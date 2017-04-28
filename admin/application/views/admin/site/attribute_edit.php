<?php echo View::factory('admin/site/basic_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<div id="do_right">
	<div class="box">
		<h3>修改产品规格</h3>
		<form method="post" action="/admin/site/attribute/edit/<?php echo $attribute->id; ?>" id="do_form_attribute_edit" class="need_validation">
			<ul>
				<li>
					<label>name<span class="req">*</span></label>
					<div>
						<input id="name" name="name" class="short text required" type="text" value="<?php echo $attribute->name; ?>">
					</div>
					<label class="note">Input note message goes here.</label>
				</li>

				<li>
					<label>label<span class="req">*</span></label>
					<div>
						<input id="label" name="label" class="short text required" type="text" value="<?php echo $attribute->label; ?>">
					</div>
					<label class="note">Input note message goes here.</label>
				</li>

				<li>
					<label>简介</label>
					<div>
						<input name="brief" class="text long" type="text" value="<?php echo $attribute->brief; ?>">
					</div>
				</li>

				<li>
					<label>输入方式</label>
					<div>
						<select class="drop" id="input_type" name="type">
							<option <?php if($attribute->type == 0 )echo ' selected="selected" '; ?>value="0">下拉选框</option>
							<option <?php if($attribute->type == 1 )echo ' selected="selected" '; ?>value="1">单选按钮</option>
							<option <?php if($attribute->type == 2 )echo ' selected="selected" '; ?>value="2">单行文本框</option>
							<option <?php if($attribute->type == 3 )echo ' selected="selected" '; ?>value="3">多行文本框</option>
						</select>
					</div>
				</li>

				<li id="options_display" <?php if( ! in_array($attribute->type, array( 0, 1 ))) echo ' style="display:none;" '; ?>  class="hazy" >
					<label>显示方式</label>
					<div>
						<input name="view" class="radio" value="0" <?php if($attribute->view == 0) echo ' checked="checked" '; ?>type="radio"><label class="choice">平铺显示</label>
						<input name="view" class="radio" value="1" <?php if($attribute->view == 1) echo ' checked="checked" '; ?>type="radio"><label class="choice">下拉显示</label>
					</div>
				</li>

				<li>
					<label>使用范围</label>
					<div>
						<select class="drop" name="scope" id="scope">
							<option <?php if($attribute->scope == 0) echo ' selected="selected" '; ?> value="0">公共</option>
							<option <?php if($attribute->scope == 1) echo ' selected="selected" '; ?>value="1">单个产品</option>
							<option <?php if($attribute->scope == 2) echo ' selected="selected" '; ?>value="2">前台顾客输入</option>
						</select>
					</div>
				</li>

				<li>
					<label>必填</label>
					<div>
						<input name="required" class="radio" value="0" <?php if($attribute->required == 0) echo ' checked="checked" '; ?> type="radio"><label class="choice">否</label>
						<input name="required" class="radio" value="1" <?php if($attribute->required == 1) echo ' checked="checked" '; ?> type="radio"><label class="choice">是</label>
					</div>
				</li>

				<li>
					<label>可作为搜索条件</label>
					<div>
						<input name="searchable" class="radio" value="0" checked="checked" <?php if($attribute->searchable == 0) echo ' checked="checked" '; ?> type="radio"><label class="choice">否</label>
						<input name="searchable" class="radio" value="1" <?php if($attribute->searchable == 1) echo ' checked="checked" '; ?> type="radio"><label class="choice">是</label>
					</div>
				</li>

				<li>
					<label>可作为促销条件</label>
					<div>
						<input name="promo" class="radio" value="0" <?php if($attribute->promo == 0) echo ' checked="checked" '; ?>type="radio"><label class="choice">No</label>
						<input name="promo" class="radio" value="1" <?php if($attribute->promo == 1) echo ' checked="checked" '; ?>type="radio"><label class="choice">Yes</label>
					</div>
				</li>

				<li>
					<table id="options_table" <?php if( ! in_array($attribute->type, array( 0, 1 ))) echo ' style="display:none;" '; ?>  class="hazy" >
						<thead>
							<tr>
								<th scope="col">ID</th>
								<th scope="col">Option</th>
								<th scope="col">Postion</th>
								<!--
								<th scope="col">Default</th>
								-->
								<th scope="col"><input value="Add Option" class="button" type="button" id="option_add" /></th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach( $options as $key => $option )
							{
							?>
								<tr>
                                    <td><?php echo $option->id;?></td>
                                    <td><input name="option_label_update[<?php echo $option->id?>]" class="text" type="text" value="<?php echo $option->label; ?>" /></td>
									<td><input name="option_position_update[<?php echo $option->id?>]" class="text" type="text" value="<?php echo $option->position; ?>" /></td>
									<!--
									<td><input name="option_default" class="radio" value="1" type="radio" /></td>
												-->
									<td>
                                        <input type="button" class="option_delete" value="删除"/>
                                    </td>
                                </tr>
							<?php
								}
							?>
							</tbody>
						</table>

						<div id="input_2" class="hazy" <?php if($attribute->type != 2) echo ' style="display:none;" '; ?>>
							<label>默认值: </label><br />
							<input type="text" name="default_value_2" value="<?php echo $attribute->default_value; ?>" class="text medium" />
						</div>
						<div id="input_3" class="hazy" <?php if($attribute->type != 3) echo ' style="display:none;" '; ?>>
							<label>默认值: </label><br />
							<textarea name="default_value_3" cols="50" rows="5"><?php echo $attribute->default_value; ?></textarea>
					</div>

				</li>

				<li>
					<button type="submit">保存</button>
				</li>

			</ul>
		</form>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('#option_add').click(function(){
			$('#options_table tbody').append('<tr><td></td><td><input name="option_label[]" class="text" type="text" value="" /></td><td><input name="option_position[]" class="text" type="text" value="0" /></td><td><input type="button" class="option_delete" value="删除"/></td></tr>');
		});

        $('.option_delete').live('click',function(){
            var $this = $(this),$name = $this.parent().prev().prev(), name = $('input',$name).val(), id = $name.prev().text();
            if(confirm('Warning: \n\nDo you really want to delete #' + id + ': "' + name + '" ?\nAll products associated with this option will be broken!'))
            {
                $(this).parentsUntil('tbody').remove();
            }    
		});

		$('#input_type').change(function(){
			var input_type = $(this).val(),input_box_id = '#input_' + input_type;
			if(input_type == 0 ||input_type == 1) {
				input_box_id = '#options_table,#options_display';
				do_options.add();
			} else {
				do_options.remove();
			}
			$(input_box_id).show();
			$('.hazy').not(input_box_id).hide();
		});
		if($('#input_type').val() != 0 && $('#input_type').val() != 1) {
			do_options.remove();
		}

	});

	do_options = (function(){
		var $options = 0;
		return {
			'add':function(){
				if($options != 0) {
					$('#scope').append($options);
					$options = 0;
				}
			},
			'remove':function(){
				if($options == 0) {
					$options = $('#scope option[value=1]');
					$options.remove();
				}
			}
		};
	})();
</script>
