<?php echo View::factory('/admin/ticket/ticket_left')->render(); ?>
<div id="do_right">
	<div class="box">
	<h3>Edit Role</h3>
	<form action="/admin/ticket/role/edit/<?php echo $data->user_id;?>" method="post" name="form1" id="form1">
		<ul>
			<li>
				<label>User #：<?php echo $data->user_id;?></label>
			</li>
			<li>
				<label>Name：<?php echo $user_info->name;?></label>
			</li>
			<li>
				<label>Email：<?php echo $user_info->email?></label>
			</li>
			<li>
			<?php if(Session::instance()->get('ticket_role')=="Admin"&&$data->role!="Admin"){
			?>
				<label>Role：</label>
				<div><select id="role" name="role">
						<option value="Manager" <?php if($data->role=='Manager') echo 'selected'?>>Manager</option>
						<option value="User" <?php if($data->role=='User') echo 'selected'?>>User</option>
					</select>
				</div>
			<?php }
				  else echo '<label>Role：'.$data->role.'</label>'; 
			?>
			</li>
			<li>
				<label>Nick Name：</label>
				<div><input id="nickname" name="nickname" value="<?php echo $data->nickname;?>" /></div>
			</li>
			<?php if($data->role=='User'){?>
			<li>
				<label>Supervisor：</label>
				<div>
					<select id="supervisor_id" name="supervisor_id">
					<option value="0" selected >Select</option>
					<?php foreach($manager_list as $key=>$value):?>
					<option value="<?php echo $key;?>" <?php echo $data->supervisor_id == $key ? 'selected' : '' ?>><?php echo $value; ?>(<?php echo $key; ?>)</option>
					<?php endforeach;?>
			</select>
				</div>
			</li>
			<?php }?>
			<li>
				<label>Active：</label>
				<div>
					<input type="radio" name="is_active" value="1" <?php echo $data->is_active == 1 ? 'checked' : '' ?> />YES
					<input type="radio" name="is_active" value="0" <?php echo $data->is_active == 0 ? 'checked' : '' ?> />NO
				</div>
			</li>
			<?php if($data->role!='Admin'){?>
				<li><label>Replace：</label>
					<div><select name="replace" id="replace">
						<option value="">Select</option>
						<?php foreach($user_list as $user){?>
						<option value="<?php echo $user->user_id;?>" <?php if($user->user_id==$data->user_id) echo 'selected';?>><?php echo $user->nickname.'('.$user->user_id.')';?></option>
						<?php }?>
					</select>
					</div>
				</li>
			<?php }?>
			<li>
				<input value="Edit" name="edit" class="button" type="submit">
			</li>
		</ul>
	</form>
	</div>
</div>
