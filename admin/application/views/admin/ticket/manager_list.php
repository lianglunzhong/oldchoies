<?php echo View::factory('/admin/ticket/ticket_left')->render(); ?>
<div id="do_right">
    <div class="box">
	<table>
 		<thead>
        	<tr>
            	<th scope="col" width=20%>Manager</th>
           		<th scope="col">Subordinate</th>
           	</tr>
        </thead>
        <tbody>
        <?php if(Session::instance()->get('ticket_role')=="Admin"){//view for admin
        	  	foreach($managers as $manager){?>
        	<tr class="odd">
        	<td><a href="/admin/ticket/manager/privilege/<?php echo $manager->user_id; ?>"><?php echo $manager->nickname.'  User ID:'.$manager->user_id;?></a></td>
        	<td>
        	<?php $subordinates=Ticket::instance()->get_subordinate_by_managerID($manager->user_id);
        			foreach ($subordinates as $subordinate) {
        	?>
        		<a href="/admin/ticket/role/default_topic/<?php echo $subordinate->user_id;?>"><?php echo $subordinate->nickname.'  User ID:'.$subordinate->user_id.' ';?></a>
        		|
        	<?php
        			}
        	?>
        	</td>
        	</tr>
        <?php }
        	  	}else{
        	  		foreach($managers as $manager)
        	  		{
        	  			if($manager->user_id==Session::instance()->get('user_id')){
        	  ?>
        	  <tr>
	        	  <td class="odd"><?php echo $manager->nickname.'  User ID:'.$manager->user_id;?></td>
	        	  <td>
	        	  <?php $subordinates=Ticket::instance()->get_subordinate_by_managerID($manager->user_id);
	        	  		foreach ($subordinates as $subordinate) {
	        	  ?>
	        	 <a href="/admin/ticket/role/default_topic/<?php echo $subordinate->user_id;?>"><?php echo $subordinate->nickname.'  User ID:'.$subordinate->user_id.' ';?></a>
        		|
        		<?php 	
	        	     }?>
	        	  </td>
        	  </tr>
        	  <?php 
        	  			}
        	  		}
        	  	 }?>
        </tbody>
	</table>
	</div>
</div>