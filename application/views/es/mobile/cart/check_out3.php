<div id="container" style="margin-top:30px; background: #fff;">
        <div class="step_l fll" id="payment">
                <div class="step_tit">MAKE THE PAYMENT</div>
<!--                <p>Note: For security purposes, we will not save any of your credit card data.</p>-->
                <br/>
                <div class="step3" style="width: 635px;">
                        <?php
                        if (isset($iframe) AND !empty($iframe))
                        {
                                //嵌入第三方站内支付
                                echo $iframe;
                        }
                        ?>
                </div>
        </div>
        <div class="step_r flr">
                <div class="step_form_h2" style="margin-top:0px;">ORDER SUMMARY</div>
                <div class="order">
                        <ul>
                        <?php
                        $products = Order::instance($order['id'])->products();
                        foreach ($products as $product):
                        ?>
                                <li>
                                        <div class="order_img fll">
                                                <a href="<?php echo Product::instance($product['product_id'])->permalink(); ?>">
                                                        <img width="88" src="<?php echo image::link(Product::instance($product['product_id'])->cover_image(), 3); ?>" alt="" />
                                                </a>
                                        </div>
                                        <div class="order_desc fll">
                                                <h3><?php echo Product::instance($product['product_id'])->get('name'); ?></h3>
                                                <p><?php echo Site::instance()->price($product['price'], 'code_view'); ?><br />
                                                <?php
                                                $attributes = explode(';', $product['attributes']);
                                                foreach($attributes as $attribute):
                                                        if (strpos($attribute, 'delivery time'))
                                                        {
                                                                $attribute = str_replace('0', 'Regular Order', $attribute);
                                                                $attribute = str_replace('15', 'Rush Order', $attribute);
                                                        }
                                                        echo $attribute . '<br>';
                                                endforeach;
                                                ?>
                                                        Quantity: <?php echo $product['quantity']; ?></p>
                                        </div>
                                        <div class="fix"></div>
                                </li>
                        <?php
                        endforeach;
                        ?>        
                        </ul>
                </div>
                <div class="step_total">
                        <ul>
                                <li><span>Subtotal:</span><?php echo Site::instance()->price($order['amount_products'], 'code_view'); ?></li>
                                <li><span>Estimated Shipping:</span><?php echo Site::instance()->price($order['amount_shipping'], 'code_view'); ?></li>
                                <?php
                                if($order['amount_coupon'] > 0):
                                ?>
                                <li><span>Coupon Code:</span>- <?php echo Site::instance()->price($order['amount_coupon'], 'code_view'); ?></li>
                                <?php
                                endif;
                                $save = $order['amount_products'] + $order['amount_shipping'] - $order['amount'];
                                if($save > 0):
                                ?>
                                <li><span>Order Subtotal Save:</span>- <?php echo Site::instance()->price($save, 'code_view'); ?></li>
                                <?php endif; ?>
                                <li class="amount"><span>Total:</span><?php echo Site::instance()->price($order['amount'], 'code_view'); ?></li>
                        </ul>
                </div>
        </div>
</div>
