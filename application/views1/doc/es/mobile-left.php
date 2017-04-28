
		<section id="main" class="visible-xs-inline hidden-sm hidden-md hidden-lg">
			<!-- crumbs -->
			<div class="container">
				<div class="crumbs">
					<div>
						<a href="<?php echo LANGPATH; ?>/">PÁGINA DE INICIO </a> > Centro De Ayuda
					</div>
				</div>
			</div>
			<!-- main-middle begin -->
			<div class="container">
				<div class="row">
<aside id="aside" class="col-xs-12">
    <div class="category-box-mobile">
        <h3 class="bg">Centro De Ayuda</h3>
        <ul class="scroll-list-mobile">
        <?php
        $url = URL::current(0);
       $links = array(
array('name' => 'Sobre Nosotros', 'link' => '/about-us'),
array('name' => 'Contáctenos', 'link' => '/contact-us'),
array('name' => 'Envío y Entrega', 'link' => '/shipping-delivery'),
array('name' => 'Devolución y Cambio', 'link' => '/returns-exchange'),
array('name' => 'Privacidad y Seguridad', 'link' => '/privacy-security'),
array('name' => 'Guía de Talla', 'link' => '/size-guide'),
array('name' => 'Pago', 'link' => '/payment'),
array('name' => 'Política VIP', 'link' => '/vip-policy'),
array('name' => 'FAQ', 'link' => '/faqs'),
array('name' => 'Venta al por Mayor', 'link' => '/wholesale'),
array('name' => 'Programa de Afiliados', 'link' => '/affiliate-program'),
array('name' => 'Aviso de Choies ', 'link' => '/important-notice'),
        );
        foreach($links as $link):
        ?>
            <li><a  href="<?php echo LANGPATH; ?><?php echo $link['link']; ?>" <?php if($url == $link['link']) echo 'class="on"'; ?>><?php echo $link['name']; ?></a></li>
        <?php
        endforeach;
        ?>
        </ul>
    </div>
</aside>
						
							</div>
			</div>
			</section>
