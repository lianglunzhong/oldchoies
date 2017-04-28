<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
    <script src="/js/plugin.js"></script>
     <style type="text/css">
		.points-banner{
			background:#dceeea; 
		}
		.points-banner-login{
			background:#c4dad6; 
		}
		.points-banner-login-mobile{
			background:#dceeea; 
		}
		.points-banner-login-mobile .container{
			position: relative;
		}
		.points-banner-login .container{
			position: relative;
		}
		.points-login{
			position: absolute;
			top: 38%;
			left: 30%;
			font-size: 16px;
		}

		.points-login a{
			color: #fff;
			text-decoration: underline;
			font-style: italic; 
			background: #d97c7e;
			padding:4px 8px; 
			border-radius:5px;
			text-decoration: none; 
		}
		.points-login-pc{
			position: absolute;
			top: 25%;
			left: 30%;
			font-size: 12px;
		}

		.points-login-pc a{
			color: #966300;
			text-decoration: underline;
			font-style: italic;  
		}
		.points-login-mobile{
			position: absolute;
			top: 89%;
			left: 26%;
			font-size: 12px;
		}

		.points-login-mobile a{
			color: #fff;
			text-decoration: underline;
			font-style: italic; 
			background: #d97c7e;
			padding:4px 8px; 
			border-radius:5px;
			text-decoration: none;
		}
		.points-code{
			position: relative;
		}
		.points-code li{
			margin-top: 3.5%;
		}
		.points-box{
			background:url(/assets/images/fr/1601/points-bg.jpg) repeat-y;
		}
		.points-on{
			position: absolute;
			background: #d06f37;
			font-size: 14px;
			text-transform: uppercase;
			color: #fff;
			padding: 1.5% 3%;
			top: 70%;
			right: 13%;
		}
		.points-on:hover{
			color: #fff;
			text-decoration: none;
		}
		.points-off{
			position: absolute;
			background: #b3b3b3;
			font-size: 14px;
			text-transform: uppercase;
			color: #fff;
			padding: 1.5% 3%;
			top: 70%;
			right: 10%;
		}
		.points-notes{
			font-size: 14px;
			line-height: 24px;
			text-align: left;
			padding:3.5% 0 0 2%; 
		}
		.confirm{
			text-align: center;
		}
		.confirm .text{
			font-size: 18px;
			padding:20px 0;
			border: none;
		}
		.confirm .button{
			font-size: 18px;
			padding:20px 0; 
		}
		.thanks{
			text-align: center;
		}
		.thanks p{
			font-size: 14px;
			padding:5px 0;
			border: none;
		}
		.thanks p a{
			text-decoration: underline;
		}
		.thanks .blod{
			font-weight: bold;
		}
		.thanks p.he{
			padding:3px 0;
			margin-bottom: 0px;
		}
    </style>
    
    
</head>
<body>
		<div class="site-content" id="phone-main">
			<div class="points-banner hidden-xs">
				<div class="container">
					<img  src="/assets/images<?php echo LANGPATH; ?>/1601/points-banner-pc-18.jpg">
				</div>
			</div>
			<div class="points-banner-login hidden-xs">
				<div class="container">
					<img  src="/assets/images<?php echo LANGPATH; ?>/1601/points-banner-pc-02.jpg">
					<?php
					//判断用户是否登录
					$user_session = Session::instance()->get('user');
					?>
					<?php
						if(!$user_session['id'])
						{
					?>
						<div class="points-login"><a href="/fr/customer/login?redirect=/fr/activity/points_redeem_coupons">Connectez-vous</a>pour racheter s'il vous plaît.</div>
					<?php 
						}else{
					?>
						<div class="points-login">Salut,<?php if($user_session['firstname']){ echo $user_session['firstname'];}else{ echo "choieser";}?>! Vous avez <span class="red" id="ajaxpoints"><?php echo $data['user_points'];?></span> points activés à utiliser.</div>
					<?php
						} 
					?>
				</div>		
			</div>

			<div class="points-banner-login-mobile  hidden-sm hidden-md hidden-lg">
				<div class="container" >
					<img  src="/assets/images<?php echo LANGPATH; ?>/1601/points-banner-mobile-18.jpg">
					<?php
						if(!$user_session['id'])
						{
					?>
						<div class="points-login-mobile" style="left:30%;">Please <a href="/fr/customer/login?redirect=/activity/points_redeem_coupons">Sign In</a> to Redeem.</div>
					<?php 
						}else{
					?>
						<div class="points-login-mobile" style="left:40%;"><span class="red" id="ajaxpoints_m"><?php echo $data['user_points'];?></span> Points à utiliser</div>
					<?php
						} 
					?>
				</div>		
			</div>
			<div class="points-box">
				<div class="container">
					<ul class="points-code">
					<?php foreach ($data['points'] as $key => $value)
					{
					?>
						<li class="col-xs-12 col-sm-6 col-md-4">
							<a href="javascript:void(0)" id="code" class="exchange"  >
								<img  src="/assets/images<?php echo LANGPATH; ?>/<?php echo $value['imgurl']; ?>">
								<?php
								if($data['user_points'] < $value['value'])
								{
								?>
									<div class="points-off" id="js_<?php echo $value['value'];?>">PAS ASSEZ DE POINTS</div>
								<?php
								}else{
								?>
									<a href="javascript:void(0);" class="points-on" data-reveal-id="myModal" data-value="<?php echo $value['value'];?>" data-name="<?php echo $value['name'];?>" id="js_<?php echo $value['value'];?>">Racheter Maintenant</a>
								<?php
								}
								?>
									
							</a>
						</li>
					<?php
					} 
					?>
					<?php foreach($data['points_pc'] as $key => $value)
					{
					?>
						<li class="col-xs-12 col-md-6 hidden-xs">
							<a href="javascript:void(0)" class="exchange-pc" data-value="<?php echo $value['value']; ?>" data-name="<?php echo $value['name'];?>">
								<img  src="/assets/images<?php echo LANGPATH; ?>/<?php echo $value['imgurl']; ?>" >
								<?php
								if($data['user_points'] < $value['value'])
								{
								?>
									<div class="points-off" id="js_<?php echo $value['value'];?>">PAS ASSEZ DE POINTS</div>
								<?php
								}else{
								?>
									<a href="javascript:void(0);" class="points-on" data-reveal-id="myModal" data-value="<?php echo $value['value'];?>" data-name="<?php echo $value['name'];?>" id="js_<?php echo $value['value'];?>">Racheter Maintenant</a>
								<?php
								}
								?>
							</a>
						</li>
					<?php 
					} 
					?>

					<?php  foreach($data['points_m'] as $key => $value)
					{
					?>
						<li class="col-xs-12 col-sm-6 hidden-md hidden-lg">
							<a href="javascript:void(0)" class="exchange-m" data-value="<?php echo $value['value']; ?>" data-name="<?php echo $value['name'];?>">
								<img  src="/assets/images<?php echo LANGPATH; ?>/<?php echo $value['imgurl']; ?>" >
								<?php
								if($data['user_points'] < $value['value'])
								{
								?>
									<div class="points-off" id="jsm_<?php echo $value['value'];?>">PAS ASSEZ DE POINTS</div>
								<?php
								}else{
								?>
									<a href="javascript:void(0);" class="points-on" data-reveal-id="myModal" data-value="<?php echo $value['value'];?>" data-name="<?php echo $value['name'];?>" id="jsm_<?php echo $value['value'];?>">Racheter Maintenant</a>
								<?php
								}
								?>
							</a>
						</li>
					<?php
					}
					?>
					</ul>
					<div class="clearfix"></div>
					<div class="points-notes">
						<p>
							<strong>REMARQUE:</strong><br>
							1. Par <strong>20 Février, 2016</strong>, tous les points seront remis à zéro. Utilisez-les pour racheter des coupons dès que possible s'il vous plaît.<br>
							2. Les codes promo sera valable <strong>jusqu'au 31 mai 2016</strong>.<br>
							3. Dès que vous avez racheté des points, ils ne seront pas retournés à votre compte. <br>
							4. Temps d'activité: <strong>Terminez le 20 février EST</strong>.<br>
							5. Nos blogueurs/partenaires coopératives sont exclus. Vous pouvez garder vos points.<br><br>
							Choies se réserve le droit d'interprétation finale de cette activité.
						</p>
					</div>
					<div class="other-customers">
						<div class="w-tit">
							<h2 style="background-color:#faf0e2;">Fortement recommandé Au Meilleurs Vendeurs</h2>
						</div>
						<div class="box-dibu1">

							<div id="personal-recs">
								<div class="hide-box1-0">
									<ul>
										<?php
			                            foreach($hots as $key=>$h)
			                            {
			                            	if($key <= 6)
			                            	{
			                                $hproduct = Product::instance($h['product_id'],LANGUAGE);
			                                ?>
			                                <li class="rec-item" kai="111"> 
			                                    <a href="<?php echo $hproduct->permalink(); ?>"> 
			                                        <img src="<?php echo Image::link($hproduct->cover_image(), 7); ?>" alt="<?php echo $hproduct->get('name'); ?>">
			                                    </a>
			                                    <p class="price">
			                                        <b><?php echo Site::instance()->price($hproduct->price(), 'code_view'); ?></b>    
			                                        <?php
			                                        if ($hproduct->get('has_pick'))
			                                            echo '<span class="icon_pick"></span>';
			                                        ?>
			                                    </p>
			                                </li>
			                            <?php
			                            	}
			                            }
			                            ?>
									</ul>
								</div>
								<div class="hide-box1-1 hide">
									<ul>
										<?php
			                            foreach($hots as $key=>$h)
			                            {
			                            	if($key >=7 && $key <= 13)
			                            	{
			                                $hproduct = Product::instance($h['product_id'],LANGUAGE);
			                                ?>
			                                <li class="rec-item" kai="111"> 
			                                    <a href="<?php echo $hproduct->permalink(); ?>"> 
			                                        <img src="<?php echo Image::link($hproduct->cover_image(), 7); ?>" alt="<?php echo $hproduct->get('name'); ?>">
			                                    </a>
			                                    <p class="price">
			                                        <b><?php echo Site::instance()->price($hproduct->price(), 'code_view'); ?></b>    
			                                        <?php
			                                        if ($hproduct->get('has_pick'))
			                                            echo '<span class="icon_pick"></span>';
			                                        ?>
			                                    </p>
			                                </li>
			                            <?php
			                            	}
			                            }
			                            ?>
									</ul>
								</div>
								<div class="hide-box1-2 hide">
									<ul>
										<?php
			                            foreach($hots as $key=>$h)
			                            {
			                            	if($key >=14 && $key <= 20)
			                            	{
			                                $hproduct = Product::instance($h['product_id'],LANGUAGE);
			                                ?>
			                                <li class="rec-item" kai="111"> 
			                                    <a href="<?php echo $hproduct->permalink(); ?>"> 
			                                        <img src="<?php echo Image::link($hproduct->cover_image(), 7); ?>" alt="<?php echo $hproduct->get('name'); ?>">
			                                    </a>
			                                    <p class="price">
			                                        <b><?php echo Site::instance()->price($hproduct->price(), 'code_view'); ?></b>    
			                                        <?php
			                                        if ($hproduct->get('has_pick'))
			                                            echo '<span class="icon_pick"></span>';
			                                        ?>
			                                    </p>
			                                </li>
			                            <?php
			                            	}
			                            }
			                            ?>
									</ul>
								</div>
								<div class="hide-box1-3 hide">
									<ul>
										<?php
			                            foreach($hots as $key=>$h)
			                            {
			                            	if($key >=21)
			                            	{
			                                $hproduct = Product::instance($h['product_id'],LANGUAGE);
			                                ?>
			                                <li class="rec-item" kai="111"> 
			                                    <a href="<?php echo $hproduct->permalink(); ?>"> 
			                                        <img src="<?php echo Image::link($hproduct->cover_image(), 7); ?>" alt="<?php echo $hproduct->get('name'); ?>">
			                                    </a>
			                                    <p class="price">
			                                        <b><?php echo Site::instance()->price($hproduct->price(), 'code_view'); ?></b>    
			                                        <?php
			                                        if ($hproduct->get('has_pick'))
			                                            echo '<span class="icon_pick"></span>';
			                                        ?>
			                                    </p>
			                                </li>
			                            <?php
			                            	}
			                            }
			                            ?>
									</ul>
								</div>
							</div>
							<div id="JS-current1" class="box-current">
								<ul>
									<li class="on"></li>
									<li id="circle1"></li>
									<li id="circle2"></li>
									<li id="circle3"></li>
								</ul>
							</div>
						</div>	
					</div>
					<div class="index-fashion buyers-show hidden-xs">
						<div class="phone-fashion-top w-tit">
							<h2  style="background-color:#faf0e2;">Highly Recommended Top Sellers</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="gotop" class="hide ">
			<a href="#" class="xs-mobile-top"></a>
		</div>
	</div>


	<!--
	<div id="register-modal" class="reveal-modal register-gift JS-popwincon1 hidden-xs" style="border-radius:0;display:none;" >
		<a class="close-reveal-modal close-btn3 JS-close2"></a>
		<div class="register-right">
			<h3>Register to win</h3>
			<p>Join in Choies now to have <span class="red">100%</span> Chance to <span class="red">win a free gift</span>.</p>
			<form class="register-form" action="#" method="post">
				<label><i>* Email</i></label>
				<input type="text" class="register-gift-text" placeholder="Your email" name="email" value="">
				<input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" type="submit" value="GET">
			</form>
			<p class="gift-no"><a class="JS-close2">No,Thanks. I’d like follow my own way! </a></p>
		</div>
	</div>

	<div id="register-modal-phone" class="register-gift-phone JS-popwincon1 hidden-sm hidden-md hidden-lg" style="border-radius:0;display:none;">
		<a class="close-reveal-modal close-btn3 JS-close2"></a>
		<div class="register-right">
			<h3>Register to win</h3>
			<p>Join in Choies now to have <span class="red">100%</span> Chance to <span class="red">win a free gift</span>.</p>
			<form class="register-form-phone" action="#" method="post">
				<label><i>* Email</i></label>
				<input type="text" class="register-gift-text" placeholder="Your email" name="email" value="">
				<input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" type="submit" value="GET">
			</form>
			<p class="gift-no"><a class="JS-close2">No,Thanks. I’d like follow my own way! </a></p>
		</div>
	</div>

	<div id="gift-modal" class="reveal-modal register-gift register-gift-2 JS-popwincon1 hidden-xs" style="border-radius:0;">
		<a class="close-reveal-modal close-btn3 JS-close2"></a>
		<div class="img-left">
			<ul>
				<li class="select"><div class="img-select"><img src="assets/images/gift-select.png" alt=""></div><img src="assets/images/SHOE1215A461B.jpg" alt=""><p><span class="red">$0.00&nbsp;&nbsp;</span><span><del>$9.99<<?php echo LANGPATH; ?>l></span></p></li>
				<li class="mt10"><div class="img-select hide"><img src="assets/images/gift-select.png" alt=""></div><img src="assets/images/SHOE1215A461B.jpg" alt=""><p><span class="red">$0.00&nbsp;&nbsp;</span><span><del>$9.99<<?php echo LANGPATH; ?>l></span></p></li>
			</ul>
		</div>
		<script>
			$("#gift-modal").find("li").click(function(){$(this).addClass("select").children("div").removeClass("hide");
														$(this).siblings().removeClass("select").children("div").addClass("hide");
														})
		</script>
		<div class="register-right">
			<h2>free gifts</h2>
			<h4>for the New Comer!</h4>
			<p class="mt20">Please choose one of the items and set your password below.</p>
			<form class="mt20 gift-form" action="#" method="post">
				<label><i>* password</i></label>
				<input type="text" class="register-gift-text" placeholder="6-24characters" name="password" value="">
				<input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" type="submit" value="APPLY">
			</form>
		</div>
	</div>

	<div id="gift-modal-phone" class="reveal-modal register-gift register-gift-2-phone JS-popwincon1 hidden-sm hidden-md hidden-lg" style="border-radius:0;">
		<a class="close-reveal-modal close-btn3 JS-close2"></a>
		<div class="register-right" style="margin-top:0;padding:0;">
			<h2>free gifts</h2>
			<h4>for the New Comer!</h4>
			<p class="mt20">Please choose one of the items and set your password below.</p>
			<ul>
				<li class="select"><div class="img-select"><img src="assets/images/gift-select.png" alt=""></div><img src="assets/images/SHOE1215A461B.jpg" alt=""><p><span class="red">$0.00&nbsp;&nbsp;</span><span><del>$9.99<<?php echo LANGPATH; ?>l></span></p></li>
				<li class="ml10"><div class="img-select hide"><img src="assets/images/gift-select.png" alt=""></div><img src="assets/images/SHOE1215A461B.jpg" alt=""><p><span class="red">$0.00&nbsp;&nbsp;</span><span><del>$9.99<<?php echo LANGPATH; ?>l></span></p></li>
			</ul>
			<script>
			$("#gift-modal-phone").find("li").click(function(){$(this).addClass("select").children("div").removeClass("hide");
														$(this).siblings().removeClass("select").children("div").addClass("hide");
														})
		    </script>
			<form class="mt20 gift-form-phone" action="#" method="post">
				<label><i>* password</i></label>
				<input type="text" class="register-gift-text" placeholder="6-24characters" name="password" value="">
				<input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" type="submit" value="APPLY">
			</form>
		</div>
	</div>
	<div class="reveal-modal-bg JS-filter1" style="display: block;"></div>
    











	<div id="register-modal" class="reveal-modal register-gift JS-popwincon1 hidden-xs" style="border-radius:0;display:none;">
		<a class="close-reveal-modal close-btn3 JS-close2"></a>
		<div class="register-right">
			<h3 style="font-size:20px;">Registrieren & Gewinnen</h3>
			<p>An CHOiES teilnehmen, um <span class="red">ein freies Geschenk zu gewinnen</span>.</p>
			<form class="register-form" action="#" method="post">
				<label><i>* Email</i></label>
				<input type="text" class="register-gift-text" placeholder="Ihr Email" name="email" value="">
				<input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" type="submit" value="Gewinnen">
			</form>
			<p class="gift-no"><a class="JS-close2">Nein Danke. Ich möchte meinen eigenen Weg folgen!</a></p>
		</div>
	</div>

	<div id="register-modal-phone" class="register-gift-phone JS-popwincon1 hidden-sm hidden-md hidden-lg" style="border-radius:0;display:none;">
		<a class="close-reveal-modal close-btn3 JS-close2"></a>
		<div class="register-right">
			<h3 style="font-size:19px;">Registrieren & Gewinnen</h3>
			<p>An CHOiES teilnehmen, um <span class="red">ein freies Geschenk zu gewinnen</span>.</p>
			<form class="register-form-phone" action="#" method="post">
				<label><i>* Email</i></label>
				<input type="text" class="register-gift-text" placeholder="Ihr Email" name="email" value="">
				<input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" type="submit" value="Gewinnen">
			</form>
			<p class="gift-no"><a class="JS-close2">Nein Danke. Ich möchte meinen eigenen Weg folgen!</a></p>
		</div>
	</div>

	 <div id="gift-modal" class="reveal-modal register-gift register-gift-2 JS-popwincon1 hidden-xs" style="border-radius:0;display:none;">
		<a class="close-reveal-modal close-btn3 JS-close2"></a>
		<div class="img-left">
			<ul>
				<li class="select"><div class="img-select"><img src="assets/images/gift-select.png" alt=""></div><img src="assets/images/SHOE1215A461B.jpg" alt=""><p><span class="red">$0.00&nbsp;&nbsp;</span><span><del>$9.99<<?php echo LANGPATH; ?>l></span></p></li>
				<li class="mt10"><div class="img-select hide"><img src="assets/images/gift-select.png" alt=""></div><img src="assets/images/SHOE1215A461B.jpg" alt=""><p><span class="red">$0.00&nbsp;&nbsp;</span><span><del>$9.99<<?php echo LANGPATH; ?>l></span></p></li>
			</ul>
		</div>
		<script>
			$("#gift-modal").find("li").click(function(){$(this).addClass("select").children("div").removeClass("hide");
														$(this).siblings().removeClass("select").children("div").addClass("hide");
														})
		</script>
		<div class="register-right">
			<h2 style="font-size:32px;">FREIE GESCHENK</h2>
			<h4>für Neuankömmlinge!</h4>
			<p class="mt20">Bitte wählen Sie einen Artikel und  setzen Sie Ihr Passwort unten.</p>
			<form class="mt20 gift-form" action="#" method="post">
				<label><i>* Passwort</i></label>
				<input type="text" class="register-gift-text" placeholder="6-24 Schriftzeichens" name="password" value="">
				<input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" type="submit" value="BEWERBEN">
			</form>
		</div>
	</div>

	<div id="gift-modal-phone" class="reveal-modal register-gift register-gift-2-phone JS-popwincon1 hidden-sm hidden-md hidden-lg" style="border-radius:0;display:none;">
		<a class="close-reveal-modal close-btn3 JS-close2"></a>
		<div class="register-right" style="margin-top:0;padding:0;">
			<h2 style="font-size:32px;">FREIE GESCHENK</h2>
			<h4>für Neuankömmlinge!</h4>
			<p class="mt20">Bitte wählen Sie einen Artikel und  setzen Sie Ihr Passwort unten.</p>
			<ul>
				<li class="select"><div class="img-select"><img src="assets/images/gift-select.png" alt=""></div><img src="assets/images/SHOE1215A461B.jpg" alt=""><p><span class="red">$0.00&nbsp;&nbsp;</span><span><del>$9.99<<?php echo LANGPATH; ?>l></span></p></li>
				<li class="ml10"><div class="img-select hide"><img src="assets/images/gift-select.png" alt=""></div><img src="assets/images/SHOE1215A461B.jpg" alt=""><p><span class="red">$0.00&nbsp;&nbsp;</span><span><del>$9.99<<?php echo LANGPATH; ?>l></span></p></li>
			</ul>
			<script>
			$("#gift-modal-phone").find("li").click(function(){$(this).addClass("select").children("div").removeClass("hide");
														$(this).siblings().removeClass("select").children("div").addClass("hide");
														})
		    </script>
			<form class="mt20 gift-form-phone" action="#" method="post">
				<label><i>* Passwort</i></label>
				<input type="text" class="register-gift-text" placeholder="6-24 Schriftzeichens" name="password" value="">
				<input class="btn btn-default btn-lg mt20" style="padding:0 58px;line-height:30px;height:30px;" type="submit" value="BEWERBEN">
			</form>
		</div>
	</div>
	-->

<div id="myModal" class="reveal-modal large">
        <a class="close-reveal-modal close-btn3"></a>
        <div class="confirm" >
        	<p class="text">Êtes-vous sûr de racheter les points?</p>
        	<p class="button">
        	  <input type="hidden" value="" id="but1">
        	  <input type="hidden" value="" id="but2">
		      <button type="button" class="btn btn-primary btn-sm" id="point_confirm">CONFIRMER</button>
		      <button type="button" class="btn btn-default btn-sm close-reveal-modal" style="font-size:12px; 
		      position: initial; line-height:26px; color:#fff;">ANNULER</button>
		    </p>
        </div>
        <div class="thanks" style="display:none;">
        	<p>Merci! Rachetées avec succès!</p>
        	<p class="blod he" id="thinkspoints">REDAS12153413</p>
         	<p class="red he">（Expire le 31 mai, 2016.）</p>
           	<p>Vérifiez dans <a href="<?php echo LANGPATH; ?>/customer/coupons" target="_blank"> Mes Coupons ></a></p>
        	<p>^_^ Nous allons aussi vous envoyer un email.</p>
        </div>
    </div>
    <div id="user_points" style="display:none">
    	<?php echo $data['user_points'] ?>
    </div>

	<!-- JS-popwincon1 login -->
<div id="myModal2" class="reveal-modal xlarge">
    <a class="close-reveal-modal close-btn3"></a>
    <?php echo View::factory('/customer/ajax_login'); ?>
</div>
	<script>

	    $(".register-form").validate({
	        rules: {
	            email: {    
	                required: true,
	                email: true
	            }   
	        },
	        messages: {
	            email: {
	                required: "Please enter your email address.",
	                email:"Please enter a valid email address."
	            }
	        
	        }
	    });
	    $(".register-form-phone").validate({
	        rules: {
	            email: {    
	                required: true,
	                email: true
	            }   
	        },
	        messages: {
	            email: {
	                required: "Please enter your email address.",
	                email:"Please enter a valid email address."
	            }
	        
	        }
	    });
	     $(".gift-form").validate({
	        rules: {
	             password: {
                        required: true,
                        minlength: 6,
                        maxlength:24
                    }
	        },
	        messages: {
	            password: {
                        required: "Please provide a password.",
                        minlength: "Password should between 6-24 characters.",
                        maxlength: "Password should between 6-24 characters."
                    }
	        
	        }
	    });
	      $(".gift-form-phone").validate({
	        rules: {
	             password: {
                        required: true,
                        minlength: 6,
                        maxlength:24
                    }
	        },
	        messages: {
	            password: {
                        required: "Please provide a password.",
                        minlength: "Password should between 6-24 characters.",
                        maxlength: "Password should between 6-24 characters."
                    }
	        
	        }
	    });
		$(function(){   
			$('.points-on').live("click",function(){
				var point_id = $(this).attr('data-value');
				var point_name = $(this).attr('data-name');
				var user_points=$("#user_points").text();
				user_points=$.trim(user_points);
				point_id = parseInt(point_id);
				user_points = parseInt(user_points);
				if(user_points<point_id){
					return false;
				}
				if(point_id==0){
					return false;
				}

				$("#but1").val(point_id);
				$("#but2").val(point_name);
		    	$(".thanks").hide();
				$(".confirm").show();
			    $("#myModal").show();
				
			    return false;  
		    })

		    $('#point_confirm').live("click",function(){
		    	var point_id1=$("#but1").val();
		    	var point_name1=$("#but2").val();
				$.ajax({
	            url:'<?php echo LANGPATH; ?>/ajax/ajax_points',
	            type:'POST',
	            dataType:'json',
	            data:{point_id: point_id1,point_name:point_name1},
	            success:function(res){
	            	if(res['success']==1)
	            	{
	            		$("#thinkspoints").html(res['newcoupon_code']);
	            		$("#ajaxpoints").html(res['points_new']);
	            		$("#ajaxpoints_m").html(res['points_new']);
	        			for(var p in res['all'])
	        			{
							$("#js_"+res['all'][p]).removeClass().addClass("points-off").removeAttr("data-reveal-id").html("PAS ASSEZ DE POINTS");
							//.手机端m
							$("#jsm_"+res['all'][p]).removeClass().addClass("points-off").removeAttr("data-reveal-id").html("PAS ASSEZ DE POINTS");
						}
						for(var p in res['allok'])
	        			{
							$("#js_"+res['all'][p]).removeClass().addClass("points-on").attr("data-reveal-id","myModal").html("Racheter Maintenant");
							//手机端m
							$("#jsm_"+res['all'][p]).removeClass().addClass("points-on").attr("data-reveal-id","myModal").html("Racheter Maintenant");
						}
						$("#user_points").html(res['points_new']);
						$(".confirm").hide();
						$(".thanks").show();
						return false;
	            	}else if(res['success']==-1){
	            		alert(res['content']);
	            		$("#myModal").hide();
	            		return false;
	            	}else if(res['success']==-3){
	            		alert(res['content']);
	            		$(".points-login-mobile").html(res['content']);
	            		$(".points-login").html(res['content']);
	            		$("#myModal").hide();
	            		return false;
	            	}
	            }
	    	 })
		    })
			
			/*//通用的积分兑换
			$(".exchange").click(function(){
				var point_id = $(this).attr('data-value');
				var point_name = $(this).attr('data-name');
				var user_points=<?php echo $data['user_points'] ?>;
				if(user_points<point_id){
					return false;
				}
				if(!confirm('确定要兑换么?'))
				{
					return false;
				}
				if(point_id.length==0){
					return false;
				}
				
				$.ajax({
	                url:'/ajax/ajax_points',
	                type:'POST',
	                dataType:'json',
	                data:{point_id: point_id,point_name:point_name},
	                success:function(res){
	                	if(res['success']==1)
	                	{
	                		alert(123);
	                		$("#thinkspoints").html();
	                		$(".thanks").show();
	                		$("#ajaxpoints").html(res['points_new']);
                			for(var p in res['all'])
                			{
								$("#js_"+res['all'][p]).removeClass().addClass("points-off").html("PAS ASSEZ DE POINTS");
							}
							for(var p in res['allok'])
                			{
								$("#js_"+res['all'][p]).removeClass().addClass("points-on").html("Racheter Maintenant");
							}
	                	}
	                }
            	})
			})*/
			//pc版本两个积分
			$('.exchange-pc').live("click",function(){
				var point_id = $(this).attr('data-value');
				var point_name = $(this).attr('data-name');
				var user_points=$("#user_points").text();
				user_points=$.trim(user_points);
				point_id = parseInt(point_id);
				user_points = parseInt(user_points);
				if(user_points<point_id){
					return false;
				}
				if(point_id==0){
					return false;
				}
				$("#but1").val(point_id);
				$("#but2").val(point_name);
		    	$(".thanks").hide();
				$(".confirm").show();
			    $("#myModal").show();
				
			    return false;  
		    })
			//m版本两个积分1
			$('.exchange-m').live("click",function(){
				var point_id = $(this).attr('data-value');
				var point_name = $(this).attr('data-name');
				var user_points=$("#user_points").text();
				user_points=$.trim(user_points);
				point_id = parseInt(point_id);
				user_points = parseInt(user_points);
				if(user_points<point_id){
					return false;
				}
				if(point_id==0){
					return false;
				}
				$("#but1").val(point_id);
				$("#but2").val(point_name);
		    	$(".thanks").hide();
				$(".confirm").show();
			    $("#myModal").show();
				
			    return false;  
		    })

			//recent view
		    $.ajax({
		        type: "POST",
		        url: "/site/ajax_recent_view",
		        dataType: "json",
		        data: "",
		        success: function(msg){
		            if(msg.length == 0)
		            {
		                $("#recent_li,#recent_view,#circle3").remove();
		            }
		            else
		            {
		                $("#recent_view").html(msg);
		            }
		        }
		    });
			//用户登录信息加载
			/*
			$("#login").click(function(){
				$.ajax({
                url:'/customer/ajax_login1',
                type:'POST',
                dataType:'json',
                data:{},
                success:function(res){
                	console.log(res);
                	return false;
                    if(res != 0)
                    {
                        $(".wish-title").removeAttr("data-reveal-id");
                        $.ajax({
                            url:'<?php echo LANGPATH; ?>/wishlist/ajax_add',
                            type:'POST',
                            dataType: "json",
                            data:{
                                product_id: pid,
                            },
                            success:function(result){
                                if(result.success)
                                {
                                    $("#myModal2").hide();
                                    $(".reveal-modal-bg").hide();
                                     $("#wish1_"+pid).html("<i class='fa fa-heart red' id='wish_'"+ pid+"></i>");
                                    $("#wish_" + pid).attr('class', 'fa fa-heart red')
                                    _proItem.find(".overlay").show();
                                    _proItem.find(".sign-warp").show();
                                    _proItem.find('.sign-warp').find('.wishlist_success').find('.text').text(result.message);
                                }
                                else
                                {
                                    alert(result.message)
                               //     showup(result.message);
                                }
                            }
                        });
                    }
                    else
                    {
                        $("#customer_pid").text(pid);
                    }
		            }
		        });
		        return false;

			})
*/
			
		})
	

	//窗口登录
	/*$("#form_login").submit(function(){
            var email = $("#email1").val();
            var password = $("#password1").val();
            var remember_me = 'on';
            if(typeof($("#remember_me1").attr('checked')) == 'undefined')
                remember_me = '';
            var pid = $("#customer_pid").text();
            console.log(pid);
            $.ajax({
                url:'<?php echo LANGPATH; ?>/customer/ajax_login',
                type:'POST',
                dataType: "json",
                data:{
                    email: email,
                    password: password,
                    remember_me: remember_me,
                },
                success:function(rs){
                	console.log(rs);
                	return false;
                    if(rs.success == 1)
                    {
                        $(".wish-title").removeAttr("data-reveal-id");

                    }
                    else
                    {
                        alert(rs.message);
                    }
                }
            });
            return false;
        })*/
    </script>
	
</body>
</html>