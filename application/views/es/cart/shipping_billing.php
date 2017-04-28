<div class="cart_header">
    <div class="layout">
        <a href="<?php echo LANGPATH; ?>/" class="logo"><img src="/images/logo.png" /></a>
        <div class="cart_step">
            <h2><img src="/images/payment_step1.png" /></h2>
            <div class="cart_step_bottom">
                <span class="on">Envío Y Entrega</span>
                <span>Confirmación Del Pago</span>
                <span>Realizar El Pedido</span>
            </div>
        </div>
        <a href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en" target="_blank"><img src="/images/card3.png" /></a>
    </div>
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
            <article class="shipping_delivery_left fll">
                <h3>DIRECCIÓNES POR ENVÍO</h3>
                <form action="<?php echo LANGPATH; ?>/cart/edit_shipping" method="post" class="form form_box form2" id="addNew">
                    <?php
                    $has_address = (isset($cart['shipping_address']) AND !empty($cart['shipping_address'])) ? 1 : 0;
                    if ($has_address AND !empty($addresses))
                    {
                        ?>
                        <dl class="shipping_payment">
                            <dd>
                                <ul class="shipping_address">
                                    <?php
                                    $default_key = 0;
                                    if ($has_address)
                                    {
                                        if ($cart['shipping_address']['shipping_address_id'] == 'new')
                                        {
                                            foreach ($addresses as $key => $value)
                                            {
                                                if ($value['id'] > $default_key)
                                                    $default_key = $key;
                                            }
                                        }
                                        else
                                        {
                                            foreach ($addresses as $key => $value)
                                            {
                                                if ($cart['shipping_address']['shipping_address_id'] == $value['id'])
                                                    $default_key = $key;
                                            }
                                        }
                                    }
                                    foreach ($addresses as $key => $value)
                                    {
                                        $country = $value['country'];
                                        foreach ($countries as $c)
                                        {
                                            if ($c['isocode'] == $country)
                                            {
                                                $country = $c['name'];
                                                break;
                                            }
                                        }
                                        ?>
                                        <li class="fix JS_shows_btn1">
                                            <div class="fix">
                                                <input type="radio" value="<?php echo $value['id']; ?>" name="shipping_address_id" id="radio<?php echo $key; ?>" class="radio JS_select" <?php if ($key == $default_key) echo 'checked'; ?> />
                                                <label for="radio<?php echo $key; ?>"><b class="s1">Dirección<?php echo $key + 1; ?></b></label>
                                                <div class="flr address_edit JS_shows1">
                                                    <?php
                                                    if ($key == $default_key)
                                                    {
                                                        ?>
                                                        <span class="b">Defecto</span>
                                                        <a href="#" class="btn22_black JS_popwinbtn1 edit_address" id="<?php echo $value['id']; ?>">Editar</a>
                                                        <a href="#" class="btn22_gray delete_address" title="<?php echo $value['id']; ?>">Eliminar</a>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <a href="<?php echo LANGPATH; ?>/address/set_default/<?php echo $value['id']; ?>" class="a_underline">Establecer Defecto</a>
                                                        <a href="#" class="btn22_black JS_popwinbtn1 edit_address" id="<?php echo $value['id']; ?>">Editar</a>
                                                        <a href="#" class="btn22_gray delete_address" title="<?php echo $value['id']; ?>">Eliminar</a>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <p class="bottom">
                                                <span><?php echo $value['firstname'] . ' ' . $value['firstname']; ?></span>
                                                <span class="tel"><?php echo $value['phone']; ?></span>
                                                <span><?php echo $value['address'] . ', ' . $value['city'] . ', ' . $value['state'] . ', ' . $value['country'] . ', ' . $value['zip']; ?></span>
                                            </p>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <li class="fix last">
                                        <input type="radio" name="shipping_address_id" value="new" class="hide" id="radionew" />
                                        <label for="radionew" class="a_underline add_new font14">+Añadir Una Dirección Nueva</label>
                                    </li>
                                </ul>
                            </dd>
                        </dl>
                        <?php
                    }
                    else
                    {
                        ?>
                        <input type="hidden" name="shipping_address_id" value="new"  />
                        <?php
                    }
                    ?>
                    <div id="selectNew"></div>
                    <div class="user_share_form <?php if ($has_address AND !empty($addresses)) echo 'hide'; ?>" id="addnewform">
                        <div>
                            <ul class="add_showcon_boxcon">
                                <li>
                                    <label><span>*</span> Primer Nombre:</label>
                                    <input type="text" value="<?php echo $cart['shipping_address']['shipping_firstname']; ?>" name="shipping_firstname" id="shipping_firstname" class="text text_long" />
                                </li>
                                <li>
                                    <label><span>*</span> Apellido:</label>
                                    <input type="text" value="<?php echo $cart['shipping_address']['shipping_lastname']; ?>" name="shipping_lastname" id="shipping_lastname" class="text text_long" />
                                </li>
                                <li>
                                    <label><span>*</span> Dirección:</label>
                                    <div>
                                        <textarea class="textarea_long" name="shipping_address" id="shipping_address"><?php echo $cart['shipping_address']['shipping_address']; ?></textarea>
                                    </div>
                                </li>
                                <li>
                                    <label><span>*</span> País:</label>
                                    <select name="shipping_country" class="select_style selected304" id="shipping_country" onchange="changeSelectLand2();$('#billing_country').val($(this).val());">
                                        <option value="">SELECCIONAR UN PAÍS</option>
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
                                        $called = str_replace(array('County', 'Province'), array('Condado', 'Provincia'), $called);
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
                                                <option value="">[SELECCIONAR UNA]</option>
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
                                    <label><span>*</span> Ciudad / Pueblo:</label>
                                    <input type="text" value="<?php echo $cart['shipping_address']['shipping_city']; ?>" name="shipping_city" id="shipping_city" class="text text_long" />
                                </li>
                                <li>
                                    <label><span>*</span> Código Postal:</label>
                                    <input type="text" value="<?php echo $cart['shipping_address']['shipping_zip']; ?>" name="shipping_zip" id="shipping_zip" class="text text_long" />
                                </li>
                                <li>
                                    <label><span>*</span> Teléfono:</label>
                                    <input type="text" value="<?php echo $cart['shipping_address']['shipping_phone']; ?>" name="shipping_phone" id="shipping_phone" class="text text_long" />
                                </li>
                                <li id="shipping_cpf" class="hide">
                                    <label><span>*</span>o cadastro de pessoa Física:</label>
                                    <input type="text" name="shipping_cpf" id="shipping_cpf" class="text text_long" value="" />
                                </li>
                            </ul>
                        </div>
                    </div>
                    <h3>MÉTODOS DE ENVÍO</h3>
                    <?php
                    $cart_shipping = !empty($cart['shipping']) ? $cart['shipping']['price'] : -1;
                    // $site_shipping = kohana::config('sites.shipping_price');
                    ?>
                    <div class="shipping_methods">
                        <ul class="fix">
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
                                $ship_name = str_replace(array('Working Day Shipping'), array('días laborables Envio'), $price['name']);
                                ?>
                                <li>
                                    <input type="radio" name="shipping_price" value="<?php echo $price['price']; ?>" id="radios<?php echo $key; ?>" class="radio" <?php if ($price['price'] == $default_shipping) echo 'checked'; ?> />
                                    <label for="radios<?php echo $key; ?>"><?php echo $ship_name . ' ( ' . Site::instance()->price($price['price'], 'code_view') . ' )'; ?></label>
                                </li>
                                <?php
                            endforeach;
                            ?>
                        </ul>
                        <p>
                            <input type="submit" value="PAGO SEGURO" class="btn40_16_red" />
                        </p>
                    </div>
                </form>

                <!-- JS_show1 -->
                <div id="edit_address" class="JS_popwincon2 popwincon popwincon_user hide">
                    <a class="JS_close3 close_btn2"></a>
                    <form action="<?php echo LANGPATH; ?>/cart/edit_address" method="post" class="form user_share_form user_form form1">
                        <input type="hidden" id="e_address_id" name="shipping_address_id" value="">
                        <ul class="add_showcon_boxcon">
                            <li>
                                <label><span>*</span> Primer Nombre:</label>
                                <input type="text" id="e_firstname" value="" name="shipping_firstname" class="text text_long" />
                            </li>
                            <li>
                                <label><span>*</span> Apellido:</label>
                                <input type="text" id="e_lastname" value="" name="shipping_lastname" class="text text_long" />
                            </li>
                            <li>
                                <label><span>*</span> Dirección:</label>
                                <div>
                                    <textarea id="e_address" class="textarea_long" name="shipping_address"></textarea>
                                </div>
                            </li>
                            <li>
                                <label><span>*</span> País:</label>
                                <select name="shipping_country" id="e_country" class="select_style selected304" onchange="changeSelectLand1();$('#billing_country').val($(this).val());">
                                    <option value="">SELECCIONAR UN PAÍS</option>
                                    <?php foreach ($countries as $country): ?>
                                        <option value="<?php echo $country['isocode']; ?>" ><?php echo $country['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </li>
                            <li class="states1">
                                <?php
                                foreach ($stateCalled as $name => $called)
                                {
                                    $called = str_replace(array('County', 'Province'), array('Condado', 'Provincia'), $called);
                                    ?>
                                    <div class="call1" id="call1_<?php echo $name; ?>" <?php if ($name != 'Default') echo 'style="display:none;"'; ?>>
                                        <label for="state"><span>*</span> <font id=""><?php echo $called; ?></font>:</label>
                                    </div>
                                    <?php
                                }
                                foreach ($stateArr as $country => $states)
                                {
                                    ?>
                                    <div class="all1 JS_drop" id="all1_<?php echo $country; ?>" style="display:none;">
                                        <select name="" class="select_style selected304 e_state">
                                            <option value="">[SELECCIONAR UNA]</option>
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
                                <div id="all1_default">
                                    <input type="text" name="shipping_state" id="e_state" class="all1 text text_long" value="" maxlength="320" />
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
                                            $(".states1 #all1_default .all1").show();
                                        }
                                        $("#e_state").val('');
                                    }
                                    $(function(){
                                        $(".states1 .all1 select").change(function(){
                                            var val = $(this).val();
                                            $("#e_state").val(val);
                                        })
                                    })
                                </script>
                            </li>
                            <li>
                                <label><span>*</span> Ciudad / Pueblo:</label>
                                <input type="text" id="e_city" value="" name="shipping_city" class="text text_long" />
                            </li>
                            <li>
                                <label><span>*</span> Código Postal:</label>
                                <input type="text" id="e_zip" value="" name="shipping_zip" class="text text_long" />
                            </li>
                            <li>
                                <label><span>*</span> Teléfono:</label>
                                <input type="text" id="e_phone" value="" name="shipping_phone" class="text text_long" />
                            </li>
                            <li id="e_cpf" class="hide">
                                <label><span>*</span>o cadastro de pessoa Física:</label>
                                <input type="text" name="shipping_cpf" class="text text_long" value="" />
                            </li>
                        </ul>
                        <div class="center" style="margin-left: -63px;"><input type="submit" value="PRESENTAR" class="btn30_14_black" /></div>
                    </form>
                </div>
            </article>

            <!-- order_summary -->
            <div class="order_summary flr">
                <div class="cart_side">
                    <h3>SU RESUMEN DE PEDIDO</h3>
                    <ul class="pro_con1">
                        <?php
                        $ecomm_prodid = array();
                        foreach ($cart['products'] as $key => $product):
                            $sku = Product::instance($product['id'], LANGUAGE)->get('sku');
                            $ecomm_prodid[] = "'$sku'";
                            $name = Product::instance($product['id'], LANGUAGE)->get('name');
                            $link = Product::instance($product['id'], LANGUAGE)->permalink();
                            $img = Product::instance($product['id'])->cover_image();
                            ?>
                            <li class="fix">
                                <div class="left"><a href="<?php echo $link; ?>"><img src="<?php echo '/pimages1/' . $img['id'] . '/3.' . $img['suffix']; ?>" alt="<?php echo $name; ?>" /></a></div>
                                <div class="right">
                                    <a href="<?php echo $link; ?>" class="name"><?php echo $name; ?></a>
                                    <p>Artículo: #<?php echo $sku; ?></p>
                                    <p><?php echo Site::instance()->price($product['price'], 'code_view'); ?></p>
                                    <p>
                                        <?php
                                        $delivery_time = kohana::config('prdress.delivery_time');
                                        if (isset($product['attributes'])):
                                            foreach ($product['attributes'] as $attribute => $option):
                                                $attribute = str_replace('Size', 'Talla ', $attribute);
                                                if ($attribute == 'delivery time')
                                                    $option = $option > 0 ? 'Rush Order' . ' ( + ' . Site::instance()->price($option, 'code_view') . ' )' : 'Regular Order';
                                                echo ucfirst($attribute) . ': ' . $option . '<br>';
                                            endforeach;
                                        endif;
                                        ?>
                                    </p> 
                                    <p>Cantidad.: <?php echo $product['quantity']; ?></p>
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
                                        <p>Artículo: #<?php echo $sku; ?></p>
                                        <p><?php echo Site::instance()->price($product['price'], 'code_view'); ?></p>
                                        <p>
                                            <?php
                                            $delivery_time = kohana::config('prdress.delivery_time');
                                            if (isset($product['attributes'])):
                                                foreach ($product['attributes'] as $attribute => $option):
                                                    $attribute = str_replace('Size', 'Talla ', $attribute);
                                                    if ($attribute == 'delivery time')
                                                        $option = $option > 0 ? 'Rush Order' . ' ( + ' . Site::instance()->price($option, 'code_view') . ' )' : 'Regular Order';
                                                    echo ucfirst($attribute) . ': ' . $option . '<br>';
                                                endforeach;
                                            endif;
                                            ?>
                                        </p> 
                                        <p>Cantidad.: <?php echo $product['quantity']; ?></p>
                                    </div>
                                </li>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                    <ul class="total">
                        <li class="font14"><label>Total Parcial: </label><span><?php echo Site::instance()->price($cart['amount']['items'], 'code_view'); ?></span></li>     
                        <li><label> Envío Estimado: </label><span id="shipping_total"><?php echo $cart_shipping == -1 ? Site::instance()->price($site_shipping[1]['price'], 'code_view') : Site::instance()->price($cart_shipping, 'code_view'); ?></span></li>
                        <?php
                        if ($cart['amount']['coupon_save'] + $cart['amount']['point'] > 0):
                            ?>
                            <li><label>Pagar Con Copónes Y Puntos: </label><span><?php echo Site::instance()->price($cart['amount']['coupon_save'] + $cart['amount']['point'], 'code_view'); ?></span></li>
                            <?php
                        endif;
                        $saving = $cart['amount']['items'] + $cart['amount']['shipping'] - $cart['amount']['total'];
                        $item_saving = round($saving - $cart['amount']['coupon_save'] - $cart['amount']['point'], 2);

                        if ($item_saving > 0):
                            ?>
                            <li><label>Item Ahorros: </label><span><?php echo Site::instance()->price($item_saving, 'code_view'); ?></span></li> 
                            <?php
                        endif;
                        ?>
                        <li class="total_num font14"><label>Total: </label><span id="totalPrice" class="font18"><?php echo $cart['amount']['shipping'] ? Site::instance()->price($cart['amount']['total'], 'code_view') : Site::instance()->price($cart['amount']['total'] + $default_shipping, 'code_view'); ?></span></li>
                        <?php
                        if ($saving):
                            ?>
                            <li class="last red"><label>Ahorros: </label><span><?php echo Site::instance()->price($saving, 'code_view'); ?></span></li>
                            <?php
                        endif;
                        ?>
                    </ul>
                </div>
            </div>
        </section>
    </section>
</section>
<div class="hide" id="cart_delete" style="position: fixed;padding: 10px 10px 20px; top: 170px;left: 400px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border:1px solid #cdcdcd;">
    <div style="font-size: 1.4em;margin-top:0px;border-bottom: 2px solid #F4F4F4;">CONFIRMAR ACCIÓN</div>

    <div class="order order_addtobag center" style="margin:20px;">
        <div style="font-size:13px;margin-bottom: 20px;">¿ Estás seguro de que quieres borrar esto? No se puede deshacer.</div>
        <form action="<?php echo LANGPATH; ?>/cart/delete_address" method="post">
            <input type="hidden" name="address_id" id="address_id" value="" />
            <input type="submit" class="view_btn btn26" value="ELELIMINAR" />
            <a href="#" class="cancel" style="text-decoration:underline;margin-left:10px;">Cancelar</a>
        </form>
    </div>
    <div class="clsbtn" style="right: -0px;top: 3px;"></div>
</div>
<script type="text/javascript">
    $(function(){
        $(".shipping_addresscon, .shipping_address .radio").click(function(){
            $(this).parent().find('a').removeClass('JS_shows1');
            $(this).parent().siblings().find('a').addClass('JS_shows1').hide();
        })
        
        $(".add_new").click(function(){
            $("#addnewform").show();
            $('.shipping_address li').removeClass('selected');
            $("#shipping_firstname").val('');
            $("#shipping_lastname").val('');
            $("#shipping_address").val('');
            $("#shipping_country").val('');
            $(".s_state").val('');
            $("#shipping_state").val('');
            $("#shipping_city").val('');
            $("#shipping_zip").val('');
            $("#shipping_phone").val('');
            $(".states2 .all2").hide();
            $("html,body").animate({scrollTop:$("#selectNew").offset().top},500);
        })
        
        $(".JS_select").click(function(){
            $("#addnewform").hide();
            var id = $(this).attr('value');
            $.ajax({
                type: "POST",
                url: "/address/ajax_data",
                dataType: "json",
                data: "id="+id,
                success: function(addresses){
                    if(addresses)
                    {
                        $("#shipping_firstname").val(addresses['firstname']);
                        $("#shipping_lastname").val(addresses['lastname']);
                        $("#shipping_address").val(addresses['address']);
                        $("#shipping_country").val(addresses['country']);
                        $(".s_state").val(addresses['state']);
                        $("#shipping_state").val(addresses['state']);
                        $("#shipping_city").val(addresses['city']);
                        $("#shipping_zip").val(addresses['firstname']);
                        $("#shipping_phone").val(addresses['phone']);
                        if(addresses['country'] == "BR")
                        {
                            $("#shipping_cpf input").val(addresses['cpf']);
                            $("#shipping_cpf").show();
                        }
                        $(".states2 .all2").hide();
                        var s_name = 'all2_'+addresses['country'];
                        if(document.getElementById(s_name))
                        {
                            $(".states2 #"+s_name).show();
                        }
                        else
                        {
                            $("#all2_default").show();
                        }
                    }
                }
            });
        })
        
        $(".edit_address").click(function(){
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
                            $("#all1_default .all1").show();
                        }
                    }
                    var top = getScrollTop();
                    top = top - 35;
                    $('body').append('<div class="JS_filter2 opacity"></div>');
                    $('.JS_popwincon2').css({
                        "top": top, 
                        "position": 'absolute'
                    });
                    $('.JS_popwincon2').appendTo('body').fadeIn(320);
                    $('.JS_popwincon2').show();
                    return false;
                }
            });
            return false;
        })
        
        $(".delete_address").live('click', function(){
            $('body').append('<div id="wingray1" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
            $('#cart_delete').appendTo('body').fadeIn(320);
            var id = $(this).attr('title');
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
        $(".shipping_methods .radio").click(function(){
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
                                        required: "Por favor, Introduzca su nombre de pila.",
                                        maxlength:"El primer nombre que supera la longitud máxima de 50 caracteres."
                                    },
                                    shipping_lastname: {
                                        required: "Por favor, introduzca su apellido.",
                                        maxlength:"El Apellido que supera la longitud máxima de 50 caracteres."
                                    },
                                    shipping_address: {
                                        required: "Por favor, introduzca su dirección.",
                                        maxlength:"El dirección que supera la longitud máxima de 200 caracteres."
                                    },
                                    shipping_zip: {
                                        required: "Introduzca su código postal.",
                                        maxlength:"El código postal que supera la longitud máxima de 50 caracteres."
                                    },
                                    shipping_city: {
                                        required: "Ingrese su cuidad.",
                                        maxlength:"El cuidad que supera la longitud máxima de 50 caracteres."
                                    },
                                    shipping_country: {
                                        required: "Por favor elija su país.",
                                        maxlength:"El país que supera la longitud máxima de 50 caracteres."
                                    },
                                    shipping_state: {
                                        required: "Introduzca su dirección de Condado / Provincia / Estado.",
                                        maxlength:"El Condado que supera la longitud máxima de 50 caracteres."
                                    },
                                    shipping_phone: {
                                        required: "Introduzca su teléfono.", 
                                        maxlength:"El teléfono que supera la longitud máxima de 50 caracteres."
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
                                        required: "Por favor, Introduzca su nombre de pila.",
                                        maxlength:"El primer nombre que supera la longitud máxima de 50 caracteres."
                                    },
                                    shipping_lastname: {
                                        required: "Por favor, introduzca su apellido.",
                                        maxlength:"El Apellido que supera la longitud máxima de 50 caracteres."
                                    },
                                    shipping_address: {
                                        required: "Por favor, introduzca su dirección.",
                                        maxlength:"El dirección que supera la longitud máxima de 200 caracteres."
                                    },
                                    shipping_zip: {
                                        required: "Introduzca su código postal.",
                                        maxlength:"El código postal que supera la longitud máxima de 50 caracteres."
                                    },
                                    shipping_city: {
                                        required: "Ingrese su cuidad.",
                                        maxlength:"El cuidad que supera la longitud máxima de 50 caracteres."
                                    },
                                    shipping_country: {
                                        required: "Por favor elija su país.",
                                        maxlength:"El país que supera la longitud máxima de 50 caracteres."
                                    },
                                    shipping_state: {
                                        required: "Introduzca su dirección de Condado / Provincia / Estado.",
                                        maxlength:"El Condado que supera la longitud máxima de 50 caracteres."
                                    },
                                    shipping_phone: {
                                        required: "Introduzca su teléfono.", 
                                        maxlength:"El teléfono que supera la longitud máxima de 50 caracteres."
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
                                        required: "Por favor, Introduzca su nombre de pila.",
                                        maxlength:"El primer nombre que supera la longitud máxima de 50 caracteres."
                                    },
                                    billing_lastname: {
                                        required: "Por favor, introduzca su apellido.",
                                        maxlength:"El Apellido que supera la longitud máxima de 50 caracteres."
                                    },
                                    billing_address: {
                                        required: "Por favor, introduzca su dirección.",
                                        maxlength:"El dirección que supera la longitud máxima de 200 caracteres."
                                    },
                                    billing_zip: {
                                        required: "Introduzca su código postal.",
                                        maxlength:"El código postal que supera la longitud máxima de 50 caracteres."
                                    },
                                    billing_city: {
                                        required: "Ingrese su cuidad.",
                                        maxlength:"El cuidad que supera la longitud máxima de 50 caracteres."
                                    },
                                    billing_country: {
                                        required: "Por favor elija su país.",
                                        maxlength:"El país que supera la longitud máxima de 50 caracteres."
                                    },
                                    billing_state: {
                                        required: "Introduzca su dirección de Condado / Provincia / Estado.",
                                        maxlength:"El Condado que supera la longitud máxima de 50 caracteres."
                                    },
                                    billing_phone: {
                                        required: "Introduzca su teléfono.", 
                                        maxlength:"El teléfono que supera la longitud máxima de 50 caracteres."
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