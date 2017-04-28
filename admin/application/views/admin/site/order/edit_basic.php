<table id="tbl-order-basic">
    <tr>
        <td colspan="3"><strong>订单信息</strong></td>
    </tr>
    <tr>
        <td>订单号：<?php print $order['ordernum']; ?></td>
        <td>下单日期：<?php print date('Y-m-d', $order['created']); ?></td>
        <td>最后修改：<?php print date('Y-m-d', $order['updated']); ?></td>
    </tr>
    <tr>
        <td>产品总价：<?php print $order['amount_products']; ?></td>
        <td>
            <form action="/admin/site/order/amount_shipping/<?php print $id; ?>" method="post">
            运费：<input type="text" name="amount_shipping" value="<?php print $order['amount_shipping']; ?>" />
            <input type="submit" value="修改运费" />
            </form>
        </td>
        <td>
            <span style="color:green">使用积分：<?php if($site_id==4){ print "{$order['points']} = $".$order['points']*0.05;} else{print "{$order['points']} = $".$order['points']*0.01;} ?></span>
        </td>
    </tr>
    <?php if($site_id == 4 && $custom_made != 0) {?>
    <tr>
        <td colspan="3">定制费用：<?php print $custom_made; ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td><strong>合计：<?php print $order['amount']; ?></strong></td>
        <td>币种：
    <form action="/admin/site/order/amount_ccy/<?php print $id; ?>" method="post">
    <select name="ccy">
    <?php 
    //ccy
    $sys_currencies = Site::instance()->currencies();
    ?>
    
    <?php foreach ($sys_currencies as $key => $ccy):?>
    <?php if ($key == $order['currency']):?> 
    <option value="<?php echo $key;?>" selected="selected"><?php echo $key;?></option>
		<?php else:?>
	    <option value="<?php echo $key;?>" ><?php echo $key;?></option>
		<?php endif;?>
    <?php endforeach;?>
    </select>
            
            <input type="submit" value="修改币种 " />
            </form>
        </td>
        <td>对美元汇率：<?php print $order['rate']; ?></td>
    </tr>
    <tr>
        <td>运费险：<?php print  isset($order['order_insurance'])?$order['order_insurance']:""; ?></td>
        <td>支付方式：<?php print $order['payment_method']; ?></td>
        <td>支付状态：<?php print isset($payment_status[$order['payment_status']]) ? $payment_status[$order['payment_status']]['name'] : ''; ?></td>
        <td></td>
    </tr>
    <tr>
        <td <?php if ($order['shipping_method'] == 'HKPT-Free-for-15') {print 'style="color:red"';}?>>发货方式：<?php print $order['shipping_method']; ?></td>
        <td>发货状态：<?php print isset($shipment_status[$order['shipping_status']]) ? $shipment_status[$order['shipping_status']]['name'] : ''; ?></td>
        <td>货物重量：<?php print $order['shipping_weight']; ?> (克)</td>
    </tr>
    <tr>
        <?php 
        $coupon_code = '无';
        $coupon_type = '';
        $coupon_value = '';
        if ($order['coupon_code']) 
        {
            $coupon_code = $order['coupon_code'];

            $coupon = Coupon::instance($coupon_code);
            if ($coupon->get('id'))
            {
                $coupon_type = $coupon->get('type');
                switch ($coupon_type) 
                {
                case 1:
                    $coupon_type = '折扣为百分比';
                    $coupon_value = '折扣值：'.$coupon->get('value');
                    break;
                case 2:
                    $coupon_type = '折扣为价格';
                    $coupon_value = '折扣值：'.$coupon->get('value');
                    break;
                case 3:
                    $coupon_type = '折扣为赠品';
                    $coupon_value = '赠品SKU: '.$coupon->get('item_sku');
                    break;
                case 4:
                    $coupon_type = '折扣为改价';
                    $coupon_value = '价格改为: '.$coupon->get('value');
                    break;
                }
            }
        }
        ?>
        <td>折扣号：<?php print $coupon_code; ?></td>
        <td>折扣类型：<?php print $coupon_type; ?></td>
        <td><?php print $coupon_value; ?></td>
    </tr>
    <tr>
        <td>订单来源：<?php print $order['order_from']; ?></td>
        <td>购物车促销：<br>
        <?php
        $promotions = unserialize($order['promotions']);

        if(isset($promotions['cart']))
        {
            foreach($promotions['cart'] as $p)
            {   
                    $psave = '';
                if(isset($p['save']))
                {
                    $psave = $p['save'];
                }
                echo '<strong>log</strong>: "' . $p['log'] . '"<br><strong>save</strong>: $' . $psave;
                echo '<br>';
            }
        }
        ?>
        </td>
        <td></td>
    </tr>
    <tr>
        <td colspan="3"><strong>客户信息</strong></td>
    </tr>
    <tr>
        <td>姓名：<?php print $customer['firstname'] . ' '; print $customer['lastname']; ?></td>
        <td>电子邮件：<?php print $customer['email']; ?></td>
        <td>客户ID：<?php print $customer['id']; ?></td>
    </tr>
    <tr>
        <td>IP地址：<?php print long2ip($order['ip']); ?></td>
        <td>注册日期：<?php print date('Y-m-d', $customer['created']); ?></td>
        <td>Mobile订单：<?php print $order['erp_fee_line_id'] ? 'Yes' : 'No'; ?></td>
    </tr>
</table>
