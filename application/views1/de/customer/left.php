<?php
$url = URL::current(0);
$lists = array(
    'MEINE BESTELLUNGEN' => array(
        array(
            'name' => 'Bestellhistorie',
            'link' =>  LANGPATH . '/customer/orders'
        ),
        array(
            'name' => 'Unbezahlte Bestellungen',
            'link' => LANGPATH . '/customer/unpaid_orders'
        ),
        array(
            'name' => 'Items to review',
            'link' => '#'
        ),
        array(
            'name' => 'Wunschliste',
            'link' => LANGPATH . '/customer/wishlist'
        ),
        array(
            'name' => 'Bestellung Verfolgen',
            'link' => LANGPATH . '/tracks/track_order'
        ),
    ),
    'MEIN PROFIL' => array(
        array(
            'name' => 'Konto Einstellung',
            'link' => LANGPATH . '/customer/profile'
        ),
        array(
            'name' => 'Passwort Ändern',
            'link' => LANGPATH . '/customer/password'
        ),
        array(
            'name' => 'Adressbuch',
            'link' => LANGPATH . '/customer/address'
        ),
        array(
            'name' => 'Adresse Erstellen',
            'link' => LANGPATH . '/address/add'
        )
    ),
    'PUNKT&GUTSCHEINE' => array(
        array(
            'name' => 'Punkte Historie',
            'link' => LANGPATH . '/customer/points_history'
        ),
        array(
            'name' => 'Social Sharing Bonus',
            'link' => '#'
        ),
        array(
            'name' => 'Meine Gutscheine',
            'link' => LANGPATH . '/customer/coupons'
        ),
    ),
);

$customer_id = Customer::logged_in();
$email = Customer::instance($customer_id)->get('email');
$celebrity = DB::select('id')->from('celebrities_celebrits')->where('email', '=', $email)->execute()->get('id');
if ($celebrity)
{
    $lists['MEIN PROFIL'][] = array(
        'name' => 'Mein Blog anzeigen',
        'link' => LANGPATH . '/customer/blog_show'
    );
}
?>
<aside id="aside" class="col-sm-3 col-xs-12 hidden-xs">
    <a href="<?php echo LANGPATH; ?>/customer/summary" class="user-home hidden-xs">KONTOÜBERSICHT</a>
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
    <a href="<?php echo LANGPATH; ?>/customer/logout" class="user-home">Abmelden</a>
</aside>