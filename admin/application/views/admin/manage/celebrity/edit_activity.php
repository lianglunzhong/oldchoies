<?php echo View::factory('admin/manage/left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>编辑红人活动记录</h3>
        <form method="post" action="" id="form1">
            <table class="layout">
                <tr>
                    <td>红人ID</td>
                    <td><input id="name" type="text" name="celebrity_id" value="<?php echo $activity->celebrity_id; ?>"/></td>
                </tr>
                <tr>
                    <td>积分</td>
                    <td><input id="name" type="text" name="points" value="<?php echo $activity->points; ?>" /></td>
                </tr>
                <tr>
                    <td>积分赠送时间</td>
                    <td><input id="name" type="text" name="points_date" value="<?php echo $activity->points_date; ?>" /></td>
                </tr>
                <tr>
                    <td>所选产品SKU</td>
                    <?php
                    $productIds = explode(',', $activity->product_id);
                    $productArr = array();
                    foreach($productIds as $pid)
                    {
                        $product = ORM::factory('product', $pid);
                        if($product->loaded())
                        {
                            $productArr[] = $product->sku;
                        }
                    }
                    $products = implode(',', $productArr);
                    ?>
                    <td><input id="name" type="text" name="sku" value="<?php echo $products; ?>" /></td>
                </tr>
                <tr>
                    <td>订单号</td>
                    <td><input id="name" type="text" name="ordernum" value="<?php echo $activity->ordernum; ?>" /></td>
                </tr>
                <tr>
                    <td>发货时间</td>
                    <td><input id="name" type="text" name="shipping_date" value="<?php echo $activity->shipping_date; ?>" /></td>
                </tr>
                <tr>
                    <td>到货时间</td>
                    <td><input id="name" type="text" name="delivery_date" value="<?php echo $activity->delivery_date; ?>" /></td>
                </tr>
                <tr>
                    <td>推广链接</td>
                    <td><input id="name" type="text" name="spread_url" value="<?php echo $activity->spread_url; ?>" /></td>
                </tr>
                <tr>
                    <td>推广时间</td>
                    <td><input id="name" type="text" name="spread_date" value="<?php echo $activity->spread_date; ?>" /></td>
                </tr>
                <tr>
                    <td>推广效果</td>
                    <td><input id="name" type="text" name="spread_flow" value="<?php echo $activity->spread_flow; ?>" /></td>
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
