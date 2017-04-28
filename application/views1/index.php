<?php
if(empty(LANGUAGE))
{
	$lists = Kohana::config('/index/index.en');
}
else
{
	$lists = Kohana::config('/index/index.'.LANGUAGE);
}
?>
        <div class="site-content">
			<div class="main-container clearfix">
				<div class="container container-xs">
            <!-- Banner Start 2015.10.22 -->
			<div id="homeBigBanner" class="flexslider topbanner hidden-xs">
				<ul class="slides">
					<?php 
	                	foreach ($banners as $key=>$banner){
	                		$i = $key + 1;
	                    if (strpos($banner['link'], 'http://') >= 0 OR strpos($banner['link'], 'https://') >= 0) $link = $banner['link'];
	                    else $link = '/' . $banner['link'];
	                    if (isset($banner['map'])) $map = 'Map' . $banner['id'];
	                    else $map = '';

	                    // $banner_src = LOCALURL.$banner['image'];
	                    if($is_mobile)
	                    	$banner_src = STATICURL . '/simages/8_' . $banner['image'];
	                    else
	                    	$banner_src = STATICURL . '/simages/' . $banner['image'];
                    ?>
					<li><a href="<?php echo LANGPATH; ?><?php echo $link; ?>"><img src="<?php echo $banner_src; ?>"  alt="<?php echo $banner['title']; ?>" class="main_banner<?php echo $i;?>" /></a></li>
					<?php }?>
				</ul>
				<script type="text/javascript">
 					$(function(){
						$('#homeBigBanner').flexslider({
		                    animation: "slides",
		                    direction:"horizontal",
		                    easing:"swing"
		                });
					})	
				</script>
			</div>
			<!-- Banner End  2015.10.22 -->
			<div id="phoneBigBanner" class="flexslider topbanner hidden-sm hidden-md hidden-lg">
				<ul class="slides">
					<?php 
					if(!empty($phone_banners)){
	                	foreach ($phone_banners as $key=>$banner){
	                		$i = $key + 1;
	                    if (strpos($banner['link'], 'http://') >= 0 OR strpos($banner['link'], 'https://') >= 0) $link = $banner['link'];
	                    else $link = '/' . $banner['link'];
	                    if (isset($banner['map'])) $map = 'Map' . $banner['id'];
	                    else $map = '';

	                    $banner_src = STATICURL . '/simages/' . $banner['image'];
	                    //$banner_src = 'http://58.213.103.194:8069/uploads/' . $banner['image'];
	                ?>
					<li>
						<a href="<?php echo LANGPATH; ?><?php echo $link; ?>"><img class="main_banner<?php echo $i;?>" src="<?php echo $banner_src; ?>" alt="" /></a>
					</li>
					<?php }}?>
				</ul>
				<script type="text/javascript">
					$(function(){
						$('#phoneBigBanner').flexslider({
	                        animation: "slides",
	                        direction:"horizontal",
	                        easing:"swing"
	                    });
                	})	
				</script>
			</div>  

						<div class="celection">
							<ul class="row">
					<?php 
					if(!empty($phonecatalog_banners))
					{
	                	foreach ($phonecatalog_banners as $key=>$banner)
	                	{
	                		$i = $key + 1;
	                		if($i <=2)
	                		{
	                			// $banner_src = LOCALURL.$banner['image'];
	                			$banner_src = STATICURL . '/simages/' . $banner['image'];
					?>
								<li class="col-xs-6 col-sm-4">
									<a class="img" href="<?php echo LANGPATH; ?><?php echo $banner['link'];?>">
										<p class="show-icon"><?php echo $lists['SHOP']; ?></p>
										<img src="<?php echo $banner_src; ?>" class="pin_banner<?php echo $i;?>">
									</a>
									<p><?php echo $banner['title'];?></p>
									<span><a href="<?php echo LANGPATH; ?><?php echo $banner['link'];?> "  class="pin_banner<?php echo $i;?>"><?php echo $banner['alt'];?></a></span>			
								</li>
					<?php 
							}
						}
					} 
					?>
								<li class="hot col-xs-12 hidden-sm hidden-md hidden-lg">
									<table class="phone-hot" >
										<tbody>
											<tr>
												<td class="col-xs-6">
													<a href="<?php echo LANGPATH; ?>/daily-new/week2"><?php echo $lists['New In']; ?> ›</a>
												</td>
												<td class="col-xs-6">
													<a href="<?php echo LANGPATH; ?>/clothing-c-615"><?php echo $lists['CLothing']; ?> ›</a>
												</td>
											</tr>
											<tr>
												<td class="col-xs-6">
													<a href="<?php echo LANGPATH; ?>/shoes-c-53"><?php echo $lists['Shoes']; ?> ›</a>
												</td>
												<td class="col-xs-6">
													<a href="<?php echo LANGPATH; ?>/accessory-c-52"><?php echo $lists['Accessories']; ?> ›</a>
												</td>
											</tr>
											<tr>
												<td class="col-xs-6">
													<a href=""><?php echo $lists['The Choies Galaxy']; ?> ›</a>
												</td>
												<td class="col-xs-6">
													<a href="<?php echo LANGPATH; ?>/outlet-c-101"><?php echo $lists['Sale']; ?> ›</a>
												</td>
											</tr>
										</tbody>
									</table>
								</li>
								<li class="hidden-sm hidden-md hidden-lg"></li>
					<?php 
					if(!empty($phonecatalog_banners))
					{
	                	foreach ($phonecatalog_banners as $key=>$banner)
	                	{
	                		$i = $key + 1;
	                		if($i > 2 && $i < 7)
	                		{
	                			// $banner_src = LOCALURL.$banner['image'];
	                			$banner_src = STATICURL . '/simages/' . $banner['image'];
					?>
								<li class="col-xs-6 col-sm-4">
									<a class="img" href="<?php echo LANGPATH; ?><?php echo $banner['link'];?>">
										<p class="show-icon">SHOP</p>
										<img src="<?php echo $banner_src; ?>" class="pin_banner<?php echo $i;?>">
									</a>
									<p><?php echo $banner['title'];?></p>
									<span><a href="<?php echo LANGPATH; ?><?php echo $banner['link'];?> " class="pin_banner<?php echo $i;?>"><?php echo $banner['alt'];?></a></span>			
								</li>
					<?php 
							}
						}
					} 
					?>
							</ul>
						</div>            
            <?php
            if(!$is_mobile)
            {       
            ?>
					<div class="n-ad hidden-xs">
						<?php
						if(isset($newindex_banners))
						{
	                        if(array_key_exists(6, $newindex_banners))
	                        {
	                        ?>
	                          <a href="<?php echo LANGPATH.$newindex_banners[6]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[6]['image']; ?>" class="central_banner"></a>
	                        <?php
	                        }
	                    }
                        ?>
					</div>

					<div class="arrivals hidden-xs">
						<?php
						if(isset($newindex_banners))
						{
	                        if(array_key_exists(7, $newindex_banners))
	                        {
	                        ?>
	                           <a class="arr-pic" href="<?php echo LANGPATH.$newindex_banners[7]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[7]['image']; ?>" class="newarrival_banner"></a>
	                        <?php
	                        }
	                    }
                        ?>
						<ul class="row">
						<?php 
						if(isset($index6_banners))
						{
							foreach($index6_banners as $keys=>$value)
							{
								$j = $keys + 1;
								$sku = $value['link'];
								$proid = Product::get_productId_by_sku($sku);
								$pro_instance = Product::instance($proid,LANGUAGE);
								$plink = $pro_instance->permalink();
								$pname = $pro_instance->get('name');
								?>
								<li class="col-xs-2">
									<a href="<?php echo $plink; ?>"><img src="<?php echo STATICURL; ?>/simages/<?php echo $value['image']; ?>" class="new_banner<?php echo $j;?>"></a>
									<a class="arr-name" href="<?php echo $plink; ?>"><?php echo $pname; ?></a>
								</li>
							<?php 
							}
						}
						 ?>
						</ul>
					</div>
					<div class="follow-us hidden-xs">
						<?php
						if(isset($newindex_banners))
						{
	                        if(array_key_exists(8, $newindex_banners))
	                        {
	                        ?>
	                           <a class="flo-pic" href="<?php echo LANGPATH.$newindex_banners[8]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[8]['image']; ?>" class="instagram_banner"></a>
	                        <?php
	                        }
	                    }
                        ?>

						<ul>
							<li class="col-xs-4">
								<a class="col-xs-12" href="<?php echo LANGPATH; ?><?php echo isset($index12_banners[0]['link']) ? $index12_banners[0]['link'] : ''; ?>"><img src="<?php echo STATICURL; ?>/simages/<?php echo isset($index12_banners[0]['image']) ? $index12_banners['0']['image'] : ''; ?>" class="ins_banner1"></a>
								<a class="col-xs-6" href="<?php echo LANGPATH; ?><?php echo isset($index12_banners[1]['link']) ? $index12_banners[1]['link'] : ''; ?>"><img src="<?php echo STATICURL; ?>/simages/<?php echo isset($index12_banners[1]['image']) ? $index12_banners[1]['image'] : ''; ?>" class="ins_banner2"></a>
								<a class="col-xs-6" href="<?php echo LANGPATH; ?><?php echo isset($index12_banners[2]['link']) ? $index12_banners[2]['link'] : ''; ?>"><img src="<?php echo STATICURL; ?>/simages/<?php echo isset($index12_banners[2]['image']) ? $index12_banners[2]['image'] : ''; ?>" class="ins_banner3"></a>
							</li>
							<li class="col-xs-4">
							<?php 
							if(isset($index6_banners))
							{
								foreach($index12_banners as $key => $values)
								{
										if($key >= 3 && $key <= 8)
										{
								 ?>
									<a class="col-xs-6" href="<?php echo LANGPATH; ?><?php echo isset($values['link']) ? $values['link'] : ''; ?>"><img src="<?php echo STATICURL; ?>/simages/<?php echo isset($values['image']) ? $values['image'] : ''; ?>" class="ins_banner<?php echo $key+1;?>"></a>
								<?php 
									   }
								}
							}
							 ?>
							</li>
							<li class="col-xs-4">
								<a class="col-xs-6" href="<?php echo LANGPATH; ?><?php echo isset($index12_banners[9]['link']) ? $index12_banners[9]['link'] : ''; ?>"><img src="<?php echo STATICURL; ?>/simages/<?php echo isset($index12_banners[9]['image']) ? $index12_banners[9]['image'] : ''; ?>" class="ins_banner10"></a>
								<a class="col-xs-6" href="<?php echo LANGPATH; ?><?php echo isset($index12_banners[10]['link']) ? $index12_banners[10]['link'] : ''; ?>"><img src="<?php echo STATICURL; ?>/simages/<?php echo isset($index12_banners[10]['image']) ? $index12_banners[10]['image'] : ''; ?>" class="ins_banner11"></a>
								<a class="col-xs-12" href="<?php echo LANGPATH; ?><?php echo isset($index12_banners[11]['link']) ? $index12_banners[11]['link'] : ''; ?>"><img src="<?php echo STATICURL; ?>/simages/<?php echo isset($index12_banners[11]['image']) ? $index12_banners[11]['image'] : ''; ?>" class="ins_banner12"></a>
							</li>
						</ul>
					</div>
            <?php
        	}

        	if($is_mobile)
        	{
				if(!empty($phonecatalog_banners))
				{
                    if(array_key_exists(6, $phonecatalog_banners))
                    {
				?>
				<div class="n-ad hidden-sm hidden-md hidden-lg">
					<a href="<?php echo LANGPATH; ?><?php echo $phonecatalog_banners[6]['link'];?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $phonecatalog_banners[6]['image']; ?>"></a>
				</div>
				<?php
					} 
				}
        	}

            if($is_mobile || $user_device == 'ipad')
            {
            ?>
						<div class="phone-also-like mt10 hidden-sm hidden-md hidden-lg">
							<div class="w-tit">
			                    <h2><?php echo $lists['You May Also Like']; ?></h2>
			                </div>
						    <div class="example-demo">
								<div class="gallery js-flickity" data-flickity-options='{ "wrapAround": true }'>
							<?php 
                                $cache = Cache::instance('memcache');
                                $indexsku = $cache->get('indexsku');
                                if(empty($indexsku))
                                {
                                    $indexsku = Kohana::config('sites.indexsku');                                     
                                }

								if(!empty($indexsku))
								{
									foreach ($indexsku as $key => $value) 
									{
										$proid1 = Product::get_productId_by_sku($value);
										$pro1 = Product::instance($proid1);
										$cover_image1 = Product::instance($proid1)->cover_image();
			                            $image_link1 = Image::link($cover_image1, 4);
			                        	$plink1 = Product::instance($proid1,LANGUAGE)->permalink();
										$k = $key + 1;
										$price1 = round($pro1->price(), 2);
								?>
						                <?php if($k % 2 ==1)
						                {    	
						                ?>
										<div class="gallery-cell">
						                    <ul>
						                <?php 
						            	}
						            	?>
						                        <li class="col-xs-6">
						                        	<a href="<?php echo $plink1;?>"><img src="<?php echo $image_link1;?>" class="phone_new_banner<?php echo $k;?>"></a>
						                        	<p><a href="<?php echo $plink1;?>"><?php echo $pro1->get('name'); ?></a></p>
						                        	<p><?php echo Site::instance()->price($price1, 'code_view'); ?></p>
						                        </li>
						                <?php if($k % 2 ==0)
						                { 
						                ?>
						                    </ul>
						                   </div>
						                <?php 
						            	}
						            	?>
						                
						        <?php								
									}
								}
								?>

								</div>
							</div>
						</div>
			<?php
			}
			?>			
        </div>
    </div>

            </div>
        </div>



