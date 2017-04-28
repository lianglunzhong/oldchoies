<?php
$url = URL::current(0);
?>
<div>
    <div>
        <ul>
            <li>
            <?php
            if($url == '/admin/site/orderprocurement/list')
            {
            ?>
                <a href="/admin/site/orderprocurement/list">Orderprocurement List</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            }
            else
            {
            ?>
                <a href="/admin/site/orderprocurement/stock">Stock(库存表)</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="/admin/site/orderprocurement/outstock">In Stock/Out Stock表</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="/admin/site/orderprocurement/check_inventory">Check Inventory</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="/admin/site/orderprocurement/monthly_inventory">Monthly Inventory</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            }
            ?>
            </li>
        </ul>
    </div>
</div>