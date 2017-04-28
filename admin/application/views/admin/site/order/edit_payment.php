<script type="text/javascript" src="/media/js/my_validation.js"></script>
<form id="frm-order-payment" action="/admin/site/order/status/<?php print $id; ?>" method="post">
    <table style="width:480px">
        <tr>
            <td><strong>当前状态：</strong></td>
            <td><?php print $current_status['name'] . "(" . $current_status['description'] . ")"; ?></td>
        </tr>
        <tr>
            <td><strong>修改为：</strong></td>
            <td>
                <select id="payment_status" name="payment_status">
                    <?php
                    $current_status['payment'] = (array) $current_status['payment'];
                    foreach ($current_status['payment'] as $status):
                        ?>
                        <option value="<?php print $status; ?>"><?php print $payment_status[$status]['name'] . '(' . $payment_status[$status]['description'] . ')'; ?></option>
<?php endforeach ?>
                </select>
            </td>
        </tr>
        <tr>
            <td style="vertical-align:top"><label for="comment"><strong>备注：</strong></label></td>
            <td><textarea id="comment" name="comment" style="width:360px;height:120px"></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" name="_continue" value="修改并继续" />
                <input type="submit" name="_save" value="修改" />
            </td>
        </tr>
    </table>
</form>
<div id="remind"></div>
<script>
    $(function(){
        var remind = $('.remind').text();
        var rclass = $('.remind').attr('class');
        $('#remind').addClass(rclass);
        $('#remind').text(remind);
    
        $('.del').live('click',function(){
            if(!confirm('Delete this record?')){
                return false;
            }
        });
    })
</script>
<h3>订单支付历史</h3>
<table>
    <tr>
        <td colspan="7">
            <div>
                <form action="/admin/site/order/payment_add" method="post" class="need_validation" id="flash_add">
                    <span>Payment Method: </span>
                    <select id="payment_method" name="payment_method" class="required">
                        <option></option>
                        <option value="PPExpress">PP</option>
                        <option value="GlobalCollect">GC</option>
                    </select>
                    &nbsp;&nbsp;<span>Trans Id: </span>
                    <input type="text" class="small required" id="trans_id" name="trans_id" style="width:240px">
                    &nbsp;&nbsp;<span>Amount: </span>
                    <input type="text" class="small" id="amount" name="amount"  style="width:80px">
                    &nbsp;&nbsp;<span>Currency: </span>
                    <select id="currency" name="currency">
                        <option></option>
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                        <option value="GBP">GBP</option>
                    </select>
                    <?php
                    $uri = Request::instance()->uri;
                    $uriArr = explode('/', $uri);
                    $order_id = $uriArr[count($uriArr) - 1];
                    ?>
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                    <input type="hidden" name="customer_id" value="<?php echo Order::instance($order_id)->get('customer_id'); ?>" />
                    <input type="submit" style="padding:0 .5em" class="ui-button" value="Add Payment History">
                </form>
            </div>
        </td>
    </tr>
    <tr>
        <td>支付方法</td>
        <td>交易号码</td>
        <td>金额</td>
        <td>币种</td>
        <td>备注</td>
        <td>状态</td>
        <td>时间</td>
    </tr>
    <?php foreach ($histories as $history): ?>
        <tr>
            <td><?php echo $history['payment_method']; ?></td>
            <td><?php echo $history['trans_id']; ?></td>
            <td><?php echo $history['amount']; ?></td>
            <td><?php echo $history['currency']; ?></td>
            <td><?php echo $history['comment']; ?></td>
            <td><?php echo $history['payment_status']; ?></td>
            <td>
                <?php
                echo date('Y-m-d H:i:s', $history['created']);
                if ($history['ip'] === Null)
                    echo '&nbsp;&nbsp;&nbsp;<a href="/admin/site/order/payment_delete/' . $history['id'] . '" class="del">delete</a>';
                ?>
            </td>
        </tr>
    <?php endforeach ?>
</table>