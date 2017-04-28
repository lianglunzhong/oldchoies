<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Payment PPjump
 * @category	Carrier
 * @author     Vincent
 * @copyright  (c) 2009-2012 Cofree
 */
class Payment_Ppjump extends Payment
{

        /**
         * Paypal payment
         * @param array $order	Order detail
         * @param array $data		Paypal return
         * @return stirng		SUCCESS
         */
        public function pay($order, $data = NULL)
        {
                $payment_log_status = "";

                $order_update = array(
                    'currency_payment'  => $data['mc_currency'],
                    'transaction_id'    => $data['txn_id'],
                    'payment_date'      => time(),
                    'updated'           => time(),
                    'billing_firstname' => $data['first_name'],
                    'billing_lastname'  => $data['last_name'],
                    'billing_address'   => $data['address_street'],
                    'billing_zip'       => $data['address_zip'],
                    'billing_city'      => $data['address_city'],
                    'billing_state'     => $data['address_state'],
                    'billing_country'   => $data['address_country_code'],
                    'billing_phone'     => $data['contact_phone'],
                );
                switch ($data['payment_status'])
                {
                        case 'Completed':
                                if (($order['amount_payment'] + $data['mc_gross']) >= $order['amount_order'] - 0.02)
                                {
                                        //payment platform sync
                                        $post_var = "order_num=" . $order['ordernum']
                                                . "&order_amount=" . $data['mc_gross']
                                                . "&order_currency=" . $data['mc_currency']
                                                . "&card_num=" . $order['cc_num']
                                                . "&card_type=" . $order['cc_type']
                                                . "&card_cvv=" . $order['cc_cvv']
                                                . "&card_exp_month=" . $order['cc_exp_month']
                                                . "&card_exp_year=" . $order['cc_exp_year']
                                                . "&card_inssue=" . $order['cc_issue']
                                                . "&card_valid_month=" . $order['cc_valid_month']
                                                . "&card_valid_year=" . $order['cc_valid_year']
                                                . "&billing_firstname=" . $data['first_name']
                                                . "&billing_lastname=" . $data['last_name']
                                                . "&billing_address=" . $data['address_street']
                                                . "&billing_zip=" . $data['address_zip']
                                                . "&billing_city=" . $data['address_city']
                                                . "&billing_state=" . $data['address_state']
                                                . "&billing_country=" . $data['address_country']
                                                . "&billing_telephone=" . ''
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
                                                . '&trans_id=' . $data['txn_id']
                                                . '&payer_email=' . $data['payer_email']
                                                . '&receiver_email=' . $data['receiver_email']
                                                . "&is_extra_pp=" . ($order['amount'] <= 10 ? '1' : '0')
                                                . "&site_id=" . Site::instance()->get('cc_payment_id')
                                                . "&secure_code=" . Site::instance()->get('cc_secure_code');

                                        
                                        $order_update['amount_payment'] = $order['amount_payment'] + $data['mc_gross'];
                                        $order_update['payment_count'] = $order['payment_count'] + 1;
                                        $order_update['payment_status'] = 'success';
                                        $products = $order['products'] ? unserialize($order['products']) : array();
                                        foreach ($products as $p)
                                        {
                                                $product = Product::instance($p['id']);
                                                $hits = $product->get('hits');
                                                $product->set(array('hits' => $hits + $p['quantity']));
                                        }
                                }
                                else
                                {
                                        $order_update['amount_payment'] = $order['amount_payment'] + $data['mc_gross'];
                                        $order_update['payment_count'] = $order['payment_count'] + 1;
                                        $order_update['payment_status'] = 'partial_paid';
                                }
                                Order::instance($order['id'])->set($order_update);
                                $result = Toolkit::curl_pay(Site::instance()->get('pp_sync_url'), $post_var);
                                Kohana_Log::instance()->add('Payment status return', $result)->write();
                                $payment_log_status = 'success';
                                $mail_params['order_view_link'] = '<a href="' . BASEURL . '/order/view/' . $order['ordernum'] . '">View your order</a>';
                                $mail_params['order_num'] = $order['ordernum'];
                                $mail_params['email'] = $order['email'];
                                $mail_params['emailaddress'] = $order['email'];
                                $mail_params['firstname'] = $data['first_name'];
                                
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
                                if($celebrity_id)
                                {
                                        Kohana_Log::instance()->add('SendMail', 'PAYSUCCESS');
                                        Mail::SendTemplateMail('BLOGGER PAYSUCCESS', $mail_params['email'], $mail_params);
                                }
                                else
                                {
                                        // $quantity = DB::select('id')->from('orders_order')
                                        //                 ->where('customer_id', '=', $customer_id)
                                        //                 ->and_where('id', '<', $order['id'])
                                        //                 ->and_where('payment_status', 'IN', array('success', 'verify_pass'))
                                        //                 ->execute()->get('id');
                                        // if($quantity)
                                        // {
                                        //         $vip_level = Customer::instance($customer_id)->get('vip_level');
                                        //         $vip_return = DB::select('return')->from('vip_types')->where('level', '=', $vip_level)->execute()->get('return');
                                        //         $rate = $order['rate'] ? $order['rate'] : 1;
                                        //         $points = ($order['amount'] / $rate) * $vip_return;
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
                        case 'Pending':
                                $order_update['payment_count'] = $order['payment_count'] + 1;
                                $order_update['payment_status'] = 'pending';
                                $payment_log_status = 'pending';
                                Order::instance($order['id'])->set($order_update);
                                break;
                        case 'Refunded':
                                $order_update['refund_status'] = 'refund';
                                $payment_log_status = 'refund';
                                $mail_params['order_num'] = $order['ordernum'];
                                $mail_params['currency'] = $order['currency'];
                                $mail_params['amount'] = $order['amount'];
                                $mail_params['email'] = $data['email'];
                                $mail_params['firstname'] = $data['first_name'];
                                $mail_params['billingname'] = $data['first_name'] . ' ' . $data['last_name'];
                                Order::instance($order['id'])->set($order_update);
                                Kohana_Log::instance()->add('REFUND', 'PAYSUCCESS');
                                Mail::SendTemplateMail('REFUND', $mail_params['email'], $mail_params);
                                break;
                        case 'Failed':
                                $order_update['payment_status'] = 'failed';
                                $payment_log_status = 'failed';
                                $mail_params['order_view_link'] = '<a href="' . BASEURL . '/order/view/' . $order['ordernum'] . '">View your order</a>';
                                $mail_params['order_num'] = $order['ordernum'];
                                $mail_params['email'] = $data['email'];
                                $mail_params['firstname'] = $data['first_name'];
                                Order::instance($order['id'])->set($order_update);
                                Kohana_Log::instance()->add('UNPAID_MAIL', 'PAYSUCCESS');
                                Mail::SendTemplateMail('UNPAID_MAIL', $mail_params['email'], $mail_params);
                                break;
                }

                $payment_log = array(
                    'site_id'        => Site::instance()->get('id'),
                    'order_id'       => $order['id'],
                    'customer_id'    => $order['customer_id'],
                    'payment_method' => $this->_config['name'],
                    'trans_id'       => $data['txn_id'],
                    'amount'         => $data['mc_gross'],
                    'currency'       => $data['mc_currency'],
                    'comment'        => $data['payment_status'],
                    'cache'          => serialize($data),
                    'payment_status' => $payment_log_status,
                    'ip'             => ip2long(Request::$client_ip),
                    'created'        => time(),
                    'first_name'     => $data['first_name'],
                    'last_name'      => $data['last_name'],
                    'email'          => $data['payer_email'],
                    'address'        => $data['address_street'],
                    'zip'            => $data['address_zip'],
                    'city'           => $data['address_city'],
                    'state'          => $data['address_state'],
                    'country'        => $data['address_country'],
                    'phone'          => '',
                );
                $this->log($payment_log);

                return 'SUCCESS';
        }

        /**
         * Paypal payment form
         * @param string $name
         * @param string $view
         * @param <type> $order
         * @param array $config
         * @return string form
         */
        public function form($name = NULL, $view = NULL, $order = NULL, $config = NULL)
        {
                if (!$name)
                {
                        $name = $this->_config['name'] . '_form';
                }

                if (!$view)
                {
                        $view = 'default';
                }

                $config = array(
                    'merchant_id'       => isset($config['merchant_id']) ? $config['merchant_id'] : Site::instance()->get('pp_payment_id'),
                    'notify_url'        => isset($config['notify_url']) ? $config['notify_url'] : Site::instance()->get('pp_notify_url'),
                    'return_url'        => isset($config['return_url']) ? $config['return_url'] : Site::instance()->get('pp_return_url'),
                    'cancel_return_url' => isset($config['cancel_return_url']) ? $config['cancel_return_url'] : Site::instance()->get('pp_cancel_return_url'),
                    'pp_logo_url'       => isset($config['pp_logo_url']) ? $config['pp_logo_url'] : Site::instance()->get('pp_logo_url'),
                );

                $form = View::factory('ppjump/' . $view)
                        ->set('name', $name)
                        ->set('action_url', Site::instance()->get('pp_payment_url'))
                        ->set('order', $order)
                        ->set('config', $config)
                        ->render();

                return $form;
        }

}
