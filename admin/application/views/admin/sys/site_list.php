<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/admin/sys/site/data',
            datatype: "json",
			height: 300,
			width: 900,
			colNames:['ID','Domain','Lang','Email','Action'],
			colModel:[
				{name:'ID',index:'id', width:40},
				{name:'Domain',index:'domain', width:200},
				{name:'Lang',index:'lang', width:100},
				{name:'Email',index:'email', width:100},
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
			postData: {id_for_search:true},
            pager: '#ptoolbar',
            sortname: 'id',
            viewrecords: true,
            sortorder: "asc"
		});

		jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
		jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
	});

	function actionFormatter(cellvalue,options,rowObject) {
        return '<a href="/admin/sys/site/edit/' + rowObject[0] + '">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/admin/sys/site/go/' + rowObject[0] + '?redirect=<?php echo $redirect;?>"> Go </a>';
	}

</script>
<div id="do_content">

    <div class="box" style="overflow:hidden;">
        <h3>Sites
			<span class="moreActions">
				<a href="/admin/sys/site/add">Add Site</a>
			</span>
        </h3>
		<p>To choose a site, press "Go".</p>
		<table id="toolbar"></table>
		<div id="ptoolbar"></div>

    </div>
</div>
<div style="display:none;">
        
</div>
