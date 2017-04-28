<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Payment PPjump
 * @category	Carrier
 * @author     Vincent
 * @copyright  (c) 2009-2012 Cofree
 */
class Payment_Ppmobile extends Payment
{

	/**
	 * Paypal payment
	 * @param array $order	Order detail
	 * @param array $data		Paypal return
	 * @return stirng		SUCCESS
	 */
	public function pay($order, $data = NULL)
	{
		$order_update = array(
			'amount_payment' => $order['amount'],
			'currency_payment' => $order['currency'],
			'transaction_id' => $data['txn_id'],
			'payment_date' => time(),
			'updated' => time(),			
			'billing_firstname' => $data['fname'],
			'billing_lastname' => $data['lname'],
			'billing_address' => $data['street'],
			'billing_zip' => $data['postalCode'],
			'billing_city' => $data['city'],
			'billing_state' => $data['state'],
			'billing_country' => $data['country'],		
		);
		switch( $data['status'] )
		{
			case 'Completed':
				//payment platform sync
				$post_var = "order_num=".$order['ordernum']
					."&order_amount=".$order['amount']
					."&order_currency=".$order['currency']
					."&card_num=".$order['cc_num']
					."&card_type=".$order['cc_type']
					."&card_cvv=".$order['cc_cvv']
					."&card_exp_month=".$order['cc_exp_month']
					."&card_exp_year=".$order['cc_exp_year']
					."&card_inssue=".$order['cc_issue']
					."&card_valid_month=".$order['cc_valid_month']
					."&card_valid_year=".$order['cc_valid_year']
					."&billing_firstname=".$data['fname']
					."&billing_lastname=".$data['lname']
					."&billing_address=".$data['street']
					."&billing_zip=".$data['postalCode']
					."&billing_city=".$data['city']
					."&billing_state=".$data['state']
					."&billing_country=".$data['country']
					."&billing_telephone=".''
					."&billing_ip_address=".$data['ip']
					."&billing_email=".$order['email']
					."&shipping_firstname=".$order['shipping_firstname']
					."&shipping_lastname=".$order['shipping_lastname']
					."&shipping_address=".$order['shipping_address']
					."&shipping_zip=".$order['shipping_zip']
					."&shipping_city=".$order['shipping_city']
					."&shipping_state=".$order['shipping_state']
					."&shipping_country=".$order['shipping_country']
					."&shipping_telephone=".$order['shipping_phone']
					.'&trans_id='.$data['txn_id']
					.'&payer_email='.$data['payer_email']
					.'&receiver_email='.$data['receiver_email']
					."&site_id=".Site::instance()->get('cc_payment_id')
					."&secure_code=".Site::instance()->get('cc_secure_code');
//				print_r(Site::instance()->get('pp_sync_url'));exit;
//				print_r($post_var);exit;
				$result = unserialize(stripcslashes(Toolkit::curl_pay(Site::instance()->get('pp_sync_url'), $post_var)));

				if(is_array($result))
				{
					$result['status_id'] = isset($result['status_id']) ? $result['status_id'] : '';
					$result['status'] = isset($result['status']) ? $result['status'] : '';
					$result['trans_id'] = isset($result['trans_id']) ? $result['trans_id'] : '';
					$result['message'] = isset($result['message']) ? $result['message'] : '';
					$result['api'] = isset($result['api']) ? $result['api'] : '';
					$result['avs'] = isset($result['avs']) ? $result['avs'] : '';
				}

				$order_update['payment_count'] = $order['payment_count'] + 1;
				$order_update['payment_status'] = 'success';
				break;
			case 'Pending':
				$order_update['payment_count'] = $order['payment_count'] + 1;
				$order_update['payment_status'] = 'pending';
				break;
			case 'Refunded':
				break;
			case 'Failed':
				$order_update['payment_status'] = 'failed';
				break;
		}

		Order::instance($order['id'])->set($order_update);

		$payment_log = array(
			'site_id' => Site::instance()->get('id'),
			'order_id' => $order['id'],
			'customer_id' => $order['customer_id'],
			'payment_method' => $this->_config['name'],
			'trans_id' => $data['txn_id'],
			'amount' => $data['amount'],
			'currency' => $data['currency'],
			'comment' => $data['status'],
			'cache' => serialize($data),
			'payment_status' => $data['status'],
			'ip' => ip2long($data['ip']),
			'created' => time(),
			'first_name' => $data['fname'],
			'last_name' => $data['lname'],
			'email' => $data['payer_email'],
			'address' => $data['street'],
			'zip' => $data['postalCode'],
			'city' => $data['city'],
			'state' => $data['state'],
			'country' => $data['country'],
			'phone' => '',
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
		if( ! $name)
		{
			$name = $this->_config['name'].'_form';
		}

		if( ! $view)
		{
			$view = 'default';
		}

		$config = array(
			'merchant_id' => isset($config['merchant_id']) ? $config['merchant_id'] : Site::instance()->get('pp_payment_id'),
			'notify_url' => isset($config['notify_url']) ? $config['notify_url'] : Site::instance()->get('pp_notify_url'),
			'return_url' => isset($config['return_url']) ? $config['return_url'] : Site::instance()->get('pp_return_url'),
			'cancel_return_url' => isset($config['cancel_return_url']) ? $config['cancel_return_url'] : Site::instance()->get('pp_cancel_return_url'),
		);

		$form = View::factory('ppjump/'.$view)
				->set('name', $name)
				->set('action_url', Site::instance()->get('pp_payment_url'))
				->set('order', $order)
				->set('config', $config)
				->render();

		return $form;
	}

}
