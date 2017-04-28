<div id="cart-full">
	<h3>Wishlist Items</h3>
	
	<?php foreach( $wishlists as $wishlist ): ?>
	<div class="product row">
		<div class="mobile-one">
			<a href="<?php echo Product::instance($wishlist['product_id'])->permalink(); ?>">
				<img src="<?php echo Image::link(Product::instance($wishlist['product_id'])->cover_image(), 3); ?>" alt=""></a>
			<div class="addproducts"></div>
		</div>
		
		<div class="mobile-three">
			<h4><a href=""><?php echo Product::instance($wishlist['product_id'])->get('name'); ?></a></h4>
			<span class="style-number">Style# <?php echo Product::instance($wishlist['product_id'])->get('sku'); ?></span><br/>
			<span>Price: <?php echo Site::instance()->price(Product::instance($wishlist['product_id'])->price(), 'code_view'); ?></span><br/><br/>
		<a href="<?php echo Product::instance($wishlist['product_id'])->permalink(); ?>" style="display:inline-block; vertical-align:middle;" class="add-to-cart" >
			<img src="/images/mobile/btn_add_tote_small.png" alt="Add to Tote"></a>
		<a href="<?php echo LANGPATH; ?>/mobilecustomer/wishlist_delete/<?php echo $wishlist['id']; ?>" style="display:inline-block; vertical-align:middle;" class="delete-want-item" >Remove</a>
		</div>
	</div>
	<?php endforeach; ?>
	<?php echo $pagination; ?>
</div>