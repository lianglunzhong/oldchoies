<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/manage/factory/data',
            datatype: "json",
			height: 450,
			width: 1050,
			colNames:['ID','名称','店铺链接','手机','旺旺','创建时间','管理员','操作'],
			colModel:[
                {name:'id',index:'id', width:40},
				{name:'name',index:'name', width:200},
				{name:'url',index:'url',align:'center', width:350},
                {name:'mobile',index:'mobile', width:100},
                {name:'aliwangwang',index:'aliwangwang', width:100},
                {name:'created',index:'created', width:120},
                {name:'user_id',index:'user_id', width:80},
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
		return '<a href="/manage/factory/edit/' + rowObject[0] + '">编辑</a> <a href="/manage/factory/delete/' + rowObject[0] + '" class="delete" product_type="'+rowObject[2]+'" product_sku="' + rowObject[4] + '">删除</a>';
	}
    function visibilityFormatter(cellvalue,options,rowObject) {
		return cellvalue == 1 ? '正常' : '缺货';
	}
</script>
<?php echo View::factory('admin/manage/left')->render(); ?>
<div id="do_right">

    <div class="box" style="overflow:hidden;">
        <h3>供货商</h3>
        <div style="margin-bottom: 10px;"><span><a href="/manage/factory/add" style="color: red">添加供货商</a></span></div>
        <div>
            <h3>
                <form enctype="multipart/form-data" action="/manage/factory/import" method="post">
                    <input type="file" name="file" />
                    <input type="submit" name="submit" value="供货商导入" />
                </form>
            </h3>
        </div>
        <table id="toolbar"></table>
		<div id="ptoolbar"></div>

    </div>
</div>