<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Operation of cooperation company info.
 * created 2011-12-21
 * @author Qin.Chong(Qin.Aeon@gmail.com)
 */
class Controller_Admin_Site_Cooperation extends Controller_Admin_Site
{

    public function action_list()
    {
        $content = View::factory('admin/site/cooperation_list')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_edit()
    {
        $id = $this->request->param('id');

        if ($_POST)
        {
            $keys = array('name', 'cata', 'state', 'city', 'people', 'tele');
            foreach ($keys as $v)
            {
                if (trim($_POST[$v]) == '')
                {
                    Message::set('请确保必填项都填写完整！', 'error');
                    $this->request->redirect('/admin/site/cooperation/edit/' . $id);
                    break;
                }
            }

            $data = array();
            $keys = array_merge($keys, array('code', 'add', 'num', 'page', 'qqnum', 'msn', 'skype', 'other_link', 'other_info'));
            foreach ($keys as $key)
            {
                $data[$key] = htmlspecialchars(trim($_POST[$key]));
            }
            $data['site_id'] = $this->site_id;
            $affected_rows = DB::update('cooperations')
                ->set($data)
                ->where('id', '=', $id)
                ->execute();
            if ($affected_rows)
            {
                Message::set('修改成功', 'success');
                $this->request->redirect('/admin/site/cooperation/edit/' . $id);
            }
        }

        $content_data['content'] = DB::select()->from('cooperations')
            ->where('id', '=', $id)
            ->execute('slave')
            ->current();

        $content = View::factory('admin/site/cooperation_edit', $content_data)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_delete()
    {
        $id = $this->request->param('id');
        $res = DB::delete('cooperations')->where('id', '=', $id)->execute();
        if ($res)
        {
            echo 'success';
        }
        else
        {
            echo 'Data isn\'t exist.';
        }
    }

    public function action_data()
    {
        $type = $this->request->param('id');

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
            foreach ($filters->rules as $item)
            {
                if (in_array($item->field, array('cata', 'state', 'city', 'name', 'people', 'tele')))
                {
                    $filter_sql .= " AND " . $item->field . " LIKE '%" . $item->data . "%'";
                }
                else
                {
                    //TODO add filter items
                    $filter_sql .= " AND " . $item->field . "='" . $item->data . "'";
                }
            }
        }
        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;
        if ($totalrows)
            $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM cooperations WHERE site_id=' . $this->site_id . $filter_sql)->execute('slave')->current();

        $count = $result['count(id)'];
        $limit = $limit ? $limit : 1;
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM cooperations WHERE site_id=' . $this->site_id . ' ' .
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
                $data['cata'],
                $data['state'],
                $data['city'],
                $data['people'],
                $data['tele']
            );

            $i++;
        }
        echo json_encode($response);
    }

}

?>
