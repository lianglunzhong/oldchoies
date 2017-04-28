<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Customer extends Controller_Webpage
{

    public function action_view()
    {
        $content['redirect'] = Arr::get($_GET, 'redirect', 0);
        $response = Request::factory('customer/orders', $content)->execute();
        $this->request->response = $response;
    }

    public function action_login()
    {

        $redirect = Arr::get($_GET, 'redirect', NULL);
        if ($_POST)
        {
            $data = array();
            $data['email'] = Arr::get($_POST, 'email', '');

            //guo add 12.3 防止机器请求
            $cache_key = "login_email" .$data['email'];
            $cache = Cache::instance('memcache');
            $totime = $cache->get($cache_key);

            if($totime >=5){
                return 503;
                exit;
            }

            $data['password'] = Arr::get($_POST, 'password', '');
            $data['hashed'] = Arr::get($_POST, 'hashed', FALSE);
            $referer = Arr::get($_POST, 'referer', '');

            $get_data = Arr::get($_POST, 'data', '');
            $getData = array();
            if($get_data)
            {
                $getArr = explode('|', $get_data);
                foreach($getArr as $g)
                {
                    $gs = explode('__', $g);
                    if(isset($gs[1]))
                    {
                        $getData[] = $gs[0] . '=' . $gs[1];
                    }
                }
            }
            if(!empty($getData))
            {
                if($redirect)
                    $redirect .= '?' . implode('&', $getData);
                else
                {
                    if(strpos($referer, '?') !== False)
                        $referer .= '&' . implode('&', $getData);
                    else
                        $referer .= '?' . implode('&', $getData);
                }
            }

            //set memcache
            //guo add 12.3 防止机器请求
            $istoo = Kohana_Cookie::get('time_now');
            if(!$istoo){
                Kohana_Cookie::set('time_now', 1, 180);
                $cache->set($cache_key, 1, 120);  
            }
            $istoo = Kohana_Cookie::get('time_now');
            if($istoo){
                $totime += 1;
                $cache->set($cache_key, $totime, 120);                
            }

            if ($customer_id = Customer::instance()->login($data))
            {
                $ppec_status = Customer::instance($customer_id)->get('ppec_status');
                if(0)
                {
                    $coupon_code = 'SIGNUP15OFF' . $customer_id;
                    $coupon = array(
                        // 'site_id' => $this->site_id,
                        'code' => $coupon_code,
                        'value' => 15,
                        'type' => 1,
                        'limit' => 1,
                        'used' => 0,
                        'created' => time(),
                        'expired' => time() + 30 * 86400,
                        'on_show' => 0,
                        'deleted' => 0,
                        'effective_limit' => 0,
                        'usedfor' => 1
                    );
                    $insert = DB::insert('carts_coupons', array_keys($coupon))->values($coupon)->execute();
                    if ($insert)
                    {
                        $c_coupon = array(
                            'customer_id' => $customer_id,
                            'coupon_id' => $insert[0],
                            'deleted' => 0
                            // 'site_id' => $this->site_id
                        );
                        DB::insert('carts_customercoupons', array_keys($c_coupon))->values($c_coupon)->execute();
                        $mail_params['email'] = $data['email'];
                        $mail_params['firstname'] = 'Choieser';
                        $mail_params['Code'] = $coupon_code;
                        $mail_params['expired'] = date('Y-m-d H:i', $coupon['expired']);
                        
                        $currencys = Site::instance()->currencies();
                        $porders = DB::select('amount', 'currency', 'shipping_firstname')->from('orders_order')->where('customer_id', '=', $customer_id)->where('payment_status', '=', 'verify_pass')->execute();
                        $points = 0;
                        foreach ($porders as $key => $o)
                        {
                            if ($key == 0)
                                $points = 1000;
                            else
                                $points += floor($o['amount'] / $currencys[$o['currency']]['rate']);
                            $mail_params['firstname'] = $o['shipping_firstname'];
                        }
                        $mail_params['Points'] = $points;
                        $mail_params['Value'] = $points / 100;
                        $send = Mail::SendTemplateMail('PP Login Confirmation', $mail_params['email'], $mail_params);
                        if($send)
                        {
                            DB::update('accounts_customers')->set(array('ppec_status' => 1))->where('id', '=', $customer_id)->execute();
                        }
                    }
                }
                
                if($redirect=="/tracks/track_order"&&isset($_POST['tmp_code'])){
                    Session::instance()->set('tmp_code', $_POST['tmp_code']);
                }

                //cartcookie
                Cookie::set('cookie_id',$customer_id,5184000);//60 days expire
                $products = Session::instance()->get('cart_products', array());
                if(is_array($products)&& count($products)>0){
                    foreach ($products as $key => $value) {
                        //初始化数据
                $datas = array();
                $datas['item_id'] = $value['items'][0];
                $datas['qty'] = $value['quantity'];
                // $productattribute = DB::select()->from('products_productattribute')->where('product_id','=',$value['id'])->execute()->current();
    
                // $datas['attribute'] = $productattribute['options'];
               
                $datas['key'] = $value['attributes']['Size'];

                        $cookieproducts = DB::select()->from('carts_cartitem')->where('customer_id','=',$customer_id)
                            ->and_where('item_id', '=', $value['items'][0])
                            ->and_where('key', '=', $value['attributes']['Size'])
                            ->execute()->current();
                        if($cookieproducts){
                    DB::update('carts_cartitem')->set($datas)
                    ->where('id', '=', $cookieproducts['id'])->execute();
                        }else{
                    DB::insert('carts_cartitem', array('customer_id','item_id','qty','key','is_cart','created'))
                    ->values(array('customer_id'=> $customer_id,
                        'item_id'=>$datas['item_id'],
                        'qty'=>$value['quantity'],
                        'key'=>$value['attributes']['Size'],
                        'is_cart' => 0,
                        'created'=>time(),))
                    ->execute();

                        }
                    }
                }
                
                //判断是否为红人，及获取红人admin的email设置session
                // Customer::instance($customer_id)->login_action();

                //added login cookie 7 days, 添加登陆状态cookie 7天
                $remember_me = Arr::get($_POST, 'remember_me', '');
                if($remember_me == 'on')
                {
                    $this->add_login_cookie($customer_id);
                }

                ($redirect AND toolkit::is_our_url($redirect)) ?
                        Request::instance()->redirect($redirect) :
                        toolkit::is_our_url($referer) ?
                            Request::instance()->redirect($referer) :
                            Request::instance()->redirect(LANGPATH);
            }
            else
            {
                Session::instance()->set('login_email', $data['email']);
                $has_email = DB::select('id')->from('accounts_customers')->where('email', '=', $data['email'])->execute('slave')->get('id');
                if($has_email)
                    $message = __('login_password_error');
                else
                    $message = __('login_email_error');
                message::set($message, 'error');
                $this->request->redirect(LANGPATH . '/customer/login?redirect=' . $redirect);
            }
        }
        $referer = (isset($_SERVER['HTTP_REFERER']) AND toolkit::is_our_url($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
        if ($customer_id = Customer::logged_in())
        {
            if (!$referer || strpos($referer, 'customer/login') || strpos($referer, 'customer/register'))
            {
                //if customer is login, referer is null or referer is login or register, direct to index page.
                Request::instance()->redirect(LANGPATH . '/customer/summary');
            }
            else
            {
                toolkit::is_our_url($referer) ? Request::instance()->redirect($referer) : Request::instance()->redirect(LANGPATH . '/customer/summary');
            }
        }
//        if (Arr::get($_SERVER, 'HTTPS', 'off') != 'on')
//        {
//            $redirects = $redirect ? '?redirect=' . $redirect : '';
//            Request::Instance()->redirect(LANGPATH . URL::site(Request::Instance()->uri . $redirects, 'https'));
//        }
		$lang=LANGUAGE;
		$seoinfo=array(
                "de"=>array("title"=>"Anmelden"),
                "es"=>array("title"=>"Acceder"),
                "fr"=>array("title"=>"Se connecter"),
                "ru"=>array("title"=>"Войти"),
                );
		if($lang!=""){
			$this->template->title = $seoinfo[$lang]['title'];
		}else{
			$this->template->title = "Log In";
		}
        $this->template->content = View::factory('/login')
            ->set('referer', $referer);
    }

    public function action_ajax_login()
    {
        $return = array();
        if ($_POST)
        {
            $data = array();
            $data['email'] = Arr::get($_POST, 'email', '');
            $data['password'] = Arr::get($_POST, 'password', '');
            $data['hashed'] = Arr::get($_POST, 'hashed', FALSE);

            if ($customer_id = Customer::instance()->login($data))
            {
                $ppec_status = Customer::instance($customer_id)->get('ppec_status');
                if($ppec_status == 0)
                {
                    $coupon_code = 'SIGNUP15OFF' . $customer_id;
                    $coupon = array(
                        // 'site_id' => $this->site_id,
                        'code' => $coupon_code,
                        'value' => 15,
                        'type' => 1,
                        'limit' => 1,
                        'used' => 0,
                        'created' => time(),
                        'expired' => time() + 30 * 86400,
                        'on_show' => 0,
                        'deleted' => 0,
                        'effective_limit' => 0,
                        'usedfor' => 1
                    );
                    $insert = DB::insert('carts_coupons', array_keys($coupon))->values($coupon)->execute();
                    if ($insert)
                    {
                        $c_coupon = array(
                            'customer_id' => $customer_id,
                            'coupon_id' => $insert[0],
                            'deleted' => 0
                            // 'site_id' => $this->site_id
                        );
                        DB::insert('carts_customercoupons', array_keys($c_coupon))->values($c_coupon)->execute();
                        $mail_params['email'] = $data['email'];
                        $mail_params['firstname'] = 'Choieser';
                        $mail_params['Code'] = $coupon_code;
                        $mail_params['expired'] = date('Y-m-d H:i', $coupon['expired']);
                        
                        $currencys = Site::instance()->currencies();
                        $porders = DB::select('amount', 'currency', 'shipping_firstname')->from('orders_order')->where('customer_id', '=', $customer_id)->where('payment_status', '=', 'verify_pass')->execute();
                        $points = 0;
                        foreach ($porders as $key => $o)
                        {
                            if ($key == 0)
                                $points = 1000;
                            else
                                $points += floor($o['amount'] / $currencys[$o['currency']]['rate']);
                            $mail_params['firstname'] = $o['shipping_firstname'];
                        }
                        $mail_params['Points'] = $points;
                        $mail_params['Value'] = $points / 100;
                        $send = Mail::SendTemplateMail('PP Login Confirmation', $mail_params['email'], $mail_params);
                        if($send)
                        {
                            DB::update('accounts_customers')->set(array('ppec_status' => 1))->where('id', '=', $customer_id)->execute();
                        }
                    }
                }
                
                if(isset($redirect) && $redirect == "/track/track_order" && isset($_POST['tmp_code'])){
                    Session::instance()->set('tmp_code', $_POST['tmp_code']);
                }
                
                Customer::instance($customer_id)->login_action();
                //added login cookie 7 days, 添加登陆状态cookie 7天
                $remember_me = Arr::get($_POST, 'remember_me', '');
                if($remember_me == 'on')
                {
                    $this->add_login_cookie($customer_id);
                }
                $firstname = DB::select('firstname')->from('accounts_customers')->where('id', '=', $customer_id)->execute('slave')->get('firstname');
				if(!$firstname){
					$firstname='Choieser';
				}
                $return['success'] = 1;
                $return['firstname'] = $firstname;
            }
            else
            {
                Session::instance()->set('login_email', $data['email']);
                $return['success'] = 0;
                $return['message'] = __('site_login_error');
            }
        }
        echo json_encode($return);
        exit;
    }

    public function action_ajax_login1()
    {
        if (!Request::$is_ajax)
            die('Hacker Attack!');
        $user_id = Customer::logged_in();
        $user = Customer::instance($user_id)->get();
        if ($user)
        {
            $return = $user_id;
        }
        else
        {
            $return = 0;
        }
        echo json_encode($return);
        exit;
    }

    public function action_ajax_register()
    {
        $return = array();
        if ($_POST)
        {
            $data = array();
            $data['email'] = Arr::get($_POST, 'email', '');
            $data['email'] = Security::xss_clean($data['email']);
            if (!Validate::email($data['email']))
            {
                $return['success'] = 0;
                $return['message'] = __('site_regist_error');
            }
            else
            {
                $data['firstname'] = Arr::get($_POST, 'firstname', '');
                $data['lastname'] = Arr::get($_POST, 'lastname', '');
                $data['password'] = Arr::get($_POST, 'password', '');
                $data['confirm_password'] = Arr::get($_POST, 'confirm_password', '');
                $data['ip'] = ip2long(Request::$client_ip);

                if (!Customer::instance()->is_register($data['email']))
                {
                    if ($data['ip'] != 0)
                        $has_ip = DB::select('id')->from('accounts_customers')->where('ip', '=', $data['ip'])->execute()->get('id');
                    else
                        $has_ip = 0;
                    $data['lang'] = $this->language;
                    if ($customer_id = Customer::instance()->set($data))
                    {
                        //celebrity add customer_id
                        $celebrity = DB::select('id', 'customer_id')->from('celebrities_celebrits')->where('email', '=', $data['email'])->execute()->current();
                        if (!empty($celebrity) AND $celebrity['customer_id'] == 0)
                        {
                            DB::update('celebrities_celebrits')->set(array('customer_id' => $customer_id))->where('id', '=', $celebrity['id'])->execute();
                        }

                        $coupon_code = 'SIGNUP15OFF' . $customer_id;
                        $coupon = array(
                            // 'site_id' => $this->site_id,
                            'code' => $coupon_code,
                            'value' => 15,
                            'type' => 1,
                            'limit' => 1,
                            'used' => 0,
                            'created' => time(),
                            'expired' => time() + 30 * 86400,
                            'on_show' => 0,
                            'deleted' => 0,
                            'effective_limit' => 0,
                            'usedfor' => 1
                        );
                        $insert = DB::insert('carts_coupons', array_keys($coupon))->values($coupon)->execute();
                        if ($insert)
                        {
                            $c_coupon = array(
                                'customer_id' => $customer_id,
                                'coupon_id' => $insert[0],
                                'deleted' => 0
                                // 'site_id' => $this->site_id
                            );
                            DB::insert('carts_customercoupons', array_keys($c_coupon))->values($c_coupon)->execute();
                            $mail_params['coupon_code'] = $coupon_code;
                            $mail_params['expired'] = date('Y-m-d H:i', $coupon['expired']);
                        }
                        $customer = Customer::instance($customer_id);
//                                        if(!$has_ip)
//                                        {
//                                                Event::run('Customer.register', $customer);
//                                        }
                        $customer->login_action();
                        //added login cookie 7 days, 添加登陆状态cookie 7天
                        $remember_me = Arr::get($_POST, 'remember_me', '');
                        if($remember_me == 'on')
                        {
                            $this->add_login_cookie($customer_id);
                        }

                        $mail_params['password'] = $data['password'];
                        $mail_params['email'] = $data['email'];
                        $mail_params['firstname'] = $data['firstname'];
                        Mail::SendTemplateMail('NEWREGISTER', $data['email'], $mail_params);

                        $return['success'] = 1;
                    }
                    else
                    {
                        $return['success'] = 0;
                        $return['message'] = __('site_regist_error');
                    }
                }
                else
                {
                    $return['success'] = 0;
                    $return['message'] = __('site_regist_email_used');
                }
            }
        }
        if($return['success']) Customer::logged_in();
        echo json_encode($return);
        exit;
    }

    public function action_logout()
    {
        if (class_exists('facebook') AND Site::instance()->get('fb_login') == 1)
        {
            $facebook = new Facebook();
            if ($facebook->getUser())
            {
                $facebook->clearAllPersistentData();
            }
        }
        Session::instance()->delete('user');
        Session::instance()->delete('celebrity');

        // 清空客户登陆cookie
        Kohana_Cookie::delete('Customer_login_id');

        if (Arr::get($_SERVER, 'HTTPS', 'off') != 'on')
        {
            $domain = URLSTR;
            Request::Instance()->redirect(BASEURL . LANGPATH);
        }
        else
        {
            Request::instance()->redirect(LANGPATH);
        }
    }

    public function action_register()
    {
        if ($_POST)
        {
            $data = array();
            $data['email'] = Arr::get($_POST, 'email', '');
            $data['email'] = Security::xss_clean($data['email']);
            if (!Validate::email($data['email']))
            {
                message::set(__('site_regist_error'), 'error');
            }
            else
            {               
                $data['firstname'] = Arr::get($_POST, 'firstname', '');
                $data['lastname'] = Arr::get($_POST, 'lastname', '');
                $data['password'] = Arr::get($_POST, 'password', '');
                $data['confirm_password'] = Arr::get($_POST, 'confirm_password', '');
                $data['ip'] = ip2long(Request::$client_ip);

                if (!Customer::instance()->is_register($data['email']))
                {
                    // if ($data['ip'] != 0)
                    //     $has_ip = DB::select('id')->from('accounts_customers')->where('ip', '=', $data['ip'])->execute()->get('id');
                    // else
                    //     $has_ip = 0;
                    $data['lang'] = $this->language;

                    $isflag = DB::select('id')->from('accounts_customers')->where('email', '=', $data['email'])->execute()->get('id');
                    if(!empty($isflag))
                    {
                        $data['id'] = $isflag;
                    }
                    else
                    {
                        $data['id'] = NULL;
                    }
                    $data['status'] = isset($data['status']) ? $data['status'] : '1';
                    $data['deleted'] = isset($data['deleted']) ? $data['status'] : '0';
                    $data['give_points'] = isset($data['give_points']) ? $data['status'] : '0';

                    if ($customer_id = Customer::instance()->set($data))
                    {
                        //celebrity add customer_id
                        // $celebrity = DB::select('id', 'customer_id')->from('celebrities_celebrits')->where('email', '=', $data['email'])->execute()->current();
                        // if (!empty($celebrity) AND $celebrity['customer_id'] == 0)
                        // {
                        //     DB::update('celebrities_celebrits')->set(array('customer_id' => $customer_id))->where('id', '=', $celebrity['id'])->execute();
                        // }

                        $coupon_code = 'SIGNUP15OFF' . $customer_id;
                        $coupon = array(
                            // 'site_id' => $this->site_id,
                            'code' => $coupon_code,
                            'value' => 15,
                            'type' => 1,
                            'limit' => 1,
                            'used' => 0,
                            'created' => time(),
                            'expired' => time() + 30 * 86400,
                            'on_show' => 0,
                            'deleted' => 0,
                            'effective_limit' => 0,
                            'usedfor' => 1
                        );
                        $insert = DB::insert('carts_coupons', array_keys($coupon))->values($coupon)->execute();
                        if ($insert)
                        {
                            $c_coupon = array(
                                'customer_id' => $customer_id,
                                'coupon_id' => $insert[0],
                                'deleted' => 0
                                // 'site_id' => $this->site_id
                            );
                            DB::insert('carts_customercoupons', array_keys($c_coupon))->values($c_coupon)->execute();
                            $mail_params['coupon_code'] = $coupon_code;
                            $mail_params['expired'] = date('Y-m-d H:i', $coupon['expired']);
                        }
                        // $customer = Customer::instance($customer_id);
                        // $customer->login_action();
                        //added login cookie 7 days, 添加登陆状态cookie 7天
                        $remember_me = Arr::get($_POST, 'remember_me', '');
                        if($remember_me == 'on')
                        {
                            $this->add_login_cookie($customer_id);
                        }

                        $referer = Arr::get($_POST, 'referer', '');
                        $redirect = Arr::get($_GET, 'redirect', NULL);
                        if ($redirect == 'cart/check_out')
                        {
                            Site::instance()->add_clicks('cart_login');
                        }
                         
                        $do_redirect =URL::base() .'customer/profile';
                        if ($redirect AND toolkit::is_our_url($redirect))
                        {
                            $do_redirect = $redirect;
                        }
                        elseif ($referer AND toolkit::is_our_url($referer))
                        {
                            $do_redirect = $referer;
                        }

                        $mail_params['password'] = $data['password'];
                        $mail_params['email'] = $data['email'];
                        $mail_params['firstname'] = $data['firstname'];
                        Mail::SendTemplateMail('NEWREGISTER', $data['email'], $mail_params);

                        //cartcookie
                        Cookie::set('cookie_id',$customer_id,5184000);//60 days expire
                        $products = Session::instance()->get('cart_products', array());
                        if(is_array($products)&& count($products)>0){
                            foreach ($products as $key => $value) {
                                    //初始化数据
                            $datas = array();
                            $datas['item_id'] = $value['id'];
                            $datas['qty'] = $value['quantity'];
                            $datas['key'] = $value['attributes']['Size'];

                                //     $cookieproducts = DB::select()->from('carts_cartitem')->where('customer_id','=',$customer_id)
                                //         ->and_where('item_id', '=', $value['id'])
                                //         ->and_where('key', '=', $value['attributes']['Size'])
                                //         ->execute()->current();
                                //     if($cookieproducts){
                                // DB::update('carts_cartitem')->set($datas)
                                // ->where('id', '=', $cookieproducts['id'])->execute();
                                //     }else{
                                DB::insert('carts_cartitem', array('customer_id','item_id','qty','key','is_cart','created',))
                                ->values(array('customer_id'=> $customer_id,
                                    'item_id'=>$datas['item_id'],
                                    'qty'=>$value['quantity'],
                                    'key'=>$value['attributes']['Size'],
                                    'is_cart' => 0,
                                    'created'=>time(),))
                                ->execute();

                                    // }


                            }
                        }

                        //用于抽奖记录用户来源
                        $draw = Arr::get($_POST, 'draw_from');
                        $langpath1 = Arr::get($_POST, 'langpath', '');
                        if($draw){
                            if(!empty($langpath1)){
                                $this->request->redirect($langpath1 . '/activity/luck_draw');
                            }else{
                               $this->request->redirect('/activity/luck_draw');
                            }
                        }else{
                            Request::instance()->redirect($do_redirect);
                        }
                    }
                    else
                    {
                        message::set(__('site_regist_error'), 'error');
                    }
                }
                else
                {
                    message::set(__('site_regist_email_used'), 'error');
                }
            }
        }
        $referer = (isset($_SERVER['HTTP_REFERER']) AND toolkit::is_our_url($_SERVER['HTTP_REFERER'])) ?
            $_SERVER['HTTP_REFERER'] : '';
        if ($customer_id = Customer::logged_in())
        {
            if (!$referer || strpos($referer, 'customer/login') || strpos($referer, 'customer/register'))
            {
                //if customer is login, referer is null or referer is login or register, direct to index page.
                Request::instance()->redirect(LANGPATH . URL::base() . 'customer/profile');
            }
            else
            {
                toolkit::is_our_url($referer) ? Request::instance()->redirect(LANGPATH . $referer) : Request::instance()->redirect(LANGPATH . URL::base() . 'customer/profile');
            }
        }
//        if (Arr::get($_SERVER, 'HTTPS', 'off') != 'on')
//        {
//            $redirects = $redirect ? '?redirect=' . $redirect : '';
//            Request::Instance()->redirect(LANGPATH . URL::site(Request::Instance()->uri . $redirects, 'https'));
//        }
        $this->template->content = View::factory('/login')
            ->set('referer', $referer);
    }

    public function action_profile()
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(LANGPATH . '/customer/login?redirect=' . URL::current(TRUE));
        }
        $customer = Customer::instance($customer_id)->get();

        if ($_POST)
        {
            $data = array();
            $data['firstname'] = Arr::get($_POST, 'firstname', '');
            $data['lastname'] = Arr::get($_POST, 'lastname', '');
            $data['country'] = Arr::get($_POST, 'country', '');
            $data['gender'] = Arr::get($_POST, 'gender', '');
            $year = Arr::get($_POST, 'year', '');
            $month = Arr::get($_POST, 'month', '');
            $day = Arr::get($_POST, 'day', '');
            if ($year AND $month AND $day)
            {
                $data['birth'] = $month . '-' . $day;
                $data['birthday'] = strtotime($year . '-' . $month . '-' . $day);
            }
            else
            {
                $data['birthday'] = 0;
            }

            $old = DB::select('firstname', 'lastname', 'country', 'birthday', 'give_points')->from('accounts_customers')->where('id', '=', $customer_id)->execute()->current();
            if (Customer::instance($customer_id)->profile($data))
            {
//                                $ip = ip2long(Request::$client_ip);
//                                if($ip != 0)
//                                        $hasip = DB::select('id')->from('accounts_customers')->where('ip', '=', $ip)->and_where('give_points', '=', 1)->execute()->get('id');
//                                else
//                                        $hasip = 0;
                $points_message = '';
                $hasip = DB::select('give_points')->from('accounts_customers')->where('id', '=', $customer_id)->execute()->get('give_points');
                if (!$hasip)
                {
                    if (!$old['give_points'] AND (!$old['firstname'] OR !$old['lastname'] OR !$old['country'] OR !$old['birthday']))
                    {
                        if ($data['firstname'] != '' AND $data['lastname'] != '' AND $data['country'] != '' AND $data['birthday'] != 0)
                        {
                            // 完善信息送500积分
                            // $result1 = DB::query(Database::UPDATE, 'UPDATE accounts_customers SET points=points+500,give_points=1 WHERE id=' . $customer_id)->execute();
                            // $result2 = Customer::instance($customer_id)->add_point(array('amount' => 500, 'type' => 'complete_profile', 'status' => 'activated'));
/*                            if ($result1 AND $result2)
                            {
                                $points_message = '500 ' . __('point_add_success');
                                $mail_params['email'] = Customer::instance($customer_id)->get('email');
                                $mail_params['firstname'] = Customer::instance($customer_id)->get('firstname');
                                if(!$mail_params['firstname'])
                                    $mail_params['firstname'] = 'customer';
                                Mail::SendTemplateMail('COMPLETE_PROFILE', $mail_params['email'], $mail_params);
                            }*/
                        }
                    }
                }
                message::set(__('update_profile_success') . ',' . $points_message);
                Request::instance()->redirect(LANGPATH . '/customer/profile');
            }
            else
            {
                message::set(__('update_profile_error'), 'error');
            }
        }
        //title
        $lang=LANGUAGE;
        $seoinfo=array(
                "de"=>array("title"=>"Konto Einstellen"),
                "es"=>array("title"=>"Configuración de Cuenta"),
                "fr"=>array("title"=>"Paramtre de Compte"),
                "ru"=>array("title"=>"Настройка Профиля"),
                );
        if($lang!=""){
            $this->template->title = $seoinfo[$lang]['title'];
        }else{
            $this->template->title = "Account Setting";
        }
        $this->template->content = View::factory('/customer/profile')
            ->set('customer', $customer);
    }

    public function action_password()
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(LANGPATH . 'customer/login?redirect=' . URL::current(TRUE));
        }

        $customer = Customer::instance($customer_id)->get();

        if ($_POST)
        {
            $oldpassword = Arr::get($_POST, 'oldpassword', '');
            $password = Arr::get($_POST, 'password', '');

            if (Customer::instance($customer_id)->is_password($oldpassword))
            {
                if (Customer::instance($customer_id)->update_password($password))
                {
                    message::set(__('update_password_success'));
                }
                else
                {
                    message::set(__('update_password_error'), 'error');
                }
            }
            else
            {
                message::set(__('update_password_error'), 'error');
            }
            Request::instance()->redirect(LANGPATH . '/customer/password');
        }
        //title
        $lang=LANGUAGE;
        $seoinfo=array(
                "de"=>array("title"=>"Passwort"),
                "es"=>array("title"=>"Contraseña "),
                "fr"=>array("title"=>"Mot de Passe"),
                "ru"=>array("title"=>"Изменение Пароля"),
                );
        if($lang!=""){
            $this->template->title = $seoinfo[$lang]['title'];
        }else{
            $this->template->title = "Password";
        }
        $this->template->content = View::factory('/customer/password')->set('customer', $customer);
    }

    public function action_orders()
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(LANGPATH . URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }

        $order_by = 'created';
        $queue = 'desc';
        $sort = Arr::get($_GET, 'sort', '');
        if ($sort == 'date1')
        {
            $queue = 'asc';
        }
        elseif ($sort == 'total')
        {
            $order_by = 'amount';
            $queue = 'desc';
        }
        elseif ($sort == 'total1')
        {
            $order_by = 'amount';
            $queue = 'asc';
        }
        $orders = $orders = DB::select()->from('orders_order')
                ->where('customer_id', '=', $customer_id)
                ->and_where('is_active', '=', 1)
                ->order_by($order_by, $queue)
                ->execute()->as_array();

        $pagination = Pagination::factory(array(
                'current_page' => array('source' => 'query_string', 'key' => 'page'),
                'total_items' => count($orders),
                'items_per_page' => 10,
                'view' => '/pagination_r'));
        $orders = $orders ? array_slice($orders, $pagination->offset, $pagination->items_per_page) : array();
        //title
        $lang=LANGUAGE;
        $seoinfo=array(
                "de"=>array("title"=>"Meine Bestellungen"),
                "es"=>array("title"=>"Mis Pedidos"),
                "fr"=>array("title"=>"Mes Commandes"),
                "ru"=>array("title"=>"Мои Заказы"),
                );
        if($lang!=""){
            $this->template->title = $seoinfo[$lang]['title'];
        }else{
            $this->template->title = "My Orders";
        }
        $this->template->content = View::factory('/order/list')
            ->set('orders', $orders)
            ->set('pagination', $pagination->render());
    }
	
    public function action_orders222()
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(LANGPATH . URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }

        $order_by = 'created';
        $queue = 'desc';
        $sort = Arr::get($_GET, 'sort', '');
        if ($sort == 'date1')
        {
            $queue = 'asc';
        }
        elseif ($sort == 'total')
        {
            $order_by = 'amount';
            $queue = 'desc';
        }
        elseif ($sort == 'total1')
        {
            $order_by = 'amount';
            $queue = 'asc';
        }
        $orders = $orders = DB::select()->from('orders_order')
                ->where('customer_id', '=', $customer_id)
                ->and_where('is_active', '=', 1)
                ->order_by($order_by, $queue)
                ->execute()->as_array();
		
        $pagination = Pagination::factory(array(
                'current_page' => array('source' => 'query_string', 'key' => 'page'),
                'total_items' => count($orders),
                'items_per_page' => 10,
                'view' => '/pagination'));
        $orders = $orders ? array_slice($orders, $pagination->offset, $pagination->items_per_page) : array();
		echo '<pre>';
		print_r($orders);
        $this->template->content = View::factory('/order/list11')
            ->set('orders', $orders)
            ->set('pagination', $pagination->render());
    }
	


    public function action_unpaid_orders()
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(LANGPATH . URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }

        $count = DB::select(DB::expr('COUNT(id) AS count'))->from('orders_order')
                // ->where('site_id', '=', $this->site_id)
                ->where('is_active', '=', 1)
                ->where('customer_id', '=', $customer_id)
                ->where('payment_status', '=', 'new')
                ->execute()->get('count');
        $pagination = Pagination::factory(array(
                'current_page' => array('source' => 'query_string', 'key' => 'page'),
                'total_items' => $count,
                'items_per_page' => 10,
                'view' => '/pagination'));

        $order_by = 'created';
        $queue = 'desc';
        $sort = Arr::get($_GET, 'sort', '');
        if ($sort == 'date1')
        {
            $queue = 'asc';
        }
        elseif ($sort == 'total')
        {
            $order_by = 'amount';
            $queue = 'desc';
        }
        elseif ($sort == 'total1')
        {
            $order_by = 'amount';
            $queue = 'asc';
        }
        $orders = DB::select()->from('orders_order')
            // ->where('site_id', '=', $this->site_id)
            ->where('is_active', '=', 1)
            ->where('customer_id', '=', $customer_id)
            ->where('payment_status', '=', 'new')
            ->order_by($order_by, $queue)
            ->limit($pagination->items_per_page)
            ->offset($pagination->offset)
            ->execute()->as_array();
        $lang=LANGUAGE;
        $seoinfo=array(
                "de"=>array("title"=>"Unbezahlte Bestellungen"),
                "es"=>array("title"=>"Pedidos No Pagados"),
                "fr"=>array("title"=>"Commandes Impayées"),
                "ru"=>array("title"=>"Неоплаченные Заказы"),
                );
        if($lang!=""){
            $this->template->title = $seoinfo[$lang]['title'];
        }else{
            $this->template->title = "Unpaid Orders";
        }
        $this->template->content = View::factory('/order/unpaid')
            ->set('orders', $orders)
            ->set('pagination', $pagination->render());
    }

    public function action_wishlist()
    {
        if (!($customer_id = Customer::instance()->logged_in()))
        {
            message::set(__('need_log_in'));
            Request::instance()->redirect(LANGPATH . '/customer/login/?redirect=/customer/wishlist');
        }

        $wishlists = Customer::instance($customer_id)->wishlists();
        $pagination = Pagination::factory(array(
                'current_page' => array('source' => 'query_string', 'key' => 'page'),
                'total_items' => count($wishlists),
                'items_per_page' => 20,
                'view' => '/pagination'));
        $wishlists = $wishlists ? array_slice($wishlists, $pagination->offset, $pagination->items_per_page) : array();
        //title
        $lang=LANGUAGE;
        $seoinfo=array(
                "de"=>array("title"=>"Meine Wunschliste"),
                "es"=>array("title"=>"Mi Lista de Deseos"),
                "fr"=>array("title"=>"Ma liste d'envies"),
                "ru"=>array("title"=>"Избранное"),
                );
        if($lang!=""){
            $this->template->title = $seoinfo[$lang]['title'];
        }else{
            $this->template->title = "My Wishlist";
        }
        $this->template->content = View::factory('/customer/wishlist')
            ->set('pagination', $pagination->render())
            ->set('wishlists', $wishlists);
    }

    public function action_address()
    {
        if (!($customer_id = Customer::instance()->logged_in()))
        {
            Request::instance()->redirect(LANGPATH . 'customer/login?redirect=customer/address');
        }

        $addresses = Customer::instance($customer_id)->addresses();
        //title
        $lang=LANGUAGE;
        $seoinfo=array(
                "de"=>array("title"=>"Adressbuch"),
                "es"=>array("title"=>"Libreta de Direcciónes"),
                "fr"=>array("title"=>"Carnet d'adresse"),
                "ru"=>array("title"=>"Адресная Книга"),
                );
        if($lang!=""){
            $this->template->title = $seoinfo[$lang]['title'];
        }else{
            $this->template->title = "Address Book";
        }
        $this->template->content = View::factory('/address/list')
            ->set('addresses', $addresses);
    }

    public function action_forgot_password()
    {
        $site_id = Site::instance()->get('id');
        if ($_POST)
        {
            $email = Arr::get($_POST, 'email', '');
            if ($customer_id = Customer::instance()->is_register($email))
            {
//                                $customer = Customer::instance($customer_id)->login_action();
                $token = Customer::instance($customer_id)->reset_password_token();
                $string = $token . "-" . $customer_id;

                $mail_params['new_password'] = BASEURL . '/customer/reset_password?token='.$string;
                $mail_params['firstname'] = Customer::instance($customer_id)->get('firstname');
                if(!$mail_params['firstname'])
                    $mail_params['firstname'] = 'customer';
                $mail_params['email'] = Customer::instance($customer_id)->get('email');
                Mail::SendTemplateMail('FOGETPASSWORD', $mail_params['email'], $mail_params);

                message::set(__('site_find_password_check'));
                $this->request->redirect(LANGPATH . '/customer/login');
            }
            else
            {
                message::set(__('site_find_password_no_user'), 'error');
            }
        }
        $this->template->content = View::factory('/customer/forgot_password');
    }

    public function action_contact_us()
    {
        $site_id = Site::instance()->get('id');
        if ($_POST)
        {
            $data = array();
            $data['email'] = Arr::get($_POST, 'email', '');
            $data['name'] = Arr::get($_POST, 'name', '');
            $data['phone'] = Arr::get($_POST, 'phone', '');
            $data['subject'] = Arr::get($_POST, 'subject', '');
            $data['orderno'] = Arr::get($_POST, 'orderno', '');
            $data['message'] = Arr::get($_POST, 'message', '');
            if ($data['email'] != '')
            {
                $mail_params['name'] = $data['name'];
                $mail_params['phone'] = $data['phone'];
                $mail_params['subject'] = $data['subject'];
                $mail_params['orderno'] = $data['orderno'];
                $mail_params['content'] = $data['message'];

                $mail_params['email'] = $site_id = Site::instance()->get('email');
                ;

                Mail::SendTemplateMail('CONTACTUS', $mail_params['email'], $mail_params, $data['email']);

                message::set(__('contact_us_send_success'));
            }
            else
            {
                message::set(__('contact_us_send_error'), 'error');
            }
        }
        $this->request->response = View::factory('/doc_contact-us')
            ->set('title', Site::instance()->get('meta_title'))
            ->set('keywords', Site::instance()->get('meta_keywords'))
            ->set('description', Site::instance()->get('meta_description'))
            ->render();
    }

    public function action_reset_password()
    {
        $string = Arr::get($_GET, 'token', '');
        $array = explode('-', $string);
        $token = $array[0];
        $customer_id = $array[1];
        $return = Customer::instance($customer_id)->check_token($customer_id, $token);

        if ($return)
        {
            if ($_POST)
            {
                $password = Arr::get($_POST, 'password', '');
                if (Customer::instance($customer_id)->update_password($password))
                {
                    Customer::instance($customer_id)->login_action();
                    Customer::instance()->delete_token($customer_id, $token);
                    message::set(__('update_password_success'));
                    $this->request->redirect(LANGPATH . '/customer/orders');
                }
                else
                {
                    message::set(__('update_password_error'), 'error');
                }
            }
            $this->template->content = View::factory('/customer/reset_password')
                ->set('title', Site::instance()->get('meta_title'))
                ->set('keywords', Site::instance()->get('meta_keywords'))
                ->set('description', Site::instance()->get('meta_description'));
        }
        else
        {
            message::set(__('site_find_password_no_user'), 'error');
            $this->request->redirect(LANGPATH . '/customer/forgot_password');
        }
    }

    public function action_product_request()
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(LANGPATH . URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }

        $this->request->response = View::factory('/customer_product_request')
            ->set('title', Site::instance()->get('meta_title'))
            ->set('keywords', Site::instance()->get('meta_keywords'))
            ->set('description', Site::instance()->get('meta_description'))
            ->render();
    }

    public function action_summary()
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(LANGPATH . URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
        if ($_POST)
        {
            $data = array();
            $data['firstname'] = Arr::get($_POST, 'firstname', '');
            $data['lastname'] = Arr::get($_POST, 'lastname', '');
            $data['gender'] = Arr::get($_POST, 'gender', '');
            $data['birthday'] = Arr::get($_POST, 'birthday', '');
            $data['birthday'] = strtotime($data['birthday']);

            if (Customer::instance($customer_id)->profile($data))
            {
                message::set(__('update_profile_success'));
                Request::instance()->redirect(LANGPATH . '/customer/summary');
            }
            else
            {
                message::set(__('update_profile_error'), 'error');
            }
        }
        $lang = Arr::get($_GET, 'lang', '');
        $history = Cookie::get('_vh', '');
        $recently_view=array();
        if ($history)
        {
            $num=1;
            $view_history = explode(',', $history);
            foreach($view_history as $id){
                if($num>21)break;
                $recently_view[]=$id;
            }
        }

         //VIP TYPES 
        $vipconfig = Site::instance()->vipconfig();
        $customer = Customer::instance($customer_id);
        $orders = $customer->orders() ? array_slice($customer->orders(), 0, 5) : array();
        $addresses = $customer->addresses() ? array_slice($customer->addresses(), 0, 5) : array();
		
		//is_vip
		//判断是否是is_vip
		$is_vip="";
		$vip_end="";
		if($customer->get('is_vip')>0){
			if(time()<=$customer->get('vip_end')){
				//is_vip=true;
				$is_vip=1;
				$vip_end=date('Y-m-d',$customer->get('vip_end'));
			}
		}
		
        //title
        $lang=LANGUAGE;
        $seoinfo=array(
                "de"=>array("title"=>"Mein Konto"),
                "es"=>array("title"=>"Mi Cuenta"),
                "fr"=>array("title"=>"Mon compte"),
                "ru"=>array("title"=>"Личный Кабинет"),
                );
        if($lang!=""){
            $this->template->title = $seoinfo[$lang]['title'];
        }else{
            $this->template->title = "My Account";
        }
        $this->template->content = View::factory('/customer/summary')
            ->set('vipconfig',$vipconfig)
            ->set('customer', $customer)
            ->set('orders', $orders)
			->set('is_vip', $is_vip)
            ->set('vip_end', $vip_end)
            ->set('view_history',$recently_view)
            ->set('addresses', $addresses);
    }

    public function action_dropshipping()
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(LANGPATH . URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }

        if ($_POST)
        {
            $data = array();
            $data['companyname'] = $_POST['companyname'];
            $data['weburl'] = $_POST ['weburl'];
            $data['site_id'] = Site::instance()->get('id');
            ;
            $data['created'] = time();
            $data['customer_id'] = $customer_id;

            if (Customer::instance($customer_id)->dropshipping($data))
            {
                message::set(__('update_dropshipping_success'));
                Request::instance()->redirect(LANGPATH . 'customer/dropshipping');
            }
            else
            {
                message::set(__('update_dropshipping_error'), 'error');
            }
        }

        $dropshipping = ORM::factory('dropshipping')->where('customer_id', '=', $customer_id)->find()->as_array();

        $this->request->response = View::factory('/customer_dropshipping')
            ->set('title', Site::instance()->get('meta_title'))
            ->set('data', $dropshipping)
            ->set('keywords', Site::instance()->get('meta_keywords'))
            ->set('description', Site::instance()->get('meta_description'))
            ->render();
    }

    public function action_affiliate_id()
    {
        $this->_perm_check();

        $customer = Customer::instance(Customer::logged_in());
        $this->request->response = View::factory('/customer_affiliate_id')
            ->set('affiliate_id', $customer->get('id'))
            ->set('affiliate_level', $customer->get('affiliate_level'))
            ->set('affiliate_rate', $customer->get('affiliate_rate'))
            ->render();
    }

    public function action_affiliate_paypal()
    {
        $this->_perm_check();
        $customer = Customer::instance(Customer::logged_in());

        if ($_POST)
        {
            $customer->_set(array('affiliate_paypal' => $_POST['af_paypal']));
            $this->request->redirect(LANGPATH . '/customer/affiliate_paypal');
        }

        $this->request->response = View::factory('/customer_affiliate_paypal')
            ->set('affiliate_paypal', $customer->get('affiliate_paypal'))
            ->render();
    }

    public function action_affiliate_commission()
    {
        $this->_perm_check();

        $customer = Customer::instance(Customer::logged_in());
        $this->request->response = View::factory('/customer_affiliate_commission')
            ->set('affiliate_rate', sprintf('%g%%', $customer->get('affiliate_rate') * 100))
            ->set('affiliate_records', $customer->affiliate_records())
            ->set('status', Kohana::config('affiliate.status'))
            ->set('affiliate_payments', $customer->affiliate_payments())
            ->set('affiliate_sum', $customer->commissions())
            ->set('payment_sum', $customer->affiliate_paid_sum())
            ->render();
    }

    public function action_affiliate_exchange()
    {
        $this->_perm_check();

        $customer = Customer::instance(Customer::logged_in());
        $n = (float) $_POST['affiliate'];
        if ($n <= 0 || $n > $customer->commissions())
        {
            die('invalid affiliate count');
        }

        $customer->add_point(array('amount' => $n * 100, 'type' => 'affiliate', 'status' => 'activated'));
        $customer->point_inc($n * 100);
        $customer->commission_dec($n);
        $customer->add_commission_payment(array(
            'commission' => $n,
            'note' => 'point exchange',
        ));

        die('success');
    }

    public function action_points()
    {
        $this->_perm_check();
        $customer = Customer::instance(Customer::logged_in());

        $this->request->response = View::factory('/customer_points')
            ->set('point_records', $customer->point_records())
            ->set('payment_records', $customer->point_payments())
            ->set('point_pending', $customer->points_pending())
            ->set('point_activated', $customer->points_activated())
            ->set('point_total', $customer->points())
            ->render();
    }

    private function _perm_check()
    {
        if (!Customer::logged_in())
        {
            Request::instance()->redirect(LANGPATH . URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
    }

    public function action_points_history()
    {
        $this->_perm_check();
        $customer = Customer::logged_in();
        $sql = '';
        $sort = Arr::get($_GET, 'sort', '');
        if ($sort == 'date')
        {
            $sql = ' ORDER BY created DESC';
        }
        elseif ($sort == 'date1')
        {
            $sql = ' ORDER BY created';
        }
        $records = DB::query(Database::SELECT, 'SELECT amount,status,type,order_id,created FROM `accounts_point_records` WHERE amount > 0 AND customer_id=' . $customer . $sql)->execute()->as_array();
        $payments = DB::query(Database::SELECT, 'SELECT amount,order_num,order_id,created FROM `accounts_point_payments` WHERE customer_id=' . $customer . $sql)->execute()->as_array();
        $count = count($records) + count($payments);
        $pagination = Pagination::factory(array(
                'current_page' => array('source' => 'query_string', 'key' => 'page'),
                'total_items' => $count,
                'items_per_page' => 8,
                'view' => '/pagination'));
        $result = DB::query(Database::SELECT, 'SELECT customer_id,amount,status,type,order_id,created FROM `accounts_point_records` WHERE customer_id=' . $customer . ' AND amount > 0 UNION ALL SELECT customer_id,amount,note,order_num,order_id,created FROM `accounts_point_payments` WHERE customer_id=' . $customer . $sql . ' LIMIT ' . $pagination->items_per_page . ' OFFSET ' . $pagination->offset)->execute()->as_array();
        //title
        $lang=LANGUAGE;
        $seoinfo=array(
                "de"=>array("title"=>"Punkte Historie"),
                "es"=>array("title"=>"Historial de Puntos"),
                "fr"=>array("title"=>"Historique de Points"),
                "ru"=>array("title"=>"История Баллов"),
                );
        if($lang!=""){
            $this->template->title = $seoinfo[$lang]['title'];
        }else{
            $this->template->title = "Points History";
        }
        $pagetype = $this->request->param('id');
        $this->template->content = View::factory('/customer/points_history')
            ->set('pagination', $pagination->render())
            ->set('datas', $result)
            ->set('records', $records)
            ->set('payments', $payments)
            ->set('pagetype', $pagetype)
            ->set('points', Customer::instance($customer)->points());
    }

    public function action_blog_show()
    {
        $this->_perm_check();
        $customer_id = Customer::logged_in();
        $email = Customer::instance($customer_id)->get('email');
        $cele_id = DB::select('id')->from('celebrities_celebrits')->where('email', '=', $email)->execute()->get('id');
        if (!$cele_id)
        {
            $this->request->redirect(LANGPATH . '/customer/summary');
        }
        $limit = 8;

        $count2 = DB::select(DB::expr('COUNT(DISTINCT ordernum,sku) AS count'))->from('celebrities_celebrityorder')->where('celebrity_id', '=', $cele_id)->execute()->get('count');
        $pagination2 = Pagination::factory(array(
                'current_page' => array('source' => 'query_string', 'key' => 'page2'),
                'total_items' => $count2,
                'items_per_page' => $limit,
                'view' => '/pagination'));

        $allshow = DB::query(Database::SELECT, 'SELECT orders_order.ordernum,orders_orderitem.sku FROM orders_orderitem LEFT JOIN orders_order ON  orders_order.id = orders_orderitem.order_id 
                                WHERE orders_order.customer_id = ' . $customer_id . ' AND orders_order.payment_status = "verify_pass" AND orders_orderitem.status <> "cancel"')
                ->execute()->as_array();
        $showeds = DB::select(DB::expr('DISTINCT ordernum,sku'))->from('celebrities_celebrityorder')->where('celebrity_id', '=', $cele_id)->execute()->as_array();
        foreach ($allshow as $key => $val)
        {
            if (in_array($val, $showeds))
                unset($allshow[$key]);
        }
        $pagination1 = Pagination::factory(array(
                'current_page' => array('source' => 'query_string', 'key' => 'page1'),
                'total_items' => count($allshow),
                'items_per_page' => $limit,
                'view' => '/pagination'));
        $toshow = array_slice($allshow, $pagination1->offset, $pagination1->items_per_page);

        $showed = DB::select(DB::expr('DISTINCT ordernum,sku'))->from('celebrities_celebrityorder')->where('celebrity_id', '=', $cele_id)->limit($pagination2->items_per_page)->offset($pagination2->offset)->order_by('id', 'DESC')->execute()->as_array();
        //title
        $lang=LANGUAGE;
        $seoinfo=array(
                "de"=>array("title"=>"Mein Blog Show"),
                "es"=>array("title"=>"Mi show del blog"),
                "fr"=>array("title"=>"Mon Blog Show"),
                "ru"=>array("title"=>"Моё Шоу Блога"),
                );
        if($lang!=""){
            $this->template->title = $seoinfo[$lang]['title'];
        }else{
            $this->template->title = "My Blog Show";
        }

        $this->template->content = View::factory('/customer/blog_show')
            ->set('showed', $showed)
            ->set('toshow', $toshow)
            ->set('cele_id', $cele_id)
            ->set('pagination1', $pagination1->render())
            ->set('pagination2', $pagination2->render());
    }

    public function action_edit_url()
    {
        if ($_POST)
        {
            $ids = Arr::get($_POST, 'id', array());
            $urls = Arr::get($_POST, 'url', array());
            if (empty($ids) OR empty($urls))
            {
                Message::set(__('post_data_error'));
            }
            else
            {
                foreach ($ids as $key => $id)
                {
                    if ($urls[$key])
                        DB::update('celebrities_celebrityorder')->set(array('url' => $urls[$key]))->where('id', '=', $id)->execute();
                    else
                        DB::delete('celebrities_celebrityorder')->where('id', '=', $id)->execute();
                }
                Message::set(__('url_modify_success'));
            }
            $more = Arr::get($_POST, 'more', array());
            if (!empty($more))
            {
                $cele_id = Arr::get($_POST, 'cele_id', 0);
                $sku = Arr::get($_POST, 'sku', '');
                $ordernum = Arr::get($_POST, 'ordernum', '');
                foreach ($more as $url)
                {
                    if ($url)
                    {
                        $data = array(
                            'celebrity_id' => $cele_id,
                            'ordernum' => $ordernum,
                            'sku' => $sku,
                            'url' => $url
                        );
                        DB::insert('celebrity_products', array_keys($data))->values($data)->execute();
                    }
                }
            }
        }
        $get = http_build_query($_GET);
        $this->request->redirect(LANGPATH . '/customer/blog_show?' . $get);
    }

    public function action_add_url()
    {
        if ($_POST)
        {
            $cele_id = Arr::get($_POST, 'cele_id', 0);
            $sku = Arr::get($_POST, 'sku', '');
            $ordernum = Arr::get($_POST, 'ordernum', '');
            $urls = Arr::get($_POST, 'url', array());
            if (!empty($urls) AND $cele_id AND $sku AND $ordernum)
            {
                foreach ($urls as $url)
                {
                    if ($url)
                    {
                        $data = array(
                            'celebrity_id' => $cele_id,
                            'ordernum' => $ordernum,
                            'sku' => $sku,
                            'url' => $url,
                            'show_date' => time()
                        );
                        DB::insert('celebrity_products', array_keys($data))->values($data)->execute();
                    }
                }
            }
        }
        $get = http_build_query($_GET);
        $this->request->redirect(LANGPATH . '/customer/blog_show?' . $get);
    }

    public function action_login_ajax()
    {
        if ($_POST)
        {
            $data = array();
            $data['email'] = Arr::get($_POST, 'email', '');
            $data['password'] = Arr::get($_POST, 'password', '');
            $data['hashed'] = Arr::get($_POST, 'hashed', FALSE);

            if ($customer_id = Customer::instance()->login($data))
            {
                Customer::instance($customer_id)->login_action();
                //added login cookie 7 days, 添加登陆状态cookie 7天
                $remember_me = Arr::get($_POST, 'remember_me', '');
                if($remember_me == 'on')
                {
                    $this->add_login_cookie($customer_id);
                }
                echo json_encode('success');
            }
            else
            {
                echo json_encode(__('site_login_error'));
            }
        }
        exit;
    }

    public function action_register_ajax()
    {
        if ($_POST)
        {
            $data = array();
            $data['email'] = Arr::get($_POST, 'email', '');
            $data['firstname'] = Arr::get($_POST, 'firstname', '');
            $data['lastname'] = Arr::get($_POST, 'lastname', '');
            $data['password'] = Arr::get($_POST, 'password', '');
            $data['confirm_password'] = Arr::get($_POST, 'confirm_password', '');
            $data['ip'] = ip2long(Request::$client_ip);

            if (!Customer::instance()->is_register($data['email']))
            {
                $has_ip = DB::select('id')->from('accounts_customers')->where('ip', '=', $data['ip'])->execute()->get('id');
                if ($customer_id = Customer::instance()->set($data))
                {
                    $customer = Customer::instance($customer_id);
//                                        if(!$has_ip)
//                                        {
//                                                Event::run('Customer.register', $customer);
//                                        }
                    $customer->login_action();
                    //added login cookie 7 days, 添加登陆状态cookie 7天
                    $remember_me = Arr::get($_POST, 'remember_me', '');
                    if($remember_me == 'on')
                    {
                        $this->add_login_cookie($customer_id);
                    }

                    $mail_params['coupon_words'] = '';
                    $mail_params['password'] = $data['password'];
                    $mail_params['email'] = $data['email'];
                    $mail_params['firstname'] = $data['firstname'];
                    Mail::SendTemplateMail('NEWREGISTER', $data['email'], $mail_params);
                    echo json_encode('success');
                }
                else
                {
                    echo json_encode(__('site_regist_error'));
                }
            }
            else
            {
                echo json_encode(__('site_regist_email_used'));
            }
        }
        exit;
    }

    public function action_coupons()
    {
        if (!$customer_id = Customer::logged_in())
        {
            Request::instance()->redirect(LANGPATH . URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
        $count = DB::query(Database::SELECT, 'SELECT COUNT(c.id) AS count FROM carts_customercoupons c LEFT JOIN carts_coupons p ON c.coupon_id=p.id 
            WHERE p.code <> "" AND c.coupon_id=p.id  AND c.customer_id=' . $customer_id)
                ->execute()->get('count');
        $pagination = Pagination::factory(array(
                'current_page' => array('source' => 'query_string', 'key' => 'page'),
                'total_items' => $count,
                'items_per_page' => 5,
                'view' => '/pagination'));
        $sql = '';
        $sort = Arr::get($_GET, 'sort', '');
        if ($sort == 'date')
        {
            $sql = ' ORDER BY p.expired DESC';
        }
        elseif ($sort == 'date1')
        {
            $sql = ' ORDER BY p.expired';
        }else
		{
			$sql = ' ORDER BY p.created DESC';
		}
        $coupons = DB::query(Database::SELECT, 'SELECT p.code,p.value,p.item_sku,p.type,p.target,p.product_limit,p.catalog_limit,p.created,p.expired 
            FROM carts_customercoupons c LEFT JOIN carts_coupons p ON c.coupon_id=p.id 
            WHERE p.code <> "" AND c.customer_id=' . $customer_id . $sql)
            ->execute()->as_array();
		$coupons = $coupons ? array_slice($coupons, $pagination->offset, $pagination->items_per_page) : array();
        $used = DB::select('coupon_code', 'amount_coupon', 'currency', 'ordernum', 'created')
            ->from('orders_order')
            ->where('customer_id', '=', $customer_id)
            ->where('amount_coupon', '>', 0)
            ->where('coupon_code', '<>', '')
            ->order_by('id', 'DESC')
            ->execute();

            $us = array();
        foreach($used as $k1=>$v1){
            array_push($us,$v1['coupon_code']);
        }
        //title
        $lang=LANGUAGE;
        $seoinfo=array(
                "de"=>array("title"=>"Meine Gutscheine"),
                "es"=>array("title"=>"Mis Cupónes"),
                "fr"=>array("title"=>"Mes Coupons"),
                "ru"=>array("title"=>"Мои Купоны"),
                );
        if($lang!=""){
            $this->template->title = $seoinfo[$lang]['title'];
        }else{
            $this->template->title = "My Coupons";
        }
        $this->template->content = View::factory('/customer/coupon')
            ->set('pagination', $pagination->render())
            ->set('coupons', $coupons)
            ->set('used', $used)
            ->set('us', $us);
    }
    
    // check email address is true --- sjm 2015-12-22
    public function action_email_exists()
    {
        if($_POST)
        {
            $email = Arr::get($_POST, 'email', '');
            $check = trim(substr($email, strpos($email, '@') + 1));
            if($check && checkdnsrr($check))
            {
                $result = 1;
            }
            else
            {
                $result = $check;
            }
            $result = 1;
            echo json_encode($result);
            exit;
        }
    }

    function action_cartcookie_mail(){
        $cartcookie = Cartcookie::get_dbcookie();
        if($cartcookie){
            $i = 0;
            foreach ($cartcookie as $key => $value) {
                $mail_params = array();
                //折扣号TODO
                $mail_params['coupons'] = Cartcookie::get_coupon(3);
                //产品列表HTML
                $mail_params['product'] = "";
                foreach ($value['products'] as $p) {
                    $product = Product::instance($p);
                    $product_link = $product->permalink()."?utm_source=web&utm_medium=edm&utm_campaign=0703";
                    $product_img = image::link($product->cover_image(), 1);
                    $product_name = $product->get('name');
                    $product_price = Site::instance()->price($product->price(), 'code_view');
                    $mail_params['product'] .= '
                    <td>
                        <div>
                            <a href="'.$product_link.'" target="_blank">
                                <img src="'.$product_img.'" title="black-oversize-plaid-skater-dress" width="180px" height="240px">
                            </a>
                        </div>
                        <p style=" margin:10px 0; width:180px;height:30px;overflow:hidden;"><a style="color:#666; font-size:12px; text-decoration:none " href="'.$product_link.'" target="_blank" >'.$product_name.'</a></p>
                        <p style=" margin:10px 0;" ><b style="color:#f00">'.$product_price.'</b></p> 
                        <p style=" margin:10px 0;"><a href="'.$product_link.'" target="_blank"><img src="'.BASEURL.'/images/docs/cartcookie/edmwaitlist_03.jpg"></a></p>
                    </td>';
                }
                echo $value['email']."<br>";
                Mail::SendTemplateMail('CARTCOOKIE_NOTICE', $value['email'], $mail_params);
                DB::update('cartcookies')->set(array('mail_date' => time()))->where('customer_id', '=', $key)->execute();
                $i++;
                if($i%50==0){
                    sleep(1);
                }
            }
        }
        exit;
    }

    public function action_me_and_choies()
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(LANGPATH . '/customer/login?redirect=' . URL::current(TRUE));
        }
        $first_order = DB::select(DB::expr('id, created, amount, rate'))
            ->from('orders_order')
            ->where('customer_id', '=', $customer_id)
            ->where('is_active', '=', 1)
            ->where('payment_status', '=', 'verify_pass')
            ->limit(1)->offset(0)
            ->execute()->current();
        if(empty($first_order))
        {
            $this->request->redirect(LANGPATH . '/customer/summary');
        }
        $fisrt_order_items = DB::select(DB::expr('product_id, name, price, attributes'))
            ->from('orders_orderitem')
            ->where('order_id', '=', $first_order['id'])
            ->where('status', '<>', 'cancel')
            ->limit(3)->offset(0)
            ->execute()->as_array();
        $customer = Customer::instance($customer_id);

        //Points history
        $records = DB::query(Database::SELECT, 'SELECT amount,status,type,order_id,created FROM `accounts_point_records` WHERE amount > 0 AND customer_id=' . $customer_id . ' ORDER BY created DESC')->execute()->as_array();
        $payments = DB::query(Database::SELECT, 'SELECT amount,order_num,order_id,created FROM `accounts_point_payments` WHERE customer_id=' . $customer_id . ' ORDER BY created DESC')->execute()->as_array();
        $activated = 0;
        $Rewarded = 0;
        foreach ($records as $p)
        {
            $Rewarded += $p['amount'];
            if ($p['status'] == 'activated')
                $activated += $p['amount'];
        }
        $paymented = 0;
        foreach ($payments as $p)
        {
            $paymented += $p['amount'];
        }
        $points_rewarded = $Rewarded;
        $points_activated = $activated - $paymented;
        $this->template->content = View::factory('/customer/me_and_choies')
            ->set('customer', $customer)
            ->set('first_order', $first_order)
            ->set('fisrt_order_items', $fisrt_order_items)
            ->set('points_rewarded', $points_rewarded)
            ->set('points_activated', $points_activated);
    }

    public function add_login_cookie($customer_id)
    {
        Kohana_Cookie::set('Customer_login_id', $customer_id, 14*24*3600);
    }

}
