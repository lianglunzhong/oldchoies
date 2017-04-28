<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<h3>修改发货状态</h3>
<form id="frm-order-shipment-status" action="/admin/site/order/status/<?php print $id; ?>" method="post">
    <ul>
        <li><label>当前状态：</label><?php print $current_status ? $current_status['name']."(".$current_status['description'].")" : '-'; ?></li>
        <li>
            <label for="shipping_status">修改状态：</label>
            <select id="shipping_status" name="shipping_status">
                <option value="">- 请选择发货状态 -</option>
                <?php if ($current_status): ?>
                <?php $current_status['shipment'] = (array)$current_status['shipment']; foreach($current_status['shipment'] as $status): ?>
                <option value="<?php print $status; ?>"><?php print $shipment_status[$status]['name'].'('.$shipment_status[$status]['description'].')'; ?></option>
                <?php endforeach ?>
                <?php else: ?>
                <?php foreach(array_keys($shipment_status) as $status): ?>
                <option value="<?php print $status; ?>"><?php print $shipment_status[$status]['name'].'('.$shipment_status[$status]['description'].')'; ?></option>
                <?php endforeach ?>
                <?php endif ?>
            </select>
        </li>
        <li>
                <label for="deliver_time" style="vertical-align:top">到货时间：</label><input type="text" id="deliver_time" name="deliver_time" value="<?php print $order['deliver_time'] ? date('Y-m-d', $order['deliver_time']) : ''; ?>" />
                <script type="text/javascript">
                        $('#deliver_time').datepicker({
                                'dateFormat': 'yy-mm-dd'
                        });
                </script>
        </li>
        <li>
                <label for="logistics_days" style="vertical-align:top">妥投时效/物流周期：</label><input type="text"  name="logistics_days" value="<?php print $order['logistics_days'] ?>" />
 
        </li>
    </ul>
    <div style="margin-bottom:20px">
        <input type="submit" name="_continue" value="修改并继续" />
        <input type="submit" name="_save" value="修改" />
    </div>
</form>

<style type="text/css">
    table.layout {width:640px}
    table.layout td {border-bottom:none}
</style>
<script type="text/javascript">
function fill_trace_url(id)
{
    urls = [
        '', 
        'http://app3.hongkongpost.com/CGI/mt/enquiry.jsp', 
        'http://www.ems.com.cn/mailtracking/e_you_jian_cha_xun.html',
        'http://www2.parcelforce.com/',
        'http://www.ups.com/tracking/tracking.html',
        'http://www.dhl-usa.com/en.html',
        'https://www.usps.com/',
        'http://www.fedex.com/Tracking/',
        'http://www.ontrac.com/',
        'http://www.sf-express.com/cn/sc/',
        'http://www.speedpost.com.sg/TrackAndTrace.asp',
        'http://www.fedex.com/Tracking?cntry_code=cn',
        'http://www.ec-firstclass.org/'
    ];

    document.getElementById('tracking_link').value = urls[id];
}
</script>
<h3>添加发货记录</h3>
<form id="frm-order-add-shipment" action="/admin/site/order/shipment/<?php print $id; ?>" method="post">
    <input type="hidden" name="shipping_status" value="<?php print $order['shipping_status']; ?>" />
    <ul id="shipment-items-list">
        <li><label for="tracking_code">物流号码：</label><input type="text" id="tracking_code" name="tracking_code" /></li>
        <li>
        <label for="shipping_method">物流商：</label>
        <select id="shipping_method" name="shipping_method">
            <option <?php if(!$shipping_method or $shipping_method == 'EMS') echo 'selected="selected"' ?> value="EMS">EMS</option>
            <option <?php if($shipping_method == 'Parcelforce(UK)') echo 'selected="selected"' ?> value="Parcelforce(UK)">Parcelforce(UK)</option>
            <option <?php if($shipping_method == 'UPS') echo 'selected="selected"' ?> value="UPS">UPS</option>
            <option <?php if($shipping_method == 'DHL') echo 'selected="selected"' ?> value="DHL">DHL</option>
            <option <?php if($shipping_method == 'HKPT') echo 'selected="selected"' ?> value="HKPT">HKPT</option>
            <option <?php if($shipping_method == 'HKPT-15-FREE') echo 'selected="selected"' ?> value="HKPT-15-FREE">HKPT-15-FREE</option>
            <option <?php if($shipping_method == 'CUE') echo 'selected="selected"' ?> value="CUE">CUE</option>
            <option <?php if($shipping_method == 'SF_EXPRESS') echo 'selected="selected"' ?> value="SF_EXPRESS">SF_EXPRESS</option>
            <option <?php if($shipping_method == 'EMS-SingPost') echo 'selected="selected"' ?> value="EMS-SingPost">EMS-SingPost</option>
            <option <?php if($shipping_method == 'FedEx-EXPRESS') echo 'selected="selected"' ?> value="FedEx-EXPRESS">FedEx EXPRESS</option>
        </select>
        </li>
        <li><label for="ship_date">发货日期：</label><input type="text" id="ship_date" name="ship_date" value="<?php print date('Y-m-d'); ?>" /></li>
        <li>
        <label for="tracking_link">查询网址：</label><input type="text" id="tracking_link" name="tracking_link" style="width:480px" />
        <select onchange="fill_trace_url(this.value);">
            <option value="0"> - 常用网址 - </option>
            <option value="1">香港航空</option>
            <option value="2">EMS</option>
            <option value="3">Parcelforce(UK)</option>
            <option value="4">UPS</option>
            <option value="5">DHL</option>
            <option value="6">USPS</option>
            <option value="7">FEDEX</option>
            <option value="8">ONTRAC</option>
            <option value="9">SF_EXPRESS</option>
            <option value="10">EMS-SingPost</option>
            <option value="11">FedEx EXPRESS</option>
            <option value="12">CUE</option>
        </select>
        </li>
        <li><label for="shipping_commnet" style="vertical-align:top">备注信息：</label><textarea id="shipping_comment" name="shipping_comment" style="width:470px;height:80px"></textarea></li>
        <li><label for="package_id" style="vertical-align:top">Package Id: </label><input type="text" id="package_id" name="package_id" value="" /></li>
    </ul>
    <label><h4 style="font-size:12px">选择发货的产品：</h4></label>
    <?php if ($products): ?>
    <script type="text/javascript">
    function toggle_select()
    {
        $('input.item-check').attr('checked', $('#slt_all').attr('checked'));
    }
    </script>
    <table>
        <thead>
            <th style="width:30px"><input type="checkbox" id="slt_all" onchange="toggle_select()" /></th>
            <th style="width:50px">发货数量</th>
            <th style="width:100px">货品SKU</th>
            <th style="width:150px">货品图片</th>
            <th style="width:330px">货品名称</th>
            <th style="width:150px">货品属性</th>
        </thead>
        <?php $left = false; ?>
        <?php foreach ($products as $item): ?>
        <?php if ($item['status'] == 'new'): ?>
        <?php $left = true; ?>
        <tr>
            <input type="hidden" name="shipping_items[]" value="<?php print $item['id']; ?>" />
            <td style="width:30px"><input type="checkbox" class="item-check" /></td>
            <td style="width:50px;"><input type="text" name="shipping_quantity[]" value="<?php print $item['quantity']; ?>" style="width:30px" /></td>
            <td style="width:100px;"><?php print $item['sku']; ?></td>
            <td style="width:150px;"><?php print html::image($item['image']); ?></td>
            <td style="width:330px;"><?php print html::anchor($item['link'], $item['name']); ?></td>
            <td style="width:150px;"><?php echo $item['attributes'];?></td>
        </tr>
        <?php endif ?>
        <?php endforeach ?>
    </table>
    <?php if (!$left): ?>
    <strong style="color:red;display:block;margin-bottom:10px">所有产品都已经发货</strong>
    <?php endif ?>
    <?php endif ?>
    <div style="margin-bottom:20px">
        <input type="submit" name="_continue" value="添加并继续" onclick="return del_uncheck();" />
        <input type="submit" name="_save" value="添加" onclick="return del_uncheck();" />
    </div>
</form>

<script type="text/javascript">
function del_uncheck() 
{
    $('input.item-check').each(function(idx, chkbox) {
        if (!chkbox.checked) {
            $(chkbox).parent().parent().remove();
        }
    });

    return true;
}
</script>

<h3>发货记录</h3>
<?php if ($shipments): ?>
<table>
    <thead>
        <tr>
            <th>物流商</th>
            <th>跟踪号</th>
            <th>跟踪网址</th>
            <th>物流价格</th>
            <th>发货日期</th>
            <th>发货详情</th>
        </tr>
    </thead>
    <?php foreach ($shipments as $shipment): ?>
    <tr>
        <td><?php print $shipment['carrier']; ?></td>
        <td><?php print $shipment['tracking_code']; ?></td>
        <td><?php print $shipment['tracking_link']; ?></td>
        <td><?php print $shipment['ship_price']; ?></td>
        <td><?php print date('Y-m-d', $shipment['ship_date']); ?></td>
        <td>
            <?php foreach ($shipment['items'] as $item): ?>
            <strong>SKU: </strong>
            <?php print Product::instance($item['item_id'])->get('sku'); ?>&nbsp;
            <strong>QTY: </strong>
            <?php print $item['quantity']; ?>
            <br/>
            <?php endforeach ?>
        </td>
    </tr>
    <?php endforeach ?>
</table>
<?php else: ?>
<strong>目前尚未发货</strong>
<?php endif ?>
