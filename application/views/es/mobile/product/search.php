<div class="family">
<?php if(empty($products)){  ?>
	<p>Sorry! The item or page you are searching for doesn’t exist…</p>
	
	
<?php }else{?>
	<p><?php echo $count;?> Records Found</p>
    <?php
    foreach( $products as $product_id ): 
        $lips = DB::query(Database::SELECT, 'SELECT COUNT(id) AS count FROM celebrity_images WHERE product_id = '.$product_id)->execute()->get('count');
        ?>     
        <div class="product">     
           	<a href="<?php echo Product::instance($product_id)->permalink(); ?>">
               <img class="lazyload" src="<?php echo image::link(Product::instance($product_id)->cover_image(), 1); ?>" height="226" width="150" >
               <h3><?php echo Product::instance($product_id)->get('name'); ?></h3>
               <span class="regular"><?php echo Site::instance()->price(Product::instance($product_id)->price(), 'code_view'); ?></span>
           	</a>
		</div><?php 
	endforeach; 
	
	echo $pagination;
}
?>
</div>