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
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Homepage</a>  >  Probe Bericht</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <section class="layout fix">
        <section id="container" class="flr">
            <div class="trial_report trial_report_list">
                <h2>Feedbacks der Gewinnern </h2>
                <!-- report_details -->
                <div class="report_details fix">
                    <?php $product = Product::instance($report['product_id'], LANGUAGE); ?>
                    <div class="left JS_imgbox">
                        <div class="pro_img">
                            <a href="#">
                                <img src="<?php echo Image::link($product->cover_image(), 2); ?>" class="JS_pro_img" width="324" />
                            </a>
                        </div>
                        <div class="pro_small">
                            <div class="pro_items">
                                <ul class="fix JS_pro_small">
                                    <?php
                                    $key = 0;
                                    foreach ($product->images() as $image):
                                        $key++;
                                        if ($key > 3)
                                            break;
                                        ?>
                                        <li<?php if ($key == 1) echo ' class="current"'; ?>><img src="<?php echo Image::link($image, 7); ?>" imgb="<?php echo Image::link($image, 2); ?>" width="102px" /></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="right">
                        <div class="right_top">
                            <h3><a href="<?php echo $product->permalink(); ?>"><?php echo $product->get('name'); ?></a></h3>
                            <span>Artikel#: <?php echo $product->get('sku'); ?></span>
                            <p class="price">Preis Jetzt: <?php echo Site::instance()->price($product->price(), 'code_view'); ?> <a href="<?php echo $product->permalink(); ?>" class="view_btn btn26 btn40">JETZT KAUFEN</a></p>
                        </div>
                        <div class="right_trial">
                            <div class="right_tit"><h4>Probe Bericht</h4></div>
                            <div class="right_con">
                                <div class="right_con_t"><span><?php echo $report['name']; ?></span>    <span><?php echo $report['age']; ?></span>    <span><?php echo $report['profession']; ?></span></div>
                                <p><?php echo $report['comments']; ?></p>
                                <p><img src="<?php echo 'http://img.choies.com/simages/' . $report['image']; ?>" /></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php echo View::factory(LANGPATH.'/catalog_left'); ?>
    </section>
</section>
