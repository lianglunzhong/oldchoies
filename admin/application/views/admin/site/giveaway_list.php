<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/admin/site/review/dataGiveaway',
              datatype: "json",
			height: 600,
			width: 1000,
			colNames:['ID','User ID','Full Name','Type','Content','Mark','Created','Options'],
			colModel:[
				{name:'id',index:'id', width:24,align:'center'},
				{name:'user_id',index:'user_id',align:'center', width:110},
				{name:'full_name',index:'full_name', width:60,align:'center',search:false},
				{name:'type',index:'type', width:80,search:false},
				{name:'content',index:'content',search:false},
                                {name:'mark',index:'mark',search:false,align:'center',width:24},
				{name:'created',index:'created', width:50,align:'center'},
				{width:70,search:false,formatter:actionFormatter,align:'center'}
			],
            rowNum:30,
            //  rowTotal: 12,
            rowList : [50,100,180],
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

    	$('#gs_created').daterangepicker({
    		dateFormat:'yy-mm-dd',
    		rangeSplitter:' to ',
    		onRangeComplete:(function(){
    			var last_date = '',$input = $('#gs_created');
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
	function actionFormatter(cellvalue,options,rowObject) {
        //var html = '<a href="/admin/site/review/edit/' + rowObject[0] + '">Edit</a><a href="javascript:do_delete(' + rowObject[0] + ');">Delete</a>';
        if (rowObject[7] == 1) {
            html = ' <span style="color:green;font-weight:bold;width:30px;display:inline-block;">Yes</span>';
        } else {
            html = ' <span style="color:red;font-weight:bold;width:30px;display:inline-block;">No</span>';
        }
        html += '<a href="javascript:do_toggle(' + rowObject[0] + ');">Toggle</a> ';
        html += '<a href="javascript:do_delete(' + rowObject[0] + ');" style="text-decoration:underline;">Delete</a>';
        return html;
	}

    function do_toggle(review_id)
    {
        $.ajax({
            url: '/admin/site/review/toggle/', 
            data: 'gid='+review_id, 
            type: 'POST', 
            success: function(data) {
                if (data == 'success') {
                    $('#toolbar').trigger('reloadGrid');
                } else {
                    window.alert(data);
                }
            }
        });
    }
    
    function do_delete(review_id)
    {
        $.ajax({
            url: '/admin/site/review/deleteGiveaway/', 
            data: 'gid='+review_id, 
            type: 'POST', 
            success: function(data) {
                if (data == 'success') {
                    $('#toolbar').trigger('reloadGrid');
                } else {
                    window.alert(data);
                }
            }
        });
    }
</script>
<?php echo View::factory('admin/site/feedback_left')->render(); ?>
<div id="do_right">
    <div class="box" style="overflow:hidden;">
        <h3>Giveaway is valid ?</h3>
		<p>
            <form action="/admin/site/review/exEmailGiveaway" method="post">
            <strong>Export Customer Email:</strong>
            <span>
                <select name="stage" id="stage">
                <?php
                $stages = DB::SELECT('mark')->distinct(TRUE)->from('giveaway')->order_by('mark','desc')->as_object()->execute();
                foreach ( $stages as $stage ):
                ?>
                    <option><?php echo $stage->mark;?></option>
                <?php endforeach;?>
                </select>
            </span>Stage
            <input type="submit" value="Export" style="background-color: #F8F8F8;width: 68px;height: 24px;border: #E8E8E8 1px solid;cursor: pointer;" />
            </form>
        </p>
		<table id="toolbar"></table>
		<div id="ptoolbar"></div>
    </div>
</div>