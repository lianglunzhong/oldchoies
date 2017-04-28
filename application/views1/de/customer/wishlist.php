<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/">Homepage</a>
				<a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > KONTOÜBERSICHT</a> > Wunschliste
			</div>
		</div>
		<?php echo Message::get(); ?>
	</div>
	<!-- main-middle begin -->
	<div class="container">
		<div class="row">
<?php echo View::factory(LANGPATH . '/customer/left'); ?>
<?php echo View::factory(LANGPATH . '/customer/left_1'); ?>
			<article class="user col-sm-9 hidden-xs">
				<div class="tit">
					<h2>Wunschliste</h2>
				</div>
				<p>Sie können Artikel zu Ihrer Wunschliste für spätere Ansicht oder Einkaufen addieren!</p>
				<table class="user-table wish-list-table">
					<tr>
						<th width="45%">Produkt-Info</th>
	                    <th width="20%">Verfügbarkeit</th>
	                    <th width="20%">Preis</th>
	                    <th width="15%">Aktion</th>
					</tr>
        <?php
        foreach ($wishlists as $wishlist):
            if (!Product::instance($wishlist['product_id'])->get('visibility'))
                continue;
            $link = Product::instance($wishlist['product_id'] ,LANGUAGE)->permalink();
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
                            <a href="<?php echo $link; ?>" class="name"><?php echo Product::instance($wishlist['product_id'], LANGUAGE)->get('name'); ?></a>
									<p>Artikel#:<?php echo Product::instance($wishlist['product_id'])->get('sku'); ?></p>
								</div>
							</div>
						</td>
                <td>
                    <?php
                    $status = Product::instance($wishlist['product_id'])->get('status');
                    echo $status ? 'Auf Lager' : 'Nicht Auf Lager';
                    ?>
                </td>
                <td><?php echo Site::instance()->price(Product::instance($wishlist['product_id'])->price(), 'code_view'); ?></td>
						<td>
		      <?php if ($status): ?>				
						<a href="<?php echo $link; ?>" class="btn btn-primary btn-xs">Details Sehen</a>
			    <?php endif; ?>
							<a href="<?php echo LANGPATH; ?>/wishlist/delete/<?php echo $wishlist['id']; ?>" class="del-btn"></a>
						</td>
					</tr>
            <?php
        endforeach;
        ?>
				</table>
    <?php echo $pagination; ?>  
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
            $link = Product::instance($wishlist['product_id'] ,LANGUAGE)->permalink();
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
								<p>Artikel#: <?php echo Product::instance($wishlist['product_id'])->get('sku'); ?></p>
								<P>Preis: <?php echo Site::instance()->price(Product::instance($wishlist['product_id'])->price(), 'code_view'); ?></P>
								<P>                            <?php
                    $status = Product::instance($wishlist['product_id'])->get('status');
                    echo $status ? 'Auf Lager' : 'Nicht Auf Lager';
                    ?></P>	    <?php if ($status): ?>
								<a href="<?php echo $link; ?>" class="btn btn-primary btn-xs">In den Warenkorb</a>
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
				</div>   -->         <?php echo $pagination; ?>  
			</article>
		</div>
	</div>
</section>
