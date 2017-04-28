<?php echo View::factory('/admin/ticket/ticket_left')->render(); ?>
<div id="do_right">
	<div class="box">
	<h3>Ticket Modify</h3>
	<form action="/admin/ticket/template/edit/<?php echo $id;?>" method="post" name="form1" id="form1">
		<ul>
			<li>
				<label>Title：</label>
				<div><input type="text" id="tpl_name" name="tpl_name" value="<?php echo $tpl_name;?>" class="text medium" /></div>
			</li>
			<li>
				<label>Belongs to Topic：</label>
				<div>
				<select id="topic_id" name="topic_id">
				<?php 
					foreach ($topics as $topic)
					{
				?>
				<option value="<?php echo $topic['id'];?>" <?php if($topic['id']==$topic_id) echo ' selected'; ?>><?php echo $topic['topic'];?></option>
				<?php 
					}
				?>
				</select>
				</div>
			</li>
			<li>
				<label>Content：</label>
				<div><textarea id="tpl_content" name="tpl_content" rows="6" cols="60" tabindex="1" class="textarea"><?php echo $tpl_content;?></textarea></div>
			</li>
			<li>
				<label>Is Active：</label>
				<div>
					<input type="radio" name="is_active" value="1" <?php echo $is_active == 1 ? 'checked' : '' ?> />yes
					<input type="radio" name="is_active" value="0" <?php echo $is_active == 0 ? 'checked' : '' ?> />no
				</div>
			</li>
			<li>
				<input value="修  改" class="button" type="submit">
			</li>
		</ul>
	</form>
	</div>
</div>
