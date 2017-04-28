<?php echo View::factory('admin/ticket/ticket_left')->render(); 
$role=Session::instance()->get('ticket_role');
?>
<script type="text/javascript">
$('#delete').live('click',function(){
    var $this = $(this);
    if(!confirm('Delete this user?\nIt can not be undone!')){
        return false;
    }
});
</script>
<div id="do_right">
    <div class="box">
        <h3>Customer Specialist List</h3>
		<?php if($role!='user')
			  {
		?>
        <a href="/admin/ticket/ticket/add" id="do_add" >Add Specialist</a><br/><br/>
        <?php 
			  }
        ?>      
        <table>
            <thead>
                <tr>
                    <th scope="col">User #</th>
                    <th scope="col">Role</th>
                    <th scope="col">Name</th>
                    <th scope="col">Nick Name</th>
                    <th scope="col">Active</th>
                    <th scope="col">Supervisor</th>
                    <?php if ($role!='user') {?>
                    <th scope="col">Action</th>
                    <?php }?>
                </tr>
            </thead>
            <tbody>
<?php 
if(count($users) > 0)
{
    foreach($users as $user)
    {
?>
                <tr class="odd">
                    <td><?php echo $user->user_id; ?></td>
                    <td><?php echo $user->role;?></td>
                    <td><?php echo USER::instance($user->user_id)->get("name");?></td>
                    <td><?php echo $user->nickname;?></td>
                    <td><?php 
                    if ($user->is_active)
                        echo '<strong>Y<strong>' ;
                    else
                        echo '<strong>N</strong>';
                        ?>
                    </td>
                     <td><?php 
                     if($user->supervisor_id=='0') echo 'Not Assign Yet';
                     else
                     echo Ticket::instance()->get_nickname_by_userID($user->supervisor_id).'('.$user->supervisor_id.')';
                     ?></td>
                    <td>
                        <?php if (($role=='Manager'&&in_array($user->user_id, $sub_list))||$role=='Admin') {?>
                      	<a href="/admin/ticket/role/edit/<?php echo $user->user_id; ?>">Edit</a>
                        <?php }
                        ?>
                    </td>
                </tr>
<?php
    }
}
?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#do_add').click(function(){
        $('#dialog-form-add').dialog('open');
        return false;
    });
	$('#role').change(function(){
		if($('#role option:selected').text()!="User")
		$('#supervisor_id').attr("disabled","disabled");
	else
		$('#supervisor_id').removeAttr("disabled");
		});
	$('#form1').submit(function(){
		if($('#nickname').val()=='')
		{
			alert('Please type a nick name!');
			return false;
		}
	});
});
$(document).ready(function(){
    $('#dialog-form-add').dialog({ autoOpen: false });
});
</script>
<div id="dialog-form-add" title="Add Specialist">
<form action="/admin/ticket/role/add" method="post" name="form1" id="form1">
	<table border="1" cellpadding="0" cellspacing="0" width="250" style="margin:auto;">
		<tr>
			<td class="tdLabel"><label>Select User</label></td>
			<td class="tdInput">
			<select name="user_id">
			<?php foreach ($user_list as $user){?>
			<option value="<?php echo $user['id'];?>"><?php echo $user['name'].'('.$user['id'].')' ;?></option>
			<?php }?>
			</select></td>
		</tr>
		<tr>
			<td class="tdLabel"><label>Role:</label></td>
			<td class="tdInput"><?php if($role=='Admin'){?>
			<select name="role" id="role">
				<option value="User">User</option>
				<option value="Manager">Manager</option>
				<option value="Admin">Admin</option>
			</select>
			<?php }else {?>
			<input name="role" value="User" readOnly type="text"/>
			<?php } ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel"><label>Nick Name</label></td>
			<td class="tdInput">
			<input name="nickname" type="text" id="nickname"/>
			</td>
		</tr>
		<tr>
			<td class="tdLabel"><label>Supervisor</label></td>
			<td class="tdInput">
			<select name="supervisor_id" id="supervisor_id">
			<option value="">Select a Supervisor</option>
			<?php foreach ($managers as $key=>$value){?>
			<option value="<?php echo $key;?>" <?php if($key==Session::instance()->get('user_id')&&$role=='Manager') echo 'Selected'; ?>><?php echo $value.'('.$key.')' ;?></option>
			<?php }?>
			</select></td>
		</tr>
	</table>
	<input name="is_active" value="1" type="hidden" />
	<input name="submit" value="Submit"  type="submit"/>
</form>
</div>
