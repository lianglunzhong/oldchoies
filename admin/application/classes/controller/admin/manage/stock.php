<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Manage_Stock extends Controller_Admin_Site
{

    public function action_list()
    {
        $catalogs = ORM::factory('catalog')->find_all();
        $factories = ORM::factory('factory')->find_all();
        $content = View::factory('admin/manage/stock/list')->set('catalogs', $catalogs)->set('factories', $factories)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_logs()
    {
//        $logs = ORM::factory('manage_product_stock_log')->find_all();
//        $content = View::factory('admin/manage/stock/logs')->set('logs', $logs)->render();
        $content = View::factory('admin/manage/stock/logs_1')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_update_log_data()
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
                if ($item->field == 'product_id')
                {
                    $product_id = Product::get_productId_by_sku($item->data);
                    $filter_sql .= $and . $item->field . "='" . $product_id . "'";
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
                elseif ($item->field == 'factory_id')
                {
                    $factory = ORM::factory('factory')->where('name', '=', $item->data)->find();
                    $filter_sql .= $and . $item->field . "='" . $factory->id . "'";
                }
                elseif ($item->field == 'user_id')
                {
                    $user_id = DB::select('id')->from('auth_user')->where('name', '=', $item->data)->execute('slave')->current();
                    $filter_sql .= $and . $item->field . "='" . $user_id['id'] . "'";
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

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM manage_product_stock_logs ' . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM manage_product_stock_logs ' .
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
                date('Y-m-d H:i:s', $data['created']),
                Product::instance($data['product_id'])->get('sku'),
                Catalog::instance(Product::instance($data['product_id'])->default_catalog())->get('name'),
                ORM::factory('factory', $data['factory_id'])->name,
                $data['quantity'],
                $data['amount'],
                $data['status'],
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
            $product = ORM::factory('product')->where('sku', '=', $_POST['sku'])->find();
            if (!$product->loaded())
            {
                Message::set('产品不存在');
                $this->request->redirect('/manage/stock/add');
            }
            $factory = ORM::factory('factory')->where('name', '=', $_POST['factory'])->find();
            if (!$factory->loaded())
            {
                Message::set('供货商不存在');
                $this->request->redirect('/manage/stock/add');
            }

            $data = array(
                'product_id' => $product->id,
                'factory_id' => $factory->id,
                'user_id'    => Session::instance()->get('user_id'),
                'quantity'   => $_POST['quantity'],
                'amount'     => $_POST['amount'],
                'status'     => $_POST['status'],
                'created'    => time(),
                'updated'    => time(),
            );
            $log = ORM::factory('manage_product_stock_log');
            $log->values($data);
            $log->save();
            Message::set('添加采购记录成功');
            $this->request->redirect('/manage/stock/logs');
        }
        $content = View::factory('admin/manage/stock/add')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_edit()
    {
        $id = $this->request->param('id');
        $log = ORM::factory('manage_product_stock_log', $id);
        if ($_POST)
        {
            $product = ORM::factory('product')->where('sku', '=', $_POST['sku'])->find();
            if (!$product->loaded())
            {
                Message::set('产品不存在');
                $this->request->redirect('/manage/stock/edit/' . $id);
            }
            $factory = ORM::factory('factory')->where('name', '=', $_POST['factory'])->find();
            if (!$factory->loaded())
            {
                Message::set('供货商不存在');
                $this->request->redirect('/manage/stock/edit/' . $id);
            }

            $data = array(
                'product_id' => $product->id,
                'factory_id' => $factory->id,
                'user_id'    => Session::instance()->get('user_id'),
                'quantity'   => $_POST['quantity'],
                'amount'     => $_POST['amount'],
                'status'     => $_POST['status'],
                'updated'    => time(),
            );
            $log->values($data);
            $log->save();
            Message::set('编辑采购记录成功');
            $this->request->redirect('/manage/stock/logs');
        }
        $content = View::factory('admin/manage/stock/edit')->set('log', $log)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_delete()
    {
        $id = $this->request->param('id');
        $log = ORM::factory('manage_product_stock_log', $id);
        if ($log->loaded())
        {
            $log->delete();
            Message::set('记录删除成功');
            $this->request->redirect('/manage/stock/logs');
        }
        else
        {
            Message::set('记录不存在');
            $this->request->redirect('/manage/stock/logs');
        }
    }

}

