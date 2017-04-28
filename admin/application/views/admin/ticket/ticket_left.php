<div id="do_left">
	<div class="title">
		<h2><?php echo Session::instance()->get('ticket_role');?></h2>
	</div>
	<div class="navigation">	
		<ul>
			<li>Tickets Manage
				<ul>
					<li><a href="/admin/ticket/ticket/list?user_id=<?php echo Session::instance()->get('user_id')?>&&status=pending">My Pending[<?php echo Ticket::instance()->get_ticket_number(array('user_id='.Session::instance()->get('user_id'),'(status=\'New\' OR status=\'Overdue\')','is_active=1'))?>]</a></li>
					<li><a href="/admin/ticket/ticket/list?user_id=<?php echo Session::instance()->get('user_id')?>">My Tickets</a></li>
					<?php if(Session::instance()->get('ticket_role')!="User"){?>
					<li><a href="/admin/ticket/ticket/list">All Tickets[<?php echo Ticket::instance()->get_ticket_number(array('(status=\'New\' OR status=\'Overdue\')','is_active=1'))?>]</a></li>
					<?php }?>
					<?php
					if(Session::instance()->get('ticket_role')=="Manager")
					{
					?>
					<?php
						$subordinates=Ticket::instance()->get_subordinate_by_managerID(Session::instance()->get('user_id'));	
						foreach ($subordinates as $sub){
							if($sub->user_id!=Session::instance()->get('user_id'))
							{
					?>
					<li><a href="/admin/ticket/ticket/list?user_id=<?php echo $sub->user_id;?>"><?php echo $sub->nickname;?>[<?php echo Ticket::instance()->get_ticket_number(array('user_id='.$sub->user_id,'(status=\'New\' OR status=\'Overdue\')','is_active=1'))?>]</a></li>
					<?php 
							}
						}
					}?>
					<li><a href="/admin/ticket/ticket/new">Open a New Ticket</a></li>
					<li><a href="/admin/ticket/ticket/bulk_upload">Bulk Upload</a></li>
					<li><a href="/admin/ticket/ticket/list?is_active=0<?php if(Session::instance()->get('ticket_role')=="User") echo "&&user_id=".Session::instance()->get('user_id')?>">Deleted Tickets</a></li>
				</ul>
			</li>
			<?php if(Session::instance()->get("ticket_role")!="User"){?>
			<li>Dashboard
				<ul>
					<li><a href="/admin/ticket/role/list">Users</a></li>
				<?php if(Session::instance()->get('ticket_role')!="User"){?>
					<li><a href="/admin/ticket/manager/list">Privilege Control</a></li>
				<?php }?>
				</ul>
				<ul>
					<li><a href="/admin/ticket/template/list">Template</a></li>
				</ul>
				<ul>
					<li><a href="/admin/ticket/topic/list">Topic</a></li>
				</ul>
				<ul>
					<li><a href="/admin/ticket/site/list">Site</a></li>
				</ul>
				<?php if(Session::instance()->get("ticket_role")=="Admin"):?>
				<ul>
					<li><a href="/admin/ticket/blacklist/list">Mail BlackList</a></li>
				</ul>
				<?php endif;?>
			</li>
			<?php }?>
			<li>Statistics
				<ul>
					<li><a href="/admin/ticket/statistics/general">General</a></li>
				</ul>
			</li>	
		</ul>
	</div>
</div>
