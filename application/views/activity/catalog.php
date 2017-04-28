<link rel="canonical" href="/<?php $catalog_link = $catalog->get('link'); echo $catalog_link; ?>" />
<link type="text/css" rel="stylesheet" href="/css/quickview.css" media="all" />
<style>
    .lp_jewelry .pro_listcon li img{width:auto; height:auto;}
</style>
<?php
$name = $catalog->get('name');
?>
<!-- main begin -->
<section id="main">
    <!-- index_free begin -->
    <div class="w_index_free">
        <div class="layout index_free">
            <img src="/images/index_free.png" border="0" usemap="#Map" />
            <map name="Map" id="Map">
                <area shape="rect" coords="3,4,345,43" href="<?php echo LANGPATH; ?>/shipping-delivery" />
                <area shape="rect" coords="346,5,714,42" href="<?php echo LANGPATH; ?>/customer/login" />
                <area shape="rect" coords="716,5,1021,43" href="<?php echo LANGPATH; ?>/daily-new" />
            </map>
        </div>
    </div>

    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll">
                <a href="<?php echo LANGPATH; ?>/" class="home">home</a>
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
                        foreach ($products as $key => $product_id):
                            $images = Product::instance($product_id)->images();
                            $product_inf = DB::select('type', 'name', 'price', 'has_pick', 'status', 'stock', 'display_date')
                                            ->from('products_product')
                                            ->where('id', '=', $product_id)
                                            ->execute()->current();
                            ?>
                            <li class="JS_shows_btn1">
                                <?php
                                if($key >= 15)
                                {
                                ?>
                                    <div class="pic">
                                        <a href="<?php echo Product::instance($product_id)->permalink(); ?>">
                                            <div class="pic1"><img data-original="<?php echo Image::link($images[0], 1); ?>" src="/images/loading.gif" alt="<?php echo 'Fashion ' . $catalog->get('name'); ?>" title="<?php echo $product_inf['name']; ?>" /></div>
                                            <?php
                                            if (isset($images[1]))
                                            {
                                                ?>
                                                <div class="pic2" style="display:none;"><img data-original="<?php echo Image::link($images[1], 1); ?>" src="/images/loading.gif" alt="<?php echo 'Fashion ' . $catalog->get('name'); ?>" title="<?php echo $product_inf['name']; ?>" /></div>
                                                <?php
                                            }
                                            ?>
                                        </a>
                                    </div>
                                <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="pic">
                                        <a href="<?php echo Product::instance($product_id)->permalink(); ?>">
                                            <div class="pic1"><img src="<?php echo Image::link($images[0], 1); ?>" alt="<?php echo 'Fashion ' . $catalog->get('name'); ?>" title="<?php echo $product_inf['name']; ?>" /></div>
                                            <?php
                                            if (isset($images[1]))
                                            {
                                                ?>
                                                <div class="pic2" style="display:none;"><img src="<?php echo Image::link($images[1], 1); ?>" alt="<?php echo 'Fashion ' . $catalog->get('name'); ?>" title="<?php echo $product_inf['name']; ?>" /></div>
                                                <?php
                                            }
                                            ?>
                                        </a>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php if ($product_inf['type'] != 0): ?>
                                    <a href="#" id="<?php echo $product_id; ?>" class="quick_view JS_shows1 hide">Quick View</a>
                                <?php endif; ?>
                                <a class="name" href="<?php echo Product::instance($product_id)->permalink(); ?>"><?php echo $product_inf['name']; ?></a>
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
<script type="text/javascript" src="/js/catalog.js"></script>
<script type="text/javascript" src="/js/catalog.loadthumb.js"></script>
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
                                    <div class="LiveChat2 mt10 pl10"><a href="mailto:<?php echo Site::instance()->get('email'); ?>"><img src="/images/livemessage.png" alt="Leave Message" /> Leave Message</a></div>
                                    <div class="LiveChat2 mt10 pl10"><a href="<?php echo LANGPATH; ?>/faqs" target="_blank"><img src="/images/faq.png" alt="FAQ" /> FAQ</a></div>
                                </div>
                            </div>
                        </div>
                    </dd>
                    <dd>
                      <div><!--  <a href="<?php echo LANGPATH; ?>/20-coupon-code-for-spring-festival"><img src="/images/gift_banner.jpg" alt="" /></a>--></div>
                    </dd>
                </dl>
            </div>

        </div>
    </div>
    <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
</div>
<div class="mybag hide" id="mybag" style="position: fixed;top: 10px;right: 140px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border-style: solid;border-width: 8px 4px 4px;">
    <div class="add_tit" style="margin-top:0px;">Success! Item Added To BAG</div>
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

<!-- lazyload -->
<script type="text/javascript" charset="utf-8" src="/js/lazyload.js"></script>