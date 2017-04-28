<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Homepage</a>  >  Wunschliste</div>
        </div>
        <?php echo Message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Wunschliste</h2></div>
            <p>Sie können Artikel zu Ihrer Wunschliste für spätere Ansicht oder Einkaufen addieren!</p>
            <table class="user_table wish_list_table">
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
                                    <p>Artikel# : <?php echo Product::instance($wishlist['product_id'])->get('sku'); ?></p>
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
                                <a href="<?php echo $link; ?>" class="view_btn btn26 btn40">In den Warenkorb</a>
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