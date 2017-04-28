	<section id="main">
			<div class="container visible-xs-inline hidden-sm hidden-md hidden-lg col-xs-12">
				<div class="crumbs">
					<div>
						<a href="<?php echo LANGPATH; ?>/">home</a> > how to order
					</div>

				</div>
			</div>
			<!-- main-middle begin -->
			<div class="container">
				<div class="row">
					<article class="top-follow" style="line-height:40px;height:40px;">
						<p class="col-xs-12 mb20">Just Few Steps before you get it done.</p>
					</article>
					<section class="container">
						<aside class="aside-active hidden-xs">
							<ul>
								<li class="on"><a title="1" href="javascript:void(0)"><span>01</span> <p>How to find the item<br /> you want?</p></a>
								</li>
								<li><a title="2" href="javascript:void(0)"><span>02</span> <p>View and edit your <br />shopping bag. </p></a>
								</li>
								<li><a title="3" href="javascript:void(0)"><span>03</span> <p>Complete your payment<br />  with credit card. </p></a>
								</li>
								<li><a title="4" href="javascript:void(0)"><span>04</span> <p>View your order<br /> details. </p></a>
								</li>
							</ul>
						</aside>
						<article class="main-how col-sm-9 col-xs-12">
							<h1 id="index_1"><p><span class="list-circle hidden-xs">1</span><span><b class="visible-xs-inline hidden-sm">1</b>&nbsp;&nbsp;&nbsp;&nbsp;How to find the item you want?</span></p></h1>
							<p class="tips">(1)Through Homepage Banners: You can access to all activities & sales that is happening.
								<img src="/assets/images/how-to-order/pic1.1.jpg">
							</p>
							<p class="tips">(2) By Navigation: Get into the specific Catalog of the item you want.
								<img src="/assets/images/how-to-order/pic1.2.jpg">
								<img src="/assets/images/how-to-order/pic1.3.jpg">
								<img src="/assets/images/how-to-order/pic1.4.jpg">
							</p>
							<h1 id="index_2"><p><span class="list-circle hidden-xs">2</span><span><b class="visible-xs-inline hidden-sm">2</b>&nbsp;&nbsp;&nbsp;&nbsp;View and edit your shopping bag. </span></p></h1>
							<p class="tips">(1) Placing an available item in your shopping bag does not reserve that item. Available inventory is only assigned to your order after you
								<br> click Place your order and receive an e-mail confirmation that we've received your order.
								<br>
								<br> You can modify an item in your Shopping Bag:
								<br>
								<br> To change the quantity or the size, click "Change Details" and enter a number in the Quantity box and select a size in the drop down Size
								<br> menu, then click Update.
								<br>
								<br> To remove an item from your Shopping Bag, click "Delete" button next to the thumbnail.
								<br>
								<br> To wait until another day to buy some of the items in your Shopping Bag, click "Save for Later". This will move the item to your Saved for
								<br> Later list located below the Shopping Bag. Click Add to Cart next to an item when you are ready to purchase it.
								<img src="/assets/images/how-to-order/pic2.1.jpg">
								<img src="/assets/images/how-to-order/pic2.2.jpg">
							</p>
							<p class="tips">(2) Sign in to your account or create a new account if this is your first order.
								<img src="/assets/images/how-to-order/pic2.3.jpg">
							</p>
							<p class="tips">(3) Enter a shipping address, choose a shipping method.
								<img src="/assets/images/how-to-order/pic2.4.jpg">
							</p>
							<p class="tips">(4) Choose your payment information.Review your order details. Be sure you've applied any Coupon codes you want to use on your order.
								<br> Click PROCEED TO CHECKOUT your order if you choose credit card payment method.
								<img src="/assets/images/how-to-order/pic2.5.jpg">
							</p>
							<h1 id="index_3"><p><span class="list-circle hidden-xs">3</span><span><b class="visible-xs-inline hidden-sm">3</b>&nbsp;&nbsp;&nbsp;&nbsp;Complete your payment with credit card. </span></p></h1>
							<p class="tips">If you choose credit card payment and click "PROCEED TO CHECKOUT", please fill all the details in Credit Card Payment section on
								<br> this page and verify your billing address at first. We currently accept VISA, MasterCard, VISA Electron, Debit VISA, Debit MasterCard.
								<br> Please note that expiration date is on the front side of your card and CVV2 Code or security code is on the back side of your card.
								<img src="/assets/images/how-to-order/pic3.1.jpg">
							</p>
							<h1 id="index_4"><p><span class="list-circle hidden-xs">4</span><span><b class="visible-xs-inline hidden-sm">4</b>&nbsp;&nbsp;&nbsp;&nbsp;View your order details. </span></p></h1>
							<p class="tips">If you successfully complete your payment, you will be directed to payment success confirmation page.
								<br> Click Order Number to view more details.
								<img src="/assets/images/how-to-order/pic4.1.jpg">
							</p>
							<p class="tips" style="font-size:16px;color:#000;">Tips: If your payment fails, you could turn to your account and find your recent order details to
								<br> try to complete
								<img src="/assets/images/how-to-order/pic4.2.jpg">
								<img src="/assets/images/how-to-order/pic4.3.jpg">
							</p>
							<p class="tips" style="font-size:16px;color:#000;">Tips: Check out your order confirmation emails in your email
								<br>
							</p>
							<p class="tips">After you choose your payment method and click "PROCEED TO CHECKOUT", your order has been created and you will receive a
								<br> confirmation email from us. If you haven't received it, please check out your Spam email box and add service@choies.com to your
								<br> email list.
								<img src="/assets/images/how-to-order/pic4.4.jpg">
							</p>
						</article>
					</section>
				</div>
			</div>
		</section>

		<script>

			$(function($) {
			$(".aside-active ul li a").click(function(event) {
			var index=this.title
			var id='#'+'index_'+index
			$("html,body").animate({scrollTop: $(id).offset().top-60}, 500);
			});
			function a(x,y){
			l = $('.main-how').offset().right;
			w = $('.main-how').width();
			$('.aside-active').css('right',(l + w + x) + 'px');
			$('.aside-active').css('bottom',y + 'px');}
			$(function () {
			$(window).scroll(function(){
			h = window.screen.width
			t = $(document).scrollTop();
			if(h>1024){
				if(t>=0&t<1300) { $(".aside-active ul li").eq(0).addClass("on").stop().siblings().removeClass("on");}
				if(t>=1300&t<3500) { $(".aside-active ul li").eq(1).addClass("on").stop().siblings().removeClass("on");}
				if(t>=3500&t<4400) { $(".aside-active ul li").eq(2).addClass("on").stop().siblings().removeClass("on");}
				if(t>=4400&t<6000) { $(".aside-active ul li").eq(3).addClass("on").stop().siblings().removeClass("on");}
				if(t>=6000){$(".aside-active").hide();}else{$(".aside-active").show();}
			}
			else if(h=1024){
				if(t>=0&t<1000) { $(".aside-active ul li").eq(0).addClass("on").stop().siblings().removeClass("on");}
				if(t>=1000&t<2800) { $(".aside-active ul li").eq(1).addClass("on").stop().siblings().removeClass("on");}
				if(t>=2800&t<4000) { $(".aside-active ul li").eq(2).addClass("on").stop().siblings().removeClass("on");}
				if(t>=4000&t<4800) { $(".aside-active ul li").eq(3).addClass("on").stop().siblings().removeClass("on");}
				if(t>=4800){$(".aside-active").hide();}else{$(".aside-active").show();}
			}
			else {
				if(t>=0&t<1000) { $(".aside-active ul li").eq(0).addClass("on").stop().siblings().removeClass("on");}
				if(t>=1000&t<3200) { $(".aside-active ul li").eq(1).addClass("on").stop().siblings().removeClass("on");}
				if(t>=3200&t<3600) { $(".aside-active ul li").eq(2).addClass("on").stop().siblings().removeClass("on");}
				if(t>=3600&t<4400) { $(".aside-active ul li").eq(3).addClass("on").stop().siblings().removeClass("on");}
				if(t>=4400){$(".aside-active").hide();}else{$(".aside-active").show();}
				}
			})
			});})
		</script>
