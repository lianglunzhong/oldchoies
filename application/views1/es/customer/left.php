<?php
$url = URL::current(0);
$lists = array(
    'MIS PEDIDOS' => array(
        array(
            'name' => 'Historial de Pedidos',
            'link' => LANGPATH . '/customer/orders'
        ),
        array(
            'name' => 'Pedidos Pendientes de Pago',
            'link' => LANGPATH . '/customer/unpaid_orders'
        ),
        array(
            'name' => 'Items to review',
            'link' => '#'
        ),
        array(
            'name' => 'Lista de Deseos',
            'link' => LANGPATH . '/customer/wishlist'
        ),
        array(
            'name' => 'Rastrear Pedido',
            'link' => LANGPATH . '/tracks/track_order'
        ),
    ),
    'MI PERFIL' => array(
        array(
            'name' => 'Configuración de Cuenta',
            'link' => LANGPATH . '/customer/profile'
        ),
        array(
            'name' => 'Cambiar Contraseña',
            'link' => LANGPATH . '/customer/password'
        ),
        array(
            'name' => 'La Libreta de Direcciones',
            'link' => LANGPATH . '/customer/address'
        ),
        array(
            'name' => 'Crear una Dirección ',
            'link' => LANGPATH . '/address/add'
        )
    ),
    'PUNTOS Y CUPONES' => array(
        array(
            'name' => 'Historial de Puntos',
            'link' => LANGPATH . '/customer/points_history'
        ),
        array(
            'name' => 'Social Sharing Bonus',
            'link' => '#'
        ),
        array(
            'name' => 'Mis Cupones',
            'link' => LANGPATH . '/customer/coupons'
        ),
    ),
);

$customer_id = Customer::logged_in();
$email = Customer::instance($customer_id)->get('email');
$celebrity = DB::select('id')->from('celebrities_celebrits')->where('email', '=', $email)->execute()->get('id');
if ($celebrity)
{
    $lists['MI PERFIL'][] = array(
        'name' => 'Mi show del blog',
        'link' => '/es/customer/blog_show'
    );
}
?>
<aside id="aside" class="col-sm-3 col-xs-12 hidden-xs">
    <a href="<?php echo LANGPATH; ?>/customer/summary" class="user-home hidden-xs">RESUMEN DE CUENTA</a>
    <?php
    foreach ($lists as $title => $link):
        ?>
        <div class="category-box aside-box">
            <h3 class="bg"><?php echo $title; ?></h3>
            <ul class="scroll-list">
                <?php
                foreach ($link as $l):
                    if (!$l['link'] OR $l['link'] == '#')
                        continue;
                    ?>
                    <li><a  href="<?php echo $l['link']; ?>"<?php if ($url == $l['link']) echo ' class="on"'; ?>><?php echo $l['name']; ?></a></li>
                    <?php
                endforeach;
                ?>
            </ul>
        </div>
        <?php
    endforeach;
    ?>
    <a href="<?php echo LANGPATH; ?>/customer/logout" class="user-home">SALIR</a>
</aside>