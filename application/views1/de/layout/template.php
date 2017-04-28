<!DOCTYPE html>
<html xml:lang="<?php echo LANGUAGE; ?>">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" id="viewport" name="viewport">
        <title><?php echo isset($head_footer['head_first']) ? $head_footer['head_first'] : $title; ?></title>
        <meta name="keywords" content="<?php echo $keywords; ?>" />
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
            if (0)
            {
                ?>
            <!-- Criteo Code For Home Page -->
                <?php

        $user_session = Session::instance()->get('user');
                ?>
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
                    { event: "viewHome" },

                    { event: "flushEvents"},

                    { event: "setAccount", account: 23688 }, 
                    { event: "setHashedEmail", email: "<?php echo !empty($user_session['email'])? md5($user_session['email']):' '; ?>" },
                    { event: "setSiteType", type: m },
                    { event: "viewHome" },

                    { event: "flushEvents"}                     
                    
                );
            </script>
            <?php

            }
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
window._fbq.push(['track', '6030050638844', {'value':'<?php echo $amoutprice ?>','currency':'USD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6030050638844&amp;cd[value]=<?php echo $amoutprice; ?>&amp;cd[currency]=USD&amp;noscript=1" /></noscript>

                <?php
        }
        ?>  

        <meta name="p:domain_verify" content="88ba17a98aaa59c3d8a3cb6728db8377"/>

        <!-- GA code -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            
            ga('create', 'UA-32176633-1', 'choies.com', {'siteSpeedSampleRate': 20});
            ga('require', 'displayfeatures');
            <?php
            if ($type !='404page' && $type !='docpage')
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

            function showga(a,b)
            {

                var clickLink = document.getElementById(a);
                addListener(clickLink, 'click', function() {
          ga('send', 'event', a, 'click', b);
});
            }

            function addListener(element, type, callback) {
             if (element.addEventListener) element.addEventListener(type, callback);
             else if (element.attachEvent) element.attachEvent('on' + type, callback);
            }
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
        <div class="page">
            <!-- header begin -->
            <?php
            if ($type != 'payment' && $type != 'purchase' && $type != 'cart')
            {
            ?>
            <header id="pc-header" class="site-header hidden-xs">
            <div class="top-ad JS-popwincon1">
                <div style="width:100%;background-color:#000;">
                    <!-- 16.03.10 去掉banner
                    <a class="JS-close2 close-btn2" style="top:0;right:5px;z-index:5;"></a>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 hidden-xs">
                            <a href="<?php //echo LANGPATH;?>/happy-womens-day-c-1070?hp0302"><img src="<?php //echo STATICURL;?>/assets/images/1602/top-ad-1.jpg" class="<?php echo LANGUAGE;?>_top_banner"></a>
                            </div>
                        
                        </div>
                        
                    </div>-->
                </div>
                <div style="width:100%;background-color:#fff; height:10px;">
                </div>           
            </div>
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
                                    /*
                                    $request = rawurlencode($request);
                                     */
                                    $request = substr($request, strlen(LANGPATH));
                                    if(!$request)
                                        $request = '/';
                                    elseif(strpos($request, '?') === 0)
                                        $request = '/' . $request;
                                    ?>
                                    <div class="drop-down-hd">
                                    <?php
                                        if(in_array(LANGPATH, $lang_list))
                                        {
                                            echo array_search(LANGPATH, $lang_list);
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
                                        if ($lang == "Deutsch" || $lang=="Русский")
                                        {
                                        }
                                        else
                                        {
                                     ?>
                                        <li class="drop-down-option">
                                            <a href="<?php echo $path . $request; ?>"><?php echo $lang; ?></a>
                                        </li>
                                    <?php
                                        }
                                    }
                                    ?>                                    
                                    </ul>
                                </div>                          
                            </div>
                        <div class="col-xs-2 col-md-2 col-lg-4 n-logo">
                            <a href="<?php echo LANGPATH; ?>/" title="choies"><img src="<?php echo STATICURL;?>/assets/images/2016/logo.png"></a>
                        </div>
                        <div class="col-xs-5 col-md-4 col-md-offset-1 col-lg-4 col-lg-offset-0">
                            <div class="n-search fll">
                                <form action="<?php echo LANGPATH; ?>/search" method="get" id="search_form" onsubmit="return search(this);">
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
                                        <p class="title"><strong class="cart_count">0</strong><span class="cart_s"></span> Artikel in Ihrer Einkaufstasche</p>
                                        <div class="items">
                                            <ul class="cart_bag">
                                                <li>
                                                    <a class="mybag-pic" href="">
                                                        <img src="/assets/images/3.jpg" alt=""></a>
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
                                            <p>Gesamtsumme: <strong class="cart_amount"> $180.00</strong></p>
                                        </div>
                                        <div class="view-check">
                                            <a href="<?php echo LANGPATH;?>/cart/view" class="btn btn-default">EINKAUFSTASCHE SEHEN</a>
                                            <p class="free-shipping free_shipping" style="display:none;">1+ „Free Shipping" Artikel hinzufügen <br>Kostenlosen Versand für Ihre gesamte Bestellung Genießen</p>
                                            <p class="free-shipping sale_words" style="display:none;"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="reg-sin flr">
                                <div id="customer_sign_in" class="out">
                                    <a href="<?php echo LANGPATH; ?>/customer/login">ANMELDEN</a>
                                </div>
                                <div id="customer_signed" class="drop-down cs-show hide" style="display: none;">
                                    <div class="drop-down-hd" id="customer_signed">
                                        <span id="username"></span>
                                    </div>
                                    <ul class="drop-down-list cs-list">
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/customer/orders">Bestellhistorie</a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/tracks/track_order">Verfolgen</a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/customer/wishlist">Meine Wunschliste</a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/customer/profile">Mein Profil</a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/customer/logout">Abmelden</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

<!--                             <li class="mybag" id="mybag1">
    <div class="currentbag mybag-box hide">
        <span class="topicon"></span>
        <div class="mybag-con">
            <h4 class="tit">ERFOLG! ARTIKEL IN DEN WARENKORB HINZUGEFÜGT</h4>
            <div class="bag_items items mtb5">
                <ul class="cart_bag">
                    <li></li>
                </ul>
                <p><a href="<?php echo LANGPATH; ?>/cart/view" class="btn btn-primary btn-lg">MEIN WARENKORB SEHEN</a></p>
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
                                    <li class="cs-show p-hide" style="width:13%">
                                        <a href="<?php echo LANGPATH;?>/daily-new/week2"><?php echo isset($head_footer['head_second']) ? $head_footer['head_second'] : 'NEUHEITEN'; ?></a>
                                        <div class="nav-list cs-list">
                                            <span class="downicon tpn01"></span>
                                            <div class="nav-box">
                                                <div class="nav-list01 fll">
                                                    <dl class="nav-ul">
                                                        <dt class="title"><?php echo isset($head_footer['head_second_first']) ? $head_footer['head_second_first'] :'FILTERN NACH'; ?></dt>
                                                        <dd><a href="<?php echo LANGPATH;?>/daily-new/week2"><?php echo isset($head_footer['head_second_second']) ? $head_footer['head_second_second'] : 'Diese Woche'; ?></a></dd>
                                                        <dd><a href="<?php echo LANGPATH;?>/daily-new/week1"><?php echo isset($head_footer['head_second_third']) ? $head_footer['head_second_third'] : 'Letzte Woche'; ?></a></dd>
                                                        <dd><a href="<?php echo LANGPATH;?>/daily-new/month"><?php echo isset($head_footer['head_second_fourth']) ? $head_footer['head_second_fourth'] : 'Letzter Monat'; ?></a></dd>
                                                    </dl>
                                                </div>
                                                    <?php
                                                        $cache_newindex_key = '1site_newindex_choies' .LANGUAGE;
                                                        $cacheins = Cache::instance('memcache');
                                                        $cache_newindex_content = $cacheins->get($cache_newindex_key);
                                                 if (isset($cache_newindex_content) AND !isset($_GET['cache'])){
                                                            $newindex_banners = $cache_newindex_content;
                                                        }else{
                                                           $newindex_banners = DB::select()->from('banners_banner')->where('type', '=', 'newindex')->where('visibility', '=', 1)->where('lang', '=', LANGUAGE)->order_by('position', 'ASC')->execute()->as_array();
                                                           $cacheins->set($cache_newindex_key,$newindex_banners, 3600);
                                                        }

                                                        ?>
                                                <div class="nav-list02 fll">
                                                        <?php
                                                        if(array_key_exists(0, $newindex_banners))
                                                        {
                                                        ?>
                                                    <a href="<?php echo LANGPATH;?><?php echo $newindex_banners[0]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[0]['image']; ?>" class="<?php echo LANGUAGE;?>_navigation_banner1"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>  
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cs-show" style="width:13%">
                                        <a href="<?php echo LANGPATH; ?>/clothing-c-615"><?php echo isset($head_footer['head_third']) ? $head_footer['head_third'] : 'BEKLEIDUNG'; ?></a>
                                        <div class="nav-list cs-list" style="margin-left:-100%;">
                                            <span class="downicon tpn02"></span>
                                            <div class="nav-box">
                                                <div class="nav-list03 fll">
                                                    <dl class="nav-ul01">
                                                        <dt class="title"><?php echo isset($head_footer['head_third_first']) ? $head_footer['head_third_first'] :'EINKAUF NACH KATEGORIE'; ?></a></dt>
                                                            <?php
                                                            $links = array(
                                                                array('Alle Bekleidung', 'clothing-c-615'),
                                                                array('Kleider', 'dresses-c-92'),
                                                                array('Tops', 'clothing-tops-c-621'),
                                                                array('Jacken', 'jackets-c-947'),
                                                                array('Mäntel & Jacken', 'coats-c-953'),
                                                                array('Pullover & Strickjacken', 'sweaters-knits-c-961'),
                                                                array('Anzüge & Koordinaten-Sets', 'suits-co-ords-c-1002'),
                                                                array('Jumpsuits & Overalls', 'rompers-jumpsuits-c-970'),                                   
                                                                array('Jeans', 'jeans-c-49'),
                                                                
                                                                array('Hosen & Leggings', 'pants-leggings-c-975'),
                                                                array('Shorts', 'shorts-c-51'),
                                                                array('Röcke', 'skirt-c-99'),
                                                                array('Bademode', 'swimwear-beachwear-c-178'),
                                                                array('Übergroß', 'plus-size-c-737'),
                                                                
                                                            ); 
                                                            foreach ($links as $link)
                                                            {
                                                                ?>
                                                                <dd><a href="<?php echo LANGPATH;?>/<?php echo $link[1]; ?>"><?php echo $link[0]; ?></a></dd>
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
                                                    <a href="<?php echo LANGPATH;?><?php echo $newindex_banners[1]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[1]['image']; ?>" class="<?php echo LANGUAGE;?>_navigation_banner2"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cs-show" style="width:13%">
                                        <a href="<?php echo LANGPATH; ?>/shoes-c-53">SCHUHE</a>
                                        <div class="nav-list cs-list" style="margin-left:-200%;">
                                            <span class="downicon tpn03"></span>
                                            <div class="nav-box">
                                                <div class="nav-list03 fll">
                                                    <dl class="nav-ul01">
                                                        <dt class="title"><?php echo isset($head_footer['head_third_first']) ? $head_footer['head_third_first'] :'EINKAUF NACH KATEGORIE'; ?></a></dt>
                                                            <?php
                                                            $links = array(
                                                                array('Alle Schuhe', 'shoes-c-53'),
                                                                array('Ebeneschuhe', 'flats-c-152'),
                                                                array('Sandalen', 'sandals-c-150'),
                                                                array('Plateauschuhe', 'platforms-c-151'),
                                                                array('Schnürschuhe', 'lace-up-shoes-c-1007'),
                                                                array('Absatzschuhe', 'heels-c-636'),
                                                                array('Stiefeln', 'boots-c-149'),
                                                                array('Sportschuhe', 'sports-shoes-c-1008'),
                                                                
                                                            ); 
                                                            foreach ($links as $link)
                                                            {
                                                                ?>
                                                                <dd><a href="<?php echo LANGPATH;?>/<?php echo $link[1]; ?>"><?php echo $link[0]; ?></a></dd>
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
                                                    <a href="<?php echo LANGPATH;?><?php echo $newindex_banners[2]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[2]['image']; ?>" class="<?php echo LANGUAGE;?>_navigation_banner3"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    
                                    <li class="cs-show" style="width:13%">
                                        <a href="<?php echo LANGPATH; ?>/accessory-c-52">ACCESSOIRES</a>
                                        <div class="nav-list cs-list" style="margin-left:-300%;">
                                            <span class="downicon tpn04"></span>
                                            <div class="nav-box">
                                                <div class="nav-list03 fll">
                                                    <dl class="nav-ul01">
                                                        <dt class="title"><?php echo isset($head_footer['head_third_first']) ? $head_footer['head_third_first'] :'EINKAUF NACH KATEGORIE'; ?></a></dt>
                                                            <?php
                                                            $links = array(
                                                                array('Alle Accessoires', 'accessory-c-52'),
                                                                array('Taschen & Geldbeutel', 'bags-wallets-c-1016'),
                                                                array('Mützen', 'hats-caps-c-55'),
                                                                array('Schmuck', 'jewellery-c-638'),
                                                                array('Sonnenbrillen', 'sunglasses-c-58'),
                                                                array('Schals', 'scarves-snoods-c-57'),
                                                                array('Handschuhe', 'gloves-c-645'),
                                                                array('Socken & Strümpfe', 'socks-tights-c-54'),
                                                                array('Haarschmuck', 'hair-accessories-c-67'),
                                                                array('Gürtel', 'belts-c-59'),
                                                                array('Innendekoration', 'home-decor-c-795'),
                                                                array('Beauty', 'beauty-c-1019'),
                                                                
                                                            ); 
                                                            foreach ($links as $link)
                                                            {
                                                                ?>
                                                                <dd><a href="<?php echo LANGPATH;?>/<?php echo $link[1]; ?>"><?php echo $link[0]; ?></a></dd>
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
                                                    <a href="<?php echo LANGPATH;?><?php echo $newindex_banners[3]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[3]['image']; ?>" class="<?php echo LANGUAGE;?>_navigation_banner4"></a>
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
                                               <a href="<?php echo LANGPATH;?><?php echo $newindex_banners[4]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[4]['image']; ?>" class="<?php echo LANGUAGE;?>_navigation_banner5"></a>
                                                   <?php
                                                   }
                                                   ?>
                                               </div>
                                               </div>
                                           </div>
                                       </li>    -->                            
                                    <li class="cs-show p-hide" style="width:22%">
                                        <a href="javascript:void(0)">GALAXIE VON CHOIES</a>
                                        <div class="nav-list cs-list" style="margin-left:-236%;width: 454.5454545%;">
                                            <span class="downicon tpn06"></span>
                                            <div class="nav-box">
                                                <div class="nav-list01 fll">
                                                    <dl class="nav-ul">
                                                          <?php
                                                            $links = array(
                                                                array('Sports-Ballerina‎ Luxusdesign','ballerina-sportsluxe-edit-c-1006'),
                                                                array('Musikfestivals','music-festivals-edit-c-1020'),
                                                                array('Boho Chic','boho-chic-c-1024'),
                                                                array("Schulmode der 90er",'90-s-school-style-c-1022'),
                                                                array("Minimal-Stil der 90er",'90-s-minimal-style-c-1023'),
                                                                array('Jeans Stil','denim-style-in-c-719'),
                                                            );
                                                            ?>
                                                            <?php 
                                                            foreach ($links as $link)
                                                            {
                                                                ?>
                                                                <dd><a href="<?php echo LANGPATH;?>/<?php echo $link[1]; ?>"><?php echo $link[0]; ?></a></dd>
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
                                                    <a href="<?php echo LANGPATH;?><?php echo $newindex_banners[5]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[5]['image']; ?>" class="<?php echo LANGUAGE;?>_navigation_banner6"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>  
                                            </div>
                                        </div>
                                    </li>
                                    <li class="cs-show" style="width:13%">
                                        <a href="<?php echo LANGPATH; ?>/outlet-c-101" class="sale">SALE</a>
                                    </li>
                                    <li class="cs-show" style="width:13%">
                                        <!-- <a href="<?php echo LANGPATH; ?>/wholesale-policy"><?php echo isset($head_footer['head_eighth']) ? $head_footer['head_eighth'] : 'GROßHANDEL'; ?> 
                                        </a> -->
                                        <a href="<?php echo LANGPATH; ?>/wholesale"> <?php echo isset($head_footer['head_eighth']) ? $head_footer['head_eighth'] : 'GROßHANDEL'; ?> 
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>

            <nav class="navbar-collapse collapse hidden-sm hidden-md hidden-lg">
                    <!-- Contenedor -->
                    <ul id="accordion" class="accordion">
                        <li>
                            <div class="link">
                                <span>CATEGORY</span>
                                <span class="myaccount"><a href="<?php echo LANGPATH;?>/customer/summary">My Account</a></span>
                            </div>
                        </li>
                        <li><div class="link"><span>NEUHEITEN</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Go Back</span></a></li>
                                   <?php
                            $newinarr = array(
                                                array('Diese Woche', 'week2'),
                                                array('Letzte Woche', 'week1'),
                                                array('Letzter Monat', 'month'),
                                             );
                                     ?>
                                    <?php foreach ($newinarr as $link):  ?>
                                    <li>
                                        <a href="<?php echo LANGPATH;?>/daily-new/<?php echo $link[1]; ?>">Neuheiten: <?php echo $link[0]; ?>
                                        </a>
                                    </li>
                                    <?php endforeach;?>
                                    <li><a href="<?php echo LANGPATH;?>/new-presale-c-1012">Vorverkauf</a></li> 
                            </ul> 
                        </li>
                        <li>
                            <div class="link"><span class="icon-collection">GALAXIE VON CHOIES</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Go Back</span></a></li>
                                    <?php
                                        $apparels_list = array(
                                            'Sports-Ballerina‎ Luxusdesign' => '/ballerina-sportsluxe-edit-c-1006',
                                            'Musikfestivals' => '/music-festivals-edit-c-1020',
                                            'Boho Chic' => '/boho-chic-c-1024',
                                            "Schulmode der 90er" => '/90-s-school-style-c-1022',
                                            "Minimal-Stil der 90er" => '/90-s-minimal-style-c-1023',
                                            'Jeans Stil' => '/denim-style-in-c-719',
                                        );
                                        foreach($apparels_list as $name => $link)
                                        {
                                     ?>
                                     <li><a href="<?php echo LANGPATH; ?><?php echo $link; ?>"><?php echo $name; ?></a></li>
                                     <?php }?>
                            </ul>
                        </li>
                        <li>
                            <div class="link"><span class="icon-dresses">KLEIDER</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Go Back</span></a></li>
                                        <?php
                                            $links = array(
                                                    array('Alle anzeigen', 'dresses-c-92'),
                                                    array('Rückenfreie Kleider', 'backless-dress-c-456'),
                                                    array('Schwarze Kleider', 'black-dresses-c-203'),
                                                    array('Figurbetonte Kleider', 'bodycon-dresses-c-211'),
                                                    array('Blumen Kleider', 'floral-dresses-c-108'),
                                                    array('Spitzenkleider', 'lace-dresses-c-209'),
                                                    array('Maxikleider', 'maxi-dresses-c-207'),
                                                    array('Schulterfreie Kleider', 'off-the-shoulder-dresses-c-504'),
                                                    array('Party Kleider', 'party-dresses-c-205'),
                                                    array('Etuikleider', 'shift-dresses-c-724'),
                                                    array('Hemdkleider', 'shirt-dresses-c-725'),
                                                    array('Streifen Kleider', 'stripe-dresses-c-652'),
                                                    array('Weiße Kleider', 'white-dresses-c-204'),
                                             );
                                             $hot_dresses = array("black-dresses-c-203","maxi-dresses-c-207","shirt-dresses-c-725","white-dresses-c-204");
                                             foreach ($links as $link):
                                        ?>
                                        <li><a href="<?php echo LANGPATH;?>/<?php echo $link[1]; ?>" <?php if(in_array($link[1],$hot_dresses)){ echo 'class="red"'; }?>><?php echo $link[0]; ?></a></li>
                                        <?php endforeach;?>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-tops">OBERTEILE</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Go Back</span></a></li>
                                   <li><a href="<?php echo LANGPATH; ?>/clothing-tops-c-621">Alle anzeigen</a></li>
                                    <li><a href="<?php echo LANGPATH; ?>/t-shirts-c-245">T-shirts</a></li>
                                    <li><a href="<?php echo LANGPATH; ?>/blouses-shirts-c-616">Hemden & Blusen</a></li>
                                    <li><a href="<?php echo LANGPATH; ?>/bodysuits-c-250">Bodysuits</a></li>
                                    <li><a href="<?php echo LANGPATH; ?>/camis-tanks-c-617">Trägertops & Tank-Tops</a></li>
                                    <li><a href="<?php echo LANGPATH; ?>/two-piece-suit-c-177">Koordinaten-Sets</a></li>
                                    <li><a class="red" href="<?php echo LANGPATH; ?>/crop-tops-bralets-c-244">Bauchfreie Tops & Bralets</a></li>
                                    <li><a href="<?php echo LANGPATH; ?>/dress-tops-c-618">Kleid Tops</a></li>
                                    <li><a href="<?php echo LANGPATH; ?>/kimonos-c-414">Kimonos</a></li>
                                    <li><a href="<?php echo LANGPATH; ?>/knitwear-sweaters-c-619">Strickwaren</a></li>
                                    <li><a href="<?php echo LANGPATH; ?>/clothing-outerwear-c-623">Oberbekleidung</a></li>
                                    <li><a href="<?php echo LANGPATH; ?>/one-pieces-c-626">Ein-Stück</a></li>
                                    <li><a href="<?php echo LANGPATH; ?>/swimwear-c-628">Bademode</a></li>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-bottoms">UNTERTEILE</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Go Back</span></a></li>
                                    <li><a href="<?php echo LANGPATH; ?>/bottoms-c-240">Alle anzeigen</a></li>
                                    <li><a href="<?php echo LANGPATH; ?>/jeans-c-49">Jeans</a></li>
                                    <li><a href="<?php echo LANGPATH; ?>/leggings-c-232">Leggings</a></li>
                                    <li><a class="red" href="<?php echo LANGPATH; ?>/skirt-c-99">Röcke</a></li>
                                    <li><a href="<?php echo LANGPATH; ?>/shorts-c-51">Shorts</a></li>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-shoes">SCHUHE</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Go Back</span></a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/shoes-c-53">Alle anzeigen</a></li>
                                                            <?php
                                                            $links = array(
                                                                array('Alle Schuhe', 'shoes-c-53'),
                                                                array('Ebeneschuhe', 'flats-c-152'),
                                                                array('Sandalen', 'sandals-c-150'),
                                                                array('Plateauschuhe', 'platforms-c-151'),
                                                                array('Absatzschuhe', 'heels-c-636'),
                                                                array('Stiefeln', 'boots-c-149'),
                                                                
                                                            ); 
                                                            foreach ($links as $link)
                                                            {
                                                                ?>
                                                            <li><a href="<?php echo LANGPATH;?><?php echo $link[1]; ?>"><?php echo $link[0]; ?></a></li>
                                                            <?php }?>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-jewellery">SCHMUCK</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Go Back</span></a></li>
                                                   <?php
                                                        $links = array(
                                                                array('Alle anzeigen', 'jewellery-c-638'),
                                                                array('Ringe', 'rings-c-62'),
                                                                array('Ohrringe', 'earrings-c-63'),
                                                                array('Armbänder & Armreifen', 'bracelets-bangles-c-640'),
                                                                array('Halsschmuckn', 'neck-c-639'),
                                                                array('Fußkettchen', 'anklets-c-650'),
                                                                array('Körper Auffanggurt', 'body-harness-c-705'),
                                                        );
                                                        $hot=array("purses-c-644","sunglasses-c-58");
                                                        foreach ($links as $link):
                                                    ?>
                                                    <li><a href="<?php echo LANGPATH;?><?php echo $link[1]; ?>" <?php if(in_array($link[1],$hot)){ echo 'class="red"'; }?>><?php echo $link[0]; ?></a></li>
                                                    <?php endforeach;?>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-acc">ACC&TASCHEN</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Go Back</span></a></li>
                                                    <?php
                                                        $links = array(
                                                                array('Alle anzeigen', 'accessories-bags-c-641'),
                                                                array('Taschen', 'bags-c-643'),
                                                                array('Geldbörsen', 'purses-c-644'),
                                                                array('Handschuhe', 'gloves-c-645'),
                                                                array('Hüte und Mützen', 'hats-caps-c-55'),
                                                                array('Augenmaske', 'eye-masks-c-647'),
                                                                array('Schals & Schlauchschals', 'scarves-snoods-c-57'),
                                                                array('Socken & Strumpfhosen', 'socks-tights-c-54'),
                                                                array('Sonnenbrillen', 'sunglasses-c-58'),
                                                                array('Haarschmuck', 'hair-accessories-c-67'),
                                                                array('Perücke', 'hair-extensions-c-646'),
                                                                array('Gürtel', 'belts-c-59'),
                                                                array('Innendekoration', 'home-decor-c-795'),
                                                                array('Nagellack', 'nails-c-460'),
                                                        );
                                                        $hot=array("purses-c-644","sunglasses-c-58");
                                                        foreach ($links as $link):
                                                    ?>
                                                    <li><a href="<?php echo LANGPATH;?><?php echo $link[1]; ?>" <?php if(in_array($link[1],$hot)){ echo 'class="red"'; }?>><?php echo $link[0]; ?></a></li>
                                                    <?php endforeach;?>
                                                </ul>
                                    <li>
                                        <div class="link"><span><a href="/outlet-c-101">SALE</a></span></div>
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
        <!-- <div id="moblie-header" class="site-header hidden-xs" 
        style="top: 0px;position: fixed; width: 100%; z-index: 999;">           
        </div> -->
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
                                            <a class="logo" href="<?php echo LANGPATH;?>/" title=""><img src="<?php echo STATICURL;?>/assets/images/2016/logo.png" alt=""></a>
                                        </div>
                                        <div class="col-xs-2" style="padding:0;">
                                                <a class="fa fa-search"></a>
                                                <a href="<?php echo LANGPATH;?>/cart/view" class="bag-phone-on cart_count"></a>
                                        </div>
                                    </div>
                                    <div class="navbar-search hide">
                                        <form action="<?php echo LANGPATH;?>/search" method="get" onsubmit="return search1('searchwords');">
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
                <?php $domain = Site::instance()->get('domain'); ?>
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
                            <label class=""><?php echo isset($head_footer['footer_first']) ? $head_footer['footer_first'] : 'BLEIBEN SIE INFORMIERT'; ?></label>
                            <div>
                                <input type="text" class="signin-input" id="letter_text" class="text fll" value="Geben Sie Ihre E-Mail-Adresse hier ein, um Newsletter zu erhalten" onblur="if(this.value==''){this.value=this.defaultValue;}" onfocus="if(this.value=='Geben Sie Ihre E-Mail-Adresse hier ein, um Newsletter zu erhalten'){this.value='';};">
                                <input type="submit" id="letter_btn" value="<?php echo isset($head_footer['footer_second']) ? $head_footer['footer_second'] : 'ANMELDEN'; ?>" class="btn btn-default">
                            </div>
                            <div class="red" id="letter_message" style="margin-left:185px;"></div>
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
                                                '<?php echo LANGPATH;?>/newsletter/ajax_add', {
                                                    email: email
                                                },
                                                function(data) {
                                                   var message = data['message'];
                                                    message = message.replace('You are in Now. Thanks', 'Sie sind in jetzt. Danke');
                                                    message = message.replace('Sorry, email has been used', 'Es tut uns leid, dass diese E-Mail verwendet wurde');
                                                    message = message.replace('Please enter a valid email address', 'Bitte geben Sie eine gültige E-Mail Adresse ein');
                                                    $("#letter_message").html(message);
                                                    if(data['success'] == 0)
                                                    {
                                                        $('#letter_message').fadeIn(10).delay(3000).fadeOut(10);
                                                    }
                                                    else
                                                    {
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
                            <span><?php echo isset($head_footer['footer_third']) ? $head_footer['footer_third'] : 'SOZIALE NETZWERKE'; ?></span>
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
                                    <img style="margin-top:-3px;" src="http://d1cr7zfsu1b8qs.cloudfront.net/assets/images/2016/sb-logo.png" data-pin-nopin="true"></a>
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
                                <li class="col-xs-3"><a class="shipping-icon" href="<?php echo LANGPATH;?>/shipping-delivery"><span></span><?php echo  isset($head_footer['footer_fourth']) ? $head_footer['footer_fourth'] : 'VERSANDARTEN'; ?></a></li>
                                <li class="col-xs-3"><a class="returns-icon" href="<?php echo LANGPATH;?>/returns-exchange"><span></span><?php echo isset($head_footer['footer_fifth']) ? $head_footer['footer_fifth'] : 'RÜCKGABE'; ?></a></li>
                                <li class="col-xs-3"><a class="size-icon" href="<?php echo LANGPATH;?>/size-guide"><span></span><?php echo isset($head_footer['footer_sixth']) ? $head_footer['footer_sixth'] : 'GRÖSSENTABELLE'; ?></a></li>
                                <li class="col-xs-3"><a class="membership-icon" href="<?php echo LANGPATH;?>/vip-policy"><span></span><?php echo isset($head_footer['footer_seventh']) ? $head_footer['footer_seventh'] : 'MITGLIEDSCHAFT'; ?></a></li>
                            </ul>
                        </div>
                        <div class="footer-context">
                            <dl>
                                <dt><?php echo isset($head_footer['footer_eighth']) ? $head_footer['footer_eighth'] : 'ÜBER UNS' ;?></dt>
                                <dd><a href="<?php echo LANGPATH;?>/about-us"><?php echo isset($head_footer['footer_eighth_first']) ? $head_footer['footer_eighth_first'] : 'Wer wir sind' ;?></a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/affiliate-program"><?php echo isset($head_footer['footer_eighth_second']) ? $head_footer['footer_eighth_second'] : 'Partnerprogramm' ;?></a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/blogger/programme"><?php echo isset($head_footer['footer_eighth_third']) ? $head_footer['footer_eighth_third'] : 'Bloggers' ;?></a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/Copyright-Infringement-Notice"><?php echo isset($head_footer['footer_eighth_fourth']) ? $head_footer['footer_eighth_fourth'] : 'Copyright Notice' ;?></a></dd>
                            </dl>
                            <dl>
                                <dt><?php echo isset($head_footer['footer_ninth']) ? $head_footer['footer_ninth'] : 'HILFE' ;?></dt>
                                <dd><a href="<?php echo LANGPATH;?>/contact-us"><?php echo isset($head_footer['footer_ninth_firsh']) ? $head_footer['footer_ninth_firsh'] : 'Kontakt' ;?></a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/faqs"><?php echo isset($head_footer['footer_ninth_second']) ? $head_footer['footer_ninth_second'] : 'FAQs' ;?></a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/important-notice"><?php echo isset($head_footer['footer_ninth_third']) ? $head_footer['footer_ninth_third'] : 'Hinweise' ;?></a></dd>
								<dd><a href="<?php echo LANGPATH;?>/how-to-order"><?php echo isset($head_footer['footer_ninth_foutth']) ? $head_footer['footer_ninth_foutth'] : 'Wie man bestellt' ;?></a></dd>
                            </dl>
                            <dl>
                                <dt><?php echo isset($head_footer['footer_tenth']) ? $head_footer['footer_tenth'] : 'EINKAUFSFÜHRER' ;?></dt>
                                <dd><a href="<?php echo LANGPATH;?>/payment"><?php echo isset($head_footer['footer_tenth_first']) ? $head_footer['footer_tenth_first'] : 'Bezahlung' ;?></a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/coupon-points"><?php echo isset($head_footer['footer_tenth_second']) ? $head_footer['footer_tenth_second'] : 'Gutscheine' ;?></a></dd>
								<dd><a href="<?php echo LANGPATH;?>/brand/brandpage"><?php echo isset($head_footer['footer_tenth_third']) ? $head_footer['footer_tenth_third'] : 'Brand List' ;?></a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/wholesale"><?php echo isset($head_footer['footer_tenth_fourth']) ? $head_footer['footer_tenth_fourth'] : 'Großhandel' ;?></a></dd>
                            </dl>
                            <dl>
                                <dt><?php echo isset($head_footer['footer_eleventh']) ? $head_footer['footer_eleventh'] : 'WIR AKZEPTIEREN' ;?></dt>
                                <dd><img src="<?php echo STATICURL;?>/assets/images/2016/card-0517.jpg"></dd>
                            </dl>
                        </div>
                    </div>              
                </div>
            </div>
            <div class="footer-bottom hidden-xs">
                <p>
                    <a href=""><img src="<?php echo STATICURL;?>/assets/images/2016/card-N.jpg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;© 2006-2016 CHOIES.COM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo LANGPATH;?>/privacy-security">DATENSCHUTZRICHTLINIE</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo LANGPATH;?>/conditions-of-use">AGB</a> 
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
                                            <input id="letter_text1" class="text" value="Email Adresse" onblur="if(this.value==''){this.value=this.defaultValue;}" onfocus="if(this.value=='Email Adresse'){this.value='';};" type="text">
                                            <input id="letter_btn1" value="SENDEN" class="btn btn-primary" type="submit">
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
                                                    var message = data['message'];
                                                    message = message.replace('You are in Now. Thanks', 'Sie sind in jetzt. Danke');
                                                    message = message.replace('Sorry, email has been used', 'Es tut uns leid, dieses E-Mail wurde schon verwendet');
                                                    message = message.replace('Please enter a valid email address', 'Bitte geben Sie eine gültige E-Mail-Adresse ein');
                                                    $("#letter_message1").html(message);
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
                            <dt style="text-transform: capitalize;"><a href="<?php echo LANGPATH; ?>/lookbook">#Lookbooks</a>
                            </dl>  
                            <dl class="sns">
                                <dt>Connect With Us</dt>
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
                                 <dt style="text-transform: capitalize;"><a href="<?php echo LANGPATH; ?>/customer/summary">MEIN KONTO&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/tracks/track_order">&nbsp;Verfolgen&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/customer/orders">&nbsp;Bestellhistorie</a></dt>
                            </dl>
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <dd><a href="<?php echo LANGPATH; ?>/about-us" style="color:#444;">Über Choies&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/vip-policy" style="color:#444;">&nbsp;Mitgliedschaft&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/contact-us" style="color:#444;">&nbsp;Kontakt&nbsp;</a></dd>
                            </dl>  
                           
                        </div>
                        <div class="copyright visible-xs-block hidden-sm hidden-md hidden-lg">
                            <p>Copyright © 2006-2016 Choies.com </p>
                            <p class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <a href="<?php echo LANGPATH; ?>/conditions-of-use">&nbsp;AGB&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/privacy-security">&nbsp;DATENSCHUTZRICHTLINIE</a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
            <div id="comm100-button-311" class="home-right-icons de-icons hidden-xs">
                <a href="#" onclick="openLivechat();return false;"><span class="live-chat-icon"></span></a>
                <a href="<?php echo LANGPATH;?>/contact-us"><span class="email-us-icon"></span></a>
            </div>
            <div id="gotop" class="hide ">
                <a href="#" class="xs-mobile-top a-de"></a>
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
                                $("#think1 .failed1 p").html("Bitte geben Sie eine gültige E-Mail Adresse ein!");
                                $("#think1 .success1").hide();
                                $("#wingray3").remove();
                                $(".reveal-modal-bg").fadeOut();
                            }
                            else if(data['success'] == -1)
                            {
                                $("#think1 .failed1").show();
                                $("#think1 .failed1 p").html("Nicht mehr als 5 Feedbacks in 24 Stunden!");
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
                                $("#think1 .failed1 p").html("Bitte geben Sie eine gültige E-Mail Adresse ein!");
                                $("#think1 .success1").hide();
                                $("#wingray3").remove();
                                $(".reveal-modal-bg").fadeOut();
                            }
                            else if(data['success'] == -1)
                            {
                                $("#think1 .failed1").show();
                                $("#think1 .failed1 p").html("Nicht mehr als 5 Feedbacks in 24 Stunden!");
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

<div id="myModal8" class="reveal-modal large feedback" >
        <a class="close-reveal-modal close-btn3"></a>
        <div id="tijiao">
                <div class="feedback-title">
                    <div class="fll text1">CHOIES WOLLEN IHRE STIMME HÖREN!</div>
                </div>
                <div class="clearfix"></div>
                <div class="point ml15 mt5">
                    Diejenigen, die signifikante Feedbacks bieten, können 
                    <strong class="red">$5 Punkte</strong> Belohnung erhalten.
                </div>
                <div class="feedtab">
                    <ul class="feedtab-nav JS-tab1">
                        <li class="current">FEEDBACK</li>
                        <li class="">FRAGE?</li>
                    </ul>
                    <div class="feedtab-con JS-tabcon1">
                        <div class="bd">
                            <form id="feedbackForm" method="post" action="#" class="form formArea">
                                <ul>
                                    <li>
                                        <label for="My Suggestion:">Choies, das ist etwas, was Ich mag: </label>
                                        <textarea name="what_like" id="what_like" rows="3" class="input textarea"></textarea>
                                    </li>
                                    <li>
                                        <label for="My Suggestion:"><span>*</span> Choies, ich glaube, man kann es besser machen: <span class="errorInfo clear hide">Bitte schreiben Sie hier etwas.</span></label>
                                        <textarea name="do_better" id="do_better" rows="5" class="input textarea"></textarea>
                                    </li>
                                    <li>
                                        <label for="Email Address:"><span>*</span> Email Adresse:<span class="errorInfo clear hide">Bitte geben Sie eine E-Mail ein.</span>
                                        </label>
                                        <input type="text" name="email" id="f_email1" class="text text-long" value="" maxlength="340">
                                    </li>
                                    <li>
                                        <input type="submit" class="btn btn-primary btn-lg" value="SENDEN"></li>
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
                                            required:"Bitte geben Sie eine E-Mail Adresse ein.",
                                            email:"Bitte geben Sie eine gültige E-Mail Adresse ein."
                                        },
                                        do_better: {
                                            required:"Dieses Feld ist erforderlich.",
                                            minlength: "Bitte geben Sie mindestens 5 Schriftzeichen ein."
                                        }
                                    }
                                });
                            </script>
                        </div>
                        <div class="bd hide">
                            <form id="problemForm" method="post" action="#" class="form formArea">
                                <ul>
                                    <li>
                                        <label><span>*</span> Brauchen Sie Hilfe? Bitte beschreiben Sie das Problem: <span class="errorInfo clear hide">Bitte schreiben Sie hier etwas.</span></label>
                                        <textarea name="comment" id="f_comment" rows="7" class="input textarea"></textarea>
                                    </li>
                                    <li>
                                        <label><span>*</span> Email Adresse:<span class="errorInfo clear hide">Bitte geben Sie Ihre E-Mail ein.</span><br>
                                        </label>
                                        <input type="text" name="email1" id="f_email2" class="text text-long" value="" maxlength="340">
                                    </li>
                                    <li>
                                        <input type="submit" data-reveal-id="myModal9" class="btn btn-primary btn-lg" value="SENDEN"></li>
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
                                            required:"Bitte geben Sie eine E-Mail Adresse ein.",
                                            email:"Bitte geben Sie eine gültige E-Mail Adresse ein."
                                        },
                                        comment: {
                                            required:"Dieses Feld ist erforderlich.",
                                            minlength: "Bitte geben Sie mindestens 5 Schriftzeichen ein."
                                        }
                                    }
                                });
                            </script>
                             <p class="mt10">Weitere detaillierte Fragen? Bitte <a href="#" onclick="openLivechat();return false;" title="kontaktieren Sie uns" target="_blank">kontaktieren Sie uns</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="think1" style="display:none">
                <div class="success1">
                    <h3>VIELEN DANK !</h3>
                    <p><em>Ihr Feedback wurde erhaltet !</em></p>
                </div>
                <div class="failed1">
                    <h3>Es tut uns leid! </h3>
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
        <script src="/assets/js/flickity-docs.min.js"></script>

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
            
            <?php 
            $cart = Cartcookie::get();   ?>
            function ajax_cart()
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo LANGPATH; ?>/cart/ajax_cart",
                    dataType: "json",
                    data: "",
                    success: function(msg){
                        if(msg['count'] > 0)
                        {
                            $(".cart_count").text(msg['count']);
                            $(".cart-all-goods").show();
                            var cart_view = msg['cart_view'];
                            cart_view = cart_view.replace(/Item:/g, 'Artikel:');
                            cart_view = cart_view.replace(/Size:/g, 'Größe:');
                            cart_view = cart_view.replace(/Quantity:/g, 'Menge:');
                        //    cart_view = cart_view.replace(/one size/g, 'eine Größe');
                            cart_view = cart_view.replace(/%off/g, '%Rabatt');
                            $(".cart_bag").html(cart_view);
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
                if($type == 'cart_view')
                    $type = 'cart';
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

<!--              <script>
                $(function(){
                    $('a').click(function(){
                        var lang = '/<?php echo LANGUAGE; ?>';
                        var h = $(this).attr('href');
                        var c1 = $(this).parent().attr('class');
                        var c2 = $(this).parent().parent().attr('class');
                        if(c1 != 'lang' && c2 != 'lang')
                        {
                        if(h.indexOf('/') != -1)
                        {
                            var a = h.indexOf('http');
                            if(a == -1)
                            {
                                var haslang = h.indexOf(lang);
                                if(haslang == -1)
                                {
                                    var target = $(this).attr('target');
                                    if(target == '_blank')
                                    {
                                        window.open(lang + h, "_blank")
                                    }
                                    else
                                    {
                                        window.location.href = lang + h;
                                    }
                                    return false;
                                }
                            }
                        }
                        }
                        
                    })
                })
                </script>-->

                <?php
            }
            ?>
                
            <?php 
            if($user_id){
                $user_session = Session::instance()->get('user');
                $email = $user_session['email'];
            ?>
            <?php } ?>
            <!-- HK ScarabQueue statistics Code -->

            <!-- <script src="//cdn.optimizely.com/js/557241246.js"></script> -->
            
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
 
    <!-- 注册有礼 ADD TIME 2015、9、23 -->  
    <div id="gift-modal-fb" class="reveal-modal JS-popwincon1 hidden-xs" style="border-radius:0;display:none;visibility:visible;background:#fff;" >
        <a class="close-reveal-modal close-btn3 JS-close2"></a>
        <div class="register-left"></div>
        <div class="register-right">
            <p style="margin-top:110px;line-height:30px;">Es tut uns leid, dass Sie bereits mit diesem Facebook-Konto registriert haben.</p>
        </div>
    </div>

    <div id="gift-modal-fb-phone" class="register-gift-phone JS-popwincon1 hidden-sm hidden-md hidden-lg" style="border-radius:0;display:none;visibility:visible;background:#fff;">
        <a class="close-reveal-modal close-btn3 JS-close2"></a>
        <div class="register-right">
            <p style="margin-top:90px;line-height:30px;">Es tut uns leid, dass Sie bereits mit diesem Facebook-Konto registriert haben.</p>
        </div>
    </div>

    <div id="register-modal" class="reveal-modal register-gift JS-popwincon1 hidden-xs regfreehide" style="border-radius:0;" >
        <a class="close-reveal-modal close-btn3 JS-close2"></a>
        <div class="register-left"></div>
        <div class="register-right">
            <span style="font-size:24px;"><b>Registrieren & Gewinnen</b></span>
            <br/>           
            <p><span style="text-align:center;">An CHOiES teilnehmen, um</span><br/><span class="red">ein freies Geschenk zu gewinnen</span>.</p>
            <form class="register-form" action="#" method="post">
                <label><i>* Email</i></label>
                <input id="register-gift-email" type="text" class="register-gift-text valuemail" placeholder="Ihr Email " name="email" value=""/><br/>
                <b id="message" style="color:#cc3300;margin-top:10px"></b>
                <input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" type="submit" id="register-get" value="Gewinnen">
            </form>
            <?php
            $redirect = Arr::get($_GET, 'redirect', '/de/');
            $page = isset($_SERVER['HTTP_SELF']) ? 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_SELF'] . '/' . htmlspecialchars($redirect) : 'http://' . $_SERVER['HTTP_HOST'] . '/' . htmlspecialchars($redirect);
            $facebook = new facebook();
            $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
            ?>
            <a href="<?php echo $loginUrl;?>" class="register-gift-btn" onclick="return setcookiefb();">Mit Facebook Anmelden</a>
            <p class="gift-no"><a class="JS-close2" style="font-size:11px;">Nein Danke. Ich möchte meinen eigenen Weg folgen!</a></p>
        </div>
    </div>

    <!-- 手机端输入账号 -->
    <div id="register-modal-phone" class="register-gift-phone JS-popwincon1 hidden-sm hidden-md hidden-lg regfreehide" style="border-radius:0;">
        <a class="close-reveal-modal close-btn3 JS-close2"></a>
        <div class="register-right">
            <h3 style="font-size:22px;"><b>Registrieren & Gewinnen</b></h3>
            <p><span style="text-align:center;">An CHOiES teilnehmen, um</span><br/><span class="red">ein freies Geschenk zu gewinnen</span>.</p>
            <form class="register-form-phone" action="#" method="post">
                <label><i>* Email</i></label>
                <input type="text" class="register-gift-text valuemail" placeholder="Ihr Email" name="email" value="">
                <input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" id="register-get" type="submit" value="Gewinnen ">
            </form>
            <?php
            $redirect = Arr::get($_GET, 'redirect', '/de/');
            $page = isset($_SERVER['HTTP_SELF']) ? 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_SELF'] . '/' . htmlspecialchars($redirect) : 'http://' . $_SERVER['HTTP_HOST'] . '/' . htmlspecialchars($redirect);
            $facebook = new facebook();
            $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
            ?>
            <a href="<?php echo $loginUrl;?>" class="register-gift-btn" onclick="return setcookiefb();">Mit Facebook Anmelden</a>
            <p class="gift-no"><a class="JS-close2" style="font-size:11px;">Nein Danke. Ich möchte meinen eigenen Weg folgen! </a></p>
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
            
            <span style="font-size:29px;color:red;"><b>FREIE GESCHENKE</b></span>
            <h4>für Neuankömmlinge!</h4>
            <p class="mt20" style="font-size:15px;">Bitte wählen Sie einen Artikel und setzen Sie Ihr Passwort unten. </p>
            <form class="mt20 gift-form" action="#" method="post">
                <?php if(!$user_fb){ ?>
                <label><i>* Passwort </i></label>
                <input type="password" class="register-gift-text userpwd" placeholder="6-24 Schriftzeichens" name="password" value="">
                <?php } ?>
                <input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" id="register-apply" type="submit" value="BEWERBEN " onclick="return loading2();">
            </form>
        </div>
    </div>

    <!-- 注册部分 -->
    <div id="gift-modal-phone" class="reveal-modal register-gift register-gift-2-phone JS-popwincon1 hidden-sm hidden-md hidden-lg" style="border-radius:0;display:none">
        <a class="close-reveal-modal close-btn3 JS-close2"></a>
        <div class="register-right" style="margin-top:0;padding:0;padding-top:20px;">
        
            <h2>FREIE GESCHENKE  </h2>
            <h4>für Neuankömmlinge!</h4>
            <p class="mt20">Bitte wählen Sie einen Artikel und setzen Sie Ihr Passwort unten.</p>
            <ul style="margin-top:2px;">
                <?php 
                    $free = Site::instance()->registergift();
                    if($free){

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
                <!--<li class="mt10"><div class="img-select hide"><img src="../images/gift-select.png" alt=""></div><img src="../images/SHOE1215A461B.jpg" alt=""><p><span class="red">$0.00&nbsp;&nbsp;</span><span><del>$9.99</del></span></p></li>-->
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
                <label><i>* Passwort</i></label>
                <input type="password" class="register-gift-text userpwd" placeholder="6-24 Schriftzeichens " name="password" value="">
                <?php } ?>
                <input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" id="register-apply" type="submit" value="BEWERBEN " onclick="return loading2();">
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
                    ac.html('Bitte wählen Sie einen diesen Artikel und ANWENDEN.'); 
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
                    required: "Bitte geben Sie Ihre E-Mail Adresse ein.",
                    email:"Bitte geben Sie eine gültige E-Mail Adresse ein."
                }
            },
            submitHandler: function(form) {  
                //Check user email
                var valuemail = $(".register-form").find(".valuemail").val();
                $.post('/cart/ajax_chkuser', {email:valuemail}, function(re){
                    if(re == "isset"){
                        alert("Entschuldigung, ein Konto existiert bereits mit dieser E-Mail-Adresse!");
                        return false;
                    }else if(re == "emailerror"){
                        alert("Bitte geben Sie eine gültige E-Mail Adresse ein.");
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
                    required: "Bitte geben Sie Ihre E-Mail Adresse ein.",
                    email:"Bitte geben Sie eine gültige E-Mail Adresse ein."
                }            
            },
            submitHandler: function(form) {       

                //Check user email
                var valuemail = $(".register-form-phone").find(".valuemail").val();
                $.post('/cart/ajax_chkuser', {email:valuemail}, function(re){
                    if(re == "isset"){
                        alert("Entschuldigung, ein Konto existiert bereits mit dieser E-Mail-Adresse!");
                        return false;
                    }else if(re == "emailerror"){
                        alert("Bitte geben Sie eine gültige E-Mail Adresse ein.");
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
                        required: "Bitte geben Sie ein Passwort ein.",
                        minlength: "Ihr Passwort muss 6-24 Schriftzeichens lang sein.",
                        maxlength: "Ihr Passwort muss 6-24 Schriftzeichens lang sein."
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
                         str +="<span>Hallo, Choieser!</span>";
                         str +="</div>";
                         str +="<dl class='drop-down-list cs-list' >";
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
                        $("#add_wishlist").html(str);
                        $(".JS-popwincon1,.reveal-modal-bg").fadeOut("fast",function(){
                            $("#mybag1").find(".mybag-box").css({"margin-top":"20px"}).fadeIn();
                            setTimeout("$('#mybag1').find('.mybag-box').fadeOut();", 2000);
                        });
                    }else{ 
                        alert(re);
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
                        required: "Bitte geben Sie ein Passwort ein.",
                        minlength: "Ihr Passwort muss 6-24 Schriftzeichens lang sein.",
                        maxlength: "Ihr Passwort muss 6-24 Schriftzeichens lang sein."
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
                            window.location.href="<?php echo LANGPATH; ?>/cart/view";
                        });
                    }else{ 
                        alert(re);
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
                             str +="<span>Hallo, Choieser!</span>";
                             str +="</div>";
                             str +="<dl class='drop-down-list cs-list' >";
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