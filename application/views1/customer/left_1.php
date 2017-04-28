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
            'name' => 'Wishlist',
            'link' => '/customer/wishlist'
        ),
        array(
            'name' => 'Track Order',
            'link' => '/tracks/track_order'
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
        ),
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
<div class="sidebar visible-xs-block hidden-sm hidden-md hidden-lg col-xs-12" style="overflow:hidden;float:none;">
	<div class="sidebar-nav">
		<h5 class="sort-nav-toggle JS-toggle">
			<span>
			<b class="visible-phone">My Account</b>
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