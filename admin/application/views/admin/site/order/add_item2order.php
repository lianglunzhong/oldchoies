<div id="do_content">
    <form method="post" action="#" name="form_add_set" class="need_validation">
    <div class="box"><h3>创建采购单</h3>
        <ul>
            <li><label>Order Num:</label>
                <textarea id="ordernum" name="ordernum" class="short text required"></textarea>(一行一个订单号)
            </li>
            <li><label>SKU:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input id="sku" name="sku" value="" type="text" class="short text required" onblur="ajax_item( $(this).val() )"></li>
            <li><label id="atrbt">Attribute: </label>&nbsp;&nbsp;&nbsp;&nbsp;
                <select id="add-attr" name="attribute" style="width:260px" onchange="ajax_stock( $('#sku').val(),$(this).val() )"></select>
                <b id="stock"></b>
            </li>
            <li><button type="submit">Save</button></li>    
        </ul>
        
    </div>
    </form>
</div>
<script type="text/javascript">
function ajax_item(sku)
{
    var ordernum = $("#ordernum").val();
    if(ordernum.indexOf("PM") >=0){
        $("#add-attr").remove();
        $("#atrbt").after("&nbsp;&nbsp;&nbsp;&nbsp;<input id=\"add-attr\" name=\"attribute\" value=\"\" type=\"text\" class=\"short text required\">");
        $("#stock").html("");
        return false;
    }else{
        $("#add-attr").remove();
        $("#atrbt").after("&nbsp;&nbsp;&nbsp;&nbsp;<select id=\"add-attr\" name=\"attribute\" style=\"width:260px\" onchange=\"ajax_stock( $('#sku').val(),$(this).val() )\"></select>");
    }
    $.ajax({
        "url": "/admin/site/order/ajax_item/", 
        "type": "POST", 
        "dataType": "json", 
        "data": "sku="+sku, 
        "success": function (data) {
            if( data.length >= 1)
            {
                $("#add-attr").html('<option>- select -</option>');
            }else{
                $("#add-attr").html('');
            }
            $.each(data, function(i,val){      
                $("#add-attr").append('<option value="'+val+'">'+val+'</option>');
            });
            $("#stock").html('');
        },
        "error":function (){alert('error')}
    });
}

function ajax_stock(sku,attr)
{
    $.ajax({
        "url": "/admin/site/order/ajax_stock/", 
        "type": "POST", 
        "dataType": "json", 
        "data": {"sku":sku ,"attr":attr},
        "success": function (data) {
            $("#stock").html(data);
        },
        "error":function (){alert('error')}
    });
}
</script>


