<?php echo View::factory('admin/site/promotion_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript">
	//商品分类的树状显示
	$(function(){
		$('li.catalog_tree_name').prepend('<ins class="tree_icon">&nbsp;</ins>');
		$('li.catalog_tree_children').prev().find('.tree_icon').addClass('tree_icon_parent tree_icon_parent_expanded').css('cursor','pointer').click(function(){
			$(this).toggleClass('tree_icon_parent_expanded').parent().next().slideToggle(0);
		});
		$('li.catalog_tree_name input[type=checkbox]').click(function(){
			$(this).prev().toggleClass('tree_checked');
		});
	});
</script>
<script type="text/javascript">
	$(function(){
		$('.filter_condition_checkboxs input').filter(':checked').each(function(){
			$(this).parent().find('label').addClass('filter_condition_checkboxs_label_selected');
		});
		//		$.datepicker.setDefaults('option',{dateFormat:'yy-mm-dd'});
        init_catalogs();

        $('.sets_checkboxes:checked').each(function(){
            attributes.add($(this).val(),1);
        });
    });
    
    function init_catalogs(){
<?php
$catalogs = explode(',', $filter->catalogs);
echo 'var catalogs = '.json_encode($catalogs).';
			';
?>
		$('#catalog_tree input[type=checkbox]').each(function(){
			var $this = $(this);
			if($.inArray($this.val(), catalogs) != -1) {
				$this.attr('checked','checked');
			}
		});
    }

    options_selected = [<?php echo $filter->options;?>];
</script>
<script type="text/javascript" src="/media/js/promotion_admin.js"></script>
<div id="do_right">
	<div class="box promotion_box" style="overflow:hidden;">
		<div class="title">
			<h3>修改产品促销</h3>
		</div>
		<?php
// echo kohana::debug($catalog);
		?>
		<form method="post" action="#" class="need_validation">

			<script type="text/javascript">
				$(function() {
					$("#tabs").tabs();
				});
			</script>

			<div id="tabs">
				<ul>
					<li><a href="#tabs-1">基本信息</a></li>
					<li><a href="#tabs-2">促销详情</a></li>
					<li><a href="#tabs-3">SEO相关</a></li>
				</ul>
				<!--START tabs-1 -->
				<div id="tabs-1">
					<ul>

						<li>
							<label>名称<span class="req">*</span></label>
							<div>
								<input name="catalog_name" id="catalog_name" class="text medium required" type="text"  value="<?php echo $promotion->name; ?>"/>
							</div>
						</li>

						<li>
							<label>简介</label>
							<div>
								<input name="brief" class="text long" type="text" value="<?php echo $promotion->brief; ?>">
							</div>
						</li>

						<li>
							<label>开始时间<span class="req">*</span></label>
							<div>
								<input type="text" name="from_date" class="text datepick required" value="<?php echo date('m/d/Y', $promotion->from_date); ?>"/>
							</div>
						</li>

						<li>
							<label>结束时间<span class="req">*</span></label>
							<div>
								<input type="text" name="to_date" class="text datepick required" value="<?php echo date('m/d/Y', $promotion->to_date); ?>" />
							</div>
						</li>

					</ul>
				</div>
				<div id="tabs-2">
					<br />
					<fieldset class="filter_condition catalog_checkboxes_tree">
						<legend>选择商品分类:</legend>
						<?php echo $catalog_checkboxes_tree; ?>
					</fieldset>
					<div class="filter_condition">
						<label for="price_lower">价格区间($)</label>: 从
						<input type="text" name="condition[price_lower]" id="price_lower" class="text numeric inline" value="<?php echo $filter->price_lower ? $filter->price_lower : ($filter->price_upper ? 0 : ''); ?>" />
																																														到
						<input type="text" name="condition[price_upper]" class="text numeric inline" value="<?php echo $filter->price_upper ? $filter->price_upper : ''; ?>" />
					</div>
					<div class="filter_condition filter_condition_sets">
						<fieldset class="clr">
							<legend>选择商品类型:</legend>
							<div class="filter_condition_sets_check_box">
								<?php
								$sets_selected = explode(',', $filter->sets);
								foreach( $sets as $set )
								{
									echo '
												<div class="filter_condition_checkboxs"><input type="checkbox" class="sets_checkboxes" name="condition[sets][]" value="'.$set->id.'" id="condition_set_'.$set->id.'" '.(in_array($set->id, $sets_selected) ? ' checked="checked"' : '').' /><label for="condition_set_'.$set->id.'"> '.$set->name.'</label></div>';
								}
								?>
							</div>
						</fieldset>
					</div>
					<div class="filter_condition filter_condition_attributes">
						<fieldset class="clr"  id="attributes_box">
							<legend>选择商品属性:</legend>
							</fieldset>
						</div>
						<div class="filter_condition promotion_method">
							<fieldset>
								<legend>促销方式</legend>
							<?php
								$actions = explode(':', $promotion->actions);
							?>
								<input type="radio" name="method" id="method_1" value="rate" <?php echo $actions[0] == 'rate' ? ' checked = "checked" ' : ''; ?>/> <label for="method_1">原价乘以: </label> <input type="text" name="rate" class="numeric" <?php echo $actions[0] != 'rate' ? ' disabled = "disabled" ' : ' value="'.$actions[1].'"'; ?>/>% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="method" id="method_2" value="reduce" <?php echo $actions[0] == 'reduce' ? ' checked = "checked" ' : ''; ?>/> <label for="method_2">原价减去: </label> <!-- TODO:显示货币符号 --><input type="text" name="reduce"  class="numeric" <?php echo $actions[0] != 'reduce' ? ' disabled = "disabled" ' : ' value="'.$actions[1].'"'; ?>/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="method" id="method_3" value="equal" <?php echo $actions[0] == 'equal' ? ' checked = "checked" ' : ''; ?>/> <label for="method_3">原价改至: </label> <!-- TODO:显示货币符号 --><input type="text" name="equal"  class="numeric" <?php echo $actions[0] != 'equal' ? ' disabled = "disabled" ' : ' value="'.$actions[1].'"'; ?>/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="method" id="method_4" value="points" <?php echo $actions[0] == 'points' ? ' checked = "checked" ' : ''; ?>/> <label for="method_1">双倍积分</label><input type="text" name="points" class="numeric" <?php echo $actions[0] != 'points' ? ' disabled = "disabled" ' : ' value="'.$actions[1].'"'; ?>/>  
						</fieldset>
					</div>
				</div>
				<!--END tabs-2 -->

				<!--START tabs-3 -->
				<div id="tabs-3">

					<ul>

						<li>
							<label>META TITLE</label>
							<div>
								<input name="meta_title" id="meta_title" class="text long" type="text"/>
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

						<li>
							<label>image src</label>
							<div>
								<input name="image_src" id="image_src" class="text long" type="text"/>
							</div>
						</li>

						<li>
							<label>image link</label>
							<div>
								<input name="image_link" id="image_link" class="text long" type="text"/>
							</div>
						</li>

						<li>
							<label>image alt</label>
							<div>
								<input name="image_alt" id="image_alt" class="text long" type="text"/>
							</div>
						</li>

					</ul>
				</div>
				<!--END tabs-3 -->

			</div>

			<ul>
				<li>
					<input value="Submit" class="button" type="submit" />
				</li>
			</ul>
		</form>
	</div>
</div>
