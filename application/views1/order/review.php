<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/">home</a>
				<a href="/" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > order details</a> > write a review
			</div>
           <?php echo Message::get(); ?>
		</div>
	</div>
	<!-- main-middle begin -->
	<div class="container">
		<div class="row">
<?php echo View::factory('customer/left'); ?>
<?php echo View::factory('customer/left_1'); ?>
			<article class="user col-sm-9 col-xs-12">
				<div class="tit">
					<h2>Write a Review</h2>
				</div>
				<dl class="review">
					<dd class="oh">
						<div class="pic">
							<a href="<?php echo Product::instance($product_id)->permalink(); ?>">
								<img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 7); ?>">
							</a>
						</div>
						<div class="retit">
							<h6><?php echo Product::instance($product_id)->get('name'); ?></h6>
							<p>Item# : <?php echo Product::instance($product_id)->get('sku'); ?></p>
							<p class="price mt10">
                <?php
                $p_price = Product::instance($product_id)->get('price');
                $price = Product::instance($product_id)->price();
                if ($p_price > $price)
                {
                    $rate =round((($p_price - $price) / $p_price) * 100);
                    ?>
								<del><span><?php echo Site::instance()->price($p_price, 'code_view'); ?></span></del>
								<span class="price-now">NOW <span><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
								<span><?php if($rate > 0) echo $rate; ?>% OFF</span>
                    <?php
                }
				                        else
                { 	?>				
			<span class="price-now">PRICE:<span><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
                    <?php
                }
                ?>
							</p>
						</div>
						<p class="sub-tit"><b>Reviews</b>
						</p>
					</dd>
					<dd>
						<form action="#" method="post" class="form form2 review-form">
                <input type="hidden" name="product_id" id="review_product" value="<?php echo $product_id; ?>" />
                <input type="hidden" name="item_id" id="review_item" value="<?php echo $items['id']; ?>" />
                <input type="hidden" name="attribute" value="<?php echo $items['attributes']; ?>" />
                <input type="hidden" name="order_id" value="<?php echo $items['order_id']; ?>" />
							<div>
								<ul class="review-ul">
                        <?php
                        $firstname = Customer::instance($user_id)->get('firstname');
                        if(!$firstname)
                            $firstname = 'Choieser';
                        ?>
									<li>Customer ID:<span class="red"><?php echo $user_id; ?></span> Name:<span class="red"><?php echo $firstname; ?></span> <?php echo date('d M Y'); ?></li>
									<li class="row">
										<label class="col-sm-2">Overall Rating:</label>
										<ul class="star-ul col-sm-4 col-xs-12 col-xs-offset-1 col-sm-offset-0">
											<li>
												<a href="#" alt="1" title="I hate it" class="one-star"></a>
											</li>
											<li>
												<a href="#" alt="2" title="I don’t like it" class="two-star"></a>
											</li>
											<li>
												<a href="#" alt="3" title="It’s okay" class="three-star"></a>
											</li>
											<li>
												<a href="#" alt="4" title="I like it" class="four-star"></a>
											</li>
											<li>
												<a href="#" alt="5" title="I love it" class="five-star"></a>
											</li>
										</ul>
										<span class="s-result col-sm-4 col-xs-12" style="color: rgb(51, 51, 51);">Please select a feedback value</span>
                            <div class="s-result_h hide" color="333">Please select a feedback value</div>
                            <br><input type="hidden" name="overall" id="review_overall" value="" />
									</li>
									<li class="starbox row">
										<label class="col-sm-2">Quality Rating: </label>
										<ul class="square-ul col-sm-4 col-xs-12 col-xs-offset-1 col-sm-offset-0">
											<li>
												<a href="#" alt="1" title="I hate it" class="square-1"></a>
											</li>
											<li>
												<a href="#" alt="2" title="I don’t like it" class="square-2"></a>
											</li>
											<li>
												<a href="#" alt="3" title="It’s okay" class="square-3"></a>
											</li>
											<li>
												<a href="#" alt="4" title="I like it" class="square-4"></a>
											</li>
											<li>
												<a href="#" alt="5" title="I love it" class="square-5"></a>
											</li>
										</ul>
                            <input type="hidden" name="quality" id="review_quality" value="" />
										<span class="s-result-square col-sm-4 col-xs-12" style="color: rgb(51, 51, 51);">Please select a feedback value</span>
                            <div class="s-result-square-h hide" color="333">Please select a feedback value</div>
									</li>
									<li class="starbox row">
										<label class="col-sm-2">Price Rating: </label>
										<ul class="square-ul col-sm-4 col-xs-12 col-xs-offset-1 col-sm-offset-0">
											<li>
												<a href="#" alt="1" title="Very Expensive" class="square-1"></a>
											</li>
											<li>
												<a href="#" alt="2" title="Expensive" class="square-2"></a>
											</li>
											<li>
												<a href="#" alt="3" title="Reasonable" class="square-3"></a>
											</li>
											<li>
												<a href="#" alt="4" title="Cheap" class="square-4"></a>
											</li>
											<li>
												<a href="#" alt="5" title="Very Cheap" class="square-5"></a>
											</li>
										</ul>
                            <input type="hidden" name="price" id="review_price" value="" />
										<span class="s-result-square col-sm-4 col-xs-12" style="color: rgb(51, 51, 51);">Please select a feedback value</span>
                            <div class="s-result-square-h hide" color="333">Please select a feedback value</div>
									</li>
									<li class="starbox row">
										<label class="col-md-2">Fitness Rating: </label>
										<ul class="radio-ul">
											<li class="col-xs-12 col-md-2 ">
												<input type="radio" value="1" name="fitness" id="fitness_1">&nbsp;
												<label for="fitness_1" style="float:initial;">Very small</label>
											</li>
											<li class="col-xs-12 col-md-2">
												<input type="radio" value="2" name="fitness" id="fitness_2">&nbsp;
												<label for="fitness_2" style="float:initial;">Small</label>
											</li>
											<li class="col-xs-12 col-md-2">
												<input type="radio" value="3" name="fitness" id="fitness_3">&nbsp;
												<label for="fitness_3" style="float:initial;">Neutral</label>
											</li>
											<li class="col-xs-12 col-md-2">
												<input type="radio" value="4" name="fitness" id="fitness_4">&nbsp;
												<label for="fitness_4" style="float:initial;">Large</label>
											</li>
											<li class="col-xs-12 col-md-2">
												<input type="radio" value="5" name="fitness" id="fitness_5">&nbsp;
												<label for="fitness_5" style="float:initial;">Very large</label>
											</li>
										</ul>
									</li>
								</ul>
								<ul class="review-ul-second">
									<li class="row">
										<label class="col-sm-2">Height:</label>
										<input type="text" name="height" value="" class="text col-sm-8 col-xs-12">
										<span>&nbsp;&nbsp;CM</span>
									</li>
									<li class="starbox row">
										<label class="col-sm-2">Weight: </label>
										<input type="text" name="weight" value="" class="text col-sm-8 col-xs-12">
										<span>&nbsp;&nbsp;KG</span>
									</li>
								</ul>
							</div>
							<p>Write your review and you will get 100 Choies points. Once you sucessfully submit your review, you'll also be entered for a chance to win a $100 Choies' gift card every month! <a href="/rate-order-win-100" class="red" target="_blank">Learn more&gt;&gt;</a>
							</p>
							<p>
								<textarea id="review_text">Do you fancy this item? Share your opinion with other fashion girls! * Shopping experience (Price, Fit, Quality, Shipping time, etc) * Your personal style advice or outfit ideas (What do you wear with this item) Avoid: profanity or spiteful remarks, obscene or distasteful content,etc. We reads all reviews before posting them. We reserve the right not to post a review if it does not meet certain guidelines.
								</textarea>
                    <textarea name="content" class="hide" id="review_content"></textarea>
							</p>
							<p class="btn-two">
								<input type="button" class="btn btn-default btn-sm" value="Cancel">
								<input type="SUBMIT" class="btn btn-primary btn-sm" value="SUBMIT">
							</p>
							<p>Please allow 24 working hours for us to approve this review and offer 100 points to you.</p>
						</form>
					</dd>
				</dl>

			</article>

		</div>
	</div>
</section>

<script type="text/javascript">
	 // signin_form 
	$(".form").validate({
		rules: {
			overall: {
				required: true,
			},
			quality: {
				required: true,
			},
			price: {
				required: true,
			},
			fitness: {
				required: true,
			},
			height: {
				required: true,
				number: true,
			},
			weight: {
				required: true,
				number: true,
			},
			content: {
				required: true,
				minlength: 20,
				maxlength: 1000,
			}
		}
	});
</script>

<script type="text/javascript">

$(function(){
  $("#review_text").live('focusin', function(){
      $(this).addClass('inputfocus');
      if(this.value==this.defaultValue){
          this.value='';
      }
  }).focusout(function(){
      $(this).removeClass('inputfocus');
      if(this.value==''){
          this.value=this.defaultValue;
      }
  })

  $("#review_text").keydown(function(){
      var text = document.getElementById('review_text');
      $("#review_content").val(text.value);
  })
  
		$('.star-ul a').hover(function() {
					$(this).addClass('active-star');
					$('.s-result').css('color', '#c00').html($(this).attr('title'))
				}, function() {
					$(this).removeClass('active-star');
			$parent = $(this).parent().parent().parent().find('.s-result_h');
    var color = $parent.attr('color');
    var html = $parent.html();
    $('.s-result').css('color','#' + color).html(html);
				});
  
  $('.star-ul a').click(function(){
    var star = $(this).attr('alt');
    $(this).parent().parent().parent().find('input').val(star);
    $(this).parent().parent().parent().find('.error').hide();
    $(this).parent().siblings().find('a').removeClass('actived-star');
    $(this).addClass('actived-star');
    $(this).parent().parent().parent().find('.s-result_h').attr('color','c00').html($(this).attr('title'));
    return false;
  });
  
  $('.square-ul a').hover(function(){
    $(this).addClass('active-square');
    $(this).parents('.starbox').find('.s-result-square').css('color','#c00').html($(this).attr('title'))
  },function(){
    $(this).removeClass('active-square');
    $parent = $(this).parent().parent().parent().find('.s-result-square-h');
    var color = $parent.attr('color');
    var html = $parent.html();
    $(this).parents('.starbox').find('.s-result_square').css('color','#' + color).html(html);
  });
  
  $('.square-ul a').click(function(){
    var square = $(this).attr('alt');
    $(this).parent().parent().parent().find('input').val(square);
    $(this).parent().parent().parent().find('.error').hide();
    $(this).parent().siblings().find('a').removeClass('actived-square');
    $(this).addClass('actived-square');
    $(this).parent().parent().parent().find('.s-result_square_h').attr('color','c00').html($(this).attr('title'));
    return false;
  });
})
</script>