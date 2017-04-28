<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  My Coupons</div>
        </div>
        <?php echo Message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>My Coupons</h2></div>
            <ul class="JS_tab1 detail_tab detail_tab1 fix">
                <li class="on">Unused Coupons</li>
                <li>Coupon Used</li>
            </ul>
            <div class="JS_tabcon1 detail_tabcon">
                <div class="bd">
                    <table class="user_table">
                        <tr>
                            <th width="20%">Coupon Code</th>
                            <th width="10%">Coupon Type</th>
                            <th width="10%">Coupon Value</th>
                            <th width="20%">Terms & Conditions</th>
                            <th width="10%">Valid From</th>
                            <th width="10%">Expiration Date <a href="?sort=<?php echo isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'date1' : 'date'; ?>" class="icon_turn"></a></th>
                            <th width="10%">Created Date</th>
                        </tr>
                        <?php
                        $types = array(
                            1 => 'Discount',
                            2 => 'Reduce',
                            3 => 'Largess',
                            4 => 'Change');
                        foreach($coupons as $coupon):
                            $conditions = 'Any items with full price';
                            switch ($coupon['type'])
                            {
                                case 1:
                                    $value = $coupon['value'] . '% off';
                                    break;
                                case 2:
                                    $value = 'Reduce $' . $coupon['value'];
                                    break;
                                case 3:
                                    $value = 'Largess: ' . $coupon['item_sku'];
                                    break;
                                case 4:
                                    $value = 'Reduce Price To ' . $coupon['value'];
                                    break;
                            }
                            ?>
                        <tr>
                            <td><?php echo $coupon['code']; ?></td>
                            <td><?php echo $types[$coupon['type']]; ?></td>
                            <td><?php echo $value; ?></td>
                            <td><?php echo $conditions; ?></td>
                            <td><?php echo date('n/j/Y H:i:s', $coupon['created']); ?></td>
                            <td><?php echo date('n/j/Y H:i:s', $coupon['expired']); ?></td>
                            <td><?php echo date('n/j/Y H:i:s', $coupon['created']); ?></td>
                        </tr>
                        <?php
                        endforeach;
                        ?>
                    </table>
                    <?php echo $pagination; ?>
                </div>
                <div class="bd hide">
                    <table class="user_table">
                        <tr>
                            <th width="20%">Coupon Code</th>
                            <th width="10%">Coupon Type</th>
                            <th width="10%">Coupon Value</th>
                            <th width="20%">Terms & Conditions</th>
                            <th width="10%">Order Number</th>
                            <th width="10%">Saving</th>
                            <th width="10%">Used Date</th>
                        </tr>
                        <?php
                        foreach($used as $data):
                            $currency = Site::instance()->currencies($data['currency']);
                            ?>
                        <tr>
                            <td><?php echo $data['coupon_code']; ?></td>
                            <td> </td>
                            <td> </td>
                            <td>Any items with full price</td>
                            <td><a href="<?php echo LANGPATH; ?>/order/view/<?php echo $data['ordernum']; ?>"><?php echo $data['ordernum']; ?></a></td>
                            <td><?php echo $currency['code'] . $data['amount_coupon']; ?></td>
                            <td><?php echo date('n/j/Y H:i:s', $data['created']); ?></td>
                        </tr>
                        <?php
                        endforeach;
                        ?>
                    </table>
<!--                    <div class="fix">
                        <div class="page flr">
                            PAGE: <a href="#" class="prev_btn1">PRE</a> <a href="#" class="on">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a>   <a href="#" class="next_btn1">NEXT</a>
                        </div>
                    </div>-->
                </div>
            </div>
        </article>
        <?php echo View::factory('customer/left'); ?>
    </section>
</section>