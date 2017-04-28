<?php echo View::factory('admin/manage/left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>添加红人活动记录</h3>
        <form method="post" action="" id="form1">
            <table class="layout">
                <tr>
                    <td>红人ID</td>
                    <td><input id="name" type="text" name="celebrity_id" /></td>
                </tr>
                <tr>
                    <td>积分</td>
                    <td><input id="name" type="text" name="points" /></td>
                </tr>
                <tr>
                    <td>积分赠送时间</td>
                    <td><input id="name" type="text" name="points_date" /></td>
                </tr>
                <tr>
                    <td>所选产品SKU</td>
                    <td><input id="name" type="text" name="sku" /></td>
                </tr>
                <tr>
                    <td>订单号</td>
                    <td><input id="name" type="text" name="ordernum" /></td>
                </tr>
                <tr>
                    <td>发货时间</td>
                    <td><input id="name" type="text" name="shipping_date" /></td>
                </tr>
                <tr>
                    <td>到货时间</td>
                    <td><input id="name" type="text" name="delivery_date" /></td>
                </tr>
                <tr>
                    <td>推广链接</td>
                    <td><input id="name" type="text" name="spread_url" /></td>
                </tr>
                <tr>
                    <td>推广时间</td>
                    <td><input id="name" type="text" name="spread_date" /></td>
                </tr>
                <tr>
                    <td>推广效果</td>
                    <td><input id="name" type="text" name="spread_flow" /></td>
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
