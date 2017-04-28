<form id="frm-order-remark" action="/admin/site/order/remark/<?php print $id; ?>" method="post" style="margin-bottom:20px">
    <textarea name="remark" style="width:640px;height:120px;"></textarea>
    <br/><br/>
    <input type="radio" id="unmarked" name="is_marked" value="0" <?php print $is_marked ? '' : 'checked="checked"'; ?> />
    <label for="unmarked">正常单</label>
    <input type="radio" id="marked" name="is_marked" value="1" <?php print $is_marked ? 'checked="checked"' : ''; ?> />
    <label for="marked">异常单</label>
    <br/><br/>
    <input type="submit" name="_continue" value="添加并继续"/>
    <input type="submit" name="_save" value="添加"/>
</form>

<?php if($remarks): ?>
<table>
    <tr>
        <thead>
            <th class="col">备注</th>
            <th class="col">管理员</th>
            <th class="col">时间</th>
            <th class="col">IP</th>
            <th class="col">Action</th>
        </thead>
    </tr>
    <?php foreach($remarks as $remark): ?>
    <tr>
        <td><?php print $remark['remark']; ?></td>
        <td><?php print User::instance($remark['admin_id'])->get('name'); ?></td>
        <td><?php print date('Y-m-d H:i:s', $remark['created']); ?></td>
        <td><?php print long2ip($remark['ip']); ?></td>
        <td><a href="/admin/site/order/remark_delete/<?php echo $remark['id']; ?>">Delete</a></td>
    </tr>
    <?php endforeach ?>
</table>
<?php else: ?>
<div>
    <strong>无订单备注信息</strong>
</div>
<?php endif ?>
