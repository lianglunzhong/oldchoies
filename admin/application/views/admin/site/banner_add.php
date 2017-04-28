<?php echo View::factory('admin/site/banner_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript" src="/media/js/file-uploader/fileuploader.js"></script>
<link rel="stylesheet" type="text/css" href="/media/js/file-uploader/fileuploader.css" />
<script type="text/javascript">
    config = {};
    config['image_tempfolder'] = '<?php echo STATICURL ?>/simages';
    config['catalog_id'] = '';
    config['image_allowed_extensions'] = ["<?php echo implode('","', kohana::config('upload.product_image.filetypes')); ?>"];
    config['image_max_size'] = <?php echo kohana::config('upload.product_image.max_size'); ?>;
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
        <h3>Banner Add</h3>
        <form method="post" action="#" name="ptype_add_form" class="need_validation">
            <ul>
                <li>
                    <label>Link<span class="req">*</span></label>
                    <div><input id="link" name="link" class="short text required" type="text"></div>
                </li>

                <li>
                    <label>Images<span class="req">*</span></label>
                    <div id="upload_box"></div>
                    <input type="hidden" name="image_src" />
                    <input type="hidden" name="images_removed" />
                    <ul id="images_list" class="clr"></ul>
                </li>

                <li>
                    <label>Alt<span class="req">*</span></label>
                    <div><input id="alt" name="alt" class="short text required" type="text"></div>
                </li>

                <li>
                    <label>Title<span class="req">*</span></label>
                    <div><input id="title" name="title" class="short text required" type="text"></div>
                </li>
                <li>
                    <label>Type<span class="req">*</span></label>
                    <div><input id="type" name="type" class="short text" type="text"></div>
                </li>

                <li>
                    <label>Map<span class="req">*</span></label>
                    <div>
                        <textarea name="map" id="map" rows="6" cols="60" class="textarea"></textarea>
                    </div>
                </li>

                <li>
                    <label>Visibility</label>
                    <div>
                        <input type="radio" checked="checked" value="1" name="visibility" class="radio"> Visible
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" value="0" name="visibility" class="radio"> Invisible
                    </div>
                </li>

                <li>
                    <label>Position<span class="req">*(排序:数字越小排在越前)</span></label>
                    <div><input id="position" name="position" class="short text required" type="text"></div>
                </li>

                <li>
                    <label>LANGUAGE<span class="req">(语种)</span></label>
                    <div>
                        <select id="lang" name="lang">
                            <option></option>
                            <?php
                            $languages = Kohana::config('sites.' . Session::instance()->get('SITE_ID') . '.language');
                            foreach ($languages as $l)
                            {
                                if ($l == 'en')
                                    continue;
                                ?>
                                <option value="<?php echo $l; ?>"><?php echo $l; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </li>

                <li>
                    <button type="submit">Add</button> 
                </li>

            </ul>
        </form>
    </div>
</div>
