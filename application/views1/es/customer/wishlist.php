<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/">Página de Inicio</a>
				<a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > RESUMEN DE CUENTA</a> > Lista De Deseos
			</div>
            <?php echo Message::get(); ?>
		</div>
	</div>
	<!-- main-middle begin -->
	<div class="container">
		<div class="row">
<?php echo View::factory(LANGPATH . '/customer/left'); ?>
<?php echo View::factory(LANGPATH . '/customer/left_1'); ?>
			<article class="user col-sm-9 hidden-xs">
				<div class="tit">
					<h2>Lista De Deseos</h2>
				</div>
    			<p>¡Usted puede añadir productos a su lista de deseos para la visión posterior o la compra!</p>
				<table class="user-table wish-list-table">
					<tr>
						<th width="45%">Información De Producto</th>
	                    <th width="20%">Disponibilidad</th>
	                    <th width="20%">Precio</th>
	                    <th width="15%">Acción</th>
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
									<p>artículo# :<?php echo Product::instance($wishlist['product_id'])->get('sku'); ?></p>
								</div>
							</div>
						</td>
                <td>
                    <?php
                    $status = Product::instance($wishlist['product_id'])->get('status');
                    echo $status ? 'En Stock' : 'Fuera De Stock';
                    ?>
                </td>
                <td><?php echo Site::instance()->price(Product::instance($wishlist['product_id'])->price(), 'code_view'); ?></td>
						<td>
		      <?php if ($status): ?>				
						<a href="<?php echo $link; ?>" class="btn btn-primary btn-xs">Ver Detalles</a>
			    <?php endif; ?>
							<a href="<?php echo LANGPATH; ?>/wishlist/delete/<?php echo $wishlist['id']; ?>" class="del-btn"></a>
						</td>
					</tr>
            <?php
        endforeach;
        ?>
				</table>
    <?php echo $pagination; ?>
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
								<p>artículo# :<?php echo Product::instance($wishlist['product_id'])->get('sku'); ?></p>
								<P>Precio:<?php echo Site::instance()->price(Product::instance($wishlist['product_id'])->price(), 'code_view'); ?></P>
								<P>                            <?php
                    $status = Product::instance($wishlist['product_id'])->get('status');
                    echo $status ? 'En Stock' : 'Fuera De Stock';
                    ?></P>	    <?php if ($status): ?>
								<a href="<?php echo $link; ?>" class="btn btn-primary btn-xs">AÑADIR A BOLSA</a>
								 <?php endif; ?>
							</td>
							<td width="15%">
								<a href="<?php echo LANGPATH; ?>/wishlist/delete/<?php echo $wishlist['id']; ?>" class="del-btn"></a>
							</td>
						</tr>
					</tbody>
				</table> 
		<?php } ?>
		    <?php echo $pagination; ?>  
			</article>
		</div>
	</div>
</section>
