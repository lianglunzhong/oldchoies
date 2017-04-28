<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<div id="do_content">
    <?php
    $pay_statuses = array('All');
    $ship_statuses = array('All');
    $issue_statuses = array('All');
    $refund_statuses = array('All');
    $return_statuses = array('All');
    $statuses = kohana::config('order_status');
    foreach ($statuses['payment'] as $ck => $c)
        $pay_statuses[$ck] = $c['name'] . ($c['description'] ? ' [' . $c['description'] . ']' : '');
    foreach ($statuses['shipment'] as $ck => $c)
        $ship_statuses[$ck] = $c['name'] . ($c['description'] ? ' [' . $c['description'] . ']' : '');
    foreach ($statuses['refund'] as $ck => $c)
        $refund_statuses[$ck] = $c['name'] . ($c['description'] ? ' [' . $c['description'] . ']' : '');
    foreach ($statuses['return'] as $ck => $c)
        $return_statuses[$ck] = $c['name'] . ($c['description'] ? ' [' . $c['description'] . ']' : '');
    $order_statuses = array_merge($statuses['payment'], $statuses['shipment'], $statuses['refund'], $statuses['return']);
    ?>
    <script type="text/javascript">
<?php echo 'order_statuses = ' . json_encode($order_statuses) . ';'; ?>
    function getStatusName(key)
    {
        var name = '';
        if (order_statuses[key])
            name = order_statuses[key]['name']+(order_statuses[key]['description']?' ['+order_statuses[key]['description']+']':'');
        return name;
    }
    function getStatusColor(key)
    {
        var name = '';
        if (order_statuses[key])
            name = order_statuses[key]['bgcolor'];
        return name;
    }
    $(function(){
        jQuery("#toolbar").jqGrid({
            url:'/admin/site/order/data?<?php echo $_SERVER['QUERY_STRING']; ?>',
            datatype: "json",
            height: 460,
            autowidth: true,
            colNames:['Select','ID','Order #','Email','Fullname','Created','Verify Date','Shipping Date','Payment Status','Shipment Status','Refund Status','Cur','Amount','Admin','P Method','Delivered Date','Mobile','Lang','From','Action'],
            colModel:[
                {name:'selectall',align:'center',search:false,formatter:actionSelect,index:false,width:40},
                {name:'id',index:'id',width:60},
                {name:'ordernum',index:'ordernum',width:120,formatter:noFormatter},
                {name:'email',index:'email',width:180,formatter:emailFormatter},
                {name:'fullname',index:'fullname',search:false},
                {name:'created',index:'created'},
                {name:'verify_date',index:'verify_date'},
                {name:'shipping_date',index:'shipping_date'},
                {name:'payment_status',index:'payment_status',stype:'select',searchoptions:{value:<?php echo "'" . str_replace(array('"', '{', '}', ',', '0:All'), array('', '', '', ';', ':All'), json_encode($pay_statuses)) . "'"; ?>}},
                {name:'shipping_status',index:'shipping_status',stype:'select',searchoptions:{value:<?php echo "'" . str_replace(array('"', '{', '}', ',', '0:All'), array('', '', '', ';', ':All'), json_encode($ship_statuses)) . "'"; ?>}},
                {name:'refund_status',index:'refund_status',stype:'select',searchoptions:{value:<?php echo "'" . str_replace(array('"', '{', '}', ',', '0:All'), array('', '', '', ';', ':All'), json_encode($refund_statuses)) . "'"; ?>}},
                {name:'currency',index:'currency',width:40},
                {name:'amount',index:'amount',width:80},
                {name:'admin',index:'admin',width:70},
                {name:'payment_method',index:'payment_method',width:100},
                {name:'deliver_time',index:'deliver_time',width:80},
                {name:'erp_fee_line_id',index:'erp_fee_line_id',width:80,stype:'select',searchoptions:{value:':All;1:Yes;0:No'},formatter:mobileFormatter},
                {name:'lang',index:'lang',width:80},
                {name:'order_from',index:'order_from',width:80},
                {search:false,formatter:actionFormatter,width:120}
            ],
            rowNum:20,
            rowList : [20,30,50],
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
                $("table:eq(1)").find("tr:last").find("th:first").find("div").html("All<input id='selectall' type='checkbox'>");
                $("#selectall").click(function(){
                    $("#selectall").attr('checked') == true?$("input[name='orders[]']").each(function(){$(this).attr("checked", true)}):$("input[name='orders[]']").each(function(){$(this).attr("checked", false)});
                });
                var rowData = $("#toolbar").getRowData();
                for (var i = 0; i < rowData.length; i++)
                {
                    var color = '';
                    var paymentcolor = '';
                    var shipmentcolor = '';
                    var refundcolor = '';
                    var payment = $('#'+rowData[i].id).find('td').eq(6);
                    if (order_statuses[payment.html()])
                    {
                        paymentcolor = getStatusColor(payment.html());
                        payment.css('background-color', paymentcolor);
                        payment.html(getStatusName(payment.html()));
                    }
                    var shipment = $('#'+rowData[i].id).find('td').eq(7);
                    if (order_statuses[shipment.html()])
                    {
                        shipmentcolor = getStatusColor(shipment.html());
                        shipment.css('background-color', shipmentcolor);
                        shipment.html(getStatusName(shipment.html()));
                    }
                    var refund = $('#'+rowData[i].id).find('td').eq(8);
                    if (order_statuses[refund.html()])
                    {
                        refundcolor = getStatusColor(refund.html());
                        refund.css('background-color', refundcolor);
                        refund.html(getStatusName(refund.html()));
                    }

                    var fullname = $('#'+rowData[i].id).find('td').eq(4);
                    var parts = fullname.html().split(':');
                    var name = parts[0];
                    var count = parseInt(parts[1]);

                    fullname.html(name);
                    if (count > 1) 
                    {
                        if (count == 2)
                        {
                            fullname.css('background-color', 'blue');
                        } 
                        else
                        {
                            fullname.css('background-color', 'green');
                        }
                    }

                    color = shipmentcolor?shipmentcolor:(refundcolor?refundcolor:paymentcolor);
                    var tr = $('tr#'+ rowData[i].id);
                    tr.css('background-image', 'none');
                    tr.css('background-color', color);
                }
            }
        });

        jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,multipleSearch:true});
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

        $('#gs_shipping_date').daterangepicker({
            dateFormat:'yy-mm-dd',
            rangeSplitter:' to ',
            onRangeComplete:(function(){
                var last_date = '',$input = $('#gs_shipping_date');
                return function(){
                    if(last_date != $input.val()) {
                        $('#toolbar')[0].triggerToolbar();
                        last_date = $input.val();
                    }
                };
            })()
        });
                        
        $('#gs_verify_date').daterangepicker({
            dateFormat:'yy-mm-dd',
            rangeSplitter:' to ',
            onRangeComplete:(function(){
                var last_date = '',$input = $('#gs_verify_date');
                return function(){
                    if(last_date != $input.val()) {
                        $('#toolbar')[0].triggerToolbar();
                        last_date = $input.val();
                    }
                };
            })()
        });
                        
        $("#orderSubmit").click(function(){
            var form = $('#orderForm');
            form.attr('action', '/admin/site/export/fedex_order');
            form.submit();
        })
                        
        $("#mailSubmit").click(function(){
            var form = $('#orderForm');
            form.attr('action', '/admin/site/sendmail/index');
            form.submit();
            return false;
        })
                        
        $("#mailEdit").click(function(){
            var form = $('#orderForm');
            form.attr('action', '/admin/site/order/email_edit');
            form.submit();
            return false;
        })
                        
        $("#export_catalog").click(function(){
            var form = $("#frm-order-export");
            form.attr('action', '/admin/site/order/export_catalog');
            form.submit();
        })
    });
    function actionSelect(cellvalue,options,rowObject){
        return '<input type="checkbox" name="orders[]" value ="'+rowObject[2]+'" >';
    }
        
    function actionFormatter(cellvalue,options,rowObject) {
        var html = '<a href="/admin/site/order/edit/' + rowObject[1] + '" target="_blank">Edit</a> ';
<?php if (isset($_GET['cl'])): ?>
                    html += '<a href="javascript:recover_order('+rowObject[1]+')">Recover</a>';
<?php else: ?>
                    html += '<a href="javascript:discard_order('+rowObject[1]+')">Discard</a>';
<?php endif ?>

                return html;
            }

            function dsFormatter(cellvalue,options,rowObject) {
                return (cellvalue == 1) ? 'yes' : 'no';
            }

            function mobileFormatter(cellvalue,options,rowObject) {
                return (cellvalue == 1) ? 'yes' : 'no';
            }
        
            function emailFormatter(cellvalue,options,rowObject) {
                return '<a href="javascript:$(\'#gs_email\').attr(\'value\', \''+cellvalue+"')"+';$(\'#toolbar\')[0].triggerToolbar();">'+cellvalue+'</a>';
            }

            function noFormatter(cellvalue,options,rowObject) {
                var is_marked = rowObject[rowObject.length-1];
                if (is_marked == 1) {
                    return '<span style="background:#F00">'+cellvalue+'</span>';
                }

                return cellvalue;
            }

            function discard_order(id)
            {
                if (!window.confirm('Discard this order?'))
                    return false;

                $.ajax({
                    url: '/admin/site/order/discard/' + id, 
                    success: function (data) {
                        if (data == 'success')
                            $('#toolbar').trigger('reloadGrid');
                        else
                            window.alert(data);
                    }
                });
            }

            function recover_order(id)
            {
                if (!window.confirm('Recover this order?'))
                    return false;

                $.ajax({
                    url: '/admin/site/order/recover/' + id, 
                    success: function (data) {
                        if (data == 'success')
                            $('#toolbar').trigger('reloadGrid');
                        else
                            window.alert(data);
                    }
                });
            }
    </script>
    <div id="do_content">
                    <h4>订单效能统计：(注：统计的是3个月内的数据，如需精准数据，请自行选择时间导出)</h4>
                <table>
                    <tr><td>物流方式/国家</td>
                        <?php
                        foreach ($dates1 as $date)
                        {
                            echo '<td>' . $date . '</td>';
                        }
                        ?>
                    </tr>
                    <?php foreach ($arr as $k => $v): ?>
                    <tr><td><?php echo $k; ?>:</td>
                        <?php foreach($v as $v1){ ?>
                            <?php echo "<td><strong>$v1</strong> &nbsp;</td>"; ?>
                        <?php } ?>
                        
                    </tr>
                <?php endforeach ?> 
                </table>
                <h4>订单支付状态统计：（3个月内数据）</h4>
                <table style="width:500px;">
                    <tr><td>订单总数</td><td>验证通过订单</td><td>暂未验证通过</td><td>白单</td><td>失败单</td><td>取消单</td></tr>
                <?php foreach ($brr as $k => $v): ?>
                    <tr>
                        <?php foreach($v as $v1){ ?>
                            <?php echo "<td><strong>$v1</strong> &nbsp;</td>"; ?>
                        <?php } ?>
                        
                    </tr>
                <?php endforeach ?>
                </table>
                <h4>verify订单发货状态统计：（3个月内数据）</h4>
                <table style="width:500px;">
                    <tr><td>订单总数</td><td>未处理订单</td><td>处理中订单</td><td>部分发货订单</td><td>已发货订单</td><td>妥投订单</td><td>到达待取订单</td></tr>
                <?php foreach ($crr as $k => $v): ?>
                    <tr>
                        <?php foreach($v as $v1){ ?>
                            <?php echo "<td><strong>$v1</strong> &nbsp;</td>"; ?>
                        <?php } ?>
                        
                    </tr>
                <?php endforeach ?>
                </table>
        <div class="box" style="overflow:hidden;">
            <h3>
                订单效能统计
            </h3>
            <div style="margin:20px">
                <h4>订单状态统计导出：</h4>
            </div>
            <div style="margin:20px;">

                <form style="margin:20px;" id="frm-order-export" method="post" action="/admin/site/order/paydown" target="_blank">
                    <label for="export-start">From: </label>
                    <input type="text" name="date" id="export-start" class="ui-widget-content ui-corner-all" />
                    <label for="export-end">To: </label>
                    <input type="text" name="date_end" id="export-end" class="ui-widget-content ui-corner-all" />
                    <input type="submit" value="导出订单支付状态统计" class="ui-button" style="padding:0 .5em" />
                    <input type="button" value="导出verify订单发货状态统计" id="export_catalog" />
                    <input type="button" value="导出主要国家妥投时效" id="export_catalog1" />
                </form>

                <script type="text/javascript">
                    $('#export-start, #export-end, .time').datepicker({
                        'dateFormat': 'yy-mm-dd'
                    });

                    $("#export_catalog").click(function(){
                        $("#frm-order-export").attr("action","/admin/site/order/verifydown");
                        $("#frm-order-export").submit();                        
                    })

                    $("#export_catalog1").click(function(){
                        $("#frm-order-export").attr("action","/admin/site/order/effectdown");
                        $("#frm-order-export").submit();                        
                    })
                </script>
            </div>
      </div>
    </div>

</div>
