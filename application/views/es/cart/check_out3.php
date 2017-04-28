<!-- <script src="//cdn.optimizely.com/js/557241246.js"></script> -->
<div class="cart_header">
    <div class="layout">
        <a href="<?php echo LANGPATH; ?>/" class="logo"><img src="/images/logo.png" /></a>
        <div class="cart_step">
            <h2><img src="/images/payment_step3.png" /></h2>
            <div class="cart_step_bottom">
                <span>Envío Y Entrega</span>
                <span>Confirmación Del Pago</span>
                <span class="on">Realizar El Pedido</span>
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
                    <h2 class="font24" style="font-size: 24px;font-weight: normal;margin-bottom: 35px;">PAGO</h2>
                    <div>
                        <dl id="loading" class="payment_box_dl">
                            <dt>Total de Pedido: <b><?php echo round($order['amount'], 2) . $order['currency']; ?></b>            <span>No.de Pedido:<b><?php echo $order['ordernum'] ?></b></span></dt>
                            <dd class="fix">
                                <span class="fll"><img src="/images/loading.gif" /></span>
                                <ul class="fll">
                                    <li>La página de pago está cargando, se tardará <b>3-5 segundos</b> o más.</li>
                                    <li>Por favor, no te vayas, porque se está procesando su petición.</li>
                                    <li>El artículo (s) que usted elija son selecciones calientes, y sólo reservado para un tiempo limitado. ¡No se lo pierda!</li>
                                </ul> 
                            </dd>
                            <dd class="last">Usted puede ponerse en contacto con nosotros en <a href="mailto:service_es@choies.com">service_es@choies.com</a></dd>
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
                        <h3>SU RESUMEN DE PEDIDO</h3>
                        <ul class="pro_con1">
                            <?php
                            $currency = Site::instance()->currencies($order['currency']);
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
                                        <p>Artículo: #<?php echo Product::instance($product['product_id'])->get('sku'); ?></p>
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
                                                $attribute = str_replace('Size', 'Talla', $attribute);
                                                echo $attribute . '<br>';
                                            endforeach;
                                            ?>
                                        </p> 
                                        <p>Cantidad: <?php echo $product['quantity']; ?></p>
                                    </div>
                                </li>
                                <?php
                            endforeach;
                            ?>
                        </ul>
                        <ul class="total">
                            <li class="font14"><label>Total Parcial: </label><span><?php echo $currency['code'] . round($order['amount_products'], 2); ?></span></li>     
                            <li><label>Envío Estimado: </label><span><?php echo $currency['code'] . round($order['amount_shipping'], 2); ?></span></li>
                            <?php
                            $amount_point = $order['points'] / 100;
                            if ($order['amount_coupon'] + $amount_point > 0):
                                ?>
                                <li><label>Pagar Con Copónes Y Puntos: </label><span><?php echo $currency['code']; ?><?php round($order['amount_coupon'] + $amount_point, 2); ?></span></li>
                                <?php
                            endif;
                            $saving = round($order['amount_products'] + $order['amount_shipping'] - $order['amount'], 2);
                            $item_saving = round($saving - $order['amount_coupon'] - $amount_point, 2);
                            if ($item_saving > 0):
                                ?>
                                <li><label>Item Ahorros: </label><span><?php echo $currency['code'] . round($item_saving, 2); ?></span></li> 
                                <?php
                            endif;
                            ?>
                            <li class="total_num font14"><label>Total: </label><span class="font18"><?php echo $currency['code'] . round($order['amount'], 2); ?></span></li>
                            <?php
                            if ($saving):
                                ?>
                                <li class="last red"><label>Ahorros: </label><span><?php echo $currency['code'] . round($saving, 2); ?></span></li>
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
                <area target="_blank" shape="rect" coords="187,14,266,57" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en" />
            </map>
            <p class="bottom">Copyright © 2006-<?php echo date('Y'); ?> choies.com</p>
        </div>
    </div>
</footer>