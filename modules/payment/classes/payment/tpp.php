<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Payment Third party pay
 * @category	Payment
 * @author     Timorning
 * @copyright  (c) 2009-2012 Cofree
 */
class Payment_tpp extends Payment
{
	public function pay($ordernum, $data = NULL)
	{
		$order=ORM::factory('order')
			->where('ordernum','=',$ordernum)
			->find();
		if(!$order->loaded()){
			Message::set("Create Order Fail","error");
			$this->request->redirect('/cart/shipping_billing');
		}
		$cc_payment_id=Site::instance()->get('cc_payment_id');
		$cc_payment_url=Site::instance()->get('cc_payment_url');
		$cc_secure_code=Site::instance()->get('cc_secure_code');
		$currency=$order->currency;
		$order_num=$order->ordernum;
		$order_amount=$order->amount_order;
		$mac      =md5($cc_secure_code.$order_num.$order_amount.$currency.$cc_payment_id);
		print <<<EOT
		<div style="display:hidden">

		<form name="form2" action="$cc_payment_url" method="post">

		<input name="orderid" type="hidden" value="$order_num" />
		<input name="fltAmount" type="hidden" value="$order_amount" />
		<input name="flag" type="hidden" value="store" />
		<input name="site_id" type="hidden" value="$cc_payment_id" />
		<input name="currency" type="hidden" value="$currency" />
		<input name="mac" type="hidden" value="$mac" />

        <input name="firstName" type="hidden" value="$order->shipping_firstname" />
		<input name="lastName" type="hidden" value="$order->shipping_lastname" />
		<input name="address" type="hidden" value="$order->shipping_address" />
		<input name="strEmail" type="hidden" value="$order->email" />
		<input name="zip" type="hidden" value="$order->shipping_zip" />
		<input name="state" type="hidden" value="$order->shipping_state" />
		<input name="city" type="hidden" value="$order->shipping_city" />
		<input name="strCountry" type="hidden" value="$order->shipping_country" />
		<input name="strTel" type="hidden" value="$order->shipping_phone" />
		</form></div>
		<script language=javascript>
		onload=function (){
			document.form2.submit();
		}
		</script>
        <div>It's turning to secure payment page...<br/>
			<a href='javascript:void(0);' onclick='document.form2.submit();'>Click here if your browser does not automatically redirect you.</a>.
		</div>
EOT;
	exit;
	} 
	
	public function verify_return($str)
	{
		$str=$this->query_decode($str);
		if(!$str){
			exit;
		}else{
			$a_tem = explode('&', $str);
			foreach($a_tem as $val){
			    $tem = explode('=', $val);
			    $$tem[0] = Security::xss_clean($tem[1]);
			}
		}
		if($fltAmount==-1){
			exit;
		}
		if($orderId==-1){
			exit;
		}
		if($verifyCode==-1){
			exit;
		}
		$order=ORM::factory("order")
				->where("ordernum",'=',$orderId)
				->find();
		if(!$order->loaded()||$fltAmount!=$order->amount_order)
		{
			echo "FAILURE";
			exit;
		}
		if (md5($order->ordernum.Site::instance()->get('cc_secure_code')) == $verifyCode) 
		{
			$order_update = array(
				'amount_payment' => $fltAmount,
				//'currency_payment' => $currencyCode,
				'transaction_id' => $trans_id,
				'payment_date' => time(),
				'updated' => time(),
				'cc_num' => $creditCardNumber,
				'cc_type' => $creditCardType,
				'cc_cvv' => $cvv2Number,
				//$cc_expires
				'cc_exp_month' => $expDateMonth,
				'cc_exp_year' => $expDateYear,
				'cc_issue' => $issueNumber,
				'cc_valid_month' => $valDateMonth,
				'cc_valid_year' => $valDateYear,
				'billing_firstname'=>$billing_firstname,
				'billing_lastname'=>$billing_lastname,
				'billing_country'=>$billing_zip,
				'billing_state'=>$billing_state,
				'billing_city'=>$billing_city,
				'billing_address'=>$billing_address,
				'billing_zip'=>$billing_zip,
				'billing_phone'=>$billing_telephone,
			);
			if($state==1)
			{
				$order_update['payment_status'] = 'success';
				$order_update['payment_count'] = $order->payment_count + 1;
				echo "SUCCESS";
			}
			elseif($state==3)
			{
				$order_update['payment_status'] = 'pending';
				$order_update['payment_count'] = $order->payment_count + 1;
				echo "SUCCESS";
			}
			else 
			{
				$order_update['payment_status'] = 'failed';
				$order_update['payment_count'] = $order->payment_count + 1;
				echo "FAILURE";
			}
			Order::instance($order->id)->set($order_update);
			
		}
		else 
		{
			echo "FAILURE";
		}
		try {
			$payment_log = array(
				'site_id' => Site::instance()->get('id'),
				'order_id' => $order->id,
				'customer_id' => $order->customer_id,
				'payment_method' => $this->_config['name'],
				'trans_id' => $trans_id,
				'amount' => $fltAmount,
				'currency' => '',
				'comment' => $message,
				'cache' => $str,
				'payment_status' => $order_update['payment_status'],
				'ip' => ip2long($billing_ip_address),
				'created' => time(),
				'first_name' => $billing_firstname,
				'last_name' => $billing_lastname,
				'email' => $billing_email,
				'address' => $billing_address,
				'zip' => $billing_zip,
				'city' => $billing_city,
				'state' => $billing_state,
				'country' => $billing_country,
				'phone' => $billing_telephone,
				);
			$this->log($payment_log);
			
		} catch (Exception $e) {
		}
		
		$this->paid_mail($orderId);
		exit;
	}
	
	public function paid_mail($ordernum)
	{
		$order=ORM::factory("order")
			->where("ordernum",'=',$ordernum)
			->find();
		if($order->loaded())
		{
			$order=$order->as_array();
			$mail_params['order_view_link'] = '<a href="'.BASEURL.'/order/view/'.$ordernum.'">View your order</a>';
			$mail_params['order_num'] = $ordernum;
			$mail_params['email'] = Customer::instance($order['customer_id'])->get('email');
			$mail_params['firstname'] = Customer::instance($order['customer_id'])->get('firstname');
			switch( $order['payment_status'] )
			{
				case 'failed' : //Payment Fail
					Mail::SendTemplateMail('NOTPAY', $mail_params['email'], $mail_params);
					break;
				case 'success' : //Payment Success
					$mail_params['order_product'] = '';
					$order_products = Order::instance($order['id'])->products();
					foreach( $order_products as $rs )
					{
						$mail_params['order_product'] .=__('SKU:').Product::instance($rs['item_id'])->get('sku').__('<br/>Name:').Product::instance($rs['item_id'])->get('name').__('<br/>Price:').Site::instance()->price($rs['price'], 'code_view').__('<br/>Quantity:').$rs['quantity'];
						if($rs['type'] == 1)
						{
							$mail_params['order_product'] .= __('<br/>Attribute').implode(',', Product::instance($rs['product_id'])->configured_attributes($rs['item_id']));
						}
						$mail_params['order_product'] .= '<br />';
					}
	
					$mail_params['currency'] = $order['currency'];
					$mail_params['amount'] = $order['amount'];
					$mail_params['pay_num'] = $order['amount_payment'];
					$mail_params['pay_currency'] = $order['currency'];
					$mail_params['shipping_firstname'] = $order['shipping_firstname'];
					$mail_params['shipping_lastname'] = $order['shipping_lastname'];
					$mail_params['address'] = $order['shipping_address'];
					$mail_params['city'] = $order['shipping_city'];
					$mail_params['state'] = $order['shipping_state'];
					$mail_params['country'] = $order['shipping_country'];
					$mail_params['zip'] = $order['shipping_zip'];
					$mail_params['phone'] = $order['shipping_phone'];
	
	                Mail::SendTemplateMail('PAYSUCCESS', $mail_params['email'], $mail_params);
					break;
			}
			
		}
	}
	
	public function paid_return($str)
	{
		$str=$this->query_decode($str);
		if(!$str){
			exit;
		}else{
			$a_tem = explode('&', $str);
			foreach($a_tem as $val){
			    $tem = explode('=', $val);
			    $$tem[0] = Security::xss_clean($tem[1]);
			}
		}
		if(isset($orderNum)&&$orderNum!='')
		{
			$order=ORM::factory("order")
					->where("ordernum","=",$orderNum)
					->find();
			if($order->loaded())
			{
				return $order;
			}
			else 
				exit;
		}
	}
	
	public function query_decode($sEncode){//解密链接
	    if(strlen($sEncode)==0){
	        return '';
	    }else{
	        $s_tem = strrev($sEncode);
	        $s_tem = base64_decode($s_tem);
	        $s_tem = rawurldecode($s_tem);
			$vcode=substr($s_tem,6,7);
			$s_tem=substr($s_tem,14);
	        $a_tem = explode('&', $s_tem);
			$hash='id8ap';
			$verifyCode='';
			foreach($a_tem as $rs){
				$verifyCode.=$hash.$rs;
			}
			$verifyCode=substr(md5($verifyCode),3,7);
			if($verifyCode==$vcode){
			  return $s_tem;
			}else{
				return '';
			}
	    }
	}
}
?>