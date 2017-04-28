<!-- main begin -->
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Home Page</a>  >  Unpaid Orders</div>
            <?php echo Message::get(); ?>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Unpaid Orders</h2></div>
            <?php
            if (empty($orders)):
                $user_id = Customer::logged_in();
                $firstname = Customer::instance($user_id)->get('firstname');
                ?>
                <p class="mb25"><?php echo $firstname ? ucfirst($firstname) : 'Choieser'; ?>, you do not have any Orders. It′s time to do some shopping on Choies with your 15% off Coupon now.</p>
                <?php
            else:
                ?>
                <table class="user_table user_table1">
                    <tr class="first">
                        <th width="25%">Product Details</th>
                        <th width="10%">Price</th>
                        <th width="5%">QTY</th>
                        <th width="10%"></th>
                        <th width="5%">Shipping</th>
                        <th width="12%">Order Total</th>
                        <th width="18%">Order Status</th>
                        <th width="20%">Action</th>
                    </tr>
                </table>
                <?php
                foreach ($orders as $order):
                    $currency = Site::instance()->currencies($order['currency']);
                    $status = $order['payment_status'];
                    $d_amount = 0;
                    $amount = 0;
                    $products = Order::instance($order['id'])->products();
                    if (empty($products))
                        continue;
                    ?>
                    <table class="user_table user_table1">
                        <tr class="second">
                            <th colspan="8">Order No.: <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><b><?php echo $order['ordernum']; ?></b></a>    <span>Order Time: <?php echo date('n/j/Y H:i:s', $order['created']); ?></span></th>
                        </tr>
                        <tr>
                            <td colspan="4" width="45%" class="table2_box">
                                <table class="table2" width="100%">
                                    <?php
                                    foreach ($products as $p):
                                        if($p['status'] == 'cancel')
                                            continue;
                                        $product = DB::select('stock', 'visibility', 'status', 'sku', 'name', 'link')->from('products_product')->where('id', '=', $p['product_id'])->execute()->current();
                                        $outstock = 0;
                                        if (!$product['visibility'] OR !$product['status'] OR $product['stock'] == 0)
                                        {
                                            $outstock = 1;
                                        }
                                        elseif ($product['stock'] == -1)
                                        {
                                            $stocks = DB::select()
                                                    ->from('products_stocks')
                                                    ->where('product_id', '=', $p['product_id'])
                                                    ->where('stocks', '<>', 0)
                                                    ->execute();
                                            $has = 0;
                                            foreach ($stocks as $stock)
                                            {
                                                if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                                {
                                                    if ($p['quantity'] > $stock['stocks'])
                                                        $p['quantity'] = $stock['stocks'];
                                                    $amount += $p['price'] * $p['quantity'] * $order['rate'];
                                                    $has = 1;
                                                    break;
                                                }
                                            }
                                            if (!$has)
                                                $outstock = 1;
                                        }
                                        else
                                        {
                                            $amount += $p['price'] * $p['quantity'] * $order['rate'];
                                        }
                                        ?>
                                        <tr>
                                            <td width="45%">
                                                <div class="fix">
                                                    <div class="left"><a href="<?php echo LANGPATH; ?>/product/<?php echo $product['link']; ?>"><img src="<?php echo image::link(Product::instance($p['product_id'])->cover_image(), 3); ?>" /></a></div>
                                                    <div class="right">
                                                        <a href="<?php echo LANGPATH; ?>/product/<?php echo $product['link']; ?>" class="name"><?php echo $product['name']; ?></a>
                                                        <?php if ($outstock): ?><p class="red">(Out of stock)</p><?php endif; ?>
                                                        <p><?php
                                            $attributes = 'Size:' . str_replace(';', ';<br>', $p['attributes']);
                                            $attributes = str_replace('delivery time: 0', 'delivery time: regular order', $attributes);
                                            $attributes = str_replace('delivery time: 15', 'delivery time: rush order', $attributes);
                                            echo $attributes;
                                                        ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td width="20%"><p class="red"><?php echo $currency['code'] . round($p['price'] * $order['rate'], 2); ?></p></td>
                                            <td width="10%"><?php echo $p['quantity']; ?></td>
                                            <td width="15%"><a href="#" class="a_underline"></a></td>
                                        </tr>
                                        <?php
                                    endforeach;
                                    $amount_order = $amount + $order['amount_shipping'];
                                    if ($amount_order > $order['amount'])
                                        $amount_order = $order['amount'];
                                    if (in_array($order['payment_status'], array('new', 'failed')) AND $amount == 0)
                                        $amount_order = $order['amount'];
                                    ?>
                                </table>
                            </td>
                            <td width="8%"><?php echo $currency['code'] . round($order['amount_shipping'], 2); ?></td>
                            <td width="12%"><?php echo $currency['code'] . round($amount_order, 2); ?></td>
                            <td width="15%">
                                <b>
                                    <?php
                                    if ($order['refund_status'])
                                    {
                                        $status = str_replace('_', ' ', $order['refund_status']);
                                    }
                                    else
                                    {
                                        $status = kohana::config('order_status.payment.' . $order['payment_status'] . '.name');
                                        if ($status == 'New' OR $status == 'new')
                                            $status = 'Unpaid(New)';
                                    }
                                    echo ucfirst($status);
                                    ?>
                                </b>
                            </td>
                            <td width="15%">
                                <?php
                                if ($amount > 0)
                                {
                                    ?>
                                    <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="btn22_red bold mb10">To pay</a>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                <?php endforeach; ?>
                <?php echo $pagination; ?>
            <?php
            endif;
            ?>  
        </article>
        <?php echo View::factory('customer/left'); ?>
    </section>
</section>