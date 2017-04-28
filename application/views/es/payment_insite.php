<style> 
    #payment_wrap f14{ font-size:14px;}
    #payment_wrap f16{ font-size:16px;}
    #payment_wrap f18{ font-size:18px;}
    #payment_wrap .c_gray{ color:#CCC;}
    #payment_wrap .c_red{ color:#000;}
    #payment_wrap .c_black{ color:#333;}
    #payment_wrap .bold{ font-weight:bold;}
    #payment_wrap .line{ border:solid 1px #eee;}

    /* payment_wrap */
    #payment_wrap { font:12px/40px Verdana; color:#333; border:solid 1px #EEE; width:690px; -webkit-box-shadow: 0px 0px 25px #ddd;-moz-box-shadow: 0px 0px 25px #ddd; box-shadow: 0px 0px 25px #ddd; background:#fff;}
    #payment_wrap .payment_h1 { border-bottom:solid 1px #EEE; padding-left:20px; background:#f8f8f8; font: bold 14px/40px Arial; }
    #payment_wrap .payment_p { padding:20px; }
    #payment_wrap .payment_p em { color:#F00; margin-right:5px; }
    #payment_wrap .payment_ul { list-style:none; padding:0; margin:0; }
    #payment_wrap .payment_ul li { width:80px; height:35px; float:left; margin-right:10px;}
    #payment_wrap .payment_ul li.visa { background-position:0 0; }
    #payment_wrap .payment_ul li.master { background-position:-90px 0; }
    #payment_wrap .payment_ul li.jcb { background-position:-180px 0; }
    #payment_wrap .payment_td_right { text-align:right; padding-right:10px; width:180px; white-space: nowrap;}
    #payment_wrap .payment_td_right2 { text-align:right; padding-right:10px; width:220px; white-space: nowrap;}
    #payment_wrap .payment_td_right3 { text-align:right; padding-right:10px; width:240px; white-space: nowrap;}
    #payment_wrap .payment_td_right4 { text-align:right; padding-right:10px; width:200px; white-space: nowrap;}

    #payment_wrap .payment_td_height { line-height:20px; height:20px; }

    #payment_wrap .payment_message{ border:solid 1px #eee; padding:10px 30px; margin-bottom:10px; color:#999; line-height:20px;}
    #payment_wrap .card_num{ position:relative;}
    #payment_wrap .card_num_box{ width:240px; background:#f8f8f8; border: solid 1px #eee; font:18px/40px "微软雅黑"; color:#999; padding:0 10px; position:absolute; bottom:38px; display:none; left:0px; }

    /* payment_input */
    #payment_wrap .ui_input { font:12px/25px Verdana; height:25px; color:#666; padding:0 0 0 5px; border:solid 1px #ccc; background:#fefefe; outline:none; margin:5px 10px 5px 0; }
    #payment_wrap .ui_input:hover { background:#fff; }
    #payment_wrap .ui_input:focus { background:#fff; border:solid 1px #ccc; -webkit-box-shadow: 0px 0px 5px #eee; -moz-box-shadow: 0px 0px 5px #eee; box-shadow: 0px 0px 5px #eee; }
    /* payment_button */
    #payment_wrap .button { display: inline-block; zoom: 1; vertical-align: baseline; margin-right:5px; cursor: pointer; text-align: center; text-decoration: none; font: bold 14px/20px Arial, Helvetica, sans-serif; padding: .5em 2em .55em; *padding: .4em 1em; text-shadow: 0 1px 1px rgba(0, 0, 0, .3); -webkit-border-radius: .5em; -moz-border-radius: .5em; border-radius: .5em; }
    #payment_wrap .orange { color: #FEF4E9; border: solid 1px #F47A20; background: #F78D1D; background: -webkit-gradient(linear, left top, left bottom, from(#FAA51A), to(#F47A20)); background: -moz-linear-gradient(top, #FAA51A, #F47A20); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#faa51a', endColorstr='#f47a20');
    }
    #payment_wrap .orange:hover { background: #F47C20; background: -webkit-gradient(linear, left top, left bottom, from(#F88E11), to(#F06015)); background: -moz-linear-gradient(top, #F88E11, #F06015); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f88e11', endColorstr='#f06015');
    }
    #payment_wrap .white { color: #606060; border: solid 1px #B7B7B7; background: white; background: -webkit-gradient(linear, left top, left bottom, from(white), to(#EDEDED)); background: -moz-linear-gradient(top, white, #EDEDED); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#ededed');
    }
    #payment_wrap .white:hover { background: #EDEDED; background: -webkit-gradient(linear, left top, left bottom, from(white), to(gainsboro)); background: -moz-linear-gradient(top, white, gainsboro); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#dcdcdc');
    }
    /* payment_icon_box */
    #payment_wrap .payment_icon{ width:13px; height:13px; background:url(/images/notice_ico.jpg) no-repeat 0 0; display:block; cursor:pointer; position:relative; }
    #payment_wrap .payment_icon_box{ width:400px; padding:10px; border:solid 1px #eee; -webkit-box-shadow: 0px 0px 10px #eee; -moz-box-shadow: 0px 0px 10px #eee; box-shadow: 0px 0px 10px #eee; background:#FFF; position:absolute; left:0px; bottom:20px; display:none;}
    #payment_wrap .payment_icon_box_txt{ width:260px; font:10px/15px Verdana; float:left;}
    #payment_wrap .payment_icon_box_pic{ width:140px; height:80px; background:url(/images/payment_p_logo_en.jpg) no-repeat 0 0px; float:left }
    #payment_wrap .payment_icon_box_close{ width:13px; height:13px; background:url(/images/payment_p_logo_en.jpg) no-repeat -290px 0; }

    /* payment_icon_box */
    #payment_wrap .payment_icon_en{ width:13px; height:13px; background:url(/images/notice_ico.jpg) no-repeat 0 0; display:block; cursor:pointer; position:relative; }
    #payment_wrap .payment_icon_box_en{ width:140px; padding:10px; border:solid 1px #eee; -webkit-box-shadow: 0px 0px 10px #eee; -moz-box-shadow: 0px 0px 10px #eee; box-shadow: 0px 0px 10px #eee; background:#FFF; position:absolute; left:0px; bottom:20px; display:none;}
    #payment_wrap .payment_icon_box_txt_en{ font:12px/25px Verdana;}
    #payment_wrap .payment_icon_box_pic_en{ width:140px; height:61px; background:url(/images/payment_p_logo_en.jpg) no-repeat 0 0px; }

    /* payment_wrap2 */
    #payment_wrap2 { font:12px/40px Verdana; color:#333; border:solid 1px #EEE; width:700px; margin:20px auto; -webkit-box-shadow: 0px 0px 25px #ddd;-moz-box-shadow: 0px 0px 25px #ddd; box-shadow: 0px 0px 25px #ddd; background:#fff; position:absolute; top:50px; left:50%; margin-left:-350px; display:none;
                     z-index:3;}
    #payment_wrap2 ol{ margin:0; padding:0;}
    #payment_wrap2 a{ color:#F90; text-decoration:none;}
    #payment_wrap2 a:hover{ color:#F90; text-decoration:underline;}
    #payment_wrap2 .payment_h1 { border-bottom:solid 1px #EEE; padding-left:20px; background:#f8f8f8; font: bold 14px/40px Arial; }
    #payment_wrap2 .payment_p { color:#999; line-height:25px; padding:20px; }
    #payment_wrap2 .payment_p img { float:left; margin-right:20px;}
    #payment_wrap2 .btn_center{ margin-left:280px;}
    #payment_wrap2 .payment_icon_box_close{ width:18px; height:18px; background:url(/images/payment_p_logo.jpg) no-repeat -310px 0; position:absolute; right:10px; top:10px; cursor:pointer; }
    #payment_wrap2 .payment_icon_box_close:hover{ opacity:0.8;}
    #payment_wrap2 .payment_p_btn{ width:100px; margin:10px auto 0;}

    /* payment_wrap3 */
    #payment_wrap3 { font:12px/40px Verdana; color:#333; border:solid 1px #EEE; width:700px; margin:20px auto; -webkit-box-shadow: 0px 0px 25px #ddd;-moz-box-shadow: 0px 0px 25px #ddd; box-shadow: 0px 0px 25px #ddd; background:#fff; position:absolute; top:50px; left:50%; margin-left:-350px; display:none;
                     z-index:3;}
    #payment_wrap3 ol{ margin:0; padding:0;}
    #payment_wrap3 a{ color:#F90; text-decoration:none;}
    #payment_wrap3 a:hover{ color:#F90; text-decoration:underline;}
    #payment_wrap3 .payment_h1 { border-bottom:solid 1px #EEE; padding-left:20px; background:#f8f8f8; font: bold 14px/40px Arial; }
    #payment_wrap3 .payment_p { color:#999; line-height:25px; padding:20px; }
    #payment_wrap3 .payment_p img { float:left; margin-right:20px;}
    #payment_wrap3 .btn_center{ margin-left:280px;}
    #payment_wrap3 .payment_icon_box_close{ width:18px; height:18px; background:url(/images/payment_p_logo.jpg) no-repeat -310px 0; position:absolute; right:10px; top:10px; cursor:pointer; }
    #payment_wrap3 .payment_icon_box_close:hover{ opacity:0.8;}
    #payment_wrap3 .payment_p_btn{ width:100px; margin:10px auto 0;}

    /* payment_button */
    .ui_btn_orange { 
        display: inline-block; zoom: 1; vertical-align: baseline; margin-left: 45px; margin-right:5px; cursor: pointer; text-align: center; text-decoration: none; font: bold 14px/20px Arial, Helvetica, sans-serif; padding: .5em 2em .55em; *padding: .4em 1em; text-shadow: 0 1px 1px rgba(0, 0, 0, .3); -webkit-border-radius: .5em; -moz-border-radius: .5em; border-radius: .5em;
        color: #FEF4E9; border: solid 1px #F47A20; background: #F78D1D; background: -webkit-gradient(linear, left top, left bottom, from(#FAA51A), to(#F47A20)); background: -moz-linear-gradient(top, #FAA51A, #F47A20); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#faa51a', endColorstr='#f47a20'); margin-right:40px;
    }
    .ui_btn_orange:hover { background: #F47C20; background: -webkit-gradient(linear, left top, left bottom, from(#F88E11), to(#F06015)); background: -moz-linear-gradient(top, #F88E11, #F06015); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f88e11', endColorstr='#f06015');
    }
    .ui_btn_white { display: inline-block; zoom: 1; vertical-align: baseline; margin-right:5px; cursor: pointer; text-align: center; text-decoration: none; font: bold 14px/20px Arial, Helvetica, sans-serif; -webkit-border-radius: .5em; -moz-border-radius: .5em; border-radius: .5em;
                    padding:2px 5px; color: #999; border: solid 1px #ccc; background: white; cursor:pointer; background: -webkit-gradient(linear, left top, left bottom, from(white), to(#EDEDED)); background: -moz-linear-gradient(top, white, #EDEDED); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#ededed');}
    .ui_btn_white:hover { background: #EDEDED;}

    #pageOverlay { visibility:hidden; position:fixed; top:0; left:0; z-index:2; width:100%; height:100%; background:#000; filter:alpha(opacity=70); opacity:0.7; }
    * html #pageOverlay { position: absolute; left: expression(documentElement.scrollLeft + documentElement.clientWidth - this.offsetWidth); top: expression(documentElement.scrollTop + documentElement.clientHeight - this.offsetHeight); }

    #popup_container {
        font-family: Arial, sans-serif;
        font-size: 12px;
        min-width: 300px; /* Dialog will be no smaller than this */
        max-width: 600px; /* Dialog will wrap after this width */
        background: #FFF;
        border: solid 5px #999;
        color: #000;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
    }

    #popup_title {
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        line-height: 1.75em;
        color: #666;
        background: #CCC url(/images/title.gif) top repeat-x;
        border: solid 1px #FFF;
        border-bottom: solid 1px #999;
        cursor: default;
        padding: 0em;
        margin: 0em;
    }

    #popup_content {
        background: 16px 16px no-repeat url(/images/info.gif);
        padding: 1em 1.75em;
        margin: 0em;
    }

    #popup_content.alert {
        background-image: url(/images/info.gif);
    }

    #popup_content.confirm {
        background-image: url(/images/important.gif);
    }

    #popup_content.prompt {
        background-image: url(/images/help.gif);
    }

    #popup_message {
        padding-left: 48px;
    }

    #popup_panel {
        text-align: center;
        margin: 1em 0em 0em 1em;
    }

    #popup_prompt {
        margin: .5em 0em;
    }

    #popup_ok {
        padding: 2px 8px;
        border: 1px solid #999;
        background: #CCC url(/images/title.gif) top repeat-x;
    }
    .payment_message_p{
        line-height: 16px;font-size: 11px;padding-bottom: 15px;padding-top: 10px;color: #666;padding-left: 30px;
    }
</style>
<script src="//cdn.optimizely.com/js/557241246.js"></script>
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
                    <div>
                        <div id="payment_wrap">
                            <div class="payment_h1">Pago de Tarjeta de Crédito</div>
                            <div class="payment_p">
                                <div class="payment_message">
                                    Importe del Pedido: 
                                    <span class="c_red f16 bold">
                                        <?php echo round($order['amount'], 2) . ' ' . $order['currency']; ?>
                                    </span>
                                    <span class="c_gray">|</span> 
                                    Numero de Pedido:<span class="c_red f16 bold"><?php echo $order['ordernum']; ?></span>
                                </div>
                                <p class="payment_message_p">Aceptamos las tarjetas de crédito/ débito siguientes .No deje hasta que vuelva el resultado del pago.<br>(Nota: Por motivos de seguridad, no vamos a guardar ninguno de sus datos de tarjeta de crédito.)</p>
                                <form action="" id="sendFrm" name="send" method="post" autocomplete="off" onsubmit="return checkFormData();">          
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td class="payment_td_right">Aceptamos:</td>
                                                <td width="300">
                                                    <ul class="payment_ul">
                                                        <li style="background-position:0 0;"><label for="cardType1"><img src="/images/visa.jpg" alt="Visa"></label></li>
                                                        <script>
                                                            cartypes[4] = "VISA";
                                                        </script>

                                                        <li style="background-position:-90 0;"><label for="cardType2"><img src="/images/master.jpg" alt="MasterCard"></label></li>
                                                        <script>
                                                            cartypes[5] = "MASTER";
                                                        </script>

                                                    </ul>
                                                </td>
                                                <td class="c_red">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td class="payment_td_right"><em>*</em>Numero de Tarjeta:</td>
                                                <td><div class="card_num">
                                                        <input type="text" class="ui_input" style="width:275px; " maxlength="16" name="cardNo" id="cardNo" onkeydown="showcardnum();" onkeyup="clean();">
                                                        <div class="card_num_box" id="card_num_box">
                                                        </div>      
                                                    </div></td>
                                                <td class="c_red">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td class="payment_td_right"><em>*</em>Fecha de Vencimiento:</td>
                                                <td><select name="cardExpireMonth" class="ui_input" id="cardExpireMonth" style="width:100px;">
                                                        <option value="0"> Mes </option>
                                                        <option value="01"> 01 </option>
                                                        <option value="02"> 02 </option>
                                                        <option value="03"> 03 </option>
                                                        <option value="04"> 04 </option>
                                                        <option value="05"> 05 </option>
                                                        <option value="06"> 06 </option>
                                                        <option value="07"> 07 </option>
                                                        <option value="08"> 08 </option>
                                                        <option value="09"> 09 </option>
                                                        <option value="10"> 10 </option>
                                                        <option value="11"> 11 </option>
                                                        <option value="12"> 12 </option>
                                                    </select>
                                                    <select name="cardExpireYear" class="ui_input" id="cardExpireYear" style="width:80px;">
                                                        <option value="0" selected="selected">Año</option>
                                                    <?php
                                                    $y = date('Y', strtotime('midnight - 1 year'));
                                                    for($i = 0;$i < 18;$i ++)
                                                    {
                                                    ?>
                                                        <option value="<?php echo $y + $i; ?>"> <?php echo $y + $i; ?> </option>
                                                    <?php
                                                    }
                                                    ?>
                                                    </select></td>
                                                <td class="c_red">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td class="payment_td_right"><em>*</em>CVV2 Código:</td>    
                                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tbody><tr>
                                                                <td width="80"><input type="password" maxlength="3" class="ui_input" style="width:60px;" id="cvv2" name="cardSecurityCode"></td>        


                                                                <td><div class="payment_icon_en">
                                                                        <div class="payment_icon_box_en">
                                                                            <div class="payment_icon_box_txt_en">¿Que es CVV2?</div>
                                                                            <div class="payment_icon_box_pic_en"></div>
                                                                        </div>
                                                                    </div></td>



                                                            </tr>
                                                        </tbody></table></td>
                                                <td class="c_red">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td width="500" style="text-align: center;padding-top: 8px;">
                                                    <input type="submit" value="PAGAR AHORA" id="paybutton" name="paybutton" class="ui_btn_orange jq_btn01"></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                </td>       
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <div id="payment_wrap2" class="jq_btn01" style="width: 400px; margin-left: -200px; box-shadow: rgb(221, 221, 221) 0px 0px 25px; top: 179px; display: none; background: rgb(255, 255, 255);">
                        <div class="payment_icon_box_close jq_close01" id="jq_close02"></div>
                            <div class="payment_h1">Cargando</div>
                            <div class="payment_p"><img id="loadingImg" src="/images/gb_loading.gif" width="100" height="68" alt="">  
                            <div style=" line-height:68px;">Cargando, espere un momento!</div>
                            </div>
                        </div>
                        <div id="pageOverlay" style="visibility: hidden;"></div>
                    </div>
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
                            <li class="fwb"><i>Seguridad de pago adicional con:</i><img src="/images/card11.jpg"></li>
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

<div id="payment_wrap2" class="jq_btn01" style="width: 400px; margin-left: -200px; box-shadow: rgb(221, 221, 221) 0px 0px 25px; top: 179px; background: rgb(255, 255, 255);">
<div class="payment_icon_box_close jq_close01" id="jq_close02"></div>
  <div class="payment_h1">Loading</div>
  <div class="payment_p"><img id="loadingImg" src="/images/loading.gif" width="100" height="68" alt="">  
  <div style=" line-height:68px;">Loading, please wait for a moment!</div>
  </div>
</div>
<div id="pageOverlay"></div>
<script type="text/javascript">
        $("#starttime").val("2014-08-21 18:54:35.748");
        $("#endtime").val("2014-08-21 18:54:35.751");
        pageInfo(path, tradeNo, $("#starttime").val() , $("#endtime").val(), 1);    
</script>
<embed src="https://device.maxmind.com/flash/Device.swf" allowscriptaccess="always" width="1" height="1">
<div id="popup_overlay" style="display:none;position: absolute; z-index: 99998; top: 0px; left: 0px; width: 100%; overflow-y: hidden; height: 413px; opacity: 0.01; background: rgb(255, 255, 255);"></div>
<div id="popup_container" style="display:none;position: absolute; z-index: 99999; padding: 0px; overflow-y: hidden; margin: 0px; min-width: 310px; max-width: 310px; top: 240px; left: 300px;" class="ui-draggable">
    <h1 id="popup_title" style="cursor: move;">Error</h1>
    <div id="popup_content" class="alert">
        <div id="popup_message">El numero de tarjeta de crédito es incorrecto</div>
        <div id="popup_panel">
        <input type="button" value="&nbsp;OK&nbsp;" id="popup_ok" onclick="$('#popup_container, #popup_overlay').hide();">
        </div>
    </div>
</div>

<script type="text/javascript">  
    $(function(){  
        var bool=false;  
        var offsetX=0;  
        var offsetY=0;  
        $("#popup_title").mousedown(function(){  
                bool=true;  
                offsetX = event.offsetX;  
                offsetY = event.offsetY;
                $(this).css('cursor','move');  
                })  
                .mouseup(function(){  
                bool=false;  
                })  
                $(document).mousemove(function(e){  
                if(!bool)  
                return;  
                var x = event.clientX-offsetX;  
                var y = event.clientY-offsetY;  
                $("#popup_container").css("left", x);  
                $("#popup_container").css("top", y);  
        })  
    })
</script> 

<script type="text/javascript">
    $( function(){
    $(".payment_icon").mouseover(function(){
       $(".payment_icon_box").fadeIn(200);
    });
    $(".payment_icon").mouseout(function(){
       $(".payment_icon_box").hide();
    });
    
    $(".payment_icon_en").mouseover(function(){
           $(".payment_icon_box_en").fadeIn(200);
        });
        $(".payment_icon_en").mouseout(function(){
           $(".payment_icon_box_en").hide();
        });
    
    /*
    $(".jq_btn01").click(function(){
       $(".jq_box01").fadeIn(200);
    });
    $(".jq_close01").click(function(){
       $(".jq_box01").hide();
    }); */
            
    $("#cardNo").keydown(function(){
        showcardnum(event.keyCode); 
    });
    $("#cardNo").keyup(function(){
        this.value=this.value.replace(/\D/g,'');
        clean(event.keyCode);
    });
    $("#cardNo").blur(function(){
        if(window.XMLHttpRequest)document.getElementById('card_num_box').style.display = "none";
        $(".card_num_box").css({ display: "none" });
    });

});
var num='';
var lastnum='';

// check cardNo, cardExpireMonth, cardExpireYear, CVV2 Code
function checkFormData()
{
    $popup_message = document.getElementById('popup_message');
    $popup_overlay = document.getElementById('popup_overlay');
    $popup_container = document.getElementById('popup_container');

    var cardNo = document.getElementById('cardNo').value;
    if(cardNo.length == 0)
    {
        $popup_message.innerHTML = 'El numero de tarjeta de crédito es incorrecto';
        $popup_overlay.style.display = 'block';
        $popup_container.style.display = 'block';
        return false;
    }
    var check = luhnCheckSum(cardNo);
    if(!check)
    {
        $popup_message.innerHTML = 'El numero de tarjeta de crédito es incorrecto';
        $popup_overlay.style.display = 'block';
        $popup_container.style.display = 'block';
        return false;
    }
    else
    {
        var month = document.getElementById("cardExpireMonth").value;
        if(month == 0)
        {
            $popup_message.innerHTML = 'El mes de la fecha de vencimiento es incorrecto';
            $popup_overlay.style.display = 'block';
            $popup_container.style.display = 'block';
            return false;
        }
        else
        {
            var year = document.getElementById("cardExpireYear").value;
            if(year == 0)
            {
                $popup_message.innerHTML = 'El mes de la fecha de vencimiento es incorrecto';
                $popup_overlay.style.display = 'block';
                $popup_container.style.display = 'block';
                return false;
            }
            else
            {
                var cvv2 = document.getElementById("cvv2").value;
                if(cvv2.length != 3)
                {
                    $popup_message.innerHTML = 'Por favor introduzca un 3-dígito CVV2 código';
                    $popup_overlay.style.display = 'block';
                    $popup_container.style.display = 'block';
                    return false;
                }
                else
                {
                    document.getElementById("payment_wrap2").style.display = "block";
                    document.getElementById("pageOverlay").style.visibility = "visible";
                }
            }
        }
        
    }
}

function luhnCheckSum(cardNumber){
    var sum=0;
    var digit=0;
    var addend=0;
    var timesTwo=false;
     
    for(var i=cardNumber.length-1;i>=0;i--){
        digit=parseInt(cardNumber.charAt(i));
        if(timesTwo){
            addend = digit * 2;
            if (addend > 9) {
                addend -= 9;
            }  
        }else{
            addend = digit;
        }
        sum += addend;
        timesTwo=!timesTwo;
    }
    return sum%10==0;
}

function showcardnum(keycode)
{
if(window.XMLHttpRequest)document.getElementById('card_num_box').style.display = "block";
    if(parseInt($("#cardNo").val().length + 1) >= 17)
    {
        return false;
    }
    if(parseInt(keycode) >=96 && parseInt(keycode) <=105)
    {
        $(".card_num_box").css({ display: "block" });
        num+=lastnum;
        newnum=num.replace(/\s/g,'').replace(/(\d{4})(?=\d)/g,"$1-");
         $(".card_num_box").html(newnum);
    }
    else if(parseInt(keycode) >=48 && parseInt(keycode) <=57)
    {
        $(".card_num_box").css({ display: "block" });
        num+=lastnum;
        newnum=num.replace(/\s/g,'').replace(/(\d{4})(?=\d)/g,"$1-");
         $(".card_num_box").html(newnum);
    }
    else
    {
        return false;
    }
    
}
function clean(keycode)
{
    num=$("#cardNo").val();
    newnum=$("#cardNo").val().replace(/\s/g,'').replace(/(\d{4})(?=\d)/g,"$1-");
     $(".card_num_box").html(newnum);
     if($("#cardNo").val().length == '0')
     {
        $(".card_num_box").css({ display: "none" }); 
    }
}
//keep out
(function(){
    // get object
    var $ = function (id){
        return document.getElementById(id);
    };
    // traverse
    var each = function(a, b) {
        for (var i = 0, len = a.length; i < len; i++) b(a[i], i);
    };
    // event binding
    var bind = function (obj, type, fn) {
        if (obj.attachEvent) {
            obj['e' + type + fn] = fn;
            obj[type + fn] = function(){obj['e' + type + fn](window.event);}
            obj.attachEvent('on' + type, obj[type + fn]);
        } else {
            obj.addEventListener(type, fn, false);
        };
    };
    
    // remove event
    var unbind = function (obj, type, fn) {
        if (obj.detachEvent) {
            try {
                obj.detachEvent('on' + type, obj[type + fn]);
                obj[type + fn] = null;
            } catch(_) {};
        } else {
            obj.removeEventListener(type, fn, false);
        };
    };
    
    // prevent brower default action
    var stopDefault = function(e){
        e.preventDefault ? e.preventDefault() : e.returnValue = false;
    };
    // get page scroll bar position
    var getPage = function(){
        var dd = document.documentElement,
            db = document.body;
        return {
            left: Math.max(dd.scrollLeft, db.scrollLeft),
            top: Math.max(dd.scrollTop, db.scrollTop)
        };
    };
    
    // lock screen
    var lock = {
        show: function(){
            $('pageOverlay').style.visibility = 'visible';
            var p = getPage(),
                left = p.left,
                top = p.top;
            
            // page mouse operation limit
            this.mouse = function(evt){
                var e = evt || window.event;
                stopDefault(e);
                scroll(left, top);
            };
            each(['DOMMouseScroll', 'mousewheel', 'scroll', 'contextmenu'], function(o, i) {
                    bind(document, o, lock.mouse);
            });
            // shield special key: F5, Ctrl + R, Ctrl + A, Tab, Up, Down
            this.key = function(evt){
                var e = evt || window.event,
                    key = e.keyCode;
                if((key == 116) || (e.ctrlKey && key == 82) || (e.ctrlKey && key == 65) || (key == 9) || (key == 38) || (key == 40)) {
                    try{
                        e.keyCode = 0;
                    }catch(_){};
                    stopDefault(e);
                };
            };
            bind(document, 'keydown', lock.key);
        },
        close: function(){
            $('pageOverlay').style.visibility = 'hidden';
            each(['DOMMouseScroll', 'mousewheel', 'scroll', 'contextmenu'], function(o, i) {
                unbind(document, o, lock.mouse);
            });
            unbind(document, 'keydown', lock.key);
        }
    };
    bind(window, 'load', function(){
        /*$(".jq_close01")onclick = function(){
           $(".jq_box01").hide();
           lock.close(); 
        };
        $('paybutton').onclick = function(){
            lock.show();
        };
        $('jq_close01').onclick = function(){
             lock.close(); 
        };
        $('jq_close02').onclick = function(){
             lock.close(); 
        };
        jq_close01*/
    });
})();

function lockpage() {
    
    // get object
    var $ = function (id){
        return document.getElementById(id);
    };
    // traverse
    var each = function(a, b) {
        for (var i = 0, len = a.length; i < len; i++) b(a[i], i);
    };
    // event binding
    var bind = function (obj, type, fn) {
        if (obj.attachEvent) {
            obj['e' + type + fn] = fn;
            obj[type + fn] = function(){obj['e' + type + fn](window.event);}
            obj.attachEvent('on' + type, obj[type + fn]);
        } else {
            obj.addEventListener(type, fn, false);
        };
    };
    
    // remove event
    var unbind = function (obj, type, fn) {
        if (obj.detachEvent) {
            try {
                obj.detachEvent('on' + type, obj[type + fn]);
                obj[type + fn] = null;
            } catch(_) {};
        } else {
            obj.removeEventListener(type, fn, false);
        };
    };
    
    // prevent brower default action
    var stopDefault = function(e){
        e.preventDefault ? e.preventDefault() : e.returnValue = false;
    };
    // get page scroll bar position
    var getPage = function(){
        var dd = document.documentElement,
            db = document.body;
        return {
            left: Math.max(dd.scrollLeft, db.scrollLeft),
            top: Math.max(dd.scrollTop, db.scrollTop)
        };
    };
    
    // lock screen
    var lock = {
        show: function(){
            $('pageOverlay').style.visibility = 'visible';
            var p = getPage(),
                left = p.left,
                top = p.top;
            
            // page mouse operation limit
            this.mouse = function(evt){
                var e = evt || window.event;
                stopDefault(e);
                scroll(left, top);
            };
            each(['DOMMouseScroll', 'mousewheel', 'scroll', 'contextmenu'], function(o, i) {
                    bind(document, o, lock.mouse);
            });
            // shield special key: F5, Ctrl + R, Ctrl + A, Tab, Up, Down
            this.key = function(evt){
                var e = evt || window.event,
                    key = e.keyCode;
                if((key == 116) || (e.ctrlKey && key == 82) || (e.ctrlKey && key == 65) || (key == 9) || (key == 38) || (key == 40)) {
                    try{
                        e.keyCode = 0;
                    }catch(_){};
                    stopDefault(e);
                };
            };
            bind(document, 'keydown', lock.key);
        },
        close: function(){
            $('pageOverlay').style.visibility = 'hidden';
            each(['DOMMouseScroll', 'mousewheel', 'scroll', 'contextmenu'], function(o, i) {
                unbind(document, o, lock.mouse);
            });
            unbind(document, 'keydown', lock.key);
        }
    };
    lock.show();
}
</script>