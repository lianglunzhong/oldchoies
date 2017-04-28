<link rel="canonical" href="/<?php $catalog_link = $catalog->get('link'); echo $catalog_link; ?>" />
<link type="text/css" rel="stylesheet" href="/css/quickview.css" media="all" />
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
    function tolink(sort)
    {
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
    if (!isset($uriArr[2]))
    {
        $to = $today + 86400;
        $from = strtotime('-1 day', $to);
    }
    else
    {
        $to = $today - $uriArr[2] * 86400 + 86400;
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
            <?php if (count($crumbs) > 1): ?>
                <div class="flr"><a href="<?php echo $crumbs[0]['link']; ?>">Back To <?php echo $crumbs[0]['name']; ?></a></div>
                <?php
            endif;
            ?>
        </div>
    </div>
        
    <!-- main begin -->
    <section class="layout fix">
        <section id="container" class="flr">
            <!-- cate_sales begin -->
            <?php
            $flash_sale = array();
            if ($catalog_link != 'outlet' AND $catalog->get('on_menu'))
            {
                $catalog_sqls = array();
                $parent_id = $catalog->get('parent_id');
                if ($parent_id == 0)
                    $parent_id = $catalog->get('id');
                $children = Catalog::instance($parent_id)->posterity();
                $children[] = $parent_id;
                $flash_sale = DB::query(DATABASE::SELECT, 'SELECT DISTINCT s.product_id, s.price, s.expired 
                    FROM carts_spromotions s LEFT JOIN products_categoryproduct c ON s.product_id=c.product_id 
                    WHERE c.category_id IN(' . implode(',', $children) . ') AND s.type = 6 AND s.expired + 36000 > ' . time() . ' 
                    ORDER BY s.expired LIMIT 0, 4')->execute()->as_array();
            }
            if (!empty($flash_sale))
            {
                ?>
                <article class="cate_sales">
                    <ul class="fix">
                        <?php
                        foreach ($flash_sale as $s):
                            $link = Product::instance($s['product_id'])->permalink();
                            $end_day = $s['expired'] - time() + 36000;
                            ?>
                            <li>
                                <a href="<?php echo $link; ?>"><img src="<?php echo Image::link(Product::instance($s['product_id'])->cover_image(), 1); ?>" /></a>
                                <a href="<?php echo $link; ?>" class="name"><?php echo Product::instance($s['product_id'])->get('name'); ?></a>
                                <p class="fix">
                                    <span class="price fll"><?php echo Site::instance()->price($s['price'], 'code_view'); ?><del><?php echo Site::instance()->price(Product::instance($s['product_id'])->get('price'), 'code_view'); ?></del></span>
                                    <span class="share flr">
                                        <a target="_blank" href="http://twitter.com/share?url=<?php echo urlencode($link); ?>" class="a1"></a>
                                        <a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($link); ?>" class="a2"></a>
                                        <a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($link); ?>&media=<?php echo Image::link(Product::instance($s['product_id'])->cover_image(), 1); ?>&description=<?php Product::instance($s['product_id'])->get('name'); ?>" class="a3"></a>
                                    </span>
                                </p>
                                <div class="saletime">
                                    <?php
                                    if ($end_day > 86400)
                                    {
                                        $day = date('d', $end_day);
                                        ?>
                                        <!-- Time more than 24hours -->
                                        <div class="JS_daobefore hide">Ends in <?php echo $day; ?> day<?php if ($day > 1) echo 's'; ?>!</div>
                                        <?php
                                    }
                                    else
                                    {
                                        $end_day;
                                        ?>    
                                        <!-- Time less than 24hours -->
                                        <div class="">
                                            <span class="left">Sale Ends in</span> <strong class="JS_RemainH"><?php echo date('H', $end_day); ?></strong>:<strong class="JS_RemainM"><?php echo date('i', $end_day); ?></strong>:<strong class="JS_RemainS"><?php echo date('s', $end_day); ?></strong>!
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </li>
                            <?php
                        endforeach;
                        ?>
                    </ul>
                </article>
                <?php
            }
            else
            {
                if (1)
                {
                    if ($catalog_link == 'outlet')
                    {
                        ?>
                        <p class="mb25"><img src="/images/outlet.jpg" width="810" alt="<?php echo $catalog->get('image_alt'); ?>" border="0" usemap="#outlet" />
                            <map name="outlet" id="outlet">
                                <area shape="rect" coords="3,91,262,162" href="<?php echo LANGPATH; ?>/usd20" />
                                <area shape="rect" coords="272,92,533,162" href="<?php echo LANGPATH; ?>/usd30" />
                                <area shape="rect" coords="543,91,803,160" href="<?php echo LANGPATH; ?>/usd40" />
                            </map>
                        </p>
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
                                        if (isset($uriArr[2]) AND $uriArr[2] == $i)
                                            $on = 1;
                                        elseif (!isset($uriArr[2]) AND $i == 0)
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
                                    <li><a href="#" title=""><img src="/images/805-400-1.jpg" alt="" /></a></li>
                                    <li><a href="#" title=""><img src="/images/805-400-2.jpg" alt="" /></a></li>
                                    <li><a href="#" title=""><img src="/images/805-400-3.jpg" alt="" /></a></li>
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
                                    <img src="/simages/<?php echo $image_src; ?>" width="810" alt="<?php echo $catalog->get('image_alt'); ?>" usemap="#<?php echo $map; ?>" />
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
            }
            ?>
            <section class="pro_list">
                <!-- filter_page -->
                <article class="filter_page">
                    <ul class="select fix">
                        <li class="wdrop">
                            <span class="JS_drop drop">
                                <span class="selected"><?php echo isset($_GET['sort']) ? $sorts[$_GET['sort']]['name'] : 'Default'; ?></span>
                                <div class="JS_drop_box drop_box hide">
                                    <ul class="drop_list" id="filter-other">
                                        <?php foreach ($sorts as $key => $sort): ?>
                                            <li <?php if (isset($_GET['sort']) AND (int) $_GET['sort'] == $key) echo 'class="on"'; ?> onclick="tolink(<?php echo $key; ?>);">
                                                <?php echo $sort['name']; ?>
                                            </li>
                                            <?php
                                        endforeach;
                                        ?>
                                    </ul>
                                </div>
                            </span>
                            <input class="Js_repNum" type="hidden" value="" />
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
                        <li><a class="icon_pick" href="<?php echo $_SERVER['REDIRECT_URL'] . '?' . implode('&', $gets1); ?>">Icon's Pick</a></li>
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
                                        $filterName = DB::select('name')->from('attributes')->where('id', '=', $filter)->execute()->get('name');
                                        $href .= '/' . implode('__', $filterArr);
                                        echo '<li><a href="' . $href . $limit_link . '"><span class="select">' . ucfirst($filterName) . '</span></a></li>';
                                    }
                                }
                                ?>
                            </ul>
                            <a href="<?php echo LANGPATH . $uris[0] . '/' . $uris[1] . '/' . $uris[2]; ?>"><span class="clearall flr">Clear All</span></a>
                            <?php
                        endif;
                        ?>
                    </div>
                </article>
                    
                <!-- pro_listcon -->
                <article class="pro_listcon">
                    <ul class="fix">
                        <?php
                        $_limit = count($products) >= $limit ? $limit : count($products);
                        for ($i = 0; $i < $_limit; $i++):
                            $product_id = $products[$i];
                            $images = Product::instance($product_id)->images();
                            $product_inf = DB::select('type', 'name', 'price', 'has_pick', 'status', 'stock', 'display_date')
                                    ->from('products_product')
                                    ->where('id', '=', $product_id)
                                    ->execute()->current();
                            ?>
                            <li class="JS_shows_btn1">
                                <div class="pic">
                                    <a href="<?php echo Product::instance($product_id)->permalink(); ?>">
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
                                    <a href="#" id="<?php echo $product_id; ?>" class="quick_view JS_shows1 hide">Quick View</a>
                                <?php endif; ?>
                                <?php
                                $secondhalf = DB::select('restrictions')
                                        ->from('carts_cpromotions')
                                        ->where('actions', '=', 'a:1:{s:6:"action";s:10:"secondhalf";}')
                                        ->and_where('site_id', '=', 1)
                                        ->and_where('is_active', '=', 1)
                                        ->and_where('to_date', '>', time())
                                        ->execute()->get('restrictions');
                                if ($secondhalf):
                                    $restrict = unserialize($secondhalf);
                                    $has = DB::query(Database::SELECT, 'SELECT id FROM products_categoryproduct WHERE product_id = ' . $product_id . ' AND category_id IN (' . $restrict['restrict_catalog'] . ')')->execute()->get('id');
                                    if ($has):
                                        ?>
                                        <div style="height: 16px;background:#ff3333;color:#fff;font-family: Century Gothic;font-size: 12px;text-align: center;">
                                            BUY 1 GET 1 AT HALF PRICE
                                        </div>
                                        <?php
                                    endif;
                                endif;
                                ?>
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
                                    if($is_sale && $is_new)
                                    {
                                        echo '<span class="icon_sale1"></span><span class="icon_new"></span>';
                                    }
                                    elseif($is_sale)
                                    {
                                        echo '<span class="icon_sale"></span>';
                                    }
                                    elseif($is_new)
                                    {
                                        echo '<span class="icon_new"></span>';
                                    }
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
                    <li class="wdrop">
                        <span class="JS_drop drop">
                            <span class="selected"><?php echo isset($_GET['sort']) ? $sorts[$_GET['sort']]['name'] : 'Default'; ?></span>
                            <div class="JS_drop_box drop_box hide">
                                <ul class="drop_list" id="filter-other">
                                    <?php foreach ($sorts as $key => $sort): ?>
                                        <li <?php if (isset($_GET['sort']) AND (int) $_GET['sort'] == $key) echo 'class="on"'; ?> onclick="tolink(<?php echo $key; ?>);">
                                            <?php echo $sort['name']; ?>
                                        </li>
                                        <?php
                                    endforeach;
                                    ?>
                                </ul>
                            </div>
                        </span>
                        <input class="Js_repNum" type="hidden" value="" />
                    </li>
                    <li><a class="icon_pick" href="<?php echo $_SERVER['REDIRECT_URL'] . '?' . implode('&', $gets); ?>">Icon's Pick</a></li>
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
            echo View::factory('/catalog_left');
        }
        else
        {
            echo View::factory('/catalog_left_1')
                ->set('count_products', $count_products)
                ->set('crumbs', $crumbs)
                ->set('custom_filter', $custom_filter)
                ->set('filter_products', $filter_products)
                ->set('pricerang', $pricerang);
        }
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
                                        <a href="#" onclick="psSMPPow(); return false;"><img name="psSMPPimage" src="<?php echo BASEURL;?>/images/livechat_online1.gif" border="0" /> LiveChat</a>
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
    $images = Product::instance($product_id)->images();
    $product_inf = DB::select('type','name','price','has_pick','status', 'stock')
        ->from('products_product')
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
        'link' => Product::instance($product_id)->permalink(),
        'name' => $product_inf['name'],
        'is_sale' => round($product_inf['price'], 2) > round(Product::instance($product_id)->price(), 2) ? 1 : 0,
        'r_price' => Site::instance()->price(Product::instance($product_id)->price(), 'code_view'),
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
                                                                                 html += '<span><img src="/images/lips.png"  alt="Buyers\' Pick"  title="Buyers\' Pick"/></span>';
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