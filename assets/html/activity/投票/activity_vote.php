<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
	<link rel="stylesheet" href="../../../css/style.css">
	<script src="../js/jquery-1.8.2.min.js"></script>
	<style>
	.vote-list .title {
  font-size: 12px; }
  .vote-list .title input {
    margin: 0px; }

.vote-bottom {
  background-color: #fafafa;
  *zoom: 1;
  margin: 30px 0  0;
  padding-bottom: 40px; }
  .vote-bottom:before, .vote-bottom:after {
    content: "";
    display: table; }
  .vote-bottom:after {
    clear: both; }
  .vote-bottom .vote-textarea span {
    font-size: 16px;
    margin: 10px 0;
    display: block;
    font-weight: bold; }
    .vote-bottom .vote-textarea span input {
      margin-right: 10px; }
  .vote-bottom .vote-sub {
    text-align: center;
    font-size: 16px;
    line-height: 24px;
    font-weight: bold;
    margin-top: 20px; }
	</style>
</head>
<body>
	<div class="page">
		<header class="site-header">
            <div class="top-ad JS-popwincon" style="width:100%;background-color:#f0f0f0;">
                <a class="JS-close1 close-btn3" style="top:0;right:5px;z-index:5;"></a>
            	<div class="container">
					<div class="row">
						<div class="col-sm-12 hidden-xs">
                        <a href="#"><img src="../images/top-ad.jpg"></a>
                        </div>
                        <div class="col-xs-12 hidden-lg hidden-md hidden-sm">
                        <a href="#"><img src="../images/top-ad-phone.jpg"></a>
                        </div>
                  </div>
                </div>           
            </div>
			<div class="top-shortcut">
				<div class="container">
					<div class="row">
						<div class="col-sm-2 col-md-1">
							<div class="drop-down JS-show">
								<div class="drop-down-hd">
									<a href="#" class="icon-flag icon-usd"></a> 
									<i class="fa fa-caret-down"></i>
									<span>$USD</span>
								</div>
								<ul class="drop-down-list JS-showcon hide" style="display:none; width:150px;">
									<li class="drop-down-option">
										<a class="icon-flag icon-usd" href="">US Dollar</a>
									</li>
									<li class="drop-down-option">
										<a class="icon-flag icon-gbp" href="">Pound Sterling</a>
									</li>
									<li class="drop-down-option">
										<a class="icon-flag icon-eur" href="">Euro</a>
									</li>
									<li class="drop-down-option">
										<a class="icon-flag icon-nok" href="">Norwegian Krone</a>
									</li>
									<li class="drop-down-option">
										<a class="icon-flag icon-cad" href="">Canadian Dollar</a>
									</li>
									<li class="drop-down-option">
										<a class="icon-flag icon-aud" href="">Australian Dollar</a>
									</li>
									<li class="drop-down-option">
										<a class="icon-flag icon-chf" href="">Switzerland Francs</a>
									</li>
									<li class="drop-down-option">
										<a class="icon-flag icon-sek" href="">Swedish Krona</a>
									</li>
									<li class="drop-down-option">
										<a class="icon-flag icon-pln" href="">Polish Zloty</a>
									</li>
									<li class="drop-down-option">
										<a class="icon-flag icon-mxn" href="">Mexican Peso</a>
									</li>
									<li class="drop-down-option">
										<a class="icon-flag icon-dkk" href="">Danish Krona</a>
									</li>
									<li class="drop-down-option">
										<a class="icon-flag icon-sar" href="">Saudi Arabian Riyal</a>
									</li>
									<li class="drop-down-option">
										<a class="icon-flag icon-jpy" href="">Japanese Yen</a>
									</li>
									<li class="drop-down-option">
										<a class="icon-flag icon-hkd" href="">Hongkong Dollar</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-sm-3 col-md-5">
							<div class="menu-language">
								<ul class="lang">
									<li>
										<a href="/">English</a>
									</li>
									<li>
										<a href="/es/">Español</a>
									</li>
									<li>
										<a href="/de/">Deutsch</a>
									</li>
									<li>
										<a href="/fr/">Français</a>
									</li>
									<li>
										<a href="/ru/">Русский</a>
									</li>
								</ul>
							</div>							
							<div class="drop-down select-language JS-show">
								<div class="drop-down-hd">
									<span>English</span>
									<i class="fa fa-caret-down"></i>
								</div>
								<div class="JS-showcon hide" style="display:none; ">
									<dl class="drop-down-list " style="width:150%;">
										<dd class="drop-down-option">
											<a href="">English</a>
										</dd>
										<dd class="drop-down-option">
											<a href="">Español</a>
										</dd>
										<dd class="drop-down-option">
											<a href="">Deutsch</a>
										</dd>
										<dd class="drop-down-option">
											<a href="">Français</a>
										</dd>
									</dl>
								</div>
							</div>
						</div>
						<div class="col-sm-7 col-md-6">
							<ul class="user-list">
								<li class="help">
									<a href="/faqs">Help</a>
								</li>
								<li class="help">
									<a href="/faqs">Sign In</a>
								</li>
								<li class="drop-down JS-show">
									<div class="drop-down-hd">
										
										<span>MY ACCOUNT</span>
									</div>
									<dl class="drop-down-list JS-showcon hide" style="display:none;">
										<dd class="drop-down-option">
											<a href="/customer/orders">my order</a>
										</dd>
										<dd class="drop-down-option">
											<a href="/track/track_order">track order</a>
										</dd>
										<dd class="drop-down-option">
											<a href="/customer/points_history">my point</a>
										</dd>
										<dd class="drop-down-option">
											<a href="/customer/profile">my profile</a>
										</dd>
									</dl>
								</li>
								<li class="mybag drop-down JS-show">
									<div class="drop-down-hd">
										<a class="bag-title" href="">MY BAG</a>
										<a href="#" class="rum">0</a>
									</div>
									
									<div class="mybag-box JS-showcon hide" style="display:none;">
										<span class="topicon" style="right: 23px;"></span>
										<div class="mybag-con">
											<h4 class="tit">MY SHOPPING BAG</h4>
											<div class="items">
												<ul>
													<li>
														<a class="mybag-pic" href="">
															<img src="../images/3.jpg" alt=""></a>
														<div class="mybag-info">
															<a class="mybag-info-name" href="">Black PU High Waist Pleat Skirt</a>
															<span>
																Price: $47.99 <em class="red">10%off</em>
															</span>
															<span>Size: M</span>
															<span>Quantity: 1</span>
														</div>
														<span class="cart-delete"></span>
													</li>
													<li>
														<a class="mybag-pic" href="">
															<img src="../images/3.jpg" alt=""></a>
														<div class="mybag-info">
															<a class="mybag-info-name" href="">Black PU High Waist Pleat Skirt</a>
															<span>
																Price: $47.99 <em class="red">10%off</em>
															</span>
															<span>Size: M</span>
															<span>Quantity: 1</span>
														</div>
														<span class="cart-delete"></span>
													</li>
												</ul>
											</div>
											<div class="cart-all-goods">
												<p> <strong>2</strong>
													items in your bag
												</p> <strong>Total: $180.00</strong>
											</div>
											<p>
												<a href="#" class="btn btn-default btn-sm mr10 mb10">VIEW BAG</a>
												<a href="#" class="btn btn-primary btn-sm">PAY NOW</a>
											</p>
										</div>
										<p class="free-shipping">
											Add1+ Item Marked "Free Shipping"
											<br>Enjoy Free Shipping Entire Order</p>
									</div>
									<!--<div class="mybag-box JS-showcon hide" style="display:none;">
										<span class="topicon" style="right: 23px;"></span>
										<div class="mybag-con">
											<h4 class="tit">MY SHOPPING BAG</h4>
											<p>Your shopping bag is empty!</p>
											<p>
												<a href="#" class="btn btn-primary btn-lg">VIEW MY BAG</a>
											</p>
										</div>
									</div>-->
								</li>
							</ul>
							<div id="comm100-button-311" class="tp-livechat">
								<a href="#" onclick="Comm100API.open_chat_window(event, 311);">
									<img id="comm100-button-311img" src="https://chatserver.comm100.com/DBResource/DBImage.ashx?imgId=178&amp;type=2&amp;siteId=203306" style="border:none;" alt=""></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="nav-wrapper">
				<div class="container">
					<div class="row">
						<div class="col-sm-2 col-md-2">
							<a class="logo" href="" title=""></a>
						</div>
						<div class="col-sm-8 col-md-8">
							<nav id="nav1" class="nav">
								<ul>
									<li class="JS-show p-hide">
										<a href="#">NEW IN</a>
										<div class="nav-list JS-showcon hide" style="width:190px;">
											<span class="topicon tpn01"></span>
											<ul>
												<li>
													<dl>
														<dt>
															<a class="newin" href="#">22 Oct.,2014</a>
														</dt>
														<dt>
															<a class="newin" href="#">21 Oct.,2014</a>
														</dt>
														<dt>
															<a class="newin" href="#">20 Oct.,2014</a>
														</dt>
														<dt>
															<a class="newin" href="#">19 Oct.,2014</a>
														</dt>
														<dt>
															<a class="newin" class="newin" href="#">18 Oct.,2014</a>
														</dt>
														<dt>
															<a class="newin" href="#">17 Oct.,2014</a>
														</dt>
														<dt>
															<a class="newin" href="#">16 Oct.,2014</a>
														</dt>
														<dt>
															<a class="newin" href="#">15 Oct.,2014</a>
														</dt>
														<dt>
															<a class="newin" href="#">14 Oct.,2014</a>
														</dt>
														<dt>
															<a class="newin" href="#">13 Oct.,2014</a>
														</dt>
													</dl>
												</li>
											</ul>
										</div>
									</li>
									<li class="JS-show">
										<a href="#">CLOTHING</a>
										<div class="nav-list JS-showcon hide op-w" style="width:700px;">
											<span class="topicon tpn02"></span>
											<ul>
												<li>
													<dl>
														<dt>
															<a href="#">DRESSES</a>
														</dt>
														<dd>
															<a href="#">T-shirts</a>
														</dd>
														<dd>
															<a class="red" href="#">Coats &amp; Jackets</a>
														</dd>
														<dd>
															<a href="#">Shirts &amp; Blouses</a>
														</dd>
														<dd>
															<a class="red" href="#">Unreal Fur</a>
														</dd>
														<dd>
															<a href="#">Two-piece Suits</a>
														</dd>
														<dd>
															<a href="#">Suits &amp; Blazers</a>
														</dd>
														<dd>
															<a class="red" href="#">Jumpers &amp; Cardigans</a>
														</dd>
														<dd>
															<a href="#">Jumpsuits &amp; Playsuits</a>
														</dd>
													</dl>
													<dl>
														<dt>
															<a href="#">TOPS</a>
														</dt>
														<dd>
															<a href="#">T-shirts</a>
														</dd>
														<dd>
															<a class="red" href="#">Coats &amp; Jackets</a>
														</dd>
														<dd>
															<a href="#">Shirts &amp; Blouses</a>
														</dd>
														<dd>
															<a class="red" href="#">Unreal Fur</a>
														</dd>
														<dd>
															<a href="#">Two-piece Suits</a>
														</dd>
														<dd>
															<a href="#">Suits &amp; Blazers</a>
														</dd>
													</dl>
													<dl>
														<dt>
															<a href="#">Swimwear</a>
														</dt>
														<dt>
															<a href="#">Two-piece suits</a>
														</dd>
														<dt>
															<a href="#">Knitwear & Sweaters</a>
														</dd>
														<dd>
															<a class="red" href="#">Skirts</a>
														</dd>
														<dd>
															<a href="#">Leggings</a>
														</dd>
														<dd>
															<a href="#">Pants</a>
														</dd>
													</dl>
												</li>
												<li>
													<dl>
														<dt>
															<a href="#">One-Pieces</a>
														</dt>
														<dd>
															<a class="red" href="#">Rompers & Playsuits</a>
														</dd>
														<dd>
															<a href="#">Jumpsuits</a>
														</dd>
														<dd>
															<a href="#">Overalls</a>
														</dd>
														<dt>
															<a href="#">Outerwear</a>
														</dt>
														<dd>
															<a class="red" href="#">Blazers</a>
														</dd>
														<dd>
															<a href="#">Blazers</a>
														</dd>
														<dd>
															<a class="red" href="#">Coats & Jackets</a>
														</dd>
														<dd>
															<a href="#">Waistcoats</a>
														</dd>
														<dt>
															<a href="#">Skirts</a>
														</dt>
														<dt>
															<a href="#">Pants</a>
														</dt>
														<dt>
															<a href="#">Jeans</a>
														</dt>
														<dt>
															<a class="red" href="#">Leggings</a>
														</dt>
														<dt>
															<a href="#">Shorts</a>
														</dt>
														<dt>
															<a href="#">Skorts</a>
														</dt>
													</dl>
													<dl>
														<dt>
															<a href="#">Menswear</a>
														</dt>
														<dd>
															<a href="#">Men's T-Shirts & Tanks</a>
														</dd>
														<dd>
															<a href="#">Men's Shirts</a>
														</dd>
														<dd>
															<a href="#">Men's Hoodies & Sweatshirts</a>
														</dd>
														<dd>
															<a href="#">Men's Jumpers & Cardigans</a>
														</dd>
														<dd>
															<a href="#">Men's Jackets & Coats</a>
														</dd>
														<dd>
															<a href="#">Men's Pants & Jeans</a>
														</dd>
														<dd>
															<a href="#">Men's Shorts</a>
														</dd>
													</dl>
												</li>
												<li>
													<dl>
														<dt>
															<a href="#">NEW IN</a>
														</dt>
														<dd>
															<a href="#"></a>
														</dd>
													</dl>
													<dl>
														<dt>
															<a href="#">Top Sellers</a>
														</dt>
														<dd>
															<a href="#"></a>
														</dd>
													</dl>
													<dl>
														<dt>
															<a href="#">SALE</a>
														</dt>
														<dd>
															<a href="#"></a>
														</dd>
														<dd>
															<a href="#"></a>
														</dd>
													</dl>
													<dl>
														<dt>
															<a href="#">FLASH SALE</a>
														</dt>
														<dd>
															<a href="#"></a>
														</dd>
													</dl>
													<dl>
														<a href="#">
															<img src="../images/banner10.jpg"></a>
													</dl>
												</li>
												<li class="last">
													<dl>
														<dt>
															<a href="#">LOOKBOOKS &amp; GUIDES</a>
														</dt>
														<dl>
															<a href="#">
																<img src="../images/banner11.jpg" width="190px"></a>
														</dl>
													</dl>
												</li>
											</ul>
										</div>
									</li>
									<li class="JS-show">
										<a href="#">SHOES</a>
										<div class="nav-list JS-showcon hide" style="width:190px;">
											<span class="topicon tpn03"></span>
											<ul>
												<li style="width: 140px;">
													<dl>
														<dt>
															<a href="#">NEW IN</a>
														</dt>
														<dt>
															<a href="#">Boots</a>
														</dt>
														<dt>
															<a href="#">Sandals</a>
														</dt>
														<dt>
															<a href="#">Platforms</a>
														</dt>
														<dt>
															<a href="#">Flats</a>
														</dt>
														<dt>
															<a href="#">Heeled Shoes</a>
														</dt>
														<dt>
															<a href="#">Sneakers</a>
														</dt>
														<dt>
															<a href="#">Loafers</a>
														</dt>
														<dt>
															<a href="#">Pumps</a>
														</dt>
													</dl>
												</li>
											</ul>
										</div>
									</li>
									<li class="JS-show">
										<a href="#">ACCESSORIES</a>
										<div class="nav-list JS-showcon hide" style="width: 360px;">
											<span class="topicon tpn04"></span>
											<ul>
												<li>
													<dl>
														<dt>
															<a href="#">NEW IN</a>
														</dt>
														<dt>
															<a href="#">Socks &amp; Tights</a>
														</dt>
														<dt>
															<a href="#">Hats &amp; Caps</a>
														</dt>
														<dt>
															<a href="#">Bags &amp; Purses</a>
														</dt>
														<dt>
															<a href="#">Scarves &amp; Snoods</a>
														</dt>
														<dt>
															<a href="#">Sunglasses</a>
														</dt>
														<dt>
															<a href="#">Belts</a>
														</dt>
														<dt>
															<a href="#">Necklaces</a>
														</dt>
														<dt>
															<a href="#">Rings</a>
														</dt>
														<dt>
															<a href="#">Earrings</a>
														</dt>
														<dt>
															<a href="#">Bracelets</a>
														</dt>
														<dt>
															<a href="#">Watches</a>
														</dt>
													</dl>
												</li>
												<li>
													<dl>
														<dt>
															<a href="#">Headdress</a>
														</dt>
														<dt>
															<a href="#">Wigs</a>
														</dt>
														<dt>
															<a href="#">MAKE UP</a>
														</dt>
														<dt>
															<a href="#">Nails</a>
														</dt>
													</dl>
												</li>
											</ul>
										</div>
									</li>
									<li class="JS-show">
										<a href="#" class="sale">SALE</a>
										<div class="nav-list JS-showcon hide" style="right:0; width: 360px;">
											<span class="topicon tpn05"></span>
											<ul>
												<li>
													<dl>
														<dt>BY PRICE</dt>
														<dd>
															<a class="red" href="#">USD9.9</a>
														</dd>
														<dd>
															<a href="#">USD19.9</a>
														</dd>
														<dd>
															<a href="#">USD29.9</a>
														</dd>
														<dd>
															<a href="#">USD39.9</a>
														</dd>
														<br>
														<dt>BY DEPARTMENT</dt>
														<dd>
															<a href="#">Outlet  Dresses</a>
														</dd>
														<dd>
															<a href="#">Outlet Tops</a>
														</dd>
														<dd>
															<a href="#">Outlet Bottoms</a>
														</dd>
														<dd>
															<a href="#">Outlet Tights&amp;Leggings</a>
														</dd>
														<dd>
															<a href="#">Outlet Accessories</a>
														</dd>
														<br></dl>
												</li>
											</ul>
										</div>
									</li>
									<li class="JS-show p-hide">
										<a href="#">ACTIVITIES</a>
										<div class="nav-list JS-showcon hide" style="right:0; width:530px;">
											<span class="topicon tpn06"></span>
											<ul>
												<li>
													<dl>
														<dt>TRENDS</dt>
														<dd>
															<a href="#">Skirt Looks</a>
														</dd>
														<dd>
															<a href="#">Palm Tree Print</a>
														</dd>
														<dd>
															<a href="#">K POP Styles</a>
														</dd>
														<dd>
															<a href="#">Off Shoulder</a>
														</dd>
														<dd>
															<a href="#">Magical Stripes</a>
														</dd>
														<dd>
															<a href="#">Crochet Lace</a>
														</dd>
														<dd>
															<a href="#">Lace Panel</a>
														</dd>
														<dd>
															<a href="#">Only Florals</a>
														</dd>
													</dl>
												</li>
												<li>
													<dl>
														<dt>HOT PIECES</dt>
														<dd>
															<a href="#">Classic White Shirt</a>
														</dd>
														<dd>
															<a href="#">Kimono Style</a>
														</dd>
													</dl>
												</li>
												<li>
													<dl>
														<dt>
															<a href="#">LOOKBOOK</a>
														</dt>
													</dl>
													<dl>
														<dt>
															<a href="#">
																<img src="../images/lookbook.jpg"></a>
														</dt>
													</dl>
												</li>
												<li style="width:318px">
													<dl>
														<dt>SOCIAL &amp; MEDIA</dt>
														<dd class="sns">
															<a rel="nofollow" href="#" target="_blank" class="sns1"></a>
															<a rel="nofollow" href="#" target="_blank" class="sns2"></a>
															<a rel="nofollow" href="#" target="_blank" class="sns3"></a>
															<a rel="nofollow" href="#" target="_blank" class="sns4"></a>
															<a rel="nofollow" href="#" target="_blank" class="sns5"></a>
															<a rel="nofollow" href="#" target="_blank" class="sns6"></a>
															<a rel="nofollow" href="#" target="_blank" class="sns7"></a>
															<a rel="nofollow" href="#" target="_blank" class="sns8"></a>
															<a rel="nofollow" href="#" target="_blank" class="sns9"></a>
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
								<form action="/search" method="get" id="search_form" onsubmit="return search(this);">
									<ul>
										<li>
											<input id="boss" name="searchwords" value="sweatshirt" class="search-text text" onblur="if(this.value==''){this.value=this.defaultValue;}" onfocus="if(this.value=='sweatshirt'){this.value='';};" type="search">
											<input value="" class="search-btn" type="submit"></li>
									</ul>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="scroll-nav-wrapper" style="display:none;">
				<div class="container">
					<div class="row">
						<div class="col-sm-1">
							<a href="#" class="home nav-home"><i class="fa fa-home"></i></a>
						</div>
						<div class="col-sm-8">
							<nav id="nav2" class="nav"></nav>
						</div>
						<div  class="col-sm-3">

							<div class="mybag drop-down JS-show"></div>
							<div class="search"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="phone-nav-wrapper">
				<div class="container">
					<div class="row">
						<div id="phone-navbar" class="col-sm-12">
							<a class="logo" href="" title=""></a>
							<div class="mybag">
								<a href="#" class="rum">0</a>
							</div>
							<a href="" class="fa fa-user"></a>
						</div>
					</div>
				</div>
			</div>
			<div class="phone-navbar">
				<div class="container">
					<div class="row">
						<div>
							<div class="search-box">
								<input type="search" class="form-control" style="padding-right:30px">
								<a href="" class="fa fa-search"></a>
							</div>
							<nav class="navbar navbar-default" role="navigation">
								<div class="container-fluid">
									<!-- Toggle get grouped for better mobile display -->
									<div class="navbar-header">
										<button type="button" class="navbar-toggle">
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
										</button>
									</div>

									<!-- Collect the nav links, forms, and other content for toggling -->
									<nav class="navbar-collapse collapse">
										<!-- Contenedor -->
										<ul id="accordion" class="accordion">
											<li>
												<div class="link">NEW IN<i class="fa fa-caret-down"></i></div>
												<ul class="submenu">
													<li><a href="#">Photoshop</a></li>
													<li><a href="#">HTML</a></li>
													<li><a href="#">CSS</a></li>
													<li><a href="#">Maquetacion web</a></li>
												</ul>
											</li>
											<li>
												<div class="link">CLOTHING<i class="fa fa-caret-down"></i></div>
												<ul class="submenu">
													<li><a href="#">Javascript</a></li>
													<li><a href="#">jQuery</a></li>
													<li><a href="#">Frameworks javascript</a></li>
												</ul>
											</li>
											<li>
												<div class="link">SHOES<i class="fa fa-caret-down"></i></div>
												<ul class="submenu">
													<li><a href="#">Tablets</a></li>
													<li><a href="#">Dispositivos mobiles</a></li>
													<li><a href="#">Medios de escritorio</a></li>
													<li><a href="#">Otros dispositivos</a></li>
												</ul>
											</li>
											<li><div class="link">JEWELLERY<i class="fa fa-caret-down"></i></div>
												<ul class="submenu">
													<li><a href="#">Google</a></li>
													<li><a href="#">Bing</a></li>
													<li><a href="#">Yahoo</a></li>
													<li><a href="#">Otros buscadores</a></li>
												</ul>
											</li>
											<li><div class="link">ACCESSORIES & BAGS<i class="fa fa-caret-down"></i></div>
												<ul class="submenu">
													<li><a href="#">Google</a></li>
													<li><a href="#">Bing</a></li>
													<li><a href="#">Yahoo</a></li>
													<li><a href="#">Otros buscadores</a></li>
												</ul>
											</li>
											<li><div class="link"><a href="">SALE</a></div></li>
											<li><div class="link"><a href="">FLASH SALE</a></div></li>
											<li><b class="link"><a href="">TOP SELLER</a></b></li>
										</ul>
									</nav>
								</div>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</header>
		<div class="site-content">
			<div class="main-container clearfix">
				<div class="container">
					<div class="row">
						<a href=""><img src="images/vote-top-1-de.jpg"></a>
						<a href=""><img src="images/vote-top-2-de.jpg"></a>
						<div class="pro-list vote-list">
							<ul class="row">
								<li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/01.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# BREA0408B023W</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
								<li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/002.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# CBZY4113</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
								<li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/02.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# CDPY0992</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
								<li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/04.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# CDPY0992</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/05.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# CIZY4393</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/06.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# CIZY4395</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/07.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# CROP0426B126K</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/08.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# CROP0428B054W</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/09.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# CSPY0527</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/10.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# CROP0428B054W</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/11.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# CROP0428B054W</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/12.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# CROP0428B054W</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/13.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# DRES0320B735K</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/14.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# DRES0323B770K</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/15.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# DRES0409B096P</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/16.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# DRES0413B102P</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/17.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# DRES0420B054K</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/18.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# DRES0422B041W</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/19.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# DRES0427B148K</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/20.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# DRES0506B201K</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/21.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# DRES0506B209K</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/22.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# DRES0511B065W</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/23.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# DRES0515B247G</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/24.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# DRES0526B273C</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/25.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# JUMP0331B229A</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/26.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# JUMP0409B023C</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/27.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# JUMP0409B023C</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/28.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# JUMP0412B259A</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/29.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# JUMP0417B041K</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/30.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# JUMP0424B069C</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/31.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# JUMP0429B180E</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/32.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# JUMP0506B200K</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/33.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# JUMP0507B330A</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/34.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# JUMP0512B201C</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/35.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# JUMP0513B067W</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/36.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# JUMP0513B632B</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/37.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# JUMP0521B364A</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/38.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# JUMP0605B347C</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/39.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# SKIR0426B289A</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/40.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# TSHI0413B985K</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/41.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# TWOP0122B209A</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/42.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# TWOP0412B254A</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/43.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# TWOP0413B975K</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/44.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# TWOP0422B077K</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/45.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# TWOP0426B286A</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/46.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# TWOP0426B297A</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/47.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# TWOP0429B160K</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/48.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# TWOP0507B176C</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/49.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# TWOP0507B313A</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/50.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# TWOP0520B240C</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/51.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# VEST0408B027W</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/52.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# TWOP0507B176C</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/53.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# CROP0422B276A</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/54.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# BLOU0326B092P</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/55.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# JUMP0331B232A</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/56.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# TWOP0426B300A</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/57.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# SWIM0520B432K</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/58.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# DRES1027A136A</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/59.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# DRES0323B771K</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
                                <li class="pro-item col-xs-6 col-sm-3">
									<div class="pic">
										<a href="">
											<img src="images/60.jpg" alt="">
										</a>
									</div>
									<div class="title clearfix mb10">
										<div class="fll"><input name="Fruit" type="checkbox" value="" />SKU# DRES0422B037W</div>
										<div class="flr"><a href=""><i class="myaccount"></i><b class="red">001 Stimmen</b></a></div>
									</div>
								</li>
							</ul>
						</div>
						<div class="vote-bottom">
							<div class="col-sm-3"></div>
							<div class="vote-box col-xs-12 col-sm-6">
								<div class="clearfix vote-textarea">
									<span><input name="Fruit" type="checkbox" value="" />Ich will CHOIES einige Vorschläge über das Modell/Outfits geben.</span>
									<textarea class="textarea-long" maxlength="500" 
								                style="width: 100%; height: 63px;color: #878787;background-color: #fff;" onfocus="this.value=''; this.onfocus=null;">Ihren Kommentar Hinterlassen...</textarea>
							    </div>
							    <div class=" vote-sub">
							    	<p>Teilen Sie mit Ihren Facebook Freunde oder Pinterest Freunde, um zusammen zu stimmen.</p>
							    	<p class="red">Je mehr Sie teilen, desto mehr Möglichkeiten haben Sie, $100 Geschenkkarte zu gewinnen . </p>
							    	<div class="sns clearfix mt20 mb20" style="line-height:32px; text-transform:uppercase">
                                    	<div style="display:inline-block; margin-right:10px;"><a rel="nofollow" href="http://www.pinterest.com/choies/" target="_blank" class="sns5"></a>pinterest</div>
                                        <div style="display:inline-block"><a rel="nofollow" href="http://www.facebook.com/choiesclothing" target="_blank" class="sns1"></a>facebook</div>
                                    </div>
							    	<button type="button" class="btn btn-default btn-lg mt20">SENDEN</button>
							    </div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer>
			<div id="comm100-button-311" class="bt-livechat visible-xs-block hidden-sm hidden-md hidden-lg">
				<a onclick="Comm100API.open_chat_window(event, 311);" href="#">
					<img id="comm100-button-311img" alt="" style="border:none;" src="https://chatserver.comm100.com/DBResource/DBImage.ashx?imgId=178&type=2&siteId=203306">
				</a>
			</div>
			<div class="w-top container-fluid">
				<div class="container">
					<div class="currency visible-xs-block hidden-sm hidden-md hidden-lg xs-mobile">
						<div class="row">
							<div class="currency-con">
								<dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-sites">
									<dt><a href="#">GERMAN SITE&nbsp;&nbsp;&nbsp;&nbsp;</a><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FRENCH SITE</a></dt>
									<dt><a href="#">SPANISH SITE&nbsp;&nbsp;&nbsp;&nbsp;</a><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RUSSIAN SITE</a></dt>
							    </dl>
								<dl class="sites col-xs-12">
									<dd class="col-xs-6"><a class="icon-flag icon-usd" href="#">US Dollar</a> </dd>
									<dd class="col-xs-6"><a class="icon-flag icon-gbp" href="#">Pound Sterling</a>
									</dd>
								</dl>
								<dl class="sites col-xs-12">
									<dd class="col-xs-6"><a class="icon-flag icon-eur" href="#">Euro</a>
									</dd>
									<dd class="col-xs-6"><a class="icon-flag icon-cad" href="#">Canadian Dollar</a>
									</dd>
								</dl>
								<dl class="sites col-xs-12">
									<dd class="col-xs-6"><a class="icon-flag icon-aud" href="#">Australian Dollar</a>
									</dd>
									<dd class="col-xs-6"><a class="icon-flag icon-brl" href="#">Brazil Reais</a>
									</dd>
								</dl>
								<dl class="sites col-xs-12">
									<dd class="col-xs-6"><a class="icon-flag icon-pln" href="#">Polish Zloty</a>
									</dd>
									<dd class="col-xs-6"><a class="icon-flag icon-mxn" href="#">Mexican Peso</a>
									</dd>
								</dl>
								<dl class="sites col-xs-12">
									<dd class="col-xs-6"><a class="icon-flag icon-dkk" href="#">Danish Krona</a>
									</dd>
									<dd class="col-xs-6"><a class="icon-flag icon-sar" href="#">Saudi Arabian Riyal</a>
									</dd>
								</dl>
								<dl class="sites col-xs-12">
									<dd class="col-xs-6"><a class="icon-flag icon-jpy" href="#">Japanese Yen</a>
									</dd>
									<dd class="col-xs-6"><a class="icon-flag icon-hkd" href="#">Hongkong Dollar</a>
									</dd>
								</dl>
							</div>
						</div>

					</div>

					<div class="fix row">
						<dl class="hidden-xs col-sm-2">
							<dt>MY ACCOUNT</dt>
							<dd><a href="#">Track Order</a>
							</dd>
							<dd><a href="#">Order History</a>
							</dd>
							<dd><a href="#">Account Setting</a>
							</dd>
							<dd><a href="#">Points History</a>
							</dd>
							<dd><a href="#">Wish List</a>
							</dd>
							<dd><a href="#">VIP Policy</a>
							</dd>
							<dd><a onclick="return feed_show();">Feedback</a>
							</dd>
						</dl>
						<dl class="hidden-xs col-sm-2">
							<dt>HELP INFO</dt>
							<dd><a href="#">FAQ</a>
							</dd>
							<dd><a href="#">Contact Us</a>
							</dd>
							<dd><a href="#">Payment</a>
							</dd>
							<dd><a href="#">Coupon &amp; Points</a>
							</dd>
							<dd><a href="#">Shipping &amp; Delivery</a>
							</dd>
							<dd><a href="#">Returns &amp; Exchange</a>
							</dd>
							<dd><a href="#">Conditions of Use</a>
							</dd>
						</dl>
						<dl class="hidden-xs col-sm-2">
							<dt>FEATURED</dt>
							<dd><a href="#">Lookbook</a>
							</dd>
							<dd><a href="#">Free Trial</a>
							</dd>
							<dd><a href="#">Flash Sale</a>
							</dd>
							<dd><a href="#">Wholesale</a>
							</dd>
							<dd><a href="#">Affiliate Program</a>
							</dd>
							<dd><a href="#">Blogger Wanted</a>
							</dd>
							<dd><a class="red" href="#">Rate &amp; Win $100</a>
							</dd>
						</dl>
						<dl class="hidden-xs col-sm-2">
							<dt>ALL SITES</dt>
							<dd><a href="#">English Site</a>
							</dd>
							<dd><a href="#">Spanish Site</a>
							</dd>
							<dd><a href="#">French Site</a>
							</dd>
							<dd><a href="#">German Site</a>
							</dd>
						</dl>
						<dl class="col-xs-12 col-sm-4 xs-mobile">
							<dt class="hidden-xs">Connect</dt>
							<dl class="sns">
								<dd>
									<a rel="nofollow" href="#" target="_blank" class="sns1"></a>
								</dd>
								<dd>
									<a rel="nofollow" href="#" target="_blank" class="sns2"></a>
								</dd>
								<dd>
									<a rel="nofollow" href="#" target="_blank" class="sns3"></a>
								</dd>
								<dd>
									<a rel="nofollow" href="#" target="_blank" class="sns4"></a>
								</dd>
								<dd>
									<a rel="nofollow" href="#" target="_blank" class="sns6"></a>
								</dd>
								<dd>
									<a rel="nofollow" href="#" target="_blank" class="sns7"></a>
								</dd>
							</dl>
							<dl class="letter">
								<form action="" method="post" id="letter_form">
									<label class="hidden-xs">SIGN UP FOR OUR EMAILS</label>
									<div>
										<input id="letter_text" class="text" value="Email Address" onblur="if(this.value==''){this.value=this.defaultValue;}" onfocus="if(this.value=='Email Address'){this.value='';};" type="text">
										<input id="letter_btn" value="Submit" class="btn btn-primary" type="submit">
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
							<dt><a href="#">MY ACCOUNT&nbsp;&bull;</a><a href="#">&nbsp;TRACK ORDER&nbsp;&bull;</a><a href="#">&nbsp;ORDER HISTORY</a></dt>
						</dl>
						<dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
							<dd><a href="#">LOOK BOOKS&nbsp;&bull;</a><a href="#">&nbsp;VIP POLICY&nbsp;</a>
							</dd>
						</dl>
						
					</div>
					<div class="card  hidden-xs container">
						<p class="paypal-card container">
							<img usemap="#Card" src="../images/card.jpg">
							<map id="Card" name="Card">
								<area target="_blank" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=<?php echo URLSTR; ?>&lang=en" coords="88,2,193,62" shape="rect">
							</map>
						</p>
					</div>
					<div class="copyright visible-xs-block hidden-sm hidden-md hidden-lg">
						<p>Copyright © 2006-2015 Choies.com </p>
						<dl class="col-xs-12 hidden-sm hidden-md hidden-lg xs-mobile object-insert">
							<a href="#">About Us&nbsp;&bull;</a><a href="#">&nbspContact Us&nbsp;&bull;</a><a href="#">&nbsp;Conditions of Use&nbsp;&bull;</a><a href="#">&nbsp;Privacy&Security</a>
						</dl>
					</div>
				</div>
				<div class="copyr hidden-xs">
					<p class="bottom container-fluid">Copyright © 2006-2015 Choies.com&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="#">Privacy &amp; Security</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="#">About Choies</a>
					</p>
				</div>
			</div>
		</footer>
		<div id="gotop" class="hide ">
			<a href="#" class="xs-mobile-top"></a>
		</div>
	</div>
	<script src="../../../js/common.js"></script>
	<script src="../../../js/slider.js"></script>
	<script src="../../../js/plugin.js"></script>
	<script src="../../../js/buttons.js"></script>
	<script src="../../../js/zoom.js"></script>
	<script src="../../../js/product-rotation.js"></script>
	
</body>
</html>