<?php echo View::factory('admin/sys/sys_left')->render(); ?>
<div id="do_right">
<div class="box">
<h3>
<span class="moreActions">
<a href="/admin/sys/role/add" >Add Role</a>
</span>
Add New Role
</h3>

<form action=" " method="post">
<ul>
<li>
<label>Name：<span class="req">*</span></label>
<div>
<input class="text short" id="name" name="name" value="" type="text" />
<div class="errorInfo"></div>
</div>
</li>

<li>
<label>Brief：<span class="req">*</span></label>
<div>
<input class="text long" id="brief" name="brief" value="" type="text" />
<div class="errorInfo"></div>
</div>
</li>

<li>
<label>Parent：<span class="req">*</span></label>
<div>

<select name="parent_id">
<option value="0">root</option>
<?php 
$roles = ORM::factory('role')->find_all();
foreach($roles as $role)
{
?>
<option value="<?php echo $role->id;?>"><?php echo $role->name;?></option>
<?php 
}
?>
</select>

</div>
</li>

<li>
<div><input type="submit" value="submit"/></div>
</li>    
</ul>

</form>
</div>
</div>

