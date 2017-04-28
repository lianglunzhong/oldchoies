<?php echo View::factory('admin/site/label_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript">
product_ids=[];
config = {};
config['catalog_id']='';
function set_catalog(id)
{
	$('#catalog_id').val(id);
	$.each($('#catalog a'),function(){
		$(this).css('color','#666666');
		});
	$('#catalog_'+id).css('color','#FF0000');
	config['catalog_id']=id;
   	jQuery("#toolbar").jqGrid('setGridParam',{url:'/admin/site/catalog/ajax_products/'+id}).trigger('reloadGrid');
}

function r()
{
    var item = $("input[name='random']:checked").val();
    if(item==0)
   		$('#products').css('display','block');
    else
    	$('#products').css('display','none');
};
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
$(document).ready(function(){
	$('#niche').blur(function(){
		var str=$('#niche').val();
		$('#url').val(str.replace(/&|\#|\?|\%| |\//g,"-").toLocaleLowerCase());
	});
});
</script>
<script type="text/javascript" src="/media/js/catalog/catalog_basic_admin.js"></script>
<script type="text/javascript" src="/media/js/catalog/catalog_admin.js"></script>
<div id="do_right">
    <div class="box">
        <h3>Add Niche label</h3>
        <form name="niche_label" action="" method="post" class="need_validation">
			<ul>

				<li>
					<label>Niche<span class="req">*</span></label>
					<div>
						<input id="niche" name="niche"  class="text medium required" type="text" />
					</div>
				</li>
				
				<li>
					<label>URL<span class="req">*</span></label>
					<div>
						<input id="url" name="url"  class="text medium required" type="text" />
					</div>
				</li>

				<li>
					<label>Select Catalog</label>
					<input type="hidden" name="catalog_id" id="catalog_id" value="" class="text medium required"/>
				    <div>
				        <ul id="catalog">
							<li>Catalog Tree <a id="catalog_tree_collapse_expand" href="#" style="color:#666666">Collapse All</a>
								<?php echo $catalog_tree;?>
							</li>
				        </ul>
				    </div>
				</li>
				
				<li>
						<input value="Submit" class="button" type="submit" />
				</li>
				
				<li>
					<label>Meta Title</label>
					<div>
						<input id="meta_title" name="meta_title"  type="text" class="text"/>
					</div>
				</li>
				
				<li>
					<label>Meta Description</label>
					<div>
						<textarea name="meta_description" style="width: 480px; height: 150px;"></textarea>
					</div>
				</li>
				
				<li>
					<label>Meta Keywords</label>
					<div>
						<input id="meta_keywords" name="meta_keywords"  type="text" class="text"/>
					</div>
				</li>
				
				<li>
					<label>Global Searches</label>
					<div>
						<input id="global" name="global"  type="text" class="text"/>
					</div>
				</li>

				<li>
					<label>Local Searches</label>
					<div>
						<input id="local" name="local"  type="text" class="text"/>
					</div>
				</li>
				
				<li>
					<label>Competition</label>
					<div>
						<input id="competition" name="competition"  type="text" class="text"/>
					</div>
				</li>
				
				<li>
					<label>Description</label>
					<div>
						<textarea name="description" style="width: 480px; height: 150px;"></textarea>
					</div>
				</li>

				<li>
					<label>Disply Number<span class="req">*</span></label>
					<div>
						<input type="text" name="display_number" class="text required" value="<?php echo Site::instance()->get('per_page')?>"/>
					</div>
				</li>

                <li>
					<label>Products<span class="req">*</span></label>
					<div>
						<label>Random:&nbsp;&nbsp;&nbsp;&nbsp;</label><input name="random" value="1" type="radio" id="random_t" checked="checked" onclick="r()"/><label for="random_t"> Yes</label> &nbsp;&nbsp;&nbsp;&nbsp;
						<input name="random" value="0" type="radio" id="random_f" onclick="r()"/><label for="random_f" > No</label>	
						<div id="products"  style="display:none">

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
					<input name="is_active" value="1" type="hidden" />
				</li>
<!--				<li>-->
<!--					<label>Activity<span class="req">*</span></label>-->
<!--					<div>-->
<!--						<input name="is_active" value="1" type="radio" id="is_active_t" checked="checked"/><label for="is_active_t"> Yes</label> &nbsp;&nbsp;&nbsp;&nbsp;-->
<!--						<input name="is_active" value="0" type="radio" id="is_active_f"/><label for="is_active_f"> No</label>-->
<!--					</div>-->
<!--				</li>-->
			</ul>
		</form>
    </div>
</div>