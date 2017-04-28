<?php

defined('SYSPATH') or die('No direct script access.');

class   Payment_Ipay extends Payment
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
            'transaction_id'    => $data['dealId'],
            'payment_date'      => time(),
            'updated'           => time(),
        );
        //payment platform sync
        if($data['status'] == 1)
        {
            $succeed = 1;
        }
        elseif($data['status'] == 0)
        {
            $succeed = 0;
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
                    . '&trans_id=' . $data['dealId']
                    . "&site_id=" . Site::instance()->get('cc_payment_id')
                    . "&secure_code=" . Site::instance()->get('cc_secure_code')
                    . "&status=" . $succeed;

        switch ($data['status'])
        {
            case 1:
                $order_update['payment_count'] = $order['payment_count'] + 1;
                $order_update['payment_status'] = 'success';
                Order::instance($order['id'])->set($order_update);
                $payment_log_status = 'success';
                $result = Toolkit::curl_pay_fk('http://manage.choiesriskcontrol.com/ipay', $post_var);
//                $result = Toolkit::curl_pay_fk('http://local.manage.com/ipay', $post_var); //本地测试
                break;
            case 0:
                $payment_log_status = 'failed';
                $order_update['payment_count'] = $order['payment_count'] + 1;
                $order_update['payment_status'] = 'failed';
                Order::instance($order['id'])->set($order_update);
                break;
        }

        $payment_log = array(
            'order_id'          => $order['id'],
            'customer_id'       => $order['customer_id'],
            'payment_method'    => 'IPAY',
            'trans_id'          => $data['dealId'],
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
}