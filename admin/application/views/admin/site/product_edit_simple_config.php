<?php
$sync_flag=Session::instance()->get('b2b_sync_sku',0);
if(!empty($sync_flag)){
?>
<script>
    i=0;
    j=0;
    sku_img_change();


    function sku_img_change(){
        $.post("<?php echo URL::base('http', TRUE).'admin/site/api/sku_img_change'; ?>",{"sku":"<?php echo $sync_flag;?>"},function(re_d){
            if(re_d!='success') {
                if(i<3){
                    i++;
                    sku_img_change();
                }
            }else{
                clear_b2b_sync_session();
            }
        });
    }
    
    function clear_b2b_sync_session(){
        $.post("<?php echo URL::base('http', TRUE).'admin/site/api/clear_b2b_sync_session'; ?>",function(re_flag){
            if(re_flag!='success') {
                if(j<3){
                    j++;
                    clear_b2b_sync_session();
                }
            }
        });
    }

</script>
<?php } ?>
 <!-- 张p中 -->

<div id="do_content">
    <script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
    <link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
    <script type="text/javascript" src="/media/js/my_validation.js"></script>
    <script type="text/javascript" src="/media/js/tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript" src="/media/js/product_admin/product_admin.js"></script>
    <script type="text/javascript" src="/media/js/file-uploader/fileuploader.js"></script>
    <link rel="stylesheet" type="text/css" href="/media/js/file-uploader/fileuploader.css" />
    <script type="text/javascript">
        config = [];
        config['image_tempfolder'] = "/pimages1.php?size=99&file=";
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
    $(document).ready(function(){
        tinyMCE.init({
            mode : 'exact',
            elements : "brief",
            theme : "advanced",
            plugins : "fullscreen,advimage",
            height: 150,
            theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,fullscreen",
            theme_advanced_buttons2 : "",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            theme_advanced_resizing : true,
            relative_urls: false,
            preformatted : true,
            remove_script_host: false,
            //forced_root_block : false, // Needed for 3.x
            force_p_newlines : false,
            //convert_newlines_to_brs: true,
            //invalid_elements : "p",
            force_br_newlines: true,
            file_browser_callback: myFileBrowser
        });
        $('#attribute_add').dialog({ autoOpen: false });
        $('#attribute_add_submit').live('click',function(){
            if($('#attribute_add_name').val()!='')
            {
                var value_input='';
                if($('#attribute_add_number').val()==''||isNaN(parseInt($('#attribute_add_number').val()))==true)
                {
                    value_input='<input type="text"  name="product[attributes]['+$('#attribute_add_name').val()+'][]"/><a href="#" class="delete_attribute""><font color="red">x</font></a>';
                }
                else
                {
                    for(var i=0;i<parseInt($('#attribute_add_number').val());i++)
                    {
                        value_input+='<input type="text"  name="product[attributes]['+$('#attribute_add_name').val()+'][]"/><a color="red" href="#" class="delete_attribute"><font color="red">x</font></a>';
                    }
                }
                $("#attribute_table tbody").append('<tr><td><input type="text" value="'+$('#attribute_add_name').val()+'" name="product[attributes]['+$('#attribute_add_name').val()+']" readonly="true" class="text valid"/></td><td colspan="2" >'+value_input+'<a href="#" class="add_attribute">+</a></td></tr>');
            }
            $('#attribute_add').dialog('close');
        });
        $('#attribute_value_add').live('click',function(){
            $('#attribute_add_name').val('');
            $('#attribute_add_number').val('');
            $('#attribute_add').dialog('open');
        });
        $('.delete_attribute').live('click',function(){
            $(this).prev("input").remove();
            if($(this).parent().find("input").length==0)
                $(this).parent().parent().remove();
            else
                $(this).remove();
            return false;
        });
        $('.add_attribute').live('click',function(){
            var e=$(this).parent().find("input:last").clone();
            e.val("");
            $(this).before(e);
            $(this).before('<a color="red" href="#" class="delete_attribute"><font color="red">x</font></a>');
            return false;
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
        $('#name').change(function(){
            $('#link').val($('#link').attr('title'));
        });
        $('.lang_hide').hide();
        <?php
        }
        ?>
    });
    </script>
    <script type="text/javascript" src="/media/js/product_admin/product_edit.js"></script>

    <div class="box">
        <h3>修改简单配置产品
        <?php
            $languages = Kohana::config('sites.1.language');
            $now_lang = Arr::get($_GET, 'lang', 'en');
            foreach($languages as $l)
            {
                ?>
                <a class="product_list"  href="/admin/site/product/edit/<?php echo $product['id']; ?><?php if($l != 'en') echo '?lang=' . $l; ?>" <?php if($now_lang == $l) echo 'style="color:red"'; ?>><?php echo $l; ?></a>
                <?php
            }
        ?>
        </h3>
        <form method="post" action="#"  name="product_form" class="need_validation">
            <div id="tabs"  style="overflow:hidden;">
                <ul>
                    <li><a href="#tabs-1">基本信息</a></li>
                    <li><a href="#tabs-2" class="lang_hide">产品图片</a></li>
                    <li><a href="#tabs-3" class="lang_hide">产品规格</a></li>
                    <li><a href="#tabs-4">产品描述</a></li>
                    <li><a href="#tabs-5" class="lang_hide">相关产品</a></li>
                    <li><a href="#tabs-catalogs" class="lang_hide">Catalogs</a></li>
                    <li><a href="#tabs-sorts" class="lang_hide">Sorts</a></li>
                    <li><a href="#tabs-6">SEO相关</a></li>
                    <li><a href="#tabs-7" class="lang_hide">红人秀</a></li>
                    <li><a href="#tabs-8" class="lang_hide">操作历史</a></li>
                </ul>
                <!--START tabs-1 -->
                <div id="tabs-1">
                    <ul>

                        <li>
                            <label>名称<span class="req">*</span></label>
                            <div>
                                <input name="product[name]" id="name" class="text medium required" type="text" value="<?php echo str_replace('"', '&quot;', $product['name']); ?>"/>
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
                                <input name="product[link]" id="link" class="text medium required" type="text" title="<?php echo $product['link']; ?>" value="<?php echo $product['link']; ?>"/>
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
                            <label>Avaliable for sale:</label>
                            <div>
                                <input type="radio" class="radio" name="product[status]" value="1" <?php if ($product['status'] == 1) echo ' checked = "checked" '; ?>/> Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="radio" name="product[status]" value="0" <?php if ($product['status'] == 0) echo ' checked = "checked" '; ?>/> No
                            </div>
                        </li>
                        <li>
                            <label>预售到期时间: </label>
                            <input type="text" class="presell text short" name="product[presell]" value="<?php if($product['presell'] > 1) echo date('Y-m-d', $product['presell']); ?>">
                            <div id="presell_message">
                                <label>预售文案</label>
                                <input name="product[presell_message]" id="presell_message" class="text short" type="text" value="<?php echo $product['presell_message']; ?>" />
                            </div>
                            <script type="text/javascript">
                                $('.presell').datepicker({
                                    'dateFormat': 'yy-mm-dd'
                                });
                            </script>
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
                            <label>加收物流费(USD)</label>
                            <div>
                                <input name="product[extra_fee]" id="cost" class="short text number" type="text" value="<?php echo isset($product['extra_fee']) ? $product['extra_fee'] : ''; ?>"/>
                            </div>
                        </li>
                        <li>
                            <label>供货商</label>
                            <div>
                                <input name="product[factory]" id="factory" class="short text" type="text" value="<?php echo $product['factory']; ?>"/>
                            </div>
                            <label>线下供货商</label>
                            <div>
                                <input name="product[offline_factory]" id="offline_factory" class="short text" type="text" value="<?php echo $product['offline_factory']; ?>"/>
                            </div>
                            <label>线下供货商SKU</label>
                            <div>
                                <input name="product[offline_sku]" id="offline_sku" class="short text" type="text" value="<?php echo $product['offline_sku']; ?>"/>
                            </div>
                            <label>库存<span class="req">*</span></label>
                            <div class="form_radio_row">
                                <input type="radio" name="product[no_limit_stock]" class="no_limit_stock" id="no_limit_stock_yes" value="1"<?php echo $product['stock'] != -99 ? '' : ' checked="checked"'; ?>/><label for="no_limit_stock_yes"> No limit.</label><br/>
                                <input type="radio" name="product[no_limit_stock]" class="no_limit_stock radio" value="0"<?php echo $product['stock'] == -99 ? '' : ' checked="checked"'; ?>/><label> Limit.</label>
                                <input name="product[stock]" id="stock" class="product_stock short text required" type="hidden" value="<?php echo $product['stock'] == -99 ? -99 : -1; ?>">
                                <br/>
                                <div id="product_stock" style="<?php echo $product['stock'] == -1 ? '' : 'display:none;' ?>">
                                    <?php
                                    if (isset($product['attributes']['Size']))
                                    {
                                        foreach ($product['attributes']['Size'] as $value)
                                        {
                                            $value = trim($value);
                                            $stock = isset($product_stocks[$value]) ? $product_stocks[$value] : '';
                                            echo $value . ':<input type="text" name="stocks[' . $value . ']" class="short text" value="' . $stock . '" /><br/>';
                                        }
                                    }
                                    ?>
                                </div>
                                <br/>
                            </div>
                            <label>Weight</label>
                            <div>
                                <input name="product[weight]" id="weight" class="short text" type="text" value="<?php echo $product['weight']; ?>"/>
                            </div>
                            <script type="text/javascript">
                                $(function(){
                                    $('.no_limit_stock').live('click',function(){
                                        var stock = $(this).val();
                                        if(stock == 0)
                                        {
                                            $('#product_stock').show();
                                            $('#stock').val(-1);
                                        }
                                        if(stock == 1)
                                        {
                                            $('#product_stock').hide();
                                            $('#stock').val(-99);
                                        }
                                    });
                                })
                            </script>
                        </li>
                        <li>
                            <label>Keywords</label>
                            <div>
                                <textarea name="product[keywords]" id="keywords" rows="6" cols="60" class="textarea"><?php echo $product['keywords']; ?></textarea>
                            </div>
                        </li>
                        <li>
                            <label>PLA_name(营销用)</label>
                            <div>
                                <input name="product[pla_name]" id="pla_name" class="text medium" type="text" value="<?php echo isset($product['pla_name']) ? $product['pla_name'] : ''; ?>"/>
                            </div>
                        </li>
                        <li>
                            <label>store</label>
                            <div>
                                <input name="product[store]" id="store" class="text medium" type="text" value="<?php echo isset($product['store']) ? $product['store'] : ''; ?>"/>
                            </div>
                        </li>
                        <li>
                            <label>Brief</label>
                            <div>
                                <textarea name="product[brief]" id="brief" rows="6" cols="60" class="textarea"><?php echo $product['brief']; ?></textarea>
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
                        <li>
                            <label>供货来源字段</label>
                            <div>
                                <input name="product[source]" id="source" class="text medium" type="text" value="<?php echo $product['source']; ?>"/>
                            </div>
                        </li>
                        <li>
                            <label>产品级别</label>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $("#level").val(<?php echo $product['level'];?>);
                                    $("#design").val(<?php echo $product['design'];?>);
                                    $("#style").val(<?php echo $product['style'];?>);
                                    $("#optimization").val(<?php echo $product['optimization'];?>);
                                })
                            </script>
                            <div>level:
                                <select name="product[level]" id="level">
                                    <option value="0">null</option>
                                    <option value="1">a</option>
                                    <option value="2">b</option>
                                </select>
                                design:
                                <select name="product[design]" id="design">
                                    <option value="0">null</option>
                                    <option value="1">开发设计款</option>
                                    <option value="2">非开发设计款</option>
                                </select>
                                style:
                                <select name="product[style]" id="style">
                                    <option value="0">null</option>
                                    <option value="1">潮款</option>
                                    <option value="2">基本款</option>
                                </select>
                                optimization:
                                <select name="product[optimization]" id="optimization">
                                    <option value="0">null</option>
                                    <option value="1">已操作</option>
                                    <option value="2">未操作</option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label>选款人</label>
                            <div>
                                <input name="product[offline_picker]" id="source" class="text medium" type="text" value="<?php echo $product['offline_picker']; ?>"/>
                            </div>
                        </li>
                        <li>
                            <label>中文名称</label>
                            <div>
                                <input name="product[cn_name]" id="cn_name" class="text medium" type="text" value="<?php echo $product['cn_name']; ?>"/>
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
                        foreach ($product['images'] as $image)
                        {
                            if ($image['id'] == 0)
                            {
                                continue;
                            }
                            ?>
                            <li image_id="<?php echo $image['id']; ?>">
                                <img src = "/pimages.php?id=<?php echo $image['id']; ?>&size=99&ext=<?php echo $image['suffix']; ?>" alt="<?php echo $image['id']; ?>号产品图"/>
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
                    
                    <div>
                    <h4>所有缩略图: </h4>
                    <hr>
                    <?php
                        //New image list
                        $sizes = Image::size_array();
                        echo '<table border="1">';
                        echo '<tr>';
                        foreach($sizes as $size)
                        {
                            echo '<td>Size:' . $size . '</td>';
                        }
                        echo '</tr>';
                        foreach($product['images'] as $i)
                        {
                            echo '<tr>';
                            foreach($sizes as $s)
                            {
                                $link = STATICURL . '/pimg/' . $s . '/' . $i['id'] . '.' . $i['suffix'];
                                echo '<td><img src="' . $link . '" width="100px" /></td>';
                            }
                            echo '</tr>';
                            DB::update('images')->set(array('status' => 1))->where('id', '=', $i['id'])->execute();
                        }
                        echo '</table>';                       
                    ?>
                    </div>
                </div>
                <!--END tabs-2 -->

                <!--START tabs-3 -->
                <div id="tabs-3">
                    <table class="hazy" id="attribute_table">
                        <thead>
                            <tr>
                                <th scope="col" width="20%">Attribute</th>
                                <th scope="col" width="30%">Value</th>
                                <th scope="col" width="50%"><input type="button" id="attribute_value_add" class="button" value="Add Attribute Value"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($product['attributes'] != '')
                            {
                                foreach ($product['attributes'] as $key => $value)
                                {
                                    ?>
                                    <tr><td><input type="text" value="<?php echo $key; ?>" name="product[attributes][<?php echo $key ?>]" readonly="true" class="text valid"/></td><td colspan="2" >
                                            <?php foreach ($value as $v): ?>		
                                                <input type="text"  name="product[attributes][<?php echo $key; ?>][]" value="<?php echo htmlspecialchars($v); ?>"/><a href="#" class="delete_attribute"><font color="red">x</font></a>								
                                            <?php endforeach; ?>
                                            <a href="#" class="add_attribute">+</a></td></tr>
                                    <?php
                                }
                            }
                            ?>	
                        </tbody>
                    </table>
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

                <!--START tabs-sorts -->
                <div id="tabs-sorts" class="navigation">
                    <?php
                    $filter_attributes = explode(';', $product['filter_attributes']);
                    foreach ($filter_attributes as $key => $filter)
                    {
                        $filter_attributes[$key] = ucfirst(strtolower($filter));
                    }
                    $result = DB::select()->from('catalog_sorts')->order_by('catalog_id')->execute();
                    $sorts_catalogs = array();
                    $sorts = array();
                    foreach ($result as $sort)
                    {
                        if (!in_array($sort['catalog_id'], $sorts_catalogs))
                        {
                            $sorts_catalogs[] = $sort['catalog_id'];
                            $sorts[$sort['catalog_id']] = '';
                        }
                        $sorts[$sort['catalog_id']] .= '<div><label class='.$sort['sort'].'>' . $sort['sort'] . ': </label>';
                        foreach (explode(',', $sort['attributes']) as $attr)
                        {
                            $attr = ucfirst(strtolower($attr));
                            if (in_array($attr, $filter_attributes))
                                $check = 'checked="checked"';
                            else
                                $check = '';
                            $sorts[$sort['catalog_id']] .= '<input type="checkbox" class="sorts_attr" name="" value="' . $attr . '" ' . $check . '><span>' . $attr . '</span>, ';
                        }
                        $sorts[$sort['catalog_id']] .= '</div>';
                    }
                    ?>
                    <script type="text/javascript">
                        $(function(){
                            $("#sorts_catalog").change(function(){
                                var id = $(this).val();
                                $("#sorts_select"+id).show().siblings().hide();
                            });
                            $(".sorts_attr").live('click', function(){
                                var val = $(this).val();
                                if($(this).attr('checked'))
                                {
                                    var filter_attributes = $("#filter_attributes").val();
                                    var filter_sort = $(this).parent().children(":eq(0)").attr("class");
                                    if(!filter_attributes)
                                    {
                                      filter_attributes = val;  
                                      $("#filter_attributes").val(filter_attributes);
                                    }
                                    else
                                    {
                                        if(filter_sort == 'Color')
                                        {
                                           fil = val + ';' + filter_attributes;
                                           $("#filter_attributes").val(fil);
                                        }
                                        else
                                        {
                                           filter_attributes += ';' + val;
                                           $("#filter_attributes").val(filter_attributes);                                              
                                        }
                                    }
                                    
                                    
                                }
                                else
                                {
                                    var remove_attributes = $("#remove_attributes").val();
                                    if(!remove_attributes)
                                    {
                                      remove_attributes = val;  
                                    }
                                    else
                                    {
                                      remove_attributes += ';' + val;  
                                    }

                                    $("#remove_attributes").val(remove_attributes);
                                }
                            })
                        })
                    </script>
                    <ul>
                        <li>
                            <h4>Catalog Select</h4>
                            <div style="margin-bottom: 15px;">
                                <select id="sorts_catalog">
                                    <option value=""></option>
                                    <?php foreach ($sorts_catalogs as $catalog): ?>
                                        <option value="<?php echo $catalog; ?>"><?php echo Catalog::instance($catalog)->get('name'); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </li>

                        <li>
                            <h4>Sorts Select</h4>
                            <div>
                                <?php foreach ($sorts as $cid => $s): ?>
                                    <div id="sorts_select<?php echo $cid; ?>" style="margin-bottom: 15px;display: none;"><?php echo $s; ?></div>
                                <?php endforeach; ?>
                            </div>
                        </li>

                        <li>
                            <div>
                                <h3 style="color:red;">请产品组修改sorts时留意下color属性是不是在第一个，不在的话请联系IT
                                </h3>
                                <br />
                                <b style="font-size:16px;">设置后的sort属性集合：</b><input type="text" name="filter_attributes" id="filter_attributes" value="<?php echo $product['filter_attributes']; ?>" style="width:600px;" />
                                <br />
                                <b style="font-size:16px;">需要去掉的sort属性：</b><input type="text" name="remove_attributes" id="remove_attributes" value=""  style="width:600px;"  />
                            </div>
                        </li>

                    </ul>
                </div>
                <!--END tabs-sorts -->

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
                    config1['image_tempfolder'] = 'http://<?php echo Site::instance()->get('domain') ?>/uploads/1/simages/';
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
                                                <img height="200px" src = "' + config1['image_tempfolder'] + '/'+ filename + '" />\n\
                                                <div class="image_actions1">\n\
                                                <a href="#" class="image_remove1">删除</a>\n\
                                                <br><select name="type['+filename+']"><option value=1>celebrity</option><option value=2>link</option><option value=3>both</option></select>\n\
                                                <input type="text" name="linksku['+filename+']" style="width:60%;">\n\
						<br><br><label>celebrity_id</label><input type="text" name="celebrity_ids['+filename+']" value="0" required />\n\
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
                                    <img height="200px" src="http://<?php echo Site::instance()->get('domain'); ?>/uploads/1/simages/<?php echo $image['image']; ?>" style="border:solid 1px #CCC;" />
                                    &nbsp;&nbsp;&nbsp;&nbsp;<a href="#" title="<?php echo $image['image']; ?>" style="color:red;" class="delete_image_src">Delete</a>
                                    <br><select name="type[<?php echo $image['image']; ?>]"><option value=1 <?php if($image['type']==1){echo "selected";}?>>celebrity</option><option value=2 <?php if($image['type']==2){echo "selected";}?>>link</option><option value=3 <?php if($image['type']==3){echo "selected";}?>>both</option></select>
                                    <input type="text" name="linksku[<?php echo $image['image']; ?>]" value="<?php echo $image['link_sku']; ?>" style="width:60%;"><br><br>
                                    <label>celebrity_id</label><input type="text" name="celebrity_ids[<?php echo $image['image'];?>]" value="<?php echo $image['celebrits_id']; ?>" required />
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
                <!-- tabs-8 zpz add 20160125 -->
                <!--START tabs-8 operate history-->
                <div id="tabs-8">
                        <?php if(!empty($oper_histories))
                        {
                        ?>
                    <table>
                        <tr>
                            <thead>
                                <th class="col">动作</th>
                                <th class="col">管理员ID</th>
                                <th class="col">备注</th>
                                <th class="col">时间</th>
                            </thead>
                        </tr>

                        <?php
                            foreach($oper_histories as $history)
                            { 
                        ?>
                        <tr>
                             <td><?php echo $history['oper']; ?></td>
                             <td><?php echo $history['name'];?></td>
                             <td><?php echo $history['data'];?></td>
                             <td><?php echo $history['create'];?></td>
                        </tr>
                        <?php 
                            } 
                        ?>
                    </table>
                        <?php
                        }
                        else
                        {
                        ?>
                    <strong>无历史信息记录</strong>
                    <?php
                        }
                    ?>
                </div>
                <!--END tabs-8 operate history-->

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
<div id="attribute_add" title="Add Attribute">
    <table border="1" cellpadding="0" cellspacing="0" width="250" style="margin:auto;">
        <tr>
            <td class="tdLabel"><label>Name</label></td>
            <td class="tdInput"><input type="text" id="attribute_add_name" /></td>
        </tr>
        <tr>
            <td class="tdLabel"><label>Value Number:</label></td>
            <td class="tdInput"><input type="text" id="attribute_add_number" value="2"/></td>
        </tr>
    </table>
    <input type="button" id="attribute_add_submit" value="Add">
</div>

