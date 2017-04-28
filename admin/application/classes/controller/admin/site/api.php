<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Api extends Controller_Admin_Site
{

    //跑客户VIP等级的
    public function action_sendmail1()
    {
        // vip mail send
        $key = 0;
        $currency = Site::instance()->currencies();
        $vips = DB::select()->from('vip_types')->execute('slave')->as_array();
        $result = DB::query(Database::SELECT, "SELECT id, trans_id, customer_id, email, currency, amount FROM order_payments
                                        WHERE vip_status =0 AND amount >0 AND payment_status = 'success' AND created > 1370044800
                                        ORDER BY customer_id LIMIT 0, 20")
                ->execute('slave');
        $called = array(
            1 => '',
            2 => 'Bronze',
            3 => 'Silver',
            4 => 'Gold',
            5 => 'Diamond'
        );
        $count = 0;
        $customer = 0;
        $tr_id = '';
        foreach ($result as $order)
        {
            if ($order['trans_id'] == $tr_id)
            {
                DB::update('orders_orderpayments')->set(array('vip_status' => 1))->where('id', '=', $order['id'])->execute();
                continue;
            }
            $tr_id = $order['trans_id'];
            $order_total = Customer::instance($order['customer_id'])->get('order_total');
            if(!isset($currency[strtoupper($order['currency'])]))
                continue;
            $current_amount = $order['amount'] / $currency[strtoupper($order['currency'])]['rate'];
            if ($customer == $order['customer_id'])
                $add_amount = $amount + $current_amount;
            else
                $add_amount = $order_total + $current_amount;
            $level = 5;
            $current_vip = array();
            foreach ($vips as $val)
            {
                if ($val['condition'] > $add_amount)
                {
                    $level = $val['level'];
                    $current_vip = $val;
                    break;
                }
            }
            if (empty($current_vip))
                $current_vip = $vips[count($vips) - 1];
            $update = DB::update('accounts_customers')->set(array('order_total' => $add_amount))->where('id', '=', $order['customer_id'])->execute();
            if ($update)
            {
                $update1 = DB::update('orders_orderpayments')->set(array('vip_status' => 1))->where('trans_id', '=', $order['trans_id'])->and_where('customer_id', '=', $order['customer_id'])->execute();
                if (!$update1)
                    continue;
                $c_update = DB::update('accounts_customers')->set(array('vip_level' => $level))->where('id', '=', $order['customer_id'])->execute();
//                 if ($c_update AND !Customer::instance($order['customer_id'])->is_celebrity())
//                 {
//                     $check = substr($order['email'], strpos($order['email'], '@') + 1);
//                     if (!empty($check) && !checkdnsrr($check))
//                     {
//                         $insert = array(
//                             'type' => 3,
//                             'table' => 3,
//                             'table_id' => $order['id'],
//                             'email' => $order['email'],
//                             'status' => 0,
//                             'send_date' => time()
//                         );
//                         DB::insert('mail_logs', array_keys($insert))->values($insert)->execute();
//                         continue;
//                     }
//                     $rcpt = $order['email'];
//                     $from = $webemail;
//                     $subject = 'Congratulations! You are now Choies ' . $called[$level] . ' VIP Member!';
//                     if ($level < 5)
//                         $extra = 'Shop a little more to <span style="color:red;">$' . $current_vip['condition'] . '</span>, you can become our <span style="color:red;">' . $called[$level + 1] . ' VIP</span> Member.<br/>';
//                     else
//                         $extra = '';

//                     $off = ((1 - $current_vip['discount']) * 100);
//                     if($off)
//                         $offinfo = ' extra <span style="color:red;">' . $off . '%</span> off discount for items and';
//                     else
//                         $offinfo = '';
                    
//                     $body = '
// Dear Choieser,<br/>
// <br/>
// Thanks for shopping on Choies.com! You have purchased <span style="color:red;">$' . $add_amount . '</span>, and now you are one of Choies honored <span style="color:red;">' . $called[$level] . ' VIP</span> members. 
// And you can enjoy' . $offinfo . ' <span style="color:red;">' . $current_vip['return'] . '%</span> order points of your product purchase amount. 
// ' . $extra . '
// For more detailed information, please check <a href="http://www.choies.com/vip-policy">VIP Policy</a>.<br/>
// You can also check your VIP Status at any time in <a href="http://www.choies.com/customer/summary">Your Account</a>.<br/>
// <br/>
// ';
// if($called[$level])
// {
//     $body .= '
// Due to yoursupport and trust, our team could become stronger, in order to show our thanksand more importance to you, we set an VIP email account vipservice@choies.com to offer you moreefficient and better service.<br/>
// I am Kelly, the manager of Customer Service and I will pay special attention to every question you raise and try my best to resolve them quickly and efficiently.<br/>
// For VIP members,Choies will push information of fashion trend elements regularly, and hope youwould like it.<br/>
// ';
// }
// else
// {
//     $body .= 'If you have any further questions, please feel free to contact: <br/>
// <a href="mailto:' . $webemail . '">' . $webemail . '</a> or <a href="mailto:lisaconnor@choies.com">lisaconnor@choies.com</a> <br/>';
// }

// $body .= '<br/>
// You may also like our facebook & Twitter:<br/>
// <a href="http://www.facebook.com/choiesofficial">http://www.facebook.com/choiesofficial</a><br/>
// <a href="http://twitter.com/choiescloth">http://twitter.com/choiescloth</a><br/>
// <br/>
// Best Regards,<br/>
// Choies Team
//                                 ';
//                     $send = Mail::Send($rcpt, $from, $subject, $body);
//                     $insert = array(
//                         'type' => 3,
//                         'table' => 3,
//                         'table_id' => $order['id'],
//                         'send_date' => time()
//                     );
//                     if (!$send)
//                     {
//                         $insert['status'] = 0;
//                     }
//                     DB::insert('mail_logs', array_keys($insert))->values($insert)->execute();
//                     $key++;
//                 }
            }
            $count++;
            $customer = $order['customer_id'];
            $amount = $add_amount;
        }
        echo $count . ' orders add to vip system' . '<br>';
        
        // vip refund
        $key = 0;
        $vips = DB::select()->from('vip_types')->execute('slave')->as_array();
        $result = DB::query(Database::SELECT, "SELECT id, trans_id, customer_id, currency, amount FROM order_payments
                                        WHERE vip_status=0 AND payment_status IN ('refund', 'partial_refund')
                                        ORDER BY id LIMIT 0, 20")
                ->execute('slave');
        $count = 0;
        $tr_id = '';
        foreach ($result as $order)
        {
            if ($order['trans_id'] == $tr_id)
            {
                DB::update('orders_orderpayments')->set(array('vip_status' => 1))->where('id', '=', $order['id'])->execute();
                continue;
            }
            $tr_id = $order['trans_id'];
            $order_total = Customer::instance($order['customer_id'])->get('order_total');
            $add_amount = $order_total - abs($order['amount']) / $currency[strtoupper($order['currency'])]['rate'];
            $level = 5;
            foreach ($vips as $val)
            {
                if ($val['condition'] > $add_amount)
                {
                    $level = $val['level'];
                    break;
                }
            }
            if ($add_amount < 0)
                $add_amount = 0;
            $data = array(
                'order_total' => $add_amount,
                'vip_level' => $level
            );
            $update = DB::update('accounts_customers')->set($data)->where('id', '=', $order['customer_id'])->execute();
            if ($update)
            {
                DB::update('orders_orderpayments')->set(array('vip_status' => 1))->where('id', '=', $order['id'])->execute();
            }
            $count++;
        }
        echo $count . ' refunds add to vip system';

        echo '<br>' . date('Y-m-d H:i:s');
        
        echo '<script type="text/javascript">
                window.setInterval(pagerefresh, 10000);
                window.setInterval(logout, 11000);
                function pagerefresh() 
                { 
                    window.open("/news/sendmail1"); 
                }
                function logout()
                {
                    parent.window.opener = null;
                    parent.window.open("", "_self");
                    parent.window.close();
                }
            </script>';
        exit;
    }

    public function action_reviews()
    {
        $content = View::factory('admin/site/lookbook_reviews')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_reviews_data()
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
            foreach ($filters->rules as $item)
            {
                $filter_sql .= " AND " . $item->field . "='" . $item->data . "'";
            }
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM lookbook_reviews WHERE site_id=' . $this->site_id . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM lookbook_reviews WHERE site_id=' . $this->site_id . ' ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach ($result as $review)
        {
            $response['rows'][$i]['id'] = $review['id'];
            $response['rows'][$i]['cell'] = array(
                $review['id'],
                $review['lookbook_id'],
                Customer::instance($review['user_id'])->get('email'),
                $review['content'],
                $review['star'],
                date('Y-m-d', $review['created']),
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_reviews_delete()
    {
        $id = $this->request->param('id');
        $result = DB::select('id')->from('lookbook_reviews')->where('id', '=', $id)->execute('slave')->current();
        if ($result)
        {
            $delete = DB::delete('lookbook_reviews')->where('id', '=', $id)->execute();
            if ($delete)
            {
                message::set(__('Delete loobook reivew success'), 'success');
                Request::instance()->redirect('admin/site/lookbook/reviews');
            }
        }
        else
        {
            message::set(__('Lookbook review not exist'), 'error');
            Request::instance()->redirect('admin/site/lookbook/reviews');
        }
    }

    public function action_product_catalog()
    {
        $products = DB::select()->from('products_product')->execute('slave')->as_array();
        $success = '';
        $amount = 0;
        foreach ($products as $product)
        {
            $default_catalog = Product::instance($product['id'])->default_catalog();
            if ($default_catalog AND !Product::instance($product['id'])->get('default_catalog'))
            {
                $result = DB::query(Database::UPDATE, 'UPDATE products SET default_catalog = ' . $default_catalog . ' WHERE id = ' . $product['id'] . ' AND default_catalog = 0')->execute();
                if ($result)
                {
                    $amount++;
                    $success .= Product::instance($product['id'])->get('sku') . '<br>';
                }
            }
        }
        echo $amount . ' products update success:<br>';
        echo $success;
    }

    public function action_phpinfo()
    {
        phpinfo();
        exit;
    }

    public function action_memcache()
    {
        $key = 'lookbook';
        if (!Cache::instance('memcache')->get($key))
        {
            $view = View::factory('admin/site/lookbook_list')->render();
            Cache::instance('memcache')->set($key, $view, 300);
        }
        else
        {
            $view = Cache::instance('memcache')->get($key);
        }

        $this->request->response = View::factory('admin/template')->set('content', $view)->render();
    }

    public function action_mkdir()
    {
        $resource_dir = '/home/data/www/htdocs/clothes/uploads';
        $file_dir = $resource_dir . '/1/files1';
        if (!is_dir($file_dir))
        {
            mkdir($file_dir, 0777);
            chmod($file_dir, 0777);
        }
    }

    public function action_freebie()
    {
        $orders = DB::query(Database::SELECT, 'SELECT orders.id, orders.shipping_firstname, orders.created, freebies.id AS fid,freebies.sku
FROM orders, freebies
WHERE orders.email = freebies.email
AND freebies.product_id =8398
AND orders.created >=1374712200')->execute('slave')->as_array();
        foreach ($orders as $order)
        {
            DB::update('freebies')->set(array('order_id' => $order['id']))->where('id', '=', $order['fid'])->execute();
        }
    }

    public function action_paypal()
    {
        $orderArr = array(
//                    10358491340 => array('Momoiroshop!','USD','113.34','-3.93','109.41','aqua112894@yahoo.com','5CX812743D627505D','','','','','296 fusteria ct.','','fremont','CA','94539','United States','925-202-1031')
        );
        foreach ($orderArr as $ordernum => $pp_return)
        {
            $order = Order::instance(Order::get_from_ordernum($ordernum));
            if ($order->get('payment_status') != 'verify_pass')
            {
                $country_code = DB::select('isocode')->from('countries')->where('name', '=', $pp_return[16])->execute('slave')->get('isocode');
                $name = explode(' ', $pp_return[0]);
                $request = array(
                    'payment_status' => 'Completed',
                    'mc_gross' => $pp_return[2],
                    'mc_currency' => $pp_return[1],
                    'txn_id' => $pp_return[6],
                    'first_name' => $name[0],
                    'last_name' => $name[1],
                    'address_street' => $pp_return[11] . ' ' . $pp_return[12],
                    'address_zip' => $pp_return[15],
                    'address_city' => $pp_return[13],
                    'address_state' => $pp_return[14],
                    'address_country_code' => $country_code,
                    'contact_phone' => $pp_return[17],
                    'payer_email' => $pp_return[5],
                    'receiver_email' => 'craigwhitmore1978@gmail.com'
                );
//                                print_r($request);exit;
                if ($coupon = $order->get('coupon_code'))
                    Coupon::instance($coupon)->apply();
                if ($request['payment_status'] == 'Completed')
                {
                    $amount = $request['mc_gross'];
                    if ($amount > 0)
                    {
                        Event::run('Order.payment', array(
                            'amount' => (int) $amount,
                            'order' => $order,
                        ));
                    }
                }
                $status = Payment::instance('PP')->pay($order->get(), $request);
                echo strtoupper($status) . '<br>';
            }
        }
    }

    public function action_sync_return()
    {
        if ($_POST)
        {
            $string = Arr::get($_POST, 'orders', '');
            $orders = explode("\n", $string);
            foreach ($orders as $onum)
            {
                $oid = Order::get_from_ordernum(trim($onum));
                $order = Order::instance($oid)->get();
                if ($order['amount'] <= 0)
                    continue;
                $payments = DB::select()->from('orders_orderpayments')->where('order_id', '=', $oid)->and_where('payment_status', '=', 'success')->and_where('amount', '>', 0)->execute('slave')->current();
                if (empty($payments))
                    continue;
                $post_var = "order_num=" . $order['ordernum']
                    . "&order_amount=" . $payments['amount']
                    . "&order_currency=" . $payments['currency']
                    . "&card_num=" . $order['cc_num']
                    . "&card_type=" . $order['cc_type']
                    . "&card_cvv=" . $order['cc_cvv']
                    . "&card_exp_month=" . $order['cc_exp_month']
                    . "&card_exp_year=" . $order['cc_exp_year']
                    . "&card_inssue=" . $order['cc_issue']
                    . "&card_valid_month=" . $order['cc_valid_month']
                    . "&card_valid_year=" . $order['cc_valid_year']
                    . "&billing_firstname=" . $payments['first_name']
                    . "&billing_lastname=" . $payments['last_name']
                    . "&billing_address=" . $payments['address']
                    . "&billing_zip=" . $payments['zip']
                    . "&billing_city=" . $payments['city']
                    . "&billing_state=" . $payments['state']
                    . "&billing_country=" . $payments['country']
                    . "&billing_telephone=" . ''
                    . "&billing_ip_address=" . long2ip($order['ip'])
                    . "&billing_email=" . $order['email']
                    . "&shipping_firstname=" . $order['shipping_firstname']
                    . "&shipping_lastname=" . $order['shipping_lastname']
                    . "&shipping_address=" . $order['shipping_address']
                    . "&shipping_zip=" . $order['shipping_zip']
                    . "&shipping_city=" . $order['shipping_city']
                    . "&shipping_state=" . $order['shipping_state']
                    . "&shipping_country=" . $order['shipping_country']
                    . "&shipping_telephone=" . $order['shipping_phone']
                    . '&trans_id=' . $payments['trans_id']
                    . '&payer_email=' . $payments['email']
                    . '&receiver_email=' . $order['email']
                    . "&is_extra_pp=" . ($order['amount'] <= 10 ? '1' : '0')
                    . "&site_id=" . Site::instance()->get('cc_payment_id')
                    . "&secure_code=" . Site::instance()->get('cc_secure_code');
                if ($order['payment_method'] == 'PP')
                {
                    $result = Toolkit::curl_pay('http://manage.choiesriskcontrol.com/pp', $post_var);
                }
                else
                {
                    $post_var .= "&status=1";
                    $result = Toolkit::curl_pay('http://manage.choiesriskcontrol.com/globebill', $post_var);
                }
                echo $result;
                echo '<br>';
            }
        }
        else
            echo '
<form method="post" action="">
Ordernum:<br/>
<textarea name="orders" cols="40" rows="20"></textarea><br/>
<input type="submit" value="Submit" />
</form>                        
';
    }
    
    public function action_globebill_payment()
    {
        $orders = array(
            '10904411340'=>array('2014011507500494139995','2014-01-15 07:50:58'),
            '10903801340'=>array('2014011505231687890762','2014-01-15 05:24:33'),
            '10903721340'=>array('2014011504582466687555','2014-01-15 05:00:16'),
            '10903371340'=>array('2014011503274566232595','2014-01-15 03:27:45'),
            '10902681340'=>array('2014011501555220922921','2014-01-15 01:56:32'),
            '10903041340'=>array('2014011501553247901952','2014-01-15 01:55:33'),
            '10902151340'=>array('2014011420582685278099','2014-01-14 20:58:54'),
            '10901091340'=>array('2014011411370933205246','2014-01-14 11:41:49'),
            '10900591340'=>array('2014011408072861786068','2014-01-14 08:28:51'),
            '10899581340'=>array('2014011402490390379658','2014-01-14 02:50:23'),
            '10898221340'=>array('2014011318311539145430','2014-01-13 18:32:41'),
            '10896791340'=>array('2014011306140355339275','2014-01-13 06:15:50'),
            '10912341340'=>array('2014011707005541213386','2014-01-17 07:02:25'),
            '10911691340'=>array('2014011703385459829368','2014-01-17 03:39:42'),
            '10911221340'=>array('2014011701122750213163','2014-01-17 01:14:17'),
            '10910321340'=>array('2014011621075812396414','2014-01-16 21:08:39'),
            '10908581340'=>array('2014011607164071803524','2014-01-16 07:18:30'),
            '10908381340'=>array('2014011606041793775842','2014-01-16 06:22:09'),
            '10908291340'=>array('2014011605410588092601','2014-01-16 05:41:05'),
            '10908061340'=>array('2014011605002728511030','2014-01-16 05:02:11'),
            '10907971340'=>array('2014011604401466875916','2014-01-16 04:42:54'),
            '10907771340'=>array('2014011603594458585223','2014-01-16 03:59:45'),
            '10865211340'=>array('2014011603560782138022','2014-01-16 03:58:40'),
            '10907571340'=>array('2014011603210762917397','2014-01-16 03:23:52'),
            '10907251340'=>array('2014011601444452181835','2014-01-16 01:45:51'),
            '10906121340'=>array('2014011519374341834342','2014-01-15 19:39:35'),
            '10905321340'=>array('2014011514122925090080','2014-01-15 14:15:36'),
        );
        foreach($orders as $ordernum => $order)
        {
            $order_id = Order::get_from_ordernum($ordernum);
            $has = DB::select('id')
                ->from('orders_orderpayments')
                ->where('order_id', '=', $order_id)
                ->where('payment_method', '=', 'globebill')
                ->where('payment_status', '=', 'success')
                ->execute()->get('id');
            if($has)
                continue;
            $data = array(
                'site_id' => 1,
                'order_id' => $order_id,
                'customer_id' => Order::instance($order_id)->get('customer_id'),
                'payment_method' => 'globebill',
                'trans_id' => $order[0],
                'amount' => Order::instance($order_id)->get('amount'),
                'currency' => Order::instance($order_id)->get('currency'),
                'comment' => '0000_Approved',
                'payment_status' => 'success',
                'ip' => Order::instance($order_id)->get('ip'),
                'created' => strtotime($order[1]),
                'first_name' => Order::instance($order_id)->get('shipping_firstname'),
                'last_name' => Order::instance($order_id)->get('shipping_lastname'),
                'email' => Order::instance($order_id)->get('email'),
                'address' => Order::instance($order_id)->get('shipping_address'),
                'city' => Order::instance($order_id)->get('shipping_city'),
                'state' => Order::instance($order_id)->get('shipping_state'),
                'country' => Order::instance($order_id)->get('shipping_country'),
                'zip' => Order::instance($order_id)->get('shipping_zip'),
                'phone' => Order::instance($order_id)->get('shipping_phone'),
            );
            $insert = DB::insert('orders_orderpayments', array_keys($data))->values($data)->execute();
            if($insert)
            {
                DB::update('orders_order')->set(array('payment_status' => 'success'))->where('id', '=', $order_id)->execute();
                echo $ordernum . ' Import Success<br>';
            }
        }
    }

    public function action_pending_return()
    {
        if ($_POST)
        {
            $string = Arr::get($_POST, 'orders', '');
            $orders = explode("\n", $string);
            foreach ($orders as $onum)
            {
                $oid = Order::get_from_ordernum(trim($onum));
                $order = Order::instance($oid)->get();
                if ($order['amount'] <= 0)
                    continue;
                if ($order['payment_status'] != 'pending')
                    continue;
                $payments = DB::select()->from('orders_orderpayments')->where('order_id', '=', $oid)->and_where('payment_status', '=', 'pending')->and_where('amount', '>', 0)->execute('slave')->current();
                if (empty($payments))
                    continue;
                DB::update('orders_order')->set(array('payment_status' => 'success'))->where('id', '=', $oid)->execute();
                DB::update('orders_orderpayments')->set(array('payment_status' => 'success'))->where('order_id', '=', $oid)->and_where('payment_status', '=', 'pending')->execute();
                $post_var = "order_num=" . $order['ordernum']
                    . "&order_amount=" . $payments['amount']
                    . "&order_currency=" . $payments['currency']
                    . "&card_num=" . $order['cc_num']
                    . "&card_type=" . $order['cc_type']
                    . "&card_cvv=" . $order['cc_cvv']
                    . "&card_exp_month=" . $order['cc_exp_month']
                    . "&card_exp_year=" . $order['cc_exp_year']
                    . "&card_inssue=" . $order['cc_issue']
                    . "&card_valid_month=" . $order['cc_valid_month']
                    . "&card_valid_year=" . $order['cc_valid_year']
                    . "&billing_firstname=" . $payments['first_name']
                    . "&billing_lastname=" . $payments['last_name']
                    . "&billing_address=" . $payments['address']
                    . "&billing_zip=" . $payments['zip']
                    . "&billing_city=" . $payments['city']
                    . "&billing_state=" . $payments['state']
                    . "&billing_country=" . $payments['country']
                    . "&billing_telephone=" . ''
                    . "&billing_ip_address=" . long2ip($order['ip'])
                    . "&billing_email=" . $order['email']
                    . "&shipping_firstname=" . $order['shipping_firstname']
                    . "&shipping_lastname=" . $order['shipping_lastname']
                    . "&shipping_address=" . $order['shipping_address']
                    . "&shipping_zip=" . $order['shipping_zip']
                    . "&shipping_city=" . $order['shipping_city']
                    . "&shipping_state=" . $order['shipping_state']
                    . "&shipping_country=" . $order['shipping_country']
                    . "&shipping_telephone=" . $order['shipping_phone']
                    . '&trans_id=' . $payments['trans_id']
                    . '&payer_email=' . $payments['email']
                    . '&receiver_email=' . $order['email']
                    . "&is_extra_pp=" . ($order['amount'] <= 10 ? '1' : '0')
                    . "&site_id=" . Site::instance()->get('cc_payment_id')
                    . "&secure_code=" . Site::instance()->get('cc_secure_code');
                if ($order['payment_method'] == 'PP')
                {
                    $result = Toolkit::curl_pay(Site::instance()->get('pp_sync_url'), $post_var);
                }
                elseif ($order['payment_method'] == 'GLOBEBILL')
                {
                    $post_var .= "&status=1";
                    $result = Toolkit::curl_pay('https://www.shuiail.com/globebill', $post_var);
                }
                var_dump($result);
                echo '<br>';
            }
        }
        else
            echo '
<form method="post" action="">
Pending Ordernum:<br/>
<textarea name="orders" cols="40" rows="20"></textarea><br/>
<input type="submit" value="Submit" />
</form>                        
';
    }

    public function action_catalogTree()
    {
        $current_catalog = 162;
        $product = 10460;
        $menu_tree = Catalog::instance()->menu_tree(159);
        $relates = array();
        $products = Catalog::instance($current_catalog)->products();
        {
            $key = array_keys($products, 10460);
            if ($key[0] <= count($products))
                $relates[] = $products[$key[0] + 1];
            else
                $relates[] = $products[0];
        }
        foreach ($menu_tree as $catalog)
        {
            if ($catalog['id'] != $current_catalog)
            {
                $products1 = Catalog::instance($catalog['id'])->products();
                $key1 = ceil($key / count($products));
                $relates[] = $products1[$key1];
            }
        }
        print_r($relates);
        exit;
    }

    public function action_celebrity()
    {
        $celebritys = DB::select('id', 'email')->from('celebrities_celebrits')->where('customer_id', '=', 0)->limit(500)->offset(0)->execute('slave');
        foreach ($celebritys as $cel)
        {
            $customer_id = DB::select('id')->from('accounts_customers')->where('email', '=', trim($cel['email']))->execute('slave')->get('id');
            if ($customer_id)
            {
                DB::update('celebrities_celebrits')->set(array('customer_id' => $customer_id))->where('id', '=', $cel['id'])->execute();
            }
        }
    }

    public function action_products()
    {

        $catalogs = array(149, 150, 151, 152, 153, 154);
        foreach ($catalogs as $catalog_id)
        {
            $products = DB::query(Database::SELECT, 'SELECT products.id
                                        FROM `catalog_products` LEFT JOIN products ON catalog_products.product_id = products.id
                                        WHERE catalog_products.catalog_id = ' . $catalog_id . ' ORDER BY products.id')
                    ->execute('slave')->as_array();
            $key = 0;
            $skus = Arr::get($_POST, 'skus', '');
            if (!$skus)
                exit;
            $skuArr = explode("\n", trim($skus));
            $products = DB::select('sku', 'description', 'attributes')->from('products_product')->where('sku', 'IN', $skuArr)->execute('slave');
            header("Content-type:application/vnd.ms-excel; charset=UTF-8");
            header('Content-Disposition: attachment; filename="products' . date('Y-m-d') . '.csv"');
            echo "\xEF\xBB\xBF" . "SKU,Description,Attributes\n";
            foreach ($products as $product)
            {
                DB::update('catalog_products')->set(array('position' => $key))
                    ->where('catalog_id', '=', $catalog_id)
                    ->and_where('product_id', '=', $product['id'])
                    ->execute();
                $key++;
            }
        }
    }

    public function action_globebill()
    {
        $_REQUEST = array(
//                    'merNo'          => 10040,
//                    'gatewayNo'      => '10040001',
//                    'tradeNo'        => '2013071217560052659520',
//                    'orderNo'        => '10338261340',
//                    'orderAmount'    => 33.86,
//                    'orderCurrency'  => 'EUR',
//                    'orderStatus'    => 1,
//                    'orderInfo'      => '0000_Approved',
//                    'signInfo'       => '4C55F0E037F57C102EC1A954ADDB5BCF310B2332A38BBF3D4C8BC48C77844C9E',
//                    'remark'         => '',
//                    'riskInfo'       => '||sourceUrl=10.0;BinCountry=100.0;BlackList=100.0;Amount=100.0;PayNum=100.0;|0.0|100.0|9.5|Commonwealth|AU|15069|110.174.29.59|AU|',
//                    'authTypeStatus' => 0,
//                    'cardNo'         => '521729***9592',
//                    'EbanxBarCode'   => '',
//                    'isPush'         => 0
        );
        //MD5key和商户id，固定值 商户号为10032，新接口
        $is_pay_insite = Site::instance()->get('is_pay_insite');

        $merNo = $_REQUEST['merNo'];
        $gatewayNo = $_REQUEST['gatewayNo'];
        $tradeNo = $_REQUEST["tradeNo"];  //交易号

        if (!$tradeNo)
        {   //钱宝拒绝交易，交易号为空
            if ($is_pay_insite)
            {
                echo '<script language="javascript">top.location.replace("http://' . Site::instance()->get('domain') . '/customer/orders");</script>';
            }
            else
            {
                $this->request->redirect('/customer/orders');
            }
            exit;
        }
        $BillNo = $_REQUEST["orderNo"];      //订单号
        $Succeed = $_REQUEST["orderStatus"];            //交易成功状态 1=成功，0=失败 -1 待处理 -2 待确认
        $PayCurrency = $_REQUEST["orderCurrency"];    //币种代码，如：GBP
        $Amount = $_REQUEST["orderAmount"];              //交易金额
        $Result = $_REQUEST["orderInfo"];     //交易详情
        $signInfo = $_REQUEST["signInfo"];
        $remark = $_REQUEST["remark"];
        $riskInfo = $_REQUEST["riskInfo"];

        //是否推送，isPush:1则是推送，为空则是POST返回
        $isPush = isset($_REQUEST['isPush']) AND $_REQUEST['isPush'] == '1' ? '1' : '';
        if ($isPush == '1')
        {
            if (substr($Result, 0, 5) == 'I0061')  //排除订单号重复(I0061)的交易
            {
                
            }
            else
            {
                $order_id = Order::get_from_ordernum($BillNo);
                $order = Order::instance($order_id)->get();
                if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                {
                    exit;
                }

//                                $success = DB::select('id')->from('orders_orderpayments')
//                                        ->where('order_id', '=', $order_id)
//                                        ->and_where('payment_method', '=', 'globebill')
//                                        ->and_where('payment_status', '=', 'success')
//                                        ->execute('slave');
//                                if($success)
//                                {
//                                        exit;
//                                }
                //积分添加
                if ($Succeed)
                {
                    $amounts = $Amount;
                    $order1 = Order::instance(Order::get_from_ordernum($BillNo));

                    // Add daily hits
                    $products = unserialize($order1->get('products'));
                    foreach ($products as $product)
                    {
                        Product::instance($product['id'])->daily_hits($product['quantity']);
                    }

                    kohana_log::instance()->add('GLOBEBILL_POINTS', $amounts);
                    if ($amounts > 0)
                    {
                        Event::run('Order.payment', array(
                            'amount' => (int) $amounts,
                            'order' => $order1,
                        ));
                    }
                }

                //md5校验码 固定格式：md5($BillNo.$Currency.$Amount.$Succeed.$MD5key)
                //$md5src = $BillNo . $Currency . $Amount . $Succeed . $MD5key;
                //$md5sign = strtoupper(md5($md5src));

                $data = array();
                $data['order_num'] = $BillNo;
                $data['verify_code'] = '';
                $data['trans_id'] = $tradeNo;
                $data['message'] = $Result;
                $data['succeed'] = $Succeed;
                $data['avs'] = '';
                $data['api'] = '';
                $data['status'] = '';
                $data['billing_firstname'] = '';
                $data['billing_lastname'] = '';
                $data['billing_address'] = '';
                $data['billing_zip'] = '';
                $data['billing_city'] = '';
                $data['billing_state'] = '';
                $data['billing_country'] = '';
                $data['billing_ip'] = '';
                $data['billing_email'] = '';
                $data['cardnum'] = '';
                $data['BankID'] = '';
                $data['merno'] = $merNo;
                $data['signInfo'] = $signInfo;
                $data['gatewayNo'] = $gatewayNo;

                $ordernum = $BillNo;
                Payment::instance('GLOBEBILL')->pay($order, $data);
            }
        }
        elseif ($isPush == '')
        {
            if (substr($Result, 0, 5) == 'I0061')  //排除订单号重复(I0061)的交易
            {
                Message::set(__('Your order is processing'), 'notice');
                if ($is_pay_insite)
                {
                    echo '<script language="javascript">top.location.replace("http://' . Site::instance()->get('domain') . '/payment/success/' . $BillNo . '");</script>';
                }
                else
                {
                    $this->request->redirect('http://' . Site::instance()->get('domain') . '/payment/success/' . $BillNo);
                }
            }
            else
            {
                $order = Order::instance(Order::get_from_ordernum($ordernum))->get();
                if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                {
                    echo '<script language="javascript">top.location.replace("http://' . Site::instance()->get('domain') . '/payment/success/' . $order['ordernum'] . '");</script>';
                    exit;
                }

                //积分添加
                if ($Succeed)
                {
                    $amounts = $Amount;
                    $order1 = Order::instance(Order::get_from_ordernum($BillNo));

                    // Add daily hits
                    $products = unserialize($order1->get('products'));
                    foreach ($products as $product)
                    {
                        Product::instance($product['id'])->daily_hits($product['quantity']);
                    }

                    kohana_log::instance()->add('GLOBEBILL_POINTS', $amounts);
                    if ($amounts > 0)
                    {
                        Event::run('Order.payment', array(
                            'amount' => (int) $amounts,
                            'order' => $order1,
                        ));
                    }
                }

                //md5校验码 固定格式：md5($BillNo.$Currency.$Amount.$Succeed.$MD5key)
                //$md5src = $BillNo . $Currency . $Amount . $Succeed . $MD5key;
                //$md5sign = strtoupper(md5($md5src));

                $data = array();
                $data['order_num'] = $BillNo;
                $data['verify_code'] = '';
                $data['trans_id'] = $tradeNo;
                $data['message'] = $Result;
                $data['succeed'] = $Succeed;
                $data['avs'] = '';
                $data['api'] = '';
                $data['status'] = '';
                $data['billing_firstname'] = '';
                $data['billing_lastname'] = '';
                $data['billing_address'] = '';
                $data['billing_zip'] = '';
                $data['billing_city'] = '';
                $data['billing_state'] = '';
                $data['billing_country'] = '';
                $data['billing_ip'] = '';
                $data['billing_email'] = '';
                $data['cardnum'] = '';
                $data['BankID'] = '';
                $data['merno'] = $merNo;
                $data['signInfo'] = $signInfo;
                $data['gatewayNo'] = $gatewayNo;

                $result = Payment::instance('GLOBEBILL')->pay($order, $data);

                switch ($result)
                {
                    case 'SUCCESS':
                        Message::set(__('order_create_success'), 'notice');
                        if ($is_pay_insite)
                        {
                            echo '<script language="javascript">top.location.replace("http://' . Site::instance()->get('domain') . '/payment/success/' . $order['ordernum'] . '");</script>';
                        }
                        else
                        {
                            $this->request->redirect('http://' . Site::instance()->get('domain') . '/payment/success/' . $order['ordernum']);
                        }
                        break;
                    case 'PENDING':
                        if ($is_pay_insite)
                        {
                            echo '<script language="javascript">top.location.replace("http://' . Site::instance()->get('domain') . '/payment/success/' . $order['ordernum'] . '");</script>';
                        }
                        else
                        {
                            $this->request->redirect('http://' . Site::instance()->get('domain') . '/payment/success/' . $order['ordernum']);
                        }
                        break;
                    case 'FAILED':
                        Message::set(__($Result), 'error');
                        if ($is_pay_insite)
                        {
                            echo '<script language="javascript">top.location.replace("http://' . Site::instance()->get('domain') . '/cart/shipping_billing/' . $order['ordernum'] . '");</script>';
                        }
                        else
                        {
                            $this->request->redirect('http://' . Site::instance()->get('domain') . '/cart/shipping_billing/' . $order['ordernum']);
                        }
                        break;
                }
            }
        }
    }

    public function action_points()
    {
        $date = 1373616279;
        $result = DB::select()->from('accounts_point_records')
            ->where('created', '>=', $date)
            ->and_where('type', '=', 'order')
            ->and_where('status', '=', 'activated')
            ->and_where('amount', '>', 0)
            ->and_where('id', '>', 10000000000)
            ->execute('slave');
        foreach ($result as $data)
        {
            DB::query(Database::UPDATE, 'UPDATE accounts_customers SET points=points+' . $data['amount'] . ' WHERE id=' . $data['customer_id'])->execute();
            echo $data['customer_id'] . '<br>';
        }
    }

    public function action_vip()
    {
        $customers = array(
            62195
        );

        $vips = DB::select()->from('vip_types')->execute('slave')->as_array();
        foreach ($customers as $id)
        {
            $success = DB::query(Database::SELECT, 'SELECT sum(amount) as sum FROM order_payments 
                                WHERE payment_status = "success" AND customer_id=' . $id)->execute('slave')->get('sum');
            $refund = DB::query(Database::SELECT, 'SELECT sum(amount) as sum FROM order_payments 
                                WHERE payment_status IN ("refund", "partial_refund") AND customer_id=' . $id)->execute('slave')->get('sum');
            $order_total = $success - (float) $refund;
            if ($order_total < 0)
                $order_total = 0;
            $level = 5;
            foreach ($vips as $val)
            {
                if ($val['condition'] > $order_total)
                {
                    $level = $val['level'];
                    break;
                }
            }
            $update = array(
                'order_total' => $order_total,
                'vip_level' => $level
            );
            DB::update('accounts_customers')->set($update)->where('id', '=', $id)->execute();
        }
    }

    public function action_customers()
    {
        $result = DB::query(Database::SELECT, 'SELECT id FROM customers 
                        WHERE customers.ip = 2147483647 limit 0, 5000')->execute('slave');
        foreach ($result as $customer)
        {
            $ip = DB::select('ip')->from('orders_order')->where('customer_id', '=', $customer['id'])->and_where('ip', 'NOT IN', array(0, 2147483647))->execute('slave')->get('ip');
            if ($ip)
            {
                echo 'UPDATE accounts_customers SET ip=' . $ip . ' WHERE id=' . $customer['id'];
                exit;
                DB::query(Database::UPDATE, 'UPDATE accounts_customers SET ip=' . $ip . ' WHERE id=' . $customer['id'])->execute();
                echo $customer['id'] . '-' . $ip . '<br>';
            }
        }
    }

    public function action_activity()
    {
        $skurange = array(
        );
        $created = strtotime('2013-08-29');
        $comments = DB::select()->from('giveaway')->where('created', '>', $created)->and_where('urls', '<>', '')->order_by('created', 'desc')->execute('slave')->as_array();
        foreach ($comments as $comment)
        {
            $skus = explode(',', $comment['sku']);
            foreach ($skus as $sku)
            {
                if (!in_array($sku, $skurange))
                    unset($skus);
            }
            if (count($skus) < 4)
            {
                echo $comment['id'] . '<br>';
//                                DB::delete('giveaway')->where('id', '=', $comment['id'])->execute();
            }
        }
    }

    public function action_vip1()
    {
        echo 'Success customers:<br>';
        $currency = Site::instance()->currencies();
        $vips = DB::select()->from('vip_types')->execute('slave')->as_array();
        $result = DB::select('id', 'order_total')->from('accounts_customers')->where('vip_level', '=', 2)->limit(500)->offset(1000)->execute('slave');
        foreach ($result as $c)
        {
            $payments = DB::select('amount', 'currency', 'payment_status')
                    ->from('orders_orderpayments')
                    ->where('customer_id', '=', $c['id'])
                    ->and_where('payment_status', 'IN', array('success', 'refund', 'partial_refund'))
                    ->and_where('vip_status', '=', 1)
                    ->execute('slave')->as_array();
            $total = 0;
            foreach ($payments as $p)
            {
                if ($p['payment_status'] == 'success')
                    $total += $p['amount'] / $currency[strtoupper($p['currency'])]['rate'];
                elseif ($p['payment_status'] == 'refund' OR $p['payment_status'] == 'partial_refund')
                    $total -= abs($p['amount']) / $currency[strtoupper($p['currency'])]['rate'];
            }
            if ($total - $c['order_total'] > 2)
            {
                $level = 5;
                foreach ($vips as $val)
                {
                    if ($val['condition'] > $total)
                    {
                        $level = $val['level'];
                        break;
                    }
                }
                $data = array(
                    'order_total' => round($total, 4),
                    'vip_level' => $level
                );
                $update = DB::update('accounts_customers')->set($data)->where('id', '=', $c['id'])->execute();
                if ($update)
                    echo $c['id'] . '<br>';
            }
        }
    }

    public function action_order_products()
    {
        $products = DB::query(Database::SELECT, 'SELECT id, sku, factory FROM products WHERE factory LIKE "%小单%"')
            ->execute('slave');
        foreach ($products as $p)
        {
            $sales = DB::query(Database::SELECT,'SELECT SUM(i.quantity) AS sum FROM order_items i LEFT JOIN orders o ON i.order_id=o.id 
                WHERE i.product_id = '.$p['id'].' AND o.payment_status="verify_pass" AND o.is_active=1 AND i.status <> "cancel"')
                ->execute('slave')->get('sum');
            echo $p['sku'] . ' ' . $p['factory'] . ' ' . (int) $sales . '<br>';
        }
    }

    public function action_order_products1()
    {
        $time = strtotime('2013-08-01');
        $today = strtotime('midnight');
        while ($time < $today)
        {
            $nextday = $time + 86400;
            $products = DB::query(Database::SELECT, 'SELECT DISTINCT i.product_id FROM order_items i LEFT JOIN orders o ON i.order_id=o.id
                                        WHERE o.payment="verify_pass" AND i.status <> "cancel" AND o.created >= ' . $time . ' AND o.created < ' . $nextday)
                    ->execute('slave')->as_array();
            echo date('Y-m-d', $time) . ' ' . count($products) . '<br>';
            $time += 86400;
        }
    }

    public function action_order_products2()
    {
        $time = strtotime('2013-08-01');
        $today = strtotime('midnight');
        while ($time < $today)
        {
            $nextday = $time + 86400;
            $products = DB::query(Database::SELECT, 'SELECT i.product_id FROM order_items i LEFT JOIN orders o ON i.order_id=o.id
                                        WHERE o.payment_status="verify_pass" AND i.status <> "cancel" AND o.created >= ' . $time . ' AND o.created < ' . $nextday . ' ORDER BY i.product_id')
                    ->execute('slave')->as_array();
            $counts = array();
            foreach ($products as $product)
            {
                $counts[$product['product_id']]++;
            }
            rsort($counts);
            $threes = 0;
            $overthree = array();
            foreach ($counts as $count)
            {
                if ($count >= 3)
                {
                    $threes++;
                    $overthree[$count]++;
                }
                else
                    break;
            }
            ksort($overthree);
            $detail = '';
            foreach ($overthree as $num => $val)
            {
                $detail .= $num . 's:' . $val . ' ';
            }
            echo date('Y-m-d', $time) . ' ' . $threes . ' ' . $detail . '<br>';
            $time += 86400;
        }
    }

    public function action_cel_products()
    {
        $skus = array(
        );

        foreach ($skus as $sku)
        {
            $sum = DB::query(DATABASE::SELECT, 'SELECT SUM(order_items.quantity) AS sum FROM celebrits,orders,order_items 
                                                WHERE celebrits.email=orders.email AND orders.id=order_items.order_id AND orders.payment_status="verify_pass" 
                                                AND order_items.status != "cancel" AND order_items.sku = "' . $sku . '"')->execute('slave')->get('sum');
            echo $sku . ' ' . $sum . '<br>';
        }
    }

    public function action_cel_orders()
    {
        $from = strtotime('2013-09-01');
        $to = strtotime('2013-10-01');
        $result = DB::query(Database::SELECT, 'SELECT id, ordernum, amount_products, customer_id, email FROM orders WHERE created >= ' . $from . ' AND created < ' . $to . ' AND payment_status="verify_pass" AND is_active=1')
            ->execute('slave');
//                var_dump($result);exit;
        foreach ($result as $order)
        {
            if (Customer::instance($order['customer_id'])->is_celebrity())
            {
                $admin = DB::select('admin')->from('celebrities_celebrits')->where('email', '=', $order['email'])->execute('slave')->get('admin');
                $amount = 0;
                $products = DB::select('product_id')->from('orders_orderitem')->where('order_id', '=', $order['id'])->and_where('status', '<>', 'cancel')->execute('slave');
                foreach ($products as $p)
                {
                    $amount += Product::instance($p['product_id'])->get('price');
                }
                echo $order['ordernum'] . ' ' . $amount . ' ' . User::instance($admin)->get('name') . '<br>';
            }
        }
    }

    public function action_order_items()
    {
        $orders = DB::query(Database::SELECT, 'SELECT o.ordernum, o.customer_id, o.email, o.shipping_firstname, o.shipping_lastname, o.shipping_country, o.ip, o.created, i.product_id, i.sku, i.price FROM 
                        order_items i LEFT JOIN orders o ON i.order_id=o.id WHERE o.is_active = 1 AND o.payment_status = "verify_pass" AND o.amount > 0 AND i.status <> "cancel" ORDER BY o.customer_id')
            ->execute('slave');
        header("Content-type:application/vnd.ms-excel; charset=UTF-8");
        header('Content-Disposition: attachment; filename="customer_orders.csv"');
        echo "\xEF\xBB\xBF" . "用户ID,用户邮箱,用户姓名,用户IP地址,用户下单填写的国家,已经寄出的订单号,下单时间,订单中的sku,原价,实际销售价\n";
        foreach ($orders as $order)
        {
            echo $order['customer_id'] . ',';
            echo $order['email'] . ',';
            echo $order['shipping_firstname'] . ' ' . $order['shipping_lastname'] . ',';
            echo long2ip($order['ip']) . ',';
            echo $order['shipping_country'] . ',';
            echo $order['ordernum'] . ',';
            echo date('Y-m-d', $order['created']) . ',';
            echo $order['sku'] . ',';
            $price = Product::instance($order['product_id'])->get('price');
            echo $price . ',';
            echo $order['price'] . "\n";
        }
    }

    public function action_ppec()
    {
        $result = DB::query(Database::SELECT, 'SELECT * FROM `orders_order` WHERE `payment_method` = "PPEC" ORDER BY `customer_id` ASC')->execute('slave');
        $customer = 0;
        $success = array();
        foreach ($result as $data)
        {
            if ($data['customer_id'] == $customer)
                continue;
            if (!$data['shipping_address'])
                continue;
            $has_add = DB::select('id')->from('accounts_address')->where('customer_id', '=', $data['customer_id'])->execute('slave')->get('id');
            if (!$has_add)
            {
                $add = array(
                    'site_id' => 1,
                    'customer_id' => $data['customer_id'],
                    'firstname' => $data['shipping_firstname'],
                    'lastname' => $data['shipping_lastname'],
                    'address' => $data['shipping_address'],
                    'city' => $data['shipping_city'],
                    'zip' => $data['shipping_zip'],
                    'state' => $data['shipping_state'],
                    'country' => $data['shipping_country'],
                    'phone' => $data['shipping_phone'],
                    'cpf' => $data['shipping_cpf']
                );
                DB::insert('accounts_address', array_keys($add))->values($add)->execute();
                $success[] = $data['customer_id'];
            }
            $customer = $data['customer_id'];
        }
        echo 'Success Customer:<br>';
        echo implode('<br>', $success);
    }

    public function action_set_products()
    {
        $result = DB::select('id', 'sku')->from('products_product')->where('set_id', '=', 374)->execute('slave');
        foreach ($result as $product)
        {
            $price = Product::instance($product['id'])->price();
            echo $product['sku'] . ' ' . $price . '<br>';
        }
    }
    
    public function action_simage_delete()
    {
        if($_POST)
        {
            require 'inc_config.php';
            $dir = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'simages' . DIRECTORY_SEPARATOR;
            $images = Arr::get($_POST, 'images', '');
            $imageArr = explode("\n", $images);
            foreach($imageArr as $img)
            {
                $img = trim($img);
                if(file_exists($dir . $img))
                {
                    unlink($dir . $img);
                }
            }
        }
        echo '
<form method="post" action="">
Images:<br/>
<textarea name="images" cols="40" rows="20"></textarea><br/>
<input type="submit" value="Submit" />
</form>                        
';
    }
    
    public function action_sis_delete()
    {
        if($_POST)
        {
            $ids = Arr::get($_POST, 'id', '');
            $idArr = explode("\n", $ids);
            foreach($idArr as $id)
            {
                $delete = DB::delete('order_sis')->where('id', '=', $id)->execute();
                if($delete)
                    echo $id . ' order_sis Delete Success<br>';
            }
        }
        else
        {
            echo '
<form method="post" action="">
Input ids:<br/>
<textarea name="id" cols="40" rows="20"></textarea><br/>
<input type="submit" value="Submit" />
</form>                        
';
        }
    }
    
    public function action_attributes()
    {
        $attributes = DB::query(DATABASE::SELECT, 'SELECT DISTINCT attributes FROM catalog_sorts')->execute('slave');
        foreach($attributes as $attr)
        {
            $attrArr = explode(',', $attr['attributes']);
            foreach($attrArr as $att)
            {
                $att = trim($att);
                $label = strtolower(preg_replace('/[^\w\b]+/', '-', $att));
                $has = DB::select('id')->from('attributes')->where('label', '=', $label)->execute('slave')->current();
                if(empty($has))
                {
                    $insert = array(
                        'name' => $att,
                        'label' => $label,
                        'brief' => $att,
                        'site_id' => $this->site_id
                    );
                    DB::insert('attributes', array_keys($insert))->values($insert)->execute();
                }
            }
        }
        echo '<script type="text/javascript">
                window.setInterval(pagerefresh, 1000);
                function pagerefresh() 
                { 
                    window.location.href = "/admin/site/lookbook/product_attributes"; 
                }     
            </script>';
    }
    
    public function action_product_attributes()
    {
        $products = DB::query(DATABASE::SELECT, 'SELECT id, filter_attributes FROM products
                WHERE type = 3 AND oid = 0 AND filter_attributes NOT LIKE "%PRODUCT TYPE%" AND filter_attributes <> ""')
                ->execute('slave');
        foreach($products as $p)
        {
            DB::delete('product_attribute_values')->where('product_id', '=', $p['id'])->where('value', '=', '')->execute();
            $attrArr = explode(';', $p['filter_attributes']);
            $used = array();
            $key = 0;
            foreach($attrArr as $attr)
            {
                $attr = trim($attr);
                $attr_label = strtolower(preg_replace('/[^\w\b]+/', '-', $attr));
                if(in_array($attr_label, $used))
                    continue;
                $used[] = $attr_label;
                $attr_id = DB::select('id')->from('attributes')->where('label', '=', $attr_label)->execute('slave')->get('id');
                if($attr_id)
                {
                        $insert = array(
                            'product_id' => $p['id'],
                            'attribute_id' => $attr_id
                        );
                        DB::insert('product_attribute_values', array_keys($insert))->values($insert)->execute();
                }
            }
            if(!empty($has))
            {
                foreach($has as $h)
                {
                    DB::delete('product_attribute_values')->where('id', '=', $h['id'])->execute();
                }
            }
            DB::update('products')->set(array('oid' => 1))->where('id', '=', $p['id'])->execute();
        }
        echo 'Update products attributes filters success!';
    }

    public function action_export_orders()
    {
        if($_POST)
        {
            $from = Arr::get($_POST, 'from', NULL);
            if (!$from)
            {
                die('invalid request');
            }
            $to = Arr::get($_POST, 'to', NULL);

            $file = 'orders-';
            $sql = '';
            if ($to)
            {
                $file .= "from-$from-to-$to";
                $sql = ' AND p.created >= ' . strtotime($from) . ' AND p.created < ' . strtotime($to);
            }
            else
            {
                $file .= "from-$from";
                $to = strtotime($from) + 86400;
                $sql = ' AND p.created >= ' . strtotime($from) . ' AND p.created < ' . $to;
            }
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="Products-' . $file . '.csv"');
            echo "\xEF\xBB\xBF" . "订单号,用户,国家,支付流水号,支付日期,支付状态,支付方式,订单付款总额,货币,物流公司,物流号,追踪地址,商户交易网站,寄件人投递日期,买家姓名,shipping_country,shipping_state,shipping_city,shipping_address,shipping_phone,产品名称,数量,产品价格\n";

            $orders = DB::query(1, 'SELECT o.id, o.ordernum, o.email, o.rate, p.trans_id, p.created AS payment_date, p.payment_status, p.amount, p.currency, p.payment_method, s.tracking_code, s.tracking_link, 
                o.shipping_firstname, o.shipping_lastname, o.shipping_country, o.shipping_state, o.shipping_city, o.shipping_address, o.shipping_zip, o.shipping_phone,s.ship_date, s.carrier 
                FROM  `order_shipments` s LEFT JOIN orders o ON s.site_id = o.site_id AND s.order_id = o.id RIGHT JOIN order_payments p ON s.site_id = p.site_id AND s.order_id = p.order_id
                WHERE s.tracking_code <> "" AND o.site_id = 1 AND o.is_active = 1 AND p.payment_method = "GlobalCollect" ' . $sql . ' GROUP BY ordernum')->execute('slave');
            $order_id = 0;
            foreach($orders as $o)
            {
                echo $o['ordernum'] . ',';
                echo $o['email'] . ',';
                echo $o['shipping_country'] . ',';
                echo "'" . $o['trans_id'] . ',';
                echo date('Y-m-d H:i:s', $o['payment_date']) . ',';
                echo $o['payment_status'] . ',';
                echo $o['payment_method'] . ',';
                echo $o['amount'] . ',';
                echo $o['currency'] . ',';
                echo $o['carrier'] . ',';
                echo $o['tracking_code'] . ',';
                echo $o['tracking_link'] . ',';
                echo 'www.choies.com,';
                echo date('Y-m-d H:i:s', $o['ship_date']) . ',';
                echo $o['shipping_firstname'] . ' ' . $o['shipping_lastname'] . ',';
                echo $o['shipping_country'] . ',';
                echo $o['shipping_state'] . ',';
                echo $o['shipping_city'] . ',';
                echo str_replace(array(',', "\n", PHP_EOL), array(';', ' ', ' '), $o['shipping_address']) . ',';
                echo "'" . $o['shipping_phone'] . ',';
                $products = DB::select('sku', 'name', 'quantity', 'price', 'status')
                    ->from('orders_orderitem')
                    ->where('site_id', '=', $this->site_id)
                    ->where('order_id', '=', $o['id'])
                    ->execute('slave')->as_array();
                $pamount = 0;
                foreach($products as $key => $p)
                {
                    if($p['status'] == 'cancel')
                    {
                        unset($products[$key]);
                        continue;
                    }
                    $pamount += round($p['price'] * $o['rate'] * $p['quantity'], 2);
                }
                foreach($products as $key => $p)
                {
                    echo $p['name'] . ',';
                    echo $p['quantity'] . ',';
                    $av_rate = $pamount > 0 ? $o['amount'] / $pamount : 0;
                    echo round($p['price'] * $o['rate'] * $p['quantity'] * $av_rate, 2) . ',';
                }
                echo PHP_EOL;
            }
            exit;
        }
        echo '
                <form style="margin:20px;" method="post" action="" target="_blank">
                    <label>From: </label>
                    <input type="text" name="from" class="ui-widget-content ui-corner-all time hasDatepicker" id="export-start">
                    <label>To: </label>
                    <input type="text" name="to" class="ui-widget-content ui-corner-all time hasDatepicker" id="export-end">
                    <input type="submit" value="导出订单" class="ui-button" style="padding:0 .5em">
                </form>
        ';
    }

    public function action_month_customers()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Month-Customers.csv"');
        echo "\xEF\xBB\xBF" . "日期,每月注册用户,曾经下单用户,没有登录用户,支付订单1次,支付订单2次,支付订单3次,支付订单超过3次\n";
        $begin = strtotime('2012-05-03');
        // $begin = strtotime('2014-01-01');
        $end = strtotime('midnight + 1 month') - 1;
        while($begin <= $end)
        {
            $from = $begin;
            $to = strtotime(date('Y-m-d', $begin) . ' + 1 month') - 1;
            $c_amount = DB::query(Database::SELECT, 'SELECT COUNT(id) AS amount FROM customers WHERE created BETWEEN ' . $from . ' AND ' . $to)->execute('slave')->get('amount');
            $c_order = DB::query(Database::SELECT, 'SELECT COUNT(DISTINCT o.customer_id) AS amount FROM customers c LEFT JOIN orders o ON c.id = o.customer_id WHERE c.created BETWEEN ' . $from . ' AND ' . $to)->execute('slave')->get('amount');
            $c_no_login = DB::query(Database::SELECT, 'SELECT COUNT(id) AS amount FROM customers WHERE created BETWEEN ' . $from . ' AND ' . $to . ' AND last_login_time = 0')->execute('slave')->get('amount');
            $c_pay = DB::query(Database::SELECT, 'SELECT c.id, COUNT(o.customer_id) AS orders FROM `customers` c LEFT JOIN orders o ON c.id = o.customer_id WHERE c.created BETWEEN ' . $from . ' AND ' . $to . ' AND o.payment_status = "verify_pass" AND o.is_active = 1 GROUP BY id')->execute('slave');
            $c_pay1 = $c_pay2 = $c_pay3 = $c_pay4 = 0;
            foreach($c_pay as $p)
            {
                if($p['orders'] == 1)
                    $c_pay1 ++;
                elseif($p['orders'] == 2)
                    $c_pay2 ++;
                elseif($p['orders'] == 3)
                    $c_pay3 ++;
                elseif($p['orders'] > 3)
                    $c_pay4 ++;
            }
            echo date('Y-m', $from) . ',';
            echo $c_amount . ',';
            echo $c_order . ',';
            echo $c_no_login . ',';
            echo $c_pay1 . ',';
            echo $c_pay2 . ',';
            echo $c_pay3 . ',';
            echo $c_pay4 . ',';
            echo PHP_EOL;
            $begin = $to + 1;
        }
    }

    public function action_delete_celebrity_images()
    {
        $imagedir = kohana::config('upload.resource_dir') . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR;
        $images = DB::query(Database::SELECT, 'SELECT c.id, c.product_id, c.image FROM celebrity_images c LEFT JOIN  `products` p ON c.product_id = p.id WHERE p.visibility = 0')->execute('slave');
        foreach($images as $image)
        {
            $key = 0;
            $img = $imagedir . 'simages' . DIRECTORY_SEPARATOR . $image['image'];
            if (file_exists($img))
            {
                unlink($img);
                $key = 1;
            }
            $image6 = $imagedir . 'simages' . DIRECTORY_SEPARATOR . '6_' . $image['image'];
            if (file_exists($image6))
            {
                unlink($image6);
                $key = 1;
            }
            $image7 = $imagedir . 'simages' . DIRECTORY_SEPARATOR . '7_' . $image['image'];
            if (file_exists($image7))
            {
                unlink($image7);
                $key = 1;
            }
            DB::delete('celebrity_images')->where('id', '=', $image['id'])->execute();
            if($key)
            {
                echo $image['product_id'] . '<br>';
            }
        }
    }

    public function action_review_statistics()
    {
        $reviews = DB::query(Database::SELECT, 'SELECT DISTINCT product_id FROM reviews WHERE is_approved = 1')->execute('slave');
        foreach($reviews as $r)
        {
            $rs = DB::select('overall')->from('reviews')->where('product_id', '=', $r['product_id'])->where('is_approved', '=', 1)->execute('slave')->as_array();
            $r_count = count($rs);
            $rating_sum = 0;
            foreach($rs as $s)
            {
                $rating_sum += $s['overall'];
            }
            $r_rating = round($rating_sum / $r_count, 1);
            $data = array(
                'product_id' => $r['product_id'],
                'rating' => (string) $r_rating,
                'quantity' => $r_count,
            ); 
            $has = DB::select('id')->from('review_statistics')->where('product_id', '=', $r['product_id'])->execute('slave')->get('id');
        if($has)
        {
          //  DB::update('review_statistics')->set($data)->where('id', '=', $has)->execute();
        }
        else
        {
            $insert = DB::insert('review_statistics', array_keys($data))->values($data)->execute();
        }

            
            if($insert)
            {
                echo $r['product_id'] . ' insert review statistics success<br>';
            }
            // $has = DB::select('id')->from('review_statistics')->where('product_id', '=', $r['product_id'])->execute('slave')->get('id');
            // if($has)
            // {
            //     DB::update('review_statistics');
            // }
        }
    }

    /* catalog products onsale count AND offsale count */
    public function action_catalog_products_cout()
    {
        echo '<table cellspacing="0" cellpadding="0" border="0">';
        echo '<tr><td width="120px">Catalog Name</td><td width="100px">在架产品数量</td><td width="100px">下架产品数量</td></tr>';
        $catalogs = DB::select('id')->from('products_category')->where('visibility', '=', 1)->where('on_menu', '=', 1)->execute('slave');
        foreach($catalogs as $cata)
        {
            $catalog = Catalog::instance($cata['id']);
            $posterity_ids = $catalog->posterity();
            $posterity_ids[] = $cata['id'];
            $posterity_sql = implode(',', $posterity_ids);

            $sql = 'SELECT count(distinct products.id) as num FROM products LEFT JOIN catalog_products ON catalog_products.product_id=products.id 
            WHERE catalog_products.catalog_id IN (' . $posterity_sql . ') AND products.site_id =1 AND products.visibility = 1';

            $onsale_count = DB::query(Database::SELECT, $sql . ' AND status = 1')->execute('slave')->get('num');
            $offsale_count = DB::query(Database::SELECT, $sql . ' AND status = 0')->execute('slave')->get('num');

            echo '<tr><td>' . $catalog->get('name') . '</td><td>' . $onsale_count . '</td><td>' . $offsale_count . '</td></tr>';
        }
        echo '</table>';
    }

    public function action_product_all_buy()
    {
        if($_POST)
        {
            echo '<table cellspacing="0" cellpadding="0" border="0">';
            // echo 'SKU||SKU-SIZE||*Product Name||Color||Size||*Quantity||*Tags||Description||*Price||*Shipping||*Main Image URL(catalog)||Extra Image URL||Extra Image URL 1||Extra Image URL 2||Extra Image URL 3||...<br>';
            echo '<tr><td>SKU</td><td>SKU-SIZE</td><td>*Product Name</td><td>Color</td><td>Size</td><td>*Quantity</td><td>*Tags</td><td>Description</td><td>*Price</td><td>*Shipping</td><td>*Main Image URL(catalog)</td><td>Extra Image URL</td><td>Extra Image URL 1</td><td>Extra Image URL 2</td><td>Extra Image URL 3</td><td>...</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
            $skus = trim(Arr::get($_POST, 'skus', ''));
            $skus = str_replace(' ', '', $skus);
            $skuArr = explode("\n", $skus);
            $products = DB::select('id', 'sku', 'name', 'attributes', 'description', 'configs')->from('products_product')->where('sku', 'IN', $skuArr)->execute('slave');
            foreach($products as $product)
            {
                $description = strip_tags($product['description']);
                $description = preg_replace('/(&nbsp;)+/', ' ', $description);
                $description = str_replace(array('&amp;', '.'), array('&', ''), $description);
                $description = trim(preg_replace('/"|\n/', '', $description));
                $color_id = DB::select('attribute_id')->from('product_attribute_values')->where('product_id', '=', $product['id'])->where('attribute_id', '>=', 4)->where('attribute_id', '<=', 17)->execute('slave')->get('attribute_id');
                if($color_id)
                    $color = DB::select('name')->from('attributes')->where('id', '=', $color_id)->execute('slave')->get('name');
                else
                    $color = '';
                $price = Product::instance($product['id'])->price();
                $attributes = unserialize($product['attributes']);
                $configs = unserialize($product['configs']);
                $default_image = '';
                $extra_images = array();
                $images = Product::instance($product['id'])->images();
                foreach($images as $key => $image)
                {
                    if($key == 0)
                    {
                        $default_image = '<td>http:://www.choies.com/pimages1/'.$image['id'].'/7.jpg</td>';
                    }
                    else
                    {
                        $extra_images[] = '<td>http:://www.choies.com/pimages1/'.$image['id'].'/9.jpg</td>';
                    }
                }
                $images_str = implode('', $extra_images);
                foreach($attributes as $name => $attrs)
                {
                    foreach($attrs as $attr)
                    {
                        $eur = strpos($attr, 'EUR');
                        if($eur !== False)
                        {
                            $attr = substr($attr, $eur + 3, 2);
                        }
                        echo '<tr><td>'.$product['sku'].'</td><td>'.$product['sku'].'-'.$attr.'</td><td>'.$product['name'].'</td><td>'.$color.'</td><td>'.$attr.'</td><td></td><td></td><td>'.$description.'</td><td>'.$price.'</td><td></td>'.$default_image.''.$images_str.'</tr>';
                    }
                }
            }
        }
        else
        {
        echo '
<form method="post" action="">
Input skus:<br/>
<textarea name="skus" cols="40" rows="20"></textarea><br/>
<input type="submit" value="Submit" />
</form>                        
';
        }
    }

    public function action_product_all_buy1()
    {
        if($_POST)
        {
            // echo '<table cellspacing="0" cellpadding="0" border="0">';
            // echo 'SKU||SKU-SIZE||*Product Name||Color||Size||*Quantity||*Tags||Description||*Price||*Shipping||*Main Image URL(catalog)||Extra Image URL||Extra Image URL 1||Extra Image URL 2||Extra Image URL 3||...<br>';
            // echo '<tr><td>SKU</td><td>SKU-SIZE</td><td>*Product Name</td><td>Color</td><td>Size</td><td>*Quantity</td><td>*Tags</td><td>Description</td><td>*Price</td><td>*Shipping</td><td>*Main Image URL(catalog)</td><td>Extra Image URL</td><td>Extra Image URL 1</td><td>Extra Image URL 2</td><td>Extra Image URL 3</td><td>...</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
            // header('Content-Type: application/vnd.ms-excel');
            // header('Content-Disposition: attachment; filename="Products-all-buy.csv"');
            echo "SKU||SKU-SIZE||*Product Name||Color||Size||*Quantity||*Tags||Description||*Price||*Shipping||*Main Image URL(catalog)||Extra Image URL Extra Image URL 1||Extra Image URL 2||Extra Image URL 3||...\n";
            $skus = trim(Arr::get($_POST, 'skus', ''));
            $skus = str_replace(' ', '', $skus);
            $skuArr = explode("\n", $skus);
            foreach($skuArr as $sku)
            {
                $product = DB::select('id', 'sku', 'name', 'attributes', 'description', 'brief', 'keywords', 'configs')->from('products_product')->where('sku', '=', trim($sku))->execute('slave')->current();
                if(empty($product))
                    continue;
                $description = $product['description'];
                $description = str_replace(array('<br>', '<br />', '<br style="margin: 0px; padding: 0px; color: #555555; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 16px;" />'), array(';'), $description);
                $description = str_replace(array('<p>', '</p>', '<div>', '</div>'), array(' '), $description);
                $price = Product::instance($product['id'])->price();
                $attributes = unserialize($product['attributes']);
                $configs = unserialize($product['configs']);
                $default_image = '';
                $extra_images = '';
                $images = Product::instance($product['id'])->images();
                foreach($images as $key => $image)
                {
                    if($key == 0)
                    {
                        $default_image = 'http://www.choies.com/pimages1/'.$image['id'].'/9.jpg';
                    }
                    else
                    {
                        $extra_images .= 'http://www.choies.com/pimages1/'.$image['id'].'/9.jpg' . '||';
                    }
                }
                // $images_str = implode('', $extra_images);
                $brief = str_replace("\n", "", $product['brief']);
                $keywords = str_replace("\n", "", $product['keywords']);
                foreach($attributes as $name => $attrs)
                {
                    foreach($attrs as $attr)
                    {
                        $eur = strpos($attr, 'EUR');
                        if($eur !== False)
                        {
                            $attr = substr($attr, $eur + 3, 2);
                        }
                        // echo '<tr><td>'.$product['sku'].'</td><td>'.$product['sku'].'-'.$attr.'</td><td>'.$product['name'].'</td><td></td><td>'.$attr.'</td><td></td><td></td><td>'.$description.'</td><td>'.$price.'</td><td></td>'.$default_image.''.$images_str.'</tr>';
                        echo $product['sku'] . '||';
                        echo $product['sku'] . '-' . $attr . '||';
                        echo $product['name'] . '||';
                        echo '||';
                        echo $attr . '||';
                        echo '||';
                        echo '||';
                        echo $description . '|' . $brief .'||';
                        echo $price . '||';
                        echo $keywords . '||';
                        echo $default_image . '||';
                        echo $extra_images;
                        echo PHP_EOL;
                    }
                }
            }
        }
        else
        {
        echo '
<form method="post" action="">
Input skus:<br/>
<textarea name="skus" cols="40" rows="20"></textarea><br/>
<input type="submit" value="Submit" />
</form>                        
';
        }
    }

    public function action_error_orders()
    {
        echo 'ordernum payment_status sku item_price order_price<br>';
        $fromorder = 224892;
        $result = DB::query(Database::SELECT, 'SELECT order_id, product_id, sku, price FROM order_items WHERE order_id > ' . $fromorder)->execute('slave');
        foreach($result as $data)
        {
            $p_price = Product::instance($data['product_id'])->price();
            if($data['price'] < $p_price)
            {
                echo Order::instance($data['order_id'])->get('ordernum') . ' ' . Order::instance($data['order_id'])->get('payment_status') . ' ' . $data['sku'] . ' ' . $p_price . ' ' . $data['price'] . '<br>';
            }
        }
    }

    public function action_hs_codes()
    {
        echo '<form enctype="multipart/form-data" action="/admin/site/lookbook/hs_codes_export" method="post" class="lang_hidden">
                    <input type="file" name="file">
                    <input type="submit" name="submit" value="submit">
                </form>';
    }

    public function action_hs_codes_export()
    {
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $basics = array();
        $head = array();
        $amount = 0;
        $success = '';
        $file_name = 'hs_codes_search.csv';
        header("Content-type:application/vnd.ms-excel; charset=UTF-8");
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        echo "\xEF\xBB\xBF" . "SKU,类别,成分,hs code,商品名称及备注,单位,代码\n";
        while ($data = fgetcsv($handle))
        {
            $sku = trim($data[0]);
            $search = trim($data[1]);
            $search = Security::xss_clean(iconv('gbk', 'utf-8', $search));
            $search = str_replace(' ', '%', $search);
            $result = DB::query(Database::SELECT, 'SELECT * FROM hs_codes WHERE `sort` LIKE "%'.$search.'%" OR `composition` LIKE "%'.$search.'%" OR `brief` LIKE "%'.$search.'%"')->execute('slave');
            foreach($result as $key => $r)
            {
                echo !$key ? $sku . ',' : ',';
                echo $r['sort'] . ',';
                echo $r['composition'] . ',';
                echo $r['hs'] . ',';
                echo str_replace(',', ';', $r['brief']) . ',';
                echo $r['unit'] . ',';
                echo $r['code'] . ',';
                echo PHP_EOL;
            }
            echo PHP_EOL;
        }
    }

    public function action_import_emails()
    {
        echo '<form enctype="multipart/form-data" action="/admin/site/lookbook/do_emails" method="post" class="lang_hidden">
                    <input type="file" name="file">
                    <input type="submit" name="submit" value="submit">
                </form>';
    }

    public function action_do_emails()
    {
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $basics = array();
        $head = array();
        $amount = 0;
        $success = '';
        $num = 0;
        while ($data = fgetcsv($handle))
        {
            $email = trim($data[0]);
            $insert = DB::insert('emails', array('email'))->values(array('email' => $email))->execute();
            if($insert)
                $num ++;
        }
        echo $num . ' data import success!';
    }

    public function action_not_main_catalog_products()
    {
        $main_catalog_prodcts = DB::query(Database::SELECT, 'SELECT DISTINCT S.product_id FROM catalog_products S LEFT JOIN catalogs C ON S.catalog_id = C.id RIGHT JOIN products P ON S.product_id = P.id
            WHERE C.on_menu = 1 AND P.visibility = 1 AND P.status = 1 AND P.stock <> 0')->execute('slave')->as_array();
        $products = DB::query(Database::SELECT, 'SELECT id, sku FROM `products_product` WHERE visibility = 1 AND status = 1 AND stock <> 0')->execute('slave');
        foreach($products AS $p)
        {
            $search = array('product_id' => $p['id']);
            if(!in_array($search, $main_catalog_prodcts))
                echo $p['sku'] . '<br>';
        }
    }

    public function action_pp_payment_import()
    {
        echo '<form enctype="multipart/form-data" action="" method="post" class="lang_hidden">
                    <input type="file" name="file">
                    <input type="submit" name="submit" value="submit">
                </form>';

        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        $countries = Site::instance()->countries();
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 0;
        while ($data = fgetcsv($handle))
        {
            $row ++;
            if($row == 1)
                continue;
            $amount = str_replace(',', '', trim($data[7]));
            if($amount <= 0)
                continue;
            $_ordernum = explode(':', trim($data[32]));
            $ordernum = $_ordernum[0];
            $order_id = Order::instance()->get_from_ordernum($ordernum);
            $payment_status = Order::instance($order_id)->get('payment_status');
            if(!$payment_status)
                continue;
            if($payment_status == 'verify_pass' OR $payment_status == 'success' OR $payment_status == 'pending' OR $payment_status == 'cancel')
                continue;
            echo $ordernum . ' ';
            $name = trim($data[3]);
            $names = explode(' ', $name);
            $firstname = $names[0];
            $lastname = str_replace($firstname . ' ', '', $name);
            $country = trim($data[41]);
            $country_code = $country;
            foreach($countries as $c)
            {
                if(strtolower($country) == strtolower($c['name']))
                {
                    $country_code = $c['isocode'];
                    break;
                }
            }
            $result = array(
                'mc_gross' => $amount,
                'invoice' => $ordernum,
                'protection_eligibility' =>'Eligible',
                'address_status' => trim($data[15]),
                'payer_id' => '',
                'tax' => trim($data[20]),
                'address_street' => trim($data[36]),
                'payment_date' => trim($data[0]) . ' ' . trim($data[1]),
                'payment_status' => trim($data[5]),
                'charset' =>'gb2312',
                'address_zip' => trim($data[40]),
                'first_name' => $firstname,
                'mc_fee' => abs($data[8]),
                'address_country_code' => $country_code,
                'address_name' => $name,
                'notify_version' =>'3.8',
                'custom' =>'',
                'payer_status' => trim($data[14]),
                'address_country' => $country,
                'address_city' => trim($data[38]),
                'quantity' => '1',
                'verify_sign' => '',
                'payer_email' => trim($data[11]),
                'contact_phone' => trim($data[42]),
                'txn_id' => trim($data[13]),
                'payment_type' => 'instant',
                'last_name' => $lastname,
                'address_state' => trim($data[39]),
                'receiver_email' => trim($data[12]),
                'payment_fee' => abs($data[8]),
                'receiver_id' => '',
                'txn_type' => 'express_checkout',
                'item_name' => '',
                'mc_currency' => trim($data[6]),
                'item_number' => '',
                'residence_country' => $country_code,
                'handling_amount' => trim($data[18]),
                'transaction_subject' => '',
                'payment_gross' => $amount,
                'shipping' => trim($data[18]),
                'ipn_track_id' => '',
            );
            
            $trans_id = $result['txn_id'];
            $has = DB::select('id')->from('orders_orderpayments')->where('trans_id', '=', $trans_id)->execute()->get('id');
            if ($has)
            {
                echo ' txn_id exists!!<br>';
                continue;
            }
            $datas = $result;
            $datas['first_name'] = $datas['first_name'];
            $datas['last_name'] = $datas['last_name'];
            $datas['address_street'] = $datas['address_street'];
            $datas['address_zip'] = $datas['address_zip'];
            $datas['address_city'] = $datas['address_city'];
            $datas['address_state'] = $datas['address_state'];
            $datas['address_country_code'] = $datas['address_country_code'];
            if ($result['invoice'])
            {
                $order = Order::instance($order_id)->get();
                // TODO Coupon Limit -1
                if ($coupon = Cart::coupon())
                {
                    Coupon::instance($coupon)->apply();
                }

                // Product stock Minus
                $products = unserialize($order['products']);
                foreach ($products as $product)
                {
                    $stock = Product::instance($product['id'])->get('stock');
                    if ($stock != -99 AND $stock > 0)
                    {
                        DB::update('products')->set(array('stock' => $stock - $product['quantity']))->where('id', '=', $product['id'])->execute();
                    }
                }

                echo Payment::instance('EC')->pay($order, $datas);
            }
            else
            {
                echo 'FAIL';
            }

            echo '<br>';
        }
    }

    public function action_import_shipments()
    {
        echo '<form enctype="multipart/form-data" action="/admin/site/lookbook/import_shipments_do" method="post" class="lang_hidden">
                <input type="file" name="file">
                <input type="submit" name="submit" value="submit">
            </form>';
    }

    public function action_import_shipments_do()
    {
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 0;
        while ($data = fgetcsv($handle))
        {
            $row ++;
            if($row == 1)
                continue;
            $success = 0;
            $ordernum = trim($data[0]);
            $packageid = trim($data[1]);
            $ship_time = trim($data[2]);
            $carrier = trim($data[3]);
            $track_no = trim($data[4]);
            $track_link = trim($data[5]);
            $order_id = Order::get_from_ordernum($ordernum);
            if($order_id)
            {
                $order = Order::instance($order_id);
                $order_items = $order->getitems();
                $items = array();
                foreach($order_items as $item)
                {
                    if($item['status'] != 'cancel')
                    {
                        $items[] = array(
                            'item_id' => $item['product_id'],
                            'quantity' => $item['quantity'],
                        );
                    }
                }
                $shipment = array(
                    'carrier' => $carrier,
                    'tracking_code' => $track_no,
                    'tracking_link' => $track_link,
                    'ship_date' => strtotime($ship_time),
                    'ship_price' => 0,
                    'package_id' => $packageid,
                );
                if($order->add_shipment($shipment, $items))
                {
                    $order->set(array(
                        'shipping_status' => 'shipped',
                        'shipping_date' => strtotime($ship_time),
                        'tracking_code' => $track_no,
                        'tracking_link' => $track_link,
                    ));
                    $success = 1;
                }
            }
            echo $ordernum . '--' . $success . '<br>';
        }
    }

//sku修改图片时通知wholesale
    public static function action_sku_img_change()
    {
        set_time_limit(0);
        $sku = Arr::get($_POST, 'sku', '');

        if(empty($sku)){
            return false;
        }
        $post_data=array('sku'=>$sku);

        $requestUrl="http://www.choieswholesale.com/api/sku_img_change";
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $requestUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $res=curl_exec($ch);
        curl_close($ch);
        echo $res;
        exit();

    }
    
    public function action_clear_b2b_sync_session()
    {
        $sync_flag=Session::instance()->get('b2b_sync_sku');
        if(!empty($sync_flag)){
            Session::instance()->delete('b2b_sync_sku');
            echo 'success';
            exit();
        }
        echo false;
        exit();
    }

    public function action_test_order()
    {
        $wp_url = 'http://choies-service.dmdelivery.com/x/soap-v4.2/wsdl.php';
        $curl = curl_init($wp_url); 
        // 不取回数据 
        curl_setopt($curl, CURLOPT_NOBODY, true); 
        // 发送请求 
        $result = curl_exec($curl); 
        $found = false; 
        // 如果请求没有发送失败 
        if ($result !== false) { 
            // 再检查http响应码是否为200 
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
            if ($statusCode == 200) { 
            $found = true; 
            } 
        } 
        curl_close($curl); 
        $client = new SoapClient($wp_url,array('encoding'=>'utf-8'));
        var_dump($found); exit;

        $orders = DB::query(Database::SELECT, 'SELECT o.id,o.payment_status,o.verify_date,o.ordernum,o.email,o.customer_id,o.currency,o.rate,o.amount,o.amount_products,o.amount_shipping,o.amount_coupon,o.amount_payment,o.ip,o.payment_method,o.payment_date,o.order_from,o.order_insurance,
                o.shipping_firstname,o.shipping_lastname,o.shipping_address,o.shipping_city,o.shipping_state,o.shipping_country,o.shipping_zip,o.shipping_phone,o.billing_firstname,o.billing_lastname,o.billing_address,o.billing_city,o.billing_zip,o.billing_phone,o.billing_state,o.billing_country
                FROM orders o WHERE o.id = 651899 GROUP BY o.id ORDER BY o.id')
                ->execute();
        $countries = Site::instance()->countries();
        foreach ($orders as $o)
        {
            $items = array();
            $itemArr = DB::query(Database::SELECT, 'SELECT sku, quantity, price, attributes, is_gift FROM order_items WHERE order_id = ' . $o['id'] .' and status != "cancel"')->execute();
            $remark = array();
            $remarks = DB::select('remark')->from('orders_orderremarks')->WHERE('order_id', '=', $o['id'])->execute();
            foreach($remarks as $r)
            {
                $remark[] = $r['remark'];
            }
            foreach ($itemArr as $i)
            {
                $items[] = array(
                    'sku' => $i['sku'],
                    'attributes' => $i['attributes'],
                    'quantity' => $i['quantity'],
                    'price' => round($i['price'], 2),
                    'is_gift' => $i['is_gift'],
                );
            }
            $admin_id = DB::select('admin')->from('celebrities_celebrits')->where('email', '=', $o['email'])->execute()->get('admin');
            if ($admin_id)
                $cele_admin = User::instance($admin_id)->get('name');
            else
                $cele_admin = '';
            if(strlen($o['billing_country']) > 2)
            {
                foreach($countries as $country)
                {
                    if(strtoupper($o['billing_country']) == strtoupper($country['name']))
                    {
                        $o['billing_country'] = $country['isocode'];
                        break;
                    }
                }
            }
            if(strlen($o['billing_country']) > 2)
            {
                $o['billing_country'] = '';
            }
            $data[] = array(
                'id' => $o['id'],
                'payment_status' => $o['payment_status'],
                'date_purchased' => date('Y-m-d H:i:s', $o['verify_date']),
                'is_active' => '1 ',
                'ordernum' => $o['ordernum'],
                'email' => $o['email'],
                'customer_id' => $o['customer_id'],
                'currency' => $o['currency'],
                'rate' => (float) $o['rate'],
                'amount' => $o['amount'],
                'amount_products' => $o['amount_products'],
                'amount_shipping' => $o['amount_shipping'],
                'amount_coupon' => $o['amount_coupon'],
                'amount_payment' => $o['amount_payment'],
                'order_insurance' => $o['order_insurance'],
                'ip_address' => long2ip($o['ip']),
                'remark' => implode('|', $remark),
                'payment' => $o['payment_method'],
                'payment_date' => date('Y-m-d H:i:s', $o['payment_date']),
                'order_from' => $o['order_from'],
                'shipping_firstname' => $o['shipping_firstname'],
                'shipping_lastname' => $o['shipping_lastname'],
                'shipping_address' => $o['shipping_address'],
                'shipping_city' => $o['shipping_city'],
                'shipping_state' => $o['shipping_state'],
                'shipping_country' => $o['shipping_country'],
                'shipping_zip' => $o['shipping_zip'],
                'shipping_phone' => $o['shipping_phone'],
                'billing_firstname' => $o['billing_firstname'],
                'billing_lastname' => $o['billing_lastname'],
                'billing_address' => $o['billing_address'],
                'billing_city' => $o['billing_city'],
                'billing_state' => $o['billing_state'],
                'billing_country' => $o['billing_country'],
                'billing_zip' => $o['billing_zip'],
                'billing_phone' => $o['billing_phone'],
                'orderitems' => $items,
                'cele_admin'=>$cele_admin,
            );
        }
        echo json_encode($data);
        exit;
    }

    //批量生成促销memcache(每次生成所有的)
    public function action_add_spromotion_memcache()
    {
        $cache = Cache::instance('memcache');

        // spromotions 特殊产品促销
        $spromotions = DB::select('id', 'product_id', 'price', 'type', 'created', 'expired')->from('spromotions')->where('expired', '>', time())->execute('slave');
        foreach($spromotions as $spromotion)
        {
            if($spromotion['price'] >0)
            {
                $cache_key = 'spromotion_' . $spromotion['product_id'];
                $cache_data = $cache->get($cache_key);
                $cache_data[$spromotion['type']] = array('price' => $spromotion['price'], 'created' => $spromotion['created'], 'expired' => $spromotion['expired']);
                asort($cache_data);
                $cache->set($cache_key, $cache_data, 30 * 86400);
                echo $cache_key . '<br>';                
            }
        }

        // promotions 传统促销
        $cache_key = 'promotions_product';
        $promotions = DB::select()
            ->from('promotions')
            ->and_where('is_active', '=', 1)
            ->and_where('from_date', '<=', time())
            ->and_where('to_date', '>=', time())
            ->order_by('from_date', 'desc')
            ->execute()
            ->as_array();
        $cache->set($cache_key, $promotions, 30 * 86400);
    }

    public function action_spromotion_update()
    {
        $product_id = Arr::get($_GET, 'product_id', '');
        $cache = Cache::instance('memcache');
        $spromotion_key = 'spromotion_' . $product_id;
        $promotions = '';
        $cache->set($spromotion_key, '', 30 * 86400);

    }

    // 按产品批量添加促销memcache
    public function action_simple_spromotion_memcache()
    {
        if($_POST)
        {
            $string = Arr::get($_POST, 'skus', '');
            $skus = explode("\n", $string);
            $product_ids = DB::select('id', 'sku')->from('products_product')->where('sku', 'in', $skus)->execute('slave');
            $cache = Cache::instance('memcache');
            foreach($product_ids as $product)
            {
                $spromotions = DB::select('id', 'product_id', 'price', 'type', 'created', 'expired')->from('spromotions')->where('product_id', '=', $product['id'])->where('expired', '>', time())->execute('slave');
                $cache_key = 'spromotion_' . $product['id'];
                $cache_data = array();
                foreach($spromotions as $spromotion)
                {
                    $cache_data[$spromotion['type']] = array('price' => $spromotion['price'], 'created' => $spromotion['created'], 'expired' => $spromotion['expired']);
                }
                asort($cache_data);
                $cache->set($cache_key, $cache_data, 30 * 86400);
                echo $product['sku'] . ' success<br>';
            }
        }
        else
        {
            echo '
                <form method="post" action="">
                Skus:<br/>
                <textarea name="skus" cols="40" rows="20"></textarea><br/>
                <input type="submit" value="Submit" />
                </form>                        
            ';
        }
    }

    public function action_test_spromotion_memcache()
    {
        $sku = Arr::get($_GET, 'sku', '');
        $product_id = Product::get_productId_by_sku($sku);
        $cache_key = 'spromotion_' . $product_id;
        $cache = Cache::instance('memcache');
        $cache_data = $cache->get($cache_key);
        echo '<pre>';
        foreach($cache_data as $s_type => $s_data)
        {
            echo $s_type;
            print_r($s_data);
            if($s_type == 0 && $s_data['created'] < time() && $s_data['expired'] > time())
            {
                $vip_promotion_price = $s_data['price'];
                break;
            }
        }
        print_r($cache_data);
        exit;
    }

}

?>
