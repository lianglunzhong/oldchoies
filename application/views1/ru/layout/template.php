<!DOCTYPE html>
<html xml:lang="<?php echo LANGUAGE; ?>">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" id="viewport" name="viewport">
        <title><?php echo $title; ?></title>
        <meta name="keywords" content="<?php echo $keywords; ?>" />
        <meta name="description" content="<?php echo $description; ?>" />
        <meta property="fb:app_id" content="<?php echo Site::instance()->get('fb_api_id'); ?>" />
        <link type="image/x-icon" rel="shortcut icon" href="/favicon.ico" />
        <link rel="stylesheet" href="<?php echo Site::instance()->version_file('/assets/css/style.css'); ?>" media="all" id="mystyle" />
        <script src="<?php echo Site::instance()->version_file('/assets/js/jquery-1.8.2.min.js'); ?>"></script>
        <script src="<?php echo Site::instance()->version_file('/assets/js/plugin.js'); ?>"></script>
        <!-- FB Website Visitors Code -->
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

            _fbq.push(['addPixelId', '454325211368099']);

            })();

            window._fbq = window._fbq || [];

            <?php 
            if(!isset($type))
            {
                $type = '';
            }
            if ($type != 'product' && $type != 'cart_view'){ ?>
            window._fbq.push(['track', 'PixelInitialized', {}]);
            <?php
            } 
            ?>

            </script>
            <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=454325211368099&amp;ev=PixelInitialized" /></noscript>       
        
        <!-- End FB Website Visitors Code -->

            <?php
            if ($type != 'payment' && $type != 'category' && $type != 'product' && $type != 'cart_view' && $type != 'purchase')
            {
                ?>
            <!-- Criteo Code For Home Page -->
                <?php
        $user_id = Customer::logged_in();
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

         <!-- Facebook Pixel Code -->

        <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','//connect.facebook.net/en_US/fbevents.js');
        fbq('init', '704997696271245');
        fbq('track', 'PageView');
        fbq('track', 'ViewContent');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=704997696271245&ev=PageView&noscript=1"
        /></noscript>

        <!-- End Facebook Pixel Code -->

        <!-- LC tell -->
        <script type='text/javascript' src='https://c.la10.salesforceliveagent.com/content/g/js/35.0/deployment.js'></script>
        <script type='text/javascript'>
        liveagent.init('https://d.la10.salesforceliveagent.com/chat', '57228000000PAtz', '00D28000000Ukt3');
        </script>
        <!-- end LC tell -->

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
        <script type="text/javascript">
        var ScarabQueue = ScarabQueue || [];
        (function(subdomain, id) {
          if (document.getElementById(id)) return;
          var js = document.createElement('script'); js.id = id;
          js.src = subdomain + '.scarabresearch.com/js/19EF1AD67F9C17E4/scarab-v2.js';
          var fs = document.getElementsByTagName('script')[0];
          fs.parentNode.insertBefore(js, fs);
        })('https:' == document.location.protocol ? 'https://recommender' : 'http://cdn', 'scarab-js-api');
        </script>

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

        <script>
        var _prum = [['id', '543f270fabe53d8358df07cd'],
                     ['mark', 'firstbyte', (new Date()).getTime()]];
        (function() {
            var s = document.getElementsByTagName('script')[0]
              , p = document.createElement('script');
            p.async = 'async';
            p.src = '//rum-static.pingdom.net/prum.min.js';
            s.parentNode.insertBefore(p, s);
        })();
        </script>
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
        $user_id = Customer::logged_in();
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
            <header class="site-header">
            <div class="top-ad JS-popwincon" style="width:100%;background-color:#ce0100;max-height:50px;">
                <a class="JS-close close-btn3 hidden-xs" style="top:0;right:5px;z-index:5;"></a>
                <div class="container">
                    <div class="row">
					<!-- banner del 12-28
                        <div class="col-sm-12 hidden-xs">
						
                            <a href="<?php //echo LANGPATH;?>/christmas-sale-clearance-c-886?hp1221"><img src="<?php //echo STATICURL; ?>/assets/images/ru/1512/12-21.jpg"></a>
							
                        </div>
						-->
                  </div>
                </div>           
            </div>

                <div class="top-shortcut">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-2 col-md-1">
                                <div class="drop-down JS-show">
                                <?php
                                $currency_now = Site::instance()->currency();
                                ?>
                                    <div class="drop-down-hd">
                                        <a href="#" class="icon-flag flag-wh icon-<?php echo strtolower($currency_now['name']); ?>"></a> 
                                        <i class="fa fa-caret-down"></i>
                                        <span>
                                        <?php
                                        if(strpos($currency_now['code'], '$') !== False)
                                            $code_now = '$';
                                        else
                                            $code_now = $currency_now['code'];
                                        
                                        if(strlen($code_now) > 1)
                                            echo $currency_now['name'];
                                        else
                                            echo $code_now . $currency_now['name'];
                                        ?>
                                        </span>
                                    </div>
                                    <ul class="drop-down-list JS-showcon hide" style="display:none; width:150px;">
                                        <?php
                                        foreach ($currencies as $currency)
                                        {
                                            if(strpos($currency['code'], '$') !== False)
                                                $code = '$';
                                            else
                                                $code = $currency['code'];
                                            ?>
                                            <li class="drop-down-option" onclick="location.href='<?php echo LANGPATH; ?>/currency/set/<?php echo $currency['name'] ?>'">
                                                <a class="icon-flag icon-<?php echo strtolower($currency['name']); ?>" href="<?php echo LANGPATH; ?>/currency/set/<?php echo $currency['name'] ?>"><?php echo $currency['fname']; ?></a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-5">
                                <div class="menu-language">
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
                                    <ul class="lang">
                                    <?php
                                    foreach($lang_list as $lang => $path)
                                    {
                                    ?>
                                        <li>
                                            <a href="<?php echo $path . $request; ?>"><?php echo $lang; ?></a>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                    </ul>
                                </div>                          
                                <div class="drop-down select-language JS-show">
                                    <div class="drop-down-hd">
                                        <span>
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
                                        </span>
                                        <i class="fa fa-caret-down"></i>
                                    </div>
                                    <div class="JS-showcon hide" style="display:none; ">
                                        <dl class="drop-down-list " style="width:150%;">
                                        <?php
                                        foreach($lang_list as $lang => $path)
                                        {
                                        ?>
                                            <dd class="drop-down-option">
                                                <a href="<?php echo $path . $request; ?>"><?php echo $lang; ?></a>
                                            </dd>
                                        <?php
                                        }
                                        ?>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7 col-md-6">
                                <ul class="user-list">
                                    <li class="help">
                                        <a href="<?php echo LANGPATH; ?>/faqs">ПОМОЩИ</a>
                                    </li>
                                    <li class="help" id="customer_data">
                                        <a href="<?php echo LANGPATH; ?>/customer/login" id="customer_sign_in">РЕГИСТРАЦИЯ / ВОЙТИ</a>
                                        <div class="drop-down-hd hide" id="customer_signed">
                                            <i class="myaccount"></i>Здравствуйте, <span id="username"></span>!
                                        </div>
                                        <dl class="drop-down-list JS-showcon hide" style="display:none;">
                                            <dd class="drop-down-option">
                                                <a href="<?php echo LANGPATH; ?>/customer/summary">Личный кабинет</a>
                                            </dd>
                                            <dd class="drop-down-option">
                                                <a href="<?php echo LANGPATH; ?>/customer/orders">Мои Заказы</a>
                                            </dd>
                                            <dd class="drop-down-option">
                                                <a href="<?php echo LANGPATH; ?>/tracks/track_order">Отслеживать заказ</a>
                                            </dd>
                                            <dd class="drop-down-option">
                                                <a href="<?php echo LANGPATH; ?>/customer/wishlist">Мой Список Пожеланий</a>
                                            </dd>
                                            <dd class="drop-down-option">
                                                <a href="<?php echo LANGPATH; ?>/customer/profile">Мой Профиль</a>
                                            </dd>
                                            <dd class="drop-down-option">
                                                <a href="<?php echo LANGPATH; ?>/customer/logout">Выход</a>
                                            </dd>
                                        </dl>
                                    </li>
                                    <li class="mybag drop-down JS-show" id="mybagli1">
                                        <div class="drop-down-hd">
                                            <a class="bag-title" href="<?php echo LANGPATH; ?>/cart/view">Корзина</a>
                                            <a href="<?php echo LANGPATH; ?>/cart/view" class="rum cart_count">0</a>
                                        </div>
                                        <div class="mybag-box JS-showcon hide" style="display:none;">
                                            <span class="topicon" style="right: 23px;"></span>
                                            <div class="mybag-con">
                                                <h4 class="tit">КОРЗИНА ТОВАРЫ</h4>
                                                <p class="cart_bag_empty cart-empty-info" style="display:none;">Ваша корзина сейчас пуста.</p>
                                                <p class="cart_button_empty" style="display:none;">
                                                    <a href="<?php echo LANGPATH; ?>/cart/view" class="btn btn-primary btn-lg">Корзина</a>
                                                </p>
                                                <div class="items">
                                                    <ul class="cart_bag"></ul>
                                                </div>
                                                <div class="cart-all-goods">
                                                    <p>
                                                        <strong class="cart_count">2</strong>
                                                        <span class="cart_s"></span>товар в вашей корзине
                                                    </p>
                                                    <strong>Итого: <span class="cart_amount"></span></strong>
                                                </div>
                                                <p class="cart_button">
                                                    <a href="<?php echo LANGPATH; ?>/cart/view" class="btn btn-primary mr10" style="padding: 0px 5px;width:80%;">в корзину</a>
                                                    <!-- <a href="<?php //echo LANGPATH; ?>/cart/checkout" class="btn btn-primary">оформить</a> -->
                                                </p>
                                            </div>
                                            <p class="free-shipping free_shipping" style="display:none;">Добавьте 1+ товар С Пометкой "Бесплатная Доставка".</p>
                                            <p class="free-shipping sale_words" style="display:none;"></p>
                                        </div>
                                    </li>
                                    <li class="mybag" id="mybag1">
                                        <div class="currentbag mybag-box hide">
                                            <span class="topicon"></span>
                                            <div class="mybag-con">
                                                <h4 class="tit">Молодец! Товар добавлен в корзину. </h4>
                                                <div class="bag_items items mtb5">
                                                    <ul class="cart_bag">
                                                        <li></li>
                                                    </ul>
                                                    <p><a href="<?php echo LANGPATH; ?>/cart/view" class="btn btn-primary btn-lg">Посмотреть корзину</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div id="comm100-button-311" class="tp-livechat">
                                    <a href="#" onclick="openLivechat();return false;" id="livechatLink">
                                        <img src="<?php echo STATICURL; ?>/assets/images/livechat_online1.gif" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="nav-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-2 col-md-2">
                                <a class="logo" href="<?php echo LANGPATH;?>/" title=""><img src="<?php echo STATICURL; ?>/assets/images/2016/logo.png" alt=""></a>
                            </div>
                            <div class="col-sm-8 col-md-8">
                                <nav id="nav1" class="nav">
                                    <ul>
                                        <li class="JS-show p-hide">
                                            <a href="<?php echo LANGPATH;?>/daily-new/92">Новинки</a>
                                            <div class="nav-list JS-showcon hide" style="width:175px;">
                                                <span class="topicon tpn01"></span>
                                                <ul>
                                                    <li>
                                                        <dl>
                                        <?php    $newinarr = array(
                                                                array('Платья', '92'),
                                                                array('Пальто', '623'),
                                                                array('Трикотаж', '619'),
                                                                array('Куртки', '621'),
                                                                array('Боттомс', '240'),
                                                                array('Обувь', '53'),
                                                                array('Единичность', '626'),
                                                            //    array('Мужская Одежда', '631'),
                                                                array('Аксессуары', '52'),
                                                                
                                                            );  
                                                            ?>
                                                        <?php 
                                                        foreach ($newinarr as $link):  ?>
                                                                <dt style="text-transform: capitalize;" class="newin">
                                                                    <a href="<?php echo LANGPATH;?>/daily-new/<?php echo $link[1]; ?>">Новинки: 
                                                                    <?php
                                                                    echo $link[0];
                                                                    ?>
                                                                    </a>
                                                                </dt>
                                                              <?php
                                                          endforeach;
                                                            ?>
                                                        </dl>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="JS-show">
                                            <a href="<?php echo LANGPATH;?>/clothing-c-615">Одежда</a>
                                            <div class="nav-list JS-showcon hide op-w" style="width:700px;">
                                                <span class="topicon tpn02"></span>
                                                <ul>
                                                    <li>
                                                        <dl>
                                                            <dt><a href="<?php echo LANGPATH;?>/dresses-c-92">Платья</a></dt>
                                                            <?php
                                                            $links = array(
                                                                array('Платья Без Спины', 'backless-dress-c-456'),
                                                                array('Чёрные Платья', 'black-dresses-c-203'),
                                                                array('Нижние Платья', 'bodycon-dresses-c-211'),
                                                                array('Цветочные Платья', 'floral-dresses-c-108'),
                                                                array('Кружевные Платья', 'lace-dresses-c-209'),

                                                                array('Макси Платья', 'maxi-dresses-c-207'),
                                                                array('Оголяющие Плечо Платья', 'off-the-shoulder-dresses-c-504'),
                                                                array('Парадные Платья', 'party-dresses-c-205'),
                                                                 array('Платья Без Талии', 'shift-dresses-c-724'),
                                                                 array('Рубашка-Платья', 'shirt-dresses-c-725'),
                                                                                                        
                                                                array('Полосчатые Платья', 'stripe-dresses-c-652'),
                                                                array('Белые Платья', 'white-dresses-c-204'),
                                                                
                                                                
                                                            );
                                                            $hot_dresses = array("black-dresses-c-203","maxi-dresses-c-207","shirt-dresses-c-725","white-dresses-c-204");
                                                            foreach ($links as $link):
                                                                ?>
                                                                <dd><a href="<?php echo LANGPATH;?>/<?php echo $link[1]; ?>" <?php if(in_array($link[1],$hot_dresses)){ echo 'class="red"'; }?>><?php echo $link[0]; ?></a></dd>
                                                                <?php
                                                            endforeach;
                                                            ?>
                                                        </dl>
                                                        <dl>
                                                        <dt>
                                                            <a href="<?php echo LANGPATH;?>/swimwear-c-628">Купальники</a>
                                                        </dt>
                                                        <dt>
                                                            <a href="<?php echo LANGPATH;?>/two-piece-suit-c-177">Комплект</a>
                                                        </dt>
                                                    </dl>
                                                </li>
                                                <li>
                                                    <dl>
                                                        <dt>
                                                            <a href="<?php echo LANGPATH;?>/clothing-outerwear-c-623">Верхняя Одежда</a>
                                                        </dt>
                                                     <?php
                                                            $links = array(
                                                                array('Блейзер','blazers-c-624'),
                                                                array('Плащи и Крылатки','capes-ponchos-c-453'),
                                                                array('Пальто и Жакет','coats-jackets-c-45'),
                                                                array('Кожаная Куртка','leather-biker-jackets-c-120'),
                                                                array('Искусственный Мех','unreal-fur-c-285'),
                                                                array('Жилеты','outerwear-waistcoats-c-625'),
                                                            );
                                                            $hot_dresses=array("coats-jackets-c-45","unreal-fur-c-285");
                                                            ?>
                                                            <?php 
                                                            foreach ($links as $link):
                                                                ?>
                                                                <dd><a href="<?php echo LANGPATH;?>/<?php echo $link[1]; ?>" <?php if(in_array($link[1],$hot_dresses)){ echo 'class="red"'; }?>><?php echo $link[0]; ?></a></dd>
                                                                <?php
                                                            endforeach;
                                                            ?>
                                                    </dl>
                                                    <dl>
                                                        <dt>
                                                            <a href="<?php echo LANGPATH;?>/knitwear-sweaters-c-619">Трикотаж</a>
                                                        </dt>
                                                        <dd>
                                                            <a href="<?php echo LANGPATH;?>/cardigans-c-321">Кардиганы</a>
                                                        </dd>
                                                        <dd>
                                                            <a class="red" href="<?php echo LANGPATH;?>/jumpers-pullovers-c-622">Пуловеры И Свитеры</a>
                                                        </dd>
                                                    </dl>
                                                    <dl>
                                                        <dt>
                                                            <a href="<?php echo LANGPATH;?>/one-pieces-c-626">Единичность</a>
                                                        </dt>
                                                        <dd>
                                                            <a href="<?php echo LANGPATH;?>/rompers-playsuits-c-627">Спортивный Костюм</a>
                                                        </dd>
                                                        <dd>
                                                            <a href="<?php echo LANGPATH;?>/jumpsuits-c-230">Комбинезон</a>
                                                        </dd>
                                                        <dd>
                                                            <a href="<?php echo LANGPATH;?>/overalls-c-606">Брюки на лямках</a>
                                                        </dd>
                                                    </dl>
                                                    </li>

                                            <li>
                                                    <dl>
                                                        <dt>
                                                            <a href="<?php echo LANGPATH;?>/clothing-tops-c-621">КУРТКИ</a>
                                                        </dt>
                                                        <dd>
                                                            <a href="<?php echo LANGPATH;?>/t-shirts-c-245">Футболки</a>
                                                        </dd>
                                                        <dd>
                                                            <a href="<?php echo LANGPATH;?>/blouses-shirts-c-616">Рубашки и Блузки</a>
                                                        </dd>
                                                        <dd>
                                                            <a href="<?php echo LANGPATH;?>/bodysuits-c-250">Комбинезоны</a>
                                                        </dd>
                                                        <dd>
                                                            <a href="<?php echo LANGPATH;?>/camis-tanks-c-617">Майки</a>
                                                        </dd>
                                                        <dd>
                                                            <a class="red" href="<?php echo LANGPATH;?>/crop-tops-bralets-c-244">Топы и Лифчики</a>
                                                        </dd>
                                                        <dd>
                                                            <a href="<?php echo LANGPATH;?>/dress-tops-c-618">Платья</a>
                                                        </dd>
                                                        <dd>
                                                            <a href="<?php echo LANGPATH;?>/hoodies-sweatshirts-c-117">Толстовки с шапкой И Толстовки</a>
                                                        </dd>
														<dd>
                                                            <a href="<?php echo LANGPATH;?>/kimonos-c-414">Кимоно</a>
                                                        </dd>
                                                    </dl>
                                                    <dl>
                                                        <dt>
                                                            <a href="<?php echo LANGPATH; ?>/bottoms-c-240">БОТТОМС</a>
                                                        </dt>
                                                        <dd>
                                                            <a href="<?php echo LANGPATH;?>/jeans-c-49">Джинсы</a>
                                                        </dd>
                                                        <dd>
                                                            <a href="<?php echo LANGPATH;?>/leggings-c-232">Леггинсы</a>
                                                        </dd>
                                                        <dd>
                                                            <a href="<?php echo LANGPATH;?>/pants-c-233">Брюки</a>
                                                        </dd>
                                                        <dd>
                                                            <a  class="red" href="<?php echo LANGPATH;?>/skirt-c-99">Юбки</a>
                                                        </dd>
                                                        <dd>
                                                            <a href="<?php echo LANGPATH;?>/shorts-c-51">Шорты</a>
                                                        </dd>
                                                    </dl>
                                                    <dl>
                                                        <dt>
                                                            <a href="<?php echo LANGPATH;?>/menswear-c-631">МУЖСКАЯ ОДЕЖДА</a>
                                                        </dt>
                                                    </dl>
                                                    
                                                </li>
                                            
                                                <li class="last">
                                                    <dl>
                                                        <dl>
                                                        <?php
                                                        $cache_apparel_key = 'site_apparel_choies' .LANGUAGE;
                                                        $cacheins = Cache::instance('memcache');
                                                        $cache_apparel_content = $cacheins->get($cache_apparel_key);
                                                        if (isset($cache_apparel_content) AND !isset($_GET['cache'])){
                                                            $apparel_banners = $cache_apparel_content;
                                                        }else{
                                                           $apparel_banners = DB::select()->from('banners')->where('type', '=', 'apparel')->where('visibility', '=', 1)->where('lang', '=', LANGUAGE)->execute()->as_array();
                                                           $cacheins->set($cache_apparel_key, $apparel_banners, 3600);
                                                        }
                                                        ?>
                                                        <?php
                                                        if(!empty($apparel_banners[1]))
                                                        {
                                                        ?>
                                                          <a href="<?php echo $apparel_banners[1]['link']; ?>"><img src="<?php echo STATICURL; ?>/bimg/<?php echo $apparel_banners[1]['image']; ?>" width="190px" /></a>
                                                        <?php
                                                        }
                                                        ?>
                                                        </dl>
                                                    </dl>
                                                    <dl>
                                                        <dt>
                                                            КОЛЛЕКЦИЯ
                                                        </dt>
                                                        <dd class="italic">
                                                            <a href="<?php echo LANGPATH;?>/plus-size-c-737">Большой Размер</a>
                                                        </dd>
                                                        <dd class="italic">
                                                            <a href="<?php echo LANGPATH;?>/aw-2015-c-739">AW 2015</a>
                                                        </dd>
                                                        <dd class="italic">
                                                            <a href="<?php echo LANGPATH;?>/boutiques-c-738">Бутики</a>
                                                        </dd>
                                                        <dd class="italic">
                                                            <a href="<?php echo LANGPATH;?>/choies-design-c-607"><img src="<?php echo STATICURL; ?>/assets/images/choies-design-ru.png"></a>
                                                        </dd>
                                                        <dd class="italic">
                                                        </dd>
                                                        <dd class="italic">
                                                        </dd>
                                                        <dd class="italic">
                                                        </dd>
                                                        <dd class="italic">
                                                        </dd>
                                                    </dl>

                                                </ul>
                                            </div>
                                        </li>
                                        <li class="JS-show">
                                            <a href="<?php echo LANGPATH;?>/shoes-c-53">Обувь</a>
                                            <div class="nav-list JS-showcon hide" style="width:350px;">
                                                <span class="topicon tpn03"></span>
                                                <ul>
                                                    <li>
                                                        <dl>
                                                            <?php
                                                        $cache_shoes_key = 'site_shoes_choies' .LANGUAGE;
                                                        $cache_shoes_content = $cacheins->get($cache_shoes_key);
                                                        if (isset($cache_shoes_content) AND !isset($_GET['cache'])){
                                                            $shoes = $cache_shoes_content;
                                                        }else{
                                                            $shoes = DB::select('id')->from('products_category')->where('link', '=', 'shoes')->execute()->get('id');
                                                            $cacheins->set($cache_shoes_key,$shoes, 3600);
                                                        }
                                                            $shoes_catalogs = Catalog::instance($shoes)->children();
                                                            $hots=array(150);

                                                            foreach ($shoes_catalogs as $catalog):
                                                                ?>
                                                                <dt><a href="<?php echo Catalog::instance($catalog ,LANGUAGE)->permalink(); ?>"><?php echo ucfirst(Catalog::instance($catalog, LANGUAGE)->get('name')); ?></a></dt>
                                                                <?php
                                                            endforeach;
                                                            ?>
                                                        </dl>
                                                    </li>
                                            <li class="last">
                                                    <dl>
                                                        <dl>
                                                            <a href="<?php echo LANGPATH; ?>/product/black-suede-wedge-knee-boots_p18647">
                                                                <img src="<?php echo STATICURL; ?>/assets/images/1512/ASMX2027.jpg" ></a>
                                                        </dl>
                                                    </dl>
                                                </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="JS-show">
                                            <a href="<?php echo LANGPATH;?>/accessory-c-52">Аксессуары</a>
                                            <?php
                                            $cache_accessory_key = 'site_accessory_choies' .LANGUAGE;
                                            $cache_accessory_content = $cacheins->get($cache_accessory_key);
                                            if (isset($cache_accessory_content) AND !isset($_GET['cache'])){
                                                $accessory = $cache_accessory_content;
                                            }else{
                                            $accessory = DB::select('id')->from('products_category')->where('link', '=', 'accessory')->execute()->get('id');
                                            $cacheins->set($cache_accessory_key, $accessory, 3600);
                                            }
                                            $accessory_catalogs = Catalog::instance($accessory)->children();
                                            $count = count($accessory_catalogs);
                                            ?>
                                            <div class="nav-list JS-showcon hide" style="width: 525px;">
                                                <span class="topicon tpn04"></span>
                                                <ul>
                                                    <li>
                                                        <dl>
                                                            <dt><a href="<?php echo LANGPATH;?>/accessories-bags-c-641">Аксессуары И Сумки</a></dt>
                                                            <?php
                                                            $links = array(
                                                                array('Сумка', 'bags-c-643'),
                                                                array('Кошелек', 'purses-c-644'),
                                                                array('Перчатки', 'gloves-c-645'),
                                                                array('Шляпа И Шапка', 'hats-caps-c-55'),
                                                                array('Повязка На Глазах И Маски', 'eye-masks-c-647'),
                                                                array('Шарфы И Шали', 'scarves-snoods-c-57'),
                                                                array('Носки И Колготки', 'socks-tights-c-54'),
                                                                array('Солнцезащитные Очки', 'sunglasses-c-58'),
                                                                array('Аксессуары Для Волосов', 'hair-accessories-c-67'),
                                                                array('Парики', 'hair-extensions-c-646'),
                                                                array('Пояс', 'belts-c-59'),
                                                                array('Украшение Дома', 'home-decor-c-795'),
                                                            );
                                                            $hot=array("bags-c-643","scarves-snoods-c-57","home-decor-c-795");
                                                            foreach ($links as $link):
                                                                ?>
                                                                <dd><a href="<?php echo LANGPATH;?>/<?php echo $link[1]; ?>" <?php if(in_array($link[1],$hot)){ echo 'class="red"'; }?>><?php echo $link[0]; ?></a></dd>
                                                                <?php
                                                            endforeach;
                                                            ?>
                                                        </dl>
                                                    </li>

                                                    <li>
                                                        <dl>
                                        <?php   
                                            $cache_jewellery_key = 'site_jewellery_choies' .LANGUAGE;
                                            $cache_jewellery_content = $cacheins->get($cache_jewellery_key);
                                            if (isset($cache_jewellery_content) AND !isset($_GET['cache'])){
                                                $jewellery = $cache_jewellery_content;
                                            }else{
                                         $jewellery = DB::select('id')->from('products_category')->where('link', '=', 'jewellery')->execute()->get('id');
                                         $cacheins->set($cache_jewellery_key, $jewellery, 3600);
                                            }
                                            $jewellery_catalogs = Catalog::instance($jewellery)->children();  ?>
                                                            <dt><a href="<?php echo LANGPATH;?>/jewellery-c-638">Jewellery</a></dt>
                                                            <?php
                                                            $hots=array(639);
                                                            for($i = 0; $i < 11; $i++)
                                                            {
                                                                if (!isset($jewellery_catalogs[$i]))
                                                                    continue;
                                                                $catalog = $jewellery_catalogs[$i];
                                                                $clink = Catalog::instance($catalog ,LANGUAGE)->permalink();
                                                                ?>
                                                                <dd><a href="<?php echo $clink; ?>" <?php if(in_array($catalog,$hots)){ echo 'class="red"'; }?>><?php echo ucfirst(Catalog::instance($catalog,LANGUAGE)->get('name')); ?></a></dd>
                                                                <?php
                                                            }
                                                            ?>
                                                            <dd>
                                                            <?php
                                    $cache_accessory_banners_key = 'site_accessory_banners_choies' .LANGUAGE;
                                 $cache_accessory_banners_content = $cacheins->get($cache_accessory_banners_key);
                                            if (isset($cache_accessory_banners_content) AND !isset($_GET['cache'])){
                                                $accessory_banners = $cache_accessory_banners_content;
                                            }else{
                                                            $accessory_banners = DB::select()->from('banners')->where('type', '=', 'accessory')->where('visibility', '=', 1)->where('lang', '=', '')->execute()->as_array();
                                                            $cacheins->set($cache_accessory_banners_key,$accessory_banners, 3600);
                                                } ?>

                                                                </dd>
                                                            </dl>
                                                        </li>

                                            <li class="last">
                                                    <dl>
                                                    <?php
                                                            if(isset($accessory_banners[0]))
                                                            {
                                                            ?>
                                                                <a href="<?php echo LANGPATH;?><?php echo $accessory_banners[0]['link']; ?>"><img src="<?php echo STATICURL; ?>/bimg/<?php echo $accessory_banners[0]['image']; ?>" alt="<?php echo $accessory_banners[0]['alt']; ?>" kai="kai" title="<?php echo $accessory_banners[0]['title']; ?>" /></a>
                                                            <?php
                                                            }
                                                            ?>
                                                    </dl>
                                                    <dl>
                                                    <dd>
                                                    </dd>
                                                    <dd>
                                                    </dd>
                                                    <dd>
                                                    </dd>
                                                    <dd>
                                                    </dd>
                                                    <dd>
                                                    </dd>
                                                    <dd>
                                                    </dd>
                                                    </dl>
                                                </li>

                                                </ul>
                                            </div>
                                        </li>
                                        <li class="JS-show">
                                            <a href="<?php echo LANGPATH;?>/outlet-c-101" class="sale">Распродажа</a>
                                            <div class="nav-list JS-showcon hide" style="right:0; width: 350px;">
                                                <span class="topicon tpn05"></span>
                                                <ul>
                                                    <li>
                                                   <dl>
                                                        <dt><a href="<?php echo LANGPATH;?>/activity/flash_sale">FLASH SALE</a></dt>
                                                    </dl>
                                                <dl>
                                                        <dt>По цене</dt>
                                                        <dd>
                                                            <a class="red" href="<?php echo LANGPATH;?>/usd5-c-872">Ниже $5 </a>
                                                        </dd>
                                                        <dd>
                                                            <a href="<?php echo LANGPATH;?>/usd-9-c-415">Цена $9.9 </a>
                                                        </dd>
                                                    </dl>
                                                <dl>
                                                <dt><a href="<?php echo LANGPATH;?>/outlet-c-101">Outlet</a></dt>
                                                    </dl>                                              
                                                    </li>
                                                
                                                <?php
                                            $cache_activities_banners_key = 'site_activities_banners_choies' .LANGUAGE;
                                            $cache_activities_banners_content = $cacheins->get($cache_activities_banners_key);
                                     if (isset($cache_activities_banners_content) AND !isset($_GET['cache'])){
                                                $activities_banners = $cache_activities_banners_content;
                                            }else{
                                            $activities_banners = DB::select()->from('banners')->where('type', '=', 'activities')->where('visibility', '=', 1)->where('lang', '=', LANGUAGE)->execute()->as_array();
                                                $cacheins->set($cache_activities_banners_key, $activities_banners, 3600);
                                            }
                                                if(isset($activities_banners[1]))
                                                {
                                                ?>
                                                                            <li class="last">
                                                    <dl>
                                                    <a href="<?php echo $activities_banners[1]['link']; ?>"><img src="<?php echo STATICURL; ?>/bimg/<?php echo $activities_banners[1]['image']; ?>" alt="<?php echo $activities_banners[1]['alt']; ?>" title="<?php echo $activities_banners[1]['title']; ?>" /></a>
                                                </dl>
                                                <?php
                                                }
                                                ?>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="JS-show p-hide">
                                            <a href="#">Деятельность</a>
                                            <div class="nav-list JS-showcon hide" style="right:0; width:525px;">
                                                <span class="topicon tpn06"></span>
                                                <ul>
                                                    <li>
                                                        <dl>
                                                            <dt>Особенности</dt>
                                                            <!--<dd><a href="/freetrial/add">Free Trial Center</a></dd>-->
                                                            <dd><a href="<?php echo LANGPATH;?>/rate-order-win-100">ставки и выиграть $100</a></dd>
                                                            <dd><a href="<?php echo LANGPATH;?>/activity/flash_sale">FLASH SALE</a></dd>
                                                            <dd><a href="<?php echo LANGPATH;?>/ready-to-be-shipped">Отправить в течение 24 часов</a></dd>
                                                            <dd><a href="<?php echo LANGPATH;?>/top-sellers-c-32">TOP SELLERS</a></dd>
                                                        </dl>
                                                    </li>
                                                    <li>
                                                        <dl>
                                                            <dt>Тенденции</dt>
                                                            <dd><a href="<?php echo LANGPATH; ?>/activity/skirt_looks">Парад Юбок</a></dd>
                                                            <dd><a href="<?php echo LANGPATH;?>/holiday-dress-destination-c-868">ПЛАТЬЕ СЕРИЯ</a></dd>
                                                            <dd><a href="<?php echo LANGPATH;?>/fashion-editor-s-picks-topic-c-703">Выбор Модного Редактора</a></dd>
                                                            <dd><a href="<?php echo LANGPATH;?>/croptop-cami-kimono-romper-topic-c-702">Летние Необходимые</a></dd>
                                                            <dd><a href="<?php echo LANGPATH;?>/rompers-playsuits-c-627">Модный Комбинезон</a></dd>
                                                            <dd><a href="<?php echo LANGPATH;?>/valentine-s-day-sale-c-909">День святого Валентина</a></dd>
                                                            <dd><a href="<?php echo LANGPATH;?>/denim-style-in-c-719">Джинсовый Стиль</a></dd>
                                                            
                                                        </dl>
                                                    </li>
                                                    <li class="last">
                                                        <dl>
                                                            <dt><a href="<?php echo LANGPATH;?>/lookbook">Лукбук</a></dt>
                                                        </dl>
                                                        <?php if(isset($activities_banners[1])): ?>
                                                        <dl>
                                                            <dt><a href="<?php echo $activities_banners[0]['link']; ?>"><img src="<?php echo STATICURL; ?>/bimg/<?php echo $activities_banners[0]['image']; ?>" /></a></dt>
                                                        </dl>
                                                        <?php endif; ?>
                                                    </li>
                                                    <li style="width:350px; padding-left:0px;">
                                                        <dl>
                                                            <dt>Социальные И СМИ</dt>
                                                            <dd class="sns fix">
                                                                <a rel="nofollow" href="http://www.facebook.com/choiesclothing" target="_blank" class="sns1"></a>
                                                                <a rel="nofollow" href="http://twitter.com/#!/choiescloth" target="_blank" class="sns2"></a>
                                                                <a rel="nofollow" href="http://style-base.tumblr.com/" target="_blank" class="sns3"></a>
                                                                <a rel="nofollow" href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4"></a>
                                                                <a rel="nofollow" href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a>
                                                                <a rel="nofollow" href="http://www.chictopia.com/Choies" target="_blank" class="sns6"></a>
                                                                <a rel="nofollow" href="http://instagram.com/choiesclothing" target="_blank" class="sns7"></a>
                                                                <a rel="nofollow" href="http://blog.choies.com" target="_blank" class="sns8"></a>
                                                                <!--<a rel="nofollow" href="http://wanelo.com/store/choies" target="_blank" class="sns9"></a>-->
                                                            </dd>
                                                         </dl>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-sm-2 col-md-2">
                                <div class="search">
                                    <?php
                                        $searchword="";
                                        $cache_searchword_key = 'site_searchword_choies' .LANGUAGE;
                                        $cache_searchword_content = $cacheins->get($cache_searchword_key);
                                 if (isset($cache_searchword_content) AND !isset($_GET['cache'])){
                                            $searchword = $cache_searchword_content;
                                        }else{
                                        $searchword=DB::select('name')->from('search_hotword')->where('active', '=', 1)->where('type', '=', 1)->where('lang', '=', LANGUAGE)->where('site_id', '=', 1)->execute()->get('name');
                                        $cacheins->set($cache_searchword_key, $searchword, 3600);
                                       }
                                    ?>
                                    <form action="<?php echo LANGPATH;?>/search" method="get" id="search_form" onsubmit="return search(this);">
                                        <ul>
                                            <li>
                                                <input id="boss" name="searchwords" value="<?php echo $searchword; ?>" class="search-text text" onblur="if(this.value==''){this.value=this.defaultValue;}" onfocus="if(this.value=='<?php echo $searchword; ?>'){this.value='';};" type="search">
                                                <input value="" class="search-btn" type="submit"></li>
                                        </ul>
                                    </form>
                                    <script type="text/javascript">
                                        function search(obj)
                                        {
                                            var q = obj.searchwords.value;
                                            location.href = "<?php echo LANGPATH;?>/search/" + q.replace(/\s/g, '_');
                                            return false;
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="scroll-nav-wrapper" style="display:none;">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-1">
                                <a href="<?php echo LANGPATH;?>/" class="home nav-home"><i class="fa fa-home"></i></a>
                                
                            </div>
                            <div class="col-sm-8">
                                <nav id="nav2" class="nav"></nav>
                            </div>
                            <div  class="col-sm-3">
                                <div class="mybag drop-down JS-show" id="mybagli2"></div>
                                <div class="search"></div>
                            </div>
                        </div>
                    </div>
                </div>
                

                <!-- PHONE GAIBAN 2015.10.22 -->
                <div class="phone-navbar hidden-sm hidden-md hidden-lg">
                <div class="container">
                    <div class="row">
                        <div>
                            <nav class="navbar navbar-default" role="navigation">
                                <div >
                                    <!-- Toggle get grouped for better mobile display -->
                                    <div class="navbar-header">
                                        <div class="col-xs-6" style="padding:0;">
                                            <button type="button" class="navbar-toggle" id="phone-btn">
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                            </button>
                                            <a class="logo" href="<?php echo LANGPATH; ?>/" title=""><img src="<?php echo STATICURL; ?>/assets/images/2016/logo.png" alt=""></a>
                                        </div>
                                        <div class="col-xs-6" style="padding:0;">
                                            <!-- SEARCH -->
                                            <form action="/search" method="get" onsubmit="return search1('searchwords');">
                                                <div class="search-box">
                                                    <input type="search" name="searchwords" id="searchwords" class="form-control phone-search" style="padding-right:30px">
                                                    <a class="fa fa-search" onclick="return search1('searchwords');"></a>
                                                </div>
                                                <a href="<?php echo LANGPATH; ?>/cart/view" class="bag-phone-on"><span class="rum cart_count">0</span></a>
                                                <a href="<?php echo LANGPATH; ?>/customer/summary" class="log-phone"></a>
                                            </form>
                                            <script type="text/javascript">
                                                function search1(id){
                                                    var q = document.getElementById(id).value;
                                                    location.href = "<?php echo LANGPATH; ?>/search/" + q.replace(/\s/g, '_');
                                                    return false;
                                                }
                                            </script>
                                            <!-- SEARCH ENDING -->
                                        </div>
                                    </div>

                                    <!-- Collect the nav links, forms, and other content for toggling -->
                                    <nav class="navbar-collapse collapse">
                                        <!-- Contenedor -->
                                        <ul id="accordion" class="accordion">
                                            <li><div class="link">НОВИНКИ<i class="fa fa-chevron-down"></i></div>
                                                <ul class="submenu">
                                                   <?php
                                            $newinarr = array(
                                                                array('Платья', '92'),
                                                                array('Пальто', '623'),
                                                                array('Трикотаж', '619'),
                                                                array('Куртки', '621'),
                                                                array('Боттомс', '240'),
                                                                array('Обувь', '53'),
                                                                array('Единичность', '626'),
                                                            //    array('Мужская Одежда', '631'),
                                                                array('Ювелирные Изделия', '638'),
                                                                
                                                            );
                                                          //   array('Accessories', '52'),
                                                            //array('Swimwear', '628'),
                                                        // array('Co-ord Sets', '177'),
                                                     ?>
                                                     
                                                    <?php foreach ($newinarr as $link):  ?>
                                                    <li>
                                                        <a href="<?php echo LANGPATH;?>/daily-new/<?php echo $link[1]; ?>">Новинки: <?php echo $link[0]; ?>
                                                        </a>
                                                      </li>
                                                      <?php endforeach;?>
                                                </ul>
                                            </li>
                                            <li>
                                                <a style="color:#cd0000;" href="<?php echo LANGPATH; ?>/outlet-c-101"><div class="link" style="color:#cd0000;padding:10px 8px;">Распродажа</div></a>
                                            </li>
                                            <li>
                                                <div class="link"><span class="icon-collection">КОЛЛЕКЦИЯ</span><i class="fa fa-chevron-down"></i></div>
                                                <ul class="submenu">
                                                    <?php
                                                        $apparels_list = array(
                                                            'Посмотреть все' => '/clothing-c-615',
                                                            'Большой Размер' => '/plus-size-c-737 ',
                                                            'AW 2015' => '/aw-2015-c-739 ',
                                                            'Бутики' => '/boutiques-c-738 ',
                                                            'Choies Дизайн' => '/choies-design-c-607 ',
                                                        );
                                                        foreach($apparels_list as $name => $link)
                                                        {
                                                     ?>
                                                     <li><a href="<?php echo LANGPATH; ?><?php echo $link; ?>"><?php echo $name; ?></a></li>
                                                     <?php }?>
                                                </ul>
                                            </li>
                                            <li>
                                                <div class="link"><span class="icon-dresses">ПЛАТЬЯ</span><i class="fa fa-chevron-down"></i></div>
                                                <ul class="submenu">
                                                    <?php
                                                        $links = array(
                                                                array('Посмотреть все', 'dresses-c-92'),
                                                                array('Платья С Открытой Спиной', 'backless-dress-c-456'),
                                                                array('Черные Платья', 'black-dresses-c-203'),
                                                                array('Платья Бодикон', 'bodycon-dresses-c-211'),
                                                                array('Цветочные Платья', 'floral-dresses-c-108'),
                                                                array('Кружевные Платья', 'lace-dresses-c-209'),

                                                                array('Макси Платья', 'maxi-dresses-c-207'),
                                                                array('Оголяющий Плечо Платья', 'off-the-shoulder-dresses-c-504'),
                                                                array('Бальные Платья', 'party-dresses-c-205'),
                                                                array('Прямое Платья', 'shift-dresses-c-724'),
                                                                array('Рубашка-Платья', 'shirt-dresses-c-725'),
                                                                array('Полосчатые Платья', 'stripe-dresses-c-652'),
                                                                array('Белые Платья', 'white-dresses-c-204'),
                                                         );
                                                         $hot_dresses = array("black-dresses-c-203","maxi-dresses-c-207","shirt-dresses-c-725","white-dresses-c-204");
                                                         foreach ($links as $link):
                                                    ?>
                                                    <li><a href="<?php echo LANGPATH; ?>/<?php echo $link[1]; ?>" <?php if(in_array($link[1],$hot_dresses)){ echo 'class="red"'; }?>><?php echo $link[0]; ?></a></li>
                                                    <?php endforeach;?>
                                                </ul>
                                            </li>
                                            <li><div class="link"><span class="icon-tops">ТОПЫ</span><i class="fa fa-chevron-down"></i></div>
                                                <ul class="submenu">
                                                    <li><a href="<?php echo LANGPATH; ?>/clothing-tops-c-621">Посмотреть все</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/t-shirts-c-245">Футболки</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/blouses-shirts-c-616">Блузки и Рубашки</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/bodysuits-c-250">Боди</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/camis-tanks-c-617">Майки и Танки</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/two-piece-suit-c-177">Комплект</a></li>
                                                    <li><a class="red" href="<?php echo LANGPATH; ?>/crop-tops-bralets-c-244">Топы и Бюстгальтеры</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/dress-tops-c-618">Платье-топы</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/kimonos-c-414">Кимоно</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/knitwear-sweaters-c-619">Трикотаж</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/clothing-outerwear-c-623">Пальто</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/one-pieces-c-626">Единичность</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/swimwear-c-628">Купальники</a></li>
                                                </ul>
                                            </li>
                                            <li><div class="link"><span class="icon-bottoms">БОТТОМС</span><i class="fa fa-chevron-down"></i></div>
                                                <ul class="submenu">
                                                    <li><a href="<?php echo LANGPATH; ?>/bottoms-c-240">Посмотреть все</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/jeans-c-49">Джинсы</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/leggings-c-232">Леггинсы</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/pants-c-233">Брюки</a></li>
                                                    <li><a class="red" href="<?php echo LANGPATH; ?>/skirt-c-99">Юбки</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/shorts-c-51">Юбки-Шорты</a></li>
                                                </ul>
                                            </li>
                                            <li><div class="link"><span class="icon-shoes">ОБУВЬ</span><i class="fa fa-chevron-down"></i></div>
                                                <ul class="submenu">
                                                    <li><a href="<?php echo LANGPATH; ?>/shoes-c-53">Посмотреть Все</a></li>
                                                    <?php
                                                        $hots=array(150);
                                                        foreach ($shoes_catalogs as $shoe){
                                                    ?>
                                                    <li><a href="<?php echo Catalog::instance($shoe ,LANGUAGE)->permalink(); ?>" <?php if(in_array($shoe,$hots)){ echo 'class="red"'; }?>><?php echo ucfirst(Catalog::instance($shoe,LANGUAGE)->get('name')); ?></a></li>
                                                    <?php }?>
                                                </ul>
                                            </li>
                                            <li><div class="link"><span class="icon-jewellery">ДРАГОЦЕННОСТИ</span><i class="fa fa-chevron-down"></i></div>
                                                <ul class="submenu">
                                                    <?php
                                                        $links = array(
                                                                array('Посмотреть Все', 'jewellery-c-638'),
                                                                array('Кольцо', 'rings-c-62'),
                                                                array('Серьги', 'earrings-c-63'),
                                                                array('Браслет', 'bracelets-bangles-c-640'),
                                                                array('Колье И Ожерелье', 'neck-c-639'),
                                                                array('Анклет', 'anklets-c-650'),
                                                                array('Цепь Тела', 'body-harness-c-705'),
                                                        );
                                                        $hot=array("purses-c-644","sunglasses-c-58");
                                                        foreach ($links as $link):
                                                    ?>
                                                    <li><a href="<?php echo LANGPATH; ?>/<?php echo $link[1]; ?>" <?php if(in_array($link[1],$hot)){ echo 'class="red"'; }?>><?php echo $link[0]; ?></a></li>
                                                    <?php endforeach;?>
                                                </ul>
                                            </li>
                                            <li><div class="link"><span class="icon-acc">АКСЕССУАРЫ и СУМКИ</span><i class="fa fa-chevron-down"></i></div>
                                                <ul class="submenu">
                                                    <?php
                                                        $links = array(
                                                                array('Посмотреть Все', 'accessories-bags-c-641'),
                                                                array('Сумки', 'bags-c-643'),
                                                                array('Кошельки', 'purses-c-644'),
                                                                array('Перчатки', 'gloves-c-645'),
                                                                array('Шляпы и Шапки', 'hats-caps-c-55'),
                                                                array('Глазные Маски', 'eye-masks-c-647'),
                                                                array('Шарфы и Снуд', 'scarves-snoods-c-57'),
                                                                array('Носки и Колготки', 'socks-tights-c-54'),
                                                                array('Солнечные Очки', 'sunglasses-c-58'),
                                                                array('Аксессуары для Волос', 'hair-accessories-c-67'),
                                                                array('Наращивание волос', 'hair-extensions-c-646'),
                                                                array('Ремни', 'belts-c-59'),
                                                                array('Украшение Дома', 'home-decor-c-795'),
                                                        );
                                                        $hot=array("bags-c-643","scarves-snoods-c-57","home-decor-c-795");
                                                        foreach ($links as $link):
                                                    ?>
                                                    <li><a href="<?php echo LANGPATH; ?>/<?php echo $link[1]; ?>" <?php if(in_array($link[1],$hot)){ echo 'class="red"'; }?>><?php echo $link[0]; ?></a></li>
                                                    <?php endforeach;?>
                                                </ul>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!--　PHONE GAIBAN ENDING 2015.10.22-->

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
            <div id="comm100-button-311" class="bt-livechat visible-xs-block hidden-sm hidden-md hidden-lg">
                <a href="#" onclick="openLivechat();return false;" id="livechatLink">
                    <img src="<?php echo STATICURL; ?>/assets/images/livechat_online1.gif" />
                </a>
            </div>
                <div class="w-top container-fluid">
                    <div class="container">
                        <div class="currency visible-xs-block hidden-sm hidden-md hidden-lg xs-mobile">
                        <div class="row">
                            <div class="currency-con">
                                <div class="JS-toggle1">
                                    <a class="icon-flag icon-<?php echo strtolower($currency_now['name']); ?>"></a>
                                    <i class="fa fa-caret-down" style="padding-right:3px"></i>
                                    <span>
                                    <?php
                                    if(strpos($currency_now['code'], '$') !== False)
                                        $code_now = '$';
                                    else
                                        $code_now = $currency_now['code'];
                                    echo $code_now . $currency_now['name']; 
                                    ?>
                                    </span>
                                    <div class="currency-con JS-toggle-box1" style="display:none;">
                                    <dl class="sites">
                                    <form method="post" action="#">
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
                                       
                                            
                                                <dd  onclick="location.href='<?php echo LANGPATH; ?>/currency/set/<?php echo $currency['name'] ?>'"><a class="icon-flag icon-<?php echo strtolower($currency['name']); ?>" href="<?php echo LANGPATH; ?>/currency/set/<?php echo $currency['name'] ?>"><?php echo $currency['fname']; ?></a>
                                                </dd>
                                        <?php
                                        $key ++;
                                    }
                                    ?></form>
                                            </dl>
                                        
                                    </div>
                                </div>

                                <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-sites">
                                <?php
                                $key = 0;
                                foreach($lang_list as $lang => $path)
                                {
                                    if($path == LANGPATH)
                                        continue;
                                    if($key % 2 == 0)
                                    {
                                        ?>
                                        <dt><a href="<?php echo $path . $request; ?>">&bull;&nbsp;<?php echo $lang; ?>&nbsp;&nbsp;&nbsp;&nbsp;</a>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <a href="<?php echo $path . $request; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;<?php echo $lang; ?></a></dt>
                                        <?php
                                    }
                                    $key ++;
                                }
                                ?>
                                </dl>
                            </div>
                        </div>
                        </div>

                        <div class="fix row">
                            <dl class="hidden-xs col-sm-2">
                                <dt>Личный кабинет</dt>
                                <dd><a href="<?php echo LANGPATH; ?>/tracks/track_order">Отслеживать заказ</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/customer/orders">Мои Заказы</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/customer/profile">Мой Профиль</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/customer/points_history">Мои баллы</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/customer/wishlist">Избранное</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/vip-policy">VIP статус</a></dd>
                                <dd><a data-reveal-id="myModal8" class="getfeed1">Фидбэк</a></dd>
                            </dl>
                            <dl class="hidden-xs col-sm-2">
                                <dt>Помощь</dt>
                            <dd><a href="<?php echo LANGPATH; ?>/faqs">ЧЗВ</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/contact-us">Контакт с нами</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/payment">Платеж</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/coupon-points">Купон и баллы</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/shipping-delivery">Отправка и доставка</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/returns-exchange">Возврат и oбмен</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/conditions-of-use">Условия использования</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/how-to-order">Как Заказать</a></dd>
                            </dl>
                            <dl class="hidden-xs col-sm-2">
                            <dt>Популярный</dt>
                            <dd><a href="<?php echo LANGPATH; ?>/lookbook">Лукбук</a></dd>
                            <!--<dd><a href=" echo LANGPATH; /freetrial/add">Бесплатная доставка</a></dd>-->
                            <dd><a href="<?php echo LANGPATH; ?>/activity/flash_sale">FLASH SALE</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/wholesale">Оптовая торговля</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/affiliate-program">Партнёрская программа</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/blogger/programme">Блоггер хочет</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/rate-order-win-100" style="color:red;">ставки и выиграть $100</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/important-notice">Choies Примечание</a></dd>
                            </dl>
                            <dl class="hidden-xs col-sm-2">
                                <dt>Все сайты</dt>
                                <dd><a href="<?php echo $request; ?>">Английский сайт</a></dd>
                                <dd><a href="/es<?php echo $request; ?>">Испанский сайт</a></dd>
                                <dd><a href="/fr<?php echo $request; ?>">Французкий сайт</a></dd>
                                <dd><a href="/de<?php echo $request; ?>">Немецкий сайт</a></dd>
                                <dd><a href="/ru<?php echo $request; ?>">Россиский сайт</a></dd>
                            </dl>
                            <dl class="hidden-xs col-sm-4">
                                <dt class="hidden-xs">Найти Нас На</dt>
                                <dl class="sns">
                                    <dd><a rel="nofollow" href="http://www.facebook.com/choiescloth" target="_blank" class="sns1" title="facebook"></a></dd>
                                    <dd><a rel="nofollow" href="http://twitter.com/#!/choiescloth" target="_blank" class="sns2" title="twitter"></a></dd>
                                    <dd><a rel="nofollow" href="http://style-base.tumblr.com/" target="_blank" class="sns3" title="tumblr"></a></dd>
                                    <dd><a rel="nofollow" href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4" title="youtube"></a></dd>
                                    <dd><a rel="nofollow" href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a></dd>
                                    <dd><a rel="nofollow" href="http://www.chictopia.com/Choies" target="_blank" class="sns6" title="chictopia"></a></dd>
                                    <dd><a rel="nofollow" href="http://instagram.com/choiesclothing" target="_blank" class="sns7" title="instagram"></a></dd>
                                </dl>
                                <dl class="letter">
                                    <form action="" method="post" id="letter_form">
                                        <label class="hidden-xs">Подпишитесь на нашу электронную почту</label>
                                        <div>
                                            <input type="text" id="letter_text" class="text fll" value="Адрес Почты" onblur="if(this.value==''){this.value=this.defaultValue;}"  onfocus="if(this.value=='Адрес Почты'){this.value='';};" />
                                            <input type="submit" id="letter_btn" value="Дальше" class="btn btn-primary" />
                                        </div>
                                    </form>
                                </dl>
                                <div class="red" id="letter_message"></div>
                                <script language="JavaScript">
                                    $(function() {
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
                                            var message = data['message'];
                                            message = message.replace('You are in Now. Thanks', 'Вы сейчас находитесь. Спасибо！');
                                            message = message.replace('Sorry, email has been used', 'Извините, этот электронной почты был использован.');
                                            message = message.replace('Please enter a valid email address', 'Заполните действительный адрес электронной почты.');
                                            $("#letter_message").html(message);
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
                            </dl>
                            
                            <dl class="col-xs-12  xs-mobile hidden-sm hidden-md hidden-lg">                         
                                <dl class="letter">
                                    <form action="" method="post" id="letter_form1">
                                        <div>
                                            <input id="letter_text1" class="text" value="Подпишитесь на нашу электронную почту" onblur="if(this.value==''){this.value=this.defaultValue;}" onfocus="if(this.value=='Подпишитесь на нашу электронную почту'){this.value='';};" type="text">
                                            <input id="letter_btn1" value="ПОДАТЬ" class="btn btn-primary" type="submit">
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
                                            message = message.replace('You are in Now. Thanks', 'Вы сейчас находитесь. Спасибо！');
                                            message = message.replace('Sorry, email has been used', 'Извините, этот электронной почты был использован.');
                                            message = message.replace('Please enter a valid email address', 'Заполните действительный адрес электронной почты.');
                                            $("#letter_message").html(message);
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
                                <dl class="sns">
                                    <dd><a rel="nofollow" href="http://www.facebook.com/choiescloth" target="_blank" class="sns1" title="facebook"></a></dd>
                                    <dd><a rel="nofollow" href="http://twitter.com/#!/choiescloth" target="_blank" class="sns2" title="twitter"></a></dd>
                                    <dd><a rel="nofollow" href="http://style-base.tumblr.com/" target="_blank" class="sns3" title="tumblr"></a></dd>
                                    <dd><a rel="nofollow" href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4" title="youtube"></a></dd>
                                    <dd><a rel="nofollow" href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a></dd>
                                    <dd><a rel="nofollow" href="http://www.chictopia.com/Choies" target="_blank" class="sns6" title="chictopia"></a></dd>
                                    <dd><a rel="nofollow" href="http://instagram.com/choiesclothing" target="_blank" class="sns7" title="instagram"></a></dd>
                                </dl>
                            </dl>                           
                            
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <dt style="text-transform: capitalize;"><a href="<?php echo LANGPATH; ?>/customer/summary">Личный кабинет&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/tracks/track_order">&nbsp;Отслеживать заказ&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/customer/orders">&nbsp;Мои Заказы</a></dt>
                            </dl>
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <dd><a data-reveal-id="myModal8" class="getfeed1" style="color:#444;">Фидбэк&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/vip-policy" style="color:#444;">&nbsp;VIP статус&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/contact-us" style="color:#444;">&nbsp;Контакт с нами&nbsp;</a></dd>
                            </dl>  
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                            <dt style="text-transform: capitalize;"><a href="<?php echo LANGPATH; ?>/lookbook" style="color:#444;">#Лукбук</a>
                            </dl>  

                            
                        </div>
                        <div class="card  hidden-xs container">
                            <p class="paypal-card container">
                                <img usemap="#Card" src="<?php echo STATICURL; ?>/assets/images/card-12-8.jpg">
                                <map id="Card" name="Card">
                                <area target="_blank" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=<?php echo URLSTR; ?>&lang=en" coords="88,2,193,62" shape="rect">
                                </map>
                            </p>
                        </div>
                        <div class="copyright visible-xs-block hidden-sm hidden-md hidden-lg">
                            <p>Copyright © 2006-2015 Choies.com </p>
                            <p class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <a href="<?php echo LANGPATH; ?>/about-us">О Нас&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/conditions-of-use">&nbsp;Условия использования&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/privacy-security">&nbsp;Конфиденциальность И Безопасность</a>
                            </p>
                        </div>
                    </div>
                    <div class="copyr hidden-xs">
                        <p class="bottom container-fluid">Copyright © 2006-2015 Choies.com&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo LANGPATH; ?>/privacy-security">Конфиденциальность И Безопасность</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo LANGPATH; ?>/about-us">О Нас</a>
                        </p>
                    </div>
                </div>
            </footer>
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
                                $("#think1 .failed1 p").html("Пожалуйста, введите действительный адрес электронной почты!");
                                $("#think1 .success1").hide();
                                $("#wingray3").remove();
                                $(".reveal-modal-bg").fadeOut();
                            }
                            else if(data['success'] == -1)
                            {
                                $("#think1 .failed1").show();
                                $("#think1 .failed1 p").html("Не больше, чем 5 отзывов в 24 часов!");
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
                                $("#think1 .failed1 p").html("Пожалуйста, введите действительный адрес электронной почты!");
                                $("#think1 .success1").hide();
                                $("#wingray3").remove();
                                $(".reveal-modal-bg").fadeOut();
                            }
                            else if(data['success'] == -1)
                            {
								$("#think1 .failed1").show();
                                $("#think1 .failed1 p").html("Не больше, чем 5 отзывов в 24 часов!");
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
                    <div class="fll text1">CHOIES ХОЧЕТ СЛЫШАТЬ ВАШ ГОЛОС!</div>
                </div>
                <div class="clearfix"></div>
                <div class="point ml15 mt5">
                    Вы можете получить  
                    <strong class="red">$5 </strong> баллов награда после предоставления обратной связи
                </div>
                <div class="feedtab">
                    <ul class="feedtab-nav JS-tab1">
                        <li class="current">Фидбэк</li>
                                <li>Проблема?</li>
                    </ul>
                    <div class="feedtab-con JS-tabcon1">
                        <div class="bd">
                            <form id="feedbackForm" method="post" action="#" class="form formArea">
                                <ul>
                                    <li>
                                        <label for="My Suggestion:">Choies,это то, что мне нравится:  </label>
                                        <textarea name="what_like" id="what_like" rows="3" class="input textarea"></textarea>
                                    </li>
                                    <li>
                                        <label for="My Suggestion:"><span>*</span>Choies, я думаю, что вы можете сделать лучше:  <span class="errorInfo clear hide">Bitte schreiben Sie hier etwas.</span></label>
                                        <textarea name="do_better" id="do_better" rows="5" class="input textarea"></textarea>
                                    </li>
                                    <li>
                                        <label for="Адрес Почты:"><span>*</span>  Адрес электронной почты:<span class="errorInfo clear hide">Предоставьте адрес электронной почты,пожалуйста.</span>
                                        </label>
                                        <input type="text" name="email" id="f_email1" class="text text-long" value="" maxlength="340">
                                    </li>
                                    <li>
										<input type="submit" class="btn btn-primary btn-lg" value="ДАЛЬШЕ"></li>
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
                                                required:"Пожалуйста, предоставьте электронная почта.",
                                                email:"Пожалуйста, введите действительный адрес электронной почты."
                                            },
                                            do_better: {
                                                required: "Ваш отзыв не может быть получен!",
												minlength: "Пожалуйста, введите не менее 5 символов."
                                            }
                                    }
                                });
                            </script>
                        </div>
                        <div class="bd hide">
                            <form id="problemForm" method="post" action="#" class="form formArea">
                                <ul>
                                    <li>
                                        <label><span>*</span> Вам помочь? Пожалуйста, опишите проблему:<span class="errorInfo clear hide">Bitte schreiben Sie hier etwas.</span></label>
                                        <textarea name="comment" id="f_comment" rows="7" class="input textarea"></textarea>
                                    </li>
                                    <li>
                                        <label><span>*</span> Адрес электронной почты:<span class="errorInfo clear hide">Предоставьте адрес электронной почты,пожалуйста.</span><br>
                                        </label>
                                        <input type="text" name="email1" id="f_email2" class="text text-long" value="" maxlength="340">
                                    </li>
                                    <li>
										<input type="submit" data-reveal-id="myModal9" class="btn btn-primary btn-lg" value="ДАЛЬШЕ"></li>
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
                                                required:"Пожалуйста, предоставьте электронная почта.",
                                                email:"Пожалуйста, введите действительный адрес электронной почты."
                                            },
                                            comment: {
                                                 required: "Ваш отзыв не может быть получен!",
												minlength: "Пожалуйста, введите не менее 5 символов."
                                            }
                                    }
                                });
                            </script>
                             <p class="mt10">Более подробные вопросы? Пожалуйста, <a href="#" onclick="openLivechat();return false;" title="contact us" target="_blank">свяжитесь с нами</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="think1" style="display:none">
                <div class="success1">
                <h3>Спасибо!</h3>
                        <p><em>Ваш фидбэк был получен !</em></p>
                </div>
                <div class="failed1">
                    <h3>К сожалению!</h3>
                    <p></p>
                </div>
            </div>
			</div>
            <?php }?>
        </div>
        <script src="<?php echo Site::instance()->version_file('/assets/js/common.js'); ?>"></script>
        <script src="<?php echo Site::instance()->version_file('/assets/js/slider.js'); ?>"></script>

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
            ScarabQueue.push(['cart', [
            <?php
            $num = 1;
            foreach($cart['products'] as $key => $product)
            {
                $sku = Product::instance($product['id'])->get('sku');
            ?>
                {item: '<?php echo $sku;  ?>', price: <?php echo round($product['price'], 2); ?>, quantity: <?php echo $product['quantity'] ?>},
            <?php $num ++;}?>
             ]]);

            function ajax_cart()
            {
                $.ajax({
                    type: "POST",
                    url: "/<?php echo LANGUAGE; ?>/cart/ajax_cart",
                    dataType: "json",
                    data: "",
                    success: function(msg){
                        if(msg['count'] > 0)
                        {
                            $(".cart_count").text(msg['count']);
                            if(msg['count'] > 1)
                                $(".cart_s").html('');
                            else
                                $(".cart_s").html('');
                            $(".cart-all-goods").show();
                          var cart_view = msg['cart_view'];
                                cart_view = cart_view.replace(/Item:/g, 'Товар:');
                                cart_view = cart_view.replace(/Size:/g, 'Размеры:');
                                cart_view = cart_view.replace(/Quantity:/g, 'Количество:');
                            //    cart_view = cart_view.replace(/one size/g, 'только один размер');
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
                            }
                            else
                            {
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
                ?>
                <script type="text/javascript">
                    var google_tag_params = {
                        ecomm_prodid: '',
                        ecomm_pagetype: '<?php echo $type; ?>',
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
            ?>
                
            <?php 
            if($user_id){
            $user_session = Session::instance()->get('user');
            $email = $user_session['email'];
            ?>
            <script type="text/javascript">ScarabQueue.push(['setEmail', '<?php echo $email; ?>']);</script>
            <script type="text/javascript">
/*            varpageTracker=_gat._getTracker("UA-32176633-1");
            pageTracker._setVar('register');//设置用户分类
            pageTracker._trackPageview();*/
            </script>
            <?php } ?>
            <script type="text/javascript">ScarabQueue.push(['go']);</script>
            <!-- HK ScarabQueue statistics Code -->

            <!-- <script src="//cdn.optimizely.com/js/557241246.js"></script> -->
        </div>

           <?php 
        $user_id = Customer::logged_in();
        $usermark = Kohana_Cookie::get('usermark');
        $usermark123 = Kohana_Cookie::get('usermark123');
        $utm_medium = Arr::get($_GET, 'utm_medium');
        if(!$usermark && !$usermark123 && !$user_id && $utm_medium != 'edmwp'){
    ?>
    <!-- 注册有礼 ADD TIME 2015、9、23 -->    

    <div id="register-modal" class="reveal-modal register-gift JS-popwincon1 hidden-xs regfreehide" style="border-radius:0;" >
        <a class="close-reveal-modal close-btn3 JS-close2"></a>
        <div class="register-right">
            <span style="font-size:20px"><b>Зарегистрируйся, чтобы Выиграть </b></span> 
            <p style="font-size:15px"> У регистратора в Choies теперь  <span class="red">100%</span><br> Шанс выиграть <span class="red">один бесплатный подарок</span>.</p>
            <form class="register-form" action="#" method="post">
                <label><i>* Email</i></label>
                <input type="text" class="register-gift-text valuemail" placeholder="Ваш email" name="email" value=""/><br/>
                <b id="message" style="color:#cc3300;margin-top:10px"></b>
                <input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" type="submit" id="btnval" value="ВОЙТИ ">
            </form>
            <p class="gift-no"><a class="JS-close2">Нет, Спасибо. Я хочу следовать своим путем! </a></p>
        </div>
    </div>

    <!-- 手机端输入账号 -->
    <div id="register-modal-phone" class="register-gift-phone JS-popwincon1 hidden-sm hidden-md hidden-lg regfreehide" style="border-radius:0;">
        <a class="close-reveal-modal close-btn3 JS-close2"></a>
        <div class="register-right">
            <h3>Зарегистрируйся, чтобы Выиграть</h3>
            <p>У регистратора в Choies теперь есть <span class="red">100%</span> Шанс выиграть <span class="red">один бесплатный подарок</span>.</p>
            <form class="register-form-phone" action="#" method="post">
                <label><i>* E-mail </i></label>
                <input type="text" class="register-gift-text valuemail" placeholder="Ваш email " name="email" value="">
                <input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" type="submit" value="ВОЙТИ ">
            </form>
            <p class="gift-no"><a class="JS-close2">Нет, Спасибо. Я хочу следовать своим путем!  </a></p>
        </div>
    </div>

    <!-- 输入密码部分 -->
    <div id="gift-modal" class="reveal-modal register-gift register-gift-2 JS-popwincon1 hidden-xs regfreeshow" style="border-radius:0;display:none;">
        <a class="close-reveal-modal close-btn3 JS-close2"></a>
        <div class="img-left">
            <ul>
                <?php 
                //$free = DB::query(Database::SELECT, 'select * from products where sku in("SA0843", "BA0844") order by id desc')->execute()->as_array();
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
                        <!--<li class="mt10"><div class="img-select hide"><img src="../images/gift-select.png" alt=""></div><img src="../images/SHOE1215A461B.jpg" alt=""><p><span class="red">$0.00&nbsp;&nbsp;</span><span><del>$9.99</del></span></p></li>-->
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
        <script>
            var product_id = $(".select56352").attr("data-id");//产品id
            $("#gift-modal").find("li").click(function(){
                product_id = $(this).attr("data-id");//选中赋忿
                $(this).addClass("select").children("div").removeClass("hide");
                $(this).siblings().removeClass("select").children("div").addClass("hide");
            })
        </script>
        <div class="register-right">
            <span style="font-size:22px"><b style="color:red">БЕСПЛАТНЫЕ ПОДАРКИ</b></span>
            <span style="font-size:20px"><b>для Новичка!</b></span>
            <p class="mt20">Пожалуйста, выберите один из пунктов от левого и установьте пароль ниже.</p>
            <form class="mt20 gift-form" action="#" method="post">
                <label><i>* Пароль</i></label>
                <input type="password" class="register-gift-text userpwd" placeholder="6-24 символов" name="password" value="">
                <input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" type="submit" value="ЗАЯВИТЬ">
            </form>
        </div>
    </div>

    <!-- 注册部分 -->
    <div id="gift-modal-phone" class="reveal-modal register-gift register-gift-2-phone JS-popwincon1 hidden-sm hidden-md hidden-lg" style="border-radius:0;display:none">
        <a class="close-reveal-modal close-btn3 JS-close2"></a>
        <div class="register-right" style="margin-top:0;padding:0;">
            <span style="font-size:22px"><b style="color:red">БЕСПЛАТНЫЕ ПОДАРКИ </b></span>
            <span style="font-size:20px"><b>для Новичка!</b></span>
            <p class="mt20"><span style="font-size:12px"> Пожалуйста, выберите один из пунктов от левого и установьте пароль ниже. </span></p>
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
                <label><i>*Пароль </i></label>
                <input type="password" class="register-gift-text userpwd" placeholder="6-24 символов" name="password" value="">
                <input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" type="submit" value="ЗАЯВИТЬ ">
            </form>
        </div>
    </div>
    <div class="reveal-modal-bg JS-filter1" style="display: block;"></div>
    <!-- 注册有礼结束 -->
    <?php }?>
    <?php Kohana_Cookie::set("usermark123",'user', time()+3600*96);?>
    <script>
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
                    required: "Пожалуйста, введите ваш адрес электронной почты.",
                    email:"пожалуйста, введите действительный адрес электронной почты."
                }
            },
            submitHandler: function(form) {  
                //Check user email
                var valuemail = $(".register-form").find(".valuemail").val();
                $.post('/cart/ajax_chkuser', {email:valuemail}, function(re){
                    if(re == "isset"){
                        alert("прости, почтовый ящик, вы вошли, уже там!");
                        return false;
                    }else if(re == "emailerror"){
                        alert("пожалуйста, введите действительный адрес электронной почты.");
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
                    required: "Пожалуйста, введите ваш адрес электронной почты.",
                    email:"пожалуйста, введите действительный адрес электронной почты."
                }            
            },
            submitHandler: function(form) {       

                //Check user email
                var valuemail = $(".register-form-phone").find(".valuemail").val();
                $.post('/cart/ajax_chkuser', {email:valuemail}, function(re){
                    if(re == "isset"){
                        alert("прости, почтовый ящик, вы вошли, уже там!");
                        return false;
                    }else if(re == "emailerror"){
                        alert("пожалуйста, введите действительный адрес электронной почты.");
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
                        required: "Пожалуйста, укажите пароль.",
                        minlength: "Пароль должен между 6-24 символов.",
                        maxlength: "Пароль должен между 6-24 символов."
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
                        required: "Пожалуйста, укажите пароль.",
                        minlength: "Пароль должен между 6-24 символов.",
                        maxlength: "Пароль должен между 6-24 символов."
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
                        $("#customer_data").attr("class","drop-down JS-show");
                    }
                   
                }
            });
        }
        //用户登录信息ajax加载 --- wanglong 2015-12-16
    </script>
        
    </body>
</html>