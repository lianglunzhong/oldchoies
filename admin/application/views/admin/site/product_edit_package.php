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
config['image_tempfolder'] = "/pimages/<?php echo Session::instance()->get('SITE_ID'); ?>/99";
config['image_allowed_extensions'] = ["<?php echo implode('","',kohana::config('upload.product_image.filetypes'));?>"];
config['image_max_size'] = <?php echo kohana::config('upload.product_image.max_size');?>;
config['product_id'] = <?php echo $product['id']; ?>;
config['catalogs'] = <?php echo $catalogs ? '["'.implode('","',$catalogs).'"]' : '[]'; ?>;
config['default_catalog'] = <?php echo $product['default_catalog'];?>;
selected_packaged = [];
<?php
foreach( $product['packaged_products'] as $key => $id )
{
	echo 'selected_packaged['.$key.'] = "'.$id.'";
		';
}
?>
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
    var options = '<?php echo $set_options;?>';
    $('#gs_product_set').append(options);
    $('#gs_packaged_product_set').append(options);
}
</script>
<script type="text/javascript" src="/media/js/product_admin/package_product_admin.js"></script>
<script type="text/javascript" src="/media/js/product_admin/product_edit.js"></script>

	<div class="box">
		<h3>
			Edit Package Product
		</h3>
		<form method="post" action="#" name="product_form" class="need_validation">
			<div id="tabs"  style="overflow:hidden;">
				<ul>
					<li><a href="#tabs-1">Basic</a></li>
					<li><a href="#tabs-2">Images</a></li>
					<li><a href="#tabs-4">Description</a></li>
					<li><a href="#tabs-5">Packaged Products</a></li>
					<li><a href="#tabs-6">Related Products</a></li>
					<li><a href="#tabs-catalogs">Catalogs</a></li>
					<li><a href="#tabs-7">SEO</a></li>
				</ul>
				<!--START tabs-1 -->
				<div id="tabs-1">
					<ul>
						<li>
							<label>Name<span class="req">*</span></label>
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
                            <label>Avaliable for sale:</label>
                            <div>
                                <input type="radio" class="radio" name="product[status]" value="1" <?php if($product['status'] == 1) echo ' checked = "checked" '; ?>/> Yes
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="radio" name="product[status]" value="0" <?php if($product['status'] == 0) echo ' checked = "checked" '; ?>/> No
                            </div>
                        </li>

						<li>
                            <label>本站价格(<?php echo Site::instance()->default_currency();?>)<span class="req">*</span></label>
                            <div>
                                <input name="product[price]" id="price" class="short text required number" type="text" value="<?php echo $product['price']; ?>"/> <a href="#" class="product_bulk_rules_toggle">Tier price</a>
<?php
if(!empty($product['configs']['bulk_rules']))
{
?>
<div class="product_bulk_rules">
<?php
	foreach($product['configs']['bulk_rules'] as $num=>$price)
	{
		echo '<div>Qty &gt;= <input type="text" name="product[bulk_num][]" class="text numeric required digits" value="'.$num.'"/>, Price = <input type="text" name="product[bulk_price][]"  class="text numeric required number" value="'.trim($price).'" /> <a href="#" class="remove_bulk_rule">[-]</a> <a href="#" class="add_bulk_rule">[+]</a></div>';
	}
?>
</div>
<?php
}
?>
                            </div>
							<label>市场价格(<?php echo Site::instance()->default_currency();?>)</label>
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
							<label>Stock<span class="req">*</span></label>
                            <div class="form_radio_row">
                                <input type="radio" name="product[no_limit_stock]" class="no_limit_stock" id="no_limit_stock_yes" value="1"<?php
echo $product['stock'] != -99 ? '' : ' checked="checked"';?>/><label for="no_limit_stock_yes"> No limit.</label><br/>
                                <input type="radio" name="product[no_limit_stock]" class="no_limit_stock radio" value="0"<?php
echo $product['stock'] == -99 ? '' : ' checked="checked"';?>/>
                                <input name="product[stock]" id="stock" class="product_stock short text required digits" type="text"<?php
echo $product['stock'] != -99 ? ' value="'.$product['stock'].'"' : ' disabled="disabled"';?>>
                            </div>
						</li>

                        <li>
                            <label>Brief</label>
                            <div>
                                <input name="product[brief]" id="brief" class="text short" type="text" value="<?php echo $product['brief']; ?>"/>
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
					<input type="hidden" name="images" />
					<input type="hidden" name="images_default" />
					<input type="hidden" name="images_removed" />
					<input type="hidden" name="images_order"/>
					<ul id="images_list" class="clr">
						<?php
						foreach( $product['images'] as $image )
						{
							if($image['id'] == 0)
							{
								continue;
							}
						?>
							<li image_id="<?php echo $image['id']; ?>">
								<img src = "/pimages/<?php echo Site::instance()->get('id').'/99/'.$image['id'].'.'.$image['suffix']; ?>" alt="<?php echo $image['id']; ?>号产品图"/>
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
                    <div class="filter_condition" id="total_quantity_box">
                        <label for="total_quantity">Total Quantity:</label>
                        <input type="text" name="packaged[total]" id="total_quantity" class="text numeric digits inline" value="<?php echo $product['configs']['quantity']['total'];?>">
                    </div>
<?php
                        if($product['packaged_products'])
                        {
?>
<table>
    <thead>
        <tr>
            <th scope="col">
                ID
            </th>
            <th scope="col" width="60%">
                Name
            </th>
            <th scope="col">
                SKU
            </th>
            <th scope="col">
                Min. Quantity
            </th>
            <th scope="col">
                Max. Quantity
            </th>
            <th scope="col">
                Actions
            </th>
        </tr>
    </thead>
    <tbody id="selected_packaged_products">
<?php
                            foreach($product['packaged_products'] as $pid)
                            {
                                $packaged_product = Product::instance($pid);
?>
        <tr>
            <td>
                <?php echo $packaged_product->get('id');?>
            </td>
            <td>
                <?php echo $packaged_product->get('name');?>
            </td>
            <td>
                <?php echo $packaged_product->get('sku');?>
            </td>
            <td>
                <input type="text" class="text numeric digits inline" name="packaged[min][<?php echo $pid;?>]"
                value="<?php echo $product['configs']['quantity']['min'][$pid];?>">
            </td>
            <td>
                <input type="text" class="text numeric digits inline" name="packaged[max][<?php echo $pid;?>]"
                value="<?php echo $product['configs']['quantity']['max'][$pid];?>">
            </td>
            <td>
                <a href="/admin/site/product/edit/<?php echo $pid;?>" target="_blank">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" product_id="<?php echo $pid;?>" class="remove_selected_product">Remove</a>
            </td>
        </tr>
<?php
                            }
?>
    </tbody>
</table>

<?php
                        }
?>
					<fieldset id="selecte_simple_form">
						<legend>Select product:</legend>
                        <input type="hidden" id="packaged_ids" name="packaged_ids" value="<?php echo implode(',',$product['packaged_products']);?>"/>
						<table id="atoolbar"></table>
						<div id="aptoolbar"></div>
					</fieldset>
				</div>
				<!--END tabs-5 -->

				<!--START tabs-6 -->
				<div id="tabs-6">
					<div id="grid_head_bar" class="clr">
						<div class="float_left">&nbsp;<input type="checkbox" id="select_all"/><label for="select_all">全选</label></div>
						<a href="#" class="float_left" id="view_selected_products">预览我已选的产品列表</a>( <span id="selected_num"><?php echo count($product['related_products']);?></span> selected )
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
