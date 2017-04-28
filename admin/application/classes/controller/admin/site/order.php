<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Order extends Controller_Admin_Site
{

    public static $upload_dir;

    private function construct()
    {
        $id = $this->request->param('id');
        $order = Order::instance($id)->get();
        if (!$order)
        {
            message::set(__('订单不存在'), 'error');
            Request::instance()->redirect('/admin/site/order/list');
        }
        return $order;
    }

    public function action_list()
    {
        /*
          $orders = DB::select('id')->from('orders_order')->where('payment_status', '=', 'verify_pass')->and_where('verify_date', '=', Null)->execute('slave')->as_array();
          if (!empty($orders))
          {
          foreach ($orders as $order_id)
          {
          $verify_date = DB::select('created')->from('orders_orderpayments')->where('order_id', '=', $order_id['id'])->and_where('payment_status', '=', 'verify_pass')->execute('slave')->current();
          if ($verify_date)
          {
          DB::query(Database::UPDATE, 'UPDATE orders SET verify_date = ' . $verify_date['created'] . ' WHERE id = ' . $order_id['id'])->execute();
          }
          else
          {
          DB::query(Database::UPDATE, 'UPDATE orders SET verify_date = created WHERE id = ' . $order_id['id'] . ' AND amount_payment = 0')->execute();
          }
          }
          }
         */

//                DB::query(Database::DELETE, 'DELETE FROM orders WHERE email IS NULL AND currency IS NULL')->execute();

        $mail_types = DB::select('name')
            ->from('mail_types')
            ->where('site_id', '=', $this->site_id)
            ->execute('slave');

        $manual_types = Kohana::config('manualmail.type');
        foreach ($mail_types as $type)
        {
            if ($type['name'] == 'NOBUY_MAIL')
                continue;
            if (in_array($type['name'], $manual_types))
                $mail_type[$type['name']] = $type['name'];
        }
        if (empty($mail_type))
        {
            $mail_type['null'] = "未设置任何邮件";
        }


        

        // Order statistics for last week
        $last_week = strtotime('midnight') - 604800 + 86400;
        $dates = array();
        for ($i = 0; $i < 7; $i++)
        {
            $midnight = $last_week + $i * 86400;
            $dates[] = date('Y-m-d', $midnight);
        }

        $cache = Cache::instance('memcache');
        $key = "admin_order_statistics12";
        if( ! ($order_statistics = $cache->get($key)))
        {
            $order_statistics = array(
                'celebrity' => array(),
                'usual' => array()
            );
            
            for ($i = 0; $i < 7; $i++)
            {
                $midnight = $last_week + $i * 86400;
                $next_day = $midnight + 86400;
                $keycount = "admin_order_count".$next_day;
                if( ! ($order_count = $cache->get($keycount)))
                {
                $order_count = DB::select(DB::expr('COUNT(*) AS order_count'))
                    ->from('orders_order')
                    ->where('is_active', '=', 1)
                    ->where('products', '<>', 'PMproducts')
                    ->where('payment_status', 'IN', array('success', 'verify_pass'))
                    ->where('created', '>=', $midnight)
                    ->where('created', '<', $next_day)
                    ->execute('slave')
                    ->get('order_count');
                    
                     $cache->set($keycount, $order_count, 600);
                }
                $order_celebrity = DB::query(Database::SELECT, 'SELECT COUNT(orders.id) AS count FROM `orders_order`,celebrits 
                                            WHERE orders.customer_id = celebrits.customer_id AND orders.is_active = 1 AND orders.products <> "PMproducts" 
                                            AND orders.payment_status IN("success","verify_pass") 
                                            AND orders.created >= ' . $midnight . ' AND orders.created < ' . $next_day)
                        ->execute('slave')->get('count');

                //手机订单数量统计
                $order_mobile = DB::query(Database::SELECT, 'SELECT COUNT(id) AS count FROM `orders_order`
                                            WHERE erp_fee_line_id=1 AND is_active = 1 AND products <> "PMproducts"
                                            AND payment_status IN("success","verify_pass")
                                            AND created >= ' . $midnight . ' AND created < ' . $next_day)
                    ->execute('slave')->get('count'); 
                
                $order_statistics['celebrity'][date('Y-m-d', $midnight)] = $order_celebrity;
                $order_statistics['usual'][date('Y-m-d', $midnight)] = $order_count - $order_celebrity;
                $order_statistics['mobile'][date('Y-m-d', $midnight)] = $order_mobile;
                $order_statistics['pc'][date('Y-m-d', $midnight)] = $order_count - $order_mobile;
            }

            $cache->set($key, $order_statistics, 600);
        }

        $content = View::factory('admin/site/order/list')
            ->set('mail_type', $mail_type)
            ->set('order_statistics', $order_statistics)
            ->set('dates', $dates)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_paydown()
    {
        if (!$_POST)
        {
            die('invalid request');
        }
        $date = strtotime(Arr::get($_POST, 'date', 0));
        if(empty($date)){
            message::set('请输入开始日期','notice');
            Request::instance()->redirect('/admin/site/order/effect');
          
        }
//                $date += 28800; /* 8 hours */     
        // 添加更新结束时间
        $date_end = Arr::get($_POST, 'date_end', 0);
        if ($date_end)
        {
            $file_name = "order-pay-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
            $date_end = strtotime($date_end);
//          $date_end += 28800;
        }
        else
        {
            $file_name = "orders-pay-" . date('Y-m-d', $date) . ".csv";
            $date_end = $date + 86400;
        }

        error_reporting(E_ALL);
        header("Content-type:application/vnd.ms-excel; charset=UTF-8");
        header('Content-Disposition: attachment; filename="' . $file_name . '"');

        echo "\xEF\xBB\xBF" . "订单总数,验证通过订单,暂未验证通过,白单,失败单,取消单\n";
        $conditions = array(
            "site_id=" . Site::instance()->get('id'),
            "created >= $date",
            "created < $date_end",
        );
        $arr = array(0=>array(),1=>array());
        $where_clause = implode(' AND ', $conditions);
        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
      
        $count = $result[0]['num'];
        array_push($arr[0],$count);
        array_push($arr[1],'100%');

        $result1 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND payment_status = "verify_pass" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count1 = $result1[0]['num'];
        $c1 = round($count1/$count * 100,2);
        array_push($arr[0],$count1);
        array_push($arr[1],$c1.'%');

        $result2 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND payment_status in ("pending","partial_paid","success") AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count2 = $result2[0]['num'];
        $c2 = round($count2/$count * 100,2);
        array_push($arr[0],$count2);
        array_push($arr[1],$c2.'%');

        $result3 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND payment_status = "new" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count3 = $result3[0]['num'];
        $c3 = round($count3/$count * 100,2);
        array_push($arr[0],$count3);
        array_push($arr[1],$c3.'%');

        $result4 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND payment_status = "failed" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count4 = $result4[0]['num'];
        $c4 = round($count4/$count * 100,2);
        array_push($arr[0],$count4);
        array_push($arr[1],$c4.'%');

        $result5 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND payment_status = "cancel" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count5 = $result5[0]['num'];
        $c5 = round($count5/$count * 100,2);
        array_push($arr[0],$count5);
        array_push($arr[1],$c5.'%');
        foreach($arr as $v){
            echo $v[0] . ',';
            echo $v[1] . ',';
            echo $v[2] . ',';
            echo $v[3] . ',';
            echo $v[4] . ',';
            echo $v[5] . ',';
            echo "\n";
        }
    }

    public function action_verifydown()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $date = strtotime(Arr::get($_POST, 'date', 0));
        if(empty($date)){
            message::set('请输入开始日期','notice');
            Request::instance()->redirect('/admin/site/order/effect');
          
        }
 
        // 添加更新结束时间
        $date_end = Arr::get($_POST, 'date_end', 0);
        if ($date_end)
        {
            $file_name = "order-verify-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
            $date_end = strtotime($date_end);
        }
        else
        {
            $file_name = "orders-verify-" . date('Y-m-d', $date) . ".csv";
            $date_end = $date + 86400;
        }

        error_reporting(E_ALL);
        header("Content-type:application/vnd.ms-excel; charset=UTF-8");
        header('Content-Disposition: attachment; filename="' . $file_name . '"');

        echo "\xEF\xBB\xBF" . "订单总数,未处理,处理中,部分发货,已发货,妥投,到达待取\n";
        $conditions = array(
            "site_id=" . Site::instance()->get('id'),
            "created >= $date",
            "created < $date_end",
            "payment_status = 'verify_pass'"
        );
        $arr = array(0=>array(),1=>array());
        $where_clause = implode(' AND ', $conditions);
        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1  AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
      
        $count = $result[0]['num'];
        array_push($arr[0],$count);
        array_push($arr[1],'100%');

        $result1 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND shipping_status = "new_s" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count1 = $result1[0]['num'];
        $c1 = round($count1/$count * 100,2);
        array_push($arr[0],$count1);
        array_push($arr[1],$c1.'%');

        $result2 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND shipping_status ="processing" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count2 = $result2[0]['num'];
        $c2 = round($count2/$count * 100,2);
        array_push($arr[0],$count2);
        array_push($arr[1],$c2.'%');

        $result3 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND shipping_status = "partial_shipped" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count3 = $result3[0]['num'];
        $c3 = round($count3/$count * 100,2);
        array_push($arr[0],$count3);
        array_push($arr[1],$c3.'%');

        $result4 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND shipping_status = "shipped" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count4 = $result4[0]['num'];
        $c4 = round($count4/$count * 100,2);
        array_push($arr[0],$count4);
        array_push($arr[1],$c4.'%');

        $result5 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND shipping_status = "delivered" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count5 = $result5[0]['num'];
        $c5 = round($count5/$count * 100,2);
        array_push($arr[0],$count5);
        array_push($arr[1],$c5.'%');

        $result6 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND shipping_status = "pickup" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count6 = $result6[0]['num'];
        $c6 = round($count6/$count * 100,2);
        array_push($arr[0],$count6);
        array_push($arr[1],$c6.'%');
        foreach($arr as $v){
            echo $v[0] . ',';
            echo $v[1] . ',';
            echo $v[2] . ',';
            echo $v[3] . ',';
            echo $v[4] . ',';
            echo $v[5] . ',';
            echo $v[6] . ',';
            echo "\n";
        }

    }

    public static function verifydowngo()
    {
        $t = time();
        $t1 = time()-7776000;
        $conditions = array(
            "site_id=" . Site::instance()->get('id'),
            "created >= $t1",
            "created < $t",
            "payment_status = 'verify_pass'"
        );
        $arr = array(0=>array(),1=>array());
        $where_clause = implode(' AND ', $conditions);
        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1  AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');

      
        $count = $result[0]['num'];
        array_push($arr[0],$count);
        array_push($arr[1],'100%');

        $result1 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND shipping_status = "new_s" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count1 = $result1[0]['num'];
        $c1 = round($count1/$count * 100,2);
        array_push($arr[0],$count1);
        array_push($arr[1],$c1.'%');

        $result2 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND shipping_status ="processing" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count2 = $result2[0]['num'];
        $c2 = round($count2/$count * 100,2);
        array_push($arr[0],$count2);
        array_push($arr[1],$c2.'%');

        $result3 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND shipping_status = "partial_shipped" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count3 = $result3[0]['num'];
        $c3 = round($count3/$count * 100,2);
        array_push($arr[0],$count3);
        array_push($arr[1],$c3.'%');

        $result4 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND shipping_status = "shipped" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count4 = $result4[0]['num'];
        $c4 = round($count4/$count * 100,2);
        array_push($arr[0],$count4);
        array_push($arr[1],$c4.'%');

        $result5 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND shipping_status = "delivered" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count5 = $result5[0]['num'];
        $c5 = round($count5/$count * 100,2);
        array_push($arr[0],$count5);
        array_push($arr[1],$c5.'%');

        $result6 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND shipping_status = "pickup" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count6 = $result6[0]['num'];
        $c6 = round($count6/$count * 100,2);
        array_push($arr[0],$count6);
        array_push($arr[1],$c6.'%');
        return $arr;

    }

    public function action_effectdown()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $date = strtotime(Arr::get($_POST, 'date', 0));
        if(empty($date)){
            message::set('请输入开始日期','notice');
            Request::instance()->redirect('/admin/site/order/effect');
          
        }
 
        // 添加更新结束时间
        $date_end = Arr::get($_POST, 'date_end', 0);
        if ($date_end)
        {
            $file_name = "order-verify-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
            $date_end = strtotime($date_end);
        }
        else
        {
            $file_name = "orders-verify-" . date('Y-m-d', $date) . ".csv";
            $date_end = $date + 86400;
        }

        error_reporting(E_ALL);
        header("Content-type:application/vnd.ms-excel; charset=UTF-8");
        header('Content-Disposition: attachment; filename="' . $file_name . '"');

        echo "\xEF\xBB\xBF" . "物流方式/国家,EMS,DHL,SDHL,HKPT,SF,MU,EUB,DGM,SGB,CRI,NXB\n";
        $brr = array();
        $countryarr = array('US','GB','CA','FR','ES','AU','HK','DE','RU','PL','TW','MX','IT','SE','BR','DK','CL','NL','CZ','NO');
        for($a = 0 ;$a<19;$a++){
            $ace = $countryarr[$a];
            $brr[$ace] =  self::geteffect($date,$date_end,$a);

        }

        foreach($brr as $k=>$v){
            echo $k . ',';
            echo $v[0] . ',';
            echo $v[1] . ',';
            echo $v[2] . ',';
            echo $v[3] . ',';
            echo $v[4] . ',';
            echo $v[5] . ',';
            echo $v[6] . ',';
            echo $v[7] . ',';
            echo $v[8] . ',';
            echo $v[9] . ',';
            echo $v[10] . ',';
            echo "\n";
        }  

    }

    public static function geteffect($date,$date_end,$a)
    {
        $carrierarr = array('EMS','DHL','SDHL','HKPT','SF','MU','EUB','DGM','SGB','CRI','NXB');
        $countryarr = array('US','GB','CA','FR','ES','AU','HK','DE','RU','PL','TW','MX','IT','SE','BR','DK','CL','NL','CZ','NO');
        $conditions = array(
            "o.created >= $date",
            "o.created < $date_end",
        );
        $arr = array();
        $where_clause = implode(' AND ', $conditions);
        $i = 0;
        foreach($carrierarr as $k=>$v){        
            if($i<19){
            $filter = ' o.shipping_country = "' . $countryarr[$a] . '" AND os.carrier = "' . $v .'"';

        $result1 = DB::query(DATABASE::SELECT, 'SELECT o.id,AVG(o.logistics_days) as av FROM `orders_order` o INNER JOIN order_shipments os ON o.id = os.order_id WHERE  o.logistics_days>0  AND o.shipping_status = "delivered"  AND ' . $filter . ' and ' . $where_clause)->execute('slave')->as_array();

        $aver = round($result1[0]['av']);

        if($result1[0]['id']){      
             array_push($arr,$aver);  
        }else{
            $aver = '无';
            array_push($arr,$aver);

                }

             }
             $i++;
            
           }

           return $arr;     

    }


    public static function geteffect1($a)
    {
        $carrierarr = array('EMS','DHL','SDHL','HKPT','SF','MU','EUB','DGM','SGB','CRI','NXB');
        $countryarr = array('US','GB','CA','FR','ES','AU','HK','DE','RU','PL','TW','MX','IT','SE','BR','DK','CL','NL','CZ','NO');
        $t = time();
        $t1 = time()-7776000;
        $conditions = array(
            "o.created >= $t1",
            "o.created < $t",
        );
        $arr = array();
        $where_clause = implode(' AND ', $conditions);
        $i = 0;
        foreach($carrierarr as $k=>$v){        
            if($i<19){
            $filter = ' o.shipping_country = "' . $countryarr[$a] . '" AND os.carrier = "' . $v .'"';

        $result1 = DB::query(DATABASE::SELECT, 'SELECT o.id,AVG(o.logistics_days) as av FROM `orders_order` o INNER JOIN order_shipments os ON o.id = os.order_id WHERE  o.logistics_days>0  AND o.shipping_status = "delivered"  AND ' . $filter . ' and ' . $where_clause)->execute('slave')->as_array();

        $aver = round($result1[0]['av']);

        if($result1[0]['id']){      
             array_push($arr,$aver);  
        }else{
            $aver = ' ';
            array_push($arr,$aver);

                }

             }
             $i++;
            
           }

           return $arr;

    }

    public function action_effect()
    {
       $mail_types = DB::select('name')
            ->from('mail_types')
            ->where('site_id', '=', $this->site_id)
            ->execute('slave');

        $manual_types = Kohana::config('manualmail.type');
        foreach ($mail_types as $type)
        {
            if ($type['name'] == 'NOBUY_MAIL')
                continue;
            if (in_array($type['name'], $manual_types))
                $mail_type[$type['name']] = $type['name'];
        }
        if (empty($mail_type))
        {
            $mail_type['null'] = "未设置任何邮件";
        }

        // Order statistics for last week
        $order_statistics = array(
            'celebrity' => array(),
            'usual' => array()
        );
        $dates = array();

        $arr = array();
        $countryarr = array('US','GB','CA','FR','ES','AU','HK','DE','RU','PL','TW','MX','IT','SE','BR','DK','CL','NL','CZ','NO');
        for($a = 0 ;$a<19;$a++){
            $ace = $countryarr[$a];
            $arr[$ace] =  self::geteffect1($a);

        }

        $brr = self::paydowngo();
        $crr = self::verifydowngo();
        $dates1 = array('EMS','DHL','SDHL','HKPT','SF','MU','EUB','DGM','SGB','CRI','NXB');
        $content = View::factory('admin/site/order/effect_list')
            ->set('mail_type', $mail_type)
            ->set('order_statistics', $order_statistics)
            ->set('dates', $dates)
            ->set('dates1', $dates1)
            ->set('arr', $arr)
            ->set('brr', $brr)
            ->set('crr', $crr)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();


    }

    public static function paydowngo()
    {
        $t = time();
        $t1 = time()-7776000;
        $conditions = array(
            "site_id=" . Site::instance()->get('id'),
            "created >= $t1",
            "created < $t",
        );
        $arr = array(0=>array(),1=>array());
        $where_clause = implode(' AND ', $conditions);
        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
      
        $count = $result[0]['num'];
        array_push($arr[0],$count);
        array_push($arr[1],'100%');

        $result1 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND payment_status = "verify_pass" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count1 = $result1[0]['num'];
        $c1 = round($count1/$count * 100,2);
        array_push($arr[0],$count1);
        array_push($arr[1],$c1.'%');

        $result2 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND payment_status in ("pending","partial_paid","success") AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count2 = $result2[0]['num'];
        $c2 = round($count2/$count * 100,2);
        array_push($arr[0],$count2);
        array_push($arr[1],$c2.'%');

        $result3 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND payment_status = "new" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count3 = $result3[0]['num'];
        $c3 = round($count3/$count * 100,2);
        array_push($arr[0],$count3);
        array_push($arr[1],$c3.'%');

        $result4 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND payment_status = "failed" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count4 = $result4[0]['num'];
        $c4 = round($count4/$count * 100,2);
        array_push($arr[0],$count4);
        array_push($arr[1],$c4.'%');

        $result5 = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND payment_status = "cancel" AND `email` IS NOT NULL AND ' . $where_clause)->execute('slave');
        $count5 = $result5[0]['num'];
        $c5 = round($count5/$count * 100,2);
        array_push($arr[0],$count5);
        array_push($arr[1],$c5.'%');
        return $arr;

    }
	
/*	public function action_everyfiverun(){
		$result = DB::query(Database::SELECT, "SELECT o.customer_id, count( o.customer_id ) AS con, c.firstname, c.email, o.currency
FROM orders o
LEFT JOIN customers c ON o.customer_id = c.id
WHERE `shipping_status` = 'delivered'
GROUP BY o.customer_id")
                    ->execute('slave');	
	
		foreach($result as $k=>$v){
			if($v['con'] == 3){
				$arr[$k]=$v;
			}
		}
					
		foreach($arr as $k=>$v){
			 $email_params = array(
                        'currency' => $v['currency'],
                        'email' => $v['email'],
                        'firstname' => $v['firstname'],
                    );
		Mail::SendTemplateMail('QUESTIONSURVEY', $email_params['email'], $email_params);
			
		}	
		
	}	*/

    public function action_baodeng()
    {
        $order_id = Arr::get($_POST, 'order_id', 0);
        $items = Arr::get($_POST, 'items', 0);
        $days = Arr::get($_POST, 'days', 0);
        if(!$days){
            $data['success'] = 0;
            $data['message'] = 'Failed!';
            echo json_encode($data);
            die;
        }
        //$items,$order_id,$days
        api::send_wait_email($items,$order_id,$days);
        
       //  $itemarr = explode(',',$items);
       //  $order = Order::instance($order_id);
       //  unset($itemarr[0]);
       //  $item = '';
       //  foreach($itemarr as $k=>$v){
       //      $result = $order->get_item($v);
       //      $item .= $result['name'] .' '.$result['attributes'] .' '. $result['sku'] .' '. round($result['price'],2) .'   '.$result['quantity'];
       //  }

        
       //  $data['email'] = $order->get('email');
       //  $firstname = $order->get('shipping_firstname');  
       //       $email_params = array(
       //                  'firstname' => $firstname,
       //                  'email' => $data['email'],
       //                  'order_num' => $order->get('ordernum'),
       //                  'waiting' =>$days,
       //                  'item' =>$item
       //              );

       //  $comment = '发送报等邮件,报等天数：'.$days.'天';
       //  $order->add_history(array(
       //      'order_status' => 'send baodeng',
       //      'message' => $comment,
       //  ));

       // Mail::SendTemplateMail('NEWSPAPER', $email_params['email'], $email_params);
        $data['success'] = 1;
       $data['message'] = 'success!';
                        echo json_encode($data);
                        die;
    }

    public function action_getdownrun(){
        error_reporting(E_ALL);
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=customers.csv');  
        echo "\xEF\xBB\xBF" . "Email,Firstname,Lastname,country,is_facebook\n";  
        $result = DB::query(Database::SELECT, "SELECT o.customer_id, count( o.customer_id ) AS con, c.firstname,c.lastname, c.email,c.is_facebook,o.shipping_country FROM orders o LEFT JOIN customers c ON o.customer_id = c.id WHERE o.amount >0 GROUP BY o.customer_id")->execute('slave'); 
    
        foreach($result as $k=>$v){
            if($v['con'] == 1){
                $arr[$k]=$v;
            }
        }
                    
        foreach($arr as $k=>$v){
            echo $v['email']. ',';
            echo $v['firstname']. ',';
            echo $v['lastname']. ',';
            echo $v['shipping_country']. ',';
            echo $v['is_facebook']. ',';
            echo "\n";         
        }   
        
    }   

    public function action_getdownrun1(){
        error_reporting(E_ALL);
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=customers.csv');  
        echo "\xEF\xBB\xBF" . "Email,Firstname,Lastname,is_facebook\n";  
        $result = DB::query(Database::SELECT, "SELECT o.customer_id, count( o.customer_id ) AS con, c.firstname,c.lastname, c.email,c.is_facebook,o.shipping_country FROM orders o LEFT JOIN customers c ON o.customer_id = c.id WHERE o.amount >0 GROUP BY o.customer_id")->execute('slave'); 
    
        foreach($result as $k=>$v){
            if($v['con'] > 1){
                $arr[$k]=$v;
            }
        }
                    
        foreach($arr as $k=>$v){
            echo $v['email']. ',';
            echo $v['firstname']. ',';
            echo $v['lastname']. ',';
            echo $v['shipping_country']. ',';
            echo $v['is_facebook']. ',';
            echo "\n";
        
            
        }   
        
    }   

	public function action_tesmail(){
		
		                            $email_params = array(
                                'tracking_num' => 112,
                                'tracking_url' => 'www.qq.com',
                                'order_num' => 'o123',
                                'currency' => 'usd',
                                'amount' => 99,
                                'email' => 'xiaojiaphp@163.com',
                                'firstname' => 'guojia',
                                'tracking_words' => '123',
                            );
                            Mail::SendTemplateMail('QUESTIONSURVEY', $email_params['email'], $email_params);
	}
	
	public function action_daochutotal(){
		$file_name = 'tops.csv';
          header("Content-type:application/vnd.ms-excel; charset=UTF-8");
          header('Content-Disposition: attachment; filename="' . $file_name . '"');
          echo "\xEF\xBB\xBF" . "sku,price,ordernum\n";
		$midnight = strtotime("2015-04-01 00:00:00");
		$next_day = strtotime("2015-04-06 23:59:59");
		$orders = DB::query(Database::SELECT, 'SELECT p.sku,oi.price,o.ordernum  FROM products p left join order_items oi on p.id = oi.product_id left join orders o on o.id = oi.order_id WHERE o.payment_date>0 and p.set_id in (14,8,15,7,11,16,280,9,375,31) AND o.created >= ' . $midnight . ' AND o.created < ' . $next_day)->execute('slave');
		foreach($orders as $v){
			echo $v['sku'] . ',';
			echo $v['price'] . ',';
			echo $v['ordernum'] . ',';
			echo "\n";
		}	
	}

    public function action_select_info_by_oids()
    {
            $oids = Arr::get($_POST, 'ORDERIDS', '');
            if (!$oids)
            {
                echo 'Sku cannot be empty';
                exit;
            }
            else
            {
                echo '<table cellspacing="1" cellpadding="5" border="0">';
                echo '<tr><td width="100px">order_id</td><td width="100px">交易号</td><td width="100px">币种</td><td width="100px">金额</td><td width="100px">支付时间</td></tr>';
                $oidArr = explode("\n", $oids);
                foreach ($oidArr as $oid)
                {
                    $oid = trim($oid);
                    $info = DB::query(DATABASE::SELECT,"SELECT `trans_id`,`currency`,`amount`,`created` FROM `orders_orderpayments` WHERE payment_status='success' AND order_id='".$oid."' limit 1")
                        ->execute('slave');
                    $trans_id = isset($info[0]['trans_id'])?$info[0]['trans_id']:"null";
                    $trans_id = $trans_id.',';
                    $currency = isset($info[0]['currency'])?$info[0]['currency']:"null";
                    $amount = isset($info[0]['amount'])?$info[0]['amount']:"null";
                    $created = isset($info[0]['created'])?date('Y-m-d H:i:s',$info[0]['created']):"null";
                    echo '<tr><td>' . $oid. '</td><td>' .$trans_id. '</td><td>' .$currency. '</td><td>' .$amount. '</td><td>' .$created. '</td></tr>';
                }
                echo '</table>';
            }
    }
	
    public function action_copy()
    {
          

       $arr = Arr::get($_REQUEST, 'arr', 0);
	   /* not has order_from */
       $seval = $arr[0]['seval'];
       if(empty($seval)){
        echo json_encode(0);
		die;
       }
	   
        $id = $arr[0]['id'];
         $order = Order::instance($id);
         $order_data = $order->basic();
           $products = $order->products();
		   $p_arr = array();
           foreach($products as $k=>$v){
                $p_arr[$k]['product_id'] = $v['product_id'];
           }
		 
		   if(empty($p_arr)){
			   echo json_encode(-2);
				die;
		   }
			$count = count($p_arr);
		   /** if has status = 0 or visibility = 0*/
		   $arrid = array();
           foreach($p_arr as $v){
            $pro = Product::instance($v['product_id']);
			$i = 0;
             if((!$pro->get('status')) || !$pro->get('visibility')){  
				
				array_push($arrid,$v['product_id']);
				$i++;
			
             }
           }

		   if($i == $count){
			   
			   echo json_encode(-1);
			   die;
		   }
		   
		   
		   $order_data['ordernum'] = $order_data['ordernum'].'c'.$order_data['id'];
		   $order_data['created'] = time();
		   $order_data['updated'] = time();
		   $order_data['points'] = 0;
		   $order_data['payment_status'] = 'new';
		   $order_data['shipping_status'] = 'new_s';
		   $order_data['erp_header_id'] = 0;
		   $order_data['erp_customer_id'] = 0;
		   $order_data['erp_customer_id'] = 0;
		   $order_data['order_from'] = $seval;
		   $order_data['ip'] = '0';
		   
			//add remark
            $remark['site_id'] = $this->site_id;
            $remark['order_id'] = $id;
            $remark['remark'] = 'copy order';		   
		   $order->add_remark($remark);
		   unset($order_data['id']);
		   $result = DB::insert('orders_order', array_keys($order_data))->values($order_data)->execute();
			if($result){
				$data['res'] = $result[0];
                $data2 =DB::query(Database::SELECT, 'SELECT * FROM order_items WHERE site_id=' . $this->site_id .' and order_id = ' .$id)->execute('slave')->as_array();
            foreach($data2 as $v){
                $arr = $v;
                $arr['order_id'] = $data['res'];
                unset($arr['id']);
              $in = DB::insert('order_items', array_keys($arr))->values($arr)->execute();  
            }

				$data['a'] = 1;
				$data['arrid'] = $arrid;
				echo json_encode($data);
				
			}else{
				echo  00000001;
			}
    }
	

    public function action_edit()
    {
        $id = (int) $this->request->param('id');
        View::set_global('id', $id);
        $order_status = Kohana::config('order_status');

        $order = Order::instance($id);
        $order_data = $order->basic();
        $a = $order->havecopy();
        $order_data['copy'] = $a;
        $product_made = $order->products();

        $custom_made = 0;
        foreach ($product_made as $key => $value)
        {
            $custom_made += $value['custom_made'];
        }
        $order_edit_basic = View::factory('admin/site/order/edit_basic')
            ->set('order', $order_data)
            ->set('customer', Customer::instance($order_data['customer_id'])->get())
            ->set('payment_status', $order_status['payment'])
            ->set('site_id', Site::instance()->get('id'))
            ->set('shipment_status', $order_status['shipment'])
            ->set('custom_made', $custom_made)
            ->render();

        $countries = Site::instance()->countries();
        $countries[] = array('name' => 'MOROCCO', 'isocode' => 'MA');
        $order_edit_address = View::factory('admin/site/order/edit_address')
            ->set('order', $order_data)
            ->set('countries', $countries)
            ->render();

        $order_edit_payment = View::factory('admin/site/order/edit_payment')
            ->set('payment_status', $order_status['payment'])
            ->set('current_status', $order_data['payment_status'] ? $order_status['payment'][$order_data['payment_status']] : NULL)
            ->set('histories', $order->payments())
            ->render();	

				$products = $order->products();
			
			
      //  $products = $order->products();
        foreach ($products as &$product)
        {
            $product['image'] = Admimage::link(Site::instance()->get('id'), Product::instance($product['item_id'])->cover_image(), 99);
        }

        $shipments = $order->shipments($id);
        $shipped_items = array();
        foreach ($shipments as $shipment)
        {
            foreach ($shipment['items'] as $item)
            {
                if (isset($shipped_items[$item['item_id']]))
                {
                    $shipped_items[$item['item_id']] += $item['quantity'];
                }
                else
                {
                    $shipped_items[$item['item_id']] = $item['quantity'];
                }
            }
        }

        $order_edit_shipment = View::factory('admin/site/order/edit_shipment')
            ->set('shipments', $shipments)
            ->set('shipping_method', isset($shipment) ? $shipment['carrier'] : '')
            ->set('products', $products)
            ->set('shipped_items', $shipped_items)
            ->set('order', $order_data)
            ->set('shipment_status', $order_status['shipment'])
            ->set('current_status', $order_data['shipping_status'] ? $order_status['shipment'][$order_data['shipping_status']] : NULL)
            ->render();

        $order_edit_refund = View::factory('admin/site/order/edit_refund')
            ->set('refund_status', $order_status['refund'])
            ->set('current_status', $order_data['refund_status'] ? $order_status['refund'][$order_data['refund_status']] : NULL)
            ->render();

        $order_edit_product = View::factory('admin/site/order/edit_product')
            ->set('products', $products)
            ->set('site_id', $this->site_id)
            ->set('promotions', unserialize($order_data['promotions']))
            ->set('histories', $order->histories())
            ->render();

        $order_edit_remark = View::factory('admin/site/order/edit_remark')
            ->set('remarks', $order->remarks())
            ->set('is_marked', $order_data['is_marked'])
            ->render();

        $order_edit_history = View::factory('admin/site/order/edit_history')
            ->set('histories', $order->histories())
            ->render();

        $content = View::factory('admin/site/order/edit')
            ->set('order_edit_basic', $order_edit_basic)
            ->set('order_edit_address', $order_edit_address)
            ->set('order_edit_payment', $order_edit_payment)
            ->set('order_edit_shipment', $order_edit_shipment)
            ->set('order_edit_refund', $order_edit_refund)
            ->set('order_edit_product', $order_edit_product)
            ->set('order_edit_remark', $order_edit_remark)
            ->set('order_edit_history', $order_edit_history)
            ->set('order', $order_data)
            ->render();

        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
    }

    public function action_customer()
    {
        $data = $this->construct();
        $_url = 'admin/site/order/edit/' . $data['id'];
        if ($_POST)
        {
            $updated = FALSE;
            // validate post data.
            $post = Validate::factory($_POST)
                ->filter(TRUE, 'trim')
                ->filter('customer_id', 'trim')
                ->filter('email', 'trim')
                ->rule('email', 'email');
            if ($post->check())
            {
                $data_ship = array();
                foreach ($post as $key => $value)
                {
                    if (!$value)
                        continue;
                    $data_customer[$key] = $value;
                }
                $updated = Order::instance()->update_customer($data['id'], $data_customer);
            }
            if ($updated)
            {
                message::set(__('Update order customer success.'));
            }
            else
            {
                message::set(__('Update order customer failed.'), 'error');
            }
            $_save = Arr::get($_POST, '_save', '');
            if ($_save)
            {
                $_url = 'admin/site/order/list/';
            }
        }
        $this->request->redirect($_url);
    }

    /**
     * Update order shipping status, tracking link and number.
     */
    public function action_shipment()
    {
        $id = (int) $this->request->param('id');

        $v = Validate::factory($_POST)
            ->filter('shipping_comment', 'trim')
            ->filter('tracking_code', 'trim')
            ->filter('tracking_url', 'trim')
            ->filter('shipping_method', 'trim')
            ->filter('package_id', 'trim')
            ->rule('shipping_items', 'not_empty')
            ->rule('shipping_quantity', 'not_empty')
            //->rule('shipping_status', 'not_empty')
            //->rule('shipping_comment', 'not_empty')
            ->rule('ship_date', 'date')
            //->rule('tracking_code', 'not_empty')
            ->rule('tracking_link', 'url');
        if ($v->check())
        {
            $shipment = array(
                'tracking_code' => $v['tracking_code'],
                'tracking_link' => $v['tracking_link'],
                'ship_date' => strtotime($v['ship_date']),
                'package_id' => $v['package_id'],
            );
            if (!empty($v['shipping_method']))
            {
                $shipment += array(
                    'carrier' => $v['shipping_method'],
                );
            }

            $items = array();
            $order = Order::instance($id);
            foreach ($v['shipping_items'] as $idx => $item_id)
            {
                $item = $order->get_item($item_id);

                $order->ship_item($item_id, $v['shipping_quantity'][$idx]);
                $items[] = array(
                    'item_id' => $item['item_id'],
                    'quantity' => $v['shipping_quantity'][$idx],
                );
            }

            if ($order->add_shipment($shipment, $items))
            {
                $order->set(array(
                    'shipping_date' => time(),
                    'shipping_code' => $v['tracking_code'],
                    'shipping_url' => $v['tracking_link'],
                ));

                if (!empty($v['shipping_comment']))
                {
                    $order->add_history(array(
                        'order_status' => 'add shipment',
                        'message' => $v['shipping_comment'],
                    ));
                }
                message::set('添加发货信息成功');

                $email_params = array(
                    'tracking_num' => Arr::get($v, 'tracking_code', ''),
                    'tracking_url' => Arr::get($v, 'tracking_link', ''),
                    'order_num' => $order->get('ordernum'),
                    'currency' => $order->get('currency'),
                    'amount' => $order->get('amount_payment'),
                    'email' => Customer::instance($order->get('customer_id'))->get('email'),
                    'firstname' => Customer::instance($order->get('customer_id'))->get('firstname'),
                );
                if(!$email_params['firstname'])
                    $email_params['firstname'] = 'customer';
//                                $email_params['tracking_words'] = ($email_params['ems_num'] OR $email_params['ems_url']) ? str_ireplace(array('{ems_num}', '{ems_url}'), array($email_params['ems_num'], $email_params['ems_url']), 'The Tracking No. is {ems_num}<br />The Tracking Link is {ems_url}<br />The tracking number will be valid in 48 hours. Please check the shipping status of your order online often.') : '';
                Mail::SendTemplateMail('SHIPPING', $email_params['email'], $email_params);
            }
            else
            {
                message::set('添加发货信息失败', 'error');
            }
        }
        else
        {
            message::set('表单信息不合法', 'error');
        }

        $this->request->redirect('/admin/site/order/' . (isset($_POST['_save']) ? 'list' : "edit/$id#order-edit-shipment"));
    }

    /**
     * Update order shipping/billing address.
     */
    public function action_address()
    {
        $id = (int) $this->request->param('id');

        $v = Validate::factory($_POST)
            ->filter(TRUE, 'trim')
            ->label('shipping_firstname', 'shipping_firstname')
            ->label('shipping_lastname', 'shipping_lastname')
            ->label('shipping_address', 'shipping_address')
            ->label('shipping_city', 'shipping_city')
            ->label('shipping_state', 'shipping_state')
            ->label('shipping_zip', 'shipping_zip')
            ->label('shipping_country', 'shipping_country')
            ->label('shipping_phone', 'shipping_phone')
            ->label('shipping_mobile', 'shipping_mobile')
            ->label('billing_firstname', 'billing_firstname')
            ->label('billing_lastname', 'billing_lastname')
            ->label('billing_address', 'billing_address')
            ->label('billing_city', 'billing_city')
            ->label('billing_state', 'billing_state')
            ->label('billing_zip', 'billing_zip')
            ->label('billing_country', 'billing_country')
            ->label('billing_phone', 'billing_phone')
            ->label('billing_mobile', 'billing_mobile');

        if ($v->check())
        {
            // update order address
            $order = Order::instance($id);

            if(Arr::get($_POST, 'isdefault', 0))
            {
                $customer_id = $order->get('customer_id');
                $datas['is_default'] = 0;
                $update = DB::update('accounts_address')->set($datas)->where('customer_id', '=', $customer_id)->execute();
                $data['customer_id'] = $customer_id;
                $data['site_id'] = 1;
                $data['firstname'] = $_POST['shipping_firstname'];
                $data['lastname'] = $_POST['shipping_lastname'];
                $data['address'] = $_POST['shipping_address'];
                $data['city'] = $_POST['shipping_city'];
                $data['zip'] = $_POST['shipping_zip'];
                $data['state'] = $_POST['shipping_state'];
                $data['country'] = $_POST['shipping_country'];
                $data['phone'] = $_POST['shipping_phone'];
                $data['is_default'] = 1;   
                DB::insert('accounts_address', array_keys($data))->values($data)->execute();
            }

            do
            {
                if (Site::instance()->erp_enabled() && $order->erp_synced())
                {
                    $order_data = array_merge($order->get(), $v->as_array());
                    if (!ERP::update_order($order_data))
                    {
                        Message::set(ERP::$error, 'error');
                        break;
                    }
                }

                if ($order->set($v->as_array()))
                {
                    // success
                    $order->add_history(array(
                        'order_status' => 'modify address',
                        'message' => '',
                    ));
                    message::set('更新订单地址成功', 'success');
                }
                else
                {
                    // failed to update address
                    message::set('更新订单地址失败', 'error');
                }
            }
            while (0);
        }
        else
        {
            message::set('表单数据不合法', 'error');
        }

        $this->request->redirect('/admin/site/order/' . (isset($_POST['_save']) ? 'list' : "edit/$id#order-edit-address"));
    }

    public function action_productqty($id)
    {
        if ($_POST)
        {
            $order = Order::instance($id);
            $products = unserialize($order->get('products'));

            $key = trim($_POST['key']);
            $qty = intval($_POST['qty']);

            if (array_key_exists($key, $products))
            {
                $orig = $products[$key]['quantity'];
                $products[$key]['quantity'] = $qty;
                if ($order->update_basic(array('products' => serialize($products))))
                {
                    $order->add_history(array(
                        'order_status' => 'change product qty',
                        'message' => "[$key] change from $orig to $qty",
                    ));
                    $this->request->response = 'success';
                    return true;
                }
                else
                {
                    $this->request->response = 'failed to update order';
                    return false;
                }
            }
        }

        $this->request->response = 'invalid form data';
        return false;
    }

    public function action_item_delete($id)
    {
        if ($_POST)
        {
            $order = Order::instance($id);
            $item_id = intval($_POST['item_id']);
            $item = $order->get_item($item_id);
            if (!$item)
                die("item not found: $item_id");

            if (Site::instance()->erp_enabled() && $order->erp_synced())
            {
                $ret = ERP::delete_order_item($item);
                if (!$ret)
                    die(ERP::$error);
            }

            if ($order->delete_item($item_id))
            {
                $this->request->response = 'success';
                return true;
            }
            else
            {
                $this->request->response = 'failed to delete product';
                return false;
            }
        }

        $this->request->response = 'invalid form data';
        return false;
    }

    public function action_item_cancel($id)
    {
        if ($_POST)
        {
            $order = Order::instance($id);
            $item_id = intval($_POST['item_id']);

            $item = $order->get_item($item_id);

            if (Site::instance()->erp_enabled() && $order->erp_synced())
            {
                $ret = ERP::cancel_order_item($item);
                if (!$ret)
                    die(ERP::$error);
            }

                $comment = 'cancel '.$item['sku'];
            if ($order->cancel_item($item_id, $item['quantity']))
            {
                    $order->add_history(array(
                        'order_status' => 'cancel product',
                        'message' => $comment,
                    ));
                    
                $payment_status = $order->get('payment_status');
                if($payment_status != 'success' AND $payment_status != 'verify_pass')
                    $order->update_amount();
                $this->request->response = 'success';
                return true;
            }
            else
            {
                $this->request->response = 'failed to cancel product';
                return false;
            }
        }

        $this->request->response = 'invalid form data';
        return false;
    }

    public function action_item_edit()
    {
        $order_id = Arr::get($_POST, 'order_id', 0);
        $item_id = Arr::get($_POST, 'item_id', 0);

        $order = Order::instance($order_id);
        if (!$order)
            die("Order not found");

        $orig_item = $order->get_item($item_id);
        $data['quantity'] = intval(Arr::get($_POST, 'quantity', 0));
        $data['price'] = Arr::get($_POST, 'price', $orig_item['price']);
        $data['customize_type'] =
            Arr::get($_POST, 'customize_type', 'none');
        $data['customize'] = $data['customize_type'] != 'none' ? serialize(Arr::get($_POST, 'customize', array())) : NULL;
        if (isset($_POST['attributes']))
            $data['attributes'] = $_POST['attributes'];
        $ret = $order->update_item($item_id, $data);
        if (!$ret)
        {
            die('Failed to save');
        }

        if (Site::instance()->erp_enabled() && $order->erp_synced())
        {
            $ret = ERP::update_order_item($order->get_item($item_id));
            if (!$ret)
            {
                $order->update_item($item_id, array(
                    'quantity' => $orig_item['quantity'],
                    'price' => $orig_item['price'],
                    'customize_type' => $orig_item['customize_type'],
                    'customize' => $orig_item['customize'] ? serialize($orig_item['customize']) : NULL,
                ));

                die(ERP::$error);
            }

            $order->set(array(
                'erp_fee_line_id' => $ret['feeLineId'],
                'erp_ship_line_id' => $ret['shipLineId'],
                'erp_otherfee_line_id' => $ret['otherFeeLineId'],
            ));
        }

        if ($order->get('payment_status') != 'verify_pass' AND $order->get('payment_status') != 'success')
            $order = Order::instance($order_id)->update_amount();
        die('success');
    }

    public function action_item_data($id)
    {
        $order = Order::instance($id);
        $item_id = intval(Arr::get($_POST, 'item_id', 0));
        $item = $order->get_item($item_id);

        echo json_encode($item);
    }

    public function action_item_add()
    {
        if ($_POST)
        {
            $sku = trim($_POST['sku']);
            $qty = intval($_POST['quantity']);

            $product = DB::select()
                ->from('products_product')
                ->where('site_id', '=', Site::instance()->get('id'))
                ->where('sku', '=', $sku)
                ->execute('slave')
                ->current();
            if (!$product)
            {
                die('Product not found');
            }

            $order = Order::instance(Arr::get($_POST, 'order_id', 0));
            if (!$order)
                die('Order not found');

            $customize = Arr::get($_POST, 'customize', null);
            $has_customize = FALSE;
            if ($customize)
            {
                foreach ($customize as $c)
                    if ($c)
                        $has_customize = TRUE;
            }

            $attributes = '';
            $attr = Arr::get($_POST, 'attributes', array());
            foreach ($attr as $name => $attribute)
            {
                $eur = strpos($attribute, 'EUR');
                if ($eur !== false)
                {
                    $attribute = substr($attribute, $eur + 3, 2);
                }
                $attributes .= ucfirst($name) . ':' . trim($attribute) . ';';
            }

            if (!$attributes)
            {
                die('Please Select Attributes');
            }

            $price = Arr::get($_POST, 'price', '');
            $item = array(
                'item_id' => $product['id'],
                'product_id' => $product['id'],
                'price' => $price != '' ? $price : Product::instance($product['id'])->price($qty),
                'quantity' => $qty == 0 ? 1 : $qty,
                'customize_type' => Arr::get($_POST, 'customize_type', 'none'),
                'customize' => ($has_customize ? serialize($customize) : NULL),
                'attributes' => $attributes,
            );

            $ret = $order->add_item($item);
            if (!$ret)
                die('Failed to add item');

            if (Site::instance()->erp_enabled() && $order->erp_synced())
            {
                list($operation, $item_id) = $ret;
                $ret = FALSE;
                switch ($operation)
                {
                    case 'CREATE':
                        $ret = ERP::create_order_item($order->get_item($item_id));
                        if (!$ret)
                            $order->delete_item($item_id);
                        else
                        {
                            $erp_line_id = 0;
                            foreach ($ret['details'] as $line)
                            {
                                if ($line['originalLineId'] == $item_id)
                                {
                                    $erp_line_id = $line['lineId'];
                                    break;
                                }
                            }

                            $order->update_item($item_id, array(
                                'erp_line_id' => $erp_line_id,
                            ));
                        }
                        break;
                    case 'UPDATE':
                        $ret = ERP::update_order_item($order->get_item($item_id));
                        if (!$ret)
                        {
                            $exist = $order->get_item($item_id);
                            $order->update_item($item_id, array(
                                'quantity' => $exist['quantity'] - $item['quantity'],
                            ));
                        }
                        break;
                }

                if (!$ret)
                    die(ERP::$error);

                $order->set(array(
                    'erp_fee_line_id' => $ret['feeLineId'],
                    'erp_ship_line_id' => $ret['shipLineId'],
                    'erp_otherfee_line_id' => $ret['otherFeeLineId'],
                ));
            }

//                        $order->update_amount();
            //shijiangming add 2013-2-20
            $amount = $order->get('amount');
            $amount += $item['price'] * $item['quantity'];
            $update = array(
                'amount' => $amount,
                'amount_order' => $amount,
                'amount_products' => $amount,
            );
            $order->update_basic($update);
            if ($order->get('payment_status') != 'verify_pass' && (float) ($order->get('amount_payment')) > 0 
                && ($amount - (float) $order->get('amount_payment')) > 0.00001)
            {
                $order->set(array('payment_status' => 'partial_paid'));
            }
            //
            die('success');
        }
        else
        {
            die('Invalid form data');
        }
    }

    public function action_item_customize()
    {
        $order_id = Arr::get($_POST, 'order_id', 0);
        $item_id = Arr::get($_POST, 'item_id', 0);

        $order = Order::instance($order_id);
        if (!$order)
            die("Order not found");

        if ($order->update_item($item_id, array(
                'customize_type' => Arr::get($_POST, 'customize_type'),
                'customize' => Arr::get($_POST, 'customize'),
            )))
        {
            die('success');
        }

        die('failed to update customize');
    }

    /**
     * Update order products.
     */
    public function action_products()
    {
        $data = $this->construct();
        $_url = 'admin/site/order/edit/' . $data['id'];
        if ($_POST)
        {
            $updated = FALSE;
            // TODO validate post data.
            // TODO 判断是否有重复提交的产品id
            $post = $_POST;
            $products = array();
            $pattern = '/product-(?P<id>\d+)-(?P<name>\w+)/';
            foreach ($post as $key => $value)
            {
                preg_match($pattern, $key, $matches);
                if (isset($matches['id']) && $value)
                {
                    $products[$matches['id']][$matches['name']] = $value;
                }
            }
            $products_delete = array();
            $products_update = array();
            foreach ($products as $key => &$product)
            {
                if (isset($product['product_id']))
                {
                    $product['id'] = $product['product_id'];
                    if (isset($product['delete']))
                    {
                        $products_delete[] = $product;
                    }
                    else
                    {
                        $products_update[] = $product;
                    }
                }
                else
                    unset($products[$key]);
            }
            $_recalculate = Arr::get($_POST, '_recalculate', '');
            $_recalculate_amount = $_recalculate ? TRUE : FALSE;
            if ($products_delete || $products_update)
            {
                $updated = Order::instance()->save_product($data['id'], $products_update, $products_delete, $_recalculate_amount);
                if ($updated)
                    Message::set(__('Update order products success.'));
                else
                    Message::set(__('Update order products failed'), 'error');
            }

            $_save = Arr::get($_POST, '_save', '');
            if ($_save)
            {
                $_url = 'admin/site/order/list/';
            }
        }
        $this->request->redirect($_url);
    }

    /**
     * Update order amount.
     */
    public function action_amount()
    {
        $id = (int) $this->request->param('id');
        $post = Validate::factory($_POST)
            ->filter(TRUE, 'trim')
            ->rule('amount_products', 'numeric')
            ->rule('amount_shipping', 'numeric')
            ->rule('amount_order', 'numeric')
            ->rule('amount', 'numeric')
            ->rule('rate', 'numeric')
            ->filter('currency', 'trim')
            ->rule('currency', 'in_array', array(explode(',', Site::instance()->get('currency'))));
        if ($post->check())
        {
            $updated = Order::instance($id)->set($post->as_array());
            if ($updated)
            {
                message::set('更新订单金额成功');
            }
            else
            {
                message::set('更新订单金额失败', 'error');
            }
        }
        else
        {
            message::set('表单数据不合法', 'error');
        }

        $this->request->redirect('/admin/site/order/' . (isset($_POST['_save']) ? 'list' : "edit/$id#order-edit-basic"));
    }

    public function action_amount_shipping($id)
    {
        $order = Order::instance($id);
        if (!$order->get('id'))
        {
            message::set('订单不存在', 'error');
        }

        $amount_orig = $order->get('amount_shipping');
        $amount_shipping = Arr::get($_POST, 'amount_shipping', 0);

        //TODO
        //plus rate
//                echo $order->get('amount') + $amount_shipping;exit;
        $order_shipping = $amount_shipping - $order->get('amount_shipping');
        if ($order->set(array('amount_shipping' => $amount_shipping, 'amount' => $order->get('amount') + $order_shipping, 'amount_order' => $order->get('amount_order') + $order_shipping)))
        {
//                        $order->update_amount();
            if (Site::instance()->erp_enabled() && $order->erp_synced())
            {
                $ret = ERP::update_order($order->get());
                if (!$ret)
                {
                    message::set(ERP::$error);
                    $order->set(array('amount_shipping' => $amount_orig));
                    $order->update_amount();
                }
                else
                {
                    message::set('更新运费成功');
                }
            }
            else
            {
                message::set('更新运费成功');
            }
        }
        else
            message::set('更新运费失败', 'error');

        $this->request->redirect("/admin/site/order/edit/$id#order-edit-basic");
    }

    //add by bzhao
    public function action_amount_ccy($id)
    {
        $transaction = TRUE;

        $order = Order::instance($id);

        if (!$order->get('id'))
        {
            $transaction = FALSE;
            message::set('订单不存在', 'error');
        }
        //TODO 

        if (!isset($_POST['ccy']))
        {
            $transaction = FALSE;
            message::set('提交数据不合法', 'error');
        }

        $orderdetail = $order->get();

        if ($_POST['ccy'] == $orderdetail['currency'])
        {
            $transaction = FALSE;
            message::set('币种没有变化', 'error');
        }

        //TODO action
        if ($transaction)
        {
            $sys_currencies = Site::instance()->currencies();
            $_update = array();

            $_update['amount_products'] = $orderdetail['amount_products'] * $sys_currencies[$_POST['ccy']]['rate'] / $sys_currencies[$orderdetail['currency']]['rate'];
            $_update['amount_shipping'] = $orderdetail['amount_shipping'] * $sys_currencies[$_POST['ccy']]['rate'] / $sys_currencies[$orderdetail['currency']]['rate'];
            $_update['amount_order'] = $orderdetail['amount_order'] * $sys_currencies[$_POST['ccy']]['rate'] / $sys_currencies[$orderdetail['currency']]['rate'];
            $_update['amount'] = $orderdetail['amount'] * $sys_currencies[$_POST['ccy']]['rate'] / $sys_currencies[$orderdetail['currency']]['rate'];
            $_update['rate'] = $sys_currencies[$_POST['ccy']]['rate'];
            $_update['currency'] = $_POST['ccy'];

            //TODO
            $post = Validate::factory($_update)
                ->filter(TRUE, 'trim')
                ->rule('amount_products', 'numeric')
                ->rule('amount_shipping', 'numeric')
                ->rule('amount_order', 'numeric')
                ->rule('amount', 'numeric')
                ->rule('rate', 'numeric')
                ->filter('currency', 'trim')
                ->rule('currency', 'in_array', array(explode(',', Site::instance()->get('currency'))));
            if ($post->check())
            {

                $updated = Order::instance($id)->set($post->as_array());
                if ($updated)
                {
                    message::set('更新币种成功');
                }
                else
                {
                    message::set('更新币种成功', 'error');
                }
            }
            else
            {
                message::set('提交数据不合法', 'error');
            }
        }
        $this->request->redirect("/admin/site/order/edit/$id#order-edit-basic");
    }

    /**
     * Add order payment.
     */
    public function action_payment()
    {
        $data = $this->construct();
        $_url = 'admin/site/order/edit/' . $data['id'] . '#order-edit-payment';
        if ($_POST)
        {
            $updated = FALSE;
            // TODO validate post data.
            $post = Validate::factory($_POST)
                ->filter(TRUE, 'trim')
                ->filter('payment_method', 'trim')
                ->filter('trans_id', 'trim')
                ->filter('amount', 'trim')
                ->filter('currency', 'trim')
                ->filter('create_date', 'trim')
                ->filter('payment_status', 'trim');
            if ($post->check())
            {
                $data_payment = array('order_id' => $data['id'], 'site_id' => $this->site_id);
                foreach ($post as $key => $value)
                {
                    if (!$value)
                        continue;
                    $data_payment[$key] = $value;
                }
                $updated = Order::instance()->insert_payment($data, $data_payment);
            }
            if ($updated)
            {
                message::set(__('Add order payment success.'));
            }
            else
            {
                message::set(__('Add order payment failed.'), 'error');
            }
            $_save = Arr::get($_POST, '_save', '');
            if ($_save)
            {
                $_url = 'admin/site/order/list/';
            }
        }
        $this->request->redirect($_url);
    }

    /**
     * Update order status.
     */
    public function action_status()
    {
        $id = (int) $this->request->param('id');
        $_POST['deliver_time'] = strtotime(Arr::get($_POST, 'deliver_time', ''));
        $payment_status = Arr::get($_POST, 'payment_status', '');
        if ($payment_status == 'verify_pass')
        {
            $_POST['verify_date'] = time();
            $v = Validate::factory($_POST)
                ->filter('payment_status', 'trim')
                ->filter('shipping_status', 'trim')
                ->filter('refund_status', 'trim')
                ->filter('verify_date', 'trim')
                ->filter('deliver_time', 'trim');
        }
        else
        {
            $v = Validate::factory($_POST)
                ->filter('payment_status', 'trim')
                ->filter('shipping_status', 'trim')
                ->filter('refund_status', 'trim')
                ->filter('deliver_time', 'trim');
        }
        if ($v->check())
        {
            $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
            $order = Order::instance($id);
            if ($order->update_basic(array_filter($v->as_array())))
            {
                // save comment to order history
                if (!empty($comment))
                {
                    $order->add_history(array(
                        'order_status' => 'update status',
                        'message' => $comment,
                    ));
                }

                if (isset($v['shipping_status']) && $v['shipping_status'] == 'delivered')
                {
                    $email_params = array(
                        'payname' => $order->get('transaction_id'),
                        'order_num' => $order->get('ordernum'),
                        'currency' => $order->get('currency'),
                        'amount' => round($order->get('amount_payment'),2),
                        'email' => Customer::instance($order->get('customer_id'))->get('email'),
                        'firstname' => Customer::instance($order->get('customer_id'))->get('firstname'),
                        'created' => date('Y-m-d H:i', $order->get('created')),
                        'points' => floor($order->get('amount_payment')),
                    );
                    if(!$email_params['firstname'])
                        $email_params['firstname'] = 'customer';
                    $currency = Site::instance()->currencies($email_params['currency']);
                    $order_product =
                            '<table border="0" width="92%">
                                    <tbody>
                                        <tr align="left">
                                            <td colspan="5"><strong>Product Details</strong></td>
                                        </tr>';
                    $order_products = Order::instance($id)->products();
                    foreach ($order_products as $rs)
                    {
                        $p = '<tr align="left">
                                        <td>' . $rs["name"] . '</td>
                                        <td>QTY:' . $rs["quantity"] . '</td>
                                        <td>' . $rs["attributes"] . '</td>
                                        <td>' . Site::instance()->price($rs['price'], 'code_view', NULL, $currency) . '</td>
                                    </tr>';
                        $order_product .= $p;
                    }
                    $order_product .= '</tbody></table>';
                    $email_params['order_product'] = $order_product;
                    Mail::SendTemplateMail('CONFIRM_MAIL', $email_params['email'], $email_params);
                }
                elseif(isset($v['shipping_status']) && $v['shipping_status'] == 'shipped')
                {
                    // add points
                    $amount = $order->get('amount');
                    if ($amount > 0)
                    {
                        Event::run('Order.payment', array(
                            'amount' => (int) $amount,
                            'order' => $order,
                        ));
                    }
                }

                $orders = $order->get();
                if ($orders['payment_status'] != 'success' AND $payment_status == 'verify_pass')
                {
                    $mail_params['order_view_link'] = 'http://' . Site::instance()->get('domain') . '/order/view/' . $orders['ordernum'];
                    $mail_params['order_num'] = $orders['ordernum'];
                    $mail_params['email'] = Customer::instance($orders['customer_id'])->get('email');
                    $mail_params['firstname'] = Customer::instance($orders['customer_id'])->get('firstname');
                    $mail_params['order_product'] = '';
                    $order_products = Order::instance($orders['id'])->products();
                    foreach ($order_products as $rs)
                    {
                        $mail_params['order_product'] .=__('<p style="line-height:22px;">SKU: ') . Product::instance($rs['item_id'])->get('sku') . ' ' . __('</p><p style="line-height:22px;">Name: ') . '<a href="' . Product::instance($rs['item_id'])->permalink() . '">' . Product::instance($rs['item_id'])->get('name') . '</a> ' . __('</p><p style="line-height:22px;">Price: ') . Site::instance()->price($rs['price'], 'code_view') . ' ' . __('</p><p style="line-height:23px;">Quantity: ') . $rs['quantity'] . ' ' . __('</p>');
                        $mail_params['order_product'] .= '<br />';
                    }

                    $mail_params['currency'] = $orders['currency'];
                    $mail_params['amount'] = $orders['amount'];
                    $mail_params['pay_num'] = $orders['amount'];
                    $mail_params['pay_currency'] = $orders['currency'];
                    $mail_params['shipping_firstname'] = $orders['shipping_firstname'];
                    $mail_params['shipping_lastname'] = $orders['shipping_lastname'];
                    $mail_params['address'] = $orders['shipping_address'];
                    $mail_params['city'] = $orders['shipping_city'];
                    $mail_params['state'] = $orders['shipping_state'];
                    $mail_params['country'] = $orders['shipping_country'];
                    $mail_params['zip'] = $orders['shipping_zip'];
                    $mail_params['phone'] = $orders['shipping_phone'];

                    Kohana_Log::instance()->add('SendMail', 'PAYSUCCESS-' . $orders['ordernum'])->write();
                    Mail::SendTemplateMail('PAYSUCCESS', $mail_params['email'], $mail_params);
                }
                message::set('更新订单状态成功');
            }
            else
            {
                message::set('更新订单状态失败', 'error');
            }
        }

        $hash = $v['payment_status'] ? '#order-edit-payment' : ($v['shipping_status'] ? '#order-edit-shipment' : '#order-edit-refund');
        $this->request->redirect('/admin/site/order/' . (isset($_POST['_save']) ? 'list' : "edit/$id$hash"));
    }

    public function action_refund()
    {
        $data = $this->construct();
        $_url = 'admin/site/order/edit/' . $data['id'] . '#order-edit-refund';
        if ($_POST)
        {
            $updated = FALSE;
            // TODO validate post data.
            $post = Validate::factory($_POST)
                ->filter(TRUE, 'trim')
                ->filter('refund_status', 'trim')
                ->filter('comment', 'trim');
            if ($post->check())
            {
                $data_status = array();
                foreach ($post as $key => $value)
                {
                    if (!$value)
                        continue;
                    $data_status[$key] = $value;
                }
                $updated = Order::instance()->update_order_status($data['id'], $data_status);
            }
            if ($updated)
            {
                message::set(__('Update order status success.'));
            }
            else
            {
                message::set(__('Update order status failed.'), 'error');
            }
            $_save = Arr::get($_POST, '_save', '');
            if ($_save)
            {
                $_url = 'admin/site/order/list/';
            }
        }
        $this->request->redirect($_url);
    }

    /**
     * Update order issue.
     */
    public function action_issue()
    {
        $data = $this->construct();
        $_url = 'admin/site/order/edit/' . $data['id'];
        if ($_POST)
        {
            $updated = FALSE;
            // TODO validate post data.
            $post = Validate::factory($_POST)
                ->filter(TRUE, 'trim')
                ->filter('issue', 'trim')
                ->filter('order_issue_comment', 'trim');
            if ($post->check())
            {
                $data_issue = array();
                foreach ($post as $key => $value)
                {
                    if (!$value)
                        continue;
                    $data_issue[$key] = $value;
                }
                $updated = Order::instance()->update_order_issue($data['id'], $data_issue);
            }
            if ($updated)
            {
                message::set(__('Update order issue success.'));
            }
            else
            {
                message::set(__('Update order issue failed.'), 'error');
            }
            $_save = Arr::get($_POST, '_save', '');
            if ($_save)
            {
                $_url = 'admin/site/order/list/';
            }
        }
        $this->request->redirect($_url);
    }

    /**
     * Add order remark.
     */
    public function action_remark()
    {
        $id = (int) $this->request->param('id');

        $v = Validate::factory($_POST)
            ->filter('remark', 'trim')
            ->filter('private', 'trim')
            ->rule('remark', 'not_empty');
        if ($v->check())
        {
            $remark['site_id'] = $this->site_id;
            $remark['order_id'] = $id;
            $remark['remark'] = $v['remark'];
            if (isset($v['private']) && $v['private'])
                $remark['type'] = 0;

            $order = Order::instance($id);
            $order->update_basic(array('is_marked' => Arr::get($_POST, 'is_marked', 0)));
            if ($order->add_remark($remark))
            {
                message::set('添加备注成功', 'success');
            }
            else
            {
                message::set('添加备注失败', 'error');
            }
        }
        else
        {
            message::set('请填写备注内容', 'error');
        }

        $this->request->redirect('/admin/site/order/' . (isset($_POST['_save']) ? 'list' : "edit/$id#order-edit-remark"));
    }

    public function action_remark_delete()
    {
        $id = (int) $this->request->param('id');
        $order_id = DB::select('order_id')->from('orders_orderremarks')->where('id', '=', $id)->execute('slave')->get('order_id');
        $delete = DB::delete('order_remarks')->where('id', '=', $id)->execute();
        if ($delete)
            message::set('Delete order remark success', 'success');
        else
            message::set('Delete order remark failed', 'success');
        $this->request->redirect("/admin/site/order/edit/$order_id#order-edit-remark");
    }

    /**
     * Ajax order list.
     * @return unknown_type
     */
    public function action_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());
        $activesql = isset($_GET['cl']) ? ' AND `orders`.`is_active`=0' : ' AND `orders`.`is_active`=1';
        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;
//                $limit = 20;
//                $sord = '';

        $filter_sql = "1";
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                $item_data = trim($item->data);
                //TODO add filter items
                if ($item->field == 'created' || $item->field == 'shipping_date' || $item->field == 'verify_date')
                {
                    $date = explode(' to ', $item_data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $_filter_sql[] = $item->field . " between " . $from . " and " . $to;
                }
                else if ($item->field == 'ordernum')
                {
                    $activesql = '';
                    $_filter_sql[] = $item->field . "='" . $item_data . "'";
                }
                else if ($item->field == 'admin')
                {
                    $user_id = DB::select('id')->from('auth_user')->where('name', '=', $item_data)->execute('slave')->get('id');
                    $_filter_sql[] = 'email IN (SELECT email FROM celebrits WHERE admin = ' . $user_id . ')';
                }
                else
                {
                    $_filter_sql[] = $item->field . "='" . $item_data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }
        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.is_active=1 AND `email` IS NOT NULL AND `orders`.site_id=' . $this->site_id . $activesql . ' AND '
                . $filter_sql)->execute('slave');
        $count = $result[0]['num'];
        $total_pages = 0;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT `orders`.* FROM `orders_order` WHERE `orders`.is_active=1 AND `email` IS NOT NULL AND  `orders`.site_id=' . $this->site_id . $activesql . ' AND '
                . $filter_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $order_status = kohana::config('order_status');
        foreach ($result as $value)
        {
            $customer = Customer::instance($value['customer_id']);
            $lastname = $customer->get('lastname');
            $firstname = $customer->get('firstname');
            $lastname_e = Database::instance()->escape($customer->get('lastname'));
            $firstname_e = Database::instance()->escape($customer->get('firstname'));
//                        $namecount = DB::query(Database::SELECT, "SELECT COUNT(*) AS total FROM orders o JOIN customers c ON o.customer_id = c.id WHERE o.customer_id = c.id AND o.site_id = " . $this->site_id . " AND o.parent_id IS NULL AND c.firstname = $firstname_e AND c.lastname = $lastname_e AND o.payment_status = 'verify_pass'")
//                                ->execute('slave')
//                                ->get('total');
            $namecount = '';
            $fullname = "$firstname $lastname:$namecount";

            $admin_id = DB::select('admin')->from('celebrities_celebrits')->where('customer_id', '=', $value['customer_id'])->execute('slave')->get('admin');

            if ($admin_id)
                $cele_admin = User::instance($admin_id)->get('name');
            else
                $cele_admin = '';

            $response['rows'][] = array(
                'id' => $value['id'],
                'cell' => array(
                    0,
                    $value['id'],
                    $value['ordernum'], 
                    $value['email'],
                    $fullname,
                    date('Y-m-d H:i', $value['created']),
                    $value['verify_date'] ? date('Y-m-d H:i', $value['verify_date']) : Null,
                    $value['shipping_date'] ? date('Y-m-d', $value['shipping_date']) : '',
                    $value['payment_status'],
                    $value['shipping_status'],
                    $value['refund_status'],
                    $value['currency'],
                    $value['amount'],
                    $cele_admin,
                    $value['payment_method'],
                    $value['deliver_time'] ? date('Y-m-d', $value['deliver_time']) : '',
                    $value['erp_fee_line_id'],
                    $value['lang'],
                    $value['order_from'],
                )
            );
        }
        echo json_encode($response);
    }

    public function action_export_data()
    {
        if($_POST)
        {
            $date = strtotime(Arr::get($_POST, 'start', 0));
            // $date += 28800; /* 8 hours */     
            // 添加更新结束时间
            $date_end = Arr::get($_POST, 'end', 0);

            if ($date_end)
            {
                $file_name = "orders-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
                $date_end = strtotime($date_end);
                // $date_end += 28800;
            }
            else
            {
                $file_name = "orders-" . date('Y-m-d', $date) . ".csv";
                $date_end = $date + 86400;
            }

            $us_states = array();
            $us = Kohana::config('state.states.US');
            foreach($us as $states)
            {
                $us_states = array_merge($us_states, $states);
            }
            $ca_states = Kohana::config('state.states.CA');

            $filter_sql = ' `orders`.created BETWEEN ' . $date . ' AND ' . $date_end;

            header("Content-type:application/vnd.ms-excel; charset=UTF-8");
            header('Content-Disposition: attachment; filename="' . $file_name . '"');
            echo "\xEF\xBB\xBF" . "Order No.,Email,Created,Verify Date,Shipping Date,Shipping Country,Shipping State,Payment Status,Shipping Status,Refund Status,Currency,Amount,Usd Amount,Admin,Payment Method,Deliver Time,Is Mobile,Lang,Order From\n";
            
            $result = DB::query(DATABASE::SELECT, 'SELECT `orders`.* FROM `orders_order` WHERE `orders`.is_active=1 AND `email` IS NOT NULL AND  `orders`.site_id=' . $this->site_id . ' AND '
                . $filter_sql . ' ORDER BY `orders`.id DESC')->execute('slave');
            foreach($result as $value)
            {
                $admin_id = DB::select('admin')->from('celebrities_celebrits')->where('customer_id', '=', $value['customer_id'])->execute('slave')->get('admin');
                if ($admin_id)
                    $cele_admin = User::instance($admin_id)->get('name');
                else
                    $cele_admin = '';

                echo '"' . $value['ordernum'] . '",'; 
                echo '"' . $value['email'] . '",';
                echo '"' . date('Y-m-d H:i', $value['created']) . '",';
                echo $value['verify_date'] ? '"' . date('Y-m-d H:i', $value['verify_date']) . '"' : Null , ',';
                echo $value['shipping_date'] ? '"' . date('Y-m-d', $value['shipping_date']) . '"' : '' , ',';
                echo $value['shipping_country'] ? '"' . $value['shipping_country'] . '"' : '' , ',';
                if($value['shipping_country'] == 'US' AND isset($us_states[$value['shipping_state']]))
                {
                    $shipping_state = $us_states[$value['shipping_state']];
                }
                elseif($value['shipping_country'] == 'CA' AND isset($ca_states[$value['shipping_state']]))
                {
                    $shipping_state = $ca_states[$value['shipping_state']];
                }
                else
                {
                    $shipping_state = $value['shipping_state'];
                }
                echo '"' . $shipping_state . '",';
                echo '"' . $value['payment_status'] . '",';
                echo '"' . $value['shipping_status'] . '",';
                echo '"' . $value['refund_status'] . '",';
                echo '"' . $value['currency'] . '",';
                echo '"' . $value['amount'] . '",';
                $usd_amount = round($value['amount'] / $value['rate'], 2);
                echo '"' . $usd_amount . '",';
                echo '"' . $cele_admin . '",';
                echo '"' . $value['payment_method'] . '",';
                echo $value['deliver_time'] ? '"' . date('Y-m-d', $value['deliver_time']) . '"' : '' , ',';
                echo '"' . $value['erp_fee_line_id'] . '",';
                echo '"' . $value['lang'] . '",';
                echo '"' . $value['order_from'] . '",';
                echo PHP_EOL;
            }
        }
    }

    public function action_gen_balance()
    {
        $data = $this->construct();
        //TODO if order is paid success, generate order balances for customer to pay for balance.
        $balance = 0;
        if ($data['payment_status'] == 'success')
        {
            //TODO Get order and balance order to verify balance.
            $balance = Site::instance()->price($data['amount'], '', $data['currency'], Site::instance()->currencies($data['currency'])) - $data['amount_payment'];
        }
        if ($balance)
        {
            // TODO Generate balance order.
            $added = Order::instance()->generate_balance($data['id']);
            if ($added)
            {
                Message::set(__('Generate balance order success.'));
            }
            else
            {
                Message::set(__('Generate balance order failed.'), 'error');
            }
        }
        else
        {
            Message::set(__('No need to generate balance order.'), 'notice');
        }
        $this->request->redirect('/admin/site/order/edit/' . $data['id']);
    }

    public function action_sendunpaymail()
    {
        $data = $this->construct();
        $sent = Order::instance()->sendmail($data['id'], 'unpay');
        if ($sent)
        {
            Message::set(__('Send customer none-payment remind email success'));
        }
        else
        {
            Message::set(__('Send customer none-payment remind email fail'), 'error');
        }
        $this->request->redirect('/admin/site/order/edit/' . $data['id']);
    }

    public function action_balance_list()
    {
        $order_statuses = Order::instance()->get_orderstatus();
        $content = View::factory('admin/site/order/balance_list')
            ->render();

        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_balance_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "1";
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                if ($item->field == 'created')
                {
                    $date = explode(' to ', $item->data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $_filter_sql[] = $item->field . " between " . $from . " and " . $to;
                }
                else
                {
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`orders`.`id`) AS num FROM `orders_order` WHERE `orders`.site_id=' . $this->site_id . ' AND `orders`.`parent_id` IS NOT NULL AND '
                . $filter_sql)->execute('slave');
        $count = $result[0]['num'];
        $total_pages = 0;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT `orders`.* FROM `orders_order` WHERE `orders`.site_id=' . $this->site_id . ' AND `orders`.`parent_id` IS NOT NULL AND '
                . $filter_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $order_status = kohana::config('order_status');
        foreach ($result as $value)
        {
            $payment_status = $value['payment_status'] ? $order_status['payment'][$value['payment_status']]['name'] . ($order_status['payment'][$value['payment_status']]['description'] ? ' [' . $order_status['payment'][$value['payment_status']]['description'] . ']' : '') : '';
            $response['rows'][] = array(
                'id' => $value['id'],
                'cell' => array(
                    $value['id'],
                    $value['ordernum'],
                    $value['email'],
                    date('Y-m-d H:i:s', $value['created']),
                    $payment_status,
                    $value['currency'],
                    $value['amount'],
                    long2ip($value['ip'])
                )
            );
        }
        echo json_encode($response);
    }

    //'Process Order' Page '导出采购单csv'
    public function action_procurementcsv()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $date = strtotime(Arr::get($_POST, 'date', 0));
        $date += 28800; /* 8 hours */

        // 添加更新结束时间
        $date_end = Arr::get($_POST, 'date_end', 0);

        if ($date_end)
        {
            $file_name = "pro-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
            $date_end = strtotime($date_end);
            $date_end += 28800;
        }
        else
        {
            $file_name = "pro-" . date('Y-m-d', $date) . ".csv";
            $date_end = $date + 86400;
        }

        $site = Site::instance();
        $where = array();
        $where[] = "site_id = " . $site->get('id');
        $where[] = "is_active = 1";
        $where[] = "payment_status = 'verify_pass'";
        $where[] = "shipping_status IN ('new_s', 'processing')";
        $where[] = "refund_status != 'refund'";
        $where[] = "refund_status != 'partial_refund'";
        $where[] = "verify_date >= $date";
        $where[] = "verify_date < $date_end";

        $where_clause = implode(' AND ', $where);
        $orders_id = $this->get_export_id($where_clause);

        header('Content-Type: application/vnd.ms-excel');
        //header('Content-Disposition: attachment; filename="orders-'.date('Y-m-d', $date).'.csv"');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');

        echo "sku,qty,name,RMB price,purchase qty,note,\n";

        $items = array();
        foreach ($orders_id as $order_id)
        {
            $order = new Order($order_id);
            if (!$order->get('id'))
                continue;

            $products = $order->products();
            foreach ($products as $orderitem)
            {
                if (array_key_exists($orderitem['item_id'], $items) && $orderitem['status'] != 'cancel')
                {
                    $items[$orderitem['item_id']]['quantity'] += $orderitem['quantity'];
                }
                else
                {
                    if ($orderitem['status'] != 'cancel')
                    {
                        $items[$orderitem['item_id']] = array(
                            'id' => $orderitem['item_id'],
                            'sku' => $orderitem['sku'],
                            'name' => $orderitem['name'],
                            'link' => $orderitem['link'],
                            'quantity' => $orderitem['quantity'],
                        );
                    }
                }
            }

            //$order->set(array('shipping_status' => 'processing'));
        }

        foreach ($items as $item)
        {
            echo $item['sku'] . ',';
            echo $item['quantity'] . ',';
            echo '"' . $item['name'] . '",';
            echo ',,,';
            echo "\n";
        }
    }

    //'Process Order' Page '导出配货单'
    public function action_procurementhtml()
    {
        $csv_file = Arr::get($_FILES, 'csv_file', NULL);
        if (!$csv_file)
        {
            die('invalid request');
        }

        $site_id = Site::instance()->get('id');
        $fp = fopen($csv_file['tmp_name'], 'r');
        $items = array();
        while ($row = fgetcsv($fp))
        {
            $sku = $row[0];
            $product = ORM::factory('product')->where('sku', '=', $sku)->find();
            if (!$product->loaded())
                continue;
            $items[$product->id] = array(
                'id' => $product->id,
                'sku' => $product->sku,
                'name' => $product->name,
                'link' => $product->link,
                'quantity' => $row[1],
                'note' => $row[5],
                'purchase_qty' => $row[4],
            );
        }

        fclose($fp);

        $content = View::factory('admin/site/order/procurement')
            ->set('items', $items)
            ->set('date', Arr::get($_POST, 'date', ''))
            ->set('date_end', Arr::get($_POST, 'date_end', ''))
            ->render();

        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
    }

    //'Process Order' Page '导出采购单'
    public function action_procurement()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $date = strtotime(Arr::get($_POST, 'date', 0));
        $date += 28800; /* 8 hours */

        // 添加更新结束时间
        $date_end = Arr::get($_POST, 'date_end', 0);

        if ($date_end)
        {
            $date_end = strtotime($date_end);
            $date_end += 28800;
        }
        else
        {
            $date_end = $date + 86400;
        }


        $site = Site::instance();
        $where = array();
        $where[] = "site_id = " . $site->get('id');
        $where[] = "is_active = 1";
        $where[] = "payment_status = 'verify_pass'";
        $where[] = "shipping_status IN ('new_s', 'processing')";
        $where[] = "refund_status != 'refund'";
        $where[] = "refund_status != 'partial_refund'";
        $where[] = "verify_date >= $date";
        $where[] = "verify_date < $date_end";
        $where[] = "products <> 'PMproducts'";

        $where_clause = implode(' AND ', $where);
        $orders_id = $this->get_export_id($where_clause);

        $items = array();
        foreach ($orders_id as $order_id)
        {
            $order = new Order($order_id);
            if (!$order->get('id'))
                continue;

            $products = $order->products();
            foreach ($products as $orderitem)
            {
                if (array_key_exists($orderitem['sku'], $items) && $orderitem['status'] != 'cancel')
                {
                    $items[$orderitem['sku']]['quantity'] += $orderitem['quantity'];
                }
                else
                {
                    if ($orderitem['status'] != 'cancel')
                    {
                        $items[$orderitem['sku']] = array(
                            'id' => $orderitem['item_id'],
                            'sku' => $orderitem['sku'],
                            'name' => $orderitem['name'],
                            'link' => $orderitem['link'],
                            'quantity' => $orderitem['quantity'],
                        );
                    }
                }
            }

            $order->set(array('shipping_status' => 'processing'));
        }
        ksort($items);
        $content = View::factory('admin/site/order/procurement')
            ->set('items', $items)
            ->set('date', Arr::get($_POST, 'date'))
            ->set('date_end', Arr::get($_POST, 'date_end', ''))
            ->render();

        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
    }

    public function action_detail()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="detail-' . date('Y-m-d') . '.csv"');

        echo "Order No.,SKU,Name,Qty\n";

        $ids = $this->shipping_ready_ids();
        foreach ($ids as $id)
        {
            $order = new Order($id['id']);
            $products = $order->products();
            foreach ($products as $orderitem)
            {
                echo '`' . $order->get('ordernum'), ',';
                echo $orderitem['sku'], ',';
                echo $orderitem['name'], ',';
                echo $orderitem['quantity'], PHP_EOL;
            }
        }
    }

    public function action_invoice()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="invoice-' . date('Y-m-d') . '.csv"');
        echo iconv('utf8', 'gbk', '库存编码') . ",Order No.,Created,Payment Date,Verify Date,SKU,Qty,Weight,Packing,Name,Shipping Address,Address Line1,Address Line2,Town/City,State/Province,Zip/Postal Code,Country,Declared Name,Declared Value(USD),Phone Num,Email,Shipping Method,Drop Shipping\n";
        $ids = $this->shipping_ready_ids();
        $countries = Site::instance()->countries();
        foreach ($countries as $c)
        {
            $country_map[$c['isocode']] = $c['name'];
        }

        foreach ($ids as $id)
        {
            $order = new Order($id['id']);
            $customer = new Customer($order->get('customer_id'));
            $products = $order->products();
            foreach ($products as $orderitem)
            {
                echo ',';
                echo '`', $order->get('ordernum'), ',';
                echo date('Y-m-d H:i:s', $order->get('created')), ',';
                echo date('Y-m-d H:i:s', $order->get('payment_date')), ',';
                echo date('Y-m-d H:i:s', $order->get('verify_date')), ',';
                echo $orderitem['sku'], ',';
                echo $orderitem['quantity'], ',';
                echo $orderitem['weight'], ',';
                echo ',';
                echo '"', $order->get('shipping_firstname'), ' ', $order->get('shipping_lastname'), '"', ',';
                echo '"', $order->get('shipping_address'), '"', ',';
                echo ',';
                echo ',';
                echo '"', $order->get('shipping_city'), '"', ',';
                echo '"', $order->get('shipping_state'), '"', ',';
                echo $order->get('shipping_zip'), ',';
                echo isset($country_map[$order->get('shipping_country')]) ? $country_map[$order->get('shipping_country')] : "", ',';
                echo ',';
                echo $order->get('amount'), ',';
                echo $order->get('shipping_phone'), ',';
                echo $order->get('email'), ',';
                echo $order->get('shipping_method'), ',';
                echo $order->get('drop_shipping') ? 'Yes' : 'No';
                echo "\n";
            }
        }
    }

    private function shipping_ready_ids()
    {
        return DB::select('id')
                ->from('orders_order')
                ->where('site_id', '=', Site::instance()->get('id'))
                ->where('is_active', '=', 1)
                ->where('payment_status', '=', 'verify_pass')
                ->where('shipping_status', '=', 'new_s')
                ->where('refund_status', '!=', 'refund')
                ->order_by('verify_date', 'DESC')
                ->execute('slave');
    }

    private function get_export_id($where)
    {
        return DB::query(Database::SELECT, "SELECT id FROM orders WHERE $where ORDER BY verify_date")
                ->execute('slave');
    }

    public function action_export_html()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $payment_status = 'verify_pass';
        $date = strtotime(Arr::get($_POST, 'date', 0));
        $date += 28800; /* 8 hours */

        // 添加更新结束时间
        $date_end = Arr::get($_POST, 'date_end', 0);

        if ($date_end)
        {
            $file_name = "orders-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
            $date_end = strtotime($date_end);
            $date_end += 28800;
        }
        else
        {
            $file_name = "orders-" . date('Y-m-d', $date) . ".csv";
            $date_end = $date + 86400;
        }

        $conditions = array(
            "is_active = 1",
            "site_id=" . Site::instance()->get('id'),
            "payment_status = 'verify_pass'",
            "shipping_status IN ('new_s', 'processing')",
            "refund_status != 'refund'",
            "refund_status != 'partial_refund'",
            "verify_date >= $date",
            "verify_date < $date_end",
        );

        $where_clause = implode(' AND ', $conditions);
        $ids = $this->get_export_id($where_clause);
        $site = Site::instance();

        $data = array();

        foreach ($ids as $id)
        {
            $order = new Order($id['id']);
            $products = $order->products();
            $remarks = $order->remarks();
            $data[$id['id']]['ordernum'] = $order->get('ordernum');
            $items = array();
            foreach ($products as $orderitem)
            {
                if ($orderitem['status'] == 'cancel')
                {
                    continue;
                }
                $item = array();
                $product = new Product($orderitem['item_id']);
                $item['id'] = $orderitem['item_id'];
                $item['sku'] = $orderitem['sku'];
                $item['quantity'] = $orderitem['quantity'];
                $items[] = $item;
            }
            $data[$id['id']]['items'] = $items;
            if (!empty($remarks))
            {
                foreach ($remarks as $orderremark)
                {
                    $remark = array();
                    $user = new User($orderremark['admin_id']);
                    $remark['remark'] = $orderremark['remark'];
                    $remark['admin'] = $user->get('name');
                    $remarkss[] = $remark;
                }
                $data[$id['id']]['remarks'] = $remarkss;
            }
        }

        $content = View::factory('admin/site/order/order_html')
            ->set('data', $data)
            ->set('date', Arr::get($_POST, 'date', ''))
            ->set('date_end', Arr::get($_POST, 'date_end', ''))
            ->render();

        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
    }

    public function action_export()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $countries = Site::instance()->countries();
        $payment_status = 'verify_pass';
        $date = strtotime(Arr::get($_POST, 'date', 0));
//                $date += 28800; /* 8 hours */		
        // 添加更新结束时间
        $date_end = Arr::get($_POST, 'date_end', 0);

        if ($date_end)
        {
            $file_name = "orders-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
            $date_end = strtotime($date_end);
//			$date_end += 28800;
        }
        else
        {
            $file_name = "orders-" . date('Y-m-d', $date) . ".csv";
            $date_end = $date + 86400;
        }

        header("Content-type:application/vnd.ms-excel; charset=UTF-8");
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
//                echo "\xEF\xBB\xBF" . "Order No.,Transaction Id,Is Gift,SKU,Description,Set,Qty,Weight,Attributes,Factory,Taobao Url,Offline_factory,Stock,Country Code,Country,Remark,Shipping Method,Shipment Status,name,address,city,state,zip,phone,mobile,Shipping amount,Dropshipping,Amount,Currency,USD,Point,Verify Date,Country,IP,Email,Times,Name,Payment Status,Sale Price,Subtotal,Orig Price,Cost,Total Cost,Orig Amount,Coupon,Time\n";
        echo "\xEF\xBB\xBF" . "Order No.,Transaction Id,SKU,Description,Qty,Attributes,Admin,Factory,Taobao Url,Offline_factory,Stock,Country Code,Country,Remark,name,address,city,state,zip,phone,mobile,Shipping amount,Amount,Email,Times,Sale Price,Orig Price,Total Cost,Time\n";
        $conditions = array(
            "is_active = 1",
            "site_id=" . Site::instance()->get('id'),
            "payment_status  = 'verify_pass'",
            "verify_date >= $date",
            "verify_date < $date_end",
        );

        $where_clause = implode(' AND ', $conditions);
        $ids = $this->get_export_id($where_clause);
        $site = Site::instance();

        foreach ($ids as $id)
        {
            $order = new Order($id['id']);
            $remarks = $order->remarks();
            $remarkss = '';
            if (!empty($remarks))
            {
                foreach ($remarks as $orderremark)
                {
                    $remark = array();
                    $user = new User($orderremark['admin_id']);
                    $remark['remark'] = $orderremark['remark'];
                    $remark['admin'] = $user->get('name');
                    $remarkss .= $remark['remark'] . ' - ' . $remark['admin'] . ',';
                }
                $data[$id['id']]['remarks'] = $remarkss;
                $remarkss = substr($remarkss, 0, strlen($remarkss) - 1);
            }

            $shipping_country = $order->get('shipping_country');
            foreach ($countries as $country)
            {
                if ($country['isocode'] == $shipping_country)
                {
                    $shipping_country = $country['name'];
                    break;
                }
            }
            $products = $order->products();
            foreach ($products as $key => $orderitem)
            {
                if ($orderitem['status'] == 'cancel')
                {
                    continue;
                }
                $product = Product::instance($orderitem['item_id']);
                echo $order->get('ordernum') . ',';
                echo "'" . $order->get('transaction_id') . ',';
//                                echo $orderitem['is_gift'] ? 'Yes,' : 'No,';
                echo $orderitem['sku'] . ',';
                echo str_replace(',', '-', $product->get('name')) . ',';
//                                $set = DB::query(Database::SELECT, 'SELECT sets.name FROM products LEFT JOIN sets ON products.set_id=sets.id WHERE products.set_id=sets.id AND products.id = ' . $orderitem['product_id'])->execute('slave')->get('name');
//                                echo $set . ',';
                echo $orderitem['quantity'] . ',';

//                                if ($product->get('id'))
//                                {
//                                        echo $product->get('weight') . ',';
//                                }
//                                else
//                                {
//                                        echo ",";
//                                }
                if (strpos($orderitem['attributes'], 'one size') !== False)
                    $attributes = 'one size;';
                else
                    $attributes = str_replace(' ', '', $orderitem['attributes']);
                $attributes = str_replace(';', '', $attributes);
                echo '"' . $attributes . ';",';
                $admin_id = DB::select('admin')->from('celebrities_celebrits')->where('email', '=', $order->get('email'))->execute('slave')->get('admin');
                if ($admin_id)
                    $admin = User::instance($admin_id)->get('name');
                else
                    $admin = '';
                echo '"' . $admin . '",';
                echo '"' . $product->get('factory') . '",';
                echo '"' . $product->get('taobao_url') . '",';
                echo '"' . $product->get('offline_factory') . '",';
                $instock = DB::query(Database::SELECT, 'SELECT SUM(quantity) AS sum FROM order_instocks WHERE sku="' . $orderitem['sku'] . '" AND attributes LIKE "' . $attributes . '%"')->execute('slave')->get('sum');
                $outstock = DB::query(Database::SELECT, 'SELECT SUM(quantity) AS sum FROM order_outstocks WHERE sku="' . $orderitem['sku'] . '" AND attributes LIKE "' . $attributes . '%"')->execute('slave')->get('sum');
                $stock = $instock - $outstock > 0 ? $instock - $outstock : 0;
                echo '"' . $stock . '",';
                echo '"' . $order->get('shipping_country') . '",';
                echo $shipping_country . ',';
                echo!$key ? '"' . $remarkss . '",' : ",";
//                                echo $order->get('shipping_method') . ',';
//                                echo $order->get('shipping_status') . ',';
                echo '"' . $order->get('shipping_firstname') . ' ' . $order->get('shipping_lastname') . '",';
                echo '"' . $order->get('shipping_address') . '",';
                echo '"' . $order->get('shipping_city') . '",';
                echo '"' . $order->get('shipping_state') . '",';
                echo "'" . $order->get('shipping_zip') . ",";
                echo '"' . $order->get('shipping_phone') . '",';
                echo '"' . $order->get('shipping_mobile') . '",';
                echo $order->get('amount_shipping') . ',';
//                                echo ($order->get('drop_shipping') ? 'Yes' : 'No') . ',';
                echo $order->get('amount') . ',';
//                                echo $order->get('currency') . ',';
//                                echo $site->price($order->get('amount'), NULL, $order->get('currency'), $site->currency_get('USD')) . ',';
//                                echo $order->get('point') . ',';
//                                echo date('Y-m-d H:i:s', $order->get('verify_date')) . ',';
//                                echo $order->get('shipping_country').',';
//                                echo $shipping_country . ',';
//                                echo long2ip($order->get('ip')) . ',';
                echo $order->get('email') . ',';
                $result = DB::query(1, 'SELECT count(id) AS count FROM orders WHERE email = "' . $order->get('email') . '" AND payment_status = "verify_pass"')->execute('slave')->current();
                echo $result['count'] . ',';
//                                echo '"' . $orderitem['name'] . '",';
//                                echo $order->get('payment_status') . ',';
                echo $orderitem['price'] . ',';
//                                echo ($orderitem['quantity'] * $orderitem['price']) . ',';

                if ($product->get('id'))
                {
                    echo $product->get('price') . ',';
//                                        echo $product->get('cost') . ',';
                    echo $product->get('total_cost') . ',';
                }
                else
                {
                    echo ",";
//                                        echo ",";
                    echo ",";
                }

//                                echo ($order->get('amount_products') + $order->get('amount_shipping')) . ',';
//                                echo $order->get('coupon_code') . ',';
                echo date('Y-m-d', $order->get('created'));
                echo "\n";
            }
        }
    }

    public function action_export_catalog()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $date = strtotime(Arr::get($_POST, 'date', 0));
//                $date += 28800; /* 8 hours */		
        // 添加更新结束时间
        $date_end = Arr::get($_POST, 'date_end', 0);

        if ($date_end)
        {
            $file_name = "orders-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
            $date_end = strtotime($date_end);
//			$date_end += 28800;
        }
        else
        {
            $file_name = "orders-" . date('Y-m-d', $date) . ".csv";
            $date_end = $date + 86400;
        }

        header("Content-type:application/vnd.ms-excel; charset=UTF-8");
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        echo "\xEF\xBB\xBF" . "Order No.,Currency,Amount,Email,Admin,Times,Created,Verify Date\n";
        $conditions = array(
            "is_active = 1",
            "site_id=" . Site::instance()->get('id'),
            "payment_status  = 'verify_pass'",
            "created >= $date",
            "created < $date_end",
        );

        $where_clause = implode(' AND ', $conditions);
        $ids = $this->get_export_id($where_clause);
        foreach ($ids as $id)
        {
            $order = new Order($id['id']);
            echo $order->get('ordernum') . ',';
            echo $order->get('currency') . ',';
            echo $order->get('amount') . ',';
            $email = $order->get('email');
            echo $email . ',';
            $admin = DB::select('admin')->from('celebrities_celebrits')->where('email', '=', $email)->execute('slave')->get('admin');
            echo $admin ? User::instance($admin)->get('name') : ' ';
            echo ',';
            $result = DB::query(1, 'SELECT count(id) AS count FROM orders WHERE email = "' . $email . '" AND payment_status = "verify_pass"')->execute('slave')->current();
            echo $result['count'] . ',';
            echo date('Y-m-d', $order->get('created')) . ',';
            echo date('Y-m-d', $order->get('verify_date'));
            echo "\n";
        }
    }

    public function action_mobile_export_catalog()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $date = strtotime(Arr::get($_POST, 'date', 0));
//                $date += 28800; /* 8 hours */		
        // 添加更新结束时间
        $date_end = Arr::get($_POST, 'date_end', 0);

        if ($date_end)
        {
            $file_name = "orders-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
            $date_end = strtotime($date_end);
//			$date_end += 28800;
        }
        else
        {
            $file_name = "orders-" . date('Y-m-d', $date) . ".csv";
            $date_end = $date + 86400;
        }

        header("Content-type:application/vnd.ms-excel; charset=UTF-8");
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        echo "\xEF\xBB\xBF" . "Order No.,Currency,Amount,Email,Admin,Times,Created,Verify Date\n";
        $conditions = array(
            "is_active = 1",
            "site_id=" . Site::instance()->get('id'),
            "payment_status  = 'verify_pass'",
            "erp_fee_line_id = 1 ",
            "created >= $date",
            "created < $date_end",
        );

        $where_clause = implode(' AND ', $conditions);
        //+++++
        $ids = DB::query(Database::SELECT, "SELECT id FROM orders WHERE $where_clause ORDER BY verify_date")
            ->execute('slave');

        foreach ($ids as $id)
        {
            $order = new Order($id['id']);
            echo $order->get('ordernum') . ',';
            echo $order->get('currency') . ',';
            echo $order->get('amount') . ',';
            $email = $order->get('email');
            echo $email . ',';
            $admin = DB::select('admin')->from('celebrities_celebrits')->where('email', '=', $email)->execute('slave')->get('admin');
            echo $admin ? User::instance($admin)->get('name') : ' ';
            echo ',';
            $result = DB::query(1, 'SELECT count(id) AS count FROM orders WHERE email = "' . $email . '" AND payment_status = "verify_pass"')->execute('slave')->current();
            echo $result['count'] . ',';
            echo date('Y-m-d', $order->get('created')) . ',';
            echo date('Y-m-d', $order->get('verify_date'));
            echo "\n";
        }
    }

    public function action_export_status()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $payment_status = 'verify_pass';
        $date = strtotime(Arr::get($_POST, 'start', 0));

        // 添加更新结束时间
        $date_end = Arr::get($_POST, 'end', 0);

        if ($date_end)
        {
            $file_name = "order_status-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
            $date_end = strtotime($date_end);
            $date_end += 28800;
        }
        else
        {
            $file_name = "order_status-" . date('Y-m-d', $date) . ".csv";
            $date_end = $date + 86400;
        }

        $payment_method = Arr::get($_POST, 'payment_method', 'PP');

        $result = DB::query(Database::SELECT, "SELECT orders.ordernum, orders.shipping_status, order_shipments.tracking_code, order_shipments.tracking_link
                        FROM orders
                        LEFT JOIN order_shipments ON orders.id = order_shipments.order_id
                        WHERE orders.id = order_shipments.order_id
                        AND orders.payment_method = '$payment_method'
                        AND orders.shipping_status = 'shipped'
                        AND orders.verify_date >= $date
                        AND orders.verify_date < $date_end
                        ORDER BY `orders`.`payment_status` DESC ")
            ->execute('slave');

        header("Content-type: application/vnd.ms-excel");
        //header('Content-Disposition: attachment; filename="orders-'.date('Y-m-d', $date).'.csv"');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');

        echo "\xEF\xBB\xBF" . "Order No.,Payment Status,Shipping Status,Tracking Code,Tracking Link\n";

        foreach ($result as $val)
        {
            echo $val['ordernum'] . ',';
            echo $val['shipping_status'] . ',';
            echo $val['tracking_code'] . ',';
            echo $val['tracking_link'] . ',';
            echo PHP_EOL;
        }
    }

    public function action_export_shipment()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="orders-shipment' . date('Y-m-d') . '.csv"');

        echo "Order No.,Shipment Status,Shipping Date,Shipping Method,Shipping Fee,SKU,Qty,Weight,Subtotal Weight\n";
        $sql = "SELECT s.order_id, s.carrier, s.ship_date, si.item_id, si.quantity"
            . " FROM order_shipments s"
            . " JOIN order_shipmentitems si ON s.id = si.shipment_id"
            . " WHERE s.site_id = " . Site::instance()->get('id')
            . " ORDER BY s.order_id";
        $records = DB::query(Database::SELECT, $sql)->execute('slave');
        foreach ($records as $record)
        {
            if (!isset($order) || $record['order_id'] != $order->get('id'))
            {
                $order = new Order($record['order_id']);
            }

            echo $record['order_id'], ',';
            echo $order->get('shipping_status'), ',';
            echo date('Y-m-d', $record['ship_date']), ',';
            echo $record['carrier'], ',';
            echo $order->get('amount_shipping'), ',';
            $product = new Product($record['item_id']);
            if ($product->get('id'))
            {
                echo $product->get('sku'), ',';
                echo $record['quantity'], ',';
                echo $product->get('weight'), ',';
                echo $product->get('weight') * $record['quantity'], PHP_EOL;
            }
            else
            {
                echo PHP_EOL;
            }
        }
    }

    public function action_export_product()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="orders-product' . date('Y-m-d') . '.csv"');

        echo "SKU,Name,Catalog,Total sold,Total Order,Price\n";
        $records = DB::select(DB::expr('DISTINCT product_id, sku, name'))
            ->from('orders_orderitem')
            ->where('site_id', '=', Site::instance()->get('id'))
            ->execute('slave');
        foreach ($records as $record)
        {
            $product = new Product($record['product_id']);
            if (!$product->get('id'))
                continue;

            echo $record['sku'], ',';
            echo '"' . $record['name'] . '"', ',';

            // catalog name
            $sql = "SELECT name FROM catalogs c"
                . " JOIN catalog_products cp ON cp.catalog_id = c.id"
                . " WHERE cp.product_id = " . $record['product_id'];
            $catalog = DB::query(Database::SELECT, $sql)
                    ->execute('slave')->current();
            echo $catalog['name'], ',';

            // total sold
            $total = DB::select(DB::expr('SUM(quantity) AS total'))
                ->from('orders_orderitem')
                ->where('site_id', '=', Site::instance()->get('id'))
                ->where('product_id', '=', $record['product_id'])
                ->execute('slave')
                ->current();
            echo $total['total'], ',';

            // total orders relate
            $total_order = DB::select(DB::expr('COUNT(DISTINCT order_id) AS total_order'))
                ->from('orders_orderitem')
                ->where('site_id', '=', Site::instance()->get('id'))
                ->where('product_id', '=', $record['product_id'])
                ->execute('slave')
                ->current();
            echo $total_order['total_order'], ',';
            echo $product->get('price'), "\n";
        }
    }

    public function action_export_address()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $payment_status = 'verify_pass';
        $date = strtotime(Arr::get($_POST, 'date', 0));
        $date += 28800; /* 8 hours */

        // 添加更新结束时间
        $date_end = Arr::get($_POST, 'date_end', 0);

        if ($date_end)
        {
            $file_name = "orders-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
            $date_end = strtotime($date_end);
            $date_end += 28800;
        }
        else
        {
            $file_name = "orders-" . date('Y-m-d', $date) . ".csv";
            $date_end = $date + 86400;
        }


        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="invoice-' . $file_name . '"');
        echo iconv('utf-8', 'gbk', '库存编码') . "," . iconv('utf-8', 'gbk', '客户备注Custom') . ",Quantity,Weight,Packing,Name,Shipping Address,Address Line1,Address Line2,Town/City,State/Province,Zip/Postal Code,Country,Declared Name,Declared Value(USD),Phone Num,Email\n";

        $conditions = array(
            "is_active = 1",
            "site_id=" . Site::instance()->get('id'),
            "payment_status = 'verify_pass'",
            "verify_date >= $date",
            "verify_date < $date_end",
        );

        $where_clause = implode(' AND ', $conditions);
        $ids = $this->get_export_id($where_clause);

        $countries = Site::instance()->countries();
        foreach ($countries as $c)
        {
            $country_map[$c['isocode']] = $c['name'];
        }

        foreach ($ids as $id)
        {
            $order = new Order($id['id']);
            $customer = new Customer($order->get('customer_id'));
            $products = $order->products();
            $quantity = 0;
            $weight = 0;
            foreach ($products as $orderitem)
            {
                $quantity += $orderitem['quantity'];
                $weight += $orderitem['weight'];
            }
            echo ',';
            echo $order->get('ordernum'), ',';
            echo $quantity, ',';
            echo $weight, ',';
            echo ',';
            echo '"', $order->get('shipping_firstname'), ' ', $order->get('shipping_lastname'), '"', ',';
            echo '"', $order->get('shipping_address'), '"', ',';
            echo ',';
            echo ',';
            echo '"', $order->get('shipping_city'), '"', ',';
            echo '"', $order->get('shipping_state'), '"', ',';
            echo $order->get('shipping_zip'), ',';
            echo isset($country_map[$order->get('shipping_country')]) ? $country_map[$order->get('shipping_country')] : "", ',';
            echo ',';
            echo $order->get('amount'), ',';
            echo $order->get('shipping_phone'), ',';
            echo $order->get('email'), ',';
            echo "\n";
        }
    }

    public function action_delete()
    {
        $id = $this->request->param('id');

        $order = Order::instance($id);

        if ($order->get('id'))
        {
            $tables = DB::select('TABLE_NAME')->from('information_schema.COLUMNS')
                ->where('COLUMN_NAME', '=', 'order_id')
                ->execute('slave');
            if (!empty($tables))
            {
                foreach ($tables as $table)
                {
                    try
                    {
                        DB::delete(Arr::get($table, 'TABLE_NAME', ''))->where('order_id', '=', $id)->execute();
                    }
                    catch (Exception $e)
                    {
                        
                    }
                }
            }
            DB::delete('orders_order')->where('id', '=', $id)->execute();
            Message::set('Order_deleted');
        }
        else
        {
            Message::set('Order does not exist');
        }

        $this->request->redirect('/admin/site/order/list');
    }

    public function action_discard($id)
    {
        $ret = DB::update('orders_order')
            ->set(array('is_active' => 0))
            ->where('id', '=', $id)
            ->execute();
        $error = '删除订单失败';
        if (Site::instance()->erp_enabled())
        {
            // cancel order in ERP
            $order = Order::instance($id);
            if (!ERP::cancel_order($order->get()))
            {
                // rollback
                DB::update('orders_order')
                    ->set(array('is_active' => 1))
                    ->where('id', '=', $id)
                    ->execute();
                $ret = FALSE;
                $error = ERP::$error;
            }
        }

//                echo $ret ? 'success' : $error;
        if ($ret)
        {
            $points = Order::instance($id)->get('points');
            if($points > 0)
            {
                $customer_id = Order::instance($id)->get('customer_id');
                Customer::instance($customer_id)->point_inc($points);
                DB::update('accounts_point_payments')->set(array('note' => 'order_discard'))->where('order_id', '=', $id)->execute();
            }
            Order::instance($id)->add_history(array(
                'order_status' => 'Discard order',
                'message' => '',
            ));
            echo 'success';
        }
        else
            echo $error;
    }

    public function action_recover($id)
    {
        $ret = DB::update('orders_order')
            ->set(array('is_active' => 1))
            ->where('id', '=', $id)
            ->execute();
        if($ret)
        {
            $points = Order::instance($id)->get('points');
            if($points > 0)
            {
                $customer_id = Order::instance($id)->get('customer_id');
                Customer::instance($customer_id)->point_dec($points);
                DB::update('accounts_point_payments')->set(array('note' => 'order_recover'))->where('order_id', '=', $id)->execute();
            }
        }

        echo $ret ? 'success' : '失败';
    }

    public function action_lens_downlad()
    {
        if ($_POST)
        {
            $file = DB::select()->from('len_pictures')
                ->where('id', '=', $_POST['id'])
                ->execute('slave')
                ->current();
            $file_name = $file['file_name'] . '.' . substr($file["file_type"], 6);
            echo $file_name;
            //            self::$upload_dir = $_SERVER['COFREE_DATA_DIR']."/upload/";
            //            $file_dir = self::$upload_dir ;
            //            if(file_exists($file_dir.$file_name))
            //            {
            //                $file = fopen($file_dir.$file_name,"r");
            //                Header("Content_type:application/octet-stream");
            //                Header("Accept-Ranges:bytes");
            //                Header("Accept-Length:".filesize($file_dir.$file_name));
            //                Header("Content-Disposition:attachment;filename=".$file_name);
            //                echo fread($file,filesize($file_dir.$file_name));
            //                fclose($file);
            //            }
            //            else
            //            {
            //                echo false;
            //            }
        }
    }

    public function action_erp_sync($id)
    {
        $order = Order::instance($id);
        if (!$order || !$order->get('id'))
        {
            die('Order not found');
        }

        $ret = ERP::sync_order($order);
        if (!$ret)
            die(ERP::$error);

        die('success');
    }

    public function action_verify($id)
    {
        $order = Order::instance($id);
        if (!$order || !$order->get('id'))
        {
            die('Order not found');
        }

        $order->set(array(
            'is_verified' => 1,
            'verified_at' => time(),
        ));

        die('success');
    }

    public function action_create()
    {
        if ($_POST)
        {
            $customer_email = Arr::get($_POST, 'customer_email', '');
            $customer_id = DB::select('id')
                ->from('accounts_customers')
                ->where('site_id', '=', Site::instance()->get('id'))
                ->where('email', '=', $customer_email)
                ->execute('slave')
                ->get('id');
            if (!$customer_id)
            {
                Message::set("Customer($customer_email) not found", 'error');
                $this->request->redirect('/admin/site/order/create');
            }

            $is_backorder = Arr::get($_POST, 'is_backorder', FALSE);
            if ($is_backorder)
            {
                $ref_ordernum = Arr::get($_POST, 'ref_ordernum', 0);
                $ref_orderid = Order::get_from_ordernum($ref_ordernum);
                if (!$ref_orderid)
                {
                    Message::set("Reference Order($ref_ordernum) not found", 'error');
                    $this->request->redirect('/admin/site/order/create');
                }
            }

            $customer = new Customer($customer_id);
            $customer_address = DB::select()
                ->from('accounts_address')
                ->where('customer_id', '=', $customer_id)
                ->order_by('id', 'desc')
                ->execute('slave')
                ->current();
            $carrier = Arr::get($_POST, 'carrier', '');
            $order_from = Arr::get($_POST, 'order_from', '');//订单来源

            $payment_method = Arr::get($_POST, 'payment_method', 'PP');
            $order_id = Order::init();
            $order = new Order($order_id);
            $order_data = array(
                'customer_id' => $customer_id,
                'email' => $customer_email,
                'currency' => 'USD',
                'parent_id' => $is_backorder ? $ref_orderid : NULL,
                'shipping_method' => $carrier,
                'payment_method' => $payment_method,
                'verify_date' => time(),
                'order_from'=>$order_from,//订单来源
            );

            if ($customer_address)
            {
                $order_data += array(
                    'shipping_firstname' => $customer_address['firstname'],
                    'shipping_lastname' => $customer_address['lastname'],
                    'shipping_country' => $customer_address['country'],
                    'shipping_state' => $customer_address['state'],
                    'shipping_city' => $customer_address['city'],
                    'shipping_address' => $customer_address['address'],
                    'shipping_zip' => $customer_address['zip'],
                    'shipping_phone' => $customer_address['phone'],
                    'shipping_mobile' => $customer_address['other_phone'],
                    'billing_firstname' => $customer_address['firstname'],
                    'billing_lastname' => $customer_address['lastname'],
                    'billing_country' => $customer_address['country'],
                    'billing_state' => $customer_address['state'],
                    'billing_city' => $customer_address['city'],
                    'billing_address' => $customer_address['address'],
                    'billing_zip' => $customer_address['zip'],
                    'billing_phone' => $customer_address['phone'],
                    'billing_mobile' => $customer_address['other_phone'],
                );
            }

            $order->set($order_data);

            $this->request->redirect('/admin/site/order/edit/' . $order_id);
        }

        $carriers = DB::select('carrier')
            ->from('core_carriers')
            ->where('site_id', '=', Site::instance()->get('id'))
            ->execute('slave');

        $content = View::factory('admin/site/order/create')
            ->set('carriers', $carriers)
            ->render();
        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
    }

    public function action_process()
    {
        $date = strtotime('midnight');
        $statistics = array();
        $site_id = Site::instance()->get('id');
        $where = array();
        $where[] = "site_id = " . $site_id;
        $where[] = "is_active = 1";
        $where[] = "payment_status  = 'verify_pass'";
        $where[] = "verify_date >= %d";
        $where[] = "verify_date < %d";
        $where[] = "shipping_status IN ('new_s', 'processing')";
        $where[] = "refund_status != 'refund'";
        $where[] = "refund_status != 'partial_refund'";
        $where_clause = implode(' AND ', $where);

        // if ($site_id != '4')
        // {
        //     $date += 28800; /* 8 hours */
        // }
        // for ($i = 0; $i < 30; $i++)
        // {
        //     $date = $date - 86400;
        //     $date_end = $date + 86400;
        //     $orders_id = $this->get_export_id(sprintf($where_clause, $date, $date_end));
        //     $statistics[$date] = count($orders_id);
        // }

        $this->request->response = View::factory('admin/template')
            ->set('content', View::factory('admin/site/order/process')->set('statistics', $statistics))
            ->render();
    }

    public function action_bulk_shipping()
    {
        $csv_file = Arr::get($_FILES, 'csv_file', NULL);
        if (!$csv_file)
        {
            die('invalid request');
        }

        $site_id = Site::instance()->get('id');
        $fp = fopen($csv_file['tmp_name'], 'r');
        while ($line = fgets($fp))
        {
            @list($order_no, $track_no, $track_link, $track_carrier) = explode(',', $line);
            $order_no = trim($order_no);
            $track_no = trim($track_no);
            $track_link = trim($track_link);
            $track_carrier = trim($track_carrier);
            $shipping_status = DB::select('shipping_status')
                ->from('orders_order')
                ->where('ordernum', '=', $order_no)
                ->execute('slave')
                ->current();

            if ($shipping_status['shipping_status'] === 'shipped')
            {
                $ret = DB::update('orders_ordershipments')
                    ->set(array('tracking_code' => $track_no, 'tracking_link' => $track_link, 'carrier' => $track_carrier ? $track_carrier : 'EMS'))
                    ->where('site_id', '=', $site_id)
                    ->and_where('ordernum', '=', $order_no)
                    ->execute();
                if ($ret)
                {
                    $order_id = Order::get_from_ordernum($order_no);
                    $order = new Order($order_id);
                    if (!$order->get('id'))
                        continue;
                    $customer = new Customer($order->get('customer_id'));
                    $email_params = array(
                        'tracking_num' => $track_no,
                        'tracking_url' => $track_link,
                        'order_num' => $order_no,
                        'currency' => $order->get('currency'),
                        'amount' => $order->get('amount'),
                        'email' => $customer->get('email'),
                        'firstname' => $customer->get('firstname'),
                    );
                    if(!$email_params['firstname'])
                        $email_params['firstname'] = 'customer';

                    if (($track_carrier == 'CUE' AND $track_link == '') or $track_carrier == 'HKPT')
                    {
                        $email_params['tracking_words'] = '';
                    }
                    else
                    {
                        $email_params['tracking_words'] = ($email_params['ems_num'] OR $email_params['ems_url']) ? str_ireplace(array('{ems_num}', '{ems_url}'), array($email_params['ems_num'], $email_params['ems_url']), 'The Tracking No. is {ems_num}<br />The Tracking Link is {ems_url}<br />The tracking number will be valid in 48 hours. Please check the shipping status of your order online often.') : '';
                    }
                    Mail::SendTemplateMail('SHIPPING', $email_params['email'], $email_params);
                    echo "$order_no: SUCCESS<br/>\n";
                }
                else
                {
                    echo "$order_no: FAILED<br/>\n";
                }
            }
            else
            {
                $ret = DB::update('orders_order')
                    ->set(array('shipping_status' => 'shipped'))
                    ->where('ordernum', '=', $order_no)
                    ->where('site_id', '=', $site_id)
                    ->where('shipping_status', 'IN', array('new_s', 'processing'))
                    ->execute();
                if ($ret)
                {
                    $order_id = Order::get_from_ordernum($order_no);
                    $order = new Order($order_id);
                    if (!$order->get('id'))
                        continue;

                    $items = array();
                    $products = $order->products();
                    foreach ($products as $product)
                    {
                        $items[] = array(
                            'item_id' => $product['item_id'],
                            'quantity' => $product['quantity'],
                        );
                    }

                    $order->add_shipment(array(
                        'tracking_code' => $track_no,
                        'tracking_link' => $track_link,
                        'carrier' => $track_carrier,
                        'ship_date' => time(),
                        ), $items);

                    $customer = new Customer($order->get('customer_id'));
                    $email_params = array(
                        'tracking_num' => $track_no,
                        'tracking_url' => $track_link,
                        'order_num' => $order_no,
                        'currency' => $order->get('currency'),
                        'amount' => $order->get('amount'),
                        'email' => $customer->get('email'),
                        'firstname' => $customer->get('firstname'),
                    );
                    if(!$email_params['firstname'])
                        $email_params['firstname'] = 'customer';

                    if (($track_carrier == 'CUE' AND $track_link == '') or $track_carrier == 'HKPT')
                    {
                        $email_params['tracking_words'] = '';
                    }
                    else
                    {
                        $email_params['tracking_words'] = ($email_params['ems_num'] OR $email_params['ems_url']) ? str_ireplace(array('{ems_num}', '{ems_url}'), array($email_params['ems_num'], $email_params['ems_url']), 'The Tracking No. is {ems_num}<br />The Tracking Link is {ems_url}<br />The tracking number will be valid in 48 hours. Please check the shipping status of your order online often.') : '';
                    }
                    Mail::SendTemplateMail('SHIPPING', $email_params['email'], $email_params);
                    echo "$order_no: SUCCESS<br/>\n";
                }
                else
                {
                    echo "$order_no: FAILED<br/>\n";
                }
            }
        }

        fclose($fp);
        exit;
    }

    public function action_shipmentfedex()
    {
        $csv_file = Arr::get($_FILES, 'csv_file', NULL);
        if (!$csv_file)
        {
            die('invalid request');
        }

        $fp = fopen($csv_file['tmp_name'], 'r');
        $items = array();
        while ($data = fgetcsv($fp))
        {
            $items[] = array(
                'ordernum' => $data[0],
                'weight' => $data[1],
                'quantity' => $data[2],
                'description' => $data[3],
                'declared_value' => $data[4],
            );
        }

        fclose($fp);
        $fedexs = array();
        foreach ($items as $key => $item)
        {
            if ($key == 0)
                continue;
            $order = Order::instance(Order::get_from_ordernum($item['ordernum']));
            $val = array();
            $val[0] = '20'; //Transaction Code
            $val[1] = $order->get('transaction_id');
            $val[31] = '338328338'; //Sender Code
            $val[4] = ''; //Sender Company Name
            $val[32] = 'LIU SI'; //Sender Contact Name
            $val[5] = 'ROOM A 1503,ZHANQIAN ROAD NO.11-1'; //Sender Address 1
            $val[6] = 'YUE XIU DISTRICT'; //Sender Address 2
            $val[7] = 'GUANGZHOU'; //Sender City
            $val[9] = '510010'; //Sender Postal Code
            $val[117] = 'CN'; //Sender Country
            $val[183] = '15915719101'; //Sender Phone Number
            $val[10] = '338328338'; //Sender FedEx Account#
            $val[1150] = ''; //SENDER SIGNATURE
            $val[11] = ''; //RECIPIENT COMPANY;
            $val[12] = ''; //RECIPIENT CONTACT
            $val[50] = $order->get('shipping_country'); //Recipient Country
            $val[13] = $order->get('shipping_address'); //RECIPIENT ADDRESS LINE 1
            $val[16] = $order->get('shipping_state'); //Recipient State/ Province Code
            $val[15] = $order->get('shipping_city'); //RECIPIENT CITY
            $val[17] = $order->get('shipping_zip'); //Recipient Postal Code
            $val[18] = $order->get('shipping_phone'); //Recipient phone number
            $val[21] = $item['weight']; //Package Weight
            $val[23] = 1; //Transportation Pay Type
            $val[26] = $item['declared_value']; //Carriage/ Declared Value
            $val[70] = 2; //Duty/Tax Payment Type
            $val[71] = ''; //Duty/Tax Payer Account Number
            $val[1274] = '1'; //Service Type
            $val[1273] = '02'; //Packaging Type
            $val[116] = $item['quantity']; //Number of Packages
            $val[75] = 'KGS'; //Weight Type
            $val[68] = $order->get('currency'); //Currency
            $val[79] = $item['description']; //Package Description
            $val[113] = 'Y'; //Commercial Invoice:Enter Y to create/ print a commercial invoice
            $val[99] = '';
            $fedexs[$item['ordernum']] = $val;
        }
        $filename = 'fedex_shipment_' . date('Ymd');
        header('Content-type: text/plain');
        header('Content-Disposition: attachment; filename="' . $filename . '.in"'); //以.in作为文件名后缀可以自动被FedEx的“交易监听器”监听并处理
        foreach ($fedexs as $fedex)
        {
            foreach ($fedex as $key => $fed)
            {
                echo $key . ',"' . $fed . '"';
            }
            echo "\n";
        }

        readfile("$filename");
        exit;
    }

    public function action_product_attributes()
    {
        if ($_POST)
        {
            $sku = Arr::get($_POST, 'sku', '');
            $id = Product::get_productId_by_sku($sku);
            if ($id)
            {
                $attr = Product::instance($id)->get('attributes');
                if (empty($attr) OR !$attr)
                {
                    $attr = array('Size' => array('one size'));
                }
                $attributes = '';
                foreach ($attr as $name => $val)
                {
                    $attributes .= '<label>' . ucfirst($name) . ':</label><select name="attributes[' . $name . ']" style="width:250px;margin:10px 0">';
                    foreach ($val as $v)
                    {
                        $attribute = $v;
                        $attributes .= '<option value="' . $attribute . '">' . $attribute . '</option>';
                    }
                    $attributes .= '</select>';
                }
                echo json_encode($attributes);
            }
            else
            {
                echo json_encode(0);
            }
        }
        exit;
    }

    public function action_sis()
    {
        $content = View::factory('admin/site/order/sis')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_sis_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "1";
        $daterange = "1";
        $order_sql = '';
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                if ($item->field == 'date')
                {
                    $date = explode(' to ', $item->data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $daterange = $item->field . " between " . $from . " and " . $to;
                    $_filter_sql[] = $daterange;
                }
                else
                    $_filter_sql[] = "`" . $item->field . "`='" . $item->data . "'";
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $count = DB::query(DATABASE::SELECT, 'SELECT COUNT(id) AS num FROM `order_sis` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql)->execute('slave')->get('num');
        $total_pages = 0;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM order_sis
		WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql . ' GROUP BY id ' . $order_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        foreach ($result as $data)
        {
            //已囤货数量，已囤未到数量
            if ($data['email'])
            {
                $count = DB::query(Database::SELECT, 'SELECT COUNT(id) AS count FROM order_sis 
                                        WHERE site_id = ' . $this->site_id . ' AND email = "' . $data['email'] . '" AND ' . $daterange)
                        ->execute('slave')->get('count');
            }
            else
                $count = 0;
            $responce['rows'][$k]['id'] = $data['id'];
            $responce['rows'][$k]['cell'] = array(
                $data['id'],
                $data['sid'],
                $data['email'],
                date('Y-m-d', $data['date']),
                $data['skus'],
                round($data['amount'], 2),
                $data['from'],
                round($data['shipping'], 2),
                $count
            );
            $k++;
        }
        echo json_encode($responce);
    }

    public function action_sis_upload()
    {
        $file_types = array(
            "application/vnd.ms-excel",
            "text/csv",
            "application/csv",
            "text/comma-separated-values",
            "application/octet-stream",
            "application/oct-stream"
        );
        if (!isset($_FILES) || (!in_array($_FILES["file"]["type"], $file_types)))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $admin = Session::instance()->get('user_id');
        $success = 0;
        $site_id = $this->site_id;
        while ($data = fgetcsv($handle))
        {
            if (!is_numeric(trim($data[0])))
            {
                $row++;
                continue;
            }
            try
            {
                $data = Security::xss_clean($data);
                $values = array();
                $values['sid'] = (int) $data[0];
                $values['email'] = trim($data[1]);
                $values['skus'] = (int) $data[2];
                $values['amount'] = str_replace(array('$', '£', '€'), array('', '', ''), $data[3]);
                $values['shipping'] = str_replace(array('$', '£', '€'), array('', '', ''), $data[4]);
                $values['from'] = trim($data[5]);
                $values['date'] = strtotime($data[6]);
                $values['site_id'] = $site_id;
                if ($values['skus'] AND $values['amount'])
                {
//                    $has = DB::select('id')->from('order_sis')->where('sid', '=', $values['sid'])->execute('slave')->get('id');
//                    if($has)
//                        $result = DB::update('order_sis')->set($values)->where('id', '=', $has)->execute();
//                    else
                        $result = DB::insert('order_sis', array_keys($values))->values($values)->execute();
                }
                if ($result)
                    $success++;
                $row++;
            }
            catch (Exception $e)
            {
                $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                $row++;
            }
        }
        die("Upload " . $success . " data successfully.");
    }

    public function action_sis_delete()
    {
        $id = (int) $this->request->param('id');
        $delete = DB::delete('order_sis')->where('id', '=', $id)->execute();
        if ($delete)
            message::set('Delete Data Success!', 'success');
        else
            message::set('Delete Data Failed!', 'error');
        $this->request->redirect('/admin/site/order/sis');
    }

    public function action_sis_report()
    {
        $type = $this->request->param('id');
        if ($_POST)
        {
            $from = Arr::get($_POST, 'from', '');
            $to = Arr::get($_POST, 'to', '');
            $this->request->redirect('/admin/site/order/sis_report/'.$type.'?from=' . strtotime($from) . '&to=' . strtotime($to . ' +1 day -1 second'));
        }
        $content = View::factory('admin/site/order/sis_report')->set('type', $type)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_sis_report_data()
    {
        $from = Arr::get($_GET, 'from', '');
        $to = Arr::get($_GET, 'to', '');
        if (!$from OR !$to)
        {
            exit;
        }
        $type = $this->request->param('id');
        $sql = '';
        if($type)
            $sql = ' AND shipping >= 1000';
        else
            $sql = ' AND shipping < 1000';
        $daterange = ' date >= ' . $from . ' AND date < ' . $to;
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "1";
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                $_filter_sql[] = "`" . $item->field . "`='" . $item->data . "'";
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $count = DB::query(DATABASE::SELECT, 'SELECT COUNT(DISTINCT `from`) AS num FROM `order_sis` WHERE site_id=' . $this->site_id . $sql . ' 
                        AND ' . $daterange . $filter_sql)->execute('slave')->get('num');
        $total_pages = 0;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT DISTINCT `from` FROM order_sis
                        WHERE site_id=' . $this->site_id . $sql . ' AND ' . $daterange
                . $filter_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        $total = array(
            'orders' => 0,
            'amounts' => 0,
            'shippings' => 0,
            'quantitys' => 0,
            'celebrity' => 0,
            'cele_skus' => 0
        );
        foreach ($result as $data)
        {
            $orders = DB::query(Database::SELECT, 'SELECT COUNT(id) AS count FROM order_sis WHERE `from` = "' . $data['from'] . '" AND ' . $daterange . $sql)->execute('slave')->get('count');
            $amounts = DB::query(Database::SELECT, 'SELECT SUM(amount) AS sum FROM order_sis WHERE `from` = "' . $data['from'] . '" AND ' . $daterange . $sql)->execute('slave')->get('sum');
            $o_amounts = $orders ? round($amounts / $orders, 2) : 0;
            $shippings = DB::query(Database::SELECT, 'SELECT SUM(shipping) AS sum FROM order_sis WHERE `from` = "' . $data['from'] . '" AND ' . $daterange . $sql)->execute('slave')->get('sum');
            $o_shippings = $orders ? round($shippings / $orders, 2) : 0;
            $quantitys = DB::query(Database::SELECT, 'SELECT SUM(skus) AS sum FROM order_sis WHERE `from` = "' . $data['from'] . '" AND ' . $daterange . $sql)->execute('slave')->get('sum');
            $o_quantitys = $orders ? round($quantitys / $orders, 2) : 0;
            $celebrity = DB::query(Database::SELECT, 'SELECT count(id) AS sum FROM order_sis WHERE amount = 0 AND `from` = "' . $data['from'] . '" AND ' . $daterange . $sql)->execute('slave')->get('sum');
            $cele_skus = DB::query(Database::SELECT, 'SELECT SUM(skus) AS sum FROM order_sis WHERE amount = 0 AND `from` = "' . $data['from'] . '" AND ' . $daterange . $sql)->execute('slave')->get('sum');
            $emails = DB::query(Database::SELECT, 'SELECT COUNT(DISTINCT email) AS sum FROM order_sis WHERE `from` = "' . $data['from'] . '" AND amount <> 0' . $sql)->execute('slave')->get('sum');
            if ($emails > 1)
            {
                $repeats = DB::query(Database::SELECT, 'SELECT email FROM `order_sis` WHERE `from` = "' . $data['from'] . '" AND ' . $daterange . $sql . ' AND amount <> 0 GROUP BY email HAVING COUNT(email) > 1')->execute('slave')->as_array();
                $repeat = count($repeats);
            }
            else
                $repeat = 0;
            $repeats = round($repeat / $emails, 4);
            $total['orders'] += $orders;
            $total['amounts'] += $amounts;
            $total['shippings'] += $shippings;
            $total['quantitys'] += $quantitys;
            $total['celebrity'] += $celebrity;
            $total['cele_skus'] += $cele_skus;

            $responce['rows'][$k]['id'] = $k;
            $responce['rows'][$k]['cell'] = array(
                $k,
                $data['from'],
                $orders,
                $amounts,
                $o_amounts,
                $shippings,
                $o_shippings,
                $quantitys,
                $o_quantitys,
                $celebrity,
                $cele_skus,
                $repeats
            );
            $k++;
        }
        $total_emails = DB::query(Database::SELECT, 'SELECT COUNT(DISTINCT email) AS sum FROM order_sis WHERE amount <> 0' . $sql)->execute('slave')->get('sum');
        if ($total_emails > 1)
        {
            $total_repeats = DB::query(Database::SELECT, 'SELECT email FROM `order_sis` WHERE amount <> 0 AND ' . $daterange . $sql . ' GROUP BY email HAVING COUNT(email) > 1')->execute('slave')->as_array();
            $total_repeat = count($total_repeats);
        }
        else
            $total_repeat = 0;
        $responce['rows'][$k]['id'] = $k;
        $responce['rows'][$k]['cell'] = array(
            $k,
            'Total',
            $total['orders'],
            $total['amounts'],
            $total['orders'] ? round($total['amounts'] / $total['orders'], 2) : 0,
            $total['shippings'],
            $total['orders'] ? round($total['shippings'] / $total['orders'], 2) : 0,
            $total['quantitys'],
            $total['orders'] ? round($total['quantitys'] / $total['orders'], 2) : 0,
            $total['celebrity'],
            $total['cele_skus'],
            round($total_repeat / $total_emails, 4)
        );
        echo json_encode($responce);
    }

    //显示该段时间内采购后台验证时间为空的sku缩略图
    public function action_noConfirmDate()
    {
        if (!$_POST)
        {
            die('invalid request');
        }
        //开始时间
        $date = strtotime(Arr::get($_POST, 'date', 0));
        $date += 28800; /* 8 hours */
        //结束时间
        $date_end = Arr::get($_POST, 'date_end', 0);
        if ($date_end)
        {
            $date_end = strtotime($date_end);
            $date_end += 28800;
        }
        else
        {
            $date_end = $date + 86400;
        }

        $items = DB::query(DATABASE::SELECT, "select O.sku,P.id product_id,P.`name`,P.`link` from `order_purchase` O left join `products` P on O.`sku`=P.`sku` 
                where O.`pay_time` is null and O.`is_error`=0 and O.`created`>" . $date . " and O.`created`<" . $date_end . " order by O.sku ")->execute('slave');

        $content = View::factory('admin/site/order/noConfirmDate')
            ->set('items', $items)
            ->set('date', Arr::get($_POST, 'date'))
            ->set('date_end', Arr::get($_POST, 'date_end', ''))
            ->render();

        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
    }

    public function action_email_edit()
    {
        if ($_POST)
        {
            $success = array();
            $email = trim(Arr::get($_POST, 'email', 0));
            $customer_id = DB::select('id')->from('accounts_customers')->where('email', '=', $email)->execute('slave')->get('id');
            if (!$customer_id)
                die('This email is not our customer!');
            $orders = Arr::get($_POST, 'orders', array());
            foreach ($orders as $ordernum)
            {
                $order_id = Order::get_from_ordernum($ordernum);
                $order_email = Order::instance($order_id)->get('email');
                $update = DB::update('orders_order')->set(array('customer_id' => $customer_id, 'email' => $email))->where('id', '=', $order_id)->execute();
                if ($update)
                {
                    $success[] = $ordernum;
                    Order::instance($order_id)->add_history(array(
                        'order_status' => 'edit email',
                        'message' => 'Change ' . $order_email . ' TO ' . $email,
                    ));
                }
            }
            echo count($success) . ' orders edit email successfully: <br>';
            echo implode("\n", $success);
            exit;
        }
    }

public function action_export_detail()
    {
        if ($_POST)
        {
            $countries = Site::instance()->countries();
            $payment_status = "'verify_pass'";
            $date = strtotime(Arr::get($_POST, 'from', 0));
            // 添加更新结束时间
            $date_end = Arr::get($_POST, 'to', 0);

            if ($date_end)
            {
                $file_name = "orders-detail-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
            $date_end = strtotime($date_end);
            $date_end;
            }
            else
            {
                $file_name = "orders-detail-" . date('Y-m-d', $date) . ".csv";
                $date_end = $date + 86400;
            }

            $type = Arr::get($_POST, 'type', 0);
            if ($type == 0)
            {
                $conditions = array(
                    "o.is_active = 1",
                    "o.payment_status = $payment_status",
                    "o.created >= $date",
                    "o.created < $date_end",
                );

                $sets = array();
                $set_data = DB::select('id', 'name')->from('sets')->where('site_id', '=', $this->site_id)->execute('slave');
                foreach ($set_data as $val)
                {
                    $sets[$val['id']] = $val['name'];
                }

                $admins = array();
                $users = DB::select('id', 'name')->from('auth_user')->where('active', '=', 1)->execute('slave');
                foreach($users as $user)
                {
                    $admins[$user['id']] = $user['name'];
                }

                $where_clause = implode(' AND ', $conditions);
                $result = DB::query(DATABASE::SELECT, 'SELECT o.ordernum, o.created, o.verify_date, o.email, o.customer_id, o.amount, o.currency, o.amount_shipping, o.coupon_code, o.amount_coupon, o.points, o.amount_point, o.shipping_country,i.product_id, i.sku, i.attributes,i.quantity, i.price,o.payment_status,o.order_insurance, p.set_id, p.price AS p_price, p.total_cost, p.weight, p.offline_picker,p.display_date FROM order_items i INNER JOIN orders o ON i.order_id=o.id INNER JOIN products p ON i.product_id = p.id WHERE ' . $where_clause . ' ORDER BY o.created')->execute('slave');

                header("Content-type:application/vnd.ms-excel; charset=UTF-8");
                header('Content-Disposition: attachment; filename="' . $file_name . '"');
                echo "\xEF\xBB\xBF" . "下单时间,付款状态,验证通过时间,订单号,是否红人单,邮箱,国家,Currency,订单总额,邮费,折扣号码,折扣号减免金额,使用积分,积分减免金额,购买产品sku,购买尺码,sku上架时间,选款人,所属set,Product Price,Price（销售价）,成本,重量,数量,运费险\n";
                foreach ($result as $data)
                {
                    echo date('Y-m-d H:i:s', $data['created']) . ',';
                    echo $data['payment_status'].',';
                    echo empty($data['verify_date']) ? '' . ',' : date('Y-m-d H:i:s', $data['verify_date']) . ',';
                    echo $data['ordernum'] . ',';
                    $is_celebrity = Customer::instance($data['customer_id'])->is_celebrity();
                    echo $is_celebrity ? $is_celebrity . ',' : '0,';
                    echo $data['email'] . ',';
                    echo $data['shipping_country'] . ',';
                    echo $data['currency'] . ',';
                    echo $data['amount'] . ',';
                    echo $data['amount_shipping'] . ',';
                    echo $data['coupon_code'] . ',';
                    echo $data['amount_coupon'] . ',';
                    echo $data['points'] . ',';
                    echo $data['amount_point'] . ',';
                    echo $data['sku'] . ',';
                    $att = explode(':', $data['attributes']);
                    $attributes = trim(substr($att[1], 0, -1));
                    echo $attributes . ',';
					echo empty($data['display_date']) ? '' . ',' : date('Y-m-d H:i:s', $data['display_date']) . ',';
                    echo isset($admins[$data['offline_picker']]) ? $admins[$data['offline_picker']] . ',' : '' . ',';
                    echo isset($sets[$data['set_id']]) ? $sets[$data['set_id']] . ',' : '' . ',';
                    echo $data['p_price'] . ',';
                    echo $data['price'] . ',';
                    echo $data['total_cost'] . ',';
                    echo $data['weight'] . ',';
                    echo $data['quantity'] . ',';
                    echo $data['order_insurance'] . ',';
                    echo "\n";
                }
            }
            elseif($type == 2)
            {
                $conditions = array(
                    "o.is_active = 1",
                    "o.payment_status = $payment_status",
                    "o.verify_date >= $date",
                    "o.verify_date < $date_end",
                );

                $sets = array();
                $set_data = DB::select('id', 'name')->from('sets')->where('site_id', '=', $this->site_id)->execute('slave');
                foreach ($set_data as $val)
                {
                    $sets[$val['id']] = $val['name'];
                }

                $admins = array();
                $users = DB::select('id', 'name')->from('auth_user')->where('active', '=', 1)->execute('slave');
                foreach($users as $user)
                {
                    $admins[$user['id']] = $user['name'];
                }

                $where_clause = implode(' AND ', $conditions);
                $result = DB::query(DATABASE::SELECT, 'SELECT o.ordernum, o.created, o.verify_date, o.email, o.customer_id, o.amount, o.currency, o.amount_shipping, o.coupon_code, o.amount_coupon, o.points, o.amount_point, o.shipping_country,i.product_id, i.sku, i.attributes,i.quantity, i.price,o.payment_status,o.order_insurance, p.set_id, p.price AS p_price, p.total_cost, p.weight, p.offline_picker,p.display_date FROM order_items i INNER JOIN orders o ON i.order_id=o.id INNER JOIN products p ON i.product_id = p.id WHERE ' . $where_clause . ' ORDER BY o.verify_date')->execute('slave');

                header("Content-type:application/vnd.ms-excel; charset=UTF-8");
                header('Content-Disposition: attachment; filename="' . $file_name . '"');
                echo "\xEF\xBB\xBF" . "下单时间,付款状态,验证通过时间,订单号,是否红人单,邮箱,国家,Currency,订单总额,邮费,折扣号码,折扣号减免金额,使用积分,积分减免金额,购买产品sku,购买尺码,sku上架时间,选款人,所属set,Product Price,Price（销售价）,成本,重量,数量,运费险\n";
                foreach ($result as $data)
                {
                    echo date('Y-m-d H:i:s', $data['created']) . ',';
                    echo $data['payment_status'].',';
                    echo empty($data['verify_date']) ? '' . ',' : date('Y-m-d H:i:s', $data['verify_date']) . ',';
                    echo $data['ordernum'] . ',';
                    $is_celebrity = Customer::instance($data['customer_id'])->is_celebrity();
                    echo $is_celebrity ? $is_celebrity . ',' : '0,';
                    echo $data['email'] . ',';
                    echo $data['shipping_country'] . ',';
                    echo $data['currency'] . ',';
                    echo $data['amount'] . ',';
                    echo $data['amount_shipping'] . ',';
                    echo $data['coupon_code'] . ',';
                    echo $data['amount_coupon'] . ',';
                    echo $data['points'] . ',';
                    echo $data['amount_point'] . ',';
                    echo $data['sku'] . ',';
                    $att = explode(':', $data['attributes']);
                    $attributes = trim(substr($att[1], 0, -1));
                    echo $attributes . ',';
                    echo empty($data['display_date']) ? '' . ',' : date('Y-m-d H:i:s', $data['display_date']) . ',';
                    echo isset($admins[$data['offline_picker']]) ? $admins[$data['offline_picker']] . ',' : '' . ',';
                    echo isset($sets[$data['set_id']]) ? $sets[$data['set_id']] . ',' : '' . ',';
                    echo $data['p_price'] . ',';
                    echo $data['price'] . ',';
                    echo $data['total_cost'] . ',';
                    echo $data['weight'] . ',';
                    echo $data['quantity'] . ',';
                    echo $data['order_insurance'] . ',';
                    echo "\n";
                }          
            }
            else
            {
                $conditions = array(
                    "o.is_active = 1",
                    "p.payment_status  = 'success'",
                    "p.created >= $date",
                    "p.created < $date_end",
                );
                $sets = array();
                $set_data = DB::select('id', 'name')->from('sets')->where('site_id', '=', $this->site_id)->execute();
                foreach ($set_data as $val)
                {
                    $sets[$val['id']] = $val['name'];
                }

                $where_clause = implode(' AND ', $conditions);
                $result = DB::query(DATABASE::SELECT, 'SELECT o.ordernum, o.created, o.email, o.customer_id, o.amount, o.currency, o.amount_shipping, o.coupon_code, o.amount_coupon, o.points, o.amount_point, o.ip,o.products,o.shipping_country,o.lang, o.payment_method,o.order_insurance, o.erp_fee_line_id, p.created AS p_created
                    FROM order_payments p LEFT JOIN orders o ON p.order_id=o.id WHERE ' . $where_clause . ' ORDER BY p.created')
                        ->execute('slave');

                header("Content-type:application/vnd.ms-excel; charset=UTF-8");
                header('Content-Disposition: attachment; filename="' . $file_name . '"');
                echo "\xEF\xBB\xBF" . "下单时间,支付时间,订单号,是否红人单,邮箱,Currency,订单总额,邮费,折扣号码,折扣号减免金额,使用积分,积分减免金额,IP,产品总数,发货国家,语言,支付方式,是否手机单,运费险\n";
                foreach ($result as $data)
                {
                    echo date('Y-m-d H:i:s', $data['created']) . ',';
                    echo date('Y-m-d H:i:s', $data['p_created']) . ',';
                    echo $data['ordernum'] . ',';
                    $is_celebrity = Customer::instance($data['customer_id'])->is_celebrity();
                    echo $is_celebrity ? $is_celebrity . ',' : '0,';
                    echo $data['email'] . ',';
                    echo $data['currency'] . ',';
                    echo $data['amount'] . ',';
                    echo $data['amount_shipping'] . ',';
                    echo $data['coupon_code'] . ',';
                    echo $data['amount_coupon'] . ',';
                    echo $data['points'] . ',';
                    echo $data['amount_point'] . ',';
                    echo long2ip($data['ip']) . ',';
                    $products = unserialize($data['products']);
                    echo count($products) . ',';
                    echo $data['shipping_country'] . ',';
                    echo $data['lang'] . ',';
                    echo $data['payment_method'] . ',';
                    echo $data['erp_fee_line_id'] . ',';
                    echo $data['order_insurance'] . ',';
                    echo "\n";
                }
            }
        }
    }
    
    public function action_payment_add()
    {
        if($_POST)
        {
            $data = array();
            $data['order_id'] = Arr::get($_POST, 'order_id', 0);
            $data['customer_id'] = Arr::get($_POST, 'customer_id', 0);
            $data['payment_method'] = Arr::get($_POST, 'payment_method', 'PPExpress');
            $data['trans_id'] = trim(Arr::get($_POST, 'trans_id', ''));
            $data['amount'] = Arr::get($_POST, 'amount', 0);
            if(!$data['amount'])
                $data['amount'] = Order::instance($data['order_id'])->get('amount');
            $data['currency'] = Arr::get($_POST, 'currency', '');
            if(!$data['currency'])
                $data['currency'] = Order::instance($data['order_id'])->get('currency');
            if($data['order_id'] AND $data['trans_id'] AND $data['amount'])
            {
                if($data['payment_method'] == 'PPExpress')
                {
                    $data['comment'] = 'Completed';
                }
                else
                {
                    $data['comment'] = 'Approved';
                }
                $data['site_id'] = $this->site_id;
                $data['created'] = time();
                $data['payment_status'] = 'success';
                $has_trans = DB::select('id')->from('orders_orderpayments')->where('site_id', '=', $this->site_id)->where('trans_id', '=', $data['trans_id'])->execute('slave')->get('id');
                if (!$has_trans)
                {
                    $insert = DB::insert('orders_orderpayments', array_keys($data))->values($data)->execute();
                    if ($insert)
                    {
                        Order::instance($data['order_id'])->add_history(array(
                            'order_status' => 'Add payment history',
                            'message' => $data['trans_id'],
                        ));
                        Message::set('Add payment history success', 'success');
                    }
                }
                else
                {
                    Message::set('Trans Id Duplicate', 'error');
                }
            }
        }
        $this->request->redirect('/admin/site/order/edit/'.$data['order_id'].'#order-edit-payment');
    }
    
    public function action_payment_delete()
    {
        $id = $this->request->param('id');
        if($id)
        {
            $data = DB::select()->from('orders_orderpayments')->where('id', '=', $id)->execute()->current();
            $delete = DB::delete('orders_orderpayments')->where('id', '=', $id)->execute();
            if($delete)
            {
                Order::instance($data['order_id'])->add_history(array(
                    'order_status' => 'Delete payment history',
                    'message' => $data['trans_id'],
                ));
                Message::set('Delete payment history success', 'success');
            }
            else
                Message::set('Delete payment history failed', 'error');
        }
        $this->request->redirect('/admin/site/order/edit/'.$data['order_id'].'#order-edit-payment');
    }
    
    public function action_search_ordernum()
    {
        if ($_POST)
        {
            $type = Arr::get($_POST, 'type', '');
            if($type == 'order')
            {
                $order_columns = array();
                $search = array();
                $columns = DB::query(1, 'SHOW COLUMNS FROM orders')->execute('slave');
                foreach ($columns as $c)
                {
                    $order_columns[] = $c['Field'];
                }
                foreach ($_POST as $name => $val)
                {
                    if (in_array($name, $order_columns) AND $val)
                    {
                        $search[] = $name . '="' . $val . '"';
                    }
                }
                if (!empty($search))
                {
                    $sql = implode(' AND ', $search);
                    $orders = DB::query(1, 'SELECT ordernum FROM orders WHERE ' . $sql . '')->execute('slave');
                    echo '<span style="color:red;">Ordernum:</span><br>';
                    foreach ($orders as $o)
                    {
                        echo $o['ordernum'] . '<br>';
                    }
                }
            }
            elseif($type == 'track')
            {
                $track = Arr::get($_POST, 'track_no', '');
                $order_id = DB::select('order_id')->from('orders_orderpayments')->where('trans_id', '=', $track)->execute('slave')->get('order_id');
                $ordernum = Order::instance($order_id)->get('ordernum');
                if($ordernum)
                {
                    echo '<span style="color:red;">Ordernum:</span>  '. $ordernum . '<br>';
                }
            }
        }
        echo '
<style type="text/css">
    .tbl-order-address input[type=text] {width:332px;}
</style>
<form action="" method="post">
    <input type="hidden" name="type" value="order" />
    <table class="tbl-order-address">
        <thead>
            <tr>
                <th scope="col" colspan="2">通过地址查询订单号</td>
            </tr>
        </thead>
        <tr>
            <td>First Name：</td>
            <td><input type="text" class="required" name="shipping_firstname" value=""/></td>
        </tr>
        <tr>
            <td>Last Name：</td>
            <td><input type="text" class="required" name="shipping_lastname" value=""/></td>
        </tr>
        <tr>
            <td>Address：</td>
            <td><input type="text" class="required" name="shipping_address" value=""/></td>
        </tr>
        <tr>
            <td>City：</td>
            <td><input type="text" class="required" name="shipping_city" value=""/></td>
        </tr>
        <tr>
            <td>State/Province：</td>
            <td><input type="text" class="required" name="shipping_state" value=""/></td>
        </tr>
        <tr>
            <td>Zip/Postal code：</td>
            <td><input type="text" class="required" name="shipping_zip" value=""/></td>
        </tr>
        <tr>
            <td>Country：</td>
            <td>
                <select class="required" name="shipping_country">
                    <option></option>';

        $countries = Site::instance()->countries();
        foreach ($countries as $c)
        {
            echo '<option value="' . $c['isocode'] . '">' . $c['name'] . '</option>';
        }

        echo '</select>
            </td>
        </tr>
        <tr>
            <td>Home Phone：</td>
            <td><input class="required" type="text" class="required" name="shipping_phone" value=""/></td>
        </tr>

        <tr>
            <td>Cell Phone：</td>
            <td><input type="text" name="shipping_mobile" value=""/></td>
        </tr>
        
        <tr>
            <td></td>
            <td colspan="2">
                <input type="submit" value="Search ordernum"/>
            </td>
        </tr>
    </table>
</form>

<form action="" method="post">
    <input type="hidden" name="type" value="track" />
    <table class="tbl-order-address">
        <thead>
            <tr>
                <th scope="col" colspan="2">通过交易号码查询订单号</td>
            </tr>
            <tr>
            <td>交易号码：</td>
            <td><input type="text" name="track_no" value=""/></td>
        </tr>
        
        <tr>
            <td></td>
            <td colspan="2">
                <input type="submit" value="Search ordernum"/>
            </td>
        </tr>
        </thead>
    </table>
</form>
';
    }

    public function action_globebill_check()
    {
        echo '
<form method="post" action="">
Ordernum:<br/>
<textarea name="orders" cols="40" rows="20"></textarea><br/>
<input type="submit" value="Submit" />
</form>
';
        if($_POST)
        {
            $correct_url = 'https://check.globebill.com/servlet/NormalCustomerCheck';
            // $correct_url = 'https://check.globebill.com/servlet/TestCustomerCheck';
            $merNo = 10470;
            $gatewayNo = 10470003;
            $signkey = '88080420';
            $signInfo = hash('sha256', $merNo . $gatewayNo . $signkey);
            $string = Arr::get($_POST, 'orders', '');
            $orders = explode("\n", $string);
            foreach($orders as $key => $o)
            {
                $payemntData = DB::select('payment_status', 'payment_method')->from('orders_order')->where('ordernum', '=', trim($o))->execute('slave')->current();
                if($payemntData['payment_status'] == 'success' OR $payemntData['payment_status'] == 'verify_pass' OR $payemntData['payment_method'] != 'GLOBEBILL')
                    unset($orders[$key]);
            }
            $orderNo = implode(',', $orders);
            $params = array(
                'merNo' => $merNo,
                'gatewayNo' => $gatewayNo,
                'orderNo' => $orderNo,
                'signInfo' => $signInfo,
            );
            $result_data = $this->socketPost($correct_url,$params);
            $xml = new DOMDocument();
            $xml->loadXML($result_data);
            
            $return_data = array();
            $statusArr = array(
                '-2'    => 'pending',
                '-1'    => 'pending',
                '0'     => 'failed',
                '1'     => 'success',
            );
            $domain = Site::instance()->get('domain');
            foreach ($orders as $key => $onum)
            {
                $ordernum = trim($onum);
                $return_data = array(
                    'merNo' => $xml->getElementsByTagName("merNo")->item($key)->nodeValue,
                    'gatewayNo' => $xml->getElementsByTagName("gatewayNo")->item($key)->nodeValue,
                    'tradeNo' => $xml->getElementsByTagName("tradeNo")->item($key)->nodeValue,
                    'tradeDate' => $xml->getElementsByTagName("tradeDate")->item($key)->nodeValue,
                    'orderNo' => $xml->getElementsByTagName("orderNo")->item($key)->nodeValue,
                    'tradeCurrency' => $xml->getElementsByTagName("tradeCurrency")->item($key)->nodeValue,
                    'tradeAmount' => $xml->getElementsByTagName("tradeAmount")->item($key)->nodeValue,
                    'sourceWebSite' => $xml->getElementsByTagName("sourceWebSite")->item($key)->nodeValue,
                    'authStatus' => $xml->getElementsByTagName("authStatus")->item($key)->nodeValue,
                    'queryResult' => $xml->getElementsByTagName("queryResult")->item($key)->nodeValue,
                );

                if(array_key_exists($return_data['queryResult'], $statusArr))
                {
                    $return_status = $statusArr[$return_data['queryResult']];
                }
                else
                {
                    echo $return_data['orderNo'] . ' No data<br>';
                    continue;
                }
                
                $orderData = DB::select()->from('orders_order')->where('ordernum', '=', $return_data['orderNo'])->execute('slave')->current();
                if($orderData['payment_status'] == 'success' OR $orderData['payment_status'] == 'verify_pass')
                    continue;

                
                if($orderData['payment_status'] != $return_status)
                {
                    $update = DB::update('orders_order')->set(array('payment_status' => $return_status))->where('id', '=', $orderData['id'])->execute();
                    if($update)
                    {
                        if($return_status == 'success')
                        {
                            //set success mail
                            $mail_params = array();
                            $mail_params['order_view_link'] = 'http://' . $domain . '/order/view/' . $orderData['ordernum'];
                            $mail_params['order_num'] = $orderData['ordernum'];
                            $mail_params['email'] = Customer::instance($orderData['customer_id'])->get('email');
                            $mail_params['firstname'] = Customer::instance($orderData['customer_id'])->get('firstname');
                            if(!$mail_params['firstname'])
                                $mail_params['firstname'] = 'customer';
                            $mail_params['order_product'] = 
                            '<table border="0" width="92%" style="color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; cursor: text;">
                                <tbody>
                                    <tr align="left">
                                        <td colspan="5"><strong>Product Details</strong></td>
                                    </tr>';
                            $customer_id = $orderData['customer_id'];
                            $celebrity_id = Customer::instance($customer_id)->is_celebrity();
                            $order_products = Order::instance($orderData['id'])->products();
                            $currency = Site::instance()->currencies($orderData['currency']);
                            foreach ($order_products as $rs)
                            {
                                $mail_params['order_product'] .= '<tr align="left">
                                                    <td>' . Product::instance($rs['item_id'])->get('name') . '</td>
                                                    <td>QTY:' . $rs['quantity'] . '</td>
                                                    <td>' . $rs['attributes'] . '</td>
                                                    <td>' . Site::instance()->price($rs['price'], 'code_view', NULL, $currency) . '</td>
                                            </tr>';
                            }
                            $mail_params['order_product'] .= '</tbody></table>';

                            $mail_params['currency'] = $orderData['currency'];
                            $mail_params['amount'] = round(Site::instance()->price($orderData['amount']),2);
                            $mail_params['pay_num'] = round($orderData['amount'],2);
                            $mail_params['pay_currency'] = $orderData['currency'];
                            $mail_params['shipping_firstname'] = $orderData['shipping_firstname'];
                            $mail_params['shipping_lastname'] = $orderData['shipping_lastname'];
                            $mail_params['address'] = $orderData['shipping_address'];
                            $mail_params['city'] = $orderData['shipping_city'];
                            $mail_params['state'] = $orderData['shipping_state'];
                            $mail_params['country'] = $orderData['shipping_country'];
                            $mail_params['zip'] = $orderData['shipping_zip'];
                            $mail_params['phone'] = $orderData['shipping_phone'];
                            $mail_params['shipping_fee'] = $orderData['amount_shipping'];
                            $mail_params['payname'] = '';
                            $mail_params['created'] = date('Y-m-d H:i', $orderData['created']);
                            $mail_params['points'] = floor($orderData['amount']);
                            if ($celebrity_id)
                            {
                                    Kohana_Log::instance()->add('SendMail', 'PAYSUCCESS');
                                    Mail::SendTemplateMail('BLOGGER PAYSUCCESS', $mail_params['email'], $mail_params);
                            }
                            else
                            {
                                    $quantity = DB::select('id')->from('orders_order')
                                            ->where('customer_id', '=', $customer_id)
                                            ->and_where('id', '<', $orderData['id'])
                                            ->and_where('payment_status', 'IN', array('success', 'verify_pass'))
                                            ->execute()->get('id');
                                    if($quantity)
                                    {
                                             $vip_level = Customer::instance($customer_id)->get('vip_level');
                                            $vip_return = DB::select('return')->from('vip_types')->where('level', '=', $vip_level)->execute()->get('return');

                                            $points = ($orderData['amount'] / $orderData['rate']) * $vip_return;
                                    }
                                    else
                                    {
                                            $points = 1000;
                                    }
                                    $mail_params['order_points'] = $points;
                                    Kohana_Log::instance()->add('SendMail', 'PAYSUCCESS');
                                    Mail::SendTemplateMail('PAYSUCCESS', $mail_params['email'], $mail_params);
                            }
                        }

                        $payment_log = array(
                            'site_id'        => $this->site_id,
                            'order_id'       => $orderData['id'],
                            'customer_id'    => $orderData['customer_id'],
                            'payment_method' => 'GLOBEBILL',
                            'trans_id'       => $return_data['tradeNo'],
                            'amount'         => $return_data['tradeAmount'],
                            'currency'       => $return_data['tradeCurrency'],
                            'comment'        => $return_data['queryResult'],
                            'cache'          => serialize($return_data),
                            'payment_status' => $return_status,
                            'ip'             => ip2long($orderData['ip']),
                            'created'        => strtotime($return_data['tradeDate']),
                            'first_name'     => $orderData['shipping_firstname'],
                            'last_name'      => $orderData['shipping_lastname'],
                            'email'          => $orderData['email'],
                            'address'        => $orderData['shipping_address'],
                            'zip'            => $orderData['shipping_zip'],
                            'city'           => $orderData['shipping_city'],
                            'state'          => $orderData['shipping_state'],
                            'country'        => $orderData['shipping_country'],
                            'phone'          => '',
                        );
                        Payment::instance('GLOBEBILL')->log($payment_log);
                        echo $return_data['orderNo'] . ' Update "' . $orderData['payment_status'] . '" to "' . $return_status . '"<br>';
                    }
                }
                
            }
            // print_r($return_data);exit;
        }
    }

    public function action_export_white_orders()
    {
        $now= getdate();
        $now_date=$now["year"]."-".$now["mon"]."-".$now["mday"];
        $from = strtotime($now_date)-3600*24*2;
        $to = $from+3600*24;
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="all_orders.csv"');
        echo "order num,create time,email,currency,amount,shipping country,phone,firstname,lastname,state,city\n";

        $orders = DB::query(DATABASE::SELECT, "
            SELECT * 
            FROM 
                (
                SELECT DISTINCT(email) email,ordernum,FROM_UNIXTIME(created) created,currency,amount,shipping_country,shipping_phone,shipping_firstname,shipping_lastname,shipping_state,shipping_city 
                FROM orders
                WHERE created>=".$from." AND created<=".$to." AND payment_status='new'
                ) A 
            WHERE A.email NOT IN (
                SELECT DISTINCT(email) email 
                FROM orders
                WHERE created>=".$from." AND payment_status IN ('pending','success','verify_pass')
                ) 
            ORDER BY created")->execute('slave');
        foreach ($orders as $order)
        {
            $admin_id = DB::select('admin')->from('celebrities_celebrits')->where('email', '=', $order['email'])->execute('slave')->get('admin');
            if ($admin_id){
                continue;
            }
            echo $order['ordernum'], ',';
            echo $order['created'], ',';
            echo $order['email'], ',';
            echo $order['currency'], ',';
            echo $order['amount'], ',';
            echo $order['shipping_country'], ',';
            echo $order['shipping_phone'], ',';
            echo $order['shipping_firstname'], ',';
            echo $order['shipping_lastname'], ',';
            echo $order['shipping_state'], ',';
            echo $order['shipping_city'], ',';
            echo PHP_EOL;
        }
        
    }

    public function action_export_gc_failed()
    {
        if($_POST)
        {
            $date = strtotime(Arr::get($_POST, 'start', 0));
            // $date += 28800; /* 8 hours */     
            // 添加更新结束时间
            $date_end = Arr::get($_POST, 'end', 0);

            if ($date_end)
            {
                $file_name = date('Y-m-d', $date) . '_' . $date_end . ".csv";
                $date_end = strtotime($date_end);
                // $date_end += 28800;
            }
            else
            {
                $file_name = date('Y-m-d', $date) . ".csv";
                $date_end = $date + 86400;
            }

            $filter_sql = ' created BETWEEN ' . $date . ' AND ' . $date_end;

            $submit = Arr::get($_POST, 'submit', '');
            if($submit == '导出GC支付失败详情')
            {
                $filter_sql .= ' AND payment_status = "failed" ';
                $file_name = "orders_gc_failed-" . $file_name;
            }
            else
            {
                $file_name = "orders_gc_all-" . $file_name;
            }

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $file_name . '"');
            echo "order_id,trans_id,payment_method,amount,currency,created,payment_status,comment\n";
            $result = DB::query(Database::SELECT, 'SELECT order_id, trans_id, payment_method, amount, currency, created, payment_status, comment FROM order_payments WHERE payment_method = "GlobalCollect"  AND ' . $filter_sql)->execute('slave');
            foreach($result as $data)
            {
                echo $data['order_id'] . ',';
                echo $data['trans_id'] . ',';
                echo $data['payment_method'] . ',';
                echo $data['amount'] . ',';
                echo $data['currency'] . ',';
                echo date('Y-m-d H:i:s', $data['created']) . ',';
                echo $data['payment_status'] . ',';
                echo $data['comment'] . ',';
                echo PHP_EOL;
            }
        }
    }

    function socketPost($url, $data)
    {
        $post_variables = http_build_query($data);
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl,CURLOPT_HEADER, 0 ); // 过滤HTTP头
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
        curl_setopt($curl,CURLOPT_POST,true); // post传输数据
        curl_setopt($curl,CURLOPT_POSTFIELDS,$post_variables);// post传输数据
        $xmlrs = curl_exec($curl);
        curl_close ( $curl );
        return $xmlrs;
    }

    public function action_add_item2order(){
        if ($_POST){
            $ordernums = Arr::get($_POST, 'ordernum', 0);
            $ordernum_arr = explode("\n",$ordernums);
            $error_msg = "";
            $product_info = DB::query(DATABASE::SELECT,"select * FROM `products_product` where `sku`='".trim($_POST['sku'])."'")
                ->execute('slave')->current();
            if($product_info){
                foreach ($ordernum_arr as $ordernum) {
                    //++++验证处理，禁止添加产品：order,  order_purchase
                    $order = DB::select()->from('orders_order')->where('ordernum', '=', $ordernum)->execute('slave')->current();
                    if ($order['shipping_status'] == 'shipped' || $order['shipping_status'] == 'delivered'){
                        $error_msg.=$ordernum."已发运，无法添加产品，请重新下单|";
                        continue;
                    }

                    if ($order){
                        $data['site_id'] = $this->site_id;
                        $data['product_id'] = $product_info['id'];
                        $data['order_id'] = $order['id'];
                        $data['item_id'] = $product_info['id'];
                        $data['name'] = $product_info['name'];
                        $data['sku'] = $product_info['sku'];
                        $data['link'] = Product::instance($product_info['id'])->permalink();
                        $data['price'] = $product_info['price'];
                        $data['cost'] = $product_info['cost'];
                        $data['created'] = time();
                        $data['weight'] = 0;
                        $data['quantity'] = 1;
                        $data['key'] = $product_info['id'].'_'.$product_info['type'].'_'.md5(serialize($product_info['id'])).(isset($_POST['attribute']) ? '_'.md5(serialize($_POST['attribute'])) : '');;
                        $data['is_gift'] = 0;
                        $data['customize'] = '';
                        $data['attributes'] = $_POST['attribute'];
                        $data['tracking_number'] = '';
                        $data['tracking_link'] = '';
                        $data['erp_line_status'] = '';

                        $insert = DB::insert('order_items', array_keys($data))->values(array_values($data))->execute();
                    }
                    if (isset($insert) && $insert){
                        $error_msg .= $ordernum.'创建成功|';
                    }else{
                        $error_msg .= $ordernum.'创建失败|';
                    }
                }
            }else{
                $error_msg.="无产品";
            }
            
            Message::set($error_msg);
            $this->request->redirect('/admin/site/order/list');
        }
        $content = View::factory('admin/site/order/add_item2order')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_ajax_item(){
        $sku = Arr::get($_POST, 'sku', 0);

        $data = array();
        $product = DB::select()->from('products_product')->where('sku', '=', $sku)->execute('slave')->current();
        if (!empty($product['attributes'])){
            $attribute = unserialize($product['attributes']);

            if (isset($attribute['Size']) && is_array($attribute['Size'])){
                foreach ($attribute['Size'] as $key => $val){
                    if (strpos($val, 'EUR')){
                        $data[] = 'Size: ' . substr($val, strpos($val, 'EUR') + 3, 2) . ';';
                    }else{
                        $data[] = 'Size: ' . $val . ';';
                    }
                }
            }elseif (isset($attribute['size']) && is_array($attribute['size'])){
                foreach ($attribute['size'] as $key => $val){
                    if (strpos($val, 'EUR')){
                        $data[] = 'Size: ' . substr($val, strpos($val, 'EUR') + 3, 2) . ';';
                    }else{
                        $data[] = 'Size: ' . $val . ';';
                    }
                }
            }
        }
        echo json_encode($data);
    }

    public function action_ajax_stock(){
        $sku = $_POST['sku'];
        $att = $_POST['attr'];

        if (strpos($att, 'one') != false) 
            $attributes = 'Size:one size;';
        else
            $attributes = str_replace(array(': ', ' ;'), array(':', ';'), $att);
        $stock = DB::query(Database::SELECT, 'SELECT SUM(quantity) AS sum FROM order_instocks WHERE `status`=0 and sku="' . $sku
            . '" AND attributes="' . $attributes . '"')->execute('slave')->get('sum');

        $product = DB::select()->from('products_product')->where('sku', '=', $sku)->where('site_id', '=', $this->site_id)->execute('slave')->current();
        $taobao = stristr($product['taobao_url'], 'http:') ? '淘宝:' . $product['taobao_url'] : '线下:' . $product['taobao_url'];

        $html = $stock >= 1 ? '库存:' . $stock . '; ' . $taobao : $taobao;
        echo json_encode($html);
    }
    
    //小语种订单信息导出 : 订单号、创建时间、payment_status、付款时间、邮箱、shipping country、姓名、地址、lang（语言）、amount（订单金额）、rate（汇率）、SKU、所属set、销售价、数量/products
    public function action_order_langGo()
    {
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        #开始下载CSV
        header('Content-type:text/html;charset=GBK');//设定编码，防止js输出乱码。
        header('Content-type:application/vnd.ms-excel');//输出的类型
        header('Content-Disposition: attachment; filename="order_invoice'.date('ymd').'.csv"'); //下载显示
        echo iconv("UTF-8", "GBK//IGNORE",'订单号,创建时间,支付状态,付款时间,邮箱,配送国家,地址,语言,订单金额,汇率,SKU,所属set,销售价,数量,姓名'."\r\n");
        $orderListInfo = DB::query(Database::SELECT, 'select o.id,o.ordernum,o.created,o.payment_status,o.payment_date,o.email,o.shipping_country,o.shipping_address,o.shipping_firstname,o.shipping_lastname,o.lang,o.amount_order,o.rate,item.product_id,item.price,item.quantity,item.sku from orders as o,order_items as item where lang != "" and o.id = item.order_id order by id desc')->execute()->as_array();
        foreach ($orderListInfo as $v) 
        {
            $proInfo = Product::instance($v['product_id']);
            $set = $proInfo->get('set_id');
            $setnames = Set::instance($set)->get('name');
            $address = str_replace(PHP_EOL , '', $v['shipping_address']);
            $address = str_replace(',', '', $address);
            $created = date('Y-m-d H:i:s', $v['created']);
            echo iconv("UTF-8", "GBK//IGNORE", ($v['ordernum'].','.$created.','.$v['payment_status'].','.$v['payment_date'].','.$v['email'].','.$v['shipping_country'].','.$address.','.$v['lang'].','.$v['amount_order'].','.$v['rate'].','.$v['sku'].','.$setnames.','.$v['price'].','.$v['quantity'].','.$v['shipping_firstname'])."\r\n");
        }
    }

    public function action_select_ordernum_by_tracking_code()
    {
        $tcds = Arr::get($_POST, 'ORDERIDS', '');
        
        
        if (!$tcds)
        {
            echo 'Sku cannot be empty';
            exit;
        }
        else
        {
            echo '<table cellspacing="1" cellpadding="5" border="0">';
            echo '<tr><td width="100px">tracking_code</td><td width="100px">ordernum</td></tr>';
            $tcdArr = explode("\n", $tcds);
            foreach ($tcdArr as $tcd)
            {
                $tcd = trim($tcd);
                $info = DB::query(DATABASE::SELECT,"SELECT ordernum FROM `orders_ordershipments` WHERE tracking_code='".$tcd."' limit 1")
                    ->execute('slave');
                $ordernum = isset($info[0]['ordernum'])?$info[0]['ordernum']:"null";
                
                echo '<tr><td>' . $tcd. '</td><td>' .$ordernum. '</td></tr>';
            }
            echo '</table>';
        }
    }

    public function action_select_tracking_code_by_ordernum()
    {

        if($_POST)
        {
            $tcds = Arr::get($_POST, 'ORDERIDS', '');
            
            
            if (!$tcds)
            {
                echo 'ordernum cannot be empty';
                exit;
            }
            else
            {
                echo '<table cellspacing="1" cellpadding="5" border="0">';
                echo '<tr><td width="100px">ordernum</td><td width="100px">tracking_code</td><td width="100px">tracking_link</td></tr>';
                $tcdArr = explode("\n", $tcds);
                foreach ($tcdArr as $tcd)
                {
                    $tcd = trim($tcd);
                    $info = DB::query(DATABASE::SELECT,"SELECT tracking_code,tracking_link FROM `orders_ordershipments` WHERE ordernum='".$tcd."' order by id desc limit 1")
                        ->execute('slave');

                    $tracking_code = isset($info[0]['tracking_code'])?$info[0]['tracking_code']:"null";
                    $tracking_code = '\''.$tracking_code;
                    $tracking_link = isset($info[0]['tracking_link'])?$info[0]['tracking_link']:"null";
                    
                    echo '<tr><td>' . $tcd. '</td><td>' .$tracking_code. '</td><td>' .$tracking_link. '</td></tr>';
                }
                echo '</table>';
            }   
            die;         
        }  

        echo '<form action="" method="post">
            <table class="tbl-order-address">
                <thead>
                    <tr>
                        <th scope="col" colspan="2">通过ordernum批量查询物流信息</td>
                    </tr>
                    <tr>
                    <td>一行一个ordernum：</td>
                    <textarea name="ORDERIDS"  cols="30" rows="15" ></textarea>
                </tr>
                
                <tr>
                    <td></td>
                    <td colspan="2">
                        <input type="submit" value="select"/>
                    </td>
                </tr>
                </thead>
            </table>
        </form>';

    }

    public function action_sofortfind()
    {

        if($_POST){
            $SKUs = Arr::get($_POST, 'SKUARR', '');
            $skuArr = explode("\n", $SKUs);
        $order_row =DB::select('id','ip','ordernum')
                ->from('orders_order')
                ->where('ordernum', 'IN', $skuArr)
                ->execute('slave')
                ->as_array();

        if($order_row)
        {
                    $d = '';  //success ordernum
            foreach ($order_row as $key => $v) 
            {
                $return_data = $this->curl_pay($v['id'],long2ip($v['ip']));

                $return_data = $return_data['REQUEST'];
                if (!empty($return_data['RESPONSE']))
                {
                    $return_order = $return_data['PARAMS']['ORDER'];
                    $order_id = $return_order['ORDERID'];
                    $order = Order::instance($order_id)->get();

                    $result = $return_data['RESPONSE']['RESULT'];
                    $message = '';
                    if(isset($return_data['RESPONSE']['ERROR']))
                    {
                        $errors = $return_data['RESPONSE']['ERROR'];
                        if(isset($errors[0]))
                        {
                            $message = $errors[0]['CODE'] . ':' . $errors[0]['MESSAGE'];
                        }
                        else
                        {
                            $message = $errors['CODE'] . ':' . $errors['MESSAGE'];
                        }
                    }
                    $data = array();
                    $data['order_id'] = $order_id;
                    $data['trans_id'] = $return_data['RESPONSE']['STATUS']['MERCHANTREFERENCE'];
                    $statusid = $return_data['RESPONSE']['STATUS']['STATUSID'];
                    $data['statusid'] = $statusid;

                    if($result == 'OK')
                    {
                        if($statusid >= 1000 OR $statusid == 525)
                        {
                            $data['succeed'] = 1;
                        }
                        else
                        {
                            $data['succeed'] = 0;
                            if(!empty($return_data['RESPONSE']['STATUS']['ERRORS']))
                                $message = $return_data['RESPONSE']['STATUS']['ERRORS']['ERROR']['MESSAGE'];
                        }
                    }
                    else
                    {
                        $data['succeed'] = 0;
                    }
                    $data['message'] = $message;
                    $data['amount'] = $return_data['RESPONSE']['STATUS']['AMOUNT'] / 100;
                    $data['currency'] = $return_data['RESPONSE']['STATUS']['CURRENCYCODE'];
                    $data['cardnum'] = '';
                    $data['type'] = 'SOFORT';
                    // save cvv data
                    $data['cvv_result'] = '';
                    if($data['succeed'] ==  1){

                        $d .= $v['ordernum'].'<br>';
                        $order['payment_status'] = 'success';
                        DB::update('orders_order')->set(array('payment_status' => 'success'))->where('id', '=', $v['id'])->execute();
                     Payment::instance('GC')->pay($order, $data);                        
                    }

                }

            }  //end foreach

            if($d){
            echo $d.'success';
            echo '<hr>';                
        }else{
            echo 'no ordernum success';
        }
        }

        }


        echo 
'<form action="" method="post">
    <table class="tbl-order-address">
        <thead>
            <tr>
                <th scope="col" colspan="2">通过ordernum批量查询查询sofort订单</td>
            </tr>
            <tr>
            <td>一行一个ordernum：</td>
            <textarea name="SKUARR"  cols="30" rows="15" ></textarea>
        </tr>
        
        <tr>
            <td></td>
            <td colspan="2">
                <input type="submit" value="Update sofortpay status"/>
            </td>
        </tr>
        </thead>
    </table>
</form>';
    }

    public function action_check()
    {
        $order_row = DB::query(DATABASE::SELECT, 'SELECT id,ip,ordernum FROM `orders_order` WHERE payment_method = "SOFORT" and  payment_status in ("failed","pending")  ORDER BY id DESC LIMIT 0,30')->execute()->as_array();

        if($order_row)
        {
                    $d = '';  //success ordernum
            foreach ($order_row as $key => $v) 
            {
                $return_data = $this->curl_pay($v['id'],long2ip($v['ip']));

                $return_data = $return_data['REQUEST'];
                if (!empty($return_data['RESPONSE']))
                {
                    $return_order = $return_data['PARAMS']['ORDER'];
                    $order_id = $return_order['ORDERID'];
                    $order = Order::instance($order_id)->get();

                    $result = $return_data['RESPONSE']['RESULT'];
                    $message = '';
                    if(isset($return_data['RESPONSE']['ERROR']))
                    {
                        $errors = $return_data['RESPONSE']['ERROR'];
                        if(isset($errors[0]))
                        {
                            $message = $errors[0]['CODE'] . ':' . $errors[0]['MESSAGE'];
                        }
                        else
                        {
                            $message = $errors['CODE'] . ':' . $errors['MESSAGE'];
                        }
                    }
                    $data = array();
                    $data['order_id'] = $order_id;
                    $data['trans_id'] = $return_data['RESPONSE']['STATUS']['MERCHANTREFERENCE'];
                    $statusid = $return_data['RESPONSE']['STATUS']['STATUSID'];
                    $data['statusid'] = $statusid;

                    // save cvv data
                    $data['cvv_result'] = '';
                    if($result == 'OK')
                    {
                        if($statusid >= 1000 OR $statusid == 525)
                        {
                            $data['succeed'] = 1;
                        }
                        else
                        {
                            $data['succeed'] = 0;
                            if(!empty($return_data['RESPONSE']['STATUS']['ERRORS']))
                                $message = $return_data['RESPONSE']['STATUS']['ERRORS']['ERROR']['MESSAGE'];
                        }
                    }
                    else
                    {
                        $data['succeed'] = 0;
                    }
                    $data['message'] = $message;
                    $data['amount'] = $return_data['RESPONSE']['STATUS']['AMOUNT'] / 100;
                    $data['currency'] = $return_data['RESPONSE']['STATUS']['CURRENCYCODE'];
                    $data['cardnum'] = '';
                    $data['type'] = 'SOFORT';
                    if($data['succeed'] ==  1){

                        $d .= $v['ordernum'].'<br>';
                        $order['payment_status'] = 'success';
                        DB::update('orders_order')->set(array('payment_status' => 'success'))->where('id', '=', $v['id'])->execute();
                     Payment::instance('GC')->pay($order, $data);                        
                    }

                }

            }  //end foreach

            if($d){
            echo $d.'success';
            echo '<hr>';                
        }else{
            echo 'no ordernum success';
        }
        }

    }

    function curl_pay($order_id,$ip,$merchantid = 1335)
    {
        if(strlen($order_id)<5) return false;

        $params = array('REQUEST' => array('ACTION' => 'GET_ORDERSTATUS', 'META' => array('MERCHANTID' => $merchantid, 'IPADDRESS' => $ip, 'VERSION' => '2.0'), 'PARAMS' => array('ORDER' => array('ORDERID' => $order_id))));
            
        $xml_data = $this->array2xml($params);
        $correct_url = 'HTTPS://ps.gcsip.com/wdl/wdl';

        $ch = curl_init();

        $header[] = "Content-type: text/xml";//定义content-type为xml
        curl_setopt($ch, CURLOPT_URL, $correct_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        $response = curl_exec($ch);
        if(curl_errno($ch)) print curl_error($ch);
        curl_close($ch);
        $result_data = @simplexml_load_string($response,NULL,LIBXML_NOCDATA);
        $request = json_decode(json_encode($result_data),true);
        return $request;
    }

    public function array2xml($data)
    {
        $xml = '<XML>';
        foreach($data as $k1 => $d1)
        {
            if(is_array($d1))
            {
                $xml .= '<' . $k1 . '>';
                foreach($d1 as $k2 => $d2)
                {
                    if(is_array($d2))
                    {
                        $xml .= '<' . $k2 . '>';
                        foreach($d2 as $k3 => $d3)
                        {
                            if(is_array($d3))
                            {
                                $xml .= '<' . $k3 . '>';
                                foreach($d3 as $k4 => $d4)
                                {
                                    $xml .= '<' . $k4 . '>' . $d4 . '</' . $k4 . '>';
                                }
                                $xml .= '</' . $k3 . '>';
                            }
                            else
                            {
                                $xml .= '<' . $k3 . '>' . $d3 . '</' . $k3 . '>';
                            }
                        }
                        $xml .= '</' . $k2 . '>';
                    }
                    else
                    {
                        $xml .= '<' . $k2 . '>' . $d2 . '</' . $k2 . '>';
                    }
                }
                $xml .= '</' . $k1 . '>';
            }
            else
            {
                $xml .= '<' . $k1 . '>' . $d1 . '</' . $k1 . '>';
            }
        }
        $xml .= '</XML>';
        return $xml;
    }

    public function action_bname()
    {
        $postvalue = Arr::get($_POST,'bname',7);
        if(!$postvalue)
        {
            $postvalue = 7;
        }
        $cache = Cache::instance('memcache');
        $cache->set('bpayment',$postvalue,30*86400);
        echo '设置的gc支付比率为'.($postvalue*10).'%';
        echo '<br />';
        echo '设置的oc支付比率为'.((10-$postvalue)*10).'%';
        $keypostvalue = 'bpayment';
        $postvalue1 = $cache->get($keypostvalue);
        echo '<br />';
        echo $postvalue1;
    }

    public function action_yearorder()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="orderyear.csv"');
        
        echo "\xEF\xBB\xBF" . "year,order,amount\n";
        $yeararr = array(
                    '2012',
                    '2013',
                    '2014',
                    '2015',
                    '2016'
            );

        foreach ($yeararr as $key => $value)
        {
            $start = $value.'-01-01';
            $end = $value.'-12-31';
            $result = DB::query(Database::SELECT, "SELECT count(id) as con,sum(amount/rate) as amt from orders where amount > 0 and payment_status = 'verify_pass' and created > ".strtotime($start)." and created < ".strtotime($end))->execute('slave')->as_array();
            echo '"'.$value.'"'.',';
            echo '"'.$result[0]['con'].'"'.',';
            echo '"'.round($result[0]['amt'],2).';'.'"'.',';
            echo PHP_EOL;
        }

    }

    //导出wholesale标记的客户单 by xuli20160718
    public function  action_export_wholesale(){
        if($_POST){
            $sql=array();
            $date = strtotime(Arr::get($_POST, 'start', 0));
            // $date += 28800; /* 8 hours */
            // 添加更新结束时间
            $date_end = Arr::get($_POST, 'end', 0);

            if ($date_end)
            {
                $file_name = date('Y-m-d', $date) . '_' . $date_end . ".csv";
                $date_end = strtotime($date_end);
                // $date_end += 28800;
            }
            else
            {
                $file_name = date('Y-m-d', $date) . ".csv";
                $date_end = $date + 86400;
            }
            if ($date && $date_end)
            {
                $sql[] .= 'O.created >= ' . $date;
                $sql[] .= 'O.created < ' . $date_end;
            }

            $file_name = "orders_wholesale-" . $file_name;
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $file_name . '"');
            echo "ordernum,email,name,country,created,verify_date,payment_status,currency,amount,admin,payment_method,lang\n";

            $result = DB::query(DATABASE::SELECT, "SELECT O.id,O.ordernum,C.firstname,C.lastname,C.country,O.email,O.created,O.verify_date,O.shipping_date,
            O.payment_status,O.shipping_status,O.refund_status,O.currency,O.amount,O.payment_method,O.deliver_time,O.lang,O.order_from
            FROM `orders_order` O LEFT JOIN customers C ON O.customer_id = C.id WHERE O.order_from='wholesale' AND O.`email` IS NOT NULL AND O.site_id=" . $this->site_id ." AND ".implode(" AND ",$sql))->execute('slave')->as_array();

            foreach ($result as $value)
            {
                $admin_id = DB::select('admin')->from('celebrities_celebrits')->where('email', '=', $value['email'])->execute('slave')->get('admin');

                if ($admin_id)
                    $cele_admin = User::instance($admin_id)->get('name');
                else
                    $cele_admin = '';

                //开始导表
                echo $value['ordernum'], ',';
                echo $value['email'], ',';
                echo $value['firstname'] . ' ' . $value['lastname'],',';
                echo $value['country'], ',';
                echo date('Y-m-d', $value['created']), ',';
                echo date('Y-m-d', $value['verify_date']), ',';
                echo $value['payment_status'], ',';
                echo $value['currency'], ',';
                echo $value['amount'], ',';
                echo $cele_admin,',';
                echo $value['payment_method'], ',';
                echo $value['lang'], ',';
                echo ',' , PHP_EOL;;
            }
        }
    }

    //导出金额币种换算之后$200+的客户单 by xuli 20160719
    public function action_export_amount200(){
        if($_POST) {
            $sql = array();
            $date = strtotime(Arr::get($_POST, 'start', 0));
            // $date += 28800; /* 8 hours */
            // 添加更新结束时间
            $date_end = Arr::get($_POST, 'end', 0);

            if ($date_end) {
                $file_name = date('Y-m-d', $date) . '_' . $date_end . ".csv";
                $date_end = strtotime($date_end);
                // $date_end += 28800;
            } else {
                $file_name = date('Y-m-d', $date) . ".csv";
                $date_end = $date + 86400;
            }

            if ($date && $date_end)
            {
                $sql[] .= 'O.created >= ' . $date;
                $sql[] .= 'O.created < ' . $date_end;
            }

            $file_name = "orders_more200-" . $file_name;
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $file_name . '"');
            echo "ordernum,email,name,country,created,verify_date,payment_status,currency,rate,amount,amount_USD,admin,payment_method,lang\n";

            $result = DB::query(DATABASE::SELECT, "SELECT O.id,O.ordernum,C.firstname,C.lastname,C.country,O.email,O.created,O.verify_date,O.shipping_date,
            O.payment_status,O.shipping_status,O.refund_status,O.currency,O.rate,O.amount,ROUND((O.amount/O.rate),4) as amount_USD,O.payment_method,O.deliver_time,O.lang,O.order_from
            FROM `orders_order` O LEFT JOIN customers C ON O.customer_id = C.id WHERE ROUND((O.amount/O.rate),4)>=200 AND O.`email` IS NOT NULL AND O.site_id=" . $this->site_id ." AND ".implode(" AND ",$sql))->execute('slave')->as_array();

            foreach ($result as $value)
            {
                $admin_id = DB::select('admin')->from('celebrities_celebrits')->where('email', '=', $value['email'])->execute('slave')->get('admin');

                if ($admin_id)
                    $cele_admin = User::instance($admin_id)->get('name');
                else
                    $cele_admin = '';

                //开始导表
                echo $value['ordernum'], ',';
                echo $value['email'], ',';
                echo $value['firstname'] . ' ' . $value['lastname'],',';
                echo $value['country'], ',';
                echo date('Y-m-d', $value['created']), ',';
                echo date('Y-m-d', $value['verify_date']), ',';
                echo $value['payment_status'], ',';
                echo $value['currency'], ',';
                echo $value['rate'], ',';
                echo $value['amount'], ',';
                echo $value['amount_USD'], ',';
                echo $cele_admin,',';
                echo $value['payment_method'], ',';
                echo $value['lang'], ',';
                echo ',' , PHP_EOL;;
            }

        }
    }

    public function action_ordernumcreated()
    {
        if ($_POST)
        {
            $skus = Arr::get($_POST, 'skus', '');
            if (!$skus)
            {
                echo 'ordernum cannot be empty';
                exit;
            }
            $skusarr = explode("\n", $skus);
            header('Content-type:text/html;charset=GBK');//设定编码，防止js输出乱码。
            header('Content-type:application/vnd.ms-excel');//输出的类型
            header('Content-Disposition: attachment; filename="ordernum.csv"'); //下载显示
            echo iconv("UTF-8", "GBK//IGNORE",'ordernum,created'."\r\n");

            foreach ($skusarr as $sku)
            {
                $order_id = Order::get_from_ordernum($sku);
                $order_instance=Order::instance($order_id);
                $order = Order::instance($order_id)->get();
                echo '"' .$sku. '"', ',';
                echo '"' .date('Y-m-d H:i:s', $order['created']). '"', ',';
                echo "\n";
            }
        }
        else
        {
            echo
            '
    <h3>根据ordernum导出创建时间</h3>
    <form method="post">
        <textarea name="skus" cols="20" rows="20"></textarea>
        <br />
    <input type="submit" value="submit">
    </form>    
';  
        }

    }


}
