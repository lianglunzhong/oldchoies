<?php echo View::factory('admin/site/celebrity_left')->render(); ?>
<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/celebrity/flow_data',
                        datatype: "json",
                        height: 460,
                        width: 1000,
                        colNames:['ID','Celebrity Id','Email','Type','TypeName','Flow','Admin'],
                        colModel:[
                                {name:'id',index:'id', width:40},
                                {name:'celebrity_id',index:'celebrity_id', width:40},
                                {name:'email',index:'email',align:'center', width:150},
                                {name:'type',index:'type',align:'center', width:60},
                                {name:'name',index:'name', width:40},
                                {name:'flow',index:'flow', width:40},
                                {name:'admin',index:'admin', width:80},
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
                        sortorder: "desc",
                        gridComplete: function () {
                        }
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
        });
        function actionFormatter(cellvalue,options,rowObject) {
                return '';
        }
</script>
<div>

        <div class="box" style="overflow:hidden;">
                <h3>Celebrity Flow List</h3>
                <table id="toolbar"></table>
                <div id="ptoolbar"></div>
        </div>
</div>