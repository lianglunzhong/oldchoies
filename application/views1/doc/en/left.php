<aside id="aside" class="col-sm-3 hidden-xs">
    <div class="category-box aside_box">
        <h3 class="bg">HELP CENTER</h3>
        <ul class="scroll-list">
        <?php
        $url = URL::current(0);
        $links = array(
array('name' => 'About Us', 'link' => '/about-us'),
array('name' => 'Contact Us', 'link' => '/contact-us'),
array('name' => 'Shipping &amp; Delivery', 'link' => '/shipping-delivery'),
array('name' => 'Return &amp; Exchange', 'link' => '/returns-exchange'),
array('name' => 'Privacy &amp; Security', 'link' => '/privacy-security'),
array('name' => 'Size Guide', 'link' => '/size-guide'),
array('name' => 'Payment', 'link' => '/payment'),
array('name' => 'VIP Policy', 'link' => '/vip-policy'),
array('name' => 'FAQs', 'link' => '/faqs'),
array('name' => 'Wholesale', 'link' => '/wholesale'),
array('name' => 'Affiliate Program', 'link' => '/affiliate-program'),
array('name' => 'Choies Notice', 'link' => '/important-notice'),
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