<div id="do_content" class="box">
    <h3>配货单<?php echo $date.' '.$date_end; ?></h3>
    <?php if (!empty($data)): ?>
    <table>
        <tr>
            <th style="width:100px;">OrderNum</th>
            <th style="width:400px;" align="center">Remark</th>
            <th>&nbsp;</th>
        </tr>
        <?php foreach ($data as $order): ?>
        <tr>
            <td><?php print $order['ordernum']; ?></td>
            <td>
                <?php if(isset($order['remarks'])) { ?>
                <table>
                    <?php foreach ($order['remarks'] as $remark): ?>
                    <tr>
                        <td style="width:300px;"><?php echo $remark['remark']; ?></td>
                        <td style="width:100px;"><?php echo $remark['admin']; ?></td>
                    </tr>
                    <?php endforeach ?>
                </table>
                <?php } ?>
            </td>
            <td>
<table>
    <?php foreach ($order['items'] as $item): ?>
<?php 
$product = new Product($item['id']);
 ?>
    <tr>
        <td style="width:100px;"><?php print $item['sku']; ?></td>
        <td style="width:80px;"><?php print $item['quantity']; ?></td>
        <td style="width:200px;"><img src="<?php print Image::link($product->cover_image(),3); ?>"/></td>

<td>
<?php print html::anchor('/admin/site/product/edit/'.$product->get('id'), $product->get('name'), array('target'=>'_blank')); ?>
</td>

    </tr>
    <?php endforeach ?>
</table>
</td>
        </tr>
    <?php endforeach ?>
    </table>
    <?php else: ?>
    <strong>没有需要采购的订单</strong>
    <?php endif ?>
</div>
    <h3><?php echo $date.' '.$date_end; ?></h3>
