		<div class="site-content">
			<div class="main-container clearfix">
				<div class="container">
				<div class="crumbs">
						<a href="/fr/">ACCUEIL</a> > Solde de Vendredi Noir
				</div>
                    <div>
                        <p class="mb25">
	                        <a href="">
	                            <img src="<?php echo STATICURL;?>/assets/images/fr.jpg" alt="">
	                        </a>
	                    </p>
                    </div>
					<div class="pro-list">
						<ul class="row" style="margin-bottom:2%;">
						<?php foreach($blackarr as $k=>$v){ ?>
							<li class="pro-item col-xs-6 col-sm-3">
								<div class="pic">
									<a href="<?php echo LANGPATH.'/product/'.$v['link'].'_p'.$v['id'];?>" target="_blank">
										<img src="<?php echo $v[
										'cover_image']; ?>" alt="">
									</a>
								</div>
								<div class="title">
									<a href="<?php echo LANGPATH.'/product/'.$v['link'].'_p'.$v['id'];?>" target="_blank"><i class="myaccount"></i><?php echo $v['fr_name'];?></a>
								</div>
								<p class="price">
									 <span class="priceold">$<?php echo $blackprice[$k][0]; ?></span>
								</p>
								<p class="price" style="font-size:16px;">
									 <span class="pricenow">Prix de Black Friday:<span class="red">$<?php echo $blackprice[$k][2]; ?></span></span>
								</p>
								<a href="#" id="<?php echo $v['id']; ?>" class="btn-qv quick_view"  data-reveal-id="myModal" attr-lang="<?php echo LANGUAGE; ?>">VUE RAPIDE</a>
							</li>
						<?php } ?>	
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div id="gotop" class="hide ">
			<a href="#" class="xs-mobile-top"></a>
		</div>

<?php echo View::factory(LANGPATH . '/quickview'); ?>

