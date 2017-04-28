<?php echo View::factory('admin/site/order/left')->render();?>
<div id="do_right">
<?php
$pay_statuses = array('All');
$ship_statuses = array('All');
$issue_statuses = array('All');
$refund_statuses = array('All');
$return_statuses = array('All');
$statuses = kohana::config('order_status');
foreach($statuses['payment'] as $ck => $c)
    $pay_statuses[$ck] = $c['name'].($c['description']?' ['.$c['description'].']':'');
foreach($statuses['shipment'] as $ck => $c)
    $ship_statuses[$ck] = $c['name'].($c['description']?' ['.$c['description'].']':'');
foreach($statuses['refund'] as $ck => $c)
    $refund_statuses[$ck] = $c['name'].($c['description']?' ['.$c['description'].']':'');
foreach($statuses['return'] as $ck => $c)
    $return_statuses[$ck] = $c['name'].($c['description']?' ['.$c['description'].']':'');
?>
<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/admin/site/ordershipment/data',
            datatype: "json",
			height: 460,
			autowidth: true,
			colNames:['ID','Email', 'Order Number','Payment Status','Shipment Status', 'Created On', 'Action'],
			colModel:[
				{name:'id',index:'id'},
				{name:'email',index:'email'},
				{name:'ordernum',index:'ordernum'},
				{name:'payment_status',index:'payment_status',stype:'select',searchoptions:{value:<?php echo json_encode($pay_statuses);?>}},
				{name:'shipping_status',index:'shipping_status',stype:'select',searchoptions:{value:<?php echo json_encode($ship_statuses);?>}},
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
	function actionFormatter(cellvalue,options,rowObject) {
		return '<a href="/admin/site/ordershipment/edit/' + rowObject[0] + '">Edit</a>';
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
