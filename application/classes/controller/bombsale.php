<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Bombsale extends Controller_Webpage
{

        public $template = 'layout/template1';
        public $product_sku = 'JNMX0037';
        public $product_id = 2919;
        public $range = 30; //购买数量限制
        public $price = 5.99;
        public $start_date = '2013-08-07';  //活动开始日期
        public $start_time = '19:30:00'; //活动开始时间
        public $continue_date = 1; //连续活动天数
//        public $file_dir = 'F:\wamp\www\ownbrand\clothes\freebie.txt';
        public $file_dir = '/home/data/www/htdocs/clothes/freebie.txt';

        public function action_view()
        {
                date_default_timezone_set('America/Chicago');
                $customer_id = Customer::logged_in();
                $diff = 64800;
                $time_left = strtotime($this->start_date . ' ' . $this->start_time) - time() - $diff;
//                $time_left = strtotime($this->start_date . ' ' . $this->start_time) - time();
                if($_POST)
                {
                        $check_code = Arr::get($_POST, 'check_code', '');
                        $indentifycode = Session::instance()->get('indentifycode');
                        if($check_code == $indentifycode)
                        {
                                $file_handle = fopen($this->file_dir, 'r');
                                $num = fgets($file_handle);
                                fclose($file_handle);
                                $amount = $this->range - $num;
                                if($amount < 0)
                                {
                                        Message::set('Sorry, ' . $this->range . ' items at killer price have been sold out.', 'notice');
                                        $this->request->redirect(LANGPATH . '/bombsale/view');
                                }
                                else
                                {
                                        $ip = ip2long(Request::$client_ip);
                                        $check = DB::select('id')->from('freebies')->where('product_id', '=', $this->product_id)->and_where('ip', '=', $ip)->execute()->get('id');
                                        if(!$check)
                                        {
                                                $post = array(
                                                    'id'    => $this->product_id,
                                                    'items' => array($this->product_id),
                                                    'type'       => 3,
                                                    'attributes' => array('Size'     => 'one size'),
                                                    'quantity' => 1,
                                                    'price'    => $this->price
                                                );
                                                Cart::add2cart($post);
                                                $data = array(
                                                    'sku'        => $this->product_sku,
                                                    'email'      => Customer::instance($customer_id)->get('email'),
                                                    'product_id' => $this->product_id,
                                                    'date_time'  => date('Y-m-d'),
                                                    'ip'         => $ip
                                                );
                                                Freebie::set($data);
                                                $amount = $num + 1;
                                                $file_handle = fopen($this->file_dir, 'w+');
                                                fwrite($file_handle, $amount);
                                                fclose($file_handle);
                                                $this->request->redirect(LANGPATH . '/cart/view');
                                        }
                                        else
                                        {
                                                Message::set(__('ip_limit'), 'notice');
                                                $this->request->redirect(LANGPATH . '/bombsale/view');
                                        }
                                }
                        }
                        else
                        {
                                Message::set(__('verif_code_error'), 'notice');
                                $this->request->redirect(LANGPATH . '/bombsale/view');
                        }
                }
                
                $file_handle = fopen($this->file_dir, 'r');
                $num = fgets($file_handle);
                fclose($file_handle);
                $amount = ceil($this->range - $num);
                if($time_left + $diff <= 0)
                {
                        $left_time = '00:00:00:00';
                }
                elseif($time_left + $diff <=  86400)
                {
                        $left_time = date('00:H:i:s', $time_left);
                }
                else
                {
                        $left_time = date('d:H:i:s', $time_left);
                }
                
                $start_time = $this->start_date;
                $count = DB::query(Database::SELECT, 'SELECT COUNT(freebies.id) AS count FROM orders, freebies 
                                                WHERE orders.id=freebies.order_id AND freebies.order_id <> 0 AND freebies.date_time >= "'.$start_time.'"
                                                AND orders.payment_status IN ("success", "verify_pass")')->execute()->get('count');
                
                $limit = 10;
                $pagination = Pagination::factory(array(
                        'current_page' => array( 'source' => 'query_string', 'key' => 'page' ),
                        'total_items' => $count,
                        'items_per_page' => $limit,
                        'view' => '/pagination' ));
                
                $orders = DB::query(Database::SELECT, 'SELECT orders.shipping_firstname, orders.created, freebies.sku FROM orders, freebies 
                                                WHERE orders.id=freebies.order_id AND freebies.order_id <> 0 AND freebies.date_time >= "'.$start_time.'"
                                                AND orders.payment_status IN ("success", "verify_pass") ORDER BY freebies.id DESC 
                                                LIMIT ' . $pagination->items_per_page . ' OFFSET ' . $pagination->offset)
                                        ->execute()->as_array();
                $this->template->content = View::factory('freebie/view')
                        ->set('sku', $this->sku)
                        ->set('product_id', $this->product_id)
                        ->set('amount', $amount)
                        ->set('time_left', $time_left + $diff < 0 ? 0 : $time_left + $diff)
                        ->set('left_time', $left_time)
                        ->set('customer_id', $customer_id)
                        ->set('start_date', $this->start_date)
                        ->set('start_time', $this->start_time)
                        ->set('orders', $orders)
                        ->set('price', $this->price)
                        ->set('pagination', $pagination->render());
        }

}

?>