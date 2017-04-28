 <style>
.vip-top p{
	margin-bottom:0;
	text-align:center;
	}
.vip-top p.tt a{
    text-decoration:underline;
	color:#ff6161;
	}
.vip-top img{
	display:block;
	}
.pricevip{
	font-size:16px;
	font-weight:bold;
	color:#202020;
	text-align:center;
}
.fix::after {
    clear: both;
    content: ".";
    display: block;
    height: 0;
    overflow: hidden;
    visibility: hidden;
}



</style>

    <div class="site-content">
    <div class="main-container clearfix">
    <div class="container">
      <div class="row">
      <div class="vip-top col-xs-12">
        	<p><a href="<?php echo LANGPATH; ?>/vip-policy" target="_blank"><img src="<?php echo STATICURL; ?>/assets/images/<?php echo LANGUAGE;?>/1601/vip-banner1.jpg"></a></p>
          <p><a href="<?php echo LANGPATH;?>/customer/login?redirect=<?php echo LANGPATH;?>/activity/vip_exclusive" target="_blank"><img src="<?php echo STATICURL; ?>/assets/images/vip/no1-<?php echo LANGUAGE; ?>.jpg"></a></p>

        </div>	
      </div>	
	  <div class="pro-list">
						<ul class="row">
						<?php foreach($skuArr as $k=>$v){ ?>
							<li class="pro-item col-xs-6 col-sm-3">
								<div class="overlay"></div>
								<div class="pic">
                                     <?php 
                                     $proid = Product::get_productId_by_sku($v);
                                     $product_instance = Product::instance($proid,LANGUAGE);
                                     $product_inf = $product_instance->get();
                                     $plink = $product_instance->permalink();
                                     $cover_image = $product_instance->cover_image();

                                    //vip spromotions price | Table spromotions 'type' = '0:vip'
                                    $vip_promotion_price = DB::select('price')
                                        ->from('spromotions')->where('type', '=', 0)
                                        ->where('product_id', '=', $proid)
                                        ->where('expired', '>', time() - 36000)
                                        ->execute()->get('price');
                                      ?>
									<a href="<?php echo $plink; ?>" target="_blank">
										<img src="<?php echo Image::link($cover_image, 1); ?>" alt="">
									</a>
								</div>
								<div class="title">
									<a href="<?php echo $plink; ?>" target="_blank"><?php echo $product_inf['name']; ?></a>
								</div>
								<p class="price">
                            <?php
                            $orig_price = round($product_inf['price'], 2);
                            $price = round($product_instance->price(), 2);
                               if ($orig_price > $price)
                            {
                             ?>
									 <span style="color:#999;font-size:12px;">Изначальная Цена:</span><span class="priceold"><?php echo Site::instance()->price($orig_price, 'code_view'); ?></span>
									 <span class="pricenew" style="color:#444;font-weight:normal;">Цена Продажи:<?php echo Site::instance()->price($price, 'code_view'); ?></span>
                                <?php
                            }
                            else
                            {
                                ?>
                                <span class="pricenew" style="color:#444;font-weight:normal;">Цена Продажи:<?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                <?php
                            }
                            ?>           
								</p>
								<!--
								<p class="price">
									<span class="pricenew" style="color:red;font-weight:bold;">VIP Цена:<?php //echo Site::instance()->price($vip_promotion_price, 'code_view'); ?></span>								
								</p>
								-->
							</li>

						<?php } ?>
						</ul> 
					</div>
					<div class="vip-top col-xs-12" style="margin-top:40px;">

                        <p style="margin:40px 0;"><img src="<?php echo STATICURL; ?>/assets/images/vip/vip-tips-<?php echo LANGUAGE; ?>.gif"></p>
                    </div>

					

    </div>
    </div>
    </div>
	<script type="text/javascript" src="js/list.js"></script>
   

