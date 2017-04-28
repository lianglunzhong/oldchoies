<link type="text/css" rel="stylesheet" href="/css/catalog.css" media="all" />
<link type="text/css" rel="stylesheet" href="/css/common.css" media="all" />
<link type="text/css" rel="stylesheet" href="/css/quickview.css" media="all" />

<!-- main begin -->
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll">
                <a href="<?php echo LANGPATH; ?>/" class="home">home</a>&gt; <span><?php echo $brands['name']; ?></span>
            </div>
        </div>
    </div>
    <div class="grid">
        <?php
        $count_product = count($products);
        if($count_product > 0)
        {
            $gets = array();
            foreach ($_GET as $name => $val)
            {
                if ($name == 'limit')
                    $gets[] = 'limit=' . $val;
                if ($name == 'pick')
                    $gets[] = 'pick=' . $val;
                if ($name == 'sort')
                    $gets[] = 'sort=' . $val;
            }
        ?>
        <div class="fll filter-bar">
            <li style="float:left;margin-top: 5px;"><div>Sort By:&nbsp;</div></li>
            <li class="item-l choice" style="width:140px;">
                <div class="choice-hd">
                    <?php
                    if(isset($_GET['sort']))
                    {
                        echo $sorts[$_GET['sort']]['name'];
                    }
                    else
                    {
                        echo 'Default'; 
                    }
                    ?>
                    <i class="fa fa-caret-down"></i>
                </div>
                <ul class="choice-list">
                <?php
                foreach ($sorts as $key => $sort)
                {
                    $link = empty($gets1) ? '' : '?' . implode('&', $gets1);
                    if($link == "")
                    {
                        $tolink = $link . '?sort=' . $key;
                    }
                    else
                    {
                        $tolink = $link . '&sort=' . $key;
                    }
                    ?>
                    <li class="choice-option">
                        <a href="<?php echo $_SERVER['REDIRECT_URL'] . $tolink; ?>"><?php echo $sort['name']; ?></a>
                    </li>
                    <?php
                }
                ?>
                </ul>
            </li>
            <li class="item-l pick">
                <?php
                $gets1 = $gets;
                if (!empty($gets1))
                {
                    $has = 0;
                    foreach ($gets1 as $key => $get)
                    {
                        if (strpos($get, 'pick') !== FALSE)
                        {
                            $has = 1;
                            $gets1[$key] = 'pick=1';
                            break;
                        }
                    }
                    if (!$has)
                        $gets1[] = 'pick=1';
                }
                else
                    $gets1[] = 'pick=1';
                ?>
                <a href="<?php echo $_SERVER['REDIRECT_URL'] . '?' . implode('&', $gets1); ?>" class=""> <i class="icon icon-pick"></i> Icon's Pick</a>
            </li>
        </div>
        <div class="flr"><?php echo $pagination; ?></div>
        <div class="fix"></div>
        <div class="pro-list">
            <ul class="cf">
                <?php
                $secondhalf = DB::select('restrictions')
                    ->from('carts_cpromotions')
                    ->where('actions', '=', 'a:1:{s:6:"action";s:10:"secondhalf";}')
                    ->and_where('site_id', '=', 1)
                    ->and_where('is_active', '=', 1)
                    ->and_where('to_date', '>', time())
                    ->execute()->get('restrictions');
                foreach($products as $i => $product)
                {
                    $product_id = $product['id'];
                    $cover_image = Product::instance($product_id)->cover_image();
                    $product_inf = Product::instance($product_id)->get();
                    $search = array('product_id' => $product_id);
                    $plink = Product::instance($product_id)->permalink();
                    ?>
                    <li class="pro-item">
                        <?php
                        if($i >= 20)
                        {
                        ?>
                            <div class="overlay"></div>
                            <div class="pic">
                                <a href="<?php echo $plink; ?>">
                                <div class="pic1"><img data-original="<?php echo Image::link($cover_image, 1); ?>" src="/images/loading.gif" alt="<?php echo $product_inf['name']; ?>" title="<?php echo $product_inf['name']; ?>" /></div>
                                </a>
                            </div>
                        <?php
                        }
                        else
                        {
                            ?>
                            <div class="overlay"></div>
                            <div class="pic">
                                <a href="<?php echo $plink; ?>">
                                <div class="pic1"><img src="<?php echo Image::link($cover_image, 1); ?>" alt="<?php echo $product_inf['name']; ?>" title="<?php echo $product_inf['name']; ?>" /></div>
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                        <h6 class="title">
                            <a href="<?php echo $plink; ?>" title="<?php echo $product_inf['name']; ?>">
                            <?php
                            if ($product_inf['has_pick'] != 0)
                            {
                                ?>
                                <i class="icon icon-pick"></i>
                                <?php
                            }
                            ?>
                            <?php echo $product_inf['name']; ?>
                            </a>
                        </h6>
                        <p class="price">
                            <?php
                            $orig_price = round($product_inf['price'], 2);
                            $price = round(Product::instance($product_id)->price(), 2);
                            if ($orig_price > $price)
                            {
                                ?>
                                <span class="priceold"><?php echo Site::instance()->price($orig_price, 'code_view'); ?></span>
                                <span class="pricenew"><?php echo Site::instance()->price($price, 'code_view'); ?></span>
                                <?php
                            }
                            else
                            {
                                ?>
                                <span class="pricenew"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                <?php
                            }
                            ?>
                        </p>
                        <?php
                        if(isset($review_statistics[$product_id]))
                        {
                            $review = $review_statistics[$product_id];
                            $integer = floor($review['rating']);
                            $decimal = $review['rating'] - $integer;
                        ?>
                        <div class="reviews">
                        <a href="<?php echo $plink; ?>#review_list">
                            <?php
                            for($r = 1;$r <= $integer;$r ++)
                            {
                            ?>
                                <i class="fa fa-star"></i>
                            <?php
                            }
                            if($decimal > 0)
                            {
                            ?>
                                <i class="fa fa-star-half-full"></i>
                            <?php
                            }
                            ?>
                            (<?php echo $review['quantity']; ?>)
                            </a>
                        </div>
                        <?php
                        }
                        ?>
                        <?php if ($product_inf['type'] != 0): ?>
                            <a href="#" id="<?php echo $product_id; ?>" class="quick_view JS_shows1"><span class="btn-qv">Quick View</span></a>
                        <?php endif; ?>
                        
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
                            $is_new = time() - $product_inf['display_date'] <= 86400 * 7 ? 1 : 0;
                            if($is_new)
                                echo '<i class="icon icon-new"></i>';
                        }
                        ?>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <div class="flr"><?php echo $pagination; ?></div>
        <?php
        }
        else
        {
            ?>
            <div class="font18 mt20">Sorry, no results found. You may take a look at our recommended products:</div>
            <div class="hide-box1_2">
                <ul class="cf">
                <?php
                $hots = array();
                $hots = DB::query(Database::SELECT, 'SELECT P.id, P.link FROM products_product P LEFT JOIN products_categoryproduct C ON P.id = C.product_id WHERE C.category_id = ' . $catalog_id . ' AND P.visibility = 1 AND P.status = 1 AND stock <> 0 ORDER BY P.hits DESC LIMIT 0, 6')->execute();
                foreach($hots as $pdetail)
                {
                    ?>
                    <li data-scarabitem="<?php echo $pdetail['sku']; ?>" style="display: inline-block" class="rec-item">
                        <a href="/product/<?php echo $pdetail['link'] . '_p' . $pdetail['id']; ?>">
                            <img src="<?php echo Image::link(Product::instance($pdetail['id'])->cover_image(), 7); ?>" class="rec-image">
                        </a>
                        <p class="price"><b><?php echo Site::instance()->price(Product::instance($pdetail['id'])->price(), 'code_view') ?></b></p>
                    </li>
                    <?php
                }
                ?>
                </ul>
            </div>
            <?php
        }
        ?>
        <br><article class="product_reviews" id="alsoview" style="display:none">
        <div class="w_tit layout"><h2>Recommended Products</h2></div>
        <div class="box-dibu1">
        <!-- Template for rendering recommendations -->
        <script type="text/html" id="simple-tmpl" >
        <![CDATA[
            {{ for (var i=0; i < SC.page.products.length; i++) { }}
                {{ if(i==0){ }}
                <div class="hide-box1_0"><ul>
                {{ }else if(i%6==0){ }}
                <div class="hide-box1_{{= i/6 }} hide1"><ul>
                {{ } }}
              {{ var p = SC.page.products[i]; }}
              <li data-scarabitem="{{= p.id }}" style="display: inline-block" class="rec-item">
                 <a href="{{=p.plink}}" id="em{{= p.id }}link">
                  <img src="{{=p.image}}" class="rec-image">
                </a>
                <p class="price"><b id="em{{= p.id }}price">${{=p.price}}</b></p>
              </li>
                {{ if(i==5 || i==11 || i==17 || i==24){ }}
                </ul></div>
                {{ } }}
            {{ } }} 
        ]]>
        </script>
        </article>
        <script type="text/javascript">
        var f=0;
        var t1;
        var tc1;
        $(function(){
            $(".box-current1 li").hover(function(){   
                $(this).addClass("on").siblings().removeClass("on");
                var c=$(".box-current1 li").index(this);
                $(".hide-box1_0,.hide-box1_1,.hide-box1_2,.hide-box1_3").hide();
                $(".hide-box1_"+c).fadeIn(150); 
                f=c; 
            })
        })
        </script>
        </div>
</section>
<?php echo View::factory('/quickview'); ?>

<script type="text/javascript" src="/js/list.js"></script>

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

<script type="text/javascript">
    var google_tag_params = {
        ecomm_prodid: '',           //SKU
        ecomm_pagetype: 'category',         // product
        ecomm_totalvalue: ''       // 
    };
</script>
<!-- lazyload -->
<script type="text/javascript" charset="utf-8" src="/js/lazyload.js"></script>
