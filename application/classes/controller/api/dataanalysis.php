<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Api_dataanalysis extends Controller
{

        public function before()
        {
                $ip = '216.24.198.11';
                if(Request::$client_ip != $ip)
                {
                       exit('Stop!');
                }
        }

        public function action_orders()
        {
                // Input
                $_POST = array(
                        'domain' => $_POST['domain'],
                        'begin' => $_POST['begin'],
                        'end' => $_POST['end'],
                );
                $sitesql="select * from sites where domain='".mysql_escape_string($_POST['domain'])."'";
                $sitearr=DB::query(Database::SELECT, $sitesql)->execute()->current();
                // Process
                $sql = 'SELECT * FROM orders 
                      WHERE `payment_status` IN ("success", "verify_pass")
                      AND site_id   = '.$sitearr['id'].'
                      and payment_date>='.$_POST['begin'].'
                            AND payment_date<'.$_POST['end'].'
                                  and is_active=1 and refund_status=\'\'';
                $orderData = DB::query(Database::SELECT, $sql)->execute();
                
                // Output
                foreach ($orderData as $order) {
                      $product=unserialize($order['products']);
                      $return[$order['ordernum']]['ordernum']=$order['ordernum'];
                      $return[$order['ordernum']]['ip']=long2ip($order['ip']);
                      $return[$order['ordernum']]['date']=date("Y-m-d H:i:s",$order['payment_date']);
                      $return[$order['ordernum']]['country']=$order['shipping_country'];
                      $return[$order['ordernum']]['amount']=$order['amount'];
                      $return[$order['ordernum']]['shipping']=$order['amount_shipping'];
                      foreach($product as $pro){
                            $psql='select sku from products where id='.$pro['id'];
                            $proarr = DB::query(Database::SELECT, $psql)->execute()->current();
                            $detail['sku']=$proarr['sku'];
                            $detail['price']=$pro['price'];
                            $detail['quantity']=$pro['quantity'];
                           
                            $return[$order['ordernum']]['detail'][$pro['id']]=$detail;
                      }
                      
                      
                }
                echo serialize($return);
        }

}