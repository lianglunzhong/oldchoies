<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/admin/site/group/data_topic',
            datatype: "json",
			height: 450,
			width: 1100,
			colNames:['ID','Group Name','Product','Subject','Content','Top_post','Last_post','Sticky','Locked','Started_by','Created','Moderators','Mod_time','Action'],
			colModel:[
                                {name:'id',index:'id', width:24, align:'center', search:false},
				{name:'group_name',index:'group_id',align:'center', width:60},
				{name:'product',index:'product_id', width:24},
                                {name:'subject',index:'subject', width:80},
                                {name:'content',index:'content', width:80},
                                {name:'top_post',index:'top_post', width:24},
                                {name:'last_post',index:'last_post', width:24},
                                {name:'sticky',index:'sticky', width:24, stype:'select', searchoptions:{value:':All;1:Yes;0:No'}},
                                {name:'locked',index:'locked', width:24, stype:'select', searchoptions:{value:':All;1:Locked;0:Unlocked'}},
                                {name:'started_by',index:'started_by', width:50},
                                {name:'created',index:'created', width:50},
                                {name:'moderators',index:'moderators', width:80},
                                {name:'mod_time',index:'mod_time', width:40},
				{width:60,search:false,align:'center',formatter:actionFormatter}
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
			if(!confirm('Delete this Forum?\nIt can not be undone!')){
				return false;
			}
		});
	});
	function actionFormatter(cellvalue,options,rowObject) {
		return '<a href="/admin/site/group/edit_topic/' + rowObject[0] + '">Edit</a> <a href="/admin/site/group/delete_topic/' + rowObject[0] + '" class="delete">Delete</a>';
	}
</script>
<?php echo View::factory('admin/site/group_left')->render(); ?>
<div id="do_right">

    <div class="box" style="overflow:hidden;">

		<table id="toolbar"></table>
		<div id="ptoolbar"></div>

    </div>
</div>

