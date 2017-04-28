<?php 
$order_status = array_merge(kohana::config('order_status.payment'), kohana::config('order_status.shipment'), kohana::config('order_status.refund'));
?>
<?php if($histories): ?>
<table>
    <tr>
        <thead>
            <th class="col">动作</th>
            <th class="col">管理员ID</th>
            <th class="col">备注</th>
            <th class="col">时间</th>
        </thead>
    </tr>
    <?php foreach($histories as $history): ?>
    <tr>
        <td><?php print $history['order_status']; ?></td>
        <td><?php print User::instance($history['admin_id'])->get('name');?></td>
        <td><?php print $history['message'];?></td>
        <td><?php print date('Y-m-d H:i:s', $history['created']);?></td>
    </tr>
    <?php endforeach ?>
</table>
<?php else: ?>
<strong>无历史信息记录</strong>
<?php endif ?>
