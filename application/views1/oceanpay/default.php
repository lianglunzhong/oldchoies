<div style='display:none'>
	<form name='<?php echo $name; ?>' id="<?php echo $name; ?>" class="payment_form" action='<?php echo $action_url; ?>' method='post'>
		<input type="hidden" name="account" value="<?php echo $config['account']; ?>" />
		<input type="hidden" name="terminal" value="<?php echo $config['terminal']; ?>" />
		<input type="hidden" name="order_number" value="<?php echo $order['ordernum']; ?>" />
		<input type="hidden" name="order_currency" value="<?php echo $order['currency']; ?>" />
		<input type="hidden" name="order_amount" value="<?php echo round($order['amount'],2); ?>" />
		<input type="hidden" name="signValue" value="<?php echo $config['signValue']; ?>" />
		<input type="hidden" name="backUrl" value="<?php echo $config['sofort_backUrl']; ?>" /> 
		<input type="hidden" name="noticeUrl" value="<?php echo $config['sofort_noticeUrl']; ?>"/>
		<input type="hidden" name="methods" value="<?php echo $config['methods']; ?>" />
		<input type="hidden" name="billing_firstName" value="<?php echo $order['shipping_firstname']; ?>" />
		<input type="hidden" name="billing_lastName" value="<?php echo $order['shipping_lastname']; ?>" />
		<input type="hidden" name="billing_email" value="<?php echo $order['email']; ?>"/>
		<input type="hidden" name="billing_phone" value="<?php echo $order['shipping_phone']; ?>" />
		<input type="hidden" name="billing_country" value="<?php echo $order['shipping_country']; ?>" />
		<input type="hidden" name="billing_city" value="<?php echo $order['shipping_city']; ?>" />
		<input type="hidden" name="billing_address" value="<?php echo $order['shipping_address']; ?>" />
		<input type="hidden" name="billing_zip" value="<?php echo $order['shipping_zip']; ?>" />
		<?php if(isset($config['productSku'])){ ?>
		<input type="hidden" name="productSku" value="<?php echo $config['productSku']; ?>" /> 
		<input type="hidden" name="productName" value="<?php echo $config['productName']; ?>" /> 
		<input type="hidden" name="productNum" value="<?php echo $config['productNum']; ?>" /> 
		<?php } ?>
		<?php if(isset($config['logoUrl'])){ ?>
		<input type="hidden" name="logoUrl" value="<?php echo $config['logoUrl']; ?>" /> 
		<?php } ?>
		<?php if(isset($order['lang'])){ ?>
		<input type="hidden" name="language" value="<?php echo $order['lang']; ?>" /> 
		<?php } ?>
	</form>
</div>
<script type="text/javascript">
    window.onload = function(){
        document.getElementById('<?php echo $name; ?>').submit();
    }
</script>