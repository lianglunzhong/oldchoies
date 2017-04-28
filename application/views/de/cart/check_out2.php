<div class="cart_header">
    <div class="layout">
        <a href="<?php echo LANGPATH; ?>/" class="logo"><img src="/images/logo.png" /></a>
        <div class="cart_step">
            <h2><img src="/images/payment_step2.png" /></h2>
            <div class="cart_step_bottom">
                <span>VERSAND & LIEFERUNG</span>
                <span class="on">ABRECHNUNG</span>
                <span>BEZAHLUNG</span>
            </div>
        </div>
        <a href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en" target="_blank"><img src="/images/card3.png" /></a>
    </div>
</div>
<div class="JS_popwincon2 popwincon popwincon_user hide">
    <a class="JS_close3 close_btn2"></a>
    <form action="<?php echo LANGPATH; ?>/cart/edit_shipping" method="post" class="form user_share_form user_form form2">
        <div class="shipping_methods">
            <ul class="fix">
                <?php
                $cart_shipping = !empty($cart['shipping']) ? $cart['shipping']['price'] : -1;
                // $site_shipping = kohana::config('sites.shipping_price');
                $default_shipping = 0;
                foreach ($site_shipping as $key => $price)
                {
                    if ($cart_shipping == -1)
                    {
                        if ($key == 1)
                        {
                            $default_shipping = $price['price'];
                        }
                    }
                    elseif ($price['price'] == $cart_shipping)
                    {
                        $default_shipping = $price['price'];
                    }
                    $name = str_replace(array('Working Day Shipping'), array('Arbeitstage Versand'), $price['name']);
                    ?>

                    <li>
                        <input type="radio" name="shipping_price" value="<?php echo $price['price']; ?>" id="radios<?php echo $key; ?>" class="radio" <?php if ($price['price'] == $default_shipping) echo 'checked'; ?> />
                        <label for="radios<?php echo $key; ?>"><?php echo $name . ' ( ' . Site::instance()->price($price['price'], 'code_view') . ' )'; ?></label>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <p><input type="submit" value="BESTÄTIGEN" class="btn30_14_black" /></p>
        </div>
    </form>
</div>
<section id="main">
    <div id="forgot_password">
        <?php
        $message = Message::get();
        echo $message;
        ?>
    </div>
    <!-- main begin -->
    <section class="layout fix">
        <section class="cart">
            <section class="shipping_delivery fix">
                <article class="shipping_delivery_left">
                    <h3>VERSAND INFORMATIONEN</h3>
                    <div class="information_con">
                        <?php
                        $has_address = (isset($cart['shipping_address']) AND !empty($cart['shipping_address'])) ? 1 : 0;
                        if ($has_address AND isset($cart['shipping']['price']))
                        {
                            $shipping_country = $cart['shipping_address']['shipping_country'];
                            foreach ($countries as $c)
                            {
                                if ($c['isocode'] == $shipping_country)
                                {
                                    $shipping_country = $c['name'];
                                    break;
                                }
                            }
                            ?>
                            <dl>
                                <dt>Lieferadressen   <a href="<?php echo LANGPATH; ?>/cart/shipping_billing" class="a_red <?php if(count($addresses) <= 1) echo 'JS_popwinbtn1'; ?>">Editieren</a></dt>
                                <dd class="fix"><label>Name:</label><span><?php echo $cart['shipping_address']['shipping_firstname'] . ' ' . $cart['shipping_address']['shipping_lastname']; ?></span></dd>
                                <dd class="fix"><label>Tel:</label><span><?php echo $cart['shipping_address']['shipping_phone']; ?></span></dd>
                                <dd class="fix"><label>Adresse:</label><span><?php echo $cart['shipping_address']['shipping_address'] . ' ' . $cart['shipping_address']['shipping_city'] . ', ' . $cart['shipping_address']['shipping_state'] . ' ' . $shipping_country . ' ' . $cart['shipping_address']['shipping_zip']; ?></span></dd>
                            </dl>
                            <dl>
                                <dt>Versandarten   <a href="#" class="a_red JS_popwinbtn2">Editieren</a></dt>
                                <dd>
                                    Versand:
                                    <?php
                                    // $cart_shipping = !empty($cart['shipping']) ? $cart['shipping']['price'] : -1;
                                    // $site_shipping = kohana::config('sites.shipping_price');
                                    foreach ($site_shipping as $price)
                                    {
                                        if ($price['price'] == $cart_shipping)
                                        {
                                            $name = str_replace(array('Working Day Shipping'), array('Arbeitstage Versand'), $price['name']);
                                            echo $name . ' ( ' . Site::instance()->price($price['price'], 'code_view') . ' )';
                                        }
                                    }
                                    ?>
                                </dd> 
                            </dl>
                            <?php
                        }
                        ?>
                    </div>
                    <div id="coupon_points"></div>
                    <div class="mb25">
                        <h3>GUTSCHEINE & PUNKTE</h3>
                        <div class="coupons_box">
                            <form action="<?php echo LANGPATH; ?>/cart/set_coupon" method="post" class="form">
                                <label class="left">
                                    GUSTSCHEIN CODE:<em class="icon_tips JS_shows_btn1">
                                        <span class="JS_shows1 icon_tipscon hide">
                                            Hinweis: 1. Das Produkt mit "% Rabatt" Ikone kann nicht mit Gutschein-Code kombiniert werden.  
                                            <i>2. Bitte geben Sie den Gutschein-Code ohne Leerzeichen ein.</i>
                                        </span>
                                    </em>
                                </label>
                                <input type="text" value="" name="coupon_code" class="text codeInput" />
                                <input type="hidden" name="return_url" value="<?php echo LANGPATH; ?>/cart/check_out" />
                                <input type="submit" value="BEWERBEN" class="btn22_black mr10" />
                                <a class="J_pop_btn a_underline">Codeliste</a>
                            </form>
                            <?php
                            if ($cart['coupon']):
                                ?>
                                <div class="color666">
                                    Aktueller Gutschein Code:
                                    <span class="red"><?php echo $cart['coupon']; ?></span>
                                </div>
                                <?php
                            endif;
                            ?>
                            <!-- codelist_con -->
                            <div class="codelist_con J_popcon hide">
                                <span class="close_btn"></span>
                                <div class="tit"><h3>VERFÜGBARE CODES</h3></div>
                                <?php
                                if (count($codes) > 0):
                                    echo '<ul class="list_con">';
                                    foreach ($codes as $code):
                                        ?>
                                        <li><a href="#"><?php echo $code['code']; ?></a></li>
                                        <?php
                                    endforeach;
                                    echo '</ul>';
                                else:
                                    ?>
                                    <div class="codenone">Keine verfügbaren Codes.</div> 
                                <?php
                                endif;
                                ?>
                            </div>
                        </div>

                        <div class="coupons_box">
                            <form action="<?php echo LANGPATH; ?>/cart/point" method="post" class="form" id="point_form">
                                <label class="left">Choies Punkten:<em class="icon_tips JS_shows_btn1"><span class="JS_shows1 icon_tipscon hide">Sie können Punkte bis zu insgesamt 10% des Auftragswertes anwenden. Vervollständigen Sie Ihr Profil, werden Sie 500 Punkte erhalten, um Ihre erste Bestellung zu machen.</span></em></label>
                                <input type="hidden" name="shipping" value="1" />
                                <input type="hidden" name="return_url" value="<?php echo LANGPATH; ?>/cart/check_out" />
                                <?php
                                $is_celebrity = Customer::instance($customer_id)->is_celebrity();
                                ?>
                                <input type="text" id="point" value="<?php if (!$is_celebrity && $points_avail > 0) echo $points_avail; ?>" name="points" class="text text_short" onkeydown="return point2dollar();" />
                                <input type="submit" value="WECHSELN" class="btn22_black mr10" onclick="return point_redeem();" />
                                Sparen: <span class="red">$ <span  id="dollar">0</span></span> 
                                <div class="color666">
                                    (10 Punkte=$0.1)  
                                    <?php
                                    if ($points_avail >= 0):
                                        ?>
                                        <span class="red"><?php echo $points_avail; ?></span> Punkte können für diese Zeit verwendet werden.
                                        <?php
                                    else:
                                        echo 'Um Ihre Punkte zu verwenden, kaufen Sie bitte mindestens $10+ ein.';
                                    endif;
                                    ?>
                                    <a class="a_underline JS_popwinbtn">VIP Politik</a></div>
                            </form>
                            <script type="text/javascript">
                                var xhr = null;
                                var amount_left = $('#amount_left').text();
                                
                                function point_redeem()
                                {
                                    var points = parseFloat(document.getElementById('point').value);
                                    if (points > <?php print $points_avail; ?>) {
                                        window.alert('Nicht genug Punkte zur Verfügung stellen');
                                        return false;
                                    }
                                    else
                                    {
                                        $('#point_form').submit();
                                        return false;
                                    }
                                }
                                
                                function point2dollar()
                                {
                                    var point = document.getElementById('point');
                                    var dollar = document.getElementById('dollar');
                                    return window.setTimeout(function(){
                                        if (!point.value) {
                                            dollar.innerHTML = '0';
                                            $('#amount_left').text(tofloat(amount_left,2));
                                            $('#point_left').text('');
                                            return true;
                                        }
                                        
                                        if (xhr)
                                            xhr.abort();
                                        
                                        var point_left = tofloat(parseInt(point.value)*0.01, 2);
                                        var point_earned = parseInt(amount_left - parseInt(point.value)*0.01);
                                        $('#point_left').text(' - $'+point_left);
                                        if(point_earned >= 0)
                                        {
                                            $('#point_earned').text(point_earned);
                                        }
                                        dollar.innerHTML = point_left;
                                    }, 0);
                                }
                            </script>
                        </div>
                    </div>
                    <?php
                    if ($has_address AND isset($cart['shipping']['price'])):
                        ?>
                        <!-- payment -->
                        <h3>BEZAHLUNG</h3>
                        <form id="payment_form" method="post" action="" class="form form_box">
                            <dl class="shipping_payment">
                            <?php
                            // currency BRL,ARS,SAR Paypal hide
                            $no_paypal = 0;
                            $currencys = array('BRL', 'ARS', 'SAR');
                            $currency_now = Site::instance()->currency();
                            if(in_array($currency_now['name'], $currencys))
                                $no_paypal = 1;
                            if(!$no_paypal)
                            {
                            ?>
                                <dd class="shipping_methods">
                                  <input type="radio" value="PP" id="radio_2" class="radio" name="payment_method" checked="" />
                                  <label for="radio_2">
                                    <h4>PayPal</h4><br />
                                    <p>Wenn Sie kein PayPal-Konto haben, können Sie auch per PayPal mit Ihrer Kreditkarte oder EC-Karte bezahlen.</p>
                                    <img class="ml20" src="/images/card1.jpg" /></label>
                                    <p>Hinweis: Sie können auch Geld direkt an <strong> paypal@choies.com</strong> senden, wenn Ihre Zahlung ausfällt, dann benachrichtigen Sie uns bitte hier service_de@choies.com.</p>
                                </dd>
                            <?php
                            }
                            ?>
                                <dd class="shipping_methods">
                                  <input type="radio" value="GC" id="radio_1" class="radio" name="payment_method" <?php if($no_paypal) echo 'checked="checked"'; ?> />
                                  <label for="radio_1">
                                    <h4>Kredit- oder Debitkarte</h4><br />
                                    <p>Wir akzeptieren die folgenden Kreditkarten/Debitkarten. Bitte geben Sie zur nächsten Seite, um Ihre Zahlung zu beenden.</p>
                                    <img class="ml20" src="/images/card10.jpg" /></label>
                                </dd>
                                <?php
                                if(array_key_exists($cart['shipping_address']['shipping_country'], $sofort_countries))
                                {
                                ?>
                                <dd class="shipping_methods">
                                  <input type="radio" value="SOFORT" id="radio_3" class="radio" name="payment_method"/>
                                  <label for="radio_3">
                                    <img src="/images/card12.jpg" /></label>
                                </dd>
                                <?php
                                }
                                ?>
                                <?php
                                if($cart['shipping_address']['shipping_country'] == 'NL')
                                {
                                ?>
                                <dd class="shipping_methods">
                                  <input type="radio" value="IDEAL" id="radio_4" class="radio" name="payment_method"/>
                                  <label for="radio_4">
                                    <img src="/images/card13.jpg" /></label>
                                </dd>
                                <?php
                                }
                                ?>
                            </dl>
                                <p>
                                    <input type="submit" class="btn40_16_red" value="Jetzt bezahlen" />
                                </p>
                        </form>
                        <?php
                    endif;
                    ?>
                </article>

                <!-- order_summary -->
                <div class="order_summary flr">
                    <div class="cart_side">
                        <h3>Ihre Bestellung Details</h3>
                        <ul class="pro_con1">
                            <?php
                            $ecomm_prodid = array();
                            foreach ($cart['products'] as $key => $product):
                                $sku = Product::instance($product['id'])->get('sku');
                                $ecomm_prodid[] = "'$sku'";
                                $name = Product::instance($product['id'])->get('name');
                                $link = Product::instance($product['id'])->permalink();
                                $img = Product::instance($product['id'])->cover_image();
                                ?>
                                <li class="fix">
                                    <div class="left"><a href="<?php echo $link; ?>"><img src="<?php echo '/pimages1/' . $img['id'] . '/3.' . $img['suffix']; ?>" alt="<?php echo $name; ?>" /></a></div>
                                    <div class="right">
                                        <a href="<?php echo $link; ?>" class="name"><?php echo $name; ?></a>
                                        <p>Artikel: #<?php echo $sku; ?></p>
                                        <p><?php echo Site::instance()->price($product['price'], 'code_view'); ?></p>
                                        <p>
                                            <?php
                                            $delivery_time = kohana::config('prdress.delivery_time');
                                            if (isset($product['attributes'])):
                                                foreach ($product['attributes'] as $attribute => $option):
                                                    $attribute = str_replace('Size', 'Größe', $attribute);
                                                    if ($attribute == 'delivery time')
                                                        $option = $option > 0 ? 'Rush Order' . ' ( + ' . Site::instance()->price($option, 'code_view') . ' )' : 'Regular Order';
                                                    echo ucfirst($attribute) . ': ' . $option . '<br>';
                                                endforeach;
                                            endif;
                                            ?>
                                        </p> 
                                        <p>Anzahl.: <?php echo $product['quantity']; ?></p>
                                    </div>
                                </li>
                                <?php
                            endforeach;
                            if (!empty($cart['largesses'])):
                                foreach ($cart['largesses'] as $key => $product):
                                    $sku = Product::instance($product['id'])->get('sku');
                                    $ecomm_prodid[] = "'$sku'";
                                    $img = Product::instance($product['id'])->cover_image();
                                    ?>
                                    <li class="fix">
                                        <div class="left"><a href="<?php echo $link; ?>"><img src="<?php echo '/pimages1/' . $img['id'] . '/3.' . $img['suffix']; ?>" alt="<?php echo $name; ?>" /></a></div>
                                        <div class="right">
                                            <a href="<?php echo $link; ?>" class="name"><?php echo $name; ?></a>
                                            <p>Artikel: #<?php echo $sku; ?></p>
                                            <p><?php echo Site::instance()->price($product['price'], 'code_view'); ?></p>
                                            <p>
                                                <?php
                                                $delivery_time = kohana::config('prdress.delivery_time');
                                                if (isset($product['attributes'])):
                                                    foreach ($product['attributes'] as $attribute => $option):
                                                        $attribute = str_replace('Size', 'Größe', $attribute);
                                                        if ($attribute == 'delivery time')
                                                            $option = $option > 0 ? 'Rush Order' . ' ( + ' . Site::instance()->price($option, 'code_view') . ' )' : 'Regular Order';
                                                        echo ucfirst($attribute) . ': ' . $option . '<br>';
                                                    endforeach;
                                                endif;
                                                ?>
                                            </p> 
                                            <p>Anzahl.: <?php echo $product['quantity']; ?></p>
                                        </div>
                                    </li>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </ul>
                        <ul class="total">
                            <li class="font14"><label>Teilsumme: </label><span><?php echo Site::instance()->price($cart['amount']['items'], 'code_view'); ?></span></li>     
                            <li><label>Geschätzte Versandkosten: </label><span id="shipping_total"><?php echo $cart_shipping == -1 ? Site::instance()->price($site_shipping[1]['price'], 'code_view') : Site::instance()->price($cart_shipping, 'code_view'); ?></span></li>
                            <?php
                            if ($cart['amount']['coupon_save'] + $cart['amount']['point'] > 0):
                                ?>
                                <li><label>Gutscheine & Punkte: </label><span><?php echo Site::instance()->price($cart['amount']['coupon_save'] + $cart['amount']['point'], 'code_view'); ?></span></li>
                                <?php
                            endif;
                            $saving = $cart['amount']['items'] + $cart['amount']['shipping'] - $cart['amount']['total'];
                            $item_saving = round($saving - $cart['amount']['coupon_save'] - $cart['amount']['point'], 2);

                            if ($item_saving > 0):
                                ?>
                                <li><label>ARTIKEL Einsparungen:: </label><span><?php echo Site::instance()->price($item_saving, 'code_view'); ?></span></li> 
                                <?php
                            endif;
                            ?>
                            <li class="total_num font14">
                                <label>Gesamtbetrag: </label>
                                <b id="totalPrice" class="font18">
                                    <?php
                                    $total = $cart['amount']['shipping'] ? $cart['amount']['total'] : $cart['amount']['total'] + $default_shipping;
                                    echo Site::instance()->price($total, 'code_view');
                                    ?>
                                </b>
                            </li>
                            <?php
                            if ($saving):
                                ?>
                                <li class="last red"><label>Einsparungen: </label><span><?php echo Site::instance()->price($saving, 'code_view'); ?></span></li>
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
<div class="JS_popwincon1 popwincon popwincon_user hide">
    <a class="JS_close2 close_btn2"></a>
    <form action="<?php echo LANGPATH; ?>/cart/edit_address" method="post" class="form user_share_form user_form form1">
        <input type="hidden" name="shipping_address_id" value="<?php echo $cart['shipping_address']['shipping_address_id']; ?>" />
        <input type="hidden" name="return" value="<?php echo LANGPATH; ?>/cart/check_out" />
        <ul class="add_showcon_boxcon">
            <li>
                <label><span>*</span> Vorname:</label>
                <input type="text" value="<?php echo $cart['shipping_address']['shipping_firstname']; ?>" name="shipping_firstname" id="shipping_firstname" class="text text_long" />
            </li>
            <li>
                <label><span>*</span> Nachname:</label>
                <input type="text" value="<?php echo $cart['shipping_address']['shipping_lastname']; ?>" name="shipping_lastname" id="shipping_lastname" class="text text_long" />
            </li>
            <li>
                <label><span>*</span> Adresse:</label>
                <div>
                    <textarea class="textarea_long" name="shipping_address" id="shipping_address"><?php echo $cart['shipping_address']['shipping_address']; ?></textarea>
                </div>
            </li>
            <li>
                <label><span>*</span> Land:</label>
                <select name="shipping_country" class="select_style selected304" id="shipping_country" onchange="changeSelectLand2();$('#billing_country').val($(this).val());">
                    <option value="">EIN LAND WÄHLEN</option>
                    <?php foreach ($countries as $country): ?>
                        <option value="<?php echo $country['isocode']; ?>" <?php if ($cart['shipping_address']['shipping_country'] == $country['isocode']) echo 'selected'; ?> ><?php echo $country['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </li>
            <li class="states2">
                <?php
                $stateCalled = Kohana::config('state.called');
                foreach ($stateCalled as $name => $called)
                {
                     $called = str_replace(array('County', 'Province'), array('Bundesland', 'Provinz'), $called);
                    ?>
                    <div class="call2" id="call2_<?php echo $name; ?>" <?php if ($name != 'Default') echo 'style="display:none;"'; ?>>
                        <label for="state"><span>*</span> <font id=""><?php echo $called; ?></font>:</label>
                    </div>
                    <?php
                }
                $stateArr = Kohana::config('state.states');
                foreach ($stateArr as $country => $states)
                {
                    ?>
                    <div class="all2 JS_drop" id="all2_<?php echo $country; ?>" style="display:none;">
                        <select name="" class="select_style selected304 s_state" onblur="$('#billing_state1').val($(this).val());">
                            <option value="">[EIN STAAT WÄHLEN]</option>
                            <?php
                            foreach ($states as $coun => $state)
                            {
                                if (is_array($state))
                                {
                                    echo '<optgroup label="' . $coun . '">';
                                    foreach ($state as $s)
                                    {
                                        ?>
                                        <option value="<?php echo $s; ?>"><?php echo $s; ?></option>
                                        <?php
                                    }
                                    echo '</optgroup>';
                                }
                                else
                                {
                                    ?>
                                    <option value="<?php echo $state; ?>"><?php echo $state; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <?php
                }
                ?>
                <div class="" id="all2_default">
                    <input type="text" name="shipping_state" id="shipping_state" class="text text_long" value="<?php echo $cart['shipping_address']['shipping_state']; ?>" maxlength="320" />
                    <div class="errorInfo"></div>
                </div>
                <script>
                    function changeSelectLand2(){
                        var select = document.getElementById("shipping_country");
                        var countryCode = select.options[select.selectedIndex].value;
                        if(countryCode == 'BR')
                        {
                            $("#shipping_cpf").show();
                        }
                        else
                        {
                            $("#shipping_cpf").hide();
                        }
                        var c_name = 'call2_' + countryCode;
                        $(".states2 .call2").hide();
                        if(document.getElementById(c_name))
                        {
                            $(".states2 #"+c_name).show();
                        }
                        else
                        {
                            $(".states2 #call2_Default").show();
                        }
                        var s_name = 'all2_' + countryCode;
                        $(".states2 .all2").hide();
                        $(".states2 #all2_default input").hide();
                        if(document.getElementById(s_name))
                        {
                            $(".states2 #"+s_name).show();
                        }
                        else
                        {
                            $(".states2 #all2_default input").show();
                        }
                        $("#all2_default input").val('');
                    }
                    $(function(){
                        $(".states2 .all2 select").change(function(){
                            var val = $(this).val();
                            $("#all2_default input").val(val);
                        })
                    })
                </script>
            </li>
            <li>
                <label><span>*</span> Stadt / Ort:</label>
                <input type="text" value="<?php echo $cart['shipping_address']['shipping_city']; ?>" name="shipping_city" id="shipping_city" class="text text_long" />
            </li>
            <li>
                <label><span>*</span> PLZ:</label>
                <input type="text" value="<?php echo $cart['shipping_address']['shipping_zip']; ?>" name="shipping_zip" id="shipping_zip" class="text text_long" />
            </li>
            <li>
                <label><span>*</span> Telefon:</label>
                <input type="text" value="<?php echo $cart['shipping_address']['shipping_phone']; ?>" name="shipping_phone" id="shipping_phone" class="text text_long" />
            </li>
            <li id="shipping_cpf" class="hide">
                <label><span>*</span>o cadastro de pessoa Física:</label>
                <input type="text" name="shipping_cpf" id="shipping_cpf" class="text text_long" value="" />
            </li>
            <li>
                <label>&nbsp;</label>
                <div class="right_box"><input type="submit" value="SENDEN" class="btn30_14_black" /></div>
            </li>
        </ul>
    </form>
</div>
<div class="JS_popwincon popwincon hide">
    <a class="JS_close1 close_btn2"></a>
    <div class="vip">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th width="15%" class="first">
            <div class="r">Privilegien</div>
            <div>VIP Niveau</div>
            </th>
            <th width="20%">Kumulierte Transaktionsbetrag</th>
            <th width="16%">Zusätzliche Rabatte für Artikel</th>
            <th width="16%">Punkte-Verwenden Berechtigungen</th>
            <th width="15%">Bestellung-Punkte Belohnung</th>
            <th width="18%">Andere Vorrechte</th>
            </tr>
            <tr>
                <td><span class="icon_nonvip" title="Non-VIP"></span><strong>Nicht-VIP</strong></td>
                <td>$0</td>
                <td>/</td>
                <td rowspan="6"><div>Sie können Punkte bis zu insgesamt 10% des Auftragswertes anwenden.</div></td>
                <td rowspan="6">$1 = 1 Punkt</td>
                <td>15% Rabatte Code</td>
            </tr>
            <tr>
                <td><span class="icon_vip" title="VIP"></span><strong>VIP</strong></td>
                <td>$1 - $199</td>
                <td>/</td>
                <td rowspan="5"><div>Sie können Doppel Einkaufspunkte während der großen Ferien erhalten.<br />
                        Besondere Geburtstagsgeschenk.<br />
                        Und mehr...</div></td>
            </tr>
            <tr>
                <td><span class="icon_bronze" title="Bronze VIP"></span><strong>Bronze VIP</strong></td>
                <td>$199 - $399</td>
                <td>5% Rabatte</td>
            </tr>
            <tr>
                <td><span class="icon_silver" title="Silber VIP"></span><strong>Silber VIP</strong></td>
                <td>$399 - $599</td>
                <td>8% Rabatte</td>
            </tr>
            <tr>
                <td><span class="icon_gold" title="Gold VIP"></span><strong>Gold VIP</strong></td>
                <td>$599 - $1999</td>
                <td>10% Rabatte</td>
            </tr>
            <tr>
                <td><span class="icon_diamond" title="Diamant VIP"></span><strong>Diamant VIP</strong></td>
                <td>&ge; $1999</td>
                <td>15% Rabatte</td>
            </tr>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $(".adress_select").live('click', function(){
            var id = $(this).attr('title');
            $("#shipping_address_id").val(id);
        })
        
        $(".edit_address").live('click', function(){
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                url: "/address/ajax_data",
                dataType: "json",
                data: "id="+id,
                success: function(addresses){
                    if(addresses)
                    {
                        $("#e_address_id").val(addresses['id']);
                        $("#e_firstname").val(addresses['firstname']);
                        $("#e_lastname").val(addresses['lastname']);
                        $("#e_address").val(addresses['address']);
                        $("#e_country").val(addresses['country']);
                        $(".e_state").val(addresses['state']);
                        $("#e_state").val(addresses['state']);
                        $("#e_city").val(addresses['city']);
                        $("#e_zip").val(addresses['firstname']);
                        $("#e_phone").val(addresses['phone']);
                        if(addresses['country'] == "BR")
                        {
                            $("#e_cpf input").val(addresses['cpf']);
                            $("#e_cpf").show();
                        }
                        $(".states1 .all1").hide();
                        var s_name = 'all1_'+addresses['country'];
                        if(document.getElementById(s_name))
                        {
                            $(".states1 #"+s_name).show();
                        }
                        else
                        {
                            $("#all1_default").show();
                        }
                        $('html, body').animate({scrollTop: $('#edit_address').offset().top - 90}, 10); 
                    }
                }
            });
            return false;
        })
        
        $(".edit_address1").live('click', function(){
            $("#current_address").hide();
            $("#select_address").show();
        })
        
        $(".delete_address").live('click', function(){
            $('body').append('<div id="wingray1" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
            $('#cart_delete').appendTo('body').fadeIn(320);
            var id = $(this).attr('id');
            $("#address_id").val(id);
            $('#cart_delete').show();
            return false;
        })
        
        $("#cart_delete .clsbtn,#cart_delete .cancel,#wingray1").live("click",function(){
            $("#wingray1").remove();
            $('#cart_delete').fadeOut(160).appendTo('#tab2');
            return false;
        })
        
        $("#shipping_select li").live('click', function(){
            var price = $(this).attr('value');
            $("#shipping_price").val(price);
        })
        
        $("#edit_shipping").live('click', function(){
            $(".shipping_methods").show();
            $(".edit_shipping").hide();
            return false;
        })
        
        //coupon code
        $('.J_pop_btn').click(function(){
            $(this).parents().find('.J_popcon').slideDown();
        }),$(".close_btn").click(function(){
            $(this).parents().find('.J_popcon').hide();
        })
        
        $(".list_con a").click(function(){
            var code = $(this).html();
            $(".codeInput").val(code);
            $(".codelist_con").hide();
            return false;
        })
        
        //        $("#edit_coupon").live('click', function(){
        //            $("#coupon_list").show();
        //            $("#current_coupon").hide();
        //            return false;
        //        })

        $("#radio1, #radio2").live('click', function(){
            var val = $(this).attr('title');
            $("#payment_method").val(val);
            if(val == 'PP')
            {
                $("#payment_form").removeClass('form3');
            }
        })
        
        $("#radio_changeaddr1, #radio_changeaddr2").live('click', function(){
            var val = $(this).attr('value');
            $("#billing_method").val(val);
        })
        
        $("#radio_changeaddr1").live('click', function(){
            $("#billingAddress").hide();
            $("#payment_form").removeClass('form3');
        })
        $("#radio_changeaddr2").live('click', function(){
            $("#billingAddress").show();
            $("#payment_form").addClass('form3');
            $('html, body').animate({scrollTop: $('#billingAddress').offset().top}, 300);
            $("#billing_firstname").focus();
        })
    })
    
    //shipping price
    $(function(){
        $("#shipping_select li").click(function(){
            var price = $(this).attr('value');
            var code = "<?php
                $currency = Site::instance()->currency();
                echo $currency['code'];
                ?>";
                            var rate = <?php echo $currency['rate']; ?>;
                            var amount = <?php echo $cart['amount']['total'] - $cart['amount']['shipping']; ?>;
                            var shipping_price = tofloat(price * rate, 2);
                            shipping_price += " ";
                            var shipping_total = code + shipping_price;
                            var amount_total = code + tofloat((amount + parseInt(price)) * rate, 2);
                            $("#shipping_total").html(shipping_total);
                            $("#shipping_amount").val(price);
                            $("#totalPrice").html(amount_total);
                            $("#amount_left").html(tofloat((amount + parseInt(price)), 2));
                        })
                    })
    
                    /* form1 */
                    $(".form1").validate({
                        rules: {
                            shipping_firstname: {    
                                required: true,
                                maxlength:50
                            },
                            shipping_lastname: {    
                                required: true,
                                maxlength:50
                            },
                            shipping_address: {
                                required: true,
                                maxlength:200
                            },
                            shipping_zip: {
                                required: true,
                                maxlength:50
                            },
                            shipping_city: {
                                required: true,
                                maxlength:50
                            },
                            shipping_country: {
                                required: true,
                                maxlength:50
                            },
                            shipping_state: {
                                required: true,
                                maxlength:50
                            },
                            shipping_phone: {
                                required: true,
                                maxlength:50
                            }
                        },
                        messages: {
                            shipping_firstname: {
                                required: "Please enter your first name.",
                                maxlength:"The first name exceeds maximum length of 50 characters."
                            },
                            shipping_lastname: {
                                required: "Please enter your last name.",
                                maxlength:"The last name exceeds maximum length of 50 characters."
                            },
                            shipping_address: {
                                required: "Please enter your address.",
                                maxlength:"The address exceeds maximum length of 200 characters."
                            },
                            shipping_zip: {
                                required: "Please enter your zip.",
                                maxlength:"The post code exceeds maximum length of 50 characters."
                            },
                            shipping_city: {
                                required: "Please enter your city.",
                                maxlength:"The city exceeds maximum length of 50 characters."
                            },
                            shipping_country: {
                                required: "Please choose your country.",
                                maxlength:"The country exceeds maximum length of 50 characters."
                            },
                            shipping_state: {
                                required: "Please enter your County / Province / State.",
                                maxlength:"The country exceeds maximum length of 50 characters."
                            },
                            shipping_phone: {
                                required: "Please enter your phone.",
                                maxlength:"The phone number exceeds maximum length of 50 characters."
                            }
                        }
                    });
    
                    /* form2 */
                    $(".form2").validate({
                        rules: {
                            shipping_firstname: {    
                                required: true,
                                maxlength:50
                            },
                            shipping_lastname: {    
                                required: true,
                                maxlength:50
                            },
                            shipping_address: {
                                required: true,
                                maxlength:200
                            },
                            shipping_zip: {
                                required: true,
                                maxlength:50
                            },
                            shipping_city: {
                                required: true,
                                maxlength:50
                            },
                            shipping_country: {
                                required: true,
                                maxlength:50
                            },
                            shipping_state: {
                                required: true,
                                maxlength:50
                            },
                            shipping_phone: {
                                required: true,
                                maxlength:50
                            }
                        },
                        messages: {
                            shipping_firstname: {
                                required: "Please enter your first name.",
                                maxlength:"The first name exceeds maximum length of 50 characters."
                            },
                            shipping_lastname: {
                                required: "Please enter your last name.",
                                maxlength:"The last name exceeds maximum length of 50 characters."
                            },
                            shipping_address: {
                                required: "Please enter your address.",
                                maxlength:"The address exceeds maximum length of 200 characters."
                            },
                            shipping_zip: {
                                required: "Please enter your zip.",
                                maxlength:"The post code exceeds maximum length of 50 characters."
                            },
                            shipping_city: {
                                required: "Please enter your city.",
                                maxlength:"The city exceeds maximum length of 50 characters."
                            },
                            shipping_country: {
                                required: "Please choose your country.",
                                maxlength:"The country exceeds maximum length of 50 characters."
                            },
                            shipping_state: {
                                required: "Please enter your County / Province / State.",
                                maxlength:"The country exceeds maximum length of 50 characters."
                            },
                            shipping_phone: {
                                required: "Please enter your phone.",
                                maxlength:"The phone number exceeds maximum length of 50 characters."
                            }
                        }
                    });

                    /* form3 */
                    $(".form3").validate({
                        rules: {
                            billing_firstname: {    
                                required: true,
                                maxlength:50
                            },
                            billing_lastname: {    
                                required: true,
                                maxlength:50
                            },
                            billing_address: {
                                required: true,
                                maxlength:200
                            },
                            billing_zip: {
                                required: true,
                                maxlength:50
                            },
                            billing_city: {
                                required: true,
                                maxlength:50
                            },
                            billing_country: {
                                required: true,
                                maxlength:50
                            },
                            billing_state: {
                                required: true,
                                maxlength:50
                            },
                            billing_phone: {
                                required: true,
                                maxlength:50
                            }
                        },
                        messages: {
                            billing_firstname: {
                                required: "Please enter your first name.",
                                maxlength:"The first name exceeds maximum length of 50 characters."
                            },
                            billing_lastname: {
                                required: "Please enter your last name.",
                                maxlength:"The last name exceeds maximum length of 50 characters."
                            },
                            billing_address: {
                                required: "Please enter your address.",
                                maxlength:"The address exceeds maximum length of 200 characters."
                            },
                            billing_zip: {
                                required: "Please enter your zip.",
                                maxlength:"The post code exceeds maximum length of 50 characters."
                            },
                            billing_city: {
                                required: "Please enter your city.",
                                maxlength:"The city exceeds maximum length of 50 characters."
                            },
                            billing_country: {
                                required: "Please choose your country.",
                                maxlength:"The country exceeds maximum length of 50 characters."
                            },
                            billing_state: {
                                required: "Please enter your County / Province / State.",
                                maxlength:"The country exceeds maximum length of 50 characters."
                            },
                            billing_phone: {
                                required: "Please enter your phone.",
                                maxlength:"The phone number exceeds maximum length of 50 characters."
                            }
                        }
                    });

    
    
                    function tofloat(f,dec)       
                    {          
                        if(dec <0) return "Error:dec <0! ";          
                        result=parseInt(f)+(dec==0? " ": ".");          
                        f-=parseInt(f);          
                        if(f==0)
                        {
                            for(i=0;i <dec;i++) result+= '0';          
                        }
                        else       
                        {          
                            for(i=0;i <dec;i++)
                            {
                                f*=10;
                                if(parseInt(f) == 0)
                                {
                                    result+= '0';
                                }
                            }          
                            result+=parseInt(Math.round(f));
                        } 
                        return result;          
                    }
</script>

<!-- New Remarket Code -->
<script type="text/javascript">
    var google_tag_params = {
        ecomm_prodid: <?php echo count($ecomm_prodid) > 1 ? '[' . implode(',', $ecomm_prodid) . ']' : $ecomm_prodid[0]; ?>,
        ecomm_pagetype: 'purchase', 
        ecomm_totalvalue: '<?php echo $cart['amount']['items']; ?>'
    };
</script>
<script type="text/javascript">                                
    /* <![CDATA[ */
    var google_conversion_id = 983779940;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
</script>
<script type="text/javascript" src="www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
    <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/983779940/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- Facebook Conversion Code for Check out -->
<script type="text/javascript">
    var fb_param = {};
    fb_param.pixel_id = '6015191467430';
    fb_param.value = '<?php echo $total; ?>';
    fb_param.currency = 'USD';
    (function(){
        var fpw = document.createElement('script');
        fpw.async = true;
        fpw.src = '//connect.facebook.net/en_US/fp.js';
        var ref = document.getElementsByTagName('script')[0];
        ref.parentNode.insertBefore(fpw, ref);
    })();
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/offsite_event.php?id=6015191467430&amp;value=<?php echo $total; ?>&amp;currency=USD" /></noscript>

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

<script src="//cdn.optimizely.com/js/557241246.js"></script>