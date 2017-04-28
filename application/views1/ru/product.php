<?php
if (strripos($_SERVER["HTTP_USER_AGENT"], 'ipad'))
{
    ?>
    <style>
        .pro_lookwith .right{ width:450px;}
    </style>
    <?php
}

$plink = $product->permalink();
$product_name = $product->get('name');
$pprice = $product->price();
?>
<link rel="canonical" href="<?php echo $plink; ?>" />
<!-- <link type="text/css" rel="stylesheet" href="/css/product.css" media="all" id="mystyle" /> -->
<meta property="og:title" content="<?php echo $product_name; ?> - Choies.com" />
<meta property="og:description" content="Shop <?php echo $product_name; ?> from choies.com .Free shipping Worldwide.<?php echo '$'.$pprice; ?>" />
<meta property="og:type" content="product" />
<meta property="og:url" content="<?php echo $plink; ?>" />
<meta property="og:site_name" content="Choies" />
<meta property="og:price:amount" content="<?php echo $pprice; ?>" />
<meta property="og:price:currency" content="USD" />
<meta property="og:availability" content="in stock" />
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
                    $product_id = $product->get('id');
                    if (!$current_catalog)
                        $current_catalog = $product->default_catalog();
                    $crumbs = Catalog::instance($current_catalog, LANGUAGE)->crumbs();
                    foreach ($crumbs as $crumb):
                        if ($crumb['id']):
                            ?>
                            &gt;  <a href="<?php echo $crumb['link']; ?>" rel="nofollow" ><?php echo $crumb['name']; ?></a>
                            <?php
                        endif;
                    endforeach;
                    ?>
                      <span class="hidden-xs">&gt;<?php echo $product_name; ?></span>
                </div>
               
            </div>
            <div class="product-view">
                <?php
                $message = Message::get();
                echo $message;
                ?>
                <!-- pro-left -->
                <div class="pro-left" style=" width:40%">
                    <div id="gallery">
                        <div id="JS_productPic" class="productpic loadding">
                            <?php if($product->get("extra_fee")==0){ ?>
                            <div class="myImages-icon"><img src="<?php echo STATICURL; ?>/assets/images/free-shipping.png" /></div>
                            <?php } ?>
                            <?php
                           if($show_ship_tip){

                            $key = Site::instance()->get('id') . '/catalog_id395';
                            $cache = Cache::instance('memcache');
                            if (!($data = $cache->get($key))){

                                $ready_shippeds = DB::select('product_id')->from('catalog_products')->where('catalog_id', '=', 395)->execute()->as_array();
                               $cache->set($key, $ready_shippeds, 600);
                           }
                           else
                           {
                                $ready_shippeds = $data;
                           }
                            }
                            else{
                                $ready_shippeds = array();
                            }
                            if(in_array(array('product_id' => $product_id), $ready_shippeds))
                            {
                                ?>
                                <div class="myImages-icon"><img src="<?php echo STATICURL; ?>/assets/images/ship-in24-3.png" /></div>
                                <?php
                            }
                            ?>
                            <!-- <div class="click-enlarge"><img src="<?php echo STATICURL; ?>/assets/images/click-enlarge.png"></div> -->
                            <?php
                            $cover = $product->cover_image();
                            ?>
                            <a href="<?php echo Image::link($cover, 9); ?>" class="picbox img480">
                                <img src="<?php echo Image::link($cover, 2); ?>" id="picture" alt="<?php echo $product_name; ?>" title="<?php echo $product_name; ?>">
                            </a>
                        </div>
                        <div class="firstthumbnail">
                            <span id="bigPrev" class="product-big-pic-left">
                            </span>
                            <span id="bigNext" class="product-big-pic-right">
                            </span>
                        </div>
                    </div>
                    <div class="hide">
                        <?php foreach ($product->images() as $key => $image): ?>
                            <img src="<?php echo Image::link($image, 2); ?>" />
                            <img src="<?php echo Image::link($image, 9); ?>" />
                        <?php endforeach; ?>
                    </div>
                    <div id="JS_thumbnail" class="thumbnail">
                        <span id="JS_thumbnailPrev" class="trigger prev prev-disabled">
                            prev
                        </span>
                        <div id="JS_thumbnailSlide" class="thumbnail-slide">
                            <ul class="thumbnail-list">
                            <?php foreach ($product->images() as $key => $image): ?>
                                <li class="list-item <?php if($key == 0) echo 'selected'; ?>">
                                    <a class="img60">
                                        <img src="<?php echo Image::link($image, 3); ?>" imgb="<?php echo Image::link($image, 2); ?>"
                                        bigimg="<?php echo Image::link($image, 9); ?>" alt="">
                                    </a>
                                </li>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                        <span id="JS_thumbnailNext" class="trigger next">
                            next
                        </span>
                    </div>
                    <div class="four-partake">
                        <span class='st_pinterest_hcount' displayText='Pinterest'></span>
                        <script type="text/javascript" src="https://w.sharethis.com/button/buttons.js"></script>
                        <script type="text/javascript">stLight.options({publisher: "76c0dd88-6e79-4e80-875e-7bc8934145b8", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
                        <span class='st_fblike_hcount' displayText='Facebook Like'></span>
                        <span class='st_facebook_hcount' displayText='Facebook'></span>
                        <!--<span class='st_twitter_hcount' displayText='Tweet'></span>-->
                        <span class='st_tumblr_hcount' displayText='Tumblr'></span>
                        <!--<script type="text/javascript" src="http://akwww.polyvorecdn.com/rsrc/add_to_polyvore.js"></script>
                        <a target="_blank" href="http://www.polyvore.com" name="addToPolyvore" id="addToPolyvore" data-product-url="<?php echo $plink; ?>" data-image-url="<?php echo Image::link($cover, 2); ?>" data-name="<?php $pname ?>" data-price="$|<?php echo $pprice; ?>"><img src="http://www.polyvore.com/rsrc/icons/embed/AddToPolyvore_61x20.png"/></a>--> 
                    </div>
                        <?php if($tags): ?>
                            <div class="tags hidden-xs">
                                <p class="fll img-tag"><img src="<?php echo STATICURL;?>/assets/images/tag.png"></p>
                                <div class="fll tags-detail">
                                    <h4 class="mb10">Метки</h4>
                                    <?php
                                    $tagtotal = Site::instance()->getalltag(LANGUAGE);

                                     foreach($tagtotal as $tag):
                                        if(in_array($tag['id'],$tags)){
                                      ?>
                                    <a href="<?php echo $tag['link'];?>"><?php echo $tag['name'];?></a> |
                                <?php   }
                                endforeach;
                                ?>

                                </div>
                            </div>
                        <?php endif; ?>
                </div>
                <div id="phoneProductPic" class="flexslider">
                    <ul class="slides">
                    <?php foreach ($product->images() as $key => $image): ?>
                        <li>
                            <div>
                                <img src="<?php echo Image::link($image, 1); ?>" alt="">
                            </div>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                </div>
                <div class="four-partake phone-size hidden-xs">
                    <span class='st_pinterest_hcount' displayText='Pinterest'></span>
                    <script type="text/javascript" src="https://w.sharethis.com/button/buttons.js"></script>
                    <script type="text/javascript">stLight.options({publisher: "76c0dd88-6e79-4e80-875e-7bc8934145b8", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
                    <span class='st_fblike_hcount' displayText='Facebook Like'></span>
                    <span class='st_facebook_hcount' displayText='Facebook'></span>
                    <!--<span class='st_twitter_hcount' displayText='Tweet'></span>-->
                    <span class='st_tumblr_hcount' displayText='Tumblr'></span>
                    <!--<script type="text/javascript" src="http://akwww.polyvorecdn.com/rsrc/add_to_polyvore.js"></script>
                    <a target="_blank" href="http://www.polyvore.com" name="addToPolyvore" id="addToPolyvore" data-product-url="<?php echo $plink; ?>" data-image-url="<?php echo Image::link($cover, 2); ?>" data-name="<?php $pname ?>" data-price="$|<?php echo $pprice; ?>"><img src="http://www.polyvore.com/rsrc/icons/embed/AddToPolyvore_61x20.png"/></a>--> 
                    </div>
                <!-- pro-right -->
                <div class="pro-right" style="margin-left:0px;">
                    <dl>
                        <dd>
                            <h3><?php echo $product_name; ?></h3>
                            <div class="pro-stock">
                                <?php
                                $instock = 1;
                                $stock = $product->get('stock');
                                if (!$product->get('status') OR ($stock == 0 AND $stock != -99))
                                    $instock = 0;
                                if($stock == -1 AND empty($stocks))
                                {
                                    $instock = 0;
                                }
                                ?>
                                <span class="stock-sp <?php if(!$instock) echo 'hide'; ?> hidden-xs" id="stock">В наличии</span>
                                <span class="stock-sp <?php if($instock) echo 'hide'; ?> hidden-xs" id="outstock">Нет в наличии</span>
                                 Товар#: <span id="product_sku"><?php echo $product->get('sku'); ?></span>
                                <?php
                                if(!empty($brands))
                                {
                                    ?>
                                    <a target="_blank" href="<?php echo LANGPATH; ?>/brand/list/<?php echo $brands['id']; ?>" class="ml10"><i>по <?php echo $brands['name']; ?></i></a>
                                    <?php
                                }
                                ?>
                                <?php if ($product->get('presell') > time()): ?>
                                <p>Предпродажа: <b class="red"><?php echo $product->get('presell_message'); ?></b></p>
                                <?php endif; ?>
                            </div>
                        </dd>
                <?php 
                $picsku1 = Kohana::config('sites.sku1');
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
                        if ($secondhalf && $secondhalf !=1):
                            $restrict = unserialize($secondhalf);
                            $has = DB::query(Database::SELECT, 'SELECT id FROM catalog_products WHERE product_id = ' . $product->get('id') . ' AND catalog_id IN (' . $restrict['restrict_catalog'] . ')')->execute()->get('id');
                            if ($has && !in_array($product->get('sku'),$picsku1)):
                                ?>
                                <dd>
                                    <div class=" mb10">
                                    <a href="<?php echo LANGPATH;?>/happy-thanksgiving-sale-c-478?hp1105" target="_blank"><img src="<?php echo STATICURL;?>/assets/images/pric-<?php echo LANGUAGE;?>.gif"></a>
                                    </div>
                                </dd>
                                <?php
                            endif;
                        endif; ?>
                        <dd>
                            <div class="price-box">
                                <p class="price">
                                    <?php
                                    $change_countries = array('CA', 'AU');
                                    $currency_change = '';
                                    if (isset($_GET['url_from']))
                                    {
                                        $currency = substr($_GET['url_from'], 0, 2);
                                        if (in_array($currency, $change_countries))
                                            $currency_change = $currency;
                                    }
                                    $p_price = $product->get('price');
                                    $price = $product->price();
                                    $customer_id = Customer::logged_in();
                                    $customer = Customer::instance($customer_id);
                                    $vip_level = $customer->get('vip_level');
                                    if ($vip_level)
                                    {
                                        if($vip_promotion_price AND $vip_level >= 1)
                                        {
                                            if ($p_price > $price)
                                            {
                                                $rate =  round((($p_price - $price) / $p_price) * 100);
                                                ?>
                                                    <del><?php echo $currency_change; ?><!--<span class="orign_price">--><?php echo Site::instance()->price($p_price, 'code_view'); ?><!--</span>--></del>   
                                                    <!--<span class="price_now">NOW  <?php // echo $currency_change; ?>--><span class="product_price red"><?php echo Site::instance()->price($price, 'code_view'); ?></span><!--</span>  -->
                                                    <i class="red"><?php if($rate > 0) echo $rate; ?>% OFF</i>
                                                <?php
                                            }else{
												?>
												<span style="font-size:24px;"><?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
												<?php
											}
                                        }
                                        else
                                        {
                                            if ($customer->is_celebrity())
                                            {
                                                if ($p_price > $price)
                                                {
                                                    $rate =  round((($p_price - $price) / $p_price) * 100);
                                                    ?>
                                                        <del><?php echo $currency_change; ?> <!--<span class="orign_price">--><?php echo Site::instance()->price($p_price, 'code_view'); ?> <!--</span>--></del>   
                                                        <!--<span class="price_now">NOW  <?php //echo $currency_change; ?>--><span class="product_price red"><?php echo Site::instance()->price($price, 'code_view'); ?></span><!--</span>-->  
                                                        <i class="red"><?php if($rate > 0) echo $rate; ?>% OFF</i>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                        <span style="font-size:24px;"><?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
                                                    <?php
                                                }
                                            }
                                            else
                                            {
                                                if(!$vip_level){
                                                   $vip = $vipconfig[0]; 
                                                }else{
                                                    $vip = $vipconfig[$vip_level]; 
                                                }
                                                $vip_price = round($p_price * $vip['discount'], 2);
                                                if ($price < $vip_price){
                                                    $vip_price = $price;
                                                }
                                                $rate = round((($p_price - $price) / $p_price) * 100);
                                                ?>
                                                <?php
                                                if($p_price > $price)
                                                {
                                                ?>
                                                    <del><?php echo $currency_change; ?><!--<span class="orign_price">--><?php echo Site::instance()->price($p_price, 'code_view'); ?><!--</span>--></del>   
                                                    <!--<span class="price_now">NOW  <?php //echo $currency_change; ?>--><span class="product_price red"><?php echo Site::instance()->price($price, 'code_view'); ?></span><!--</span>-->  
                                                    <i class="red"><?php if($rate > 0) echo $rate; ?>% OFF</i>
                                                <?php
                                                }
                                                else
                                                {
                                                ?>
                                                    <span style="font-size:24px;"><?php echo $currency_change; ?><span class="product_price red"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
                                                <?php
                                                }
                                                ?>
                                                &nbsp;<strong style="color:#FF5200;">VIP. Цена <?php echo $currency_change; ?><?php echo Site::instance()->price($vip_price, 'code_view'); ?></strong>
                                                <?php
                                            }
                                        }
                                    }
                                    else
                                    {
                                        if ($p_price > $price)
                                        {
                                            $rate =round((($p_price - $price) / $p_price) * 100);
                                            ?>
                                                <del><?php echo $currency_change; ?><!--<span class="orign_price">--><?php echo Site::instance()->price($p_price, 'code_view'); ?><!--</span>--></del>   
                                                <!--<span class="price_now"><?php // echo $currency_change; ?>--><span class="product_price red"><?php echo Site::instance()->price($price, 'code_view'); ?></span><!--</span>-->
                                                <i class="red"><?php if($rate > 0) echo $rate; ?>% OFF</i>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            
                                                Цена: <span style="font-size:24px;"><?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
                                            <?php
                                        }
                                    }
                                    ?>
                                </p>
                                <p class="pro-sign">
                                    <?php
                                    if (!$customer_id)
                                    {
                                        ?>
                                        
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    //vip spromotions price
                                    if($vip_promotion_price)
                                    {
                                        if($customer_id)
                                        {
                                            if($vip_level >= 1)
                                            {
                                                ?>
                                                    <strong style="color:#FF5200;">VIP. Цена  <span style="font-size: 16px;"><?php echo $currency_change; ?><?php echo Site::instance()->price($vip_promotion_price, 'code_view'); ?></span></strong>
                                                <?php
                                            }
                                        }
										/*
                                        else
                                        {
                                        ?>
                                            <strong style="color:#FF5200;">VIP. Цена <span style="font-size: 16px;"><?php echo $currency_change; ?><?php echo Site::instance()->price($vip_promotion_price, 'code_view'); ?></span></strong>
                                        <?php
                                        }
										*/
                                    }
                                    ?>
                                </p>
                            </div>
                           <!-- <div class="flr free">
                                <?php
                                // $codetext = DB::select()->from('banners')->where('type', '=', 'product')->where('lang', '=', '')->where('visibility', '=', 1)->execute()->current();
                                // if(!empty($codetext))
                                // {
                                ?>
                                    <a href="<?php // echo $codetext['link']; ?>" target="_blank"><img src="<?php echo STATICURL; ?>/simages/<?php //echo $codetext['image']; ?>" alt="<?php //echo $codetext['alt']; ?>" title="<?php //echo $codetext['title']; ?>" /></a>
                                <?php
                             //   }
                                ?>
                            </div>-->
                        </dd>
                        <dd>
                            <div class="review-box">
                                <div class="reviews">
                                <?php
                                $review_title = Kohana::config('review.' . LANGUAGE);
                                $overalls = explode('.', $reviews_data['overall']);
                                if(!isset($overalls[1]) || !$overalls[1])
                                {
                                    $star_num = $overalls[0];
                                }
                                else
                                {
                                    $star_num = $overalls[0] + 0.5;
                                }
                                $review_stars = '';
                                for($i = 0;$i < 5;$i ++)
                                {
                                    if($star_num > 0)
                                    {
                                        if($star_num == 0.5)
                                            $review_stars .= '<i class="fa fa-star-half-o"></i>';
                                        else
                                            $review_stars .= '<i class="fa fa-star"></i>';
                                    }
                                    else
                                    {
                                        $review_stars .= '<i class="fa fa-star-o"></i>';
                                    }
                                    $star_num --;
                                }
                                echo $review_stars;
                                ?>
                                    <span class="pc-review">(<a href="#review_list" style="font-weight:bold;font-size:10px;"><?php $count_reviews = count($reviews); echo $count_reviews; ?></a>)</span>
                                    <span class="phone-review">(<a href="#phone_review_list" style="font-weight:bold;font-size:10px;"><?php $count_reviews = count($reviews); echo $count_reviews; ?></a>)</span>
                                </div>
                                <img src="<?php echo STATICURL; ?>/assets/images/write1.jpg" style="margin-left:10px;">
                                <?php
                                if(!$customer_id)
                                {
                                ?>
                                    <a target="_blank" href="#" class="text-underline" id="write_review" style="" data-reveal-id="myModal4">Написать отзыв</a>
                                <?php
                                }
                                else
                                {
                                    ?>
                                    <a target="_blank" href="<?php echo LANGPATH; ?>/review/add/<?php echo $product_id; ?>" class="text-underline">Написать отзыв</a>
                                    <?php
                                }
                                ?>
                            </div>
                            <div id="action_form" class="JS-popwincon">
                            <p class="product-note-title" style="display:none;">Выберите размер!<b class="JS-close">&times; </b></p>
                                <form action="<?php echo LANGPATH; ?>/cart/add" method="post" id="formAdd" class="product-pl">
                                    <input type="hidden" name="id" id="product_id" value="<?php echo $product_id; ?>"/>
                                    <input type="hidden" name="items[]" value="<?php echo $product_id; ?>"/>
                                    <input type="hidden" name="type" id="product_type" value="<?php echo $product->get('type'); ?>"/>
                                    <input type="hidden" name="psku" id="product_psku" value="<?php echo $product->get('sku'); ?>"/>
                                    <input type="hidden" name="price" id="product_price" value="<?php echo $product->get('price'); ?>"/>
                                    <?php
                                    $set_id = $product->get('set_id');
                                    if (!empty($attributes['size']))
                                    {
                                        ?>
                                        <div class="btn-size" style=" margin-top:20px;">
                                            <div class="selected-box">
                                                <p class="fll">
                                                    <span id="select_size">Выберите размер:</span> <span class="selected"></span>
                                                    <span id="size_span" style="display:none;">Размер:<span id="size_show"></span></span>
                                                    <span id="only_left" class="red" style="display:none;">Only <span id="only_num"></span> left!</span>
                                                </p>
                                            </div>
                                            <input name="attributes[Size]" value="" class="s-size" type="hidden">
                                            <div class="clearfix">
                                                <ul class="size-list pc-size-choies" id="pc_size">
                                                <?php
                                                if($set_id == 2)
                                                {
                                                    $breifs = array();
                                                    $js_show = '';
                                                }
                                                else
                                                {
                                                    $brief = $product->get('brief');
                                                    $breifs = explode(';', $brief);
                                                    $js_show = 'JS-show';
                                                }
                                                if (isset($attributes['size']))
                                                {
                                                    if(count($attributes['size']) == 1)
                                                    {
                                                        $onesize = 1;
                                                    }else{
                                                        $onesize = 0;
                                                    }
                                                }
                                                $briefsArr = array();
                                                foreach($breifs as $b)
                                                {
                                                    $colon = strpos($b, ':');
                                                    $sizename = substr($b, 0, $colon);
                                                    $sizename = str_replace(array("\n", "<p>"), array(""), $sizename);
                                                    $sizebrief = substr($b, $colon + 1);
                                                    $briefsArr[trim($sizename)] = $sizebrief;
                                                }
                                                $phone_attrs = array();
                                                if (!empty($stocks))
                                                {
                                                    $key = 0;
                                                    foreach ($attributes['size'] as $attribute)
                                                    {
                                                       $attribute_name = $attribute;
                                                 if(strtolower($attribute) == 'one size')
                                                $attribute_name = 'только один размер';
                                                        $_phone = array();
                                                        $_phone['attribute'] = $attribute;
                                                        $_phone['stock'] = -1;
                                                        if(array_key_exists($attribute, $stocks))
                                                        {
                                                            $_phone['stock'] = $stocks[$attribute];
                                                            if($stocks[$attribute] == 0)
                                                            {
                                                                ?>
                                                                <li id="<?php echo $attribute; ?>" class="btn-size-normal on-border <?php echo $js_show; ?>" data-attr="<?php echo $attribute; ?>" disabled="disabled"><span><?php echo $attribute_name; ?></span></li>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <li title="<?php echo $stocks[$attribute]; ?>" id="<?php echo $attribute; ?>" class="btn-size-normal on-border <?php echo $js_show; ?>" data-attr="<?php echo $attribute; ?>"><span><?php echo $attribute_name; ?></span>
                                                                <?php
                                                            }
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <li title="0" id="<?php echo $attribute; ?>" class="btn-size-normal on-border <?php echo $js_show; ?>"><span><?php echo $attribute_name; ?></span>
                                                            <?php
                                                        }
                                                        ?>
                                                        <?php
                                                        if(isset($briefsArr[$attribute]))
                                                        {
                                                        ?>
                                                        <div class="size-dpn-box JS-showcon" style="display: none;">
                                                            <span class="dpn-icon"></span>
                                                            <div class="dpn-property loc0<?php echo $key + 1; ?>">
                                                                <p><?php echo $briefsArr[$attribute]; ?></p>
                                                                
                                                            </div>
                                                        </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        </li>
                                                        <?php
                                                        $key ++;
                                                        $phone_attrs[] = $_phone;
                                                    }
                                                }
                                                else
                                                {
                                                    $key = 0;
                                                    $str = array();
                                                    $newstr = array();
                                                    foreach ($attributes['size'] as $attribute)
                                                    {
                                                        $str[$attribute] = '';
														$attribute_name = $attribute;
                                                        if(strtolower($attribute) == 'one size')
                                                            $attribute_name = 'только один размер';
                                                        $_phone = array();
                                                        $_phone['attribute'] = $attribute;
                                                        $_phone['stock'] = -1;
                                                    ?>
                                                    <li id="<?php echo $attribute; ?>" class="btn-size-normal on-border <?php echo $js_show; ?>" data-attr="<?php echo $attribute; ?>">
                                                        <span><?php echo $attribute_name; ?></span>
                                                        <?php
                                                        if(isset($briefsArr[$attribute]))
                                                        {
                                                            //胸围产品product_id
                                                            if($set_id !=705){
                                                                $c_briefsArr=explode(',',$briefsArr[$attribute]);
                                                                foreach($c_briefsArr as $k=>$v){
                                                                    $sizes1=explode(':',$v);
                                                                    if(!isset($sizes1[1]))
                                                                        continue;
                                                                    $sizes1[1]=str_replace("cm","",$sizes1[1]);
                                                                    //判断是否带有'-'
                                                                    if(strpos($sizes1[1],'-')){
                                                                        $sizes1[1]=explode('-',$sizes1[1]);
                                                                        $yi=round($sizes1[1][0] * 0.39370078740157, 2);
                                                                        $er=round($sizes1[1][1] * 0.39370078740157, 2);
                                                                        $c[$attribute][]=$sizes1[0].':'.$yi.'-'.$er.'inch';
                                                                    }else{
                                                                        $i = round($sizes1[1] * 0.39370078740157, 2);
                                                                        $c[$attribute][]=$sizes1[0].':'.$i.'inch';
                                                                    }
                                                                    
                                                                }
                                                                //数组转字符串kai
                                                                if(!empty($c[$attribute]))
                                                                {
                                                                    foreach($c[$attribute] as $k1=>$v1){
                                                                        $str[$attribute] .= $v1.',';
                                                                    }
                                                                    
                                                                    $newstr[$attribute] = substr($str[$attribute],0,strlen($str[$attribute])-1); 
                                                                }
                                                                else
                                                                {
                                                                    $newstr[$attribute] = $briefsArr[$attribute];
                                                                }
                                                            }else{
                                                                $newstr[$attribute]=$briefsArr[$attribute];
                                                            }
                                                            
                                                        ?>
                                                        <div class="size-dpn-box JS-showcon hide">
                                                            <span class="dpn-icon"></span>
                                                            <div class="dpn-property loc0<?php echo $key + 1; ?>">
                                                                <p><?php echo $newstr[$attribute]; ?></p>
																<!--
                                                                <a class="size-quide fix" href="javascript:;" data-reveal-id="myModal3">Таблица размеров</a>
																-->
                                                            </div>
                                                        </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </li>
                                                    <?php
                                                    $key ++;
                                                    $phone_attrs[] = $_phone;
                                                    }
                                                }
                                                ?>
                                                </ul>
                                   <?php
                                $clothes = array(
                                    3,4,5,6,17,18,19,21,22,23,25,31,269,270,298,481,535,565,566,689,703,705
                                );
                                if(!in_array($set_id, $clothes))
                                {
                                ?> 
                                                <span class="size-charts pc-size-choies ml10">
                                                <a class="size-charts pc-size-choies" data-reveal-id="myModal3">Таблица Размеров</a>
                                                </span>
                                <?php
                                }
                                ?>
                                                

                                                <ul class="size-list pad-size-choies">
                                                    <?php 
                                                        $phone_k = 0;
                                                        foreach($phone_attrs as $phone) {
                                                            $attribute_name = $phone['attribute'];
                                                            if(strtolower($attribute) == 'one size') $attribute_name = 'только один размер';
                                                            if($phone['stock'] == -1) { 
                                                    ?>
                                                    <li id="<?php echo $phone['attribute']; ?>" class="btn-size-normal on-border JS-click-tip" data-attr="<?php echo $phone['attribute']; ?>">
                                                        <span><?php echo $attribute_name; ?></span>
                                                        <div class="size-dpn-box JS-clickcon-tip hide" style="display: none;">
                                                            <span class="dpn-icon"></span>
                                                            <?php if(isset($briefsArr[$phone['attribute']])) {?> 
                                                            <div class="dpn-property loc0<?php echo $phone_k + 1; ?>">
                                                                <p><?php echo $briefsArr[$phone['attribute']]; ?></p> 
                                                                <a class="size-quide fix JS-popwinbtn2"  href="javascript:;">Таблица размеров</a>
                                                            </div>
                                                            <?php }?>
                                                        </div>
                                                    </li>
                                                    <?php }elseif($phone['stock'] == 0){?>
                                                    <li id="<?php echo $phone['attribute']; ?>" class="btn-size-normal on-border JS-click-tip" data-attr="<?php echo $phone['attribute']; ?>" disabled="disabled">
                                                        <span><?php echo $attribute_name; ?></span>
                                                        <div class="size-dpn-box JS-clickcon-tip hide" style="display: none;">
                                                            <span class="dpn-icon"></span>
                                                            <?php if(isset($briefsArr[$phone['attribute']])) {?>
                                                            <div class="dpn-property loc0<?php echo $phone_k + 1; ?>">
                                                                <p><?php echo $briefsArr[$phone['attribute']]; ?></p>
                                                                <a class="size-quide fix JS-popwinbtn2"  href="javascript:;">Таблица размеров</a>
                                                            </div>
                                                            <?php }?>
                                                        </div>
                                                    </li>
                                                    <?php }else{?>
                                                    <li title="<?php echo $phone['stock'];?>" id="<?php echo $phone['attribute']; ?>" class="btn-size-normal JS-click-tip" data-attr="<?php echo $phone['attribute']; ?>">
                                                        <span><?php echo $attribute_name; ?></span>
                                                        <div class="size-dpn-box JS-clickcon-tip hide" style="display: none;">
                                                            <span class="dpn-icon"></span>
                                                            <?php if(isset($briefsArr[$phone['attribute']])) {?>
                                                            <div class="dpn-property loc0<?php echo $phone_k + 1; ?>">
                                                                <p><?php echo $briefsArr[$phone['attribute']]; ?></p>
                                                                <a class="size-quide fix JS-popwinbtn2"  href="javascript:;">Таблица размеров</a>
                                                            </div>
                                                            <?php }?>
                                                        </div>
                                                    </li>
                                                    <?php }}?>
                                                </ul>
                                                    <?php
                                                        $clothes = array(3,4,5,6,17,18,19,21,22,23,25,31,269,270,298,481,535,565,566,703,705);
                                                        if(!in_array($set_id, $clothes)){
                                                    ?> 
                                                    <span class="size-charts pad-size-choies ml10"><a href="javascript:;" class="big-link" data-reveal-id="myModal3">Tabla de tallas</a></span>
                                                    <?php }?>


                                                <ul class="size-list phone-size-choies" id="phone_size">
                                                <?php
                                                foreach($phone_attrs as $phone)
                                                {
                                                    if($phone['stock'] == -1)
                                                    {
                                                        ?>
                                                        <li id="<?php echo $phone['attribute']; ?>" class="btn-size-normal on-border" data-attr="<?php echo $phone['attribute']; ?>">
                                                            <span><?php echo $phone['attribute']; ?></span>
                                                        </li>
                                                        <?php
                                                    }
                                                    elseif($phone['stock'] == 0)
                                                    {
                                                        ?>
                                                        <li id="<?php echo $phone['attribute']; ?>" class="btn-size-normal on-border" data-attr="<?php echo $phone['attribute']; ?>" disabled="disabled">
                                                            <span><?php echo $phone['attribute']; ?></span>
                                                        </li>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <li id="<?php echo $phone['attribute']; ?>" title="<?php echo $phone['stock']; ?>" class="btn-size-normal" data-attr="<?php echo $phone['attribute']; ?>">
                                                            <span><?php echo $phone['attribute']; ?></span>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                </ul>
                                   <?php
                                $clothes = array(
                                    3,4,5,6,17,18,19,21,22,23,25,31,269,270,298,481,535,565,566,703,705
                                );
                                if(!in_array($set_id, $clothes))
                                {
                                ?> 
                                                <a class="size-charts phone-size-choies" style="float:none;" data-reveal-id="myModal3">Таблица размеров</a>
                                <?php
                                }
                                ?>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="total" style=" margin-top:15px;">
                                        <div class="same-paragraph">
                                            <ul class="color-choies" id="same_paragraph">
                                                <li class="current-color"><a><img width="50" src="<?php echo Image::link($product->cover_image(), 3) ?>"></a><b class="on"></b></li>
                                                
                                            </ul>
                                        </div>
                                        <div class="choise-size hide">
                                            <span class="size-qty">Qté:</span>
                                            <div class="p-size">
                                                <select class="s-input" name="quantity" id="cart_quantity">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                </select>     
                                            </div>
                                            </div>
                                        <div class="btn-buy">
                                        <?php
                                        if($instock)
                                        {
                                        ?>
                                        <?php if(!in_array($product_id,array('56351','56352'))){ ?>
                                            <input class="btn btn-primary btn-lg" id="addCart" value="Добавить в Корзину" type="submit" style="text-transform: none;">
                                        <?php   } ?>
                                        <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <button class="btn btn-primary btn-lg" disabled="disabled">Добавить в Корзину</button>
                                            <?php
                                        }
                                        ?>    
                                            <a onclick="wish_ajax_add()" class="wishlist" id="addWishList">
                                            <?php
                                            $keywishlists = 'site_wishlist/'.$product_id;
                                            $cache = Cache::instance('memcache');
                                            if (!($wishlists = $cache->get($keywishlists)))
                                            {
                                            $wishlists = DB::select(DB::expr('COUNT(id) AS count'))
                                                    ->from('accounts_wishlists')
                                                    ->where('product_id', '=', $product_id)
                                                    ->execute()->get('count');
                                                $cache->set($keywishlists, $wishlists, 3600);
                                            }
                                            ?>
                                            
                                            <?php
                                            //判断用户是否收藏
                                            $user_session = Session::instance()->get('user');
                                            if(!empty($user_session))
                                            {
                                                $wishlist_id = DB::select('id')
                                                    ->from('accounts_wishlists')
                                                    ->where('customer_id', '=', $user_session['id'])
                                                    ->where('product_id', '=', $product_id)
                                                    ->execute()->get('id');
                                                if($wishlist_id){
                                                    echo "<span id='xin' class='fa fa-heart '>";
                                                }else{
                                                    echo "<span id='xin' class='fa fa-heart-o '>";
                                                }
                                            }
                                            else
                                            {
                                                echo "<span id='xin' class='fa fa-heart-o'>";
                                            }
                                            ?>
                                            
                                            </span><span class="fa fa-heart" style="display:none;"></span>Избранное
                                            <?php
                                                if($wishlists){
                                                    ?>
                                                    <span id="wishlists">
                                                        <?php 
                                                         echo $wishlists ? '(' . $wishlists . ')' : '';
                                                        ?>
                                                    </span>
                                                    <?php
                                                }
                                            ?></a>
                                        </div>
                                            
                                        <script type="text/javascript">
                                            //判断屏幕宽度
                                            
                                            $(function(){
                                                 //获取浏览器宽度
                                            var _width = $(window).width(); 
                                            
                                             if(_width >= 768){
                                                //移除该div原本的样式，并添加w1024这个样式
                                                    $("#addWishList").addClass("hidden-xs");
                                                /*
                                                    //直接为该div添加w1024样式,会覆盖前一个样式
                                                    $(".w").addClass("w1024");
                                                     
                                                    //修改该div的class属性值为w1024
                                                    $(".w").attr("class","w1024");
                                                    */
                                             }else{
                                            
                                                $("#addWishList").addClass("hidden-sm hidden-md hidden-lg");
                                             }
                                             });
											 function wish_ajax_add(){
												 $.ajax({
													type: "POST",
													url: '/wishlist/ajax_add',
													dataType: "json",
													data: {product_id:<?php echo $product_id; ?>},
													success: function(msg){
														if(msg['success']==1){
															$("#xin").removeClass().addClass("fa fa-heart");
															$("#wishlists").html("("+msg['wishlists']+")");
														}else if(msg['success']==0){
															window.location.href="<?php echo LANGPATH; ?>/wishlist/add/<?php echo $product_id; ?>";
														}
													}
												});
											 }
                                        </script>
                                        <div class="same-paragraph same-paragraph1" style="display:none">
                                            <label>Другие Цветы:</label>
                                            <div id="same_paragraph1111"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <ul class="JS-tab detail-tab two-bor" style="margin-top:30px;">
                                <li class="dt-s1 current">Детали</li>
                                <?php
                                $models = '';
                                if($product->get('model_size'))
                                {
                                    $models .= 'Одежда Модели: ' . $product->get('model_size') . '<br><br>';
                                }
                                $model_id = $product->get('model_id');
                                if($model_id)
                                {
                                    $modelArr = DB::select()->from('models')->where('id', '=', $model_id)->execute()->current();
                                    if(!empty($modelArr))
                                    {
                                        $models .= ' Профиль Модели:<br>';
                                    }
                                    $models .= 'Name:' . $modelArr['name'] . '<br>';
                                    $ft = 0.0328084;
                                    $in = 0.3937008;
                                    $height_ft = round($modelArr['height'] * $ft, 1);
                                    $height_ft = str_replace(".", "'", $height_ft);
                                    $height_ft .= '"';
                                    $bust_in = round($modelArr['bust'] * $in, 1);
                                    $waist_in = round($modelArr['waist'] * $in, 1);
                                    $hip_in = round($modelArr['hip'] * $in, 1);
                                     $models .= 'Высота: ' . $height_ft .' | Обхват груди : ' . $bust_in . ' | Обхват талии : ' . $waist_in . ' | Обхват бедер : ' . $hip_in . '<br>';
                                      $models .= 'Высота в см: ' . $modelArr['height'] . '  | Обхват груди в см: ' . $modelArr['bust'] . ' | Обхват талии в см: ' . $modelArr['waist'] . ' | Обхват бедер в см: ' . $modelArr['hip'] . '<br>';
                                }
                                if($models)
                                {
                                    ?>
                                    <li class="dt-s1">модель</li>
                                    <?php
                                }
                                ?>
                                <li class="dt-s1">Доставка</li>
                                <li class="dt-s1">Контакт</li>
                                <p style="left: 0px;"><b></b></p>
                            </ul>
                            <div class="JS-tabcon detail-tabcon">
                                <div class="bd" id="tab-detail">
                                    <?php
                                    $keywords = $product->get('keywords');
                                    if($keywords)
                                    {
                                        echo '<p class="red">';
                                        echo str_replace("\n", "<br>", $keywords) . '<br><br>';
                                        echo '</p>';
                                    }
                                $sortArr_en = Kohana::config('sorts.en');
                                $sortArr_small = Kohana::config('sorts.' . LANGUAGE);
                                    if (!empty($filter_sorts))
                                    {
                                        echo '<table width="100%" class="pro_style_table">';
                                        foreach ($filter_sorts as $name => $sort)
                                        {
                                        $en_name = strtolower($name);
                                        if(in_array($en_name, $sortArr_en))
                                        {
                                            $small_key = array_keys($sortArr_en, $en_name);
                                            $small_name = $sortArr_small[$small_key[0]];
                                        }
                                        else
                                            $small_name = $name;

                                            echo '<tr><td width="40%" style="width:105px;float:left;font-weight:bold;"><p>' . strtoupper($small_name) . ':</p></td><td width="60%"><p>' . ucfirst($small_filter[strtolower($sort)]) . '</p></td></tr>';
                                        }
                                        echo '</table>';
                                        echo '<br>';
                                    }
                                    $description = $product->get('description');
                                    if($description) echo $description . '<br><br>';
									$brief = $product->get('brief');	
									$brief = str_replace(';', '<br>', $brief);
									//判断set_id
									
									$showinch=array(
										7,8,9,10,11,12,13,14,15,16,20,280,375,472,537,538,539,549,550,551,552,553,554,557,558,559,560,561,562,693,705
									);
									if(in_array($set_id, $showinch)){
										//胸围产品的id
                                        $nonec = '';
										if($set_id !=705){
											foreach($attributes['size'] as $ke=>$va){
												if(isset($newstr[$va]) && $newstr[$va]){
													echo $va.':'.$newstr[$va].'<br/>';
												}elseif($va=='one size' || $va=='One size' || $va == 'one size'){//如果他是One size 尺寸
													$brief1=substr($brief,12);//去掉onesize
													$onebrief=explode(',',$brief1);
													foreach($onebrief as $onebri){
														$onebri1=explode(':',$onebri);
														$onebri1=str_replace("cm","",$onebri1);
														
														//判断是否带有'-'
														if(strpos($onebri1[1],'-')){
															$onebri1[1]=explode('-',$onebri1[1]);
															$one1=round($onebri1[1][0] * 0.39370078740157, 2);
															$one2=round($onebri1[1][1] * 0.39370078740157, 2);
															$onec[]=$onebri1[0].':'.$one1.'-'.$one2.'inch';
															
														}else{
															$onei = round($onebri1[1] * 0.39370078740157, 2);
															$onec[]=$onebri1[0].':'.$onei.'inch';
														}
													}
													//数组转字符串kai
													foreach($onec as $onek=>$onev){
														$nonec .= $onev.',';
													}
													$newnonec = substr($nonec,0,strlen($nonec)-1); //去掉逗号
													echo 'one size:'.$newnonec.'<br/>';
												}
											}
										}else{
											echo $brief;
										}
											
									}else{
										echo $brief;
									}
                                    ?>
                                   <?php
                                $clothes = array(
                                    3,4,5,6,17,18,19,21,22,23,31,269,270,535,563,566,689,703,705
                                );
                                if(!in_array($set_id, $clothes))
                                {
                                ?> 
                                    <a class="fix" style="cursor:pointer;margin-top:3px;text-decoration: underline;font-weight: bold;" data-reveal-id="myModal3">Размер</a>
                                <?php
                                }
                                ?>
                                </div>
                                <?php
                                if($models)
                                {
                                ?>
                                <div class="bd hide">
                                    <?php
                                    echo '<p>' . $models . str_replace("\n", "<br>", $keywords) . '</p><br><br>';
                                    ?>
                                </div>
                                <?php
                                }
                                ?>
                        <div class="bd hide">
                            <p style="color:#F00;">Время приема= время обработки（3-5 рабочих дней） + время доставки</p>
                                <h4>Доставка:</h4>
                                <p>(1)  бесплатная доставка по всему миру (10-15 рабочих дней)</p>
                                <p style="color:#F00; padding-left:18px;">Нет минимальной суммы покупки</p>
                                <p>(2)  <?php echo Site::instance()->price(15, 'code_view'); ?> экспресс-доставка(4-7 рабочих дней)</p>
                                <p style="padding-left:18px;">Проверить детали в <a class="a_red" href="<?php echo LANGPATH; ?>/shipping-delivery" title="Отправка и доставка">Отправка и доставка</a></p>
                                <h4>Политики Возврата:</h4>
                                <p>Не устраивает ваш заказ, вы можете связаться с нами и вернуть его в течение 60 дней.</p>
                                <p>Если нет проблем качества с одеждой, мы не осуществляем возврат и обмен <span class="red">купальников и пижамы</span>. Проверить детали в <a class="a_red" href="<?php echo LANGPATH; ?>/returns-exchange" title="Политики Возврата">Политики Возврата</a>.</p>
                                <h4>Дополнительное Внимание:</h4>
                                <p>Заказы может быть облагаться импортными пошлинами, если вы хотите избежать дополнительных налогов в местный обычай,пожалуйста,свяжитесь с нами.Мы будем использовать почту Hong Kong.</p>
                            </div>
                                <div class="bd hide">
                                    <div class="LiveChat2  mt15 pl10">
                                        <a href="#" onclick="openLivechat();return false;"><img name="psSMPPimage" src="<?php echo STATICURL; ?>/assets/images/livechat_online1.gif" border="0" /> Чат</a>
                                    </div>
                                    <div class="LiveChat2 mt10 pl10"><a href="mailto:service_ru@choies.com"><img src="<?php echo STATICURL; ?>/assets/images/livemessage.png" alt="Leave Message" />Оставить сообщение</a></div>
                                    <div class="LiveChat2 mt10 pl10"><a href="<?php echo LANGPATH; ?>/faqs" target="_blank"><img src="<?php echo STATICURL; ?>/assets/images/faq.png" alt="FAQ" />ЧЗВ</a></div>
                                </div>
                            </div>
                          </dd>
                    </dl>
                </div>
                            <div class="phone-product-info col-sm-12">
                            <div class="accordion-group visible-phone">
                                <div class="accordion-heading JS-toggle">
                                    <a class="accordion-toggle " href="javascript:void(0);">Детали
                                        <i class="fa flr fa-caret-down"></i>
                                    </a>
                                </div>
                                <?php
                                $keywords = $product->get('keywords');
                                if($keywords)
                                {
                                    echo '<p class="red">';
                                    echo str_replace("\n", "<br>", $keywords) . '<br><br>';
                                    echo '</p>';
                                }
                                $models = '';
                                if($product->get('model_size'))
                                {
                                    $models .= 'Одежда Модели: ' . $product->get('model_size') . '<br><br>';
                                }
                                $model_id = $product->get('model_id');
                                if($model_id)
                                {
                                    $modelArr = DB::select()->from('models')->where('id', '=', $model_id)->execute()->current();
                                    if(!empty($modelArr))
                                    {
                                         $models .= ' Профиль Модели:<br>';
                                    }
                                    $models .= 'Nom:' . $modelArr['name'] . '<br>';
                                    $ft = 0.0328084;
                                    $in = 0.3937008;
                                    $height_ft = round($modelArr['height'] * $ft, 1);
                                    $height_ft = str_replace(".", "'", $height_ft);
                                    $height_ft .= '"';
                                    $bust_in = round($modelArr['bust'] * $in, 1);
                                    $waist_in = round($modelArr['waist'] * $in, 1);
                                    $hip_in = round($modelArr['hip'] * $in, 1);
                                      $models .= 'Высота: ' . $height_ft .' | Обхват груди : ' . $bust_in . ' | Обхват талии : ' . $waist_in . ' | Обхват бедер : ' . $hip_in . '<br>';
                                   $models .= 'Высота в см: ' . $modelArr['height'] . '  | Обхват груди в см: ' . $modelArr['bust'] . ' | Обхват талии в см: ' . $modelArr['waist'] . ' | Обхват бедер в см: ' . $modelArr['hip'] . '<br>';
                                }  ?>
                                <div class="accordion-body JS-toggle-box hide" style="display:block;">
                                    <div class="accordion-inner">
                                        <ul class="unstyled">
                                            <div class="bd">
                                                <!--手机kai-->
											<?php
											$description = $product->get('description');
                                    if($description) echo $description . '<br><br>'; 
                                    $brief = $product->get('brief');	
									$brief = str_replace(';', '<br>', $brief);
									//判断set_id
									$showinch=array(
										7,8,9,10,11,12,13,14,15,16,20,280,375,472,537,538,539,549,550,551,552,553,554,557,558,559,560,561,562,693,705
									);
									if(in_array($set_id, $showinch)){
										//胸围产品的id
										if($set_id !=705){
											foreach($attributes['size'] as $ke=>$va){
												if(isset($newstr[$va]) && $newstr[$va]){
													echo $va.':'.$newstr[$va].'<br/>';
												}elseif($va=='one size' || $va=='One size'){//如果他是One size 尺寸
													$brief1=substr($brief,12);//去掉onesize
													$onebrief=explode(',',$brief1);
													foreach($onebrief as $onebri){
														$onebri1=explode(':',$onebri);
														$onebri1=str_replace("cm","",$onebri1);
														
														//判断是否带有'-'
														if(strpos($onebri1[1],'-')){
                                                            if(!isset($sizes1[1]))
                                                                continue;
															$onebri1[1]=explode('-',$onebri1[1]);
															$one1=round($onebri1[1][0] * 0.39370078740157, 2);
															$one2=round($onebri1[1][1] * 0.39370078740157, 2);
															$onec[]=$onebri1[0].':'.$one1.'-'.$one2.'inch';
															
														}else{
															$onei = round($onebri1[1] * 0.39370078740157, 2);
															$onec[]=$onebri1[0].':'.$onei.'inch';
														}
													}
													//数组转字符串kai
													foreach($onec as $onek=>$onev){
														$nonec .= $onev.',';
													}
													$newnonec = substr($nonec,0,strlen($nonec)-1); //去掉逗号
													echo 'one size:'.$newnonec.'<br/>';
												}
											}
										}else{
											echo $brief;
										}
											
									}else{
										echo $brief;
									}
											?>
                                                </div>  
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if($models)
                                {
                                    ?>
                                <div class="accordion-group visible-phone">
                                        <div class="accordion-heading JS-toggle">
                                            <a class="accordion-toggle " href="javascript:void(0);">MODEL INFO
                                                <i class="fa flr fa-caret-down"></i>
                                            </a>
                                        </div>
                                        <div class="accordion-body JS-toggle-box hide">
                                            <div class="accordion-inner">
                                                <ul class="unstyled">
                                                    <div class="bd">
                                                    <?php
                                                    echo '<p>' . $models . str_replace("\n", "<br>", $keywords) . '</p><br>';
                                                    ?>                                                  
                                                    </div>  
                                                </ul>
                                            </div>                                                      
                                        </div>
                                    </div>
                                <?php
                            }
                            ?>
                            <div class="accordion-group visible-phone">
                            <div id="phone_review_list"></div>
                                <div class="accordion-heading JS-toggle">
                                    <a class="accordion-toggle " href="javascript:void(0);">Доставка
                                        <i class="fa flr fa-caret-down"></i>
                                    </a>
                                </div>
                                <div class="accordion-body JS-toggle-box hide">
                                    <div class="accordion-inner">
                                        <ul class="unstyled">
                                            <div class="bd">
                           <p style="color:#F00;">Время приема= время обработки（3-5 рабочих дней） + время доставки</p>
                                <h4>Доставка:</h4>
                                <p>(1)  бесплатная доставка по всему миру (10-15 рабочих дней)</p>
                                <p style="color:#F00; padding-left:18px;">Нет минимальной суммы покупки</p>
                                <p>(2)  <?php echo Site::instance()->price(15, 'code_view'); ?> экспресс-доставка(4-7 рабочих дней)</p>
                                <p style="padding-left:18px;">Проверить детали в <a class="a_red" href="<?php echo LANGPATH; ?>/shipping-delivery" title="Отправка и доставка">Отправка и доставка</a></p>
                                <h4>Политики Возврата:</h4>
                                <p>Не устраивает ваш заказ, вы можете связаться с нами и вернуть его в течение 60 дней.</p>
                                <p>Если нет проблем качества с одеждой, мы не осуществляем возврат и обмен <span class="red">купальников и пижамы</span>. Проверить детали в <a class="a_red" href="<?php echo LANGPATH; ?>/returns-exchange" title="Политики Возврата">Политики Возврата</a>.</p>
                                <h4>Дополнительное Внимание:</h4>
                                <p>Заказы может быть облагаться импортными пошлинами, если вы хотите избежать дополнительных налогов в местный обычай,пожалуйста,свяжитесь с нами.Мы будем использовать почту Hong Kong.</p>
                                            </div>  
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group visible-phone">
                                <div class="accordion-heading JS-toggle">
                                    <a class="accordion-toggle " href="javascript:void(0);">КОНТАКТ
                                        <i class="fa flr fa-caret-down"></i>
                                    </a>
                                </div>
                                <div class="accordion-body JS-toggle-box hide">
                                    <div class="accordion-inner">
                                        <ul class="unstyled">
                                            <div class="mt10 ml10">
                                                <a href="#" onclick="openLivechat();return false;">
                                                    <img id="comm100-button-311img" alt="" style="border:none;" src="<?php echo STATICURL; ?>/assets/images/livechat_online1.gif"> Live chat
                                                </a>
                                            </div>
                                            <div class="mt10 ml10">
                                                <a href="mailto:<?php echo Site::instance()->get('email'); ?>">
                                                    <img src="<?php echo STATICURL; ?>/assets/images/livemessage.png" alt="Leave Message"> Оставить сообщение
                                                </a>
                                            </div>
                                            <div class="mt10 ml10">
                                                <a href="<?php echo LANGPATH; ?>/faqs" target="_blank">
                                                    <img src="<?php echo STATICURL; ?>/assets/images/faq.png" alt="FAQ"> ЧЗВ
                                                </a>
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group visible-phone">
                                <div class="accordion-heading JS-toggle">
                                    <a class="accordion-toggle " href="javascript:void(0);">Отзывы покупателей
                                        <i class="fa flr fa-caret-down"></i>
                                    </a>
                                </div>
                                <div class="accordion-body JS-toggle-box hide">
                                <?php
                                if(empty($reviews))
                                {
                                ?>
                                    <div class="reviews-sign mb20">
                                    <p>БУДЬТЕ ПЕРВЫМ, ВЫСКАЖИТЕ СВОЕ МНЕНИЕ</p>
                                    <a target="_blank" href="<?php echo LANGPATH; ?>/review/add/<?php echo $product_id; ?>" class="text-underline ml20" style="text-decoration: underline;">Написать Отзыв</a>                                    
                                    </div>
                                <?php
                                }
                                else
                                {
                                    ?>  
                                    <div class="reviews-sign mb20">
                                    <?php
                                    $r_limit = 3;
                                    $r_pages = ceil($count_reviews / $r_limit);
                                    for($i = 1;$i <= $r_pages;$i ++)
                                    {
                                    ?>                  
                                    <ul class="con reviews-box <?php if($i > 1) echo 'hide'; ?>" id="page_<?php echo $i; ?>">
                                        <?php
                                        for($j = ($i - 1) * $r_limit;$j < $i * $r_limit;$j ++)
                                        {
                                            if($j >= $count_reviews)
                                                break;
                                            $r = $reviews[$j];
                                            $firstname = $r['firstname'];
                                            if(!$firstname)
                                                $firstname = 'Choieser';
                                            $attrs = explode(':', $r['attribute']);
                                            if(strtolower($attrs[0]) == 'size')
                                                $size = $attrs[1];
                                            $size = str_replace(';', '', $size);
                                        ?>
                                        <li>
                                            <div class="clearfix">
                                                <strong class="fll"><?php echo $r['overall']; ?> Звёзды</strong>
                                                <span class="time flr"><?php echo $firstname; ?> on <?php echo date('d M Y', $r['time']); ?></span>
                                            </div>
                                        <?php
                                        if(strlen($r['content']) > 400)
                                        {
                                            $front_400 = substr($r['content'], 0, 400);
                                            $remain = substr($r['content'], 400);   ?>
                                             <p><?php echo $remain; ?></p>                      
                                        <?php
                                        }else
                                        {
                                            ?>
                                            <p><?php echo $r['content']; ?></p>
                                            <?php
                                        }
                                        ?>                                        
                                        </li>         
                                        <?php
                                    }
                                    ?>
                                    </ul>       
                                    <?php
                                }
                                ?>    
                                <a target="_blank" href="<?php echo LANGPATH; ?>/review/add/<?php echo $product_id; ?>" class="text-underline ml20" style="text-decoration: underline;">Написать отзыв</a>
                                <div class="clearfix flr" id="review_pagination">
                                <?php
                                $pagination = Pagination::factory(array(
                                    'current_page' => array('source' => 'query_string', 'key' => 'page'),
                                    'total_items' => $count_reviews,
                                    'items_per_page' => $r_limit,
                                    'view' => LANGPATH . '/pagination_2'));
                                echo $pagination->render();
                                ?>
                                </div>
                            </div>
                            <script>
                            $(function(){
                                $("#review_pagination .pagination a").live('click', function(){
                                    var page = $(this).attr('title');
                                    $(".customer-reviews .reviews-box").addClass('loadding');
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo LANGPATH; ?>/review/pagination?page=" + page,
                                        dataType: "json",
                                        data: "count=<?php echo $count_reviews; ?>&limit=<?php echo $r_limit; ?>",
                                        success: function(msg){
                                            setTimeout(function(){ 
                                                $(".customer-reviews .reviews-box").removeClass('loadding');
                                                $("#review_pagination").html(msg);
                                                $(".reviews-box").hide()
                                                $("#page_" + page).show();
                                            }, 1000);
                                        }
                                    });
                                    return false;
                                })
                            })
                            </script>
                   <?php
                        }
                        ?>
                    </div>
                   
                    </div>
                </div>  
            </div>
                <div class="four-partake phone-size hidden-sm hidden-md hidden-lg">
                    <span class='st_pinterest_hcount' displayText='Pinterest'></span>
                    <script type="text/javascript" src="https://w.sharethis.com/button/buttons.js"></script>
                    <script type="text/javascript">stLight.options({publisher: "76c0dd88-6e79-4e80-875e-7bc8934145b8", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
                    <span class='st_fblike_hcount hidden-xs' displayText='Facebook Like'></span>
                    <span class='st_facebook_hcount' displayText='Facebook'></span>
                    <!--<span class='st_twitter_hcount' displayText='Tweet'></span>-->
                    <span class='st_tumblr_hcount' displayText='Tumblr'></span>
                    <!--<script type="text/javascript" src="http://akwww.polyvorecdn.com/rsrc/add_to_polyvore.js"></script>
                    <a target="_blank" href="http://www.polyvore.com" name="addToPolyvore" id="addToPolyvore" data-product-url="<?php echo $plink; ?>" data-image-url="<?php echo Image::link($cover, 2); ?>" data-name="<?php $pname ?>" data-price="$|<?php echo $pprice; ?>"><img src="http://www.polyvore.com/rsrc/icons/embed/AddToPolyvore_61x20.png"/></a>--> 
                    </div>
        
            <?php
            $has_link = $product->get('has_link');
            if(!empty($celebrity_images) || ($has_link == 1 AND !empty($link_images)) || (isset($videos) AND !empty($videos)))
            {
            ?>
            <div class="buyshow-box">
                <ul class="JS-tab getlook-tab two-bor">
                    <?php
                    $buys_show = 0;
                    $get_look = 0;
                    $video_client = 0;
                    $current = 0;
                    if(!empty($celebrity_images))
                    {
                        $buys_show = 1;
                    }
                    if ($has_link == 1 AND !empty($link_images))
                    {
                        if(empty($celebrity_images))
                            $current = 1;
                        $get_look = 1;
                    }
                    if (isset($videos) AND !empty($videos))
                    {
                        if ($has_link == 0 AND empty($link_images) AND empty($celebrity_images))
                            $current = 2;
                        $video_client = 1;
                    }
                    ?>
                    <li class="dt-s2 <?php if($current == 0) echo 'current'; ?>" style="margin-left:30% <?php if(!$buys_show) echo 'display:none;' ?>">Шоу Покупателей</li>
                    <li class="dt-s2 <?php if($current == 1) echo 'current'; ?>" style="<?php if(!$get_look) echo 'display:none;'; ?>">Получить Этот</li>
                    <li class="dt-s2 <?php if($current == 2) echo 'current'; ?>" style="<?php if(!$video_client) echo 'display:none;'; ?>">VIDEO CLIENT</li>
                    <p style="left: 0px; width: 150px; margin-left:30%"><b></b></p>
                </ul>
                
                <?php
                if(!empty($celebrity_images))
                {
                ?>
                <div class="JS-tabcon getlook-tabcon">
                    <div class="bd">
                        <div class="product-carousel">
                            <ul>
                            <?php
                            $celebrity_lists = array();
                            $count = count($celebrity_images);
                            $cel_num = $count > 8 ? 8 : $count;
                            for($i = 0;$i < $cel_num;$i ++)
                            {
                                $c_image = $celebrity_images[$i];
                                $cel_id = (int) $c_image['link_sku'];
                                if($cel_id AND !in_array($cel_id, $celebrity_lists))
                                {
                                    $celebrity_lists[] = $cel_id;
                                }
                                ?>
                                <li>
                                    <a target="_blank" href="<?php echo LANGPATH; ?>/lookbook/<?php echo $c_image['id']; ?>-1" <?php if($i % 8 == 0){ echo 'style="display:block;"';}elseif($i % 4 == 3){ echo 'style="margin:0;"'; } ?>>
                                        <img src="<?php echo STATICURL; ?>/simg/<?php echo $c_image['image']; ?>">
                                    </a>
                                </li>
                            <?php
                            }
                            $grey = (8 - $cel_num) % 4;
                            if($grey == 4)
                                $grey = 0;
                            for($k = 1;$k <= $grey;$k ++)
                            {
                                ?>
                                <li>
                                    <img src="<?php echo STATICURL; ?>/assets/images/bantou.jpg" />
                                </li>
                                <?php
                            }
                            ?>
                            </ul>
                        <?php
                        if($count > 8)
                        {
                            ?>
                            <ul class="more-view" style="display:none;">
                            <?php
                            for($j = 8;$j < $count;$j ++)
                            {
                                if($j >= $count)
                                    continue;
                                $c_image = $celebrity_images[$j];
                                $cel_id = (int) $c_image['link_sku'];
                                if($cel_id AND !in_array($cel_id, $celebrity_lists))
                                {
                                    $celebrity_lists[] = $cel_id;
                                }
                                ?>
                                <li>
                                    <a target="_blank" href="<?php echo LANGPATH; ?>/lookbook/<?php echo $c_image['id']; ?>-1" <?php if($j % 8 == 0){ echo 'style="display:block;"';}elseif($j % 4 == 3){ echo 'style="margin:0;"'; } ?>>
                                        <img src="<?php echo STATICURL; ?>/simg/<?php echo $c_image['image']; ?>">
                                    </a>
                                </li>
                            <?php
                            }
                            $grey = 4 - $count % 4;
                            if($grey == 4)
                                $grey = 0;
                            for($k = 1;$k <= $grey;$k ++)
                            {
                                ?>
                                <li>
                                    <img src="<?php echo STATICURL; ?>/assets/images/bantou.jpg" />
                                </li>
                                <?php
                            }
                            ?>
                            </ul>
                            <div class="bt-view"><p>Смотреть более</p></div>
                        <?php
                        }
                        ?>
                        </div>  
                    </div>
                    <?php
                    $skus = '';
                    if ($has_link == 1 AND !empty($link_images))
                    {
                    ?>
                    <div class="bd hide">
                        <div class="pro-lookwith">
                        <?php
                        foreach ($link_images as $key => $link_img)
                        {
                            ?>
                            <ul <?php if($key > 0) echo 'class="more-view mt10 hide"'; ?>>
                                <li style="width:35%;">
                                    <img src="<?php echo STATICURL; ?>/limg/<?php echo $link_img['image']; ?>">
                                </li>
                                <li style="width:65%;">
                                    <div class="clearfix">
                                    <?php
                                    $skus = explode(',', $link_img['link_sku']);
                                    if (is_array($skus))
                                    {
                                        $n = 1;
                                        foreach ($skus as $sku)
                                        {
                                            $pro_id = Product::get_productId_by_sku(trim($sku));
                                            $link_pro = Product::instance($pro_id, LANGUAGE);
                                            if (!$link_pro->get('visibility'))
                                            {
                                                continue;
                                            }
                                            if ($n > 5)
                                            {
                                                break;
                                            }
                                            $n++;
                                            ?>
                                            <div class="fashion-code">
                                                <?php
                                                $orig_price = round($link_pro->get('price'), 2);
                                                $price = round($link_pro->price(), 2);
                                                ?>
                                                <a href="<?php echo $link_pro->permalink(); ?>" target="_blank"><img title="<?php echo $link_pro->get('name'); ?>" alt="<?php echo $link_pro->get('name'); ?>" src="<?php echo Image::link($link_pro->cover_image(), 7); ?>" /></a>
                                                <p class="price center">
                                                    <?php
                                                    if ($orig_price > $price)
                                                    {
                                                        ?>
                                                        <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del>
                                                        <?php echo Site::instance()->price($price, 'code_view'); ?>
                                                        
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        echo Site::instance()->price($link_pro->get('price'), 'code_view');
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        <?php
                                        }
                                    }
                                    ?>
                                    </div>
                                    <a class="btn btn-primary btn-lg flr" title="<?php echo $key; ?>" data-reveal-id="myModal5">ПОЛУЧИТЬ ЭТОТ</a>
                                </li>
                            </ul>
                            <?php
                        }
                        ?>
                        <?php
                        if($key > 0)
                        {
                            ?>
                            <div class="bt-view a-underline mt10"><p>View More+</p></div>
                            <?php
                        }
                        ?>
                        </div>  
                    </div>
                    <?php
                    }
                    ?>
                    <div class="bd <?php if (($has_link == 1 AND !empty($link_images)) || !empty($celebrity_images)) echo 'hide'; ?>">
                    <?php
                    if (isset($videos) AND !empty($videos))
                    {
                    ?>    
                        <div class="video-client">
                            <div class="JS-tabcon-v img-big fll">
                            <?php
                            foreach ($videos as $key => $video):
                                ?>
                                <div class="bd-v <?php if($key > 0) echo 'hide'; ?>" id="video<?php echo $key; ?>">
                                    <object type="application/x-shockwave-flash" style= "width:600px; height:350px; border: #333 1px solid; margin-bottom:5px;"
                                            data="http://www.youtube.com/v/<?php echo $video['url_add']; ?>?">
                                        <param name="movie" value="http://www.youtube.com/v/<?php echo $video['url_add']; ?>?"/>
                                    </object>
                                </div>
                                <?php
                            endforeach;
                            ?>
                            </div>    
                            <ul class="JS-tab-v right flr">
                                <?php
                                foreach ($videos as $key => $video)
                                {
                                    $url = substr($video['url_add'], 0, 11);
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, 'http://gdata.youtube.com/feeds/api/videos/' . $url);
                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                                    $response = curl_exec($ch);
                                    curl_close($ch);
                                    if (strpos($response, 'xml') === FALSE)
                                        $response = '';
                                    if ($response)
                                    {
                                        $xml = new SimpleXMLElement($response);
                                        $title = (string) $xml->title;
                                        $author = (string) $xml->author->name;
                                    }
                                    else
                                    {
                                        $title = "No Title";
                                        $author = "No author";
                                    }
                                    ?>
                                    <li class="current-v" title="video<?php echo $key; ?>">
                                        <div class="img"><img height="100px" src="http://i1.ytimg.com/vi/<?php echo $video['url_add']; ?>/mqdefault.jpg" imgb="" /></div>
                                        <div class="con">
                                            <p class="tit"><?php echo $title; ?></p>
                                            <p class="name">by: <?php echo $author; ?></p>
                                        </div>
                                    </li>
                                    <?php
                                }
                                ?>
                                <!-- only one -->
                                <li class="less">
                                    <a href="<?php echo LANGPATH; ?>/blogger/programme">
                                    Есть ли у вас собственный модный блог?Присоединитесь CHOIES!<br />
                                    Программа Модных Блогеров Сейчас! >>
                                    </a>
                                </li>
                            </ul>    
                        </div>
                    <?php
                    }
                    ?>
                    </div>
                </div>
                <?php
                }
                ?>
                <script type="text/javascript">
                    $(function(){
                        $(".JS-popwinbtn4").click(function(){
                            var id = $(this).attr('title');
                            $("#form" + id).show().siblings().hide();
                        })
                    })
                </script>
                <?php
                if (isset($skus) && is_array($skus))
                {
                ?>
<div id="myModal5" class="reveal-modal xlarge">
        <a class="close-reveal-modal close-btn3"></a>
                    <!-- look-box -->
                    <div class="look-pro">
                    <?php
                    foreach ($link_images as $key => $link_img)
                    {
                        $skus = explode(',', $link_img['link_sku']);
                        if (!empty($skus))
                        {
                            $wishlist = array();
                            $n = 1;
                            ?>
                            <form action="<?php echo LANGPATH; ?>/cart/add_more" method="post" class="form3" id="form<?php echo $key; ?>">
                                <input name="page" value="product" type="hidden">
                                <div class="clearfix items<?php echo $key; ?>">
                                    <ul class="scrollableDiv1 scrollableDivs<?php echo $key; ?>">
                                    <?php
                                    foreach ($skus as $sku)
                                    {
                                        $pro_id = Product::get_productId_by_sku(trim($sku));
                                        $link_pro = Product::instance($pro_id, LANGUAGE);
                                        if (!$link_pro->get('visibility'))
                                        {
                                            continue;
                                        }
                                        if ($n > 5)
                                        {
                                            break;
                                        }
                                        $n++;
                                            $wishlist[] = $pro_id;
                                            $orig_price = round($link_pro->get('price'), 2);
                                            $price = round($link_pro->price(), 2);
                                        $sku_link = $link_pro->permalink();
                                        ?>
                                        <li>
                                            <input type="checkbox" name="check[<?php echo $n; ?>]" title="size<?php echo $n; ?>" class="checkbox" checked="checked" id="checkout<?php echo $pro_id . $key; ?>" /> <label for="checkout<?php echo $pro_id . $key; ?>">Добавить в корзину</label>
                                            <input type="hidden" name="item[<?php echo $n; ?>]" value="<?php echo $pro_id; ?>" />
                                            <a href="<?php echo $sku_link; ?>"><img src="<?php echo Image::link($link_pro->cover_image(), 3); ?>" /></a>
                                            <a href="<?php echo $sku_link; ?>" class="name"><?php echo $link_pro->get('name'); ?> </a>
                                            <p class="price">
                                                <?php
                                                if ($orig_price > $price)
                                                {
                                                    ?>
                                                    <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del> <b class="red font18"><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <b class="red font18"><?php echo Site::instance()->price($link_pro->get('price'), 'code_view'); ?></b>
                                                    <?php
                                                }
                                                ?>
                                            </p>
                                            <?php
                                            $instock = 1;
                                            $stock = $link_pro->get('stock');
                                            $stocks = array();
                                            $pro_stocks = array();
                                            if (!$link_pro->get('status') OR ($stock == 0 AND $stock != -99))
                                            {
                                                $instock = 0;
                                            }
                                            elseif ($stock == -1)
                                            {
                                                $stocks = DB::select()->from('products_stocks')->where('product_id', '=', $pro_id)->where('stocks', '>', 0)->execute()->as_array();
                                                if (count($stocks) == 0)
                                                    $instock = 0;
                                                else
                                                {
                                                    foreach ($stocks as $s)
                                                    {
                                                        $pro_stocks[$s['attributes']] = $s['stocks'];
                                                    }
                                                }
                                            }
                                            ?>
                                            <p class="select">Размер: 
                                                <select name="size[<?php echo $n; ?>]" class="size_select" <?php if(!$instock) echo 'disabled="disabled"'; ?>>
                                                    <?php
                                                    $is_onesize = 0;
                                                    $set = $link_pro->get('set_id');
                                                    if(!empty($pro_stocks))
                                                    {
                                                        echo '<option>Размер</option>';
                                                        foreach($pro_stocks as $size => $p)
                                                        {
                                                            $sizeval = $size;
                                                            if($set == 2)
                                                            {
                                                                    $sizeArr = explode('/', $size);
                                                                    $sizeval = $sizeArr[2];
                                                            }
                                                        ?>
                                                        <option value="<?php echo str_replace('EUR', '', $sizeval); ?>" ><?php echo $sizeval; ?> <span class="red">(Only <?php echo $p; ?>  left)</span></option>
                                                        <?php
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $attributes = $link_pro->get('attributes');
                                                        if (isset($attributes['Size']))
                                                        {
                                                            if(count($attributes['Size']) == 1)
                                                                $is_onesize = 1;
                                                            else
                                                                echo '<option>выбрать размер</option>';
                                                            foreach ($attributes['Size'] as $size)
                                                            {
                                                                $sizeval = $size;
                                                                if($set == 2)
                                                                {
                                                                        $sizeArr = explode('/', $size);
                                                                        $sizeval = $sizeArr[2];
                                                                }
                                                                $sizeSmall = str_replace(array('One size', 'one size', 'One Size'), 'только один размер', $sizeval);
                                                                ?>
                                                                    <option value="<?php echo str_replace('EUR', '', $sizeval); ?>" ><?php echo $sizeSmall; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $is_onesize = 1;
                                                            ?>
                                                            <option value="one size" <?php if (isset($pro_stocks['one size'])) echo 'title="' . $pro_stocks['one size'] . '"' ?>>Размер</option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <input type="hidden" class="size_input" name="size<?php echo $n; ?>" value="<?php if($is_onesize) echo 1; ?>" />
                                            </p>
                                            <p class="select">Количество:<input type="text" class="text" name="qty[<?php echo $n; ?>]" value="1" <?php if(!$instock) echo 'disabled="disabled"'; ?> /></p>
                                            <p class="center"><a href="<?php echo $sku_link; ?>" class="btn22_gray" target="_blank">етали</a></p>
                                            <?php
                                            if (!$instock)
                                                echo '<span class="outstock red">Нет в наличии</span>';
                                            ?>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                    </ul>
                                </div>
                                <div class="add-bag" style="margin-bottom:40px;">
                                    <input value="ДОБАВИТЬ В КОРЗИНУ" class="btn btn-primary btn-lg" type="submit"><a href="<?php echo LANGPATH; ?>/wishlist/add_more/<?php echo implode('-', $wishlist); ?>" class="a-underline add-wishlist">Избранное</a>
                                </div>
                                <span class="prevs0"></span>
                                <span class="nexts0"></span>
                            </form>
                            <script>
                                $("#form<?php echo $key; ?>").validate({
                                    rules: {
                                        size0: {
                                            required: true
                                        },
                                        size1: {
                                            required: true
                                        },
                                        size2: {
                                            required: true
                                        },
                                        size3: {
                                            required: true
                                        },
                                        size4: {
                                            required: true
                                        }
                                    }
                                })
                                $(function(){
                                    $(".form3 .checkbox").click(function(){
                                        var ck = $(this).attr('checked');
                                        if(ck == 'checked')
                                        {
                                            var title = $(this).attr('title');
                                            $(this).parent().find('.size_input').attr('name', title);
                                        }
                                        else
                                        {
                                            $(this).parent().find('.size_input').attr('name', '');
                                        }
                                    })
                                    
                                    $(".size_select").change(function(){
                                        var val = $(this).val();
                                        $(this).parent().find(".size_input").val(val);
                                    })
                                })
                            </script>
                            <?php
                        }
                    }
                    ?>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            <?php
            }
            ?>
            <div class="other-customers" id="alsoview" style="display:none;">
                <div class="w-tit">
                    <h2>Другие Клиенты Также Просматривали</h2>
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
                          <li data-scarabitem="{{= p.id }}" style="display: inline-block" class="rec-item" id="em{{= p.id }}">
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
                                        
                                        if(!data){
                                            
                                            $(".phone-fashion-top").hide();
                                        }
                                        for(var o in data){
                                            $("#em"+o+"link").attr("href",data[o]["link"]);
                                            $("#em"+o+"price").html(data[o]["price"]);
                                            if(data[o]["show"]==0 || typeof(data[o]["link"]) == "undefined"){
                                                $("#em"+o).css('display','none');
                                            }
                                            else
                                            {
                                                num ++;
                                                if(num <= 9)
                                                {
                                                    phone_scare = '\
                                                    <li class="col-xs-4">\
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
            <div class="four-lay">
                <div class="box-title">
                    <ul>
                        <li class="current ml10" style="margin-left:10%;">похожие стили</li>
                        <li class="">Новинки</li>
                        <li class="">Ходовые товары</li>
                        <li class="" id="recent_li">Последнее Посмотрение</li>
                        <p style="left:120px;">
                            <b></b>
                        </p>
                    </ul>                           
                </div>
                <div class="box-dibu1">
                    <div>
                        <div class="hide-box-0">
                            <ul>
                            <?php
                            $key = 0;
                            if(!empty($flash_sales))
                            {
                                foreach($flash_sales as $flash)
                                {
                                    $flash_name = Product::instance($flash['product_id'], LANGUAGE)->get('name');
                                    $flash_link = Product::instance($flash['product_id'])->get('link');
                                    ?>
                                    <li class="rec-item"> 
                                        <a href="<?php echo LANGPATH; ?>/product/<?php echo $flash_link . '_p' . $flash['product_id']; ?>"> 
                                            <img src="<?php echo Image::link(Product::instance($flash['product_id'])->cover_image(), 7); ?>" alt="<?php echo $flash_name; ?>">
                                        </a>
                                        <p class="price">
                                            <b><?php echo Site::instance()->price($flash['price'], 'code_view'); ?></b>    
                                            <?php
                                            if (Product::instance($flash['product_id'])->get('has_pick'))
                                                echo '<span class="icon_pick"></span>';
                                            ?>
                                        </p>
                                    </li>
                                    <?php
                                }
                            }
                            elseif(!empty($related_products))
                            {
                                foreach($related_products as $pid)
                                {
                                    if (!Product::instance($pid)->get('visibility') OR !Product::instance($pid)->get('status'))
                                        continue;
                                    else
                                        $key++;
                                    if ($key == 8)
                                        break;
                                    $relate_name = Product::instance($pid, LANGUAGE)->get('name');
                                    $relate_link = Product::instance($pid)->get('link');
                                    ?>
                                    <li class="rec-item"> 
                                        <a href="<?php echo LANGPATH; ?>/product/<?php echo $relate_link . '_p' . $pid; ?>"> 
                                            <img src="<?php echo Image::link(Product::instance($pid)->cover_image(), 7); ?>" alt="<?php echo $relate_name; ?>">
                                        </a>
                                        <p class="price">
                                            <b><?php echo Site::instance()->price(Product::instance($pid)->price(), 'code_view'); ?></b>    
                                            <?php
                                            if (Product::instance($pid)->get('has_pick'))
                                                echo '<span class="icon_pick"></span>';
                                            ?>
                                        </p>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                            </ul>
                        </div>
                        <div class="hide-box-1 hide">
                            <ul>
                            <?php
                            $news = array();
                            $from = time() - 14 * 86400;
                            $to = time();

                            $keynews  = 'site_news_choies/'.$product->get('set_id');
                            if (!($news = $cache->get($keynews)))
                            {
                                $news = DB::query(Database::SELECT, 'SELECT id, name, link, price, has_pick FROM products WHERE set_id = ' . $product->get('set_id') . ' AND visibility = 1 AND status=1 AND stock <> 0 ORDER BY display_date DESC LIMIT 0, 7')->execute()->as_array();  
                                $cache->set($keynews, $news, 7200);
                            }   

                            foreach($news as $pdetail)
                            {
                                ?>
                                <li class="rec-item"> 
                                    <a href="<?php echo LANGPATH; ?>/product/<?php echo $pdetail['link'] . '_p' . $pdetail['id']; ?>"> 
                                        <img src="<?php echo Image::link(Product::instance($pdetail['id'])->cover_image(), 7); ?>" alt="<?php echo $pdetail['name']; ?>">
                                    </a>
                                    <p class="price">
                                        <b><?php echo Site::instance()->price(Product::instance($pdetail['id'])->price(), 'code_view'); ?></b>    
                                        <?php
                                        if ($pdetail['has_pick'])
                                            echo '<span class="icon_pick"></span>';
                                        ?>
                                    </p>
                                </li>
                                <?php
                            }
                            ?>
                            </ul>
                        </div>
                        <div class="hide-box-2 hide">
                            <ul>
                            <?php
                            $hots = array();

                            $keyhots  = 'site_hots_choies/'.$product->get('set_id');
                            if (!($hots = $cache->get($keyhots)))
                            {
                            $hots = DB::query(Database::SELECT, 'SELECT product_id FROM catalog_products WHERE catalog_id = 32 ORDER BY position DESC LIMIT 0, 7')->execute()->as_array();
                                $cache->set($keyhots, $hots, 7200);
                            }   

                            foreach($hots as $h)
                            {
                                $hproduct = Product::instance($h['product_id'], LANGUAGE);
                                ?>
                                <li class="rec-item"> 
                                    <a href="<?php echo $hproduct->permalink(); ?>"> 
                                        <img src="<?php echo Image::link($hproduct->cover_image(), 7); ?>" alt="<?php echo $hproduct->get('name'); ?>">
                                    </a>
                                    <p class="price">
                                        <b><?php echo Site::instance()->price($hproduct->price(), 'code_view'); ?></b>    
                                        <?php
                                        if ($hproduct->get('has_pick'))
                                            echo '<span class="icon_pick"></span>';
                                        ?>
                                    </p>
                                </li>
                                <?php
                            }
                            ?>
                            </ul>
                        </div>
                        <div class="hide-box-3 hide">
                            <ul id="recent_view">
                            </ul>
                        </div>
                    </div>
                    <div id="review_list"></div>
                    <div id="JS-current" class="box-current">
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
                    <h2>ДРУГИЕ ТОЖЕ ИНТЕРЕСУЮТСЯ</h2>
                </div>
                <div class="flash-sale">
                    <ul class="row" id="phone_scare"></ul>
                </div>  
            </div>
            <div class="customer-reviews">
                <div class="w-tit">
                    <h2>Отзывы покупателей</h2>
                </div>
                <?php
                if(empty($reviews))
                {
                ?>
                    <div style="text-align:center; margin-bottom:-40px;">
                        <div class="reviews">
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <span style="font-weight:bold; margin-left:10px;font-size:16px;">0</span><span style=" margin-left:5px;font-size:16px;">отзывов</span>
                        </div>
                        <p style="margin-top:15px;font-size:14px;">БУДЬТЕ ПЕРВЫМ, ВЫСКАЖИТЕ СВОЕ МНЕНИЕ</p>
                        <?php
                        if(!$customer_id)
                        {
                        ?>
                            <a class="btn btn-primary btn-lg" id="write_review1" style="margin-top:18px;margin-bottom:100px; cursor:pointer;" data-reveal-id="myModal4">Написать отзыв</a>
                        <?php
                        }
                        else
                        {
                            ?>
                            <a target="_blank" class="btn btn-primary btn-lg" href="<?php echo LANGPATH; ?>/review/add/<?php echo $product_id; ?>" style="margin-top:18px;margin-bottom:100px; cursor:pointer;">Написать отзыв</a>
                            <?php
                        }
                        ?>
                    </div>
                <?php
                }
                else
                {
                    ?>
                    <div class="cus-rev-bg col-md-12">
                        <div class="rating" style="height:17px;">
                            <span class="s1 col-md-4">
                                <span class="reviews font14"><?php echo $review_stars; ?></span> Средний Общий Рейтинг
                            </span>
                            <span class="s1 col-md-3">Рейтинг Качества:<div class="outbt"><div style="width:<?php echo round($reviews_data['quality'] / 0.05, 2); ?>%;background:#e6cfcf;" class="inbt"></div></div></span>
                            <span class="s1 col-md-3">Рейтинг Цены:<div class="outbt"><div style="width:<?php echo round($reviews_data['price'] / 0.05, 2); ?>%;background:#e6cfcf;" class="inbt"></div></div></strong></span>
                            <span class="s1 col-md-2">Рейтинг Фитнеса:<span style="font-weight:normal;"> <?php echo $review_title['fitness'][ceil($reviews_data['fitness'])]; ?></span></span>
                        </div>
                        <div class="rating-note">
                            <span class="s2 col-md-4"><strong style="margin-left:20%;">Рейтинг: <?php echo $reviews_data['overall']; ?> / 5(<?php echo $count_reviews; ?>)</strong></span>
                            <span class="s2 col-md-3" style="margin-left:8%;">
                                <?php
                                $r_title = $review_title['quality'][ceil($reviews_data['quality'])];
                                $r_title = str_replace('I ', 'We ', $r_title);
                                echo $r_title;
                                ?>
                            </span>
                            <span class="s2 col-md-3">
                                <?php echo $review_title['price'][ceil($reviews_data['price'])]; ?>
                            </span>
                        </div>
                        <div class="view-num col-md-12">
                            <span class="s2"><?php echo $count_reviews; ?> REVIEW<?php if($count_reviews > 1) echo 'S'; ?>  &nbsp; | &nbsp;   
                            <?php
                            if(!$customer_id)
                            {
                                ?>
                                <a href="<?php echo LANGPATH; ?>/review/add/<?php echo $product_id; ?>" class="JS-popwinbtn12" id="write_review2" style="text-decoration:underline;">Написать отзыв</a>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a target="_blank" href="<?php echo LANGPATH; ?>/review/add/<?php echo $product_id; ?>" style="text-decoration:underline;">Hаписать отзыв</a>
                                <?php
                            }
                            ?>
                            </span>
                        </div>
                    </div>
                    <?php
                    $r_limit = 4;
                    $r_pages = ceil($count_reviews / $r_limit);
                    for($i = 1;$i <= $r_pages;$i ++)
                    {
                    ?>
                        <ul class="reviews-box <?php if($i > 1) echo 'hide'; ?>" id="page1_<?php echo $i; ?>">
                        <?php
                        for($j = ($i - 1) * $r_limit;$j < $i * $r_limit;$j ++)
                        {
                            if($j >= $count_reviews)
                                break;
                            $r = $reviews[$j];
                            if($r['user_id'] == 0)
                            {
                                $firstname = $r['firstname'];
                            }
                            else
                            {
                                $firstname = DB::select('shipping_firstname')->from('orders_order')->where('id', '=', $r['order_id'])->execute('slave')->get('shipping_firstname');
                            }
                            if(!$firstname)
                                $firstname = 'Choieser';
                            $attrs = explode(':', $r['attribute']);
                            if(strtolower($attrs[0]) == 'size')
                                $size = $attrs[1];
                            $size = str_replace(';', '', $size);
                        ?>
                            <li class="clearfix bgg">
                                <div class="left col-md-2">
                                    <dl>
                                        <dd><span>Имя:</span><span><?php echo $firstname; ?></span></dd>      
                                        <dd><span>Размер:</span><span><?php echo $size ? $size : $attributes['size'][0]; ?></span></dd> 
                                        <dd><span>по фигуре:</span><span><?php echo $review_title['fitness'][$r['fitness']]; ?></span></dd>     
                                        <dd><span>Высота:</span><span><?php echo $r['height']; ?> CM</span></dd> 
                                        <dd><span>вес:</span><span><?php echo $r['weight']; ?> KG</span></dd> 
                                    </dl>
                                </div>
                                <div class="right col-md-10">
                                    <div class="rating1">
                                        <span class="s1">
                                        Общий Рейтинг:<strong class="rating_show1 <?php echo 'star' . $r['overall']; ?>"></strong> (<?php echo $review_title['overall'][$r['overall']]; ?>)
                                        </span>
                                        <span class="s1">Рейтинг Качества:<div class="outbt" title="<?php echo $review_title['overall'][$r['quality']]; ?>"><div style="width:<?php echo round($r['quality'] / 0.05, 2); ?>%;background:#e6cfcf;" class="inbt"></div></div></span>
                                        <span class="s1">Рейтинг Цены:<div class="outbt" title="<?php echo $review_title['overall'][$r['price']]; ?>"><div style="width:<?php echo round($r['price'] / 0.05, 2); ?>%;background:#e6cfcf;" class="inbt"></div></div></span>
                                    </div>
                                    <div class="reviews-boxcon">
                                        <p id="sluo">
                                        <?php
                                        if(strlen($r['content']) > 400)
                                        {
                                            $front_400 = substr($r['content'], 0, 400);
                                            $remain = substr($r['content'], 400);
                                        ?>
                                            <div>
                                                <?php echo $front_400; ?>
                                                <span id="review_remain_<?php echo $r['id']; ?>" style="display:none;"><?php echo $remain; ?></span>
                                                <a onclick="$('#review_remain_<?php echo $r['id']; ?>').show();$(this).hide();" class="red">Далее</a>
                                            </div>
                                        <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <div><?php echo $r['content']; ?></div>
                                            <?php
                                        }
                                        ?>
                                        </p>
                                        <p class="clearfix">
                                        <?php
                                        if($r['reply'])
                                        {
                                        ?>
                                            <span style="font-weight:bold;width:20px;height:10px;"> Choies Ответы:</span>
                                            <span><?php echo $r['reply']; ?></span>
                                        <?php
                                        }
                                        ?>    
                                            <span class="date"><?php echo date('d M Y', $r['time']); ?></span>
                                        </p> 
                                    </div>
                                </div>
                            </li>
                        <?php
                        }
                        ?>
                        </ul>
                    <?php
                    }
                    ?>
                    <div class="bottom fix" id="review_pagination1">
                        <div class="flr">
                            <?php
                            $pagination = Pagination::factory(array(
                                'current_page' => array('source' => 'query_string', 'key' => 'page'),
                                'total_items' => $count_reviews,
                                'items_per_page' => $r_limit,
                                'view' => LANGPATH . '/pagination_2'));
                            echo $pagination->render();
                            ?>
                        </div>
                    </div>
                    <script>
                    $(function(){
                        $("#review_pagination1 .pagination a").live('click', function(){
                            var page = $(this).attr('title');
                            $(".customer-reviews .reviews-box").addClass('loadding');
                            $.ajax({
                                type: "POST",
                                url: "<?php echo LANGPATH; ?>/review/pagination?page=" + page,
                                dataType: "json",
                                data: "count=<?php echo $count_reviews; ?>&limit=<?php echo $r_limit; ?>",
                                success: function(msg){
                                    setTimeout(function(){ 
                                        $(".customer-reviews .reviews-box").removeClass('loadding');
                                        $("#review_pagination1 .flr").html(msg);
                                        $(".reviews-box").hide()
                                        $("#page1_" + page).show();
                                    }, 1000);
                                }
                            });
                            return false;
                        })
                    })
                    </script>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- JS-popwincon1 -->
<div id="myModal4" class="reveal-modal xlarge">
    <a class="close-reveal-modal close-btn3"></a>
    <?php
    $redirect = LANGPATH . '/product/' . $product->get('link') . '_p' . $product_id;
    echo View::factory(LANGPATH. '/customer/ajax_login')->set('redirect', $redirect);
    ?>
</div>
<!-- JS-popwincon1 -->

<!-- JS-popwincon2 -->
<div id="myModal3" class="reveal-modal xlarge">
        <a class="close-reveal-modal close-btn3"></a>
    <h2>Таблица размеров</h2>
    <!-- size guide2 -->
    <ul class="JS-tab-size size-tab two-bor">
        <?php if ($set_id != 2): ?>
            <li class="dt-s2 current">Одежда</li>
            <li class="dt-s2  pc-size" style="width:250px;">Преобразование графиков</li>
        <?php endif; ?>
        <?php if ($set_id == 2): ?>
            <li class="dt-s2 current">Обувь</li>
<!--         <?php //else: ?>
    <li class="dt-s2 two-bor">Обувь</li> -->
        <?php endif; ?>
      
        <?php if (Product::instance($product_id)->get('set_id') != 2 AND !empty($celebrity_lists)): ?>
            <li class="dt-s2  pc-size">Попробуйте на отчет</li>
        <?php endif; ?>
  <li class="dt-s2  pc-size">измерения</li>

        <p style="left: 0px; width: 150px;margin-top: -1px;" class="pc-size"><b></b></p>
    </ul>
    <div class="JS-tabcon-size size-tabcon size-table-box">
        <?php
        if ($set_id != 2)
        {
            ?>
            <div class="bd">
                <?php
                $brief = str_replace(array('<p>', '</p>'), '', $brief);
                $brief = str_replace(array('<br />', '<br/>'), '<br>', $brief);
                $brief = str_replace(':<br>', ':', $brief);
                $briefs = explode("<br>", trim($brief));
                $sizes = array();
                $details = array();
                foreach ($briefs as $key => $b)
                {
                    if (strlen($b) > 4)
                    {
                        $sizes[] = substr($b, 0, strpos($b, ':'));
                        $briefs[$key] = substr($b, strpos($b, ':') + 1, strlen($b));
                    }
                }
                foreach ($briefs as $key => $b)
                {
                    $detail = explode(',', trim($b));
                    foreach ($detail as $d)
                    {
                        $de = explode(':', trim($d));
                        $titlekey = strtolower($de[0]);
                        if ($titlekey == 'sleeve')
                            $titlekey = 'sleeve length';
                        elseif ($titlekey == 'hips')
                            $titlekey = 'hip';
                        if (!isset($details[$titlekey]))
                            $details[$titlekey] = array();
                        $details[$titlekey][$key] = isset($de[1]) ? $de[1] : '';
                    }
                }
                $size_titles = array(
                    'shoulder', 'bust', 'waist', 'hip', 'length', 'sleeve length'
                );
                $us_sizes = '';
                //Site::us_size($details, $set_id);
                ?>
                <table class="user-table">
                    <tr>
                        <th width="10%" rowspan="2">Размер</th>
                        <?php
                        if (!empty($us_sizes))
                        {
                            ?>
                           <th width="5%" rowspan="2">Размер США</th>
                            <th width="5%" rowspan="2">Размер UK</th>
                            <th width="5%" rowspan="2">Европейский размер</th>
                            <?php
                        }
                        ?>
                   <th width="15%" colspan="2">Длина плеча</th>
                        <th width="15%" colspan="2">Обхват груди</th>
                        <th width="15%" colspan="2">Обхват талии</th>
                        <th width="15%" colspan="2">Обхват бедер</th>
                        <th width="15%" colspan="2">Длина изделия</th>
                        <th width="15%" colspan="2">Длина рукава</th>
                    </tr>
                    <tr>
                       <th>inch</th>
                        <th>cm</th>
                        <th>inch</th>
                        <th>cm</th>
                        <th>inch</th>
                        <th>cm</th>
                        <th>inch</th>
                        <th>cm</th>
                        <th>inch</th>
                        <th>cm</th>
                        <th>inch</th>
                        <th>cm</th>
                    </tr>
                    <?php
                    foreach ($sizes as $key1 => $size)
                    {
                        if (!$size)
                            continue;
                        if($size == 'one size')
                          $size = 'только один размер';
                        ?>
                        <tr>
                            <td class="b"><?php echo $size; ?></td>
                            <?php
                            $us = isset($us_sizes[$key1]) ? $us_sizes[$key1] : 0;
                            $uk = $eu = 0;
                            if ($us)
                            {
                                if (strpos($us, '+') !== False)
                                {
                                    $uk = (int) $us + 4;
                                    $uk .= '+';
                                    $eu = (int) $us + 32;
                                    $eu .= '+';
                                }
                                else
                                {
                                    $uk = $us + 4;
                                    $eu = $us + 32;
                                }
                            }
                            if ($us)
                            {
                                echo '<td>' . $us . '</td><td>' . $uk . '</td><td>' . $eu . '</td>';
                            }
                            foreach ($size_titles as $key => $title)
                            {
                                if (isset($details[$title]) && isset($details[$title][$key1]))
                                {
                                    $cm = str_replace('cm', '', $details[$title][$key1]);
                                    $inchs = array();
                                    $cms = explode('-', $cm);
                                    foreach ($cms as $c)
                                    {
                                        $c = trim($c);
                                        $i = round($c * 0.39370078740157, 2);
                                        $inchs[] = $i;
                                    }
                                    $cm = implode(' - ', $cms);
                                    $inch = implode(' - ', $inchs);
                                    if ((int) $inch)
                                        echo '<td>' . $inch . '</td><td>' . $cm . '</td>';
                                    else
                                        echo '<td>/</td><td>/</td>';
                                }
                                else
                                {
                                    echo '<td>/</td><td>/</td>';
                                }
                            }
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
            <div class="bd hide">
                <?php
                $hides = array(
                    9 => array(),
                    14 => array(),
                    15 => array(),
                    474 => array('bust'),
                    12 => array('bust'),
                    10 => array('bust'),
                    13 => array('bust'),
                    20 => array('bust'),
                );
                if (array_key_exists($set_id, $hides))
                {
                    $hide = $hides[$set_id];
                    ?>
                  <h3> Одежда - Таблица международных размеров</h3>
                    <table width="100%" class="user-table">
                        <tr>
                       <th width="5%" rowspan="2">Размер США</th>
                            <th width="5%" rowspan="2">Размер UK</th>
                            <th width="5%" rowspan="2">Европейский размер</th>
                            <th width="15%" colspan="2" class="bust">Обхват груди</th>
                            <th width="15%" colspan="2" class="waist">Обхват талии</th>
                            <th width="15%" colspan="2" class="hip">Обхват бедер</th>
                        </tr>
                        <tr>
                           <th class="bust">inch</th>
                            <th class="bust">cm</th>
                            <th class="waist">inch</th>
                            <th class="waist">cm</th>
                            <th class="hip">inch</th>
                            <th class="hip">cm</th>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>6</td>
                            <td>34</td>
                            <td class="bust">31</td>
                            <td class="bust">78.5</td>
                            <td class="waist">23.75</td>
                            <td class="waist">60.5</td>
                            <td class="hip">33.75</td>
                            <td class="hip">86</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>8</td>
                            <td>36</td>
                            <td class="bust">32</td>
                            <td class="bust">81</td>
                            <td class="waist">24.75</td>
                            <td class="waist">63</td>
                            <td class="hip">34.75</td>
                            <td class="hip">88.5</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>10</td>
                            <td>38</td>
                            <td class="bust">34</td>
                            <td class="bust">86</td>
                            <td class="waist">26.75</td>
                            <td class="waist">68</td>
                            <td class="hip">36.75</td>
                            <td class="hip">93.5</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>12</td>
                            <td>40</td>
                            <td class="bust">36</td>
                            <td class="bust">91</td>
                            <td class="waist">28.75</td>
                            <td class="waist">73</td>
                            <td class="hip">38.75</td>
                            <td class="hip">98.5</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>14</td>
                            <td>42</td>
                            <td class="bust">38</td>
                            <td class="bust">96</td>
                            <td class="waist">30.75</td>
                            <td class="waist">78</td>
                            <td class="hip">40.75</td>
                            <td class="hip">103.5</td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>16</td>
                            <td>44</td>
                            <td class="bust">40</td>
                            <td class="bust">101</td>
                            <td class="waist">32.75</td>
                            <td class="waist">83</td>
                            <td class="hip">42.75</td>
                            <td class="hip">108.5</td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>18</td>
                            <td>46</td>
                            <td class="bust">43</td>
                            <td class="bust">108.5</td>
                            <td class="waist">35.75</td>
                            <td class="waist">90.5</td>
                            <td class="hip">45.75</td>
                            <td class="hip">116</td>
                        </tr>
                    </table>
                    <script>
                    <?php
                    foreach ($hide as $h)
                    {
                        ?>
                                $(".<?php echo $h; ?>").hide();
                        <?php
                    }
                    ?>
                    </script>
                        <?php
                    }
                    ?>
                <table width="100%" class="user-table">
                    <tr>
                        <td class="b" width="16%" bgcolor="f4f4f0">US</td>
                        <td width="6%">00</td>
                        <td width="6%">0</td>
                        <td width="6%">2</td>
                        <td width="6%">4</td>
                        <td width="6%">6</td>
                        <td width="6%">8</td>
                        <td width="6%">10</td>
                        <td width="6%">12</td>
                        <td width="6%">14</td>
                        <td width="6%">16</td>
                        <td width="6%">18</td>
                        <td width="6%">20</td>
                        <td width="6%">22</td>
                        <td width="6%">24</td>
                    </tr>
                    <tr>
                        <td class="b" bgcolor="f4f4f0">UK</td>
                        <td>2</td>
                        <td>4</td>
                        <td>6</td>
                        <td>8</td>
                        <td>10</td>
                        <td>12</td>
                        <td>14</td>
                        <td>16</td>
                        <td>18</td>
                        <td>20</td>
                        <td>22</td>
                        <td>24</td>
                        <td>26</td>
                        <td>28</td>
                    </tr>
                    <tr>
                        <td class="b" bgcolor="f4f4f0">EU</td>
                        <td>/</td>
                        <td>32</td>
                        <td>34</td>
                        <td>36</td>
                        <td>38</td>
                        <td>40</td>
                        <td>42</td>
                        <td>44</td>
                        <td>46</td>
                        <td>48</td>
                        <td>50</td>
                        <td>52</td>
                        <td>54</td>
                        <td>56</td>
                    </tr>
                    <tr>
                        <td class="b" bgcolor="f4f4f0">Франция/Испания</td>
                        <td>30</td>
                        <td>32</td>
                        <td>34</td>
                        <td>36</td>
                        <td>38</td>
                        <td>40</td>
                        <td>42</td>
                        <td>44</td>
                        <td>46</td>
                        <td>48</td>
                        <td>50</td>
                        <td>52</td>
                        <td>54</td>
                        <td>56</td>
                    </tr>
                    <tr>
                        <td class="b" bgcolor="f4f4f0">Германия</td>
                        <td>32</td>
                        <td>34</td>
                        <td>36</td>
                        <td>38</td>
                        <td>40</td>
                        <td>42</td>
                        <td>44</td>
                        <td>46</td>
                        <td>48</td>
                        <td>50</td>
                        <td>52</td>
                        <td>54</td>
                        <td>56</td>
                        <td>58</td>
                    </tr>
                    <tr>
                        <td class="b" bgcolor="f4f4f0">Италия</td>
                        <td>34</td>
                        <td>36</td>
                        <td>38</td>
                        <td>40</td>
                        <td>42</td>
                        <td>44</td>
                        <td>46</td>
                        <td>48</td>
                        <td>50</td>
                        <td>52</td>
                        <td>54</td>
                        <td>56</td>
                        <td>58</td>
                        <td>60</td>
                    </tr>
                    <tr>
                        <td class="b" bgcolor="f4f4f0">AU</td>
                        <td>2</td>
                        <td>4</td>
                        <td>6</td>
                        <td>8</td>
                        <td>10</td>
                        <td>12</td>
                        <td>14</td>
                        <td>16</td>
                        <td>18</td>
                        <td>20</td>
                        <td>22</td>
                        <td>24</td>
                        <td>26</td>
                        <td>28</td>
                    </tr>
                </table>
            </div>
            <?php
        }
        ?>

            <?php
        if ($set_id == 2)
        {
            ?> 
        <div class="bd <?php if ($set_id != 2) echo 'hide'; ?>">
            <table width="95%" class="size-table">
                <tr>
                    <th width="24%">US</th>
                    <th width="24%">UK</th>
                    <th width="28%">ЕС</th>
                    <th width="24%">CM</th>
                </tr>
                <tr style="background:#f6f6f7;">
                    <td>3</td>
                    <td>1.5-2</td>
                    <td>34</td>
                    <td>22</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>2-2.5</td>
                    <td>35</td>
                    <td>22.5</td>
                </tr>
                <tr style="background:#f6f6f7;">
                    <td>5</td>
                    <td>3-3.5</td>
                    <td>36</td>
                    <td>23</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>4-4.5</td>
                    <td>37</td>
                    <td>23.5</td>
                </tr>
                <tr style="background:#f6f6f7;">
                    <td>7</td>
                    <td>5-5.5</td>
                    <td>38</td>
                    <td>24</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>6-6.5</td>
                    <td>39</td>
                    <td>24.5</td>
                </tr>
                <tr style="background:#f6f6f7;">
                    <td>9</td>
                    <td>7-7.5</td>
                    <td>40</td>
                    <td>25</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>8-8.5</td>
                    <td>41</td>
                    <td>25.5</td>
                </tr>
                <tr style="background:#f6f6f7;">
                    <td>11</td>
                    <td>9-9.5</td>
                    <td>42</td>
                    <td>26</td>
                </tr>
                <tr>
                    <td>12</td>
                    <td>10-10.5</td>
                    <td>43</td>
                    <td>26.5</td>
                </tr>
                <tr style="background:#f6f6f7;">
                    <td>13</td>
                    <td>11-11.5</td>
                    <td>44</td>
                    <td>27</td>
                </tr>
                <tr>
                    <td>14</td>
                    <td>12-12.5</td>
                    <td>45</td>
                    <td>27.5</td>
                </tr>
            </table>
     <p>Используйте эти таблицы размеров, чтобы помочь определить ваш размер.Размер на наш сайт вручную измеряется, может быть, небольшое отклонение.Если у вас есть конкретный размеров требование или вы хотели бы знать больше информации, пожалуйста, свяжитесь с нами: <a href="mailto:service_ru@choies.com">service_ru@choies.com</a>. </p>
        </div>
            <?php
        }
        ?>

        <?php
        if (Product::instance($product_id)->get('set_id') != 2 AND !empty($celebrity_lists))
        {
            ?>
            <div class="bd hide">
                <h3 class="center">Попробуйте на отчет</h3>
                <table width="100%" class="user-table">
                    <tr>
                        <th width="5%" rowspan="2">Название</th>
                        <th width="5%" rowspan="2">Размеры zu passen</th>
                        <th width="15%" colspan="2">Высота</th>
                        <th width="15%" colspan="2">вес</th>
                        <th width="15%" colspan="2">Обхват груди</th>
                        <th width="15%" colspan="2">Обхват талии</th>
                        <th width="15%" colspan="2">Обхват бедер</th>
                    </tr>
                    <tr>
                        <th>фут</th>
                        <th>cm</th>
                        <th>lbs</th>
                        <th>kg</th>
                        <th>inch</th>
                        <th>cm</th>
                        <th>inch</th>
                        <th>cm</th>
                        <th>inch</th>
                        <th>cm</th>
                    </tr>
                    <?php
                    foreach ($celebrity_lists as $cid)
                    {
                        $cid = (int) $cid;
                        $cel_customer = DB::select('customer_id')->from('celebrities_celebrits')->where('id', '=', $cid)->execute()->get('customer_id');
                        $cel_customer = (int) $cel_customer;
                        if ($cel_customer)
                        {
                            $cel_attrs = DB::query(Database::SELECT, 'SELECT i.attributes FROM order_items i 
                        LEFT JOIN orders o ON i.site_id = o.site_id AND i.order_id = o.id
                        WHERE i.product_id = ' . $product_id . ' AND o.customer_id = ' . $cel_customer)
                                            ->execute()->get('attributes');
                            $eur = strpos($cel_attrs, 'EUR');
                            $size = '';
                            if ($eur !== FALSE)
                            {
                                $size = substr($cel_attrs, $eur + 3, 2);
                            }
                            else
                            {
                                $size = substr($cel_attrs, 5, -1);
                            }
                            $celebrity = DB::query(Database::SELECT, 'SELECT show_name,height,weight,bust,waist,hips FROM celebrits WHERE id = ' . $cid)->execute()->current();
                            $height = (float) $celebrity['height'];
                            $weight = (float) $celebrity['weight'];
                            $bust = (float) $celebrity['bust'];
                            $waist = (float) $celebrity['waist'];
                            $hips = (float) $celebrity['hips'];
                            $in = 0.3937008;
                            $ft = 0.0328084;
                            $lb = 2.2046226;
                            ?>
                            <tr>
                                <td><?php echo $celebrity['show_name']; ?></td>
                                <td><?php echo $size; ?></td>
                                <td>
                                    <?php
                                    $height_ft = round($height * $ft, 1);
                                    $height_ft = str_replace(".", "'", $height_ft);
                                    $height_ft .= '"';
                                    echo $height_ft;
                                    ?>
                                </td>
                                <td><?php echo $height; ?></td>
                                <td><?php echo round($weight * $lb, 1); ?></td>
                                <td><?php echo $weight; ?></td>
                                <td><?php echo round($bust * $in, 1); ?></td>
                                <td><?php echo $bust; ?></td>
                                <td><?php echo round($waist * $in, 1); ?></td>
                                <td><?php echo $waist; ?></td>
                                <td><?php echo round($hips * $in, 1); ?></td>
                                <td><?php echo $hips; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>
            </div>
            <?php
        }
        ?>

        <div class="bd size-mesurements hide">
            <h3>Одежда</h3>
            <div class="clearfix">
                <div class="fll"><img src="<?php echo STATICURL; ?>/assets/images/<?php echo LANGPATH; ?>/docs/size-guide1.jpg" /></div>
                <div class="right flr" style="padding-left:20px;">
				<p>
					<strong>a) Обхват груди</strong>
					<br> *Это не ваш размер бюстгальтера!
					<br> *Носите бюстгальтер без ведущего (ваше платье будет иметь встроенный в бюстгальтер)
					<br> *Опустите расслабленные руки вдоль туловища
					<br> *Потяните ленту по полной части бюста
				</p>
				<p>
					<strong>b) Обхват талии</strong>
					<br> *Найти естественную талию
					<br> *Это самая маленькая часть талии
					<br> *Обычно около 1 дюйм выше пупка
					<br> *Держать ленту слегка свободно, чтобы обеспечить передышку
				</p>
				<p>
					<strong>c) Обхват бедер</strong>
					<br> *Найдите самую широкую часть бедер
					<br> *Обычно около 8 дюймов. ниже талии
					<br> *Лента должна охватывать обе тазовые кости
				</p>
                    </div>
            </div>
            <h3>Обувь</h3>
            <div class="clearfix">
                <div class="fll"><img width="320" src="<?php echo STATICURL; ?>/assets/images/<?php echo LANGPATH; ?>/docs/size-guide6.jpg" /></div>
                <div class="right flr" style="padding-left:25px;">
                    <h4>ОБУВЬ ДЛИНА</h4>
                    <p>Измерьте обувь от передней носочной части к задней части пятки.</p>
                    <h4>ТУФЛИ ВЫСОТА</h4>
                    <p>Измерить заднюю часть обуви от верха обуви ранта в нижней части пятки, покоящегося на плоской поверхности.</p>
                    <h4>ВЫСОТА КАБЛУКА</h4>
                    <p>Измерить заднюю часть пятки от точки, где он подключается к обуви, называется шов, к низу каблуки, покоящегося на плоской поверхности.</p>
                    <h4>ВЫСОТА ТРУБА</h4>
                    <p>= ВЫСОТА ОБУВЬ - ВЫСОТА КАБЛУКА</p>
                </div>
            </div>
        </div>



    </div>
</div>
<!-- JS-popwincon2 -->

<script type="text/javascript">
    $(function(){
        $.ajax({
            type: "POST",
            url: "/site/ajax_product1",
            dataType: "json",
            data: "id=<?php echo $product_id; ?>",
            success: function(product){
                if(product['status'] == 0)
                {
                    $("#product_status").html('<strong class="red">Нет в наличии</strong>');
                    $("#addCart").hide();
                }
                else
                {
                    $("#product_status").html('Disponible');
                    $("#addCart").show();
                }
                $(".orig_price").html(product['s_price']);
                $(".product_price").html(product['price']);
                 var attributes = product['attributeSize'].replace('<span>one size</span>', '<span>только один размер</span>');
                <?php
                if($crumbs[0]['id'] == 53)
                {
                    ?>
                    $("#pc_size").html(product['attributeSize']);
                    $("#phone_size").html(product['attributePhone']);
                    <?php
                }
                ?>
                $("#total_price").text(product['total_price']);
                $("#get_points").text(parseInt(product['points']));
                <?php 
                //判断是否onesize,为onesize默认选中
                if($onesize==1){ ?>
                var value = $(".size-list li").attr('id');
                var qty = $(".size-list li").attr('title');
                $(".s-size").val(value);
                $(".size-list li").addClass('on');
                $("#size_show").html($(".size-list li span").eq(0).text());
                $("#size_span").show();
                $("#select_size").hide();
                <?php } ?>
            }
        });
    })

    $(function(){
        $("#sign_in").click(function(){
            $("#sign_in_up form").attr('action', '<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/product/<?php echo $product->get('link'); ?>_p<?php echo $product_id; ?>');
        })
        $("#write_review, #write_review1, #write_review2").click(function(){
            $("#sign_in_up form").attr('action', '<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/review/add/<?php echo $product_id; ?>');
            $("#email2").val('');
            $("#password2").val('');
        })
    })
</script>

<!--<div class="JS_filter opacity hide"></div>-->
<script type="text/javascript">
    function tofloat(f,dec)       
    {          
        if(dec <0) return "Error:dec <0! ";          
        result=parseInt(f)+(dec==0? " ": ".");          
        f-=parseInt(f);          
        if(f==0)
        {
            for(i=0;i <dec;i++) result+= '0';          
        }
        else       
        {          
            for(i=0;i <dec;i++)
            {
                f*=10;
                if(parseInt(f) == 0)
                {
                    result+= '0';
                }
            }          
            result+=parseInt(Math.round(f));
        } 
        return result;          
    }
</script>

<script type="text/javascript">
    var quantity = 1;
    $(function(){
        $("#formAdd").submit(function(){
            if(winWidth <= 768)
            {
                return true;
            }
            var obj = document.getElementById('cart_quantity');
            var index = obj.selectedIndex;
            quantity = obj.options[index].value;
            $.ajax({
                url:'/cart/ajax_add',
                type:'POST',
                dataType: "json",
                data:{
                    id: $("#product_id").val(),
                    type: $("#product_type").val(),
                    size: $('.s-size').val(),
                    quantity: quantity,
                    language: '<?php echo LANGUAGE; ?>',
                },
                success:function(product){
                    ajax_cart();
                    if($(document).scrollTop() > 120)
                    {
                        $('#mybagli2 .mybag-box').fadeIn(10).delay(3000).fadeOut(10);
                    }
                    else
                    {
                        $('#mybagli1 .mybag-box').fadeIn(10).delay(3000).fadeOut(10);
                    }
                    var sku=$('#product_psku').val();
                    var price=$('#product_price').val();
                    tprice=price*quantity;
                        if($(window).width() < 768)
                        {
                            window.location.href="<?php echo LANGPATH;?>/cart/view";
                        }
                }
            });
            return false;
        })
    })
                                        
function getScrollTop() {
    var scrollPos; if (window.pageYOffset) {
        scrollPos = window.pageYOffset; } else if (document.compatMode && document.compatMode != 'BackCompat') { scrollPos = document.documentElement.scrollTop; } else if (document.body) { scrollPos = document.body.scrollTop; } return scrollPos; 
}
function plus(){
    $init = document.getElementById("count_1").value;
    $init++;
    document.getElementById("count_1").value = $init;
    if(document.getElementById("count_1").value!=="1"){
        $(".btn_qty1").css("background","#666");
    }
}

function minus(){
    if($init>1){
        $init = document.getElementById("count_1").value;
        $init--;
        document.getElementById("count_1").value = $init;
        if(document.getElementById("count_1").value =="1"){
            $(".btn_qty1").css("background","#CED0D4");
        }
    }
}

<?php
if (!empty($flash_sale))
{
    $end_day = strtotime(date('Y-m-d', $flash_sale) . ' - 1 month');
    ?>
        /* time left */
        var startTime = new Date();
        startTime.setFullYear(<?php echo date('Y, m, d', $end_day); ?>);
        startTime.setHours(9);
        startTime.setMinutes(59);
        startTime.setSeconds(59);
        startTime.setMilliseconds(999);
        var EndTime=startTime.getTime();
        function GetRTime(){
            var NowTime = new Date();
            var nMS = EndTime - NowTime.getTime();
            var nD = Math.floor(nMS/(1000 * 60 * 60 * 24));
            var nH = Math.floor(nMS/(1000*60*60)) % 24;
            var nM = Math.floor(nMS/(1000*60)) % 60;
            var nS = Math.floor(nMS/1000) % 60;
            if(nD<=9) nD = "0"+nD;
            if(nH<=9) nH = "0"+nH;
            if(nM<=9) nM = "0"+nM;
            if(nS<=9) nS = "0"+nS;
            if (nMS < 0){
                $(".JS_dao").hide();
                $(".JS_daoend").show();
            }else{
                $(".JS_dao").show();
                $(".JS_daoend").hide();
                $(".JS_RemainD").text(nD);
                $(".JS_RemainH").text(nH);
                $(".JS_RemainM").text(nM);
                $(".JS_RemainS").text(nS); 
            }
        }
        
        $(document).ready(function () {
            var timer_rt = window.setInterval("GetRTime()", 1000);
        });
    <?php
}
?>

</script>

<script type="text/javascript">
$(function(){
    //recent view
    $.ajax({
        type: "POST",
        url: "/site/ajax_recent_view?lang=<?php echo LANGUAGE; ?>",
        dataType: "json",
        data: "",
        success: function(msg){
            if(msg.length == 0)
            {
                $("#recent_li,#recent_view").remove();
            }
            else
            {
                $("#recent_view").html(msg);
            }
        }
    });

    $.ajax({
        type: "POST",
        url: "/site/ajax_product_same?lang=<?php echo LANGUAGE; ?>",
        dataType: "json",
        data: "product_id=<?php echo $product_id; ?>",
        success: function(msg){
            if(msg.length == 0)
            {
                //$("#same_paragraph").hide();
                $(".same-paragraph1").hide();
            }
            else
            {
                $("#same_paragraph").append(msg);
            }
        }
    });
});

</script>


<!-- New Remarket Code -->
<script type="text/javascript">
    var google_tag_params = {
        ecomm_prodid: '<?php echo $product->get('sku'); ?>',
        ecomm_pagetype: 'product',
        ecomm_totalvalue: '<?php echo $price; ?>'
    };
</script>
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 983779940;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
    <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/983779940/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<script type="text/javascript">
window._fbq.push(["track", "ViewContent", { content_type: 'product', content_ids: ['<?php echo $product_id; ?>'], product_catalog_id: '1575263496062031' }]);
ScarabQueue.push(['view', '<?php echo $product->get('sku'); ?>']);
</script>


    <?php
        $user_id = Customer::logged_in();
        $user_session = Session::instance()->get('user');
    ?>
<!-- Criteo Code For Product Page -->
    <script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
    <script type="text/javascript">
        if (window.innerWidth)
            winWidth = window.innerWidth;
        else if ((document.body) && (document.body.clientWidth))
            winWidth = document.body.clientWidth;
        if(winWidth<768)
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
            { event: "viewItem", item: "<?php echo $product_id; ?>" },

            { event: "flushEvents"},

            { event: "setAccount", account: 23688 },          
            { event: "setHashedEmail", email: "<?php echo !empty($user_session['email'])? md5($user_session['email']):' '; ?>" },
            { event: "setSiteType", type: m },
            { event: "viewItem", item: "<?php echo $product_id; ?>" },
            
            { event: "flushEvents"}
        );
    </script>
<!-- end Criteo Code For Product Page -->