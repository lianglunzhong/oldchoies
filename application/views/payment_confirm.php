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
        <?php
        $message = Message::get();
        echo $message;
        ?>
    </div>
    <!-- main begin -->
    <section class="layout fix">
        <section class="cart">
            <article class="shipping_delivery_left fll">
                <h3>SHIPPING ADDRESSES</h3>
                <?php
                $has_address = (isset($cart['shipping_address']) AND !empty($cart['shipping_address'])) ? 1 : 0;
                if($has_address)
                {
                ?>
                    <dl class="shipping_payment">
                        <dd>
                            <ul class="shipping_address">
                                <li class="fix JS_shows_btn1">
                                    <div class="fix">
                                        <label for="radio<?php echo $key; ?>"><b class="s1">Address</b></label>
                                    </div>
                                    <p class="bottom" id="now_address">
                                        <span><?php echo $cart['shipping_address']['shipping_firstname'] . ' ' . $cart['shipping_address']['shipping_lastname']; ?></span>
                                        <span class="tel"><?php echo $cart['shipping_address']['shipping_phone']; ?></span>
                                        <span><?php echo $cart['shipping_address']['shipping_address'] . ', ' . $cart['shipping_address']['shipping_city'] . ', ' . $cart['shipping_address']['shipping_state'] . ', ' . $cart['shipping_address']['shipping_country'] . ', ' . $cart['shipping_address']['shipping_zip']; ?></span>
                                    </p>
                                </li>
                                <li class="fix last">
                                    <a for="radionew" class="a_underline JS_popwinbtn1 edit_address font14">Edit Address</a>
                                </li>
                            </ul>
                        </dd>
                    </dl>
                    <?php
                }
                    ?>
                    <!-- JS_show1 -->
                <div id="edit_address" class="JS_popwincon2 popwincon popwincon_user hide">
                    <a class="JS_close3 close_btn2"></a>
                    <form action="/cart/edit_address" method="post" class="form user_share_form user_form form1">
                        <input type="hidden" id="e_address_id" name="shipping_address_id" value="">
                        <ul class="add_showcon_boxcon">
                                <li>
                                    <label><span>*</span> First Name:</label>
                                    <input type="text" value="<?php echo $cart['shipping_address']['shipping_firstname']; ?>" name="shipping_firstname" id="shipping_firstname" class="text text_long" />
                                </li>
                                <li>
                                    <label><span>*</span> Last Name:</label>
                                    <input type="text" value="<?php echo $cart['shipping_address']['shipping_lastname']; ?>" name="shipping_lastname" id="shipping_lastname" class="text text_long" />
                                </li>
                                <li>
                                    <label><span>*</span> Address:</label>
                                    <div>
                                        <textarea class="textarea_long" name="shipping_address" id="shipping_address"><?php echo $cart['shipping_address']['shipping_address']; ?></textarea>
                                    </div>
                                </li>
                                <li>
                                    <label><span>*</span> Country:</label>
                                    <select name="shipping_country" class="select_style selected304" id="shipping_country" onchange="changeSelectCountry2();$('#billing_country').val($(this).val());">
                                        <option value="">SELECT A COUNTRY</option>
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
                                        ?>
                                        <div class="all2 JS_drop" id="all2_<?php echo $country; ?>" style="display:none;">
                                            <select name="" class="select_style selected304 s_state" onblur="$('#billing_state1').val($(this).val());">
                                                <option value="">[Select One]</option>
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
                                        function changeSelectCountry2(){
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
                                    <label><span>*</span> City / Town:</label>
                                    <input type="text" value="<?php echo $cart['shipping_address']['shipping_city']; ?>" name="shipping_city" id="shipping_city" class="text text_long" />
                                </li>
                                <li>
                                    <label><span>*</span> Zip / Postal Code:</label>
                                    <input type="text" value="<?php echo $cart['shipping_address']['shipping_zip']; ?>" name="shipping_zip" id="shipping_zip" class="text text_long" />
                                </li>
                                <li>
                                    <label><span>*</span> Phone:</label>
                                    <input type="text" value="<?php echo $cart['shipping_address']['shipping_phone']; ?>" name="shipping_phone" id="shipping_phone" class="text text_long" />
                                </li>
                                <li id="shipping_cpf" class="hide">
                                    <label><span>*</span>o cadastro de pessoa Física:</label>
                                    <input type="text" name="shipping_cpf" id="shipping_cpf" class="text text_long" value="" />
                                </li>
                        </ul>
                        <div class="center" style="margin-left: -63px;"><input type="submit" value="SUBMIT" class="btn30_14_black" /></div>
                    </form>
                </div>
                <h3>SHIPPING METHODS</h3>
                    <?php
                    $cart_shipping = !empty($cart['shipping']) ? $cart['shipping']['price'] : -1;
                    $site_shipping = kohana::config('sites.shipping_price');
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
                                ?>
                                <li>
                                    <input type="radio" name="shipping_price" value="<?php echo $price['price']; ?>" id="radios<?php echo $key; ?>" class="radio shipping_radio" <?php if ($price['price'] == $default_shipping) echo 'checked'; ?> />
                                    <label for="radios<?php echo $key; ?>"><?php echo $price['name'] . ' ( ' . Site::instance()->price($price['price'], 'code_view') . ' )'; ?></label>
                                </li>
                                <?php
                            endforeach;
                            ?>
                        </ul>
                    </div>
                <div id="coupon_points"></div>
                    <div class="mb25">
                        <h3>Coupons & Points</h3>
                        <div class="coupons_box">
                            <form action="/cart/set_coupon" method="post" class="form" id="set_coupon">
                                <label class="left">
                                    Coupons  Code:<em class="icon_tips JS_shows_btn1">
                                        <span class="JS_shows1 icon_tipscon hide">
                                            Note: 1. The product with "% off" icon cannot be combined   with any coupon code.     
                                            <i>2. Please enter the coupon code with no space.</i>
                                        </span>
                                    </em>
                                </label>
                                <input type="text" value="" name="coupon_code" class="text codeInput" id="codeInput" />
                                <input type="hidden" name="return_url" value="/payment/ppec_confirm?token=<?php echo $token; ?>&PayerID=<?php echo $payerid; ?>" />
                                <input type="submit" value="Apply" class="btn22_black mr10" />
                                <a class="J_pop_btn a_underline">Code list</a>
                            </form>
                            <?php
                                if ($cart['coupon']):
                                    ?>
                                    <div class="color666">
                                        Current Coupon Code:
                                        <span class="red"><?php echo $cart['coupon']; ?></span>
                                    </div>
                                    <?php
                                endif;
                                ?>
                            <!-- codelist_con -->
                            <div class="codelist_con J_popcon hide">
                                <span class="close_btn"></span>
                                <div class="tit"><h3>Available Codes</h3></div>
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
                                    <div class="codenone">No Available Codes.</div> 
                                <?php
                                endif;
                                ?>
                            </div>
                        </div>
                            
                        <div class="coupons_box">
                            <form action="/cart/point" method="post" class="form" id="point_form">
                                <label class="left">Choies Points:<em class="icon_tips JS_shows_btn1"><span class="JS_shows1 icon_tipscon hide">You may apply Points equaling up to only 10% of your order value. Complete your profile, you will be awarded 500 points to redeem your first order.</span></em></label>
                                <input type="hidden" name="return_url" value="/payment/ppec_confirm?token=<?php echo $token; ?>&PayerID=<?php echo $payerid; ?>" />
                                <?php
                                $is_celebrity = Customer::instance($customer_id)->is_celebrity();
                                ?>
                                <input type="text" id="point" value="<?php if (!$is_celebrity && $points_avail > 0) echo $points_avail; ?>" name="points" class="text text_short" onkeydown="return point2dollar();" />
                                <input type="submit" value="Redeem" class="btn22_black mr10" onclick="return point_redeem();" />
                                Save: <span class="red">$ <span  id="dollar">0</span></span> 
                                <div class="color666">
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
                                    <a class="a_underline JS_popwinbtn">VIP Policy</a></div>
                            </form>
                            <script type="text/javascript">
                                    var xhr = null;
                                    var amount_left = $('#amount_left').text();
                                
                                    function point_redeem()
                                    {
                                        var points = parseFloat(document.getElementById('point').value);
                                        if (points > <?php print $points_avail; ?>) {
                                            window.alert('Not enough points available');
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
                <form action="" method="post">
                    <p>
                        <input type="hidden" name="shipping" id="shipping_value" value="<?php echo $default_shipping; ?>" />
                        <input type="hidden" name="token" value="<?php echo $token; ?>" />
                        <input type="hidden" name="payerid" value="<?php echo $payerid; ?>" />
                        <input type="submit" value="pay now" class="btn40_16_red" />
                    </p>
                </form>
            </article>

            <!-- order_summary -->
            <div class="order_summary flr">
                <div class="cart_side">
                    <h3>YOUR ORDER SUMMARY</h3>
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
                            endforeach;
                        endif;
                        ?>
                    </ul>
                    <ul class="total">
                        <li class="font14"><label>Subtotal: </label><span><?php echo Site::instance()->price($cart['amount']['items'], 'code_view'); ?></span></li>     
                        <li><label>Estimated Shipping: </label><span id="shipping_total"><?php echo $cart_shipping == -1 ? Site::instance()->price($site_shipping[1]['price'], 'code_view') : Site::instance()->price($cart_shipping, 'code_view'); ?></span></li>
                        <li id="coupon_save">
                        <?php
                        if ($cart['amount']['coupon_save'] + $cart['amount']['point'] > 0):
                            ?>
                            <label>Pay with Coupons & Points: </label><span><?php echo Site::instance()->price($cart['amount']['coupon_save'] + $cart['amount']['point'], 'code_view'); ?></span>
                            <?php
                        endif;
                        ?>
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
                        <li class="last red" id="total_saving">
                        <?php
                        if ($saving):
                            ?>
                            <label>Savings: </label><span><?php echo Site::instance()->price($saving, 'code_view'); ?></span>
                            <?php
                        endif;
                        ?>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </section>
</section>
<div class="hide" id="cart_delete" style="position: fixed;padding: 10px 10px 20px; top: 170px;left: 400px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border:1px solid #cdcdcd;">
    <div style="font-size: 1.4em;margin-top:0px;border-bottom: 2px solid #F4F4F4;">CONFIRM ACTION</div>

    <div class="order order_addtobag center" style="margin:20px;">
        <div style="font-size:13px;margin-bottom: 20px;">Are you sure you want to delete this address?</div>
        <form action="/cart/delete_address" method="post">
            <input type="hidden" name="address_id" id="address_id" value="" />
            <input type="submit" class="btn30_14_black" value="DELETE" />
            <a href="#" class="cancel" style="text-decoration:underline;margin-left:10px;">Cancel</a>
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
        
        $(".edit_address").click(function(){
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
        })

        $("#edit_address").submit(function(){
            $.post(
            '/cart/ajax_shipping',
            {
                id: $('input:[name="id"]').val(),
                shipping_firstname: $("#shipping_firstname").val(),
                shipping_lastname: $("#shipping_lastname").val(),
                shipping_address: $("#shipping_address").val(),
                shipping_city: $("#shipping_city").val(),
                shipping_state: $("#shipping_state").val(),
                shipping_country: $("#shipping_country").val(),
                shipping_zip: $("#shipping_zip").val(),
                shipping_phone: $("#shipping_phone").val(),
                shipping_cpf: $("#shipping_cpf").val()
            },
            function(address)
            {
                var html_address = '<span>'+address['shipping_firstname']+' '+address['shipping_lastname']+'</span>\
                <span class="tel">'+address['shipping_phone']+'</span>\
                <span>'+address['shipping_address']+', '+address['shipping_city']+', '+address['shipping_state']+', '+address['shipping_country']+', '+address['shipping_zip']+'</span>';
                $("#now_address").html(html_address);
                $(".JS_filter2").remove();
                $('.JS_popwincon2').fadeOut(160);
            },
            'json'
            );
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
        })
    })
    
    //shipping price
    $(function(){
        var code = "<?php $currency = Site::instance()->currency(); echo $currency['code']; ?>";
        var rate = <?php echo $currency['rate']; ?>;
        $(".shipping_methods .radio").click(function(){
            var price = $(this).attr('value');
            $.ajax({
                type: "POST",
                url: "/cart/ajax_shipping_price",
                dataType: "json",
                data: "shipping_price="+price,
                success: function(data){
                    var shipping_price = tofloat(price * rate, 2);
                    shipping_price += " ";
                    var shipping_total = code + shipping_price;
                    $("#shipping_total").html(shipping_total);
                    $("#shipping_amount").val(price);
                    var amount_total = code + tofloat(data['total'] * rate, 2);;
                    $("#totalPrice").html(amount_total);
                }
            });
        })

        //Set coupon
        $("#set_coupon").submit(function(){
            var coupon = $("#codeInput").val();
            var shipping = $("#shipping_value").val();
            $.ajax({
                type: "POST",
                url: "/cart/ajax_coupon",
                dataType: "json",
                data: "coupon_code="+coupon+"&shipping="+shipping,
                success: function(data)
                {
                    if(data['success'] == 1)
                    {
                        $("#coupon_save").html("<label>Pay with Coupons &amp; Points: </label><span>" + data['save'] + "</span>");
                        $("#totalPrice").html(data['total']);
                        $("#total_saving").html("<label>Savings: </label><span>" + data['saving'] + "</span>");
                        alert('Set coupon code success!');
                    }
                    else
                    {
                        alert(data['message']);
                    }
                    
                }
            });
            return false;
        })

        //Set points
        $("#point_form").submit(function(){
            var points = $("#point").val();
            var shipping = $("#shipping_value").val();
            $.ajax({
                type: "POST",
                url: "/cart/ajax_point",
                dataType: "json",
                data: "points="+points+"&shipping="+shipping,
                success: function(data)
                {
                    if(data['success'] == 1)
                    {
                        $("#coupon_save").html("<label>Pay with Coupons &amp; Points: </label><span>" + data['save'] + "</span>");
                        $("#totalPrice").html(data['total']);
                        $("#total_saving").html("<label>Savings: </label><span>" + data['saving'] + "</span>");
                        alert('Set point success!');
                    }
                    else
                    {
                        alert(data['message']);
                    }
                    
                }
            });
            return false;
        })
    })
                                
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