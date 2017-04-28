<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Página de Inicio</a>  >  Mis Cupones</div>
        </div>
        <?php echo Message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Mis Cupones</h2></div>
            <ul class="JS_tab1 detail_tab detail_tab1 fix">
                <li class="on">Cupónes No Usados</li>
                <li>Cupónes Usados</li>
            </ul>
            <div class="JS_tabcon1 detail_tabcon">
                <div class="bd">
                    <table class="user_table">
                        <tr>
                            <th width="20%">Código De Descuento</th>
                            <th width="10%">Cupón Tipo</th>
                            <th width="10%">Valor De Cupón</th>
                            <th width="20%">Términos Y Condiciones</th>
                            <th width="10%">Validez Desde</th>
                            <th width="10%">Fecha De Vencimiento<a href="?sort=<?php echo isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'date1' : 'date'; ?>" class="icon_turn"></a></th>
                            <th width="10%">Fecha De Creación</th>
                        </tr>
                        <?php
                        $types = array(
                            1 => 'Descuento',
                            2 => 'Reducción',
                            3 => 'Largueza',
                            4 => 'Cambiar');
                        foreach($coupons as $coupon):
                            $conditions = 'Cualquier artículo con el precio completo';
                            switch ($coupon['type'])
                            {
                                case 1:
                                    $value = $coupon['value'] . '% menos';
                                    break;
                                case 2:
                                    $value = 'Reducción ' . Site::instance()->price($coupon['value'], 'code_view');
                                    break;
                                case 3:
                                    $value = 'Largueza: ' . $coupon['item_sku'];
                                    break;
                                case 4:
                                    $value = 'Cambiar a precio de ' . Site::instance($coupon['value'], 'code_view');
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
                            <th width="20%">Código De Descuento</th>
                            <th width="10%">Cupón Tipo</th>
                            <th width="10%">Valor De Cupón</th>
                            <th width="20%">Términos Y Condiciones</th>
                            <th width="10%">Numero de pedido</th>
                            <th width="10%">Ahorro</th>
                            <th width="10%">Fecha Usado</th>
                        </tr>
                        <?php
                        foreach($used as $data):
                            $currency = Site::instance()->currencies($data['currency']);
                            ?>
                        <tr>
                            <td><?php echo $data['coupon_code']; ?></td>
                            <td> </td>
                            <td> </td>
                            <td>Cualquier artículo con el precio completo</td>
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