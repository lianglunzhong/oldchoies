<header class="site-header">
    <div class="cart-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-8 col-md-8">
                    <a href="<?php echo LANGPATH; ?>/" class="logo"><img src="<?php echo STATICURL; ?>/assets/images/2016/logo.png" alt=""></a>
                </div>
                <div class="col-xs-4 col-md-4">
                    <a href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=<?php echo URLSTR; ?>&lang=en" target="_blank"><img src="<?php echo STATICURL; ?>/assets/images/card3.png" /></a>
                </div>
            </div>
        </div>
    </div>
    <div class="phone-cart-header">
        <div class="container">
            <div class="row">
                <?php
                $has_address = (isset($cart['shipping_address']) AND !empty($cart['shipping_address'])) ? 1 : 0;
                ?>
                <div class="col-sm-12 col-md-12">
                    <div class="step-nav">
                        <ul class="clearfix">
                            <li class="current">Заказать<em></em><i></i></li>
                            <li>Оплатить<em></em><i></i></li>
                            <li>Успешно<em></em><i></i></li>
                        </ul>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</header>
<!-- JS-popwincon2 -->
<div class="JS-popwincon2 popwincon popwincon-user  hide">
    <a class="JS-close3 close-btn3"></a>
    <form action="<?php echo LANGPATH; ?>/cart/edit_shipping" method="post" class="form payment-form" onsubmit="return setShipping(this);">
        <?php
        $cart_shipping = !empty($cart['shipping']) ? $cart['shipping']['price'] : -1;
        $default_shipping = 0;
        ?>
        <div class="shipping-methods s_price_list">
            <ul class="clearfix">
                <?php
                foreach ($site_shipping as $key => $price)
                {
                    $name1 = '10-15 Рабочих дней Бесплатная Доставка';
                    $site_shipping[1]['name'] = $name1;
                    $name2 = '4-7 Рабочих дней Экспресс-Доставка';
                    $site_shipping[2]['name'] = $name2;
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
                    <li class="col-xs-12 col-md-6">
                        <input type="radio" name="sprice" value="<?php echo $price['price']; ?>" id="sprice_radios_ph<?php echo $key; ?>" class="radio" <?php if ($price['price'] == $default_shipping) echo 'checked'; ?> onclick="change_sprice(<?php echo $price['price']; ?>);" />
                        <label for="sprice_radios<?php echo $key; ?>" id="sprice_title<?php echo $price['price']; ?>" style="display: initial;"><?php echo $price['name'] . ' ( ' . Site::instance()->price($price['price'], 'code_view') . ' )'; ?></label>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <input type="hidden" id="shipping_price111" value="<?php echo $default_shipping; ?>" name="shipping_price" />
            <p><input type="submit" value="Дальше" class="btn btn-default"></p>
        </div>
    </form>
</div>
<div class="site-content">
    <div class="main-container clearfix">
        <div class="container">
            <div class="row">
                <div id="forgot_password">
                    <?php
                    $message = Message::get();
                    echo $message;
                    ?>
                </div>
                <div class="cart clearfix">
                 <div class="col-xs-12 col-sm-7">
                    <div class="shipping-information">
                        <h2>Информация доставки</h2>
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
                            <div class="information-con">
                                <dl id="shipping_address_list" class="col-xs-12 col-md-6">
                                <?php
                                if ($has_address)
                                {
                                ?>
                                    <dt>
                                      АДРЕСЫ ДОСТАВКИ  <a href="javascript:;" class="red"  data-reveal-id="myModal10" onclick="return edit_address(<?php echo $cart['shipping_address']['shipping_address_id']; ?>, 1);">Редактировать</a>
                                        <?php
                                        if($count_address > 1)
                                        {
                                        ?>
                                            <a href="javascript:;" class="red" onclick="return change_address_show();">Изменить</a>
                                        <?php
                                        }
                                        ?>
                                    </dt>
                                    <dd><label>Имя:</label><span><?php echo $cart['shipping_address']['shipping_firstname'] . ' ' . $cart['shipping_address']['shipping_lastname']; ?></span></dd>
                                    <dd><label>Телефон:</label><span><?php echo $cart['shipping_address']['shipping_phone']; ?></span></dd>
                                    <dd><label>Адрес:</label><span><?php echo $cart['shipping_address']['shipping_address'] . ' ' . $cart['shipping_address']['shipping_city'] . ', ' . $cart['shipping_address']['shipping_state'] . ' ' . $shipping_country . ' ' . $cart['shipping_address']['shipping_zip']; ?></span></dd>
                                <?php
                                }
                                ?>
                                </dl>
                                <dl class="col-xs-12 col-md-6">
                                    <dt>МЕТОДЫ ДОСТАВКИ <!--   <a href="javacript:;" class="red JS-popwinbtn2" id="ship_edit" <?php //if(in_array($cart['shipping_address']['shipping_country'], $no_express_countries)) echo 'style="display:none;"'; ?>>Редактировать</a> --></dt>
                                    <form action="<?php echo LANGPATH; ?>/cart/edit_shipping" method="post" class="form payment-form" onsubmit="return setShipping(this);" id="editshipingform">
                                    <?php
                      $cart_shipping = !empty($cart['shipping']) ? $cart['shipping']['price'] : -1;
                       $default_shipping = 0;
                                  /*  if($show_address)
                                        {*/
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
                } ?>
                <input type="hidden" id="shipping_price" value="<?php echo $default_shipping; ?>" name="shipping_price" />
                <?php
                foreach ($site_shipping as $key => $price)
                { ?>
                                        <dd id="shipping_price_list_<?php echo $key; ?>" <?php if(in_array($cart['shipping_address']['shipping_country'], $no_express_countries) && $key==2) echo 'style="display:none;"'; ?> >
                                            <label style="width:5%" class="s_price_list">
                                                <input type="radio" name="sprice" value="<?php echo $price['price']; ?>" id="sprice_radios<?php echo $key; ?>" class="radio" <?php if ($price['price'] == $default_shipping) echo 'checked'; ?> onclick="change_sprice(<?php echo $price['price']; ?>);" />
                                            </label>
                                            <div class="method">    
                                                <p style="width:78%;"><?php echo $price['name']; ?></p> 
                                                <p style="width:20%;"><?php echo Site::instance()->price($price['price'], 'code_view'); ?></p>
                                            </div>
                                        </dd>
                                    <?php
                                        }
                                      /*  }*/
                                        ?>
                                        <dd id="aaab">
                                            <label style="width:5%">
                                                <input type="checkbox" value="1" name="insurance_pc" id="insurance_pc" class="radio" <?php if($session_insurance != -1){ echo 'checked'; } ?>>
                                            </label>
                                            <div class="method">    
                                                <p style="width:78%;">Добавить страхование доставки  для вашего заказа</p> 
                                                <p style="width:20%;"><?php echo Site::instance()->price(0.99, 'code_view'); ?></p>
                                                <div class="insurance JS-show">
                                                    <b>Почему добавить страховку?</b>
                                                    <div class="ins-info JS-showcon" style="display: none;">
                                                        <b class="arrow-up"></b>
                                                        <div class="ins-tipscon">Страхование Доставки обеспечивает превосходную защиту и безопасность ваших ценных вещей во время международной доставки. Если посылка утеряна или повреждена, мы будем отправить вам новую посылку бесплатно сразу.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </dd> 
                                          </form>
                                </dl>
                            </div>
                        </div>
                        <div id="shippingAddressAdd" style="display:none;">
                            <dl class="shipping-add-address">
                                <dd>
                                <form action="" method="post" name="shipping_address_radio">
                                    <ul class="shipping-address" id="shipping_address_ul">
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
                                            <div class="clearfix">
                                                <input type="radio" value="<?php echo $value['id']; ?>" name="address_id" id="radio<?php echo $key; ?>" class="radio" onclick="select_address(<?php echo $value['id']; ?>);" <?php if($cart['shipping_address']['shipping_address_id'] == $value['id']) echo 'checked="checked"'; ?> />
                                                <label for="radio<?php echo $key; ?>">
                                                    <b>Адрес<?php echo $key + 1; ?></b>
                                                </label>
                                                    <div>
                                                    <?php
                                                    if ($key == $default_key)
                                                    {
                                                        ?>
                                                            <p class="col-md-4 col-sm-12"><span class="b address-detault" id="detault_<?php echo $value['id']; ?>">дефолт</span>
                                                            <a href="javascript:;" class="a-underline address-detault-a" id="address_detault_<?php echo $value['id']; ?>" onclick="default_address(<?php echo $value['id']; ?>);" style="display:none;">Установить по умолчанию</a></p>
                                                            <p class="col-md-8 col-sm-12"><a href="javascript:;" class="btn btn-primary btn-sm"  data-reveal-id="myModal10" onclick="edit_address(<?php echo $value['id']; ?>, 1);">Редактировать</a>
                                                            <a href="javascript:;" class="btn btn-default btn-sm"  data-reveal-id="myModal6" onclick="delete_address(<?php echo $value['id']; ?>);">Удалить</a></p>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                            <p class="col-md-4 col-sm-12"><span class="b address-detault" id="detault_<?php echo $value['id']; ?>" style="display:none;">дефолт</span>
                                                            <a href="javascript:;" class="a-underline address-detault-a" id="address_detault_<?php echo $value['id']; ?>" onclick="default_address(<?php echo $value['id']; ?>);">Установить по умолчанию</a></p>
                                                            <p class="col-md-8 col-sm-12"><a href="javascript:;" class="btn btn-primary btn-sm"  data-reveal-id="myModal10" onclick="edit_address(<?php echo $value['id']; ?>, 1);">Редактировать</a>
                                                            <a href="javascript:;" class="btn btn-default btn-sm"  data-reveal-id="myModal6" onclick="delete_address(<?php echo $value['id']; ?>);">Удалить</a></p>
                                                        <?php
                                                    }
                                                    ?>
                                                    </div>
                                                    <p class="bottom" id="address_list_<?php echo $value['id']; ?>">
                                                        <span><?php echo $value['firstname'] . ' ' . $value['lastname']; ?></span>
                                                        <span class="tel"><?php echo $value['phone']; ?></span>
                                                        <span><?php echo $value['address'] . ', ' . $value['city'] . ', ' . $value['state'] . ', ' . $value['country'] . ', ' . $value['zip']; ?></span>
                                                    </p>
                                            </div>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                    </ul>
                                    <ul class="shipping-address">
                                        <li class="clearfix last">
                                            <a href="javascript:;" class="a-underline" id="add_new_address"  data-reveal-id="myModal10" onclick="return new_address_show();">+Добавить Новый Адрес</a>
                                        </li>
                                    </ul>
                                    </form>
                                </dd>
                            </dl>
                        </div>
                        <div class="address-fill" id="shippingAddressFill" <?php if($has_address) echo 'style="display:none;";' ?>>
                            <h4>АДРЕСЫ ДОСТАВКИ</h4>
                            <form action="" method="post" class="form payment-form form2" onsubmit="return update_address(this);">
                                <input type="hidden" name="is_cart" value="1">
                                <ul>
                                    <li>
                                        <label class="col-xs-12 col-md-3"><span>*</span>Имя:</label>
                                        <input type="text" value="" name="firstname"  id="s_firstname" class="text col-xs-12 col-md-9">
                                    </li>
                                    <li>
                                        <label class="col-xs-12 col-md-3"><span>*</span>Фамилия:</label>
                                        <input type="text" value="" name="lastname" id="s_lastname" class="text col-xs-12 col-md-9">
                                    </li>
                                    <li>
                                        <label class="col-xs-12 col-md-3"><span>*</span> Адрес:</label>
                                        <div>
                                            <textarea class="col-xs-12 col-md-9" name="address" id="s_address"></textarea>
                                            <label class="a1 error" style="display:none;"  generated="true" id="guo_con1">Пожалуйста, выберите вашу страну.</label>
                                        </div>
                                    </li>
                                    <li>
                                        <label class="col-xs-12 col-md-3"><span>*</span>Страна:</label>
                                        <select name="country" class="select-style  col-xs-12 col-md-9" id="s_country" onchange="changeSelectCountry1();$('#billing_country').val($(this).val());">
                                            <option value="">ВЫБЕРИТЕ СТРАНУ</option>
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
                                            $called = str_replace(array('County', 'Province'), array('Страна', 'Провинция'), $called);
                                            ?>
                                            <div class="col-xs-12 col-md-3 call2" id="call2_<?php echo $name; ?>" <?php if ($name != 'Default') echo 'style="display:none;"'; ?>>
                                                <label for="state"><span>*</span> <font id=""><?php echo $called; ?></font>:</label>
                                            </div>
                                            <?php
                                        }
                                        $stateArr = Kohana::config('state.states');
                                        foreach ($stateArr as $country => $states)
                                        {
                                       if($country == "US")
                                         {
                                            $enter_title = 'Введите штат';
                                          }
                                         else
                                        {
                                            $enter_title = 'Введите Страна или Провинция';
                                         }
                                            ?>
                                            <div class="all2 JS_drop" id="all2_<?php echo $country; ?>" style="display:none;">
                                                <select name="" class="select-style col-xs-12 col-md-9 s_state" onblur="$('#billing_state1').val($(this).val());" onchange="acecoun()">
                                                    <option value="">[Выбрать Один]</option>
                                                    <option value=" " class="state-enter">[<?php echo $enter_title; ?>]</option>
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
                                            <input type="text" name="state" id="s_state" class="text col-xs-12 col-md-9" value="" maxlength="320" onchange="acecoun()"  />
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
                                                    document.getElementById("shipping_price_listpc_2").style.display = 'none';
                                                    document.getElementById("price_radio1").checked = true;
                                                    document.getElementById("new_shipping_price").value=0;
                                                }
                                                else
                                                {
                                                    document.getElementById("shipping_price_listpc_2").style.display = 'inline';
                                                }
                                                if(countryCode == 'BR')
                                                {
                                                    $("#shipping_cpf").show();
                                                }
                                                else if(countryCode == 'HK' || countryCode == 'MO' || countryCode == 'TW')
                                                {   
                                
                                                    var aa = $("#guo_con1");
                                                        aa.show();
                                                    aa.html('請輸入中文地址(Пожалуйста, введите адрес на китайском языке.)');
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
                                        <label class="col-xs-12 col-md-3"><span>*</span>Город/Городок:</label>
                                        <input type="text" value="" name="city" id="s_city" class="text col-xs-12 col-md-9" onchange="acedoun()">
                                        <label class="error a4" style="display:none;" generated="true" id="guo_eon1">Название Города с цифрами? Пожалуйста, проверьте точность.</label>
                                    </li>
                                    <li>
                                        <label class="col-xs-12 col-md-3"><span>*</span> Почтовый индекс:</label>
                                        <input type="text" value="" name="zip" id="s_zip" class="text col-xs-12 col-md-9" onchange="ace()">
                                        <label class="error" style="display:none;" generated="true" id="guo_fon1">Кажется, что нет цифр в коде, пожалуйста, проверьте точность.</label>
                                        <p class="phone_tips phone-t">Если вы не используете Индекс в вашем регионе, пожалуйста, введите 0000 вместо.</p>  
                                    </li>
                                    <li>
                                        <label class="col-xs-12 col-md-3"><span>*</span> Телефон:</label>
                                        <input type="text" value="" name="phone" id="s_phone" class="text col-xs-12 col-md-9">
                                    </li>
                                    <li class="hide" value="0">
                                        <label class="col-xs-12 col-md-3"><span>*</span>o cadastro de pessoa Física:</label>
                                        <input type="text" name="cpf" id="s_cpf" class="text col-xs-12 col-md-9" value="">
                                    </li>
                                </ul>
                                <h4>МЕТОДЫ ДОСТАВКИ</h4>
                                <div class="shipping-methods">
                                    <ul class="clearfix">
                                    <?php
                                    foreach($site_shipping as $key => $price)
                                    {
                                    ?>
                                        <li class="col-xs-12" id="shipping_price_listpc_<?php echo $key; ?>" <?php if(in_array($cart['shipping_address']['shipping_country'], $no_express_countries) && $key==2) echo 'style="display:none;"'; ?> >
                                 <div class="method">
                                         <p class="me-ra">
                                          <input type="radio" name="shipping_price1" value="<?php echo $price['price']; ?>" id="price_radio<?php echo $key; ?>" class="radio" <?php if($key == 1) echo 'checked="checked"'; ?> onclick="document.getElementById('new_shipping_price').value = <?php echo $price['price']; ?>;" /> 
                                        </p>
                                   <p class="me-wt"><?php echo $price['name']; ?> </p> 
                                                        <p class="me-pr"><?php echo Site::instance()->price($price['price'], 'code_view'); ?> </p>
                                                    </div>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                    <li class="col-xs-12">
                                                    <div class="method">
                                                        <p class="me-ra">
                                                            <input type="checkbox" value="1" name="insurance" id="insurance" class="radio" checked>
                                                        </p>    
                                                        <p class="me-wt">Добавить страхование доставки  для вашего заказа</p> 
                                                        <p class="me-pr">$0.99</p>
                                                        <div class="insurance JS-show" style="margin-left:4%">
                                                            <b>Почему добавить страховку?</b>
                                                            <div class="ins-info JS-showcon" style="display: none;">
                                                                <b class="arrow-up"></b>
                                                                <div class="ins-tipscon">Страхование Доставки обеспечивает превосходную защиту и безопасность ваших ценных вещей во время международной доставки. Если посылка утеряна или повреждена, мы будем отправить вам новую посылку бесплатно сразу.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </li>
                                    </ul>
                                    <input type="hidden" name="shipping_price" id="new_shipping_price" value="<?php echo $default_shipping; ?>" />
                                </div>
                                <p><input id="spgInfoCountinue" type="submit" value="Дальше" class="btn btn-primary btn-lg"></p>
                            </form>
                        </div>
                    </div>
                    <div class="shipping-information payment-information" id="paymentInfo" <?php if(!$has_address) echo 'style="display:none;"'; ?>>
                        <h2>Информация платежа</h2>
                        <form id="payment_form" method="post" action="" class="form">
                            <dl class="shipping-payment">
                            <?php
                            $no_paypal = 0;
                            if(!$no_paypal)
                            {
                            ?>
                                <dd class="shipping-infor">
                                    <label>
                                        <div>
                                            <input type="radio" value="PP" id="radio_2" class="radio" name="payment_method" checked="" />
                                            PayPal
                                        </div>
                                        <img src="<?php echo STATICURL; ?>/assets/images/card1.jpg"> 
                                        <!-- <p>Если у вас нет счет PayPal, вы также можете оплатить через PayPal с помощью кредитной карты или банковской платежной карты.</p> -->
                                    </label>
                                </dd>
                            <?php
                            }
                            ?>
                                <dd class="shipping-infor">
                                    <label>
                                        <div>
                                            <input type="radio" value="GC" id="radio_1" class="radio" name="payment_method" <?php if($no_paypal) echo 'checked="checked"'; ?> />
                                           Кредитная или дебетовая карта
                                        </div>
                                        <img src="<?php echo STATICURL; ?>/assets/images/card10-0509.png">
                                    </label>
                                </dd>
                                <dd class="shipping-infor" id="sofort_banking" <?php if(!array_key_exists($cart['shipping_address']['shipping_country'], $sofort_countries)) echo 'style="display:none;";' ?>>
                                    <label>
                                        <div>
                                            <input type="radio" value="SOFORT" id="radio_3" class="radio" name="payment_method"/>
                                            SOFORT BANKING
                                        </div>                                          
                                        <img src="<?php echo STATICURL; ?>/assets/images/card12.jpg">
                                    </label>
                                </dd>
                                <dd class="shipping-infor" id="ideal" <?php if($cart['shipping_address']['shipping_country'] != 'NL') echo 'style="display:none;";' ?>>                              
                                    <label>
                                        <div>
                                            <input type="radio" value="IDEAL" id="radio_4" class="radio" name="payment_method"/>
                                            iDEAL
                                        </div>                                          
                                        <img src="<?php echo STATICURL; ?>/assets/images/card13.jpg">
                                    </label>
                                </dd>
                            </dl>
                              </form>
                               
                                    <h2 class="visible-xs-block hidden-sm hidden-md hidden-lg">КУПАН И БАЛЛЫ</h2>
                                    <div class="promo-choies visible-xs-block hidden-sm hidden-md hidden-lg" style="background:none;">
                                    <ul>
                                        <li class="promo-code">
                                            <div class="pc-apply">
                                                <div class="ml10">
                                                    <span class="fll" style="font-weight:bold;">Использовать Код Акции&nbsp;&nbsp;</span> 
                                                    <span style="display:inline-block;">
                                                        <a class="J-pop-btn a-underline" style="margin:0;">
                                                            <i>Перечень кодов</i>
                                                        </a>
                                                    </span>

                                                </div>
                                                <div class="pc-ibutton">
                                                    <form method="post" action="<?php echo LANGPATH; ?>/cart/set_coupon" onsubmit="return setCoupon();">
                                                        <input type="hidden" name="return_url" value="<?php echo LANGPATH ?>/cart/checkout" />
                                                        <input id="coupon_code" name="coupon_code" class="input-promo-code fll"type="text" value="" style="width:63%;">
                                                        <button type="submit" class="btn btn-default btn-xs flr ml10">
                                                            Применение
                                                        </button>
                                                    </form>
                                                    
                                                    <!-- codelist-con -->
                                                    <div class="codelist-con J-popcon hide" style="display:none;" id="available_codes1">
                                                        <span class="close-btn">
                                                        </span>
                                                        <div class="tit">
                                                            <h3>
                                                                Доступные коды
                                                            </h3>
                                                        </div>
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
                                                        <div class="codenone">
                                                            Не доступные коды.
                                                        </div>
                                               <?php
                                                endif;
                                                ?>
                                                    </div>
                                                </div>
                                            </div>                                          
                                        </li>
                                        <li class="promo-code">
                                            <div class="pc-apply">
                                                <div class="ml10">
                                                    <span style="font-weight:bold;">Использовать Баллы Choies</span>
                                                    <span>(10 Баллов=$0.1)</span>

                                                </div>
                                                <div class="pc-ibutton">
                                           <form method="post" action="<?php echo LANGPATH; ?>/cart/point" class="form" id="point_form" onsubmit="return setPoints();">
                                                <input type="hidden" name="return_url" value="<?php echo LANGPATH ?>/cart/checkout" />
                                    <?php $is_celebrity = Customer::instance($customer_id)->is_celebrity(); ?>
                                     <input id="points1" name="points" class="input-promo-code fll" type="text" value="<?php if (!$is_celebrity && $points_avail > 0) echo $points_avail; ?>" onchange="return point2dollar1();" style="width:23%;">
                                    <div class="po-equal">= &nbsp;&nbsp;$</div>
                                      <input id="aaa" class="input-promo-code fll" type="text" value="" style="width:23%;">  
                                                       
                                                        <button type="submit" class="btn btn-default btn-xs flr ml10"  onclick="return point_redeem();">
                                                            Погашение
                                                        </button>
                                                        
                                                    </form>
                                                    <div class="clearfix"></div>
                                                    <div class="points-info" style="font-size:11px;">
                                               <?php
                                                if ($points_avail >= 0){
                                                    ?>
                                                        <span style="font-weight:bold;">
                                                            <?php echo $points_avail; ?>
                                                        </span>
                                                        баллов может быть использован сейчас.
                                                   <?php
                                               }else{
                                                     echo 'Условие использования баллов:Раходы по крайней мере $10.';
                                                }
                                                ?>
                                                        <a class="a-underline hidden-xs">
                                                            VIP Policy
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                             <script type="text/javascript">
                                                var xhr = null;
                                                var amount_left = $('#amount_left').text();
                                            
                                                function point_redeem()
                                                {
                                                    var points = parseFloat(document.getElementById('points1').value);
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
                                            
                                                function point2dollar1()
                                                {
                                                    var point = document.getElementById('points1');
                                                  var point_left = tofloat(parseInt(point.value)*0.01, 2);

                                                    var dollar = document.getElementById('aaa');
                                                    return window.setTimeout(function(){
                                                        if (!parseInt(point.value)) {
                                                            dollar.innerHTML = '0';
                                                            $('#amount_left').text(tofloat(amount_left,2));
                                                            $('#point_left').text('');
                                                            return true;
                                                        }
                                                    
                                                    
                                                        point_left = point_left;
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
                                        </li>
                                    </ul>
                                </div>
                                
                                <ul class="total visible-xs-block hidden-sm hidden-md hidden-lg">
                                    <li class="font14">
                                        <label>
                                            Промежуточный итог:
                                        </label>
                                        <span>
                                           <?php echo Site::instance()->price($cart['amount']['items'], 'code_view'); ?>
                                        </span>
                                    </li>
                                    <li>
                                        <label>
                                            Ориентировочная Доставка:
                                        </label>
                                        <span id="shipping_total">
                                            <?php echo $cart_shipping == -1 ? Site::instance()->price($site_shipping[2]['price'], 'code_view') : Site::instance()->price($cart_shipping, 'code_view'); ?>
                                        </span>
                                    </li>
                 <li class="last" id="oii_insurance" <?php  if($session_insurance == -1) echo 'style="display:none;"'; ?>>
                                        <label>
                                            страхование доставки: 
                                        </label>
                                        <span id="oi_insurance"><?php echo Site::instance()->price($cart['amount']['insurance'], 'code_view'); ?>
                                        </span>
                                    </li>
                           <?php
                            $coupon_points_save = 0;
                            if ($cart['amount']['coupon_save'] + $cart['amount']['point'] > 0)
                            {
                                $coupon_points_save = $cart['amount']['coupon_save'] + $cart['amount']['point'];
                            }
                            ?>
                            <li id="coupon_points_save" <?php if(!$coupon_points_save) echo 'style="display:none;"'; ?>>
                                        <label>
                                            Платеж с купоном и баллами:
                                        </label>
<span id="save_total"><?php echo Site::instance()->price($cart['amount']['coupon_save'] + $cart['amount']['point'], 'code_view'); ?></span>
                                    </li>

                           <?php
                            $saving = $cart['amount']['items'] + $cart['amount']['shipping'] - $cart['amount']['total'];
                            $item_saving = round($saving - $cart['amount']['coupon_save'] - $cart['amount']['point'], 2);

                            if ($item_saving > 0){
                                ?>
                                <li><label>Sale Items Saving: </label><span><?php echo Site::instance()->price($item_saving, 'code_view'); ?></span></li> 
                                <?php
                            }
                            ?>
                           <?php
                            if($saving <= 0){
                                $saving = 0;
                            }
                            ?>
                                    <li class="last red">
                                        <label>
                                            Экономить:
                                        </label>
<span id="cart_saving"><?php echo Site::instance()->price($saving, 'code_view'); ?>
                                        </span>
                                    </li>
                                    <li class="total-num font14">
                                        <label>
                                            Итого:
                                        </label>
                                  <?php  if($session_insurance != -1){ 
                                    $insurance = 0.99;
                                  }else{
                                    $insurance = 0;
                                    }  ?>
<span id="totalPrice" class="font18"><?php echo $cart['amount']['shipping'] ? Site::instance()->price($cart['amount']['total']+ $insurance, 'code_view') : Site::instance()->price($cart['amount']['total'] + $default_shipping+ $insurance, 'code_view'); ?>
                                        </span>
                                    </li>
                                </ul>
                                <p class="mt20">
                                    <input type="submit" class="btn btn-primary btn-lg" id="checkoutbtn" value="Подтвердить и оплатить" onclick="return btn_loading();">
                                <div id="loadingbtn" style="display:none;">
                                    <button type="button" class="btn btn-primary btn-lg" disabled="disabled">Подтвердить и оплатить</button>
                                    <img src="/assets/images/loading.gif" />
                                </div>
                                </p>    
                             

 
                  
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-sm-offset-1 hidden-xs">
                    <div class="order-summary">
                        <h3>
                            Общая сумма заказа
                        </h3>
                        <ul class="pro-con1">
                        <?php
                        $ecomm_prodid = array();
                        $p_saving = 0;
                        foreach (array_reverse($cart['products']) as $key => $product):
                            $sku = Product::instance($product['id'])->get('sku');
                            $ecomm_prodid[] = "'$sku'";
                            $name = Product::instance($product['id'], LANGUAGE)->get('name');
                            $img = Product::instance($product['id'])->cover_image();
                            ?>
                            <li class="clearfix">
                                <div class="left"><img src="<?php echo STATICURL.'/pimg/75/' . $img['id'] . '.' . $img['suffix']; ?>" alt="<?php echo $name; ?>" /></div>
                                <div class="right">
                                    <p class="name"><?php echo $name; ?></p>
                                    <p class="color666">Товар: #<?php echo $sku; ?></p>
                                    <b class="font14"><?php echo Site::instance()->price($product['price'], 'code_view'); ?></b>
                                    <p>
                                        <?php
                                        $delivery_time = kohana::config('prdress.delivery_time');
                                        if (isset($product['attributes'])):
                                            foreach ($product['attributes'] as $attribute => $option):
                                                $attribute = str_replace('Size', 'Размеры', $attribute);
                                            $option = str_replace('one size', 'только один размер', $option);
                                                if ($attribute == 'delivery time')
                                                    $option = $option > 0 ? 'Rush Order' . ' ( + ' . Site::instance()->price($option, 'code_view') . ' )' : 'Regular Order';
                                                echo ucfirst($attribute) . ': ' . $option . '<br>';
                                            endforeach;
                                        endif;
                                        ?>
                                    </p> 
                                    <p>Количество.: <?php echo $product['quantity']; ?></p>
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
                                $link = Product::instance($product['id'])->permalink();
                                ?>
                                <li class="clearfix">
                                    <div class="left"><a href="<?php echo $link; ?>"><img src="<?php echo STATICURL.'/pimg/75/' . $img['id'] . '.' . $img['suffix']; ?>" alt="<?php echo $name; ?>" /></a></div>
                                    <div class="right">
                                        <a href="<?php echo $link; ?>" class="name"><?php echo $name; ?></a>
                                        <p>Товар: #<?php echo $sku; ?></p>
                                        <p><?php echo Site::instance()->price($product['price'], 'code_view'); ?></p>
                                        <p>
                                            <?php
                                            $delivery_time = kohana::config('prdress.delivery_time');
                                            if (isset($product['attributes'])):
                                                foreach ($product['attributes'] as $attribute => $option):
                                                    $attribute = str_replace('Size', 'Размеры', $attribute);
                                                   $option = str_replace('one size', 'только один размер', $option);
                                                    if ($attribute == 'delivery time')
                                                        $option = $option > 0 ? 'Rush Order' . ' ( + ' . Site::instance()->price($option, 'code_view') . ' )' : 'Regular Order';
                                                    echo ucfirst($attribute) . ': ' . $option . '<br>';
                                                endforeach;
                                            endif;
                                            ?>
                                        </p> 
                                        <p>Количество.: <?php echo $product['quantity']; ?></p>
                                    </div>
                                </li>
                                <?php
                                $p_saving += Product::instance($product['id'])->get('price') - $product['price'];
                            endforeach;
                        endif;
                        ?>
                        </ul>
                        <ul class="total">
                            <li class="font14"><label>Промежуточный итог: </label><span><?php echo Site::instance()->price($cart['amount']['items'], 'code_view'); ?></span></li>     
                            <li><label>Ориентировочная Доставка: </label><span id="shipping_total_pc"><?php echo $cart_shipping == -1 ? Site::instance()->price($site_shipping[2]['price'], 'code_view') : Site::instance()->price($cart_shipping, 'code_view'); ?></span></li>
                        <li class="last" id="oii_insurance_pc" <?php  if($session_insurance == -1) echo 'style="display:none;"'; ?>>
                                        <label>
                                            страхование доставки: 
                                        </label>
                                        <span id="oi_insurance_pc"><?php echo Site::instance()->price($cart['amount']['insurance'], 'code_view'); ?>
                                        </span>
                          </li>
                            <?php
                            $coupon_points_save = 0;
                            if ($cart['amount']['coupon_save'] + $cart['amount']['point'] > 0)
                            {
                                $coupon_points_save = $cart['amount']['coupon_save'] + $cart['amount']['point'];
                            }
                            ?>
                            <li id="coupon_points_save_pc" <?php if(!$coupon_points_save) echo 'style="display:none;"'; ?>>
                                <label>Платеж с купоном и баллами: </label><span id="save_total_pc"><?php echo Site::instance()->price($cart['amount']['coupon_save'] + $cart['amount']['point'], 'code_view'); ?></span>
                            </li>
                            <?php
                            $saving = $cart['amount']['items'] + $cart['amount']['shipping'] - $cart['amount']['total'];
                            $item_saving = round($saving - $cart['amount']['coupon_save'] - $cart['amount']['point'], 2);

                            if ($item_saving > 0):
                                ?>
                                <li><label>Сохранение Товаров Продажи: </label><span><?php echo Site::instance()->price($item_saving, 'code_view'); ?></span></li> 
                                <?php
                            endif;
                            ?>

                            <?php
                            $saving += $p_saving;
                            if($saving <= 0)
                                $saving = 0;
                            ?>
                            <li class="last red"><label>Экономить: </label><span id="cart_saving_pc"><?php echo Site::instance()->price($saving, 'code_view'); ?></span></li>
                            <li class="total-num font14"><label>Итого: </label>
                    <?php  if($session_insurance != -1){ 
                                    $insurance = 0.99;
                                  }else{
                                    $insurance = 0;
                                    }  ?>
                    <span id="totalPrice_pc" class="font18"><?php echo $cart['amount']['shipping'] ? Site::instance()->price($cart['amount']['total'] + $insurance, 'code_view') : Site::instance()->price($cart['amount']['total'] + $default_shipping + $insurance, 'code_view'); ?></span></li>

                        </ul>
                        <div class="promo-choies">
                            <ul>
                                <li class="promo-code">
                                    <div class="pc-apply">
                                    <div class="ml10">
                       <span class="fll" style="font-weight:bold;">Использовать Код Акции&nbsp;&nbsp;</span>
                            <span style="display:inline-block;">
                                                        <a class="J-pop-btn a-underline" style="margin:0;">
                                                            <i>Перечень кодов</i>
                                                        </a>
                                                    </span>
                                    </div>
                                        <div class="pc-ibutton">
                                            <form method="post" action="<?php echo LANGPATH; ?>/cart/set_coupon" onsubmit="return setCoupon();">
                                                <input type="hidden" name="return_url" value="<?php echo LANGPATH ?>/cart/checkout" />
                                                <input id="coupon_code1" name="coupon_code" class="input-promo-code fll" type="text" value="" style="width:64%;margin: 0 10px 10px 0;">
                                                <button type="submit" class="btn btn-default btn-xs fll">Применение</button>
                                            </form>
                                            <!-- <a class="J-pop-btn a-underline flr">Перечень кодов</a> -->
                                            <!-- codelist_con -->
                                            <div class="codelist-con J-popcon hide" id="available_codes">
                                                <span class="close-btn"></span>
                                                <div class="tit"><h3>Доступные коды</h3></div>
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
                                                    <div class="codenone">Не доступные коды.</div> 
                                                <?php
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="promo-code">
                                    <div class="pc-apply">
                                    <div class="ml10">
                                       
<span style="font-weight:bold;">Использовать Баллы Choies</span>
                                                    <span>(10 Баллов=$0.1)</span>
                                        <div class="pc-ibutton">
                                            <form method="post" action="<?php echo LANGPATH; ?>/cart/point" class="form" id="point_form" onsubmit="return setPoints();">
                                                <input type="hidden" name="return_url" value="<?php echo LANGPATH ?>/cart/checkout" />
                                                <?php $is_celebrity = Customer::instance($customer_id)->is_celebrity(); ?>
                                                <input id="points" name="points" class="input-promo-code fll" type="text" value="<?php if (!$is_celebrity && $points_avail > 0) echo $points_avail; ?>" onkeydown="return point2dollar();" style="width:24%;margin:0 0 10px 0;">
                                                <div class="po-equal">= &nbsp;&nbsp;$</div>
                                                        <input id="aab" class="input-promo-code fll" type="text" value="" style="width:24%;margin:0 10px 10px 0;">
                                                <button type="submit" class="btn btn-default btn-xs fll" onclick="return point_redeem();">Погашение</button>
                                            </form>
                                            <div class="clearfix"></div>
                                            <div class="points-info" style="font-size:11px;">
                                            <!-- Save: <span class="red">$ <span id="dollar">0</span></span><br> -->
                                                <!-- (10 Баллов=$0.1)   -->
                                                <?php
                                                if ($points_avail >= 0):
                                                    ?>
                                                    <span class="red"><?php echo $points_avail; ?></span>баллов может быть использован сейчас.
                                                    <?php
                                                else:
                                                     echo 'Условие использования баллов:Раходы по крайней мере $10.';
                                                endif;
                                                ?>
                                                <br>
                                                <!-- <a class="a-underline JS-popwinbtn" style="display: inline;">VIP статус</a> -->
                                            </div>
                                            <script type="text/javascript">
                                                var xhr = null;
                                                var amount_left = $('#amount_left').text();
                                            
                                                function point_redeem()
                                                {

                                                    var points = parseFloat(document.getElementById('points').value);
                                                    if (points > <?php print $points_avail; ?>) {
                                                        window.alert('Баллов не хватит сейчас');
                                                        return false;
                                                    }
                                                    else
                                                    {
                                                        
                                                        // return false;
                                                    }
                                                }
                                            
                                                function point2dollar()
                                                {
                                                    var point = document.getElementById('points');
                                                    var dollar = document.getElementById('dollar');
                                                    var dollar1 = document.getElementById('aab');
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
                                                        dollar1.value = point_left;
                                                    }, 0);
                                                }
                                            </script>
                                        </div>
                                    </div>
                                </li>
                            </ul>              
                        </div>
                        <div class="additional-payment mt20">
                            <form action="<?php echo LANGPATH; ?>/cart/set_message" method="post" class="form user-message" onsubmit="return setMessage();">
                                <input type="hidden" name="return_url" value="<?php echo LANGPATH; ?>/cart/checkout" />
                                <input type="hidden" name="message_change" value="" id="message_change" />
                                <b>Сообщение:</b>
                                <br /><label style="color:#878787;height:20px;">(5-100 символов)</label>
                                <div class="right-box">
                                    <textarea class="textarea-long" maxlength="150" minlength='5' id="set_message" name="message" style="width: 100%; height: 63px;color: #878787;background-color: #fff;<?php if($cart_message) echo 'display:none;'; ?>"  onkeydown="return messageChange();" 
                                    onfocus="if(this.value=='Вы можете оставить сообщение, чтобы поменить информацию. все сообщения будут ответить в течение 24 часов.') 
                                    {this.value='';}this.style.color='#000';" onblur="if(this.value=='') {this.value='Вы можете оставить сообщение, чтобы поменить информацию. все сообщения будут ответить в течение 24 часов.';this.style.color='#878787';}"
                                    ><?php if($cart_message) {echo $cart_message;} else { echo 'Вы можете оставить сообщение, чтобы поменить информацию. все сообщения будут ответить в течение 24 часов.'; } ?></textarea>
                                    <p id="now_message" style="font-style: normal;font-weight: normal;color:#666;<?php if(!$cart_message) echo 'display:none;'; ?>">
                                    <?php if($cart_message) echo $cart_message; ?>
                                    </p>
                                    <a href="javascript:;" onclick="editMessage();" id="message_edit" style="text-decoration: underline;<?php if(!$cart_message) echo 'display:none;'; ?>">Написать</a>
                                    <button class="btn btn-default btn-xs mt10" type="submit" id="message_submit" <?php if($cart_message) echo 'style="display:none;"'; ?>>Дальше</button>
                                </div>
                            </form>
                            <p class="mt10">
                                Дополнительная безопасность платежа с:
                            </p>
                            <img src="<?php echo STATICURL; ?>/assets/images/card11.jpg">
                            <div id="paypal_shipping_refund">
                                <?php
                                $show_img = '';
                                if(isset($cart['shipping_address']['shipping_country']))
                                {
                                    $now_country = $cart['shipping_address']['shipping_country'];
                                    $show_img = isset($paypal_refund_config[$now_country]) ? $paypal_refund_config[$now_country] : '';
                                }
                                ?>
                                <a target="_blank" href="https://www.paypal.eu/returns/" class="en" <?php if($show_img != 'en') echo 'style="display:none;"'; ?>><img src="/assets/images/paypal_refund_en.jpg" /></a>
                                <a target="_blank" href="https://www.paypal.fr/retours/" class="fr" <?php if($show_img != 'fr') echo 'style="display:none;"'; ?>><img src="/assets/images/paypal_refund_fr.jpg" /></a>
                                <a target="_blank" href="https://www.paypal.eu/returns/" class="ru" <?php if($show_img != 'ru') echo 'style="display:none;"'; ?>><img src="/assets/images/paypal_refund_ru.jpg" /></a>
                                <a target="_blank" href="https://www.paypal.es/devoluciones/" class="es" <?php if($show_img != 'es') echo 'style="display:none;"'; ?>><img src="/assets/images/paypal_refund_es.jpg" /></a>
                                <a target="_blank" href="https://www.paypal.eu/ch/retourenserviceaktivieren/" class="de" <?php if($show_img != 'de') echo 'style="display:none;"'; ?>><img src="/assets/images/paypal_refund_de.jpg" /></a>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
            </div>  
        </div>
    </div>
</div>
<footer>
    <div class="footer_payment">
        <div class="card">
            <p class="paypal-card container"><img src="<?php echo STATICURL; ?>/assets/images/card-0509.jpg" usemap="#Card" /></p>
            <map name="Card" id="Card">
                <area target="_blank" shape="rect" coords="88,2,193,62" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=<?php echo URLSTR; ?>&lang=en" />
            </map>
            <div style="background-color:#232121;">
                <p class="bottom">
                    Copyright © 2006-<?php echo date('Y'); ?> Choies.com
                </p>
            </div>
        </div>
    </div>
</footer>
<div id="gotop" class="hide ">
    <a href="#" class="xs-mobile-top"></a>
</div>
</div>
<!-- JS-popwincon1 -->
<div id="myModal10" class="reveal-modal large">
        <a class="close-reveal-modal close-btn3"></a>
    <div class="address-fill">
        <h4>Адрес Для Доставки</h4>
        <form onsubmit="return update_address(this);" method="post" class="form payment-form form1">
            <input type="hidden" name="address_id" id="shipping_address_id" value="<?php echo $cart['shipping_address']['shipping_address_id']; ?>" />
            <input type="hidden" name="is_cart" id="is_cart" value="1" />
            <ul>
                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span> Имя:</label>
                    <input type="text" value="<?php echo $cart['shipping_address']['shipping_firstname']; ?>" name="firstname" id="shipping_firstname" class="text col-xs-12 col-md-9">
                </li>
                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span> Фамилия:</label>
                    <input type="text" value="<?php echo $cart['shipping_address']['shipping_lastname']; ?>" name="lastname" id="shipping_lastname" class="text col-xs-12 col-md-9">
                </li>
                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span>  Адрес:</label>
                    <div>
                        <textarea class="col-xs-12 col-md-9" name="address" id="shipping_address" onchange="ace2()"><?php echo $cart['shipping_address']['shipping_address']; ?></textarea>
                        <label class="a1 error" style="display:none;"  generated="true" id="guo_con">Пожалуйста, выберите вашу страну.</label>
                    </div>
                </li>
                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span> Страна:</label>
                    <select name="country" class="select-style  col-xs-12 col-md-9" id="shipping_country" onchange="changeSelectCountry2();$('#billing_country').val($(this).val());">
                        <option value="">ВЫБЕРИТЕ СТРАНУ</option>
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
                        $called = str_replace(array('County', 'Province'), array('Область', 'Провинция'), $called);
                        ?>
                        <div class="col-xs-12 col-md-3 call2" id="call2_<?php echo $name; ?>" <?php if ($name != 'Default') echo 'style="display:none;"'; ?>>
                            <label for="state"><span>*</span> <font id=""><?php echo $called; ?></font>:</label>
                        </div>
                        <?php
                    }
                    $stateArr = Kohana::config('state.states');
                    foreach ($stateArr as $country => $states)
                    {
                        $enter_title = 'Выберите Один';
                        ?>
                        <div class="all2 JS_drop" id="all2_<?php echo $country; ?>" style="display:none;">
                            <select name="" class="select-style col-xs-12 col-md-9 s_state" id="s_state" onblur="$('#billing_state1').val($(this).val());" onchange="acecoun()">
                                <option value=" " class="state-enter">[<?php echo $enter_title; ?>]</option>
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
                        <input type="text" name="state" id="shipping_state" class="text col-xs-12 col-md-9" value="<?php echo $cart['shipping_address']['shipping_state']; ?>" maxlength="320" onchange="acecoun()" />
                        <div class="errorInfo"></div>
                        <label class="error a3" style="display:none;"  generated="true" id="guo_don">Название Области / Провинции с цифрами? Пожалуйста, проверьте точность.</label>
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
                                ooo.html('請輸入中文地址(Пожалуйста, введите адрес на китайском языке.)');
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
                    <label class="col-xs-12 col-md-3"><span>*</span>Город/Городок:</label>
                    <input type="text" value="<?php echo $cart['shipping_address']['shipping_city']; ?>" name="city" id="shipping_city" class="text col-xs-12 col-md-9" onchange="acedoun()">
                    <label class="error a4" style="display:none;"  generated="true" id="guo_eon">Название Города с цифрами? Пожалуйста, проверьте точность.</label>
                </li>
                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span>Почтовый индекс:</label>
                    <input type="text" value="<?php echo $cart['shipping_address']['shipping_zip']; ?>" name="zip" id="shipping_zip" class="text col-xs-12 col-md-9" onchange="ace()">
                    <label class="error" style="display:none;" generated="true" id="guo_fon">Кажется, что нет цифр в коде, пожалуйста, проверьте точность.</label>
                    <p class="phone_tips">Если вы не используете Индекс в вашем регионе, пожалуйста, введите 0000 вместо.</p>
                </li>
                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span>Телефон:</label>
                    <input type="text" value="<?php echo $cart['shipping_address']['shipping_phone']; ?>" name="phone" id="shipping_phone" class="text col-xs-12 col-md-9">
                    <p class="mt5 col-md-offset-3 col-xs-12 col-md-9 phone_tips">Введите правильный и полный номер телефона,чтобы почтальон товары точно доставил.</p>
                </li>
                <li class="hide" value="0">
                    <label class="col-xs-12 col-md-3"><span>*</span>o cadastro de pessoa Física:</label>
                    <input type="text" name="cpf" id="shipping_cpf" class="text col-xs-12 col-md-9" value="">
                </li>
            </ul>
            <p class="col-md-offset-3 col-xs-12 col-md-9"><input type="submit" value="Дальше" class="btn btn-default"></p>
        </form>
    </div>
</div>
<!-- JS-popwincon3 -->
<div id="myModal6" class="reveal-modal medium" id="cart_delete">
        <a class="close-reveal-modal close-btn3"></a>
    <h3>ПОДВЕРДИТЬ ОПЕРАЦИИ</h3>
    <div class="order-addtobag">
        <div class="prompt">Вы уверены, что хотите удалить этот адрес?</div>
        <form action="/cart/delete_address" method="post" id="delete_address_form" onsubmit="return delete_address_submit();">
             <input type="hidden" name="address_id" id="address_id" value="" />
            <input type="submit" class="btn btn-default btn-sm" value="DELETE">
            <a class="cancel" href="">Отменить</a>
        </form>
    </div>
</div>

<div class="JS-popwincon popwincon hide">
    <a class="JS-close1 close-btn3"></a>
    <div class="vip">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody><tr>
                    <th width="15%" class="first">
            <div class="r">Привилегии</div>
            <div>Уровень VIP</div>
            </th>
            <th width="20%">Накопленная сумма сделки</th>
            <th width="16%">Товары с дополнительной скидкой</th>
            <th width="16%">Разрешения использования баллов</th>
            <th width="15%">Награда баллов заказов</th>
            <th width="18%">Другие привилегии</th>
            </tr>
            <tr>
                <td><span class="icon_nonvip" title="Non-VIP"></span><strong>Non-VIP</strong></td>
                <td>$0</td>
                <td>/</td>
                <td rowspan="6"><div>Вы можете использовать баллы в размере до 10% стоимости заказа.</div></td>
                <td rowspan="6">$1 = 1 points</td>
                <td>15% off код купона</td>
            </tr>
            <tr>
                <td><span class="icon_vip" title="Diamond VIP"></span><strong>VIP</strong></td>
                <td>$1 - $199</td>
                <td>/</td>
                <td rowspan="5"><div>Получите двойные баллы во время крупных праздников.<br>
                        Особый подарок на день рождения.<br>
                        И больше</div></td>
            </tr>
            <tr>
                <td><span class="icon_bronze" title="VIP Бронза"></span><strong>VIP Бронза</strong></td>
                <td>$199 - $399</td>
                <td>5% OFF</td>
            </tr>
            <tr>
                <td><span class="icon_silver" title="VIP Серебра"></span><strong>VIP Серебра</strong></td>
                <td>$399 - $599</td>
                <td>8% OFF</td>
            </tr>
            <tr>
                <td><span class="icon_gold" title="VIP Золота"></span><strong>VIP Золота</strong></td>
                <td>$599 - $1999</td>
                <td>10% OFF</td>
            </tr>
            <tr>
                <td><span class="icon_diamond" title="VIP Бриллианты"></span><strong>VIP Бриллианты</strong></td>
                <td>≥ $1999</td>
                <td>15% OFF</td>
            </tr>
            </tbody></table>
    </div>
</div>

<script type="text/javascript">
    var ms = 'Совет: Теперь Бесплатная Доставка в России, почта не будет сообщить покупателям забрать посылку, а мы будем послать Е-mail на вашу электронную почту, и сообщить вам забрать посылку после того, что посылка пришла в почте. <b>Пожалуйста, почаще проверяйте свою почту, не ставьте</b><a target="_blank" href="mailto:service_ru@choies.com" style="color:red;"> service_ru@choies.com</a> <b>в спам список.</b>';
    showup(ms);
    
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

//guo 
$("#sprice_radios1, #sprice_radios_ph1").click(function(){
    showup(ms);
})

function setShipping(formObj)
{
    var datas = createData(formObj);
    $.ajax({
        type:"POST",
        url :"<?php echo LANGPATH; ?>/cart/ajax_shipping_price",
        data:datas,
        dataType:"json",
        success:function(res){
            if(res.response ==1){
                document.getElementById('oii_insurance').style.display = 'block';
                 document.getElementById('oi_insurance').innerHTML = res.insurance;
                document.getElementById('oii_insurance_pc').style.display = 'block';
                 document.getElementById('oi_insurance_pc').innerHTML = res.insurance;
                 document.getElementById('totalPrice').innerHTML = res.total;
                 document.getElementById('totalPrice_pc').innerHTML = res.total;
                 return false;
            }
            if(res.response ==2){
                document.getElementById('oii_insurance').style.display = 'none';
                document.getElementById('oii_insurance_pc').style.display = 'none';
                document.getElementById('totalPrice').innerHTML = res.total;
                document.getElementById('totalPrice_pc').innerHTML = res.total;
                return false;
            }
            var ship_name = $("#sprice_title" + res.val).text();
/*            document.getElementById('shipping_price_list').innerHTML = '';
            document.getElementById('shipping_price_list').innerHTML = ship_name;*/
            document.getElementById('shipping_total').innerHTML = '';
            document.getElementById('shipping_total').innerHTML = res.price;
            document.getElementById('shipping_total_pc').innerHTML = '';
            document.getElementById('shipping_total_pc').innerHTML = res.price;
            document.getElementById('totalPrice').innerHTML = '';
            document.getElementById('totalPrice').innerHTML = res.total;
            document.getElementById('totalPrice_pc').innerHTML = '';
            document.getElementById('totalPrice_pc').innerHTML = res.total;
           // $(".opacity").hide();
            $(".JS-popwincon2").hide();
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
        url :"<?php echo LANGPATH; ?>/cart/set_address",
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
        url :"<?php echo LANGPATH; ?>/address/ajax_default/",
        data:datas,
        dataType:"json",
        success:function(res){
            if(res.success == 1)
            {
                alert(res.message);
                $(".address-detault").hide();
                $(".address-detault-a").show();
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
    if(typeof(is_cart) == 'undefined')
    {
        is_cart = 1;
    }
    datas = new Object();
    datas.id = id;
    $.ajax({
        type:"POST",
        url :"<?php echo LANGPATH; ?>/address/ajax_data",
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
               var s_name = 'all2_'+address.country;
                    if(document.getElementById(s_name))
                    {
                     $(".states2 .all2").hide();
                     $(".states2 #"+s_name).show();
                     $(".states2 #"+s_name+ " select").val(address.state);
                     document.getElementById('shipping_state').style.display = 'none';
                    }
                    else
                    {
                     $(".states2 .all2").hide();
                     $("#all2_default").show();
                     document.getElementById('shipping_state').style.display = 'block';
                    }
            }
            else
            {
           //     alert('failed');
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
            url : '<?php echo LANGPATH; ?>/address/ajax_edit1',
            data: datas,
            dataType: "json",
            success: function(result){
                if(result.success == 1){
                    var change = '';
                    if(result.count_address > 1)
                        change = '<a href="javascript:;" class="red" onclick="change_address_show();">Change</a>';
                    var shipping_address_list = '<dt>АДРЕСЫ ДОСТАВКИ  <a href="javascript:;" class="red"  data-reveal-id="myModal10" onclick="return edit_address('+result.address_id+');">Редактировать</a>'+change+'</dt>'+
                                    '<dd class="fix"><label>Имя:</label><span>'+datas.firstname+' '+datas.lastname+'</span></dd>'+
                                    '<dd class="fix"><label>Телефон:</label><span>'+datas.phone+'</span></dd>'+
                                    '<dd class="fix"><label>Адрес:</label><span>'+datas.address+', '+datas.city+' '+datas.state+', '+datas.country+' '+datas.zip+'</span></dd>';
                    document.getElementById('shipping_address_list').innerHTML = '';
                    document.getElementById('shipping_address_list').innerHTML = shipping_address_list;
                    change_paypal_refund(datas.country);
                    if(result.val ==15){
                      document.getElementById('sprice_radios2').checked=true;
                      document.getElementById('sprice_radios1').checked=false;
                    }
                    if(result.has_no_express)
                    {
                        var ship_name = $("#sprice_title" + result.shipping_val).text();
                        document.getElementById('shipping_price_list_2').style.display = 'none';
                        document.getElementById('shipping_price_list_1').style.display = 'block';
                        document.getElementById('aaab').style.display = 'block';
                        document.getElementById('shipping_total').innerHTML = '';
                        document.getElementById('shipping_total').innerHTML = result.shipping_price;
                        document.getElementById('totalPrice').innerHTML = '';
                        document.getElementById('totalPrice').innerHTML = result.total_price;
                        document.getElementById('totalPrice_pc').innerHTML = '';
                        document.getElementById('totalPrice_pc').innerHTML = result.total_price;
                    }
                    else
                    {
                       document.getElementById('shipping_price_list_2').style.display = 'block';
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
                                            '<div class="clearfix">'+
                                                '<input type="radio" value="'+result.address_id+'" name="address_id" id="radio'+result.count_address+'" class="radio" onclick="select_address('+result.address_id+');" checked="checked">'+
                                                '<label for="radio'+result.count_address+'">'+
                                                '<b class="s1">Adresse'+result.count_address+'</b></label>'+
                                                    '<div class="flr">'+
                                                        '<span class="b address-detault" id="detault_'+result.address_id+'" style="display:none;">дефолт</span>'+
                                                            '<a href="javascript:;" class="a-underline address-detault-a" id="address_detault_'+result.address_id+'" onclick="default_address('+result.address_id+');">Установить по умолчанию</a>'+
                                                            '<a href="javascript:;" class="view_btn  btn btn-primary btn-sm btn40"  data-reveal-id="myModal10"  onclick="edit_address('+result.address_id+', 1);">Редактировать</a>'+
                                                            '<a href="javascript:;" class="view_btn btn26 delete_address btn btn-default btn-sm"  data-reveal-id="myModal6" onclick="delete_address('+result.address_id+');">Удалить</a>'+
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

                    //common alert
                    $("#myModal10").css("visibility","hidden");
                    $(".reveal-modal-bg").fadeOut();
                    $.ajax({
                        type:"POST",
                        url :"<?php echo LANGPATH; ?>/cart/ajax_shipping_price",
                        data:"shipping_price="+datas.shipping_price,
                        dataType:"json",
                        success:function(res){
                          if(res.val == 15){
                             document.getElementById('sprice_radios1').checked=false;
                              document.getElementById('sprice_radios2').checked=true;
                            }
                           document.getElementById('shipping_total').innerHTML = '';
                            document.getElementById('shipping_total').innerHTML = res.price;
                            document.getElementById('shipping_total_pc').innerHTML = '';
                            document.getElementById('shipping_total_pc').innerHTML = res.price;
                            document.getElementById('totalPrice').innerHTML = '';
                            document.getElementById('totalPrice').innerHTML = res.total;
                            document.getElementById('totalPrice_pc').innerHTML = '';
                            document.getElementById('totalPrice_pc').innerHTML = res.total;
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
            url : '<?php echo LANGPATH; ?>/address/ajax_edit1',
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
                                                '<b class="s1">Address'+result.count_address+'</b></label>'+
                                                    '<div class="clearfix">'+
                                                        '<span class="b address-detault" id="detault_'+result.address_id+'" style="display:none;">дефолт</span>'+
                                                            '<a href="javascript:;" class="a-underline address-detault-a" id="address_detault_'+result.address_id+'" onclick="default_address('+result.address_id+');">Установить по умолчанию</a>'+
                                                            '<a href="javascript:;" class="view_btn  btn btn-primary btn-sm btn40"   data-reveal-id="myModal10" onclick="edit_address('+result.address_id+', 1);">Редактировать</a>'+
                                                            '<a href="javascript:;" class="view_btn btn26 delete_address btn btn-default btn-sm" onclick="delete_address('+result.address_id+');">Удалить</a>'+
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
                        change = '<a href="javascript:;" class="red" onclick="change_address_show();">Изменить</a>';
                    var shipping_address_list = '<dt>АДРЕСЫ ДОСТАВКИ  <a href="javascript:;" class="red"  data-reveal-id="myModal10" onclick="return edit_address('+result.address_id+');">Редактировать</a>'+change+'</dt>'+
                                    '<dd class="fix"><label>Имя:</label><span>'+datas.firstname+' '+datas.lastname+'</span></dd>'+
                                    '<dd class="fix"><label>Телефон:</label><span>'+datas.phone+'</span></dd>'+
                                    '<dd class="fix"><label>Адрес:</label><span>'+datas.address+', '+datas.city+' '+datas.state+', '+datas.country+' '+datas.zip+'</span></dd>';
                    document.getElementById('shipping_address_list').innerHTML = '';
                    document.getElementById('shipping_address_list').innerHTML = shipping_address_list;
                    change_paypal_refund(datas.country);
                    if(result.val ==15){
                      document.getElementById('sprice_radios2').checked=true;
                      document.getElementById('sprice_radios1').checked=false;
                    }
                    if(result.has_no_express)
                    {
                        var ship_name = $("#sprice_title" + result.shipping_val).text();
                        document.getElementById('shipping_price_list_2').style.display = 'none';
                        document.getElementById('shipping_price_list_1').style.display = 'block';
                        document.getElementById('shipping_total').innerHTML = '';
                        document.getElementById('shipping_total').innerHTML = result.shipping_price;
                        document.getElementById('shipping_total_pc').innerHTML = '';
                        document.getElementById('shipping_total_pc').innerHTML = result.shipping_price;
                        document.getElementById('totalPrice').innerHTML = '';
                        document.getElementById('totalPrice').innerHTML = result.total_price;
                        document.getElementById('totalPrice_pc').innerHTML = '';
                        document.getElementById('totalPrice_pc').innerHTML = result.total_price;
                    }
                    else
                    {
                        document.getElementById('shipping_price_list_2').style.display = 'block';
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

                    //common alert
                    $(".reveal-modal-bg").fadeOut();
                    $("#myModal10").css("visibility","hidden");          
                    $(".opacity").hide();
                    $(".JS-popwincon1").hide();
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
        url : '<?php echo LANGPATH; ?>/cart/ajax_shipping',
        data: datas,
        dataType: "json",
        success: function(res){
            var change = '';
            if(res.count_address > 1)
                change = '<a href="javascript:;" class="red" onclick="change_address_show();">Изменить</a>';
            var shipping_address_list = '<dt>АДРЕСЫ ДОСТАВКИ   <a href="javascript:;" class="red"   data-reveal-id="myModal10" onclick="return edit_address('+res.shipping_address_id+');">Редактировать</a>'+change+'</dt>'+
                    '<dd class="fix"><label>Имя:</label><span>'+res.shipping_firstname+' '+res.shipping_lastname+'</span></dd>'+
                    '<dd class="fix"><label>Телефон:</label><span>'+res.shipping_phone+'</span></dd>'+
                    '<dd class="fix"><label>Адрес:</label><span>'+res.shipping_address+', '+res.shipping_city+' '+res.shipping_state+', '+res.shipping_country+' '+res.shipping_zip+'</span></dd>';
            document.getElementById('shipping_address_list').innerHTML = '';
            document.getElementById('shipping_address_list').innerHTML = shipping_address_list;
            change_paypal_refund(res.shipping_country);

            if(res.has_no_express)
            {
                document.getElementById('sprice_radios1').checked=true;
                var ship_name = $("#sprice_title" + res.shipping_val).text();
                document.getElementById('shipping_price_list_2').style.display = 'none';
                document.getElementById('shipping_total').innerHTML = '';
                document.getElementById('shipping_total').innerHTML = res.shipping_price;
            document.getElementById('shipping_total_pc').innerHTML = '';
            document.getElementById('shipping_total_pc').innerHTML = res.shipping_price;
                document.getElementById('totalPrice').innerHTML = '';
                document.getElementById('totalPrice').innerHTML = res.total_price;
                document.getElementById('totalPrice_pc').innerHTML = '';
                document.getElementById('totalPrice_pc').innerHTML = res.total_price;
            }
            else
            {
              document.getElementById('shipping_price_list_2').style.display = 'block';
            }

            $(".opacity").hide();
            $(".JS-popwincon1").hide();
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

function acecoun(){
    var s = $("#shipping_state").val(); 
    var scon = $("#s_state").val(); 
    var re = /.*\d+.*/;
    if(re.test(s)){ 
            $("#guo_don").show();
            $("#guo_don").html('Страна / Провинция Имя с цифрами? Пожалуйста, проверьте точно.');
        }else{
            $("#guo_don").hide();
        }   
        
    if(re.test(scon)){  
            $("#guo_don1").show();
    $("#guo_don1").html('Страна / Провинция Имя с цифрами? Пожалуйста, проверьте точно.');
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
           $("#guo_eon").html('Город / Городок Имя с цифрами? Пожалуйста, проверьте точно. ');
        }else{
            $("#guo_eon").hide();
        }   
        
    if(re.test(s2)){    
            $("#guo_eon1").show();
            $("#guo_eon1").html('Город / Городок Имя с цифрами? Пожалуйста, проверьте точно. ');
        }else{
            $("#guo_eon1").hide();
        }   
}

function ace(){
    var str1 = $("#shipping_zip").val(); 
    s = str1.replace(/[\ |\~|\`|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\_|\+|\=|\||\\|\[|\]|\{|\}|\;|\:|\"|\'|\,|\，|\。|\<|\.|\>|\/|\?]/g,""); 
    $("#shipping_zip").val(s);
    var str3 = $("#s_zip").val(); 
    s3 = str3.replace(/[\ |\~|\`|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\_|\+|\=|\||\\|\[|\]|\{|\}|\;|\:|\"|\'|\,|\，|\。|\<|\.|\>|\/|\?]/g,""); 
    $("#s_zip").val(s3);
    var re = /^[a-zA-Z]{3,10}$/;
    var reg = new RegExp("[\\u4E00-\\u9FFF]+","g");
        if(re.test(s) || reg.test(s)){     
        $("#guo_fon").show();
        $("#guo_fon").html("Кажется, что нет цифр в коде, пожалуйста, проверьте точно.");
    }else{
        $("#guo_fon").hide();
    }
    
        if(re.test(s3) || reg.test(s3)){        
        $("#guo_fon1").show();
        $("#guo_fon1").html("Кажется, что нет цифр в коде, пожалуйста, проверьте точно.");
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
        var reg = new RegExp("[\\u4E00-\\u9FFF]+","g");
    // if(re.test(s)){
        // $("#guo222").show();
        // $("#guo222").html("It seems that there are no digits in your code, please check the accuracy.");
    // }else{
        // $("#guo222").hide();
    // }
    if(!trim(datas.firstname) || !trim(datas.lastname) || !trim(datas.address) || !trim(datas.country) || !trim(datas.state) || !trim(datas.city) || !trim(datas.zip) || !trim(datas.phone) || datas.address.length>100 || datas.address.length<3 || (re.test(s)) || (ret.test(c)) || (ret.test(ct)) || datas.phone.length>20 || datas.phone.length<6 || s.length>10 || s.length<3 || reg.test(s)) 
    {
        if((ret.test(c)))
            alert($("#guo_don").text());
        else if((ret.test(ct)))
            alert($("#guo_eon").text());
        else if((re.test(s)))
            alert($("#guo_fon").text());    
        return 0;
    }
    else
        return 1;
}

function delete_address(id)
{
/*    $('body').append('<div id="wingray1" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');*/
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
        url : '<?php echo LANGPATH; ?>/address/ajax_delete1',
        data: datas,
        dataType: "json",
        success: function(data){
            if(data.success == 1){
                var address_li_id = 'address_li_' + id;
                document.getElementById(address_li_id).remove();
                    $(".reveal-modal-bg").fadeOut();
                    $("#myModal6").css("visibility","hidden"); 
                //document.getElementById('wingray1').remove();
              //  document.getElementById('cart_delete').style.display = 'none';
               // $(".opacity").hide();
            }else{
                alert(data.message);
            }
        }
    });
    return false;
}

function choice_coupon(code)
{
    document.getElementById('coupon_code1').value = code;
    document.getElementById('coupon_code').value = code;
    document.getElementById('available_codes').style.display = 'none';
    document.getElementById('available_codes1').style.display = 'none';
}

function setCoupon()
{
    coupon = document.getElementById('coupon_code');
    coupon1 = document.getElementById('coupon_code1');
    if(coupon.value == ''){
        coupon = coupon1;
    }
    if(coupon.value == ''){
        return false;
    }
    datas = new Object();
    datas.coupon_code = coupon.value;
    $.ajax({
        type:"POST",
        url :"<?php echo LANGPATH; ?>/cart/ajax_coupon",
        data:datas,
        dataType:"json",
        success:function(datas){
            if(datas.success == 1)
            {
                alert(datas.message);
                document.getElementById('cart_saving').innerHTML = '';
                document.getElementById('cart_saving').innerHTML = datas.saving;
                document.getElementById('cart_saving_pc').innerHTML = '';
                document.getElementById('cart_saving_pc').innerHTML = datas.saving;
                document.getElementById('save_total').innerHTML = '';
                document.getElementById('save_total').innerHTML = datas.save_total;
                document.getElementById('save_total_pc').innerHTML = '';
                document.getElementById('save_total_pc').innerHTML = datas.save_total;
                document.getElementById('coupon_points_save').style.display = 'block';
                document.getElementById('coupon_points_save_pc').style.display = 'block';
                document.getElementById('totalPrice').innerHTML = '';
                document.getElementById('totalPrice').innerHTML = datas.total;
                document.getElementById('totalPrice_pc').innerHTML = '';
                document.getElementById('totalPrice_pc').innerHTML = datas.total;
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
    elment1 = document.getElementById('points1');
    points = Number(elment.value);
    if(points <= 0 || !points){
        points = Number(elment1.value);
    }
    if(points <= 0 || !points)
        return false;
    datas = new Object();
    datas.points = points;
    $.ajax({
        type:"POST",
        url :"<?php echo LANGPATH; ?>/cart/ajax_point",
        data:datas,
        dataType:"json",
        success:function(datas){
            if(datas.success == 1)
            {
                alert(datas.message);
                document.getElementById('cart_saving').innerHTML = '';
                document.getElementById('cart_saving').innerHTML = datas.saving;
                document.getElementById('cart_saving_pc').innerHTML = '';
                document.getElementById('cart_saving_pc').innerHTML = datas.saving;
                document.getElementById('save_total').innerHTML = '';
                document.getElementById('save_total').innerHTML = datas.save_total;
                document.getElementById('save_total_pc').innerHTML = '';
                document.getElementById('save_total_pc').innerHTML = datas.save_total;
                document.getElementById('coupon_points_save').style.display = 'block';
                document.getElementById('coupon_points_save_pc').style.display = 'block';
                document.getElementById('totalPrice').innerHTML = '';
                document.getElementById('totalPrice').innerHTML = datas.total;
                document.getElementById('totalPrice_pc').innerHTML = '';
                document.getElementById('totalPrice_pc').innerHTML = datas.total;
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

function btn_loading()
{
    document.getElementById('checkoutbtn').style.display = 'none';
    document.getElementById('loadingbtn').style.display = 'block';
    document.getElementById('payment_form').submit();

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
//insurance 
    $("#insurance_pc").click(function(){
        if(this.checked == true){
          document.getElementById('insurance_pc').value = 1;
        }else{
          document.getElementById('insurance_pc').value = 2;
        }
        var form = document.getElementById('editshipingform');
        setShipping(form);
    })

    $("#insurance").click(function(){
        if(this.checked == true){
          document.getElementById('insurance').value = 1;
        }else{
          document.getElementById('insurance').value = 2;
        }
        var form = document.getElementById('editshipingform');
        setShipping(form);
    })

    //shipping price
    $(".s_price_list .radio").click(function(){
        var form = document.getElementById('editshipingform');
        setShipping(form);
        var price = $(this).attr('value');
        var code = "<?php $currency = Site::instance()->currency(); echo $currency['code']; ?>";
        var rate = <?php echo $currency['rate']; ?>;
        var amount = <?php echo $cart['amount']['total'] - $cart['amount']['shipping']; ?>;
        var shipping_price = tofloat(price * rate, 2);
        shipping_price += " ";
        var shipping_total = code + shipping_price;
        var insurance = tofloat(<?php echo $cart['amount']['insurance']; ?>  * rate, 2);
        var amount_total =  tofloat((amount  + parseInt(price)) * rate, 2);
        var amount_total = parseFloat(insurance) + parseFloat(amount_total);
        var amount_total = code + tofloat(amount_total,2);
        $("#shipping_total").html(shipping_total);
        $("#shipping_total_pc").html(shipping_total);
        $("#shipping_amount").val(price);
        $("#shipping_amount_pc").val(price);
/*        $("#totalPrice").html(amount_total);
        $("#totalPrice_pc").html(amount_total);*/
        $("#amount_left").html(tofloat((amount + parseInt(price)), 2));
        $("#amount_left_pc").html(tofloat((amount + parseInt(price)), 2));
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
                required: "Введите ваше имя,пожалуйста.",
                maxlength:"Имя превышает максимальную длину:50 символов."
            },
            lastname: {
                required: "Введите вашу фамилию,пожалуйста.",
                maxlength:"Фамилия превышает максимальную длину:50 символов."
            },
            address: {
                required: "Введите ваш адрес,пожалуйста.",
                rangelength: $.validator.format("Пожалуйста, введите  3-100 символов.")
            },
            zip: {
                required: "Введите ваш почтовый индекс,пожалуйста.",
                rangelength: $.validator.format("Пожалуйста, введите  3-10 символов.")
            },
            city: {
                required: "Введите ваш город,пожалуйста.",
                maxlength:"Город/Городок превышает максимальную длину:50 символов."
            },
            country: {
                required: "Выберите страну,пожалуйста.",
                maxlength:"Страна превышает максимальную длину:50 символов."
            },
            state: {
                required: "Введите вашу страну/провинцию/штат,пожалуйста.",
                maxlength:"страну/провинцию/штат,пожалуйста превышает максимальную длину:50 символов."
            },
            phone: { 
                required: "Введите ваш номер телефона,пожалуйст", 
                rangelength: $.validator.format("Пожалуйста, введите номер телефона в пределах 6-20 цифр.")
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
                required: "Введите ваше имя,пожалуйста.",
                maxlength:"Имя превышает максимальную длину:50 символов."
            },
            lastname: {
                required: "Введите вашу фамилию,пожалуйста.",
                maxlength:"Фамилия превышает максимальную длину:50 символов."
            },
            address: {
                required: "Введите ваш адрес,пожалуйста.",
                rangelength: $.validator.format("Пожалуйста, введите  3-100 символов.")
            },
            zip: {
                required: "Введите ваш почтовый индекс,пожалуйста.",
                rangelength: $.validator.format("Пожалуйста, введите  3-10 символов.")
            },
            city: {
                required: "Введите ваш город,пожалуйста.",
                maxlength:"Город/Городок превышает максимальную длину:50 символов."
            },
            country: {
                required: "Выберите страну,пожалуйста.",
                maxlength:"Страна превышает максимальную длину:50 символов."
            },
            state: {
                required: "Введите вашу страну/провинцию/штат,пожалуйста.",
                maxlength:"страну/провинцию/штат,пожалуйста превышает максимальную длину:50 символов."
            },
            phone: { 
                required: "Введите ваш номер телефона,пожалуйст", 
                rangelength: $.validator.format("Пожалуйста, введите номер телефона в пределах 6-20 цифр.")
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
<!-- VE code -->
<script src="//configch2.veinteractive.com/tags/2AA3B13E/D7D0/431E/9B9E/38DE91E41CD3/tag.js" type="text/javascript" async></script>

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
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
    <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/983779940/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>