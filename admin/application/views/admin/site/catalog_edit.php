<?php echo View::factory('admin/site/catalog_left')->set('catalog_tree', $catalog_tree)->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript">
    config = {};
    config['catalog_id'] = <?php echo $catalog->id; ?>;
    config['image_allowed_extensions'] = ["<?php echo implode('","', kohana::config('upload.product_image.filetypes')); ?>"];
    config['image_max_size'] = <?php echo kohana::config('upload.product_image.max_size'); ?>;
    $(function(){
        $('#parent_id option[value=<?php echo $catalog->parent_id; ?>]').attr('selected',true);
        
        $('.filter_condition_checkboxs input').filter(':checked').each(function(){
            $(this).parent().find('label').addClass('filter_condition_checkboxs_label_selected');
        });
        
        $('#catalog_tree input[type=checkbox]').each(function(){
            var $this = $(this);
            if($.inArray($this.val(), catalogs) != -1) {
                $this.attr('checked','checked');
            }
        });
        
    });
</script>
<script type="text/javascript" src="/media/js/catalog/catalog_admin.js"></script>
<?php
if (!$catalog->is_filter)
{
    ?>
    <script type="text/javascript">
        product_ids = [];
    <?php
    foreach ($product_ids as $key => $id)
    {
        echo "product_ids[$key] = '$id';
";
    }
    ?>
        function set_search_options(){
            var $gs_product_set = $('#gs_product_set');
            $gs_product_set.append('<option value="0">无</option>');
    <?php
    $sets = Site::instance()->sets();
    if (count($sets))
    {
        foreach ($sets as $set)
        {
            ?>
                            $gs_product_set.append('<option value="<?php echo $set['id']; ?>"><?php echo $set['name']; ?></option>');
            <?php
        }
    }
    ?>
        }
    </script>
    <script type="text/javascript" src="/media/js/catalog/catalog_basic_admin.js"></script>
    <?php
}
else
{
    ?>
    <script type="text/javascript">
        options_selected = [<?php echo $filter->options; ?>];
    </script>
    <script type="text/javascript" src="/media/js/catalog/catalog_conditional_admin.js"></script>
    <?php
}
?>
<script type="text/javascript" src="/media/js/file-uploader/fileuploader.js"></script>
<link rel="stylesheet" type="text/css" href="/media/js/file-uploader/fileuploader.css" />

<div id="do_right" class="catalog_right">
    <div class="box" style="overflow:hidden;">
        <h3>
            <span class="moreActions">
                <a href="/admin/site/catalog/add<?php echo $catalog->is_filter ? '/conditional' : ''; ?>">添加<?php echo $catalog->is_filter ? '条件' : ''; ?>分类</a>
            </span>
            修改<?php echo $catalog->is_filter ? '条件' : ''; ?>分类
        <?php
            $languages = Kohana::config('sites.1.language');
            $now_lang = Arr::get($_GET, 'lang', 'en');
            foreach($languages as $l)
            {
                ?>
                <a class="product_list"  href="/admin/site/catalog/edit/<?php echo $catalog->id; ?><?php if($l != 'en') echo '?lang=' . $l; ?>" <?php if($now_lang == $l) echo 'style="color:red"'; ?>><?php echo $l; ?></a>
                <?php
            }
        ?>
        </h3>
        <form method="post" action="#" class="need_validation" id="catalog_set" enctype="multipart/form-data">
            <?php
            $lang = Arr::get($_GET, 'lang', '');
            if($lang)
            {
                ?>
            <input type="hidden" name="lang" value="<?php echo $lang; ?>" />
            <?php
            }
            ?>

            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Basic</a></li>
                    <li><a href="#tabs-2" class="lang_hide"><?php echo $catalog->is_filter ? 'Filter' : 'Products'; ?></a></li>
                    <li><a href="#tabs-3" class="lang_hide">Search Bar</a></li>
                    <li><a href="#tabs-4" class="">SEO</a></li>
                    <li><a href="#tabs-5">Others</a></li>
                </ul>
                <!--START tabs-1 -->
                <div id="tabs-1">
                    <ul>

                        <li>
                            <label>Parent Catalog</label>
                            <div>
                                <select class="drop required" name="parent_id" id="parent_id">
                                    <option value="0">--ROOT--</option>
                                    <?php
                                    echo $catalog_opt == '' ? '<option value="0">ROOT</option>' : $catalog_opt;
                                    ?>
                                </select>
                            </div>
                        </li>

                        <li>
                            <label>Name<span class="req">*</span></label>
                            <div>
                                <input name="catalog_name" id="catalog_name" class="text medium required" type="text" value="<?php echo $catalog->name; ?>" />
                            </div>
                        </li>

                        <li>
                            <label>URL<span class="req">*</span></label>
                            <div>
                                <input name="link" id="link" class="text medium required" type="text" title="<?php echo $catalog->link; ?>" value="<?php echo $catalog->link; ?>" />
                            </div>
                        </li>

                        <li>
                            <label><span class="req">推广URL</span>:</label>
                            <?php echo $catalog->link . '-c-' . $catalog->id; ?>
                        </li>

                        <li>
                            <label>Products order by</label>
                            <div>
                                <select name="orderby" class="drop">
                                    <option value="created"<?php echo $catalog->orderby == 'created' ? ' selected="selected"' : ''; ?>>Created time</option>
                                    <option value="hits"<?php echo $catalog->orderby == 'hits' ? ' selected="selected"' : ''; ?>>Number purchased</option>
                                    <option value="name"<?php echo $catalog->orderby == 'name' ? ' selected="selected"' : ''; ?>>Name</option>
                                    <option value="price"<?php echo $catalog->orderby == 'price' ? ' selected="selected"' : ''; ?>>Price</option>
                                </select>
                                <select name="desc" class="drop">
                                    <option value="desc"<?php echo $catalog->desc == 'desc' ? ' selected="selected"' : ''; ?>>Descending</option>
                                    <option value="asc"<?php echo $catalog->desc == 'asc' ? ' selected="selected"' : ''; ?>>Ascending</option>
                                </select>
                            </div>
                        </li>

                        <li>
                            <label>Visibility</label>
                            <div style="margin-top:10px;">
                                <input type="radio" name="catalog_visibility" value="1" id="visibility_yes" <?php echo $catalog->visibility ? 'checked = "checked" ' : ''; ?>/><label for="visibility_yes"> Yes</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="catalog_visibility" value="0" id="visibility_no"  <?php echo $catalog->visibility ? '' : 'checked = "checked" '; ?>/><label for="visibility_no"> No</label>
                            </div>
                        </li>

                        <li>
                            <label>Listed on menu</label>
                            <div style="margin-top:10px;">
                                <input type="radio" name="on_menu" value="1" id="on_menu_yes" <?php echo $catalog->on_menu ? 'checked = "checked" ' : ''; ?>/><label for="on_menu_yes"> Yes</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="on_menu" value="0" id="on_menu_no"  <?php echo $catalog->on_menu ? '' : 'checked = "checked" '; ?>/><label for="on_menu_no"> No</label>
                            </div>
                        </li>

                        <?php if ($show_stereotyped): ?>
                            <li>
                                <label>Stereotyped modules</label>
                                <div style="margin-top:10px;">
                                    <label><input type="radio" name="stereotyped_m" value="1" id="on_menu_yes" <?php echo $catalog->stereotyped ? 'checked = "checked" ' : ''; ?>/> Show</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" name="stereotyped_m" value="0" id="on_menu_no"  <?php echo $catalog->stereotyped ? '' : 'checked = "checked" '; ?>/> Hidden</label>
                                </div>
                                <fieldset>
                                    <legend>Sample</legend>
                                    <p>Geartaker offers the high quality but low price (分类超链接) for all customers online. All of them are strictly pick-up from the mainstream market, they are produced by those famous professional manufacturers who come to agreements with us. So, the product's quality... </p>
                                </fieldset>
                            </li>
                        <?php endif; ?>

                        <li>
                            <label>Template</label>
                            <div>
                                <input name="template" id="template" class="text short" type="text" value="<?php echo $catalog->template; ?>" />
                            </div>
                        </li>

                        <li>
                            <label>Description</label>
                            <div>
                                <textarea name="description" id="meta_description" rows="6" cols="60" tabindex="1" class="textarea"><?php echo $catalog->description; ?></textarea>
                            </div>
                        </li>
                        <li>
                            <label>hot catalog & link(格式：dresses,dresses-c-92)</label>
                            <div>
                                <textarea name="hot_catalog" id="hot_catalog" rows="6" cols="60" tabindex="1" class="textarea"><?php
                                if(!empty($catalog->hot_catalog))
                                {
                                    $hot_catalog = unserialize($catalog->hot_catalog);
                                    foreach ($hot_catalog as $key => $value)
                                    {
                                           echo $value;
                                           echo "\r\n";
                                    }    
                                }

                                 ?>
                                </textarea>
                            </div>
                        </li>

                        <li>
                            <label>Is Brand</label>
                            <div style="margin-top:10px;">
                                <input type="radio" name="is_brand" value="1" id="brand_yes" <?php echo $catalog->is_brand ? 'checked = "checked" ' : ''; ?>/><label for="brand_yes"> Yes</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="is_brand" value="0" id="brand_no"  <?php echo $catalog->is_brand ? '' : 'checked = "checked" '; ?>/><label for="brand_no"> No</label>
                            </div>
                        </li>

                        <li>
                            <label>Position</label>
                            <div>
                                <input name="position" id="position" class="text short" type="text" value="<?php echo $catalog->position; ?>" />
                            </div>
                        </li>

                    </ul>
                </div>
                <!--END tabs-1 -->

                <!--START tabs-2 -->
                <div id="tabs-2">
                    <?php
                    if (!$catalog->is_filter)
                    {
                        ?>
                        <div id="grid_head_bar" class="clr">
                            <div class="float_left">&nbsp<a id="select_all" class="inline_link" href="#">All</a>&nbsp;|&nbsp;<a id="invert_all" class="inline_link" href="#">Invert</a></div>
                            <a href="#" class="float_left" id="view_selected_products">预览我的修改结果</a>
                            <div class="float_left">( <span id="selected_num"><?php echo count($product_ids); ?></span> selected )</div>
                            <a href="#" class="float_right" id="search_grid">过滤</a>
                            <a href="#" class="float_right" id="reset_search_grid">查看所有产品</a>
                        </div>
                        <div>
                            <table id="toolbar"></table>
                            <div id="ptoolbar"></div>
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <div class="filter_condition">
                            <label for="price_lower">价格区间($)</label>: 从
                            <input type="text" name="condition[price_lower]" id="price_lower" class="text numeric inline" value="<?php echo $filter->price_lower ? $filter->price_lower : ($filter->price_upper ? 0 : ''); ?>" />
                            到
                            <input type="text" name="condition[price_upper]" class="text numeric inline" value="<?php echo $filter->price_upper ? $filter->price_upper : ''; ?>" />
                        </div>

                        <div class="filter_condition">
                            <fieldset class="clr">
                                <legend>选择商品类型:</legend>
                                <?php
                                $sets_selected = explode(',', $filter->sets);
                                foreach ($sets as $set)
                                {
                                    echo '
												<div class="filter_condition_checkboxs"><input class="sets_checkboxes" type="checkbox" name="condition[sets][]" value="' . $set->id . '" id="condition_set_' . $set->id . '" ' . (in_array($set->id, $sets_selected) ? ' checked="checked"' : '') . ' /><label for="condition_set_' . $set->id . '"> ' . $set->name . '</label></div>';
                                }
                                ?>
                            </fieldset>
                        </div>
                        <div class="filter_condition">
                            <fieldset class="clr" id="attributes_box">
                                <legend>选择商品属性:</legend>
                            </fieldset>
                        </div>
                        <?php
                    }
                    ?>
                    <div>
                        <div>
                            <button onclick="return export_products(<?php echo $catalog->id; ?>);">Export products</button>&nbsp;&nbsp;&nbsp;
                            <button onclick="return delete_products(<?php echo $catalog->id; ?>);">批量清空分类下的产品</button>
                            <button onclick="return catalogdelete_products(<?php echo $catalog->id; ?>);">批量分类下产品置0</button>
                            
                        </div>
                        <fieldset>
                            <div style="width:270px;float:left;">
                                <h4>批量分类产品关联</h4>
                                <div><span style="color:#FF0000" >注意： (会覆盖原来的分类产品)</span>一行一个SKU</div>
                                <div><span>请输入产品SKU:</span><br />
                                    <input type="hidden" name="catalog_id" value="<?php echo $catalog->id; ?>" />
                                    <textarea name="SKUARR"  cols="30" rows="15" ></textarea>       
                                </div>
                                <input type="submit" value="Relate" id="products_relate" />
<!--                                                                        <input type="submit" value="Unrelate" id="products_unrelate" />-->
                            </div>
                            <div style="width:250px;float:left;">
                                <h4>批量分类产品添加</h4>
                                <div><span style="color:#FF0000" >注意： </span>一行一个SKU</div>
                                <div><span>请输入产品SKU:</span><br />
                                    <input type="hidden" name="catalog_id" value="<?php echo $catalog->id; ?>" />
                                    <textarea name="SKUARR1"  cols="30" rows="15" ></textarea>      
                                </div>
                                <input type="submit" value="Add" id="products_add" />
<!--                                                                        <input type="submit" value="Unrelate" id="products_unrelate" />-->
                            </div>
                            <div style="width:250px;float:left;">
                                <h4>批量分类产品置顶显示</h4>
                                <div><span style="color:#FF0000" ></span>一行一个SKU</div>
                                <div><span>请输入产品SKU:</span><br />
                                    <input type="hidden" name="catalog_id" value="<?php echo $catalog->id; ?>" />
                                    <textarea name="SKUARR2" cols="30" rows="15" ></textarea>       
                                </div>
                                <input type="submit" value="Submit" id="products_top" />
<!--                                                                        <input type="submit" value="Unrelate" id="products_unrelate" />-->
                            </div>
                            <div style="width:250px;float:left;">
                                <h4>批量分类Position置零</h4>
                                <div><span style="color:#FF0000" ></span>一行一个SKU</div>
                                <div><span>请输入产品SKU:</span><br />
                                    <input type="hidden" name="catalog_id" value="<?php echo $catalog->id; ?>" />
                                    <textarea name="SKUARR3" cols="30" rows="15" ></textarea>       
                                </div>
                                <input type="submit" value="Submit" id="products_zero" />
                            </div>
                            <?php if($catalog->on_menu){ ?>
                            <div style="width:250px;float:left;">
                                <h4>批量产品positon设置</h4>
                                <div><span style="color:#FF0000" ></span>格式如右:CDZT4321212,2</div>
                                <div><span>CDZT4321212,3</span><br />
                                    <input type="hidden" name="catalog_id" value="<?php echo $catalog->id; ?>" />
                                    <textarea name="SKUARR4" cols="30" rows="15" ></textarea>       
                                </div>
                                <input type="submit" value="Submit" id="products_zero12" />
                            </div>
                            <?php }else{ ?>
                            <div style="width:250px;float:left;">
                                <h4>批量营销分类positon设置</h4>
                                <div><span style="color:#FF0000" ></span>格式如右:CDZT4321212,2</div>
                                <div><span>CDZT4321212,3</span><br />
                                    <input type="hidden" name="catalog_id" value="<?php echo $catalog->id; ?>" />
                                    <textarea name="SKUARR5" cols="30" rows="15" ></textarea>       
                                </div>
                                <input type="submit" value="Submit" id="products_zero13" />
                            </div>
                            <?php } ?>
                        </fieldset>
                    </div>
                </div>
                <!--END tabs-2 -->
                <!--START tabs-3 -->
                <div id="tabs-3">
                    <div class="filter_condition filter_condition_sets">
                        <fieldset class="clr">
                            <legend>Searchable attributes:</legend>
                            <div class="filter_condition_sets_check_box" style="height:auto;">
                                <?php
                                $searchable_selected = explode(',', $catalog->searchable_attributes);
                                foreach ($searchable_attributes as $attribute)
                                {
                                    echo '
                                                                <div class="filter_condition_checkboxs"><input type="checkbox" name="searchable_attributes[]" value="' . $attribute->id . '" id="condition_set_' . $attribute->id . '" ' . (in_array($attribute->id, $searchable_selected) ? ' checked="checked"' : '') . ' /><label for="condition_set_' . $attribute->id . '" title="' . $attribute->name . '"> ' . $attribute->name . '</label></div>';
                                }
                                ?>
                            </div>
                        </fieldset>
                        <ul>
                            <li>
                                <label>Price Ranges</label>
                                <div>
                                    <input type="text" class="text medium" name="price_ranges" value="<?php echo $catalog->price_ranges; ?>"/><br />e.x. "5,7" means "(0,5],(5,7]"
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--END tabs-3 -->
                <!--START tabs-4 -->
                <div id="tabs-4">

                    <ul>

                        <li>
                            <label>META TITLE</label>
                            <div>
                                <input name="meta_title" id="meta_title" class="text long" type="text" value="<?php echo $catalog->meta_title; ?>"/>
                            </div>
                        </li>

                        <li>
                            <label>META KEYWORDS</label>
                            <div>
                                <input name="meta_keywords" id="meta_keywords" class="text long" type="text" value="<?php echo $catalog->meta_keywords; ?>"/>
                            </div>
                        </li>

                        <li>
                            <label>META DESCRIPTION</label>
                            <div>
                                <textarea name="meta_description" id="meta_description" rows="6" cols="60" tabindex="1" class="textarea"><?php echo $catalog->meta_description; ?></textarea>
                            </div>
                        </li>

                    </ul>
                </div>
                <!--END tabs-4 -->
                <!--START tabs-5 -->
                <div id="tabs-5">
                    <fieldset class="clr">
                        <legend>Recommended Products</legend>
                        <ul>
                            <li>
                                <label>Product IDs</label>
                                <div>
                                    <input type="text" class="text medium" name="recommended_products" value="<?php echo $catalog->recommended_products; ?>" /><br />e.x. "524,528,36"
                                </div>
                            </li>
                        </ul>
                    </fieldset>
                    <fieldset class="clr">
                        <legend>Banner Image</legend>

                        <div id="upload_box"></div>
                        <div id="image_preview" style="margin-bottom:15px;"><?php
                                if ($catalog->image_src)
                                {
                                    echo '<img src="http://' . Site::instance()->get('domain') . '/uploads/1/simages/' . $catalog->image_src . '" />';
                                }
                                ?></div>
                        Image: <span id="image_filename"><?php
                            if ($catalog->image_src)
                            {
                                echo $catalog->image_src;
                            }
                                ?></span>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"<?php
                            if (!$catalog->image_src)
                            {
                                echo ' style="display:none"';
                            }
                                ?> id="delete_image_src">Delete</a>
                        <input type="hidden" name="image_src" value="<?php
                                                              if ($catalog->image_src)
                                                              {
                                                                  echo $catalog->image_src;
                                                              }
                                ?>"/>
                        <input type="hidden" name="image_bak" value="<?php
                               if ($catalog->image_src)
                               {
                                   echo $catalog->image_src;
                               }
                                ?>" />

                        <ul style="margin-top:20px;">
                            <li>
                                <label>Image link</label>
                                <div>
                                    <input name="image_link" id="image_link" class="text long" type="text" value="<?php echo $catalog->image_link; ?>" />
                                </div>
                            </li>

                            <li>
                                <label>Image alt</label>
                                <div>
                                    <input name="image_alt" id="image_alt" class="text long" value="<?php echo $catalog->image_alt; ?>" type="text">
                                </div>
                            </li>

                            <li>
                                <label>Image Map</label>
                                <div>
                                    <textarea name="image_map" id="image_map" rows="6" cols="60" class="textarea"><?php echo $catalog->image_map; ?></textarea>
                                </div>
                            </li>
                            <li>
                                <label>手机分类页图片</label>
                                <div>
                                    <input type="file" name="file_phone" value="上传手机图片" />
                                    <input type="hidden" name="pimage_src" value="<?php echo $catalog->pimage_src; ?>" />
                                </div>
                            </li>
                            <li>
                                <label>手机版Image Map</label>
                                <div>
                                    <textarea name="pimage_map" id="pimage_map" rows="6" cols="60" class="textarea" value=""><?php echo $catalog->pimage_src; ?></textarea>
									<br/>
									<img src="<?php echo STATICURL;?>/simages/<?php echo $catalog->pimage_src; ?>"/>
                                </div>
								<!--<?php //echo $catalog->id; ?>-->
								<div><a href="/admin/site/catalog/deleteimgmap?catalog_id=<?php echo $catalog->id; ?>&lang=<?php echo $now_lang; ?>" onclick="return confirm('确定删除？')">删除手机版image</a></div>
                            </li>
                        </ul>

                    </fieldset>
                </div>
                <!--END tabs-5 -->

            </div>

            <ul>
                <li>
                    <input value="Submit" class="button" type="submit" />
                </li>
            </ul>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $("#products_relate").click(function(){
            $("#catalog_set").attr('action', '/admin/site/catalog/products_relate');
            $("#catalog_set").submit();
        });
        $("#products_add").click(function(){
            $("#catalog_set").attr('action', '/admin/site/catalog/products_add');
            $("#catalog_set").submit();
        });
        $("#products_top").click(function(){
            $("#catalog_set").attr('action', '/admin/site/catalog/products_top');
            $("#catalog_set").submit();
        });
        $("#products_zero").click(function(){
            $("#catalog_set").attr('action', '/admin/site/catalog/products_zero');
            $("#catalog_set").submit();
        });
        $("#products_zero12").click(function(){
            $("#catalog_set").attr('action', '/admin/site/catalog/products_zero12');
            $("#catalog_set").submit();
        });
        $("#products_zero13").click(function(){
            $("#catalog_set").attr('action', '/admin/site/catalog/products_zero13');
            $("#catalog_set").submit();
        });
        
        //        $("#products_unrelate").click(function(){
        //                $("#catalog_set").attr('action', '/admin/site/catalog/products_unrelate');
        //                $("#catalog_set").submit();
        //        });
        <?php
    $lang_url = $lang ? '?lang=' . $lang : '';
    if ($lang_url)
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
            $('#catalog_name').change(function(){
                $('#link').val($('#link').attr('title'));
            });
            $('.lang_hide').hide();
            $('#tabs-5').show();
        <?php
    }
    ?>
    })
        
    function export_products($id)
    {
        location.href = "/admin/site/catalog/export_products/" + $id;
        return false;
    }

    function delete_products($id)
    {
        if(!confirm('确定要清空么？')){
            return false;
        }
        location.href = "/admin/site/catalog/delete_products/" + $id;
        return false;        
    }

    function catalogdelete_products($id)
    {
        if(!confirm('确定要置零么？')){
            return false;
        }
        location.href = "/admin/site/catalog/catalogdelete_products/" + $id;
        return false;        
    }


</script>