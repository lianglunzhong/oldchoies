<?php echo View::factory('admin/sys/sys_left')->render(); ?>
<div id="do_right">
<div class="box">
<h3><span class="moreActions"><a href="#" id="do_add_attribute">新增产品线</a></span>产品线列表</h3>
<table id="do_property_table">
<thead>
<tr>
<th scope="col">No</th>
<th scope="col">Name</th>
<th scope="col">Brief</th>
<th scope="col">Action</th>
</tr>
</thead>
<tbody>
<form method="post" action="/sys/line/deleteall">
<?php
foreach($data as $value)
{
?>
<tr class="odd">
<td><?php echo $value->id;?></td>
<td><?php echo $value->id;?></td>
<td><?php echo $value->name;?></td>
<td><a href="/sys/task/edit/<?php echo $value->id;?>">edit</a> | <a href="/sys/line/delete/<?php echo $value->id;?>" onclick="return confirm('确定删除？')" >删除</a></td>
</tr>
<?php
}
?>
</form>
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
<div id="dialog-form" title="添加产品线">
<form action="/sys/line/add" method="post" name="form1" id="form1">
<table border="1" cellpadding="0" cellspacing="0" width="280" style="margin:auto;">
<tr>
<td class="tdLabel"><label>名称:</label></td>
<td class="tdInput"><input type="text" id="name" name="name" />
</tr>
<tr>
<td class="tdLabel"><label>简介:</label></td>
<td class="tdInput"><textarea id="brief" name="brief" ></textarea>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" value="新 增"></td>
</tr>
</table>
</form>
</div>

