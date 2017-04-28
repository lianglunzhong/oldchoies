
<link rel="canonical" href="/<?php echo $catalog_link; ?>" />
<link type="text/css" rel="stylesheet" href="/css/common.css" media="all" />
<link type="text/css" rel="stylesheet" href="/css/easter-day-list.css" media="all" />
<link type="text/css" rel="stylesheet" href="/css/quickview.css" media="all" />


<?php

?>
<!-- main begin -->
<section id="main">
    <!-- crumbs -->
    <div class="grid">     
                <script>
                    // banner805 
                    $(function(){
                        $(".banner .bannerPic li").soChange({
                            //thumbObj:".banner .bannerBtn li",
                            botPrev:".banner .previous",
                            botNext:".banner .next",
                            botPrevslideTime:500,
                            changeTime:5000,
                            slideTime:500
                        });
                    });
                </script>
                <?php

                ?>

                <script>
                    // banner805 
                    $(function(){
                        $(".banner .bannerPic li").soChange({
                            //thumbObj:".banner .bannerBtn li",
                            botPrev:".banner .previous",
                            botNext:".banner .next",
                            botPrevslideTime:500,
                            changeTime:5000,
                            slideTime:500
                        });
                    });
                </script>
                
                <script>
                    // banner805 
                    $(function(){
                        $(".banner .bannerPic li").soChange({
                            //thumbObj:".banner .bannerBtn li",
                            botPrev:".banner .previous",
                            botNext:".banner .next",
                            botPrevslideTime:500,
                            changeTime:5000,
                            slideTime:500
                        });
                    });
                </script>
                
        <!-- aside -->


        
        <div class="flr mt20"><?php echo $pagination; ?></div>
        <div class="fix"></div>
		        <div class="easter-day-top">
        	<p><img src="/images/activity/listbanner_ru.jpg" width="1024" height="300"></p>
            <div class="easter-day-filter">
                <p class="filter-instruction">Купить По Пасхальным Яйцам</p>
                <ul class="filter-main detail-tab fix">
                    <li class=" current" style="width: 137px;margin: 45px 0 -30px 80px;" id="Blue">Синее</li>
                    <li class="" style="width: 137px;margin: 45px 0 -1px 0;" id="Green">Зеленое</li>
                    <li class="" style="width: 137px;margin: 45px 0 -1px 0;" id="Pink">Розовое</li>
                    <li class="" style="width: 137px;margin: 45px 0 -1px 0;" id="Yellow">Желтое</li>
                    <li class="" style="width: 137px;margin: 45px 0 -1px 0;" id="White">Белое</li>
                    <li class="" style="width: 137px;margin: 45px 0 -1px 0;" id="Purple">Фиолетовое </li>
                    <p style="left: 78px;">
                        <b></b>
                    </p>
                </ul>
            
            
            </div>    
        </div>	
        <div class="pro-list blue" id="bluediv">
            <ul class="cf">
                <?php
     
			 foreach ($weekly1 as $key => $w){   
			      $product = Product::instance($w['product_id'], LANGUAGE);
				 
                    if(!$product->get('id'))
                        continue; 
					$product_inf = $product->get();
                    $link = $product->permalink();
                    $orig_price = $product->get('price');
                    $price = $product->price();
                    $off = round(($orig_price - $price) / $orig_price, 2) * 100;
                    $c_class = str_replace(array(' ', '/', '&'), array('-', '-', '-'), $w['catalog']);
                    $end_day = strtotime(date('Y-m-d', $w['expired']) . ' - 1 month');
                    $attributes = $product->get('attributes');					
					
					
					
		
                    ?>
				<li class="pro-item">
					<div class="overlay"></div>
					<div class="pic">
						<a target="_blank" href="<?php echo $link; ?>">
							<img src="<?php echo Image::link($product->cover_image(), 2); ?>" alt="">
						</a>

						<span class="icon-color"></span>
					</div>
					<h6 class="title">
						<i class="icon icon-pick"></i><a target="_blank" href="<?php echo $link; ?>"><?php echo $product->get('name'); ?></a>
					</h6>
					<p class="price">
                            <?php
							
                            $orig_price = round($product_inf['price'], 2);
                            $price = round($price, 2);
                            if ($orig_price > $price)
                            {
                                ?>
                                <span class="priceold"><?php echo Site::instance()->price($orig_price, 'code_view'); ?></span>
                                <span class="pricenew"><?php echo Site::instance()->price($price, 'code_view'); ?></span>
                                <?php
                            } 
                            else
                            {
                                ?>
                                <span class="pricenew"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                <?php
                            }
                            ?>
                        </p>  
					<div class="reviews">
                        <?php
                        if(isset($review_statistics[$w['product_id']]))
                        {
                            $review = $review_statistics[$w['product_id']];
                            $integer = floor($review['rating']);
                            $decimal = $review['rating'] - $integer;
                        ?>
                        <a target="_blank" href="<?php echo $link; ?>#review_list">
                            <?php
                            for($r = 1;$r <= $integer;$r ++)
                            {
                            ?>
                                <i class="fa fa-star"></i>
                            <?php
                            }
                            if($decimal > 0)
                            {
                            ?>
                                <i class="fa fa-star-half-full"></i>
                            <?php
                            }
                            ?>
                            (<?php echo $review['quantity']; ?>)
                            </a>
                        <?php
                        }
                        ?>
						<!--<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star-half-full"></i>
						(34)	-->
					</div>
					<a href="#" id="<?php echo $product->get('id'); ?>" class="quick_view JS_shows1"><span class="btn-qv">Quick View</span></a>
					<div class="add-wish">
					
					  <?php
					  $product_id = $product->get('id');
                        if(in_array(array('product_id' => $product_id), $wishlists))
                        {
                            ?>
						
                        <i class="fa fa-heart add_wishlist2"></i>
						
                            <?php
                        }
                        else
                        {   ?>
                        <a class="add_to_wishlist" data-product="<?php echo $product->get('id'); ?>">
                            <span>Add to wishlist</span>
                            <i class="fa fa-heart add_wishlist" id="wish_<?php echo $product->get('id'); ?>"></i>
                        </a>
                        <?php
                        }
                        ?>

						
					</div>
                        <div class="sign-warp">
                            <span class="sign-close">
                                <i class="fa fa-times-circle fa-lg"></i>
                            </span>
                            <div class="wishlist_success">
                                <p class="text" style="border:medium none;"></p>
                              <p class="wish">
					<i class="fa fa-heart"></i>
						Wishlist
							</p>
                            </div>
                        </div>
				</li>
				<?php }?>
            </ul>
		<div class="pager">
			<?php echo $pagination1; ?>
		</div>
        </div>
		
        <div class="pro-list green" id="greendiv" style="display:none;">
            <ul class="cf">
                <?php
     
			 foreach ($weekly2 as $key => $w){   
			      $product = Product::instance($w['product_id'], LANGUAGE);
				 
                    if(!$product->get('id'))
                        continue; 
					$product_inf = $product->get();
                    $link = $product->permalink();
                    $orig_price = $product->get('price');
                    $price = $product->price();
                    $off = round(($orig_price - $price) / $orig_price, 2) * 100;
                    $c_class = str_replace(array(' ', '/', '&'), array('-', '-', '-'), $w['catalog']);
                    $end_day = strtotime(date('Y-m-d', $w['expired']) . ' - 1 month');
                    $attributes = $product->get('attributes');					
					
					
					
		
                    ?>
				<li class="pro-item">
					<div class="overlay"></div>
					<div class="pic">
						<a target="_blank" href="<?php echo $link; ?>">
							<img src="<?php echo Image::link($product->cover_image(), 2); ?>" alt="">
						</a>

						<span class="icon-color"></span>
					</div>
					<h6 class="title">
						<i class="icon icon-pick"></i><a target="_blank" href="<?php echo $link; ?>"><?php echo $product->get('name'); ?></a>
					</h6>
					<p class="price">
                            <?php
							
                            $orig_price = round($product_inf['price'], 2);
                            $price = round($price, 2);
                            if ($orig_price > $price)
                            {
                                ?>
                                <span class="priceold"><?php echo Site::instance()->price($orig_price, 'code_view'); ?></span>
                                <span class="pricenew"><?php echo Site::instance()->price($price, 'code_view'); ?></span>
                                <?php
                            } 
                            else
                            {
                                ?>
                                <span class="pricenew"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                <?php
                            }
                            ?>
                        </p>
					<div class="reviews">
                        <?php
                        if(isset($review_statistics[$w['product_id']]))
                        {
                            $review = $review_statistics[$w['product_id']];
                            $integer = floor($review['rating']);
                            $decimal = $review['rating'] - $integer;
                        ?>
                        <a target="_blank" href="<?php echo $link; ?>#review_list">
                            <?php
                            for($r = 1;$r <= $integer;$r ++)
                            {
                            ?>
                                <i class="fa fa-star"></i>
                            <?php
                            }
                            if($decimal > 0)
                            {
                            ?>
                                <i class="fa fa-star-half-full"></i>
                            <?php
                            }
                            ?>
                            (<?php echo $review['quantity']; ?>)
                            </a>
                        <?php
                        }
                        ?>
						<!--<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star-half-full"></i>
						(34)	-->
					</div>
					<a href="#" id="<?php echo $product->get('id'); ?>" class="quick_view JS_shows1"><span class="btn-qv">Quick View</span></a>
					<div class="add-wish">
					
					  <?php
					  $product_id = $product->get('id');
                        if(in_array(array('product_id' => $product_id), $wishlists))
                        {
                            ?>
						<p class="text">
                        <i class="fa fa-heart add_wishlist2"></i>
						</p>
                            <?php
                        }
                        else
                        {   ?>
                        <a class="add_to_wishlist" data-product="<?php echo $product->get('id'); ?>">
                            <span>Add to wishlist</span>
                            <i class="fa fa-heart add_wishlist" id="wish_<?php echo $product->get('id'); ?>"></i>
                        </a>
                        <?php
                        }
                        ?>

					
					</div>
                        <div class="sign-warp">
                            <span class="sign-close">
                                <i class="fa fa-times-circle fa-lg"></i>
                            </span>
                            <div class="wishlist_success">
                                <p class="text" style="border:medium none;"></p>
                                                            <p class="wish">
					<i class="fa fa-heart"></i>
						Wishlist
							</p>
                            </div>
                        </div>
				</li>
				<?php }?>
            </ul>
				<div class="pager">
			<?php echo $pagination2; ?>
		</div>
        </div>
		
        <div class="pro-list pink"  id="pinkdiv" style="display:none;">
            <ul class="cf">
                <?php
     
			 foreach ($weekly3 as $key => $w){   
			      $product = Product::instance($w['product_id'], LANGUAGE);
				 
                    if(!$product->get('id'))
                        continue; 
					$product_inf = $product->get();
                    $link = $product->permalink();
                    $orig_price = $product->get('price');
                    $price = $product->price();
                    $off = round(($orig_price - $price) / $orig_price, 2) * 100;
                    $c_class = str_replace(array(' ', '/', '&'), array('-', '-', '-'), $w['catalog']);
                    $end_day = strtotime(date('Y-m-d', $w['expired']) . ' - 1 month');
                    $attributes = $product->get('attributes');					
					
					
					
		
                    ?>
				<li class="pro-item">
					<div class="overlay"></div>
					<div class="pic">
						<a target="_blank" href="<?php echo $link; ?>">
							<img src="<?php echo Image::link($product->cover_image(), 2); ?>" alt="">
						</a>

						<span class="icon-color"></span>
					</div>
					<h6 class="title">
						<i class="icon icon-pick"></i><a target="_blank" href="<?php echo $link; ?>"><?php echo $product->get('name'); ?></a>
					</h6>
					<p class="price">
                            <?php
							
                            $orig_price = round($product_inf['price'], 2);
                            $price = round($price, 2);
                            if ($orig_price > $price)
                            {
                                ?>
                                <span class="priceold"><?php echo Site::instance()->price($orig_price, 'code_view'); ?></span>
                                <span class="pricenew"><?php echo Site::instance()->price($price, 'code_view'); ?></span>
                                <?php
                            } 
                            else
                            {
                                ?>
                                <span class="pricenew"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                <?php
                            }
                            ?>
                        </p>
					<div class="reviews">
                        <?php
                        if(isset($review_statistics[$w['product_id']]))
                        {
                            $review = $review_statistics[$w['product_id']];
                            $integer = floor($review['rating']);
                            $decimal = $review['rating'] - $integer;
                        ?>
                        <a target="_blank" href="<?php echo $link; ?>#review_list">
                            <?php
                            for($r = 1;$r <= $integer;$r ++)
                            {
                            ?>
                                <i class="fa fa-star"></i>
                            <?php
                            }
                            if($decimal > 0)
                            {
                            ?>
                                <i class="fa fa-star-half-full"></i>
                            <?php
                            }
                            ?>
                            (<?php echo $review['quantity']; ?>)
                            </a>
                        <?php
                        }
                        ?>
						<!--<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star-half-full"></i>
						(34)	-->
					</div>
					<a href="#" id="<?php echo $product->get('id'); ?>" class="quick_view JS_shows1"><span class="btn-qv">Quick View</span></a>
					<div class="add-wish">
					
					  <?php
					  $product_id = $product->get('id');
                        if(in_array(array('product_id' => $product_id), $wishlists))
                        {
                            ?>
						<p class="text">
                        <i class="fa fa-heart add_wishlist2"></i>
						</p>
                            <?php
                        }
                        else
                        {   ?>
                        <a class="add_to_wishlist" data-product="<?php echo $product->get('id'); ?>">
                            <span>Add to wishlist</span>
                            <i class="fa fa-heart add_wishlist" id="wish_<?php echo $product->get('id'); ?>"></i>
                        </a>
                        <?php
                        }
                        ?>

					
					</div>
                        <div class="sign-warp">
                            <span class="sign-close">
                                <i class="fa fa-times-circle fa-lg"></i>
                            </span>
                            <div class="wishlist_success">
                                <p class="text" style="border:medium none;"></p>
                                                            <p class="wish">
					<i class="fa fa-heart"></i>
						Wishlist
							</p>
                            </div>
                        </div>
				</li>
				<?php }?>
            </ul>
				<div class="pager">
			<?php echo $pagination3; ?>
		</div>
        </div>

        <div class="pro-list yellow" id="yellowdiv" style="display:none;">
		
		
            <ul class="cf">
                <?php
     
			 foreach ($weekly4 as $key => $w){   
			      $product = Product::instance($w['product_id'], LANGUAGE);
				 
                    if(!$product->get('id'))
                        continue; 
					$product_inf = $product->get();
                    $link = $product->permalink();
                    $orig_price = $product->get('price');
                    $price = $product->price();
                    $off = round(($orig_price - $price) / $orig_price, 2) * 100;
                    $c_class = str_replace(array(' ', '/', '&'), array('-', '-', '-'), $w['catalog']);
                    $end_day = strtotime(date('Y-m-d', $w['expired']) . ' - 1 month');
                    $attributes = $product->get('attributes');					
					
					
					
		
                    ?>
				<li class="pro-item">
					<div class="overlay"></div>
					<div class="pic">
						<a target="_blank" href="<?php echo $link; ?>">
							<img src="<?php echo Image::link($product->cover_image(), 2); ?>" alt="">
						</a>

						<span class="icon-color"></span>
					</div>
					<h6 class="title">
						<i class="icon icon-pick"></i><a target="_blank" href="<?php echo $link; ?>"><?php echo $product->get('name'); ?></a>
					</h6>
					<p class="price">
                            <?php
							
                            $orig_price = round($product_inf['price'], 2);
                            $price = round($price, 2);
                            if ($orig_price > $price)
                            {
                                ?>
                                <span class="priceold"><?php echo Site::instance()->price($orig_price, 'code_view'); ?></span>
                                <span class="pricenew"><?php echo Site::instance()->price($price, 'code_view'); ?></span>
                                <?php
                            } 
                            else
                            {
                                ?>
                                <span class="pricenew"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                <?php
                            }
                            ?>
                        </p>
					<div class="reviews">
                        <?php
                        if(isset($review_statistics[$w['product_id']]))
                        {
                            $review = $review_statistics[$w['product_id']];
                            $integer = floor($review['rating']);
                            $decimal = $review['rating'] - $integer;
                        ?>
                        <a target="_blank" href="<?php echo $link; ?>#review_list">
                            <?php
                            for($r = 1;$r <= $integer;$r ++)
                            {
                            ?>
                                <i class="fa fa-star"></i>
                            <?php
                            }
                            if($decimal > 0)
                            {
                            ?>
                                <i class="fa fa-star-half-full"></i>
                            <?php
                            }
                            ?>
                            (<?php echo $review['quantity']; ?>)
                            </a>
                        <?php
                        }
                        ?>
						<!--<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star-half-full"></i>
						(34)	-->
					</div>
					<a href="#" id="<?php echo $product->get('id'); ?>" class="quick_view JS_shows1"><span class="btn-qv">Quick View</span></a>
					<div class="add-wish">
					
					  <?php
					  $product_id = $product->get('id');
                        if(in_array(array('product_id' => $product_id), $wishlists))
                        {
                            ?>
						<p class="text">
                        <i class="fa fa-heart add_wishlist2"></i>
						</p>
                            <?php
                        }
                        else
                        {   ?>
                        <a class="add_to_wishlist" data-product="<?php echo $product->get('id'); ?>">
                            <span>Add to wishlist</span>
                            <i class="fa fa-heart add_wishlist" id="wish_<?php echo $product->get('id'); ?>"></i>
                        </a>
                        <?php
                        }
                        ?>

						<!--<i class="fa fa-heart"></i>	-->
					</div>
                        <div class="sign-warp">
                            <span class="sign-close">
                                <i class="fa fa-times-circle fa-lg"></i>
                            </span>
                            <div class="wishlist_success">
                                <p class="text" style="border:medium none;"></p>
                                                            <p class="wish">
					<i class="fa fa-heart"></i>
						Wishlist
							</p>
                            </div>
                        </div>
				</li>
				<?php }?>
            </ul>
				<div class="pager">
			<?php echo $pagination4; ?>
		</div>
        </div>	

        <div class="pro-list white" id="whitediv" style="display:none;">
            <ul class="cf">
                <?php
     
			 foreach ($weekly5 as $key => $w){   
			      $product = Product::instance($w['product_id'], LANGUAGE);
				 
                    if(!$product->get('id'))
                        continue; 
					$product_inf = $product->get();
                    $link = $product->permalink();
                    $orig_price = $product->get('price');
                    $price = $product->price();
                    $off = round(($orig_price - $price) / $orig_price, 2) * 100;
                    $c_class = str_replace(array(' ', '/', '&'), array('-', '-', '-'), $w['catalog']);
                    $end_day = strtotime(date('Y-m-d', $w['expired']) . ' - 1 month');
                    $attributes = $product->get('attributes');					
					
					
					
		
                    ?>
				<li class="pro-item">
					<div class="overlay"></div>
					<div class="pic">
						<a target="_blank" href="<?php echo $link; ?>">
							<img src="<?php echo Image::link($product->cover_image(), 2); ?>" alt="">
						</a>

						<span class="icon-color"></span>
					</div>
					<h6 class="title">
						<i class="icon icon-pick"></i><a target="_blank" href="<?php echo $link; ?>"><?php echo $product->get('name'); ?></a>
					</h6>
					<p class="price">
                            <?php
							
                            $orig_price = round($product_inf['price'], 2);
                            $price = round($price, 2);
                            if ($orig_price > $price)
                            {
                                ?>
                                <span class="priceold"><?php echo Site::instance()->price($orig_price, 'code_view'); ?></span>
                                <span class="pricenew"><?php echo Site::instance()->price($price, 'code_view'); ?></span>
                                <?php
                            } 
                            else
                            {
                                ?>
                                <span class="pricenew"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                <?php
                            }
                            ?>
                        </p>
					<div class="reviews">
                        <?php
                        if(isset($review_statistics[$w['product_id']]))
                        {
                            $review = $review_statistics[$w['product_id']];
                            $integer = floor($review['rating']);
                            $decimal = $review['rating'] - $integer;
                        ?>
                        <a target="_blank" href="<?php echo $link; ?>#review_list">
                            <?php
                            for($r = 1;$r <= $integer;$r ++)
                            {
                            ?>
                                <i class="fa fa-star"></i>
                            <?php
                            }
                            if($decimal > 0)
                            {
                            ?>
                                <i class="fa fa-star-half-full"></i>
                            <?php
                            }
                            ?>
                            (<?php echo $review['quantity']; ?>)
                            </a>
                        <?php
                        }
                        ?>
						<!--<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star-half-full"></i>
						(34)	-->
					</div>
					<a href="#" id="<?php echo $product->get('id'); ?>" class="quick_view JS_shows1"><span class="btn-qv">Quick View</span></a>
					<div class="add-wish">
					
					  <?php
					  $product_id = $product->get('id');
                        if(in_array(array('product_id' => $product_id), $wishlists))
                        {
                            ?>
						<p class="text">
                        <i class="fa fa-heart add_wishlist2"></i>
						</p>
                            <?php
                        }
                        else
                        {   ?>
                        <a class="add_to_wishlist" data-product="<?php echo $product->get('id'); ?>">
                            <span>Add to wishlist</span>
                            <i class="fa fa-heart add_wishlist" id="wish_<?php echo $product->get('id'); ?>"></i>
                        </a>
                        <?php
                        }
                        ?>

						<!--<i class="fa fa-heart"></i>	-->
					</div>
                        <div class="sign-warp">
                            <span class="sign-close">
                                <i class="fa fa-times-circle fa-lg"></i>
                            </span>
                            <div class="wishlist_success">
                                <p class="text" style="border:medium none;"></p>
                                                            <p class="wish">
					<i class="fa fa-heart"></i>
						Wishlist
							</p>
                            </div>
                        </div>
				</li>
				<?php }?>
            </ul>
					<div class="pager">
			<?php echo $pagination5; ?>
		</div>
        </div>		
		
		 <div class="pro-list purple" id="purplediv" style="display:none;">
            <ul class="cf">
                <?php
     
			 foreach ($weekly6 as $key => $w){   
			      $product = Product::instance($w['product_id'], LANGUAGE);
				 
                    if(!$product->get('id'))
                        continue; 
					$product_inf = $product->get();
                    $link = $product->permalink();
                    $orig_price = $product->get('price');
                    $price = $product->price();
                    $off = round(($orig_price - $price) / $orig_price, 2) * 100;
                    $c_class = str_replace(array(' ', '/', '&'), array('-', '-', '-'), $w['catalog']);
                    $end_day = strtotime(date('Y-m-d', $w['expired']) . ' - 1 month');
                    $attributes = $product->get('attributes');					
					
					
					
		
                    ?>
				<li class="pro-item">
					<div class="overlay"></div>
					<div class="pic">
						<a target="_blank" href="<?php echo $link; ?>">
							<img src="<?php echo Image::link($product->cover_image(), 2); ?>" alt="">
						</a>

						<span class="icon-color"></span>
					</div>
					<h6 class="title">
						<i class="icon icon-pick"></i><a target="_blank" href="<?php echo $link; ?>"><?php echo $product->get('name'); ?></a>
					</h6>
					<p class="price">
                            <?php
							
                            $orig_price = round($product_inf['price'], 2);
                            $price = round($price, 2);
                            if ($orig_price > $price)
                            {
                                ?>
                                <span class="priceold"><?php echo Site::instance()->price($orig_price, 'code_view'); ?></span>
                                <span class="pricenew"><?php echo Site::instance()->price($price, 'code_view'); ?></span>
                                <?php
                            } 
                            else
                            {
                                ?>
                                <span class="pricenew"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                <?php
                            }
                            ?>
                        </p>
					<div class="reviews">
                        <?php
                        if(isset($review_statistics[$w['product_id']]))
                        {
                            $review = $review_statistics[$w['product_id']];
                            $integer = floor($review['rating']);
                            $decimal = $review['rating'] - $integer;
                        ?>
                        <a target="_blank" href="<?php echo $link; ?>#review_list">
                            <?php
                            for($r = 1;$r <= $integer;$r ++)
                            {
                            ?>
                                <i class="fa fa-star"></i>
                            <?php
                            }
                            if($decimal > 0)
                            {
                            ?>
                                <i class="fa fa-star-half-full"></i>
                            <?php
                            }
                            ?>
                            (<?php echo $review['quantity']; ?>)
                            </a>
                        <?php
                        }
                        ?>
						<!--<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star-half-full"></i>
						(34)	-->
					</div>
					<a href="#" id="<?php echo $product->get('id'); ?>" class="quick_view JS_shows1"><span class="btn-qv">Quick View</span></a>
					<div class="add-wish">
					
					  <?php
					  $product_id = $product->get('id');
                        if(in_array(array('product_id' => $product_id), $wishlists))
                        {
                            ?>
						<p class="text">
                        <i class="fa fa-heart add_wishlist2"></i>
						</p>
                            <?php
                        }
                        else
                        {   ?>
                        <a class="add_to_wishlist" data-product="<?php echo $product->get('id'); ?>">
                            <span>Add to wishlist</span>
                            <i class="fa fa-heart add_wishlist" id="wish_<?php echo $product->get('id'); ?>"></i>
                        </a>
                        <?php
                        }
                        ?>

						<!--<i class="fa fa-heart"></i>	-->
					</div>
                        <div class="sign-warp">
                            <span class="sign-close">
                                <i class="fa fa-times-circle fa-lg"></i>
                            </span>
                            <div class="wishlist_success">
                                <p class="text" style="border:medium none;"></p>
                                                            <p class="wish">
					<i class="fa fa-heart"></i>
						Wishlist
							</p>
                            </div>
                        </div>
				</li>
				<?php }?>
            </ul>
				<div class="pager">
			<?php echo $pagination6; ?>
		</div>
        </div>
		</div>
        <div class="flr"><?php echo $pagination; ?></div>

        <br><article class="product_reviews" id="alsoview" style="display:none">
        <div class="w_tit layout"><h2>Recommended Products</h2></div>
        <div class="box-dibu1">
        <!-- Template for rendering recommendations -->
        <script type="text/html" id="simple-tmpl" >
        <![CDATA[
            {{ for (var i=0; i < SC.page.products.length; i++) { }}
                {{ if(i==0){ }}
                <div class="hide-box1_0"><ul>
                {{ }else if(i%6==0){ }}
                <div class="hide-box1_{{= i/6 }} hide1"><ul>
                {{ } }}
              {{ var p = SC.page.products[i]; }}
              <li data-scarabitem="{{= p.id }}" style="display: inline-block" class="rec-item">
                 <a href="{{=p.plink}}" id="em{{= p.id }}link">
                  <img src="{{=p.image}}" class="rec-image">
                </a>
                <p class="price"><b id="em{{= p.id }}price">${{=p.price}}</b></p>
              </li>
                {{ if(i==5 || i==11 || i==17 || i==24){ }}
                </ul></div>
                {{ } }}
            {{ } }} 
        ]]>
        </script>
        <div id="personal-recs"></div>
 
            <div class="box-current1">
              <ul>
                <li class="on"></li>
                <li id="circle1"></li>
                <li id="circle2"></li>
                <li id="circle3"></li>
              </ul>
            </div>
        </div>
        </article>
        <script type="text/javascript">
        var f=0;
        var t1;
        var tc1;
        $(function(){
            $(".box-current1 li").hover(function(){   
                $(this).addClass("on").siblings().removeClass("on");
                var c=$(".box-current1 li").index(this);
                $(".hide-box1_0,.hide-box1_1,.hide-box1_2,.hide-box1_3").hide();
                $(".hide-box1_"+c).fadeIn(150); 
                f=c; 
            })
        })
        </script>
        </div>
</section>
<?php echo View::factory(LANGPATH . '/quickview'); ?>
<div class="mybag hide" id="mybag" style="position: fixed;top: 10px;right: 140px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border-style: solid;border-width: 8px 4px 4px;">
    <div class="add_tit" style="margin-top:0px;">Success! Item Added To BAG</div>
    <div class="order order_addtobag">
        <ul id="bag_items">
            <li>
            </li>
        </ul>
    </div>
    <div class="mybagButton"><a href="<?php echo LANGPATH; ?>/cart/view" id="checkout1" class="allbtn btn-chk1">&nbsp;</a></div>
</div>

<!-- JS_popwincon2 -->
<div class="JS_popwincon2 popwincon w_signup hide">
    <a class="JS_close3 close_btn3"></a>
    <div class="fix" id="sign_in_up">
        <div class="left" style="width:320px;margin-right:30px;padding-right:30px;">
            <h3>CHOIES Member Sign In</h3>
            <div id="customer_pid" style="display:none;"></div>
            <form action="#" method="post" class="signin_form sign_form form" id="form_login">
                <ul>
                    <li>
                        <label>Email address: </label>
                        <input type="text" value="" name="email" class="text" id="email1" />
                    </li>
                    <li>
                        <label>Password: </label>
                        <input type="password" value="" name="password" class="text" maxlength="16" id="password1" />
                    </li>
                    <li><input type="submit" value="Sign In" name="submit" class="btn btn40" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">Forgot password?</a></li>
                    <li>
                        <?php
                        $page = $plink;
                        $facebook = new facebook();
                        $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                        ?>
                        <a href="<?php echo $loginUrl; ?>" class="facebook_btn"></a>
                    </li>
                </ul>
            </form>
        </div>
        <div class="right">
            <h3>CHOIES Member Sign Up</h3>
            <form action="#" method="post" class="signup_form sign_form form" id="form_register">
                <ul>
                    <li>
                        <label>Email address: </label>
                        <input type="text" value="" name="email" class="text" id="email2" />
                    </li>
                    <li>
                        <label>Password: </label>
                        <input type="password" value="" name="password" class="text" id="password2" maxlength="16" />
                    </li>
                    <li>
                        <label>Confirm password: </label>
                        <input type="password" value="" name="password_confirm" id="password_confirm" class="text" maxlength="16" />
                    </li>
                    <li><input type="submit" value="Sign Up" name="submit" class="btn btn40" /></li>
                </ul>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        // signin_form 
        $(".signin_form").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 5,
                    maxlength:20
                }
            },
            messages: {
                email:{
                    required:"Please provide an email.",
                    email:"Please enter a valid email address."
                },
                password: {
                    required: "Please provide a password.",
                    minlength: "Your password must be at least 5 characters long.",
                    maxlength: "The password exceeds maximum length of 20 characters."
                }
            }
        });

        // signup_form 
        $(".signup_form").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 5,
                    maxlength:20
                },
                password_confirm: {
                    required: true,
                    minlength: 5,
                    maxlength:20,
                    equalTo: "#password2"
                }
            },
            messages: {
                email:{
                    required:"Please provide an email.",
                    email:"Please enter a valid email address."
                },
                password: {
                    required: "Please provide a password.",
                    minlength: "Your password must be at least 5 characters long.",
                    maxlength:"The password exceeds maximum length of 20 characters."
                },
                password_confirm: {
                    required: "Please provide a password.",
                    minlength: "Your password must be at least 5 characters long.",
                    maxlength:"The password exceeds maximum length of 20 characters.",
                    equalTo: "Please enter the same password as above."
                }
            }
        });
    </script>
</div>

<script type="text/javascript" src="/js/list.js"></script>

<script type="text/javascript">
    $(function(){
        $(".add_to_wishlist").live('click', function(){
            var pid = $(this).attr('data-product');
            var _proItem = $(this).parents(".pro-item");
            $.ajax({
                url:'/customer/ajax_login1',
                type:'POST',
                dataType:'json',
                data:{},
                success:function(res){
                    if(res != 0)
                    {
                        $.ajax({
                            url:'<?php echo LANGPATH; ?>/wishlist/ajax_add',
                            type:'POST',
                            dataType: "json",
                            data:{
                                product_id: pid,
                            },
                            success:function(result){
                                if(result.success)
                                {
                                    $("#wish_" + pid).parent().find('span').text('');
                                    $("#wish_" + pid).attr('class', 'fa fa-heart add_wishlist2')
                                    _proItem.find(".overlay").show();
                                    _proItem.find(".sign-warp").show();
                                    _proItem.find('.sign-warp').find('.wishlist_success').find('.text').text(result.message);
                                }
                                else
                                {
                                    alert(result.message);
                                }
                            }
                        });
                    }
                    else
                    {
                        $("#customer_pid").text(pid);
                        var top = getScrollTop();
                        top = top - 35;
                        $('body').append('<div class="JS_filter2 opacity"></div>');
                        $('.JS_popwincon2').css({
                            "top": top, 
                            "position": 'absolute'
                        });
                        $('.JS_popwincon2').appendTo('body').fadeIn(320);
                        $('.JS_popwincon2').show();
                    }
                }
            });
            return false;
        })

        $(".pro-item .add-wish .add_wishlist2").live('click', function() {
            return false;
        });

        $(".JS_popwinbtn2").click(function(){
            var product_id = $(this).attr('title');
            $("#customer_pid").text(product_id);
        })

        $("#form_login").submit(function(){
            var email = $("#email1").val();
            var password = $("#password1").val();
            var pid = $("#customer_pid").text();
            $.ajax({
                url:'<?php echo LANGPATH; ?>/customer/ajax_login',
                type:'POST',
                dataType: "json",
                data:{
                    email: email,
                    password: password,
                },
                success:function(rs){
                    if(rs.success)
                    {
                        $.ajax({
                            url:'<?php echo LANGPATH; ?>/wishlist/ajax_add',
                            type:'POST',
                            dataType: "json",
                            data:{
                                product_id: pid,
                            },
                            success:function(result){
                                if(result.success == 1)
                                {
                                    alert(result.message);
                                    $("#wish_" + pid).parent().find('span').text('');
                                    $("#wish_" + pid).attr('class', 'fa fa-heart add_wishlist2');
                                    $(".wishlist_success").show();
                                    $(".JS_filter2").remove();
                                    $(".JS_popwincon2").fadeOut(160);
                                    $(".overlay").hide();
                                    $(".sign-warp").hide();
                                }
                                else
                                {
                                    alert(result.message);
                                }
                            }
                        });
                        return false;
                    }
                    else
                    {
                        alert(rs.message);
                    }
                }
            });
            return false;
        })

        $("#form_register").submit(function(){
            var email = $("#email2").val();
            var password = $("#password2").val();
            var password_confirm = $("#password_confirm").val();
            var pid = $("#customer_pid").text();
            $.ajax({
                url:'<?php echo LANGPATH; ?>/customer/ajax_register',
                type:'POST',
                dataType: "json",
                data:{
                    email: email,
                    password: password,
                    confirm_password: password_confirm,
                },
                success:function(rs){
                    if(rs.success)
                    {
                        $.ajax({
                            url:'<?php echo LANGPATH; ?>/wishlist/ajax_add',
                            type:'POST',
                            dataType: "json",
                            data:{
                                product_id: pid,
                            },
                            success:function(result){
                                if(result.success == 1)
                                {
                                    alert(result.message);
                                    $("#wish_" + pid).parent().find('span').text('');
                                    $("#wish_" + pid).attr('class', 'fa fa-heart add_wishlist2');
                                    $(".wishlist_success").show();
                                    $(".JS_filter2").remove();
                                    $(".JS_popwincon2").fadeOut(160);
                                    $(".overlay").hide();
                                    $(".sign-warp").hide();
                                }
                                else
                                {
                                    alert(result.message);
                                }
                            }
                        });
                        return false;
                    }
                    else
                    {
                        alert(rs.message);
                    }
                }
            });
            return false;
        })
    })
</script>

<script type="text/javascript">
    $(function(){
        //pagination locate to 'Sort By:'
        $(".page a").click(function(){
            var link = $(this).attr('href');
            if(link)
                location.href = link + '#catalog_filter';
            return false;
        })

        $(".btn_size input").live("click",function(){
            var qty = $(this).attr('title');
            if(qty)
                $("#only_left").html('Only '+qty+' Left!');
        });
        $("#formAdd").submit(function(){
            $.post(
                '/cart/ajax_add',
                {
                    id: $('#product_id').val(),
                    type: $('#product_type').val(),
                    size: $('.s-size').val(),
                    color: $('.s-color').val(),
                    attrtype: $('.s-type').val(),
                    quantity: $('#count_1').val()
                },
                function(product)
                {
                    var count = 0;
                    var cart_view = '';
                    var cart_view1 = '';
                    var key = 0;
                    for(var p in product)
                    {
                        if(key == 0)
                        {
                            cart_view = '\
                            <a href="'+product[p]['link']+'"><img src="'+product[p]['image']+'" alt="'+product[p]['name']+'" /></a>\
                                <div class="right">\
                                    <a class="name" href="'+product[p]['link']+'">'+product[p]['name']+'</a>\
                                    <p>Item# : '+product[p]['sku']+'</p>\
                                    <p>'+product[p]['price']+'</p>\
                                    <p>'+product[p]['attributes']+'</p>\
                                    <p>Quantity: '+product[p]['quantity']+'</p>\
                                </div>\
                            <div class="fix"></div>\
                            ';
                        }
                    }
                    if($(document).scrollTop() > 120)
                    {
                        $('#mybag2 .currentbag .bag_items li').html(cart_view);
                        $('#mybag2 .currentbag').fadeIn(10).delay(3000).fadeOut(10);
                    }
                    else
                    {
                        $('#mybag1 .currentbag .bag_items li').html(cart_view);
                        $('#mybag1 .currentbag').fadeIn(10).delay(3000).fadeOut(10);
                    }
                    ajax_cart();
                },
                'json'
            );
            $(".JS_filter1").remove();
            $('.JS_popwincon1').fadeOut(160).appendTo('#tab2');
            return false;
        })
    })
</script>

<script type="text/javascript">
    var google_tag_params = {
        ecomm_prodid: '',           //SKU
        ecomm_pagetype: 'category',         // product
        ecomm_totalvalue: ''       // 
    };
</script>
<!-- lazyload -->
<script type="text/javascript" charset="utf-8" src="/js/lazyload.js"></script>
<script  type="text/javascript" charset="utf-8">
	$("#Blue").live('click',function(){				
				$("#bluediv").show();
				$("#greendiv").hide();
				$("#pinkdiv").hide();
				$("#yellowdiv").hide();
				$("#whitediv").hide();
				$("#purplediv").hide();

	})

	$("#Green").live('click',function(){
				$("#greendiv").show();
				$("#bluediv").hide();
				$("#pinkdiv").hide();
				$("#yellowdiv").hide();
				$("#whitediv").hide();
				$("#purplediv").hide();

	})
	
	$("#Pink").live('click',function(){
				$("#pinkdiv").show();
				$("#bluediv").hide();
				$("#greendiv").hide();
				$("#yellowdiv").hide();
				$("#whitediv").hide();
				$("#purplediv").hide();

	})
	
	$("#Yellow").live('click',function(){
				$("#yellowdiv").show();
				$("#pinkdiv").hide();
				$("#bluediv").hide();
				$("#greendiv").hide();				
				$("#whitediv").hide();
				$("#purplediv").hide();

	})
	
	$("#White").live('click',function(){
				$("#whitediv").show();	
				$("#yellowdiv").hide();
				$("#pinkdiv").hide();
				$("#bluediv").hide();
				$("#greendiv").hide();				
				$("#purplediv").hide();
	})
	
	$("#Purple").live('click',function(){
				$("#purplediv").show();
				$("#whitediv").hide();	
				$("#yellowdiv").hide();
				$("#pinkdiv").hide();
				$("#bluediv").hide();
				$("#greendiv").hide();				
				
	})


</script>

	<script type="text/javascript" src="/js/list1.js"></script>
    <script>
    $('.detail-tab li').click(function(){
        var liindex = $('.detail-tab li').index(this);
        $(this).addClass('current').siblings().removeClass('current');
        var liWidth = $('.detail-tab li').width();
        $('.detail-tab p').stop(false,true).animate({'left' : (liindex * liWidth +78)+ 'px'},300);
    });
    </script>
