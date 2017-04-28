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
                        <h1>Oops... Page Not Found!</h1>

                        <!-- 英语站 -->
                        <p class="font24 mt50">We are sincerely sorry for any inconvenience.</p>
                        <p class="font24">Here is your exclusive <b class="red">20% off</b> coupon code: </p>
                        <p class="b"><b class="red font18"><?php echo $code; ?></b> (Expire in 30 days)</p>
                        <p class="text_upper mb20"><b>The code can only be used for once.</b></p>
                        <p><a href="<?php echo BASEURL ;?>/choies-highlights" class="b">Shop Now >></a></p>
                    </div>
                    <div class="banner_404 fix">
                        <div class="left">
                            <p class="mb10"><b>Send the Code to My Email >></b></p>
                            <form action="/site/404_mail" method="post" class="form">
                                <input type="hidden" name="code" value="<?php echo $code; ?>" />
                                <input type="text" name="email" value="Please Enter Email Address" class="text" />
                                <input type="submit" value="SEND" class="btn" />
                            </form>
                        </div>
                        <div class="right">
                            <p>Special Request?</p> 
                            <b><a href="<?php echo BASEURL ;?>/contact-us">Contact Us!</a></b>
                        </div>
                    </div>
                </div>
                <div class=" font18 mb25">Or you may take a look at our best-selling products:</div>
                <!-- pro_listcon -->
                <article class="pro_listcon">
                    <ul class="fix">
                        <?php
                        $top_seller = DB::select('product_id')
                                ->from('products_categoryproduct')
                                ->where('category_id', '=', 32)
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
                            $relate_name = Product::instance($product['product_id'])->get('name');
                            $link = Product::instance($product['product_id'])->permalink();
                            ?>
                            <li>
                                <a href="<?php echo $link; ?>" title="<?php echo $relate_name; ?>">
                                    <img src="<?php echo image::link(Product::instance($product['product_id'])->cover_image(), 1); ?>" />
                                </a>
                                <?php if (Product::instance($product['product_id'])->get('type') != 0): ?>
                                    <a href="#" id="<?php echo $product['product_id']; ?>" class="quick_view">Quick View</a>
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
                                        <b><?php echo Site::instance()->price($now, 'code_view'); ?></b>    <del><?php echo Site::instance()->price($retail, 'code_view'); ?></del> <span class="off"><?php echo (int) $off; ?>% off</span>
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
                                    <span class="outstock">Out Of Stock</span>
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
        <?php echo View::factory('/catalog_left'); ?>
    </section>
</section>
<?php echo View::factory('/quickview'); ?> 
<script type="text/javascript">
    $(function(){
        $("#formAdd").live('submit', function(){
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