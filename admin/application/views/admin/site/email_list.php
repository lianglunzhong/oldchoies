<script type="text/javascript">
function toggle_active(link, id)
{
    $.ajax({
        url: '/admin/site/email/toggle_active/' + id, 
        success: function (res) {
            if (res == 'success') {
                $(link).html($(link).html() == 'Yes' ? 'No' : 'Yes');
            } else {
                window.alert(res);
            }
        }
    });
}
<?php
    $lang_url = $lang ? '?lang=' . $lang : '';
    if($lang_url)
    {
        ?>
        var lang_url = '<?php echo $lang_url; ?>';
        $("a").live('click', function(){
            var href = $(this).attr('href');
            var pclass = $(this).attr('class');
            if(pclass != 'product_list')
            {
                href += lang_url;
                $(this).attr('href', href);
            }
        })
        <?php
    }
    ?>
</script>
<?php echo View::factory('admin/site/basic_left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>邮件列表
        <?php
            if($lang == '')
                $lang = 'en';
            $languages = Kohana::config('sites.1.language');
            foreach($languages as $l)
            {
                ?>
                <a href="/admin/site/email/list/<?php if($l != 'en') echo $l; ?>" <?php if($lang == $l) echo 'style="color:red"'; ?>><?php echo $l; ?></a>
                <?php
            }
        ?>
        </h3>
        <a href="/admin/site/email/add">添加站点邮件</a>&nbsp;&nbsp;<a href="/admin/site/email/duplicate" onclick="return window.confirm('Sure copy all emails from Email template?');">bulk copy</a><br/><br/>
        <table>
            <thead>
                <tr>
                    <th scope="col">邮件类型</th>
                    <th scope="col">邮件标题</th>
                    <th scope="col">是否启用</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mails as $mail): ?>
                <tr>
                    <td><?php print $mail->type; ?></td>
                    <td><?php print $mail->title; ?></td>
                    <td>
                        <a href="#" onclick="toggle_active(this, <?php print $mail->id; ?>);">
                            <?php print $mail->is_active ? 'Yes' : 'No'; ?>
                        </a>
                    </td>
                    <td>
                        <a href="/admin/site/email/edit/<?php print $mail->id; ?>">Edit</a>&nbsp;
                        <a href="/admin/site/email/delete/<?php print $mail->id; ?>" onclick="return window.confirm('delete?');" style="color:red">Delete</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
