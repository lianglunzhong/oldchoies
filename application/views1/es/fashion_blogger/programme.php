<?php
$url1 = parse_url(Arr::get($_SERVER, 'HTTP_REFERER', '/'));
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
			<section class="container">
				<div class="blogger-img hidden-xs">
					<div class="step-nav step-nav1">
                        <ul class="clearfix">
                            <li class="current">Blogger De Moda<em></em><i></i></li>
                            <li>Leer La Política<em></em><i></i></li>
                            <li>Presentar Información<em></em><i></i></li>
                            <li>Conseguir Una Bandera<em></em><i></i></li>
                        </ul>
                    </div>
				</div>
				<p class="hidden-xs img-active">
    				<img src="<?php echo STATICURL; ?>/assets/images/blogger/blogger-es.jpg" border="0" usemap="#Map" />
					<map name="Map" id="Map">
                      <area shape="poly" coords="112,337,182,187,437,134,495,203,544,187,520,232,565,321,501,458,195,482" href="<?php echo LANGPATH; ?>/blogger/read_policy">
                      <area shape="poly" coords="712,379,915,377,922,484,697,481" href="<?php echo LANGPATH; ?>/blogger/read_policy">
                      <area shape="poly" coords="1196,504,1197,654,1188,662,913,664" href="<?php echo LANGPATH; ?>/blogger/get_banner?shortcut">
                    </map>
				</p>
			</section>
			<section class="visible-xs-block hidden-sm hidden-md hidden-lg blogger-step1-phone">
				<div class="col-xs-12">
					<p><a href="<?php echo LANGPATH; ?>/blogger/read_policy">Quiero unirse choies!</a>
					</p>
					<p><a href="<?php echo LANGPATH; ?>/blogger/get_banner?shortcut">Quiero conseguir una bandera.</a>
					</p>
				</div>
			</section>
		</section>

		<!-- footer begin -->

		<!-- gotop -->
		<div id="gotop" class="hide">
			<a href="#" class="xs-mobile-top"></a>
		</div>


	</body>

</html>