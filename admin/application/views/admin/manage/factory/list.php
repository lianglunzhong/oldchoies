<?php echo View::factory('admin/manage/left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>供货商</h3>
        <div style="margin-bottom: 10px;"><span><a href="/manage/factory/add" style="color: red">添加供货商</a></span></div>
        <table>
            <tr>
                <td>名称</td>
                <td>店铺链接</td>
                <td>手机</td>
                <td>旺旺</td>
                <td>创建时间</td>
                <td>管理员</td>
                <td>操作</td>
            </tr>
            <?php foreach( $factories as $factory ): ?>
                <tr>
                    <td><?php echo $factory->name; ?></td>
                    <td><?php echo $factory->url; ?></td>
                    <td><?php echo $factory->mobile; ?></td>
                    <td><?php echo $factory->aliwangwang; ?></td>
                    <td><?php echo date('Y-m-d H:i:s', $factory->created); ?></td>
                    <td><?php echo User::instance($factory->user_id)->get('name'); ?></td>
                    <td><a href="/manage/factory/edit/<?php echo $factory->id; ?>">编辑</a> | <a href="javascript::void(0);" onclick="if(confirm('确定删除？')){location.href='/manage/factory/delete/<?php echo $factory->id; ?>'}">删除</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>