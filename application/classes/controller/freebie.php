<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Freebie extends Controller_Webpage
{

        public $product_sku = 'JRMX0008';
        public $product_id = 4213;
        public $range = 500; //购买数量限制
        public $start_date = '2012-09-11';  //活动开始日期
        public $start_time = '19:30:00'; //活动开始时间
//        public $start_date = '2012-09-11';
//        public $start_time = '1:17:00';
        public $continue_date = 3; //连续活动天数
        public $relate_product = 'CCZR0003,CTLS1399,CVLS0966,ASMX0763,CTZR0148,ASMX1035';
//        public $file_dir = 'F:\wamp\www\ownbrand\clothes\freebie.txt';
        public $file_dir = '/home/data/www/htdocs/clothes/freebie.txt';

        public function action_view()
        {
                /* freebie页面SEO */
                date_default_timezone_set('America/Chicago');
//                $meta_title = '';
//                $meta_keywords = '';
//                $meta_description = '';
//
//                $this->template->title = $meta_title;
//                $this->template->keywords = $meta_keywords;
//                $this->template->description = $meta_description;
                $file_handle = fopen($this->file_dir, 'r');
                $num = fgets($file_handle);
                fclose($file_handle);
//                $num = array(
//                    @Freebie::get_amont_bysku($this->product_sku),
//                );

                $num = $num + floor($num / 5);
                $amount = array(
                    $this->range - $num,
                );

//                echo date('Y-m-d H:i:s');exit;
//                $amount = 0;
                /* 时间开关 */
                $free_rst = array();
                $free_rst[$this->start_date] = strtotime($this->start_date . ' ' . $this->start_time);
                $timestr = strtotime('2012-09-01 ' . $this->start_time) - strtotime('2012-09-01 00:00:00');
                for ($i = 1; $i < $this->continue_date; $i++)
                {
                        $free_rst[date('Y-m-d', strtotime("$this->start_date + $i day"))] = strtotime("$this->start_date + $i day") + $timestr;
                }

                $now_flag = isset($free_rst[date('Y-m-d')]) ? $free_rst[date('Y-m-d')] - time() : 99999;
                $zero = 0;
                if ($now_flag > 86400)
                {
                        $zero = 1;
                }
//                $now_flag = 1;
                $products = array(
                    Product::instance($this->product_id),
                );
                /* 1天 为 1次周期 */
                if (($amount[0] > 0) && ($now_flag <= 86400))
                {
                        $view = 'freebie/now_august'; //在活动期内，有数量
                }
//                else if (($amount[0] <= 0) && time() > $free_rst[count($free_rst) - 1])
//                {
//                        $view = 'freebie/over_august'; //连续几天的活动结束
//                }
                else
                {
                        $view = 'freebie/coming_august'; //在活动期外
                }
                //echo 123;die;
                $start = 0;
                if ($now_flag < 0)
                        $start = 1;
//                $start = 1;

                $relate_products = explode(",", $this->relate_product);

                $this->template->content = View::factory($view)
                        ->set('amount', $amount)
                        ->set('freeday', $free_rst[date('Y-m-d')])
                        ->set('products', $products)
                        ->set('relate_products', $relate_products)
                        ->set('zero', $zero)
                        ->set('start', $start);
        }

        public function action_start()
        {
                date_default_timezone_set('America/Chicago');

                $file_handle = fopen($this->file_dir, 'r');
                $num = fgets($file_handle);
                fclose($file_handle);
//                $num = array(
//                    @Freebie::get_amont_bysku($this->product_sku),
//                );

                $num = $num + floor($num / 5);
                $amount = array(
                    $this->range - $num,
                );

//                $amount = 0;
                /* 时间开关 */
                $free_rst = array();
                $free_rst[$this->start_date] = strtotime($this->start_date . ' ' . $this->start_time);
                $timestr = strtotime('2012-09-01 ' . $this->start_time) - strtotime('2012-09-01 00:00:00');
                for ($i = 1; $i < $this->continue_date; $i++)
                {
                        $free_rst[date('Y-m-d', strtotime("$this->start_date + $i day"))] = strtotime("$this->start_date + $i day") + $timestr;
                }

                $now_flag = isset($free_rst[date('Y-m-d')]) ? $free_rst[date('Y-m-d')] - time() : 99999;
                $zero = 0;
                if ($now_flag > 86400)
                {
                        $zero = 1;
                }
                $products = array(
                    Product::instance($this->product_id),
                );
                $day = $this->continue_date - 1;
                /* 1天 为 1次周期 */
                //var_dump($product);die;
                if (($amount[0] > 0) && ($now_flag <= 86400))
                {
                        $view = 'freebie/now'; //在活动期内，有数量
                }
                else if (($amount[0] <= 0) && date('Y-m-d') == date('Y-m-d', strtotime("$this->start_date + $day day")))
                {
                        $view = 'freebie/over_august'; //连续几天的活动结束
                }
                else if (($amount[0] <= 0) && ($now_flag <= 86400))
                {
                        if ($products[0]->get('price') == 0)
                        {
                                DB::query(Database::UPDATE, 'UPDATE products SET price=2.99 WHERE sku="' . $this->product_sku . '"')->execute();
                        }
                        $view = 'freebie/over'; //在活动期内，没数量
                }
                else
                {
                        $view = 'freebie/coming'; //在活动期外
                }
                //echo 123;die;
                $relate_products = explode(",", $this->relate_product);

                $this->template->content = View::factory($view)
                        ->set('amount', $amount)
                        ->set('products', $products)
                        ->set('relate_products', $relate_products);
        }

        public function action_gettime()
        {
                date_default_timezone_set('America/Chicago');
//                if(!Customer::logged_in())
//                {
//                        $this->request->redirect(LANGPATH . '/customer/login?redirect='.URL::current(TRUE));
//                }
                $product_id = $this->request->param('id');
                $sku = Product::instance($product_id)->get('sku');
                /* 时间开关 */
                $free_rst = array();
                $free_rst[$this->start_date] = strtotime($this->start_date . ' ' . $this->start_time);
                $timestr = strtotime('2012-09-01 ' . $this->start_time) - strtotime('2012-09-01 00:00:00');
                for ($i = 1; $i < $this->continue_date; $i++)
                {
                        $free_rst[date('Y-m-d', strtotime("$this->start_date + $i day"))] = strtotime("$this->start_date + $i day") + $timestr;
                }

                $time_con = isset($free_rst[date('Y-m-d')]) ? $free_rst[date('Y-m-d')] - time() : 99999;
//                $time_con = -1;
//                echo $time_con;exit;
                $re = array();
                if ($time_con < 0 && $time_con >= -86400)
                {
//                        $email = Customer::instance(Customer::logged_in())->get('email');
//                        $tag = Freebie::check_email($email, $sku, $this->range, array_keys($free_rst));
//                        if ($tag)
//                        {
//                                $data = array(
//                                    'sku'         => $sku,
//                                    'email'       => $email,
//                                    'product_id'  => $product_id,
//                                    'date_time'   => date('Y-m-d')
//                                );
//                                
//                                $id = Freebie::set($data);
//                                if($id)
//                                {
//                                        $re['amount'] = $id;
//                                        $file_handle = fopen($this->file_dir, 'r');
//                                        $amount = fgets($file_handle);
//                                        fclose($file_handle);
//                                        $amount = $amount + 1;
//                                        $file_handle = fopen($this->file_dir, 'w+');
//                                        fwrite($file_handle, $amount);
//                                        fclose($file_handle);
//                                        
//                                        if ($amount < $this->range)
//                                        {
//                                                $re['state'] = 'ok';
//                                        }
//                                        else
//                                        {
//                                                $re['state'] = 'faild';
//                                        }
//                                }
//                                else
//                                {
//                                        $re['state'] = 'Limit one freebie per ID within 3 days.Please come to win next week.';
//                                }
//                        }
//                        else
//                        {
//                                //echo $tag;
//                                $re['state'] = 'Limit one freebie per ID within 3 days.Please come to win next week!';
//                        }

                        $re['amount'] = $id;
                        $file_handle = fopen($this->file_dir, 'r');
                        $amount = fgets($file_handle);
                        fclose($file_handle);
                        $amount = $amount + 1;

                        if ($amount < $this->range)
                        {
                                $re['state'] = 'ok';
                        }
                        else
                        {
                                $re['state'] = 'faild';
                        }
                }
                else if ($time_con > 0)
                {
                        $re['state'] = 'The promotion starts on 8:30 PM EST.';
                }
                else
                {
                        $re['state'] = 'The promotion is now over.';
                }
                $re['product_id'] = $product_id;

                echo json_encode($re);
                exit;
        }

        public function action_addfreebie()
        {
                $post['id'] = Arr::get($_POST, 'id', 0);
                $post['quantity'] = Arr::get($_POST, 'quantity', 1);
                $post['type'] = Arr::get($_POST, 'type', 0);
                $post['amount'] = Arr::get($_POST, 'amount', 0);
                $post['sku'] = Arr::get($_POST, 'sku', 0);
                $post['items'] = Arr::get($_POST, 'items', array());
                $post['shipping_price'] = 0;
                
                if ($post['id'] == 0)
                {
                        $this->request->redirect(LANGPATH . '/404');
                }

                $customer_id = Customer::logged_in();
                $addresses = Customer::instance($customer_id)->addresses();
                if (count($addresses) > 0)
                {
                        $data = array(
                            'sku'        => $this->product_sku,
                            'email'      => Customer::instance($customer_id)->get('email'),
                            'product_id' => $this->product_id,
                            'date_time'  => date('Y-m-d')
                        );
                        $set = Freebie::set($data);
                        if (!$set)
                        {
                                Message::set(__('freebie_limit'), 'notice');
                                $this->request->redirect(LANGPATH . '/freebie/view');
                        }
                        $site_id = Site::instance()->get('id');
                        $order = ORM::factory('order');
                        $order->site_id = $site_id;
                        $order->created = time();
                        // initial payment information
                        $order->amount_payment = 0;
                        $order->payment_status = 'new';
                        $order->transaction_id = 0;
                        // set shipping information
                        $order->shipping_status = 'new_s';
                        $order->save();
                        $order->ordernum = (string) ($order->id + 1000000) . Site::instance()->get('cc_payment_id');
                        $order->is_active = 1;
                        $order->save();

                        $email = Customer::instance(Customer::logged_in())->get('email');
                        $data['customer_id'] = $customer_id;
                        $data['email'] = $email;
                        $data['ip'] = sprintf('%u', ip2long(Request::$client_ip));
                        $data['shipping_firstname'] = $addresses[0]['firstname'];
                        $data['shipping_lastname'] = $addresses[0]['firstname'];
                        $data['shipping_address'] = $addresses[0]['address'];
                        $data['shipping_city'] = $addresses[0]['city'];
                        $data['shipping_state'] = $addresses[0]['state'];
                        $data['shipping_country'] = $addresses[0]['country'];
                        $data['shipping_zip'] = $addresses[0]['zip'];
                        $data['shipping_phone'] = $addresses[0]['phone'];
                        $data['payment_method'] = 'PP';

                        $currency = Site::instance()->currency();
                        $data['currency'] = $currency['name'];
                        $data['rate'] = $currency['rate'];
                        $data['shipping_method'] = 'HKPF';
                        $data['amount_products'] = $post['amount'] * $data['rate'];
                        $data['amount_shipping'] = 0;
                        $data['amount_coupon'] = 0;
                        $data['amount_order'] = $data['amount_products'];
                        $data['amount'] = $data['amount_order'];
                        $data['points'] = $cart['points'];

                        $key = "${freebie_products['id']}_${freebie_products['type']}_" . md5(serialize($post['items'])) . (isset($post['attributes']) ? '_' . md5(serialize($post['attributes'])) : '');
                        $products[$key] = array(
                            'id'              => $post['id'],
                            'items'           => $post['items'],
                            'quantity'        => $post['quantity'],
                            'type'            => $post['type'],
                            'configs'         => '',
                            'attributes'      => '',
                            'price'           => $data['amount_products'],
                        );
                        $data['products'] = serialize($products);

                        $order->values($data);

                        $ret = $order->save();

                        if ($ret)
                        {
                                $item = array();
                                $product = Product::instance($post['id']);
                                $item = array(
                                    'site_id'        => $site_id,
                                    'order_id'       => $order->id,
                                    'key'            => $key,
                                    'product_id'     => $post['id'],
                                    'item_id'        => $post['id'],
                                    'price'          => $post['amount'],
                                    'quantity'       => $post['quantity'],
                                    'customize'      => '',
                                    'customize_type' => '',
                                    'attributes'     => '',
                                    'name'           => $product->get('name'),
                                    'sku'            => $product->get('sku'),
                                    'link'           => $product->permalink(),
                                    'price'          => $data['amount_products'],
                                    'cost'           => $product->get('cost'),
                                    'weight'         => $product->get('weight'),
                                    'created'        => time(),
                                    'customize'      => NULL,
                                    'status'         => 'new',
                                );

                                $ret1 = DB::insert('order_items', array_keys($item))
                                        ->values($item)
                                        ->execute();

                                if ($ret1)
                                {
                                        $file_handle = fopen($this->file_dir, 'r');
                                        $amount = fgets($file_handle);
                                        fclose($file_handle);
                                        $amount = $amount + 1;
                                        $file_handle = fopen($this->file_dir, 'w+');
                                        fwrite($file_handle, $amount);
                                        fclose($file_handle);

                                        Message::set(__('freebie_success'), 'success');
                                        $this->request->redirect(LANGPATH . '/freebie/view');
                                }
                                else
                                {
                                        $this->request->redirect(LANGPATH . '/freebie/view');
                                }
                        }
                        else
                        {
                                Message::set(__('order_create_failed'), 'error');
                                $this->request->redirect(LANGPATH . '/cart/view');
                        }
                }
                //echo"<pre>";print_r($post);exit;
//                $amount = Freebie::get_amont_bysku($post['sku'], $post['amount']);
//                if ($amount > 10)
//                {
//                        Message::set("Today's promotions is over, another 250 freebies will be given at 8:30 pm EST tomorrow.", 'error');
//                        $this->request->redirect(LANGPATH . '/freebie/view');
//                }

                Session::instance()->set('freebie_products', $post);
//                Cart::add2cart($post);
                $this->template->content = View::factory('/freebie/shipping_billing');
        }

        public function action_shipping()
        {
                if (!($customer_id = Customer::logged_in()))
                {
                        Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
                }
                if ($_POST)
                {
                        $email = Customer::instance(Customer::logged_in())->get('email');
                        $data = array(
                            'sku'        => $this->product_sku,
                            'email'      => $email,
                            'product_id' => $this->product_id,
                            'date_time'  => date('Y-m-d')
                        );
                        $set = Freebie::set($data);
                        if (!$set)
                        {
                                Message::set(__('freebie_limit'), 'notice');
                                $this->request->redirect(LANGPATH . '/freebie/view');
                        }
                        $site_id = Site::instance()->get('id');
                        $order = ORM::factory('order');
                        $order->site_id = $site_id;
                        $order->created = time();
                        // initial payment information
                        $order->amount_payment = 0;
                        $order->payment_status = 'new';
                        $order->transaction_id = 0;
                        // set shipping information
                        $order->shipping_status = 'new_s';
                        $order->save();
                        $order->ordernum = (string) ($order->id + 1000000) . Site::instance()->get('cc_payment_id');
                        $order->is_active = 1;
                        $order->save();

                        $freebie_products = Session::instance()->get('freebie_products');
                        $data['customer_id'] = $customer_id;
                        $data['email'] = $email;
                        $data['ip'] = sprintf('%u', ip2long(Request::$client_ip));
                        $data['shipping_firstname'] = $_POST['shipping_firstname'];
                        $data['shipping_lastname'] = $_POST['shipping_lastname'];
                        $data['shipping_address'] = $_POST['shipping_address'];
                        $data['shipping_city'] = $_POST['shipping_city'];
                        $data['shipping_state'] = $_POST['shipping_state'];
                        $data['shipping_country'] = $_POST['shipping_country'];
                        $data['shipping_zip'] = $_POST['shipping_zip'];
                        $data['shipping_phone'] = $_POST['shipping_phone'];
                        $data['payment_method'] = 'PP';

                        $currency = Site::instance()->currency();
                        $data['currency'] = $currency['name'];
                        $data['rate'] = $currency['rate'];
                        $data['shipping_method'] = 'HKPF';
                        $data['amount_products'] = $freebie_products['amount'] * $data['rate'];
                        $data['amount_shipping'] = 0;
                        $data['amount_coupon'] = 0;
                        $data['amount_order'] = $data['amount_products'];
                        $data['amount'] = $data['amount_order'];
                        $data['points'] = $cart['points'];

                        $key = "${freebie_products['id']}_${freebie_products['type']}_" . md5(serialize($freebie_products['items'])) . (isset($freebie_products['attributes']) ? '_' . md5(serialize($freebie_products['attributes'])) : '');
                        $products[$key] = array(
                            'id'              => $freebie_products['id'],
                            'items'           => $freebie_products['items'],
                            'quantity'        => $freebie_products['quantity'],
                            'type'            => $freebie_products['type'],
                            'configs'         => '',
                            'attributes'      => '',
                            'price'           => $data['amount_products'],
                        );
                        $data['products'] = serialize($products);

                        $order->values($data);

                        $ret = $order->save();

                        if ($ret)
                        {
                                $item = array();
                                $product = Product::instance($freebie_products['id']);
                                $item = array(
                                    'site_id'        => $site_id,
                                    'order_id'       => $order->id,
                                    'key'            => $key,
                                    'product_id'     => $freebie_products['id'],
                                    'item_id'        => $freebie_products['id'],
                                    'price'          => $freebie_products['amount'],
                                    'quantity'       => $freebie_products['quantity'],
                                    'customize'      => '',
                                    'customize_type' => '',
                                    'attributes'     => '',
                                    'name'           => $product->get('name'),
                                    'sku'            => $product->get('sku'),
                                    'link'           => $product->permalink(),
                                    'price'          => $data['amount_products'],
                                    'cost'           => $product->get('cost'),
                                    'weight'         => $product->get('weight'),
                                    'created'        => time(),
                                    'customize'      => NULL,
                                    'status'         => 'new',
                                );

                                $ret1 = DB::insert('order_items', array_keys($item))
                                        ->values($item)
                                        ->execute();

                                if ($ret1)
                                {
                                        $file_handle = fopen($this->file_dir, 'r');
                                        $amount = fgets($file_handle);
                                        fclose($file_handle);
                                        $amount = $amount + 1;
                                        $file_handle = fopen($this->file_dir, 'w+');
                                        fwrite($file_handle, $amount);
                                        fclose($file_handle);

                                        Message::set(__('freebie_success'), 'success');
                                        $this->request->redirect(LANGPATH . '/freebie/view');
                                }
                                else
                                {
                                        $this->request->redirect(LANGPATH . '/freebie/view');
                                }
                        }
                        else
                        {
                                Message::set(__('order_create_failed'), 'error');
                                $this->request->redirect(LANGPATH . '/cart/view');
                        }
                }
        }

}

?>