<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  Wish List</div>
        </div>
        <?php echo Message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Wish List</h2></div>
            <p>You may add products to your wishlist for later view or purchase!</p>
            <table class="user_table wish_list_table">
                <tr>
                    <th width="45%">Product Info</th>
                    <th width="20%">Availability</th>
                    <th width="20%">Price</th>
                    <th width="15%">Action</th>
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
                                    <a href="<?php echo $link; ?>" class="name"><?php echo Product::instance($wishlist['product_id'])->get('name'); ?></a>
                                    <p>Item# : <?php echo Product::instance($wishlist['product_id'])->get('sku'); ?></p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php
                            $status = Product::instance($wishlist['product_id'])->get('status');
                            echo $status ? 'In Stock' : 'Out Stock';
                            ?>
                        </td>
                        <td><?php echo Site::instance()->price(Product::instance($wishlist['product_id'])->price(), 'code_view'); ?></td>
                        <td>
                            <?php if ($status): ?>
                                <a href="<?php echo $link; ?>" class="view_btn btn26 btn40">ADD TO BAG</a>
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
        <?php echo View::factory('customer/left'); ?>
    </section>
</section>