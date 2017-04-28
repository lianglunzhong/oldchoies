<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Cityads extends Controller
{

    public function action_orders(){
        //$click_id = Arr::get($_REQUEST, 'click_id', '');
        $status = Arr::get($_REQUEST, 'status', '');
        $token = Arr::get($_REQUEST, 'pkey', '');
        if($token!="m4eK5gu9TLUZOS3sGi75"){
            exit;
        }
        switch ($status)
        {
        case "new":
          $payment_status="'new'";
          $refund_status="";
          $status="new";
          break;
        case "done":
          $payment_status="'verify_pass','success'";
          $refund_status="";
          $status="done";
          break;
        case "cancel":
          $payment_status="'cancel'";
          $refund_status="'refund'";
          $status="cancel";
          break;
        default:
          $payment_status="'new','verify_pass','success','cancel'";
          $refund_status="'refund','partial_refund'";
          $status="all";
        }
        if($payment_status){
            $xml_date='<items>';
            if($refund_status){
                $refund=" OR O.`refund_status` in (".$refund_status.")";
            }else{
                $refund="";
            }
            $orders = DB::query(DATABASE::SELECT, "select O.*,C.`click_id` FROM cityads C left join `orders` O on C.`order_id`=O.`id` WHERE O.`payment_status` in (".$payment_status.")".$refund)->execute();
            if($orders->count()>0){
                foreach ($orders as $order) {
                    if($order['refund_status']){
                        $order_statu="cancel";
                    }elseif($order['payment_status']=="new"){
                        $order_statu="new";
                    }elseif(in_array($order['payment_status'], array('verify_pass','success'))){
                        $order_statu="done";
                    }else{
                        $order_statu="";
                    }
                    $xml_date .='
                                <item> 
                                <order_id>'.$order["ordernum"].'</order_id> 
                                <click_id>'.$order["click_id"].'</click_id>
                                <status>'.$order_statu.'</status>
                                <date>'.$order["created"].'</date> 
                                <order_total>'.number_format(round($order["amount"], 2),2).'</order_total> 
                                <coupon>'.$order["coupon"].'</coupon> 
                                <discount>'.number_format(round($order["amount_coupon"], 2),2).'</discount> 
                                <currency>'.$order["currency"].'</currency> 
                                <payment_method>cash</payment_method> 
                                <customer_type>new</customer_type>
                                <basket> ';
                    $products=Order::instance($order["id"])->products();
                    foreach ($products as $product) {
                        $catalog=Set::instance(Product::instance($product['product_id'])->get("set_id"))->get('name');
                        $xml_date.='
                                <product> 
                                <pid>'.$product['sku'].'</pid> 
                                <pc>'.$catalog.'</pc> 
                                <pn>'.$product['name'].'</pn> 
                                <up>'.number_format(round($product['price'], 2),2).'</up> 
                                <qty>'.$product['quantity'].'</qty> 
                                </product>';
                    }
                    $xml_date.=' 
                                </basket> 
                                </item>';
                                
                }
            $xml_date.='</items>';
            header("Content-type: text/xml");  
            echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; 
            echo $xml_date;
            exit;
            }else{
                exit;
            }
        }else{
            exit;
        }
    }

}

