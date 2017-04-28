<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/admin/site/lookbook/reviews_data',
            datatype: "json",
			height: 450,
			width: 800,
			colNames:['ID','Lookbook Id','Customer','Content','Star','Created','Action'],
			colModel:[
				{name:'id',index:'id', width:40},
				{name:'lookbook_id',index:'lookbook_id',align:'center', width:60},
                                {name:'user_id',index:'user_id',align:'center', width:200},
                                {name:'content',index:'content',align:'center', width:200},
                                {name:'star',index:'star',align:'center', width:40},
                                {name:'created',index:'created', width:200},
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
			if(!confirm('Delete this review?\nIt can not be undone!')){
				return false;
			}
		});
	});
	function actionFormatter(cellvalue,options,rowObject) {
		return '<a href="/admin/site/reviews_edit/' + rowObject[0] + '">Edit</a> <a href="/admin/site/lookbook/reviews_delete/' + rowObject[0] + '" class="delete">Delete</a>';
	}
</script>
<?php echo View::factory('admin/site/lookbook_left')->render(); ?>
<div id="do_right">

    <div class="box" style="overflow:hidden;">
                <div style="margin:20px;">
                                <form enctype="multipart/form-data" method="post" action="/admin/site/lookbook/items">
                                        <input id="file" type="file" name="file">
                                        <input type="submit" value="Bulk Upload" name="submit">
                                </form>
                </div>
		<table id="toolbar"></table>
		<div id="ptoolbar"></div>

    </div>
</div>