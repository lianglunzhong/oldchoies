<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Payment extends Controller_Webpage
{
    public $merchantid = 1335;
    public $ocean_account = 160378;
    public $ocean_terminal = 16037801;
    public $ocean_secureCode = 'L8h8j2lb';
    public $ocean_account1 = 160378;
    public $ocean_terminal1 = 16037803;
    public $ocean_secureCode1 = 'R482N82B';


    //IPAY账户会员号
    public $partnerId = '10000004056';
//    public $partnerId = '10000008740';//联调

    /*
     * masapay config
     * */
    public $masapayPostUrl = 'https://mas.masapay.com/mas/receiveMerchantOrder.htm';
    public $masapayTestUrl = 'https://mas-sandbox.masapay.com/mas/receiveMerchantOrder.htm';

    public $masapayId = '801141756213001';
    public $masapayKey = '801141756213001choies2017';
//   //OC测试环境使用
//    public $ocean_account =  140105;
//    public $ocean_terminal = 14010501;
//    public $ocean_secureCode = '12345678';
    public function action_pay($ordernum = NULL)
    {
        $languages = Kohana::config('sites.language');
        if(in_array($ordernum, $languages))
        {
            $uri = $this->request->uri;
            $uris = explode('/', $uri);
            $ordernum = $uris[count($uris) - 1];
        }
        // if (Arr::get($_SERVER, 'COFREE_DOMAIN', URLSTR) == URLSTR AND Arr::get($_SERVER, 'HTTPS', 'off') != 'on')
        // {
        //     $type = isset($_GET['type']) ? '?type=' . $_GET['type'] : '';
        //     Request::Instance()->redirect(URL::site(Request::Instance()->uri . $type, 'https'));
        // }
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=cart/shipping_billing/' . $ordernum);
        }

        //create or update a order
        $order_id = Order::get_from_ordernum($ordernum);
        if (!$order_id)
        {
            Message::set(__('order_create_failed'), 'error');
            $this->request->redirect(LANGPATH . '/cart/view');
        }
        $order = Order::instance($order_id);
        if(!$order->get('is_active'))
        {
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
        
        switch ($order->get('payment_method'))
        {
            case 'CC':
                $amount = $order->get('payment_status') == 'partial_paid' ? $order->get('amount') - $order->get('amount_payment') : $order->get('amount');

                if (round((float) $amount, 2) < 0.01)
                {
                    $order->set(array(
                        'payment_status' => 'success',
                        'amount_payment' => 0,
                        'transaction_id' => 'point redeem',
                        'payment_date' => time(),
                    ));
                    Kohana_Log::instance()->add('SendMail', 'PAYSUCCESS');
                     Mail::SendTemplateMail('BLOGGER PAYSUCCESS', $mail_params['email'], $mail_params);
//                                        Message::set(__('order_create_success'), 'notice');
                    $this->request->redirect(LANGPATH . '/payment/success/' . $order->get('ordernum'));
                }
                $result = Payment::instance($order->get('payment_method'))->pay($order->get());
                switch ($result['status'])
                {
                    case 'SUCCESS':
                        $amount = $order->get('amount_products');
                        // if ($amount > 0)
                        // {
                        //     Event::run('Order.payment', array(
                        //         'amount' => $amount,
                        //         'order' => $order,
                        //     ));
                        // }
                        $customer = Customer::instance($order->get('customer_id'));
                        if ($customer)
                        {
                            $customer->order_total_inc($amount);
                        }
                        Message::set(__('order_pay_success'), 'notice');
                        $this->request->redirect(LANGPATH . '/payment/success/' . $order->get('ordernum'));
                        break;
                    case 'FAIL':
                        Message::set($result['message'], 'error');
                        $this->request->redirect(LANGPATH . '/cart/shipping_billing/' . $order->get('ordernum'));
                        break;
                    case 'PENDING':
                        Message::set($result['message'], 'notice');
                        $this->request->redirect(LANGPATH . '/payment/success/' . $order->get('ordernum'));
                        break;
                    default:
                        break;
                }
                break;

            case 'PP':
                $amount = $order->get('payment_status') == 'partial_paid' ? $order->get('amount') - $order->get('amount_payment') : $order->get('amount');

                $isgift = 1;
                if($order->get('amount_products') >0){
                    $isgift = 0;
                }

                if (round((float) $amount, 2) < 0.01)
                {
					$mail_params = array();
					$mail_params['order_num'] = $order->get('ordernum');
					$mail_params['email'] = Customer::instance($order->get('customer_id'))->get('email');
					$mail_params['firstname'] = Customer::instance($order->get('customer_id'))->get('firstname');
					if(!$mail_params['firstname'])
						$mail_params['firstname'] = 'customer';
					$mail_params['created'] = date('Y-m-d H:i', $order->get('created'));
					$currency = Site::instance()->currencies($order->get('currency'));
					$mail_params['currency'] = $order->get('currency');
					$mail_params['amount'] = round($order->get('amount'),2);
					$mail_params['points'] = round($order->get('points'),2);
					
					$mail_params['order_product'] = 
					'<table border="0" width="92%" style="color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; cursor: text;">
						<tbody>
							<tr align="left">
								<td colspan="5"><strong>Product Details</strong></td>
							</tr>';
					$customer_id = $order->get('customer_id');
					$celebrity_id = Customer::instance($customer_id)->is_celebrity();
					$order_products = Order::instance($order->get('id'))->products();
					$currency = Site::instance()->currencies($order->get('currency'));
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
                    $order->set(array(
                        'payment_status' => 'success',
                        'amount_payment' => 0,
                        'transaction_id' => 'point redeem',
                        'payment_date' => time(),
                    ));
					Kohana_Log::instance()->add('SendMail', 'PAYSUCCESS');
                    Mail::SendTemplateMail('BLOGGER PAYSUCCESS', $mail_params['email'], $mail_params);
                    $this->request->redirect(LANGPATH . '/payment/success/' . $ordernum);
                }
                $config['return_url'] = BASEURL . LANGPATH . '/payment/success/' . $ordernum;

                if($isgift){
                $this->template = View::factory('/payment')
                     ->set('paypal_form', Payment::instance($order->get('payment_method'))->form('', 'auto', $order->get(), $config))
                    ->set('ordernum', $ordernum)->set('order', $order)->set('isgift',$isgift);
                }else{
                $this->template = View::factory('/payment')->set('ordernum', $ordernum)->set('order', $order)->set('isgift',$isgift);
                }
                // $this->request->redirect(LANGPATH . '/payment/ppec_set1/' . $ordernum);
                break;

             //   $this->template = View::factory('/payment')
                    // ->set('paypal_form', Payment::instance($order->get('payment_method'))->form('', 'auto', $order->get(), $config))
                //    ->set('ordernum', $ordernum)->set('order', $order);
                // $this->request->redirect(LANGPATH . '/payment/ppec_set1/' . $ordernum);
             //   break;

            case 'GLOBEBILL':
                $amount = $order->get('payment_status') == 'partial_paid' ? $order->get('amount') - $order->get('amount_payment') : $order->get('amount');

                if (round((float) $amount, 2) < 0.01)
                {
                    $order->set(array(
                        'payment_status' => 'success',
                        'amount_payment' => 0,
                        'transaction_id' => 'point redeem',
                        'payment_date' => time(),
                    ));

                    // Product stock Minus
                    $products = unserialize($order->get('products'));
                    foreach ($products as $product)
                    {
                        $stock = Product::instance($product['id'])->get('stock');
                        if ($stock != -99 AND $stock > 0)
                        {
                            DB::update('products')->set(array('stock' => $stock - $product['quantity']))->where('id', '=', $product['id'])->execute();
                        }
                    }

                    Message::set(__('order_create_success'), 'notice');
                    $this->request->redirect(LANGPATH . '/payment/success/' . $order->get('ordernum'));
                }
                if (Site::instance()->get('is_pay_insite'))
                {
                    $this->request->redirect(LANGPATH . '/payment/pay_insite/' . $order->get('ordernum'));
                }
                echo Payment::instance("GLOBEBILL")->jump($order->get());
                exit("<div>It's turning to secure payment page...<br/><a href='javascript:void(0);' onclick='document.form2.submit();'>Click here if your browser does not automatically redirect you.</a>.</div>");
                break;
        }
    }

    public function action_gc_pay($ordernum)
    {
        if(!is_numeric($ordernum))
        {
            $uri = $this->request->uri();
            $uris = explode('/', $uri);
            $ordernum = $uris[count($uris) - 1];
        }
        if (!$ordernum)
        {
            $this->request->redirect(LANGPATH . '/');
        }

        $this->request->redirect(LANGPATH . '/payment/ocean_pay/'.$ordernum);
        if (Arr::get($_SERVER, 'COFREE_DOMAIN', URLSTR) == URLSTR AND Arr::get($_SERVER, 'HTTPS', 'off') != 'on')
        {
            $type = isset($_GET['type']) ? '?type=' . $_GET['type'] : '';
            Request::Instance()->redirect(URL::site(Request::Instance()->uri . $type, 'https'));
        }
        if(!is_numeric($ordernum))
        {
            $uri = $this->request->uri();
            $uris = explode('/', $uri);
            $ordernum = $uris[count($uris) - 1];
        }
        if (!$ordernum)
        {
            $this->request->redirect(LANGPATH . '/');
        }
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
        $order = Order::instance(Order::get_from_ordernum($ordernum));
        $order_info = $order->get();
        if(!$order_info['is_active'])
        {
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
        if($order_info['payment_status'] == 'success' OR $order_info['payment_status'] == 'verify_pass')
        {
            $this->request->redirect(LANGPATH . '/payment/success/' . $ordernum);
        }
        if($order_info['payment_status'] == 'pending')
        {
            Message::set(__('payment_pending'), 'notice');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
        if ($order_info['customer_id'] != $customer_id)
            $this->request->redirect(LANGPATH . '/404');

        if($_POST)
        {
            Site::instance()->add_clicks('card_pay');
            date_default_timezone_set ('Asia/Shanghai');
            $orderNo = trim($order_info['ordernum']);
            $orderCurrency = trim($order_info['currency']);
            $orderAmount = round($order_info['amount'], 2);
            $cardNo = Arr::get($_POST, 'cardNo', 0);
            if(strlen($cardNo) < 12)
            {
                Message::set(__('card_no_invalid'), 'error');
                $this->request->redirect(LANGPATH . '/payment/gc_pay/' . $ordernum);
            }
            $cardExpireMonth = Arr::get($_POST, 'cardExpireMonth', 0);
            if(strlen($cardExpireMonth) > 2)
            {
                $cardExpireMonth = substr($cardExpireMonth, 2);
            }
            $cardExpireYear = Arr::get($_POST, 'cardExpireYear', 0);
            if(strlen($cardExpireYear) > 2)
            {
                $cardExpireYear = substr($cardExpireYear, 2);
            }
            if(!$cardExpireMonth OR !$cardExpireYear)
            {
                Message::set(__('expiration_date_invalid'), 'error');
                $this->request->redirect(LANGPATH . '/payment/gc_pay/' . $ordernum);
            }
            $cardSecurityCode = Arr::get($_POST, 'cardSecurityCode', 0);
            $issuingBank = 'bank';
            $firstName = trim($order_info['shipping_firstname']);
            if(strlen($firstName) > 15)
            {
                $firstName = substr($firstName, 0, 14);
            }
            $lastName = trim($order_info['shipping_lastname']);
            if(strlen($lastName) > 35)
            {
                $lastName = substr($lastName, 0, 34);
            }
            $email = trim($order_info['email']);
            if(strlen($email) > 70)
            {
                $email = substr($email, 0, 69);
            }
            $ip = long2ip($order_info['ip']);
            $phone = trim($order_info['shipping_phone']);
            if(strlen($phone) > 15)
            {
                $phone = substr($phone, 0, 14);
            }
            $paymentMethod = 'Credit Card';
            $country_replace = array('CAN', 'CHI', 'KO', 'XG');
            $replace_to = array('ES', 'US', 'RS', 'ES');
            $country = trim($order_info['shipping_country']);
            $country = str_replace($country_replace, $replace_to, $country);
            $state = trim($order_info['shipping_state']);
            if(strlen($state) > 35)
            {
                $state = substr($state, 0, 34);
            }
            $city = trim($order_info['shipping_city']);
            if(strlen($city) > 40)
            {
                $city = substr($city, 0, 39);
            }
            $address = trim($order_info['shipping_address']);
            $address = preg_replace('/[^A-Za-z0-9_]/', ' ', $address);
            if(strlen($address) > 50)
            {
                $address = substr($address, 0, 49);
            }
            $zip = trim($order_info['shipping_zip']);
            if(strlen($zip) > 10)
            {
                $zip = substr($zip, 0, 9);
            }
            $remark = 'remark';
            $customerID = $order_info['customer_id'];

            //Card Type 1:Visa,3:Master,114:Visa Debit,119:Master Debit,122:Visa Electron
            $card_type = Arr::get($_POST, 'card_type', 1);

            $correct_url = 'HTTPS://ps.gcsip.com/wdl/wdl';
            // $correct_url = 'HTTPS://ps.gcsip.nl/wdl/wdl'; //test url
            $language = LANGUAGE ? LANGUAGE : 'en';
            $amount = (int) ($orderAmount * 100);
            $params=array(
                'REQUEST' => array(
                    'ACTION' => 'INSERT_ORDERWITHPAYMENT',
                    'META' => array(
                        'MERCHANTID' => $this->merchantid,
                        // 'IPADDRESS' => '205.234.213.129',
                        'IPADDRESS' => $ip,
                        'VERSION' => '2.0',
                    ),
                    'PARAMS' => array(
                        'ORDER' => array(
                            'ORDERID' => $order_info['id'],
                            'AMOUNT' => $amount,
                            'CURRENCYCODE' => $orderCurrency,
                            'LANGUAGECODE' => $language,
                            'FIRSTNAME' => $firstName,
                            'SURNAME' => $lastName,
                            'EMAIL' => $email,
                            'HOUSENUMBER' => $phone,
                            'COUNTRYCODE' => $country,
                            'STATE' => $state,
                            'CITY' => $city,
                            'STREET' => $address,
                            'ZIP' => $zip,
                            'MERCHANTREFERENCE' => $ordernum . '-' . time(),
                        ),
                        'PAYMENT' => array(
                            'CREDITCARDNUMBER'=>$cardNo,
                            'EXPIRYDATE' => $cardExpireMonth . $cardExpireYear,
                            'CVV' => $cardSecurityCode,
                            'PAYMENTPRODUCTID' => $card_type,
                            'AMOUNT' => $amount,
                            'CURRENCYCODE' => $orderCurrency,
                            'LANGUAGECODE' => $language,
                            'COUNTRYCODE' => $country,
                        ),
                    ),
                ),
            );
            $xml_data = $this->array2xml($params);
            $ch = curl_init();

            $header[] = "Content-type: text/xml";//定义content-type为xml
            curl_setopt($ch, CURLOPT_URL, $correct_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
            $response = curl_exec($ch);
            if(curl_errno($ch))
            {
                print curl_error($ch);
            }
            curl_close($ch);

            $result_data = @simplexml_load_string($response,NULL,LIBXML_NOCDATA);
            $return_data = json_decode(json_encode($result_data),true);
            // print_r($return_data); exit;
            if(empty($return_data['REQUEST']))
            {
                kohana_log::instance()->add('GC_NO_RETURN', $ordernum . '-' . json_encode($params));
            }
            $this->gc_return($return_data['REQUEST']);
            exit;
        }

        // $str = '{"ACTION":"INSERT_ORDERWITHPAYMENT","META":{"MERCHANTID":"7560","IPADDRESS":"221.226.84.170","VERSION":"2.0","REQUESTIPADDRESS":"46.16.252.133"},"PARAMS":{"ORDER":{"ORDERID":"127293","AMOUNT":"10","CURRENCYCODE":"USD","LANGUAGECODE":"en","FIRSTNAME":"Luca","SURNAME":"Mim","EMAIL":"shijiangming09@163.com","HOUSENUMBER":"(647)-459-5822","COUNTRYCODE":"CA","STATE":"Ontario","CITY":"wuxi1","STREET":"asdfasf asf asdaf","ZIP":"08650","MERCHANTREFERENCE":"11831161340-1410848681"},"PAYMENT":{"CREDITCARDNUMBER":"4392250036768082","EXPIRYDATE":"0515","CVV":"159","PAYMENTPRODUCTID":"1","AMOUNT":"10","CURRENCYCODE":"USD","LANGUAGECODE":"en","COUNTRYCODE":"CA"}},"RESPONSE":{"RESULT":"OK","META":{"REQUESTID":"9908206","RESPONSEDATETIME":"20140916082243"},"ROW":{"STATUSDATE":"20140916082242","FRAUDRESULT":"C","AUTHORISATIONCODE":"789143","PAYMENTREFERENCE":"0","ADDITIONALREFERENCE":"M11272931340-14108486","ORDERID":"127293","EXTERNALREFERENCE":"11830721340-1410848681","FRAUDCODE":"0330","EFFORTID":"1","CVVRESULT":"M","ATTEMPTID":"1","MERCHANTID":"7560","STATUSID":"525"}}}';
        // $request = json_decode($str);
        // $this->gc_return1($request);
        // exit;

        $this->template->type = 'purchase';
        $this->template->content = View::factory('/payment_gc1')
            ->set('order', $order_info);
    }

    public function action_sofort_pay($ordernum)
    {
        if (Arr::get($_SERVER, 'COFREE_DOMAIN', URLSTR) == URLSTR AND Arr::get($_SERVER, 'HTTPS', 'off') != 'on')
        {
            $type = isset($_GET['type']) ? '?type=' . $_GET['type'] : '';
            Request::Instance()->redirect(URL::site(Request::Instance()->uri . $type, 'https'));
        }
        if(!is_numeric($ordernum))
        {
            $uri = $this->request->uri();
            $uris = explode('/', $uri);
            $ordernum = $uris[count($uris) - 1];
        }
        if (!$ordernum)
        {
            $this->request->redirect(LANGPATH . '/');
        }
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
        $order = Order::instance(Order::get_from_ordernum($ordernum));
        $order_info = $order->get();
        if(!$order_info['is_active'])
        {
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
        if($order_info['payment_status'] == 'success' OR $order_info['payment_status'] == 'verify_pass')
        {
            $this->request->redirect(LANGPATH . '/payment/success/' . $ordernum);
        }
        if($order_info['payment_status'] == 'pending')
        {
            Message::set(__('payment_pending'), 'notice');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
        if ($order_info['customer_id'] != $customer_id)
            $this->request->redirect(LANGPATH . '/404');

        $country_replace = array('CAN', 'CHI', 'KO', 'XG');
        $replace_to = array('ES', 'US', 'RS', 'ES');
        $country = trim($order_info['shipping_country']);
        $country = str_replace($country_replace, $replace_to, $country);
        $sofort_countries = array(
            'DE' => 'EUR', 'AT' => 'EUR', 'CH' => 'CHF', 'BE' => 'EUR', 'FR' => 'EUR',
            'IT' => 'EUR', 'GB' => 'GBP', 'ES' => 'EUR', 'NL' => 'EUR', 'PL' => 'EUR',
        );
        if(!array_key_exists($country, $sofort_countries))
        {
            Message::set('Country Code Error', 'error');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
        else
        {
            $sofort_currency = $sofort_countries[$country];
        }

        date_default_timezone_set ('Asia/Shanghai');
        $orderNo = trim($order_info['ordernum']);
        $orderCurrency = trim($order_info['currency']);
        $orderAmount = round($order_info['amount'], 2);
        if($orderCurrency != $sofort_currency)
        {
            $orderCurrency = $sofort_currency;
            $currency = Site::instance()->currencies($order_info['currency']);
            $currency1 = Site::instance()->currencies($orderCurrency);
            $orderAmount = round($orderAmount / $currency['rate'] * $currency1['rate'], 2);
        }
        $firstName = trim($order_info['shipping_firstname']);
        if(strlen($firstName) > 15)
        {
            $firstName = substr($firstName, 0, 14);
        }
        $lastName = trim($order_info['shipping_lastname']);
        if(strlen($lastName) > 35)
        {
            $lastName = substr($lastName, 0, 34);
        }
        $email = trim($order_info['email']);
        if(strlen($email) > 70)
        {
            $email = substr($email, 0, 69);
        }
        $ip = long2ip($order_info['ip']);
        $phone = trim($order_info['shipping_phone']);
        if(strlen($phone) > 15)
        {
            $phone = substr($phone, 0, 14);
        }
        $state = trim($order_info['shipping_state']);
        if(strlen($state) > 35)
        {
            $state = substr($state, 0, 34);
        }
        $city = trim($order_info['shipping_city']);
        if(strlen($city) > 40)
        {
            $city = substr($city, 0, 39);
        }
        $address = trim($order_info['shipping_address']);
        if(strlen($address) > 50)
        {
            $address = substr($address, 0, 49);
        }
        $zip = trim($order_info['shipping_zip']);
        if(strlen($zip) > 10)
        {
            $zip = substr($zip, 0, 9);
        }
        $language = LANGUAGE ? LANGUAGE : 'en';
        $amount = (int) ($orderAmount);

        $pmethod = $order->get('payment_method');
        $paytype = array("SOFORT","IDEAL");
        if(in_array($pmethod, $paytype))
        {
            $pmethod = 'OC';
        }



        $config = array(
                'sofort_backUrl' => BASEURL . LANGPATH . '/payment/success/' . $ordernum,
                'sofort_noticeUrl' => BASEURL . '/payment/sofort_return',
                'account' => $this->ocean_account1,
                'terminal' => $this->ocean_terminal1,
                'oc_payment_url' => 'https://secure.oceanpayment.com/gateway/service/pay',
                'methods' => 'Directpay',
            );

        //去除空格
        $order_info['shipping_firstname'] = trim($order_info['shipping_firstname']);
        $order_info['shipping_lastname'] = trim($order_info['shipping_lastname']);

        //转义
        $find = array("'","\"",'>','<');
        $replace = array("&#039;","&quot;","&gt;","&lt;");
        $order_info['shipping_firstname'] = str_replace($find, $replace, $order_info['shipping_firstname']);
        $order_info['shipping_lastname'] = str_replace($find, $replace, $order_info['shipping_lastname']);

        $config['signValue'] = $this->stringtoshasipay($order_info,$config);

        DB::update('orders_order')->set(array('payment_method' => 'SOFORT'))->where('id', '=', $order_info['id'])->execute();

        $isgift = 1;
        $this->template = View::factory('/payment')
             ->set('paypal_form', Payment::instance($pmethod)->form('', '', $order_info, $config))
            ->set('ordernum', $ordernum)->set('order', $order)->set('isgift',$isgift);;

    }

    public function action_ideal_pay($ordernum)
    {
        if (Arr::get($_SERVER, 'COFREE_DOMAIN', URLSTR) == URLSTR AND Arr::get($_SERVER, 'HTTPS', 'off') != 'on')
        {
            $type = isset($_GET['type']) ? '?type=' . $_GET['type'] : '';
            Request::Instance()->redirect(URL::site(Request::Instance()->uri . $type, 'https'));
        }
        if(!is_numeric($ordernum))
        {
            $uri = $this->request->uri();
            $uris = explode('/', $uri);
            $ordernum = $uris[count($uris) - 1];
        }
        if (!$ordernum)
        {
            $this->request->redirect(LANGPATH . '/');
        }
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
        $order = Order::instance(Order::get_from_ordernum($ordernum));
        $order_info = $order->get();
        if(!$order_info['is_active'])
        {
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
        if($order_info['payment_status'] == 'success' OR $order_info['payment_status'] == 'verify_pass')
        {
            $this->request->redirect(LANGPATH . '/payment/success/' . $ordernum);
        }
        if($order_info['payment_status'] == 'pending')
        {
            Message::set(__('payment_pending'), 'notice');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
        if ($order_info['customer_id'] != $customer_id)
            $this->request->redirect(LANGPATH . '/404');

        $country_replace = array('CAN', 'CHI', 'KO', 'XG');
        $replace_to = array('ES', 'US', 'RS', 'ES');
        $country = trim($order_info['shipping_country']);
        $country = str_replace($country_replace, $replace_to, $country);
        $sofort_countries = array(
            'NL' => 'EUR',
        );
        if(!array_key_exists($country, $sofort_countries))
        {
            Message::set('Country Code Error', 'error');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
        else
        {
            $sofort_currency = $sofort_countries[$country];
        }

        date_default_timezone_set ('Asia/Shanghai');
        $orderNo = trim($order_info['ordernum']);
        $orderCurrency = trim($order_info['currency']);
        $orderAmount = round($order_info['amount'], 2);
        if($orderCurrency != $sofort_currency)
        {
            $orderCurrency = $sofort_currency;
            $currency = Site::instance()->currencies($order_info['currency']);
            $currency1 = Site::instance()->currencies($orderCurrency);
            $orderAmount = round($orderAmount / $currency['rate'] * $currency1['rate'], 2);
        }
        $firstName = trim($order_info['shipping_firstname']);
        if(strlen($firstName) > 15)
        {
            $firstName = substr($firstName, 0, 14);
        }
        $lastName = trim($order_info['shipping_lastname']);
        if(strlen($lastName) > 35)
        {
            $lastName = substr($lastName, 0, 34);
        }
        $email = trim($order_info['email']);
        if(strlen($email) > 70)
        {
            $email = substr($email, 0, 69);
        }
        $ip = long2ip($order_info['ip']);
        $phone = trim($order_info['shipping_phone']);
        if(strlen($phone) > 15)
        {
            $phone = substr($phone, 0, 14);
        }
        $state = trim($order_info['shipping_state']);
        if(strlen($state) > 35)
        {
            $state = substr($state, 0, 34);
        }
        $city = trim($order_info['shipping_city']);
        if(strlen($city) > 40)
        {
            $city = substr($city, 0, 39);
        }
        $address = trim($order_info['shipping_address']);
        if(strlen($address) > 50)
        {
            $address = substr($address, 0, 49);
        }
        $zip = trim($order_info['shipping_zip']);
        if(strlen($zip) > 10)
        {
            $zip = substr($zip, 0, 9);
        }
        $language = LANGUAGE ? LANGUAGE : 'en';
        $amount = (int) ($orderAmount);

        $pmethod = $order->get('payment_method');
        $paytype = array("SOFORT","IDEAL");
        if(in_array($pmethod, $paytype))
        {
            $pmethod = 'OC';
        }

        $config = array(
                'sofort_backUrl' => BASEURL . LANGPATH . '/payment/success/' . $ordernum,
                'sofort_noticeUrl' => BASEURL . '/payment/ideal_return',
                'account' => $this->ocean_account1,
                'terminal' => $this->ocean_terminal1,
                'oc_payment_url' => 'https://secure.oceanpayment.com/gateway/service/pay',
                'methods' => 'iDEAL',
            );

        //去除空格
        $order_info['shipping_firstname'] = trim($order_info['shipping_firstname']);
        $order_info['shipping_lastname'] = trim($order_info['shipping_lastname']);

        //转义
        $find = array("'","\"",'>','<');
        $replace = array("&#039;","&quot;","&gt;","&lt;");
        $order_info['shipping_firstname'] = str_replace($find, $replace, $order_info['shipping_firstname']);
        $order_info['shipping_lastname'] = str_replace($find, $replace, $order_info['shipping_lastname']);

        $config['signValue'] = $this->stringtoshasipay($order_info,$config);

        DB::update('orders_order')->set(array('payment_method' => 'IDEAL'))->where('id', '=', $order_info['id'])->execute();

        $isgift = 1;
        $this->template = View::factory('/payment')
             ->set('paypal_form', Payment::instance($pmethod)->form('', '', $order_info, $config))
            ->set('ordernum', $ordernum)->set('order', $order)->set('isgift',$isgift);

    }

    public function action_qiwi_pay($ordernum)
    {
        if (Arr::get($_SERVER, 'COFREE_DOMAIN', URLSTR) == URLSTR AND Arr::get($_SERVER, 'HTTPS', 'off') != 'on')
        {
            $type = isset($_GET['type']) ? '?type=' . $_GET['type'] : '';
            Request::Instance()->redirect(URL::site(Request::Instance()->uri . $type, 'https'));
        }
        if(!is_numeric($ordernum))
        {
            $uri = $this->request->uri();
            $uris = explode('/', $uri);
            $ordernum = $uris[count($uris) - 1];
        }
        if (!$ordernum)
        {
            $this->request->redirect(LANGPATH . '/');
        }
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
        $order = Order::instance(Order::get_from_ordernum($ordernum));
        $order_info = $order->get();
        if(!$order_info['is_active'])
        {
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
        if($order_info['payment_status'] == 'success' OR $order_info['payment_status'] == 'verify_pass')
        {
            $this->request->redirect(LANGPATH . '/payment/success/' . $ordernum);
        }
        if($order_info['payment_status'] == 'pending')
        {
            Message::set(__('payment_pending'), 'notice');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
        if ($order_info['customer_id'] != $customer_id)
            $this->request->redirect(LANGPATH . '/404');

        $country_replace = array('CAN', 'CHI', 'KO', 'XG');
        $replace_to = array('ES', 'US', 'RS', 'ES');
        $country = trim($order_info['shipping_country']);
        $country = str_replace($country_replace, $replace_to, $country);
        $qiwi_countries = array(
            'RU' => 'RUB',
        );
        if(!array_key_exists($country, $qiwi_countries))
        {
            Message::set('Country Code Error', 'error');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
        else
        {
            $qiwi_currency = $qiwi_countries[$country];
        }

        date_default_timezone_set ('Asia/Shanghai');
        $orderNo = trim($order_info['ordernum']);
        $orderCurrency = trim($order_info['currency']);
        $orderAmount = round($order_info['amount'], 2);
        if($orderCurrency != $qiwi_currency)
        {
            $orderCurrency = $qiwi_currency;
            $currency = Site::instance()->currencies($order_info['currency']);
            $currency1 = Site::instance()->currencies($orderCurrency);
            $orderAmount = round($orderAmount / $currency['rate'] * $currency1['rate'], 2);
        }
        $firstName = trim($order_info['shipping_firstname']);
        if(strlen($firstName) > 15)
        {
            $firstName = substr($firstName, 0, 14);
        }
        $lastName = trim($order_info['shipping_lastname']);
        if(strlen($lastName) > 35)
        {
            $lastName = substr($lastName, 0, 34);
        }
        $email = trim($order_info['email']);
        if(strlen($email) > 70)
        {
            $email = substr($email, 0, 69);
        }
        $ip = long2ip($order_info['ip']);
        $phone = trim($order_info['shipping_phone']);
        if(strlen($phone) > 15)
        {
            $phone = substr($phone, 0, 14);
        }
        $state = trim($order_info['shipping_state']);
        if(strlen($state) > 35)
        {
            $state = substr($state, 0, 34);
        }
        $city = trim($order_info['shipping_city']);
        if(strlen($city) > 40)
        {
            $city = substr($city, 0, 39);
        }
        $address = trim($order_info['shipping_address']);
        if(strlen($address) > 50)
        {
            $address = substr($address, 0, 49);
        }
        $zip = trim($order_info['shipping_zip']);
        if(strlen($zip) > 10)
        {
            $zip = substr($zip, 0, 9);
        }
        $language = LANGUAGE ? LANGUAGE : 'en';
        $amount = (int) ($orderAmount * 100);

        $params = array(
            'REQUEST' => array(
                'ACTION' => 'INSERT_ORDERWITHPAYMENT',
                'META' => array(
                    'MERCHANTID' => $this->merchantid,
                    // 'IPADDRESS' => '205.234.213.129',
                    'IPADDRESS' => $ip,
                    'VERSION' => '2.0',
                ),
                'PARAMS' => array(
                    'ORDER' => array(
                        'ORDERID' => $order_info['id'],
                        'AMOUNT' => $amount,
                        'CURRENCYCODE' => $orderCurrency,
                        'LANGUAGECODE' => $language,
                        'FIRSTNAME' => $firstName,
                        'SURNAME' => $lastName,
                        'EMAIL' => $email,
                        'HOUSENUMBER' => $phone,
                        'COUNTRYCODE' => $country,
                        'STATE' => $state,
                        'CITY' => $city,
                        'STREET' => $address,
                        'ZIP' => $zip,
                        'MERCHANTREFERENCE' => $ordernum . '-' . time(),
                    ),
                    'PAYMENT' => array(
                        'PAYMENTPRODUCTID' => 8580,
                        'AMOUNT' => $amount,
                        'CURRENCYCODE' => $orderCurrency,
                        'LANGUAGECODE' => $language,
                        'COUNTRYCODE' => $country,
                        'HOSTEDINDICATOR' => 1,
                        'RETURNURL' => BASEURL . '/payment/qiwi_return',
                    ),
                ),
            ),
        );
        $correct_url = 'HTTPS://ps.gcsip.com/wdl/wdl';
        // $correct_url = 'HTTPS://ps.gcsip.nl/wdl/wdl'; //test url
        $xml_data = $this->array2xml($params);
        // echo $xml_data;exit;
        $ch = curl_init();

        $header[] = "Content-type: text/xml";//定义content-type为xml
        curl_setopt($ch, CURLOPT_URL, $correct_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        $response = curl_exec($ch);

        if(curl_errno($ch))
        {
            print curl_error($ch);
        }
        curl_close($ch);
        $result_data = @simplexml_load_string($response,NULL,LIBXML_NOCDATA);
        $return_data = json_decode(json_encode($result_data),true);
        $request = $return_data['REQUEST'];
        $result = $request['RESPONSE'];
        if($result['RESULT'] == 'OK')
        {
            $ref = $result['ROW']['REF'];
            DB::update('orders_order')->set(array('referrer' => $ref))->where('id', '=', $order_info['id'])->execute();
            $url = $result['ROW']['FORMACTION'];
            $this->request->redirect($url);
        }
        else
        {
            Kohana_log::instance()->add('QiWi Response', json_encode($result_data));
            $error = $result['ERROR'];
            if(isset($error[0]))
            {
                $message = $error[0]['MESSAGE'];
            }
            else
            {
                $message = $error['MESSAGE'];
            }
            Message::set($message, 'error');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
    }

    public function action_webmoney_pay($ordernum)
    {

        if (Arr::get($_SERVER, 'COFREE_DOMAIN', URLSTR) == URLSTR AND Arr::get($_SERVER, 'HTTPS', 'off') != 'on')
        {
            $type = isset($_GET['type']) ? '?type=' . $_GET['type'] : '';
            Request::Instance()->redirect(URL::site(Request::Instance()->uri . $type, 'https'));
        }
        if(!is_numeric($ordernum))
        {
            $uri = $this->request->uri();
            $uris = explode('/', $uri);
            $ordernum = $uris[count($uris) - 1];
        }
        if (!$ordernum)
        {
            $this->request->redirect(LANGPATH . '/');
        }
        if (!($customer_id = Customer::logged_in()))
        {

            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
        $order = Order::instance(Order::get_from_ordernum($ordernum));
        $order_info = $order->get();
        if(!$order_info['is_active'])
        {
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
        if($order_info['payment_status'] == 'success' OR $order_info['payment_status'] == 'verify_pass')
        {
            $this->request->redirect(LANGPATH . '/payment/success/' . $ordernum);
        }
        if($order_info['payment_status'] == 'pending')
        {
            Message::set(__('payment_pending'), 'notice');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
        if ($order_info['customer_id'] != $customer_id)
            $this->request->redirect(LANGPATH . '/404');

        $country_replace = array('CAN', 'CHI', 'KO', 'XG');
        $replace_to = array('ES', 'US', 'RS', 'ES');
        $country = trim($order_info['shipping_country']);
        $country = str_replace($country_replace, $replace_to, $country);
        $webmoney_countries = array(
            'RU' => 'RUB',
        );
        if(!array_key_exists($country, $webmoney_countries))
        {
            Message::set('Country Code Error', 'error');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
        else
        {
            $webmoney_currency = $webmoney_countries[$country];
        }

        date_default_timezone_set ('Asia/Shanghai');
        $orderNo = trim($order_info['ordernum']);
        $orderCurrency = trim($order_info['currency']);
        $orderAmount = round($order_info['amount'], 2);
        if($orderCurrency != $webmoney_currency)
        {
            $orderCurrency = $webmoney_currency;
            $currency = Site::instance()->currencies($order_info['currency']);
            $currency1 = Site::instance()->currencies($orderCurrency);
            $orderAmount = round($orderAmount / $currency['rate'] * $currency1['rate'], 2);
        }
        $firstName = trim($order_info['shipping_firstname']);
        if(strlen($firstName) > 15)
        {
            $firstName = substr($firstName, 0, 14);
        }
        $lastName = trim($order_info['shipping_lastname']);
        if(strlen($lastName) > 35)
        {
            $lastName = substr($lastName, 0, 34);
        }
        $email = trim($order_info['email']);
        if(strlen($email) > 70)
        {
            $email = substr($email, 0, 69);
        }
        $ip = long2ip($order_info['ip']);
        $phone = trim($order_info['shipping_phone']);
        if(strlen($phone) > 15)
        {
            $phone = substr($phone, 0, 14);
        }
        $state = trim($order_info['shipping_state']);
        if(strlen($state) > 35)
        {
            $state = substr($state, 0, 34);
        }
        $city = trim($order_info['shipping_city']);
        if(strlen($city) > 40)
        {
            $city = substr($city, 0, 39);
        }
        $address = trim($order_info['shipping_address']);
        if(strlen($address) > 50)
        {
            $address = substr($address, 0, 49);
        }
        $zip = trim($order_info['shipping_zip']);
        if(strlen($zip) > 10)
        {
            $zip = substr($zip, 0, 9);
        }
        $language = LANGUAGE ? LANGUAGE : 'en';
        $amount = (int) ($orderAmount * 100);

        $params = array(
            'REQUEST' => array(
                'ACTION' => 'INSERT_ORDERWITHPAYMENT',
                'META' => array(
                    'MERCHANTID' => $this->merchantid,
                    // 'IPADDRESS' => '205.234.213.129',
                    'IPADDRESS' => $ip,
                    'VERSION' => '2.0',
                ),
                'PARAMS' => array(
                    'ORDER' => array(
                        'ORDERID' => $order_info['id'],
                        'AMOUNT' => $amount,
                        'CURRENCYCODE' => $orderCurrency,
                        'LANGUAGECODE' => $language,
                        'FIRSTNAME' => $firstName,
                        'SURNAME' => $lastName,
                        'EMAIL' => $email,
                        'HOUSENUMBER' => $phone,
                        'COUNTRYCODE' => $country,
                        'STATE' => $state,
                        'CITY' => $city,
                        'STREET' => $address,
                        'ZIP' => $zip,
                        'MERCHANTREFERENCE' => $ordernum . '-' . time(),
                    ),
                    'PAYMENT' => array(
                        'PAYMENTPRODUCTID' => 841,
                        'AMOUNT' => $amount,
                        'CURRENCYCODE' => $orderCurrency,
                        'LANGUAGECODE' => $language,
                        'COUNTRYCODE' => $country,
                        'HOSTEDINDICATOR' => 1,
                        'RETURNURL' => BASEURL . '/payment/webmoney_return',
                    ),
                ),
            ),
        );
        $correct_url = 'HTTPS://ps.gcsip.com/wdl/wdl';
        // $correct_url = 'HTTPS://ps.gcsip.nl/wdl/wdl'; //test url
        $xml_data = $this->array2xml($params);
        // echo $xml_data;exit;
        $ch = curl_init();

        $header[] = "Content-type: text/xml";//定义content-type为xml
        curl_setopt($ch, CURLOPT_URL, $correct_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        $response = curl_exec($ch);

        if(curl_errno($ch))
        {
            print curl_error($ch);
        }
        curl_close($ch);
        $result_data = @simplexml_load_string($response,NULL,LIBXML_NOCDATA);
        $return_data = json_decode(json_encode($result_data),true);
        $request = $return_data['REQUEST'];
        $result = $request['RESPONSE'];
        if($result['RESULT'] == 'OK')
        {
            $ref = $result['ROW']['REF'];
            DB::update('orders_order')->set(array('referrer' => $ref))->where('id', '=', $order_info['id'])->execute();
            $url = $result['ROW']['FORMACTION'];
            $this->request->redirect($url);
        }
        else
        {
            Kohana_log::instance()->add('Webmoney Response', json_encode($result_data));
            $error = $result['ERROR'];
            if(isset($error[0]))
            {
                $message = $error[0]['MESSAGE'];
            }
            else
            {
                $message = $error['MESSAGE'];
            }
            Message::set($message, 'error');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
    }

    public function action_yandex_pay($ordernum)
    {

        if (Arr::get($_SERVER, 'COFREE_DOMAIN', URLSTR) == URLSTR AND Arr::get($_SERVER, 'HTTPS', 'off') != 'on')
        {
            $type = isset($_GET['type']) ? '?type=' . $_GET['type'] : '';
            Request::Instance()->redirect(URL::site(Request::Instance()->uri . $type, 'https'));
        }
        if(!is_numeric($ordernum))
        {
            $uri = $this->request->uri();
            $uris = explode('/', $uri);
            $ordernum = $uris[count($uris) - 1];
        }
        if (!$ordernum)
        {
            $this->request->redirect(LANGPATH . '/');
        }
        if (!($customer_id = Customer::logged_in()))
        {

            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
        $order = Order::instance(Order::get_from_ordernum($ordernum));
        $order_info = $order->get();
        if(!$order_info['is_active'])
        {
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
        if($order_info['payment_status'] == 'success' OR $order_info['payment_status'] == 'verify_pass')
        {
            $this->request->redirect(LANGPATH . '/payment/success/' . $ordernum);
        }
        if($order_info['payment_status'] == 'pending')
        {
            Message::set(__('payment_pending'), 'notice');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
        if ($order_info['customer_id'] != $customer_id)
            $this->request->redirect(LANGPATH . '/404');

        $country_replace = array('CAN', 'CHI', 'KO', 'XG');
        $replace_to = array('ES', 'US', 'RS', 'ES');
        $country = trim($order_info['shipping_country']);
        $country = str_replace($country_replace, $replace_to, $country);
        $yandex_countries = array(
            'RU' => 'RUB',
        );
        if(!array_key_exists($country, $yandex_countries))
        {
            Message::set('Country Code Error', 'error');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
        else
        {
            $yandex_currency = $yandex_countries[$country];
        }

        date_default_timezone_set ('Asia/Shanghai');
        $orderNo = trim($order_info['ordernum']);
        $orderCurrency = trim($order_info['currency']);
        $orderAmount = round($order_info['amount'], 2);
        if($orderCurrency != $yandex_currency)
        {
            $orderCurrency = $yandex_currency;
            $currency = Site::instance()->currencies($order_info['currency']);
            $currency1 = Site::instance()->currencies($orderCurrency);
            $orderAmount = round($orderAmount / $currency['rate'] * $currency1['rate'], 2);
        }
        $firstName = trim($order_info['shipping_firstname']);
        if(strlen($firstName) > 15)
        {
            $firstName = substr($firstName, 0, 14);
        }
        $lastName = trim($order_info['shipping_lastname']);
        if(strlen($lastName) > 35)
        {
            $lastName = substr($lastName, 0, 34);
        }
        $email = trim($order_info['email']);
        if(strlen($email) > 70)
        {
            $email = substr($email, 0, 69);
        }
        $ip = long2ip($order_info['ip']);
        $phone = trim($order_info['shipping_phone']);
        if(strlen($phone) > 15)
        {
            $phone = substr($phone, 0, 14);
        }
        $state = trim($order_info['shipping_state']);
        if(strlen($state) > 35)
        {
            $state = substr($state, 0, 34);
        }
        $city = trim($order_info['shipping_city']);
        if(strlen($city) > 40)
        {
            $city = substr($city, 0, 39);
        }
        $address = trim($order_info['shipping_address']);
        if(strlen($address) > 50)
        {
            $address = substr($address, 0, 49);
        }
        $zip = trim($order_info['shipping_zip']);
        if(strlen($zip) > 10)
        {
            $zip = substr($zip, 0, 9);
        }
        $language = LANGUAGE ? LANGUAGE : 'en';
        $amount = (int) ($orderAmount * 100);

        $params = array(
            'REQUEST' => array(
                'ACTION' => 'INSERT_ORDERWITHPAYMENT',
                'META' => array(
                    'MERCHANTID' => $this->merchantid,
                    // 'IPADDRESS' => '205.234.213.129',
                    'IPADDRESS' => $ip,
                    'VERSION' => '2.0',
                ),
                'PARAMS' => array(
                    'ORDER' => array(
                        'ORDERID' => $order_info['id'],
                        'AMOUNT' => $amount,
                        'CURRENCYCODE' => $orderCurrency,
                        'LANGUAGECODE' => $language,
                        'FIRSTNAME' => $firstName,
                        'SURNAME' => $lastName,
                        'EMAIL' => $email,
                        'HOUSENUMBER' => $phone,
                        'COUNTRYCODE' => $country,
                        'STATE' => $state,
                        'CITY' => $city,
                        'STREET' => $address,
                        'ZIP' => $zip,
                        'MERCHANTREFERENCE' => $ordernum . '-' . time(),
                    ),
                    'PAYMENT' => array(
                        'PAYMENTPRODUCTID' => 849,
                        'AMOUNT' => $amount,
                        'CURRENCYCODE' => $orderCurrency,
                        'LANGUAGECODE' => $language,
                        'COUNTRYCODE' => $country,
                        'HOSTEDINDICATOR' => 1,
                        'RETURNURL' => BASEURL . '/payment/yandex_return',
                    ),
                ),
            ),
        );
        $correct_url = 'HTTPS://ps.gcsip.com/wdl/wdl';
        // $correct_url = 'HTTPS://ps.gcsip.nl/wdl/wdl'; //test url
        $xml_data = $this->array2xml($params);
        // echo $xml_data;exit;
        $ch = curl_init();

        $header[] = "Content-type: text/xml";//定义content-type为xml
        curl_setopt($ch, CURLOPT_URL, $correct_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        $response = curl_exec($ch);

        if(curl_errno($ch))
        {
            print curl_error($ch);
        }
        curl_close($ch);
        $result_data = @simplexml_load_string($response,NULL,LIBXML_NOCDATA);
        $return_data = json_decode(json_encode($result_data),true);
        $request = $return_data['REQUEST'];
        $result = $request['RESPONSE'];
        if($result['RESULT'] == 'OK')
        {
            $ref = $result['ROW']['REF'];
            DB::update('orders_order')->set(array('referrer' => $ref))->where('id', '=', $order_info['id'])->execute();
            $url = $result['ROW']['FORMACTION'];
            $this->request->redirect($url);
        }
        else
        {
            Kohana_log::instance()->add('Yandex Response', json_encode($result_data));
            $error = $result['ERROR'];
            if(isset($error[0]))
            {
                $message = $error[0]['MESSAGE'];
            }
            else
            {
                $message = $error['MESSAGE'];
            }
            Message::set($message, 'error');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
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

    public function action_gc_check()
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
            $correct_url = 'HTTPS://ps.gcsip.com/wdl/wdl';
            // $correct_url = 'HTTPS://ps.gcsip.nl/wdl/wdl'; //test url
            $cc_payment_id = Site::instance()->get('cc_payment_id');
            $cc_secure_code = Site::instance()->get('cc_secure_code');
            $successArr = array(
                800, 900, 975, 1000, 1010, 1020, 1030, 1050, 1500
            );

            $string = Arr::get($_POST, 'orders', '');
            $orders = explode("\n", $string);
            foreach($orders as $key => $o)
            {
                $ordernum = trim($o);
                $order_id = Order::get_from_ordernum($ordernum);
                $params=array(
                    'REQUEST' => array(
                        'ACTION' => 'GET_ORDERSTATUS',
                        'META' => array(
                            'MERCHANTID' => $this->merchantid,
                            'IPADDRESS' => '205.234.213.129',
                            // 'IPADDRESS' => $ip,
                            'VERSION' => '2.0',
                        ),
                        'PARAMS' => array(
                            'ORDER' => array(
                                'ORDERID' => $order_id,
                            )
                        ),
                    ),
                );
                $xml_data = $this->array2xml($params);

                $ch = curl_init();

                $header[] = "Content-type: text/xml";//定义content-type为xml
                curl_setopt($ch, CURLOPT_URL, $correct_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
                $response = curl_exec($ch);
                if(curl_errno($ch))
                {
                    print curl_error($ch);
                }
                curl_close($ch);

                $result_data = @simplexml_load_string($response,NULL,LIBXML_NOCDATA);
                $return_data = json_decode(json_encode($result_data),true);
                // print_r($return_data);exit;
                $order_status = Order::instance($order_id)->get('payment_status');
                if(in_array($order_status, array('new', 'failed', 'pending')))
                {
                    $response = $return_data['REQUEST']['RESPONSE']['STATUS'];
                    if(isset($response['ERRORS']))
                    {
                        echo $ordernum . '-error: ' . $response['ERRORS'] . '<br>';
                    }
                    else
                    {
                        if(in_array($response['STATUSID'], $successArr))
                        {
                            $update = DB::update('orders_order')->set(array('payment_status' => 'success'))->where('id', '=', $order_id)->execute();
                            if($update)
                            {
                                $orderData = Order::instance($order_id)->get();
                                //payment platform sync
                                $post_var = "order_num=" . $orderData['ordernum']
                                    . "&order_amount=" . $orderData['amount']
                                    . "&order_currency=" . $orderData['currency']
                                    . "&card_num=4263982640269299"
                                    . "&card_type=1"
                                    . "&card_cvv=111"
                                    . "&card_exp_month=12"
                                    . "&card_exp_year=15"
                                    . "&card_inssue=" . $orderData['cc_issue']
                                    . "&card_valid_month=12"
                                    . "&card_valid_year=15"
                                    . "&billing_firstname=" . $orderData['billing_firstname']
                                    . "&billing_lastname=" . $orderData['billing_lastname']
                                    . "&billing_address=" . $orderData['billing_address']
                                    . "&billing_zip=" . $orderData['billing_zip']
                                    . "&billing_city=" . $orderData['billing_city']
                                    . "&billing_state=" . $orderData['billing_state']
                                    . "&billing_country=" . $orderData['billing_country']
                                    . "&billing_telephone=" . $orderData['billing_phone']
                                    . "&billing_ip_address=" . long2ip($orderData['ip'])
                                    . "&billing_email=" . $orderData['email']
                                    . "&shipping_firstname=" . $orderData['shipping_firstname']
                                    . "&shipping_lastname=" . $orderData['shipping_lastname']
                                    . "&shipping_address=" . $orderData['shipping_address']
                                    . "&shipping_zip=" . $orderData['shipping_zip']
                                    . "&shipping_city=" . $orderData['shipping_city']
                                    . "&shipping_state=" . $orderData['shipping_state']
                                    . "&shipping_country=" . $orderData['shipping_country']
                                    . "&shipping_telephone=" . $orderData['shipping_phone']
                                    . '&trans_id=' . $response['MERCHANTREFERENCE']
                                    . "&site_id=" . $cc_payment_id
                                    . "&secure_code=" . $cc_secure_code
                                    . "&status=1";
                                $result = Toolkit::curl_pay('https://www.shuiail.com/globebill', $post_var);
                                $result = unserialize(stripcslashes($result));
                                Kohana_Log::instance()->add('Payment status return', $result)->write();

                                //set success mail
                                $mail_params = array();
                                $mail_params['order_view_link'] = BASEURL. '/order/view/' . $orderData['ordernum'];
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
                                $mail_params['shipping_fee'] = round($orderData['amount_shipping'],2);
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

                                $amount = $response['AMOUNT'] / 100;
                                $payment_log = array(
                                    // 'site_id'        => $this->site_id,
                                    'order_id'       => $orderData['id'],
                                    'customer_id'    => $orderData['customer_id'],
                                    'payment_method' => 'GlobalCollect',
                                    'trans_id'       => $response['MERCHANTREFERENCE'],
                                    'amount'         => $amount,
                                    'currency'       => $response['CURRENCYCODE'],
                                    'comment'        => 'success',
                                    'cache'          => serialize($response),
                                    'payment_status' => 'success',
                                    'ip'             => ip2long($orderData['ip']),
                                    'created'        => strtotime($response['STATUSDATE']),
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
                                Payment::instance('GC')->log($payment_log);

                                //update orders amount_payment
                                DB::update('orders_order')->set(array('amount_payment' => $amount))->where('id', '=', $orderData['id'])->execute();

                                echo $ordernum . ' update success<br>';
                            }
                        }
                    }
                }

            }
        }
        exit;
    }

    public function action_pay_insite1($ordernum = '')
    {
        if (Arr::get($_SERVER, 'COFREE_DOMAIN', URLSTR) == URLSTR AND Arr::get($_SERVER, 'HTTPS', 'off') != 'on')
        {
            $type = isset($_GET['type']) ? '?type=' . $_GET['type'] : '';
            Request::Instance()->redirect(URL::site(Request::Instance()->uri . $type, 'https'));
        }
        if(!is_numeric($ordernum))
        {
            $uri = $this->request->uri();
            $uris = explode('/', $uri);
            $ordernum = $uris[count($uris) - 1];
        }
        if (!$ordernum)
        {
            $this->request->redirect(LANGPATH . '/');
        }
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
        $order = Order::instance(Order::get_from_ordernum($ordernum));
        $order_info = $order->get();
        if ($order_info['customer_id'] != $customer_id)
            $this->request->redirect(LANGPATH . '/404');

        if($_POST)
        {
            Site::instance()->add_clicks('card_pay');
            date_default_timezone_set ('Asia/Shanghai');
            $merNo = 10470;
            $gatewayNo = 10470003;
            $signkey = '88080420';
            $orderNo = trim($order_info['ordernum']);
            $orderCurrency = trim($order_info['currency']);
            $orderAmount = round($order_info['amount'], 2);
            $cardNo = Arr::get($_POST, 'cardNo', 0);
            $cardExpireMonth = Arr::get($_POST, 'cardExpireMonth', 0);
            $cardExpireYear = Arr::get($_POST, 'cardExpireYear', 0);
            $cardSecurityCode = Arr::get($_POST, 'cardSecurityCode', 0);
            $issuingBank = 'bank';
            $firstName = trim($order_info['shipping_firstname']);
            $firstName = preg_replace('/[^\b\w]+/i','-',$firstName) . '-';
            $lastName = trim($order_info['shipping_lastname']);
            $lastName = preg_replace('/[^\b\w]+/i','-',$lastName) . '-';
            $email = trim($order_info['email']);
            $ip = long2ip($order_info['ip']);
            $phone = trim($order_info['shipping_phone']);
            $paymentMethod = 'Credit Card';
            $country = trim($order_info['shipping_country']);
            $state = trim($order_info['shipping_state']);
            $state = preg_replace('/[^\b\w]+/i','-',$state) . '-';
            $city = trim($order_info['shipping_city']);
            $city = preg_replace('/[^\b\w]+/i','-',$city) . '-';
            $address = trim($order_info['shipping_address']);
            $address = preg_replace('/[^\b\w]+/i','-',$address) . '-';
            $zip = trim($order_info['shipping_zip']);
            $remark = 'remark';
            $customerID = $order_info['customer_id'];
            // $signsrc = $merNo.$gatewayNo.$orderNo.$orderCurrency.$orderAmount.$firstName.$lastName.$cardNo.$cardExpireYear.$cardExpireMonth.$cardSecurityCode.$email.$signkey;
            $signsrc = $merNo . $gatewayNo . $orderNo . $orderCurrency . $orderAmount . $customerID . $firstName . $lastName . $cardNo . $cardExpireYear . $cardExpireMonth . $cardSecurityCode . $email . $signkey;
            $signInfo = hash('sha256',$signsrc);

            //add signInfo log
            $signlog = $merNo . '|' . $gatewayNo . '|' . $orderNo . '|' . $orderCurrency . '|' . $orderAmount . '|' . $customerID . '|' . $firstName . '|' . $lastName . '|' . $cardNo . '|' . $cardExpireYear . '|' . $cardExpireMonth . '|' . $cardSecurityCode . '|' . $email . '|' . $signkey;
            Kohana_log::instance()->add('Signinfo', $orderNo . ': ' . $signlog);

            $correct_url = 'https://payment.globebill.com/TPInterface';
            // $correct_url = 'https://payment.globebill.com/TestTPInterface'; //test url

            $params=array(
                'merNo'=>$merNo,
                'gatewayNo'=>$gatewayNo,
                'orderNo'=>$orderNo,
                'signInfo'=>$signInfo,
                'orderCurrency'=>$orderCurrency,
                'orderAmount' => $orderAmount,
                'paymentMethod'=>$paymentMethod,
                'cardNo'=>$cardNo,
                'cardExpireMonth'=>$cardExpireMonth,
                'cardExpireYear'=>$cardExpireYear,
                'cardSecurityCode'=>$cardSecurityCode,
                'issuingBank'=>$issuingBank,
                'customerID' => $customerID,
                'firstName'=>$firstName,
                'lastName'=>$lastName,
                'email'=>$email,
                'ip'=>$ip,
                'phone'=>$phone,
                'country'=>$country,
                'state'=>$state,
                'city'=>$city,
                'address'=>$address,
                'zip'=>$zip
            );
            // print_r($params);exit;
            $result_data = $this->socketPost($correct_url,$params);
            $xml = new DOMDocument();
            $xml->loadXML($result_data);
            $return_data = array(
                'merNo' => $xml->getElementsByTagName("merNo")->item(0)->nodeValue,
                'gatewayNo' => $xml->getElementsByTagName("gatewayNo")->item(0)->nodeValue,
                'tradeNo' => $xml->getElementsByTagName("tradeNo")->item(0)->nodeValue,
                'orderNo' => $xml->getElementsByTagName("orderNo")->item(0)->nodeValue,
                'orderCurrency' => $xml->getElementsByTagName("orderCurrency")->item(0)->nodeValue,
                'orderAmount' => $xml->getElementsByTagName("orderAmount")->item(0)->nodeValue,
                'cardNo' => $xml->getElementsByTagName("cardNo")->item(0)->nodeValue,
                'orderStatus' => $xml->getElementsByTagName("orderStatus")->item(0)->nodeValue,
                'orderInfo' => $xml->getElementsByTagName("orderInfo")->item(0)->nodeValue,
                'signInfo' => $xml->getElementsByTagName("signInfo")->item(0)->nodeValue,
                'riskInfo' => $xml->getElementsByTagName("riskInfo")->item(0)->nodeValue,
                'remark' => $xml->getElementsByTagName("remark")->item(0)->nodeValue,
            );

            $this->globebill_return1($return_data);
            exit;
        }

        $this->template->type = 'purchase';
        $this->template->content = View::factory('/payment_insite')
            ->set('order', $order_info);
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

    public function action_insite_globebill()
    {
        $order_status = Order::instance(Order::get_from_ordernum($_GET['orderNo']))->get('payment_status');
        if ($order_status == 'success' OR $order_status == 'verify_pass')
        {
            echo '<script language="javascript">top.location.replace("'.BASEURL.'/payment/success/' . $_GET['orderNo'] . '");</script>';
            exit;
        }
        echo View::factory('/payment_insite_globebill')->render();
        exit;
    }

    // PP IPN
    public function action_pp_return()
    {
        try{
            Kohana_Log::instance()->add('PP_RETURN', json_encode($_REQUEST))->write();
        }
        catch(Exception $e){
            Kohana_Log::instance()->add('PP_RETURN', serialize($_REQUEST))->write();
        }

        $this->auto_render = FALSE;
//                $a = 'a:40:{s:8:"mc_gross";s:4:"0.01";s:22:"protection_eligibility";s:10:"Ineligible";s:14:"address_status";s:9:"confirmed";s:8:"payer_id";s:13:"QAE6ZC9ZQ6ZEA";s:3:"tax";s:4:"0.00";s:14:"address_street";s:16:"144 Marsden Road";s:12:"payment_date";s:25:"10:03:19 Nov 09, 2012 PST";s:14:"payment_status";s:9:"Completed";s:7:"charset";s:6:"gb2312";s:11:"address_zip";s:8:"BB10 2QP";s:10:"first_name";s:14:"Michael Joshua";s:6:"mc_fee";s:4:"1.43";s:20:"address_country_code";s:2:"GB";s:12:"address_name";s:23:"Michael Joshua Reynolds";s:14:"notify_version";s:3:"3.7";s:6:"custom";s:0:"";s:12:"payer_status";s:8:"verified";s:8:"business";s:27:"craigwhitmore1978@gmail.com";s:15:"address_country";s:14:"United Kingdom";s:12:"address_city";s:7:"Burnley";s:8:"quantity";s:1:"1";s:11:"verify_sign";s:56:"ABlYq.7R2IHqQTc1kx9HVB4oCrebADpamZkrI-GHrJS1FQvVOVgXB.Iw";s:11:"payer_email";s:22:"shijiangming09@163.com";s:6:"txn_id";s:17:"35D125007X304741E";s:12:"payment_type";s:7:"instant";s:9:"last_name";s:8:"Reynolds";s:13:"address_state";s:10:"Lancashire";s:14:"receiver_email";s:27:"craigwhitmore1978@gmail.com";s:11:"payment_fee";s:0:"";s:11:"receiver_id";s:13:"2M9SCQX9PGW8C";s:8:"txn_type";s:10:"web_accept";s:9:"item_name";s:11:"10622421340";s:11:"mc_currency";s:3:"USD";s:11:"item_number";s:17:"10622421340:62242";s:17:"residence_country";s:2:"GB";s:15:"handling_amount";s:4:"0.00";s:19:"transaction_subject";s:11:"10622421340";s:13:"payment_gross";s:0:"";s:8:"shipping";s:4:"0.00";s:12:"ipn_track_id";s:13:"b7975257b916d";}';
//                $_REQUEST = unserialize($a);
        $trans_id = Arr::get($_REQUEST, 'txn_id', '');
        $has = DB::select('id')->from('orders_orderpayments')->where('trans_id', '=', $trans_id)->execute()->get('id');
        if ($has)
        {
            exit;
        }

        $item_num = isset($_REQUEST['item_number']) ? $_REQUEST['item_number'] : '';
        $custom = isset($_REQUEST['custom']) ? $_REQUEST['custom'] : '';
        if ($item_num OR $custom)
        {
            $item_num = !empty($item_num) ? explode(':', $item_num) : explode(':', $custom);
            $order_id = $item_num[1];
            $order = Order::instance($order_id);
            // TODO Coupon Limit -1
            if ($coupon = Cart::coupon())
            {
                Coupon::instance($coupon)->apply();
            }

            if ($_REQUEST['payment_status'] == 'Completed')
            {
                $amount = $_REQUEST['mc_gross'];
                // if ($amount > 0)
                // {
                //     Event::run('Order.payment', array(
                //         'amount' => (int) $amount,
                //         'order' => $order,
                //     ));
                // }

                // Product stock Minus
                $products = $order->products();
                foreach ($products as $product)
                {
                    $stock = Product::instance($product['product_id'])->get('stock');
                    if ($stock == -1)
                    {
                        $attr = $product['attributes'];
                        $attr = str_replace(';', '', $attr);
                        $attr = str_replace('Size:', '', $attr);
                        $attr = str_replace('size:', '', $attr);
                        $attr = trim($attr);
                        $stocks = DB::select('id', 'stock')->from('products_productitem')
                                ->where('product_id', '=', $product['product_id'])
                                ->where('attribute', 'LIKE', '%' . $attr . '%')
                                ->execute()->current();
                        if (!empty($stocks))
                        {
                            DB::update('products_productitem')->set(array('stock' => $stocks['stock'] - $product['quantity']))->where('id', '=', $stocks['id'])->execute();
                        }
                    }
                }
            }

            $status = Payment::instance('PP')->pay($order->get(), $_REQUEST);
            if ($status == 'success')
            {
                Message::set(__('order_create_success'), 'notice');
                echo strtoupper($status);
            }
        }
        else
        {
            echo 'FAIL';
        }
    }

    public function gc_return($return_data)
    {
        // print_r($return_data);exit;
        Kohana_Log::instance()->add('GC_RETURN', json_encode($return_data))->write();
        // $a = 'a:15:{s:5:"merNo";s:5:"10040";s:9:"gatewayNo";s:8:"10040001";s:7:"tradeNo";s:22:"2013071103241790698612";s:7:"orderNo";s:11:"10335391340";s:11:"orderAmount";s:5:"77.97";s:13:"orderCurrency";s:3:"USD";s:11:"orderStatus";s:1:"1";s:9:"orderInfo";s:13:"0000_Approved";s:8:"signInfo";s:64:"CD6A7D34E17A814566C6CA33F52EDA7FE4C6CF9CDC72F2AF5E0654178B4F9B14";s:6:"remark";s:0:"";s:8:"riskInfo";s:140:"||sourceUrl=10.0;BinCountry=100.0;BlackList=100.0;Amount=100.0;PayNum=100.0;|0.0|100.0|2.52|monte dei paschi di siena|IT|49|2.224.23.120|IT|";s:14:"authTypeStatus";s:1:"0";s:6:"cardNo";s:13:"525500***0696";s:12:"EbanxBarCode";s:0:"";s:6:"isPush";s:1:"1";}';
        // $return_data = unserialize($a);

        if (empty($return_data['RESPONSE']))
        {
            //钱宝拒绝交易，交易号为空
            $this->request->redirect(LANGPATH . '/customer/orders');
            exit;
        }
        if(!empty($return_data['PARAMS']['ORDER']))
        {
            $return_order = $return_data['PARAMS']['ORDER'];
        }
        else
        {
            $this->request->redirect(LANGPATH . '/404');
        }
        $order_id = $return_order['ORDERID'];
        DB::update('orders_order')->set(array('payment_method' => 'GC'))->where('id', '=', $order_id)->execute();
        $order = Order::instance($order_id)->get();
        if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
        {
            echo '<script language="javascript">top.location.replace("'.BASEURL. '/payment/success/' . $order['ordernum'] . '");</script>';
            exit;
        }

        $result = $return_data['RESPONSE']['RESULT'];
        $message = '';
        $error_code = '';
        if(isset($return_data['RESPONSE']['ERROR']))
        {
            $errors = $return_data['RESPONSE']['ERROR'];
            if(isset($errors[0]))
            {
                $error_code = $errors[0]['CODE'];
                $message = $errors[0]['CODE'] . ':' . $errors[0]['MESSAGE'];
            }
            else
            {
                $error_code = $errors['CODE'];
                $message = $errors['CODE'] . ':' . $errors['MESSAGE'];
            }
        }
        $data = array();
        $data['order_id'] = $order_id;
        $data['trans_id'] = $return_order['MERCHANTREFERENCE'];
        if(!empty($return_data['RESPONSE']['ROW']['STATUSID']))
        {
            $statusid = $return_data['RESPONSE']['ROW']['STATUSID'];
        }
        else
        {
            $statusid = 0;
        }
        $data['statusid'] = $statusid;
        if($result == 'OK')
        {
            if($statusid >= 800 OR $statusid == 525 )
            {
                $data['succeed'] = 1;
            }
            else
            {
                $data['succeed'] = 0;
                if(!empty($return_data['RESPONSE']['STATUS']['ERRORS']))
                {
                    $error_code = $return_data['RESPONSE']['STATUS']['ERRORS']['ERROR']['CODE'];
                    $message = $return_data['RESPONSE']['STATUS']['ERRORS']['ERROR']['MESSAGE'];
                }
            }
        }
        else
        {
            $data['succeed'] = 0;
        }
        $data['message'] = $message;
        $return_payment = $return_data['PARAMS']['PAYMENT'];
        $data['amount'] = $return_payment['AMOUNT'] / 100;
        $data['currency'] = $return_payment['CURRENCYCODE'];
        $data['cardnum'] = '';

        // save cvv data
        $data['fraud_result'] = '';
        $data['fraud_code'] = '';
        $data['cvv_result'] = '';
        if(isset($return_data['RESPONSE']['ROW']['FRAUDRESULT']))
        {
            $data['fraud_result'] = $return_data['RESPONSE']['ROW']['FRAUDRESULT'];
        }
        if(isset($return_data['RESPONSE']['ROW']['FRAUDCODE']))
        {
            $data['fraud_code'] = $return_data['RESPONSE']['ROW']['FRAUDCODE'];
        }
        if(isset($return_data['RESPONSE']['ROW']['CVVRESULT']))
        {
            $data['cvv_result'] = $return_data['RESPONSE']['ROW']['CVVRESULT'];
        }

        Payment::instance('GC')->pay($order, $data);

        switch ($result)
        {
            case 'OK':
                if($statusid >= 800)
                {
                    $products = Order::instance($order_id)->products();
                    foreach ($products as $product)
                    {
                        $stock = Product::instance($product['product_id'])->get('stock');
                        if ($stock == -1)
                        {
                            $attr = $product['attributes'];
                            $attr = str_replace(';', '', $attr);
                            $attr = str_replace('Size:', '', $attr);
                            $attr = str_replace('size:', '', $attr);
                            $attr = trim($attr);
                            $stocks = DB::select('id', 'stock')->from('products_productitem')
                                    ->where('product_id', '=', $product['product_id'])
                                    ->where('attribute', 'LIKE', '%' . $attr . '%')
                                    ->execute()->current();
                            if (!empty($stocks))
                            {
                                DB::update('products_productitem')->set(array('stock' => $stocks['stock'] - $product['quantity']))->where('id', '=', $stocks['id'])->execute();
                            }
                        }
                    }
                    $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);
                }
                elseif($statusid == 525)
                {
                    $this->request->redirect(BASEURL. LANGPATH . '/payment/success/' . $order['ordernum']);
                }
                else
                {
                    Message::set($message, 'error');
                    $this->request->redirect(BASEURL . LANGPATH . '/order/view/' . $order['ordernum']);
                    break;
                }
                break;
            case 'NOK':
                $message = $return_data['RESPONSE']['ERROR']['MESSAGE'];
                $not_authorized = array('not authorized', 'not authorised', 'unable to authorize', 'unable to authorise', 'referred');
                if(in_array(strtolower($message), $not_authorized))
                {
                    $message = __('not_authorized');
                }
                else
                {
                    $error_types = array(
                        '430285', '430360', '430339', '430412', '430354', '430330',
                        '430357', '400708', '430306', '430490', '430900', '430418',
                        '430433', '400700', '400705', '430165', '430327', '430409',
                    );
                    if(in_array($error_code, $error_types))
                    {
                        $message = __('gc_error_' . $error_code);
                    }
                }
                Message::set($message, 'error');
                $this->request->redirect(BASEURL . LANGPATH . '/order/view/' . $order['ordernum']);
                break;
        }
    }

    public function gc_return1($return_data)
    {
        // print_r($return_data);exit;
        Kohana_Log::instance()->add('GC_RETURN', json_encode($return_data))->write();
        // $a = 'a:15:{s:5:"merNo";s:5:"10040";s:9:"gatewayNo";s:8:"10040001";s:7:"tradeNo";s:22:"2013071103241790698612";s:7:"orderNo";s:11:"10335391340";s:11:"orderAmount";s:5:"77.97";s:13:"orderCurrency";s:3:"USD";s:11:"orderStatus";s:1:"1";s:9:"orderInfo";s:13:"0000_Approved";s:8:"signInfo";s:64:"CD6A7D34E17A814566C6CA33F52EDA7FE4C6CF9CDC72F2AF5E0654178B4F9B14";s:6:"remark";s:0:"";s:8:"riskInfo";s:140:"||sourceUrl=10.0;BinCountry=100.0;BlackList=100.0;Amount=100.0;PayNum=100.0;|0.0|100.0|2.52|monte dei paschi di siena|IT|49|2.224.23.120|IT|";s:14:"authTypeStatus";s:1:"0";s:6:"cardNo";s:13:"525500***0696";s:12:"EbanxBarCode";s:0:"";s:6:"isPush";s:1:"1";}';
        // $return_data = unserialize($a);

        if (empty($return_data->RESPONSE))
        {
            //钱宝拒绝交易，交易号为空
            $this->request->redirect(LANGPATH . '/customer/orders');
            exit;
        }
        $return_order = $return_data->PARAMS->ORDER;
        $order_id = $return_order->ORDERID;
        $order = Order::instance($order_id)->get();
        if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
        {
            echo '<script language="javascript">top.location.replace("' . BASEURL . '/payment/success/' . $order['ordernum'] . '");</script>';
            exit;
        }
        $result = $return_data->RESPONSE->RESULT;
        $message = isset($return_data->RESPONSE->ERROR) ? $return_data->RESPONSE->ERROR->CODE . ':' . $return_data->RESPONSE->ERROR->MESSAGE : '';
        $data = array();
        $data['order_id'] = $order_id;
        $data['trans_id'] = $return_order->MERCHANTREFERENCE;
        $data['message'] = $message;
        $data['succeed'] = $result == 'OK' ? 1 : 0;
        $statusid = $return_data->RESPONSE->ROW->STATUSID;
        $data['statusid'] = $statusid;
        $return_payment = $return_data->PARAMS->PAYMENT;
        $data['amount'] = $return_payment->AMOUNT / 100;
        $data['currency'] = $return_payment->CURRENCYCODE;
        $data['cardnum'] = '';

        Payment::instance('GC')->pay($order, $data);

        switch ($result)
        {
            case 'OK':
                if($statusid >= 800)
                {
                    $products = Order::instance($order_id)->products();
                    foreach ($products as $product)
                    {
                        $stock = Product::instance($product['product_id'])->get('stock');
                        if ($stock == -1)
                        {
                            $attr = $product['attributes'];
                            $attr = str_replace(';', '', $attr);
                            $attr = str_replace('Size:', '', $attr);
                            $attr = str_replace('size:', '', $attr);
                            $attr = trim($attr);
                            $stocks = DB::select('id', 'stocks')->from('products_stocks')
                                    ->where('product_id', '=', $product['product_id'])
                                    ->where('attributes', 'LIKE', '%' . $attr . '%')
                                    ->execute()->current();
                            if (!empty($stocks))
                            {
                                DB::update('products_stocks')->set(array('stocks' => $stocks['stocks'] - $product['quantity']))->where('id', '=', $stocks['id'])->execute();
                            }
                        }
                    }
                    $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);
                }
                elseif($statusid == 525)
                {
                    $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);
                }
                break;
            case 'NOK':
                $message = $return_data->RESPONSE->ERROR->MESSAGE;
                if(strtolower($message) == 'not authorized')
                {
                    $message = __('not_authorized');
                }
                Message::set($message, 'error');
                $this->request->redirect(BASEURL. LANGPATH . '/order/view/' . $order['ordernum']);
                break;
        }
    }

    public function action_qiwi_return()
    {
        // print_r($_REQUEST);exit;
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
        $ref = Arr::get($_REQUEST, 'REF', '');
        if(!$ref)
        {
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
        $order_id = DB::select('id')->from('orders_order')->where('referrer', '=', $ref)->execute()->get('id');
        DB::update('orders_order')->set(array('payment_method' => 'QIWI'))->where('id', '=', $order_id)->execute();
        if($order_id)
        {
            $params=array(
                'REQUEST' => array(
                    'ACTION' => 'GET_ORDERSTATUS',
                    'META' => array(
                        'MERCHANTID' => $this->merchantid,
                        'IPADDRESS' => '205.234.213.129',
                        // 'IPADDRESS' => $ip,
                        'VERSION' => '2.0',
                    ),
                    'PARAMS' => array(
                        'ORDER' => array(
                            'ORDERID' => $order_id,
                        )
                    ),
                ),
            );
            $xml_data = $this->array2xml($params);
            $correct_url = 'HTTPS://ps.gcsip.com/wdl/wdl';
            // $correct_url = 'HTTPS://ps.gcsip.nl/wdl/wdl'; //test url

            $ch = curl_init();

            $header[] = "Content-type: text/xml";//定义content-type为xml
            curl_setopt($ch, CURLOPT_URL, $correct_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
            $response = curl_exec($ch);

            if(curl_errno($ch))
            {
                print curl_error($ch);
            }
            curl_close($ch);

            $result_data = @simplexml_load_string($response,NULL,LIBXML_NOCDATA);
            $request = json_decode(json_encode($result_data),true);
            Kohana_Log::instance()->add('QIWI_RETURN', json_encode($request))->write();
            $return_data = $request['REQUEST'];
            if (empty($return_data['RESPONSE']))
            {
                //钱宝拒绝交易，交易号为空
                $this->request->redirect(LANGPATH . '/customer/orders');
                exit;
            }
            $return_order = $return_data['PARAMS']['ORDER'];
            $order_id = $return_order['ORDERID'];
            $order = Order::instance($order_id)->get();
            if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
            {
                echo '<script language="javascript">top.location.replace("'.BASEURL. '/payment/success/' . $order['ordernum'] . '");</script>';
                exit;
            }

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
                if($statusid >= 800 OR $statusid == 525)
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
            $data['type'] = 'QIWI';

            Payment::instance('GC')->pay($order, $data);

            switch ($result)
            {
                case 'OK':
                    if($statusid >= 800)
                    {
                        $products = Order::instance($order_id)->products();
                        foreach ($products as $product)
                        {
                            $stock = Product::instance($product['product_id'])->get('stock');
                            if ($stock == -1)
                            {
                                $attr = $product['attributes'];
                                $attr = str_replace(';', '', $attr);
                                $attr = str_replace('Size:', '', $attr);
                                $attr = str_replace('size:', '', $attr);
                                $attr = trim($attr);
                                $stocks = DB::select('id', 'stocks')->from('products_stocks')
                                        ->where('product_id', '=', $product['product_id'])
                                        ->where('attributes', 'LIKE', '%' . $attr . '%')
                                        ->execute()->current();
                                if (!empty($stocks))
                                {
                                    DB::update('products_stocks')->set(array('stocks' => $stocks['stocks'] - $product['quantity']))->where('id', '=', $stocks['id'])->execute();
                                }
                            }
                        }
                        $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);
                    }
                    elseif($statusid == 525)
                    {
                        $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);
                    }
                    else
                    {
                        Message::set($message, 'error');
                        $this->request->redirect(BASEURL . LANGPATH . '/order/view/' . $order['ordernum']);
                        break;
                    }
                    break;
                case 'NOK':
                    $message = $return_data['RESPONSE']['ERROR']['MESSAGE'];
                    $not_authorized = array('not authorized', 'not authorised', 'unable to authorize', 'unable to authorise');
                    if(in_array(strtolower($message), $not_authorized))
                    {
                        $message = __('not_authorized');
                    }
                    Message::set($message, 'error');
                    $this->request->redirect(BASEURL . LANGPATH . '/order/view/' . $order['ordernum']);
                    break;
            }
        }
        else
        {
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
    }

    public function action_webmoney_return()
    {
        // print_r($_REQUEST);exit;
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
        $ref = Arr::get($_REQUEST, 'REF', '');
        if(!$ref)
        {
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
        $order_id = DB::select('id')->from('orders_order')->where('referrer', '=', $ref)->execute()->get('id');
        DB::update('orders_order')->set(array('payment_method' => 'WEBMONEY'))->where('id', '=', $order_id)->execute();
        if($order_id)
        {
            $params=array(
                'REQUEST' => array(
                    'ACTION' => 'GET_ORDERSTATUS',
                    'META' => array(
                        'MERCHANTID' => $this->merchantid,
                        'IPADDRESS' => '205.234.213.129',
                        // 'IPADDRESS' => $ip,
                        'VERSION' => '2.0',
                    ),
                    'PARAMS' => array(
                        'ORDER' => array(
                            'ORDERID' => $order_id,
                        )
                    ),
                ),
            );
            $xml_data = $this->array2xml($params);
            $correct_url = 'HTTPS://ps.gcsip.com/wdl/wdl';
            // $correct_url = 'HTTPS://ps.gcsip.nl/wdl/wdl'; //test url

            $ch = curl_init();

            $header[] = "Content-type: text/xml";//定义content-type为xml
            curl_setopt($ch, CURLOPT_URL, $correct_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
            $response = curl_exec($ch);

            if(curl_errno($ch))
            {
                print curl_error($ch);
            }
            curl_close($ch);

            $result_data = @simplexml_load_string($response,NULL,LIBXML_NOCDATA);
            $request = json_decode(json_encode($result_data),true);
            Kohana_Log::instance()->add('Webmoney_RETURN', json_encode($request))->write();
            $return_data = $request['REQUEST'];
            if (empty($return_data['RESPONSE']))
            {
                //钱宝拒绝交易，交易号为空
                $this->request->redirect(LANGPATH . '/customer/orders');
                exit;
            }
            $return_order = $return_data['PARAMS']['ORDER'];
            $order_id = $return_order['ORDERID'];
            $order = Order::instance($order_id)->get();
            if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
            {
                echo '<script language="javascript">top.location.replace("' . BASEURL. '/payment/success/' . $order['ordernum'] . '");</script>';
                exit;
            }

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
                if($statusid >= 800 OR $statusid == 525)
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
            $data['type'] = 'WEBMONEY';

            Payment::instance('GC')->pay($order, $data);

            switch ($result)
            {
                case 'OK':
                    if($statusid >= 800)
                    {
                        $products = Order::instance($order_id)->products();
                        foreach ($products as $product)
                        {
                            $stock = Product::instance($product['product_id'])->get('stock');
                            if ($stock == -1)
                            {
                                $attr = $product['attributes'];
                                $attr = str_replace(';', '', $attr);
                                $attr = str_replace('Size:', '', $attr);
                                $attr = str_replace('size:', '', $attr);
                                $attr = trim($attr);
                                $stocks = DB::select('id', 'stocks')->from('products_stocks')
                                        ->where('product_id', '=', $product['product_id'])
                                        ->where('attributes', 'LIKE', '%' . $attr . '%')
                                        ->execute()->current();
                                if (!empty($stocks))
                                {
                                    DB::update('products_stocks')->set(array('stocks' => $stocks['stocks'] - $product['quantity']))->where('id', '=', $stocks['id'])->execute();
                                }
                            }
                        }
                        $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);
                    }
                    elseif($statusid == 525)
                    {
                        $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);
                    }
                    else
                    {
                        Message::set($message, 'error');
                        $this->request->redirect(BASEURL . LANGPATH . '/order/view/' . $order['ordernum']);
                        break;
                    }
                    break;
                case 'NOK':
                    $message = $return_data['RESPONSE']['ERROR']['MESSAGE'];
                    $not_authorized = array('not authorized', 'not authorised', 'unable to authorize', 'unable to authorise');
                    if(in_array(strtolower($message), $not_authorized))
                    {
                        $message = __('not_authorized');
                    }
                    Message::set($message, 'error');
                    $this->request->redirect(BASEURL . LANGPATH . '/order/view/' . $order['ordernum']);
                    break;
            }
        }
        else
        {
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
    }

    public function action_yandex_return()
    {
        // print_r($_REQUEST);exit;
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
        $ref = Arr::get($_REQUEST, 'REF', '');
        if(!$ref)
        {
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
        $order_id = DB::select('id')->from('orders_order')->where('referrer', '=', $ref)->execute()->get('id');
        DB::update('orders_order')->set(array('payment_method' => 'YANDEX'))->where('id', '=', $order_id)->execute();
        if($order_id)
        {
            $params=array(
                'REQUEST' => array(
                    'ACTION' => 'GET_ORDERSTATUS',
                    'META' => array(
                        'MERCHANTID' => $this->merchantid,
                        'IPADDRESS' => '205.234.213.129',
                        // 'IPADDRESS' => $ip,
                        'VERSION' => '2.0',
                    ),
                    'PARAMS' => array(
                        'ORDER' => array(
                            'ORDERID' => $order_id,
                        )
                    ),
                ),
            );
            $xml_data = $this->array2xml($params);
            $correct_url = 'HTTPS://ps.gcsip.com/wdl/wdl';
            // $correct_url = 'HTTPS://ps.gcsip.nl/wdl/wdl'; //test url

            $ch = curl_init();

            $header[] = "Content-type: text/xml";//定义content-type为xml
            curl_setopt($ch, CURLOPT_URL, $correct_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
            $response = curl_exec($ch);

            if(curl_errno($ch))
            {
                print curl_error($ch);
            }
            curl_close($ch);

            $result_data = @simplexml_load_string($response,NULL,LIBXML_NOCDATA);
            $request = json_decode(json_encode($result_data),true);
            Kohana_Log::instance()->add('Yandex_RETURN', json_encode($request))->write();
            $return_data = $request['REQUEST'];
            if (empty($return_data['RESPONSE']))
            {
                //钱宝拒绝交易，交易号为空
                $this->request->redirect(LANGPATH . '/customer/orders');
                exit;
            }
            $return_order = $return_data['PARAMS']['ORDER'];
            $order_id = $return_order['ORDERID'];
            $order = Order::instance($order_id)->get();
            if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
            {
                echo '<script language="javascript">top.location.replace("' . BASEURL . '/payment/success/' . $order['ordernum'] . '");</script>';
                exit;
            }

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
                if($statusid >= 800 OR $statusid == 525)
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
            $data['type'] = 'YANDEX';

            Payment::instance('GC')->pay($order, $data);

            switch ($result)
            {
                case 'OK':
                    if($statusid >= 800)
                    {
                        $products = Order::instance($order_id)->products();
                        foreach ($products as $product)
                        {
                            $stock = Product::instance($product['product_id'])->get('stock');
                            if ($stock == -1)
                            {
                                $attr = $product['attributes'];
                                $attr = str_replace(';', '', $attr);
                                $attr = str_replace('Size:', '', $attr);
                                $attr = str_replace('size:', '', $attr);
                                $attr = trim($attr);
                                $stocks = DB::select('id', 'stocks')->from('products_stocks')
                                        ->where('product_id', '=', $product['product_id'])
                                        ->where('attributes', 'LIKE', '%' . $attr . '%')
                                        ->execute()->current();
                                if (!empty($stocks))
                                {
                                    DB::update('products_stocks')->set(array('stocks' => $stocks['stocks'] - $product['quantity']))->where('id', '=', $stocks['id'])->execute();
                                }
                            }
                        }
                        $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);
                    }
                    elseif($statusid == 525)
                    {
                        $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);
                    }
                    else
                    {
                        Message::set($message, 'error');
                        $this->request->redirect(BASEURL . LANGPATH . '/order/view/' . $order['ordernum']);
                        break;
                    }
                    break;
                case 'NOK':
                    $message = $return_data['RESPONSE']['ERROR']['MESSAGE'];
                    $not_authorized = array('not authorized', 'not authorised', 'unable to authorize', 'unable to authorise');
                    if(in_array(strtolower($message), $not_authorized))
                    {
                        $message = __('not_authorized');
                    }
                    Message::set($message, 'error');
                    $this->request->redirect(BASEURL . LANGPATH . '/order/view/' . $order['ordernum']);
                    break;
            }
        }
        else
        {
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
    }

    public function action_ideal_return()
    {
        //获取推送输入流XML
        $xml_str = file_get_contents("php://input");

        //判断返回的输入流是否为xml
        if($this->xml_parser($xml_str))
        {
            $xml = simplexml_load_string($xml_str);
                //把推送参数赋值到$_REQUEST
                $_REQUEST['response_type']    = (string)$xml->response_type;
                $_REQUEST['account']          = (string)$xml->account;
                $_REQUEST['terminal']         = (string)$xml->terminal;
                $_REQUEST['payment_id']       = (string)$xml->payment_id;
                $_REQUEST['order_number']     = (string)$xml->order_number;
                $_REQUEST['order_currency']   = (string)$xml->order_currency;
                $_REQUEST['order_amount']     = (string)$xml->order_amount;
                $_REQUEST['payment_status']   = (string)$xml->payment_status;
                $_REQUEST['payment_details']  = (string)$xml->payment_details;
                $_REQUEST['signValue']        = (string)$xml->signValue;
                $_REQUEST['order_notes']      = (string)$xml->order_notes;
                $_REQUEST['payment_authType'] = (string)$xml->payment_authType;
                $_REQUEST['payment_risk']     = (string)$xml->payment_risk;
                $_REQUEST['methods']          = (string)$xml->methods;
                $_REQUEST['payment_country']  = (string)$xml->payment_country;
            //获取本地的code值
            $secureCode = $this->ocean_secureCode1;
        }

        $local_signValue  = hash("sha256",$_REQUEST['account'].$_REQUEST['terminal'].$_REQUEST['order_number'].$_REQUEST['order_currency'].$_REQUEST['order_amount'].$_REQUEST['order_notes'].$_REQUEST['payment_id'].$_REQUEST['payment_authType'].$_REQUEST['payment_status'].$_REQUEST['payment_details'].$_REQUEST['payment_risk'].$secureCode);

        if (strtolower($local_signValue) == strtolower($_REQUEST['signValue']))
        {
            $return_data = $_REQUEST;

            $returnum = serialize($return_data);

            Kohana_Log::instance()->add('OCEAN_IDEALRETURN', $returnum)->write();
            $order_id = Order::get_from_ordernum($return_data['order_number']);
            DB::update('orders_order')->set(array('payment_method' => 'IDEAL'))->where('id', '=', $order_id)->execute();
            $order = Order::instance($order_id)->get();
            if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
            {
            }

                $data = array();
                $data['order_id'] = $order_id;
                $data['payment_id'] = $return_data['payment_id'];
                $data['account'] = $return_data['account'];
                $data['terminal'] = $return_data['terminal'];
                $data['order_number'] = $return_data['order_number'];
                $data['order_currency'] = $return_data['order_currency'];
                $data['order_amount'] = $return_data['order_amount'];
                $data['payment_country'] = $return_data['payment_country'];
                $data['payment_details'] = $return_data['payment_details'];
                $data['payment_risk'] = $return_data['payment_risk'];
                $data['payment_authType'] = $return_data['payment_authType'];
                $data['type'] = 'OceanPay';

                $payment_status = $return_data['payment_status'];
                $payment_details = explode(":",$return_data['payment_details']);

            if ($payment_status == 1)
            {
                //支付成功
                $data['succeed'] = 1;
            }
            else
            {
                if($payment_details[0] == 80101)
                {
                    echo "receive-ok";
                    die;
                }
                //支付失败
                $data['succeed'] = 0;
            }

            Payment::instance('OC')->pay($order, $data);
            echo "receive-ok";
            die;
        }
        else
        {
            $return_data = $_REQUEST;
            $order_id = Order::get_from_ordernum($return_data['order_number']);
            DB::update('orders_order')->set(array('payment_status' => 'failed'))->where('id', '=', $order_id)->execute();
        }

    }

    public function action_globebill_return()
    {
        Kohana_Log::instance()->add('GLOBEBILL', json_encode($_REQUEST))->write();
//              $a = 'a:15:{s:5:"merNo";s:5:"10040";s:9:"gatewayNo";s:8:"10040001";s:7:"tradeNo";s:22:"2013071103241790698612";s:7:"orderNo";s:11:"10335391340";s:11:"orderAmount";s:5:"77.97";s:13:"orderCurrency";s:3:"USD";s:11:"orderStatus";s:1:"1";s:9:"orderInfo";s:13:"0000_Approved";s:8:"signInfo";s:64:"CD6A7D34E17A814566C6CA33F52EDA7FE4C6CF9CDC72F2AF5E0654178B4F9B14";s:6:"remark";s:0:"";s:8:"riskInfo";s:140:"||sourceUrl=10.0;BinCountry=100.0;BlackList=100.0;Amount=100.0;PayNum=100.0;|0.0|100.0|2.52|monte dei paschi di siena|IT|49|2.224.23.120|IT|";s:14:"authTypeStatus";s:1:"0";s:6:"cardNo";s:13:"525500***0696";s:12:"EbanxBarCode";s:0:"";s:6:"isPush";s:1:"1";}';
//              $_REQUEST = unserialize($a);
        //MD5key和商户id，固定值 商户号为10032，新接口
        $is_pay_insite = Site::instance()->get('is_pay_insite');

        $merNo = $_REQUEST['merNo'];
        $gatewayNo = $_REQUEST['gatewayNo'];
        $tradeNo = $_REQUEST["tradeNo"];  //交易号

        if (!$tradeNo)
        {   //钱宝拒绝交易，交易号为空
            if ($is_pay_insite)
            {
                echo '<script language="javascript">top.location.replace("' . BASEURL . '/customer/orders");</script>';
            }
            else
            {
                $this->request->redirect(LANGPATH . '/customer/orders');
            }
            exit;
        }
        $BillNo = $_REQUEST["orderNo"];      //订单号
        $Succeed = $_REQUEST["orderStatus"];            //交易成功状态 1=成功，0=失败 -1 待处理 -2 待确认
        $PayCurrency = $_REQUEST["orderCurrency"];    //币种代码，如：GBP
        $Amount = $_REQUEST["orderAmount"];              //交易金额
        $Result = $_REQUEST["orderInfo"];     //交易详情
        $signInfo = $_REQUEST["signInfo"];
        $remark = $_REQUEST["remark"];
        $riskInfo = $_REQUEST["riskInfo"];

        //是否推送，isPush:1则是推送，为空则是POST返回
        $isPush = isset($_REQUEST['isPush']) AND $_REQUEST['isPush'] == '1' ? '1' : '';
        if ($isPush == '1')
        {
            if (substr($Result, 0, 5) == 'I0061')  //排除订单号重复(I0061)的交易
            {

            }
            else
            {
                $order_id = Order::get_from_ordernum($BillNo);
                $order = Order::instance($order_id)->get();
                if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                {
                    exit;
                }

//                                $success = DB::select('id')->from('orders_orderpayments')
//                                        ->where('order_id', '=', $order_id)
//                                        ->and_where('payment_method', '=', 'globebill')
//                                        ->and_where('payment_status', '=', 'success')
//                                        ->execute();
//                                if($success)
//                                {
//                                        exit;
//                                }
                //积分添加
                if ($Succeed)
                {
                    $amounts = $Amount;
                    $order1 = Order::instance(Order::get_from_ordernum($BillNo));

                    // kohana_log::instance()->add('GLOBEBILL_POINTS', $amounts);
                    // if ($amounts > 0)
                    // {
                    //     Event::run('Order.payment', array(
                    //         'amount' => (int) $amounts,
                    //         'order' => $order1,
                    //     ));
                    // }

                    // Product stock Minus
                    $products = Order::instance($order_id)->products();
                    foreach ($products as $product)
                    {
                        $stock = Product::instance($product['product_id'])->get('stock');
                        if ($stock == -1)
                        {
                            $attr = $product['attributes'];
                            $attr = str_replace(';', '', $attr);
                            $attr = str_replace('Size:', '', $attr);
                            $attr = str_replace('size:', '', $attr);
                            $attr = trim($attr);
                            $stocks = DB::select('id', 'stocks')->from('products_stocks')
                                    ->where('product_id', '=', $product['product_id'])
                                    ->where('attributes', 'LIKE', '%' . $attr . '%')
                                    ->execute()->current();
                            if (!empty($stocks))
                            {
                                DB::update('products_stocks')->set(array('stocks' => $stocks['stocks'] - $product['quantity']))->where('id', '=', $stocks['id'])->execute();
                            }
                        }
                    }
                }

                //md5校验码 固定格式：md5($BillNo.$Currency.$Amount.$Succeed.$MD5key)
                //$md5src = $BillNo . $Currency . $Amount . $Succeed . $MD5key;
                //$md5sign = strtoupper(md5($md5src));

                $data = array();
                $data['order_num'] = $BillNo;
                $data['verify_code'] = '';
                $data['trans_id'] = $tradeNo;
                $data['message'] = $Result;
                $data['succeed'] = $Succeed;
                $data['avs'] = '';
                $data['api'] = '';
                $data['status'] = '';
                $data['billing_firstname'] = '';
                $data['billing_lastname'] = '';
                $data['billing_address'] = '';
                $data['billing_zip'] = '';
                $data['billing_city'] = '';
                $data['billing_state'] = '';
                $data['billing_country'] = '';
                $data['billing_ip'] = '';
                $data['billing_email'] = '';
                $data['cardnum'] = '';
                $data['BankID'] = '';
                $data['merno'] = $merNo;
                $data['signInfo'] = $signInfo;
                $data['gatewayNo'] = $gatewayNo;

                $ordernum = $BillNo;
                Payment::instance('GLOBEBILL')->pay($order, $data);
            }
        }
        elseif ($isPush == '')
        {
            if (substr($Result, 0, 5) == 'I0061')  //排除订单号重复(I0061)的交易
            {
                Message::set(__('order_repaid'), 'notice');
                if ($is_pay_insite)
                {
                    echo '<script language="javascript">top.location.replace("' .BASEURL . '/payment/success/' . $BillNo . '");</script>';
                }
                else
                {
                    $this->request->redirect(BASEURL. LANGPATH . '/payment/success/' . $BillNo);
                }
            }
            else
            {
                $order = Order::instance(Order::get_from_ordernum($BillNo))->get();
                if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                {
                    echo '<script language="javascript">top.location.replace("' . BASEURL. '/payment/success/' . $order['ordernum'] . '");</script>';
                    exit;
                }

                switch ($Succeed)
                {
                    case '1':
                        Message::set(__('order_create_success'), 'notice');
                        if ($is_pay_insite)
                        {
                            echo '<script language="javascript">top.location.replace("' . BASEURL . '/payment/success/' . $order['ordernum'] . '");</script>';
                        }
                        else
                        {
                            $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);
                        }
                        break;
                    case '-1':
                    case '-2':
                        if ($is_pay_insite)
                        {
                            echo '<script language="javascript">top.location.replace("' . BASEURL. '/payment/success/' . $order['ordernum'] . '");</script>';
                        }
                        else
                        {
                            $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);
                        }
                        break;
                    case '0':
                        $info = (int) $Result;
                        $messages = array(
                            '3127','3227','3302','3310','3350','9901','9903','9904','9905','9906','9912','9913','9914','9915','9941','9943','9951','9954','9957','9961','9962','9975','9977','9991','99YZ'
                        );
                        $message = in_array($info, $messages) ? __('globebill_message_' . $info) : $Result;
                        Message::set($message, 'error');
                        if ($is_pay_insite)
                        {
                            echo '<script language="javascript">top.location.replace("' . BASEURL . '/order/view/' . $order['ordernum'] . '");</script>';
                        }
                        else
                        {
                            $this->request->redirect(BASEURL . LANGPATH . '/order/view/' . $order['ordernum']);
                        }
                        break;
                }
            }
        }
    }

    public function globebill_return1($return_data)
    {
        Kohana_Log::instance()->add('GLOBEBILL', json_encode($return_data))->write();
        // $a = 'a:15:{s:5:"merNo";s:5:"10040";s:9:"gatewayNo";s:8:"10040001";s:7:"tradeNo";s:22:"2013071103241790698612";s:7:"orderNo";s:11:"10335391340";s:11:"orderAmount";s:5:"77.97";s:13:"orderCurrency";s:3:"USD";s:11:"orderStatus";s:1:"1";s:9:"orderInfo";s:13:"0000_Approved";s:8:"signInfo";s:64:"CD6A7D34E17A814566C6CA33F52EDA7FE4C6CF9CDC72F2AF5E0654178B4F9B14";s:6:"remark";s:0:"";s:8:"riskInfo";s:140:"||sourceUrl=10.0;BinCountry=100.0;BlackList=100.0;Amount=100.0;PayNum=100.0;|0.0|100.0|2.52|monte dei paschi di siena|IT|49|2.224.23.120|IT|";s:14:"authTypeStatus";s:1:"0";s:6:"cardNo";s:13:"525500***0696";s:12:"EbanxBarCode";s:0:"";s:6:"isPush";s:1:"1";}';
        // $return_data = unserialize($a);
        //MD5key和商户id，固定值 商户号为10032，新接口
        $is_pay_insite = Site::instance()->get('is_pay_insite');

        $merNo = $return_data['merNo'];
        $gatewayNo = $return_data['gatewayNo'];
        $tradeNo = $return_data["tradeNo"];  //交易号

        if (!$tradeNo)
        {
            //钱宝拒绝交易，交易号为空
            $this->request->redirect(LANGPATH . '/customer/orders');
            exit;
        }
        $BillNo = $return_data["orderNo"];      //订单号
        $Succeed = $return_data["orderStatus"];            //交易成功状态 1=成功，0=失败 -1 待处理 -2 待确认
        $PayCurrency = $return_data["orderCurrency"];    //币种代码，如：GBP
        $Amount = $return_data["orderAmount"];              //交易金额
        $Result = $return_data["orderInfo"];     //交易详情
        $signInfo = $return_data["signInfo"];
        $remark = $return_data["remark"];
        $riskInfo = $return_data["riskInfo"];

        if (substr($Result, 0, 5) == 'I0061')  //排除订单号重复(I0061)的交易
        {
            Message::set(__('order_repaid'), 'notice');
            if ($is_pay_insite)
            {
                echo '<script language="javascript">top.location.replace("' . BASEURL . '/payment/success/' . $BillNo . '");</script>';
            }
            else
            {
                $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $BillNo);
            }
        }
        else
        {
            $order = Order::instance(Order::get_from_ordernum($BillNo))->get();
            if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
            {
                echo '<script language="javascript">top.location.replace("' . BASEURL . '/payment/success/' . $order['ordernum'] . '");</script>';
                exit;
            }

            $data = array();
            $data['order_num'] = $BillNo;
            $data['verify_code'] = '';
            $data['trans_id'] = $tradeNo;
            $data['message'] = $Result;
            $data['succeed'] = $Succeed;
            $data['avs'] = '';
            $data['api'] = '';
            $data['status'] = '';
            $data['billing_firstname'] = '';
            $data['billing_lastname'] = '';
            $data['billing_address'] = '';
            $data['billing_zip'] = '';
            $data['billing_city'] = '';
            $data['billing_state'] = '';
            $data['billing_country'] = '';
            $data['billing_ip'] = '';
            $data['billing_email'] = '';
            $data['cardnum'] = '';
            $data['BankID'] = '';
            $data['merno'] = $merNo;
            $data['signInfo'] = $signInfo;
            $data['gatewayNo'] = $gatewayNo;

            $ordernum = $BillNo;
            Payment::instance('GLOBEBILL')->pay($order, $data);

            switch ($Succeed)
            {
                case '1':
                    $products = Order::instance($order_id)->products();
                    foreach ($products as $product)
                    {
                        $stock = Product::instance($product['product_id'])->get('stock');
                        if ($stock == -1)
                        {
                            $attr = $product['attributes'];
                            $attr = str_replace(';', '', $attr);
                            $attr = str_replace('Size:', '', $attr);
                            $attr = str_replace('size:', '', $attr);
                            $attr = trim($attr);
                            $stocks = DB::select('id', 'stocks')->from('products_stocks')
                                    ->where('product_id', '=', $product['product_id'])
                                    ->where('attributes', 'LIKE', '%' . $attr . '%')
                                    ->execute()->current();
                            if (!empty($stocks))
                            {
                                DB::update('products_stocks')->set(array('stocks' => $stocks['stocks'] - $product['quantity']))->where('id', '=', $stocks['id'])->execute();
                            }
                        }
                    }
                    Message::set(__('order_create_success'), 'notice');
                    $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);
                    break;
                case '-1':
                case '-2':

                    $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);
                    break;
                case '0':
                    $resultArr = explode(':', $Result);
                    $info = strtolower($resultArr[0]);
                    $messages = array(
                        'declined', '3127','3227','3302','3310','3350','9901','9903','9904','9905','9906','9912','9913','9914','9915','9941','9943','9951','9954','9957','9961','9962','9975','9977','9991','99YZ'
                    );
                    $message = in_array($info, $messages) ? __('globebill_message_' . $info) : $Result;
                    Message::set($message, 'error');
                    $this->request->redirect(BASEURL . LANGPATH . '/order/view/' . $order['ordernum']);
                    break;
            }
        }
    }

    // Payment Synchronization
    public function action_status_return()
    {
        $a = 0;
        for ($i = 0; $i < 1000; $i++)
        {
            for ($j = 0; $j < 2000; $j++)
            {
                $a++;
            }
        } //延迟执行
        $this->auto_render = FALSE;
        Kohana_Log::instance()->add('function Payment status return', json_encode($_POST))->write();
        if (!$_POST['order_num'])
            return FALSE;

        $post = $_POST;
        $order = DB::select()
            ->from('orders_order')
            ->where('ordernum', '=', $post['order_num'])
            ->execute()
            ->current();

        if (!$order['id'])
        {
            $post['order_num'] = substr($post['order_num'], 0, -1);
        }

        $order = DB::select()
            ->from('orders_order')
            ->where('ordernum', '=', $post['order_num'])
            ->execute()
            ->current();
        if (!$order)
            return FALSE;

        $mail_params['order_view_link'] = '<a href="' . BASEURL . '/order/view/' . $post['order_num'] . '">Your order view</a>';
        $mail_params['order_num'] = $post['order_num'];
        $mail_params['email'] = Customer::instance($order['customer_id'])->get('email');
        $mail_params['firstname'] = Customer::instance($order['customer_id'])->get('firstname');
        $api = Arr::get($post, 'api', '');

        switch ($post['payment_status_id'])
        {
            case "4"://Cancel
                $payment_status = 'cancel';
                break;
            case "5"://partial refund
                $mail_params['amount'] = $post['refund_amount'];
                $mail_params['currency'] = $post['currency'];
                $mail_params['payname'] = $api;

                $refund_status = 'partial_refund';
                Mail::SendTemplateMail('REFUND', $mail_params['email'], $mail_params);
                break;
            case "6"://refund
                $mail_params['amount'] = $post['refund_amount'];
                $mail_params['currency'] = $post['currency'];
                $mail_params['payname'] = $api;

                $refund_status = 'refund';
                Mail::SendTemplateMail('REFUND', $mail_params['email'], $mail_params);
                break;
            case "12"://Not passed verification.
                $payment_status = 'verify_failed';
                break;
            case "13"://Banned list
                $payment_status = 'verify_banned';
                break;
            case "26"://Pay success, pass verification.
                $payment_status = 'verify_pass';
                break;
            case "30"://Prepare refund.
                $refund_status = 'prepare_refund';
                break;
            default:
                break;
        }
        $message = "Operator: " . $post['admin_employee_name'] . "\r\n";
        $message .= "Remark: " . $post['context'] . "\r\n";

        // change order payment_status or refund_status
        if (isset($payment_status))
        {
            if ($order['payment_status'] == $payment_status)
            {
                echo "SUCCESS";
                exit;
            }
            $order_update['payment_status'] = $payment_status;
            if ($payment_status == 'verify_pass')
            {
                $order_update['verify_date'] = time();
            }
        }
        elseif (isset($refund_status))
            $order_update['refund_status'] = $refund_status;

//                $ret = Order::instance($order['id'])->set($order_update);
        $ret = DB::update('orders_order')->set($order_update)->where('id', '=', $order['id'])->execute();
        if ($ret)
        {
            Kohana_Log::instance()->add('Update verify pass', 'Success')->write();
            $payment = DB::select('id')->from('orders_orderpayments')
                    ->where('order_id', '=', $order['id'])
                    ->where('payment_status', '=', 'pending')
                    ->where('amount', '<>', 0)
                    ->execute()->get('id');
            if($payment)
            {
                DB::update('orders_orderpayments')->set(array('payment_status' => 'success'))->where('id', '=', $payment)->execute();
            }
        }
        else
            Kohana_Log::instance()->add('Update verify pass', 'Failed')->write();
        Order::instance($order['id'])->add_history(array(
            'order_status' => 'update status',
            'message' => $message,
        ));

        // Payment Log
        $payment_log = array(
            'order_id' => $order['id'],
            'customer_id' => $order['customer_id'],
            'payment_method' => 'CreditPay',
            'trans_id' => $post['trans_id'],
            'amount' => isset($post['refund_amount']) ? $post['refund_amount'] : '',
            'currency' => $order['currency'],
            'comment' => $message,
            'payment_status' => isset($payment_status) ? $payment_status : $refund_status,
            'ip' => ip2long(Request::$client_ip),
            'created' => time(),
        );
        Payment::instance('CC')->log($payment_log);

        // 如果是自动验证，添加自动验证状态 erp_customer_id=1
        if($post['admin_employee_name'] == '系统自动')
        {
            DB::update('orders_order')->set(array('erp_customer_id' => 1))->where('id', '=', $order['id'])->execute();
        }

        echo "SUCCESS";
    }

    public function action_success($ordernum = NULL)
    {
        $languages = Kohana::config('sites.language');
        if(in_array($ordernum, $languages))
        {
            $uri = $this->request->uri;
            $uris = explode('/', $uri);
            $ordernum = $uris[count($uris) - 1];
        }

        if (!$ordernum)
            $this->request->redirect(LANGPATH . '/customer/orders');
        if (!$customer_id = Customer::instance()->logged_in())
        {
            $this->request->redirect(URL::base());
        }

        $p_key = "pmethod_success".$ordernum;
        $pmethod_success = Kohana_Cookie::get($p_key);
        $session_success =  Session::instance()->get($p_key,0);
        if($pmethod_success or $session_success)
        {
            if(empty($pmethod_success))
            {
                $pmethod_success = $session_success;
            }
            $ordernumarr = explode('_', $pmethod_success);
            $ordernum = isset($ordernumarr[1]) ? $ordernumarr[1] : '';
            if($ordernum)
            {
                $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
            }
            else
            {
                $this->request->redirect(LANGPATH . '/customer/orders');
            }
        }
        else
        {
            $p_success = "pmethodsuccess_".$ordernum;
            $p_key = "pmethod_success".$ordernum;
            Kohana_Cookie::set($p_key,$p_success,3600*24*30);
            Session::instance()->set($p_key, $p_success);
        }

        $filters = array('customer_id' => $customer_id, 'ordernum' => $ordernum);

        $order = Order::instance(Order::get_from_ordernum($ordernum));

        if (!$order->get('id'))
        {
            Message::set(__('order_status_pre') . $ordernum . __('order_status_not_exits_suffix'), 'error');
            $this->request->redirect(LANGPATH . '/customer/orders');
        }

        kohana_log::instance()->add('payment_status', $order->get('payment_status'));
        if(in_array($order->get('payment_status'), array('new_s', 'failed')))
        {
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
        //$order['products'] = Order::instance($order['id'])->orderitems();
        $header['refresh'] = '8;url=/order/view/' . $ordernum;
        $orderdata = $order->get();
        $type = "paysuccess";
        $value = round($orderdata['amount'] / $orderdata['rate'], 2);

//begin by L 拼接威睿代码
        $products = DB::select()
            ->from('orders_orderitem')
            // ->where('site_id', '=', $this->site_id)
            ->where('order_id', '=', $orderdata['id'])
            ->execute()
            ->as_array();
        $lang = empty($orderdata['lang'])? 'en' : $orderdata['lang'];

        $vizury = "http://www.vizury.com/analyze/analyze.php?account_id=VIZVRM3203&param=e500&orderid=".$orderdata['id']."&orderprice=".$orderdata['amount_order'];
        for($i=1;$i<=3;$i++){
            $vizury .= "&pid$i=".(empty($products[($i-1)])? '' : $products[($i-1)]['product_id']."_$lang")
                        ."&catid$i=".(empty($products[($i-1)])? '' : Product::instance($products[($i-1)]['product_id'])->get('set_id'))
                        ."&quantity$i=".(empty($products[($i-1)])? '' : $products[($i-1)]['quantity'])
                        ."&price$i=".(empty($products[($i-1)])? '' : $products[($i-1)]['price']);
        }
        $vizury .= "&currency=".$orderdata['currency']."&section=1&level=1";
//end by L 拼接威睿代码        
        $data = array();
        $data['type'] = $type;
        $data['value'] = $value;
        $data['order'] = $orderdata;
        $data['vizury'] = $vizury;
        $data['products'] = $products;
        $data['title'] = '';
        $data['keywords'] = '';
        $data['description'] = '';
        echo View::factory('/payment_success', $data);
        exit();
    }

    public function action_ppec_set()
    {
        Site::instance()->add_clicks('ppec');
        $cart = Cart::get();
        $shipping_price = Arr::get($_POST, 'shipping_price', 0);
        Session::instance()->set('shipping_price', $shipping_price);
        $amount = $cart['amount']['items'] + $shipping_price - $cart['amount']['save'] - $cart['amount']['point'];
        if ($amount <= 0)
        {
            Message::set(__('cart_no_product'));
            $this->request->redirect(LANGPATH . '/cart/view');
        }
        if ($cart['amount']['items'] <= 0)
        {
            Message::set(__('cart_no_product'));
            $this->request->redirect(LANGPATH . '/cart/view');
        }
        $currency = Site::instance()->currency();
        $result = Payment::instance('EC')->set(Site::instance()->price($shipping_price), $currency['name'], $cart['products']);
        if (strtoupper($result['ACK']) == 'SUCCESS')
        {
            $paypal_ec_token = $result['TOKEN'];
            Session::instance()->set('paypal_ec_token', $paypal_ec_token);
            $order_review = true;
            $user_action_key = (int) $order_review == false ? "&useraction=commit" : '';
            $this->request->redirect(Site::instance()->get('pp_payment_url') . "?cmd=_express-checkout&token=" . $paypal_ec_token . $user_action_key);
        }
    }

    public function action_ppec_set1($ordernum)
    {
        $languages = Kohana::config('sites.language');
        if(in_array($ordernum, $languages))
        {
            $uri = $this->request->uri;
            $uris = explode('/', $uri);
            $ordernum = $uris[count($uris) - 1];
        }
        // add ppjump clicks
        Site::instance()->add_clicks('ppjump');

        $order_id = Order::get_from_ordernum($ordernum);
        // echo $order_id;exit;
        if(!$order_id)
        {
            Message::set(__('order_create_failed'), 'error');
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
        $order = Order::instance($order_id)->get();
        $amount = $order['amount'];
        if ($amount <= 0)
        {
            $this->request->redirect(LANGPATH . '/payment/success/' . $ordernum);
        }
        $change_currencies = array('BRL', 'ARS', 'SAR');
        $others = array();
        if(in_array($order['currency'], $change_currencies))
        {
            $others['message'] = "Sorry to inform you that PayPal won't accept your currency " . $order['currency'] . " currently, then your order total has been converted into USD by PayPal.";
            $order['currency'] = 'USD';
            $order['amount'] = round($order['amount'] / $order['rate'], 2);
        }

        $result = Payment::instance('EC')->set1($order, $others);
        if (strtoupper($result['ACK']) == 'SUCCESS')
        {
            $paypal_ec_token = $result['TOKEN'];
            Session::instance()->set('paypal_ec_token', $paypal_ec_token);
            $order_review = false;
            $user_action_key = "&useraction=" . ((int) $order_review == false ? 'commit' : 'continue');
            $this->request->redirect(Site::instance()->get('pp_payment_url') . "?cmd=_express-checkout&token=" . $paypal_ec_token . $user_action_key);
        }
        else
        {
            kohana_log::instance()->add('PPSET1', json_encode($result));
            $message = Arr::get($result, 'L_LONGMESSAGE0', '');
            Message::set($message, 'error');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
    }

    public function action_ppec_set_test($ordernum)
    {
        $languages = Kohana::config('sites.language');
        if(in_array($ordernum, $languages))
        {
            $uri = $this->request->uri;
            $uris = explode('/', $uri);
            $ordernum = $uris[count($uris) - 1];
        }
        $order_id = Order::get_from_ordernum($ordernum);
        // echo $order_id;exit;
        if(!$order_id)
        {
            Message::set(__('order_create_failed'), 'error');
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
        $order = Order::instance($order_id)->get();
        $amount = $order['amount'];
        if ($amount <= 0)
        {
            $this->request->redirect(LANGPATH . '/payment/success/' . $ordernum);
        }
        $change_currencies = array('BRL', 'ARS', 'SAR');
        $others = array();
        if(in_array($order['currency'], $change_currencies))
        {
            $others['message'] = "Sorry to inform you that PayPal won't accept your currency " . $order['currency'] . " currently, then your order total has been converted into USD by PayPal.";
            $order['currency'] = 'USD';
            $order['amount'] = round($order['amount'] / $order['rate'], 2);
        }
        $result = Payment::instance('ECTEST')->set1($order, $others);
        if (strtoupper($result['ACK']) == 'SUCCESS')
        {
            $paypal_ec_token = $result['TOKEN'];
            Session::instance()->set('paypal_ec_token', $paypal_ec_token);
            $order_review = false;
            $user_action_key = "&useraction=" . ((int) $order_review == false ? 'commit' : 'continue');
            $this->request->redirect("https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=" . $paypal_ec_token . $user_action_key);
        }
        else
        {
            kohana_log::instance()->add('PPSET1', json_encode($result));
            $message = Arr::get($result, 'L_LONGMESSAGE0', '');
            Message::set($message, 'error');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
    }

    public function action_ppec_response()
    {
//                $token = 'EC-4K939410JT380004G';
//                $result1 = 'a:21:{s:5:"TOKEN";s:20:"EC-4K939410JT380004G";s:9:"TIMESTAMP";s:20:"2013-02-17T08:55:17Z";s:13:"CORRELATIONID";s:12:"342c4d0a789c";s:3:"ACK";s:7:"Success";s:7:"VERSION";s:3:"3.0";s:5:"BUILD";s:7:"5060305";s:5:"EMAIL";s:22:"shijiangming09@163.com";s:7:"PAYERID";s:13:"P3JSDNXFUXJEC";s:11:"PAYERSTATUS";s:10:"unverified";s:9:"FIRSTNAME";s:4:"hill";s:8:"LASTNAME";s:5:"jimmy";s:11:"COUNTRYCODE";s:2:"CN";s:10:"SHIPTONAME";s:10:"hill jimmy";s:12:"SHIPTOSTREET";s:6:"baixia";s:13:"SHIPTOSTREET2";s:5:"jimmy";s:10:"SHIPTOCITY";s:7:"nanjing";s:11:"SHIPTOSTATE";s:7:"Jiangsu";s:9:"SHIPTOZIP";s:6:"210000";s:17:"SHIPTOCOUNTRYCODE";s:2:"CN";s:17:"SHIPTOCOUNTRYNAME";s:5:"China";s:13:"ADDRESSSTATUS";s:11:"Unconfirmed";}';
//                $result = unserialize($result1);
        $token = Session::instance()->get('paypal_ec_token');
        $result = Payment::instance('EC')->get($token);
        kohana_log::instance()->add('ppec', json_encode($result));
        // If customer has registed by his paypal email, then login. Else regist a new account by paypal infomation.
        if (!($customer_id = Customer::logged_in()))
        {
            if (Customer::instance()->is_register($result['EMAIL']) == 0)
            {
                $data = array();
                $data['email'] = Arr::get($result, 'EMAIL', '');
                $data['firstname'] = Arr::get($result, 'FIRSTNAME', '');
                $data['lastname'] = Arr::get($result, 'LASTNAME', '');
                $data['password'] = Arr::get($result, 'PAYERID', '');
                $data['ip'] = ip2long(Request::$client_ip);
                $data['ppec_status'] = 0;
                $customer_id = Customer::instance()->set($data);
                Customer::instance($customer_id)->login_action();
                // mail to customer the infomation of the new account.
                $mail_params['password'] = $data['password'];
                $mail_params['email'] = $data['email'];
                $mail_params['firstname'] = $data['firstname'];
                Mail::SendTemplateMail('NEWREGISTER', $data['email'], $mail_params);
            }
            else
            {
                $customer_id = Customer::instance()->is_register($result['EMAIL']);
                Customer::instance($customer_id)->login_action();
            }
        }
        $shipping = array(
            'shipping_address_id' => 'new',
            'shipping_firstname' => $result['FIRSTNAME'],
            'shipping_lastname' => $result['LASTNAME'],
            'shipping_address' => $result['SHIPTOSTREET'] . ' ' . $result['SHIPTOSTREET2'],
            'shipping_city' => $result['SHIPTOCITY'],
            'shipping_state' => $result['SHIPTOSTATE'],
            'shipping_country' => $result['SHIPTOCOUNTRYCODE'],
            'shipping_zip' => $result['SHIPTOZIP'],
            'shipping_phone' => $result['PHONENUM'],
            'shipping_method' => 39
        );
        Cart::shipping_billing($shipping);

        $o = Request::factory('order/set')->execute()->response;
        $order = $o->get();
        $result1 = Payment::instance('EC')->go($order, $result['PAYERID'], $token);

        kohana_log::instance()->add('ppec_return', json_encode($result1));

        // Product stock Minus
        $products = unserialize($order['products']);
        foreach ($products as $product)
        {
            $stock = Product::instance($product['id'])->get('stock');
            if ($stock != -99 AND $stock > 0)
            {
                DB::update('products')->set(array('stock' => $stock - $product['quantity']))->where('id', '=', $product['id'])->execute();
            }
        }

        $this->request->redirect(LANGPATH . '/payment/success/' . $order['ordernum']);
    }

    public function action_ppec_response1()
    {
        // $token = 'EC-5TY72116LT056413R';
        // $result1 = 'a:71:{s:5:"TOKEN";s:20:"EC-5TY72116LT056413R";s:8:"PHONENUM";s:15:"+86 15850610942";s:30:"BILLINGAGREEMENTACCEPTEDSTATUS";s:1:"0";s:14:"CHECKOUTSTATUS";s:25:"PaymentActionNotInitiated";s:9:"TIMESTAMP";s:20:"2014-09-04T01:51:36Z";s:13:"CORRELATIONID";s:13:"4cc44b67d05bf";s:3:"ACK";s:7:"Success";s:7:"VERSION";s:4:"65.1";s:5:"BUILD";s:8:"12658619";s:5:"EMAIL";s:22:"shijiangming09@163.com";s:7:"PAYERID";s:13:"P3JSDNXFUXJEC";s:11:"PAYERSTATUS";s:10:"unverified";s:9:"FIRSTNAME";s:4:"hill";s:8:"LASTNAME";s:5:"jimmy";s:11:"COUNTRYCODE";s:2:"CN";s:10:"SHIPTONAME";s:10:"jimmy hill";s:12:"SHIPTOSTREET";s:24:"baixia sifang 09 02 #602";s:10:"SHIPTOCITY";s:6:"南京";s:11:"SHIPTOSTATE";s:10:"QUEENSLAND";s:9:"SHIPTOZIP";s:5:"jimmy";s:17:"SHIPTOCOUNTRYCODE";s:2:"CN";s:17:"SHIPTOCOUNTRYNAME";s:5:"China";s:13:"ADDRESSSTATUS";s:11:"Unconfirmed";s:12:"CURRENCYCODE";s:3:"USD";s:3:"AMT";s:4:"0.01";s:7:"ITEMAMT";s:5:"20.99";s:11:"SHIPPINGAMT";s:5:"15.00";s:11:"HANDLINGAMT";s:4:"0.00";s:6:"TAXAMT";s:4:"0.00";s:6:"INVNUM";s:11:"11272811340";s:12:"INSURANCEAMT";s:4:"0.00";s:11:"SHIPDISCAMT";s:6:"-35.98";s:7:"L_NAME0";s:43:"White Grid Sleeve T-shirt With Sunday Print";s:9:"L_NUMBER0";s:8:"CTPY0009";s:6:"L_QTY0";s:1:"1";s:9:"L_TAXAMT0";s:4:"0.00";s:6:"L_AMT0";s:5:"20.99";s:7:"L_DESC0";s:14:"Size:one size;";s:18:"L_ITEMWEIGHTVALUE0";s:10:"   0.00000";s:18:"L_ITEMLENGTHVALUE0";s:10:"   0.00000";s:17:"L_ITEMWIDTHVALUE0";s:10:"   0.00000";s:18:"L_ITEMHEIGHTVALUE0";s:10:"   0.00000";s:29:"PAYMENTREQUEST_0_CURRENCYCODE";s:3:"USD";s:20:"PAYMENTREQUEST_0_AMT";s:4:"0.01";s:24:"PAYMENTREQUEST_0_ITEMAMT";s:5:"20.99";s:28:"PAYMENTREQUEST_0_SHIPPINGAMT";s:5:"15.00";s:28:"PAYMENTREQUEST_0_HANDLINGAMT";s:4:"0.00";s:23:"PAYMENTREQUEST_0_TAXAMT";s:4:"0.00";s:23:"PAYMENTREQUEST_0_INVNUM";s:11:"11272811340";s:29:"PAYMENTREQUEST_0_INSURANCEAMT";s:4:"0.00";s:28:"PAYMENTREQUEST_0_SHIPDISCAMT";s:6:"-35.98";s:39:"PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED";s:5:"false";s:27:"PAYMENTREQUEST_0_SHIPTONAME";s:10:"jimmy hill";s:29:"PAYMENTREQUEST_0_SHIPTOSTREET";s:24:"baixia sifang 09 02 #602";s:27:"PAYMENTREQUEST_0_SHIPTOCITY";s:6:"南京";s:28:"PAYMENTREQUEST_0_SHIPTOSTATE";s:10:"QUEENSLAND";s:26:"PAYMENTREQUEST_0_SHIPTOZIP";s:5:"jimmy";s:34:"PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE";s:2:"CN";s:34:"PAYMENTREQUEST_0_SHIPTOCOUNTRYNAME";s:5:"China";s:30:"PAYMENTREQUEST_0_ADDRESSSTATUS";s:11:"Unconfirmed";s:24:"L_PAYMENTREQUEST_0_NAME0";s:43:"White Grid Sleeve T-shirt With Sunday Print";s:26:"L_PAYMENTREQUEST_0_NUMBER0";s:8:"CTPY0009";s:23:"L_PAYMENTREQUEST_0_QTY0";s:1:"1";s:26:"L_PAYMENTREQUEST_0_TAXAMT0";s:4:"0.00";s:23:"L_PAYMENTREQUEST_0_AMT0";s:5:"20.99";s:24:"L_PAYMENTREQUEST_0_DESC0";s:14:"Size:one size;";s:35:"L_PAYMENTREQUEST_0_ITEMWEIGHTVALUE0";s:10:"   0.00000";s:35:"L_PAYMENTREQUEST_0_ITEMLENGTHVALUE0";s:10:"   0.00000";s:34:"L_PAYMENTREQUEST_0_ITEMWIDTHVALUE0";s:10:"   0.00000";s:35:"L_PAYMENTREQUEST_0_ITEMHEIGHTVALUE0";s:10:"   0.00000";s:30:"PAYMENTREQUESTINFO_0_ERRORCODE";s:1:"0";}';
        // $result = unserialize($result1);
        $token = Session::instance()->get('paypal_ec_token');
        $result = Payment::instance('EC')->get($token);
        kohana_log::instance()->add('ppec', json_encode($result));
        // If customer has registed by his paypal email, then login. Else regist a new account by paypal infomation.
        $ordernum = Arr::get($result, 'INVNUM', '');
        $order_id = Order::get_from_ordernum($ordernum);
        if($order_id)
        {
            $order = Order::instance($order_id)->get();
            $result1 = Payment::instance('EC')->go($order, $result['PAYERID'], $token, 1);

            kohana_log::instance()->add('ppec_return', json_encode($result1));

            $resultstatus = '';
            if(isset($result1['PAYMENTSTATUS']))
            {
                $resultstatus = $result1['PAYMENTSTATUS'];
            }
            if($resultstatus == 'Completed')
            {
                $this->request->redirect(LANGPATH . '/payment/success/' . $order['ordernum']);
            }
            else
            {
                $code = Arr::get($result1, 'L_ERRORCODE0', 0);
                if($code == 10486)
                {
                    $this->request->redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $token);
                }

                if(isset($result1['L_LONGMESSAGE0']))
                    Message::set($result1['L_LONGMESSAGE0'], 'error');
                $this->request->redirect(LANGPATH . '/customer/orders');
            }
        }
        else
        {
            Message::set(__('order_create_failed'), 'error');
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
    }


    public function action_ppec_response_test()
    {
        // $token = 'EC-5TY72116LT056413R';
        // $result1 = 'a:71:{s:5:"TOKEN";s:20:"EC-5TY72116LT056413R";s:8:"PHONENUM";s:15:"+86 15850610942";s:30:"BILLINGAGREEMENTACCEPTEDSTATUS";s:1:"0";s:14:"CHECKOUTSTATUS";s:25:"PaymentActionNotInitiated";s:9:"TIMESTAMP";s:20:"2014-09-04T01:51:36Z";s:13:"CORRELATIONID";s:13:"4cc44b67d05bf";s:3:"ACK";s:7:"Success";s:7:"VERSION";s:4:"65.1";s:5:"BUILD";s:8:"12658619";s:5:"EMAIL";s:22:"shijiangming09@163.com";s:7:"PAYERID";s:13:"P3JSDNXFUXJEC";s:11:"PAYERSTATUS";s:10:"unverified";s:9:"FIRSTNAME";s:4:"hill";s:8:"LASTNAME";s:5:"jimmy";s:11:"COUNTRYCODE";s:2:"CN";s:10:"SHIPTONAME";s:10:"jimmy hill";s:12:"SHIPTOSTREET";s:24:"baixia sifang 09 02 #602";s:10:"SHIPTOCITY";s:6:"南京";s:11:"SHIPTOSTATE";s:10:"QUEENSLAND";s:9:"SHIPTOZIP";s:5:"jimmy";s:17:"SHIPTOCOUNTRYCODE";s:2:"CN";s:17:"SHIPTOCOUNTRYNAME";s:5:"China";s:13:"ADDRESSSTATUS";s:11:"Unconfirmed";s:12:"CURRENCYCODE";s:3:"USD";s:3:"AMT";s:4:"0.01";s:7:"ITEMAMT";s:5:"20.99";s:11:"SHIPPINGAMT";s:5:"15.00";s:11:"HANDLINGAMT";s:4:"0.00";s:6:"TAXAMT";s:4:"0.00";s:6:"INVNUM";s:11:"11272811340";s:12:"INSURANCEAMT";s:4:"0.00";s:11:"SHIPDISCAMT";s:6:"-35.98";s:7:"L_NAME0";s:43:"White Grid Sleeve T-shirt With Sunday Print";s:9:"L_NUMBER0";s:8:"CTPY0009";s:6:"L_QTY0";s:1:"1";s:9:"L_TAXAMT0";s:4:"0.00";s:6:"L_AMT0";s:5:"20.99";s:7:"L_DESC0";s:14:"Size:one size;";s:18:"L_ITEMWEIGHTVALUE0";s:10:"   0.00000";s:18:"L_ITEMLENGTHVALUE0";s:10:"   0.00000";s:17:"L_ITEMWIDTHVALUE0";s:10:"   0.00000";s:18:"L_ITEMHEIGHTVALUE0";s:10:"   0.00000";s:29:"PAYMENTREQUEST_0_CURRENCYCODE";s:3:"USD";s:20:"PAYMENTREQUEST_0_AMT";s:4:"0.01";s:24:"PAYMENTREQUEST_0_ITEMAMT";s:5:"20.99";s:28:"PAYMENTREQUEST_0_SHIPPINGAMT";s:5:"15.00";s:28:"PAYMENTREQUEST_0_HANDLINGAMT";s:4:"0.00";s:23:"PAYMENTREQUEST_0_TAXAMT";s:4:"0.00";s:23:"PAYMENTREQUEST_0_INVNUM";s:11:"11272811340";s:29:"PAYMENTREQUEST_0_INSURANCEAMT";s:4:"0.00";s:28:"PAYMENTREQUEST_0_SHIPDISCAMT";s:6:"-35.98";s:39:"PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED";s:5:"false";s:27:"PAYMENTREQUEST_0_SHIPTONAME";s:10:"jimmy hill";s:29:"PAYMENTREQUEST_0_SHIPTOSTREET";s:24:"baixia sifang 09 02 #602";s:27:"PAYMENTREQUEST_0_SHIPTOCITY";s:6:"南京";s:28:"PAYMENTREQUEST_0_SHIPTOSTATE";s:10:"QUEENSLAND";s:26:"PAYMENTREQUEST_0_SHIPTOZIP";s:5:"jimmy";s:34:"PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE";s:2:"CN";s:34:"PAYMENTREQUEST_0_SHIPTOCOUNTRYNAME";s:5:"China";s:30:"PAYMENTREQUEST_0_ADDRESSSTATUS";s:11:"Unconfirmed";s:24:"L_PAYMENTREQUEST_0_NAME0";s:43:"White Grid Sleeve T-shirt With Sunday Print";s:26:"L_PAYMENTREQUEST_0_NUMBER0";s:8:"CTPY0009";s:23:"L_PAYMENTREQUEST_0_QTY0";s:1:"1";s:26:"L_PAYMENTREQUEST_0_TAXAMT0";s:4:"0.00";s:23:"L_PAYMENTREQUEST_0_AMT0";s:5:"20.99";s:24:"L_PAYMENTREQUEST_0_DESC0";s:14:"Size:one size;";s:35:"L_PAYMENTREQUEST_0_ITEMWEIGHTVALUE0";s:10:"   0.00000";s:35:"L_PAYMENTREQUEST_0_ITEMLENGTHVALUE0";s:10:"   0.00000";s:34:"L_PAYMENTREQUEST_0_ITEMWIDTHVALUE0";s:10:"   0.00000";s:35:"L_PAYMENTREQUEST_0_ITEMHEIGHTVALUE0";s:10:"   0.00000";s:30:"PAYMENTREQUESTINFO_0_ERRORCODE";s:1:"0";}';
        // $result = unserialize($result1);
        $token = Session::instance()->get('paypal_ec_token');
        $result = Payment::instance('ECTEST')->get($token);
        kohana_log::instance()->add('ppec', json_encode($result));
        // If customer has registed by his paypal email, then login. Else regist a new account by paypal infomation.
        $ordernum = Arr::get($result, 'INVNUM', '');
        $order_id = Order::get_from_ordernum($ordernum);
        if($order_id)
        {
            $order = Order::instance($order_id)->get();
            $result1 = Payment::instance('ECTEST')->go($order, $result['PAYERID'], $token, 1);

            kohana_log::instance()->add('ppec_return', json_encode($result1));
            if($result1['PAYMENTSTATUS'] == 'Completed')
            {
                $this->request->redirect(LANGPATH . '/payment/success/' . $order['ordernum']);
            }
            else
            {
                $code = Arr::get($result1, 'L_ERRORCODE0', 0);
                if($code == 10486)
                {
                    $this->request->redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $token);
                }

                if(isset($result1['L_LONGMESSAGE0']))
                    Message::set($result1['L_LONGMESSAGE0'], 'error');
                $this->request->redirect(LANGPATH . '/customer/order');
            }
        }
        else
        {
            Message::set(__('order_create_failed'), 'error');
            $this->request->redirect(LANGPATH . '/customer/order');
        }
    }

    public function action_ppec_notify()
    {
        // $r = 'a:41:{s:8:"mc_gross";s:4:"0.01";s:7:"invoice";s:11:"11272821340";s:22:"protection_eligibility";s:8:"Eligible";s:14:"address_status";s:11:"unconfirmed";s:8:"payer_id";s:13:"P3JSDNXFUXJEC";s:3:"tax";s:4:"0.00";s:14:"address_street";s:17:"asdfasf asf asdaf";s:12:"payment_date";s:25:"19:34:32 Sep 03, 2014 PDT";s:14:"payment_status";s:9:"Completed";s:7:"charset";s:5:"UTF-8";s:11:"address_zip";s:5:"08650";s:10:"first_name";s:4:"hill";s:6:"mc_fee";s:4:"0.01";s:20:"address_country_code";s:2:"CA";s:12:"address_name";s:8:"Luca Mim";s:14:"notify_version";s:3:"3.8";s:6:"custom";s:0:"";s:12:"payer_status";s:10:"unverified";s:15:"address_country";s:6:"Canada";s:12:"address_city";s:5:"wuxi1";s:8:"quantity";s:1:"1";s:11:"verify_sign";s:56:"AxY4PZnLwHn-wCsVYatnHp9kp4-PAMUHsfFXiSWAccUnHaQfhHM-yU1R";s:11:"payer_email";s:22:"shijiangming09@163.com";s:13:"contact_phone";s:15:"+86 15850610942";s:6:"txn_id";s:17:"69193491SL6766010";s:12:"payment_type";s:7:"instant";s:9:"last_name";s:5:"jimmy";s:13:"address_state";s:7:"ONTARIO";s:14:"receiver_email";s:17:"paypal@choies.com";s:11:"payment_fee";s:4:"0.01";s:11:"receiver_id";s:13:"2M9SCQX9PGW8C";s:8:"txn_type";s:16:"express_checkout";s:9:"item_name";s:0:"";s:11:"mc_currency";s:3:"USD";s:11:"item_number";s:0:"";s:17:"residence_country";s:2:"CN";s:15:"handling_amount";s:4:"0.00";s:19:"transaction_subject";s:0:"";s:13:"payment_gross";s:4:"0.01";s:8:"shipping";s:4:"0.00";s:12:"ipn_track_id";s:13:"fb12a5debb434";}';
        // $_REQUEST = unserialize($r);
        Kohana_Log::instance()->add('PPEC', serialize($_REQUEST))->write();
        $trans_id = Arr::get($_REQUEST, 'txn_id', '');
        $has = DB::select('id')->from('orders_orderpayments')->where('trans_id', '=', $trans_id)->execute()->get('id');
        if ($has)
        {
            exit;
        }
        $data = $_REQUEST;
        $data['first_name'] = Arr::get($data, 'first_name', '');
        $data['last_name'] = Arr::get($data, 'last_name', '');
        $data['address_street'] = Arr::get($data, 'address_street', '');
        $data['address_zip'] = Arr::get($data, 'address_zip', '');
        $data['address_city'] = Arr::get($data, 'address_city', '');
        $data['address_state'] = Arr::get($data, 'address_state', '');
        $data['address_country_code'] = Arr::get($data, 'address_country_code', '');
        if (isset($_REQUEST['invoice']))
        {
            $order_id = Order::instance()->get_from_ordernum($_REQUEST['invoice']);
            $order = Order::instance($order_id)->get();
            // TODO Coupon Limit -1
            if ($coupon = Cart::coupon())
            {
                Coupon::instance($coupon)->apply();
            }

            // Product stock Minus
            $products = unserialize($order['products']);
            foreach ($products as $product)
            {
                $stock = Product::instance($product['id'])->get('stock');
                if ($stock != -99 AND $stock > 0)
                {
                    DB::update('products')->set(array('stock' => $stock - $product['quantity']))->where('id', '=', $product['id'])->execute();
                }
            }

            echo Payment::instance('EC')->pay($order, $data);
        }
        else
        {
            echo 'FAIL';
        }
    }

    public function action_ppec_notify1()
    {
        // $r = 'a:41:{s:8:"mc_gross";s:4:"0.01";s:7:"invoice";s:11:"11272821340";s:22:"protection_eligibility";s:8:"Eligible";s:14:"address_status";s:11:"unconfirmed";s:8:"payer_id";s:13:"P3JSDNXFUXJEC";s:3:"tax";s:4:"0.00";s:14:"address_street";s:17:"asdfasf asf asdaf";s:12:"payment_date";s:25:"19:34:32 Sep 03, 2014 PDT";s:14:"payment_status";s:9:"Completed";s:7:"charset";s:5:"UTF-8";s:11:"address_zip";s:5:"08650";s:10:"first_name";s:4:"hill";s:6:"mc_fee";s:4:"0.01";s:20:"address_country_code";s:2:"CA";s:12:"address_name";s:8:"Luca Mim";s:14:"notify_version";s:3:"3.8";s:6:"custom";s:0:"";s:12:"payer_status";s:10:"unverified";s:15:"address_country";s:6:"Canada";s:12:"address_city";s:5:"wuxi1";s:8:"quantity";s:1:"1";s:11:"verify_sign";s:56:"AxY4PZnLwHn-wCsVYatnHp9kp4-PAMUHsfFXiSWAccUnHaQfhHM-yU1R";s:11:"payer_email";s:22:"shijiangming09@163.com";s:13:"contact_phone";s:15:"+86 15850610942";s:6:"txn_id";s:17:"69193491SL6766010";s:12:"payment_type";s:7:"instant";s:9:"last_name";s:5:"jimmy";s:13:"address_state";s:7:"ONTARIO";s:14:"receiver_email";s:17:"paypal@choies.com";s:11:"payment_fee";s:4:"0.01";s:11:"receiver_id";s:13:"2M9SCQX9PGW8C";s:8:"txn_type";s:16:"express_checkout";s:9:"item_name";s:0:"";s:11:"mc_currency";s:3:"USD";s:11:"item_number";s:0:"";s:17:"residence_country";s:2:"CN";s:15:"handling_amount";s:4:"0.00";s:19:"transaction_subject";s:0:"";s:13:"payment_gross";s:4:"0.01";s:8:"shipping";s:4:"0.00";s:12:"ipn_track_id";s:13:"fb12a5debb434";}';
        // $_REQUEST = unserialize($r);
        Kohana_Log::instance()->add('PPEC', serialize($_REQUEST))->write();
        $trans_id = Arr::get($_REQUEST, 'txn_id', '');
        $has = DB::select('id')->from('orders_orderpayments')->where('trans_id', '=', $trans_id)->execute()->get('id');
        if ($has)
        {
            exit;
        }
        $data = $_REQUEST;
        $data['first_name'] = Arr::get($data, 'first_name', '');
        $data['last_name'] = Arr::get($data, 'last_name', '');
        $data['address_street'] = Arr::get($data, 'address_street', '');
        $data['address_zip'] = Arr::get($data, 'address_zip', '');
        $data['address_city'] = Arr::get($data, 'address_city', '');
        $data['address_state'] = Arr::get($data, 'address_state', '');
        $data['address_country_code'] = Arr::get($data, 'address_country_code', '');
        if ($_REQUEST['invoice'])
        {
            $order_id = Order::instance()->get_from_ordernum($_REQUEST['invoice']);
            $order = Order::instance($order_id)->get();
            // TODO Coupon Limit -1
            if ($coupon = Cart::coupon())
            {
                Coupon::instance($coupon)->apply();
            }

            // Product stock Minus
            $products = unserialize($order['products']);
            foreach ($products as $product)
            {
                $stock = Product::instance($product['id'])->get('stock');
                if ($stock != -99 AND $stock > 0)
                {
                    DB::update('products')->set(array('stock' => $stock - $product['quantity']))->where('id', '=', $product['id'])->execute();
                }
            }

            echo Payment::instance('EC')->pay($order, $data);

            if($data['payment_status'] == 'Completed')
            {
                $amount = $order['amount_products'];
                // if ($amount > 0)
                // {
                //     Event::run('Order.payment', array(
                //         'amount' => $amount,
                //         'order' => Order::instance($order_id),
                //     ));
                // }

                //set mail
                $customer_id = $order['customer_id'];
                $ppec_status = Customer::instance($customer_id)->get('ppec_status');
                if($ppec_status == 0)
                {
                    $mail_params = array();
                    $mail_params['email'] = $order['email'];
                    $mail_params['firstname'] = $order['shipping_firstname'];
                    $mail_params['password'] = $data['payer_id'];
                    $mail_params['expired'] = date('Y-m-d', time() + 30 * 86400);
                    $points = 0;
                    $currencys = Site::instance()->currencies();
                    $porders = DB::select('amount', 'currency')->from('orders_order')->where('customer_id', '=', $customer_id)->where('payment_status', '=', 'verify_pass')->execute();
                    foreach($porders as $key => $o)
                    {
                        if($key == 0)
                            $points = 1000;
                        else
                            $points += floor($o['amount'] / $currencys[$o['currency']]['rate']);
                    }
                    if($points > 0)
                        $points += floor($order['amount'] / $currencys[$order['currency']]['rate']);
                    else
                        $points = 1000;
                    $mail_params['Points'] = $points;
                    $mail_params['Value'] = $points / 100;
                    Mail::SendTemplateMail('PP Newly Created Account', $mail_params['email'], $mail_params);
                }
            }
        }
        else
        {
            echo 'FAIL';
        }
    }

    public function action_ppec_notify_test()
    {
         $r = 'a:43:{s:10:"kohana_uri";s:20:"/payment/ppec_notify";s:8:"mc_gross";s:5:"22.09";s:7:"invoice";s:11:"18705141341";s:22:"protection_eligibility";s:8:"Eligible";s:14:"address_status";s:9:"confirmed";s:8:"payer_id";s:13:"CWCMQPW4SY2MJ";s:3:"tax";s:4:"0.00";s:14:"address_street";s:14:"1 Dixon street";s:12:"payment_date";s:25:"01:08:46 Feb 26, 2017 PST";s:14:"payment_status";s:9:"Completed";s:7:"charset";s:6:"gb2312";s:11:"address_zip";s:6:"ML54HS";s:10:"first_name";s:8:"Daniella";s:6:"mc_fee";s:4:"1.02";s:20:"address_country_code";s:2:"GB";s:12:"address_name";s:15:"Daniella Bryand";s:14:"notify_version";s:3:"3.8";s:6:"custom";s:0:"";s:12:"payer_status";s:8:"verified";s:8:"business";s:26:"makecollections@choies.com";s:15:"address_country";s:14:"United Kingdom";s:12:"address_city";s:10:"Coatbridge";s:8:"quantity";s:1:"1";s:11:"verify_sign";s:56:"AMmBnrHtWGvSkk06jUOpWl63TjWcArXihZL4JEGyLYkIdUwuA81lbI2y";s:11:"payer_email";s:26:"daniellabryanz@yahoo.co.uk";s:13:"contact_phone";s:14:"+44 1236425624";s:6:"txn_id";s:17:"2KG92894W76265321";s:12:"payment_type";s:7:"instant";s:9:"last_name";s:6:"Bryans";s:13:"address_state";s:11:"Lanarkshire";s:14:"receiver_email";s:26:"makecollections@choies.com";s:11:"payment_fee";s:0:"";s:11:"receiver_id";s:13:"WUB6TBGG5T53U";s:8:"txn_type";s:16:"express_checkout";s:9:"item_name";s:0:"";s:11:"mc_currency";s:3:"GBP";s:11:"item_number";s:0:"";s:17:"residence_country";s:2:"GB";s:15:"handling_amount";s:4:"0.00";s:19:"transaction_subject";s:0:"";s:13:"payment_gross";s:0:"";s:8:"shipping";s:4:"0.00";s:12:"ipn_track_id";s:13:"c32138fce083c";}';
        // $r = 'a:43:{s:10:"kohana_uri";s:20:"/payment/ppec_notify";s:8:"mc_gross";s:5:"20.89";s:7:"invoice";s:11:"18706451341";s:22:"protection_eligibility";s:8:"Eligible";s:14:"address_status";s:9:"confirmed";s:8:"payer_id";s:13:"EQ2FLX8PJBA3Q";s:3:"tax";s:4:"0.00";s:14:"address_street";s:18:"1016 bayswater Ave";s:12:"payment_date";s:25:"19:48:23 Feb 26, 2017 PST";s:14:"payment_status";s:9:"Completed";s:7:"charset";s:6:"gb2312";s:11:"address_zip";s:5:"94401";s:10:"first_name";s:8:"Danielle";s:6:"mc_fee";s:4:"1.07";s:20:"address_country_code";s:2:"US";s:12:"address_name";s:16:"Danielle  Cronin";s:14:"notify_version";s:3:"3.8";s:6:"custom";s:0:"";s:12:"payer_status";s:10:"unverified";s:8:"business";s:26:"makecollections@choies.com";s:15:"address_country";s:13:"United States";s:12:"address_city";s:9:"SAN Mateo";s:8:"quantity";s:1:"1";s:11:"verify_sign";s:56:"ABz2Di8Yxx0StYSrc51Z99pvnLO2AEuXcZAeiPGux2CQF17PVchF5qjA";s:11:"payer_email";s:23:"ddevencenzi11@gmail.com";s:13:"contact_phone";s:12:"650-346-7214";s:6:"txn_id";s:17:"7R4228710S5532739";s:12:"payment_type";s:7:"instant";s:9:"last_name";s:6:"Cronin";s:13:"address_state";s:10:"CALIFORNIA";s:14:"receiver_email";s:26:"makecollections@choies.com";s:11:"payment_fee";s:4:"1.07";s:11:"receiver_id";s:13:"WUB6TBGG5T53U";s:8:"txn_type";s:16:"express_checkout";s:9:"item_name";s:0:"";s:11:"mc_currency";s:3:"USD";s:11:"item_number";s:0:"";s:17:"residence_country";s:2:"US";s:15:"handling_amount";s:4:"0.00";s:19:"transaction_subject";s:0:"";s:13:"payment_gross";s:5:"20.89";s:8:"shipping";s:4:"0.00";s:12:"ipn_track_id";s:13:"f142477a19d7c";}';
         $_REQUEST = unserialize($r);
        Kohana_Log::instance()->add('PPEC_test', serialize($_REQUEST))->write();
        $trans_id = Arr::get($_REQUEST, 'txn_id', '');
//        $has = DB::select('id')->from('orders_orderpayments')->where('trans_id', '=', $trans_id)->execute()->get('id');
//        if ($has)
//        {
//            exit;
//        }
        $data = $_REQUEST;
        $data['first_name'] = Arr::get($data, 'first_name', '');
        $data['last_name'] = Arr::get($data, 'last_name', '');
        $data['address_street'] = Arr::get($data, 'address_street', '');
        $data['address_zip'] = Arr::get($data, 'address_zip', '');
        $data['address_city'] = Arr::get($data, 'address_city', '');
        $data['address_state'] = Arr::get($data, 'address_state', '');
        $data['address_country_code'] = Arr::get($data, 'address_country_code', '');
        kohana::$log->add('payment_test1',1);
        if ($_REQUEST['invoice'])
        {
            $order_id = Order::instance()->get_from_ordernum($_REQUEST['invoice']);
            $order = Order::instance($order_id)->get();
            // TODO Coupon Limit -1
            if ($coupon = Cart::coupon())
            {
                Coupon::instance($coupon)->apply();
            }

            // Product stock Minus
            $products = unserialize($order['products']);
            foreach ($products as $product)
            {
                $stock = Product::instance($product['id'])->get('stock');
                if ($stock != -99 AND $stock > 0)
                {
                    DB::update('products')->set(array('stock' => $stock - $product['quantity']))->where('id', '=', $product['id'])->execute();
                }
            }
            kohana::$log->add('payment_test1',2);
            echo Payment::instance('ECTEST')->pay($order, $data);
        }
        else
        {
            echo 'FAIL';
        }
    }

    public function action_ppec_confirm()
    {
        if($_POST)
        {
            $token = Arr::get($_POST, 'token', '');
            $payerid = Arr::get($_POST, 'payerid', '');
            $cart = Cart::get();
            if($cart['amount']['items'] <= 0)
            {
                $this->request->redirect(LANGPATH . '/cart/view');
            }

            $shipping = Arr::get($_POST, 'shipping', 0);
            Session::instance()->set('shipping_price', $shipping);

            $o = Request::factory('order/set')->execute()->response;
            $order = $o->get();
            if($order['amount'] == 0)
            {
                $this->request->redirect(LANGPATH . '/payment/success/' . $order['ordernum']);
            }
            else
            {
                $result1 = Payment::instance('EC')->go($order, $payerid, $token, 0);

                kohana_log::instance()->add('ppec_return', json_encode($result1));

                // Product stock Minus
                $products = unserialize($order['products']);
                foreach ($products as $product)
                {
                    $stock = Product::instance($product['id'])->get('stock');
                    if ($stock != -99 AND $stock > 0)
                    {
                        DB::update('products')->set(array('stock' => $stock - $product['quantity']))->where('id', '=', $product['id'])->execute();
                    }
                }

                $this->request->redirect(LANGPATH . '/payment/success/' . $order['ordernum']);
            }
        }
        $token = Arr::get($_REQUEST, 'token', '');
        $result = Payment::instance('EC')->get($token);
        if (!($customer_id = Customer::logged_in()))
        {
            if (Customer::instance()->is_register($result['EMAIL']) == 0)
            {
                $data = array();
                $data['email'] = Arr::get($result, 'EMAIL', '');
                $data['firstname'] = Arr::get($result, 'FIRSTNAME', '');
                $data['lastname'] = Arr::get($result, 'LASTNAME', '');
                $data['password'] = Arr::get($result, 'PAYERID', '');
                $data['ip'] = ip2long(Request::$client_ip);
                $data['ppec_status'] = 0;
                $customer_id = Customer::instance()->set($data);
                Customer::instance($customer_id)->login_action();
                // mail to customer the infomation of the new account.
                $mail_params['password'] = $data['password'];
                $mail_params['email'] = $data['email'];
                $mail_params['firstname'] = $data['firstname'];
                Mail::SendTemplateMail('NEWREGISTER', $data['email'], $mail_params);
            }
            else
            {
                $customer_id = Customer::instance()->is_register($result['EMAIL']);
                Customer::instance($customer_id)->login_action();
            }
        }
        $cart = Cart::get();
        // print_r($cart);exit;
        if(empty($cart['shipping_address']))
        {
            $shipping = array(
                'shipping_address_id' => 'new',
                'shipping_firstname' => $result['FIRSTNAME'],
                'shipping_lastname' => $result['LASTNAME'],
                'shipping_address' => $result['SHIPTOSTREET'] . ' ' . $result['SHIPTOSTREET2'],
                'shipping_city' => $result['SHIPTOCITY'],
                'shipping_state' => $result['SHIPTOSTATE'],
                'shipping_country' => $result['SHIPTOCOUNTRYCODE'],
                'shipping_zip' => $result['SHIPTOZIP'],
                'shipping_phone' => $result['PHONENUM'],
                'shipping_method' => 39
            );
            Cart::shipping_billing($shipping);
        }

        $countries = Site::instance()->countries(LANGUAGE);

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

        // set default carrier
        $default_carrier = $cart['shipping']['carrier'] ? $cart['shipping']['carrier'] : current($carriers);

        $codes = array();
        $customer_codes = DB::query(Database::SELECT, 'SELECT DISTINCT o.code FROM carts_coupons o LEFT JOIN carts_customercoupons c ON o.id=c.coupon_id 
                                                WHERE c.customer_id= ' . $customer_id . ' AND o.limit <> 0 AND expired > ' . time() . ' ORDER BY o.id DESC')->execute()->as_array();
        $on_show_codes = DB::select('code')->from('carts_coupons')->where('limit', '<>', 0)->and_where('expired', '>', time())->and_where('on_show', '=', 1)->execute()->as_array();
        $codes = array_merge($customer_codes, $on_show_codes);

        $cart = Cart::get();
        $this->template->type = 'cart';
        $this->template->content = View::factory('/payment_confirm')
            ->set('cart', $cart)
            ->set('countries', $countries)
            ->set('addresses', $addresses)
            ->set('points_avail', $points_avail)
            ->set('default_carrier', $default_carrier)
            ->set('carriers', $carriers)
            ->set('codes', $codes)
            ->set('token', $token)
            ->set('payerid', $result['PAYERID']);
    }

    public function action_orderpay()
    {
        //$_POST['str']='=Q0MlQWafNnbhJHd2ITJ0MjMxQ0MlIXZi1WdOJjd2NmNyUCRzUiclJWb15UZ1N3cpZjMlYzMuIzNx4SN54iMyIDRzUyczVmckRWYfBXafdmbpxGbpJmNyUyMENTJlRXY0NnNyUCRzUCa052bNVGdhREbhZnNyUSN5UCR4USNFVCR4UCM5USNFVSM5UiQCVSOFVCRzUyc1RXY0NnNyUiZ5UDOhFWNldzNzMWN1YDMzEDNyYjZ3ADZhRjM3cTMhR0MlUGZvNUemlmclZnNyUyZulGZhJHVwITJsFmYvx2RwITJt92Y09GRENTJpBXY2ITJtlGVENTJl1WYuR3cylmZfdmbpxGbpJmNyUSaoNFRzUSZtFmb0NXYs91ZulGbslmY2ITJykjMxIDRzUCcpp3Xn5WasxWaiZjMlQ0MlIXYllVZ0FGRsFmd2ITJn5WakFmcUBjMlwWYi9GbHBjMl02bjR3bER0MlUWbh5mNyUyMyEzN2UDN0MjMxQ0MlUmbvhGclxWZ091ZulGbslmY2ITJTVFRzUSeyRnb192YfdmbpxGbpJmNyUCRzUyc2FmNyUSbvNmLslWYtdGM0UyZulmby9WbpRHRzUCbpFWbl91ZulGbslmY2ITJyETMwITJzNXZyRWQENTJzNXZyRGZh91ZulGbslmY2ITJENTJvZmbpZjMlczM2IDNzITN4QTM1MDNzQ0MlQWSyVGZy9mNyUSe0l2QENTJ5RXaj91ZulGbslmY2ITJ2gjLwkTMENTJ05Wdv1WQ0xmZ2ITJ3MjNENTJkl2XlRXazZjMlQ0MlU2ZhN3cl1mNyUSYzlmVENTJlBXeURmchNEdpRWZyNmNyUiMwQ0MlgGdu9WTlRXYEBHelZjMlUGdhR3UENTJlRXY0N3Xn5WasxWaiZjMlETMxETMxETMxETMxETMxQDRzUiclJWb15EZyF2Q0lGZlJ3Y2ITJyQ0MlQWafNXd0FGdzZjMlQTMwIDRzU ichVWWlRXYEBHelZjMlkGaTBjMl0WaUR0MlUWbh5kclNXd2ITJwUjZzgTOyQ0MlUGZvNmd';
        Payment::instance("TPP")->verify_return($_POST['str']);
    }

    public function action_paid()
    {
        $order = Payment::instance("TPP")->paid_return($_SERVER['QUERY_STRING']);
        $this->request->response = View::factory('/payment_success')
            ->set('order', $order)
            ->render();
    }

    public function action_ocean1_pay($ordernum)
    {
        if (Arr::get($_SERVER, 'COFREE_DOMAIN', URLSTR) == URLSTR AND Arr::get($_SERVER, 'HTTPS', 'off') != 'on')
        {
            $type = isset($_GET['type']) ? '?type=' . $_GET['type'] : '';
            Request::Instance()->redirect(URL::site(Request::Instance()->uri . $type, 'https'));
        }
        if(!is_numeric($ordernum))
        {
            $uri = $this->request->uri();
            $uris = explode('/', $uri);
            $ordernum = $uris[count($uris) - 1];
        }
        if (!$ordernum)
        {
            $this->request->redirect(LANGPATH . '/');
        }
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
        $order = Order::instance(Order::get_from_ordernum($ordernum));


        $products = $order->products();
        $order_info = $order->get();

        if($order_info['payment_method'] != 'OC')
        {
            DB::update('orders_order')->set(array('payment_method' => 'OC'))->where('id', '=', $order_info['id'])->execute();
        }

        if(!$order_info['is_active'])
        {
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
        if($order_info['payment_status'] == 'success' OR $order_info['payment_status'] == 'verify_pass')
        {
            $this->request->redirect(LANGPATH . '/payment/success/' . $ordernum);
        }
        if($order_info['payment_status'] == 'pending')
        {
            Message::set(__('payment_pending'), 'notice');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
        if ($order_info['customer_id'] != $customer_id)
            $this->request->redirect(LANGPATH . '/404');

        if($_POST)
        {
            //初始化card
            $card_info = array();
            Site::instance()->add_clicks('card_pay');
            date_default_timezone_set ('Asia/Shanghai');
            $orderNo = trim($order_info['ordernum']);
            $orderCurrency = trim($order_info['currency']);
            $orderAmount = round($order_info['amount'], 2);
            $cardNo = Arr::get($_POST, 'cardNo', 0);


            if(strlen($cardNo) < 12)
            {
                Message::set(__('card_no_invalid'), 'error');
                $this->request->redirect(LANGPATH . '/payment/ocean_pay/' . $ordernum);
            }
            $cardExpireMonth = Arr::get($_POST, 'cardExpireMonth', 0);
            if(strlen($cardExpireMonth) > 2)
            {
                $cardExpireMonth = substr($cardExpireMonth, 2);
            }
            $cardExpireYear = Arr::get($_POST, 'cardExpireYear', 0);
            if(strlen($cardExpireYear) > 2)
            {
                $cardExpireYear = substr($cardExpireYear, 2);
            }
            if(!$cardExpireMonth OR !$cardExpireYear)
            {
                Message::set(__('expiration_date_invalid'), 'error');
                $this->request->redirect(LANGPATH . '/payment/ocean_pay/' . $ordernum);
            }
            $cardSecurityCode = Arr::get($_POST, 'cardSecurityCode', 0);
            $issuingBank = 'bank';
            $firstName = trim($order_info['shipping_firstname']);
            if(strlen($firstName) > 15)
            {
                $firstName = substr($firstName, 0, 14);
            }
            $lastName = trim($order_info['shipping_lastname']);
            if(strlen($lastName) > 35)
            {
                $lastName = substr($lastName, 0, 34);
            }
            $email = trim($order_info['email']);
            if(strlen($email) > 70)
            {
                $email = substr($email, 0, 69);
            }
            $ip = long2ip($order_info['ip']);
            $phone = trim($order_info['shipping_phone']);
            if(strlen($phone) > 15)
            {
                $phone = substr($phone, 0, 14);
            }
            $paymentMethod = 'Credit Card';
            $country_replace = array('CAN', 'CHI', 'KO', 'XG');
            $replace_to = array('ES', 'US', 'RS', 'ES');
            $country = trim($order_info['shipping_country']);
            $country = str_replace($country_replace, $replace_to, $country);
            $state = trim($order_info['shipping_state']);
            if(strlen($state) > 35)
            {
                $state = substr($state, 0, 34);
            }
            $city = trim($order_info['shipping_city']);
            if(strlen($city) > 40)
            {
                $city = substr($city, 0, 39);
            }
            $address = trim($order_info['shipping_address']);
            if(strlen($address) > 50)
            {
                $address = substr($address, 0, 49);
            }
            $zip = trim($order_info['shipping_zip']);
            if(strlen($zip) > 10)
            {
                $zip = substr($zip, 0, 9);
            }
            $remark = 'remark';
            $customerID = $order_info['customer_id'];

            //Card Type 1:Visa,3:Master,114:Visa Debit,119:Master Debit,122:Visa Electron
            $card_type = Arr::get($_POST, 'card_type', 1);

            $correct_url = 'https://secure.oceanpayment.com/gateway/directservice/test';
            // $correct_url = 'HTTPS://ps.gcsip.nl/wdl/wdl'; //test url
            $language = LANGUAGE ? LANGUAGE : 'en';

            $card_info['card_number'] = $cardNo;
            $card_info['card_year'] = '20'.$cardExpireYear;
            $card_info['card_month'] = $cardExpireMonth;
            $card_info['card_secureCode'] = $cardSecurityCode;
            $card_info['card_issuer'] = $issuingBank;

            $params = array();

            $productSku = '';
            $productName = '';
            $productNum = '';
            foreach($products as $product=>$value)
            {
                $productSku .= $value['sku'].';';
                $productName .= $value['name'].';';
                $productNum .= $value['quantity'].';';
            }

            //去除空格
            $order_info['billing_firstname'] = trim($order_info['billing_firstname']);
            $order_info['billing_lastname'] = trim($order_info['billing_lastname']);

            //转义
            $find = array("'","\"",'>','<');
            $replace = array("&#039;","&quot;","&gt;","&lt;");
            $order_info['billing_firstname'] = str_replace($find, $replace, $order_info['billing_firstname']);
            $order_info['billing_lastname'] = str_replace($find, $replace, $order_info['billing_lastname']);

            $params['account'] = $this->ocean_account;
            $params['terminal'] = $this->ocean_terminal;
            $params['signValue'] = $this->stringtosha($order_info,$card_info);
            $params['noticeUrl'] = BASEURL . '/payment/ocean_return';
            $params['methods'] = 'Credit Card';
            $params['card_number'] = $card_info['card_number'];
            $params['card_year'] = $card_info['card_year'];
            $params['card_month'] = $card_info['card_month'];
            $params['card_secureCode'] = $card_info['card_secureCode'];
            $params['card_issuer'] = $issuingBank;
            $params['order_number'] = $order_info['ordernum'];
            $params['order_currency'] = $order_info['currency'];
            $params['order_amount'] = round($order_info['amount'],2);
            $params['order_notes'] = $remark;
            $params['billing_firstName'] = $order_info['billing_firstname'];
            $params['billing_lastName'] = $order_info['billing_lastname'];
            $params['billing_email'] = $order_info['email'];
            $params['billing_phone'] = $order_info['billing_phone'];
            $params['billing_country'] = $order_info['billing_country'];
            $params['billing_state'] = $order_info['billing_state'];
            $params['billing_city'] = $order_info['billing_city'];
            $params['billing_address'] = $order_info['billing_address'];
            $params['billing_zip'] = $order_info['billing_zip'];
            $params['billing_ip'] = $ip;
            $params['productSku'] = $productSku;
            $params['productName'] = $productName;
            $params['productNum'] = $productNum;

            $correct_url="https://secure.oceanpayment.com/gateway/directservice/pay?".http_build_query($params);

            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_URL, $correct_url);
            curl_setopt ( $ch, CURLOPT_FAILONERROR, false );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            //以post请求发送
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $params);
            $response = curl_exec($ch);
            if(curl_errno($ch))
            {
                print curl_error($ch);
            }
            curl_close($ch);

            if($this->xml_parser($response))
            {
                $xml = simplexml_load_string($response);
                    //把推送参数赋值到$_REQUEST
                    $_REQUEST['response_type']    = (string)$xml->response_type;
                    $_REQUEST['account']          = (string)$xml->account;
                    $_REQUEST['terminal']         = (string)$xml->terminal;
                    $_REQUEST['payment_id']       = (string)$xml->payment_id;
                    $_REQUEST['order_number']     = (string)$xml->order_number;
                    $_REQUEST['order_currency']   = (string)$xml->order_currency;
                    $_REQUEST['order_amount']     = (string)$xml->order_amount;
                    $_REQUEST['payment_status']   = (string)$xml->payment_status;
                    $_REQUEST['payment_details']  = (string)$xml->payment_details;
                    $_REQUEST['signValue']        = (string)$xml->signValue;
                    $_REQUEST['order_notes']      = (string)$xml->order_notes;
                    $_REQUEST['card_number']      = (string)$xml->card_number;
                    $_REQUEST['payment_authType'] = (string)$xml->payment_authType;
                    $_REQUEST['payment_risk']     = (string)$xml->payment_risk;
                    $_REQUEST['methods']          = (string)$xml->methods;
                    $_REQUEST['payment_country']  = (string)$xml->payment_country;
                    $_REQUEST['payment_solutions']= (string)$xml->payment_solutions;

                //获取本地的code值
                $secureCode = $this->ocean_secureCode;
            }

            if($_REQUEST)
            {
               $return_data = $_REQUEST;
            }

            // print_r($return_data); exit;
            if(empty($return_data))
            {
                kohana_log::instance()->add('OC_NO_RETURN', $order_info['ordernum']);
            }
            if(isset($return_data['account']))
            {
                $this->ocean_return1($return_data);
                exit;
            }

        }

        $this->template->type = 'purchase';
        $this->template->content = View::factory('/payment_gc1')
            ->set('order', $order_info);
    }

    public function action_ocean_pay($ordernum)
    {
        if (Arr::get($_SERVER, 'COFREE_DOMAIN', URLSTR) == URLSTR AND Arr::get($_SERVER, 'HTTPS', 'off') != 'on')
        {
            $type = isset($_GET['type']) ? '?type=' . $_GET['type'] : '';
            Request::Instance()->redirect(URL::site(Request::Instance()->uri . $type, 'https'));
        }
        if(!is_numeric($ordernum))
        {
            $uri = $this->request->uri();
            $uris = explode('/', $uri);
            $ordernum = $uris[count($uris) - 1];
        }
        if (!$ordernum)
        {
            $this->request->redirect(LANGPATH . '/');
        }
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
        $order = Order::instance(Order::get_from_ordernum($ordernum));


        $products = $order->products();
        $order_info = $order->get();

        if($order_info['payment_method'] != 'OC')
        {
            DB::update('orders_order')->set(array('payment_method' => 'OC'))->where('id', '=', $order_info['id'])->execute();
        }

        if(!$order_info['is_active'])
        {
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
        if($order_info['payment_status'] == 'success' OR $order_info['payment_status'] == 'verify_pass')
        {
            $this->request->redirect(LANGPATH . '/payment/success/' . $ordernum);
        }
        if($order_info['payment_status'] == 'pending')
        {
            Message::set(__('payment_pending'), 'notice');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
        if ($order_info['customer_id'] != $customer_id)
            $this->request->redirect(LANGPATH . '/404');

        //初始化card
        $card_info = array();
        Site::instance()->add_clicks('card_pay');
        date_default_timezone_set ('Asia/Shanghai');
        $orderNo = trim($order_info['ordernum']);
        $orderCurrency = trim($order_info['currency']);
        $orderAmount = round($order_info['amount'], 2);

        $issuingBank = 'bank';
        $firstName = trim($order_info['shipping_firstname']);
        if(strlen($firstName) > 15)
        {
            $firstName = substr($firstName, 0, 14);
        }
        $lastName = trim($order_info['shipping_lastname']);
        if(strlen($lastName) > 35)
        {
            $lastName = substr($lastName, 0, 34);
        }
        $email = trim($order_info['email']);
        if(strlen($email) > 70)
        {
            $email = substr($email, 0, 69);
        }
        $ip = long2ip($order_info['ip']);
        $phone = trim($order_info['shipping_phone']);
        if(strlen($phone) > 15)
        {
            $phone = substr($phone, 0, 14);
        }
        $paymentMethod = 'Credit Card';
        $country_replace = array('CAN', 'CHI', 'KO', 'XG');
        $replace_to = array('ES', 'US', 'RS', 'ES');
        $country = trim($order_info['shipping_country']);
        $country = str_replace($country_replace, $replace_to, $country);
        $state = trim($order_info['shipping_state']);
        if(strlen($state) > 35)
        {
            $state = substr($state, 0, 34);
        }
        $city = trim($order_info['shipping_city']);
        if(strlen($city) > 40)
        {
            $city = substr($city, 0, 39);
        }
        $address = trim($order_info['shipping_address']);
        if(strlen($address) > 50)
        {
            $address = substr($address, 0, 49);
        }
        $zip = trim($order_info['shipping_zip']);
        if(strlen($zip) > 10)
        {
            $zip = substr($zip, 0, 9);
        }
        $remark = 'remark';
        $customerID = $order_info['customer_id'];

        $correct_url = 'https://secure.oceanpayment.com/gateway/directservice/test';
        $language = LANGUAGE ? LANGUAGE : 'en';

        $params = array();

        $productSku = '';
        $productName = '';
        $productNum = '';
        foreach($products as $product=>$value)
        {
            $productSku .= $value['sku'].';';
            $productName .= $value['name'].';';
            $productNum .= $value['quantity'].';';
        }

//        $config = array(
//                'sofort_backUrl' => BASEURL . '/payment/ocean_response',
//                'sofort_noticeUrl' => BASEURL . '/payment/ocean_return',
//                'account' => $this->ocean_account,
//                'terminal' => $this->ocean_terminal,
//                'oc_payment_url' => 'https://secure.oceanpayment.com/gateway/service/pay',
//                'methods' => 'Credit Card',
//                'logoUrl' => STATICURLHTTPS.'/assets/images/2016/logo.png',
//            );
        $config = array(
            'sofort_backUrl' => BASEURL . '/payment/ocean_response',
            'sofort_noticeUrl' => BASEURL . '/payment/ocean_return',
            'account' => $this->ocean_account,
            'terminal' => $this->ocean_terminal,
            'oc_payment_url' => 'https://secure.oceanpayment.com/gateway/service/pay',
//            'oc_payment_url' => 'https://secure.oceanpayment.com/gateway/service/test', //对方测试环境
            'methods' => 'Credit Card',
            'logoUrl' => STATICURLHTTPS.'/assets/images/2016/logo.png',
        );

        //去除空格
        $order_info['shipping_firstname'] = trim($order_info['shipping_firstname']);
        $order_info['shipping_lastname'] = trim($order_info['shipping_lastname']);

        //转义
        $find = array("'","\"",'>','<');
        $replace = array("&#039;","&quot;","&gt;","&lt;");
        $order_info['shipping_firstname'] = str_replace($find, $replace, $order_info['shipping_firstname']);
        $order_info['shipping_lastname'] = str_replace($find, $replace, $order_info['shipping_lastname']);

        $config['signValue'] = $this->stringtoshasipay1($order_info,$config);
        $config['productSku'] = $productSku;
        $config['productName'] = $productName;
        $config['productNum'] = $productNum;

        $isgift = 1;
        $this->template = View::factory('/payment')
             ->set('paypal_form', Payment::instance('OC')->form('', '', $order_info, $config))
            ->set('ordernum', $ordernum)->set('order', $order)->set('isgift',$isgift);

    }

    public function ocean_return1($return_data)
    {

        //获取本地的code值
        $secureCode = 'L8h8j2lb';

        $local_signValue  = hash("sha256",$return_data['account'].$return_data['terminal'].$return_data['order_number'].$return_data['order_currency'].$return_data['order_amount'].$return_data['order_notes'].$return_data['card_number'].
                $return_data['payment_id'].$return_data['payment_authType'].$return_data['payment_status'].$return_data['payment_details'].$return_data['payment_risk'].$secureCode);

        if (strtolower($local_signValue) == strtolower($return_data['signValue']))
        {
            $order_id = Order::get_from_ordernum($return_data['order_number']);
            DB::update('orders_order')->set(array('payment_method' => 'OC'))->where('id', '=', $order_id)->execute();
            $order = Order::instance($order_id)->get();
            if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
            {
                echo '<script language="javascript">top.location.replace("' . BASEURL. '/payment/success/' . $order['ordernum'] . '");</script>';
                exit;
            }

                $data = array();
                $data['order_id'] = $order_id;
                $data['payment_id'] = $return_data['payment_id'];
                $data['account'] = $return_data['account'];
                $data['terminal'] = $return_data['terminal'];
                $data['order_number'] = $return_data['order_number'];
                $data['order_currency'] = $return_data['order_currency'];
                $data['order_amount'] = $return_data['order_amount'];
                $data['card_number'] = $return_data['card_number'];
                $data['payment_country'] = $return_data['payment_country'];
                $data['payment_details'] = $return_data['payment_details'];
                $data['payment_risk'] = $return_data['payment_risk'];
                $data['payment_authType'] = $return_data['payment_authType'];
                $data['type'] = 'OceanPay';

                $payment_status = $return_data['payment_status'];

            if ($payment_status == 1)
            {
                //支付成功
                $data['succeed'] = 1;
            }
            elseif($payment_status == 0)
            {
                //支付失败
                $data['succeed'] = 0;
            }
            elseif($payment_status == -1 && $data['payment_authType'] == 1)
            {
                //预授权
                $data['succeed'] = -1;
            }

            $result = $data['succeed'];
            switch ($result)
            {
                case 1:
                        $products = Order::instance($order_id)->products();
                        foreach ($products as $product)
                        {
                            $stock = Product::instance($product['product_id'])->get('stock');
                            if ($stock == -1)
                            {
                                $attr = $product['attributes'];
                                $attr = str_replace(';', '', $attr);
                                $attr = str_replace('Size:', '', $attr);
                                $attr = str_replace('size:', '', $attr);
                                $attr = trim($attr);
                                $stocks = DB::select('id', 'stocks')->from('products_productitem')
                                        ->where('product_id', '=', $product['product_id'])
                                        ->where('attribute', 'LIKE', '%' . $attr . '%')
                                        ->execute()->current();
                                if (!empty($stocks))
                                {
                                    DB::update('products_productitem')->set(array('stock' => $stocks['stock'] - $product['quantity']))->where('id', '=', $stocks['id'])->execute();
                                }
                            }
                        }
                        $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);

                case 0:
                    $message = $data['payment_details'];
                    Message::set($message, 'error');
                    $this->request->redirect(BASEURL . LANGPATH . '/order/view/' . $order['ordernum']);
                    break;
                case -1:
                    $message = 'Your payment is pending at the moment.';
                    Message::set($message, 'error');
                    $this->request->redirect(BASEURL . LANGPATH . '/order/view/' . $order['ordernum']);
                    break;
            }

        }
        else
        {
            //校验失败
                $message = 'not authorized';
                Message::set($message, 'error');
                $this->request->redirect(BASEURL. LANGPATH . '/customer/orders/');
                exit;
        }
    }


    //ocean pay return
    public function action_ocean_return()
    {
        //获取推送输入流XML
        $xml_str = file_get_contents("php://input");

        //判断返回的输入流是否为xml
        if($this->xml_parser($xml_str))
        {
            $xml = simplexml_load_string($xml_str);
                //把推送参数赋值到$_REQUEST
                $_REQUEST['response_type']    = (string)$xml->response_type;
                $_REQUEST['account']          = (string)$xml->account;
                $_REQUEST['terminal']         = (string)$xml->terminal;
                $_REQUEST['payment_id']       = (string)$xml->payment_id;
                $_REQUEST['order_number']     = (string)$xml->order_number;
                $_REQUEST['order_currency']   = (string)$xml->order_currency;
                $_REQUEST['order_amount']     = (string)$xml->order_amount;
                $_REQUEST['payment_status']   = (string)$xml->payment_status;
                $_REQUEST['payment_details']  = (string)$xml->payment_details;
                $_REQUEST['signValue']        = (string)$xml->signValue;
                $_REQUEST['order_notes']      = (string)$xml->order_notes;
                $_REQUEST['card_number']      = (string)$xml->card_number;
                $_REQUEST['payment_authType'] = (string)$xml->payment_authType;
                $_REQUEST['payment_risk']     = (string)$xml->payment_risk;
                $_REQUEST['methods']          = (string)$xml->methods;
                $_REQUEST['payment_country']  = (string)$xml->payment_country;
                $_REQUEST['payment_solutions']= (string)$xml->payment_solutions;

            //获取本地的code值
            $secureCode = $this->ocean_secureCode;
        }

        //Kohana_Log::instance()->add('OCEAN_RETURN', json_encode($_REQUEST))->write();

        $local_signValue  = hash("sha256",$_REQUEST['account'].$_REQUEST['terminal'].$_REQUEST['order_number'].$_REQUEST['order_currency'].$_REQUEST['order_amount'].$_REQUEST['order_notes'].$_REQUEST['card_number'].
                $_REQUEST['payment_id'].$_REQUEST['payment_authType'].$_REQUEST['payment_status'].$_REQUEST['payment_details'].$_REQUEST['payment_risk'].$secureCode);

        if (strtolower($local_signValue) == strtolower($_REQUEST['signValue']))
        {
            $return_data = $_REQUEST;

            $returnum = serialize($return_data);

            Kohana_Log::instance()->add('OCEAN_RETURN', $returnum)->write();
            $order_id = Order::get_from_ordernum($return_data['order_number']);
            DB::update('orders_order')->set(array('payment_method' => 'OC'))->where('id', '=', $order_id)->execute();
            $order = Order::instance($order_id)->get();
            if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
            {
            }

                $data = array();
                $data['order_id'] = $order_id;
                $data['payment_id'] = $return_data['payment_id'];
                $data['account'] = $return_data['account'];
                $data['terminal'] = $return_data['terminal'];
                $data['order_number'] = $return_data['order_number'];
                $data['order_currency'] = $return_data['order_currency'];
                $data['order_amount'] = $return_data['order_amount'];
                $data['card_number'] = $return_data['card_number'];
                $data['payment_country'] = $return_data['payment_country'];
                $data['payment_details'] = $return_data['payment_details'];
                $data['payment_risk'] = $return_data['payment_risk'];
                $data['payment_authType'] = $return_data['payment_authType'];

                $data['type'] = 'OceanPay';

                $payment_status = $return_data['payment_status'];
                $payment_details = explode(":",$return_data['payment_details']);

            if ($payment_status == 1)
            {
                //支付成功
                $data['succeed'] = 1;
            }
            elseif($payment_status == 0)
            {
                //支付失败
                if($payment_details[0] == 50008 || $payment_details[0] == 50000)
                {
                    echo "receive-ok";
                    die;
                }
                $data['succeed'] = 0;
            }
            elseif($payment_status == -1 && $data['payment_authType'] == 1)
            {
                //预授权
                $data['succeed'] = -1;
            }

            Payment::instance('OC')->pay($order, $data);
            echo "receive-ok";
            die;
        }
        else
        {
            $return_data = $_REQUEST;
            $order_id = Order::get_from_ordernum($return_data['order_number']);
            DB::update('orders_order')->set(array('payment_status' => 'failed'))->where('id', '=', $order_id)->execute();
        }

    }

    public function action_ocean_response()
    {
        if($_POST) {
            //获取本地的code值
           // $secureCode = 'L8h8j2lb';
            $secureCode = '12345678';
            $return_data = $_POST;
            $local_signValue = hash("sha256", $return_data['account'] . $return_data['terminal'] . $return_data['order_number'] . $return_data['order_currency'] . $return_data['order_amount'] . $return_data['order_notes'] . $return_data['card_number'] .
                $return_data['payment_id'] . $return_data['payment_authType'] . $return_data['payment_status'] . $return_data['payment_details'] . $return_data['payment_risk'] . $secureCode);

            if (strtolower($local_signValue) == strtolower($return_data['signValue'])) {
                $order_id = Order::get_from_ordernum($return_data['order_number']);
                $order = Order::instance($order_id)->get();
                if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass') {
                    echo '<script language="javascript">top.location.replace("' . BASEURL . '/payment/success/' . $order['ordernum'] . '");</script>';
                    exit;
                }

                $data = array();
                $data['order_id'] = $order_id;
                $data['payment_id'] = $return_data['payment_id'];
                $data['account'] = $return_data['account'];
                $data['terminal'] = $return_data['terminal'];
                $data['order_number'] = $return_data['order_number'];
                $data['order_currency'] = $return_data['order_currency'];
                $data['order_amount'] = $return_data['order_amount'];
                $data['card_number'] = $return_data['card_number'];
                $data['payment_country'] = $return_data['payment_country'];
                $data['payment_details'] = $return_data['payment_details'];
                $data['payment_risk'] = $return_data['payment_risk'];
                $data['payment_authType'] = $return_data['payment_authType'];
                $data['type'] = 'OceanPay';

                $payment_status = $return_data['payment_status'];


                if ($payment_status == 1) {
                    //支付成功
                    $data['succeed'] = 1;
                } elseif ($payment_status == 0) {
                    //支付失败
                    $data['succeed'] = 0;
                } elseif ($payment_status == -1 && $data['payment_authType'] == 1) {
                    //预授权
                    $data['succeed'] = -1;
                }

                $result = $data['succeed'];
                switch ($result) {
                    case 1:
                        $products = Order::instance($order_id)->products();
                        foreach ($products as $product) {
                            $stock = Product::instance($product['product_id'])->get('stock');
                            if ($stock == -1) {
                                $attr = $product['attributes'];
                                $attr = str_replace(';', '', $attr);
                                $attr = str_replace('Size:', '', $attr);
                                $attr = str_replace('size:', '', $attr);
                                $attr = trim($attr);
                                $stocks = DB::select('id', 'stock')->from('products_productitem')
                                    ->where('product_id', '=', $product['product_id'])
                                    ->where('attribute', 'LIKE', '%' . $attr . '%')
                                    ->execute()->current();
                                if (!empty($stocks)) {
                                    DB::update('products_productitem')->set(array('stock' => $stocks['stock'] - $product['quantity']))->where('id', '=', $stocks['id'])->execute();
                                }
                            }
                        }
                        $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);

                    case 0:
                        $message = $data['payment_details'];
                        Message::set($message, 'error');
                        $this->request->redirect(BASEURL . LANGPATH . '/order/view/' . $order['ordernum']);
                        break;
                    case -1:
                        $message = 'Your payment is pending at the moment.';
                        Message::set($message, 'error');
                        $this->request->redirect(BASEURL . LANGPATH . '/order/view/' . $order['ordernum']);
                        break;
                }

            } else {
                //校验失败
                $message = 'not authorized';
                Message::set($message, 'error');
                $this->request->redirect(BASEURL . LANGPATH . '/customer/orders/');

            }
        }else{
            $this->request->redirect(BASEURL . LANGPATH );
            exit;
        }
    }

    //ocean pay return
    public function action_sofort_return()
    {
        //获取推送输入流XML
        $xml_str = file_get_contents("php://input");

        //判断返回的输入流是否为xml
        if($this->xml_parser($xml_str))
        {
            $xml = simplexml_load_string($xml_str);
                //把推送参数赋值到$_REQUEST
                $_REQUEST['response_type']    = (string)$xml->response_type;
                $_REQUEST['account']          = (string)$xml->account;
                $_REQUEST['terminal']         = (string)$xml->terminal;
                $_REQUEST['payment_id']       = (string)$xml->payment_id;
                $_REQUEST['order_number']     = (string)$xml->order_number;
                $_REQUEST['order_currency']   = (string)$xml->order_currency;
                $_REQUEST['order_amount']     = (string)$xml->order_amount;
                $_REQUEST['payment_status']   = (string)$xml->payment_status;
                $_REQUEST['payment_details']  = (string)$xml->payment_details;
                $_REQUEST['signValue']        = (string)$xml->signValue;
                $_REQUEST['order_notes']      = (string)$xml->order_notes;
                $_REQUEST['payment_authType'] = (string)$xml->payment_authType;
                $_REQUEST['payment_risk']     = (string)$xml->payment_risk;
                $_REQUEST['methods']          = (string)$xml->methods;
                $_REQUEST['payment_country']  = (string)$xml->payment_country;
            //获取本地的code值
            $secureCode = $this->ocean_secureCode1;
        }

        $local_signValue  = hash("sha256",$_REQUEST['account'].$_REQUEST['terminal'].$_REQUEST['order_number'].$_REQUEST['order_currency'].$_REQUEST['order_amount'].$_REQUEST['order_notes'].$_REQUEST['payment_id'].$_REQUEST['payment_authType'].$_REQUEST['payment_status'].$_REQUEST['payment_details'].$_REQUEST['payment_risk'].$secureCode);

        if (strtolower($local_signValue) == strtolower($_REQUEST['signValue']))
        {
            $return_data = $_REQUEST;

            $returnum = serialize($return_data);

            Kohana_Log::instance()->add('OCEAN_SOFORTRETURN', $returnum)->write();
            $order_id = Order::get_from_ordernum($return_data['order_number']);
            DB::update('orders_order')->set(array('payment_method' => 'SOFORT'))->where('id', '=', $order_id)->execute();
            $order = Order::instance($order_id)->get();
            if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
            {
            }

                $data = array();
                $data['order_id'] = $order_id;
                $data['payment_id'] = $return_data['payment_id'];
                $data['account'] = $return_data['account'];
                $data['terminal'] = $return_data['terminal'];
                $data['order_number'] = $return_data['order_number'];
                $data['order_currency'] = $return_data['order_currency'];
                $data['order_amount'] = $return_data['order_amount'];
                $data['payment_country'] = $return_data['payment_country'];
                $data['payment_details'] = $return_data['payment_details'];
                $data['payment_risk'] = $return_data['payment_risk'];
                $data['payment_authType'] = $return_data['payment_authType'];
                $data['type'] = 'OceanPay';

                $payment_status = $return_data['payment_status'];
                $payment_details = explode(":",$return_data['payment_details']);

            if ($payment_status == 1 && $payment_details[0] == 80000)
            {
                //支付成功
                $data['succeed'] = 1;
            }
            elseif($payment_status == 0)
            {
                //支付失败
                $data['succeed'] = 0;
            }
            elseif($payment_status == 1 && $payment_details[0] == 80004)
            {
                //预授权
                $data['succeed'] = -1;
                DB::update('orders_order')->set(array('payment_status' => 'pending'))->where('id', '=', $order_id)->execute();
                echo "receive-ok";
                die;
            }
            else
            {
                echo "receive-ok";
                die;
            }

            Payment::instance('OC')->pay($order, $data);
            echo "receive-ok";
            die;
        }
        else
        {
            $return_data = $_REQUEST;
            $order_id = Order::get_from_ordernum($return_data['order_number']);
            DB::update('orders_order')->set(array('payment_status' => 'failed'))->where('id', '=', $order_id)->execute();
        }

    }

    public function stringtosha($order_info,$card_info)
    {
        $value = $this->ocean_account.$this->ocean_terminal.$order_info['ordernum'].$order_info['currency'];
        $amount = round($order_info['amount'],2);

        $value = $value.$amount.$card_info['card_number'].$card_info['card_year'].$card_info['card_month'].$card_info['card_secureCode'].$card_info['card_issuer'];

        $value = $value.$order_info['billing_firstname'].$order_info['billing_lastname'].$order_info['email'].$this->ocean_secureCode;

        $signValue=hash("sha256",$value);

        return $signValue;
    }

    public function stringtoshasipay($order_info,$config)
    {
        $value = $this->ocean_account1.$this->ocean_terminal1.$config['sofort_backUrl'].$order_info['ordernum'].$order_info['currency'];
        $amount = round($order_info['amount'],2);

        $value = $value.$amount;

        $value = $value.$order_info['shipping_firstname'].$order_info['shipping_lastname'].$order_info['email'].$this->ocean_secureCode1;

        $signValue=hash("sha256",$value);

        return $signValue;
    }

    public function stringtoshasipay1($order_info,$config)
    {
        $value = $this->ocean_account.$this->ocean_terminal.$config['sofort_backUrl'].$order_info['ordernum'].$order_info['currency'];
        $amount = round($order_info['amount'],2);

        $value = $value.$amount;

        $value = $value.$order_info['shipping_firstname'].$order_info['shipping_lastname'].$order_info['email'].$this->ocean_secureCode;

        $signValue=hash("sha256",$value);

        return $signValue;
    }

    public function action_ipay($ordernum)
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }

        $order_id = Order::instance()->get_from_ordernum($ordernum);
        if(!$order_id)
        {
            $this->request->redirect(BASEURL);
        }
        $order = Order::instance($order_id);
        if(in_array($order->get('payment_status'),array('success','verify_pass')))
        {
            $this->request->redirect(BASEURL);
        }
        $billadress = array();
        if($order->get('billing_country') and $order->get('billing_city'))
        {
            $billadress['firstName'] = $order->get('billing_firstname');
            $billadress['lastName'] = $order->get('billing_lastname');
            $billadress['address'] = $order->get('billing_address');
            $billadress['state'] = $order->get('billing_state');
            $billadress['city'] = $order->get('billing_city');
            $billadress['zip'] = $order->get('billing_zip');
            $billadress['phone'] = $order->get('billing_phone');
            $billadress['country'] = $order->get('billing_country');

        }
        $shipping['firstName'] = $order->get('shipping_firstname');
        $shipping['lastName'] = $order->get('shipping_lastname');
        $shipping['address'] = $order->get('shipping_address');
        $shipping['state'] = $order->get('shipping_state');
        $shipping['city'] = $order->get('shipping_city');
        $shipping['zip'] = $order->get('shipping_zip');
        $shipping['phone'] = $order->get('shipping_phone');
        $shipping['country'] = $order->get('shipping_country');
        $address = (!empty($billadress))?$billadress:$shipping;
        $currency = $order->get('currency');
        $amount = $order->get('amount');
//        $email = $order->get('email');
        $countries_top = Site::instance()->countries_top(LANGUAGE);
        $countries = Site::instance()->countries(LANGUAGE);
        $this->template->type = 'purchase';
        $this->template->content = View::factory('/ipay')
            ->set('ordernum',$ordernum)
            ->set('billAddress',$address)
            ->set('countries_top',$countries_top)
            ->set('countries',$countries)
            ->set('currency',$currency)
            ->set('amount',$amount);
    }

    public function action_ipay_pay()
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
        if(!$_POST['cardNumber'] or !$_POST['cardMonth'] or !$_POST['cardYear'] or !$_POST['cardCode']  or !$_POST['ordernum'])
        {
            $this->request->redirect(BASEURL . LANGPATH . '/customer/orders/');
        }
        $card['cardNumber']  = trim(Arr::get($_POST,'cardNumber',''));
        $card['cardMonth']  = trim(Arr::get($_POST,'cardMonth',''));
        $card['cardYear']  = trim(Arr::get($_POST,'cardYear',''));
//        $card['cardEmail']  = trim(Arr::get($_POST,'cardEmail',''));
        $card['cardCode']  = trim(Arr::get($_POST,'cardCode',''));
        $ordernum = trim(Arr::get($_POST,'ordernum',''));
        $order_id = Order::instance()->get_from_ordernum($ordernum);
        if(!$order_id)
        {
            $message = 'not';
            Message::set($message, 'error');
            $this->request->redirect(BASEURL . LANGPATH . '/customer/orders/');
        }


        $order = Order::instance($order_id);
        $orderInfo = $order->get();
        if($orderInfo['customer_id'] != $customer_id)
        {
            $this->request->redirect(BASEURL . LANGPATH . '/customer/orders/');
        }
        if($orderInfo['payment_method'] != 'IPAY')
        {
            DB::update('orders_order')->where('id', '=', $orderInfo['id'])->set(array('payment_method' => 'IPAY'))->execute();
        }
        if(!$orderInfo['is_active'])
        {
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
        if($orderInfo['payment_status'] == 'success' OR $orderInfo['payment_status'] == 'verify_pass')
        {
            $this->request->redirect(LANGPATH . '/payment/success/' . $ordernum);
        }
        if($orderInfo['payment_status'] == 'pending')
        {
            Message::set(__('payment_pending'), 'notice');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
        if ($orderInfo['customer_id'] != $customer_id)
            $this->request->redirect(LANGPATH . '/404');
        $goodsInfo = $order->goodsInfo();
        $ip = $_SERVER["REMOTE_ADDR"];
        $amount = (float)$orderInfo['amount']*100;
        $currencyCode = $orderInfo['currency'];
        $ipayCountryCode = kohana::config('ipayCountryCode');

        //转义
        $find = array("'","\"",'>','<');
        $replace = array("&#039;","&quot;","&gt;","&lt;");
        $orderInfo['shipping_firstname'] = str_replace($find, $replace, $orderInfo['shipping_firstname']);
        $orderInfo['shipping_lastname'] = str_replace($find, $replace, $orderInfo['shipping_lastname']);

        if(!$orderInfo['billing_firstname'] and !$orderInfo['billing_lastname'] and !$orderInfo['billing_country'])
        {
            $billing['billing_firstname'] = $orderInfo['shipping_firstname'];
            $billing['billing_lastname'] = $orderInfo['shipping_lastname'];
            $billing['billing_country'] = $orderInfo['shipping_country'];
            $billing['billing_state'] = $orderInfo['shipping_state'];
            $billing['billing_city'] = $orderInfo['shipping_city'];
            $billing['billing_address'] = $orderInfo['shipping_address'];
            $billing['billing_zip'] = $orderInfo['shipping_zip'];
            $billing['billing_phone'] = $orderInfo['shipping_phone'];
            DB::update('orders_order')->where('ordernum','=',$ordernum)->set($billing)->execute();
        }
        $billing = DB::select()->from('orders_order')->where('ordernum','=',$ordernum)->execute()->current();

        if(array_key_exists($billing['billing_country'],$ipayCountryCode))
        {
            $billCountryCode = $ipayCountryCode[$billing['billing_country']];
        }else{
            $message = 'please check if all the infomation is correct';
            Message::set($message, 'error');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }

        if(array_key_exists($orderInfo['shipping_country'],$ipayCountryCode))
        {
            $shippingCountryCode = $ipayCountryCode[$orderInfo['shipping_country']];
        }else{
            $message = 'please check if all the infomation is correct';
            Message::set($message, 'error');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
        //card
        $data['payMode'] = '10';
        $data['cardHolderNumber'] = $card['cardNumber'];
        $data['cardHolderFirstName'] = $billing['billing_firstname'];
        $data['cardHolderLastName'] = billing['billing_lastname'];
        $data['cardExpirationMonth'] = $card['cardMonth'];
        $data['cardExpirationYear'] = $card['cardYear'];
        $data['securityCode'] = $card['cardCode'];
        $data['cardHolderEmail'] = $orderInfo['email'];
        $data['cardHolderPhoneNumber'] = $billing['billing_phone'];
        //bill
        $data['billFirstName']  =   $billing['billing_firstname'];
        $data['billLastName']   =   $billing['billing_lastname'];
        $data['billAddress']    =   $billing['billing_address'];
        $data['billEmail']      =   $orderInfo['email'];
        $data['billPhoneNumber'] =  $billing['billing_phone'];
        $data['billPostalCode'] =   $billing['billing_zip'];
        $data['billCity']       =   $billing['billing_city'];
        $data['billState']      =   $billing['billing_state'];
        $data['billCountryCode'] =  $billCountryCode;


        //shipping
        $data['shippingFirstName'] = $orderInfo['shipping_firstname'];
        $data['shippingLastName'] = $orderInfo['shipping_lastname'];
        $data['shippingAddress'] = $orderInfo['shipping_address'];
        $data['shippingMail'] = $orderInfo['email'];
        $data['shippingPhoneNumber'] = $orderInfo['shipping_phone'];
        $data['shippingPostalCode'] = $orderInfo['shipping_zip'];

        $data['shippingCity'] = $orderInfo['shipping_city'];
        $data['shippingState'] = $orderInfo['shipping_state'];
        $data['shippingCountryCode'] = $shippingCountryCode;

        //order

        $data['version'] = '1.1';   //支付接口版本号
        $data['orderId'] = $orderInfo['ordernum'];
        $data['goodsName'] = $goodsInfo['name'];
        $data['goodsDesc'] = $goodsInfo['desc'];
        $data['submitTime'] = date('YmdHis',time());
        $data['customerIP'] = $ip;
        $data['siteId'] = URLSTR;   //商户域名
        $data['orderAmount'] = (string)$amount;
        $data['tradeType'] = '1001';   //及时支付
        $data['payType'] = 'DCC';  //支付类型
        $data['currencyCode'] = $currencyCode;

        $data['settlementCurrencyCode'] = 'USD';   //结算币种
        $data['borrowingMarked'] = '0';
        $data['noticeUrl'] = BASEURL.'/payment/ipay_notice'; //异步通知链接
        $data['partnerId'] = $this->partnerId;  //会员号
        $data['mcc'] = '4000';
        //other
        $data['deviceFingerprintId'] = $orderInfo['ordernum'];
        $data['charset'] = '1';
        $data['signType'] = '2';
        ksort($data);

        $sendSignMsg = '';
        foreach ($data as $key => $value)
        {
            $sendSignMsg .= $key.'='.trim($value).'&';
        }
        //$ipayKey 商户公钥，在ipay账号里下载。该公钥每次下载，都要更新这里，否则无法支付
        $ipayKey = kohana::config('ipayConfig');
        $sendSignMsg .= 'pkey='.$ipayKey[0].'';
        $data['signMsg'] = md5($sendSignMsg);



//        $correct_url = 'http://api.test.ipaylinks.com/webgate/crosspay.htm';//本地联调
        $correct_url = 'https://api.ipaylinks.com/webgate/crosspay.htm'; //生产环境
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $correct_url);
        curl_setopt ( $ch, CURLOPT_FAILONERROR, false );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        //以post请求发送
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        if(curl_errno($ch))
        {
            print curl_error($ch);
            $message = 'Communication failure';
            Message::set($message, 'error');
            $this->request->redirect(BASEURL . LANGPATH . '/customer/orders/');
        }
        curl_close($ch);

        if($this->xml_parser($response))
        {
            $xml = simplexml_load_string($response);
            //把推送参数赋值到$_REQUEST
            $get['orderId']                    = (string)$xml->orderId;
            $get['resultCode']                 = (string)$xml->resultCode;
            $get['resultMsg']                  = (string)$xml->resultMsg;
            $get['orderAmount']                = (string)$xml->orderAmount;
            $get['currencyCode']               = (string)$xml->currencyCode;
            $get['merchantBillName']           = (string)$xml->merchantBillName;
            $get['settlementCurrencyCode']     = (string)$xml->settlementCurrencyCode;
            $get['acquiringTime']              = (string)$xml->acquiringTime;
            $get['completeTime']               = (string)$xml->completeTime;
            $get['dealId']                     = (string)$xml->dealId;
            $get['partnerId']                  = (string)$xml->partnerId;
            $get['remark']                     = (string)$xml->remark;
            $get['language']                   = (string)$xml->language;
            $get['settlementRates']            = (string)$xml->settlementRates;
            $get['rates']                      = (string)$xml->rates;
            $get['charset']                    = (string)$xml->charset;
            $get['signType']                   = (string)$xml->signType;
            $signMsg                         = (string)$xml->signMsg;

            ksort($get);
            $localVerify = '';
            foreach ($get as $key => $value)
            {
                if($value)
                {
                    $localVerify .= $key.'='.trim($value).'&';
                }
            }
            $localVerify  .= 'pkey='.$this->ipayKey;

            if(md5($localVerify) == $signMsg)
            {
                $return = serialize($get);
                Kohana::$log->add('IPAY_RETURN', $return.'|singMsg:'.$signMsg);
                $order_id = Order::get_from_ordernum($get['orderId']);
                DB::update('orders_order')->set(array('payment_method' => 'IPAY'))->where('id', '=', $order_id)->execute();
                $order = Order::instance($order_id)->get();
                if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass') {
                    echo '<script language="javascript">top.location.replace("' . BASEURL . '/payment/success/' . $order['ordernum'] . '");</script>';
                    exit;
                }
                if($get['resultCode'] == '0000')
                {
//                    $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);
                    $this->request->redirect('/payment/success/' . $order['ordernum']);
                }else{
                    $message = 'Payment failure.';
                    Message::set($message, 'error');
                    $this->request->redirect(BASEURL . LANGPATH . '/order/view/' . $order['ordernum']);
                }

            }else {
                //校验失败
                $message = 'not authorized';
                Message::set($message, 'error');
                $this->request->redirect(BASEURL . LANGPATH . '/customer/orders/');
            }
        }else{
            $this->request->redirect(BASEURL . LANGPATH );
            exit;
        }

    }

    public function action_ipay_notice()
    {
        if($_POST)
        {
//            $_POST = unserialize('a:17:{s:13:"acquiringTime";s:14:"20170302031444";s:7:"charset";s:1:"1";s:12:"completeTime";s:14:"20170302171445";s:12:"currencyCode";s:3:"USD";s:6:"dealId";s:19:"1021703021714182738";s:8:"language";s:0:"";s:16:"merchantBillName";s:7:"mijhola";s:11:"orderAmount";s:4:"5089";s:7:"orderId";s:11:"18222171341";s:9:"partnerId";s:11:"10000008740";s:5:"rates";s:0:"";s:6:"remark";s:0:"";s:10:"resultCode";s:4:"0000";s:9:"resultMsg";s:42:"The transaction has completed:交易成功";s:22:"settlementCurrencyCode";s:3:"USD";s:15:"settlementRates";s:0:"";s:8:"signType";s:1:"2";}');
kohana::$log->add('ipay_notice_1',serialize($_POST));
            $return['orderId']                    = $_POST['orderId'];
            $return['resultCode']                 = $_POST['resultCode'];
            $return['resultMsg']                  = $_POST['resultMsg'];
            $return['orderAmount']                = $_POST['orderAmount'];
            $return['currencyCode']               = $_POST['currencyCode'];
            $return['merchantBillName']           = $_POST['merchantBillName'];
            $return['settlementCurrencyCode']     = $_POST['settlementCurrencyCode'];
            $return['acquiringTime']              = $_POST['acquiringTime'];
            $return['completeTime']               = $_POST['completeTime'];
            $return['dealId']                     = $_POST['dealId'];
            $return['partnerId']                  = $_POST['partnerId'];
            $return['remark']                     = $_POST['remark'];
            $return['language']                   = $_POST['language'];
            $return['settlementRates']            = $_POST['settlementRates'];
            $return['rates']                      = $_POST['rates'];
            $return['charset']                    = $_POST['charset'];
            $return['signType']                   = $_POST['signType'];
            $signMsg                              = $_POST['signMsg'];

            ksort($return);
//            $signMsg = '24a86d71cc84fa6e9c94771e3f824ca4';
            $localVerify = '';
            foreach ($return as $key => $value)
            {
                if($value)
                {
                    $localVerify .= $key.'='.trim($value).'&';
                }
            }
            //$ipayKey 商户公钥，在ipay账号里下载。该公钥每次下载，都要更新这里，否则无法支付
            $ipayKey = kohana::config('ipayConfig');
            $localVerify  .= 'pkey='.$ipayKey[0];

            //本地校验
            if(md5($localVerify) == $signMsg)
            {
                Kohana_Log::instance()->add('IPAY_NOTICE', serialize($return))->write();
                $order_id = Order::get_from_ordernum($return['orderId']);
                DB::update('orders_order')->set(array('payment_method' => 'IPAY'))->where('id', '=', $order_id)->execute();
                $order = Order::instance($order_id)->get();
                $data= array();
                $data['dealId'] = $return['dealId'];
                $data['currencyCode'] = $return['currencyCode'];
                $amount = (float)$return['orderAmount']*0.01;
                $data['amount'] = $amount;

                if ($return['resultCode'] == '0000')
                {
                    $data['status'] = 1;
                }else{
                    $data['status'] = 0;
                }

                Payment::instance('IPAY')->pay($order, $data);
                header("HTTP/1.1 200 OK");
                die;
            }else{
                $order_id = Order::get_from_ordernum($return['orderId']);
                DB::update('orders_order')->set(array('payment_status' => 'failed'))->where('id', '=', $order_id)->execute();
            }

        }

    }

    #masapay 跳转方式
    public function action_masapay($ordernum)
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
        $order_id = Order::instance()->get_from_ordernum($ordernum);
        if(!$order_id)
        {
            $message = 'not';
            Message::set($message, 'error');
            $this->request->redirect(BASEURL . LANGPATH . '/customer/orders/');
        }


        $order = Order::instance($order_id);
        $orderInfo = $order->get();
        if($orderInfo['customer_id'] != $customer_id)
        {
            $this->request->redirect(BASEURL . LANGPATH . '/customer/orders/');
        }
        if($orderInfo['payment_status'] == 'success' OR $orderInfo['payment_status'] == 'verify_pass')
        {
            $this->request->redirect(LANGPATH . '/payment/success/' . $ordernum);
        }
        if($orderInfo['payment_status'] == 'pending')
        {
            Message::set(__('payment_pending'), 'notice');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
        if(!$orderInfo['is_active'])
        {
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
        if($orderInfo['payment_method'] != 'MASAPAY')
        {
            DB::update('orders_order')->set(array('payment_method' => 'MASAPAY'))->where('id', '=', $orderInfo['id'])->execute();
        }

        $goodsInfo = $order->goodsInfo();


        $currencyCode = $orderInfo['currency'];
        $ipayCountryCode = kohana::config('ipayCountryCode');

        //转义
        $find = array("'","\"",'>','<');
        $replace = array("&#039;","&quot;","&gt;","&lt;");
        $orderInfo['shipping_firstname'] = str_replace($find, $replace, $orderInfo['shipping_firstname']);
        $orderInfo['shipping_lastname'] = str_replace($find, $replace, $orderInfo['shipping_lastname']);
        $customer_id = Customer::logged_in();
        $customer = Customer::instance($customer_id);
        $order_id = Order::instance()->get_from_ordernum($ordernum);
        if(!$order_id)
        {
            $this->request->redirect(BASEURL);
        }

        $amount = (float)$orderInfo['amount']*100;
        $ip = $_SERVER["REMOTE_ADDR"];
        $state = '';
        if($orderInfo['shipping_country']=='US' )
        {
            $us = kohana::config('state.states.US');
            foreach ($us as $value)
            {
                foreach ($value as $key => $v)
                {
                    if($orderInfo['shipping_state']==$v)
                    {
                        $state = $key;
                    }
                }
            }

        }elseif ($orderInfo['shipping_country'] == 'CA')
        {
            $ca = kohana::config('state.states.CA');
            foreach ($ca as $key=>$value)
            {
                if($orderInfo['shipping_state']==$value)
                {
                    $state = $key;
                }

            }
        }
        else{
            $state = $orderInfo['shipping_state'];
        }

        if($orderInfo['shipping_country'] == 'CA')
        {

            if(preg_match('/^([A-Z]\d[A-Z]\s\d[A-Z]\d)$/',$orderInfo['shipping_zip']) or preg_match('/^([A-Z]\d[A-Z]\d[A-Z]\d)$/',$orderInfo['shipping_zip']))
            {
                $postCode   = $orderInfo['shipping_zip'];
            }else{
                $postCode   = 'V9V 9V9';
            };

        }
        elseif($orderInfo['shipping_country'] == 'US')
        {

            if(preg_match('/^(\d\d\d\d\d)$/',$orderInfo['shipping_zip']))
            {
                $postCode   = $orderInfo['shipping_zip'];

            }else{
                $postCode   = '00000';
            };

        }else{
            $postCode   = $orderInfo['shipping_zip'];
        }
        if($amount<0.01)
        {
            DB::update('orders_order')->set(array('payment_method' => 'MASAPAY','payment_status'=>'success'))->where('id', '=', $order_id)->execute();
            $this->request->redirect('/payment/success/' . $orderInfo['ordernum']);
        }
        //basic
        $data['version'] = '1.5';
        $data['merchantId'] = $this->masapayId;
        $data['charset'] = 'utf-8';
        $data['language'] = 'en';
        $data['signType'] = 'MD5';
        //
        $data['merchantOrderNo'] = $ordernum;
        $data['goodsName'] = $goodsInfo['name'];
        $data['goodsDesc'] = $goodsInfo['desc'];
        $data['currencyCode'] = $orderInfo['currency'];
        $data['orderAmount'] = (string)$amount;
        $data['payMode'] = '10'; //支付方式
        $data['directFlag'] = 'D'; //连接方式
        $data['submitTime'] = date('YmdHis',time());

        $data['pageUrl'] = BASEURL . LANGPATH . '/payment/masapay_return/';
        $data['bgUrl'] = BASEURL.'/payment/masapay_response';

       //shipping
        $data['shippingFirstName'] = $orderInfo['shipping_firstname'];
        $data['shippingLastName'] = $orderInfo['shipping_lastname'];
        $data['shippingAddress'] = $orderInfo['shipping_address'];
        $data['shippingPostalCode'] = $postCode;
        $data['shippingCountry'] = $orderInfo['shipping_country'];
        $data['shippingState'] = $state;
        $data['shippingCity'] = $orderInfo['shipping_city'];
        $data['shippingEmail'] = $orderInfo['email'];
        $data['shippingPhoneNumber'] = $orderInfo['shipping_phone'];
        //billing
        $data['billFirstName'] = $orderInfo['shipping_firstname'];
        $data['billLastName'] = $orderInfo['shipping_lastname'];
        $data['billAddress'] = $orderInfo['shipping_address'];
        $data['billPostalCode'] = $postCode;
        $data['billCountry'] = $orderInfo['shipping_country'];
        $data['billState'] = $state;
        $data['billCity'] = $orderInfo['shipping_city'];
        $data['billEmail'] = $orderInfo['email'];
        $data['billPhoneNumber'] = $orderInfo['shipping_phone'];
        //other
        $data['registerUserEmail'] = $orderInfo['email'];
        $data['registerTime'] = date('YmdHis',$customer->get('created'));
        $data['registerIp'] = $customer->get('ip');
        $data['registerTerminal'] = '00';
        $data['orderIp'] = $ip;
        $data['orderTerminal'] = '00';

        $signMsg = '';
        $check = array('version','merchantId','signType','merchantOrderNo','currencyCode','orderAmount','submitTime');
        foreach ($check as  $value)
        {
            $signMsg .= $value.'='.trim($data[$value]).'&';
        }
        $signMsg .= 'key='.$this->masapayKey;
        $data['signMsg'] = md5($signMsg);
        $correct_url = $this->masapayPostUrl;
    kohana::$log->add('masa_data',serialize($data));
        $isgift = 1;
        $this->template = View::factory('/payment')
            ->set('paypal_form', Payment::instance('MASAPAY')->form($data,$correct_url))
            ->set('ordernum', $ordernum)->set('isgift',$isgift);



    }

    #masapay 客户端
    public function action_masapay_return()
    {

        if($_POST)
        {
			kohana::$log->add('masapay_return',serialize($_POST));
            $return = array();
            $return['ordernum']     =   Arr::get($_POST,'merchantOrderNo','');
            $return['trans_id']     =   Arr::get($_POST,'masapayOrderNo','');
            $return['currency']     =   Arr::get($_POST,'currencyCode','');
            $return['order_amount'] =   Arr::get($_POST,'orderAmount','');
            $return['pay_amount']   =   Arr::get($_POST,'payAmount','');
            $return['resultCode']   =   Arr::get($_POST,'resultCode','');
            $return['errCode']      =   Arr::get($_POST,'errCode','');
            $return['errMsg']       =   Arr::get($_POST,'errMsg','');
            $return['signType']     =   Arr::get($_POST,'signType','');
            $return['signMsg']               =   Arr::get($_POST,'signMsg','');
            $check = array('signType','merchantOrderNo','currencyCode','orderAmount','payAmount','resultCode');
            $signMsg = '';
            foreach ($check as $value)
            {
                $signMsg .= $value.'='.trim($_POST[$value]).'&';
            }
            $signMsg .= 'key='.$this->masapayKey;
            if(strtoupper(md5($signMsg)) == $return['signMsg'])
            {
                Kohana::$log->add('MASAPAY_RETURN', serialize($return).'|singMsg:'.$signMsg);
                $order_id = Order::get_from_ordernum($return['ordernum']);
                DB::update('orders_order')->set(array('payment_method' => 'MASAPAY'))->where('id', '=', $order_id)->execute();
                $order = Order::instance($order_id)->get();
                if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass') {
                    echo '<script language="javascript">top.location.replace("' . BASEURL . '/payment/success/' . $order['ordernum'] . '");</script>';
                    exit;
                }
                if($return['resultCode'] == '10' or $return['resultCode'] == '00' or $return['resultCode'] == '12')
                {
//                    $this->request->redirect(BASEURL . LANGPATH . '/payment/success/' . $order['ordernum']);
                    $this->request->redirect('/payment/success/' . $order['ordernum']);
                }else{
                    $message = 'Payment failure.';
                    Message::set($message, 'error');
                    $this->request->redirect(BASEURL . LANGPATH . '/order/view/' . $order['ordernum']);
                }
            }
            else
            {
                //校验失败
                $message = 'not authorized';
                Message::set($message, 'error');
                $this->request->redirect(BASEURL . LANGPATH . '/customer/orders/');
            }
        }
        else
        {
            $this->request->redirect(BASEURL . LANGPATH );
            exit;
        }
    }

    #masapay 服务端
    public function action_masapay_response()
    {

        if($_POST)
        {
            kohana::$log->add('masapay_response',serialize($_POST));
            $return = array();

            $return['version']          =   Arr::get($_POST,'version','');
            $return['charset']          =   Arr::get($_POST,'charset','');
            $return['language']         =   Arr::get($_POST,'language','');
            $return['signType']         =   Arr::get($_POST,'signType','');
            $return['serviceType']      =   Arr::get($_POST,'serviceType','');

            $return['ordernum']         =   Arr::get($_POST,'merchantOrderNo','');
            $return['trans_id']         =   Arr::get($_POST,'masapayOrderNo','');
            $return['submitTime']       =   Arr::get($_POST,'submitTime','');
            $return['dealTime']         =   Arr::get($_POST,'dealTime','');
            $return['currency']         =   Arr::get($_POST,'currencyCode','');
            $return['orderAmount']      =   Arr::get($_POST,'orderAmount','');
            $return['paidAmount']       =   Arr::get($_POST,'paidAmount','');
            $return['resultCode']       =   Arr::get($_POST,'resultCode','');
            $return['signMsg']          =   Arr::get($_POST,'signMsg','');
            $check = array('version','signType','merchantOrderNo','currencyCode','orderAmount','paidAmount','submitTime','resultCode');
            $signMsg = '';
            foreach ($check as  $value)
            {
                $signMsg .= $value.'='.trim($_POST[$value]).'&';
            }
            $signMsg .= 'key='.$this->masapayKey;
            if($return['signMsg'] == strtoupper(md5($signMsg)))
            {
                kohana::$log->add('masapay_response',serialize($return));
                $order_id = Order::get_from_ordernum($return['ordernum']);
                DB::update('orders_order')->set(array('payment_method' => 'MASAPAY'))->where('id', '=', $order_id)->execute();
                $order = Order::instance($order_id)->get();
                $data= array();
                $data['trans_id'] = $return['trans_id'];
                $data['currencyCode'] = $return['currency'];
                $amount = (float)$return['orderAmount']*0.01;
                $data['amount'] = $amount;

                if ($return['resultCode'] == '10')//支付成功
                {
                    $data['status'] = 1;
                }elseif ($return['resultCode'] == '12'){ //支付滞留
                    $data['status'] = 2;
                }else{                              //支付失败
                    $data['status'] = 0;
                }

                Payment::instance('MASAPAY')->pay($order, $data);
                header("HTTP/1.1 200 OK");
            }else{
                $order_id = Order::get_from_ordernum($return['ordernum']);
                DB::update('orders_order')->set(array('payment_status' => 'failed'))->where('id', '=', $order_id)->execute();
            }
        }else{
            $this->request->redirect(BASEURL . LANGPATH );
            exit;
        }
    }

    #masapay 内联方式
    public function action_masapay_inner($ordernum)
    {
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }

        $order_id = Order::instance()->get_from_ordernum($ordernum);
        if(!$order_id)
        {
            $this->request->redirect(BASEURL);
        }
        $order = Order::instance($order_id);
        if(in_array($order->get('payment_status'),array('success','verify_pass')))
        {
            $this->request->redirect(BASEURL);
        }
        $billadress = array();
        if($order->get('billing_country') and $order->get('billing_city'))
        {
            $billadress['firstName'] = $order->get('billing_firstname');
            $billadress['lastName'] = $order->get('billing_lastname');
            $billadress['address'] = $order->get('billing_address');
            $billadress['state'] = $order->get('billing_state');
            $billadress['city'] = $order->get('billing_city');
            $billadress['zip'] = $order->get('billing_zip');
            $billadress['phone'] = $order->get('billing_phone');
            $billadress['country'] = $order->get('billing_country');

        }
        $shipping['firstName'] = $order->get('shipping_firstname');
        $shipping['lastName'] = $order->get('shipping_lastname');
        $shipping['address'] = $order->get('shipping_address');
        $shipping['state'] = $order->get('shipping_state');
        $shipping['city'] = $order->get('shipping_city');
        $shipping['zip'] = $order->get('shipping_zip');
        $shipping['phone'] = $order->get('shipping_phone');
        $shipping['country'] = $order->get('shipping_country');
        $address = (!empty($billadress))?$billadress:$shipping;
        $currency = $order->get('currency');
        $amount = $order->get('amount');

        $countries_top = Site::instance()->countries_top(LANGUAGE);
        $countries = Site::instance()->countries(LANGUAGE);
        $this->template->type = 'purchase';
        $this->template->content = View::factory('/masapay')
            ->set('ordernum',$ordernum)
            ->set('billAddress',$address)
            ->set('countries_top',$countries_top)
            ->set('countries',$countries)
            ->set('currency',$currency)
            ->set('amount',$amount);
    }

    #masapay
    public function action_masapay_inner_pay()
    {
        #验证
        if (!($customer_id = Customer::logged_in()))
        {
            Request::instance()->redirect(URL::base() . 'customer/login?redirect=' . URL::current(TRUE));
        }
        if(!$_POST['cardNumber'] or !$_POST['cardMonth'] or !$_POST['cardYear'] or !$_POST['cardCode']  or !$_POST['ordernum'])
        {
            $this->request->redirect(BASEURL . LANGPATH . '/customer/orders/');
        }
        $card['cardNumber']  = trim(Arr::get($_POST,'cardNumber',''));
        $card['cardMonth']  = trim(Arr::get($_POST,'cardMonth',''));
        $card['cardYear']  = trim(Arr::get($_POST,'cardYear',''));
//        $card['cardEmail']  = trim(Arr::get($_POST,'cardEmail',''));
        $card['cardCode']  = trim(Arr::get($_POST,'cardCode',''));
        $ordernum = trim(Arr::get($_POST,'ordernum',''));
        $order_id = Order::instance()->get_from_ordernum($ordernum);
        if(!$order_id)
        {
            $message = 'not';
            Message::set($message, 'error');
            $this->request->redirect(BASEURL . LANGPATH . '/customer/orders/');
        }


        $order = Order::instance($order_id);
        $orderInfo = $order->get();
        if($orderInfo['customer_id'] != $customer_id)
        {
            $this->request->redirect(BASEURL . LANGPATH . '/customer/orders/');
        }
        if($orderInfo['payment_method'] != 'IPAY')
        {
            DB::update('orders_order')->where('id', '=', $orderInfo['id'])->set(array('payment_method' => 'MASAPAY'))->execute();
        }
        if(!$orderInfo['is_active'])
        {
            $this->request->redirect(LANGPATH . '/customer/orders');
        }
        if($orderInfo['payment_status'] == 'success' OR $orderInfo['payment_status'] == 'verify_pass')
        {
            $this->request->redirect(LANGPATH . '/payment/success/' . $ordernum);
        }
        if($orderInfo['payment_status'] == 'pending')
        {
            Message::set(__('payment_pending'), 'notice');
            $this->request->redirect(LANGPATH . '/order/view/' . $ordernum);
        }
        if ($orderInfo['customer_id'] != $customer_id)
        {
            $this->request->redirect(LANGPATH . '/404');
        }

        #参数处理
        $goodsInfo = $order->goodsInfo();
        $ip = $_SERVER["REMOTE_ADDR"];
        $amount = (float)$orderInfo['amount']*100;

        $customer_id = Customer::logged_in();
        $customer = Customer::instance($customer_id);
        //转义
        $find = array("'","\"",'>','<');
        $replace = array("&#039;","&quot;","&gt;","&lt;");
        $orderInfo['shipping_firstname'] = str_replace($find, $replace, $orderInfo['shipping_firstname']);
        $orderInfo['shipping_lastname'] = str_replace($find, $replace, $orderInfo['shipping_lastname']);
        # billing地址
        if(!$orderInfo['billing_firstname'] and !$orderInfo['billing_lastname'] and !$orderInfo['billing_country'])
        {
            $billing['billing_firstname'] = $orderInfo['shipping_firstname'];
            $billing['billing_lastname'] = $orderInfo['shipping_lastname'];
            $billing['billing_country'] = $orderInfo['shipping_country'];
            $billing['billing_state'] = $orderInfo['shipping_state'];
            $billing['billing_city'] = $orderInfo['shipping_city'];
            $billing['billing_address'] = $orderInfo['shipping_address'];
            $billing['billing_zip'] = $orderInfo['shipping_zip'];
            $billing['billing_phone'] = $orderInfo['shipping_phone'];
            DB::update('orders_order')->where('ordernum','=',$ordernum)->set($billing)->execute();
        }
        $billing = DB::select()->from('orders_order')->where('ordernum','=',$ordernum)->execute()->current();

        #US/CA的州/省验证处理
        $state = '';
        $billingstate = '';
        if($orderInfo['shipping_country']=='US' )
        {
            $us = kohana::config('state.states.US');
            foreach ($us as $value)
            {
                foreach ($value as $key => $v)
                {
                    if($orderInfo['shipping_state']==$v)
                    {
                        $state = $key;
                    }
                    if($billing['billing_state']==$v)
                    {
                        $billingstate = $key;
                    }
                }
            }

        } elseif ($orderInfo['shipping_country'] == 'CA') {
            $ca = kohana::config('state.states.CA');
            foreach ($ca as $key=>$value)
            {
                if($orderInfo['shipping_state']==$value)
                {
                    $state = $key;
                }
                if($billing['billing_state']==$value)
                {
                    $billingstate = $key;
                }

            }
        } else{
            $state = $orderInfo['shipping_state'];
            $billingstate = $billing['billing_state'];
        }

        #US/CA的邮编处理
        if($orderInfo['shipping_country'] == 'CA')
        {

            if(preg_match('/^([A-Z]\d[A-Z]\s\d[A-Z]\d)$/',$orderInfo['shipping_zip']) or preg_match('/^([A-Z]\d[A-Z]\d[A-Z]\d)$/',$orderInfo['shipping_zip']))
            {
                $postCode   = $orderInfo['shipping_zip'];
                $billingpostCode   = $billing['billing_zip'];
            }else{
                $postCode = 'V9V 9V9';
                $billingpostCode = 'V9V 9V9';
            };

        }
        elseif($orderInfo['shipping_country'] == 'US')
        {

            if(preg_match('/^(\d\d\d\d\d)$/',$orderInfo['shipping_zip']))
            {
                $postCode   = $orderInfo['shipping_zip'];
                $billingpostCode   = $billing['billing_zip'];

            }else{
                $postCode   = '00000';
                $billingpostCode   = '00000';
            };

        }else{
            $postCode   = $orderInfo['shipping_zip'];
            $billingpostCode   = $billing['billing_zip'];
        }

        if($amount<0.01)
        {
            DB::update('orders_order')->set(array('payment_method' => 'MASAPAY','payment_status'=>'success'))->where('id', '=', $order_id)->execute();
            $this->request->redirect('/payment/success/' . $orderInfo['ordernum']);
        }
        //basic
        $data['version'] = '1.5';
        $data['merchantId'] = $this->masapayId;
        $data['charset'] = 'utf-8';
        $data['language'] = 'en';
        $data['signType'] = 'MD5';
        //
        $data['merchantOrderNo'] = $ordernum;
        $data['goodsName'] = $goodsInfo['name'];
        $data['goodsDesc'] = $goodsInfo['desc'];
        $data['currencyCode'] = $orderInfo['currency'];
        $data['orderAmount'] = (string)$amount;
        $data['payMode'] = '10'; //支付方式
        $data['directFlag'] = 'D'; //连接方式
        $data['submitTime'] = date('YmdHis',time());

        $data['pageUrl'] = BASEURL . LANGPATH . '/payment/masapay_return/';
        $data['pageUrl'] =  'http://local.newchoies.com/payment/masapay_return/';
        $data['bgUrl'] = BASEURL.'/payment/masapay_response';
        $data['bgUrl'] = 'http://local.newchoies.com/payment/masapay_response';

        //shipping
        $data['shippingFirstName'] = $orderInfo['shipping_firstname'];
        $data['shippingLastName'] = $orderInfo['shipping_lastname'];
        $data['shippingAddress'] = $orderInfo['shipping_address'];
        $data['shippingPostalCode'] = $postCode;
        $data['shippingCountry'] = $orderInfo['shipping_country'];
        $data['shippingState'] = $state;
        $data['shippingCity'] = $orderInfo['shipping_city'];
        $data['shippingEmail'] = $orderInfo['email'];
        $data['shippingPhoneNumber'] = $orderInfo['shipping_phone'];
        //billing
        $data['billFirstName'] = $billing['billing_firstname'];
        $data['billLastName'] = $billing['billing_lastname'];
        $data['billAddress'] = $billing['billing_address'];
        $data['billPostalCode'] = $billingpostCode;
        $data['billCountry'] = $billing['billing_country'];
        $data['billState'] = $billingstate;
        $data['billCity'] = $billing['billing_city'];
        $data['billEmail'] = $billing['email'];
        $data['billPhoneNumber'] = $billing['billing_phone'];
        //other
        $data['registerUserEmail'] = $orderInfo['email'];
        $data['registerTime'] = date('YmdHis',$customer->get('created'));
        $data['registerIp'] = $customer->get('ip');
        $data['registerTerminal'] = '00';
        $data['orderIp'] = $ip;
        $data['orderTerminal'] = '00';

        $signMsg = '';
        $check = array('version','merchantId','signType','merchantOrderNo','currencyCode','orderAmount','submitTime');
        foreach ($check as  $value)
        {
            $signMsg .= $value.'='.trim($data[$value]).'&';
        }
        $signMsg .= 'key='.$this->masapayKey;
        $data['signMsg'] = md5($signMsg);

        #发送数据
        $correct_url = $this->masapayPostUrl;
        $correct_url = $this->masapayTestUrl;
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $correct_url);
        curl_setopt ( $ch, CURLOPT_FAILONERROR, false );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        //以post请求发送
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        if(curl_errno($ch))
        {
            print curl_error($ch);
            $message = 'Communication failure';
            Message::set($message, 'error');
            die;
            $this->request->redirect(BASEURL . LANGPATH . '/customer/orders/');
        }
        curl_close($ch);
        
        #对获取的数据验证、处理
        if($response)
        {
            kohana::$log->add('masapay_return',serialize($_POST));
            $return = array();
            $return['ordernum']     =   Arr::get($_POST,'merchantOrderNo','');
            $return['trans_id']     =   Arr::get($_POST,'masapayOrderNo','');
            $return['currency']     =   Arr::get($_POST,'currencyCode','');
            $return['order_amount'] =   Arr::get($_POST,'orderAmount','');
            $return['pay_amount']   =   Arr::get($_POST,'payAmount','');
            $return['resultCode']   =   Arr::get($_POST,'resultCode','');
            $return['errCode']      =   Arr::get($_POST,'errCode','');
            $return['errMsg']       =   Arr::get($_POST,'errMsg','');
            $return['signType']     =   Arr::get($_POST,'signType','');
            $return['signMsg']               =   Arr::get($_POST,'signMsg','');
            $check = array('signType','merchantOrderNo','currencyCode','orderAmount','payAmount','resultCode');
            $signMsg = '';
            foreach ($check as $value)
            {
                $signMsg .= $value.'='.trim($_POST[$value]).'&';
            }
            $signMsg .= 'key='.$this->masapayKey;
            if(strtoupper(md5($signMsg)) == $return['signMsg'])
            {
                Kohana::$log->add('MASAPAY_RETURN', serialize($return).'|singMsg:'.$signMsg);
                $order_id = Order::get_from_ordernum($return['ordernum']);
                DB::update('orders_order')->set(array('payment_method' => 'MASAPAY'))->where('id', '=', $order_id)->execute();
                $order = Order::instance($order_id)->get();
                if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass') {
                    echo '<script language="javascript">top.location.replace("' . BASEURL . '/payment/success/' . $order['ordernum'] . '");</script>';
                    exit;
                }
                if($return['resultCode'] == '10' or $return['resultCode'] == '00' or $return['resultCode'] == '12')
                {
                    $this->request->redirect('/payment/success/' . $order['ordernum']);
                }else{
                    $message = 'Payment failure.';
                    Message::set($message, 'error');
                    $this->request->redirect( '/order/view/' . $order['ordernum']);
                }
            }
            else
            {
                //校验失败
                $message = 'not authorized';
                Message::set($message, 'error');
                $this->request->redirect( '/customer/orders/');
            }
        }
        else
        {
            $this->request->redirect(BASEURL . LANGPATH );
            exit;
        }

    }
    /**
    *  判断是否为xml
    *
    */
    function xml_parser($str){
        $xml_parser = xml_parser_create();
        if(!xml_parse($xml_parser,$str,true)){
            xml_parser_free($xml_parser);
            return false;
        }else {
            return true;
        }
    }


}

