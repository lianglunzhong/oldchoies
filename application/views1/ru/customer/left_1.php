<?php
$url = URL::current(0);
$lists = array(
    'Мои Заказы' => array(
        array(
            'name' => 'История заказов',
            'link' => LANGPATH . '/customer/orders'
        ),
        array(
            'name' => 'Неоплаченные Заказы',
            'link' => LANGPATH . '/customer/unpaid_orders'
        ),
        array(
            'name' => 'Items to review',
            'link' => '#'
        ),
        array(
            'name' => 'Избранное',
            'link' => LANGPATH . '/customer/wishlist'
        ),
        array(
            'name' => 'Отслеживать заказ',
            'link' => LANGPATH . '/tracks/track_order'
        ),
    ),
    'МОЙ ПРОФИЛЬ' => array(
        array(
            'name' => 'Настройка профиля',
            'link' => LANGPATH . '/customer/profile'
        ),
        array(
            'name' => 'Изменение пароля',
            'link' => LANGPATH . '/customer/password'
        ),
        array(
            'name' => 'Адресная книга',
            'link' => LANGPATH . '/customer/address'
        ),
        array(
            'name' => 'Создать адрес',
            'link' => LANGPATH . '/address/add'
        )
    ),
    'Мои Купоны и баллы' => array(
        array(
            'name' => 'История баллов',
            'link' => LANGPATH . '/customer/points_history'
        ),
        array(
            'name' => 'Social Sharing Bonus',
            'link' => '#'
        ),
        array(
            'name' => 'Мои купоны',
            'link' => LANGPATH . '/customer/coupons'
        ),
    ),
);

$customer_id = Customer::logged_in();
$email = Customer::instance($customer_id)->get('email');
$celebrity = DB::select('id')->from('celebrities_celebrits')->where('email', '=', $email)->execute()->get('id');
if ($celebrity)
{
    $lists['МОЙ ПРОФИЛЬ'][] = array(
        'name' => 'Мое шоу блога',
        'link' => LANGPATH . '/customer/blog_show'
    );
}
?>
<div class="sidebar visible-xs-block hidden-sm hidden-md hidden-lg col-xs-12" style="overflow:hidden;float:none;">
    <div class="sidebar-nav">
        <h5 class="sort-nav-toggle JS-toggle">
            <span>
            <b class="visible-phone">Личный кабинет</b>
            <i class="fa fa-caret-down"></i>
            </span>
        </h5>
        <div class="sort-nav-section JS-toggle-box hide">
            <div class="accordion">
            <?php
            foreach ($lists as $title => $link):
                ?>
                <div class="accordion-group visible-phone">
                    <div class="accordion-heading JS-toggle">
                        <a class="accordion-toggle " href="javascript:void(0);">
                        <?php echo $title; ?>
                        <i class="fa fa-caret-down flr"></i>
                        </a>
                    </div>
                    <div class="accordion-body JS-toggle-box hide" style="display: none;">
                        <div class="accordion-inner">
                            <ul class="unstyled">
                            <?php
                            foreach ($link as $l):
                                if (!$l['link'] OR $l['link'] == '#')
                                    continue;
                                ?>
                                <li class="selector">
                                    <a href="<?php echo LANGPATH . $l['link']; ?>"><?php echo $l['name']; ?></a>
                                </li>
                                <?php
                            endforeach;
                            ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
            ?>
            </div>
        </div>
    </div>
</div>