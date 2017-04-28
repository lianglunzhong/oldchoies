<?php
$conditions1 = 'Alle Artikel mit vollem Preis';
$conditions2 = 'Alle Artikel';
?>

		<section id="main">
			<!-- crumbs -->
			<div class="container">
				<div class="crumbs">
					<div>
						<a href="<?php echo LANGPATH; ?>/">Homepage</a>
						<a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > KONTOÜBERSICHT</a> > Meine Gutscheine
					</div>
                     <?php echo Message::get(); ?>
				</div>
			</div>
			<!-- main-middle begin -->
			<div class="container">
				<div class="row">
        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
		<?php echo View::factory(LANGPATH . '/customer/left_1'); ?>
					<article id="container" class="user col-sm-9 col-xs-12">
						<div class="tit">
							<h2>Meine Gutscheine</h2>
						</div>
						<ul class="JS_tab1 detail-tab1 hidden-xs">
							<li class="on">Unbenutzte Gutscheine</li>
							<li>Verwendete Gutscheine</li>
						                            <p style="left:0px;">
                            <b></b>
                            </p>
						</ul>
						<div class="JS_tabcon1 detail-tabcon1 hidden-xs">
							<div>
								<div class=" table-responsive">
									<table class="user-table">
										<tr>
											<th width="20%">Gutschein Code</th>
				                            <th width="10%">Gutschein Typ</th>
				                            <th width="10%">Gutschein Wert</th>
				                            <th width="20%">Allgemeine Geschäftsbedingungen</th>
				                            <th width="10%">Gültig ab</th>
				                            <th width="10%">Ablaufdatum <a href="?sort=<?php echo isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'date1' : 'date'; ?>" class="icon_turn"></a></th>
				                            <th width="10%">Erstellungsdatum</th>
										</tr>
                     <?php
                        $types = array(
                            1 => 'Rabatt',
                            2 => 'Reduzieren',
                            3 => 'Großzügigkeit',
                            4 => 'Änderung');
                        foreach($coupons as $coupon):
                        	if(!in_array($coupon['code'],$us)){
                            $conditions = 'Alle Artikel mit vollem Preis';
                            switch ($coupon['type'])
                            {
                                case 1:
                                    $value = $coupon['value'] . '% Rabatt';
                                    break;
                                case 2:
                                    $value = Site::instance()->price($coupon['value'], 'code_view').' Reduzieren ';
                                    break;
                                case 3:
                                    $value = 'Großzügigkeit: ' . $coupon['item_sku'];
                                    break;
                                case 4:
                                    $value = 'Reduzieren Preis bis ' . Site::instance()->price($coupon['value'], 'code_view');
                                    break;
                                default:
                                    $value = '';
                                    break;
                            }
                            ?>
										<tr>
                         <td><?php echo $coupon['code']; ?></td>
                            <td><?php echo isset($types[$coupon['type']]) ? $types[$coupon['type']] : $coupon['type']; ?></td>
                            <td><?php echo $value; ?></td>
                            <td>
                            	<?php
									if(isset($coupon['target']))
									{
										if($coupon['target'] == 'global')
										{
											echo $conditions2;
										}else
										{
											echo $conditions1;
										}										
									}
                            	?>
                            </td>
                            <td><?php echo date('n/j/Y H:i:s', $coupon['created']); ?></td>
                            <td><?php echo date('n/j/Y H:i:s', $coupon['expired']); ?></td>
                            <td><?php echo date('n/j/Y H:i:s', $coupon['created']); ?></td>
					</tr>
                     <?php
                     		}
                        endforeach;
                        ?>
									</table>   
									<span style="float:right;">
						<?php echo $pagination; ?>
						</span>
								</div>

							</div>
							<div class="hide">
								<div class=" table-responsive">
									<table class="user-table">
										<tr>
											<th width="20%">Gutschein Code</th>
				                            <th width="10%">Gutschein Typ</th>
				                            <th width="10%">Gutschein Wert</th>
				                            <th width="20%">Allgemeine Geschäftsbedingungen</th>
				                            <th width="10%">Bestellnummer</th>
				                            <th width="10%">Einsparung</th>
				                            <th width="10%">Verwendete Daten</th>
										</tr>
                                        <?php
                        foreach($used as $data):
                            $currency = Site::instance()->currencies($data['currency']);
                            ?>
                        <tr>
                            <td><?php echo $data['coupon_code']; ?></td>
                            <td> </td>
                            <td> </td>
                            <td>
							<?php 
								if(isset($coupon['target']))
								{
									if($coupon['target'] == 'global')
									{
										echo $conditions2;
									}else
									{
										echo $conditions1;
									}										
								}
							?>
							</td>
                            <td><a href="<?php echo LANGPATH; ?>/order/view/<?php echo $data['ordernum']; ?>"><?php echo $data['ordernum']; ?></a></td>
                            <td><?php echo $currency['code'] . $data['amount_coupon']; ?></td>
                            <td><?php echo date('n/j/Y H:i:s', $data['created']); ?></td>
                        </tr>
                        <?php
                        endforeach;
                        ?>
									</table>
								</div>
							</div>
						</div>
						<div class="coupons-mobile visible-xs-block hidden-sm hidden-md hidden-lg">
							<ul class="detail-tab">
								<li class="on">Unbenutzte Gutscheine</li>
							</ul>
								<div class=" table-responsive">
									<table class="user-table">
										<tr>
											<th width="20%">Gutschein Code</th>
				                            <th width="10%">Gutschein Typ</th>
				                            <th width="10%">Gutschein Wert</th>
				                            <th width="20%">Allgemeine Geschäftsbedingungen</th>
				                            <th width="10%">Gültig ab</th>
				                            <th width="10%">Ablaufdatum <a href="?sort=<?php echo isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'date1' : 'date'; ?>" class="icon_turn"></a></th>
				                            <th width="10%">Erstellungsdatum</th>
										</tr>
                     <?php
                        $types = array(
                            1 => 'Rabatt',
                            2 => 'Reduzieren',
                            3 => 'Großzügigkeit',
                            4 => 'Änderung');
                        foreach($coupons as $coupon):
                            $conditions = 'Alle Artikel mit vollem Preis';
                            switch ($coupon['type'])
                            {
                                case 1:
                                    $value = $coupon['value'] . '% off';
                                    break;
                                case 2:
                                    $value = 'Reduzieren ' . Site::instance()->price($coupon['value'], 'code_view');
                                    break;
                                case 3:
                                    $value = 'Großzügigkeit: ' . $coupon['item_sku'];
                                    break;
                                case 4:
                                    $value = 'Reduzieren Preis bis ' . Site::instance()->price($coupon['value'], 'code_view');
                                    break;
                                default:
                                    $value = '';
                                    break;
                            }
                            ?>
                        <tr>
                            <td><?php echo $coupon['code']; ?></td>
                            <td><?php echo isset($types[$coupon['type']]) ? $types[$coupon['type']] : $coupon['type']; ?></td>
                            <td><?php echo $value; ?></td>
                            <td>
							<?php 
								if(isset($coupon['target']))
								{
									if($coupon['target'] == 'global')
									{
										echo $conditions2;
									}else
									{
										echo $conditions1;
									}										
								}
							?>
                            </td>
                            <td><?php echo date('n/j/Y H:i:s', $coupon['created']); ?></td>
                            <td><?php echo date('n/j/Y H:i:s', $coupon['expired']); ?></td>
                            <td><?php echo date('n/j/Y H:i:s', $coupon['created']); ?></td>
                        </tr>
                        <?php
                        endforeach;
                        ?>
									</table>
								</div>
								<ul class="detail-tab">
									<li class="on">Verwendete Gutscheine</li>
								</ul>
							    <div class=" table-responsive">
									<table class="user-table">
										<tr>
											<th width="20%">Gutschein Code</th>
				                            <th width="10%">Gutschein Typ</th>
				                            <th width="10%">Gutschein Wert</th>
				                            <th width="20%">Allgemeine Geschäftsbedingungen</th>
				                            <th width="10%">Bestellnummer</th>
				                            <th width="10%">Einsparung</th>
				                            <th width="10%">Verwendete Daten</th>
										</tr>
                        <?php
                        foreach($used as $data):
                            $currency = Site::instance()->currencies($data['currency']);
                            ?>
										<tr>
				                            <td><?php echo $data['coupon_code']; ?></td>
				                            <td> </td>
				                            <td> </td>
				                            <td>
											<?php 
												if(isset($coupon['target']))
													{
														if($coupon['target'] == 'global')
														{
															echo $conditions2;
														}else
														{
															echo $conditions1;
														}										
													}
											?>
											</td>
				                            <td><a href="<?php echo LANGPATH; ?>/order/view/<?php echo $data['ordernum']; ?>"><?php echo $data['ordernum']; ?></a></td>
				                            <td><?php echo $currency['code'] . $data['amount_coupon']; ?></td>
				                            <td><?php echo date('n/j/Y H:i:s', $data['created']); ?></td>
				                        </tr>
                        <?php
                        endforeach;
                        ?>
									</table>
								</div>
						</div>
					</article>

				</div>
			</div>
		</section>

		<!-- footer begin -->

		<div id="gotop" class="hide">
			<a href="#" class="xs-mobile-top"></a>
		</div>
