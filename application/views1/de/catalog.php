<link rel="canonical" href="<?php echo LANGPATH; ?>/<?php $catalog_link = $catalog->get('link'); echo $catalog_link; ?>" />
<link type="text/css" rel="stylesheet" href="<?php echo LANGPATH; ?>/css/quickview.css" media="all" />
<?php
$gets = array();
$gets1 = array();
foreach ($_GET as $key => $val)
{
    if ($key == 'limit')
        $gets[] = 'limit=' . $val;
    if ($key == 'pick')
        $gets[] = 'pick=' . $val;
    $gets1 = $gets;
    if ($key == 'sort')
    {
        $gets[] = 'sort=' . $val;
    }
}
?>
<script type="text/javascript">
    function tolink()
    {
        var sort = $("#filter").val();
        var link = "<?php echo empty($gets1) ? '' : '?' . implode('&', $gets1); ?>";
        if(link == "")
        {
            var tolink = link + '?sort=' + sort;
        }
        else
        {
            var tolink = link + '&sort=' + sort;
        }
        location.href = '<?php echo $_SERVER['REDIRECT_URL']; ?>' + tolink;
        return false;
    }
</script>

<?php
$name = $catalog->get('name');
if ($catalog_link == 'daily-new')
{
    $today = strtotime('midnight') - 50400;
    $uri = $_SERVER['REQUEST_URI'];
    $uriArr = explode('/', $uri);
    if (!isset($uriArr[3]))
    {
        $to = $today + 86400;
        $from = strtotime('-1 day', $to);
    }
    else
    {
        $to = $today - $uriArr[3] * 86400 + 86400;
        $from = strtotime('-1 day', $to);
    }
    $name = date('Y-m-d', $to - 1);
}
?>
<!-- main begin -->
<section id="main">
    <!-- index_free begin -->
    <div class="w_index_free">
        <div class="layout index_free">
            <a href="<?php echo LANGPATH; ?>/shipping-delivery" class="a1">WELTWEIT VERSANDKOSTENFREI</a>
            <a href="<?php echo LANGPATH; ?>/customer/login" class="a2">15% SPAREN BEI ERSTER BESTELLUNG</a>
            <a href="<?php echo LANGPATH; ?>/daily-new" class="a3">NEUHEITEN 10% RABATT</a>
        </div>
    </div>
        
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll">
                <a href="<?php echo LANGPATH; ?>/" class="home">Homepage</a> 
                <?php
                $crumbs = $catalog->crumbs();
                foreach ($crumbs as $key => $crumb):
                    ?>
                    <?php if ($key != count($catalog->crumbs()) - 1): ?>
                        &gt;<span><a href="<?php echo $crumb['link']; ?>" rel="nofollow" ><?php echo $crumb['name']; ?></a>
                        <?php else: ?>
                            &gt;<span><?php echo $name; ?></span>
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
            <?php
            if (count($top_sellers) >= 5 && count($new_arrvals) >= 5)
                $show = 3;
            elseif (count($top_sellers) >= 5)
                $show = 1;
            elseif (count($new_arrvals) >= 5)
                $show = 2;
            else
                $show = 0;
            ?>
            <?php
            if ($show)
            {
                ?>
                <ul class="JS_tab3 detail_tab hotnew_box fix" style="margin-top:0;">
                    <?php
                    if ($show == 1)
                        echo '<li class="on">HEIßE AUSWAHL</li>';
                    elseif ($show == 2)
                        echo '<li class="on">New Arrivals</li>';
                    elseif ($show == 3)
                        echo '<li class="on">HEIßE AUSWAHL</li><li>New Arrivals</li>';
                    ?>
                </ul>
                <div class="JS_tabcon3 detail_tabcon hotnew_boxcon mb25">
                    <?php
                    if ($show == 1 || $show == 3)
                    {
                        ?>
                        <div class="bd">
                            <div class="JS_carousel4 pro_listcon product_carousel">
                                <ul class="fix">
                                    <?php
                                    foreach ($top_sellers as $top)
                                    {
                                        $top_product = Product::instance($top, LANGUAGE);
                                        ?>
                                        <li>
                                            <a href="<?php echo $top_product->permalink(); ?>"><img src="<?php echo Image::link($top_product->cover_image(), 1); ?>" /></a>
                                            <a href="<?php echo $top_product->permalink(); ?>" class="name"><?php echo $top_product->get('name'); ?></a>
                                            <p class="price fix">
                                                <?php
                                                $orig_price = round($top_product->get('price'), 2);
                                                $price = round($top_product->price(), 2);
                                                if ($orig_price > $price)
                                                {
                                                    ?>
                                                    <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del><span class="red"><b><?php echo Site::instance()->price($price, 'code_view'); ?></b></span>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <span class="red font14"><b><?php echo Site::instance()->price($price, 'code_view'); ?></b></span>
                                                    <?php
                                                }
                                                ?>
                                            </p>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                                <span class="prev4 JS_prev4"></span>
                                <span class="next4 JS_next4"></span>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if ($show == 2 || $show == 3)
                    {
                        ?>
                        <div class="bd no2">
                            <div class="JS_carousel5 pro_listcon product_carousel">
                                <ul class="fix">
                                    <?php
                                    foreach ($new_arrvals as $new)
                                    {
                                        $new_product = Product::instance($new, LANGUAGE);
                                        ?>
                                        <li>
                                            <a href="<?php echo $new_product->permalink(); ?>"><img src="<?php echo Image::link($new_product->cover_image(), 1); ?>" /></a>
                                            <a href="<?php echo $new_product->permalink(); ?>" class="name"><?php echo $new_product->get('name'); ?></a>
                                            <p class="price fix">
                                                <?php
                                                $orig_price = round($new_product->get('price'), 2);
                                                $price = round($new_product->price(), 2);
                                                if ($orig_price > $price)
                                                {
                                                    ?>
                                                    <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del><span class="red font14">NOW <b><?php echo Site::instance()->price($price, 'code_view'); ?></b></span>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <span class="red font14"><b><?php echo Site::instance()->price($price, 'code_view'); ?></b></span>
                                                    <?php
                                                }
                                                ?>
                                            </p>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                                <span class="prev4 JS_prev5"></span>
                                <span class="next4 JS_next5"></span>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            ?>
            <?php
            if (1)
            {
                if (in_array($catalog_link, array('outlet', '2014-summer-sale', 'usd20', 'usd30', 'usd40')))
                {
                    ?>
                    <div class="mb25 newin_banner">
                        <img src="<?php echo STATICURL; ?>/ximg/sale_banner.jpg" />
                        <ul class="sale_">
                            <li class="sale_1"><a target="_blank" href="<?php echo LANGPATH; ?>/2014-summer-sale?0814"></a></li>
                            <li class="sale_2"><a target="_blank" href="<?php echo LANGPATH; ?>/usd20"></a></li>
                            <li class="sale_3"><a target="_blank" href="<?php echo LANGPATH; ?>/usd30"></a></li>
                            <li class="sale_4"><a target="_blank" href="<?php echo LANGPATH; ?>/usd40"></a></li>
                        </ul>
                    </div>
                    <?php
                }
                elseif ($catalog_link == 'daily-new')
                {
                    $image_src = $catalog->get('image_src');
                    if ($image_src)
                    {
                        ?>
                        <div class="newin_banner">
                            <img src="/simages/<?php echo $image_src; ?>" />
                            <ul class="con fix">
                                <?php
                                for ($i = 0; $i < 10; $i++):
                                    $day = $today - $i * 86400 + 86400;
                                    $on = 0;
                                    if (isset($uriArr[3]) AND $uriArr[3] == $i)
                                        $on = 1;
                                    elseif (!isset($uriArr[3]) AND $i == 0)
                                        $on = 1;
                                    ?>
                                    <li <?php echo $on ? 'class="on"' : ''; ?>><a href="<?php echo LANGPATH; ?>/daily-new/<?php echo $i ? $i : ''; ?>"><?php echo date('m.d', $day); ?></a></li>
                                    <?php
                                endfor;
                                ?>
                            </ul>
                        </div>
                        <?php
                    }
                }
                elseif ($catalog_link == 'happy-lady-show')
                {
                    ?>
                    <div class="banner" id="banner">
                        <div class="ibanner layout" style="height:400px;">
                            <ul class="bannerPic">
                                <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/805-400-1.jpg" alt="" /></a></li>
                                <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/805-400-2.jpg" alt="" /></a></li>
                                <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/805-400-3.jpg" alt="" /></a></li>
                            </ul>
                            <div class="banner_lr">
                                <button class="previous prev1"></button>
                                <button class="next next1"></button>
                            </div>
                        </div>
                    </div>
                    <script>
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
                    <?php
                }
                else
                {
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
                                <img src="/simages/<?php echo $image_src; ?>" alt="<?php echo $catalog->get('image_alt'); ?>" usemap="#<?php echo $map; ?>" />
                            </a>
                        </p>
                        <?php
                        if ($map)
                        {
                            echo '<map name="' . $map . '" id="' . $map . '">' . $image_map . '</map>';
                        }
                    endif;
                }
            }
            ?>
            <section class="pro_list">
                <!-- filter_page -->
                <article class="filter_page">
                    <ul class="select fix">
                        <li class="wdrop">
                            <select class="select_style" id="filter" onchange="tolink();">
                                <?php
                                foreach ($sorts as $key => $sort):
                                    $ens = array("What's New", 'Best Seller', 'Price: Low To High', 'Price: High To Low');
                                    $trns = array('Was ist NEU', 'Bestseller', 'Preis: Niedrig zu Hoch', 'Preis: Hoch zu Niedrig');
                                    $sname = str_replace($ens, $trns, $sort['name']);
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php if (isset($_GET['sort']) AND (int) $_GET['sort'] == $key) echo 'selected'; ?>><?php echo $sname; ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </li>
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
                        <span><a class="icon_pick" href="<?php echo $_SERVER['REDIRECT_URL'] . '?' . implode('&', $gets1); ?>" title="Wahl der Berühmtheit"></a></span>
                        <li class="last">
                            <?php
                            echo $pagination;
                            ?>
                        </li>
                    </ul>
                    <div class="results_box fix">
                        <?php
                        $limit_link = '';
                        if (!empty($gets))
                            $limit_link = '?' . implode('&', $gets);
                        $uri = $_SERVER['REDIRECT_URL'];
                        $language = Request::Instance()->param('language');
                        if ($language)
                        {
                            $uri = substr($uri, strpos($uri, $language, 0) + strlen($language));
                        }
                        $uris = explode('/', $uri);
                        unset($custom_filter['sql']);
                        if (!empty($custom_filter)):
                            ?>
                            <ul class="left">
                                <?php
                                if (isset($custom_filter['price_range']))
                                {
                                    $href = LANGPATH . $uris[0] . '/' . $uris[1] . '/' . $uris[2] . '/all';
                                    if (isset($uris[4]))
                                        $href .= '/' . $uris[4];
                                    echo '<li><a href="' . $href . $limit_link . '"><span class="select">Price:$' . $custom_filter['price_range'][0] . ' ~ $' . $custom_filter['price_range'][1] . '</span></a></li>';
                                }
                                if (isset($custom_filter['filter_attirbutes']))
                                {
                                    foreach ($custom_filter['filter_attirbutes'] as $filter)
                                    {
                                        $href = LANGPATH . $uris[0] . '/' . $uris[1] . '/' . $uris[2] . '/' . $uris[3];
                                        $filterArr = explode('__', $filters);
                                        foreach ($filterArr as $key => $f)
                                        {
                                            $fil = str_replace(' ', '-', $filter);
                                            if (strpos($f, $fil) != FALSE)
                                                unset($filterArr[$key]);
                                        }
                                        $filterName = DB::select(LANGUAGE)->from('attributes_small')->where('attribute_id', '=', $filter)->execute()->get('name');
                                        if(!$filterName)
                                            $filterName = DB::select('name')->from('attributes')->where('id', '=', $filter)->execute()->get('name');
                                        $href .= '/' . implode('__', $filterArr);
                                        echo '<li><a href="' . $href . $limit_link . '"><span class="select">' . ucfirst($filterName) . '</span></a></li>';
                                    }
                                }
                                ?>
                            </ul>
                            <a href="<?php echo LANGPATH . $uris[0] . '/' . $uris[1] . '/' . $uris[2]; ?>"><span class="clearall flr">Alle Löschen</span></a>
                            <?php
                        endif;
                        ?>
                    </div>
                </article>
                    
                <!-- pro_listcon -->
                <article class="pro_listcon">
                    <ul class="fix">
                        <?php
                        $lang_table = LANGUAGE ? '_' . LANGUAGE : '';
                        $_limit = count($products) >= $limit ? $limit : count($products);
                        for ($i = 0; $i < $_limit; $i++):
                            $product_id = $products[$i];
                            $images = Product::instance($product_id, LANGUAGE)->images();
                            $product_inf = DB::select('type', 'name', 'price', 'has_pick', 'status', 'stock', 'display_date')
                                    ->from('products' . $lang_table)
                                    ->where('id', '=', $product_id)
                                    ->execute()->current();
                            ?>
                            <li class="JS_shows_btn1">
                                <?php
                                if($i >= 20)
                                {
                                ?>
                                    <div class="pic">
                                        <a href="<?php echo Product::instance($product_id,  ,LANGUAGE)->permalink(); ?>">
                                            <div class="pic1"><img data-original="http://img3.choies.com/pimg/192/<?php echo $images[0]['id'].'.'.$images[0]['suffix']; ?>" src="/assets/images/loading.gif" alt="<?php echo 'Fashion ' . $catalog->get('name'); ?>" title="<?php echo $product_inf['name']; ?>" /></div>
                                            <?php
                                            if (isset($images[1]))
                                            {
                                                ?>
                                                <div class="pic2" style="display:none;"><img data-original="http://img2.choies.com/pimg/192/<?php echo $images[1]['id'].'.'.$images[1]['suffix']; ?>" src="/assets/images/loading.gif" alt="<?php echo 'Fashion ' . $catalog->get('name'); ?>" title="<?php echo $product_inf['name']; ?>" /></div>
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
                                        <a href="<?php echo Product::instance($product_id,  ,LANGUAGE)->permalink(); ?>">
                                            <div class="pic1"><img src="http://img1.choies.com/pimg/192/<?php echo $images[0]['id'].'.'.$images[0]['suffix']; ?>" alt="<?php echo 'Fashion ' . $catalog->get('name'); ?>" title="<?php echo $product_inf['name']; ?>" /></div>
                                            <?php
                                            if (isset($images[1]))
                                            {
                                                ?>
                                                <div class="pic2" style="display:none;"><img src="http://img2.choies.com/pimg/192/<?php echo $images[1]['id'].'.'.$images[1]['suffix']; ?>" alt="<?php echo 'Fashion ' . $catalog->get('name'); ?>" title="<?php echo $product_inf['name']; ?>" /></div>
                                                <?php
                                            }
                                            ?>
                                        </a>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php if ($product_inf['type'] != 0): ?>
                                    <a href="#" id="<?php echo $product_id; ?>" class="quick_view JS_shows1 hide">SCHNELLANSICHT</a>
                                <?php endif; ?>
                                <a class="name" href="<?php echo Product::instance($product_id,  ,LANGUAGE)->permalink(); ?>"><?php echo $product_inf['name']; ?></a>
                                <p class="price fix">
                                    <?php
                                    $orig_price = round($product_inf['price'], 2);
                                    $price = round(Product::instance($product_id, LANGUAGE)->price(), 2);
                                    if ($orig_price > $price)
                                    {
                                        $off = (int) (round(($orig_price - $price) / $orig_price, 2) * 100);
                                        ?>
                                        <b><?php echo Site::instance()->price($price, 'code_view'); ?></b>    <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del>
                                        <br/><span class="off"><?php echo $off; ?>% Rabatt</span>
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
                                    <?php
                                    }
                                    ?>
                                </p>
                                <?php
                                $onsale = 1;
                                if ($product_inf['status'] == 0)
                                    $onsale = 0;
                                else
                                {
                                    if($product_inf['stock'] == 0)
                                        $onsale = 0;
                                    elseif($product_inf['stock'] == -1)
                                    {
                                        $stocks = DB::select(DB::expr('SUM(stocks) AS sum'))
                                            ->from('products_stocks')
                                            ->where('product_id', '=', $product_id)
                                            ->where('attributes', '<>', '')
                                            ->execute()->get('sum');
                                        if(!$stocks)
                                            $onsale = 0;
                                    }
                                }
                                if($onsale == 0)
                                {
                                    echo '<span class="outstock">Nicht Auf Lager</span>';
                                }
                                elseif (round($product_inf['price'], 2) > Product::instance($product_id, LANGUAGE)->price())
                                {
                                    echo '<span class="icon_sale"></span>';
                                }
                                elseif (time() - $product_inf['display_date'] <= 86400 * 14)
                                {
                                    echo '<span class="icon_new"></span>';
                                }
                                ?>
                            </li>
                            <?php
                        endfor;
                        ?>
                    </ul>
                </article>
            </section>
                
            <!-- filter_page -->
            <article class="filter_page">
                <ul class="select fix">
                    <li><a class="icon_pick" href="<?php echo $_SERVER['REDIRECT_URL'] . '?' . implode('&', $gets); ?>">Wahl der Berühmtheit</a></li>
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
        $occasion_dresses = DB::select('id')->from('products_category')->where('name', '=', 'Occasion Dresses')->execute()->get('id');
        if (in_array($catalog_link, array('weekly-new', 'daily-new')) OR $crumbs[0]['id'] == $occasion_dresses)
        {
            echo View::factory(LANGPATH . '/de/catalog_left');
        }
        else
        {
            echo View::factory(LANGPATH . '/de/catalog_left_1')
                ->set('count_products', $count_products)
                ->set('crumbs', $crumbs)
                ->set('custom_filter', $custom_filter)
                ->set('filter_products', $filter_products)
                ->set('pricerang', $pricerang);
        }
        ?>
    </section>
</section>
<?php echo View::factory(LANGPATH . '/de/quickview'); ?>
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
        $('#addCart').live("click",function(){
            var btn_size = $('.btn_size').html();
            var size = $('.s-size').val();
            if(btn_size && !size)
            {
                alert('Bitte ' + $('#select_size').html());
                return false;
            }
        })
        
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
                                <p>Artikel# : '+product[p]['sku']+'</p>\
                                <p>'+product[p]['price']+'</p>\
                                <p>'+product[p]['attributes']+'</p>\
                                <p>Anzahl: '+product[p]['quantity']+'</p>\
                            </div>\
                        <div class="fix"></div>\
                        ';
                    }
                }
                cart_view = cart_view.replace('Size', 'Größe');
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
<?php
$limited = Arr::get($_GET, 'limit', 0);
if($limited == 1)
{
?>
<script type="text/javascript">
    /**
     ************************************************************
     ***@project jquery瀑布流插件
     ***@author hcp0209@gmail.com
     ***@ver version 1.0
     ************************************************************
     */
    (function($){
        var 
        //参数
        setting={
            column_width:204,//列宽
            column_className:'waterfall_column',//列的类名
            column_space:0,//列间距
            cell_selector:'.cell',//要排列的砖块的选择器，context为整个外部容器
            img_selector:'img',//要加载的图片的选择器
            auto_imgHeight:true,//是否需要自动计算图片的高度
            fadein:true,//是否渐显载入
            fadein_speed:600,//渐显速率，单位毫秒
            insert_type:1, //单元格插入方式，1为插入最短那列，2为按序轮流插入
            getResource:function(index){ }  //获取动态资源函数,必须返回一个砖块元素集合,传入参数为加载的次数
        },
        //
        waterfall=$.waterfall={},//对外信息对象
        $container=null;//容器
        waterfall.load_index=0, //加载次数
        $.fn.extend({
            waterfall:function(opt){
                opt=opt||{};  
                setting=$.extend(setting,opt);
                $container=waterfall.$container=$(this);
                waterfall.$columns=creatColumn();
                render($(this).find(setting.cell_selector).detach(),false); //重排已存在元素时强制不渐显
                waterfall._scrollTimer2=null;
                $(window).bind('scroll',function(){
                    clearTimeout(waterfall._scrollTimer2);
                    waterfall._scrollTimer2=setTimeout(onScroll,300);
                });
                waterfall._scrollTimer3=null;
                $(window).bind('resize',function(){
                    clearTimeout(waterfall._scrollTimer3);
                    waterfall._scrollTimer3=setTimeout(onResize,300);
                });
            }
        });
        function creatColumn(){//创建列
            waterfall.column_num=calculateColumns();//列数
            //循环创建列
            var html='';
            for(var i=0;i<waterfall.column_num;i++){
                html+='<div class="'+setting.column_className+'" style="width:'+setting.column_width+'px; display:inline-block; *display:inline;zoom:1; margin-left:'+setting.column_space/2+'px;margin-right:'+setting.column_space/2+'px; vertical-align:top; overflow:hidden"></div>';
            }
            $container.prepend(html);//插入列
            return $('.'+setting.column_className,$container);//列集合
        }
        function calculateColumns(){//计算需要的列数
            var num=Math.floor(($container.innerWidth())/(setting.column_width+setting.column_space));
            if(num<1){ num=1; } //保证至少有一列
            return num;
        }
        function render(elements,fadein){//渲染元素
            if(!$(elements).length) return;//没有元素
            var $columns = waterfall.$columns;
            $(elements).each(function(i){										
                if(!setting.auto_imgHeight||setting.insert_type==2){//如果给出了图片高度，或者是按顺序插入，则不必等图片加载完就能计算列的高度了
                    if(setting.insert_type==1){ 
                        insert($(elements).eq(i),setting.fadein&&fadein);//插入元素
                    }else if(setting.insert_type==2){
                        insert2($(elements).eq(i),i,setting.fadein&&fadein);//插入元素	 
                    }
                    return true;//continue
                }						
                if($(this)[0].nodeName.toLowerCase()=='img'||$(this).find(setting.img_selector).length>0){//本身是图片或含有图片
                    var image=new Image;
                    var src=$(this)[0].nodeName.toLowerCase()=='img'?$(this).attr('src'):$(this).find(setting.img_selector).attr('src');
                    image.onload=function(){//图片加载后才能自动计算出尺寸
                        image.onreadystatechange=null;
                        if(setting.insert_type==1){ 
                            insert($(elements).eq(i),setting.fadein&&fadein);//插入元素
                        }else if(setting.insert_type==2){
                            insert2($(elements).eq(i),i,setting.fadein&&fadein);//插入元素	 
                        }
                        image=null;
                    }
                    image.onreadystatechange=function(){//处理IE等浏览器的缓存问题：图片缓存后不会再触发onload事件
                        if(image.readyState == "complete"){
                            image.onload=null;
                            if(setting.insert_type==1){ 
                                insert($(elements).eq(i),setting.fadein&&fadein);//插入元素
                            }else if(setting.insert_type==2){
                                insert2($(elements).eq(i),i,setting.fadein&&fadein);//插入元素	 
                            }
                            image=null;
                        }
                    }
                    image.src=src;
                }else{//不用考虑图片加载
                    if(setting.insert_type==1){ 
                        insert($(elements).eq(i),setting.fadein&&fadein);//插入元素
                    }else if(setting.insert_type==2){
                        insert2($(elements).eq(i),i,setting.fadein&&fadein);//插入元素	 
                    }
                }						
            });
        }
        function public_render(elems){//ajax得到元素的渲染接口
            render(elems,true);	
        }
        function insert($element,fadein){//把元素插入最短列
            if(fadein){//渐显
                $element.css('opacity',0).appendTo(waterfall.$columns.eq(calculateLowest())).fadeTo(setting.fadein_speed,1);
            }else{//不渐显
                $element.appendTo(waterfall.$columns.eq(calculateLowest()));
            }
        }
        function insert2($element,i,fadein){//按序轮流插入元素
            if(fadein){//渐显
                $element.css('opacity',0).appendTo(waterfall.$columns.eq(i%waterfall.column_num)).fadeTo(setting.fadein_speed,1);
            }else{//不渐显
                $element.appendTo(waterfall.$columns.eq(i%waterfall.column_num));
            }
        }
        function calculateLowest(){//计算最短的那列的索引
            var min=waterfall.$columns.eq(0).outerHeight(),min_key=0;
            waterfall.$columns.each(function(i){						   
                if($(this).outerHeight()<min){
                    min=$(this).outerHeight();
                    min_key=i;
                }							   
            });
            return min_key;
        }
        function getElements(){//获取资源
            $.waterfall.load_index++;
            return setting.getResource($.waterfall.load_index,public_render);
        }
        waterfall._scrollTimer=null;//延迟滚动加载计时器
        function onScroll(){//滚动加载
            clearTimeout(waterfall._scrollTimer);
            waterfall._scrollTimer=setTimeout(function(){
                var $lowest_column=waterfall.$columns.eq(calculateLowest());//最短列
                var bottom=$lowest_column.offset().top+$lowest_column.outerHeight();//最短列底部距离浏览器窗口顶部的距离
                var scrollTop=document.documentElement.scrollTop||document.body.scrollTop||0;//滚动条距离
                var windowHeight=document.documentElement.clientHeight||document.body.clientHeight||0;//窗口高度
                if(scrollTop>=bottom-windowHeight){
                    render(getElements(),true);
                }
            },100);
        }
        function onResize(){//窗口缩放时重新排列
            if(calculateColumns()==waterfall.column_num) return; //列数未改变，不需要重排
            var $cells=waterfall.$container.find(setting.cell_selector);
            waterfall.$columns.remove();
            waterfall.$columns=creatColumn();
            render($cells,false); //重排已有元素时强制不渐显
        }
    })(jQuery);
</script>

<script type="text/javascript">
<?php
$productArr = array();
for ($i = $limit, $j = 0; $i < count($products); $i++, $j++)
{
    $product_id = $products[$i];
    $images = Product::instance($product_id, LANGUAGE)->images();
    $product_inf = DB::select('type','name','price','has_pick','status', 'stock')
        ->from('products' . $lang_table)
        ->where('id', '=', $product_id)
        ->execute()->current();
    if($product_inf['stock'] == -1)
    {
        $stocks = DB::select(DB::expr('SUM(stocks) AS sum'))->from('products_stocks')->where('product_id', '=', $product_id)->execute()->get('sum');
        if(!$stocks)
        {
            $product_inf['status'] = 0;
        }
    }
    $productArr[$j] = array(
        'id' => $product_id,
        'image1' => Image::link($images[0], 1),
        'image2' => isset($images[1]) ? Image::link($images[1], 1) : '',
        'type' => $product_inf['type'],
        'link' => Product::instance($product_id,  ,LANGUAGE)->permalink(),
        'name' => $product_inf['name'],
        'is_sale' => round($product_inf['price'], 2) > round(Product::instance($product_id, LANGUAGE)->price(), 2) ? 1 : 0,
        'r_price' => Site::instance()->price(Product::instance($product_id, LANGUAGE)->price(), 'code_view'),
        'price' => Site::instance()->price($product_inf['price'], 'code_view'),
        'pick' => $product_inf['has_pick'],
        'status' => $product_inf['status']
    );
}
//print_r($productArr);exit;
?>
    var products = new Array();
    var limit = <?php echo $limit; ?>;
    products = <?php echo json_encode($productArr); ?>;
    var page = <?php echo ceil(count($productArr) / $limit); ?>;
    var count = <?php echo count($productArr); ?>;
    var opt={
        getResource:function(index,render){//index为已加载次数,render为渲染接口函数,接受一个dom集合或jquery对象作为参数。通过ajax等异步方法得到的数据可以传入该接口进行渲染，如 render(elem)
            if(index>page) return false;
            var html='';
            for(var i=limit*(index-1);i<limit*(index-1)+limit;i++){
                if(i < count)
                {
                    html+='<li>\
                                                        <div class="pic">\
                                                                <a href="'+products[i]['link']+'">\
                                                                        <img class="pic1" src="'+products[i]['image1']+'" alt="Fashion '+products[i]['name']+'" title="'+products[i]['name']+'" />';
                                                                                            if(products[i]['image2'] != '')
                                                                                            {
                                                                                                html+='<img class="pic2" style="display:none;" src="'+products[i]['image2']+'" alt="Fashion '+products[i]['name']+'" title="'+products[i]['name']+'" /></a>';
                                                                                            }
                        
                                                                                            if(products[i]['type'] != 0)
                                                                                            {
                                                                                                html+='<div><a href="#" id="'+products[i]['id']+'" class="quick_view hide">&nbsp;</a></div>';
                                                                                            }
                                                                                            html+= '</div>\
                                                        <div class="name">\
                                                                <a href="'+products[i]['link']+'">'+products[i]['name']+'</a>\
                                                        </div>\
                                                        <div class="price">';
                        
                                                                                            if(products[i]['is_sale'] == 0)
                                                                                            {
                                                                                                html += '<span class="now">'+products[i]['price']+'</span>';
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                html += '<span class="retail"><del>'+products[i]['price']+'</del></span>\
                                                         <span class="now">'+products[i]['r_price']+'</span>';
                                                                             }
                                                                             if(products[i]['pick'] != 0)
                                                                             {
                                                                                 html += '<span><img src="<?php echo STATICURL; ?>/ximg/lips.png"  alt="Buyers\' Pick"  title="Buyers\' Pick"/></span>';
                                                                             }
                                                                             html += '</div>';
                                                                             if(products[i]['pick'] == 0)
                                                                             {
                                                                                 html += '<div class="outstock"></div>';
                                                                             }
                                                                             else if(products[i]['is_sale'] != 0)
                                                                             {
                                                                                 html += '<div class="sale"></div>';
                                                                             }
                                                                             else
                                                                             {
                                                                                 html += '<div class="new"></div>';
                                                                             }
                                                                             html += '</li>';
                                                                         }
                                                                     }
                                                                     return $(html);
                                                                 },
                                                                 auto_imgHeight:true,
                                                                 insert_type:1
                                                             }
                                                             $('#waterfall .list5 .fix').waterfall(opt);
</script>
<?php
}
?>

<script type="text/javascript">
    var google_tag_params = {
        ecomm_prodid: '',           //SKU
        ecomm_pagetype: 'category',         // product
        ecomm_totalvalue: ''       // 
    };
</script>

<!-- lazyload -->
<script type="text/javascript" charset="utf-8" src="/js/lazyload.js"></script>