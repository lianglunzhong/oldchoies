<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
	<link rel="stylesheet" href="<?php echo Site::instance()->version_file('/assets/css/style.css'); ?>">
	<script src="/assets/js/jquery-1.8.2.min.js"></script>
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
	</head>
<body>
	<div class="page">
		<header class="site-header">
			<div class="nav-wrapper" style="display:block;">
				<div class="container">
					<div class="row" style="width:1200px;  background-color: #202020;">
						<div class="col-xs-2">
							<a class="logo" href="/" title=""></a>
						</div>
						<div class="col-xs-10" style="display:block;">
							<nav id="nav1" class="nav">
								<ul>
									<li>
										<a href="/daily-new">NEW IN</a>
									</li>
									<li>
										<a href="/clothing-c-615">APPAREL</a>
									</li>
									<li>
										<a href="/shoes-c-53">SHOES</a>
									</li>
									<li>
										<a href="/accessory-c-52">ACCESSORIES</a>
									</li>
									<li>
										<a href="/outlet-c-101" class="sale">SALE</a>
									</li>
									<li>
										<a href="/">ACTIVITIES</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</header>
		<div class="site-content">
			<div class="main-container clearfix">
				<div class="container">
					<div class="row" style="width:1200px;">
						<div class="luck-lay">
							<div class="luck-step fll" style="padding-top:50px;">
								<h3>step1</h3>
								<i class="fa fa-play"></i>
							</div>	
							<!-- User In -->
							<div class="luck-reg flr" style="padding-top:50px;">
								<h3>Register to WIN</h3>
								<p>Register with CHOIES!</p>
								<p>Then you can start the Lucky Turntable, and enjoy the big surprise!</p>
								<div class="reg-win">
									<div class="fll"><img src="/assets/images/reg-win.jpg"></div>
									<?php if(Customer::logged_in()){?>
									<div class="flr signup-success">
										<b>Great! </b>
										<p>You have successfully joined Choies Family! </p>
									</div>
									<?php }else{?>
									<div class="flr w-signup" style=" padding:40px 40px 0 0;">
										<form class="signup-form sign-form form" method="post" action="/customer/register">
											<input type="hidden" value="<?php echo BASEURL ;?>/" name="referer">
											<input type="hidden" value="luck_draw" name="draw_from">
											<input type="hidden" value="" name="langpath">
											<ul>
												<li>
													<div>
														<label>Email address:</label>
													</div>
													<input id="email" class="text umail" type="text" name="email" value="" onchange="chkemail()">
												</li>
												<li>
													<div>
														<label>Password:</label>
													</div>
													<input id="password" class="text" type="password" maxlength="16" name="password" value="">
												</li>
												<li>
													<div>
														<label>Confirm Password:</label>
													</div>
													<input class="text" type="password" maxlength="16" name="password_confirm" value="">
												</li>
												<li>
													<input class="btn btn-primary btn-lg mr10" type="submit" name="submit" value="Sign Up" onclick="ga('send', 'event', 'Button_click', 'click', 'Sign Up_activity');">
												</li>
											</ul>
										</form>
									</div>
									<?php }?>
								</div>	
							</div>
						</div>
						<div class="luck-lay">
							<div class="luck-step fll" style="padding-top:50px;">
								<h3>step2</h3>
								<i class="fa fa-play"></i>
							</div>	
							<div class="luck-reg flr" style="padding-top:50px;">
								<h3>Try Your Luck</h3>
								<div class="turntable">
									<div class="tur-box">
									<div id="dowebok">
										<div class="plate pla-bg">	</div>
										<?php if(Customer::logged_in()){?>
									    <a id="plateBtn" class="pla-play" href="javascript:void();" title="start">start</a>
										<?php }else{?>
										<a id="plateBtnHide" class="pla-play" href="javascript:void();" title="start">start</a>
									    <?php }?>
									</div>
										<div class="tur-user">
											<div class="tur-r-t">
												<b>Today’s Lucky Dogs</b>
												<p>We only show the latest 100 winners here.</p>
											</div>
											<div class="tur-r-line">
												<div class="fll"><img src="/assets/images/cup.png"></div>

												<script type="text/javascript">
													$(function(){
													    $('.fontscroll').fontscroll({time: 3000,num: 1});
													});
												</script>
												<div class="fontscroll flr">
												    <ul>
												    	<?php 
												    		$row = DB::query(Database::SELECT, 'select email,draw_name from customer_draw order by position asc limit 50')->execute()->as_array();
												    		if(count($row)>=1){
												    		  foreach ($row as $v) {
												    			$email = explode('@', $v['email']);
													    		$email1 = substr($email[0], 0,2).'**'.substr($email[0], -1);//eg:ma**s
													    		$email2 = explode('.', $email[1]);
													    		$newemail = $email1.'@'.substr($email[1], 0,1).'*'.substr($email[1], -4);//eg:ma**s
												    	?>
												        <li style="font-size:12px"><?php echo $newemail;?><span><?php echo $v['draw_name'];?></span></li>
												        <?php }}else{?>  
												        <li style="font-size:12px">as***d.tveita@g*.com   <span>5% Code</span></li>
												        <li style="font-size:12px">alc5**@y*.com   <span>Free Gift</span></li>
												        <li style="font-size:12px">alc5**@y*.com   <span>Free Gift</span></li>
												        <li style="font-size:12px">as***d.tveita@g*.com   <span>5% Code</span></li>
												        <li style="font-size:12px">alc5**@y*.com   <span>Free Gift</span></li>
												        <li style="font-size:12px">alc5**@y*.com   <span>Free Gift</span></li>
												        <li style="font-size:12px">as***d.tveita@g*.com   <span>5% Code</span></li>
												        <li style="font-size:12px">alc5**@y*.com   <span>Free Gift</span></li>
												        <li style="font-size:12px">alc5**@y*.com   <span>Free Gift</span></li>
												        <li style="font-size:12px">as***d.tveita@g*.com   <span>5% Code</span></li>
												        <li style="font-size:12px">alc5**@y*.com   <span>Free Gift</span></li>
												        <li style="font-size:12px">alc5**@y*.com   <span>Free Gift</span></li>
												        <?php }?>
												    </ul>
												</div>
											</div>	
										</div>	
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="luck-notes">
									<dl>
										<dt>Notes:</dt>
										<dd>1. One ID, One Chance to play the Game.</dd>
										<dd>2. Choies reserves the rights to the final explanation of the campaign.  </dd>
										<dd>Any questions regarding the campaign please email to service@choies.com.</dd>
									</dl>
								</div>
							</div>
						</div>
					</div>	
				</div>
			</div>
		</div>
		<footer>
			<div class="container-fluid" style="background-color: #202020;">
				<div class="copyr container">
					<div class="row" style="width:1200px;background-color: #202020;">
						<p class="bottom container-fluid">Copyright © 2006-2015 Choies.com&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a style="color: #ccc;" href="/privacy-security" class="hidden-xs">Privacy &amp; Security</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a style="color: #ccc;" href="/about-us" class="hidden-xs">About Choies</a>
						</p>
					</div>
				</div>
			</div>
		</footer>
		<div id="gotop" class="hide ">
			<a href="#" class="xs-mobile-top"></a>
		</div>

	</div>
	<div id="result">
    	<div class="result-modal-bg"></div>
		<div id="resultTxt">       	
        </div>
	</div>
	
	<script src="/assets/js/jquery.rotate.min.js"></script>
	<script>
		$(function(){
			var $plateBtn = $('#plateBtn');
			var $plate = $('.plate');
			var $result = $('#result');
			var $resultTxt = $('#resultTxt');
			var $resultBtn = $('#resultBtn');
			$plateBtn.click(function()
			{
				$plateBtn.unbind("click");
				$.post('/activity/chkdraw',{customer_id : "<?php echo Customer::logged_in();?>"},function(data)
				{
					switch(data){
						case "nochange":
							alert("Sorry! You have already played the game!");
							break;
						case "689717": 
							var five = [ 170, 140];
							five = five[Math.floor(Math.random()*five.length)];
							rotateFunc(689717,five,'<div class="res-box"><div class="res-title">Congratulations! You got a <span>5%</span> Code</div><div class="res-img"><img src="/assets/images/5code.png"></div><div class="res-back"><a href="/customer/coupons">My Coupons</a><a href="/" style="margin-left:20px;">Start Shopping ></a></div></div>');
							break;
						case "0": 
							var haveno = [ 90, 75];
							haveno = haveno[Math.floor(Math.random()*haveno.length)];
							rotateFunc(0,haveno,'<div class="res-box"><div class="res-title">HAPPY EVERY DAY</div><div class="res-img" style="margin-top:8px;"><img src="/assets/images/smile.png"></div><div class="res-back" style="margin-top:8px;">Sorry! <br>No Gift but Best Wishes from <a href="/">Choies.</a></div></div>');
							break;
						case "689721": 
							var FREE = [ 245, 290];
							FREE = FREE[Math.floor(Math.random()*FREE.length)];
							rotateFunc(689721,FREE,'<div class="res-box"><div class="res-title">Congratulations! You got a <span>FREE GIFT!<span> </div><div class="res-img" style="margin-top:8px;"><img src="/assets/images/luck.png"></div><div class="res-back" style="margin-top:8px;"><a href="/customer/coupons">Check the Gift Code in My Coupons</a><a href="" style="margin-left:20px;">Start Shopping NOW  ></a></div></div>');
							break;
						case "689718": 
							var ten = [ 355, 310];
							ten = ten[Math.floor(Math.random()*ten.length)];
							rotateFunc(689718,ten,'<div class="res-box"><div class="res-title">Congratulations! You got a <span>10%</span> Code</div><div class="res-img"><img src="/assets/images/10code.png"></div><div class="res-back"><a href="/customer/coupons">My Coupons</a><a href="/" style="margin-left:20px;">Start Shopping ></a></div></div>');
							break;
					}
				});
					
			});
			 
			var rotateFunc = function(awards,angle,text){
				$plate.stopRotate();
				$plate.rotate({
					angle: 0, 
					duration: 5000,
					animateTo: angle + 1440, 
					callback: function(){
						$.post('/activity/senddraw',{coupon_id:awards,customer_id:"<?php echo Customer::logged_in();?>"},function(re){
							$resultTxt.html(text);
							$result.show();
						})						
					}
				});
			};
		});
	</script>

	<script type="text/javascript">
            // signup-form 
            $(".signup-form").validate({
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
 			$("#plateBtnHide").click(function(){
				$(window).scrollTop(0);
			});

			//chkemail
			function chkemail(){
				var uemail = $(".umail").val();
				$.post('/draw/chkmail', {email:uemail}, function(result){
					if(result == "isset"){
						alert("This email has been registered.");
						$(".umail").val("");
						return false;
					}
				})
			}
        </script>	
</body>
</html>