<?php
if(empty(LANGUAGE))
{
	$lists = Kohana::config('/customer/wishlist.en');
}
else
{
	$lists = Kohana::config('/customer/wishlist.'.LANGUAGE);
}
?>
<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/"><?php echo $lists['title1']; ?></a>
				<a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > <?php echo $lists['title2']; ?></a> ><?php echo $lists['title3']; ?>
			</div>
            <?php echo Message::get(); ?>
		</div>
	</div>
	<!-- main-middle begin -->
	<div class="container">
		<div class="row">
<?php echo View::factory('customer/left'); ?>
<?php echo View::factory('customer/left_1'); ?>
			<article class="user col-sm-9 hidden-xs">
				<div class="tit">
					<h2><?php echo $lists['title4']; ?> </h2>
				</div>
				<p><?php echo $lists['title5']; ?></p>
				<table class="user-table wish-list-table">
					<tr>
						<th width="45%"><?php echo $lists['Product Info'];?></th>
						<th width="20%"><?php echo $lists['Availability'];?></th>
						<th width="20%"><?php echo $lists['Price'];?></th>
						<th width="15%"><?php echo $lists['Action'];?></th>
					</tr>
        <?php
        foreach ($wishlists as $wishlist):
            if (!Product::instance($wishlist['product_id'])->get('visibility'))
                continue;
            $link = Product::instance($wishlist['product_id'],LANGUAGE)->permalink();
            ?>
					<tr>
						<td>
							<div class="product-info">
								<div class="left">
                            <a href="<?php echo $link; ?>">
                                <img src="<?php echo Image::link(Product::instance($wishlist['product_id'])->cover_image(), 3); ?>" />
                            </a>
								</div>
								<div class="right">
                            <a href="<?php echo $link; ?>" class="name"><?php echo Product::instance($wishlist['product_id'])->get('name'); ?></a>
									<p><?php echo $lists['Item']; echo Product::instance($wishlist['product_id'])->get('sku'); ?></p>
								</div>
							</div>
						</td>
                <td>
                    <?php
                    $status = Product::instance($wishlist['product_id'])->get('status');
                    echo $status ?  $lists['In Stock'] :  $lists['Out Stock'];
                    ?>
                </td>
                <td><?php echo Site::instance()->price(Product::instance($wishlist['product_id'])->price(), 'code_view'); ?></td>
						<td>
		      <?php if ($status): ?>				
						<a href="<?php echo $link; ?>" class="btn btn-primary btn-xs"><?php echo $lists['View Details']; ?></a>
			    <?php endif; ?>
							<a href="<?php echo LANGPATH; ?>/wishlist/delete/<?php echo $wishlist['id']; ?>" class="del-btn"></a>
						</td>
					</tr>
            <?php
        endforeach;
        ?>
				</table>

			<!--	<div class="tol-page">
					<div class="records">2 Records Found</div>
					<ul class="pagination flr">
					    <li class="disabled"><a href="#">« PRE</a></li>
					    <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
					    <li><a href="#">2</a></li>
					    <li><a href="#">3</a></li>
					    <li><a href="#">4</a></li>
					    <li><a href="#">5</a></li>
					    <li><a href="#">NEXT »</a></li>
					</ul>
				</div>	-->
			</article>
			<article class="wish-list-mobile col-xs-12 hidden-sm hidden-md hidden-lg">
        <?php
        foreach ($wishlists as $wishlist){
            if (!Product::instance($wishlist['product_id'])->get('visibility'))
                continue;
            $link = Product::instance($wishlist['product_id'],LANGUAGE)->permalink();
            ?>
				<table class="user-table">
					<tbody>

						<tr>
							<td width="20%" align="left">
                            <a href="<?php echo $link; ?>">
                                <img src="<?php echo Image::link(Product::instance($wishlist['product_id'])->cover_image(), 3); ?>" />
                            </a>
							</td>
							<td width="65%">
                            <a href="<?php echo $link; ?>" class="name"><?php echo Product::instance($wishlist['product_id'])->get('name'); ?></a>
								<p><?php echo $lists['Item'];  echo Product::instance($wishlist['product_id'])->get('sku'); ?></p>
								<P><?php echo $lists['Price'];echo Site::instance()->price(Product::instance($wishlist['product_id'])->price(), 'code_view'); ?></P>
								<P>                            <?php
                    $status = Product::instance($wishlist['product_id'])->get('status');
                    echo $status ? $lists['In Stock'] : $lists['Out Stock'];
                    ?></P>	    <?php if ($status): ?>
								<a href="<?php echo $link; ?>" class="btn btn-primary btn-xs"><?php echo $lists['ADD TO BAG']; ?></a>
								 <?php endif; ?>
							</td>
							<td width="15%">
								<a href="<?php echo LANGPATH; ?>/wishlist/delete/<?php echo $wishlist['id']; ?>" class="del-btn"></a>
							</td>
						</tr>
					</tbody>
				</table> 
		<?php } ?>
				<!--<div class="tol-page">
					<div class="records">2 Records Found</div>
					<ul class="pagination flr">
					    <li class="disabled"><a href="#">« PRE</a></li>
					    <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
					    <li><a href="#">2</a></li>
					    <li><a href="#">3</a></li>
					    <li><a href="#">4</a></li>
					    <li><a href="#">5</a></li>
					    <li><a href="#">NEXT »</a></li>
					</ul>
				</div>   -->    
			</article>
		</div>
		    <?php echo $pagination; ?>  
	</div>
</section>
