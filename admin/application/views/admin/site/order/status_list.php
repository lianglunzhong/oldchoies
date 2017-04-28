<?php echo View::factory('admin/site/order/left')->render();?>
<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/admin/site/orderstatus/data',
            datatype: "json",
			height: 400,
			autowidth: true,
			colNames:['id','Type','Name','Description','Actions'],
			colModel:[
				{name:'status_id',index:'id'},
				{name:'status_type',index:'type',search:true,stype:'select',searchoptions:{value:{'0':'All','1':'Payment','2':'Shipment','3':'Issue','4':'Refund'}}},
				{name:'status_name',index:'name'},
				{name:'status_description',index:'description'},
				{width:60,search:false,formatter:actionFormatter}
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
		return '<a href="/admin/site/orderstatus/edit/' + rowObject[0] + '">Edit</a>';
	}
</script>
<div id="do_right">
	<div id="do_content">
		<div class="box">
			<h3>Status List</h3>
			<table id="toolbar"></table>
			<div id="ptoolbar"></div>
		</div>
	</div>
</div>
