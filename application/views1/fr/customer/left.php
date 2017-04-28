<?php
$url = URL::current(0);
$lists = array(
    'MES COMMANDES' => array(
        array(
            'name' => 'Historique de Commandes',
            'link' => LANGPATH . '/customer/orders'
        ),
        array(
            'name' => 'Commande impayée',
            'link' => LANGPATH . '/customer/unpaid_orders'
        ),
        array(
            'name' => 'Items to review',
            'link' => '#'
        ),
        array(
            'name' => 'Liste d’envies',
            'link' => LANGPATH . '/customer/wishlist'
        ),
        array(
            'name' => 'Suivi de Commande',
            'link' => LANGPATH . '/tracks/track_order'
        ),
    ),
    'MON PROFIL' => array(
        array(
            'name' => 'Paramètre de compte',
            'link' => LANGPATH . '/customer/profile'
        ),
        array(
            'name' => 'Changer le mot de passe',
            'link' => LANGPATH . '/customer/password'
        ),
        array(
            'name' => 'Carnet d’adresses',
            'link' => LANGPATH . '/customer/address'
        ),
        array(
            'name' => 'Créer une adresse',
            'link' => LANGPATH . '/address/add'
        )
    ),
    'POINTS & COUPONS' => array(
        array(
            'name' => 'Historique de points',
            'link' => LANGPATH . '/customer/points_history'
        ),
        array(
            'name' => 'Social Sharing Bonus',
            'link' => '#'
        ),
        array(
            'name' => 'Mes Coupons',
            'link' => LANGPATH . '/customer/coupons'
        ),
    ),
);

$customer_id = Customer::logged_in();
$email = Customer::instance($customer_id)->get('email');
$celebrity = DB::select('id')->from('celebrities_celebrits')->where('email', '=', $email)->execute()->get('id');
if ($celebrity)
{
    $lists['My Profile'][] = array(
        'name' => 'Mon blog show',
        'link' => LANGPATH . '/customer/blog_show'
    );
}
?>
<aside id="aside" class="col-sm-3 col-xs-12 hidden-xs">
    <a href="<?php echo LANGPATH; ?>/customer/summary" class="user-home hidden-xs">SOMMAIRE DE COMPTE</a>
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
    <a href="<?php echo LANGPATH; ?>/customer/logout" class="user-home">Me Déconnecter</a>
</aside>