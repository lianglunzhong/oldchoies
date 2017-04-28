<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * External Boncyboutique
 * @category	External
 * @author     Vincent
 * @copyright  (c) 2009-2012 Cofree
 */
class External_Boncyboutique extends External
{

	public function orders()
	{
		$orders = DB::select()->from('orders_order')
				->where('site_id', '=', 4)
				->order_by('created', 'DESC')
				->execute();

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

		$customer = DB::select()->from('accounts_customers')->where('id', '=', $order['customer_id'])->execute()->current();

		$order_array['ordernum'] = $order['ordernum'];
		$order_array['email'] = $order['email'];
		$order_array['status'] = $order['payment_status'].', '.$order['shipping_status'];
		$order_array['name'] = $customer['firstname'].' '.$customer['lastname'];
		$order_array['shipping_name'] = $order['shipping_firstname'].' '.$order['shipping_lastname'];
		$order_array['billing_name'] = $order['billing_firstname'].' '.$order['billing_lastname'];
		$order_array['date'] = date('Y-m-d', $order['created']);

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

		$order = DB::select()->from('orders_order')
				->where('ordernum', '=', $ordernum)
				->execute()
				->current();

		// order detail
		$order_return['detail']['ordernum'] = $order['ordernum'];
		$order_return['detail']['amount'] = $order['amount'];
		$order_return['detail']['currency'] = $order['currency'];
		$order_return['detail']['payment_status'] = $order['payment_status'];
		$order_return['detail']['shipment_status'] = $order['shipping_status'];
		$order_return['detail']['created'] = date('Y-m-d H:i:s', $order['created']);
		$order_return['detail']['updated'] = date('Y-m-d H:i:s', $order['updated']);
		$order_return['detail']['ip'] = long2ip($order['ip']);

		// order customer
		$customer = DB::select()->from('accounts_customers')->where('id', '=', $order['customer_id'])->execute()->current();
		$order_return['customer']['email'] = $customer['email'];
		$order_return['customer']['name'] = $customer['firstname'].' '.$customer['lastname'];
		$order_return['customer']['date'] = date('Y-m-d H:i:s', $customer['created']);

		// order products
		$order_products = DB::select()->from('orders_orderitem')->where('order_id', '=', $order['id'])->execute()->as_array();
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
				$product['name'] = $order_product['name'];
				$product['sku'] = $order_product['sku'];
				$product['price'] = $order_product['price'];
				$product['quantity'] = $order_product['quantity'];
				$product['style'] = ($i % 2 == 0) ? 'odd' : 'even';
				$order_return['products'][] = $product;
				$i ++;
			}
		}

		// order shipments
		$order_shipments = DB::select()->from('orders_ordershipments')->where('order_id', '=', $order['id'])->execute()->as_array();
		if($order_shipments)
		{
			$i = 0;
			foreach( $order_shipments as $order_shipment )
			{
				$shipment = array(
					'method' => '',
					'code' => '',
					'link' => '',
					'date' => '',
					'products' => '',
					'style' => '',
				);

				$carrier = DB::select()->from('core_carriers')->where('id', '=', $order_shipment['carrier'])->execute()->current();
				$shipment['method'] = $carrier['carrier_name'];
				$shipment['code'] = $order_shipment['tracking_code'];
				$shipment['link'] = $order_shipment['tracking_link'];
				$shipment['date'] = date('Y-m-d H:i:s', $order_shipment['ship_date']);
				$shipment['style'] = ($i % 2 == 0) ? 'odd' : 'even';
				$order_return['shipments'][] = $shipment;
				$i ++;
			}
		}

		// order payments
		$order_payments = DB::select()->from('orders_orderpayments')->where('order_id', '=', $order['id'])->execute()->as_array();
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

				$payment['method'] = $order_payment['payment_method'];
				$payment['transaction_id'] = $order_payment['trans_id'];
				$payment['amount'] = $order_payment['amount'];
				$payment['currency'] = $order_payment['currency'];
				$payment['payment_status'] = $order_payment['payment_status'];
				$payment['date'] = date('Y-m-d H:i:s', $order_payment['created']);
				$payment['ip'] = long2ip($order_payment['ip']);
				$payment['style'] = ($i % 2 == 0) ? 'odd' : 'even';
				$order_return['payments'][] = $payment;
				$i ++;
			}
		}

		return $order_return;
	}

}
