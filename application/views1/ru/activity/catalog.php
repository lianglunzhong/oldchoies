<link rel="canonical" href="/<?php $catalog_link = $catalog->get('link'); echo $catalog_link; ?>" />
<link type="text/css" rel="stylesheet" href="/css/quickview.css" media="all" />
<?php
$name = $catalog->get('name');
?>
<!-- main begin -->
<section id="main">
    <!-- index_free begin -->
    <div class="w_index_free">
        <div class="layout index_free">
            <a href="<?php echo LANGPATH; ?>/shipping-delivery" class="a1">Бесплатная доставка по всему миру</a>
            <?php 
            $user_id = Customer::logged_in();
            if($user_id){?>
                <a href="<?php echo LANGPATH; ?>/vip-policy" class="a2">15% скидка на первый заказ</a>
            <?php }else{ ?>
                <a href="<?php echo LANGPATH; ?>/customer/login" class="a2">15% скидка на первый заказ</a>
            <?php } ?>
            <a href="<?php echo LANGPATH; ?>/daily-new" class="a3">Новинки - 10% скидки</a>
        </div>
    </div>

    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll">
                <a href="<?php echo LANGPATH; ?>/" class="home">Home</a>
                <?php
                $crumbs = $catalog->crumbs();
                foreach ($crumbs as $key => $crumb):
                    ?>
                    <?php if ($key != count($catalog->crumbs()) - 1): ?>
                        &gt; <span><a href="<?php echo $crumb['link']; ?>" rel="nofollow" ><?php echo $crumb['name']; ?></a></span>
                    <?php else: ?>
                        &gt; <span><?php echo $name; ?></span>
                    <?php endif; ?>
                    <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <section id="container" class="flr">
            <section class="pro_list lp_jewelry">
                <?php
                $image_src = $catalog->get('image_src');
                if ($image_src):
                    $image_map = $catalog->get('image_map');
                    if ($image_map)
                        $map = 'Map' . $catalog->get('id');
                    else
                        $map = '';
                    ?>
                    <p class="mb25">
                        <a href="<?php echo $catalog->get('image_link'); ?>">
                            <img src="/simages/<?php echo $image_src; ?>" width="810" alt="<?php echo $catalog->get('image_alt'); ?>" usemap="#<?php echo $map; ?>" />
                        </a>
                    </p>
                    <?php
                    if ($map)
                    {
                        echo '<map name="' . $map . '" id="' . $map . '">' . $image_map . '</map>';
                    }
                endif;
                ?>
                <article class="filter_page">
                    <ul class="select fix">
                        <li class="last">
                            <?php
                            echo $pagination;
                            ?>
                        </li> 
                    </ul>
                </article>
                <!-- pro_listcon -->
                <article class="pro_listcon">
                    <ul class="fix">
                        <?php
                        $_limit = count($products) >= $limit ? $limit : count($products);
                        foreach ($products as $product_id):
                            $images = Product::instance($product_id)->images();
                            $product_inf = DB::select('type', 'name', 'price', 'has_pick', 'status', 'stock', 'display_date')
                                            ->from('products_' . LANGUAGE)
                                            ->where('id', '=', $product_id)
                                            ->execute()->current();
                            ?>
                            <li class="JS_shows_btn1">
                                <div class="pic">
                                    <a href="<?php echo Product::instance($product_id, LANGUAGE)->permalink(); ?>">
                                        <img class="pic1" src="<?php echo Image::link($images[0], 1); ?>" alt="<?php echo 'Fashion ' . $catalog->get('name'); ?>" title="<?php echo $product_inf['name']; ?>" />
                                        <?php
                                        if (isset($images[1]))
                                        {
                                            ?>
                                            <img class="pic2" style="display:none;" src="<?php echo Image::link($images[1], 1); ?>" alt="<?php echo 'Fashion ' . $catalog->get('name'); ?>" title="<?php echo $product_inf['name']; ?>" />
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </div>
                                <?php if ($product_inf['type'] != 0): ?>
                                    <a href="#" id="<?php echo $product_id; ?>" class="quick_view JS_shows1 hide">Бстрый посмотр</a>
                                <?php endif; ?>
                                <a class="name" href="<?php echo Product::instance($product_id, LANGUAGE)->permalink(); ?>"><?php echo $product_inf['name']; ?></a>
                                <p class="price fix">
                                    <?php
                                    $orig_price = round($product_inf['price'], 2);
                                    $price = round(Product::instance($product_id)->price(), 2);
                                    if ($orig_price > $price)
                                    {
                                        $off = round(($orig_price - $price) / $orig_price, 2) * 100;
                                        ?>
                                        <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>    <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del>
                                        <span class="off"><?php echo $off; ?>% OFF</span>
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
                                    echo '<span class="outstock">Нет в наличии</span>';
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
                        endforeach;
                        ?>
                    </ul>
                </article>
            </section>

            <!-- filter_page -->
            <article class="filter_page">
                <ul class="select fix">
                    <li class="last">
                        <?php
                        echo $pagination;
                        ?>
                    </li> 
                </ul>
            </article>
        </section>

        <!-- aside -->
        <?php
        echo View::factory(LANGPATH . '/catalog_left');
        ?>
    </section>
</section>
<?php echo View::factory(LANGPATH.'/quickview'); ?>
<div class="mybag hide" id="mybag" style="position: fixed;top: 10px;right: 140px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border-style: solid;border-width: 8px 4px 4px;">
    <div class="add_tit" style="margin-top:0px;">Молодец! Товар добавлен в корзину.</div>
    <div class="order order_addtobag">
        <ul id="bag_items">
            <li>
            </li>
        </ul>
    </div>
    <div class="mybagButton"><a href="<?php echo LANGPATH; ?>/cart/view" id="checkout1" class="allbtn btn-chk1">&nbsp;</a></div>
</div>
<script type="text/javascript">
    $(function(){
        $(".btn_size input").live("click",function(){
            var qty = $(this).attr('title');
            if(qty)
                $("#only_left").html('Теперь Только '+qty+' !');
        });
        $("#formAdd").submit(function(){
            $.post(
            '/cart/ajax_add?lang=<?php echo LANGUAGE; ?>',
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
                                <p>Товар# : '+product[p]['sku']+'</p>\
                                <p>'+product[p]['price']+'</p>\
                                <p>'+product[p]['attributes']+'</p>\
                                <p>Количество: '+product[p]['quantity']+'</p>\
                            </div>\
                        <div class="fix"></div>\
                        ';
                    }
                }
                cart_view = cart_view.replace('Size', 'Размеры');
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
                ajax_cart();
            },
            'json'
        );
        $(".JS_filter1").remove();
        $('.JS_popwincon1').fadeOut(160).appendTo('#tab2');
        return false;
        })
})
</script>