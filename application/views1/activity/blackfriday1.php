		<div class="site-content">
			<div class="main-container clearfix">
				<div class="container">
				<div class="crumbs">
						<a href="/">home</a> > Black Friday Sale
				</div>
					<div class="pro-list">
						<ul class="row" style="margin-bottom:2%;">
						<?php foreach($product as $k=>$v){ ?>
							<li class="pro-item col-xs-6 col-sm-3">
								<div class="pic">
								<?php 
								$cover_image = image::link(Product::instance($v['id'])->cover_image(), 7);
								$plink = Product::instance($v['id'])->permalink();
                                //$orig_price = round($product_inf['price'], 2);
                                $price = round(Product::instance($v['id'])->price(), 2);
                                $name = Product::instance($v['id'])->get('name');
								?>
									<a href="<?php echo $plink;?>" target="_blank">
										<img src="<?php echo $cover_image; ?>" alt="">
									</a>
								</div>
								<div class="title">
									<a href="<?php echo $plink;?>" target="_blank"><i class="myaccount"></i><?php echo $name;?></a>
								</div>
								<a href="#" id="<?php echo $v['id']; ?>" class="btn-qv quick_view"  data-reveal-id="myModal">Quick View</a>
							</li>
						<?php } ?>	
						</ul>
					</div>
					<?php echo $pagination; ?>
				</div>
			</div>
		</div>

		<div id="gotop" class="hide ">
			<a href="#" class="xs-mobile-top"></a>
		</div>

<?php echo View::factory('quickview'); ?>

