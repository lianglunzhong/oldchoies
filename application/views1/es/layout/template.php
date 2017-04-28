<!DOCTYPE html>
<html xml:lang="<?php echo LANGUAGE; ?>">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" id="viewport" name="viewport">
        <title><?php echo $title; ?></title>
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
                                    <ul class="drop-down-list cs-list" >

                                    <?php
                                    foreach($lang_list as $lang => $path)
                                    {
                                        if ($lang == "Español" || $lang=="Русский")
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
                                        <p class="title"><strong class="cart_count">0</strong> artículo<span class="cart_s"></span></p>
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
                                            <p>Total: <strong class="cart_amount"> $180.00</strong></p>
                                        </div>
                                        <div class="view-check">
                                            <a href="<?php echo LANGPATH;?>/cart/view" class="btn btn-default">VER MI BOLSA & PAGAR</a>
                                            <p class="free-shipping free_shipping" style="display:none;">Añadir 1+ artículo marcado "Free Shipping" <br>para disfrutar envío gratis por todo el pedido</p>
                                            <p class="free-shipping sale_words" style="display:none;"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="reg-sin flr">
                                <div id="customer_sign_in" class="out">
                                    <a href="<?php echo LANGPATH; ?>/customer/login">ACCEDER</a>
                                </div>
                                <div id="customer_signed" class="drop-down cs-show hide" style="display: none;">
                                    <div class="drop-down-hd" id="customer_signed">
                                        <span id="username"></span>
                                    </div>
                                    <ul class="drop-down-list cs-list" >
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/customer/orders">Mis Pedidos</a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/tracks/track_order">Rastrear</a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/customer/wishlist">Mi Lista de Deseos</a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/customer/profile">Mi Perfil</a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/customer/logout">Salir</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
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
                                        <a href="<?php echo LANGPATH;?>/daily-new/week2">NOVEDADES</a>
                                        <div class="nav-list cs-list">
                                            <span class="downicon tpn01"></span>
                                            <div class="nav-box">
                                                <div class="nav-list01 fll">
                                                    <dl class="nav-ul">
                                                        <dt class="title">COMPRAR POR</dt>
                                                        <dd><a href="<?php echo LANGPATH;?>/daily-new/week2">Esta semana</a></dd>
                                                        <dd><a href="<?php echo LANGPATH;?>/daily-new/week1">La semana pasada</a></dd>
                                                        <dd><a href="<?php echo LANGPATH;?>/daily-new/month">El mes pasado</a></dd>
                                                        <dd style="display:none;"><a href="<?php echo LANGPATH;?>/new-presale-c-1012">Preventa</a></dd>
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
                                    <li class="cs-show" style="width:13%;">
                                        <a href="<?php echo LANGPATH;?>/clothing-c-615">ROPA</a>
                                        <div class="nav-list cs-list" style="margin-left:-100%;">
                                            <span class="downicon tpn02"></span>
                                            <div class="nav-box">
                                                <div class="nav-list03 fll">
                                                    <dl class="nav-ul01">
                                                        <dt class="title">COMPRAR POR CATÁLOGO</a></dt>
                                                            <?php
                                                            $links = array(
                                                                
                                                                array('Vestidos', 'dresses-c-92'),
                                                                array('Pantalones y Leggins', 'pants-leggings-c-975'),
                                                                array('Trajes de baño y Ropa de playa', 'swimwear-beachwear-c-178'),
                                                                array('Abrigos', 'coats-c-953'),
                                                                array('Monos crotos y Monos largos', 'rompers-jumpsuits-c-970'),
                                                                array('Chaquetas', 'jackets-c-947'),
                                                                array('Tops', 'clothing-tops-c-621'),
                                                                array('Vaqueros', 'jeans-c-49'), 
                                                                array('Faldas', 'skirt-c-99'),
                                                                array('Shorts', 'shorts-c-51'),
                                                                array('Conjuntos', 'suits-co-ords-c-1002'), 
                                                                array('Prendas de punto', 'sweaters-knits-c-961'),
                                                                array('Ver Todas Ropas', 'clothing-c-615'),
                                                                 
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
                                    <li class="cs-show" style="width:13%;">
                                        <a href="<?php echo LANGPATH;?>/shoes-c-53">ZAPATOS</a>
                                        <div class="nav-list cs-list" style="margin-left:-200%;">
                                            <span class="downicon tpn03"></span>
                                            <div class="nav-box">
                                                <div class="nav-list03 fll">
                                                    <dl class="nav-ul01">
                                                        <dt class="title">COMPRAR POR CATÁLOGO</a></dt>
                                                            <?php
                                                            $links = array(
                                                                
                                                                array('Planos', 'flats-c-152'),
                                                                array('Sandalias', 'sandals-c-150'),
                                                                array('Plataforma', 'platforms-c-151'),
                                                                array('Zapatos con cordónes', 'lace-up-shoes-c-1007'),
                                                                array('Zapatos de tacón', 'heels-c-636'),
                                                                array('Botas', 'boots-c-149'),
                                                                array('Zapatos deportivos', 'sports-shoes-c-1008'),
                                                                array('Ver Todos Zapatos', 'shoes-c-53'),
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
                                    
                                    <li class="cs-show" style="width:13%;">
                                        <a href="<?php echo LANGPATH;?>/accessory-c-52">ACCESORIOS</a>
                                        <div class="nav-list cs-list" style="margin-left:-300%;">
                                            <span class="downicon tpn04"></span>
                                            <div class="nav-box">
                                                <div class="nav-list03 fll">
                                                    <dl class="nav-ul01">
                                                        <dt class="title">COMPRAR POR CATÁLOGO</a></dt>
                                                            <?php
                                                            $links = array(
                                                                
                                                                array('Bolsos y Monederos', 'bags-wallets-c-1016'),
                                                                array('Sombreros', 'hats-caps-c-55'),
                                                                array('Joyas', 'jewellery-c-638'),
                                                                array('Gafas de sol', 'sunglasses-c-58'),
                                                                array('Bufandas', 'scarves-snoods-c-57'),
                                                                array('Guantes', 'gloves-c-645'),
                                                                array('Calcetínes y Medias', 'socks-tights-c-54'),
                                                                array('Accesorios para el pelo', 'hair-accessories-c-67'),
                                                                array('Cinturones', 'belts-c-59'),
                                                                array('Decoración del hogar', 'home-decor-c-795'),
                                                                array('Belleza', 'beauty-c-1019'),
                                                                array('Ver Todos Accesarios', 'accessory-c-52'),
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
                                  <a href="#">BELLEZA</a>
                                  <div class="nav-list cs-list" style="margin-left:-400%;">
                                      <span class="downicon tpn05"></span>
                                      <div class="nav-box">
                                          <div class="nav-list03 fll">
                                              <dl class="nav-ul01">
                                                  <dd><a href="">Belleza</a></dd>
                                                  <dd><a href="">Pelo</a></dd>
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
                                      </li>   -->                                  
                                    <li class="cs-show p-hide" style="width:22%;">
                                        <a href="javascript:void(0)">GALAXIA DE CHOIES</a>
                                        <div class="nav-list cs-list" style="margin-left:-236%;width: 454.5454545%;">
                                            <span class="downicon tpn06"></span>
                                            <div class="nav-box">
                                                <div class="nav-list01 fll">
                                                    <dl class="nav-ul">
                                                          <?php
                                                            $links = array(
                                                                array('Fiesta de la música','music-festivals-edit-c-1020'),
                                                                array('Estilo boho chic','boho-chic-c-1024'),
                                                                array("Estilo de la escuela de los 90's",'90-s-school-style-c-1022'),
                                                                array("Tendencia minimalista de los 90's",'90-s-minimal-style-c-1023'),
                                                                array('Denim','denim-style-in-c-719'),
                                                                array('Estilos de Rayas Clásico','classic-stripe-styles-c-1106'),
                                                                array('Estilos de Hombro Descubierto','off-the-shoulder-styles-c-1125'),
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
                                    <li class="cs-show" style="width:13%;">
                                        <a href="<?php echo LANGPATH; ?>/outlet-c-101" class="sale">REBAJAS</a>
                                        <div class="nav-list cs-list" style="margin-left:-570%;">
                                            <span class="downicon tpn006"></span>
                                                <div class="nav-box">
                                                    <div class="nav-list01 fll">
                                                        <dl class="nav-ul01">
                                                            <dd><a href="/es/only-9-c-1170">Sólo $9.90</a></dd><br>
                                                            <dd><a href="/es/only-19-c-1171">Sólo $19.90</a></dd><br>
                                                            <dd><a href="/es/only-29-c-1172">Sólo $29.90</a></dd><br>
                                                            <dd><a href="/es/outlet-c-101">Outlet</a></dd><br>
                                                            <dd><a href="/es/activity/flash_sale">Flash sale</a></dd><br>
                                                            <dd><a href="/es/summer-clearance-c-451">Liquidación Verano</a></dd>
                                                        </dl>
                                                    </div>
                                                    <div class="nav-list02 fll">
                                                            <a href="/es/outlet-c-101">
                                                            <img src="<?php echo STATICURL;?>/assets/images/es/1609/sale_banner_es.jpg" class="navigation_banner6"></a>
                                                    </div>
                                                </div>
                                        </div>
                                    </li>
                                    <li class="cs-show" style="width:13%">
                                        <a href="<?php echo LANGPATH; ?>/wholesale">WHOLESALE</a>
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
                                <span>CATEGORÍA</span>
                                <span class="myaccount"><a href="<?php echo LANGPATH;?>/customer/summary">Mi Cuenta</a></span>
                            </div>
                        </li>
                        <li><div class="link"><span>NOVEDADES</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Volver</span></a></li>
                                                   <?php
                                            $newinarr = array(
                                                                array('Esta semana', 'week2'),
                                                                array('La semana pasada', 'week1'),
                                                                array('El mes pasado', 'month'),
                                                            );
                                                     ?>
                                                     
                                                    <?php foreach ($newinarr as $link):  ?>
                                                    <li>
                                                        <a href="<?php echo LANGPATH;?>/daily-new/<?php echo $link[1]; ?>">Novedades: <?php echo $link[0]; ?>
                                                        </a>
                                                      </li>
                                                      <?php endforeach;?>
                                                    <li style="display:none;"><a href="<?php echo LANGPATH;?>/new-presale-c-1012">Preventa</a></li>
                            </ul> 
                        </li>
                        <li>
                            <div class="link"><span class="icon-collection">GALAXIA DE CHOIES</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Volver</span></a></li>
                                                    <?php
                                                        $apparels_list = array(
                                                            'Fiesta de la música' => '/music-festivals-edit-c-1020',
                                                            'Estilo boho chic' => '/boho-chic-c-1024',
                                                            "Estilo de la escuela de los 90's" => '/90-s-school-style-c-1022',
                                                            "Tendencia minimalista de los 90's" => '/90-s-minimal-style-c-1023',
                                                            'Denim' => '/denim-style-in-c-719',
                                                            'Estilos de Rayas Clásico' => '/dclassic-stripe-styles-c-1106',
                                                            'Estilos de Hombro Descubierto' => '/off-the-shoulder-styles-c-1125',
                                                        );
                                                        foreach($apparels_list as $name => $link)
                                                        {
                                                     ?>
                                                     <li><a href="<?php echo LANGPATH; ?><?php echo $link; ?>"><?php echo $name; ?></a></li>
                                                     <?php }?>
                            </ul>
                        </li>
                        <li>
                            <div class="link"><span class="icon-dresses">VESTIDOS</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Volver</span></a></li>
                                                    <?php
                                                        $links = array(
                                                                array('Ver todos', 'dresses-c-92'),
                                                                array('Vestidos sin Espalda', 'backless-dress-c-456'),
                                                                array('Vestidos Negros', 'black-dresses-c-203'),
                                                                array('Vestidos Ajustados', 'bodycon-dresses-c-211'),
                                                                array('Vestidos Florales', 'floral-dresses-c-108'),
                                                                array('Vestidos de Encaje', 'lace-dresses-c-209'),
                                                                array('Vestidos Largos', 'maxi-dresses-c-207'),
                                                                array('Vestidos al Aire', 'off-the-shoulder-dresses-c-504'),
                                                                array('Vestidos de Fiesta', 'party-dresses-c-205'),
                                                                array('Vestidos Sueltos', 'shift-dresses-c-724'),
                                                                array('Vestidos Camiseros', 'shirt-dresses-c-725'),
                                                                array('Vestidos a Rayas', 'stripe-dresses-c-652'),
                                                                array('Vestidos Blancos', 'white-dresses-c-204'),
                                                         );
                                                         $hot_dresses = array("black-dresses-c-203","maxi-dresses-c-207","shirt-dresses-c-725","white-dresses-c-204");
                                                         foreach ($links as $link):
                                                    ?>
                                                    <li><a href="<?php echo LANGPATH;?>/<?php echo $link[1]; ?>" <?php if(in_array($link[1],$hot_dresses)){ echo 'class="red"'; }?>><?php echo $link[0]; ?></a></li>
                                                    <?php endforeach;?>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-tops">TOPS</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Volver</span></a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/clothing-tops-c-621">Ver todos</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/t-shirts-c-245">Camisetas</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/blouses-shirts-c-616">Blusas & Camisas</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/bodysuits-c-250">Body</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/camis-tanks-c-617">Camisola & Chaleco</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/two-piece-suit-c-177">Conjuntos</a></li>
                                                    <li><a class="red" href="<?php echo LANGPATH; ?>/crop-tops-bralets-c-244">Tops Cortos</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/dress-tops-c-618">Tops Largos</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/kimonos-c-414">Kimonos</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/knitwear-sweaters-c-619">Prendas de Punto</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/clothing-outerwear-c-623">Prendas Exteriores</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/one-pieces-c-626">Prendas de una Pieza</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/swimwear-c-628">Bañadores</a></li>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-bottoms">PARTES DE ABAJO</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Volver</span></a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/bottoms-c-240">Ver todos</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/jeans-c-49">Vaqueros</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/leggings-c-232">Leggings</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/pants-c-233">Pantalones</a></li>
                                                    <li><a class="red" href="<?php echo LANGPATH; ?>/skirt-c-99">Faldas</a></li>
                                                    <li><a href="<?php echo LANGPATH; ?>/shorts-c-51">Shorts</a></li>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-shoes">ZAPATOS</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Volver</span></a></li>
                                                         <?php
                                                            $links = array(
                                                                array('Todos zapatos', 'shoes-c-53'),
                                                                array('Planos', 'flats-c-152'),
                                                                array('Sandalias', 'sandals-c-150'),
                                                                array('Plataforma', 'platforms-c-151'),
                                                                array('Zapatos de tacón', 'heels-c-636'),
                                                                array('Botas', 'boots-c-149'),
                                                            );
                                                            foreach ($links as $link)
                                                            {
                                                                ?>
                                                            <li><a href="<?php echo LANGPATH;?><?php echo $link[1]; ?>"><?php echo $link[0]; ?></a></li>
                                                            <?php }?>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-jewellery">JOYAS</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Volver</span></a></li>
                                                    <?php
                                                        $links = array(
                                                                array('Ver todos', 'jewellery-c-638'),
                                                                array('Anillos', 'rings-c-62'),
                                                                array('Pendientes', 'earrings-c-63'),
                                                                array('Pulseras', 'bracelets-bangles-c-640'),
                                                                array('Collares', 'neck-c-639'),
                                                                array('Pulseras de Tobillo', 'anklets-c-650'),
                                                                array('Accesorio para Cuerpo', 'body-harness-c-705'),
                                                        );
                                                        $hot=array("purses-c-644","sunglasses-c-58");
                                                        foreach ($links as $link):
                                                    ?>
                                                    <li><a href="<?php echo LANGPATH;?><?php echo $link[1]; ?>" <?php if(in_array($link[1],$hot)){ echo 'class="red"'; }?>><?php echo $link[0]; ?></a></li>
                                                    <?php endforeach;?>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-acc">ACCESORIOS & BOLSOS</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Volver</span></a></li>
                                                    <?php
                                                        $links = array(
                                                                array('Ver todos', 'accessories-bags-c-641'),
                                                                array('Bolsos', 'bags-c-643'),
                                                                array('Monederos', 'purses-c-644'),
                                                                array('Guantes', 'gloves-c-645'),
                                                                array('Sombreros & Gorros', 'hats-caps-c-55'),
                                                                array('Máscaras de Ojos', 'eye-masks-c-647'),
                                                                array('Bufandas & Cuello Snoods', 'scarves-snoods-c-57'),
                                                                array('Calcetínes & Medias', 'socks-tights-c-54'),
                                                                array('Gafas del Sol', 'sunglasses-c-58'),
                                                                array('Joyas para el Pelo', 'hair-accessories-c-67'),
                                                                array('Pelucas', 'hair-extensions-c-646'),
                                                                array('Cinturóns', 'belts-c-59'),
                                                                array('Decoración del Holgar', 'home-decor-c-795'),
                                                                array('Esmalte de uñas', 'nails-c-460'),
                                                        );
                                                        $hot=array("purses-c-644","sunglasses-c-58");
                                                        foreach ($links as $link):
                                                    ?>
                                                    <li><a href="<?php echo LANGPATH;?><?php echo $link[1]; ?>" <?php if(in_array($link[1],$hot)){ echo 'class="red"'; }?>><?php echo $link[0]; ?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </li>
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
                                            <a class="logo" href="<?php echo LANGPATH;?>/" title=""><img src="<?php echo STATICURL;?>/assets/images/2016/logo-moblie.png" alt=""></a>
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
                            <label class="">ENTÉRATE DE TODO</label>
                            <div>
                                <input type="text" class="signin-input" id="letter_text" class="text fll" value="Introduzca su dirección de correo electrónico para recibir las noticias" onblur="if(this.value==''){this.value=this.defaultValue;}" onfocus="if(this.value=='Introduzca su dirección de correo electrónico para recibir las noticias'){this.value='';};">
                                <input type="submit" id="letter_btn" value="SUSCRIBIRSE" class="btn btn-default">
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
                                                '<?php echo LANGPATH;?>/newsletter/ajax_add', {
                                                    email: email
                                                },
                                                function(data) {
                                                    var message = data['message'];
                                                    message = message.replace('You are in Now. Thanks!', 'Usted se ha suscrito con éxito.');
                                                    message = message.replace('Sorry, email has been used', 'Lo sentimos, el correo electrónico se ha utilizado');
                                                    message = message.replace('Please enter a valid email address', 'Proporcione una dirección de Email');
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
                        <div class="footer-s">
                            <span>REDES SOCIALES</span>
                            <ul class="footer-sns">
                                <li><a  href="https://www.facebook.com/choiescloth" target="_blank"  title="facebook">
                                    <i class="fa fa-facebook"></i></a></li>
                                <li><a  href="https://twitter.com/choiescloth" target="_blank"  title="twitter">
                                    <i class="fa fa-twitter"></i>
                                </a></li>
                                <li><a  href="https://www.youtube.com/user/choiesclothes" target="_blank"  title="youtube">
                                    <i class="fa fa-youtube-play"></i>
                                </a></li>
                                <li><a  href="http://style-base.tumblr.com/" target="_blank"  title="tumblr">
                                    <i class="fa fa-tumblr"></i>
                                </a></li>
                                <li><a  href="https://www.instagram.com/choiesclothing/" target="_blank"  title="instagram">
                                    <i class="fa fa-instagram"></i>
                                </a></li>
                                <li><a  href="https://www.pinterest.com/choiesfashion/" target="_blank"  title="pinterest">
                                    <i class="fa fa-pinterest"></i>
                                </a></li>
                                <li><a  href="http://choies.studentbeans.com" target="_blank" title="pinterest">
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
                                <li class="col-xs-3"><a class="shipping-icon" href="<?php echo LANGPATH;?>/shipping-delivery"><span></span>OPCIONES DE ENVÍOS</a></li>
                                <li class="col-xs-3"><a class="returns-icon" href="<?php echo LANGPATH;?>/returns-exchange"><span></span>DEVOLUCIONES</a></li>
                                <li class="col-xs-3"><a class="size-icon" href="<?php echo LANGPATH;?>/size-guide"><span></span>GUÍA DE TALLA</a></li>
                                <li class="col-xs-3"><a class="membership-icon" href="<?php echo LANGPATH;?>/vip-policy"><span></span>SOCIOS</a></li>
                            </ul>
                        </div>
                        <div class="footer-context">
                            <dl>
                                <dt>Sobre nosotros</dt>
                                <dd><a href="<?php echo LANGPATH;?>/about-us">Quiénes somos</a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/affiliate-program">Afiliados</a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/blogger/programme">Bloggers</a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/Copyright-Infringement-Notice">Aviso de Copyright</a></dd>
                            </dl>
                            <dl>
                                <dt>Ayuda</dt>
                                <dd><a href="<?php echo LANGPATH;?>/contact-us">Contáctenos</a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/faqs">FAQs</a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/important-notice">Tablón de anuncios</a></dd>
								<dd><a href="<?php echo LANGPATH;?>/how-to-order">Como realizar un pedido</a></dd>
                            </dl>
                            <dl>
                                <dt>Guía de compras</dt>
                                <dd><a href="<?php echo LANGPATH;?>/payment">Pago</a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/coupon-points">Cupones</a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/brand/brandpage">Lista de Marca</a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/wholesale">Venta al por mayor</a></dd>
                            </dl>
                            <dl>
                                <dt>ACEPTAMOS</dt>
                                <dd><img src="<?php echo STATICURL;?>/assets/images/2016/card-0630.jpg"></dd>
                            </dl>
                        </div>
                    </div>              
                </div>
            </div>
            <div class="footer-bottom hidden-xs">
                <p>
                    <a href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en" target="_blank"><img src="<?php echo STATICURL;?>/assets/images/2016/card-N.jpg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;© 2006-2016 CHOIES.COM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo LANGPATH;?>/privacy-security">POLÍTICA DE PRIVACIDAD</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo LANGPATH;?>/conditions-of-use">TÉRMINOS Y CONDICIONES</a> 
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
                            <dl class="hidden-xs col-sm-2">
                                <dt>MI CUENTA</dt>
                                <dd><a href="<?php echo LANGPATH; ?>/tracks/track_order">Rastrear Tu Pedido</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/customer/orders">Historial de Pedidos</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/customer/profile">Configuración de la Cuenta</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/customer/points_history">Historial de Puntos</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/customer/wishlist">Lista de Artículos Deseados</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/vip-policy">Política VIP</a></dd>
                                <dd><a data-reveal-id="myModal8" class="getfeed1">Feedback</a></dd>
                            </dl>
                            <dl class="hidden-xs col-sm-2">
                                <dt>CENTRO DE AYUDA</dt>
                                <dd><a href="<?php echo LANGPATH; ?>/faqs">FAQ</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/contact-us">Contáctenos</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/payment">Pago</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/shipping-delivery">Envío y Entrega</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/coupon-points">Cupónes y Puntos</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/returns-exchange">Devolución y Cambio</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/conditions-of-use">Condiciones de Uso</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/how-to-order">Cómo Realizar un Pedido</a></dd>
                            </dl>
                            <dl class="hidden-xs col-sm-2">
                                <dt>DESTACADO</dt>
                                <dd><a href="<?php echo LANGPATH; ?>/lookbook">Lookbook</a></dd>
                                <!--<dd><a href=" echo LANGPATH; /freetrial/add">Centro De Prueba Gratuita</a></dd>-->
                                <dd><a href="<?php echo LANGPATH; ?>/activity/flash_sale">Flash Sale</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/wholesale">Venta al por Mayor</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/affiliate-program">Programa de Afiliados</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/blogger/programme">Blogger de Moda</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/rate-order-win-100" style="color:red;">Calificalo para Ganar $100</a></dd>
                                <dd><a href="<?php echo LANGPATH; ?>/important-notice">Aviso de Choies</a></dd>
                            </dl>
                            <dl class="hidden-xs col-sm-2">
                                <dt>TODOS LOS SITIOS</dt>
                                <?php
                                foreach($lang_list as $lang => $path)
                                {
                                ?>  
                                <dd><a href="<?php echo $path . $request; ?>"><?php echo $lang; ?></a></dd>
                                <?php
                                }
                                ?>
                                </dl>
                            </dl>
                            <dl class="hidden-xs col-sm-4">
                                <dt class="hidden-xs">Encuéntranos en</dt>
                                <dl class="sns">
                                    <dd><a  href="http://www.facebook.com/choiescloth" target="_blank" class="sns1" title="facebook"></a></dd>
                                    <dd><a  href="http://twitter.com/#!/choiescloth" target="_blank" class="sns2" title="twitter"></a></dd>
                                    <dd><a  href="http://style-base.tumblr.com/" target="_blank" class="sns3" title="tumblr"></a></dd>
                                    <dd><a  href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4" title="youtube"></a></dd>
                                    <dd><a  href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a></dd>
                                    <!--<dd><a  href="http://www.chictopia.com/Choies" target="_blank" class="sns6" title="chictopia"></a></dd>-->
                                    <dd><a  href="http://instagram.com/choiesclothing" target="_blank" class="sns7" title="instagram"></a></dd>
                                    <dd><a  href="http://choies.studentbeans.com" target="_blank" class="sns10" title="instagram"></a></dd>
                                </dl>
                            </dl>
                            
                            <dl class="col-xs-12  xs-mobile hidden-sm hidden-md hidden-lg">                         
                                <dl class="letter">
                                    <form action="" method="post" id="letter_form1">
                                        <div>
                                            <input id="letter_text1" class="text" value="SUSCRIBETE A NUESTROS BOLETINES" onblur="if(this.value==''){this.value=this.defaultValue;}" onfocus="if(this.value=='SUSCRIBETE A NUESTROS BOLETINES'){this.value='';};" type="text">
                                            <input id="letter_btn1" value="PRESENTAR" class="btn btn-primary" type="submit">
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
                                                    message = message.replace('You are in Now. Thanks', 'Usted está en ahora. Gracias');
                                                    message = message.replace('Sorry, email has been used', 'Lo sentimos, el correo electrónico se ha utilizado');
                                                    message = message.replace('Please enter a valid email address', 'Proporcione una dirección de Email.');
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
                                <dt>CONTÁCTENOS</dt>
                                <dd><a  href="http://www.facebook.com/choiescloth" target="_blank" class="sns1" title="facebook"></a></dd>
                                <dd><a  href="http://twitter.com/#!/choiescloth" target="_blank" class="sns2" title="twitter"></a></dd>
                                <dd><a  href="http://style-base.tumblr.com/" target="_blank" class="sns3" title="tumblr"></a></dd>
                                <dd><a  href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4" title="youtube"></a></dd>
                                <dd><a  href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a></dd>
                                <!--<dd><a  href="http://www.chictopia.com/Choies" target="_blank" class="sns6" title="chictopia"></a></dd>-->
                                <dd><a  href="http://instagram.com/choiesclothing" target="_blank" class="sns7" title="instagram"></a></dd>
                            </dl>    
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <dt style="text-transform: capitalize;"><a href="<?php echo LANGPATH; ?>/customer/summary">MI CUENTA&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/tracks/track_order">&nbsp;Rastrear&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/customer/orders">&nbsp;Mis Puntos</a></dt>
                            </dl>                        
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <dd><a href="<?php echo LANGPATH; ?>/about-us" style="color:#444;">Sobre Nosotros&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/vip-policy" style="color:#444;">&nbsp;Socios&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/contact-us" style="color:#444;">&nbsp;Contáctenos&nbsp;</a></dd>
                            </dl>  


                            
                        </div>
                        <div class="card  hidden-xs container">
                            <p class="paypal-card container">
                                <img usemap="#Card" src="<?php echo STATICURL; ?>/assets/images/card-12-8.jpg">
                                <map id="Card" name="Card">
                                <area target="_blank" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en" coords="88,2,193,62" shape="rect">
                                </map>
                            </p>
                        </div>
                        <div class="copyright visible-xs-block hidden-sm hidden-md hidden-lg">
                            <p>Copyright © 2006-2016 Choies.com </p>
                            <p class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <a href="<?php echo LANGPATH; ?>/conditions-of-use">&nbsp;Términos & Condiciones&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/privacy-security">&nbsp;Privacidad y Seguridad</a>
                            </p>
                        </div>
                    </div>
                    <div class="copyr hidden-xs">
                        <p class="bottom container-fluid">Copyright © 2006-2015 Choies.com&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo LANGPATH; ?>/privacy-security">Política de privacidad</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo LANGPATH; ?>/about-us">Sobre Nosotros</a>
                        </p>
                    </div>
                </div>
            </footer>
            <div id="comm100-button-311" class="home-right-icons es-icons hidden-xs">
                <a href="#" onclick="openLivechat();return false;"><span class="live-chat-icon"></span></a>
                <a href="<?php echo LANGPATH;?>/contact-us"><span class="email-us-icon"></span></a>
            </div>
            <div id="gotop" class="hide ">
                <a href="#" class="xs-mobile-top a-es"></a>
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
                        if(do_better==''){
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
                                $("#think1 .failed1 p").html("¡Por favor introduzca una dirección de email válida! ");
                                $("#think1 .success1").hide();
                                $("#wingray3").remove();
                                $(".reveal-modal-bg").fadeOut();
                            }
                            else if(data['success'] == -1)
                            {
                                $("#think1 .failed1").show();
                                $("#think1 .failed1 p").html("No puedes dejar 5 comentarios en 24 horas.");
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
                                $("#think1 .failed1 p").html("¡Por favor introduzca una dirección de email válida! ");
                                $("#think1 .success1").hide();
                                $("#wingray3").remove();
                                $(".reveal-modal-bg").fadeOut();
                            }
                            else if(data['success'] == -1)
                            {
                                $("#think1 .failed1").show();
                                $("#think1 .failed1 p").html("No puedes dejar 5 comentarios en 24 horas.");
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
                    <div class="fll text1">¡CHOIES QUIERE OÍR TU VOZ!</div>
                </div>
                <div class="clearfix"></div>
                <div class="point ml15 mt5">
                    Los que proporcionan evaluaciones significativas pueden obtener 
                    <strong class="red">$5 puntos</strong> de recompensa.
                </div>
                <div class="feedtab">
                    <ul class="feedtab-nav JS-tab1">
                        <li class="current">FEEDBACK</li>
                        <li class="">PREGUNTA?</li>
                    </ul>
                    <div class="feedtab-con JS-tabcon1">
                        <div class="bd">
                            <form id="feedbackForm" method="post" action="#" class="form formArea">
                                <ul>
                                    <li>
                                        <label for="My Suggestion:">Choies,es lo que me gusta: </label>
                                        <textarea name="what_like" id="what_like" rows="3" class="input textarea"></textarea>
                                    </li>
                                    <li>
                                        <label for="My Suggestion:"><span>*</span> Choies, creo que se puede hacer mejor: <span class="errorInfo clear hide">Los campos obligatorios.</span></label>
                                        <textarea name="do_better" id="do_better" rows="5" class="input textarea"></textarea>
                                    </li>
                                    <li>
                                        <label for="Email:"><span>*</span> Dirección de Email:<span class="errorInfo clear hide">Proporcione una dirección de Email.</span>
                                        </label>
                                        <input type="text" name="email" id="f_email1" class="text text-long" value="" maxlength="340">
                                    </li>
                                    <li>
                                        
                                         <input type="submit" class="btn btn-primary btn-lg" value="PRESENTAR"></li>
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
                                            required:"Por favor proporcione un correo electrónico.",
                                            email:"Por favor introduzca una dirección de email válida."
                                        },
                                        do_better: {
                                            required: "Este campo es requerido.",
                                            minlength: "El contenido debe ser de al menos 5 caracteres."
                                        }
                                    }
                                });
                            </script>
                        </div>
                        <div class="bd hide">
                            <form id="problemForm" method="post" action="#" class="form formArea">
                                <ul>
                                    <li>
                                        <label><span>*</span> ¿Necesita ayuda? Por favor, describa el problema: <span class="errorInfo clear hide">Please write something here.</span></label>
                                        <textarea name="comment" id="f_comment" rows="7" class="input textarea"></textarea>
                                    </li>
                                    <li>
                                        <label><span>*</span> Email:<span class="errorInfo clear hide">Please enter your email.</span><br>
                                        </label>
                                        <input type="text" name="email1" id="f_email2" class="text text-long" value="" maxlength="340">
                                    </li>
                                    <li>
                                        <input type="submit" data-reveal-id="myModal9" class="btn btn-primary btn-lg" value="PRESENTAR"></li>
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
                                            required:"Por favor proporcione un correo electrónico.",
                                            email:"Por favor introduzca una dirección de email válida."
                                        },
                                        comment: {
                                            required: "Este campo es requerido.",
                                            minlength: "El contenido debe ser de al menos 5 caracteres."
                                        }
                                    }
                                });
                            </script>
                             <p class="mt10">¿Mas pregunta detallada? Por favor <a href="#" onclick="openLivechat();return false;" title="Contáctenos" target="_blank">Contáctenos</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="think1" style="display:none">
                <div class="success1">
                    <h3>¡Graias!</h3>
                    <p><em>Su Feedback se ha recibido !</em></p>
                </div>
                <div class="failed1">
                    <h3>Perdón!</h3>
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
                            if(msg['count'] > 1)  
                            {
                                $(".es_count").html('s');
                                $(".cart_s").html('s');                                
                            }                       
                            else
                            {
                                $(".cart_s").html('');
                                $(".es_count").html('');                                
                            }

                            $(".cart-all-goods").show();
                            var cart_view = msg['cart_view'];
                            cart_view = cart_view.replace(/Item:/g, 'Artikel:');
                            cart_view = cart_view.replace(/Size:/g, 'Talla:');
                            cart_view = cart_view.replace(/Quantity:/g, 'Cantidad:');
                        //    cart_view = cart_view.replace(/one size/g, 'talla única');
                            cart_view = cart_view.replace(/%off/g, '%menos');
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
                                if ($p_cart['save'])
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
            if($user_id){
                $user_session = Session::instance()->get('user');
                $email = $user_session['email'];
            } ?>

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
            <p style="margin-top:110px;line-height:30px;">Disculpe, usted se ha registrado con la cuenta de Facebook.</p>
        </div>
    </div>

    <div id="gift-modal-fb-phone" class="register-gift-phone JS-popwincon1 hidden-sm hidden-md hidden-lg" style="border-radius:0;display:none;visibility:visible;background:#fff;">
        <a class="close-reveal-modal close-btn3 JS-close2"></a>
        <div class="register-right">
            <p style="margin-top:90px;line-height:30px;">Disculpe, usted se ha registrado con la cuenta de Facebook.</p>
        </div>
    </div>

    <div id="register-modal" class="reveal-modal register-gift JS-popwincon1 hidden-xs regfreehide" style="border-radius:0;" >
        <a class="close-reveal-modal close-btn3 JS-close2"></a>
        <div class="register-left"></div>
        <div class="register-right">
            <h3 style="font-size:22px;"><b>Registrate para Ganar</b></h3>
            <br/>
            <p style="font-size:14px;">Únete a nosotros ahora para conseguir la<span class="red">100%</span><br/>oportunidad de<span class="red"> ganar un regalo gratuito</span>.</p>
            <form class="register-form" action="#" method="post">
                <label><i>* Email</i></label>
                <input id="register-gift-email" type="text" class="register-gift-text valuemail" placeholder="Tu email " name="email" value=""/><br/>
                <b id="message" style="color:#cc3300;margin-top:10px"></b>
                <input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" type="submit" id="register-get" value="CONSEGUIR ">
            </form>
            <?php
            $redirect = Arr::get($_GET, 'redirect', '/es/');
            $page = isset($_SERVER['HTTP_SELF']) ? 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_SELF'] . '/' . htmlspecialchars($redirect) : 'http://' . $_SERVER['HTTP_HOST'] . '/' . htmlspecialchars($redirect);
            $facebook = new facebook();
            $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
            ?>
            <a href="<?php echo $loginUrl;?>" class="register-gift-btn" onclick="return setcookiefb();">Acceder con Facebook</a>
            <p class="gift-no"><a class="JS-close2">NO,GRACIAS.DÉJEME HACER LA COMPRA.</a></p>
        </div>
    </div>

    <!-- 手机端输入账号 -->
    <div id="register-modal-phone" class="register-gift-phone JS-popwincon1 hidden-sm hidden-md hidden-lg regfreehide" style="border-radius:0;">
        <a class="close-reveal-modal close-btn3 JS-close2"></a>
        <div class="register-right">
            <span style="font-size:26px;"><b>Registrate para Ganar</b></span>
            <p style="font-size:13px;">Únete a nosotros ahora para conseguir la<span class="red">100%</span><br/>oportunidad de<span class="red"> ganar un regalo gratuito</span>.</p>
            <form class="register-form-phone" action="#" method="post">
                <label><i>* Email</i></label>
                <input type="text" class="register-gift-text valuemail" placeholder="Tu email " name="email" value="">
                <input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" id="register-get" type="submit" value="CONSEGUIR ">
            </form>
            <?php
            $redirect = Arr::get($_GET, 'redirect', '/es/');
            $page = isset($_SERVER['HTTP_SELF']) ? 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_SELF'] . '/' . htmlspecialchars($redirect) : 'http://' . $_SERVER['HTTP_HOST'] . '/' . htmlspecialchars($redirect);
            $facebook = new facebook();
            $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
            ?>
            <a href="<?php echo $loginUrl;?>" class="register-gift-btn" onclick="return setcookiefb();">Acceder con Facebook</a>
            <p class="gift-no"><a class="JS-close2">NO, GRACIAS. DÉJEME HACER LA COMPRA.</a></p>
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
                    if($free){
                        foreach ($free as $key => $value) {
                            $product_instance = Product::instance($value['id']);
                            $img = $product_instance->cover_image();
                            $product_img = Image::link($img, 7);
                ?>
                <li class="<?php if($key==0){echo 'select';}else echo 'mt10'; ?> select<?php echo $value['id'];?>" data-id="<?php echo $value['id'];?>-<?php echo $value['type'];?>"><div class="img-select <?php if($key==1){echo 'hide';} ?>"><img src="<?php echo STATICURL; ?>/assets/images/gift-select.png" alt=""></div><img src="<?php echo $product_img;?>" alt=""><p><span class="red"><?php echo Site::instance()->price(0, 'code_view'); ?>&nbsp;&nbsp;</span><span><del><?php echo round($value['price'],2);?></del></span></p></li>
                <?php }}?>
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
            <span style="font-size:24px; color:red"><b>REGALO GRATUITO</b></span>
            <h4>por nuevos!</h4>
            <p class="mt20" style="font-size:12px;">Por favor elige un artículo de la izquierda <br/> y restablece tu contraseña debajo.</p>
            <form class="mt20 gift-form" action="#" method="post">
                <?php if(!$user_fb){ ?>
                <label><i>* Contraseña</i></label>
                <input type="password" class="register-gift-text userpwd" placeholder="6-24carácteres" name="password" value="">
                <?php } ?>
                <input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" id="register-apply" type="submit" value="APLICAR" onclick="return loading2();">
            </form>
        </div>
    </div>

    <!-- 注册部分 -->
    <div id="gift-modal-phone" class="reveal-modal register-gift register-gift-2-phone JS-popwincon1 hidden-sm hidden-md hidden-lg" style="border-radius:0;display:none">
        <a class="close-reveal-modal close-btn3 JS-close2"></a>
        <div class="register-right" style="margin-top:0;padding:0;padding-top:20px;">
            <h2>REGALO GRATUITO </h2>
            <h4>por nuevos!</h4>
            <p class="mt20">Por favor elige un artículo y restablece tu contraseña debajo.</p>
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
                <label><i>* Contraseña</i></label>
                <input type="password" class="register-gift-text userpwd" placeholder="6-24carácteres" name="password" value="">
                <?php } ?>
                <input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" id="register-apply" type="submit" value="APLICAR" onclick="return loading2();">
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
                    ac.html('Por favor elija uno de los artículos y APLIQUE.');
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
                    required: "Por favor introduzca su email.",
                    email:"Por favor introduzca una dirección de email válida."
                }
            },
            submitHandler: function(form) {  
                //Check user email
                var valuemail = $(".register-form").find(".valuemail").val();
                $.post('/cart/ajax_chkuser', {email:valuemail}, function(re){
                    if(re == "isset"){
                        alert("Lo siento, ya existe el correo electrónico!");
                        return false;
                    }else if(re == "emailerror"){
                        alert("Por favor introduzca una dirección de email válida.");
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
                    required: "Por favor introduzca su email.",
                    email:"Por favor introduzca una dirección de email válida."
                }            
            },
            submitHandler: function(form) {       

                //Check user email
                var valuemail = $(".register-form-phone").find(".valuemail").val();
                $.post('/cart/ajax_chkuser', {email:valuemail}, function(re){
                    if(re == "isset"){
                        alert("Lo siento, ya existe el correo electrónico!");
                        return false;
                    }else if(re == "emailerror"){
                        alert("Por favor introduzca una dirección de email válida.");
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
                        required: "Por favor proporcione la contraseña.",
                        minlength: "La contraseña debe ser 6-24 carácteres.",
                        maxlength: "La contraseña debe ser 6-24 carácteres."
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
                         str +="<span>¡Hola Choieser!</span>";
                         str +="</div>";
                         str +="<dl class='drop-down-list cs-list'>";
                         str +="<dd class='drop-down-option'>";
                         str +="<a href='<?php echo LANGPATH; ?>/customer/summary'>Mi Cuenta</a>";
                         str +="</dd>";
                         str +="<dd class='drop-down-option'>";
                         str +="<a href='<?php echo LANGPATH; ?>/customer/orders'>Mis Pedidos</a>";
                         str +="</dd>";
                         str +="<dd class='drop-down-option'>";
                         str +="<a href='<?php echo LANGPATH; ?>/tracks/track_order'>Rastrear</a>";
                         str +="</dd>";
                         str +="<dd class='drop-down-option'>";
                         str +="<a href='<?php echo LANGPATH; ?>/customer/wishlist'>Mi Lista de Deseos</a>";
                         str +="</dd>";
                         str +="<dd class='drop-down-option'>";
                         str +="<a href='<?php echo LANGPATH; ?>/customer/profile'>Mi Perfil</a>";
                         str +="</dd>";
                         str +="<dd class='drop-down-option'>";
                         str +="<a href='<?php echo LANGPATH; ?>/customer/logout'>Salir</a>";
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
                        required: "Por favor proporcione la contraseña.",
                        minlength: "La contraseña debe ser 6-24 carácteres.",
                        maxlength: "La contraseña debe ser 6-24 carácteres."
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
                             str +="<span>Здравствуйте, Choieser!</span>";
                             str +="</div>";
                             str +="<dl class='drop-down-list cs-list'>";
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