<?php echo View::factory('/admin/ticket/ticket_left')->render(); ?>
<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<div id="do_right">
		<?php
		//prepare data for filters
		$topices_status=array('All');
		$site_status=array('All');
		$line_status=array('All');
		$status=array('All');
		$priority_status=array();
		$priority_status['all']=array('All');
		$country_status['all']=array('All');
		$user_status['all']=array('All');
		$classification_status['all']=array('All');
		$priority_color=array();
		$ticketinfo=Ticket::instance();
		$topices=$ticketinfo->get_ticket_topic('',false);
		foreach ($topices as $value) 
			$topices_status[$value['id']]=$value['topic'];
		$append_sql="";
		if(!empty($_GET))
		{
			$append_sql=' AND ';
			foreach ($_GET as $key=>$value)
			{
				if($key=="status"&&$value=="pending")
				{
					$append_sql.="(status='New' OR status='Overdue') AND ";
				}
				elseif($key=="user_id")
				{
					$append_sql.=("user_id=".$value." AND ");
				}
				else
					$append_sql.=($key.'=\''.$value.'\' AND ');
			}
			$append_sql.= 1;
		}
		$active=isset($_GET['is_active'])?'':' AND is_active=1 ';
		$tickets=DB::query(Database::SELECT, "select line_id,site_id from tickets where 1".$append_sql.$active)
					->execute()
					->as_array();
		$line_ids=array();
		$site_ids=array();
		foreach($tickets as $ticket)
		{
			$line_ids[]=$ticket['line_id'];
			$site_ids[]=$ticket['site_id'];
		}
		$lines=$ticketinfo->get_ticket_line_name();
		foreach ($lines as $value)
		{
			if(in_array($value['id'], $line_ids))
				$line_status[$value['id']]=$value['name'];
		}
		$line_status["-100"]="avoid bug";//防止json_encode处理连续ID错误
		$sites=$ticketinfo->get_ticket_site_name();
		foreach ($sites as $value)
		{ 
			if(in_array($value['id'], $site_ids))
				$site_status[$value['id']]=$value['domain'];
		}
		$site_status["-100"]="avoid bug";
		$bindsite=str_replace(array( '"', '{', '}', ',','0:All',';-100:avoid bug'), array( '', '', '', ';',':All',''), json_encode($site_status));
		$bindline=str_replace(array( '"', '{', '}', ',','0:All',';-100:avoid bug'), array( '', '', '', ';',':All',''), json_encode($line_status));
		$statusinfo=$ticketinfo->get_ticket_status();
		if($statusinfo!=1)
		{
			foreach ($statusinfo as $value)
				$status[$value['status']]=$value['status'];
		}
		foreach (Kohana::config('ticket.classification') as $classification)
			$classification_status[$classification]=$classification;
		$priority=Kohana::config('ticket.priority');
		foreach ($priority as $value)
		{
			$priority_status[]=$value['status'];
			$priority_color[$value['status']]=$value['bgcolor'];
		}
		$countries=DB::query(Database::SELECT, 'SELECT DISTINCT country FROM tickets')
							->execute()
							->as_array();
		foreach ($countries as $value)
		{
			$country_status[$value['country']]=$value['country'];
		}
		$users=DB::query(Database::SELECT, 'SELECT DISTINCT nickname FROM ticket_users')
							->execute()
							->as_array();
		foreach ($users as $value)
		{
			$user_status[$value['nickname']]=$value['nickname'];
		}
		$user_status['Not Assign']='Not Assign';
		?>
		<script type="text/javascript">
	<?php 
			echo 'priority_colors = '.json_encode($priority_color).';'; 
	?>
			$(function(){
				jQuery("#toolbar").jqGrid({
					url:'/admin/ticket/ticket/data?<?php echo $_SERVER['QUERY_STRING']; ?>',
					datatype: "json",
					height: 460,
					autowidth: true,
					colNames:['User','Line','Site','Ticket #','Email','Topic','Subject','Classification','Priority','Status','Updated','Note','Top'],
					colModel:[
						{name:'user_id',index:'user_id',width:100,stype:'select',searchoptions:{value:<?php echo "'".str_replace(array( '"', '{', '}', ',','[',']', 'all:All' ), array( '', '', '', ';','','' , ':All'), json_encode($user_status))."'"; ?>}},
						{name:'line_id',index:'line_id',width:50,stype:'select',searchoptions:{value:<?php echo "'".$bindline."'"; ?>}},
						{name:'site_id',index:'site_id',width:100,stype:'select',searchoptions:{value:<?php echo "'".$bindsite."'"; ?>}},
						{name:'ticketID',index:'ticketID',formatter:actionFormatter},
						{name:'email',index:'email'},
						{name:'topic_id',index:'topic_id',stype:'select',searchoptions:{value:<?php echo "'".str_replace(array( '"', '{', '}', ',','0:All'), array( '', '', '', ';',':All'), json_encode($topices_status))."'"; ?>}},
						{name:'subject',index:'subject',formatter:actionFormatter},
						//{name:'country',index:'country',width:80,stype:'select',searchoptions:{value:<?php echo "'".str_replace(array( '"', '{', '}', ',','[',']', 'all:All'), array( '', '', '', ';','','' , ':All'), json_encode($country_status))."'"; ?>}},
						{name:'classification',index:'classification',stype:'select',searchoptions:{value:<?php echo "'".str_replace(array( '"', '{', '}', ',','[',']', 'all:All'), array( '', '', '', ';','','' , ':All'), json_encode($classification_status))."'"; ?>}},
						{name:'priority_id',index:'priority_id',width:80,stype:'select',searchoptions:{value:<?php echo "'".str_replace(array( '"', '{', '}', ',','[',']', 'all:All' ), array( '', '', '', ';','','' , ':All'), json_encode($priority_status))."'"; ?>}},
						{name:'status',index:'status',width:80,stype:'select',searchoptions:{value:<?php echo "'".str_replace(array( '"', '{', '}', ',','[',']', '0:All' ), array( '', '', '', ';','','' , ':All'), json_encode($status))."'"; ?>}},
						{name:'updated',index:'updated'},
						{name:'note',index:'note'},
						{name:'istop',index:'istop',hidden:true}
					],
					rowNum:50,
					rowList : [20,30,50],
					mtype: "POST",
					gridview: true,
					pager: '#ptoolbar',
					sortname: 'created',
					viewrecords: true,
					sortorder: "desc",
					recordtext: "View {0} - {1} of {2}",
					emptyrecords: "No records to view",
					loadtext: "Loading...",
					pgtext : "Page {0} of {1}",
					gridComplete: function () {
					$('#gbox_toolbar').css("margin-top","50px");
					$("#toolbar").find('tr').each(function(){
						var priority=$(this).find("td").eq(8);
						if (priority_colors[priority.html()])
						{
							color = priority_colors[priority.html()];
							priority.css('background-image', 'none');
							priority.css('background-color', color);
						}
						var istop=$(this).find("td").eq(12);
						if(istop.html()==1)
						{
							$(this).css('background-image', 'none' );
							$(this).css('background-color', '#FD3E03');
						}
					})
					}
				});
	
				jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,multipleSearch:true});
				jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
					
				$('#gs_updated').daterangepicker({
					dateFormat:'yy-mm-dd',
					rangeSplitter:' to ',
					onRangeComplete:(function(){
						var last_date = '',$input = $('#gs_created');
						return function(){
							if(last_date != $input.val()) {
								$('#toolbar')[0].triggerToolbar();
								last_date = $input.val();
							}
						};
					})()
				});
			});
			function actionFormatter(cellvalue,options,rowObject) {
				return '<a href="/admin/ticket/ticket/detail/' + rowObject[3] + '" ordernum="' + rowObject[3] + '" target="_blank">'+cellvalue+'</a>';
			}
		</script>
		<div id="do_content">
			<div class="box" style="overflow:hidden;">
				<div class="tk_status">
					<div class="tk_search">
					<form action="/admin/ticket/ticket/search?<?php echo $_SERVER['QUERY_STRING']; ?>" method="post">
						<label>Search Content:</label>
						<input type="text" name="search" />
						<input type="submit" value="Search" />
					</form>
					</div>
				</div>
				<table id="toolbar"></table>
				<div id="ptoolbar"></div>
			</div>
			<div>
				<form action="/admin/ticket/ticket/set_overdue" method="post" >
					<input name="url" type="hidden" value="<?php echo $_SERVER["REQUEST_URI"];?>"/>
					<input name="overdue" type="submit" value="Set Overdue"/>
				</form>
			</div>
				
		</div>
	</div>
</div>
