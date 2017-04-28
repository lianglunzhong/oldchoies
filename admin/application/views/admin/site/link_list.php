<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/admin/site/links/data',
            datatype: "json",
			height: 450,
			width: 1000,
			colNames:['ID','Name','Email','Subject','Message','Is_valid','Level','Action'],
			colModel:[
				{name:'id',index:'id', width:40},
				{name:'name',index:'name',align:'center', width:80},
				{name:'email',index:'email', width:180},
                                {name:'subject',index:'subject', width:180},
                                {name:'message',index:'message', width:300},
                                {name:'is_valid',index:'is_valid', width:40, stype:'select', searchoptions:{value:':All;1:Yes;0:No'}},
                                {name:'level',index:'level', width:40, stype:'select', searchoptions:{value:':All;0:0;1:1;2:2;3:3;4:4;5:5;6:6'}},
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
			if(!confirm('Delete this link?\nIt can not be undone!')){
				return false;
			}
		});
	});
	function actionFormatter(cellvalue,options,rowObject) {
		return '<a href="/admin/site/links/edit/' + rowObject[0] + '">Edit</a> <a href="/admin/site/links/delete/' + rowObject[0] + '" class="delete">Delete</a>';
	}
</script>
<div id="do_right">

    <div class="box" style="overflow:hidden;">

		<table id="toolbar"></table>
		<div id="ptoolbar"></div>

    </div>
</div>

