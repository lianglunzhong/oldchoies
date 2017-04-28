<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title; ?></title>
        <meta name="keywords" content="<?php echo $keywords; ?>" />
        <meta name="description" content="<?php echo $description; ?>" />
        <meta property="fb:app_id" content="<?php echo Site::instance()->get('fb_api_id'); ?>" />
        <link type="image/x-icon" rel="shortcut icon" href="/favicon.ico" />
        <link rel="stylesheet" href="/assets/css/style.css" media="all" id="mystyle" />
        <script src="/assets/js/jquery-1.8.2.min.js"></script>
        <script src="/assets/js/global.js"></script>
        <script src="/assets/js/plugin.js"></script>
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
$products = Order::instance($order['id'])->products();
            foreach($products as $key => $product){
                $allid[]="'".$product['product_id']."'";          
            }
            $sqid = implode(",", $allid);
    ?>
         //   window._fbq.push(['track', 'PixelInitialized', {}]);
            window._fbq.push(["track", "Purchase", { content_type: 'product', content_ids: [<?php echo $sqid; ?>], product_catalog_id: '1575263496062031' }]);

            </script>
            <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=454325211368099&amp;ev=PixelInitialized" /></noscript>       
        
        <!-- End FB Website Visitors Code -->

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
<script>fbq('track', 'Purchase', {value: '<?php echo $value; ?>', currency: 'USD'});</script>
            <!-- Facebook Conversion Code for Pay Success -->
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
            window._fbq.push(['track', '6017548810430', {'value':'<?php echo $value; ?>','currency':'USD'}]);
            </script>
            <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6017548810430&amp;cd[value]=<?php echo $value; ?>&amp;cd[currency]=USD&amp;noscript=1" /></noscript>

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
window._fbq.push(['track', '6027440007769', {'value':'<?php echo $value; ?>','currency':'USD'}]);

</script>

<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6027440007769&amp;cd[value]=<?php echo $value; ?>&amp;cd[currency]=USD&amp;noscript=1" /></noscript>

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
            ga('send', 'pageview');
        </script>
    
        
        <!-- Vizury Code -->
  <!--      <script type="text/javascript">
            (function() {
                try {
                    var viz = document.createElement("script");
                    viz.type = "text/javascript";
                    viz.async = true;
                    viz.src = ("https:" == document.location.protocol ?"https://www.vizury.com" : "http://www.vizury.com")+ "/analyze/pixel.php?account_id=VIZVRM3203";
            
                    var s = document.getElementsByTagName("script")[0];
                    s.parentNode.insertBefore(viz, s);
                    viz.onload = function() {
                        try {
                            pixel.parse();
                        } catch (i) {
                        }
                    };
                    viz.onreadystatechange = function() {
                        if (viz.readyState == "complete" || viz.readyState == "loaded") {
                            try {
                                pixel.parse();
                            } catch (i) {
                            }
                        }
                    };
                } catch (i) {
                }
            })();
        </script>   -->
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
        <div class="page">
            <!-- header begin -->
            <?php
            if ($type != 'payment' && $type != 'purchase' && $type != 'cart')
            {
            ?>
            <header class="site-header">
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
                                            <li class="drop-down-option" onClick="location.href='<?php echo LANGPATH; ?>/currency/set/<?php echo $currency['name'] ?>'">
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
                                    ?>
                                    <ul class="lang">
                                    <?php
                                    $lang_list = Kohana::config('sites.lang_list');
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
                                    <?php
                                    if ($user_id)
                                    {
                                        $user_session = Session::instance()->get('user');
                                        $firstname = $user_session['firstname'];
                                        if (!$firstname)
                                            $firstname = 'choieser';
                                        if (strlen($firstname) > 12)
                                            $fname = substr($firstname, 0, 11) . '...';
                                        else
                                            $fname = $firstname;
                                        ?>
                                        <li class="help">
                                            Здравствуйте, <span title="<?php echo $firstname; ?>"><?php echo $fname; ?></span> !
                                        </li>
                                        <li class="drop-down JS-show">
                                            <div class="drop-down-hd">
                                                <i class="myaccount"></i>
                                                <span><a href="<?php echo LANGPATH; ?>/customer/summary">Личный кабинет</a></span>
                                            </div>
                                            <dl class="drop-down-list JS-showcon hide" style="display:none;">
                                                <dd class="drop-down-option">
                                                    <a href="<?php echo LANGPATH; ?>/customer/orders">Мои Заказы</a>
                                                </dd>
                                                <dd class="drop-down-option">
                                                    <a href="<?php echo LANGPATH; ?>/tracks/track_order">Отслеживать заказ</a>
                                                </dd>
                                                <dd class="drop-down-option">
                                                    <a href="<?php echo LANGPATH; ?>/customer/points_history">Мои баллы</a>
                                                </dd>
                                                <dd class="drop-down-option">
                                                    <a href="<?php echo LANGPATH; ?>/customer/profile">Мой Профиль</a>
                                                </dd>
                                                <dd class="drop-down-option">
                                                    <a href="<?php echo LANGPATH; ?>/customer/logout">Выход</a>
                                                </dd>
                                            </dl>
                                        </li>
                                    <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li class="help">
                                            <a href="<?php echo LANGPATH; ?>/customer/login">Войти</a>
                                        </li>
                                        <li class="drop-down JS-show">
                                            <div class="drop-down-hd">
                                                <span><a href="<?php echo LANGPATH; ?>/customer/summary">Личный кабинет</a></span>
                                            </div>
                                            <dl class="drop-down-list JS-showcon hide" style="display:none;">
                                                <dd class="drop-down-option">
                                                    <a href="<?php echo LANGPATH; ?>/customer/orders">Мои Заказы</a>
                                                </dd>
                                                <dd class="drop-down-option">
                                                    <a href="<?php echo LANGPATH; ?>/tracks/track_order">Отслеживать заказ</a>
                                                </dd>
                                                <dd class="drop-down-option">
                                                    <a href="<?php echo LANGPATH; ?>/customer/points_history">Мои баллы</a>
                                                </dd>
                                                <dd class="drop-down-option">
                                                    <a href="<?php echo LANGPATH; ?>/customer/profile">Мой Профиль</a>
                                                </dd>
                                            </dl>
                                        </li>
                                        <?php
                                    }
                                    ?>
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
                                                        item<span class="cart_s"></span>товар в вашей корзине
                                                    </p>
                                                    <strong>Итого: <span class="cart_amount"></span></strong>
                                                </div>
                                                <p class="cart_button">
                                                    <a href="<?php echo LANGPATH; ?>/cart/view" class="btn btn-default btn-sm mr10">в корзину</a>
                                                    <a href="<?php echo LANGPATH; ?>/cart/checkout" class="btn btn-primary btn-sm">оформить</a>
                                                </p>
                                            </div>
                                            <p class="free-shipping free_shipping" style="display:none;">Добавьте 1+ товар С Пометкой "Бесплатная Доставка" <br>Добавьте 1+ товар С Пометкой "Бесплатная Доставка".</p>
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
                                <div id="comm100-button-311" class="tp-livechat"></div>
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
                                                                array('Мужская Одежда', '631'),
                                                                array('Ювелирные Изделия', '638'),
                                                                
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
                                                            <a href="<?php echo LANGPATH;?>/clothing-outerwear-c-623">Пальто</a>
                                                        </dt>
                                                     <?php
                                                            $links = array(
                                                                array('Блейзер','blazers-c-624'),
                                                                array('Плащи и Крылатки','capes-ponchos-c-453'),
                                                                array('Пальто и Жакет','coats-jackets-c-45'),
                                                                
                                                                array('Толстовки с шапкой И Толстовки','hoodies-sweatshirts-c-117'),
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
                                                           $apparel_banners = DB::select()->from('banners')->where('type', '=', 'apparel')->where('visibility', '=', 1)->where('lang', '=', '')->execute()->as_array();
                                                           $cacheins->set($cache_apparel_key, $apparel_banners, 3600);
                                                        }
                                                           ?>
                                                              <a href="<?php echo LANGPATH;?><?php echo $apparel_banners[1]['link']; ?>"><img src="<?php echo STATICURL; ?>/bimg/<?php echo $apparel_banners[1]['image']; ?>" width="190px" /></a>
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
                                                            <a href="<?php echo LANGPATH; ?>/product/black-suede-pointed-laced-back-over-the-knee-flat-boots_p51788">
                                                                <img src="<?php echo STATICURL; ?>/assets/images/SHOE1215A461B.jpg" ></a>
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
                                                            <dd><a href="<?php echo LANGPATH;?>/early-autumn-wardrobe-things-c-717">Осенняя Готовность</a></dd>
                                                            <dd><a href="<?php echo LANGPATH;?>/fashion-editor-s-picks-topic-c-703">Выбор Модного Редактора</a></dd>
                                                            <dd><a href="<?php echo LANGPATH;?>/croptop-cami-kimono-romper-topic-c-702">Летние Необходимые</a></dd>
                                                            <dd><a href="<?php echo LANGPATH;?>/rompers-playsuits-c-627">Модный Комбинезон</a></dd>
                                                            <dd><a href="<?php echo LANGPATH;?>/midi-skirt-c-546">Миди Юбка</a></dd>
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
                                                                <a rel="nofollow" href="http://thatisstylish.tumblr.com" target="_blank" class="sns3"></a>
                                                                <a rel="nofollow" href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4"></a>
                                                                <a rel="nofollow" href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a>
                                                                <!--<a rel="nofollow" href="http://www.chictopia.com/Choies" target="_blank" class="sns6"></a>-->
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
                                <a href="<?php echo LANGPATH; ?>/" class="home nav-home"><i class="fa fa-home"></i></a>
                                
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
                                                                array('Мужская Одежда', '631'),
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
                                                <a style="color:#cd0000;" href="<?php echo LANGPATH; ?>/christmas-sale-c-490"><div class="link" style="color:#cd0000;padding:10px 8px;">Пред-Рождество  Распродажа</div></a>
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
                <span class="livechat"></span>
                <?php $domain = URLSTR; ?>
                <!--Begin Comm100 Live Chat Code-->
                <script type="text/javascript">
                    var Comm100API = Comm100API || new Object;
                    Comm100API.chat_buttons = Comm100API.chat_buttons || [];
                    var comm100_chatButton = new Object;
                    comm100_chatButton.code_plan = 311;
                    comm100_chatButton.div_id = 'comm100-button-311';
                    Comm100API.chat_buttons.push(comm100_chatButton);
                    Comm100API.site_id = 203306;
                    Comm100API.main_code_plan = 311;
                    var comm100_lc = document.createElement('script');
                    comm100_lc.type = 'text/javascript';
                    comm100_lc.async = true;
                    comm100_lc.src = 'https://chatserver.comm100.com/livechat.ashx?siteId=' + Comm100API.site_id;
                    var comm100_s = document.getElementsByTagName('script')[0];
                    comm100_s.parentNode.insertBefore(comm100_lc, comm100_s);
                </script>
                <!--End Comm100 Live Chat Code-->
            </header>
            <?php
            }
            ?>
            <!-- main begin -->
            <section id="main">
                <!-- main-middle begin -->
                <div class="phone-cart-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="step-nav">
                                    <ul class="clearfix">
                                        <li>Заказать<em></em><i></i></li>
                                        <li>Оплатить<em></em><i></i></li>
                                        <li class="current">Успешно<em></em><i></i></li>
                                    </ul>
                                </div>  
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="crumbs hidden-xs">
                        <div class="fll"></div>
                    </div>
                    <div class="row">
                        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
                        <article class="user col-sm-9 col-xs-12">
                            <h1 class="paysuccess-h">Спасибо большое!</h1>
                            <ul class="paysuccess-t">
                                <li>Вы успешно завершили ваш платеж.
                    <li>Нажмите номер вашего заказа: <a class="success" href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><?php echo $order['ordernum']; ?></a> для просмотра более подробной информации.</li>
                               <li>Außerdem erhalten Sie eine Übersicht über Ihre Bestellinformationen per E-Mail.</li> 
                                <li>Вы также будете получить сводную информацию о вашем заказе по электронной почте. </li> 
                                <li>Если у вас есть вопросы о вашем заказе,то <a href="<?php echo LANGPATH; ?>/contact-us">свяжитесь с нами</a>.</li>
                                <li><a href="<?php echo LANGPATH; ?>/" class="btn btn-primary btn-sm">Продолжить покупки</a></li>
                                <?php
                                $customer_id = $order['customer_id'];
                                $ppec_status = Customer::instance($customer_id)->get('ppec_status');
                                if($ppec_status == 0)
                                {
                                ?>
                                    <li><span class="red">Note:</span>Your logging status is valid only once.Once you sign out, you are unable to sign into Choies again.</li>
                                    <li>We have sent you an email to your PayPal email address with randomly generated password in it. </li>
                                    <li>Use the password to sign into Choies, you will find more details about your order.</li>
                                <?php
                                }
                                ?>
                            </ul>
                            <div class="other-customers" id="alsoview" style="display:none">
                                <div class="w-tit">
                                    <h2>Andere Kunden sehen auch</h2>
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
                                  <li data-scarabitem="{{= p.id }}" style="display: inline-block" class="rec-item">
                                     <a href="{{=p.link}}" id="em{{= p.id }}link">
                                      <img src="{{=p.image}}" class="rec-image">
                                    </a>
                                    <p class="price"><b>${{=p.price}}</b></p>
                                  </li>
                                    {{ if(i==6 || i==13 || i==20 || i==27){ }}
                                    </ul></div>
                                    {{ } }}
                                {{ } }}
                                ]]>
                                </script>
                                <div id="personal-recs"></div>
                                <script type="text/javascript">
                                ScarabQueue.push(['purchase', {
                                    orderId: '<?php echo $order['ordernum']; ?>',
                                    items: [
                                    <?php
                                    foreach(unserialize($order['products']) as $product)
                                    {
                                    ?>
                                        {item: '<?php echo $product['id']; ?>', price: <?php echo round($product['price'], 2); ?>, quantity: <?php echo $product['quantity']; ?>},
                                    <?php
                                    }
                                    ?>
                                    ]
                                }]);
                                // Request personalized recommendations.
                                var render = function() {
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
                                                        for(var o in data){
                                                            $("#em"+o+"link").attr("href",data[o]["link"]);
                                                            $("#em"+o+"price").html(data[o]["price"]);
                                                            if(data[o]["show"]==0 || typeof(data[o]["link"]) == "undefined"){
                                                                $("#em"+o).css('display','none');
                                                            }
                                                            else
                                                            {
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
                                                    }
                                            });
                                            
                                            var winWidth = window.innerWidth;
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
                                 
                                };
                                return {
                                    render: render,
                                    add: function(itemId, price) {
                                        cart.push({Artikel: itemId, price: price, Menge: 1});
                                        render();
                                    },
                                    remove: function(itemId) {
                                        cart = cart.filter(function(e) {
                                          return e.item !== itemId;
                                        });
                                        render();
                                    } 
                                };
                                }());
                                Cart.render();
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
                            <script type="text/javascript">
                            var f=0;
                            var t1;
                            var tc1;
                            $(function(){
                                $(".box-current1 li").hover(function(){   
                                    $(this).addClass("on").siblings().removeClass("on");
                                    var c=$(".box-current1 li").index(this);
                                    $(".hide-box1_0,.hide-box1_1,.hide-box1_2,.hide-box1_3").hide();
                                    $(".hide-box1_"+c).fadeIn(150); 
                                    f=c; 
                                })
                            })
                            </script>

                            <div class="index-fashion buyers-show">
                                <div class="phone-fashion-top w-tit">
                                    <h2>Andere Kunden sehen auch</h2>
                                </div>
                                <div class="flash-sale">
                                    <ul class="row" id="phone_scare"></ul>
                                </div>  
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <?php
            if ($type != 'payment' && $type != 'purchase' && $type != 'cart')
            {
            ?>
            <footer>
            <div id="comm100-button-311" class="bt-livechat visible-xs-block hidden-sm hidden-md hidden-lg">
                <a onClick="Comm100API.open_chat_window(event, 311);" href="#">
                    <img id="comm100-button-311img" alt="" style="border:none;" src="https://chatserver.comm100.com/DBResource/DBImage.ashx?imgId=178&type=2&siteId=203306">
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
                                        <form method="post" action="#">
                                            
                                                <dd  onclick="location.href='<?php echo LANGPATH; ?>/currency/set/<?php echo $currency['name'] ?>'"><a class="icon-flag icon-<?php echo strtolower($currency['name']); ?>" href="<?php echo LANGPATH; ?>/currency/set/<?php echo $currency['name'] ?>"><?php echo $currency['fname']; ?></a>
                                                </dd>
                                        <?php
                                        $key ++;
                                    }
                                    ?>
                                            </dl>
                                        </form>
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
                                <dd><a onClick="return feed_show();">Фидбэк</a></dd>
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
                            <dd><a href="<?php echo LANGPATH; ?>/rate-order-win-100" style="color:red;">Rate & Win $100</a></dd>
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
                                    <dd><a rel="nofollow" href="http://thatisstylish.tumblr.com" target="_blank" class="sns3" title="tumblr"></a></dd>
                                    <dd><a rel="nofollow" href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4" title="youtube"></a></dd>
                                    <dd><a rel="nofollow" href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a></dd>
                                    <!--<dd><a rel="nofollow" href="http://www.chictopia.com/Choies" target="_blank" class="sns6" title="chictopia"></a></dd>-->
                                    <dd><a rel="nofollow" href="http://instagram.com/choiesclothing" target="_blank" class="sns7" title="instagram"></a></dd>
                                </dl>
                                <dl class="letter">
                                    <form action="" method="post" id="letter_form">
                                        <label class="hidden-xs">Подпишитесь на нашу электронную почту</label>
                                        <div>
                                            <input type="text" id="letter_text" class="text fll" value="Email Address" onBlur="if(this.value==''){this.value=this.defaultValue;}"  onfocus="if(this.value=='Email Address'){this.value='';};" />
                                            <input type="submit" id="letter_btn" value="Submit" class="btn btn-primary" />
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
                                            <input id="letter_text1" class="text" value="Sign up for our emails" onBlur="if(this.value==''){this.value=this.defaultValue;}" onFocus="if(this.value=='Sign up for our emails'){this.value='';};" type="text">
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
                                    <dd><a rel="nofollow" href="http://thatisstylish.tumblr.com" target="_blank" class="sns3" title="tumblr"></a></dd>
                                    <dd><a rel="nofollow" href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4" title="youtube"></a></dd>
                                    <dd><a rel="nofollow" href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a></dd>
                                    <!--<dd><a rel="nofollow" href="http://www.chictopia.com/Choies" target="_blank" class="sns6" title="chictopia"></a></dd>-->
                                    <dd><a rel="nofollow" href="http://instagram.com/choiesclothing" target="_blank" class="sns7" title="instagram"></a></dd>
                                </dl>
                            </dl>                           
                            
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <dt style="text-transform: capitalize;"><a href="/customer/summary">Личный кабинет&nbsp;&bull;</a><a href="/tracks/track_order">&nbsp;Отслеживать заказ&nbsp;&bull;</a><a href="/customer/orders">&nbsp;Мои Заказы</a></dt>
                            </dl>
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <dd><a  onclick="return feed_show();" style="color:#444;">Фидбэк&nbsp;&bull;</a><a href="/vip-policy" style="color:#444;">&nbsp;VIP Policy&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/contact-us" style="color:#444;">&nbsp;Контакт с нами&nbsp;</a></dd>
                            </dl>  
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                            <dt style="text-transform: capitalize;"><a href="<?php echo LANGPATH; ?>/lookbook" style="color:#444;">#Лукбук</a>
                            </dl>  

                            
                        </div>
                        <div class="card  hidden-xs container">
                            <p class="paypal-card container">
                                <img usemap="#Card" src="/assets/images/card-0509.jpg">
                                <map id="Card" name="Card">
                                <area target="_blank" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=<?php echo URLSTR; ?>&lang=en" coords="88,2,193,62" shape="rect">
                                </map>
                            </p>
                        </div>
                        <div class="copyright visible-xs-block hidden-sm hidden-md hidden-lg">
                            <p>Copyright © 2006-2015 Choies.com </p>
                            <p class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <a href="<?php echo LANGPATH; ?>/about-us">О Нами&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/conditions-of-use">&nbsp;Условия использования&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/privacy-security">&nbsp;Конфиденциальность И Безопасность</a>
                            </p>
                        </div>
                    </div>
                    <div class="copyr hidden-xs">
                        <p class="bottom container-fluid">Copyright © 2006-2015 Choies.com&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo LANGPATH; ?>/privacy-security">Конфиденциальность И Безопасность</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo LANGPATH; ?>/about-us">О Нами</a>
                        </p>
                    </div>
                </div>
            </footer>
            <div id="gotop" class="hide ">
                <a href="#" class="xs-mobile-top"></a>
            </div>

            <script type="text/javascript">
                $(function(){
                    $("#feedback .clsbtn,#wingray2").live("click",function(){
                        $("#wingray2").remove();
                        $('#feedback').fadeOut(160);
                        $('#feedback_success').fadeOut(160);
                        return false;
                                                
                    })
                    $("#feedback_success .clsbtn,#wingray3").live("click",function(){
                        $("#wingray3").remove();
                        $("#wingray2").remove();
                        $('#feedback_success').fadeOut(160);
                        $('#feedback').fadeOut(160);
                        return false;
                    })
                    $("#feedback .formArea").submit(function(){
                        var email1 = $('#f_email1').val();
                        var email2 = $('#f_email2').val();
                        var comment = $("#f_comment").val();
                        var what_like = $("#what_like").val();
                        var do_better = $("#do_better").val();
                        if((!email1 && !email2) || (!comment && !do_better))
                        {
                            return false;
                        }
                        $.post(
                        '/review/ajax_feedback',
                        {
                            email1: email1,
                            email2: email2,
                            comment: comment,
                            what_like: what_like,
                            do_better: do_better
                        },
                        function(data)
                        {
                            $('body').append('<div id="wingray3" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                            var top = getScrollTop();
                            top = top - 15;
                            $('#feedback_success').css({
                                "top": top,
                                "position": 'absolute'
                            });
                            $('#feedback_success').appendTo('body').fadeIn(240);
                            if(data['success'] == 0)
                            {
                                $("#feedback_success .failed1").show();
                                $("#feedback_success .failed1 p").html(data['message']);
                                $("#feedback_success .success1").hide();
                                $("#wingray3").remove();
                                $("#feedback").hide();
                            }
                            else if(data['success'] == -1)
                            {
                                $("#feedback_success .failed1").show();
                                $("#feedback_success .failed1 p").html(data['message']);
                                $("#feedback_success .success1").hide();
                                $("#wingray3").remove();
                                $("#feedback").remove();
                                $("#feedback_success").attr('id', 'feedback');
                            }
                            else
                            {
                                $("#feedback_success success1").show();
                                $("#feedback_success .failed1").hide();
                                $("#wingray3").remove();
                                $("#feedback").remove();
                                $("#feedback_success").attr('id', 'feedback');
                            }
                        },
                        'json'
                    );
                        return false;
                    })
                })
                                
                function feed_show()
                {
                    $(".f_email").val('');
                    $("#f_comment").val('');
                    var top = getScrollTop();
                    top = top - 35;
                    $('body').append('<div class="JS-filter4 opacity"></div>');
                    $('#feedback').css({
                        "top": top,
                        "position": 'absolute'
                    });
                    $('#feedback').appendTo('body').fadeIn(320);
                    $('#feedback').show();
                    return false;
                }
            </script>

            <div class="feedback JS-popwincon4 hide" id="feedback">
                <a class="JS-close5 close-btn3 clsbtn"></a>
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
                                        <label for="Email Address:"><span>*</span>  Адрес электронной почты:<span class="errorInfo clear hide">Предоставьте адрес электронной почты,пожалуйста.</span>
                                        </label>
                                        <input type="email" name="email" id="f_email1" class="text text-long" value="" maxlength="340">
                                    </li>
                                    <li>
                                        <input type="submit" value="submit" class="btn btn-primary btn-lg">
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
                                                required:"Предоставьте адрес электронной почты,пожалуйста.",
                                                email:"Заполните действительный адрес электронной почты."
                                            },
                                            do_better: {
                                                required: "Заполните это поле."
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
                                        <input type="email" name="email1" id="f_email2" class="text text-long" value="" maxlength="340">
                                    </li>
                                    <li>
                                        <input type="submit" value="submit" class="btn btn-primary btn-lg">
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
                                                required:"Предоставьте адрес электронной почты,пожалуйста.",
                                                email:"Заполните действительный адрес электронной почты."
                                            },
                                            comment: {
                                                required: "Заполните это поле.",
                                                minlength: "Пароль слишком короткий, не менее 5 символов."
                                            }
                                    }
                                });
                            </script>
                             <p class="mt10">Более подробные вопросы? Пожалуйста, <a href="https://chatserver.comm100.com/chatwindow.aspx?planId=311&amp;siteId=203306" title="contact us" target="_blank">свяжитесь с нами</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="feedback_success" class="feedback JS-popwincon4 popwincon" style="height:200px; width:420px; margin-left:-270px; top:80px;display:none;">
                <div class="JS-close5 close-btn3 clsbtn" style="right: 0px;top: 3px;"></div>
                <div class="success1">
                <h3>Спасибо!</h3>
                        <p><em>Ваш фидбэк был получен !</em></p>
                </div>
                <div class="failed1">
                    <h3>Sorry!</h3>
                    <p></p>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
        <script src="/assets/js/common.js"></script>
        <script src="/assets/js/slider.js"></script>
        <script src="/assets/js/zoom.js"></script>
        <script src="/assets/js/product-rotation.js"></script>

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
                    url: "/<?php echo LANGUAGE; ?>/cart/ajax_cart",
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
                          var cart_view = msg['cart_view'];
                                cart_view = cart_view.replace(/Item:/g, 'Товар:');
                                cart_view = cart_view.replace(/Size:/g, 'Размеры:');
                                cart_view = cart_view.replace(/Quantity:/g, 'Количество:');
                                cart_view = cart_view.replace(/one size/g, 'только один размер');
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
            $email = $user_session['email'];
            ?>
            <script type="text/javascript">ScarabQueue.push(['setEmail', '<?php echo $email; ?>']);</script>
            <script type="text/javascript">
            varpageTracker=_gat._getTracker("UA-32176633-1");
            pageTracker._setVar('register');//设置用户分类
            pageTracker._trackPageview();
            </script>
            <?php } ?>
<!-- HK ScarabQueue statistics Code -->
<?php 
    $amount=round($order["amount"]/$order["rate"],4);
    $qty=count($products);
    ($qty == 0) ? 0 : $amount2=round(($amount/$qty)*100)/100;
?>

<script type="text/javascript" src="https://imgsrv.nextag.com/imagefiles/includes/roitrack.js"></script> 
<script type="text/javascript">
ScarabQueue.push(['setOrderId', '<?php echo $order["ordernum"]; ?>']);
<?php
$products = Order::instance($order['id'])->products();
foreach ($products as $product):
$sku = Product::instance($product['product_id'])->get('sku');
echo "ScarabQueue.push(['checkOut', '".$sku."', ".$product['quantity'].", ".$amount2."]);";
endforeach;
?>
</script>
<!-- HK ScarabQueue statistics Code -->
<script type="text/javascript">ScarabQueue.push(['go']);</script>
<!-- HK ScarabQueue statistics Code -->

    <img src="https://hotdeals.dmdelivery.com/x/conversion/?order_hva=<?php echo $order['ordernum']; ?>" alt="" width="1" height="1" />

<!-- Google Code for Success Conversion Page -->
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 983779940;
    var google_conversion_language = "en";
    var google_conversion_format = "2";
    var google_conversion_color = "ffffff";
    var google_conversion_label = "o62wCIT3kQgQ5JSN1QM";
    var google_conversion_value = <?php $g_amount = round($order['amount'] / $order['rate'], 2); echo $g_amount;  ?>;
    var google_remarketing_only = false;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
    <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/983779940/?value=<?php echo $g_amount; ?>&amp;label=o62wCIT3kQgQ5JSN1QM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- Google Code for sales Conversion Page --> 
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 969564565;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "dzCzCPuoiQgQlcOpzgM";
var google_conversion_value = <?php $g_amount = round($order['amount'] / $order['rate'], 2); echo $g_amount;  ?>;
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
    <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/969564565/?value=<?php echo $g_amount; ?>&amp;label=dzCzCPuoiQgQlcOpzgM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>



<?php
$products = Order::instance($order['id'])->products();
//new GA ecommerce code
// Transaction Data
$cou = $order['coupon_code'];
$trans = array('id'=>$order['ordernum'],'coupon'=>$cou,'affiliation'=>'Acme Clothing',
               'revenue'=>$order['amount'], 'shipping'=>$order['amount_shipping'], 'tax'=>'0','currency'=>$order['currency']);

// List of Items Purchased.
$items=array();
$currency = Site::instance()->currencies($order['currency']);
foreach ($products as $product):
    $items[]=array(
        'sku'=>Product::instance($product['product_id'])->get('sku'),
        'name'=>htmlspecialchars(Product::instance($product['product_id'])->get('name')),
        'category'=>htmlspecialchars(Catalog::instance(Product::instance($product['product_id'])->default_catalog())->get('name')),
        'price'=>number_format($product['price']*$currency['rate'],2),
        'quantity'=>$product['quantity'],
        'currency'=>$order['currency'],
        )
;
 endforeach; 
// Function to return the JavaScript representation of a TransactionData object.
function getTransactionJs(&$trans) {
  return <<<HTML
ga('ecommerce:addTransaction', {
  'id': '{$trans['id']}',
  'affiliation': '{$trans['affiliation']}',
  'revenue': '{$trans['revenue']}',
  'shipping': '{$trans['shipping']}',
  'tax': '{$trans['tax']}',
  'currency': '{$trans['currency']}'
});
HTML;
}

// Function to return the JavaScript representation of an ItemData object.
function getItemJs(&$transId, &$item) {
  return <<<HTML
ga('ecommerce:addItem', {
  'id': '$transId',
  'name': '{$item['name']}',
  'sku': '{$item['sku']}',
  'category': '{$item['category']}',
  'price': '{$item['price']}',
  'quantity': '{$item['quantity']}',
  'currency': '{$item['currency']}'
});
HTML;
}
?>

<!-- GA code -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            
ga('create', 'UA-32176633-1', 'choies.com', {'siteSpeedSampleRate': 20});
ga('require', 'displayfeatures');
ga('send', 'pageview');
ga('require', 'ecommerce');

<?php
echo getTransactionJs($trans);

foreach ($items as &$item) {
  echo getItemJs($trans['id'], $item);
}
?>

ga('ecommerce:send');
</script>

    <!--START AffiliateTraction CODE-->
    <?php $tto = $order['amount'] - $order['order_insurance'] * $order['rate'] - $order['amount_shipping']; 
        $tto = round($tto,2);
    ?>
    <iframe src="https://choies.affiliatetechnology.com/trackingcode_sale.php?mid=1&sec_id=M_14aL4kF3nX8iQ&sale=<?php echo $tto; ?>&orderId=<?php echo $order['ordernum']; ?>&promo=<?php echo $cou; ?>&currency=<?php echo $order['currency']; ?>" height="1" width="1" frameborder=no border=0 scrolling=no></iframe>
    <!-- END AffiliateTraction CODE --> 


<img src="https://hotdeals.dmdelivery.com/x/conversion/?order_choies=<?php echo $order['ordernum']; ?>" alt="" width="1" height="1" />
<img src="https://hotdeals.dmdelivery.com/x/conversion/?price_choies=<?php echo $order['amount']; ?>" alt="" width="1" height="1" />

<img src="https://gan.doubleclick.net/gan_conversion?advid=K603690&oid=<?php echo $order['ordernum']; ?>&amt=<?php echo $order['amount']; ?>&fxsrc=USD" width=1 height=1>

<script type="text/javascript">
    var _roi = _roi || [];
    _roi.push(['_setMerchantId', '528303']);
    _roi.push(['_setOrderId', '<?php echo $order['ordernum']; ?>']);
    _roi.push(['_setOrderAmount', '<?php echo $order['amount']; ?>']);
    _roi.push(['_setOrderNotes', '']);
    _roi.push(['_addItem','<?php echo $products[0]['sku']; ?>','<?php echo $products[0]['sku']; ?>','','','<?php echo round($products[0]['price'], 2); ?>','<?php echo $products[0]['quantity']; ?>']);
    _roi.push(['_trackTrans']);
</script>
<script type="text/javascript" src="https://stat.dealtime.com/ROI/ROI2.js"></script>

<?php
$gol_sku = null;
$gol_price = null;
$gol_qty = null;
$i = 1;
$xingcloud = array();
$xingcloud[0] = array(
    'orderId' => $order['ordernum'],
    'merchant' => 'Choies',
    'orderTotalPrice' => round($order['amount'], 2),
    'productList' => array(),
);
$cj_sku=array();
$cj_qty=array();
$cj_amt=array();

$all_sku=array();
$all_qty=array();
$all_price=array();

$link_amt=array();
$link_name=array();
foreach ($products as $valu)
{
    $sku = Product::instance($valu['product_id'])->get('sku');
    $all_sku[] = $sku;
    $all_qty[] = $valu['quantity'];
    $all_price[] = $valu['price'];
    
    $cj_sku[] = "ITEM" . $i . "=" . $sku;
    $cj_qty[] = "QTY" . $i . "=" . $valu['quantity'];
    $cj_amt[] = "AMT" . $i . "=" . ($valu['price']);
    $i++;

    $link_amt[] = $valu['quantity'] * $valu['price'] * 100;
    $link_name[] = $valu['name'];
    $set_id = Product::instance($valu['product_id'])->get('set_id');
    $xingcloud[0]['productList'][] = array(
        'name' => $valu['name'],
        'currency' => $order['currency'],
        'singlePrice' => round($valu['price'] * $order['rate'], 2),
        'totalPrice' => round($valu['price'] * $order['rate'], 2) * $valu['quantity'],
        'productCount' => $valu['quantity'],
        'category' => Set::instance($set_id)->get('name'),
    );
}
$cj_sku = implode('&', $cj_sku);
$cj_qty = implode('&', $cj_qty);
$cj_amt = implode('&', $cj_amt);

$gol_sku = implode('^', $all_sku);
$gol_qty = implode('^', $all_qty);
$gol_price = implode('^', $all_price);

$link_sku = implode('|', $all_sku);
$link_qty = implode('|', $all_qty);
$link_amt = implode('|', $link_amt);
$link_name = implode('|', $link_name);
$discount = $order['amount_products'] - $order['amount'];
?>

<!-- New EDM Track Code -->
<?php
$items = array();
$a8qty = 0;
$pol_skus = array();
foreach($all_sku as $key => $s)
{
    $items[] = $s . '@' . $all_qty[$key] . '@' . round($all_price[$key], 2);
    $a8qty += $all_qty[$key];
    $pol_skus[] = $s;
}
?>
<img src="https://p.chtah.com/a/r2095704761/CLIENT_NAME.gif?a=<?php echo $order['ordernum']; ?>&b=<?php echo round($order['amount'], 2); ?>&items=<?php echo implode('|', $items); ?>&currency=<?php echo $order['currency']; ?>&country=<?php echo $order['shipping_country']; ?>">


<script type="text/javascript" src="https://imgsrv.nextag.com/imagefiles/includes/roitrack.js"></script> 

<?php
if (strtolower(Kohana_Cookie::get("ChoiesCookie")) == "cj")
{ 
    ?>
    <!--begin cj platform code -->
    <iframe height="1" width="1" frameborder="0" scrolling="no" src="https://www.emjcd.com/tags/c?containerTagId=4452&<?php echo $cj_sku; ?>&<?php echo $cj_amt; ?>&<?php echo $cj_qty; ?>&CID=1527669&OID=<?php echo $order['ordernum']; ?>&TYPE=361456&CURRENCY=<?php echo $order['currency']; ?>&Discount=<?php echo $discount; ?>" name="cj_conversion" ></iframe>
    <?php
}
elseif(strtolower(Kohana_Cookie::get("ChoiesCookie")) == "shareasale")
{
    ?>
<!--begin shareasale platform code-->
<img src="https://shareasale.com/sale.cfm?amount=<?php echo $order['amount']; ?>&tracking=<?php echo $order['ordernum']; ?>&transtype=sale&merchantID=41271&currency=<?php echo $order['currency']; ?>" width="1" height="1">
    <?php
}
?>

<?php SetCookie('ChoiesCookie', '', time()+24*3600);  ?>


<!--ReasonableSpread.com conversion tracking begin-->
   <a href="http://ReasonableSpread.com">
     <img border="0px" src="http://track1.rspread.com/ConversionTracking.aspx?userid=36883&type=p&value=<?php echo round($order['amount'], 2); ?>&label=<?php echo $order['ordernum']; ?>(<?php echo $order['currency']; ?>)"/>
   </a>
<!--ReasonableSpread.com conversion tracking end-->

<!-- Polyvore Conversion Code -->
<img width="1" height="1" src="https://www.polyvore.com/conversion/beacon.gif?adv=choies.com&amt=<?php echo round($order['amount'], 2); ?>&oid=<?php echo $order['ordernum']; ?>&skus=<?php echo implode(',', $pol_skus); ?>&cur=<?php echo strtolower($order['currency']); ?>">
<?php
if(strtolower(Kohana_Cookie::get("xc_source")) == "xingcloud")
{
    ?>
    <!-- xingcloud code -->
    <script type="text/javascript">
        $(function(){
            $.post(
            'http://api.affiliate.xingcloud.com/cps?callback=order',
            {
                orderList: '<?php echo json_encode($xingcloud); ?>'
            },
            function(product)
            {

            },
            'json'
            );
            return false;
        })
    </script>
    <?php
    SetCookie("xc_source", "null", time() + 1800, '/');
}
?>



<!-- Facebook Conversion Code for Check out -->
<script type="text/javascript">
    var fb_param = {};
    fb_param.pixel_id = '6015191467430';
    fb_param.value = '<?php echo $order['amount']; ?>';
    fb_param.currency = 'USD';
    (function(){
        var fpw = document.createElement('script');
        fpw.async = true;
        fpw.src = '//connect.facebook.net/en_US/fp.js';
        var ref = document.getElementsByTagName('script')[0];
        ref.parentNode.insertBefore(fpw, ref);
    })();
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/offsite_event.php?id=6015191467430&amp;value=<?php echo $order['amount']; ?>&amp;currency=USD" /></noscript>

<!-- Google Code for sale 1 Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 974164400;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "BIjICLCEuAgQsKPC0AM";
var google_conversion_value = <?php echo $g_amount; ?>;
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/974164400/?value=<?php echo $g_amount; ?>&amp;label=BIjICLCEuAgQsKPC0AM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- Google Code for sale 1 Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 972170544;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "kcKNCMDK2goQsMrIzwM";
var google_conversion_value = <?php echo $g_amount; ?>;
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/972170544/?value=<?php echo $g_amount; ?>&amp;label=kcKNCMDK2goQsMrIzwM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- Google Code for sale 1 Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 970256491;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "etPuCN3n4wgQ6-DTzgM";
var google_conversion_value = <?php echo $g_amount; ?>;
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/970256491/?value=<?php echo $g_amount; ?>&amp;label=etPuCN3n4wgQ6-DTzgM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- Bing Conversion Track Code -->
<script type="text/javascript"> if (!window.mstag) mstag = {loadTag : function(){},time : (new Date()).getTime()};</script> <script id="mstag_tops" type="text/javascript" src="//flex.msn.com/mstag/site/328da873-bd52-4a88-acfc-33b0b6eb8904/mstag.js"></script> <script type="text/javascript"> mstag.loadTag("analytics", {dedup:"1",domainId:"3099717",type:"1",actionid:"255169"})</script> <noscript> <iframe src="//flex.msn.com/mstag/tag/328da873-bd52-4a88-acfc-33b0b6eb8904/analytics.html?dedup=1&domainId=3099717&type=1&actionid=255169" frameborder="0" scrolling="no" width="1" height="1" style="visibility:hidden;display:none"> </iframe> </noscript>


<!-- AB Test Code -->
<script>
    window.optimizely = window.optimizely || [];
    window.optimizely.push(['trackEvent', 'purchase_complete', {'revenue': <?php echo round($order['amount'] / $order['rate'], 2) * 100; ?>}]);
</script>


<?php 
    $currency = Site::instance()->currencies($order['currency']);
?>
<!-- webpower Foreign Statistical code by zhang.jinling-->
<img src="http://choies-mail.dmdelivery.com/x/conversion/?buy=<?php echo $order["ordernum"]."_".$currency['code'] . round($order["amount"],2); ?>" alt="" width="1" height="1" />
<img src="http://choies-mail.dmdelivery.com/x/conversion/?price=<?php echo $currency['code'] . round($order["amount"],2); ?>" alt="" width="1" height="1" />
<!-- webpower Foreign Statistical code by zhang.jinling-->
<img src="http://choies-service.dmdelivery.com/x/conversion/?order=<?php echo $order["ordernum"]; ?>" alt="" width="1" height="1" />
<img src="http://choies-service.dmdelivery.com/x/conversion/?price=<?php echo $currency['code'] . round($order["amount"],2); ?>" alt="" width="1" height="1" />


<!-- <webgains tracking code> -->
<?php if (strtolower(Kohana_Cookie::get("ChoiesCookie")) == "webgains"){ ?>
<script language="javascript" type="text/javascript">
var wgOrderReference = "<?php echo $order['ordernum']; ?>";
var wgOrderValue = "<?php echo $order['amount']; ?>";
var wgEventID = 16617;
var wgComment = "";
var wgLang = "en_EN";
var wgsLang = "javascript-client";
var wgVersion = "1.2";
var wgProgramID = 10007;
var wgSubDomain = "track";
var wgCheckSum = "";
var wgItems = "";
var wgVoucherCode = "<?php echo $order['coupon_code']; ?>";
var wgCustomerID = "";
var wgCurrency = "<?php echo $order['currency']; ?>";
if(location.protocol.toLowerCase() == "https:") wgProtocol="https";
else wgProtocol = "http";
wgUri = wgProtocol + "://" + wgSubDomain + ".webgains.com/transaction.html" + "?wgver=" + wgVersion + "&wgprotocol=" + wgProtocol + "&wgsubdomain=" + wgSubDomain + "&wgslang=" + wgsLang + "&wglang=" + wgLang + "&wgprogramid=" + wgProgramID + "&wgeventid=" + wgEventID + "&wgvalue=" + wgOrderValue + "&wgchecksum=" + wgCheckSum + "&wgorderreference="  + wgOrderReference + "&wgcomment=" + escape(wgComment) + "&wglocation=" + escape(document.referrer) + "&wgitems=" + escape(wgItems) + "&wgcustomerid=" + escape(wgCustomerID) + "&wgvouchercode=" + escape(wgVoucherCode) + "&wgCurrency=" + escape(wgCurrency);
document.write('<sc'+'ript language="JavaScript"  type="text/javascript" src="'+wgUri+'"></sc'+'ript>');
</script>
<noscript>
<img src="http://track.webgains.com/transaction.html?wgver=1.2&wgprogramid=10007&wgrs=1&wgvalue=<?php echo $order['amount']; ?>&wgeventid=16617&wgorderreference=<?php echo $order['ordernum']; ?>&wgitems=&wgvouchercode=&wgcustomerid=&wgCurrency=<?php echo $order['currency']; ?>" alt="" />
</noscript>
<?php } ?>

            <?php
            $user_id = Customer::logged_in();
            $products = Order::instance($order['id'])->products();
            $user_session = Session::instance()->get('user');
                        ?>
                <!-- Criteo Code For Pay Success Page -->
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
                { event: "trackTransaction" , id: <?php echo $ordernum = Order::instance($order['id'])->get('ordernum');?>,currency:"<?php echo $order['currency'];?>", item: [
                    <?php
                    foreach($products as $key => $product)
                    {
                        $sku = Product::instance($product['id'])->get('sku');
                    ?>
                    {id: '<?php echo $product['product_id'];  ?>', price: <?php echo round($product['price'] * $order['rate'], 2); ?>, quantity: <?php echo $product['quantity']; ?>},
                    <?php
                    }
                    ?>
            ]},

                { event: "flushEvents"},

                { event: "setAccount", account: 23688 },
                { event: "setHashedEmail", email: "<?php echo !empty($user_session['email'])? md5($user_session['email']):' '; ?>" },
                { event: "setSiteType", type: m },
                { event: "trackTransaction" , id: <?php echo $ordernum = Order::instance($order['id'])->get('ordernum');?>,currency:"<?php echo $order['currency'];?>", item: [
                    <?php
                    foreach($products as $key => $product)
                    {
                        $sku = Product::instance($product['id'])->get('sku');
                    ?>
                    {id: '<?php echo $product['product_id'];  ?>', price: <?php echo round($product['price'] * $order['rate'], 2); ?>, quantity: <?php echo $product['quantity']; ?>},
                    <?php
                    }
                    ?>
            ]},
                { event: "flushEvents"}
            );
        </script>
        <!-- end Criteo Code For Pay Success Page -->
        
    </body>
</html>
