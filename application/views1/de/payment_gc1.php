<style>
    .card_num_box{ width:265px; background:#f8f8f8; border: solid 1px #eee; font:18px/40px "微软雅黑"; color:#999; padding:0 10px; position:absolute; bottom:-10px; display:none; left:15px; }
    .error{ margin-left: 15px;float:left;width: auto;text-align: left;font-size: 11px;line-height: 25px;color: #db2031;display:none; }
    /* payment_wrap2 */
    
    #pageOverlay { visibility:hidden; position:fixed; top:0; left:0; z-index:2; width:100%; height:100%; background:#000; filter:alpha(opacity=70); opacity:0.7; }
    * html #pageOverlay { position: absolute; left: expression(documentElement.scrollLeft + documentElement.clientWidth - this.offsetWidth); top: expression(documentElement.scrollTop + documentElement.clientHeight - this.offsetHeight); }
</style>
<header class="site-header">
    <div class="cart-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-8 col-md-8">
                    <a href="<?php echo LANGPATH; ?>/" ><img src="<?php echo STATICURLHTTPS; ?>/assets/images/2016/logo.png" alt=""></a>
                </div>
                <div class="col-xs-4 col-md-4">
                    <a href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&amp;dn=www.choies.com&amp;lang=de" target="_blank"><img src="<?php echo STATICURLHTTPS; ?>/assets/images/card3.png"></a>
                </div>
            </div>
        </div>
    </div>
    <div class="phone-cart-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="step-nav">
                        <ul class="clearfix">
                            <li>Bestellung Aufgeben<em></em><i></i></li>
                            <li class="current">Bezahlen<em></em><i></i></li>
                            <li>Erfolgreich<em></em><i></i></li>
                        </ul>
                    </div>  
                </div>  
            </div>
        </div>
    </div>
</header>
<div class="site-content">
    <div class="main-container clearfix">
        <div class="container">
            <div class="row">
                <div class="cart clearfix">
                <div class="col-xs-12 col-sm-7">
                    <div class="shipping-information">
                        <div class="information-con">
                            <?php
                            $billing_country = $order['billing_country'];
                            $countries = Site::instance()->countries(LANGUAGE);
                            $countries_top = Site::instance()->countries_top(LANGUAGE);
                            foreach ($countries as $c)
                            {
                                if ($c['isocode'] == $billing_country)
                                {
                                    $billing_country = $c['name'];
                                    break;
                                }
                            }
                            ?>
                            <div class="billing-address" id="payment_address">
                                <h3>Rechnungsadresse</h3>
                                <a href="javascript:;" class="red JS-popwinbtn1">Editieren</a>
                            </div>
                            <p><?php echo $order['billing_firstname'] . ' ' . $order['billing_lastname']; ?>, <?php echo $order['billing_phone']; ?>, <?php echo $order['billing_address'] . ' ' . $order['billing_city'] . ', ' . $order['billing_state'] . ' ' . $billing_country . ' ' . $order['billing_zip']; ?></p>
                        </div>
                        <div class="payment-wrap">
                            <div class="payment-p">
                                <div class="payment-message">
                                    <div class="fll mr20">Bestellung Zwischensumme: 
                                        <span class=" f16 bold"><?php echo round($order['amount'], 2) . ' ' . $order['currency']; ?></span>
                                    </div>
                                    <div class="fll">Bestellnummer:<span class=" f16 bold"><?php echo $order['ordernum']; ?></span></div>
                                </div>
                                <div class="clearfix"></div>
                                <form action="" id="sendFrm" name="send" method="post" autocomplete="off" onsubmit="return checkFormData();">    
                                    <ul>
                                        <li class="clearfix">
                                            <label class="payment-td-right bold"><em>*</em>Kreditkartentyp</label>
                                            <select name="card_type" class="ui-input" style="width:180px" id="card_select" onchange="select_ch()">
                                                <option selected="selected" value="0">
                                                    <?php 
                                                    $lang = LANGUAGE;
                                                    echo Kohana::config('lang.'.$lang.'.payment.choosecard');
                                                    ?>
                                                </option>
                                                <option  value="1"> Visa </option>
                                                <option value="3"> MasterCard </option>
                                                <option value="122"> Visa Electron </option>
                                                <option value="114"> Visa Debit </option>
                                                <option value="119"> MasterCard Debit </option>
                                                <option value="125"> JCB </option>
                                                <option value="128"> Discover </option>
                                                <option value="132"> Diners Club </option>
                                            </select>
                                            <div class="payment-ul">
                                                <ul>
                                                    <li onclick="return change_card(1);">
                                                        <label for=""><img src="<?php echo STATICURLHTTPS; ?>/assets/images/card16.jpg" title="Visa"></label>
                                                    </li>
                                                    <li onclick="return change_card(2);">
                                                        <label for=""><img src="<?php echo STATICURLHTTPS; ?>/assets/images/card15.jpg" title="MasterCard"></label>
                                                    </li>
                                                    <li onclick="return change_card(3);">
                                                        <label for=""><img src="<?php echo STATICURLHTTPS; ?>/assets/images/card17.jpg" title="Visa Electron"></label>
                                                    </li>
                                                    <li onclick="return change_card(4);">
                                                        <label for=""><img src="<?php echo STATICURLHTTPS; ?>/assets/images/card18.jpg" title="Visa Debit"></label>
                                                    </li>
                                                    <li onclick="return change_card(5);">
                                                        <label for=""><img src="<?php echo STATICURLHTTPS; ?>/assets/images/card19.jpg" title="MasterCard Debit"></label>
                                                    </li>
                                                    <!-- <li onclick="return change_card(6);">
                                                                           <label for=""><img src="<?php echo STATICURLHTTPS; ?>/assets/images/card20.jpg" title="JCB"></label>
                                                                       </li>
                                                                       <li onclick="return change_card(7);">
                                                                           <label for=""><img src="<?php echo STATICURLHTTPS; ?>/assets/images/card21.jpg" title="Discover"></label>
                                                                       </li>
                                                                       <li onclick="return change_card(8);">
                                                                           <label for=""><img src="<?php echo STATICURLHTTPS; ?>/assets/images/card22.jpg" title="Diners Club"></label>
                                                                       </li>  -->                   
                                                </ul>
                                            </div>
                                            <br><br><br>
                                            <div class="error hide" id="card_error1">
                                                <?php
                                                $lang = LANGUAGE;
                                                echo Kohana::config('lang.'.$lang.'.payment.choosecard1');
                                                ?>
                                            </div> 
                                        </li>
                                        <li class="clearfix">
                                            <label class="payment-td-right bold"><em>*</em>Kreditkartennummer</label>
                                            <div class="payment-card-time">12-19 Stelle, Leerzeichen sind nicht erlaubt</div>
                                            <div class="card-num">
                                                <input class="ui-input" style="width:220px;" maxlength="19" name="cardNo" id="cardNo" onclick="error_clean('card_error');" type="tel" onkeydown="showcardnum();" onkeyup="clean();">
                                                <div class="card_num_box" id="card_num_box"></div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="error hide" id="card_error">Die Kreditkartennummer ist falsch.</div>
                                        </li>
                                        <li class="clearfix">
                                            <label class="payment-td-right bold"><em>*</em>Ablaufdatum</label>
                                            <?php
                                            $now_month_list = '<option value="0"> Month </option>';
                                            $all_month_list = '<option value="0"> Month </option>';
                                            $m = date('m');
                                            ?>
                                            <div class="fll" style="width:100px;">
                                                <select name="cardExpireMonth" class="ui-input" id="cardExpireMonth" style="width:70px;" onclick="error_clean('expire_error')">
                                                    <option selected="selected" value="0"> Monat </option>
                                                    <?php
                                                    for($i = 1;$i <= 12;$i ++)
                                                    {
                                                        $j = $i < 10 ? '0' . $i : $i;
                                                        if($i >= $m)
                                                            $now_month_list .= '<option value="' . $j . '"> '. $j . ' </option>';
                                                        $all_month_list .= '<option value="' . $j . '"> '. $j . ' </option>';
                                                    ?>
                                                        <option value="<?php echo $j; ?>"> <?php echo $j; ?> </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="payment-card-time fl">Monat</div>
                                            </div>
                                            <div class="fll" style="margin-top:17px;">/</div>
                                            <div class="fll" style="width:100px;">
                                                <select name="cardExpireYear" class="ui-input" id="cardExpireYear" style="width:70px;" onclick="error_clean('expire_error')">
                                                    <option value="0" selected="selected">Jahr</option>
                                                    <?php
                                                    $y = date('y');
                                                    for($i = 0;$i < 27;$i ++)
                                                    {
                                                    ?>
                                                        <option value="<?php echo $y + $i; ?>"> <?php echo $y + $i; ?> </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="payment-card-time fl">Jahr</div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="error hide" id="expire_error">Das Verfallsdatum des Monats ist falsch.</div>                                                               
                                        </li>
                                        <li class="clearfix">
                                            <label class="payment-td-right bold"><em>*</em>Kartenprüfnummer <span style="font-weight:normal; color:#999">(CVV/CVC)</span></label>
                                            <input maxlength="3" class="ui-input" style="width:60px;" id="cvv2" name="cardSecurityCode" type="tel" onclick="error_clean('cvv_error')">
                                            <div class="payment-icon-box-pic-en"><img src="<?php echo STATICURLHTTPS; ?>/assets/images/payment-new-credit-crad.png"></div>
                                            <div class="clearfix"></div>
                                            <div class="error hide" id="cvv_error">Bitte geben Sie eine dreistellige CVV/CVC-Code ein.</div>
                                        </li>
                                    </ul>      
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td style="text-align: left;padding: 30px 0 30px 15px;" width="487">
                                                    <input value="JETZT BEZAHLEN" id="paybutton" name="paybutton" class="btn btn-primary btn-lg" type="submit"></td>
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
                    </div>  
                </div>
                <div class="col-xs-12 col-sm-4 col-sm-offset-1">
                    <div class="order-summary">
                        <div class="cart-side">
                            <p>
                                <strong>Akzeptierte Kreditkarte</strong>
                                Wir akzeptieren VISA, Electron, MasterCard und VISA Debit oder MasterCard Debit.<br>
                                Wenn Sie eine andere Karte verwenden (z.B Discover oder American Express) stattdessen bezahlen Sie bitte mit <a style="text-decoration:underline;" href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" target="_blank">PayPal</a>.
                                <br>
                                <br>
                                <strong>60-Tage Rückerstattung Politik</strong>
                                Wenn Sie mit Ihrem Kauf unzufrieden sind, dann einfach senden Sie uns eine E-Mail an 
                                <a style="text-decoration:underline;" href="mailto:service@choies.com" target="_blank">service@choies.com</a> 
                                um eine Rücksendungsgenehmigung (Rückkehradresse) oder Umtausch Genehmigung innerhalb von 60 Tagen nach Erhalt zu bekommen.
                            </p>
                            <div class="add-payment">
                                <strong>Zusätzliche Zahlungssicherheit mit:</strong>
                                <span class="encryption"><b></b>Sicheres Kassensystem  256-Bit SSL Verschlüsselung von Norton</span>
                                <span>
                                    <img src="<?php echo STATICURLHTTPS; ?>/assets/images/card24.jpg" usemap="#Card24">
                                    <map name="Card24" id="Card24">
                                        <area target="_blank" shape="rect" coords="2,1,91,49" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en">
                                    </map>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
            </div>  
        </div>
    </div>
</div>

<div class="loading" id="payment_wrap2" style="display:none;">
    <div class="loading-box">
        <div class="loading-title">Lade Daten</div>
        <div class="loading-pic"><img src="<?php echo STATICURLHTTPS; ?>/assets/images/gb_loading.gif" alt="" height="68" width="100">  
        <div class="loading-prompt">Lade Daten, Bitte einen Moment warten!</div>
        </div>
    </div>
</div>
<div id="pageOverlay" style="visibility: hidden;"></div>

<footer>
    <div id="comm100-button-311" class="bt-livechat visible-xs-block hidden-sm hidden-md hidden-lg">
        <a onclick="Comm100API.open_chat_window(event, 311);" href="#">
            <span id="comm100-button-311img" alt="" style="border:none;"><!--LIVECHAT--></span>
        </a>
    </div>
    <div class="w-top container-fluid">
        <div class="container">
            <div class="card  hidden-xs container">
                <p class="paypal-card container">
                    <img usemap="#Card" src="<?php echo STATICURLHTTPS; ?>/assets/images/card-0509.jpg">
                    <map id="Card" name="Card">
                        <area target="_blank" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en" coords="88,2,193,62" shape="rect">
                    </map>
                </p>
            </div>
        </div>
        <div class="copyr hidden-xs">
            <p class="bottom container-fluid">Copyright © 2006-<?php echo date('Y'); ?> Choies.com</p>
        </div>
    </div>
</footer>
<div id="gotop" class="hide ">
    <a href="#" class="xs-mobile-top"></a>
</div>

<!-- JS-popwincon1 -->
<div class="JS-popwincon1 popwincon popwincon-user hide">
    <a class="JS-close2 close-btn3"></a>
    <div class="address-fill">
        <h4>Rechnungsadresse</h4>
        <form action="<?php echo LANGPATH; ?>/order/edit_address/<?php echo $order['id']; ?>" method="post" class="form payment-form form1">
            <input type="hidden" name="return" value="<?php echo LANGPATH; ?>/payment/gc_pay/<?php echo $order['ordernum']; ?>" />
            <input type="hidden" name="type" value="billing" />
            <ul>
                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span> Vorname:</label>
                    <input type="text" value="<?php echo $order['billing_firstname']; ?>" name="billing_firstname" id="billing_firstname" class="text col-xs-12 col-md-9">
                </li>
                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span> Nachname:</label>
                    <input type="text" value="<?php echo $order['billing_lastname']; ?>" name="billing_lastname" id="billing_lastname" class="text col-xs-12 col-md-9">
                </li>
                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span> Adresse:</label>
                    <div>
                        <textarea class="col-xs-12 col-md-9" name="billing_address" id="billing_address" onchange="ace2()"><?php echo $order['billing_address']; ?></textarea>
                        <label class="a1 error" style="display:none;"  generated="true" id="guo_con"></label>
                    </div>
                </li>
                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span> Land:</label>
                    <select name="billing_country" class="select-style  col-xs-12 col-md-9" id="billing_country" onchange="changeSelectCountry2();$('#billing_country').val($(this).val());">
                        <option value="">EIN LAND WÄHLEN</option>
                        <?php if (is_array($countries_top)): ?>
                            <?php foreach ($countries_top as $country_top): ?>
                                <option value="<?php echo $country_top['isocode']; ?>"><?php echo $country_top['name']; ?></option>
                            <?php endforeach; ?>
                            <option disabled="disabled">———————————</option>
                        <?php endif; ?>
                        <?php foreach ($countries as $country): ?>
                            <option value="<?php echo $country['isocode']; ?>" <?php if ($order['billing_country'] == $country['isocode']) echo 'selected'; ?> ><?php echo $country['name']; ?></option>
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
                            $enter_title = 'Einen Bundesstaat Eingeben';
                        }
                        else
                        {
                            $enter_title = 'Ein(e) Bundesland/Provinz Wählen';
                        }
                        ?>
                        <div class="all2 JS_drop" id="all2_<?php echo $country; ?>" style="display:none;">
                            <select name="billing_" class="select-style col-xs-12 col-md-9 s_state" id="s_state" onblur="$('#billing_state1').val($(this).val());" onchange="acecoun()">
                                <option value="">[Select One]</option>
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
                        <input type="text" name="billing_state" id="billing_state" class="text col-xs-12 col-md-9" value="<?php echo $order['billing_state']; ?>" maxlength="320" onchange="acecoun()" />
                        <div class="errorInfo"></div>
                        <label class="error a3" style="display:none;"  generated="true" id="guo_don">Please choose your country.</label>
                    </div>
                    <script>
                        function changeSelectCountry2(){
                            var select = document.getElementById("billing_country");
                            var countryCode = select.options[select.selectedIndex].value;
                            if(countryCode == 'BR')
                            {
                                $("#billing_cpf").show();
                                $("#guo111").hide();
                            }
                            else if(countryCode == 'HK' || countryCode == 'MO' || countryCode == 'TW')
                            {   
                            
                            var ooo = $("#guo_con");
                                ooo.show();
                                ooo.html('請輸入中文地址(Bitte geben Sie die Adresse auf Chinesisch ein.)');
                            }
                            else
                            {
                                $("#billing_cpf").hide();
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
                    <label class="col-xs-12 col-md-3"><span>*</span> Stadt / Ort:</label>
                    <input type="text" value="<?php echo $order['billing_city']; ?>" name="billing_city" id="billing_city" class="text col-xs-12 col-md-9" onchange="acedoun()">
                    <label class="error a4" style="display:none;"  generated="true" id="guo_eon">Stadt / Ort mit Ziffern? Bitte überprüfen Sie es noch einmal..</label>
                </li>
                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span> PLZ:</label>
                    <input type="text" value="<?php echo $order['billing_zip']; ?>" name="billing_zip" id="billing_zip" class="text col-xs-12 col-md-9" onchange="ace()">
                    <label class="error hide" style="display:none;" generated="true" id="guo_fon">Es scheint, dass es keine Ziffern in der PLZ gibt, überprüfen Sie sie bitte erneut.</label>
                    <p class="phone_tips">Bitte geben Sie Ihre Postleitzahl ein (oder 0000, wenn keine Postleitzahl in Ihrem Land erforderlich ist).</p>
                </li>
                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span> Telefon:</label>
                    <input type="text" value="<?php echo $order['billing_phone']; ?>" name="billing_phone" id="billing_phone" class="text col-xs-12 col-md-9">
                    <p class="mt5 col-md-offset-3 col-xs-12 col-md-9 phone_tips">Bitte hinterlassen Sie eine richtige und vollständige Telefonnummer für pünktliche Lieferung von Postbote</p>
                </li>
                <li class="hide" value="0">
                    <label class="col-xs-12 col-md-3"><span>*</span>o cadastro de pessoa Física:</label>
                    <input type="text" name="billing_cpf" id="billing_cpf" class="text col-xs-12 col-md-9" value="">
                </li>
            </ul>
            <p class="col-md-offset-3 col-xs-12 col-md-9"><input type="submit" value="WEITER" class="btn btn-default"></p>
        </form>
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
$(function(){
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

function change_card(index)
{
    var card_select = document.getElementById('card_select');
    card_select.selectedIndex = index;
    
        $popup_message = document.getElementById('card_error1');
        $popup_message.style.display = 'none';  
}

function select_ch(){
    var card_select = document.getElementById('card_select');
    if(card_select.value>0){
        $popup_message = document.getElementById('card_error1');
        $popup_message.style.display = 'none';  
    }else{
        $popup_message = document.getElementById('card_error1');
        $popup_message.style.display = 'block';     
    }
}

// check cardNo, cardExpireMonth, cardExpireYear, CVV2 Code
function checkFormData()
{
    var now_year = '<?php echo date('y'); ?>';
    var now_month = '<?php echo date('m'); ?>';
    var error = 0;
    var cardNo = document.getElementById('cardNo').value;
    var card_select = document.getElementById('card_select');
    
    if(card_select.value == 0){
        $popup_message = document.getElementById('card_error1');
        $popup_message.innerHTML = "<?php echo Kohana::config('lang.'.$lang.'.payment.choosecard1'); ?>";
        $popup_message.style.display = 'block';
        error = 1;
    }   
    
    if(cardNo.length == 0)
    {
        $popup_message = document.getElementById('card_error');
        $popup_message.innerHTML = 'Bitte geben Sie Ihre Kartennummer ein.';
        $popup_message.style.display = 'block';
        error = 1;
    }
    var check = luhnCheckSum(cardNo);
    if(!check)
    {
        $popup_message = document.getElementById('card_error');
        $popup_message.innerHTML = 'Die Kreditkartennummer ist falsch.';
        $popup_message.style.display = 'block';
        error = 1;
    }
    var month = document.getElementById("cardExpireMonth").value;
    if(month == 0)
    {
        $popup_message = document.getElementById('expire_error');
        $popup_message.innerHTML = 'Bitte wählen Sie das Ablaufdatum.';
        $popup_message.style.display = 'block';
        error = 1;
    }
    var year = document.getElementById("cardExpireYear").value;
    if(year == 0)
    {
        $popup_message = document.getElementById('expire_error');
        $popup_message.innerHTML = 'Bitte wählen Sie das Ablaufdatum.';
        $popup_message.style.display = 'block';
        error = 1;
    }
    if(year == now_year && month < now_month)
    { 
        $popup_message = document.getElementById('expire_error');
        $popup_message.innerHTML = 'Ihr Ablaufdatum ist ungültig.';
        $popup_message.style.display = 'block';
        error = 1;
    }
    var cvv2 = document.getElementById("cvv2").value;
    reg = /^[0-9]\d*$|^0$/;
    if(cvv2.length != 3 || reg.test(cvv2) != true)
    {
        $popup_message = document.getElementById('cvv_error');
        $popup_message.innerHTML = 'Bitte geben Sie eine dreistellige CVV/CVC-Code ein.';
        $popup_message.style.display = 'block';
        error = 1;
    }

    if(error == 1)
    {
        return false;
    }
    else
    {
        $popup_message = document.getElementById('card_error');
        $popup_message.style.display = 'none';
        $popup_message = document.getElementById('expire_error');
        $popup_message.style.display = 'none';
        $popup_message = document.getElementById('cvv_error');
        $popup_message.style.display = 'none';
        document.getElementById('pageOverlay').style.visibility = 'initial';
        document.getElementById('payment_wrap2').style.display = 'block';
    }
        
}

function error_clean(error_id)
{
    $error_div = document.getElementById(error_id);
    $error_div.style.display = 'none';
}

function luhnCheckSum(Luhn)
{
    var ca, sum = 0, mul = 1;
    var len = Luhn.length;
    while (len--)
    {
        ca = parseInt(Luhn.charAt(len),10) * mul;
        sum += ca - (ca>9)*9;// sum += ca - (-(ca>9))|9
        // 1 <--> 2 toggle.
        mul ^= 3; // (mul = 3 - mul);
    };
    return (sum%10 === 0) && (sum > 0);
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

<!--Begin Comm100 Live Chat Code-->
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
