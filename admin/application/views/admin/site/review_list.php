<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/admin/site/review/data',
            datatype: "json",
			height: 600,
			width: 1100,
			colNames:['Select','ID','User ID','SKU','Order ID','overall','quality','price','fitness','Content','reply','time','Points','Is_Process','Is_Approve','Action'],
			colModel:[
                {name:'selectall',align:'center',search:false,formatter:actionSelect,index:false,width:30},
				{name:'id',index:'id', width:30},
				{name:'user_id',index:'user_id',align:'center', width:30,search:false},
				{name:'sku',index:'sku', width:40,align:'center'},
                {name:'order_id',index:'order_id', width:40,align:'center'},
				{name:'overall',index:'overall', width:30},
                {name:'quality',index:'quality', width:30},
                {name:'price',index:'price', width:20},
                {name:'fitness',index:'fitness', width:30},
				{name:'content',index:'content'},
				{name:'reply',index:'reply'},
				{name:'time',index:'time', width:50},
                {name:'points',index:'points', width:50},
                {name:'is_process',index:'is_process', width:40,stype:'select',searchoptions:{value:':All;1:Yes;0:No'}},
                {name:'is_approved',index:'is_approved', width:40,stype:'select',searchoptions:{value:':All;1:Yes;0:No'}},
				{width:130,search:false,formatter:actionFormatter}
			],
            rowNum:20,
            rowList : [20,50,100,200,500],
            mtype: "POST",
            gridview: true,
            pager: '#ptoolbar',
            sortname: 'id',
            viewrecords: true,
            sortorder: "desc",
            recordtext: "View {0} - {1} of {2}",
            emptyrecords: "No records to view",
            loadtext: "Loading...",
            pgtext : "Page {0} of {1}",
            gridComplete: function () {
                $("table:first").find("tr:last").find("th:first").find("div").html("All<input id='selectall' type='checkbox'>");
                $("#selectall").click(function(){
                    $("#selectall").attr('checked') == true?$("input[name='orders[]']").each(function(){$(this).attr("checked", true)}):$("input[name='orders[]']").each(function(){$(this).attr("checked", false)});
                });
            }
		});

		jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,multipleSearch:true});
        jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});

    	$('#gs_time').daterangepicker({
    		dateFormat:'yy-mm-dd',
    		rangeSplitter:' to ',
    		onRangeComplete:(function(){
    			var last_date = '',$input = $('#gs_time');
    			return function(){
    				if(last_date != $input.val()) {
    					$('#toolbar')[0].triggerToolbar();
    					last_date = $input.val();
    				}
    			};
    		})()
    	});

        $('.delete').live('click',function(){
			if(!confirm('Delete this review?\nIt can not be undone!')){
				return false;
			}
		});
	});

    function actionSelect(cellvalue,options,rowObject){
        return '<input type="checkbox" name="orders[]" value ="'+rowObject[1]+'" >';
    }

	function actionFormatter(cellvalue,options,rowObject) {
		var html = '<a target="_blank" href="/admin/site/review/edit/' + rowObject[1] + '">Edit</a> <a href="javascript:do_delete(' + rowObject[1] + ');">Delete</a>';
        if (rowObject[14] == 'Yes')
        {
            html += ' <a href="javascript:un_approve('+rowObject[1]+');" class="unapprove">Unapprove</a>';
        }
        else
        {
            html += ' <a href="javascript:do_approve('+rowObject[1]+');" class="approve">Approve</a>';
        }

        return html;
	}

    function do_delete(review_id)
    {
        if (!window.confirm("delete?"))
            return false;

        $.ajax({
            url: '/admin/site/review/delete/'+review_id, 
            type: 'GET', 
            success: function(data)
            {
                if (data == 'success')
                {
                    $('#toolbar').trigger('reloadGrid');
                }
                else
                {
                    window.alert(data);
                }
            }
        });

        //return false;
    }

    function do_approve(review_id)
    {
    	//alert(review_id);exit;
        var points = window.prompt("How many points?", 0);
       // alert(points);eixt;
        if (points)
        {
            $.ajax({
                url: '/admin/site/review/approve/'+review_id, 
                data: 'points='+points, 
                type: 'POST', 
                success: function(data)
                {
                    if (data == 'success')
                    {
                        $('#toolbar').trigger('reloadGrid');
                    }
                    else
                    {
                        window.alert(data);
                    }
                }
            });
        }
    }

    function un_approve(review_id)
    {
        if (!window.confirm("Do you realy want to Unapprove This review?"))
            return false;
        $.ajax({
            url: '/admin/site/review/unapprove/'+review_id, 
            data: '', 
            type: 'POST', 
            success: function(data)
            {
                if (data == 'success')
                {
                    $('#toolbar').trigger('reloadGrid');
                }
                else
                {
                    window.alert(data);
                }
            }
        });
    }

    function do_process(formObj)
    {
        var datas = createData(formObj);
        $.ajax({
            type:"post",
            url : '/admin/site/review/do_process',
            data: datas,
            dataType: "json",
            success: function(data){
                alert(data.message);
                if(data.success)
                {
                    $('#toolbar').trigger('reloadGrid');
                }
            }
        });
        return false;
    }

    function createData(formObj){
        var datas = new Object();
        formElement = $(formObj).find("input,select,textarea");
        formElement.each(function(i,n){
            datas[$(n).attr("name")] = $(n).val();
        });
        return datas;
    }

</script>
<?php echo View::factory('admin/site/feedback_left')->render(); ?>
<div id="do_right">

    <div class="box" style="overflow:hidden;">
        <h3>Reviews
                    <form enctype="multipart/form-data" action="/admin/site/review/special_bulk" method="post" class="lang_hidden">
                                    <input type="file" name="file" />
                    <input type="submit" name="submit" value="批量导入review" /> 
                    </form>
        <span class="moreActions">
             <a href="/admin/site/review/add">Add Review</a>
        </span>
        </h3>
<!--                 <form enctype="multipart/form-data" action="/admin/site/review/special_bulk11" method="post" class="lang_hidden">
                    <input type="file" name="file" />
    <input type="submit" name="submit" value="批量basic修改review store" /> 
</form> -->

        <div style="margin:20px;">
            <form style="margin:20px;" method="post" action="/admin/site/review/export" target="_blank">
                <label>From: </label>
                <input type="text" name="date" class="ui-widget-content ui-corner-all" id="date">
                <label>To: </label>
                <input type="text" name="date_end" class="ui-widget-content ui-corner-all" id="date_end">
                <input type="submit" value="Export" class="ui-button" style="padding:0 .5em">
            </form>
            <script type="text/javascript">
                $('#date, #date_end').datepicker({
                    'dateFormat': 'yy-mm-dd'
                });
            </script>
        </div>
        <form action="/admin/site/review/do_process" method="post" id="reviewForm" onsubmit="return do_process(this);">
    		<table id="toolbar"></table>
            <input type="hidden" name="ids" value="" id="ids">
            <input type="submit" value="批量标记已处理">
        </form>
		<div id="ptoolbar"></div>

    </div>
</div>
<script>
    $(function(){
        $("#gbox_toolbar input[type=checkbox]").live('click', function(){
            var checks = $(this).attr('checked');
            var checkval = $(this).val();
            var ids = $("#ids").val();
            if(checkval == 'on')
            {
                ids = '';
                if(checks)
                {
                    $toolbar_ids = $("#toolbar").find('tr');
                    for(i = 0;i < $toolbar_ids.length;i ++)
                    {
                        var tr = $toolbar_ids.eq(i).attr('id');
                        ids += ',' + tr;
                    }
                }
            }
            else
            {
                var adds = ',' + checkval;
                if(checks)
                {
                    ids += adds;
                }
                else
                {
                    ids = ids.replace(adds, '');
                }
            }
            
            $("#ids").val(ids);
        })
    })
</script>
