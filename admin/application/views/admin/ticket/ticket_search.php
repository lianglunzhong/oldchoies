<?php echo View::factory('/admin/ticket/ticket_left')->render(); ?>
<div id="do_right">
    <div class="box">
	<table>
 		<thead>
        	<tr>
            	<th scope="col">Ticket #</th>
           		<th scope="col">Subject</th>
           		<th scope="col">Message</th>
           		<th scope="col">Note</th>
           	</tr>
        </thead>
        <tbody>
        	<?php foreach($data as $value){?>
        	<tr class="odd">
        		<td width="15%"><a href="/admin/ticket/ticket/detail/<?php echo $value['ticketID'];?>"><?php echo $value['ticketID']?></a></td>
        		<td><?php echo $value['subject'];?></td>
        		<td><?php echo $value['message'];?></td>
        		<td><?php echo $value['note'];?></td>
        	</tr>
        	<?php }?>
        </tbody>
	</table>
	</div>
</div>