<?php
$url = URL::current(0);
$lists = array(
    'My Orders' => array(
        array(
            'name' => 'Order History',
            'link' => '/customer/orders'
        ),
        array(
            'name' => 'Unpaid Orders',
            'link' => '/customer/unpaid_orders'
        ),
        array(
            'name' => 'Items to review',
            'link' => '#'
        ),
        array(
            'name' => 'Wish List',
            'link' => '/customer/wishlist'
        ),
        array(
            'name' => 'Track Order',
            'link' => '/track/track_order'
        ),
    ),
    'My Profile' => array(
        array(
            'name' => 'Account Setting',
            'link' => '/customer/profile'
        ),
        array(
            'name' => 'Change Password',
            'link' => '/customer/password'
        ),
        array(
            'name' => 'Address Book',
            'link' => '/customer/address'
        ),
        array(
            'name' => 'Create Address',
            'link' => '/address/add'
        )
    ),
    'MY POINTS&COUPONS' => array(
        array(
            'name' => 'Points History',
            'link' => '/customer/points_history'
        ),
        array(
            'name' => 'Social Sharing Bonus',
            'link' => '#'
        ),
        array(
            'name' => 'My Coupons',
            'link' => '/customer/coupons'
        ),
    ),
);

$customer_id = Customer::logged_in();
$email = Customer::instance($customer_id)->get('email');
$celebrity = DB::select('id')->from('celebrities_celebrits')->where('email', '=', $email)->execute()->get('id');
if ($celebrity)
{
    $lists['My Profile'][] = array(
        'name' => 'My Blog Show',
        'link' => '/customer/blog_show'
    );
}
?>
<aside id="aside" class="fll">
    <a href="<?php echo LANGPATH; ?>/customer/summary" class="user_home">Account Summary</a>
    <?php
    foreach ($lists as $title => $link):
        ?>
        <div class="category_box aside_box">
            <h3 class="bg"><?php echo $title; ?></h3>
            <ul class="scroll_list">
                <?php
                foreach ($link as $l):
                    if (!$l['link'] OR $l['link'] == '#')
                        continue;
                    ?>
                    <li><a rel="nofollow" href="<?php echo $l['link']; ?>"<?php if ($url == $l['link']) echo ' class="on"'; ?>><?php echo $l['name']; ?></a></li>
                    <?php
                endforeach;
                ?>
            </ul>
        </div>
        <?php
    endforeach;
    ?>
</aside>