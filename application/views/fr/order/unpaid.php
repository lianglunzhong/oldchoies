<!-- main begin -->
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Accueil</a>  >  Commandes Non Payées</div>
            <?php echo Message::get(); ?>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Commandes Non Payées</h2></div>
            <?php
            if (empty($orders)):
                $user_id = Customer::logged_in();
                $firstname = Customer::instance($user_id)->get('firstname');
                ?>
                <p class="mb25"><?php echo $firstname ? ucfirst($firstname) : 'Choieser'; ?>, Vous n'avez pas de commandes. Il est temps de faire quelques achats sur Choies avec votre coupon-rabais de 15% maintenant</p>
                <?php
            else:
                ?>
                <table class="user_table user_table1">
                    <tr class="first">
                        <th width="25%">Détails De Produit</th>
                        <th width="10%">Prix</th>
                        <th width="5%">QTÉ</th>
                        <th width="10%"></th>
                        <th width="5%">Livraison</th>
                        <th width="12%">Total</th>
                        <th width="18%">Statut De Commande</th>
                        <th width="20%">Action</th>
                    </tr>
                </table>
                <?php
                foreach ($orders as $order):
                    $currency = Site::instance()->currencies($order['currency']);
                    $status = $order['payment_status'];
                    $d_amount = 0;
                    $amount = 0;
                    $products = Order::instance($order['id'])->products();
                    if (empty($products))
                        continue;
                    ?>
                    <table class="user_table user_table1">
                        <tr class="second">
                            <th colspan="8">No. De Commande: <b><?php echo $order['ordernum']; ?></b> <span>Date De Commande: <?php echo date('n/j/Y H:i:s', $order['created']); ?></span></th>
                        </tr>
                        <tr>
                            <td colspan="4" width="45%" class="table2_box">
                                <table class="table2" width="100%">
                                    <?php
                                    foreach ($products as $p):
                                        if($p['status'] == 'cancel')
                                            continue;
                                        $product = DB::select('stock', 'visibility', 'status', 'sku', 'name', 'link')->from('products_' . LANGUAGE)->where('id', '=', $p['product_id'])->execute()->current();
                                        $outstock = 0;
                                        if (!$product['visibility'] OR !$product['status'] OR $product['stock'] == 0)
                                        {
                                            $outstock = 1;
                                        }
                                        elseif ($product['stock'] == -1)
                                        {
                                            $stocks = DB::select()
                                                    ->from('products_stocks')
                                                    ->where('product_id', '=', $p['product_id'])
                                                    ->where('stocks', '<>', 0)
                                                    ->execute();
                                            $has = 0;
                                            foreach ($stocks as $stock)
                                            {
                                                if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                                {
                                                    if ($p['quantity'] > $stock['stocks'])
                                                        $p['quantity'] = $stock['stocks'];
                                                    $amount += $p['price'] * $p['quantity'];
                                                    $has = 1;
                                                    break;
                                                }
                                            }
                                            if (!$has)
                                                $outstock = 1;
                                        }
                                        else
                                        {
                                            $amount += $p['price'] * $p['quantity'];
                                        }
                                        ?>
                                        <tr>
                                            <td width="45%">
                                                <div class="fix">
                                                    <div class="left"><a href="<?php echo LANGPATH; ?>/product/<?php echo $product['link']; ?>"><img src="<?php echo image::link(Product::instance($p['product_id'])->cover_image(), 3); ?>" /></a></div>
                                                    <div class="right">
                                                        <a href="<?php echo LANGPATH; ?>/product/<?php echo $product['link']; ?>" class="name"><?php echo $product['name']; ?></a>
                                                        <?php if ($outstock): ?><p class="red">(En rupture de stock)</p><?php endif; ?>
                                                        <p>
                                                            <?php
                                                            $attributes = str_replace(';', ';<br>', $p['attributes']);
                                                            $attributes = str_replace('one size', 'taille unique', $attributes);
                                                            $attributes = str_replace(array('Size', 'Color'), array('Taille', 'Couleur'), $attributes);
                                                            echo $attributes;
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td width="20%"><p class="red"><?php echo Site::instance()->price($p['price'], 'code_view', NULL, $currency); ?></p></td>
                                            <td width="10%"><?php echo $p['quantity']; ?></td>
                                            <td width="15%"><a href="#" class="a_underline"></a></td>
                                        </tr>
                                        <?php
                                    endforeach;
                                    $amount_order = $amount + $order['amount_shipping'];
                                    if ($amount_order > $order['amount'])
                                        $amount_order = $order['amount'];
                                    if (in_array($order['payment_status'], array('new', 'failed')) AND $amount == 0)
                                        $amount_order = $order['amount'];
                                    ?>
                                </table>
                            </td>
                            <td width="8%"><?php echo $currency['code'] . round($order['amount_shipping'], 2); ?></td>
                            <td width="12%"><?php echo $currency['code'] . round($amount_order, 2); ?></td>
                            <td width="15%">
                                <b>
                                    <?php
                                    $status = kohana::config('order_status.payment.' . $order['payment_status'] . '.name');
                                    if ($status == 'New' OR $status == 'new')
                                        $status = 'Non Payé (Nouveau)';
                                    echo $status;
                                    ?>
                                </b>
                            </td>
                            <td width="15%">
                                <?php
                                if ($amount > 0)
                                {
                                    ?>
                                    <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="btn22_red bold mb10">Payer</a>
                                <?php
                                } 
                                ?>
                            </td>
                        </tr>
                    </table>
                <?php endforeach; ?>
                <?php echo $pagination; ?>
            <?php
            endif;
            ?>  
        </article>
        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
    </section>
</section>