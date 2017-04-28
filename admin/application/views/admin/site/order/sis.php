<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<div>
    <div>
        <ul>
                <li>
                        <a href="/admin/site/order/sis">sis订单数据库</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="/admin/site/order/sis_report">Sis数据透视报表(运费<1000)</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="/admin/site/order/sis_report/1">Sis数据透视报表(运费>=1000)</a>
                </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/order/sis_data',
                        datatype: "json",
                        height: 450,
                        width: 1000,
                        colNames:['ID','Sid','Email','Date','订单产品总数','金额','来源','运费','购买次数','Action'],
                        colModel:[
                                {name:'id',index:'id', width:60},
                                {name:'sid',index:'sid', width:60},
                                {name:'email',index:'email',align:'center', width:200},
                                {name:'date',index:'date', width:80},
                                {name:'skus',index:'skus', width:100},
                                {name:'amount',index:'amount', width:50},
                                {name:'from',index:'from', width:200},
                                {name:'shipping',index:'shipping', width:50},
                                {name:'count',index:'count', width:50},
                                {width:100,search:false,formatter:actionFormatter}
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
                        sortorder: "desc"
                        //            caption: "Toolbar Searching"
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
                                                $('#toolbar')[0].triggerToolbar();
                                                last_date = $input.val();
                                        }
                                };
                        })()
                });

                $('.delete').live('click',function(){
                        if(!confirm('Delete this lookbook?\nIt can not be undone!')){
                                return false;
                        }
                });
        });
        function actionFormatter(cellvalue,options,rowObject) {
                return '<a href="/admin/site/order/sis_delete/' + rowObject[0] + '" class="delete">Delete</a>';
        }
</script>
<div id="do_content">
        <div class="box" style="overflow:hidden;">
                <h3>
                        sis订单数据库
                        <div style="margin:20px;">
                                <form enctype="multipart/form-data" method="post" action="/admin/site/order/sis_upload">
                                        <input id="file" type="file" name="file">
                                        <input type="submit" value="Bulk Upload" name="submit">
                                        <span style="color:red;">(表格模板: Sid,邮箱,订单产品总数,订单金额,物流费用,订单来源,订单日期)</span>
                                </form>
                        </div>
                </h3>
                <table id="toolbar"></table>
                <div id="ptoolbar"></div>

        </div>
</div>