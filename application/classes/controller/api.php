<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Api extends Controller_Webpage
{
    //服务器 生日发送邮件
    public function action_send_birthday_mail()
    {
        set_time_limit(0);
        api::send_birthday_email();
        exit();
    }

    //feed 服务器定时任务
    public function action_updateFeed()
    {
        set_time_limit(0);

        //手动
        $feeds = DB::select()->from('core_pla')
            ->where('type','=','0')
            ->execute()
            ->as_array();

        foreach ($feeds as $feed)
        {
            DB::update('core_pla')->where('type','=','0')->set(['status'=>'0'])->execute();
            DB::update('core_pla')->where('id','=',$feed['id'])->set(['status'=>'1'])->execute();
            $url = BASEURL.'/webpowerfor/mihqtgylls/'.strtoupper($feed['country']);
//           $url = 'http://local.newchoies.com/webpowerfor/mihqtgylls/'.strtoupper($feed['country']);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
        }
        die;
    }

    //后台 vip数据更新
    public function action_newvip1()
    {
        //获取当前的月份
        $month=date('m');
        $day=date('d');

        //获取去年这个时候的月份
        $lastyear=strtotime('last year');
        //去年这个时候的时间
        $last=date('Y-m-d',$lastyear);
        $page = Arr::get($_GET, 'page', 1);
        $limit =1000;

        $startvip=strtotime('2015-01-01 00:00:00');

        $sql = array();
        $file = '';
        $up="";
        $up1="";

        $result = DB::query(Database::SELECT, 'SELECT customer_id,email,sum(amount/rate) as sum_amount FROM `orders_order` where payment_status="verify_pass" and refund_status<>"refund" and is_active=1 and verify_date>'.$startvip.' GROUP BY customer_id HAVING(sum_amount >= 199) ORDER BY customer_id limit '.$limit.' offset '.($page - 1) * $limit.' ')->execute('slave')->as_array();
        foreach($result as $k=>$v){
            if($v['customer_id'])
            {
                $vip_ok=DB::query(Database::SELECT, 'SELECT id,ordernum,verify_date FROM `orders_order` where customer_id='.$v['customer_id'].' and payment_status="verify_pass" and refund_status<>"refund" and is_active=1 ORDER BY id desc limit 1')->execute('slave')->current();
                //去年下单时间
                if($vip_ok['verify_date']>strtotime('2016-01-01 00:00:00')){
                    $last_time=strtotime(date('Y',$vip_ok['verify_date'])-1 .'-'.date('m-d H:i:s',$vip_ok['verify_date']));
                    $result1 = DB::query(Database::SELECT, 'SELECT id,customer_id,email,sum(amount/rate) as sum_amount FROM `orders_order` where customer_id='.$v['customer_id'].' and payment_status="verify_pass" and refund_status<>"refund" and is_active=1 and verify_date > '. $last_time .' and  verify_date <= '. $vip_ok['verify_date'] .'')->execute('slave')->current();
                    //获取用户vip时间(和用户最终下单时间比较)
                    if($result1['sum_amount']>=199){
                        $data['is_vip']=2;
                        $data['vip_start']=$vip_ok['verify_date'];
                        $data['vip_end']=strtotime(date('Y',$vip_ok['verify_date'])+1 .'-'.date('m-d H:i:s',$vip_ok['verify_date']));
                        $up .=$v['customer_id']."<br/>";
                        DB::update('accounts_customers')->set($data)->where('id', '=', $v['customer_id'])->execute();
                    }
                }
            }
        }

        header("Content-type: text/html; charset=utf-8");
        echo "此次更新的用户有(再次下单)<br/>".$up."<br/>";
        //echo "此次会员到期的用户有(到期时间小于当前时间就属于过期)<br/>".$up1."<br/>";

        echo '<script type="text/javascript">
                setTimeout("pagerefresh()",5000);
                setTimeout("logout()",6000);
                function pagerefresh() 
                { 
                    window.open("?page=' . ($page + 1) . '");
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

    //oa 抓单
    public function action_orderlistjava()
    {
        $data = array();
        $date = isset($_REQUEST['date']) ? trim($_REQUEST['date']) : '';
        $from = strtotime($date . ' midnight');
        $to = $from + 86400;

        $orders = DB::query(Database::SELECT, 'SELECT o.id,o.payment_status,o.verify_date,o.ordernum,o.email,o.customer_id,o.currency,o.amount,o.amount_products,o.amount_shipping,o.amount_coupon,o.amount_payment,o.ip,o.rate,
                o.shipping_firstname,o.shipping_lastname,o.shipping_address,o.shipping_city,o.shipping_state,o.shipping_country,o.shipping_zip,o.shipping_phone,o.billing_firstname,o.billing_lastname,o.billing_address,o.billing_city,o.billing_zip,o.billing_phone,o.billing_state,o.billing_country,o.shipping_status,o.created,o.updated,o.payment_method,o.order_insurance,o.shipping_weight,o.order_from
                FROM orders_order o WHERE o.is_active = 1 AND o.payment_status = "verify_pass" AND o.created BETWEEN "' . $from . '" AND "' . $to . '" GROUP BY o.id ORDER BY o.id')
                ->execute('slave');
        foreach ($orders as $o)
        {
            $items = array();
            $itemArr = DB::query(Database::SELECT, 'SELECT sku, quantity, price, attributes,product_id,created,status FROM orders_orderitem WHERE order_id = ' . $o['id'])->execute('slave');
            $tracks = array();
            $tracking = DB::query(Database::SELECT, 'SELECT tracking_code, tracking_link FROM orders_ordershipments WHERE order_id = ' . $o['id'])->execute('slave');
            $remark = array();
            $remarks = DB::select('remark')->from('orders_orderremarks')->WHERE('order_id', '=', $o['id'])->execute('slave');

            foreach ($tracking as $t)
            {
                $tracks[] = array(
                    'tracking_code' => $t['tracking_code'],
                    'tracking_link' => $t['tracking_link']
                );
            }          
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
                    'price' => $i['price'],
                    'product_id' => $i['product_id'],
                    'created' => date('Y-m-d H:i:s', $i['created']),
                    'status' => $i['status']
                );
            }
                $amount_usd = $o['amount'] / $o['rate'];
            $data[] = array(
                'id' => null,
                'payment_status' => $o['payment_status'],
                'date_purchased' => date('Y-m-d H:i:s', $o['verify_date']),
                'is_active' => '1 ',
                'ordernum' => $o['ordernum'],
                'email' => $o['email'],
                'customer_id' => $o['customer_id'],
                'currency' => $o['currency'],
                'amount' => $o['amount'],
                'amount_usd' => $amount_usd,
                'amount_products' => $o['amount_products'],
                'amount_shipping' => $o['amount_shipping'],
                'amount_coupon' => $o['amount_coupon'],
                'amount_payment' => $o['amount_payment'],
                'ip_address' => long2ip($o['ip']),
                'remark' => implode('|', $remark),
                'shipping_firstname' => $o['shipping_firstname'],
                'shipping_lastname' => $o['shipping_lastname'],
                'shipping_address' => $o['shipping_address'],
                'shipping_city' => $o['shipping_city'],
                'shipping_state' => $o['shipping_state'],
                'shipping_country' => $o['shipping_country'],
                'shipping_zip' => $o['shipping_zip'],
                'shipping_phone' => $o['shipping_phone'],
                'shipping_status' => $o['shipping_status'],
                'created' => date('Y-m-d H:i:s', $o['created']),
                'updated' => date('Y-m-d H:i:s', $o['updated']),
                'shipping_weight' => $o['shipping_weight'],
                'order_from' => $o['order_from'],
                'payment_method' => $o['payment_method'],
                'order_insurance' => $o['order_insurance'],
                'billing_firstname' => $o['billing_firstname'],
                'billing_lastname' => $o['billing_lastname'],
                'billing_address' => $o['billing_address'],
                'billing_city' => $o['billing_city'],
                'billing_state' => $o['billing_state'],
                'billing_country' => $o['billing_country'],
                'billing_zip' => $o['billing_zip'],
                'billing_phone' => $o['billing_phone'],
                'trackinginfo' => $tracks,
                'orderitems' => $items,
            );
        }
        echo json_encode($data);
        exit;
    }

    //oa 抓单
    public function action_orderlistjava11()
    {
        $data = array();
        $date = isset($_REQUEST['date']) ? trim($_REQUEST['date']) : '';
        $from = strtotime($date . ' midnight');
        $to = $from + 86400;

        $orders = DB::query(Database::SELECT, 'SELECT o.id,o.payment_status,o.verify_date,o.ordernum,o.email,o.customer_id,o.currency,o.amount,o.amount_products,o.amount_shipping,o.amount_coupon,o.amount_payment,o.ip,o.rate,o.points,o.amount_point,o.coupon_code,
                o.shipping_firstname,o.shipping_lastname,o.shipping_address,o.shipping_city,o.shipping_state,o.shipping_country,o.shipping_zip,o.shipping_phone,o.billing_firstname,o.billing_lastname,o.billing_address,o.billing_city,o.billing_zip,o.billing_phone,o.billing_state,o.billing_country,o.shipping_status,o.created,o.updated,o.payment_method,o.order_insurance,o.shipping_weight,o.order_from
                FROM orders_order o WHERE o.is_active = 1  AND o.created BETWEEN "' . $from . '" AND "' . $to . '" GROUP BY o.id ORDER BY o.id')
                ->execute('slave');
        foreach ($orders as $o)
        {
            $cus = Customer::instance($o['customer_id']);
            $cus_created = $cus ->get('created');
            $items = array();
            $itemArr = DB::query(Database::SELECT, 'SELECT sku, quantity, price, attributes,product_id,created,status FROM orders_orderitem WHERE order_id = ' . $o['id'])->execute('slave');
            $iscele = DB::query(Database::SELECT, 'SELECT orders.customer_id FROM `orders_order`,celebrities_celebrits  WHERE orders_order.customer_id = celebrities_celebrits.customer_id and orders.id = '.$o['id'])->execute('slave');
            $hongren = 0;
            if($iscele[0]['customer_id']){
                $hongren = 1;
            }
            $remark = array();
            $remarks = DB::select('remark')->from('orders_orderremarks')->WHERE('order_id', '=', $o['id'])->execute('slave');
            foreach($remarks as $r)
            {
                $remark[] = $r['remark'];
            }
            foreach ($itemArr as $i)
            {
                $pro = Product::instance($i['product_id']);
                $procreated = $pro ->get('created');
                $source = $pro ->get('source');
                $total_cost = $pro ->get('total_cost');
                $ppprice = $pro ->get('price');
                $weight = $pro ->get('weight');
                $set = $pro ->get('set_id');
                $setname = Set::instance($set) ->get('name');
                $catemanger = Set::instance($set)->get('catemanger');
                $amount_usd = $o['amount'] / $o['rate'];
                $skucount = DB::query(Database::SELECT, 'select count(id) as skucount from products_product where set_id  = "'.$set.'"')->execute('slave')->current();
            $data[] = array(
                'id' => null,
                'payment_status' => $o['payment_status'],
                'date_purchased' => date('Y-m-d H:i:s', $o['verify_date']),
                'is_active' => '1',
                'cus_created' => date('Y-m-d H:i:s', $cus_created), 
                'hongren' => $hongren,
                'ordernum' => $o['ordernum'],
                'email' => $o['email'],
                'points' => $o['points'],
                'customer_id' => $o['customer_id'],
                'currency' => $o['currency'],
                'amount' => $o['amount'],
                'amount_point' => $o['amount_point'],
                'amount_usd' => $amount_usd,
                'coupon_code' => $o['coupon_code'],
                'rate' =>$o['rate'],
                'amount_products' => $o['amount_products'],
                'amount_shipping' => $o['amount_shipping'],
                'amount_coupon' => $o['amount_coupon'],
                'amount_payment' => $o['amount_payment'],
                'ip_address' => long2ip($o['ip']),
                'remark' => implode('|', $remark),
                'shipping_firstname' => $o['shipping_firstname'],
                'shipping_lastname' => $o['shipping_lastname'],
                'shipping_address' => $o['shipping_address'],
                'shipping_city' => $o['shipping_city'],
                'shipping_state' => $o['shipping_state'],
                'shipping_country' => $o['shipping_country'],
                'shipping_zip' => $o['shipping_zip'],
                'shipping_phone' => $o['shipping_phone'],
                'shipping_status' => $o['shipping_status'],
                'created' => date('Y-m-d H:i:s', $o['created']),
                'updated' => date('Y-m-d H:i:s', $o['updated']),
                'shipping_weight' => $o['shipping_weight'],
                'order_from' => $o['order_from'],
                'payment_method' => $o['payment_method'],
                'order_insurance' => $o['order_insurance'],
                'billing_firstname' => $o['billing_firstname'],
                'billing_lastname' => $o['billing_lastname'],
                'billing_address' => $o['billing_address'],
                'billing_city' => $o['billing_city'],
                'billing_state' => $o['billing_state'],
                'billing_country' => $o['billing_country'],
                'billing_zip' => $o['billing_zip'],
                'billing_phone' => $o['billing_phone'],
                'orderitems' => $items,
                'sku' => $i['sku'],
                'attributes' => $i['attributes'],
                'quantity' => $i['quantity'],
                'price' => $i['price'],
                'product_id' => $i['product_id'],
                'created' => date('Y-m-d H:i:s', $i['created']),
                'status' => $i['status'],
                'procreated' => date('Y-m-d H:i:s', $procreated),
                'source' => $source,
                'setname' => $setname,
                'total_cost' => $total_cost,
                'weight' => $weight,
                'ppprice' => $ppprice,
                'catemanger' => $catemanger,
                'skucount'=>$skucount['skucount']
                );

            }

        }
        echo json_encode($data);
        exit;
    }

    #oa 当天用户消费清单 for java Ma 09.01   11.22 exit!
    public function action_usercount(){
        set_time_limit(0);
        $data = array();
        $date = isset($_REQUEST['date']) ? trim($_REQUEST['date']) : '';
        $from = strtotime($date . 'midnight');
        $to = $from + 86400;
        #查询当天所有订单
        $order = DB::query(Database::SELECT, 'select id,amount,created as order_time,email as usermail,payment_date from orders where created >= "'.$from.'" and created <= "'.$to.'" and payment_status = "verify_pass"')->execute()->as_array();
        if(!$order){
            $arr = array('message'=>'No order for the day!');
            echo json_encode($arr);exit;
        }
        $oidStr = '';
        foreach ($order as $orderItem) {
            $orderArr[$orderItem['id']] = $orderItem;
            $oidStr .= '"' . $orderItem['id'] . '",';
        }
        $oidStr = substr($oidStr, 0, -1);
        unset($order);

        #查询购买产品数
        $order_items = DB::query(Database::SELECT, 'select order_id,count(order_id) as ordercount,count(quantity) as quantity from order_items where order_id in ('.$oidStr.') group by order_id')->execute()->as_array();
        $countArr = array();
        foreach ($order_items as $count) {
            $countArr[$count['order_id']] = array_merge($count, $orderArr[$count['order_id']]);
        }

        #更改数组主键为email
        $countNarr = array();
        $mailStr = '';
        foreach ($countArr as $umail) {
            if(!isset($countNarr[$umail['usermail']])){
                $countNarr[$umail['usermail']]['amount'] = 0;
            }
            $amountSum = $countNarr[$umail['usermail']]['amount']+$umail['amount'];
            $countNarr[$umail['usermail']] = $umail;
            $mailStr .= '"' . $umail['usermail'] . '",';
        }
        $mailStr = substr($mailStr, 0, -1);
        unset($countArr);
        unset($order_items);

        #匹配用户
        $userArr = array();
        $user = DB::query(Database::SELECT, 'select email,created,last_login_time,country from customers where email in ('.$mailStr.')')->execute()->as_array();
        foreach ($user as $userItem) {
            $userArr[] = array_merge($userItem, $countNarr[$userItem['email']]);
        }

        #转换时间日期格式
        $outArr = array();
        foreach ($userArr as $key => $value) {
            $value['created'] = date('Y-m-d H:i:s', $value['created']);
            $value['last_login_time'] = date('Y-m-d H:i:s', $value['last_login_time']);
            $value['order_time'] = date('Y-m-d H:i:s', $value['order_time']);
            $value['payment_date'] = date('Y-m-d H:i:s', $value['payment_date']);
            $outArr[] = $value;
        }
        echo json_encode($outArr);
        exit;
    }

    #shenmart 获取图片表所有数据
    public function action_getImages(){
        $curl_data = $_REQUEST;
        if($curl_data['id'] != 'not'){
            $id = intval($curl_data['id']);
            $images = DB::query(Database::SELECT, 'select id,type,suffix,obj_id,image_name,status from products_productimage where id > ' . $id . ' order by id asc limit 10000')->execute('slave')->as_array();
        }else{
            $images = DB::query(Database::SELECT, 'select id,type,suffix,sobj_id,image_name,status from products_productimage order by id asc limit 10000')->execute('slave')->as_array();
        }
        echo json_encode($images);
        exit(); 
    }

    #shenmart 获取图片表所有数据
    public function action_getImages_by_skus(){
        
        if(empty($_POST['skus'])){
            echo false;
            exit();
        }
        $curl_data = $_POST['skus'];
        $skuArr = explode(',', $curl_data);
        $sql='select i.id iid,i.type itype,i.suffix isuffix ,i.status ist from products_product p inner join products_productimage i on p.id = i.product_id where p.sku=';
        $sql1='select configs from products_product where sku=';
        $data_res=array();
        $data_res1=array();
        $data_res2=array();
        foreach ($skuArr as $sku) {
            if(!empty($sku)){
                $data_imgs=DB::query(Database::SELECT, $sql.'"'.$sku.'"')->execute('slave')->as_array();
                if(!empty($data_imgs)) $data_res[$sku]=$data_imgs;
                $data_configs=DB::query(Database::SELECT, $sql1.'"'.$sku.'" limit 1')->execute('slave')->current();
                if(!empty($data_configs))
                {
                    $data_res1[$sku]=$data_configs['configs']; 
                    $data_res2[$sku]=unserialize($data_configs['configs']);       
                } 
            }
        }
        
        if(empty($data_res)||empty($data_res1)){
            echo false;
            exit();
        }
        $d_r=array(
            'imgs'=>$data_res,
            'configs'=>$data_res1,
            'imgarr'=>$data_res2,
            );
        kohana::$log->add('getImages_by_skus',serialize($d_r));
        echo json_encode($d_r);
        exit();

    }
    
    //shenmart
    public function action_getproduct(){
        $arr = $_REQUEST; 
        $i = 0;
        foreach($arr as $v){
            $brr[$i] = $v;
            $i++;
        }
        $pro = array();
        foreach($brr as $v){
            $products = DB::select()->from('products_product')->where('sku', '=', $v)->execute('slave')->as_array();
            $pro[] = $products;
        }
        echo json_encode($pro);
        exit();
    }

    //shenmart
    public function action_get_celebrity_img_info_by_skus()
    {
        $skus=Arr::get($_POST, 'skus', '');
        if(empty($skus)) {
            echo "require data input";
            exit();
        }
        $skus=explode(',', $skus);
        $img_infos=array();
        foreach ($skus as $sku) {
            if(empty($sku)) continue;
            $product = DB::query(DATABASE::SELECT, 'SELECT id FROM products_product WHERE sku = "' . $sku.'" limit 1')->execute()->current();
            if(empty($product['id'])) continue;
            $product_id=$product['id'];
            $img_info = DB::query(DATABASE::SELECT, 'SELECT image,position FROM products_celebrityimages WHERE product_id = "' . $product_id.'" ')->execute()->as_array();
            if(!empty($img_info)){
                $img_infos[$sku]=$img_info;
            }
        }
        if(empty($img_infos)){
            echo 'no db data';
            exit();
        }else{
            echo json_encode($img_infos);
            exit();
        }

    }

    //erp 抓单
    public function action_order_date_list()
    {
        $data = array();
        $date = isset($_REQUEST['date']) ? trim($_REQUEST['date']) : '';
        $from = strtotime($date . ' midnight');
        $to = strtotime($date . ' + 1 day midnight') - 1;
        $orders = DB::query(Database::SELECT, 'SELECT o.id,o.payment_status,o.verify_date,o.ordernum,o.email,o.customer_id,o.currency,o.rate,o.amount,o.amount_products,o.amount_shipping,o.amount_coupon,o.amount_payment,o.ip,o.payment_method,o.payment_date,o.order_from,o.order_insurance,
                o.shipping_firstname,o.shipping_lastname,o.shipping_address,o.shipping_city,o.shipping_state,o.shipping_country,o.shipping_zip,o.shipping_phone,o.billing_firstname,o.billing_lastname,o.billing_address,o.billing_city,o.billing_zip,o.billing_phone,o.billing_state,o.billing_country,o.transaction_id 
                FROM orders_order o WHERE o.is_active = 1  AND (o.erp_header_id < 1 or o.erp_header_id is null )AND o.payment_status = "verify_pass" AND o.verify_date BETWEEN "' . $from . '" AND "' . $to . '" GROUP BY o.id ORDER BY o.id')
            ->execute('slave');

        $countries = Site::instance()->countries();

        $n =0;
        foreach ($orders as $o)
        {

            $items = array();
            $itemArr = DB::query(Database::SELECT, 'SELECT sku, quantity, price, attributes, is_gift FROM orders_orderitem WHERE order_id = ' . $o['id'] .' and status != "cancel"')->execute('slave');
            $remark = array();
            $remarks = DB::select('remark')->from('orders_orderremarks')->WHERE('order_id', '=', $o['id'])->execute('slave');
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

            $admin_id = DB::select('admin_id')->from('celebrities_celebrits')->where('email', '=', $o['email'])->execute('slave')->get('admin_id');
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
            $n = $n+1;

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
                'trans_id'=> $o['transaction_id'],
            );

        }

        echo json_encode($data);
        exit;
    }

    //erp回传物流信息rp_header_id = 2
    public function action_from_ws_update_order_erp()
    {
        $success = 0;
        if($_REQUEST)
        {
            $order_id = Arr::get($_REQUEST, 'order_id', 0);
            if($order_id)
            {
                //9.14 guo update
                $data['erp_header_id'] = 2;
                $data['shipping_status'] = 'processing';
                DB::update('orders_order')->set($data)->where('id', '=', $order_id)->execute();
                $success = 1;
            }
        }
        kohana::$log->add('from_ws_update_order_erp',$success);
        echo json_encode($success);
        exit;
    }

    //erp 已发货信息回传
    public function action_from_ws_update_shipment()
    {
        if($_POST)
        {
            $success = 0;
            $updated = Arr::get($_POST, 'updated', 0);
            if($updated == 1)
            {
                $v = Validate::factory($_POST)
                    ->rule('ordernum', 'not_empty')
                    ->rule('status', 'not_empty')
                    ->rule('skus', 'not_empty')
                    ->rule('qtys', 'not_empty')
                    ->rule('totals', 'not_empty')
                    ->rule('tracking_no', 'not_empty')
                    ->rule('shipping_method', 'not_empty')
                    ->rule('shipping_time', 'not_empty')
                    ->filter('tracking_link', 'trim')
                    ->rule('package_id', 'not_empty');
                if ($v->check())
                {
                    $onum = $v['ordernum'];
                    $order = ORM::factory('order')->where('ordernum', '=', $v['ordernum'])->find();
                    if($order && !empty($onum))
                    {
                        $orderd = Order::instance($order->id);
                        $onum1 = $orderd->get('ordernum');
                        if(!empty($onum1))
                        {    
                            if($v['status'] == 'shipped')
                                $data['shipping_status'] = 'shipped';
                            else
                                $data['shipping_status'] = 'partial_shipped';
                            $data['shipping_date'] = time();
                            $shipping_status = $order->shipping_status;
                            if($shipping_status != 'shipped' and $data['shipping_status'] == 'shipped'){
                                // add points
                                // $amount = $order->amount;
                                // if ($amount > 0)
                                // {
                                //     Event::run('Order.payment', array(
                                //         'amount' => (int) $amount,
                                //         'order' => $orderd,
                                //     ));
                                // }
                            }
                            $order->values($data);
                            $ret = $order->save();
                            if ($ret)
                            {
                                $shipment = array(
                                    'carrier' => $v['shipping_method'],
                                    'tracking_code' => $v['tracking_no'],
                                    'tracking_link' => $v['tracking_link'],
                                    'ship_date' => strtotime($v['shipping_time']),
                                    'ship_price' => $v['totals'],
                                    'package_id' => $v['package_id'],
                                );
                                $items = array();
                                $skusArr = explode(',', $v['skus']);
                                $qtysArr = explode(',', $v['qtys']);
                                foreach($skusArr as $key => $sku)
                                {
                                    if(isset($qtysArr[$key]))
                                    {
                                        $skuA = explode('-', $sku);

                                        $item_id = Item::get_itemId_by_sku(trim($skuA[0]));
                                        $item_id = Item::instance($item_id)->get('product_id');
                                        if($item_id)
                                        {
                                            $items[] = array(
                                                'item_id' => $item_id,
                                                'quantity' => $qtysArr[$key],
                                            );
                                        }
                                    }

                                }

                                if($orderd->add_shipment($shipment, $items))
                                {
                                    $orderd->set(array(
                                        'ship_date' => strtotime($v['shipping_time']),
                                        'tracking_code' => $v['tracking_no'],
                                        'tracking_link' => $v['tracking_link'],
                                    ));
                                    $success = 1;

                                    if ($data['shipping_status'] == 'shipped')
                                    {
                                        $email_params = array(
                                            'tracking_num' => $v['tracking_no'],
                                            'tracking_url' => $v['tracking_link'],
                                            'order_num' => $v['ordernum'],
                                            'currency' => $orderd->get('currency'),
                                            'amount' => $orderd->get('amount'),
                                            'email' => $orderd->get('email'),
                                            'firstname' => $orderd->get('shipping_firstname'),
                                            'tracking_words' => '',
                                        );
                                        Mail::SendTemplateMail('SHIPPING', $email_params['email'], $email_params);
                                    }
                                    else
                                    {
                                        $email_params = array(
                                            'tracking_num' => $v['tracking_no'],
                                            'tracking_url' => $v['tracking_link'],
                                            'order_num' => $v['ordernum'],
                                            'currency' => $orderd->get('currency'),
                                            'amount' => $orderd->get('amount'),
                                            'email' => $orderd->get('email'),
                                            'firstname' => $orderd->get('shipping_firstname'),
                                            'tracking_words' => '',
                                        );

                                        Mail::SendTemplateMail('PARTIALSHIPPING', $email_params['email'], $email_params);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            elseif($updated == 2)
            {
                $v = Validate::factory($_POST)
                    ->rule('ordernum', 'not_empty')
                    ->rule('tracking_no', 'not_empty')
                    ->rule('shipping_method', 'not_empty')
                    ->filter('tracking_link', 'trim')
                    ->rule('package_id', 'not_empty');
                if ($v->check())
                {
                    $order = ORM::factory('order')->where('ordernum', '=', $v['ordernum'])->find();
                    if($order)
                    {
                        $shipment = DB::update('orders_ordershipments')
                            ->set(array('tracking_code' => $v['tracking_no'], 'tracking_link' => $v['tracking_link']))
                            ->where('order_id', '=', $order->id)
                            ->where('package_id', '=', $v['package_id'])
                            ->execute();
                        if($shipment)
                        {
                            $success = 1;
                        }
                    }
                }
            }
            echo json_encode($success);
            exit;
        }
    }

    //erp 到货信息回传 待取/已签收
    public function action_from_ws_update_shipment_status()
    {
        if($_POST)
        {
            $success = 0;
            $v = Validate::factory($_POST)
                ->rule('ordernum', 'not_empty')
                ->filter('delivery_age', 'trim')
                ->filter('delivery_time', 'trim')
                ->rule('status', 'not_empty');
            if ($v->check())
            {
                $order = ORM::factory('order')->where('ordernum', '=', $v['ordernum'])->find();
                if($order)
                {
                    $orderd = Order::instance($order->id); // guo add
                    $shipments = $orderd->shipments();// guo add
                    if($v['status'] == 'delivered')
                        $data['shipping_status'] = 'delivered';//已签收 妥投
                    elseif($v['status'] == 'pickup')
                        $data['shipping_status'] = 'pickup';//到达待取

                    $data['logistics_days'] = $v['delivery_age'];
                    $data['deliver_time'] = $v['delivery_time'];
                    $order->values($data);
                    $ret = $order->save();
                    if($ret)
                       $success = 1;

                    if ($data['shipping_status'] == 'delivered')
                    {
                        $email_params = array(
                            'created' => date('Y-m-d',$orderd->get('created')),
                            'order_num' => $orderd->get('ordernum'),
                            'currency' => $orderd->get('currency'),
                            'amount' => round($orderd->get('amount'),2),
                            'email' => $orderd->get('email'),
                            'points' => floor($orderd->get('amount') / $orderd->get('rate')),
                        );
                        Mail::SendTemplateMail('CONFIRM_MAIL', $email_params['email'], $email_params);
                    }
                    elseif($data['shipping_status'] == 'pickup' && isset($shipments[0]['tracking_code']))
                    {
                       $email_params = array(
                            'firstname' => $orderd->get('shipping_firstname'),
                            'order_num' => $orderd->get('ordernum'),
                            'tracking_num' => $shipments[0]['tracking_code'],
                            'tracking_url' => $shipments[0]['tracking_link'],
                            'email' => $orderd->get('email'),
                        );

                        Mail::SendTemplateMail('PICK UP', $email_params['email'], $email_params);
                    }
                }
            }
            echo json_encode($success);
            exit;
        }
    }

    //erp回传缺货信息，报等邮件  ws触发订单产品报等接口
    public function action_send_mail_baodeng()
    {

        set_time_limit(0);

        $res=array();


        $res['error_item']=array();
        $res['mes']=array();
        // $data=Arr::get($_POST, 'baodeng', '');
        $data=$_POST['baodeng'];

        if(empty($data)){
            echo 'no data input';
            exit();
        }


        $data=json_decode($data,True);


        foreach ($data as $orderinfo) {

            $ordernum = $orderinfo['ordernum'];
            $sku=$orderinfo['sku'];
            $attr=$orderinfo['attributes'];
            $days=$orderinfo['days'];
            $erp_oid=$orderinfo['erp_oid'];
            //

            if(empty($ordernum)){
                $res['mes'][]='ordernum empty';
                continue;
            }
            if(empty($sku)){
                $res['mes'][]='sku empty';
                continue;
            }
            if(empty($days)){
                $res['mes'][]='days empty';
                continue;
            }


            $order = DB::query(DATABASE::SELECT, 'SELECT id FROM orders_order WHERE ordernum = "' . $ordernum.'" limit 1')->execute()->current();
            if(empty($order['id'])){
                $res['mes'][]='orderid empty';
                $res['error_item'][]=$erp_oid;
                continue;
            }
            $order_id=$order['id'];


            $item = DB::query(DATABASE::SELECT, 'SELECT id FROM orders_orderitem WHERE order_id = "' . $order_id.'" and sku ="'.$sku.'" and attributes="'.$attr.'" limit 1')->execute()->current();
            if(empty($item['id'])){
                $res['mes'][]='itemid empty';
                $res['error_item'][]=$erp_oid;
                continue;
            }
            $item_id=$item['id'];



            $r=api::send_wait_email($item_id,$order_id,$days);
            if(empty($r)){

                $res['error_item'][]=$erp_oid;
            }
        }
        echo json_encode($res);
        exit();
        //筛选是否发送过的机制在ws，此处不需要添加
    }

    //erp 同款不同色
    public function action_color_product()
    {
        if($_REQUEST)
        {
            $url='http://erp.wxzeshang.com:8000/api/choies_erp_style/';
        }else{
            $url='http://192.168.11.109:8002/api/choies_erp_style/';
        }


        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $colors = curl_exec($ch);
            curl_close($ch);
        }catch(Exception  $e){
            echo '获取数据失败';
            die;
        }

        $colors=json_decode($colors,true);

        if($colors)
        {
            foreach ($colors as $color)
            {
                // 过滤erp默认值
                if($color['style_id'] == 1)
                {
                    continue;
                }
                // 确认sku,获取产品id
                $pro = DB::select('id')->from('products_product')
                    ->where('sku','=',$color['sku'])
                    ->execute('slave')
                    ->current();
                if(!$pro)
                {
                    $product = DB::select('id')->from('products_product')
                        ->where('sku','=',$color['choies_sku'])
                        ->execute('slave')
                        ->current();
                    if(!$product)
                    {
                        continue;
                    }else
                    {
                        $pro = $product;
                    }
                }

                // 检查是否存在
                $colorpro = DB::select()->from('products_colorproduct')
                    ->where('product_id','=',$pro['id'])
                    ->execute('slave')
                    ->current();

                // 不存在，插入;存在,检查group,如果group更改,则更新
                if(!$colorpro)
                {
                    $data['group'] = $color['style_id'];
                    $data['product_id'] = $pro['id'];
                    DB::insert('products_colorproduct',array_keys($data))->values($data)->execute();
                }else{
                    if($color['style_id'] == $colorpro['group'])
                    {
                        continue;
                    }else{
                        DB::update('products_colorproduct')
                            ->where('id','=',$colorpro['id'])
                            ->set(array('group'=>$color['style_id']))
                            ->execute();
                    }
                }
            }
            echo 'success';
        }
        die;
    }

    //erp 产品发布--入口
    public function action_catch_skus_info_from_ws()
    {
        if(empty($_POST['skus']))
        {
            die('empty input');
        }

        $skus=$_POST['skus'];
        Kohana_log::instance()->add('catch_product_info_from_ws', $skus );

        $product_info_json=$this->action_catch_sku_info_from_ws($skus);
        $products=json_decode($product_info_json,true);

        if(empty($products))
        {
            Kohana_log::instance()->add('catch_product_info_from_ws', ' STATE:ERROR' . ' | RES:empty ' );
            exit();
        }
        else
        {
            Kohana_log::instance()->add('catch_product_info_from_ws', ' STATE:NORMAL' . ' | RES:' . $product_info_json );
        }

        $result=array();
        foreach ($products as $product)
        {
            if(empty($product))
            {
                continue;
            }
            // 检查item的尺码，不允许重复，不允许超出产品attributes字段的尺码
            if(!Api::checkSize($product))
            {
                $result[] = array('sku'=>$product['sku'],'flag'=>0,'msg'=>'please check item size');
                continue;
            };
            $pid_tmp=0;
            $mes_tmp='';
            $a=$this->action_do_sku_info_from_ws($product,$pid_tmp,$mes_tmp);

            if($a)
            {
                $p_instance=Product::instance($pid_tmp);
                $p_link=$p_instance->permalink();
                $result[]=array('sku'=>$product['sku'],'flag'=>1,'url'=>$p_link);
            }
            else
            {
                $result[]=array('sku'=>empty($product['sku'])?'':$product['sku'],'flag'=>0,'msg'=>$mes_tmp);
            }
        }

        if(!empty($result))
        {
            $str=json_encode($result);
            // echo $str;
            $this->return_status_to_ws($str);
        }



        exit();
    }

    //erp 产品发布--获取数据
    function action_catch_sku_info_from_ws($skus)
    {
        if(empty($skus))
        {
            return false;
        }

        if($_REQUEST)
        {
            $url='http://erp.wxzeshang.com:8000/api/choies_get_ws_tribute/';
        }else{
            $url='http://192.168.11.114:8001/api/choies_get_ws_tribute/';
        }

        $post_data=array('skus'=>$skus);
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data);
        $product_info = curl_exec ( $ch );
        curl_close($ch);

        return $product_info;
    }

    //erp 产品发布--数据保存
    function action_do_sku_info_from_ws($product_info,&$pid_tmp,&$mes_tmp)
    {

        if(empty($product_info))
        {
            Kohana_log::instance()->add('sync_product_info_from_ws', ' STATE:ERROR' . ' | RES:empty ' );
            $mes_tmp='empty data';
            return false;
        }

        if(empty($product_info['sku']))
        {

            Kohana_log::instance()->add('sync_product_info_from_ws', ' SKU:empty'.' | STATE:ERROR'  );
            $mes_tmp='empty data';
            return false;
        }

        $product=$product_info;
        //对变量处理
        $images=$product['image'];
        unset($product['image']);

        $img_updated = $product['img_updated']?1:0;
        unset($product['img_updated']);


        $sku=$product['sku'];
        //保存产品信息
        $res = api::import_product_info($product);
        //返回的信息
        if(!$res['flag'] || !$res['id'])
        {
            Kohana_log::instance()->add('sync_product_info_from_ws',  ' SKU:'.$sku .' | STATE:ERROR' .' |  MES:'.$res['mes']);
            $mes_tmp=$res['mes'];
            return false;
        }
        else
        {
            Kohana_log::instance()->add('sync_product_info_from_ws', ' SKU:'.$sku.' | STATE:product info save success'  );
        }

        $product_id = $res['id'];
        //保存产品图片数据，下载产品图片,设置默认首图
        if($img_updated)
        {
            if($res['type']=='update')
            {
                $p_imgs = DB::select('id')
                    ->from('products_productimage')
                    ->where('product_id', '=', $product_id)
                    ->execute()->as_array();
                if(!empty($p_imgs))
                {
                    foreach ($p_imgs as $p_img)
                    {
                        image::delete_uploads($p_img['id']);
                    }
                }
            }

            $image_default=0;
            $img_data=array();
            $default_image = 0;
            $images_order=array();

            if(!empty($images))
            {
                //图片数据保存数据库
                $n = 1;
                foreach ($images as $k => $img_url)
                {
                    if(!empty($img_url))
                    {
                        $image_in=array(
                            'type'=>1,
                            'suffix'=>'jpg',
                            'product_id'=>$product_id,
                            'status'=>1,
                            'position'=>$n,
                            'created'=>time(),
                        );

                        $img_insert = DB::insert('products_productimage', array_keys($image_in))->values($image_in)->execute();
                        if(!empty($img_insert[0]))
                        {
                            $img_id = $img_insert[0];
                            //默认首图处理---第一张图为默认首图
                            if($n == 1)
                            {
                                DB::update('products_productimage')
                                    ->where('id','=',$img_id)
                                    ->set(array('is_default'=>1))
                                    ->execute();

                                $default_image = $img_id;
                                $image_default = 1;
                            }
                            $n++;

                            $images_order[]=$img_id;
                            $img_data[$img_id]=$img_url;

                        }else
                        {
                            Kohana_log::instance()->add('sync_product_info_from_ws',  ' SKU:'.$sku.' | STATE:image insert error'  );
                            $mes_tmp='image insert error';
                            return false;
                        }
                    }
                }
            }
            //下载图片，产品表configs字段更新
            if($image_default)
            {

                $img_save_state=true;
                foreach ($img_data as $img_id => $img_url)
                {
                    $img_res=api::download_image($img_url,$img_id);
                    if(empty($img_res['flag']))
                    {
                        $img_save_state=false;
                    }
                }
                if(!$img_save_state)
                {

                    Kohana_log::instance()->add('sync_product_info_from_ws', ' SKU:'.$sku.' | STATE:download image error'  );
                    $mes_tmp='download image error';
                    return false;
                }


                $img_config=array(
                    'default_image'=>$default_image,
                    'images_order'=>implode(',', $images_order),
                );

                $config=array(
                    'configs'=>serialize($img_config),
                );
                try
                {
                    $update=DB::update('products_product')->set($config)->where('id', '=', $product_id)->execute();

                    if($update)
                    {
                        return true;
                    }
                    else
                    {
                        Kohana_log::instance()->add('sync_product_info_from_ws',  ' SKU:'.$sku.' | STATE:update product `config`_images failed'  );
                        $mes_tmp='update product `config`_images failed';
                        return false;
                    }
                }
                catch (Exception $e)
                {
                    Kohana_log::instance()->add('sync_product_info_from_ws', 'SKU:'.$sku.' | STATE:ERROR' .' | MES:'.$e->getMessage());
                    $mes_tmp=$e->getMessage();

                    return false;
                }

            }
        }

        return true;

    }

    //erp 产品发布--返回信息
    function return_status_to_ws($str)
    {
        // echo $str;
//        $url='http://192.168.11.114:8001/api/choies_item_status/';
        $url='http://erp.wxzeshang.com:8000/api/choies_item_status/';

        $post_data=array('skus'=>$str);
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data);
        $product_info = curl_exec ( $ch );
        curl_close($ch);

        Kohana_log::instance()->add('return_status_to_ws', 'DATA:'.$str);
        return true;
    }

    //erp 定时更新库存
    public function action_frow_ws_get_stock()
    {

        if($_POST)
        {
            $skuarr = json_decode($_POST['skus']);
            kohana::$log->add('frow_ws_get_stock',$_POST['skus']);
            foreach ($skuarr as $key => $value)
            {
                $sku = $key;
                $item_id = Item::get_itemId_by_sku(trim($sku));
                $product_id = Item::instance($item_id)->get('product_id');
                $pro = DB::select('stock','source')->from('products_product')->where('id','=',$product_id)->execute()->current();
                $source = $pro['source'];
                $prostock =  $pro['stock'];
                if($source == '库存限制销售' || $source == '做货')
                {
                    $isstock = DB::select('id')
                        ->from('products_productitem')
                        ->where('sku', '=', $sku)
                        ->execute('slave')->get('id');

                    if($isstock)
                    {
                        if($prostock == -1)
                        {
                            $update = DB::update('products_productitem')->set(array('stock' => $value))->where('id', '=', $isstock)->execute();
                        }
//                        $update = DB::update('products_productitem')->set(array('stock' => $value, 'status' => 1))->where('id', '=', $isstock)->execute();
//
//                        kohana_log::instance()->add('1updateskustock', $sku.':'.$value);
//                        if($prostock != -1 && $update)
//                        {
//                            $updateproduct = DB::update('products')->set(array('stock' => -1))->where('id', '=', $product_id)->execute();
//                        }
                    }
                    /*                    else
                                        {
                                            $stocks = array(
                                                'product_id' => $product_id,
                                                'stock' => $value,
                                                'attributes' => $value1,
                                                'sku' =>

                                            );

                                            $insert = DB::insert('products_productitem', array_keys($stocks))->values($stocks )->execute();
                                            kohana_log::instance()->add('1insertskustock', $sku.':'.$qty);
                                            if($prostock != -1 && $insert)
                                            {
                                                $updateproduct = DB::update('products')->set(array('stock' => -1))->where('id', '=', $product_id)->execute();
                                            }
                                        }*/


                }

            }

        }
        kohana::$log->add('action_frow_ws_get_stock','end');
    }

    //todo 产品数据更新 更新的字段：sku name total_cost brief description weight factory taobao_url offline_sku cost
    //erp 产品数据更新
    public function action_catch_skus_by_timing()
    {

        /*
         * 传来的数据格式 array('data'=>json_str)
         * */
        if(empty($_POST['data']))
        {
            exit();
        }


        $languages = Kohana::config('sites.'.'.product_info_catch_language');
        $product = json_decode($_POST['data'],true);
        foreach ($product as $datas)
        {

            $obj = ORM::factory("product")
                ->where('sku', '=', $datas['sku'])
                ->find();
            if($obj->loaded())
            {
                $array = array();
                $filter = array('cost','price','weight');//对这三个字段进行数据验证，大于0，更新,小于0，跳出本次循环
                //需要更新的字段
                foreach ($datas as $key =>  $data)
                {
                    if(!empty($data))
                    {
                        $type = in_array($key,$filter)?($data>0?1:0):1;
                        if(!$type)continue;
                        $array[$key] = $data;
                    }
                }

                //产品表更新
                if(!empty($array))
                {
                    $update=DB::update('products_product')->set($array)->where('sku', '=', $datas['sku'])->execute();
//                    if($update){
//                        Kohana_log::instance()->add('sku_en:'.$datas['sku'], ' STATE:SUCCESS' . ' | RES:'.json_encode($array));
//                    }
//                    else
//                    {
//                        Kohana_log::instance()->add('sku_en:'.$datas['sku'], ' STATE:NORMAL' . ' | RES: no updated');
//                    }
                    //多语言表更新，改版后视情况而定
//                    foreach ($languages as $l)
//                    {
//                        if($l==='en')
//                        {
//                            continue;
//                        }
//                        $update=DB::update('products_'.$l)->set($array)->where('sku', '=', $datas['sku'])->execute();
//                        if(empty($update))
//                        {
//                            Kohana_log::instance()->add('sku_'.$l.':'.$datas['sku'], ' STATE:NORMAL' . ' | RES: no updated');
//                        }
//                        else
//                        {
//                            Kohana_log::instance()->add('sku_'.$l.':'.$datas['sku'], ' STATE:SUCCESS' . ' | RES:'.json_encode($array));
//                        }
//                    }
                }
                else
                {
                    Kohana_log::instance()->add('sku:'.$datas['sku'],'no data');
                }
            }
            else
            {
                Kohana_log::instance()->add('sku:'.$datas['sku'], ' STATE:ERROR' . ' | RES: sku not found');
            }
        }
        exit();
    }

    //erp 批量发送未支付订单的邮件
    public function action_wpemail()
    {
        $sign_id = "";
        $sign_id = $_GET['sign_id'];
        //  校验码防止恶意刷   www.choies.com/api/wpemail?sign_id=8ESQ0BINOV4
        if($sign_id != '8ESQ0BINOV4'){
          exit;
        }
        $result=array();
        
        //获取支付成功邮件
        $result_ok = DB::query(DATABASE::SELECT, 'SELECT * FROM `orders_order` WHERE payment_status in ("success","verify_pass") and email_status in (0,1) order by id desc limit 20')->execute()->as_array();
        
        foreach($result_ok as $k1=>$o1){
            //判断是否已发送过邮件
            $sendlog1 = DB::select('id')
                ->from('mail_logs')
                ->where('type', '=', 1)
                ->where('table', '=', 1)
                ->where('table_id', '=', $o1['id'])
                ->execute()->current();
            if(empty($sendlog1))
            {
                if($o1['payment_status']=='verify_pass' || $o1['payment_status']=='success')
                {
                    $mail_params['order_view_link'] = '<a href="'.BASEURL.'/order/view/' . $o1['ordernum'] . '">View your order</a>';
                    $mail_params['order_num'] = $o1['ordernum'];
                    $mail_params['email'] = $o1['email'];
                    $customer_id = $o1['customer_id'];
                    $mail_params['firstname'] = Customer::instance($customer_id)->get('firstname');
                    $products = $o1['products'] ? unserialize($o1['products']) : array();
                    foreach ($products as $p)
                    {
                        $product = Product::instance($p['id']);
                        $hits = $product->get('hits');
                        $product->set(array('hits' => $hits + $p['quantity']));
                    }
                    $mail_params['order_product'] =
                            '<table border="0" width="92%" style="color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; cursor: text;">
                                                <tbody>
                                                    <tr align="left">
                                                        <td colspan="5"><strong>Product Details</strong></td>
                                                    </tr>';
                    $celebrity_id = Customer::instance($customer_id)->is_celebrity();
                    $order_products = Order::instance($o1['id'])->products();
                    $currency = Site::instance()->currencies($o1['currency']);
                    foreach ($order_products as $rs)
                    {
                        $mail_params['order_product'] .= '<tr align="left">
                                                                    <td>' . Product::instance($rs['item_id'], $o1['lang'])->get('name') . '</td>
                                                                    <td>QTY:' . $rs['quantity'] . '</td>
                                                                    <td>' . $rs['attributes'] . '</td>
                                                                    <td>' . $currency['code'] . round($rs['price'] * $o1['rate'], 2) . '</td>
                                                            </tr>';
                    }
                    $mail_params['order_product'] .= '</tbody></table>';

                    $mail_params['currency'] = $o1['currency'];
                    $mail_params['amount'] = $o1['amount'];
                    $mail_params['pay_num'] = $o1['amount'];
                    $mail_params['pay_currency'] = $o1['currency'];
                    $mail_params['shipping_firstname'] = $o1['shipping_firstname'];
                    $mail_params['shipping_lastname'] = $o1['shipping_lastname'];
                    $mail_params['address'] = $o1['shipping_address'];
                    $mail_params['city'] = $o1['shipping_city'];
                    $mail_params['state'] = $o1['shipping_state'];
                    $mail_params['country'] = $o1['shipping_country'];
                    $mail_params['zip'] = $o1['shipping_zip'];
                    $mail_params['phone'] = $o1['shipping_phone'];
                    $mail_params['shipping_fee'] = $o1['amount_shipping'];
                    $mail_params['payname'] = '';
                    $mail_params['created'] = date('Y-m-d H:i', $o1['created']);
                    $mail_params['points'] = floor($o1['amount'] / $o1['rate']);
                    //支付成功的
                    if ($celebrity_id)
                    {
                        Kohana_Log::instance()->add('SendMail', 'PAYSUCCESS');
                        $send=Mail::SendTemplateMail('PAYSUCCESS', $mail_params['email'], $mail_params);
                    }
                    else
                    {
                        $mail_params['emailaddress'] = $o1['email'];
                        $vip_level = Customer::instance($customer_id)->get('vip_level');
                        $vip_return = DB::select('return')->from('vip_types')->where('level', '=', $vip_level)->execute()->get('return');
                        $rate = $o1['rate'] ? $o1['rate'] : 1;
                        $points = ($o1['amount'] / $rate) * $vip_return;
                        $mail_params['order_points'] = $points;
                        Kohana_Log::instance()->add('SendMail', 'PAYSUCCESS');
                        $send=Mail::SendTemplateMail('PAYSUCCESS', $mail_params['email'], $mail_params);
                    }
                    $insert1 = array(
                        'type' => 1,
                        'table' => 1,
                        'table_id' => $o1['id'],
                        'email' => $o1['email'],
                        'status' => 0,
                        'send_date' => time()
                    );
                    $updata1=array();
                    $updata1 = array(
                        'email_status' => 2,
                    );
                    DB::insert('mail_logs', array_keys($insert1))->values($insert1)->execute();
                    DB::update('orders_order')->set($updata1)->where('id', '=', $o['id'])->execute();
                }
            }
        }
        echo "success!";
        exit;
    }

    //erp ['ordernum': 123, 'sku': 'ABC']，发送报缺邮件
    public function action_ws_set_outstock()
    {
        $success = array();
        $data = trim(Arr::get($_POST, 'item_miss'));
        $data = str_replace('\\', '', $data);
        // $data = '[{"ordernum": "14303331340", "sku": "DRES0407B020W", "order_item_id": 120271}, {"ordernum": "14304041340", "sku": "DRES0407B020W", "order_item_id": 120387}]';
        $item_miss = json_decode($data);
        $from = Site::instance()->get('email');
        if(!empty($item_miss))
        {
            foreach($item_miss as $item)
            {
                $ordernum = $item->ordernum;
                $sku = $item->sku;
                $order_item_id = $item->order_item_id;
                $order_data = DB::select('id', 'ordernum', 'email', 'shipping_firstname', 'payment_status')->from('orders_order')->where('ordernum', '=', $ordernum)->execute('slave')->current();
                if(empty($order_data))
                {
                    continue;
                }
                $update_item = DB::select('id', 'name', 'sku', 'price', 'attributes','quantity')->from('orders_orderitem')->where('order_id', '=', $order_data['id'])->where('sku', '=', $sku)->execute('slave')->current();
                if(empty($update_item))
                {
                    continue;
                }
                $update = DB::update('orders_orderitem')->set(array('status' => 'cancel', 'erp_line_status' => '缺货-WS'))->where('id', '=', $update_item['id'])->execute();
                if($update)
                {
                    $updateItems = array($update_item);
                    $rcpt = $order_data['email'];
                    $rcpts = array($rcpt, 'service@choies.com');
                    $subject = "Sorry dear, item you have ordered from Choies is not available now!";
                    $body = View::factory('/order/item_outstock_mail')->set('orderData', $order_data)->set('updateItems', $updateItems);
                    $send = Mail::Send($rcpts, $from, $subject, $body);

                    $comment_skus='';

                    foreach ($updateItems as $k0 => $v0) {
                        $comment_skus.=$v0['sku'].';';
                    }
                    $order = Order::instance($order_data['id']);
                    $order->add_history(array(
                        'order_status' => 'send baoque',
                        'message' => 'API报缺:'.$comment_skus,
                    ));

                    $success[] = $order_item_id;
                }
            }
        }
        echo json_encode($success);
        exit;
    }

    //erp 漏单处理
    public function action_order_erp()
    {
        $ordernum = Arr::get($_GET,'ordernum','');
        $time = Arr::get($_GET,'time','');
        $token = Arr::get($_GET,'token','');
        $localtoken = 'wrewedfa';
        if(($token != $localtoken) or empty($ordernum) or empty($time))
        {
            die;
        }
        DB::update('orders_order')->where('ordernum','=',$ordernum)->set(array('verify_date'=>$time))->execute();
        exit;
    }

    //es 产品es缓存
    public function action_add_all_product_elastic()
    {
        $sku = $_GET['sku'];
        $page = Arr::get($_GET, 'page', 1);
        $total = Arr::get($_GET, 'total', '');
        $limit = 1000;
        if(empty($total))
        {
            exit;
        }
        if($page*$limit>$total)
        {
            exit;
        }
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);

        $products = DB::select('id', 'name', 'sku', 'visibility','link', 'status', 'description', 'keywords', 'price', 'display_date', 'hits', 'has_pick', 'filter_attributes', 'default_catalog', 'position', 'attributes')
            ->from('products_product')
//            ->where('sku','=',$sku)
            ->order_by('id', 'desc')
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->execute('slave')->as_array();


        if($products and !empty($products))
        {
            $catalog_config = Kohana::config('filter.colors');
            foreach($products as $key => $p)
            {
                $attributes = unserialize($p['attributes']);
                if(!empty($attributes['Size']))
                {
                    $attr_size = array();
                    if(strpos($p['attributes'], 'EUR') !== FALSE)
                    {
                        foreach($attributes['Size'] as $attr)
                        {
                            $attribute = explode('/', $attr);
                            if(!empty($attribute[2]))
                            {
                                $attr_size[] = preg_replace('/[A-Z]+/i', '', $attribute[2]);
                            }
                        }
                    }
                    if(empty($attr_size))
                        $attr_size = $attributes['Size'];
                    $products[$key]['size_value'] = implode(' ', $attr_size);
                    $attr_size = str_replace(' ', '', $attr_size);
                    $attr_string = 'size' . implode(' size', $attr_size);
                    $products[$key]['attributes'] = $attr_string;
                    $p_color = '';
                    foreach($catalog_config as $color)
                    {
                        $color = strtolower($color);
                        if(strpos($p['filter_attributes'], $color) !== FALSE)
                        {
                            $p_color = $color;
                            break;
                        }
                    }
                }
                $products[$key]['color_value'] = $p_color;
                $products[$key]['price'] = round($products[$key]['price'], 2);
                $products[$key]['default_catalog'] = Product::instance($p['id'])->allCategory();
                $products[$key]['pro_price'] = round($products[$key]['price'], 2);
                $products[$key]['has_promotion'] = 0;

                $languages = Kohana::config('sites.language');
                foreach($languages as $language)
                {
                    if($language == 'en' || !$language)
                        continue;
                    $products[$key]['name_' . $language] = $products[$key]['name'];
                    $products[$key]['description_' . $language] = $products[$key]['description'];
                    $products[$key]['keywords_' . $language] = $products[$key]['keywords'];
                }
                $data[]= $p['id'];
            }

            if(!empty($products))
            {
                $responses = $elastic->create_index($products);

                echo date('Y-m-d H:i:s');
                print_r($data);
            }
        }
        else
        {
            echo LANGUAGE . ":<br>\n";
            $product_l = array();
            foreach($products as $key => $p)
            {
                $product_l['name_' . LANGUAGE] = $products[$key]['name'];
                $product_l['description_' . LANGUAGE] = $products[$key]['description'];
                $product_l['keywords_' . LANGUAGE] = $products[$key]['keywords'];
                $res = $elastic->update(array('id' => $p['id']), $product_l);
                echo $p['id'] . '-' . $res . "<br>\n";
            }
        }

        echo '<script type="text/javascript">
                setTimeout("pagerefresh()",3000);
                setTimeout("logout()",4000);
                function pagerefresh()
                {
                    window.open("?page=' . ($page + 1) . '&total='.$total.'");
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

    //es 分类es缓存
    public function action_add_catalog_elastic()
    {
        $page = Arr::get($_GET, 'page', 1);
        $limit = 3000;
        $start = ($page - 1) * $limit;
        $result = DB::query(Database::SELECT, 'SELECT C.product_id, C.category_id 
            FROM products_categoryproduct C LEFT JOIN products_product P ON C.product_id = P.id 
            RIGHT JOIN products_category A ON C.category_id = A.id
            WHERE P.visibility = 1 AND P.status = 1 AND A.visibility = 1
            ORDER BY product_id LIMIT ' . $start . ', ' . $limit)->execute();
        $product_catalogs = array();
        foreach($result as $res)
        {
            if(isset($product_catalogs[$res['product_id']]))
            {
                $product_catalogs[$res['product_id']] .= ' ' . $res['category_id'];
            }
            else
            {
                $product_catalogs[$res['product_id']] = '' . $res['category_id'];
            }
        }
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        foreach($product_catalogs as $product_id => $catalogs)
        {
            $response = $elastic->update(array('id' => $product_id), array('default_catalog' => $catalogs));
            echo $product_id . '---' . $response . "<br>\n";
        }

        echo '<script type="text/javascript">
                setTimeout("pagerefresh()",3000);
                setTimeout("logout()",4000);
                function pagerefresh() 
                { 
                    window.open("?page=' . ($page + 1) . '");
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

    //es 更新es缓存
    public function action_update_elastic()
    {
        $page = Arr::get($_GET, 'page', 1);
        $limit = 1000;
        $products = DB::select('id', 'price')
            ->from('products_product')
            ->where('visibility', '=', 1)
            ->where('status', '=', 1)
            ->order_by('id', 'desc')
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->execute('slave')->as_array();
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        $catalog_config = Kohana::config('filter.colors');
        foreach($products as $key => $p)
        {
            $p_color = '';
            foreach($catalog_config as $color)
            {
                $color = strtolower($color);
                if(isset($p['filter_attributes']))
                {
                    if(strpos($p['filter_attributes'], $color) !== FALSE)
                    {
                        $p_color = $color;
                        break;
                    }                    
                }
            }

            $response = $elastic->update(array('id' => $p['id']), array('color_value' => $p_color));
            echo $p['id'] . '---' . '"' . $p_color . '"' . '---' . $response . "<br>\n";
        }

        echo '<script type="text/javascript">
                setTimeout("pagerefresh()",3000);
                setTimeout("logout()",4000);
                function pagerefresh() 
                { 
                    window.open("?page=' . ($page + 1) . '");
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

    //es
    public function action_init_elastic_price()
    {
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        $filter = array('term' => array('has_promotion' => 1));
        $promotion_elastic = $elastic->search('', array(), 5000, 0, $filter);
        if(!empty($promotion_elastic['hits']['hits']))
        {
            foreach($promotion_elastic['hits']['hits'] as $pro)
            {
                $res = $elastic->do_update($pro['_index'], $pro['_type'], $pro['_id'], array('has_promotion' => 0, 'price' => $pro['_source']['pro_price']));
                if(empty($res['error']))
                {
                    echo $pro['_source']['id'] . "<br>\n";
                }
            }
        }
        exit;
    }

    //es
    public function action_update_elastic_price()
    {
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        $spromotions = DB::query(Database::SELECT, 'SELECT S.product_id, S.price, P.price AS p_price FROM carts_spromotions S 
            LEFT JOIN products_product P ON S.product_id = P.id
            WHERE S.type <> 0 AND S.expired > ' . time() . ' AND P.visibility = 1 AND P.status = 1')
            ->execute('slave')->as_array();
        $responses = '';
        foreach($spromotions as $spromotion)
        {
            if($spromotion['price'] >= $spromotion['p_price'])
                continue;
            $update = array(
                'price' => round($spromotion['price'], 2),
                'has_promotion' => 1,
            );

            $response = $elastic->update(array('id' => $spromotion['product_id']), $update);
            $responses .= $spromotion['product_id'] . '-' . $response . "<br>\n";

            $cache_key = '1/product_price/' . $spromotion['product_id'] . '/0';
            Cache::instance('memcache')->set($cache_key, $spromotion['price'], 7200);
        }
        echo $responses;exit;
    }

    //es
    public function action_update_elastic_brand()
    {
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        $page = Arr::get($_GET, 'page', 1);
        $limit = 1000;
        $start = ($page - 1) * $limit;
        $result = DB::query(Database::SELECT, 'SELECT id, keywords, brand_id FROM products_product WHERE visibility = 1 AND status = 1 LIMIT ' . $start . ', ' . $limit)->execute();
        foreach($result as $product)
        {
            if($product['brand_id'])
            {
                $product['keywords'] .= ' brand' . $product['brand_id'];
                $response = $elastic->update(array('id' => $product['id']), array('keywords' => $product['keywords']));
                echo $product['id'] . '---' . $response . "<br>\n";
            }
            else
            {
                echo $product['id'] . "---No Brand<br>\n";
            }
        }

        echo '<script type="text/javascript">
                setTimeout("pagerefresh()",3000);
                setTimeout("logout()",4000);
                function pagerefresh() 
                { 
                    window.open("?page=' . ($page + 1) . '");
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

    //es 缓存查看
    public function action_www()
    {
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $sku = Arr::get($_GET, 'sku', '');
        $id = Product::get_productId_by_sku($sku);
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        // $res = $elastic->delete_all();
        // print_r($res);exit;

        // $products = DB::select('id', 'name', 'sku', 'description', 'keywords')
        //     ->from('products')
        //     ->where('visibility', '=', 1)
        //     ->where('status', '=', 1)
        //     ->order_by('id', 'desc')
        //     ->limit(10)->offset(30)
        //     ->execute('slave')->as_array();
        // $responses = $elastic->create_index($products);
        // print_r($responses);

        // /* SEARCH */

        echo $id;
        //$res = $elastic->search($sku, array('name', 'sku', 'description'), 5, 0);
        $res = $elastic->search((string)($id), array('id'));
        // /* UPDATE */
        // // $res = $elastic->update(array('sku' => 'EXA2VB'), array('name' => 'Golden Faux Pearl Embellished Through Hook Earrings Test'));

        // /* DELETE */
        // // $res = $elastic->delete(array('sku' => 'EXA2VB'));
        echo '<pre>';
        print_r($res);
        exit;
    }

    //es 删除缓存
    public function action_delete()
    {
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $sku = Arr::get($_GET, 'sku', '');
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        $array = array(
            'sku'=>$sku,
        );
        $res = $elastic->delete($array);
        print_r($res);
        die;
    }

    //es 删除所有缓存
    public function action_deleteall()
    {
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        $res = $elastic->delete_all();
    }

    //google翻译
    public function action_productInfoTrans()
    {
        set_time_limit(0);

        $token = Arr::get($_GET, 'token', '');
        $lang = Arr::get($_GET, 'lang', '');
        $limit = Arr::get($_GET, 'limit', '');
        $localtoken = 'jwinfuture';
        if($token != $localtoken)
        {
            die('error');
        }
        if(!in_array($lang,['es','de','fr']))
        {
            die('error');
        }
        $table = 'products_trans_'.$lang;
        if($limit == 11)
        {
            $products = DB::select()->from('products_product')
                ->where('visibility','=','1')
                ->where('status','=','1')
                ->limit(20)
                ->execute('slave')
                ->as_array();
        }elseif($limit == 10){
            $products = DB::select()->from('products_product')
                ->where('visibility','=','1')
                ->where('status','=','1')
                ->execute('slave')
                ->as_array();
        }else{
            die;
        }

        echo count($products).'<br>';
        $trans = DB::select()->from($table)->execute('slave')->as_array();
        $check = array();
        foreach ($trans as $tran)
        {
            $check[] = $tran['product_id'];
        }
        $n = 0;
        $m = 0;
        $back = array();
        foreach ($products as $product)
        {
            $strs['name'] = $product['name'];
            $strs['description'] = $product['description'];
            $strs['brief'] = $product['brief'];
            foreach ($strs as $key => $str)
            {
                $str = strip_tags($str);
                $str = str_replace("\\",'',$str);
                $res = Site::googletransapi($blank='en',$target=$lang,$str);
                if($res != 1) {
                    $words1 = json_decode($res);
                    $data[$key] = $words1->data->translations[0]->translatedText;
                }else{
                    $back[$product['id']][] = $key;
                }
            }

            if(isset($data) and !empty($data))
            {
                $data['product_id'] = $product['id'];
                if(in_array($product['id'],$check))
                {
                    $m++;
                    DB::update($table)->where('product_id','=',$product['id'])->set($data)->execute();
                }else{
                    $n ++;
                    DB::insert($table,array_keys($data))->values($data)->execute();
                }
            }

        }

        echo 'success';
        echo '<br>';
        echo 'insert:'.$n;
        echo '<br>';
        echo 'update:'.$m;
        echo '<pre>';
        print_r($back);
        exit;
    
    }

    //后台调用 删除产品缓存，访问产品页时，重新生成缓存
    public function action_delete_product_cache()
    {

        $id = $_REQUEST['id'];
        if(!$id)
            return false;
        $cache = Cache::instance('memcache');
        $langs = array( 'de', 'es', 'fr', '');
        foreach ($langs as $lang)
        {
            $key = '/productcache/'.$id.'/'.$lang;
            $cache->delete($key);
        }

        die;
    }

    //后台调用 删除汇率缓存，前台加载时，重新生成缓存
    public function action_delete_currencies_cache()
    {

        $cache = Cache::instance('memcache');
        $countries = DB::select('name')->from('core_currencies')->execute()->as_array();
        foreach ($countries as $country)
        {
            $key = 'site_currency11_'.$country['name'];
            $cache->delete($key);
        }
    }

    //支付-->风控，发送失败后，调用此接口，尝试发送
    public function action_manage()
    {
        $local_directory = '/home/choies/project/www.choies.com/fengkong';
        $filesnames = scandir($local_directory);

        foreach ($filesnames as $name)
        {
            $file = $local_directory.$name;
            $fp = fopen($file,"r");
            $handle = fread($fp,filesize($file));//指定读取大小，这里把整个文件内容读取出来
            $str = str_replace("\r\n","<br />",$handle);
            fclose($fp);
            $result = Toolkit::curl_pay_fk('local.manage.com/pp', $str);
            if($result)
            {
                unlink($file);
            }
        }
        exit();
    }

    //memcache 产品数据缓存展示
    public function action_product_memcache_show()
   {
       $id = $_REQUEST['id'];
       if(!$id)
           return false;
       $cache = Cache::instance('memcache');

       $key = 'productcache/'.$id;
       $data = $cache->get($key);
       echo '<pre>';
       var_dump($data);
       die;
   }

    //memcache 更新产品缓存
    public function action_update_product_memcache()
    {
        $products = DB::select('id')->from('products_product')
            ->where('visibility','=','1')
            ->where('status','=','1')
            ->execute('slave')
            ->as_array();

        $cache = Cache::instance('memcache');
        $langs = array( 'de', 'es', 'fr', '');
        foreach ($products as $product)
        {
            foreach ($langs as $lang)
            {
                $key = 'productcache/'.$product['id'].'/'.$lang;
                $cache->delete($key);
            }

        }
    }

    //导出产品图片 根目录放置sku.csv文件,sku可以为两列，erp的model,choies的sku，分生成文件使用第一列，即erp的model
    public function action_productImages()
    {
        $skus =  file_get_contents('sku.csv');
        $skus = explode(PHP_EOL,$skus);
        foreach ($skus as $sku)
        {
            $sku = trim($sku,',');
            $data[] = explode(',',$sku);
        }

        $links = fopen('links.csv','w+');
        $return = array();
        foreach ($data as $value)
        {

            $product = DB::select()->from('products_product')
                ->where('sku','=',$value[0])
                ->execute('slave')
                ->current();
            if(!$product and isset($value[1]))
            {
                $product = DB::select()->from('products_product')
                    ->where('sku','=',$value[1])
                    ->execute('slave')
                    ->current();
            }
            if(!$product)
            {
                $return[] = $value;
                continue;
            }

            $images = Product::instance($product['id'])->images();
            $str = $value[0].',';
            foreach ($images as $image)
            {
                $str .= Image::link($image,9).',';
            }

            fwrite($links, $str . PHP_EOL);
        }
        fclose($links);
        exit;
    }

    public function action_email()
    {
        $mail = Arr::get($_GET,'emial','');
        # 用户注册
        if(!$mail)
        {
            $customers = DB::query('select',"SELECT
                    a.email,a.firstname,c.`code`,c.expired
                FROM
                    `accounts_customers` a
                LEFT JOIN
                carts_customercoupons  p ON a.id=p.customer_id
                RIGHT JOIN carts_coupons c on p.coupon_id=c.id
                WHERE
                    a.created > 1492185600
                AND a.lang = ''")->execute('slave')->as_array();
            foreach ($customers as $customer)
            {
                $mail_params['coupon_code'] = $customer['code'];
                $mail_params['expired'] = date('Y-m-d H:i', $customer['expired']);
//                $mail_params['password'] = $customer['password'];
                $mail_params['email'] = $customer['email'];
                $mail_params['firstname'] = $customer['firstname'];
                Mail::SendTemplateMail('NEWREGISTER', $mail_params['email'], $mail_params);
            }
        }else{
            $customer = DB::query('select',"SELECT
                    a.email,a.firstname,c.`code`,c.expired
                FROM
                    `accounts_customers` a
                LEFT JOIN
                carts_customercoupons  p ON a.id=p.customer_id
                RIGHT JOIN carts_coupons c on p.coupon_id=c.id
                WHERE
                  a.email = '3543886570@qq.com'
                AND 
                    a.created > 1492185600
                AND a.lang = ''")->execute('slave')->as_array();

                $mail_params['coupon_code'] = $customer['code'];
                $mail_params['expired'] = date('Y-m-d H:i', $customer['expired']);
//                $mail_params['password'] = $customer['password'];
                $mail_params['email'] = $customer['email'];
                $mail_params['firstname'] = $customer['firstname'];
                Mail::SendTemplateMail('NEWREGISTER', $mail_params['email'], $mail_params);

        }


    }

    public function action_email1()
    {
        $shipping = Arr::get($_GET,'shipping','');
        if(!$shipping)
        {
            exit;
        }
        if($shipping == 1)
        {
            $str = 'shipped';
            $email_type  = 'SHIPPING';
        }elseif ($shipping == 2)
        {
            $str = 'partial_shipped';
            $email_type = 'PARTIALSHIPPING';
        }else{
            die;
        }
        $datas = DB::query('select',"SELECT
            o.ordernum,
            o.shipping_status,
            o.amount,
            o.email,
            o.shipping_firstname,
            s.tracking_code,
            s.tracking_link
        FROM
            `orders_order` o
        LEFT JOIN orders_ordershipments s ON o.id = s.order_id
        WHERE
            shipping_date > 1492185600
        AND shipping_status = ".$str)->execute('slave')->as_array();

        foreach ($datas as $data)
        {
            $email_params = array(
                'tracking_num' => $data['tracking_code'],
                'tracking_url' => $data['tracking_link'],
                'order_num' => $data['ordernum'],
                'currency' => $data['currency'],
                'amount' => $data['amount'],
                'email' => $data['email'],
                'firstname' => $data['shipping_firstname'],
                'tracking_words' => '',
            );
            Mail::SendTemplateMail($email_type, $email_params['email'], $email_params);
        }
        die;
    }


    public function action_test()
   {


       exit;
   }



}

