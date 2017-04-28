<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * IPS Payment
 * @category	Payment
 * @author     Vincent
 * @copyright  (c) 2009-2012 Cofree
 */
class Payment_Globebill extends Payment
{

        public function jump($order)
        {
                //MD5key和商户id，固定值
//                $MD5key = "xFMoydhN";
//                $MerNo = "887327";
                $MD5key = "8nf8jhX6";
                $MerNo = "10470";

                //订单号
                $BillNo = $order['ordernum'];
                //交易金额
                $Amount = round($order['amount'], 2);
                //币种代码 如GBP
                $PayCurrency = $order['currency'];
                //用户基本信息
                $user_info = $order['shipping_firstname'] . "|" . $order['shipping_lastname'] . "|" . $order['shipping_address'] . "|" . $order['shipping_city'] . "|" . strtolower($order['shipping_country']) . "|" . $order['shipping_zip'] . "|" . $order['email'] . "|" . $order['billing_phone'] . "|" . $order['shipping_state'] . "||0";
                //返回地址
                $ReturnURL = BASEURL . '/payment/globebill_return';
                //remark
                // $Remark = $client_ip;
                //2个默认值 $Currency=15 $Language=2
                $Currency = "15";
                $Language = "2";

                //md5校验码 固定形式：md5($MerNo.$BillNo.$Currency.$Amount.$Language.$ReturnURL.$MD5key)
                $md5src = $MerNo . $BillNo . $Currency . $Amount . $Language . $ReturnURL . $MD5key;
                $MD5info = strtoupper(md5($md5src));

                $config = $this->_config['product'];
                //新商户号新接口
                if ($MerNo == 10470)
                {
                        $gatewayNo = 10470002;
                        $signkey = '8nf8jhX6';
                        $Amount = (floor($Amount * 100)) / 100;
                        $signInfo = hash("sha256", $MerNo . $gatewayNo . $BillNo . $PayCurrency . $Amount . $ReturnURL . $signkey);
                        return View::factory('globebill/newform')
                                        ->set('merNo', $MerNo)
                                        ->set('Payurl', isset($config['url']) ? $config['url'] : 'https://payment.billing-secureserver.com/payment/Interface')
                                        ->set('gatewayNo', $gatewayNo)
                                        ->set('orderNo', $BillNo)
                                        ->set('orderCurrency', $PayCurrency)
                                        ->set('orderAmount', $Amount)
                                        ->set('signInfo', $signInfo)
                                        ->set('returnUrl', $ReturnURL)
                                        ->set('firstName', $order['shipping_firstname'])
                                        ->set('lastName', $order['shipping_lastname'])
                                        ->set('country', $order['shipping_country'])
                                        ->set('city', $order['shipping_city'])
                                        ->set('address', $order['shipping_address'])
                                        ->set('zip', $order['shipping_zip'])
                                        ->set('email', $order['email'])
                                        ->set('phone', $order['shipping_phone'])
                                        ->render();
                }
                else
                {
                        return View::factory('globebill/form')
                                        ->set('MerNo', $config['MerNo'])
                                        ->set('action_url', $config['url'])
                                        ->set('BillNo', $BillNo)
                                        ->set('Amount', $Amount)
                                        ->set('user_info', $user_info)
                                        ->set('ReturnURL', $ReturnURL)
                                        ->set('Currency', $Currency)
                                        ->set('Language', $Language)
                                        ->set('PayCurrency', $PayCurrency)
                                        ->set('MD5info', $MD5info)
                                        //->set('Remark', $client_ip)
                                        ->render();
                }
        }

        public function check($response)
        {
                if (!$response OR !is_array($response))
                        return FALSE;

                $config = $this->_config['product'];
                if ($response['MerNo'] != $config['MerNo'])
                        return FALSE;
                //if(md5($response['payres'].$config['merchant_key']) != $response['payreshash']) return FALSE;

                return TRUE;
        }

        public function pay($order, $data = NULL)
        {
                $payment_log_status = "";

                $order_update = array(
                    'currency_payment'  => $order['currency'],
                    'transaction_id'    => $data['trans_id'],
                    'payment_date'      => time(),
                    'updated'           => time(),
                    'billing_firstname' => $order['shipping_firstname'],
                    'billing_lastname'  => $order['shipping_lastname'],
                    'billing_address'   => $order['shipping_address'],
                    'billing_zip'       => $order['shipping_zip'],
                    'billing_city'      => $order['shipping_city'],
                    'billing_state'     => $order['shipping_state'],
                    'billing_country'   => $order['shipping_country'],
                    'billing_phone'     => '',
                );


                //payment platform sync
                $post_var = "order_num=" . $order['ordernum']
                        . "&order_amount=" . $order['amount']
                        . "&order_currency=" . $order['currency']
                        . "&card_num=" . $data['cardnum']
                        . "&card_type=" . $order['cc_type']
                        . "&card_cvv=" . $order['cc_cvv']
                        . "&card_exp_month=" . $order['cc_exp_month']
                        . "&card_exp_year=" . $order['cc_exp_year']
                        . "&card_inssue=" . $order['cc_issue']
                        . "&card_valid_month=" . $order['cc_valid_month']
                        . "&card_valid_year=" . $order['cc_valid_year']
                        . "&billing_firstname=" . $order['shipping_firstname']
                        . "&billing_lastname=" . $order['shipping_lastname']
                        . "&billing_address=" . $order['shipping_address']
                        . "&billing_zip=" . $order['shipping_zip']
                        . "&billing_city=" . $order['shipping_city']
                        . "&billing_state=" . $order['shipping_state']
                        . "&billing_country=" . $order['shipping_country']
                        . "&billing_telephone=" . $order['shipping_phone']
                        . "&billing_ip_address=" . long2ip($order['ip'])
                        . "&billing_email=" . $order['email']
                        . "&shipping_firstname=" . $order['shipping_firstname']
                        . "&shipping_lastname=" . $order['shipping_lastname']
                        . "&shipping_address=" . $order['shipping_address']
                        . "&shipping_zip=" . $order['shipping_zip']
                        . "&shipping_city=" . $order['shipping_city']
                        . "&shipping_state=" . $order['shipping_state']
                        . "&shipping_country=" . $order['shipping_country']
                        . "&shipping_telephone=" . $order['shipping_phone']
                        . '&trans_id=' . $data['trans_id']
                        . "&site_id=" . Site::instance()->get('cc_payment_id')
                        . "&secure_code=" . Site::instance()->get('cc_secure_code')
                        . "&status=" . $data['succeed'];

                $mail_params['order_view_link'] = BASEURL . '/order/view/' . $order['ordernum'];
                $mail_params['order_num'] = $order['ordernum'];
                $mail_params['email'] = Customer::instance($order['customer_id'])->get('email');
                $mail_params['firstname'] = Customer::instance($order['customer_id'])->get('firstname');
                if(!$mail_params['firstname'])
                    $mail_params['firstname'] = 'customer';
                //新接口
                if ($data['merno'] == 10470)
                {
                        switch ($data['succeed'])
                        {
                                case '1':
                                        $order_update['amount_payment'] = $order['amount'];
                                        $order_update['payment_count'] = $order['payment_count'] + 1;
                                        $order_update['payment_status'] = 'success';
                                        $payment_log_status = 'success';

                                        Order::instance($order['id'])->set($order_update);
                                        $result = Toolkit::curl_pay('https://www.shuiail.com/globebill', $post_var);
//                                        $result = unserialize(stripcslashes($result));
                                        $status = 'SUCCESS';
                                        $products = $order['products'] ? unserialize($order['products']) : array();
                                        foreach($products as $p)
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
                                        $customer_id = $order['customer_id'];
                                        $celebrity_id = Customer::instance($customer_id)->is_celebrity();
                                        $order_products = Order::instance($order['id'])->products();
                                        $currency = Site::instance()->currencies($order['currency']);
                                        
                                        foreach ($order_products as $rs)
                                        {
                                            $mail_params['order_product'] .= '<tr align="left">
                                                                <td>' . Product::instance($rs['item_id'])->get('name') . '</td>
                                                                <td>QTY:' . $rs['quantity'] . '</td>
                                                                <td>' . $rs['attributes'] . '</td>
                                                                <td>' . $currency['code'] . round($rs['price'] * $order['rate'], 2) . '</td>
                                                        </tr>';
                                        }
                                        $mail_params['order_product'] .= '</tbody></table>';

                                        $mail_params['currency'] = $order['currency'];
                                        $mail_params['amount'] = round($order['amount'],2);
                                        $mail_params['pay_num'] = round($order['amount'],2);
                                        $mail_params['pay_currency'] = $order['currency'];
                                        $mail_params['shipping_firstname'] = $order['shipping_firstname'];
                                        $mail_params['shipping_lastname'] = $order['shipping_lastname'];
                                        $mail_params['address'] = $order['shipping_address'];
                                        $mail_params['city'] = $order['shipping_city'];
                                        $mail_params['state'] = $order['shipping_state'];
                                        $mail_params['country'] = $order['shipping_country'];
                                        $mail_params['zip'] = $order['shipping_zip'];
                                        $mail_params['phone'] = $order['shipping_phone'];
                                        $mail_params['shipping_fee'] = round($order['amount_shipping'],2);
                                        $mail_params['payname'] = '';
                                        $mail_params['created'] = date('Y-m-d H:i', $order['created']);
                                        $mail_params['points'] = floor($order['amount']);
                                        if ($celebrity_id)
                                        {
                                                Kohana_Log::instance()->add('SendMail', 'PAYSUCCESS');
                                                Mail::SendTemplateMail('BLOGGER PAYSUCCESS', $mail_params['email'], $mail_params);
                                        }
                                        else
                                        {
                                                // $quantity = DB::select('id')->from('orders_order')
                                                //         ->where('customer_id', '=', $customer_id)
                                                //         ->and_where('id', '<', $order['id'])
                                                //         ->and_where('payment_status', 'IN', array('success', 'verify_pass'))
                                                //         ->execute()->get('id');
                                                // if($quantity)
                                                // {
                                                //          $vip_level = Customer::instance($customer_id)->get('vip_level');
                                                //         $vip_return = DB::select('return')->from('vip_types')->where('level', '=', $vip_level)->execute()->get('return');

                                                //         $points = ($order['amount'] / $order['rate']) * $vip_return;
                                                // }
                                                // else
                                                // {
                                                //         $points = 1000;
                                                // }
                                                // $mail_params['order_points'] = $points;
                                                Kohana_Log::instance()->add('SendMail', 'PAYSUCCESS');
                                                Mail::SendTemplateMail('PAYSUCCESS', $mail_params['email'], $mail_params);
                                        }

                                        break;
                                case '0':
                                        if($data['message'] == 'I0061:Merchant order NO.has unsuccessful transation')
                                        {
                                                if($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                                                {
                                                        $status = 'SUCCESS';
                                                        break;
                                                }
                                                else
                                                        $order_update['payment_status'] = 'repeat_pay';
                                        }
                                        else
                                        {
                                                $order_update['payment_status'] = $order['payment_status'] == 'success' ? 'success' : 'failed';
                                        }
                                        $payment_log_status = 'failed';
                                        Order::instance($order['id'])->set($order_update);
                                        $result = Toolkit::curl_pay('https://www.shuiail.com/globebill', $post_var);
                                        $status = 'FAILED';
                                        Kohana_Log::instance()->add('SendMail', 'UNPAID_MAIL')->write();
                                        Mail::SendTemplateMail('UNPAID_MAIL', $mail_params['email'], $mail_params);
                                        break;
                                default:
                                        $order_update['payment_status'] = 'pending';
                                        $payment_log_status = 'pending';
                                        $status = 'PENDING';
                                        Order::instance($order['id'])->set($order_update);
                                        break;
                        }
                }
                else
                {
                        //支付不成功时得到真实支付状态
                        $paystr = "merno=" . $data['merno']
                                . "&billno=" . $data['order_num']
                                . "&md5info=" . md5($data['merno'] . $data['MD5key']);
                        $get_result = Toolkit::curl_pay("http://mers.globebill.com/Merchant/BatchOrderQuery", $paystr);
                        $xml = new DOMDocument();
                        $xml->loadXML($get_result);
                        $get_status = $xml->getElementsByTagName('status')->item(0)->nodeValue; //支付结果

                        switch ($data['succeed'])
                        {
                                case '1':
                                        $order_update['amount_payment'] = $order['amount'];
                                        $order_update['payment_count'] = $order['payment_count'] + 1;
                                        $order_update['payment_status'] = 'success';
                                        $payment_log_status = 'success';

                                        $result = Toolkit::curl_pay('https://www.shuiail.com/globebill', $post_var);
//                                        $result = unserialize(stripcslashes($result));
                                        $status = 'SUCCESS';
                                        break;
                                case '0':
                                        if ($get_status == 7)
                                        {
                                                $order_update['payment_status'] = 'pending';
                                                $payment_log_status = 'pending';
                                                $status = 'PENDING';
                                                break;
                                        }
                                        else
                                        {
                                                $order_update['payment_status'] = 'failed';
                                                $payment_log_status = 'failed';
                                                $result = Toolkit::curl_pay('https://www.shuiail.com/globebill', $post_var);
                                                $status = 'FAILED';
                                                break;
                                        }
                                /* if ($data['BankID'] == 1156)
                                  {
                                  $order_update['payment_status'] = 'pending';
                                  $payment_log_status = 'pending';
                                  break;
                                  }
                                  else
                                  {
                                  $order_update['payment_status'] = 'failed';
                                  $payment_log_status = 'failed';
                                  break;
                                  } */
                        }
                }

//                $result = Toolkit::curl_pay('https://www.shuiail.com/globebill', $post_var);
//                $result = 'a:7:{s:9:"status_id";i:9;s:8:"trans_id";s:18:"133983815803989246";s:7:"message";s:21:"Globebill支付结果";s:3:"api";s:9:"Globebill";s:3:"avs";N;s:6:"status";s:7:"capture";s:4:"flag";s:1:"A";}';
                //支付平台日志
                Kohana_Log::instance()->add('Payment status return', $result)->write();
                
                $result = unserialize(stripcslashes($result));
//

                $payment_log = array(
                    'site_id'        => Site::instance()->get('id'),
                    'order_id'       => $order['id'],
                    'customer_id'    => $order['customer_id'],
                    'payment_method' => $this->_config['name'],
                    'trans_id'       => $data['trans_id'],
                    'amount'         => $order['amount'],
                    'currency'       => $order['currency'],
                    'comment'        => $data['message'],
                    'cache'          => serialize($data),
                    'payment_status' => $payment_log_status,
                    'ip'             => ip2long(Request::$client_ip),
                    'created'        => time(),
                    'first_name'     => $order['shipping_firstname'],
                    'last_name'      => $order['shipping_lastname'],
                    'email'          => $order['email'],
                    'address'        => $order['shipping_address'],
                    'zip'            => $order['shipping_zip'],
                    'city'           => $order['shipping_city'],
                    'state'          => $order['shipping_state'],
                    'country'        => $order['shipping_country'],
                    'phone'          => '',
                );
                $this->log($payment_log);

                return $status;
        }
        
        public function form($name = NULL, $view = NULL, $order = NULL, $config = NULL)
        {
                //MD5key和商户id，固定值
                $MD5key = "xFMoydhN";
                $MerNo = "887327";

                //订单号
                $BillNo = $order['ordernum'];
                //交易金额
                $Amount = round($order['amount'], 2);
                //币种代码 如GBP
                $PayCurrency = $order['currency'];
                //用户基本信息
                $user_info = $order['shipping_firstname'] . "|" . $order['shipping_lastname'] . "|" . $order['shipping_address'] . "|" . $order['shipping_city'] . "|" . strtolower($order['shipping_country']) . "|" . $order['shipping_zip'] . "|" . $order['email'] . "|" . $order['billing_phone'] . "|" . $order['shipping_state'] . "||0";
                //返回地址
                $ReturnURL = BASEURL . '/payment/globebill_return';
                //remark
                // $Remark = $client_ip;
                //2个默认值 $Currency=15 $Language=2
                $Currency = "15";
                $Language = "2";

                //md5校验码 固定形式：md5($MerNo.$BillNo.$Currency.$Amount.$Language.$ReturnURL.$MD5key)
                $md5src = $MerNo . $BillNo . $Currency . $Amount . $Language . $ReturnURL . $MD5key;
                $MD5info = strtoupper(md5($md5src));

                $config = $this->_config['product'];
                return View::factory('globebill/form_1')
                                ->set('MerNo', $config['MerNo'])
                                ->set('action_url', $config['url'])
                                ->set('BillNo', $BillNo)
                                ->set('Amount', $Amount)
                                ->set('user_info', $user_info)
                                ->set('ReturnURL', $ReturnURL)
                                ->set('Currency', $Currency)
                                ->set('Language', $Language)
                                ->set('PayCurrency', $PayCurrency)
                                ->set('MD5info', $MD5info)
                                //->set('Remark', $client_ip)
                                ->render();
        }
}

?>