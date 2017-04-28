<?php echo View::factory('admin/site/label_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript">
product_ids=[];
<?php
		if($label->product_ids!='')
		{
			$product_ids=explode(',',$label->product_ids);
			foreach( $product_ids as $key => $id )
			{
				echo "product_ids[$key] = '$id';
		";
			}
		}
?>
config = {};
config['catalog_id']='';
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
</script>
<script type="text/javascript" src="/media/js/catalog/catalog_basic_admin.js"></script>
<div id="do_right">
    <div class="box">
        <h3>Edit Niche label</h3>
        <ul>
        	<li>
        		<label>Replace Products(separate with comma)</label>
        		<div>
        			<form action="/admin/site/label/edit/<?php echo $label->id;?>" method="post">
        				<input name="skus" type="text" value="<?php echo $selected_sku;?>" size="120"/>
        				<input type="submit" value="Submit">
        			</form>
        		</div>
        	</li>
        </ul>
        <form name="niche_label" action="" method="post" class="need_validation">
			<ul>
				<li>
					<label>Niche</label>
					<div>
						<label><?php echo $label->niche;?></label>
					</div>
				</li>
				
				<li>
					<label>Meta Title</label>
					<div>
						<input id="meta_title" name="meta_title"  type="text" class="text" value="<?php echo $label->meta_title;?>"/>
					</div>
				</li>
				
				<li>
					<label>Meta Description</label>
					<div>
						<textarea name="meta_description" style="width: 480px; height: 150px;"><?php echo $label->meta_description;?></textarea>
					</div>
				</li>
				
				<li>
					<label>Meta Keywords</label>
					<div>
						<input id="meta_keywords" name="meta_keywords"  type="text" class="text" value="<?php echo $label->meta_keywords;?>"/>
					</div>
				</li>
								
				<li>
					<label>Global Searches</label>
					<div>
						<input id="global" name="global"  type="text" class="text" value="<?php echo $label->global;?>"/>
					</div>
				</li>

				<li>
					<label>Local Searches</label>
					<div>
						<input id="local" name="local"  type="text" class="text" value="<?php echo $label->local;?>"/>
					</div>
				</li>
				
				<li>
					<label>Competition</label>
					<div>
						<input id="competition" name="competition"  type="text" class="text" value="<?php echo $label->competition;?>"/>
					</div>
				</li>
				
				<li>
					<label>Description</label>
					<div>
						<textarea name="description" style="width: 480px; height: 150px;"><?php echo $label->description;?></textarea>
					</div>
				</li>

				<li>
					<label>Disply Number<span class="req">*</span></label>
					<div>
						<input type="text" name="display_number" class="text required" value="<?php echo $label->display_number;?>"/>
					</div>
				</li>

                <li>
					<label>Products<span class="req">*</span></label>
					<div>
						<div id="products">

							<div id="grid_head_bar" class="clr">
								<div class="float_left">&nbsp;<a id="select_all" class="inline_link" href="#">All</a>&nbsp;|&nbsp;<a id="invert_all" class="inline_link" href="#">Invert</a></div>
                                <a href="#" class="float_left" id="view_selected_products">预览我的修改结果</a>
                                <div class="float_left">( <span id="selected_num"><?php //echo count($product_ids);?></span> selected )</div>
								<a href="#" class="float_right" id="search_grid">过滤</a>
								<a href="#" class="float_right" id="reset_search_grid">查看所有产品</a>
							</div>
							<div>
								<table id="toolbar"></table>
								<div id="ptoolbar"></div>
							</div>
						</div>
					</div>
                </li>
                				
				<li>
						<input value="Submit" class="button" type="submit" />
				</li>
			</ul>
		</form>
    </div>
</div>