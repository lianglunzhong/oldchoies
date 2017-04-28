	<section id="main">
			<div class="container visible-xs-inline hidden-sm hidden-md hidden-lg col-xs-12">
				<div class="crumbs">
					<div>
						<a href="<?php echo LANGPATH; ?>/">Página de Inicio</a> > Cómo Realizar Un Pedido
					</div>

				</div>
			</div>
			<!-- main-middle begin -->
			<div class="container">
				<div class="row">
					<article class="top-follow" style="line-height:40px;height:40px;">
						<p class="col-xs-12 mb20">Apenas Unos Pasos Antes De Completar El Pedido.</p>
					</article>
					<section class="container">
						<aside class="aside-active hidden-xs">
							<ul>
								<li class="on"><a title="1" href="javascript:void(0)"><span>01</span> <p>¿Cómo buscar el artículo<br/> que desea?
								</p></a></li>
								<li><a title="2" href="javascript:void(0)"><span>02</span> <p> Ver y editar su bolsa<br/> de compras.
								</p></a></li>
								<li><a title="3" href="javascript:void(0)"><span>03</span> <p>Completar su<br/> pago con tarjeta de crédito.
								</p></a></li>
								<li><a title="4" href="javascript:void(0)"><span>04</span> <p>Ver los detalles de su<br/> pedido. 
								</p></a></li>
							</ul>
						</aside>
						<article class="main-how col-sm-9 col-xs-12">
							<h1 id="index_1"><p><span class="list-circle hidden-xs">1</span><span><b class="visible-xs-inline hidden-sm">1</b>&nbsp;&nbsp;&nbsp;&nbsp;¿Cómo buscar el artículo que desea?</span></p></h1>
							<p class="tips">(1)A través de los banners de página principal, puede acceder a todas las actividades y las rebajas que están sucediendo.
								<img src="<?php echo STATICURL; ?>/ximg/es/pic1.1.jpg">
							</p>
							<p class="tips">(2)Desde Navegación: Se mostrará el catálogo específico del artículo que desea.
								<img src="<?php echo STATICURL; ?>/ximg/es/pic1.2.jpg">
								<img src="<?php echo STATICURL; ?>/ximg/es/pic1.3.jpg">
								<img src="<?php echo STATICURL; ?>/ximg/es/pic1.4.jpg">
							</p>
							<h1 id="index_2"><p><span class="list-circle hidden-xs">2</span><span><b class="visible-xs-inline hidden-sm">2</b>&nbsp;&nbsp;&nbsp;&nbsp;Ver y editar su bolsa de compras. </span></p></h1>
							<p class="tips">
								(1)Añadir un artículo disponible a su bolsa de compras. Inventario disponible se asignará a su pedido después de hacer clic PAGAR. Entonces usted recibirá un email de confirmacion.<br><br>
                                
                                Puede modificar los detalles en su bolsa de compras.<br><br>
                                
                               	Para cambiar la cantidad o la talla, haga clic en "Cambiar Detalles" e introduzca un número en el cuadro Cantidad y seleccione una talla en el menú desplegable, a continuación, haga clic en Actualizar.<br><br>
                                
                              	Para comprar más tarde, puede hacer clic "Guardar para después", a continuación, se guardará el artículo a su Lista de artículos guardados.
								<img src="<?php echo STATICURL; ?>/ximg/es/pic2.1.jpg">
								<img src="<?php echo STATICURL; ?>/ximg/es/pic2.2.jpg">
							</p>
							<p class="tips">(2)Inicia sesión en tu cuenta o crear una nueva cuenta si ésta es su primera orden.<img src="<?php echo STATICURL; ?>/ximg/es/pic2.3.jpg"></p>
							<p class="tips">(3)Introduzca una dirección de envío, elija un método de envío.<img src="<?php echo STATICURL; ?>/ximg/es/pic2.4.jpg">
							</p>
				            <p class="tips">(4)Revise los detalles de pedido y elige un método de pago. Asegúrese de que haya aplicado el bono o puntos si tiene algún. 
								Haga clic VOY A PAGAR para entrar el próximo paso.  
								<img src="<?php echo STATICURL; ?>/ximg/es/pic2.5.jpg">
							</p>
							<h1 id="index_3"><p><span class="list-circle hidden-xs">3</span><span><b class="visible-xs-inline hidden-sm">3</b>&nbsp;&nbsp;&nbsp;&nbsp;Completar su pago con tarjeta de crédito. </span></p></h1>
							<p class="tips">Si usted elige una tarjeta de crédito y haga clic " VOY A PAGAR", por favor complete toda la información en la página. Actualmente, aceptamos VISA, MasterCard, VISA Electron, Débito VISA, Débito MasterCard.
								Tenga en cuenta que la fecha de vencimiento está en la parte frontal de la tarjeta y el código CVV2 o código de seguridad está en el reverso.<img src="<?php echo STATICURL; ?>/ximg/es/pic3.1.jpg">
							</p>
							<h1 id="index_4"><p><span class="list-circle hidden-xs">4</span><span><b class="visible-xs-inline hidden-sm">4</b>&nbsp;&nbsp;&nbsp;&nbsp;Ver los detalles de su pedido. </span></p></h1>
							<p class="tips">Si usted complete el pedido con éxito, se le dirigirá a la página de confirmación de pago.
								Haga clic el N°de Pedido para ver más detalles.
								<img src="<?php echo STATICURL; ?>/ximg/es/pic4.1.jpg">
							</p>
							<p class="tips" style="font-size:16px;color:#000;">Consejos: Si el pago falla, podría volver a su cuenta y encontrar los últimos detalles de la orden. 
								<img src="<?php echo STATICURL; ?>/ximg/es/pic4.2.jpg"><img src="<?php echo STATICURL; ?>/ximg/es/pic4.3.jpg">
							</p>
							<p class="tips" style="font-size:16px;color:#000;">
								Consejos: comprube su email de confirmación de la orden en su correo electrónico.
								<br>
							</p>
							<p class="tips">
								Su pedido será creada y usted recibirá un email de confirmación de nosotros después de hacer clic"VOY A PAGAR".Si no recibelo, por favor comprube el Spam de su correo y añade Choies a la lista de contactos.
								<img src="<?php echo STATICURL; ?>/ximg/es/pic4.4.jpg">
							</p>
						</article>
					</section>
				</div>
			</div>
		</section>

		<script>
			$(function($) {
			$(".aside-active ul li a").click(function(event) {
			var index=this.title
			var id='#'+'index_'+index
			$("html,body").animate({scrollTop: $(id).offset().top-60}, 500);
			});
			function a(x,y){
			l = $('.main-how').offset().right;
			w = $('.main-how').width();
			$('.aside-active').css('right',(l + w + x) + 'px');
			$('.aside-active').css('bottom',y + 'px');}
			$(function () {
			$(window).scroll(function(){
			h = window.screen.width
			t = $(document).scrollTop();
			if(h>1024){
				if(t>=0&t<1300) { $(".aside-active ul li").eq(0).addClass("on").stop().siblings().removeClass("on");}
				if(t>=1300&t<3500) { $(".aside-active ul li").eq(1).addClass("on").stop().siblings().removeClass("on");}
				if(t>=3500&t<4400) { $(".aside-active ul li").eq(2).addClass("on").stop().siblings().removeClass("on");}
				if(t>=4400&t<6000) { $(".aside-active ul li").eq(3).addClass("on").stop().siblings().removeClass("on");}
				if(t>=6000){$(".aside-active").hide();}else{$(".aside-active").show();}
			}
			else if(h=1024){
				if(t>=0&t<1000) { $(".aside-active ul li").eq(0).addClass("on").stop().siblings().removeClass("on");}
				if(t>=1000&t<2800) { $(".aside-active ul li").eq(1).addClass("on").stop().siblings().removeClass("on");}
				if(t>=2800&t<4000) { $(".aside-active ul li").eq(2).addClass("on").stop().siblings().removeClass("on");}
				if(t>=4000&t<4800) { $(".aside-active ul li").eq(3).addClass("on").stop().siblings().removeClass("on");}
				if(t>=4800){$(".aside-active").hide();}else{$(".aside-active").show();}
			}
			else {
				if(t>=0&t<1000) { $(".aside-active ul li").eq(0).addClass("on").stop().siblings().removeClass("on");}
				if(t>=1000&t<3200) { $(".aside-active ul li").eq(1).addClass("on").stop().siblings().removeClass("on");}
				if(t>=3200&t<3600) { $(".aside-active ul li").eq(2).addClass("on").stop().siblings().removeClass("on");}
				if(t>=3600&t<4300) { $(".aside-active ul li").eq(3).addClass("on").stop().siblings().removeClass("on");}
				if(t>=4300){$(".aside-active").hide();}else{$(".aside-active").show();}
				}
			})
			});})
		</script>
