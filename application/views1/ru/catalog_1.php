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
/*    if (!isset($uriArr[2]))
    {
        $to = $today + 86400;
        $from = strtotime('-1 day', $to);
    }
    else
    {
        $to = $today - $uriArr[2] * 86400 + 86400;
        $from = strtotime('-1 day', $to);
    }
    $m = date('m', $to - 1);
    if ($m == 5)
        $name = date('d M, Y', $to - 1);
    else
        $name = date('d M., Y', $to - 1);*/
    $brr = array(
        '92'=>'Платья',
        '623'=>'Пальто',
        '619'=>'Трикотаж',
        '621'=>'Куртки',
        '240'=>'Боттомс',
        '53'=>'Обувь',
        '626'=>'Единичность',
        '631'=>'Мужская Одежда',
        '638'=>'Ювелирные Изделия',
             
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
                    <a href="<?php echo LANGPATH; ?>/" class="home">ГЛАВНАЯ СТРАНИЦА</a>
                    <?php
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
            <div <?php
                    $phonebannerarr = array('black-friday','cyber-monday','christmas-sale');
                 if(!in_array($catalog_link, $phonebannerarr)){ echo 'class="hidden-xs"';
                }
            ?>>
            <?php
            if ($catalog_link == 'daily-new')
            {
                    ?>
                    <!-- width auto -->
					<script>
						$(function(){
							var listUlWidth =$(".newin-list ul").width();
							var listLiLength =$(".newin-list ul li").length;				
							$(".newin-list ul li").width(listUlWidth/listLiLength-0.1);
							
						})
					</script>
                    <div class="newin-list">
                        <ul>
                            <?php
                    $newinarr = array(
                                        array('ПЛАТЬЯ', '92'),
                                        array('ПАЛЬТО', '623'),
                                        array('ТРИКОТАЖ', '619'),
                                        array('КУРТКИ', '621'),
                                        array('БОТТОМС', '240'),
                                        array('Обувь', '53'),
                                        array('ЕДИНИЧНОСТЬ', '626'),
                                    //    array('МУЖСКАЯ ОДЕЖДА', '631'),
                                        array('Ювелирные Изделия', '52'),
                                 //       array('Accessories', '52'),
                                    );
                                   foreach ($newinarr as $k=>$link):
                                    $a = $k+1;
                                    if($k == 7)
                                    {
                                        $a = 13;
                                    }
                                      ?>

                                   
                            <?php if($a>=10){ ?> 
                            <li><a href="<?php echo LANGPATH;?>/daily-new/<?php echo $link[1]; ?>"><img src="<?php echo STATICURL;?>/assets/images/ru/1512/newin-<?php echo $a;?>-<?php echo LANGUAGE;?>.png"></a></li>
                            <?php  }else{  ?>
                            <li><a href="<?php echo LANGPATH;?>/daily-new/<?php echo $link[1]; ?>"><img src="<?php echo STATICURL;?>/assets/images/ru/1512/newin-0<?php echo $a;?>-<?php echo LANGUAGE;?>.png"></a></li>
                            <?php }  ?>
                                <?php
                              endforeach;
                            ?>

                        </ul>
                    </div>
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
                if ($image_src):
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
                endif; ?>
                    </p>
                <?php
            }
/*            elseif($isusd == 1)
            { 
                ?>
                 <div class="sale-filter hidden-xs">
                        <img src="<?php echo STATICURL;?>/assets/images/sale/sale11.jpg">
                        <ul class="con">
                    <?php
                        foreach($usdarr as $k=>$v){   ?>
                              <li <?php if($k == $catalog_link){ ?>  class="on" <?php } ?>><a href="<?php echo LANGPATH.'/'.$v[1]; ?>"><?php echo $v[0]; ?></a></li>
                    <?php } ?>
                         </ul>
                 </div>    
        <?php          
            }*/
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
                            <img src="<?php echo STATICURL;?>/simages/<?php echo $image_src; ?>" alt="<?php echo $catalog->get('image_alt'); ?>" usemap="#<?php echo $map; ?>" />
                        </a>
                    </p>
                    <?php
                    if ($map)
                    {
                        echo '<map name="' . $map . '" id="' . $map . '">' . $image_map . '</map>';
                    }
                endif;
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
            <div class="visible-xs" style="display:none;">
                <p class="mb25 img-active" style="display:none;">
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
                    ->set('pricerang', $pricerang)
                    ->set('size_filter', $size_filter);
            }
            ?>
            <?php
            $count_product = count($products);
            if($count_product > 0)
            {
            ?>
            <div class="flr hidden-xs"><?php echo $pagination; ?></div>
            <div class="fix"></div>
            <div class="pro-list">
                <ul class="row">
                <?php
                $product_ids = array();
                $picsku = Kohana::config('sites.sku');


            $cache = Cache::instance('memcache');

                if($show_ship_tip)
                        $key395 = Site::instance()->get('id') . '/catalog_id395';
                        if (!($ready_shippeds = $cache->get($key395))){
                            $ready_shippeds = DB::select('product_id')->from('catalog_products')->where('catalog_id', '=', 395)->execute()->as_array();
                           $cache->set($key395, $ready_shippeds, 600);
                       }
                else
                    $ready_shippeds = array();
                $_limit = $count_product >= $limit ? $limit : count($products);
                for ($i = 0; $i < $_limit; $i++)
                {
                    $product_id = $products[$i];
                    $product_ids[] = $product_id;
                    $cover_image = Product::instance($product_id)->cover_image();
                    $product_inf = Product::instance($product_id, LANGUAGE)->get();
                    $search = array('product_id' => $product_id);
                    $plink = Product::instance($product_id, LANGUAGE)->permalink();
                    ?>
                    <li class="pro-item col-xs-6 col-sm-3">
                        <?php
                        if($is_mobile)
                            $image_link = Image::link($cover_image, 4);
                        else
                            $image_link = Image::link($cover_image, 1);
                        if($i >= 20)
                        {
                        ?>
                            <!--<div class="overlay"></div>-->
                            <div class="pic">
                                <a href="<?php echo $plink; ?>">
                                    <div class="pic1"><img data-original="<?php echo $image_link; ?>" src="<?php echo STATICURL;?>/assets/images/loading.gif" alt="<?php echo 'Fashion ' . $catalog->get('name'); ?>" title="<?php echo $product_inf['name']; ?>" /></div>
                                </a>
                                <a href="<?php echo $plink; ?>" id="more_color<?php echo $product_id; ?>" style="display:none;"><span class="icon-color" title="More Colors"></span></a>
                            </div>
                        <?php
                        }
                        else
                        {
                            ?>
                            <!-- <div class="overlay"></div> -->
                            <div class="pic">
                                <a href="<?php echo $plink; ?>">
                                <div class="pic1"><img src="<?php echo $image_link; ?>" alt="<?php echo 'Fashion ' . $catalog->get('name'); ?>" title="<?php echo $product_inf['name']; ?>" /></div>
                                </a>
                                <a href="<?php echo $plink; ?>" id="more_color<?php echo $product_id; ?>" style="display:none;"><span class="icon-color" title="More Colors"></span></a>
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
                            <a href="#" id="<?php echo $product_id; ?>" attr-lang="<?php echo LANGUAGE; ?>" class="btn-qv quick_view"  data-reveal-id="myModal">Бстрый посмотр</a>
                        <?php endif; ?>
                        <div class="add-wish">
                        <?php if(!$customer_id = Customer::logged_in()){ ?>
                        <div class="add_to_wishlist" data-product="<?php echo $product_id; ?>">
                            <a class="wish-title" data-reveal-id="myModal2" id="wish1_<?php echo $product_id; ?>">Добавить в избранное
                            <i class="fa fa-heart add_wishlist" id="wish_<?php echo $product_id; ?>"></i></a>
                        </div>
                        <?php }else{ ?>
                        <div class="add_to_wishlist" data-product="<?php echo $product_id; ?>">
                            <a class="wish-title" id="wish1_<?php echo $product_id; ?>">Добавить в избранное
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
                                <p class="wish"><i class="fa fa-heart"></i>Избранное</p>
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
                            echo '<span class="outstock">Indisponible</span>';
                        }
                        else
                        {
                            if(in_array($product_inf['sku'], $picsku)){
                                
                            }elseif(in_array($search, $flash_sales)){
                                echo '<i class="icon icon-fsale"></i>';
                            }
                            else
                            {
                                if(in_array($search, $ready_shippeds))
                                {
                                    echo '<i class="icon icon-rshipped"></i>';
                                }
                                else
                                {
                                    $is_new = time() - $product_inf['display_date'] <= 86400 * 7 ? 1 : 0;
                                    if($is_new)
                                        echo '<i class="icon icon-new"></i>';
                                }
                                
                            }
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
            <div class="font18 mt20">Извините, ничего не найдет. Вы можете взглянуть на наши рекомендуемые товары:</div>
            <?php
        }
        ?>
        <?php
        if(!$is_mobile)
        {
        ?>
        <div class="clearfix"></div>
        <div class="other-customers" id="alsoview" style="display:none;">
            <div class="w-tit"><h2>РЕКОМЕНДУЕМЫЕ ТОВАРЫ</h2></div>
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
                          <img src="{{=p.image}}" class="rec-image" id="em{{= p.id }}image">
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
                    ScarabQueue.push(['category', "<?php
                    foreach ($crumbs2 as $key => $crumb):
                     if ($key != count($catalog->crumbs2()) - 1):  echo $crumb['name']." > ";  else: echo $crumb['name']; endif; 
                    endforeach;
                    ?>"]);
                    // Request personalized recommendations.
                    ScarabQueue.push(['recommend', {
                        logic: 'CATEGORY',
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
                                            $("#em"+o+"image").attr("src",data[o]["cover_image"]);
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
        <?php
        }
        else
        {
        ?>
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
                  <img src="{{=p.image}}" class="rec-image" id="em{{= p.id }}image">
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
        ScarabQueue.push(['category', '<?php
        foreach ($crumbs2 as $key => $crumb):
         if ($key != count($catalog->crumbs2()) - 1):  echo $crumb['name']." > ";  else: echo $crumb['name']; endif; 
        endforeach;
        ?>']);
        // Request personalized recommendations.
        ScarabQueue.push(['recommend', {
            logic: 'CATEGORY',
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
                $.ajax({
                        type: "POST",
                        url: "/site/emarsysdata?page=product",
                        dataType: "json",
                        data:"sku="+psku+"&lang=<?php echo LANGUAGE; ?>",
                        success: function(data){
                            for(var o in data){
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
                });
            }
        }]);
        </script>
        <div class="index-fashion buyers-show">
            <div class="phone-fashion-top w-tit">
                <h2>РЕКОМЕНДУЕМЫЕ ТОВАРЫ</h2>
            </div>
            <div class="flash-sale">
                <ul class="row" id="phone_scare"></ul>
            </div>  
        </div>
        <?php
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
						 str +="<li class='drop-down JS-show'>";
						 str +="<div class='drop-down-hd'>";
						 str +="<i class='myaccount'></i>";
						 str +="<span>Здравствуйте, "+rs.firstname+"!</span>";
						 str +="</div>";
						 str +="<dl class='drop-down-list JS-showcon hide' style='display:none;'>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/summary'>Личный кабинет</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/orders'>Мои Заказы</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/tracks/track_order'>Отслеживать заказ</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/wishlist'>Мой Список Пожеланий</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/profile'>Мой Профиль</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/logout'>Выход</a>";
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
						 str +="<li class='drop-down JS-show'>";
						 str +="<div class='drop-down-hd'>";
						 str +="<i class='myaccount'></i>";
						 str +="<span>Здравствуйте, Choieser!</span>";
						 str +="</div>";
						 str +="<dl class='drop-down-list JS-showcon hide' style='display:none;'>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/summary'>Личный кабинет</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/orders'>Мои Заказы</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/tracks/track_order'>Отслеживать заказ</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/wishlist'>Мой Список Пожеланий</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/profile'>Мой Профиль</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/logout'>Выход</a>";
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

        //ajax more color
        $.ajax({
            type: "POST",
            url: "/ajax/more_color",
            dataType: "json",
            data: "product_ids=<?php echo $product_str; ?>",
            success: function(res){
                for(var p in res){
                    var pid = res[p];
                    $("#more_color"+pid).show();
                }
            }
        });

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

        //ajax reviews
        $.ajax({
            type: "POST",
            url: "/ajax/review_data",
            dataType: "json",
            data: "product_ids=<?php echo $product_str; ?>",
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

<script type="text/javascript">
    var google_tag_params = {
        ecomm_prodid: '',           //SKU
        ecomm_pagetype: 'category',         // product
        ecomm_totalvalue: ''       // 
    };
</script>
<!-- lazyload -->
<script type="text/javascript" charset="utf-8" src="/assets/js/lazyload.js"></script>
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
            { event: "viewList", item: [
             <?php
            for ($i = 0; $i < 3; $i++)
            {
                ?>
                '<?php echo $products[$i]; ?>',
                <?php
            }
            ?>
            ] },

            { event: "flushEvents"},

            { event: "setAccount", account: 23688 },         
            { event: "setHashedEmail", email: "<?php echo !empty($user_session['email'])? md5($user_session['email']):' '; ?>" },
            { event: "setSiteType", type: m },           
            { event: "viewList", item: [
            <?php
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