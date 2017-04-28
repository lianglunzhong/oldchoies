<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Cart
 * @category	Liabrary
 * @author     Vincent
 * @copyright  (c) 2009-2012 Cofree
 */
class Cartcookie
{

    /**
     * Add single product to cart
     * @param array $data
     * @return Null
     */
    public static function add2cart($data)
    {
        // simple product
        // config product
        // package product
        if (!isset($data['configs']))
            $data['configs'] = '';
        if (!Product::instance($data['id'])->get('visibility') OR !Product::instance($data['id'])->get('status'))
        {
            return false;
        }
        $product = array(
            'id' => $data['id'],
            'items' => $data['items'],
            'quantity' => intval($data['quantity']) > 0 ? intval($data['quantity']) : 1,
            'type' => $data['type'],
            'configs' => $data['configs'],
            'price' => isset($data['price']) ? $data['price'] : 0,
        );
        if ($data['type'] == 3 OR $data['type'] == 0)
            $product['attributes'] = $data['attributes'];

        //TODO 棄1�7查传递过来的产品合法性（产品id是否存在，库存是否满足，id是否与items里面的内容相匹配）！
        sort($data['items']);
        $key = $data['id'] . '_' . $data['type'] . '_' . md5(serialize($data['items'])) . (isset($data['attributes']) ? '_' . md5(serialize($data['attributes'])) : '');

        //if(self::ishavepromotion($data['id'])){

            self::set($key, $product);
        //}
       
    }

/**
    *get promition product
    * @param string $id
    * @return true or false;
    */

    public static function ishavepromotion($id)
    {
        $proarr = array(50051,50050);
        if(in_array($id,$proarr)){
            $customer_id = Customer::instance()->logged_in();
            if(!$customer_id){
                return false;
            }
            $memcache_key = $customer_id.'_get0.01product';
               $ispromotion = Cache::instance('memcache')->get($memcache_key);
               if(!$ispromotion){
                   Cache::instance('memcache')->set($memcache_key, 1,604800);
                   return true;
               }elseif($ispromotion == 1){
                    return false;
               }else{
                   return true;                   
               }
        }else{
            return true;
        }

    }

    /**
     * Set cart products
     * @param string $key
     * @param array $data
     * @return Null
     */
    public static function set($key, $data)
    {
        $cart_products = Session::instance()->get('cart_products');

        $isgift = 0 ;
        $giftarr = Site::giftsku();
        if(in_array($data['id'],$giftarr)){
            $isgift = 1;
        }
        if(isset($cart_products)){
         foreach($cart_products as $k1=>$v1){
            if(in_array($v1['id'],$giftarr) && $isgift == 1){
                return false;
            }
        }           
        }

        if (isset($cart_products[$key]))
        {
            $cart_products[$key]['quantity'] += $data['quantity'];
        }
        else
        {
            $cart_products[$key] = $data;
        }

        if ($data['price'])
        {
            $cart_products[$key]['price'] = round($data['price'], 2);
            $cart_products[$key]['is_killer'] = 1;
        }
        else
        {
            $cart_products[$key]['price'] = round(self::product_price($cart_products[$key]), 2);
            $cart_products[$key]['is_killer'] = 0;
        }

        if ($data['type'] == 0)
        {
            $cart_products[$key]['price'] += round($data['attributes']['delivery time'], 2);
        }

        Session::instance()->set('cart_products', $cart_products);
    }

    /**
     * Set the quantity of cart product
     * @param string $key
     * @param int $quantity
     * @param bool $offset	TRUE: ADD	FALSE: RESET
     */
    public static function quantity($key, $quantity, $offset = TRUE)
    {
        $products = Session::instance()->get('cart_products');

        switch ($offset)
        {
            case TRUE :
                $products[$key]['quantity'] = ($products[$key]['quantity'] + $quantity) > 0 ? ($products[$key]['quantity'] + $quantity) : 1;
                break;
            case FALSE :
                $products[$key]['quantity'] = $quantity > 0 ? $quantity : 1;
                break;
        }

        $products[$key]['price'] = self::product_price($products[$key]);
        Session::instance()->set('cart_products', $products);
    }

    /**
     * Get product in cart
     * @param string $key
     * @return array or bool
     */
    public static function product($key)
    {
        $cart_products = Session::instance()->get('cart_products');

        if (isset($cart_products[$key]))
        {
            return $cart_products[$key];
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Delete product from cart
     * @param string $key
     * @return bool
     */
    public static function delete($key)
    {
        $key = str_replace('0000', '.', $key);
        $arr = explode("_",$key);
        $key = self::getkey($key);
        $cart_products = Session::instance()->get('cart_products');

        //cartcookie
        if($customer_id = Customer::logged_in()){
            DB::delete('carts_cartitem')->where('customer_id', '=', $customer_id)->and_where('item_id', '=', $arr[0])->and_where('key', '=', $arr[1])->execute();

        }else{
            $cookie_id = Kohana_Cookie::get('Customer_login_id');
            if($cookie_id){
            DB::delete('carts_cartitem')->where('customer_id', '=', $customer_id)->and_where('item_id', '=', $arr[0])->and_where('key', '=', $arr[1])->execute();
            }
        }

        if (isset($cart_products[$key]))
        {
            unset($cart_products[$key]);
            Session::instance()->set('cart_products', $cart_products);

            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Get cart amount
     * @param array $amount    Order products array. If null, get from cart session.
     * @param array $shipping    Order shiping array. If null, get from cart session.
     * @param string $coupon     Order coupon code. If null, get from cart session.
     * @return array $amount
     */
    public static function amount($products = NULL, $shipping = NULL, $coupon = NULL)
    {
        // Get items' total
        $cart_products = $products ? $products : Session::instance()->get('cart_products');
        $amount_products = self::product_amount($cart_products);

        //Get coupon save
        $coupon_code = $coupon ? $coupon : self::coupon();
        $amount_save = Coupon::instance($coupon_code)->check() ? Coupon::instance($coupon_code)->save($amount_products) : 0;

        //Get shipping total
        $shipping = $shipping ? $shipping : self::shipping();
        $amount_shipping = $shipping['price'] ? $shipping['price'] : 0;

        //Get drop shipping
        $drop_shipping = self::drop_shipping();
        $amount_drop_shipping = $drop_shipping == 1 ? '0.01' : '0';

        //Get points save
        $site = Site::instance();
        $amount_points = $site->price(Session::instance()->get('cart_points', 0) / 100, NULL, 'USD', $site->currency_get($site->default_currency()));

        $amount_total = $amount_products + $amount_shipping - $amount_save + $amount_drop_shipping - $amount_points;
        if ($amount_total < 0)
            $amount_total = 0;

        $amount = array(
            'items' => $amount_products,
            'shipping' => $amount_shipping,
            'save' => $amount_save,
            'coupon_save' => $amount_save,
            'drop_shipping' => $amount_drop_shipping,
            'point' => $amount_points,
            'total' => round($amount_total, 2),
            'insurance' =>0.99
        );
        return $amount;
    }

    public static function product_price($product)
    {
        if (!$product)
        {
            return FALSE;
        }

        $type = isset($product['type']) ? $product['type'] : 3;
        switch($type)
        {
//                        case 0://箄1�7单产哄1�7
            case 1://配置产品
                $price = Product::instance($product['id'])->price($product['quantity']);
                break;
            case 2://打包产品
            default:
                $p_price = Product::instance($product['id'])->price($product['quantity']);
                $c_price = $product['price'];
                $price = $c_price < $p_price ? $c_price : $p_price;
                break;
        }

        //判断是否为赠品
        $giftarr = Site::giftsku();
        if(in_array($product['id'], $giftarr)){
            $p_price = 0;
        }

        return $price;
    }

    /**
     * Get product amount
     * @param <array> $products		Order Products, Null: Cart products
     * @return <int>	$product_amount
     */
    public static function product_amount($products = array())
    {
        $product_amount = 0;

        if ($products)
        {
            foreach ($products as $product)
            {
                $product_amount += self::product_price($product) * $product['quantity'];
            }
        }

        return $product_amount;
    }

    /**
     * Get product quantity
     * @param <array> $products
     * @return <float>$count
     */
    public static function count($products = array())
    {
        //add cart cookie
//                $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
//                if(!$referer OR !toolkit::is_our_url($referer))
//                {
//                        $cartid = $_COOKIE["cartid"];
//                        if($cartid)
//                        {
//                                $cart_products = DB::select('value')->from('cartcookies')->where('id', '=', $cartid)->execute()->get('value');
//                                
//                                Session::instance()->set('cart_products', unserialize($cart_products));
//                        }
//                }

        $products = Session::instance()->get('cart_products', array());
        if (!empty($products))
        {
            foreach ($products as $key => $product)
            {
                if (!Product::instance($product['id'])->get('visibility') OR !Product::instance($product['id'])->get('status'))
                {
                    unset($products[$key]);
                }
            }
        }
        $count = 0;

        if ($products)
        {
            foreach ($products as $product)
            {
                $count += $product['quantity'];
            }
        }
        return $count;
    }

    /**
     * Get Cart items
     * @param <array> $products
     * @return <array> Cart items
     */
    public static function items($products = array())
    {
        $data = array();
        if ($products)
        {
            foreach ($products as $product)
            {
                if ($product['type'] == 0 OR $product['type'] == 3)
                {
// simple and config product
                    if (isset($data[$product['id']]))
                    {
                        $data[$product['id']] += $product['quantity'];
                    }
                    else
                    {
                        $data[$product['id']] = $product['quantity'];
                    }
                }
                else if ($product['type'] == 1)
                {
// config product
                    if (isset($data[$product['items'][0]]))
                    {
                        $data[$product['items'][0]] += $product['quantity'];
                    }
                    else
                    {
                        $data[$product['items'][0]] = $product['quantity'];
                    }
                }
                else if ($product['type'] == 2)
                {
                    //$package_items = $this->get_items($product['items']); 
                    foreach ($product['items'] as $item)
                    {
                        if (isset($data[$item['items']]))
                        {
                            $data[$item['items']] += $item['quantity'];
                        }
                        else
                        {
                            $data[$item['items']] = $item['quantity'];
                        }
                    }
                }
            }
        }
        return $data;
    }

    /**
     * Get cart weight
     * @param <array> $products
     * @return <float> $weight
     */
    public static function weight($products = array())
    {
        $products = $products ? $products : Session::instance()->get('cart_products');
        $items = self::items($products);
        $weight = 0;
        foreach ($items as $item => $quantity)
        {
            $weight += Product::instance($item)->get('weight') * $quantity;
        }
        return $weight;
    }

    /*     * ** *****************************************************************************************
     * Promotion
     * ******************************************************************************************** */

    public static function largess_add($largess = array())
    {
        if ($largess)
        {
            Session::instance()->delete('cart_largess_add');
            Session::instance()->set('cart_largess_add', $largess);
        }
        else
        {
            $largess_add = Session::instance()->get('cart_largess_add');
            Session::instance()->delete('cart_largess_add');
            return $largess_add;
        }
    }

    public static function largess_delete($largess = NULL)
    {
        if ($largess)
        {
            Session::instance()->delete('cart_largess_delete');
            Session::instance()->set('cart_largess_delete', $largess);
        }
        else
        {
            $largess_delete = Session::instance()->get('cart_largess_delete');
            Session::instance()->delete('cart_largess_delete');
            return $largess_delete;
        }
    }

    public static function largess($largess = array())
    {
        if ($largess)
        {
            Session::instance()->delete('cart_largesses');
            Session::instance()->set('cart_largesses', $largess);
        }
        else
        {
            return Session::instance()->get('cart_largesses');
        }
    }

    public static function promotion_log($promotion_log = array())
    {
        if ($promotion_log)
        {
            Session::instance()->delete('cart_promotion_logs');
            Session::instance()->set('cart_promotion_logs', $promotion_log);
        }
        else
        {
            return Session::instance()->get('cart_promotion_logs');
        }
    }

    /*     * ********************************************************************************************
     * End Promotion
     * ******************************************************************************************** */

    /**
     * Drop Shipping
     */
    public static function drop_shipping($value = NULL)
    {
        if (isset($value))
        {
            Session::instance()->set('cart_drop_shipping', $value);
        }
        else
        {
            return Session::instance()->get('cart_drop_shipping');
        }
    }

    //return cartcookie product
    public static function getcartcookie()
    {

    $products = Session::instance()->get('cart_products', array());

        $customer_id = Customer::instance()->logged_in();
        if(!isset($customer_id)){
                $customer_id = Kohana_Cookie::get('Customer_login_id');
            }  
            if($customer_id){
                $carproducts = DB::select()->from('carts_cartitem')->where('customer_id','=',$customer_id)->where('is_cart','=','1')->execute(); 

            foreach($carproducts as $k1 =>$v1){
                $v2= self::getkey($v1['item_id'].'_'.$v1['key']);
                $data = self::getdata($v1['item_id'].'_'.$v1['key']);

                    if (!isset($products[$v2]))
                    {
                      self::add2cart($data);
                    }                
            }       
        }  
     
    }


    /**
     * Get cart all
     * @return array
     */
    public static function get($order = NULL)
    {
        self::getcartcookie();

        $products = Session::instance()->get('cart_products', array());
        $stock_tips = array();
        $extra_flg = TRUE;//判断是否收取低价产品增值税
        $extra_fee = 0;//记录购物车产品中增值税最高值
        if (!empty($products))
        {
            //vip
            $customer_id = Customer::instance()->logged_in();
            $vip_level = Customer::instance($customer_id)->get('is_vip');
			//新 vip    2016-4-27
            if(!$vip_level){
                $vip_level = 0;
				$vipconfig = Site::instance()->vipconfig();
				$vip = $vipconfig[0]; 
            }else{
				$vipconfig = Site::instance()->vipconfig();
				$vip = $vipconfig[4]; 
			}
            foreach ($products as $key => $product)
            {
                if (!Product::instance($product['id'])->get('visibility') OR !Product::instance($product['id'])->get('status') OR Product::instance($product['id'])->get('stock')==0)
                {
                    unset($products[$key]);
                    continue;
                }

                if(Product::instance($product['id'])->get('extra_fee')==0){
                    $extra_flg = FALSE;//一旦有不收增值税产品，购物车就不收取增值税
                }else{
                    $extra_fee = $extra_fee>Product::instance($product['id'])->get('extra_fee')?$extra_fee:Product::instance($product['id'])->get('extra_fee');
                }
                
                if (Product::instance($product['id'])->get('stock') == -1)
                {
                    $postsize = $product['attributes']['Size'];
                    if(Product::instance($product['id'])->get('set_id') == 2)
                    {
                       
                       $att = kohana::config('sites.apishoes');
                        if(strpos($postsize, '-') !== FALSE)
                        {
                            $newsizearr = explode('-',$postsize);
                            $postsize = $newsizearr[0].'-UK'.$newsizearr[1];
                        }

                        if(is_numeric($postsize))
                        {
                            $postsize = 'EUR'.$postsize;
                        }
                       foreach ($att as  $value) 
                       {
                            $newatt = explode('/',$value);
                            if(in_array($postsize,$newatt))
                            {
                                $postsize = $value;
                            }
                       }
                    }

                    $stock = DB::select('stock')->from('products_productitem')
                            ->where('product_id', '=', $product['id'])
                            ->where('attribute', '=', $postsize)
                            ->execute()->current();

                    if (!empty($stock))
                    {
                        if ((int) $stock['stock'] == 0)
                        {
                            unset($products[$key]);
                            $stock_tips[$key] = 'Sorry,' . Product::instance($product['id'])->get('sku') . ' (size ' . $product['attributes']['Size'] . ') was romoved from your cart because it has been sold out.';
                            continue;
                        }
                        elseif ($product['quantity'] > $stock['stock'])
                        {
                            $products[$key]['quantity'] = $stock['stock'];
                            $stock_tips[$key] = 'Sorry,but ' . Product::instance($product['id'])->get('sku') . ' (Size ' . $product['attributes']['Size'] . ') has only got ' . $stock['stock'] . ' left.';
                        }
                    }
                }

                if ($product['is_killer'])
                {
                    continue;
                }
                $vip_promotion = 10000;
                if((int) $vip_level >= 1)
                {
                    // vip spromotions memcache get --- sjm 2015-12-15
                    $spromotion_key = 'spromotion_' . $product['id'];
                    $spromotion_data = Cache::instance('memcache')->get($spromotion_key);
                    try 
                    {
                        $spromotion_data = unserialize($spromotion_data);
                    }
                    catch (Exception $e)
                    {
                    }
                    if(!empty($spromotion_data) && is_array($spromotion_data))
                    {
                        foreach($spromotion_data as $s_type => $s_data)
                        {
                            if($s_type == 0 && $s_data['created'] < time() && $s_data['expired'] > time())
                            {
                                $vip_promotion = $s_data['price'];
                                break;
                            }
                        }
                    }
                    if(!$vip_promotion)
                        $vip_promotion = 10000;
                }
                
                //判断是否为赠品
                $giftarr = Site::giftsku();
                if(in_array($product['id'], $giftarr)){
                    $p_price = 0;
                }else{
                    $p_price = Product::instance($product['id'])->price();

                }

                if($vip_promotion < $p_price)
                {
                    $products[$key]['price'] = $vip_promotion;
                }
                else
                {
					$vip_price = Product::instance($product['id'])->get('price') * $vip['discount'];
					if ($vip_price < $p_price)
                    {
						$products[$key]['price'] = $vip_price;
                    }
					else
                    {
						$products[$key]['price'] = $p_price;
                    }
                }
            }

            Session::instance()->set('cart_products', $products);
        }
        $cart = array(
            'products' => Session::instance()->get('cart_products', array()),
            'shipping' => self::shipping(),
            'shipping_address' => self::shipping_address(),
            'billing' => self::billing(),
            'billing_address' => self::billing_address(),
            'amount' => self::amount(),
            'quantity' => self::count(),
            'weight' => self::weight(),
            'coupon' => self::coupon(),
            'drop_shipping' => self::drop_shipping(),
            //promotion
            'largess_add' => self::largess_add(),
            'largess_delete' => self::largess_delete(),
            'largesses' => self::largess(),
            'promotion_logs' => self::promotion_log(),
            'points' => self::points(),
        );
        $cart = Promotion::instance()->apply_cart($cart);
        if ($cart)
        {
            self::largess($cart['largesses']);
            self::promotion_log($cart['promotion_logs']);
        }
        else
        {
            $cart = array(
                'products' => Session::instance()->get('cart_products', array()),
                'shipping' => self::shipping(),
                'shipping_address' => self::shipping_address(),
                'billing' => self::billing(),
                'billing_address' => self::billing_address(),
                'amount' => self::amount(),
                'quantity' => self::count(),
                'weight' => self::weight(),
                'coupon' => self::coupon(),
                'points' => self::points(),
            );
        }

        $coupon = Coupon::instance($cart['coupon']);
        $cart['coupon_item'] = 0;
        if ($coupon->get('id') && $coupon->get('type') == 3 && $coupon->check())
        {
            $product = DB::select('id')->from('products_product')
                ->where('sku', '=', $coupon->get('item_sku'))
                ->execute()
                ->current();
            $cart['coupon_item'] = $product['id'];
        }
        $cart['extra_flg'] = $extra_flg;
        $cart['extra_fee'] = $extra_fee;
        $cart['stock_tips'] = $stock_tips;

        return $cart;
    }

    /**
     * Clear cart all
     */
    public static function clear()
    {
        Session::instance()->delete('cart_products');
        Session::instance()->delete('cart_coupon');
        Session::instance()->delete('cart_largesses');
        Session::instance()->delete('cart_largess_add');
        Session::instance()->delete('cart_promotion_logs');
        Session::instance()->delete('cart_drop_shipping');
        Session::instance()->delete('cart_shipping');
        Session::instance()->delete('cart_shipping_address');
        Session::instance()->delete('cart_billing');
        Session::instance()->delete('cart_billing_address');
        Session::instance()->delete('cart_points');
        //clear cart cookie
//                $cartid = $_COOKIE['cartid'];
//                DB::update('cartcookies')->set(array('value' => ''))->where('id', '=', $cartid)->execute();
    }

    /**
     * Set or get cart coupon
     * @param string $coupon_code
     * @return string
     */
    public static function coupon($coupon_code = NULL)
    {
        if ($coupon_code)
        {
            Session::instance()->set('cart_coupon', $coupon_code);
        }
        else
        {
            return Session::instance()->get('cart_coupon');
        }
    }

    /**
     * Set cart shipping and billing
     * @param array $post
     * @return type
     */
    public static function shipping_billing($post)
    {
        // set shipping
        $cart = self::get();
//        $carrier_param = array(
//            'weight' => self::weight(),
//            'shipping_address' => array('country' => $post['shipping_country']),
//            'amount' => $cart['amount']
//        );
//        $shipping = Carrier::instance($post['shipping_method'])->get($carrier_param);
        $price = Session::instance()->get('shipping_price', -1);
        if ($price != -1)
        {
            $shipping['price'] = $price;
        }

        // set shipping address
        if ($post['shipping_address_id'] === 'new')
        {
            $shipping_address = array(
                'shipping_address_id' => $post['shipping_address_id'],
                'shipping_firstname' => $post['shipping_firstname'],
                'shipping_lastname' => $post['shipping_lastname'],
                'shipping_address' => $post['shipping_address'],
                'shipping_city' => $post['shipping_city'],
                'shipping_state' => $post['shipping_state'],
                'shipping_country' => $post['shipping_country'],
                'shipping_zip' => $post['shipping_zip'],
                'shipping_phone' => $post['shipping_phone'],
                'shipping_cpf' => isset($post['shipping_cpf']) ? $post['shipping_cpf'] : '',
            );
        }
        else
        {
            $address = Address::instance($post['shipping_address_id'])->get();
            $shipping_address = array(
                'shipping_address_id' => $post['shipping_address_id'],
                'shipping_firstname' => $address['firstname'],
                'shipping_lastname' => $address['lastname'],
                'shipping_address' => $address['address'],
                'shipping_city' => $address['city'],
                'shipping_state' => $address['state'],
                'shipping_country' => $address['country'],
                'shipping_zip' => $address['zip'],
                'shipping_phone' => $address['phone'],
                'shipping_cpf' => isset($address['shipping_cpf']) ? $address['cpf'] : '',
            );
        }
        
        self::shipping($shipping);
        self::shipping_address($shipping_address);

        // set billing & billing address
        if (isset($post['payment_method']))
        {
            if ($post['payment_method'] == 'CC' OR $post['payment_method'] == 'GLOBEBILL')
            {
                $billing = array(
                    'payment_method' => $post['payment_method'],
                    'cc_type' => $post['cc_type'],
                    'cc_num' => $post['cc_num'],
                    'cc_cvv' => $post['cc_cvv'],
                    'cc_exp_month' => $post['cc_exp_month'],
                    'cc_exp_year' => $post['cc_exp_year'],
                    'cc_issue' => $post['cc_issue'],
                    'cc_valid_month' => $post['cc_valid_month'],
                    'cc_valid_year' => $post['cc_valid_year'],
                );
                $billing_address = array(
                    'billing_firstname' => $post['billing_firstname'],
                    'billing_lastname' => $post['billing_lastname'],
                    'billing_address' => $post['billing_address'],
                    'billing_city' => $post['billing_city'],
                    'billing_state' => $post['billing_state'],
                    'billing_country' => $post['billing_country'],
                    'billing_zip' => $post['billing_zip'],
                    'billing_phone' => $post['billing_phone'],
                );
            }
            else
            {
                $billing = array('payment_method' => $post['payment_method']);
                $billing_address = '';
            }
            self::billing($billing);
            self::billing_address($billing_address);
        }
    }

    /**
     * Set or get cart shipping
     * @param array $shipping
     * @return array
     */
    public static function shipping($shipping = NULL)
    {
        if ($shipping)
        {
            Session::instance()->set('cart_shipping', $shipping);
        }
        else
        {
            return Session::instance()->get('cart_shipping');
        }
    }

    /**
     * Set or get cart shipping address
     * @param array $shipping_address
     * @return array
     */
    public static function shipping_address($shipping_address = NULL)
    {
        if ($shipping_address)
        {
            Session::instance()->set('cart_shipping_address', $shipping_address);
        }
        else
        {
            return Session::instance()->get('cart_shipping_address');
        }
    }

    /**
     * Set or get cart billing
     * @param array $billing
     * @return array
     */
    public static function billing($billing = NULL)
    {
        if ($billing)
        {
            Session::instance()->set('cart_billing', $billing);
        }
        else
        {
            return Session::instance()->get('cart_billing');
        }
    }

    /**
     * Set or get billing address
     * @param array $billing_address
     * @return array
     */
    public static function billing_address($billing_address = NULL)
    {
        if ($billing_address)
        {
            Session::instance()->set('cart_billing_address', $billing_address);
        }
        else
        {
            return Session::instance()->get('cart_billing_address');
        }
    }

    public static function points($points = NULL)
    {
        if ($points)
        {
            Session::instance()->set('cart_points', $points);
        }
        else
        {
            return Session::instance()->get('cart_points', 0);
        }
    }

    //for the different process of third party pay and others
    public static function tpp_view()
    {
        $cart = Cart::get();
        $countries = Site::instance()->countries();
        $carriers = Site::instance()->carriers();
        // set default carrier
        $carrier_param = array();
        foreach ($carriers as $key => $carrier)
        {
            $carrier_param = array(
                'weight' => $cart['weight'],
                'shipping_address' => $cart['shipping_address'] ? array('country' => $cart['shipping_address']['shipping_country']) : array('country' => $countries[0]['isocode']),
                'amount' => $cart['amount']
            );
            $carrier_price = Carrier::instance($carrier['id'])->get_price($carrier_param);
            if ($carrier_price !== FALSE)
            {
                $carriers[$key]['price'] = $carrier_price;
            }
            else
            {
                unset($carriers[$key]);
            }
        }
        reset($carriers);
        $default = current($carriers);
        $default_carrier = $cart['shipping']['carrier']['id'] ? $cart['shipping']['carrier']['id'] : $default['id'];
        $shipping = Carrier::instance($default_carrier)->get($carrier_param);
        Cart::shipping($shipping);
        $data['carriers'] = $carriers;
        $data['default_carrier'] = $default_carrier;
        $data['cart'] = Cart::get();
        return $data;
    }

    //cartcookie
    public static function cookie_get(){
        $cookie_products = array();
        if($customer_id = Customer::logged_in()){
            $cookieproducts = DB::select()->from('carts_cartitem')->where('customer_id','=',$customer_id)->where('is_cart','=',0)->order_by('created','DESC')->execute();
            $arr = array();
            foreach ($cookieproducts as $value) {
                $product_id = Item::instance($value['item_id'])->get('product_id');
                if (!Product::instance($product_id)->get('visibility') OR !Product::instance($product_id)->get('status') OR Product::instance($product_id)->get('stock')==0){ 
                }else{
                    $key = self::getkey($value['item_id'].'_'.$value['key'].'_'.$value['item_id']);
                    $arr = self::getdata($value['item_id'].'_'.$value['key'].'_'.$value['item_id']);
                    $cookie_products[$key] = $arr;
                    $cookie_products[$key]['c_id'] = $product_id;                
                }    
            }
        }else{
            $cookie_id = Kohana_Cookie::get('Customer_login_id');

            if ($cookie_id) {
                $cookieproducts = DB::select()->from('carts_cartitem')->where('customer_id','=',$cookie_id)->where('is_cart','=',0)->order_by('created','DESC')->execute();
                $arr = array();
                foreach ($cookieproducts as $value) {
                    $product_id = Item::instance($value['item_id'])->get('product_id');
                    if (!Product::instance($product_id)->get('visibility') OR !Product::instance($product_id)->get('status') OR Product::instance($product_id)->get('stock')==0){ 

                    }else{
                        $key = self::getkey($product_id.'_'.$value['key'].'_'.$value['item_id']);
                        $arr = self::getdata($product_id.'_'.$value['key'].'_'.$value['item_id']);
                       $cookie_products[$key] = $arr;
                        $cookie_products[$key]['c_id'] = $product_id;                
                    }   
                }
            }
        }

        return $cookie_products;
    }

    //cartcookie
    public static function cookie2cart($key){
        $key = str_replace('0000', '.', $key);
        $customer_id = Customer::logged_in();
        if(!$customer_id){
            $customer_id = Kohana_Cookie::get('Customer_login_id');
        }
        $arr = explode("_",$key);

        $newkey = $key;//new carts_cartitem table
        $key = self::getkey($key);

        if($customer_id){
            $data = self::getdata($arr[0].'_'.$arr[1]);
            $cart_products = Session::instance()->get('cart_products');
            if (isset($cart_products[$key])){
                $cart_products[$key]['quantity'] += $data['quantity'];
            }else{
                $cart_products[$key] = $data;
            }
            if ($data['price']){
                $cart_products[$key]['price'] = round($data['price'], 2);
                //秒杀
                $cart_products[$key]['is_killer'] = 1;
            }else{
                $cart_products[$key]['price'] = round(self::product_price($cart_products[$key]), 2);
                $cart_products[$key]['is_killer'] = 0;
            }
            if ($data['type'] == 0){
                $cart_products[$key]['price'] += round($data['attributes']['delivery time'], 2);
            }
            Session::instance()->set('cart_products', $cart_products);
            self::saveforcart($newkey);
        }else{
            return false;
        }
    }

    public static function getkey($key)
    {
        $arr = explode("_",$key);
        $data['id'] = Item::instance($arr[0])->get('product_id');
        $data['items'][] = isset($arr[0]) ? $arr[0] : Item::instance($arr[0])->get('product_id');
        $data['type'] = Product::instance($data['id'])->get('type');
        $data['attributes']['Size'] = $arr[1];

        sort($data['items']);
        $key = $data['id'] . '_' . $data['type'] . '_' . md5(serialize($data['items'])) . (isset($data['attributes']) ? '_' . md5(serialize($data['attributes'])) : '');



        return $key;
    }

    public static function getdata($key)
    {
        $arr = explode("_",$key);
        $brr = array();
        $brr['id'] = Item::instance($arr[0])->get('product_id');
        $brr['items'][] = isset($arr[2]) ? $arr[2] : $arr[0];
        $brr['quantity'] = 1;
        $brr['type'] = Product::instance($brr['id'])->get('type');
        $brr['configs'] = '';
        $brr['price'] = 0;
        $brr['attributes']['Size'] = $arr[1];
        $brr['is_killer'] = 0;

        return $brr;
    }

    public static function saveforlater($newkey)
    {
        $p = explode("_",$newkey);
        $customer_id = Customer::logged_in();
        if(!$customer_id){
            $customer_id = Kohana_Cookie::get('Customer_login_id');
        }
         $cookieproducts = DB::select()->from('carts_cartitem')->where('customer_id','=',$customer_id)
        ->and_where('item_id','=',$p[0])
        ->and_where('key','=',$p[1])
        ->execute()->current();
        if($cookieproducts){
            DB::update('carts_cartitem')->set(array('is_cart'=>0))
            ->where('id', '=', $cookieproducts['id'])->execute();
        }
    }

    public static function saveforcart($newkey)
    {
        $p = explode("_",$newkey);

        $customer_id = Customer::logged_in();
        if(!$customer_id){
            $customer_id = Kohana_Cookie::get('Customer_login_id');
        }
         $cookieproducts = DB::select()->from('carts_cartitem')->where('customer_id','=',$customer_id)
        ->and_where('item_id','=',$p[0])
        ->and_where('key','=',$p[1])
        ->execute()->current();
        if($cookieproducts){
            DB::update('carts_cartitem')->set(array('is_cart'=>1))
            ->where('id', '=', $cookieproducts['id'])->execute();
        }
    }


    //cartcookie
    public static function cookie2later($key)
    {
        $key = str_replace('0000', '.', $key);
        $customer_id = Customer::logged_in();
        if(!$customer_id){
            $customer_id = Kohana_Cookie::get('Customer_login_id');
        }
        $newkey = $key;//new carts_cartitem table
        $key = self::getkey($key);
        $cart_products = Session::instance()->get('cart_products');
        if (isset($cart_products[$key])){
            unset($cart_products[$key]);
            if($customer_id){
                self::saveforlater($newkey);
            }
            Session::instance()->set('cart_products', $cart_products);

            return TRUE;
        }else{
            return FALSE;
        }
    }

    //cartcookie
    public static function invalid($customer_id){
        $cookie_products = DB::select('item_id','id')->from('carts_cartitem')
            ->where('customer_id', '=', $customer_id)->where('is_cart', '=', 0)->execute();
        if(count($cookie_products)>0){
            foreach ($cookie_products as $cookie_product) {
                $product = Product::instance($cookie_product['item_id']);
                if (!$product->get('visibility') OR !$product->get('status') OR $product->get('stock')==0 ){
                    DB::delete('carts_cartitem')->where('id', '=', $cookie_product['id'])->execute();
                }
            }
        }
    }

    //cartcookie
    public static function get_dbcookie(){
        $data = DB::query(Database::SELECT, 'SELECT c.email,ck.key,ck.created,ck.customer_id 
            FROM `cartcookies` ck LEFT JOIN `customers` c ON ck.customer_id=c.id 
            WHERE ck.mail_date IS NULL OR ck.mail_date<(UNIX_TIMESTAMP(NOW())-3600*24*6)
            ORDER BY ck.`customer_id`,ck.created DESC')->execute('slave');
        if(count($data)>0){
            $tmp = array();
            foreach ($data as $value) {
                $key = explode("_",$value['key']);
                $product_id = trim($key['0']);
                if($product_id&&$value['email']){
                    if(is_array($tmp[$value['customer_id']]['products'])){
                        if (in_array($product_id, $tmp[$value['customer_id']]['products']) OR count($tmp[$value['customer_id']]['products'])>2 ) {
                            continue;
                        }
                    }
                    $tmp[$value['customer_id']]['email'] = $value['email'];
                    $tmp[$value['customer_id']]['products'][] = $product_id;
                }else{
                    continue;
                }
            }
            return count($tmp)>0 ? $tmp : false;
        }else{
            return false;
        }
    }

    //cartcookie coupon code
    public static function get_coupon($expired_day=3){
        $ip = ip2long(self::GetIP());
        $max_id = DB::select(DB::expr('MAX(id) AS max_id'))->from('carts_coupons')->execute()->get('max_id');
        $max_id ++;
        $coupon_code = 'CCOFF' . $max_id;
        $coupon = array(
            // 'site_id' => 1,
            'code' => $coupon_code,
            'value' => 10,
            'type' => 1,
            'limit' => 1,
            'used' => 0,
            'created' => time(),
            'expired' => time() + $expired_day * 86400,
            'on_show' => 0,
            'deleted' => 0,
            'effective_limit' => 0
            // 'ip' => $ip
        );
        $insert = DB::insert('carts_coupons', array_keys($coupon))->values($coupon)->execute();
        if ($insert)
            return $coupon_code;
        else
            return '';
    }

    public static function GetIP()
    {
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
            $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = "unknown";
        return($ip);
    }
    
}
