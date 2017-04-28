<?php if (!Customer::logged_in()): ?>
    <script type="text/javascript">
        $(function(){
            $("#agree").live("click", function(){
				var top = getScrollTop();
				top = top - 35;
				$('body').append('<div class="JS_filter1 opacity hidden-xs"></div>');
				$('.JS_popwincon1').css({
					"top": top,
					"position": 'absolute'
				});
				$('.JS_popwincon1').appendTo('body').fadeIn(320);
				$('.JS_popwincon1').show();
				return false;

            })
                    
			 $(".JS_close2,.JS_filter1").live("click", function() {
				$(".JS_filter1").remove();
				$('.JS_popwinbtn1').fadeOut(160);
				return false;
			})
					
            $("#catalog_link .clsbtn,#wingray").live("click",function(){
                $("#wingray").remove();
                $('#catalog_link').fadeOut(160).appendTo('#tab2');
                return false;
            })
        })
		
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
    </script>
<?php endif; ?>
<?php
$url1 = parse_url(Request::$referrer);
?>
		<section id="main">
			<!-- crumbs -->
			<div class="container">
				<div class="crumbs">
					<div>
						<a href="<?php echo LANGPATH; ?>/">Página de Inicio</a> > Blogger De Moda
					</div>
					<div class="back visible-xs-inline hidden-sm hidden-md hidden-lg">&lt;&lt;&nbsp;<a class="back" href="<?php echo LANGPATH.$url1['path']; ?>">Volver</a>
					</div>
				</div>
			</div>
			<!-- main begin -->
			<section class="container blogger-wanted">
				<div class="blogger-img hidden-xs">
					<div class="step-nav step-nav1">
                        <ul class="clearfix">
                            <li>Blogger De Moda<em></em><i></i></li>
                            <li class="current">Leer La Política<em></em><i></i></li>
                            <li>Presentar Información<em></em><i></i></li>
                            <li>Conseguir Una Bandera<em></em><i></i></li>
                        </ul>
                    </div>
				</div>
				<article class="row">
					<div class="col-sm-1 hidden-xs"></div>
					<div class="col-sm-10 col-xs-12">
						<div class="fashion-policy">
							<h3>BLOGGER DE MODA:</h3>
							<p>No importa si eres una amante de la moda o una blogger de moda, siempre muestras tu gusto por la moda como una mente libre.</p>
			                <p>Uniéndote al programa de Blogger de moda de Choies.com, te beneficiarás de descuentos especiales y artículos gratis de nuestras grandes novedades.</p>
			                <p>No dude en enviarnos un correo electrónico a <a href="mailto:business@choies.com" title="business@choies.com">bussiness@choies.com</a> sobre usted mismo.</p>
			            </div>
						<div class="fashion-policy">
							<p>¿Como unirse al programa de Blogger de moda?</p>
			                <h3>1¿Eres una blogger que se centra en la moda y estilo actual?</h3>
			                <p>CHOIES ha colaborado con muchos bloggers famosos y sería un honor contar contigo en nuestro programa de moda.</p>
			                <h3>Requisitos:</h3>
			                <p>  1. ¿Crees que tienes buen gusto en moda y que eres influyente en tu blog personal, página de Facebook, canal de Youtube, Chicisimo?</p>
			                <p>  2. ¿Hablas de moda de forma frecuente, al menos una vez por semana?</p>
			                <p>&nbsp;</p>
			                <h3>2.  ¿Cómo empezar?</h3>
			                <p>Primero tienes que registrarte en www.choies.com y poner nuestro banner en tu blog. Puedes conseguir el código para el banner haciendo click en “Acepto”. Infórmanos de tu registro por email, añadiremos puntos en tu cuenta.</p>
			                <p>&nbsp;</p>
			                <h3>3. ¿Qué regla tengo que seguir para renovar mis puntos?</h3>
			                <p>Normalmente tienes que mostrar nuestros productos antes de siete días y enviarnos un link de tu blog. Tiene que haber un link directo al producto que estas llevando en tu blog, únicamente usarás el link de la página principal si el producto se ha agotado. Te daremos puntos extra si compartes tu look en Chicisimo.com e incluyes un link a Choies.com.</p>
			                <p>&nbsp;</p>
			                <h3>4. ¿Cada cuánto recompensáis a los bloggers?</h3>
			                <p>Por lo general, damos puntos a los bloggers para que puedan usarlos en la tienda. Renovamos sus puntos cuando hacen outfits en sus blogs y en tantas redes sociales como puedan y nos envían el link de la publicación.</p>
			                <p>&nbsp;</p>
			                <h3>5. ¿Tengo que pagar aduanas?</h3>
			                <p>La política de aduanas es diferente en cada país. Por ejemplo, los bloggers de Brasil tiene que facilitarnos su DNI y pagar tasas. Todo depende de la política de tu país. </p>
			                <p>&nbsp;</p>
			                <h3>6. ¿Hay otras formas de conseguir más puntos?</h3>
			                <p>Sí, puedes conseguirlos escribiendo una entrada colaborativa con CHOIES o haciendo sorteos para Choies y enviándonos el link de la publicación.</p>
			                <p>&nbsp;</p>
			                <h3>7. Por favor, regístrate en choies.com antes de continuar.</h3>
			                <p>No podrás usar los puntos a no ser que estés registrada.</p>
						</div>
						<div>
							<h3>Sobre el copyright de tus fotos.</h3>
			                <p>Tenemos derecho de poner fotos de tu blog en nuestra página de Facebook, Instagram y cualquier otra página oficial.</p>
			                <p>Si tienes alguna otra duda acerca de nuestro programa Blogger de moda puedes enviarnos un emal a <a href="mailto:business@choies.com" title="business@choies.com">business@choies.com</a>.</p>
			                <p>&nbsp;</p>
			                <p>Lo comprobaremos en una semana y te responderemos si has sido seleccionada. </p>
			                <p>Si estás de acuerdo con los términos anteriores, haz clic en Acepto para continuar.</p>
			                <div id="agree" class="mt20 mb10">
								<p><a href="<?php echo LANGPATH; ?>/blogger/submit_information"><strong class="btn btn-primary btn-lg">Acepto</strong></a>
								</p>
							</div>
						</div>
					</div>
					<div class="col-sm-1 hidden-xs"></div>
				</article>
			</section>
            <div class="JS_popwincon1  hide" style="position: fixed; padding: 10px 10px 20px; top: 100px; left: 400px; width: 640px; height: 230px; z-index: 1000; background: none repeat scroll 0% 0% rgb(255, 255, 255); border:1px solid rgb(204, 204, 204);">
			    <div class="order">
			        <div class="fashion-thank">
			            <h4>Consigue tu cuenta primero antes del próximo paso.<br/>
                			Por favor ingresa o regístrate.</h4>
			            <div class="2btns">
			                <span style="padding-right:10px;"><a class="btn btn-primary btn-sm" title="ACCEDER" href="<?php echo LANGPATH; ?>/customer/login?redirect=/blogger/submit_information"><strong style="width: 100px;" class="view_btn btn26 btn40">ACCEDER</strong></a></span>
			                <span><a class="btn btn-primary btn-sm" title="Registrar" href="<?php echo LANGPATH; ?>/customer/register?redirect=/blogger/submit_information"><strong style="width: 100px;" class="view_btn btn26 btn40">Registrar</strong></a></span>
			            </div>
			        </div>
			    </div>
			    <div class="JS_close2 close-btn3"></div>
			</div>			
					

			<!-- footer begin -->

			<!-- gotop -->
			<div id="gotop" class="hide">
				<a href="#" class="xs-mobile-top"></a>
			</div>