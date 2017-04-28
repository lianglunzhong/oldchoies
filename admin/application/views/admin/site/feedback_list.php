<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/feedback/data',
                        datatype: "json",
                        height: 600,
                        width: 1100,
                        colNames:['Select','ID','Email','What Like','Do Better','Content','Time','Sent','Action'],
                        colModel:[
                                {name:'selectall',align:'center',search:false,formatter:actionSelect,index:false,width:40},
                                {name:'id',index:'id',align:'center', width:40},
                                {name:'email',index:'email',align:'center', width:120},
                                {name:'what_like',index:'what_like', width:200,align:'center'},
                                {name:'do_better',index:'do_better', width:200,align:'center'},
                                {name:'content',index:'content', width:200,align:'center'},
                                {name:'time',index:'time', width:60,align:'center'},
                                {name:'sent',index:'sent',align:'center', width:40},
                                {width:80,search:false,formatter:actionFormatter}
                        ],
                        rowNum:20,
                        rowList : [20,50,500],
                        mtype: "POST",
                        gridview: true,
                        pager: '#ptoolbar',
                        sortname: 'id',
                        viewrecords: true,
                        sortorder: "desc"
                });

                jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
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
                
                $("#mailSubmit").click(function(){
                        var form = $('#orderForm');
                        form.attr('action', '/admin/site/feedback/mail');
                        form.submit();
                })
                                        
                $("#deleteSubmit").click(function(){
                        var form = $('#orderForm');
                        form.attr('action', '/admin/site/feedback/delete');
                        form.submit();
                })
        });
        
        function actionSelect(cellvalue,options,rowObject){
                return '<input type="checkbox" name="ids[]" value ="'+rowObject[1]+'" >';
        }
        function actionFormatter(cellvalue,options,rowObject) {
                return '<a href="/admin/site/feedback/delete/' + rowObject[1] + '" class="delete">Delete</a>';
        }
</script>
<div id="do_content">
        <div class="box" style="overflow:hidden;">
                <h3>Feedback List</h3>
                <form action="" id="orderForm" method="post">
                        <table id="toolbar"></table>
                        <input type="button" value="发送邮件" id="mailSubmit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" value="删除" id="deleteSubmit">
                </form>
                <div id="ptoolbar"></div>
                
                <fieldset style="text-align:left;">
                        <legend style="font-weight:bold">Export Giveaway</legend>
                        <form id="frm-customer-export" method="post" action="/admin/site/feedback/giveaway" target="_blank">
                                <label for="export-start">From: </label>
                                <input type="text" name="start" id="export-start" class="ui-widget-content ui-corner-all" />
                                <label for="export-end">To: </label>
                                <input type="text" name="end" id="export-end" class="ui-widget-content ui-corner-all" />
                                <input type="submit" value="Export" class="ui-button" style="padding:0 .5em" />
                        </form>
                </fieldset>
				<fieldset style="text-align:left;">
                        <legend style="font-weight:bold">Activi Lottery用户表</legend>
                        <form id="frm-customer-export" method="post" action="/admin/site/feedback/lottery" target="_blank">
                                <label for="export-start">From: </label>
                                <input type="text" name="start" id="export-start1" class="ui-widget-content ui-corner-all" />
                                <label for="export-end">To: </label>
                                <input type="text" name="end" id="export-end1" class="ui-widget-content ui-corner-all" />
                                <input type="submit" value="Export" class="ui-button" style="padding:0 .5em" />
                        </form>
                </fieldset>
				
				
                <script type="text/javascript">
                        $('#export-start, #export-end').datepicker({
                                'dateFormat': 'yy-mm-dd', 
                        });
						$('#export-start1, #export-end1').datepicker({
                                'dateFormat': 'yy-mm-dd', 
                        });
                </script>
        </div>
</div>
