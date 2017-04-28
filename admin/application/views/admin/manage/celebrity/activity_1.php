<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/manage/celebrity/activities_data',
            datatype: "json",
			height: 450,
			width: 1120,
			colNames:['ID','时间','姓名','Email','积分数量','积分时间','所选产品','产品分类','订单号','发货时间','到货时间','推广链接','推广时间','推广效果','操作人','操作'],
			colModel:[
                {name:'id',index:'id', width:40},
				{name:'created',index:'created', width:110},
				{name:'name',index:'name',align:'center', width:60},
                {name:'email',index:'email', width:100},
                {name:'points',index:'points', width:40},
                {name:'points_date',index:'points_date', width:70},
                {name:'product_id',index:'product_id', width:60},
                {name:'catalog',index:'catalog', width:100, search:false},
                {name:'ordernum',index:'ordernum', width:70},
                {name:'shipping_date',index:'shipping_date', width:70},
                {name:'delivery_date',index:'delivery_date', width:70},
                {name:'spread_url',index:'spread_url', width:100},
                {name:'spread_date',index:'spread_date', width:70},
                {name:'spread_flow',index:'spread_flow', width:50},
                {name:'user_id',index:'user_id', width:50},
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
		return '<a href="/manage/celebrity/edit_activity/' + rowObject[0] + '">编辑</a> ' +  ' <a href="/manage/celebrity/delete_activity/' + rowObject[0] + '" class="delete">删除</a>';
	}
    function visibilityFormatter(cellvalue,options,rowObject) {
		return cellvalue == 1 ? '正常' : '缺货';
	}
</script>
<?php echo View::factory('admin/manage/left')->render(); ?>
<div id="do_right">

    <div class="box" style="overflow:hidden;">
        <h3>红人活动记录</h3>
        <div style="margin-bottom: 10px;"><span><a href="/manage/celebrity/add_activity" style="color: red">添加活动记录</a></span></div>
		<table id="toolbar"></table>
		<div id="ptoolbar"></div>

    </div>
</div>