<?php echo View::factory('admin/manage/left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>编辑采购记录</h3>
        <form method="post" action="" id="form1">
            <table class="layout">
                <tr>
                    <td><label>SKU：</label></td>
                    <td><input id="name" type="text" name="sku" value="<?php echo Product::instance($log->product_id)->get('sku'); ?>"/></td>
                </tr>
                <tr>
                    <td><label>供货商：</label></td>
                    <td><input id="name" type="text" name="factory" value="<?php echo ORM::factory('factory', $log->factory_id)->name; ?>" /></td>
                </tr>
                <tr>
                    <td><label>数量：</label></td>
                    <td><input id="name" type="text" name="quantity" value="<?php echo $log->quantity; ?>"/></td>
                </tr>
                <tr>
                    <td><label>金额：</label></td>
                    <td><input id="name" type="text" name="amount" value="<?php echo $log->amount; ?>" /></td>
                </tr>
                <tr>
                    <td><label>是否缺货：</label></td>
                    <td>
                        <select name="status">
                            <option value="0" <?php echo $log->status == 0 ? 'selected' : ''; ?>>正常</option>
                            <option value="1" <?php echo $log->status == 1 ? 'selected' : ''; ?>>缺货</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Save" />
                        <a href="/admin/site/doc/list">Cancel</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
