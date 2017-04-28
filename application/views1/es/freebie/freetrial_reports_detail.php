<script>
$(function(){
        // pro_img 
	jQuery.fn.loadthumb = function(options) {
			options = $.extend({
				 src : ""
			},options);
			var _self = this;
			_self.hide();
			var img = new Image();
			$(img).load(function(){
				_self.attr("src", options.src);
				_self.fadeIn("slow");
			}).attr("src", options.src); 
			return _self;
	}
	$(".JS_pro_small li").live("click",function(){
		var src = $(this).find("img").attr("imgb");
		var bigimgSrc = $(this).find("img").attr("bigimg");
		$(this).parents(".JS_imgbox").find(".JS_pro_img").loadthumb({src:src}).attr("bigimg",bigimgSrc);
		$(this).addClass("current").siblings().removeClass("current");
		return false;
	});
	$(".JS_pro_small li:nth-child(1)").trigger("click");
})
</script>
		<section id="main">
			<!-- crumbs -->
			<div class="container">
				<div class="crumbs">
					<div>
						<a href="<?php echo LANGPATH; ?>/">home</a>
						<a href="<?php echo LANGPATH; ?>/freetrial/add" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > free trial</a> > freetrial reports
					</div>
					<div class="back visible-xs-inline hidden-sm hidden-md hidden-lg">&lt;&lt;&nbsp;<a class="back" href="window.history.back()">Volver</a>
					</div>
				</div>
			</div>
			<!-- main begin -->
			<section class="container">
				<div class="trial-report trial-report-list">
					<h2>Winners' Feedbacks</h2>
					<!-- report_details -->
					<div class="report-details">
                    <?php $product = Product::instance($report['product_id']); ?>
						<div class="report-left JS_imgbox col-sm-5 col-xs-12">
							<div class="pro-img">
								<a href="#">
									<img class="JS_pro_img" src="<?php echo Image::link($product->cover_image(), 2); ?>" style="display: inline;" />
								</a>
							</div>
							<div class="pro-small">
								<div class="pro-items">
									<ul class="JS_pro_small">
                                    <?php
                                    $key = 0;
                                    foreach ($product->images() as $image):
                                        $key++;
                                        if ($key > 3)
                                            break;
                                        ?>
										<li  class="<?php if ($key == 1) echo 'current'; ?> col-xs-3">
											<a href="<?php echo LANGPATH; ?>/">
												<img src="<?php echo Image::link($image, 3); ?>" imgb="<?php echo Image::link($image, 2); ?>" />
											</a>
										</li>
                                    <?php endforeach; ?>
									</ul>
								</div>
							</div>
						</div>
						<div class="report-right col-sm-6 col-xs-12 col-sm-offset-1">
							<div class="right-top">
								<h3><a href="<?php echo $product->permalink(); ?>"><?php echo $product->get('name'); ?></a></h3>
								<span>Item#:<?php echo $product->get('sku'); ?></span>
								<p class="price">Price Now: <?php echo Site::instance()->price($product->price(), 'code_view'); ?><a href="<?php echo $product->permalink(); ?>" class="btn btn-primary btn-sm">buy now</a>
								</p>
							</div>
							<div class="right-trial">
								<div class="right-tit">
									<h4>Trial Report</h4>
								</div>
								<div class="right-con">
									<div class="right-con-t"><span><?php echo $report['name']; ?></span> <span><?php echo $report['age']; ?></span> <span><?php echo $report['profession']; ?></span>
									</div>
									<p><?php echo $report['comments']; ?></p>
									<p>
										<img src="<?php echo 'http://img.choies.com/simages/' . $report['image']; ?>" />
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</section>
		<!-- footer begin -->

		<!-- gotop -->
		<div id="gotop" class="hide">
			<a href="#" class="xs-mobile-top"></a>
		</div>

