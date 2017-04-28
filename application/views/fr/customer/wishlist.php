<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Accueil</a>  >  Liste d’envies</div>
        </div>
        <?php echo Message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Liste d’envies</h2></div>
            <p>Vous pouvez ajouter les produits à votre Liste d’envies pour les voir or acheter la prochaine fois!</p>
            <table class="user_table wish_list_table">
                <tr>
                    <th width="45%">Info de produit</th>
                    <th width="20%">Disponibilité</th>
                    <th width="20%">Prix</th>
                    <th width="15%">Action</th>
                </tr>
                <?php
                foreach ($wishlists as $wishlist):
                    if (!Product::instance($wishlist['product_id'])->get('visibility'))
                        continue;
                    $link = Product::instance($wishlist['product_id'], LANGUAGE)->permalink();
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
                                    <p>Article# : <?php echo Product::instance($wishlist['product_id'])->get('sku'); ?></p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php
                            $status = Product::instance($wishlist['product_id'])->get('status');
                            echo $status ? 'En Stock' : 'En rupture de Stock';
                            ?>
                        </td>
                        <td><?php echo Site::instance()->price(Product::instance($wishlist['product_id'])->price(), 'code_view'); ?></td>
                        <td>
                            <?php if ($status): ?>
                                <a href="<?php echo $link; ?>" class="view_btn btn26 btn40">AJOUTER AU PANIER</a>
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