<?php echo View::factory('admin/ticket/ticket_left')->render(); ?>
<div id="do_right">
	<script type="text/javascript">
	$(function(){
		jQuery("#linebar").jqGrid({
			url:'/admin/ticket/site/line_data',
			datatype: "json",
			height: 200,
			autowidth: true,
			colNames:['ID','Name','Brief','Active','Action'],
			colModel:[
				{name:'id',index:'id', width:80},
				{name:'name',index:'name'},
				{name:'brief',index:'brief'},
				{name:'is_active',index:'is_active',formatter:acFormatter},
				{formatter:actionFormatter, width:50,search:false}
			],
			rowNum:50,
			rowList : [20,30,50],
			mtype: "POST",
			gridview: true,
			pager: '#linetoolbar',
			sortname: 'id',
			viewrecords: true,
			sortorder: "desc",
			recordtext: "View {0} - {1} of {2}",
			emptyrecords: "No records to view",
			loadtext: "Loading...",
			pgtext : "Page {0} of {1}",
		});

		jQuery("#linebar").jqGrid('navGrid','#linetoolbar',{del:false,add:false,edit:false,multipleSearch:true});
		jQuery("#linebar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
		$('.edit_line').live('click',function(){
            var $this = $(this);
            var ret = jQuery("#linebar").jqGrid('getRowData',$this.attr('ordernum'));
            $('#line_add').find("#name").val(ret.name);
            $('#line_add').find("#brief").val(ret.brief);
            $('#line_add').find("#id").val(ret.id);
            active=ret.is_active=="no"?0:1;
            $("input[type=radio][value="+active+"]",$("#line_add")).attr("checked",true);
            $('#line_add').dialog('open');
            return false;
        });
	});
	$(function(){
		jQuery("#sitebar").jqGrid({
			url:'/admin/ticket/site/site_data',
			datatype: "json",
			height: 500,
			autowidth: true,
			colNames:['ID','Domain','Email','Ticket Center','Line','Active','HiddenLine','Action'],
			colModel:[
				{name:'id',index:'id',width:80},
				{name:'domain',index:'domain'},
				{name:'ticket_email',index:'ticket_email'},
				{name:'ticket_center',index:'ticket_center'},
				{name:'line_id',index:'line_id'},
				{name:'is_active',index:'is_active',formatter:acFormatter},
				{name:'hiddenline',index:'hiddenline',hidden:true},
				{formatter:siteActionFormatter, width:50,search:false},
			],
			rowNum:50,
			rowList : [20,30,50],
			mtype: "POST",
			gridview: true,
			pager: '#sitetoolbar',
			sortname: 'id',
			viewrecords: true,
			sortorder: "desc",
			recordtext: "View {0} - {1} of {2}",
			emptyrecords: "No records to view",
			loadtext: "Loading...",
			pgtext : "Page {0} of {1}",
		});

		jQuery("#sitebar").jqGrid('navGrid','#sitetoolbar',{del:false,add:false,edit:false,multipleSearch:true});
		jQuery("#sitebar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
		$('.edit_site').live('click',function(){
            var $this = $(this);
            var ret = jQuery("#sitebar").jqGrid('getRowData',$this.attr('ordernum'));
            $('#site_add').find("#domain").val(ret.domain);
            $('#site_add').find("#ticket_email").val(ret.ticket_email);
            $('#site_add').find("#ticket_center").val(ret.ticket_center);
            $('#site_add').find("#line_id").val(ret.hiddenline);
            $('#site_add').find("#id").val(ret.id);
            active=ret.is_active=="no"?0:1;
            $("input[type=radio][value="+active+"]",$("#site_add")).attr("checked",true);
            $('#site_add').dialog('open');
            return false;
        });
	});

	function siteActionFormatter(cellvalue,options,rowObject){
		return '<a href="#" ordernum="' + rowObject[0] + '" class="edit_site">Edit</a>';
	}
	
	function actionFormatter(cellvalue,options,rowObject) {
		return '<a href="#" ordernum="' + rowObject[0] + '"  class="edit_line">Edit</a>';
	}
    function acFormatter(cellvalue,options,rowObject) {
        return (cellvalue == 1) ? 'yes' : 'no';
    }
	</script>
	<div id="do_content">
		<div class="box" style="overflow:hidden;">
			<h3>Lines List</h3><a href="#" id="add_line">Add</a>
			<table id="linebar"></table>
			<div id="linetoolbar"></div>
		</div>
		<div class="box" style="overflow:hidden;">
			<h3>Sites List</h3><a href="#" id="add_site">Add</a>
			<table id="sitebar"></table>
			<div id="sitetoolbar"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	
    $('#add_site').click(function(){
        $('#site_add').find("#domain").val("");
        $('#site_add').find("#email").val("");
        $('#site_add').find("#ticket_center").val("");
        $('#site_add').find("#line_id").val("");
        $('#site_add').find("#id").val("");
        $("input[type=radio][value=1]",$("#site_add")).attr("checked",true);
        $('#site_add').dialog('open');
        return false;
    });
    $('#add_line').click(function(){
        $('#line_add').find("#name").val("");
        $('#line_add').find("#brief").val("");
        $('#line_add').find("#id").val("");
        $("input[type=radio][value=1]",$("#line_add")).attr("checked",true);
        $('#line_add').dialog('open');
        return false;
    });
	$('#line').submit(function(){
		if($('#name').val()=='')
		{
			alert('Please type a name!');
			return false;
		}
	});
	$('#site').submit(function(){
		if($('#domain').val()==''||$('#ticket_email').val()==''||$('#ticket_center').val()=='')
		{
			alert('Please finish the form!');
			return false;
		}
	});
    $('#line_add').dialog({ autoOpen: false });
    $('#site_add').dialog({ autoOpen: false });
});
</script>

<div id="line_add" title="Add/Edit Line">
<form action="/admin/ticket/site/line_update" method="post" name="line" id="line">
	<table border="1" cellpadding="0" cellspacing="0" width="250" style="margin:auto;">
		<tr>
			<td class="tdLabel"><label>Name</label></td>
			<td class="tdInput"><input type="text" name="name" id="name"/></td>
		</tr>
		<tr>
			<td class="tdLabel"><label>Brief:</label></td>
			<td class="tdInput"><input type="text" name="brief" id="brief"/></td>
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

<div id="site_add" title="Add/Edit Site">
<form action="/admin/ticket/site/site_update" method="post" name="site" id="site">
	<table border="1" cellpadding="0" cellspacing="0" width="250" style="margin:auto;">
		<tr>
			<td class="tdLabel"><label>Domain</label></td>
			<td class="tdInput"><input type="text" name="domain" id="domain"/></td>
		</tr>
		<tr>
			<td class="tdLabel"><label>Email:</label></td>
			<td class="tdInput"><input type="text" name="ticket_email" id="ticket_email"/></td>
		</tr>
		<tr>
			<td class="tdLabel"><label>Ticket Center:</label></td>
			<td class="tdInput"><input type="text" name="ticket_center" id="ticket_center"/></td>
		</tr>
		<tr>
			<td class="tdLabel"><label>Line:</label></td>
			<td class="tdInput">
			<select name="line_id" id="line_id">
			<?php 
			foreach ($lines as $key=>$value){
				?>
				<option value="<?php echo $key;?>"><?php echo $value;?></option>
				<?php 
			}
			?>
			</select>
			</td>
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
