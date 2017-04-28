<div id="do_content" class="box">
    <h3>创建订单</h3>
    <form id="frm-create-order" action="/admin/site/order/create" method="post">
        <label for="customer-email">Customer Email: </label>
        <input type="text" id="customer-email" name="customer_email" /><br/>
        <label for="carrier">Shippint Method: </label>
        <select name="carrier" id="carrier">
            <?php foreach ($carriers as $carrier): ?>
            <option value="<?php print $carrier['carrier']; ?>"><?php print $carrier['carrier']; ?></option>
            <?php endforeach; ?>
        </select><br/>
        <label for="payment_method">Payment Method：</label>
        <select id="payment_method" name="payment_method" >
                <option value="PP">PAYPAL</option>
                <option value="OC">OC</option>
        </select><br/>
        <label for="is-backorder">退货单？</label>
        <input type="checkbox" id="is-backorder" name="is_backorder" /><br/>

        <label for="order_from">订单来源：</label>
        <select id="order_from" name="order_from" >
            <option value="">  </option>
            <?php $order_from=kohana::config("order_status.order_from");
            foreach($order_from as $key=>$value){ ?>
            <option value="<?php echo $key;?>"><?php echo $value;?></option>
            <?php } ?>
        </select><br/>

        <div id="is-backorder-toggle" style="display:none">
            <label for="ref-ordernum">关联的订单号：</label>
            <input type="text" id="ref-ordernum" name="ref_ordernum" />
        </div>
        <input type="submit" value="Create" />
    </form>
</div>
<script type="text/javascript">
$('#is-backorder').change(function() {
    if ($('#is-backorder').attr('checked')) 
    {
        $('#is-backorder-toggle').show();
    }
    else
        $('#is-backorder-toggle').hide();
});
</script>
