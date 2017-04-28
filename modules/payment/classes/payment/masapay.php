<?php

defined('SYSPATH') or die('No direct script access.');

class   Payment_Masapay extends Payment
{

    public function pay($order, $data = NULL)
    {
        // TODO: Implement pay() method.
        if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
        {
            return 'SUCCESS';
        }
        $order_update = array(
            'currency_payment'  => $data['currencyCode'],
            'transaction_id'    => $data['trans_id'],
            'payment_date'      => time(),
            'updated'           => time(),
        );
        //payment platform sync
        if($data['status'] == 1)
        {
            $succeed = 9;  //风控状态 capture
        }
        elseif($data['status'] == 0)
        {
            $succeed = 1;  //支付失败
        }elseif ($data['status']== 2)
        {
            $succeed = 43;  //滞留
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
                    . '&trans_id=' . $data['trans_id']
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

        switch ($data['status'])
        {
            case 1:
                $order_update['payment_count'] = $order['payment_count'] + 1;
                $order_update['payment_status'] = 'success';
                Order::instance($order['id'])->set($order_update);
                $payment_log_status = 'success';
                $result = Toolkit::curl_pay_fk('http://manage.choiesriskcontrol.com/masapay', $post_var);
//                $result = Toolkit::curl_pay_fk('http://local.manage.com/masapay', $post_var); //本地测试

                //邮件
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

                if ($celebrity_id)
                {
                    Kohana_Log::instance()->add('SendMail', 'PAYSUCCESS');
                    Mail::SendTemplateMail('BLOGGER PAYSUCCESS', $mail_params['email'], $mail_params);
                }
                else
                {
                    Kohana_Log::instance()->add('SendMail', 'PAYSUCCESS');
                    Mail::SendTemplateMail('PAYSUCCESS', $mail_params['email'], $mail_params);
                    $mail_params['email'] = 'invoices@3auntt7rwt.referralcandy.com';
                    Mail::SendTemplateMail('PAYSUCCESS', $mail_params['email'], $mail_params);
                }
                break;
            case 2:
                $order_update['payment_count'] = $order['payment_count'] + 1;
                $order_update['payment_status'] = 'pending';
                Order::instance($order['id'])->set($order_update);
                $payment_log_status = 'pending';
                $result = Toolkit::curl_pay_fk('http://manage.choiesriskcontrol.com/masapay', $post_var);
//                $result = Toolkit::curl_pay_fk('http://local.manage.com/masapay', $post_var); //本地测试
                break;
            case 0:
                $payment_log_status = 'failed';
                $order_update['payment_count'] = $order['payment_count'] + 1;
                $order_update['payment_status'] = 'failed';
                Order::instance($order['id'])->set($order_update);
                $result = Toolkit::curl_pay_fk('http://manage.choiesriskcontrol.com/masapay', $post_var);
//                $result = Toolkit::curl_pay_fk('http://local.manage.com/masapay', $post_var); //本地测试

                //邮件
                $mail_params['order_view_link'] = '<a href="' . BASEURL . '/order/view/' . $order['ordernum'] . '">View your order</a>';
                $mail_params['created'] = date('Y-m-d H:i', $order['created']);
                $mail_params['currency'] = $order['currency'];
                $mail_params['amount'] = round($order['amount'],2);

                Kohana_Log::instance()->add('FAILED_MAIL', 'PAYSUCCESS');
                Mail::SendTemplateMail('FAILED_MAIL', $mail_params['email'], $mail_params);
                break;
        }

        $payment_log = array(
            'order_id'          => $order['id'],
            'customer_id'       => $order['customer_id'],
            'payment_method'    => 'MASAPAY',
            'trans_id'          => $data['trans_id'],
            'amount'            => $data['amount'],
            'currency'          => $data['currencyCode'],
            'comment'           => '',
            'payment_status'    => $payment_log_status,
            'ip'                => ip2long(Request::$client_ip),
            'created'           => time(),
            'first_name'        => $order['shipping_firstname'],
            'last_name'         => $order['shipping_lastname'],
            'email'             => $order['email'],
            'address'           => $order['shipping_address'],
            'zip'               => $order['shipping_zip'],
            'city'              => $order['shipping_city'],
            'state'             => $order['shipping_state'],
            'country'           => $order['shipping_country'],
            'phone'             => '',
        );
        $this->log($payment_log);
    }

    public function form($config = NULL,$url = NULL)
    {

        $form = View::factory('masapay/masapay')
            ->set('action_url', $url)
            ->set('config', $config)
            ->render();

        return $form;
    }
}