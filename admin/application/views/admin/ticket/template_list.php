<?php echo View::factory('admin/ticket/ticket_left')->render(); ?>
<div id="do_right">
<div class="box">
<h3><span class="moreActions"><a href="/admin/ticket/template/add">Add Template</a></span>Template List</h3>
<table id="do_property_table">
<thead>
<tr>
<th scope="col">No</th>
<th scope="col">Title</th>
<th scope="col">Topic</th>
<th scope="col">Content</th>
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
<td><?php echo $value->tpl_name;?></td>
<td><?php echo $topic[$value->topic_id];?></td>
<td><?php echo $value->tpl_content;?></td>
<td><?php echo $value->is_active == 1 ? 'Yes' : 'No';?></td>
<td><a href="/admin/ticket/template/edit/<?php echo $value->id;?>">Edit</a> | <a href="/admin/ticket/template/delete/<?php echo $value->id;?>" onclick="return confirm('sure?')" >Delete</a></td>
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