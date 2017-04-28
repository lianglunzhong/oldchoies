<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Manage_Celebrity extends Controller_Admin_Site
{

    public function action_list()
    {
//        $celebrities = ORM::factory('celebrity')->order_by('id', 'DESC')->find_all();
//        $content = View::factory('admin/manage/celebrity/list')->set('celebrities', $celebrities)->render();
        $content = View::factory('admin/manage/celebrity/list_1')->render();
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
                if ($item->field == 'user')
                {
                    $user_id = DB::select('id')->from('auth_user')->where('name', '=', $item->data)->execute('slave')->current();
                    $filter_sql .= $and . "user_id='" . $user_id['id'] . "'";
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

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM celebrities ' . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM celebrities ' .
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
                $data['user_id'],
                $data['name'],
                $data['email'],
                $data['contact'],
                $data['level'],
                $data['points'],
                $data['blog_url'],
                $data['blog_alexa'],
                $data['lookbook_url'],
                $data['facebook_url'],
                $data['flow'],
                User::instance($data['user_id'])->get('name')
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_add()
    {
        if($_POST)
        {
            // todo 红人唯一性判断
            $data = $_POST;
            $data['user_id'] = Session::instance()->get('user_id');
            $data['created'] = time();
            $data['updated'] = time();
            $celebrity = ORM::factory('celebrity');
            $celebrity->values($data);
            $celebrity->save();
            Message::set('红人添加成功');
            $this->request->redirect('/manage/celebrity/add');
        }
        $content = View::factory('admin/manage/celebrity/add')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_edit()
    {
        $id = $this->request->param('id');
        $celebrity = ORM::factory('celebrity', $id);
        if($_POST)
        {
            // todo 红人唯一性判断
            $data = $_POST;
            $data['user_id'] = Session::instance()->get('user_id');
            $data['updated'] = time();
            $celebrity->values($data);
            $celebrity->save();
            Message::set('红人编辑成功');
            $this->request->redirect('/manage/celebrity/edit/'.$id);
        }
        $content = View::factory('admin/manage/celebrity/edit')->set('celebrity', $celebrity)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_delete()
    {
        $id = $this->request->param('id');
        $celebrity = ORM::factory('celebrity', $id);
        if($celebrity->loaded())
        {
            $celebrity->delete();
            Message::set('红人删除成功');
            $this->request->redirect('/manage/celebrity/list');
        }
        else
        {
            Message::set('红人不存在');
            $this->request->redirect('/manage/celebrity/list');
        }
    }

    public function action_activities()
    {
        $id = $this->request->param('id');
        if($id)
        {
            $activities = ORM::factory('celebrity_log')->where('celebrity_id', '=', $id)->order_by('id', 'DESC')->find_all();
            $content = View::factory('admin/manage/celebrity/activity')->set('activities', $activities)->render();
            $this->request->response = View::factory('admin/template')->set('content', $content)->render();
        }
        else
        {
            $content = View::factory('admin/manage/celebrity/activity_1')->render();
            $this->request->response = View::factory('admin/template')->set('content', $content)->render();
        }
    }
    
    public function action_activities_data()
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
                    $filter_sql .= $and . "user_id='" . $user_id['id'] . "'";
                }
                elseif($item->field == 'created')
				{
					$date = explode(' to ', $item->data);
					$count = count($date);
					$from = strtotime($date[0]);
					if($count == 1)
					{
						$to = strtotime($date[0].' +1 day -1 second');
					}
					else
					{
						$to = strtotime($date[1].' +1 day -1 second');
					}
					$filter_sql .= $and . $item->field." between ".$from." and ".$to;
				}
                elseif($item->field == 'name')
                {
                    $celebrity = ORM::factory('celebrity')->where('name', '=', $item->data)->find();
                    $filter_sql .= $and . "celebrity_id='" . $celebrity->id . "'";
                }
                elseif($item->field == 'email')
                {
                    $celebrity = ORM::factory('celebrity')->where('email', '=', $item->data)->find();
                    $filter_sql .= $and . "celebrity_id='" . $celebrity->id . "'";
                }
                elseif($item->field == 'product_id')
                {
                    $product_id = Product::get_productId_by_sku($item->data);
                    $filter_sql .= $and . "product_id like '%" . $product_id . "%'";
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

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM celebrity_logs ' . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM celebrity_logs ' .
                        $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach ($result as $data)
        {
            $productIds = explode(',', $data['product_id']);
            $productArr = array();
            $products = '';
            foreach($productIds as $pid)
            {
                $product = ORM::factory('product', $pid);
                if($product->loaded())
                {
                    $productArr[] = $product->sku;
                }
            }
            $products = implode(',', $productArr);
            $response['rows'][$i]['id'] = $data['id'];
            $response['rows'][$i]['cell'] = array(
                $data['id'],
                date('Y-m-d H:i:s', $data['created']),
                ORM::factory('celebrity', $data['celebrity_id'])->name,
                ORM::factory('celebrity', $data['celebrity_id'])->email,
                $data['points'],
                $data['points_date'],
                $products,
                Catalog::instance(Product::instance($data['product_id'])->default_catalog())->get('name'),
                $data['ordernum'],
                $data['shipping_date'],
                $data['delivery_date'],
                $data['spread_url'],
                $data['spread_date'],
                $data['spread_flow'],
                User::instance($data['user_id'])->get('name')
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_add_activity()
    {
        if($_POST)
        {
            $celebrity = ORM::factory('celebrity', $_POST['celebrity_id']);
            if( ! $celebrity->loaded())
            {
                Message::set('红人不存在');
                $this->request->redirect('/manage/celebrity/add_activity');
            }
            $productArr = explode(',', $_POST['sku']);
            $products = '';
            foreach($productArr as $key => $sku)
            {
                $product = ORM::factory('product')->where('sku', '=', $sku)->find();
                if($product->loaded())
                {
                    $productArr[$key] = $product->id;
                }
                else
                {
                    unset($productArr[$key]);
                }
            }
            if(!empty($productArr))
            {
                $products = implode(',', $productArr);
            }
            else
            {
                Message::set('产品不存在');
                $this->request->redirect('/manage/celebrity/add_activity');
            }
            $data = $_POST;
            $data['user_id'] = Session::instance()->get('user_id');
            $data['product_id'] = $products;
            $data['created'] = time();
            $data['updated'] = time();
            $celebrity_log = ORM::factory('celebrity_log');
            $celebrity_log->values($data);
            $celebrity_log->save();

            $celebrity->points += $data['points'];
            $celebrity->flow += $data['spread_flow'];
            $celebrity->save();
            Message::set('红人活动记录添加成功');
            $this->request->redirect('/manage/celebrity/add_activity');
        }
        $content = View::factory('admin/manage/celebrity/add_activity')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_edit_activity()
    {
        $id = $this->request->param('id');
        $activity = ORM::factory('celebrity_log', $id);
        if($_POST)
        {
            $celebrity = ORM::factory('celebrity', $_POST['celebrity_id']);
            if( ! $celebrity->loaded())
            {
                Message::set('红人不存在');
                $this->request->redirect('/manage/celebrity/add_activity');
            }
            $productArr = explode(',', $_POST['sku']);
            $products = '';
            foreach($productArr as $key => $sku)
            {
                $product = ORM::factory('product')->where('sku', '=', $sku)->find();
                if($product->loaded())
                {
                    $productArr[$key] = $product->id;
                }
                else
                {
                    unset($productArr[$key]);
                }
            }
            if(!empty($productArr))
            {
                $products = implode(',', $productArr);
            }
            else
            {
                Message::set('产品不存在');
                $this->request->redirect('/manage/celebrity/add_activity');
            }

            if($activity->points != $_POST['points'])
            {
                $celebrity->points += $_POST['points'] - $activity->points;
                $celebrity->save();
            }

            if($activity->spread_flow != $_POST['spread_flow'])
            {
                $celebrity->flow += $_POST['spread_flow'] - $activity->spread_flow;
                $celebrity->save();
            }

            $data = $_POST;
            $data['user_id'] = Session::instance()->get('user_id');
            $data['product_id'] = $products;
            $data['updated'] = time();
            $activity->values($data);
            $activity->save();
            Message::set('活动编辑成功');
            $this->request->redirect('/manage/celebrity/edit_activity/'.$id);
        }
        $content = View::factory('admin/manage/celebrity/edit_activity')->set('activity', $activity)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_delete_activity()
    {
        $id = $this->request->param('id');
        $activity = ORM::factory('celebrity_log', $id);
        if($activity->loaded())
        {
            $celebrity = ORM::factory('celebrity', $activity->celebrity_id);
            $celebrity->points -= $activity->points;
            $celebrity->flow -= $activity->spread_flow;
            $celebrity->save();
            $activity->delete();
            Message::set('活动删除成功');
            $this->request->redirect('/manage/celebrity/activities');
        }
        else
        {
            Message::set('活动不存在');
            $this->request->redirect('/manage/celebrity/activities');
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
            if(!$data[0] || !$data[1])
                continue;
            foreach ($data as $key => $val)
            {
                $val = str_replace('', "\n", $val);
                $data[$key] = trim(Security::xss_clean(iconv('gbk', 'utf-8', $val)));
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
            $isset = DB::select('id')->from('celebrities')->where('name', '=', $insert['name'])->execute('slave')->current();
            if($isset['id'])
            {
                $reduplicate ++;
                continue;
            }
            $result = DB::insert('celebrities', array_keys($insert))->values($insert)->execute();
            if($result)
            {
                $amount ++;
                $success.= $insert['name'] . '<br>';
            }
        }
        echo $amount . ' celebrities import successfully:<br>';
        echo $success;
        echo '<span style="color:red;">' . $reduplicate . ' celebrities reduplicate</span><br>';
    }

}

