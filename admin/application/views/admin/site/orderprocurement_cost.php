<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<?php echo View::factory('admin/site/orderprocurement_left')->render(); ?>
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/orderprocurement/cost_data',
                        datatype: "json",
                        height: 400,
                        width: 1000,
                        colNames:['ID','Date','Sku','Price','Type','Remark','Quantity'],
                        colModel:[
                                {name:'id',index:'id', width:40},
                                {name:'date', index:'date',width:100},
                                {name:'sku',index:'sku',width:100},
                                {name:'price', index:'price',width:80},
//                                {name:'type', index:'type',width:80},
                                {name:'type',index:'type', width:50,align:'center',formatter:typeFormatter,searchoptions:{'value':':All;1:采购;2:其他'},stype:'select',"summaryTpl":"{0}"},
                                {name:'remark', index:'remark',width:80},
                                {name:'quantity', index:'quantity',width:80},
                        ],
                        rowNum:20,
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
                
                $('#gs_date').daterangepicker({
                        dateFormat:'yy-mm-dd',
                        rangeSplitter:' to ',
                        onRangeComplete:(function(){
                                var last_date = '',$input = $('#gs_date');
                                return function(){
                                        if(last_date != $input.val()) {
                                                $('#toolbar1')[0].triggerToolbar();
                                                last_date = $input.val();
                                        }
                                };
                        })()
                });
		
        });
        function actionFormatter(cellvalue,options,rowObject) {
                return '<a href="/admin/site/orderprocurement/view/' + rowObject[0] + '">View</a>';
        }
        function typeFormatter (cellvalue, options, rowObject)
        {
                var types = ['','采购','其他'];
                return ! types[cellvalue] ? '未知' : types[cellvalue] ;
        }
</script>
<div id="do_content">
        <div class="box" style="overflow:hidden;">
                <h3>采购成本表
                        <div style="margin:20px;">
                                <form enctype="multipart/form-data" method="post" action="/admin/site/orderprocurement/cost_upload" target="_blank">
                                        <input id="file" type="file" name="file">
                                        <input type="submit" value="Bulk Upload" name="submit">
                                </form>
                        </div>
                </h3>	
                <table id="toolbar"></table>
                <div id="ptoolbar"></div> 
        </div>
</div>
