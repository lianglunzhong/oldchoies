<?php echo View::factory('admin/site/basic_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<div id="do_right">
	<div class="box">
		<h3>添加属性</h3>
		<form method="post" action="/admin/site/attribute/add" id="do_form_attribute_add" class="need_validation">
			<ul>
				<li>
					<label>名称<span class="req">*</span></label>
					<div>
						<input id="name" name="name" class="short text required" type="text">
					</div>
					<label class="note">仅后台可见的属性名。</label>
				</li>

				<li>
					<label>标题<span class="req">*</span></label>
					<div>
						<input id="label" name="label" class="short text required" type="text">
					</div>
					<label class="note">前台可见的属性标题。</label>
				</li>

				<li>
					<label>简介</label>
					<div>
						<input name="brief" class="text long" value="" type="text">
					</div>
				</li>

				<li>
					<label>输入方式</label>
					<div>
						<select class="drop" id="input_type" name="type">
							<option selected="selected" value="0">下拉选框</option>
							<option value="1">单选按钮</option>
							<option value="2">单行文本框</option>
							<option value="3">多行文本框</option>
						</select>
					</div>
				</li>

				<li id="options_display" class="hazy">
					<label>显示方式</label>
					<div>
						<input name="view" class="radio" value="0" checked="checked" type="radio"><label class="choice">平铺显示</label>
						<input name="view" class="radio" value="1" type="radio"><label class="choice">下拉显示</label>
					</div>
				</li>

				<li>
					<label>使用范围</label>
					<div>
						<select class="drop" name="scope" id="scope">
							<option selected="selected" value="0">公共</option>
							<option value="1">单个产品</option>
							<option value="2">前台顾客输入</option>
						</select>
					</div>
				</li>

				<li>
					<label>必填</label>
					<div>
						<input name="required" class="radio" value="0" checked="checked" type="radio"><label class="choice">否</label>
						<input name="required" class="radio" value="1" type="radio"><label class="choice">是</label>
					</div>
				</li>

				<li>
					<label>可作为搜索条件</label>
					<div>
						<input name="searchable" class="radio" value="0" checked="checked" type="radio"><label class="choice">否</label>
						<input name="searchable" class="radio" value="1" type="radio"><label class="choice">是</label>
					</div>
				</li>

				<li>
					<label>可作为促销条件</label>
					<div>
						<input name="promo" class="radio" value="0" checked="checked" type="radio"><label class="choice">否</label>
						<input name="promo" class="radio" value="1" type="radio"><label class="choice">是</label>
					</div>
				</li>

				<li>
					<table id="options_table" class="hazy">
						<thead>
							<tr>
								<th scope="col">可选值</th>
								<th scope="col">顺序</th>
								<!--
								<th scope="col">Default</th>
								-->
								<th scope="col"><input value="添加可选值" class="button" type="button" id="option_add" /></th>
							</tr>
						</thead>
						<tbody>

							<tr>
								<td><input name="option_label[]" class="text" type="text" value="" /></td>
								<td><input name="option_position[]" class="text" type="text" value="0" /></td>
								<!--
								<td><input name="option_default" class="radio" value="1" type="radio" /></td>
								-->
								<td></td>
							</tr>

						</tbody>
					</table>
					<div id="input_2" class="hazy" style="display:none;">
						<label>默认值: </label><br />
						<input type="text" name="default_value_2" class="text medium" />
					</div>
					<div id="input_3" class="hazy" style="display:none;">
						<label>默认值: </label><br />
						<textarea name="default_value_3" cols="50" rows="5"></textarea>
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
			$('#options_table tbody').append('<tr><td><input name="option_label[]" class="text" type="text" value="" /></td><td><input name="option_position[]" class="text" type="text" value="0" /></td><td><input type="button" class="option_delete" value="删除"/></td></tr>');
		});

		$('.option_delete').live('click',function(){
			$(this).parentsUntil('tbody').remove();
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
