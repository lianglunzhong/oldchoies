<?php echo View::factory('admin/manage/left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>红人活动记录</h3>
        <table>
            <tr>
                <td>时间</td>
                <td>姓名</td>
                <td>Email</td>
                <td>积分数量</td>
                <td>积分时间</td>
                <td>所选产品</td>
                <td>产品分类</td>
                <td>订单号</td>
                <td>发货时间</td>
                <td>到货时间</td>
                <td>推广链接</td>
                <td>推广时间</td>
                <td>推广效果</td>
                <td>操作人</td>
                <td>操作</td>
            </tr>
            <?php foreach( $activities as $activity ): ?>
                <tr>
                    <td><?php echo date('Y-m-d H:i:s', $activity->created); ?></td>
                    <td><?php echo ORM::factory('celebrity', $activity->celebrity_id)->name; ?></td>
                    <td><?php echo ORM::factory('celebrity', $activity->celebrity_id)->email; ?></td>
                    <td><?php echo $activity->points; ?></td>
                    <td><?php echo $activity->points_date; ?></td>
                    <td><?php echo Product::instance($activity->product_id)->get('sku'); ?></td>
                    <td><?php echo Catalog::instance(Product::instance($activity->product_id)->default_catalog())->get('name'); ?></td>
                    <td><?php echo $activity->ordernum; ?></td>
                    <td><?php echo $activity->shipping_date; ?></td>
                    <td><?php echo $activity->delivery_date; ?></td>
                    <td><?php echo $activity->spread_url; ?></td>
                    <td><?php echo $activity->spread_date; ?></td>
                    <td><?php echo $activity->spread_flow; ?></td>
                    <td><?php echo User::instance($activity->user_id)->get('name'); ?></td>
                    <td><a href="/manage/celebrity/edit_activity/<?php echo $activity->id; ?>">编辑</a> | <a href="javascript::void(0);" onclick="if(confirm('确定删除？')){location.href='/manage/celebrity/delete_activity/<?php echo $activity->id; ?>'}">删除</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
</div>