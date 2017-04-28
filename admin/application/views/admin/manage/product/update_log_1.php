<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/manage/product/update_log_data',
            datatype: "json",
			height: 450,
			width: 700,
			colNames:['时间','SKU','产品分类','操作','操作人'],
			colModel:[
				{name:'created',index:'created', width:250},
				{name:'product_id',index:'product_id',align:'center', width:100},
                                {name:'catalog',index:'product_id', width:200, search:false},
                                {name:'action',index:'action', width:100},
				{name:'user_id',index:'user_id', width:50}
			],
            rowNum:20,
            //  rowTotal: 12,
            rowList : [20,30,50],
            // loadonce:true,
            mtype: "POST",
            // rownumbers: true,
            // rownumWidth: 40,
            gridview: true,
            pager: '#ptoolbar',
            sortname: 'id',
            viewrecords: true,
            sortorder: "desc"
            //            caption: "Toolbar Searching"
		});

		jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
        jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
        
        $('#gs_created').daterangepicker({
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
</script>
<?php echo View::factory('admin/manage/left')->render(); ?>
<div id="do_right">

    <div class="box" style="overflow:hidden;">

		<table id="toolbar"></table>
		<div id="ptoolbar"></div>

    </div>
</div>