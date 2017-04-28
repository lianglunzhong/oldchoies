<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Clicks extends Controller_Admin_Site
{

    public function action_list()
    {
        $content = View::factory('admin/site/clicks_list')
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_mobile_list()
    {
        $content = View::factory('admin/site/clicks_mobile')
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
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

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "1";
        $order_sql = '';
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                // TODO optimize name filter.
                if ($item->field == 'day')
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
                    $_filter_sql[] = $item->field . " between " . $from . " and " . $to;
                }
                else
                {
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`id`) AS num FROM `site_clicks` WHERE '
                . $filter_sql)->execute('slave');
        $count = $result[0]['num'];
        $total_pages = 0;
//                $limit = 20;
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

        $result = DB::query(DATABASE::SELECT, 'SELECT *  
		FROM `site_clicks` WHERE '
                . $filter_sql . ' GROUP BY id ' . $order_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        foreach ($result as $data)
        {
            $day = $data['day'] - 8 * 3600;
            $next_day = $day + 86400;
            // $orders = DB::query(Database::SELECT, 'SELECT DISTINCT p.order_id FROM order_payments p WHERE p.payment_status="success" AND p.payment_method="globebill" AND p.created >= ' . $day . ' AND p.created < ' . $next_day)->execute('slave')->as_array();
            // $c_num = count($orders);
            // $orders = DB::query(Database::SELECT, 'SELECT DISTINCT p.order_id FROM order_payments p WHERE p.payment_status="success" AND p.payment_method="PPJump" AND p.created >= ' . $day . ' AND p.created < ' . $next_day)->execute('slave')->as_array();
            // $p_num = count($orders);
            // $orders = DB::query(Database::SELECT, 'SELECT DISTINCT p.order_id FROM order_payments p WHERE p.payment_status="success" AND p.payment_method="PPExpress" AND p.created >= ' . $day . ' AND p.created < ' . $next_day)->execute('slave')->as_array();
            // $ppc_num = count($orders);
            // $cart_rate = $data['cart_view'] > 0 ? round((($c_num + $p_num + $ppc_num) / $data['cart_view']) * 100, 2) : 0;
            $responce['rows'][$k]['id'] = $data['id'];
            $responce['rows'][$k]['cell'] = array(
                $data['id'],
                date('Y-m-d', $data['day']),
                $data['add_to_cart'],
                $data['cart_view'],
                $data['continue'],
                $data['cart_login'],
                $data['cart_checkout'],
                $data['proceed'],
                $data['globebill'],
                $data['ppjump'],
                $data['card_pay'],
                $data['cart_to_cookie'],
                $data['cookie_to_cart'],
                // $c_num,
                // $p_num,
                // $ppc_num,
                // $cart_rate . '%',
                $data['log']
            );
            $k++;
        }
        echo json_encode($responce);
    }

    public function action_mobile_data()
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

        $filter_sql = "1";
        $order_sql = '';
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                // TODO optimize name filter.
                if ($item->field == 'day')
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
                    $_filter_sql[] = $item->field . " between " . $from . " and " . $to;
                }
                else
                {
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`id`) AS num FROM `site_mobile_clicks` WHERE '
                . $filter_sql)->execute('slave');

        $count = $result[0]['num'];

        $total_pages = 0;
//                $limit = 20;
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

        $result = DB::query(DATABASE::SELECT, 'SELECT *  
		FROM `site_mobile_clicks` WHERE '
                . $filter_sql . ' GROUP BY id ' . $order_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        foreach ($result as $data)
        {
            $day = $data['day'];
            $next_day = $day + 86400;
            $c_num = DB::query(Database::SELECT, 'SELECT count(*) AS count FROM orders WHERE payment_status="verify_pass" AND payment_method="GLOBEBILL" AND erp_fee_line_id=1 AND created >= ' . $day . ' AND created < ' . $next_day)->execute('slave')->get('count');
            $p_num = DB::query(Database::SELECT, 'SELECT count(*) AS count FROM orders WHERE payment_status="verify_pass" AND payment_method = "PP" AND erp_fee_line_id=1 AND created >= ' . $day . ' AND created < ' . $next_day)->execute('slave')->get('count');
            $ppc_num = DB::query(Database::SELECT, 'SELECT count(*) AS count FROM orders WHERE payment_status="verify_pass" AND payment_method = "PPEC" AND erp_fee_line_id=1 AND created >= ' . $day . ' AND created < ' . $next_day)->execute('slave')->get('count');


            $cele_c_num = DB::query(Database::SELECT, 'SELECT COUNT(orders.id) AS count FROM `orders_order`,celebrits 
                                        WHERE orders.email = celebrits.email AND orders.is_active = 1 AND orders.erp_fee_line_id=1
                                        AND orders.payment_status = "verify_pass" AND orders.payment_method="GLOBEBILL"
                                        AND orders.created >= ' . $day . ' AND orders.created < ' . $next_day)
                    ->execute('slave')->get('count');
            $cele_p_num = DB::query(Database::SELECT, 'SELECT COUNT(orders.id) AS count FROM `orders_order`,celebrits 
                                        WHERE orders.email = celebrits.email AND orders.is_active = 1 AND orders.erp_fee_line_id=1
                                        AND orders.payment_status = "verify_pass" AND orders.payment_method = "PP" 
                                        AND orders.created >= ' . $day . ' AND orders.created < ' . $next_day)
                    ->execute('slave')->get('count');


            $cele_ppc_num = DB::query(Database::SELECT, 'SELECT COUNT(orders.id) AS count FROM `orders_order`,celebrits 
                                        WHERE orders.email = celebrits.email AND orders.is_active = 1 AND orders.erp_fee_line_id=1
                                        AND orders.payment_status = "verify_pass" AND orders.payment_method = "PPEC" 
                                        AND orders.created >= ' . $day . ' AND orders.created < ' . $next_day)
                    ->execute('slave')->get('count');
            $cart_rate = $data['cart_view'] > 0 ? round((($c_num + $p_num + $ppc_num) / $data['cart_view']) * 100, 2) : 0;
            $responce['rows'][$k]['id'] = $data['id'];
            $responce['rows'][$k]['cell'] = array(
                $data['id'],
                date('Y-m-d', $data['day']),
                $data['add_to_cart'],
                $data['cart_view'],
                $data['continue'],
                $data['checkout'],
                $data['ppec'],
                $data['cart_login'],
                $data['cart_checkout'],
                $data['proceed'],
                $data['globebill'],
                $data['ppjump'],
                $c_num - $cele_c_num,
                $p_num - $cele_p_num,
                $ppc_num - $cele_ppc_num,
                $cart_rate . '%',
                $data['log']
            );
            $k++;
        }
        echo json_encode($responce);
    }

    public function action_edit_log()
    {
        if ($_POST)
        {
            $id = Arr::get($_POST, 'id', '');
            $log = Arr::get($_POST, 'log', '');
            $result = DB::query(Database::UPDATE, 'UPDATE site_clicks SET log="' . $log . '" WHERE id=' . $id)->execute();
            if ($result)
            {
                Message::set('Success', 'success');
            }
            else
            {
                Message::set('Assign Backup Celebrity Failed!', 'error');
            }
        }
        $this->request->redirect('/admin/site/clicks/list');
    }

    public function action_export()
    {
        if ($_POST)
        {
            $start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);
            $filter_day = '';
            $file = 'convert';
            if ($start)
            {
                $file .= "-from-$start";
                $filter_day .= ' WHERE day >= ' . strtotime($start);
            }

            if ($end)
            {
                $file .= "-to-$end";
                $filter_day .= ' AND day < ' . strtotime($end);
            }
            $result = DB::query(DATABASE::SELECT, 'SELECT * FROM `site_clicks` ' . $filter_day . ' ORDER BY id DESC')->execute('slave');

            header("Content-type:application/vnd.ms-excel; charset=UTF-8");
            header('Content-Disposition: attachment; filename=' . $file . '.csv');
            echo "\xEF\xBB\xBF" . "Day,Add cart,Cart view,Continue,Checkout,PPEC,Cart/Login,Cart/Checkout,Proceed,Credit Card,Paypal,Card Num,PP Num,PPEC Num,Cart %,Log\n";
            foreach ($result as $data)
            {
                $day = $data['day'];
                $next_day = $day + 86400;
                $c_num = DB::query(Database::SELECT, 'SELECT count(*) AS count FROM orders WHERE payment_status="verify_pass" AND payment_method="GLOBEBILL" AND created >= ' . $day . ' AND created < ' . $next_day)->execute('slave')->get('count');
                $p_num = DB::query(Database::SELECT, 'SELECT count(*) AS count FROM orders WHERE payment_status="verify_pass" AND payment_method = "PP" AND created >= ' . $day . ' AND created < ' . $next_day)->execute('slave')->get('count');
                $ppc_num = DB::query(Database::SELECT, 'SELECT count(*) AS count FROM orders WHERE payment_status="verify_pass" AND payment_method = "PPEC" AND created >= ' . $day . ' AND created < ' . $next_day)->execute('slave')->get('count');
                $cele_c_num = DB::query(Database::SELECT, 'SELECT COUNT(orders.id) AS count FROM `orders_order`,celebrits 
                                        WHERE orders.email = celebrits.email AND orders.is_active = 1 
                                        AND orders.payment_status IN("success","verify_pass") AND orders.payment_method="GLOBEBILL"
                                        AND orders.created >= ' . $day . ' AND orders.created < ' . $next_day)
                        ->execute('slave')->get('count');
                $cele_p_num = DB::query(Database::SELECT, 'SELECT COUNT(orders.id) AS count FROM `orders_order`,celebrits 
                                        WHERE orders.email = celebrits.email AND orders.is_active = 1 
                                        AND orders.payment_status IN("success","verify_pass") AND orders.payment_method = "PP" 
                                        AND orders.created >= ' . $day . ' AND orders.created < ' . $next_day)
                        ->execute('slave')->get('count');
                $cele_ppc_num = DB::query(Database::SELECT, 'SELECT COUNT(orders.id) AS count FROM `orders_order`,celebrits 
                                        WHERE orders.email = celebrits.email AND orders.is_active = 1 
                                        AND orders.payment_status IN("success","verify_pass") AND orders.payment_method = "PPEC" 
                                        AND orders.created >= ' . $day . ' AND orders.created < ' . $next_day)
                        ->execute('slave')->get('count');
                $cart_rate = $data['cart_view'] > 0 ? round((($c_num + $p_num + $ppc_num) / $data['cart_view']) * 100, 2) : 0;
                echo date('Y-m-d', $data['day']), ',';
                echo $data['add_to_cart'], ',';
                echo $data['cart_view'], ',';
                echo $data['continue'], ',';
                echo $data['checkout'], ',';
                echo $data['ppec'], ',';
                echo $data['cart_login'], ',';
                echo $data['cart_checkout'], ',';
                echo $data['proceed'], ',';
                echo $data['globebill'], ',';
                echo $data['ppjump'], ',';
                echo $c_num - $cele_c_num, ',';
                echo $p_num - $cele_p_num, ',';
                echo $ppc_num - $cele_ppc_num, ',';
                echo $cart_rate . '%', ',';
                echo $data['log'], "\n";
            }
        }
    }

    public function action_products()
    {
        if ($_POST)
        {
            $start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);
            $get = '';
            if ($start)
            {
                $get .= '?start=' . strtotime($start);
                if ($end)
                    $get .= '&end=' . strtotime($end);
            }
            $this->request->redirect('/admin/site/clicks/products' . $get);
        }
        $content = View::factory('admin/site/clicks_products')
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_products_data()
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
        else
            $sidx = 'd.' . $sidx;
        if (!$sord)
            $sord = '';

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "1";
        $order_sql = '';
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                // TODO optimize name filter.
                if ($item->field == 'day')
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
                    $_filter_sql[] = "d." . $item->field . " between " . $from . " and " . $to;
                }
                elseif ($item->field == 'sku')
                {
                    $id = Product::get_productId_by_sku($item->data);
                    $_filter_sql[] = "d.product_id='" . $id . "'";
                }
                elseif ($item->field == 'set')
                {
                    $id = DB::select('id')->from('sets')->where('name', '=', $item->data)->execute('slave')->get('id');
                    $_filter_sql[] = "p.set_id='" . $id . "'";
                }
                else
                {
                    $_filter_sql[] = "d." . $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $start = Arr::get($_GET, 'start', NULL);
        $end = Arr::get($_GET, 'end', NULL);
        $filter_day = '';
        if ($start)
        {
            if ($end)
            {
                $filter_day .= ' AND d.day >= ' . $start . ' AND d.day < ' . $end;
            }
            else
            {
                $filter_day .= ' AND d.day >= ' . $start;
            }
        }

        $count = DB::query(DATABASE::SELECT, 'SELECT COUNT(DISTINCT d.product_id) AS num FROM product_daily d 
                                        LEFT JOIN products p ON d.product_id=p.id WHERE '
                . $filter_sql . $filter_day)->execute('slave')->get('num');
        $total_pages = 0;
//                $limit = 20;
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

        $result = DB::query(DATABASE::SELECT, 'SELECT DISTINCT d.product_id FROM
		product_daily d LEFT JOIN products p ON d.product_id=p.id WHERE '
                . $filter_sql . $filter_day . ' GROUP BY d.id ' . $order_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        foreach ($result as $data)
        {
            $clicks = DB::query(Database::SELECT, 'SELECT SUM( `clicks` ) AS clicks , SUM( `quick_clicks` ) AS quick_clicks ,
                                SUM( `add_times` ) AS add_times , SUM( `hits` ) AS hits FROM  `product_daily` WHERE `product_id` = ' . $data['product_id'] . $filter_day)
                    ->execute('slave')->current();
            $responce['rows'][$k]['id'] = $data['id'];
            $responce['rows'][$k]['cell'] = array(
                $k,
                Product::instance($data['product_id'])->get('sku'),
                Set::instance(Product::instance($data['product_id'])->get('set_id'))->get('name'),
                Product::instance($data['product_id'])->get('price'),
                $clicks['clicks'],
                $clicks['quick_clicks'],
                $clicks['add_times'],
                $clicks['hits']
            );
            $k++;
        }
        echo json_encode($responce);
    }

    public function action_products_export()
    {
        if ($_POST)
        {
            $start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);
            $filter_day = '';
            $file = 'product_clicks';
            if ($start)
            {
                $file .= "-from-$start";
                $filter_day .= ' WHERE day >= ' . strtotime($start);
            }

            if ($end)
            {
                $file .= "-to-$end";
                $filter_day .= ' AND day < ' . strtotime($end);
            }
            $result = DB::query(DATABASE::SELECT, 'SELECT DISTINCT product_id FROM `product_daily` ' . $filter_day . ' ORDER BY clicks DESC')->execute('slave');

            header("Content-type:application/vnd.ms-excel; charset=UTF-8");
            header('Content-Disposition: attachment; filename=' . $file . '.csv');
            echo "\xEF\xBB\xBF" . "SKU,Set,Price,Clicks,Q_clicks,Add Cart,Hits\n";
            foreach ($result as $data)
            {
                $clicks = DB::query(Database::SELECT, 'SELECT SUM( `clicks` ) AS clicks , SUM( `quick_clicks` ) AS quick_clicks ,
                                SUM( `add_times` ) AS add_times , SUM( `hits` ) AS hits FROM `product_daily` ' . $filter_day . ' AND `product_id` = ' . $data['product_id'])
                        ->execute('slave')->current();
                echo Product::instance($data['product_id'])->get('sku'), ',';
                echo Set::instance(Product::instance($data['product_id'])->get('set_id'))->get('name'), ',';
                echo Product::instance($data['product_id'])->get('price'), ',';
                echo $clicks['clicks'], ',';
                echo $clicks['quick_clicks'], ',';
                echo $clicks['add_times'], ',';
                echo $clicks['hits'], "\n";
            }
        }
    }

    public function action_brand()
    {
        if ($_POST['start'])
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
            $this->request->redirect('/admin/site/clicks/brand?history=' . $date . '-' . $date_end);
        }
        $content = View::factory('admin/site/clicks_brand')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_brand_data()
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

        $filter_sql = " WHERE brief='brand'";
        $_filter_sql = array();

        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                if ($item->field == 'name')
                {
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
                }
            }
        }
        if (!empty($_filter_sql))
            $filter_sql .= 'AND ' . implode(' AND ', $_filter_sql);

        $daterange = '';
        if ($_GET['history'])
        {
            $history = $_GET['history'];
            $date = explode('-', $history);
            $daterange = ' BETWEEN ' . $date[0] . ' AND ' . $date[1];
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;
        $limit = 5;

        $count = DB::query(DATABASE::SELECT, 'SELECT COUNT(id) as count FROM sets ' . $filter_sql)->execute('slave')->get('count');
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT id,name FROM sets ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        $order_where = '';
        if ($daterange)
            $order_where = ' AND o.created ' . $daterange;
        foreach ($result as $data)
        {
            $orders = DB::query(Database::SELECT, 'SELECT o.order_id, o.sku, o.price, o.quantity, p.set_id 
                                FROM order_items o LEFT JOIN products p ON o.product_id = p.id WHERE o.status != "cancel" AND p.set_id =' . $data['id'] . $order_where)
                    ->execute('slave')->as_array();
            $o_quantity = array();
            $c_quantity = array();
            $amount = 0;
            $p_quantity = 0;
            $skus = array();
            $c_products = 0;
            $celebrits = array();
            foreach ($orders as $key => $order)
            {
                $status = Order::instance($order['order_id'])->get('payment_status');
                if ($status != 'verify_pass')
                    unset($orders[$key]);
                else
                {
                    $customer_id = Order::instance($order['order_id'])->get('customer_id');
                    if (Customer::instance($customer_id)->is_celebrity())
                    {
                        $c_products += $order['quantity'];
                        $celebrits[$customer_id] = 1;
                        $c_quantity[$order['order_id']] = 1;
                    }
                    else
                    {
                        $amount += $order['price'] * $order['quantity'];
                        $p_quantity += $order['quantity'];
                        $skus[$order['sku']] = 1;
                        $o_quantity[$order['order_id']] = 1;
                    }
                }
            }

            $total_skus = DB::select(DB::expr('COUNT(id) as count'))->from('products_product')
                    ->where('set_id', '=', $data['id'])->and_where('visibility', '=', 1)->execute('slave')->get('count');
            if ($daterange)
            {
                $total_clicks = DB::query(Database::SELECT, 'SELECT SUM(d.clicks+d.quick_clicks) AS sum FROM `product_daily` d, products p
                                WHERE d.product_id = p.id AND p.set_id =' . $data['id'] . ' AND d.day ' . $daterange)
                        ->execute('slave')->get('sum');
            }
            else
            {
                $total_clicks = DB::select(DB::expr('SUM(clicks+quick_clicks) AS sum_clicks'))->from('products_product')
                        ->where('set_id', '=', $data['id'])->and_where('visibility', '=', 1)->execute('slave')->get('sum_clicks');
            }
            $response['rows'][$i]['id'] = $data['id'];
            $response['rows'][$i]['cell'] = array(
                $data['name'],
                count($o_quantity),
                count($c_quantity),
                $amount,
                $p_quantity,
                $p_quantity > 0 ? round($amount / $p_quantity, 2) : 0,
                $total_skus,
                count($skus),
                $c_products,
                count($celebrits),
                $total_clicks ? $total_clicks : 0,
                $total_skus > 0 ? round($total_clicks / $total_skus, 2) : 0,
            );
            $i++;
        }
        echo json_encode($response);
    }

    //合作商分账
    public function action_brand_account()
    {
        $brands = DB::select('id', 'name')->from('sets')->where('brief', '=', 'brand')->execute('slave')->as_array();
        $set_id = $this->request->param('id');
        if ($set_id)
        {
            $sets = Set::instance($set_id)->get();
            if ($sets['brief'] != 'brand')
            {
                die('This set is not brand!');
            }
            $content = View::factory('admin/site/clicks_brand_account')->set('sets', $sets)->set('brands', $brands)->render();
            $this->request->response = View::factory('admin/template')->set('content', $content)->render();
        }
        else
        {
            $content = View::factory('admin/site/clicks_brand_account')->set('brands', $brands)->render();
            $this->request->response = View::factory('admin/template')->set('content', $content)->render();
        }
    }

    public function action_brand_account_data()
    {
        $usd_rate = 6.1;
        $set_id = $this->request->param('id');
        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        $i = array('id', 'sku', 'name', 'quantity', 'attributes', 'status');
        $o = array('ordernum', 'email', 'amount', 'currency', 'verify_date');
        $p = array('orig_price', 'cost', 'total_cost', 'weight');
        //sort
        if (in_array($sidx, $i))
            $sidx = 'i.' . $sidx;
        elseif (in_array($sidx, $o))
            $sidx = 'o.' . $sidx;
        elseif (in_array($sidx, $p))
        {
            if ($sidx == 'orig_price')
                $sidx = 'p.price';
            else
                $sidx = 'p.' . $sidx;
        }
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";
        $_filter_sql = array();

        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                if (in_array($item->field, $i))
                    $field = 'i.' . $item->field;
                elseif (in_array($item->field, $o))
                    $field = 'o.' . $item->field;
                elseif (in_array($item->field, $p))
                {
                    if ($item->field == 'orig_price')
                        $field = 'p.price';
                    else
                        $field = 'p.' . $item->field;
                }
                if ($item->field == 'verify_date')
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
                    $_filter_sql[] = $field . " between " . $from . " and " . $to;
                }
                else
                    $_filter_sql[] = $field . "='" . $item->data . "'";
            }
        }
        if (!empty($_filter_sql))
            $filter_sql .= 'AND ' . implode(' AND ', $_filter_sql);

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $count = DB::query(DATABASE::SELECT, 'SELECT COUNT(i.id) as count FROM `orders_orderitem` i LEFT JOIN orders o ON i.order_id=o.id RIGHT JOIN products p ON i.product_id=p.id 
                        WHERE p.set_id=' . $set_id . ' AND o.payment_status="verify_pass" AND i.status <> "cancel" ' . $filter_sql)->execute('slave')->get('count');
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT o.ordernum, i.id, i.order_id, i.sku, i.name, i.quantity, i.attributes, i.status, o.email, o.amount, o.currency, i.price, p.price AS orig_price, p.cost, p.total_cost, p.weight, o.verify_date, o.points, o.amount_coupon 
                                FROM `orders_orderitem` i LEFT JOIN orders o ON i.order_id=o.id RIGHT JOIN products p ON i.product_id=p.id 
                                WHERE p.set_id=' . $set_id . ' AND o.payment_status="verify_pass" AND i.status <> "cancel" ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        $sys_currencies = Site::instance()->currencies();
        foreach ($result as $data)
        {
            if(!isset($sys_currencies[$data['currency']]))
                continue;
            $admin = '';
            $cel = DB::select('admin')->from('celebrities_celebrits')->where('email', '=', $data['email'])->execute('slave')->get('admin');
            if ($cel)
                $admin = User::instance($cel)->get('name');

            //计算: 积分扣除,折扣扣除	利润,分成,合作方金额
            $points = 0;
            $coupons = 0;
            $shipping = 0;
            $usd_cost = 0;
            $profit = 0;
            $commission = 0;
            $partners = 0;
            if ($data['amount'] > 0 AND $admin == '' AND !in_array($data['status'], array('cancel', 'return')))
            {
                if ($data['points'] OR $data['amount_coupon'])
                {
                    $point_price = $data['points'] / 100;
                    $total_price = DB::select(DB::expr('SUM(price * quantity) AS total'))->from('orders_orderitem')->where('order_id', '=', $data['order_id'])->execute('slave')->get('total');
                    $rate = $data['price'] * $data['quantity'] / $total_price;
                    $points = round($rate * $point_price, 2);
                    if ($data['price'] >= $data['orig_price'])
                        $coupons = round($rate * $data['amount_coupon'], 2);
                }
                $shipping = round(120 * $data['weight'], 2);
                $usd_cost = round(($data['total_cost'] + $shipping) / $usd_rate, 2);

                $profit = $data['price'] * $data['quantity'] - $usd_cost * $data['quantity'] - $points - $coupons;
                $profit = round($profit, 2);
                $commission = round(($profit / 2) * $usd_rate, 2);
                $partners = $data['total_cost'] * $data['quantity'] + $commission;
            }
            $response['rows'][$i]['id'] = $data['id'];
            $response['rows'][$i]['cell'] = array(
                $data['id'],
                $data['ordernum'],
                $data['sku'],
                $data['name'],
                $data['quantity'],
                $data['attributes'],
                $admin,
                round($data['amount'] / $sys_currencies[$data['currency']]['rate'], 2),
                round($data['price'], 2),
                round($data['orig_price'], 2),
                round($data['cost'], 2),
                date('Y-m-d H:i:s', $data['verify_date']),
                $data['status'],
                round($data['weight'], 2),
                $shipping,
                round($data['total_cost'], 2),
                $usd_cost,
                $points,
                $coupons,
                $profit,
                $commission,
                $partners,
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_exprotcsv()
    {
        $filename = Arr::get($_POST, 'filename', 'Export_' . date('Y-m-d', time()));
        ob_end_clean();
        ob_start();
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition: attachment; filename=' . $filename . '.xls');
        header("Content-Transfer-Encoding: binary ");

        $buffer = $_POST['csvBuffer'];
        $buffer = iconv("utf-8", "gbk", $buffer);
        try
        {
            echo $buffer;
        }
        catch (Exception $e)
        {
            echo 'Sorry, Server is too busy, please try again later,THX.';
        }
    }

}

?>