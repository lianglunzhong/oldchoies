<div id="do_content" class="box">
    <h3>处理订单</h3>
    <div style="margin:20px">
        <form id="frm-order-process" action="" method="post">
<div>
            <label for="date" style="font-weight:bold">开始日期：</label>
            <input type="text" id="date" name="date" class="ui-widget-content ui-corner-all" />
</div>

<div>
            <label for="date" style="font-weight:bold">结束日期：</label>
            <input type="text" id="date_end" name="date_end" class="ui-widget-content ui-corner-all" />
            选择当天订单，结束日期留空即可
</div>

<div>
            <input type="button" id="btn-export-procurement"value="导出采购单" class="ui-button" style="padding:0 .5em;font-size:14px" />
            <input type="button" id="btn-export-procurementcsv"value="导出采购单csv" class="ui-button" style="padding:0 .5em;font-size:14px" />
            <input type="button" id="btn-export-order" value="导出订单" class="ui-button" style="padding:0 .5em;font-size:14px" />
            <input type="button" id="btn-export-orderhtml" value="导出配货单" class="ui-button" style="padding:0 .5em;font-size:14px" />
            <input type="button" id="btn-export-orderaddress" value="导出地址订单" class="ui-button" style="padding:0 .5em;font-size:14px" />
            <input type="button" id="btn-export-ordershipment" value="导出订单物流" class="ui-button" style="padding:0 .5em;font-size:14px" />
            <input type="button" id="btn-export-no-confirm-date" value="导出无验证时间产品" class="ui-button" style="padding:0 .5em;font-size:14px" />
</div>
        </form>
    </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div>
                <a href="/admin/site/order/check">SOFORTBANK订单查询</a>
                </div>

    <h3>订单处理统计</h3>
    <div style="margin:20px">
    <?php foreach ($statistics as $date => $count): ?>
    <span<?php if ($count != 0) { print ' style="color:red;font-weight:bold"'; } else { print ' style="color:green"'; } ?>><?php print date('Y-m-d', $date); ?></span>
    <?php endforeach ?>
    </div>

<!--    <h3>订单批量发货</h3>
    <div style="margin:5px;color:red">
        文件格式：订单号,跟踪号,跟踪链接,物流商<br/>
        （注意：逗号为英文半角, 每行一条记录）
    </div>

    <form id="frm-bulk-shipping" action="/admin/site/order/bulk_shipping" method="post" enctype="multipart/form-data">
        <input type="file" name="csv_file" />
        <input type="submit" value="上传" />
    </form>
    
    <br>-->
    <h3>订单批量发货</h3>
    <div style="margin:5px;color:red">
        文件格式：订单号 跟踪号 跟踪链接 物流商<br/>
    </div>

    <form id="frm-bulk-shipping" action="/admin/site/ordershipment/bulk" method="post" enctype="multipart/form-data">
        <input type="file" name="file" />
        <input type="submit" value="上传" />
    </form>

<br>

<h3>订单批量上传物流价格</h3>
    <div style="margin:5px;color:red">
        文件格式：订单号 物流价格<br/>
    </div>

    <form id="frm-bulk-shipping" action="/admin/site/ordershipment/bulk_price" method="post" enctype="multipart/form-data">
        <input type="file" name="file" />
        <input type="submit" value="上传" />
    </form>

<br>

    <h3>csv发货单打印</h3>
    <div style="margin:5px;color:red">
        文件格式：csv <br/>
        （注意：逗号为英文半角, 每行一条记录）
    </div>

    <form id="frm-procurementhtml" action="/admin/site/order/procurementhtml" method="post" enctype="multipart/form-data">
        <input type="file" name="csv_file" />
        <input type="submit" value="上传" />
    </form>



<br>
    <h3>新旧ERP切换期间,手动回传</h3>
    <div style="margin:5px;color:red">
        文件格式：ordernum shipping_method tracking_no tracking_link <br/>
    </div>
    <form id="frm-bulk-shipping" action="/admin/site/ordershipment/manual_update_shipment" method="post" enctype="multipart/form-data">
        <input type="file" name="file" />
        <input type="submit" value="手动回传并发邮件给客户" />
    </form>
<br>
    <h3>新旧ERP切换期间,手动回传后，修改发货日期(ship_date)</h3>
    <form id="frm-bulk-shipping" action="/admin/site/ordershipment/manual_update_shipment_ship_date" method="post" enctype="multipart/form-data">
        <label for="shipment_ship_date">发货日期: </label>
        <input type="text" name="ship_date" id="shipment_ship_date" class="ui-widget-content ui-corner-all" value="<?php print date('Y-m-d'); ?>"/><br>
        <label>请输入ordernum一行一个：</label><br>
        <textarea rows="20" cols="25" name="ordernum"></textarea><br>
        <input type="submit" value="批量修改发货日期" />
    </form>
    <script type="text/javascript">
        $('#shipment_ship_date').datepicker({
            'dateFormat': 'yy-mm-dd',
        });
    </script>
<!--    
<br>

    <h3>FedEx发货单打印</h3>
    <div style="margin:5px;color:red">
        文件格式：csv <br/>
        表头：订单号 重量 数量 货物说明 货物申报价值
    </div>
    <form id="frm-shipmentfedex" action="/admin/site/order/shipmentfedex" method="post" enctype="multipart/form-data">
        <input type="file" name="csv_file" />
        <input type="submit" value="生成.in文件" />
    </form>
-->
</div>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<script type="text/javascript">
$('#date').datepicker({
    'dateFormat': 'yy-mm-dd', 
});

$('#date_end').datepicker({
    'dateFormat': 'yy-mm-dd', 
});

$('#btn-export-procurement').click(function(){
    if ($('#date').attr('value') == '') {
        window.alert('请选择日期！');
        return false;
    }
    
    var form = $('#frm-order-process');
    form.attr('action', '/admin/site/order/procurement');
    form.submit();
});

$('#btn-export-procurementcsv').click(function(){
    if ($('#date').attr('value') == '') {
        window.alert('请选择日期！');
        return false;
    }
    
    var form = $('#frm-order-process');
    form.attr('action', '/admin/site/order/procurementcsv');
    form.submit();
});

$('#btn-export-order').click(function(){
    if ($('#date').attr('value') == '') {
        window.alert('请选择日期！');
        return false;
    }
    
    var form = $('#frm-order-process');
    form.attr('action', '/admin/site/order/export');
    form.submit();
});

$('#btn-export-orderhtml').click(function(){
    if ($('#date').attr('value') == '') {
        window.alert('请选择日期！');
        return false;
    }
    
    var form = $('#frm-order-process');
    form.attr('action', '/admin/site/order/export_html');
    form.submit();
});

$('#btn-export-orderaddress').click(function(){
    if ($('#date').attr('value') == '') {
        window.alert('请选择日期！');
        return false;
    }

    var form = $('#frm-order-process');
    form.attr('action','/admin/site/order/export_address');
    form.submit();
});

$('#btn-export-ordershipment').click(function(){
    if ($('#date').attr('value') == '') {
        window.alert('请选择日期！');
        return false;
    }

    var form = $('#frm-order-process');
    form.attr('action','/admin/site/ordershipment/export');
    form.submit();
});

$('#btn-export-no-confirm-date').click(function(){
    if ($('#date').attr('value') == '') {
        window.alert('请选择日期！');
        return false;
    }
    
    var form = $('#frm-order-process');
    form.attr('action', '/admin/site/order/noConfirmDate');
    form.submit();
});

</script>
