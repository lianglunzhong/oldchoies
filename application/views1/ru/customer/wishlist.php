<section id="main">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs">
            <div>
                <a href="<?php echo LANGPATH; ?>/">home</a>
                <a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> >Личный кабинет</a> >Избранное
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
                    <h2>Избранное</h2>
                </div>
               <p>Вы можете добавить товар в избранное для последующего просмотра или покупки!</p>
                <table class="user-table wish-list-table">
                    <tr>
            <th width="45%">Информация товаров</th>
            <th width="20%">Статус наличия</th>
            <th width="20%">Цена</th>
            <th width="15%">Действие</th>
                    </tr>
        <?php
        foreach ($wishlists as $wishlist):
            if (!Product::instance($wishlist['product_id'])->get('visibility'))
                continue;
            $link = Product::instance($wishlist['product_id'], LANGUAGE)->permalink();
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
                                    <p>Товар# : <?php echo Product::instance($wishlist['product_id'])->get('sku'); ?></p>
                                </div>
                            </div>
                        </td>
                <td>
                    <?php
                    $status = Product::instance($wishlist['product_id'])->get('status');
                    echo $status ? 'В наличии' : 'Нет в наличии';
                    ?>
                </td>
                <td><?php echo Site::instance()->price(Product::instance($wishlist['product_id'])->price(), 'code_view'); ?></td>
                        <td>
              <?php if ($status): ?>                
                        <a href="<?php echo $link; ?>" class="btn btn-primary btn-xs">Посмотреть Детали</a>
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
            $link = Product::instance($wishlist['product_id'], LANGUAGE)->permalink();
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
                            <a href="<?php echo $link; ?>" class="name"><?php echo Product::instance($wishlist['product_id'], LANGUAGE)->get('name'); ?></a>
                                <p>Товар# : <?php echo Product::instance($wishlist['product_id'])->get('sku'); ?></p>
                                <P>Price:<?php echo Site::instance()->price(Product::instance($wishlist['product_id'], LANGUAGE)->price(), 'code_view'); ?></P>
                                <P>                            <?php
                    $status = Product::instance($wishlist['product_id'])->get('status');
                    echo $status ? 'В наличии' : 'Нет в наличии';
                    ?></P>      <?php if ($status): ?>
                                <a href="<?php echo $link; ?>" class="btn btn-primary btn-xs">ДОБАВИТЬ В КОРЗИНУ</a>
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
