<?php echo View::factory('admin/site/basic_left')->render(); ?>

<div id="do_right">
<div class="box">
<h3>Product Set</h3>
<table>
<thead>
<tr>
<th scope="col" style="width:20px;"><input type="checkbox" id="checkall" name="checkall" value="" /></th>
<th scope="col" style="width:20px;">No</th>
<th scope="col">Name</th>
<th scope="col">Brief</th>
<th scope="col">Action</th>
</tr>
</thead>
<tbody>

<?php
foreach($data as $item)
{
?>
<tr>
<td><input type="checkbox" id="checkall" name="checkall" value="" /></td>
<td><?php echo $item->id; ?></td>
<td><?php echo $item->name; ?></td>
<td><?php echo $item->brief; ?></td>
<td>
<a href="/admin/site/set/edit/<?php echo $item->id; ?>">Edit</a> | 
<a class="delete_set" href="/admin/site/set/delete/<?php echo $item->id; ?>">Delete</a>
<a href="/admin/site/set/export/<?php echo $item->id; ?>" target="_black">Export</a>
</td>
</tr>
<?php
}
?>

</tbody>
</table>

</div>
</div>
<script type="text/javascript">
$(function(){
    $('.delete_set').click(function(){
        if(!confirm('Are you sure to delete this Product Set?'))
        {
            return false;
        }
    });
});
</script>
