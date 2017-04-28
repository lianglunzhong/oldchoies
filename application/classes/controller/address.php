<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Address extends Controller_Webpage
{

    public function action_add()
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(LANGPATH . '/customer/login?redirect=' . URL::current(TRUE));
        }

        if ($_POST)
        {
            $data = array();
            $data['customer_id'] = $customer_id;
            $data['firstname'] = Arr::get($_POST, 'firstname', '');
            $data['lastname'] = Arr::get($_POST, 'lastname', '');
            $data['address'] = Arr::get($_POST, 'address', '');
            $data['city'] = Arr::get($_POST, 'city', '');
            $data['zip'] = Arr::get($_POST, 'zip', '');
            $data['state'] = Arr::get($_POST, 'state', '');
            $data['country'] = Arr::get($_POST, 'country', '');
            $data['phone'] = Arr::get($_POST, 'phone', '');
            $data['other_phone'] = Arr::get($_POST, 'other_phone', '');
            $data['is_default'] = Arr::get($_POST, 'is_default', 0);
            $data['deleted'] = 0;
            if ($data['is_default'])
                DB::update('accounts_address')->set(array('is_default' => 0))->where('customer_id', '=', $customer_id)->execute();
            if (Address::instance()->set($data))
            {
                message::set(__('address_add_do_success'));
                $this->request->redirect(LANGPATH . '/customer/address');
            }
            else
            {
                message::set(__('address_add_do_fail'), 'error');
            }
        }
        $countries = Site::instance()->countries(LANGUAGE);
        $countries_top = Site::instance()->countries_top(LANGUAGE);
        //title
        $lang=LANGUAGE;
        $seoinfo=array(
                "de"=>array("title"=>"Neue Adresse Hinzufügen"),
                "es"=>array("title"=>"Añadir Nueva Dirección"),
                "fr"=>array("title"=>"Ajouter Une Nouvelle Adresse"),
                "ru"=>array("title"=>"Создать Адрес"),
                );
        if($lang!=""){
            $this->template->title = $seoinfo[$lang]['title'];
        }else{
            $this->template->title = "Add New Address";
        }
        $this->template->content = View::factory('/address/add')
            ->set('countries', $countries)
            ->set('countries_top', $countries_top);
    }

    public function action_edit()
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . LANGPATH . '?redirect=' . URL::current(TRUE));
        }

        $id = $this->request->param('id');

        if ($_POST)
        {
            $data = array();
            $data['firstname'] = Arr::get($_POST, 'firstname', '');
            $data['lastname'] = Arr::get($_POST, 'lastname', '');
            $data['address'] = Arr::get($_POST, 'address', '');
            $data['city'] = Arr::get($_POST, 'city', '');
            $data['zip'] = Arr::get($_POST, 'zip', '');
            $data['state'] = Arr::get($_POST, 'state', '');
            $data['country'] = Arr::get($_POST, 'country', '');
            $data['phone'] = Arr::get($_POST, 'phone', '');
            $data['other_phone'] = Arr::get($_POST, 'other_phone', '');

            if (Address::instance($id)->set($data))
            {
                message::set(__('address_modify_do_success'));
            }
            else
            {
                message::set(__('address_modify_do_fail'), 'error');
            }
        }

        $this->template->content = View::factory('/address/edit')
            ->set('countries', Site::instance()->countries())
            ->set('address', Address::instance($id)->get());
    }

    public function action_delete()
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . LANGPATH . '?redirect=' . URL::current(TRUE));
        }

        $id = $this->request->param('id');

        if (Address::instance($id)->delete())
        {
            message::set(__('address_delete_success'));
        }
        else
        {
            message::set(__('address_delete_fail'), 'error');
        }

        $this->request->redirect(LANGPATH . '/customer/address');
    }

    public function action_ajax_edit()
    {
        if (!$customer_id = Customer::logged_in())
        {
            Message::set(__('address_modify_do_fail'));
            $this->request->redirect(LANGPATH . '/customer/summary');
        }
        if ($_POST)
        {
            $aid = Arr::get($_POST, 'address_id', 0);
            $return = Arr::get($_POST, 'return_url', LANGPATH . '/customer/summary');
            if (!isset($_POST['firstname']))
            {
                $this->request->redirect(LANGPATH . '/customer/summary');
            }
            if (!$_POST['address'] OR !$_POST['city'] OR !$_POST['country'] OR !$_POST['zip'] OR !$_POST['phone'])
            {
                Message::set(__('address_modify_do_fail'));
                echo '<script language="javascript">top.location.replace("'.BASEURL . $return . '");</script>';
                exit;
            }
            if ($aid == 'new')
            {
                $shipping_address = array();
                $shipping_address['customer_id'] = $customer_id;
                $shipping_address['firstname'] = Arr::get($_POST, 'firstname', '');
                $shipping_address['lastname'] = Arr::get($_POST, 'lastname', '');
                $shipping_address['address'] = Arr::get($_POST, 'address', '');
                $shipping_address['city'] = Arr::get($_POST, 'city', '');
                $shipping_address['state'] = Arr::get($_POST, 'state', '');
                $shipping_address['country'] = Arr::get($_POST, 'country', '');
                $shipping_address['zip'] = Arr::get($_POST, 'zip', '');
                $shipping_address['phone'] = Arr::get($_POST, 'phone', '');
                $shipping_address['cpf'] = Arr::get($_POST, 'cpf', '');
                $shipping_address['is_default'] = Arr::get($_POST, 'default', 0);
                if ($shipping_address['is_default'])
                    DB::update('accounts_address')->set(array('is_default' => 0))->where('customer_id', '=', $customer_id)->execute();
                Address::instance()->set($shipping_address);
                Message::set(__('address_add_do_success'), 'success');
                echo '<script language="javascript">top.location.replace("'.BASEURL . $return . '");</script>';
                exit;
            }
            elseif ($aid)
            {
                $shipping_address = array();
                $shipping_address['firstname'] = Arr::get($_POST, 'firstname', '');
                $shipping_address['lastname'] = Arr::get($_POST, 'lastname', '');
                $shipping_address['address'] = Arr::get($_POST, 'address', '');
                $shipping_address['city'] = Arr::get($_POST, 'city', '');
                $shipping_address['state'] = Arr::get($_POST, 'state', '');
                $shipping_address['country'] = Arr::get($_POST, 'country', '');
                $shipping_address['zip'] = Arr::get($_POST, 'zip', '');
                $shipping_address['phone'] = Arr::get($_POST, 'phone', '');
                // $shipping_address['cpf'] = Arr::get($_POST, 'cpf', '');
                $shipping_address['is_default'] = Arr::get($_POST, 'default', 0);
                if ($shipping_address['is_default'])
                {
                    DB::update('accounts_address')->set(array('is_default' => 0))->where('customer_id', '=', $customer_id)->execute();
                    DB::update('accounts_address')->set(array('is_default' => 1))->where('id', '=', $aid)->execute();
                }
                DB::update('accounts_address')->set($shipping_address)->where('id', '=', $aid)->execute();
                Message::set(__('address_modify_do_success'), 'success');
                echo '<script language="javascript">top.location.replace("'.BASEURL . $return . '");</script>';
                exit;
            }
        }
        $id = $this->request->param('id');
        $return_url = Arr::get($_GET, 'return_url', LANGPATH . '/customer/summary');
        if ($id)
            $address = DB::select()->from('accounts_address')->where('id', '=', $id)->execute()->current();
        else
            $address = array(
                'id' => 'new',
                'firstname' => '',
                'lastname' => '',
                'address' => '',
                'city' => '',
                'zip' => '',
                'state' => '',
                'country' => '',
                'phone' => '',
                'other_phone' => '',
            );
        $countries = Site::instance()->countries(LANGUAGE);
        echo View::factory('/address/ajax_edit')
            ->set('address', $address)
            ->set('countries', $countries)
            ->set('return_url', $return_url);
        exit;
    }

    public function action_newaddresslist(){
        $lang = Arr::get($_GET,'lang','');
        if(!$lang){
            $lang = 'en';
        }

        $addlanguage = kohana::config('address.'.$lang);

        $addres = '';
        $default_key = 0;
        $cart = Cart::get();
        $has_address = (isset($cart['shipping_address']) AND !empty($cart['shipping_address'])) ? 1 : 0;
        $customer_id = Customer::logged_in();
        $addresses = Customer::instance($customer_id)->addresses();
        if ($has_address)
        {
            if ($cart['shipping_address']['shipping_address_id'] == 'new')
            {
                foreach ($addresses as $key => $value)
                {
                    if ($value['id'] > $default_key)
                        $default_key = $key;
                }
            }
            else
            {
                foreach ($addresses as $key => $value)
                {
                    if ($value['is_default'])
                        $default_key = $key;
                }
            }
        }
        
          foreach($addresses as $key => $value)
            {
                
                     $sele = '';
                     $sele1 = $addlanguage[2];
                  if($cart['shipping_address']['shipping_address_id'] == $value['id'])
                    {
                        $temap_whereselected = "class='selected'";
                        $sele = 'class="address-option-selected"';
                        $sele1 = $addlanguage[1];
                    }else{
                        $temap_whereselected = "";
                    }
                    $temp_name = $value['firstname'].' '.$value['lastname'];
                    $temp_address = $value['address'].$value['city'].$value['state'].$value['country'].$value['zip'];


                $addres  .="<li class='mb20'>";
                $addres  .="<table class='shopping-table address-option-list' width='100%'>";
                $addres  .="<tr ".$sele."><td width='5%'>";
                $addres  .= "<span onclick=\"select_address('".$value['id']."')\" id=\"address_li_".$value['id']."\" ".$temap_whereselected."</span>";
                $addres  .=  "</td><td width='10%'>".$sele1."</td><td width='15%'>".$temp_name."</td><td width='45%'>".$temp_address."</td>";
                            if ($key == $default_key)
                            {
                                $addres .=  "<td width='10%' class='address-detault' id='detault_".$value['id']."'><a class='default'><i>".$addlanguage[3]."</i></a></td><td style='display:none;' width='10%' class='address-detault-a' id='address_detault_".$value['id']." >'";
                                $addres .="<a style='text-decoration:underline;'  href='javascript:;' onclick=\"default_address('".$value['id']."')\"><i>".$addlanguage[4]."</i></a></td>";
                            }
                            else
                            {
                $addres .="<td width='10%' class='address-detault-a' id='address_detault_".$value['id']."'><a style='text-decoration:underline;'  href='javascript:;' onclick=\"default_address('".$value['id']."')\"><i>".$addlanguage[4]."</i></a></td><td width='10%' class='address-detault' id='detault_".$value['id']."' style='display:none;'><a class='default'><i>".$addlanguage[3]."</i></a></td>";
                            }
                        $addres .="<td width='5%'>";
                        $addres .="<a style='text-decoration:underline;' data-reveal-id='myModal10-1' onclick=\"edit_address('".$value['id']."')\" href='javascript:;'><i>".$addlanguage[5]."</i></a></td>";
                        $addres .="<td width='10%'>";
                        $addres .="<a href='javascript:;' style='text-decoration:underline;' data-reveal-id='myModal6' onclick=\"delete_address('".$value['id']."')\"><i>".$addlanguage[6]."</i></a>";
                        $addres .="</td>";
                        $addres .="</tr>";
                        $addres .="</table>";
                        $addres .="</li>";
                
            }

            $addres .="<li><span><a class=\"a-underline js-add\" href=\"javascript:;\" id=\"add_new_address\" data-reveal-id=\"myModal10-1\" onclick=\"return new_address_show();\"><strong>".$addlanguage[7]."</strong></a></span></li>";

            echo json_encode($addres);
            exit;

    }
    //修改
    
    public function action_newaddresslist1(){
        $lang = Arr::get($_GET,'lang','');
        if(!$lang){
            $lang = 'en';
        }

        $addlanguage = kohana::config('address.'.$lang);

        $addres = '';
        $default_key = 0;
        $cart = Cart::get();
        $has_address = (isset($cart['shipping_address']) AND !empty($cart['shipping_address'])) ? 1 : 0;
        $customer_id = Customer::logged_in();
        $addresses = Customer::instance($customer_id)->addresses();
        
        if ($has_address)
        {
            if ($cart['shipping_address']['shipping_address_id'] == 'new')
            {
                foreach ($addresses as $key => $value)
                {
                    if ($value['id'] > $default_key)
                        $default_key = $key;
                }
            }
            else
            {
                foreach ($addresses as $key => $value)
                {
                    if ($value['is_default'])
                        $default_key = $key;
                }
            }
        }
          foreach($addresses as $key => $value)
            {
                
                $c =$key+1;
                $sele = '';
                  if($cart['shipping_address']['shipping_address_id'] == $value['id'])
                    {
                        $temap_whereselected = "class='selected'";
                        $sele = 'class="address-option-selected"';
                    }else{
                        $temap_whereselected = "";
                    } 
                    $temp_name = $value['firstname'].' '.$value['lastname'];
                    $temp_address = $value['address'].','.$value['city'].",".$value['state'].",".$value['country'].",".$value['zip'];


               
$addres  .="<li class='mb20' id=\"m_address_li_".$value['id']."\">";
                $addres  .="<table class='shopping-table address-option-list' width='100%'>";
                $addres  .="<tr ".$sele." onclick=\"select_address('".$value['id']."')\"><td width='15%''>";
                $addres  .= "<span ".$temap_whereselected."</span>";
                $addres  .=  "</td><td width='85%' style='text-align:left;'><p>".$addlanguage[8].   $c."</p><p>".$temp_name."</p>";
                $addres  .="<p>".$temp_address."</p>";
                $addres  .="<p>".$value['phone']."</p><p>";      
                        if ($key == $default_key)
                            {
                                $addres.="<a><i>".$addlanguage[3]."</i></a>";
                                }
                            else
                            {
                $addres .="<a style=\"text-decoration:underline;\"href=\"javascript:;\" id=\"address_detault_'".$value['id']."'\" onclick=\"default_address('".$value['id']."');\"><i>".$addlanguage[4]."</i></a>";
                            }
                $addres .="<a style=\"text-decoration:underline;\"data-reveal-id=\"myModal10-1\" onclick=\"edit_address('".$value['id']."', 1)\" href=\"javascript:;\"><i>".$addlanguage[5]."</i></a><a style=\"text-decoration:underline;\"data-reveal-id=\"myModal6\" onclick=\"delete_address('".$value['id']."');\" href=\"javascript:;\"><i>".$addlanguage[6]."</i></a></p>";
                $addres .="</td>";
                $addres .="</tr>";
                $addres .="</table>";
                $addres .="</li>";
                
            }
                $addres .="<li>";
                $addres .="<span><a class=\"a-underline js-add\" href=\"javascript:;\" id=\"add_new_address\" data-reveal-id=\"myModal10-1\" onclick=\"return new_address_show();\"><strong>".$addlanguage[7]."</strong></a></span>";
                $addres .="</li>";                            
            echo json_encode($addres);
            exit;

    }

    public function action_ajax_edit1()
    {
        if (!$customer_id = Customer::logged_in())
        {
            Message::set(__('address_modify_do_fail'));
            $this->request->redirect(LANGPATH . '/customer/summary');
        }
        if ($_POST)
        {
            //billing address default
            $c = Arr::get($_POST, 'billaddress', 0);
            $c1 = Arr::get($_POST, 'billaddress3', 0);

            $aid = Arr::get($_POST, 'address_id', 0);
            $return = Arr::get($_POST, 'return_url', LANGPATH . '/customer/summary');
            if (!isset($_POST['shipping_firstname']))
            {
                $data['success'] = 0;
                $data['message'] = __('address_modify_do_fail');
            }
            if (!$_POST['address'] OR !$_POST['city'] OR !$_POST['country'] OR !$_POST['zip'] OR !$_POST['phone'])
            {
                $data['success'] = 0;
                $data['message'] = __('address_modify_do_fail');
            }
            
            $is_cart = Arr::get($_POST, 'is_cart', 0);
            $is_checkout = Arr::get($_POST, 'is_checkout', 0);

            $count_address = DB::select(DB::expr('COUNT(id) AS count'))->from('accounts_address')->where('customer_id', '=', $customer_id)->execute()->get('count');
            $data['count_address'] = $count_address;

            if($is_cart != 2)
            {
                $address = array();
                // $address['site_id'] = $this->site_id;
                $address['customer_id'] = $customer_id;
                $address['firstname'] = Arr::get($_POST, 'firstname', '');
                $address['lastname'] = Arr::get($_POST, 'lastname', '');
                $address['address'] = Arr::get($_POST, 'address', '');
                $address['city'] = Arr::get($_POST, 'city', '');
                $address['state'] = Arr::get($_POST, 'state', '');
                $address['country'] = Arr::get($_POST, 'country', '');
                $address['zip'] = Arr::get($_POST, 'zip', '');
                $address['phone'] = Arr::get($_POST, 'phone', '');
                // $address['cpf'] = Arr::get($_POST, 'cpf', '');
                $address['is_default'] = Arr::get($_POST, 'is_default', 0);
                if ($aid == 'new' || $aid == '')
                {
                    if ($address['is_default'])
                        DB::update('accounts_address')->set(array('is_default' => 0))->where('customer_id', '=', $customer_id)->execute();
                    $result = DB::insert('accounts_address', array_keys($address))->values($address)->execute();
                    $aid = $result[0];
                    $data['success'] = 1;
                    $data['address_id'] = $aid;
                    $data['message'] = __('address_add_do_success');
                }
                elseif ($aid)
                {
                    if ($address['is_default'])
                    {
                        DB::update('accounts_address')->set(array('is_default' => 0))->where('customer_id', '=', $customer_id)->execute();
                        DB::update('accounts_address')->set(array('is_default' => 1))->where('id', '=', $aid)->execute();
                    }
                    DB::update('accounts_address')->set($address)->where('id', '=', $aid)->execute();
                    $data['success'] = 1;
                    $data['message'] = __('address_modify_do_success');
                }
            }

            $data['has_no_express'] = 0;
            if($is_cart == 1)
            {
                $shipping_address = array();
                $shipping_address['shipping_address_id'] = $aid;
                $shipping_address['shipping_firstname'] = Arr::get($_POST, 'firstname', '');
                $shipping_address['shipping_lastname'] = Arr::get($_POST, 'lastname', '');
                $shipping_address['shipping_address'] = Arr::get($_POST, 'address', '');
                $shipping_address['shipping_city'] = Arr::get($_POST, 'city', '');
                $shipping_address['shipping_state'] = Arr::get($_POST, 'state', '');
                $shipping_address['shipping_country'] = Arr::get($_POST, 'country', '');
                $shipping_address['shipping_zip'] = Arr::get($_POST, 'zip', '');
                $shipping_address['shipping_phone'] = Arr::get($_POST, 'phone', '');
                $shipping_address['shipping_cpf'] = Arr::get($_POST, 'cpf', '');
                Cart::shipping_billing($shipping_address);

                //billing address
                if($c || $c1){
                $billing = array();
                $billing['billing_firstname'] = Arr::get($_POST, 'firstname', '');
                $billing['billing_lastname'] = Arr::get($_POST, 'lastname', '');
                $billing['billing_address'] = Arr::get($_POST, 'address', '');
                $billing['billing_city'] = Arr::get($_POST, 'city', '');
                $billing['billing_state'] = Arr::get($_POST, 'state', '');
                $billing['billing_country'] = Arr::get($_POST, 'country', '');
                $billing['billing_zip'] = Arr::get($_POST, 'zip', '');
                $billing['billing_phone'] = Arr::get($_POST, 'phone', '');
                $billing['billing_cpf'] = Arr::get($_POST, 'cpf', '');
                Cart::billing_address($billing);               
                }

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
                    if($price['price'] == 0){
                        if($cart_extra['extra_flg']&&$cart_extra['extra_fee']>0){
                            $site_shipping[$key]['price']+=$cart_extra['extra_fee'];
                        }
					}elseif($tgift==2){
						$site_shipping[1]['price']=0;
                    }elseif($cart['amount']['items'] < 15 && $cart_extra['extra_fee']<=0 && !$cart_extra['extra_flg'])
                    {
                        $site_shipping[1]['price'] = 4.99;
                    }
                }
                $no_express_countries = kohana::config('shipment.no-express');
                if(in_array($shipping_address['shipping_country'], $no_express_countries))
                {
                    $shipping['price'] = $site_shipping[1]['price'];
                    Cart::shipping($shipping);
                    $data['has_no_express'] = 1;
                    $data['shipping_name'] = $site_shipping[1]['name'];
                    $data['shipping_price'] = Site::instance()->price($site_shipping[1]['price'], 'code_view');
                    $data['shipping_val'] = $site_shipping[1]['price'];
                    $cart = Cart::get();
                    if(Session::instance()->get('insurance') == -1){
                        $in = 0;
                    }else{
                        $in = 0.99;
                    }

                    $data['total_price'] = Site::instance()->price($cart['amount']['total'] + $in, 'code_view');
                }

                $no_standard_countries = kohana::config('shipment.no-standard');
                if(in_array($shipping_address['shipping_country'], $no_standard_countries) && $site_shipping[1]['price'] != 7)
                {
                    $shipping['price'] = $site_shipping[2]['price'];
                    Cart::shipping($shipping);
                    $data['has_no_express'] = 2;
                    $data['shipping_name'] = $site_shipping[2]['name'];
                    $data['shipping_price'] = Site::instance()->price($site_shipping[2]['price'], 'code_view');
                    $data['shipping_val'] = $site_shipping[2]['price'];
                    $cart = Cart::get();
                    if(Session::instance()->get('insurance') == -1){
                        $in = 0;
                    }else{
                        $in = 0.99;
                    }

                    $data['total_price'] = Site::instance()->price($cart['amount']['total'] + $in, 'code_view');
                }
            }
            elseif($is_cart == 2)
            {
                $billing = array();
                $billing['billing_firstname'] = Arr::get($_POST, 'firstname', '');
                $billing['billing_lastname'] = Arr::get($_POST, 'lastname', '');
                $billing['billing_address'] = Arr::get($_POST, 'address', '');
                $billing['billing_city'] = Arr::get($_POST, 'city', '');
                $billing['billing_state'] = Arr::get($_POST, 'state', '');
                $billing['billing_country'] = Arr::get($_POST, 'country', '');
                $billing['billing_zip'] = Arr::get($_POST, 'zip', '');
                $billing['billing_phone'] = Arr::get($_POST, 'phone', '');
                $billing['billing_cpf'] = Arr::get($_POST, 'cpf', '');
                Cart::billing_address($billing);
                $data['success'] = 1;
                $data['message'] = 'update billing address success';
            }

            if($is_checkout==1)
            {
                $error = 0;
                $customer_id = Customer::logged_in();
                $ordernum = Arr::get($_POST,'ordernum','');
                $order_customer = DB::select('customer_id')->from('orders_order')->where('ordernum','=',$ordernum)->execute()->current();
                if($customer_id != $order_customer['customer_id'])
                {
                    $error = 1;
                }
                $billing = array();
                $billing['billing_firstname'] = trim(Arr::get($_POST, 'firstname', ''));
                $billing['billing_lastname'] = trim(Arr::get($_POST, 'lastname', ''));
                $billing['billing_address'] = trim(Arr::get($_POST, 'address', ''));
                $billing['billing_city'] = trim(Arr::get($_POST, 'city', ''));
                $billing['billing_state'] = trim(Arr::get($_POST, 'state', ''));
                $billing['billing_country'] = trim(Arr::get($_POST, 'country', ''));
                $billing['billing_zip'] = trim(Arr::get($_POST, 'zip', ''));
                $billing['billing_phone'] = trim(Arr::get($_POST, 'phone', ''));
                $country = DB::select()->from('core_country')->where('isocode','=',$billing['billing_country'])->execute()->as_array();
                if(!$country)
                {
                    $error = 1;
                }
                if(!$error){
                    DB::update('orders_order')->set($billing)->where('ordernum','=',$ordernum)->execute();
                    $data['success'] = 1;
                    $data['message'] = 'update billing address success';
                    $data['address'] = $billing['billing_firstname'].' '.$billing['billing_lastname'].', '.$billing['billing_phone'].', '.$billing['billing_address'].' '.$billing['billing_city'].' '.$billing['billing_state'].' '.$billing['billing_country'].'<a href="javascript:;" data-reveal-id="myModal">Edit</a>';
                }else{
                    $data['success'] = 0;
                    $data['message'] = 'update billing address error';
                }


            }
            echo json_encode($data);
            exit;
        }
        $id = $this->request->param('id');
        $return_url = Arr::get($_GET, 'return_url', LANGPATH . '/customer/summary');
        if ($id)
            $address = DB::select()->from('accounts_address')->where('id', '=', $id)->execute()->current();
        else
            $address = array(
                'id' => 'new',
                'firstname' => '',
                'lastname' => '',
                'address' => '',
                'city' => '',
                'zip' => '',
                'state' => '',
                'country' => '',
                'phone' => '',
                'other_phone' => '',
            );
        $countries = Site::instance()->countries(LANGUAGE);
        echo View::factory('/address/ajax_edit')
            ->set('address', $address)
            ->set('countries', $countries)
            ->set('return_url', $return_url);
        exit;
    }

    public function action_ajax_delete()
    {
        if ($_POST)
        {
            if (!Customer::logged_in())
                exit();
            $address_id = Arr::get($_POST, 'address_id', 0);
            $return_url = Arr::get($_POST, 'return_url', LANGPATH . '/customer/summary');
            if ($address_id)
            {
                $customer_id = Customer::logged_in();
                DB::delete('accounts_address')->where('id', '=', $address_id)->and_where('customer_id', '=', $customer_id)->execute();
            }
        }
        $this->request->redirect($return_url);
    }

    public function action_ajax_delete1()
    {
        if ($_POST)
        {
            $data = array();
            if (!Customer::logged_in())
            {
                $data['success'] = 0;
                $data['message'] = __('need_log_in');
            }
            $address_id = Arr::get($_POST, 'id', 0);
            if ($address_id)
            {
                $customer_id = Customer::logged_in();
                $delete = DB::delete('accounts_address')->where('id', '=', $address_id)->and_where('customer_id', '=', $customer_id)->execute();
                if($delete)
                {
                    $data['success'] = 1;
                    $data['message'] = __('address_delete_success');
                }
                else
                {
                    $data['success'] = 0;
                    $data['message'] = __('address_delete_fail');
                }
            }
            else
            {
                $data['success'] = 0;
                $data['message'] = __('address_delete_fail');
            }
            echo json_encode($data);
            exit;
        }
    }

    public function action_ajax_data()
    {
        if ($_POST)
        {
            $id = Arr::get($_POST, 'id', 0);
            if (!$id)
            {
                echo json_encode(0);
            }
            else
            {
                $addresses = DB::select()->from('accounts_address')->where('id', '=', $id)->execute()->current();
                echo json_encode($addresses);
            }
            exit;
        }
    }

    public function action_set_default()
    {
        if ($_POST)
        {
            $customer_id = Customer::logged_in();
            if (!$customer_id)
            {
                Message::set(__('need_log_in'), 'notice');
                $this->request->redirect(LANGPATH . '/customer/login?redirect=/customer/address');
            }
            else
            {
                $address_id = (int) Arr::get($_POST, 'address_id', 0);
                $address_customer = DB::select('customer_id')->from('accounts_address')->where('id', '=', $address_id)->execute()->get('customer_id');
                if (!$address_customer)
                {
                    Message::set(__('address_modify_do_fail'), 'notice');
                    $this->request->redirect(LANGPATH . '/customer/address');
                }
                else
                {
                    DB::update('accounts_address')->set(array('is_default' => 0))->where('customer_id', '=', $customer_id)->execute();
                    DB::update('accounts_address')->set(array('is_default' => 1))->where('id', '=', $address_id)->execute();
                    Message::set(__('address_default_success'), 'success');
                    $this->request->redirect(LANGPATH . '/customer/address');
                }
            }
        }
        else
        {
            $id = $this->request->param('id');
            $customer_id = Customer::logged_in();
            if (!$customer_id)
            {
                Message::set(__('need_log_in'), 'notice');
                $this->request->redirect(LANGPATH . '/customer/login?redirect=/cart/shipping_billing');
            }
            else
            {
                $address_id = (int) $id;
                $address_customer = DB::select('customer_id')->from('accounts_address')->where('id', '=', $address_id)->execute()->get('customer_id');
                if (!$address_customer)
                {
                    Message::set(__('address_modify_do_fail'), 'notice');
                    $this->request->redirect(LANGPATH . '/cart/shipping_billing');
                }
                else
                {
                    $shipping = array(
                        'shipping_address_id' => $address_id,
                        'shipping_method' => 'HKPF',
                    );
                    Cart::shipping_billing($shipping);
                    DB::update('accounts_address')->set(array('is_default' => 0))->where('customer_id', '=', $customer_id)->execute();
                    DB::update('accounts_address')->set(array('is_default' => 1))->where('id', '=', $address_id)->execute();
                    Message::set(__('address_default_success'), 'success');
                    $this->request->redirect(LANGPATH . '/cart/shipping_billing');
                }
            }
        }
    }

    public function action_ajax_default()
    {
        if ($_POST)
        {
            $data = array();
            $customer_id = Customer::logged_in();
            if (!$customer_id)
            {
                $data['success'] = 0;
                $data['message'] = __('need_log_in');
            }
            else
            {
                $address_id = (int) Arr::get($_POST, 'id', 0);
                $address_customer = DB::select('customer_id')->from('accounts_address')->where('id', '=', $address_id)->execute()->get('customer_id');
                if (!$address_customer)
                {
                    $data['success'] = 0;
                    $data['message'] = __('address_modify_do_fail');
                }
                else
                {
                    DB::update('accounts_address')->set(array('is_default' => 0))->where('customer_id', '=', $customer_id)->execute();
                    DB::update('accounts_address')->set(array('is_default' => 1))->where('id', '=', $address_id)->execute();
                    $data['success'] = 1;
                    $data['message'] = __('address_default_success');
                }
            }
            echo json_encode($data);
            exit;
        }
    }

}

