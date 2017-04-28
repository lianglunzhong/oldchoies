
		<section id="main" class="visible-xs-inline hidden-sm hidden-md hidden-lg">
			<!-- crumbs -->
			<div class="container">
				<div class="crumbs">
					<div>
						<a href="<?php echo LANGPATH; ?>/">HOMEPAGE</a> > help center
					</div>
				</div>
			</div>
			<!-- main-middle begin -->
			<div class="container">
				<div class="row">
<aside id="aside" class="col-xs-12">
    <div class="category-box-mobile">
        <h3 class="bg">HELP CENTER</h3>
        <ul class="scroll-list-mobile">
        <?php
        $url = URL::current(0);
        $links = array(
array('name' => 'Über uns', 'link' => '/about-us'),
array('name' => 'Kontakt', 'link' => '/contact-us'),
array('name' => 'Versand & Lieferung', 'link' => '/shipping-delivery'),
array('name' => 'Rückgabe & Umtausch', 'link' => '/returns-exchange'),
array('name' => 'Privatsphäre & Sicherheit', 'link' => '/privacy-security'),
array('name' => 'Größetabelle', 'link' => '/size-guide'),
array('name' => 'Bezahlung', 'link' => '/payment'),
array('name' => 'VIP Politik', 'link' => '/vip-policy'),
array('name' => 'FAQs', 'link' => '/faqs'),
array('name' => 'Großhandel', 'link' => '/wholesale'),
array('name' => 'Partnerprogramm', 'link' => '/affiliate-program'),
array('name' => 'Choies Hinweise ', 'link' => '/important-notice'),
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
