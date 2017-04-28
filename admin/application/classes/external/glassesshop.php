<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * External Glassesshop
 * @category	External
 * @author     Vincent
 * @copyright  (c) 2009-2012 Cofree
 */
class External_Glassesshop extends External
{

	public $_db;

	public function __construct()
	{
		$this->_db = Database::instance(NULL, Kohana::config('external.glassesshop.database'));
	}

	public function orders()
	{
		$orders = DB::select()->from('order')
				->order_by('time', 'DESC')
				->limit(5000)
				->execute($this->_db);
		
		return $orders;
	}

	public function format($order)
	{
		$order_array = array(
			'ordernum' => '',
			'email' => '',
			'status' => '',
			'name' => '',
			'shipping_name' => '',
			'billing_name' => '',
			'date' => '',
		);

		$customer = DB::select()->from('user_info')->where('id', '=', $order['userid'])->execute($this->_db)->current();
		$billing = DB::select()->from('transaction_log')->where('strOrderNum', '=', $order['orderNum'])->where('trans_result', '=', 1)->execute($this->_db)->current();
		switch( $order['pay'] )
		{
			case '1':
				$payment_status = 'paid';
				break;
			case '2':
				$payment_status = 'pending';
				break;
			case '26':
				$payment_status = 'verify_pass';
				break;
			case '0':
				$payment_status = 'unpaid';
				break;
			default :
				$payment_status = $order['pay'];
				break;
		}
		switch( $order['sent'] )
		{
			case '1':
				$shipping_status = 'shipped';
				break;
			case '0':
				$shipping_status = 'unshipped';
				break;
			default :
				$shipping_status = $order['sent'];
				break;
		}
		$order_array['ordernum'] = $order['orderNum'];
		$order_array['email'] = $order['email'];
		$order_array['status'] = $payment_status.', '.$shipping_status;
		$order_array['name'] = $customer['firstname'].' '.$customer['lastname'];
		$order_array['shipping_name'] = $order['firstname'].' '.$order['lastname'];
		$order_array['billing_name'] = $billing['strCardHolder'];
		$order_array['date'] = date('Y-m-d', $order['time']);

		return $order_array;
	}

	public function detail($ordernum)
	{
		$order_return = array(
			'detail' => array(
				'ordernum' => '',
				'amount' => '',
				'currency' => '',
				'payment_status' => '',
				'shipment_status' => '',
				'created' => '',
				'updated' => '',
				'ip' => '',
			),
			'customer' => array(
				'email' => '',
				'name' => '',
				'date' => '',
			),
			'products' => array( ),
			'shipments' => array( ),
			'payments' => array( ),
		);

		$order = DB::select()->from('order')
				->where('orderNum', '=', $ordernum)
				->execute($this->_db)
				->current();

		switch( $order['pay'] )
		{
			case '1':
				$payment_status = 'paid';
				break;
			case '2':
				$payment_status = 'pending';
				break;
			case '26':
				$payment_status = 'verify_pass';
				break;
			case '0':
				$payment_status = 'unpaid';
				break;
			default :
				$payment_status = $order['pay'];
				break;
		}
		switch( $order['payment_type'] )
		{
			case '1':
				$payment_method = 'Credit Card';
				break;
			case '2':
				$payment_method = 'Paypal';
				break;
			case '3':
				$payment_method = 'Google Checkout';
				break;
			default :
				$payment_method = $order['payment_type'];
				break;
		}
		switch( $order['sent'] )
		{
			case '1':
				$shipping_status = 'shipped';
				break;
			case '0':
				$shipping_status = 'unshipped';
				break;
			default :
				$shipping_status = $order['sent'];
				break;
		}

		// order detail
		$order_return['detail']['ordernum'] = $order['orderNum'];
		$order_return['detail']['amount'] = $order['total'];
		$order_return['detail']['currency'] = 'USD';
		$order_return['detail']['payment_status'] = $payment_status;
		$order_return['detail']['shipment_status'] = $shipping_status;
		$order_return['detail']['created'] = date('Y-m-d', $order['time']);
		$order_return['detail']['updated'] = date('Y-m-d', $order['time']);
		$order_return['detail']['ip'] = long2ip($order['ip']);

		// order customer
		$customer = DB::select()->from('user_info')->where('id', '=', $order['userid'])->execute($this->_db)->current();
		$order_return['customer']['email'] = $customer['email'];
		$order_return['customer']['name'] = $customer['firstname'].' '.$customer['lastname'];
		$order_return['customer']['date'] = date('Y-m-d H:i:s', $customer['reg_time']);

		// order products
		$order_products = DB::select()->from('o_detail')->where('orderNum', '=', $order['orderNum'])->execute($this->_db)->as_array();
		if($order_products)
		{
			$i = 0;
			foreach( $order_products as $order_product )
			{
				$product = array(
					'name' => '',
					'sku' => '',
					'price' => '',
					'quantity' => '',
					'style' => '',
				);
				$good = DB::select()->from('good')->where('SKU', '=', $order_product['SKU'])->execute($this->_db)->current();
				$product['name'] = $good['name'];
				$product['sku'] = $order_product['SKU'];
				$product['price'] = $order_product['frame_price'];
				$product['quantity'] = $order_product['amount'];
				$product['style'] = ($i % 2 == 0) ? 'odd' : 'even';
				$order_return['products'][] = $product;
				$i ++;
			}
		}

		// order shipments
		$shipment = array(
			'method' => '',
			'code' => '',
			'link' => '',
			'date' => '',
			'products' => '',
			'style' => '',
		);

		$shipment['method'] = 'Glass Shipment';
		$shipment['code'] = $order['EMS'];
		$shipment['link'] = $order['EMSUrl'];
		$shipment['date'] = date('Y-m-d H:i:s', $order['stockouttime']);
		$shipment['style'] = 'odd';
		$order_return['shipments'][] = $shipment;

		// order payments
		$order_payments = DB::select()->from('transaction_log')->where('strOrderNum', '=', $order['orderNum'])->execute($this->_db)->as_array();
		if($order_payments)
		{
			$i = 0;
			foreach( $order_payments as $order_payment )
			{
				$payment = array(
					'method' => '',
					'transaction_id' => '',
					'amount' => '',
					'currency' => '',
					'status' => '',
					'date' => '',
					'ip' => '',
					'style' => '',
				);

				$payment['method'] = $payment_method;
				$payment['transaction_id'] = $order_payment['transcationID'];
				$payment['amount'] = $order_payment['fltAmount'];
				$payment['currency'] = $order_payment['strCurrency'];
				$payment['status'] = ($order_payment['trans_result'] == 1) ? 'success' : 'fail';
				$payment['date'] = date('Y-m-d H:i:s', $order['payTime']);
				$payment['ip'] = $order_payment['trans_ip'];
				$payment['style'] = ($i % 2 == 0) ? 'odd' : 'even';
				$order_return['payments'][] = $payment;
				$i ++;
			}
		}

		return $order_return;
	}

}
