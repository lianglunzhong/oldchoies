<p id="crumbs"><a href="<?php echo LANGPATH; ?>/">Home</a> / <a href="<?php echo LANGPATH; ?>/mobilecustomer/profile">My Account</a> / Order Detail	</p>
<?php echo Message::get(); ?>

<h2>Order Number: <?php echo $order->get('ordernum'); ?></h2>
<div class="order-summary-detail">
    <ul>
        <li><strong>Status:</strong> <?php echo $order->get('payment_status'); ?></li>
        <li><strong>Shipping Address:</strong>
            <ul><li></li>
                <li><?php echo $order->get('shipping_firstname') . ' ' . $order->get('shipping_lastname'); ?></li>
                <li><?php echo $order->get('shipping_address'); ?></li>			
                <li><?php echo $order->get('shipping_city') . ' ' . $order->get('shipping_state') . ' ' . $order->get('shipping_zip'); ?></li>
                <li><?php echo $order->get('shipping_country'); ?></li>
            </ul>
        </li>
    </ul>
</div>


<?php
$currency = Site::instance()->currencies($order->get('currency'));
$status = $order->get('payment_status');
$amount = 0;
$d_amount = 0;
$d_skus = array();
foreach ($order->products() as $product):
    $stock = Product::instance($product['product_id'])->get('stock');
    if ($status != 'success' AND $status != 'verify_pass' AND (!Product::instance($product['product_id'])->get('visibility') OR !Product::instance($product['product_id'])->get('status') OR ($stock != -99 AND $stock <= 0)))
    {
        $d_product[] = $product['product_id'];
        $d_skus[] = $product['sku'];
        $d_amount += $product['price'] * $product['quantity'];
        continue;
    }
    else
    {
        $amount += $product['price'] * $product['quantity'];
    }
    ?>
    <p>
        <strong>Item#:</strong><?php echo Product::instance($product['product_id'])->get('sku'); ?> | 
        <strong>Name:</strong><?php echo Product::instance($product['product_id'])->get('name'); ?> | 
        <strong><?php
    $attributes = str_replace(';', ';<br>', $product['attributes']);
    $attributes = str_replace('delivery time: 0', 'delivery time: regular order', $attributes);
    $attributes = str_replace('delivery time: 15', 'delivery time: rush order', $attributes);
    echo $attributes;
    ?></strong> | 
        <strong>Quantity:</strong> <?php echo $product['quantity']; ?> | 
        <strong>Price:</strong> <?php echo Site::instance()->price($product['price'], 'code_view', NULL, $currency); ?> | 
        <strong>Total:</strong> <?php echo Site::instance()->price($product['price'] * $product['quantity'], 'code_view', NULL, $currency); ?>	
    </p>
    <?php
endforeach;

$delete_product = isset($d_product) ? implode(',', $d_product) : '';
$amount_order = $amount + $order->get('amount_shipping');
if ($amount_order > $order->get('amount'))
    $amount_order = $order->get('amount');
if (in_array($order->get('payment_status'), array('new', 'failed')) AND $amount_order == 0)
    $amount_order = $order->get('amount');
//                        $amount = $order->get('amount_products');
?>


<table class="cost-summary"><tbody>
        <tr><td>Subtotal:</td>
            <td class="text-right"><?php echo $currency['code'] . round($order->get('amount_products'), 2); ?></td></tr>
        <tr><td>Express Shipping:</td>
            <td class="text-right"><?php echo $currency['code'] . round($order->get('amount_shipping'), 2); ?></td></tr>
        <?php
        $save = $order->get('amount_products') + $order->get('amount_shipping') - $order->get('amount');
        if ($save > 0):
            ?>
            <tr>
                <td class="tal">Order Subtotal Save:</td>
                <td class="tar">-<?php echo $currency['code'] . round($save, 2); ?></td>
            </tr>
        <?php endif; ?>
        <tr><td><strong>Total:</strong></td>
            <td class="text-right"><strong><?php echo $currency['code'] . round($amount_order, 2); ?></strong></td></tr></tbody>
</table>
<?php if (!empty($d_skus)): ?>
    <div>
        <span class="red">P.s: <strong><?php echo implode(' / ', $d_skus); ?></strong> in your order <?php echo count($d_skus) > 1 ? 'are' : 'is'; ?> out of stock now.</span>
    </div>
<?php endif; ?>
