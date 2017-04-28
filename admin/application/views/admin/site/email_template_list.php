<?php echo View::factory('admin/site/basic_left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>邮件模板列表</h3>
        <a href="/admin/site/email/template_add">添加邮件模板</a><br/><br/>
        <table>
            <thead>
                <tr>
                    <th scope="col">邮件类型</th>
                    <th scope="col">邮件标题</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mails as $mail): ?>
                <tr>
                    <td><?php print $mail->type; ?></td>
                    <td><?php print $mail->title; ?></td>
                    <td>
                        <a href="/admin/site/email/template_edit/<?php print $mail->id; ?>">Edit</a>&nbsp;
                        <a href="/admin/site/email/template_delete/<?php print $mail->id; ?>" onclick="return window.confirm('delete?');" style="color:red">Delete</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
