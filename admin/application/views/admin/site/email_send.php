<?php echo View::factory('admin/site/basic_left')->render(); ?>
<style type="text/css">
.layout label {font-weight:bold}
.text-input {width:360px}
</style>
<script type="text/javascript" src="/media/js/core.js"></script>
<script type="text/javascript" src="/media/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
    tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
        plugins : "fullscreen",
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,cleanup,code,|,fullscreen",
        theme_advanced_buttons2 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
        elements : "body"
    });
</script>
<div id="do_right">
    <div class="box">
        <h3>发送邮件</h3>
        <form method="post" action="">
            <table class="layout">
                <tr>
                    <td><label>收件人：</label></td>
                    <td><input type="text" name="rcpt" class="text-input" /></td>
                </tr>
                <tr>
                    <td><label>发件人：</label></td>
                    <td><input type="text" name="from" value="<?php print $from; ?>" class="text-input"/></td>
                </tr>
                <tr>
                    <td><label>主题：</label></td>
                    <td><input type="text" name="subject" class="text-input"/></td>
                </tr>
                <tr>
                    <td style="vertical-align:top"><label>内容：</label></td>
                    <td><textarea name="body" id="body"></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="发送" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
