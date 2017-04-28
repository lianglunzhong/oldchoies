<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Ordershipment extends Controller_Admin_Site
{

    private function construct()
    {
        $id = $this->request->param('id');
        $order = DB::select()->from('orders_order')
            ->where('site_id', '=', $this->site_id)
            ->where('id', '=', $id)
            ->execute('slave')
            ->current();
        if (!$order['id'])
        {
            message::set(__('订单不存在'), 'error');
            Request::instance()->redirect('/admin/site/ordershipment/list');
        }
        return $order;
    }

    public function action_list()
    {
        $content = View::factory('admin/site/order/shipment_list')
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_edit()
    {
        $data = $this->construct();
        if ($_POST)
        {
            $_url = '/admin/site/ordershipment/edit/' . $data['id'];
            //TODO validate post data.
            $post = $_POST;
            if (!$post['shipping_items'])
            {
                if (in_array($post['shipping_status'], array('shipped', 'delivered')))
                {
                    $updated = Order::instance()->update_shipment($data['id'], $post);
                    if ($updated)
                    {
                        Message::set(__('Update shipment success.'));
                    }
                    else
                    {
                        Message::set(__('Update shipment failed'), 'error');
                    }
                }
                else
                {
                    Message::set(__('Please select products to ship.'), 'error');
                }
            }
            else
            {
                // @todo check product items and quantity.
                foreach ($post['shipping_items'] as $k => $v)
                {
                    if (intval($post['shipping_quantity'][$v]['quantity']) < 1)
                    {
                        unset($post['shipping_items'][$k]);
                    }
                }
                if (count($post['shipping_items']))
                {
                    $shipment = Order::instance()->add_shipment($data['id'], $post);
                }
                if ($shipment)
                {
                    Message::set(__('Add shipment success.'));
                }
                else
                {
                    Message::set(__('Add shipment failed'), 'error');
                }
            }
            $_save = Arr::get($_POST, '_save', '');
            if ($_save)
                $_url = '/admin/site/ordershipment/list';
            $this->request->redirect($_url);
        }
        $order_history = Order::instance()->get_history($data['id']);
        $order_remarks = Order::instance()->get_remarks($data['id']);
        $payment_history = Order::instance()->get_payment_history($data['id']);
        $order_shipments = Order::instance()->get_shipments($data['id']);
        $orderitems = Order::instance()->get_orderitems($data['id']);
        $shippeditems = Order::instance()->get_shipmentitems($data['id']);
        $items = array();
        if (!$shippeditems)
        {
            $items = $orderitems;
        }
        else
        {
            foreach ($orderitems as $k => $v)
            {
                if (isset($shippeditems[$k]))
                {
                    if ($v == $shippeditems[$k])
                        continue;
                    $items[$k] = $v - $shippeditems[$k];
                }
                else
                {
                    $items[$k] = $v;
                }
            }
        }
        $countries = DB::select()->from('countries')->where('site_id', '=', $this->site_id)->execute('slave');
        $content = View::factory('admin/site/order/shipment_edit')
            ->set('data', $data)
            ->set('order_history', $order_history)
            ->set('order_remarks', $order_remarks)
            ->set('order_shipments', $order_shipments)
            ->set('orderitems', $items)
            ->set('shippeditems', $shippeditems)
            ->set('countries', $countries)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_delete()
    {
        
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
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                if ($item->data)
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.site_id=' . $this->site_id . ' AND `orders`.`parent_id` IS NULL AND '
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

        $result = DB::query(DATABASE::SELECT, 'SELECT `orders`.* FROM `orders_order` WHERE `orders`.site_id=' . $this->site_id . ' AND `orders`.`parent_id` IS NULL AND '
                . $filter_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $order_status = kohana::config('order_status');
        $k = 0;
        foreach ($result as $value)
        {
            $responce['rows'][$k]['id'] = $value['id'];
            $responce['rows'][$k]['cell'] = array(
                $value['id'],
                $value['email'],
                $value['ordernum'],
                $value['payment_status'] ? $order_status['payment'][$value['payment_status']]['name'] : '',
                $value['shipping_status'] ? $order_status['shipment'][$value['shipping_status']]['name'] : '',
                date('Y-m-d H:i:s', $value['created']),
            );
            $k++;
        }
        echo json_encode($responce);
    }

    function action_bulk()
    {
        if (!isset($_FILES) OR ($_FILES["file"]["type"] != "application/vnd.ms-excel" AND $_FILES["file"]["type"] != "text/csv" AND $_FILES["file"]["type"] != "text/comma-separated-values"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        while ($row = fgetcsv($handle))
        {
            $ordernum = $order_no;
            $order_no = $row[0];
            $track_no = $row[1];
            if (strpos($track_no, 'E+'))
                continue;
            $track_link = $row[2];
            $track_carrier = $row[3];

            if ($ordernum == $order_no)
            {
                $order_shipping = DB::select('id')->from('orders_ordershipments')->where('site_id', '=', $this->site_id)->and_where('ordernum', '=', $ordernum)->execute('slave')->as_array();
                if (count($order_shipping) > 1)
                {
                    DB::update('orders_ordershipments')
                        ->set(array('tracking_code' => $track_no, 'tracking_link' => $track_link, 'carrier' => $track_carrier ? $track_carrier : 'EMS'))
                        ->where('id', '=', $order_shipping[1]['id'])
                        ->execute();
                }
                else
                {
                    $shipment1 = array(
                        'admin_id' => 0,
                        'site_id' => $this->site_id,
                        'order_id' => Order::get_from_ordernum($ordernum),
                        'ordernum' => $ordernum,
                        'created' => time(),
                        'tracking_code' => $track_no,
                        'tracking_link' => $track_link,
                        'carrier' => $track_carrier,
                        'ship_date' => time()
                    );
                    DB::insert('orders_ordershipments', array_keys($shipment1))
                        ->values(array_values($shipment1))
                        ->execute();
                }
                continue;
            }
//                        echo $order_no . '-' . $track_no . '-' . $track_link . '-' . $track_carrier;exit;
            $shipping_status = DB::select('shipping_status')
                ->from('orders_order')
                ->where('ordernum', '=', $order_no)
                ->execute('slave')
                ->current();

            if ($shipping_status['shipping_status'] === 'shipped' OR $shipping_status['shipping_status'] === 'delivered')
            {
                $shipping_date = DB::select('shipping_date')->from('orders_order')->where('ordernum', '=', $order_no)->execute('slave')->get('shipping_date');
                if ($shipping_date)
                {
                    $ret = DB::update('orders_ordershipments')
                        ->set(array('tracking_code' => $track_no, 'tracking_link' => $track_link, 'carrier' => $track_carrier ? $track_carrier : 'EMS'))
                        ->where('site_id', '=', $this->site_id)
                        ->and_where('ordernum', '=', $order_no)
                        ->execute();
                }
                else
                {
                    DB::update('orders_order')->set(array('shipping_date' => time()))->where('ordernum', '=', $order_no)->execute();

                    $order_id = Order::get_from_ordernum($order_no);
                    $order = new Order($order_id);
                    if (!$order->get('id'))
                        continue;

                    // DB::update('orders_orderitem')->set(array('status' => 'shipped'))->where('order_id', '=', $order_id)->and_where('status', '=', 'new')->execute();
                    $items = array();
                    $products = $order->products();
                    foreach ($products as $product)
                    {
                        $order->ship_item($product['item_id'], $product['quantity']);
                        $items[] = array(
                            'item_id' => $product['item_id'],
                            'quantity' => $product['quantity'],
                        );
                    }

                    $ret = $order->add_shipment(array(
                        'tracking_code' => $track_no,
                        'tracking_link' => $track_link,
                        'carrier' => $track_carrier,
                        'ship_date' => time(),
                        ), $items);
                }

                if ($ret)
                {
                    $order_id = Order::get_from_ordernum($order_no);
                    $order = new Order($order_id);
                    if (!$order->get('id'))
                        continue;

                    // DB::update('orders_orderitem')->set(array('status' => 'shipped'))->where('order_id', '=', $order_id)->execute();
                    $customer = new Customer($order->get('customer_id'));
                    $email_params = array(
                        'ems_num' => $track_no,
                        'ems_url' => $track_link,
                        'order_num' => $order_no,
                        'currency' => $order->get('currency'),
                        'amount' => $order->get('amount'),
                        'email' => $customer->get('email'),
                        'firstname' => $customer->get('firstname') ? $customer->get('firstname') : 'customer',
                    );

                    if (($track_carrier == 'CUE' AND $track_link == '') or $track_carrier == 'HKPT')
                    {
                        $email_params['tracking_words'] = '';
                    }
                    else
                    {
                        $email_params['tracking_words'] = ($email_params['ems_num'] OR $email_params['ems_url']) ? str_ireplace(array('{ems_num}', '{ems_url}'), array($email_params['ems_num'], $email_params['ems_url']), 'The Tracking No. is {ems_num}<br />The Tracking Link is {ems_url}<br />The tracking number will be valid in 48 hours. Please check the shipping status of your order online often.') : '';
                    }
                    Mail::SendTemplateMail('SHIPPING', $email_params['email'], $email_params);
                    echo "$order_no: SUCCESS<br/>\n";
                }
                else
                {
                    echo "$order_no: FAILED<br/>\n";
                }
            }
            else
            {
                $ret = DB::update('orders_order')
                    ->set(array('shipping_status' => 'shipped', 'shipping_date' => time()))
                    ->where('ordernum', '=', $order_no)
                    ->where('site_id', '=', $this->site_id)
                    ->where('shipping_status', 'IN', array('new_s', 'processing'))
                    ->execute();
                if ($ret)
                {
                    $order_id = Order::get_from_ordernum($order_no);
                    $order = new Order($order_id);
                    if (!$order->get('id'))
                        continue;

                    // DB::update('orders_orderitem')->set(array('status' => 'shipped'))->where('order_id', '=', $order_id)->execute();
                    $items = array();
                    $products = $order->products();
                    foreach ($products as $product)
                    {
                        $order->ship_item($product['item_id'], $product['quantity']);
                        $items[] = array(
                            'item_id' => $product['item_id'],
                            'quantity' => $product['quantity'],
                        );
                    }

                    $order->add_shipment(array(
                        'tracking_code' => $track_no,
                        'tracking_link' => $track_link,
                        'carrier' => $track_carrier,
                        'ship_date' => time(),
                        ), $items);

                    $customer = new Customer($order->get('customer_id'));
                    $email_params = array(
                        'ems_num' => $track_no,
                        'ems_url' => $track_link,
                        'order_num' => $order_no,
                        'currency' => $order->get('currency'),
                        'amount' => $order->get('amount'),
                        'email' => $customer->get('email'),
                        'firstname' => $customer->get('firstname') ? $customer->get('firstname') : 'customer',
                    );

                    if ($track_carrier == 'CUE' AND $track_link == '')
                    {
                        $email_params['tracking_words'] = '';
                    }
                    else
                    {
                        $email_params['tracking_words'] = ($email_params['ems_num'] OR $email_params['ems_url']) ? str_ireplace(array('{ems_num}', '{ems_url}'), array($email_params['ems_num'], $email_params['ems_url']), 'The Tracking No. is {ems_num}<br />The Tracking Link is {ems_url}<br />The tracking number will be valid in 48 hours. Please check the shipping status of your order online often.') : '';
                    }
                    Mail::SendTemplateMail('SHIPPING', $email_params['email'], $email_params);
                    echo "$order_no: SUCCESS<br/>\n";
                }
                else
                {
                    echo "$order_no: FAILED<br/>\n";
                }
            }
        }
        fclose($handle);
    }

    function action_bulk_price()
    {
        if (!isset($_FILES) OR ($_FILES["file"]["type"] != "application/vnd.ms-excel" AND $_FILES["file"]["type"] != "text/csv" AND $_FILES["file"]["type"] != "text/comma-separated-values"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $pre_ordernum = '';
        while ($row = fgetcsv($handle))
        {
            $ordernum = $row[0];
            $ship_price = $row[1];
            if ($ordernum == $pre_ordernum)
            {
                $result = DB::query(Database::UPDATE, 'UPDATE order_shipments SET ship_price=ship_price+' . $ship_price . ' WHERE ordernum=' . $ordernum)
                    ->execute();
            }
            else
            {
                $result = DB::update('orders_ordershipments')
                    ->set(array('ship_price' => $ship_price))
                    ->where('ordernum', '=', $ordernum)
                    ->execute();
            }
            if ($result)
                echo "$ordernum: SUCCESS<br/>\n";
            else
            {
                echo "$ordernum: FAILED<br/>\n";
            }
            $pre_ordernum = $ordernum;
        }
        fclose($handle);
    }

    public function action_export()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $date = strtotime(Arr::get($_POST, 'date', 0));
//                $date += 28800; /* 8 hours */		
        // 添加更新结束时间
        $date_end = Arr::get($_POST, 'date_end', 0);

        if ($date_end)
        {
            $file_name = "ordershipments-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
            $date_end = strtotime($date_end);
//			$date_end += 28800;
        }
        else
        {
            $file_name = "ordershipments-" . date('Y-m-d', $date) . ".csv";
            $date_end = $date + 86400;
        }

        header("Content-type:application/vnd.ms-excel; charset=UTF-8");
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        echo "\xEF\xBB\xBF" . "Order No.,Email,Created,Ship Date,Deliver Time,Weight,Country,Ship Method,Ship Code,预计费用,实际费用,关税,Admin\n";
        $conditions = array(
            "is_active = 1",
            "site_id=" . $this->site_id,
            "payment_status  = 'verify_pass'",
            "shipping_status IN ('shipped', 'delivered')",
            "created >= $date",
            "created < $date_end",
        );

        $where_clause = implode(' AND ', $conditions);
        $result = DB::query(Database::SELECT, 'SELECT id,ordernum,email,created,deliver_time,shipping_country FROM orders WHERE ' . $where_clause)->execute('slave')->as_array();
        foreach ($result as $order)
        {
            echo $order['ordernum'] . ',';
            echo $order['email'] . ',';
            echo date('Y-m-d', $order['created']) . ',';
            $shipping = DB::select('carrier', 'ship_date', 'ship_price', 'tracking_code')->from('orders_ordershipments')->where('order_id', '=', $order['id'])->execute('slave')->current();
            echo date('Y-m-d', $shipping['ship_date']) . ',';
            echo $order['deliver_time'] ? date('Y-m-d', $order['deliver_time']) . ',' : ',';
            $products = DB::select('product_id')->from('orders_orderitem')->where('order_id', '=', $order['id'])->execute('slave')->as_array();
            $weight = empty($products) ? 0 : DB::select(array(DB::expr('SUM(weight)'), 'sum'))->from('products_product')->where('id', 'IN', $products)->execute('slave')->get('sum');
            echo $weight . ',';
            echo $order['shipping_country'] . ',';
            echo $shipping['carrier'] . ',';
            echo "'" . $shipping['tracking_code'] . ',';
            echo ',';
            echo $shipping['ship_price'] ? $shipping['ship_price'] : '' . ',';
            echo ',';
            $admin = DB::select('admin')->from('celebrities_celebrits')->where('email', '=', $order['email'])->execute('slave')->get('admin');
            echo $admin ? User::instance($admin)->get('name') : ' ';
            echo "\n";
        }
    }



    //新旧ERP切换期间，先获取运单号给我们各渠道手动回传,临时用几天
    public function action_manual_update_shipment()
    {
        if (!isset($_FILES) OR ($_FILES["file"]["type"] != "application/vnd.ms-excel" AND $_FILES["file"]["type"] != "text/csv" AND $_FILES["file"]["type"] != "text/comma-separated-values"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $rowno = 0;
        $msg = '';
        $hasupdate_ordernum = '';
        $csv_items = array();
        while ($row = fgetcsv($handle))
        {
            if ($rowno == 0) {
                $rowno = $rowno + 1;
                continue;
            }
            $csv_items[] = array(
                'ordernum' => $row[0],
                'shipping_method' => $row[1],
                'tracking_no' => str_replace("'","",$row[2]),
                'tracking_link' => $row[3],
                'status' => 'shipped',
                'skus' => '',
                'qtys' => '',
                'totals' => 0,
                'shipping_time' => time(),
                'package_id' => 20160801,
            );
        }
        fclose($handle);

        foreach($csv_items as $csv_item)
        {
            $ordernum = $csv_item['ordernum'];
            $shipping_method = $csv_item['shipping_method'];
            $tracking_no = $csv_item['tracking_no'];
            $tracking_link = $csv_item['tracking_link'];
            $status = $csv_item['status'];
            $skus = $csv_item['skus'];
            $qtys = $csv_item['qtys'];
            $totals = $csv_item['totals'];
            $shipping_time = $csv_item['shipping_time'];
            $package_id = $csv_item['package_id'];//暂时固定的值

            if ((!empty($ordernum)) && (!empty($tracking_no)) && (!empty($shipping_method))) {
                // 判断已追加过order_shipments，不处理
                $order_shipments = DB::query(Database::SELECT, "SELECT `id`,`order_id`,`ordernum` FROM `orders_ordershipments` WHERE `ordernum`='" . $ordernum . "'")->execute('slave')->as_array();
                if (count($order_shipments) > 0) {
                    $hasupdate_ordernum = $hasupdate_ordernum . $ordernum . "<br>";
                    continue;
                }
                $order = DB::query(Database::SELECT, "SELECT `id`,`ordernum`,`shipping_status` FROM `orders_order` WHERE `ordernum`='" . $ordernum . "'")->execute('slave')->as_array();
                if (count($order) > 0) {
                    $order_id = $order[0]['id'];
                    $order_items = DB::query(Database::SELECT, 'SELECT `id`,`sku`,`quantity` FROM `orders_orderitem` WHERE `order_id`=' . $order_id)->execute('slave')->as_array();
                    if (count($order_items) > 0) {
                        $order_skus_arr = array();
                        $order_qtys_arr = array();
                        foreach ($order_items as $item_key) {
                            $order_skus_arr[] = $item_key['sku'];
                            $order_qtys_arr[] = $item_key['quantity'];
                        }
                        $skus = implode(',', $order_skus_arr);
                        $qtys = implode(',', $order_qtys_arr);
                    }

                    if ((!empty($skus)) && (!empty($qtys))) {
                        if ($status == 'shipped')
                            $shipping_status = 'shipped';
                        else
                            $shipping_status = 'partial_shipped';
                        $shipping_date = time();
                        //更新order
                        $result = DB::query(Database::UPDATE, "UPDATE orders SET shipping_status='" . $shipping_status . "',shipping_date=" . $shipping_date . " WHERE ordernum='" . $ordernum . "'")
                            ->execute();
                        if ($result) {
                            $shipment = array(
                                'carrier' => $shipping_method,
                                'tracking_code' => $tracking_no,
                                'tracking_link' => $tracking_link,
                                'ship_date' => strtotime($shipping_time),
                                'ship_price' => $totals,
                                'package_id' => $package_id,
                            );
                            $items = array();
                            $skusArr = explode(',', $skus);
                            $qtysArr = explode(',', $qtys);
                            foreach ($skusArr as $key => $sku) {
                                if (isset($qtysArr[$key])) {
                                    $skuA = explode('-', $sku);
                                    $item_id = Product::get_productId_by_sku(trim($skuA[0]));
                                    if ($item_id) {
                                        $items[] = array(
                                            'item_id' => $item_id,
                                            'quantity' => $qtysArr[$key],
                                        );
                                    }
                                }
                            }
                            $orderd = Order::instance($order_id);
                            if ($orderd->add_shipment($shipment, $items)) {
                                if ($shipping_status == 'shipped') {
                                    $email_params = array(
                                        'tracking_num' => $tracking_no,
                                        'tracking_url' => $tracking_link,
                                        'order_num' => $ordernum,
                                        'currency' => $orderd->get('currency'),
                                        'amount' => $orderd->get('amount'),
                                        'email' => $orderd->get('email'),
                                        'firstname' => $orderd->get('shipping_firstname'),
                                        'tracking_words' => '',
                                    );
                                    Mail::SendTemplateMail('SHIPPING', $email_params['email'], $email_params);
                                    //本地测试用发给自己QQ邮箱，注意修改order里的邮箱为自己邮箱
//                                    Mail::SendTemplateMail('SHIPPING', '573857424@qq.com', $email_params);
                                    $msg = $msg . $ordernum . '手动回传成功，邮件已发送<br>';
                                } else {
                                    $email_params = array(
                                        'tracking_num' => $tracking_no,
                                        'tracking_url' => $tracking_link,
                                        'order_num' => $ordernum,
                                        'currency' => $orderd->get('currency'),
                                        'amount' => $orderd->get('amount'),
                                        'email' => $orderd->get('email'),
                                        'firstname' => $orderd->get('shipping_firstname'),
                                        'tracking_words' => '',
                                    );
                                    Mail::SendTemplateMail('PARTIALSHIPPING', $email_params['email'], $email_params);
                                    //本地测试用发给自己QQ邮箱，注意修改order里的邮箱为自己邮箱
//                                    Mail::SendTemplateMail('PARTIALSHIPPING', '573857424@qq.com', $email_params);
                                }
                            }
                        }
                    }
                }
            }
        }
        print "无需处理ordernum（重复）:"."<br>";
        print $hasupdate_ordernum;
        print "手动回传处理记录：";
        print $msg;
    }

    //新旧ERP切换期间,手动回传后，修改发货日期(ship_date),临时用几天
    public function action_manual_update_shipment_ship_date()
    {
        if($_POST)
        {
            $success_ordernum = '';
            $success_count = 0;
            $failed_ordernum = '';
            $failed_count = 0;
            $ship_date = strtotime(Arr::get($_POST, 'ship_date', 0));
            $ordernums = Arr::get($_POST, 'ordernum', '');
            if (!$ship_date)
            {
                echo 'Ship_date cannot be empty';
                exit;
            }
            if (!$ordernums)
            {
                echo 'Ordernum cannot be empty';
                exit;
            }
            if ($ship_date && $ordernums)
            {
                $ordernumArr = explode("\n", $ordernums);
                foreach ($ordernumArr as $ordernum)
                {
                    $ordernum = trim($ordernum);
                    //更新order
                    $result = DB::query(Database::UPDATE, "UPDATE `order_shipments` SET `ship_date`='" . $ship_date . "' WHERE package_id='20160801' and ordernum='" . $ordernum . "'")
                        ->execute();
                    if($result)
                    {
                        $success_count = $success_count + 1;
                        $success_ordernum = $success_ordernum . $ordernum ."<br>";
                    }
                    else
                    {
                        $failed_count = $failed_count + 1;
                        $failed_ordernum = $failed_ordernum . $ordernum ."<br>";
                    }
                }
            }
            echo "批量修改发货日期结果:更新成功".$success_count."条。更新失败".$failed_count."条。<br>更新成功的Ordernum:<br>";
            print $success_ordernum;
            if($failed_count>0)
            {
                echo "更新失败的Ordernum(检查是否重复修改，无需修改):"."<br>";
                print $failed_ordernum;
            }
        }
    }
}