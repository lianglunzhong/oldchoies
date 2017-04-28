<?php echo View::factory('admin/manage/left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>产品更新记录</h3>
        <table>
            <tr>
                <td>时间</td>
                <td>SKU</td>
                <td>产品分类</td>
                <td>操作</td>
                <td>操作人</td>
            </tr>
            <?php foreach( $update_logs as $update_log ): ?>
                <tr>
                    <td><?php echo date('Y-m-d H:i:s', $update_log->created); ?></td>
                    <td><?php echo Product::instance($update_log->product_id)->get('sku'); ?></td>
                    <td><?php echo Catalog::instance(Product::instance($update_log->product_id)->default_catalog())->get('name'); ?></td>
                    <td><?php echo $update_log->action; ?></td>
                    <td><?php echo User::instance($update_log->user_id)->get('name'); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>