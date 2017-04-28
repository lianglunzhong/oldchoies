<?php echo View::factory('admin/site/order/left')->render();?>
<div id="do_right">
<?php
$pay_statuses = array('All');
$ship_statuses = array('All');
$issue_statuses = array('All');
$refund_statuses = array('All');
$return_statuses = array('All');
$statuses = Order::instance()->get_orderstatus();
foreach($statuses as $c){
    switch($c['type'])
    {
        case 1:
            $pay_statuses[$c['id']] = $c['name'];
            break;
        case 2:
            $ship_statuses[$c['id']] = $c['name'];
            break;
        case 3:
            $issue_statuses[$c['id']] = $c['name'];
            break;
        case 4:
            $refund_statuses[$c['id']] = $c['name'];
            break;
        case 5:
            $return_statuses[$c['id']] = $c['name'];
            break;
        default:
            break;
    }
}
?>
<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/admin/site/shipment/data',
            datatype: "json",
			height: 460,
			width: 900,
			colNames:['ID','Order ID', 'Order Number', 'Tracking link', 'Tracking code', 'Ship Date', 'Created On', 'Action'],
			colModel:[
				{name:'id',index:'id'},
				{name:'order_id',index:'order_id'},
				{name:'ordernum',index:'ordernum'},
				{name:'tracking_link',index:'tracking_link'},
				{name:'tracking_code',index:'tracking_code'},
				{name:'ship_date',index:'ship_date',search:true,stype:'text',searchoptions:{dataInit:datePick}},
				{name:'created',index:'created'},
				{search:false,formatter:actionFormatter}
			],
            rowNum:20,
            rowList : [20,30,50],
            mtype: "POST",
            gridview: true,
            pager: '#ptoolbar',
            sortname: 'id',
            viewrecords: true,
            sortorder: "desc",
            recordtext: "View {0} - {1} of {2}",
	        emptyrecords: "No records to view",
			loadtext: "Loading...",
			pgtext : "Page {0} of {1}"
		});

		jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
		jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
	});
	datePick = function(elem)
	{
		$(elem).datepicker({dateFormat:'yy-mm-dd'});
	}
	function actionFormatter(cellvalue,options,rowObject) {
		return '<a href="/admin/site/shipment/edit/' + rowObject[0] + '">Edit</a>';
	}
</script>
<div id="do_content">
    <div class="box" style="overflow:hidden;">
        <h3>Order Shipment List</h3>
		<table id="toolbar"></table>
		<div id="ptoolbar"></div>
    </div>
</div>
</div>
