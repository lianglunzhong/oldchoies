<aside id="aside" class="fll">
    <div class="category_box aside_box">
        <h3 class="bg">CENTRE D'AIDE</h3>
        <ul class="scroll_list">
        <?php
        $url = URL::current(0);
        $links = array(
            array('name' => 'À propos de nous', 'link' => '/about-us'),
            array('name' => 'Contactez-nous', 'link' => '/contact-us'),
            array('name' => 'Expédition & Livraison', 'link' => '/shipping-delivery'),
            array('name' => 'Retour & Changemnt', 'link' => '/returns-exchange'),
            array('name' => 'Confidentialité & Sécurité', 'link' => '/privacy-security'),
            array('name' => 'Guide des tailles', 'link' => '/size-guide'),
            array('name' => 'Paiement', 'link' => '/payment'),
            array('name' => 'Politique de VIP', 'link' => '/vip-policy'),
            array('name' => 'FAQs', 'link' => '/faqs'),
            array('name' => 'Vente en gros', 'link' => '/wholesale'),
            array('name' => 'Programme d\'Affiliation', 'link' => '/affiliate-program'),
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