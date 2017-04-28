<h3>Affiliate Info</h3>
<div id="affiliate_basic">
    <form id="frm-affiliate-edit" method="post" action="/admin/site/customer/edit_affiliate/<?php print $id; ?>">
        <label for="affiliate_id">Affiliate ID: </label>
        <input type="text" readonly="readonly" value="<?php print $affiliate_id; ?>" /><br/>
        <label for="affiliate_level">Affiliate Level: </label>
        <select id="affiliate_level" name="level">
            <?php foreach ($affiliate_levels as $level => $rate): ?>
            <option value="<?php print $level; ?>" <?php if ($level == strtolower($affiliate_level)) { print 'selected="selected"'; } ?>><?php print $level; ?></option>
            <?php endforeach ?>
        </select><br/>
        <label for="affiliate_rate">Affiliate Rate: </label>
        <input type="text" id="affiliate_rate" name="rate" value="<?php print $affiliate_rate; ?>" /><br/>
        <input type="submit" value="Save" />
    </form>
</div>

<h3>Affiliate Records</h3>
<table id="affiliate_records">
    <tr>
        <th>Order Date</th>
        <th>Order No.</th>
        <th>Order Total</th>
        <th>Commission</th>
        <th>Status</th>
        <th>Note</th>
    </tr>
    <?php foreach ($affiliate_records as $record): ?>
    <tr>
        <td><?php print date('Y-m-d', $record['order_date']); ?></td>
        <td><?php print Order::instance($record['order_id'])->get('ordernum'); ?></td>
        <td><?php print Site::instance()->price($record['order_total'], 'code_view', $record['order_currency']); ?></td>
        <td><?php print Site::instance()->price($record['commission'], 'code_view', $record['order_currency']); ?></td>
        <td><?php print $record['status']; ?></td>
        <td><?php print $record['note']; ?></td>
    </tr>
    <?php endforeach ?>
</table>

<h3>Affiliate Payment Records</h3>
<table id="affiliate_payments">
    <tr>
        <th>Payment Date</th>
        <th>Paid Commission</th>
        <th>Note</th>
    </tr>
    <?php foreach ($affiliate_payments as $payment): ?>
    <tr>
        <td><?php print date('Y-m-d', $payment['created']); ?></td>
        <td><?php print '$'.number_format($payment['commission'], 2); ?></td>
        <td><?php print $payment['note']; ?></td>
    </tr>
    <?php endforeach ?>
</table>

<h3>Add Payment Records</h3>
<form id="frm-add-payment" method="post" action="/admin/site/customer/add_affiliate_payment/<?php print $id; ?>">
    <label for="payment_date">Paymente Date: </label>
    <input type="text" id="payment_date" name="date" value="<?php print date('Y-m-d'); ?>" /><br/>
    <label for="commission">Paid Commission: </label>
    <input type="text" id="commission" name="commission" /><br/>
    <label for="payment_note">Note: </label>
    <textarea id="paymente_note" name="note"></textarea><br/>
    <input type="submit" value="Add" />
</form>
