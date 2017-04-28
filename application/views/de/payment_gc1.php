<script src="//cdn.optimizely.com/js/557241246.js"></script>
<style> 
    #payment_wrap .f14{ font-size:14px;}
    #payment_wrap .f16{ font-size:16px;}
    #payment_wrap .f18{ font-size:18px;}
    #payment_wrap .c_gray{ color:#CCC;}
    #payment_wrap .c_red{ color:#000;}
    #payment_wrap .c_black{ color:#333;}
    #payment_wrap .bold{ font-weight:bold;}
    #payment_wrap .line{ border:solid 1px #eee;}

    /* payment_wrap */
    #payment_wrap { font:12px/40px Verdana; color:#333; border:solid 1px #D6D5D5; width:690px; background:#f4f4f0;}
    #payment_wrap .payment_h1 { border-bottom:solid 1px #EEE; padding-left:20px; background:#f8f8f8; font: bold 16px/40px Arial; }

    #payment_wrap .payment_p em { color:#F00; margin-right:5px; }
    #payment_wrap .payment_ul { list-style:none; padding:0; margin:0; float:left;}
    #payment_wrap .payment_ul li { float:left; margin-right:5px; line-height: 15px;}
    #payment_wrap .payment_ul li.visa { background-position:0 0; }
    #payment_wrap .payment_ul li.master { background-position:-90px 0; }
    #payment_wrap .payment_ul li.jcb { background-position:-180px 0; }
    #payment_wrap .payment_td_right { text-align:left; padding-right:10px; padding-left: 15px; white-space: nowrap; display:block; line-height:20px; margin-top:10px;}
    #payment_wrap .payment_td_right2 { text-align:right; padding-right:10px; width:220px; white-space: nowrap;}
    #payment_wrap .payment_td_right3 { text-align:right; padding-right:10px; width:240px; white-space: nowrap;}
    #payment_wrap .payment_td_right4 { text-align:right; padding-right:10px; width:200px; white-space: nowrap;}

    #payment_wrap .payment_td_height { line-height:20px; height:20px; }

    #payment_wrap .payment_message{ text-align: left;border:none; padding:10px 15px; margin-bottom:0; color:#999; line-height:20px;}
    #payment_wrap .card_num{ position:relative;}
    #payment_wrap .card_num_box{ width:265px; background:#f8f8f8; border: solid 1px #eee; font:18px/40px "微软雅黑"; color:#999; padding:0 10px; position:absolute; bottom:-10px; display:none; left:15px; }
    #payment_wrap .cad img{cursor:pointer;}

    /* payment_input */
    #payment_wrap .ui_input { font:12px/25px Verdana; height:25px; color:#666; padding:0 0 0 5px; border:solid 1px #ccc; background:#fefefe; outline:none; margin:10px 15px 5px 15px; display: block; float:left;}
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
    #payment_wrap .payment_icon_en{ display:block; cursor:pointer; position:relative; }
    #payment_wrap .payment_icon_box_en{ width:140px; padding:10px; border:solid 1px #eee; -webkit-box-shadow: 0px 0px 10px #eee; -moz-box-shadow: 0px 0px 10px #eee; box-shadow: 0px 0px 10px #eee; background:#FFF; position:absolute; left:20px; bottom:0; display:none;}
    #payment_wrap .payment_icon_box_txt_en{ font:12px/25px Verdana;}
    #payment_wrap .payment_icon_box_pic_en{ float:left; margin-top:8px;margin-right:15px;}

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
        display: inline-block; zoom: 1; vertical-align: baseline; cursor: pointer; text-align: center; text-decoration: none; font: bold 14px/20px Arial, Helvetica, sans-serif; padding: .5em 2em .55em; *padding: .4em 1em; text-shadow: 0 1px 1px rgba(0, 0, 0, .3); -webkit-border-radius: .5em; -moz-border-radius: .5em; border-radius: .5em;
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
        line-height: 16px;font-size: 11px;padding-bottom: 20px;padding-top: 10px;color: #666;padding-left: 15px;
    }
    .error{ margin-left: 15px;float:left;width: auto;text-align: left;font-size: 11px;line-height: 25px;color: #db2031;display:none; }
    .payment_card_time{line-height:18px; font-size:10px; color:#999;}
</style>

<div class="cart_header">
    <div class="layout">
        <a href="<?php echo LANGPATH; ?>/" class="logo"><img src="/images/logo.png"></a>
        <div class="cart_step">
            <h2><img src="/images/payment_step3.png"></h2>
            <div class="cart_step_bottom">
                <span>VERSAND & LIEFERUNG</span>
                <span>ABRECHNUNG</span>
                <span class="on">BEZAHLUNG</span>
            </div>
        </div>
        <a href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&amp;dn=www.choies.com&amp;lang=en" target="_blank"><img src="/images/card3.png"></a>
    </div>
</div>
<section id="main">
    <div id="forgot_password"></div>
    <section class="layout fix">
        <section class="cart">
            <section class="shipping_delivery fix">
                <article class="shipping_delivery_left payment_box">
                    <!-- payment -->
                    <div>
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
                        <div id="payment_address" class="mb25" style="border: 1px solid #D6D5D5;padding: 15px;margin-bottom: 30px;height: 67px;width: 660px;">
                            <div style="background: #f8f8f8;font: bold 16px Arial;margin-bottom: 15px;">Rechnungsadresse</div>
                            <p style="width:605px;overflow:hidden; text-overflow:ellipsis;white-space: nowrap;color:#666;font-size: 12px;" class="fll"><?php echo $order['billing_firstname'] . ' ' . $order['billing_lastname']; ?>, <?php echo $order['billing_phone']; ?>, <?php echo $order['billing_address'] . ' ' . $order['billing_city'] . ', ' . $order['billing_state'] . ' ' . $billing_country . ' ' . $order['billing_zip']; ?></p>
                            <a href="#" class="a_red JS_popwinbtn1" style="font-style: italic;font-size:12px;margin-left:3px;">Editieren</a></dt>
                        </div>
                        <?php echo Message::get(); ?>
                        <div id="payment_wrap">
                            <div class="payment_p">
                                <div class="payment_message">
                                    Bestellung Zwischensumme: 
                                    <span class="c_red f16 bold">
                                        <?php echo round($order['amount'], 2) . ' ' . $order['currency']; ?>
                                    </span>
                                    <span class="c_gray">|</span> 
                                    Bestellnummer:<span class="c_red f16 bold"><?php echo $order['ordernum']; ?></span>
                                </div>
                                <form action="" id="sendFrm" name="send" method="post" autocomplete="off" onsubmit="return checkFormData();">    
                                    <ul>
                                        <li class="fix">
                                            <label class="payment_td_right bold"><em>*</em>Kreditkartentyp</label>
                                            <select name="card_type" class="ui_input" style="width:180px;" id="card_select" onchange="select_ch()">
											<option selected="selected" value="0"><?php 
											$lang = LANGUAGE;
											echo Kohana::config('lang.'.$lang.'.payment.choosecard') ?></option>
                                                <option value="1"> Visa </option>
                                                <option value="3"> MasterCard </option>
                                                <option value="122"> Visa Electron </option>
                                                <option value="114"> Visa Debit </option>
                                                <option value="119"> MasterCard Debit </option>
                                                <option value="125"> JCB </option>
                                                <option value="128"> Discover </option>
                                                <option value="132"> Diners Club </option>
                                            </select>
                                            <div class="payment_ul">
                                                <ul class="cad">
                                                    <li onclick="return change_card(1);">
                                                        <label for="card16"><img src="/images/card16.jpg" title="Visa"></label>                 
                                                    </li>
                                                    <li onclick="return change_card(2);">
                                                        <label for="card15"><img src="/images/card15.jpg" title="MasterCard"></label>
                                                    </li>
                                                    <li onclick="return change_card(3);">
                                                        <label for="card17"><img src="/images/card17.jpg" title="Visa Electron"></label>
                                                    </li>
                                                    <li onclick="return change_card(4);">
                                                        <label for="card18"><img src="/images/card18.jpg" title="Visa Debit"></label>
                                                    </li>
                                                    <li onclick="return change_card(5);">
                                                        <label for="card19"><img src="/images/card19.jpg" title="MasterCard Debit"></label>
                                                    </li>
                                                    <li onclick="return change_card(6);">
                                                        <label for="card20"><img src="/images/card20.jpg" title="JCB"></label>
                                                    </li>
                                                    <li onclick="return change_card(7);">
                                                        <label for="card21"><img src="/images/card21.jpg" title="Discover"></label>
                                                    </li>
                                                    <li onclick="return change_card(8);">
                                                        <label for="card22"><img src="/images/card22.jpg" title="Diners Club"></label>
                                                    </li>                    
                                                </ul>
                                            </div>
											<div class="error" id="card_error1" style="clear:both;"><?php 
											$lang = LANGUAGE;
											echo Kohana::config('lang.'.$lang.'.payment.choosecard1'); ?></div>
                                        </li>
                                        <li class="fix">
                                            <label class="payment_td_right bold"><em>*</em>Kreditkartennummer</label>
                                            <div class="payment_card_time" style="margin: 0 0 -10px 15px;">12-19 Stelle, Leerzeichen sind nicht erlaubt</div>
                                            <div class="card_num">
                                                <input class="ui_input" style="width:280px; " maxlength="19" name="cardNo" id="cardNo" onclick="error_clean('card_error');" type="text" onkeydown="showcardnum();" onkeyup="clean();">
                                                <div class="card_num_box" id="card_num_box"></div>
                                            </div>
                                            <div class="fix"></div>
                                            <div class="error" id="card_error">Die Kreditkartennummer ist falsch.</div>
                                        </li>
                                        <li class="fix">
                                            <label class="payment_td_right bold"><em>*</em>Ablaufdatum</label>
                                            <?php
                                            $now_month_list = '<option value="0"> Monat </option>';
                                            $all_month_list = '<option value="0"> Monat </option>';
                                            $m = date('m');
                                            ?>
                                            <div class="fll" style="width:100px;">
                                                <select name="cardExpireMonth" class="ui_input" id="cardExpireMonth" style="width:70px;" onclick="error_clean('expire_error')">
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
                                                <div class="payment_card_time fl ml20">Monat</div>
                                            </div>
                                            <div class="fll">/</div>
                                            <div class="fll" style="width:100px;">
                                                <select name="cardExpireYear" class="ui_input" id="cardExpireYear" style="width:70px;" onclick="error_clean('expire_error')">
                                                    <option value="0" selected="selected">Jahr</option>
                                                    <?php
                                                    $y = date('y');
                                                    for($i = 0;$i < 18;$i ++)
                                                    {
                                                    ?>
                                                        <option value="<?php echo $y + $i; ?>"> <?php echo $y + $i; ?> </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="payment_card_time fl ml20">Jahr</div>
                                            </div>
                                            <div class="fix"></div>
                                            <div class="error" id="expire_error">Das Verfallsdatum des Monats ist falsch.</div>                                                               
                                        </li>
                                        <li class="fix">
                                            <label class="payment_td_right bold"><em>*</em>Kartenprüfnummer <span style="font-weight:normal; color:#999">(CVV/CVC)</span></label>
                                            <input maxlength="3" class="ui_input" style="width:60px;" id="cvv2" name="cardSecurityCode" onclick="error_clean('cvv_error')" type="text">
                                            <div class="payment_icon_box_pic_en"><img src="/images/payment-new-credit-crad.png" /></div>
                                            <div class="fix"></div>
                                            <div class="error" id="cvv_error">Bitte geben Sie eine dreistellige CVV/CVC-Code ein.</div>
                                        </li>
                                    </ul>      
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td style="text-align: left;padding: 30px 0 30px 15px;" width="487">
                                                    <input value="JETZT BEZAHLEN" id="paybutton" name="paybutton" class="btn40_16_red" type="submit"></td>
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
                            <div class="payment_h1">Lade Daten</div>
                            <div class="payment_p"><img id="loadingImg" src="/images/gb_loading.gif" alt="" height="68" width="100">  
                            <div style=" line-height:68px;">Lade Daten, Bitte einen Moment warten!</div>
                            </div>
                        </div>
                        <div id="pageOverlay" style="visibility: hidden;"></div>
                    </div>
                </article>
                
                <!-- order_summary -->
                <div class="order_summary flr">
                    <div class="cart_side">
                    <p style="padding:15px; color:#999;">
                    <strong style="color:#000;">Akzeptierte Kreditkarte</strong><br /><br />
                    Wir akzeptieren VISA, Electron, MasterCard und VISA Debit oder MasterCard Debit.<br />
                    Wenn Sie eine andere Karte verwenden (z.B Discover oder American Express) stattdessen bezahlen Sie bitte mit <a style="text-decoration:underline;" href="/order/view/<?php echo $order['ordernum']; ?>" target="_blank">PayPal</a>.<br /><br />
                    <strong style="color:#000;">60-Tage Rückerstattung Politik</strong><br /><br />
                    Wenn Sie mit Ihrem Kauf unzufrieden sind, dann einfach senden Sie uns eine E-Mail an <a style="text-decoration:underline;" href="mailto:service@choies.com" target="_blank">service@choies.com</a>, um eine Rücksendungsgenehmigung (Rückkehradresse) oder Umtausch Genehmigung innerhalb von 60 Tagen nach Erhalt zu bekommen.
                    </p>
                    <div style="padding:15px;">
                        <strong style="display:block; font-style:italic;">Zusätzliche Zahlungssicherheit mit:</strong>
                        <span style="font-size:11px; color:#999;"><img class="mr10" style="vertical-align:middle" src="/images/nor-lock.png" />Sicheres Kassensystem  256-Bit SSL Verschlüsselung von Norton</span>
                        <span class="mt10 show">
                            <img src="/images/card24.jpg" usemap="#Card24" />
                            <map name="Card24" id="Card24">
                                <area target="_blank" shape="rect" coords="2,1,91,49" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en" />
                            </map>
                        </span>
                    </div>
                    </div>
                </div>
            </section>
        </section>
    </section>
</section>
<footer>
    <div class="footer_payment">
        <div class="card">
            <p><img src="/images/card.jpg" usemap="#Card"></p>
            <map name="Card" id="Card">
                <area target="_blank" shape="rect" coords="88,2,193,62" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&amp;dn=www.choies.com&amp;lang=en">
            </map>
            <div style="background-color:#232121;">
                <p class="bottom">
                    Copyright © 2006-<?php echo date('Y'); ?> Choies.com
                </p>
            </div>
        </div>
    </div>
</footer>

<div class="JS_popwincon1 popwincon popwincon_user hide">
    <a class="JS_close2 close_btn2"></a>
    <form action="/order/edit_address/<?php echo $order['id']; ?>" method="post" class="form user_share_form user_form form1">
        <input type="hidden" name="return" value="<?php echo LANGPATH; ?>/payment/gc_pay/<?php echo $order['ordernum']; ?>" />
        <input type="hidden" name="type" value="billing" />
        <ul class="add_showcon_boxcon">
            <li>
                <label><span>*</span> Vorname:</label>
                <input type="text" value="<?php echo $order['billing_firstname']; ?>" name="billing_firstname" id="billing_firstname" class="text text_long" />
            </li>
            <li>
                <label><span>*</span> Nachname:</label>
                <input type="text" value="<?php echo $order['billing_lastname']; ?>" name="billing_lastname" id="billing_lastname" class="text text_long" />
            </li>
            <li>
                <label><span>*</span> Adresse:</label>
                <div>
                    <textarea class="textarea_long" name="billing_address" id="billing_address"><?php echo $order['billing_address']; ?></textarea>
                </div>
            </li>
            <li>
                <label><span>*</span> Land:</label>
                <select name="billing_country" class="select_style selected304" id="billing_country" onchange="changeSelectCountry2();$('#billing_country').val($(this).val());">
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
                <div id="all2_default">
                    <input type="text" name="billing_state" id="billing_state" class="all2 text text_long" value="<?php echo $order['billing_state']; ?>" maxlength="320" />
                    <div class="errorInfo"></div>
                </div>
                <script>
                    function changeSelectCountry2(){
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
                <label><span>*</span> Stadt/Ort:</label>
                <input type="text" value="<?php echo $order['billing_city']; ?>" name="billing_city" id="billing_city" class="text text_long" />
            </li>
            <li>
                <label><span>*</span> PLZ:</label>
                <input type="text" value="<?php echo $order['billing_zip']; ?>" name="billing_zip" id="billing_zip" class="text text_long" />
            </li>
            <li>
                <label><span>*</span> Telefon:</label>
                <div class="right_box">
                    <input type="text" value="<?php echo $order['billing_phone']; ?>" name="billing_phone" id="billing_phone" class="text text_long" />
                    <p class="phone_tips">Bitte hinterlassen Sie eine richtige und vollständige Telefonnummer für pünktliche Lieferung von Postbote.</p>
                </div>
            </li>
            <li id="billing_cpf" class="hide">
                <label><span>*</span>o cadastro de pessoa Física:</label>
                <input type="text" name="billing_cpf" id="billing_cpf" class="text text_long" value="" />
            </li>
            <li>
              <label>&nbsp;</label>
              <div class="right_box"><input type="submit" value="SENDEN" class="btn30_14_black" /></div>
            </li>
        </ul>
        </form>
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
     $popup_message.innerHTML = '<?php echo Kohana::config('lang.'.$lang.'.payment.choosecard1'); ?>';
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
		$popup_message = document.getElementById('card_error1');
        $popup_message.style.display = 'none';			
		
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

<script src="//cdn.optimizely.com/js/557241246.js"></script>