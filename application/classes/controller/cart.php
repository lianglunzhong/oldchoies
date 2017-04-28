<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Cart extends Controller_Webpage
{

    public function action_view()
    {
        Site::instance()->add_clicks('cart_view');
        //?product,?lookbook add clicks
//        if(isset($_GET['product']))
//        {
//            DB::query(Database::UPDATE, 'UPDATE site_clicks SET cart_view = cart_view + 1 WHERE day = 0 AND log = "cart_product"')->execute();
//        }
//        elseif(isset($_GET['lookbook']))
//        {
//            DB::query(Database::UPDATE, 'UPDATE site_clicks SET cart_view = cart_view + 1 WHERE day = 0 AND log = "cart_lookbook"')->execute();
//        }

        //init cart points
        Session::instance()->delete('cart_points');
        Session::instance()->delete('cart_coupon');
        $site_shipping = kohana::config('sites.shipping_price');
        if ($_POST)
        {
            $shipping_price = Arr::get($_POST, 'shipping_price', 0);
            if ($shipping_price <= 0)
                $shipping_price = 0;
            else
                $shipping_price = $site_shipping[1]['price'];
            Session::instance()->set('shipping_price', $shipping_price);
            $this->request->redirect(LANGPATH . '/cart/shipping_billing');
        }
        Session::instance()->delete('cart_shipping');
        // $cart = Cart::get();
        $cart = Cartcookie::get();//cartcookie
        $cart_shipping = $cart['amount']['shipping'] ? $cart['amount']['shipping'] : Session::instance()->get('shipping_price', -1);

        $gi = geoip_open(APPPATH . "classes/GeoIP.dat", GEOIP_STANDARD);
        // 获取国家代码 
        $country_code = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);
        $noex_country = kohana::config('shipment.noex-country');
        if (in_array($country_code, $noex_country))
            $only_hkpf = 1;
        else
            $only_hkpf = 0;
        if ($country_code == 'US')
        {
            $index = 0;
            $country = 'US';
        }
        elseif ($country_code == 'GB' OR $country_code == 'UK')
        {
            $index = 1;
            $country = 'UK';
        }
        else
        {
            $index = 2;
            $country = '';
        }
        $p_attributes = array();
        $p_stocks = array();

        //guo add
        $giftarr = Site::giftsku();


        foreach($cart['products'] as $ck=>$p)
        {
            $set = Product::instance($p['id'])->get('set_id');
            if (Product::instance($p['id'])->get('stock') == -1)
            {
                $attributes= DB::select()->from('products_productitem')->where('product_id', '=', $p['id'])->where('status','=',1)->where('stock','>',0)->execute()->as_array();
                if (isset($attributes[0]['attribute']) )
                {
                    $one_size = 0;
                    $attr_sizes = $attributes[0]['attribute'];
                    $is = 0;
                        //判断attributes
                        if(strpos($attr_sizes, 'US') !== FALSE)
                        {
                            $is = 1;
                        }
                    if (count($attr_sizes) == 1 && isset($attr_sizes) && $attr_sizes == 'one size')
                        $one_size = 1;
                }

                $attrs = array();
                $stocks = array();
                foreach ($attributes as $a)
                {
                    $size = trim($a['attribute']);
                    if($set == 2)
                    {
                        $att = explode('/', $size);
                        if(isset($att[$index]))
                        {
                            $value = $country . preg_replace('/[A-Z]+/i', '', $att[$index]);        
                        }
                        else
                        {
                            $value = $att[0];  
                        }   
                    }
                    else
                    {
                        $value = $size;
                    }
                    if ($a['stock'] > 0)
                    {
                        $attrs[] = $value;
                        $stocks[] = $a['stock'];
                    }
                }
                $p_stocks[$p['id']] = $stocks;
                $p_attributes[$p['id']] = $attrs;
            }
            else
            {
                $attributes= DB::select()->from('products_productitem')->where('product_id', '=', $p['id'])->execute()->as_array();
                if (isset($attributes[0]['attribute']) )
                {
                    $one_size = 0;
                    $attr_sizes = $attributes[0]['attribute'];
                    $is = 0;
                        //判断attributes
                        if(strpos($attr_sizes, 'US') !== FALSE)
                        {
                            $is = 1;
                        }
                    if (count($attr_sizes) == 1 && isset($attr_sizes) && $attr_sizes == 'one size')
                        $one_size = 1;
                }

                $attSize = array();
                if (!empty($attributes)) {
                    if ($one_size) {

                        $attSize = array('one size');
                    } elseif ($is) {
                        // include the php script
                        $gi = geoip_open(APPPATH . "classes/GeoIP.dat", GEOIP_STANDARD);
                        // 获取国家代码
                        $country_code = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);
                        if ($country_code == 'US') {
                            $index = 0;
                            $country = 'US';
                        } elseif ($country_code == 'GB' OR $country_code == 'UK') {
                            $index = 1;
                            $country = 'UK';
                        } else {

                            $index = 2;
                            $country = '';
                        }

                        foreach($attributes as $value)
                        {
                            $attri = explode('/',$value['attribute']);
                            $attSize[] = $country . preg_replace('/[A-Z]+/i', '', $attri[$index]);
                            $stocks[$country . preg_replace('/[A-Z]+/i', '', $attri[$index])] = ($value['stock']>0)?$value['stock']:9999;
                        }

                    } 
                    else 
                    {
                        foreach ($attributes as $value)
                        {
                            $attSize[] = $value['attribute'];
                            $stocks[$value['attribute']] = ($value['stock']!=-99)?$value['stock']:9999;//
                        }
                    }
                }
                $p_attributes[$p['id']] = $attSize;
                $attSize=array();
                $customer_id = Customer::logged_in();
                //cartcookie
                if (!isset($customer_id)) {
                    $customer_id = Cookie::get('cookie_id');
                }
            }
            $customer_id = Customer::logged_in();
            if(!in_array($p['id'],$giftarr))
            {
              if($customer_id)
              {
                  $datas = array();
                  $datas['item_id'] = $p['items'][0];
                  $datas['qty'] = $p['quantity'];
                  $datas['key'] = $p['attributes']['Size'];

                  $cookieproducts = DB::select()->from('carts_cartitem')->where('customer_id','=',$customer_id)
                      ->and_where('item_id','=',$p['items'][0])
                      ->and_where('key','=',$p['attributes']['Size'])
                      ->execute()->current();
                  if($cookieproducts)
                  {
                      DB::update('carts_cartitem')->set($datas)
                      ->where('id', '=', $cookieproducts['id'])->execute();
                  }
                  else
                  {
                      DB::insert('carts_cartitem', array('customer_id','item_id','qty','key','is_cart','created',))
                      ->values(array('customer_id'=> $customer_id,
                          'item_id'=>$datas['item_id'],
                          'qty'=>$p['quantity'],
                          'key'=>$p['attributes']['Size'],
                          'is_cart' => 0,
                          'created'=>time(),))
                      ->execute();
                  }
              }
            }



        }

        //get choies cartcookie product   guo add
        $cart = Cartcookie::get();//cartcookie
        foreach($cart['products'] as $ck=>$p)
        {
            $expired = DB::select('expired')->from('carts_spromotions')->where('product_id','=',$p['id'])
                ->where('type','=',6)->execute()->get('expired');
            if($expired>time())
            {
                $cart['products'][$ck]['expired'] = $expired;
            }


            // Shoes Edit Europen Size
            $attr_value = strtoupper($p['attributes']['Size']);
            if (strpos($attr_value, 'UK') !== False) // UK
            {
                $newuksize = str_replace('.','0000', $attr_value);
                $cart['products'][$ck]['attributes']['Size_value'] = $newuksize;
            }
            else
            {
                $cart['products'][$ck]['attributes']['Size_value'] = $cart['products'][$ck]['attributes']['Size'];  
            }
        }



        //cartcookie
        $save_show = TRUE;
        $customer_id = Customer::logged_in();
        if(!$customer_id){
            $customer_id = Kohana_Cookie::get('Customer_login_id');
        }

        if(!$customer_id){
            $save_show = FALSE;
        }
        $p_cookie_attributes = array();
        $p_cookie_stocks = array();
        $cartcookie = Cartcookie::cookie_get();

        foreach($cartcookie as $k=>$p)
        {
            $set = Product::instance($p['id'])->get('set_id');
            if (Product::instance($p['id'])->get('stock') == -1)
            {
                $attributes = DB::select('attribute', 'stock')->from('products_productitem')->where('product_id', '=', $p['id'])->where('stock', '>', 0)->execute();
                $attrs = array();
                $stocks = array();
                foreach ($attributes as $a)
                {
                    $size = trim($a['attribute']);
                    if($set == 2)
                    {
                        $att = explode('/', $size);
                        $value = $country . preg_replace('/[A-Z]+/i', '', $att[$index]);
                    }
                    else
                    {
                        $value = $size;
                    }
                    if ($a['stock'] > 0)
                    {
                        $attrs[] = $value;
                        $stocks[] = $a['stock'];
                    }
                }
                $p_cookie_stocks[$p['id']] = $stocks;
            }
            else
            {
                $attributes = Product::instance($p['id'])->get('attributes');
                $attrs = array();
                if(isset($attributes['Size']))
                    $attributes = $attributes['Size'];
                elseif(isset($attributes['size']))
                    $attributes = $attributes['size'];
                else
                    $attributes = array();
                foreach ($attributes as $size)
                {
                    $size = trim($size);
                    if($set == 2)
                    {
                        $att = explode('/', $size);
                        $value = $country . preg_replace('/[A-Z]+/i', '', $att[$index]);
                    }
                    else
                    {
                        $value = $size;
                    }
                    $attrs[] = $value;
                }
            }
            $p_cookie_attributes[$p['id']] = $attrs;
            $expired = DB::select('expired')->from('carts_spromotions')->where('product_id','=',$p['id'])
                ->where('type','=',6)->execute()->get('expired');
            if($expired>time()){
                $cartcookie[$k]['expired'] = $expired;
            }


            // Shoes Edit Europen Size
            $attr_value = strtoupper($p['attributes']['Size']);
            if (strpos($attr_value, 'UK') !== False) // UK
            {
                $newuksize = str_replace('.','0000', $attr_value);
                $cartcookie[$k]['attributes']['Size_value'] = $newuksize;
            }
            else
            {
                $cartcookie[$k]['attributes']['Size_value'] = $cartcookie[$k]['attributes']['Size'];
            }

        }



    //fb 获取金额用
      $cart_save = 0;
        if ($cart['amount']['save'])
        {
            if (isset($cart['promotion_logs']['cart']))
            {
                foreach ($cart['promotion_logs']['cart'] as $p_cart)
                {
                    if ($p_cart['save'])
                    {
                        $cart_save += $p_cart['save'];
                    }
                }
            }
        }

        $amoutprice = $cart['amount']['items'] - $cart_save;
        $lang=LANGUAGE;
        $seoinfo=array(
                "de"=>array("title"=>"Einkaufstasche"),
                "es"=>array("title"=>"Bolsa de la Compra"),
                "fr"=>array("title"=>"Panier d'Achat"),
                "ru"=>array("title"=>"Корзина"),
                );
        if($lang!=""){
            $this->template->title = $seoinfo[$lang]['title'];
        }else{
            $this->template->title = "Shopping Bag";
        }

        $giftarr = Site::giftsku();


        $this->template->type = 'cart_view';
        $this->template->amoutprice = $amoutprice;
        $this->template->content = View::factory('/cart/view')
            ->set('cart', $cart)
            ->set('site_shipping', $site_shipping)
            ->set('cart_shipping', $cart_shipping)
            ->set('only_hkpf', $only_hkpf)
            ->set('p_attributes', $p_attributes)
            ->set('p_stocks', $p_stocks)
            ->set('cartcookie',$cartcookie)//cartcookie
            ->set('save_show', $save_show)//cartcookie
            ->set('p_cookie_attributes', $p_cookie_attributes)//cartcookie
            ->set('p_cookie_stocks', $p_cookie_stocks)//cartcookie;
            ->set('giftarr',$giftarr);
    }

    public function action_continue()
    {
        Site::instance()->add_clicks('continues');
        $this->request->redirect(LANGPATH . '/');
    }

    public function action_point()
    {
        if ($_POST)
        {
            if (!($customer_id = Customer::logged_in()))
            {
                $this->request->redirect(URL::base() . 'customer/login?redirect=cart/view');
            }
            $banned = DB::select('id')->from('products_category')->where('name', '=', 'Points banned')->execute()->get('id');
            $banned_products = Catalog::instance($banned)->products();
            $cart = Cart::get();
            $customer = Customer::instance($customer_id);
            $is_celebrity = $customer->is_celebrity();
            $in = array();
            foreach ($cart['products'] as $product)
            {
                if (in_array($product['id'], $banned_products))
                    $in[] = '<strong>' . Product::instance($product['id'], LANGUAGE)->get('sku') . '</strong>';
            }
            if (!$is_celebrity AND count($in) == count($cart['products']))
            {
                Message::set(__('mail_sku') . implode(',', $in) . __('cannot_pay_by_points'), 'error');
                $this->request->redirect(LANGPATH . '/cart/shipping_billing#coupon_points');
            }
            $points = (float) $_POST['points'];
            $points = $points > 0 ? $points : 0;
            $points = round($points, 2);
            $shipping_amount = Arr::get($_POST, 'shipping_amount', 0);
            Session::instance()->set('shipping_price', $shipping_amount);

            $c_points = Customer::instance($customer_id)->points();
            $product_amount = 0;
            foreach ($cart['products'] as $product)
            {
                $product_amount += $product['price'] * $product['quantity'];
            }
            // if ($is_celebrity)
            // {
            //     $points_avail = $c_points;
            // }
            // else
            // {
            //     $points_avail = floor($product_amount * 10);
            //     if ($points_avail > $c_points)
            //         $points_avail = $c_points;
            // }
            $points_avail = $c_points;
            $points_avail -= $cart['points'];
            if ($points_avail < 0)
                $points_avail = 0;
            $return_url = Arr::get($_POST, 'return_url', LANGPATH . '/cart/view');
            if ($points > $points_avail)
            {
                Message::set(__('not_enough_points'), 'error');
                $this->request->redirect($return_url);
            }
            else
            {
                Session::instance()->set('cart_points', Session::instance()->get('cart_points', 0) + $points);
                if (isset($_POST['shipping']))
                    $this->request->redirect($return_url);
                else
                    $this->request->redirect($return_url);
            }
        }
        $this->request->redirect(LANGPATH . '/cart/view');
    }

    public function action_set_coupon()
    {
        $shipping_amount = Arr::get($_POST, 'shipping', 0);
        Session::instance()->set('shipping_price', $shipping_amount);
        $cart = Cart::get();
        $url = Arr::get($_POST, 'return_url', NULL);
        $has_promotion = 0;
        if (!empty($cart['promotion_logs']['cart']))
        {
            foreach ($cart['promotion_logs']['cart'] as $promotion)
            {
                if (isset($promotion['method']) AND $promotion['method'] != 'largess')
                {
                    $has_promotion = 1;
                    break;
                }
            }
        }
        if (Session::instance()->get('no_coupon') OR $has_promotion)
        {
            Message::set(__('coupon_avoid_promotion'), 'error');
            if ($url)
            {
                $this->request->redirect($url);
            }
            else
            {
                $this->request->redirect(LANGPATH . '/cart/shipping_billing#coupon_points');
            }
        }
        $coupon_code = Arr::get($_POST, 'coupon_code', NULL);
        if ($coupon_code)
        {
            $coupon = Coupon::instance($coupon_code);
            if (!$coupon->get('id'))
            {
                $errno = 4;
                $error = __('coupon_invalid');
            }
            else
            {
                list($errno, $error) = $coupon->check_error();
            }

            if (!$errno)
            {
                // if(Coupon::instance($coupon_code)->get('target') != 'global')
                if(Coupon::instance($coupon_code)->get('target') != 1)
                {
                    $products = Session::instance()->get('cart_products', array());
                    foreach ($products as $product)
                    {
                        $discount_price = Product::instance($product['id'], LANGUAGE)->price();
                        $product_price = round(Product::instance($product['id'], LANGUAGE)->get('price'), 2);
                        if ($discount_price < $product_price)
                        {
                            Message::set(__('coupon_avoid_promotion'), 'notice');
                            continue;
                        }
                    }
                }
                Cart::coupon($coupon_code);
            }
            else
            {
                Message::set($error, 'error');
                if ($url)
                {
                    $this->request->redirect($url);
                }
                else
                {
                    $this->request->redirect(LANGPATH . '/cart/shipping_billing#coupon_points');
                }
            }
        }
        if ($url)
        {
            $this->request->redirect($url);
        }
        else
        {
            $this->request->redirect(LANGPATH . '/cart/shipping_billing#coupon_points');
        }
    }

    public function action_ajax_coupon()
    {
        $shipping_amount = Arr::get($_POST, 'shipping', 0);
        Session::instance()->set('shipping_price', $shipping_amount);
        $cart = Cart::get();

        $tgift = '';
        $tsum = count($cart['products']);
        $giftarr = Site::giftsku();
        foreach ($cart['products'] as $cart_val) {
            if(in_array($cart_val['id'], $giftarr) && $tsum == 1){
                $data['success'] = 0;
                $coupon_avoid_promotion = 'Coupon code can only be applied to items of full price.';
                $data['message'] = $coupon_avoid_promotion;
                echo json_encode($data);exit;
            }
        }

        $data = array('success' => 1);
        $coupon_code = Arr::get($_POST, 'coupon_code', NULL);
        if ($coupon_code)
        {
            $coupon = Coupon::instance($coupon_code);
            if (!$coupon->get('id'))
            {
                $data['success'] = 0;
                $data['message'] = __('coupon_invalid');
                echo json_encode($data);exit;
            }
            else
            {
                list($errno, $error) = $coupon->check_error();
            }

            if (!$errno)
            {
                // if(Coupon::instance($coupon_code)->get('target') != 'global')

                if(Coupon::instance($coupon_code)->get('target') != 1)
                {
                    $products = $cart['products'];
                    foreach ($products as $product)
                    {
                        $discount_price = Product::instance($product['id'], LANGUAGE)->price();
                        $product_price = round(Product::instance($product['id'], LANGUAGE)->get('price'), 2);
                        if ($discount_price < $product_price)
                        {
                            $data['message'] = __('coupon_avoid_promotion');
                            break;
                        }
                    }

                    if (!empty($cart['promotion_logs']['cart']))
                    {
                        foreach ($cart['promotion_logs']['cart'] as $promotion)
                        {
                            if (isset($promotion['method']) AND $promotion['method'] != 'largess')
                            {
                                $data['success'] = 0;
                                $data['message'] = __('coupon_avoid_promotion');
                                break;
                            }
                        }
                    }
                }
                if($data['success'] == 0)
                {
                    echo json_encode($data);
                    exit;
                }
                Cart::coupon($coupon_code);
                $data['success'] = 1;

                if(!isset($data['message']))
                    $data['message'] = __('coupon_set_success');

                $cart = Cart::get();
                $data['save'] = Site::instance()->price($cart['amount']['coupon_save'] + $cart['amount']['point'], 'code_view');
                $saving = $cart['amount']['items'] + $cart['amount']['shipping'] - $cart['amount']['total'];
               $isbundle = 0;
               $cart_promotion_logs = isset($cart['promotion_logs']['cart']) ? $cart['promotion_logs']['cart'] : array();
               if(!empty($cart_promotion_logs))
                {       
                    foreach ($cart_promotion_logs as $cpromo)
                    {
                        $actions = isset($cpromo['method']) ? $cpromo['method'] : '';
                        if($actions == 'bundle')
                        {
                            $isbundle = 1;
                        }
                    }
                }

                $v = '';
                foreach($cart['products'] as $p)
                {
                    $s = Product::instance($p['id'])->get('price') - $p['price'];
                    $v += $s;
                }

                $saving1 = 0;
                foreach($cart['products'] as $k=>$p)
                {
                    $s = Product::instance($p['id'])->get('price') - $p['price'];
                    $saving1 += $s * $p['quantity'];
                }

                if($isbundle)
                {
                    $saving1 = $saving1 + $cart['amount']['coupon_save'] + $cart['amount']['checkoutsave'] + $cart['amount']['point'];
                    if(!$cart['amount']['checkoutsave'])
                    {
                        $saving = $v + $cart['amount']['coupon_save'] + $cart['amount']['point'];
                    }
                }
                else
                {
                    $saving1 = $saving1 + $cart['amount']['save'] + $cart['amount']['coupon_save'] + $cart['amount']['checkoutsave'] + $cart['amount']['point'];
                    $saving += $v;
                }

                if($cart['amount']['checkoutsave'] > 0)
                {
                   $saving = $saving1;
                }

                if (!empty($cart['largesses']))
                {
                    foreach ($cart['largesses'] as $p)
                    {
                        $s = Product::instance($p['id'])->get('price') - $p['price'];
                        $saving += $s;
                    }
                }
                $data['saving'] = Site::instance()->price($saving1, 'code_view');
                if(Session::instance()->get('insurance') == -1){
                    $in = 0;
                }else{
                    $in = 0.99;
                }
                $total = $cart['amount']['shipping'] ? $cart['amount']['total'] : $cart['amount']['total'] + $shipping_amount;
                if ($total < 0)
                    $total = 0;

                $data['total'] = Site::instance()->price($total + $in , 'code_view');
                $data['wholesave'] = Site::instance()->price($cart['amount']['checkoutsave'], 'code_view');
                $data['save_total'] = Site::instance()->price($cart['amount']['coupon_save'] + $cart['amount']['point'], 'code_view');
            }
            else
            {
                $data['success'] = 0;
                $data['message'] = $error;
            }
        }
        else
        {
            $data['success'] = 0;
            $data['message'] = __('coupon_invalid');
        }
        $cart = Cart::get();
        echo json_encode($data);
        exit;
    }

    public function action_ajax_point()
    {
        if ($_POST)
        {
            $data = array();
            if (!($customer_id = Customer::logged_in()))
            {
                $data['success'] = 0;
                $data['message'] = __('need_log_in');
                echo json_encode($data);
                exit;
            }
            $banned = DB::select('id')->from('products_category')->where('name', '=', 'Points banned')->execute()->get('id');
            $banned_products = Catalog::instance($banned)->products();
            $cart = Cart::get();
            $customer = Customer::instance($customer_id);
            $is_celebrity = $customer->is_celebrity();
            $in = array();
            foreach ($cart['products'] as $product)
            {
                if (in_array($product['id'], $banned_products))
                    $in[] = Product::instance($product['id'], LANGUAGE)->get('sku');
            }
            if (!$is_celebrity AND count($in) == count($cart['products']))
            {
                $data['success'] = 0;
                $data['message'] = __('mail_sku') . implode(',', $in) . __('cannot_pay_by_points');
                echo json_encode($data);
                exit;
            }
            $points = (float) $_POST['points'];
            $points = $points > 0 ? $points : 0;
            $points = round($points, 2);
            $shipping_amount = Arr::get($_POST, 'shipping', 0);
            Session::instance()->set('shipping_price', $shipping_amount);

            $c_points = Customer::instance($customer_id)->points();
            $product_amount = 0;
            foreach ($cart['products'] as $product)
            {
                $product_amount += $product['price'] * $product['quantity'];
            }
            // if ($is_celebrity)
            // {
            //     $points_avail = $c_points;
            // }
            // else
            // {
            //     $points_avail = floor($product_amount * 10);
            //     if ($points_avail > $c_points)
            //         $points_avail = $c_points;
            // }
            $points_avail = $c_points;
            $points_avail -= $cart['points'];
            if ($points_avail < 0)
                $points_avail = 0;

            if ($points > $points_avail)
            {
                $data['success'] = 0;
                $data['message'] = __('not_enough_points');
            }
            else
            {
                Session::instance()->set('cart_points', Session::instance()->get('cart_points', 0) + $points);
                $data['success'] = 1;
                $data['message'] = __('point_set_success');
                $cart = Cart::get();
                $data['save'] = Site::instance()->price($cart['amount']['coupon_save'] + $cart['amount']['point'], 'code_view');
                $saving = $cart['amount']['items'] + $cart['amount']['shipping'] - $cart['amount']['total'];

               $isbundle = 0;
               $cart_promotion_logs = isset($cart['promotion_logs']['cart']) ? $cart['promotion_logs']['cart'] : array();
               if(!empty($cart_promotion_logs))
                {       
                    foreach ($cart_promotion_logs as $cpromo)
                    {
                        $actions = $cpromo['method'];
                        if($actions == 'bundle')
                        {
                            $isbundle = 1;
                        }
                    }
                }

                $v = '';
                foreach($cart['products'] as $p)
                {
                    $s = Product::instance($p['id'])->get('price') - $p['price'];
                    $v += $s;
                }

                $saving1 = 0;
                foreach($cart['products'] as $k=>$p)
                {
                    $s = Product::instance($p['id'])->get('price') - $p['price'];
                    $saving1 += $s * $p['quantity'];
                }

                if($isbundle)
                {
                    $saving1 = $saving1 + $cart['amount']['coupon_save'] + $cart['amount']['checkoutsave'] + $cart['amount']['point'];
                    if(!$cart['amount']['checkoutsave'])
                    {
                        $saving = $v + $cart['amount']['coupon_save'] + $cart['amount']['point'];
                    }
                }
                else
                {
                    $saving1 = $saving1 + $cart['amount']['save'] + $cart['amount']['coupon_save'] + $cart['amount']['checkoutsave'] + $cart['amount']['point'];
                    $saving += $v;
                }

                if($cart['amount']['checkoutsave'] > 0)
                {
                   $saving = $saving1;
                }

                if (!empty($cart['largesses']))
                {
                    foreach ($cart['largesses'] as $p)
                    {
                        $s = Product::instance($p['id'])->get('price') - $p['price'];
                        $saving += $s;
                    }
                }
                $data['saving'] = Site::instance()->price($saving1, 'code_view');
                $total = $cart['amount']['shipping'] ? $cart['amount']['total'] : $cart['amount']['total'] + $shipping_amount;
                if ($total < 0)
                    $total = 0;
                if(Session::instance()->get('insurance') == -1){
                    $in = 0;
                }else{
                    $in = 0.99;
                }
                $data['total'] = Site::instance()->price($total + $in, 'code_view');
                $data['wholesave'] = Site::instance()->price($cart['amount']['checkoutsave'], 'code_view');
                $data['save_total'] = Site::instance()->price($cart['amount']['coupon_save'] + $cart['amount']['point'], 'code_view');
            }
            $cart = Cart::get();

            echo json_encode($data);
            exit;
        }
    }

    public function action_ajax_shipping()
    {
        if (!$customer_id = Customer::logged_in())
        {
            Message::set(__('address_modify_do_fail'), 'error');
            $this->request->redirect(LANGPATH . '/cart/shipping_billing');
        }
        if ($_POST)
        {
            $aid = Arr::get($_POST, 'address_id');
            if($aid)
            {
                $shipping_address['shipping_address_id'] = $aid;
            }
            else
            {
                $shipping_address['shipping_address_id'] = 'new';
                $shipping_address['shipping_firstname'] = Arr::get($_POST, 'shipping_firstname', '');
                $shipping_address['shipping_lastname'] = Arr::get($_POST, 'shipping_lastname', '');
                $shipping_address['shipping_address'] = Arr::get($_POST, 'shipping_address', '');
                $shipping_address['shipping_city'] = Arr::get($_POST, 'shipping_city', '');
                $shipping_address['shipping_state'] = Arr::get($_POST, 'shipping_state', '');
                $shipping_address['shipping_country'] = Arr::get($_POST, 'shipping_country', '');
                $shipping_address['shipping_zip'] = Arr::get($_POST, 'shipping_zip', '');
                $shipping_address['shipping_phone'] = Arr::get($_POST, 'shipping_phone', '');
                $shipping_address['shipping_cpf'] = Arr::get($_POST, 'shipping_cpf', '');
            }
            $shipping_address['shipping_method'] = 39;
            Cart::shipping_billing($shipping_address);
        }
        $cart_shipping_address = Cart::shipping_address();
        $count_address = DB::select(DB::expr('COUNT(id) AS count'))->from('accounts_address')->where('customer_id', '=', $customer_id)->execute()->get('count');
        $cart_shipping_address['count_address'] = $count_address;

        $cart_shipping_address['has_no_express'] = 0;
        $site_shipping = kohana::config('sites.shipping_price');
        $cart_extra = Session::instance()->get('cart_extra');

        //是否是礼物  guo add
        $cart = Cart::get();
        $tsum = count($cart['products']);
        $tgift = 0;
        $giftarr = Site::giftsku();
        foreach ($cart['products'] as $cart_val) {
            if(in_array($cart_val['id'], $giftarr) && $tsum == 1){
                $shipping['price'] = 7;
                $tgift = 1;
            }elseif(in_array($cart_val['id'], array('6693','35050'))){
                $tgift = 2;
            }
        }

        foreach ($site_shipping as $key => $price){
            if($tgift && $key ==1){
                $site_shipping[$key]['price'] = $price['price'] + 7;
            }
        }
        foreach ($site_shipping as $key => $price)
        {
            if($price['price'] == 0)
            {
                if($cart_extra['extra_flg']&&$cart_extra['extra_fee']>0){
                    $site_shipping[$key]['price']+=$cart_extra['extra_fee'];
                }
            }
            elseif($tgift ==2)
            {
                $site_shipping[1]['price'] = 0;
            }
            elseif($cart['amount']['items'] < 15 && $cart_extra['extra_fee']<=0 && !$cart_extra['extra_flg'])
            {
                $site_shipping[1]['price'] = 4.99;
            }
        }
        $no_express_countries = kohana::config('shipment.no-express');
        if(in_array($cart_shipping_address['shipping_country'], $no_express_countries))
        {
            $shipping['price'] = $site_shipping[1]['price'];
            Cart::shipping($shipping);
            $cart_shipping_address['has_no_express'] = 1;
            $cart_shipping_address['shipping_name'] = $site_shipping[1]['name'];
            $cart_shipping_address['shipping_price'] = Site::instance()->price($site_shipping[1]['price'], 'code_view');
            $cart_shipping_address['shipping_val'] = $site_shipping[1]['price'];
            $cart = Cart::get();
            if(Session::instance()->get('insurance') == -1){
                $in = 0;
            }else{
                $in = 0.99;
            }

            $cart_shipping_address['total_price'] = Site::instance()->price($cart['amount']['total'] + $in, 'code_view');

        }

        $no_standard_countries = kohana::config('shipment.no-standard');
        if(in_array($cart_shipping_address['shipping_country'], $no_standard_countries))
        {
            $shipping['price'] = $site_shipping[2]['price'];
            Cart::shipping($shipping);
            $cart_shipping_address['has_no_express'] = 2;
            $cart_shipping_address['shipping_name'] = $site_shipping[2]['name'];
            $cart_shipping_address['shipping_price'] = Site::instance()->price($site_shipping[2]['price'], 'code_view');
            $cart_shipping_address['shipping_val'] = $site_shipping[2]['price'];
            $cart = Cart::get();
            if(Session::instance()->get('insurance') == -1){
                $in = 0;
            }else{
                $in = 0.99;
            }

            $cart_shipping_address['total_price'] = Site::instance()->price($cart['amount']['total'] + $in, 'code_view');
        }

        echo json_encode($cart_shipping_address);
        exit;
    }

    public function action_ajax_shipping_price()
    {
        if($_POST)
        {
            $data = array();
            $data['express'] = '';
            $site_shipping = kohana::config('sites.shipping_price');

            //guo add
            $gift_shipping = Session::instance()->get('gift_shipping',0);
            $tgift = '';

            $shipping_price = Arr::get($_POST, 'shipping_price', 0);
            $sprice = Arr::get($_POST, 'sprice', 0);
            $insurance_pc =  Arr::get($_POST, 'insurance_pc', 0);
            if(empty($insurance_pc)){
               $insurance_pc =  Arr::get($_POST, 'insurance', 0); 
            }

            //是否是礼物
            $cart = Cart::get();
            $tsum = count($cart['products']);
            $giftarr = Site::giftsku();
            foreach ($cart['products'] as $cart_val) {
                if(in_array($cart_val['id'], $giftarr) && $tsum == 1){
                    $shipping['price'] = 7;
                    $tgift = 1;
                }elseif(in_array($cart_val['id'], array('6693','35050'))){
                    $tgift = 2;
                }
            }

            foreach ($site_shipping as $key => $price){
                if($tgift && $key ==1){
                    $site_shipping[$key]['price'] = $price['price'] + 7;
                }elseif($tgift==2){
                    $site_shipping[1]['price']=0;                
                }else{
                    //2016 运费调整
                    if($cart['amount']['items']<15){
                         $site_shipping[1]['price']=4.99;
                    }else{
                        $site_shipping[1]['price']=0;
                    }
                }
            }



            $cart = Cart::get();
            if($insurance_pc == 1){
                $cart = Cart::get();

            if ($shipping_price <= 0)
            {
                //guo add
                $tgift = 0;
                $cart = Cart::get();
                $tsum = count($cart['products']);
                $giftarr = Site::giftsku();
                foreach ($cart['products'] as $cart_val) {
                    if(in_array($cart_val['id'], $giftarr) && $tsum == 1){
                        $shipping['price'] = 7;
                        $tgift = 1;
                    }else continue;
                }

                if($cart['extra_flg'] && $cart['extra_fee'] > 0 && $tgift !=1)
                {
                    $shipping_price = $cart['extra_fee'];
                }
                else
                {
                    //gift add
                   if($tgift == 1){
                       $shipping_price = 7; 
                   }else{
                        $shipping_price = 0; 
                   }

                }
                $shipping_name = $site_shipping[1]['name'];
            }
            elseif($shipping_price == 4.99)
            {
                //guo add
                $tgift = 0;
                $cart = Cart::get();
                $tsum = count($cart['products']);
                $giftarr = Site::giftsku();
            foreach ($cart['products'] as $cart_val) {
                if(in_array($cart_val['id'], $giftarr) && $tsum == 1){
                    $shipping['price'] = 7;
                    $tgift = 1;
                }else continue;
            }

                if($cart['extra_flg'] && $cart['extra_fee'] > 0 && $tgift !=1)
                {
                    $shipping_price = $cart['extra_fee'];
                }
                else
                {
                    //gift add
                   if($tgift == 1){
                       $shipping_price = 7; 
                   }else{
                       $shipping_price = 4.99; 
                   }

                }
                $shipping_name = $site_shipping[1]['name'];
            }
            else
            {
                // $shipping_price = $site_shipping[1]['price'];
                if($shipping_price == $site_shipping[1]['price'])
                    $shipping_name = $site_shipping[1]['name'];
                else
                    $shipping_name = $site_shipping[2]['name'];
            }

            $no_standard_countries = kohana::config('shipment.no-standard');
            if(in_array($cart['shipping_address']['shipping_country'], $no_standard_countries))
            {
                $shipping_price = $site_shipping[2]['price'];
                $shipping['price'] = $shipping_price;
                $data['express'] = 1;
            }
            else
            {
                $shipping['price'] = $shipping_price;
            }
            
            Cart::shipping($shipping);
            $cart = Cart::get();

            $v = '';
            foreach($cart['products'] as $p)
            {
                $s = Product::instance($p['id'])->get('price') - $p['price'];
                $v += $s * $p['quantity'];
            }

/*            echo $v;
            print_r($cart);
            die;*/
            $data['response'] = 1;
            $insurance =  Site::instance()->price(0.99, 'code_view');
            $data['insurance'] = $insurance;
            Session::instance()->set('insurance', 0.99);
            $cart['amount']['insurance'] = $insurance;
            if($cart['amount']['total'] + 0.99 <= 0)
            {
                $data['total'] = Site::instance()->price(0, 'code_view'); 
            }
            else
            {
                $data['total'] = Site::instance()->price($cart['amount']['total'] + 0.99, 'code_view');                
            }

            $data['wholesave'] = Site::instance()->price($cart['amount']['checkoutsave'], 'code_view');
            $data['save'] = Site::instance()->price($cart['amount']['checkoutsave'] + $cart['amount']['save'] + $v + $cart['amount']['coupon_save']+ $cart['amount']['point'], 'code_view');
            echo json_encode($data);
            exit;
            }
            if($insurance_pc == 2)
            {
                if ($shipping_price <= 0)
                {
                    
                    //guo add
                    $tgift = 0;
                    $cart = Cart::get();
                    $tsum = count($cart['products']);
                    $giftarr = Site::giftsku();
                foreach ($cart['products'] as $cart_val) {
                    if(in_array($cart_val['id'], $giftarr) && $tsum == 1){
                        $shipping['price'] = 7;
                        $tgift = 1;
                    }else continue;
                }

                    if($cart['extra_flg'] && $cart['extra_fee'] > 0 && $tgift !=1)
                    {
                        $shipping_price = $cart['extra_fee'];
                    }
                    else
                    {
                        //gift add
                       if($tgift == 1){
                            $shipping_price = 7; 
                       }else{
                            $shipping_price = $site_shipping[1]['price']; 
                       }

                    }
                    $shipping_name = $site_shipping[1]['name'];
                }
                elseif($shipping_price == 4.99)
                {
                    //guo add
                    $tgift = 0;
                    $cart = Cart::get();
                    $tsum = count($cart['products']);
                    $giftarr = Site::giftsku();
                    foreach ($cart['products'] as $cart_val) 
                    {
                        if(in_array($cart_val['id'], $giftarr) && $tsum == 1){
                            $shipping['price'] = 7;
                            $tgift = 1;
                            }else continue;
                    }

                    if($cart['extra_flg'] && $cart['extra_fee'] > 0 && $tgift !=1)
                    {
                        $shipping_price = $cart['extra_fee'];
                    }
                    else
                    {
                        //gift add
                       if($tgift == 1)
                       {
                           $shipping_price = 7; 
                       }else
                       {
                           $shipping_price = 4.99; 
                       }

                    }
                    $shipping_name = $site_shipping[1]['name'];
                }
                else
                {
                    // $shipping_price = $site_shipping[1]['price'];
                    if($shipping_price == $site_shipping[1]['price'])
                        $shipping_name = $site_shipping[1]['name'];
                    else
                        $shipping_name = $site_shipping[2]['name'];
                }

                $no_standard_countries = kohana::config('shipment.no-standard');
                if(in_array($cart['shipping_address']['shipping_country'], $no_standard_countries))
                {
                    $shipping_price = $site_shipping[2]['price'];
                    $shipping['price'] = $shipping_price;
                    $data['express'] = 1;
                }
                else
                {
                    $shipping['price'] = $shipping_price;
                }


                Cart::shipping($shipping);
                $cart = Cart::get();
                $data['response'] = 2;
                Session::instance()->set('insurance', -1);
                if($cart['amount']['total'] <= 0)
                {
                    $data['total'] = Site::instance()->price(0, 'code_view');
                }
                else
                {
                    $data['total'] = Site::instance()->price($cart['amount']['total'], 'code_view');                
                }
                
                echo json_encode($data);
                exit;
            }

            if($shipping_price <= 0){
                $shipping_price = Arr::get($_POST, 'sprice', 0);
            }

            if ($shipping_price <= 0)
            {
                
                //guo add
                $tgift = 0;
                $cart = Cart::get();
                $tsum = count($cart['products']);
                $giftarr = Site::giftsku();
            foreach ($cart['products'] as $cart_val) {
                if(in_array($cart_val['id'], $giftarr) && $tsum == 1){
                    $shipping['price'] = 7;
                    $tgift = 1;
                }else continue;
            }

                if($cart['extra_flg'] && $cart['extra_fee'] > 0 && $tgift !=1)
                {
                    $shipping_price = $cart['extra_fee'];
                }
                else
                {
                    //gift add
                   if($tgift == 1)
                   {
                       $shipping_price = 7; 
                   }
                   else
                   {
                        if($cart['amount']['items']<15)
                        {
                            $shipping_price = 4.99;
                        }
                        else
                        {
                            $shipping_price = 0;                             
                        }
                   }

                }
                $shipping_name = $site_shipping[1]['name'];
            }
            else
            {
                // $shipping_price = $site_shipping[1]['price'];
                if($shipping_price == $site_shipping[1]['price'])
                    $shipping_name = $site_shipping[1]['name'];
                else
                    $shipping_name = $site_shipping[2]['name'];
            }

            $no_standard_countries = kohana::config('shipment.no-standard');
            if(in_array($cart['shipping_address']['shipping_country'], $no_standard_countries))
            {
                $shipping_price = $site_shipping[2]['price'];
                $shipping['price'] = $shipping_price;
                $data['express'] = 1;
            }
            else
            {
                $shipping['price'] = $shipping_price;
            }

            Cart::shipping($shipping);
            $data['price'] = Site::instance()->price($shipping_price, 'code_view');
            $data['val'] = $shipping_price;
            $cart = Cart::get();
            if(Session::instance()->get('insurance') == -1){
                $in = 0;
            }else{
                $in = 0.99;
            }

             $data['session1'] = Session::instance()->get('insurance');
            $data['total'] = Site::instance()->price($cart['amount']['total'] + $in, 'code_view');
            $data['shipping_name'] = $shipping_name . ' ( ' . $data['price'] . ' )';
            echo json_encode($data);
            exit;
        }
    }

    public function action_largess_add()
    {
        if ($_POST)
            Cart::largess_add($_POST);
        $this->request->redirect(LANGPATH . '/cart/view');
    }

    public function action_largess_delete()
    {
        $id = $this->request->param('id');
        if ($id)
            Cart::largess_delete($id);
        $this->request->redirect(LANGPATH . '/cart/view');
    }

    public function action_shipping_billing()
    {
        $this->request->redirect(LANGPATH . '/cart/checkout');
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(LANGPATH . '/customer/login?redirect=' . URL::current(TRUE));
            //Request::instance()->redirect(URL::base() . LANGPATH . '/customer/login?redirect=' . URL::current(TRUE));
        }
        // if (Arr::get($_SERVER, 'COFREE_DOMAIN', URLSTR) == URLSTR AND Arr::get($_SERVER, 'HTTPS', 'off') != 'on')
        // {
        //     $redirects = isset($_GET['redirect']) ? '?redirect=' . $_GET['redirect'] : '';
        //     Request::Instance()->redirect(URL::site(Request::Instance()->uri . $redirects, 'https'));
        // }
        Site::instance()->add_clicks('checkout');
        $cart = Cart::get();
        if (count($cart['products']) == 0)
        {
            Message::set(__('cart_no_product'), 'error');
            $this->request->redirect(LANGPATH . '/cart/view');
        }

        $site_shipping = kohana::config('sites.shipping_price');
        foreach ($site_shipping as $key => $price)
        {
            if($price['price'] == 0){
                if($cart['extra_flg']&&$cart['extra_fee']>0){
                    $site_shipping[$key]['price']+=$cart['extra_fee'];
                }elseif($cart['amount']['items']<15){
                    $site_shipping[1]['price'] = 4.99;
                }
            }
        }
        $cart_shipping = Session::instance()->get('cart_shipping');
        if(!isset($cart_shipping['price']))
        {
            $shipping['price'] = $site_shipping[1]['price'];
            Cart::shipping($shipping);
        }
        
        $has_address = isset($cart['shipping_address']['shipping_firstname']) && $cart['shipping_address']['shipping_firstname'] ? 1 : 0;
        if (!$has_address)
        {
            $default_address = DB::select()
                    ->from('accounts_address')
                    // ->where('site_id', '=', $this->site_id)
                    ->where('customer_id', '=', $customer_id)
                    ->order_by('is_default', 'DESC')
                    ->execute()->current();
            if (!empty($default_address))
            {
                $address = array(
                    'shipping_address_id' => $default_address['id'],
                    'shipping_method' => 'HKPF',
                    'shipping_firstname' => $default_address['firstname'],
                    'shipping_lastname' => $default_address['lastname'],
                    'shipping_address' => $default_address['address'],
                    'shipping_city' => $default_address['city'],
                    'shipping_state' => $default_address['state'],
                    'shipping_country' => $default_address['country'],
                    'shipping_zip' => $default_address['zip'],
                    'shipping_phone' => $default_address['phone'],
                    'shipping_cpf' => $default_address['cpf'],
                );
                Cart::shipping_billing($address);
                // $shipping['price'] = 0;
                // Cart::shipping($shipping);
                echo '<script language="javascript">top.location.replace("'.BASEURL . LANGPATH . '/cart/check_out");</script>';
                exit;
            }
        }

        if ($_POST)
        {
            if (!$_POST['shipping_address'] OR !$_POST['shipping_city'] OR !$_POST['shipping_country'] OR !$_POST['shipping_zip'] OR !$_POST['shipping_phone'])
            {
                Message::set(__('address_modify_do_fail'), 'error');
                $this->request->redirect(LANGPATH . '/cart/shipping_billing');
            }
            Cart::shipping_billing($_POST);
            $this->request->redirect(LANGPATH . '/cart/confirm');
        }

        $cart = Cart::get();

        $addresses = Customer::instance($customer_id)->addresses();
        // set default address
        $default_address = array(
            'shipping_address_id' => 'new',
            'firstname' => '',
            'lastname' => '',
            'country' => '',
            'state' => '',
            'city' => '',
            'address' => '',
            'zip' => '',
            'phone' => '',
        );
        if ($cart['shipping_address'])
        {
            $default_address = array(
                'shipping_address_id' => $cart['shipping_address']['shipping_address_id'],
                'firstname' => $cart['shipping_address']['shipping_firstname'],
                'lastname' => $cart['shipping_address']['shipping_lastname'],
                'country' => $cart['shipping_address']['shipping_country'],
                'state' => $cart['shipping_address']['shipping_state'],
                'city' => $cart['shipping_address']['shipping_city'],
                'address' => $cart['shipping_address']['shipping_address'],
                'zip' => $cart['shipping_address']['shipping_zip'],
                'phone' => $cart['shipping_address']['shipping_phone'],
            );
        }
        elseif (count($addresses) > 0)
        {
            $default_address = current($addresses);
            $default_address['shipping_address_id'] = $default_address['id'];
        }

        $countries = Site::instance()->countries(LANGUAGE);

        if (!empty($default_address['country']))
        {
            $carrier_address = $default_address;
        }
        else
        {
            $carrier_address['country'] = $countries[0]['isocode'];
        }
        $carriers = Site::instance()->carriers($carrier_address['country']);
        $carrier_param = array(
            'weight' => $cart['weight'],
            'shipping_address' => $carrier_address,
            'amount' => $cart['amount']
        );
        foreach ($carriers as $key => $carrier)
        {
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
        $points = Customer::instance($customer_id)->points();
        $product_amount = 0;
        foreach ($cart['products'] as $product)
        {
            $product_amount += $product['price'] * $product['quantity'];
        }
        $is_celebrity = Customer::instance($customer_id)->is_celebrity();
        if ($is_celebrity)
        {
            $points_avail = $points;
        }
        else
        {
            $points_avail = floor($product_amount * 10);
            if ($points_avail > $points)
                $points_avail = $points;
        }

        $points_avail -= $cart['points'];
        if ($points_avail < 0)
            $points_avail = 0;
        // set default carrier
        $default_carrier = $cart['shipping']['carrier'] ? $cart['shipping']['carrier'] : current($carriers);

        $codes = array();
        $customer_codes = DB::query(Database::SELECT, 'SELECT DISTINCT o.code FROM carts_coupons o LEFT JOIN carts_customercoupons c ON o.id=c.coupon_id 
                                                WHERE c.customer_id= ' . $customer_id . ' AND o.limit <> 0 AND expired > ' . time() . ' ORDER BY o.id DESC')->execute()->as_array();
        $on_show_codes = DB::select('code')->from('carts_coupons')->where('limit', '<>', 0)->and_where('expired', '>', time())->and_where('on_show', '=', 1)->execute()->as_array();
        $codes = array_merge($customer_codes, $on_show_codes);

        $this->template->type = 'cart';
        $this->template->content = View::factory('/cart/shipping_billing')
            ->set('cart', $cart)
            ->set('countries', $countries)
            ->set('default_address', $default_address)
            ->set('addresses', $addresses)
            ->set('points_avail', $points_avail)
            ->set('default_carrier', $default_carrier)
            ->set('site_shipping', $site_shipping)
            ->set('carriers', $carriers)
            ->set('codes', $codes);
    }

    public function action_confirm()
    {
        $this->request->redirect(LANGPATH . '/cart/check_out');
        if (!($customer_id = Customer::logged_in()))
        {
            $this->request->redirect(URL::base() . 'customer/login?redirect=cart/confirm');
        }
        $customer = Customer::instance($customer_id);

        if ($_POST)
        {
            $points = (float) $_POST['points'];
            if ($points > $customer->points())
            {
                Message::set(__('not_enough_points'), 'error');
                $this->request->redirect($this->request->uri);
            }
            else
            {
                Session::instance()->set('cart_points', Session::instance()->get('cart_points', 0) + $points);
                $this->request->redirect(LANGPATH . '/payment/pay');
            }
        }

        $cart = Cart::get();
        if (empty($cart['shipping']) || empty($cart['shipping_address']))
            $this->request->redirect(LANGPATH . '/cart/shipping_billing');

        if ($cart['products'] && $customer->get('status'))
        {
            $site = Site::instance();
            $amount_point = $site->price($cart['points'] * 0.01, NULL, 'USD', $site->currency_get($site->default_currency()));
            $amount_left = $cart['amount']['total'] - $amount_point;
            if ($amount_left < 0)
                $amount_left = 0;

//                        $template = View::factory('/cart_confirm')
//                                ->set('points_avail', $customer->points() - $cart['points'])
//                                ->set('amount_left', $cart['amount']['total'])
//                                ->set('cart', $cart)->render();
//                        $this->request->response = $template;
            $this->template->content = View::factory('/cart/confirm')
                ->set('points_avail', $customer->points() - $cart['points'])
                ->set('amount_left', $cart['amount']['total'])
                ->set('cart', $cart);
        }
        else
        {
            $this->request->redirect(LANGPATH . '/cart/view');
        }
    }

    public function action_add()
    {
        $post['id'] = Arr::get($_POST, 'id', 0);
        $post['quantity'] = Arr::get($_POST, 'quantity', 1);
        #$post['items'] = Arr::get($_POST, 'items', 0);
        $post['type'] = Arr::get($_POST, 'type', 0);
        if ($post['type'] == 3)
        {
            if (empty($_POST['attributes']))
            {
                $product = Product::instance($post['id']);
                $attributes = $product->get('attributes');
                if (!empty($attributes))
                {
                    $this->request->redirect(LANGPATH . '/product/' . $product->get('link'));
                }
            }
            else
            {
                foreach ($_POST['attributes'] as $attr)
                {
                    if (!$attr)
                        $this->request->redirect(LANGPATH . '/product/' . Product::instance($post['id'])->get('link'));
                }
            }

            $post['attributes'] = Arr::get($_POST, 'attributes', array());
            if ($post['type'] == 3)
            {
                $postsize = $post['attributes']['Size'];
                if(Product::instance($post['id'])->get('set_id') == 2)
                {
                   $att =  kohana::config('sites.apishoes');
                    if(strpos($postsize, '-') !== FALSE)
                    {
                        $newsizearr = explode('-',$postsize);
                        $postsize = $newsizearr[0].'-UK'.$newsizearr[1];
                    }

                   foreach ($att as $key => $value) 
                   {
                        $newatt = explode('/',$value);
                        if(is_numeric($postsize))
                        {
                            $postsize = 'EUR'.$postsize;
                        }
                        if(in_array($postsize,$newatt))
                        {
                            $postsize = $value;
                        }
                   }
                }

                $proitem= DB::select('id','stock')->from('products_productitem')->where('product_id', '=', $post['id'])->and_where('attribute', '=', $postsize)->and_where('status', '=', 1)->execute('slave')->as_array();

                if(!isset($proitem[0]) || $proitem[0]['id'] < 1)
                {
                    kohana_log::instance()->add('PRODUCT_ERROR', $post['id']);
                    echo json_encode(0);
                    exit;  
                }
                else
                {
                    $post['items'][] = $proitem[0]['id'];
                }

                if (Product::instance($post['id'])->get('stock') == -1)
                {
                    $cart_stock = 0;
                    $products = Session::instance()->get('cart_products');
                    if (!empty($products))
                    {
                        foreach ($products as $p)
                        {
                            if ($p['id'] == $post['id'] AND $p['attributes']['Size'] == $post['attributes']['Size'])
                                $cart_stock = $p['quantity'];
                        }
                    }

                    $product_stocks = (int) $proitem[0]['stock'];

                    if ($post['quantity'] > $product_stocks - $cart_stock)
                        $post['quantity'] = $product_stocks - $cart_stock;
                }
            }else{
                echo json_encode(0);
                exit;
            }
        }
        elseif ($post['type'] == 0)
        {
            $_POST['size'] = trim($_POST['size']);
            $_POST['color'] = trim($_POST['color']);
            if (!$_POST['size'] OR !$_POST['color'])
            {
                $product = Product::instance($post['id']);
                $this->request->redirect(LANGPATH . '/product/' . $product->get('link'));
            }
            else
            {
                $stock = Product::instance($post['id'])->get('stock');
                if ($stock != -99)
                {
                    if ($post['quantity'] > $stock)
                    {
                        $post['quantity'] = $stock;
                    }
                }
                $attr = array();
                if ($_POST['size'] == 'CUSTOM SIZE' AND $_POST['custom_size'])
                {
                    $attr['size'] = $_POST['custom_size'];
                }
                else
                {
                    $attr['size'] = $_POST['size'];
                }
                $attr['color'] = $_POST['color'];
                $attr['delivery time'] = $_POST['delivery_time'];
                $post['attributes'] = $attr;
            }
        }
        if ($post['quantity'] != 0)
        {
            // Cart::add2cart($post);
            Cartcookie::add2cart($post);//cartcookie
        }
        Site::instance()->add_clicks('add_to_cart');
        if($post['id'] && $post['id']>0){
        DB::query(Database::UPDATE, 'UPDATE products_product SET add_times=add_times+1 WHERE id=' . $post['id'])->execute();
        }     
        Product::instance($post['id'])->daily_add_times();
        $this->request->redirect(LANGPATH . '/cart/view');
    }

    public function action_increase()
    {
        $cart_q = 0;
        $cart = Cart::get();
        $rproduct = $cart['products'][$this->request->param('id')];
        $stock = Product::instance($rproduct['id'])->get('stock');
        if ($stock != -99)
        {
            foreach ($cart['products'] as $product)
            {
                if ($product['id'] == $rproduct['id'])
                {
                    $cart_q += $product['quantity'];
                }
            }
            if (1 + $cart_q > $stock)
            {
                $this->request->redirect(LANGPATH . '/cart/view');
            }
        }

        Cart::quantity($this->request->param('id'), 1);
        $this->request->redirect(LANGPATH . '/cart/view');
    }

    public function action_reduce()
    {
        Cart::quantity($this->request->param('id'), -1);
        $this->request->redirect(LANGPATH . '/cart/view');
    }

    public function action_quantity()
    {
        if ($_POST)
        {
            if (isset($_POST['key']))
            {
                $quantity = Arr::get($_POST, 'num', 1);
                $quantity = (int) $quantity;
                if ($quantity < 1)
                    $quantity = 1;
                $cart_q = 0;
                $cart = Cart::get();
                $rproduct = $cart['products'][$_POST['key']];
                $stock = Product::instance($rproduct['id'])->get('stock');
                if ($stock != -99)
                {
                    foreach ($cart['products'] as $product)
                    {
                        if ($product['id'] == $rproduct['id'])
                        {
                            $cart_q += $product['quantity'];
                        }
                    }
                    if ($quantity + $cart_q > $stock)
                    {
                        $this->request->redirect(LANGPATH . '/cart/view');
                    }
                }
                Cart::quantity($_POST['key'], $quantity, FALSE);
            }
        }
        $this->request->redirect(LANGPATH . '/cart/view');
    }

    public function action_delete()
    {
        $key = $this->request->param('id');
        $key = str_replace('%20', ' ', $key);
        $arr = explode("_",$key);
        $proarr = array(50051,50050);
        if(in_array($arr[0],$proarr)){
        $customer_id = Customer::instance()->logged_in();
        $memcache_key = $customer_id.'_get0.01product';
        Cache::instance('memcache')->set($memcache_key,0,604800);//cuxiao product
        }

        // Cart::delete($this->request->param('id'));
        Cartcookie::delete($key);//cartcookie
        $referer = LANGPATH . '/cart/view';
        if(isset($_SERVER['HTTP_REFERER']) AND toolkit::is_our_url($_SERVER['HTTP_REFERER']))
        {
            $referer = $_SERVER['HTTP_REFERER'];
        }
        $this->request->redirect($referer);
    }

    public function action_drop_shipping()
    {
        $drop_shipping = Cart::drop_shipping();
        switch ($drop_shipping)
        {
            case '0':
                $drop_shipping = '1';
                break;
            case '1':
                $drop_shipping = '0';
                break;
            default:
                $drop_shipping = '1';
                break;
        }
        Cart::drop_shipping($drop_shipping);

        $this->request->redirect(LANGPATH . '/cart/view');
    }

    public function action_ajax_carrier()
    {
        $this->auto_render = FALSE;
        $iso = $_POST['iso'];
        $weight = $_POST['weight'];
        $carriers = Site::instance()->carriers($iso);
        $cart = Cart::get();

        $carrier_param = array(
            'weight' => '',
            'shipping_address' => '',
            'amount' => array()
        );
        $carrier_param['weight'] = $weight;
        $carrier_param['amount'] = $cart['amount'];

        foreach ($carriers as $key => $carrier)
        {
            $carrier_shipping_address['country'] = $iso;
            $carrier_param['shipping_address'] = $carrier_shipping_address;
            $carrier_price = Carrier::instance($carrier['id'])->get_price($carrier_param);
            if ($carrier_price !== FALSE)
            {
                $carriers[$key]['price'] = Site::instance()->price($carrier_price, 'code_view');
            }
            else
            {
                unset($carriers[$key]);
            }
        }
        echo json_encode($carriers);
    }

    public function action_ajax_change_carrier()
    {
        $id = $_POST['id'];
        $cart = Cart::get();
        $countries = Site::instance()->countries(LANGUAGE);
        $carrier_param = array(
            'weight' => $cart['weight'],
            'shipping_address' => $cart['shipping_address'] ? array('country' => $cart['shipping_address']['shipping_country']) : array('country' => $countries[0]['isocode']),
            'amount' => $cart['amount']
        );
        $shipping = Carrier::instance($id)->get($carrier_param);
        Cart::shipping($shipping);
        $cart = Cart::get();
        $data['shipping'] = Site::instance()->price($cart['amount']['shipping'], 'code_view');
        $data['total'] = Site::instance()->price($cart['amount']['total'], 'code_view');
        echo json_encode($data);
        exit;
    }

    public function action_cartproadd()
    {
        $aa = Cart::largess_add($_POST);
        $_SERVER['HTTP_REFERER'] = (isset($_SERVER['HTTP_REFERER']) AND toolkit::is_our_url($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '/';
        $this->request->redirect($_SERVER['HTTP_REFERER']);
    }

    public function action_cartprodelete()
    {
        $aa = Cart::largess_delete($this->request->param('id'));
        $_SERVER['HTTP_REFERER'] = (isset($_SERVER['HTTP_REFERER']) AND toolkit::is_our_url($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '/';
        $this->request->redirect($_SERVER['HTTP_REFERER']);
    }

    public function action_ajax_cart()
    {
        // $cart = Cart::get();
        $cart = Cartcookie::get();//cartcookie
        $data = array();
        // $data['count'] = Cart::count();
        $data['count'] = Cartcookie::count();//cartcookie
        
        $cart_view = '';
        $replacearr = array(
                'de' =>'eine Größe',
                'es' =>'talla única',
                'fr' =>'taille unique',
                'ru' =>'только один размер'
            );
        
        $customer_id = Customer::logged_in();
        if ($data['count'] > 0)
        {
            foreach (array_reverse($cart['products']) as $pkey => $product)
            {
                $product_obj = Product::instance($product['id'], LANGUAGE);
                $product_name = $product_obj->get('name');

                $cart_view .= '<li>';
                $cart_view .= '<a class="mybag-pic" href="' . $product_obj->permalink() . '" ><img src="' . image::link($product_obj->cover_image(), 3) . '" alt="" /></a>';
                $cart_view .= '<div class="mybag-info">';
                $cart_view .= '<a class="mybag-info-name" href="' . $product_obj->permalink() . '" title="' . $product_obj->get('name') . '">' . $product_name . '</a>';
                $cart_view .= ' <span>' . Site::instance()->price($product['price'], 'code_view');
                $p_price = $product_obj->get('price');
                if($p_price > $product['price'])
                {
                    $off = round(($p_price - $product['price']) / $p_price, 4) * 100;
                    $cart_view .= ' <em class="red">' . $off . '%off</em>';
                }
                $cart_view .= '</span>';
                if (isset($product['attributes']) AND !empty($product['attributes']))
                {
                    foreach ($product['attributes'] as $key => $attr)
                    {
                        if ($key == 'delivery time')
                            $attr = $attr > 0 ? 'Rush Order' . ' ( + ' . Site::instance()->price($attr, 'code_view') . ' )' : 'Regular Order';
                            if(LANGUAGE)
                            {
                                $attr = str_replace('one size', $replacearr[LANGUAGE], $attr);
                            }
                            
                        $cart_view .= '<span>' . $key . ': ' . $attr . '</span>';
                    }
                }
                $cart_view .= '<span>Quantity: ' . $product['quantity'] . '</span>';

                $delete_link = $customer_id ? LANGPATH . '/cart/cookie2later/' . $product['id'].'_'.str_replace('.','0000', $product['attributes']['Size']) : LANGPATH . '/cart/delete/' . $product['id'].'_'.str_replace('.','0000', $product['attributes']['Size']);
                $cart_view .= '</div>
                               <a href="' . $delete_link . '"><span class="cart-delete"></span></a>
                               <div class="fix"></div>
                               </li>';
            }
        }
        $data['usd_cart']=$cart['amount']['items'];
        $data['cart_view'] = $cart_view;
        if ($cart['extra_flg'])
            $data['free_shipping'] = 1;
        else
            $data['free_shipping'] = 0;
        $data['cart_amount'] = Site::instance()->price($cart['amount']['items'], 'code_view');

        //set cpromotion sale words
        $cpromotions = DB::select()
            ->from('carts_cpromotions')
            ->and_where('is_active', '=', 1)
            ->and_where('from_date', '<=', time())
            ->and_where('to_date', '>=', time())
            ->order_by('priority')
            ->execute()->as_array();
        $sale_words = array();
        $largess_words = array();
        $cart_promotion_logs = isset($cart['promotion_logs']['cart']) ? $cart['promotion_logs']['cart'] : array();
        $celebrity_avoid = 0;
        $customer_id = Customer::logged_in();
        $catalog_link = LANGPATH . '/';
        foreach ($cpromotions as $cpromo)
        {
            $actions = unserialize($cpromo['actions']);
            if ($customer_id AND Customer::instance($customer_id)->is_celebrity())
                $celebrity_avoid = $cpromo['celebrity_avoid'];
            if ($actions['action'] == 'largess')
            {
                if (empty($cart['largesses_for_choosing']) AND empty($cart['largesses']))
                {
                    if(LANGUAGE)
                        $largess_words[] = $cpromo[LANGUAGE];
                    else
                        $largess_words[] = $cpromo['name'];
                    $restrict = unserialize($cpromo['restrictions']);
                    if (isset($restrict['restrict_catalog']))
                    {
                        $catalog_link = LANGPATH . '/' . Catalog::instance($restrict['restrict_catalog'])->get('link');
                    }
                }
            }
            else
            {
                if (isset($cart_promotion_logs[$cpromo['id']]['restrictions']))
                {
                    $restrictions = unserialize($cart_promotion_logs[$cpromo['id']]['restrictions']);
                    $rate = $cart_promotion_logs[$cpromo['id']]['value'];
                }
                elseif (isset($cart_promotion_logs[$cpromo['id']]['log']))
                {
                    if(LANGUAGE)
                        $sale_words[] = $cpromo[LANGUAGE] . ': ' . Site::instance()->price($cart_promotion_logs[$cpromo['id']]['save'], 'code_view') . ' off';
                    else
                        $sale_words[] = $cart_promotion_logs[$cpromo['id']]['log'];
                }
                elseif (!array_key_exists($cpromo['id'], $cart_promotion_logs))
                {
                    $restrict = unserialize($cpromo['restrictions']);
                    if (isset($restrict['restrict_catalog']))
                    {
                        $catalog_link = LANGPATH . '/' . Catalog::instance($restrict['restrict_catalog'])->get('link');
                        if(LANGUAGE)
                            $sale_words[] = $cpromo[LANGUAGE];
                        else
                            $sale_words[] = $cpromo['name'];
                    }
                    else
                    {
                        if(LANGUAGE)
                            $sale_words[] = $cpromo[LANGUAGE];
                        else
                            $sale_words[] = $cpromo['name'];
                    }
                }
            }
        }
        if(!empty($sale_words))
            $data['sale_words'] = '<a href="' . $catalog_link . '" style="color: #232121;font-size: 15px;">' . implode(' , ', $sale_words) . '</a>';
        else
            $data['sale_words'] = '';

        echo json_encode($data);
        exit;
    }

    public function action_check_out()
    {
        $this->request->redirect(LANGPATH . '/cart/checkout');
        if (Arr::get($_SERVER, 'COFREE_DOMAIN', URLSTR) == URLSTR AND Arr::get($_SERVER, 'HTTPS', 'off') != 'on')
        {
            $redirects = isset($_GET['redirect']) ? '?redirect=' . $_GET['redirect'] : '';
            Request::Instance()->redirect(URL::site(Request::Instance()->uri . $redirects, 'https'));
        }
        $cart = Cart::get();

        $site_shipping = kohana::config('sites.shipping_price');
        foreach ($site_shipping as $key => $price)
        {
            if($price['price'] == 0){
                if($cart['extra_flg']&&$cart['extra_fee']>0){
                    $site_shipping[$key]['price']+=$cart['extra_fee'];
                }
            }
        }
        $cart_shipping = Session::instance()->get('cart_shipping');
        if(!isset($cart_shipping['price']))
        {
            $shipping['price'] = $site_shipping[1]['price'];
            Cart::shipping($shipping);
        }
        $cart = Cart::get();

        $customer_id = Customer::logged_in();
        if (!$customer_id)
        {
            Site::instance()->add_clicks('cart_login');
            $this->request->redirect(LANGPATH . '/customer/login?redirect='.LANGPATH.'/cart/check_out');
        }
        Site::instance()->add_clicks('cart_checkout');
        if (count($cart['products']) == 0)
        {
            if (!$customer_id)
                $this->request->redirect(LANGPATH . '/cart/view');
            else
                $this->request->redirect(LANGPATH . '/customer/orders');
        }
        $has_address = isset($cart['shipping_address']['shipping_firstname']) && $cart['shipping_address']['shipping_firstname'] ? 1 : 0;
        if (!$has_address)
        {
            $default_address = DB::select()
                    ->from('accounts_address')
                    // ->where('site_id', '=', $this->site_id)
                    ->where('customer_id', '=', $customer_id)
                    ->order_by('is_default', 'DESC')
                    ->execute()->current();
            if (!empty($default_address))
            {
                $address = array(
                    'shipping_address_id' => $default_address['id'],
                    'shipping_method' => 'HKPF',
                    'shipping_firstname' => $default_address['firstname'],
                    'shipping_lastname' => $default_address['lastname'],
                    'shipping_address' => $default_address['address'],
                    'shipping_city' => $default_address['city'],
                    'shipping_state' => $default_address['state'],
                    'shipping_country' => $default_address['country'],
                    'shipping_zip' => $default_address['zip'],
                    'shipping_phone' => $default_address['phone'],
                    'shipping_cpf' => $default_address['cpf'],
                );
                Cart::shipping_billing($address);
                echo '<script language="javascript">top.location.replace("'.BASEURL . LANGPATH . '/cart/check_out");</script>';
                exit;
            }
        }

        $sofort_countries = array(
            'DE' => 'EUR', 'AT' => 'EUR', 'CH' => 'CHF', 'BE' => 'EUR', 'FR' => 'EUR',
            'IT' => 'EUR', 'GB' => 'GBP', 'ES' => 'EUR', 'NL' => 'EUR', 'PL' => 'EUR',
        );

        if ($_POST)
        {
            $billing = array('payment_method' => $_POST['payment_method']);
            Cart::billing($billing);
            if ($_POST['payment_method'] == 'PP')
            {
                $order = Request::factory(LANGPATH . '/order/set')->execute()->response;
                if (!$order)
                {
                    Message::set(__('order_create_failed'), 'error');
                    $this->request->redirect(LANGPATH . '/cart/check_out');
                }
                $ordernum = $order->get('ordernum');
                $this->request->redirect(LANGPATH . '/payment/pay/'.$ordernum);
            }
            elseif ($_POST['payment_method'] == 'GC')
            {
                $shipping_address = Cart::shipping_address();
                $billing_address = array(
                    'billing_firstname' => $shipping_address['shipping_firstname'],
                    'billing_lastname' => $shipping_address['shipping_lastname'],
                    'billing_address' => $shipping_address['shipping_address'],
                    'billing_city' => $shipping_address['shipping_city'],
                    'billing_state' => $shipping_address['shipping_state'],
                    'billing_country' => $shipping_address['shipping_country'],
                    'billing_zip' => $shipping_address['shipping_zip'],
                    'billing_phone' => $shipping_address['shipping_phone']
                );
                Cart::billing_address($billing_address);
                Site::instance()->add_clicks('globebill');
                $order = Request::factory(LANGPATH . '/order/set')->execute()->response;
                if (!$order)
                {
                    Message::set(__('order_create_failed'), 'error');
                    $this->request->redirect(LANGPATH . '/cart/check_out');
                }
                $ordernum = $order->get('ordernum');
                if($order->get('amount') < 0.1)
                {
                     $this->request->redirect(LANGPATH . '/payment/success/'.$ordernum);
                }
                Session::instance()->set('current_order', $ordernum);
                $this->request->redirect(LANGPATH . '/payment/gc_pay/'.$ordernum);
            }
            elseif($_POST['payment_method'] == 'SOFORT')
            {
                $order = Request::factory(LANGPATH . '/order/set')->execute()->response;
                if (!$order)
                {
                    Message::set(__('order_create_failed'), 'error');
                    $this->request->redirect(LANGPATH . '/cart/check_out');
                }
                $ordernum = $order->get('ordernum');
                $this->request->redirect('https://' . $_SERVER['HTTP_HOST'] . LANGPATH . '/payment/sofort_pay/'.$ordernum);
            }
            elseif($_POST['payment_method'] == 'IDEAL')
            {
                $order = Request::factory(LANGPATH . '/order/set')->execute()->response;
                if (!$order)
                {
                    Message::set(__('order_create_failed'), 'error');
                    $this->request->redirect('https://' . $_SERVER['HTTP_HOST'] . LANGPATH . '/cart/check_out');
                }
                $ordernum = $order->get('ordernum');
                $this->request->redirect(LANGPATH . '/payment/ideal_pay/'.$ordernum);
            }
            elseif ($_POST['payment_method'] == 'GLOBEBILL')
            {
                if ($_POST['billing_method'] == 2)
                {
                    $billing_address = array(
                        'billing_firstname' => $_POST['billing_firstname'],
                        'billing_lastname' => $_POST['billing_lastname'],
                        'billing_address' => $_POST['billing_address'],
                        'billing_city' => $_POST['billing_city'],
                        'billing_state' => $_POST['billing_state'],
                        'billing_country' => $_POST['billing_country'],
                        'billing_zip' => $_POST['billing_zip'],
                        'billing_phone' => $_POST['billing_phone']
                    );
                    Cart::billing_address($billing_address);
                }
                Site::instance()->add_clicks('globebill');
                Site::instance()->add_clicks('proceed');
                if (Site::instance()->get('is_pay_insite'))
                {
                    $order = Request::factory(LANGPATH . '/order/set')->execute()->response;
                    if (!$order)
                    {
                        Message::set(__('order_create_failed'), 'error');
                        $this->request->redirect(LANGPATH . '/cart/check_out');
                    }
                    $ordernum = $order->get('ordernum');
                    if($order->get('amount') <= 0.1)
                    {
                         $this->request->redirect(LANGPATH . '/payment/success/'.$ordernum);
                    }
                    Session::instance()->set('current_order', $ordernum);
                    $this->request->redirect(LANGPATH . '/payment/pay_insite1/'.$ordernum);
                }
                else
                {
                    $this->request->redirect(LANGPATH . '/payment/pay/'.$ordernum);
                }
            }
        }
        else
        {
//                  $price = Session::instance()->get('shipping_price', -1);
//                  $shipping = Cart::shipping();
//                  if($price != -1)
//                  {
//                        $shipping['price'] = $price;
//                  }
//                  Cart::shipping($shipping);
//                  $cart = Cart::get();

            if ($customer_id)
            {
                $addresses = Customer::instance($customer_id)->addresses();
                // set default address
                $default_address = array(
                    'shipping_address_id' => 'new',
                    'firstname' => '',
                    'lastname' => '',
                    'country' => '',
                    'state' => '',
                    'city' => '',
                    'address' => '',
                    'zip' => '',
                    'phone' => '',
                );
                if ($cart['shipping_address'])
                {
                    $default_address = array(
                        'shipping_address_id' => $cart['shipping_address']['shipping_address_id'],
                        'firstname' => $cart['shipping_address']['shipping_firstname'],
                        'lastname' => $cart['shipping_address']['shipping_lastname'],
                        'country' => $cart['shipping_address']['shipping_country'],
                        'state' => $cart['shipping_address']['shipping_state'],
                        'city' => $cart['shipping_address']['shipping_city'],
                        'address' => $cart['shipping_address']['shipping_address'],
                        'zip' => $cart['shipping_address']['shipping_zip'],
                        'phone' => $cart['shipping_address']['shipping_phone'],
                    );
                }
                elseif (count($addresses) > 0)
                {
                    $default_address = current($addresses);
                    $default_address['shipping_address_id'] = $default_address['id'];
                }

                $countries = Site::instance()->countries(LANGUAGE);
                $countries_top = Site::instance()->countries_top(LANGUAGE);

                if (!empty($default_address['country']))
                {
                    $carrier_address = $default_address;
                }
                else
                {
                    $carrier_address['country'] = $countries[0]['isocode'];
                }
                $carriers = Site::instance()->carriers($carrier_address['country']);
                $carrier_param = array(
                    'weight' => $cart['weight'],
                    'shipping_address' => $carrier_address,
                    'amount' => $cart['amount']
                );
                foreach ($carriers as $key => $carrier)
                {
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
                $points = Customer::instance($customer_id)->points();
                $product_amount = 0;
                foreach ($cart['products'] as $product)
                {
                    $product_amount += $product['price'] * $product['quantity'];
                }
                $is_celebrity = Customer::instance($customer_id)->is_celebrity();
                if ($is_celebrity)
                {
                    $points_avail = $points;
                }
                else
                {
                    $points_avail = floor($product_amount * 10);
                    if ($points_avail > $points)
                        $points_avail = $points;
                }

                $points_avail -= $cart['points'];
                if ($points_avail < 0)
                    $points_avail = 0;

                // set default carrier
                $default_carrier = isset($cart['shipping']['carrier']) ? $cart['shipping']['carrier'] : current($carriers);

                $codes = array();
                $customer_codes = DB::query(Database::SELECT, 'SELECT DISTINCT o.code FROM carts_coupons o LEFT JOIN carts_customercoupons c ON o.id=c.coupon_id 
                                                WHERE c.customer_id= ' . $customer_id . ' AND o.limit <> 0 AND expired > ' . time() . ' ORDER BY o.id DESC')->execute()->as_array();
                $on_show_codes = DB::select('code')->from('carts_coupons')->where('limit', '<>', 0)->and_where('expired', '>', time())->and_where('on_show', '=', 1)->execute()->as_array();
                $codes = array_merge($customer_codes, $on_show_codes);
                
                $this->template->type = 'purchase';
                $this->template->content = View::factory('/cart/check_out2')
                    ->set('cart', $cart)
                    ->set('countries', $countries)
                    ->set('countries_top', $countries_top)
                    ->set('default_address', $default_address)
                    ->set('addresses', $addresses)
                    ->set('points_avail', $points_avail)
                    ->set('default_carrier', $default_carrier)
                    ->set('site_shipping', $site_shipping)
                    ->set('carriers', $carriers)
                    ->set('customer_id', $customer_id)
                    ->set('codes', $codes)
                    ->set('sofort_countries', $sofort_countries);
            }
            else
            {
                $this->template->content = View::factory('/cart/check_out1')->set('cart', $cart);
            }
        }
    }

    public function action_checkout11()
    {
        // Session::instance()->delete('cart_shipping_address');
        $customer_id = Customer::logged_in();
        if (!$customer_id)
        {
            Site::instance()->add_clicks('cart_login');
            $this->request->redirect(LANGPATH . '/customer/login?redirect='.LANGPATH.'/cart/checkout');
        }

        if ($_POST)
        {
            if(!$customer_id)
            {
                $this->request->redirect(LANGPATH . '/customer/login?redirect=/cart/checkout');
            }
            else
            {
                $cart_count = Cart::count();
                if($customer_id AND !$cart_count)
                {
                    $this->request->redirect(LANGPATH . '/customer/orders');
                }
            }
            Site::instance()->add_clicks('proceed');
            $billing = array('payment_method' => $_POST['payment_method']);
            Cart::billing($billing);
            if ($_POST['payment_method'] == 'PP')
            {
                $order = Request::factory(LANGPATH . '/order/set')->execute()->response;
                if (!$order)
                {
                    Message::set(__('order_create_failed'), 'error');
                    $this->request->redirect(LANGPATH . '/cart/view');
                }
                $ordernum = $order->get('ordernum');
                $this->request->redirect(LANGPATH . '/payment/pay/'.$ordernum);
            }
            elseif ($_POST['payment_method'] == 'GC')
            {
                $shipping_address = Cart::shipping_address();
                $billing_address = array(
                    'billing_firstname' => $shipping_address['shipping_firstname'],
                    'billing_lastname' => $shipping_address['shipping_lastname'],
                    'billing_address' => $shipping_address['shipping_address'],
                    'billing_city' => $shipping_address['shipping_city'],
                    'billing_state' => $shipping_address['shipping_state'],
                    'billing_country' => $shipping_address['shipping_country'],
                    'billing_zip' => $shipping_address['shipping_zip'],
                    'billing_phone' => $shipping_address['shipping_phone']
                );
                Cart::billing_address($billing_address);
                Site::instance()->add_clicks('globebill');
                $order = Request::factory(LANGPATH . '/order/set')->execute()->response;
                if (!$order)
                {
                    Message::set(__('order_create_failed'), 'error');
                    $this->request->redirect(LANGPATH . '/cart/view');
                }
                $ordernum = $order->get('ordernum');
                if($order->get('amount') < 0.1)
                {
                     $this->request->redirect(LANGPATH . '/payment/success/'.$ordernum);
                }
                Session::instance()->set('current_order', $ordernum);
                $this->request->redirect(LANGPATH . '/payment/gc_pay/'.$ordernum);
            }
            elseif($_POST['payment_method'] == 'SOFORT')
            {
                $order = Request::factory(LANGPATH . '/order/set')->execute()->response;
                if (!$order)
                {
                    Message::set(__('order_create_failed'), 'error');
                    $this->request->redirect(LANGPATH . '/cart/view');
                }
                $ordernum = $order->get('ordernum');
                $this->request->redirect('https://' . $_SERVER['HTTP_HOST'] . LANGPATH . '/payment/sofort_pay/'.$ordernum);
            }
            elseif($_POST['payment_method'] == 'IDEAL')
            {
                $order = Request::factory(LANGPATH . '/order/set')->execute()->response;
                if (!$order)
                {
                    Message::set(__('order_create_failed'), 'error');
                    $this->request->redirect(LANGPATH . '/cart/view');
                }
                $ordernum = $order->get('ordernum');
                $this->request->redirect(LANGPATH . '/payment/ideal_pay/'.$ordernum);
            }
            elseif ($_POST['payment_method'] == 'GLOBEBILL')
            {
                if ($_POST['billing_method'] == 2)
                {
                    $billing_address = array(
                        'billing_firstname' => $_POST['billing_firstname'],
                        'billing_lastname' => $_POST['billing_lastname'],
                        'billing_address' => $_POST['billing_address'],
                        'billing_city' => $_POST['billing_city'],
                        'billing_state' => $_POST['billing_state'],
                        'billing_country' => $_POST['billing_country'],
                        'billing_zip' => $_POST['billing_zip'],
                        'billing_phone' => $_POST['billing_phone']
                    );
                    Cart::billing_address($billing_address);
                }
                Site::instance()->add_clicks('globebill');
                Site::instance()->add_clicks('proceed');
                if (Site::instance()->get('is_pay_insite'))
                {
                    $order = Request::factory(LANGPATH . '/order/set')->execute()->response;
                    if (!$order)
                    {
                        Message::set(__('order_create_failed'), 'error');
                        $this->request->redirect(LANGPATH . '/cart/view');
                    }
                    $ordernum = $order->get('ordernum');
                    if($order->get('amount') <= 0.1)
                    {
                         $this->request->redirect(LANGPATH . '/payment/success/'.$ordernum);
                    }
                    Session::instance()->set('current_order', $ordernum);
                    $this->request->redirect(LANGPATH . '/payment/pay_insite1/'.$ordernum);
                }
                else
                {
                    $this->request->redirect(LANGPATH . '/payment/pay/'.$ordernum);
                }
            }
        }
        else
        {
            Site::instance()->add_clicks('cart_checkout');
        }
        $cart = Cart::get();
        //订单中只有一件产品，且产品单价小于15美金，运费增加4.99美金
        $site_shipping = kohana::config('sites.shipping_price');
        foreach ($site_shipping as $key => $price)
        {
            if($price['price'] == 0){
                if($cart['extra_flg']&&$cart['extra_fee']>0){
                    $site_shipping[$key]['price']+=$cart['extra_fee'];
                    $default_shipping = $site_shipping[$key]['price'];
                }
            }
        }
        $shipping_address = Cart::shipping_address();
        $has_address = isset($shipping_address['shipping_firstname']) && $shipping_address['shipping_firstname'] ? 1 : 0;
        if (!$has_address)
        {
            $default_address = DB::select()
                    ->from('accounts_address')
                    // ->where('site_id', '=', $this->site_id)
                    ->where('customer_id', '=', $customer_id)
                    ->order_by('is_default', 'DESC')
                    ->execute()->current();
            if (!empty($default_address))
            {
                $address = array(
                    'shipping_address_id' => $default_address['id'],
                    'shipping_method' => 'HKPF',
                    'shipping_firstname' => $default_address['firstname'],
                    'shipping_lastname' => $default_address['lastname'],
                    'shipping_address' => $default_address['address'],
                    'shipping_city' => $default_address['city'],
                    'shipping_state' => $default_address['state'],
                    'shipping_country' => $default_address['country'],
                    'shipping_zip' => $default_address['zip'],
                    'shipping_phone' => $default_address['phone'],
                    'shipping_cpf' => $default_address['cpf'],
                );
                Cart::shipping_billing($address);
            }
        }
        else
        {
            $default_address = array();
        }
        $no_express_countries = kohana::config('shipment.no-express');

        if($has_address && !empty($shipping_address['shipping_country']))
        {
            $shipping_country = $shipping_address['shipping_country'];
        }
        elseif(!empty($address['shipping_country']))
        {
            $shipping_country = $address['shipping_country'];
        }
        else
        {
            $shipping_country = '';
        }

        $cart_shipping = Session::instance()->get('cart_shipping');
        if(!isset($cart_shipping['price']) OR in_array($shipping_country, $no_express_countries))
        {
            $shipping['price'] = $site_shipping[1]['price'];
            Cart::shipping($shipping);
        }
        $cart = Cart::get();

        if($cart['amount']['items'] <= 0)
        {
            $current_order = Session::instance()->get('current_order');
            if($current_order)
                $this->request->redirect(LANGPATH . '/order/view/' . $current_order);
            else
                $this->request->redirect(LANGPATH . '/cart/view');
        }
        $countries = Site::instance()->countries(LANGUAGE);
        $countries_top = Site::instance()->countries_top(LANGUAGE);
        $addresses = Customer::instance($customer_id)->addresses();

        $carriers = Site::instance()->carriers($carrier_address['country']);
        $carrier_param = array(
            'weight' => $cart['weight'],
            'shipping_address' => $carrier_address,
            'amount' => $cart['amount']
        );
        foreach ($carriers as $key => $carrier)
        {
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

        $points = Customer::instance($customer_id)->points();
        $product_amount = 0;
        foreach ($cart['products'] as $product)
        {
            $product_amount += $product['price'] * $product['quantity'];
        }
        $is_celebrity = Customer::instance($customer_id)->is_celebrity();
        if ($is_celebrity)
        {
            $points_avail = $points;
        }
        else
        {
            $points_avail = floor($product_amount * 10);
            if ($points_avail > $points)
                $points_avail = $points;
        }

        $points_avail -= $cart['points'];
        if ($points_avail < 0)
            $points_avail = 0;

        // set default carrier
        $default_carrier = isset($cart['shipping']['carrier']) ? $cart['shipping']['carrier'] : current($carriers);

        $codes = array();
        $customer_codes = DB::query(Database::SELECT, 'SELECT DISTINCT o.code FROM carts_coupons o LEFT JOIN carts_customercoupons c ON o.id=c.coupon_id 
                                        WHERE c.customer_id= ' . $customer_id . ' AND o.limit <> 0 AND expired > ' . time() . ' ORDER BY o.id DESC')->execute()->as_array();
        $on_show_codes = DB::select('code')->from('carts_coupons')->where('limit', '<>', 0)->and_where('expired', '>', time())->and_where('on_show', '=', 1)->execute()->as_array();
        $codes = array_merge($customer_codes, $on_show_codes);

        $sofort_countries = array(
            'DE' => 'EUR', 'AT' => 'EUR', 'CH' => 'CHF', 'BE' => 'EUR', 'FR' => 'EUR',
            'IT' => 'EUR', 'GB' => 'GBP', 'ES' => 'EUR', 'NL' => 'EUR', 'PL' => 'EUR',
        );

        //Paypal 20 countries 'Get Return Shipping Refunded'
        $paypal_refund_config = array(
            'FR' => 'fr', 'ES' => 'es', 'IT' => 'en', 'SE' => 'en', 'CY' => 'en', 'HR' => 'en', 'FI' => 'en', 
            'GR' => 'en', 'HU' => 'en', 'MT' => 'en', 'RO' => 'en', 'SV' => 'en', 'SK' => 'en', 'BG' => 'en', 
            'CZ' => 'en', 'PL' => 'en', 'CH' => 'de', 'LV' => 'ru', 'LT' => 'ru', 'EE' => 'ru',
        );

        $cart_message = Cart::message();

 //guo  FB获取金额
        $checkprice =   $cart['amount']['total'] + $default_shipping;
        $this->template->type = 'purchase';
        $this->template->checkprice = $checkprice;
        $this->template->content = View::factory('/cart/checkout11')
            ->set('cart', $cart)
            ->set('countries', $countries)
            ->set('countries_top', $countries_top)
            ->set('default_address', $default_address)
            ->set('addresses', $addresses)
            ->set('points_avail', $points_avail)
            ->set('site_shipping', $site_shipping)
            ->set('default_carrier', $default_carrier)
            ->set('carriers', $carriers)
            ->set('customer_id', $customer_id)
            ->set('codes', $codes)
            ->set('sofort_countries', $sofort_countries)
            ->set('paypal_refund_config', $paypal_refund_config)
            ->set('cart_message', $cart_message)
            ->set('no_express_countries', $no_express_countries);
    }

    public function action_checkout()
    {
        // Session::instance()->delete('cart_shipping_address');
        $customer_id = Customer::logged_in();
        if (!$customer_id)
        {
            Site::instance()->add_clicks('cart_login');
            //$this->request->redirect(LANGPATH . '/customer/login?redirect='.LANGPATH.'/cart/view');
            $this->request->redirect(LANGPATH . '/customer/login?redirect='.LANGPATH.'/cart/checkout');
        }

        if ($_POST)
        {
            if(!$customer_id)
            {
                //$this->request->redirect(LANGPATH . '/customer/login?redirect=/cart/view');
                $this->request->redirect(LANGPATH . '/customer/login?redirect=/cart/checkout');
            }
            else
            {
                $cart_count = Cart::count();
                if($customer_id AND !$cart_count)
                {
                    $this->request->redirect(LANGPATH . '/customer/orders');
                }
            }
            Site::instance()->add_clicks('proceed');
            if(!isset($_POST['payment_method']))
            {
                $_POST['payment_method'] = 'PP'; 
            }
            $billing = array('payment_method' => $_POST['payment_method']);
            Cart::billing($billing);
            if ($_POST['payment_method'] == 'PP')
            {
                $order = Request::factory(LANGPATH . '/order/set')->execute()->response;
                if (!$order)
                {
                    Message::set(__('order_create_failed'), 'error');
                    $this->request->redirect(LANGPATH . '/cart/view');
                }
                $ordernum = $order->get('ordernum');
                $this->request->redirect(LANGPATH . '/payment/pay/'.$ordernum);
            }
            elseif ($_POST['payment_method'] == 'MASAPAY')
            {
                $order = Request::factory(LANGPATH . '/order/set')->execute()->response;
                if (!$order)
                {
                    Message::set(__('order_create_failed'), 'error');
                    $this->request->redirect(LANGPATH . '/cart/view');
                }
                $ordernum = $order->get('ordernum');
                $this->request->redirect(LANGPATH . '/payment/masapay/'.$ordernum);
            }
            elseif ($_POST['payment_method'] == 'MASAPAYINNER')
            {
                $order = Request::factory(LANGPATH . '/order/set')->execute()->response;
                if (!$order)
                {
                    Message::set(__('order_create_failed'), 'error');
                    $this->request->redirect(LANGPATH . '/cart/view');
                }
                $ordernum = $order->get('ordernum');
                $this->request->redirect(LANGPATH . '/payment/masapay_inner/'.$ordernum);
            }
            elseif ($_POST['payment_method'] == 'IPAY')
            {
                $this->request->redirect(BASEURL);
                $order = Request::factory(LANGPATH . '/order/set')->execute()->response;
                if (!$order)
                {
                    Message::set(__('order_create_failed'), 'error');
                    $this->request->redirect(LANGPATH . '/cart/view');
                }
                $ordernum = $order->get('ordernum');
                $this->request->redirect(LANGPATH . '/payment/ipay/'.$ordernum);
            }
            elseif ($_POST['payment_method'] == 'GC')
            {
                $this->request->redirect(BASEURL);
                $shipping_address = Cart::shipping_address();
                $billing_address = array(
                    'billing_firstname' => $shipping_address['shipping_firstname'],
                    'billing_lastname' => $shipping_address['shipping_lastname'],
                    'billing_address' => $shipping_address['shipping_address'],
                    'billing_city' => $shipping_address['shipping_city'],
                    'billing_state' => $shipping_address['shipping_state'],
                    'billing_country' => $shipping_address['shipping_country'],
                    'billing_zip' => $shipping_address['shipping_zip'],
                    'billing_phone' => $shipping_address['shipping_phone']
                );
                Cart::billing_address($billing_address);
                Site::instance()->add_clicks('globebill');
                $order = Request::factory(LANGPATH . '/order/set')->execute()->response;
                if (!$order)
                {
                    Message::set(__('order_create_failed'), 'error');
                    $this->request->redirect(LANGPATH . '/cart/view');
                }
                $ordernum = $order->get('ordernum');
                if($order->get('amount') < 0.01)
                {
                    $order->set(array(
                        'payment_status' => 'success',
                        'amount_payment' => 0,
                        'transaction_id' => 'point redeem',
                        'payment_date' => time(),
                        'payment_method' => 'OC',
                    ));
                     $this->request->redirect(LANGPATH . '/payment/success/'.$ordernum);
                }
                Session::instance()->set('current_order', $ordernum);

                $this->request->redirect(LANGPATH . '/payment/ocean_pay/'.$ordernum);   
            }
            elseif($_POST['payment_method'] == 'SOFORT')
            {
                $this->request->redirect(BASEURL);
                $order = Request::factory(LANGPATH . '/order/set')->execute()->response;
                if (!$order)
                {
                    Message::set(__('order_create_failed'), 'error');
                    $this->request->redirect(LANGPATH . '/cart/view');
                }
                $ordernum = $order->get('ordernum');
                $this->request->redirect('https://' . $_SERVER['HTTP_HOST'] . LANGPATH . '/payment/sofort_pay/'.$ordernum);
            }
            elseif($_POST['payment_method'] == 'IDEAL')
            {
                $this->request->redirect(BASEURL);
                $order = Request::factory(LANGPATH . '/order/set')->execute()->response;
                if (!$order)
                {
                    Message::set(__('order_create_failed'), 'error');
                    $this->request->redirect(LANGPATH . '/cart/view');
                }
                $ordernum = $order->get('ordernum');
                $this->request->redirect(LANGPATH . '/payment/ideal_pay/'.$ordernum);
            }
            elseif ($_POST['payment_method'] == 'GLOBEBILL')
            {
                $this->request->redirect(BASEURL);
                if ($_POST['billing_method'] == 2)
                {
                    $billing_address = array(
                        'billing_firstname' => $_POST['billing_firstname'],
                        'billing_lastname' => $_POST['billing_lastname'],
                        'billing_address' => $_POST['billing_address'],
                        'billing_city' => $_POST['billing_city'],
                        'billing_state' => $_POST['billing_state'],
                        'billing_country' => $_POST['billing_country'],
                        'billing_zip' => $_POST['billing_zip'],
                        'billing_phone' => $_POST['billing_phone']
                    );
                    Cart::billing_address($billing_address);
                }
                Site::instance()->add_clicks('globebill');
                Site::instance()->add_clicks('proceed');
                if (Site::instance()->get('is_pay_insite'))
                {
                    $order = Request::factory(LANGPATH . '/order/set')->execute()->response;
                    if (!$order)
                    {
                        Message::set(__('order_create_failed'), 'error');
                        $this->request->redirect(LANGPATH . '/cart/view');
                    }
                    $ordernum = $order->get('ordernum');
                    if($order->get('amount') <= 0.1)
                    {
                         $this->request->redirect(LANGPATH . '/payment/success/'.$ordernum);
                    }
                    Session::instance()->set('current_order', $ordernum);
                    $this->request->redirect(LANGPATH . '/payment/pay_insite1/'.$ordernum);
                }
                else
                {
                    $this->request->redirect(LANGPATH . '/payment/pay/'.$ordernum);
                }
            }
        }
        else
        {
            Site::instance()->add_clicks('cart_checkout');
        }
        $cart = Cart::get();
        $site_shipping = kohana::config('sites.shipping_price');
        $default_shipping = 0;
        foreach ($site_shipping as $key => $price)
        {
            if($price['price'] == 0){
                if($cart['extra_flg']&&$cart['extra_fee']>0){
                    $site_shipping[$key]['price']+=$cart['extra_fee'];
                    $default_shipping = $site_shipping[$key]['price'];
                }elseif($cart['amount']['items']<15){
                    $site_shipping[1]['price'] = 4.99;
                }
            }
        }
        $shipping_address = Cart::shipping_address();
        $has_address = isset($shipping_address['shipping_firstname']) && $shipping_address['shipping_firstname'] ? 1 : 0;
        if (!$has_address)
        {
            $default_address = DB::select()
                    ->from('accounts_address')
                    // ->where('site_id', '=', $this->site_id)
                    ->where('customer_id', '=', $customer_id)
                    ->order_by('is_default', 'DESC')
                    ->execute()->current();
            if (!empty($default_address))
            {
                $address = array(
                    'shipping_address_id' => $default_address['id'],
                    'shipping_method' => 'HKPF',
                    'shipping_firstname' => $default_address['firstname'],
                    'shipping_lastname' => $default_address['lastname'],
                    'shipping_address' => $default_address['address'],
                    'shipping_city' => $default_address['city'],
                    'shipping_state' => $default_address['state'],
                    'shipping_country' => $default_address['country'],
                    'shipping_zip' => $default_address['zip'],
                    'shipping_phone' => $default_address['phone'],
                    // 'shipping_cpf' => $default_address['cpf'],
                );
                Cart::shipping_billing($address);
            }
        }
        else
            $default_address = array();
        $no_express_countries = kohana::config('shipment.no-express');
        $no_standard_countries = kohana::config('shipment.no-standard');
        
        if($has_address && !empty($shipping_address['shipping_country']))
        {
            $shipping_country = $shipping_address['shipping_country'];
        }
        elseif(!empty($address['shipping_country']))
        {
            $shipping_country = $address['shipping_country'];
        }
        else
        {
            $shipping_country = '';
        }

        $cart_shipping = Session::instance()->get('cart_shipping');
        if(!isset($cart_shipping['price']) OR in_array($shipping_country, $no_express_countries))
        {
            $shipping['price'] = $site_shipping[1]['price'];
            Cart::shipping($shipping);
        }

        //guo add
        $tgift = '';
        $tsum = count($cart['products']);

        $product_amount = 0;
        $giftarr = Site::giftsku();
        foreach ($cart['products'] as $cart_val) {
            if(in_array($cart_val['id'], $giftarr) && $tsum == 1){
                $shipping['price'] = 7;
                Cart::shipping($shipping);
                Session::instance()->set('gift_shipping',7);
                $tgift = 1;
            }elseif(in_array($cart_val['id'], array('6693','35050'))){
                $shipping['price'] = 0;
                Cart::shipping($shipping);
                Session::instance()->set('gift_shipping',0);
                $tgift = 2;
            }
        }

        if(in_array($shipping_country, $no_standard_countries))
        {
            $shipping['price'] = $site_shipping[2]['price'];
            Cart::shipping($shipping);
        }

        $gift_shipping = Session::instance()->get('gift_shipping',7);

        foreach ($site_shipping as $key => $price){
            if($tgift && $key ==1){
                if($site_shipping[1]['price'] == 3){
                  $site_shipping[1]['price'] = 7;                    
                }

            }elseif($tgift==2){
                $site_shipping[1]['price'] = 0;
            }
        }

        $cart = Cart::get();
        //Add time 2015/09/25
        $progift = '';
        $giftarr = Site::giftsku();
        foreach ($cart['products'] as $cart_val) {
            if(in_array($cart_val['id'], $giftarr)){
                $progift = $cart_val['id'];
            }else continue;
        }


        if($cart['amount']['items'] <= 0 && empty($progift))
        {
            $current_order = Session::instance()->get('current_order');
            if($current_order)
                $this->request->redirect(LANGPATH . '/order/view/' . $current_order);
            else
                $this->request->redirect(LANGPATH . '/cart/view');
        }
        $countries = Site::instance()->countries(LANGUAGE);
        $countries_top = Site::instance()->countries_top(LANGUAGE);
        $addresses = Customer::instance($customer_id)->addresses();

        if (!empty($default_address['country']))
        {
            $carrier_address = $default_address;
        }
        else
        {
            $carrier_address['country'] = $countries[0]['isocode'];
        }
        $carriers = Site::instance()->carriers($carrier_address['country']);
        $carrier_param = array(
            'weight' => $cart['weight'],
            'shipping_address' => $carrier_address,
            'amount' => $cart['amount']
        );
        foreach ($carriers as $key => $carrier)
        {
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

        $points = Customer::instance($customer_id)->points();

        $product_amount = 0;
        $giftarr = Site::giftsku();
        $giftarr1 = array('6693','35050');
        $giftarr2 = array_merge($giftarr, $giftarr1); 

        $savearray = array();
        $vip_level = Customer::instance($customer_id)->get('is_vip');
        if(!$vip_level)
        {
            $vip_level = 0;
            $vipconfig = Site::instance()->vipconfig();
            $vip = $vipconfig[0]; 
        }
        else
        {
            $vipconfig = Site::instance()->vipconfig();
            $vip = $vipconfig[4]; 
        }

        $product_save = 0;
        foreach ($cart['products'] as $product)
        {
            $product_amount += $product['price'] * $product['quantity'];
            //check price   guo
            if(in_array($product['id'], $giftarr2))
            {
                $product['price'] = 0;
            }

            $origial_price = Product::instance($product['id'])->get('price');
            $sprice =  Product::instance($product['id'])->price();   
            $vip_price = Product::instance($product['id'])->get('price') * $vip['discount'];

            if ($vip_price < $sprice)
            {
                $sprice = $vip_price;
            }

            if($origial_price > $sprice)
            {
               $product_save += ($origial_price - $sprice) * $product['quantity'];
            }
        }


        $cart_save = 0;
        $isbundle = 0;
        if ($cart['amount']['save'])
        {
            if (isset($cart['promotion_logs']['cart']))
            {
                foreach ($cart['promotion_logs']['cart'] as $p_cart)
                {
                    if($p_cart['method'] == 'bundle')
                    {
                        $isbundle = 1;
                    }
                    if($isbundle)
                    {
                        $cart_save = $cart['amount']['save'];
                    }
                    else
                    {
                        if (isset($p_cart['save']) && $p_cart['save'])
                        {
                            $cart_save += $p_cart['save'];
                        }                        
                    }

                }
            }
        }

        $savearray = array(
                'cart_save' => $cart_save,
                'product_save' => $product_save,
                'product_amount' => $product_amount,
                'isbundle' => $isbundle
            );
/*
        echo '<pre>';
        print_r($savearray);
        print_r($cart);
        die;*/
        $points_avail = $points;
        $points_avail -= $cart['points'];
        if ($points_avail < 0)
            $points_avail = 0;

        // set default carrier
        $default_carrier = isset($cart['shipping']['carrier']) ? $cart['shipping']['carrier'] : current($carriers);

        $codes = array();
        $customer_codes = DB::query(Database::SELECT, 'SELECT DISTINCT o.code,o.id FROM carts_coupons o LEFT JOIN carts_customercoupons c ON o.id=c.coupon_id 
                                        WHERE c.customer_id= ' . $customer_id . ' AND o.limit <> 0 AND expired > ' . time() . ' ORDER BY o.id DESC')->execute()->as_array();
        $on_show_codes = DB::select('code')->from('carts_coupons')->where('limit', '<>', 0)->and_where('expired', '>', time())->and_where('on_show', '=', 1)->execute()->as_array();
        $codes = array_merge($customer_codes, $on_show_codes);
//        kohana::$log->add("customer_codes",json_encode($customer_codes));
//        kohana::$log->add("on_show_codes",json_encode($on_show_codes));
//        kohana::$log->add("codes",json_encode($codes));
        $sofort_countries = array(
            'DE' => 'EUR', 'AT' => 'EUR', 'CH' => 'CHF', 'BE' => 'EUR', 'FR' => 'EUR',
            'IT' => 'EUR', 'GB' => 'GBP', 'ES' => 'EUR', 'NL' => 'EUR', 'PL' => 'EUR',
        );

        //Paypal 20 countries 'Get Return Shipping Refunded'
        $paypal_refund_config = array(
            'FR' => 'fr', 'ES' => 'es', 'IT' => 'en', 'SE' => 'en', 'CY' => 'en', 'HR' => 'en', 'FI' => 'en', 
            'GR' => 'en', 'HU' => 'en', 'MT' => 'en', 'RO' => 'en', 'SV' => 'en', 'SK' => 'en', 'BG' => 'en', 
            'CZ' => 'en', 'PL' => 'en', 'CH' => 'de', 'LV' => 'ru', 'LT' => 'ru', 'EE' => 'ru',
        );

        $cart_message = Cart::message();

 //guo  FB获取金额
        $checkprice =   $cart['amount']['total'] + $default_shipping;
        $session_insurance = Session::instance()->get('insurance');
        if(!$session_insurance)
        {
            Session::instance()->set('insurance', 0.99);
            $session_insurance = 0.99;
        }

        //title
        $lang=LANGUAGE;
        $seoinfo=array(
                "de"=>array("title"=>"Zur Kasse"),
                "es"=>array("title"=>"Proceso de la Compra"),
                "fr"=>array("title"=>"Procéder au Paiement "),
                "ru"=>array("title"=>"Оформить Заказ"),
                );
        if($lang!=""){
            $this->template->title = $seoinfo[$lang]['title'];
        }else{
            $this->template->title = "Check Out";
        }
        $this->template->type = 'purchase';
        $this->template->checkprice = $checkprice;
        $this->template->content = View::factory('/cart/checkout')
            ->set('cart', $cart)
            ->set('gift_shipping',$gift_shipping)
            ->set('countries', $countries)
            ->set('countries_top', $countries_top)
            ->set('default_address', $default_address)
            ->set('addresses', $addresses)
            ->set('points_avail', $points_avail)
            ->set('site_shipping', $site_shipping)
            ->set('default_carrier', $default_carrier)
            ->set('carriers', $carriers)
            ->set('customer_id', $customer_id)
            ->set('codes', $codes)
            ->set('sofort_countries', $sofort_countries)
            ->set('paypal_refund_config', $paypal_refund_config)
            ->set('cart_message', $cart_message)
            ->set('no_express_countries', $no_express_countries)
            ->set('no_standard_countries', $no_standard_countries)
            ->set('savearray', $savearray)
            ->set('session_insurance', $session_insurance);
    }

    public function action_login()
    {
        if ($_POST)
        {
            $data = array();
            $data['email'] = Arr::get($_POST, 'email', '');
            $data['password'] = Arr::get($_POST, 'password', '');

            if ($customer_id = Customer::instance()->login($data))
            {
                Customer::instance($customer_id)->login_action();
                $this->request->redirect(LANGPATH . '/cart/check_out');
            }
            else
            {
                message::set(__('site_login_error'), 'error');
                $this->request->redirect(LANGPATH . '/cart/check_out');
            }
        }
    }

    public function action_register()
    {
        if ($_POST)
        {
            $data = array();
            $data['email'] = Arr::get($_POST, 'email', '');
            $data['password'] = Arr::get($_POST, 'password', '');
            $data['confirm_password'] = Arr::get($_POST, 'confirm_password', '');
            $data['firstname'] = ' ';
            $data['lastname'] = ' ';
            $data['ip'] = ip2long(Request::$client_ip);
            if (!Customer::instance()->is_register($data['email']))
            {
                if ($customer_id = Customer::instance()->set($data))
                {
                    $customer = Customer::instance($customer_id);
                    Event::run('Customer.register', $customer);
                    $customer->login_action();
                }
                else
                {
                    message::set(__('site_regist_error'), 'error');
                }
            }
            else
            {
                message::set(__('site_regist_email_used'), 'error');
            }
        }
        $this->request->redirect(LANGPATH . '/cart/check_out');
    }

    public function action_edit_address()
    {
        if (!$customer_id = Customer::logged_in())
        {
            Message::set(__('address_modify_do_fail'), 'error');
            $this->request->redirect(LANGPATH . '/cart/shipping_billing');
        }
        if ($_POST)
        {
            $aid = Arr::get($_POST, 'shipping_address_id', 0);
            $return = Arr::get($_POST, 'return', LANGPATH . '/cart/shipping_billing');
            if (!isset($_POST['shipping_firstname']))
            {
                $carriers = Site::instance()->carriers();
                foreach ($carriers as $c)
                {
                    $carrier = $c['id'];
                    break;
                }
                Address::instance($aid)->get('phone');
                $shipping = array(
                    'shipping_address_id' => $aid,
                    'shipping_method' => $carrier
                );
                Cart::shipping_billing($shipping);
                $this->request->redirect(LANGPATH . '/cart/shipping_billing');
            }
            if (!trim($_POST['shipping_address']) OR !trim($_POST['shipping_city']) OR !trim($_POST['shipping_country']) OR !trim($_POST['shipping_zip']) OR !trim($_POST['shipping_phone']))
            {
                Message::set(__('address_modify_do_fail'), 'error');
                echo '<script language="javascript">top.location.replace("'.BASEURL . $return . '");</script>';
                exit;
            }
            if ($aid == 'new')
            {
                $shipping_address = array();
                $shipping_address['customer_id'] = $customer_id;
                $shipping_address['firstname'] = Arr::get($_POST, 'shipping_firstname', '');
                $shipping_address['lastname'] = Arr::get($_POST, 'shipping_lastname', '');
                $shipping_address['address'] = Arr::get($_POST, 'shipping_address', '');
                $shipping_address['city'] = Arr::get($_POST, 'shipping_city', '');
                $shipping_address['state'] = Arr::get($_POST, 'shipping_state', '');
                $shipping_address['country'] = Arr::get($_POST, 'shipping_country', '');
                $shipping_address['zip'] = Arr::get($_POST, 'shipping_zip', '');
                $shipping_address['phone'] = Arr::get($_POST, 'shipping_phone', '');
                $shipping_address['cpf'] = Arr::get($_POST, 'shipping_cpf', '');
                $result = Address::instance()->set($shipping_address);
                if (!$result)
                {
                    Message::set(__('address_modify_do_fail'), 'error');
                }
                else
                {
                    Cart::shipping_billing($_POST);
                }
                echo '<script language="javascript">top.location.replace("'.BASEURL . $return . '");</script>';
                exit;
            }
            elseif ($aid)
            {
                $shipping_address = array();
                $shipping_address['firstname'] = Arr::get($_POST, 'shipping_firstname', '');
                $shipping_address['lastname'] = Arr::get($_POST, 'shipping_lastname', '');
                $shipping_address['address'] = Arr::get($_POST, 'shipping_address', '');
                $shipping_address['city'] = Arr::get($_POST, 'shipping_city', '');
                $shipping_address['state'] = Arr::get($_POST, 'shipping_state', '');
                $shipping_address['country'] = Arr::get($_POST, 'shipping_country', '');
                $shipping_address['zip'] = Arr::get($_POST, 'shipping_zip', '');
                $shipping_address['phone'] = Arr::get($_POST, 'shipping_phone', '');
                $shipping_address['cpf'] = Arr::get($_POST, 'shipping_cpf', '');
                DB::update('accounts_address')->set($shipping_address)->where('id', '=', $aid)->execute();
                Cart::shipping_billing($_POST);
                Message::set(__('address_modify_do_success'), 'success');
                echo '<script language="javascript">top.location.replace("'.BASEURL . $return . '");</script>';
                exit;
            }
        }
        $id = $this->request->param('id');
        if (!$id)
        {
            echo 'Connot find shipping address';
            exit;
        }
        $address = DB::select()->from('accounts_address')->where('id', '=', $id)->execute()->current();
        $countries = Site::instance()->countries(LANGUAGE);
        $carriers = Site::instance()->carriers();
        foreach ($carriers as $c)
        {
            $carrier = $c['id'];
            break;
        }
        echo View::factory('/cart/address')->set('address', $address)->set('countries', $countries)->set('carrier', $carrier);
        exit;
    }

    public function action_delete_address()
    {
        if ($_POST)
        {
            $address_id = Arr::get($_POST, 'address_id', 0);
            if ($address_id)
            {
                $customer_id = Customer::logged_in();
                DB::delete('accounts_address')->where('id', '=', $address_id)->and_where('customer_id', '=', $customer_id)->execute();
            }
        }
        $this->request->redirect(LANGPATH . '/cart/shipping_billing');
    }

    public function action_ajax_add()
    {
        if ($_POST)
        {
            $post['id'] = Arr::get($_POST, 'id', 0);
            $post['quantity'] = Arr::get($_POST, 'quantity', 1);
            #$post['items'][] = $post['id'];
            $post['type'] = Arr::get($_POST, 'type', 0);
            $size = trim(Arr::get($_POST, 'size', ''));
            $post['attributes']['Size']  = $size;
            if (!$size)
            {
                echo json_encode(0);
                exit;
            }
            if ($post['quantity'] == 0)
            {
                echo json_encode(0);
                exit;
            }
            $lang = Arr::get($_GET, 'lang', '');
            if ($post['type'] == 3)
            {
                $postsize = $post['attributes']['Size'];
                if(Product::instance($post['id'])->get('set_id') == 2)
                {
                   $att =  kohana::config('sites.apishoes');
                    if(strpos($postsize, '-') !== FALSE)
                    {
                        $newsizearr = explode('-',$postsize);
                        $postsize = $newsizearr[0].'-UK'.$newsizearr[1];
                    }

                   foreach ($att as $key => $value) 
                   {
                        $newatt = explode('/',$value);
                        if(is_numeric($postsize))
                        {
                            $postsize = 'EUR'.$postsize;
                        }
                        if(in_array($postsize,$newatt))
                        {
                            $postsize = $value;
                        }
                   }
                }

                $proitem= DB::select('id','stock')->from('products_productitem')->where('product_id', '=', $post['id'])->and_where('attribute', '=', $postsize)->and_where('status', '=', 1)->execute('slave')->as_array();

                if(!isset($proitem[0]) || $proitem[0]['id'] < 1)
                {
                    kohana_log::instance()->add('PRODUCT_ERROR', $post['id']);
                    echo json_encode(0);
                    exit;  
                }
                else
                {
                    $post['items'][] = $proitem[0]['id'];
                }

                if (Product::instance($post['id'])->get('stock') == -1)
                {
                    $cart_stock = 0;
                    $products = Session::instance()->get('cart_products');
                    if (!empty($products))
                    {
                        foreach ($products as $p)
                        {
                            if ($p['id'] == $post['id'] AND $p['attributes']['Size'] == $post['attributes']['Size'])
                                $cart_stock = $p['quantity'];
                        }
                    }

                    $product_stocks = (int) $proitem[0]['stock'];

                    if ($post['quantity'] > $product_stocks - $cart_stock)
                        $post['quantity'] = $product_stocks - $cart_stock;
                }
            }else{
                echo json_encode(0);
                exit;
            }

            if ($post['quantity'] != 0)
            {
                if(isset($post['attributes']))
                {
                    Cartcookie::add2cart($post);//cartcookie                  
                }
                else
                {
                    kohana_log::instance()->add('NO_ATTRIBUTES', $post['id']);
                    echo json_encode(0);
                    exit;
                }


                // Cart::add2cart($post);
            }
            DB::query(Database::UPDATE, 'UPDATE products_product SET add_times=add_times+1 WHERE id=' . $post['id'])->execute();
          //  Product::instance($post['id'])->daily_add_times();
            Site::instance()->add_clicks('add_to_cart');
            // $cart = Cart::get();

            $cart = Cartcookie::get();//cartcookie


            if (!empty($cart['products']))
            {
                $productArr = array();
                foreach ($cart['products'] as $p)
                {
                    $product = array();
                    $product['name'] = Product::instance($p['id'], $lang)->get('name');
                    $product['link'] = Product::instance($p['id'], $lang)->permalink();
                    $product['sku'] = Product::instance($p['id'])->get('sku');
                    $product['image'] = image::link(Product::instance($p['id'])->cover_image(), 3);
                    $product['price'] = Site::instance()->price($p['price'], 'code_view');
                    $attributes = '';
                    foreach ($p['attributes'] as $key => $val)
                    {
                        $attributes .= $key . ':' . $val . ';<br>';
                    }
                    $product['attributes'] = $attributes;
                    $product['quantity'] = $p['quantity'];
                    $productArr[] = $product;
                }
                echo json_encode($productArr);
            }
            else
                echo json_encode(0);
            exit;
        }
    }


    public function action_shipping_price()
    {
        if($_POST)
        {
            $site_shipping = kohana::config('sites.shipping_price');
            $shipping_price = Arr::get($_POST, 'shipping_price', 0);
            if ($shipping_price <= 0)
                $shipping_price = 0;
            else
                $shipping_price = $site_shipping[1]['price'];
            $shipping['price'] = $shipping_price;
            Cart::shipping($shipping);
        }
        $this->request->redirect(LANGPATH . '/cart/check_out');
    }
    
    public function action_edit_shipping()
    {
        if (!$customer_id = Customer::logged_in())
        {
            Message::set(__('address_modify_do_fail'), 'error');
            $this->request->redirect(LANGPATH . '/cart/shipping_billing');
        }
        if ($_POST)
        {
            $aid = Arr::get($_POST, 'shipping_address_id', 0);
            if ($aid === 'new')
            {
                $shipping_address = array();
                $shipping_address['customer_id'] = $customer_id;
                $shipping_address['firstname'] = Arr::get($_POST, 'shipping_firstname', '');
                $shipping_address['lastname'] = Arr::get($_POST, 'shipping_lastname', '');
                $shipping_address['address'] = Arr::get($_POST, 'shipping_address', '');
                $shipping_address['city'] = Arr::get($_POST, 'shipping_city', '');
                $shipping_address['state'] = Arr::get($_POST, 'shipping_state', '');
                $shipping_address['country'] = Arr::get($_POST, 'shipping_country', '');
                $shipping_address['zip'] = Arr::get($_POST, 'shipping_zip', '');
                $shipping_address['phone'] = Arr::get($_POST, 'shipping_phone', '');
                $shipping_address['cpf'] = Arr::get($_POST, 'shipping_cpf', '');
                $result = Address::instance()->set($shipping_address);
                if (!$result)
                {
                    Message::set(__('address_modify_do_fail'), 'error');
                    $this->request->redirect(LANGPATH . '/cart/shipping_billing');
                }
                else
                {
                    Cart::shipping_billing($_POST);
                }
            }
            elseif ($aid)
            {
                $shipping = array(
                    'shipping_address_id' => $aid,
                    'shipping_method' => 'HKPF'
                );
                Cart::shipping_billing($shipping);
            }
            $site_shipping = kohana::config('sites.shipping_price');
            $shipping_price = Arr::get($_POST, 'shipping_price', 0);
            if ($shipping_price <= 0)
                $shipping_price = 0;
            // else
            //     $shipping_price = $site_shipping[1]['price'];
            $shipping['price'] = $shipping_price;
            Cart::shipping($shipping);
        }
        $this->request->redirect(LANGPATH . '/cart/check_out');
    }
    
    public function action_product_edit()
    {
        if($_POST)
        {
            $key = Arr::get($_POST, 'key', '');
            if($key)
            {
                $quantity = Arr::get($_POST, 'quantity', 1);
                if($quantity < 1)
                    $quantity = 1;
                $attr = Arr::get($_POST, 'attribute', '');
                $attrs = explode('-', $attr);
                $attribute = trim($attrs[0]);
                $qty = isset($attrs[1]) ? (int) trim($attrs[1]) : 1;
                if($quantity > $qty)
                    $quantity = $qty;
                $product = Cart::product($key);

                $proitem = DB::select('id')->from('products_productitem')->where('product_id', '=', $product['id'])->and_where('attribute', '=', $product['attributes']['Size'])->and_where('status', '=', 1)->execute('slave')->as_array();
                if(!isset($proitem[0]) || $proitem[0]['id'] < 1)
                {
                    kohana_log::instance()->add('PRODUCT_ERROR', $product['id']);
                    echo json_encode(0);
                    exit;  
                }
                else
                {
                    $items= $proitem[0]['id'];
                }

                $newproitem = DB::select('id')->from('products_productitem')->where('product_id', '=', $product['id'])->and_where('attribute', '=', $attribute)->and_where('status', '=', 1)->execute('slave')->as_array(); 
                $newitems = $newproitem[0]['id'];
                // Cart::delete($key);
                $key1 = $items.'_'.$product['attributes']['Size'];

                // Cart::delete($key);
                Cartcookie::delete($key1);//cartcookie
                $giftarr = Site::giftsku();
                if(in_array($product['id'], $giftarr)){
                    $quantity = 1;
                }


                $data = array(
                    'id' => $product['id'],
                    'items' => array($newitems),
                    'quantity' => $quantity,
                    'type' => $product['type'],
                    'attributes' => array('Size' => $attribute)
                );

                Cart::add2cart($data);
            }
        }
        $this->request->redirect(LANGPATH . '/cart/view');
    }

    public function action_chk_total(){
        $total_price = Arr::get($_POST, 'total_amount', '');
        var_dump($total_price);exit; 
        echo Site::instance()->price($total_price, 'code_view');
        exit;
    }
  
    public function action_add_more()
    {
        $page = '';
        if($_POST)
        {
            $checks = Arr::get($_POST, 'check', array());
            $items = Arr::get($_POST, 'item', array());
            $sizes = Arr::get($_POST, 'size', array());
            $qtys = Arr::get($_POST, 'qty', array());
            foreach($checks as $key => $check)
            {
                if(!isset($sizes[$key]) OR !isset($items[$key]) OR !isset($qtys[$key]))
                    continue;
                $post = array();
                $post['id'] = $items[$key];
                $post['quantity'] = $qtys[$key];
                $post['items'] = array($post['id']);
                $post['type'] = 3;
                if ($post['type'] == 3)
                {
                    $attribute = array('Size' => $sizes[$key]);
                    $post['attributes'] = $attribute;
                    if (Product::instance($post['id'])->get('stock') == -1)
                    {
                        $cart_stock = 0;
                        $products = Session::instance()->get('cart_products');
                        if (!empty($products))
                        {
                            foreach ($products as $p)
                            {
                                if ($p['id'] == $post['id'])
                                    $cart_stock = $p['quantity'];
                            }
                        }
                        $product_stocks = DB::select('stock')
                                        ->from('products_productitem')
                                        ->where('product_id', '=', $post['id'])
                                        ->where('attribute', 'LIKE', '%' . $post['attributes']['Size'] . '%')
                                        ->execute()->get('stock');
                        $product_stocks = (int) $product_stocks;
                        if ($post['quantity'] > $product_stocks - $cart_stock)
                            $post['quantity'] = $product_stocks - $cart_stock;
                    }
                }
                if ($post['quantity'] != 0)
                {
                    Cart::add2cart($post);
                }
            }
            $page = Arr::get($_POST, 'page', '');
        }
        $page = $page ? '?' . $page : '';
        $this->request->redirect(LANGPATH . '/cart/view' . $page);
    }

    public function action_add_moreforchina()
    {
        $page = '';
        if($_POST)
        {

            $id = Arr::get($_POST, 'item', array());
            $sizes = Arr::get($_POST, 'size', array());
            $qtys = Arr::get($_POST, 'qty', 1);

                $post = array();
                $post['id'] = $id;
                $post['quantity'] = $qtys;
                $post['items'] = array($post['id']);
                $post['type'] = 3;

                if ($post['type'] == 3)
                {
                    $attribute = array('Size' => $sizes);
                    $post['attributes'] = $attribute;
                    if (Product::instance($post['id'])->get('stock') == -1)
                    {
                        $cart_stock = 0;
                        $products = Session::instance()->get('cart_products');
                        if (!empty($products))
                        {
                            foreach ($products as $p)
                            {
                                if ($p['id'] == $post['id'])
                                    $cart_stock = $p['quantity'];
                            }
                        }
                        $product_stocks = DB::select('stocks')
                                        ->from('products_stocks')
                                        ->where('product_id', '=', $post['id'])
                                        ->where('attributes', 'LIKE', '%' . $post['attributes']['Size'] . '%')
                                        ->execute()->get('stocks');
                        $product_stocks = (int) $product_stocks;
                        if ($post['quantity'] > $product_stocks - $cart_stock)
                            $post['quantity'] = $product_stocks - $cart_stock;
                    }
                }
                if ($post['quantity'] != 0)
                {
                    Cart::add2cart($post);
                }
            
         
        }
       
        $this->request->redirect(LANGPATH . '/cart/view');
    }

    //cartcookie
    public function action_cookie2cart(){
        $key = $this->request->param('id');
        $key = str_replace('%20', ' ', $key);
        Cartcookie::cookie2cart($key);
        Site::instance()->add_clicks('cookie_to_cart');
        $this->request->redirect(LANGPATH . '/cart/view');
    }

    //cartcookie
    public function action_cookie2later(){
        $key = $this->request->param('id');
        $key = str_replace('%20', ' ', $key);
        $arr = explode("_",$key);
        $proarr = array(50051,50050);
        if(in_array($arr[0],$proarr)){
        $customer_id = Customer::instance()->logged_in();
        $memcache_key = $customer_id.'_get0.01product';
        Cache::instance('memcache')->set($memcache_key,0,604800);//cuxiao product
        }
        Cartcookie::cookie2later($key);
        Site::instance()->add_clicks('cart_to_cookie'); 
        $referer = LANGPATH . '/cart/view';
        if(isset($_SERVER['HTTP_REFERER']) AND toolkit::is_our_url($_SERVER['HTTP_REFERER']))
        {
            $referer = $_SERVER['HTTP_REFERER'];
        }
        $this->request->redirect($referer);
    }

    //cartcookie
    public function action_cartcookie_invalid(){
        if($customer_id = Customer::logged_in()){
            Cartcookie::invalid($customer_id);
        }else{
            $cookie_id = Cookie::get('cookie_id');
            if($cookie_id){
                Cartcookie::invalid($cookie_id);
            }
        }
        $this->request->redirect(LANGPATH . '/cart/view');
    }

    //checkout page add message
    public function action_set_message()
    {
        if($_POST)
        {
            $success = 0;
            $message = trim(Arr::get($_POST, 'message', ''));
            $message_change = trim(Arr::get($_POST, 'message_change', ''));
            if($message AND $message_change)
            {
                Cart::message($message);
                $success = 1;
            }
            $return_url = Arr::get($_POST, 'return_url', '/cart/checkout');
            if($return_url == 'ajax')
            {
                $data['success'] = $success;
                $data['message'] = 'success!';
                echo json_encode($data);
                exit;
            }
            else
            {
                if(!$success)
                {
                    Message::set(__('post_data_error'), 'error');
                }
                else
                {
                    Message::set('Success', 'success');
                }
                $this->request->redirect($return_url);
            }
        }
    }

    //注册有礼功能之用户检测 Add Time 2015/9/23
    public function action_ajax_chkuser()
    {
        //用户验证
        $usermail = Arr::get($_POST,'email');
        $chkmail = Security::xss_clean($usermail);
        if (!Validate::email($chkmail)) {
            echo trim('emailerror');exit;
        }
            
        //检测用户是否已注册
        if(!Customer::instance()->is_register($usermail)) {
            echo trim('success');exit;
        }else{
            echo trim('isset');exit;
        }
    }

    public function action_add_to_cart()
    {
        $id = Arr::get($_POST, 'id');
        if($id)
        {
            $attribute = Product::instance($id)->get('attributes');
            //随机取尺码
            if(is_array($attribute)){
                $SizeAll = count($attribute['Size']);
                if($SizeAll>1){
                    $sizeInt = array_rand($attribute['Size']);
                    $size = $attribute['Size'][$sizeInt];
                    $searchsize = trim($size);
                }else{
                    $searchsize = trim($attribute['Size'][0]);
                }
            }
            $cart_data['id'] = $id;
            $cart_data['quantity'] = 1;
            $cart_data['items'][] = $id;
            $cart_data['type'] = Product::instance($id)->get('type');
            $cart_data['price'] = Site::instance()->price(Product::instance($id)->price(), 'code_view');
            $data['attributes'] = $searchsize;
            Cartcookie::add2cart($cart_data);//将商品信息存入COOKIE
            DB::query(Database::UPDATE, 'UPDATE products_product SET add_times=add_times+1 WHERE id=' . $id)->execute();
            Product::instance($product[0])->daily_add_times();
            Site::instance()->add_clicks('add_to_cart');
            $cart = Cartcookie::get(); 
            echo $cart ? trim('success') : 'Failed to add a shopping cart!';exit;   
        }
    }

     public function action_ajax_user_add()
     {
        if ($_POST)
        {
            $password=Arr::get($_POST, 'password', '');
            $data = array();
            $data['email'] = Arr::get($_POST, 'email', '');
            $data['email'] = Security::xss_clean($data['email']);
            $proInfo = Arr::get($_POST, 'product_id', '');
            $lang = Arr::get($_GET, 'lang', '');
            $referer = Arr::get($_POST, 'referer', '');
            $get_data = Arr::get($_POST, 'data', '');
        //验证产品ID/SKU信息传输是否正常
            if(empty($proInfo) || strlen($proInfo) < 5)
            {
                echo trim('The network is suspended, please try again later.');exit;
            }
        //密码长度过短或过长
            if(strlen($password) < 6 || strlen($password) > 24)
            {
                echo trim('Password should between 6-24 characters.');exit;
            }
            if (!Validate::email($data['email']))
            {
                message::set(__('site_regist_error'), 'error');
            }
            else
            {
                $data['firstname'] = Arr::get($_POST, 'firstname', '');
                $data['lastname'] = Arr::get($_POST, 'lastname', '');
                $data['password'] = Arr::get($_POST, 'password', '');
                $data['confirm_password'] = Arr::get($_POST, 'confirm_password', '');
                $data['ip'] = ip2long(Request::$client_ip);

                if (!Customer::instance()->is_register($data['email']))
                {
                    if ($data['ip'] != 0)
                        $has_ip = DB::select('id')->from('accounts_customers')->where('ip', '=', $data['ip'])->execute()->get('id');
                    else
                        $has_ip = 0;
                    $data['lang'] = $this->language;
                    $isflag = DB::select('id')->from('accounts_customers')->where('email', '=', $data['email'])->where('flag', '=', 1)->execute('slave')->get('id');
                    if(!empty($isflag))
                    {
                        $data['id'] = $isflag;
                    }
                    else
                    {
                        $data['id'] = '';
                    }
                    $data['status'] = '1';
                    if ($customer_id = Customer::instance()->set($data))
                    {
                        //celebrity add customer_id
                        $celebrity = DB::select('id', 'customer_id')->from('celebrities_celebrits')->where('email', '=', $data['email'])->execute()->current();
                        if (!empty($celebrity) AND $celebrity['customer_id'] == 0)
                        {
                            DB::update('celebrities_celebrits')->set(array('customer_id' => $customer_id))->where('id', '=', $celebrity['id'])->execute();
                        }

                        $coupon_code = 'SIGNUP15OFF' . $customer_id;
                        $coupon = array(
                            // 'site_id' => $this->site_id,
                            'code' => $coupon_code,
                            'value' => 15,
                            'type' => 1,
                            'limit' => 1,
                            'used' => 0,
                            'created' => time(),
                            'expired' => time() + 30 * 86400,
                            'on_show' => 0,
                            'deleted' => 0,
                            'effective_limit' => 0,
                            'usedfor' => 1
                        );
                        $insert = DB::insert('carts_coupons', array_keys($coupon))->values($coupon)->execute();
                        if ($insert)
                        {
                            $c_coupon = array(
                                'customer_id' => $customer_id,
                                'coupon_id' => $insert[0],
                                'deleted' => 0
                                // 'site_id' => $this->site_id
                            );
                            DB::insert('carts_customercoupons', array_keys($c_coupon))->values($c_coupon)->execute();
                            $mail_params['coupon_code'] = $coupon_code;
                            $mail_params['expired'] = date('Y-m-d H:i', $coupon['expired']);
                        }
                        $customer = Customer::instance($customer_id);
            $customer->login_action();//执行登陆
                //cartcookie
            Cookie::set('cookie_id',$customer_id,5184000);//60 days expire

                        // 发送邮件
                            $mail_params['password'] = $data['password'];
                            $mail_params['email'] = $data['email'];
                            $mail_params['firstname'] = $data['firstname'];
                            Mail::SendTemplateMail('NEWREGISTER', $data['email'], $mail_params);

            //组装购物车数组
            $product = explode('-', $proInfo);
            $cart_data['id'] = $product[0];
            $cart_data['quantity'] = 1;
            $item_id = DB::select('id')->from('products_productitem')->where('product_id','=',$product[0])->execute();
            $cart_data['items'][] = $item_id->get('id');
            $cart_data['type'] = 3;
            $cart_data['price'] = 0;

            $cart_data['attributes']['Size']  = 'one size';
            $data['attributes'] = 'One Size';
            Cartcookie::add2cart($cart_data);//将商品信息存入COOKIE
            DB::query(Database::UPDATE, 'UPDATE products_product SET add_times=add_times+1 WHERE id=' . $product[0])->execute();
            Product::instance($product[0])->daily_add_times();
            Site::instance()->add_clicks('add_to_cart');
            $cart = Cartcookie::get(); 
            echo $cart ? trim('success') : 'Failed to add a shopping cart!';exit;

                        //Request::instance()->redirect($do_redirect);
                    }
                    else
                    {
                        message::set(__('site_regist_error'), 'error');
                    }
                }
                else
                {
                    message::set(__('site_regist_email_used'), 'error');
                }
            }
        }
        $referer = (isset($_SERVER['HTTP_REFERER']) AND toolkit::is_our_url($_SERVER['HTTP_REFERER'])) ?
            $_SERVER['HTTP_REFERER'] : '';
        if ($customer_id = Customer::logged_in())
        {
            if (!$referer || strpos($referer, 'customer/login') || strpos($referer, 'customer/register'))
            {
                //if customer is login, referer is null or referer is login or register, direct to index page.
                Request::instance()->redirect(LANGPATH . URL::base() . 'customer/profile');
            }
            else
            {
                toolkit::is_our_url($referer) ? Request::instance()->redirect(LANGPATH . $referer) : Request::instance()->redirect(LANGPATH . URL::base() . 'customer/profile');
            }
        }

        $this->template->content = View::factory('/login')
            ->set('referer', $referer);
    }

    public function action_fbuser_add()
    {
        if ($_POST)
        {  
            $proInfo = Arr::get($_POST, 'product_id', '');
            $lang = Arr::get($_GET, 'lang', '');
            //验证产品ID/SKU信息传输是否正常
            if(empty($proInfo) || strlen($proInfo) < 5)
            {
                echo trim('The network is suspended, please try again later.');exit;
            }
            $user_id = Customer::logged_in();
            if(empty($user_id))
            {
              echo 'Failed to add a shopping cart!';exit;  
            }
            //组装购物车数组

            $product = explode('-', $proInfo);
            $cart_data['id'] = $product[0];
            $cart_data['quantity'] = 1;
            $cart_data['items'][] = $product[0];
            $cart_data['type'] = 3;
            $cart_data['price'] = 0;
            $cart_data['attributes']['Size']  = 'one size';
            $data['attributes'] = 'One Size';
            Cartcookie::add2cart($cart_data);//将商品信息存入COOKIE
            DB::query(Database::UPDATE, 'UPDATE products_product SET add_times=add_times+1 WHERE id=' . $product[0])->execute();
            Product::instance($product[0])->daily_add_times();
            Site::instance()->add_clicks('add_to_cart');
            $cart = Cartcookie::get(); 
            echo ($cart) ? trim('success') : 'Failed to add a shopping cart!';exit;
        }      
    }

    //收藏
    public function action_collection(){
        $product_id = Arr::get($_POST, 'product_id');
        $customer_id = Customer::instance()->logged_in();
        
        $lang = Arr::get($_GET, 'lang', '');
        if(!$customer_id){echo "error";exit;}
        $product_id1 = DB::select('product_id')
                                        ->from('accounts_wishlists')
                                        ->where('product_id', '=', $product_id)
                                        ->where('customer_id', '=', $customer_id)
                                        ->execute()->get('product_id');
        if($product_id1==$product_id){
            echo "error1";
            exit;
        }else{
        $insetArr = array(
                'site_id' => Site::instance()->get('id'),
                'product_id' => $product_id,
                'name'  =>  Product::instance($product_id,$lang)->get('name'),
                'permalink' => Product::instance($product_id,$lang)->permalink(),
                'customer_id'   => $customer_id,
                'created'=>time()
        );
        $ok = DB::insert('accounts_wishlists', array_keys($insetArr))->values($insetArr)->execute();
        echo "ok";
        exit;
        }
        
    }

    public function action_cart_promotion()
    {
        
        $att = Arr::get($_POST, 'att','');
        $cart = Cartcookie::get();
        if(empty($att))
        {  
           $att = $cart['shipping_address']['shipping_country'];
        }

        $has_no_express = 0;
        $no_express_countries = kohana::config('shipment.no-express');
        $total_price = 0;
        if(in_array($att, $no_express_countries))
        {
            $has_no_express = 1;
        }

        $data =array();
        if(!in_array($att,array('US','TW','HK')))
        {
            $data['success'] = 0;
            $data['price'] = Site::instance()->price(15, 'code_view');
            $data['shipping_country'] = $att;
            $data['has_no_express'] = $has_no_express;
            echo json_encode($data);
            die;
        }
       
        foreach($cart['products'] as $product =>$value)
        {
            $product_instance = Product::instance($value['id']);
            $all_catalog = $product_instance->all_catalog();

            $newarr = array();
            if(is_string($all_catalog))
            {
                array_push($newarr,$all_catalog);
            }
            else
            {
                $newarr = $all_catalog;
            }
            if($newarr != 0)
            {
                if(count($newarr) > 0 && is_array($newarr))
                {
                    if(in_array(395,$newarr))
                    {
                        $total_price = $total_price + ($value['price'] * $value['quantity']);
                    }                      
                }
                                   
            }            
        }


        if($total_price >=79)
        {
            $shipping['price'] = 15;
            Cart::shipping($shipping);
            $cart = Cartcookie::get();

            if(Session::instance()->get('insurance') == -1){
                $in = 0;
            }else{
                $in = 0.99;
            }

            if(!in_array($att,array('US','TW','HK')))
            {
                $data['success'] = 0;
                $data['price'] = Site::instance()->price(15, 'code_view');
                $data['shipping_country'] = $att;
                $data['has_no_express'] = $has_no_express;
                echo json_encode($data);
                die;
            }
            else
            {
                $data['total'] = Site::instance()->price($cart['amount']['total'] + $in, 'code_view');         
                $data['price'] = Site::instance()->price(0, 'code_view');
                $data['has_no_express'] = $has_no_express;
                $data['success'] = 1;
                Session::instance()->set('amount_ship',1);
                echo json_encode($data);
                die;                    
            }

     
        }
        else
        {
            $data['success'] = 0;
            $data['price'] = Site::instance()->price(15, 'code_view');
            echo json_encode($data);
            die;            
        } 

    }

}
