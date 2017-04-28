<?php echo View::factory('admin/manage/left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>产品概况</h3>
        <table>
            <tr>
                <td>分类</td>
                <td>本周</td>
                <td>一周前</td>
                <td>两周前</td>
                <td>三周前</td>
                <td>四周前</td>
            </tr>
            <?php $total = array( ); ?>
            <?php foreach( $catalogs as $catalog ): ?>
                <tr>
                    <td><?php echo $catalog->name; ?></td>
                    <?php foreach( Catalog::instance($catalog->id)->products() as $product_id ): ?>
                        <?php if(Product::instance($product_id)->get('created') > (time() - 7 * 24 * 60 * 60)): ?>
                            <?php $total[$catalog->id]['now'] +=1; ?>
                        <?php elseif(Product::instance($product_id)->get('created') < (time() - 7 * 24 * 60 * 60) AND Product::instance($product_id)->get('created') >= (time() - 14 * 24 * 60 * 60)): ?>
                            <?php $total[$catalog->id]['aweek'] +=1; ?>
                        <?php elseif(Product::instance($product_id)->get('created') < (time() - 14 * 24 * 60 * 60) AND Product::instance($product_id)->get('created') >= (time() - 21 * 24 * 60 * 60)): ?>
                            <?php $total[$catalog->id]['twoweek'] +=1; ?>
                        <?php elseif(Product::instance($product_id)->get('created') < (time() - 21 * 24 * 60 * 60) AND Product::instance($product_id)->get('created') >= (time() - 28 * 24 * 60 * 60)): ?>
                            <?php $total[$catalog->id]['threeweek'] +=1; ?>
                        <?php elseif(Product::instance($product_id)->get('created') < (time() - 28 * 24 * 60 * 60)): ?>
                            <?php $total[$catalog->id]['fourweek'] +=1; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <td><?php echo $total[$catalog->id]['now']; ?></td>
                    <td><?php echo $total[$catalog->id]['aweek']; ?></td>
                    <td><?php echo $total[$catalog->id]['twoweek']; ?></td>
                    <td><?php echo $total[$catalog->id]['threeweek']; ?></td>
                    <td><?php echo $total[$catalog->id]['fourweek']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>