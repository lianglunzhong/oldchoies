<aside id="aside" class="fll">
    <div class="category_box aside_box">
        <h3 class="bg">Centro De Ayuda</h3>
        <ul class="scroll_list">
        <?php
        $url = URL::current(0);
        $links = array(
array('name' => 'Sobre Nosotros', 'link' => '/about-us'),
array('name' => 'Contáctenos', 'link' => '/contact-us'),
array('name' => 'Envío Y Entrega', 'link' => '/shipping-delivery'),
array('name' => 'Devolución Y Cambio', 'link' => '/returns-exchange'),
array('name' => 'Privacidad Y Seguridad', 'link' => '/privacy-security'),
array('name' => 'Guía De Talla', 'link' => '/size-guide'),
array('name' => 'Pago', 'link' => '/payment'),
array('name' => 'Política Vip', 'link' => '/vip-policy'),
array('name' => 'FAQ', 'link' => '/faqs'),
array('name' => 'Vender Al Por Mayor', 'link' => '/wholesale'),
array('name' => 'Programa De Afiliados', 'link' => '/affiliate-program'),
        );
        foreach($links as $link):
            $link['link'] = LANGPATH . $link['link'];
            ?>
            <li><a rel="nofollow" href="<?php echo $link['link']; ?>" <?php if($url == $link['link']) echo 'class="on"'; ?>><?php echo $link['name']; ?></a></li>
        <?php
        endforeach;
        ?>
        </ul>
    </div>
</aside>