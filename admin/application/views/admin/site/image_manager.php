<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Image Manager</title>

<link type="text/css" rel="stylesheet" href="/media/css/all.css" media="all" id="mystyle" charset="utf-8" />
<link type="text/css" href="/media/js/jquery-ui/jquery-ui-1.8.1.custom.css" rel="stylesheet" id="uistyle" />
<script type="text/javascript" src="/media/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="/media/js/jquery-ui-1.8.1.custom.min.js"></script>
<script type="text/javascript" src="/media/js/tiny_mce/tiny_mce_popup.js"></script>
<script type="text/javascript" src="/media/js/file-uploader/fileuploader.js"></script>
<link rel="stylesheet" type="text/css" href="/media/js/file-uploader/fileuploader.css" />
<style type="text/css">
.bigLabel,h3 {
    font-size:20px;
    font-weight: normal;
}
a.image_remove {
    color: red;
}
a.image_insert {
    font-weight: bold;
}
h3 {
    border-top:dashed 1px #ccc;
    color: #666;
    margin-top: 10px;
}
</style>
    </head>
    <body>
    <script type="text/javascript">
//Upload Action:
$(function(){
    var uploader = new qq.FileUploader({
        element: document.getElementById('upload_box'),
        action: '/admin/site/image/embed_manager',
		multiple:false,
        params:{
            folder:'site_image'
        },
        allowedExtensions:["<?php echo implode('","',kohana::config('upload.site_image.filetypes'));?>"],
        sizeLimit:<?php echo kohana::config('upload.site_image.max_size');?>,
        onComplete:function(id, fileName, responseJSON) {
            if(responseJSON['success'] == 'true'){
                insert(responseJSON['file_url']);
            }
        }
    });
    $('.qq-upload-drop-area').click(function(){this.style.display = 'none';});

    $('.image_insert').click(function(){
        var url = $(this).parent().prev().attr('src');
        insert(url);
        return false;
    });
    $('.image_remove').click(function(){
        var $this = $(this);
        if(!confirm('Are you sure to delete this image forever? \nIt cannot be undone!'))
        {
            return false;
        }
        $this.after('deleting').hide();
        $.ajax({
            url:$this.attr('href'),
                context:this,
                success:function(){
                    $(this).parent().parent().remove();
                }
        });
        return false;
    });
});
function insert(url){
    var win = tinyMCEPopup.getWindowArg('window');
    win.document.getElementById(tinyMCEPopup.getWindowArg('input')).value = url;
    if(typeof(win.ImageDialog) != "undefined") {
        if(win.ImageDialog.getImageData) {
            win.ImageDialog.getImageData();
        }
        if(win.ImageDialog.showPreviewImage) {
            win.ImageDialog.showPreviewImage(url);
        }
    }
    tinyMCEPopup.close();
}
</script>
                    <div id="upload_box">
                    </div>
<?php
if(count($images))
{
?>
                    <h3>Or Select:</h3>
                    <?php echo $pagination;?>
                    <ul id="images_list" class="clr">
<?php
    foreach($images as $image)
    {
?>
                        <li>
                            <img src="http://<?php echo Site::instance()->get('domain');?>/simages/<?php echo $image->filename;;?>" />
                            <div class="image_actions">
                                <a href="#" class="image_insert">Use this! </a>|
                                <a href="/admin/site/image/do_delete/<?php echo $image->id;?>" class="image_remove"> X </a>    
                            </div>
                        </li>
<?php
    }
?>
                    </ul>
<?php
echo $pagination;
}
?>

</body>
</html>
