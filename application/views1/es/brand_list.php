<div class="site-content">
    <div class="main-container clearfix">
        <div class="container">
            <div class="crumbs">
                <div class="fll">
                    <a href="<?php echo LANGPATH; ?>/" class="home">home</a>&gt; <span><?php echo $brands['name']; ?>
                </div>
            </div>
            <!-- aside -->
			<div class="list-main">
            <div class="filter-right" style="width: 100%;">
                <div class="filter-bar">
                    <ul class="bar-r">
                        <li class=" item-r pick">
                    <?php
                    $gets = isset($gets) ? $gets : array();
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
                    <a href="<?php echo isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : '' . '?' . implode('&', $gets1); ?>" class=""> <i class="myaccount"></i> Elección de Celebridad</a>
                </li>
            <li class=" drop-down JS-show">
                            <span class="fll">Ordenar por:&nbsp;</span>
                            <div class="drop-down-hd">
                                <?php
                                $getsort = '';
                                if(isset($_GET['sort']))
                                {
                                    $getsort = $_GET['sort'];                    
                                }

                                if(array_key_exists($getsort, $sorts))
                                {
                                    echo isset($getsort) ? $sorts[$getsort]['name'] : 'Default';
                                }
                                else
                                {
                                    echo 'Default';
                                }
                                ?>
                                <i class="fa fa-angle-down"></i>
                            </div>
                            <ul class="drop-down-list JS-showcon hide" style="display:none; width:110%;">
                                <?php
                                foreach($gets1 as $k => $g)
                                {
                                    if (strpos($g, 'sort') !== FALSE || strpos($g, 'pick') !== FALSE)
                                        unset($gets1[$k]);
                                }
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
                                        <a href="<?php echo $tolink; ?>"><?php echo $sort['name']; ?></a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
					</ul>
				</div>
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
                $key = 'site_restrictions_choies';
                $cache = Cache::instance('memcache');
                if (!($secondhalf = $cache->get($key)))
                {
                    $secondhalf = DB::select('restrictions')
                        ->from('carts_cpromotions')
                        ->where('actions', '=', 'a:1:{s:6:"action";s:10:"secondhalf";}')
                        ->and_where('is_active', '=', 1)
                        ->and_where('to_date', '>', time())
                        ->execute()->get('restrictions');  
                    if($secondhalf && $secondhalf !=1)
                    {
                        $cache->set($key, $secondhalf, 86400);
                    }
                    else
                    {
                        $cache->set($key, 1, 86400);             
                    }
                }
                foreach($products as $i => $product)
                {
                    $product_id = $product['id'];
                    $product_ids[] = $product_id;
                    $cover_image = Product::instance($product_id)->cover_image();
                    $product_inf = Product::instance($product_id)->get();
                    $search = array('product_id' => $product_id);
                    $plink = Product::instance($product_id ,LANGUAGE)->permalink();
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
                                <span class="pricenow"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                <?php
                            }
                            ?>
                        </p>
                        <div class="star" id="star_<?php echo $product_id; ?>">
                        
                        </div>
                        <?php if ($product_inf['type'] != 0): ?>
                            <a href="#" id="<?php echo $product_id; ?>" attr-lang="<?php echo LANGUAGE; ?>" class="JS-popwinbtn quick_view" data-reveal-id="myModal"><span class="btn-qv">VISTA RÁPIDA</span></a>
                        <?php endif; ?>
                        <div class="add-wish">
                        <a class="add_to_wishlist" data-product="<?php echo $product_id; ?>">
                            <span class="wish-title">AÑADIR A SU LISTA DE DESEOS</span>
                            <i class="fa fa-heart add_wishlist" id="wish_<?php echo $product_id; ?>"></i>
                        </a>
                        </div>
                        <div class="sign-warp">
                            <span class="sign-close">
                                <i class="fa fa-times-circle fa-lg"></i>
                            </span>
                            <div class="wishlist_success">
                                <p class="text" style="border:none;"></p>
                                <p class="wish"><i class="fa fa-heart"></i>Lista De Deseos</p>
                            </div>
                        </div>
                        <?php
                        if ($secondhalf && $secondhalf !=1):
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
                            echo '<span class="outstock">Fuera de Stock</span>';
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
            <div class="font18 mt20">Lo siento, no se encuentra ningún resultado. Échale un vistazo a nuestros productos recomendados:</div>
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
                        <a href="<?php echo LANGPATH; ?>/product/<?php echo $pdetail['link'] . '_p' . $pdetail['id']; ?>">
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
            <div class="w-tit"><h2>PRODUCTOS RECOMENDADOS</h2></div>
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
                         <a href="{{=p.plink}}" id="em{{= p.id }}link">
                          <img src="{{=p.image}}" class="rec-image">
                        </a>
                        <p class="price"><b id="em{{= p.id }}price">${{=p.price}}</b></p>
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
                ScarabQueue.push(['recommend', {
                    logic: 'RELATED',
                    limit: 28,
                    containerId: 'personal-recs',
                    templateId: 'simple-tmpl',
                    success: function(SC, render) {
                        var psku="";
                        for (var i = 0, l = SC.page.products.length; i < l; i++) {
                            var product = SC.page.products[i]; 
                            psku+=product.id+",";
                        }
                        var pdata=[];
                        var phone_scare = '';
                        var num = 0;
                        render(SC);
                        $.ajax({
                                type: "POST",
                                url: "/site/emarsysdata?page=product",
                                dataType: "json",
                                data:"sku="+psku+"&lang=<?php echo LANGUAGE; ?>",
                                success: function(data){
                                    for(var o in data){
                                        $("#em"+o+"link").attr("href",data[o]["link"]);
                                        $("#em"+o+"price").html(data[o]["price"]);
                                        if(data[o]["show"]==0 || typeof(data[o]["link"]) == "undefined"){
                                            $("#em"+o).css('display','none');
                                        }
                                        else
                                        {
                                            num ++;
                                            if(num <= 12)
                                            {
                                                phone_scare = '\
                                                <li class="col-xs-6">\
                                                    <a href="' + data[o]['link'] + '">\
                                                        <img src="' + data[o]['cover_image'] + '">\
                                                        <p class="price">' + data[o]['price'] + '</p>\
                                                    </a>\
                                                </li>\
                                                ';
                                                $("#phone_scare").append(phone_scare);
                                            }
                                        }
                                    }
                                }
                        });
                        
                        if(SC.page.products.length>0){
                            keyone = Math.ceil(SC.page.products.length/7);
                            for (var j=keyone; j <= 4; j++) {
                               $("#circle"+j).hide(); 
                            }
                            if(winWidth > 768)
                                $("#alsoview").show();
                        }else{
                            $("#alsoview").hide();
                        }
                    }
                }]);
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
        <div class="index-fashion buyers-show">
            <div class="phone-fashion-top w-tit">
                <h2>PRODUCTOS RECOMENDADOS</h2>
            </div>
            <div class="flash-sale">
                <ul class="row" id="phone_scare"></ul>
            </div>  
        </div>
    </div>
</div>

<?php echo View::factory(LANGPATH . '/quickview'); ?>

<!-- JS-popwincon1 -->
<div class="JS-popwincon1 popwincon w_signup hide">
    <a class="JS-close2 close-btn3"></a>
    <?php echo View::factory(LANGPATH . '/customer/ajax_login'); ?>
</div>

<script type="text/javascript">
    $(function(){
        $(".add_to_wishlist").live('click', function(){
            var pid = $(this).attr('data-product');
            var _proItem = $(this).parents(".pro-item");
            $.ajax({
                url:'<?php echo LANGPATH; ?>/customer/ajax_login1',
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