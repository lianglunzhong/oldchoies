<div style='display:none'>
    <form name='<?php echo $name; ?>' id="<?php echo $name; ?>" action='<?php echo $action_url; ?>' method='post'>
        <input type='hidden' name='cmd' value='_cart'/>
        <input type="hidden" name="upload" value="1">
        <input type="hidden" name="charset" value="utf-8">
        <input type='hidden' name='business' value='<?php echo $config['merchant_id']; ?>'/>
        <input type='hidden' name='custom' value='<?php echo (isset($order['ordernum']) ? $order['ordernum'] : '') . ':' . (isset($order['id']) ? $order['id'] : ''); ?>'/>
        <input type='hidden' name='invoice' value='<?php echo (isset($order['ordernum']) ? $order['ordernum'] : '') . ':' . (isset($order['id']) ? $order['id'] : ''); ?>'/>
        <?php
        $key = 1;
        $currency = Site::instance()->currencies($order['currency']);
        $products = Order::instance($order['id'])->products();
        $amount_products = 0;
        $amount_products1 = 0;
        foreach ($products as $product)
        {
            $attributes = $product['attributes'];
//                        foreach($product['attributes'] as $attr => $val)
//                        {
//                                $attributes .= $attr . ':' . $val . ';';
//                        }
            $amount_products += $product['price'] * $currency['rate'] * $product['quantity'];
            $amount_products1 += round($product['price'] * $currency['rate'], 2) * $product['quantity'];
            ?>
            <input type="hidden" name="item_name_<?php echo $key; ?>" value="<?php echo str_replace(array('$', '£', '€'), '', Product::instance($product['product_id'])->get('name')); ?>" />
            <input type="hidden" name="item_number_<?php echo $key; ?>" value="<?php echo Product::instance($product['product_id'])->get('sku'); ?>" />
            <input type="hidden" name="amount_<?php echo $key; ?>" value="<?php echo round($product['price'] * $currency['rate'], 2); ?>" />
            <input type="hidden" name="quantity_<?php echo $key; ?>" value="<?php echo $product['quantity']; ?>" />
            <input type="hidden" name="on0_<?php echo $key; ?>" value="attributes" />
            <input type="hidden" name="os0_<?php echo $key; ?>" value="<?php echo $attributes; ?>" />
            <?php
            $key++;
        }
        $amount_products = round($amount_products, 2);
        $discount = $amount_products + $order['amount_shipping'] - $order['amount'];
        $shipping = isset($order['amount_shipping']) ? round($order['amount_shipping'], 2) : 0;
            if($order['order_insurance'] > 0)
            {
                $insurance = round($order['order_insurance'] * $order['rate'], 2);
                $shipping += $insurance;
            }

        if ($amount_products > $amount_products1)
            $shipping += $amount_products - $amount_products1;
        $special = 0;
        if ($discount > $order['amount_products'])
        {
            $special = 1;
        }
        if ($special)
        {
            ?>
            <input type="hidden" name="item_name_<?php echo $key; ?>" value="Shipping" />
            <input type="hidden" name="amount_<?php echo $key; ?>" value="<?php echo $shipping; ?>" />
            <input type="hidden" name="quantity_<?php echo $key; ?>" value="1" />
            <?php
        }
        else
        {
            ?>
            <input type="hidden" name="shipping_1" value="<?php echo $shipping; ?>">
            <?php
        }
        ?>
        <input type="hidden" name="discount_amount_cart" value="<?php echo $discount > 0 ? round($discount, 2) : ''; ?>">
        <input type='hidden' name="notify_url" value="<?php echo $config['notify_url']; ?>">
        <input type='hidden' name="return" value="<?php echo $config['return_url']; ?>">
        <input type='hidden' name="cancel_return" value="<?php echo $config['cancel_return_url']; ?>">
        <input type='hidden' name='amount' value='<?php echo isset($order['amount']) ? round($order['amount'], 2) : ''; ?>'/>
        <input type='hidden' name='currency_code' value='<?php echo isset($order['currency']) ? $order['currency'] : ''; ?>'/>
        <input type='hidden' name='image_url' value='<?php echo $config['pp_logo_url']; ?>'/>
        <input type="hidden" name="address1" value="<?php echo $order['shipping_address']; ?>"/>
        <input type="hidden" name="city" value="<?php echo $order['shipping_city']; ?>"/>
        <input type="hidden" name="country" value="<?php echo $order['shipping_country']; ?>"/>
        <input type="hidden" name="email" value="<?php echo $order['email']; ?>"/>
        <input type="hidden" name="first_name" value="<?php echo $order['shipping_firstname']; ?>"/>
        <input type="hidden" name="last_name" value="<?php echo $order['shipping_lastname']; ?>"/>
        <input type="hidden" name="state" value="<?php echo $order['shipping_state']; ?>"/>
        <input type="hidden" name="zip" value="<?php echo $order['shipping_zip']; ?>"/>
        <input type="hidden" name="night_phone_a" value="<?php echo $order['shipping_phone']; ?>">
        <input type="hidden" name="lc" value="US"/>
    </form>
</div>
<script type="text/javascript">
    window.onload = function(){
        document.getElementById('<?php echo $name; ?>').submit();
    }
</script>