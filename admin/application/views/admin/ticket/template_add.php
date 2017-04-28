<?php echo View::factory('/admin/ticket/ticket_left')->render(); ?>
<div id="do_right">
	<div class="box">
	<h3>Add Template</h3>
	<form action="/admin/ticket/template/add" method="post" name="form1" id="form1">
		<ul>
			<li>
				<label>Title：</label>
				<div><input type="text" id="tpl_name" name="tpl_name" class="text medium" /></div>
			</li>
			<li>
				<label>Belongs to Topic：</label>
				<div>
				<select id="topic_id" name="topic_id">
				<?php 
					foreach ($topics as $topic)
					{
				?>
				<option value="<?php echo $topic['id'];?>"><?php echo $topic['topic'];?></option>
				<?php 
					}
				?>
				</select>
				</div>
			</li>
			<li>
				<label>Content：</label>
				<div><textarea id="tpl_content" name="tpl_content" rows="10" cols="80" tabindex="1" class="textarea"></textarea></div>
			</li>
			<li>
				<label>Is Active：</label>
					<input type="radio" name="is_active" value="1" checked/>是
					<input type="radio" name="is_active" value="0" />否
			</li>
			<li>
				<input value="Save " class="button" type="submit">
			</li>
		</ul>
	</form>
	</div>
</div>
