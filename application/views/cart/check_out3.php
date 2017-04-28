<!-- <script src="//cdn.optimizely.com/js/557241246.js"></script> -->
<div class="cart_header">
    <div class="layout">
        <a href="/" class="logo"><img src="/images/logo.png" /></a>
        <div class="cart_step">
            <h2><img src="/images/payment_step3.png" /></h2>
            <div class="cart_step_bottom">
                <span>Shipping & Delivery</span>
                <span>Payment & Confirmation</span>
                <span class="on">Order Placement</span>
            </div>
        </div>
        <a href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en" target="_blank"><img src="/images/card3.png" /></a>
    </div>
</div>
<section id="main">
    <div id="forgot_password">
        <?php echo Message::get(); ?>
    </div>
    
    <section class="layout fix">
        <section class="cart">
            <section class="shipping_delivery fix">
                <article class="shipping_delivery_left payment_box">
                    <!-- payment -->
                    <h2 class="font24" style="font-size: 24px;font-weight: normal;margin-bottom: 35px;">PAYMENT</h2>
                    <div>
                        <dl id="loading" class="payment_box_dl">
                            <dt>Order Amount: <b><?php echo round($order['amount'], 2) . $order['currency']; ?></b>            <span>Order No:<b><?php echo $order['ordernum'] ?></b></span></dt>
                            <dd class="fix">
                                <span class="fll"><img src="/images/loading.gif" /></span>
                                <ul class="fll">
                                    <li>The payment page is loading to come up, it will take <b>3-5 seconds</b> or more.</li>
                                    <li>Please don't go, for your request is being processed.</li>
                                    <li>The item(s) you choose are hot picks, and only reserved for limited time, don't miss out!</li>
                                </ul> 
                            </dd>
                            <dd class="last">Feel free to contact us at <a href="mailto:service@choies.com">service@choies.com</a></dd>
                        </dl>
                        <?php
                        if (isset($iframe) AND !empty($iframe))
                        {
                            //嵌入第三方站内支付
                            echo $iframe;
                        }
                        ?>
                    </div>
                    <script type="text/javascript">
                        var ifrm_cc  = document.getElementById("payment_insite_iframe");
                        var loading  = document.getElementById("loading");
                        if (ifrm_cc.attachEvent){
                            ifrm_cc.attachEvent("onload", function(){
                                loading.style.display = 'none';
                            });
                        } else {
                            ifrm_cc.onload = function(){
                                loading.style.display = 'none';   		
                            };
                        }
                    </script>
                </article>

                <!-- order_summary -->
                <div class="order_summary flr">
                    <div class="cart_side">
                        <h3>YOUR ORDER SUMMARY</h3>
                        <ul class="pro_con1">
                            <?php
                            $currency = Site::instance()->currencies($order['currency']);
                            $products = Order::instance($order['id'])->products();
                            foreach ($products as $product):
                                $name = Product::instance($product['product_id'])->get('name');
                                $link = Product::instance($product['product_id'])->permalink();
                                $img = Product::instance($product['product_id'])->cover_image();
                                ?>
                                <li class="fix">
                                    <div class="left"><a href="<?php echo $link; ?>"><img src="<?php echo '/pimages1/'.$img['id'].'/3.'.$img['suffix']; ?>" alt="<?php echo $name; ?>" /></a></div>
                                    <div class="right">
                                        <a href="<?php echo $link; ?>" class="name"><?php echo $name; ?></a>
                                        <p>Item: #<?php echo Product::instance($product['product_id'])->get('sku'); ?></p>
                                        <p><?php echo $currency['code']; ?><?php echo round($product['price'] * $order['rate'], 2); ?></p>
                                        <p>
                                            <?php
                                            $attributes = explode(';', $product['attributes']);
                                            foreach ($attributes as $attribute):
                                                if (strpos($attribute, 'delivery time'))
                                                {
                                                    $attribute = str_replace('0', 'Regular Order', $attribute);
                                                    $attribute = str_replace('15', 'Rush Order', $attribute);
                                                }
                                                echo $attribute . '<br>';
                                            endforeach;
                                            ?>
                                        </p> 
                                        <p>Quantity: <?php echo $product['quantity']; ?></p>
                                    </div>
                                </li>
                                <?php
                            endforeach;
                            ?>
                        </ul>
                        <ul class="total">
                            <li class="font14"><label>Subtotal: </label><span><?php echo $currency['code'] . round($order['amount_products'], 2); ?></span></li>     
                            <li><label>Estimated Shipping: </label><span><?php echo $currency['code'] . round($order['amount_shipping'], 2); ?></span></li>
                            <?php
                            $amount_point = $order['points'] / 100;
                            if ($order['amount_coupon'] + $amount_point > 0):
                                ?>
                                <li><label>Pay with Coupons & Points: </label><span><?php echo $currency['code']; ?><?php echo round($order['amount_coupon'] + $amount_point, 2); ?></span></li>
                                <?php
                            endif;
                            $saving = round($order['amount_products'] + $order['amount_shipping'] - $order['amount'], 2);
                            $item_saving = round($saving - $order['amount_coupon'] - $amount_point, 2);
                            if ($item_saving > 0):
                                ?>
                                <li><label>Sale Items Saving: </label><span><?php echo $currency['code'] . round($item_saving, 2); ?></span></li> 
                                <?php
                            endif;
                            ?>
                            <li class="total_num font14"><label>Total: </label><span class="font18"><?php echo $currency['code'] . round($order['amount'], 2); ?></span></li>
                            <?php
                            if ($saving > 0):
                                ?>
                                <li class="last red"><label>Savings: </label><span><?php echo $currency['code'] . round($saving, 2); ?></span></li>
                                <?php
                            endif;
                            ?>
                        </ul>
                    </div>
                </div>
            </section>
        </section>
    </section>
</section>

<span class="livechat">
        <?php $domain = Site::instance()->get('domain'); ?>
    <!--Begin Comm100 Live Chat Code-->
    <div id="comm100-button-311"></div>  
    <script type="text/javascript">
        var Comm100API = Comm100API || new Object;
        Comm100API.chat_buttons = Comm100API.chat_buttons || [];
        var comm100_chatButton = new Object;
        comm100_chatButton.code_plan = 311;
        comm100_chatButton.div_id = 'comm100-button-311';
        Comm100API.chat_buttons.push(comm100_chatButton);
        Comm100API.site_id = 203306;
        Comm100API.main_code_plan = 311;
        var comm100_lc = document.createElement('script');
        comm100_lc.type = 'text/javascript';
        comm100_lc.async = true;
        comm100_lc.src = 'https://chatserver.comm100.com/livechat.ashx?siteId=' + Comm100API.site_id;
        var comm100_s = document.getElementsByTagName('script')[0];
        comm100_s.parentNode.insertBefore(comm100_lc, comm100_s);
    </script>
    <!--End Comm100 Live Chat Code-->
</span>

<footer>
    <div class="footer_payment">
        <div class="card">
            <p><img src="/images/card.jpg" usemap="#Card" /></p>
            <map name="Card" id="Card">
                <area target="_blank" shape="rect" coords="187,14,266,57" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en" />
            </map>
            <p class="bottom">Copyright © 2006-<?php echo date('Y'); ?> choies.com</p>
        </div>
    </div>
</footer>