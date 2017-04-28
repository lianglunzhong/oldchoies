<?php echo View::factory('admin/manage/left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>供货概况</h3>
        <table>
            <tr>
                <td>分类</td>
                <?php foreach( $factories as $factory ): ?>
                    <?php $stock_logs = ORM::factory('manage_product_stock_log')->where('factory_id', '=', $factory->id)->count_all(); ?>
                    <?php $unstock_logs = ORM::factory('manage_product_stock_log')->where('factory_id', '=', $factory->id)->where('status', '=', 1)->count_all(); ?>
                    <?php if($stock_logs): ?>
                        <?php $unstock_rate = ($unstock_logs / $stock_logs) * 100; ?>
                    <?php else: ?>
                        <?php $unstock_rate = 0; ?>
                    <?php endif; ?>
                    <td><?php echo $factory->name; ?> [ <?php echo $unstock_rate; ?>% ]</td>
                <?php endforeach; ?>
            </tr>
            <?php foreach( $catalogs as $catalog ): ?>
                <tr>
                    <td><?php echo $catalog->name; ?></td>
                    <?php foreach( $factories as $factory ): ?>
                        <?php $products = ORM::factory('product')->where('default_catalog', '=', $catalog->id)->where('factory_id', '=', $factory->id)->find_all(); ?>
                        <td><?php echo count($products); ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
</div>