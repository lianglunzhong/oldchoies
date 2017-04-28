<?php echo View::factory('/admin/ticket/ticket_left')->render(); ?>
<script type="text/javascript">
var data=<?php echo $data;?>;
$(document).ready(
	function()
	{
		$('#line').change(function(){
			$('#all').removeAttr("checked");
			$("[name='code[]']").each(function() {
				   $(this).attr("checked", false);
				  });			  
			$("#site").load("/admin/ticket/ticket/get_site/"+$("#line").val()+"?q=all");
			if($('#line').val()=="all")
			{
				$('#site').attr("disabled","disabled");
				$('#all').attr("disabled","disabled");
				$("[name='code[]']").each(function() {
				   $(this).attr("disabled","disabled");
				  });	
			}
			else
				$('#site').removeAttr("disabled");
			  });		  
		$('#site').change(function(){
			$('#all').removeAttr("checked");			
			$("[name='code[]']").each(function() {
				   $(this).attr("checked", false);
				  });
			if($('#site').val()=="all")
			{
				$('#all').attr("disabled","disabled");
				$("[name='code[]']").each(function() {
					   $(this).attr("disabled","disabled");
					  });	
			}
			else
			{
				$('#all').removeAttr("disabled");
				$("[name='code[]']").each(function() {
					   $(this).removeAttr("disabled");
					  });					
			}
			has_privilege();
			  });
		$('#all').click(function(){
			if($(this).attr("checked")==true)
				$("[name='code[]']").each(function() {
					   $(this).attr("checked",true);
					  });
			else
				$("[name='code[]']").each(function() {
					   $(this).removeAttr("checked");
					  });				
			});
		$("[name='code[]']").click(function(){
			$('#all').attr("checked",true);
			$("[name='code[]']").each(function() {
				   if($(this).attr("checked")!=true)
					   $('#all').removeAttr("checked");
				  });
			});
	}
);

function has_privilege()
{
	$("[name='code[]']").each(function(){
		code=$('#line').val()+'-'+$('#site').val()+'-'+$(this).val().split('-')[2];
		$(this).val(code);
		if($.inArray(code,data)!=-1)
			$(this).attr("checked", true);
		});
}

</script>
<div id="do_right">
<h3>Set Privilege For User <?php echo $nickname.'('.$user_id.')';?></h3>
<form action="/admin/ticket/manager/privilege/<?php echo $user_id;?>" method="post" id="form">
<label>Line:</label>
<select id="line" name="line">
	<option value="all">Select All</option>
	<?php foreach ($lines as $line){?>
	<option value="<?php echo $line['id']; ?>"><?php echo $line['name'];?></option>
	<?php }?>
</select>
<label>Site:</label>
<select id="site" name="site" disabled >
</select>
<input type="checkbox" id="all" disabled/><label>Select All</label>
<br/><br/>
<label>Topic:</label><br/><br/>
<?php foreach ($topics as $topic){?>
<input type="checkbox" name="code[]" value="{line}-{site}-<?php echo $topic['id'];?>" disabled/><label><?php echo $topic['topic'];?></label><br/><br/>
<?php }?>
<input type="submit" value="submit" id="submit" />
</form>

</div>