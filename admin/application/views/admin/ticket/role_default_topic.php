<?php 
@ini_set( "memory_limit" , "128M" );
echo View::factory('/admin/ticket/ticket_left')->render(); ?>
<script type="text/javascript">
var data=<?php echo json_encode($default);?>;
$(document).ready(
		function()
		{
			$('#line').change(function(){
				$('#site option:first').attr("selected",true);
				val=$(this).val();
				$("#table").find('tr').each(function(){
					if($.inArray($(this).find('input').val(),data)==-1)
					{
						$(this).find('input').attr("checked",false);
						if($(this).find('td').eq(0).html()==val||val=='all')
						{
							$(this).find('input').attr("checked",true);
						}
					}
				});
			});
			
			$('#site').change(function(){
				val=$(this).val();
				$("#table").find('tr').each(function(){
					if($("#line").val()!="all"&&$.inArray($(this).find('input').val(),data)==-1&&$(this).find('td').eq(0).html()!=$("#line").val())
					{
						$(this).find('input').attr("checked",false);
						if($(this).find('td').eq(1).html()==val)
						{
							$(this).find('input').attr("checked",true);
						}
					}
				});
			});
			$('#reset').click(function(){
				$("#table").find('tr').each(function(){
					if($.inArray($(this).find('input').val(),data)!=-1)
						$(this).find('input').attr("checked",true);
					else
						$(this).find('input').attr("checked",false);
					})
				});			
		});
</script>
<div id="do_right">
    <div class="box">
    <form action="/admin/ticket/role/default_topic/<?php echo $user_id;?>" method="post">
		<h3>Set Default Topic For User <?php echo $nickname.'('.$user_id.')';?></h3>
		<label>Line:</label>
		<select id="line">
			<option value="">Select a Line</option>
			<option value="all">Select All</option>
			<?php 
				$choosed=array();
				foreach ($privilege as $code){
					$thisline=explode('-',$code);
					$thisline=$thisline[0];
					if(!in_array($thisline,$choosed)){
			?>
			<option value="<?php echo $lines[$thisline]; ?>"><?php echo $lines[$thisline];?></option>
		<?php 		}
					$choosed[]=$thisline;
				}?>
		</select>
		<label>Site:</label>
		<select id="site">
			<option value="">----</option>
			<?php 
			$choosed=array();
			foreach ($privilege as $code){
				$thissite=explode('-',$code);
				$thissite=$thissite[1];
				if(!in_array($thissite,$choosed)){?>
			<option value="<?php echo $sites[$thissite]; ?>"><?php echo $sites[$thissite];?></option>
			<?php }
				$choosed[]=$thissite;
				}?>
		</select>
		<input type="button" value="reset" id="reset" />
		<input type="submit" value="Submit" name="submit">
		<table id="table">
 		<thead>
        	<tr>
            	<th scope="col">Line</th>
           		<th scope="col">Site</th>
           		<th scope="col">Topic</th>
           		<th scope="col">Assign</th>
           	</tr>
        </thead>
        <tbody>
		<?php foreach ($privilege as $code){
				$info=explode('-',$code);		
		?>
		<tr class="odd">
			<td><?php echo $lines[$info[0]];?></td>
			<td><?php echo $sites[$info[1]];?></td>
			<td><?php echo $topics[$info[2]];?></td>
			<td><input type="checkbox" value="<?php echo $code;?>" name="code[]" <?php if(in_array($code, $default)) echo 'checked';?>/></td>
		</tr>
		<?php }?>
		</tbody>
		</table>
	</form>
	</div>
</div>