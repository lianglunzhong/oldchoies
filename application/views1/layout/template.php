<?php
//引入多语言配置
if(empty(LANGUAGE))
{
    $lists = Kohana::config('lang.en');
}
else
{
    $lists = Kohana::config('lang.'.LANGUAGE);
}
$footer = $lists['footer'];
$pc_content = $lists['pc_content'];
$phone_content = $lists['phone_content'];
$customer = $lists['customer'];

//if(!empty(LANGUAGE))
//{
//    $key = 'title'.LANGUAGE.$title;
//    $words = Cache::instance('memcache')->get($key);
//    if(empty($words))
//    {
//        $str = $title;
//        $words = Site::googletransapi($blank='en',$target=LANGUAGE,$str);
//        if($words != 1)
//        {
//            $words = json_decode($words);
//            $words = $words->data->translations[0]->translatedText;
//            $title = $words;
//            Cache::instance('memcache')->set($key, $words, 86400*20);
//        }
//    }
//    $key = 'description'.LANGUAGE.$description;
//    $words = Cache::instance('memcache')->get($key);
//    if(empty($words))
//    {
//        $str = $description;
//        $words = Site::googletransapi($blank='en',$target=LANGUAGE,$str);
//        if($words != 1)
//        {
//            $words = json_decode($words);
//            $words = $words->data->translations[0]->translatedText;
//            $description = $words;
//            Cache::instance('memcache')->set($key, $words, 86400*20);
//        }
//    }
//}
?>
<!DOCTYPE html>
<html xml:lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" id="viewport" name="viewport">
        <title><?php echo  $title; ?></title>
        <meta name="description" content="<?php echo $description; ?>" />
        <meta property="fb:app_id" content="<?php echo Site::instance()->get('fb_api_id'); ?>" />
        <link type="image/x-icon" rel="shortcut icon" href="/favicon.ico" />
        <link rel="stylesheet" href="<?php echo Site::instance()->version_file('/assets/css/style.css'); ?>" media="all" id="mystyle" />
        <script src="<?php echo Site::instance()->version_file('/assets/js/jquery-1.8.2.min.js'); ?>"></script>
        <script src="<?php echo Site::instance()->version_file('/assets/js/plugin.js'); ?>"></script>

        <!-- Facebook Pixel Code CMCM -->
        <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','//connect.facebook.net/en_US/fbevents.js');fbq('init', '553200044828510');
            <?php $type = isset($type) ? $type : '';
                $pagearray = array(
                        'home' => 'PageView',
                        'product' => 'ViewContent',
                        'cart_view' => 'AddToCart',
                        'purchase' => 'InitiateCheckout',
                        'home' => 'PageView',
                    );
                $pagenow = '';
                $pagenow = isset($pagearray[$type]) ? $pagearray[$type] : $pagearray['home'];
            
            if($pagenow == 'PageView')
            {
                echo 'fbq("track", "PageView");';                
            }
            ?>
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=553200044828510&ev=<?php echo isset($pagenow) ? $pagenow : '';?>&noscript=1"/></noscript>
        <!-- End Facebook Pixel Code CMCM -->

        <!-- Facebook Pixel Code NJKY -->
        <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','//connect.facebook.net/en_US/fbevents.js');fbq('init', '454325211368099');
        <?php
            if(isset($pagenow))
            {
                if($pagenow == 'PageView')
                {
                    echo 'fbq("track", "PageView");';                
                }                
            }
        ?>
        </script>
        <noscript><img height="1" width="1" style="display:none"src="https://www.facebook.com/tr?id=454325211368099&ev=<?php echo isset($pagenow) ? $pagenow : '';?>&noscript=1"/></noscript>
        <!-- End Facebook Pixel Code NJKY -->

            <?php
            $user_id = Customer::logged_in();
            ?>
        <!-- end Criteo Code For Home Page -->

        <!-- HK ScarabQueue statistics Code -->
        <?php
        if(!empty($_GET))
        {
            $url = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?'));
            ?>
            <link rel="canonical" href="<?php echo $_SERVER['HTTP_HOST'] . $url; ?>"/>
            <?php
        }
        ?>
        <?php
        if(isset($og_image))
        {
            ?>
        <meta property="og:image" content="<?php echo $og_image; ?>" />
            <?php 
        }
        ?>

        <?php
        $type = isset($type) ? $type : '';
        if($type == 'paysuccess')
        {
        ?>
<!-- Facebook Conversion Code for choies pay success page -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6027051164830', {'value':'<?php echo $value; ?>','currency':'USD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6027051164830&amp;cd[value]=<?php echo $value; ?>&amp;cd[currency]=USD&amp;noscript=1" /></noscript>
        <?php
        }
        ?>

        <?php
        $type = isset($type) ? $type : '';
        if($type == 'purchase' && isset($checkprice))
        {
        ?>
<!-- Facebook Conversion Code for choies check out page -->
        <script>(function() {
            var _fbq = window._fbq || (window._fbq = []);
          if (!_fbq.loaded) {
            var fbds = document.createElement('script');
            fbds.async = true;
            fbds.src = '//connect.facebook.net/en_US/fbds.js';
            var s = document.getElementsByTagName('script')[0];
             s.parentNode.insertBefore(fbds, s);
            _fbq.loaded = true;
          }
        })();
        window._fbq = window._fbq || [];
        window._fbq.push(['track', '6015191467430', {'value':'<?php echo $checkprice; ?>','currency':'USD'}]);
        </script>
        <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6015191467430&amp;cd[value]=<?php echo $checkprice; ?>&amp;cd[currency]=USD&amp;noscript=1" /></noscript>

<!-- Facebook Conversion Code for Checkouts - Yeahmobi -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0]; 
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6035664484245', {'value':'<?php echo $checkprice; ?>','currency':'USD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6035664484245&amp;cd[value]=<?php echo $checkprice; ?>&amp;cd[currency]=USD&amp;noscript=1" /></noscript>
<!-- end Facebook Conversion Code for Checkouts - Yeahmobi -->
                <?php
        }
        ?>  

        <?php
        $type = isset($type) ? $type : '';
        if($type == 'cart_view')
        {
        ?>

<!-- Facebook Conversion Code for Add to cart -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6014860836030', {'value':'<?php echo $amoutprice ?>','currency':'USD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6014860836030&amp;cd[value]=<?php echo $amoutprice; ?>&amp;cd[currency]=USD&amp;noscript=1" /></noscript>

<!-- Facebook Conversion Code for Adds to Cart - YeahMobi -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6035664475245', {'value':'<?php echo $amoutprice ?>','currency':'USD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6035664475245&amp;cd[value]=<?php echo $amoutprice; ?>&amp;cd[currency]=USD&amp;noscript=1" /></noscript>
<!--  end Facebook Conversion Code for Adds to Cart - YeahMobi -->

<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6027737862369', {'value':'<?php echo $amoutprice ?>','currency':'USD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6027737862369&amp;cd[value]=<?php echo $amoutprice; ?>&amp;cd[currency]=USD&amp;noscript=1" /></noscript>

                <?php
        }
        ?>  

        <meta name="p:domain_verify" content="be90fd5b7a3845f91275a2b1dad0f732"/>

        <!-- GA code -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            
            ga('create', 'UA-32176633-1', 'choies.com', {'siteSpeedSampleRate': 20});
            ga('require', 'displayfeatures');
            <?php
            if ($type != 'payment' && $type != 'purchase' && $type != 'cart' && $type != 'product' && $type != 'cart_view' && $type !='404page' && $type !='docpage')
            {
             ?>
            ga('send', 'pageview');
         <?php 
           

       }
            ?>

            <?php if($type == '404page'){ ?>
             ga('send', 'pageview');
            <?php    } ?>

            <?php $uro = substr($_SERVER['REQUEST_URI'], 1); ?>
            <?php if($type == 'docpage'){ ?>
             ga('send', 'pageview');
            <?php    } ?>

            <?php
            if ($type == 'home' || $type == 'purchase' || $type == 'cart' || $type == 'product' || $type == 'cart_view' || $type == 'category')
            {
            ?>
            ga('require', 'ec');
            <?php
            }
            ?>


        </script>
        
        <script type="text/javascript">
                    <?php 
            $cart = Cartcookie::get();   ?>
        </script>
  
    </head>
    <body>
            <!-- GA get user email -->
        <?php $user_session = Session::instance()->get('user');?>
        <script>
        var dataLayer = window.dataLayer = window.dataLayer || [];
        dataLayer.push({'userID': '<?php if($user_session['email']){ echo $user_session['email'];}else{ echo "";}?>'});
        </script>
        <!-- GA get user email -->
        <!-- Google Tag Manager -->
         <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5C85KV"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5C85KV');</script>
        <!-- End Google Tag Manager -->
        <?php
        if ($user_id)
        {
            $celebrity_session = Session::instance()->get('celebrity');
            if (isset($celebrity_session['id']) AND !isset($_GET['cid']))
            {
                ?>
                <script type="text/javascript">
                    var stateObject = {};
                    var title = "";
                    var newUrl = "<?php echo URL::site(Request::current()->uri) . URL::query(array('cid' => $celebrity_session['id'] . $celebrity_session['name'])); ?>";
                    history.pushState(stateObject,title,newUrl);
                </script>
                <?php
            }
        }
        $currencies = Site::instance()->currencies();
        ?>
        <div class="JS-popwincon5 popwincon popwincon-user hide">
            <a class="JS-close6 close-btn3"></a>
            <div class="col-xs-12" id="jsshowup">
            </div>
        </div> 
        <div class="page">
            <!-- header begin -->
            <?php
            if ($type != 'payment' && $type != 'purchase' && $type != 'cart')
            {
            ?>
            <header id="pc-header" class="site-header hidden-xs">
                <?php
                    $cache_topbanner_key = '1site_top_banner';
                    $cacheins = Cache::instance('memcache');
                    $cache_topbanner_content = $cacheins->get($cache_topbanner_key);

                    if($cache_topbanner_content and !is_array($cache_topbanner_content))
                    {
                        $cache_topbanner_content = unserialize($cache_topbanner_content);
                    }
                    if (isset($cache_topbanner_content) AND !empty($cache_topbanner_content) AND !isset($_GET['cache'])){
                        $top_banner = $cache_topbanner_content;
                    }else{
                        $top_banner = DB::select()->from('banners_banner')->where('type', '=', 'top_banner')->where('visibility', '=', 1)->where('lang', '=', LANGUAGE)->order_by('position', 'ASC')->execute()->as_array();
                       $cacheins->set($cache_topbanner_key,$top_banner, 3600);
                    }
                    if (array_key_exists(0,$top_banner)){ ?>

                    <!--top_banner-->
                    <div class="JS-popwincon1">
                    <div style="width:100%;background-color:<?php echo $top_banner[0]['alt'] ?>;">
                        <a class="JS-close2 close-btn2" style="top:0;right:5px;z-index:5;"></a>
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12 hidden-xs">
                                <a href="<?php echo $top_banner[0]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $top_banner[0]['image']; ?>" class="top_banner"></a>
                                </div>
                                <!-- <a href="<?php #echo $newindex_banners[0]['link']; ?>"><img src="<?php #echo STATICURL;?>/simages/<?php #echo $newindex_banners[0]['image']; ?>" class="navigation_banner1"></a> -->
                            </div>
                        </div>
                    </div>
                    </div>
                <?php } ?>

            <div class="n-nav-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-5 col-md-5 col-lg-4">
                            <div class="drop-down cs-show mr10">
                                <?php
                                $currency_now = Site::instance()->currency();
                                ?>
                                <div class="drop-down-hd">
                                    <?php
                                        echo $currency_now['name'];
                                    ?>
                                    <i class="fa fa-caret-down flr"></i>    
                                </div>
                                <ul class="drop-down-list cs-list" >
                                    <?php
                                    foreach ($currencies as $currency)
                                    {
                                        if(strpos($currency['code'], '$') !== False)
                                            $code = '$';
                                        else
                                            $code = $currency['code'];
                                        ?>
                                        <li class="drop-down-option" onclick="location.href='<?php echo LANGPATH; ?>/currency/set/<?php echo $currency['name'] ?>'">
                                            <a href="<?php echo LANGPATH; ?>/currency/set/<?php echo $currency['name'] ?>"><?php echo $currency['name']; ?></a>
                                        </li>
                                        
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="drop-down cs-show">
                                    <?php
                                    $request = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
                                    $request = rawurldecode($request);
                                    $request = Security::xss_clean($request);
                                    $request = htmlentities($request);
                                    if (LANGPATH){
                                        $request = substr(strstr($request, LANGPATH), strlen(LANGPATH));
                                    }
                                    ?>
                                <div class="drop-down-hd">
                                <?php
                                    if(in_array(LANGPATH, $lang_list))
                                    {
                                        $default_lang = array_search(LANGPATH, $lang_list);
                                        echo $default_lang;
                                    }
                                    else
                                    {
                                        echo 'English';
                                    }
                                ?>
                                    <i class="fa fa-caret-down"></i>    
                                </div>
                                <ul class="drop-down-list cs-list">

                                <?php

                                foreach($lang_list as $lang => $path)
                                {
                                    if ($lang=="Русский")
                                    {
                                    }else{
                                 ?>
                                    <li class="drop-down-option">
                                        <?php 
                                        if ($lang != $default_lang){
                                            if ($lang == 'English') {
                                            ?>
                                                <a href="<?php echo BASEURL.$request ; ?>"><?php echo $lang; ?></a>
                                                
                                            <?php 
                                            }else{
                                            ?>
                                                <a href="<?php echo $path.$request ; ?>"><?php echo $lang; ?></a>
                                            <?php } ?>
                                        <?php } ?>                                        
                                    </li>
                                <?php
                                    }
                                }
                                ?>                                    
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-2 col-md-2 col-lg-4 n-logo">
                            <a href="<?php echo LANGPATH;?>/" title="choies"><img src="<?php echo STATICURL;?>/assets/images/2016/logo.png"></a>
                        </div>
                        <div class="col-xs-5 col-md-4 col-md-offset-1 col-lg-4 col-lg-offset-0">
                            <div class="n-search fll">
                                <form action="/search" method="get" id="search_form" onsubmit="return search(this);">
                                    <ul>
                                        <li>
                                        <div class="search-btn-lg"><i class="fa fa-search" ></i><input value=""  class="n-search-btn" type="submit"></div>
                                        <input id="boss" name="searchwords" value="" class="search-text text" onblur="if(this.value==''){this.value=this.defaultValue;}" onfocus="if(this.value=='Search'){this.value='';};" type="search">
                                            <span class="search-close-hide" ></span>
                                            <span class="search-close"  style="display:none;"></span>
                                        </li>  
                                    </ul>
                                </form>
                                    <script type="text/javascript">
                                        function search(obj)
                                        {
                                            var q = obj.searchwords.value;
                                            var pattern = new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）&;|{}【】‘；：”“'。，、？]", "g");
                                            location.href = "<?php echo LANGPATH; ?>/search/" + q.replace(pattern, '_');
                                            return false;
                                        }
                                    </script>
                            </div>
                            
                            <div class="m-mybag drop-down JS-show flr" id="mybagli1">
                                <div class="drop-down-hd">
                                    <a class="bag-bg cart_count" href="<?php echo LANGPATH;?>/cart/view">0</a>
                                </div>
                                <div class="mybag-box JS-showcon hide" style="display:none;" >
                                    <span class="arrow-up"></span>
                                    <div class="mybag-con">
                                        <p class="title"><strong class="cart_count">0</strong> <?php echo $lists['bag']['ITEM']; ?><span class="cart_s"></span> <?php echo $lists['bag']['IN MY BAG']; ?></p>
                                        <div class="items">
                                            <ul class="cart_bag">
                                                <li>
                                                    <a class="mybag-pic" href="">
                                                        <img src="<?php echo STATICURL;?>/assets/images/3.jpg" alt=""></a>
                                                    <div class="mybag-info">
                                                        <a class="mybag-info-name" href="">Black PU High Waist Pleat Skirt</a>
                                                        <span>
                                                            <b>colour:</b> Natural
                                                        </span>
                                                        <span><b>Size:</b> M</span>
                                                        
                                                        
                                                        <span><b>QTY:</b> 1</span>
                                                        <span>
                                                            <b>Price:</b> $47.99 <em class="red">10%off</em>
                                                        </span>
                                                        <span class="cart-delete">REMOVE</span>
                                                    </div>                                                   
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="cart-all-goods">
                                            <p> TOTAL:<strong class="cart_amount"> $180.00</strong></p>
                                        </div>
                                        <div class="view-check">
                                            <a href="<?php echo LANGPATH;?>/cart/view" class="btn btn-default"><?php echo $lists['bag']['VIEW BAG & CHECKOUT']; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="reg-sin flr">
                                <?php
                                $user_session = Session::instance()->get('user');
                                if(empty($user_session)){
                                    // 小语种只展示登陆，英语展示登陆、注册
                                    if(!empty(LANGUAGE) and LANGUAGE != 'en') {
                                        ?>
                                        <div id="customer_sign_in" class="out">
                                            <a href="<?php echo LANGPATH; ?>/customer/login"><?php echo $customer['SIGN IN']; ?></a>
                                        </div>

                                        <?php
                                    }else{
                                        ?>
                                        <div id="customer_sign_in" class="out">
                                            <a href="<?php echo LANGPATH; ?>/customer/login"><?php echo $customer['REGISTER']; ?></a>
                                            <span>/</span>
                                            <a href="<?php echo LANGPATH; ?>/customer/login"><?php echo $customer['SIGN IN']; ?></a>
                                        </div>
                                        <?php
                                    }
                                }else{

                                ?>
                                <div id="customer_signed" class="drop-down cs-show hide" >
                                    <div class="drop-down-hd" id="customer_signed" >
                                        <span id="username"><?php echo $customer['choieser']; ?></span>
                                    </div>
                                    <ul class="drop-down-list cs-list" >
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/customer/orders"><?php echo $customer['My Order']; ?></a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/tracks/track_order"><?php echo $customer['Track Order']; ?></a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/customer/wishlist"><?php echo $customer['My Wishlist']; ?></a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/customer/profile"><?php echo $customer['My Profile']; ?></a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/customer/logout"><?php echo $customer['Sign Out']; ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php }?>

<!--                             <li class="mybag" id="mybag1">
    <div class="currentbag mybag-box hide">
        <span class="topicon"></span>
        <div class="mybag-con">
            <h4 class="tit">SUCCESS! ITEM ADDED TO BAG</h4>
            <div class="bag_items items mtb5">
                <ul class="cart_bag">
                    <li></li>
                </ul>
                <p><a href="/cart/view" class="btn btn-primary btn-lg">VIEW MY BAG</a></p>
            </div>
        </div>
    </div>
</li> -->
                        </div>  
                    </div>
                </div>
            </div>
            <div class="n-nav">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <nav id="nav1" class="nav">
                                <ul>
                                    <li class="cs-show p-hide" style="width:13%;">
                                        <a href="<?php echo LANGPATH. $pc_content['first']['title_link'];?>"><?php echo $pc_content['first']['title1']; ?> </a>
                                        <div class="nav-list cs-list">
                                            <span class="downicon tpn01"></span>
                                            <div class="nav-box">
                                                <div class="nav-list01 fll">
                                                    <dl class="nav-ul">
                                                        <dt class="title"><?php echo $pc_content['first']['title2'];; ?> </dt>
                                                        <?php
                                                        foreach ($pc_content['first']['content'] as $key =>$value)
                                                        {
                                                            ?>
                                                                 <dd><a href="<?php echo LANGPATH.$key;?>"><?php echo $value; ?></a></dd>
                                                            <?php
                                                        }
                                                        ?>
                                                    </dl>
                                                </div>
                                                    <?php
                                                        $cache_newindex_key = '1site_newindex_choies' .LANGUAGE;
                                                        $cacheins = Cache::instance('memcache');
                                                        $cache_newindex_content = $cacheins->get($cache_newindex_key);

                                                        if($cache_newindex_content and !is_array($cache_newindex_content))
                                                        {
                                                            $cache_newindex_content = unserialize($cache_newindex_content);
                                                        }
                                                 if (isset($cache_newindex_content) AND !isset($_GET['cache'])){
                                                            $newindex_banners = $cache_newindex_content;
                                                        }else{
                                                           $newindex_banners = DB::select()->from('banners_banner')->where('type', '=', 'newindex')->where('visibility', '=', 1)->where('lang', '=', LANGUAGE)->order_by('position', 'ASC')->execute()->as_array();
                                                           $cacheins->set($cache_newindex_key,$newindex_banners, 3600);
                                                        }
                                                        // var_dump($newindex_banners); die;
                                                        ?>
                                                <div class="nav-list02 fll">
                                                        <?php 
                                                        if(array_key_exists(0, $newindex_banners))
                                                        {
                                                        ?>
                                                    <a href="<?php echo LANGPATH.$newindex_banners[0]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[0]['image']; ?>" class="navigation_banner1"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>  
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cs-show" style="width:13%;">
                                        <a href="<?php echo LANGPATH. $pc_content['second']['title_link'];?>"><?php echo $pc_content['second']['title1']; ?></a>
                                        <div class="nav-list cs-list" style="margin-left:-100%;">
                                            <span class="downicon tpn02"></span>
                                            <div class="nav-box">
                                                <div class="nav-list03 fll">
                                                    <dl class="nav-ul01">
                                                        <dt class="title"><?php echo $pc_content['second']['title2']; ?> </a></dt>
                                                        <?php
                                                        foreach ($pc_content['second']['content'] as $key =>$value)
                                                        {
                                                            ?>
                                                            <dd><a href="<?php echo LANGPATH.$key;?>"><?php echo $value; ?></a></dd>
                                                            <?php
                                                        }
                                                        ?>
                                                    </dl>
                                                </div>
                                                <div class="nav-list04 fll" style="margin:18px 0 0 0">
                                                        <?php
                                                        if(array_key_exists(1, $newindex_banners))
                                                        {
                                                        ?>
                                                         <a href="<?php echo LANGPATH.$newindex_banners[1]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[1]['image']; ?>" class="navigation_banner2"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cs-show" style="width:13%;">
                                        <a href="<?php echo LANGPATH. $pc_content['third']['title_link'];?>"><?php echo $pc_content['third']['title1']; ?></a>
                                        <div class="nav-list cs-list" style="margin-left:-200%;">
                                            <span class="downicon tpn03"></span>
                                            <div class="nav-box">
                                                <div class="nav-list03 fll">
                                                    <dl class="nav-ul01">
                                                        <dt class="title"><?php echo $pc_content['third']['title2']; ?></dt>
                                                        <?php
                                                        foreach ($pc_content['third']['content'] as $key =>$value)
                                                        {
                                                            ?>
                                                            <dd><a href="<?php echo LANGPATH.$key;?>"><?php echo $value; ?></a></dd>
                                                            <?php
                                                        }
                                                        ?>
                                                    </dl>
                                                </div>
                                                <div class="nav-list04 fll">
                                                        <?php
                                                        if(array_key_exists(2, $newindex_banners))
                                                        {
                                                        ?>
                                                   <a href="<?php echo LANGPATH.$newindex_banners[2]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[2]['image']; ?>" class="navigation_banner3"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    
                                    <li class="cs-show" style="width:13%;">
                                      <!--  <a href="/accessory-c-52">ACCESSORIES</a> -->
                                        <a href="<?php echo LANGPATH. $pc_content['fourth']['title_link'];?>"><?php echo $pc_content['fourth']['title1']; ?></a>
                                        <div class="nav-list cs-list" style="margin-left:-300%;">
                                            <span class="downicon tpn04"></span>
                                            <div class="nav-box">
                                                <div class="nav-list03 fll">
                                                    <dl class="nav-ul01">
                                                        <dt class="title"><?php echo $pc_content['fourth']['title1']; ?></dt>
                                                        <?php

                                                        foreach ($pc_content['fourth']['content'] as $key =>$value)
                                                        {
                                                            ?>
                                                            <dd ><a href="<?php echo LANGPATH.$key;?>"><?php echo $value; ?></a></dd>
                                                            <?php
                                                        }
                                                        ?>
                                                    </dl>
                                                </div>
                                                <div class="nav-list04 fll">
                                                        <?php
                                                        if(array_key_exists(3, $newindex_banners))
                                                        {
                                                        ?>
                                                    <a href="<?php echo LANGPATH.$newindex_banners[3]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[3]['image']; ?>" class="navigation_banner4"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
<!--                                         <li class="cs-show">
                                   <a href="#">BEAUTY</a>
                                   <div class="nav-list cs-list" style="margin-left:-400%;">
                                       <span class="downicon tpn05"></span>
                                       <div class="nav-box">
                                           <div class="nav-list03 fll">
                                               <dl class="nav-ul01">
                                                   <dd><a href=""> Beauty</a></dd>
                                                   <dd><a href=""> Hair</a></dd>
                                               </dl>
                                           </div>
                                           <div class="nav-list04 fll">
                                                   <?php
                                                   if(array_key_exists(4, $newindex_banners))
                                                   {
                                                   ?>
                                               <a href="<?php echo LANGPATH.$newindex_banners[4]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[4]['image']; ?>" class="navigation_banner5"></a>
                                                   <?php
                                                   }
                                                   ?>
                                               </div>
                                               </div>
                                           </div>
                                       </li>  -->                                   
                                    <li class="cs-show p-hide" style="width:22%;">
                                        <a href="javascript:void(0)"><?php echo $pc_content['fifth']['title1']; ?></a>
                                        <div class="nav-list cs-list" style="margin-left:-236%;width: 454.5454545%;">
                                            <span class="downicon tpn06"></span>
                                            <div class="nav-box">
                                                <div class="nav-list01 fll">
                                                    <dl class="nav-ul">
                                                          <?php
                                                              foreach ($pc_content['fifth']['content'] as $key => $value){
                                                          ?>
                                                                  <dd><a href="<?php echo LANGPATH.$key; ?>"><?php echo $value ?></a></dd>
                                                          <?php
                                                              }
                                                          ?>
                                                    </dl>
                                                </div>
                                                <div class="nav-list02 fll">
                                                        <?php
                                                        if(array_key_exists(5, $newindex_banners))
                                                        {
                                                        ?>
                                                   <a href="<?php echo LANGPATH.$newindex_banners[5]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[5]['image']; ?>" class="navigation_banner6"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>  
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cs-show" style="width:13%">
                                        <a href="<?php echo LANGPATH. $pc_content['sixth']['title_link']; ?>" class="sale"><?php echo $pc_content['sixth']['title1']; ?></a>
                                   <div class="nav-list cs-list" style="margin-left:-569%;">
                                        <span class="downicon tpn006"></span>
                                        <div class="nav-box">
                                            <div class="nav-list01 fll">
                                                <dl class="nav-ul01">
                                                    <?php
                                                    foreach ($pc_content['sixth']['content'] as $key => $value){
                                                        ?>
                                                        <dd><a href="<?php echo LANGPATH.$key; ?>"><?php echo $value ?></a></dd>
                                                        <?php
                                                    }
                                                    ?>
                                                </dl>
                                            </div>
                                            <div class="nav-list02 fll">
                                                    <!-- <a href="/outlet-c-101">
                                                    <img src="<?php #echo STATICURL;?>/assets/images/1609/sale_banner.jpg" class="navigation_banner6"></a> -->
                                                    <?php
                                                   if(array_key_exists(4, $newindex_banners))
                                                   {
                                                   ?>
                                               <a href="<?php echo LANGPATH.$newindex_banners[4]['link']; ?>"><img src="<?php echo STATICURL; ?>/simages/<?php echo $newindex_banners[4]['image']; ?>" class="navigation_banner6"></a>
                                                   <?php
                                                   }
                                                   ?>
                                            </div>
                                        </div>
                                   </div>
                                    </li>
                                    <li class="cs-show" style="width:13%">
                                        <a href="<?php echo LANGPATH. $pc_content['seventh']['title_link']; ?>"><?php echo $pc_content['seventh']['title1']; ?></a>
                                        <div class="nav-list cs-list" style="margin-left:-669%;">
                                        <span class="downicon tpn07"></span>
                                        <div class="nav-box">
                                            <div class="nav-list01 fll">
                                                <dl class="nav-ul">
                                                    <?php
                                                    foreach ($pc_content['seventh']['content'] as $key => $value){
                                                    ?>
                                                    <dd><a href="<?php echo LANGPATH.$key; ?>"><?php echo $value ?></a></dd>
                                                    <?php
                                                    }
                                                    ?>
                                                </dl>
                                            </div>
                                            <div class="nav-list02 fll">
                                                    <?php
                                                   if(array_key_exists(9, $newindex_banners))
                                                   {
                                                   ?>
                                               <a href="<?php echo LANGPATH.$newindex_banners[9]['link']; ?>"><img src="<?php echo STATICURL; ?>/simages/<?php echo $newindex_banners[9]['image']; ?>" class="navigation_banner6"></a>
                                                   <?php
                                                   }
                                                   ?>
                                            </div>
                                        </div>
                                        </div>

                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- <div id="moblie-header" class="site-header hidden-xs" 
        style="top: 0px;position: fixed; width: 100%; z-index: 999;">           
        </div> -->

            <nav class="navbar-collapse collapse hidden-sm hidden-md hidden-lg">
                    <!-- Contenedor -->
                    <ul id="accordion" class="accordion">
                        <li>
                            <div class="link">
                                <span><?php echo $phone_content['phone_first'];?></span>
                                <span class="myaccount"><a href="<?php echo LANGPATH;?>/customer/summary"><?php echo $phone_content['phone_second'];?></a></span>
                            </div>
                        </li>
                        <li><div class="link"><span><?php echo  $phone_content['first']['title'];?></span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span><?php echo  $phone_content['Go Back'];?></span></a></li>
                                <?php foreach ( $phone_content['first']['content'] as $key => $value):  ?>
                                <li>
                                    <a href="<?php echo LANGPATH.$key; ?>"><?php echo  $phone_content['first']['title'].":". $value; ?>
                                    </a>
                                </li>
                                  <?php endforeach;?>
                                <!-- <li><a href="/new-presale-c-1012">Presale</a></li> -->  
                            </ul> 
                        </li>
                        <li>
                            <div class="link"><span class="icon-collection"><?php echo  $phone_content['second']['title']; ?></span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span><?php echo  $phone_content['Go Back']; ?></span></a></li>
                                <?php
                                    foreach( $phone_content['second']['content'] as $key => $value)
                                    {
                                 ?>
                                    <li><a href="<?php echo LANGPATH.$key; ?>"><?php echo $value; ?></a></li>
                                 <?php }?>
                            </ul>
                        </li>
                        <li>
                            <div class="link"><span class="icon-dresses"><?php echo  $phone_content['third']['title']; ?></span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span><?php echo $phone_content['Go Back']; ?></span></a></li>
                                <?php

                                     $hot_dresses = array("black-dresses-c-203","maxi-dresses-c-207","shirt-dresses-c-725","white-dresses-c-204");
                                     foreach ( $phone_content['third']['content'] as $key => $value):
                                ?>
                                <li><a href="<?php echo LANGPATH.$key; ?>" <?php if(in_array($key,$hot_dresses)){ echo 'class="red"'; }?>><?php echo $value; ?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-tops"><?php echo  $phone_content['fourth']['title']; ?></span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span><?php echo  $phone_content['Go Back']; ?></span></a></li>
                                <?php
                                    foreach ($phone_content['fourth']['content'] as $key => $value):
                                ?>
                                <li><a href="<?php echo LANGPATH.$key; ?>" ><?php echo $value; ?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-bottoms"><?php echo  $phone_content['fifth']['title']; ?></span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span><?php echo  $phone_content['Go Back']; ?></span></a></li>
                                <?php
                                foreach ( $phone_content['fifth']['content'] as $key => $value):
                                    ?>
                                    <li><a href="<?php echo LANGPATH.$key; ?>" ><?php echo $value; ?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-shoes"><?php echo  $phone_content['sixth']['title']; ?></span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span><?php echo  $phone_content['Go Back']; ?></span></a></li>
                                <?php
                                foreach ( $phone_content['sixth']['content'] as $key => $value):
                                    ?>
                                    <li><a href="<?php echo LANGPATH.$key; ?>" ><?php echo $value; ?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-jewellery"><?php echo  $phone_content['seventh']['title']; ?></span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span><?php echo  $phone_content['Go Back']; ?></span></a></li>
                                <?php

                                    $hot=array("purses-c-644","sunglasses-c-58");
                                    foreach ( $phone_content['seventh']['content'] as $key => $value):
                                ?>
                                    <li><a href="<?php echo LANGPATH.$key; ?>" <?php if(in_array($key,$hot)){ echo 'class="red"'; }?>><?php echo $value; ?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-acc"><?php echo  $phone_content['eighth']['title']; ?></span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span><?php echo  $phone_content['Go Back']; ?></span></a></li>
                                <?php
                                    $hot=array("purses-c-644","sunglasses-c-58");
                                    foreach ( $phone_content['eighth']['content'] as $key => $value):
                                ?>
                                    <li><a href="<?php echo LANGPATH.$key; ?>" <?php if(in_array($key,$hot)){ echo 'class="red"'; }?>><?php echo $value; ?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </li>
                        <li>
                            <div class="link"><span><a href="<?php echo LANGPATH. $phone_content['ninth']['link']; ?>"><?php echo $phone_content['ninth']['title']; ?></a></span></div>
                        </li>
                    </ul>
            </nav>
            <script>
            $(".phone-search").focus(function(){
                $(this).addClass("on");
            }).blur(function(){
                $(this).removeClass("on");
            }) 
            </script>
            <!-- Collect the nav links, forms, and other content for toggling -->
                <!-- PHONE GAIBAN 2015.10.22 -->
            <div class="clearfix hidden-xs"></div>
            <div class="phone-mask hide">
                <button type="button" class="navbar-toggle btn-on" id="phone-close-btn">
                    <i class="fa fa-angle-left"></i>
                </button>
            </div>
            <div class="site-content">
                <div class="phone-navbar hidden-sm hidden-md hidden-lg">
                    <div class="container">
                        <div class="row">
                            <nav class="navbar navbar-default" role="navigation">
                                <div >
                                    <!-- Toggle get grouped for better mobile display -->
                                    <div class="navbar-header">
                                        <div class="col-xs-2" style="padding:0;">
                                            <button type="button" class="navbar-toggle" id="phone-btn">
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                            </button>
                                        </div>
                                        <div class="col-xs-8" style="text-align:center;">
                                            <a class="logo" href="<?php echo LANGPATH; ?>/" title=""><img src="<?php echo STATICURL;?>/assets/images/2016/logo-moblie.png" alt=""></a>
                                        </div>
                                        <div class="col-xs-2" style="padding:0;">
                                                <a class="fa fa-search"></a>
                                                <a href="<?php echo LANGPATH;?>/cart/view" class="bag-phone-on cart_count"></a>
                                        </div>
                                    </div>
                                    <div class="navbar-search hide">
                                        <form action="/search" method="get" onsubmit="return search1('searchwords');">
                                        <div class="search-box">
                                            <input type="search" name="searchwords" id="searchwords"  class="phone-search" onblur="if(this.value==''){this.value=this.defaultValue;}" onfocus="if(this.value=='Search'){this.value='';};">
                                            <a class="fa fa-search" onclick="return search1('searchwords');"></a>
                                        </div>
                                        </form>
                                        <script type="text/javascript">
                                            function search1(id){
                                                var q = document.getElementById(id).value;
                                                location.href = "<?php echo LANGPATH; ?>/search/" + q.replace(/\s/g, '_');
                                                return false;
                                            }
                                        </script>
                                            </div>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
            <!--　PHONE GAIBAN ENDING 2015.10.22-->
            <div class="clearfix"></div>

                <span class="livechat"></span>
                <?php $domain = URLSTR; ?>
            </header>
            <?php
            }
            ?>
            
            <!-- main begin -->
            <div id="phone-main">
            <?php if (isset($content)) echo $content;?>
            </div>

            <?php
            if ($type != 'payment' && $type != 'purchase' && $type != 'cart')
            {
            ?>
            <footer>
                <div class="container-fluid footer-signin hidden-xs">
                    <div class="container">
                        <form action="" method="post" id="letter_form">
                            <label class=""><?php echo $footer['other']['first']; ?> </label>
                            <div>
                                <input type="text" class="signin-input" id="letter_text" class="text fll" value="<?php echo $footer['other']['second']; ?>" onblur="if(this.value==''){this.value=this.defaultValue;}" onfocus="if(this.value=='Enter your email address to receive newsletter'){this.value='';};">
                                <input type="submit" id="letter_btn" value="<?php echo $footer['other']['third']; ?> " class="btn btn-default">
                            </div>
                            <div class="red" id="letter_message" style="margin-left:160px;"></div>
                        </form> 
                           
                                <script language="JavaScript">
                                    $(function() {
                                        $("#letter_text").focus( 
                                              function () { 
                                                $(this).addClass("on"); 
                                              }).blur(function () { 
                                                $(this).removeClass("on"); 
                                              } 
                                            );
                                        $("#letter_form").submit(function() {
                                            var email = $('#letter_text').val();
                                            if (!email) {
                                                return false;
                                            }
                                            $.post(
                                                '/newsletter/ajax_add', {
                                                    email: email
                                                },
                                                function(data) {
                                                    $("#letter_message").html(data['message']);
                                                    if (data['success'] == 0) {
                                                        $('#letter_message').fadeIn(10).delay(3000).fadeOut(10);
                                                    } else {
                                                        $("#letter").css('display', 'none');
                                                        $("#letter_message").css('display', 'block');
                                                    }
                                                },
                                                'json'
                                            );
                                            return false;
                                        })
                                    })
                                </script>
                        <div class="footer-s">
                            <span><?php echo  $footer['other']['fourth']; ?></span>
                            <ul class="footer-sns">
                                <li><a href="https://www.facebook.com/choiescloth" target="_blank"  title="facebook">
                                    <i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://twitter.com/choiescloth" target="_blank"  title="twitter">
                                    <i class="fa fa-twitter"></i>
                                </a></li>
                                <li><a href="https://www.youtube.com/user/choiesclothes" target="_blank"  title="youtube">
                                    <i class="fa fa-youtube-play"></i>
                                </a></li>
                                <li><a href="http://style-base.tumblr.com/" target="_blank"  title="tumblr">
                                    <i class="fa fa-tumblr"></i>
                                </a></li>
                                <li><a href="https://www.instagram.com/choiesclothing/" target="_blank"  title="instagram">
                                    <i class="fa fa-instagram"></i>
                                </a></li>
                                <li><a href="https://www.pinterest.com/choiesfashion/" target="_blank"  title="pinterest">
                                    <i class="fa fa-pinterest"></i>
                                </a></li>
                                <li><a href="http://choies.studentbeans.com" target="_blank" title="pinterest">
                                    <img style="margin-top:-3px;" src="<?php echo STATICURL; ?>/assets/images/2016/sb-logo.png" data-pin-nopin="true"></a>
                                </li>
                            </ul>
                        </div>  

                    </div>  
                </div>

            <div class="container-fluid footer-main hidden-xs">
                <div class="container">
                    <div class="footer-mid">
                        <div class="footer-ship">
                            <ul class="row">
                                <li class="col-xs-3"><a class="shipping-icon" href="<?php echo LANGPATH; ?>/shipping-delivery"><span></span>
                            <?php echo  $footer['first']['first'] ; ?></a></li>
                                <li class="col-xs-3"><a class="returns-icon" href="<?php echo LANGPATH; ?>/returns-exchange"><span></span>
                            <?php echo $footer['first']['second'] ; ?> </a></li>
                                <li class="col-xs-3"><a class="size-icon" href="<?php echo LANGPATH; ?>/size-guide"><span></span>
                            <?php echo  $footer['first']['third'] ; ?>    </a></li>
                                <li class="col-xs-3"><a class="membership-icon" href="<?php echo LANGPATH; ?>/vip-policy"><span></span>
                            <?php echo  $footer['first']['fourth'] ; ?>    </a></li>
                            </ul>
                        </div>
                        <div class="footer-context">
                            <dl>
                                <dt><?php echo  $footer['second']['title'];?></dt>
                                <?php
                                foreach ($footer['second']['content'] as $key=>$value) {
                                    ?>
                                    <dd><a href="<?php echo LANGPATH.$key; ?>"><?php echo $value; ?></a></dd>
                                    <?php
                                }
                                ?>

                            </dl>
                            <dl>
                                <dt><?php echo $footer['third']['title'];?></dt>
                                <?php
                                foreach ($footer['third']['content'] as $key=>$value) {
                                    ?>
                                    <dd><a href="<?php echo LANGPATH.$key; ?>"><?php echo $value; ?></a></dd>
                                    <?php
                                }
                                ?>
                            </dl>
                            <dl>
                                <dt><?php echo $footer['fourth']['title'];?></dt>
                                <?php
                                foreach ($footer['fourth']['content'] as $key=>$value) {
                                    ?>
                                    <dd><a href="<?php echo LANGPATH.$key; ?>"><?php echo $value; ?></a></dd>
                                    <?php
                                }
                                ?>
                            </dl>
                            <dl>
                                <dt><?php echo $footer['other']['fifth'];?></dt>
                                <dd><img src="<?php echo STATICURL;?>/assets/images/2016/card-0630.jpg"></dd>
                            </dl>
                        </div>
                    </div>              
                </div>
            </div>
            <div class="footer-bottom hidden-xs">
                <p>
                    <a href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=<?php echo URLSTR; ?>&lang=en" target="_blank"><img src="<?php echo STATICURL;?>/assets/images/2016/card-N.jpg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php echo $footer['pc_footer']['© 2006-2016 CHOIES.COM'] ;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo LANGPATH;?>/privacy-security"><?php echo $footer['pc_footer']['PRIVACY POLICY'] ;?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="<?php echo LANGPATH;?>/conditions-of-use"><?php echo $footer['pc_footer']['TERMS & CONDITIONS'] ;?></a>
                </p>
                
            </div>
            <div id="comm100-button-311" class="bt-livechat visible-xs-block hidden-sm hidden-md hidden-lg">
                <a href="#" onclick="openLivechat();return false;" id="livechatLink">
                    <img src="<?php echo STATICURL;?>/assets/images/2016/livechart-1603.png" />
                </a>
            </div>
                <div class="w-top container-fluid visible-xs-block hidden-sm hidden-md hidden-lg xs-mobile">
                    <div class="container">
                        <div class="currency">
                        <div class="row">
                            <div class="currency-con col-xs-12">
                                <form class="object-flags" action="" method="post">
                                    <a class="icon-flag icon-<?php echo strtolower($currency_now['name']); ?>"></a>
                                    <select class="select" id="currencyselect">
                                    <?php
                                    $key = 0;
                                    foreach ($currencies as $currency)
                                    {
                                        if(strpos($currency['code'], '$') !== False)
                                        {
                                            $code = '$';
                                        }
                                        else
                                        {
                                            $code = $currency['code'];
                                        }
                                        ?>
                                        <option value="<?php echo LANGPATH; ?>/currency/set/<?php echo $currency['name'] ?>" <?php if(strtolower($currency_now['name']) == strtolower($currency['name'])){ echo 'selected="selected"';} ?> ><?php echo $currency['fname']; ?>
                                        </option>
                                        <?php
                                        $key ++;
                                    }
                                    ?>
                                    </select>
                                    <script type="text/javascript">
                                        $("#currencyselect").change(function(){  
                                           var redirect = $("#currencyselect").val();
                                           window.location.href = redirect;
                                        })
                                    </script>
                                </form>
                                <form class="object-sites" action="" method="post">
                                    <select class="select" id="langselect">
                                <?php
                                $key = 0;
                                foreach($lang_list as $lang => $path)
                                {
                                    $langhref = $path . $request;
                                    $langname = '/'.LANGUAGE;
                                        ?>
                                        <option value="<?php echo $langhref; ?>" <?php if($langname == $path){ echo 'selected="selected"';} ?>><?php echo $lang; ?>
                                        </option>
                                        <?php
                                }
                                ?>
                                    <script type="text/javascript">
                                        $("#langselect").change(function(){  
                                           var redirect1 = $("#langselect").val();
                                           window.location.href = redirect1;
                                        })
                                    </script>
                                    </select>
                                </form>
                            </div>
                        </div>
                        </div>

                        <div class="fix row">
                            <dl class="col-xs-12  xs-mobile hidden-sm hidden-md hidden-lg">                         
                                <dl class="letter">
                                    <form action="" method="post" id="letter_form1">
                                        <div>
                                            <input id="letter_text1" class="text" value="Sign up for our emails" onblur="if(this.value==''){this.value=this.defaultValue;}" onfocus="if(this.value=='Sign up for our emails'){this.value='';};" type="text">
                                            <input id="letter_btn1" value="Submit" class="btn btn-primary" type="submit">
                                        </div>
                                    </form>
                                </dl>
                                
                                <div class="red" id="letter_message1"></div>
                                <script language="JavaScript">
                                    $(function() {
                                        $("#letter_form1").submit(function() {
                                            var email = $('#letter_text1').val();
                                            if (!email) {
                                                return false;
                                            }
                                            $.post(
                                                '/newsletter/ajax_add', {
                                                    email: email
                                                },
                                                function(data) {
                                                    $("#letter_message1").html(data['message']);
                                                    if (data['success'] == 0) {
                                                        $('#letter_message1').fadeIn(10).delay(3000).fadeOut(10);
                                                    } else {
                                                        $("#letter1").css('display', 'none');
                                                        $("#letter_message1").css('display', 'block');
                                                    }
                                                },
                                                'json'
                                            );
                                            return false;
                                        })
                                    })
                                </script>                        
                            
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert" style="margin-top:30px;">
                                 <dt style="text-transform: capitalize;"><a href="<?php echo LANGPATH;?>/blogger/programme"><?php echo $footer['phone_footer']['BLOGGER']; ?>&nbsp;&nbsp;</a><a href="<?php echo LANGPATH;?>/lookbook"><?php echo $footer['phone_footer']['#LOOKBOOKS']; ?></a>&nbsp;&nbsp;<?php echo $footer['phone_footer']['HERE']; ?></dt>
                            </dl>
                            <dl class="sns">
                                <dt><?php echo $footer['phone_footer']['Connect With Us']; ?></dt>
                                <dd><a href="http://www.facebook.com/choiescloth" target="_blank" class="sns1" title="facebook"></a></dd>
                                <dd><a href="http://twitter.com/#!/choiescloth" target="_blank" class="sns2" title="twitter"></a></dd>
                                <dd><a href="http://style-base.tumblr.com/" target="_blank" class="sns3" title="tumblr"></a></dd>
                                <dd><a href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4" title="youtube"></a></dd>
                                <dd><a href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a></dd>
                                <!--<dd><a href="http://www.chictopia.com/Choies" target="_blank" class="sns6" title="chictopia"></a></dd>-->
                                <dd><a href="http://instagram.com/choiesclothing" target="_blank" class="sns7" title="instagram"></a></dd>
                                <dd><a href="http://choies.studentbeans.com" target="_blank" class="sns10" title="instagram"></a></dd>
                            </dl>
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <dt style="text-transform: capitalize;"><a href="<?php echo LANGPATH;?>/customer/summary"><?php echo $footer['phone_footer']['My Account']; ?>&nbsp;&bull;</a><a href="<?php echo LANGPATH;?>/tracks/track_order">&nbsp;<?php echo $footer['phone_footer']['Track Order']; ?>&nbsp;&bull;</a><a href="<?php echo LANGPATH;?>/customer/orders">&nbsp;<?php echo $footer['phone_footer']['Order History']; ?></a></dt>
                            </dl>
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <dd><a href="<?php echo LANGPATH;?>/about-us" style="color:#444;"><?php echo $footer['phone_footer']['About Us']; ?>&nbsp;&bull;</a><a href="<?php echo LANGPATH;?>/vip-policy" style="color:#444;">&nbsp;<?php echo $footer['phone_footer']['Membership']; ?>&nbsp;&bull;</a><a href="<?php echo LANGPATH;?>/contact-us" style="color:#444;">&nbsp;<?php echo $footer['phone_footer']['Contact Us']; ?>&nbsp;</a></dd>
                            </dl>                            
                        </div>
                        <div class="copyright visible-xs-block hidden-sm hidden-md hidden-lg">
                            <p><?php echo $footer['phone_footer']['Copyright © 2006-2016 Choies.com']; ?> </p>
                            <p class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <a href="<?php echo LANGPATH;?>/conditions-of-use">&nbsp;<?php echo $footer['phone_footer']['Terms & Conditions']; ?>&nbsp;&bull;</a><a href="<?php echo LANGPATH;?>/privacy-security">&nbsp;<?php echo $footer['phone_footer']['Privacy Policy']; ?></a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
</div>
            <div id="comm100-button-311" class="home-right-icons hidden-xs">
                <a href="#" onclick="openLivechat();return false;"><span class="live-chat-icon"></span></a>
                <a href="<?php echo LANGPATH;?>/contact-us"><span class="email-us-icon"></span></a>
            </div>
            <div id="gotop" class="hide ">
                <a href="#" class="xs-mobile-top"></a>
            </div>
            <div id="gotop" class="hide ">
                <a href="#" class="xs-mobile-top"></a>
            </div>
            <script type="text/javascript">
                $(function(){
                    $(".getfeed1").click(function(){
                        $("#tijiao").show();
                        $("#think1").hide();
                    })
                    $("#feedbackForm").submit(function(){
                        var email1 = $('#f_email1').val();
                        var what_like = $("#what_like").val();
                        var do_better = $("#do_better").val();
                        var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
                        if(!reg.test(email1)) {
                            return false;
                        }
                        if(email1==''){
                            return false;
                        }
                        if(do_better=='' || do_better.length < 5){
                            return false;
                        }
                        
                        $.post(
                        '/review/ajax_feedback',
                        {
                            email1: email1,
                            what_like: what_like,
                            do_better: do_better
                        },
                        function(data)
                        {
                            
                            $("#f_email1").val("");
                            $('#what_like').val("");
                            $('#do_better').val("");
                            $("#tijiao").hide();
                            $("#think1").show();
                            if(data['success'] == 0)
                            {
                                $("#think1 .failed1").show();
                                $("#think1 .failed1 p").html(data['message']);
                                $("#think1 .success1").hide();
                                $("#wingray3").remove();
                                $(".reveal-modal-bg").fadeOut();
                            }
                            else if(data['success'] == -1)
                            {
                                $("#think1 .failed1").show();
                                $("#think1 .failed1 p").html(data['message']);
                                $("#think1 .success1").hide();
                                $("#wingray3").remove();
                                $(".reveal-modal-bg").fadeOut();
                                
                            }else if(data['success'] == -2)
                            {
                                
                                $("#think1 .success1").show();
                                $("#think1 .failed1").hide();
                                $("#wingray3").remove();
                                $(".reveal-modal-bg").fadeOut();
                                
                            }
                            else if(data['success'] == 1)
                            {
                                
                                $("#think1 .success1").show();
                                $("#think1 .failed1").hide();
                                //$("#think1 .failed1 p").html(data['message']);
                                $("#wingray3").remove();
                                $(".reveal-modal-bg").fadeOut();
                            }
                            
                        },
                        'json'
                    );
                        return false;
                    })
                    
                    $("#problemForm").submit(function(){
                        var comment = $("#f_comment").val();
                        var email2 = $('#f_email2').val();
                        var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
                        if(!reg.test(email2)) {
                            return false;
                        }
                        if(comment=='' || comment.length < 5){
                            return false;
                        }
                        if(email2==''){
                            return false;
                        }
                        $.ajax({
                        type: "POST",
                        url: "/review/ajax_feedback",
                        dataType: "json",
                        data: {comment:comment,email2:email2},
                        success: function(data){
                            //$("#myModal9").show();
                            $("#f_comment").val("");
                            $('#f_email2').val("");
                            $("#tijiao").hide();
                            $("#think1").show();
                            console.log(data['success']);
                             if(data['success'] == 0)
                            {
                                $("#think1 .failed1").show();
                                $("#think1 .failed1 p").html(data['message']);
                                $("#think1 .success1").hide();
                                $("#wingray3").remove();
                                $(".reveal-modal-bg").fadeOut();
                            }
                            else if(data['success'] == -1)
                            {
                                $("#think1 .failed1").show();
                                $("#think1 .failed1 p").html(data['message']);
                                $("#think1 .success1").hide();
                                $("#wingray3").remove();
                                $(".reveal-modal-bg").fadeOut();
                                
                            }else if(data['success'] == -2)
                            {
                                $("#think1 .success1").show();
                                $("#think1 .failed1").hide();
                                $("#wingray3").remove();
                                $(".reveal-modal-bg").fadeOut();
                                
                            }
                            else if(data['success'] == 1)
                            {
                                
                                $("#think1 .success1").show();
                                $("#think1 .failed1").hide();
                                $("#wingray3").remove();
                                $(".reveal-modal-bg").fadeOut();
                            }
                        }
                    });
                    return false;
                    })
                })
                                
            </script>

<div id="myModal8" class="reveal-modal large feedback" kai="kai">
    
        <a class="close-reveal-modal close-btn3"></a>
        <div id="tijiao">
                <div class="feedback-title">
                    <div class="fll text1">CHOIES WANT TO HEAR YOUR VOICE!</div>
                </div>
                <div class="clearfix"></div>
                <div class="point ml15 mt5">
                    Those who provide significant feedbacks can get 
                    <strong class="red">$5 Points</strong> Reward.
                </div>
                <div class="feedtab">
                    <ul class="feedtab-nav JS-tab1">
                        <li class="current">FEEDBACK</li>
                        <li class="">PROBLEM?</li>
                    </ul>
                    <div class="feedtab-con JS-tabcon1">
                        <div class="bd">
                            <form id="feedbackForm" method="post" action="#" class="form formArea">
                                <ul>
                                    <li>
                                        <label for="My Suggestion:">Choies,this is what I like: </label>
                                        <textarea name="what_like" id="what_like" rows="3" class="input textarea"></textarea>
                                    </li>
                                    <li>
                                        <label for="My Suggestion:"><span>*</span> Choies,I think you can do better: <span class="errorInfo clear hide">Please write something here.</span></label>
                                        <textarea name="do_better" id="do_better" rows="5" class="input textarea"></textarea>
                                    </li>
                                    <li>
                                        <label for="Email Address:"><span>*</span> Email Address:<span class="errorInfo clear hide">Please enter your email.</span>
                                        </label>
                                        <input type="text" name="email" id="f_email1" class="text text-long" value="" maxlength="340">
                                    </li>
                                    <li>
                                        <input type="submit" class="btn btn-primary btn-lg" value="SUBMIT"></li>
                                    </li>
                                </ul>
                            </form>
                            <script>
                                $("#feedbackForm").validate({
                                    rules: {
                                        email: {
                                            required: true,
                                            email: true
                                        },
                                        do_better: {
                                            required: true,
                                            minlength: 5
                                        }
                                    },
                                    messages: {
                                        email:{
                                            required:"Please provide an email.",
                                            email:"Please enter a valid email address."
                                        },
                                        do_better: {
                                            required:"This field is required.",
                                            minlength: "Please enter at least 5 characters."
                                        }
                                    }
                                });
                            </script>
                        </div>
                        <div class="bd hide">
                            <form id="problemForm" method="post" action="#" class="form formArea">
                                <ul>
                                    <li>
                                        <label><span>*</span> Need help? Please describe the problem: <span class="errorInfo clear hide">Please write something here.</span></label>
                                        <textarea name="comment" id="f_comment" rows="7" class="input textarea"></textarea>
                                    </li>
                                    <li>
                                        <label><span>*</span> Email Address:<span class="errorInfo clear hide">Please enter your email.</span><br>
                                        </label>
                                        <input type="text" name="email1" id="f_email2" class="text text-long" value="" maxlength="340">
                                    </li>
                                    <li>
                                        <input type="submit" data-reveal-id="myModal9" class="btn btn-primary btn-lg" value="SUBMIT"></li>
                                    </li>
                                </ul>
                            </form>
                            <script>
                                $("#problemForm").validate({
                                    rules: {
                                        email1: {
                                            required: true,
                                            email: true
                                        },
                                        comment: {
                                            required: true,
                                            minlength: 5
                                        }
                                    },
                                    messages: {
                                        email1:{
                                            required:"Please provide an email.",
                                            email:"Please enter a valid email address."
                                        },
                                        comment: {
                                            required:"This field is required.",
                                            minlength: "Please enter at least 5 characters."
                                        }
                                    }
                                });
                            </script>
                             <p class="mt10">More detailed questions? Please <a href="https://chatserver.comm100.com/chatwindow.aspx?planId=311&amp;siteId=203306" title="contact us" target="_blank">contact us</a>.</p>
                        </div>
                    </div>
                </div>
                </div>
                <div id="think1" style="display:none">
                <div class="success1">
                    <h3>THANK YOU !</h3>
                    <p><em>Your feedback has been received !</em></p>
                </div>
                <div class="failed1">
                    <h3>Sorry!</h3>
                    <p></p>
                </div>
            </div>
            </div>
            <?php
            }
            ?>
        </div>
        <script src="<?php echo Site::instance()->version_file('/assets/js/common.js'); ?>"></script>
        <script src="<?php echo Site::instance()->version_file('/assets/js/slider.js'); ?>"></script>
        <script src="<?php echo Site::instance()->version_file('/assets/js/flickity-docs.min.js'); ?>"></script>
        <?php
            if ($type == 'purchase')
            {
        ?>
        <script src="<?php echo Site::instance()->version_file('/assets/js/jquery.reveal-1.js'); ?>"></script>
        <?php 
            } 
        ?>

        <script type="text/javascript">
            $(function(){
                //cart ajax
                ajax_cart();
                $('.currency_select').change(function(){
                    var currency = $(this).val();
                    location.href = '/currency/set/' + currency;
                    return false;
                })
                //recent view
                // $.ajax({
                //     type: "POST",
                //     url: "/site/ajax_recent_view",
                //     dataType: "json",
                //     data: "",
                //     success: function(msg){
                //         $("#recent_view ul").html(msg);
                //     }
                // });
            })

            function ajax_cart()
            {
                $.ajax({
                    type: "POST",
                    url: "/cart/ajax_cart",
                    dataType: "json",
                    data: "",
                    success: function(msg){
                        if(msg['count'] > 0)
                        {
                            $(".cart_count").text(msg['count']);
                            if(msg['count'] > 1)
                                $(".cart_s").html('s');
                            else
                                $(".cart_s").html('');
                            $(".cart-all-goods").show();
                            $(".cart_bag").html(msg['cart_view']);
                            if(msg['sale_words'])
                            {
                                $(".sale_words").show();
                                $(".sale_words").html(msg['sale_words']);
                                $(".free_shipping").hide();
                            }
                            else if(msg['free_shipping'])
                            {
                                $(".free_shipping").show();
                                $(".sale_words").hide();
                            }else{
                                $(".free_shipping").hide();
                                $(".sale_words").hide();
                            }
                            $(".cart_amount").html(msg['cart_amount']);
                            $(".items").show();
                            $(".cart_bag").show();
                            $(".cart_bag_empty").hide();
                            $(".cart_button").show();
                            $(".cart_button_empty").hide();
                        }
                        else
                        {
                            $(".free-shipping").hide();
                            $(".cart_bag_empty").show();
                            $(".items").hide();
                            $(".cart_bag").hide();
                            $(".cart_button_empty").show();
                            $(".cart_button").hide();
                            $(".cart-all-goods").hide();
                        }
                    }
                });
            }
        </script>

        <div style="display:none;">
            <!-- New Remarket Code -->
            <?php
            if (!$type)
            {
                ?>
                <script type="text/javascript">
                    var google_tag_params = {
                        ecomm_prodid: '',
                        ecomm_pagetype: 'other',
                        ecomm_totalvalue: ''
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
            }
            elseif (in_array($type, array('cart','category','home','purchase', 'cart_view')))
            {
                if($type == 'cart_view'){
                    $type = 'cart';
                }
                $arr=cart::get();
                    foreach ($arr['products'] as $value) {
                        $id[]=$value['id'];
                    }
                $cart_save = 0;
                    if ($cart['amount']['save'])
                    {
                        if (isset($cart['promotion_logs']['cart']))
                        {
                            foreach ($cart['promotion_logs']['cart'] as $p_cart)
                            {
                                if (isset($p_cart['save']))
                                {
                                    $cart_save += $p_cart['save'];
                                }
                            }
                        }
                    }            
                    $totalprice=$cart['amount']['items'] - $cart_save;                    
                ?>
                <script type="text/javascript">
                    var google_tag_params = {
                        ecomm_prodid: <?php $n=1; if(isset($id)){?>[<?php foreach ($id as $key => $value) { if($n!=1){echo ',';};$n++;?>"<?php  echo Product::instance($value)->get('sku');?>"<?php }?>]<?php }else{?>''<?php }?>,
                        ecomm_pagetype: '<?php echo $type; ?>',
                        ecomm_totalvalue: <?php if(isset($arr['amount']['items']) && !empty($arr['amount']['items'])){?><?php echo $totalprice;?><?php }else{?>''<?php }?>
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
            }
            ?>
                
            <?php 
            if($user_id)
            {
                $user_session = Session::instance()->get('user');
                $email = $user_session['email'];
            }
             ?>
            <!-- HK ScarabQueue statistics Code -->

            <!-- GA get user email -->
            <script>
            var dataLayer = window.dataLayer = window.dataLayer || [];
            dataLayer.push({'userID': '<?php if($user_session['email']){ echo $user_session['email'];}else{ echo "";}?>'});
            </script>
            <!-- GA get user email -->

        </div>
        <?php 
        $usermark = Kohana_Cookie::get('usermark');
        $usermark123 = Kohana_Cookie::get('usermark123');
        $utm_medium = Arr::get($_GET, 'utm_medium');
        $user_fb = Session::instance()->get('user_fb',0); 
        $fb_cookies = Session::instance()->get('fb_cookies',0);
        $code  = Arr::get($_GET, 'code',''); 
        $fb_loginpage = Session::instance()->get('fb_loginpage',0);
        if(($user_fb && empty($fb_loginpage)) or (!$usermark && !$usermark123 && $utm_medium != 'edmwp')){
        ?>
        <!-- register -->    
        <div id="gift-modal-fb" class="reveal-modal JS-popwincon1 hidden-xs" style="border-radius:0;display:none;visibility:visible;background:#fff;" >
            <a class="close-reveal-modal close-btn3 JS-close2"></a>
            <div class="register-left"></div>
            <div class="register-right">
                <p style="margin-top:110px;line-height:30px;">Sorry but you have already registered with this facebook account.</p>
            </div>
        </div>

        <div id="gift-modal-fb-phone" class="register-gift-phone JS-popwincon1 hidden-sm hidden-md hidden-lg" style="border-radius:0;display:none;visibility:visible;background:#fff;">
            <a class="close-reveal-modal close-btn3 JS-close2"></a>
            <div class="register-right">
                <p style="margin-top:90px;line-height:30px;">Sorry but you have already registered with this facebook account.</p>
            </div>
        </div>

        <div id="register-modal" class="reveal-modal register-gift JS-popwincon1  hidden-xs regfreehide" style="border-radius:0;" >
            <a class="close-reveal-modal close-btn3 JS-close2"></a>
            <div class="register-left"></div>
            <div class="register-right">
                <h3>Register to win</h3> 
                <p>Join in Choies now to have <span class="red">100%</span> Chance to <span class="red">win a free gift</span>.</p>
                <form class="register-form" action="#" method="post">
                    <label><i>* Email</i></label>
                    <input id="register-gift-email" type="text" class="register-gift-text valuemail" placeholder="Your email" name="email" value=""/><br/>
                    <b id="message" style="color:#cc3300;margin-top:10px"></b>
                    <input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" type="submit" id="register-get" value="GET" onclick="return loading1();">
                </form>
                <?php
                $redirect = Arr::get($_GET, 'redirect', '');
                $page = isset($_SERVER['HTTP_SELF']) ? BASEURL . $_SERVER['HTTP_SELF'] . '/' . htmlspecialchars($redirect) : BASEURL . '/' . htmlspecialchars($redirect);
                $facebook = new facebook();
                $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                ?>
                <a href="<?php echo $loginUrl;?>" class="register-gift-btn" onclick="return setcookiefb();">sign in with facebook</a>
                <p class="gift-no"><a class="JS-close2">No,Thanks. I’d like to follow my own way!</a></p>
            </div>
        </div>

        <!--  -->
        <div id="register-modal-phone" class="register-gift-phone JS-popwincon1 hidden-sm hidden-md hidden-lg regfreehide" style="border-radius:0;">
            <a class="close-reveal-modal close-btn3 JS-close2"></a>
            <div class="register-right">
                <h3>Register to win</h3>
                <p>Join in Choies now to have <span class="red">100%</span> Chance to <span class="red">win a free gift</span>.</p>
                <form class="register-form-phone" action="#" method="post">
                    <label><i>* Email</i></label>
                    <input type="text" class="register-gift-text valuemail" placeholder="Your email" name="email" value="">
                    <input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" id="register-get" type="submit" value="GET" onclick="return loading1();">
                </form>
                <?php
                $redirect = Arr::get($_GET, 'redirect', '');
                $page = isset($_SERVER['HTTP_SELF']) ? BASEURL . $_SERVER['HTTP_SELF'] . '/' . htmlspecialchars($redirect) : BASEURL . '/' . htmlspecialchars($redirect);
                $facebook = new facebook();
                $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                ?>
                <a href="<?php echo $loginUrl;?>" class="register-gift-btn" onclick="return setcookiefb();">sign in with facebook</a>
                <p class="gift-no"><a class="JS-close2">No,Thanks. I’d like to follow my own way!</a></p>
            </div>
        </div>

        <!-- 输入密码部分 -->
        <div id="gift-modal" class="reveal-modal register-gift register-gift-2 JS-popwincon1 hidden-xs regfreeshow" style="border-radius:0;display:none;">
            <a class="close-reveal-modal close-btn3 JS-close2"></a>
            <div class="img-left">
                <ul>
                    <?php 
                        $isfb = 0;
                    if(Site::instance()->get('fb_login'))
                    {
                        $isfb = 1;
                    }
                    $free = Site::instance()->registergift();
                    if($free)
                    {
                        foreach ($free as $key => $value)
                        {
                            $product_instance = Product::instance($value['id']);
                            $img = $product_instance->cover_image();
                            $product_img = Image::link($img, 7);
                            ?>
                            <li class="<?php if($key==0){echo 'select';}else echo 'mt10'; ?> select<?php echo $value['id'];?>" data-id="<?php echo $value['id'];?>-<?php echo $value['type'];?>"><div class="img-select <?php if($key==1){echo 'hide';} ?>"><img src="<?php echo STATICURL; ?>/assets/images/gift-select.png" alt=""></div><img src="<?php echo $product_img;?>" alt=""><p><span class="red"><?php echo Site::instance()->price(0, 'code_view'); ?>&nbsp;&nbsp;</span><span><del><?php echo round($value['price'],2);?></del></span></p></li>
                            <!--<li class="mt10"><div class="img-select hide"><img src="/assets/images/gift-select.png" alt=""></div><img src="/assets/images/SHOE1215A461B.jpg" alt=""><p><span class="red">$0.00&nbsp;&nbsp;</span><span><del>$9.99</del></span></p></li>-->
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            <script>
                <?php 
                    $giftarr = Site::giftsku(); 
                ?>
                var product_id = $(".select<?php echo $giftarr[0];?>").attr("data-id");//产品id
                $("#gift-modal").find("li").click(function(){
                    product_id = $(this).attr("data-id");//选中赋忿
                    $(this).addClass("select").children("div").removeClass("hide");
                    $(this).siblings().removeClass("select").children("div").addClass("hide");
                })
            </script>
            <div class="register-right">
                <h2>free gifts</h2>
                <h4>for the New Comer!</h4>
                <p class="mt20">Please choose one of the items and set your password below.</p>
                <form class="mt20 gift-form" action="#" method="post">
                    <?php if(!$user_fb){ ?>
                    <label><i>* password</i></label>
                    <input type="password" class="register-gift-text userpwd" placeholder="6-24characters" name="password" value="">
                    <?php } ?>
                    <input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" id="register-apply" type="submit" value="APPLY" onclick="return loading2();">
                </form>
            </div>
        </div>

        <!-- PHONE -->
        <div id="gift-modal-phone" class="reveal-modal register-gift register-gift-2-phone JS-popwincon1 hidden-sm hidden-md hidden-lg" style="border-radius:0;display:none">
            <a class="close-reveal-modal close-btn3 JS-close2"></a>
            <div class="register-right" style="margin-top:0;padding:0;padding-top:20px;">
                <h2>free gifts</h2>
                <h4>for the New Comer!</h4>
                <p class="mt20">Please choose one of the items and set your password below.</p>
                <ul style="margin-top:2px;">
                    <?php 
                        //$free = DB::query(Database::SELECT, 'select * from products where sku in("SA0843", "BA0844") order by id desc')->execute()->as_array();
                        $free = Site::instance()->registergift();
                        if($free){
                            //var_dump($free);
                            foreach ($free as $key => $value) {
                                $product_instance = Product::instance($value['id']);
                                $img = $product_instance->cover_image();
                                $product_img = Image::link($img, 7);
                    ?>
                    <li style="margin-top:-0.1px;" class="<?php if($key==0){echo ' select';}else echo 'mt10';?>  select<?php echo $value['id'];?>" 
                    data-id="<?php echo $value['id'];?>-<?php echo $value['type'];?>">
                    <div class="img-select<?php if($key==1){echo ' hide';} ?>">
                    <img src="<?php echo STATICURL; ?>/assets/images/gift-select.png" alt="">
                    </div>
                    <img src="<?php echo $product_img;?>" alt="">
                    <p><span class="red"><?php echo Site::instance()->price(0, 'code_view'); ?>&nbsp;&nbsp;</span><span><del><?php echo round($value['price'],2);?></del></span></p>
                    </li>
                    <!--<li class="mt10"><div class="img-select hide"><img src="/assets/images/gift-select.png" alt=""></div><img src="/assets/images/SHOE1215A461B.jpg" alt=""><p><span class="red">$0.00&nbsp;&nbsp;</span><span><del>$9.99</del></span></p></li>-->
                    <?php }}?>
                </ul>
                <script>
                $("#gift-modal-phone").find("li").click(function(){
                    product_id = $(this).attr("data-id");
                    $(this).addClass("select").children("div").removeClass("hide");
                    $(this).siblings().removeClass("select").children("div").addClass("hide");
                })
                </script>
                <form class="mt20 gift-form-phone" action="#" method="post">
                    <?php if(!$user_fb){ ?>
                    <label><i>* password</i></label>
                    <input type="password" class="register-gift-text userpwd" placeholder="6-24characters" name="password" value="">
                    <?php } ?>
                    <input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" id="register-apply" type="submit" value="APPLY" onclick="return loading2();">
                </form>
            </div>
        </div>
        
        <div class="reveal-modal-bg JS-filter1" style="display: block;"></div>
        <!-- 注册有礼结束 -->
        <?php }?>
        <?php Kohana_Cookie::set("usermark123",'user',3600*96);?>
        <script>
            function setcookiefb()
            {
              <?php  Session::instance()->set('fb_cookies',5); 
              $aaa = Session::instance()->get('fb_cookies',0); 
              $fb_loginpage = Session::instance()->get('fb_loginpage',0);
                ?>
            }
                <?php $code  = Arr::get($_GET, 'code',''); 
                if($code && empty($fb_loginpage)){  ?>   
                    $(function(){      
                        gofb(<?php echo $fb_cookies; ?>);       
                        })
                    <?php } ?>

            function gofb(ace)
            { 
               <?php  
                $user_fb = Session::instance()->get('user_fb',0);
                if($user_id && !empty($user_fb) && !empty($aaa))
                {

                    if($user_fb >1)
                    { 
                ?>   
                        var ac = $("p.mt20");
                        ac.html('');
                        ac.html('Please choose one of the items and APPLY.');
                        $("#gift-modal").fadeIn();
                        $("#gift-modal-phone").fadeIn();
                        $(".reveal-modal-bg").fadeIn(); 
                        $("#register-modal-phone").hide();
                        $("#register-modal").hide();          
                <?php }else{ ?>               
                        $("#gift-modal").fadeOut();
                        $("#gift-modal-fb").show();
                        $("#gift-modal-fb-phone").show();
                        $("#register-modal-phone").hide();
                        $("#register-modal").hide();                   
                        $(".reveal-modal-bg").fadeIn();
            <?php    }
                } ?>
            }


            function loading2()  
            {
                ga('send', 'event', 'register for gift', 'click', 'apply');
                <?php  
                    $user_fb = Session::instance()->get('user_fb',0); 
                    //fb 客户登陆
                    if(!empty($user_fb))
                    { ?>      
                        showfb();
                    <?php }else{ ?>
                        shownofb();
                <?php } ?>
            }
            function loading1()  
            {
                ga('send', 'event', 'register for gift', 'click', 'get');
            }
            
            var globalemail = '';
            $(".register-form").validate({
                rules: {
                    email: {    
                        required: true,
                        email: true
                    }   
                },
                messages: {
                    email: {
                        required: "Please enter your email address.",
                        email:"Please enter a valid email address."
                    }
                },
                submitHandler: function(form) {  
                    //Check user email
                    var valuemail = $(".register-form").find(".valuemail").val();
                    $.post('/cart/ajax_chkuser', {email:valuemail}, function(re){
                        if(re == "isset"){
                            alert("Sorry,The mailbox you entered is already there!");
                            return false;
                        }else if(re == "emailerror"){
                            alert("Please enter a valid email address.");
                            return false;
                        }else{
                            globalemail = valuemail;
                            $("#message").hide();
                            $(".regfreehide").fadeOut("fast",function(){
                                $(".regfreeshow").fadeIn();
                            });
                        }
                    })
                }    
            });
            $(".register-form-phone").validate({
                rules: {
                    email: {    
                        required: true,
                        email: true
                    }   
                },
                messages: {
                    email: {
                        required: "Please enter your email address.",
                        email:"Please enter a valid email address."
                    }            
                },
                submitHandler: function(form) {       

                    //Check user email
                    var valuemail = $(".register-form-phone").find(".valuemail").val();
                    $.post('/cart/ajax_chkuser', {email:valuemail}, function(re){
                        if(re == "isset"){
                            alert("Sorry,The mailbox you entered is already there!");
                            return false;
                        }else if(re == "emailerror"){
                            alert("Please enter a valid email address.");
                            return false;
                        }else{
                            globalemail = valuemail;
                            $("#message").hide();
                            $("#register-modal-phone").fadeOut("fast",function(){
                                $("#gift-modal-phone").fadeIn();
                            });
                        }
                    })
                }            
            });

            function shownofb()
            {
                <?php Session::instance()->delete('user_fb'); ?>
             $(".gift-form").validate({
                rules: {
                     password: {
                            required: true,
                            minlength: 6,
                            maxlength:24
                    }
                },
                messages: {
                    password: {
                            required: "Please provide a password.",
                            minlength: "Password should between 6-24 characters.",
                            maxlength: "Password should between 6-24 characters."
                    }
                },
                submitHandler: function(form) {       
                    var userpwd = $(".gift-form").find(".userpwd").val();
                    var proid = product_id;
                    var data = {
                        email:globalemail,
                        password:userpwd,
                        product_id:proid
                    };
                    ////Add user / Add cart
                    $.post('/cart/ajax_user_add', data, function(re){
                        if(re == "success"){
                            ajax_cart();
                            var str="";
                             str +="<li class='drop-down cs-show'>";
                             str +="<div class='drop-down-hd'>";
                             str +="<i class='myaccount'></i>";
                             str +="<span>Hello, Choieser!</span>";
                             str +="</div>";
                             str +="<dl class='drop-down-list cs-list' >";
                             str +="<dd class='drop-down-option'>";
                             str +="<a href='/customer/summary'>My Account</a>";
                             str +="</dd>";
                             str +="<dd class='drop-down-option'>";
                             str +="<a href='/customer/orders'>My Order</a>";
                             str +="</dd>";
                             str +="<dd class='drop-down-option'>";
                             str +="<a href='/tracks/track_order'>Track Order</a>";
                             str +="</dd>";
                             str +="<dd class='drop-down-option'>";
                             str +="<a href='/customer/wishlist'>My Wishlist</a>";
                             str +="</dd>";
                             str +="<dd class='drop-down-option'>";
                             str +="<a href='/customer/profile'>My Profile</a>";
                             str +="</dd>";
                             str +="<dd class='drop-down-option'>";
                             str +="<a href='/customer/logout'>Sign Out</a>";
                             str +="</dd></dl></li>";
                            $("#add_wishlist").html(str);
                            $(".JS-popwincon1,.reveal-modal-bg").fadeOut("fast",function(){
                                if($("#mybag-box").is(":hidden")){
                                    $("#mybag-box").fadeIn();
                                    setTimeout("$('#mybag-box').fadeOut();", 2000);
                                }else{
                                    setTimeout("$('#mybag-box').fadeOut();", 2000);
                                }
                            });
                        }else{
                            //alert(re);
                            return false;
                        }
                    })
                }   
            });
              $(".gift-form-phone").validate({
                rules: {
                     password: {
                            required: true,
                            minlength: 6,
                            maxlength:24
                        }
                },
                messages: {
                    password: {
                            required: "Please provide a password.",
                            minlength: "Password should between 6-24 characters.",
                            maxlength: "Password should between 6-24 characters."
                     }
                },
                submitHandler: function(form) {       
                    var userpwd = $(".gift-form-phone").find(".userpwd").val();
                    var proid = product_id;
                    var data = {
                        email:globalemail,
                        password:userpwd,
                        product_id:proid
                    };
                    //Add user / Add cart
                    $.post('/cart/ajax_user_add', data, function(re){
                        if(re == "success"){
                            ajax_cart();
                            $("#help").empty().html("<span titile='Choieser'>Hello, Choieser !</span>");
                            $(".JS-popwincon1,.reveal-modal-bg").fadeOut("fast",function(){
                                window.location.href="/cart/view";
                            });
                        }else{ 
                            //alert(re);
                            return false;
                        }
                    })
                }   
            });
        }

            function showfb()
            {
                <?php Session::instance()->delete('user_fb'); ?>
                    var proid = product_id;
                    var data = {
                        product_id:proid
                    };    
                        $.post('/cart/fbuser_add', data, function(re){
                            if(re == "success"){
                                ajax_cart();
                                var str="";
                                 str +="<li class='drop-down cs-show'>";
                                 str +="<div class='drop-down-hd'>";
                                 str +="<i class='myaccount'></i>";
                                 str +="<span>Hello, Choieser!</span>";
                                 str +="</div>";
                                 str +="<dl class='drop-down-list cs-list'>";
                                 str +="<dd class='drop-down-option'>";
                                 str +="<a href='/customer/summary'>My Account</a>";
                                 str +="</dd>";
                                 str +="<dd class='drop-down-option'>";
                                 str +="<a href='/customer/orders'>My Order</a>";
                                 str +="</dd>";
                                 str +="<dd class='drop-down-option'>";
                                 str +="<a href='/tracks/track_order'>Track Order</a>";
                                 str +="</dd>";
                                 str +="<dd class='drop-down-option'>";
                                 str +="<a href='/customer/wishlist'>My Wishlist</a>";
                                 str +="</dd>";
                                 str +="<dd class='drop-down-option'>";
                                 str +="<a href='/customer/profile'>My Profile</a>";
                                 str +="</dd>";
                                 str +="<dd class='drop-down-option'>";
                                 str +="<a href='/customer/logout'>Sign Out</a>";
                                 str +="</dd></dl></li>";
                                $("#add_wishlist").html(str);
                                $(".JS-popwincon1,.reveal-modal-bg").fadeOut("fast",function(){
                                    <?php if($tem_mobile){ ?>
                                    window.location.href="<?php echo LANGPATH; ?>/cart/view"; 
                                        <?php } ?>
                                    $("#mybag1").find(".mybag-box").css({"margin-top":"20px"}).fadeIn();
                                    setTimeout("$('#mybag1').find('.mybag-box').fadeOut();", 2000);

                                });
                            }else{ 
                                alert(re);
                                return false;
                            }
                        }) 
                }

            function openLivechat()
            {
                var href = 'https://chatserver.comm100.com/chatwindow.aspx?planId=311&siteId=203306';

                lleft=screen.width/2-285;
                if($.browser.msie)
                {
                    ttop=window.screenTop;
                }
                else
                { 
                    ttop=$.browser.opera ==true ? 25 :  (window.screen.availHeight  - document.documentElement.clientHeight + (window.status.length>0 ? -25 : 0));
                }
                var newwin=window.open(href,"","toolbar=1,location=1,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,top="+ttop+",left="+lleft+",width=520,height=425");
            }

        $(function(){
            load_customer_login();
        })
        //用户登录信息ajax加载 --- wanglong 2015-12-16
        function load_customer_login()
        {
            $.ajax({
                type: "POST",
                url: "/ajax/customer_login_data",
                dataType: "json",
                data: "",
                success: function(res){
                    if(res['logged_in'])
                    {
                        $("#customer_sign_in").hide();
                        $("#customer_signed").show();
                        $("#customer_signed #username").html(res['firstname']);
                        $("#customer_data").attr("class","drop-down cs-show");
                    }
                   
                }
            });
        }
        //用户登录信息ajax加载 --- wanglong 2015-12-16


        </script>
    </body>
</html>