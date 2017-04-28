
		<section id="main" class="visible-xs-inline hidden-sm hidden-md hidden-lg">
			<!-- crumbs -->
			<div class="container">
				<div class="crumbs">
					<div>
						<a href="<?php echo LANGPATH; ?>/">ACCUEIL</a> > CENTRE D'AIDE
					</div>
				</div>
			</div>
			<!-- main-middle begin -->
			<div class="container">
				<div class="row">
<aside id="aside" class="col-xs-12">
    <div class="category-box-mobile">
        <h3 class="bg">NIVEAU VIP & PRIVILÈGE</h3>
        <ul class="scroll-list-mobile">
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
            array('name' => 'Avis de Choies', 'link' => '/important-notice'),
        );
        foreach($links as $link):
        ?>
            <li><a rel="nofollow" href="<?php echo LANGPATH; ?><?php echo $link['link']; ?>" <?php if($url == $link['link']) echo 'class="on"'; ?>><?php echo $link['name']; ?></a></li>
        <?php
        endforeach;
        ?>
        </ul>
    </div>
</aside>
						
							</div>
			</div>
			</section>
