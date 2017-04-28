<form id="frm-order-refund" action="/admin/site/order/status/<?php print $id; ?>" method="post">
    <table style="width:480px">
        <tr>
            <td><strong>当前状态：</strong></td>
            <td><?php print $current_status ? $current_status['name']."(".$current_status['description'].")" : '-'; ?></td>
        </tr>
        <tr>
            <td><strong>修改为：</strong></td>
            <td>
                <select name="refund_status">
                    <?php if ($current_status): ?>
                    <?php $current_status['refund'] = (array)$current_status['refund']; foreach($current_status['refund'] as $status): ?>
                    <option value="<?php print $status; ?>"><?php print $refund_status[$status]['name'].'('.$refund_status[$status]['description'].')'; ?></option>
                    <?php endforeach ?>
                    <?php else: ?>
                    <?php foreach(array_keys($refund_status) as $status): ?>
                    <option value="<?php print $status; ?>"><?php print $refund_status[$status]['name'].'('.$refund_status[$status]['description'].')'; ?></option>
                    <?php endforeach ?>
                    <?php endif ?>
                </select>
            </td>
        </tr>
        <tr>
            <td style="vertical-align:top"><label for="comment"><strong>备注：</strong></label></td>
            <td><textarea id="comment" name="comment" style="width:360px;height:120px"></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" name="_continue" value="修改并继续" />
                <input type="submit" name="_save" value="修改" />
            </td>
        </tr>
    </table>
</form>
