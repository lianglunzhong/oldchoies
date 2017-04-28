<?php echo View::factory('/admin/ticket/ticket_left')->render(); ?>
<div id="do_right">
	<div class="box">
	<h3>Topic修改</h3>
	<form action="/admin/ticket/topic/edit/<?php echo $id;?>" method="post" name="form1" id="form1">
		<ul>
			<li>
				<label>名称：</label>
				<div><input type="text" id="topic" name="topic" value="<?php echo $topic;?>" class="text medium" /></div>
			</li>
			<li>
				<label>简介：</label>
				<div><textarea id="brief" name="brief" rows="6" cols="60" tabindex="1" class="textarea"><?php echo $brief;?></textarea></div>
			</li>
			<li>
				<label>优先级：</label>
				<div>
					<select id="priority_id" name="priority_id">
					<?php foreach($priority_list as $key=>$priority):?>
					<option value="<?php echo $key;?>" <?php echo $priority_id == $key ? 'selected' : '' ?>><?php echo $priority['status']; ?></option>
					<?php endforeach;?>
			</select>
				</div>
			</li>
			<li>
				<label>激活：</label>
				<div>
					<input type="radio" name="is_active" value="1" <?php echo $is_active == 1 ? 'checked' : '' ?> />是
					<input type="radio" name="is_active" value="0" <?php echo $is_active == 0 ? 'checked' : '' ?> />否
				</div>
			</li>
			<li>
				<label>用于：</label>
				<div>
					<input type="radio" name="for_customer" value="0" <?php echo $for_customer == 0 ? 'checked' : '' ?> />客户
					<input type="radio" name="for_customer" value="1" <?php echo $for_customer == 1 ? 'checked' : '' ?> />客服
				</div>
			</li>
			<li>
				<input value="修  改" class="button" type="submit">
			</li>
		</ul>
	</form>
	</div>
</div>
