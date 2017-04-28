<fieldset>
    <legend><strong>修改可用积分</strong></legend>
    <form id="frm-edit-point" method="post" action="/admin/site/customer/edit_point/<?php print $id; ?>">
        <label for="point_avail">可使用积分：</label>
        <input type="text" name="points" value="<?php print $point_avail; ?>" /><br/>
        <label for="point_pending">未激活积分：</label>
        <input type="text" value="<?php print $point_pending; ?>" readonly="readonly"/><br/>
        <label for="point_activated">已激活积分：</label>
        <input type="text" value="<?php print $point_activated; ?>" readonly="readonly"/><br/>
        <input type="submit" value="修改" />
    </form>
</fieldset>

<fieldset>
    <legend><strong>添加积分记录</strong></legend>
    <form id="frm-add-point-record" method="post" action="/admin/site/customer/add_point_record/<?php print $id; ?>">
        <label for="point_amount">积分数量：</label>
        <input type="text" id="point_amount" name="amount" /><br/>
        <label for="point_status">积分状态：</label>
        <select id="point_status" name="status">
            <option value="activated">已激活</option>
            <option value="pending">未激活</option>
        </select><br/>
        <label for="point_type">积分类型：</label>
        <select id="point_type" name="type">
            <option value="product_show">产品秀积分</option>
            <option value="review">评论奖励积分</option>
            <option value="feedback">互动反馈积分</option>
            <option value="promoting">推广奖励积分</option>
            <option value="register">注册赠送积分</option>
            <option value="order">购物赠送积分</option>
            <option value="affiliate">佣金兑换积分</option>
            <option value="compensation">订单补偿积分</option>
        </select><br/>
        <input type="submit" value="添加" />
    </form>
</fieldset>

<fieldset>
    <legend><strong>积分记录</strong></legend>
    <table>
        <tr>
            <th>日期</th>
            <th>数量</th>
            <th>类型</th>
            <th>状态</th>
            <th>操作者</th>
            <th>操作</th>
        </tr>
        <?php foreach ($point_records as $record): ?>
        <tr>
            <td><?php print date('Y-m-d', $record['created']); ?></td>
            <td><?php print $record['amount']; ?></td>
            <td><?php print $record['type']; ?></td>
            <td><?php print $record['status']; ?></td>
            <td>
                    <?php
                    if($record['user_id'])
                            print User::instance($record['user_id'])->get('name');
                    else
                            print $record['user_id'];
                    ?>
            </td>
            <td>
            <?php
            if(Session::instance()->get('user_id') == $record['user_id'] OR User::instance(Session::instance()->get('user_id'))->get('role_id') == 0)
            {
            ?>
                    <a href="/admin/site/customer/del_point_record/<?php print $record['id']; ?>" onclick="return window.confirm('delete?');">删除</a>
            <?php
            }
            ?>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
</fieldset>

<fieldset>
    <legend><strong>积分使用记录</strong></legend>
    <table>
        <tr>
            <th>日期</th>
            <th>订单号</th>
            <th>数量</th>
            <th>备注</th>
        </tr>
        <?php foreach ($point_payments as $payment): ?>
        <tr>
            <td><?php print date('Y-m-d', $payment['created']); ?></td>
            <td><?php print $payment['order_num']; ?></td>
            <td><?php print $payment['amount']; ?></td>
            <td><?php print $payment['note']; ?></td>
        </tr>
        <?php endforeach ?>
    </table>
</fieldset>
