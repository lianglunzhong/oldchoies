<?php
defined('SYSPATH') or die('No direct script access.');

class Customer
{

        private static $instances;
        private $data;
        private $site_id;

        public static function & instance($id = 0)
        {
                if( ! isset(self::$instances[$id]))
                {
                        $class = __CLASS__;
                        self::$instances[$id] = new $class($id);
                }
                return self::$instances[$id];
        }

        public function __construct($id)
        {
                $this->site_id = Site::instance()->get('id');
                $this->data = NULL;
                $this->_load($id);
        }

        public function _load($id)
        {
                if( ! $id) return FALSE;
                $result = ORM::factory('customer')
                        ->where('id', '=', $id)
                        ->find()->as_array();

                $this->data = $result ? $result : array( );
        }

        public function get($key = NULL)
        {
                if(empty($key))
                {
                        return $this->data;
                }
                else
                {
                        return isset($this->data[$key]) ? $this->data[$key] : '';
                }
        }

        public function set($data)
        {
                if( ! $data) return FALSE;

                if($this->data['id'])
                {
                        $customer = ORM::factory('customer', $this->data['id']);
                        $customer->values($data);
                        $customer->save();
                        return $customer->id;
                }
                else
                {
                    $dataid = isset($data['id']) ? $data['id'] : '';
                    if($dataid)
                    {
                        $customer = ORM::factory('customer', $data['id']);  
                        $email = $data['email'];
                        $password = $data['password'];
                        $update['password'] = toolkit::hash($password);
                        $update['flag'] = 0;
                        if($customer->flag == 4)
                        {
                            $update['flag'] = 3;
                        }
                        $upcustomer = DB::update('accounts_customers')->set($update)->where('id', '=', $data['id'])->execute();
                        if($upcustomer)
                        {
                            return $data['id'];
                        }
                    }
                    else
                    {
                        
                        $customer = ORM::factory('customer');
                        $data['password'] = toolkit::hash($data['password']);
                        $data['flag'] = 0;
                        $data['created'] = time();
                        $customer->values($data);

                        if($customer->check())
                        {
                            // file_put_contents('D:/lg.log', $customer->save()->last_query());
                            $customer->save();
                            return $customer->id;
                        }                   
                    }

                }
                return FALSE;
        }

        /**
         * customer login
         *
         * @param 	Array $email,$password
         * @return 	Int 	customer id
         */
        public function login($data)
        {
                $email = $data['email'];
                $password = $data['password'];

/*                $customer = ORM::factory('customer')
                    ->where('email', '=', $email)
                    ->where('password', '=', $data['hashed'] ? $password : toolkit::hash($password))
                    ->where('status', '=', 1)
                    ->find();*/

                //hash 
                $data['hashed'] ? $password = $password : $password = toolkit::hash($password);
                $customer = ORM::factory('customer')
                    ->where('email', '=', $email)
                    ->where('status', '=', 1)
                    ->find();

                $result_password = $customer->password;

                if($result_password == $password)
                {
                    $customer_id = $customer->id;
                }           
                else
                {
                    $customer_id = 0;
                }

            //    $customer->loaded() ? $customer_id = $customer->id : $customer_id = 0;
                
                //add last login time, ip
                if($customer_id)
                {
                    $update['last_login_time'] = time();
                    $update['last_login_ip'] = ip2long(Request::$client_ip);
                    DB::update('accounts_customers')->set($update)->where('id', '=', $customer_id)->execute();
                }
                return $customer_id;
        }

        public function login_action()
        {
                $data = array( );
                $data['id'] = $this->get('id');
                $data['email'] = $this->get('email');
                $data['firstname'] = $this->get('firstname');
                $data['lastname'] = $this->get('lastname');
                $data['vip_level'] = $this->get('vip_level');

                $session = Session::instance();
                $session->set('user', $data);
                //set celebrity session
                $celebrity = array( );
                $cid = $this->is_celebrity();
                if($cid)
                {
                    $celebrity['id'] = $cid;
                    $c_admin = DB::select('admin_id')->from('celebrities_celebrits')->where('id', '=', $cid)->execute()->get('admin_id');
                    $admin_email = DB::select('email')->from('auth_user')->where('id', '=', $c_admin)->execute()->get('email');
                    $admin_name = substr($admin_email, 0, strpos($admin_email, '@'));
                    $celebrity['name'] = $admin_name;
                    $session->set('celebrity', $celebrity);
                }
        }

        /**
         * is the customer reigstered?
         *
         * @param 	String 	email
         * @return 	boolean|customer id
         */
        public function is_register($email)
        {
            $customer = ORM::factory('customer')
                ->where('email', '=', $email)
                ->where('flag', 'in', array('0', '3'))
                ->find();

            $customer->loaded() ? $customer_id = $customer->id : $customer_id = 0;
            return $customer_id;
        }

        /**
         * edit customer information
         *
         * @param   Array   $data
         * @return 	Boolean
         */
        public function profile($data)
        {
                $customer_id = $this->data['id'];
                $customer = ORM::factory('customer', $customer_id)->values($data);
                if($customer->loaded())
                {
                        $customer->save();
                        return TRUE;
                }
                else
                {
                        return FALSE;
                }
        }

        /**
         * update customer password
         *
         * @param 	Str 	$password
         * @return 	Int 	customer id | 0
         */
        public function update_password($password)
        {
                $customer = ORM::factory('customer', $this->data['id']);
                if($customer->loaded())
                {
                        $customer->password = toolkit::hash($password);
                        $customer->save();
                        return $customer->id;
                }
                else
                {
                        return 0;
                }
        }

        public function is_password($password)
        {
                $customer = ORM::factory('customer', $this->data['id']);
              $result =  $customer->where('id', '=', $this->data['id'])->find()->as_array();

              //  $customer->where('password', '=', toolkit::hash($password))->where('site_id', '=', $this->site_id)->find();
                    $return = 0;
              if($result['password'] == toolkit::hash($password))
              {
                    $return = 1;
              }
              //  $customer->loaded() ? $return = 1 : $return = 0;
                return $return;
        }

        public function reset_password_token()
        {
                $token = ORM::factory('token')->where('customer_id', '=', $this->data['id'])->find();
                $hash = substr(sha1(uniqid(mt_rand())), 0, -1);
                $token->customer_id = $this->data['id'];
                $token->created = time();
                $token->token = $hash;
                $token->site_id = $this->site_id;
                $token->save();
                return $token->token;
        }

        public function check_token($customer_id, $token)
        {
                $token = ORM::factory('token')->where('customer_id', '=', $customer_id)->where('token', '=', $token)->find();
                $customer = ORM::factory('customer', $customer_id);
                $tokentime = $token->created;
                if($token->loaded() AND $token->customer_id == $customer->id)
                {
                        //time limit
                        if(time() < $tokentime || (time() - $tokentime) >= Kohana::config('password.time'))
                        {
                                return FALSE;
                        }
                        return TRUE;
                }
                return FALSE;
        }

        public function delete_token($customer_id, $token)
        {
                $token = ORM::factory('token')->where('customer_id', '=', $customer_id)->where('token', '=', $token)->find();
                $token->delete();
        }

        public static function logged_in()
        {
                $session = Session::instance();
                $customer = $session->get('user');

                if(isset($customer['id']) AND $customer['id'] != 0)
                {
                        return $customer['id'];
                }

                // If site has facebook login
                if(class_exists('facebook') AND Site::instance()->get('fb_login') == 1)
                {
                        return Customer::instance()->facebook_login();
                }

                return FALSE;
        }

        public function facebook_login()
        {
                $facebook = new Facebook();
                if($facebook->getUser())
                {
                        try
                        {
                                $facebook_user = $facebook->api('/me');

                                // Judge if facebook has registed
                                $fb_email = Arr::get($facebook_user, 'email', '');
                                if(!$fb_email)
                                {
                                    return False;
                                }
                                $customer_id = Customer::instance()->is_register($fb_email);

                                // TODO Judge if email is used as not facebook user
                                if ($customer_id == 0)
                                {
                                        $data = array();
                                        $data['email'] = Arr::get($facebook_user, 'email', '');
                                        $data['firstname'] = Arr::get($facebook_user, 'first_name', '');
                                        $data['lastname'] = Arr::get($facebook_user, 'last_name', '');
                                        $data['password'] = Arr::get($facebook_user, 'id', '');
                                        $data['confirm_password'] = Arr::get($facebook_user, 'id', '');
                                        $data['ip'] = ip2long(Request::$client_ip);
                                        $data['is_facebook'] = 1;
                                        $has_ip = DB::select('id')->from('accounts_customers')->where('ip', '=', $data['ip'])->execute()->get('id');
                                        $customer_id = Customer::instance()->set($data);

                                        if($customer_id)
                                        {
                                            $coupon_code = 'SIGNUP15OFF' . $customer_id;
                                            $coupon = array(
                                                // 'site_id' => 1,
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
                                                    // 'site_id' => 1
                                                );
                                                DB::insert('carts_customercoupons', array_keys($c_coupon))->values($c_coupon)->execute();
                                                $mail_params['coupon_code'] = $coupon_code;
                                                $mail_params['expired'] = date('Y-m-d H:i', $coupon['expired']);
                                            }
                                        }

                                        $mail_params['password'] = $data['password'];
                                        $mail_params['email'] = $data['email'];
                                        $mail_params['firstname'] = $data['firstname'];
                                        Mail::SendTemplateMail('NEWREGISTER', $data['email'], $mail_params);
                                        
                                        Session::instance()->set('user_fb',$customer_id); 
                                }
                                else
                                {
                                        Session::instance()->set('user_fb',1); 
                                        //fb 老用户没有注册有礼 
                                        if (Customer::instance($customer_id)->get('is_facebook') != 1)
                                        {
                                                $data = array();
                                                $data['is_facebook'] = 1;
                                                Customer::instance($customer_id)->set($data);
                                        }
                                }

                                Customer::instance($customer_id)->login_action();

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

                                    $cookieproducts = DB::select()->from('carts_cartitem')->where('customer_id','=',$customer_id)
                                        ->and_where('item_id', '=', $value['id'])
                                        ->and_where('key', '=', $value['attributes']['Size'])
                                        ->execute()->current();
                                    if($cookieproducts){
                                DB::update('carts_cartitem')->set($datas)
                                ->where('id', '=', $cookieproducts['id'])->execute();
                                    }else{
                                DB::insert('carts_cartitem', array('customer_id','item_id','qty','key','is_cart','created',))
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

                                return $customer_id;
                        }
                        catch(FacebookApiException $e)
                        {
                                return FALSE;
                        }
                        
                }

                return FALSE;
        }

        public function is_forum_moderator()
        {
                if($this->data['id'])
                {
                        $moderators = Site::instance()->get('forum_moderators');
                        $moderators = $moderators ? explode(',', $moderators) : array( );
                        if(FALSE !== array_search($this->data['id'], $moderators))
                        {
                                return TRUE;
                        }
                }
                return FALSE;
        }

        // New Customer
        public function orders()
        {
                $orders = DB::select()->from('orders_order')
                        ->where('customer_id', '=', $this->data['id'])
                        ->and_where('is_active', '=', 1)
                        ->order_by('created', 'desc')
                        ->execute()->as_array();

                if(count($orders) > 0)
                {
                        return $orders;
                }
                else
                {
                        return array( );
                }
        }

        public function wishlists()
        {
                $wishlists =  DB::query(Database::SELECT, 'SELECT w.id,w.product_id from accounts_wishlists w left join products_product p on w.product_id = p.id where w.customer_id = '.$this->data['id'] . ' and p.visibility != 0 order by w.id desc ')->execute('slave')->as_array();  

                if(count($wishlists) > 0)
                {
                        return $wishlists;
                }
                else
                {
                        return array( );
                }
        }

        public function addresses()
        {
                $addresses = DB::select()->from('accounts_address')
                        ->where('customer_id', '=', $this->data['id'])
                        ->order_by('id', 'DESC')
                        ->execute()->as_array();

                return count($addresses) > 0 ? $addresses : array( );
        }

        public function get_order($ordernum)
        {
                $result = DB::select('id')->from('orders_order')
                        ->where('ordernum', '=', $ordernum)
                        ->where('customer_id', '=', $this->get('id'))
                        ->execute()->current();
                return Order::instance($result['id']);
        }

        /**
         * edit customer dropshipping
         *
         * @param   Array   $data
         * @return 	Boolean
         */
        public function dropshipping($data)
        {
                $customer_id = $data['customer_id'];
                $dropshipping = ORM::factory('dropshipping')->where('customer_id', '=', $customer_id)->find();
                $dropshipping->companyname = $data['companyname'];
                $dropshipping->weburl = $data['weburl'];
                $dropshipping->site_id = Site::instance()->get('id');
                $dropshipping->customer_id = $customer_id;
                $dropshipping->created = time();
                $dropshipping->save();
                return TRUE;
        }

        public function add_commission($commission)
        {
                if( ! isset($commission['status'])) $commission['status'] = 'pending';
                if( ! isset($commission['created'])) $commission['created'] = time();

                $commission['affiliate_id'] = $this->get('id');

                return DB::insert('affiliate_records', array_keys($commission))
                        ->values(array_values($commission))
                        ->execute();
        }

        public function affiliate_records()
        {
                if( ! $this->get('id'))
                {
                        return array( );
                }

                $records = DB::select()
                    ->from('affiliate_records')
                    ->where('affiliate_id', '=', $this->get('id'))
                    ->order_by('created', 'desc')
                    ->execute()
                    ->as_array();

                // modify record status if neccesary
                $now = time();
                foreach( $records as &$record )
                {
                        if($record['status'] == 'pending' && $now - $record['created'] > Kohana::config('affiliate.pending_duration', 5184000))
                        {
                                $record['status'] = 'ready';
                                $update = DB::update('affiliate_records')
                                    ->set(array( 'status' => 'ready' ))
                                    ->where('id', '=', $record['id'])
                                    ->execute();
                                if($update)
                                {
                                        $commission_usd =
                                            Site::instance()->price($record['commission'], NULL, $record['order_currency'], Site::instance()->currency_get('USD'));
                                        $this->commission_inc($commission_usd);
                                        $this->data = ORM::factory('customer', $this->get('id'))->as_array();
                                }
                        }
                }

                return $records;
        }

        public function affiliate_payments()
        {
                if( ! $this->get('id'))
                {
                        return array( );
                }

                return DB::select()
                        ->from('affiliate_payments')
                        ->where('affiliate_id', '=', $this->get('id'))
                        ->order_by('created', 'desc')
                        ->execute()
                        ->as_array();
        }

        public function point_records()
        {
                if( ! $this->get('id'))
                {
                        return array( );
                }

                $records = DB::select()
                    ->from('accounts_point_records')
                    ->where('customer_id', '=', $this->get('id'))
                    ->order_by('created', 'desc')
                    ->execute()
                    ->as_array();

                $now = time();
                foreach( $records as &$record )
                {
                        if($record['status'] == 'pending' && $now - $record['created'] > Kohana::config('points.pending_duration', 5184000))
                        {
                                $record['status'] = 'activated';
                                $update = DB::update('accounts_point_records')
                                    ->set(array( 'status' => 'activated' ))
                                    ->where('id', '=', $record['id'])
                                    ->execute();
                                if($update)
                                {
                                        $this->point_inc($record['amount']);
                                        $this->data = ORM::factory('customer', $this->get('id'))->as_array();
                                }
                        }
                }

                return $records;
        }

        public function point_payments()
        {
                if( ! $this->get('id'))
                {
                        return array( );
                }

                return DB::select()
                        ->from('accounts_point_payments')
                        ->where('customer_id', '=', $this->get('id'))
                        ->order_by('created', 'desc')
                        ->execute()
                        ->as_array();
        }

        public function points()
        {
                $this->point_records();
                return $this->get('points');
        }

        public function points_pending()
        {
                return $this->_points_status('pending');
        }

        public function points_activated()
        {
                return $this->_points_status('activated');
        }

        protected function _points_status($status)
        {
                if( ! $this->get('id'))
                {
                        return 0;
                }

                return DB::select(array( DB::expr('IFNULL(SUM(amount), 0)'), 'sum' ))
                        ->from('accounts_point_records')
                        ->where('customer_id', '=', $this->get('id'))
                        ->where('status', '=', $status)
                        ->order_by('created', 'desc')
                        ->execute()
                        ->get('sum');
        }

        public function commissions()
        {
                $this->affiliate_records();
                return $this->get('commissions');
        }

        public function commissions_pending()
        {
                $pending_records = $this->_commissions_status('pending');
                if( ! $pending_records) return 0;

                $sum = 0;
                foreach( $pending_records as $record )
                {
                        $sum += Site::instance()->price($record['commission'], NULL, $record['order_currency'], Site::instance()->currency_get('USD'));
                }

                return $sum;
        }

        protected function _commissions_status($status)
        {
                if( ! $this->get('id'))
                {
                        return 0;
                }

                return DB::select()
                        ->from('affiliate_records')
                        ->where('affiliate_id', '=', $this->get('id'))
                        ->where('status', '=', $status)
                        ->execute();
        }

        public function add_commission_payment($payment)
        {
                $payment['affiliate_id'] = $this->get('id');
                $payment['created'] = time();

                return DB::insert('affiliate_payments', array_keys($payment))
                        ->values(array_values($payment))
                        ->execute();
        }

        public function add_point_payment($payment)
        {
                $payment['customer_id'] = $this->get('id');
                $payment['created'] = time();

                return DB::insert('accounts_point_payments', array_keys($payment))
                        ->values(array_values($payment))
                        ->execute();
        }

        public function affiliate_paid_sum()
        {
                $sum = 0.0;
                foreach( $this->affiliate_payments() as $record )
                {
                        $sum += $record['commission'];
                }

                return $sum;
        }

        public function add_point($point)
        {
                if(isset($point['order']))
                {
                        $promotion = Promotion::instance(27);
                        $double_products = $promotion->products();
                        $from = $promotion->get('from_date');
                        $to = $promotion->get('to_date');
                        $time = time();

                        if($time <= $to && $time >= $from)
                        {
                                /* 通过订单计算双倍积分 */
                                $products = unserialize($point['order']['products']);

                                $is_multi = false;
                                if(!empty($products))
                                {
                                        foreach( $products as $key => $product )
                                        {
                                                if(in_array($product['id'], $double_products))
                                                {
                                                        $is_multi = true;

                                                        $point['amount'] += $product['price'] * $product['quantity'];
                                                }
                                        }
                                }
                        }
                        unset($point['order']);
                }

                if( ! isset($point['created'])) $point['created'] = time();

                $point['customer_id'] = $this->get('id');

                return DB::insert('accounts_point_records', array_keys($point))
                        ->values(array_values($point))
                        ->execute();
        }

        public function commission_inc($amount)
        {
                return DB::query(Database::UPDATE, "UPDATE accounts_customers SET commissions=commissions+$amount WHERE id=".$this->get('id'))
                        ->execute();
        }

        public function commission_dec($amount)
        {
                return DB::query(Database::UPDATE, "UPDATE accounts_customers SET commissions=commissions-$amount WHERE id=".$this->get('id'))
                        ->execute();
        }

        public function point_inc($amount)
        {
                return DB::query(Database::UPDATE, "UPDATE accounts_customers SET points=points+$amount WHERE id=".$this->get('id'))
                        ->execute();
        }

        public function point_dec($amount)
        {
                return DB::query(Database::UPDATE, "UPDATE accounts_customers SET points=points-$amount WHERE id=".$this->get('id'))
                        ->execute();
        }

        public function _set($data)
        {
                $customer = ORM::factory('customer', $this->get('id'));
                if( ! $customer->loaded())
                {
                        return FALSE;
                }

                $customer->values($data);
                if( ! $customer->check())
                {
                        return FALSE;
                }

                return $customer->save();
        }

        public function order_total_inc($amount=1)
        {
                return DB::update('accounts_customers')
                        ->set(array( 'order_total' => DB::expr("order_total + $amount") ))
                        ->where('id', '=', $this->get('id'))
                        ->execute();
        }

        public function order_total_dec($amount=1)
        {
                return DB::update('accounts_customers')
                        ->set(array( 'order_total' => DB::expr("order_total - $amount") ))
                        ->where('id', '=', $this->get('id'))
                        ->execute();
        }

        public function is_celebrity()
        {
            $cache = Cache::instance('memcache');
            $cache_key = 'customer_is_celebrity_' . $this->get('id');
            if( ! $is_celebrity = $cache->get($cache_key))
            {
                $is_celebrity = DB::select('id')
                    ->from('celebrities_celebrits')
                    ->where('customer_id', '=', $this->get('id'))
                    ->and_where('is_able', '=', 1)
                    ->execute('slave')
                    ->get('id');
                $cache->set($cache_key, $is_celebrity, 5 * 86400);
            }
            return $is_celebrity;
        }

}
