<?php echo View::factory('admin/site/lookbook_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript" src="/media/js/file-uploader/fileuploader.js"></script>
<link rel="stylesheet" type="text/css" href="/media/js/file-uploader/fileuploader.css" />
<script type="text/javascript">
        config = {};
        config['image_tempfolder'] = 'http://<?php echo Site::instance()->get('domain'); ?>/simages';
        config['catalog_id'] = '';
        config['image_allowed_extensions'] = ["<?php echo implode('","',kohana::config('upload.product_image.filetypes'));?>"];
        config['image_max_size'] = <?php echo kohana::config('upload.product_image.max_size');?>;
        uploaded = {
                'images':[] ,
                        'add':function(filename){
                                this.images.push(filename);
                                $('input[name=images]').val(this.images.join(','));
                                var product_sku = $('#product_sku').val();
                                if(product_sku == '')
                                {
                                        product_sku = 'Main'
                                }
                                //TODO 修改具体样式：
                                var image_li = '\
                                <li image_name="'+ filename + '">\n\
                                <img src = "' + config['image_tempfolder'] + '/'+ filename + '" />\n\
                                <div class="image_actions">\n\
                                '+ product_sku +' <a href="#" class="image_remove">删除</a>\n\
                                </div>\n\
                                </li>';
                                $('#images_list').append(image_li);
                                $image_src = $('input[name=image_src]');
                                $image_src.val($image_src.val() + ($image_src.val()  == '' ? '' : ',') + filename);
                        },
                        'remove':function(filename){
                                var idx = $.inArray(filename, this.images),
                                $input_removed = $('input[name=images_removed]');
                                if(idx >= 0) {
                                        this.images.splice(idx,1);
                                }
                                $('input[name=images]').val(this.images.join(','));
                                $input_removed.val($input_removed.val() + ($input_removed.val()  == '' ? '' : ',') + filename);
                                //如果删掉了默认图片，则把默认设为空：
                        }
                };
        $(function(){
                var uploader = new qq.FileUploader({
                        element: document.getElementById('upload_box'),
                        action: '/admin/site/image/embed_manager',
                        params:{ 
                                folder:'site_image'
                        },
                        allowedExtensions:config['image_allowed_extensions'],
                        sizeLimit:config['image_max_size'],
                        onComplete:function(id, fileName, responseJSON) {
                                if(responseJSON['success'] == 'true'){
                                        uploaded.add(responseJSON['filename']);
                                }
                        }
                });
                $('.qq-upload-drop-area').click(function(){this.style.display = 'none';});
                $('.image_remove').live('click',function(){
                    var $li = $(this).parent().parent();
                    uploaded.remove($li.attr('image_name'));
                    $li.remove();
                    return false;
                });
                $('#product_submit').live('click',function(){
                        var product_sku = $('#product_sku').val();
                        if(product_sku == '')
                        {
                               product_sku = 'main'; 
                        }
                        $('#image_type').html(product_sku + ':');
                        var html = '<input type="hidden" name="product_sku[]" value="' + product_sku + '" />';
                        var productVal = 'value="' + product_sku + '"';
                        var productArr = $('#productArr').html();
                        if(productArr.indexOf(productVal) < 0)
                        {
                                $('#productArr').append(html);
                        }
                        return false;
                });
        });
</script>
<div id="do_right">
        <div class="box">
                <h3>Lookbook Add</h3>
                <form method="post" action="#" name="ptype_add_form" class="need_validation">
                        <ul>
                                <li>
                                        <label>Title<span class="req">*</span></label>
                                        <div><input id="name" name="lookbook[title]" value="<?php echo $lookbook['title']; ?>" class="short text required" type="text"></div>
                                </li>

                                <li>
                                        <label>Images<span class="req">*</span></label>
                                        <?php $images = unserialize($lookbook['images']); ?>
                                        <div id="image_preview" style="margin-bottom:15px;">
                                        <?php
                                        if($images)
                                        {
                                        foreach($images as $name => $image):
                                        ?>
                                                <div>
                                                <h4><?php echo $name; ?> images:</h4><br>
                                                <img src="<?php echo 'http://' . Site::instance()->get('domain') . '/simages/' . $image; ?>" />
                                                </div>
                                        <?php

                                        endforeach;
                                        }
                                        ?>
                                        </div>
                                        <div>
                                                <input type="text" id="product_sku" /><button id="product_submit">产品锁定</button>
                                                <div id="productArr"></div>
                                        </div>
                                        <label id="image_type"></label>
                                        <div id="upload_box"></div>
                                        <input type="hidden" name="image_src" />
                                        <input type="hidden" name="images_removed" />
                                        <ul id="images_list" class="clr"></ul>
                                </li>

                                <li>
                                        <label>Visibility</label>
                                        <div>
                                                <input type="radio" <?php if($lookbook['visibility']) echo 'checked="checked"'; ?> value="1" name="lookbook[visibility]" class="radio"> Visible
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="radio" <?php if(!$lookbook['visibility']) echo 'checked="checked"'; ?> value="0" name="lookbook[visibility]" class="radio"> Invisible
                                        </div>
                                </li>

                                <li>
                                        <button type="submit">Add</button> 
                                </li>

                        </ul>
                </form>
        </div>
</div>
