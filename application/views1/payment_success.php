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



<script>fbq('track', 'Purchase', {value: '<?php echo $value; ?>', currency: 'USD'});</script>

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

<!-- Facebook Conversion Code for Other Website Conversions - YeahMobi -->
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
window._fbq.push(['track', '6035664498845', {'value':'<?php echo $value; ?>','currency':'USD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6035664498845&amp;cd[value]=<?php echo $value; ?>&amp;cd[currency]=USD&amp;noscript=1" /></noscript>

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
                                    if ($lang=="Русский" || $lang=="English")
                                    {
                                    }else{
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
                            <a href="/" title="choies"><img src="/assets/images/2016/logo.png"></a>
                        </div>
                        <div class="col-xs-5 col-md-4 col-md-offset-1 col-lg-4 col-lg-offset-0">
                            <div class="n-search fll">

                                <form action="/search" method="get" id="search_form" onsubmit="return search(this);">
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
                                    <a class="bag-bg cart_count" href="/cart/view">0</a>
                                </div>
                                <div class="mybag-box JS-showcon hide" style="display:none;">
                                    <span class="arrow-up"></span>
                                    <div class="mybag-con">
                                        <p class="title"><strong class="cart_count">0</strong> ITEM<span class="cart_s"></span> IN MY BAG</p>
                                        <div class="items">
                                            <ul class="cart_bag">
                                                <li>
                                                    <a class="mybag-pic" href="">
                                                        <img src="<?php echo STATICURL;?>/assets/images/3.jpg" alt=""></a>
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
                                            <p> TOTAL:<strong class="cart_amount"> $180.00</strong></p>
                                        </div>
                                        <div class="view-check">
                                            <a href="<?php echo LANGPATH; ?>/cart/view" class="btn btn-default">VIEW BAG & CHECKOUT</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="reg-sin flr">
                                <div id="customer_sign_in" class="out">
                                    <a href="/customer/login">REGISTER</a>
                                    <span>/</span>
                                    <a href="/customer/login">SIGN IN</a>
                                </div>
                                <div id="customer_signed" class="drop-down JS-show hide" style="display: none;">
                                    <div class="drop-down-hd" id="customer_signed">
                                        <span id="username">choieser</span> 
                                    </div>
                                    <ul class="drop-down-list JS-showcon hide" style="display: none;">
                                        <li class="drop-down-option" onclick="'">
                                            <a href="/customer/orders">My Order</a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="/tracks/track_order">Track Order</a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="/customer/wishlist">My Wishlist</a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="/customer/profile">My Profile</a>
                                        </li>
                                        <li class="drop-down-option" onclick="'">
                                            <a href="/customer/logout">Sign Out</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

<!--                             <li class="mybag" id="mybag1">
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
                                        <a href="/daily-new/week2">NEW IN</a>
                                        <div class="nav-list JS-showcon hide">
                                            <span class="downicon tpn01"></span>
                                            <div class="nav-box">
                                                <div class="nav-list01 fll">
                                                    <dl class="nav-ul">
                                                        <dt class="title">SHOP BY</dt>
                                                        <dd><a href="/daily-new/week2">This Week</a></dd>
                                                        <dd><a href="/daily-new/week1">Last Week</a></dd>
                                                        <dd><a href="/daily-new/month">Last Month</a></dd>
                                                        <dd><a href="/new-presale-c-1012">Presale</a></dd>
                                                    </dl>
                                                </div>
                                                    <?php
                                                        $cache_newindex_key = '1site_newindex_choies' .LANGUAGE;
                                                        $cacheins = Cache::instance('memcache');
                                                        $cache_newindex_content = $cacheins->get($cache_newindex_key);
                                                 if (isset($cache_newindex_content) AND !isset($_GET['cache'])){
                                                            $newindex_banners = $cache_newindex_content;
                                                 } else {
                                                           $newindex_banners = DB::select()->from('banners_banner')->where('type', '=', 'newindex')->where('visibility', '=', 1)->where('lang', '=', '')->order_by('position', 'ASC')->execute()->as_array();
                                                           $cacheins->set($cache_newindex_key,$newindex_banners, 3600);
                                                        }

                                                        ?>
                                                <div class="nav-list02 fll">
                                                        <?php
                                                        if(array_key_exists(0, $newindex_banners))
                                                        {
                                                        ?>
                                                    <a href="<?php echo $newindex_banners[0]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[0]['image']; ?>"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>  
                                            </div>
                                        </div>
                                    </li>
                                    <li class="JS-show" style="width:13%">
                                        <a href="/clothing-c-615">CLOTHING</a>
                                        <div class="nav-list JS-showcon hide" style="margin-left:-100%;">
                                            <span class="downicon tpn02"></span>
                                            <div class="nav-box">
                                                <div class="nav-list03 fll">
                                                    <dl class="nav-ul01">
                                                        <dt class="title">SHOP BY CATEGORY</a></dt>
                                                        <dd><a href="/clothing-c-615"> All Clothing</a></dd>                                  
                                                        <dd><a href="/dresses-c-92"> Dresses</a></dd>                                    
                                                        <dd><a href="/clothing-tops-c-621"> Tops</a></dd>
                                                        <dd><a href="/coats-jackets-c-45"> Coats</a></dd>
                                                        <dd><a href="/knitwear-sweaters-c-619"> Sweaters & Knits</a></dd>
                                                        <dd><a href="/two-piece-suit-c-177">Suits & Co-ords</a></dd>
                                                        <dd><a href="/one-pieces-c-626"> Rompers & Jumpsuits</a></dd>
                                                        <dd><a href="/jeans-c-49"> Jeans</a></dd>
                                                        <dd><a href="/pants-c-233"> Pants & Leggings</a></dd>
                                                        <dd><a href="/shorts-c-51"> Shorts</a></dd>
                                                        <dd><a href="/skirt-c-99"> Skirts</a></dd>
                                                        <dd><a href="/swimwear-c-628"> Swimwear & Beachwear</a></dd>
                                                        <dd><a href="/skirt-c-99" style="display:none"> Sleepwear</a></dd>
                                                        <dd><a href="/skirt-c-99" style="display:none"> Clothing Accessories</a></dd>
                                                        <dd><a href="/plus-size-c-737"> Plus Size</a></dd>
                                                    </dl>
                                                </div>
                                                <div class="nav-list04 fll" style="margin:18px 0 0 0">
                                                        <?php
                                                        if(array_key_exists(1, $newindex_banners))
                                                        {
                                                        ?>
                                                    <a href="<?php echo $newindex_banners[1]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[1]['image']; ?>"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="JS-show" style="width:13%">
                                        <a href="/shoes-c-53">SHOES</a>
                                        <div class="nav-list JS-showcon hide" style="margin-left:-200%;">
                                            <span class="downicon tpn03"></span>
                                            <div class="nav-box">
                                                <div class="nav-list03 fll">
                                                    <dl class="nav-ul01">
                                                        <dt class="title">SHOP BY CATEGORY</a></dt>
                                                        <dd><a href="/shoes-c-53"> All Shoes</a></dd>
                                                        <dd><a href="/flats-c-152"> Flats</a></dd>
                                                        <dd><a href="/sandals-c-150"> Sandals</a></dd>
                                                        <dd><a href="/platforms-c-151"> Platforms</a></dd>
                                                        <dd><a href="/lace-up-shoes-c-1007"> Lace Up Shoes</a></dd>
                                                        <dd><a href="/heels-c-636"> Heels</a></dd>
                                                        <dd><a href="/boots-c-149"> Boots</a></dd>
                                                    </dl>
                                                </div>
                                                <div class="nav-list04 fll">
                                                        <?php
                                                        if(array_key_exists(2, $newindex_banners))
                                                        {
                                                        ?>
                                                    <a href="<?php echo $newindex_banners[2]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[2]['image']; ?>"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    
                                    <li class="JS-show" style="width:13%">
                                        <a href="/accessory-c-52">ACCESSORIES</a>
                                        <div class="nav-list JS-showcon hide" style="margin-left:-300%;">
                                            <span class="downicon tpn04"></span>
                                            <div class="nav-box">
                                                <div class="nav-list03 fll">
                                                    <dl class="nav-ul01">
                                                        <dt class="title">SHOP BY CATEGORY</a></dt>
                                                        <dd><a href="/accessory-c-52">All Accessories</a></dd>
                                                        <dd><a href="/bags-c-643">Bags & Wallets</a></dd>
                                                        <dd><a href="/skirt-c-99" style="display:none">Spring Accessories</a></dd>
                                                        <dd><a href="/hats-caps-c-55"> Hats</a></dd>
                                                        <dd><a href="/jewellery-c-638"> Jewelry</a></dd>
                                                        <dd><a href="/sunglasses-c-58"> Sunglasses</a></dd>
                                                        <dd><a href="/scarves-snoods-c-57"> Scarves</a></dd>
                                                        <dd><a href="/gloves-c-645"> Gloves</a></dd>
                                                        <dd><a href="/socks-tights-c-54"> Socks & Tights</a></dd>
                                                        <dd><a href="/hair-accessories-c-67"> Hair Accessories</a></dd>
                                                        <dd><a href="" style="display:none"> iPhones & iPads</a></dd>
                                                        <dd><a href="/belts-c-59"> Belts</a></dd>
                                                        <dd><a href="/home-decor-c-795">Home Decor</a></dd>                                                        
                                                        <dd><a href="/nails-c-460">Nails</a></dd>                        
                                                    </dl>
                                                </div>
                                                <div class="nav-list04 fll">
                                                        <?php
                                                        if(array_key_exists(3, $newindex_banners))
                                                        {
                                                        ?>
                                                    <a href="<?php echo $newindex_banners[3]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[3]['image']; ?>"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
<!--                                         <li class="JS-show">
                                   <a href="#">BEAUTY</a>
                                   <div class="nav-list JS-showcon hide" style="margin-left:-400%;">
                                       <span class="downicon tpn05"></span>
                                       <div class="nav-box">
                                           <div class="nav-list03 fll">
                                               <dl class="nav-ul01">
                                                   <dd><a href=""> Beauty</a></dd>
                                                   <dd><a href=""> Hair</a></dd>
                                               </dl>
                                           </div>
                                           <div class="nav-list04 fll">
                                                   <?php
                                                   if(array_key_exists(4, $newindex_banners))
                                                   {
                                                   ?>
                                               <a href="<?php echo $newindex_banners[4]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[4]['image']; ?>"></a>
                                                   <?php
                                                   }
                                                   ?>
                                               </div>
                                               </div>
                                           </div>
                                       </li>  -->                                   
                                    <li class="JS-show p-hide" style="width:22%">
                                        <a href="javascript:void(0)">THE CHOIES GALAXY</a>
                                        <div class="nav-list JS-showcon hide" style="margin-left:-236%;width: 454.5454545%;">
                                            <span class="downicon tpn06"></span>
                                            <div class="nav-box">
                                                <div class="nav-list01 fll">
                                                    <dl class="nav-ul">
                                                          <?php
                                                            $links = array(
                                                                array('Music Festivals','music-festivals-edit-c-1020'),
                                                                array('Boho Chic','boho-chic-c-1024'),
                                                                array("90's School Style",'90-s-school-style-c-1022'),
                                                                array("90's Minimal Style",'90-s-minimal-style-c-1023'),
                                                                array('Denim','denim-style-in-c-719'),
                                                                array('Classic Stripe Styles','classic-stripe-styles-c-1106'),
                                                                array('Off the Shoulder Styles','off-the-shoulder-styles-c-1125'),
                                                            );
                                                            ?>
                                                            <?php 
                                                            foreach ($links as $link)
                                                            {
                                                                ?>
                                                                <dd><a href="/<?php echo $link[1]; ?>"><?php echo $link[0]; ?></a></dd>
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
                                                    <a href="<?php echo $newindex_banners[5]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[5]['image']; ?>"></a>
                                                        <?php
                                                        }
                                                        ?>
                                                </div>  
                                            </div>
                                        </div>
                                    </li>
                                    <li class="JS-show" style="width:13%">
                                        <a href="/outlet-c-101" class="sale">SALE</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
<!--         <div id="moblie-header" class="site-header hidden-xs" 
style="top: 0px;position: fixed; width: 100%; z-index: 999;">           
</div> -->
            <nav class="navbar-collapse collapse hidden-sm hidden-md hidden-lg">
                    <!-- Contenedor -->
                    <ul id="accordion" class="accordion">
                        <li>
                            <div class="link">
                                <span>CATEGORY</span>
                                <span class="myaccount"><a href="/customer/summary">My Account</a></span>
                            </div>
                        </li>
                        <li><div class="link"><span>NEW IN</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Go Back</span></a></li>
                                <?php
                        $newinarr = array(
                                        array('This Week','week2'),
                                        array('Last Week','week1'),
                                        array('Last Month','month'), 
                                        );
                                ?>
                                 
                                <?php foreach ($newinarr as $link):  ?>
                                <li>
                                    <a href="/daily-new/<?php echo $link[1]; ?>">New In: <?php echo $link[0]; ?>
                                    </a>
                                </li>
                                  <?php endforeach;?>
                                <li><a href="/new-presale-c-1012">Presale</a></li>  
                            </ul> 
                        </li>
                        <li>
                            <div class="link"><span class="icon-collection">COLLECTION</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Go Back</span></a></li>
                                <?php
                                    $apparels_list = array(
                                        'View all' => '/clothing-c-615',
                                        'Plus-size' => '/plus-size-c-737 ',
                                        'AW 2015' => '/aw-2015-c-739 ',
                                        'Boutique' => '/boutiques-c-738 ',
                                        'Choies Design' => '/choies-design-c-607 ',

                                    );
                                    foreach($apparels_list as $name => $link)
                                    {
                                 ?>
                                 <li><a href="<?php echo $link; ?>"><?php echo $name; ?></a></li>
                                 <?php }?>
                            </ul>
                        </li>
                        <li>
                            <div class="link"><span class="icon-dresses">DRESSES</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Go Back</span></a></li>
                                <?php
                                    $links = array(
                                            array('View All', 'dresses-c-92'),
                                            array('Backless Dresses', 'backless-dress-c-456'),
                                            array('Black Dresses', 'black-dresses-c-203'),
                                            array('Bodycon Dresses', 'bodycon-dresses-c-211'),
                                            array('Floral Dresses', 'floral-dresses-c-108'),
                                            array('Lace Dresses', 'lace-dresses-c-209'),
                                            array('Maxi Dresses', 'maxi-dresses-c-207'),
                                            array('Off Shoulder Dresses', 'off-the-shoulder-dresses-c-504'),
                                            array('Party Dresses', 'party-dresses-c-205'),
                                            array('Shift Dresses', 'shift-dresses-c-724'),
                                            array('Shirt Dresses', 'shirt-dresses-c-725'),
                                            array('Stripe Dresses', 'stripe-dresses-c-652'),
                                            array('White Dresses', 'white-dresses-c-204'),
                                     );
                                     $hot_dresses = array("black-dresses-c-203","maxi-dresses-c-207","shirt-dresses-c-725","white-dresses-c-204");
                                     foreach ($links as $link):
                                ?>
                                <li><a href="/<?php echo $link[1]; ?>" <?php if(in_array($link[1],$hot_dresses)){ echo 'class="red"'; }?>><?php echo $link[0]; ?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-tops">TOPS</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Go Back</span></a></li>
                                <li><a href="/clothing-tops-c-621">View All</a></li>
                                <li><a href="/t-shirts-c-245">T-shirts</a></li>
                                <li><a href="/blouses-shirts-c-616">Blouses & Shirts</a></li>
                                <li><a href="/bodysuits-c-250">Bodysuits</a></li>
                                <li><a href="/camis-tanks-c-617">Camis & Tanks</a></li>
                                <li><a href="/two-piece-suit-c-177">CO-ORD Sets</a></li>
                                <li><a class="red" href="/crop-tops-bralets-c-244">Crop Tops & Bralets</a></li>
                                <li><a href="/dress-tops-c-618">Dress-tops</a></li>
                                <li><a href="/kimonos-c-414">Kimonos</a></li>
                                <li><a href="/knitwear-sweaters-c-619">Knitwear</a></li>
                                <li><a href="/clothing-outerwear-c-623">Outerwear</a></li>
                                <li><a href="/one-pieces-c-626">One-pieces</a></li>
                                <li><a href="/swimwear-c-628">Swimwear</a></li>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-bottoms">BOTTOMS</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Go Back</span></a></li>
                                <li><a href="/bottoms-c-240">View All</a></li>
                                <li><a href="/jeans-c-49">Jeans</a></li>
                                <li><a href="/leggings-c-232">Leggings</a></li>
                                <li><a class="red" href="/skirt-c-99">Skirts</a></li>
                                <li><a href="/shorts-c-51">Shorts</a></li>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-shoes">SHOES</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Go Back</span></a></li>
                                <li><a href="/shoes-c-53">View All</a></li>
                                <li><a href="/boots-c-149">Boots</a></li>
                                <li><a href="/sandals-c-150">Sandals</a></li>
                                <li><a class="red" href="/platforms-c-151">Platforms</a></li>
                                <li><a href="/flats-c-152">Flats</a></li>
                                <li><a href="/sneakers-athletic-shoes-c-635">Sneakers & Athletic Shoes</a></li>
                                <li><a href="/heels-c-636">Heels</a></li>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-jewellery">JEWELLERY</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Go Back</span></a></li>
                                <?php
                                    $links = array(
                                            array('View All', 'jewellery-c-638'),
                                            array('Rings', 'rings-c-62'),
                                            array('Earrings', 'earrings-c-63'),
                                            array('Bracelets & Bangles', 'bracelets-bangles-c-640'),
                                            array('Neck', 'neck-c-639'),
                                            array('Anklets', 'anklets-c-650'),
                                            array('Body Harness', 'body-harness-c-705'),
                                    );
                                    $hot=array("purses-c-644","sunglasses-c-58");
                                    foreach ($links as $link):
                                ?>
                                <li><a href="/<?php echo $link[1]; ?>" <?php if(in_array($link[1],$hot)){ echo 'class="red"'; }?>><?php echo $link[0]; ?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </li>
                        <li><div class="link"><span class="icon-acc">ACC&BAGS</span><i class="fa fa-caret-right"></i></div>
                            <ul class="submenu">
                                <li class="back"><a class="back-btn" href="#"><i class="fa fa-caret-left"></i><span>Go Back</span></a></li>
                                <?php
                                    $links = array(
                                            array('View All', 'accessories-bags-c-641'),
                                            array('Bags', 'bags-c-643'),
                                            array('Purses', 'purses-c-644'),
                                            array('Gloves', 'gloves-c-645'),
                                            array('Hats & Caps', 'hats-caps-c-55'),
                                            array('Eye Masks', 'eye-masks-c-647'),
                                            array('Scarves & Snoods', 'scarves-snoods-c-57'),
                                            array('Socks & Tights', 'socks-tights-c-54'),
                                            array('Sunglasses', 'sunglasses-c-58'),
                                            array('Hair Accessories', 'hair-accessories-c-67'),
                                            array('Hair Extensions', 'hair-extensions-c-646'),
                                            array('Belts', 'belts-c-59'),
                                            array('Home Decor', 'home-decor-c-795'),
                                            array('Nails', 'nails-c-460'),
                                    );
                                    $hot=array("purses-c-644","sunglasses-c-58");
                                    foreach ($links as $link):
                                ?>
                                <li><a href="/<?php echo $link[1]; ?>" <?php if(in_array($link[1],$hot)){ echo 'class="red"'; }?>><?php echo $link[0]; ?></a></li>
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
            <!-- Collect the nav links, forms, and other content for toggling -->
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
                                            <a class="logo" href="/" title=""><img src="<?php echo STATICURL;?>/assets/images/2016/logo.png" alt=""></a>
                                        </div>
                                        <div class="col-xs-2" style="padding:0;">
                                                <a class="fa fa-search"></a>
                                                <a href="/cart/view" class="bag-phone-on cart_count"></a>
                                        </div>
                                    </div>
                                    <div class="navbar-search hide">
                                        <form action="/search" method="get" onsubmit="return search1('searchwords');">
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
                <?php $domain = URLSTR; ?>
            </header>
            <?php
            }
            ?>
            <!-- main begin -->
            <br /><br /><br />
            <section id="main">
                <!-- main-middle begin -->
                <div class="phone-cart-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="step-nav">
                                    <ul class="clearfix">
                                        <li>Place Order<em></em><i></i></li>
                                        <li>Pay<em></em><i></i></li>
                                        <li class="current">Succeed<em></em><i></i></li>
                                    </ul>
                                </div>  
                            </div>  
                        </div>
                    </div>
                </div>
                <?php
                if(empty(LANGUAGE))
                {
                    $lists = Kohana::config('/pay/payment_success.en');
                }
                else
                {
                    $lists = Kohana::config('/pay/payment_success.'.LANGUAGE);
                }
                ?>
                <div class="container">
                    <div class="crumbs hidden-xs">
                        <div class="fll"></div>
                    </div>
                    <div class="row">
                        <?php echo View::factory('/customer/left'); ?>
                        <article class="user col-sm-9 col-xs-12">
                            <h1 class="paysuccess-h"><?php echo $lists['title'];?></h1>
                            <ul class="paysuccess-t">
                                <li><?php echo $lists['title1'];?> </li>
                                <li><?php echo $lists['title2'];?>: <a class="success" href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><?php echo $order['ordernum']; ?></a> <?php echo $lists['title3'];?></li>
                                <li><?php echo $lists['title4'];?></li>
                                <li><?php echo $lists['title5'];?></li>
                                <li><?php echo $lists['title6'];?> <a class="success" href="<?php echo LANGPATH; ?>/contact-us"><?php echo $lists['title7'];?></a>.</li>
                                <li><a href="<?php echo LANGPATH; ?>/" class="btn btn-primary btn-sm"><?php echo $lists['title8'];?></a></li>
                                <?php
                                $customer_id = $order['customer_id'];
                                $ppec_status = Customer::instance($customer_id)->get('ppec_status');
                                if($ppec_status == 0)
                                {
                                    echo  $lists['title9'];
                                }
                                ?>
                            </ul>

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
                                </div>
                            </div>
                        </article>


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
                            <label class="">STAY IN THE KNOW</label>
                            <div>
                                <input type="text" class="signin-input" id="letter_text" class="text fll" value="Enter your email address to receive newsletter" onblur="if(this.value==''){this.value=this.defaultValue;}" onfocus="if(this.value=='Enter your email address to receive newsletter'){this.value='';};">
                                <input type="submit" id="letter_btn" value="SIGN UP" class="btn btn-default">
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
                        <div class="footer-s">
                            <span>CHOIES SOCIAL</span>
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
                            </ul>
                        </div>  

                    </div>  
                </div>

            <div class="container-fluid footer-main hidden-xs">
                <div class="container">
                    <div class="footer-mid">
                        <div class="footer-ship">
                            <ul class="row">
                                <li class="col-xs-3"><a class="shipping-icon" href="/shipping-delivery"><span></span>SHIPPING OPTIONS</a></li>
                                <li class="col-xs-3"><a class="returns-icon" href="/returns-exchange"><span></span>RETURNS</a></li>
                                <li class="col-xs-3"><a class="size-icon" href="/size-guide"><span></span>SIZE GUIDE</a></li>
                                <li class="col-xs-3"><a class="membership-icon" href="/vip-policy"><span></span>MEMBERSHIP</a></li>
                            </ul>
                        </div>
                        <div class="footer-context">
                            <dl>
                                <dt>ABOUT US</dt>
                                <dd><a href="/about-us">Who We Are</a></dd>
                                <dd><a href="/affiliate-program">Affiliates</a></dd>
                                <dd><a href="/blogger/programme">Bloggers</a></dd>
                                <dd><a href="/wholesale">Wholesale</a></dd>
                            </dl>
                            <dl>
                                <dt>HELP</dt>
                                <dd><a href="/contact-us">Contact Us</a></dd>
                                <dd><a href="/faqs">FAQs</a></dd>
                                <dd><a href="/important-notice">Notice Board</a></dd>
                            </dl>
                            <dl>
                                <dt>SHOPPING GUIDE</dt>
                                <dd><a href="/payment">Payments</a></dd>
                                <dd><a href="/coupon-points">Coupons</a></dd>
                                <dd><a href="/how-to-order">How to Order</a></dd>
                            </dl>
                            <dl>
                                <dt>WE ACCEPT</dt>
                                <dd><img src="/assets/images/2016/card-0517.jpg"></dd>
                            </dl>
                        </div>
                    </div>              
                </div>
            </div>
            <div class="footer-bottom hidden-xs">
                <p>
                    <a href=""><img src="/assets/images/2016/card-N.jpg"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;© 2006-2016 CHOIES.COM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/privacy-security">PRIVACY POLICY</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/conditions-of-use">TERMS & CONDITIONS</a> 
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
                                            <input id="letter_text1" class="text" value="Sign up for our emails" onblur="if(this.value==''){this.value=this.defaultValue;}" onfocus="if(this.value=='Sign up for our emails'){this.value='';};" type="text">
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
                                                    $("#letter_message1").html(data['message']);
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
                                 <dt style="text-transform: capitalize;"><a href="/blogger/programme">BLOGGER&nbsp;&nbsp;</a><a href="/lookbook">#LOOKBOOKS</a>&nbsp;&nbsp;HERE</dt>
                            </dl>
                            <dl class="sns">
                                <dt>Connect With Us</dt>
                                <dd><a  href="http://www.facebook.com/choiescloth" target="_blank" class="sns1" title="facebook"></a></dd>
                                <dd><a  href="http://twitter.com/#!/choiescloth" target="_blank" class="sns2" title="twitter"></a></dd>
                                <dd><a  href="http://style-base.tumblr.com/" target="_blank" class="sns3" title="tumblr"></a></dd>
                                <dd><a  href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4" title="youtube"></a></dd>
                                <dd><a  href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a></dd>
                                <!--<dd><a  href="http://www.chictopia.com/Choies" target="_blank" class="sns6" title="chictopia"></a></dd>-->
                                <dd><a  href="http://instagram.com/choiesclothing" target="_blank" class="sns7" title="instagram"></a></dd>
                            </dl>
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <dt style="text-transform: capitalize;"><a href="/customer/summary">My Account&nbsp;&bull;</a><a href="/tracks/track_order">&nbsp;Track Order&nbsp;&bull;</a><a href="/customer/orders">&nbsp;Order History</a></dt>
                            </dl>
                            <dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <dd><a href="/about-us" style="color:#444;">About Us&nbsp;&bull;</a><a href="/vip-policy" style="color:#444;">&nbsp;Membership&nbsp;&bull;</a><a href="/contact-us" style="color:#444;">&nbsp;Contact Us&nbsp;</a></dd>
                            </dl>                            
                        </div>
                        <div class="copyright visible-xs-block hidden-sm hidden-md hidden-lg">
                            <p>Copyright © 2006-2016 Choies.com </p>
                            <p class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
                                 <a href="/conditions-of-use">&nbsp;Terms & Conditions&nbsp;&bull;</a><a href="/privacy-security">&nbsp;Privacy Policy</a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
</div>
            <div id="comm100-button-311" class="home-right-icons hidden-xs">
                <a href="#" onclick="openLivechat();return false;"><span class="live-chat-icon"></span></a>
                <a href="/contact-us"><span class="email-us-icon"></span></a>
            </div>
            <div id="gotop" class="hide ">
                <a href="#" class="xs-mobile-top"></a>
            </div>
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
                                $("#think1 .failed1 p").html(data['message']);
                                $("#think1 .success1").hide();
                                $("#wingray3").remove();
                                $(".reveal-modal-bg").fadeOut();
                            }
                            else if(data['success'] == -1)
                            {
                                $("#think1 .failed1").show();
                                $("#think1 .failed1 p").html(data['message']);
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
                                $("#think1 .failed1 p").html(data['message']);
                                $("#think1 .success1").hide();
                                $("#wingray3").remove();
                                $(".reveal-modal-bg").fadeOut();
                            }
                            else if(data['success'] == -1)
                            {
                                $("#think1 .failed1").show();
                                $("#think1 .failed1 p").html(data['message']);
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

<div id="myModal8" class="reveal-modal large feedback" kai="kai">
    
        <a class="close-reveal-modal close-btn3"></a>
        <div id="tijiao">
                <div class="feedback-title">
                    <div class="fll text1">CHOIES WANT TO HEAR YOUR VOICE!</div>
                </div>
                <div class="clearfix"></div>
                <div class="point ml15 mt5">
                    Those who provide significant feedbacks can get 
                    <strong class="red">$5 Points</strong> Reward.
                </div>
                <div class="feedtab">
                    <ul class="feedtab-nav JS-tab1">
                        <li class="current">FEEDBACK</li>
                        <li class="">PROBLEM?</li>
                    </ul>
                    <div class="feedtab-con JS-tabcon1">
                        <div class="bd">
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
                                        <label for="Email Address:"><span>*</span> Email Address:<span class="errorInfo clear hide">Please enter your email.</span>
                                        </label>
                                        <input type="text" name="email" id="f_email1" class="text text-long" value="" maxlength="340">
                                    </li>
                                    <li>
                                        <input type="submit" class="btn btn-primary btn-lg" value="SUBMIT"></li>
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
                                        do_better: {
                                            required:"This field is required.",
                                            minlength: "Please enter at least 5 characters."
                                        }
                                    }
                                });
                            </script>
                        </div>
                        <div class="bd hide">
                            <form id="problemForm" method="post" action="#" class="form formArea">
                                <ul>
                                    <li>
                                        <label><span>*</span> Need help? Please describe the problem: <span class="errorInfo clear hide">Please write something here.</span></label>
                                        <textarea name="comment" id="f_comment" rows="7" class="input textarea"></textarea>
                                    </li>
                                    <li>
                                        <label><span>*</span> Email Address:<span class="errorInfo clear hide">Please enter your email.</span><br>
                                        </label>
                                        <input type="text" name="email1" id="f_email2" class="text text-long" value="" maxlength="340">
                                    </li>
                                    <li>
                                        <input type="submit" data-reveal-id="myModal9" class="btn btn-primary btn-lg" value="SUBMIT"></li>
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
                                        comment: {
                                            required:"This field is required.",
                                            minlength: "Please enter at least 5 characters."
                                        }
                                    }
                                });
                            </script>
                             <p class="mt10">More detailed questions? Please <a href="https://chatserver.comm100.com/chatwindow.aspx?planId=311&amp;siteId=203306" title="contact us" target="_blank">contact us</a>.</p>
                        </div>
                    </div>
                </div>
                </div>
                <div id="think1" style="display:none">
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
            <script type="text/javascript">

            </script>
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
        'coupon'=>$order['coupon_code'],
        )
;
 endforeach; 
// Function to return the JavaScript representation of a TransactionData object.
function getTransactionJs(&$trans) {
  return <<<HTML
ga('ec:setAction', 'purchase',{
  'id': '{$trans['id']}',
  'affiliation': '{$trans['affiliation']}',
  'revenue': '{$trans['revenue']}',
  'shipping': '{$trans['shipping']}',
  'tax': '{$trans['tax']}',
  'currency': '{$trans['currency']}',
  'coupon': '{$trans['coupon']}'
});
HTML;
}

// Function to return the JavaScript representation of an ItemData object.
function getItemJs(&$transId, &$item) {
  return <<<HTML
ga('ec:addProduct',{
  'id': '{$item['sku']}',
  'name': '{$item['name']}',
  'category': '{$item['category']}',
  'brand': 'Choies',
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
ga('require', 'ec');
ga('set','&cu','<?php echo $trans['currency'];?>');

<?php
echo getTransactionJs($trans);

foreach ($items as &$item) {
  echo getItemJs($trans['id'], $item);
}
?>

ga('send', 'pageview');
</script>

            <?php
            $user_id = Customer::logged_in();
            $products = Order::instance($order['id'])->products();
            $user_session = Session::instance()->get('user');
kohana::$log->add('payment/success','ordernum:'.$order['ordernum'].'|customer:'.$user_id);
            if(0){
                        ?>
            <!-- Criteo Code For Pay Success Page -->
        <script type="text/javascript" src="static.criteo.net/js/ld/ld.js" async="true"></script>
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

<?php
$isfrom = 0;
if (Kohana_Cookie::get("ChoiesCookie") == "CJ")
{
    ?>
    <!--begin cj platform code -->
    <iframe height="1" width="1" frameborder="0" scrolling="no" src="https://www.emjcd.com/tags/c?containerTagId=4452&<?php echo $cj_sku; ?>&<?php echo $cj_amt; ?>&<?php echo $cj_qty; ?>&CID=1527669&OID=<?php echo $order['ordernum']; ?>&TYPE=361456&CURRENCY=<?php echo $order['currency']; ?>&Discount=<?php echo $discount; ?>" name="cj_conversion" ></iframe>

<img src="https://shareasale.com/sale.cfm?amount=<?php echo $order['amount']; ?>&tracking=<?php echo $order['ordernum']; ?>&transtype=sale&merchantID=41271&currency=<?php echo $order['currency']; ?>&autovoid=1" width="1" height="1">
    <?php
$isfrom = 1;
}
elseif(strtolower(Kohana_Cookie::get("ChoiesCookie")) == "shareasale")
{
    ?>
<!--begin shareasale platform code-->
<img src="https://shareasale.com/sale.cfm?amount=<?php echo $order['amount']; ?>&tracking=<?php echo $order['ordernum']; ?>&transtype=sale&merchantID=41271&currency=<?php echo $order['currency']; ?>" width="1" height="1">


    <?php
$isfrom = 1;
}
elseif(strtolower(Kohana_Cookie::get("ChoiesCookie")) == 'clickid')
{
	$transaction_id = strtolower(Kohana_Cookie::get("clickid")); 
	$souce_name = 'choies';

?>
<img src="http://global.ymtracking.com/mconv?transaction_id=<?php echo $transaction_id; ?>&event=purchase&order_id=<?php echo $order['id']; ?>&order_amount=<?php echo $order['amount']; ?>&external_id=<?php echo $order['ordernum']; ?>&source=<?php echo $souce_name; ?>" width="1" height="1">
<?php
}

 ?>
     


<?php 
   // ma 
    if(strtolower(Kohana_Cookie::get("ChoiesCookie")=='mopubi')){
        $ecsk = $ecld = $ecpr = $ecqu = ''; $item_sum = $order_sum = 0;
        foreach ($products as $key => $v) {
            $ecsk .= $v['product_id'].'^';
            $ecqu .= $v['quantity'] . '^';
            $ecpr .= $v['price'] . '^';

            //计算价格        
            $product_inf = Product::instance($v['product_id'])->get();
            $orig_price = round($product_inf['price'], 2);
            $price = round(Product::instance($v['product_id'])->price(), 2);
            $ecld .= round($orig_price - $price) . '^';
        }

        $ecst = Order::instance($order['id'])->get('amount');
        $ecsk = substr($ecsk, 0,-1);
        $ecqu = substr($ecqu, 0,-1);
        $ecld = substr($ecld, 0,-1);
        $ecpr = substr($ecpr, 0,-1);
        $ecd  = round($order_sum - $item_sum); 
        $ectx = 0;
        $ect  = Order::instance($order['id'])->get('amount');

        //运费/国家/地区
        $ecsh = Order::instance($order['id'])->get('amount_shipping');
        $ecco = Order::instance($order['id'])->get('shipping_country');
        $ecrg = Order::instance($order['id'])->get('shipping_city');
        $t = Order::instance($order['id'])->get('ordernum');
        $r = Kohana_Cookie::get("rqid");
        $o = Kohana_Cookie::get("oid");
        $p = round($ecst - $ecsh);
        $ecv = Order::instance($order['id'])->get('cc_cvv');
?>

<!-- Affiliate Mopubi Cov Code -->
<iframe src="http://tmoki.com/p.ashx?a=19&e=20&o=<?php echo $o;?>&t=<?php echo $t;?>&p=<?php echo $p;?>&r=<?php echo $r;?>&ecsk=<?php echo $ecsk;?>&ecqu=<?php echo $ecqu;?>&ecpr=<?php echo $ecpr;?>&ecld=<?php echo $ecld;?>&ecst=<?php echo $ect;?>&ecd=<?php echo $ecd;?>&ectx=<?php echo $ectx;?>&ecsh=<?php echo $ecsh;?>&ect=<?php echo $ecst;?>&ecco=<?php echo $ecco;?>&ecrg=<?php echo $ecrg;?>" width="1" height="1" frameborder="0"></iframe>
<!-- end Affiliate Mopubi Cov Code -->
<?php }?>

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

