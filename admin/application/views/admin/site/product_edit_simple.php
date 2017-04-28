<div id="do_content">
        <script type="text/javascript" src="/media/js/my_validation.js"></script>
        <script type="text/javascript" src="/media/js/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript" src="/media/js/product_admin/product_admin.js"></script>
        <script type="text/javascript" src="/media/js/file-uploader/fileuploader.js"></script>
        <link rel="stylesheet" type="text/css" href="/media/js/file-uploader/fileuploader.css" />
        <script type="text/javascript">
                config = [];
                config['image_tempfolder'] = "/pimages/<?php echo Session::instance()->get('SITE_ID'); ?>/99";
                config['image_allowed_extensions'] = ["<?php echo implode('","', kohana::config('upload.product_image.filetypes')); ?>"];
                config['image_max_size'] = <?php echo kohana::config('upload.product_image.max_size'); ?>;
                config['product_id'] = <?php echo $product['id']; ?>;
                config['catalogs'] = <?php echo $catalogs ? '["' . implode('","', $catalogs) . '"]' : '[]'; ?>;
                config['default_catalog'] = <?php echo $product['default_catalog']; ?>;
                product_ids = [];
<?php
foreach ($product['related_products'] as $key => $id)
{
        echo 'product_ids[' . $key . '] = "' . $id . '";
                ';
}
?>
        function set_search_options(){
<?php
$set_options = '<option value="0">None</option>';
$sets = Site::instance()->sets();
if (count($sets))
{
        foreach ($sets as $set)
        {
                $set_options .= '<option value="' . $set['id'] . '">' . $set['name'] . '</option>';
        }
}
?>
                var options = '<?php echo $set_options; ?>';
                $('#gs_product_set').append(options);
        }
        </script>
        <script type="text/javascript" src="/media/js/product_admin/product_edit.js"></script>

        <div class="box">
                <h3>
                        修改简单产品
                </h3>
                <form method="post" action="#"  name="product_form" class="need_validation">
                        <div id="tabs"  style="overflow:hidden;">
                                <ul>
                                        <li><a href="#tabs-1">基本信息</a></li>
                                        <li><a href="#tabs-2">产品图片</a></li>
                                        <li><a href="#tabs-3">产品规格</a></li>
                                        <li><a href="#tabs-4">产品描述</a></li>
                                        <li><a href="#tabs-5">相关产品</a></li>
                                        <li><a href="#tabs-catalogs">Catalogs</a></li>
                                        <li><a href="#tabs-6">SEO相关</a></li>
                                        <li><a href="#tabs-7">红人秀</a></li>
                                </ul>
                                <!--START tabs-1 -->
                                <div id="tabs-1">
                                        <ul>

                                                <li>
                                                        <label>名称<span class="req">*</span></label>
                                                        <div>
                                                                <input name="product[name]" id="name" class="text medium required" type="text" value="<?php echo $product['name']; ?>"/>
                                                        </div>
                                                </li>

                                                <li>
                                                        <label>SKU<span class="req">*</span></label>
                                                        <div>
                                                                <input name="product[sku]" id="sku" class="text medium required" type="text" value="<?php echo $product['sku']; ?>"/>
                                                        </div>
                                                </li>

                                                <li>
                                                        <label>URL<span class="req">*</span></label>
                                                        <div>
                                                                <input name="product[link]" id="link" class="text medium required" type="text" value="<?php echo $product['link']; ?>"/>
                                                        </div>
                                                </li>

                                                <li>
                                                        <label>Visibility</label>
                                                        <div>
                                                                <input type="radio" class="radio" name="product[visibility]" value="1" <?php if ($product['visibility'] == 1) echo ' checked = "checked" '; ?>/> Visible
                                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                                <input type="radio" class="radio" name="product[visibility]" value="0" <?php if ($product['visibility'] == 0) echo ' checked = "checked" '; ?> /> Invisible
                                                        </div>
                                                </li>

                                                <li>
                                                        <label>Pre Sale</label>
                                                        <div>
                                                                <input type="radio" class="radio" name="product[presell]" value="1" <?php if ($product['presell'] == 1) echo ' checked = "checked" '; ?>/> Yes
                                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                                <input type="radio" class="radio" name="product[presell]" value="0" <?php if ($product['presell'] == 0) echo ' checked = "checked" '; ?> /> No
                                                        </div>
                                                </li>

                                                <li>
                                                        <label>Avaliable for sale:</label>
                                                        <div>
                                                                <input type="radio" class="radio" name="product[status]" value="1" <?php if ($product['status'] == 1) echo ' checked = "checked" '; ?>/> Yes
                                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                                <input type="radio" class="radio" name="product[status]" value="0" <?php if ($product['status'] == 0) echo ' checked = "checked" '; ?>/> No
                                                        </div>
                                                </li>

                                                <li>
                                                        <label>本站价格(<?php echo Site::instance()->default_currency(); ?>)<span class="req">*</span></label>
                                                        <div>
                                                                <input name="product[price]" id="price" class="short text required number" type="text" value="<?php echo $product['price']; ?>"/> <a href="#" class="product_bulk_rules_toggle">Tier price</a>
                                                                <?php
                                                                if (!empty($product['configs']['bulk_rules']))
                                                                {
                                                                        ?>
                                                                        <div class="product_bulk_rules">
                                                                                <?php
                                                                                foreach ($product['configs']['bulk_rules'] as $num => $price)
                                                                                {
                                                                                        echo '<div>Qty &gt;= <input type="text" name="product[bulk_num][]" class="text numeric required digits" value="' . $num . '"/>, Price = <input type="text" name="product[bulk_price][]"  class="text numeric required number" value="' . trim($price) . '" /> <a href="#" class="remove_bulk_rule">[-]</a> <a href="#" class="add_bulk_rule">[+]</a></div>';
                                                                                }
                                                                                ?>
                                                                        </div>
                                                                        <?php
                                                                }
                                                                ?>
                                                        </div>
                                                        <label>市场价格(<?php echo Site::instance()->default_currency(); ?>)</label>
                                                        <div>
                                                                <input name="product[market_price]" id="market_price" class="short text number" type="text" value="<?php echo $product['market_price']; ?>"/>
                                                        </div>
                                                        <label>总成本(USD)</label>
                                                        <div>
                                                                <input name="product[cost]" id="cost" class="short text number" type="text" value="<?php echo $product['cost']; ?>"/>
                                                        </div>
                                                        <label>采购成本(RMB)</label>
                                                        <div>
                                                                <input name="product[total_cost]" id="total_cost" class="short text number" type="text" value="<?php echo $product['total_cost']; ?>"/>
                                                        </div>
                                                </li>
                                                <li>
                                                        <label>库存<span class="req">*</span></label>
                                                        <div class="form_radio_row">
                                                                <input type="radio" name="product[no_limit_stock]" class="no_limit_stock" id="no_limit_stock_yes" value="1"<?php echo $product['stock'] != -99 ? '' : ' checked="checked"'; ?>/><label for="no_limit_stock_yes"> No limit.</label><br/>
                                                                <input type="radio" name="product[no_limit_stock]" class="no_limit_stock radio" value="0"<?php echo $product['stock'] == -99 ? '' : ' checked="checked"'; ?>/>
                                                                <input name="product[stock]" id="stock" class="product_stock short text required digits" type="text"<?php echo $product['stock'] != -99 ? ' value="' . $product['stock'] . '"' : ' disabled="disabled"'; ?>>
                                                        </div>
                                                </li>

                                                <li>
                                                        <label>重量(g)<span class="req">*</span></label>
                                                        <div>
                                                                <input name="product[weight]" id="weight" class="short text required" type="text" value="<?php echo $product['weight']; ?>">
                                                        </div>
                                                </li>
                                                <li>
                                                        <label>体积(cm)<span class="req">*</span></label>
                                                        <div>
                                                                <input name="product[size]" id="size" class="short text required" type="text" value="<?php echo $product['size']; ?>">
                                                        </div>
                                                </li>

                                                <li>
                                                        <label>Brief</label>
                                                        <div>
                                                                <input name="product[brief]" id="brief" class="text short" type="text" value="<?php echo $product['brief']; ?>"/>
                                                        </div>
                                                </li>

                                                <li>
                                                        <label>Tabao URL</label>
                                                        <div>
                                                                <input name="product[taobao_url]" id="taobao_url" class="text medium" type="text" value="<?php echo $product['taobao_url']; ?>"/>
                                                        </div>
                                                </li>

                                                <li>
                                                        <label>Position</label>
                                                        <div>
                                                                <input name="product[position]" id="position" class="text medium" type="text" value="<?php echo $product['position']; ?>"/>
                                                        </div>
                                                </li>
                                        </ul>
                                </div>
                                <!--END tabs-1 -->

                                <!--START tabs-2 -->
                                <div id="tabs-2">
                                        <p>Please drag and drop to order the images.</p>
                                        <div id="upload_box">
                                        </div>
                                        <input type="hidden" name="images_default" />
                                        <input type="hidden" name="images_removed" />
                                        <input type="hidden" name="images_order"/>
                                        <ul id="images_list" class="clr">
                                                <?php
                                                $site_id = Site::instance()->get('id');
                                                foreach ($product['images'] as $image)
                                                {
                                                        if ($image['id'] == 0)
                                                                continue;
                                                        $image_name = $image['id'];
                                                        ?>
                                                        <li image_id="<?php echo $image['id']; ?>">
                                                                <img src = "/pimages/<?php echo $site_id . '/99/' . $image_name . '.' . $image['suffix']; ?>" alt="<?php echo $image['id']; ?>号产品图"/>
                                                                <div class="image_actions">
                                                                        <?php
                                                                        if (isset($product['configs']['default_image']) AND $image['id'] == $product['configs']['default_image'])
                                                                        {
                                                                                ?>
                                                                                <span id="is_default">默认&nbsp;&nbsp;</span>
                                                                                <?php
                                                                        }
                                                                        else
                                                                        {
                                                                                ?>
                                                                                <a href="#" class="image_set_default">设为默认</a>
                                                                                <?php
                                                                        }
                                                                        ?>
                                                                        <a href="#" class="image_remove">删除</a>
                                                                </div>
                                                        </li>
                                                        <?php
                                                }
                                                ?>
                                        </ul>
                                </div>
                                <!--END tabs-2 -->

                                <!--START tabs-3 -->
                                <div id="tabs-3">
                                        <ul>

                                                <?php
                                                foreach ($product['attributes'] as $attribute)
                                                {
                                                        ?>
                                                        <li>
                                                                <label><?php echo $attribute['name']; ?></label>
                                                                <div>
                                                                        <?php
                                                                        switch ($attribute['type'])
                                                                        {
                                                                                case 2:
                                                                                        ?>
                                                                                        <input type="text" name="attributes[<?php echo $attribute['id']; ?>]" class="text medium<?php if ($attribute['required']) echo ' required'; ?>" value="<?php echo!$attribute['value'] ? $attribute['default_value'] : $attribute['value']; ?>" />
                                                                                        <?php
                                                                                        break;
                                                                                case 3:
                                                                                        ?>
                                                                                        <textarea cols="60" rows="6" class="textarea<?php if ($attribute['required']) echo ' required'; ?>" name="attributes[<?php echo $attribute['id']; ?>]"><?php echo!$attribute['value'] ? $attribute['default_value'] : $attribute['value']; ?></textarea>
                                                                                        <?php
                                                                                        break;
                                                                                case 1:
                                                                                        $keys = array_keys($attribute['options']);
                                                                                        foreach ($attribute['options'] as $option)
                                                                                        {
                                                                                                ?>
                                                                                                <input type="radio" class="radio<?php if ($attribute['required']) echo ' required'; ?>" name="option_id[<?php echo $attribute['id']; ?>]" value="<?php echo $option['id']; ?>" <?php if (isset($attribute['selected_option_id']) AND $option['id'] == $attribute['selected_option_id']) echo 'checked="checked"'; ?> /> <?php echo $option['label']; ?>
                                                                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                                <?php
                                                                                        }
                                                                                        break;
                                                                                case 0:
                                                                                default:
                                                                                        ?>
                                                                                        <select name="option_id[<?php echo $attribute['id']; ?>]" class="drop<?php if ($attribute['required']) echo ' required'; ?>" >
                                                                                                <option value="">--NONE--</option>
                                                                                                <?php
                                                                                                $keys = array_keys($attribute['options']);
                                                                                                foreach ($attribute['options'] as $key => $option)
                                                                                                {
                                                                                                        ?>
                                                                                                        <option value="<?php echo $option['id']; ?>" <?php if (isset($attribute['selected_option_id']) AND $option['id'] == $attribute['selected_option_id']) echo 'selected="selected"'; ?>><?php echo $option['label']; ?></option>
                                                                                                        <?php
                                                                                                }
                                                                                                ?>
                                                                                        </select>
                                                                                        <?php
                                                                                        break;
                                                                        }
                                                                        ?>
                                                                        <label class="note"><?php echo $attribute['brief']; ?></label>
                                                                </div>
                                                        </li>
                                                        <?php
                                                }
                                                ?>
                                        </ul>
                                </div>
                                <!--END tabs-3 -->

                                <!--START tabs-4 -->
                                <div id="tabs-4">
                                        <ul>
                                                <li>
                                                        <div>
                                                                <textarea name="product[description]" id="description" rows="6" cols="60" class="textarea"><?php echo $product['description']; ?></textarea>
                                                        </div>
                                                </li>
                                        </ul>
                                </div>
                                <!--END tabs-4 -->

                                <!--START tabs-5 -->
                                <div id="tabs-5">

                                        <div id="grid_head_bar" class="clr">
                                                <div class="float_left">&nbsp;<input type="checkbox" id="select_all"/><label for="select_all">全选</label></div>
                                                <a href="#" class="float_left" id="view_selected_products">预览我已选的产品列表</a>( <span id="selected_num"><?php echo count($product['related_products']); ?></span> selected )
                                                <a href="#" class="float_right" id="search_grid">过滤</a>
                                                <a href="#" class="float_right" id="reset_search_grid">查看所有产品</a>
                                        </div>
                                        <div>
                                                <table id="toolbar"></table>
                                                <div id="ptoolbar"></div>
                                        </div>

                                </div>
                                <!--END tabs-5 -->

                                <!--START tabs-catalogs -->
                                <div id="tabs-catalogs" class="clr">
                                        <?php echo $catalog_checkboxes_tree; ?>
                                </div>
                                <!--END tabs-catalogs -->

                                <!--START tabs-6 -->
                                <div id="tabs-6">
                                        <ul>

                                                <li>
                                                        <label>META TITLE</label>
                                                        <div>
                                                                <input name="product[meta_title]" id="meta_title" class="text long" type="text" value="<?php echo $product['meta_title']; ?>"/>
                                                        </div>
                                                </li>

                                                <li>
                                                        <label>META KEYWORDS</label>
                                                        <div>
                                                                <input name="product[meta_keywords]" id="meta_keywords" class="text long" type="text" value="<?php echo $product['meta_keywords']; ?>"/>
                                                        </div>
                                                </li>

                                                <li>
                                                        <label>META DESCRIPTION</label>
                                                        <div>
                                                                <textarea name="product[meta_description]" id="meta_description" rows="6" cols="60" class="textarea"><?php echo $product['meta_description']; ?></textarea>
                                                        </div>
                                                </li>

                                        </ul>
                                </div>
                                <!--END tabs-6 -->

                                <!--START tabs-7 -->
                                <script type="text/javascript">
                                        config1 = {};
                                        config1['image_tempfolder'] = 'http://<?php echo Site::instance()->get('domain'); ?>/simages';
                                        config1['catalog_id'] = '';
                                        config1['image_allowed_extensions'] = ["<?php echo implode('","', kohana::config('upload.product_image.filetypes')); ?>"];
                                        config1['image_max_size'] = <?php echo kohana::config('upload.product_image.max_size'); ?>;
                                        uploaded1 = {
                                                'images':[] ,
                                                'add':function(filename){
                                                        this.images.push(filename);
                                                        $('input[name=images]').val(this.images.join(','));
                                                        //TODO 修改具体样式：
                                                        var image_li = '\
                                                                <li image_name="'+ filename + '">\n\
                                                                <input type="hidden" name="position[]" value="'+filename+'" />\n\
                                                                <img src = "' + config1['image_tempfolder'] + '/'+ filename + '" />\n\
                                                                <div class="image_actions1">\n\
                                                                <a href="#" class="image_remove1">删除</a>\n\
                                                                </div>\n\
                                                                </li>';
                                                                                        $('#images_list1').append(image_li);
                                                                                        $image_src = $('input[name=image_src1]');
                                                                                        $image_src.val($image_src.val() + ($image_src.val()  == '' ? '' : ',') + filename);
                                                                                },
                                                                                'remove':function(filename){
                                                                                        var idx = $.inArray(filename, this.images),
                                                                                        $input_removed = $('input[name=images_removed1]');
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
                                                                                        element: document.getElementById('upload_box1'),
                                                                                        action: '/admin/site/image/embed_manager',
                                                                                        params:{ 
                                                                                                folder:'site_image'
                                                                                        },
                                                                                        allowedExtensions:config1['image_allowed_extensions'],
                                                                                        sizeLimit:config1['image_max_size'],
                                                                                        onComplete:function(id, fileName, responseJSON) {
                                                                                                if(responseJSON['success'] == 'true'){
                                                                                                        uploaded1.add(responseJSON['filename']);
                                                                                                }
                                                                                        }
                                                                                });
                                                                                $('.qq-upload-drop-area').click(function(){this.style.display = 'none';});
                                                                                $('.image_remove1').live('click',function(){
                                                                                        var $li = $(this).parent().parent();
                                                                                        uploaded1.remove($li.attr('image_name'));
                                                                                        $li.remove();
                                                                                        return false;
                                                                                });
                        
                                                                                $(".delete_image_src").click(function(){
                                                                                        $(this).parent().hide();
                                                                                        var image = $(this).attr('title');
                                                                                        $input_removed = $('input[name=images_removed2]');
                                                                                        $input_removed.val($input_removed.val() + ($input_removed.val()  == '' ? '' : ',') + image);
                                                                                })
                                                                                
                                                                                $( "#images_list1" ).sortable({
                                                                                        stop: function(event, ui)
                                                                                        {
                                                                                                images_order = $('input[name=images_order]');
                                                                                                images_order.val('');
                                                                                                $.each($('#images_list1 li'),function(){
                                                                                                        images_order.val(images_order.val() + (images_order.val()  == '' ? '' : ',') + $(this).attr('image_id'))
                                                                                                });
                                                                                        }
                                                                                });
                                                                                $( "#images_list1" ).disableSelection();
                                                                        })
                                </script>
                                <div id="tabs-7">
                                        <fieldset class="clr">
                                                <legend>Images<span class="req">*</span></legend>
                                                <ul id="images_list1" style="margin-bottom:15px;">
                                                        <?php
                                                        foreach ($celebrity_images as $image):
                                                                ?>
                                                                <li style="margin: 0pt 0pt 15px;">
                                                                        <h4><?php echo $image['id']; ?> images:</h4>
                                                                        <input type="hidden" name="position[]" value="<?php echo $image['image']; ?>" />
                                                                        <img height="200px" src="<?php echo 'http://' . Site::instance()->get('domain') . '/simages/' . $image['image']; ?>" style="border:solid 1px #CCC;" />
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;<a href="#" title="<?php echo $image['image']; ?>" style="color:red;" class="delete_image_src">Delete</a>
                                                                </li>
                                                                <?php
                                                        endforeach;
                                                        ?>
                                                </ul>
                                                <div id="upload_box1"></div>
                                                <input type="hidden" name="image_src1" />
                                                <input type="hidden" name="images_removed1" />
                                                <input type="hidden" name="images_removed2" />
                                        </fieldset>
                                </div>
                                <!--END tabs-7 -->
                        </div>

                        <ul>

                                <li>
                                        <input value="Submit" class="button" type="submit" />
                                        <input value="Reset" class="button" type="button" />
                                </li>
                        </ul>
                </form>
        </div>
</div>
