<div style='display:none'>
	<form action="<?php echo $action_url; ?>" method='post' id="globebillForm">
		<input type="hidden" name="MerNo" value="<?php echo $MerNo; ?>">
		<input type="hidden" name="BillNo" value="<?php echo $BillNo; ?>">
		<input type="hidden" name="Amount" value="<?php echo $Amount; ?>">
		<input type="hidden" name="baseInfo" value="<?php echo $user_info; ?>">
		<input type="hidden" name="ReturnURL" value="<?php echo $ReturnURL; ?>">
		<input type="hidden" name="Language" value="<?php echo $Language; ?>">
		<input type="hidden" name="Currency" value="<?php echo $Currency; ?>">
		<input type="hidden" name="PayCurrency" value="<?php echo $PayCurrency; ?>">
		<input type="hidden" name="MD5info" value="<?php echo $MD5info; ?>">
	</form>
</div>
<script type="text/javascript">
        window.onload = function(){
             document.getElementById('globebillForm').submit();
        }
</script>