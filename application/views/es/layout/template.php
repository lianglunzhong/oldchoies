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
        <link type="text/css" rel="stylesheet" href="/css/es.css" media="all" id="mystyle" />
        <script src="/js/jquery-1.7.2.min.js"></script>
        <script src="/js/plugin.js"></script>
        <script src="/js/global.js"></script>
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

        <?php
        $type = isset($type) ? $type : '';
        if($type == 'purchase')
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
        window._fbq.push(['track', '6015191467430', {'value':'0.00','currency':'USD'}]);
        </script>
        <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6015191467430&amp;cd[value]=0.00&amp;cd[currency]=USD&amp;noscript=1" /></noscript>
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
window._fbq.push(['track', '6014860836030', {'value':'0.00','currency':'USD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6014860836030&amp;cd[value]=0.00&amp;cd[currency]=USD&amp;noscript=1" /></noscript>
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
        ?>
        <!-- header begin -->
        <?php
        if ($type != 'payment' && $type != 'purchase' && $type != 'cart')
        {
            ?>
            <header>
			<!-- <div class="wt_top JS_hide">
					<div class="topbanner layout fix">
						<a href="http://www.choies.com/es/top-sellers?hph0327" target="_blank"><img src="/../images/esbanner.png" /></a>
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

                            $request = str_replace(LANGPATH, '', $request);
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
                            <a href="<?php echo LANGPATH; ?>/faqs">AYUDA</a>
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
                                ¡HOLA! <span title="<?php echo $firstname; ?>"><?php echo $fname; ?></span> !
                                <div class="JS_show" style="display:inline-block">
                                    <a href="<?php echo LANGPATH; ?>/customer/summary" rel="nofollow" class="myaccount ">MI CUENTA</a>
                                    <div class="myaccount-hide JS_showcon hide" style="display: none;">
                                       <ul>
                                       <li><a href="<?php echo LANGPATH; ?>/customer/orders" rel="nofollow">Mis Pedidos</a></li>
                                       <li><a href="<?php echo LANGPATH; ?>/track/track_order" rel="nofollow">Rastrear</a></li>
                                       <li><a href="<?php echo LANGPATH; ?>/customer/points_history" rel="nofollow">Mis Puntos</a></li>
                                       <li><a href="<?php echo LANGPATH; ?>/customer/profile" rel="nofollow">Mi Perfil</a></li>
                                       <li><a href="<?php echo LANGPATH; ?>/customer/logout" rel="nofollow">SALIR </a></li>
                                       </ul>
                                   </div>
                                </div>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a href="<?php echo LANGPATH; ?>/customer/login">ACCEDER</a>
                                <div class="JS_show" style="display:inline-block">
                                    <a href="<?php echo LANGPATH; ?>/customer/summary" rel="nofollow" class="myaccount ">MI CUENTA</a>
                                    <div class="myaccount-hide JS_showcon hide" style="display: none;">
                                       <ul>
                                       <li><a href="<?php echo LANGPATH; ?>/customer/orders" rel="nofollow">Mis Pedidos</a></li>
                                       <li><a href="<?php echo LANGPATH; ?>/track/track_order" rel="nofollow">Rastrear</a></li>
                                       <li><a href="<?php echo LANGPATH; ?>/customer/points_history" rel="nofollow">Mis Puntos</a></li>
                                       <li><a href="<?php echo LANGPATH; ?>/customer/profile" rel="nofollow">Mi Perfil</a></li>
                                       <li><a href="<?php echo LANGPATH; ?>/customer/logout" rel="nofollow">Salir</a></li>
                                       </ul>
                                   </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="mybag JS_show">
                                <a href="<?php echo LANGPATH; ?>/cart/view">MI BOLSA<span class="rum cart_count">0</span></a>
                                <div class="mybag_box JS_showcon hide">
                                    <span class="topicon"></span>
                                    <div class="mybag_con">
                                        <h4 class="tit">ARTÍCULOS DE SU BOLSA</h4>
                                        <div class="cart_bag items mtb5"></div>
                                        <div class="cart-all-goods mr20">
                                            <p><span class="bold mr5 cart_count"></span>Artículo<span class="cart_s"></span> en su bolsa</p>
                                             <p class="bold">Total: <span class="cart_amount"></span></p>
                                        </div>
                                        <div class="cart_bag_empty cart-empty-info" style="display:none;">Su cesta de compra está vacía.</div>
                                        <p class="cart_button">
                                            <a href="<?php echo LANGPATH; ?>/cart/view" class="btn30_14_black">VER MI BOLSA</a>
                                            <a href="<?php echo LANGPATH; ?>/cart/checkout" class="btn30_14_red ml20">PAGAR</a>
                                        </p>
                                        <p class="cart_button_empty" style="display:none;"><a href="<?php echo LANGPATH; ?>/cart/view" class="btn40_16_red">VER MI BOLSA</a></p>
                                        <!--<p class="ppexpress mt10"><a href="javascript:void(0)" style="background:none;margin-right: 40px;" onclick="location.href='<?php //echo LANGPATH; ?>/payment/ppec_set';" id="pp_express"><img src="/images/ppec.jpg" alt="Click here to pay via PayPal Express Checkout" style="vertical-align: middle;padding-left:15px;"></a></p>-->
                                    </div>
                                    <p class="free-shipping free_shipping" style="display:none;">Añadir 1+ artículo marcado "Free Shipping" <br>para disfrutar envío gratis por todo el pedido</p>
                                    <p class="free-shipping sale_words" style="display:none;"></p>
                                </div>
                            </div>
                            <div class="mybag1" id="mybag1">
                                <div class="currentbag mybag_box hide">
                                    <span class="topicon"></span>
                                    <div class="mybag_con">
                                        <h4 class="tit">¡EXITO! ARTÍCULO AÑADIDO A BOLSA</h4>
                                        <div class="bag_items items mtb5">
                                            <li class="fix"></li>
                                            <p><a href="<?php echo LANGPATH; ?>/cart/view" class="view_btn btn40_16_red">VER MI BOLSA</a></p>
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
                                    <a href="<?php echo LANGPATH; ?>/daily-new">NOVEDADES</a>
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
                                    <a href="<?php echo LANGPATH; ?>/apparels-c-40">ROPA</a>
                                    <div class="nav_list JS_showcon apparel hide">
                                        <span class="topicon"></span>
                                        <ul class="fix">
                                            <li>
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/tops-c-442">TOPS</a></dt>
                                                    <?php
                                                    $links = array(
                                                        array('Camisetas','t-shirts-c-245'),
                                                        array('Abrigos Y Chaquetas','coats-jackets-c-45'),
                                                        array('Kimonos','kimonos-c-414'),
                                                        array('Camisas Y Blusas','shirt-blouse-c-43'),
                                                        array('Piel de Imitación','unreal-fur-c-285'),
                                                        array('Traje De Dos Piezas','two-piece-suit-c-177'),
                                                        array('Trajes Y Blazers','suits-blazers-c-46'),
                                                        array('Jerseis Y Cardigáns','jumpers-cardigans-c-89'),
                                                        array('Mono Largo Y Corto','jumpsuits-playsuits-c-119'),
                                                        array('Chaquetas de Cuero','leather-biker-jackets-c-120'),
                                                        array('Sudaderas Con Y Sin Capucha','hoodies-sweatshirts-c-117'),
                                                        array('Trajes De Baño','swimwear-beachwear-c-178'),
                                                        array('Tops Cortos Y Corpinos','crop-tops-bralets-c-244'),
                                                        array('Chalecos Y Camisolas','vests-tanks-c-242'),
                                                    );
                                                    $hots=array("jumpsuits-playsuits-c-119","kimonos-c-414","crop-tops-bralets-c-244","swimwear-beachwear-c-178");
                                                    ?>
                                                    <?php
                                                    foreach($links as $link)
                                                    {
                                                    ?>
                                                        <dd><a href="<?php echo LANGPATH; ?>/<?php echo $link[1]; ?>" <?php if(in_array($link[1],$hots)){ echo 'style="color:#ba2325;"'; }?>><?php echo $link[0]; ?></a></dd>
                                                    <?php
                                                    }
                                                    ?>
                                                </dl>
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/bottoms-c-240">BOTTOMS </a></dt>
                                                    <?php
                                                    $hots = array(
                                                        99
                                                    );
                                                    $catalog1 = DB::select('id')->from('catalogs_es')->where('link', '=', 'bottoms')->execute()->get('id');
                                                    $catalogs = Catalog::instance($catalog1)->children();
                                                    foreach ($catalogs as $catalog):
                                                        $link = Catalog::instance($catalog, LANGUAGE)->permalink();
                                                        $name = Catalog::instance($catalog)->get('name');
                                                        ?>
                                                        <dd><a href="<?php echo $link; ?>" <?php if(in_array($catalog, $hots)) echo 'style="color:#ba2325;"'; ?>><?php echo ucfirst(Catalog::instance($catalog, LANGUAGE)->get('name')); ?></a></dd>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </dl>
                                            </li>
                                            <li>
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/dresses-c-92">VESTIDOS</a></dt>
                                                    <?php
                                                    $links = array(
                                                        array('Vestidos Maxi', 'maxi-dresses-c-207'),
                                                        array('Vestidos Negros', 'black-dresses-c-203'),
                                                        array('Vestidos Blancos', 'white-dresses-c-204'),
                                                        array('Vestidos Ajustados', 'bodycon-dresses-c-211'),
                                                        array('Vestidos De Encaje', 'lace-dresses-c-209'),
                                                        array('Vestido por Fiesta', 'homecoming-dresses-c-454'),
                                                        array('Vestidos De Mangas Cortas', 'long-sleeve-dresses-c-507'),
                                                        array('Vestido de Hombros Descubiertos', 'off-the-shoulder-dresses-c-504'),
                                                        array('Vestido sin Espalda', 'backless-dress-c-456'),
                                                        array('Vestidos De Mangas Largas', 'short-sleeve-dresses-c-505'),
                                                    );
                                                    $hot_dresses=array("maxi-dresses-c-207","off-the-shoulder-dresses-c-504","lace-dresses-c-209");
                                                    foreach ($links as $link):
                                                        ?>
                                                        <dd><a href="<?php echo $link[1]; ?>" <?php if(in_array($link[1],$hot_dresses)){ echo 'style="color:#ba2325;"'; }?>><?php echo $link[0]; ?></a></dd>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </dl>
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/men-s-collection-c-91">HOMBRE</a></dt>
                                                    <?php
                                                    $catalog1 = DB::select('id')->from('catalogs_es')->where('link', '=', 'men-s-collection')->execute()->get('id');
                                                    $catalogs = Catalog::instance($catalog1)->children();
                                                    foreach ($catalogs as $catalog):
                                                        $cname = strtolower(Catalog::instance($catalog, LANGUAGE)->get('name'));
                                                        $cname = str_replace('de hombres', '', $cname);
                                                        ?>
                                                        <dd><a href="<?php echo Catalog::instance($catalog, LANGUAGE)->permalink(); ?>"><?php echo ucfirst($cname); ?></a></dd>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </dl>
                                            </li>
                                            <li>
                                                <!--<dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/apparels-c-40/new">NOVEDADES</a></dt>
                                                    <dd><a href="#"></a></dd>
                                                </dl>-->
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/top-sellers-c-32">LOS MÁS VENDIDOS</a></dt>
                                                    <dd><a href="#"></a></dd>
                                                </dl>
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/outlet-c-101">OUTLET</a></dt>
                                                    <dd><a href="#"></a></dd>
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
                                                    <dt>LOS MÁS RECIENTES Y CALIENTES</dt>
                                                    <dl>
                                                        <?php
                                                        $lookbook_banner = DB::select()->from('banners')->where('type', '=', 'apparel')->where('visibility', '=', 1)->execute()->as_array();
                                                        ?>
                                                        <a href="<?php echo LANGPATH . $lookbook_banner[1]['link']; ?>"><img src="http://img.choies.com/uploads/1/files/<?php echo $lookbook_banner[1]['image']; ?>" width="190px" /></a>
                                                    </dl>
                                                </dl>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="JS_show">
                                    <a href="<?php echo LANGPATH; ?>/shoes-c-53">ZAPATOS</a>
                                    <div class="nav_list JS_showcon hide" style="width: 174px; margin-left: 205px;">
                                        <span class="topicon" style="left: 90px;"></span>
                                        <ul class="fix">
                                            <li style="padding-bottom: 0;">
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/shoes-c-53/new">NOVEDADES</a></dt>
                                                    <?php
                                                    $catalog1 = DB::select('id')->from('catalogs_es')->where('link', '=', 'shoes')->execute()->get('id');
                                                    $catalogs = Catalog::instance($catalog1)->children();
                                                    foreach ($catalogs as $catalog):
                                                        ?>
                                                        <dt><a href="<?php echo Catalog::instance($catalog, LANGUAGE)->permalink(); ?>"><?php echo ucfirst(Catalog::instance($catalog, LANGUAGE)->get('name')); ?></a></dt>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </dl>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="JS_show">
                                    <a href="<?php echo LANGPATH; ?>/accessory-c-52">ACCESORIOS</a>
                                    <?php
                                    $catalog1 = DB::select('id')->from('catalogs_es')->where('link', '=', 'accessory')->execute()->get('id');
                                    $catalogs = Catalog::instance($catalog1)->children();
                                    $count = count($catalogs);
                                    ?>
                                    <div class="nav_list JS_showcon hide" style="<?php if ($count > 11) echo 'width: 400px; margin-left: 140px;'; else echo 'width: 174px; margin-left: 230px;' ?>">
                                        <span class="topicon" style="left: <?php if ($count > 11) echo 185; else echo 90; ?>px;"></span>
                                        <ul class="fix">
                                            <li style="padding-bottom: 0;width:190px;">
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/accessory-c-52/new">NOVEDADES</a></dt>
                                                    <?php
                                                    for ($i = 0; $i < 11; $i++):
                                                        if (!isset($catalogs[$i]))
                                                            continue;
                                                        $catalog = $catalogs[$i];
                                                        $clink = Catalog::instance($catalog, LANGUAGE)->permalink();
                                                        ?>
                                                        <dt><a href="<?php echo $clink; ?>"><?php echo ucfirst(Catalog::instance($catalog, LANGUAGE)->get('name')); ?></a></dt>
                                                        <?php
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
                                                        <dt><a href="<?php echo Catalog::instance($catalog, LANGUAGE)->permalink(); ?>"><?php echo ucfirst(Catalog::instance($catalog, LANGUAGE)->get('name')); ?></a></dt>
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
                                    <a href="<?php echo LANGPATH; ?>/outlet-c-101" class="sale">OUTLET</a>
                                    <div class="nav_list JS_showcon hide" style="width: 210px; margin-left: 202px;">
                                        <span class="topicon" style="left: 90px;"></span>
                                        <ul class="fix">
                                            <li style="padding-bottom: 0;width:210px;">
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/salute-the-spring-c-508">VENTA DE PRIMAVERA</a></dt>
                                                    <br>
                                                    <dt><a href="<?php echo LANGPATH; ?>/activity/flash_sale">FLASH SALE</a></dt>
                                                    <br>
                                                    <dt>POR EL PRECIO</dt>
                                                    <dd><a href="<?php echo LANGPATH; ?>/usd2-c-501" style="color:#ba2325;">USD1.9</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/usd-9-c-415?0814" style="color:#ba2325">USD9.9</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/usd-13-c-464">USD13.9</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/usd-16-c-465">USD16.9</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/usd20-c-170">USD19.9</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/usd30-c-171">USD29.9</a></dd>
                                                    <br>
                                                    
                                                </dl>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="JS_show">
                                    <a href="#">ACTIVIDADES</a>
                                        <div class="nav_list JS_showcon  hide" style="width: 580px; left: -300px;">
                                            <span class="topicon" style="left: 330px;"></span>
                                        <ul class="fix new_list">
                                            <li style="padding-bottom: 0px;">

                                                <dl>
                                                    <dt>DESTACADOS</dt>
                                                    <!--<dd><a href="echo LANGPATH; /freetrial/add">Centro de Prueba Gratuita</a></dd>-->
                                                    <dd><a href="<?php echo LANGPATH; ?>/rate-order-win-100">Calificalo para Ganar $100</a></dd>
													<dd><a href="<?php echo LANGPATH; ?>/activity/flash_sale">FLASH SALE</a></dd>
													<dd><a href="<?php echo LANGPATH; ?>/ready-to-be-shipped">SE ENVIARÁN EN 24 HRS</a></dd>
                                                </dl>
                                            </li>
                                            <li style="padding-bottom: 0px;">
                                                <dl>
                                                    <dt>TENDENCIAS</dt>
                                                    <dd><a href="<?php echo LANGPATH; ?>/k-pop?0904">K Pop Estilo</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/off-shoulder-c-444">Hombros Descubiertos</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/activity/stripes-collection">Rayas Mágicas</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/crochet-lace-c-419">Encaje Croché</a></dd>
                                                    <dd><a href="<?php echo LANGPATH; ?>/vintage-floral-c-421">Sólo Flores</a></dd>
													<dd><a href="<?php echo LANGPATH; ?>/kimonos-c-414?sort=0&limit=1">Estilo Kimono</a></dd>
                                                </dl>
                                            </li>

                                            <li style="padding-bottom: 0px;">
                                                <dl>
                                                    <dt><a href="<?php echo LANGPATH; ?>/lookbook">LOOKBOOK</a></dt>
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
                                                    <dt>MEDIOS SOCIALES</dt>
                                                    <dd class="sns fix">
                                                        <a rel="nofollow" href="http://www.facebook.com/choiescloth" target="_blank" class="sns1"></a>
                                                        <a rel="nofollow" href="http://twitter.com/#!/choiescloth" target="_blank" class="sns2"></a>
                                                        <a rel="nofollow" href="http://thatisstylish.tumblr.com" target="_blank" class="sns3"></a>
                                                        <a rel="nofollow" href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4"></a>
                                                        <a rel="nofollow" href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a>
                                                        <a rel="nofollow" href="http://www.chictopia.com/Choies" target="_blank" class="sns6"></a>
                                                        <a rel="nofollow" href="https://instagram.com/choiesclothing" target="_blank" class="sns7"></a>
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
                                $searchword=DB::select('name')->from('search_hotword')->where('active', '=', 1)->where('type', '=', 1)->where('lang', '=', 'es')->where('site_id', '=', 1)->execute()->get('name');
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
                                <a href="<?php echo LANGPATH; ?>/customer/summary">MI CUENTA</a>
                            <?php else: ?>
                                <a href="<?php echo LANGPATH; ?>/customer/summary">ACCEDER</a>
                            <?php endif; ?>
                            <div class="mybag JS_show">
                                <a href="<?php echo LANGPATH; ?>/cart/view">MI BOLSA<span class="rum cart_count">0</span></a>
                                <div class="mybag_box JS_showcon hide">
                                    <span class="topicon"></span>
                                    <div class="mybag_con">
                                        <h4 class="tit">ARTÍCULOS DE SU BOLSA</h4>
                                        <div class="cart_bag items mtb5"></div>
                                        <div class="cart-all-goods mr20">
                                            <p><span class="bold mr5 cart_count"></span>Artículo<span class="cart_s"></span> en su bolsa</p>
                                             <p class="bold">Total: <span class="cart_amount"></span></p>
                                        </div>
                                        <div class="cart_bag_empty cart-empty-info" style="display:none;">Su cesta de compra está vacía.</div>
                                        <p class="cart_button">
                                            <a href="<?php echo LANGPATH; ?>/cart/view" class="btn30_14_black">VER MI BOLSA</a>
                                            <a href="<?php echo LANGPATH; ?>/cart/checkout" class="btn30_14_red ml20">PAGAR</a>
                                        </p>
                                        <p class="cart_button_empty" style="display:none;"><a href="<?php echo LANGPATH; ?>/cart/view" class="btn40_16_red">VER MI BOLSA</a></p>
                                        <!--<p class="ppexpress mt10"><a href="javascript:void(0)" style="background:none;" onclick="location.href='<?php //echo LANGPATH; ?>/payment/ppec_set';" id="pp_express"><img src="/images/ppec.jpg" alt="Click here to pay via PayPal Express Checkout" style="vertical-align: middle;"></a></p>-->
                                    </div>
                                    <p class="free-shipping free_shipping" style="display:none;">Añadir 1+ artículo marcado "Free Shipping" <br>para disfrutar envío gratis por todo el pedido</p>
                                    <p class="free-shipping sale_words" style="display:none;"></p>
                                </div>
                            </div>
                            <div class="mybag1" id="mybag2">
                                <div class="currentbag mybag_box hide">
                                    <span class="topicon"></span>
                                    <div class="mybag_con">
                                        <h4 class="tit">¡EXITO! ARTÍCULO AÑADIDO A BOLSA</h4>
                                        <div class="bag_items items mtb5">
                                            <li class="fix"></li>
                                            <p><a href="<?php echo LANGPATH; ?>/cart/view" class="view_btn btn40_16_red">VER MI BOLSA</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="currency1 JS_show ">
                                  <span class="lan">Español</span>
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
        <?php
        if (isset($content))
            echo $content;
        ?>

        <?php
        if ($type != 'payment' && $type != 'purchase' && $type != 'cart')
        {
            ?>
            <!-- footer begin -->
            <footer>
                <div class="w_top">
                    <div class="top layout fix">
                        <dl>
                            <dt>MI CUENTA</dt>
                            <dd><a href="<?php echo LANGPATH; ?>/track/track_order">Rastrear Pedido</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/customer/orders">Historial De Pedidos</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/customer/profile">Configuración De La Cuenta</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/customer/points_history">Historial De Punto</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/customer/wishlist">Lista De Artículos Deseados</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/vip-policy">Política VIP</a></dd>
                            <dd><a onclick="return feed_show();">Feedback</a></dd>
                        </dl>
                        <dl>
                            <dt>CENTRO DE AYUDA</dt>
                            <dd><a href="<?php echo LANGPATH; ?>/faqs">FAQ</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/contact-us">Contáctenos</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/payment">Pago</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/coupon-points">Cupónes y Puntos</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/shipping-delivery">Envío Y Entrega</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/returns-exchange">Devolución Y Cambio</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/conditions-of-use">Condiciones de uso</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/how-to-order">Cómo Realizar Un Pedido</a></dd>
                        </dl>
                        <dl>
                            <dt>DESTACADO</dt>
                            <dd><a href="<?php echo LANGPATH; ?>/lookbook">Lookbook</a></dd>
                            <!--<dd><a href=" echo LANGPATH; /freetrial/add">Centro De Prueba Gratuita</a></dd>-->
                            <dd><a href="<?php echo LANGPATH; ?>/activity/flash_sale">Flash Sale</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/wholesale">Vender Al Por Mayor</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/affiliate-program">Programa De Afiliados</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/blogger/programme">Blogger de Moda</a></dd>
                            <dd><a href="<?php echo LANGPATH; ?>/rate-order-win-100" style="color:red;">Calificalo para Ganar $100</a></dd>
                        </dl>
                        <dl>
                            <dt>TODOS LOS SITIOS</dt>
                            <dd class="lang"><a href="<?php echo $request; ?>">Sitio Inglés</a></dd>
                            <dd class="lang"><a href="/es<?php echo $request; ?>">Sitio Español</a></dd>
                            <dd class="lang"><a href="/fr<?php echo $request; ?>">Sitio Francés</a></dd>
                            <dd class="lang"><a href="/de<?php echo $request; ?>">Sitio Alemán</a></dd>
                            <dd class="lang"><a href="/ru<?php echo $request; ?>">Sitio Ruso</a></dd>
                        </dl>
                        <dl class="last">
                            <dt>Encuéntranos en</dt>
                            <dd class="sns fix">
                                <a rel="nofollow" href="http://www.facebook.com/choiescloth" target="_blank" class="sns1"></a>
                                <a rel="nofollow" href="http://twitter.com/#!/choiescloth" target="_blank" class="sns2"></a>
                                <a rel="nofollow" href="http://thatisstylish.tumblr.com" target="_blank" class="sns3"></a>
                                <a rel="nofollow" href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4"></a>
                                <a rel="nofollow" href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a>
                                <a rel="nofollow" href="http://www.chictopia.com/Choies" target="_blank" class="sns6"></a>
                                <a rel="nofollow" href="https://instagram.com/choiesclothing" target="_blank" class="sns7"></a>
                            </dd>
                            <dd class="letter">
                                <form action="" method="post" id="letter_form">
                                    <label>SUSCRIBETE A NUESTROS BOLETINES</label>
                                    <div class="fix">
                                        <input type="text" id="letter_text" class="text fll" value="Dirección de Email" onblur="if(this.value==''){this.value=this.defaultValue;}"  onfocus="if(this.value=='Dirección de Email'){this.value='';};" />
                                        <input type="submit" id="letter_btn" value="PRESENTAR" class="btn fll" />
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
                                            message = message.replace('You are in Now. Thanks', 'Usted está en ahora. Gracias');
                                            message = message.replace('Sorry, email has been used', 'Lo sentimos, el correo electrónico se ha utilizado');
                                            message = message.replace('Please enter a valid email address', 'Proporcione una dirección de Email');
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
                            <a style="color: #ccc;" href="<?php echo LANGPATH; ?>/privacy-security">Privacidad y seguridad</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a style="color: #ccc;" href="<?php echo LANGPATH; ?>/about-us">Sobre Nosotros</a>
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
                            message = message.replace('Your feedback cannot be received', 'Su feedback no puede ser recibido');
                            message = message.replace('Sorry! No more than 5 feedbacks in 24 hours!', '¡Lo sentimos! No más de 5 feedbacks en 24 horas!');
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
                        <div class="fll text1">¡CHOIES QUIERE OÍR TU VOZ!</div>
                        <div class="close_btn3 clsbtn" style="right: 0px;top: 3px;"></div>
                    </div>
                    <div class="clear"></div>
                    <div class="point ml15 mt5">Los que proporcionan evaluaciones significativas pueden obtener <strong class="red">$5 puntos</strong> de recompensa.</div>
                    <div id="tab6">
                        <div id="tab-nav" class="JS_tab5">
                            <ul class="fix">
                                <li class="on">FEEDBACK</li>
                                <li>PREGUNTA?</li>
                            </ul>
                        </div>
                        <div id="tab-con" class="JS_tabcon5">
                            <div>
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
                                            <label for="Dirección de Email:"><span>*</span> Dirección de Email:<span class="errorInfo clear hide">Proporcione una dirección de Email.</span><br/>
                                            </label>
                                            <input type="email" name="email" id="f_email1" class="text text_long" value="" maxlength="340" />
                                        </li>
                                        <li>
                                            <input type="submit" value="PRESENTAR" class="view_btn btn26 btn40 form_btn" style="width: 100px;" />
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
                                                required:"Los campos obligatorios.",
                                                email:"Proporcione una dirección de Email."
                                            },
                                            do_better: {
                                                required: "Los campos obligatorios.",
                                                minlength: "Introduzca por lo menos 5 caracteres."
                                            }
                                        }
                                    });
                                </script>
                            </div>
                            <div class="hide">
                                <form id="problemForm" method="post" action="#" class="form formArea">
                                    <ul>
                                        <li>
                                            <label for="My Suggestion:"><span>*</span> ¿Necesita ayuda? Por favor, describa el problema: <span class="errorInfo clear hide">Los campos obligatorios.</span></label>
                                            <textarea name="comment" id="f_comment" rows="7" class="input textarea"></textarea>
                                        </li>
                                        <li>
                                            <label for="Dirección de Email:"><span>*</span> Dirección de Email:<span class="errorInfo clear hide">Proporcione una dirección de Email.</span><br/>
                                            </label>
                                            <input type="email" name="email1" id="f_email2" class="text text_long" value="" maxlength="340" />
                                        </li>
                                        <li>
                                            <input type="submit" value="PRESENTAR" class="view_btn btn26 btn40 form_btn" style="width: 100px;" />
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
                                                required:"Los campos obligatorios.",
                                                email:"Proporcione una dirección de Email."
                                            },
                                            comment: {
                                                required: "Los campos obligatorios.",
                                                minlength: "Introduzca por lo menos 5 caracteres."
                                            }
                                        }
                                    });
                                </script>
                                <p class="mt10">¿Mas pregunta detallada? Por favor <a href="https://chatserver.comm100.com/chatwindow.aspx?planId=311&siteId=203306" title="contact us" target="_blank">contacte con nosotros</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="feedback_success" style="display:none;">
                <div class="feedback" style="height:200px;">
                    <div class="close_btn3 clsbtn" style="right: 0px;top: 3px;"></div>
                    <div class="success1">
                        <h3>¡Graias!</h3>
                        <p><em>Su Feedback se ha recibido !</em></p>
                    </div>
                    <div class="failed1">
                        <h3>¡lo siento!</h3>
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
                                cart_view = cart_view.replace(/Item:/g, 'Artikel:');
                                cart_view = cart_view.replace(/Size:/g, 'TALLA:');
                                cart_view = cart_view.replace(/Quantity:/g, 'Cantidad:');
                                cart_view = cart_view.replace(/one size/g, 'talla única');
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
                window._fbq.push(['track', 'PixelInitialized', {
        			<?php 
        			if($type == 'product'){
        			?>
        				  content_type: 'product',
        				  content_ids: ['<?php if(isset($fb_sku)) echo $fb_sku; ?>'],
                          product_catalog_id: '1575263496062031'
        			<?php 
        			}
        			?>
        				}]);
            </script>
            <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=454325211368099&amp;ev=PixelInitialized" /></noscript>
            <!-- End FB Website Visitors Code -->
            <!-- HK ScarabQueue statistics Code -->
            <?php 
            if($user_id){
            $email = $user_session['email'];
            ?>
            <script type="text/javascript">ScarabQueue.push(['setEmail', '<?php echo $email; ?>']);</script>
            <?php } ?>
            <script type="text/javascript">ScarabQueue.push(['go']);</script>
            <!-- HK ScarabQueue statistics Code -->
            <img src="track.excelmob.com?add=NHRmmv7KbM"/>
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

    </body>
</html>
