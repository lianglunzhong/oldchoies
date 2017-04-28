<?php
/**
 * Description of file
 *
 * @package
 * @author    FangHao
 * @copyright    © 2010 Cofree Development Group
 */
?>

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
config['set_id'] = <?php echo $set_id; ?>;
config['configurable_attributes'] = '<?php echo implode(',', $p_attrs); ?>';
config['currency_code'] = '<?php echo Site::instance()->default_currency(); ?>';
config['catalogs'] = [];
selected_associated = [];
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
<script type="text/javascript" src="/media/js/product_admin/configurable_product_admin.js"></script>
<script type="text/javascript" src="/media/js/product_admin/product_add.js"></script>

	<div class="box">
		<h3>
			添加配置产品
		</h3>
		<form method="post" action="#" name="product_form" class="need_validation">
			<input type="hidden" name="product[set_id]" value="<?php echo $set_id; ?>" />
			<input type="hidden" name="product[type]" value="<?php echo $type; ?>" />
			<input type="hidden" name="product[configurable_attributes]" value="<?php echo implode(',', $p_attrs); ?>" />
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

						<li>
                            <label>Visibility</label>
                            <div>
                                <input type="radio" class="radio" name="product[visibility]" value="1" checked="checked"/> Visible
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="radio" name="product[visibility]" value="0" /> Invisible
                            </div>
                        </li>

                        <li>
                            <label>Now for sale:</label>
                            <div>
                                <input type="radio" class="radio" name="product[status]" value="1" checked="checked"/> Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="radio" name="product[status]" value="0" /> No
                            </div>
                        </li>

                        <li>
                            <label>本站价格(<?php echo Site::instance()->default_currency(); ?>)<span class="req">*</span></label>
                            <div>
                                <input name="product[price]" id="price" class="short text required number" type="text" />
                            </div>
							<label>市场价格(<?php echo Site::instance()->default_currency(); ?>)</label>
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
                            <label>Weight(g)<span class="req">*</span></label>
                            <div>
                                <input name="product[weight]" id="weight" class="short text required digits" type="text" />
                            </div>
                        </li>

                        <li>
                            <label>Brief</label>
                            <div>
                                <input name="product[brief]" id="brief" class="text medium" type="text" />
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
					<ul>

						<?php
						$config_attr = array( );
						foreach( $attributes as $attribute )
						{
							if( ! in_array($attribute->id, $p_attrs))
							{
						?>
								<li>
									<label><?php echo $attribute->name; ?></label>
									<div>
								<?php
								switch( $attribute->type )
								{
									case 2:
								?>
										<input type="text" name="attributes[<?php echo $attribute->id; ?>]" class="text medium<?php if($attribute->required) echo ' required'; ?>" value="" />
								<?php
										break;
									case 3:
								?>
										<textarea cols="60" rows="6" class="textarea<?php if($attribute->required) echo ' required'; ?>" name="attributes[<?php echo $attribute->id; ?>]"></textarea>
								<?php
										break;
									case 1:
										$options = $attribute->options->find_all();
										foreach( $options as $option )
										{
								?>
											<input type="radio" class="radio<?php if($attribute->required) echo ' required'; ?>" name="option_id[<?php echo $attribute->id; ?>]" value="<?php echo $option->id; ?>"  /> <?php echo $option->label; ?>
											&nbsp;&nbsp;&nbsp;&nbsp;
								<?php
										}
										break;
									case 0:
									default:
								?>
                                        <select name="option_id[<?php echo $attribute->id; ?>]" class="drop<?php if($attribute->required) echo ' required'; ?>" >
                                            <option value="">--NONE--</option>
									<?php
										$options = $attribute->options->find_all();
										foreach( $options as $option )
										{
									?>
											<option value="<?php echo $option->id; ?>"><?php echo $option->label; ?></option>
									<?php
										}
									?>
									</select>
								<?php
										break;
								}
								?>
								<label class="note"><?php echo $attribute->brief; ?></label>
							</div>
						</li>
						<?php
							}
							else
							{
								$config_attr[] = $attribute;
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
								<textarea name="product[description]" id="description" rows="6" cols="60" class="textarea"></textarea>
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
							foreach( $config_attr as $attribute )
							{
								echo '<div class="filter_condition_little_box config_attribution" id="attr_'.$attribute->id.'">
								  <div class="filter_condition_little_box_title">'.$attribute->name.'</div>
								  <div class="filter_condition_little_box_content">';
								echo '<div style="float:right;margin-right:5px;font-size:10px;"><a href="javascript:void(0)" onclick="$(\'.check_'.$attribute->id.'\').attr(\'checked\', true);">all</a> / <a href="javascript:void(0)" onclick="$(\'.check_'.$attribute->id.'\').attr(\'checked\', false);">none</a></div>';
								$options = $attribute->options->find_all();
								foreach( $options as $option )
								{
									echo '<div class="filter_condition_checkboxs"><input type="checkbox" value="'.$option->id.'" id="condition_option_'.$option->id.'" class="check_'.$attribute->id.'"/><label for="condition_option_'.$option->id.'">'.$option->label.'</label></div>';
								}
								echo '
														</div>
											</div>';
							}
							?>
						</div>
						<br />
						<button id="create_associated_product" count="0">创建关联产品</button><span id="create_notice"></span>
					</fieldset>
					<fieldset id="selecte_simple_form">
						<legend>选择已有的简单产品:</legend>
						<input type="hidden" id="associated_ids" name="associated_ids" />
						<table id="atoolbar"></table>
						<div id="aptoolbar"></div>
					</fieldset>
                    <input type="hidden" name="default_item" />
				</div>
				<!--END tabs-5 -->

				<!--START tabs-6 -->
				<div id="tabs-6">
					<div id="grid_head_bar" class="clr">
						<div class="float_left">&nbsp;<input type="checkbox" id="select_all"/><label for="select_all">全选</label></div>
						<a href="#" class="float_left" id="view_selected_products">预览我已选的产品列表</a>( <span id="selected_num">0</span> selected )
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
                    <?php echo $catalog_checkboxes_tree;?>
                </div>
                <!--END tabs-catalogs -->

				<!--START tabs-7 -->
				<div id="tabs-7">
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
