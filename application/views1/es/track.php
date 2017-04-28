		<section id="main">
			<!-- crumbs -->
			<div class="container visible-xs-inline hidden-sm hidden-md hidden-lg col-xs-12">
				<div class="crumbs">
					<div>
						<a href="<?php echo LANGPATH; ?>/">Página de Inicio</a>
						<a href="<?php echo LANGPATH; ?>/customer/summary"> > RESUMEN DE CUENTA</a> > Rastrear Pedido
					</div><?php echo Message::get(); ?>
				</div>
			</div>
			<!-- main-middle begin -->
			<div class="container">
				<div class="cart row">
					<div class="order-track-tit col-xs-12">
						<h4>Centro de Seguimiento de pedidos </h4>
					</div>
					<div class="order-track-con">
						<form onsubmit="return false" class="form col-xs-12 col-sm-6" method="" action="#">
							<ul>
								<li>
									<input type="text"  value="" id="code" class="text " name="code" value="">
								</li>
								<li>
									<input type="button" id="do_check" class="btn btn-primary btn-sm" value="RASTREAR">
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
			                                $("#order_action").html('<a href="<?php echo LANGPATH; ?>/order/view/'+data.data.ordernum+'">View Details</a>');
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
			                                    <ul class="box1 fix">\
			                                      <li><b>No. de seguimiento:</b> <span id="track_no'+i+'"></span></li>\
			                                      <li><b>Estado:</b> <span id="status'+i+'"></span></li>\
			                                      <li><b>País de Origen:</b><span id="send_country'+i+'"></span></li>\
			                                      <li><b>País de Destino:</b><span id="dest_country'+i+'"></span></li>\
			                                    </ul>\
			                                    <dl class="box3" id="history'+i+'"></dl>\
			                                    <dl class="box3">\
			                                      <dt>Enviado a:</dt>\
			                                      <dd id="shipping_address'+i+'"></dd>\
			                                      <dd id="shipping_country'+i+'"></dd>\
			                                      <dd id="shipping_zip'+i+'"></dd>\
			                                      <dd id="shipping_phone'+i+'"></dd>\
			                                    </dl>\
			                                  </div>');
			                                  if(item.length>1){
			                                    $("#shipping_title").append("<li "+cls+">Paquete"+(i+1)+"</li>");
			                                    $("#track_url").append("<li>Paquete "+(i+1)+" No. de seguimiento: "+item[i]['tracking_code']+"</li><li>Enlace de seguimiento: <a href='#'>"+item[i]['tracking_link']+"</a></li>")
			                                  }else{
			                                    $("#track_url").append("<li>No. de seguimiento: "+item[i]['tracking_code']+"</li><li>Enlace de seguimiento:<a href='"+item[i]['tracking_link']+"'> "+item[i]['tracking_link']+"</a></li>")
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
				                                    $("#history"+i).append("<dt>Historial del Seguimiento</dt>");
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
							<dt>Consejos:</dt>
				            <dd>*Por favor, introduzca No.de pedido O No. de seguimiento Para realizar el seguimiento de sus pedidos.</dd>
				            <dd>*También puede acceder a su cuenta y encontrar "Historial de pedidos", y dar seguimiento de su estado de pedido allí.</dd>
				            <dd>*A veces, algunos clientes no pueden rastrear sus pedidos aquí debido al control de acceso al red en sus países y regiones. Sentimos mucho por los inconvenientes. En ese caso, puede ponerse en contacto con nosotros a través de <a style="display:inline-block;margin-left:5px;" href="mailto:service_es@choies.com" class="a-underline a-red">service_es@choies.com</a> y nuestro equipo de servicio al cliente le ayudará con el seguimiento.
							<dd>*Durante las temporadas de fiestas, los pedidos con envío estándar no serán rastreable cuando lleguen a EE.UU. Es que la página web de USPS ya no actualizará la información sobre los paquetes. Generalmente tarda 20 días para llegar a EE.UU, por favor espere con paciencia. Si excede 20 días, por favor póngase en contacto con USPS o PO local para obtener más información.
							</dd>
				            </dd>
				        </dl>
					</div>
				</div>
				<!--无物流 -->
				<div id="msg" class="track-con-no" style="display:none;">
					<p class="red" style=""></p>
				</div>
				<!--未发货无物流 -->
				<div class="track-none" style="display:none;">
					<div class="order-history">
						<div class="table-responsive">
							<table width="100%" cellspacing="0" cellpadding="0" border="0">
								<tbody>
									<tr bgcolor="#e4e4e4">
				                      <th width="20%"><strong>Fecha de Pedido</strong></th>
				                      <th width="20%"><strong>N°de Pedido</strong></th>
				                      <th width="15%"><strong>Total de Pedido</strong></th>
				                      <th width="15%"><strong>Envío</strong></th>
				                      <th width="15%"><strong>Estado de Pedido</strong></th>
				                      <th width="15%"><strong>Acción</strong></th>
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
						<li><b>No. de Pedido:</b><span id="ordernum"></span></li>
            			<li><b>Fecha de Pedido:</b><span id="date"></span></li>
					</ul>

					<ul class="box2" id="track_url">
					</ul>
          <ul class="JS_tab detail_tab fix" id="shipping_title"></ul>
		
					<div class="track-detail hidden-xs">
		
						<div class="JS_tabcon detail_tabcon">
							<div class="bd">
								<ul class="box1 row">
									<li class="col-xs-12 col-sm-6"><b class="col-xs-12 col-sm-2" style="padding:0;">No. de seguimiento:</b> <span class="col-xs-12 col-sm-4" id="track_no"></span>
									</li>
									<li class="col-xs-12 col-sm-6"><b>Estados:</b><span id="status"></span></li>
									<li class="col-xs-12 col-sm-6"><b>País de Origen:</b> <span id="send_country"></span></li>
									<li class="col-xs-12 col-sm-6"><b>País de Destino:</b><span id="dest_country"></span></li>
								</ul>
								<dl class="box3" id="history">
								</dl>
								<dl class="box3">
									<dt>Enviado A:</dt>
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
					<h3>Acceso para socios</h3>
					<form class="signin-form sign-form form" method="post" action="<?php echo LANGPATH; ?>/customer/login?redirect=/tracks/track_order">
						<input id="tmp_code" type="hidden" value="" name="tmp_code">
						<ul>
							<li>
								<input class="text" type="text" name="email" value="">
							</li>
							<li>
								<input class="text" type="password" name="password" value="">
							</li>
							<li>
								<input class="btn btn-primary btn-lg mr10" type="submit" name="submit" value="ACCEDER"><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text-underline">¿Olvidaste tu contraseña?</a>
                            </li>
                            <li>
								<?php
                                $redirect = "tracks/track_order";
                                $page = isset($_SERVER['HTTP_SELF']) ? 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_SELF'] . '/' . htmlspecialchars($redirect) : 'http://' . $_SERVER['HTTP_HOST'] . '/' . htmlspecialchars($redirect);
                                $facebook = new facebook();
                                $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                                ?>
                                <a href="<?php echo $loginUrl; ?>" class="facebook-btn">Acceder con Facebook</a>
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

