<div style='display:none'>
	<form name='<?php echo $name; ?>' id="<?php echo $name; ?>" class="payment_form" action='<?php echo $action_url; ?>' method='post'>
		<input type='hidden' name='cmd' value='_xclick'/>
		<input type='hidden' name='business' value='<?php echo $config['merchant_id']; ?>'/>
		<input type='hidden' name='item_name' value='<?php echo isset($order['ordernum']) ? $order['ordernum'] : ''; ?>'/>
		<input type='hidden' name='item_number' value='<?php echo (isset($order['ordernum']) ? $order['ordernum'] : '').':'.(isset($order['id']) ? $order['id'] : ''); ?>'/>
		<input type='hidden' name="notify_url" value="<?php echo $config['notify_url']; ?>">
		<input type='hidden' name="return" value="<?php echo $config['return_url']; ?>">
		<input type='hidden' name="cancel_return" value="<?php echo $config['cancel_return_url']; ?>">
		<input type='hidden' name='amount' value='<?php echo isset($order['amount']) ? round($order['amount'], 2) : ''; ?>'/>
		<input type='hidden' name='currency_code' value='<?php echo isset($order['currency']) ? $order['currency'] : ''; ?>'/>
		<input type='hidden' name='image_url' value='<?php echo $config['pp_logo_url']; ?>'/>
	</form>
</div>