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
                        url:'/admin/site/order/sis_report_data<?php if($type) echo '/1'; ?>?<?php echo $_SERVER['QUERY_STRING']; ?>',
                        datatype: "json",
                        height: 450,
                        width: 1100,
                        colNames:['Id','来源','订单个数','订单总金额','客单价','总运费','客运费','订单产品总数','客产品总数','红人单总个数','红人SKU个数','复购率'],
                        colModel:[
                                {name:'id',index:'id',width:30},
                                {name:'from',index:'from', width:50},
                                {name:'orders',index:'orders', width:50},
                                {name:'amounts',index:'amounts', width:50},
                                {name:'o_amount',index:'o_amount', width:50},
                                {name:'shippings',index:'shippings', width:50},
                                {name:'o_shipping',index:'o_shipping', width:50},
                                {name:'quantitys',index:'quantitys', width:50},
                                {name:'o_quantity',index:'o_quantity', width:50},
                                {name:'celebrity',index:'celebrity', width:50},
                                {name:'cele_skus',index:'cele_skus', width:50},
                                {name:'repeat',index:'repeat', width:70},
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
                                var rowData = $("#toolbar").getRowData();
				for (var i = 0; i < rowData.length; i++)
				{
                                        var from = $('#'+rowData[i].id).find('td').eq(1).html();
                                        if(from == 'Total')
                                        {
                                                var tr = $('tr#'+ rowData[i].id);
						tr.css('background-image', 'none');
						tr.css('background-color', '#0F0');
                                        }
                                }
                        }
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
                <h3>Sis数据透视报表<?php if($type) echo '(运费>=1000)'; else echo '(运费<1000)' ?>
                <?php
                $from = Arr::get($_GET, 'from', '');
                $to = Arr::get($_GET, 'to', '');
                if($from)
                        echo 'From ' . date('Y-m-d', $from);
                if($to)
                        echo 'To ' . date('Y-m-d', $to);
                ?>
                </h3>
                <br/>
                <fieldset>
                        <legend style="font-weight:bold">Date From To</legend>
                        <div style="margin:20px;">
                                <form enctype="multipart/form-data" method="post" action="#" id="daterange">
                                        <label for="from">From: </label>
                                        <input type="text" class="text small required email" id="from" name="from">
                                        <label for="to">To: </label>
                                        <input type="text" class="text small required email" id="to" name="to">
                                        <input type="submit" style="padding:0 .5em" class="ui-button" value="Submit">
                                </form>
                                <script type="text/javascript">
                                        $('#from,#to').datepicker({
                                                'dateFormat': 'yy-mm-dd'
                                        });
                                </script>
                        </div>
                </fieldset>
                <table id="toolbar"></table>
                <div id="ptoolbar"></div>

        </div>
</div>