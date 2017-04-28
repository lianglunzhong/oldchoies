<?php if (!Customer::logged_in()): ?>
    <script type="text/javascript">

        $(function(){
            $("#agree").live("click", function(){
				var top = getScrollTop();
				top = top - 35;
				$('body').append('<div class="JS_filter1 opacity"></div>');
				$('.JS_popwincon1').css({
					"top": top,
					"position": 'absolute'
				});
				$('.JS_popwincon1').appendTo('body').fadeIn(320);
				$('.JS_popwincon1').show();
				return false;

            })
                    
			 $(".JS_close2,.JS_filter1").live("click", function() {
				$(".JS_filter1").remove();
				$('.JS_popwinbtn1').fadeOut(160);
				return false;
			})
					
            $("#catalog_link .clsbtn,#wingray").live("click",function(){
                $("#wingray").remove();
                $('#catalog_link').fadeOut(160).appendTo('#tab2');
                return false;
            })
        })
		
		function getScrollTop() {
				var scrollPos;
				if (window.pageYOffset) {
					scrollPos = window.pageYOffset;
				} else if (document.compatMode && document.compatMode != 'BackCompat') {
					scrollPos = document.documentElement.scrollTop;
				} else if (document.body) {
					scrollPos = document.body.scrollTop;
				}
				return scrollPos;
			}
    </script>
<?php endif; ?>
<?php
$url1 = parse_url(Request::$referrer);
?>
		<section id="main">
			<!-- crumbs -->
			<div class="container">
				<div class="crumbs">
					<div>
						<a href="<?php echo LANGPATH; ?>/">home</a> > blogger wanted
					</div>
					<div class="back visible-xs-inline hidden-sm hidden-md hidden-lg">&lt;&lt;&nbsp;<a class="back" href="<?php echo LANGPATH.$url1['path']; ?>">back</a>
					</div>
				</div>
			</div>
			<!-- main begin -->
			<section class="container blogger-wanted">
				<div class="blogger-img hidden-xs">
					<div class="step-nav step-nav1">
	                    <ul class="clearfix">
	                        <li>Fashion Programme<em></em><i></i></li>
	                        <li class="current">Read Policy<em></em><i></i></li>
	                        <li>Submit Information<em></em><i></i></li>
	                        <li>Get A Banner<em></em><i></i></li>
	                    </ul>
	                </div>
                </div>
				<article class="row">
					<div class="col-sm-1 hidden-xs"></div>
					<div class="col-sm-10 col-xs-12">
						<div class="fashion-policy">
							<h3>FASHION BLOGGER:</h3>
							<p>No matter you are a cool girl loving fashion, or a fashion blogger, always show your forward fashion taste as a free-thinking girl.</p>
							<p>By applying to the Choies.com Fashion Blogger program. Our bloggers benefit from special discounts and free products direct from our new product lines.</p>
							<p>Don't hesitate to send us an email(<a title="business@choies.com" href="mailto:business@choies.com">business@choies.com</a>) about yourself.</p>
						</div>
						<div class="fashion-policy">
							<p>How to Join CHOIES Fashion Blogger?</p>
							<h3>1. Are you a blogger who focuses on current fashion and style?</h3>
							<p>CHOIES now has been collaborating with many famous bloggers and will be honored to have you in our fashion programme. </p>
							<h3>Qualification:</h3>
							<p> 1. You believe you have a taste for fashion and are influential in your personal blog, Facebook page, YouTube, <span class="red1">Chicisimo</span> etc,</p>
							<p> 2. You blog about fashion frequently, at least once a week.</p>
							<p>&nbsp;</p>
							<h3>2. What should I do to start?</h3>
							<p>You have to register first in <?php echo URLSTR; ?> and put up our banner on your blog. You can get banner code by clicking "I agree". Inform us of your register email, we will add points to your account.</p>
							<p>&nbsp;</p>
							<h3>3. What rule should I follow to get my points renewed?</h3>
							<p>Usually you need to show our products within 7days and send me the link of your blog post. There should be a corresponding product link below the product you wear on your blog instead of the main page only unless the product you show has run out
								of stock. <span class="red1">Extra points if you share your look on Chicisimo.com and include a link to choies.com.</span>
							</p>
							<p>&nbsp;</p>
							<h3>4. How often do you give reward to different bloggers?</h3>
							<p>Usually we give points to bloggers as reward which you can use in our shop. We will renew their points when they make outfits on their blog and as many social platforms as possible and send us the post link.</p>
							<p>&nbsp;</p>
							<h3>5. Do I have to pay customs?</h3>
							<p>Custom policy differs from different countries. For example, Bloggers from Brazil have to provide us their tax number and pay tax. It depends on the policy of your country.</p>
							<p>&nbsp;</p>
							<h3>6. Are there other ways to get more points?</h3>
							<p>Yes, you can get more points by writing blog post featuring CHOIES or hold giveaways for choies and send us the link.</p>
							<p>&nbsp;</p>
							<h3>7. Please register on choies.com first before doing anything else.</h3>
							<p>You cannot use the points unless you have been registered.</p>
						</div>
						<div>
							<h3>About the copyright of your photos</h3>
							<p>We have the right to put photos from your blog on our facebook, instagram page and our other official pages.</p>
							<p>If you have any other questions about fashion blogger programme, you can email to <a title="business@choies.com" href="mailto:business@choies.com">business@choies.com</a>.</p>
							<p>&nbsp;</p>
							<p>We will check it in a week and reply if you are approved.</p>
							<p>If you agree with all the terms above, clicks agree to continue.</p>
							<div id="agree" class="mt20 mb10">
								<p><a href="<?php echo LANGPATH; ?>/blogger/submit_information"><strong class="btn btn-primary btn-lg">I Agree</strong></a>
								</p>
							</div>
						</div>
					</div>
					<div class="col-sm-1 hidden-xs"></div>
				</article>
			</section>
            <div class="JS_popwincon1 order hide">
			    <div>
			        <div class="fashion-thank">
			            <h4>Get your own account first before next step.<br>
			                Please login or register.</h4>
			            <div class="2btns">
			                <span style="padding-right:10px;"><a class="btn btn-primary btn-sm" title="Log In" href="<?php echo LANGPATH; ?>/customer/login?redirect=/blogger/submit_information"><strong style="width: 100px;" class="view_btn btn26 btn40">Log In</strong></a></span>
			                <span><a class="btn btn-primary btn-sm" title="REGISTER" href="<?php echo LANGPATH; ?>/customer/register?redirect=/blogger/submit_information"><strong style="width: 100px;" class="view_btn btn26 btn40">REGISTER</strong></a></span>
			            </div>
			        </div>
			    </div>
			    <div class="JS_close2 close-btn3"></div>
			</div>			
					

			<!-- footer begin -->

			<!-- gotop -->
			<div id="gotop" class="hide">
				<a href="#" class="xs-mobile-top"></a>
			</div>