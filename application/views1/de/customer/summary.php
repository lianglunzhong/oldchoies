<!-- main begin -->
<section id="main">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs">
            <div>
                <a href="<?php echo LANGPATH; ?>/">Homepage</a> > KONTOÜBERSICHT
            </div>
        </div>
    </div>
    <!-- main-middle begin -->
    <div class="container">
        <div class="row">
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
                <aside id="aside" class="col-sm-3 col-xs-10 col-xs-offset-2 col-sm-offset-0">
                    <a href="<?php echo LANGPATH; ?>/customer/summary" class="user-home hidden-xs">MEIN KONTO</a>
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
                                    <li><a  href="<?php echo LANGPATH . $l['link']; ?>"<?php if ($url == $l['link']) echo ' class="on"'; ?>><?php echo $l['name']; ?></a></li>
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

					<article class="user user-account col-sm-9 hidden-xs">
						<dl>
							<dt>Hi, <?php echo $customer->get('firstname') ? $customer->get('firstname') : 'Choieser'; ?> . Welcome to Choies.</dt>
							<dd>VIP Member or Not:<strong class="mr10"> <?php if($is_vip){ echo "Yes";}else{ echo "No";}?></strong>
							<?php
								if($vip_end){
							?>
							<span>Expires on: <strong><?php echo $vip_end?></strong></span></dd>
							<?php
								}
							?>
						</dl>	
						<!-- vip -->
						<div class="vip JS_clickcon hide">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<th width="15%" class="first">
										<div class="r">Privilegien</div>
										<div>VIP Level</div>
									</th>
									<th width="20%">Kumulierte Transaktionsbetrag</th>
                                    <th width="16%">Zusätzliche Rabatte für Artikel</th>
                                    <th width="16%">Punkte-Verwenden Berechtigungen</th>
                                    <th width="15%">Bestellung-Punkte Belohnung</th>
                                    <th width="18%">Andere Vorrechte</th>
								</tr>
								<tr>
									<td><span class="icon-nonvip" title="Nicht-VIP"></span><strong>Nicht-VIP</strong>
									</td>
									<td>$0</td>
									<td>/</td>
									<td rowspan="6"><div>Sie können Punkte bis zu insgesamt 10% des Auftragswertes anwenden.</div></td>
                                    <td rowspan="6">$1 = 1 Punkt</td>
                                    <td>15% Rabatt Code</td>
								</tr>
								<tr>
									<td><span class="icon-vip" title="Diamant VIP"></span><strong>VIP</strong>
									</td>
									<td>$1 - $199</td>
									<td>/</td>
									<td rowspan="5"><div>Sie können Doppel Einkaufspunkte während der großen Ferien erhalten.<br />
                                        Besondere Geburtstagsgeschenk.<br />
                                        Und mehr...</div>
									</td>
								</tr>
								<tr>
									<td><span class="icon-bronze" title="Bronze VIP"></span><strong>Bronze VIP</strong>
									</td>
									<td>$199 - $399</td>
									<td>5% Rabatt</td>
								</tr>
								<tr>
									<td><span class="icon-silver" title="Silber VIP"></span><strong>Silber VIP</strong>
									</td>
									<td>$399 - $599</td>
									<td>8% Rabatt</td>
								</tr>
								<tr>
									<td><span class="icon-gold" title="Gold VIP"></span><strong>Gold VIP</strong>
									</td>
									<td>$599 - $1999</td>
									<td>10% Rabatt</td>
								</tr>
								<tr>
									<td><span class="icon-diamond" title="Diamant VIP"></span><strong>Diamant VIP</strong>
									</td>
									<td>&ge; $1999</td>
									<td>15% Rabatt</td>
								</tr>
							</table>
						</div>
						<!--order-list-->
            <?php if(!empty($orders)){ ?>
						<div class="order-list fix">
						<h4 style="font-size:18px;margin-bottom:10px;font-weight:normal;">Below are your recent orders: </h4>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr bgcolor="#e4e4e4">
									<th width="20%"><strong>Bestelldatum</strong></th>
                                    <th width="20%"><strong>Bestellnummer</strong></th>
                                    <th width="15%"><strong>Gesamtsumme</strong></th>
                                    <th width="15%"><strong>Lieferung</strong></th>
                                    <th width="15%"><strong>Bestellstatus</strong></th>
                                    <th width="15%"><strong>Aktion</strong></th>
								</tr>
                  <?php foreach($orders as $order){ 
                    $currency = Site::instance()->currencies($order['currency']);
                    ?>

								<tr>
                    <td><?php echo date('n/j/Y H:i:s', $order['created']); ?></td>
                    <td><a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><?php echo $order['ordernum']; ?></a></td>
                    <td><?php echo $currency['code'] . round($order['amount'], 2); ?></td>
                    <td><?php echo $currency['code'] . round($order['amount_shipping'], 2); ?></td>
                    <td>
                    <?php
                        if($order['refund_status'])
                        {
                            $status = $order['refund_status'];
                        }else{
                            if($order['shipping_status']=="new_s" OR $order['payment_status']=="cancel")
                            {
                                $status=$order['payment_status'];
                            }else{
                                $status=$order['shipping_status'];
                            }
                        }
                        if ($status == 'new'){ $status = 'Unbezahlt'; }
                        elseif ($status == 'cancel'){ $status = 'Storniert'; }
                        elseif ($status == 'failed'){ $status = 'Mißerfolg'; }
                        elseif ($status == 'success'){ $status = 'Erfolgreich'; }
                        elseif ($status == 'pending'){ $status = 'Pending'; }
                        elseif ($status == 'partial_paid'){ $status = 'Teilweise Bezahlt'; }
                        elseif ($status == 'processing'){ $status = 'Bearbeitung'; }
                        elseif ($status == 'shipped'){ $status = 'Versandt'; }
                        elseif ($status == 'partial_shipped'){ $status = 'Teilweise Versandt'; }
                        elseif ($status == 'delivered'){ $status = 'Zugestellt'; }
                        elseif ($status == 'prepare_refund'){ $status = 'Rückerstattung vorzubereiten'; }
                        elseif ($status == 'partial_refund'){ $status = 'Teilweise Zurückerstattet'; }
                        elseif ($status == 'refund'){ $status = 'Zurückerstattet'; }
                        echo ucfirst($status);
                        ?>
                    </td>
                    <td>
                    <?php
                    if($order['shipping_status'] == 'shipped' OR $order['shipping_status'] == 'partial_shipped'){
                        ?>
                        <a href="<?php echo LANGPATH; ?>/tracks/customer_track?id=<?php echo $order['ordernum']; ?>" class="order-list-btn">Verfolgen</a>
                    <?php }else{
                    if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                    {?>
                    <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>">Bestelldetails</a>
                    <?php }elseif (!$order['refund_status'] AND $order['amount'] > 0 AND ($order['payment_status']=="new" or $order['payment_status']=="failed")){ ?>
                        <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="btn btn-primary btn-xs">BEZAHLEN</a>
                    <?php }else{ ?>
                        <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>">Bestelldetails</a>
                    <?php } ?>
                        
                    <?php }?>
                    </td>
								</tr>

                  <?php } ?>
							</table>

						</div>
		          <?php } ?>				
	
					<?php 
						if(!empty($view_history)){
						$i=0; 
						$count=count($view_history);
						$num=ceil($count/7);
					?>	
						<div class="box-dibu1">
                            <div class="w-tit">
								<h2>Kürzlich Rezensiert</h2>
							</div>
							<div id="personal-recs">
                <?php foreach($view_history as $id){
                if($i==0){ ?>
								<div class="hide-box1-0">
									<ul>
                <?php }elseif($i%7==0){ ?>
                <div class="hide-box1-<?php echo ceil($i/7); ?> hide">
									<ul>
                <?php } ?>

                <li><a href="<?php echo Product::instance($id ,LANGUAGE)->permalink(); ?>">
                    <img src="<?php echo Image::link(Product::instance($id)->cover_image(), 7); ?>" width="150"  /></a>
                  <p class="price">
                      <b><?php echo Site::instance()->price(Product::instance($id)->price(), 'code_view'); ?></b>
                   </p>
                </li>
				 <?php
                $i++;
                if($i%7==0){
                    echo "</ul></div>";
                }
                }  ?>
					
				</div>
					</div>
							<div id="JS-current1" class="box-current">
								<ul>
									<li class="on"></li>
            <?php for($j=0;$j<$num-1;$j++){ ?>
            <li></li>
            <?php } ?>
								</ul>
							</div>
		<?php		}else{ ?>
		
							<div class="recently-viewed">
                            <div class="w-tit">
								<h2>Bestseller</h2>
							</div>
							<div id="personal-recs">
                <?php 
                $i=0;
                $top_seller = Catalog::instance(32)->products();
                foreach($top_seller as $id){
                    if($i>9)break;
                     $stock = Product::instance($id)->get('stock');
                     if ($stock == 0)
                                continue;
                            elseif ($stock == -1)
                            {
                                $stocks = DB::select(DB::expr('SUM(stocks) AS sum'))
                                                ->from('products_stocks')
                                                ->where('product_id', '=', $id)
                                                ->where('attributes', '<>', '')
                                                ->execute()->get('sum');
                                if (!$stocks)
                                    continue;
                            }
                if($i==0){ ?>
								<div class="hide-box1-0">
									<ul>
                <?php }elseif($i%7==0){ ?>
                <div class="hide-box1-<?php echo ceil($i/7); ?> hide">
                <ul>
                <?php } ?>

                <li><a href="<?php echo Product::instance($id ,LANGUAGE)->permalink(); ?>">
                    <img src="<?php echo Image::link(Product::instance($id)->cover_image(), 7); ?>" width="150"  /></a>
                  <p class="price">
                      <b><?php echo Site::instance()->price(Product::instance($id)->price(), 'code_view'); ?></b>
                   </p>
                </li>
				 <?php
                $i++;
                if($i%7==0){
                    echo "</ul></div>";
                }
                }  ?>
					
				</div>
					</div>
					</div>
							<div id="JS-current1" class="box-current">
								<ul>
									<li class="on"></li>
									<?php 
									$num=ceil($i/7);
									for($j=0;$j<$num-1;$j++){ ?>
									<li></li>
									<?php } ?>
								</ul>
							</div>
		
	        <?php } ?>  			
					</article>
		</div>
					</div>
					</div>
		</section>

		<!-- footer begin -->

		<div id="gotop" class="hide">
			<a href="#" class="xs-mobile-top"></a>
		</div>
<script type="text/javascript">
var f=0;
var t1;
var tc1;
$(function(){
$(".box-current1 li").hover(function(){
$(this).addClass("on").siblings().removeClass("on");
var c=$(".box-current1 li").index(this);
$(".hide-box1-0,.hide-box1-1,.hide-box1-2,.hide-box1-3").hide();
$(".hide-box1-"+c).fadeIn(150);
f=c;
})
})
</script>
		<script src="/assets/js/buttons.js"></script>
		<script src="/assets/js/product-rotation.js"></script>



