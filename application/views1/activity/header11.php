<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $description; ?>" />
        <meta property="fb:app_id" content="<?php echo Site::instance()->get('fb_api_id'); ?>" />
        <link type="image/x-icon" rel="shortcut icon" href="/favicon.ico" />
        <link rel="stylesheet" href="<?php echo Site::instance()->version_file('/assets/css/style.css'); ?>" media="all" id="mystyle" />
        <script src="/assets/js/jquery-1.8.2.min.js"></script>
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

            window._fbq.push(['track', 'PixelInitialized', {}]);

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
        
        <!-- Stats code of HelloSociety -->
        <script type="text/javascript">
            var _hs = _hs || [];
            (function() {
                var hs = document.createElement('script'); hs.type = 'text/javascript'; hs.async = true;
                hs.id="hs-pixel-source"; hs.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cf.hellosociety.com/js/hellosociety.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(hs, s);
            })();
        </script>
        
        <!-- Vizury Code -->
        <script type="text/javascript">
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
        </script>   
    </head>
    <body>
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
                                        <a href="#" class="icon-flag icon-<?php echo strtolower($currency_now['name']); ?>"></a> 
                                        <i class="fa fa-caret-down"></i>
                                        <span>
                                        <?php
                                        if(strpos($currency_now['code'], '$') !== False)
                                            $code_now = '$';
                                        else
                                            $code_now = $currency_now['code'];
                                        echo $code_now . $currency_now['name']; 
                                        ?>
                                        </span>
                                    </div>
                                    <ul class="drop-down-list JS-showcon hide" style="display:none; width:150px;">
                                        <li class="drop-down-option">
                                            <a class="icon-flag icon-usd" href="">US Dollar</a>
                                        </li>
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
                                        <a href="/faqs">Help</a>
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
                                            Hello, <span title="<?php echo $firstname; ?>"><?php echo $fname; ?></span> !
                                        </li>
                                        <li class="drop-down JS-show">
                                            <div class="drop-down-hd">
                                                <span><a href="/customer/summary">MY ACCOUNT</a></span>
                                            </div>
                                            <dl class="drop-down-list JS-showcon hide" style="display:none;">
                                                <dd class="drop-down-option">
                                                    <a href="/customer/orders">My Order</a>
                                                </dd>
                                                <dd class="drop-down-option">
                                                    <a href="/tracks/track_order">Track Order</a>
                                                </dd>
                                                <dd class="drop-down-option">
                                                    <a href="/customer/points_history">My Point</a>
                                                </dd>
                                                <dd class="drop-down-option">
                                                    <a href="/customer/profile">My Profile</a>
                                                </dd>
                                                <dd class="drop-down-option">
                                                    <a href="/customer/logout">Sign Out</a>
                                                </dd>
                                            </dl>
                                        </li>
                                    <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li class="help">
                                            <a href="/customer/login">Sign In</a>
                                        </li>
                                        <li class="drop-down JS-show">
                                            <div class="drop-down-hd">
                                                <span><a href="/customer/summary">MY ACCOUNT</a></span>
                                            </div>
                                            <dl class="drop-down-list JS-showcon hide" style="display:none;">
                                                <dd class="drop-down-option">
                                                    <a href="/customer/orders">My Order</a>
                                                </dd>
                                                <dd class="drop-down-option">
                                                    <a href="/tracks/track_order">Track Order</a>
                                                </dd>
                                                <dd class="drop-down-option">
                                                    <a href="/customer/points_history">My Point</a>
                                                </dd>
                                                <dd class="drop-down-option">
                                                    <a href="/customer/profile">My Profile</a>
                                                </dd>
                                            </dl>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <li class="mybag drop-down JS-show" id="mybagli1">
                                        <div class="drop-down-hd">
                                            <span><a href="/cart/view">MY BAG</a></span>
                                            <a href="/cart/view" class="rum cart_count">0</a>
                                        </div>
                                        <div class="mybag-box JS-showcon hide" style="display:none;">
                                            <span class="topicon" style="right: 23px;"></span>
                                            <div class="mybag-con">
                                                <h4 class="tit">MY SHOPPING BAG</h4>
                                                <p class="cart_bag_empty cart-empty-info" style="display:none;">Your shopping bag is empty!</p>
                                                <p class="cart_button_empty" style="display:none;">
                                                    <a href="/cart/view" class="btn btn-primary btn-lg">VIEW MY BAG</a>
                                                </p>
                                                <div class="items">
                                                    <ul class="cart_bag"></ul>
                                                </div>
                                                <div class="cart-all-goods">
                                                    <p>
                                                        <strong class="cart_count">2</strong>
                                                        item<span class="cart_s"></span> in your bag
                                                    </p>
                                                    <strong>Total: <span class="cart_amount"></span></strong>
                                                </div>
                                                <p class="cart_button">
                                                    <a href="/cart/view" class="btn btn-default btn-sm">VIEW BAG</a>
                                                    <a href="/cart/checkout" class="btn btn-primary btn-sm">PAY NOW</a>
                                                </p>
                                            </div>
                                            <p class="free-shipping free_shipping" style="display:none;">Add1+ Item Marked "Free Shipping" <br>Enjoy Free Shipping Entire Order</p>
                                            <p class="free-shipping sale_words" style="display:none;"></p>
                                        </div>
                                    </li>
                                    <li class="mybag" id="mybag1">
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
                                <a class="logo" href="/" title=""></a>
                            </div>
                            <div class="col-sm-8 col-md-8">
                                <nav id="nav1" class="nav">
                                    <ul>
                                        <li class="JS-show">
                                            <a href="/daily-new">NEW IN</a>
                                            <div class="nav-list JS-showcon hide" style="width: 155px; margin-left: 136px;">
                                                <span class="topicon tpn01"></span>
                                                <ul>
                                                    <li>
                                                        <dl>
                                                            <?php
                                                            $today = strtotime('midnight');
                                                            $i = 0;
                                                            while ($i < 10):
                                                                $from = $today - $i * 86400 + 86400;
                                                                $i++;
                                                                ?>
                                                                <dt style="text-transform: capitalize;" class="newin">
                                                                    <a href="/daily-new/<?php echo $i - 1 ? $i - 1 : ''; ?>">
                                                                    <?php
                                                                    $m = date('m', $from - 1);
                                                                    if($m == 5)
                                                                        echo date('d M, Y', $from - 1);
                                                                    else
                                                                        echo date('d M., Y', $from - 1);
                                                                    ?>
                                                                    </a>
                                                                </dt>
                                                                <?php
                                                            endwhile;
                                                            ?>
                                                        </dl>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="JS-show">
                                            <a href="/apparels-c-40">APPAREL</a>
                                            <div class="nav-list JS-showcon hide">
                                                <span class="topicon tpn02"></span>
                                                <ul>
                                                    <li>
                                                        <dl>
                                                            <dt><a href="/tops">TOPS</a></dt>
                                                            <?php
                                                            $links = array(
                                                                array('T-shirts','t-shirts-c-245'),
                                                                array('Coats & Jackets','coats-jackets-c-45'),
                                                                array('Shirts & Blouses','shirt-blouse-c-43'),
                                                                array('Unreal Fur','unreal-fur-c-285'),
                                                                array('Two-piece Suits','two-piece-suit-c-177'),
                                                                array('Suits & Blazers','suits-blazers-c-46'),
                                                                array('Jumpers & Cardigans','jumpers-cardigans-c-90'),
                                                                array('Jumpsuits & Playsuits','jumpsuits-playsuits-c-119'),
                                                                array('Leather & Biker Jackets','leather-biker-jackets-c-120'),
                                                                array('Hoodies & Sweatshirts','hoodies-sweatshirts-c-117'),
                                                                array('Swimwear & Beachwear','swimwear-beachwear-c-178'),
                                                                array('Crop Tops & Bralets','crop-tops-bralets-c-244'),
                                                                array('Vests & Camis','vests-tanks-c-242'),
                                                            );
                                                            $hots=array("t-shirts-c-245","shirt-blouse-c-43","swimwear-beachwear-c-178");
                                                            ?>
                                                            <?php
                                                            foreach($links as $link)
                                                            {
                                                            ?>
                                                                <dd><a href="/<?php echo $link[1]; ?>" <?php if(in_array($link[1],$hots)){ echo 'style="color:#ba2325;"'; }?>><?php echo $link[0]; ?></a></dd>
                                                            <?php
                                                            }
                                                            ?>
                                                        </dl>
                                                        <dl>
                                                            <dt><a href="/bottoms-c-240">BOTTOMS</a></dt>
                                                            <?php
                                                            $hots = array(
                                                                99
                                                            );
                                                            $catalog1 = DB::select('id')->from('products_category')->where('link', '=', 'bottoms')->execute()->get('id');
                                                            $catalogs = Catalog::instance($catalog1)->children();
                                                            foreach ($catalogs as $catalog):
                                                                $link = Catalog::instance($catalog)->permalink();
                                                                $name = Catalog::instance($catalog)->get('name');
                                                                ?>
                                                                <dd><a href="<?php echo $link; ?>" <?php if(in_array($catalog, $hots)) echo 'style="color:#ba2325;"'; ?>><?php echo ucfirst($name); ?></a></dd>
                                                                <?php
                                                            endforeach;
                                                            ?>
                                                        </dl>
                                                    </li>
                                                    <li>
                                                        <dl>
                                                            <dt><a href="/dresses-c-92">DRESSES</a></dt>
                                                            <?php
                                                            $links = array(
                                                                array('Maxi Dresses', '/maxi-dresses-c-207'),
                                                                array('Black Dresses', '/black-dresses-c-203'),
                                                                array('White Dresses', '/white-dresses-c-204'),
                                                                array('Bodycon Dresses', '/bodycon-dresses-c-211'),
                                                                array('Off Shoulder Dresses', '/off-the-shoulder-dresses-c-504'),
                                                                array('Backless Dresses', '/backless-dress-c-456'),
                                                                array('Lace Dresses', '/lace-dresses-c-209'),
                                                                array('Homecoming Dresses', '/homecoming-dresses-c-454'),
                                                                array('Short Sleeve Dresses', '/short-sleeve-dresses-c-505'),
                                                                array('Long Sleeve Dresses', '/long-sleeve-dresses-c-507'),
                                                            );
                                                            $hot_dresses=array("maxi-dresses-c-207","off-the-shoulder-dresses-c-504","lace-dresses-c-209");
                                                            foreach ($links as $link):
                                                                ?>
                                                                <dd><a href="<?php echo $link[1]; ?>" <?php if(in_array($link[0],$hot_dresses)){ echo 'style="color:#ba2325;"'; }?>><?php echo $link[0]; ?></a></dd>
                                                                <?php
                                                            endforeach;
                                                            ?>
                                                        </dl>
                                                        <dl>
                                                            <dt><a href="/men-s-collection-c-91">MEN</a></dt>
                                                            <?php
                                                            $catalog1 = DB::select('id')->from('products_category')->where('link', '=', 'men-s-collection')->execute()->get('id');
                                                            $catalogs = Catalog::instance($catalog1)->children();
                                                            foreach ($catalogs as $catalog):
                                                                ?>
                                                                <dd><a href="<?php echo Catalog::instance($catalog)->permalink(); ?>"><?php echo ucfirst(Catalog::instance($catalog)->get('name')); ?></a></dd>
                                                                <?php
                                                            endforeach;
                                                            ?>
                                                        </dl>
                                                    </li>
                                                    <li>
                                                        <dl>
                                                            <dt>
                                                                <a href="/apparels-c-40/new">NEW IN</a>
                                                            </dt>
                                                            <dd>
                                                                <a href="#"></a>
                                                            </dd>
                                                        </dl>
                                                        <dl>
                                                            <dt><a href="/top-sellers-c-463">Top Sellers</a></dt>
                                                            <dd><a href="#"></a></dd>
                                                        </dl>
                                                        <dl>
                                                            <dt><a href="/outlet-c-101">SALE</a></dt>
                                                            <dd><a href="#"></a></dd>
                                                            <dd><a href="#"></a></dd>
                                                        </dl>
                                                        <dl>
                                                            <dt><a href="<?php echo LANGPATH; ?>/activity/flash_sale?1112">FLASH SALE</a></dt>
                                                            <dd><a href="#"></a></dd>
                                                        </dl>
                                                        <!--<dl>
                                                            <dt>OUR EDITS</dt>
                                                            <dd><a href="/activity/oversized_outerwear_trend">Oversized Coats</a></dd>
                                                            <dd><a href="/activity/party_wear">Party Wear</a></dd>
                                                            <dd><a href="/tartan-grid-check-collection">Tartan Rocks</a></dd>
                                                            <dd><a href="/choieslooks/vol1">Mix & Match</a></dd>
                                                            <dd><a href="/burgundy-wine-red-fall-winter-2013-color-trend-collection">Color Trend - Wine Red</a></dd>
                                                            <dd><a href="/deep-lichen-green-fall-winter-2013-color-trend-collection">Color Trend - Deep Green</a></dd>
                                                        </dl>-->
                                                        <dl>
                                                            <?php
                                                            $apparel_banners = DB::select()->from('banners')->where('type', '=', 'apparel')->where('visibility', '=', 1)->where('lang', '=', '')->execute()->as_array();
                                                            ?>
                                                            <a href="<?php echo $apparel_banners[0]['link']; ?>"><img src="<?php echo STATICURL; ?>/simages/<?php echo $apparel_banners[0]['image']; ?>" /></a>
                                                        </dl>
                                                    </li>
                                                    <li class="last">
                                                    <dl>
                                                        <dt style="padding-bottom: 20px;"><a href="/lookbook">LOOKBOOKS & GUIDES</a></dt>
                                                        <dl>
                                                            <a href="<?php echo $apparel_banners[1]['link']; ?>"><img src="<?php echo STATICURL; ?>/simages/<?php echo $apparel_banners[1]['image']; ?>" width="190px" /></a>
                                                        </dl>
                                                    </dl>
                                                </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="JS-show">
                                            <a href="/shoes-c-53">SHOES</a>
                                            <div class="nav-list JS-showcon hide" style="width: 174px; margin-left: 118px;">
                                                <span class="topicon tpn03"></span>
                                                <ul>
                                                    <li style="width: 140px;">
                                                        <dl>
                                                            <dt><a href="/shoes-c-53/new">NEW IN</a></dt>
                                                            <?php
                                                            $shoes = DB::select('id')->from('products_category')->where('link', '=', 'shoes')->execute()->get('id');
                                                            $shoes_catalogs = Catalog::instance($shoes)->children();
                                                            foreach ($shoes_catalogs as $catalog):
                                                                ?>
                                                                <dt><a href="<?php echo Catalog::instance($catalog ,LANGUAGE)->permalink(); ?>"><?php echo ucfirst(Catalog::instance($catalog)->get('name')); ?></a></dt>
                                                                <?php
                                                            endforeach;
                                                            ?>
                                                        </dl>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="JS-show">
                                            <a href="/accessory-c-52">ACCESSORIES</a>
                                            <?php
                                            $accessory = DB::select('id')->from('products_category')->where('link', '=', 'accessory')->execute()->get('id');
                                            $accessory_catalogs = Catalog::instance($accessory)->children();
                                            $count = count($accessory_catalogs);
                                            ?>
                                            <div class="nav-list JS-showcon hide" style="width: 415px; margin-left: 40px;">
                                                <span class="topicon tpn04"></span>
                                                <ul>
                                                    <li>
                                                        <dl>
                                                            <dt><a href="/accessory-c-52/new">NEW IN</a></dt>
                                                            <?php
                                                            for ($i = 0; $i < 11; $i++)
                                                            {
                                                                if (!isset($accessory_catalogs[$i]))
                                                                    continue;
                                                                $catalog = $accessory_catalogs[$i];
                                                                $clink = Catalog::instance($catalog ,LANGUAGE)->permalink();
                                                                ?>
                                                                <dt><a href="<?php echo $clink; ?>"><?php echo ucfirst(Catalog::instance($catalog)->get('name')); ?></a></dt>
                                                                <?php
                                                            }
                                                            ?>
                                                        </dl>
                                                    </li>
                                                    <li style="padding-bottom: 0;">
                                                        <dl>
                                                            <?php
                                                            for ($i = 11; $i <= $count; $i++)
                                                            {
                                                                if (!isset($catalogs[$i]))
                                                                    continue;
                                                                $catalog = $catalogs[$i];
                                                                ?>
                                                                <dt><a href="<?php echo Catalog::instance($catalog ,LANGUAGE)->permalink(); ?>"><?php echo ucfirst(Catalog::instance($catalog)->get('name')); ?></a></dt>
                                                                <?php
                                                            }
                                                            ?>
                                                            <dt>
                                                            <?php
                                                            $accessory_banners = DB::select()->from('banners')->where('type', '=', 'accessory')->where('visibility', '=', 1)->where('lang', '=', '')->execute()->as_array();
                                                            if(isset($accessory_banners[0]))
                                                            {
                                                            ?>
                                                                <a href="<?php echo $accessory_banners[0]['link']; ?>"><img src="<?php echo STATICURL; ?>/simages/<?php echo $accessory_banners[0]['image']; ?>" alt="<?php echo $accessory_banners[0]['alt']; ?>" title="<?php echo $accessory_banners[0]['title']; ?>" /></a>
                                                            <?php
                                                            }
                                                            ?>
                                                            </dt>
                                                        </dl>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="JS-show">
                                            <a href="/outlet-c-101?hp" class="sale">SALE</a>
                                            <div class="nav-list JS-showcon hide" style="width: 400px; margin-left: 112px;">
                                                <span class="topicon tpn05"></span>
                                                <ul>
                                                    <li>
                                                        <dl>
                                                            <dt><a href="/salute-the-spring-c-508">SPRING SALE</a></dt>
                                                            <br>
                                                            <dt><a href="/activity/flash_sale">FLASH SALE</a></dt>
                                                            <br>
                                                            <dt>BY PRICE</dt>
                                                            <dd><a href="/usd2-c-501" style="color:#ba2325;">USD1.9</a></dd>
                                                            <dd><a href="/usd-9-c-415?0814" style="color:#ba2325;">USD9.9</a></dd>
                                                            <dd><a href="/usd-13-c-464">USD13.9</a></dd>
                                                            <dd><a href="/usd-16-c-465">USD16.9</a></dd>
                                                            <dd><a href="/usd20-c-170">USD19.9</a></dd>
                                                            <dd><a href="/usd30-c-171">USD29.9</a></dd>
                                                            <br>
                                                            <dt>BY DEPARTMENT</dt>
                                                            <?php
                                                            $outlet = DB::select('id')->from('products_category')->where('link', '=', 'outlet')->execute()->get('id');
                                                            $outlets = Catalog::instance($outlet)->children();
                                                            foreach ($outlets as $c)
                                                            {
                                                                $link = Catalog::instance($c ,LANGUAGE)->permalink();
                                                                if (strpos($link, 'usd') === False)
                                                                {
                                                                    ?>
                                                                    <dd><a href="<?php echo $link; ?>"><?php echo Catalog::instance($c)->get('name'); ?></a></dd>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                            <br>
                                                        </dl>
                                                    </li>
                                                </ul>
                                                <?php
                                                $activities_banners = DB::select()->from('banners')->where('type', '=', 'activities')->where('visibility', '=', 1)->where('lang', '=', '')->execute()->as_array();
                                                if(isset($activities_banners[1]))
                                                {
                                                ?>
                                                    <a href="<?php echo $activities_banners[1]['link']; ?>"><img src="<?php echo STATICURL; ?>/simages/<?php echo $activities_banners[1]['image']; ?>" alt="<?php echo $activities_banners[1]['alt']; ?>" title="<?php echo $activities_banners[1]['title']; ?>" /></a>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </li>
                                        <li class="JS-show">
                                            <a href="#">ACTIVITIES</a>
                                            <div class="nav-list JS-showcon hide" style="left: -277px; width: 610px;">
                                                <span class="topicon tpn06"></span>
                                                <ul>
                                                    <li style="padding-bottom: 0px;">
                                                        <dl>
                                                            <dt><a href="/activity/catalog/presale-from-choies">ORIGINAL DESIGNS</a></dt>
                                                        </dl>
                                                        <dl>
                                                            <dt>FEATURES</dt>
                                                            <dd><a href="/freetrial/add">Free Trial Center</a></dd>
                                                            <dd><a href="/rate-order-win-100">Rate to Win $100</a></dd>
                                                        </dl>
                                                    </li>
                                                    <li style="padding-bottom: 0px;">
                                                        <dl>
                                                            <dt>TRENDS</dt>
                                                            <dd><a href="/activity/skirt_looks">Skirt Looks</a></dd>
                                                            <dd><a href="/tropical-palm-tree-print-c-447">Palm Tree Print</a></dd>
                                                            <dd><a href="/off-shoulder-c-444">Off Shoulder</a></dd>
                                                            <dd><a href="/activity/stripes_collection">Magical Stripes</a></dd>
                                                            <dd><a href="/crochet-lace-c-419">Crochet Lace</a></dd>
                                                            <dd><a href="/activity/only_florals">Only Florals</a></dd>
                                                            <dd><a href="/kimonos-c-414?sort=0&limit=1">Kimono Style</a></dd>
                                                        </dl>
                                                    </li>
                                                    <li style="padding-bottom: 0px;">
                                                        <dl>
                                                            <dt><a href="/lookbook">LOOKBOOK</a></dt>
                                                        </dl>
                                                        <?php if(isset($activities_banners[1])): ?>
                                                        <dl>
                                                            <dt><a href="<?php echo $activities_banners[0]['link']; ?>"><img src="<?php echo STATICURL; ?>/simages/<?php echo $activities_banners[0]['image']; ?>" /></a></dt>
                                                        </dl>
                                                        <?php endif; ?>
                                                    </li>
                                                    <li style="width:318px">
                                                        <dl>
                                                            <dt>SOCIAL & MEDIA</dt>
                                                            <dd class="sns fix">
                                                                <a  href="http://www.facebook.com/choiescloth" target="_blank" class="sns1"></a>
                                                                <a  href="http://twitter.com/#!/choiescloth" target="_blank" class="sns2"></a>
                                                                <a  href="http://thatisstylish.tumblr.com" target="_blank" class="sns3"></a>
                                                                <a  href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4"></a>
                                                                <a  href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a>
                                                                <!--<a  href="http://www.chictopia.com/Choies" target="_blank" class="sns6"></a>-->
                                                                <a  href="http://instagram.com/choiescloth" target="_blank" class="sns7"></a>
                                                                <a  href="http://blog.choies.com" target="_blank" class="sns8"></a>
                                                                <!--<a  href="http://wanelo.com/store/choies" target="_blank" class="sns9"></a>-->
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
                                        $searchword=DB::select('name')->from('search_hotword')->where('active', '=', 1)->where('type', '=', 1)->where('lang', '=', 'en')->where('site_id', '=', 1)->execute()->get('name');
                                    ?>
                                    <form action="/search" method="get" id="search_form" onsubmit="return search(this);">
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
                                            location.href = "/search/" + q.replace(/\s/g, '_');
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
                            <div class="col-sm-2 col-sm-2">
                                <a href="/" class="home nav-home"></a>
                            </div>
                            <div class="col-sm-8 col-sm-8">
                                <nav id="nav2" class="nav"></nav>
                            </div>
                            <div  class="col-sm-2 col-sm-2">
                                <div class="mybag drop-down JS-show" id="mybagli2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="phone-nav-wrapper">
                    <div class="container">
                        <div class="row">
                            <div id="phone-navbar" class="col-sm-12">
                                <a class="logo" href="/" title=""></a>
                                <div class="mybag">
                                    <a href="/cart/view" class="rum cart_count"></a>
                                </div>
                                <a href="/customer/summary" class="fa fa-user"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="phone-navbar">
                    <div class="container">
                        <div class="row">
                            <div>
                                <div class="search-box">
                                <form action="/search" method="get" onsubmit="return search1('searchwords');">
                                    <input type="search" name="searchwords" id="searchwords" class="form-control" style="padding-right:30px">
                                    <a class="fa fa-search" onclick="return search1('searchwords');"></a>
                                </form>
                                <script type="text/javascript">
                                    function search1(id)
                                    {
                                        var q = document.getElementById(id).value;
                                        location.href = "<?php echo LANGPATH; ?>/search/" + q.replace(/\s/g, '_');
                                        return false;
                                    }
                                </script>
                                </div>
                                <nav class="navbar navbar-default" role="navigation">
                                    <div class="container-fluid">
                                        <!-- Toggle get grouped for better mobile display -->
                                        <div class="navbar-header">
                                            <button type="button" class="navbar-toggle">
                                                <span class="sr-only">Toggle navigation</span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                            </button>
                                        </div>

                                        <!-- Collect the nav links, forms, and other content for toggling -->
                                        <nav class="navbar-collapse collapse">
                                            <div class="ac-container">
                                                <div>
                                                    <input id="ac-1" name="accordion-1" type="radio" checked />
                                                    <label for="ac-1">NEW IN</label>
                                                    <article class="ac-small-hei1">
                                                        <ul class="ac-list">
                                                        <?php
                                                        $today = strtotime('midnight');
                                                        $i = 0;
                                                        while ($i < 10):
                                                            $from = $today - $i * 86400 + 86400;
                                                            $i++;
                                                            ?>
                                                            <li>
                                                                <a href="/daily-new/<?php echo $i - 1 ? $i - 1 : ''; ?>">
                                                                <?php
                                                                $m = date('m', $from - 1);
                                                                if($m == 5)
                                                                    echo date('d M, Y', $from - 1);
                                                                else
                                                                    echo date('d M., Y', $from - 1);
                                                                ?>
                                                                </a>
                                                            </li>
                                                            <?php
                                                        endwhile;
                                                        ?>
                                                        </ul>
                                                    </article>
                                                </div>
                                                <div>
                                                    <input id="ac-2" name="accordion-1" type="radio" checked />
                                                    <label for="ac-2">APPAREL<i class="fa fa-caret-down flr mt10 mr10"></i></label>
                                                    <article class="ac-small-hei1">
                                                        <ul class="ac-list">
                                                        <?php
                                                        $apparels_list = array(
                                                            'View All' => '/apparels',
                                                            'NEW IN' => '/apparels/new',
                                                            'DRESSES' => '/dresses',
                                                            'T-shirt' => '/t-shirt',
                                                            'Coats & Jackets' => '/coats-jackets',
                                                            'Jumpers & Cardigans' => '/jumpers-cardigans',
                                                            'Shirt & Blouse' => '/shirt-blouse',
                                                            'Hoodies & Sweatshirts' => '/hoodies-sweatshirts',
                                                            'Vests & Camis' => '/vests-tanks',
                                                            'Skirts' => '/skirts',
                                                            'Jeans' => '/jeans',
                                                            'Shorts' => '/shorts',
                                                        );
                                                        foreach($apparels_list as $name => $link)
                                                        {
                                                            ?>
                                                            <li>
                                                                <a href="<?php echo $link; ?>"><?php echo $name; ?></a>
                                                            </li>
                                                            <?php
                                                        }
                                                        ?>
                                                        </ul>
                                                    </article>
                                                </div>
                                                <div>
                                                    <input id="ac-3" name="accordion-1" type="radio" />
                                                    <label for="ac-3">SHOES<i class="fa fa-caret-down flr mt10 mr10"></i></label>
                                                    <article class="ac-small-hei2">
                                                        <ul class="ac-list">
                                                            <li>
                                                                <a href="/shoes">View All</a>
                                                            </li>
                                                            <li>
                                                                <a href="/shoes/new">NEW IN</a>
                                                            </li>
                                                            <?php
                                                            foreach ($shoes_catalogs as $shoe)
                                                            {
                                                                ?>
                                                                <li><a href="/<?php echo Catalog::instance($shoe ,LANGUAGE)->permalink(); ?>"><?php echo ucfirst(Catalog::instance($shoe)->get('name')); ?></a></li>
                                                                <?php
                                                            }
                                                            ?>
                                                        </ul>
                                                    </article>
                                                </div>
                                                <div>
                                                    <input id="ac-4" name="accordion-1" type="radio" />
                                                    <label for="ac-4">ACCESSORIES<i class="fa fa-caret-down flr mt10 mr10"></i></label>
                                                    <article class="ac-small-hei2">
                                                        <ul class="ac-list">
                                                            <li><a href="/accessory">View All</a></li>
                                                            <li><a href="/accessory/new">NEW IN</a></li>
                                                            <?php
                                                            for ($i = 0; $i < 11; $i++)
                                                            {
                                                                if (!isset($accessory_catalogs[$i]))
                                                                    continue;
                                                                $catalog = $accessory_catalogs[$i];
                                                                $clink = Catalog::instance($catalog ,LANGUAGE)->permalink();
                                                                ?>
                                                                <li><a href="/<?php echo $clink; ?>"><?php echo ucfirst(Catalog::instance($catalog)->get('name')); ?></a></li>
                                                                <?php
                                                            }
                                                            ?>
                                                        </ul>
                                                    </article>
                                                </div>
                                                <div>
                                                    <input id="ac-5" name="accordion-1" type="radio" checked />
                                                    <label for="ac-5"><a href="/outlet">SALE</a></label>
                                                </div>
                                                <div>
                                                    <input id="ac-6" name="accordion-1" type="radio" checked />
                                                    <label for="ac-6"><a href="/activity/flash_sale">FLASH SALE</a></label>
                                                </div>
                                                <div>
                                                    <input id="ac-7" name="accordion-1" type="radio" checked />
                                                    <label for="ac-7"><a href="/top-sellers">TOP SELLER</a></label>
                                                </div>
                                            </div>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
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
            <?php
            if (isset($content))
                echo $content;
            ?>

            <?php
            if ($type != 'payment' && $type != 'purchase' && $type != 'cart')
            {
            ?>
            <footer>
                <div class="w-top container-fluid">
                    <div class="container">
                        <div class="currency visible-xs-block hidden-sm hidden-md hidden-lg xs-mobile">
                            <div class="row">
                                <div class="currency-con">
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
                                        <dt>
                                        <?php
                                        }
                                            ?>
                                            <a href="<?php echo $path . $request; ?>"><?php echo $lang; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?php
                                        if($key % 2 == 1)
                                        {
                                        ?>
                                        </dt>
                                        <?php
                                        }
                                        $key ++;
                                    }
                                    ?>
                                    </dl>
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
                                        if($key % 2 == 0)
                                        {
                                        ?>
                                        <dl class="sites col-xs-12">
                                        <?php
                                        }
                                            ?>
                                            <dd class="col-xs-6"  onclick="location.href='<?php echo LANGPATH; ?>/currency/set/<?php echo $currency['name'] ?>'">
                                                <a class="icon-flag icon-<?php echo strtolower($currency['name']); ?>" href="<?php echo LANGPATH; ?>/currency/set/<?php echo $currency['name'] ?>"><?php echo $currency['fname']; ?></a>
                                            </dd>
                                            <?php
                                        if($key % 2 == 1)
                                        {
                                        ?>
                                        </dl>
                                        <?php
                                        }
                                        $key ++;
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>

                        <div class="fix row">
                            <dl class="hidden-xs col-sm-2">
                                <dt>MY ACCOUNT</dt>
                                <dd><a href="/tracks/track_order">Track Order</a></dd>
                                <dd><a href="/customer/orders">Order History</a></dd>
                                <dd><a href="/customer/profile">Account Setting</a></dd>
                                <dd><a href="/customer/points_history">Points History</a></dd>
                                <dd><a href="/customer/wishlist">Wish List</a></dd>
                                <dd><a href="/vip-policy">VIP Policy</a></dd>
                                <dd><a onclick="return feed_show();">Feedback</a></dd>
                            </dl>
                            <dl class="hidden-xs col-sm-2">
                                <dt>HELP INFO</dt>
                                <dd><a href="/faqs">FAQ</a></dd>
                                <dd><a href="/contact-us">Contact Us</a></dd>
                                <dd><a href="/payment">Payment</a></dd>
                                <dd><a href="/coupon-points">Coupon &amp; Points</a></dd>
                                <dd><a href="/shipping-delivery">Shipping &amp; Delivery</a></dd>
                                <dd><a href="/returns-exchange">Returns &amp; Exchange</a></dd>
                                <dd><a href="/conditions-of-use">Conditions of Use</a></dd>
                                <dd><a href="/how-to-order">How To Order</a></dd>
                            </dl>
                            <dl class="hidden-xs col-sm-2">
                                <dt>FEATURED</dt>
                                <dd><a href="/lookbook">Lookbook</a></dd>
                                <dd><a href="/freetrial/add">Free Trial</a></dd>
                                <dd><a href="/activity/flash_sale">Flash Sale</a></dd>
                                <dd><a href="/wholesale">Wholesale</a></dd>
                                <dd><a href="/affiliate-program">Affiliate Program</a></dd>
                                <dd><a href="/blogger/programme">Blogger Wanted</a></dd>
                                <dd><a href="/rate-order-win-100" style="color:red;">Rate &amp; Win $100</a></dd>
                            </dl>
                            <dl class="hidden-xs col-sm-2">
                                <dt>ALL SITES</dt>
                                <dd><a href="<?php echo $request; ?>">English Site</a></dd>
                                <dd><a href="/es<?php echo $request; ?>">Spanish Site</a></dd>
                                <dd><a href="/fr<?php echo $request; ?>">French Site</a></dd>
                                <dd><a href="/de<?php echo $request; ?>">German Site</a></dd>
                                <dd><a href="/ru<?php echo $request; ?>">Russian Site</a></dd>
                            </dl>
                            <dl class="col-xs-12 col-sm-4 xs-mobile">
                                <dt>Find Us On</dt>
                                <dl class="sns">
                                    <dd><a  href="http://www.facebook.com/choiescloth" target="_blank" class="sns1" title="facebook"></a></dd>
                                    <dd><a  href="http://twitter.com/#!/choiescloth" target="_blank" class="sns2" title="twitter"></a></dd>
                                    <dd><a  href="http://thatisstylish.tumblr.com" target="_blank" class="sns3" title="tumblr"></a></dd>
                                    <dd><a  href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4" title="youtube"></a></dd>
                                    <dd><a  href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a></dd>
                                    <!--<dd><a  href="http://www.chictopia.com/Choies" target="_blank" class="sns6" title="chictopia"></a></dd>-->
                                    <dd><a  href="http://instagram.com/choiescloth" target="_blank" class="sns7" title="instagram"></a></dd>
                                    <!--<dd><a  href="http://wanelo.com/store/choies" target="_blank" class="sns9" title="wanelo"></a></dd>-->
                                </dl>
                                <dl class="letter">
                                    <form action="" method="post" id="letter_form">
                                        <label>SIGN UP FOR OUR EMAILS</label>
                                        <div>
                                            <input type="text" id="letter_text" class="text fll" value="Email Address" onblur="if(this.value==''){this.value=this.defaultValue;}"  onfocus="if(this.value=='Email Address'){this.value='';};" />
                                            <input type="submit" id="letter_btn" value="Submit" class="btn btn-primary" />
                                        </div>
                                    </form>
                                </dl>
                                <div class="red hide" id="letter_message"></div>
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
                            </dl>
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <dt><a href="/customer/summary">MY ACCOUNT&nbsp;&bull;</a><a href="/tracks/track_order">&nbsp;TRACK ORDER&nbsp;&bull;</a><a href="/customer/orders">&nbsp;ORDER HISTORY</a></dt>
                            </dl>
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <dd><a href="/lookbook">LOOK BOOKS&nbsp;&bull;</a><a href="/vip-policy">&nbsp;VIP POLICY&nbsp;</a></dd>
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
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <dt><a href="/about-us">About Us&nbsp;&bull;</a><a href="/contact-us">&nbsp;Contact Us&nbsp;&bull;</a><a href="/conditions-of-use">&nbsp;Conditions of Use&nbsp;&bull;</a><a href="/privacy-security">&nbsp;Privacy&Security</a></dt>
                            </dl>
                        </div>
                    </div>
                    <div class="copyr hidden-xs">
                        <p class="bottom container-fluid">Copyright © 2006-2015 Choies.com&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="/privacy-security">Privacy &amp; Security</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="/about-us">About Choies</a>
                        </p>
                    </div>
                </div>
            </footer>
            <div id="gotop" class="hide ">
                <a href="#" class="xs-mobile-top"></a>
            </div>

            <script type="text/javascript">
                $(function(){
                    //                                $(".feed").live('click', function(){
                    //                                        $(".f_email").val('');
                    //                                        $("#f_comment").val('');
                    //                                        $('body').append('<div id="wingray2" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                    //                                        $('#feedback').appendTo('body').fadeIn(240);
                    //                                })
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
                    $('body').append('<div id="wingray2" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                    $('#feedback').appendTo('body').fadeIn(240);
                }
            </script>

            <div id="feedback" style="display:none;">
                <div class="feedback">
                    <div class="feedback_title">
                        <div class="fll text1">CHOIES WANT TO HEAR YOUR VOICE!</div>
                        <div class="close_btn3 clsbtn" style="right: 0px;top: 3px;"></div>
                    </div>
                    <div class="clear"></div>
                    <div class="point ml15 mt5">Those who provide significant feedbacks can get <strong class="red">$5 Points</strong> Reward.</div>
                    <div id="tab6">
                        <div id="tab-nav" class="JS_tab5">
                            <ul class="fix">
                                <li class="on">FEEDBACK</li>
                                <li>PROBLEM?</li>
                            </ul>
                        </div>
                        <div id="tab-con" class="JS_tabcon5">
                            <div>
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
                                            <label for="Email Address:"><span>*</span> Email Address:<span class="errorInfo clear hide">Please enter your email.</span><br/>
                                            </label>
                                            <input type="email" name="email" id="f_email1" class="text text_long" value="" maxlength="340" />
                                        </li>
                                        <li>
                                            <input type="submit" value="SUBMIT" class="view_btn btn26 btn40 form_btn" style="width: 100px;" />
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
                                            password: {
                                                minlength: "Your password must be at least 5 characters long."
                                            }
                                        }
                                    });
                                </script>
                            </div>
                            <div class="hide">
                                <form id="problemForm" method="post" action="#" class="form formArea">
                                    <ul>
                                        <li>
                                            <label for="My Suggestion:"><span>*</span> Need help? Please describe the problem: <span class="errorInfo clear hide">Please write something here.</span></label>
                                            <textarea name="comment" id="f_comment" rows="7" class="input textarea"></textarea>
                                        </li>
                                        <li>
                                            <label for="Email Address:"><span>*</span> Email Address:<span class="errorInfo clear hide">Please enter your email.</span><br/>
                                            </label>
                                            <input type="email" name="email1" id="f_email2" class="text text_long" value="" maxlength="340" />
                                        </li>
                                        <li>
                                            <input type="submit" value="SUBMIT" class="view_btn btn26 btn40 form_btn" style="width: 100px;" />
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
                                            password: {
                                                required: "Please provide a comment.",
                                                minlength: "Your password must be at least 5 characters long."
                                            }
                                        }
                                    });
                                </script>
                                <p class="mt10">More detailed questions? Please <a href="https://chatserver.comm100.com/chatwindow.aspx?planId=311&siteId=203306" title="contact us" target="_blank">contact us</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="feedback_success" style="display:none;">
                <div class="feedback" style="height:200px;">
                    <div class="close_btn3 clsbtn" style="right: 0px;top: 3px;"></div>
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
        <script src="/assets/js/common.js"></script>
        <script src="/assets/js/slider.js"></script>
        <script src="/assets/js/plugin.js"></script>
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
                            }
                            else
                            {
                                $(".free_shipping").hide();
                                $(".sale_words").hide();
                            }
                            $(".cart_amount").html(msg['cart_amount']);
                            $(".cart_bag").show();
                            $(".cart_bag_empty").hide();
                            $(".cart_button").show();
                            $(".cart_button_empty").hide();
                        }
                        else
                        {
                            $(".free-shipping").hide();
                            $(".cart_bag_empty").show();
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
            <script type="text/javascript">ScarabQueue.push(['go']);</script>
            <!-- HK ScarabQueue statistics Code -->
            <?php if (!in_array($type, array('cart','product', 'paysuccess','cart_view'))){ ?>
            <!-- cityads code -->
            <script id="xcntmyAsync" type="text/javascript"> 
            (function(d){ 
            var xscr = d.createElement( 'script' ); xscr.async = 1; 
            xscr.src = '//x.cnt.my/async/track/?r=' + Math.random(); 
            var x = d.getElementById( 'xcntmyAsync' ); 
            x.parentNode.insertBefore( xscr, x ); 
            })(document); 
            </script>
            <!-- cityads code -->
            <?php } ?>
            <!-- <script src="//cdn.optimizely.com/js/557241246.js"></script> -->
        </div>
        
    </body>
</html>