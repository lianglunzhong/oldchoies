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
                {name:'shipping_firstname',index:'shipping_firstname'},
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
            rowList : [20,50,100,200],
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
        <?php
        $user_id = Session::instance()->get('user_id');
        $userArr = array(1, 125);
        if(in_array($user_id, $userArr))
        {
            if (isset($_GET['cl'])):
            ?>
                html += '<a href="javascript:recover_order('+rowObject[1]+')">Recover</a>';
            <?php
            else:
                ?>
                html += '<a href="javascript:discard_order('+rowObject[1]+')">Discard</a>';
            <?php
            endif;
        }
        ?>
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
        <div class="box" style="overflow:hidden;">
            <h3>
                Order List (<a href="/admin/site/order/create">创建订单</a>)(<a href="/admin/site/order/add_item2order">批量添加订单产品</a>)
                <div style="float:right; margin-right:10px;"><a target="_blank" href="/admin/site/orderproduct/list?history=1338480000-<?php echo time();?>">订单产品数据</a></div>
            </h3>
            <div style="margin:20px">
                <h4>
                    订单统计：
                    <div style="float:right; margin-right:10px;"><a target="_blank" href="/admin/site/orderproduct/vip">Vip用户订单</a></div>
                </h4>
                <table>
                    <tr><td>时间:</td>
                        <?php
                        foreach ($dates as $date)
                        {
                            echo '<td>' . $date . '</td>';
                        }
                        ?>
                    </tr>
                    <tr><td>红人订单:</td>
                        <?php foreach ($order_statistics['celebrity'] as $date => $count): ?>
                            <?php echo "<td><strong>$count</strong> &nbsp;</td>"; ?>
                        <?php endforeach ?>
                    </tr>
                    <tr><td>采购订单:</td>
<?php foreach ($order_statistics['usual'] as $date => $count): ?>
    <?php echo "<td><strong>$count</strong> &nbsp;</td>"; ?>
<?php endforeach ?>
                    </tr>
                    <tr><td>手机订单:</td>
                        <?php foreach ($order_statistics['mobile'] as $date => $count): ?>
                            <?php echo "<td><strong>$count</strong> &nbsp;</td>"; ?>
                        <?php endforeach ?>
                    </tr>
                    <tr><td>电脑订单:</td>
                        <?php foreach ($order_statistics['pc'] as $date => $count): ?>
                            <?php echo "<td><strong>$count</strong> &nbsp;</td>"; ?>
                        <?php endforeach ?>
                    </tr>

                </table>
            </div>
            <div style="margin:20px;">
                <!-- <?php echo html::anchor('/admin/site/order/procurement', '采购单', array('target' => '_blank')); ?> -->
                <?php echo html::anchor('/admin/site/order/detail', '配货单', array('target' => '_blank')); ?>
<?php echo html::anchor('/admin/site/order/invoice', '发货单', array('target' => '_blank')); ?>
<?php echo html::anchor('/admin/site/order/list?cl=1', '丢弃的订单', array('target' => '_blank')); ?>
<?php echo html::anchor('/admin/site/order/export_shipment', '物流统计', array('target' => '_blank')); ?>
<?php echo html::anchor('/admin/site/order/export_product', '单品销售', array('target' => '_blank')); ?>

                <form style="margin:20px;" id="frm-order-export" method="post" action="/admin/site/order/export" target="_blank">
                    <label for="export-start">From: </label>
                    <input type="text" name="date" id="export-start" class="ui-widget-content ui-corner-all" />
                    <label for="export-end">To: </label>
                    <input type="text" name="date_end" id="export-end" class="ui-widget-content ui-corner-all" />
                    <input type="submit" value="导出" class="ui-button" style="padding:0 .5em" />
                    <input type="button" value="导出分类订单" id="export_catalog" />
                </form>

                <form style="margin:20px;" method="post" action="/admin/site/order/mobile_export_catalog" target="_blank">
                    <label>From: </label>
                    <input type="text" name="date"  class="ui-widget-content ui-corner-all time" />
                    <label>To: </label>
                    <input type="text" name="date_end"  class="ui-widget-content ui-corner-all time" />
                    <input type="submit" value="导出分类订单" class="ui-button" style="padding:0 .5em" />(mobile 用)
    <!--                <input type="button" value="导出分类订单" />(mobile 用)-->
                </form>


                <h4>订单跟踪链接统计：</h4>
                <form style="margin:20px;" id="frm-order-export1" method="post" action="/admin/site/order/export_status" target="_blank">
                    <label for="export-start">Payment method: </label>
                    <select name="payment_method">
                        <option value="PP" selected>PAYPAL</option>
                        <option value="GLOBEBILL">GLOBEBILL</option>
                    </select>
                    <label for="export-start">From: </label>
                    <input type="text" name="start" id="export-start1" class="ui-widget-content ui-corner-all" />
                    <label for="export-end">To: </label>
                    <input type="text" name="end" id="export-end1" class="ui-widget-content ui-corner-all" />
                    <input type="submit" value="导出" class="ui-button" style="padding:0 .5em" />
                </form>
                <script type="text/javascript">
                    $('#export-start, #export-end, .time').datepicker({
                        'dateFormat': 'yy-mm-dd'
                    });
                    $('#export-start1, #export-end1').datepicker({
                        'dateFormat': 'yy-mm-dd'
                    });
                </script>
            </div>
            
                <?php // echo Form::open('admin/site/sendmail/index', array('id' => 'orderForm')); ?>
            <form action="" id="orderForm" method="post" target="_blank">
                <table id="toolbar"></table>
<!--                        <input type="button" value="导出FedEx订单" id="orderSubmit" /><span style="color:red">(勾选订单生成表格)</span><br />-->
<?php
echo Form::select('mail_type', $mail_type);
?>
                <input type="button" value="发送邮件" id="mailSubmit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="text" name="email" />
                <input type="button" value="订单邮箱修改" id="mailEdit">
            </form>
            <div id="ptoolbar"></div>
            <fieldset style="text-align:right">
            <div style="float:right; margin-right:10px;font-size:14px;"><a target="_blank" href="/admin/site/order/sis">Sis</a></div>

            <div style="float:right; margin-right:10px;font-size:14px;">
                <form action="/admin/site/order/export_detail" method="post" target="_blank">
                    <label for="type">Type: </label>
                    <select name="type">
                        <option value="1">Payment date</option>
                        <option value="0">Order date</option>
                        <option value="2">verify date</option>
                    </select>
                    <label for="export-start">From: </label>
                    <input type="text" name="from" id="export-from" class="ui-widget-content ui-corner-all" />
                    <label for="export-end">To: </label>
                    <input type="text" name="to" id="export-to" class="ui-widget-content ui-corner-all" />
                    <input type="submit" value="导出订单详情" class="ui-button" style="padding:0 .5em" />
                    <script type="text/javascript">
                        $('#export-from, #export-to').datepicker({
                            'dateFormat': 'yy-mm-dd'
                        });
                    </script>
                </form>
            </div>
            </fieldset>
            <fieldset style="text-align:right">
                <legend style="font-weight:bold">所有订单导出</legend>
                <form id="frm-orderdata-export" method="post" action="/admin/site/order/export_data" target="_blank" style="float:left;">
                    <label for="exportdata-start">From: </label>
                    <input type="text" name="start" id="exportdata-start" class="ui-widget-content ui-corner-all" />
                    <label for="exportdata-end">To: </label>
                    <input type="text" name="end" id="exportdata-end" class="ui-widget-content ui-corner-all" />
                    <input type="submit" value="导出上面的订单信息" class="ui-button" style="padding:0 .5em" />
                </form>
                <a href="/admin/site/order/export_white_orders">导出前两天的白单信息</a>
                <br><br>
                <form id="frm-orderdata-export" method="post" action="/admin/site/order/export_gc_failed" target="_blank" style="float:left;">
                    <label for="exportgc-start">From: </label>
                    <input type="text" name="start" id="exportgc-start" class="ui-widget-content ui-corner-all" />
                    <label for="exportgc-end">To: </label>
                    <input type="text" name="end" id="exportgc-end" class="ui-widget-content ui-corner-all" />
                    <input type="submit" name="submit" value="导出GC支付失败详情" class="ui-button" style="padding:0 .5em" />
                    <input type="submit" name="submit" value="导出GC所有支付详情" class="ui-button" style="padding:0 .5em" />
                </form>
            </fieldset>
            <script type="text/javascript">
            $('#exportall-start, #exportall-end, #exportdata-start, #exportdata-end, #exportgc-start, #exportgc-end').datepicker({
                'dateFormat': 'yy-mm-dd', 
            });
            </script>
    <!--
            <fieldset style="text-align:right">
                <legend style="font-weight:bold">订单导出</legend>
                <form id="frm-order-export" method="post" action="/admin/site/order/export" target="_blank">
                    <label for="export-payment_status">Payment: </label>
                    <select name="payment_status" id="export-payment_status">
                        <option value="">All</option>
                        <option value="new">New</option>
                        <option value="success">Success</option>
                        <option value="pending">Pending</option>
                        <option value="failed">Failed</option>
                        <option value="cancel">Cancel</option>
                        <option value="partial_paid">Partial Paid</option>
                        <option value="verify_pass">Verify Pass</option>
                        <option value="verify_banned">Verify Banned</option>
                        <option value="verify_failed">Verify Failed</option>
                    </select>
                    <label for="export-shipment_status">Shipment: </label>
                    <select name="shipment_status" id="export-shipment_status">
                        <option value="">All</option>
                        <option value="new_s">New</option>
                        <option value="processing">Processing</option>
                        <option value="partial_shipped">Partial Shipped</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                    </select>
                    <label for="export-refund_status">Refund: </label>
                    <select name="refund_status" id="export-refund_status">
                        <option value="">All</option>
                        <option value="prepare_refund">Prepare Refund</option>
                        <option value="partial_refund">Partial Refund</option>
                        <option value="refund">Refund</option>
                    </select>
                    <label for="export-start">From: </label>
                    <input type="text" name="from" id="export-start" class="ui-widget-content ui-corner-all" />
                    <label for="export-end">To: </label>
                    <input type="text" name="to" id="export-end" class="ui-widget-content ui-corner-all" />
                    <input type="submit" value="导出" class="ui-button" style="padding:0 .5em" />
                </form>
            </fieldset>
            <script type="text/javascript">
            $('#export-start, #export-end').datepicker({
                'dateFormat': 'yy-mm-dd', 
            });
            </script>
-->                                    <!-- 根据orderid查询成功订单 -->
                <div>
                    
                    
                    <span>查询order信息：</span>
                        <label>请输入order id 一行一个：</label><br>
                        <form method="post" action="/admin/site/order/select_info_by_oids">
                            <textarea rows="20" cols="25" name="ORDERIDS"></textarea><br>
                            <input type="submit" value="order_info" name="Submit">
                        </form>

                </div>

                <div>               
                    <span>根据物流跟踪号查询order订单号：</span>
                        <label>请输入order id 一行一个：</label><br>
                        <form method="post" action="/admin/site/order/select_ordernum_by_tracking_code">
                            <textarea rows="20" cols="25" name="ORDERIDS"></textarea><br>
                            <input type="submit" value="order_info" name="Submit">
                        </form>

                </div>
                <br />
                <div style="display:none;">               
                    <span><h3>gc,oc订单自动分配比率设置：</h3></span>
                    <label><h4>输入一个数字（为gc分配的比率），oc自动分配比率为1-输入的百分比</h4></label><br>
                    <label><h4>如输入数字：7  则自动分配gc比率为70%，oc为30%(数字为0-10)</h4></label><br>
                        <form method="post" action="/admin/site/order/bname">
                            <input type="text" name="bname" />
                            <input type="submit" value="submit" name="Submit">
                        </form>

                </div>

            <fieldset style="text-align:left">
                <form id="frm-order-export" method="post" action="/admin/site/order/export_wholesale" target="_blank">
                    <label for="exportwholesaledata-start">From: </label>
                    <input type="text" name="start" id="exportwholesaledata-start" class="ui-widget-content ui-corner-all" />
                    <label for="exportwholesaledata-end">To: </label>
                    <input type="text" name="end" id="exportwholesaledata-end" class="ui-widget-content ui-corner-all" />
                    <input type="submit" value="导出Wholesale用户订单" class="ui-button" style="padding:0 .5em" />
                </form>
                <br>
                <form id="frm-order-export" method="post" action="/admin/site/order/export_amount200" target="_blank">
                    <label for="exportamount200data-start">From: </label>
                    <input type="text" name="start" id="exportamount200data-start" class="ui-widget-content ui-corner-all" />
                    <label for="exportamount200data-end">To: </label>
                    <input type="text" name="end" id="exportamount200data-end" class="ui-widget-content ui-corner-all" />
                    <input type="submit" value="导出换算后$200+用户订单" class="ui-button" style="padding:0 .5em" />
                </form>
            </fieldset>
            <script type="text/javascript">
                $('#exportwholesaledata-start, #exportwholesaledata-end, #exportamount200data-start, #exportamount200data-end').datepicker({
                    'dateFormat': 'yy-mm-dd',
                });
            </script>
        </div>
    </div>
</div>
