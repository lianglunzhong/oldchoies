<?php echo View::factory('admin/site/activity_left')->render(); ?>
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
                                //TODO 修改具体样式：
                                var image_li = '\
                                <li image_name="'+ filename + '">\n\
                                <img src = "' + config['image_tempfolder'] + '/'+ filename + '" />\n\
                                <div class="image_actions">\n\
                                <a href="#" class="image_remove">删除</a>\n\
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
        });
</script>
<div id="do_right">
        <div class="box">
                <h3>share_win Reports Add</h3>
                <form method="post" action="#" name="ptype_add_form" class="need_validation">
                        <ul>
                                <li>
                                        <label>Sku<span class="req">*</span></label>
                                        <div><input id="sku" name="sku" class="short text required" type="text"></div>
                                </li>
                                
                                <li>
                                        <label>Name<span class="req">*</span></label>
                                        <div><input id="name" name="name" class="short text required" type="text"></div>
                                </li>
                                
                                <li>
                                        <label>Age<span class="req">*</span></label>
                                        <div><input id="age" name="age" class="short text required" type="text"></div>
                                </li>
                                
                                <li>
                                        <label>Profession<span class="req">*</span></label>
                                        <div><input id="profession" name="profession" class="short text required" type="text"></div>
                                </li>
                                
                                <li>
                                        <label>Comments<span class="req">*</span></label>
                                        <div><textarea id="comments" name="comments" cols="50" rows="10" class="short text required" type="text"></textarea></div>
                                </li>

                                <li>
                                        <label>Images<span class="req">*</span></label>
                                        <div id="upload_box"></div>
                                        <input type="hidden" name="image_src" />
                                        <input type="hidden" name="images_removed" />
                                        <ul id="images_list" class="clr"></ul>
                                </li>
                                
                                <li>
                                        <button type="submit">Add</button> 
                                </li>

                        </ul>
                </form>
        </div>
</div>
