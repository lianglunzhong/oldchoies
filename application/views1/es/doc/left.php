<aside id="aside" class="col-sm-3 hidden-xs">
    <div class="category-box aside_box">
        <h3 class="bg">Centro De Ayuda</h3>
        <ul class="scroll-list">
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
            $link['link'] = LANGPATH . $link['link'];
        ?>
            <li><a  href="<?php echo $link['link']; ?>" <?php if($url == $link['link']) echo 'class="on"'; ?>><?php echo $link['name']; ?></a></li>
        <?php
        endforeach;
        ?>
        </ul>
    </div>
</aside>