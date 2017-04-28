<?php
$url = URL::current(0);
$lists = array(
    'MEINE BESTELLUNGEN' => array(
        array(
            'name' => 'Bestellhistorie',
            'link' => '/customer/orders'
        ),
        array(
            'name' => 'Unbezahlte Bestellungen',
            'link' => '/customer/unpaid_orders'
        ),
        array(
            'name' => 'Items to review',
            'link' => '#'
        ),
        array(
            'name' => 'Wunschliste',
            'link' => '/customer/wishlist'
        ),
        array(
            'name' => 'Bestellung Verfolgen',
            'link' => '/tracks/track_order'
        ),
    ),
    'MEIN PROFIL' => array(
        array(
            'name' => 'Konto Einstellung',
            'link' => '/customer/profile'
        ),
        array(
            'name' => 'Passwort Ändern',
            'link' => '/customer/password'
        ),
        array(
            'name' => 'Adressbuch',
            'link' => '/customer/address'
        ),
        array(
            'name' => 'Adresse Erstellen',
            'link' => '/address/add'
        )
    ),
    'PUNKT&GUTSCHEINE' => array(
        array(
            'name' => 'Punkte Historie',
            'link' => '/customer/points_history'
        ),
        array(
            'name' => 'Social Sharing Bonus',
            'link' => '#'
        ),
        array(
            'name' => 'Meine Gutscheine',
            'link' => '/customer/coupons'
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
        'link' => '/customer/blog_show'
    );
}
?>
<div class="sidebar visible-xs-block hidden-sm hidden-md hidden-lg col-xs-12" style="overflow:hidden;float:none;">
	<div class="sidebar-nav">
		<h5 class="sort-nav-toggle JS-toggle">
			<span>
			<b class="visible-phone">KONTOÜBERSICHT</b>
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