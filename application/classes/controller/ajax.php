<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax extends Controller_Webpage
{
    public function action_more_color()
    {
        $data = array();
        $product_ids = Arr::get($_POST, 'product_ids', '');
        $product_idsint=array();
        $product_ids = explode(',',$product_ids); 
        foreach($product_ids as $product_id){
             $product_idint= intval($product_id);
             if($product_idint){
                $product_idsint[] += $product_idint;
                
             }
        }
        $product_idsint =implode(",",$product_idsint);
        if($product_idsint)
        {
            $same_paragraphs = DB::query(Database::SELECT, 'SELECT DISTINCT product_id FROM catalog_colors WHERE product_id IN (' . $product_idsint  . ')')->execute();
            foreach($same_paragraphs as $same)
            {
                $data[] = $same['product_id'];
            }
        }
        echo json_encode($data);
        exit;
    }

    //获取用户所有收藏的id
    public function action_wishlist_data()
    {
        $data = array();
        $product_ids = Arr::get($_POST, 'product_ids', '');
        $product_idsint="";
        $product_ids = explode(',',$product_ids); 

        foreach($product_ids as $product_id){
             $product_idint= intval($product_id);
             if($product_idint){
                $product_idsint .= $product_idint.',';
             }
        }
        $product_idsint=substr($product_idsint,0,strlen($product_idsint)-1);
        if($product_idsint)
        {
            $customer_id = Customer::logged_in();
            if($customer_id)
            {
                $pids = array();
                $wishlists = DB::query(Database::SELECT, 'SELECT product_id FROM accounts_wishlists WHERE customer_id = ' . $customer_id . ' AND product_id IN (' . $product_idsint . ')')->execute();
                
                foreach($wishlists as $w)
                {
                    $data[] = $w['product_id'];
                }
            }
        }
        echo json_encode($data);
        exit;
    }

    public function action_review_data()
    {
        $data = array();
        $product_ids = Arr::get($_POST, 'product_ids', '');
        $product_idsint="";
        $product_ids = explode(',',$product_ids); 

        foreach($product_ids as $product_id){
             $product_idint= intval($product_id);
             if($product_idint){
                $product_idsint .= $product_idint.',';
             }
        }
        $product_idsint=substr($product_idsint,0,strlen($product_idsint)-1);
        if($product_idsint)
        {
            $reviews = DB::query(Database::SELECT, 'SELECT product_id, rating, quantity FROM review_statistics WHERE product_id IN (' . $product_idsint . ')')->execute();
            foreach($reviews as $r)
            {
                $plink = Product::instance($r['product_id'],LANGUAGE)->permalink();
                $r['plink'] = $plink;
                $data[] = $r;
            }
        }
        echo json_encode($data);
        exit;
    }
    
    /**
     * 获取mark标识库ajax
     * @param string proudct_ids,catalog_id
     * @return json 产品标识,分类标识
     * json: arrary()
     * wankaifa add 2015-12-11
     */
    public function action_marks_data()
    {
        $data = array();
        $product_ids = Arr::get($_POST, 'product_ids', '');
        $catalog_id = Arr::get($_GET, 'catalog_id', '');
        if(!$product_ids && !$catalog_id)
        {
            exit;
        }
        $product_array = explode(',',$product_ids);
        $cache = Cache::instance('memcache');

        //产品标识1
        $key395 = Site::instance()->get('id') . '/catalog_id_395';
        if (!($ready_shippeds = $cache->get($key395)))
        {
            $ready_shippeds = array();
            $readys= DB::select('product_id')->from('products_categoryproduct')->where('category_id', '=', 395)->execute()->as_array();
            foreach($readys as $ready)
            {
                $ready_shippeds[] = $ready['product_id'];
            }
            $cache->set($key395, $ready_shippeds, 600);
        }

        $flash_sale_key = 'flash_sales_products';
        if (!$flash_sales_products = $cache->get($flash_sale_key))
        {
            $flash_sales_products = array();
            $flash_sales = DB::select('product_id')->from('carts_spromotions')->where('type', '=', 6)->where('expired', '>', time())->execute()->as_array();
            foreach($flash_sales as $flash)
            {
                $flash_sales_products[] = $flash['product_id'];
            }
            $cache->set($flash_sale_key, $flash_sales_products, 7200);
        }

        $keymarks = 'site_marks';
        if(!$marks = $cache->get($keymarks))
        {
            $marks = DB::select('category_id', 'product_id', 'mark_name')->from('products_marks')->execute()->as_array();
            $cache->set($keymarks, $marks, 7200);
        }
        $marks_products = array();
        $marks_catalog = '';
        foreach($marks as $m)
        {
            if(in_array($m['product_id'], $product_array))
                $marks_products[$m['product_id']] = $m['mark_name'];
            elseif($m['category_id'] == $catalog_id)
                $marks_catalog = $m['mark_name'];
        }

        $mark_data = array();

        foreach($product_array as $product_id)
        {
            $is_new = time() - Product::instance($product_id)->get('display_date') <= 86400 * 7 ? 1 : 0;
            $onsale = Product::instance($product_id)->get('status');
            if($onsale==0){
                $mark='outstock';
            }else if(in_array($product_id, $flash_sales_products)){
                $mark='icon-fsale';
            }else if(in_array($product_id, $ready_shippeds)){
                $mark='icon-rshipped';
            }else if($is_new){
                $mark='icon-new';
            }else{
                $mark='';
            }

            if(!$mark)
            {
                if(array_key_exists($product_id, $marks_products))
                    $mark = $marks_products[$product_id];
                elseif($marks_catalog)
                    $mark = $marks_catalog;
            }

            $mark_data[$product_id] = $mark;
        }
        echo json_encode($mark_data);
        exit;
        
    }

    public function action_test()
    {
        $data = array();
        sleep(3);
        echo json_encode($data);
        exit;
    }


    //test product price, memcache
    public function action_test_product_memcache()
    {
        $sku = Arr::get($_GET, 'sku', '');
        $product_id = Product::get_productId_by_sku($sku);
        if($product_id)
        {
            $cache_key = 'spromotion_' . $product_id;
            $cache = Cache::instance('memcache');
            $cache_data = $cache->get($cache_key);
            print_r($cache_data);
            $sale_price = Product::instance($product_id)->price();
            $o_price = Product::instance($product_id)->get('price');
            echo 'o_price: ' . $o_price . '; sale_price: ' . $sale_price;
        }
        exit;
    }
    
    /**
     * 获取用户剩下的积分ajax
     * @param point_id
     * @return json 未登录则返回空,登录则返回用户名 
     * wkf add 2016-01-12
     */
    public function action_ajax_points()
    {
        $user_session = Session::instance()->get('user');
        $data = array();
        $allpoints=array();
        if($user_session['id'])
        {
            $point_id = Arr::get($_POST, 'point_id', '');
            $point_name = Arr::get($_POST, 'point_name', '');
            $point_id=intval($point_id);
            $lang=LANGUAGE;
            if($point_id)
            {
                $newuser_points='';
                //获取用户可使用的积分
                $customer = Customer::logged_in();
                //过滤红人
                if($customer AND Customer::instance($customer)->is_celebrity())
                {
                    $data['success']=-3;
                    if($lang=='de')
                    {
                        $data['content']='Unsere kooperative Bloggers werden ausgeschlossen.';
                    }elseif($lang=='es'){
                        $data['content']='Quedan excluidos nuestros bloggers de cooperación.';
                    }elseif($lang=='fr') {
                        $data['content']='Blogueurs coopératives sont exclus.';
                    }elseif($lang=='ru'){
                        $data['content']='Совместные блоггеров исключительные.';
                    }else{
                        $data['content']='Cooperative bloggers are excluded';
                    }
                    echo json_encode($data);
                    exit;
                }
                $user_points=Customer::instance($customer)->points();
                $point_name=str_replace("%","",$point_name);
                $allpoints=array("500","1000","1500","2000","2500","3000","4000","5000");
                //设置用户最低消费
                $minprice=array(
                    "5"=>49,
                    "10"=>79,
                    "15"=>109,
                    "20"=>139,
                    "25"=>169,
                    "30"=>199,
                    "40"=>259,
                    "50"=>299,
                );
                //用户可用积分减去兑换的积分
                if($user_points >= $point_id)
                {
                    $newuser_points=$user_points-$point_id;
                    //设置兑换券名
                    $coupon_code = 'REDEEM'. $user_session['id'].'_'.$point_name.'_1';
                    $coupons = DB::query(Database::SELECT, 'select code FROM carts_coupons where code = "'.$coupon_code.'"')->execute()->get('code');
                    
                    if($coupons)
                    {
                        $count = DB::query(Database::SELECT, 'select COUNT(*) as sum FROM carts_coupons where value = '.$point_name.' and code like "'.$coupon_code.'%"')->execute()->current();
                        $count['sum']=$count['sum']+1;
                        $newcoupon_code = $coupon_code.'_'.$count['sum'];
                        $coupon = array(
                            // 'site_id' => $this->site_id,
                            'code' => $newcoupon_code,
                            'value' => $point_name,
                            'type' => 2,
                            'limit' => 1,
                            'used' => 0,
                            'created' => time(),
                            'expired' => strtotime("2016-06-01 00:00:00"),
                            'usedfor' => 1,
                            // 'target'=>'global',
                            'on_show' => 0,
                            'deleted' => 0,
                            'effective_limit' => 0,
                            'condition'=>$minprice[$point_name]
                            );
                        $insert = DB::insert('carts_coupons', array_keys($coupon))->values($coupon)->execute();
                        //更新用户可用积分
                        if ($insert)
                        {
                            $c_coupon = array(
                                'customer_id' => $user_session['id'],
                                'coupon_id' => $insert[0],
                                'deleted' => 0
                                // 'site_id' => $this->site_id
                            );
                            DB::insert('carts_customercoupons', array_keys($c_coupon))->values($c_coupon)->execute();
                            
                        }
                         foreach ($allpoints as $key => $value){
                             if($value>$newuser_points)
                             {
                                 unset($allpoints[$key]);
                             }
                         }
                         $newcustomer = Customer::instance($user_session['id']);
                          if ($newcustomer->_set(array('points' =>$newuser_points)))
                            {
                                $newcustomer->add_point(array('amount' => $newuser_points, 'type' => 'tryon', 'status' => 'activated', 'user_id' => 0));
                                //message::set('');
                                $data['success']=1;
                                $data['newcoupon_code']=$newcoupon_code;
                                $data['points_new']=$newuser_points;
                                $data['point_id']=$point_id;
                                $data['all']=array("500","1000","1500","2000","2500","3000","4000","5000");
                                $data['allok']=$allpoints;
                                if(!$user_session['firstname']){
                                    $user_session['firstname']="choieser";
                                }
                                $mail_params['email'] = $user_session['email'];
                                $mail_params['firstname'] = $user_session['firstname'];
                                $mail_params['coupon_code'] = $newcoupon_code;
                                $mail_params['minprice'] = $minprice[$point_name];
                                Mail::SendTemplateMail('Redeem Points', $mail_params['email'], $mail_params);
                                echo json_encode($data);
                                exit;
                            }
                            else
                            {
                                message::set(' ', 'error');
                                exit;
                            }
                            
                    }else{
                        //新用户就add一条数据
                        $coupon = array(
                                // 'site_id' => $this->site_id,
                                'code' => $coupon_code,
                                'value' => $point_name,
                                'type' => 2,
                                'limit' => 1,
                                'used' => 0,
                                'created' => time(),
                                'expired' => strtotime("2016-06-01 00:00:00"),
                                'usedfor' => 1,
                                'on_show' => 0,
                                'deleted' => 0,
                                'effective_limit' => 0,
                                // 'target'=>'global',
                                'condition'=>$minprice[$point_name]
                            );

                        $insert = DB::insert('carts_coupons', array_keys($coupon))->values($coupon)->execute();
                        if($insert[0])
                        {
                        //更新用户可用积分
                            $c_coupon = array(
                                'customer_id' => $user_session['id'],
                                'coupon_id' => $insert[0],
                                'deleted' => 0
                                // 'site_id' => $this->site_id
                            );
                            DB::insert('carts_customercoupons', array_keys($c_coupon))->values($c_coupon)->execute();
                             foreach ($allpoints as $key => $value) 
                             {
                                 if($value>$newuser_points)
                                 {
                                     unset($allpoints[$key]);
                                 }    
                             }
                             $newcustomer = Customer::instance($user_session['id']);

                          if ($newcustomer->_set(array('points' =>$newuser_points)))
                            {
                                $newcustomer->add_point(array('amount' => $newuser_points, 'type' => 'tryon', 'status' => 'activated', 'user_id' => 0));
                                //message::set(' ');
                                $data['success']=1;
                                $data['newcoupon_code']=$coupon_code;
                                $data['points_new']=$newuser_points;
                                $data['point_id']=$point_id;
                                $data['all']=array("500","1000","1500","2000","2500","3000","4000","5000");
                                $data['allok']=$allpoints;
                                if(!$user_session['firstname']){
                                    $user_session['firstname']="choieser";
                                }
                                $mail_params['email'] = $user_session['email'];
                                $mail_params['firstname'] = $user_session['firstname'];
                                $mail_params['coupon_code'] = $coupon_code;
                                $mail_params['minprice'] = $minprice[$point_name];
                                Mail::SendTemplateMail('Redeem Points', $mail_params['email'], $mail_params);
                                echo json_encode($data);
                                exit;
                            }
                            else
                            {
                                message::set('error', 'error');
                                exit;
                            }
                        }
                    }
                }else{
                    $data['success']=-1;
                    echo json_encode($data);
                    exit;
                }
                
            }else{
                $data['success']=-2;
                echo json_encode($data);
                exit;
            }
            
        }
    }

    public function action_ajax_addck()
    {
        Session::instance()->set('fb_loginpage',1); 
        $fb_loginpage = Session::instance()->get('fb_loginpage',0);
        echo json_encode($fb_loginpage);
        die;
    }
    
    public function action_more_product()
    {
        $data = array();
        $cache = Cache::instance('memcache');
        $product_ids = Arr::get($_POST, 'product_ids', '');    
        $is_mobile = Session::instance()->get('is_mobile');
        $product_idsint="";
        $product_ids = explode(',',$product_ids); 
        foreach($product_ids as $product_id)
        {
             $product_idint= intval($product_id);
             if($product_idint)
             {
                $product_idsint .= $product_idint.',';
             }
        }
        $product_idsint=substr($product_idsint,0,strlen($product_idsint)-1);
        $tli = Arr::get($_POST, 'tli', '20');
        $lang = Arr::get($_GET, 'lang', '');
        $product_id=explode(',',$product_idsint);
        $newproduct_id = array();
        foreach($product_id as $product=>$v)
        {
            if($product>=$tli && $product <= $tli+19)
            {
                array_push($newproduct_id,$v);
            }
        }
        $products = array();
        foreach($newproduct_id as $newproduct)
        {
            $cover_image = Product::instance($newproduct)->cover_image();
            $product_inf = Product::instance($newproduct,$lang)->get();
            $plink = Product::instance($newproduct,$lang)->permalink();
               
            if($is_mobile)
                $image_link = Image::link($cover_image, 4);
            else
                $image_link = Image::link($cover_image, 1);
            
                $orig_price = round($product_inf['price'], 2);
                $price = round(Product::instance($newproduct)->price(), 2);

            $product_title = $product_inf['name'];
                
            $products[] = array(
                'product_href' => $plink,
                'product_id' => $newproduct,
                'image_src' => $image_link,
                'image_alt' => 'Fashion '.$product_inf['name'],
                'product_title' => $product_title,
                'price_old' => Site::instance()->price($orig_price, 'code_view'),
                'price_new' => Site::instance()->price($price, 'code_view'),
                'has_pick' => $product_inf['has_pick'],
                'mark' => '',
            );
            
        }
        echo json_encode($products);
        exit;    
    }
    
    /*
        获取产品的相关产品 --- sjm 2016-02-29
    */
    public function action_product_relate()
    {
        if($_POST)
        {
            $product_id = (int) Arr::get($_POST, 'product_id', 0);
            $lang = Arr::get($_POST, 'lang', '');
            if($product_id)
            {
                $key = 'product_relates1_' . $product_id;
                $cache = Cache::instance('memcache');
                if(!$relate_products = $cache->get($key))
                {
                	// 每组显示数量
                	$b_num = 7;
                    // 获取new.choies上面relate数据
                    $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
                    $context = stream_context_create($opts);
                    $relate_url = 'http://new.choies.com/api/get_product_relate?product_id=' . $product_id;
                    $relate_html = trim(@file_get_contents($relate_url, FALSE, $context));
                    if($relate_html)
                    {
                        $relate_array = explode(',', $relate_html);
                    }
                    else
                    {
                        $relate_array = array();
                    }
                    $relate_products = array();
                    if(!empty($relate_array))
                    {
                        // delete special products
                        $not_in_products = array(18247,18248,35050,40056,63627,6693,7462);
                        foreach($relate_array as $key => $relate)
                        {
                            if(in_array($relate, $not_in_products))
                                unset($relate_array[$key]);
                        }
                    }
                    if(!empty($relate_array))
                    {
                        $re_num1 = 0;
                        $set_id = Product::instance($product_id)->get('set_id');
                        $same_set_relates = DB::query(Database::SELECT, 'SELECT id, sku, link, price, set_id FROM products_product WHERE set_id = ' . $set_id . ' AND visibility = 1 AND status = 1 AND id IN (' . implode(',', $relate_array) . ') LIMIT 0, 14')->execute();
                        $ga_relates_array = DB::query(Database::SELECT, 'SELECT id, sku, link, price, set_id FROM products_product WHERE set_id != ' . $set_id . ' AND visibility = 1 AND status = 1 AND id IN (' . implode(',', $relate_array) . ') LIMIT 0, 28')->execute();
                        foreach($same_set_relates as $re_num1 => $relate)
                        {
                            $num = (int) ($re_num1 / $b_num);
                            if(!isset($relate_products[$num]))
                                $relate_products[$num] = array();
                            $relate['link'] = '/product/' . $relate['link'] . '_p' . $relate['id'];
                            $relate['realprice'] = number_format($relate['price'], 2);
                            $relate['price'] = Product::instance($relate['id'])->price();
                            $relate['cover_image'] = Image::link(Product::instance($relate['id'])->cover_image(), 7);
                            $relate_products[$num][] = $relate;
                        }
                        $re_num1 ++;
                        foreach($ga_relates_array as $re_num2 => $relate)
                        {
                            $num = (int) (($re_num1 + $re_num2) / $b_num);
                            if(!isset($relate_products[$num]))
                            	$relate_products[$num] = array();
                            $relate['link'] = '/product/' . $relate['link'] . '_p' . $relate['id'];
                            $relate['realprice'] = number_format($relate['price'], 2);
                            $relate['price'] = Product::instance($relate['id'])->price();
                    		$relate['cover_image'] = Image::link(Product::instance($relate['id'])->cover_image(), 7);
                            $relate_products[$num][] = $relate;
                        }
                    }
                    else
                    {
                        $product = Product::instance($product_id);
                        if($product->get('id'))
                        {
                        	$product_set = $product->get('set_id');
                            // 同SET推荐---7个热销款
                            $hots = DB::select('id', 'sku', 'link', 'price')
                                ->from('products_product')
                                ->where('id', '<>', $product_id)
                                ->where('set_id', '=', $product_set)
                                ->where('visibility', '=', 1)
                                ->where('status', '=', 1)
                                ->order_by('hits', 'desc')
                                ->limit(20)
                                ->execute()->as_array();
                            $rand = rand(0, count($hots) - $b_num);
                            $relate_products[0] = array();
                            for($i = $rand;$i < $rand + $b_num;$i ++)
                            {
                            	if(isset($hots[$i]))
                            	{
                            		$relate = $hots[$i];
                            		$relate['link'] = '/product/' . $relate['link'] . '_p' . $relate['id'];
                            		$relate['realprice'] = number_format($relate['price'], 2);
		                            $relate['price'] = Product::instance($relate['id'])->price();
		                    		$relate['cover_image'] = Image::link(Product::instance($relate['id'])->cover_image(), 7);
                            		$relate_products[0][] = $relate;
                            	}
                            }

                            // 同SET推荐---7个新品
                            $news = DB::select('id', 'sku', 'link', 'price')
                                ->from('products_product')
                                ->where('id', '<>', $product_id)
                                ->where('set_id', '=', $product_set)
                                ->where('visibility', '=', 1)
                                ->where('status', '=', 1)
                                ->order_by('display_date', 'desc')
                                ->limit(20)
                                ->execute()->as_array();
                            $rand = rand(0, count($news) - $b_num);
                            $relate_products[1] = array();
                            for($i = $rand;$i < $rand + $b_num;$i ++)
                            {
                            	if(isset($news[$i]))
                            	{
                            		$relate = $news[$i];
                            		$relate['link'] = '/product/' . $relate['link'] . '_p' . $relate['id'];
                            		$relate['realprice'] = number_format($relate['price'], 2);
		                            $relate['price'] = Product::instance($relate['id'])->price();
		                    		$relate['cover_image'] = Image::link(Product::instance($relate['id'])->cover_image(), 7);
                            		$relate_products[1][] = $relate;
                            	}
                            }

                            // 不同SET推荐---7个热销款
                            $not_in_sets = array(
                                0, 29, (int) $product_set
                            );
                            $hots1 = DB::select('id', 'sku', 'link', 'price')
                                ->from('products_product')
                                ->where('set_id', 'NOT IN', $not_in_sets)
                                ->where('visibility', '=', 1)
                                ->where('status', '=', 1)
                                ->order_by('hits', 'desc')
                                ->limit(20)
                                ->execute()->as_array();
                            $rand = rand(0, count($hots1) - $b_num);
                            $relate_products[2] = array();
                            for($i = $rand;$i < $rand + $b_num;$i ++)
                            {
                            	if(isset($hots1[$i]))
                            	{
                            		$relate = $hots1[$i];
                            		$relate['link'] = '/product/' . $relate['link'] . '_p' . $relate['id'];
                            		$relate['realprice'] = number_format($relate['price'], 2);
		                            $relate['price'] = Product::instance($relate['id'])->price();
		                    		$relate['cover_image'] = Image::link(Product::instance($relate['id'])->cover_image(), 7);
                            		$relate_products[2][] = $relate;
                            	}
                            }

                            // 不同SET推荐---7个新品
                            $news1 = DB::select('id', 'sku', 'link', 'price')
                                ->from('products_product')
                                ->where('set_id', 'NOT IN', $not_in_sets)
                                ->where('visibility', '=', 1)
                                ->where('status', '=', 1)
                                ->order_by('display_date', 'desc')
                                ->limit(20)
                                ->execute()->as_array();
                            $rand = rand(0, count($news1) - $b_num);
                            $relate_products[3] = array();
                            for($i = $rand;$i < $rand + $b_num;$i ++)
                            {
                            	if(isset($news1[$i]))
                            	{
                            		$relate = $news1[$i];
                            		$relate['link'] = '/product/' . $relate['link'] . '_p' . $relate['id'];
                            		$relate['realprice'] = number_format($relate['price'], 2);
		                            $relate['price'] = Product::instance($relate['id'])->price();
		                    		$relate['cover_image'] = Image::link(Product::instance($relate['id'])->cover_image(), 7);
                            		$relate_products[3][] = $relate;
                            	}
                            }

                        }
                    }
                    $cache->set($key, $relate_products, 10);//7200
                }
                foreach($relate_products as $key1 => $relate1)
                {
                    foreach($relate1 as $key2 => $relate)
                    {
                        $relate_products[$key1][$key2]['price'] = Site::instance()->price($relate_products[$key1][$key2]['price'], 'code_view');
                        $relate_products[$key1][$key2]['link'] = $lang . $relate_products[$key1][$key2]['link'];
                    }
                }
                echo json_encode($relate_products);
            }
        }
        exit;
    }

    public function action_topseller_relate()
    {

        if($_POST)
        {
            $lang = Arr::get($_POST, 'lang', '');
            $key = 'currencytopseller_relates'.$lang;
            $cache = Cache::instance('memcache');
            if(!$relate_products = $cache->get($key))
            {
                $not_in_sets = array(
                    0, 29,
                );
                $relate_array = DB::query(Database::SELECT, 'SELECT p.id, p.sku, p.link, p.price FROM products_product p left join products_categoryproduct cp on p.id = cp.product_id WHERE cp.category_id =32 and p.visibility = 1 AND p.status = 1 and p.set_id not in (0,29) order by p.hits desc LIMIT 0, 28')->execute('slave')->as_array();


                $newarr = array();
                foreach($relate_array as $keys =>$value)
                {
                    if($keys<=6)
                    {
                        $newarr[0][$keys]['link'] = '/product/' . $value['link'] . '_p' . $value['id'];
                        $newarr[0][$keys]['realprice'] = number_format($value['price'], 2);
                        $newarr[0][$keys]['price'] = Product::instance($value['id'])->price();
                        $newarr[0][$keys]['cover_image'] = Image::link(Product::instance($value['id'])->cover_image(), 7);                        
                    }
                    elseif($keys >6 && $keys <=13)
                    {
                        $keys -= 7;
                        $newarr[1][$keys]['link'] = '/product/' . $value['link'] . '_p' . $value['id'];
                        $newarr[1][$keys]['realprice'] = number_format($value['price'], 2);
                        $newarr[1][$keys]['price'] = Product::instance($value['id'])->price();
                        $newarr[1][$keys]['cover_image'] = Image::link(Product::instance($value['id'])->cover_image(), 7);                        
                    }
                    elseif($keys >13 && $keys <=20)
                    {
                        $keys -= 14;
                        $newarr[2][$keys]['link'] = '/product/' . $value['link'] . '_p' . $value['id'];
                        $newarr[2][$keys]['realprice'] = number_format($value['price'], 2);
                        $newarr[2][$keys]['price'] = Product::instance($value['id'])->price();
                        $newarr[2][$keys]['cover_image'] = Image::link(Product::instance($value['id'])->cover_image(), 7);                        
                    }
                    else
                    {
                        $keys -=21;
                        $newarr[3][$keys]['link'] = '/product/' . $value['link'] . '_p' . $value['id'];
                        $newarr[3][$keys]['realprice'] = number_format($value['price'], 2);
                        $newarr[3][$keys]['price'] = Product::instance($value['id'])->price();
                        $newarr[3][$keys]['cover_image'] = Image::link(Product::instance($value['id'])->cover_image(), 7);                    
                    }

                }

                $relate_products = $newarr;
                $cache->set($key, $relate_products, 86400);

            }

            if(isset($relate_products))
            {
                foreach($relate_products as $keynew => $values)
                {
                    foreach($values as $keytwo => $valuetwo)
                    {
                        if($lang)
                        {
                            $relate_products[$keynew][$keytwo]['link'] = '/'.$lang.$valuetwo['link'];
                        }
                            $relate_products[$keynew][$keytwo]['price'] = Site::instance()->price($valuetwo['price'], 'code_view');
                    }

                }                
            }


            echo json_encode($relate_products);
            die;
       }    
    }

    // get catalog filters SIZE, COLOR, PRICE --- sjm add 2016-03-15
    public function action_catalog_filters()
    {
        if($_REQUEST)
        {
            $catalog_id = Arr::get($_REQUEST, 'catalog_id', 0);
            $count_products = Arr::get($_REQUEST, 'count_products', 1);
            $is_shoes = Arr::get($_REQUEST, 'is_shoes', 0);

            // set current filter array
            $current_filters = array(
                'size' => array(),
                'color' => array(),
                'price' => array(),
            );
            $current_filter_str = Arr::get($_REQUEST, 'current_filter', '');
            $current_filter_array = explode('__', $current_filter_str);
            foreach($current_filter_array as $c_f)
            {
                if($c_f)
                {
                    $c_f_array = explode('_', $c_f);
                    if(count($c_f_array) > 1)
                    {
                        $current_filters[$c_f_array[0]] = array();
                        if($c_f_array[0] == 'price')
                        {
                            $price_range = explode('-', $c_f_array[1]);
                            $current_filters[$c_f_array[0]] = $price_range;
                        }
                        else
                        {
                            for($i = 1;$i < count($c_f_array);$i ++)
                            {
                                if($c_f_array[$i] == 'ONESIZE')
                                    $current_filters[$c_f_array[0]][] = 'ONE SIZE';
                                else
                                    $current_filters[$c_f_array[0]][] = $c_f_array[$i];
                            }
                        }
                    }
                }
            }

            if($catalog_id)
            {
                $cache = Cache::instance('memcache');
                $cache_key = 'catalog_all_filters12_' . $catalog_id;
                $catalog_all_filters = $cache->get($cache_key);
                if(empty($catalog_all_filters))
                {
                    $catalog_all_filters = array();
                    $posterity = Catalog::instance($catalog_id)->posterity();
                    $catalog_ids = $catalog_id . ' ' . implode(' ', $posterity);
                    $elastic_type = 'product';
                    $elastic_index = 'basic_new';
                    $elastic = Elastic::instance($elastic_type, $elastic_index);
                    $response = $elastic->search($catalog_ids, array('default_catalog'), $count_products);
                    if(!empty($response['hits']['hits']))
                    {
                        foreach($response['hits']['hits'] as $res)
                        {
                            $catalog_all_filters[$res['_source']['id']] = array(
                                'size' => isset($res['_source']['size_value']) ? $res['_source']['size_value'] : '',
                                'color' => isset($res['_source']['color_value']) ? $res['_source']['color_value'] : '',
                                'price' => round($res['_source']['price'], 2),
                            );
                        }
                    }
                    $cache->set($cache_key, $catalog_all_filters, 7200);
                }

                if(!empty($catalog_all_filters))
                {
                    $filters = array(
                        'size' => array(),
                        'color' => array(),
                        'price' => array(),
                    );
                    $has_filters = array(
                        'size' => array(),
                        'color' => array(),
                        'price' => array(),
                    );
                    if(!$is_shoes)
                    {
                        $filters['size'] = array(
                            'ONE SIZE' => 0,
                            'XXS' => 0,
                            'XS' => 0,
                            'S' => 0,
                            'M' => 0,
                            'L' => 0,
                            'XL' => 0,
                            'XXL' => 0,
                            'XXXL' => 0,
                            '4XL' => 0,
                            '5XL' => 0,
                            '6XL' => 0,
                            '7XL' => 0,
                        );
                    }
                    else
                    {
                        $filters['size'] = array(
                            '32' => 0,
                            '33' => 0,
                            '34' => 0,
                            '35' => 0,
                            '36' => 0,
                            '37' => 0,
                            '38' => 0,
                            '39' => 0,
                            '40' => 0,
                            '41' => 0,
                            '42' => 0,
                            '43' => 0,
                            '44' => 0,
                            '45' => 0,
                            '46' => 0,
                            '47' => 0,
                            '48' => 0,
                        );
                    }
                    $size_replace = array(
                        '2' => 'XS',
                        '4' => 'S',
                        '6' => 'M',
                        '8' => 'L',
                        '10' => 'XL',
                        '12' => 'XXL',
                        '14' => 'XXXL',
                        '16' => '4XL',
                        '18' => '5XL',
                        'XXXXL' => '4XL',
                        'XXXXXL' => '5XL',
                        '2XL' => 'XXL',
                        '3XL' => 'XXXL',
                    );
                    $size_title = array(
                        'ONE SIZE' =>'ONESIZE',
                        '4XL' => 'XXXXL',
                        '5XL' => 'XXXXXL',
                        '6XL' => 'XXXXXXL',
                        '7XL' => 'XXXXXXXL',                        
                        'US4/UK2-UK2.5/EUR35/22.5CM' => '35',
                        'US5/UK3-UK3.5/EUR36/23CM' => '36',
                        'US6/UK4-UK4.5/EUR37/23.5CM' => '37',
                        'US7/UK5-UK5.5/EUR38/24CM' => '38',
                        'US8/UK6-UK6.5/EUR39/24.5CM' => '39',
                    );
                    $language_onesize = array(
                        'de' => 'Eine Größe',
                        'es' => 'Talla única',
                    );
                    $filters['language_onesize'] = $language_onesize;

                    $filters['size_title'] = $size_title;
                    $price_config = Kohana::config('filter.price');
                    foreach($price_config['keys'] as $key => $val)
                    {
                        $filters['price'][$key] = 0;
                    }
                    $filters['price_keys'] = $price_config['keys'];
                    $filters['price_values'] = $price_config['values'];
                    $config_colors = Kohana::config('filter.colors');
                    foreach($config_colors as $color)
                    {
                        $filters['color'][strtolower($color)] = 0;
                    }
                    foreach($catalog_all_filters as $product_id => $filter)
                    {
                        $size_value = strtoupper($filter['size']);
                        $color_value = strtolower(trim($filter['color']));
                        $price_value = $filter['price'];
                        if(strpos($size_value, 'ONE') !== FALSE)
                        {
                            $sizes = array('ONE SIZE');
                        }
                        else
                        {
                            $sizes = explode(' ', $size_value);
                        }

                        foreach($sizes as $size)
                        {
                            $size = trim($size);
                            if(isset($size_replace[$size]))
                                $size = $size_replace[$size];
                            if(isset($filters['size'][$size]))
                                $filters['size'][$size] ++;

                            if(!isset($has_filters['size'][$size]))
                                $has_filters['size'][$size] = 0;
                            $has = 1;
                            foreach($current_filters as $f_key => $f_value)
                            {
                                if(empty($f_value) || $f_key == 'size')
                                    continue;
                                elseif($f_key == 'color' && !in_array($color_value, $f_value))
                                {
                                    $has = 0;
                                }
                                elseif($f_key == 'price' && !($price_value >= $f_value[0] && $price_value < $f_value[1]))
                                {
                                    $has = 0;
                                }
                            }
                            $has_filters['size'][$size] += $has;
                        }
                        
                        if(isset($filters['color'][$color_value]))
                            $filters['color'][$color_value] ++;

                        if(!isset($has_filters['color'][$color_value]))
                            $has_filters['color'][$color_value] = 0;
                        $has = 1;

                        foreach($current_filters as $f_key => $f_value)
                        {
                            if(empty($f_value) || $f_key == 'color')
                                continue;
                            elseif($f_key == 'size')
                            {
                                $has = 0;
                                foreach($sizes as $size)
                                {
                                    if(in_array($size, $f_value))
                                    {
                                        $has = 1;
                                        break;
                                    }
                                }
                            }
                            elseif($f_key == 'price' && !($price_value >= $f_value[0] && $price_value < $f_value[1]))
                            {
                                $has = 0;
                            }
                        }
                        $has_filters['color'][$color_value] += $has;
                        $filter_price_key = '';
                        foreach($price_config['values'] as $price_key => $price_val)
                        {
                            $price_value_array = explode('-', $price_val);
                            if($price_value >= $price_value_array[0] && $price_value < $price_value_array[1])
                            {
                                $filters['price'][$price_key] ++;
                                $filter_price_key = $price_val;
                                break;
                            }
                        }
                        if(!isset($has_filters['price'][$filter_price_key]))
                            $has_filters['price'][$filter_price_key] = 0;
                        $has = 1;
                        foreach($current_filters as $f_key => $f_value)
                        {
                            if(empty($f_value) || $f_key == 'price')
                                continue;
                            elseif($f_key == 'size')
                            {
                                $has = 0;
                                foreach($sizes as $size)
                                {
                                    if(in_array($size, $f_value))
                                    {
                                        $has = 1;
                                        break;
                                    }
                                }
                            }
                            elseif($f_key == 'color' && !in_array($color_value, $f_value))
                            {
                                $has = 0;
                            }
                        }
                        $has_filters['price'][$filter_price_key] += $has;

                    }
                }
                if(!empty($has_filters))
                {
                    foreach($has_filters['size'] as $has_key => $has_val)
                    {
                        if(array_key_exists($has_key, $size_title))
                        {
                            $has_filters['size'][$size_title[$has_key]] = $has_val;
                            unset($has_filters['size'][$has_key]);
                        }
                    }
                }
                else
                {
                    $has_filters = array();
                }

                $filters['has_filters'] = $has_filters;

                 if(LANGUAGE)
                 {
                     $key = 'color1'.LANGUAGE;
                     $color = Cache::instance('memcache')->get($key);
                     if(!empty($color) and count($color)>10)
                     {
                         $filters['color_names'] = $color;
                     }
                     else
                     {
                         $color_names = Kohana::config('color.'.LANGUAGE);
                         $filters['color_names'] = $color_names;
                         Cache::instance('memcache')->set($key, $color_names, 86400*20);
                     }
                 }
                echo json_encode($filters);
            }
        }
        exit;
    }
    
    public function action_catalog_do_filter()
    {
        if($_REQUEST)
        {
            $catalog_id = Arr::get($_REQUEST, 'catalog_id', 0);
            $type = Arr::get($_REQUEST, 'type', '');
            $value = Arr::get($_REQUEST, 'value', '');
            $current_url = Arr::get($_REQUEST, 'current_url', '');
            $lang_url = Arr::get($_REQUEST, 'lang_url', '');
            $lang = Arr::get($_REQUEST, 'lang', '');
            /* START get url $_GET params */
            $url_params = parse_url($current_url);
            $gets = array();
            $need_page = Arr::get($_REQUEST, 'need_page', 0);
            if(!empty($url_params['query']))
            {
                if($need_page || $type == 'init')
                    $get_page = true;
                else
                    $get_page = false;
                $get_array = explode('&', $url_params['query']);
                foreach($get_array as $get_val)
                {
                    $get_val_array = explode('=', $get_val);
                    if(count($get_val_array) == 2)
                    {
                        if($get_val_array[0] == 'page' && !$get_page)
                            continue;
                        $gets[$get_val_array[0]] = $get_val_array[1];
                    }
                }
            }

            /* END get url $_GET params */

            $url_path = str_replace($lang_url, '', $url_params['path']);
                
            //init filters
            $filters = array(
                'term' => array(
                    'visibility' => 1,
                    'status' => 1,
                ),
                'match' => array(),
                'range' => array(),
            );
            $filter_param = array(
                'size' => 'all',
                'price' => 'all',
                'color' => '',
            );
            $url_array = explode('/', $url_path);
            if(isset($url_array[2]) && $url_array[2]) // size
            {
                if($url_array[2] != 'all')
                    $filters['match']['attributes'] = 'size' . $url_array[2];
                $filter_param['size'] = $url_array[2];
            }
            if(isset($url_array[3]) && $url_array[3]) // price
            {
                if($url_array[3] != 'all')
                    $filters['range']['price'] = explode('-', $url_array[3]);
                if(isset($filters['range']['price'][1]))
                {
                    $filters['range']['price'][1] -= 0.01;
                }
                $filter_param['price'] = $url_array[3];
            }
            if(isset($url_array[4]) && $url_array[4]) // color
            {
                $colors = explode('_', $url_array[4]);
                if(count($colors) == 2 && $colors[0] == 'color')
                {
                    $filters['term']['color_value'] = $colors[1];
                    $filter_param['color'] = 'color_' . $colors[1];
                }
            }

            /* START set new filters */
            if($type == '' AND $value == '')
            {
                $filters = array(
                    'term' => array(
                        'visibility' => 1,
                        'status' => 1,
                    ),
                );
                $filter_param = array();
            }
            elseif($type == 'size')
            {
                if(!$value)
                {
                    unset($filters['match']['attributes']);
                    $filter_param['size'] = 'all';
                }
                else
                {
                    $filters['match']['attributes'] = 'size'.$value;
                    $filter_param['size'] = $value;
                }
                
            }
            elseif($type == 'price')
            {
                if(!$value)
                {
                    unset($filters['range']['price']);
                    $filter_param['price'] = 'all';
                }
                else
                {
                    $filters['range']['price'] = explode('-', $value);
                    if(isset($filters['range']['price'][1]))
                    {
                        $filters['range']['price'][1] -= 0.01;
                    }
                    $filter_param['price'] = $value;
                }
            }
            elseif($type == 'color')
            {
                if(!$value)
                {
                    unset($filters['term']['color_value']);
                    unset($filter_param['color']);
                }
                else
                {
                    $filters['term']['color_value'] = $value;
                    $filter_param['color'] = 'color_' . $value;
                }
            }
            /* END set new filters */
            $is_mobile = Session::instance()->get('is_mobile');
            $size = Arr::get($_REQUEST, 'limit', 20);
            $show_size = 20;
            $product_ids = array();
            $product_infos = array();
            $type_array = array('size', 'color', 'price');
            if($catalog_id && $current_url)
            {
                // judge if init
                if(empty($filters['term']['color_value']) && empty($filters['match']) && empty($filters['range']) && empty($gets['pick']) && empty($gets['sort']))
                {

                    //todo 修改分类产品功能时，注意sql的字段
                    $all_products = $this->catalog_all_products($catalog_id);

                    $count_products = count($all_products);
                    
                    if(isset($_REQUEST['page']))
                    {
                        $page = (int) $_REQUEST['page'];
                        $gets['page'] = $page;
                    }
                    else
                        $page = Arr::get($gets, 'page', 1);
                    $from = $size * ($page - 1);
                    $show_to = $from + $show_size;
                    for($i = $from;$i < $from + $size;$i ++)
                    {
                        if(isset($all_products[$i]))
                        {
                            $product_ids[] = $all_products[$i];
                            if($i < $show_to)
                            {
                                $product_ins = Product::instance($all_products[$i],$lang);
                                $cover_image = Product::instance($all_products[$i])->cover_image();
                                $product_title = $product_ins->get('name');

                                $mark = '';
                                $product_infos[] = array(
                                    'product_href' => $product_ins->permalink(),
                                    'product_id' => $all_products[$i],
                                    'image_src' => $is_mobile ? Image::link($cover_image, 4) : Image::link($cover_image, 1),
                                    'image_alt' => 'Fashion '.$product_ins->get('name'),
                                    'product_title' => $product_title,
                                    'price_old' => Site::instance()->price($product_ins->get('price'), 'code_view'),
                                    'price_new' => Site::instance()->price($product_ins->price(), 'code_view'),
                                    'has_pick' => $product_ins->get('has_pick'),
                                    'mark' => $mark,
                                );
                            }
                        }
                    }

                }
                else
                {
                    $elastic_type = 'product';
                    $elastic_index = 'basic_new';
                    $elastic = Elastic::instance($elastic_type, $elastic_index);
                    $posterity = Catalog::instance($catalog_id)->posterity();
                    $catalog_ids = $catalog_id . ' ' . implode(' ', $posterity);
                    if(isset($_REQUEST['page']))
                    {
                        $page = (int) $_REQUEST['page'];
                        $gets['page'] = $page;
                    }
                    else
                        $page = Arr::get($gets, 'page', 1);
                    $from = $size * ($page - 1);
                    $order_by = array();
                    $pick = Arr::get($gets, 'pick', 0);
                    if($pick)
                        $order_by['has_pick'] = 'desc';
                    $sort = Arr::get($gets, 'sort', 0);
                    $sorts = Kohana::config('catalog.sorts');
                    if(isset($sorts[$sort]['field']) && isset($sorts[$sort]['queue']))
                        $order_by[$sorts[$sort]['field']] = $sorts[$sort]['queue'];
                    $search_res = $elastic->search($catalog_ids, array('default_catalog'), $size, $from, $filters, $order_by);
                    $count_products = isset($search_res['hits']['total']) ? $search_res['hits']['total'] : 0;
                    if(!empty($search_res['hits']['hits']))
                    {
                        $s_row = 0;
                        
                        foreach ($search_res['hits']['hits'] as $item)
                        {
                            $product_ids[] = $item['_source']['id'];
                            if($s_row < $show_size)
                            {   
                                
                                $cover_image = isset($item['_source']['cover_image']) ? unserialize($item['_source']['cover_image']) : '';
                                if(empty($cover_image)){
                                    $product = Product::instance($item['_source']['id']);
                                    if(!empty($product->get('configs')) and !empty($product->get('configs')['default_image']))
                                    {
                                        $cover_image = array('status' => 1,
                                                                'id' => $product->get('configs')['default_image'],
                                                                'suffix' =>'jpg');
                                    }
                                    else
                                    {
                                        $image = DB::select('id', 'suffix', 'status')->from('products_productimage')->where('product_id', '=', $item['_source']['id'])->execute()->current();
                                        if(!empty($image)){
                                            $cover_image = array('status' => $image['status'],
                                                                'id' => $image['id'],
                                                                'suffix' =>$image['suffix']);
                                        }
                                    }                                                
                                }

                                
                                $mark = '';
                                $product_ins = Product::instance($item['_source']['id'],LANGUAGE);
                                $product_title = $product_ins->get('name');

                                $image_test =$is_mobile ? Image::link($cover_image, 4) : Image::link($cover_image, 1);
                                $small_lang = '';
                                if($lang)
                                {
                                    $small_lang = '/'.$lang;
                                }
                                $product_infos[] = array(
                                    'product_href' => $small_lang . '/product/' . $item['_source']['link'] . '_p' . $item['_source']['id'],
                                    'product_id' => $item['_source']['id'],
                                    'image_src' => $is_mobile ? Image::link($cover_image, 4) : Image::link($cover_image, 1),
                                    'image_alt' => 'Fashion '.$item['_source']['name'],
                                    'product_title' => $product_title,
                                    'price_old' => Site::instance()->price($product_ins->get('price'), 'code_view'),
                                    'price_new' => Site::instance()->price($product_ins->price(), 'code_view'),
                                    'has_pick' => $item['_source']['has_pick'],
                                    'mark' => $mark,
                                );
                            }
                            $s_row ++;
                        }
                    }
                }
                
                // set filter url
                $path_add = '';
                if(isset($filter_param['color']) && $filter_param['color'])
                {
                    $path_add = implode('/', $filter_param);
                }
                elseif(isset($filter_param['price']) && $filter_param['price'] != 'all')
                {
                    $path_add = implode('/', $filter_param);
                }
                elseif(isset($filter_param['size']) && $filter_param['size'] != 'all')
                {
                    $path_add = $filter_param['size'];
                }

                $path_array = explode('/', $url_path);
                $base_path = $lang_url . '/' . $path_array[1];
                if($path_add)
                    $url_params['path'] = $base_path . '/' . $path_add;
                else
                    $url_params['path'] = $base_path;
                if($url_params['host'] == '58.213.103.194')
                    $url_params['host'] = '58.213.103.194:8069';
                $put_url = $url_params['scheme'] . '://' . $url_params['host'] . $url_params['path'];
                if(!empty($gets))
                {
                    $get_array = array();
                    foreach($gets as $get_name => $get_val)
                    {
                        $get_array[] = $get_name . '=' . $get_val;
                    }
                    $get_url = '?' . implode('&', $get_array);
                    $put_url .= $get_url;
                }

                // get pagination
                if($count_products > $size)
                {
                    $_GET = $gets; // set $_GET for pagination
                    $pagination = Pagination::factory(array(
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items' => $count_products,
                        'items_per_page' => $size,
                        'view' => '/pagination_r'));
                    $pagination_fr = $pagination->render();
                }
                else
                {
                    $pagination_fr = '';
                }

                $filter_bar = array();
                if(isset($filter_param['size']) && $filter_param['size'] != 'all')
                {
                    if($filter_param['size'] == 'ONESIZE')
                        $filter_title = 'ONE SIZE';
                    else
                        $filter_title = $filter_param['size'];
                    $filter_bar['size'] = array(
                        'value' => $filter_param['size'],
                        'title' => $filter_title,
                    );
                }
                if(isset($filter_param['color']) && $filter_param['color'])
                {
                    $filter_value = str_replace('color_', '', $filter_param['color']);
                    $filter_bar['color'] = array(
                        'value' => $filter_value,
                        'title' => $filter_value,
                    );
                }
                $filter_price_config = Kohana::config('filter.price');
                if(isset($filter_param['price']) && $filter_param['price'] != 'all')
                {
                    if(in_array($filter_param['price'], $filter_price_config['values']))
                    {
                        $key = array_keys($filter_price_config['values'], $filter_param['price']);
                        $filter_title = $filter_price_config['keys'][$key[0]];
                    }
                    else
                    {
                        $filter_title = '$' . str_replace('-', ' - $', $filter_param['price']);
                    }
                    $filter_bar['price'] = array(
                        'value' => $filter_param['price'],
                        'title' => $filter_title,
                    );
                }

                $data = array(
                    'product_ids' => implode(',', $product_ids),
                    'product_infos' => $product_infos,
                    'filter_bar' => $filter_bar,
                    'put_url' => $put_url,
                    'pagination' => $pagination_fr,
                );
//                $data['product_infos'] = array_unique($data['product_infos']);
                echo json_encode($data);
                
            }
        }
        exit;
    }

    // get filter color name by language
    public function get_color_by_language($language)
    {
        $config_colors = Kohana::config('filter.colors');
        $cache = Cache::instance('memcache');
        $key = 'attributes_color_languages';
        if( ! $small_colors = $cache->get($key))
        {
            $small_colors = DB::query(Database::SELECT, 'SELECT A.name,S.de,S.es,S.fr 
                FROM `attributes` A LEFT JOIN `attributes_small` S ON A.id = S.attribute_id WHERE A.name IN
                ("' . implode('","', $config_colors) . '")')
                ->execute('slave')->as_array();
            $cache->set($key, $small_colors, 86400);
        }
        $color_names = array();
        foreach($small_colors as $color)
        {
            if(isset($color[$language]))
                $color_names[strtolower($color['name'])] = $color[$language];
            else
                $color_names[strtolower($color['name'])] = $color['name'];
        }
        return $color_names;
    }

    public function catalog_all_products($catalog_id)
    {
        $catalog_id = intval($catalog_id);
        $all_products = array();
        if($catalog_id)
        {
            $cache = Cache::instance('memcache');
            $cache_key = 'catalog_all_products' . $catalog_id;
            $all_products = $cache->get($cache_key);
            if(empty($products))
            {
                $sorts = Kohana::config('catalog.sorts');
                $orderby = $sorts[0]['field'];
                $queue = $sorts[0]['queue'];
                $all_products = Catalog::instance($catalog_id)->all_products($orderby, $queue);
                $cache->set($cache_key, $all_products, 7200);
            }

        }
        return $all_products;
    }

    public function action_test_filter()
    {
        if($_REQUEST)
        {
            $catalog_id = Arr::get($_REQUEST, 'catalog_id', 0);
            $type = Arr::get($_REQUEST, 'type', '');
            $value = Arr::get($_REQUEST, 'value', '');
            $current_url = Arr::get($_REQUEST, 'current_url', '');
            /* START get url $_GET params */
            $url_params = parse_url($current_url);
            $gets = array();
            $need_page = Arr::get($_REQUEST, 'need_page', 0);
            if(!empty($url_params['query']))
            {
                if($need_page || $type == 'init')
                    $get_page = true;
                else
                    $get_page = false;
                $get_array = explode('&', $url_params['query']);
                foreach($get_array as $get_val)
                {
                    $get_val_array = explode('=', $get_val);
                    if(count($get_val_array) == 2)
                    {
                        if($get_val_array[0] == 'page' && !$get_page)
                            continue;
                        $gets[$get_val_array[0]] = $get_val_array[1];
                    }
                }
            }

            /* END get url $_GET params */

            $url_path = str_replace(LANGPATH, '', $url_params['path']);
                
            //init filters
            $filters = array(
                'term' => array(
                    'visibility' => 1,
                    'status' => 1,
                ),
                'match' => array(),
                'range' => array(),
            );
            $filter_param = array(
                'size' => 'all',
                'price' => 'all',
                'color' => '',
            );
            $url_array = explode('/', $url_path);
            if(isset($url_array[2]) && $url_array[2]) // size
            {
                if($url_array[2] != 'all')
                    $filters['match']['attributes'] = 'size' . $url_array[2];
                $filter_param['size'] = $url_array[2];
            }
            if(isset($url_array[3]) && $url_array[3]) // price
            {
                if($url_array[3] != 'all')
                    $filters['range']['price'] = explode('-', $url_array[3]);
                if(isset($filters['range']['price'][1]))
                {
                    $filters['range']['price'][1] -= 0.01;
                }
                $filter_param['price'] = $url_array[3];
            }
            if(isset($url_array[4]) && $url_array[4]) // color
            {
                $colors = explode('_', $url_array[4]);
                if(count($colors) == 2 && $colors[0] == 'color')
                {
                    $filters['term']['color_value'] = $colors[1];
                    $filter_param['color'] = 'color_' . $colors[1];
                }
            }

            /* START set new filters */
            if($type == '' AND $value == '')
            {
                $filters = array(
                    'term' => array(
                        'visibility' => 1,
                        'status' => 1,
                    ),
                );
                $filter_param = array();
            }
            elseif($type == 'size')
            {
                if(!$value)
                {
                    unset($filters['match']['attributes']);
                    $filter_param['size'] = 'all';
                }
                else
                {
                    $filters['match']['attributes'] = 'size'.$value;
                    $filter_param['size'] = $value;
                }
                
            }
            elseif($type == 'price')
            {
                if(!$value)
                {
                    unset($filters['range']['price']);
                    $filter_param['price'] = 'all';
                }
                else
                {
                    $filters['range']['price'] = explode('-', $value);
                    if(isset($filters['range']['price'][1]))
                    {
                        $filters['range']['price'][1] -= 0.01;
                    }
                    $filter_param['price'] = $value;
                }
            }
            elseif($type == 'color')
            {
                if(!$value)
                {
                    unset($filters['term']['color_value']);
                    unset($filter_param['color']);
                }
                else
                {
                    $filters['term']['color_value'] = $value;
                    $filter_param['color'] = 'color_' . $value;
                }
            }
            /* END set new filters */
            $product_ids = array();
            $type_array = array('size', 'color', 'price');
            if($catalog_id && $current_url)
            {
                // judge if init
                if(empty($filters['term']['color_value']) && empty($filters['match']) && empty($filters['range']) && empty($gets['pick']) && empty($gets['sort']))
                {
                    $all_products = $this->catalog_all_products($catalog_id);
                    $count_products = count($all_products);
                    $size = Arr::get($_REQUEST, 'limit', 20);
                    if(isset($_REQUEST['page']))
                    {
                        $page = (int) $_REQUEST['page'];
                        $gets['page'] = $page;
                    }
                    else
                        $page = Arr::get($gets, 'page', 1);
                    $from = $size * ($page - 1);
                    
                    for($i = $from;$i < $from + $size;$i ++)
                    {
                        if(isset($all_products[$i]))
                            $product_ids[] = $all_products[$i];
                    }
                }
                else
                {
                    $elastic_type = 'product';
                    $elastic_index = 'basic';
                    $elastic = Elastic::instance($elastic_type, $elastic_index);
                    $posterity = Catalog::instance($catalog_id)->posterity();
                    $catalog_ids = $catalog_id . ' ' . implode(' ', $posterity);

                    $size = Arr::get($_REQUEST, 'limit', 20);
                    if(isset($_REQUEST['page']))
                    {
                        $page = (int) $_REQUEST['page'];
                        $gets['page'] = $page;
                    }
                    else
                        $page = Arr::get($gets, 'page', 1);
                    $from = $size * ($page - 1);
                    $order_by = array();
                    $pick = Arr::get($gets, 'pick', 0);
                    if($pick)
                        $order_by['has_pick'] = 'desc';
                    $sort = Arr::get($gets, 'sort', 0);
                    $sorts = Kohana::config('catalog.sorts');
                    if(isset($sorts[$sort]['field']) && isset($sorts[$sort]['queue']))
                        $order_by[$sorts[$sort]['field']] = $sorts[$sort]['queue'];
                    $search_res = $elastic->search($catalog_ids, array('default_catalog'), $size, $from, $filters, $order_by);
                    $count_products = isset($search_res['hits']['total']) ? $search_res['hits']['total'] : 0;
                    if(!empty($search_res['hits']['hits']))
                    {
                        foreach ($search_res['hits']['hits'] as $item)
                        {
                            $product_ids[] = $item['_source']['id'];
                        }
                    }
                }
                
                print_r($product_ids);exit;
            }
        }
        exit;
    }

    /**
     * 获取用户登录信息ajax
     * @return json 未登录则返回空,登录则返回用户名 
     * sjm add 2015-12-17
     */
    public function action_customer_login_data()
    {
        $user_session = Session::instance()->get('user');
        if(!empty($user_session))
        {
            try
            {
                $firstname = $user_session['firstname'];
                if (!$firstname)
                    $firstname = 'choieser';
                if (strlen($firstname) > 12)
                    $fname = substr($firstname, 0, 12) . '...';
                else
                    $fname = $firstname;
                $user_session['firstname'] = $fname;
                $user_session['logged_in'] = 1;
                echo json_encode($user_session);
            }
            catch (Exception $e)
            {
                Kohana_log::instance()->add('USER_AJAX', serialize($user_session));
                echo json_encode(array('logged_in' => 1, 'firstname' => 'choieser'));
            }
        }
        else
        {

            echo json_encode(array('logged_in' => 0));
        }
        exit;
    }
    
}

?>