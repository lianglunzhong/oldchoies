<!--<script src="//cdn.optimizely.com/js/557241246.js"></script>-->
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
            <?php
            $has_address = isset($cart['shipping_address']) AND !empty($cart['shipping_address']) ? 1 : 0;
            if($has_address AND isset($cart['shipping']['price'])): 
                ?>
                <h2 class="cart_step"><img src="/images/payment_step2.jpg" /></h2>
            <?php else: ?>
                <h2 class="cart_step"><img src="/images/payment_step1.jpg" /></h2>
            <?php endif; ?>
            <section class="shipping_delivery fix">
                <article class="shipping_delivery_left">
                    <h3>ADRESSE DE LIVRAISON</h3>
                    <dl class="shipping_payment">
                        <dd id="select_address" <?php if ($has_address OR empty($addresses)) echo ' class="hide"'; ?>>
                            <em>Ihre persoenlichen Informationen werden auch von www.choies.com geschützt werden</em>
                            <ul class="addresses">
                                <?php
                                $default_key = 0;
                                if ($has_address)
                                {
                                    foreach ($addresses as $key => $value)
                                    {
                                        if ($cart['shipping_address']['shipping_address_id'] == $value['id'])
                                            $default_key = $key;
                                    }
                                }
                                foreach ($addresses as $key => $value)
                                {
                                    $country = $value['country'];
                                    foreach($countries as $c)
                                    {
                                        if($c['isocode'] == $country)
                                        {
                                            $country = $c['name'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <li class="JS_select adress_select <?php if ($default_key == $key) echo ' selected'; ?>" title="<?php echo $value['id']; ?>">
                                        <div class="addresses_con">
                                            <div class="tit">
                                                <label>Adresse <?php echo $key + 1; ?></label>
                                                <span class="right flr">
                                                    <a href="#" class="edit_address edit_btn JS_show_btn2" id="<?php echo $value['id']; ?>"></a>
                                                    <a href="#" class="delete_address del_btn" id="<?php echo $value['id']; ?>"></a>
                                                </span>
                                            </div>
                                            <p class="fix"><label>Name:</label><?php echo $value['firstname'] . ' ' . $value['lastname']; ?></p>
                                            <p class="fix"><label>Tel:</label><?php echo $value['phone']; ?></p>
                                            <p class="fix"><label>Adresse:</label><?php echo $value['address'] . ' ' . $value['city'] . ', ' . $value['state'] . ' ' . $country . ' ' . $value['zip']; ?></p>
                                        </div>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <div class="center">
                                <form action="<?php echo LANGPATH; ?>/cart/edit_address" method="post">
                                    <a class="view_btn btn26 JS_show_btn3">AJOUTER UNE NOUVELLE ADRESSE</a>
                                    <input type="hidden" id="shipping_address_id" name="shipping_address_id" value="<?php echo $addresses[0]['id']; ?>" />
                                    <input type="submit" class="view_btn btn26" value="AN DIESE ADRESSE VERSENDEN" />
                                </form>
                            </div>
                        </dd>
                        <?php
                        if ($has_address):
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
                            <div class="addresses" id="current_address">
                                <div class="addresses_con">
                                    <div>
                                        <span class="right flr">
                                            <a href="#" class="edit_address1 edit_btn" id="<?php echo $value['id']; ?>"></a>
                                        </span>
                                    </div>
                                    <p class="fix"><label>Name:</label><?php echo $cart['shipping_address']['shipping_firstname'] . ' ' . $cart['shipping_address']['shipping_lastname']; ?></p>
                                    <p class="fix"><label>Tel:</label><?php echo $cart['shipping_address']['shipping_phone']; ?></p>
                                    <p class="fix"><label>Adresse:</label><?php echo $cart['shipping_address']['shipping_address'] . ' ' . $cart['shipping_address']['shipping_city'] . ', ' . $cart['shipping_address']['shipping_state'] . ' ' . $shipping_country . ' ' . $cart['shipping_address']['shipping_zip']; ?></p>
                                </div>
                            </div>
                            <?php
                        endif;
                        ?>
                    </dl>
                    <!-- JS_show1 -->
                    <div id="edit_address" class="JS_show2 add_showcon hide">
                        <form action="<?php echo LANGPATH; ?>/cart/edit_address" method="post" class="form form_box form1">
                            <input type="hidden" id="e_address_id" name="shipping_address_id" value="">
                            <div class="add_showcon_box">
                                <h4>ADRESSE EDITIEREN</h4>
                                <ul class="add_showcon_boxcon">
                                    <li>
                                        <label><span>*</span> Vorname:</label>
                                        <input type="text" id="e_firstname" value="" name="shipping_firstname" class="text text_long" />
                                    </li>
                                    <li>
                                        <label><span>*</span> Nachname:</label>
                                        <input type="text" id="e_lastname" value="" name="shipping_lastname" class="text text_long" />
                                    </li>
                                    <li>
                                        <label><span>*</span> Adresse:</label>
                                        <div>
                                            <textarea id="e_address" class="textarea_long" name="shipping_address"></textarea>
                                        </div>
                                    </li>
                                    <li>
                                        <label><span>*</span> Land:</label>
                                        <select name="shipping_country" id="e_country" class="select_style selected304" onchange="changeSelectLand1();$('#billing_country').val($(this).val());">
                                            <option value="">EIN LAND WÄHLEN</option>
                                            <?php foreach ($countries as $country): ?>
                                                <option value="<?php echo $country['isocode']; ?>" ><?php echo $country['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </li>
                                    <li class="states1">
                                        <?php
                                        $stateCalled = Kohana::config('state.called');
                                        foreach ($stateCalled as $name => $called)
                                        {
                                            $called = str_replace(array('County', 'Province'), array('Pays', 'Région'), $called);
                                            ?>
                                            <div class="call1" id="call1_<?php echo $name; ?>" <?php if ($name != 'Default') echo 'style="display:none;"'; ?>>
                                                <label for="state"><span>*</span> <font id=""><?php echo $called; ?></font>:</label>
                                            </div>
                                            <?php
                                        }
                                        $stateArr = Kohana::config('state.states');
                                        foreach ($stateArr as $country => $states)
                                        {
                                            ?>
                                            <div class="all1 JS_drop" id="all1_<?php echo $country; ?>" style="display:none;">
                                                <select name="" class="select_style selected304 e_state" onblur="$('#billing_state1').val($(this).val());">
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
                                        <div class="all1" id="all1_default">
                                            <input type="text" name="shipping_state" id="e_state" class="text text_long" value="" maxlength="320" />
                                            <div class="errorInfo"></div>
                                        </div>
                                        <script>
                                            function changeSelectLand1(){
                                                var select = document.getElementById("e_country");
                                                var countryCode = select.options[select.selectedIndex].value;
                                                if(countryCode == 'BR')
                                                 {
                                                     $("#e_cpf").show();
                                                 }
                                                else
                                                {
                                                    $("#e_cpf").hide();
                                                }
                                                var c_name = 'call1_' + countryCode;
                                                $(".states1 .call1").hide();
                                                if(document.getElementById(c_name))
                                                {
                                                    $(".states1 #"+c_name).show();
                                                }
                                                else
                                                {
                                                    $(".states1 #call1_Default").show();
                                                }
                                                var s_name = 'all1_' + countryCode;
                                                $(".states1 .all1").hide();
                                                if(document.getElementById(s_name))
                                                {
                                                    $(".states1 #"+s_name).show();
                                                }
                                                else
                                                {
                                                    $(".states1 #all1_default").show();
                                                }
                                                $(function(){
                                                    $(".states1 .all1 select").change(function(){
                                                        var val = $(this).val();
                                                        $("#e_state").val(val);
                                                    })
                                                })
                                            }
                                        </script>
                                    </li>
                                    <li>
                                        <label><span>*</span> Stadt / Ort:</label>
                                        <input type="text" id="e_city" value="" name="shipping_city" class="text text_long" />
                                    </li>
                                    <li>
                                        <label><span>*</span> PLZ:</label>
                                        <input type="text" id="e_zip" value="" name="shipping_zip" class="text text_long" />
                                    </li>
                                    <li>
                                        <label><span>*</span> Telefon:</label>
                                        <input type="text" id="e_phone" value="" name="shipping_phone" class="text text_long" />
                                        <em>Bitte hinterlassen Sie eine richtige und vollständige Telefonnummer für 
                                            pünktliche Lieferung von Postbote</em>
                                    </li>
                                    <li id="e_cpf" class="hide">
                                        <label><span>*</span>o cadastro de pessoa Física:</label>
                                        <input type="text" name="shipping_cpf" class="text text_long" value="" />
                                    </li>
                                </ul>
                            </div>
                            <div class="center"><input type="submit" value="SPEICHERN & AN DIESE ADRESSE VERSENDEN" class="view_btn btn26" /></div>
                        </form>
                    </div>
                    <div class="JS_show3 add_showcon <?php if (!empty($addresses)) echo ' hide'; ?>">
                        <form action="<?php echo LANGPATH; ?>/cart/edit_address" method="post" class="form form_box form2">
                            <input type="hidden" name="shipping_address_id" value="new">
                            <div class="add_showcon_box">
                                <h4>AJOUTER UNE NOUVELLE ADRESSE</h4>
                                <ul class="add_showcon_boxcon">
                                    <li>
                                        <label><span>*</span> Vorname:</label>
                                        <input type="text" value="" name="shipping_firstname" class="text text_long" />
                                    </li>
                                    <li>
                                        <label><span>*</span> Nachname:</label>
                                        <input type="text" value="" name="shipping_lastname" class="text text_long" />
                                    </li>
                                    <li>
                                        <label><span>*</span> Adresse:</label>
                                        <div>
                                            <textarea class="textarea_long" name="shipping_address"></textarea>
                                        </div>
                                    </li>
                                    <li>
                                        <label><span>*</span> Land:</label>
                                        <select name="shipping_country" class="select_style selected304" id="shipping_country" onchange="changeSelectLand2();$('#billing_country').val($(this).val());">
                                            <option value="">EIN LAND WÄHLEN</option>
                                            <?php foreach ($countries as $country): ?>
                                                <option value="<?php echo $country['isocode']; ?>" ><?php echo $country['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </li>
                                    <li class="states2">
                                        <?php
                                        foreach ($stateCalled as $name => $called)
                                        {
                                            $called = str_replace(array('County', 'Province'), array('Pays', 'Région'), $called);
                                            ?>
                                            <div class="call2" id="call2_<?php echo $name; ?>" <?php if ($name != 'Default') echo 'style="display:none;"'; ?>>
                                                <label for="state"><span>*</span> <font id=""><?php echo $called; ?></font>:</label>
                                            </div>
                                            <?php
                                        }
                                        foreach ($stateArr as $country => $states)
                                        {
                                            ?>
                                            <div class="all2 JS_drop" id="all2_<?php echo $country; ?>" style="display:none;">
                                                <select name="" class="select_style selected304" onblur="$('#billing_state1').val($(this).val());">
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
                                        <div class="all2" id="all2_default">
                                            <input type="text" name="shipping_state" class="text text_long" value="" maxlength="320" />
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
                                                if(document.getElementById(s_name))
                                                {
                                                    $(".states2 #"+s_name).show();
                                                }
                                                else
                                                {
                                                    $(".states2 #all2_default").show();
                                                }
                                                $(function(){
                                                    $(".states2 .all2 select").change(function(){
                                                        var val = $(this).val();
                                                        $("#all2_default input").val(val);
                                                    })
                                                })
                                            }
                                        </script>
                                    </li>
                                    <li>
                                        <label><span>*</span> Stadt / Ort:</label>
                                        <input type="text" value="" name="shipping_city" class="text text_long" />
                                    </li>
                                    <li>
                                        <label><span>*</span> PLZ:</label>
                                        <input type="text" value="" name="shipping_zip" class="text text_long" />
                                    </li>
                                    <li>
                                        <label><span>*</span> Telefon:</label>
                                        <input type="text" value="" name="shipping_phone" class="text text_long" />
                                        <em>Bitte hinterlassen Sie eine richtige und vollständige Telefonnummer für 
                                            pünktliche Lieferung von Postbote</em>
                                    </li>
                                    <li id="shipping_cpf" class="hide">
                                        <label><span>*</span>o cadastro de pessoa Física:</label>
                                        <input type="text" name="shipping_cpf" class="text text_long" value="" />
                                    </li>
                                </ul>
                            </div>
                            <div class="center"><input type="submit" value="SPEICHERN & AN DIESE ADRESSE VERSENDEN" class="view_btn btn26" /></div>
                        </form>
                    </div>

                    <div id="coupon_points"></div>
                    <h3>MÉTHODES DE LIVRAISON</h3>
                    <?php
                    $cart_shipping = !empty($cart['shipping']) ? $cart['shipping']['price'] : -1;
                    $site_shipping = kohana::config('sites.shipping_price');
                    if ($cart_shipping != -1)
                    {
                        ?>
                        <dl class="edit_shipping addresses">
                            <?php
                            foreach ($site_shipping as $price):
                                if ($price['price'] == $cart_shipping):
                                    $name = str_replace(array('Business Day Shipping', 'Day Shipping'), array('Werktage Versand', 'Tage Versand'), $price['name']);
                                    ?>
                                    <dd class="addresses_con">
                                        <?php echo $name . ' ( ' . Site::instance()->price($price['price'], 'code_view') . ' )'; ?>
                                        <span class="right flr">
                                            <a href="#" class="edit_btn" id="edit_shipping"></a>
                                        </span>
                                    </dd>
                                    <?php
                                endif;
                            endforeach;
                            ?>
                        </dl>
                        <?php
                    }
                    ?>
                    <div class="shipping_methods <?php if ($cart_shipping != -1) echo 'hide' ?>">
                        <form action="<?php echo LANGPATH; ?>/cart/shipping_price" method="POST">
                            <ul class="fix" id="shipping_select">
                                <?php
                                $default_shipping = 0;
                                foreach ($site_shipping as $key => $price):
                                    $selected = 0;
                                    if ($cart_shipping == -1)
                                    {
                                        if ($key == 1)
                                        {
                                            $default_shipping = $price['price'];
                                            $selected = 1;
                                        }
                                    }
                                    elseif ($price['price'] == $cart_shipping)
                                    {
                                        $default_shipping = $price['price'];
                                        $selected = 1;
                                    }
                                    ?>
                                    <li class="JS_select<?php if ($selected) echo ' selected'; ?>" value="<?php echo $price['price']; ?>"><?php echo $price['name'] . ' ( ' . Site::instance()->price($price['price'], 'code_view') . ' )'; ?></li>
                                    <?php
                                endforeach;
                                ?>
                            </ul>
                            <input type="hidden" id="shipping_price" name="shipping_price" value="<?php echo $default_shipping; ?>" />
                            <p class="fix" style="margin-right: 28px;">
                                <input type="submit" value="ZU SICHERN KASSE" class="view_btn btn26 btn40 flr" />
                            </p>
                        </form>
                    </div>
                    <?php
                    if($has_address AND isset($cart['shipping']['price'])):
                    ?>
                    <h3>GUTSCHEINE & PUNKTE</h3>
                    <dl class="shipping_payment">
                        <div id="coupon_list" <?php if ($cart['coupon']) echo 'class="hide"' ?>>
                            <dt>BEZAHLEN MIT GUTSCHEIN</dt>
                            <dd>
                                <div class="note">
                                    Hinweis: 1. Das Produkt mit "% Rabatt" Ikone kann nicht mit Gutschein-Code kombiniert werden.
                                    <span>2. Bitte geben Sie den Gutschein-Code ohne Leerzeichen ein.</span>
                                </div>
                                <?php
//                                if(strpos($message, 'code') !== FALSE)
                                    echo $message;
                                ?>
                                <div class="coupons_box fix">
                                    <form action="<?php echo LANGPATH; ?>/cart/set_coupon" method="post" class="form">
                                        Gutschein-Code Eingeben
                                        <input type="text" value="" name="coupon_code" class="text codeInput" />
                                        <input type="submit" value="BEWERBEN" class="view_btn btn26" />
                                        <a class="codelist J_pop_btn">Codeliste</a>
                                    </form>
                                    <p>Ein Code pro Bestellung Begrenzen.</p>
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
                        </div>
                        </dd>
                        <?php
                        if ($cart['coupon']):
                            ?>
                            <div id="current_coupon">
                                <dl class="edit_shipping addresses">
                                    <dd class="addresses_con">
                                        Aktueller Gutschein Code:
                                        <span class="red"><?php echo $cart['coupon']; ?></span>
    <!--                                        <span class="right flr">
                                            <a href="#" class="edit_btn" id="edit_coupon"></a>
                                        </span>-->
                                    </dd>
                                </dl>
                            </div>
                            <?php
                        endif;
                        ?>
                        <dt>BEZAHLEN MIT PUNKTEN <span class="font11">(10 Points=$0.1)</span></dt>
                        <dd>
                            <em>Sie können Punkte bis zu insgesamt 10% des Auftragswertes verwenden (über $ 10, Fracht ausgenommen). <a target="_blank" href="<?php echo LANGPATH; ?>/coupon-points" class="a_red">Punkte Politik</a></em>
                            <div class="points">
                                <?php
                                if ($points_avail >= 0):
                                    ?>
                                    Maximale Anzahl der Punkte, die Sie möglicherweise bewerben :<span><?php echo $points_avail; ?> Punkte</span>
                                    <?php
                                else:
                                    echo 'To use your points, please shop at least $10+.';
                                endif;
                                ?>
                            </div>
                            <div class="coupons_box fix">
                                <form action="<?php echo LANGPATH; ?>/cart/point" id="point_form" method="post" class="form">
                                    <input type="hidden" name="shipping" value="1" />
                                    <input type="text" id="point" value="" name="points" class="text text_short" onkeydown="return point2dollar();" />Punkte = $
                                    <input type="text" id="dollar" value="" name="dollar" class="text text_short" />
                                    <input type="submit" value="WECHSELN" class="view_btn btn26" onclick="return point_redeem();" />
                                </form>
                                <p>Der Rest Ihrer Bestellung zu zahlen: $<span id="amount_left"><?php echo round($cart['amount']['total'], 2); ?></span><span id="point_left"></span><br />       
                                    Punkte für diese Bestellung erhalten:   <strong id="point_earned" class="red"><?php echo floor($cart['amount']['total']); ?></strong>Punkte  ($1 = 1 punkte )</p>
                            </div>
                            <script type="text/javascript">
                                var xhr = null;
                                var amount_left = $('#amount_left').text();
                                
                                function point_redeem()
                                {
                                    var points = parseFloat(document.getElementById('point').value);
                                    if (points > <?php print $points_avail; ?>) {
                                        window.alert('Pas assez de points disponible');
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
                                            dollar.value = '';
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
                                        dollar.value = point_left;
                                    }, 0);
                                }
                            </script>
                        </dd>
                    </dl>

                    <!-- payment -->
                    <h3>BEZAHLUNG</h3>
                    <form id="payment_form" method="post" action="<?php echo LANGPATH; ?>" class="form form_box">
                        <dl class="shipping_payment">
                            <dt>WÄHLEN SIE IHRE ZAHLUNGSWEISE</dt>
                            <dd class="shipping_methods shipping_methods1">
                                <ul class="fix">
                                    <li class="JS_select f1 selected" title="PP" id="radio2" onclick="$('#ccDiv').hide();"><span class="cards card1"></span></li>
                                    <li class="JS_select" title="GLOBEBILL" id="radio1" onclick="$('#ccDiv').show();"><span class="cards card2"></span></li>
                                </ul>
                                <input type="hidden" id="payment_method" name="payment_method" value="PP" />
                            </dd>
                            <div id="ccDiv" class="hide">
                                <dt>Rechnungsadresse</dt>
                                <dd class="shipping_methods">
                                    <ul class="fix">
                                        <li class="JS_select f1 selected" value="1" id="radio_changeaddr1">Senden Sie die Rechnung an meine Liefer adresse</li>
                                        <li class="JS_select" value="2" id="radio_changeaddr2">Senden Sie die Rechnung an eine andere Adresse</li>
                                    </ul>
                                    <input type="hidden" id="billing_method" name="billing_method" value="1" />
                                </dd>
                            </div>
                            <div class="add_showcon_box add_showcon" id="billingAdresse" style="display:none;">
                                <ul class="add_showcon_boxcon">
                                    <li>
                                        <label for="billing_firstname"><span class="strong1">*</span> Vorname :</label>
                                        <input type="text" name="billing_firstname" id="billing_firstname" class="text text_long" value="" maxlength="250"   />

                                    </li>
                                    <li>
                                        <label for="billing_lastname"><span class="strong1">*</span> Nachname :</label>
                                        <input type="text" name="billing_lastname" id="billing_lastname" class="text text_long" value="" maxlength="250"   />
                                    </li>
                                    <li>
                                        <label for="billing_address"><span class="strong1">*</span> Adresse :</label>
                                        <textarea name="billing_address" id="billing_address" class="textarea_long"></textarea>
                                    </li>
                                    <li>
                                        <label for="billing_country"><span class="strong1">*</span> Land :</label>
                                        <select name="billing_country" id="billing_country" class="select_style selected304" onchange="changeSelectLand3();$('#billing_country').val($(this).val());">
                                            <option value="">EIN LAND WÄHLEN</option>
                                            <?php foreach ($countries as $country): ?>
                                                <option value="<?php echo $country['isocode']; ?>" ><?php echo $country['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </li>
                                    <li class="states3">
                                        <?php
                                        $stateCalled = Kohana::config('state.called');
                                        foreach ($stateCalled as $name => $called)
                                        {
                                            $called = str_replace(array('County', 'Province'), array('Pays', 'Région'), $called);
                                            ?>
                                            <div class="call3" id="call3_<?php echo $name; ?>" <?php if ($name != 'Default') echo 'style="display:none;"'; ?>>
                                                <label for="state"><span>*</span> <font id="state_name3"><?php echo $called; ?></font>:</label>
                                            </div>
                                            <?php
                                        }
                                        $stateArr = Kohana::config('state.states');
                                        foreach ($stateArr as $country => $states)
                                        {
                                            ?>
                                            <div class="all3 JS_drop" id="all3_<?php echo $country; ?>" style="display:none;">
                                                <select name="" id="billing_state1" class="select_style selected304" onblur="$('#billing_state1').val($(this).val());">
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
                                        <div class="all3" id="all3_default">
                                            <input type="text" name="billing_state" id="billing_state" class="text text_long" value="" maxlength="320" onblur="$('#billing_state').val($(this).val());" />
                                        </div>
                                        <script>
                                            function changeSelectLand3(){
                                                var select = document.getElementById("billing_country");
                                                var countryCode = select.options[select.selectedIndex].value;
                                                if(countryCode == 'BR')
                                                {
                                                    $("#billing_cpf").show();
                                                }
                                                else
                                                {
                                                    $("#billing_cpf").hide();
                                                }
                                                var c_name = 'call3_' + countryCode;
                                                $(".states3 .call3").hide();
                                                if(document.getElementById(c_name))
                                                {
                                                    $(".states3 #"+c_name).show();
                                                }
                                                else
                                                {
                                                    $(".states3 #call3_Default").show();
                                                }
                                                var s_name = 'all3_' + countryCode;
                                                $(".states3 .all3").hide();
                                                if(document.getElementById(s_name))
                                                {
                                                    $(".states3 #"+s_name).show();
                                                }
                                                else
                                                {
                                                    $(".states3 #all3_default").show();
                                                }
                                                $(function(){
                                                    $(".states3 .all3 select").change(function(){
                                                        var val = $(this).val();
                                                        $("#billing_state").val(val);
                                                    })
                                                })
                                            }
                                        </script>
                                    </li>
                                    <li>
                                        <label for="billing_city"><span class="strong1">*</span> Ort/Stadt:</label>
                                        <input type="text" name="billing_city" id="billing_city" class="text text_long" value="" maxlength="320"   />
                                    </li>
                                    <li>
                                        <label for="billing_zip"><span class="strong1">* </span> PLZ</label>
                                        <input type="text" name="billing_zip" id="billing_zip" class="text text_long" value="" maxlength="320"   />
                                    </li>
                                    <li>
                                        <label for="billing_phone"><span class="strong1">*</span> Telefon1 :</label>
                                        <input type="text" name="billing_phone" id="billing_phone" class="text text_long" value="" maxlength="320"   />
                                    </li>
                                    <li id="billing_cpf" class="hide">
                                        <label><span>*</span>o cadastro de pessoa Física:</label>
                                        <input type="text" name="billing_cpf" class="text text_long" value="" maxlength="16" />
                                    </li>
                                </ul>
                            </div>
                            <p class="flr" style="margin-right: 28px;">
                                <input type="submit" class="view_btn btn26 btn40" value="Proceed to checkout" />
                            </p>
                        </dl>
                    </form>
                    <?php
                    endif;
                    ?>
                </article>

                <!-- order_summary -->
                <div class="order_summary flr">
                    <div class="JS_cart_side cart_side">
                        <h3>IHRE BESTELLZUSAMMENFASSUNG</h3>
                        <ul class="pro_con1">
                            <?php
                            foreach ($cart['products'] as $key => $product):
                                $name = Product::instance($product['id'], LANGUAGE)->get('name');
                                $link = Product::instance($product['id'], LANGUAGE)->permalink();
                                ?>
                                <li class="fix">
                                    <div class="left"><a href="<?php echo $link; ?>"><img src="<?php echo image::link(Product::instance($product['id'])->cover_image(), 3); ?>" alt="<?php echo $name; ?>" /></a></div>
                                    <div class="right">
                                        <a href="<?php echo $link; ?>" class="name"><?php echo $name; ?></a>
                                        <p>Article: #<?php echo Product::instance($product['id'])->get('sku'); ?></p>
                                        <p><?php echo Site::instance()->price($product['price'], 'code_view'); ?></p>
                                        <p>
                                            <?php
                                            $delivery_time = kohana::config('prdress.delivery_time');
                                            if (isset($product['attributes'])):
                                                foreach ($product['attributes'] as $attribute => $option):
                                                    if($attribute == 'Size') $attribute = 'Taille';
                                                    if ($attribute == 'delivery time')
                                                        $option = $option > 0 ? 'Rush Order' . ' ( + ' . Site::instance()->price($option, 'code_view') . ' )' : 'Regular Order';
                                                    echo ucfirst($attribute) . ': ' . $option . '<br>';
                                                endforeach;
                                            endif;
                                            ?>
                                        </p> 
                                        <p>Qté.: <?php echo $product['quantity']; ?></p>
                                    </div>
                                </li>
                                <?php
                            endforeach;
                            if(!empty($cart['largesses'])):
                            foreach ($cart['largesses'] as $key => $product):
                                ?>
                                <li class="fix">
                                    <div class="left"><a href="<?php echo $link; ?>"><img src="<?php echo image::link(Product::instance($product['id'])->cover_image(), 3); ?>" alt="<?php echo $name; ?>" /></a></div>
                                    <div class="right">
                                        <a href="<?php echo $link; ?>" class="name"><?php echo $name; ?></a>
                                        <p>Article: #<?php echo Product::instance($product['id'])->get('sku'); ?></p>
                                        <p><?php echo Site::instance()->price($product['price'], 'code_view'); ?></p>
                                        <p>
                                            <?php
                                            $delivery_time = kohana::config('prdress.delivery_time');
                                            if (isset($product['attributes'])):
                                                foreach ($product['attributes'] as $attribute => $option):
                                                    if($attribute == 'Size') $attribute = 'Taille';
                                                    if ($attribute == 'delivery time')
                                                        $option = $option > 0 ? 'Rush Order' . ' ( + ' . Site::instance()->price($option, 'code_view') . ' )' : 'Regular Order';
                                                    echo ucfirst($attribute) . ': ' . $option . '<br>';
                                                endforeach;
                                            endif;
                                            ?>
                                        </p> 
                                        <p>Qté.: <?php echo $product['quantity']; ?></p>
                                    </div>
                                </li>
                                <?php
                            endforeach;
                            endif;
                            ?>
                        </ul>
                        <ul class="total">
                            <li><label>Sous total: </label><span><?php echo Site::instance()->price($cart['amount']['items'], 'code_view'); ?></span></li>     
                            <li><label>Livraison estimée: </label><span id="shipping_total"><?php echo $cart_shipping == -1 ? Site::instance()->price($site_shipping[1]['price'], 'code_view') : Site::instance()->price($cart_shipping, 'code_view'); ?></span></li>
                            <?php
                            if ($cart['amount']['coupon_save'] + $cart['amount']['point'] > 0):
                                ?>
                                <li><label>Payer avec Coupons & Points: </label><span><?php echo Site::instance()->price($cart['amount']['coupon_save'] + $cart['amount']['point'], 'code_view'); ?></span></li>
                                <?php
                            endif;
                            $saving = $cart['amount']['items'] + $cart['amount']['shipping'] - $cart['amount']['total'];
                            $item_saving = round($saving - $cart['amount']['coupon_save'] - $cart['amount']['point'], 2);

                            if ($item_saving > 0):
                                ?>
                                <li><label>remise: </label><span><?php echo Site::instance()->price($item_saving, 'code_view'); ?></span></li> 
                                <?php
                            endif;
                            ?>
                            <li class="total_num"><label>Total: </label><span id="totalPrice"><?php echo $cart['amount']['shipping'] ? Site::instance()->price($cart['amount']['total'], 'code_view') : Site::instance()->price($cart['amount']['total'] + $default_shipping, 'code_view'); ?></span></li>
                            <?php
                            if ($saving):
                                ?>
                                <li class="last"><label>Économiser: </label><span><?php echo Site::instance()->price($saving, 'code_view'); ?></span></li>
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
<div class="hide" id="cart_delete" style="position: fixed;padding: 10px 10px 20px; top: 170px;left: 400px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border:1px solid #cdcdcd;">
    <div style="font-size: 1.4em;margin-top:0px;border-bottom: 2px solid #F4F4F4;">CONFIRMATION</div>

    <div class="order order_addtobag center" style="margin:20px;">
        <div style="font-size:13px;margin-bottom: 20px;">Êtes-vous sûr de supprimer cet article? il ne peut pas être annulé.</div>
        <form action="<?php echo LANGPATH; ?>/cart/delete_address" method="post">
            <input type="hidden" name="address_id" id="address_id" value="" />
            <input type="submit" class="view_btn btn26" value="LÖSCHEN" />
            <a href="#" class="cancel" style="text-decoration:underline;margin-left:10px;">Annuler</a>
        </form>
    </div>
    <div class="clsbtn" style="right: -0px;top: 3px;"></div>
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
            $("#billingAdresse").hide();
            $("#payment_form").removeClass('form3');
        })
        $("#radio_changeaddr2").live('click', function(){
            $("#billingAdresse").show();
            $("#payment_form").addClass('form3');
        })
    })
    
    //shipping price
    $(function(){
        $("#shipping_select li").click(function(){
            var price = $(this).attr('value');
            var code = "<?php $currency = Site::instance()->currency(); echo $currency['code']; ?>";
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
                required: "Bitte geben Sie Ihren Vornamen ein.",
                maxlength:"Ihren Vornamen überschreitet eine maximale Länge von 50 Zeichen."
            },
            shipping_lastname: {
                required: "Bitte geben Sie Ihren Nachnamen ein.",
                maxlength:"Ihren Nachnamen überschreitet eine maximale Länge von 50 Zeichen."
            },
            shipping_address: {
                required: "Bitte geben Sie Ihren Adresse ein.",
                maxlength:"Ihren Adresse überschreitet eine maximale Länge von 200 Zeichen."
            },
            shipping_zip: {
                required: "Bitte geben Sie Ihre Postleitzahl ein.",
                maxlength:"Ihre Postleitzahl überschreitet eine maximale Länge von 50 Zeichen."
            },
            shipping_city: {
                required: "Bitte geben Sie Ihre Stadt ein.",
                maxlength:"Ihre Stadt überschreitet eine maximale Länge von 50 Zeichen."
            },
            shipping_country: {
                required: "Bitte wählen Sie Ihr Land.",
                maxlength:"Ihr Land überschreitet eine maximale Länge von 50 Zeichen."
            },
            shipping_state: {
                required: "Bitte geben Sie Ihren Bundesland / Provinz / Staat ein.",
                maxlength:"Ihren Bundesland überschreitet eine maximale Länge von 50 Zeichen."
            },
            shipping_phone: {
                required: "Bitte geben Sie Ihre Telefon ein.", 
                maxlength:"Ihre Telefon überschreitet eine maximale Länge von 50 Zeichen."
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
                required: "Bitte geben Sie Ihren Vornamen ein.",
                maxlength:"Ihren Vornamen überschreitet eine maximale Länge von 50 Zeichen."
            },
            shipping_lastname: {
                required: "Bitte geben Sie Ihren Nachnamen ein.",
                maxlength:"Ihren Nachnamen überschreitet eine maximale Länge von 50 Zeichen."
            },
            shipping_address: {
                required: "Bitte geben Sie Ihren Adresse ein.",
                maxlength:"Ihren Adresse überschreitet eine maximale Länge von 200 Zeichen."
            },
            shipping_zip: {
                required: "Bitte geben Sie Ihre Postleitzahl ein.",
                maxlength:"Ihre Postleitzahl überschreitet eine maximale Länge von 50 Zeichen."
            },
            shipping_city: {
                required: "Bitte geben Sie Ihre Stadt ein.",
                maxlength:"Ihre Stadt überschreitet eine maximale Länge von 50 Zeichen."
            },
            shipping_country: {
                required: "Bitte wählen Sie Ihr Land.",
                maxlength:"Ihr Land überschreitet eine maximale Länge von 50 Zeichen."
            },
            shipping_state: {
                required: "Bitte geben Sie Ihren Bundesland / Provinz / Staat ein.",
                maxlength:"Ihren Bundesland überschreitet eine maximale Länge von 50 Zeichen."
            },
            shipping_phone: {
                required: "Bitte geben Sie Ihre Telefon ein.", 
                maxlength:"Ihre Telefon überschreitet eine maximale Länge von 50 Zeichen."
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
                required: "Bitte geben Sie Ihren Vornamen ein.",
                maxlength:"Ihren Vornamen überschreitet eine maximale Länge von 50 Zeichen."
            },
            billing_lastname: {
                required: "Bitte geben Sie Ihren Nachnamen ein.",
                maxlength:"Ihren Nachnamen überschreitet eine maximale Länge von 50 Zeichen."
            },
            billing_address: {
                required: "Bitte geben Sie Ihren Adresse ein.",
                maxlength:"Ihren Adresse überschreitet eine maximale Länge von 200 Zeichen."
            },
            billing_zip: {
                required: "Bitte geben Sie Ihre Postleitzahl ein.",
                maxlength:"Ihre Postleitzahl überschreitet eine maximale Länge von 50 Zeichen."
            },
            billing_city: {
                required: "Bitte geben Sie Ihre Stadt ein.",
                maxlength:"Ihre Stadt überschreitet eine maximale Länge von 50 Zeichen."
            },
            billing_country: {
                required: "Bitte wählen Sie Ihr Land.",
                maxlength:"Ihr Land überschreitet eine maximale Länge von 50 Zeichen."
            },
            billing_state: {
                required: "Bitte geben Sie Ihren Bundesland / Provinz / Staat ein.",
                maxlength:"Ihren Bundesland überschreitet eine maximale Länge von 50 Zeichen."
            },
            billing_phone: {
                required: "Bitte geben Sie Ihre Telefon ein.", 
                maxlength:"Ihre Telefon überschreitet eine maximale Länge von 50 Zeichen."
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