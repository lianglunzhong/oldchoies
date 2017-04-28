<?php echo View::factory('admin/site/catalog_left')->set('catalog_tree', $catalog_tree)->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript">
    config = {};
    config['catalog_id'] = '';
    config['image_allowed_extensions'] = ["<?php echo implode('","',kohana::config('upload.product_image.filetypes'));?>"];
    config['image_max_size'] = <?php echo kohana::config('upload.product_image.max_size');?>;
</script>
<script type="text/javascript" src="/media/js/catalog/catalog_admin.js"></script>
<?php
if( ! $is_conditional)
{
?>
<script type="text/javascript">
    product_ids = [];
    function set_search_options(){
		var $gs_product_set = $('#gs_product_set');
		$gs_product_set.append('<option value="0">无</option>');
		<?php
		$sets = Site::instance()->sets();
		if(count($sets))
		{
			foreach($sets as $set)
			{
			?>
					$gs_product_set.append('<option value="<?php echo $set['id'];?>"><?php echo $set['name'];?></option>');
					<?php
			}
		}
		?>
	}
    
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
        <?php
    }
    ?>
</script>
<script type="text/javascript" src="/media/js/catalog/catalog_basic_admin.js"></script>
<?php
}
else
{
?>
<script type="text/javascript" src="/media/js/catalog/catalog_conditional_admin.js"></script>
<?php
}
?>
<script type="text/javascript" src="/media/js/file-uploader/fileuploader.js"></script>
<link rel="stylesheet" type="text/css" href="/media/js/file-uploader/fileuploader.css" />
<div id="do_right" class="catalog_right">
	<div class="box" style="overflow:hidden;">
		<h3>Add<?php echo $is_conditional ? ' Conditional' : ''; ?> Catalog
        <?php
            $languages = Kohana::config('sites.1.language');
            $now_lang = Arr::get($_GET, 'lang', 'en');
            foreach($languages as $l)
            {
                ?>
                <a class="product_list"  href="/admin/site/catalog/list<?php if($l != 'en') echo '?lang=' . $l; ?>" <?php if($now_lang == $l) echo 'style="color:red"'; ?>><?php echo $l; ?></a>
                <?php
            }
        ?>
        </h3>
        <?php
        if($now_lang !== 'en')
        {
            ?>
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
            </script>
            <div style="margin:20px;">
                <div>小语种批量修改分类信息</div>
                <span style="color:red;">模板: 英文分类名(en_name),小语种分类名(name),description,meta_title,meta_keywords,meta_description</span>
                <form method="post" action="/admin/site/catalog/import_basic?lang=<?php echo $now_lang; ?>" id="form1">
                    <table class="layout">
                        <tr>
                            <td><label>Content：</label></td>
                            <td><textarea name="content" id="content" cols="55" rows="20" ></textarea></td>
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
            <?php
        }
        else
        {
        ?>
		<form method="post" action="/admin/site/catalog/add<?php echo $is_conditional ? '/conditional' : ''; ?>" class="need_validation">

			<div id="tabs">
				<ul>
					<li><a href="#tabs-1">Basic</a></li>
                    <li><a href="#tabs-2"><?php echo $is_conditional ? 'Filter' : 'Products'; ?></a></li>
					<li><a href="#tabs-3">Search Bar</a></li>
					<li><a href="#tabs-4">SEO</a></li>
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
									echo $catalog_opt == '' ? '<option value="0">--ROOT--</option>' : $catalog_opt;
									?>
								</select>
							</div>
						</li>

						<li>
							<label>Name<span class="req">*</span></label>
							<div>
								<input name="catalog_name" id="name" class="text medium required" type="text" />
							</div>
						</li>

						<li>
							<label>URL<span class="req">*</span></label>
							<div>
								<input name="link" id="link" class="text medium required" type="text" />
							</div>
                        </li>

						<li>
							<label>Products order by</label>
							<div>
                                <select name="orderby" class="drop">
                                    <option value="created">Created time</option>
                                    <option value="hits">Number purchased</option>
                                    <option value="name">Name</option>
                                    <option value="price">Price</option>
                                </select>
                                <select name="desc" class="drop">
                                    <option value="desc">Descending</option>
                                    <option value="asc">Ascending</option>
                                </select>
							</div>
                        </li>

						<li>
							<label>Visibility</label>
							<div style="margin-top:10px;">
                                <input type="radio" name="catalog_visibility" value="1" id="visibility_yes" checked="checked"/><label for="visibility_yes"> Yes</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="catalog_visibility" value="0" id="visibility_no" /><label for="visibility_no"> No</label>
							</div>
                        </li>

						<li>
							<label>Listed on menu</label>
							<div style="margin-top:10px;">
                                <input type="radio" name="on_menu" value="1" id="on_menu_yes" checked="checked"/><label for="on_menu_yes"> Yes</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="on_menu" value="0" id="on_menu_no" /><label for="on_menu_no"> No</label>
							</div>
                        </li>

						<li>
							<label>Template</label>
							<div>
								<input name="template" id="template" class="text short" type="text" />
							</div>
						</li>


						<li>
							<label>Description</label>
							<div>
								<textarea name="description" id="meta_description" rows="6" cols="60" tabindex="1" class="textarea"></textarea>
							</div>
						</li>
                                                
                                                <li>
                                                        <label>Is Brand</label>
                                                        <div style="margin-top:10px;">
                                                                <input type="radio" name="is_brand" value="1" id="brand_yes" /><label for="brand_yes"> Yes</label>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                                <input type="radio" name="is_brand" value="0" id="brand_no" checked = "checked" /><label for="brand_no"> No</label>
                                                        </div>
                                                </li>

					</ul>
				</div>
				<!--END tabs-1 -->

				<!--START tabs-2 -->
				<div id="tabs-2">
					<?php
									if( ! $is_conditional)
									{
					?>
										<div id="grid_head_bar" class="clr">
											<div class="float_left">&nbsp<a id="select_all" class="inline_link" href="#">All</a>&nbsp;|&nbsp;<a id="invert_all" class="inline_link" href="#">Invert</a></div>
                                            <a href="#" class="float_left" id="view_selected_products">预览我已选的产品列表</a>
                                            <div class="float_left">( <span id="selected_num">0</span> selected )</div>
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
											<input type="text" name="condition[price_lower]" id="price_lower" class="text numeric inline" value="" />
																																																																		到
											<input type="text" name="condition[price_upper]" class="text numeric inline" value="" />
										</div>
										
										<div class="filter_condition">
											<fieldset class="clr">
												<legend>选择商品类型:</legend>
							<?php
										foreach( $sets as $set )
										{
											echo '
												<div class="filter_condition_checkboxs"><input class="sets_checkboxes" type="checkbox" name="condition[sets][]" value="'.$set->id.'" id="condition_set_'.$set->id.'" /><label for="condition_set_'.$set->id.'"> '.$set->name.'</label></div>';
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
				</div>
				<!--END tabs-2 -->

                <!--START tabs-3 -->
                <div id="tabs-3">
                    <div class="filter_condition filter_condition_sets">
                        <fieldset class="clr">
                            <legend>Searchable attributes:</legend>
                            <div class="filter_condition_sets_check_box" style="height:auto;">
                                <?php
                                foreach( $searchable_attributes as $attribute )
                                {
                                    echo '
                                                <div class="filter_condition_checkboxs"><input type="checkbox" name="searchable_attributes[]" value="'.$attribute->id.'" id="condition_set_'.$attribute->id.'" /><label for="condition_set_'.$attribute->id.'" title="'.$attribute->name.'"> '.$attribute->name.'</label></div>';
                                }
                                ?>
                            </div>
                        </fieldset>
                        <ul>
                            <li>
                                <label>Price Ranges</label>
                                <div>
                                    <input type="text" class="text medium" name="price_ranges" /><br />e.x. "5,7" means "(0,5],(5,7]"
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
								<input name="meta_title" id="meta_title" class="text long" type="text" />
							</div>
						</li>

						<li>
							<label>META KEYWORDS</label>
							<div>
								<input name="meta_keywords" id="meta_keywords" class="text long" type="text" />
							</div>
						</li>

						<li>
							<label>META DESCRIPTION</label>
							<div>
								<textarea name="meta_description" id="meta_description" rows="6" cols="60" tabindex="1" class="textarea"></textarea>
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
                                    <input type="text" class="text medium" name="recommended_products" /><br />e.x. "524,528,36"
                                </div>
                            </li>
                        </ul>
                    </fieldset>
                    <fieldset class="clr">
                        <legend>Banner Image</legend>
                        <div id="upload_box"></div>
                        <div id="image_preview" style="margin-bottom:15px;"></div>
                        Image: <span id="image_filename"></span>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="delete_image_src" style="display:none">Delete</a>
                        <input type="hidden" name="image_src" />
                        <input type="hidden" name="image_bak" />

                        <ul style="margin-top:20px;">
                            <li>
                                <label>Image link</label>
                                <div>
                                    <input name="image_link" id="image_link" class="text long" type="text" />
                                </div>
                            </li>

                            <li>
                                <label>Image alt</label>
                                <div>
                                    <input name="image_alt" id="image_alt" class="text long" value="" type="text">
                                </div>
                            </li>
                        </ul>

                    </fieldset>
                </div>
                <!--END tabs-5 -->

			</div>

			<ul>
				<li>
					<input value="Save" class="button" type="submit" />
				</li>
			</ul>
		</form>
            <form method="post" action="/admin/site/catalog/cata_basic" >
                        <fieldset>
                            <div style="width:270px;float:left;">
                                <h4>批量修改分类basic属性</h4>
                                <div><span style="color:#FF0000" >注意： (暂无注意)</span>一行一个分类链接！！！</div>
                                <div><span>请输入分类名称:</span><br />

                                    <textarea name="SKUARR"  cols="30" rows="15" ></textarea>       
                                </div>
                                <input type="submit" value="Relate" id="products_relate" />
<!--                                                                        <input type="submit" value="Unrelate" id="products_unrelate" />-->
                            </div>
                            </form>
                        </fieldset>
        <?php
        }
        ?>
	</div>
</div>
