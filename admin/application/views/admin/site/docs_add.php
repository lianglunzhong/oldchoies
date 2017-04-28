<?php echo View::factory('admin/site/basic_left')->render(); ?>
<script type="text/javascript" src="/media/js/core.js"></script>
<script type="text/javascript" src="/media/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
    mode : "textareas",
    theme : "advanced",
    plugins : "fullscreen",
    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,"
        + "|,justifyleft,justifycenter,justifyright,justifyfull,"
        + "|,cut,copy,paste,pastetext,pasteword,"
        + "|,search,replace,"
        + "|,bullist,numlist,"
        + "|,outdent,indent,blockquote,"
        + "|,undo,redo,|,link,unlink,cleanup,code,|,fullscreen",
    theme_advanced_buttons2 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,
    elements : "content"
});
$(document).ready(function(){
    $('#form1').submit(function(){
		if($('#name').val()=='')
		{
			alert('Please fill the name!');
			return false;
		}
	});
    $('#form1').submit(function(){
		if($('#link').val()=='')
		{
			alert('Please fill the link!');
			return false;
		}
	});

	$('#name').blur(function(){
		var str=$('#name').val();
		$('#link').val(str.replace(/&|\?|\%| |\//g,"-").toLocaleLowerCase());
	});
    
    <?php
        $lang = Arr::get($_GET, 'lang', '');
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
});
</script>
<div id="do_right">
    <div class="box">
        <h3>Edit Document</h3>
        <form method="post" action="" id="form1">
            <table class="layout">
            	<tr>
                    <td><label>Variable：</label></td>
                    <td>{site}-site name,e.g: <?php echo str_replace('www.', '', Site::instance()->get('domain')); ?><br/>
                        {email}-email,e.g: <?php echo Site::instance()->get('email'); ?><br/>
                        {ticket}-ticket center,e.g: <?php echo Site::instance()->get('ticket_center'); ?>
                    </td>
                </tr>
                <tr>
                    <td><label>Name：</label></td>
                    <td><input id="name" type="text" name="name" style="width:360px" value="<?php echo Arr::get($_POST, 'name', '')?>"/></td>
                </tr>
                <tr>
                    <td><label>Link：</label></td>
                    <td><input id="link" type="text" name="link" style="width:360px" value=""/></td>
                </tr>
                <tr>
                    <td><label>Content：</label></td>
                    <td><textarea name="content" id="content" cols="55" rows="20" ><?php echo Arr::get($_POST, 'content', '')?></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Save" />
                        <a href="/admin/site/doc/list">Cancel</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
