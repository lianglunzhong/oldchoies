<?php
if (strripos(Request::$user_agent, 'ipad'))
{
    ?>
    <style>
        .pro_lookwith .right{ width:450px;}
    </style>
    <?php
}
$plink = $product->permalink();
$transname = Product::instance($product->get('id'), LANGUAGE)->transname();
$product_name = $transname ? $transname : $product->get('name');
$pprice = $product->price();
?>
<link rel="canonical" href="<?php echo $plink; ?>" />
<!-- <link type="text/css" rel="stylesheet" href="<?php echo LANGPATH; ?>/css/product.css" media="all" id="mystyle" /> -->
<meta property="og:title" content="<?php echo $product_name; ?> - Choies.com" />
<meta property="og:description" content="Shop <?php echo $product_name; ?> from choies.com .Free shipping Worldwide.<?php echo '$'.$pprice; ?>" />
<meta property="og:type" content="product" />
<meta property="og:url" content="<?php echo $plink; ?>" />
<meta property="og:site_name" content="Choies" />
<meta property="og:price:amount" content="<?php echo $pprice; ?>" />
<meta property="og:price:currency" content="USD" />
<meta property="og:availability" content="in stock" />
<?php
    $price = $product->price();
   $currencyeur = Site::instance()->currencies("EUR");
   $eurprice = $price * $currencyeur['rate'];
   $eurprice = number_format($eurprice,2);
    ?>
<div itemtype="http://schema.org/Product" itemscope>
  <meta itemprop="name" content="<?php echo $product_name; ?>">
  <meta itemprop="sku" content="<?php echo $product->get('sku'); ?>">
  <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
    <meta itemprop="price" content="<?php echo $eurprice; ?>" />
    <meta itemprop="priceCurrency" content="EUR" />
  </div>
</div>
<script>
    var winWidth = window.innerWidth;
</script>
<div class="site-content">
    <div class="main-container clearfix">
        <div class="container">
            <div class="crumbs">
                <div class="fll">
                    <a href="<?php echo LANGPATH; ?>/" class="home"><?php echo isset($repla['crumbs_first']) ? $repla['crumbs_first'] : 'home' ?></a>
                    <?php
                    $product_id = $product->get('id');
                    if (!$current_catalog)
                        $current_catalog = $product->default_catalog();
                    $cataname = Catalog::instance($current_catalog)->get("name");
                    $crumbs = Catalog::instance($current_catalog, LANGUAGE)->crumbs();
                    if(!empty($crumbs))
                    {
                        foreach ($crumbs as $crumb):
                            if ($crumb['id']):
                                if(isset($repla[$crumb['name']]))
                                {
                                    $crumb['name'] = $repla[$crumb['name']];
                                }
                                ?>
                                &gt;  <a href="<?php echo $crumb['link']; ?>" ><?php echo $crumb['name']; ?></a>
                                <?php
                            endif;
                        endforeach;                        
                    }
                    ?>
                    <span class="hidden-xs">&gt;<?php echo isset($repla['crumbs_fourth']) ? $repla['crumbs_fourth'] : $product_name; ?></span>
                </div>
                
            </div>
            <div class="product-view">
                <?php
                $message = Message::get();
                echo $message;
                // mobile diff width pc --- sjm 2016-01-14
                $cover = $product->cover_image();
                if(!$is_mobile)
                {
                ?>
            <div class="product-view">
                <!-- pro-left -->
                <div class="pro-left phone-product-pic" style=" width:40%">
                    <div id="gallery">
                        <div id="JS_productPic" class="productpic loadding">
                            <?php
                           if($show_ship_tip){

                            $key = Site::instance()->get('id') . '/category_id395';
                            $cache = Cache::instance('memcache');
                            if (!($data = $cache->get($key))){

                                $ready_shippeds = DB::select('product_id')->from('products_categoryproduct')->where('category_id', '=', 395)->execute()->as_array();
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

                            <a href="<?php echo Image::link($cover, 9); ?>" class="picbox img480">
                                <img src="<?php echo Image::link($cover, 2); ?>" id="picture" alt="<?php echo isset($repla['crumbs_fourth']) ? $repla['crumbs_fourth'] : $product_name; ?>" title="<?php echo isset($repla['crumbs_fourth']) ? $repla['crumbs_fourth'] : $product_name; ?>">
                            </a>
                        </div>
                        <div class="firstthumbnail">
                            <span id="bigPrev" class="product-big-pic-left">
                            </span>
                            <span id="bigNext" class="product-big-pic-right">
                            </span>
                        </div>
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
                        <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
                        <script type="text/javascript">stLight.options({publisher: "76c0dd88-6e79-4e80-875e-7bc8934145b8", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
                        <span class='st_fblike_hcount' displayText='Facebook Like'></span>
                        <span class='st_facebook_hcount' displayText='Facebook'></span>
                        <!--<span class='st_twitter_hcount' displayText='Tweet'></span>-->
                        <span class='st_tumblr_hcount' displayText='Tumblr'></span>
                        <!--<script type="text/javascript" src="http://akwww.polyvorecdn.com/rsrc/add_to_polyvore.js"></script>
                        <a target="_blank" href="http://www.polyvore.com" name="addToPolyvore" id="addToPolyvore" data-product-url="<?php echo $plink; ?>" data-image-url="<?php echo Image::link($cover, 2); ?>" data-name="<?php $pname ?>" data-price="$|<?php echo $pprice; ?>"><img src="http://www.polyvore.com/rsrc/icons/embed/AddToPolyvore_61x20.png"/></a>--> 
                    </div>
                    <?php 
                    if($tags)
                    {
                        ?>
                        <div class="tags hidden-xs">
                            <p class="fll img-tag"><img src="<?php echo STATICURL;?>/assets/images/tag.png"></p>
                            <div class="fll tags-detail">
                                <h4 class="mb10">Stichworte</h4>
                                <?php
                                $tagtotal = Site::instance()->getalltag(LANGUAGE);

                                 foreach($tagtotal as $tag)
                                 {
                                    if(in_array($tag['id'],$tags))
                                    {
                                    ?>
                                    <a href="<?php echo LANGPATH.$tag['link'];?>"><?php echo $tag['name'];?></a> |
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
                else
                {
                ?>
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
                    <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
                    <script type="text/javascript">stLight.options({publisher: "76c0dd88-6e79-4e80-875e-7bc8934145b8", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
                    <span class='st_fblike_hcount' displayText='Facebook Like'></span>
                    <span class='st_facebook_hcount' displayText='Facebook'></span>
                    <!--<span class='st_twitter_hcount' displayText='Tweet'></span>-->
                    <span class='st_tumblr_hcount' displayText='Tumblr'></span>
                    <!--<script type="text/javascript" src="http://akwww.polyvorecdn.com/rsrc/add_to_polyvore.js"></script>
                    <a target="_blank" href="http://www.polyvore.com" name="addToPolyvore" id="addToPolyvore" data-product-url="<?php echo $plink; ?>" data-image-url="<?php echo Image::link($cover, 2); ?>" data-name="<?php $pname ?>" data-price="$|<?php echo $pprice; ?>"><img src="http://www.polyvore.com/rsrc/icons/embed/AddToPolyvore_61x20.png"/></a>--> 
                </div>
                <?php
                }
                ?>
                <!-- pro-right -->
                <div class="pro-right" style="margin-left:0px;">
                            <h3><?php echo $product_name; ?></h3>
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
                                <div class="row">
                                <dl class="col-xs-12 col-md-9">
                                    <div class="pro-stock">
                                        Artikel# : <span id="product_sku"><?php echo $product->get('sku'); ?></span>
                                        <?php
                                        if(!empty($brands))
                                        {
                                            ?>
                                            <a target="_blank" href="/brand/list/<?php echo $brands['id']; ?>">von <?php echo $brands['name']; ?></a>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <a target="_blank" href="/brand/list/220">von Zonewetwo</a>
                                        <?php
                                        }
                                         if ($product->get('presell') > time()): ?>
                                        <p>Vorverkauf: <b class="red"><?php echo $product->get('presell_message'); ?></b></p>
                                        <?php endif; ?>
                                    </div>
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
									$is_vip = $customer->get('is_vip');
                                    $vip_level = $customer->get('vip_level');
                                    if ($is_vip)
                                    {
                                        if($vip_promotion_price AND $is_vip >= 1)
                                        {
                                            if ($p_price > $price)
                                            {
                                                $rate =  round((($p_price - $price) / $p_price) * 100);
                                                ?>
                                                    <del><?php echo $currency_change; ?><?php echo Site::instance()->price($p_price, 'code_view'); ?></del>   
                                                    <span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span>
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
                                                        <del><?php echo $currency_change; ?> <?php echo Site::instance()->price($p_price, 'code_view'); ?> </del>   
                                                        <span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span>
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
                                                if(!$is_vip){
                                                   $vip = $vipconfig[0]; 
                                                }else{
                                                    $vip = $vipconfig[4]; 
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
                                                    <del><?php echo $currency_change; ?><?php echo Site::instance()->price($p_price, 'code_view'); ?></del>   
                                                    <span class="product_price"><?php echo Site::instance()->price($vip_price, 'code_view'); ?></span>
                                                    
                                                <?php
                                                }
                                                else
                                                {
                                                ?>
                                                    <span style="font-size:24px;"><?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($vip_price, 'code_view'); ?></span></span>
                                                <?php
                                                }
                                                ?>
                                                <?php if($is_vip >= 1){ ?>
                                                    vip
                                                <?php
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        if ($p_price > $price)
                                        {
                                            $rate =round((($p_price - $price) / $p_price) * 100);
                                            ?>
                                                <del><?php echo $currency_change; ?><?php echo Site::instance()->price($p_price, 'code_view'); ?></del>   
                                                <span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></i>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                                PREIS: <span style="font-size:24px;"><?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
                                            <?php
                                        }
                                    }
                                    ?>                                    
                                <?php
                                    //vip spromotions price
                                    if($vip_promotion_price)
                                    {
                                        if($customer_id)
                                        {
                                            if($is_vip >= 1)
                                            {
                                                ?>
                                                vip
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </p>

                            </div>
                        </dd>
                        <dd>
                            <div id="action_form" class="JS-popwincon">
                                <p class="product-note-title" style="display:none;">Bitte Größe Wählen
                                !<b class="JS-close">&times; </b></p>
                                <form action="<?php echo LANGPATH; ?>/cart/add" method="post" id="formAdd" class="product-pl">
                                    <input type="hidden" name="id" id="product_id" value="<?php echo $product_id; ?>"/>
                                    <input type="hidden" name="items[]" value="<?php echo $product_id; ?>"/>
                                    <input type="hidden" name="type" id="product_type" value="<?php echo $product->get('type'); ?>"/>
                                    <input type="hidden" name="psku" id="product_psku" value="<?php echo $product->get('sku'); ?>"/>
                                    <input type="hidden" name="price" id="product_price" value="<?php echo $product->get('price'); ?>"/>
                                    <input name="attributes[Size]" value="" class="s-size" type="hidden">
                                    <?php
                                    $set_id = $product->get('set_id');
                                    if (!empty($attributes['size']))
                                    {
                                        ?>
                                            <div class="btn-size" style=" margin-top:20px;">
                                                    <div class="selected-box">
                                                        <p class="fll">
                                                            <span class="mt10">Größe Wählen:</span>
                                                        </p>
                                                            <div class="drop-down select-down" id="select_size">
                                                                <div class="drop-down-hd JS-show1">
                                                                    <span id="size-val">Größe</span>
                                                                    <i class="fa fa-caret-down flr"></i>    
                                                                </div>
                                                    <ul class="drop-down-list size-list JS-showcon1" style="display:none;">
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
                                                    $js_show = 'cs-show';
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
                                                            $attribute_name = 'eine Größe111';
                                                        $_phone = array();
                                                        $_phone['attribute'] = $attribute;
                                                        $_phone['stock'] = -1;
                                                        if(array_key_exists($attribute, $stocks))
                                                        {
                                                            $_phone['stock'] = $stocks[$attribute];
                                                            if($stocks[$attribute] == 0)
                                                            {
                                                                ?>
                                                                <li id="<?php echo $attribute; ?>" class="drop-down-option hide" data-attr="<?php echo $attribute; ?>" disabled="disabled">
                                                                <a href="javascript:void(0);"><?php echo $attribute_name; ?></a></li>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <li title="<?php echo $stocks[$attribute]; ?>" id="<?php echo $attribute; ?>" class="drop-down-option <?php echo $js_show; ?>" data-attr="<?php echo $attribute; ?>"><a href="javascript:void(0);"><?php echo $attribute_name; ?></a></li>
                                                                <?php
                                                            }
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <li title="0" id="<?php echo $attribute; ?>"  class="drop-down-option hide <?php echo $js_show; ?>" data-attr="<?php echo $attribute; ?>"><a href="javascript:void(0);"><?php echo $attribute_name; ?></a>
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
                                                            $attribute_name = 'eine Größe';
                                                        $_phone = array();
                                                        $_phone['attribute'] = $attribute;
                                                        $_phone['stock'] = -1;
                                                    ?>
                                                    <li id="<?php echo $attribute; ?>" class="drop-down-option <?php echo $js_show; ?>" data-attr="<?php echo $attribute; ?>">
                                                            <a href="javascript:void(0);"><?php echo $attribute_name; ?></a>
                                                    </li>
                                                    <?php
                                                    $key ++;
                                                    $phone_attrs[] = $_phone;
                                                    }
                                                }
                                                ?>
                                            </ul>

                                            </div>
                                            <?php
                                                $clothes = array(
                                                    3,4,5,6,17,18,19,21,22,23,25,31,269,270,298,481,535,565,566,689,703,705
                                                );
                                                if(!in_array($set_id, $clothes))
                                                {
                                                ?>
                                                <span class="size-charts JS-popwinbtn2 ml10 hidden-xs"><a data-reveal-id="myModal3">Größentabelle</a></span>
                                                <?php
                                                }
                                                ?>
                                                         </div>
                                                    <div class="qty-box">
                                                        <span class="mt10" style="font-weight:bold;">Qty:</span>
                                                        <input type="number" required="required" value="1" min="1" name="quantity" id="qty" class="text-long text ml10">
                                                        <span id="only_left" class="red hide" style="display:none;"><span id="size_show">M</span> Only <span id="only_num">1</span> left!</span>
                                                    </div>
                                                    <p class="mt10"><span class="size-charts JS-popwinbtn2 hidden-sm hidden-md hidden-lg"><a data-reveal-id="myModal3">Size Guide</a></span></p>
                                                </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="total" style=" margin-top:15px;">
                                        <div class="same-paragraph">
                                            <ul class="color-choies" id="same_paragraph" style="display:none;">
                                                <li class="current-color"><a><img width="50" src="<?php echo Image::link($product->cover_image(), 3) ?>"></a><b class="on"></b></li>
                                            </ul>
                                        </div>
                                        <div class="btn-buy">
                                        <?php
                                        if($instock)
                                        {
                                            $giftarr = Site::giftsku();
                                            if(!in_array($product_id,$giftarr))
                                            {
                                        ?>
                                            <input class="btn btn-primary btn-lg" id="addCart" value="IN DEN WARENKORB" type="submit" style="text-transform: none;">
                                        <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <button class="btn btn-primary btn-lg" disabled="disabled">Ausverkauft</button>
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
                                            
                                            </span>
                                            <span class="fa fa-heart" style="display:none;"></span>WUNSCHLISTE
                                            <?php
                                            if($wishlists)
                                            {
                                            ?>
                                                <span id="wishlists">
                                                    <?php 
                                                     echo $wishlists ? '(' . $wishlists . ')' : '';
                                                    ?>
                                                </span>
                                            <?php
                                            }
                                            ?>
                                            </a>
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
                                            <label>MÁS COLORES:</label>
                                            <div id="same_paragraph11111"></div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </dd>
                                </dl>
                            <!--  <div class="col-md-3 hidden-xs">
                                <a href=""><img src="/assets/images/en/1603/pro-banner.jpg"></a>
                            </div> -->
                            </div>
                        <div>
                            <ul class="JS-tab detail-tab two-bor" style="margin-top:30px;">
                                <li class="dt-s1 current">Details</li>
                                <li class="dt-s1">Lieferung</li>
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
                                            echo '<tr><td width="25%" style="font-weight:bold;"><p>' . ucfirst($small_name) . ':</p></td><td width="75%"><p>' . ucfirst($small_filter[strtolower($sort)]) . '</p></td></tr>';
                                        }
                                        echo '</table>';
                                        echo '<br>';
                                    }
                                    $description = $product->get('description');
                                    $description = str_replace(';', '<br>', $description);
                                    if($description)
                                        echo $description . '<br><br>';
                                    $brief = $product->get('brief');
                                    $brief = str_replace(';', '<br>', $brief);
                                    $brief = str_replace(array('One size', 'one size', 'One Size'), array('Eine Größe'), $brief);
                                    echo $brief;
                                    ?>
                                   <?php
                                $clothes = array(
                                    3,4,5,6,17,18,19,21,22,23,25,31,269,270,298,481,535,565,566
                                );
                                if(!in_array($set_id, $clothes))
                                {
                                ?> 
                                    <a class="fix" style="cursor:pointer;margin-top:3px;text-decoration: underline;font-weight: bold;" data-reveal-id="myModal3">Größentabelle</a>
                                <?php
                                }
                                ?>
                                </div>
                                <div class="bd hide">
                                    <p style="color:#F00;">Empfangszeit = Bearbeitungszeit(3-5 Arbeitstage) + Versandzeit</p>
                                    <h4>Versand:</h4>
                                    <p>(1)  Kostenloser weltweiter Versand (10-15 Arbeitstage)</p>
                                    <p style="color:#F00; padding-left:18px;">Keine Mindestbestellung erforderlich.</p>
                                    <p>(2)  <?php echo Site::instance()->price(15, 'code_view'); ?> Express Versand (4-7 Arbeitstage)</p>
                                    <p style="padding-left:18px;">Prüfen Sie Details hier <a class="a_red" href="<?php echo LANGPATH; ?>/shipping-delivery" title="Versand &amp; Lieferung">Versand &amp; Lieferung</a>.</p>
                                    <h4>Rückgabe Politik:</h4>
                                    <p>Wenn Sie nicht 100% zufrieden mit Ihrer Bestellung sind, können Sie Ihre Artikel(n) innerhalb von 60 Tagen zurückgeben.</p>
                                    <p>Für <span class="red">Bademode &amp; Unterwäsche</span>, wenn es kein Qualitätsproblem gibt, akzeptieren wir KEINE Rückgabe oder Umtausch, Prüfen Sie Details hier <a class="a_red" href="<?php echo LANGPATH; ?>/returns-exchange" title="Rückgabe Politik">Rückgabe Politik</a>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                if($is_mobile)
                {
                ?>
                <!-- mobile view -->
                <div class="phone-product-info col-sm-12">
                    <div class="accordion-group visible-phone">
                        <div class="accordion-heading JS-toggle">
                            <a class="accordion-toggle " href="javascript:void(0);">Details
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
                        ?>
                        <div class="accordion-body JS-toggle-box hide" style="display:block;">
                            <div class="accordion-inner">
                                <ul class="unstyled">
                                    <div class="bd">
                                        <?php
                                        $brief = str_replace(array('One size', 'one size', 'One Size'), array('eine Größe'), $brief);
                                        echo $brief;
                                        ?>
                                        <br>
                                        <p>       
                                        <?php $description = $product->get('description');
                                        if(isset($repla['description']))
                                        {
                                            $description = $repla['description'];
                                        }
                                        $description = str_replace(';', '<br>', $description);
                                        if($description)
                                            echo $description;  
                                        ?>
                                        </p>
                                        </div>  
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <div class="accordion-group visible-phone">
                        <div id="phone_review_list"></div>
                        <div class="accordion-heading JS-toggle">
                            <a class="accordion-toggle " href="javascript:void(0);">Lieferung
                                <i class="fa flr fa-caret-down"></i>
                            </a>
                        </div>
                        <div class="accordion-body JS-toggle-box hide">
                            <div class="accordion-inner">
                                <ul class="unstyled">
                                    <div class="bd">
                                        <p style="color:#F00;">Empfangszeit = Bearbeitungszeit(3-5 Arbeitstage) + Versandzeit</p>
                                        <h4>Versand:</h4>
                                        <p>(1)  Kostenloser weltweiter Versand (10-15 Arbeitstage)</p>
                                        <p style="color:#F00; padding-left:18px;">Keine Mindestbestellung erforderlich.</p>
                                        <p>(2)  <?php echo Site::instance()->price(15, 'code_view'); ?> Express Versand (4-7 Arbeitstage)</p>
                                        <p style="padding-left:18px;">Prüfen Sie Details hier <a class="a_red" href="<?php echo LANGPATH; ?>/shipping-delivery" title="Versand &amp; Lieferung">Versand &amp; Lieferung</a>.</p>
                                        <h4>Rückgabe Politik:</h4>
                                        <p>Wenn Sie nicht 100% zufrieden mit Ihrer Bestellung sind, können Sie Ihre Artikel(n) innerhalb von 60 Tagen zurückgeben.</p>
                                        <p>Für <span class="red">Bademode &amp; Unterwäsche</span>, wenn es kein Qualitätsproblem gibt, akzeptieren wir KEINE Rückgabe oder Umtausch, Prüfen Sie Details hier <a class="a_red" href="<?php echo LANGPATH; ?>/returns-exchange" title="Rückgabe Politik">Rückgabe Politik</a>.</p>
                                    </div>  
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group visible-phone">
                        <div class="accordion-heading JS-toggle">
                            <a class="accordion-toggle " href="javascript:void(0);">Kontakt
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
                                            <img src="<?php echo STATICURL; ?>/assets/images/livemessage.png" alt="Leave Message"> Eine Nachricht hinterlassen
                                        </a>
                                    </div>
                                    <div class="mt10 ml10">
                                        <a href="<?php echo LANGPATH; ?>/faqs" target="_blank">
                                            <img src="<?php echo STATICURL; ?>/assets/images/faq.png" alt="FAQ"> FAQ
                                        </a>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?> 
            </div>
            <div class="four-partake phone-size hidden-sm hidden-md hidden-lg">
                <span class='st_pinterest_hcount' displayText='Pinterest'></span>
                <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
                <script type="text/javascript">stLight.options({publisher: "76c0dd88-6e79-4e80-875e-7bc8934145b8", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
                <span class='st_fblike_hcount hidden-xs' displayText='Facebook Like'></span>
                <span class='st_facebook_hcount' displayText='Facebook'></span>
                <!--<span class='st_twitter_hcount' displayText='Tweet'></span>-->
                <span class='st_tumblr_hcount' displayText='Tumblr'></span>
                <!--<script type="text/javascript" src="http://akwww.polyvorecdn.com/rsrc/add_to_polyvore.js"></script>
                <a target="_blank" href="http://www.polyvore.com" name="addToPolyvore" id="addToPolyvore" data-product-url="<?php echo $plink; ?>" data-image-url="<?php echo Image::link($cover, 2); ?>" data-name="<?php $pname ?>" data-price="$|<?php echo $pprice; ?>"><img src="http://www.polyvore.com/rsrc/icons/embed/AddToPolyvore_61x20.png"/></a>--> 
            </div>
       

                <div class="index-fashion buyers-show">
                    <div class="phone-fashion-top w-tit">
                        <h2>Andere Kunden sehen auch</h2>
                    </div>
                    <div class="flash-sale">
                        <ul class="row" id="phone_scare">
                        </ul>
                    </div>  
                </div>
            <script type="text/javascript">
                $(function(){
                    $.ajax({
                        type: "POST",
                        url: "<?php echo LANGPATH; ?>/ajax/product_relate",
                        dataType: "json",
                        data: "product_id=<?php echo $product_id; ?>",
                        success: function(relate_products){
                            if(!relate_products){
                                $(".phone-fashion-top").hide();
                                $("#alsoview").hide();
                            }
                            else
                            {
                                for(var o in relate_products)
                                {
                                    if(o > 0)
                                    {
                                        var relate_html = '<div class="hide-box1-' + o + ' hide">';
                                    }
                                    else
                                    {
                                        var relate_html = '<div class="hide-box1-' + o + '">';
                                    }
                                    for(var p in relate_products[o])
                                    {
                                        var relate_product = relate_products[o][p];
                                        relate_html += '<li style="display: inline-block" class="rec-item">\
                                        <a href="' + relate_product['link'] + '">\
                                        <img src="' + relate_product['cover_image'] + '" class="rec-image" id="' + relate_product['sku'] + '">\
                                        </a>\
                                        <p class="price"><b>' + relate_product['price'] + '</b></p>\
                                        </li>';
                                        // add phone
                                        if(p <= 2)
                                        {
                                            phone_scare = '\
                                            <li class="col-xs-4">\
                                            <a href="' + relate_product['link'] + '">\
                                            <img src="' + relate_product['cover_image'] + '" class="rec-image" id="' + relate_product['sku'] + '">\
                                            <p class="price">' + relate_product['price'] + '</p>\
                                            </a>\
                                            </li>\
                                            ';
                                            $("#phone_scare").append(phone_scare);
                                        }
                                    }
                                    relate_html += '</div>';
                                    $("#personal-recs").append(relate_html);
                                }
                                $("#alsoview").show();
                                $(".phone-fashion-top").show();
                            }
                        }
                    });
                })
            </script>
            <?php
            // mobile diff width pc --- sjm 2016-01-14
            if(!$is_mobile)
            {
                $has_link = $product->get('has_link');
                $has_link = 1;

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

                    if(!empty($celebrity_images))
                    {
                    ?>
                    <div class="other-customers">
                        <div class="w-tit">
                            <h2>SCHAU DER KÄUFER</h2>
                        </div>
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
                                $grey = $cel_num % 4;
                                if($grey == 4)
                                    $grey = 0;
                                if($grey >0)
                                {
                                    ?>
                                    <?php 
                                        if($grey == 1)
                                        { 
                                            echo '<li style="margin: 0; width:74.166666667%;">';
                                        }
                                        elseif($grey == 2)
                                        {
                                            echo '<li style="margin: 0; width:48.33333333333%;">';
                                        }
                                        elseif($grey == 3)
                                        {
                                            echo '<li>';   
                                        }
                                    ?>
                                        <img src="<?php echo STATICURL; ?>/assets/images/en/1603/buyers0<?php echo $grey;?>.jpg" />
                                    </li>
                                    <?php
                                }
                                ?>
                                </ul>
                            <div class="clearfix"></div>
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
                                $grey = $count % 4;
                                if($grey == 4)
                                    $grey = 0;
                                if($grey >0)
                                {
                                    ?>
                                    <?php 
                                        if($grey == 1)
                                        { 
                                            echo '<li style="margin: 0; width:74.166666667%;">';
                                        }
                                        elseif($grey == 2)
                                        {
                                            echo '<li style="margin: 0; width:48.33333333333%;">';
                                        }
                                        elseif($grey == 3)
                                        {
                                            echo '<li>';   
                                        }
                                    ?>
                                        <img src="<?php echo STATICURL; ?>/assets/images/en/1603/buyers0<?php echo $grey;?>.jpg" />
                                    </li>
                                    <?php
                                }
                                ?>
                                </ul>
                                <div class="clearfix"></div>
                                <div class="bt-view"><p>Mehr Sehen+</p></div>
                            <?php
                            }
                            ?>
                            </div>  
                        </div>
                    <?php
                    }
                    ?>
                        <?php
                        /*if ($has_link == 1 AND !empty($link_images))*/
                        if(0)
                        {
                        ?>
                        <!-- get the look -->
                        <div class="other-customers">
                            <div class="w-tit">
                                <h2>SEHEN SIE HIER</h2>
                            </div>
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
                                        <a class="btn btn-primary btn-sm flr" data-reveal-id="myModal5<?php echo $key; ?>" title="<?php echo $key; ?>" >SEHEN SIE HIER</a>
                                    </li>
                    <?php
                    if (isset($skus) && is_array($skus))
                    {
                    ?>
                        <div id="myModal5<?php echo $key; ?>" class="reveal-modal xlarge">
                        <a class="close-reveal-modal close-btn3"></a>
                        <!-- look-box -->
                        <div class="look-pro">
                        <?php
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
                                                <input type="checkbox" name="check[<?php echo $n; ?>]" title="size<?php echo $n; ?>" class="checkbox" checked="checked" id="checkout<?php echo $pro_id . $key; ?>" /> <label for="checkout<?php echo $pro_id . $key; ?>">IN DEN WARENKORB</label>
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
                                                <p class="select">Größe: 
                                                    <select name="size[<?php echo $n; ?>]" class="size_select" <?php if(!$instock) echo 'disabled="disabled"'; ?>>
                                                        <?php
                                                        $is_onesize = 0;
                                                        $set = $link_pro->get('set_id');
                                                        if(!empty($pro_stocks))
                                                        {
                                                            echo '<option>Größe Wählen</option>';
                                                            foreach($pro_stocks as $size => $p)
                                                            {
                                                                $sizeval = $size;
                                                                if($set == 2)
                                                                {
                                                                        $sizeArr = explode('/', $size);
                                                                        if(count($sizeArr)>1){
                                                                            $sizeval = $sizeArr[2];
                                                                        }
                                                                        
                                                                }
                                                            ?>
                                                            <option value="<?php echo str_replace('EUR', '', $sizeval); ?>" ><?php echo $sizeval; ?> <span class="red">(Nur noch <?php echo $p; ?> auf Lager!)</span></option>
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
                                                                    echo '<option>Größe Wählen</option>';
                                                                foreach ($attributes['Size'] as $size)
                                                                {
                                                                    $sizeval = $size;
                                                                    if($set == 2)
                                                                    {
                                                                            $sizeArr = explode('/', $size);
                                                                            if(count($sizeArr)>1){
                                                                                $sizeval = $sizeArr[2];
                                                                            }
                                                                    }
                                                                    $sizeSmall = str_replace(array('One size', 'one size', 'One Size'), 'eine Größe', $sizeval);
                                                                    ?>
                                                                        <option value="<?php echo str_replace('EUR', '', $sizeval); ?>" ><?php echo $sizeSmall; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            else
                                                            {
                                                                $is_onesize = 1;
                                                                ?>
                                                                <option value="one size" <?php if (isset($pro_stocks['one size'])) echo 'title="' . $pro_stocks['one size'] . '"' ?>>eine Größe</option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <input type="hidden" class="size_input" name="size<?php echo $n; ?>" value="<?php if($is_onesize) echo 1; ?>" />
                                                </p>
                                                <p class="select">Menge: <input type="text" class="text" name="qty[<?php echo $n; ?>]" value="1" <?php if(!$instock) echo 'disabled="disabled"'; ?> /></p>
                                                <p class="center"><a href="<?php echo $sku_link; ?>" class="btn22_gray" target="_blank">DETAILS</a></p>
                                                <?php
                                                if (!$instock)
                                                    echo '<span class="outstock red">Ausverkauft</span>';
                                                ?>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                        </ul>
                                    </div>
                                    <div class="add-bag" style="margin-bottom:40px;">
                                        <input value="IN DEN WARENKORB" class="btn btn-primary btn-lg" type="submit"><a href="<?php echo LANGPATH; ?>/wishlist/add_more/<?php echo implode('-', $wishlist); ?>" class="a-underline add-wishlist">MEINE WUNSCHLISTE</a>
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
                                        },
                                        messages: {
                                            size0: {
                                                required:"Erforderliches Feld.",
                                            },
                                            size1: {
                                                required:"Erforderliches Feld.",
                                            },
                                            size2: {
                                                required:"Erforderliches Feld.",
                                            },
                                            size3: {
                                                required:"Erforderliches Feld.",
                                            },
                                            size4: {
                                                required:"Erforderliches Feld.",
                                            },
                                            size5: {
                                                required:"Erforderliches Feld.",
                                            },
                                            size6: {
                                                required:"Erforderliches Feld.",
                                            },
                                            size7: {
                                                required:"Erforderliches Feld.",
                                            }
                                        },
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

                        ?>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                            </ul>
                            <?php
                        }
                        ?>
                            <?php
                            if($key > 0)
                            {
                                ?>
                                <div class="bt-view a-underline mt10"><p>Mehr Sehen+</p></div>
                                <?php
                            }
                            ?>
                            </div>  
                        </div>
                        <?php
                        }
                        ?>

                        <script type="text/javascript">
                            $(document).ready(function() {
                                $(".bt-view p").click(function() {
                                    var text = $(this).text();
                                    if(text == 'Mehr Sehen+')
                                    {
                                        $(this).text("Wenig Sehen-");
                                    }
                                    else if(text == 'Wenig Sehen-')
                                    {
                                        $(this).text("Mehr Sehen+");
                                    }
                                })
                            });
                        </script>
                        <script type="text/javascript">
                            $(function(){
                                $(".JS-popwinbtn4").click(function(){
                                    var id = $(this).attr('title');
                                    $("#form" + id).show().siblings().hide();
                                })
                            })
                        </script>
                <div class="other-customers hidden-xs" id="alsoview" style="display:none;">
                    <div class="w-tit">
                        <h2>Andere Kunden sehen auch</h2>
                    </div>
                    <div class="box-dibu1">
                        <div id="personal-recs">
                            
                        </div>
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
<!--                     <div class="other-customers" id="recent_view1">
    <div class="w-tit">
        <h2>Kürzlich Angesehen</h2>
    </div>
    <div class="box-dibu1">
        <div id="personal-recs">
            <div class="hide-box1-0">
                <ul id="recent_view">
                </ul>
            </div>
        </div>
    </div>  
</div> -->
            <div class="four-lay">
                <div class="box-title">
                    <ul>
                        <li class="current ml10" style="margin-left:10%;">FLASH SALE</li>
                        <li class="">Neuheiten</li>
                        <li class="">Bestseller</li>
                        <li class="" id="recent_li">Kürzlich Angesehen</li>
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
                                    $flash_link = Product::instance($flash['product_id'], LANGUAGE)->get('link');
                                    $flash_sku = Product::instance($flash['product_id'])->get('sku');
                                    ?>
                                    <li class="rec-item"> 
                                        <a href="<?php echo LANGPATH; ?>/product/<?php echo $flash_link . '_p' . $flash['product_id']; ?>"> 
                                            <img src="<?php echo Image::link(Product::instance($flash['product_id'])->cover_image(), 7); ?>" alt="<?php echo $flash_name; ?>" id="<?php echo $flash_sku;?>" class="product-flashsale">
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
                                    $relate_sku = Product::instance($pid)->get('sku');
                                    ?>
                                    <li class="rec-item"> 
                                        <a href="<?php echo LANGPATH; ?>/product/<?php echo $relate_link . '_p' . $pid; ?>"> 
                                            <img src="<?php echo Image::link(Product::instance($pid)->cover_image(), 7); ?>" alt="<?php echo $relate_name; ?>" id="<?php echo $relate_sku;?>" class="product-flashsale">
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
                                $news = DB::query(Database::SELECT, 'SELECT id, name, link, price, has_pick FROM products_product WHERE  visibility = 1 AND status=1 AND stock <> 0 AND deleted = 0 ORDER BY display_date DESC LIMIT 0, 7')->execute()->as_array();  
                                $cache->set($keynews, $news, 7200);
                            }   
                            foreach($news as $pdetail)
                            {
                                ?>
                                <li class="rec-item"> 
                                    <a href="<?php echo LANGPATH; ?>/product/<?php echo $pdetail['link'] . '_p' . $pdetail['id']; ?>"> 
                                        <img src="<?php echo Image::link(Product::instance($pdetail['id'])->cover_image(), 7); ?>" alt="<?php echo $pdetail['name']; ?>" id="<?php echo Product::instance($pdetail['id'])->get('sku');?>" class="product-newin">
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
                            $hots = DB::query(Database::SELECT, 'SELECT cp.product_id FROM products_categoryproduct cp left join products_product p on cp.product_id = p.id   WHERE cp.category_id = 32 and p.visibility = 1 AND p.status=1 AND p.stock <> 0 ORDER BY cp.position DESC LIMIT 0, 7')->execute()->as_array();
                                $cache->set($keyhots, $hots, 7200);
                            }   
                            foreach($hots as $h)
                            {
                                $hproduct = Product::instance($h['product_id'], LANGUAGE);
                                ?>
                                <li class="rec-item"> 
                                    <a href="<?php echo $hproduct->permalink(); ?>"> 
                                        <img src="<?php echo Image::link($hproduct->cover_image(), 7); ?>" alt="<?php echo $hproduct->get('name'); ?>" id="<?php echo $hproduct->get('sku');?>" class="product-topseller">
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
                <?php
                }
                ?>
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
    <h2>Größetabelle</h2>
    <!-- size guide2 -->
    <ul class="JS-tab-size size-tab two-bor">
        <?php if ($set_id != 2): ?>
            <li class="dt-s2 current">KLEIDUNG</li>
            <li class="dt-s2 pc-size" style="width:250px;">UMRECHNUNGSTABELLE</li>
        <?php endif; ?>
        <?php if ($set_id == 2): ?>
            <li class="dt-s2 current">SCHUHE</li>
<!--         <?php // else: ?>
    <li class="dt-s2 two-bor">SCHUHE</li> -->
        <?php endif; ?>
        <?php if (Product::instance($product_id)->get('set_id') != 2 AND !empty($celebrity_lists)): ?>
            <li class="dt-s2 pc-size">Probieren Bericht</li>
        <?php endif; ?>
        <li class="dt-s2 pc-size">MESSUNGEN</li>
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
                            $titlekey = 'Ärmellänge';
                        elseif ($titlekey == 'hips')
                            $titlekey = 'hip';
                        if (!isset($details[$titlekey]))
                            $details[$titlekey] = array();
                        if(isset($de[1]))
                            $details[$titlekey][$key] = $de[1];
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
                        <th width="10%" rowspan="2">Größe</th>
                        <?php
                        if (!empty($us_sizes))
                        {
                            ?>
                            <th width="5%" rowspan="2">US Größe</th>
                            <th width="5%" rowspan="2">UK Größe</th>
                            <th width="5%" rowspan="2">EU Größe</th>
                            <?php
                        }
                        ?>
                        <th width="15%" colspan="2">Schulter</th>
                        <th width="15%" colspan="2">Büste</th>
                        <th width="15%" colspan="2">Taille</th>
                        <th width="15%" colspan="2">Hüfte</th>
                        <th width="15%" colspan="2">Länge</th>
                        <th width="15%" colspan="2">Ärmellänge</th>
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
                            $size = 'eine Größe';
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
                                        $i = round($c * 0.39370078740157, 1);
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
                    <h3>Clothing - International Size Conversion Chart</h3>
                    <table width="100%" class="user-table">
                        <tr>
                            <th width="5%" rowspan="2">US Size</th>
                            <th width="5%" rowspan="2">UK Size</th>
                            <th width="5%" rowspan="2">EU Size</th>
                            <th width="15%" colspan="2" class="bust">Büste</th>
                            <th width="15%" colspan="2" class="waist">Taille</th>
                            <th width="15%" colspan="2" class="hip">Hüfte</th>
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
                        <td class="b" bgcolor="f4f4f0">Frankreich/Spanien</td>
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
                        <td class="b" bgcolor="f4f4f0">Deutschland</td>
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
                        <td class="b" bgcolor="f4f4f0">Italien</td>
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
                    <th width="28%">EUROPA</th>
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
            <p>Bitte nutzen Sie diese Größentabelle, um Ihrer Größe zu bestimmen. Größe auf unserer Website ist manuell gemessen, könnte es kleine Abweichungen geben. Wenn Sie eine besondere Größenanforderung haben oder mehr Informationen kennen möchten, wenden Sie sich bitte an unseren Kundenservice: <a href="mailto:service_de@choies.com">service_de@choies.com</a>. </p>
        </div>
            <?php
        }
        ?>
        
        <?php
        if (Product::instance($product_id)->get('set_id') != 2 AND !empty($celebrity_lists))
        {
            ?>
            <div class="bd hide">
                <h3 class="center">Probieren Bericht</h3>
                <table width="100%" class="user-table">
                    <tr>
                        <th width="5%" rowspan="2">Name</th>
                        <th width="5%" rowspan="2">Größe zu passen</th>
                        <th width="15%" colspan="2">Höhe</th>
                        <th width="15%" colspan="2">Gewicht</th>
                        <th width="15%" colspan="2">Büste</th>
                        <th width="15%" colspan="2">Taille</th>
                        <th width="15%" colspan="2">Hüfte</th>
                    </tr>
                    <tr>
                        <th>Fuß</th>
                        <th>cm</th>
                        <th>Pfd</th>
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
                            $cel_attrs = DB::query(Database::SELECT, 'SELECT i.attributes FROM orders_orderitem i 
                        LEFT JOIN orders_order o ON  i.order_id = o.id
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
                            $celebrity = DB::query(Database::SELECT, 'SELECT show_name,height,weight,bust,waist,hips FROM celebrities_celebrits WHERE id = ' . $cid)->execute()->current();
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
            <h3>KLEIDUNG</h3>
            <div class="clearfix">
                <div class="fll"><img src="<?php echo STATICURL; ?>/assets/images/<?php echo LANGPATH; ?>/docs/size-guide1.jpg" /></div>
                <div class="right flr" style="padding-left:20px;">
                <p>
                    <strong>a) Brustumfang</strong>
                    <br> *Dies ist nicht Ihre BH-Größe! 
                    <br> *Einen ungepolsterten BH Tragen (Ihr Kleid wird einen integrierten BH haben.)
                    <br> *Relax Arme an den Seiten
                    <br> *Pull-Band über die volle Teil der Büste 
                </p>
                <p>
                    <strong>b) Taille</strong>
                    <br> *Finden Sie die natürliche Taille
                    <br> *Dies ist die kleinste Teil der Taille
                    <br> *In der Regel ca. 1 Zoll. über den Bauchnabel
                    <br> *Halten Band leicht locker für Platz zum Atmen erlauben
                </p>
                <p>
                    <strong>c) Hüfte</strong>
                    <br> *Den breitesten Teil der Hüften Suchen
                    <br> *In der Regel ca. 8 Zoll. unter der natürlichen Taille
                    <br> *Tape sollte über beide Hüftknochen Pinsel
                </p>
                    </div>
            </div>
            <h3>SCHUHE</h3>
            <div class="clearfix">
                <div class="fll" style="width:320px;"><img width="320" src="<?php echo STATICURL; ?>/assets/images/<?php echo LANGPATH; ?>/docs/size-guide6.jpg" /></div>
                <div class="right flr" style="padding-left:25px;">
                    <h4>FUSSLÄNGE</h4>
                    <p>Messen Sie bitte Ihren Fuß, indem Sie ein Lineal entlang der Innenseite Ihrer Füße von der Hacke bis zu den Zehen flach auf dem Untergrund anlegen. </p>
                    <h4>SCHUHHÖHE</h4>
                    <p>Stellen Sie die Schuhe auf eine gerade Fläche und messen Sie die Rückseite vom oberen Schaftrand bis zu den Boden.</p>
                    <h4>ABSATZHÖHE</h4>
                    <p>Messen Sie bitte die Rückseite der Schuhe vom oberen Absatzrand bis zum unteren Absatzrand.</p>
                    <h4>ROHRHÖHE</h4>
                    <p>= SCHUHHÖHE - ROHRHÖHE</p>
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
                    $("#product_status").html('<strong class="red">Ausverkauft</strong>');
                    $("#addCart").hide();
                }
                else
                {
                    $("#product_status").html('Auf Lager');
                    $("#addCart").show();
                }
                $(".orig_price").html(product['s_price']);
                $(".product_price").html(product['price']);
                var attributesSize = product['attributeSize'].replace('<span>one size</span>', '<span>eine Größe</span>');
                var attributesPhone = product['attributePhone'].replace('<span>one size</span>', '<span>eine Größe</span>');
                <?php
                if($crumbs[0]['id'] == 53)
                {
                    ?>
                    $("#pc_size").html(attributesSize);
                    $("#phone_size").html(attributesPhone);
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
                if(value == 'one size')
                {
                    value = 'eine Größe';
                }
                $("#size-val").html(value);
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

<script type="text/javascript">
    var quantity = 1;
    $(function(){
        $("#formAdd").submit(function(){
            if(winWidth <= 768)
            {
                return true;
            }
            var obj = document.getElementById('qty');
            quantity = obj.value;
            $.ajax({
                url:'<?php echo LANGPATH; ?>/cart/ajax_add',
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
                $("#recent_view1").remove();
            }
            else
            {
                $("#recent_view1").show();
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
            //    $("#same_paragraph").show();
                $(".same-paragraph1").hide();
            }
            else
            {
                $("#same_paragraph").show();
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
<?php 
    $nowcurrency = Site::instance()->currency();
?>
<script type="text/javascript">
window._fbq.push(["track", "ViewContent", { content_type: 'product', content_ids: ['<?php echo $product_id; ?>'], product_catalog_id: '908216835935784' }]);
fbq('track', 'ViewContent'),{
    content_name: "<?php echo $product_name; ?>",
    content_category: "<?php echo $cataname; ?>",
    content_ids: ['<?php echo $product->get('id'); ?>'],
    content_type: 'product',
    value:"<?php echo $price; ?>",
    currency: "USD"
    };
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