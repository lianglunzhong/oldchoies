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
            if(pclass != 'nolang')
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
        <h3>小语种产品数据修改
        <?php
            $languages = Kohana::config('sites.1.language');
            $now_lang = Arr::get($_GET, 'lang', 'en');
            foreach($languages as $l)
            {
                ?>
                <a class="nolang" href="/admin/site/product/small_import<?php if($l != 'en') echo '?lang=' . $l; ?>" <?php if($now_lang == $l) echo 'style="color:red"'; ?>><?php echo $l; ?></a>
                <?php
            }
        ?>
        </h3>
        <form method="post" action="" id="form1">
            <table class="layout">
                <tr>
                    <td><label>Content：</label></td>
                    <td><textarea name="content" id="content" cols="55" rows="20" ></textarea></td>
                </tr>
				<tr>
				<td><label>类型：</label></td>
				<td>
				<select name="name1">
				<option value ="name">name</option>
				<option value ="brief">brief</option>
				<option value="description">description</option>
				<option value="meta_title">meta_title</option>
				<option value="meta_keywords">meta_keywords</option>
				<option value="meta_description">meta_description</option>
				<option value="keywords">keywords</option>
				<option value="presell_message">presell_message</option>
				</select>
				</td>
				</tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Save" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
