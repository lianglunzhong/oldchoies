<?php
$types = array(
    1 => 'unpaid',2 => 'birth',3 => 'vip',4 => 'coupon',5 => 'whishlist'
);
$tables = array(
    1 => 'order',2 => 'customer',3 => 'order_payments',4 => 'coupon'
);
?>
<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/admin/site/email/logs_data',
            datatype: "json",
			height: 450,
			width: 600,
			colNames:['ID','Type','Send Date','Table','Table_id','Status','Action'],
			colModel:[
				{name:'id',index:'id', width:60},
                {name:'type',index:'type',width:150,stype:'select',searchoptions:{value:<?php echo "'" . str_replace(array('"', '{', '}', ','), array('', '', '', ';'), json_encode(array('' => '') + $types)) . "'"; ?>}},
                {name:'send_date',index:'send_date', width:200},
                {name:'table',index:'table',width:200,stype:'select',searchoptions:{value:<?php echo "'" . str_replace(array('"', '{', '}', ','), array('', '', '', ';'), json_encode(array('' => '') + $tables)) . "'"; ?>}},
                {name:'table_id',index:'table_id', width:200},
                {name:'status',index:'status', width:50},
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

        $('.delete').live('click',function(){
			if(!confirm('Delete this lookbook?\nIt can not be undone!')){
				return false;
			}
		});
	});
	function actionFormatter(cellvalue,options,rowObject) {
		return '<a href="/admin/site/lookbook/edit/' + rowObject[0] + '">Edit</a> <a href="/admin/site/lookbook/delete/' + rowObject[0] + '" class="delete">Delete</a>';
	}
</script>
<?php echo View::factory('admin/site/basic_left')->render(); ?>
<div id="do_right">
    <h3>Mail Logs List</h3>
    <div class="box" style="overflow:hidden;">

		<table id="toolbar"></table>
		<div id="ptoolbar"></div>

    </div>
</div>
