<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/manage/stock/update_log_data',
            datatype: "json",
			height: 450,
			width: 880,
			colNames:['ID','时间','采购产品','分类','卖家','数量','金额','是否缺货','采购员','操作'],
			colModel:[
                {name:'id',index:'id', width:40},
				{name:'created',index:'created', width:200},
				{name:'product_id',index:'product_id',align:'center', width:100},
                {name:'catalog',index:'product_id', width:200, search:false},
                {name:'factory_id',index:'factory_id', width:50},
                {name:'quantity',index:'quantity', width:50},
                {name:'amount',index:'amount', width:50},
                {name:'status',index:'status', width:70,formatter:visibilityFormatter,
					"searchoptions":{"value":":All;1:正常;0:缺货"},
					"stype":"select",
					"summaryTpl":"{0}"
				},
                {name:'user_id',index:'user_id', width:60},
				{width:60,search:false,formatter:actionFormatter}
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
        
        $('.delete').live('click',function(){
            confirm_info = '确定删除？';
            if(!confirm(confirm_info)){
                return false;
            }
        });
	});
    
    function actionFormatter(cellvalue,options,rowObject) {
		return '<a href="/manage/stock/edit/' + rowObject[0] + '">编辑</a> <a href="/manage/stock/delete/' + rowObject[0] + '" class="delete" product_type="'+rowObject[2]+'" product_sku="' + rowObject[4] + '">删除</a>';
	}
    function visibilityFormatter(cellvalue,options,rowObject) {
		return cellvalue == 1 ? '正常' : '缺货';
	}
</script>
<?php echo View::factory('admin/manage/left')->render(); ?>
<div id="do_right">

    <div class="box" style="overflow:hidden;">
        <h3>采购记录</h3>
        <div style="margin-bottom: 10px;"><span><a href="/manage/stock/add" style="color: red">添加采购记录</a></span></div>
		<table id="toolbar"></table>
		<div id="ptoolbar"></div>

    </div>
</div>