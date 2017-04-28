<?php echo View::factory('admin/site/basic_left')->render(); ?>
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
        elements : "template"
    });
$(document).ready(function(){
    $('#form1').submit(function(){
		if($('#type').val()=='')
		{
			alert('Please fill the email type!');
			return false;
		}
		if($('#title').val()=='')
		{
			alert('Please fill the email title!');
			return false;
		}
	});
});
</script>
<div id="do_right">
    <div class="box">
        <h3>新增邮件模板</h3>
        <form method="post" action="" id="form1" name="form1">
            <table class="layout">
                <tr>
                    <td><label>邮件类型：</label></td>
                    <td>
                    	<input id='type' name="type" type='text' value="">
                    </td>
                </tr>
                <tr>
                    <td><label>邮件标题：</label></td>
                    <td><input id='title' type="text" name="title" style="width:360px"/></td>
                </tr>
                <tr>
                    <td><label>邮件内容：</label></td>
                    <td><textarea name="template" id="template" cols="55" rows="20" ></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="保存" />
                        <a href="/admin/site/email/template_list">取消</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
