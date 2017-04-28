<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Manage_Factory extends Controller_Admin_Site
{

    public function action_list()
    {
//        $factories = ORM::factory('factory')->order_by('id', 'DESC')->find_all();
//        $content = View::factory('admin/manage/factory/list')->set('factories', $factories)->render();
        $content = View::factory('admin/manage/factory/list_1')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_data()
    {
        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";

        if ($filters)
        {
            $key = 0;
            $and = " WHERE ";
            foreach ($filters->rules as $item)
            {
                if ($key)
                    $and = " AND ";
                if ($item->field == 'user_id')
                {
                    $user_id = DB::select('id')->from('auth_user')->where('name', '=', $item->data)->execute('slave')->current();
                    $filter_sql .= $and . $item->field . "='" . $user_id['id'] . "'";
                }
                elseif ($item->field == 'created')
                {
                    $date = explode(' to ', $item->data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $filter_sql .= $and . $item->field . " between " . $from . " and " . $to;
                }
                else
                {
                    $filter_sql .= $and . $item->field . "='" . $item->data . "'";
                }
                $key++;
            }
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM factories ' . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM factories ' .
                        $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach ($result as $data)
        {
            $response['rows'][$i]['id'] = $data['id'];
            $response['rows'][$i]['cell'] = array(
                $data['id'],
                $data['name'],
                $data['url'],
                $data['mobile'],
                $data['aliwangwang'],
                date('Y-m-d H:i:s', $data['created']),
                User::instance($data['user_id'])->get('name')
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_add()
    {
        if ($_POST)
        {
            $if_factory = ORM::factory('factory')->where('name', '=', $_POST['name'])->find();
            if ($if_factory->loaded())
            {
                Message::set('供货商已存在');
                $this->request->redirect('/manage/factory/list');
            }
            $data = array(
                'name'        => $_POST['name'],
                'url'         => $_POST['url'],
                'mobile'      => $_POST['mobile'],
                'aliwangwang' => $_POST['aliwangwang'],
                'user_id'     => Session::instance()->get('user_id'),
                'created'     => time(),
            );
            $factory = ORM::factory('factory');
            $factory->values($data);
            $factory->save();
            Message::set('供货商添加成功');
            $this->request->redirect('/manage/factory/list');
        }
        $content = View::factory('admin/manage/factory/add')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_edit()
    {
        $id = $this->request->param('id');
        $factory = ORM::factory('factory', $id);
        if ($_POST)
        {
            $if_factory = ORM::factory('factory')->where('name', '=', $_POST['name'])->where('id', '<>', $id)->find();
            if ($if_factory->loaded())
            {
                Message::set('供货商已存在');
                $this->request->redirect('/manage/factory/list');
            }
            $data = array(
                'name'        => $_POST['name'],
                'url'         => $_POST['url'],
                'mobile'      => $_POST['mobile'],
                'aliwangwang' => $_POST['aliwangwang'],
                'user_id'     => Session::instance()->get('user_id'),
                'updated'     => time(),
            );
            $factory->values($data);
            $factory->save();
            Message::set('供货商编辑成功');
            $this->request->redirect('/manage/factory/list');
        }
        $content = View::factory('admin/manage/factory/edit')->set('factory', $factory)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_delete()
    {
        $id = $this->request->param('id');
        $factory = ORM::factory('factory', $id);
        if ($factory->loaded())
        {
            $factory->delete();
            Message::Set('供货商删除成功');
            $this->request->redirect('/manage/factory/list');
        }
        else
        {
            Message::Set('供货商不存在');
            $this->request->redirect('/manage/factory/list');
        }
    }

    public function action_import()
    {

        if (!isset($_FILES) OR ($_FILES["file"]["type"] != "application/vnd.ms-excel" AND $_FILES["file"]["type"] != "text/csv" AND $_FILES["file"]["type"] != "text/comma-separated-values"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $import = array();
        $head = array();
        while ($data = fgetcsv($handle))
        {
            foreach ($data as $key => $val)
            {
                $data[$key] = Security::xss_clean(iconv('gbk', 'utf-8', $val));
            }

            if ($row == 1)
            {
                foreach ($data as $val)
                {
                    $head[] = strtolower(trim($val));
                }
            }
            else
            {
                $attribute = array();
                foreach ($data as $key => $value)
                {
                    $attribute[$head[$key]] = $value;
                }
                $import[] = $attribute;
            }
            $row++;
        }
//                print_r($import);exit;
        $amount = 0;
        $reduplicate = 0;
        $success = '';
        foreach ($import as $value)
        {
            $insert = $value;
            $insert['user_id'] = Session::instance()->get('user_id');
            $insert['created'] = time();
            $isset = DB::select('id')->from('factories')->where('name', '=', $insert['name'])->execute('slave')->current();
            if($isset['id'])
            {
                $reduplicate ++;
                continue;
            }
            $result = DB::insert('factories', array_keys($insert))->values($insert)->execute();
            if($result)
            {
                $amount ++;
                $success.= $insert['name'] . '<br>';
            }
        }
        echo $amount . ' factories import successfully:<br>';
        echo $success;
        echo '<span style="color:red;">' . $reduplicate . ' celebrities reduplicate</span><br>';
    }

}

