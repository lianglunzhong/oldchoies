        <section id="main">
            <!-- crumbs -->
            <div class="container visible-xs-inline hidden-sm hidden-md hidden-lg col-xs-12">
                <div class="crumbs">
                    <div>
                        <a href="<?php echo LANGPATH; ?>/">home</a>
                        <a href="<?php echo LANGPATH; ?>/customer/summary"> > Mon Compte</a> > track order
                    </div>
                    <?php echo Message::get(); ?>
                </div>
            </div>
            <!-- main-middle begin -->
            <div class="container">
                <div class="cart row">
                    <div class="order-track-tit col-xs-12">
                        <h4>Centre De Suivi De Commande De Choies</h4>
                    </div>
                    <div class="order-track-con">
                        <form onsubmit="return false" class="form col-xs-12 col-sm-6" method="" action="#">
                            <ul>
                                <li>
                                    <input type="text"  value="" id="code" class="text " name="code" value="">
                                </li>
                                <li>
                                    <input type="button" id="do_check" class="btn btn-primary btn-sm" value="SUIVRE">
                                </li>
                            </ul>
                        </form>
                        <script type="text/javascript">
                            $(function(){
                                $("#do_check").bind("click",function(){
                                    $("#msg").hide();
                                    $("#track_info").hide();
                                    $(".track-none").hide();
                                    var code = $("#code").val()
                                    $.ajax({
                                        type: "POST",
                                        url: "/tracks/ajax_orderdata",
                                        dataType: "json",
                                        data: "code="+code,
                                        success: function(data){
                                          if(data.result=="has_order"){
                                            $("#order_date").html(data.data.created);
                                            $("#order_no").html(data.data.ordernum);
                                            $("#order_total").html(data.data.amount);
                                            $("#order_shipping").html(data.data.shipping);
                                            $("#order_status").html(data.data.order_status);
                                            $("#order_action").html('<a href="<?php echo LANGPATH;?>/order/view/'+data.data.ordernum+'">Voir Détails</a>');
                                            $(".track-none").fadeIn(620);
                                          }
                                        }
                                    });
                                    $.ajax({
                                        type: "POST",
                                        url: "/tracks/ajax_pagedata1?lang=<?php echo LANGUAGE; ?>",
                                        dataType: "json",
                                        data: "code="+code,
                                        success: function(data){
                                          if(data.result=="login"){
                                            $("#tmp_code").attr("value",code);
                                            var top = getScrollTop();
                                            top = top - 35;
                                            $('body').append('<div class="JS_filter opacity hidden-xs"></div>');
                                            $('.JS_popwincon').css({
                                                "top": top, 
                                                "position": 'absolute'
                                            });
                                            $('.JS_popwincon').appendTo('body').fadeIn(320);
                                            $('.JS_popwincon').show();
                                          }else if(data.result=="noData"){
                                            $("#msg>p").html(data.msg).fadeIn(320)
                                            $("#msg").fadeIn(620)
                                            window.location.href = '#message';
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
                                              if(i===0){
                                                var cls = "class='current'";
                                                var hd = "";
                                              }else{
                                                var cls = "";
                                                var hd = "hide";
                                              }

                                              $(".detail_tabcon").append('<div class="bd '+hd+'">\
                                                <ul class="box1 row">\
                                                  <li class="col-xs-12 col-sm-6"><b class="col-xs-12 col-sm-2" style="padding:0;">N°de Suivi: </b> <span id="track_no'+i+'" class="col-xs-12 col-sm-4"></span></li>\
                                                  <li class="col-xs-12 col-sm-6"><b>État:</b> <span id="status'+i+'"></span></li>\
                                                  <li class="col-xs-12 col-sm-6"><b>Pays d\'Origine:</b><span id="send_country'+i+'"></span></li>\
                                                  <li class="col-xs-12 col-sm-6"><b>Pays De Destination:</b><span id="dest_country'+i+'"></span></li>\
                                                </ul>\
                                                <dl class="box3" id="history'+i+'"></dl>\
                                                <dl class="box3">\
                                                  <dt>Expédié à:</dt>\
                                                  <dd id="shipping_address'+i+'"></dd>\
                                                  <dd id="shipping_country'+i+'"></dd>\
                                                  <dd id="shipping_zip'+i+'"></dd>\
                                                  <dd id="shipping_phone'+i+'"></dd>\
                                                </dl>\
                                              </div>');
                                              if(item.length>1){
                                                $("#shipping_title").append("<li "+cls+">Colis"+(i+1)+"</li>");
                                                $("#track_url").append("<li>Colis "+(i+1)+" N°de Suivi: "+item[i]['tracking_code']+"</li><li>Lien de Suivi:  <a href='#'>"+item[i]['tracking_link']+"</a></li>")
                                              }else{
                                                $("#track_url").append("<li>N°de Suivi: "+item[i]['tracking_code']+"</li><li>Lien de Suivi:  <a href='"+item[i]['tracking_link']+"'>"+item[i]['tracking_link']+"</a></li>")
                                              }
                                              if(item[i]['history'])
                                              {
                                                if(item[i]['history'].length>0)
                                                {
                                                $("#status"+i).html(item[i]['status']);
                                                $("#send_country"+i).html(item[i]['send_country']);
                                                $("#dest_country"+i).html(item[i]['dest_country']);
                                                $("#shipping_address"+i).html(item[i]['shipping_address']+','+item[i]['shipping_city']+','+item[i]['shipping_state']);
                                                $("#shipping_country"+i).html(item[i]['shipping_country']);
                                                $("#shipping_zip"+i).html(item[i]['shipping_zip']);
                                                $("#shipping_phone"+i).html(item[i]['shipping_phone']);
                                                  
                                                $("#track_no"+i).html(item[i]['tracking_code']);
                                                if(typeof(item[i]['history'])!="undefined"){
                                                  $("#history"+i).append("<dt>Histoire de Pays de Destination</dt>");
                                                  for (var l = 0; l < item[i]['history'].length; l++) {
                                                    $("#history"+i).append("<dd>"+item[i]['history'][l]['a']+"<span>"+item[i]['history'][l]['z']+"</span></dd>");
                                                      }
                                                    }
                                                   }                                               
                                              }
                                              else
                                              {
                                                $(".JS_tabcon").html('');
                                              }   
                                  
                                              }
                                              $("#track_info").fadeIn(620);
                                            }
                                          },
                                        error:function(){
                                          $("#msg").fadeOut(320);
                                          $("#track_info").fadeOut(320);
                                          $("#msg>p").html("Error.").fadeIn(320)
                                          $("#msg").fadeIn(620)
                                          
                                        }
                                    });
                                })
                            })
                        </script>
                        <dl class="right col-xs-12 col-sm-6">
                            <dt>Propositions:</dt>
                     <dd>*Veuillez entrer NO. de commande ou No. de suivi pour suivre votre commande.</dd>
                    <dd>*Vous pouvez également vous connecter à votre compte et trouver« Historique des commandes », puis suivre le statut de votre commande avec l'information de toutes vos commandes.</dd>
                    <dd>*Parfois certains clients ne peuvent pas suivre leurs commandes ici en raison du contrôle d'accès au réseau dans leurs pays et régions.Nous sommes très désolés pour cela.Dans ce cas, vous pouvez nous contacter via <a class="a-underline a-red" style="display:inline-block;margin-left:5px;" href="mailto:service_fr@choies.com">service_fr@choies.com</a> et notre équipe de service à la clientèle vous aidera avec le suivi.
                    <dd>* Pendant la saison de vacances, commandes avec Livraison standard ne seront pas traçables lorsque les colis arrivent aux États-Unis.Parce que site USPS ne mettra plus à jour les informations sur l'emballage d'expédition. Normalement il prend 20 jours pour l'expédition aux Etats-Unis, s'il vous plaît être facile d'attendre pour votre paquet, si elle est plus de 20 jours à attendre pour votre paquet, Contactez USPS ou PO locale pour plus d'informations.
                    </dd>
                    </dd>
                            
                        </dl>
                    </div>
                </div>
                <!--无物流 -->
                <div id="msg" class="track-con-no" style="display:none;">
                    <p class="red" style="">Sorry, no tracking information found by your order No. or tracking code.</p>
                </div>
                <!--未发货无物流 -->
                <div class="track-none" style="display:none;">
                    <div class="order-history">
                        <div class="table-responsive">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                    <tr bgcolor="#fafafa">
                          <th width="20%"><strong>Date de Commande</strong></th>
                          <th width="20%"><strong>N°de Commande</strong></th>
                          <th width="15%"><strong>Total de Commande</strong></th>
                          <th width="15%"><strong>Livraison</strong></th>
                          <th width="15%"><strong>Statut de Commande</strong></th>
                          <th width="15%"><strong>Action</strong></th>
                                    </tr>
                                    <tr bgcolor="#fff">
                      <td id="order_date"></td>
                      <td id="order_no"></td>
                      <td id="order_total"></td>
                      <td id="order_shipping"></td>
                      <td id="order_status"></td>
                      <td id="order_action"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--有物流 -->
                <div class="track-con" id="track_info" style="display:none;">
                    <ul class="box1">
                        <li><b>N°de Commande:</b><span id="ordernum"></span></li>
                        <li><b>Date de Commande:</b> <span id="date"></span></li>
                    </ul>

                    <ul class="box2" id="track_url">
                    </ul>
          <ul class="JS_tab detail_tab fix" id="shipping_title"></ul>
        
                    <div class="track-detail hidden-xs">
        
                        <div class="JS_tabcon detail_tabcon">
                            <div class="bd">
                                <ul class="box1 row">
                                    <li class="col-xs-12 col-sm-6"><b class="col-xs-12 col-sm-2" style="padding:0;">Numéro De Suivi.:</b> <span class="col-xs-12 col-sm-4" id="track_no"></span>
                                    </li>
                                    <li class="col-xs-12 col-sm-6"><b>État:</b><span id="status"></span></li>
                                    <li class="col-xs-12 col-sm-6"><b>Pays d\'Origine:</b> <span id="send_country"></span></li>
                                    <li class="col-xs-12 col-sm-6"><b>Pays De Destination:</b><span id="dest_country"></span></li>
                                </ul>
                                <dl class="box3" id="history">
                                </dl>
                                <dl class="box3">
                                    <dt>Expédié à:</dt>
                <dd id="shipping_address"></dd>
                <dd id="shipping_country"></dd>
                <dd id="shipping_zip"></dd>
                <dd id="shipping_phone"></dd>
                                </dl>
                            </div>
                            <div class="bd hide">111</div>
                        </div>
                    </div>

                </div>
                <p>
                    <img src="/assets/images/card4.jpg">
                </p>
            </div>
        </section>
        <!-- footer begin -->
<!-- JS_popwincon -->
<div class="JS_popwincon hidden-xs track-pop w-signup hide" >
            <a class="JS_close2 close-btn3"></a>
            <div>
                <div>
                    <h3>Déjà client CHOIES</h3>
                    <form class="signin-form sign-form form" method="post" action="<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/tracks/track_order">
                        <input id="tmp_code" type="hidden" value="" name="tmp_code">
                        <ul>
                            <li>
                                <input class="text" type="text" name="email" value="">
                            </li>
                            <li>
                                <input class="text" type="password" name="password" value="">
                            </li>
                            <li>
                                <input class="btn btn-primary btn-lg mr10" type="submit" name="submit" value="SE CONNECTER"><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text-underline">Mot de passe oublié?</a>
                            </li>
                            <li>
                                <?php
                                $redirect = "tracks/track_order";
                                $page = isset($_SERVER['HTTP_SELF']) ? 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_SELF'] . '/' . htmlspecialchars($redirect) : 'http://' . $_SERVER['HTTP_HOST'] . '/' . htmlspecialchars($redirect);
                                $facebook = new facebook();
                                $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                                ?>
                                <a href="<?php echo $loginUrl; ?>" class="facebook-btn">Connexion avec Facebook</a>
                             </li>
                       </ul>
                 </form>
            </div>
       </div>  
</div> 
        
        <div id="gotop" class="hide">
            <a href="#" class="xs-mobile-top"></a>
        </div>
        <script type="text/javascript">
            function getScrollTop() {
                var scrollPos;
                if (window.pageYOffset) {
                    scrollPos = window.pageYOffset;
                } else if (document.compatMode && document.compatMode != 'BackCompat') {
                    scrollPos = document.documentElement.scrollTop;
                } else if (document.body) {
                    scrollPos = document.body.scrollTop;
                }
                return scrollPos;
            }
             $(".JS_close2,.JS_filter").live("click", function() {
                $(".JS_filter").remove();
                $('.JS_popwincon').fadeOut(160);
                return false;
            })
    </script>

