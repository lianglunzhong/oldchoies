<aside id="aside" class="col-sm-3 hidden-xs">
    <div class="category-box aside_box">
        <h3 class="bg">HILFE ZENTRUM</h3>
        <ul class="scroll-list">
        <?php
        $url = URL::current(0);
        $links = array(
array('name' => 'Über uns', 'link' => '/about-us'),
array('name' => 'Kontakt', 'link' => '/contact-us'),
array('name' => 'Versand &amp; Lieferung', 'link' => '/shipping-delivery'),
array('name' => 'Rückgabe &amp; Umtausch', 'link' => '/returns-exchange'),
array('name' => 'Privatsphäre &amp; Sicherheit', 'link' => '/privacy-security'),
array('name' => 'Größetabelle', 'link' => '/size-guide'),
array('name' => 'Bezahlung', 'link' => '/payment'),
array('name' => 'VIP Politik', 'link' => '/vip-policy'),
array('name' => 'FAQs', 'link' => '/faqs'),
array('name' => 'Großhandel', 'link' => '/wholesale'),
array('name' => 'Partnerprogramm', 'link' => '/affiliate-program'),
array('name' => 'Choies Hinweise ', 'link' => '/important-notice'),
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