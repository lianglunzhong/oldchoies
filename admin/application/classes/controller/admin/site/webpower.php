<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Webpower extends Controller_Admin_Site {

    private $_site_name;
    private $_product_url;
    private $_file_item_list;
    private $_file_user_info;
    private $_file_user_log;
    private $_ftp_root = '/';
    private $_ftp_server = '192.111.135.162';
    private $_ftp_account = 'choies';
    private $_ftp_password = '7skU^FlU3v9I';
    private $_local_directory = '/tmp/';
    private $_piwik_token_auth = 'fe1971555c2e9880271153ab9518c8c1';
    private $_site_id;

    public function action_itemlist_export() {
        ignore_user_abort(true);
        set_time_limit(0);

        $site_id = Arr::get($_GET, 'site_id');
        if (!empty($site_id)) {
            $this->site_id = $site_id;
        } else {
            $this->site_id = 1;
//            exit();
        }
        $start = Arr::get($_POST, 'start');
        
        $start = !empty($start) ? strtotime($start) : time()-24*3600;

        //Itemlist
        $this->_file_item_list = 'Itemlist_source1_' . date('Y-m-d', time()) . '.csv';
        $outstream_itemlist = fopen($this->_local_directory . $this->_file_item_list, 'w');
        $head_itemlist = array('Title', 'URL', 'image URL', 'image2 URL', 'Price1', 'Price2', 'Price3', 'desc1', 'desc2', 'desc3', 'Item ID', 'Type', 'Brand', 'Price level', 'Tag ID', 'Gender', 'online Date', 'offline Date', 'Stock', 'Status','Pin');
        fputcsv($outstream_itemlist, $head_itemlist);

        $this->_get_product_url();

        $products = ORM::factory('product')
                ->where('site_id', '=', $this->site_id)
                ->where('visibility', '=', 1)
                ->where('status', '=', 1)
                ->where('created', '>=', $start)
                ->find_all();
        $site = Site::instance($this->site_id);
//        $subinventory = $site->get('subinventory');
        $men_ids=array(91,234,235,236,237,238,239);
        $set_ids=array("Elf Sack","Aimer","Celebona");

        if (count($products) > 0) {

            $outstream = fopen($this->_local_directory . $this->_file_item_list, 'a');
            foreach ($products as $product) {
                    $data = array();
                    $product_instance = Product::instance($product->id);
                    $data[] = preg_replace('/[()]/','',trim($product->name));
                    $data[] = $product_instance->permalink();
                    $product_images = $product_instance->images();
                    $real_link = array();
                    $imageURL=Image::link($product_instance->cover_image(), 2);
                    $imageURL2=Image::link($product_instance->cover_image(), 4);
                    /*foreach ($product_images as $image) {
                        if ($this->site_id == 15) {
                            $real_link[] = str_replace('120x60', '600x300', Image::link($image, 4));
                        } else {
                            $real_link[] = str_replace('180x180', '400x400', Image::link($image, 4));
                        }
                    }*/
                    $data[] = !empty($imageURL) ? $imageURL : ''; //商品图片1
                    $data[] = !empty($imageURL2) ? $imageURL2 : ''; //商品图片2
                    $PriceInterval=0;
                    $PriceInterval=ceil($product_instance->price()/20);
                    $data[] = $product->price;
                    $data[] = $product_instance->price()==$product->price?'':$product_instance->price();
                    $data[] = ''; //折扣价3，无数据
                    $data[] = preg_replace('/[℃]/','',trim(strip_tags($product->description)));
                    $data[] = ''; //描述2
                    $data[] = ''; //描述3
                    $data[] = $this->site_id == 1 ? $product->sku : $product->link;
                    if($PriceInterval<=1){
                            $price="0-20";
                    }else{
                            $price=(($PriceInterval-1)*20)."-".($PriceInterval*20);
                    }

                    //$result = Db::select('name')->from('products_category')->where('id', '=', $product_instance->default_catalog())->execute();
                    $data[] = $product_instance->default_catalog(); //分类
                    $setname = Set::instance($product->set_id)->get('name');
                    $data[] = in_array($setname,$set_ids)? $setname : 'Choies'; //品牌
                    $data[] = $price; //价格区间
                    $product_tag = explode(";",$product_instance->get('filter_attributes'));
                    $product_tag = array_filter($product_tag);
                    $product_tag = implode(",",$product_tag);
                    $data[] = $product_tag; //tag id
                    $data[] = in_array($product_instance->default_catalog(),$men_ids)? '1' : '0' ; //gender

                    $data[] = date('Y-m-d', $product->created); //上线created
                    $data[] = ''; //下线

                    $result = DB::select(DB::expr('COUNT(*) AS available_stock'))
                            ->from('order_instocks')
                            ->where('status', '=', 0)
                            ->where('sku', '=', $product->sku)
                            ->execute()
                            ->current();
                    $data[] = $result['available_stock']==0?'-99':$result['available_stock'];
                    $data[] = $product->status; //状态
                    $data[] = "http://pinterest.com/pin/create/button/?url=".$product_instance->permalink()."&media=".$imageURL."&description=".trim($product->name);
                    fputcsv($outstream, $data);
            }
        }
        $re = fclose($outstream_itemlist);
        if ($re) {
            $this->_upload_to_ftp('itemlist');
        }
        message::set('导出产品信息成功！');
        $content = View::factory('admin/site/userlog_list')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_googleproduct_export() {
        ignore_user_abort(true);
        set_time_limit(0);

        $local_directory = '/home/data/www/htdocs/clothes/googleproduct/';

        $setnames=array("Shoes"=>"Apparel & Accessories > Shoes",
"Necklace "=>"Apparel & Accessories > Jewelry > Necklaces",
"Headdress "=>"Apparel & Accessories > Clothing Accessories > Hair Accessories",
"Bags/purses"=>"Apparel & Accessories > Handbags",
"Socks/Tights"=>"Apparel & Accessories > Clothing > Underwear & Socks > Socks",
"Suits/Blazers"=>"Apparel & Accessories > Clothing > Suits",
"Coats/Jackets"=>"Apparel & Accessories > Clothing > Outerwear > Coats & Jackets",
"Dress"=>"Apparel & Accessories > Clothing > Dresses ",
"Shorts"=>"Apparel & Accessories > Clothing > Shorts",
"Cardigans/Jumpers"=>"Apparel & Accessories > Clothing > Shirts & Tops",
"Skirt"=>"Apparel & Accessories > Clothing > Skirts",
"Pants"=>"Apparel & Accessories > Clothing > Pants",
"Shirt/Blouse"=>"Apparel & Accessories > Clothing > Shirts & Tops",
"T-shirt"=>"Apparel & Accessories > Clothing > Shirts & Tops",
"Vest/Basic"=>"Apparel & Accessories > Clothing > Shirts & Tops",
"Bracelet"=>"Apparel & Accessories > Jewelry > Bracelets",
"Rings"=>"Apparel & Accessories > Jewelry > Rings",
"Belts"=>"Apparel & Accessories > Clothing Accessories > Belts",
"Jeans"=>"Apparel & Accessories > Clothing > Pants",
"Hats/Caps"=>"Apparel & Accessories > Clothing Accessories > Hats",
"Sunglasses "=>"Apparel & Accessories > Clothing Accessories > Sunglasses",
"Earrings "=>"Apparel & Accessories > Jewelry > Earrings",
"Brooch "=>"Apparel & Accessories > Jewelry > Brooches & Lapels",
"Scarves/Snoods"=>"Apparel & Accessories > Clothing Accessories > Scarves & Shawls",
"Gloves"=>"Apparel & Accessories > Clothing Accessories > Wigs",
"Wigs"=>"Apparel & Accessories > Clothing Accessories > Gloves & Mittens > Gloves",
"Jumpsuits&Playsuits"=>"Apparel & Accessories > Clothing > One-pieces > Jumpsuits & Rompers",
"Hoodies/Sweatshirts"=>"Apparel & Accessories > Clothing > Shirts & Tops",
"Watch"=>"Apparel & Accessories > Jewelry > Watches",
"Occasion Dresses"=>"Apparel & Accessories > Clothing > Dresses > Day Dresses",
"Swimwear"=>"Apparel & Accessories > Clothing > Swimwear",
"Jumpsuits & Playsuits"=>"Apparel & Accessories > Clothing > One-pieces > Jumpsuits & Rompers",
"ELF SACK"=>"Apparel & Accessories > Clothing > Skirts",
"AIMER"=>"Apparel & Accessories > Clothing > Swimwear",
"Corset"=>"Apparel & Accessories > Clothing > Shirts & Tops",
"Two-piece Suit"=>"Apparel & Accessories > Clothing > Suits",
"Celebona"=>"Apparel & Accessories > Clothing > Skirts",
"Sivanna"=>"Health & Beauty > Personal Care > Cosmetics > Makeup",
"Swimwear/Beachwear"=>"Apparel & Accessories > Clothing > Swimwear",
"LEMONPAIER"=>"Apparel & Accessories > Clothing Accessories > Scarves & Shawls",
"Sleepwear"=>"Apparel & Accessories > Clothing > Sleepwear & Loungewear",
"Leggings"=>"Apparel & Accessories > Clothing > Pants",
"Scarves"=>"Apparel & Accessories > Clothing Accessories > Scarves & Shawls",
"Skirts"=>"Apparel & Accessories > Clothing > Skirts");
        //Itemlist
        $this->_file_item_list = 'Googleproduct.csv';
        $outstream_gooproductlist = fopen($local_directory . $this->_file_item_list, 'w');
        $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'google_product_category', 'product_type', 'link','image_link','condition','availability','price','brand','gender','tax','shipping','age_group','color','size','mpn');
        fputcsv($outstream_gooproductlist, $head_gooproductinfo);

        $products = DB::query(DATABASE::SELECT,"select * from products where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave');
        $outstream_gooproductlist = fopen($local_directory . $this->_file_item_list, 'a');
        $product_type="";
        foreach ($products as $product) {
            $data=array();
            $product_instance = Product::instance($product['id']);
            $imageURL=Image::link($product_instance->cover_image(), 9);
            $set_name=Set::instance($product['set_id'])->get('name');
            if($set_name){
                $product_type=$setnames[$set_name];
            }
            $data[]=$product['sku'];
            $data[]=$product['name'];
            $data[]=trim(strip_tags(str_replace(PHP_EOL, '', $product['description'])));
            $data[]=$set_name;
            $data[]=$product_type;
            $data[]=$product_type;
            $data[]=$product_instance->permalink()."+?utm_source=googleshopping&utm_medium=cse&utm_campaign=googleshoppingproduct";
            $data[]=$imageURL;
            $data[]="new";
            $data[]=$product['status']==1?"in stock":"out of stock";
            $data[]=number_format($product_instance->price(),2)." USD";
            $data[]="Choies";
            $data[]="female";
            $data[]="US::0:";
            $data[]="US:::0 USD";
            $data[]="Adult";
            $data[]="as photo";
            $data[]="see site";
            $data[]="Choies";
            fputcsv($outstream_gooproductlist, $data);
        }
        $re1 = fclose($outstream_gooproductlist);

        message::set('导出Google product信息成功！');
        Request::instance()->redirect('admin/site/webpower/userlog');
    }

    //导出用户信息
    public function action_customer_export() {
        ignore_user_abort(true);
        set_time_limit(0);

        $site_id = Arr::get($_GET, 'site_id');
        if (!empty($site_id)){
            $this->site_id = $site_id;
        }else {
            $this->site_id = 1;
        }

        $set_ids=array("Elf Sack","Aimer","Celebona");

        //Itemlist
        $this->_file_item_list = 'userinfo_' . date('Y-m-d', time()) . '.csv';
        $outstream_customlist = fopen($this->_local_directory . $this->_file_item_list, 'w');
        $head_userinfo = array('Username', 'email', 'mobile', 'gender', 'province', 'city', 'brithday', 'register date','country');
        fputcsv($outstream_customlist, $head_userinfo);

        $this->_file_user_log = 'userlog_' . date('Y-m-d', time()) . '.csv';
        $outstream_userlog = fopen($this->_local_directory . $this->_file_user_log, 'w');
        $head_userlog = array('email', 'Item ID', 'Type', 'Brand ID', 'Price level', 'Tag ID', 'Action', 'Timestamp');
        fputcsv($outstream_userlog, $head_userlog);

        $customers = DB::query(DATABASE::SELECT,"select * from customers where `site_id`=1 and `created`>=1393603200 and `created`<=1396281600")->execute();

        $outstream_customlist = fopen($this->_local_directory . $this->_file_item_list, 'a');
        $outstream_userlog = fopen($this->_local_directory . $this->_file_user_log, 'a');
        foreach ($customers as $customer) {
                $customer_address = DB::query(DATABASE::SELECT,"select * from addresses where customer_id=".$customer['id'])->execute();
                    $data = array();
                    $data[] = trim($customer['firstname'].' '.$customer['lastname']);
                    $data[] = $customer['email'];
                    $data[] = $customer_address->get('phone');
                    $data[] = $customer['gender']==1?0:1;
                    $data[] = $customer_address->get('state');
                    $data[] = $customer_address->get('city');
                    $data[] = !empty($customer['birthday']) ? date('Y-m-d', $customer['birthday']) : '';
                    $data[] = date('Y-m-d', $customer['created']);
                    $data[] = $customer_address->get('country');
                    fputcsv($outstream_customlist, $data);
               if($customer['id']){
                    $data2=array();
                    $data2[]=$customer['email'];
                    $data2[]='';//ITEM ID
                    $data2[]='';//TYPE
                    $data2[]='';//BRAND
                    $data2[]='';//PRICE
                    $data2[]='';//TAG
                    $data2[]='6';//ACTION
                    $data2[]=date('Y-m-d H:i:s', $customer['created']);//time
                    fputcsv($outstream_userlog, $data2);
                }
                if($customer['last_login_time']){
                    $data2=array();
                    $data2[]=$customer['email'];
                    $data2[]='';//ITEM ID
                    $data2[]='';//TYPE
                    $data2[]='';//BRAND
                    $data2[]='';//PRICE
                    $data2[]='';//TAG
                    $data2[]='5';//ACTION
                    $data2[]=date('Y-m-d H:i:s', $customer['last_login_time']);//time
                    fputcsv($outstream_userlog, $data2);
                }
                $wishlists = DB::query(DATABASE::SELECT,"select * from wishlists where customer_id=".$customer['id'])->execute();
                if(!empty($wishlists)){
                    foreach ($wishlists as $wishlist) {
                        $collected=array();
                        $cproducts=Product::instance($wishlist['product_id']);
                        if($cproducts){
                        $product_set = Set::instance($cproducts->get('set_id'))->get('name');
                        $product_tag = explode(";",$cproducts->get('filter_attributes'));
                        $product_tag = array_filter($product_tag);
                        $product_tag = implode(",",$product_tag);
                        $PriceInterval=ceil($cproducts->price()/20);
                        if($PriceInterval<=1){
                            $price="0-20";
                        }else{
                            $price=(($PriceInterval-1)*20)."-".($PriceInterval*20);
                        }
                        $collected[]=$customer['email'];
                        $collected[]=$cproducts->get('sku');//ITEM ID
                        $collected[]="";//TYPE
                        $collected[]=in_array($product_set,$set_ids)? $product_set : 'Choies';//BRAND
                        $collected[]=$price;//PRICE
                        $collected[]=!empty($product_tag) ? $product_tag : '';//TAG
                        $collected[]='3';//ACTION
                        $collected[]=date('Y-m-d H:i:s', $wishlist['created']);//time
                        fputcsv($outstream_userlog, $collected);
                        }
                    }
                }
                unset($product_tag,$product_set,$PriceInterval);
                $orders = DB::query(DATABASE::SELECT,"select * from orders where customer_id=".$customer['id'])->execute();
                if(!empty($orders)){
                    foreach ($orders as $order) {
                        $order_products=Order::instance($order['id'])->products();
                            foreach($order_products as $order_product){
                                $purchased=array();
                                $cproducts=Product::instance($order_product['id']);
                                if($cproducts){
                                $PriceInterval=ceil($cproducts->price()/20);
                                if($PriceInterval<=1){
                                    $price="0-20";
                                }else{
                                    $price=(($PriceInterval-1)*20)."-".($PriceInterval*20);
                                }
                                $product_tag = explode(";",$cproducts->get('filter_attributes'));
                                $product_tag = array_filter($product_tag);
                                $product_tag = implode(",",$product_tag);
                                //$product_catalog=!$cproducts->default_catalog()?$cproducts->default_catalog():"";
                                $product_set = Set::instance($cproducts->get('set_id'))->get('name');
                                $purchased[] = $customer['email'];
                                $purchased[] = $order_product['sku'];//ITEM ID
                                $purchased[] ="";//TYPE
                                $purchased[] =in_array($product_set,$set_ids)? $product_set : 'Choies';//BRAND
                                $purchased[] =$price;//PRICE
                                $purchased[] =!empty($product_tag) ? $product_tag : '';//TAG
                                $purchased[] ='2';//ACTION
                                $purchased[] =date('Y-m-d H:i:s', $order_product['created']);//time
                                fputcsv($outstream_userlog, $purchased);
                                }
                            }
                    }
                } 
            }
        $re1 = fclose($outstream_customlist);
        $re2 = fclose($outstream_userlog);
        if($re1&&$re2){
            $this->_upload_to_ftp('userlog');
        }
        message::set('导出站内用户信息成功！');
        $content = View::factory('admin/site/userlog_list')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }
    /**
     * userlog导出页面
     */
    public function action_userlog() {
        $content = View::factory('admin/site/userlog_list')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    /**
     * userlog导出功能
     */
    public function action_userlog_export() {
        ignore_user_abort(true);
        set_time_limit(0);

        $site_id = Arr::get($_GET, 'site_id');
        $set_ids=array("Elf Sack","Aimer","Celebona");
        if (!empty($site_id)) {
            $this->site_id = $site_id;
        } else {
            $this->site_id = 1;
        }

        $this->_get_site_name();
        $this->_get_product_url();
        
        $start_tented = Arr::get($_POST, 'start');
        $end_tented = Arr::get($_POST, 'end');
        
        $start = !empty($start_tented) ? strtotime($start_tented) : time()-24*3600;
        $end = !empty($end_tented) ? strtotime($end_tented) : time();
        
        $models = DB::query(DATABASE::SELECT,"select * from orders where `site_id`=1 and `created`>=".$start." and `created`<=".$end)->execute();

        $ips = array();
        foreach ($models as $model) {
            $ips[long2ip($model['ip'])] = $model['email'];
        }
        $ips = array_unique($ips);

        //userinfo
        $this->_file_user_info = 'userinfo_' . date('Y-m-d', time()) . '.csv';
        $outstream_userinfo = fopen($this->_local_directory . $this->_file_user_info, 'w');
        $head_userinfo = array('Username', 'email', 'mobile', 'gender', 'province', 'city', 'brithday', 'register date','country');
        fputcsv($outstream_userinfo, $head_userinfo);

        //userlog
        $this->_file_user_log = 'userlog_' . date('Y-m-d', time()) . '.csv';
        $outstream_userlog = fopen($this->_local_directory . $this->_file_user_log, 'w');
        $head_userlog = array('email', 'Item ID', 'Type', 'Brand ID', 'Price level', 'Tag ID', 'Action', 'Timestamp');
        fputcsv($outstream_userlog, $head_userlog);

        foreach ($ips as $ip => $email) {
            $url = 'http://piwik.choies.com/index.php?module=API&method=Live.getLastVisitsDetails&idSite=1&period=range&date=' . date('Y-m-d', $start) . ',' . date('Y-m-d', $end) . '&format=JSON&token_auth=' . $this->_piwik_token_auth . '&segment=visitIp==' . $ip;
            $html = $this->curl_file_get_contents($url);
            $data = json_decode($html);

            if (!empty($data)) {
                $customer=array();
                /**记录用户登录购买和收藏BEGIN**/
                $user = DB::query(DATABASE::SELECT,"select * from customers where `email`='".$email."'")->execute();
                if($user->get('id')){
                    $customer[]=$email;
                    $customer[]='';//ITEM ID
                    $customer[]='';//TYPE
                    $customer[]='';//BRAND
                    $customer[]='';//PRICE
                    $customer[]='';//TAG
                    $customer[]='6';//ACTION
                    $customer[]=date('Y-m-d H:i:s', $user->get('created'));//time
                    fputcsv($outstream_userlog, $customer);
                }
                if($user->get('last_login_time')){
                    $customer=array();
                    $customer[]=$email;
                    $customer[]='';//ITEM ID
                    $customer[]='';//TYPE
                    $customer[]='';//BRAND
                    $customer[]='';//PRICE
                    $customer[]='';//TAG
                    $customer[]='5';//ACTION
                    $customer[]=date('Y-m-d H:i:s', $user->get('last_login_time'));//time
                    fputcsv($outstream_userlog, $customer);
                }
                $wishlists = DB::query(DATABASE::SELECT,"select * from wishlists where `customer_id`=".$user->get('id'))->execute();
                if(!empty($wishlists)){
                    foreach ($wishlists as $wishlist) {
                        $collected=array();
                        if($wishlist['product_id']){
                        $cproducts=Product::instance($wishlist['product_id']);
                        $product_set = Set::instance($cproducts->get('set_id'))->get('name');
                        $product_tag = explode(";",$cproducts->get('filter_attributes'));
                        $product_tag = array_filter($product_tag);
                        $product_tag = implode(",",$product_tag);
                        $collected[]=$email;
                        $collected[]=$cproducts->get('sku');//ITEM ID
                        $collected[]="";//TYPE
                        $collected[]=in_array($product_set,$set_ids)? $product_set : 'Choies';//BRAND
                        $collected[]=$cproducts->price();//PRICE
                        $collected[]=!empty($product_tag) ? $product_tag : '';//TAG
                        $collected[]='3';//ACTION
                        $collected[]=date('Y-m-d H:i:s', $wishlist['created']);//time
                        fputcsv($outstream_userlog, $collected);
                        }
                    }
                }

                $orders = DB::query(DATABASE::SELECT,"select * from orders where customer_id=".$user->get('id'))->execute();
                if(!empty($orders)){
                    foreach ($orders as $order) {
                        $order_products=Order::instance($order['id'])->products();
                            foreach($order_products as $order_product){
                                $purchased=array();
                                if($order_product['id']){
                                $cproducts=Product::instance($order_product['id']);
                                $product_tag = explode(";",$cproducts->get('filter_attributes'));
                                $product_tag = array_filter($product_tag);
                                $product_tag = implode(",",$product_tag);
                                $product_set = Set::instance($cproducts->get('set_id'))->get('name');
                                $purchased[]=$email;
                                $purchased[]=$order_product['sku'];//ITEM ID
                                $purchased[]="";//TYPE
                                $purchased[]=in_array($product_set,$set_ids)? $product_set : 'Choies';//BRAND
                                $purchased[]=$order_product['price'];//PRICE
                                $purchased[]=!empty($product_tag) ? $product_tag : '';//TAG
                                $purchased[]='2';//ACTION
                                $purchased[]=date('Y-m-d H:i:s', $order_product['created']);//time
                                fputcsv($outstream_userlog, $purchased);
                                }
                            }
                    }
                }
                /**记录用户登录购买和收藏END**/
                $product_name = array();
                $Timestamp='';$product_set='';$product_brand='';
                foreach ($data as $item) {
                    $actions = array();
                    foreach ($item->actionDetails as $key=>$value) {
                        $pattern = '/http:\/\/www\.' . $this->_site_name . '\.com\/(product|cart)\/(.*)/';
                        preg_match($pattern, $value->url, $matches);
                        if (!empty($matches)) {
                            $actions[$key] = $matches;
                        }
                    }
                    $Timestamp=$item->serverTimestamp;
                    if (!empty($actions)) {
                        foreach ($actions as $item) {
                            $output = array();
                            $action_name = 1;
                            $output[] = $email;
                            switch ($item[1]) {
                                case 'product':
                                    $product_link = $item[2];
                                    break;
                                case 'cart':
                                    $action_name = 4;
                                    break;
                                case 'order':
                                    $action_name = 2;
                                    break;
                                default:
                                    break;
                            }
                        unset($product_sku,$product_catalog,$product_price,$product_tag,$product_set,$product_brand);
                        if($action_name==1){
                        $product_link=explode("_p",$product_link);
                        if(!empty($product_link[0])){
                            $product = DB::query(DATABASE::SELECT,'select * from products where `link`="'.$product_link[0].'"')->execute();
                            if($product->get('id')){
                                $products=Product::instance($product->get('id'));
                                $product_sku = $products->get('sku');
                                //$product_catalog = $products->default_catalog();
                                $product_price = $products->get('price');
                                $product_tag = explode(";",$products->get('filter_attributes'));
                                $product_tag = array_filter($product_tag);
                                $product_tag = implode(",",$product_tag); 
                                $product_set = Set::instance($products->get('set_id'))->get('name');
                                $product_brand=in_array($product_set,$set_ids)? $product_set : 'Choies';
                            }
                            }
                        }
                        $output[]= !empty($product_sku) ? $product_sku : ''; //item id
                        $output[]= ""; //item type
                        $output[]= !empty($product_brand) ? $product_brand : ''; //Brand
                        $output[]= !empty($product_price) ? $product_price : ''; //price
                        $output[]= !empty($product_tag) ? $product_tag : ''; //tag
                        $output[]= $action_name; //action
                        $output[]= date('Y-m-d H:i:s', $Timestamp); //time
                        if(!empty($product_link[0])&&$product->get('id')){
                            fputcsv($outstream_userlog, $output);
                        }
                        }
                    }
                }
                


                /***$product_name = array_unique($product_name);
                $product_ids = array();
                foreach ($product_name as $item) {
                    if (strpos($item, '?') === FALSE && strpos($item, '#') === FALSE && strpos($item, '&') === FALSE) {
                        $product_ids[] = $item;
                    }
                }
                $product_name_str = implode(",", $product_ids);
                $output[] = $product_name_str;
                $output[] = ''; //分类
                $output[] = ''; //Brand ID
                $output[] = ''; //Price level
                $output[] = ''; //Tag ID
                $output[] = $action_name;
                $output[] = date('Y-m-d H:i:s', time());***/
                

                //写入userinfo文件
                $this->_write_user_info($email);
            }
        }

        $re = fclose($outstream_userlog);
        $re2 = fclose($outstream_userinfo);
        //执行产品信息导出
        //$this->_itemlist_export();


        if ($re && $re2) {
            $this->_upload_to_ftp('userlog');
            message::set('导出用户信息成功！');
        }
        $content = View::factory('admin/site/userlog_list')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    private function curl_file_get_contents($url){
       $ch = curl_init();
        $timeout = 5; 
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file_contents = curl_exec($ch);
        curl_close($ch);
       return $file_contents;
     }

    private function _write_user_info($email) {
        $model = ORM::factory('customer')
                ->where('site_id', '=', $this->site_id)
                ->where('email', '=', $email)
                ->find();

        $outstream = fopen($this->_local_directory . $this->_file_user_info, 'a');

        $data = array();
        $data[] = $model->firstname . ' ' . $model->lastname;
        $data[] = $model->email;

        $model_address = ORM::factory('address')
                ->where('customer_id', '=', $model->id)
                ->find();

        $data[] = $model_address->phone;
        $data[] = $model->gender==1?0:1;
        $data[] = $model_address->state;
        $data[] = $model_address->city;
        $data[] = !empty($model->birthday) ? date('Y-m-d', $model->birthday) : '';
        $data[] = date('Y-m-d', $model->created);
        $data[] = $model_address->country;
        fputcsv($outstream, $data);
    }

    /**
     * 获取产品的链接
     * @param type $link
     * @return string
     */
    private function _get_product_url() {
        switch ($this->site_id) {
            case 15:
                $this->_product_url = 'http://www.glassesshop.com/eyeglasses/';
                break;
            case 1:
                $this->_product_url = 'http://www.choies.com/product/';
                break;
            default:
                $this->_product_url = 'none';
                break;
        }
    }

    /**
     * 导出后上传到ftp
     * @param type $mark 标记
     */
    private function _upload_to_ftp($mark) {
        switch ($this->site_id) {
            case 1:
                $this->_ftp_account = 'choies';
                $this->_ftp_password = '7skU^FlU3v9I';
                break;
            default:
                $this->_ftp_account = '';
                $this->_ftp_password = '';
                break;
        }
        $conn_id = ftp_connect($this->_ftp_server);
        $login_result = ftp_login($conn_id, $this->_ftp_account, $this->_ftp_password);

        if ($login_result) {
            if ($mark == 'userlog') {
                ftp_put($conn_id, $this->_ftp_root . $this->_file_user_log, $this->_local_directory . $this->_file_user_log, FTP_BINARY);
                ftp_put($conn_id, $this->_ftp_root . $this->_file_user_info, $this->_local_directory . $this->_file_user_info, FTP_BINARY);
            } else {
                ftp_put($conn_id, $this->_ftp_root . $this->_file_item_list, $this->_local_directory . $this->_file_item_list, FTP_BINARY);
            }
        }
        ftp_close($conn_id);
    }

    /**
     * 获取网站的名称
     * @return string
     */
    private function _get_site_name() {
        switch ($this->site_id) {
            case 1:
                $this->_site_name = 'choies';
                break;
            default:
                $this->_site_name = 'none';
                break;
        }
    }

}
