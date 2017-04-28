<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Orderproduct extends Controller_Admin_Site
{

    public function action_list()
    {
        if (Arr::get($_POST, 'start', 0))
        {
            $date = strtotime(Arr::get($_POST, 'start', 0));
            $date += 28800;

            // 添加更新结束时间
            $date_end = Arr::get($_POST, 'end', 0);

            if ($date_end)
            {
                $date_end = strtotime($date_end);
                $date_end += 28800;
            }
            else
            {
                $date_end = $date + 86400;
            }
            $this->request->redirect('/admin/site/orderproduct/list?history=' . $date . '-' . $date_end);
        }
        $content = View::factory('admin/site/order/product')->render();
        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
    }

    public function action_data1()
    {
        $in_catalog = false;

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

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "";
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                if (in_array($item->field, array('name', 'sku')))
                {
                    $filter_sql .= " AND products." . $item->field . " LIKE '%" . $item->data . "%'";
                }
                elseif ($item->field == 'admin')
                {
                    $user = ORM::factory('user')->where('name', '=', $item->data)->find();
                    $filter_sql .= " AND products." . $item->field . "='" . $user->id . "'";
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
                    $filter_sql .= " AND products." . $item->field . " between " . $from . " and " . $to;
                }
                else
                {
                    //TODO add filter items
                    $filter_sql .= " AND products." . $item->field . "='" . $item->data . "'";
                }
            }
        }
        $daterange = '';
        if ($_GET['history'])
        {
            $history = $_GET['history'];
            $date = explode('-', $history);
            $daterange = ' AND orders.created >= ' . $date[0] . ' AND orders.created < ' . $date[1];
        }
        $count = DB::query(Database::SELECT, 'SELECT count(DISTINCT order_items.sku) AS count FROM order_items LEFT JOIN orders ON order_items.order_id=orders.id RIGHT JOIN products ON order_items.product_id=products.id WHERE orders.payment_status = "verify_pass"' . $daterange . $filter_sql)->execute('slave')->get('count');
        $total_pages = 0;
        $limit = 20;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(Database::SELECT, 'SELECT DISTINCT products.id,products.sku,products.set_id,products.price,products.admin,products.created,products.clicks,products.add_times FROM order_items LEFT JOIN orders ON order_items.order_id=orders.id RIGHT JOIN products ON order_items.product_id=products.id WHERE orders.payment_status = "verify_pass"' . $daterange . $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave')->as_array();

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach ($result as $data)
        {
            $set = Set::instance($data['set_id'])->get('name');
            $admin = User::instance($admin)->get('name');
            $sales = DB::query(Database::SELECT, 'SELECT COUNT(order_items.id) AS count FROM order_items LEFT JOIN orders ON order_items.order_id=orders.id WHERE orders.payment_status="verify_pass" AND order_items.product_id=' . $data['id'])->execute('slave')->get('count');
            $celebrities = DB::query(Database::SELECT, 'SELECT celebrits.id AS cele_id FROM orders LEFT JOIN order_items ON order_items.order_id=orders.id RIGHT JOIN celebrits ON celebrits.email=orders.email WHERE order_items.product_id=' . $data['id'])->execute('slave')->as_array();
            $cele_sales = count($celebrities);
            $cele_str = '';
            foreach ($celebrities as $cele)
            {
                $cele_str .= $cele['cele_id'] . ',';
            }
            $response['rows'][$k]['id'] = $data['id'];
            $response['rows'][$k]['cell'] = array(
                $data['id'],
                $data['sku'],
                $set,
                $data['price'],
                $admin,
                date('Y-m-d', $data['created']),
                $data['clicks'],
                $data['add_times'],
                $sales,
                $cele_sales,
                $cele_str
            );
            $k++;
        }
//                print_r($response);exit;
        echo json_encode($response);
    }

    public function action_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;
        if (!$sord)
            $sord = 'asc';

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "";
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                // TODO optimize name filter.
                if (in_array($item->field, array('name', 'sku')))
                {
                    $filter_sql .= " AND products." . $item->field . " LIKE '%" . $item->data . "%'";
                }
                elseif ($item->field == 'admin')
                {
                    $user = ORM::factory('user')->where('name', '=', $item->data)->find();
                    $filter_sql .= " AND products." . $item->field . "='" . $user->id . "'";
                }
                elseif ($item->field == 'picker')
                {
                    $user2 = ORM::factory('user')->where('name', '=', $item->data)->find();
                    $filter_sql .= " AND products.offline_picker='" . $user2->id . "'";
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
                    $filter_sql .= " AND products." . $item->field . " between " . $from . " and " . $to;
                }
                else
                {
                    //TODO add filter items
                    $filter_sql .= " AND products." . $item->field . "='" . $item->data . "'";
                }
            }
        }

        $daterange = '';
        if ($_GET['history'])
        {
            $history = $_GET['history'];
            $date = explode('-', $history);
            $daterange = ' AND orders.created >= ' . $date[0] . ' AND orders.created < ' . $date[1];
        }

        $count = DB::query(Database::SELECT, 'SELECT count(DISTINCT order_items.sku) AS count FROM order_items LEFT JOIN orders ON order_items.order_id=orders.id RIGHT JOIN products ON order_items.product_id=products.id WHERE orders.payment_status = "verify_pass"' . $daterange . $filter_sql)->execute('slave')->get('count');
        $total_pages = 0;
        $limit = 20;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(Database::SELECT, 'SELECT DISTINCT products.id,products.sku,products.set_id,products.price,products.admin,products.created,products.clicks,products.add_times,products.taobao_url,products.source,products.offline_picker FROM order_items LEFT JOIN orders ON order_items.order_id=orders.id RIGHT JOIN products ON order_items.product_id=products.id WHERE orders.payment_status = "verify_pass"'
                    . $daterange . $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)
                ->execute('slave')->as_array();
        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $k = 0;
        foreach ($result as $data)
        {
            $set = Set::instance($data['set_id'])->get('name');
            $admin = User::instance($data['admin'])->get('name');
            $picker = User::instance($data['offline_picker'])->get('name');
            $sales = DB::query(Database::SELECT, 'SELECT COUNT(order_items.id) AS count FROM order_items LEFT JOIN orders ON order_items.order_id=orders.id WHERE orders.payment_status="verify_pass" AND order_items.product_id=' . $data['id'] . $daterange)->execute('slave')->get('count');
            $celebrities = DB::query(Database::SELECT, 'SELECT celebrits.id AS cele_id FROM orders LEFT JOIN order_items ON order_items.order_id=orders.id RIGHT JOIN celebrits ON celebrits.email=orders.email WHERE order_items.product_id=' . $data['id'] . $daterange)->execute('slave')->as_array();
            $cele_sales = count($celebrities);
            $cele_str = '';
            $purchase = '线下';
            if (strpos($data['taobao_url'], 'http://') !== false)
                $purchase = '线上';
            foreach ($celebrities as $cele)
            {
                $cele_str .= $cele['cele_id'] . ',';
            }
            $response['rows'][$k]['id'] = $data['id'];
            $response['rows'][$k]['cell'] = array(
                $data['id'],
                $data['sku'],
                $set,
                $data['price'],
                $admin,
                $picker,
                $data['source'],
                date('Y-m-d', $data['created']),
                $data['clicks'],
                $data['add_times'],
                $sales,
                $purchase,
                $cele_sales,
                $cele_str
            );
            $k++;
        }
        echo json_encode($response);
    }

    public function action_export()
    {
        $daterange = '';
        $file_name = 'order_products.csv';
        if (Arr::get($_POST, 'start', 0))
        {
            $date = strtotime(Arr::get($_POST, 'start', 0));
            $date += 28800;

            // 添加更新结束时间
            $date_end = Arr::get($_POST, 'end', 0);

            if ($date_end)
            {
                $file_name = "order_products-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
                $date_end = strtotime($date_end);
                $date_end += 28800;
            }
            else
            {
                $file_name = "order_products-" . date('Y-m-d', $date) . ".csv";
                $date_end = $date + 86400;
            }
            $daterange = ' AND orders.created >= ' . $date . ' AND orders.created < ' . $date_end;
        }
        $result = DB::query(Database::SELECT, 'SELECT DISTINCT products.id,products.sku,products.set_id,products.price,products.admin,products.created,products.clicks,products.add_times,products.taobao_url FROM order_items LEFT JOIN orders ON order_items.order_id=orders.id RIGHT JOIN products ON order_items.product_id=products.id WHERE orders.payment_status = "verify_pass"'
                    . $daterange)
                ->execute('slave')->as_array();

        header("Content-type:text/csv");
        //header('Content-Disposition: attachment; filename="orders-'.date('Y-m-d', $date).'.csv"');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        echo "\xEF\xBB\xBF" . "Product Id,SKU,SET,Price,Admin,Created,Clicks,Add Cart Times,Sales,Purchase,Celebrity Sales,Celebrity Display\n";
        foreach ($result as $data)
        {
            $set = Set::instance($data['set_id'])->get('name');
            $admin = User::instance($data['admin'])->get('name');
            $sales = DB::query(Database::SELECT, 'SELECT COUNT(order_items.id) AS count FROM order_items LEFT JOIN orders ON order_items.order_id=orders.id WHERE orders.payment_status="verify_pass" AND order_items.product_id=' . $data['id'] . $daterange)->execute('slave')->get('count');
            $celebrities = DB::query(Database::SELECT, 'SELECT celebrits.id AS cele_id FROM orders LEFT JOIN order_items ON order_items.order_id=orders.id RIGHT JOIN celebrits ON celebrits.email=orders.email WHERE order_items.product_id=' . $data['id'] . $daterange)->execute('slave')->as_array();
            $cele_sales = count($celebrities);
            $cele_str = '';
            $purchase = '线下';
            if (strpos($data['taobao_url'], 'http://') !== false)
                $purchase = '线上';
            foreach ($celebrities as $cele)
            {
                $cele_str .= $cele['cele_id'] . ';';
            }

            echo $data['id'] . ',';
            echo $data['sku'] . ',';
            echo $set . ',';
            echo $data['price'] . ',';
            echo $admin . ',';
            echo date('Y-m-d', $data['created']) . ',';
            echo $data['clicks'] . ',';
            echo $data['add_times'] . ',';
            echo $sales . ',';
            echo $purchase . ',';
            echo $cele_sales . ',';
            echo $cele_str;
            echo "\n";
        }
    }

    public function action_exportall()
    {
        $daterange = '';
        $file_name = 'order_products.csv';
        if (Arr::get($_POST, 'start', 0))
        {
            $date = strtotime(Arr::get($_POST, 'start', 0));
            $date += 28800;

            // 添加更新结束时间
            $date_end = Arr::get($_POST, 'end', 0);

            if ($date_end)
            {
                $file_name = "order_products-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
                $date_end = strtotime($date_end);
                $date_end += 28800;
            }
            else
            {
                $file_name = "order_products-" . date('Y-m-d', $date) . ".csv";
                $date_end = $date + 86400;
            }
            $daterange = ' AND orders.created >= ' . $date . ' AND orders.created < ' . $date_end;
        }
        $result = DB::query(Database::SELECT, 'SELECT DISTINCT products.id,products.sku,products.created FROM order_items LEFT JOIN orders ON order_items.order_id=orders.id RIGHT JOIN products ON order_items.product_id=products.id WHERE orders.payment_status = "verify_pass" and products.visibility = 1 and products.status = 1'
                    . $daterange)
                ->execute('slave')->as_array();

        header("Content-type:text/csv");
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        echo "\xEF\xBB\xBF" . "SKU,Created,Sales\n";
        foreach ($result as $data)
        {
            $sales = DB::query(Database::SELECT, 'SELECT COUNT(order_items.id) AS count FROM order_items LEFT JOIN orders ON order_items.order_id=orders.id WHERE orders.payment_status="verify_pass" AND order_items.product_id=' . $data['id'] . $daterange)->execute('slave')->get('count');

            echo $data['sku'] . ',';
            echo date('Y-m-d', $data['created']) . ',';
            echo $sales . ',';
            echo "\n";
        }
    }

    public function action_vip()
    {
        $content = View::factory('admin/site/order/vip')->render();
        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
    }

    public function action_vip_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());
        $activesql = isset($_GET['cl']) ? ' AND O.`is_active`=0' : ' AND O.`is_active`=1';
        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;
//                $limit = 20;
//                $sord = '';

        $filter_sql = "1";
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                if ($item->field == 'created' || $item->field == 'shipping_date' || $item->field == 'verify_date')
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
                    $_filter_sql[] = 'O.' . $item->field . " between " . $from . " and " . $to;
                }
                else if ($item->field == 'ordernum')
                {
                    $activesql = '';
                    $_filter_sql[] = 'O.' . $item->field . "='" . $item->data . "'";
                }
                else if ($item->field == 'admin')
                {
                    $user_id = DB::select('id')->from('auth_user')->where('name', '=', $item->data)->execute('slave')->get('id');
                    $_filter_sql[] = 'O.email IN (SELECT email FROM celebrits WHERE admin = ' . $user_id . ')';
                }
                else if($item->field == 'is_vip')
                {
                    $_filter_sql[] = 'C.' . $item->field . "='" . $item->data . "'";
                }
                else
                {
                    $_filter_sql[] = 'O' . $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }
        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(O.`id`) AS num FROM `orders_order` O LEFT JOIN customers C ON O.customer_id = C.id WHERE C.is_vip >= 1 AND O.is_active=1 AND O.site_id=' . $this->site_id . $activesql . ' AND '
                . $filter_sql)->execute('slave');
        $count = $result[0]['num'];
        $total_pages = 0;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT O.id,O.ordernum,O.email,O.created,O.verify_date,O.shipping_date,O.payment_status,O.shipping_status,O.refund_status,O.currency,O.amount,O.payment_method,O.deliver_time,O.lang,C.firstname,C.lastname,C.is_vip 
            FROM `orders_order` O LEFT JOIN customers C ON O.customer_id = C.id WHERE C.is_vip >= 1 AND O.is_active=1 AND  O.site_id=' . $this->site_id . $activesql . ' AND '
                . $filter_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $order_status = kohana::config('order_status');
        foreach ($result as $value)
        {
            $namecount = '';

            $admin_id = DB::select('admin')->from('celebrities_celebrits')->where('email', '=', $value['email'])->execute('slave')->get('admin');

            if ($admin_id)
                $cele_admin = User::instance($admin_id)->get('name');
            else
                $cele_admin = '';

            $response['rows'][] = array(
                'id' => $value['id'],
                'cell' => array(
                    $value['id'],
                    $value['ordernum'], 
                    $value['email'],
                    $value['firstname'] . ' ' . $value['lastname'],
                    $value['is_vip'],
                    date('Y-m-d H:i', $value['created']),
                    $value['verify_date'] ? date('Y-m-d H:i', $value['verify_date']) : Null,
                    $value['shipping_date'] ? date('Y-m-d', $value['shipping_date']) : '',
                    $value['payment_status'],
                    $value['shipping_status'],
                    $value['refund_status'],
                    $value['currency'],
                    $value['amount'],
                    $cele_admin,
                    $value['payment_method'],
                    $value['deliver_time'] ? date('Y-m-d', $value['deliver_time']) : '',
                    $value['lang'],
                )
            );
        }
        echo json_encode($response);
    }
	
	
	/*
	 * 导出vip订单
	 * 2016.04.12
	 */
	public function action_export_vipdata()
	{
		if($_POST){
			$sql=array();
			$start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);
			
			if ($start && $end)
            {
                $sql[] .= 'verify_date >= ' . strtotime($start);
				$sql[] .= 'verify_date < ' . strtotime($end);
            }
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="vip_date.csv"');
			echo "ordernum,email,name,created,verify_date,payment_status,currency,amount,admin,payment_method,lang\n";
			$result = DB::query(DATABASE::SELECT, 'SELECT O.id,O.ordernum,C.firstname,C.lastname,O.email,O.created,O.verify_date,O.shipping_date,O.payment_status,O.shipping_status,O.refund_status,O.currency,O.amount,O.payment_method,O.deliver_time,O.lang,C.firstname,C.lastname,C.vip_level 
            FROM `orders_order` O LEFT JOIN customers C ON O.customer_id = C.id WHERE C.vip_level > 1 AND O.is_active=1 AND '.implode(' AND ',$sql).' ')->execute('slave')->as_array();
			foreach ($result as $value)
			{
				$namecount = '';

				$admin_id = DB::select('admin')->from('celebrities_celebrits')->where('email', '=', $value['email'])->execute('slave')->get('admin');

				if ($admin_id)
					$cele_admin = User::instance($admin_id)->get('name');
				else
					$cele_admin = '';

				//开始导表
				echo $value['ordernum'], ',';
				echo $value['email'], ',';
				echo $value['firstname'] . ' ' . $value['lastname'],',';
				echo date('Y-m-d', $value['created']), ',';
				echo date('Y-m-d', $value['verify_date']), ',';
				echo $value['payment_status'], ',';
				echo $value['currency'], ',';
				echo $value['amount'], ',';
				echo $cele_admin,',';
				echo $value['payment_method'], ',';
				echo $value['lang'], ',';
				echo ',' , PHP_EOL;;
			}
		}
	}
	

    public function action_message()
    {
        if($_POST)
        {
            $message_id = Arr::get($_POST, 'message_id', '');

            if($message_id)
            {
                $set_read = Arr::get($_POST, 'set_read', '');
                if($set_read == 'on')
                {
                    DB::update(orders_ordermessages)->set(array('status' => 1))->where('id', '=', $message_id)->execute();
                    Message::set('Set message read success');
                }
                else
                {
                    DB::update(orders_ordermessages)->set(array('status' => 0))->where('id', '=', $message_id)->execute();
                    Message::set('Set message not read success');
                }
                $type = Arr::get($_POST, 'typ', '');
                if($type == 'ajax')
                {
                    echo json_encode('success');
                    exit;
                }
            }
        }
        $content = View::factory('admin/site/order/message_list')->render();
        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
    }

    public function action_message_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());
        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;
//                $limit = 20;
//                $sord = '';

        $filter_sql = "1";
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                if($item->field == 'created')
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
                    $_filter_sql[] = 'M.' . $item->field . " between " . $from . " and " . $to;
                }
                elseif($item->field == 'ordernum')
                {
                    $order_id = DB::select("id")->from('orders_order')->where('ordernum', '=', $item->data)->execute('slave')->get('id');
                    $_filter_sql[] = "M.order_id = '" . $order_id . "'";
                }
                else
                {
                    $_filter_sql[] = "M." . $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }
        $result = DB::query(DATABASE::SELECT, "SELECT COUNT(M.id) AS num FROM `orders_ordermessages` M LEFT JOIN `orders` O ON M.order_id = O.id WHERE M.message != '' and " . $filter_sql)->execute();
        $count = $result[0]['num'];
        $total_pages = 0;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, "SELECT M.id, O.ordernum, M.message, M.created, M.status FROM `orders_ordermessages` M LEFT JOIN `orders` O ON M.order_id = O.id WHERE M.message != '' and " . $filter_sql 
                . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute();
        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        foreach ($result as $value)
        {
            $response['rows'][] = array(
                'id' => $value['id'],
                'cell' => array(
                    $value['id'],
                    $value['ordernum'],
                    $value['message'],
                    date('Y-m-d H:i:s', $value['created']),
                    $value['status'],
                )
            );
        }
        echo json_encode($response);
    }

    public function action_message_delete($id)
    {
        if($id)
        {
            DB::delete('order_messages')->where('id', '=', $id)->execute();
            Message::set('Delete order message success');
        }
        $this->request->redirect('/admin/site/orderproduct/message');
    }

    public function action_month_statistics()
    {
        $content = View::factory('admin/site/order/month_statistics')->render();
        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
    }

    public function action_month_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());
        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;
//                $limit = 20;
//                $sord = '';

        $filter_sql = "1";
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                if(in_array($item->field, array('top_sets1', 'top_sets2', 'top_sets3', 'top_sets4', 'top_sets5')))
                {
                    $set_id = DB::select("id")->from('sets')->where('name', '=', $item->data)->execute('slave')->get('id');
                    $_filter_sql[] = "top_set LIKE '%" . $set_id . "%'";
                }
                else
                {
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }
        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(id) AS num FROM `order_month_statistics` WHERE ' . $filter_sql)->execute('slave');
        $count = $result[0]['num'];
        $total_pages = 0;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM `order_month_statistics` WHERE ' . $filter_sql 
                . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        foreach ($result as $value)
        {
            $top_sets = explode(',', $value['top_set']);
            $count_set = count($top_sets);
            if($count_set < 5)
            {
                for($i = $count_set;$i < 5;$i ++)
                {
                    $top_sets[$i] = 0;
                }
            }
            $response['rows'][] = array(
                'id' => $value['id'],
                'cell' => array(
                    $value['id'],
                    $value['country'],
                    $value['month'],
                    $value['order_qty'],
                    $value['celebrity_orders'],
                    $value['sale_orders'],
                    $value['product_qty'],
                    $value['average_qty'],
                    $value['order_amount'],
                    $value['gross_margin'],
                    Set::instance($top_sets[0])->get('name'),
                    Set::instance($top_sets[1])->get('name'),
                    Set::instance($top_sets[2])->get('name'),
                    Set::instance($top_sets[3])->get('name'),
                    Set::instance($top_sets[4])->get('name'),
                )
            );
        }
        echo json_encode($response);
    }

    public function action_month_do()
    {
        $month_get = trim(Arr::get($_GET, 'm', ''));
        $usd2rmb = 6.19;
        if($month_get)
        {
            $has = DB::select('id')->from('order_month_statistics')->where('month', '=', $month_get)->execute('slave')->as_array();
            $from = strtotime($month_get . '01');
            $to = strtotime(date('Y-m-d', $from) . ' + 1 month') - 1;
            $result = DB::query(Database::SELECT, 'SELECT O.id, O.amount, O.currency, O.rate, O.customer_id, O.shipping_country, O.order_from, I.product_id, I.quantity, I.status 
                    FROM orders O LEFT JOIN order_items I ON O.id = I.order_id WHERE O.is_active = 1 AND O.payment_status = "verify_pass" AND O.rate > 0 AND O.created BETWEEN ' . $from . ' AND ' . $to . ' ORDER BY shipping_country, id')
                ->execute('slave');
            $country_data = array();
            $product_sets = array();
            $all_data = array(
                'order_qty' => 0,
                'celebrity_orders' => 0,
                'product_qty' => 0,
                'amount' => 0,
                'product_costs' => 0,
                'shipping_prices' => 0,
            );
            $sets = DB::select('id')->from('sets')->execute('slave');
            $all_sets = array();
            foreach($sets as $s)
            {
                $all_sets[$s['id']] = 0;
            }
            $h = 0;
            foreach($result AS $order)
            {
                if($order['status'] == 'cancel')
                    continue;
                $product = DB::select('set_id', 'total_cost')->from('products_product')->where('id', '=', $order['product_id'])->execute('slave')->current();
                if(empty($product))
                    continue;
                if(!$order['shipping_country'])
                {
                    continue;
                }
                elseif(!isset($country_data[$order['shipping_country']]))
                {
                    if(isset($order_qty) AND $order_qty > 0)
                    {
                        $top_set = '';
                        arsort($product_sets);
                        $key = 0;
                        foreach($product_sets as $set => $v)
                        {
                            $top_set .= $set . ',';
                            $key ++;
                            if($key == 5)
                                break;
                        }
                        $product_costs = round($product_costs / $usd2rmb, 2);
                        $shipping_prices = round($shipping_prices / $usd2rmb, 2);
                        echo '('.$amount. '-' .$product_costs. '-' .$shipping_prices.') /'. $amount;
                        $country_data = array(
                            'month' => $month_get,
                            'country' => $last_country,
                            'order_qty' => $order_qty,
                            'celebrity_orders' => $celebrity_orders,
                            'sale_orders' => $order_qty - $celebrity_orders,
                            'product_qty' => $product_qty,
                            'average_qty' => round($product_qty / $order_qty, 1),
                            'order_amount' => round($amount / $order_qty, 2),
                            'gross_margin' => $amount > 0 ? round(($amount - $product_costs - $shipping_prices) / $amount, 4) : 0,
                            'top_set' => $top_set,
                        );
                        print_r($country_data);
                        if(isset($has[$h]))
                            DB::update('order_month_statistics')->set($country_data)->where('id', '=', $has[$h])->execute();
                        else
                            DB::insert('order_month_statistics', array_keys($country_data))->values($country_data)->execute();
                        $h ++;
                        $country_data = array();
                        $product_sets = array();
                    }
                    $country_data[$order['shipping_country']] = array();
                    $order_qty = 1;
                    $all_data['order_qty'] ++;
                    if($order['amount'] == 0 OR $order['order_from'] != '')
                    {
                        $celebrity_orders = 1;
                        $all_data['celebrity_orders'] ++;
                        $amount = 0;
                    }
                    else
                    {
                        $celebrity_orders = 0;
                        $amount = round($order['amount'] / $order['rate'], 2);
                        $all_data['amount'] += $amount;
                    }
                    $product_qty = $order['quantity'];
                    $all_data['product_qty'] += $order['quantity'];
                    if($order['amount'] > 0 AND $order['order_from'] == '')
                    {
                        $product_costs = $product['total_cost'];
                        $all_data['product_costs'] += $product['total_cost'];
                    }
                    $shipping_price = DB::select('ship_price')->from('orders_ordershipments')->where('order_id', '=', $order['id'])->execute('slave')->get('ship_price');
                    $shipping_prices = (float) $shipping_price;
                    $all_data['shipping_prices'] += (float) $shipping_price;
                    $product_sets[$product['set_id']] = 1;
                    if(isset($all_sets[$product['set_id']]))
                        $all_sets[$product['set_id']] = 1;
                    else
                        $all_sets[$product['set_id']] ++;
                }
                else
                {
                    if($order['id'] != $last_order)
                    {
                        $order_qty ++;
                        $all_data['order_qty'] ++;
                        if($order['amount'] == 0 OR $order['order_from'] != '')
                        {
                            $celebrity_orders ++;
                            $all_data['celebrity_orders'] ++;
                        }
                        else
                        {
                            $am = round($order['amount'] / $order['rate'], 2);
                            $amount += $am;
                            $all_data['amount'] += $am;
                        }
                        $shipping_price = DB::select('ship_price')->from('orders_ordershipments')->where('order_id', '=', $order['id'])->execute('slave')->get('ship_price');
                        $shipping_prices += (float) $shipping_price;
                        $all_data['shipping_prices'] += (float) $shipping_price;
                    }
                    $product_qty += $order['quantity'];
                    $all_data['product_qty'] += $order['quantity'];
                    if($order['amount'] > 0 AND $order['order_from'] == '')
                    {
                        $product_costs += $product['total_cost'];
                        $all_data['product_costs'] += $product['total_cost'];
                    }
                    if(isset($product_sets[$product['set_id']]))
                    {
                        $product_sets[$product['set_id']] ++;
                        $all_sets[$product['set_id']] ++;
                    }
                    else
                    {
                        $product_sets[$product['set_id']] = 1;
                        $all_sets[$product['set_id']] = 1;
                    }
                }
                $last_country = $order['shipping_country'];
                $last_order = $order['id'];
            }
            $top_set = '';
            arsort($product_sets);
            $key = 0;
            foreach($product_sets as $set => $v)
            {
                $top_set .= $set . ',';
                $key ++;
                if($key == 5)
                    break;
            }
            $product_costs = round($product_costs / $usd2rmb, 2);
            $shipping_prices = round($shipping_prices / $usd2rmb, 2);
            $country_data = array(
                'month' => $month_get,
                'country' => $last_country,
                'order_qty' => $order_qty,
                'celebrity_orders' => $celebrity_orders,
                'sale_orders' => $order_qty - $celebrity_orders,
                'product_qty' => $product_qty,
                'average_qty' => round($product_qty / $order_qty, 1),
                'order_amount' => round($amount / $order_qty, 2),
                'gross_margin' => $amount > 0 ? round(($amount - $product_costs - $shipping_prices) / $amount, 4) : 0,
                'top_set' => $top_set,
            );
            print_r($country_data);
            if(isset($has[$h]))
                DB::update('order_month_statistics')->set($country_data)->where('id', '=', $has[$h])->execute();
            else
                DB::insert('order_month_statistics', array_keys($country_data))->values($country_data)->execute();
            $h ++;
            print_r($all_data);
            arsort($all_sets);
            print_r($all_sets);
            $key = 0;
            foreach($all_sets as $set => $v)
            {
                $top_set .= $set . ',';
                $key ++;
                if($key == 5)
                    break;
            }
            $product_costs = round($all_data['product_costs'] / $usd2rmb, 2);
            $shipping_prices = round($all_data['shipping_prices'] / $usd2rmb, 2);
            $all_country_data = array(
                'month' => $month_get,
                'country' => 'total',
                'order_qty' => $all_data['order_qty'],
                'celebrity_orders' => $all_data['celebrity_orders'],
                'sale_orders' => $all_data['order_qty'] - $all_data['celebrity_orders'],
                'product_qty' => $all_data['product_qty'],
                'average_qty' => round($all_data['product_qty'] / $all_data['order_qty'], 1),
                'order_amount' => round($all_data['amount'] / $all_data['order_qty'], 2),
                'gross_margin' => $all_data['amount'] > 0 ? round(($all_data['amount'] - $product_costs - $shipping_prices) / $all_data['amount'], 4) : 0,
                'top_set' => $top_set,
            );
            if(isset($has[$h]))
                DB::update('order_month_statistics')->set($all_country_data)->where('id', '=', $has[$h])->execute();
            else
                DB::insert('order_month_statistics', array_keys($all_country_data))->values($all_country_data)->execute();

            echo date('Y-m-d H:i:s', $from) . '~' . date('Y-m-d H:i:s', $to);
            exit;
        }
    }

}

function compare_product_id($a, $b)
{
    if ($a['product_id'] < $b['product_id'])
        return -1;
    else if ($a['product_id'] == $b['product_id'])
        return 0;
    else
        return 1;
}

function compare_product_id1($a, $b)
{
    if ($a['product_id'] > $b['product_id'])
        return -1;
    else if ($a['product_id'] == $b['product_id'])
        return 0;
    else
        return 1;
}

function compare_sku($a, $b)
{
    if ($a['sku'] < $b['sku'])
        return -1;
    else if ($a['sku'] == $b['sku'])
        return 0;
    else
        return 1;
}

function compare_sku1($a, $b)
{
    if ($a['sku'] > $b['sku'])
        return -1;
    else if ($a['sku'] == $b['sku'])
        return 0;
    else
        return 1;
}

function compare_set($a, $b)
{
    if ($a['set'] < $b['set'])
        return -1;
    else if ($a['set'] == $b['set'])
        return 0;
    else
        return 1;
}

function compare_set1($a, $b)
{
    if ($a['set'] < $b['set'])
        return -1;
    else if ($a['set'] == $b['set'])
        return 0;
    else
        return 1;
}

function compare_quantity($a, $b)
{
    if ($a['quantity'] < $b['quantity'])
        return -1;
    else if ($a['quantity'] == $b['quantity'])
        return 0;
    else
        return 1;
}

function compare_quantity1($a, $b)
{
    if ($a['quantity'] > $b['quantity'])
        return -1;
    else if ($a['quantity'] == $b['quantity'])
        return 0;
    else
        return 1;
}

function compare_celebrity_num($a, $b)
{
    if ($a['celebrity_num'] < $b['celebrity_num'])
        return -1;
    else if ($a['celebrity_num'] == $b['celebrity_num'])
        return 0;
    else
        return 1;
}

function compare_celebrity_num1($a, $b)
{
    if ($a['celebrity_num'] > $b['celebrity_num'])
        return -1;
    else if ($a['celebrity_num'] == $b['celebrity_num'])
        return 0;
    else
        return 1;
}

function compare_celebrity($a, $b)
{
    if ($a['celebrity'] < $b['celebrity'])
        return -1;
    else if ($a['celebrity'] == $b['celebrity'])
        return 0;
    else
        return 1;
}

function compare_celebrity1($a, $b)
{
    if ($a['celebrity'] < $b['celebrity'])
        return -1;
    else if ($a['celebrity'] == $b['celebrity'])
        return 0;
    else
        return 1;
}
