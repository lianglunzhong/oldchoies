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

        <!-- Facebook Pixel Code CMCM -->
        <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','//connect.facebook.net/en_US/fbevents.js');fbq('init', '553200044828510');
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=553200044828510&ev=Purchase&noscript=1"/></noscript>
        <!-- End Facebook Pixel Code CMCM -->

        <!-- Facebook Pixel Code NJKY -->
        <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','//connect.facebook.net/en_US/fbevents.js');fbq('init', '454325211368099');
        </script>
        <noscript><img height="1" width="1" style="display:none"src="https://www.facebook.com/tr?id=454325211368099&ev=Purchase&noscript=1"/></noscript>
        <!-- End Facebook Pixel Code NJKY -->
        
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
            window._fbq.push(["track", "Purchase", { content_type: 'product', content_ids: [<?php echo $sqid; ?>], product_catalog_id: '516630661844855' }]);

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

         <!-- Facebook Pixel Code -->

        <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','//connect.facebook.net/en_US/fbevents.js');
        fbq('init', '704997696271245');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=704997696271245&ev=PageView&noscript=1"
        /></noscript>

        <!-- End Facebook Pixel Code -->

        <!-- refferalcandy Code -->
        <script type='text/javascript'>
        !function(d,s) {
        var rc = d.location.protocol + "//go.referralcandy.com/purchase/faulqmadf3unlw9vk79xilhp9.js";
        var js = d.createElement(s);
        js.src = rc;
        var fjs = d.getElementsByTagName(s)[0];
        fjs.parentNode.insertBefore(js,fjs);
        }(document,"script");
        </script>
        <!-- End refferalcandy Code -->

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
		$user_session = Session::instance()->get('user');
		$products = Order::instance($order['id'])->products();
		$currency = Site::instance()->currencies($order['currency']);
		?>
			<script>
			var dataLayer = window.dataLayer = window.dataLayer || [];
			dataLayer.push({'userID': '<?php if($user_session['email']){ echo $user_session['email'];}else{ echo "";}?>'});
			</script>
			
	<!--ga获取订单信息 产品信息-->
	<script>
// Send transaction data with a pageview if available
// when the page loads. Otherwise, use an event when the transaction
// data becomes available.
var dataLayer = window.dataLayer = window.dataLayer || [];
dataLayer.push({
  'ecommerce': {
  		'currencyCode': '<?php echo $order['currency'];?>',
    'purchase': {
      'actionField': {
        'id': '<?php echo $order['ordernum'];?>',                    	 // Transaction ID. Required for purchases and refunds.
        'affiliation': 'Choies',
        'revenue': '<?php echo $order['amount'];?>',                     // Total transaction value (incl. tax and shipping)
        'tax':'0',
        'shipping': '<?php echo $order['amount_shipping'];?>',
        'coupon': '<?php echo $order['coupon_code'];?>',

      },
	  'products': [
		<?php foreach($products as $product){
		?>
      {                            // List of productFieldObjects.
        'name': '<?php echo htmlspecialchars(Product::instance($product['product_id'])->get('name'));?>',     // Name or ID is required.
        'id': '<?php echo Product::instance($product['product_id'])->get('sku');?>',
        'price': '<?php echo number_format($product['price']*$currency['rate'],2);?>',
        'brand': 'Choies',
        'category': '<?php echo htmlspecialchars(Catalog::instance(Product::instance($product['product_id'])->default_catalog())->get('name'));?>',
        'variant': '',
        'quantity': <?php echo $product['quantity'];?>,
        'coupon': '<?php echo $order['coupon_code'];?>'                            // Optional fields may be omitted or set to empty string.
       },
	   <?php
	   }
	   ?>
	   ]
    }
  }
});
</script>
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
            <header id="pc-header" class="site-header hidden-xs">
            <div class="n-nav-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-5 col-md-5 col-lg-4">
                                <div class="drop-down JS-show mr10">
                                <?php
                                $currency_now = Site::instance()->currency();
                                ?>
                                    <div class="drop-down-hd">
                                        <?php
                                            echo $currency_now['name'];
                                        ?>
                                        <i class="fa fa-caret-down flr"></i>    
                                    </div>
                                    <ul class="drop-down-list JS-showcon hide" style="display:none;">
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
                            <div class="drop-down JS-show">
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
                                    $lang_list = Kohana::config('sites.lang_list');
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
                                    <ul class="drop-down-list JS-showcon hide" style="display:none;">

                                    <?php
                                    foreach($lang_list as $lang => $path)
                                    {
                                        if ($lang == "Français" || $lang=="Русский")
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
                            <a href="<?php echo LANGPATH; ?>/" title="choies"><img src="/assets/images/2016/logo.png"></a>
                        </div>
                        <div class="col-xs-5 col-md-4 col-md-offset-1 col-lg-4 col-lg-offset-0">
                            <div class="n-search fll">
                                    <?php
                                        $cacheins = Cache::instance('memcache');
                                        $searchword="";
                                        $cache_searchword_key = 'site_searchword_choies' .LANGUAGE;
                                        $cache_searchword_content = $cacheins->get($cache_searchword_key);
                                        if (isset($cache_searchword_content) AND !isset($_GET['cache']))
                                        {
                                            $searchword = $cache_searchword_content;
                                        }
                                        else
                                        {
                                        $searchword=DB::select('name')->from('search_hotword')->where('active', '=', 1)->where('type', '=', 1)->where('lang', '=', LANGUAGE)->where('site_id', '=', 1)->execute()->get('name');
                                        $cacheins->set($cache_searchword_key, $searchword, 3600);
                                        }
                                    ?>
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
                                <div class="mybag-box JS-showcon hide" style="display:none;">
                                    <span class="arrow-up"></span>
                                    <div class="mybag-con">
                                        <p class="title"><strong class="cart_count">0</strong>&nbsp;article<span class="cart_s"></span> dans votre panier</p>
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
                                            <a href="<?php echo LANGPATH;?>/cart/view" class="btn btn-default">VOIR MON PANIER & PAIEMENT</a>
                                            <p class="free-shipping free_shipping" style="display:none;">Ajoutez 1+ Article Marqué "Free Shipping" <br>Profitez De La Livraison Gratuite Sur Votre Commande</p>
                                            <p class="free-shipping sale_words" style="display:none;"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="reg-sin flr">
                                <div id="customer_sign_in" class="out">
                                    <a href="<?php echo LANGPATH; ?>/customer/login">S'INSCRIRE</a>
                                </div>
                                <div id="customer_signed" class="drop-down JS-show hide" style="display: none;">
                                    <div class="drop-down-hd" id="customer_signed">
                                        <span id="username"></span>
                                    </div>
                                    <ul class="drop-down-list JS-showcon hide" style="display: none;">
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/customer/orders">Mes commandes</a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/tracks/track_order">Suivi de Commande</a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/customer/wishlist">Ma Liste d'Envies</a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/customer/profile">Mon profil</a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="<?php echo LANGPATH; ?>/customer/logout">Me Déconnecter</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
<!--                             <li class="mybag" id="mybag1">
    <div class="currentbag mybag-box hide">
        <span class="topicon"></span>
        <div class="mybag-con">
            <h4 class="tit">SUCCÈS! L'ARTICLE EST AJOUTÉ AU PANIER</h4>
            <div class="bag_items items mtb5">
                <ul class="cart_bag">
                    <li></li>
                </ul>
                <p><a href="<?php echo LANGPATH; ?>/cart/view" class="btn btn-primary btn-lg">Voir mon panier</a></p>
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
                                    <li class="JS-show p-hide" style="width:13%">
                                        <a href="<?php echo LANGPATH;?>/daily-new/week2">NOUVEAU</a>
                                        <div class="nav-list JS-showcon hide">
                                            <span class="downicon tpn01"></span>
                                            <div class="nav-box">
                                                <div class="nav-list01 fll">
                                                    <dl class="nav-ul">
                                                        <dt class="title">PRODUITS PAR</dt>
                                                        <dd><a href="<?php echo LANGPATH;?>/daily-new/week2">Cette semaine</a></dd>
                                                        <dd><a href="<?php echo LANGPATH;?>/daily-new/week1">La semaine dernière</a></dd>
                                                        <dd><a href="<?php echo LANGPATH;?>/daily-new/month">Le mois dernier</a></dd>
                                                        <dd><a href="<?php echo LANGPATH;?>/new-presale-c-1012">Prévente</a></dd>
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
                                                    <a href="<?php echo LANGPATH;?>/<?php echo $newindex_banners[0]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[0]['image']; ?>"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>  
                                            </div>
                                        </div>
                                    </li>
                                    <li class="JS-show" style="width:13%">
                                        <a href="<?php echo LANGPATH; ?>/clothing-c-615">VÊTEMENTS</a>
                                        <div class="nav-list JS-showcon hide" style="margin-left:-100%;">
                                            <span class="downicon tpn02"></span>
                                            <div class="nav-box">
                                                <div class="nav-list03 fll">
                                                    <dl class="nav-ul01">
                                                        <dt class="title">PRODUITS PAR CATÉGORIE</a></dt>
                                                            <?php
                                                            $links = array(
                                                                array('Tous les vêtements', 'clothing-c-615'),
                                                                array('Robes', 'dresses-c-92'),
                                                                array('Tops', 'clothing-tops-c-621'),
                                                                array('Manteaux', 'coats-jackets-c-45'),
                                                                array('Pulls & Tricots', 'knitwear-sweaters-c-619'),
                                                                array('Ensemble', 'two-piece-suit-c-177'),
                                                                array('Combinaisons', 'one-pieces-c-626'),                                   
                                                                array('Jeans', 'jeans-c-49'),
                                                                
                                                                array('Pantalons & Leggings', 'pants-c-233'),
                                                                array('Shorts', 'shorts-c-51'),
                                                                array('Jupes', 'skirt-c-99'),
                                                                array('Maillots de bain', 'swimwear-c-628'),
                                                                array('Grande Taille', 'plus-size-c-737'),
                                                                
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
                                                    <a href="<?php echo LANGPATH;?><?php echo $newindex_banners[1]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[1]['image']; ?>"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="JS-show" style="width:13%">
                                        <a href="<?php echo LANGPATH; ?>/shoes-c-53">CHAUSSURES</a>
                                        <div class="nav-list JS-showcon hide" style="margin-left:-200%;">
                                            <span class="downicon tpn03"></span>
                                            <div class="nav-box">
                                                <div class="nav-list03 fll">
                                                    <dl class="nav-ul01">
                                                        <dt class="title">PRODUITS PAR CATÉGORIE</a></dt>
                                                            <?php
                                                            $links = array(
                                                                array('Toutes les chaussures', 'shoes-c-53'),
                                                                array('Chaussure plates', 'flats-c-152'),
                                                                array('Sandales', 'sandals-c-150'),
                                                                array('Platformes', 'platforms-c-151'),
                                                                array('Chaussures à lacets', 'lace-up-shoes-c-1007'),
                                                                array('Talons', 'heels-c-636'),
                                                                array('Bottes', 'boots-c-149'),
                                                                
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
                                                    <a href="<?php echo LANGPATH;?><?php echo $newindex_banners[2]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[2]['image']; ?>"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    
                                    <li class="JS-show" style="width:13%">
                                        <a href="<?php echo LANGPATH; ?>/accessory-c-52">ACCESSORIES</a>
                                        <div class="nav-list JS-showcon hide" style="margin-left:-300%;">
                                            <span class="downicon tpn04"></span>
                                            <div class="nav-box">
                                                <div class="nav-list03 fll">
                                                    <dl class="nav-ul01">
                                                        <dt class="title">PRODUITS PAR CATÉGORIE</a></dt>
                                                            <?php
                                                            $links = array(
                                                                array('Tous les accessoires', 'accessory-c-52'),
                                                                array('Sacs & Portefeuilles', 'bags-c-643'),
                                                                array('Chapeaux', 'hats-caps-c-55'),
                                                                array('Bijoux', 'jewellery-c-638'),
                                                                array('Lunettes de soleil', 'sunglasses-c-58'),
                                                                array('Echarpes', 'scarves-snoods-c-57'),
                                                                array('Gants', 'gloves-c-645'),
                                                                array('Chaussettes & Collants', 'socks-tights-c-54'),
                                                                array('Accessoires pour cheveux', 'hair-accessories-c-67'),
                                                                array('Ceintures', 'belts-c-59'),
                                                                array('Décoration intérieure', 'home-decor-c-795'),
                                                                array('Vernis à ongle', 'nails-c-460'),
                                                                
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
                                                    <a href="<?php echo LANGPATH;?><?php echo $newindex_banners[3]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[3]['image']; ?>"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
<!--                                         <li class="JS-show">
                                   <a href="#">BEAUTÉ</a>
                                   <div class="nav-list JS-showcon hide" style="margin-left:-400%;">
                                       <span class="downicon tpn05"></span>
                                       <div class="nav-box">
                                           <div class="nav-list03 fll">
                                               <dl class="nav-ul01">
                                                   <dd><a href="">Beauté</a></dd>
                                                   <dd><a href="">Cheveux</a></dd>
                                               </dl>
                                           </div>
                                           <div class="nav-list04 fll">
                                                   <?php
                                                   if(array_key_exists(4, $newindex_banners))
                                                   {
                                                   ?>
                                               <a href="<?php echo LANGPATH;?><?php echo $newindex_banners[4]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[4]['image']; ?>"></a>
                                                   <?php
                                                   }
                                                   ?>
                                               </div>
                                               </div>
                                           </div>
                                       </li>  -->                                   
                                    <li class="JS-show p-hide" style="width:22%">
                                        <a href="javascript:void(0)">LA GALAXIE DE CHOIES</a>
                                        <div class="nav-list JS-showcon hide" style="margin-left:-236%;width: 454.5454545%;">
                                            <span class="downicon tpn05"></span>
                                            <div class="nav-box">
                                                <div class="nav-list01 fll">
                                                    <dl class="nav-ul">
                                                          <?php
                                                            $links = array(
                                                                array('Ballerine sport de luxe','ballerina-sportsluxe-edit-c-1006'),
                                                                array('Festival de musique','music-festivals-edit-c-1020'),
                                                                array('Bohème chic','boho-chic-c-1024'),
                                                                array("Style de campus des années 90",'90-s-school-style-c-1022'),
                                                                array("Style minimal des années 90",'90-s-minimal-style-c-1023'),
                                                                array('Jean','denim-style-in-c-719'),
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
                                                    <a href="<?php echo LANGPATH;?><?php echo $newindex_banners[5]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[5]['image']; ?>"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>  
                                            </div>
                                        </div>
                                    </li>
                                    <li class="JS-show" style="width:13%">
                                        <a href="<?php echo LANGPATH; ?>/outlet-c-101" class="sale">Vente</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div id="moblie-header" class="site-header hidden-xs" 
        style="top: 0px;position: fixed; width: 100%; z-index: 999;">           
        </div>     
                <!-- PHONE GAIBAN 2015.10.22 -->
            <nav class="navbar-collapse collapse hidden-sm hidden-md hidden-lg">
                    <!-- Contenedor -->
                    <ul id="accordion" class="accordion">
                        <li>
                            <div class="link">
                                <span>CATÉGORIE</span>
                                <span class="myaccount"><a href="<?php echo LANGPATH;?>/customer/summary">Mon Compte</a></span>
                            </div>
                        </li>
                        <li><div class="link"><span>NOUVEAUTÉS</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Retourner</span></a></li>
                                                   <?php
                                            $newinarr = array(
                                                            array('Cette semaine','week2'),
                                                            array('La semaine dernière','week1'),
                                                            array('Le mois dernier','month'),       
                                                            );

                                                     ?>
                                                     
                                                    <?php foreach ($newinarr as $link):  ?>
                                                    <li>
                                                        <a href="<?php echo LANGPATH;?>/daily-new/<?php echo $link[1]; ?>">Nouveautés: <?php echo $link[0]; ?>
                                                        </a>
                                                    </li>
                                                      <?php endforeach;?>
                                                    <li><a href="<?php echo LANGPATH;?>/new-presale-c-1012">Prévente</a></li>
                            </ul> 
                        </li>
                        <li>
                            <div class="link"><span class="icon-collection">COLLECTION</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Retourner</span></a></li>
                                                    <?php
                                                        $apparels_list = array(
                                                            'Voir tout' => '/clothing-c-615',
                                                            'Grande taille' => '/plus-size-c-737 ',
                                                            'AW 2015' => '/aw-2015-c-739 ',
                                                            'Boutiques' => '/boutiques-c-738 ',
                                                            'Conception de Choies ' => '/choies-design-c-607 ',
                                                        );
                                                        foreach($apparels_list as $name => $link)
                                                        {
                                                     ?>
                                                     <li><a href="<?php echo LANGPATH.$link; ?>"><?php echo $name; ?></a></li>
                                                     <?php }?>
                            </ul>
                        </li>
                        <li>
                            <div class="link"><span class="icon-dresses">ROBES</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Retourner</span></a></li>
                                                    <?php
                                                        $links = array(
                                                                array('Voir tout', 'dresses-c-92'),
                                                                array('Robes Dos Nu', 'backless-dress-c-456'),
                                                                array('Robes Noires', 'black-dresses-c-203'),
                                                                array('Robes Moulants', 'bodycon-dresses-c-211'),
                                                                array('Robes Floraux', 'floral-dresses-c-108'),
                                                                array('Robes Dentelles', 'lace-dresses-c-209'),
                                                                array('Maxi Robes', 'maxi-dresses-c-207'),
                                                                array('Robes Épaules Dénudées', 'off-the-shoulder-dresses-c-504'),
                                                                array('Robes de Soirée', 'party-dresses-c-205'),
                                                                array('Robes Droites', 'shift-dresses-c-724'),
                                                                array('Robes Chemisiers', 'shirt-dresses-c-725'),
                                                                array('Robes Rayures', 'stripe-dresses-c-652'),
                                                                array('Robes Blanches', 'white-dresses-c-204'),
                                                         );
                                                         $hot_dresses = array("black-dresses-c-203","maxi-dresses-c-207","shirt-dresses-c-725","white-dresses-c-204");
                                                         foreach ($links as $link):
                                                    ?>
                                                    <li><a href="<?php echo LANGPATH.'/'.$link[1]; ?>" <?php if(in_array($link[1],$hot_dresses)){ echo 'class="red"'; }?>><?php echo $link[0]; ?></a></li>
                                                    <?php endforeach;?>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-tops">TOPS</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Retourner</span></a></li>
                                                    <li><a href="<?php echo LANGPATH;?>/clothing-tops-c-621">Voir tout</a></li>
                                                    <li><a href="<?php echo LANGPATH;?>/t-shirts-c-245">T-shirts</a></li>
                                                    <li><a href="<?php echo LANGPATH;?>/blouses-shirts-c-616">Blouses & Chemises</a></li>
                                                    <li><a href="<?php echo LANGPATH;?>/bodysuits-c-250">Body</a></li>
                                                    <li><a href="<?php echo LANGPATH;?>/camis-tanks-c-617">Camisoles et Débardeurs</a></li>
                                                    <li><a href="<?php echo LANGPATH;?>/two-piece-suit-c-177">Ensemble coordonné </a></li>
                                                    <li><a class="red" href="<?php echo LANGPATH;?>/crop-tops-bralets-c-244">Tops  Courts& Bralets</a></li>
                                                    <li><a href="<?php echo LANGPATH;?>/dress-tops-c-618">Robes-tops</a></li>
                                                    <li><a href="<?php echo LANGPATH;?>/kimonos-c-414">Kimonos</a></li>
                                                    <li><a href="<?php echo LANGPATH;?>/knitwear-sweaters-c-619">Tricots</a></li>
                                                    <li><a href="<?php echo LANGPATH;?>/clothing-outerwear-c-623">Manteaux</a></li>
                                                    <li><a href="<?php echo LANGPATH;?>/one-pieces-c-626">Une-Pièces</a></li>
                                                    <li><a href="<?php echo LANGPATH;?>/swimwear-c-628">Maillot de Bain</a></li>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-bottoms">BOTTOMS</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Retourner</span></a></li>
                                                    <li><a href="<?php echo LANGPATH;?>/bottoms-c-240">Voir tout</a></li>
                                                    <li><a href="<?php echo LANGPATH;?>/jeans-c-49">Jeans</a></li>
                                                    <li><a href="<?php echo LANGPATH;?>/leggings-c-232">Leggings</a></li>
                                                    <li><a href="<?php echo LANGPATH;?>/pants-c-233">Pantalon</a></li>
                                                    <li><a class="red" href="<?php echo LANGPATH;?>/skirt-c-99">Jupes</a></li>
                                                    <li><a href="<?php echo LANGPATH;?>/shorts-c-51">Short</a></li>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-shoes">CHAUSSURES</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Retourner</span></a></li>
                                                            <?php
                                                            $links = array(
                                                                array('Toutes les chaussures', 'shoes-c-53'),
                                                                array('Chaussure plates', 'flats-c-152'),
                                                                array('Sandales', 'sandals-c-150'),
                                                                array('Platformes', 'platforms-c-151'),
                                                                array('Talons', 'heels-c-636'),
                                                                array('Bottes', 'boots-c-149'),
                                                                
                                                            ); 
                                                            foreach ($links as $link)
                                                            {
                                                                ?>
                                                            <li><a href="<?php echo LANGPATH;?><?php echo $link[1]; ?>"><?php echo $link[0]; ?></a></li>
                                                            <?php }?>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-jewellery">JEWELLERY</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Retourner</span></a></li>
                                                    <?php
                                                        $links = array(
                                                                array('Voir tout', 'jewellery-c-638'),
                                                                array('Bagues', 'rings-c-62'),
                                                                array('Boucles d‘Oreilles', 'earrings-c-63'),
                                                                array('Bracelets', 'bracelets-bangles-c-640'),
                                                                array('Colliers ', 'neck-c-639'),
                                                                array('Bracelets de cheville  ', 'anklets-c-650'),
                                                                array('Harnais de corps', 'body-harness-c-705'),
                                                        );
                                                        $hot=array("purses-c-644","sunglasses-c-58");
                                                        foreach ($links as $link):
                                                    ?>
                                                    <li><a href="<?php echo LANGPATH;?><?php echo $link[1]; ?>" <?php if(in_array($link[1],$hot)){ echo 'class="red"'; }?>><?php echo $link[0]; ?></a></li>
                                                    <?php endforeach;?>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-acc">ACC&SACS</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Retourner</span></a></li>
                                                        <?php
                                                        $links = array(
                                                                array('Voir tout', 'accessories-bags-c-641'),
                                                                array('Sacs', 'bags-c-643'),
                                                                array('Porte-monnais', 'purses-c-644'),
                                                                array('Gants', 'gloves-c-645'),
                                                                array('Chapeaux & Casquettes', 'hats-caps-c-55'),
                                                                array('Masques pour les yeux', 'eye-masks-c-647'),
                                                                array('Echarpes & Foulards', 'scarves-snoods-c-57'),
                                                                array('Chaussettes & Collants', 'socks-tights-c-54'),
                                                                array('Lunettes de soleil', 'sunglasses-c-58'),
                                                                array('Accessoires de cheveux', 'hair-accessories-c-67'),
                                                                array('Rallonges de cheveux', 'hair-extensions-c-646'),
                                                                array('Ceintures', 'belts-c-59'),
                                                                array('Décoration de maison', 'home-decor-c-795'),
                                                                array('Vernis à ongles', 'nails-c-460'),
                                                        );
                                                        $hot=array("purses-c-644","sunglasses-c-58");
                                                        foreach ($links as $link):
                                                    ?>
                                                    <li><a href="<?php echo LANGPATH;?><?php echo $link[1]; ?>" <?php if(in_array($link[1],$hot)){ echo 'class="red"'; }?>><?php echo $link[0]; ?></a></li>
                                                    <?php endforeach;?>
                            </ul>
                        </li>
                        <li>
                            <div class="link"><span><a href="<?php echo LANGPATH;?>/outlet-c-101">VENTE</a></span></div>
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
            <!--　PHONE GAIBAN ENDING 2015.10.22-->
            <div class="clearfix"></div>

                <span class="livechat"></span>
                <?php $domain = Site::instance()->get('domain'); ?>
            </header>
            <?php
            }
            ?>
            <!-- main begin -->
            <br /><br /><br />
            <section id="main">
			<div class="phone-cart-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="step-nav">
                                    <ul class="clearfix">
                                        <li>Passer Commande<em></em><i></i></li>
                                        <li>Payer<em></em><i></i></li>
                                        <li class="current">Réussir<em></em><i></i></li>
                                    </ul>
                                </div>  
                            </div>  
                        </div>
                    </div>
                </div>
                <!-- main-middle begin -->
                <div class="container">
                    <div class="row">
                     <?php echo View::factory(LANGPATH.'/customer/left'); ?>
                        <article class="user col-sm-9 col-xs-12">
                            <h1 class="paysuccess-h">REMERCIEMENT!</h1>
                            <ul class="paysuccess-t">
                                <li>Vous avez complété votre paiement avec succès. </li>
                                <li>Cliquer votre numéro de commande: <a class="success" href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><?php echo $order['ordernum']; ?></a> pour voir plus de détails.</li>
                                <li>Vous recevrez un sommaire des informations de votre commande par é-mail.</li>
                                <li>Si vous avez des questions concernant votre commande,</li>
                                <li> Veuillez <a class="success" href="<?php echo LANGPATH; ?>/contact-us">nous contacter.</a>.</li>
                                <li><a href="<?php echo LANGPATH; ?>/" class="btn btn-primary btn-sm">CONTINUER VOS ACHATS</a></li>
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
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
            <!-- main end -->

            <?php
            if ($type != 'payment' && $type != 'purchase' && $type != 'cart')
            {
            ?>
            <footer>
                <div class="container-fluid footer-signin hidden-xs">
                    <div class="container">
                        <form action="" method="post" id="letter_form">
                            <label class="">RESTER DANS-LE-SAVOIR</label>
                            <div>
                                <input type="text" class="signin-input" id="letter_text" class="text fll" value="Entrez votre adresse email pour recevoir la newsletter" onblur="if(this.value==''){this.value=this.defaultValue;}" onfocus="if(this.value=='Entrez votre adresse email pour recevoir la newsletter'){this.value='';};">
                                <input type="submit" id="letter_btn" value="S'INSCRIRE" class="btn btn-default">
                            </div>
                            <div class="red" id="letter_message" style="margin-left:190px;"></div>
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
                                            message = message.replace('You are in Now. Thanks', 'Vous êtes un membre de CHOIES maintenant, merci!');
                                            message = message.replace('Sorry, email has been used', 'Désolé, email a été utilisé');
                                            message = message.replace('Please enter a valid email address', "Veuillez saisir une adresse e-mail valide");
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
                            <span>RÉSEAU SOCIAL</span>
                            <ul class="footer-sns">
                                <li><a rel="nofollow" href="https://www.facebook.com/choiescloth" target="_blank"  title="facebook">
                                    <i class="fa fa-facebook"></i></a></li>
                                <li><a rel="nofollow" href="https://twitter.com/choiescloth" target="_blank"  title="twitter">
                                    <i class="fa fa-twitter"></i>
                                </a></li>
                                <li><a rel="nofollow" href="https://www.youtube.com/user/choiesclothes" target="_blank"  title="youtube">
                                    <i class="fa fa-youtube-play"></i>
                                </a></li>
                                <li><a rel="nofollow" href="http://style-base.tumblr.com/" target="_blank"  title="tumblr">
                                    <i class="fa fa-tumblr"></i>
                                </a></li>
                                <li><a rel="nofollow" href="https://www.instagram.com/choiesclothing/" target="_blank"  title="instagram">
                                    <i class="fa fa-instagram"></i>
                                </a></li>
                                <li><a rel="nofollow" href="https://www.pinterest.com/choiesfashion/" target="_blank"  title="pinterest">
                                    <i class="fa fa-pinterest"></i>
                                </a></li>
                            </ul>
                        </div> 
                    </div>  
                </div> 

            <div class="container-fluid footer-main hidden-xs">
                <div class="container">
                    <div class="footer-mid">
                        <div class="footer-ship">
                            <ul class="row">
                                <li class="col-xs-3"><a class="shipping-icon" href="<?php echo LANGPATH;?>/shipping-delivery"><span></span>OPTIONS D'EXPÉDITION</a></li>
                                <li class="col-xs-3"><a class="returns-icon" href="<?php echo LANGPATH;?>/returns-exchange"><span></span>RETOURS</a></li>
                                <li class="col-xs-3"><a class="size-icon" href="<?php echo LANGPATH;?>/size-guide"><span></span>GUIDE DES TAILLES</a></li>
                                <li class="col-xs-3"><a class="membership-icon" href="<?php echo LANGPATH;?>/vip-policy"><span></span>ADHÉSION</a></li>
                            </ul>
                        </div>
                        <div class="footer-context">
                            <dl>
                                <dt>À PROPOS DE NOUS</dt>
                                <dd><a href="<?php echo LANGPATH;?>/about-us">Qui nous sommes</a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/affiliate-program">Filiales</a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/blogger/programme">Bloggers</a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/wholesale">Vente en gros</a></dd>
                            </dl>
                            <dl>
                                <dt>AIDE</dt>
                                <dd><a href="<?php echo LANGPATH;?>/contact-us">Contactez-Nous</a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/faqs">FAQs</a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/important-notice">Tableau d'affichage</a></dd>
                            </dl>
                            <dl>
                                <dt>GUIDE D'ACHAT</dt>
                                <dd><a href="<?php echo LANGPATH;?>/payment">Paiements</a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/coupon-points">Coupons</a></dd>
                                <dd><a href="<?php echo LANGPATH;?>/how-to-order">Comment commander</a></dd>
                            </dl>
                            <dl>
                                <dt>Nous acceptons</dt>
                                <dd><img src="/assets/images/2016/card-0517.jpg"></dd>
                            </dl>
                        </div>
                    </div>              
                </div>
            </div>
            <div class="footer-bottom hidden-xs">
                <p>
                    <a href=""><img src="/assets/images/2016/card-N.jpg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;© 2006-2016 CHOIES.COM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo LANGPATH;?>/privacy-security">POLITIQUE DE CONFIDENTIALITÉ</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo LANGPATH;?>/conditions-of-use">CONDITIONS D'UTILISATION</a> 
                </p>                
            </div>

            <div id="comm100-button-311" class="bt-livechat visible-xs-block hidden-sm hidden-md hidden-lg">
                <a href="#" onclick="openLivechat();return false;" id="livechatLink">
                    <img src="<?php echo STATICURL; ?>/assets/images/2016/livechart-1603.png" />
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
                                            <input id="letter_text1" class="text" value="Adresse e-mail" onblur="if(this.value==''){this.value=this.defaultValue;}" onfocus="if(this.value=='Sign up for our emails'){this.value='';};" type="text">
                                            <input id="letter_btn1" value="SOUMETTRE" class="btn btn-primary" type="submit">
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
                                            message = message.replace('You are in Now. Thanks', 'Vous 锚tes ici maintenant. Merci beaucoup!');
                                            message = message.replace('Sorry, email has been used', 'Désolé, email a été utilisé');
                                            message = message.replace('Please enter a valid email address', 'Veuillez saisir une adresse e-mail valide.');
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
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert" style="margin-top:30px;">
                            <dt style="text-transform: capitalize;"><a href="<?php echo LANGPATH; ?>/lookbook" >#Lookbooks</a>
                            </dl>  
                            <dl class="sns">
                                <dt>NOUS CONTACTER</dt>
                                <dd><a rel="nofollow" href="http://www.facebook.com/choiescloth" target="_blank" class="sns1" title="facebook"></a></dd>
                                <dd><a rel="nofollow" href="http://twitter.com/#!/choiescloth" target="_blank" class="sns2" title="twitter"></a></dd>
                                <dd><a rel="nofollow" href="http://style-base.tumblr.com/" target="_blank" class="sns3" title="tumblr"></a></dd>
                                <dd><a rel="nofollow" href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4" title="youtube"></a></dd>
                                <dd><a rel="nofollow" href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a></dd>
                                <!--<dd><a rel="nofollow" href="http://www.chictopia.com/Choies" target="_blank" class="sns6" title="chictopia"></a></dd>-->
                                <dd><a rel="nofollow" href="http://instagram.com/choiesclothing" target="_blank" class="sns7" title="instagram"></a></dd>
                            </dl>    
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <dt style="text-transform: capitalize;"><a href="<?php echo LANGPATH; ?>/customer/summary">Mon Compte&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/tracks/track_order">&nbsp;Suivi de Commande&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/customer/orders">&nbsp;Mes commandes</a></dt>
                            </dl>                 
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <dd><a href="<?php echo LANGPATH; ?>/about-us" style="color:#444;">À propos de nous&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/vip-policy" style="color:#444;">&nbsp;Adhésion&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/contact-us" style="color:#444;">&nbsp;Nous contacter&nbsp;</a></dd>
                            </dl>  
                         
                        </div>
                        <div class="copyright visible-xs-block hidden-sm hidden-md hidden-lg">
                            <p>Copyright © 2006-<?php echo date('Y'); ?> Choies.com </p>
                            <p class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <a href="<?php echo LANGPATH; ?>/conditions-of-use">&nbsp;Conditions Générales d'Utilisation&nbsp;&bull;</a><a href="<?php echo LANGPATH; ?>/privacy-security">&nbsp;Politique de confidentialité</a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
            <div id="comm100-button-311" class="home-right-icons fr-icons hidden-xs">
                <a href="#" onclick="openLivechat();return false;"><span class="live-chat-icon"></span></a>
                <a href="<?php echo LANGPATH;?>/contact-us"><span class="email-us-icon"></span></a>
            </div>
            <div id="gotop" class="hide ">
                <a href="#" class="xs-mobile-top a-fr"></a>
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
                                $("#think1 .failed1 p").html("Entrez une adresse email valide s'il vous plaît.");
                                $("#think1 .success1").hide();
                                $("#wingray3").remove();
                                $(".reveal-modal-bg").fadeOut();
                            }
                            else if(data['success'] == -1)
                            {
                                $("#think1 .failed1").show();
                                $("#think1 .failed1 p").html("Pas plus de 5 commentaires en 24 heures!");
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
                             if(data['success'] == 0)
                            {
                                $("#think1 .failed1").show();
                                $("#think1 .failed1 p").html("Entrez une adresse email valide s'il vous plaît.");
                                $("#think1 .success1").hide();
                                $("#wingray3").remove();
                                $(".reveal-modal-bg").fadeOut();
                            }
                            else if(data['success'] == -1)
                            {
                                $("#think1 .failed1").show();
                                $("#think1 .failed1 p").html("Pas plus de 5 commentaires en 24 heures!");
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
                    <div class="fll text1">CHOIES VEULENT ENTENDRE VOTRE VOIX!</div>
                </div>
                <div class="clearfix"></div>
                <div class="point ml15 mt5">
                    Ceux qui offrent les feedbacks significatifs peuvent obtenir 
                    <strong class="red">$5 points</strong>de récompense.
                </div>
                <div class="feedtab">
                    <ul class="feedtab-nav JS-tab">
                        <li class="current">FEEDBACK</li>
                        <li class="">PROBLÈME?</li>
                    </ul>
                    <div class="feedtab-con JS-tabcon">
                        <div class="bd">
                            <form id="feedbackForm" method="post" action="#" class="form formArea">
                                <ul>
                                    <li>
                                        <label for="My Suggestion:">Choies, c'est ce que j'aime:</label>
                                        <textarea name="what_like" id="what_like" rows="3" class="input textarea"></textarea>
                                    </li>
                                    <li>
                                        <label for="My Suggestion:"><span>*</span> Choies, je pense que vous pouvez faire mieux:  <span class="errorInfo clear hide">Veuillez saisir une adresse e-mail.</span></label>
                                        <textarea name="do_better" id="do_better" rows="5" class="input textarea"></textarea>
                                    </li>
                                    <li>
                                        <label for="Email Address:"><span>*</span> Adresse e-mail:<span class="errorInfo clear hide">Veuillez saisir une adresse e-mail.</span>
                                        </label>
                                        <input type="text" name="email" id="f_email1" class="text text-long" value="" maxlength="340">
                                    </li>
                                    <li>
                                       <input type="submit" class="btn btn-primary btn-lg" value="SOUMETTRE"></li>
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
                                                required:"Fournissez une adresse email s'il vous plaît.",
                                                email:"Entrez une adresse email valide s'il vous plaît."
                                        },              
                                       do_better: {
                                                required: "Ce champ est obligatoire.",
                                                minlength: "Entrez au moins 5 caractères s'il vous plaît."
                                            }
                                    }
                                });
                            </script>
                        </div>
                        <div class="bd hide">
                            <form id="problemForm" method="post" action="#" class="form formArea">
                                <ul>
                                    <li>
                                        <label><span>*</span>  Vous avez besoin d'aide? Veuillez décrire le problème: <span class="errorInfo clear hide">Veuillez écrire quelque chose ici.</span></label>
                                        <textarea name="comment" id="f_comment" rows="7" class="input textarea"></textarea>
                                    </li>
                                    <li>
                                        <label><span>*</span> Adresse E-mail:<span class="errorInfo clear hide">Veuillez saisir une adresse e-mail.</span><br>
                                        </label>
                                        <input type="text" name="email1" id="f_email2" class="text text-long" value="" maxlength="340">
                                    </li>
                                    <li>
                                        <input type="submit" data-reveal-id="myModal9" class="btn btn-primary btn-lg" value="SOUMETTRE"></li>
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
                                                required:"Fournissez une adresse email s'il vous plaît.",
                                                email:"Entrez une adresse email valide s'il vous plaît."
                                            },
                                            comment: {
                                                required: "Ce champ est obligatoire.",
                                                minlength: "Entrez au moins 5 caractères s'il vous plaît."
                                            }
                                        }
                                });
                            </script>
                             <p class="mt10">Des questions plus détaillées? Veuillez <a href="#" onclick="openLivechat();return false;" title="contact us" target="_blank">nous contacter</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="think1" style="display:none">
                <div class="success1">
                            <h3>Merci beaucoup!</h3>
                        <p><em>Votre feed-back a déjà été reçu!</em></p>
                </div>
                <div class="failed1">
                    <h3>Pardon!</h3>
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

        <script>
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
            <?php } ?>
<!-- HK ScarabQueue statistics Code -->
<?php 
    $amount=round($order["amount"]/$order["rate"],4);
    $products = Order::instance($order['id'])->products();
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
            <script type="text/javascript">ScarabQueue.push(['go']);</script>
            <!-- HK ScarabQueue statistics Code -->

            <!-- <script src="//cdn.optimizely.com/js/557241246.js"></script> -->
        </div>
        
    </body>
</html>
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

<!-- <img src="https://gan.doubleclick.net/gan_conversion?advid=K603690&oid=<?php echo $order['ordernum']; ?>&amt=<?php echo $order['amount']; ?>&fxsrc=USD" width=1 height=1> -->

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

<!--begin clixGalore code -->
<img src="https://www.clixGalore.com/AdvTransaction.aspx?AdID=15957&SV=<?php echo round($order['amount'] / $order['rate'], 2); ?>&OID=<?php echo $order['ordernum'];?>" height="0" width="0" border="0">
<!--end clixGalore code -->


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
$allsku=$allskus=$allqty=array();
$allname = array();
$allcataname = array();
foreach ($products as $key => $product)
{
    $sku = Product::instance($product['product_id'])->get('sku');
    $name = Product::instance($product['product_id'])->get('name');
    $current_catalog = Product::instance($product['product_id'])->default_catalog();
    $cataname = Catalog::instance($current_catalog)->get("name");
    $allsku[]="['cartItem', '".$sku."']";
    $allskus[]=$sku;
    $allname[]='"'.$name.'"';
    $allcataname[]='"'.$cataname.'"';
    $allqty[]=$product['quantity'];
}

$sqStr=implode(",", $allsku);
$sqStrs=implode(",", $allskus);
$sqname = implode(",", $allname);
$sqcataname = implode(",", $allcataname);
$sqQty=implode(",", $allqty);
$sqid = implode(",", $allid);


?>
<?php
if(!empty($sqid))
{
?>
<script type="text/javascript">
fbq('track', 'Purchase'),{
    content_name: [<?php echo isset($sqname) ? $sqname : '';?>],
    content_category: [<?php echo isset($sqcataname) ? $sqcataname : '';?>],
    content_ids: [<?php echo isset($sqid) ? $sqid : ''; ?>],
    content_type: 'product',
    value:"<?php echo $order['amount']; ?>",
    currency: "USD"
    };
</script>
<?php
}
?>

            <?php
            $user_id = Customer::logged_in();
            $products = Order::instance($order['id'])->products();
            $user_session = Session::instance()->get('user');
            if(0){
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
        <?php } ?>