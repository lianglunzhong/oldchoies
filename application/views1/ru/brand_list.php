<div class="site-content">
    <div class="main-container clearfix">
        <div class="container">
            <div class="crumbs">
                <div class="fll">
                    <a href="<?php echo LANGPATH; ?>/" class="home">home</a>&gt; <span><?php echo $brands['name']; ?>
                </div>
            </div>
            <!-- aside -->
            <ul class="filter-bar cf">
                <li class="fll mt5"><div>Trier par:&nbsp;</div></li>
                <li class="item-l drop-down JS-show">
                    <div class="drop-down-hd">
                        <?php
                        if(isset($_GET['sort']))
                        {
                            echo $sorts[$_GET['sort']]['name'];
                        }
                        else
                        {
                            echo 'Défaut'; 
                        }
                        ?>
                        <i class="fa fa-angle-down"></i>
                    </div>
                    <ul class="drop-down-list JS-showcon hide" style="width: 180%; display: none;">
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
                        <li class="drop-down-option">
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
                    <a href="<?php echo $_SERVER['REDIRECT_URL'] . '?' . implode('&', $gets1); ?>" class=""> <i class="myaccount"></i> Выбор звёзд</a>
                </li>
            </ul>
            <?php
            $count_product = count($products);
            if($count_product > 0)
            {
            ?>
            <div class="flr"><?php echo $pagination; ?></div>
            <div class="fix"></div>
            <div class="pro-list">
                <ul class="row">
                    <?php
                $product_ids = array();
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
                    $product_ids[] = $product_id;
                    $cover_image = Product::instance($product_id, LANGUAGE)->cover_image();
                    $product_inf = Product::instance($product_id, LANGUAGE)->get();
                    $search = array('product_id' => $product_id);
                    $plink = Product::instance($product_id, LANGUAGE)->permalink();
                    ?>
                    <li class="pro-item col-xs-6 col-sm-3">
                        <?php
                        if($i >= 20)
                        {
                        ?>
                            <div class="overlay"></div>
                            <div class="pic">
                                <a href="<?php echo $plink; ?>">
                                    <div class="pic1"><img data-original="<?php echo Image::link($cover_image, 1); ?>" src="/assets/images/loading.gif" alt="<?php echo $product_inf['name']; ?>" title="<?php echo $product_inf['name']; ?>" /></div>
                                </a>
                            </div>
                        <?php
                        }
                        else
                        {
                            ?>
                            <!-- <div class="overlay"></div> -->
                            <div class="pic">
                                <a href="<?php echo $plink; ?>">
                                <div class="pic1"><img src="<?php echo Image::link($cover_image, 1); ?>" alt="<?php echo $product_inf['name']; ?>" title="<?php echo $product_inf['name']; ?>" /></div>
                                </a>
                                <?php if($in_same){ ?>
                                    <a href="<?php echo $plink; ?>"><span class="icon-color" title="More Colors"></span></a>
                                <?php } ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="title">
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
                        </div>
                        <p class="price">
                            <?php
                            $orig_price = round($product_inf['price'], 2);
                            $price = round(Product::instance($product_id, LANGUAGE)->price(), 2);
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
                                <span class="pricenow"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                <?php
                            }
                            ?>
                        </p>
                        <div class="star" id="star_<?php echo $product_id; ?>">
                        
                        </div>
                        <?php if ($product_inf['type'] != 0): ?>
                            <a href="#" id="<?php echo $product_id; ?>" class="JS-popwinbtn quick_view"><span class="btn-qv">Бстрый посмотр</span></a>
                        <?php endif; ?>
                        <div class="add-wish">
                        <a class="add_to_wishlist" data-product="<?php echo $product_id; ?>">
                            <span class="wish-title">Добавить в избранное</span>
                            <i class="fa fa-heart add_wishlist" id="wish_<?php echo $product_id; ?>"></i>
                        </a>
                        </div>
                        <div class="sign-warp">
                            <span class="sign-close">
                                <i class="fa fa-times-circle fa-lg"></i>
                            </span>
                            <div class="wishlist_success">
                                <p class="text" style="border:none;"></p>
                                <p class="wish"><i class="fa fa-heart"></i>Избранное</p>
                            </div>
                        </div>
                        <?php
                        if ($secondhalf):
                            $restrict = unserialize($secondhalf);
                            $has = DB::query(Database::SELECT, 'SELECT id FROM catalog_products WHERE product_id = ' . $product_id . ' AND catalog_id IN (' . $restrict['restrict_catalog'] . ')')->execute()->get('id');
                            if ($has):
                                ?>
                                <div style="height: 16px;background:#ff3333;color:#fff;font-family: Century Gothic;font-size: 12px;text-align: center;">
                                    BUY 1 GET 2nd HALF PRICE
                                </div>
                                <?php
                            endif;
                        endif;
                        ?>

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
                            echo '<span class="outstock">INDISPONIBLE</span>';
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
            <div class="font18 mt20">РЕКОМЕНДУЕМЫЕ ТОВАРЫ</div>
            <div class="hide-box1_2">
                <ul class="cf">
                <?php
                $hots = array();
        if(isset($catalog_id)){
                $hots = DB::query(Database::SELECT, 'SELECT P.id, P.link FROM products P LEFT JOIN catalog_products C ON P.id = C.product_id WHERE C.catalog_id = ' . $catalog_id . ' AND P.visibility = 1 AND P.status = 1 AND stock <> 0 ORDER BY P.hits DESC LIMIT 0, 6')->execute();
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
            }
                ?>
                </ul>
            </div>
            <?php
        }
        ?>
        <div class="clearfix"></div>
        <div class="other-customers" id="alsoview" style="display:none;">
            <div class="w-tit">
                <h2>РЕКОМЕНДУЕМЫЕ ТОВАРЫ</h2>
            </div>
            <div class="box-dibu1">
            <!-- Template for rendering recommendations -->
            <script type="text/html" id="simple-tmpl" >
            <![CDATA[
            {{ for (var i=0; i < SC.page.products.length; i++) { }}
                {{ if(i==0){ }}
                <div class="hide-box1-0"><ul>
                {{ }else if(i%7==0){ }}
                <div class="hide-box1-{{= i/7 }} hide"><ul>
                {{ } }}
              {{ var p = SC.page.products[i]; }}
              <li data-scarabitem="{{= p.id }}" style="display: inline-block" class="rec-item">
                 <a href="{{=p.link}}">
                  <img src="{{=p.image}}" class="rec-image">
                </a>
                <p class="price"><b>${{=p.price}}</b></p>
              </li>
                {{ if(i==6 || i==13 || i==20 || i==27){ }}
                </ul></div>
                {{ } }}
            {{ } }}
            ]]>
            </script>
            <div id="personal-recs"></div>
            <script type="text/javascript">
            // Request personalized recommendations.
            Cart = (function() {
            var cart = [];
            var render = function() {
                ScarabQueue.push(['cart', cart]);
                ScarabQueue.push(['recommend', {
                    logic: 'CART',
                    limit: 28,
                    containerId: 'personal-recs',
                    templateId: 'simple-tmpl',
                    success: function(SC, render) {
                        SC.basket = cart;
                        if(SC.page.products.length>0){
                        keyone = Math.ceil(SC.page.products.length/7);
                        for (var j=keyone; j <= 4; j++) {
                           $("#circle"+j).hide(); 
                        }
                        render(SC);
                        $("#alsoview").show();
                        }else{
                            $("#alsoview").hide();
                        }
                    }
                }]);
             
            };
            return {
                render: render,
                add: function(itemId, price) {
                    cart.push({item: itemId, price: price, quantity: 1});
                    render();
                },
                remove: function(itemId) {
                    cart = cart.filter(function(e) {
                      return e.item !== itemId;
                    });
                    render();
                } 
            };
            }());
            Cart.render();
            </script>  
                <div class="box-current" id="JS-current1">
                  <ul>
                    <li class="on"></li>
                    <li id="circle1"></li>
                    <li id="circle2"></li>
                    <li id="circle3"></li>
                  </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo View::factory(LANGPATH . '/quickview'); ?>

<!-- JS-popwincon1 -->
<div class="JS-popwincon1 popwincon w_signup hide">
    <a class="JS-close2 close-btn3"></a>
    <?php echo View::factory('/customer/ajax_login'); ?>
</div>

<script type="text/javascript">
    $(function(){
        $(".add_to_wishlist").live('click', function(){
            var pid = $(this).attr('data-product');
            var _proItem = $(this).parents(".pro-item");
            $.ajax({
                url:'/customer/ajax_login1',
                type:'POST',
                dataType:'json',
                data:{},
                success:function(res){
                    if(res != 0)
                    {
                        $.ajax({
                            url:'<?php echo LANGPATH; ?>/wishlist/ajax_add',
                            type:'POST',
                            dataType: "json",
                            data:{
                                product_id: pid,
                            },
                            success:function(result){
                                if(result.success)
                                {
                                    $("#wish_" + pid).parent().find('span').text('');
                                    $("#wish_" + pid).attr('class', 'fa fa-heart red')
                                    _proItem.find(".overlay").show();
                                    _proItem.find(".sign-warp").show();
                                    _proItem.find('.sign-warp').find('.wishlist_success').find('.text').text(result.message);
                                }
                                else
                                {
                                    alert(result.message);
                                }
                            }
                        });
                    }
                    else
                    {
                        $("#customer_pid").text(pid);
                        var top = getScrollTop();
                        top = top - 35;
                        $('body').append('<div class="JS-filter1 opacity"></div>');
                        $('.JS-popwincon1').css({
                            "top": top, 
                            "position": 'absolute'
                        });
                        $('.JS-popwincon1').appendTo('body').fadeIn(320);
                        $('.JS-popwincon1').show();
                    }
                }
            });
            return false;
        })

        $(".pro-item .add-wish .red").live('click', function() {
            return false;
        });

        $("#form_login").submit(function(){
            var email = $("#email1").val();
            var password = $("#password1").val();
            var remember_me = 'on';
            if(typeof($("#remember_me1").attr('checked')) == 'undefined')
                remember_me = '';
            var pid = $("#customer_pid").text();
            $.ajax({
                url:'<?php echo LANGPATH; ?>/customer/ajax_login',
                type:'POST',
                dataType: "json",
                data:{
                    email: email,
                    password: password,
                    remember_me: remember_me,
                },
                success:function(rs){
                    if(rs.success)
                    {
                        $.ajax({
                            url:'<?php echo LANGPATH; ?>/wishlist/ajax_add',
                            type:'POST',
                            dataType: "json",
                            data:{
                                product_id: pid,
                            },
                            success:function(result){
                                if(result.success == 1)
                                {
                                    alert(result.message);
                                    $("#wish_" + pid).parent().find('span').text('');
                                    $("#wish_" + pid).attr('class', 'fa fa-heart red');
                                    $(".wishlist_success").show();
                                    $(".JS-filter1").remove();
                                    $(".JS-popwincon1").fadeOut(160);
                                    $(".overlay").hide();
                                    $(".sign-warp").hide();
                                }
                                else
                                {
                                    alert(result.message);
                                }
                            }
                        });
                        return false;
                    }
                    else
                    {
                        alert(rs.message);
                    }
                }
            });
            return false;
        })

        $("#form_register").submit(function(){
            var email = $("#email2").val();
            var password = $("#password2").val();
            var password_confirm = $("#password_confirm").val();
            var remember_me = 'on';
            if(typeof($("#remember_me2").attr('checked')) == 'undefined')
                remember_me = '';
            var pid = $("#customer_pid").text();
            $.ajax({
                url:'<?php echo LANGPATH; ?>/customer/ajax_register',
                type:'POST',
                dataType: "json",
                data:{
                    email: email,
                    password: password,
                    confirm_password: password_confirm,
                    remember_me: remember_me,
                },
                success:function(rs){
                    if(rs.success)
                    {
                        $.ajax({
                            url:'<?php echo LANGPATH; ?>/wishlist/ajax_add',
                            type:'POST',
                            dataType: "json",
                            data:{
                                product_id: pid,
                            },
                            success:function(result){
                                if(result.success == 1)
                                {
                                    alert(result.message);
                                    $("#wish_" + pid).parent().find('span').text('');
                                    $("#wish_" + pid).attr('class', 'fa fa-heart red');
                                    $(".wishlist_success").show();
                                    $(".JS_filter2").remove();
                                    $(".JS-popwincon2").fadeOut(160);
                                    $(".overlay").hide();
                                    $(".sign-warp").hide();
                                }
                                else
                                {
                                    alert(result.message);
                                }
                            }
                        });
                        return false;
                    }
                    else
                    {
                        alert(rs.message);
                    }
                }
            });
            return false;
        })

        //close wihlist_success
        $(".sign-close").click(function(){
            $(this).parent().hide();
        })

        //ajax wishlists
        $.ajax({
            type: "POST",
            url: "/ajax/wishlist_data",
            dataType: "json",
            data: "product_ids=<?php echo !empty($product_ids) ? implode(',', $product_ids) : ''; ?>",
            success: function(res){
                for(var p in res){
                    var pid = res[p];
                    $("#wish_"+pid).removeClass('add_wishlist');
                    $("#wish_"+pid).addClass('red');
                    $("#wish_"+pid).parent().find('.wish-title').remove();
                }
            }
        });

        //ajax reviews
        $.ajax({
            type: "POST",
            url: "/ajax/review_data",
            dataType: "json",
            data: "product_ids=<?php echo !empty($product_ids) ? implode(',', $product_ids) : ''; ?>",
            success: function(res){
                for(var p in res){
                    var review = res[p];
                    var rating = parseFloat(review['rating']);
                    var integer = parseInt(review['rating']);
                    var decimal = rating - integer;
                    var div = '<div class="reviews">';
                    div += '<a href="' + review['plink'] + '#review_list">';
                    for(var r = 1;r <= integer;r ++)
                    {
                        div += '<i class="fa fa-star"></i>';
                    }
                    if(decimal > 0)
                    {
                        div += '<i class="fa fa-star-half-full"></i>';
                    }
                    div += '(' + review['quantity'] + ')';
                    div += '</a>';
                    div += '</div>';
                    $("#star_" + review['product_id']).html(div);
                }
            }
        });

    })

    function getScrollTop() {
        var scrollPos;
        if (window.pageYOffset) {
            scrollPos = window.pageYOffset;
        } else if (document.compatMode && document.compatMode != 'BackCompat') {
            scrollPos = document.documentElement.scrollTop;
        } else if (document.body) {
            scrollPos = document.body.scrollTop;
        }
        return scrollPos;
    }
</script>

<script type="text/javascript">
    var google_tag_params = {
        ecomm_prodid: '',           //SKU
        ecomm_pagetype: 'category',         // product
        ecomm_totalvalue: ''       // 
    };
</script>
<!-- lazyload -->
<script type="text/javascript" charset="utf-8" src="/assets/js/lazyload.js"></script>