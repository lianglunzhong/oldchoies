<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Homepage</a>  >  Meine Gutscheine</div>
        </div>
        <?php echo Message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Meine Gutscheine</h2></div>
            <ul class="JS_tab1 detail_tab detail_tab1 fix">
                <li class="on">Unbenutzte Gutscheine</li>
                <li>Verwendete Gutscheine</li>
            </ul>
            <div class="JS_tabcon1 detail_tabcon">
                <div class="bd">
                    <table class="user_table">
                        <tr>
                            <th width="20%">Gutschein Code</th>
                            <th width="10%">Gutschein Typ</th>
                            <th width="10%">Gutschein Wert</th>
                            <th width="20%">Allgemeine Geschäftsbedingungen</th>
                            <th width="10%">Gültig ab</th>
                            <th width="10%">Ablaufdatum <a href="?sort=<?php echo isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'date1' : 'date'; ?>" class="icon_turn"></a></th>
                            <th width="10%">Erstellungsdatum</th>
                        </tr>
                        <?php
                        $types = array(
                            1 => 'Rabatt',
                            2 => 'Reduzieren',
                            3 => 'Großzügigkeit',
                            4 => 'Änderung');
                        foreach($coupons as $coupon):
                            $conditions = 'Alle Artikel mit vollem Preis';
                            switch ($coupon['type'])
                            {
                                case 1:
                                    $value = $coupon['value'] . '% off';
                                    break;
                                case 2:
                                    $value = 'Reduzieren ' . Site::instance()->price($coupon['value'], 'code_view');
                                    break;
                                case 3:
                                    $value = 'Großzügigkeit: ' . $coupon['item_sku'];
                                    break;
                                case 4:
                                    $value = 'Reduzieren Preis bis ' . Site::instance()->price($coupon['value'], 'code_view');
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
                            <th width="20%">Gutschein Code</th>
                            <th width="10%">Gutschein Typ</th>
                            <th width="10%">Gutschein Wert</th>
                            <th width="20%">Allgemeine Geschäftsbedingungen</th>
                            <th width="10%">Bestellnummer</th>
                            <th width="10%">Einsparung</th>
                            <th width="10%">Verwendete Daten</th>
                        </tr>
                        <?php
                        foreach($used as $data):
                            $currency = Site::instance()->currencies($data['currency']);
                            ?>
                        <tr>
                            <td><?php echo $data['coupon_code']; ?></td>
                            <td> </td>
                            <td> </td>
                            <td>Alle Artikel mit vollem Preis</td>
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
        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
    </section>
</section>