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
        
<?php
$lang = Arr::get($_GET, 'lang', '');
$lang_url = $lang ? '?lang=' . $lang : '';
if ($lang_url)
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
else
{
    ?>
                        $('#name').blur(function(){
                            var str=$('#name').val();
                            $('#link').val(str.replace(/&|\?|\%| |\//g,"-").toLocaleLowerCase());
                        });
    <?php
}
?>
            });
</script>
<div id="do_right">
    <div class="box">
        <h3>Edit Document
        <?php
            $languages = Kohana::config('sites.1.language');
            $now_lang = Arr::get($_GET, 'lang', 'en');
            foreach($languages as $l)
            {
                ?>
                <a class="nolang" href="/admin/site/doc/edit/<?php echo $doc->id; ?><?php if($l != 'en') echo '?lang=' . $l; ?>" <?php if($now_lang == $l) echo 'style="color:red"'; ?>><?php echo $l; ?></a>
                <?php
            }
        ?>
        </h3>
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
                    <td><label>Meta title: </label></td>
                    <td><input id="meta_title" type="text" name="meta_title" style="width:560px" value="<?php print $doc->meta_title; ?>"/></td>
                </tr>
                <tr>
                    <td><label>Meta keywords: </label></td>
                    <td><input id="meta_keywords" type="text" name="meta_keywords" style="width:560px" value="<?php print $doc->meta_keywords; ?>"/></td>
                </tr>
                <tr>
                    <td><label>Meta description: </label></td>
                    <td><input id="meta_description" type="text" name="meta_description" style="width:560px" value="<?php print $doc->meta_description; ?>"/></td>
                </tr>
                <tr>
                    <td><label>Name：</label></td>
                    <td><input id="name" type="text" name="name" style="width:360px" value="<?php print $doc->name; ?>"/></td>
                </tr>
                <tr>
                    <td><label>Link：</label></td>
                    <td><input id="link" type="text" name="link" style="width:360px" value="<?php print $doc->link; ?>" title="<?php print $doc->link; ?>"/></td>
                </tr>
                <tr>
                    <td><label>Content：</label></td>
                    <td><textarea name="content" id="content" cols="55" rows="20" ><?php print $doc->content; ?></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Save" />
                        <a class="nolang" href="/admin/site/doc/list<?php if($lang) echo '?lang=' . $lang; ?>">Cancel</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
