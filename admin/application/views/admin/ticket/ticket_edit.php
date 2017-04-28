<?php echo View::factory('admin/ticket/ticket_left')->render(); ?>
<div id="do_right">
    <div class="box">
        <form action="/admin/ticket/ticket/edit/" method="post" name="form1" id="form1">
            <ul>
				<li ><h3>Eidt Ticket</h3></li>
				<li ><label>Ticket #:<?php echo $ticket['ticketID']; ?></label></li>
					<li>
						<label>Topic:</label>
						<div>
							<select name='topic_id'>
								<?php 
									foreach ($topics as $topic)
									{
								?>
								<option value="<?php echo $topic['id'];?>" <?php if($topic['id']==$ticket['topic_id']) echo 'selected'; ?>><?php echo $topic['topic'];?></option>
								<?php 
									}
								?>
							</select>						
						</div>
					</li>
					<li>
						<label>Assign To User_id:</label>
						<div><input type="text" id="user_id" name="user_id" value="<?php echo $ticket['user_id'] ?>"></div>
					</li>
					<li>
						<label>Priority:</label>
						<div>
							<select name='priority_id'>
								<?php 
									foreach ($priority as $key=>$value)
									{
								?>
								<option value="<?php echo $key;?>" <?php if($key==$ticket['priority_id']) echo 'selected'; ?>><?php echo $value['status'];?></option>
								<?php 
									}
								?>
							</select>		
						</div>
					</li>
					<li>
						<label>Status:</label>
						<div>
							<select name='status'>
								<?php 
									foreach ($status as $value)
									{
								?>
								<option value="<?php echo $value;?>" <?php if($value==$ticket['status']) echo 'selected'; ?>><?php echo $value;?></option>
								<?php 
									}
								?>
							</select>		
						</div>
					</li>
					<li>
						<label>Set Top:</label>
						<div><input type="checkbox" name='istop' <?php if($ticket['istop']==1) echo "checked";?>/></div>
					</li>					
					<li>
					<input type="hidden" value="<?php echo $ticket['ticketID']; ?>" name="ticketID" />
					<div><input type="submit" value="Save"></div>
					</li>
			</ul>
        </form>
    </div>
</div>

