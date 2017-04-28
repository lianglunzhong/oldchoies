        <div class="site-content">
            <div class="main-container clearfix">
			<div class="container container-xs">
                
            <!-- Banner Start 2015.10.22 -->
			<div id="homeBigBanner" class="flexslider">
				<ul class="slides">
					<?php
	                	foreach ($banners as $banner){
	                    if (strpos($banner['link'], 'http://') >= 0 OR strpos($banner['link'], 'https://') >= 0) $link = $banner['link'];
	                    else $link = '/' . $banner['link'];
	                    if ($banner['map']) 
	                    	$map = 'Map' . $banner['id'];
	                    else $map = '';

	                    if($is_mobile)
	                    	$banner_src = STATICURL . '/simages/8_' . $banner['image'];
	                    else
	                    	$banner_src = STATICURL . '/simages/' . $banner['image']; 
                    ?>
					<li><a href="<?php echo $link; ?>"><img src="<?php echo $banner_src; ?>"  alt="<?php echo $banner['title']; ?>" /></a></li>
					<?php }?>
				</ul>
			</div>
			<!-- Banner End  2015.10.22 -->
            
  
            <?php
            if(!$is_mobile)
            {
            ?>
            <div class="index-fashion hidden-xs">
                <div class="fashion-top w-tit">
                    <h2><a href="/lookbook"><span><b>FASHION </b>BUYER'S SHOW</span></a></h2>
                </div>
                
                <div id="homeIndexFashion" class="flexslider">
                    <ul class="slides">
                    <?php
                    $num = 4;
                    $array_skus = explode("\n", trim($buyers_sku));
                    $sku_num = ceil(count($array_skus) / $num);
                    for($i = 0;$i < $sku_num;$i ++)
                    {
                    ?>
                        <li <?php if($i > 0) echo 'style="display:none;"' ?>>
                            <div class="row">
                                <ul>
                                <?php
                                for($j = $num * $i;$j < ($i + 1) * $num;$j ++)
                                {
                                    if(isset($array_skus[$j]))
                                    {
                                        $sku = trim($array_skus[$j]);
                                        $product_id = Product::get_productId_by_sku($sku);
                                        $plink = Product::instance($product_id)->permalink();
                                        $p = ($i+1) * $num -2;
                                        if($j >= $p)
                                            $col = 'f-sm-none';
                                        else
                                            $col = 'col-xs-6';
                                        ?>
                                        <li class="buys-show <?php echo $col; ?> col-sm-3">
                                            <a href="<?php echo $plink; ?>">
                                                <img width="270" src="<?php echo STATICURL; ?>/bimg/<?php echo $sku; ?>.jpg" />
                                                <img style="display:none;" class="img-hide" src="<?php echo image::link(Product::instance($product_id)->cover_image(), 1); ?>" />
                                            </a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                                </ul>
                            </div>
                        </li>
                    <?php
                    }
                    ?>
                    </ul>
                </div>
                
            </div>
            
            <div class="features">
                <div class="fashion-top w-tit">
                    <h2><a href=""><span class="mr5">CHOIES'</span><span><b> FEATURES</b></span> </a></h2>
                </div>
                <div class="phone-fashion-top w-tit">
                    <h2>CHOIES FEATURES</h2>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        <div class="brandbox">
                            <a href="<?php echo $index_banners[3]['link']; ?>">
                                <img src="<?php echo STATICURL; ?>/bimg/<?php echo $index_banners[3]['image']; ?>" alt="<?php echo $index_banners[3]['alt']; ?>" title="<?php echo $index_banners[3]['title']; ?>" />
                            </a>
                                                
                            <!-- <a href="<?php // echo $index_banners[4]['link']; ?>" class="name"><?php // echo $index_banners[4]['title']; ?></a> -->
                        </div>                              
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="brandbox">
                            <a href="<?php echo $index_banners[5]['link']; ?>">
                                <img src="<?php echo STATICURL; ?>/bimg/<?php echo $index_banners[5]['image']; ?>" alt="<?php echo $index_banners[5]['alt']; ?>" title="<?php echo $index_banners[5]['title']; ?>" />
                            </a>                            
                           <!--  <a href="<?php //echo $index_banners[6]['link']; ?>" class="name"><?php // echo $index_banners[6]['title']; ?></a> -->
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="brandbox">
                            <a href="<?php echo $index_banners[7]['link']; ?>">
                                <img src="<?php echo STATICURL; ?>/bimg/<?php echo $index_banners[7]['image']; ?>" alt="<?php echo $index_banners[7]['alt']; ?>" title="<?php echo $index_banners[7]['title']; ?>" />
                            </a>
                           <!--  <a href="<?php //echo $index_banners[8]['link']; ?>" class="name"><?php // echo $index_banners[8]['title']; ?></a> -->
                        </div>
                    </div>
                </div>
            </div>
            <?php
        	}
            else
            {
            ?>
            <!-- 2015.10.22 -->
			<table class="phone-hot">
				<tbody>
					<tr>
						<td class="col-xs-6"><a href="/choies-design-c-607"><img src="<?php echo STATICURL; ?>/assets/images/1512/home-phone1-12-1.jpg"></a></td>
						<td class="col-xs-6"><a href="/activity/flash_sale"><img src="<?php echo STATICURL; ?>/assets/images/1512/home-phone2-12-1.jpg"></a></td>
					</tr>
					<tr>
						<td class="col-xs-6"><a href="/knitwear-sweaters-c-619"><img src="<?php echo STATICURL; ?>/assets/images/phone-home3.jpg"></a></td>
						<td class="col-xs-6"><a href="/hottest-newbies-c-809"><img src="<?php echo STATICURL; ?>/assets/images/phone-home4.jpg"></a></td>
					</tr>
					<tr>
						<td class="col-xs-6"><a href="/coats-jackets-c-45"><img src="<?php echo STATICURL; ?>/assets/images/phone-home5.jpg"></a></td>
						<td class="col-xs-6"><a href="/party-dresses-c-205"><img src="<?php echo STATICURL; ?>/assets/images/phone-home6.jpg"></a></td>
					</tr>
				</tbody>
			</table>
			<!-- HIGHLY RECOMMEND TAB页切换 -->
			<div class="phone-recommend mt10">
				<h2 >HIGHLY RECOMMEND</h2>
				<div class="pr-tab">
					<nav>
						<ul class="clearfix JS-tab1 detail-tab">
				                <li class="fr current" ><span></span></li>
				                <li class="s" data_id="92" onclick="accept(this)"><span></span></li> 
				                <li class="t" data_id="616" onclick="accept(this)"><span></span></li>
				                <li class="f" data_id="99" onclick="accept(this)"><span></span></li> 
				                <li class="fi" data_id="149" onclick="accept(this)"><span></span></li>     
				            </ul>
				    </nav>
					<script>
					function accept(obj){
						var data_id= $(obj).attr("data_id");
						var class_id= $(obj).attr("class");
						var lan='';
						$.ajax({
							type:"post",
							url : '/site/ajax_accept',
							data: {data_id:data_id,lan:lan},
							dataType: "json",
                            beforeSend: function(){
                                $("#"+class_id).empty().append("<p><img src='<?php echo STATICURL; ?>/assets/images/gb_loading.gif' /></p>");
                            },
							success: function(data){
								var str='';
								$.each(data,function(i,item){
									str +="<li class='col-xs-4'>";
									str +="<a href="+item.plink+"><img src="+item.image+"></a>";
                                    if(item.orig_price>item.price){
									    str +="<p class='p-sale'>";
									    str +="<del>"+item.orig_price+"</del>"+item.price+"";
                                        str +="</p>";
									}else{
										str +="<p>"+item.price1+"</p>";
									}
									str +='</li>';
								})
                                $("#"+class_id).empty().append(str);
							}
						});						
					}
					</script>
				    <div class=" JS-tabcon1 detail-tabcon mt20">
				    	<div class="pr-01 bd JS-toggle-box hide" style="display:block;">
							<ul>								
								<?php 
					                $ready_shippeds = Site::instance()->ready_shippeds(45);
					                foreach ($ready_shippeds as $v){
					                    $product_id = $v['product_id'];
					                    $cover_image = Product::instance($product_id)->cover_image();
					                    $cataname = Catalog::instance($product_catalog)->get("name");
					                    $product_inf = Product::instance($product_id)->get();
					                    $plink = Product::instance($product_id)->permalink();
								?>									
								<li class="col-xs-4">
									<a href="<?php echo $plink;?>"><img src="<?php echo Image::link($cover_image, 1); ?>"></a>
									<?php
                                        $orig_price = round($product_inf['price'], 2);
                                        $price = round(Product::instance($product_id)->price(), 2);
                                        if ($orig_price > $price) {
                                    ?>
                                    <p class="p-sale">
                                        <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del>
                                        <?php echo Site::instance()->price($price, 'code_view'); ?>
                                    </p>
                                    <?php }else{echo '<p>'.Site::instance()->price($product_inf['price'], 'code_view').'</p>';}?>
								</li>
								<?php }?>
							</ul>
						</div>
						<div class="pr-02 bd JS-toggle-box hide">
							<ul id="s">
							
							</ul>
						</div>
						<div class="pr-03 bd JS-toggle-box hide">
							<ul id="t">							
								
							</ul>
						</div>
						<div class="pr-04 bd JS-toggle-box hide">
							<ul id="f">								
								
							</ul>
						</div>
						<div class="pr-05 bd JS-toggle-box hide">
							<ul id="fi">								
								
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- 2015.10.22 -->
			<?php
			}
			?>
								
        </div>
    </div>

            </div>
        </div>



