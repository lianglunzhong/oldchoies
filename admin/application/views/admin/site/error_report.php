<?php echo View::factory('admin/site/feedback_left')->render(); ?>
<?php
$error_report_types = array(
    1 => 'Product description',
    2 => 'Product price',
    3 => 'Product image',
    4 => 'Product quality',
    5 => 'Others',
);
?>
<div id="do_right">
    <div class="box" style="overflow:hidden;">
        <h3>Error Report</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Email</th>
                    <th>Order No.</th>
                    <th>SKU</th>
                    <th>Type</th>
                    <th>Content</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($error_reports as $report): ?>
                <tr>
                    <td><?php echo date('Y-m-d', $report['time']); ?></td>
                    <td><?php echo $report['email']; ?></td>
                    <td><?php echo $report['ordernum']; ?></td>
                    <td><?php echo Product::instance($report['product_id'])->get('sku'); ?></td>
                    <td><?php echo $error_report_types[$report['type']]; ?></td>
                    <td><?php echo $report['content']; ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php print $pager; ?>
    </div>
</div>
