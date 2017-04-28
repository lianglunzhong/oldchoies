<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>payment</title>
        <style>
            table td{display: none;}
        </style>
        <script type="text/javascript" src="<?php echo 'https://' . Site::instance()->get('domain'); ?>/js/jquery.js"></script>
    </head>
    <body>

        <form action="<?php echo $_GET['post_url']; ?>" method="post" name="payment_form" id="payment_from">  
            <input type="hidden" name="merNo" value="<?php echo $_GET['merNo']; ?>">
            <input type="hidden" name="gatewayNo" value="<?php echo $_GET['gatewayNo']; ?>">
            <input type="hidden" name="orderNo" value="<?php echo $_GET['orderNo']; ?>">
            <input type="hidden" name="orderCurrency" value="<?php echo $_GET['orderCurrency']; ?>">
            <input type="hidden" name="orderAmount" value="<?php echo $_GET['orderAmount']; ?>">
            <input type="hidden" name="signInfo" value="<?php echo $_GET['signInfo']; ?>">
            <input type="hidden" name="returnUrl" value="<?php echo $_GET['returnUrl']; ?>">
            <input type="hidden" name="firstName" value="<?php echo $_GET['firstName']; ?>">
            <input type="hidden" name="lastName" value="<?php echo $_GET['lastName']; ?>">
            <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
            <input type="hidden" name="phone" value="<?php echo $_GET['phone']; ?>">
            <input type="hidden" name="country" value="<?php echo $_GET['country']; ?>">
            <input type="hidden" name="city" value="<?php echo $_GET['city']; ?>">
            <input type="hidden" name="address" value="<?php echo $_GET['address']; ?>">
            <input type="hidden" name="zip" value="<?php echo $_GET['zip']; ?>">

        </form>
        <?php // exit; ?>
        <script>
            $(function(){
                $('#payment_from').submit();
            });
        </script>
    </body>
</html>