<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/admin/site/lookbook/data',
            datatype: "json",
			height: 450,
			width: 600,
			colNames:['ID','Title','Created','Visibility','Action'],
			colModel:[
				{name:'id',index:'id', width:40},
				{name:'title',index:'title',align:'center', width:200},
                                {name:'created',index:'created', width:200},
                                {name:'visibility',index:'visibility', width:100, stype:'select', searchoptions:{value:':All;1:Yes;0:No'}},
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
<?php echo View::factory('admin/site/lookbook_left')->render(); ?>
<div id="do_right">

    <div class="box" style="overflow:hidden;">

		<table id="toolbar"></table>
		<div id="ptoolbar"></div>

    </div>
</div>