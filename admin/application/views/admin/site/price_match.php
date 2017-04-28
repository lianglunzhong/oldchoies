<?php echo View::factory('admin/site/feedback_left')->render(); ?>
<div id="do_right">
    <div class="box" style="overflow:hidden;">
        <h3>Price Match</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Email</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>URL</th>
                    <th>Content</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($price_matches as $match): ?>
                <tr>
                    <td><?php echo date('Y-m-d', $match['time']); ?></td>
                    <td><?php echo $match['email']; ?></td>
                    <td><?php echo Product::instance($match['product_id'])->get('sku'); ?></td>
                    <td><?php echo $match['price']; ?></td>
                    <td><?php echo $match['url']; ?></td>
                    <td><?php echo $match['content']; ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php print $pager; ?>
    </div>
</div>
