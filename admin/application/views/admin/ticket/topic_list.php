<?php echo View::factory('admin/ticket/ticket_left')->render(); ?>
<div id="do_right">
<div class="box">
<h3><span class="moreActions"><a href="#" id="do_add_attribute">新增topic</a></span>topic列表</h3>
<table id="do_property_table">
<thead>
<tr>
<th scope="col">No</th>
<th scope="col">Topic</th>
<th scope="col">Brief</th>
<th scope="col">Priority</th>
<th scope="col">Used For</th>
<th scope="col">Active</th>
<th scope="col">Action</th>
</tr>
</thead>
<tbody>
<?php
foreach($data as $value)
{
?>
<tr class="odd">
<td><?php echo $value->id;?></td>
<td><?php echo $value->topic;?></td>
<td><?php echo $value->brief;?></td>
<td><?php echo $priority_list[$value->priority_id]['status'];?></td>
<td><?php echo $value->for_customer == 1 ? '客服' : '客户';?></td>
<td><?php echo $value->is_active == 1 ? 'Yes' : 'No';?></td>
<td><a href="/admin/ticket/topic/edit/<?php echo $value->id;?>">修改</a></td>
</tr>
<?php
}
?>
</tbody>
</table>

<div class="pagination">
<ul>
<?php echo $page_view; ?>
</ul>
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    //        $('#do_add_attribute').button();

    $('#do_add_attribute').click(function(){
        $('#dialog-form').dialog('open');
        return false;
    });

});
</script>

<!-- attribute add box -->
<script type="text/javascript">
$(document).ready(function(){
    $('#dialog-form').dialog({ autoOpen: false });
});
</script>
<div id="dialog-form" title="添加Topic">
<form action="/admin/ticket/topic/add" method="post" name="form1" id="form1">
	<table border="1" cellpadding="0" cellspacing="0" width="280" style="margin:auto;">
		<tr>
			<td class="tdLabel"><label>名称:</label></td>
			<td class="tdInput"><input type="text" id="topic" name="topic" />
		</tr>
		<tr>
			<td class="tdLabel"><label>简介:</label></td>
			<td class="tdInput"><textarea id="brief" name="brief"></textarea>
		</tr>
		<tr>
			<td class="tdLabel"><label>优先级:</label></td>
			<td class="tdInput">
			<select id="priority_id" name="priority_id">
			<?php foreach($priority_list as $key=>$priority):?>
			<option value="<?php echo $key;?>"><?php echo $priority['status']; ?></option>
			<?php endforeach;?>
			</select>
			</td>
		</tr>
		<tr>
			<td class="tdLabel"><label>激活:</label></td>
			<td class="tdInput">
			<input type="radio" name="is_active" value="1" checked/>是
			<input type="radio" name="is_active" value="0" />否
			</td>
		</tr>
		<tr>
			<td class="tdLabel"><label>用于:</label></td>
			<td class="tdInput">
			<input type="radio" name="for_customer" value="0" checked/>客户
			<input type="radio" name="for_customer" value="1" />客服
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" value="新 增"></td>
		</tr>
	</table>
</form>
</div>

