<link type="text/css" rel="stylesheet" href="/css/quickview.css" media="all" />
<style>
    #container{ position:relative;}
    .croptops_nav{ position:fixed; top:182px; left:89%; z-index:100;}
    .croptops_nav a{ display:block; margin-bottom:12px;}
    .croptops_nav a:hover{ filter: alpha(opacity=40); opacity: 0.4;}
    #container .ibanner, #container .bannerPic{ height:302px;}
    .banner button{ top:110px;}
    .music_festival_tit{ height:35px; line-height:35px; padding:0 10px; color:#fff; text-transform:uppercase; background-color:#000;}
    .music_festival_tit h4{ float:left; font-size:18px; font-weight:normal; font-family:Tahoma, Geneva, sans-serif;}
    .music_festival_tit h4 img{ vertical-align:middle; margin:-2px 5px 0 0;}
    .music_festival_tit a{ float:right; color:#fff; text-decoration:none; margin:0;}
</style>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  Seasonal Picks</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <section class="layout fix">
        <section id="container" class="flr">
            <div class="croptops_nav">
                <a onclick="goto(1);"><img src="<?php echo STATICURL; ?>/ximg/activity/croptops_nav1.png" /></a>
                <a onclick="goto(2);"><img src="<?php echo STATICURL; ?>/ximg/activity/croptops_nav2.png" /></a>
                <a onclick="goto(3);"><img src="<?php echo STATICURL; ?>/ximg/activity/croptops_nav3.png" /></a>
                <a onclick="goto(4);"><img src="<?php echo STATICURL; ?>/ximg/activity/croptops_nav4.png" /></a>
            </div>
            <!-- banner805 -->
            <div class="banner" id="banner">
                <div class="ibanner">
                    <ul class="bannerPic">
                        <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/activity/croptops_banner2.jpg" alt="" /></a></li>
                        <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/activity/croptops_banner4.jpg" alt="" /></a></li>
                        <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/activity/croptops_banner3.jpg" alt="" /></a></li>
                        <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/activity/croptops_banner1.jpg" alt="" /></a></li>
                    </ul>
                    <div class="banner_lr">
                        <button class="previous prev1"></button>
                        <button class="next next1"></button>
                    </div>
                </div>
            </div>

            <div class="scroll_list">
                <div class="music_festival_tit tit1 fix mb25">
                    <h4 id="d1"><img src="<?php echo STATICURL; ?>/ximg/activity/croptop_tit1.png" />Crop tops</h4>
                    <a class="view_morebtn JS_view_morebtn">View more</a>
                </div>
                <div class="pro_listcon">
                    <ul class="fix">
                        <?php
                        $products = Catalog::instance($catalogs[0])->products();
                        for($i = 0;$i < 4;$i ++)
                        {
                            $product_id = $products[$i];
                            $product_inf = DB::select('type', 'name', 'price', 'has_pick', 'status', 'stock', 'display_date')
                                            ->from('products_product')
                                            ->where('id', '=', $product_id)
                                            ->execute()->current();
                            ?>
                            <li>
                                <a href="<?php echo Product::instance($product_id)->permalink(); ?>"><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 1); ?>" /></a>
                                <?php if ($product_inf['type'] != 0): ?>
                                    <a href="#" id="<?php echo $product_id; ?>" class="quick_view JS_shows1">Quick View</a>
                                <?php endif; ?>
                                <a href="<?php echo Product::instance($product_id)->permalink(); ?>" class="name"><?php echo $product_inf['name']; ?></a>
                                <p class="price fix">
                                    <?php
                                    $orig_price = round($product_inf['price'], 2);
                                    $price = round(Product::instance($product_id)->price(), 2);
                                    if ($orig_price > $price)
                                    {
                                        $off = round(($orig_price - $price) / $orig_price, 2) * 100;
                                        ?>
                                        <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>    <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del>
                                        <span class="off"><?php echo $off; ?>% off</span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class="now"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                        <?php
                                    }
                                    if ($product_inf['has_pick'] != 0)
                                    {
                                        ?>
                                        <span class="icon_pick"></span>
                                    <?php } ?>
                                </p>
                                <?php
                                $onsale = 1;
                                if ($product_inf['status'] == 0)
                                    $onsale = 0;
                                else
                                {
                                    if ($product_inf['stock'] == 0)
                                        $onsale = 0;
                                    elseif ($product_inf['stock'] == -1)
                                    {
                                        $stocks = DB::select(DB::expr('SUM(stocks) AS sum'))
                                                        ->from('products_stocks')
                                                        ->where('product_id', '=', $product_id)
                                                        ->where('attributes', '<>', '')
                                                        ->execute()->get('sum');
                                        if (!$stocks)
                                            $onsale = 0;
                                    }
                                }
                                if ($onsale == 0)
                                {
                                    echo '<span class="outstock">Sold Out</span>';
                                }
                                else
                                {
                                    $is_sale = round($product_inf['price'], 2) > Product::instance($product_id)->price() ? 1 : 0;
                                    $is_new = time() - $product_inf['display_date'] <= 86400 * 14 ? 1 : 0;
                                    if ($is_sale && $is_new)
                                    {
                                        echo '<span class="icon_sale1"></span><span class="icon_new"></span>';
                                    }
                                    elseif ($is_sale)
                                    {
                                        echo '<span class="icon_sale"></span>';
                                    }
                                    elseif ($is_new)
                                    {
                                        echo '<span class="icon_new"></span>';
                                    }
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
                    for($i = 4;$i < count($products);$i ++)
                    {
                        $product_id = $products[$i];
                            $product_inf = DB::select('type', 'name', 'price', 'has_pick', 'status', 'stock', 'display_date')
                                            ->from('products_product')
                                            ->where('id', '=', $product_id)
                                            ->execute()->current();
                            ?>
                            <li>
                                <a href="<?php echo Product::instance($product_id)->permalink(); ?>"><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 1); ?>" /></a>
                                <?php if ($product_inf['type'] != 0): ?>
                                    <a href="#" id="<?php echo $product_id; ?>" class="quick_view JS_shows1">Quick View</a>
                                <?php endif; ?>
                                <a href="<?php echo Product::instance($product_id)->permalink(); ?>" class="name"><?php echo $product_inf['name']; ?></a>
                                <p class="price fix">
                                    <?php
                                    $orig_price = round($product_inf['price'], 2);
                                    $price = round(Product::instance($product_id)->price(), 2);
                                    if ($orig_price > $price)
                                    {
                                        $off = round(($orig_price - $price) / $orig_price, 2) * 100;
                                        ?>
                                        <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>    <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del>
                                        <span class="off"><?php echo $off; ?>% off</span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class="now"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                        <?php
                                    }
                                    if ($product_inf['has_pick'] != 0)
                                    {
                                        ?>
                                        <span class="icon_pick"></span>
                                    <?php } ?>
                                </p>
                                <?php
                                $onsale = 1;
                                if ($product_inf['status'] == 0)
                                    $onsale = 0;
                                else
                                {
                                    if ($product_inf['stock'] == 0)
                                        $onsale = 0;
                                    elseif ($product_inf['stock'] == -1)
                                    {
                                        $stocks = DB::select(DB::expr('SUM(stocks) AS sum'))
                                                        ->from('products_stocks')
                                                        ->where('product_id', '=', $product_id)
                                                        ->where('attributes', '<>', '')
                                                        ->execute()->get('sum');
                                        if (!$stocks)
                                            $onsale = 0;
                                    }
                                }
                                if ($onsale == 0)
                                {
                                    echo '<span class="outstock">Sold Out</span>';
                                }
                                else
                                {
                                    $is_sale = round($product_inf['price'], 2) > Product::instance($product_id)->price() ? 1 : 0;
                                    $is_new = time() - $product_inf['display_date'] <= 86400 * 14 ? 1 : 0;
                                    if ($is_sale && $is_new)
                                    {
                                        echo '<span class="icon_sale1"></span><span class="icon_new"></span>';
                                    }
                                    elseif ($is_sale)
                                    {
                                        echo '<span class="icon_sale"></span>';
                                    }
                                    elseif ($is_new)
                                    {
                                        echo '<span class="icon_new"></span>';
                                    }
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
                <div class="music_festival_tit tit2 fix mb25">
                    <h4 id="d2"><img src="<?php echo STATICURL; ?>/ximg/activity/croptop_tit2.png" />Skirts</h4>
                    <a class="view_morebtn JS_view_morebtn">View more</a>
                </div>
                <div class="pro_listcon">
                    <ul class="fix">
                        <?php
                        $products = Catalog::instance($catalogs[1])->products();
                        for($i = 0;$i < 4;$i ++)
                        {
                            $product_id = $products[$i];
                            $product_inf = DB::select('type', 'name', 'price', 'has_pick', 'status', 'stock', 'display_date')
                                            ->from('products_product')
                                            ->where('id', '=', $product_id)
                                            ->execute()->current();
                            ?>
                            <li>
                                <a href="<?php echo Product::instance($product_id)->permalink(); ?>"><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 1); ?>" /></a>
                                <?php if ($product_inf['type'] != 0): ?>
                                    <a href="#" id="<?php echo $product_id; ?>" class="quick_view JS_shows1">Quick View</a>
                                <?php endif; ?>
                                <a href="<?php echo Product::instance($product_id)->permalink(); ?>" class="name"><?php echo $product_inf['name']; ?></a>
                                <p class="price fix">
                                    <?php
                                    $orig_price = round($product_inf['price'], 2);
                                    $price = round(Product::instance($product_id)->price(), 2);
                                    if ($orig_price > $price)
                                    {
                                        $off = round(($orig_price - $price) / $orig_price, 2) * 100;
                                        ?>
                                        <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>    <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del>
                                        <span class="off"><?php echo $off; ?>% off</span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class="now"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                        <?php
                                    }
                                    if ($product_inf['has_pick'] != 0)
                                    {
                                        ?>
                                        <span class="icon_pick"></span>
                                    <?php } ?>
                                </p>
                                <?php
                                $onsale = 1;
                                if ($product_inf['status'] == 0)
                                    $onsale = 0;
                                else
                                {
                                    if ($product_inf['stock'] == 0)
                                        $onsale = 0;
                                    elseif ($product_inf['stock'] == -1)
                                    {
                                        $stocks = DB::select(DB::expr('SUM(stocks) AS sum'))
                                                        ->from('products_stocks')
                                                        ->where('product_id', '=', $product_id)
                                                        ->where('attributes', '<>', '')
                                                        ->execute()->get('sum');
                                        if (!$stocks)
                                            $onsale = 0;
                                    }
                                }
                                if ($onsale == 0)
                                {
                                    echo '<span class="outstock">Sold Out</span>';
                                }
                                else
                                {
                                    $is_sale = round($product_inf['price'], 2) > Product::instance($product_id)->price() ? 1 : 0;
                                    $is_new = time() - $product_inf['display_date'] <= 86400 * 14 ? 1 : 0;
                                    if ($is_sale && $is_new)
                                    {
                                        echo '<span class="icon_sale1"></span><span class="icon_new"></span>';
                                    }
                                    elseif ($is_sale)
                                    {
                                        echo '<span class="icon_sale"></span>';
                                    }
                                    elseif ($is_new)
                                    {
                                        echo '<span class="icon_new"></span>';
                                    }
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
                    for($i = 4;$i < count($products);$i ++)
                    {
                        $product_id = $products[$i];
                            $product_inf = DB::select('type', 'name', 'price', 'has_pick', 'status', 'stock', 'display_date')
                                            ->from('products_product')
                                            ->where('id', '=', $product_id)
                                            ->execute()->current();
                            ?>
                            <li>
                                <a href="<?php echo Product::instance($product_id)->permalink(); ?>"><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 1); ?>" /></a>
                                <?php if ($product_inf['type'] != 0): ?>
                                    <a href="#" id="<?php echo $product_id; ?>" class="quick_view JS_shows1">Quick View</a>
                                <?php endif; ?>
                                <a href="<?php echo Product::instance($product_id)->permalink(); ?>" class="name"><?php echo $product_inf['name']; ?></a>
                                <p class="price fix">
                                    <?php
                                    $orig_price = round($product_inf['price'], 2);
                                    $price = round(Product::instance($product_id)->price(), 2);
                                    if ($orig_price > $price)
                                    {
                                        $off = round(($orig_price - $price) / $orig_price, 2) * 100;
                                        ?>
                                        <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>    <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del>
                                        <span class="off"><?php echo $off; ?>% off</span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class="now"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                        <?php
                                    }
                                    if ($product_inf['has_pick'] != 0)
                                    {
                                        ?>
                                        <span class="icon_pick"></span>
                                    <?php } ?>
                                </p>
                                <?php
                                $onsale = 1;
                                if ($product_inf['status'] == 0)
                                    $onsale = 0;
                                else
                                {
                                    if ($product_inf['stock'] == 0)
                                        $onsale = 0;
                                    elseif ($product_inf['stock'] == -1)
                                    {
                                        $stocks = DB::select(DB::expr('SUM(stocks) AS sum'))
                                                        ->from('products_stocks')
                                                        ->where('product_id', '=', $product_id)
                                                        ->where('attributes', '<>', '')
                                                        ->execute()->get('sum');
                                        if (!$stocks)
                                            $onsale = 0;
                                    }
                                }
                                if ($onsale == 0)
                                {
                                    echo '<span class="outstock">Sold Out</span>';
                                }
                                else
                                {
                                    $is_sale = round($product_inf['price'], 2) > Product::instance($product_id)->price() ? 1 : 0;
                                    $is_new = time() - $product_inf['display_date'] <= 86400 * 14 ? 1 : 0;
                                    if ($is_sale && $is_new)
                                    {
                                        echo '<span class="icon_sale1"></span><span class="icon_new"></span>';
                                    }
                                    elseif ($is_sale)
                                    {
                                        echo '<span class="icon_sale"></span>';
                                    }
                                    elseif ($is_new)
                                    {
                                        echo '<span class="icon_new"></span>';
                                    }
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
                <div class="music_festival_tit tit3 fix mb25">
                    <h4 id="d3"><img src="<?php echo STATICURL; ?>/ximg/activity/croptop_tit3.png" />T-shirts</h4>
                    <a class="view_morebtn JS_view_morebtn">View more</a>
                </div>
                <div class="pro_listcon">
                    <ul class="fix">
                        <?php
                        $products = Catalog::instance($catalogs[2])->products();
                        for($i = 0;$i < 4;$i ++)
                        {
                            $product_id = $products[$i];
                            $product_inf = DB::select('type', 'name', 'price', 'has_pick', 'status', 'stock', 'display_date')
                                            ->from('products_product')
                                            ->where('id', '=', $product_id)
                                            ->execute()->current();
                            ?>
                            <li>
                                <a href="<?php echo Product::instance($product_id)->permalink(); ?>"><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 1); ?>" /></a>
                                <?php if ($product_inf['type'] != 0): ?>
                                    <a href="#" id="<?php echo $product_id; ?>" class="quick_view JS_shows1">Quick View</a>
                                <?php endif; ?>
                                <a href="<?php echo Product::instance($product_id)->permalink(); ?>" class="name"><?php echo $product_inf['name']; ?></a>
                                <p class="price fix">
                                    <?php
                                    $orig_price = round($product_inf['price'], 2);
                                    $price = round(Product::instance($product_id)->price(), 2);
                                    if ($orig_price > $price)
                                    {
                                        $off = round(($orig_price - $price) / $orig_price, 2) * 100;
                                        ?>
                                        <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>    <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del>
                                        <span class="off"><?php echo $off; ?>% off</span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class="now"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                        <?php
                                    }
                                    if ($product_inf['has_pick'] != 0)
                                    {
                                        ?>
                                        <span class="icon_pick"></span>
                                    <?php } ?>
                                </p>
                                <?php
                                $onsale = 1;
                                if ($product_inf['status'] == 0)
                                    $onsale = 0;
                                else
                                {
                                    if ($product_inf['stock'] == 0)
                                        $onsale = 0;
                                    elseif ($product_inf['stock'] == -1)
                                    {
                                        $stocks = DB::select(DB::expr('SUM(stocks) AS sum'))
                                                        ->from('products_stocks')
                                                        ->where('product_id', '=', $product_id)
                                                        ->where('attributes', '<>', '')
                                                        ->execute()->get('sum');
                                        if (!$stocks)
                                            $onsale = 0;
                                    }
                                }
                                if ($onsale == 0)
                                {
                                    echo '<span class="outstock">Sold Out</span>';
                                }
                                else
                                {
                                    $is_sale = round($product_inf['price'], 2) > Product::instance($product_id)->price() ? 1 : 0;
                                    $is_new = time() - $product_inf['display_date'] <= 86400 * 14 ? 1 : 0;
                                    if ($is_sale && $is_new)
                                    {
                                        echo '<span class="icon_sale1"></span><span class="icon_new"></span>';
                                    }
                                    elseif ($is_sale)
                                    {
                                        echo '<span class="icon_sale"></span>';
                                    }
                                    elseif ($is_new)
                                    {
                                        echo '<span class="icon_new"></span>';
                                    }
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
                    for($i = 4;$i < count($products);$i ++)
                    {
                        $product_id = $products[$i];
                            $product_inf = DB::select('type', 'name', 'price', 'has_pick', 'status', 'stock', 'display_date')
                                            ->from('products_product')
                                            ->where('id', '=', $product_id)
                                            ->execute()->current();
                            ?>
                            <li>
                                <a href="<?php echo Product::instance($product_id)->permalink(); ?>"><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 1); ?>" /></a>
                                <?php if ($product_inf['type'] != 0): ?>
                                    <a href="#" id="<?php echo $product_id; ?>" class="quick_view JS_shows1">Quick View</a>
                                <?php endif; ?>
                                <a href="<?php echo Product::instance($product_id)->permalink(); ?>" class="name"><?php echo $product_inf['name']; ?></a>
                                <p class="price fix">
                                    <?php
                                    $orig_price = round($product_inf['price'], 2);
                                    $price = round(Product::instance($product_id)->price(), 2);
                                    if ($orig_price > $price)
                                    {
                                        $off = round(($orig_price - $price) / $orig_price, 2) * 100;
                                        ?>
                                        <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>    <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del>
                                        <span class="off"><?php echo $off; ?>% off</span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class="now"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                        <?php
                                    }
                                    if ($product_inf['has_pick'] != 0)
                                    {
                                        ?>
                                        <span class="icon_pick"></span>
                                    <?php } ?>
                                </p>
                                <?php
                                $onsale = 1;
                                if ($product_inf['status'] == 0)
                                    $onsale = 0;
                                else
                                {
                                    if ($product_inf['stock'] == 0)
                                        $onsale = 0;
                                    elseif ($product_inf['stock'] == -1)
                                    {
                                        $stocks = DB::select(DB::expr('SUM(stocks) AS sum'))
                                                        ->from('products_stocks')
                                                        ->where('product_id', '=', $product_id)
                                                        ->where('attributes', '<>', '')
                                                        ->execute()->get('sum');
                                        if (!$stocks)
                                            $onsale = 0;
                                    }
                                }
                                if ($onsale == 0)
                                {
                                    echo '<span class="outstock">Sold Out</span>';
                                }
                                else
                                {
                                    $is_sale = round($product_inf['price'], 2) > Product::instance($product_id)->price() ? 1 : 0;
                                    $is_new = time() - $product_inf['display_date'] <= 86400 * 14 ? 1 : 0;
                                    if ($is_sale && $is_new)
                                    {
                                        echo '<span class="icon_sale1"></span><span class="icon_new"></span>';
                                    }
                                    elseif ($is_sale)
                                    {
                                        echo '<span class="icon_sale"></span>';
                                    }
                                    elseif ($is_new)
                                    {
                                        echo '<span class="icon_new"></span>';
                                    }
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
                <div class="music_festival_tit tit4 fix mb25">
                    <h4 id="d4"><img src="<?php echo STATICURL; ?>/ximg/activity/croptop_tit4.png" />Shorts</h4>
                    <a class="view_morebtn JS_view_morebtn">View more</a>
                </div>
                <div class="pro_listcon">
                    <ul class="fix">
                        <?php
                        $products = Catalog::instance($catalogs[3])->products();
                        for($i = 0;$i < 4;$i ++)
                        {
                            $product_id = $products[$i];
                            $product_inf = DB::select('type', 'name', 'price', 'has_pick', 'status', 'stock', 'display_date')
                                            ->from('products_product')
                                            ->where('id', '=', $product_id)
                                            ->execute()->current();
                            ?>
                            <li>
                                <a href="<?php echo Product::instance($product_id)->permalink(); ?>"><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 1); ?>" /></a>
                                <?php if ($product_inf['type'] != 0): ?>
                                    <a href="#" id="<?php echo $product_id; ?>" class="quick_view JS_shows1">Quick View</a>
                                <?php endif; ?>
                                <a href="<?php echo Product::instance($product_id)->permalink(); ?>" class="name"><?php echo $product_inf['name']; ?></a>
                                <p class="price fix">
                                    <?php
                                    $orig_price = round($product_inf['price'], 2);
                                    $price = round(Product::instance($product_id)->price(), 2);
                                    if ($orig_price > $price)
                                    {
                                        $off = round(($orig_price - $price) / $orig_price, 2) * 100;
                                        ?>
                                        <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>    <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del>
                                        <span class="off"><?php echo $off; ?>% off</span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class="now"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                        <?php
                                    }
                                    if ($product_inf['has_pick'] != 0)
                                    {
                                        ?>
                                        <span class="icon_pick"></span>
                                    <?php } ?>
                                </p>
                                <?php
                                $onsale = 1;
                                if ($product_inf['status'] == 0)
                                    $onsale = 0;
                                else
                                {
                                    if ($product_inf['stock'] == 0)
                                        $onsale = 0;
                                    elseif ($product_inf['stock'] == -1)
                                    {
                                        $stocks = DB::select(DB::expr('SUM(stocks) AS sum'))
                                                        ->from('products_stocks')
                                                        ->where('product_id', '=', $product_id)
                                                        ->where('attributes', '<>', '')
                                                        ->execute()->get('sum');
                                        if (!$stocks)
                                            $onsale = 0;
                                    }
                                }
                                if ($onsale == 0)
                                {
                                    echo '<span class="outstock">Sold Out</span>';
                                }
                                else
                                {
                                    $is_sale = round($product_inf['price'], 2) > Product::instance($product_id)->price() ? 1 : 0;
                                    $is_new = time() - $product_inf['display_date'] <= 86400 * 14 ? 1 : 0;
                                    if ($is_sale && $is_new)
                                    {
                                        echo '<span class="icon_sale1"></span><span class="icon_new"></span>';
                                    }
                                    elseif ($is_sale)
                                    {
                                        echo '<span class="icon_sale"></span>';
                                    }
                                    elseif ($is_new)
                                    {
                                        echo '<span class="icon_new"></span>';
                                    }
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
                    for($i = 4;$i < count($products);$i ++)
                    {
                        $product_id = $products[$i];
                            $product_inf = DB::select('type', 'name', 'price', 'has_pick', 'status', 'stock', 'display_date')
                                            ->from('products_product')
                                            ->where('id', '=', $product_id)
                                            ->execute()->current();
                            ?>
                            <li>
                                <a href="<?php echo Product::instance($product_id)->permalink(); ?>"><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 1); ?>" /></a>
                                <?php if ($product_inf['type'] != 0): ?>
                                    <a href="#" id="<?php echo $product_id; ?>" class="quick_view JS_shows1">Quick View</a>
                                <?php endif; ?>
                                <a href="<?php echo Product::instance($product_id)->permalink(); ?>" class="name"><?php echo $product_inf['name']; ?></a>
                                <p class="price fix">
                                    <?php
                                    $orig_price = round($product_inf['price'], 2);
                                    $price = round(Product::instance($product_id)->price(), 2);
                                    if ($orig_price > $price)
                                    {
                                        $off = round(($orig_price - $price) / $orig_price, 2) * 100;
                                        ?>
                                        <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>    <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del>
                                        <span class="off"><?php echo $off; ?>% off</span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class="now"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                        <?php
                                    }
                                    if ($product_inf['has_pick'] != 0)
                                    {
                                        ?>
                                        <span class="icon_pick"></span>
                                    <?php } ?>
                                </p>
                                <?php
                                $onsale = 1;
                                if ($product_inf['status'] == 0)
                                    $onsale = 0;
                                else
                                {
                                    if ($product_inf['stock'] == 0)
                                        $onsale = 0;
                                    elseif ($product_inf['stock'] == -1)
                                    {
                                        $stocks = DB::select(DB::expr('SUM(stocks) AS sum'))
                                                        ->from('products_stocks')
                                                        ->where('product_id', '=', $product_id)
                                                        ->where('attributes', '<>', '')
                                                        ->execute()->get('sum');
                                        if (!$stocks)
                                            $onsale = 0;
                                    }
                                }
                                if ($onsale == 0)
                                {
                                    echo '<span class="outstock">Sold Out</span>';
                                }
                                else
                                {
                                    $is_sale = round($product_inf['price'], 2) > Product::instance($product_id)->price() ? 1 : 0;
                                    $is_new = time() - $product_inf['display_date'] <= 86400 * 14 ? 1 : 0;
                                    if ($is_sale && $is_new)
                                    {
                                        echo '<span class="icon_sale1"></span><span class="icon_new"></span>';
                                    }
                                    elseif ($is_sale)
                                    {
                                        echo '<span class="icon_sale"></span>';
                                    }
                                    elseif ($is_new)
                                    {
                                        echo '<span class="icon_new"></span>';
                                    }
                                }
                                ?>
                            </li>
                    <?php
                    }
                    ?>
                    </ul>
                </div>
            </div>
        </section>
        <?php echo View::factory(LANGPATH . '/catalog_left'); ?>
    </section>
</section>
<script type="text/javascript" src="/js/catalog.js"></script>
<script type="text/javascript" src="/js/catalog.loadthumb.js"></script>
<script src="js/plugin.js"></script>
<script type="text/javascript">
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

// croptops_nav
function goto(k){
	var id = "#d"+k;
	var obj = $(id).offset();
	var pos = obj.top - 80;
	
	$("html,body").animate({scrollTop: pos}, 1000);
};

</script>
<div class="JS_popwincon1 popwincon hide" style="padding-right: 50px;">
    <a class="JS_close2 close_btn2"></a>
    <div style="background:#fff; height: 545px;" id="inline_example2">
        <div id="quickView">

            <!------------------------------------ Product Images-------------------------------------->         
            <div class="content-product-image fix">
                <div class="myImagesSlideBox1" id="myImagesSlideBox">
                    <div class="myImages1">
                        <img src="" class="myImgs" alt="" />
                    </div>
                    <div id="scrollable"> 
                        <div class="items" >
                            <div class="scrollableDiv"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!------------------------------------ Product Info-------------------------------------->
            <div id="productInfo">
                <dl>
                    <dd>
                        <h1 id="product_name">Floral Print Skinny Jean</h1>
                        <div class="infoText">Item# : <span id="product_sku">CPDL1959</span></div>
                        <div class="stock" id="stock">
                            <span class="icon-stock">&nbsp;</span>In Stock
                        </div>
                        <div class="hide" id="outstock">
                            <span class="icon-outstock">&nbsp;</span> Out Of Stock
                        </div>
                        <div class="detils"><a id="product_link" href="#" title="VIEW FULL DETAILS">VIEW FULL DETAILS</a></div>
                        <div class="clear"></div>
                    </dd>
                    <dd>
                        <div class="price">
                            <span class="reg"><del id="product_s_price"></del></span>
                            <br/>
                            <span id="product_price" class="nowPrice"></span>
                        </div>
                    </dd>

                    <dd class="fix">
                        <div class="charge_fix" id="action-form">
                            <form action="#" method="post" id="formAdd">
                                <input id="product_id" type="hidden" name="id" value="8468"/>
                                <input id="product_items" type="hidden" name="items[]" value="8468"/>
                                <input id="product_type" type="hidden" name="type" value="3"/>
                                <div class="btn_size"></div>
                                <div class="btn_color"></div>
                                <div class="btn_type"></div>
                                <div class="qty mt10">Qty: 
                                    <input type="button" onclick="minus()" value="-" class="btn_qty1" />
                                    <input type="text" name="quantity" class="btn_text" value="1" id="count_1"/>
                                    <input type="button" onclick="plus()" value="+" class="btn_qty" />
                                    <span id="only_left" class="red"></span>
                                    <strong class="red" id="outofstock"></strong>
                                </div>
                                <div class="btnadd"> 
                                    <button class="btn add_btn view_btn" id="addCart">add to bag</button>
                                    <a id="addWishList" class="btn40_1 view_btn btn" href="#">my wishlist</a>
                                </div>
                            </form>
                        </div>
                    </dd>
                    <dd>
                        <div id="tab5">
                            <div id="tab5-nav1">
                                <ul class="fix idTabs">
                                    <li class="on">DETAILS</li>
                                    <li>CONTACT</li>
                                </ul>
                            </div>
                            <div id="tab5-con-1">
                                <div id="tab5-1-con"></div>
                                <div class="description hide" id="tab5-2-con">
                                    <div class="LiveChat2  mt15 pl10">
                                        <a href="#" onclick="psSMPPow(); return false;"><img name="psSMPPimage" src="<?php echo BASEURL ;?>/images/livechat_online1.gif" border="0" /> LiveChat</a>
                                    </div>
                                    <div class="LiveChat2 mt10 pl10"><a href="mailto:<?php echo Site::instance()->get('email'); ?>"><img src="<?php echo STATICURL; ?>/ximg/livemessage.png" alt="Leave Message" /> Leave Message</a></div>
                                    <div class="LiveChat2 mt10 pl10"><a href="<?php echo LANGPATH; ?>/faqs" target="_blank"><img src="<?php echo STATICURL; ?>/ximg/faq.png" alt="FAQ" /> FAQ</a></div>
                                </div>
                            </div>
                        </div>
                    </dd>
                    <dd>
                      <div><!--  <a href="<?php echo LANGPATH; ?>/20-coupon-code-for-spring-festival"><img src="<?php echo STATICURL; ?>/ximg/gift_banner.jpg" alt="" /></a>--></div>
                    </dd>
                </dl>
            </div>

        </div>
    </div>
    <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
</div>
<script type="text/javascript">
    $(function(){
        $(".btn_size input").live("click",function(){
            var qty = $(this).attr('title');
            if(qty)
                $("#only_left").html('Only '+qty+' Left!');
        });
        $("#formAdd").submit(function(){
            $.post(
            '/cart/ajax_add',
            {
                id: $('#product_id').val(),
                type: $('#product_type').val(),
                size: $('.s-size').val(),
                color: $('.s-color').val(),
                attrtype: $('.s-type').val(),
                quantity: $('#count_1').val()
            },
            function(product)
            {
                var count = 0;
                var cart_view = '';
                var cart_view1 = '';
                var key = 0;
                for(var p in product)
                {
                    if(key == 0)
                    {
                        cart_view = '\
                                                <a href="'+product[p]['link']+'"><img src="'+product[p]['image']+'" alt="'+product[p]['name']+'" /></a>\
                                                    <div class="right">\
                                                        <a class="name" href="'+product[p]['link']+'">'+product[p]['name']+'</a>\
                                                        <p>Item# : '+product[p]['sku']+'</p>\
                                                        <p>'+product[p]['price']+'</p>\
                                                        <p>'+product[p]['attributes']+'</p>\
                                                        <p>Quantity: '+product[p]['quantity']+'</p>\
                                                    </div>\
                                                <div class="fix"></div>\
                                                ';
                                                                            }
                                                                            else
                                                                            {
                                                                                cart_view1 += '\
                                                <li class="fix">\
                                                <a href="'+product[p]['link']+'"><img src="'+product[p]['image']+'" alt="'+product[p]['name']+'" /></a>\
                                                    <div class="right">\
                                                        <a class="name" href="'+product[p]['link']+'">'+product[p]['name']+'</a>\
                                                        <p>Item# : '+product[p]['sku']+'</p>\
                                                        <p>'+product[p]['price']+'</p>\
                                                        <p>'+product[p]['attributes']+'</p>\
                                                        <p>Quantity: '+product[p]['quantity']+'</p>\
                                                    </div>\
                                                <div class="fix"></div>\
                                                </li>';
                                                                                count = count + parseInt(product[p]['quantity']);
                                                                            }
                                                                            key = key + 1;
                                                                        }
                                                                        if($(document).scrollTop() > 120)
                                                                        {
                                                                            $('#mybag2 .currentbag .bag_items li').html(cart_view);
                                                                            $('#mybag2 .currentbag').fadeIn(10).delay(3000).fadeOut(10);
                                                                        }
                                                                        else
                                                                        {
                                                                            $('#mybag1 .currentbag .bag_items li').html(cart_view);
                                                                            $('#mybag1 .currentbag').fadeIn(10).delay(3000).fadeOut(10);
                                                                        }
                                                                        $('.mybag_box .cart_bag').html(cart_view1);
                                                                        $('.cart_count').text(count);
                                                                    },
                                                                    'json'
                                                                );
                                                                    $(".JS_filter1").remove();
                                                                    $('.JS_popwincon1').fadeOut(160).appendTo('#tab2');
                                                                    return false;
                                                                })
                                                            })
</script>