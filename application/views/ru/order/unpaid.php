<!-- main begin -->
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Home</a>  >  Неоплаченные Заказы</div>
            <?php echo Message::get(); ?>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Неоплаченные Заказы</h2></div>
            <?php
            if (empty($orders)):
                $user_id = Customer::logged_in();
                $firstname = Customer::instance($user_id)->get('firstname');
                ?>
                <p class="mb25"><?php echo $firstname ? ucfirst($firstname) : 'Choieser'; ?>, У вас нет заказов.Теперь вы можете делать покупки на Choies с 15% off купоном. </p>
                <?php
            else:
                ?>
                <table class="user_table user_table1">
                    <tr class="first">
                        <th width="25%">Детали товаров</th>
                        <th width="10%">Цена</th>
                        <th width="5%">Количество</th>
                        <th width="10%"></th>
                        <th width="5%">Стоимость доставки</th>
                        <th width="12%">Итого заказа</th>
                        <th width="18%">Статус Заказа</th>
                        <th width="20%">Действие</th>
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
                            <th colspan="8">Номер заказа: <b><?php echo $order['ordernum']; ?></b>    <span>Дата заказа: <?php echo date('n/j/Y H:i:s', $order['created']); ?></span></th>
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
                                                    $amount += $p['price'] * $p['quantity'] * $order['rate'];
                                                    $has = 1;
                                                    break;
                                                }
                                            }
                                            if (!$has)
                                                $outstock = 1;
                                        }
                                        else
                                        {
                                            $amount += $p['price'] * $p['quantity'] * $order['rate'];
                                        }
                                        ?>
                                        <tr>
                                            <td width="45%">
                                                <div class="fix">
                                                    <div class="left"><a href="<?php echo LANGPATH; ?>/product/<?php echo $product['link']; ?>"><img src="<?php echo image::link(Product::instance($p['product_id'])->cover_image(), 3); ?>" /></a></div>
                                                    <div class="right">
                                                        <a href="<?php echo LANGPATH; ?>/product/<?php echo $product['link']; ?>" class="name"><?php echo $product['name']; ?></a>
                                                        <?php if ($outstock): ?><p class="red">(Нет в наличии)</p><?php endif; ?>
                                                        <p>
                                                            <?php
                                                            $attributes = str_replace(';', ';<br>', $p['attributes']);
                                                            $attributes = str_replace('one size', 'только один размер', $attributes);
                                                            $attributes = str_replace(array('Size', 'Color'), array('Размеры', 'Цвет'), $attributes);
                                                            echo $attributes;
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td width="20%"><p class="red"><?php echo $currency['code'] . round($p['price'] * $order['rate'], 2); ?></p></td>
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
                                        $status = 'Неоплаченный(Новый)';
                                    echo $status;
                                    ?>
                                </b>
                            </td>
                            <td width="15%">
                                <?php
                                if ($amount > 0)
                                {
                                    ?>
                                    <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="btn22_red bold mb10">Платить</a>
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