<?php echo View::factory('admin/manage/left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>红人</h3>
        <div style="margin-bottom: 10px;"><span><a href="/manage/celebrity/add" style="color: red">添加红人</a></span> | <span><a href="/manage/celebrity/add_activity" style="color: red">添加活动记录</a></span></div>
        <table>
            <tr>
                <td>#</td>
                <td>S#</td>
                <td>姓名</td>
                <td>Email</td>
                <td>联系方式</td>
                <td>等级</td>
                <td>积分数</td>
                <td>个人博客</td>
                <td>博客ALEXA排名</td>
                <td>lookbook地址</td>
                <td>facebook地址</td>
                <td>流量</td>
                <td>管理员</td>
                <td>操作</td>
            </tr>
            <?php foreach( $celebrities as $celebrity ): ?>
                <tr>
                    <td><?php echo $celebrity->id; ?></td>
                    <td><?php echo $celebrity->user_id; ?></td>
                    <td><?php echo $celebrity->name; ?></td>
                    <td><?php echo $celebrity->email; ?></td>
                    <td><?php echo $celebrity->contact; ?></td>
                    <td><?php echo $celebrity->level; ?></td>
                    <td><?php echo $celebrity->points; ?></td>
                    <td><?php echo $celebrity->blog_url; ?></td>
                    <td><?php echo $celebrity->blog_alexa; ?></td>
                    <td><?php echo $celebrity->lookbook_url; ?></td>
                    <td><?php echo $celebrity->facebook_url; ?></td>
                    <td><?php echo $celebrity->flow; ?></td>
                    <td><?php echo User::instance($celebrity->user_id)->get('name'); ?></td>
                    <td><a href="/manage/celebrity/edit/<?php echo $celebrity->id; ?>">编辑</a> | <a href="/manage/celebrity/activities/<?php echo $celebrity->id; ?>">活动记录</a> | <a href="javascript::void(0);" onclick="if(confirm('确定删除？')){location.href='/manage/celebrity/delete/<?php echo $celebrity->id; ?>'}">删除</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>