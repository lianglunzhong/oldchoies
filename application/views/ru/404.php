<link type="text/css" rel="stylesheet" href="/css/quickview.css" media="all" />
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Home</a>  >  404</div>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <?php echo Message::get(); ?>
        <section id="container" class="flr">
            <section class="pro_list">
                <!-- searchon_box -->
                <div class="searchon_wp">
                    <div class="searchon_404 center">
                        <!-- 小语种 -->
                        <img src="/images/not_found_1.png" />
                        <h1>Упс... Страница Не Найдена!</h1>

                        <!-- 英语站 -->
                        <p class="font24 mt50">Мы искренне сожалеем за причиненные неудобства.</p>
                        <p class="font24">Вот ваш эксклюзивный код купона"<b class="red">20% off</b>": </p>
                        <p class="b"><b class="red font18"><?php echo $code; ?></b> (Истекает в течение 30 дней)</p>
                        <p class="text_upper mb20"><b>КОД МОЖЕТ БЫТЬ ИСПОЛЬЗОВАН ТОЛЬКО ОДИН РАЗ.</b></p>
                        <p><a href="http://www.choies.com/<?php echo LANGUAGE; ?>/choies-highlights" class="b">КУПИТЬ СЕЙЧАС >></a></p>
                    </div>
                    <div class="banner_404 fix">
                        <div class="left">
                            <p class="mb10"><b>ОТПРАВИТЬ КОД НА МОЙ ПОЧТУ >></b></p>
                            <form action="<?php echo LANGPATH; ?>/site/404_mail" method="post" class="form">
                                <input type="hidden" name="code" value="<?php echo $code; ?>" />
                                <input type="text" name="email" value="Введите Адрес Электронной Почты" class="text" />
                                <input type="submit" value="ОТПРАВИТЬ" class="btn" />
                            </form>
                        </div>
                        <div class="right">
                            <p>Особая Просьба?</p> 
                            <b><a href="http://www.choies.com/<?php echo LANGUAGE; ?>/contact-us">Свяжитесь С Нами</a></b>
                        </div>
                    </div>
                </div>
                <div class=" font18 mb25">Посмотреть нац ходовые товары:</div>
                <!-- pro_listcon -->
                <article class="pro_listcon">
                    <ul class="fix">
                        <?php
                        $top_seller = DB::select('product_id')
                                ->from('catalog_products')
                                ->where('catalog_id', '=', 32)
                                ->order_by('position', 'DESC')
                                ->execute();
                        $key = 0;
                        foreach ($top_seller as $product):
                            if (!Product::instance($product['product_id'])->get('visibility') OR !Product::instance($product['product_id'])->get('status'))
                                continue;
                            $stock = Product::instance($product['product_id'])->get('stock');
                            if ($stock == 0)
                                continue;
                            elseif ($stock == -1)
                            {
                                $stocks = DB::select(DB::expr('SUM(stocks) AS sum'))
                                                ->from('products_stocks')
                                                ->where('product_id', '=', $product['product_id'])
                                                ->where('attributes', '<>', '')
                                                ->execute()->get('sum');
                                if (!$stocks)
                                    continue;
                            }
                            $relate_name = Product::instance($product['product_id'], LANGUAGE)->get('name');
                            $link = Product::instance($product['product_id'], LANGUAGE)->permalink();
                            ?>
                            <li>
                                <a href="<?php echo $link; ?>" title="<?php echo $relate_name; ?>">
                                    <img src="<?php echo image::link(Product::instance($product['product_id'])->cover_image(), 1); ?>" />
                                </a>
                                <?php if (Product::instance($product['product_id'])->get('type') != 0): ?>
                                    <a href="#" id="<?php echo $product['product_id']; ?>" class="quick_view">Бстрый посмотр</a>
                                <?php endif; ?>
                                <a href="<?php echo $link; ?>" class="name"><?php echo $relate_name; ?></a>
                                <p class="price fix">
                                    <?php
                                    $retail = Product::instance($product['product_id'])->get('price');
                                    $now = Product::instance($product['product_id'])->price();
                                    if ($retail > $now)
                                    {
                                        $off = (($retail - $now) / $retail) * 100;
                                        ?>
                                        <b><?php echo Site::instance()->price($now, 'code_view'); ?></b>    <del><?php echo Site::instance()->price($retail, 'code_view'); ?></del> <span class="off"><?php echo (int) $off; ?>% OFF</span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <b><?php echo Site::instance()->price($now, 'code_view'); ?></b>
                                        <?php
                                    }
                                    if (Product::instance($product['product_id'])->get('has_pick'))
                                        echo '<span class="icon_pick"></span>';
                                    ?>
                                </p>
                                <?php if ($retail > $now): ?>
                                    <span class="icon_sale"></span>
                                <?php endif; ?>
                                <?php if (!Product::instance($product['product_id'])->get('status')): ?>
                                    <span class="outstock">Нет в наличии</span>
                                <?php endif; ?>
                            </li>
                            <?php
                            $key++;
                            if ($key >= 8)
                                break;
                        endforeach;
                        ?>
                    </ul>
                </article>
            </section>
        </section>
        <?php echo View::factory(LANGPATH . '/catalog_left'); ?>
    </section>
</section>
<?php echo View::factory(LANGPATH.'/quickview'); ?>
<div class="mybag hide" id="mybag" style="position: fixed;top: 10px;right: 140px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border-style: solid;border-width: 8px 4px 4px;">
    <div class="add_tit" style="margin-top:0px;">Молодец! Товар добавлен в корзину. </div>
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