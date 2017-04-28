<?php
$catalog_link = $catalog->get('link');
    $isusd = 0;
     if(isset($usdarr)){
        if (array_key_exists($catalog_link,$usdarr)){        
                $isusd =1;           
        }
}  

    $banemap = 0;
     if(isset($bannermap)){
        if (in_array($catalog_link,$bannermap)){        
                $banemap =1;           
        }
}      
?>
<link rel="canonical" href="<?php echo LANGPATH; ?>/<?php echo $catalog_link; ?>" />

<?php
$name = $catalog->get('name');
if ($catalog_link == 'daily-new')
{
    $today = strtotime('midnight') - 50400;
    $uri = $_SERVER['REQUEST_URI'];
    $uri = str_replace(LANGPATH, '', $uri);
    $uriArr = explode('/', $uri);
    $brr = array(
        'week1'=>'Letzte Woche',     
        'week2'=>'Diese Woche',     
        'month'=>'Letzter Monat',  
        );
    if(isset($uriArr[2]) && isset($brr[$uriArr['2']]))
    {
        $name = $brr[$uriArr['2']];
    }
}

$catalog_id = $catalog->get('id');
?>
<script>
    var winWidth = window.innerWidth;
</script>
<div class="site-content">
    <div class="main-container clearfix">
        <div class="container">
            <div class="crumbs">
                <div class="fll">
                    <a href="<?php echo LANGPATH; ?>/" class="home">Homepage</a>
                    <?php
                    foreach ($crumbs as $key => $crumb):
                        ?>
                        <?php if ($key != count($catalog->crumbs()) - 1):
                            if(isset($repla[$crumb['name']]))
                            {
                                $crumb['name'] = $repla[$crumb['name']];
                            }
                        ?>
                            &gt; <span><a href="<?php echo $crumb['link']; ?>" rel="nofollow" ><?php echo $crumb['name']; ?></a></span>
                        <?php else: ?>
                            &gt; <span><?php echo $name; ?></span>
                        <?php endif; ?>
                        <?php
                    endforeach;
                    ?>
                </div>
                
            </div>
            <div <?php
                    $phonebannerarr = array('black-friday','cyber-monday','christmas-sale','seasonal-clearance-sale-fb');
                 if(!in_array($catalog_link, $phonebannerarr)){ echo 'class="hidden-xs"';
                }
            ?>>
            <?php
            if ($catalog_link == 'daily-new')
            {
                    ?>
                    <?php
            }
            elseif ($catalog_link == 'halloween')
            {
                ?>
                <div class="banner" id="banner">
                    <div class="ibanner layout" style="height:300px;">
                        <ul class="bannerPic">
                            <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/1020-300-1.jpg" alt="" /></a></li>
                            <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/1020-300-2.jpg" alt="" /></a></li>
                            <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/1020-300-3.jpg" alt="" /></a></li>
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
            elseif ($catalog_link == 'new-year-paypal-sale')
            {
                ?>
                <div class="banner" id="banner">
                    <div class="ibanner layout" style="height:300px;">
                        <ul class="bannerPic">
                            <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/new-year-paypal-sale1.jpg" alt="" /></a></li>
                            <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/new-year-paypal-sale2.jpg" alt="" /></a></li>
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
            elseif($catalog_link == 'south-east-asian-sale')
            {
                ?>
                <div class="banner" id="banner">
                    <div class="ibanner layout" style="height:300px;">
                        <ul class="bannerPic">
                            <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/south-east-asian-sale1.jpg" alt="" /></a></li>
                            <li><a href="#" title=""><img src="<?php echo STATICURL; ?>/ximg/south-east-asian-sale2.jpg" alt="" /></a></li>
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
            elseif($banemap == 1)
            {
                $image_src = $catalog->get('image_src');
                if ($image_src)
                {
                    $image_map = $catalog->get('image_map');
                    if ($image_map)
                        $map = 'Map' . $catalog->get('id');
                    else
                        $map = '';                
                ?>
                    <p class="mb25 img-active">                    
                            <img src="<?php echo STATICURL;?>/simages/<?php echo $image_src; ?>" alt="<?php echo $catalog->get('image_alt'); ?>" usemap="#<?php echo $map; ?>" />
                            <map id="<?php echo $map; ?>" name="<?php echo $map; ?>">
                            <?php 
                            if ($map){
                            echo $image_map;
                           }
                             ?>
                    </map>
                <?php
                }
                ?>
                    </p>
                <?php
            }
            else
            {
                $image_src = $catalog->get('image_src');
                if ($image_src)
                {
                    $image_map = $catalog->get('image_map');
                    if ($image_map)
                        $map = 'Map' . $catalog->get('id');
                    else
                        $map = '';
                    ?>
                    <p class="mb25 img-active">
                    <?php if($catalog->get('image_link')){ ?>
                        <a href="<?php echo $catalog->get('image_link'); ?>"><?php } ?>
                            <img border="0" src="<?php echo STATICURL;?>/simages/<?php echo $image_src; ?>" alt="<?php echo $catalog->get('image_alt'); ?>" usemap="#<?php echo $map; ?>"  />
                    <?php if($catalog->get('image_link')){ ?></a><?php } ?>

                    <?php
                    if ($map)
                    {
                        echo '<map name="' . $map . '" id="' . $map . '">' . $image_map . '</map>';
                    }
                }
                else
                {
                    $description = trim($catalog->get('description'));
                    if($description)
                    {
                    ?>
                        <div class="list-word-banner">
                            <h3><?php echo $catalog->get('name'); ?></h3>
                            <p><?php echo $description; ?></p>
                            <ul>
                                <?php
                                $hot_catalog = $catalog->get('hot_catalog');
                                if(!empty($hot_catalog)) 
                                {
                                    $hot_catalog = unserialize($hot_catalog);
                                }
                                
                                if(!empty($hot_catalog))
                                { 
                                    if(is_array($hot_catalog))
                                    {
                                        foreach ($hot_catalog as $key => $value)
                                        {   
                                            if(strpos($value,',') != false)
                                            { 
                                                $newhot = explode(",",$value); ?>
                                            <li><a href="<?php if(isset($newhot[1])){echo $newhot[1]; }?>"><?php if(isset($newhot[0])){echo $newhot[0]; }?></a></li>
                                        <?php
                                            }
                                        }
                                    ?>
                                <?php 
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    <?php
                    }
                }
                ?>
                </p>
            <?php 
            }
            ?>
            </div>

            <?php              
               $pimage_src = $catalog->get('pimage_src');
                if ($pimage_src):
                    $pimage_map = $catalog->get('pimage_map');
                    if ($pimage_map)
                        $map = 'pMap' . $catalog->get('id');
                    else
                        $map = '';

                if($pimage_src):
                         ?>
            <div class="visible-xs">
                <p class="mb25 img-active">
                    <a  href="<?php echo $catalog->get('image_link'); ?>">
                        <img src="<?php echo STATICURL;?>/simages/<?php echo $pimage_src; ?>" alt="">
                    </a>
                </p>
                    <?php
                    if ($map)
                    {
                        echo '<map class="map" name="' . $map . '" id="' . $map . '">' . $pimage_map . '</map>';
                    }
                endif;
                    ?>
            </div>
            <?php endif;?>
            
            <div id="catalog_filter"></div>
            <!-- aside -->
            <?php
            if($catalog_link != 'daily-new' AND $catalog_link != 'new-in')
            {
                echo View::factory(LANGPATH . '/catalog_left_1')
                    ->set('catalog_id', $catalog_id)
                    ->set('sort_by', $sorts)
                    ->set('crumbs', $crumbs)
                    ->set('custom_filter', $custom_filter)
                    ->set('now_filters', $now_filters)
                    ->set('children', $children)
                    ->set('childrens', $childrens)
                    ->set('repla',$repla)
                    ->set('is_mobile', $is_mobile);
            }
            ?>
            <?php
            if($catalog_link != 'daily-new' AND $catalog_link != 'new-in')
            {
            ?>
                <div class="fix"></div>
                <div class="pro-list">
                    <ul class="row" id="product_ul"></ul>
                </div>
                <div class="font18 mt20 ml20 hide" id="no_result">Entschuldigung! Ihre Suche ergab leider keine Produkttreffer.</div>
                <div class="flr pagination_div" id="pagination" style="display:none;"><?php echo $pagination; ?></div>
                <div style="display:none" id="load">1</div>
            <?php
            }
            else
            {
                $count_product = count($products);
                if($count_product > 0)
                {
                ?>
                <div class="list-main">
                <div class="loading hidden-xs hide"><img src="<?php echo STATICURL; ?>/assets/images/loading.gif"></div>
                <div class="filter-right" style="width: 100%;">
                <div class="flr hidden-xs pagination_div"><?php echo $pagination; ?></div>
                <div class="fix"></div>
                <div class="pro-list">
                    <ul class="row" id="product_ul">
                    <?php
                    $product_ids = array();
                    $picsku = Kohana::config('sites.sku');
                    
                    $cache = Cache::instance('memcache');
              
                    if($show_ship_tip){
    					
    				
                            $key395 = Site::instance()->get('id') . '/catalog_id395';
                            if (!($ready_shippeds = $cache->get($key395))){
                                $ready_shippeds = DB::select('product_id')->from('catalog_products')->where('catalog_id', '=', 395)->execute()->as_array();
                               $cache->set($key395, $ready_shippeds, 600);
                           }
    				}else{
    					$ready_shippeds = array();
    				}
                    $_limit = $count_product >= $limit ? $limit : count($products);
                    for ($i = 0; $i < $_limit; $i++)
                    {
                        $product_id = $products[$i];
                        $product_ids[] = $product_id;
                        $cover_image = Product::instance($product_id, LANGUAGE)->cover_image();
                        $product_inf = Product::instance($product_id, LANGUAGE)->get();
                        $search = array('product_id' => $product_id);
                        $plink = Product::instance($product_id ,LANGUAGE)->permalink();
    					if($i<=19){
                        ?>
                        <li class="pro-item col-xs-6 col-sm-3">
                            <?php
                            if($is_mobile)
                                $image_link = Image::link($cover_image, 4);
                            else
                                $image_link = Image::link($cover_image, 1);
                            ?>
                                <div class="pic">
                                    <a href="<?php echo $plink; ?>">
                                        <div class="pic1"><img src="<?php echo STATICURL;?>/assets/images/2016/loading.jpg" class="lazy" data-original="<?php echo $image_link; ?>"  alt="<?php echo 'Fashion ' . $catalog->get('name'); ?>" title="<?php echo $product_inf['name']; ?>" /></div>
                                    </a>
                                </div>
                            <div class="title">
                                <a href="<?php echo $plink; ?>" title="<?php echo $product_inf['name']; ?>">
                                <?php
                                if ($product_inf['has_pick'] != 0)
                                {
                                    ?>
                                    <i class="myaccount"></i>
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
                                <a href="#" id="<?php echo $product_id; ?>" attr-lang="<?php echo LANGUAGE; ?>"  class="btn-qv quick_view"  data-reveal-id="myModal">SCHNELLANSICHT</a>
                            <?php endif; ?>
                            <div class="add-wish">
                            <?php if(!$customer_id = Customer::logged_in()){ ?>
                            <div class="add_to_wishlist" data-product="<?php echo $product_id; ?>">
                                <a class="wish-title" data-reveal-id="myModal2" id="wish1_<?php echo $product_id; ?>">Zur Wunschliste Hinzufügen
                                <i class="fa fa-heart add_wishlist" id="wish_<?php echo $product_id; ?>"></i></a>
                            </div>
                            <?php }else{ ?>
                            <div class="add_to_wishlist" data-product="<?php echo $product_id; ?>">
                                <a class="wish-title" id="wish1_<?php echo $product_id; ?>">Zur Wunschliste Hinzufügen
                                <i class="fa fa-heart add_wishlist" id="wish_<?php echo $product_id; ?>"></i></a>
                            </div>
                            <?php } ?>
                            </div>
                            <div class="sign-warp" id="sc_<?php echo $product_id; ?>">
                                <span class="sign-close">
                                    <i class="fa fa-times-circle fa-lg"></i>
                                </span>
                                <div class="wishlist_success">
                                    <p class="text" style="border:none;"></p>
                                    <p class="wish"><i class="fa fa-heart"></i>Wunschliste</p>
                                </div>
                            </div>
                            <?php
    /*                        if ($secondhalf):
                                $restrict = unserialize($secondhalf);
                                $has = DB::query(Database::SELECT, 'SELECT id FROM catalog_products WHERE product_id = ' . $product_id . ' AND catalog_id IN (' . $restrict['restrict_catalog'] . ')')->execute()->get('id');
                                if ($has):
                                    ?>
                                    <div style="height: 16px;background:#ff3333;color:#fff;font-family: Century Gothic;font-size: 12px;text-align: center;">
                                        BUY 1 GET 2nd HALF PRICE
                                    </div>
                                    <?php
                                endif;
                            endif;*/
                            ?>

                            <?php
                            $onsale = 1;
                            $bogoarr = array('blouses-shirts','bodysuits','coats-jackets','hoodies-sweatshirts','happy-thanksgiving-sale');
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
    							if(in_array($product_id, $flash_sales)){
                                    echo '<i class="icon icon-fsale" id="mark_'.$product_id.'"></i>';
                                }
                                else
                                {
                                    if(in_array($search, $ready_shippeds))
                                    {
                                        echo '<i class="" id="mark_'.$product_id.'"></i>';
                                    }
                                    else
                                    {
                                        $is_new = time() - $product_inf['display_date'] <= 86400 * 7 ? 1 : 0;
                                        if($is_new){
    										echo '<i class="icon icon-new" id="mark_'.$product_id.'"></i>';
    									}else{
    										echo '<i class="" id="mark_'.$product_id.'"></i>';
    									}
    										
                                    }
                                    
                                }
                            }
                            ?>
                        </li>
                        <?php
                    }
    				}
                    ?>
                    </ul>
                </div>
                </div>
                </div>
                <div class="flr" id="pagination" style="display:none;"><?php echo $pagination; ?></div>
                <div style="display:none" id="load">1</div>        
            <?php
            }
            else
            {
                ?>
                <div class="font18 mt20">Entschuldigung! Ihre Suche ergab leider keine Produkttreffer.</div>
                <?php
            }
        }
        ?>
    </div>
</div>
</div>
<?php echo View::factory(LANGPATH . '/quickview'); ?>

<!-- JS-popwincon1 -->
<div id="myModal2" class="reveal-modal xlarge">
    <a class="close-reveal-modal close-btn3"></a>
    <?php echo View::factory(LANGPATH . '/customer/ajax_login'); ?>
</div>

<?php
    $product_str = !empty($product_ids) ? implode(',', $product_ids) : '';
?>
<div id="current_product_ids" class="hide"><?php echo $product_str; ?></div>

<script type="text/javascript">
$(function(){      

    // 分类产品信息加载 --- wanglong 2015-12-17
        var timeout = false;	
		wishlistresult = '';  
		showcolorarr = '';  
		showmarksarr = '';  
		showreviewsarr = '';
        $(window).scroll(function(){
		
            if (timeout){clearTimeout(timeout);} 
            timeout = setTimeout(function(){ 
				$("#pagination").hide();
                var li_last_height=parseInt($("#product_ul li").last().offset().top);
                var seeheight=parseInt($(window).height());
                var scrolltop=parseInt($(window).scrollTop());
                if(li_last_height<seeheight+scrolltop+500){ // 
                    var tli = $('#product_ul').children('li').length;
    				var load=$("#load").text();
    				if(load==1)
    				{
                        var product_str = $("#current_product_ids").html();
                        show_products(product_str, tli);
                    }else{
    					$("#pagination").show();
    				}
				}
				
            },500);

         })
		
    })

    function show_products(product_str, tli)
    {
        $.ajax({
            type: "POST",
            url: "/ajax/more_product?lang=<?php echo LANGUAGE;?>",
            dataType: "json",
            data: "product_ids="+product_str+"&tli="+tli,
            success: function(product){
                //判断是否最后一组
                if(product.length==0){  
                    $("#load").text("0")
                }
                var showis_ids = '';
                //  var product = [0,1,2,3,4,5,6,7,];
                $.each(product,function(i,pdata){
                    showis_ids += pdata['product_id'] + ',';
                    var product_li = '';
                    product_li += '\
                    <li class="pro-item col-xs-6 col-sm-3">\
                        <div class="pic">\
                            <a href="' + pdata['product_href'] + '">\
                            <div class="pic1">\
                                <img class="lazy" title="' + pdata['product_title'] + '" src="<?php echo STATICURL; ?>/assets/images/2016/loading.jpg" data-original="' + pdata['image_src'] + '"  alt="' + pdata['image_alt'] + '">\
                            </div>\
                            </a>\
                            <a href="' + pdata['product_href'] + '" style="display:none;">\
                                <span class="icon-color" title="More Colors"></span>\
                            </a>\
                        </div>\
                        <div class="title">\
                            <a href="' + pdata['product_href'] + '">';
                            if(pdata['has_pick'] != 0){
                                product_li += '<i class="myaccount"></i>';
                            }
                            
                            
                        product_li += pdata['product_title']+'</a></div><p class="price">';
                        
                        if(pdata['price_new'] == pdata['price_old']){
                        product_li +=  '<span class="pricenow">'+pdata['price_old']+'</span>';
                        }else{
                        product_li +=  '<span class="priceold">' + pdata['price_old'] + '</span><span class="pricenew">' + pdata['price_new'] + '</span>';
                        }
                        product_li +=  '</p>\
                        <div class="star" id="star_' + pdata['product_id'] + '">\
                        </div>\
                        <a id="' + pdata['product_id'] + '" class="btn-qv quick_view" attr-lang="<?php echo LANGUAGE; ?>" data-reveal-id="myModal">SCHNELLANSICHT</a>';
                        product_li +=  
                        '<div class="add-wish">';
                        <?php if(!$customer_id = Customer::logged_in()){ ?>
                        product_li += '<div class="add_to_wishlist" data-product="' + pdata['product_id'] + '">\
                            <a class="wish-title" data-reveal-id="myModal2" id="wish1_' + pdata['product_id'] + '">Zur Wunschliste Hinzufügen <i class="fa fa-heart add_wishlist" id="wish_' + pdata['product_id'] + '"></i></a></div>';

                        <?php }else{ ?>
                        product_li +=  
                            '<div class="add_to_wishlist" data-product="' + pdata['product_id'] + '">\
                                <a class="wish-title" id="wish1_' + pdata['product_id'] + '">Zur Wunschliste Hinzufügen \
                                <i class="fa fa-heart add_wishlist" id="wish_' + pdata['product_id'] + '"></i></a>\
                            </div>';

                        <?php } ?>

                        product_li += '</div>';
                        product_li += '<div class="sign-warp" id="sc_' + pdata['product_id'] + '">\
                            <span class="sign-close">\
                                <i class="fa fa-times-circle fa-lg"></i>\
                            </span>\
                            <div class="wishlist_success">\
                                <p class="text" style="border:none;"></p>\
                                <p class="wish"><i class="fa fa-heart"></i>Wunschliste</p>\
                            </div>\
                        </div>';
                        if(pdata['mark']=='outstock'){
                            product_li += '<span class="outstock">Sold Out</span>';
                        }else if(pdata['mark']=='flash_sales'){
                            product_li += '<i class="icon-fsale" id="mark_' + pdata['product_id'] + '"></i>';
                        }else if(pdata['mark']=='ready_shippeds'){
                            product_li += '<i class="" id="mark_' + pdata['product_id'] + '"></i>';
                        }else if(pdata['mark']=='icon-new'){
                            product_li += '<i class="icon-new" id="mark_' + pdata['product_id'] + '"></i>';
                        }else{
                            product_li += '<i class="" id="mark_' + pdata['product_id'] + '"></i>';
                        }
                    product_li += '</li>';
                                
                    $("#product_ul").append(product_li);
                     $(".sign-close").click(function(){
                        $(this).parent().hide();
                        $(".overlay").hide();
                    });
                })
                showis(showis_ids);
            },
            complete: function () {
                $("#pagination").show();
                $("img.lazy").lazyload({
                    event: "scrollstop"
                });
            },
        });  // end ajax
    }
	
    function show_products_detail(product_infos)
    {
        var product_li = '';
        var showis_ids = '';
        for(i in product_infos)
        {
            var pdata = product_infos[i];
            showis_ids += pdata['product_id'] + ',';
            if(i < 12)
                var img_src = pdata['image_src'];
            else
                var img_src = '<?php echo STATICURL; ?>/assets/images/2016/loading.jpg';
            product_li += '\
            <li class="pro-item col-xs-6 col-sm-3">\
                <div class="pic">\
                    <a href="' + pdata['product_href'] + '">\
                    <div class="pic1">\
                        <img class="lazy" title="' + pdata['product_title'] + '" src="' + img_src + '" data-original="' + pdata['image_src'] + '"  alt="' + pdata['image_alt'] + '">\
                    </div>\
                    </a>\
                    <a href="' + pdata['product_href'] + '" style="display:none;">\
                        <span class="icon-color" title="More Colors"></span>\
                    </a>\
                </div>\
                <div class="title">\
                    <a href="' + pdata['product_href'] + '">';
                    if(pdata['has_pick'] != 0){
                        product_li += '<i class="myaccount"></i>';
                    }
                    
                    
                product_li += pdata['product_title']+'</a></div><p class="price">';
                
                if(pdata['price_new'] == pdata['price_old']){
                product_li +=  '<span class="pricenow">'+pdata['price_old']+'</span>';
                }else{
                product_li +=  '<span class="priceold">' + pdata['price_old'] + '</span><span class="pricenew">' + pdata['price_new'] + '</span>';
                }
                product_li +=  '</p>\
                <div class="star" id="star_' + pdata['product_id'] + '">\
                </div>\
                <a id="' + pdata['product_id'] + '" class="btn-qv quick_view" attr-lang="<?php echo LANGUAGE; ?>" data-reveal-id="myModal">SCHNELLANSICHT</a>';
                product_li +=  
                '<div class="add-wish">';
                <?php if(!$customer_id = Customer::logged_in()){ ?>
                product_li += '<div class="add_to_wishlist" data-product="' + pdata['product_id'] + '">\
                    <a class="wish-title" data-reveal-id="myModal2" id="wish1_' + pdata['product_id'] + '">Zur Wunschliste Hinzufügen <i class="fa fa-heart add_wishlist" id="wish_' + pdata['product_id'] + '"></i></a></div>';

                <?php }else{ ?>
                product_li +=  
                    '<div class="add_to_wishlist" data-product="' + pdata['product_id'] + '">\
                        <a class="wish-title" id="wish1_' + pdata['product_id'] + '">Zur Wunschliste Hinzufügen \
                        <i class="fa fa-heart add_wishlist" id="wish_' + pdata['product_id'] + '"></i></a>\
                    </div>';

                <?php } ?>

                product_li += '</div>';
                product_li += '<div class="sign-warp" id="sc_' + pdata['product_id'] + '">\
                    <span class="sign-close">\
                        <i class="fa fa-times-circle fa-lg"></i>\
                    </span>\
                    <div class="wishlist_success">\
                        <p class="text" style="border:none;"></p>\
                        <p class="wish"><i class="fa fa-heart"></i>Wunschliste</p>\
                    </div>\
                </div>';
                if(pdata['mark']=='outstock'){
                    product_li += '<span class="outstock">Sold Out</span>';
                }else if(pdata['mark']=='flash_sales'){
                    product_li += '<i class="icon-fsale" id="mark_' + pdata['product_id'] + '"></i>';
                }else if(pdata['mark']=='ready_shippeds'){
                    product_li += '<i class="" id="mark_' + pdata['product_id'] + '"></i>';
                }else if(pdata['mark']=='icon-new'){
                    product_li += '<i class="icon-new" id="mark_' + pdata['product_id'] + '"></i>';
                }else{
                    product_li += '<i class="" id="mark_' + pdata['product_id'] + '"></i>';
                }
            product_li += '</li>';
        }
        $("#product_ul").append(product_li);
         $(".sign-close").click(function(){
            $(this).parent().hide();
            $(".overlay").hide();
        });
        showis(showis_ids);
    }

	function showis(product_ids)
    {
        
        if(wishlistresult){
            for(var p in wishlistresult){
                var pid = wishlistresult[p];
                $("#wish_"+pid).removeClass('add_wishlist');
                $("#wish_"+pid).addClass('red');
                $("#wish1_"+pid).html("<i class='fa fa-heart red' id='wish_'"+ pid+"></i>");
            }            
        }else{
            $.ajax({
                type: "POST",
                url: "/ajax/wishlist_data",
                dataType: "json",
                async : false,
                data: "product_ids=" + product_ids,
                success: function(res){
                    wishlistresult = res;
                    for(var p in res){
                        var pid = res[p];
                        $("#wish_"+pid).removeClass('add_wishlist');
                        $("#wish_"+pid).addClass('red');
                        $("#wish1_"+pid).html("<i class='fa fa-heart red' id='wish_'"+ pid+"></i>");
                    }
                }
            });
        }

        $.ajax({
            type: "POST",
            url: "/ajax/marks_data?catalog_id=<?php echo $catalog_id;?>",
            data: "product_ids=" + product_ids,
            dataType: "json",
            success: function(res){
                for(var p in res){
                    if(res[p]){
                        $("#mark_"+p).removeClass().addClass(res[p]);
                    }
                }
            }
        });                
            
        return true;
            
        if(showreviewsarr){
            for(var p in showreviewsarr){
                var review = showreviewsarr[p];
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
        }else{
            //ajax reviews
            $.ajax({
                type: "POST",
                url: "<?php echo LANGPATH;?>/ajax/review_data",
                dataType: "json",
                data: "product_ids=" + product_ids,
                success: function(res){
                    showreviewsarr=res;
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
            
            
        }   
            

    }



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
                        $(".wish-title").removeAttr("data-reveal-id");
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
                                    $("#myModal2").hide();
                                    $(".reveal-modal-bg").hide();
                                    $("#wish1_"+pid).html("<i class='fa fa-heart red' id='wish_'"+ pid+"></i>");
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
/*                        var top = getScrollTop();
                        top = top - 35;
                        $('body').append('<div class="JS-filter1 opacity"></div>');
                        $('.JS-popwincon1').css({
                            "top": top, 
                            "position": 'absolute'
                        });
                        $('.JS-popwincon1').appendTo('body').fadeIn(320);
                        $('.JS-popwincon1').show();
            $("#email2").val('');
            $("#password2").val('');*/
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
                    if(rs.success == 1)
                    {
                        $(".wish-title").removeAttr("data-reveal-id");
						var str="";
						 str +="<li class='drop-down cs-show'>";
						 str +="<div class='drop-down-hd'>";
						 str +="<i class='myaccount'></i>";
						 str +="<span>Hallo, "+rs.firstname+"!</span>";
						 str +="</div>";
						 str +="<dl class='drop-down-list cs-list'>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/summary'>Mein Konto</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/orders'>Bestellhistorie</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/tracks/track_order'>Verfolgen</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/wishlist'>Meine Wunschliste</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/profile'>Mein Profil</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/logout'>Abmelden</a>";
						 str +="</dd></dl></li>";
						$("#customer_sign_in").html(str);
							
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
                                    $("#myModal2").hide();
                                    $(".reveal-modal-bg").hide();
                                    $("#wish_" + pid).parent().find('span').text('');
                                    $("#wish_" + pid).attr('class', 'fa fa-heart red');
                                    $(".wishlist_success").show();
                                    $(".JS-filter1").remove();
                                    $(".JS-popwincon1").fadeOut(160);
									var _proItem = $("#sc_"+pid).parents(".pro-item");
                                    _proItem.find(".overlay").show();
                                    _proItem.find(".sign-warp").show();
                                    _proItem.find('.sign-warp').find('.wishlist_success').find('.text').text(result.message);
									getwishlist();
									
                                }else if(result.success == '-1'){
									var _proItem = $("#sc_"+pid).parents(".pro-item");
									$("#myModal2").hide();
                                    $(".reveal-modal-bg").hide();
                                    $("#wish1_"+pid).html("<i class='fa fa-heart red' id='wish_'"+ pid+"></i>");
                                    $("#wish_" + pid).attr('class', 'fa fa-heart red')
                                    _proItem.find(".overlay").show();
									_proItem.find(".sign-warp").show();
									_proItem.find('.sign-warp').find('.wishlist_success').find('.text').text(result.message);
									getwishlist();
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
                    if(rs.success == 1)
                    {
						var str="";
						 str +="<li class='drop-down cs-show'>";
						 str +="<div class='drop-down-hd'>";
						 str +="<i class='myaccount'></i>";
						 str +="<span>Hello, Choieser!</span>";
						 str +="</div>";
						 str +="<dl class='drop-down-list cs-list'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/summary'>Mein Konto</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/orders'>Bestellhistorie</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/tracks/track_order'>Verfolgen</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/wishlist'>Meine Wunschliste</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/profile'>Mein Profil</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/logout'>Abmelden</a>";
						 str +="</dd></dl></li>";
						$("#customer_sign_in").html(str);
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
                                    var _proItem = $("#sc_"+pid).parents(".pro-item");
									$("#myModal2").hide();
                                    $(".reveal-modal-bg").hide();
                                    $("#wish1_"+pid).html("<i class='fa fa-heart red' id='wish_'"+ pid+"></i>");
                                    $("#wish_" + pid).attr('class', 'fa fa-heart red')
                                    _proItem.find(".overlay").show();
									_proItem.find(".sign-warp").show();
									_proItem.find('.sign-warp').find('.wishlist_success').find('.text').text(result.message);
									getwishlist();
                                }
                                else
                                {
                                  //  showup(result.message);
                                    alert(result.message);
                                }
                            }
                        });
                        return false;
                    }
                    else
                    {
                      //  showup(rs.message);
                        alert(rs.message);
                    }
                }
            });
            return false;
        })

        //close wihlist_success
        $(".sign-close").click(function(){
            $(this).parent().hide();
            $(".overlay").hide();
        })

        <?php
        $product_str = !empty($product_ids) ? implode(',', $product_ids) : '';
        ?>

        //ajax wishlists
        $.ajax({
            type: "POST",
            url: "/ajax/wishlist_data",
            dataType: "json",
            data: "product_ids=<?php echo $product_str; ?>",
            success: function(res){
                for(var p in res){
                    var pid = res[p];
                    $("#wish_"+pid).removeClass('add_wishlist');
                    $("#wish_"+pid).addClass('red');
                    $("#wish1_"+pid).html("<i class='fa fa-heart red' id='wish_'"+ pid+"></i>");
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
	
	function getwishlist(){
		//ajax wishlists
        $.ajax({
            type: "POST",
            url: "/ajax/wishlist_data",
            dataType: "json",
            data: "product_ids=<?php echo $product_str; ?>",
            success: function(res){
                for(var p in res){
                    var pid = res[p];
                    $("#wish_"+pid).removeClass('add_wishlist');
                    $("#wish_"+pid).addClass('red');
                    $("#wish1_"+pid).html("<i class='fa fa-heart red' id='wish_'"+ pid+"></i>");
                }
            }
        });
	}
</script>

<?php
if(!$is_daily_new)
{
?>
<!-- catalog left filter -->
<script type="text/javascript">
    $(function(){
        var catalog_id = <?php echo $catalog_id; ?>;
        var limit = <?php echo $limit; ?>;
        // get_catalog_filters(catalog_id, 99999);
        // init catalog page
        var type = 'init';
        var value = '';
        var current_url = window.location.href;
        do_catalog_filters(catalog_id,type,value,limit,current_url,'',0);

        // init left filter bar


        $("#size_ul a,#color_ul a,#price_ul a").live('click', function(){
            var this_class = $(this).attr('class');
            if(typeof this_class != 'undefined')
            {
                if(this_class.indexOf('disabled') >= 0 || this_class.indexOf('selected') >= 0)
                    return false;
            }
            $(this).parent().parent().find('a').removeClass('selected');
            $(this).addClass('selected');
            var size_value = $(this).attr('data-value');
            var current_url = window.location.href;
            var ul_id = $(this).parent().parent().attr('id');
            var type = '';
            if(ul_id == 'size_ul')
            {
                type = 'size';
            }
            else if(ul_id == 'color_ul')
            {
                type = 'color';
            }
            else if(ul_id == 'price_ul')
            {
                type = 'price';
            }
            var bar_title = $(this).find('span').html();
            do_catalog_filters(catalog_id,type,size_value,limit,current_url,bar_title,0);
            return false;
        });
        $("#bar").find("a").live('click', function(){
            var bar_li_id = $(this).parent().attr('id');
            var type = '';
            if(bar_li_id == 'filter_item_size')
                type = 'size';
            if(bar_li_id == 'filter_item_color')
                type = 'color';
            if(bar_li_id == 'filter_item_price')
                type = 'price';
            var size_value = '';
            var current_url = window.location.href;
            do_catalog_filters(catalog_id,type,size_value,limit,current_url,'',0);
            return false;
        });
        $(".pagination_div").find("a").live('click', function(){
            var page_url = $(this).attr('href');
            if(typeof page_url != 'undefined')
            {
                var host = window.location.host;
                var path = window.document.location.pathname;
                var current_url = 'http://' + host + path + page_url;
                var type = 'init';
                var size_value = '';
                do_catalog_filters(catalog_id,type,size_value,limit,current_url,'',1);
            }
            return false;
        })
    })

    function do_catalog_filters(catalog_id,type,value,limit,current_url,bar_title,need_page)
    {
        $(".loading").show();
        $.post(
            '<?php echo LANGPATH; ?>/ajax/catalog_do_filter',
            {
                catalog_id: catalog_id,
                type: type,
                value: value,
                limit: limit,
                current_url: current_url,
                need_page: need_page,
            },
            function(res)
            {
                if(res['product_ids'])
                {
                    $("#current_product_ids").html(res['product_ids']);
                    $("#load").html(1);
                    $("#product_ul").html('');
                    $("#no_result").hide();
                    // show_products(res['product_ids'], 0);
                    show_products_detail(res['product_infos']);
                    var stateObject = {};
                    var title = "";
                }
                else
                {
                    $("#product_ul").html('');
                    $("#no_result").show();
                }

                // set left filter items
                var is_shoes = <?php echo $is_shoes; ?>;
                get_catalog_filters(catalog_id, 99999, res['filter_bar'], is_shoes);

                // set pagination
                $(".pagination_div").html(res['pagination']);
                if(res['pagination'])
                {
                    $(".pagination_div").show();
                }
                else
                {
                    $(".pagination_div").hide();
                }

                history.pushState(stateObject,title,res['put_url']);
                if(type != 'init' || need_page)
                {
                    $("html,body").animate({scrollTop:$("#catalog_filter").offset().top},100);
                }
                $(".loading").hide();
            },
            'json'
        );
    }

    function get_catalog_filters(catalog_id, count_products, current_filter, is_shoes)
    {
        var language = '<?php echo LANGUAGE; ?>';
        var current_filter_str = '';
        for(filter_type in current_filter)
        {
            current_filter_str += filter_type + '_' + current_filter[filter_type]['value'] + '__';
        }
        $.ajax({
            type: "POST",
            url: "<?php echo LANGPATH; ?>/ajax/catalog_filters",
            dataType: "json",
            async : false,
            data: "catalog_id="+catalog_id+"&count_products="+count_products+"&current_filter="+current_filter_str+"&is_shoes="+is_shoes,
            success: function(filters){
                var size_filter_html = '';
                for(size in filters['size'])
                {
                    if(filters['size'][size] > 0)
                    {
                        var size_value = size;//ONE SIZE
                        if(typeof filters['size_title'][size] != 'undefined')
                        {
                            size_value = filters['size_title'][size];  //ONESIZE
                        }
                        
                        console.log(language)
                        if(size == 'ONE SIZE' && typeof filters['language_onesize'][language] != 'undefined')
                        {
                            size = filters['language_onesize'][language];
                        }

                        console.log(size)
                        size_filter_html += '<li class="drop-down-option">\
                            <a href="#" data-value="' + size_value + '" id="filter_item_' + size_value + '"><i></i>\
                            <span>' + size + '</span>\
                            </a>\
                        </li>';
                    }
                }
                $("#size_ul").html(size_filter_html);
                var color_filter_html = '';
                for(color in filters['color'])
                {
                    var color_name = color;
                    if(typeof filters['color_names'][color.toLowerCase()] != 'undefined' && filters['color_names'][color.toLowerCase()])
                    {
                        color_name = filters['color_names'][color.toLowerCase()];
                    }
                    if(color && filters['color'][color] > 0)
                    {
                        color_filter_html += '<li class="drop-down-option">\
                            <a href="#" data-value="' + color + '" id="filter_item_' + color + '"><i></i>\
                            <span>' + color_name + '</span>\
                            </a>\
                        </li>';
                    }
                }
                $("#color_ul").html(color_filter_html);

                var price_filter_html = '';
                for(price_key in filters['price'])
                {
                    if(filters['price'][price_key] > 0)
                    {
                        var price_title = filters['price_keys'][price_key];
                        var price_value = filters['price_values'][price_key];
                        price_filter_html += '<li class="drop-down-option">\
                            <a href="#" data-value="' + price_value + '" id="filter_item_' + price_value + '"><i></i>\
                            <span>' + price_title + '</span>\
                            </a>\
                        </li>';
                    }
                }
                $("#price_ul").html(price_filter_html);

                /* START set filter bar left */
                var bar_html = '';
                var has_filter_html = 0;
                var has_filters = new Array();
                for(filter_type in current_filter)
                {
                    if( typeof current_filter[filter_type] != 'undefined')
                    {
                        var title = current_filter[filter_type]['title'];
                        if(typeof filters['color_names'][title.toLowerCase()] != 'undefined' && filters['color_names'][title.toLowerCase()])
                        {
                            title = filters['color_names'][title.toLowerCase()];
                        }

                        if(title == 'ONE SIZE' && typeof filters['language_onesize'][language] != 'undefined')
                        {
                            title = filters['language_onesize'][language];
                        }
                        var bar_item_id = 'filter_item_' + filter_type;
                        bar_html += '<li class="item-l" id="' + bar_item_id + '" data-value="' + current_filter[filter_type]['value'] + '">\
                            <a href="#"><i class="fa fa-close"></i><span>' + title + '</span></a>\
                        </li>';
                        has_filters.push(current_filter[filter_type]['value']);
                    }
                }
                if(bar_html != '')
                    bar_html += '<li class="item-l clear-li"><a href="#">' + $("#bar1").html() + '</a></li>';
                $("#bar").html(bar_html);
                $(".drop-down-option").find("a").removeClass('selected');
                for(i in has_filters)
                {
                    $("#filter_item_" + has_filters[i]).addClass('selected');
                }

                // hide no count filter items
                for(filter_key in filters['has_filters'])
                {
                    for(filter_item in filters['has_filters'][filter_key])
                    {
                        if(filters['has_filters'][filter_key][filter_item] <= 0)
                        {
                            $("#filter_item_" + filter_item).addClass('disabled');
                        }
                    }
                }

                /* END set left filter bar */
            }
        });
    }
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
<!-- lazyload-12-14 -->
<script type="text/javascript" charset="utf-8" src="<?php echo STATICURL;?>/assets/js/lazyload-12-14.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo STATICURL;?>/assets/js/scrollstop.js"></script>
<script>
	$("img.lazy").lazyload({
		event: "scrollstop"
	});
</script>
<script>
//pic map自适应
    //    adjust();  
        var timeout = null;//onresize触发次数过多，设置定时器  
/*        window.onresize = function () {  
            clearTimeout(timeout);  
            timeout = setTimeout(function () { window.location.reload(); },50);//页面大小变化，重新加载页面以刷新MAP  
        }  */
  
        //获取MAP中元素属性  
        function adjust() {  
            var map = document.getElementById("<?php echo isset($map) ? $map: ''; ?>"); 
            var element = map.childNodes;  
            var itemNumber = element.length / 2;  

            for (var i = 0; i <= itemNumber - 1; i++) {  
                var item = 2 * i + 1;            
                var oldCoords = element[item].coords;  
                var newcoords = adjustPosition(oldCoords);  
                element[item].setAttribute("coords", newcoords);  
            }  
            var test = element;  
        }  
  
        //调整MAP中坐标  
        function adjustPosition(position) {   
            var boxWidth = $(".img-active").width();
            var boxHeight = $(".img-active").height();
            <?php if($catalog_link === 'summer-pretty-sale'){ ?> 
            var imageWidth =  1200;    //图片的长宽  
            var imageHeight = 500;  
         <?php   }    ?>
            <?php if($catalog_link === 'kimonos-croptops'){ ?> 
            var imageWidth =  1200;    //图片的长宽  
            var imageHeight = 300;  
         <?php   }    ?>
            <?php if($catalog_link === 'midi-skirt'){ ?> 
            var imageWidth =  1200;    //图片的长宽  
            var imageHeight = 350;  
         <?php   }    ?>
  
            var each = position.split(",");  
            //获取每个坐标点  
            for (var i = 0; i < each.length; i++) {  
                each[i] = Math.round(parseInt(each[i]) * boxWidth / imageWidth).toString();//x坐标  
                i++;  
                each[i] = Math.round(parseInt(each[i]) * boxHeight / imageHeight).toString();//y坐标  
            }  
            //生成新的坐标点  
            var newPosition = "";  
            for (var i = 0; i < each.length; i++) {  
                newPosition += each[i];  
                if (i < each.length - 1) {  
                    newPosition += ",";  
                }  
            }  
            return newPosition;  
        }  
</script>

    <?php
    $user_session = Session::instance()->get('user');
    ?>
    
    <?php
    if(count($products) >= 3)
    {
    ?>
        <!-- Criteo Code For Listing Page -->
    <script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
    <script type="text/javascript">

        if (window.innerWidth)
            winWidth = window.innerWidth;
        else if ((document.body) && (document.body.clientWidth))
            winWidth = document.body.clientWidth;
        if(winWidth<=768)
            var  m='m';
        else if((winWidth<=1024))
            var  m='t';
        else
            var m='d';
        window.criteo_q = window.criteo_q || [];
        window.criteo_q.push(
            { event: "manualFlush" },

            { event: "setAccount", account: [23687,23689] },          
            { event: "setHashedEmail", email: "<?php echo !empty($user_session['email'])? md5($user_session['email']):' '; ?>" },
            { event: "setSiteType", type: m },           
            { event: "viewList", item: [<?php
    for ($i = 0; $i < 3; $i++)
    { ?>
            '<?php echo $products[$i]; ?>',
        <?php }?>] },

            { event: "flushEvents"},

            { event: "setAccount", account: 23688 },         
            { event: "setHashedEmail", email: "<?php echo !empty($user_session['email'])? md5($user_session['email']):' '; ?>" },
            { event: "setSiteType", type: m },           
            { event: "viewList", item: [<?php
    for ($i = 0; $i < 3; $i++)
    { ?>
            '<?php echo $products[$i]; ?>',
        <?php }?>] },

            { event: "flushEvents"}          
        );
    </script>
    <!-- end Criteo Code For Listing Page -->
    <?php
    }
    ?>