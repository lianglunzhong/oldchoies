<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/admin/site/cooperation/data',
            datatype: "json",
			height: 440,
			width: 1000,
			colNames:['ID','Company Name','Category','State','City','Person','Telephone','Action'],
			colModel:[
				{name:'id',index:'id', width:26, align:'center'},
				{name:'name',index:'name'},
				{name:'cata',index:'cata', width:80, align:'center'},
				{name:'state',index:'state', width:60, align:'center'},
				{name:'city',index:'city', width:60, align:'center'},
				{name:'people',index:'people', width:60, align:'center'},
				{name:'tele',index:'tele', width:80, align:'center'},
				{width:60,search:false,formatter:actionFormatter, align:'center'}
			],
            rowNum:16,
            rowList : [20,30,50],
            mtype: "POST",
            gridview: true,
            pager: '#ptoolbar',
            sortname: 'id',
            viewrecords: true,
            sortorder: "desc"
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
		var html = '<a href="/admin/site/cooperation/edit/' + rowObject[0] + '">Details</a>'
                +' or '
                +'<a href="javascript:do_delete(' + rowObject[0] + ');">Delete</a>';
        
        return html;
	}

    function do_delete(review_id)
    {
        if (!window.confirm("Delete? Can't be undo!"))
            return false;

        $.ajax({
            url: '/admin/site/cooperation/delete/'+review_id, 
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
    }
</script>
<?php echo View::factory('admin/site/feedback_left')->render(); ?>
<div id="do_right">

    <div class="box" style="overflow:hidden;">
        <h3>Cooperation Information</h3>

		<table id="toolbar"></table>
		<div id="ptoolbar"></div>

    </div>
</div>