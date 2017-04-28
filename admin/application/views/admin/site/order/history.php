<?php 
$order_status = array_merge(kohana::config('order_status.payment'), kohana::config('order_status.shipment'), kohana::config('order_status.refund'));
?>
<?php 
if($order_history)
{
?>
<div class="box">
        <h3>Order History</h3>
<table>
<tr>
<thead>
    <th class="col">Status</th>
    <th class="col">Admin</th>
    <th class="col">Comment</th>
    <th class="col">Time</th>
</thead>
</tr>
<?php 
    $order_status = Order::instance()->get_orderstatus();
    foreach($order_history as $oh)
    {
?>
<tr>
    <td><?php echo $oh['order_status']?($order_status[$oh['order_status']]['name']?$order_status[$oh['order_status']]['name']:$oh['order_status']):"";?></td>
    <td><?php echo $oh['admin_id'];?></td>
    <td><?php echo $oh['message'];?></td>
    <td><?php echo date('Y-m-d H:i:s', $oh['created']);?></td>
</tr>
<?php 
    }
?>
</table>
</li>
</ul>
</div>
<?php 
}
?>
