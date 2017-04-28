<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Order extends Controller_Webpage
{

    public function action_view($ordernum = NULL)
    {
        $languages = Kohana::config('sites.language');
        if(in_array($ordernum, $languages))
        {
            $uri = $this->request->uri;
            $uris = explode('/', $uri);
            $ordernum = $uris[count($uris) - 1];
        }
        if (!($customer_id = Customer::logged_in()))
        {
            Message::set(__('need_log_in'), 'notice');
            Request::instance()->redirect(LANGPATH . '/customer/login?redirect=' . URL::current(TRUE));
        }

        if (!$ordernum)
        {
            Message::set(__('order_not_exist'), 'error');
            $this->request->redirect(LANGPATH . '/customer/orders');
        }

        $order = Customer::instance($customer_id)->get_order($ordernum);

        if ($_POST)
        {
            $amount = Arr::get($_POST, 'amount', 0);
            $product_amount = Arr::get($_POST, 'product_amount', 0);
            $delete_product = Arr::get($_POST, 'delete_product', '');
            if (!$amount && !$product_amount)
            {
                Message::set(__('cart_no_product'), 'note');
                $this->request->redirect(LANGPATH . '/cart/view');
            }
            if ($delete_product)
            {
                foreach ($order->products() as $product)
                {
                    if (strpos($delete_product, $product['product_id']) !== false)
                    {
                        DB::delete('orders_orderitem')->where('id', '=', $product['id'])->execute();
                    }
                }

                $products = unserialize($order->get('products'));
                {
                    foreach ($products as $key => $product)
                    {
                        if (strpos($delete_product, $product['id']) !== false)
                        {
                            unset($products[$key]);
                        }
                    }
                }
                DB::update('orders_order')->set(
                        array(
                            'products' => serialize($products),
                            'amount_products' => $amount,
                            'amount_order' => $amount + $order->get('amount_shipping'),
                            'amount' => $amount + $order->get('amount_shipping')
                        )
                    )
                    ->where('ordernum', '=', $ordernum)->execute();
            }
            $payment_method = Arr::get($_POST, 'payment_method', 'PP');
            DB::update('orders_order')->set(array('payment_method' => $payment_method, 'is_pre_order' => 1))->where('ordernum', '=', $ordernum)->execute();
            if ($payment_method == 'PP')
            {
                $this->request->redirect(LANGPATH . '/payment/pay/' . $ordernum . '?type=repaid');
            }
            elseif($payment_method == 'MASAPAY')
            {
                $this->request->redirect(LANGPATH . '/payment/masapay/' . $ordernum);
            }elseif($payment_method == 'MASAPAYINNER')
            {
                $this->request->redirect(LANGPATH . '/payment/masapay_inner/' . $ordernum);
            }
            elseif ($payment_method == 'GC')
            {
                $orderData = DB::select()->from('orders_order')->where('ordernum', '=', $ordernum)->execute()->current();
                if(!$orderData['billing_address'])
                {
                    $billing_address = array(
                        'billing_firstname' => $orderData['shipping_firstname'],
                        'billing_lastname' => $orderData['shipping_lastname'],
                        'billing_address' => $orderData['shipping_address'],
                        'billing_city' => $orderData['shipping_city'],
                        'billing_state' => $orderData['shipping_state'],
                        'billing_country' => $orderData['shipping_country'],
                        'billing_zip' => $orderData['shipping_zip'],
                        'billing_phone' => $orderData['shipping_phone']
                    );
                    DB::update('orders_order')->set($billing_address)->where('id', '=', $orderData['id'])->execute();
                }
                $this->request->redirect(LANGPATH . '/payment/ocean_pay/' . $ordernum .  '?type=repaid');
            }
            elseif ($payment_method == 'OC')
            {
                $orderData = DB::select()->from('orders_order')->where('ordernum', '=', $ordernum)->execute()->current();
                if(!$orderData['billing_address'])
                {
                    $billing_address = array(
                        'billing_firstname' => $orderData['shipping_firstname'],
                        'billing_lastname' => $orderData['shipping_lastname'],
                        'billing_address' => $orderData['shipping_address'],
                        'billing_city' => $orderData['shipping_city'],
                        'billing_state' => $orderData['shipping_state'],
                        'billing_country' => $orderData['shipping_country'],
                        'billing_zip' => $orderData['shipping_zip'],
                        'billing_phone' => $orderData['shipping_phone']
                    );
                    DB::update('orders_order')->set($billing_address)->where('id', '=', $orderData['id'])->execute();
                }
                $this->request->redirect(LANGPATH . '/payment/ocean_pay/' . $ordernum .  '?type=repaid');
            }
            elseif ($payment_method == 'SOFORT')
            {
                $this->request->redirect('https://' . $_SERVER['HTTP_HOST'] . LANGPATH . '/payment/sofort_pay/' . $ordernum .  '?type=repaid');
            }
            elseif ($payment_method == 'IDEAL')
            {
                $this->request->redirect('https://' . $_SERVER['HTTP_HOST'] . LANGPATH . '/payment/ideal_pay/' . $ordernum .  '?type=repaid');
            } 
        }
        if ($order->get('id'))
        {
            $order_message = DB::select('message')->from('orders_ordermessages')->where('order_id', '=', $order->get('id'))->execute()->get('message');
            $order_statuses = kohana::config('order_status');
            $order_history = $order->histories();
            $order_remarks = $order->remarks();
            $payment_history = $order->payments();
            $config['return_url'] = URL::site(NULL, TRUE) . 'payment/success/' . $order->get('ordernum');
            $this->template->content = View::factory('/order/detail')
                ->set('order', $order)->set('order_message', $order_message);
        }
        else
        {
            message::set(__('order_status_pre') . $ordernum . __('order_status_not_exits_suffix'), 'notice');
            Request::instance()->redirect(LANGPATH . '/customer/orders');
        }
    }

    public function action_paynow($ordernum)
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }

        if (!$ordernum)
        {
            Message::set(__('order_not_exist'), 'error');
            $this->request->redirect(LANGPATH . '/customer/orders');
        }

        $order = Customer::instance($customer_id)->get_order($ordernum);

        if ($order->get('id') AND in_array($order->get('payment_status'), array('new', 'partial_paid', 'failed')))
        {
            $order_data = $order->get();
            $order_data['products'] = $order->products();
            $order_statuses = kohana::config('order_status');
            $order_history = $order->histories();
            $order_remarks = $order->remarks();
            $payment_history = $order->payments();

            foreach (date::months() as $k => $v)
            {
                $month_arr[sprintf('%02d', $v)] = sprintf('%02d', $v);
            }

            $exp_month_arr = $month_arr;
            $valid_month_arr = $month_arr;

            $exp_year_arr = date::years(date('Y'), date('Y') + 9);
            $valid_year_arr = date::years(date('Y') - 9, date('Y'));

            $form_arr['cc_exp_month'] = Form::select('cc_exp_month', $exp_month_arr);
            $form_arr['cc_exp_year'] = Form::select('cc_exp_year', $exp_year_arr);
            $form_arr['cc_valid_month'] = Form::select('cc_valid_month', $valid_month_arr);
            $form_arr['cc_valid_year'] = Form::select('cc_valid_year', $valid_year_arr);

            $template = View::factory('/order_paynow')
                ->set('order', $order_data)
                ->set('order_statuses', $order_statuses)
                ->set('order_remarks', $order_remarks)
                ->set('order_history', $order_history)
                ->set('form_arr', $form_arr)
                ->set('countries', Site::instance()->countries())
                ->render();
            $this->request->response = $template;
        }
        else
        {
            message::set(__('order_status_pre') . $ordernum . __('order_paid_or_not_exitst'), 'notice');
            Request::instance()->redirect('customer/orders');
        }
    }

    public function action_cancel($ordernum)
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
        $customer = Customer::instance($customer_id);
        $order = $customer->get_order($ordernum);
        if ($order->get('id'))
        {
            if ($order->go_to_cancel())
            {
                Message::set(__('order_cancel_success'), 'success');
            }
            else
            {
                message::set(__('order_status_pre') . $ordernum . __('order_status_not_cancel_suffix'), 'notice');
            }
        }
        else
        {
            message::set(__('order_status_pre') . $ordernum . __('order_status_not_exits_suffix'), 'notice');
        }

        $redirect = Arr::get($_GET, 'r', '/customer/orders');
        $this->request->redirect($redirect);
    }

    public function action_set()
    {
        $this->auto_render = '';
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=cart/check_out');
        }

        // create order information
        $cart = Cart::get();
        if (count($cart['products']) == 0)
            Request::instance()->redirect(URL::base());

        if(empty($cart['shipping_address']['shipping_address']))
        {
            Message::set(__('order_create_failed'), 'error');
            $referer = $_SERVER['HTTP_REFERER'];
            if(toolkit::is_our_url($referer))
                Request::instance()->redirect($referer);
            else
                Request::instance()->redirect(URL::base());
        }

        $customer = Customer::instance($customer_id);
        $flag = $customer->get('flag');

        $order_id = Order::init();
        $order = Order::instance($order_id);

        Session::instance()->set('current_order', $order->get('ordernum'));

        if(Session::instance()->get('is_mobile')){
            $data['erp_fee_line_id'] = 1;//手机访问标记
        }
        else{
            $data['erp_fee_line_id'] = 0;
        }
        $data['refund_status'] = 'none';
        $data['updated'] = time();

//set customer
        $data['customer_id'] = $customer->get('id');
        $data['email'] = $customer->get('email');
        $data['ip'] = sprintf('%u', ip2long(Request::$client_ip));
        $data['is_active'] = 1;

// set shipping address
        $data = array_merge($data, $cart['shipping_address']);
        kohana_log::instance()->add($order_id . '_shipping_address', serialize($cart['shipping_address']));

// save customer shipping address
        if ($cart['shipping_address']['shipping_address_id'] === 'new')
        {
            $address = array(
                'customer_id' => $customer_id,
                'firstname' => $cart['shipping_address']['shipping_firstname'],
                'lastname' => $cart['shipping_address']['shipping_lastname'],
                'address' => $cart['shipping_address']['shipping_address'],
                'city' => $cart['shipping_address']['shipping_city'],
                'zip' => $cart['shipping_address']['shipping_zip'],
                'state' => $cart['shipping_address']['shipping_state'],
                'country' => $cart['shipping_address']['shipping_country'],
                'phone' => $cart['shipping_address']['shipping_phone'],
                'other_phone' => "",
            );
            if ($cart['shipping_address']['shipping_country'] == 'BR')
            {
                $address['cpf'] = $cart['shipping_address']['shipping_cpf'];
            }
            Address::instance()->set($address);
        }
        else
        {
            $address = Address::instance($cart['shipping_address']['shipping_address_id'])->get();
            if ($address['country'] == 'BR' AND $address['cpf'] == '')
            {
                DB::update('accounts_address')->set(array('cpf' => $cart['shipping_address']['shipping_cpf']))
                    ->where('id', '=', $cart['shipping_address']['shipping_address_id'])
                    ->execute();
            }
        }

// set billing address
        $data = array_merge($data, isset($cart['billing_address']) ? $cart['billing_address'] : array());

// set billing information
        if(!empty($cart['billing']))
            $data = array_merge($data, $cart['billing']);

// set currency
        $currency = Site::instance()->currency();
        $data['currency'] = $currency['name'];
        $data['rate'] = $currency['rate'];

// set shipping
        $data['shipping_method'] = isset($cart['shipping']['carrier']['carrier']) ? $cart['shipping']['carrier']['carrier'] : '';
        $data['shipping_weight'] = $cart['weight'];

// set amount
        $data['amount_products'] = Site::instance()->price($cart['amount']['items']);

        $priceshipping = 0;
        $tproduct = count($cart['products']);
        $giftarr = Site::giftsku();
        foreach ($cart['products'] as $p){
            if(in_array($p['id'],$giftarr) && $tproduct == 1){
                 $priceshipping = 1;
            }
        } 

        if($priceshipping && !$cart['amount']['shipping']){
            $data['amount_shipping'] = 7.0000;
        }else{
            $data['amount_shipping'] = Site::instance()->price($cart['amount']['shipping']);
        }

        $amount_ship = Session::instance()->get('amount_ship');     
        if(!empty($amount_ship))
        {
            $data['amount_shipping'] = 15.0000;
        }
        
        $data['amount_coupon'] = Site::instance()->price($cart['amount']['coupon_save']);
        if(Session::instance()->get('insurance') > 0){
            if ($cart['amount']['total'] < 0)
                $cart['amount']['total'] = 0;
            $data['amount_order'] = Site::instance()->price($cart['amount']['total'] + $cart['amount']['insurance']); 
        }else{
            $data['amount_order'] = Site::instance()->price($cart['amount']['total']);
        }
        if ($data['amount_order'] < 0)
            $data['amount_order'] = 0;

        $amount_orders = ceil($data['amount_order']);
        if($data['amount_shipping'] == 7.0000 and empty($amount_orders))
        {
           $data['amount'] = 7.0000; 
        }
        else
        {
           $data['amount'] = $data['amount_order']; 
        }

// set points
        $data['points'] = $cart['points'];

// set coupon
        $data['coupon_code'] = $cart['coupon'];

// set drop shipping
        $data['drop_shipping'] = isset($cart['drop_shipping']) ? $cart['drop_shipping'] : 0;

// set promotion
        $data['promotions'] = isset($cart['promotion_logs']) ? serialize($cart['promotion_logs']) : '';

// set largesses
        $data['largesses'] = isset($cart['largesses']) ? serialize($cart['largesses']) : '';

// record affiliate id
        $data['affiliate_id'] = isset($_COOKIE['aid']) ? $_COOKIE['aid'] : 0;

//set order_insurance
        if(Session::instance()->get('insurance') == -1){
            $data['order_insurance'] = 0;
        }else{
            $data['order_insurance'] = $cart['amount']['insurance'];
        }

//set face cpc biaoshi
        if(Session::instance()->get('facecpc')){
            $data['facebook_cpc'] = 1;
        }else{
             $data['facebook_cpc'] = 0;
        }

//set source_league
        if(strtolower(Kohana_cookie::get('ChoiesCookie'))){
            $data['source_league'] = strtolower(Kohana_cookie::get('ChoiesCookie'));
        }else{
            $data['source_league'] = '';
        }

// record point payment record
        $points_used = $cart['points'];
        if ($points_used > 0)
        {
            $customer->add_point_payment(array(
                'amount' => $points_used,
                'order_id' => $order->get('id'),
                'order_num' => $order->get('ordernum'),
                'order_date' => $order->get('created'),
            ));
            $customer_points = $customer->points();
            if ($points_used > $customer_points)
                $points_used = $customer_points;
            $customer->point_dec($points_used);
        }

//set language
        $data['lang'] = $this->language;

//set order_from
        if($flag == 3)
        {
            $data['order_from'] = 'wholesale';        
        }
        
// set basic data
        if ($order->set($data))
        {
// set product
            $order->set_products($cart['products']);
            foreach ($cart['products'] as $p)
            {
                if ($p['is_killer'])
                {
                    $freebie_id = DB::select('id')->from('freebies')
                            ->where('product_id', '=', $p['id'])
                            ->and_where('email', '=', $data['email'])
                            ->execute()->get('id');
                    DB::update('freebies')->set(array('order_id' => $order->get('id')))->where('id', '=', $freebie_id)->execute();
                }
            }
            if (isset($cart['largesses']))
                $order->set_largesses($cart['largesses']);
            $product = Product::instance($cart['coupon_item']);
            if ($product->get('id'))
            {
                $attribute = array('Size'=>'one size');
                $item_id = DB::select('id')->from('products_productitem')
                    ->where('product_id','=',$product->get('id'))
                    ->execute('slave')
                    ->current();
                $order->add_product(array(
                    'id' => $product->get('id'),
                    'type' => 4,
                    'items' => array($item_id['id']),
                    'price' => 0,
                    'quantity' => 1,
                    'attributes' =>$attribute
                ));
            }
            // set coupon
            if ($cart['coupon'])
            {
                Coupon::instance($cart['coupon'])->apply();
            }

            //cartcookie
            foreach ($cart['products'] as $key => $value) {
                DB::delete('carts_cartitem')->where('customer_id', '=', $customer_id)->and_where('item_id', '=', $value['items'][0])->and_where('key', '=', $value['attributes']['Size'])->execute();
            }

            //add order message
            $cart_message = Cart::message();
            if(strlen($cart_message) > 0)
            {
                $array = array(
                    'order_id' => $order->get('id'),
                    'message' => $cart_message,
                    'created' => time(),
                );
                DB::insert('orders_ordermessages', array_keys($array))->values($array)->execute();
            }
            
            Cart::clear();
            
            Session::instance()->delete('no_coupon');
            Session::instance()->delete('shipping_price');
            Session::instance()->delete('insurance');
            Session::instance()->delete('facecpc');
            Session::instance()->set('facecpc', 0);
            Session::instance()->delete('amount_ship');
            //set cityads click_id
            $click_id=Arr::get($_COOKIE, 'click_id', 0);
            if($click_id!=0){
                DB::insert('cityads', array('order_id','ordernum','click_id'))
                    ->values(array(
                        'order_id'=>$order->get('id'),
                        'ordernum'=>$order->get('ordernum'),
                        'click_id'=>$click_id,
                        ))->execute();
            }

            //send order confirmed mail --- hide by sjm 2015-12-25
            // $mail_params['email'] = $order->get('email');
            // $mail_params['firstname'] = $order->get('shipping_firstname');
            // $mail_params['order_num'] = $order->get('ordernum');
            // Mail::SendTemplateMail('Order Confirmed', $mail_params['email'], $mail_params);
            $this->request->response = $order;
        }
        else
        {
            DB::delete('orders_order')->where('id', '=', $order_id)->where('email', 'IS', NULL)->execute();
            $this->request->response = FALSE;
        }
    }

    public function action_edit_address()
    {
        $id = $this->request->param('id');
        $customer_id = Customer::logged_in();
        if(!$customer_id)
            $this->request->redirect(LANGPATH . '/customer/orders');
        $order_id = DB::select('id')->from('orders_order')->where('customer_id', '=', $customer_id)->where('id', '=', $id)->execute()->get('id');
        if(!$order_id)
            $this->request->redirect(LANGPATH . '/customer/orders');
        if($_POST)
        {
            $type = Arr::get($_POST, 'type', 'shipping');
            if($type == 'shipping')
            {
                $shipping_address = array(
                    'shipping_firstname' => $_POST['shipping_firstname'],
                    'shipping_lastname' => $_POST['shipping_lastname'],
                    'shipping_address' => $_POST['shipping_address'],
                    'shipping_city' => $_POST['shipping_city'],
                    'shipping_state' => $_POST['shipping_state'],
                    'shipping_country' => $_POST['shipping_country'],
                    'shipping_zip' => $_POST['shipping_zip'],
                    'shipping_phone' => $_POST['shipping_phone'],
                );
                DB::update('orders_order')->set($shipping_address)->where('id', '=', $order_id)->execute();
                $return = Arr::get($_POST, 'return', LANGPATH . '/orders/view/' . Order::instance()->get('ordernum'));
                $this->request->redirect($return);
            }
            elseif($type == 'billing')
            {
                $billing_address = array(
                    'billing_firstname' => $_POST['billing_firstname'],
                    'billing_lastname' => $_POST['billing_lastname'],
                    'billing_address' => $_POST['billing_address'],
                    'billing_city' => $_POST['billing_city'],
                    'billing_state' => $_POST['billing_state'],
                    'billing_country' => $_POST['billing_country'],
                    'billing_zip' => $_POST['billing_zip'],
                    'billing_phone' => $_POST['billing_phone'],
                );
                DB::update('orders_order')->set($billing_address)->where('id', '=', $order_id)->execute();
                $return = Arr::get($_POST, 'return', LANGPATH . '/orders/view/' . Order::instance()->get('ordernum'));
                $this->request->redirect($return);
            }
        }
    }

    public function action_set_message()
    {
        if($_POST)
        {
            $message = trim(Arr::get($_POST, 'message', ''));
            $order_id = Arr::get($_POST, 'order_id', 0);
            if($message OR $order_id)
            {
                $array = array(
                    'order_id' => $order_id,
                    'message' => $message,
                    'created' => time(),
                );
                $has = DB::select('id')->from('orders_ordermessages')->where('order_id', '=', $order_id)->execute()->get('id');
                if($has)
                    $result = DB::update(orders_ordermessages)->set($array)->where('id', '=', $has)->execute();
                else
                    $result = DB::insert('orders_ordermessages', array_keys($array))->values($array)->execute();
                if($result)
                {
                    $orders = Order::instance($order_id)->get();
                    $mail_params['email'] = $orders['email'];
                    $mail_params['firstname'] = $orders['shipping_firstname'];
                    $mail_params['toemail'] = 'service@choies.com';
                    $mail_params['message'] = $message;
                    $mail_params['ordernum'] = $orders['ordernum'];
                    Mail::Sendmessage($mail_params['toemail'],$mail_params);
                    Message::set('Add message success!', 'success');
                }
                else
                {
                    Message::set('Add message failed', 'error');
                }
            }
            $this->request->redirect(LANGPATH . '/order/view/' . Order::instance($order_id)->get('ordernum'));
        }
    }

}

