<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Página de Inicio</a>  >  Lista De Deseos</div>
        </div>
        <?php echo Message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Lista De Deseos</h2></div>
            <p>¡Usted puede añadir productos a su lista de deseos para la visión posterior o la compra!</p>
            <table class="user_table wish_list_table">
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
                    $link = Product::instance($wishlist['product_id'])->permalink();
                    ?>
                    <tr>
                        <td>
                            <div class="fix">
                                <div class="left">
                                    <a href="<?php echo $link; ?>">
                                        <img src="<?php echo Image::link(Product::instance($wishlist['product_id'])->cover_image(), 3); ?>" />
                                    </a>
                                </div>
                                <div class="right">
                                    <a href="<?php echo $link; ?>" class="name"><?php echo Product::instance($wishlist['product_id'], LANGUAGE)->get('name'); ?></a>
                                    <p>artículo# : <?php echo Product::instance($wishlist['product_id'])->get('sku'); ?></p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php
                            $status = Product::instance($wishlist['product_id'])->get('status');
                            echo $status ? 'En Stock' : 'Fuera de Stock';
                            ?>
                        </td>
                        <td><?php echo Site::instance()->price(Product::instance($wishlist['product_id'])->price(), 'code_view'); ?></td>
                        <td>
                            <?php if ($status): ?>
                                <a href="<?php echo $link; ?>" class="view_btn btn26 btn40">AÑADIR A BOLSA</a>
                            <?php endif; ?>
                            <a href="<?php echo LANGPATH; ?>/wishlist/delete/<?php echo $wishlist['id']; ?>" class="del_btn"></a>
                        </td>
                    </tr>
                    <?php
                endforeach;
                ?>
            </table>
            <?php echo $pagination; ?>
        </article>
        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
    </section>
</section>