<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Review extends Controller_Webpage
{

    public function action_add()
    {
        $user = Customer::instance()->logged_in();
        if ($_POST)
        {
            $data = $_POST;
            $product_id = Arr::get($data, 'product_id', NULL);
            if ($user)
            {
                if(!$data['overall'] || !$data['quality'] || !$data['price'] || !$data['fitness'] || !$data['content'])
                {
                    Message::set(__('post_data_error'), 'error');
                    $this->request->redirect(Request::instance()->uri());
                }
                $data['user_id'] = $user;
                $data['firstname'] = DB::select('shipping_firstname')->from('orders_order')->where('id', '=', $data['order_id'])->execute()->get('shipping_firstname');
                $review_re = Review::instance($product_id)->set($data);
                if (is_int($review_re))
                {
                    $item_id = Arr::get($data, 'item_id', 0);
                    DB::update('orders_orderitem')->set(array('erp_line_status' => 1))->where('id', '=', $item_id)->execute();
                    Message::set(__('review_add_success'));
                    $this->request->redirect(Product::instance($product_id, LANGUAGE)->permalink());
                }
                else
                {
                    Message::set(__('post_data_error'), 'error');
                    $this->request->redirect(Request::instance()->uri());
                }
            }
            else
            {
                Message::set(__('need_log_in'), 'notice');
                $this->request->redirect(LANGPATH . '/customer/login?redirect=' . Request::instance()->uri());
            }
        }

        if(!$user)
        {
            $this->request->redirect(LANGPATH . '/customer/login?redirect=' . Request::instance()->uri());
        }
        $product_id = $this->request->param('id');
        if(!$product_id)
        {
            Message::set(__('review_data_error'), 'notice');
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
        $items = DB::query(Database::SELECT, 'SELECT i.id, i.order_id, i.attributes, i.erp_line_status FROM order_items i LEFT JOIN orders o ON i.site_id = o.site_id AND i.order_id = o.id WHERE i.product_id = ' . $product_id . ' AND o.customer_id = ' . $user . ' AND o.payment_status IN ("success", "verify_pass") ORDER BY o.id')->execute();
        $has_item = 0;
        $has_submited = 0;
        foreach($items as $item)
        {
            if($item['erp_line_status'] == '')
            {
                $has_item = 1;
                $items_data = $item;
            }
            elseif($item['erp_line_status'] == 1)
            {
                $has_submited = 1;
            }
        }
        if(empty($has_item))
        {
            if($has_submited)
            {
                Message::set(__('review_submit_already'), 'notice');
                $this->request->redirect(Product::instance($product_id, LANGUAGE)->permalink());
            }
            else
            {
                Message::set(__('review_data_error'), 'notice');
                $this->request->redirect(LANGPATH . '/customer/orders');
            }
        }
        $this->template->content = View::factory('/order/review')
            ->set('product_id', $product_id)
            ->set('items', $items_data)
            ->set('user_id', $user);
    }

    public function action_pagination()
    {
        $count = Arr::get($_REQUEST, 'count', 0);
        $limit = Arr::get($_REQUEST, 'limit', 0);
        $pagination = Pagination::factory(array(
            'current_page' => array('source' => 'query_string', 'key' => 'page'),
            'total_items' => $count,
            'items_per_page' => $limit,
            'view' => '/pagination_2'));
        $data = $pagination->render();
        echo json_encode($data);
        exit;
    }

    public function action_ajax_feedback()
    {
        if ($_POST)
        {
            $ip = Request::$client_ip;
            $now = time();
            $last_day = $now - 86400;
            $todayhas = DB::query(Database::SELECT, 'SELECT COUNT(id) AS count FROM feedbacks WHERE ip=' . ip2long($ip) . ' AND time >= ' . $last_day . ' AND time < ' . $now)->execute()->get('count');

            if ($todayhas >= 5)
            {
                $result['success'] = -1;
                $result['message'] = 'No more than 5 feedbacks in 24 hours!';
            }
            else
            {
                $result = array();
                $email = Arr::get($_POST, 'email1', '');
                if (!$email)
                {
                    $email = $email2 = Arr::get($_POST, 'email2', '');
                }
                $comment = Arr::get($_POST, 'comment', '');
                $what_like = Arr::get($_POST, 'what_like', '');
                $do_better = Arr::get($_POST, 'do_better', '');
                if (preg_match("/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i", $email))
                {
                    $data['site_id'] = 1;
                    $data['time'] = time();
                    $data['ip'] = ip2long(Request::$client_ip);
                    $data['email'] = $email;
                    if (strlen($comment) >= 5)
                    {
                        $comment = str_replace('<img', 'img', $comment);
                        $data['content'] = $comment;
                        $has = DB::select('id')->from('feedbacks')
                                ->where('email', '=', $data['email'])
                                ->where('content', '=', $data['content'])
                                ->execute()
                                ->get('id');
                        if ($has)
                        {
                            $result['success'] = -2;
                            $result['message'] = 'Your problem has been received!';
                            echo json_encode($result);
                            exit;
                        }
                        $result = DB::insert('feedbacks', array_keys($data))->values($data)->execute();
                        if ($result)
                        {
                            $result['success'] = 1;
                            $result['message'] = 'Your problem has been received!';
                        }
                        else
                        {
                            $result['success'] = 0;
                            $result['message'] = 'Your problem cannot be received!';
                        }
                    }
                    elseif (strlen($do_better) >= 5)
                    {
                        $data['what_like'] = $what_like;
                        $data['do_better'] = $do_better;
                        $has = DB::select('id')->from('feedbacks')
                                ->where('email', '=', $data['email'])
                                ->where('do_better', '=', $data['do_better'])
                                ->execute()
                                ->get('id');
                        if ($has)
                        {
                            $result['success'] = -2;
                            $result['message'] = 'Your feedback has been received!';
                            echo json_encode($result);
                            exit;
                        }
                        $result = DB::insert('feedbacks', array_keys($data))->values($data)->execute();
                        if ($result)
                        {
                            $result['success'] = 1;
                            $result['message'] = 'Your feedback has been received!';
                        }
                        else
                        {
                            $result['success'] = 0;
                            $result['message'] = 'Your feedback cannot be received!';
                        }
                    }
                    else
                    {
                        $result['success'] = 0;
                        $result['message'] = 'Your feedback cannot be received!';
                    }
                }
                else
                {
                    $result['success'] = 0;
                    $result['message'] = 'Please enter a valid email address!';
                }
            }
            echo json_encode($result);
            exit;
        }
    }

    public function action_globebill()
    {
        $order = Request::factory('order/set')->execute()->response;
        Session::instance()->set('current_order', $order->get('ordernum'));
        if (!$order)
        {
            Message::set(__('order_create_failed'), 'error');
            $this->request->redirect(LANGPATH . '/cart/check_out');
        }
        $amount = $order->get('payment_status') == 'partial_paid' ? $order->get('amount') - $order->get('amount_payment') : $order->get('amount');

        if (round((float) $amount, 2) < 0.01)
        {
            $order->set(array(
                'payment_status' => 'success',
                'amount_payment' => 0,
                'transaction_id' => 'point redeem',
                'payment_date' => time(),
            ));

            Message::set(__('order_create_success'), 'notice');
            $this->request->redirect(LANGPATH . '/payment/success/' . $order->get('ordernum'));
        }
        $customer_id = Customer::logged_in();
        $order_info = $order->get();
        if ($order_info['customer_id'] != $customer_id)
            $this->request->redirect(LANGPATH . '/404');
        $iframe = '';
        // 钱宝站内支付
        $MD5key = "8nf8jhX6";
        $MerNo = "10470";

        //订单号
        $BillNo = $order_info['ordernum'];
        //交易金额
        $Amount = round($order_info['amount'], 2);
        //币种代码 如GBP
        $PayCurrency = $order_info['currency'];
        //用户基本信息
        $user_info = $order_info['shipping_firstname'] . "|" . $order_info['shipping_lastname'] . "|" . $order_info['shipping_address'] . "|" . $order_info['shipping_city'] . "|" . strtolower($order_info['shipping_country']) . "|" . $order_info['shipping_zip'] . "|" . $order_info['email'] . "|" . $order_info['billing_phone'] . "|" . $order_info['shipping_state'] . "||0";
        //返回地址
        $ReturnURL = BASEURL. '/review/globebill_return';
        //remark
        // $Remark = $client_ip;
        //2个默认值 $Currency=15 $Language=2
        $Currency = "15";
        $Language = "2";

        //md5校验码 固定形式：md5($MerNo.$BillNo.$Currency.$Amount.$Language.$ReturnURL.$MD5key)
        $md5src = $MerNo . $BillNo . $Currency . $Amount . $Language . $ReturnURL . $MD5key;
        $MD5info = strtoupper(md5($md5src));
        //新商户号新接口
        $gatewayNo = 10470002;
        $signkey = '8nf8jhX6';
        $Amount = (floor($Amount * 100)) / 100;
        $signInfo = hash("sha256", $MerNo . $gatewayNo . $BillNo . $PayCurrency . $Amount . $ReturnURL . $signkey);
        $data = array(
            "post_url" => 'https://pay.securesslgateway.com/Interface',
//                    "post_url" => 'https://payment.globebill.com/Interface',
            'merNo' => $MerNo,
            'gatewayNo' => $gatewayNo,
            'orderNo' => $BillNo,
            'orderCurrency' => $PayCurrency,
            'orderAmount' => $Amount,
            'signInfo' => $signInfo,
            'returnUrl' => $ReturnURL,
            'firstName' => $order_info['shipping_firstname'],
            'lastName' => $order_info['shipping_lastname'],
            'country' => $order_info['shipping_country'],
            'city' => $order_info['shipping_city'],
            'address' => $order_info['shipping_address'],
            'zip' => $order_info['shipping_zip'],
            'email' => $order_info['email'],
            'phone' => $order_info['shipping_phone'],
        );

        $query = '';
        $data['address'] = preg_replace('/[^\b\w]+/i', '-', $data['address']);
        $data['zip'] = preg_replace('/[^\b\w]+/i', '-', $data['zip']);
        $email = explode('@', $data['email']);
        $str = preg_replace('/\W/', '_', $email[0]);
        $data['email'] = $str . '@' . $email[1];
        $data['firstName'] = preg_replace('/\W/', '_', $data['firstName']);
        $data['lastName'] = preg_replace('/\W/', '_', $data['lastName']);
        $data['city'] = preg_replace('/\W/', '_', $data['city']);
        foreach ($data as $key => $value)
        {
            if (strlen($value) < 2 AND $key != 'orderAmount')
            {
                $value .= '-';
            }
            $query .= ($key . '=' . $value . '&');
        }

        $iframe = '<iframe id="payment_insite_iframe" width="100%" height="400" scrolling="no" frameborder="no" src="' . BASEURL . '/review/insite_globebill/?' . $query . '"></iframe>';
        $this->template->content = View::factory( '/cart/check_out3')
                ->set('order', $order_info)
                ->set('iframe', $iframe);
    }

    public function action_insite_globebill()
    {
        $order_status = Order::instance(Order::get_from_ordernum($_GET['orderNo']))->get('payment_status');
        if ($order_status == 'success' OR $order_status == 'verify_pass')
        {
            echo '<script language="javascript">top.location.replace("' . BASEURL. '/payment/success/' . $_GET['orderNo'] . '");</script>';
            exit;
        }
        echo View::factory('/payment_insite_globebill')->render();
        exit;
    }

    public function action_globebill_return()
    {
//                Kohana_Log::instance()->add('GLOBEBILL1', serialize($_REQUEST))->write();
//              $a = 'a:15:{s:5:"merNo";s:5:"10040";s:9:"gatewayNo";s:8:"10040001";s:7:"tradeNo";s:22:"2013071103241790698612";s:7:"orderNo";s:11:"10335391340";s:11:"orderAmount";s:5:"77.97";s:13:"orderCurrency";s:3:"USD";s:11:"orderStatus";s:1:"1";s:9:"orderInfo";s:13:"0000_Approved";s:8:"signInfo";s:64:"CD6A7D34E17A814566C6CA33F52EDA7FE4C6CF9CDC72F2AF5E0654178B4F9B14";s:6:"remark";s:0:"";s:8:"riskInfo";s:140:"||sourceUrl=10.0;BinCountry=100.0;BlackList=100.0;Amount=100.0;PayNum=100.0;|0.0|100.0|2.52|monte dei paschi di siena|IT|49|2.224.23.120|IT|";s:14:"authTypeStatus";s:1:"0";s:6:"cardNo";s:13:"525500***0696";s:12:"EbanxBarCode";s:0:"";s:6:"isPush";s:1:"1";}';
//              $_REQUEST = unserialize($a);
        //MD5key和商户id，固定值 商户号为10032，新接口
        $is_pay_insite = Site::instance()->get('is_pay_insite');

        $merNo = $_REQUEST['merNo'];
        $gatewayNo = $_REQUEST['gatewayNo'];
        $tradeNo = $_REQUEST["tradeNo"];  //交易号

        if (!$tradeNo)
        {   //钱宝拒绝交易，交易号为空
            if ($is_pay_insite)
            {
                echo '<script language="javascript">top.location.replace("' . BASEURL . '/customer/orders");</script>';
            }
            else
            {
                $this->request->redirect(LANGPATH . '/customer/orders');
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
//                                        ->execute();
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

                Payment::instance('CC')->pay1($order, $data);
            }
        }
        elseif ($isPush == '')
        {
            if (substr($Result, 0, 5) == 'I0061')  //排除订单号重复(I0061)的交易
            {
                Message::set(__('order_repaid'), 'notice');
                if ($is_pay_insite)
                {
                    echo '<script language="javascript">top.location.replace("' . BASEURL . LANGPATH . '/payment/success/' . $BillNo . '");</script>';
                }
                else
                {
                    $this->request->redirect(BASEURL. LANGPATH . '/payment/success/' . $BillNo);
                }
            }
            else
            {
                $order = Order::instance(Order::get_from_ordernum($BillNo))->get();
                if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                {
                    echo '<script language="javascript">top.location.replace("' . BASEURL . LANGPATH . '/payment/success/' . $order['ordernum'] . '");</script>';
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

//                                        kohana_log::instance()->add('GLOBEBILL_POINTS', $amounts);
//                                        if ($amounts > 0)
//                                        {
//                                                Event::run('Order.payment', array(
//                                                    'amount' => (int) $amounts,
//                                                    'order'  => $order1,
//                                                ));
//                                        }
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
                $result = Payment::instance('CC')->pay1($order, $data);

                switch ($result)
                {
                    case 'SUCCESS':
                        Message::set(__('order_create_success'), 'notice');
                        if ($is_pay_insite)
                        {
                            echo '<script language="javascript">top.location.replace("' .BASEURL . LANGPATH . '/payment/success/' . $order['ordernum'] . '");</script>';
                        }
                        else
                        {
                            $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);
                        }
                        break;
                    case 'PENDING':
                        if ($is_pay_insite)
                        {
                            echo '<script language="javascript">top.location.replace("' . BASEURL . LANGPATH . '/payment/success/' . $order['ordernum'] . '");</script>';
                        }
                        else
                        {
                            $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);
                        }
                        break;
                    case 'FAILED':
                        Message::set(__($Result), 'error');
                        if ($is_pay_insite)
                        {
                            echo '<script language="javascript">top.location.replace("' . BASEURL . '/cart/shipping_billing/' . $order['ordernum'] . '");</script>';
                        }
                        else
                        {
                            $this->request->redirect(BASEURL . '/cart/shipping_billing/' . $order['ordernum']);
                        }
                        break;
                }
            }
        }
    }

    public function action_etags()
    {
        $file = $_SERVER['DOCUMENT_ROOT'] . '/css/all.css';
        $last_modified_time = filemtime($file);
        $etag = md5_file($file);

        header("Last-Modified: " . gmdate("D, d M Y H:i:s", $last_modified_time) . " GMT");
        header("Etag: $etag");

        if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $last_modified_time ||
                trim($_SERVER['HTTP_IF_NONE_MATCH']) == $etag)
        {
            header("HTTP/1.1 304 Not Modified");
            exit;
        }
    }

    public function action_youtube()
    {
        $id = $this->request->param('id');
        $product = Product::instance($id);
        $product->set_view_history();

        // if (isset($_GET['cid']) AND $_GET['cid'])
        // {
        //     Site::instance()->add_flow($_GET['cid'], 'product', $product->get('sku'));
        // }

        $this->template->title = $product->get('name') . ' | ' . 'Choies';
        $this->template->keywords = $product->get('name');
        $this->template->description = 'Shop for  the ' . $product->get('name') . ' online now.Choies.com offer the latest fashion  women ' . Set::instance($product->get('set_id'))->get('name') . ' at cheap prices with free shipping.';

        $celebrity_images = DB::select()->from('celebrity_images')->where('product_id', '=', $product->get('id'))->order_by('position')->execute()->as_array();
        if ($product->get('type') == 0)  //type 0 simple product
        {
            // include the php script  
            require(APPPATH . "classes/geoip.inc.php");

            $gi = geoip_open(APPPATH . "classes/GeoIP.dat", GEOIP_STANDARD);
            // 获取国家代码 
            $country_code = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);

            $attributes = $product->set_data();
            $color = $fabric = array();
            $fabricName = '';
            if (isset($attributes[3]))
            {
                $fabricArr = kohana::config('prdress.fabric');
                $fabricName = $attributes[3]['value'];
                $fabriclink = str_replace(' ', '-', strtolower($attributes[3]['value']));
                $fabric = $fabricArr[$fabriclink];
                $size = kohana::config('prdress.size');
                $delivery_time = kohana::config('prdress.delivery_time');
            }
            $this->template->content = View::factory('/product_prdress')
                    ->set('product', $product)
                    ->set('current_catalog', $current_catalog)
                    ->set('fabric', $fabric)
                    ->set('fabricName', $fabricName)
                    ->set('size', $size)
                    ->set('delivery_time', $delivery_time)
                    ->set('celebrity_images', $celebrity_images)
                    ->set('country_code', $country_code);
        }
        elseif ($product->get('type') == 3)  //type 3 simple config product
        {
            $attributes = $product->get('attributes');
            if (isset($attributes['Size']) OR isset($attributes['size']))
            {
                $one_size = 0;
                $attr_sizes = isset($attributes['Size']) ? $attributes['Size'] : $attributes['size'];
                if (count($attr_sizes) == 1 AND $attr_sizes[0] == 'one size')
                    $one_size = 1;
            }
            $attSize = array();
            $attColor = array();
            if (!empty($attributes))
            {
                if ($one_size)
                {
                    $attSize[] = 'one size';
                }
                elseif (strpos($attr_sizes[0], 'US') !== FALSE)
                {
                    // include the php script  
                    require(APPPATH . "classes/geoip.inc.php");

                    $gi = geoip_open(APPPATH . "classes/GeoIP.dat", GEOIP_STANDARD);
                    // 获取国家代码 
                    $country_code = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);
                    if ($country_code == 'US')
                    {
                        $index = 0;
                        $country = 'US';
                    }
                    elseif ($country_code == 'GB' OR $country_code == 'UK')
                    {
                        $index = 1;
                        $country = 'UK';
                    }
                    else
                    {
//                                        $countries = $gi->GEOIP_COUNTRY_CODE_TO_NUMBER;
//                                        $continents = $gi->GEOIP_CONTINENT_CODES;
//                                        $continent = $continents[$countries[$country_code]];
                        $index = 2;
                        $country = '';
                    }
                    foreach ($attr_sizes as $attr)
                    {
                        $attribute = explode('/', $attr);
                        $attSize[] = $country . preg_replace('/[A-Z]+/i', '', $attribute[$index]);
                    }
                }
                else
                {
                    $attSize = $attr_sizes;
                }
            }
            else
            {
                $attSize[] = 'one size';
            }
            if (isset($attributes['Color']) OR isset($attributes['color']))
            {
                $attColor = isset($attributes['Color']) ? $attributes['Color'] : $attributes['color'];
            }
            $attributess = array(
                'size' => $attSize,
                'color' => $attColor,
                'type' => isset($attributes['Type']) ? $attributes['Type'] : array()
            );

            $videos = DB::select(DB::expr('DISTINCT url_add'))->from('review_media')->where('product_id', '=', $product->get('id'))->execute()->as_array();

            $this->template->content = View::factory('/product')
                    ->set('product', $product)
                    ->set('current_catalog', $current_catalog)
                    ->set('celebrity_images', $celebrity_images)
                    ->set('attributes', $attributess)
                    ->set('videos', $videos);
        }

//                Cache::instance('memcache')->set($cache_key,$this->template,86400);
//          }
    }

    public function action_facebook()
    {
        $facebook = new facebook();
        $uid = $facebook->getUser();
        $fql = 'SELECT uid,page_id FROM page_fan WHERE page_id =1458055941084399 and uid=' . $uid;
        $param = array(
            'method' => 'fql.query',
            'query' => $fql,
            'callback' => ''
        );
        $fqlResult = $facebook->api($param);
        print_r($fqlResult);
        $this->template->content = View::factory('/facebook');
    }

    public function action_facebook_share()
    {
        $action = Arr::get($_POST, 'check_facebook_share', '');
        $product_id = Arr::get($_POST, 'goods_id', '');
        $type = Arr::get($_POST, 'type', '');
        $result = array();
        $result['status'] = 1;
        $result['sku'] = Product::instance($product_id)->get('sku');
        echo json_encode($result);
        exit;
    }

    public function action_catalog()
    {
        $catalog = Catalog::instance(53);
        $catalog_sqls = array();
        $parent_id = $catalog->get('parent_id');
        if ($parent_id == 0)
            $parent_id = $catalog->get('id');
        $children = Catalog::instance($parent_id)->posterity();
        $children[] = $parent_id;
        echo 'SELECT DISTINCT s.product_id, s.price, s.expired 
                    FROM carts_spromotions s LEFT JOIN products_categoryproduct c ON s.product_id=c.product_id 
                    WHERE c.category_id IN(' . implode(',', $children) . ') AND s.type = 6 AND s.expired + 36000 > ' . time() . ' 
                    ORDER BY s.expired LIMIT 0, 4';
        exit;
    }

    public function action_ppec_notify()
    {
        // $r = 'a:41:{s:8:"mc_gross";s:4:"0.01";s:7:"invoice";s:11:"11272821340";s:22:"protection_eligibility";s:8:"Eligible";s:14:"address_status";s:11:"unconfirmed";s:8:"payer_id";s:13:"P3JSDNXFUXJEC";s:3:"tax";s:4:"0.00";s:14:"address_street";s:17:"asdfasf asf asdaf";s:12:"payment_date";s:25:"19:34:32 Sep 03, 2014 PDT";s:14:"payment_status";s:9:"Completed";s:7:"charset";s:5:"UTF-8";s:11:"address_zip";s:5:"08650";s:10:"first_name";s:4:"hill";s:6:"mc_fee";s:4:"0.01";s:20:"address_country_code";s:2:"CA";s:12:"address_name";s:8:"Luca Mim";s:14:"notify_version";s:3:"3.8";s:6:"custom";s:0:"";s:12:"payer_status";s:10:"unverified";s:15:"address_country";s:6:"Canada";s:12:"address_city";s:5:"wuxi1";s:8:"quantity";s:1:"1";s:11:"verify_sign";s:56:"AxY4PZnLwHn-wCsVYatnHp9kp4-PAMUHsfFXiSWAccUnHaQfhHM-yU1R";s:11:"payer_email";s:22:"shijiangming09@163.com";s:13:"contact_phone";s:15:"+86 15850610942";s:6:"txn_id";s:17:"69193491SL6766010";s:12:"payment_type";s:7:"instant";s:9:"last_name";s:5:"jimmy";s:13:"address_state";s:7:"ONTARIO";s:14:"receiver_email";s:17:"paypal@choies.com";s:11:"payment_fee";s:4:"0.01";s:11:"receiver_id";s:13:"2M9SCQX9PGW8C";s:8:"txn_type";s:16:"express_checkout";s:9:"item_name";s:0:"";s:11:"mc_currency";s:3:"USD";s:11:"item_number";s:0:"";s:17:"residence_country";s:2:"CN";s:15:"handling_amount";s:4:"0.00";s:19:"transaction_subject";s:0:"";s:13:"payment_gross";s:4:"0.01";s:8:"shipping";s:4:"0.00";s:12:"ipn_track_id";s:13:"fb12a5debb434";}';
        // $_REQUEST = unserialize($r);
        print_r($_REQUEST);exit; 
        Kohana_Log::instance()->add('PPEC', serialize($_REQUEST))->write();
        $trans_id = Arr::get($_REQUEST, 'txn_id', '');
        $has = DB::select('id')->from('orders_orderpayments')->where('trans_id', '=', $trans_id)->execute()->get('id');
        if ($has)
        {
            exit;
        }
        $data = $_REQUEST;
        $data['first_name'] = Arr::get($data, 'first_name', '');
        $data['last_name'] = Arr::get($data, 'last_name', '');
        $data['address_street'] = Arr::get($data, 'address_street', '');
        $data['address_zip'] = Arr::get($data, 'address_zip', '');
        $data['address_city'] = Arr::get($data, 'address_city', '');
        $data['address_state'] = Arr::get($data, 'address_state', '');
        $data['address_country_code'] = Arr::get($data, 'address_country_code', '');
        if (isset($_REQUEST['invoice']))
        {
            $order_id = Order::instance()->get_from_ordernum($_REQUEST['invoice']);
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

            echo Payment::instance('EC')->pay($order, $data);
        }
        else
        {
            echo 'FAIL';
        }
    }
}
