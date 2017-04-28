<div id="do_content">
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript" src="/media/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/media/js/product_admin/product_admin.js"></script>
<script type="text/javascript" src="/media/js/file-uploader/fileuploader.js"></script>
<link rel="stylesheet" type="text/css" href="/media/js/file-uploader/fileuploader.css" />
<script type="text/javascript">
config = [];
config['image_tempfolder'] = "<?php echo kohana::config('upload.temp_folder'); ?>";
config['image_allowed_extensions'] = ["<?php echo implode('","',kohana::config('upload.product_image.filetypes'));?>"];
config['image_max_size'] = <?php echo kohana::config('upload.product_image.max_size');?>;
config['catalogs'] = [];
product_ids = [];
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
    var options = '<?php echo $set_options;?>';
    $('#gs_product_set').append(options);
}
</script>
<script type="text/javascript" src="/media/js/product_admin/product_add.js"></script>

    <div class="box">
        <h3> Add Simple Product	</h3>
        <form method="post" action="#" name="product_form" class="need_validation">
            <input type="hidden" name="product[set_id]" value="<?php echo $set_id; ?>" />
            <input type="hidden" name="product[type]" value="<?php echo $type; ?>" />
            <div id="tabs"  style="overflow:hidden;">
                <ul>
                    <li><a href="#tabs-1">Basic</a></li>
                    <li><a href="#tabs-2">Images</a></li>
                    <li><a href="#tabs-3">Attributes</a></li>
                    <li><a href="#tabs-4">Description</a></li>
                    <li><a href="#tabs-5">Related Products</a></li>
					<li><a href="#tabs-catalogs">Catalogs</a></li>
                    <li><a href="#tabs-6">SEO</a></li>
                </ul>
                <!--START tabs-1 -->
                <div id="tabs-1">
                    <ul>

                        <li>
                            <label>Name<span class="req">*</span></label>
                            <div>
                                <input name="product[name]" id="name" class="text medium required" type="text" />
                            </div>
                        </li>

                        <li>
                            <label>SKU<span class="req">*</span></label>
                            <div>
                                <input name="product[sku]" id="sku" class="text medium required" type="text" />
                            </div>
                        </li>

                        <li>
                            <label>URL<span class="req">*</span></label>
                            <div>
                                <input name="product[link]" id="link" class="text medium required" type="text" />
                            </div>
                        </li>

                        <li>
                            <label>Visibility</label>
                            <div>
                                <input type="radio" class="radio" name="product[visibility]" value="1" checked="checked"/> Visible
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="radio" name="product[visibility]" value="0" /> Invisible
                            </div>
                        </li>

                        <li>
                            <label>Avaliable for sale:</label>
                            <div>
                                <input type="radio" class="radio" name="product[status]" value="1" checked="checked"/> Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="radio" name="product[status]" value="0" /> No
                            </div>
                        </li>

                        <li>
                            <label>本站价格(<?php echo Site::instance()->default_currency();?>)<span class="req">*</span></label>
							<div>
								<input name="product[price]" id="price" class="short text required number" type="text" /> <a href="#" class="product_bulk_rules_toggle">Tier price</a>
                            </div>
							<label>市场价格(<?php echo Site::instance()->default_currency();?>)</label>
                            <div>
                                <input name="product[market_price]" id="market_price" class="short text number" type="text" />
                            </div>
							<label>总成本(<?php echo Site::instance()->default_currency(); ?>)</label>
                            <div>
                                <input name="product[cost]" id="cost" class="short text number" type="text" />
                            </div>
							<label>采购成本(RMB)</label>
                            <div>
                                <input name="product[total_cost]" id="total_cost" class="short text number" type="text" />
                            </div>
                        </li>

						<li>
							<label>Stock<span class="req">*</span></label>
                            <div class="form_radio_row">
                                <input type="radio" name="product[no_limit_stock]" class="no_limit_stock" id="no_limit_stock_yes" checked="checked"/><label for="no_limit_stock_yes"> No limit.</label><br/>
                                <input type="radio" name="product[no_limit_stock]" class="no_limit_stock radio" value="0"/>
                                <input name="product[stock]" id="stock" class="product_stock short text required digits" type="text" disabled="disabled" />
                            </div>
						</li>

                        <li>
                            <label>Weight(g)<span class="req">*</span></label>
                            <div>
                                <input name="product[weight]" id="weight" class="short text required digits" type="text" />
                            </div>
                        </li>
                        <li>
                            <label>Size(cm)<span class="req">*</span></label>
                            <div>
                                <input name="product[size]" id="size" class="short text required" type="text" />
                            </div>
                        </li>

                        <li>
                            <label>Brief</label>
                            <div>
                                <input name="product[brief]" id="brief" class="text short medium" type="text" />
                            </div>
                        </li>

                        <li>
                            <label>Tabao URL</label>
                            <div>
                                <input name="product[taobao_url]" id="taobao_url" class="text short medium" type="text" />
                            </div>
                        </li>
                    </ul>
                </div>
                <!--END tabs-1 -->

                <!--START tabs-2 -->
                <div id="tabs-2">
                    <div id="upload_box">
                    </div>
                    <input type="hidden" name="images" />
                    <input type="hidden" name="images_default" />
                    <input type="hidden" name="images_removed" />
                    <ul id="images_list" class="clr">
                    </ul>
                </div>
                <!--END tabs-2 -->

                <!--START tabs-3 -->
                <div id="tabs-3">
<?php
//include simple group product attributes view
echo View::factory('admin/site/product_simple')
    ->set('attributes', $attributes)
    ->render();
?>
                </div>
                <!--END tabs-3 -->

                <!--START tabs-4 -->
                <div id="tabs-4">
                    <ul>
                        <li>
                            <div>
                                <textarea name="product[description]" id="description" rows="10" cols="60" class="textarea"></textarea>
                            </div>
                        </li>


                    </ul>
                </div>
                <!--END tabs-4 -->

                <!--START tabs-5 -->
                <div id="tabs-5">

                    <div id="grid_head_bar" class="clr">
                        <div class="float_left">&nbsp;<input type="checkbox" id="select_all"/><label for="select_all">SELECT ALL</label></div>
                        <a href="#" class="float_left" id="view_selected_products">预览我已选的产品列表</a>( <span id="selected_num">0</span> selected )
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
                    <?php echo $catalog_checkboxes_tree;?>
                </div>
                <!--END tabs-catalogs -->

                <!--START tabs-6 -->
                <div id="tabs-6">
                    <ul>

                        <li>
                            <label>META TITLE</label>
                            <div>
                                <input name="product[meta_title]" id="meta_title" class="text long" type="text" />
                            </div>
                        </li>

                        <li>
                            <label>META KEYWORDS</label>
                            <div>
                                <input name="product[meta_keywords]" id="meta_keywords" class="text long" type="text" />
                            </div>
                        </li>

                        <li>
                            <label>META DESCRIPTION</label>
                            <div>
                                <textarea name="product[meta_description]" id="meta_description" rows="6" cols="60" class="textarea"></textarea>
                            </div>
                        </li>

                    </ul>
                </div>
                <!--END tabs-6 -->

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
