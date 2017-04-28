<script type="text/javascript" src="/media/js/my_validation.js"></script>
<?php echo View::factory('admin/site/catalog_left')->render(); ?>
<div id="do_right">
	<div class="box">
		<h3>Brands List</h3>
		<fieldset>
	        <legend style="font-weight:bold">Add Brands</legend>
	        <div>
	        	<form action="#" method="post" class="need_validation" id="fee_add">
                    <label for="name">Brands Name: </label>
                    <input type="text" class="text small required" id="name" name="name">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="brief">Brands Brief: </label>
                    <textarea id="brief" name="brief" cols="30" rows="4"></textarea>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" style="padding:0 .5em" class="ui-button" value="Add">
                </form>
	        </div>
		</fieldset>
        <fieldset>
            <legend style="font-weight:bold">批量Add Brands</legend>
            <div>
                <form action="/admin/site/catalog/brandcsv" method="post" class="need_validation">
                <textarea name="file" cols="30" rows="30"></textarea>
                    <input type="submit" value="上传" name="submit">
                </form>
            </div>
        </fieldset>
		<table>
			<thead>
				<tr>
					<th scope="col" style="width:20px;">No</th>
					<th scope="col">Name</th>
					<th scope="col">label</th>
					<th scope="col">Brief</th>
					<th scope="col">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($brands as $data)
			{
			?>
				<tr>
				<td><?php echo $data['id']; ?></td>
				<td><?php echo $data['name']; ?></td>
				<td><?php echo $data['label']; ?></td>
				<td><?php echo $data['brief']; ?></td>
				<td>
				<a href="javascript:;" onclick="brand_edit_click(<?php echo $data['id']; ?>, '<?php echo $data['name']; ?>', '<?php echo $data['brief']; ?>');">Edit</a> | 
				<a class="delete_set" href="/admin/site/catalog/brand_delete/<?php echo $data['id']; ?>">Delete</a>
				</td>
				</tr>
			<?php
			}
			?>
			</tbody>
		</table>

	</div>
</div>

<div id="celebrity_view" class="" style="padding-bottom: 50px; padding-right: 50px; width: 400px; height: 180px; top: -30px; left: 360px;display:none;">
    <div id="cboxWrapper" style="height: 450px; width: 744px;"><div>
    <div id="cboxTopLeft" style="float: left;"></div>
    <div id="cboxTopCenter" style="float: left; width: 400px;"></div>
    <div id="cboxTopRight" style="float: left;"></div></div>
        <div style="clear: left;">
        	<div id="cboxMiddleLeft" style="float: left; height: 180px;"></div>
            <div id="cboxContent" style="float: left; width: 400px; height: 180px;">
                    <form action="/admin/site/catalog/brands_edit" method="post" onsubmit="return brand_edit_submit();">
                        <input type="hidden" name="brand_id" id="brand_id" value="0" />
                        <label style="width: 100px;display: inline-block;">Brand name:</label>&nbsp;
                        <input type="text" name="brand_name" id="brand_name" />
                        <br><br>
                        <label style="width: 100px;display: inline-block;">Brand brief:</label>&nbsp;
                        <textarea id="brand_brief" name="brand_brief" cols="30" rows="5"></textarea>
                        <br><br>
                        <div style="width:80px;float:right;"><input type="submit" value="submit" /></div>
                    </form>
                    <div class="closebtn" class="" style="right: 25px;top: 190px;">close</div>
            </div>
            <div id="cboxMiddleRight" style="float: left; height: 180px;"></div>
        </div>
        <div style="clear: left;">
            <div id="cboxBottomLeft" style="float: left;"></div>
            <div id="cboxBottomCenter" style="float: left; width: 400px;"></div>
            <div id="cboxBottomRight" style="float: left;"></div>  
        </div>
    </div>
    <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
</div>

<script type="text/javascript">
function brand_edit_submit()
{

}

function brand_edit_click(id, name, brief)
{
	$('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
    $('#celebrity_view').appendTo('body').fadeIn(320);
    $('#brand_id').val(id);
    $('#brand_name').val(name);
    $('#brand_brief').val(brief);
    $('#celebrity_view').show();
}
$(function(){
	$("#celebrity_view .closebtn,#wingray").live("click",function(){
        $("#wingray").remove();
        $('#celebrity_view').fadeOut(160).appendTo('#tab2');
        return false;
    })

    $('.delete_set').click(function(){
        if(!confirm('Are you sure to delete this Brand?'))
        {
            return false;
        }
    });
});
</script>
