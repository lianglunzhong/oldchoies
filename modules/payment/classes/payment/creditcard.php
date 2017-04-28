<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Payment Credit Card
 * @category	Carrier
 * @author     Vincent
 * @copyright  (c) 2009-2012 Cofree
 */
class Payment_Creditcard extends Payment
{

	/**
	 * Creditcard payment
	 * @param array $order	Order detail
	 * @param array $data		Billing & Billing_address
	 * @return array $return	 Order id & Payment_status & Message
	 */
	public function pay($order, $data = NULL)
	{
		switch( $order['payment_status'] )
		{
// partly payment
			case 'partial_paid' :
				$ordernum_tail = $order['payment_count'];
				$ordernum = $order['ordernum'].$ordernum_tail;
				$amount = $order['amount'] - $order['amount_payment'];
				break;
			default :
				$ordernum = $order['ordernum'];
				$amount = $order['amount'];
				break;
		}

		$post_var = "order_num=".$ordernum
			."&order_amount=".$amount
			."&order_currency=".$order['currency']
			."&card_num=".$order['cc_num']
			."&card_type=".$order['cc_type']
			."&card_cvv=".$order['cc_cvv']
			."&card_exp_month=".$order['cc_exp_month']
			."&card_exp_year=".$order['cc_exp_year']
			."&card_inssue=".$order['cc_issue']
			."&card_valid_month=".$order['cc_valid_month']
			."&card_valid_year=".$order['cc_valid_year']
			."&billing_firstname=".$order['billing_firstname']
			."&billing_lastname=".$order['billing_lastname']
			."&billing_address=".$order['billing_address']
			."&billing_zip=".$order['billing_zip']
			."&billing_city=".$order['billing_city']
			."&billing_state=".$order['billing_state']
			."&billing_country=".$order['billing_country']
			."&billing_telephone=".$order['billing_phone']
			."&billing_ip_address=".long2ip($order['ip'])
			."&billing_email=".$order['email']
			."&shipping_firstname=".$order['shipping_firstname']
			."&shipping_lastname=".$order['shipping_lastname']
			."&shipping_address=".$order['shipping_address']
			."&shipping_zip=".$order['shipping_zip']
			."&shipping_city=".$order['shipping_city']
			."&shipping_state=".$order['shipping_state']
			."&shipping_country=".$order['shipping_country']
			."&shipping_telephone=".$order['shipping_phone']
			."&site_id=".Site::instance()->get('cc_payment_id')
			."&secure_code=".Site::instance()->get('cc_secure_code');

		if(in_array(Site::instance()->get('id'), array( '1' )) && $amount <= 10)
		{
			// GT order which amount under $10 is not need to verified.
			$result = unserialize(stripcslashes(Toolkit::curl_pay('https://www.shuiail.com/need_not_verify', $post_var)));
		}
		else
		{
			$result = unserialize(stripcslashes(Toolkit::curl_pay(Site::instance()->get('cc_payment_url'), $post_var)));
		}

		if(is_array($result))
		{
			$result['status_id'] = isset($result['status_id']) ? $result['status_id'] : '';
			$result['status'] = isset($result['status']) ? $result['status'] : '';
			$result['trans_id'] = isset($result['trans_id']) ? $result['trans_id'] : '';
			$result['message'] = isset($result['message']) ? $result['message'] : '';
			$result['api'] = isset($result['api']) ? $result['api'] : '';
			$result['avs'] = isset($result['avs']) ? $result['avs'] : '';

			$order_update = array(
				'currency_payment' => $order['currency'],
				'rate_payment' => $order['rate'],
				'transaction_id' => $result['trans_id'],
				'payment_date' => time(),
				'updated' => time(),
				'cc_num' => '',
				'cc_type' => '',
				'cc_cvv' => '',
				'cc_exp_month' => '',
				'cc_exp_year' => '',
				'cc_issue' => '',
				'cc_valid_month' => '',
				'cc_valid_year' => '',
			);
		}

		switch( $result['status_id'] )
		{
			case 1 : //Payment Fail
				if($order['payment_status'] != 'partial_paid')
				{
					$order_update['payment_status'] = 'failed';
				}
				$status = 'FAIL';
				break;
			case 8 : //Payment Success
				$order_update['payment_status'] = 'success';
				$order_update['payment_count'] = $order['payment_count'] + 1;
				$order_update['amount_payment'] = $amount + $order['amount_payment'];
				$order_update['verify_date'] = time();
				$status = 'SUCCESS';
				break;
			case 26 : //Payment Success
				$order_update['payment_status'] = 'verify_pass';
				$order_update['payment_count'] = $order['payment_count'] + 1;
				$order_update['amount_payment'] = $amount + $order['amount_payment'];
				$order_update['verify_date'] = time();
				$status = 'SUCCESS';
				break;
			default : //Pending
				$order_update['payment_status'] = 'pending';
				$order_update['payment_count'] = $order['payment_count'] + 1;
				$status = 'PENDING';
				break;
		}

		Order::instance($order['id'])->set($order_update);

		$payment_log = array(
			'site_id' => Site::instance()->get('id'),
			'order_id' => $order['id'],
			'customer_id' => $order['customer_id'],
			'payment_method' => $this->_config['name'],
			'trans_id' => $result['trans_id'],
			'amount' => $amount,
			'currency' => $order['currency'],
			'comment' => $order['payment_status'] == 'partial_paid' ? 'Balance #'.$ordernum.': '.$result['message'] : $result['message'],
			'cache' => serialize($result),
			'payment_status' => $order_update['payment_status'],
			'ip' => ip2long(Request::$client_ip),
			'created' => time(),
			'first_name' => $order['billing_firstname'],
			'last_name' => $order['billing_lastname'],
			'email' => $order['email'],
			'address' => $order['billing_address'],
			'zip' => $order['billing_zip'],
			'city' => $order['billing_city'],
			'state' => $order['billing_state'],
			'country' => $order['billing_country'],
			'phone' => $order['billing_phone'],
		);
		$this->log($payment_log);

		$mail_params['order_view_link'] = '<a href="'.BASEURL.'/order/view/'.$ordernum.'">View your order</a>';
		$mail_params['order_num'] = $ordernum;
		$mail_params['email'] = Customer::instance($order['customer_id'])->get('email');
		$mail_params['firstname'] = Customer::instance($order['customer_id'])->get('firstname');
		switch( $result['status_id'] )
		{
			case 1 : //Payment Fail
				Mail::SendTemplateMail('NOTPAY', $mail_params['email'], $mail_params);
				break;
			case 8 : //Payment Success
				$mail_params['order_product'] = '';
				$order_products = Order::instance($order['id'])->products();
				foreach( $order_products as $rs )
				{
					$mail_params['order_product'] .=__('SKU:').Product::instance($rs['item_id'])->get('sku').' '.__('Name:').Product::instance($rs['item_id'])->get('name').' '.__('Price:').Site::instance()->price($rs['price'], 'code_view').' '.__('Quality:').$rs['quantity'];
					/*
					  if($rs['type'] == 1)
					  {
					  $mail_params['order_product'] .= __('mail_attribute').implode(',', Product::instance($rs['product_id'])->configured_attributes($rs['item_id']));
					  }
					 */
					$mail_params['order_product'] .= '<br />';
				}

				$mail_params['currency'] = $order['currency'];
				$mail_params['amount'] = $order['amount'];
				$mail_params['pay_num'] = $amount;
				$mail_params['pay_currency'] = $order['currency'];
				$mail_params['shipping_firstname'] = $order['shipping_firstname'];
				$mail_params['shipping_lastname'] = $order['shipping_lastname'];
				$mail_params['address'] = $order['shipping_address'];
				$mail_params['city'] = $order['shipping_city'];
				$mail_params['state'] = $order['shipping_state'];
				$mail_params['country'] = $order['shipping_country'];
				$mail_params['zip'] = $order['shipping_zip'];
				$mail_params['phone'] = $order['shipping_phone'];
				$mail_params['payname'] = Arr::get($result, 'api', '');

				Mail::SendTemplateMail('PAYSUCCESS', $mail_params['email'], $mail_params);
				break;
		}

		$return = array(
			'status' => $status,
			'amount' => $amount,
			'message' => $result['message']
		);
		return $return;
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

		$config = array(
			'action_url' => isset($config['action_url']) ? $config['action_url'] : $this->_config['form_action_url']
		);

		$form = View::factory('creditcard/'.$view)
			->render();

		return $form;
	}
        
        public function pay1($order, $data = NULL)
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
                //新接口
                if ($data['merno'] == 10470)
                {
                        switch ($data['succeed'])
                        {
                                case '1':
                                        $order_update['amount_payment'] = round($order['amount'],2);
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
                                        $mail_params['order_product'] = '';
                                        $customer_id = $order['customer_id'];
                                        $celebrity_id = Customer::instance($customer_id)->is_celebrity();
                                        $order_products = Order::instance($order['id'])->products();
                                        if ($celebrity_id)
                                        {
                                                foreach ($order_products as $rs)
                                                {
                                                        $sku = Product::instance($rs['item_id'])->get('sku');
                                                        $mail_params['order_product'] .=__('<p style="line-height:22px;">SKU: ') . $sku . ' ' . __('</p><p style="line-height:22px;">Name: ') . '<a href="' . Product::instance($rs['item_id'])->permalink() . '">' . Product::instance($rs['item_id'])->get('name') . '</a> ' . __('</p><p style="line-height:22px;">Price: ') . Site::instance()->price($rs['price'], 'code_view') . ' ' . __(',Quantity: ') . $rs['quantity'] . ' ' . __('</p>');
                                                        $mail_params['order_product'] .= 'Product Link: <span style="color:#003399;">' . Product::instance($rs['item_id'])->permalink() . '?cid=' . $celebrity_id.'</span>';
                                                        $mail_params['order_product'] .= '<br />';
                                                }
                                        }
                                        else
                                        {
                                                foreach ($order_products as $rs)
                                                {
                                                        $sku = Product::instance($rs['item_id'])->get('sku');
                                                        $mail_params['order_product'] .=__('<p style="line-height:22px;">SKU: ') . $sku . ' ' . __('</p><p style="line-height:22px;">Name: ') . '<a href="' . Product::instance($rs['item_id'])->permalink() . '">' . Product::instance($rs['item_id'])->get('name') . '</a> ' . __('</p><p style="line-height:22px;">Price: ') . Site::instance()->price($rs['price'], 'code_view') . ' ' . __(',Quantity: ') . $rs['quantity'] . ' ' . __('</p>');
                                                        $mail_params['order_product'] .= '<br />';
                                                }
                                        }

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
                                        if ($celebrity_id)
                                        {
                                                Kohana_Log::instance()->add('SendMail', 'PAYSUCCESS');
                                                Mail::SendTemplateMail('BLOGGER PAYSUCCESS', $mail_params['email'], $mail_params);
                                        }
                                        else
                                        {
                                                $vip_level = Customer::instance($customer_id)->get('vip_level');
                                                $vip_return = DB::select('return')->from('vip_types')->where('level', '=', $vip_level)->execute()->get('return');

                                                $points = ($order['amount'] / $order['rate']) * $vip_return;
                                                $mail_params['order_points'] = $points;
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

}
