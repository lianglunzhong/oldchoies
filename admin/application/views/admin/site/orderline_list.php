<div id="do_content" class="box">
    <h3>Orderline</h3>
    <fieldset style="text-align:right">
        <legend style="font-weight:bold">Filter</legend>
        <form id="frm-customer-export" method="post" action="">
            <label for="orderno-start">Order Number From: </label>
            <input type="text" name="orderno_from" class="ui-widget-content ui-corner-all" />
            <label for="orderno-to">Order Number To: </label>
            <input type="text" name="orderno_to" class="ui-widget-content ui-corner-all" />
            <br/>
            <label for="export-start">Order Date From: </label>
            <input type="text" name="from" id="export-start" class="ui-widget-content ui-corner-all" />
            <label for="export-end">Order Date To: </label>
            <input type="text" name="to" id="export-end" class="ui-widget-content ui-corner-all" />
            <label for="filter-status">Shipment Status: </label>
            <select id="filter-status" name="status">
                <option value="">All</option>
                <option value="Entered">Entered</option>
                <option value="Booked">Booked</option>
                <option value="Picked">Picked</option>
                <option value="Supply Partial">Supply Partial</option>
                <option value="Supply Eligible">Supply Eligible</option>
                <option value="Awaiting Shipping">Awaiting Shipping</option>
                <option value="Awaiting Return">Awaiting Return</option>
                <option value="Cancelled">Cancelled</option>
                <option value="Closed">Closed</option>
                <option value="加工完成">加工完成</option>
                <option value="生产中">生产中</option>
                <option value="已出厂">已出厂</option>
            </select>
            <input type="submit" value="Filter" class="ui-button" style="padding:0 .5em" />
        </form>
    </fieldset>
    <script type="text/javascript">
    $('#export-start, #export-end').datepicker({
        'dateFormat': 'yy-mm-dd', 
    });
    </script>
    <table id="orderline-list">
        <tr>
            <th>Order Date</th>
            <th>Order No.</th>
            <th>Name</th>
            <th>SKU</th>
            <th>Product Price</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Cost</th>
            <th>Weight</th>
            <th>Status</th>
        </tr>
        <?php foreach ($orderlines as $item): ?>
        <tr>
            <td><?php print date('Y-m-d', $item['created']); ?></td>
            <td><?php print Order::instance($item['order_id'])->get('ordernum'); ?></td>
            <td><?php print isset($item['name']) ? (html::anchor($item['link'], $item['name'])) : (html::anchor($item['link'], product::instance($product['id'])->get('name'))); ?></td>
            <td><?php print isset($item['sku']) ? $item['sku']:(product::instance($product['id'])->get('sku')); ?>
            </td>
            <td><?php print Product::instance($item['item_id'])->price(1); ?></td>
            <td><?php print $item['price']; ?></td>
            <td><?php print $item['quantity']; ?></td>
            <td><?php print Product::instance($item['item_id'])->get('cost'); ?></td>
            <td><?php print Product::instance($item['item_id'])->get('weight'); ?></td>
            <td>
                <?php print $item['erp_line_status']; ?>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
</div>
