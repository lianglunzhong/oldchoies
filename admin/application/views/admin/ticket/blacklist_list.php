<?php echo View::factory('admin/ticket/ticket_left')->render(); ?>
<script type="text/javascript">
$(function(){
	jQuery("#bar").jqGrid({
		url:'/admin/ticket/blacklist/data',
		datatype: "json",
		height: 500,
		autowidth: true,
		colNames:['ID','Domain','Active','Action'],
		colModel:[
			{name:'id',index:'id'},
			{name:'domain',index:'domain'},
			{name:'is_active',index:'is_active',stype:'select',searchoptions:{value:':All;1:Yes;0:No'}},
			{formatter:actionFormatter, width:80,search:false}
		],
		rowNum:50,
		rowList : [20,30,50],
		mtype: "POST",
		gridview: true,
		pager: '#toolbar',
		sortname: 'id',
		viewrecords: true,
		sortorder: "desc",
		recordtext: "View {0} - {1} of {2}",
		emptyrecords: "No records to view",
		loadtext: "Loading...",
		pgtext : "Page {0} of {1}",
	});

	jQuery("#bar").jqGrid('navGrid','#toolbar',{del:false,add:false,edit:false,multipleSearch:true});
	jQuery("#bar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});

	function actionFormatter(cellvalue,options,rowObject){
		return '<a href="#" ordernum="' + rowObject[0] + '" class="edit">Edit</a>&nbsp;<a href="#" ordernum="' + rowObject[0] + '" class="delete">Delete</a>';
	}
	$('#add').dialog({ autoOpen: false });

    $('#add_blacklist').click(function(){
        $('#add').find("#domain").val("");
        $('#add').find("#id").val("");
        $("input[type=radio][value=1]",$("#add")).attr("checked",true);
        $('#add').dialog('open');
        return false;
    });

    $('.edit').live('click',function(){
        var $this = $(this);
        var ret = jQuery("#bar").jqGrid('getRowData',$this.attr('ordernum'));
        $('#add').find("#domain").val(ret.domain);
        $('#add').find("#id").val(ret.id);
        active=ret.is_active=="No"?0:1;
        $("input[type=radio][value="+active+"]",$("#add")).attr("checked",true);
        $('#add').dialog('open');
        return false;
    });

    $('.delete').live('click',function(){
       if(confirm("确定移除此Mail Domain?"))
       {
           window.location.href="/admin/ticket/blacklist/delete/"+$(this).attr('ordernum');
       }
       else
       {
           return false;
       }
    });
})
</script>

<div id="do_right">
	<div id="do_content">
		<div class="box" style="overflow:hidden;">
			<h3>Mail BlackList</h3><a href="#" id="add_blacklist">Add Mail Domain</a>
			<table id="bar"></table>
			<div id="toolbar"></div>
		</div>
	</div>
</div>

<div id="add" title="Add/Edit BlackList">
<form action="/admin/ticket/blacklist/update" method="post">
	<table border="1" cellpadding="0" cellspacing="0" width="250" style="margin:auto;">
		<tr>
			<td class="tdLabel"><label>Domain</label></td>
			<td class="tdInput"><input type="text" name="domain" id="domain"/></td>
		</tr>
		<tr>
			<td class="tdLabel"><label>Active</label></td>
			<td class="tdInput">
				<input type="radio" name="is_active" value="1"  checked/>YES
				<input type="radio" name="is_active" value="0"  />NO
			</td>
		</tr>
	</table>
	<input name="id" value="" type="hidden" id="id"/>
	<input value="Submit"  type="submit"/>
</form>
</div>