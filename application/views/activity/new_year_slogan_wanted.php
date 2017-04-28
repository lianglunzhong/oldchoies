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
        <link rel="image_src" href="<?php echo BASEURL ;?>/images/activity/slogan-02.jpg"/>
        <meta property="og:title" content="Choies 2015 Slogan Wanted!!!" />
        <meta property="og:url" content="<?php echo BASEURL ;?>/activity/new_year_slogan_wanted" />
        <meta property="og:description" content="Write a slogan for Choies to win $100 Gift Card.Once in a year, you should not miss this. Open your mind and do Choies a favor." />
        <meta property="og:image" content="<?php echo BASEURL ;?>/images/activity/slogan-02.jpg">
        <style>
            .lp_slogan img{ display:block; border:0 none;}
            .lp_slogan .view_btn{ width:90px; height:25px; text-align:center; line-height:25px; font-size:15px; border:0 none; border-radius:5px; margin:0 5px;}
            .lp_slogan h1{font-size:25px;color:#e54b1d;line-height:70px;border-bottom:1px solid #aaaaaa;margin-left:80px;width:610px;font-family:"Times New Roman", Times, serif;}
            .lp_slogan .btn1{ background-color:#54a776;}
            .lp_slogan .btn2{ background-color:#e4494e;}
            .lp_slogan .center p{ margin-bottom:5px;}
            .lp_slogan li .text {width: 255px;height: 26px;line-height: 26px;background-color: #fff;}
            .lp_vote_formcon{ width:530px; margin:20px auto;}
            .lp_vote_formcon li{ margin-bottom:10px;}
            .lp_vote_formcon li label{ display:inline-block; width:70px; margin-right:5px; float:left;font-weight:bold;}
            .lp_vote_formcon li .btn{ width:140px; height:30px; line-height:30px; background-color:#ec4449; font-size:18px; border-radius:5px; margin-top:10px;margin-left:74px;}
            .lp_vote_formcon li textarea{ width:440px; height:180px;background-color: #fff;}
            .lp-main{width:748px;border:1px solid #aaaaaa;margin:0 auto;}
            .slogan-02{padding:30px 0;margin-left:120px;}
            .lp_vote_share{ width:540px;margin:20px 0 30px 120px;border:1px dashed #ccc; padding:15px 0; text-align:center; font-size:14px; text-transform:uppercase;}
            .lp_vote_share a{ font-size:12px; display:inline-block; margin-left:15px; text-decoration:underline; background:url(/images/activity/icon1.png) no-repeat; padding:2px 0 1px 22px;}
            .lp_vote_share .a1{ background-position:0 0;}
            .lp_vote_share .a2{ background-position:0 -23px;}
            .lp_vote_share .a3{ background:url(/images/activity/icon2.jpg) no-repeat;}
            .lp_vote_share p{ color:#6a9c24; font-style:italic; text-transform:none; font-size:12px; margin:5px 0 0;}

            .lp_vote_bottom{ padding:20px 60px;width:748px;margin:0 auto;}
            .lp_vote_history{ width:100%;}
            .lp_vote_history li{ float:left; width:325px; background-color:#fff; padding:0 20px 25px 25px;text-transform:capitalize;}
            .lp_vote_history li .name{ display:inline-block; margin-right:5px; width:80px; color:#ff0008;}
            .lp_vote_history li .time1{color:#626262;}
            .lp_vote_history li .con1{ background-color:#f5f5f5;font-weight: bold;}
            .lp_vote_history li .con{margin-top:8px; height:22px; line-height:22px;color:#222222;font-weight: bold;}
            .gcom_page{ border-top: 1px solid #000; margin-top:20px;padding-top:20px;}
            .gcom_page .noborder{ border:none}
        </style>
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
        <?php
        if ($type != 'payment' && $type != 'purchase' && $type != 'cart')
        {
            ?>
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
            <?php
        }
        ?>

        <!-- main begin -->
        <img src="<?php echo BASEURL ;?>/images/activity/slogan-02.jpg" style="display:none;">
        <section id="main">
            <!-- crumbs -->
            <div class="layout">
                <div class="crumbs fix">
                    <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  New Year Slogan</div>
                </div>
                <?php
                $message = Message::get();
                echo $message; 
                ?>
            </div>
            <div class="lp_slogan layout fix">
                <p><img src="/images/activity/slogan-img.jpg" /></p> 
                <p><img src="/images/activity/slogan-01.jpg" /></p>
                <div id="step2"></div>
                <?php if (!empty($comments)): ?>
                <p style="margin:0 auto;width:748px;margin-top:40px;"><img src="/images/activity/slogan-03.jpg" /></p>
                <div class="lp_vote_bottom">
                    <ul class="lp_vote_history fix">
                    <?php
                    foreach ($comments as $comment)
                    {
                    ?>
                        <li>
                            <p class="con1"><b class="name"><?php echo $comment['firstname']; ?></b><span class="time1"><?php echo date('M d, Y', $comment['created']); ?></span></p>
                            <p class="con"><?php echo $comment['comments'] ?></p>
                        </li>
                    <?php
                    }
                    ?>
                    </ul>
                    <div class="fix gcom_page" style="background-color:#f5f5f5;padding:8px;">
                        <?php echo $pagination; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <script src="js/jquery-1.4.2.min.js"></script>
            <script src="js/plugin.js"></script>
            <script src="js/global.js"></script>
        </section>

        <!-- JS_popwincon1 -->
        <div class="JS_popwincon1 popwincon w_signup hide">
            <a class="JS_close2 close_btn2"></a>
            <div class="fix" id="sign_in_up">
                <div class="left" style="width:auto;margin-right:30px;padding-right:30px;">
                    <h3>CHOIES Member Sign In</h3>
                    <form action="/customer/login?redirect=/activity/new_year_slogan_wanted#step2" method="post" class="signin_form sign_form form">
                        <ul>
                            <li>
                                <label>Email address: </label>
                                <input type="text" value="" name="email" class="text" />
                            </li>
                            <li>
                                <label>Password: </label>
                                <input type="password" value="" name="password" class="text" maxlength="16" />
                            </li>
                            <li><input type="submit" value="Sign In" name="submit" class="btn btn40" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">Forgot password?</a></li>
                            <li>
                                <?php
                                $page = $plink;
                                $facebook = new facebook();
                                $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                                ?>
                                <a href="<?php echo $loginUrl; ?>" class="facebook_btn"></a>
                            </li>
                        </ul>
                    </form>
                </div>
                <div class="right">
                    <h3>CHOIES Member Sign Up</h3>
                    <form action="/customer/register?redirect=/activity/new_year_slogan_wanted#step2" method="post" class="signup_form sign_form form">
                        <ul>
                            <li>
                                <label>Email address: </label>
                                <input type="text" value="" name="email" class="text" />
                            </li>
                            <li>
                                <label>Password: </label>
                                <input type="password" value="" name="password" class="text" id="password" maxlength="16" />
                            </li>
                            <li>
                                <label>Confirm password: </label>
                                <input type="password" value="" name="password_confirm" class="text" maxlength="16" />
                            </li>
                            <li><input type="submit" value="Sign Up" name="submit" class="btn btn40" /></li>
                        </ul>
                    </form>
                </div>
            </div>
            <script type="text/javascript">
                // signin_form 
                $(".signin_form").validate({
                    rules: {
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true,
                            minlength: 5,
                            maxlength:20
                        }
                    },
                    messages: {
                        email:{
                            required:"Please provide an email.",
                            email:"Please enter a valid email address."
                        },
                        password: {
                            required: "Please provide a password.",
                            minlength: "Your password must be at least 5 characters long.",
                            maxlength: "The password exceeds maximum length of 20 characters."
                        }
                    }
                });

                // signup_form 
                $(".signup_form").validate({
                    rules: {
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true,
                            minlength: 5,
                            maxlength:20
                        },
                        password_confirm: {
                            required: true,
                            minlength: 5,
                            maxlength:20,
                            equalTo: "#password"
                        }
                    },
                    messages: {
                        email:{
                            required:"Please provide an email.",
                            email:"Please enter a valid email address."
                        },
                        password: {
                            required: "Please provide a password.",
                            minlength: "Your password must be at least 5 characters long.",
                            maxlength:"The password exceeds maximum length of 20 characters."
                        },
                        password_confirm: {
                            required: "Please provide a password.",
                            minlength: "Your password must be at least 5 characters long.",
                            maxlength:"The password exceeds maximum length of 20 characters.",
                            equalTo: "Please enter the same password as above."
                        }
                    }
                });
            </script>
        </div>

        <script>
            $("#giveawayForm").validate({
                rules: {
                    name:{required: true},
                    comments: {required: true,minlength: 5},
                }
            });
            $('.text,textarea').live('focusin', function(){
                $(this).addClass('inputfocus');
                if(this.value==this.defaultValue){
                    this.value='';
                }
            }).focusout(function(){
                $(this).removeClass('inputfocus');
                if(this.value==''){
                    this.value=this.defaultValue;
                }
            })
             $(function(){
                $('.gcom_page a').click(function(){
                    var link = $(this).attr('href');
                    if(typeof(link) != "undefined")
                    location.href = link + '#step5';
                    return false;
                })
            }) 

            function commentChange()
            {
                return window.setTimeout(function(){
                    var message = document.getElementById('comments1').value;
                    message = message.replace(/(^\s*)|(\s*$)/g, "");
                    document.getElementById('comments').value = message;
                }, 0);
            }
        </script>

        <?php
        if ($type != 'payment' && $type != 'purchase' && $type != 'cart')
        {
            ?>
            <!-- footer begin -->
            <footer>
                <div class="w_top">
                    <div class="top layout fix">
                        <dl>
                            <dt>MY ACCOUNT</dt>
                            <dd><a href="/track/track_order">Track Order</a></dd>
                            <dd><a href="/customer/orders">Order History</a></dd>
                            <dd><a href="/customer/profile">Account Setting</a></dd>
                            <dd><a href="/customer/points_history">Points History</a></dd>
                            <dd><a href="/customer/wishlist">Wish List</a></dd>
                            <dd><a href="/vip-policy">VIP Policy</a></dd>
                            <dd><a onclick="return feed_show();">Feedback</a></dd>
                        </dl>
                        <dl>
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
                        <dl>
                            <dt>FEATURED</dt>
                            <dd><a href="/lookbook">Lookbook</a></dd>
                            <dd><a href="/freetrial/add">Free Trial</a></dd>
                            <dd><a href="/activity/flash_sale">Flash Sale</a></dd>
                            <dd><a href="/wholesale">Wholesale</a></dd>
                            <dd><a href="/affiliate-program">Affiliate Program</a></dd>
                            <dd><a href="/blogger/programme">Blogger Wanted</a></dd>
                            <dd><a href="/rate-order-win-100" style="color:red;">Rate &amp; Win $100</a></dd>
                            <dd><a href="/sharewin/index">Share and Win</a></dd>
                        </dl>
                        <dl>
                            <dt>ALL SITES</dt>
                            <dd><a href="<?php echo $request; ?>">English Site</a></dd>
                            <dd><a href="/es<?php echo $request; ?>">Spanish Site</a></dd>
                            <dd><a href="/fr<?php echo $request; ?>">French Site</a></dd>
                            <dd><a href="/de<?php echo $request; ?>">German Site</a></dd>
                            <dd><a href="/ru<?php echo $request; ?>">Russian Site</a></dd>
                        </dl>
                        <dl class="last">
                            <dt>Find Us On</dt>
                            <dd class="sns fix">
                                <a rel="nofollow" href="http://www.facebook.com/choiescloth" target="_blank" class="sns1" title="facebook"></a>
                                <a rel="nofollow" href="http://twitter.com/#!/choiescloth" target="_blank" class="sns2" title="twitter"></a>
                                <a rel="nofollow" href="http://thatisstylish.tumblr.com" target="_blank" class="sns3" title="tumblr"></a>
                                <a rel="nofollow" href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4" title="youtube"></a>
                                <!--<a rel="nofollow" href="http://www.pinterest.com/choiesclothes/" target="_blank" class="sns5" title="pinterest"></a>-->
                                <a rel="nofollow" href="http://www.chictopia.com/Choies" target="_blank" class="sns6" title="chictopia"></a>
                                <a rel="nofollow" href="http://instagram.com/choiescloth" target="_blank" class="sns7" title="instagram"></a>
                                <!--<a rel="nofollow" href="http://wanelo.com/store/choies" target="_blank" class="sns9" title="wanelo"></a>-->
                            </dd>
                            <dd class="letter">
                                <form action="" method="post" id="letter_form">
                                    <label>SIGN UP FOR OUR EMAILS</label>
                                    <div class="fix">
                                        <input type="text" id="letter_text" class="text fll" value="Email Address" onblur="if(this.value==''){this.value=this.defaultValue;}"  onfocus="if(this.value=='Email Address'){this.value='';};" />
                                        <input type="submit" id="letter_btn" value="Submit" class="btn fll" />
                                    </div>
                                </form>
                            </dd>
                            <div class="red" id="letter_message" style="display: none;"></div>
                            <script language="JavaScript">
                                $(function(){
                                    $("#letter_form").submit(function(){
                                        var email = $('#letter_text').val();
                                        if(!email)
                                        {
                                            return false;
                                        }
                                        $.post(
                                        '/newsletter/ajax_add',
                                        {
                                            email: email
                                        },
                                        function(data)
                                        {
                                            $("#letter_message").html(data['message']);
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
                        </dl>
                    </div>
                    
                    <div class="card">
                        <p>
                            <img src="/images/card.jpg" usemap="#Card" />
                            <map name="Card" id="Card">
                                <area shape="rect" coords="88,2,193,62" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en" target="_blank" />
                            </map>
                        </p>
                    </div>
                </div>
                <div style="background-color:#232121;">
                    <p class="bottom">
                        Copyright © 2006-<?php echo date('Y'); ?> Choies.com&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a style="color: #ccc;" href="/privacy-security">Privacy &amp; Security</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a style="color: #ccc;" href="/about-us">About Choies</a>
                    </p>
                </div>
                <!--            <div class="w_bottom JS_hide">
                                <div class="bottom layout fix">
                                    <div class="left fll">
                                        <a href="#" class="a1"></a>
                                        <a href="#" class="a2"></a>
                                        <span class="f0llowus"></span>
                                    </div>
                                    <div class="right flr">
                                        <form action="/newsletter/single_add" method="post" class="fix" id="newsletter_form">
                                            <label class="left"></label>
                                            <div class="newsletter fix">
                                                <input type="text" name="email" value="Sign up with your email..." class="text fll" />
                                                <input type="submit" value="" class="btn fll" />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <span class="JS_close close_btn1"></span>
                            </div>-->
            </footer>
            <div id="gotop" class="hide" style="display:block;"><a href="#"></a></div>
            
            <script type="text/javascript">
                $(function(){
                    $("#w_bottom_close").live("click",function(){
                    $.ajax({
                                    type: "POST",
                                    url: "/site/hide_banner",
                                    dataType: "json",
                                    data: "",
                                    success: function(msg){
                                        $("#w_bottom_banner").css('display','none');
                                    }
                                });
                    });
                })
            </script>
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
            <script type="text/javascript">
                // newsletter_form
                $("#newsletter_form").validate({
                    rules: {
                        email: {
                            required: true,
                            email: true
                        }
                    },
                    messages: {
                        email:{
                            required:"",
                            email:""
                        }
                    }
                
                });
            </script>
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
                //                $.ajax({
                //                    type: "POST",
                //                    url: "/site/ajax_recent_view",
                //                    dataType: "json",
                //                    data: "",
                //                    success: function(msg){
                //                        $("#recent_view ul").html(msg);
                //                    }
                //                });
                
                //                $(".remind").delay(8000).fadeOut(500);
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
                                $("#sale_words").show();
                                $("#sale_words").text(msg['sale_words']);
                                $("#free_shipping").hide();
                            }
                            else if(msg['free_shipping'])
                            {
                                $("#free_shipping").show();
                                $("#sale_words").hide();
                            }
                            else
                            {
                                $("#free_shipping").hide();
                                $("#sale_words").hide();
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

<!--            <script language="javascript" src="http://count35.51yes.com/click.aspx?id=352285727&logo=1" charset="gb2312"></script>-->

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
                <script type="text/javascript" src="www.googleadservices.com/pagead/conversion.js">
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
                <script type="text/javascript" src="www.googleadservices.com/pagead/conversion.js">
                </script>
                <noscript>
                    <div style="display:inline;">
                        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/983779940/?value=0&amp;guid=ON&amp;script=0"/>
                    </div>
                </noscript>

                <?php
            }
            ?>
                
            <!-- FB Website Visitors Code -->
            <script>
                (function() {
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
            <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=454325211368099&amp;ev=NoScript" /></noscript>
            <!-- End FB Website Visitors Code -->
            <!-- HK ScarabQueue statistics Code -->
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