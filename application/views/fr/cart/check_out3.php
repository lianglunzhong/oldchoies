<!-- <script src="//cdn.optimizely.com/js/557241246.js"></script> -->
<div class="cart_header">
    <div class="layout">
        <a href="<?php echo LANGPATH; ?>/" class="logo"><img src="/images/logo.png" /></a>
        <div class="cart_step">
            <h2><img src="/images/payment_step3.png" /></h2>
            <div class="cart_step_bottom">
                <span>Expédition&Livraison</span>
                <span>Payement&Confirmation</span>
                <span class="on">Passation Des Commandes</span>
            </div>
        </div>
        <a href="https://sealserver.trustkeeper.net/cert.php?customerId=y2cj3BufDhnnkhj5am2daSvaX2I8Ww&size=105x54&style=normal" target="_blank"><img src="/images/card3.png" /></a>
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
                    <h2 class="font24" style="font-size: 24px;font-weight: normal;margin-bottom: 35px;">PAIEMENT</h2>
                    <div>
                        <dl id="loading" class="payment_box_dl">
                            <dt>Montant de la commande: <b><?php echo $order['amount'] . $order['currency']; ?></b> <span>Numéro de Commande:<b><?php echo $order['ordernum'] ?></b></span></dt>
                            <dd class="fix">
                                <span class="fll"><img src="/images/loading.gif" /></span>
                                <ul class="fll">
                                    <li>La page de payement est en chargement, cela vous dépensera quelques secondes.</li>
                                    <li>Veuillez ne pas la quitter， pour le traitement de votre demande.</li>
                                    <li>L'article que vous choisissez est le plus demandé, il n'est réservé que pour le temps limité, ne pas le manquer!</li>
                                </ul> 
                            </dd>
                            <dd class="last">N'hésitez pas à nous contacter sur <a href="mailto:service_fr@choies.com">service_fr@choies.com</a></dd>
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
                        <h3>VÉRIFIEZ VOTRE COMMANDE</h3>
                        <ul class="pro_con1">
                            <?php
                            $products = Order::instance($order['id'])->products();
                            foreach ($products as $product):
                                $name = Product::instance($product['product_id'], LANGUAGE)->get('name');
                                $link = Product::instance($product['product_id'], LANGUAGE)->permalink();
                                $img = Product::instance($product['product_id'])->cover_image();
                                ?>
                                <li class="fix">
                                    <div class="left"><a href="<?php echo $link; ?>"><img src="<?php echo '/pimages1/'.$img['id'].'/3.'.$img['suffix']; ?>" alt="<?php echo $name; ?>" /></a></div>
                                    <div class="right">
                                        <a href="<?php echo $link; ?>" class="name"><?php echo $name; ?></a>
                                        <p>Article: #<?php echo Product::instance($product['product_id'])->get('sku'); ?></p>
                                        <p><?php echo Site::instance()->price($product['price'], 'code_view'); ?></p>
                                        <p>
                                            <?php
                                            $attributes = explode(';', $product['attributes']);
                                            foreach ($attributes as $attribute):
                                                if (strpos($attribute, 'delivery time'))
                                                {
                                                    $attribute = str_replace('0', 'Regular Order', $attribute);
                                                    $attribute = str_replace('15', 'Rush Order', $attribute);
                                                }
                                                $attribute = str_replace('Size', 'Taille', $attribute);
                                                echo $attribute . '<br>';
                                            endforeach;
                                            ?>
                                        </p> 
                                        <p>Qté: <?php echo $product['quantity']; ?></p>
                                    </div>
                                </li>
                                <?php
                            endforeach;
                            ?>
                        </ul>
                        <ul class="total">
                            <li class="font14"><label>Sous-total: </label><span><?php echo Site::instance()->price($order['amount_products'], 'code_view'); ?></span></li>     
                            <li><label>Livraison: </label><span><?php echo Site::instance()->price($order['amount_shipping'], 'code_view'); ?></span></li>
                            <?php
                            $amount_point = $order['points'] / 100;
                            if ($order['amount_coupon'] + $amount_point > 0):
                                ?>
                                <li><label>Payer avec Coupons & Points: </label><span><?php echo Site::instance()->price($order['amount_coupon'] + $amount_point, 'code_view'); ?></span></li>
                                <?php
                            endif;
                            $saving = $order['amount_products'] + $order['amount_shipping'] - $order['amount'];
                            $item_saving = round($saving - $order['amount_coupon'] - $amount_point, 2);
                            if ($item_saving > 0):
                                ?>
                                <li><label>remise: </label><span><?php echo Site::instance()->price($item_saving, 'code_view'); ?></span></li> 
                                <?php
                            endif;
                            ?>
                            <li class="total_num font14"><label>Total: </label><span class="font18"><?php echo Site::instance()->price($order['amount'], 'code_view'); ?></span></li>
                            <?php
                            if ($saving):
                                ?>
                                <li class="last red"><label>Économiser: </label><span><?php echo Site::instance()->price($saving, 'code_view'); ?></span></li>
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
    <!-- BEGIN ProvideSupport.com Custom Images Chat Button Code -->
    <div id="ciSMPP" style="z-index:100;position:absolute"></div><div id="scSMPP" style="display:inline"></div><div id="sdSMPP" style="display:none"></div><script type="text/javascript">var seSMPP=document.createElement("script");seSMPP.type="text/javascript";var seSMPPs=(location.protocol.indexOf("https")==0?"https":"http")+"://image.providesupport.com/js/01rl3tjgz7wq50rth1bmgy76zj/safe-standard.js?ps_h=SMPP&ps_t="+new Date().getTime()+"&online-image=https%3A//<?php echo $domain; ?>/images/livechat1.png&offline-image=https%3A//<?php echo $domain; ?>/images/livechat2.png";setTimeout("seSMPP.src=seSMPPs;document.getElementById('sdSMPP').appendChild(seSMPP)",1)</script><noscript><div style="display:inline"><a href="https://www.providesupport.com?messenger=01rl3tjgz7wq50rth1bmgy76zj">Live Chat</a></div></noscript>
    <!-- END ProvideSupport.com Custom Images Chat Button Code -->
</span>

<footer>
    <div class="footer_payment">
        <div class="card">
            <p><img src="/images/card.jpg" usemap="#Card" /></p>
            <map name="Card" id="Card">
                <area target="_blank" shape="rect" coords="187,14,266,57" href="https://sealserver.trustkeeper.net/cert.php?customerId=y2cj3BufDhnnkhj5am2daSvaX2I8Ww&size=105x54&style=normal" />
            </map>
            <p class="bottom">Copyright © 2006-<?php echo date('Y'); ?> choies.com</p>
        </div>
    </div>
</footer>