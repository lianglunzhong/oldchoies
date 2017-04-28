<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Payment GCjump
 * @category     Payment
 * @author     Vincent
 * @copyright  (c) 2009-2012 Cofree
 */
class Payment_OceanPay extends Payment
{

        /**
         * Ocean payment
         * @param array $order	Order detail
         * @param array $data          Paypal return
         * @return stirng		SUCCESS
         */
        public function pay($order, $data = NULL)
        {
                $payment_log_status = "";

                $order_update = array(
                    'currency_payment'  => $data['order_currency'],
                    'transaction_id'    => $data['payment_id'],
                    'payment_date'      => time(),
                    'updated'           => time(),
                );

                //payment platform sync
                if($data['succeed'] == 1)
                {
                    $succeed = 1;
                }
                elseif($data['succeed'] == 0)
                {
                    $succeed = 0;
                }
                elseif($data['succeed'] == -1 && $data['payment_authType'] == 1)
                {
                    $succeed = 525;
                    //预授权
                    $data['succeed'] =1;
                }

                $post_var = "order_num=" . $order['ordernum']
                        . "&order_amount=" . $order['amount']
                        . "&order_currency=" . $order['currency']
                        . "&card_num=4263982640269299"
                        . "&card_type=1"
                        . "&card_cvv=111"
                        . "&card_exp_month=12"
                        . "&card_exp_year=15"
                        . "&card_inssue=" . $order['cc_issue']
                        . "&card_valid_month=12"
                        . "&card_valid_year=15"
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
                        . '&trans_id=' . $data['payment_id']
                        . "&site_id=" . Site::instance()->get('cc_payment_id')
                        . "&secure_code=" . Site::instance()->get('cc_secure_code')
                        . "&status=" . $succeed;

                $mail_params['order_view_link'] = BASEURL . '/order/view/' . $order['ordernum'];
                $mail_params['order_num'] = $order['ordernum'];
                $mail_params['email'] = Customer::instance($order['customer_id'])->get('email');
                $mail_params['emailaddress'] = $mail_params['email'];
                $mail_params['firstname'] = Customer::instance($order['customer_id'])->get('firstname');
                if(!$mail_params['firstname'])
                    $mail_params['firstname'] = 'customer';
                        
                switch ($data['succeed'])
                {
                        case '1':
                                $order_update['amount_payment'] = $order['amount'];
                                $order_update['payment_count'] = $order['payment_count'] + 1;
                                if($data['payment_authType'] == 1)
                                {
                                    $order_update['payment_status'] = 'pending';
                                    $payment_log_status = 'pending';
                                }
                                else
                                {
                                    $order_update['payment_status'] = 'success';
                                    $payment_log_status = 'success';
                                }

                                Order::instance($order['id'])->set($order_update);
                                
                                $result = Toolkit::curl_pay('http://manage.choiesriskcontrol.com/oceanpay', $post_var);

                                $result = unserialize(stripcslashes($result));

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
                                    $att = item::instance($rs['item_id'])->get('attribute');
                                    $mail_params['order_product'] .= '<tr align="left">
                                                        <td>' . Product::instance($rs['product_id'], $order['lang'])->get('name') . '</td>
                                                        <td>QTY:' . $rs['quantity'] . '</td>
                                                        <td>' . $att . '</td>
                                                        <td>' . $currency['code'] . round($rs['price'] * $order['rate'], 2) . '</td>
                                                </tr>';
                                }
                                kohana::$log->add('paysucess',json_encode($mail_params['order_product']).'|order:'.$order['ordernum']);
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
                                $mail_params['points'] = floor($order['amount'] / $order['rate']);
                                
                                if($data['payment_authType'] == 1)
                                {
                                    Kohana_Log::instance()->add('SendMail', 'OC PENDING');
                                    Mail::SendTemplateMail('GC PENDING', $mail_params['email'], $mail_params);
                                }
                                elseif ($celebrity_id)
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
                                        $mail_params['email'] = 'invoices@3auntt7rwt.referralcandy.com';
                                        Mail::SendTemplateMail('PAYSUCCESS', $mail_params['email'], $mail_params);
                                }

                                break;
                        case '0':
                                $order_update['payment_status'] = $order['payment_status'] == 'success' ? 'success' : 'failed';
                                $payment_log_status = 'failed';
                                Order::instance($order['id'])->set($order_update);
                                $result = Toolkit::curl_pay('http://manage.choiesriskcontrol.com/oceanpay', $post_var);
                                $status = 'FAILED';
                                $mail_params['order_view_link'] = '<a href="' . BASEURL . '/order/view/' . $order['ordernum'] . '">View your order</a>';
                                $mail_params['created'] = date('Y-m-d H:i', $order['created']);
                                $mail_params['order_num'] = $order['ordernum'];
                                $mail_params['currency'] = $order['currency'];
                                $mail_params['amount'] = round($order['amount'],2);
                                Order::instance($order['id'])->set($order_update);
                                $payment_details = explode(":",$data['payment_details']);
                                $filed_type = '';
                                if($payment_details[0] == 80010)
                                {
                                   $filed_type = 'FAILED_MAIL_HONOOUR'; 
                                }
                                elseif($payment_details[0] == 80022)
                                {
                                   $filed_type = 'FAILED_MAIL_FUNDS'; 
                                }
                                else
                                {
                                   $filed_type = 'FAILED_MAIL'; 
                                }
                                Kohana_Log::instance()->add('SendMail', $filed_type)->write();
                                Mail::SendTemplateMail($filed_type, $mail_params['email'], $mail_params);
                                break;
                }

                //支付平台日志
                if(!empty($result))
                {
                    if(is_array($result))
                    {
                        $result = serialize($result);
                    }
                    Kohana_Log::instance()->add('Payment status return', $result)->write();
                }

                $payment_method = $this->_config['name'];
                $type = Arr::get($data, 'type', '');
                if($type)
                {
                    $payment_method = $type;
                }
                $payment_log = array(
                    'order_id'       => $order['id'],
                    'customer_id'    => $order['customer_id'],
                    'payment_method' => $payment_method,
                    'trans_id'       => $data['payment_id'],
                    'amount'         => $order['amount'],
                    'currency'       => $order['currency'],
                    'comment'        => $data['payment_details'],
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
                if( ! $name)
                {
                        $name = $this->_config['name'].'_form';
                }

                if( ! $view)
                {
                        $view = 'default';
                }

                $form = View::factory('oceanpay/'.$view)
                    ->set('name', $name)
                    ->set('action_url', $config['oc_payment_url'])
                    ->set('order', $order)
                    ->set('config', $config)
                    ->render();

                return $form;
        }

}
