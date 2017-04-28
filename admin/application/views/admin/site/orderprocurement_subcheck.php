<?php echo View::factory('admin/site/orderprocurement_left')->render(); ?>
<div id="do_content" class="box">
    <h3>Order Procurement Sub Check <?php echo date('Y-m-d', $date) . '-' . date('Y-m-d', $date_end) ?></h3>
    <table id="orderline-list">
        <tr>
            <th>Ordernum</th>
            <th>SKU</th>
            <th>Attributes</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Procurement SKU</th>
            <th>Procurement Attributes</th>
            <th>Procurement Quantity</th>
            <th>Procurement Price</th>
            <th>Ship Date</th>
        </tr>
        <?php foreach ($data as $d): ?>
        <tr>
            <td><?php print $d['ordernum']; ?></td>
            <td><?php print $d['sku']; ?></td>
            <td><?php print $d['attributes']; ?></td>
            <td><?php print $d['quantity']; ?></td>
            <td><?php print $d['price']; ?></td>
            <td><?php print $d['p_sku']; ?></td>
            <td><?php print $d['p_attributes']; ?></td>
            <td><?php print $d['p_quantity']; ?></td>
            <td><?php print $d['p_price']; ?></td>
            <td><?php print $d['ship_date']; ?></td>
        </tr>
        <?php endforeach ?>
    </table>
</div>
