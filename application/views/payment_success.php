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
window._fbq.push(['track', '6027051164830', {'value':'0.00','currency':'USD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6027051164830&amp;cd[value]=0.00&amp;cd[currency]=USD&amp;noscript=1" /></noscript>
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
			function create() {
			    try {
			        var baseURL = "<?php echo $vizury; ?>";
			        var analyze = document.createElement("iframe");
			        analyze.src = baseURL;
			        analyze.scrolling = "no";
			        analyze.width = 1;
			        analyze.height = 1;
			        analyze.marginheight = 0;
			        analyze.marginwidth = 0;
			        analyze.frameborder = 0;
			        var node = document.getElementsByTagName("script")[0];
			        node.parentNode.insertBefore(analyze, node);
			    } catch (i) {
			    }
			}
			var existing = window.onload;
			window.onload = function() {
			    if (existing) {
			        existing();
			    }
			    create();
			}
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
        ?>
        <!-- header begin -->
        <?php
        if ($type != 'payment' && $type != 'purchase' && $type != 'cart')
        {
            ?>
            <header>
			
			<!-- <div class="wt_top JS_hide">
					<div class="topbanner layout fix">
						<a href="http://www.choies.com/top-sellers?hph0327" target="_blank"><img src="/images/indexbanner.png" /></a>
					</div>
					<span class="JS_close close "></span>
			 </div>-->
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
                                    <p class="free-shipping free_shipping" style="display:none;">Add1+ Item Marked "Free Shipping" <br>Enjoy Free Shipping Entire Order</p>
                                    <p class="free-shipping sale_words" style="display:none;"></p>
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
                                                        <dd><a href="/t-shirts" style="color:#ba2325;">T-shirts</a></dd>
                                                        <dd><a href="/coats-jackets">Coats & Jackets</a></dd>
                                                        <dd><a href="/shirt-blouse" style="color:#ba2325;">Shirts & Blouses</a></dd>
                                                        <dd><a href="/unreal-fur">Unreal Fur</a></dd>
                                                        <dd><a href="/two-piece-suit">Two-piece Suits</a></dd>
                                                        <dd><a href="/suits-blazers">Suits & Blazers</a></dd>
                                                        <dd><a href="/jumpers-cardigans">Jumpers & Cardigans</a></dd>
                                                        <dd><a href="/jumpsuits-playsuits">Jumpsuits & Playsuits</a></dd>
                                                        <dd><a href="/leather-biker-jackets">Leather & Biker Jackets</a></dd>
                                                        <dd><a href="/hoodies-sweatshirts">Hoodies & Sweatshirts</a></dd>
                                                        <dd><a href="/swimwear-beachwear" style="color:#ba2325;">Swimwear & Beachwear</a></dd>
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
                                                            array('Maxi Dresses', '/maxi-dresses'),
                                                            array('Black Dresses', '/black-dresses'),
                                                            array('White Dresses', '/white-dresses'),
                                                            array('Bodycon Dresses', '/bodycon-dresses'),
                                                            array('Off Shoulder Dresses', '/off-the-shoulder-dresses'),
                                                            array('Backless Dresses', '/backless-dress'),
                                                            array('Lace Dresses', '/lace-dresses'),
                                                            array('Homecoming Dresses', '/homecoming-dresses'),
                                                            array('Short Sleeve Dresses', '/short-sleeve-dresses'),
                                                            array('Long Sleeve Dresses', '/long-sleeve-dresses'),
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
                                                        <dt style="padding-bottom: 20px;"><!--<a href="/lookbook">-->NEWEST & HOTTEST <!--</a>--></dt>
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
                                                          <!--      <dt><a href="/sand-river-baby-cashmere" style="color:red;">SAND RIVER</a></dt>	-->
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
                                                        <?php
                                                        $accessory_banners = DB::select()->from('banners')->where('type', '=', 'accessory')->where('visibility', '=', 1)->where('lang', '=', '')->execute()->as_array();
                                                        if(isset($accessory_banners[0]))
                                                        {
                                                        ?>
                                                            <a href="<?php echo $accessory_banners[0]['link']; ?>"><img src="http://img.choies.com/uploads/1/files/<?php echo $accessory_banners[0]['image']; ?>" alt="<?php echo $accessory_banners[0]['alt']; ?>" title="<?php echo $accessory_banners[0]['title']; ?>" /></a>
                                                        <?php
                                                        }
                                                        ?>
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
                                                        <dt><a href="/salute-the-spring">SPRING SALE</a></dt>
                                                        <br>
                                                        <dt><a href="/activity/flash_sale">FLASH SALE</a></dt>
                                                        <br>
                                                        <dt>BY PRICE</dt>
                                                        <dd><a href="/usd2" style="color:#ba2325;">USD1.9</a></dd>
                                                        <dd><a href="/2014-summer-sale?0814" style="color:#ba2325;">USD9.9</a></dd>
                                                        <dd><a href="/usd-13">USD13.9</a></dd>
                                                        <dd><a href="/usd-16">USD16.9</a></dd>
                                                        <dd><a href="/usd20">USD19.9</a></dd>
                                                        <dd><a href="/usd30">USD29.9</a></dd>
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
                                        <div class="nav_list JS_showcon  hide" style="width: 580px; left: -300px;">
                                            <span class="topicon" style="left: 330px;"></span>
                                            <ul class="fix new_list">
                                                <li style="padding-bottom: 0px;">
                                                    <!--<dl>
                                                        <dt><a href="/activity/catalog/presale-from-choies">ORIGINAL DESIGNS</a></dt>
                                                    </dl>-->
                                                    <dl>
                                                        <dt>FEATURES</dt>
                                                        <dd><a href="/freetrial/add">Free Trial Center</a></dd>
                                                        <dd><a href="/rate-order-win-100">Rate to Win $100</a></dd>
														<dd><a href="/activity/flash_sale">FLASH SALE</a></dd>
														<dd><a href="/ready-to-be-shipped">SHIP IN 24 HRS</a></dd>
                                                    </dl>
                                                </li>
                                                <li style="padding-bottom: 0px;">
                                                    <dl>
                                                        <dt>TRENDS</dt>
                                                        <dd><a href="/activity/skirt_looks">Skirt Looks</a></dd>
                                                        <dd><a href="/tropical-palm-tree-print">Palm Tree Print</a></dd>
                                                        <!--<dd><a href="/k-pop?0904">K POP Styles</a></dd>-->
                                                        <dd><a href="/off-shoulder">Off Shoulder</a></dd>
                                                        <dd><a href="/activity/stripes_collection">Magical Stripes</a></dd>
                                                        <dd><a href="/crochet-lace">Crochet Lace</a></dd>
                                                        <!--<dd><a href="/lace-panel">Lace Panel</a></dd>-->
                                                        <dd><a href="/activity/only_florals">Only Florals</a></dd>
														<dd><a href="/kimonos?sort=0&limit=1">Kimono Style</a></dd>
                                                    </dl>
                                                </li>
                                               <!-- <li style="padding-bottom: 0px;">
                                                    <dl>
                                                        <dt><a href="/activity/flash_sale?1112" style="background-color:#000; color:#fff;padding:0px 5px">FLASH SALE</a></dt>
                                                    </dl>
                                                    <dl>
                                                        <dt>HOT PIECES</dt>
                                                        <dd><a href="/kimonos?sort=0&limit=1">Kimono Style</a></dd>
                                                    </dl>
                                                </li>	-->
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
                                                            <a rel="nofollow" href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a>
                                                            <a rel="nofollow" href="http://www.chictopia.com/Choies" target="_blank" class="sns6"></a>
                                                            <a rel="nofollow" href="http://instagram.com/choiescloth" target="_blank" class="sns7"></a>
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
                                    <p class="free-shipping free_shipping" style="display:none;">Add1+ Item Marked "Free Shipping" <br>Enjoy Free Shipping Entire Order</p>
                                    <p class="free-shipping sale_words" style="display:none;"></p>
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

<script src="//cdn.optimizely.com/js/557241246.js"></script>
<section id="main">
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="mlr30">
                <h1>Thank You!</h1>
                <ul class="paysuccess_t">
                    <li>Your have completed your payment successfully.</li>
                    <li>Click Your Order Number: <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><?php echo $order['ordernum']; ?></a> to view more details.</li>
                    <li>You will also receive a summary of your order information via email.</li> 
                    <li>If you have any questions about your order,</li> 
                    <li>please <a href="<?php echo LANGPATH; ?>/contact-us">contact us</a>.</li>
                    <li><a href="<?php echo LANGPATH; ?>/" class="view_btn btn26 btn40">Continue Shopping</a></li>
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
                <dl class="paysuccess_b">
                    <dt>You may take a look at our current promotion:</dt>
                    <div class="fix">
                        <a href="<?php echo LANGPATH; ?>/freetrial/add" class="fll"><img src="/images/banner404_1.jpg" /></a>
                        <a href="<?php echo LANGPATH; ?>/activity/flash_sale" class="flr"><img src="/images/banner404_2.jpg" /></a>
                    </div>
                    <dt>Or share your ordered items with your friends through social networking sites:</dt>
                    <dd>
                        <p class="font14">Please choose the item you'd like to share:</p>
                        <div class="pay_product_carousel">
                            <div class="JS_carousel product_carousel">
                                <ul class="fix">
                                <?php
                                $domain = 'www.choies.com';
                                $products = Order::instance($order['id'])->products();
                                foreach($products as $p):
                                ?>
                                    <li>
                                        <a href="<?php echo $p['link']; ?>"><img src="<?php echo image::link(Product::instance($p['product_id'])->cover_image(), 3); ?>" /></a>
                                        <div class="share mt5">
                                            <a target="_blank" href="http://twitter.com/share?url=http%3A%2F%2F<?php echo $domain; ?>%2Fproduct%2F<?php echo $p['link']; ?>" class="a1"></a>
                                            <a target="_blank" href="http://www.facebook.com/sharer.php?u=http%3A%2F%2F<?php echo $domain; ?>%2Fproduct%2F<?php echo $p['link']; ?>" class="a2"></a>
                                        </div>
                                    </li>
                                <?php
                                endforeach;
                                ?>
                                </ul>
                            </div>
                            <span class="prev1 JS_prev"></span>
                            <span class="next1 JS_next"></span>
                        </div>
<!--                        <div class="fix">
                            <div class="flr">
                                <div class="sns"><a href="#" class="sns1"></a><a href="#" class="sns2"></a><a href="#" class="sns3"></a></div>
                            </div>
                        </div>-->
                    </dd>
                </dl>
            </div>
        </article>
        <?php echo View::factory('/customer/left'); ?>
    </section>
</section>
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
<script type="text/javascript" src="www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
    <img height="1" width="1" style="border-style:none;" alt="" src="www.googleadservices.com/pagead/conversion/983779940/?value=<?php echo $g_amount; ?>&amp;label=o62wCIT3kQgQ5JSN1QM&amp;guid=ON&amp;script=0"/>
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
<script type="text/javascript" src="www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
    <img height="1" width="1" style="border-style:none;" alt="" src="www.googleadservices.com/pagead/conversion/969564565/?value=<?php echo $g_amount; ?>&amp;label=dzCzCPuoiQgQlcOpzgM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<?php
//new GA ecommerce code
// Transaction Data
$trans = array('id'=>$order['ordernum'], 'affiliation'=>'Acme Clothing',
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


<img src="https://hotdeals.dmdelivery.com/x/conversion/?order_choies=<?php echo $order['ordermun']; ?>" alt="" width="1" height="1" />
<img src="https://hotdeals.dmdelivery.com/x/conversion/?price_choies=<?php echo $order['amount']; ?>" alt="" width="1" height="1" />

<!-- begin adBrite, Purchases/sales tracking --><img border="0" hspace="0" vspace="0" width="1" height="1" src="https://stats.adbrite.com/stats/stats.gif?_uid=1228654&_pid=0" /><!-- end adBrite, Purchases/sales tracking -->
<img src="https://gan.doubleclick.net/gan_conversion?advid=K603690&oid=<?php echo $order['ordernum']; ?>&amt=<?php echo $order['amount']; ?>&fxsrc=USD" width=1 height=1>

<script type="text/javascript">
    var _roi = _roi || [];
    _roi.push(['_setMerchantId', '514168']);
    _roi.push(['_setOrderId', '<?php echo $order['ordernum']; ?>']);
    _roi.push(['_setOrderAmount', '<?php echo $order['amount']; ?>']);
    _roi.push(['_setOrderNotes', '']);
    _roi.push(['_addItem','<?php echo Product::instance($product1['id'])->get('sku'); ?>','<?php echo Product::instance($product1['id'])->get('sku'); ?>','','','<?php echo round($product1['price'], 2); ?>','<?php echo $product1['quantity']; ?>']);
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

<?php
if (strtolower($_COOKIE["ChoiesCookie"]) == "cj")
{ 
    ?>
    <!--begin cj platform code -->
    <iframe height="1" width="1" frameborder="0" scrolling="no" src="https://www.emjcd.com/tags/c?containerTagId=4452&<?php echo $cj_sku; ?>&<?php echo $cj_amt; ?>&<?php echo $cj_qty; ?>&CID=1527669&OID=<?php echo $order['ordernum']; ?>&TYPE=361456&CURRENCY=<?php echo $order['currency']; ?>&Discount=<?php echo $discount; ?>" name="cj_conversion" ></iframe>
    <?php
}
elseif(strtolower($_COOKIE["ChoiesCookie"]) == "a8")
{
    ?>
    <!-- A8.NET Code -->
    <img src="https://px.a8.net/cgi-bin/a8fly/sales?pid=s00000014305001&so=<?php echo $order['ordernum']; ?>&si=<?php echo round(($order['amount_products'] + $order['amount_shipping']) / $order['rate'], 2) * 100; ?>.<?php echo $a8qty; ?>.<?php echo round($order['amount'] / $order['rate'], 2) * 100; ?>.Clothing" width="1" height="1">
    <?php
}
?>

<!-- Polyvore Conversion Code -->
<img width="1" height="1" src="https://www.polyvore.com/conversion/beacon.gif?adv=choies.com&amt=<?php echo round($order['amount'], 2); ?>&oid=<?php echo $order['ordernum']; ?>&skus=<?php echo implode(',', $pol_skus); ?>&cur=<?php echo strtolower($order['currency']); ?>">
<?php
if(strtolower($_COOKIE["xc_source"]) == "xingcloud")
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

<!--begin shareasale platform code-->
<img src="https://shareasale.com/sale.cfm?amount=<?php echo $order['amount']; ?>&tracking=<?php echo $order['ordernum']; ?>&transtype=sale&merchantID=41271&currency=<?php echo $order['currency']; ?>" width="1" height="1">


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
<script type="text/javascript" src="www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="www.googleadservices.com/pagead/conversion/974164400/?value=<?php echo $g_amount; ?>&amp;label=BIjICLCEuAgQsKPC0AM&amp;guid=ON&amp;script=0"/>
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
<script type="text/javascript" src="www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="www.googleadservices.com/pagead/conversion/972170544/?value=<?php echo $g_amount; ?>&amp;label=kcKNCMDK2goQsMrIzwM&amp;guid=ON&amp;script=0"/>
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
<script type="text/javascript" src="www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="www.googleadservices.com/pagead/conversion/970256491/?value=<?php echo $g_amount; ?>&amp;label=etPuCN3n4wgQ6-DTzgM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- Bing Conversion Track Code -->
<script type="text/javascript"> if (!window.mstag) mstag = {loadTag : function(){},time : (new Date()).getTime()};</script> <script id="mstag_tops" type="text/javascript" src="//flex.msn.com/mstag/site/328da873-bd52-4a88-acfc-33b0b6eb8904/mstag.js"></script> <script type="text/javascript"> mstag.loadTag("analytics", {dedup:"1",domainId:"3099717",type:"1",actionid:"255169"})</script> <noscript> <iframe src="//flex.msn.com/mstag/tag/328da873-bd52-4a88-acfc-33b0b6eb8904/analytics.html?dedup=1&domainId=3099717&type=1&actionid=255169" frameborder="0" scrolling="no" width="1" height="1" style="visibility:hidden;display:none"> </iframe> </noscript>


<!-- AB Test Code -->
<script>
    window.optimizely = window.optimizely || [];
    window.optimizely.push(['trackEvent', 'purchase_complete', {'revenue': <?php echo round($order['amount'] / $order['rate'], 2) * 100; ?>}]);
</script>

<!-- HK ScarabQueue statistics Code -->
<?php 
    $amount=round($order["amount"]/$order["rate"],4);
    $qty=count($products);
    ($qty == 0) ? 0 : $amount2=round(($amount/$qty)*100)/100;
?>
<script type="text/javascript">
ScarabQueue.push(['setOrderId', '<?php echo $order["ordernum"]; ?>']);
<?php
foreach ($products as $product):
$sku = Product::instance($product['product_id'])->get('sku');
echo "ScarabQueue.push(['checkOut', '".$sku."', ".$product['quantity'].", ".$amount2."]);";
endforeach;
?>
</script>
<!-- HK ScarabQueue statistics Code -->

<!-- Cityads Code -->
<?php
$sqsku=$sqqty=$xcstr=array();
foreach ($products as $product):
    $p_sku=Product::instance($product['product_id'])->get('sku');
    $p_name=Product::instance($product['product_id'])->get('name');
    $sqsku[]=$p_sku;
    $sqqty[]=$product['quantity'];
    $xcstr[]='{"pid":"'.$p_sku.'","pn":"'.$p_name.'","up":"'.$product['quantity'].'","pc":"","qty":"'.$product['quantity'].'"}';
endforeach;
    $xcsku=$xcqty=$xcmart="";
    $xcsku=implode(",", $sqsku);
    $xcqty=implode(",", $sqqty);
    $xcmart=implode(",", $xcstr);
    $click_id=Arr::get($_COOKIE, 'click_id', 0);
    $amount=round($order["amount"]/$order["rate"],4);
    $amount=round($amount*100)/100;
    ?>
<script id="xcntmyAsync" type="text/javascript"> 
// order confirmation page 
var xcnt_order_products = '<?php echo $xcsku; ?>';
var xcnt_order_quantity = '<?php echo $xcqty; ?>';
var xcnt_order_id = '<?php echo md5($order["ordernum"]); ?>';
var xcnt_order_total = '<?php echo $amount; ?>';
var xcnt_order_currency = 'USD';
var xcnt_user_email = '<?php echo $order["email"]; ?>';
var xcnt_user_email_hash = '<?php echo md5($order["email"]); ?>';
var xcnt_user_id = '<?php echo $order["customer_id"]; ?>';
(function(d){ 
var xscr = d.createElement( 'script' ); xscr.async = 1; 
xscr.src = '//x.cnt.my/async/track/?r=' + Math.random(); 
var x = d.getElementById( 'xcntmyAsync' ); 
x.parentNode.insertBefore( xscr, x ); 
})(document); 
</script>
<script type="text/javascript" async="async" src='https://cityadspix.com/track/<?php echo $order["ordernum"]; ?>/ct/q1/c/9795?click_id=<?php echo $click_id; ?>&customer_type=N&payment_method=cash&order_total=<?php echo $amount; ?>&currency=USD&basket=[<?php echo $xcmart; ?>]&md=2'></script>
<noscript ><img src='https://cityadspix.com/track/<?php echo $order["ordernum"]; ?>/ct/q1/c/9795?click_id=<?php echo $click_id; ?>&customer_type=N&payment_method=cash&order_total=<?php echo $amount; ?>&currency=USD&basket=[<?php echo $xcmart; ?>]' width="1" height="1"></noscript>
<!-- Cityads Code -->
<?php 
    $currency = Site::instance()->currencies($order['currency']);
?>
<!-- webpower Foreign Statistical code by zhang.jinling-->
<img src="http://choies-mail.dmdelivery.com/x/conversion/?buy=<?php echo $order["ordernum"]."_".$currency['code'] . round($order["amount"],2); ?>" alt="" width="1" height="1" />
<img src="http://choies-mail.dmdelivery.com/x/conversion/?price=<?php echo $currency['code'] . round($order["amount"],2); ?>" alt="" width="1" height="1" />
<!-- webpower Foreign Statistical code by zhang.jinling-->
<img src="http://choies-service.dmdelivery.com/x/conversion/?order=<?php echo $order["ordernum"]; ?>" alt="" width="1" height="1" />
<img src="http://choies-service.dmdelivery.com/x/conversion/?price=<?php echo $currency['code'] . round($order["amount"],2); ?>" alt="" width="1" height="1" />
<!-- kenshoo code by zuolong -->
<script type=text/javascript>
   var hostProtocol = (("https:" == document.location.protocol) ? "https" : "http");
   document.write('<scr'+'ipt src="', hostProtocol+
   '://5064.xg4ken.com/media/getpx.php?cid=1d62c007-5c29-4b86-bc5b-9d924c279db8','" type="text/JavaScript"><\/scr'+'ipt>');
</script>
<script type=text/javascript>
   var params = new Array();
   params[0]='id=1d62c007-5c29-4b86-bc5b-9d924c279db8';
   params[1]='type=conv';
   params[2]='val=<?php echo number_format(round($order["amount"], 2),2); ?>';
   params[3]='orderId=<?php echo $order["ordernum"]; ?>';
   params[4]='promoCode=';
   params[5]='valueCurrency=<?php echo $order["currency"]; ?>';
   params[6]='GCID='; //For Live Tracking only
   params[7]='kw='; //For Live Tracking only
   params[8]='product='; //For Live Tracking only
   k_trackevent(params,'5064');
</script>

<noscript>
   <img src="https://5064.xg4ken.com/media/redir.php?track=1&token=1d62c007-5c29-4b86-bc5b-9d924c279db8&type=conv&val=<?php echo number_format(round($order["amount"], 2),2); ?>&orderId=<?php echo $order["ordernum"]; ?>&promoCode=&valueCurrency=<?php echo $order["currency"]; ?>&GCID=&kw=&product=" width="1" height="1">
</noscript>
<!-- kenshoo code by zuolong -->

<!-- <webgains tracking code> -->
<?php if (strtolower($_COOKIE["ChoiesCookie"]) == "webgains"){ ?>
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
<!-- </webgains tracking code> -->

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
                                <a rel="nofollow" href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a>
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
            <img src="track.excelmob.com?purchase=EXCELMOB-150003&segment=zIVosBUe86&sku=PRODUCT-SKU-HERE&orderref=ORDER-REF-HERE&ordervalue=ORDER-VALUE-HERE" />
            <img src="track.excelmob.com?add=NHRmmv7KbM"/>
            <img height="1" width="1" alt="" src="https://ct.pinterest.com/?tid=WIGOXXSyALa"/>
            <img height="1" width="1" alt="" src="https://ct.pinterest.com/?tid=Gt0JgSDWKiV"/>
        </div>
        
    </body>
</html>
