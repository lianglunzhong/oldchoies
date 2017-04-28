<div style='display:none'>
    <form name='masapay' id="masapay" class="payment_form" action='<?php echo $action_url; ?>' method='post'>
        <input type="hidden" name="version" value="<?php echo $config['version']; ?>" />
        <input type="hidden" name="merchantId" value="<?php echo $config['merchantId']; ?>" />
        <input type="hidden" name="charset" value="<?php echo $config['charset']; ?>" />
        <input type="hidden" name="language" value="<?php echo $config['language']; ?>" />
        <input type="hidden" name="signType" value="<?php echo $config['signType']; ?>" />
        <input type="hidden" name="merchantOrderNo" value="<?php echo $config['merchantOrderNo']; ?>" />
        <input type="hidden" name="goodsName" value="<?php echo $config['goodsName']; ?>"/>
        <input type="hidden" name="goodsDesc" value="<?php echo $config['goodsDesc']; ?>" />
        <input type="hidden" name="currencyCode" value="<?php echo $config['currencyCode']; ?>" />
        <input type="hidden" name="orderAmount" value="<?php echo $config['orderAmount']; ?>" />
        <input type="hidden" name="payMode" value="<?php echo $config['payMode']; ?>"/>
        <input type="hidden" name="directFlag" value="<?php echo $config['directFlag']; ?>" />
        <input type="hidden" name="submitTime" value="<?php echo $config['submitTime']; ?>" />
        <input type="hidden" name="pageUrl" value="<?php echo $config['pageUrl']; ?>" />
        <input type="hidden" name="bgUrl" value="<?php echo $config['bgUrl']; ?>" />
        <input type="hidden" name="shippingFirstName" value="<?php echo $config['shippingFirstName']; ?>" />
        <input type="hidden" name="shippingLastName" value="<?php echo $config['shippingLastName']; ?>" />
        <input type="hidden" name="shippingAddress" value="<?php echo $config['shippingAddress']; ?>" />
        <input type="hidden" name="shippingPostalCode" value="<?php echo $config['shippingPostalCode']; ?>" />
        <input type="hidden" name="shippingCountry" value="<?php echo $config['shippingCountry']; ?>" />
        <input type="hidden" name="shippingState" value="<?php echo $config['shippingState']; ?>" />
        <input type="hidden" name="shippingCity" value="<?php echo $config['shippingCity']; ?>" />
        <input type="hidden" name="shippingEmail" value="<?php echo $config['shippingEmail']; ?>" />
        <input type="hidden" name="shippingPhoneNumber" value="<?php echo $config['shippingPhoneNumber']; ?>" />
        <input type="hidden" name="registerUserEmail" value="<?php echo $config['registerUserEmail']; ?>" />
        <input type="hidden" name="registerTime" value="<?php echo $config['registerTime']; ?>" />
        <input type="hidden" name="registerIp" value="<?php echo $config['registerIp']; ?>" />
        <input type="hidden" name="registerTerminal" value="<?php echo $config['registerTerminal']; ?>" />
        <input type="hidden" name="orderIp" value="<?php echo $config['orderIp']; ?>" />
        <input type="hidden" name="orderTerminal" value="<?php echo $config['orderTerminal']; ?>" />
        <input type="hidden" name="signMsg" value="<?php echo $config['signMsg']; ?>" />

        <input type="hidden" name="billFirstName" value="<?php echo $config['billFirstName']; ?>" />
        <input type="hidden" name="billLastName" value="<?php echo $config['billLastName']; ?>" />
        <input type="hidden" name="billAddress" value="<?php echo $config['billAddress']; ?>" />
        <input type="hidden" name="billPostalCode" value="<?php echo $config['billPostalCode']; ?>" />
        <input type="hidden" name="billCountry" value="<?php echo $config['billCountry']; ?>" />
        <input type="hidden" name="billState" value="<?php echo $config['billState']; ?>" />
        <input type="hidden" name="billCity" value="<?php echo $config['billCity']; ?>" />
        <input type="hidden" name="billEmail" value="<?php echo $config['billEmail']; ?>" />
        <input type="hidden" name="billPhoneNumber" value="<?php echo $config['billPhoneNumber']; ?>" />

    </form>
</div>
<script type="text/javascript">
    window.onload = function(){
        document.getElementById('masapay').submit();
    }
</script>