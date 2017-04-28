<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <!--[if IE]>
        <script src="/js/html5.js" type="text/javascript"></script>
        <![endif]-->
        <title><?php echo $title; ?></title>
        <meta name="keywords" content="<?php echo $keywords; ?>" />
        <meta name="description" content="<?php echo $description; ?>" />
        <meta property="fb:app_id" content="<?php echo Site::instance()->get('fb_api_id'); ?>" />
        <link type="image/x-icon" rel="shortcut icon" href="/favicon.ico" />
        <link type="text/css" rel="stylesheet" href="/css/all_1.css" media="all" id="mystyle" />
        <script src="/js/jquery-1.7.2.min.js"></script>
        <script src="/js/plugin.js"></script>
        <script src="/js/global.js"></script>
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
        <?php
        if(!empty($_GET))
        {
            $url = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?'));
            ?>
            <link rel="canonical" href="<?php echo $_SERVER['HTTP_HOST'] . $url; ?>"/>
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
        <link rel="image_src" href="<?php echo $c_image; ?>"/>
        <meta property="og:title" content="<?php echo $og_title; ?>" />
        <meta property="og:url" content="<?php echo BASEURL ;?><?php echo $c_url; ?>" />
        <meta property="og:description" content="<?php echo $og_description; ?>" />
        <meta property="og:image" content="<?php echo $c_image; ?>">
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
        ?>
        <!-- header begin -->
        <header>
            <div class="top">
                <div class="layout fix">
                    <div class="left fll">
                        <div class="currency JS_show">
                            <?php
                            $currency_now = Site::instance()->currency();
                            ?>
                            <a href="#" class="icon_flag icon_<?php echo strtolower($currency_now['name']); ?>"></a>
                            <div class="currency_con JS_showcon hide">
                                <form action="#" method="post">
                                    <dl class="sites">
                                        <?php
                                        $currencies = Site::instance()->currencies();
                                        foreach ($currencies as $currency)
                                        {
                                            if(strpos($currency['code'], '$') !== False)
                                                $code = '$';
                                            else
                                                $code = $currency['code'];
                                            ?>
                                            <dd onclick="location.href='<?php echo LANGPATH; ?>/currency/set/<?php echo $currency['name'] ?>'">
                                                <a href="<?php echo LANGPATH; ?>/currency/set/<?php echo $currency['name'] ?>" class="icon_flag icon_<?php echo strtolower($currency['name']); ?>"><?php echo $currency['fname']; ?></a>
                                            </dd>
                                            <?php
                                        }
                                        ?>
                                    </dl>
                                </form>
                            </div>
                        </div>
                        <span>
                            <?php
                            if(strpos($currency_now['code'], '$') !== False)
                                $code_now = '$';
                            else
                                $code_now = $currency_now['code'];
                            echo $code_now . $currency_now['name']; 
                            ?>
                        </span>
                        <span class="lang">
                        <?php
                        $request = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
                        $request = rawurldecode($request);
                        $request = Security::xss_clean($request);
                        $request = htmlentities($request);
                        /*
                        $request = rawurlencode($request);
                         */

                        ?>
                            <a href="<?php echo $request; ?>">English</a>
                            <a href="/es<?php echo $request; ?>">Español</a>
                            <a href="/de<?php echo $request; ?>">Deutsch</a>
                            <a href="/fr<?php echo $request; ?>">Français</a>
                            <a href="/ru<?php echo $request; ?>">Русский</a>
                        </span>
                    </div>

                    <div class="right flr">
                        <div id="comm100-button-311" class="tp-livechat"></div>
                        <a href="/faqs">Help</a>
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
                            Hello, <span title="<?php echo $firstname; ?>"><?php echo $fname; ?></span> !
                            <div class="JS_show" style="display:inline-block">
                                <a href="/customer/summary" rel="nofollow" class="myaccount ">MY ACCOUNT</a>
                                <div class="myaccount-hide JS_showcon hide" style="display: none;">
                                   <ul>
                                   <li><a href="/customer/orders" rel="nofollow">my order</a></li>
                                   <li><a href="/track/track_order" rel="nofollow">track order</a></li>
                                   <li><a href="/customer/points_history" rel="nofollow">my point</a></li>
                                   <li><a href="/customer/profile" rel="nofollow">my profile</a></li>
                                   <li><a href="/customer/logout" rel="nofollow">sign out</a></li>
                                   </ul>
                               </div>
                            </div>
                            <?php
                        }
                        else
                        {
                            ?>
                            <a href="/customer/login">Sign In</a>
                            <div class="JS_show" style="display:inline-block">
                                <a href="/customer/summary" rel="nofollow" class="myaccount ">MY ACCOUNT</a>
                                <div class="myaccount-hide JS_showcon hide" style="display: none;">
                                   <ul>
                                   <li><a href="/customer/orders" rel="nofollow">my order</a></li>
                                   <li><a href="/track/track_order" rel="nofollow">track order</a></li>
                                   <li><a href="/customer/points_history" rel="nofollow">my point</a></li>
                                   <li><a href="/customer/profile" rel="nofollow">my profile</a></li>
                                   </ul>
                               </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="mybag JS_show">
                            <a href="/cart/view">MY BAG<span class="rum cart_count">0</span></a>
                            <div class="mybag_box JS_showcon hide">
                                <span class="topicon"></span>
                                <div class="mybag_con">
                                    <h4 class="tit">MY SHOPPING BAG</h4>
                                    <div class="cart_bag items mtb5"></div>
                                    <div class="cart-all-goods mr20">
                                        <p><span class="bold mr5 cart_count"></span>item<span class="cart_s"></span> in your bag</p>
                                         <p class="bold">Total: <span class="cart_amount"></span></p>
                                    </div>
                                    <div class="cart_bag_empty cart-empty-info" style="display:none;">Your shopping bag is empty!</div>
                                    <p class="cart_button">
                                        <a href="/cart/view" class="btn30_14_black">VIEW BAG</a>
                                        <a href="/cart/checkout" class="btn30_14_red ml20">PAY NOW</a>
                                    </p>
                                    <p class="cart_button_empty" style="display:none;"><a href="/cart/view" class="btn40_16_red">VIEW MY BAG</a></p>
                                    <!--<p class="ppexpress mt10"><a href="javascript:void(0)" style="background:none;" onclick="location.href='/payment/ppec_set';" id="pp_express"><img src="/images/ppec.jpg" alt="Click here to pay via PayPal Express Checkout" style="vertical-align: middle;"></a></p>-->
                                </div>
                                <p class="free-shipping" id="free_shipping" style="display:none;">Add1+ Item Marked "Free Shipping" <br>Enjoy Free Shipping Entire Order</p>
                                <p class="free-shipping" id="sale_words" style="display:none;"></p>
                            </div>
                        </div>
                        <div class="mybag1" id="mybag1">
                            <div class="currentbag mybag_box hide">
                                <span class="topicon"></span>
                                <div class="mybag_con">
                                    <h4 class="tit">SUCCESS! ITEM ADDED TO BAG</h4>
                                    <div class="bag_items items mtb5">
                                        <li class="fix"></li>
                                        <p><a href="/cart/view" class="btn40_16_red">VIEW MY BAG</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div style="background-color:#232121;">
                <div class="bottom" id="nav_list">
                    <div class="layout">
                        <a href="/" class="logo" title=""></a>
                        <nav id="nav1" class="nav">
                            <ul class="fix">
                                <li class="JS_show">
                                    <a href="/daily-new">NEW IN</a>
                                    <div class="nav_list JS_showcon hide" style="width: 135px; margin-left: 225px;">
                                        <span class="topicon" style="left: 70px;"></span>
                                        <ul class="fix">
                                            <li style="padding-bottom: 0;width: 105px;">
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
                                <li class="JS_show">
                                    <a href="/apparels">APPAREL</a>
                                    <div class="nav_list JS_showcon apparel hide">
                                        <span class="topicon"></span>
                                        <ul class="fix new_list">
                                            <li>
                                                <dl>
                                                    <dt><a href="/tops">TOPS</a></dt>
                                                    <dd><a href="/t-shirts">T-shirts</a></dd>
                                                    <dd><a href="/coats-jackets" style="color:#ba2325;">Coats & Jackets</a></dd>
                                                    <dd><a href="/shirt-blouse">Shirts & Blouses</a></dd>
                                                    <dd><a href="/unreal-fur" style="color:#ba2325;">Unreal Fur</a></dd>
                                                    <dd><a href="/two-piece-suit">Two-piece Suits</a></dd>
                                                    <dd><a href="/suits-blazers">Suits & Blazers</a></dd>
                                                    <dd><a href="/jumpers-cardigans" style="color:#ba2325;">Jumpers & Cardigans</a></dd>
                                                    <dd><a href="/jumpsuits-playsuits">Jumpsuits & Playsuits</a></dd>
                                                    <dd><a href="/leather-biker-jackets">Leather & Biker Jackets</a></dd>
                                                    <dd><a href="/hoodies-sweatshirts" style="color:#ba2325;">Hoodies & Sweatshirts</a></dd>
                                                    <dd><a href="/swimwear-beachwear">Swimwear & Beachwear</a></dd>
                                                    <dd><a href="/crop-tops-bralets">Crop Tops & Bralets</a></dd>
                                                    <dd><a href="/vests-tanks">Vests & Camis</a></dd>
                                                </dl>
                                                <dl>
                                                    <dt><a href="/bottoms">BOTTOMS</a></dt>
                                                    <?php
                                                    $hots = array(
                                                        'skirt'
                                                    );
                                                    $catalog1 = DB::select('id')->from('products_category')->where('link', '=', 'bottoms')->execute()->get('id');
                                                    $catalogs = Catalog::instance($catalog1)->children();
                                                    foreach ($catalogs as $catalog):
                                                        $link = Catalog::instance($catalog)->get('link');
                                                        ?>
                                                        <dd><a href="/<?php echo $link; ?>" <?php if(in_array($link, $hots)) echo 'style="color:#ba2325;"'; ?>><?php echo ucfirst(Catalog::instance($catalog)->get('name')); ?></a></dd>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </dl>
                                            </li>
                                            <li>
                                                <dl>
                                                    <dt><a href="/dresses">DRESSES</a></dt>
                                                    <?php
                                                    $links = array(
                                                        array('Maxi Dresses', '/dresses/all/all/Dresses-Length_maxi'),
                                                        array('Black Dresses', '/dresses/all/all/color_black'),
                                                        array('White Dresses', '/dresses/all/all/color_14'),
                                                        array('Bodycon Dresses', '/dresses/all/all/Silhouette_bodycon'),
                                                        array('Off Shoulder Dresses', '/dresses/all/all/Neckline_41'),
                                                        array('Backless Dresses', '/backless-dress'),
                                                        array('Lace Dresses', '/dresses/all/all/Detail_lace'),
                                                        array('Homecoming Dresses', '/homecoming-dress'),
                                                        array('Short Sleeve Dresses', '/dresses/all/all/Sleeve-Length_53'),
                                                        array('Long Sleeve Dresses', '/dresses/all/all/Sleeve-Length_long-sleeve'),
                                                    );
                                                    $hot_dresses=array("Maxi Dresses","Off Shoulder Dresses","Lace Dresses");
                                                    foreach ($links as $link):
                                                        ?>
                                                        <dd><a href="<?php echo $link[1]; ?>" <?php if(in_array($link[0],$hot_dresses)){ echo 'style="color:#ba2325;"'; }?>><?php echo $link[0]; ?></a></dd>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </dl>
                                                <dl>
                                                    <dt><a href="/men-s-collection">MEN</a></dt>
                                                    <?php
                                                    $catalog1 = DB::select('id')->from('products_category')->where('link', '=', 'men-s-collection')->execute()->get('id');
                                                    $catalogs = Catalog::instance($catalog1)->children();
                                                    foreach ($catalogs as $catalog):
                                                        ?>
                                                        <dd><a href="/<?php echo Catalog::instance($catalog)->get('link'); ?>"><?php echo ucfirst(Catalog::instance($catalog)->get('name')); ?></a></dd>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </dl>
                                            </li>
                                            <li>
                                                <dl>
                                                    <dt><a href="/apparels/new">NEW IN</a></dt>
                                                    <dd><a href="#"></a></dd>
                                                </dl>
                                                <dl>
                                                    <dt><a href="/top-sellers">Top Sellers</a></dt>
                                                    <dd><a href="#"></a></dd>
                                                </dl>
                                                <dl>
                                                    <dt><a href="/outlet">SALE</a></dt>
                                                    <dd><a href="#"></a></dd>
                                                    <dd><a href="#"></a></dd>
                                                </dl>
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/activity/flash_sale?1112">FLASH SALE</a></dt>
                                                    <dd><a href="#"></a></dd>
                                                </dl>
                                                <!--                                            <dl>
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
                                                    <a href="<?php echo $apparel_banners[0]['link']; ?>"><img src="http://img.choies.com/uploads/1/files/<?php echo $apparel_banners[0]['image']; ?>" /></a>
                                                </dl>
                                            </li>
                                            <li class="last">
                                                <dl>
                                                    <dt style="padding-bottom: 20px;"><a href="/lookbook">LOOKBOOKS & GUIDES</a></dt>
                                                    <!--                                                <dd>
                                                                                                        <a href="#"><img src="/images/pr190.jpg" /></a>
                                                                                                        <a href="#" class="name">Long Sleeve Slim Dress </a>
                                                                                                    </dd>-->
                                                    <dl>
                                                        <a href="<?php echo $apparel_banners[1]['link']; ?>"><img src="http://img.choies.com/uploads/1/files/<?php echo $apparel_banners[1]['image']; ?>" width="190px" /></a>
                                                    </dl>
                                                </dl>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="JS_show">
                                    <a href="/shoes">SHOES</a>
                                    <div class="nav_list JS_showcon hide" style="width: 174px; margin-left: 205px;">
                                        <span class="topicon" style="left: 90px;"></span>
                                        <ul class="fix accessories">
                                            <li style="padding-bottom: 0;width: 140px;">
                                                <dl>
                                                    <dt><a href="/shoes/new">NEW IN</a></dt>
                                                    <?php
                                                    $catalog1 = DB::select('id')->from('products_category')->where('link', '=', 'shoes')->execute()->get('id');
                                                    $catalogs = Catalog::instance($catalog1)->children();
                                                    foreach ($catalogs as $catalog):
                                                        ?>
                                                        <dt><a href="/<?php echo Catalog::instance($catalog)->get('link'); ?>"><?php echo ucfirst(Catalog::instance($catalog)->get('name')); ?></a></dt>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </dl>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="JS_show">
                                    <a href="/accessory">ACCESSORIES</a>
                                    <?php
                                    $catalog1 = DB::select('id')->from('products_category')->where('link', '=', 'accessory')->execute()->get('id');
                                    $catalogs = Catalog::instance($catalog1)->children();
                                    $count = count($catalogs);
                                    ?>
                                    <div class="nav_list JS_showcon hide" style="<?php if ($count > 11) echo 'width: 380px; margin-left: 140px;'; else echo 'width: 174px; margin-left: 230px;' ?>">
                                        <span class="topicon" style="left: <?php if ($count > 11) echo 185; else echo 90; ?>px;"></span>
                                        <ul class="fix accessories">
                                            <li style="padding-bottom: 0;">
                                                <dl>
                                                    <dt><a href="/accessory/new">NEW IN</a></dt>
                                                    <?php
                                                    for ($i = 0; $i < 11; $i++):
                                                        if (!isset($catalogs[$i]))
                                                            continue;
                                                        $catalog = $catalogs[$i];
                                                        $clink = Catalog::instance($catalog)->get('link');
                                                        ?>
                                                        <dt><a href="/<?php echo $clink; ?>"><?php echo ucfirst(Catalog::instance($catalog)->get('name')); ?></a></dt>
                                                        <?php
                                                        if($clink == 'scarves-snoods')
                                                        {
                                                            ?>
                                                            <dt><a href="/sand-river-baby-cashmere" style="color:red;">SAND RIVER</a></dt>
                                                            <?php
                                                        }
                                                    endfor;
                                                    ?>
                                                </dl>
                                            </li>
                                            <li style="padding-bottom: 0;">
                                                <dl>
                                                    <?php
                                                    for ($i = 11; $i <= $count; $i++):
                                                        if (!isset($catalogs[$i]))
                                                            continue;
                                                        $catalog = $catalogs[$i];
                                                        ?>
                                                        <dt><a href="/<?php echo Catalog::instance($catalog)->get('link'); ?>"><?php echo ucfirst(Catalog::instance($catalog)->get('name')); ?></a></dt>
                                                        <?php
                                                    endfor;
                                                    ?>
                                                    <dt>
                                                        <a href="/sand-river-baby-cashmere"><img src="/images/sand_river.jpg" /></a>
                                                    </dt>
                                                </dl>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="JS_show">
                                    <a href="/outlet?hp" class="sale">SALE</a>
                                    <div class="nav_list JS_showcon hide" style="width: 364px; margin-left: 202px;">
                                        <span class="topicon" style="left: 90px;"></span>
                                        <ul class="new_list fix" style="float:left;">
                                            <li style="padding-bottom: 0;">
                                                <dl>
                                                    <dt><a href="/christmas-sale">XMAS SALE</a></dt>
                                                    <br>
                                                    <dt><a href="/activity/flash_sale">FLASH SALE</a></dt>
                                                    <br>
                                                    <dt>BY PRICE</dt>
                                                    <dd><a href="/2014-summer-sale?0814" style="color:#ba2325;">USD9.9</a></dd>
                                                    <dd><a href="/usd-13">USD13.9</a></dd>
                                                    <dd><a href="/usd-16">USD16.9</a></dd>
                                                    <dd><a href="/usd20">USD19.9</a></dd>
                                                    <dd><a href="/usd30">USD29.9</a></dd>
                                                    <dd><a href="/usd40">USD39.9</a></dd>
                                                    <br>
                                                    <dt>BY DEPARTMENT</dt>
                                                    <?php
                                                    $outlet = DB::select('id')->from('products_category')->where('link', '=', 'outlet')->execute()->get('id');
                                                    $outlets = Catalog::instance($outlet)->children();
                                                    foreach ($outlets as $c)
                                                    {
                                                        $link = Catalog::instance($c)->get('link');
                                                        if (strpos($link, 'usd') === False)
                                                        {
                                                            ?>
                                                            <dd><a href="/<?php echo $link; ?>"><?php echo Catalog::instance($c)->get('name'); ?></a></dd>
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
                                            <a href="<?php echo $activities_banners[1]['link']; ?>"><img src="http://img.choies.com/uploads/1/files/<?php echo $activities_banners[1]['image']; ?>" alt="<?php echo $activities_banners[1]['alt']; ?>" title="<?php echo $activities_banners[1]['title']; ?>" /></a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </li>
                                <li class="JS_show">
                                    <a href="#">ACTIVITIES</a>
                                    <div class="nav_list JS_showcon hide" style="width: 780px;left:-500px;">
                                        <span class="topicon" style="left: 530px;"></span>
                                        <ul class="fix new_list">
                                            <li style="padding-bottom: 0px;">
                                                <dl>
                                                    <dt><a href="/activity/flash_sale?1112" style="background-color:#000; color:#fff;padding:0px 5px">FLASH SALE</a></dt>
                                                </dl>
                                                <dl>
                                                    <dt><a href="/activity/catalog/presale-from-choies">ORIGINAL DESIGNS</a></dt>
                                                </dl>
                                                <dl>
                                                    <dt>FEATURES</dt>
                                                    <dd><a href="/freetrial/add">Free Trial Center</a></dd>
                                                    <dd><a href="/sharewin/index">Share and Win</a></dd>
                                                    <dd><a href="/rate-order-win-100">Rate to Win $100</a></dd>
                                                </dl>
                                            </li>
                                            <li style="padding-bottom: 0px;">
                                                <dl>
                                                    <dt>TRENDS</dt>
                                                    <dd><a href="/activity/thanksgiving_looks">Thanksgiving Looks</a></dd>
                                                    <dd><a href="/activity/skirt_looks">Skirt Looks</a></dd>
                                                    <dd><a href="/tropical-palm-tree-print">Palm Tree Print</a></dd>
                                                    <dd><a href="/k-pop?0904">K POP Styles</a></dd>
                                                    <dd><a href="/off-shoulder">Off Shoulder</a></dd>
                                                    <dd><a href="/activity/stripes_collection">Magical Stripes</a></dd>
                                                    <dd><a href="/crochet-lace">Crochet Lace</a></dd>
                                                    <dd><a href="/lace-panel">Lace Panel</a></dd>
                                                    <dd><a href="/activity/only_florals">Only Florals</a></dd>
                                                </dl>
                                            </li>
                                            <li style="padding-bottom: 0px;">
                                                <dl>
                                                    <dt>HOT PIECES</dt>
                                                    <dd><a href="/activity/classic_white_shirt">Classic White Shirt</a></dd>
                                                    <dd><a href="/kimonos?sort=0&limit=1">Kimono Style</a></dd>
                                                </dl>
                                            </li>
                                            <li style="padding-bottom: 0px;">
                                                <dl>
                                                    <dt><a href="/lookbook">LOOKBOOK</a></dt>
                                                </dl>
                                                <dl>
                                                    <dt><a href="<?php echo $activities_banners[0]['link']; ?>"><img src="http://img.choies.com/uploads/1/files/<?php echo $activities_banners[0]['image']; ?>" /></a></dt>
                                                </dl>
                                            </li>
                                            <li style="width:318px">
                                                <dl>
                                                    <dt>SOCIAL & MEDIA</dt>
                                                    <dd class="sns fix">
                                                        <a rel="nofollow" href="http://www.facebook.com/choiescloth" target="_blank" class="sns1"></a>
                                                        <a rel="nofollow" href="http://twitter.com/#!/choiescloth" target="_blank" class="sns2"></a>
                                                        <a rel="nofollow" href="http://thatisstylish.tumblr.com" target="_blank" class="sns3"></a>
                                                        <a rel="nofollow" href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4"></a>
                                                        <a rel="nofollow" href="http://www.pinterest.com/choiesclothes/" target="_blank" class="sns5"></a>
                                                        <a rel="nofollow" href="http://www.chictopia.com/Choies" target="_blank" class="sns6"></a>
                                                        <a rel="nofollow" href="http://instagram.com/choiescloth" target="_blank" class="sns7"></a>
                                                        <a rel="nofollow" href="http://blog.choies.com" target="_blank" class="sns8"></a>
                                                        <a rel="nofollow" href="http://wanelo.com/store/choies" target="_blank" class="sns9"></a>
                                                    </dd>
                                                 </dl>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                        <div class="search">
                            <?php
                                $searchword="";
                                $searchword=DB::select('name')->from('search_hotword')->where('active', '=', 1)->where('type', '=', 1)->where('lang', '=', 'en')->where('site_id', '=', 1)->execute()->get('name');
                            ?>
                            <form action="/search" method="get" id="search_form" onsubmit="return search(this);">
                                <ul>
                                    <li class="fix">
                                        <input type="text" id="boss" name="searchwords" value="<?php echo $searchword; ?>" class="search_text text fll" onblur="if(this.value==''){this.value=this.defaultValue;}"  onfocus="if(this.value=='<?php echo $searchword; ?>'){this.value='';};" />
                                        <input type="submit" value="" class="search_btn fll" />
                                    </li>
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
            <div id="JS_floatnav" class="nav2 bottom hide">
                <div class="layout fix">
                    <nav class="nav fll">
                        <a href="/" class="home nav_home"></a>
                        <div id="nav2"></div>
                    </nav>
                    <div class="search">
                    </div>
                    <div class="nav2_right flr">
                        <?php if ($user_id): ?>
                            <a href="/customer/summary">MY ACCOUNT</a>
                        <?php else: ?>
                            <a href="/customer/summary">SIGN IN</a>
                        <?php endif; ?>
                        <div class="mybag JS_show">
                            <a href="/cart/view">MY BAG<span class="rum cart_count">0</span></a>
                            <div class="mybag_box JS_showcon hide">
                                <span class="topicon"></span>
                                <div class="mybag_con">
                                    <h4 class="tit">MY SHOPPING BAG</h4>
                                    <div class="cart_bag items mtb5"></div>
                                    <div class="cart-all-goods mr20">
                                        <p><span class="bold mr5 cart_count"></span>item<span class="cart_s"></span> in your bag</p>
                                         <p class="bold">Total: <span class="cart_amount"></span></p>
                                    </div>
                                    <div class="cart_bag_empty cart-empty-info" style="display:none;">Your shopping bag is empty!</div>
                                    <p class="cart_button">
                                        <a href="/cart/view" class="btn30_14_black">VIEW BAG</a>
                                        <a href="/cart/checkout" class="btn30_14_red ml20">PAY NOW</a>
                                    </p>
                                    <p class="cart_button_empty" style="display:none;"><a href="/cart/view" class="btn40_16_red">VIEW MY BAG</a></p>
                                    <!--<p class="ppexpress mt10"><a href="javascript:void(0)" style="background:none;margin-right: 40px;" onclick="location.href='/payment/ppec_set';" id="pp_express"><img src="/images/ppec.jpg" alt="Click here to pay via PayPal Express Checkout" style="vertical-align: middle;padding-left:20px;"></a></p>-->
                                </div>
                                <p class="free-shipping" style="display:none;">Add1+ Item Marked "Free Shipping" <br>Enjoy Free Shipping Entire Order</p>
                            </div>
                        </div>
                        <div class="mybag1" id="mybag2">
                            <div class="currentbag mybag_box hide">
                                <span class="topicon"></span>
                                <div class="mybag_con">
                                    <h4 class="tit">SUCCESS! ITEM ADDED TO BAG</h4>
                                    <div class="bag_items items mtb5">
                                        <li class="fix"></li>
                                        <p><a href="/cart/view" class="btn40_16_red">VIEW MY BAG</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="currency1 JS_show ">
                              <span class="lan">English</span>
                              <div class="currency_con JS_showcon hide " style="right:20px;display:none">
                                  <span class="topicon" style="right:50px"></span>
                                    <dl id="sites" >
                                    <dd><a href="<?php echo $request; ?>">English</a></dd>
                                    <dd><a href="/es<?php echo $request; ?>">Español</a></dd>
                                    <dd><a href="/de<?php echo $request; ?>">Deutsch</a></dd>
                                    <dd><a href="/fr<?php echo $request; ?>">Français</a></dd>
                                    <dd><a href="/ru<?php echo $request; ?>">Русский</a></dd>
                                  </dl>
                              </div>
                        </div>
                        <div class="currency1 JS_show">
                            <span class="currency"><a href="#" class="icon_flag icon_<?php echo strtolower($currency_now['name']); ?>"></a></a></span>
                            <div class="currency_con JS_showcon hide">
                                <span class="topicon"></span>
                                <form action="#" method="post">
                                    <dl class="sites">
                                        <?php
                                        $currencies = Site::instance()->currencies();
                                        foreach ($currencies as $currency)
                                        {
                                            if(strpos($currency['code'], '$') !== False)
                                                $code = '$';
                                            else
                                                $code = $currency['code'];
                                            ?>
                                            <dd onclick="location.href='<?php echo LANGPATH; ?>/currency/set/<?php echo $currency['name'] ?>'">
                                                <a href="<?php echo LANGPATH; ?>/currency/set/<?php echo $currency['name'] ?>" class="icon_flag icon_<?php echo strtolower($currency['name']); ?>"><?php echo $currency['fname']; ?></a>
                                            </dd>
                                            <?php
                                        }
                                        ?>
                                    </dl>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <span class="livechat"></span>
            <?php $domain = Site::instance()->get('domain'); ?>
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
