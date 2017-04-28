<style>
    .lp_icecream{ position:relative;}
    .lp_icecream img{ display:block; border:0 none;}
    .lp_icecream .banner button{ top:125px;}
    .lp_icecream .tit{ height:32px; line-height:32px; padding-right:15px; margin-bottom:15px;}
    .lp_icecream .t1{ background:url(/images/activity/ht-1.jpg) no-repeat;}
    .lp_icecream .t2{ background:url(/images/activity/ht-2.jpg) no-repeat;}
    .lp_icecream .t3{ background:url(/images/activity/ht-3.jpg) no-repeat;}
    .lp_icecream .t4{ background:url(/images/activity/ht-4.jpg) no-repeat;}
    .lp_icecream .t5{ background:url(/images/activity/ht-5.jpg) no-repeat;}
    .lp_icecream .t6{ background:url(/images/activity/ht-6.jpg) no-repeat;}
    .lp_icecream .t7{ background:url(/images/activity/ht-7.jpg) no-repeat;}
    .lp_icecream .t8{ background:url(/images/activity/ht-8.jpg) no-repeat;}
    .lp_icecream .tit .view_morebtn{ margin:0;}

    .lp_icecream .flv_product_details_nav{ top:275px;}
    .lp_icecream .flv_product_details_nav li{ margin-bottom:5px; cursor:pointer;}
    .lp_icecream .flv_product_details_nav li:hover,.lp_icecream .flv_product_details_nav li.current{ filter: alpha(opacity=40); opacity: 0.4;}
</style>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  Jewelry Clearance</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <section class="layout fix">
        <section id="container" class="flr">
            <div class="lp_icecream">
                <!-- banner805 -->
                <div class="banner" id="banner">
                    <div class="ibanner layout" style="height:300px;">
                        <ul class="bannerPic" style="height:300px;">
                            <!--<li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/activity/805-300-1.jpg" alt="" /></a></li>-->
                            <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/activity/805-300-2.jpg" alt="" /></a></li>
                            <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/activity/805-300-3.jpg" alt="" /></a></li>
                            <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/activity/805-300-4.jpg" alt="" /></a></li>
                            <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/activity/805-300-5.jpg" alt="" /></a></li>
                            <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/activity/805-300-6.jpg" alt="" /></a></li>
                        </ul>
                        <div class="banner_lr">
                            <button class="previous prev1"></button>
                            <button class="next next1"></button>
                        </div>
                    </div>
                </div>

                <div class="scroll_list">
                    <div class="tit t1 fix" id="d1">
                        <a class="view_morebtn JS_view_morebtn flr">View more</a>
                    </div>
                    <div class="pro_listcon">
                        <ul class="fix">
                            <?php
                            $catalog = 399;
                            $products = DB::query(Database::SELECT, 'SELECT p.id, p.stock, p.sku, p.name, p.link, p.price 
                                FROM products_product p LEFT JOIN products_categoryproduct c ON p.id = c.product_id 
                                WHERE c.category_id = ' . $catalog . ' AND p.status = 1 AND p.visibility = 1 AND p.stock <> 0 ORDER BY c.position DESC')
                                ->execute()->as_array();
                            for ($i = 0; $i < 4; $i++)
                            {
                                $pdetail = $products[$i];
                                $outstock = 0;
                                if ($pdetail['stock'] == -1)
                                {
                                    $stocks = DB::select()
                                        ->from('products_stocks')
                                        ->where('product_id', '=', $pdetail['id'])
                                        ->where('stocks', '<>', 0)
                                        ->execute();
                                    $has = 0;
                                    foreach ($stocks as $stock)
                                    {
                                        if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                        {
                                            $has = 1;
                                            break;
                                        }
                                    }
                                    if (!$has)
                                        $outstock = 1;
                                }
                                ?>
                                <li>
                                    <a href="/product/<?php echo $pdetail['link']; ?>"><img src="<?php echo image::link(Product::instance($pdetail['id'])->cover_image(), 1); ?>" /></a>
                                    <a href="/product/<?php echo $pdetail['link']; ?>" class="name"><?php echo $pdetail['name']; ?></a>

                                    <?php
                                    $price = Product::instance($pdetail['id'])->price();
                                    if ($price < $pdetail['price'])
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                            <del><?php echo Site::instance()->price($pdetail['price'], 'code_view'); ?></del>
                                        </p>
                                        <span class="icon_sale"></span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($outstock)
                                    {
                                        ?>
                                        <span class="outstock">out of stock</span>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="pro_listcon view_morecon">
                        <ul class="fix">
                            <?php
                            for ($i = 4; $i <= count($products) - 1; $i++)
                            {
                                $pdetail = $products[$i];
                                $outstock = 0;
                                if ($pdetail['stock'] == -1)
                                {
                                    $stocks = DB::select()
                                        ->from('products_stocks')
                                        ->where('product_id', '=', $pdetail['id'])
                                        ->where('stocks', '<>', 0)
                                        ->execute();
                                    $has = 0;
                                    foreach ($stocks as $stock)
                                    {
                                        if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                        {
                                            $has = 1;
                                            break;
                                        }
                                    }
                                    if (!$has)
                                        $outstock = 1;
                                }
                                ?>
                                <li>
                                    <a href="/product/<?php echo $pdetail['link']; ?>"><img src="<?php echo image::link(Product::instance($pdetail['id'])->cover_image(), 1); ?>" /></a>
                                    <a href="/product/<?php echo $pdetail['link']; ?>" class="name"><?php echo $pdetail['name']; ?></a>

                                    <?php
                                    $price = Product::instance($pdetail['id'])->price();
                                    if ($price < $pdetail['price'])
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                            <del><?php echo Site::instance()->price($pdetail['price'], 'code_view'); ?></del>
                                        </p>
                                        <span class="icon_sale"></span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($outstock)
                                    {
                                        ?>
                                        <span class="outstock">out of stock</span>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="scroll_list">
                    <div class="tit t2 fix" id="d2"><a class="view_morebtn JS_view_morebtn flr">View more</a></div>
                    <div class="pro_listcon">
                        <ul class="fix">
                            <?php
                            $catalog = 400;
                            $products = DB::query(Database::SELECT, 'SELECT p.id, p.stock, p.sku, p.name, p.link, p.price 
                                FROM products_product p LEFT JOIN products_categoryproduct c ON p.id = c.product_id 
                                WHERE c.category_id = ' . $catalog . ' AND p.status = 1 AND p.visibility = 1 AND p.stock <> 0 ORDER BY c.position DESC')
                                ->execute()->as_array();
                            for ($i = 0; $i < 4; $i++)
                            {
                                $pdetail = $products[$i];
                                $outstock = 0;
                                if ($pdetail['stock'] == -1)
                                {
                                    $stocks = DB::select()
                                        ->from('products_stocks')
                                        ->where('product_id', '=', $pdetail['id'])
                                        ->where('stocks', '<>', 0)
                                        ->execute();
                                    $has = 0;
                                    foreach ($stocks as $stock)
                                    {
                                        if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                        {
                                            $has = 1;
                                            break;
                                        }
                                    }
                                    if (!$has)
                                        $outstock = 1;
                                }
                                ?>
                                <li>
                                    <a href="/product/<?php echo $pdetail['link']; ?>"><img src="<?php echo image::link(Product::instance($pdetail['id'])->cover_image(), 1); ?>" /></a>
                                    <a href="/product/<?php echo $pdetail['link']; ?>" class="name"><?php echo $pdetail['name']; ?></a>

                                    <?php
                                    $price = Product::instance($pdetail['id'])->price();
                                    if ($price < $pdetail['price'])
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                            <del><?php echo Site::instance()->price($pdetail['price'], 'code_view'); ?></del>
                                        </p>
                                        <span class="icon_sale"></span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($outstock)
                                    {
                                        ?>
                                        <span class="outstock">out of stock</span>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="pro_listcon view_morecon">
                        <ul class="fix">
                            <?php
                            for ($i = 4; $i <= count($products) - 1; $i++)
                            {
                                $pdetail = $products[$i];
                                $outstock = 0;
                                if ($pdetail['stock'] == -1)
                                {
                                    $stocks = DB::select()
                                        ->from('products_stocks')
                                        ->where('product_id', '=', $pdetail['id'])
                                        ->where('stocks', '<>', 0)
                                        ->execute();
                                    $has = 0;
                                    foreach ($stocks as $stock)
                                    {
                                        if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                        {
                                            $has = 1;
                                            break;
                                        }
                                    }
                                    if (!$has)
                                        $outstock = 1;
                                }
                                ?>
                                <li>
                                    <a href="/product/<?php echo $pdetail['link']; ?>"><img src="<?php echo image::link(Product::instance($pdetail['id'])->cover_image(), 1); ?>" /></a>
                                    <a href="/product/<?php echo $pdetail['link']; ?>" class="name"><?php echo $pdetail['name']; ?></a>

                                    <?php
                                    $price = Product::instance($pdetail['id'])->price();
                                    if ($price < $pdetail['price'])
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                            <del><?php echo Site::instance()->price($pdetail['price'], 'code_view'); ?></del>
                                        </p>
                                        <span class="icon_sale"></span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($outstock)
                                    {
                                        ?>
                                        <span class="outstock">out of stock</span>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>  

                <div class="scroll_list">
                    <div class="tit t3 fix" id="d3"><a class="view_morebtn JS_view_morebtn flr">View more</a></div>
                    <div class="pro_listcon">
                        <ul class="fix">
                            <?php
                            $catalog = 401;
                            $products = DB::query(Database::SELECT, 'SELECT p.id, p.stock, p.sku, p.name, p.link, p.price 
                                FROM products_product p LEFT JOIN products_categoryproduct c ON p.id = c.product_id 
                                WHERE c.category_id = ' . $catalog . ' AND p.status = 1 AND p.visibility = 1 AND p.stock <> 0 ORDER BY c.position DESC')
                                ->execute()->as_array();
                            for ($i = 0; $i < 4; $i++)
                            {
                                $pdetail = $products[$i];
                                $outstock = 0;
                                if ($pdetail['stock'] == -1)
                                {
                                    $stocks = DB::select()
                                        ->from('products_stocks')
                                        ->where('product_id', '=', $pdetail['id'])
                                        ->where('stocks', '<>', 0)
                                        ->execute();
                                    $has = 0;
                                    foreach ($stocks as $stock)
                                    {
                                        if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                        {
                                            $has = 1;
                                            break;
                                        }
                                    }
                                    if (!$has)
                                        $outstock = 1;
                                }
                                ?>
                                <li>
                                    <a href="/product/<?php echo $pdetail['link']; ?>"><img src="<?php echo image::link(Product::instance($pdetail['id'])->cover_image(), 1); ?>" /></a>
                                    <a href="/product/<?php echo $pdetail['link']; ?>" class="name"><?php echo $pdetail['name']; ?></a>

                                    <?php
                                    $price = Product::instance($pdetail['id'])->price();
                                    if ($price < $pdetail['price'])
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                            <del><?php echo Site::instance()->price($pdetail['price'], 'code_view'); ?></del>
                                        </p>
                                        <span class="icon_sale"></span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($outstock)
                                    {
                                        ?>
                                        <span class="outstock">out of stock</span>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="pro_listcon view_morecon">
                        <ul class="fix">
                            <?php
                            for ($i = 4; $i <= count($products) - 1; $i++)
                            {
                                $pdetail = $products[$i];
                                $outstock = 0;
                                if ($pdetail['stock'] == -1)
                                {
                                    $stocks = DB::select()
                                        ->from('products_stocks')
                                        ->where('product_id', '=', $pdetail['id'])
                                        ->where('stocks', '<>', 0)
                                        ->execute();
                                    $has = 0;
                                    foreach ($stocks as $stock)
                                    {
                                        if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                        {
                                            $has = 1;
                                            break;
                                        }
                                    }
                                    if (!$has)
                                        $outstock = 1;
                                }
                                ?>
                                <li>
                                    <a href="/product/<?php echo $pdetail['link']; ?>"><img src="<?php echo image::link(Product::instance($pdetail['id'])->cover_image(), 1); ?>" /></a>
                                    <a href="/product/<?php echo $pdetail['link']; ?>" class="name"><?php echo $pdetail['name']; ?></a>

                                    <?php
                                    $price = Product::instance($pdetail['id'])->price();
                                    if ($price < $pdetail['price'])
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                            <del><?php echo Site::instance()->price($pdetail['price'], 'code_view'); ?></del>
                                        </p>
                                        <span class="icon_sale"></span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($outstock)
                                    {
                                        ?>
                                        <span class="outstock">out of stock</span>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="scroll_list">
                    <div class="tit t4 fix" id="d4"><a class="view_morebtn JS_view_morebtn flr">View more</a></div>
                    <div class="pro_listcon">
                        <ul class="fix">
                            <?php
                            $catalog = 402;
                            $products = DB::query(Database::SELECT, 'SELECT p.id, p.stock, p.sku, p.name, p.link, p.price 
                                FROM products_product p LEFT JOIN products_categoryproduct c ON p.id = c.product_id 
                                WHERE c.category_id = ' . $catalog . ' AND p.status = 1 AND p.visibility = 1 AND p.stock <> 0 ORDER BY c.position DESC')
                                ->execute()->as_array();
                            for ($i = 0; $i < 4; $i++)
                            {
                                $pdetail = $products[$i];
                                $outstock = 0;
                                if ($pdetail['stock'] == -1)
                                {
                                    $stocks = DB::select()
                                        ->from('products_stocks')
                                        ->where('product_id', '=', $pdetail['id'])
                                        ->where('stocks', '<>', 0)
                                        ->execute();
                                    $has = 0;
                                    foreach ($stocks as $stock)
                                    {
                                        if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                        {
                                            $has = 1;
                                            break;
                                        }
                                    }
                                    if (!$has)
                                        $outstock = 1;
                                }
                                ?>
                                <li>
                                    <a href="/product/<?php echo $pdetail['link']; ?>"><img src="<?php echo image::link(Product::instance($pdetail['id'])->cover_image(), 1); ?>" /></a>
                                    <a href="/product/<?php echo $pdetail['link']; ?>" class="name"><?php echo $pdetail['name']; ?></a>

                                    <?php
                                    $price = Product::instance($pdetail['id'])->price();
                                    if ($price < $pdetail['price'])
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                            <del><?php echo Site::instance()->price($pdetail['price'], 'code_view'); ?></del>
                                        </p>
                                        <span class="icon_sale"></span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($outstock)
                                    {
                                        ?>
                                        <span class="outstock">out of stock</span>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="pro_listcon view_morecon">
                        <ul class="fix">
                            <?php
                            for ($i = 4; $i <= count($products) - 1; $i++)
                            {
                                $pdetail = $products[$i];
                                $outstock = 0;
                                if ($pdetail['stock'] == -1)
                                {
                                    $stocks = DB::select()
                                        ->from('products_stocks')
                                        ->where('product_id', '=', $pdetail['id'])
                                        ->where('stocks', '<>', 0)
                                        ->execute();
                                    $has = 0;
                                    foreach ($stocks as $stock)
                                    {
                                        if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                        {
                                            $has = 1;
                                            break;
                                        }
                                    }
                                    if (!$has)
                                        $outstock = 1;
                                }
                                ?>
                                <li>
                                    <a href="/product/<?php echo $pdetail['link']; ?>"><img src="<?php echo image::link(Product::instance($pdetail['id'])->cover_image(), 1); ?>" /></a>
                                    <a href="/product/<?php echo $pdetail['link']; ?>" class="name"><?php echo $pdetail['name']; ?></a>

                                    <?php
                                    $price = Product::instance($pdetail['id'])->price();
                                    if ($price < $pdetail['price'])
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                            <del><?php echo Site::instance()->price($pdetail['price'], 'code_view'); ?></del>
                                        </p>
                                        <span class="icon_sale"></span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($outstock)
                                    {
                                        ?>
                                        <span class="outstock">out of stock</span>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="scroll_list">
                    <div class="tit t5 fix" id="d5"><a class="view_morebtn JS_view_morebtn flr">View more</a></div>
                    <div class="pro_listcon">
                        <ul class="fix">
                            <?php
                            $catalog = 403;
                            $products = DB::query(Database::SELECT, 'SELECT p.id, p.stock, p.sku, p.name, p.link, p.price 
                                FROM products_product p LEFT JOIN products_categoryproduct c ON p.id = c.product_id 
                                WHERE c.category_id = ' . $catalog . ' AND p.status = 1 AND p.visibility = 1 AND p.stock <> 0 ORDER BY c.position DESC')
                                ->execute()->as_array();
                            for ($i = 0; $i < 4; $i++)
                            {
                                $pdetail = $products[$i];
                                $outstock = 0;
                                if ($pdetail['stock'] == -1)
                                {
                                    $stocks = DB::select()
                                        ->from('products_stocks')
                                        ->where('product_id', '=', $pdetail['id'])
                                        ->where('stocks', '<>', 0)
                                        ->execute();
                                    $has = 0;
                                    foreach ($stocks as $stock)
                                    {
                                        if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                        {
                                            $has = 1;
                                            break;
                                        }
                                    }
                                    if (!$has)
                                        $outstock = 1;
                                }
                                ?>
                                <li>
                                    <a href="/product/<?php echo $pdetail['link']; ?>"><img src="<?php echo image::link(Product::instance($pdetail['id'])->cover_image(), 1); ?>" /></a>
                                    <a href="/product/<?php echo $pdetail['link']; ?>" class="name"><?php echo $pdetail['name']; ?></a>

                                    <?php
                                    $price = Product::instance($pdetail['id'])->price();
                                    if ($price < $pdetail['price'])
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                            <del><?php echo Site::instance()->price($pdetail['price'], 'code_view'); ?></del>
                                        </p>
                                        <span class="icon_sale"></span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($outstock)
                                    {
                                        ?>
                                        <span class="outstock">out of stock</span>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="pro_listcon view_morecon">
                        <ul class="fix">
                            <?php
                            for ($i = 4; $i <= count($products) - 1; $i++)
                            {
                                $pdetail = $products[$i];
                                $outstock = 0;
                                if ($pdetail['stock'] == -1)
                                {
                                    $stocks = DB::select()
                                        ->from('products_stocks')
                                        ->where('product_id', '=', $pdetail['id'])
                                        ->where('stocks', '<>', 0)
                                        ->execute();
                                    $has = 0;
                                    foreach ($stocks as $stock)
                                    {
                                        if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                        {
                                            $has = 1;
                                            break;
                                        }
                                    }
                                    if (!$has)
                                        $outstock = 1;
                                }
                                ?>
                                <li>
                                    <a href="/product/<?php echo $pdetail['link']; ?>"><img src="<?php echo image::link(Product::instance($pdetail['id'])->cover_image(), 1); ?>" /></a>
                                    <a href="/product/<?php echo $pdetail['link']; ?>" class="name"><?php echo $pdetail['name']; ?></a>

                                    <?php
                                    $price = Product::instance($pdetail['id'])->price();
                                    if ($price < $pdetail['price'])
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                            <del><?php echo Site::instance()->price($pdetail['price'], 'code_view'); ?></del>
                                        </p>
                                        <span class="icon_sale"></span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($outstock)
                                    {
                                        ?>
                                        <span class="outstock">out of stock</span>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="scroll_list">
                    <div class="tit t6 fix" id="d6"><a class="view_morebtn JS_view_morebtn flr">View more</a></div>
                    <div class="pro_listcon">
                        <ul class="fix">
                            <?php
                            $catalog = 404;
                            $products = DB::query(Database::SELECT, 'SELECT p.id, p.stock, p.sku, p.name, p.link, p.price 
                                FROM products_product p LEFT JOIN products_categoryproduct c ON p.id = c.product_id 
                                WHERE c.category_id = ' . $catalog . ' AND p.status = 1 AND p.visibility = 1 AND p.stock <> 0 ORDER BY c.position DESC')
                                ->execute()->as_array();
                            for ($i = 0; $i < 4; $i++)
                            {
                                $pdetail = $products[$i];
                                $outstock = 0;
                                if ($pdetail['stock'] == -1)
                                {
                                    $stocks = DB::select()
                                        ->from('products_stocks')
                                        ->where('product_id', '=', $pdetail['id'])
                                        ->where('stocks', '<>', 0)
                                        ->execute();
                                    $has = 0;
                                    foreach ($stocks as $stock)
                                    {
                                        if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                        {
                                            $has = 1;
                                            break;
                                        }
                                    }
                                    if (!$has)
                                        $outstock = 1;
                                }
                                ?>
                                <li>
                                    <a href="/product/<?php echo $pdetail['link']; ?>"><img src="<?php echo image::link(Product::instance($pdetail['id'])->cover_image(), 1); ?>" /></a>
                                    <a href="/product/<?php echo $pdetail['link']; ?>" class="name"><?php echo $pdetail['name']; ?></a>

                                    <?php
                                    $price = Product::instance($pdetail['id'])->price();
                                    if ($price < $pdetail['price'])
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                            <del><?php echo Site::instance()->price($pdetail['price'], 'code_view'); ?></del>
                                        </p>
                                        <span class="icon_sale"></span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($outstock)
                                    {
                                        ?>
                                        <span class="outstock">out of stock</span>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="pro_listcon view_morecon">
                        <ul class="fix">
                            <?php
                            for ($i = 4; $i <= count($products) - 1; $i++)
                            {
                                $pdetail = $products[$i];
                                $outstock = 0;
                                if ($pdetail['stock'] == -1)
                                {
                                    $stocks = DB::select()
                                        ->from('products_stocks')
                                        ->where('product_id', '=', $pdetail['id'])
                                        ->where('stocks', '<>', 0)
                                        ->execute();
                                    $has = 0;
                                    foreach ($stocks as $stock)
                                    {
                                        if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                        {
                                            $has = 1;
                                            break;
                                        }
                                    }
                                    if (!$has)
                                        $outstock = 1;
                                }
                                ?>
                                <li>
                                    <a href="/product/<?php echo $pdetail['link']; ?>"><img src="<?php echo image::link(Product::instance($pdetail['id'])->cover_image(), 1); ?>" /></a>
                                    <a href="/product/<?php echo $pdetail['link']; ?>" class="name"><?php echo $pdetail['name']; ?></a>

                                    <?php
                                    $price = Product::instance($pdetail['id'])->price();
                                    if ($price < $pdetail['price'])
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                            <del><?php echo Site::instance()->price($pdetail['price'], 'code_view'); ?></del>
                                        </p>
                                        <span class="icon_sale"></span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($outstock)
                                    {
                                        ?>
                                        <span class="outstock">out of stock</span>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="scroll_list">
                    <div class="tit t7 fix" id="d7"><a class="view_morebtn JS_view_morebtn flr">View more</a></div>
                    <div class="pro_listcon">
                        <ul class="fix">
                            <?php
                            $catalog = 405;
                            $products = DB::query(Database::SELECT, 'SELECT p.id, p.stock, p.sku, p.name, p.link, p.price 
                                FROM products_product p LEFT JOIN products_categoryproduct c ON p.id = c.product_id 
                                WHERE c.category_id = ' . $catalog . ' AND p.status = 1 AND p.visibility = 1 AND p.stock <> 0 ORDER BY c.position DESC')
                                ->execute()->as_array();
                            for ($i = 0; $i < 4; $i++)
                            {
                                $pdetail = $products[$i];
                                $outstock = 0;
                                if ($pdetail['stock'] == -1)
                                {
                                    $stocks = DB::select()
                                        ->from('products_stocks')
                                        ->where('product_id', '=', $pdetail['id'])
                                        ->where('stocks', '<>', 0)
                                        ->execute();
                                    $has = 0;
                                    foreach ($stocks as $stock)
                                    {
                                        if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                        {
                                            $has = 1;
                                            break;
                                        }
                                    }
                                    if (!$has)
                                        $outstock = 1;
                                }
                                ?>
                                <li>
                                    <a href="/product/<?php echo $pdetail['link']; ?>"><img src="<?php echo image::link(Product::instance($pdetail['id'])->cover_image(), 1); ?>" /></a>
                                    <a href="/product/<?php echo $pdetail['link']; ?>" class="name"><?php echo $pdetail['name']; ?></a>

                                    <?php
                                    $price = Product::instance($pdetail['id'])->price();
                                    if ($price < $pdetail['price'])
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                            <del><?php echo Site::instance()->price($pdetail['price'], 'code_view'); ?></del>
                                        </p>
                                        <span class="icon_sale"></span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($outstock)
                                    {
                                        ?>
                                        <span class="outstock">out of stock</span>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="pro_listcon view_morecon">
                        <ul class="fix">
                            <?php
                            for ($i = 4; $i <= count($products) - 1; $i++)
                            {
                                $pdetail = $products[$i];
                                $outstock = 0;
                                if ($pdetail['stock'] == -1)
                                {
                                    $stocks = DB::select()
                                        ->from('products_stocks')
                                        ->where('product_id', '=', $pdetail['id'])
                                        ->where('stocks', '<>', 0)
                                        ->execute();
                                    $has = 0;
                                    foreach ($stocks as $stock)
                                    {
                                        if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                        {
                                            $has = 1;
                                            break;
                                        }
                                    }
                                    if (!$has)
                                        $outstock = 1;
                                }
                                ?>
                                <li>
                                    <a href="/product/<?php echo $pdetail['link']; ?>"><img src="<?php echo image::link(Product::instance($pdetail['id'])->cover_image(), 1); ?>" /></a>
                                    <a href="/product/<?php echo $pdetail['link']; ?>" class="name"><?php echo $pdetail['name']; ?></a>

                                    <?php
                                    $price = Product::instance($pdetail['id'])->price();
                                    if ($price < $pdetail['price'])
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                            <del><?php echo Site::instance()->price($pdetail['price'], 'code_view'); ?></del>
                                        </p>
                                        <span class="icon_sale"></span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($outstock)
                                    {
                                        ?>
                                        <span class="outstock">out of stock</span>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="scroll_list">
                    <div class="tit t8 fix" id="d8"><a class="view_morebtn JS_view_morebtn flr">View more</a></div>
                    <div class="pro_listcon">
                        <ul class="fix">
                            <?php
                            $catalog = 406;
                            $products = DB::query(Database::SELECT, 'SELECT p.id, p.stock, p.sku, p.name, p.link, p.price 
                                FROM products_product p LEFT JOIN products_categoryproduct c ON p.id = c.product_id 
                                WHERE c.category_id = ' . $catalog . ' AND p.status = 1 AND p.visibility = 1 AND p.stock <> 0 ORDER BY c.position DESC')
                                ->execute()->as_array();
                            for ($i = 0; $i < 4; $i++)
                            {
                                $pdetail = $products[$i];
                                $outstock = 0;
                                if ($pdetail['stock'] == -1)
                                {
                                    $stocks = DB::select()
                                        ->from('products_stocks')
                                        ->where('product_id', '=', $pdetail['id'])
                                        ->where('stocks', '<>', 0)
                                        ->execute();
                                    $has = 0;
                                    foreach ($stocks as $stock)
                                    {
                                        if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                        {
                                            $has = 1;
                                            break;
                                        }
                                    }
                                    if (!$has)
                                        $outstock = 1;
                                }
                                ?>
                                <li>
                                    <a href="/product/<?php echo $pdetail['link']; ?>"><img src="<?php echo image::link(Product::instance($pdetail['id'])->cover_image(), 1); ?>" /></a>
                                    <a href="/product/<?php echo $pdetail['link']; ?>" class="name"><?php echo $pdetail['name']; ?></a>

                                    <?php
                                    $price = Product::instance($pdetail['id'])->price();
                                    if ($price < $pdetail['price'])
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                            <del><?php echo Site::instance()->price($pdetail['price'], 'code_view'); ?></del>
                                        </p>
                                        <span class="icon_sale"></span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($outstock)
                                    {
                                        ?>
                                        <span class="outstock">out of stock</span>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="pro_listcon view_morecon">
                        <ul class="fix">
                            <?php
                            for ($i = 4; $i <= count($products) - 1; $i++)
                            {
                                $pdetail = $products[$i];
                                $outstock = 0;
                                if ($pdetail['stock'] == -1)
                                {
                                    $stocks = DB::select()
                                        ->from('products_stocks')
                                        ->where('product_id', '=', $pdetail['id'])
                                        ->where('stocks', '<>', 0)
                                        ->execute();
                                    $has = 0;
                                    foreach ($stocks as $stock)
                                    {
                                        if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                        {
                                            $has = 1;
                                            break;
                                        }
                                    }
                                    if (!$has)
                                        $outstock = 1;
                                }
                                ?>
                                <li>
                                    <a href="/product/<?php echo $pdetail['link']; ?>"><img src="<?php echo image::link(Product::instance($pdetail['id'])->cover_image(), 1); ?>" /></a>
                                    <a href="/product/<?php echo $pdetail['link']; ?>" class="name"><?php echo $pdetail['name']; ?></a>

                                    <?php
                                    $price = Product::instance($pdetail['id'])->price();
                                    if ($price < $pdetail['price'])
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                            <del><?php echo Site::instance()->price($pdetail['price'], 'code_view'); ?></del>
                                        </p>
                                        <span class="icon_sale"></span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p class="price fix">
                                            <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($outstock)
                                    {
                                        ?>
                                        <span class="outstock">out of stock</span>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <!-- flv_product_details_nav -->
                <ul class="flv_product_details_nav" style="position: fixed;top: 200px; right:135px;">
                    <li onclick="goto(1);"><img src="<?php echo STATICURL; ?>/ximg/activity/icecream_01.jpg" /></li>
                    <li onclick="goto(2);"><img src="<?php echo STATICURL; ?>/ximg/activity/icecream_02.jpg" /></li>
                    <li onclick="goto(3);"><img src="<?php echo STATICURL; ?>/ximg/activity/icecream_03.jpg" /></li>
                    <li onclick="goto(4);"><img src="<?php echo STATICURL; ?>/ximg/activity/icecream_04.jpg" /></li>
                    <li onclick="goto(5);"><img src="<?php echo STATICURL; ?>/ximg/activity/icecream_05.jpg" /></li>
                    <li onclick="goto(6);"><img src="<?php echo STATICURL; ?>/ximg/activity/icecream_06.jpg" /></li>
                    <li onclick="goto(7);"><img src="<?php echo STATICURL; ?>/ximg/activity/icecream_07.jpg" /></li>
                    <li onclick="goto(8);"><img src="<?php echo STATICURL; ?>/ximg/activity/icecream_08.jpg" /></li>
                </ul>
            </div>
        </section>
        <?php echo View::factory(LANGPATH . '/catalog_left'); ?>
    </section>
</section>
<script type="text/javascript">
    // JS_cart_side
    function goto(k){
        var id = "#d"+k;
        var obj = $(id).offset();
        var pos = obj.top - 70;
        var position = $(".JS_cart_side").css("position");
        if(position=="fixed"){
            pos = obj.top - 70; 
        }
        $("html,body").animate({scrollTop: pos}, 1000);
    };

    // flv_product_details_nav
    $('.flv_product_details_nav li').click(function(){
        $('.flv_product_details_nav li').removeClass("current");
        $(this).addClass("current");
        //return false;
    })

    // banner805 
    $(function(){
        $(".banner .bannerPic li").soChange({
            //thumbObj:".banner .bannerBtn li",
            botPrev:".banner .previous",
            botNext:".banner .next",
            botPrevslideTime:500,
            changeTime:5000,
            slideTime:500
        });
    });
</script>