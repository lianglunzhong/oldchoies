<?php
echo View::factory('admin/sys/sys_left')->render();
?>
<div id="do_right">
<div class="box">
<h3>Add role</h3>
<table id="do_property_table">
<form method="post" action="/admin/sys/task/addrolle">
<tbody>
<tr class="odd">
<td>
<select name="role_id">
<?php foreach($role as $role_data):?>
<option value="<?php echo $role_data->id;?>"><?php echo $role_data->name;?></option>
<?php endforeach;?>
</select>
</td>
</tr>
<?php foreach($field_key as $key => $data):?>
<tr class="odd">
<?php foreach($data as $k => $rs):?>
<td><?php echo $key.'.'.$rs.' : ';?></td>
<?php foreach($task_key as $action => $obj):?>
<td>
<input type="checkbox" checked="" name="<?php echo $action;?>[]" value="<?php echo  $key.'.'.$rs;?>">
<?php echo $action.'.'.$rs;?>
</td>
<?php endforeach;?>
</tr>
<?php
endforeach;
endforeach;
?>
<tr>
<input type="submit" value="Save" name="submit">
</tr>
</tbody>
</form>
</table>
</div>
</div>

