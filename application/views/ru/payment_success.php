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
        <link type="text/css" rel="stylesheet" href="/css/<?php echo LANGUAGE; ?>.css" media="all" id="mystyle" />
        <script src="/js/jquery-1.4.2.min.js"></script>
        <script src="/js/global.js"></script>
        <script src="/js/plugin.js"></script>
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
        <!-- Facebook Conversion Code for Check out success-->
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
		
		<!-- Stats code of HelloSociety  -->
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
            $cid = Customer::instance($user_id)->is_celebrity();
            if ($cid AND !isset($_GET['cid']))
            {
                $c_admin = DB::select('admin')->from('celebrities_celebrits')->where('id', '=', $cid)->execute()->get('admin');
                $admin_email = DB::select('email')->from('auth_user')->where('id', '=', $c_admin)->execute()->get('email');
                $admin_name = substr($admin_email, 0, strpos($admin_email, '@'))
                ?>
                <script type="text/javascript">
                    var stateObject = {};
                    var title = "";
                    var newUrl = "<?php echo URL::site(Request::current()->uri) . URL::query(array('cid' => $cid . $admin_name)); ?>";
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
						<a href="http://www.choies.com/ru/top-sellers?hph0327" target="_blank"><img src="/../images/rubanner.png" /></a>
					</div>
					<span class="JS_close close "></span>
			 </div>	-->
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
                                                    <a href="<?php echo LANGPATH; ?>/currency/set/<?php echo $currency['name'] ?>" class="icon_flag icon_<?php echo strtolower($currency['name']); ?>"><?php echo $code . $currency['name']; ?></a>
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
                            
                            $request = substr($request, strlen(LANGPATH));
                            if(!$request)
                                $request = '/';
                            elseif(strpos($request, '?') === 0)
                                $request = '/' . $request;
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
                            <a href="<?php echo LANGPATH; ?>/faqs">ПОМОЩИ</a>
                            <?php
                            if ($user_id)
                            {
                                $firstname = Customer::instance($user_id)->get('firstname');
                                if(!$firstname)
                                    $firstname = 'choieser';
                                if(strlen($firstname) > 12)
                                    $fname = substr($firstname, 0, 11) . '...';
                                else
                                    $fname = $firstname;
                                ?>
                                Здравствуйте, <span title="<?php echo $firstname; ?>"><?php echo $fname; ?></span> !
                                <div class="JS_show" style="display:inline-block">
                                    <a href="/customer/summary" rel="nofollow" class="myaccount ">Личный кабинет</a>
                                    <div class="myaccount-hide JS_showcon hide" style="display: none;">
                                       <ul>
                                       <li><a href="/customer/orders" rel="nofollow">Мои Заказы</a></li>
                                       <li><a href="/track/track_order" rel="nofollow">Отслеживать заказ</a></li>
                                       <li><a href="/customer/points_history" rel="nofollow">Мои баллы</a></li>
                                       <li><a href="/customer/profile" rel="nofollow">Мой Профиль</a></li>
                                       <li><a href="/customer/logout" rel="nofollow">Выход</a></li>
                                       </ul>
                                   </div>
                                </div>
                            <?php
                            }
                            else
                            {
                            ?>
                                <a href="/customer/login">Войти</a>
                                <div class="JS_show" style="display:inline-block">
                                    <a href="/customer/summary" rel="nofollow" class="myaccount ">Личный кабинет</a>
                                    <div class="myaccount-hide JS_showcon hide" style="display: none;">
                                       <ul>
                                       <li><a href="/customer/orders" rel="nofollow">Мои Заказы</a></li>
                                       <li><a href="/track/track_order" rel="nofollow">Отслеживать заказ</a></li>
                                       <li><a href="/customer/points_history" rel="nofollow">Мои баллы</a></li>
                                       <li><a href="/customer/profile" rel="nofollow">Мой Профиль</a></li>
                                       </ul>
                                   </div>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="mybag JS_show">
                                <a href="<?php echo LANGPATH; ?>/cart/view">Корзина<span class="rum cart_count">0</span></a>
                                <div class="mybag_box JS_showcon hide">
                                    <span class="topicon"></span>
                                    <div class="mybag_con">
                                        <h4 class="tit">КОРЗИНА ТОВАРЫ</h4>
                                        <div class="cart_bag items mtb5"></div>
                                        <div class="cart-all-goods mr20">
                                            <p><span class="bold mr5 cart_count"></span>товар в вашей корзине</p>
                                             <p class="bold">Итого: <span class="cart_amount"></span></p>
                                        </div>
                                        <div class="cart_bag_empty cart-empty-info" style="display:none;">Ваша корзина сейчас пуста.</div>
                                        <p class="cart_button">
                                            <a href="<?php echo LANGPATH; ?>/cart/view" class="btn30_14_black">в корзину</a>
                                            <a href="<?php echo LANGPATH; ?>/cart/checkout" class="btn30_14_red ml20">оформить</a>
                                        </p>
                                        <p class="cart_button_empty" style="display:none;"><a href="<?php echo LANGPATH; ?>/cart/view" class="btn40_16_red">Посмотреть корзину</a></p>
                                        <!--<p class="ppexpress mt10"><a href="javascript:void(0)" style="background:none;" onclick="location.href='/payment/ppec_set';" id="pp_express"><img src="/images/ppec.jpg" alt="Klicken Sie hier, um per PayPal Express zu bezahlen." style="vertical-align: middle;"></a></p>-->
                                    </div>
                                    <p class="free-shipping free_shipping" style="display:none;">Добавьте 1+ товар С Пометкой "Бесплатная Доставка" <br>Добавьте 1+ товар С Пометкой "Бесплатная Доставка".</p>
                                    <p class="free-shipping sale_words" style="display:none;"></p>
                                </div>
                            </div>
                            <div class="mybag1" id="mybag1">
                                <div class="currentbag mybag_box hide">
                                    <span class="topicon"></span>
                                    <div class="mybag_con">
                                        <h4 class="tit">Молодец! Товар добавлен в корзину. </h4>
                                        <div class="bag_items items mtb5">
                                            <li class="fix"></li>
                                            <p><a href="<?php echo LANGPATH; ?>/cart/view" class="btn40_16_red" style="font-size: 12px;">Посмотреть корзину</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bottom" id="nav_list">
                    <div class="layout">
                        <a href="<?php echo LANGPATH; ?>/" class="logo" title=""></a>
                        <nav id="nav1" class="nav">
                            <ul class="fix">
                                <li class="JS_show">
                                    <a href="<?php echo LANGPATH; ?>/daily-new">Новинки</a>
                                    <div class="nav_list JS_showcon hide" style="width: 130px; margin-left: 225px;">
                                        <span class="topicon" style="left: 70px;"></span>
                                        <ul class="fix">
                                            <li style="padding-bottom: 0;width: 100px;text-align: center;">
                                                <dl>
                                                    <?php
                                                    $today = strtotime('midnight');
                                                    $i = 0;
                                                    while ($i < 10):
                                                        $from = $today - $i * 86400 + 86400;
                                                        $i++;
                                                        ?>
                                                        <dt><a href="<?php echo LANGPATH; ?>/daily-new/<?php echo $i - 1 ? $i - 1 : ''; ?>"><?php echo date('Y-m-d', $from - 1); ?></a></dt>
                                                        <?php
                                                    endwhile;
                                                    ?>
                                                </dl>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="JS_show">
                                    <a href="<?php echo LANGPATH; ?>/apparels">Одежда</a>
                                    <div class="nav_list JS_showcon apparel hide">
                                        <span class="topicon"></span>
                                        <ul class="fix">
                                            <li>
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/tops">Топ</a></dt>
                                                    <dd><a href="<?php echo LANGPATH; ?>/t-shirts" style="color:#ba2325;">Футболки</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/coats-jackets">Верхняя одежда</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/shirt-blouse" style="color:#ba2325;">Рубашки и блузки</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/unreal-fur">нереальный мех</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/two-piece-suit">2 в 1</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/suits-blazers">Жакет</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/jumpers-cardigans">Джемпер и кардиган</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/jumpsuits-playsuits">Комбинезоны</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/leather-biker-jackets">Байкеры-Куртка</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/hoodies-sweatshirts">Худи и свитшоты</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/swimwear-beachwear" style="color:#ba2325;">Купальники и пляжная одежда</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/crop-tops-bralets">Кроп-топы и bralets</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/vests-tanks">Безрукавка и топы</a></dd>
                                                </dl>
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/bottoms">Боттомс</a></dt>
                                                    <?php
                                                    $hots = array(
                                                        'skirt'
                                                    );
                                                    $catalog1 = DB::select('id')->from('catalogs_'.LANGUAGE)->where('link', '=', 'bottoms')->execute()->get('id');
                                                    $catalogs = Catalog::instance($catalog1)->children();
                                                    foreach ($catalogs as $catalog):
                                                        $link = Catalog::instance($catalog)->get('link');
                                                        ?>
                                                        <dd><a href="<?php echo LANGPATH; ?>/<?php echo $link; ?>" <?php if(in_array($link, $hots)) echo 'style="color:#ba2325;"'; ?>><?php echo ucfirst(Catalog::instance($catalog, LANGUAGE)->get('name')); ?></a></dd>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </dl>
                                            </li>
                                            <li>
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/dresses">Платья</a></dt>
                                                    <?php
                                                    $links = array(
                                                        array('Чёрные платья', LANGPATH . '/black-dresses'),
                                                        array('Кружевные платья', LANGPATH . '/lace-dresses'),
                                                        array('Облегающие платья', LANGPATH . '/bodycon-dresses'),
                                                        array('Белые платья', LANGPATH . '/white-dresses'),
                                                        array('Длинные платья', LANGPATH . '/maxi-dresses'),
                                                        array('Homecoming Платья', LANGPATH . '/homecoming-dresses'),
                                                        array('Платья с длинными рукавами', LANGPATH . '/long-sleeve-dresses'),
                                                        array('Платья С Открытым Плечом', LANGPATH . '/off-the-shoulder-dresses'),
                                                        array('Платья С Открытой Спиной', LANGPATH . '/backless-dress'),
                                                        array('Платья с короткими рукавами', LANGPATH . '/short-sleeve-dresses'),
                                                    );
                                                    $hot_dresses=array("Кружевные платья","Длинные платья","Платья С Открытым Плечом");
                                                    foreach ($links as $link):
                                                        ?>
                                                        <dd><a href="<?php echo $link[1]; ?>" <?php if(in_array($link[0],$hot_dresses)){ echo 'style="color:#ba2325;"'; }?>><?php echo $link[0]; ?></a></dd>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </dl>
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/men-s-collection">Мужская одежда</a></dt>
                                                    <?php
                                                    $catalog1 = DB::select('id')->from('catalogs_'.LANGUAGE)->where('link', '=', 'men-s-collection')->execute()->get('id');
                                                    $catalogs = Catalog::instance($catalog1)->children();
                                                    foreach ($catalogs as $catalog):
                                                        ?>
                                                        <dd><a href="<?php echo LANGPATH; ?>/<?php echo Catalog::instance($catalog)->get('link'); ?>"><?php echo ucfirst(Catalog::instance($catalog, LANGUAGE)->get('name')); ?></a></dd>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </dl>
                                            </li>
                                            <li>
                                                <!--<dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/apparels/new">Новинки</a></dt>
                                                    <dd><a href="#"></a></dd>
                                                </dl>-->
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/top-sellers">Ходовые товары</a></dt>
                                                    <dd><a href="#"></a></dd>
                                                </dl>
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/outlet">Распродажа</a></dt>
                                                    <dd><a href="#"></a></dd>
                                                    <dd><a href="#"></a></dd>
                                                </dl>
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/activity/flash_sale?1112">FLASH SALE</a></dt>
                                                    <dd><a href="#"></a></dd>
                                                </dl>
                                                <dl>
                                                    <?php
                                                    $apparel_banners = DB::select()->from('banners')->where('type', '=', 'apparel')->where('visibility', '=', 1)->where('lang', '=', LANGUAGE)->execute()->as_array();
                                                    ?>
                                                    <a href="<?php echo $apparel_banners[0]['link']; ?>"><img src="http://www.choies.com/cimages/<?php echo $apparel_banners[0]['image']; ?>" /></a>
                                                </dl>
                                            </li>
                                            <li class="last">
                                                <dl>
                                                    <dt>НОВЫЕ И ГОРЯЧИЕ</dt>
                                                    <dl>
                                                        <?php
                                                        $lookbook_banner = DB::select()->from('banners')->where('type', '=', 'apparel')->where('visibility', '=', 1)->where('lang', '=', '')->execute()->as_array();
                                                        ?>
                                                        <a href="<?php echo LANGPATH . $lookbook_banner[1]['link']; ?>"><img src="http://img.choies.com/uploads/1/files/<?php echo $lookbook_banner[1]['image']; ?>" width="190px" /></a>
                                                    </dl>
                                                </dl>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="JS_show">
                                    <a href="<?php echo LANGPATH; ?>/shoes">Обувь</a>
                                    <div class="nav_list JS_showcon hide" style="width: 174px; margin-left: 205px;">
                                        <span class="topicon" style="left: 90px;"></span>
                                        <ul class="fix">
                                            <li style="padding-bottom: 0;">
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/shoes/new">Новинки</a></dt>
                                                    <?php
                                                    $catalog1 = DB::select('id')->from('catalogs_'.LANGUAGE)->where('link', '=', 'shoes')->execute()->get('id');
                                                    $catalogs = Catalog::instance($catalog1)->children();
                                                    foreach ($catalogs as $catalog):
                                                        ?>
                                                        <dt><a href="<?php echo LANGPATH; ?>/<?php echo Catalog::instance($catalog)->get('link'); ?>"><?php echo ucfirst(Catalog::instance($catalog, LANGUAGE)->get('name')); ?></a></dt>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </dl>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="JS_show">
                                    <a href="<?php echo LANGPATH; ?>/accessory">Аксессуары</a>
                                    <?php
                                    $catalog1 = DB::select('id')->from('catalogs_'.LANGUAGE)->where('link', '=', 'accessory')->execute()->get('id');
                                    $catalogs = Catalog::instance($catalog1)->children();
                                    $count = count($catalogs);
                                    ?>
                                    <div class="nav_list JS_showcon hide" style="<?php if ($count > 11) echo 'width: 400px; margin-left: 140px;'; else echo 'width: 174px; margin-left: 230px;' ?>">
                                        <span class="topicon" style="left: <?php if ($count > 11) echo 185; else echo 90; ?>px;"></span>
                                        <ul class="fix">
                                            <li style="padding-bottom: 0;width:190px;">
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/accessory/new">Новинки</a></dt>
                                                    <?php
                                                    for ($i = 0; $i < 11; $i++):
                                                        if (!isset($catalogs[$i]))
                                                            continue;
                                                        $catalog = $catalogs[$i];
                                                        $clink = Catalog::instance($catalog)->get('link');
                                                        ?>
                                                        <dt><a href="<?php echo LANGPATH; ?>/<?php echo $clink; ?>"><?php echo ucfirst(Catalog::instance($catalog, LANGUAGE)->get('name')); ?></a></dt>
                                                        <?php
                                                        if($clink == 'scarves-snoods')
                                                        {
                                                            ?>

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
                                                        <dt><a href="<?php echo LANGPATH; ?>/<?php echo Catalog::instance($catalog)->get('link'); ?>"><?php echo ucfirst(Catalog::instance($catalog, LANGUAGE)->get('name')); ?></a></dt>
                                                        <?php
                                                    endfor;
                                                    ?>
                                                    <dt>
                                                    <?php
                                                    $accessory_banners = DB::select()->from('banners')->where('type', '=', 'accessory')->where('visibility', '=', 1)->where('lang', '=', '')->execute()->as_array();
                                                    if(isset($accessory_banners[0]))
                                                    {
                                                    ?>
                                                        <a href="<?php echo LANGPATH . $accessory_banners[0]['link']; ?>"><img src="http://img.choies.com/uploads/1/files/<?php echo $accessory_banners[0]['image']; ?>" alt="<?php echo $accessory_banners[0]['alt']; ?>" title="<?php echo $accessory_banners[0]['title']; ?>" /></a>
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
                                    <a href="<?php echo LANGPATH; ?>/outlet" class="sale">Распродажа</a>
                                    <div class="nav_list JS_showcon hide" style="width: 244px; margin-left: 202px;">
                                        <span class="topicon" style="left: 90px;"></span>
                                        <ul class="fix">
                                            <li style="padding-bottom: 0;width:240px;">
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/salute-the-spring">ВЕСЕННЯЯ РАСПРОДАЖА</a></dt>
                                                    <br>
                                                    <dt><a href="<?php echo LANGPATH; ?>/activity/flash_sale">FLASH SALE</a></dt>
                                                    <br>
                                                    <dt>По цене</dt>
                                                    <dd><a href="<?php echo LANGPATH; ?>/usd2" style="color:#ba2325;">USD1.9</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/2014-summer-sale?0814" style="color:#ba2325">USD9.9</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/usd20">USD19.9</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/usd30">USD29.9</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/usd30">USD29.9</a></dd>
                                                    <br>
                                                    <dt>По виду</dt>
                                                    <?php
                                                    $outlet = DB::select('id')->from('products_category')->where('link', '=', 'outlet')->execute()->get('id');
                                                    $outlets = Catalog::instance($outlet)->children();
                                                    foreach ($outlets as $c)
                                                    {
                                                        $link = Catalog::instance($c)->get('link');
                                                        if (strpos($link, 'usd') === False)
                                                        {
                                                            ?>
                                                            <dd><a href="<?php echo LANGPATH; ?>/<?php echo $link; ?>"><?php echo Catalog::instance($c, LANGUAGE)->get('name'); ?></a></dd>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <br>
                                                </dl>
                                            </li>
                                        </ul>
                                    </div>

                                </li>
                                <li class="JS_show">
                                    <a href="#">Деятельность</a>
									<div class="nav_list JS_showcon  hide" style="width: 580px; left: -300px;">
                                            <span class="topicon" style="left: 330px;"></span>
                                        <ul class="fix new_list">
                                            <li style="padding-bottom: 0px;">
                                                <dl>
                                                    <dt>Рекомендуемые</dt>
                                                    <dd><a href="<?php echo LANGPATH; ?>/freetrial/add">Центр бесплатного испытания</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/rate-order-win-100">Rate to Win $100</a></dd>
													<dd><a href="<?php echo LANGPATH; ?>/activity/flash_sale">FLASH SALE</a></dd>
													<dd><a href="<?php echo LANGPATH; ?>/ready-to-be-shipped">Отправить в течение 24 часов</a></dd>
                                                </dl>
                                            </li>
                                            <li style="padding-bottom: 0px;">
                                                <dl>
                                                    <dt>Тенденция</dt>
                                                    <dd><a href="<?php echo LANGPATH; ?>/tropical-palm-tree-print">С Рисунком Пальмовых Деревьев</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/off-shoulder">С Открытыми Плечами</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/stripes-collection">Полосатая Коллекция</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/crochet-lace">Вязание Кружева</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/vintage-floral">С Рисунком Цветов</a></dd>
													 <dd><a href="<?php echo LANGPATH; ?>/kimonos?sort=0&limit=1">Кимоно стиль</a></dd>
                                                </dl>
                                            </li>

                                            <li style="padding-bottom: 0px;">
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/lookbook">Лукбук</a></dt>
                                                </dl>
                                                <dl>
                                                <?php
                                                    $activities_banners = DB::select()->from('banners')->where('type', '=', 'activities')->where('visibility', '=', 1)->where('lang', '=', LANGUAGE)->execute()->as_array();
                                                    ?>
                                                    <dt><a href="<?php echo $activities_banners[0]['link']; ?>"><img src="http://img.choies.com/uploads/1/files/<?php echo $activities_banners[0]['image']; ?>" /></a></dt>
                                                </dl>
                                            </li>
                                            <li style="width:318px">
                                                <dl>
                                                    <dt>Социальные И СМИ</dt>
                                                    <dd class="sns fix">
                                                        <a rel="nofollow" href="http://www.facebook.com/choiescloth" target="_blank" class="sns1"></a>
                                                        <a rel="nofollow" href="http://twitter.com/#!/choiescloth" target="_blank" class="sns2"></a>
                                                        <a rel="nofollow" href="http://thatisstylish.tumblr.com" target="_blank" class="sns3"></a>
                                                        <a rel="nofollow" href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4"></a>
                                                        <a rel="nofollow" href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a>
                                                        <a rel="nofollow" href="http://www.chictopia.com/Choies" target="_blank" class="sns6"></a>
                                                        <a rel="nofollow" href="http://instagram.com/choiescloth" target="_blank" class="sns7"></a>
                                                        <a rel="nofollow" href="http://blog.choies.com" target="_blank" class="sns8"></a>
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
                                $searchword=DB::select('name')->from('search_hotword')->where('active', '=', 1)->where('type', '=', 1)->where('lang', '=', LANGUAGE)->where('site_id', '=', 1)->execute()->get('name');
                            ?>
                            <form action="<?php echo LANGPATH; ?>/search" method="get" id="search_form" onsubmit="return search(this);">
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
                                    location.href = "<?php echo LANGPATH; ?>/search/" + q.replace(/\s/g, '_');
                                    return false;
                                }
                            </script>
                        </div>
                    </div>  
                </div>
                <div id="JS_floatnav" class="nav2 bottom hide">
                    <div class="layout fix">
                        <nav class="nav fll">
                            <a href="<?php echo LANGPATH; ?>/" class="home nav_home"></a>
                            <div id="nav2"></div>
                        </nav>
                        <div class="search">
                        </div>
                        <div class="nav2_right flr">
                            <?php if ($user_id): ?>
                                <a href="<?php echo LANGPATH; ?>/customer/summary">Личный кабинет</a>
                            <?php else: ?>
                                <a href="<?php echo LANGPATH; ?>/customer/summary">Вход</a>
                            <?php endif; ?>
                            <div class="mybag JS_show">
                                <a href="<?php echo LANGPATH; ?>/cart/view">Корзина<span class="rum cart_count">0</span></a>
                                <div class="mybag_box JS_showcon hide">
                                    <span class="topicon"></span>
                                    <div class="mybag_con">
                                        <h4 class="tit">КОРЗИНА ТОВАРЫ</h4>
                                        <div class="cart_bag items mtb5"></div>
                                        <div class="cart-all-goods mr20">
                                            <p><span class="bold mr5 cart_count"></span>товар в вашей корзине</p>
                                             <p class="bold">Итого: <span class="cart_amount"></span></p>
                                        </div>
                                        <div class="cart_bag_empty cart-empty-info" style="display:none;">Ваша корзина сейчас пуста.</div>
                                        <p class="cart_button">
                                            <a href="<?php echo LANGPATH; ?>/cart/view" class="btn30_14_black">в корзину</a>
                                            <a href="<?php echo LANGPATH; ?>/cart/checkout" class="btn30_14_red ml20">оформить</a>
                                        </p>
                                        <p class="cart_button_empty" style="display:none;"><a href="<?php echo LANGPATH; ?>/cart/view" class="btn40_16_red">Посмотреть корзину</a></p>
                                        <!--<p class="ppexpress mt10"><a href="javascript:void(0)" style="background:none;" onclick="location.href='/payment/ppec_set';" id="pp_express"><img src="/images/ppec.jpg" alt="Klicken Sie hier, um per PayPal Express zu bezahlen." style="vertical-align: middle;"></a></p>-->
                                    </div>
                                    <p class="free-shipping free_shipping" style="display:none;">Добавьте 1+ товар С Пометкой "Бесплатная Доставка" <br>Добавьте 1+ товар С Пометкой "Бесплатная Доставка".</p>
                                    <p class="free-shipping sale_words" style="display:none;"></p>
                                </div>
                            </div>
                            <div class="mybag1" id="mybag2">
                                <div class="currentbag mybag_box hide">
                                    <span class="topicon"></span>
                                    <div class="mybag_con">
                                        <h4 class="tit">Молодец! Товар добавлен в корзину. </h4>
                                        <div class="bag_items items mtb5">
                                            <li class="fix"></li>
                                            <p><a href="<?php echo LANGPATH; ?>/cart/view" class="btn40_16_red" style="font-size: 12px;">Посмотреть корзину</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="currency1 JS_show ">
                                  <span class="lan">Русский</span>
                                  <div class="currency_con JS_showcon hide " style="right:20px;display:none">
                                      <span class="topicon" style="right:50px"></span>
                                        <dl id="sites" >
                                        <dd><a href="http://www.choies.com<?php echo $request; ?>">English</a></dd>
                                        <dd><a href="http://www.choies.com/es<?php echo $request; ?>">Español</a></dd>
                                        <dd><a href="http://www.choies.com/de<?php echo $request; ?>">Deutsch</a></dd>
                                        <dd><a href="http://www.choies.com/fr<?php echo $request; ?>">Français</a></dd>
                                        <dd><a href="http://www.choies.com/ru<?php echo $request; ?>">Русский</a></dd>
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
                                                    <a href="<?php echo LANGPATH; ?>/currency/set/<?php echo $currency['name'] ?>" class="icon_flag icon_<?php echo strtolower($currency['name']); ?>"><?php echo $code . $currency['name']; ?></a>
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
<script src="//cdn.optimizely.com/js/557241246.js"></script>
<section id="main">
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="mlr30">
                <h1 style="line-height: 25px">Спасибо большое!</h1>
                <ul class="paysuccess_t">
                    <li>Вы успешно завершили ваш платеж.
                    <li>Нажмите номер вашего заказа: <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><?php echo $order['ordernum']; ?></a> для просмотра более подробной информации.</li>
                    <li>Außerdem erhalten Sie eine Übersicht über Ihre Bestellinformationen per E-Mail.</li> 
                    <li>Вы также будете получить сводную информацию о вашем заказе по электронной почте. </li> 
                    <li>Если у вас есть вопросы о вашем заказе,то <a href="<?php echo LANGPATH; ?>/contact-us">свяжитесь с нами</a>.</li>
                    <li><a href="<?php echo LANGPATH; ?>/" class="view_btn btn26 btn40">Продолжить покупки</a></li>
                </ul>
                <dl class="paysuccess_b">
                    <dt>Вы можете посмотреть наши текущие распродажи:</dt>
                    <div class="rows_3 fix">
                        <ul class="fix mtb10 rows_3_con">
                        <li style="width: 45%;">
                            <a href="<?php echo LANGPATH; ?>/freetrial/add" class="a2" style="height: 180px;"><span class="s1">Центр бесплатного испытания</span>
                                <span class="s2">Товары+доставка=$0</span>
                                <span class="s3">Испытайте свою удачу</span>
                            </a>
                        </li>
                        <li style="width: 45%; margin-left: 4.2%;">
                            <a href="<?php echo LANGPATH; ?>/activity/flash_sale" class="a1" style="height: 180px;"><span class="s1">FLASH SALE</span>
                                <span class="s2">Скидки дня и скидки недели</span>
                                <span class="s3">Время летит</span>
                            </a>
                        </li>
                    </ul>
                    </div>
                    <dt>Или поделиться своим заказанным позициям с друзьями через сайты социальных сетей:</dt>
                    <dd>
                        <p class="font14">Выберите товар, который вы хотите поделиться:</p>
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
                                            <a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo $p['link']; ?>" class="a1"></a>
                                            <a target="_blank" href="http://twitter.com/share?url=<?php echo $p['link']; ?>" class="a2"></a>
                                            <a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(Product::instance($p['product_id'])->permalink()); ?>&media=<?php echo Image::link(Product::instance($p['product_id'])->cover_image(), 1); ?>&description=<?php Product::instance($p['product_id'])->get('name'); ?>" class="a3"></a>
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
        <?php echo View::factory(LANGPATH.'/customer/left'); ?>
    </section>
</section>
<img src="https://hotdeals.dmdelivery.com/x/conversion/?order_hva=<?php echo $order['ordernum']; ?>" alt="" width="1" height="1" />
<?php 
    $currency = Site::instance()->currencies($order['currency']);
?>
<!-- webpower Foreign Statistical code by zhang.jinling-->
<img src="http://choies-mail.dmdelivery.com/x/conversion/?buy=<?php echo $order["ordernum"]."_".$currency['code'] . round($order["amount"],2); ?>" alt="" width="1" height="1" />
<img src="http://choies-mail.dmdelivery.com/x/conversion/?price=<?php echo $currency['code'] . round($order["amount"],2); ?>" alt="" width="1" height="1" />
<!-- webpower Foreign Statistical code by zhang.jinling-->
<img src="http://choies-service.dmdelivery.com/x/conversion/?order=<?php echo $order["ordernum"]; ?>" alt="" width="1" height="1" />
<img src="http://choies-service.dmdelivery.com/x/conversion/?price=<?php echo $currency['code'] . round($order["amount"],2); ?>" alt="" width="1" height="1" />

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
<script>
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

<?php if (strtolower($_COOKIE["ChoiesCookie"]) == "cj")
{ ?>
    <!--begin cj platform code -->
    <iframe height="1" width="1" frameborder="0" scrolling="no" src="https://www.emjcd.com/tags/c?containerTagId=4452&<?php echo $cj_sku; ?>&<?php echo $cj_amt; ?>&<?php echo $cj_qty; ?>&CID=1527669&OID=<?php echo $order['ordernum']; ?>&TYPE=361456&CURRENCY=<?php echo $order['currency']; ?>&Discount=<?php echo $discount; ?>" name="cj_conversion" ></iframe>
<?php } ?>

<?php
if (isset($_COOKIE["ChoiesCookie"]))
{
    Kohana_Log::instance()->add('ChoiesCookie', $_COOKIE["ChoiesCookie"]);
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
        <!-- main end -->

        <?php
        if ($type != 'payment' && $type != 'purchase' && $type != 'cart')
        {
            ?>
            <!-- footer begin -->
            <footer>
                <div class="w_top">
                    <div class="top layout fix">
                        <dl>
                            <dt>Личный кабинет</dt>
                            <dd><a href="<?php echo LANGPATH; ?>/track/track_order">Отслеживать заказ</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/customer/orders">История заказов</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/customer/profile">Настройка профиля</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/customer/points_history">История баллов</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/customer/wishlist">Избранное</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/vip-policy">VIP статус</a></dd>
                            <dd><a onclick="return feed_show();">Фидбэк</a></dd>
                        </dl>
                        <dl>
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
                        <dl>
                            <dt>Популярный</dt>
                            <dd><a href="<?php echo LANGPATH; ?>/lookbook">Лукбук</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/freetrial/add">Бесплатная доставка</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/activity/flash_sale">FLASH SALE</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/wholesale">Оптовая торговля</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/affiliate-program">Партнёрская программа</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/blogger/programme">Блоггер хочет</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/rate-order-win-100" style="color:red;">Rate & Win $100</a></dd>
                        </dl>
                        <dl>
                            <dt>Все сайты</dt>
                            <dd class="lang"><a href="<?php echo $request; ?>">Английский сайт</a></dd>
                            <dd class="lang"><a href="/es<?php echo $request; ?>">Испанский сайт</a></dd>
                            <dd class="lang"><a href="/fr<?php echo $request; ?>">Французкий сайт</a></dd>
                            <dd class="lang"><a href="/de<?php echo $request; ?>">Немецкий сайт</a></dd>
                            <dd class="lang"><a href="/ru<?php echo $request; ?>">Россиский сайт</a></dd>
                        </dl>
                        <dl class="last">
                            <dt>Найти Нас На</dt>
                            <dd class="sns fix">
                                <a rel="nofollow" href="http://www.facebook.com/choiescloth" target="_blank" class="sns1"></a>
                                <a rel="nofollow" href="http://twitter.com/#!/choiescloth" target="_blank" class="sns2"></a>
                                <a rel="nofollow" href="http://thatisstylish.tumblr.com" target="_blank" class="sns3"></a>
                                <a rel="nofollow" href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4"></a>
                                <a rel="nofollow" href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a>
                                <a rel="nofollow" href="http://www.chictopia.com/Choies" target="_blank" class="sns6"></a>
                                <a rel="nofollow" href="http://instagram.com/choiescloth" target="_blank" class="sns7"></a>
                            </dd>
                            <dd class="letter">
                                <form action="" method="post" id="letter_form">
                                    <label>Подпишитесь на нашу электронную почту </label>
                                    <div class="fix">
                                        <input type="text" id="letter_text" class="text fll" value="Адрес почты" onblur="if(this.value==''){this.value=this.defaultValue;}"  onfocus="if(this.value=='Адрес почты'){this.value='';};" />
                                        <input type="submit" id="letter_btn" value="Дальше" class="btn fll" />
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
                                            var message = data['message'];
                                            message = message.replace('You are in Now. Thanks', 'Вы сейчас находитесь. Спасибо！');
                                            message = message.replace('Sorry, email has been used', 'Извините, этот электронной почты был использован.');
                                            message = message.replace('Please enter a valid email address', 'Заполните действительный адрес электронной почты.');
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
                        </dl>
                    </div>
                    <div class="card">
                        <p>
                            <img src="/images/card.jpg" usemap="#Card" />
                            <map name="Card" id="Card">
                                <area shape="rect" coords="88,2,193,62" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en" target="_blank" />
                            </map>
                        </p>
                        <p class="bottom">
                            Copyright © 2006-<?php echo date('Y'); ?> choies.com&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a style="color: #ccc;" href="<?php echo LANGPATH; ?>/privacy-security">Конфиденциальность И Безопасность</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a style="color: #ccc;" href="<?php echo LANGPATH; ?>/about-us">О Нами</a>
                        </p>
                    </div>
                </div>
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
                            var message = data['message'];
                            message = message.replace('Your feedback cannot be received', 'Ihr Feedback kann nicht empfangen werden');
                            message = message.replace('Sorry! No more than 5 feedbacks in 24 hours!', 'Es tut uns leid! Nicht mehr als 5 Bewertungen in 24 Stunden!');
                            $('body').append('<div id="wingray3" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                            $('#feedback_success').appendTo('body').fadeIn(240);
                            if(data['success'] == 0)
                            {
                                $("#feedback_success .failed1").show();
                                $("#feedback_success .failed1 p").html(message);
                                $("#feedback_success .success1").hide();
                                $("#wingray3").remove();
                                $("#feedback").hide();
                            }
                            else if(data['success'] == -1)
                            {
                                $("#feedback_success .failed1").show();
                                $("#feedback_success .failed1 p").html(message);
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
                        <div class="fll text1">CHOIES ХОЧЕТ СЛЫШАТЬ ВАШ ГОЛОС!</div>
                        <div class="close_btn3 clsbtn" style="right: 0px;top: 3px;"></div>
                    </div>
                    <div class="clear"></div>
                    <div class="point ml15 mt5">Вы можете получить <strong class="red">$5</strong> баллов награда после предоставления обратной связи.</div>
                    <div id="tab6">
                        <div id="tab-nav" class="JS_tab5">
                            <ul class="fix">
                                <li class="on">Фидбэк</li>
                                <li>Проблема?</li>
                            </ul>
                        </div>
                        <div id="tab-con" class="JS_tabcon5">
                            <div>
                                <form id="feedbackForm" method="post" action="#" class="form formArea">
                                    <ul>
                                        <li>
                                            <label for="My Suggestion:">Choies,это то, что мне нравится: </label>
                                            <textarea name="what_like" id="what_like" rows="3" class="input textarea"></textarea>
                                        </li>
                                        <li>
                                            <label for="My Suggestion:"><span>*</span> Choies, я думаю, что вы можете сделать лучше: <span class="errorInfo clear hide">Bitte schreiben Sie hier etwas.</span></label>
                                            <textarea name="do_better" id="do_better" rows="5" class="input textarea"></textarea>
                                        </li>
                                        <li>
                                            <label for="Email Adresse:"><span>*</span> Адрес электронной почты:<span class="errorInfo clear hide">Предоставьте адрес электронной почты,пожалуйста.</span><br/>
                                            </label>
                                            <input type="email" name="email" id="f_email1" class="text text_long" value="" maxlength="340" />
                                        </li>
                                        <li>
                                            <input type="submit" value="Дальше" class="view_btn btn26 btn40 form_btn" style="width: 100px;" />
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
                            <div class="hide">
                                <form id="problemForm" method="post" action="#" class="form formArea">
                                    <ul>
                                        <li>
                                            <label for="My Suggestion:"><span>*</span> Вам помочь? Пожалуйста, опишите проблему: <span class="errorInfo clear hide">Bitte schreiben Sie hier etwas.</span></label>
                                            <textarea name="comment" id="f_comment" rows="7" class="input textarea"></textarea>
                                        </li>
                                        <li>
                                            <label for="Email Adresse:"><span>*</span> Адрес электронной почты:<span class="errorInfo clear hide">Предоставьте адрес электронной почты,пожалуйста.</span><br/>
                                            </label>
                                            <input type="email" name="email1" id="f_email2" class="text text_long" value="" maxlength="340" />
                                        </li>
                                        <li>
                                            <input type="submit" value="Дальше" class="view_btn btn26 btn40 form_btn" style="width: 100px;" />
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
                                <p class="mt10">Более подробные вопросы? Пожалуйста, <a href="http://messenger.providesupport.com/messenger/01rl3tjgz7wq50rth1bmgy76zj.html" title="contact us" target="_blank">свяжитесь с нами</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="feedback_success" style="display:none;">
                <div class="feedback" style="height:200px;">
                    <div class="close_btn3 clsbtn" style="right: 0px;top: 3px;"></div>
                    <div class="success1">
                        <h3>Спасибо!</h3>
                        <p><em>Ваш фидбэк был получен !</em></p>
                    </div>
                    <div class="failed1">
                        <h3>Извините!</h3>
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
                $(function(){
                    //cart ajax
                    ajax_cart();
                    
                    $('.currency_select').change(function(){
                        var currency = $(this).val();
                        location.href = '/currency/set/' + currency;
                        return false;
                    })
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
            <?php
        }
        ?>
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
            elseif (in_array($type, array('cart','category','home','purchase')))
            {
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

            <script>
            $(function(){
                $('a').click(function(){
                    var lang = '/<?php echo LANGUAGE; ?>';
                    var h = $(this).attr('href');
                    var c = $(this).parent().attr('class');
                    if(c != 'lang')
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
            </script>

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
            $email = Customer::instance($user_id)->get('email');
            ?>
            <script type="text/javascript">ScarabQueue.push(['setEmail', '<?php echo $email; ?>']);</script>
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
            <img src="track.excelmob.com?add=NHRmmv7KbM"/>
            <img src="track.excelmob.com?purchase=EXCELMOB-150003&segment=zIVosBUe86&sku=PRODUCT-SKU-HERE&orderref=ORDER-REF-HERE&ordervalue=ORDER-VALUE-HERE" />
        </div>
        <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 970256491;
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        /* ]]> */
        </script>
        <script type="text/javascript" src="www.googleadservices.com/pagead/conversion.js">
        </script>
        <noscript>
        <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/970256491/?value=0&amp;guid=ON&amp;script=0"/>
        </div>
        </noscript>
        <img height="1" width="1" alt="" src="https://ct.pinterest.com/?tid=WIGOXXSyALa"/>
        <img height="1" width="1" alt="" src="https://ct.pinterest.com/?tid=Gt0JgSDWKiV"/>
    </body>
</html>
