<div id="do_content" class="box">
    <h3>编辑订单信息</h3><?php if(!$order['copy']): ?><button id="aa">复制订单</button><?php endif; ?>
    <script type="text/javascript">
        $("#aa").click(function(){      
                $('body').append('<div id="wingray1" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.9; z-index:99;"></div>');
                $('#remark_div').appendTo('body').fadeIn(320);
        })
		
        $("#order_from").live("change",function(){
            var  seval = $(this).val();
                    $.ajax({
            url: "/admin/site/order/copy/", 
            "type": "POST", 
            "dataType": "json", 
             "data":{'arr':[  
        {'seval':seval,'id':<?php echo $order['id']; ?>}]},  
            success: function(data) {
                if (data.a ==1){
					var st = new Array();
					var na = data.res;
					var a  = data.arrid;
					b = a.join(",");
					var message = '复制订单成功，其中id为'+b+'的产品因为状态为0,或者因为下架没有显示，复制后的订单号是'+na;
                    window.alert(message);   
					$('#remark_div').hide();
            $("#wingray1").hide();
	window.location.href="/admin/site/order/edit/"+na;
                }else if(data == -1){
                 window.alert('订单内含有状态为0的产品，无法复制');   
            $('#remark_div').hide();
            $("#wingray1").hide();
                }else if(data == -2){
                 window.alert('此订单为复制单，无法再次复制');   
            $('#remark_div').hide();
            $("#wingray1").hide();
                }
                else{
					alert(data)
                    window.alert('没有选择订单来源，如果没有请选择other');
                }
                }
              });
              
        })


        $("#close11").live("click",function(){
            $('#remark_div').hide();
            $("#wingray1").hide();


        })


    function erp_sync(order_id)
    {
        $.ajax({
            url: "/admin/site/order/erp_sync/"+order_id, 
            success: function(data) {
                if (data == 'success')
                    window.location.reload(true);
                else
                    window.alert(data);
            }
        });
    }
    function order_verify(order_id)
    {
        $.ajax({
            url: "/admin/site/order/verify/"+order_id, 
            success: function(data) {
                if (data == 'success')
                    window.location.reload(true);
                else
                    window.alert(data);
            }
        });
    }
    </script>
    <div id="remark_div" style="padding-bottom: 50px; padding-right: 50px; width: 742px; height: 318px; top: 15px; left: 330px;position: fixed;z-index: 109;margin-left: 0px;margin-top: 100px;display:none;">
    
                        <div style="padding:10px; background:#fff;" id="inline_example2">
                            <table style="width: 100%;">
                                <tbody id="remark_list">
                                <span style="color:red;font-size:22px;">请选择一下订单来源，选择后即可复制订单</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button id="close11">X</button>(点击X号即可关闭)  <br />  
                                   <select id="order_from" name="order_from" >
                                    <option value="">  </option>
                                          <?php $order_from=kohana::config("order_status.order_from");
                              foreach($order_from as $key=>$value){ ?>
                          <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                  <?php } ?>
                </select>
               </tbody>
                            </table>

                    </div>

    </div>
    <div id="order-edit-tabs">
        <ul>
            <li><a href="#order-edit-basic">基本信息</a></li>
            <li><a href="#order-edit-address">地址</a></li>
            <li><a href="#order-edit-payment">支付</a></li>
            <li><a href="#order-edit-shipment">发货</a></li>
            <li><a href="#order-edit-refund">退款</a></li>
            <li><a href="#order-edit-product">产品</a></li>
            <li><a href="#order-edit-remark">备注</a></li>
            <li><a href="#order-edit-history">历史</a></li>
        </ul>
        <div id="order-edit-basic">
            <?php print $order_edit_basic; ?>
        </div>
        <div id="order-edit-address">
            <?php print $order_edit_address; ?>
        </div>
        <div id="order-edit-payment">
            <?php print $order_edit_payment; ?>
        </div>
        <div id="order-edit-shipment">
            <?php print $order_edit_shipment; ?>
        </div>
        <div id="order-edit-refund">
            <?php print $order_edit_refund; ?>
        </div>
        <div id="order-edit-product">
            <?php print $order_edit_product; ?>
        </div>
        <div id="order-edit-remark">
            <?php print $order_edit_remark; ?>
        </div>
        <div id="order-edit-history">
            <?php print $order_edit_history; ?>
        </div>
    </div>
    <div style="margin-top:5px">
        <?php if (Site::instance()->erp_enabled() && $order['erp_header_id'] == 0): ?>
        <button id="btn-erp-sync" onclick="erp_sync(<?php echo $order['id']; ?>);">同步到ERP</button>
        <?php endif ?>
        <?php if ($order['is_verified']): ?>
        <h3 style="font-weight:bold;color:red;margin:10px">订单头信息已经验证通过</h3>
        <?php else: ?>
        <button id="btn-order-verify" onclick="order_verify(<?php echo $order['id']; ?>);">验证通过</button>
        <?php endif ?>
    </div>
    <script type="text/javascript">
        $('#order-edit-tabs').tabs({
            select: function(event, ui) {
                window.location.hash = ui.tab.href.split('#')[1];
            }
        });

        if (window.location.hash) {
            $('#order-edit-tabs').tabs('select', window.location.hash);
        }
    </script>
</div>
