<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/admin/site/group/data_post',
            datatype: "json",
			height: 450,
			width: 1000,
			colNames:['ID','Topic_id','User','Title','Content','Video_url','Create','Action'],
			colModel:[
				{name:'id',index:'id', width:30},
                                {name:'topic_id',index:'topic_id', width:40},
                                {name:'user',index:'user_id', align:'center', width:100},
                                {name:'title',index:'title', width:100},
                                {name:'content',index:'content', width:200},
                                {name:'video_url',index:'video_url', width:150},
                                {name:'create',index:'pub_time', width:80},
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
			if(!confirm('Delete this Post?\nIt can not be undone!')){
				return false;
			}
		});
	});
	function actionFormatter(cellvalue,options,rowObject) {
		return '<a href="/admin/site/group/edit_post/' + rowObject[0] + '">Edit</a> <a href="/admin/site/group/delete_post/' + rowObject[0] + '" class="delete">Delete</a>';
	}
</script>
<?php echo View::factory('admin/site/group_left')->render(); ?>
<div id="do_right">

    <div class="box" style="overflow:hidden;">

		<table id="toolbar"></table>
		<div id="ptoolbar"></div>

    </div>
</div>

