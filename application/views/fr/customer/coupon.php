<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Accueil</a>  >  Mes Coupons</div>
        </div>
        <?php echo Message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Mes Coupons</h2></div>
            <ul class="JS_tab1 detail_tab detail_tab1 fix">
                <li class="on">Coupons Inutilisés</li>
                <li>Coupons Utilisés</li>
            </ul>
            <div class="JS_tabcon1 detail_tabcon">
                <div class="bd">
                    <table class="user_table">
                        <tr>
                            <th width="20%">Code de coupons</th>
                            <th width="10%">Type de coupons</th>
                            <th width="10%">Valeur de coupons</th>
                            <th width="20%">Termes & Conditions</th>
                            <th width="10%">Valable à partie de</th>
                            <th width="10%">Date d’expiration <a href="?sort=<?php echo isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'date1' : 'date'; ?>" class="icon_turn"></a></th>
                            <th width="10%">Date de Création</th>
                        </tr>
                        <?php
                        $types = array(
                            1 => 'Remise',
                            2 => 'Réduction',
                            3 => 'largesse',
                            4 => 'changement');
                        foreach($coupons as $coupon):
                            $conditions = 'Tous les articles à plein tarif';
                            switch ($coupon['type'])
                            {
                                case 1:
                                    $value = $coupon['value'] . '% de réduction';
                                    break;
                                case 2:
                                    $value = 'de réduction ' . Site::instance()->price($coupon['value'], 'code_view');
                                    break;
                                case 3:
                                    $value = 'largesse: ' . $coupon['item_sku'];
                                    break;
                                case 4:
                                    $value = 'réduire le prix pour ' . Site::instance()->price($coupon['value'], 'code_view');
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
                            <th width="20%">Code de coupons</th>
                            <th width="10%">Type de coupons</th>
                            <th width="10%">Valeur de coupons</th>
                            <th width="20%">Termes & Conditions</th>
                            <th width="10%">Numéro de Commande</th>
                            <th width="10%">Économiser</th>
                            <th width="10%">Date de l’utilisation</th>
                        </tr>
                        <?php
                        foreach($used as $data):
                            $currency = Site::instance()->currencies($order['currency']);
                            ?>
                        <tr>
                            <td><?php echo $data['coupon_code']; ?></td>
                            <td> </td>
                            <td> </td>
                            <td>Tous les articles à plein tarif</td>
                            <td><a href="<?php echo LANGPATH; ?>/order/view/<?php echo $data['ordernum']; ?>"><?php echo $data['ordernum']; ?></a></td>
                            <td><?php echo $currency['code'] . $data['amount_coupon']; ?></td>
                            <td><?php echo date('n/j/Y H:i:s', $data['created']); ?></td>
                        </tr>
                        <?php
                        endforeach;
                        ?>
                    </table>
                </div>
            </div>
        </article>
        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
    </section>
</section>