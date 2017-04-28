<style type="text/css">
    .track_none p{color:#da0609;}
    .track_none table{margin-top: 25px;margin-bottom: 0px;}
    .track_none table th,.track_none table td{ padding:10px; text-align:center; border:#e4e4e4 1px solid;}
    .track_none table th{padding:8px;}
</style>
<!-- main begin -->
<section id="main">
    <!-- main begin -->
    <section class="layout fix">
        <section class="cart">
            <div class="order_track_tit"><h4>Bestellung Verfolgen </h4></div>
            <div class="order_track_con fix">
                <form action="#" method="" class="form fll" onsubmit="return false">
                    <ul>
                        <li><input type="text" value="" name="code" class="text" id="code"/></li>
                        <li><input type="button" value="VERFOLGEN" class="btn view_btn btn40" id="do_check"/></li>
                    </ul>
                </form>
                <script type="text/javascript">
                    $(function(){
                        $("#do_check").bind("click",function(){
                            $("#msg").hide();
                            $("#track_info").hide();
                            $(".track_none").hide();
                            var code = $("#code").val()
                            $.ajax({
                                type: "POST",
                                url: "/track/ajax_orderdata",
                                dataType: "json",
                                data: "code="+code,
                                success: function(data){
                                  if(data.result=="has_order"){
                                    $("#order_date").html(data.data.created);
                                    $("#order_no").html(data.data.ordernum);
                                    $("#order_total").html(data.data.amount);
                                    $("#order_shipping").html(data.data.shipping);
                                    $("#order_status").html(data.data.order_status);
                                    $("#order_action").html('<a href="<?php echo LANGPATH;?>/order/view/'+data.data.ordernum+'">Details Sehen</a>');
                                    $(".track_none").fadeIn(620);
                                  }
                                }
                            });
                            $.ajax({
                                type: "POST",
                                url: "/track/ajax_pagedata?lang=<?php echo LANGUAGE; ?>",
                                dataType: "json",
                                data: "code="+code,
                                success: function(data){
                                    if(data.result=="login"){
                                        $("#tmp_code").attr("value",code);
                                        var top = getScrollTop();
                                        top = top - 35;
                                        $('body').append('<div class="JS_filter opacity"></div>');
                                        $('.JS_popwincon').css({
                                            "top": top, 
                                            "position": 'absolute'
                                        });
                                        $('.JS_popwincon').appendTo('body').fadeIn(320);
                                        $('.JS_popwincon').show();
                                    }else if(data.result=="noData"){
                                        $("#msg>p").html(data.msg).fadeIn(320)
                                        $("#msg").fadeIn(620)
                                    }else if(data.result=="success"){
                                        $("#msg").hide();
                                        var item = eval(data.data)
                                        $("#track_url").html('');
                                        $("#shipping_title").html('');
                                        $("#history").html('');
                                        $(".detail_tabcon").html('');
                                        for(var i=0; i<item.length;i++){
                                            $("#ordernum").html(item[i]['ordernum']);
                                            $("#date").html(item[i]['created']);
                                            $("#track_url").append("<li>Paket "+(i+1)+" Sendungnummer.: "+item[i]['tracking_code']+"</li><li>Verfolgungslink:<a href=\"#\"> "+item[i]['tracking_link']+"</a></li>")
                                            if(i===0){
                                                var cls = "class=\"current\"";
                                                var hd = "";
                                            }else{
                                                var cls = "";
                                                var hd = "hide";
                                            }

                                            $(".detail_tabcon").append('<div class="bd '+hd+'">\
                                          <ul class="box1 fix">\
                                            <li><b>Sendungnummer.:</b> <span id="track_no'+i+'"></span></li>\
                                            <li><b>Status:</b> <span id="status'+i+'"></span></li>\
                                            <li><b>Herkunftsland:</b><span id="send_country'+i+'"></span></li>\
                                            <li><b>Zielland:</b><span id="dest_country'+i+'"></span></li>\
                                          </ul>\
                                          <dl class="box3" id="history'+i+'"></dl>\
                                          <dl class="box3">\
                                            <dt>Versandt Nach:</dt>\
                                            <dd id="shipping_address'+i+'"></dd>\
                                            <dd id="shipping_country'+i+'"></dd>\
                                            <dd id="shipping_zip'+i+'"></dd>\
                                            <dd id="shipping_phone'+i+'"></dd>\
                                          </dl>\
                                        </div>');

                                            $("#shipping_title").append("<li "+cls+">Paket"+(i+1)+"</li>");
                                  
                                            $("#status"+i).html(item[i]['status']);
                                            $("#send_country"+i).html(item[i]['send_country']);
                                            $("#dest_country"+i).html(item[i]['dest_country']);
                                            $("#shipping_address"+i).html(item[i]['shipping_address']+','+item[i]['shipping_city']+','+item[i]['shipping_state']);
                                            $("#shipping_country"+i).html(item[i]['shipping_country']);
                                            $("#shipping_zip"+i).html(item[i]['shipping_zip']);
                                            $("#shipping_phone"+i).html(item[i]['shipping_phone']);

                                            $("#track_no"+i).html(item[i]['tracking_code']);
                                            if(typeof(item[i]['history'])!="undefined"){
                                                $("#history"+i).append("<dt>Zielland Historie</dt>");
                                                for (var l = 0; l < item[i]['history'].length; l++) {
                                                    $("#history"+i).append("<dd>"+item[i]['history'][l]['a']+"<span>"+item[i]['history'][l]['z']+"</span></dd>");
                                                }
                                            }
                                        }
                                        $("#track_info").fadeIn(620);
                                    }
                                },
                                error:function(){
                                    $("#msg").fadeOut(320);
                                    $("#track_info").fadeOut(320);
                                    $("#msg>p").html("Fehler.").fadeIn(320)
                                    $("#msg").fadeIn(620)
                                }
                            });
                        })
                    })
                </script>
                <dl class="right flr">
                    <dt>Tipps:</dt>
                    <dd>*Bitte geben Sie Bestellnummer oder Sendungnummer ein, um Ihre Bestellungen zu verfolgen.</dd>
                    <dd>*Sie können sich in Ihrem Konto anmelden und finden Sie "Bestellhistorie" und verfolgen Sie Ihren Bestellstatus dort mit alle Informationen Ihrer Bestellungen.</dd>
                    <dd>*Falls Sie weitere Fragen zur Verfolgung haben, zögern Sie bitte keinen Augenblick, uns zu kontaktieren: <a href="mailto:service_de@choies.com" class="a_red">service_de@choies.com</a>.</dd>
                </dl>
            </div>
            <div class="track_none" style="display:none;">
              <div class="order-history">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr bgcolor="#e4e4e4">
                          <th width="20%"><strong>Bestelldatum</strong></th>
                          <th width="20%"><strong>Bestellnummer</strong></th>
                          <th width="15%"><strong>Gesamtsumme</strong></th>
                          <th width="15%"><strong>Lieferung</strong></th>
                          <th width="15%"><strong>Bestellstatus</strong></th>
                          <th width="15%"><strong>Aktion</strong></th>
                      </tr>
                      <tr bgcolor="#ffffff">
                          <td id="order_date"></td>
                          <td id="order_no"></td>
                          <td id="order_total"></td>
                          <td id="order_shipping"></td>
                          <td id="order_status"></td>
                          <td id="order_action"></td>
                      </tr>
                  </table>           
              </div>
            </div>
            <!-- 有物流 -->
            <div class="track_con" id="track_info" style="display:none;">
                <ul class="box1 fix">
                    <li><b>Bestellnummer.:</b><span id="ordernum"></span></li>
                    <li><b>Bestelldatum:</b><span id="date"></span></li>
                </ul>
                <ul class="box2 fix" id="track_url"></ul>
                <ul class="JS_tab detail_tab fix" id="shipping_title"></ul>
                <div class="JS_tabcon detail_tabcon">

                    <div class="bd">
                        <ul class="box1 fix">
                            <li><b>Sendungnummer.:</b> <span id="track_no"></span></li>
                            <li><b>Status:</b> <span id="status"></span></li>
                            <li><b>Herkunftsland:</b><span id="send_country"></span></li>                                                                              
                            <li><b>Zielland:</b><span id="dest_country"></span></li>
                        </ul>
                        <dl class="box3" id="history"></dl>
                        <dl class="box3">
                            <dt>Versandt Nach:</dt>
                            <dd id="shipping_address"></dd>
                            <dd id="shipping_country"></dd>
                            <dd id="shipping_zip"></dd>
                            <dd id="shipping_phone"></dd>
                        </dl>
                    </div>

                    <div class="bd hide">111</div>

                </div>
            </div>

            <!-- 没有物流 -->
            <div class="track_con track_con_no" id="msg" style="display:none;">
                <p class="red"></p>
            </div>

            <p><img src="/images/card4.jpg" /></p>       
        </section>
    </section>
</section>

<!-- JS_popwincon -->
<div class="JS_popwincon popwincon track_pop w_signup hide">
    <a class="JS_close1 close_btn2"></a>
    <div class="fix">
        <div class="left">
            <h3>CHOIES Mitglied Anmelden</h3>
            <form action="<?php echo LANGPATH; ?>/customer/login?redirect=/track/track_order" method="post" class="signin_form sign_form form">
                <input type="hidden" name="tmp_code" id="tmp_code" value="" />
                <ul>
                    <li><input type="text" value="Email Adresse" name="email" class="text" /></li>
                    <li><input type="password" value="Passwort" name="password" class="text" /></li>
                    <li><input type="submit" value="ANMELDEN" name="submit" class="btn40_16_red" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">Passwort vergessen?</a></li>
                    <li>
                        <?php
                        $redirect = "track/track_order";
                        $page = isset($_SERVER['HTTP_SELF']) ? 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_SELF'] . '/' . htmlspecialchars($redirect) : 'http://' . $_SERVER['HTTP_HOST'] . '/' . htmlspecialchars($redirect);
                        $facebook = new facebook();
                        $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                        ?>
                        <a href="<?php echo $loginUrl; ?>" class="facebook_btn">Mit Facebook Verbinden</a>
                    </li>
                </ul>
            </form>
        </div>
    </div>  
</div> 