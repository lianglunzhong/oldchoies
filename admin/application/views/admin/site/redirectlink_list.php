<?php echo View::factory('admin/site/basic_left')->render(); ?>

<div id="do_right">
    <div class="box">
        <h3>Redirect Links List</h3>
        <table id="toolbar"></table>
        <div id="ptoolbar"></div>
    </div>
</div>

<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/admin/site/redirectlink/data',
            datatype: "json",
			height: 470,
			width: 1085,
			colNames:['ID','Src Link','Des Link','Created','Operator','Actions'],
			colModel:[
				{name:'id',index:'id', width:24, align:'center'},
				{name:'src_link',index:'src_link',
                    editable:true,
                    edittype:'text',
                    editoptions:{size:40,maxlength:225},
                    editrules:{required:true},
                    formoptions:{elmsuffix:'<b style="color:red;">&nbsp;&nbsp;*必填</b>',label:'原始链接：'}
                },
                {name:'des_link',index:'des_link',
                    editable:true,
                    edittype:'text',
                    editoptions:{size:40,maxlength:225},
                    editrules:{required:true},
                    formoptions:{elmsuffix:'<b style="color:red;">&nbsp;&nbsp;*必填</b>',label:'目的链接：'}
                },
                {name:'created',index:'created',align:'center', width:50, search:false},
                {name:'operator',index:'operator', width:40, align:'center'},
                {name:'act',index:'act', width:45,sortable:false, search:false, align:'center'},
			],
            rowNum:20,
            rowList : [30,40,50],
            mtype: "POST",
            gridview: true,
            pager: '#ptoolbar',
            sortname: 'id',
            viewrecords: true,
            sortorder: "desc",
            gridComplete: function(){
                var ids = $("#toolbar").getDataIDs();//jqGrid('getDataIDs');
                for(var i=0;i<ids.length;i++){
                    var cl = ids[i];
                    be = "<span style='display:inline-block;height:22px;width:40px;line-height:28px;cursor:pointer;' onclick=\"jQuery('#toolbar').jqGrid('editGridRow','"+cl+"',{checkOnSubmit:true,checkOnUpdate:true,closeAfterEdit:true,closeOnEscape:true,resize:false,width:400,jqModal:false,top:120,left:300,afterSubmit:pAfterSbumit,reloadAfterSubmit:true});\">Edit</span>"; 
                    de = "<span style='display:inline-block;height:22px;width:40px;line-height:28px;cursor:pointer;' onclick=\"jQuery('#toolbar').jqGrid('delGridRow','"+cl+"',{closeOnEscape:true,resize:false,jqModal:false,top:120,left:300});\">Delete</span>";
                    jQuery("#toolbar").jqGrid('setRowData',ids[i],{act:be+de});
                }
            },
            editurl: "/admin/site/redirectlink/edit"
		});
        
		jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{edit:false,add:true,del:false,search:false},{},{afterSubmit:pAfterSbumit,closeAfterAdd:true,closeAfterEdit:true,resize:false,width:400,jqModal:false,top:120,left:300,reloadAfterSubmit:true},{},{});
        jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
	});
	function actionFormatter(cellvalue,options,rowObject) {
		return '<a class="editlinks">Edit</a>&nbsp;|&nbsp;<a class="delete_link" title="delete" href="/admin/site/redirectlink/delete/' + rowObject[0] + '">Delete</a>';
    }
    
    var pAfterSbumit = function processAfterSbumit(response)
    {
        var success =true;
        var message ="";
        var json = eval('('+ response.responseText + ')');
        if(!json.success){
           success =json.success;
           message =json.errors;
        }
        var new_id ="1";
        return [success,message,new_id];
    }
    
</script>
