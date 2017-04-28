<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Sendmail extends Controller_Admin_Site
{

    public function action_index()
    {
        $_SERVER['COFREE_LOG_DIR'] = APPPATH . 'logs';
        if ($_POST)
        {
            $mailtype = $_POST['mail_type'];
            switch ($mailtype)
            {
                case 'Order Confirmed':
                    $orders = Arr::get($_POST, "orders");

                    if (!empty($orders))
                    {
                        foreach ($orders as $order)
                        {
                            $result = DB::query(Database::SELECT, 'SELECT ordernum, email, shipping_firstname FROM orders WHERE ordernum = ' . $order)->execute('slave')->current();
                            $mail_params['email'] = $result['email'];
                            $mail_params['firstname'] = $result['shipping_firstname'] ? $result['shipping_firstname'] : 'customer';
                            $mail_params['order_num'] = $result['ordernum'];
                            if ($mail_params['email'] != "")
                            {
                                Mail::SendTemplateMail('Order Confirmed', $mail_params['email'], $mail_params);
                            }
                        }
                    }
                    break;
                case 'CONFIRM_MAIL':
                    $orders = Arr::get($_POST, "orders");
                    if (!empty($orders))
                    {
                        foreach ($orders as $order)
                        {
                            $result = DB::query(DATABASE::SELECT, 'SELECT `customers`.`email`,`customers`.`firstname`,`orders`.`ordernum`,`orders`.`currency`,`orders`.`amount`,`orders`.`products`,`orders`.`created`,`order_items`.`name`,`order_items`.`quantity`,`order_items`.`attributes`,`order_items`.`price`
							FROM `customers` LEFT JOIN `orders` ON `customers`.`id`=`orders`.`customer_id` LEFT JOIN `order_items` ON `orders`.`id`=`order_items`.`order_id` 
							WHERE `orders`.`ordernum`="' . $order . '" and `orders`.site_id=' . $this->site_id)
                                ->execute('slave');
                            if (!empty($result))
                            {
                                $mail_params['email'] = $result[0]['email'];
                                $mail_params['firstname'] = $result[0]['firstname'] ? $result[0]['firstname'] : 'customer';
                                $mail_params['order_num'] = $result[0]['ordernum'];
                                $mail_params['currency'] = $result[0]['currency'];
                                $mail_params['amount'] = round($result[0]['amount'],2);
                                $mail_params['created'] = date('Y-m-d H:i', $result[0]['created']);
                                $mail_params['points'] = floor($result[0]['amount']);
                                $currency = Site::instance()->currencies($result[0]['currency']);
                                $order_product = 
                                '<table border="0" width="92%" style="color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; cursor: text;">
                                    <tbody>
                                        <tr align="left">
                                            <td colspan="5"><strong>Product Details</strong></td>
                                        </tr>';
                                foreach ($result as $mailinfo)
                                {
                                    
                                    $p = '<tr align="left">
                                        <td>'.$mailinfo["name"].'</td>
                                        <td>QTY:'.$mailinfo["quantity"].'</td>
                                        <td>'.$mailinfo["attributes"].'</td>
                                        <td>'.Site::instance()->price($mailinfo['price'], 'code_view', NULL, $currency).'</td>
                                    </tr>';
                                    $order_product .= $p;
                                }
                                $order_product .= '</tbody></table>';
                                $mail_params['order_product'] = $order_product;
                            }
                            if ($mail_params['email'] != "")
                            {
                                Mail::SendTemplateMail('CONFIRM_MAIL', $mail_params['email'], $mail_params);
                            }
                        }
                    }
                    break;
                case 'UNPAID_MAIL':
                    $orders = Arr::get($_POST, "orders");
                    if (!empty($orders))
                    {
                        foreach ($orders as $order)
                        {
                            $mail_params = array();
                            $mail_params['order_num'] = $order;
                            $result = DB::query(DATABASE::SELECT, 'SELECT id,`email`,`shipping_firstname`,`ordernum`,`currency`,`amount`, `created`, `amount_shipping`,`shipping_firstname`,`shipping_lastname`,`shipping_address`,`shipping_city`,`shipping_state`,`shipping_zip`,`shipping_country`,`shipping_phone` FROM `orders_order`  
						WHERE `ordernum`="' . $order . '" AND payment_status = "new" AND is_active = 1')
                                ->execute('slave')->current();
                            if (!empty($result))
                            {
                                $mail_params['email'] = $result['email'];
                                $mail_params['firstname'] = $result['shipping_firstname'];
                                $mail_params['created'] = date('Y-m-d H:i:s', $result['created']);
                                $mail_params['ship_method'] = $result['amount_shipping'] ? 'Express Shipping ($' . Site::instance()->price($result['amount_shipping']) . ')' : 'Free Shipping ($0)';
                                $mail_params['ship_address'] = $result['shipping_firstname'] . ' ' . $result['shipping_lastname'] . ';' . $result['shipping_phone'] . ';' . $result['shipping_address'] . ' ' . $result['shipping_city'] . ', ' . $result['shipping_state'] . ' ' . $result['shipping_country'] . ' ' . $result['shipping_zip'];
                                $mail_params['amount'] = $result['currency'] . round(Site::instance()->price($result['amount']),2);
                                Mail::SendTemplateMail('UNPAID_MAIL', $mail_params['email'], $mail_params);
                            }
                        }
                    }
                    break;
                case 'NOBUY_MAIL':
                    $orders = Arr::get($_POST, "orders");
                    if (!empty($orders))
                    {
                        foreach ($orders as $order)
                        {
                            $result = DB::query(DATABASE::SELECT, 'SELECT `customers`.`email`,`customers`.`firstname` 
							FROM `customers`
							WHERE `customers`.`id`="' . $order . '"')
                                ->execute('slave');
                            if (!empty($result))
                            {
                                $mail_params['email'] = $result[0]['email'];
                                $mail_params['firstname'] = $result[0]['firstname'];
                            }
                            if ($mail_params['email'] != "")
                                $mail_params['site_domain'] = 'http://' . Site::instance()->get('domain');
                            Mail::SendTemplateMail('NOBUY_MAIL', $mail_params['email'], $mail_params);
                        }
                    }
                    break;
                case 'PICK UP':
                    $orders = Arr::get($_POST, "orders");
                    if (!empty($orders))
                    {
                        foreach ($orders as $order)
                        {
                            $orderd = Order::instance(Order::get_from_ordernum($order));
                            $shipments = $orderd->shipments();
                            if(count($shipments)>1){
                                    $email_params = array(
                                    'firstname' => $orderd->get('shipping_firstname'),
                                    'order_num' => $orderd->get('ordernum'),
                                    'tracking_num' => $shipments[0]['tracking_code'],
                                    'tracking_url' => $shipments[0]['tracking_link'],
                                    'email' => $orderd->get('email'),
                                    );
                            }else{
                                    $email_params = array(
                                    'firstname' => $orderd->get('shipping_firstname'),
                                    'order_num' => $orderd->get('ordernum'),
                                    'email' => $orderd->get('email'),
                                    );
                            }
                            
                            Mail::SendTemplateMail('PICK UP', $email_params['email'], $email_params);
                        }
                    }
                    break;
                case 'PAYSUCCESS':
                    $orders = Arr::get($_POST, "orders");
                    
                    if (!empty($orders))
                    {
                        foreach ($orders as $ordernum)
                        {
                            $order = Order::instance(Order::get_from_ordernum($ordernum))->get();
                            if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                            {
                                $result = DB::query(DATABASE::SELECT, 'SELECT `customers`.`firstname` 
                                FROM `customers`
                                WHERE `customers`.`id`="' . $order['customer_id'] . '"')
                                ->execute('slave')->get('firstname');
                                $mail_params = array();
                                $mail_params['order_view_link'] = '<a href="http://' . Site::instance()->get('domain') . '/order/view/' . $order['ordernum'] . '">View your order</a>';
                                $mail_params['order_num'] = $order['ordernum'];
                                $mail_params['email'] = $order['email'];
                                if($result){ 
                                    $result=$result;
                                }else{ 
                                    $result="Choieser";
                                }
                                $mail_params['firstname'] = $result;
                                $mail_params['order_product'] = '';
                                $order_products = Order::instance($order['id'])->products();
                                foreach ($order_products as $rs)
                                {
                                    $mail_params['order_product'] .=__('<p style="line-height:22px;">SKU: ') . Product::instance($rs['item_id'])->get('sku') . ' ' . __('</p><p style="line-height:22px;">Name: ') . '<a href="' . Product::instance($rs['item_id'])->permalink() . '">' . Product::instance($rs['item_id'])->get('name') . '</a> ' . __('</p><p style="line-height:22px;">Price: ') . Site::instance()->price($rs['price'], 'code_view') . ' ' . __('</p><p style="line-height:23px;">Quantity: ') . $rs['quantity'] . ' ' . __('</p>');
                                    $mail_params['order_product'] .= '<br />';
                                }
                                $mail_params['currency'] = $order['currency'];
                                $mail_params['amount'] = $order['amount'];
                                $mail_params['pay_num'] = $order['amount'];
                                $mail_params['pay_currency'] = $order['currency'];
                                $mail_params['shipping_firstname'] = $order['shipping_firstname'];
                                $mail_params['shipping_lastname'] = $order['shipping_lastname'];
                                $mail_params['address'] = $order['shipping_address'];
                                $mail_params['city'] = $order['shipping_city'];
                                $mail_params['state'] = $order['shipping_state'];
                                $mail_params['country'] = $order['shipping_country'];
                                $mail_params['zip'] = $order['shipping_zip'];
                                $mail_params['phone'] = $order['shipping_phone'];
                                $mail_params['shipping_fee'] = $order['amount_shipping'];
                                $mail_params['payname'] = Arr::get($result, 'api', '');
                                Kohana_Log::instance()->add('SendMail', 'PAYSUCCESS-' . $order['ordernum']);
                                Mail::SendTemplateMail('PAYSUCCESS', $mail_params['email'], $mail_params);
                            }
                        }
                    }
                    break;
                default:
                    Message::set('未配置此类邮件');
                    $this->request->redirect($_SERVER['HTTP_REFERER']);
                    break;
            }
            $mailname = DB::select('name')
                ->from('mail_types')
                ->where('site_id', '=', $this->site_id)
                ->execute('slave');
            $path = $_SERVER['COFREE_LOG_DIR'] . '/MailLog.txt';
            if ($_POST['created'] != '')
                $time = $_POST['created'];
            else
            {
                $time = 'Before ' . date("Y-n-d");
            }
            if (true == ($handle = fopen($path, 'a')))
            {
                if (is_writable($path))
                {
                    date_default_timezone_set('Asia/Shanghai');
                    date_default_timezone_get();
                    fwrite($handle, '--' . date("Y-n-d H:i:s") . '--[' . $mailtype . '] Created Time:' . $time . " 成功发送\r\n");
                }
                fclose($handle);
            }
            Message::set('发送成功');
            $this->request->redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * read file MailLog
     *
     * @param  <int> $number
     * @return  <string>
     */
    Public function readlog($type, $number = 10)
    {
        $str = '';
        $path = $_SERVER['COFREE_LOG_DIR'] . '/MailLog.txt';
        if (true == ($handle = fopen($path, 'a')))
        {
            $lines = file($path);
            fclose($handle);
        }
        if (!empty($lines))
        {
            for ($i = 1; $i <= $number && $i <= count($lines); $i++)
            {
                $str.=str_replace('[' . $type . ']', '', $lines[count($lines) - $i]) . '<br/><br/>';
            }
        }
        return $str;
    }

}

?>
