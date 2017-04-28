<!-- <script src="//cdn.optimizely.com/js/557241246.js"></script> -->
<link type="text/css" rel="stylesheet" href="/css/cart.css" media="all" />
<div class="cart_header">
    <div class="layout">
        <a href="/" class="logo"><img src="/images/logo.png" /></a>
        <?php
        $has_address = (isset($cart['shipping_address']) AND !empty($cart['shipping_address'])) ? 1 : 0;
        ?>
        <div class="cart_step" id="payment_step1" <?php if($has_address) echo 'style="display:none";' ?>>
            <h2><img src="/images/payment_step1.png" /></h2>
            <div class="cart_step_bottom">
                <span class="on">Shipping & Delivery</span>
                <span>Payment & Confirmation</span>
                <span>Order Placement</span>
            </div>
        </div>
        <div class="cart_step" id="payment_step2" <?php if(!$has_address) echo 'style="display:none";' ?>>
            <h2><img src="/images/payment_step2.png" /></h2>
            <div class="cart_step_bottom">
                <span>Shipping & Delivery</span>
                <span class="on">Payment & Confirmation</span>
                <span>Order Placement</span>
            </div>
        </div>
        <a href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en" target="_blank"><img src="/images/card3.png" /></a>
    </div>
</div>
<div class="JS_popwincon2 popwincon popwincon_user hide">
    <a class="JS_close3 close_btn2"></a>
    <form action="/cart/edit_shipping" method="post" class="form user_share_form user_form" onsubmit="return setShipping(this);">
        <?php
        $cart_shipping = !empty($cart['shipping']) ? $cart['shipping']['price'] : -1;
        $default_shipping = 0;
        ?>
        <input type="hidden" id="shipping_price" value="<?php echo $default_shipping; ?>" name="shipping_price" />
        <div class="shipping_methods s_price_list">
            <ul class="fix">
                <?php
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
                }
                foreach ($site_shipping as $key => $price)
                {
                    ?>
                    <li>
                        <input type="radio" name="sprice" value="<?php echo $price['price']; ?>" id="sprice_radios<?php echo $key; ?>" class="radio" <?php if ($price['price'] == $default_shipping) echo 'checked'; ?> onclick="change_sprice(<?php echo $price['price']; ?>);" />
                        <label for="sprice_radios<?php echo $key; ?>"><?php echo $price['name'] . ' ( ' . Site::instance()->price($price['price'], 'code_view') . ' )'; ?></label>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <p><input type="submit" value="submit" class="btn30_14_black" /></p>
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
    <section class="layout">
        <section class="cart fix">
            <article class="shipping_delivery_left">
                <h3>SHIPPING INFORMATION</h3>
                <div class="shipping_bottom_line">
                    <div class="arrow-down"></div>
                </div>
                <?php
                $cart_shipping = !empty($cart['shipping']) ? $cart['shipping']['price'] : -1;
                $count_address = count($addresses);
                $show_address = $has_address AND isset($cart['shipping']['price']) ? 1 : 0;
                if ($show_address)
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
                }
                    ?>
                    <div id="shippingAddressInfo" <?php if (!$show_address) echo 'style="display:none;"'; ?>>
                        <div class="information_con">
                            <dl id="shipping_address_list">
                            <?php
                            if ($has_address)
                            {
                            ?>
                                <dt>
                                    Shipping Address  <a href="javascript:;" class="a_red JS_popwinbtn1" onclick="return edit_address(<?php echo $cart['shipping_address']['shipping_address_id']; ?>, 1);">Edit</a>
                                    <?php
                                    if($count_address > 1)
                                    {
                                    ?>
                                        <a href="javascript:;" class="a_red" onclick="return change_address_show();">Change</a>
                                    <?php
                                    }
                                    ?>
                                </dt>
                                <dd class="fix"><label>Name:</label><span><?php echo $cart['shipping_address']['shipping_firstname'] . ' ' . $cart['shipping_address']['shipping_lastname']; ?></span></dd>
                                <dd class="fix"><label>Tel:</label><span><?php echo $cart['shipping_address']['shipping_phone']; ?></span></dd>
                                <dd class="fix"><label>Address:</label><span><?php echo $cart['shipping_address']['shipping_address'] . ' ' . $cart['shipping_address']['shipping_city'] . ', ' . $cart['shipping_address']['shipping_state'] . ' ' . $shipping_country . ' ' . $cart['shipping_address']['shipping_zip']; ?></span></dd>
                            <?php
                            }
                            ?>
                            </dl>
                            <dl>
                                <dt>Shipping Method   <a href="javacript:;" class="a_red JS_popwinbtn2" id="ship_edit" <?php if(in_array($cart['shipping_address']['shipping_country'], $no_express_countries)) echo 'style="display:none;"'; ?>>Edit</a></dt>
                                <dd>
                                    Shipping:
                                    <c id="shipping_price_list">
                                    <?php
                                    if($show_address)
                                    {
                                        foreach ($site_shipping as $price)
                                        {
                                            if ($price['price'] == $cart_shipping)
                                            {
                                                echo $price['name'] . ' ( ' . Site::instance()->price($cart_shipping, 'code_view') . ' )';
                                            }
                                        }
                                    }
                                    ?>
                                    </c>
                                </dd> 
                            </dl>
                        </div>
                    </div>
                <div id="shippingAddressAdd" style="display:none;">
                    <dl class="shipping_add_address">
                        <dd>
                        <form action="" method="post" name="shipping_address_radio">
                            <ul class="shipping_address" id="shipping_address_ul">
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
                                        if ($value['is_default'])
                                            $default_key = $key;
                                    }
                                }
                            }
                            foreach($addresses as $key => $value)
                            {
                            ?>
                                <li id="address_li_<?php echo $value['id']; ?>">
                                    <div class="fix">
                                        <input type="radio" value="<?php echo $value['id']; ?>" name="address_id" id="radio<?php echo $key; ?>" class="radio" onclick="select_address(<?php echo $value['id']; ?>);" <?php if($cart['shipping_address']['shipping_address_id'] == $value['id']) echo 'checked="checked"'; ?> />
                                        <label for="radio<?php echo $key; ?>">
                                            <b class="s1">Address<?php echo $key + 1; ?></b>
                                            <div class="flr">
                                            <?php
                                            if ($key == $default_key)
                                            {
                                                ?>
                                                    <span class="b address_detault" id="detault_<?php echo $value['id']; ?>">Default</span>
                                                    <a href="javascript:;" class="a_underline address_detault_a" id="address_detault_<?php echo $value['id']; ?>" onclick="default_address(<?php echo $value['id']; ?>);" style="display:none;">Set Default</a>
                                                    <a href="javascript:;" class="view_btn btn40 JS_popwinbtn1" onclick="edit_address(<?php echo $value['id']; ?>, 1);">Edit</a>
                                                    <a href="javascript:;" class="view_btn btn26 delete_address" onclick="delete_address(<?php echo $value['id']; ?>);">Delete</a>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                    <span class="b address_detault" id="detault_<?php echo $value['id']; ?>" style="display:none;">Default</span>
                                                    <a href="javascript:;" class="a_underline address_detault_a" id="address_detault_<?php echo $value['id']; ?>" onclick="default_address(<?php echo $value['id']; ?>);">Set Default</a>
                                                    <a href="javascript:;" class="view_btn btn40 JS_popwinbtn1" onclick="edit_address(<?php echo $value['id']; ?>, 1);">Edit</a>
                                                    <a href="javascript:;" class="view_btn btn26 delete_address" onclick="delete_address(<?php echo $value['id']; ?>);">Delete</a>
                                                <?php
                                            }
                                            ?>
                                            </div>
                                            <p class="bottom" id="address_list_<?php echo $value['id']; ?>">
                                                <span><?php echo $value['firstname'] . ' ' . $value['lastname']; ?></span>
                                                <span class="tel"><?php echo $value['phone']; ?></span>
                                                <span><?php echo $value['address'] . ', ' . $value['city'] . ', ' . $value['state'] . ', ' . $value['country'] . ', ' . $value['zip']; ?></span>
                                            </p>
                                        </label>
                                    </div>
                                    
                                </li>
                            <?php
                            }
                            ?>
                            </ul>
                            <ul class="shipping_address" style="margin: 0;padding: 0 10px 10px 10px;">
                                <li class="fix last">
                                    <a href="javascript:;" class="a_underline JS_popwinbtn1" id="add_new_address" onclick="return new_address_show();">+Add a New Address</a>
                                </li>
                            </ul>
                            </form>
                        </dd>
                    </dl>
                </div>
                <div id="shippingAddressFill" <?php if($has_address) echo 'style="display:none;";' ?>>
                    <h4>Shipping Address</h4>
                    <form action="" method="post" class="form user_share_form form2" onsubmit="return update_address(this);">
                        <input type="hidden" name="is_cart" value="1" />
                        <ul class="add_showcon_boxcon">
                            <li>
                                <label><span>*</span> First Name:</label>
                                <input type="text" value="" name="firstname" id="s_firstname" class="text text_long" />
                            </li>
                            <li>
                                <label><span>*</span> Last Name:</label>
                                <input type="text" value="" name="lastname" id="s_lastname" class="text text_long" />
                            </li>
                            <li>
                                <label><span>*</span> Address:</label>
                                <div>
                                    <textarea class="textarea_long" name="address" id="s_address"></textarea>
				<label class="a1 error" style="display:none;"  generated="true" id="guo_con1">Please choose your country.</label>
                                </div>
                            </li>
                            <li>
                                <label><span>*</span> Country:</label>
                                <select name="country" class="select_style selected304" id="s_country" onchange="changeSelectCountry1();$('#billing_country').val($(this).val());">
                                    <option value="">SELECT A COUNTRY</option>
                                    <?php if (is_array($countries_top)): ?>
                                        <?php foreach ($countries_top as $country_top): ?>
                                            <option value="<?php echo $country_top['isocode']; ?>"><?php echo $country_top['name']; ?></option>
                                        <?php endforeach; ?>
                                        <option disabled="disabled">———————————</option>
                                    <?php endif; ?>
                                    <?php foreach ($countries as $country): ?>
                                        <option value="<?php echo $country['isocode']; ?>" ><?php echo $country['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </li>
                            <li class="states2">
                                <?php
                                $stateCalled = Kohana::config('state.called');
                                foreach ($stateCalled as $name => $called)
                                {
                                    ?>
                                    <div class="call2" id="call2_<?php echo $name; ?>" <?php if ($name != 'Default') echo 'style="display:none;"'; ?>>
                                        <label for="state"><span>*</span> <font id=""><?php echo $called; ?></font>:</label>
                                    </div>
                                    <?php
                                }
                                $stateArr = Kohana::config('state.states');
                                foreach ($stateArr as $country => $states)
                                {
                                    if($country == "US")
                                    {
                                        $enter_title = 'Enter a State';
                                    }
                                    else
                                    {
                                        $enter_title = 'Enter a County or Province';
                                    }
                                    ?>
                                    <div class="all2 JS_drop" id="all2_<?php echo $country; ?>" style="display:none;">
                                        <select name="" class="select_style selected304 s_state" onblur="$('#billing_state1').val($(this).val());" onchange="acecoun()">
                                            <option value="">[Select One]</option>
                                            <option value=" " class="state_enter">[<?php echo $enter_title; ?>]</option>
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
                                    <input type="text" name="state" id="s_state" class="text text_long" value="" maxlength="320" onchange="acecoun()"  />
                                    <div class="errorInfo"></div>
					<label class="error a3" style="display:none;"  generated="true" id="guo_don1">Please choose your country.</label>
                                </div>
                                <script>
                                    var no_express_countries = new Array();
                                    no_express_countries = <?php echo json_encode($no_express_countries); ?>;
                                    function changeSelectCountry1(){
                                        var select = document.getElementById("s_country");
                                        var countryCode = select.options[select.selectedIndex].value;
                                        if(in_array(countryCode, no_express_countries))
                                        {
                                            document.getElementById("shipping_price_li1").style.display = 'none';
                                            document.getElementById("price_radio2").checked = true;
                                        }
                                        else
                                        {
                                            document.getElementById("shipping_price_li1").style.display = 'inline';
                                        }
                                        if(countryCode == 'BR')
                                        {
                                            $("#shipping_cpf").show();
                                        }
										else if(countryCode == 'HK' || countryCode == 'MO' || countryCode == 'TW')
										{	
						
											var aa = $("#guo_con1");
												aa.show();
											aa.html('請輸入中文地址(Please enter the address in Chinese.)');
										}
                                        else
                                        {
                                            $("#shipping_cpf").hide();
											$("#guo_con1").hide();
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
                                <label><span>*</span> City / Town:</label>
                                <input type="text" value="" name="city" id="s_city" class="text text_long" onchange="acedoun()"   />
								<label class="error a4" style="display:none;"  generated="true" id="guo_eon1">Please choose your country.</label>
                            </li>
                            <li>
                                <label><span>*</span> Zip / Postal Code:</label>
                                <input type="text" value="" name="zip" id="s_zip" class="text text_long"  onchange="ace()"  />
				<label class="error" style="display:none;" generated="true" id="guo_fon1">Please choose your country.</label>
				<p class="phone_tips">If there is no zip code in your area, please enter 0000 instead.</p>	
                            </li>
                            <li>
                                <label><span>*</span> Phone:</label>
                                <input type="text" value="" name="phone" id="s_phone" class="text text_long" />
                            </li>
                            <li id="shipping_cpf" class="hide">
                                <label><span>*</span>o cadastro de pessoa Física:</label>
                                <input type="text" name="cpf" id="s_cpf" class="text text_long" value="" />
                            </li>
                        </ul>
                        <h4 class="mt10">SHIPPING METHODS</h4>
                        <div class="shipping_methods s_price_list">
                            <ul class="fix">
                            <?php
                            foreach($site_shipping as $key => $price)
                            {
                            ?>
                                <li id="shipping_price_li<?php echo $key; ?>">
                                  <input type="radio" name="shipping_price1" value="<?php echo $price['price']; ?>" id="price_radio<?php echo $key; ?>" class="radio" <?php if($key == 2) echo 'checked="checked"'; ?> onclick="document.getElementById('new_shipping_price').value = <?php echo $price['price']; ?>;" /> 
                                    <label for="price_radio<?php echo $key; ?>">
                                        <?php echo $price['name'] . ' ( ' . Site::instance()->price($price['price'], 'code_view') . ' )'; ?>
                                  </label>
                                </li>
                            <?php
                            }
                            ?>
                            </ul>
                            <input type="hidden" name="shipping_price" id="new_shipping_price" value="<?php echo $default_shipping; ?>" />
                        </div>
                        <p><input id="spgInfoCountinue" type="submit" value="COUNTINUE" class="view_btn btn40 font18" /></p>
                    </form>
                </div>
                <div id="paymentInfo" <?php if(!$has_address) echo 'style="display:none;"'; ?>>
                    <h3 class="mt50">PAYMENT INFO</h3>
                    <div class="shipping_bottom_line">
                        <div class="arrow-down"></div>
                    </div>
                    <form id="payment_form" method="post" action="" class="form form_box">
                        <dl class="shipping_payment">
                        <?php
                        // currency BRL,ARS,SAR Paypal hide
                        $no_paypal = 0;
                        // $currencys = array('BRL', 'ARS', 'SAR');
                        // $currency_now = Site::instance()->currency();
                        // if(in_array($currency_now['name'], $currencys))
                        //     $no_paypal = 1;
                        if(!$no_paypal)
                        {
                        ?>
                            <dd class="shipping_methods">
                              <input type="radio" value="PP" id="radio_2" class="radio" name="payment_method" checked="" />
                              <label for="radio_2">
                                <h4>PayPal</h4><br />
                                <img class="ml20" src="/images/card1.jpg" /></label>
                                <!-- <p>If you don't have a PayPal account, you can also pay via PayPal with your credit card or bank debit card.</p> -->
                                <!-- <p>Note: you can send money to <strong>paypal@choies.com</strong> directly if your payment fails.</p> -->
                            </dd>
                        <?php
                        }
                        ?>
                            <dd class="shipping_methods">
                              <input type="radio" value="GC" id="radio_1" class="radio" name="payment_method" <?php if($no_paypal) echo 'checked="checked"'; ?> />
                              <label for="radio_1">
                                <h4>Credit or Debit Card</h4><br />
                                <!-- <p>We accept the following credit/debit cards. Please enter to the next page to finish your payment.</p> -->
                                <img class="ml20" src="/images/card10.jpg" /></label>
                            </dd>
                            <dd class="shipping_methods" id="sofort_banking" <?php if(!array_key_exists($cart['shipping_address']['shipping_country'], $sofort_countries)) echo 'style="display:none;";' ?>>
                              <input type="radio" value="SOFORT" id="radio_3" class="radio" name="payment_method"/>
                              <label for="radio_3">
                                <h4>SOFORT BANKING</h4><br />
                                <img class="ml20" src="/images/card12.jpg" /></label>
                            </dd>
                            <dd class="shipping_methods" id="ideal" <?php if($cart['shipping_address']['shipping_country'] != 'NL') echo 'style="display:none;";' ?>>
                              <input type="radio" value="IDEAL" id="radio_4" class="radio" name="payment_method"/>
                              <label for="radio_4">
                                <h4>iDEAL</h4><br />
                                <img class="ml20" src="/images/card13.jpg" /></label>
                            </dd>
                        </dl>
                        <p>
                            <input type="submit" class="btn40_16_red" value="Proceed to checkout" />
                        </p>
                    </form>
                </div>
            </article>
            
            <!-- order_summary -->
            <div class="order_summary flr">
                <h3>YOUR ORDER SUMMARY</h3>
                <ul class="pro_con1">
                    <?php
                    $ecomm_prodid = array();
                    $p_saving = 0;
                    foreach (array_reverse($cart['products']) as $key => $product):
                        $sku = Product::instance($product['id'])->get('sku');
                        $ecomm_prodid[] = "'$sku'";
                        $name = Product::instance($product['id'])->get('name');
                        $img = Product::instance($product['id'])->cover_image();
                        ?>
                        <li class="fix">
                            <div class="left"><img src="<?php echo '/pimages1/' . $img['id'] . '/3.' . $img['suffix']; ?>" alt="<?php echo $name; ?>" /></div>
                            <div class="right">
                                <p class="name"><?php echo $name; ?></p>
                                <p class="color666">Item: #<?php echo $sku; ?></p>
                                <b class="font14"><?php echo Site::instance()->price($product['price'], 'code_view'); ?></b>
                                <p>
                                    <?php
                                    $delivery_time = kohana::config('prdress.delivery_time');
                                    if (isset($product['attributes'])):
                                        foreach ($product['attributes'] as $attribute => $option):
                                            if ($attribute == 'delivery time')
                                                $option = $option > 0 ? 'Rush Order' . ' ( + ' . Site::instance()->price($option, 'code_view') . ' )' : 'Regular Order';
                                            echo ucfirst($attribute) . ': ' . $option . '<br>';
                                        endforeach;
                                    endif;
                                    ?>
                                </p> 
                                <p>Qty.: <?php echo $product['quantity']; ?></p>
                            </div>
                        </li>
                        <?php
                        $p_saving += Product::instance($product['id'])->get('price') - $product['price'];
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
                                    <p>Item: #<?php echo $sku; ?></p>
                                    <p><?php echo Site::instance()->price($product['price'], 'code_view'); ?></p>
                                    <p>
                                        <?php
                                        $delivery_time = kohana::config('prdress.delivery_time');
                                        if (isset($product['attributes'])):
                                            foreach ($product['attributes'] as $attribute => $option):
                                                if ($attribute == 'delivery time')
                                                    $option = $option > 0 ? 'Rush Order' . ' ( + ' . Site::instance()->price($option, 'code_view') . ' )' : 'Regular Order';
                                                echo ucfirst($attribute) . ': ' . $option . '<br>';
                                            endforeach;
                                        endif;
                                        ?>
                                    </p> 
                                    <p>Qty.: <?php echo $product['quantity']; ?></p>
                                </div>
                            </li>
                            <?php
                            $p_saving += Product::instance($product['id'])->get('price') - $product['price'];
                        endforeach;
                    endif;
                    ?>
                </ul>
                <ul class="total">
                    <li class="font14"><label>Subtotal: </label><span><?php echo Site::instance()->price($cart['amount']['items'], 'code_view'); ?></span></li>     
                    <li><label>Estimated Shipping: </label><span id="shipping_total"><?php echo $cart_shipping == -1 ? Site::instance()->price($site_shipping[2]['price'], 'code_view') : Site::instance()->price($cart_shipping, 'code_view'); ?></span></li>
                    <?php
                    $coupon_points_save = 0;
                    if ($cart['amount']['coupon_save'] + $cart['amount']['point'] > 0)
                    {
                        $coupon_points_save = $cart['amount']['coupon_save'] + $cart['amount']['point'];
                    }
                    ?>
                    <li id="coupon_points_save" <?php if(!$coupon_points_save) echo 'style="display:none;"'; ?>>
                        <label>Pay with Coupons & Points: </label><span id="save_total"><?php echo Site::instance()->price($cart['amount']['coupon_save'] + $cart['amount']['point'], 'code_view'); ?></span>
                    </li>
                    <?php
                    $saving = $cart['amount']['items'] + $cart['amount']['shipping'] - $cart['amount']['total'];
                    $item_saving = round($saving - $cart['amount']['coupon_save'] - $cart['amount']['point'], 2);

                    if ($item_saving > 0):
                        ?>
                        <li><label>Sale Items Saving: </label><span><?php echo Site::instance()->price($item_saving, 'code_view'); ?></span></li> 
                        <?php
                    endif;
                    ?>
                    <li class="total_num font14"><label>Total: </label><span id="totalPrice" class="font18"><?php echo $cart['amount']['shipping'] ? Site::instance()->price($cart['amount']['total'], 'code_view') : Site::instance()->price($cart['amount']['total'] + $default_shipping, 'code_view'); ?></span></li>
                    <?php
                    $saving += $p_saving;
                    if($saving <= 0)
                        $saving = 0;
                    ?>
                    <li class="last red"><label>Saving: </label><span id="cart_saving"><?php echo Site::instance()->price($saving, 'code_view'); ?></span></li>
                        
                </ul>       
                <div class="promo-choies">
                    <ul>
                        <li class="promo-code">
                            <div class="pc-apply">Have a Promo Code? <a href="javascript:;" title="Apply it now">Apply it now </a>
                                <em class="icon_tips JS_shows_btn1">
                                    <span class="JS_shows1 icon_tipscon" style="display: none;">
                                        Note: 1. The product with "% off" icon cannot be combined   with any coupon code.
                                        <i>2. Please enter the coupon code with no space.</i>
                                    </span>
                                </em>
                            </div>
                            <div class="pc-ibutton" style="display:none;">
                                <form method="post" action="/cart/set_coupon" onsubmit="return setCoupon();">
                                    <input type="hidden" name="return_url" value="<?php echo LANGPATH ?>/cart/checkout" />
                                    <input id="coupon_code" name="coupon_code" class="input-promo-code fll" type="text" value="">
                                    <button type="submit" class="btn-promo-code btn22_black flr">Apply</button>
                                </form>
                                <a class="J_pop_btn a_underline flr">Code list</a>
                                <!-- codelist_con -->
                                <div class="codelist_con J_popcon hide" id="available_codes">
                                    <span class="close_btn"></span>
                                    <div class="tit"><h3>Available Codes</h3></div>
                                    <?php
                                    if (count($codes) > 0):
                                        echo '<ul class="list_con">';
                                        foreach ($codes as $code):
                                            ?>
                                            <li><a href="javascript:;" onclick="choice_coupon('<?php echo $code['code']; ?>');"><?php echo $code['code']; ?></a></li>
                                            <?php
                                        endforeach;
                                        echo '</ul>';
                                    else:
                                        ?>
                                        <div class="codenone">No Available Codes.</div> 
                                    <?php
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </li>
                        <li class="promo-code">
                            <div class="pc-apply">Have Choies Points?<a href="javascript:;" title="Use it Now">Use Now </a>
                                <em class="icon_tips JS_shows_btn1">
                                    <span class="JS_shows1 icon_tipscon hide" style="display: none;">You may apply Points equaling up to only 10% of your order value. <br>Complete your profile, you will be awarded 500 points to redeem your first order.</span>
                                </em>
                            </div>
                            <div class="pc-ibutton" style="display:none;">
                                <form method="post" action="/cart/point" class="form" id="point_form" onsubmit="return setPoints();">
                                    <input type="hidden" name="return_url" value="<?php echo LANGPATH ?>/cart/checkout" />
                                    <?php $is_celebrity = Customer::instance($customer_id)->is_celebrity(); ?>
                                    <input id="points" name="points" class="input-promo-code fll" type="text" value="<?php if (!$is_celebrity && $points_avail > 0) echo $points_avail; ?>" onkeydown="return point2dollar();">
                                    <button type="submit" class="btn-promo-code btn22_black flr" onclick="return point_redeem();">Redeem</button>
                                </form>
                                <div class="color666 fll mt5">
                                Save: <span class="red">$ <span  id="dollar">0</span></span><br>
                                    (10 Points=$0.1)  
                                    <?php
                                    if ($points_avail >= 0):
                                        ?>
                                        <span class="red"><?php echo $points_avail; ?></span> points can be used for this time.
                                        <?php
                                    else:
                                        echo 'To use your points, please shop at least $10+.';
                                    endif;
                                    ?>
                                    <a class="a_underline JS_popwinbtn" style="display: inline;">VIP Policy</a>
                                </div>
                                <script type="text/javascript">
                                    var xhr = null;
                                    var amount_left = $('#amount_left').text();
                                
                                    function point_redeem()
                                    {
                                        var points = parseFloat(document.getElementById('points').value);
                                        if (points > <?php print $points_avail; ?>) {
                                            window.alert('Not enough points available');
                                            return false;
                                        }
                                        else
                                        {
                                            // $('#point_form').submit();
                                            // return false;
                                        }
                                    }
                                
                                    function point2dollar()
                                    {
                                        var point = document.getElementById('points');
                                        var dollar = document.getElementById('dollar');
                                        return window.setTimeout(function(){
                                            if (!parseInt(point.value)) {
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
                        </li>
                    </ul>              
                </div>
              
                <div class="additional-payment mt20">
                    <form action="/cart/set_message" method="post" class="form user-message" onsubmit="return setMessage();">
                        <input type="hidden" name="return_url" value="<?php echo LANGPATH; ?>/cart/checkout" />
                        <input type="hidden" name="message_change" value="" id="message_change" />
                        <label style="font-weight: bold;">Message: </label>
                        <br /><label style="color:#878787;height:20px;">(5-100 characters)</label>
                        <div class="right_box">
                            <textarea class="textarea_long" maxlength="150" minlength='5' id="set_message" name="message" style="width: 262px; height: 63px;color: #878787;background-color: #fff;<?php if($cart_message) echo 'display:none;'; ?>"  onkeydown="return messageChange();" 
                            style="color:#878787" onfocus="if(this.value=='Leave any message regarding order placement, product change or delivery options. All messages will be responded within 24 hours.') 
                            {this.value='';}this.style.color='#000';" onblur="if(this.value=='') {this.value='Leave any message regarding order placement, product change or delivery options. All messages will be responded within 24 hours.';this.style.color='#878787';}"
                            ><?php if($cart_message) {echo $cart_message;} else { echo 'Leave any message regarding order placement, product change or delivery options. All messages will be responded within 24 hours.'; } ?></textarea>
                            <p id="now_message" style="font-style: normal;font-weight: normal;color:#666;<?php if(!$cart_message) echo 'display:none;'; ?>">
                            <?php if($cart_message) echo $cart_message; ?>
                            </p>
                            <a href="javascript:;" onclick="editMessage();" id="message_edit" style="text-decoration: underline;<?php if(!$cart_message) echo 'display:none;'; ?>">Edit</a>
                            <button class="btn-promo-code btn22_black fll mt5" type="submit" id="message_submit" <?php if($cart_message) echo 'style="display:none;"'; ?>>Submit</button>
                        </div>
                    </form>
                    <p style="margin-top:40px;">Additional payment security with:</p>
                    <img src="/images/card11.jpg" />
                    <div id="paypal_shipping_refund">
                    <?php
                    $show_img = '';
                    if(isset($cart['shipping_address']['shipping_country']))
                    {
                        $now_country = $cart['shipping_address']['shipping_country'];
                        $show_img = isset($paypal_refund_config[$now_country]) ? $paypal_refund_config[$now_country] : '';
                    }
                    ?>
                        <a target="_blank" href="https://www.paypal.eu/returns/" class="en" <?php if($show_img != 'en') echo 'style="display:none;"'; ?>><img src="/images/paypal_refund_en.jpg" /></a>
                        <a target="_blank" href="https://www.paypal.fr/retours/" class="fr" <?php if($show_img != 'fr') echo 'style="display:none;"'; ?>><img src="/images/paypal_refund_fr.jpg" /></a>
                        <a target="_blank" href="https://www.paypal.eu/returns/" class="ru" <?php if($show_img != 'ru') echo 'style="display:none;"'; ?>><img src="/images/paypal_refund_ru.jpg" /></a>
                        <a target="_blank" href="https://www.paypal.es/devoluciones/" class="es" <?php if($show_img != 'es') echo 'style="display:none;"'; ?>><img src="/images/paypal_refund_es.jpg" /></a>
                        <a target="_blank" href="https://www.paypal.eu/ch/retourenserviceaktivieren/" class="de" <?php if($show_img != 'de') echo 'style="display:none;"'; ?>><img src="/images/paypal_refund_de.jpg" /></a>
                    </div>
                </div>
            </div>
        </section>
  </section>
</section>
<div class="JS_popwincon1 popwincon popwincon_user hide" id="new_address_list">
    <a class="JS_close2 close_btn2"></a>
    <form onsubmit="return update_address(this);" method="post" class="form user_share_form user_form form1">
        <input type="hidden" name="address_id" id="shipping_address_id" value="<?php echo $cart['shipping_address']['shipping_address_id']; ?>" />
        <input type="hidden" name="is_cart" id="is_cart" value="1" />
        <ul class="add_showcon_boxcon">
            <li>
                <label><span>*</span> First Name:</label>
                <input type="text" value="<?php echo $cart['shipping_address']['shipping_firstname']; ?>" name="firstname" id="shipping_firstname" class="text text_long" />
            </li>
            <li>
                <label><span>*</span> Last Name:</label>
                <input type="text" value="<?php echo $cart['shipping_address']['shipping_lastname']; ?>" name="lastname" id="shipping_lastname" class="text text_long" />
            </li>
            <li>
                <label><span>*</span> Address:</label>
                <div>
                    <textarea class="textarea_long" name="address" id="shipping_address"  onchange="ace2()" ><?php echo $cart['shipping_address']['shipping_address']; ?></textarea>
				<label class="a1 error" style="display:none;"  generated="true" id="guo_con">Please choose your country.</label>
                </div>
            </li>
            <li>
                <label><span>*</span> Country:</label>
                <select name="country" class="select_style selected304" id="shipping_country" onchange="changeSelectCountry2();$('#billing_country').val($(this).val());">
                    <option value="">SELECT A COUNTRY</option>
                    <?php if (is_array($countries_top)): ?>
                        <?php foreach ($countries_top as $country_top): ?>
                            <option value="<?php echo $country_top['isocode']; ?>"><?php echo $country_top['name']; ?></option>
                        <?php endforeach; ?>
                        <option disabled="disabled">———————————</option>
                    <?php endif; ?>
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
                    ?>
                    <div class="call2" id="call2_<?php echo $name; ?>" <?php if ($name != 'Default') echo 'style="display:none;"'; ?>>
                        <label for="state"><span>*</span> <font id=""><?php echo $called; ?></font>:</label>
                    </div>
                    <?php
                }
                $stateArr = Kohana::config('state.states');
                foreach ($stateArr as $country => $states)
                {
                    if($country == "US")
                    {
                        $enter_title = 'Enter a State';
                    }
                    else
                    {
                        $enter_title = 'Enter a County or Province';
                    }
                    ?>
                    <div class="all2 JS_drop" id="all2_<?php echo $country; ?>" style="display:none;">
                        <select name="" class="select_style selected304 s_state" id="s_state" onblur="$('#billing_state1').val($(this).val());" onchange="acecoun()">
                            <option value="">[Select One]</option>
                            <option value=" " class="state_enter">[<?php echo $enter_title; ?>]</option>
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
                <div id="all2_default">
                    <input type="text" name="state" id="shipping_state" class="all2 text text_long" value="<?php echo $cart['shipping_address']['shipping_state']; ?>" maxlength="320" onchange="acecoun()" />
                    <div class="errorInfo"></div>
					<label class="error a3" style="display:none;"  generated="true" id="guo_don">Please choose your country.</label>
                </div>
                <script>
                    function changeSelectCountry2(){
                        var select = document.getElementById("shipping_country");
                        var countryCode = select.options[select.selectedIndex].value;
                        if(countryCode == 'BR')
                        {
                            $("#shipping_cpf").show();
							$("#guo111").hide();
                        }
						else if(countryCode == 'HK' || countryCode == 'MO' || countryCode == 'TW')
						{	
						
						var ooo = $("#guo_con");
							ooo.show();
							ooo.html('請輸入中文地址(Please enter the address in Chinese.)');
						}
                        else
                        {
                            $("#shipping_cpf").hide();
							$("#guo_con").hide();
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
							$("#guo111").hide();
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
                <label><span>*</span> City / Town:</label>

                <input type="text" value="<?php echo $cart['shipping_address']['shipping_city']; ?>" name="city" id="shipping_city" class="text text_long" onchange="acedoun()"  />
				<label class="error a4" style="display:none;"  generated="true" id="guo_eon">Please choose your country.</label>

            </li>
            <li>
                <label><span>*</span> Zip / Postal Code:</label>			
                <input type="text" value="<?php echo $cart['shipping_address']['shipping_zip']; ?>" name="zip" id="shipping_zip" class="text text_long" onchange="ace()"  />
				<label class="error" style="display:none;" generated="true" id="guo_fon">Please choose your country.</label>
				<p class="phone_tips">If there is no zip code in your area, please enter 0000 instead.</p>				
            </li>
            <li>
                <label><span>*</span> Phone:</label>               
                    <input type="text" value="<?php echo $cart['shipping_address']['shipping_phone']; ?>" name="phone" id="shipping_phone" class="text text_long" />
                    <p class="phone_tips">Please leave correct and complete phone number for accurate delivery by postman.</p>             
            </li>
            <li id="shipping_cpf" class="hide">
                <label><span>*</span>o cadastro de pessoa Física:</label>
                <input type="text" name="cpf" id="shipping_cpf" class="text text_long" value="" />
            </li>
            <li>
              <label>&nbsp;</label>
              <div class="right_box"><input type="submit" value="submit" class="btn30_14_black" /></div>
            </li>
        </ul>
        </form>
</div>
<div class="hide" id="cart_delete" style="position: fixed;padding: 10px 10px 20px; top: 170px;left: 400px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border:1px solid #cdcdcd;">
    <div style="font-size: 1.4em;margin-top:0px;border-bottom: 2px solid #F4F4F4;">CONFIRM ACTION</div>

    <div class="order order_addtobag center" style="margin:20px;">
        <div style="font-size:13px;margin-bottom: 20px;">Are you sure you want to delete this address?</div>
        <form action="/cart/delete_address" method="post" id="delete_address_form" onsubmit="return delete_address_submit();">
            <input type="hidden" name="address_id" id="address_id" value="" />
            <input type="submit" class="btn30_14_black" value="DELETE" />
            <a href="" class="cancel" style="text-decoration:underline;margin-left:10px;" onclick="return delete_close();">Cancel</a>
        </form>
    </div>
    <div class="clsbtn" style="right: -0px;top: 3px;" onclick="return delete_close();"></div>
</div>
<div class="JS_popwincon popwincon hide">
    <a class="JS_close1 close_btn2"></a>
    <div class="vip">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody><tr>
                    <th width="15%" class="first">
            <div class="r">Privileges</div>
            <div>VIP Level</div>
            </th>
            <th width="20%">Accumulated Transaction Amount</th>
            <th width="16%">Extra Discounts for Items</th>
            <th width="16%">Points Use Permissions</th>
            <th width="15%">Order Points Reward</th>
            <th width="18%">Other Privileges</th>
            </tr>
            <tr>
                <td><span class="icon_nonvip" title="Non-VIP"></span><strong>Non-VIP</strong></td>
                <td>$0</td>
                <td>/</td>
                <td rowspan="6"><div>You may apply Points equaling up to only 10% of your  order value.</div></td>
                <td rowspan="6">$1 = 1 points</td>
                <td>15% off Coupon Code</td>
            </tr>
            <tr>
                <td><span class="icon_vip" title="Diamond VIP"></span><strong>VIP</strong></td>
                <td>$1 - $199</td>
                <td>/</td>
                <td rowspan="5"><div>Get double shopping points during major holidays.<br>
                        Special birthday gift.<br>
                        And More...</div></td>
            </tr>
            <tr>
                <td><span class="icon_bronze" title="Bronze VIP"></span><strong>Bronze VIP</strong></td>
                <td>$199 - $399</td>
                <td>5% OFF</td>
            </tr>
            <tr>
                <td><span class="icon_silver" title="Silver VIP"></span><strong>Silver VIP</strong></td>
                <td>$399 - $599</td>
                <td>8% OFF</td>
            </tr>
            <tr>
                <td><span class="icon_gold" title="Gold VIP"></span><strong>Gold VIP</strong></td>
                <td>$599 - $1999</td>
                <td>10% OFF</td>
            </tr>
            <tr>
                <td><span class="icon_diamond" title="Diamond VIP"></span><strong>Diamond VIP</strong></td>
                <td>≥ $1999</td>
                <td>15% OFF</td>
            </tr>
            </tbody></table>
    </div>
</div>
<script type="text/javascript">
function change_address_show()
{
    document.getElementById('shippingAddressAdd').style.display = 'block';
    document.getElementById('shippingAddressInfo').style.display = 'none';
    $('html, body').animate({scrollTop: $('#shippingAddressAdd').offset().top}, 300);
    return false;
}

function new_address_show()
{
    document.getElementById('shipping_address_id').value = '';
    document.getElementById('shipping_firstname').value = '';
    document.getElementById('shipping_lastname').value = '';
    document.getElementById('shipping_address').value = '';
    document.getElementById('shipping_country').value = '';
    document.getElementById('shipping_state').value = '';
    document.getElementById('shipping_city').value = '';
    document.getElementById('shipping_zip').value = '';
    document.getElementById('shipping_phone').value = '';
}

function change_sprice(price)
{
    document.getElementById('shipping_price').value = price;
}

function setShipping(formObj)
{
    var datas = createData(formObj);
    $.ajax({
        type:"POST",
        url :"/cart/ajax_shipping_price",
        data:datas,
        dataType:"json",
        success:function(res){
            document.getElementById('shipping_price_list').innerHTML = '';
            document.getElementById('shipping_price_list').innerHTML = res.shipping_name;
            document.getElementById('shipping_total').innerHTML = '';
            document.getElementById('shipping_total').innerHTML = res.price;
            document.getElementById('totalPrice').innerHTML = '';
            document.getElementById('totalPrice').innerHTML = res.total;
            $(".opacity").hide();
            $(".JS_popwincon2").hide();
        }
    });
    return false;
}

function setShippingAddress(id)
{
    datas = new Object();
    datas.address_id = id;
    $.ajax({
        type:"POST",
        url :"/cart/set_address",
        data:datas,
        dataType:"json",
        success:function(datas){
        }
    });
    $(".address_edit").hide();
    $("#address_edit_" + id).show();
    // window.location.reload();
}

function default_address(id)
{
    datas = new Object();
    datas.id = id;
    $.ajax({
        type:"POST",
        url :"/address/ajax_default/",
        data:datas,
        dataType:"json",
        success:function(res){
            if(res.success == 1)
            {
                alert(res.message);
                $(".address_detault").hide();
                $(".address_detault_a").show();
                document.getElementById('address_detault_' + id).style.display = 'none';
                document.getElementById('detault_' + id).style.display = 'inline';
            }
            else
            {
                alert(res.message);
            }
        }
    });
}

function edit_address(id, is_cart)
{
    if(!id){
        return;
    }
    datas = new Object();
    datas.id = id;
    $.ajax({
        type:"POST",
        url :"/address/ajax_data",
        data:datas,
        dataType:"json",
        success:function(address){
            if(address != 0){
                document.getElementById('is_cart').value = is_cart;
                document.getElementById('shipping_address_id').value = address.id;
                document.getElementById('shipping_firstname').value = address.firstname;
                document.getElementById('shipping_lastname').value = address.lastname;
                document.getElementById('shipping_address').value = address.address;
                document.getElementById('shipping_country').value = address.country;
                document.getElementById('shipping_state').value = address.state;
                document.getElementById('s_state').value = address.state;
                document.getElementById('shipping_city').value = address.city;
                document.getElementById('shipping_zip').value = address.zip;
                document.getElementById('shipping_phone').value = address.phone;
                document.getElementById('shipping_cpf').value = address.cpf;
                
                if(address.country == 'BR')
                {
                    document.getElementById('cpf_list').style.display = 'block';
                }
            }
            else
            {
                alert('failed');
            }
        }
    });
}

function update_address(formObj)
{
    var datas = createData(formObj);
    if(!check_address(datas))
        return false;
    if (typeof(datas.shipping_price) != "undefined")
    {
        $.ajax({
            type:"post",
            url : '/address/ajax_edit1',
            data: datas,
            dataType: "json",
            success: function(result){
                if(result.success == 1){
                    var change = '';
                    if(result.count_address > 1)
                        change = '<a href="javascript:;" class="a_red" onclick="change_address_show();">Change</a>';
                    var shipping_address_list = '<dt>Shipping Address  <a href="javascript:;" class="a_red JS_popwinbtn1" onclick="return edit_address('+result.address_id+');">Edit</a>'+change+'</dt>'+
                                    '<dd class="fix"><label>Name:</label><span>'+datas.firstname+' '+datas.lastname+'</span></dd>'+
                                    '<dd class="fix"><label>Tel:</label><span>'+datas.phone+'</span></dd>'+
                                    '<dd class="fix"><label>Address:</label><span>'+datas.address+', '+datas.city+' '+datas.state+', '+datas.country+' '+datas.zip+'</span></dd>';
                    document.getElementById('shipping_address_list').innerHTML = '';
                    document.getElementById('shipping_address_list').innerHTML = shipping_address_list;
                    document.getElementById('payment_step1').style.display = 'none';
                    document.getElementById('payment_step2').style.display = 'inline-block';
                    change_paypal_refund(datas.country);

                    if(result.has_no_express)
                    {
                        document.getElementById('shipping_price_list').innerHTML = '';
                        document.getElementById('shipping_price_list').innerHTML = result.shipping_name;
                        document.getElementById('shipping_total').innerHTML = '';
                        document.getElementById('shipping_total').innerHTML = result.shipping_price;
                        document.getElementById('totalPrice').innerHTML = '';
                        document.getElementById('totalPrice').innerHTML = result.total_price;
                        document.getElementById('ship_edit').style.display = 'none';
                    }
                    else
                    {
                        document.getElementById('ship_edit').style.display = 'initial';
                    }

                    if(in_array(datas.country, sofort))
                    {
                        document.getElementById('sofort_banking').style.display = 'block';
                    }
                    else
                    {
                        document.getElementById('sofort_banking').style.display = 'none';
                    }
                    if(in_array(datas.country, ideal))
                    {
                        document.getElementById('ideal').style.display = 'block';
                    }
                    else
                    {
                        document.getElementById('ideal').style.display = 'none';
                    }

                    var new_address_li = '<li id="address_li_'+result.address_id+'">'+
                                            '<div class="fix">'+
                                                '<input type="radio" value="'+result.address_id+'" name="address_id" id="radio'+result.count_address+'" class="radio" onclick="select_address('+result.address_id+');" checked="checked">'+
                                                '<label for="radio'+result.count_address+'">'+
                                                    '<b class="s1">Address'+result.count_address+'</b>'+
                                                    '<div class="flr">'+
                                                        '<span class="b address_detault" id="detault_'+result.address_id+'" style="display:none;">Default</span>'+
                                                            '<a href="javascript:;" class="a_underline address_detault_a" id="address_detault_'+result.address_id+'" onclick="default_address('+result.address_id+');">Set Default</a>'+
                                                            '<a href="javascript:;" class="view_btn btn40 JS_popwinbtn1" onclick="edit_address('+result.address_id+', 1);">Edit</a>'+
                                                            '<a href="javascript:;" class="view_btn btn26 delete_address" onclick="delete_address('+result.address_id+');">Delete</a>'+
                                                    '</div>'+
                                                    '<p class="bottom" id="address_list_'+result.address_id+'">'+
                                                        '<span>'+datas.firstname+' '+datas.firstname+'</span>'+
                                                        '<span class="tel">'+datas.phone+'</span>'+
                                                        '<span>'+datas.address+', '+datas.city+' '+datas.state+', '+datas.country+' '+datas.zip+'</span>'+
                                                    '</p>'+
                                                '</label>'+
                                            '</div>'+
                                        '</li>';
                    $("#shipping_address_ul").append(new_address_li);
                    $("#shipping_address_ul .radio").removeAttr("checked");
                    $("#address_li_" + result.address_id + " .radio").attr("checked","checked");

                    $.ajax({
                        type:"POST",
                        url :"/cart/ajax_shipping_price",
                        data:"shipping_price="+datas.shipping_price,
                        dataType:"json",
                        success:function(res){
                            document.getElementById('shipping_price_list').innerHTML = '';
                            document.getElementById('shipping_price_list').innerHTML = res.shipping_name;
                            document.getElementById('shipping_total').innerHTML = '';
                            document.getElementById('shipping_total').innerHTML = res.price;
                            document.getElementById('totalPrice').innerHTML = '';
                            document.getElementById('totalPrice').innerHTML = res.total;
                            document.getElementById('shippingAddressFill').style.display = 'none';
                            document.getElementById('shippingAddressInfo').style.display = 'block';
                            document.getElementById('paymentInfo').style.display = 'block';
                            $('html, body').animate({scrollTop: $('body').offset().top}, 10);
                        }
                    });
                }
                else
                {
                    alert(result.message);
                }
            }
        });
    }
    else
    {
        $.ajax({
            type:"post",
            url : '/address/ajax_edit1',
            data: datas,
            dataType: "json",
            success: function(result){
                if(result.success == 1){
                    alert(result.message);
                    if(datas.address_id)
                    {
                        var address_list_value = '<span>'+datas.firstname+' '+datas.lastname+'</span><span class="tel">'+datas.phone+
                        '</span><span>'+datas.address+', '+datas.city+', '+datas.state+', '+datas.country+', '+datas.zip+'</span>';
                        var list_id = 'address_list_' + datas.address_id;
                        document.getElementById(list_id).innerHTML = '';
                        document.getElementById(list_id).innerHTML = address_list_value;
                        $("#shipping_address_ul .radio").removeAttr("checked");
                        $("#address_li_" + datas.address_id + " .radio").attr("checked","checked");
                    }
                    else
                    {
                        var new_address_li = '<li id="address_li_'+result.address_id+'">'+
                                            '<div class="fix">'+
                                                '<input type="radio" value="'+result.address_id+'" name="address_id" id="radio'+result.count_address+'" class="radio" onclick="select_address('+result.address_id+');">'+
                                                '<label for="radio'+result.count_address+'">'+
                                                    '<b class="s1">Address'+result.count_address+'</b>'+
                                                    '<div class="flr">'+
                                                        '<span class="b address_detault" id="detault_'+result.address_id+'" style="display:none;">Default</span>'+
                                                            '<a href="javascript:;" class="a_underline address_detault_a" id="address_detault_'+result.address_id+'" onclick="default_address('+result.address_id+');">Set Default</a>'+
                                                            '<a href="javascript:;" class="view_btn btn40 JS_popwinbtn1" onclick="edit_address('+result.address_id+', 1);">Edit</a>'+
                                                            '<a href="javascript:;" class="view_btn btn26 delete_address" onclick="delete_address('+result.address_id+');">Delete</a>'+
                                                    '</div>'+
                                                    '<p class="bottom" id="address_list_'+result.address_id+'">'+
                                                        '<span>'+datas.firstname+' '+datas.firstname+'</span>'+
                                                        '<span class="tel">'+datas.phone+'</span>'+
                                                        '<span>'+datas.address+', '+datas.city+' '+datas.state+', '+datas.country+' '+datas.zip+'</span>'+
                                                    '</p>'+
                                                '</label>'+
                                            '</div>'+
                                        '</li>';
                        $("#shipping_address_ul").append(new_address_li);
                        $("#shipping_address_ul .radio").removeAttr("checked");
                        $("#address_li_" + result.address_id + " .radio").attr("checked","checked");
                    }
                    var change = '';
                    if(result.count_address > 1)
                        change = '<a href="javascript:;" class="a_red" onclick="change_address_show();">Change</a>';
                    var shipping_address_list = '<dt>Shipping Address  <a href="javascript:;" class="a_red JS_popwinbtn1" onclick="return edit_address('+result.address_id+');">Edit</a>'+change+'</dt>'+
                                    '<dd class="fix"><label>Name:</label><span>'+datas.firstname+' '+datas.lastname+'</span></dd>'+
                                    '<dd class="fix"><label>Tel:</label><span>'+datas.phone+'</span></dd>'+
                                    '<dd class="fix"><label>Address:</label><span>'+datas.address+', '+datas.city+' '+datas.state+', '+datas.country+' '+datas.zip+'</span></dd>';
                    document.getElementById('shipping_address_list').innerHTML = '';
                    document.getElementById('shipping_address_list').innerHTML = shipping_address_list;
                    document.getElementById('payment_step1').style.display = 'none';
                    document.getElementById('payment_step2').style.display = 'inline-block';
                    change_paypal_refund(datas.country);

                    if(result.has_no_express)
                    {
                        document.getElementById('shipping_price_list').innerHTML = '';
                        document.getElementById('shipping_price_list').innerHTML = result.shipping_name;
                        document.getElementById('shipping_total').innerHTML = '';
                        document.getElementById('shipping_total').innerHTML = result.shipping_price;
                        document.getElementById('totalPrice').innerHTML = '';
                        document.getElementById('totalPrice').innerHTML = result.total_price;
                        document.getElementById('ship_edit').style.display = 'none';
                    }
                    else
                    {
                        document.getElementById('ship_edit').style.display = 'initial';
                    }

                    if(in_array(datas.country, sofort))
                    {
                        document.getElementById('sofort_banking').style.display = 'block';
                    }
                    else
                    {
                        document.getElementById('sofort_banking').style.display = 'none';
                    }
                    if(in_array(datas.country, ideal))
                    {
                        document.getElementById('ideal').style.display = 'block';
                    }
                    else
                    {
                        document.getElementById('ideal').style.display = 'none';
                    }

                    $(".opacity").hide();
                    $(".JS_popwincon1").hide();
                    document.getElementById('shippingAddressAdd').style.display = 'none';
                    document.getElementById('shippingAddressInfo').style.display = 'block';
                    $('html, body').animate({scrollTop: $('body').offset().top}, 10);
                }
                else
                {
                    alert(result.message);
                }
            }
        });
    }
    
    return false;
}

var sofort = new Array('DE', 'AT', 'CH', 'BE', 'FR', 'IT', 'GB', 'ES', 'NL', 'PL');
var ideal = new Array('NL');

function select_address(id)
{
    datas = new Object();
    datas.address_id = id;
    $.ajax({
        type:"post",
        url : '/cart/ajax_shipping',
        data: datas,
        dataType: "json",
        success: function(res){
            var change = '';
            if(res.count_address > 1)
                change = '<a href="javascript:;" class="a_red" onclick="change_address_show();">Change</a>';
            var shipping_address_list = '<dt>Shipping Address  <a href="javascript:;" class="a_red JS_popwinbtn1" onclick="return edit_address('+res.shipping_address_id+');">Edit</a>'+change+'</dt>'+
                    '<dd class="fix"><label>Name:</label><span>'+res.shipping_firstname+' '+res.shipping_lastname+'</span></dd>'+
                    '<dd class="fix"><label>Tel:</label><span>'+res.shipping_phone+'</span></dd>'+
                    '<dd class="fix"><label>Address:</label><span>'+res.shipping_address+', '+res.shipping_city+' '+res.shipping_state+', '+res.shipping_country+' '+res.shipping_zip+'</span></dd>';
            document.getElementById('shipping_address_list').innerHTML = '';
            document.getElementById('shipping_address_list').innerHTML = shipping_address_list;
            document.getElementById('payment_step1').style.display = 'none';
            document.getElementById('payment_step2').style.display = 'inline-block';
            change_paypal_refund(res.shipping_country);

            if(res.has_no_express)
            {
                document.getElementById('shipping_price_list').innerHTML = '';
                document.getElementById('shipping_price_list').innerHTML = res.shipping_name;
                document.getElementById('shipping_total').innerHTML = '';
                document.getElementById('shipping_total').innerHTML = res.shipping_price;
                document.getElementById('totalPrice').innerHTML = '';
                document.getElementById('totalPrice').innerHTML = res.total_price;
                document.getElementById('ship_edit').style.display = 'none';
            }
            else
            {
                document.getElementById('ship_edit').style.display = 'initial';
            }

            $(".opacity").hide();
            $(".JS_popwincon1").hide();
            document.getElementById('shippingAddressAdd').style.display = 'none';
            document.getElementById('shippingAddressInfo').style.display = 'block';
            if(in_array(res.shipping_country, sofort))
            {
                document.getElementById('sofort_banking').style.display = 'block';
            }
            else
            {
                document.getElementById('sofort_banking').style.display = 'none';
            }
            if(in_array(res.shipping_country, ideal))
            {
                document.getElementById('ideal').style.display = 'block';
            }
            else
            {
                document.getElementById('ideal').style.display = 'none';
            }
            $('html, body').animate({scrollTop: $('body').offset().top}, 10);
        }
    });
}

function check_shipping_address(datas)
{
    if(!trim(datas.shipping_firstname) || !datas.trim(shipping_lastname) || !trim(datas.shipping_address) || !trim(datas.shipping_country) || !trim(datas.shipping_state) || !trim(datas.shipping_city) || !trim(datas.shipping_zip) || !trim(datas.shipping_phone))
        return 0;
    else
        return 1;
}

function ace2(){
	var select = document.getElementById("shipping_country");
    var countryCode = select.options[select.selectedIndex].value;
		if(countryCode == 'HK' || countryCode == 'MO' || countryCode == 'TW')
		{	
			$("#guo111").show();
			$("#guo111").html('請輸入中文地址(Please enter the address in Chinese.)');
		}else{
			$("#guo111").hide();
		}	
}

function ace2(){
	var select = document.getElementById("shipping_country");
    var countryCode = select.options[select.selectedIndex].value;
		if(countryCode == 'HK' || countryCode == 'MO' || countryCode == 'TW')
		{	
			$("#guo111").show();
			$("#guo111").html('請輸入中文地址(Please enter the address in Chinese.)');
		}else{
			$("#guo111").hide();
		}	
}
function acecoun(){
	var s = $("#shipping_state").val(); 
	var scon = $("#s_state").val(); 
var re = /.*\d+.*/;
	if(re.test(s)){	
			$("#guo_don").show();
			$("#guo_don").html('County / Province Name with digits? Please check the accuracy.');
		}else{
			$("#guo_don").hide();
		}	
		
	if(re.test(scon)){	
			$("#guo_don1").show();
			$("#guo_don1").html('County / Province Name with digits? Please check the accuracy.');
		}else{
			$("#guo_don1").hide();
		}	
}

function acedoun(){
	var s = $("#shipping_city").val(); 
	var s2 = $("#s_city").val(); 
var re = /.*\d+.*/;
	if(re.test(s)){	
			$("#guo_eon").show();
			$("#guo_eon").html('City / Town Name with digits? Please check the accuracy.');
		}else{
			$("#guo_eon").hide();
		}	
		
	if(re.test(s2)){	
			$("#guo_eon1").show();
			$("#guo_eon1").html('City / Town Name with digits? Please check the accuracy.');
		}else{
			$("#guo_eon1").hide();
		}	
}

function ace(){
	var s = $("#shipping_zip").val(); 
	var s3 = $("#s_zip").val(); 
var re = /^[a-zA-Z]{3,10}$/;
		if(re.test(s)){		
		$("#guo_fon").show();
		$("#guo_fon").html("It seems that there are no digits in your code, please check the accuracy.");
	}else{
		$("#guo_fon").hide();
	}
	
		if(re.test(s3)){		
		$("#guo_fon1").show();
		$("#guo_fon1").html("It seems that there are no digits in your code, please check the accuracy.");
	}else{
		$("#guo_fon1").hide();
	}
}

function check_address(datas)
{
		var s = datas.zip; 
		var re = /^[a-zA-Z]{3,10}$/;
		var c = datas.state;
		var ct = datas.city;
		var ret = /.*\d+.*/;
	// if(re.test(s)){
		// $("#guo222").show();
		// $("#guo222").html("It seems that there are no digits in your code, please check the accuracy.");
	// }else{
		// $("#guo222").hide();
	// }
    if(!trim(datas.firstname) || !trim(datas.lastname) || !trim(datas.address) || !trim(datas.country) || !trim(datas.state) || !trim(datas.city) || !trim(datas.zip) || !trim(datas.phone) || datas.address.length>100 || datas.address.length<3 || (re.test(s)) || (ret.test(c)) || (ret.test(ct)) || datas.phone.length>20 || datas.phone.length<6 || s.length>10 || s.length<3) 
        return 0;
    else
        return 1;
}

function delete_address(id)
{
    $('body').append('<div id="wingray1" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
    $('#cart_delete').appendTo('body').fadeIn(320);
    document.getElementById('address_id').value = id;
    document.getElementById('cart_delete').style.display = 'block';
    return false;
}

function delete_close()
{
    document.getElementById('wingray1').remove();
    document.getElementById('cart_delete').style.display = 'none';
    return false;
}

function delete_address_submit()
{
    var id = document.getElementById('address_id').value;
    datas = new Object();
    datas.id = id;
    $.ajax({
        type:"post",
        url : '/address/ajax_delete1',
        data: datas,
        dataType: "json",
        success: function(data){
            if(data.success == 1){
                var address_li_id = 'address_li_' + id;
                document.getElementById(address_li_id).remove();
                document.getElementById('wingray1').remove();
                document.getElementById('cart_delete').style.display = 'none';
            }else{
                alert(data.message);
            }
        }
    });
    return false;
}

function choice_coupon(code)
{
    document.getElementById('coupon_code').value = code;
    document.getElementById('available_codes').style.display = 'none';
}

function setCoupon()
{
    coupon = document.getElementById('coupon_code');
    if(coupon.value == '')
        return false;
    datas = new Object();
    datas.coupon_code = coupon.value;
    $.ajax({
        type:"POST",
        url :"/cart/ajax_coupon",
        data:datas,
        dataType:"json",
        success:function(datas){
            if(datas.success == 1)
            {
                alert(datas.message);
                document.getElementById('cart_saving').innerHTML = '';
                document.getElementById('cart_saving').innerHTML = datas.saving;
                document.getElementById('save_total').innerHTML = '';
                document.getElementById('save_total').innerHTML = datas.save_total;
                document.getElementById('coupon_points_save').style.display = 'block';
                document.getElementById('totalPrice').innerHTML = '';
                document.getElementById('totalPrice').innerHTML = datas.total;
                coupon.value = '';
            }
            else
            {
                alert(datas.message);
            }
        }
    });
    return false;
}

function setPoints()
{
    elment = document.getElementById('points');
    points = Number(elment.value);
    if(points <= 0 || !points)
        return false;
    datas = new Object();
    datas.points = points;
    $.ajax({
        type:"POST",
        url :"/cart/ajax_point",
        data:datas,
        dataType:"json",
        success:function(datas){
            if(datas.success == 1)
            {
                alert(datas.message);
                document.getElementById('cart_saving').innerHTML = '';
                document.getElementById('cart_saving').innerHTML = datas.saving;
                document.getElementById('save_total').innerHTML = '';
                document.getElementById('save_total').innerHTML = datas.save_total;
                document.getElementById('coupon_points_save').style.display = 'block';
                document.getElementById('totalPrice').innerHTML = '';
                document.getElementById('totalPrice').innerHTML = datas.total;
                elment.value = '';
            }
            else
            {
                alert(datas.message);
            }
        }
    });
    return false;
}

function change_paypal_refund(country)
{
    var paypal_refund_config = new Array();
    paypal_refund_config = <?php echo json_encode($paypal_refund_config); ?>;
    var change_img = paypal_refund_config[country];
    if(typeof(change_img) != "undefined")
    {
        $("#paypal_shipping_refund a").hide();
        $("#paypal_shipping_refund ." + change_img).show();
    }
    else
    {
        $("#paypal_shipping_refund a").hide();
    }
}

function setMessage()
{
    message_change = document.getElementById('message_change').value;
    if(!message_change)
        return false;
    elment = document.getElementById('set_message');
    datas = new Object();
    datas.message = elment.value;
    datas.message_change = document.getElementById('message_change').value;
    datas.return_url = 'ajax';
    $.ajax({
        type:"post",
        url : '/cart/set_message',
        data: datas,
        dataType: "json",
        success: function(data){
            if(data.success == 1){
                // alert(data.message);
                document.getElementById('message_submit').style.display = 'none';
                document.getElementById('message_edit').style.display = 'block';
                elment.style.display = 'none';
                document.getElementById('now_message').innerHTML = datas.message;
                document.getElementById('now_message').style.display = 'block';
            }
        }
    });
    return false;
}

function editMessage()
{
    document.getElementById('set_message').style.display = 'block';
    document.getElementById('now_message').style.display = 'none';
    document.getElementById('message_submit').style.display = 'block';
    document.getElementById('message_edit').style.display = 'none';
}

function messageChange()
{
    return window.setTimeout(function(){
        var message = document.getElementById('set_message').value;
        message = message.replace(/(^\s*)|(\s*$)/g, "");
        document.getElementById('message_change').value = message;
    }, 0);
}

function createData(formObj){
    var datas = new Object();
    formElement = $(formObj).find("input,select,textarea");
    formElement.each(function(i,n){
        datas[$(n).attr("name")] = $(n).val();
    });
    return datas;
}

function radio_change(radio_oj,aValue){//传入一个对象
   for(var i=0;i<radio_oj.length;i++) {//循环
        if(radio_oj[i].value==aValue){  //比较值
            radio_oj[i].checked=true; //修改选中状态
            break; //停止循环
        }
   }
}

function in_array(search,array){
    for(var i in array){
        if(array[i]==search){
            return true;
        }
    }
    return false;
}

function trim(str){
    return str.replace(/(^\s*)|(\s*$)/g, "");
}

$(document).ready(function(){
    $("div.pc-apply").click(function(){
        $(this).siblings().toggle();
    });    
    //shipping price
    $(".s_price_list .radio").click(function(){
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

    $(".states2 .all2 .s_state").change(function(){
        var val = $(this).val();
        if(val == ' ')
        {
            $(".states2 .all2").hide();
            $(".states2 .text").show();
            $(".states2 .text").val("");
        }
    })
})
</script>
<script type="text/javascript">
    /* form1 */
    $(".form1").validate({
        rules: {
            firstname: {    
                required: true,
                maxlength:50
            },
            lastname: {    
                required: true,
                maxlength:50
            },
            address: {
                required: true,
                rangelength:[3,200]
            },
            zip: {
                required: true,
                rangelength:[3,10]
            },
            city: {
                required: true,
                maxlength:50
            },
            country: {
                required: true,
                maxlength:50
            },
            state: {
                required: true,
                maxlength:50
            },
            phone: {
                required: true,
                rangelength:[6,20]
            }
        },
        messages: {
            firstname: {
                required: "Please enter your first name.",
                maxlength:"The first name exceeds maximum length of 50 characters."
            },
            lastname: {
                required: "Please enter your last name.",
                maxlength:"The last name exceeds maximum length of 50 characters."
            },
            address: {
                required: "Please enter your address.",
				rangelength: $.validator.format("Please enter 3-100 characters.")
            },
            zip: {
                required: "Please enter your zip.",
                rangelength: $.validator.format("Please enter 3-10 characters.")
            },
            city: {
                required: "Please enter your city.",
                maxlength:"The city exceeds maximum length of 50 characters."
            },
            country: {
                required: "Please choose your country.",
                maxlength:"The country exceeds maximum length of 50 characters."
            },
            state: {
                required: "Please enter your County / Province / State.",
                maxlength:"The country exceeds maximum length of 50 characters."
            },
            phone: {
                required: "Please enter your phone.",
                rangelength: $.validator.format("Please enter a phone no. within 6-20 digits.")
            }
        }
    });

    /* form2 */
    $(".form2").validate({
        rules: {
            firstname: {    
                required: true,
                maxlength:50
            },
            lastname: {    
                required: true,
                maxlength:50
            },
            address: {
                required: true,
                rangelength:[3,200]
            },
            zip: {
                required: true,
                rangelength:[3,10]
            },
            city: {
                required: true,
                maxlength:50
            },
            country: {
                required: true,
                maxlength:50
            },
            state: {
                required: true,
                maxlength:50
            },
            phone: {
                required: true,
                rangelength:[6,20]
            }
        },
        messages: {
            firstname: {
                required: "Please enter your first name.",
                maxlength:"The first name exceeds maximum length of 50 characters."
            },
            lastname: {
                required: "Please enter your last name.",
                maxlength:"The last name exceeds maximum length of 50 characters."
            },
            address: {
                required: "Please enter your address.",
				rangelength: $.validator.format("Please enter 3-100 characters.")
            },
            zip: {
                required: "Please enter your zip.",
                rangelength: $.validator.format("Please enter 3-10 characters.")
            },
            city: {
                required: "Please enter your city.",
                maxlength:"The city exceeds maximum length of 50 characters."
            },
            country: {
                required: "Please choose your country.",
                maxlength:"The country exceeds maximum length of 50 characters."
            },
            state: {
                required: "Please enter your County / Province / State.",
                maxlength:"The country exceeds maximum length of 50 characters."
            },
            phone: {
                required: "Please enter your phone.",
                rangelength: $.validator.format("Please enter a phone no. within 6-20 digits.")
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
                <area target="_blank" shape="rect" coords="88,2,193,62" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en" />
            </map>
            <div style="background-color:#232121;">
                <p class="bottom">
                    Copyright © 2006-<?php echo date('Y'); ?> Choies.com
                </p>
            </div>
        </div>
    </div>
</footer>