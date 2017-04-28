<?php echo View::factory('admin/manage/left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>采购记录</h3>
        <div style="margin-bottom: 10px;"><span><a href="/manage/stock/add" style="color: red">添加采购记录</a></span></div>
        <table>
            <tr>
                <td>时间</td>
                <td>采购产品</td>
                <td>分类</td>
                <td>卖家</td>
                <td>数量</td>
                <td>金额</td>
                <td>是否缺货</td>
                <td>采购员</td>
                <td>操作</td>
            </tr>
            <?php foreach( $logs as $log ): ?>
                <tr>
                    <td><?php echo date('Y-m-d H:i:s', $log->created); ?></td>
                    <td><?php echo Product::instance($log->product_id)->get('name'); ?></td>
                    <td><?php echo Catalog::instance(Product::instance($log->product_id)->default_catalog())->get('name'); ?></td>
                    <td><?php echo ORM::factory('factory', $log->factory_id)->name; ?></td>
                    <td><?php echo $log->quantity; ?></td>
                    <td><?php echo $log->amount; ?></td>
                    <td><?php echo $log->status == 1 ? '缺货' : '正常'; ?></td>
                    <td><?php echo User::instance($log->user_id)->get('name'); ?></td>
                    <td><a href="/manage/stock/edit/<?php echo $log->id; ?>">编辑</a> | <a href="javascript::void(0);" onclick="if(confirm('确定删除？')){location.href='/manage/stock/delete/<?php echo $log->id; ?>'}">删除</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
</div>