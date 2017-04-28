<link type="text/css" href="/media/js/jquery-ui/jquery-ui-1.8.1.custom.css" rel="stylesheet" id="uistyle" /> 
<script type="text/javascript" src="/media/js/jquery-1.4.2.min.js"></script> 
<script type="text/javascript" src="/media/js/jquery-ui-1.8.1.custom.min.js"></script> 
<style type="text/css">
label, input, textarea {display:block}
label {font-weight:bold}
</style>
<fieldset>
    <legend>验证通过</legend>
    <form id="frm-verify-pass" method="post" action="">
        订单号：<input type="text" id="verify-order_num" name="order_num" />
        <input type="submit" value="验证通过" onclick="return verify()" />
    </form>
</fieldset>
<fieldset>
    <legend>退款</legend>
    <form id="frm-refund" method="post" action="">
        订单号：<input type="text" id="refund-order_num" name="order_num" />
        退款金额：<input type="text" id="refund-amount" name="amount" />
        <input type="submit" value="退款" onclick="return refund()"/>
    </form>
</fieldset>
<script type="text/javascript">
function verify()
{
    $.ajax({
        type: 'POST', 
        url: '/admin/site/erp/proxy', 
        data: {
            order_num: $('#verify-order_num').val(), 
            payment_status_id: 26, 
            currency: 'USD', 
            admin_employee_name: 'liwei', 
            trans_id: 'erp-test', 
            context: 'erp-test', 
        }, 
        success: function (data) {
            if (data == 'SUCCESS')
            {
                window.alert('成功');
            }
            else
            {
                window.alert('失败');
            }
        }, 
    });

    return false;
}

function refund()
{
    $.ajax({
        type: 'POST', 
        url: '/admin/site/erp/proxy', 
        data: {
            order_num: $('#refund-order_num').val(), 
            payment_status_id: 6, 
            refund_amount: $('#refund-amount').val(), 
            currency: 'USD', 
            admin_employee_name: 'liwei', 
            trans_id: 'erp-test', 
            context: 'erp-test', 
        }, 
        success: function (data) {
            if (data == 'SUCCESS')
                window.alert('退款成功！');
            else
                window.alert("退款失败！");
        }, 
    });

    return false;
}
</script>
