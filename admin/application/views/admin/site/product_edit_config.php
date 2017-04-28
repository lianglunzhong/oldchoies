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
                config['set_id'] = <?php echo $product['set_id']; ?>;
                config['configurable_attributes'] = '<?php echo implode(',', $product['configs']['configurable_attributes']); ?>';
                config['product_id'] = <?php echo $product['id']; ?>;
                config['currency_code'] = '<?php echo Site::instance()->default_currency(); ?>';
                config['catalogs'] = <?php echo $catalogs ? '["'.implode('","', $catalogs).'"]' : '[]'; ?>;
                config['default_catalog'] = <?php echo $product['default_catalog']; ?>;
                selected_packaged = [];
                product_ids = [];
<?php
foreach( $product['related_products'] as $key => $id )
{
        echo 'product_ids['.$key.'] = "'.$id.'";
                ';
}
?>
                function set_search_options(){
<?php
$set_options = '<option value="0">None</option>';
$sets = Site::instance()->sets();
if(count($sets))
{
        foreach( $sets as $set )
        {
                $set_options .= '<option value="'.$set['id'].'">'.$set['name'].'</option>';
        }
}
?>
                        var options = '<?php echo $set_options; ?>';
                        $('#gs_product_set').append(options);
                }
        </script>
        <script type="text/javascript" src="/media/js/product_admin/configurable_product_admin.js"></script>
        <script type="text/javascript" src="/media/js/product_admin/product_edit.js"></script>

        <div class="box">
                <h3>
                        修改配置产品
                </h3>
                <form method="post" action="#" name="product_form" class="need_validation">
                        <div id="tabs"  style="overflow:hidden;">
                                <ul>
                                        <li><a href="#tabs-1">基本信息</a></li>
                                        <li><a href="#tabs-2">产品图片</a></li>
                                        <li><a href="#tabs-3">规格参数</a></li>
                                        <li><a href="#tabs-4">产品描述</a></li>
                                        <li><a href="#tabs-5">关联产品</a></li>
                                        <li><a href="#tabs-6">相关产品</a></li>
                                        <li><a href="#tabs-catalogs">Catalogs</a></li>
                                        <li><a href="#tabs-7">SEO相关</a></li>
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
                                                                <input type="radio" class="radio" name="product[visibility]" value="1" <?php if($product['visibility'] == 1) echo ' checked = "checked" '; ?>/> Visible
                                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                                <input type="radio" class="radio" name="product[visibility]" value="0" <?php if($product['visibility'] == 0) echo ' checked = "checked" '; ?> /> Invisible
                                                        </div>
                                                </li>

                                                <li>
                                                        <label>Now for sale:</label>
                                                        <div>
                                                                <input type="radio" class="radio" name="product[status]" value="1" <?php if($product['status'] == 1) echo ' checked = "checked" '; ?>/> Yes
                                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                                <input type="radio" class="radio" name="product[status]" value="0" <?php if($product['status'] == 0) echo ' checked = "checked" '; ?>/> No
                                                        </div>
                                                </li>

                                                <li>
                                                        <label>本站价格(<?php echo Site::instance()->default_currency(); ?>)<span class="req">*</span></label>
                                                        <div>
                                                                <input name="product[price]" id="price" class="short text required number" type="text" value="<?php echo $product['price']; ?>"/>
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
                                                        <label>Weight(g)<span class="req">*</span></label>
                                                        <div>
                                                                <input name="product[weight]" id="weight" class="short text required" type="text" value="<?php echo $product['weight']; ?>">
                                                        </div>
                                                </li>

                                                <li>
                                                        <label>Brief</label>
                                                        <div>
                                                                <input name="product[brief]" id="brief" class="text short" type="text" value="<?php echo $product['brief']; ?>"/>
                                                        </div>
                                                </li>

                                                <li>
                                                        <label>Modify all the SKUs under this config product?</label>
                                                        <div>
                                                                <input type="radio" class="radio" name="for_all" value="1" /> Yes
                                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                                <input type="radio" class="radio" name="for_all" value="0" checked/> No
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
                                                foreach( $product['images'] as $image )
                                                {
                                                        if($image['id'] == 0) continue;
                                                        $image_name = $image['id'];
                                                        ?>
                                                        <li image_id="<?php echo $image['id']; ?>">
                                                                <img src = "/pimages/<?php echo $site_id.'/99/'.$image_name.'.'.$image['suffix']; ?>" alt="<?php echo $image['id']; ?>号产品图"/>
                                                                <div class="image_actions">
                                                                        <?php
                                                                        if(isset($product['configs']['default_image']) AND $image['id'] == $product['configs']['default_image'])
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
                                                foreach( $product['attributes'] as $attribute )
                                                {
                                                        if(isset($product['configs']['configurable_attributes']) AND ! in_array($attribute['id'], $product['configs']['configurable_attributes']))
                                                        {
                                                                ?>
                                                                <li>
                                                                        <label><?php echo $attribute['name']; ?></label>
                                                                        <div>
                                                                                <?php
                                                                                switch( $attribute['type'] )
                                                                                {
                                                                                        case 2:
                                                                                                ?>
                                                                                                <input type="text" name="attributes[<?php echo $attribute['id']; ?>]" class="text medium<?php if($attribute['required']) echo ' required'; ?>" value="<?php echo ! $attribute['value'] ? $attribute['default_value'] : $attribute['value']; ?>" />
                                                                                                <?php
                                                                                                break;
                                                                                        case 3:
                                                                                                ?>
                                                                                                <textarea cols="60" rows="6" class="textarea<?php if($attribute['required']) echo ' required'; ?>" name="attributes[<?php echo $attribute['id']; ?>]"><?php echo ! $attribute['value'] ? $attribute['default_value'] : $attribute['value']; ?></textarea>
                                                                                                <?php
                                                                                                break;
                                                                                        case 1:
                                                                                                $keys = array_keys($attribute['options']);
                                                                                                foreach( $attribute['options'] as $option )
                                                                                                {
                                                                                                        ?>
                                                                                                        <input type="radio" class="radio<?php if($attribute['required']) echo ' required'; ?>" name="option_id[<?php echo $attribute['id']; ?>]" value="<?php echo $option['id']; ?>" <?php if(isset($attribute['selected_option_id']) AND $option['id'] == $attribute['selected_option_id']) echo 'checked="checked"'; ?> /> <?php echo $option['label']; ?>
                                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                                        <?php
                                                                                                }
                                                                                                break;
                                                                                        case 0:
                                                                                        default:
                                                                                                ?>
                                                                                                <select name="option_id[<?php echo $attribute['id']; ?>]" class="drop<?php if($attribute['required']) echo ' required'; ?>" >
                                                                                                        <option value="">--NONE--</option>
                                                                                                        <?php
                                                                                                        $keys = array_keys($attribute['options']);
                                                                                                        foreach( $attribute['options'] as $option )
                                                                                                        {
                                                                                                                ?>
                                                                                                                <option value="<?php echo $option['id']; ?>" <?php if(isset($attribute['selected_option_id']) AND $option['id'] == $attribute['selected_option_id']) echo 'selected="selected"'; ?>><?php echo $option['label']; ?></option>
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
                                                        else
                                                        {
                                                                $config_attr[$attribute['id']] = $attribute;
                                                        }
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
                                        <fieldset id="create_simple_form">
                                                <legend>选择属性值，自动组合创建所有关联产品</legend>
                                                <div class="clr">
                                                        <?php
                                                        ksort($config_attr);
                                                        foreach( $config_attr as $attribute )
                                                        {
                                                                echo '<div class="filter_condition_little_box config_attribution" id="attr_'.$attribute['id'].'">
								  <div class="filter_condition_little_box_title">'.$attribute['name'].'</div>
								  <div class="filter_condition_little_box_content">';
                                                                echo '<div style="float:right;margin-right:5px;font-size:10px;"><a href="javascript:void(0)" onclick="$(\'.check_'.$attribute['id'].'\').attr(\'checked\', true);">all</a> / <a href="javascript:void(0)" onclick="$(\'.check_'.$attribute['id'].'\').attr(\'checked\', false);">none</a></div>';
                                                                foreach( $attribute['options'] as $option )
                                                                {
                                                                        echo '<div class="filter_condition_checkboxs"><input type="checkbox" value="'.$option['id'].'" id="condition_option_'.$option['id'].'"  class="check_'.$attribute['id'].'"/><label for="condition_option_'.$option['id'].'">'.$option['label'].'</label></div>';
                                                                }
                                                                echo '
		</div>
		</div>';
                                                        }
                                                        ?>
                                                </div>
                                                <br />
                                                <button id="create_associated_product" count="<?php echo $max_associated_sku; ?>">创建关联产品</button><span id="create_notice"></span>
                                        </fieldset>
                                        <fieldset>
                                                <legend>已关联的产品</legend>
                                                <div id="selected_associated_products">
                                                        <?php
                                                        $js_created = array( );
                                                        $input_created = array( );
                                                        foreach( $product['associated_products'] as $product_id => $opts )
                                                        {
                                                                $ids = array( );
                                                                $name = '';
                                                                ksort($opts['options']);
                                                                foreach( $opts['options'] as $attr_id => $opt_id )
                                                                {
                                                                        $ids[] = 'attr_'.$attr_id.'__'.$opt_id;
                                                                        //									echo $attr_id.'<br />';
                                                                        $name .= $product['attributes'][$attr_id]['name'].': '.$product['attributes'][$attr_id]['options'][$opt_id]['label'].'&nbsp;&nbsp;';
                                                                }
                                                                sort($ids);
                                                                $id = implode('-', $ids);
                                                                $js_created[$id] = 1;
                                                                $input_created[] = $product_id;
                                                                ?>
                                                                <div class="associated_product" id="<?php echo $id; ?>">
                                                                        <div class="product_title clr" product_key="<?php echo $product_id; ?>"><a href="#" product_id ="<?php echo $product_id; ?>" class="remove_selected_product">Cancel</a><a href="/admin/site/product/edit/<?php echo $product_id; ?>" target="_blank">Edit</a><?php echo (isset($product['configs']['default_item']) AND $product['configs']['default_item'] == $product_id) ? '<a href="javascript:return false;" id="is_default_product"><strong>Default</strong></a>' : '<a class="product_set_default" href="#">Set as Default</a>'; ?><?php echo $name.', (#'.$product_id.') '.Product::instance($product_id)->get('name'); ?> </div>
                                                                </div>
                                                                <?php
                                                        }
                                                        ?>
                                                        <script type="text/javascript">
                                                                $(function(){
                                                                        do_products.created = <?php echo json_encode($js_created); ?>;
                                                                        selected_associated = [<?php if(count($input_created)) echo '"'.implode('","', $input_created).'"'; ?>];
                                                                });
                                                        </script>
                                                </div>
                                        </fieldset>
                                        <fieldset id="selecte_simple_form">
                                                <legend>选择已有的简单产品:</legend>
                                                <input type="hidden" id="associated_ids" name="associated_ids" value="<?php echo implode(',', $input_created); ?>" />
                                                <table id="atoolbar"></table>
                                                <div id="aptoolbar"></div>
                                        </fieldset>
                                        <input type="hidden" name="default_item" value="<?php echo isset($product['configs']['default_item']) ? $product['configs']['default_item'] : ''; ?>"/>
                                </div>
                                <!--END tabs-5 -->
                                <!--START tabs-6 -->
                                <div id="tabs-6">
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
                                <!--END tabs-6 -->

                                <!--START tabs-catalogs -->
                                <div id="tabs-catalogs" class="clr">
                                        <?php echo $catalog_checkboxes_tree; ?>
                                </div>
                                <!--END tabs-catalogs -->

                                <!--START tabs-7 -->
                                <div id="tabs-7">
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
