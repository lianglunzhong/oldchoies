<style type="text/css">
    #tbl-order-address input[type=text] {width:332px;}
</style>
<form id="frm-order-address" action="/admin/site/order/address/<?php print $id; ?>" method="post">
    <table id="tbl-order-address">
        <thead>
            <tr>
                <th scope="col">&nbsp;</td>
                <th scope="col">Shipping Address</td>
                <th scope="col">Billing Address</td>
            </tr>
        </thead>
        <tr>
            <td>First Name：</td>
            <td><input type="text" class="required" name="shipping_firstname" value="<?php print $order['shipping_firstname']; ?>"/></td>
            <td><input type="text" class="required" name="billing_firstname" value="<?php print $order['billing_firstname']; ?>"/></td>
        </tr>
        <tr>
            <td>Last Name：</td>
            <td><input type="text" class="required" name="shipping_lastname" value="<?php print $order['shipping_lastname']; ?>"/></td>
            <td><input type="text" class="required" name="billing_lastname" value="<?php print $order['billing_lastname']; ?>"/></td>
        </tr>
        <tr>
            <td>Address：</td>
            <td><input type="text" class="required" name="shipping_address" value="<?php print $order['shipping_address']; ?>"/></td>
            <td><input type="text" class="required" name="billing_address" value="<?php print $order['billing_address']; ?>"/></td>
        </tr>
        <tr>
            <td>City：</td>
            <td><input type="text" class="required" name="shipping_city" value="<?php print $order['shipping_city']; ?>"/></td>
            <td><input type="text" class="required" name="billing_city" value="<?php print $order['billing_city']; ?>"/></td>
        </tr>
        <tr>
            <td>State/Province：</td>
            <td><input type="text" class="required" name="shipping_state" value="<?php print $order['shipping_state']; ?>"/></td>
            <td><input type="text" class="required" name="billing_state" value="<?php print $order['billing_state']; ?>"/></td>
        </tr>
        <tr>
            <td>Zip/Postal code：</td>
            <td><input type="text" class="required" name="shipping_zip" value="<?php print $order['shipping_zip']; ?>"/></td>
            <td><input type="text" class="required" name="billing_zip" value="<?php print $order['billing_zip']; ?>"/></td>
        </tr>
        <tr>
            <td>Country：</td>
            <td>
            <?php
            if(strlen($order['shipping_country']) > 3)
            {
            ?>
                <input type="text" class="required" name="shipping_country" value="<?php echo $order['shipping_country']; ?>" />
            <?php
            }
            else
            {
                ?>
                <select class="required" name="shipping_country">
                    <option></option>
                <?php foreach ($countries as $c): ?>
                    <option value="<?php print $c['isocode']; ?>" <?php print $c['isocode'] == $order['shipping_country'] ? "selected" : ""; ?>><?php print $c['name']; ?></option>
                <?php endforeach; ?>
                </select>
                <?php
            }
            ?>
            </td>
            <td>
                <select class="required" name="billing_country">
                <?php foreach( $countries as $c ): ?>
                    <option value="<?php print $c['isocode']; ?>" <?php print $c['isocode'] == $order['billing_country'] ? "selected" : ""; ?>><?php print $c['name']; ?></option>
                <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Home Phone：</td>
            <td><input class="required" type="text" class="required" name="shipping_phone" value="<?php print $order['shipping_phone']; ?>"/></td>
            <td><input class="required" type="text" class="required" name="billing_phone" value="<?php print $order['billing_phone']; ?>"/></td>
        </tr>

        <!-- <tr>
            <td>Cell Phone：</td>
            <td><input type="text" name="shipping_mobile" value="<?php print $order['shipping_mobile']; ?>"/></td>
            <td><input type="text" name="billing_mobile" value="<?php print $order['billing_mobile']; ?>"/></td>
        </tr> -->
        <tr>
            <td></td>
            <td colspan="2">
                <input type="checkbox" name="isdefault" value="1"  />设置为客户默认地址
                <input type="submit" name="_continue" value="Save And Continue"/>
                <input type="submit" name="_save" value="Save"/>
            </td>
        </tr>
    </table>
</form>
