<?php echo View::factory('admin/site/label_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript" src="/media/js/file-uploader/fileuploader.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#niche').blur(function(){
		var str=$('#niche').val();
		$('#url').val(str.replace(/&|\#|\?|\%| |\//g,"-").toLocaleLowerCase());
	});
	$('select').change(function(){
			$("input[name='defined_catalog']").val($(this).val());
			var str=$('#defined_catalog').val();
			$('#catalog_link').val(str.replace(/&|\#|\?|\%| |\//g,"-").toLocaleLowerCase());
		})
	$('#defined_catalog').blur(function(){
			var str=$('#defined_catalog').val();
			$('#catalog_link').val(str.replace(/&|\#|\?|\%| |\//g,"-").toLocaleLowerCase());
		});
});
</script>
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
					<label>Defined_Catalog:<span class="req">*</span></label>
					<div>
						<input type="text" id="defined_catalog" name="defined_catalog" class="text required" value=""/>
						<select>
							<option value="">-Select a Defined Catalog</option>
						<?php foreach ($catalogs as $catalog) :
								if($catalog['defined_catalog']!=''):
						?>
							<option value="<?php echo $catalog['defined_catalog'];?>"><?php echo $catalog['defined_catalog'];?></option>
						<?php
								endif; 
							 endforeach;
						?>
						</select>
					</div>
				</li>
				
				<li>
					<label>Defined_Catalog_URL:<span class="req">*</span></label>
					<div>
						<input type="text" id="catalog_link" name="defined_catalog_link" class="text required" value=""/>
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
					<input name="is_active" value="1" type="hidden" />
				</li>
			</ul>
		</form>
    </div>
</div>