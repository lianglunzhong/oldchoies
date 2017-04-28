<!--<!DOCTYPE html>-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-Strict.dtd">
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<meta name="format-detection" content="telephone=no"/>
	<link type="image/x-icon" rel="shortcut icon" href="/favicon.ico" />
	<link type="text/css" rel="stylesheet" href="/css_mobile/screen.css"/>
	
	<script src="/css_mobile/5127.js"  type="text/javascript"></script>
<!--	<script src="/css_mobile/ga.js" type="text/javascript" ></script>-->
	<script src="/css_mobile/jquery.js"></script>
	<script src="/js/jquery.validate.js" type="text/javascript"></script>
</head>

				
<body data-action="index" class="container">

<header id="primary-header">

	<style type="text/css">
		#img_logo { display:inline-block; background-image: url(/images/mobile/logo.gif); width:138px; height:45px; }
		.fake-search{background-color:#fff;}
	</style>
	
	<div id="logo"><a href="<?php echo LANGPATH; ?>/" ><div id="img_logo" class="cms-image"></div></a></div>
	<nav>
		<ul>
			<li><a href="<?php echo LANGPATH; ?>/" >Home</a></li>	
			<li><a href="<?php echo LANGPATH; ?>/mobilecart/view" id="cart_count">My Bag(<?php $cart = Cart::get(); echo count($cart['products']); ?>)</a></li>
			
		  <?php if ($user_id = Customer::logged_in()){ ?>
			<li><a href="<?php echo LANGPATH; ?>/mobilecustomer/summary">My Account</a></li>
			<li><a href="<?php echo LANGPATH; ?>/mobilecustomer/logout" >Sign Out</a></li>
		  <?php }else{
		  		  $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '/' . Request::instance()->uri();  ?>	
			<li><a href="<?php echo LANGPATH; ?>/mobilecustomer/login?redirect=<?php echo $redirect;?>" >Sign In</a></li>
		  <?php }?>
		</ul>
	</nav>
	
		
		<form method="get" action="/search"  class="searchB">
			<input name="q" type="text" value="Jumper" onblur="if(this.value==''){this.value=this.defaultValue;}"  onfocus="if(this.value=='Jumper'){this.value='';};" class="magnifying-glass" />
			<input type="submit" class="fake-search" value=""/>
		</form>

</header>


	<?php echo $content;?>

			
<footer id="primary-footer">
	<nav>
		<ul>
			<li><a href="<?php echo LANGPATH; ?>/mobile/doc/about-us">About Us</a></li>
			<li><a href="<?php echo LANGPATH; ?>/mobile/doc/contact-us" >Contact Us</a></li>
			<li><a href="<?php echo LANGPATH; ?>/mobile/doc/privacy-security" >Privacy & Security</a></li>
			<li><a href="<?php echo LANGPATH; ?>/mobilecustomer/orders" >Order History</a> | </li>
<!--			<li><a href="<?php echo LANGPATH; ?>/mobile/doc/vip-policy">VIP Policy</a></li>-->
			<li><a href="<?php echo LANGPATH; ?>/mobile/doc/conditions-of-use" >Conditions of Use</a></li>
			<li><a href="<?php echo LANGPATH; ?>/mobile/outmobile">Full Site</a></li>
		</ul>
	</nav>
	<div style="text-align:center;">
	<script src="https://sealserver.trustkeeper.net/compliance/seal_js.php?code=y2cj3BufDhnnkhj5am2daSvaX2I8Ww&style=normal&size=105x54&language=en"></script><noscript><a href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en" target="hATW"><img src="https://sealserver.trustkeeper.net/compliance/seal.php?code=y2cj3BufDhnnkhj5am2daSvaX2I8Ww&style=normal&size=105x54&language=en" border="0" alt="Trusted Commerce"/></a></noscript>
	</div>
	
	<p>Copyright © 2006-2013 choies.com. Nowee E-commerce Co. Ltd All Rights Reserved.</p>
</footer>


<!--<script src="/css_mobile/script.js"></script>-->
<!--<script src="/css_mobile/jquery.foundation.reveal.js"></script>-->
<!--<script src="/css_mobile/jquery.accordion.js"></script>-->
<!--<script src="/css_mobile/jquery.smartbanner.js"></script>-->
<!--<script src="/css_mobile/home.js"></script>-->
        
        <?php echo Site::instance()->get('stat_code'); ?>
        
</body>


</html>

