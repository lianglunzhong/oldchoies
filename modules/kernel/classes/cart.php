<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Cart
 * @category    Liabrary
 * @author     Vincent
 * @copyright  (c) 2009-2012 Cofree
 */
class Cart
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
        self::set($key, $product);
    }

    public static function add2cart_view($data)
    {
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
        self::set($key, $product);
        return $key;
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
     * @param bool $offset  TRUE: ADD   FALSE: RESET
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
        $cart_products = Session::instance()->get('cart_products');

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
        // $amount_save = 0;

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

        $checkout_save = 0;
        $amount = array(
            'items' => $amount_products,
            'shipping' => $amount_shipping,
            'save' => 0,
            // 'save' => $amount_save,
            'coupon_save' => $amount_save,
            'checkoutsave' => $checkout_save,
            'drop_shipping' => $amount_drop_shipping,
            'point' => $amount_points,
            'total' => round($amount_total, 2),
            'insurance' =>0.99
        );
        // var_dump($amount);die;
        return $amount;
    }

    /**
     * wholesale cart amount
     * @param array $cart    cart session.
     * @return array $cart   discount cart over 200$
     */
    public static function checkoutsave($cart)
    {
        $amount_total = $cart['amount']['total'];
        $pricer = kohana::config('sites.checkoutsave'); 
        if(200 <= $amount_total and $amount_total < 500)
        {
            $priceran = $pricer[0];
        }
        elseif(500 <= $amount_total and $amount_total < 1000)
        {
            $priceran = $pricer[1];
        }
        elseif($amount_total >= 1000 and $amount_total < 2000)
        {
            $priceran = $pricer[2];
        }
        elseif($amount_total >= 2000)
        {
            $priceran = $pricer[3];
        }
        else
        {
            $priceran = 0;
        }

        $cart_saves = round($cart['amount']['total'] * $priceran,2);
        $cart_totals = $amount_total - $cart_saves;
        $cart['amount']['checkoutsave'] += $cart_saves;
        $cart['amount']['total'] = $cart_totals;
        return $cart;
    }

    public static function product_price($product)
    {
        if (!$product)
        {
            return FALSE;
        }
        switch ($product['type'])
        {
//                        case 0://箄1�7单产哄1�7
            case 1://配置产品
                $price = Product::instance($product['items'][0])->price($product['quantity']);
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
     * @param <array> $products     Order Products, Null: Cart products
     * @return <int>    $product_amount
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

    /**
     * Get cart all
     * @return array
     */
    public static function get($order = NULL)
    {
        $products = Session::instance()->get('cart_products', array());
        $stock_tips = array();
        $extra_flg = TRUE;//判断是否收取低价产品增值税
        $extra_fee = 0;//记录购物车产品中增值税最高值
        if (!empty($products))
        {
            //vip
            $customer_id = Customer::instance()->logged_in();
            $is_vip = Customer::instance($customer_id)->get('is_vip');
            if($is_vip){
                $vipconfig = Site::instance()->vipconfig();
                $vip = $vipconfig[4]; 
            }else{
                $vipconfig = Site::instance()->vipconfig();
                $vip = $vipconfig[0]; 
            }
            
            foreach ($products as $key => $product)
            {
                if (!Product::instance($product['id'])->get('visibility') OR !Product::instance($product['id'])->get('status'))
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
                            $stock_tips[$key] = 'Sorry,but ' . Product::instance($product['id'])->get('sku') . ' (Size ' . $product['attributes']['Size'] . ') has only got ' . $stock['stocks'] . ' left.';
                        }
                    }
                }

                if ($product['is_killer'])
                {
                    continue;
                }
                $vip_promotion = 10000;
                if((int) $is_vip >= 1)
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
                        $products[$key]['price'] = $vip_price;
                    else
                        $products[$key]['price'] = $p_price;
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

        //Get coupon save
        $coupon_code = $cart['coupon'];
        $amount_products = $cart['amount']['items'] - $cart['amount']['save'];
        // $amount_save = Coupon::instance($coupon_code)->check() ? Coupon::instance($coupon_code)->save($amount_products) : 0;
        // $cart['amount']['coupon_save'] = $amount_save;
        // $cart['amount']['total'] -= $amount_save;

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

        $request_uri = Request::Instance()->uri;
        $allow_uri = array(
                'cart/checkout',
                'es/cart/checkout',
                'cart/ajax_shipping_price',
                'es/cart/ajax_shipping_price',
                'address/ajax_edit1',
                'es/address/ajax_edit1',
                'cart/ajax_coupon',
                'es/cart/ajax_coupon',
                'cart/ajax_point',
                'es/cart/ajax_point',
                'cart/ajax_shipping',
                'es/cart/ajax_shipping',
            );

        //if($cart['amount']['total'] >= 200 && in_array($request_uri, $allow_uri))
        if(0)
        {
            $cart = self::checkoutsave($cart);
        }

        $cart['extra_flg'] = $extra_flg;
        $cart['extra_fee'] = $extra_fee;
        $extra = array('extra_flg' => $extra_flg, 'extra_fee' => $extra_fee);
        Session::instance()->set('cart_extra', $extra);

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
        Session::instance()->delete('cart_message');
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
        
        if(!empty($shipping))
        {
            self::shipping($shipping);
        }
        if(!empty($shipping_address))
        {
            self::shipping_address($shipping_address);
        }

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

    //checkout page add message
    public static function message($message = NULL)
    {
        if ($message)
        {
            Session::instance()->set('cart_message', $message);
        }
        else
        {
            return Session::instance()->get('cart_message');
        }
    }

}
