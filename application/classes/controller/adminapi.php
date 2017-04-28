<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Adminapi extends Controller_Webpage
{
    //后台调用，删除产品缓存，访问产品页时，重新生成缓存
    public function action_delete_product_cache()
    {

        $id = $_POST['id'];
        if(!$id)
            return false;
        $cache = Cache::instance('memcache');
        $langs = array( 'de', 'es', 'fr', '');
        foreach ($langs as $lang)
        {
            $key = 'productcache/'.$id.'/'.$lang;
            $cache->delete($key);
        }

    }

    //后台订单详情页产品缺货发送邮件
    public function action_order_item_outstock_email()
    {   
        if($_POST)
        {
            $order_id = Arr::get($_POST, 'order_id', 0);
            $items = Arr::get($_POST, 'items', 0);

            // $order_id = 869880;
            // $items = "1696766,1696767";

            if($order_id && $items )
            {
                $orderData = DB::select('ordernum', 'email', 'shipping_firstname', 'payment_status')->from('orders_order')->where('id', '=', $order_id)->execute('slave')->current();

                $updateItems = array();
                #去除前后的双引号“”
                $items = substr($items, 1, -1);
                #转为数组
                $itemsArr = explode(',',$items);

                foreach($itemsArr as $item_id)
                {
                    // $updateItems[] = DB::select('name', 'sku', 'price', 'attributes','quantity')->from('orders_orderitem')->where('id', '=', $item_id)->execute('slave')->current();
                    $orderitem = DB::select('name', 'product_id', 'price', 'attributes','quantity')->from('orders_orderitem')->where('id', '=', $item_id)->execute('slave')->current();
                    $product_id = $orderitem['product_id'];
                    $product = DB::select('sku','name')->from('products_product')->where('id', '=', $product_id)->execute('slave')->current();
                    $updateItems[] = array('name'=>$product['name'],'sku'=>$product['sku'],'price'=>$orderitem['price'],'attributes'=>$orderitem['attributes'],'quantity'=>$orderitem['quantity']);
                }

                if(!empty($updateItems))
                {   
                    try
                    {
                        $rcpt = $orderData['email'];
                        // $rcpt = "2546763702@qq.com";
                        $rcpts = array($rcpt, 'service@choies.com');
                        $from = Site::instance()->get('email');
                        $subject = "Sorry dear, item you have ordered from Choies is not available now!";
                        $body = View::factory('/order/item_outstock_mail')->set('orderData', $orderData)->set('updateItems', $updateItems);
                        // $this->template->content = View::factory('/order/item_outstock_mail')->set('orderData', $orderData)->set('updateItems', $updateItems);
                        $send = Mail::Send($rcpts, $from, $subject, $body);
                    }catch (Exception $e)
                    {
                        kohana::$log->add('send_email_error',$e);
                    }
                    
                }    
            }
        }
    }

    //后台订单详情页产品缺货报等天数发送邮件
    public function action_baodeng_email()
    {
        if($_POST)
        {
            $order_id = Arr::get($_POST, 'order_id', 0);
            $days = Arr::get($_POST, 'day', 0);
            $items = Arr::get($_POST, 'items', 0);
            #去除前后的双引号“”
            $items = substr($items, 1, -1);

            api::send_wait_email($items,$order_id,$days);
        }
    }


    //后台调用，设置首页手机站底部推荐产品的缓存
    public function action_phone_product()
    {
        if($_POST)
        {
            $skus = Arr::get($_POST, 'skus', 0);

            #去除前后的双引号“”
            $skus = substr($skus, 1, -1); 
            kohana::$log->add('skus2',$skus); 

            #转为数组
            $skuarr = explode(',',$skus); 

            #设置缓存
            $cache = Cache::instance('memcache');
            $cache->set('indexsku',$skuarr,30*86400);

        }
    }


    //后台调用，新品促销分类产品关联
    public function action_new_relate()
    {
        if($_POST)
        {
            $relate_type = Arr::get($_POST, 'relate_type', 1);

            $today = time();

            if ($relate_type == 1){
                $_2Weekslater = $today - 1209600 / 2; //一周前`
            }else
            {
                $_2Weekslater = $today - 1209600; //两周前
            }

            #新品分类
            $category_id = DB::select('id')->from('products_category')->where('link', '=', 'new-product')->execute('slave')->get('id');
            // $category_id = DB::select('id')->from('products_category')->where('link', '=', 'new')->execute('slave')->get('id');
            kohana::$log->add('category_id', $category_id);

            #新品产品
            // $new_products = DB::query(Database::SELECT, 'SELECT id,sku FROM products_product WHERE visibility = 1 AND display_date >= ' . $_2Weekslater . ' AND display_date < ' . $today)->execute('slave');
            $new_products = DB::query(Database::SELECT, 'SELECT id,sku FROM products_product WHERE visibility = 1 AND display_date >= 1487748902 AND display_date < ' . $today)->execute('slave');
            $products = array();
            $productArr = array();
            $cache = Cache::instance('memcache');
            foreach ($new_products as $idx => $p)
            {
                try {
                    $pro_cate = DB::query(Database::SELECT,"SELECT id FROM products_categoryproduct WHERE category_id =".$category_id." AND  product_id = ".$p['id'])->execute('slave')->get('id');
                    if($pro_cate){} else 
                    {
                        DB::insert('products_categoryproduct', array('category_id', 'product_id', 'position'))
                        ->values(array($category_id, $p['id'], $idx))
                        ->execute();
                    }
                } catch (Exception $e) {}

                array_push($productArr, $p['sku']);

                $cache_key = 'product_catalogs1_' . $p['id'];
                $product_categorys = DB::query(Database::SELECT,"SELECT category_id FROM products_categoryproduct WHERE product_id = ".$p['id'])->execute()->as_array('category_id','category_id');
                $cache->set($cache_key, $product_categorys, 3600);
                
            }

            $sql = 'SELECT id,price FROM products_product';
            $skus = '';

            foreach($productArr as $key)
            {
                $key = trim($key);
                if($key)
                    $skus .= '"' . $key . '",';
            }
            $skus .= '""';
            $sql .= ' WHERE sku IN (' . $skus . ')';

            $products = DB::query(Database::SELECT, $sql)->execute()->as_array();

            foreach ($products as $key => $p) 
            {
                $price = Product::instance($p['id'])->price();
            }
        }
    }


    //后台调用，返回产品现售价
    public function action_product_sale_price()
    {
        if($_POST)
        {
            $product_id = Arr::get($_POST,'product_id',0);
            kohana::$log->add('product_id',$product_id);
            $price = Product::instance($product_id)->price();
            $data = array();
            $data[] = $price;
            echo json_encode($data);
            exit;
        }
    }

    //缓存产品现售价，供后台导出获取
    public function action_memcache_test()
    {
        $id_start = Arr::get($_GET,'id_start',0);
        $id_end = Arr::get($_GET,'id_end',0);
        $id_start = (int)$id_start;
        $id_end = (int)$id_end;

        $cache = Cache::instance('memcache');
        $products = DB::select('id')
            ->from('products_product')
            ->where('id', '>=', $id_start)
            ->where('id', '<', $id_end)
            ->execute()
            ->as_array();

        foreach ($products as $product) {
            $price = Product::instance($product['id'])->price();
            $price = (string)$price;
            $cache = Cache::instance('memcache');
            $key = 'product_price_for_admin_'.(string)$product['id'];
            $cache->set($key,$price,30*86400);
        }
        echo "<pre>";
        echo 'https://www.choies.com/adminapi/memcache_test?id_start='.$id_start.'&id_end='.$id_end;
        echo "<pre>";
        echo "缓存成功";
        exit;
    }

    //缓存产品现售价，供后台导出获取
    public function action_productprice_memcache_foradmin($id)
    {
        if(empty($id)) {
            echo "<pre>";
            echo "url不正确！";
            exit;
        }

        $id = (int)$id;

        $id_start = ($id - 1) * 5000;
        $id_end = $id_start + 5000;

        $cache = Cache::instance('memcache');
        $products = DB::select('id')
            ->from('products_product')
            ->where('id', '>=', $id_start)
            ->where('id', '<', $id_end)
            ->execute()
            ->as_array();

        foreach ($products as $product) {
            $price = Product::instance($product['id'])->price();
            $price = (string)$price;
            $cache = Cache::instance('memcache');
            $key = 'product_price_for_admin_'.(string)$product['id'];
            $cache->set($key,$price,10*86400);
        }
        echo "<pre>";
        echo "product id start:".$id_start."  end:".$id_end;
        echo "<pre>";
        echo "缓存成功";
        exit;
    }
}

