<link type="text/css" rel="stylesheet" href="/css/quickview.css" media="all" />
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Homepage</a>  >  404</div>
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
                        <h1>Oops ... Seite Nicht Gefunden!</h1>

                        <!-- 英语站 -->
                        <p class="font24 mt50">Wir sind aufrichtig leid für die Unannehmlichkeiten.</p>
                        <p class="font24">Hier ist Ihre exklusive <b class="red">20% Rabatt</b> Gutschein Code: </p>
                        <p class="b"><b class="red font18"><?php echo $code; ?></b> (In 30 Tage Ablaufen)</p>
                        <p class="text_upper mb20"><b>DER CODE KANN NUR FÜR EINMAL VERWENDET WERDEN.</b></p>
                        <p><a href="<?php echo BASEURL ;?>/<?php echo LANGUAGE; ?>/choies-highlights" class="b">JETZT KAUFEN >></a></p>
                    </div>
                    <div class="banner_404 fix">
                        <div class="left">
                            <p class="mb10"><b>SENDEN SIE DEN Code ZU MEINE E-Mail >></b></p>
                            <form action="<?php echo LANGPATH; ?>/site/404_mail" method="post" class="form">
                                <input type="hidden" name="code" value="<?php echo $code; ?>" />
                                <input type="text" name="email" value="Bitte Geben Sie Ihre Email Adresse Ein" class="text" />
                                <input type="submit" value="SENDEN" class="btn" />
                            </form>
                        </div>
                        <div class="right">
                            <p>SPEZIELLE ANFORDERUNG?</p> 
                            <b><a href="<?php echo BASEURL ;?>/<?php echo LANGUAGE; ?>/contact-us">KONTAKTIEREN SIE UNS!</a></b>
                        </div>
                    </div>
                </div>
                <div class=" font18 mb25">Oder Sie können einen Blick auf unsere Bestseller-Produkte werfen:</div>
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
                                    <a href="#" id="<?php echo $product['product_id']; ?>" class="quick_view">SCHNELLANSICHT</a>
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
                                        <b><?php echo Site::instance()->price($now, 'code_view'); ?></b>    <del><?php echo Site::instance()->price($retail, 'code_view'); ?></del> <span class="off"><?php echo (int) $off; ?>% Rabatt</span>
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
                                    <span class="outstock">Nicht Auf Lager</span>
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
<?php echo View::factory('/de/quickview'); ?>
<div class="mybag hide" id="mybag" style="position: fixed;top: 10px;right: 140px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border-style: solid;border-width: 8px 4px 4px;">
    <div class="add_tit" style="margin-top:0px;">ERFOLG! ARTIKEL IN DEN WARENKORB HINZUGEFÜGT</div>
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
                                <p>Item# : '+product[p]['sku']+'</p>\
                                <p>'+product[p]['price']+'</p>\
                                <p>'+product[p]['attributes']+'</p>\
                                <p>Quantity: '+product[p]['quantity']+'</p>\
                            </div>\
                        <div class="fix"></div>\
                        ';
                    }
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