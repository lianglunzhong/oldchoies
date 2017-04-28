<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div style="display:inline;">
				<a href="<?php echo LANGPATH; ?>/">Homepage</a>
				<a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > KONTOÜBERSICHT</a> > Unbezahlte Bestellungen
			</div>
		</div>
        <?php echo Message::get(); ?>
	</div>
	<!-- main-middle begin -->
	<div class="container">
		<div class="row">
<?php echo View::factory(LANGPATH . '/customer/left'); ?>
<?php echo View::factory(LANGPATH . '/customer/left_1'); ?>
			<article class="user user-account col-sm-9 hidden-xs">
				<div class="tit">
					<h2>Unbezahlte Bestellungen</h2>
				</div>
    <?php
    $user_id = Customer::logged_in();
    $firstname = Customer::instance($user_id)->get('firstname');
    if (empty($orders)):
    ?>
    <p class="mb25"><?php echo $firstname ? ucfirst($firstname) : 'Choieser'; ?>, Sie haben noch keine Bestellungen. Es ist Zeit zum Einkaufen auf Choies mit 15% Rabatt Code jetzt.</p>
    <p class="mb25">Um Bestelldetails zu sehen, klicken Sie bitte die Bestellnummer oder "Bestelldetails" Druckknopf.</p>
    <?php 
    else: 
    ?>
				<table class="user-table">
					<tr class="tol-table">
						<th width="25%">Produktdetails</th>
                        <th width="10%">Preis</th>
                        <th width="5%">Anzahl</th>
                        <th width="5%"></th>
                        <th width="5%">Lieferung</th>
                        <th width="12%">Gesamtsumme</th>
                        <th width="18%">Bestellstatus</th>
                        <th width="20%">Aktion</th>
					</tr>
				</table>   
				<?php
        foreach ($orders as $order):
            $currency = Site::instance()->currencies($order['currency']);
            $status = $order['payment_status'];
            $d_amount = 0;
            $amount = 0;
            $products = Order::instance($order['id'])->products();
            if (empty($products))
                continue;
            ?>
				<table class="user-table">

					<tr class="sub-table">
                    <th colspan="8">Bestellnummer: <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><b><?php echo $order['ordernum']; ?></b></a>    <span>Bestellzeit: <?php echo date('n/j/Y H:i:s', $order['created']); ?></span></th>
					</tr>
					<tr>
						<td colspan="4" width="45%" class="sub-table-box">
							<table width="100%">
                            <?php
                            foreach ($products as $p):
                                if($p['status'] == 'cancel')
                                    continue;
                                $product = DB::select('stock', 'visibility', 'status', 'sku', 'name', 'link')->from('products_' . LANGUAGE)->where('id', '=', $p['product_id'])->execute()->current();
					$pa = Product::instance($p['product_id']);
					$p_price = $pa->get('price');
                                $outstock = 0;
                                if (!$product['visibility'] OR !$product['status'] OR $product['stock'] == 0)
                                {
                                    $outstock = 1;
                                }
                                elseif ($product['stock'] == -1)
                                {
                                    $stocks = DB::select()
                                            ->from('products_stocks')
                                            ->where('product_id', '=', $p['product_id'])
                                            ->where('stocks', '<>', 0)
                                            ->execute();
                                    $has = 0;
                                    foreach ($stocks as $stock)
                                    {
                                        if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                        {
                                            if ($p['quantity'] > $stock['stocks'])
                                                $p['quantity'] = $stock['stocks'];
                                            $amount += $p['price'] * $p['quantity'] * $order['rate'];
                                            $has = 1;
                                            break;
                                        }
                                    }
                                    if (!$has)
                                        $outstock = 1;
                                }
                                else
                                {
                                    $amount += $p['price'] * $p['quantity'] * $order['rate'];
                                }
                                ?>
								<tr>
									<td width="60%">
										<div>
											<div class="left">
<a href="<?php echo LANGPATH; ?>/product/<?php echo $product['link']; ?>"><img src="<?php echo image::link(Product::instance($p['product_id'])->cover_image(), 3); ?>" /></a>
											</div>
											<div class="right">
                                                <a href="<?php echo LANGPATH; ?>/product/<?php echo $product['link']; ?>" class="name"><?php echo $product['name']; ?></a>
                                                <?php if ($outstock): ?><p class="red">(Nicht Auf Lager)</p><?php endif; ?>
                                                <p><?php
                                                    $attributes = str_replace(';', ';<br>', $p['attributes']);
                                                    $attributes = str_replace('one size', 'eine Größe', $attributes);
                                                    $attributes = str_replace(array('Size', 'Color'), array('Größe', 'Farbe'), $attributes);
                                                    echo $attributes;
                                                ?></p>
											</div>
										</div>
									</td>
									<td width="22%">
									<?php 
									if ($p_price > $p['price']){ ?>
									<del><?php echo $currency['code'] . round($p_price * $order['rate'], 2); ?></del>
										<p class="red"><?php echo $currency['code'] . round($p['price'] * $order['rate'], 2); ?></p>
																					
								<?php	}else{ ?>
										<p class="red"><?php echo $currency['code'] . round($p['price'] * $order['rate'], 2); ?></p>											
									<?php }  ?></td>
									<td width="10%"><?php echo $p['quantity']; ?></td>
									<td width="8%">
										<a href="#" class="a-underline"></a>
									</td>
								</tr>
                                <?php
                            endforeach;
                            $amount_order = $amount + $order['amount_shipping'];
                            if ($amount_order > $order['amount'])
                                $amount_order = $order['amount'];
                            if (in_array($order['payment_status'], array('new', 'failed')) AND $amount == 0)
                                $amount_order = $order['amount'];
                            ?>
							</table>
						</td>
						<td width="8%"><?php echo $currency['code'] . round($order['amount_shipping'], 2); ?></td>
						<td width="12%"><?php echo $currency['code'] . round($amount_order, 2); ?></td>
						<td width="15%"><b>
                        <?php
                            if($order['refund_status'])
                            {
                                $status = 'Zurückerstattet';
                            }
                            else
                            {
                                $status = kohana::config('order_status.payment.' . $order['payment_status'] . '.name');
                                $shipstatus = kohana::config('order_status.shipment.' . $order['shipping_status'] . '.name');
                                if ($status == 'New' OR $status == 'new'){
                                    $status = "Unbezahlt(Neu)";
                                }elseif($status == 'failed' OR $status == 'Failed'){
                                    $status = "Gescheitert";
                                }elseif($status == 'cancel' OR $status == 'Cancel'){
                                    $status = "Storniert";
                                }elseif($shipstatus == 'processing' OR $shipstatus == 'Processing'){
                                    $status = "Bearbeiten";
                                }elseif($shipstatus == 'partial shipped' OR $shipstatus == 'Partial Shipped'){
                                    $status = "Teilweise Versandt";
                                }elseif($shipstatus == 'shipped' OR $shipstatus == 'Shipped'){
                                    $status = "Versandt";
                                }elseif($shipstatus == 'delivered' OR $shipstatus == 'Delivered'){
                                    $status = "Zugestellt";
                                }
                            }
                            echo ucfirst($status);
                            ?></b>
						</td>
						<td width="15%">
                        <?php
                        if ($amount > 0)
                        {
                            ?>								
					<a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="btn btn-primary btn-xs mb10">BEZAHLEN</a>
						 <?php } ?>	
					</td>
					</tr>
				</table>
        <?php endforeach; ?>
        <?php echo $pagination; ?>
    <?php
    endif;
    ?>  
			</article>
			<article class="order-history-mobile col-xs-12 hidden-sm hidden-md hidden-lg">
			<?php
    $user_id = Customer::logged_in();
    $firstname = Customer::instance($user_id)->get('firstname');

	
        foreach ($orders as $order){
            $currency = Site::instance()->currencies($order['currency']);
            $status = $order['payment_status'];
            $d_amount = 0;
            $amount = 0;
            $products = Order::instance($order['id'])->products();
            if (empty($products))
                continue;
            ?>
				<table class="user-table">
					<tbody>
						<tr>
							<td width="80%" align="left">
								<p>Bestellnummer:&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><?php echo $order['ordernum']; ?></a></p>
								<p>Bestellzeit:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('n/j/Y H:i:s', $order['created']); ?></p>
						<p>Gesamtsumme:&nbsp;&nbsp;&nbsp;&nbsp;        
						<?php
        if($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
            $amount_order = $order['amount'];
        echo $currency['code'] . round($amount_order, 2); 
        ?></p>
						<p>Versandkosten:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $currency['code'] . round($order['amount_shipping'], 2); ?></p>
						<p>Bestellstatus:&nbsp;&nbsp;&nbsp;&nbsp;                                    <?php
                            if($order['refund_status'])
                            {
                                $status = 'Zurückerstattet';
                            }
                            else
                            {
                                $status = kohana::config('order_status.payment.' . $order['payment_status'] . '.name');
                                $shipstatus = kohana::config('order_status.shipment.' . $order['shipping_status'] . '.name');
                                if ($status == 'New' OR $status == 'new'){
                                    $status = "Unbezahlt(Neu)";
                                }elseif($status == 'failed' OR $status == 'Failed'){
                                    $status = "Gescheitert";
                                }elseif($status == 'cancel' OR $status == 'Cancel'){
                                    $status = "Storniert";
                                }elseif($shipstatus == 'processing' OR $shipstatus == 'Processing'){
                                    $status = "Bearbeiten";
                                }elseif($shipstatus == 'partial shipped' OR $shipstatus == 'Partial Shipped'){
                                    $status = "Teilweise Versandt";
                                }elseif($shipstatus == 'shipped' OR $shipstatus == 'Shipped'){
                                    $status = "Versandt";
                                }elseif($shipstatus == 'delivered' OR $shipstatus == 'Delivered'){
                                    $status = "Zugestellt";
                                }
                            }
                            echo ucfirst($status);
                            ?></p>
               <?php

                foreach ($products as $p):
                    if($p['status'] == 'cancel')
                        continue;
                    $product = DB::select('stock', 'visibility', 'status', 'sku', 'name', 'link','market_price')->from('products_product')->where('id', '=', $p['product_id'])->execute()->current();
					$pa = Product::instance($p['product_id']);
					$p_price = $pa->get('price');

                    $outstock = 0;
                    if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                    {
                        $amount += $p['price'] * $p['quantity'] * $order['rate'];
                    }
                    else
                    {
                        if (!$product['visibility'] OR !$product['status'] OR $product['stock'] == 0)
                        {
                            $outstock = 1;
                        }
                        elseif ($product['stock'] == -1)
                        {
                            $stocks = DB::select()
                                ->from('products_stocks')
                                ->where('product_id', '=', $p['product_id'])
                                ->where('stocks', '<>', 0)
                                ->execute();
                            $has = 0;
                            foreach ($stocks as $stock)
                            {
                                if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                {
                                    if ($p['quantity'] > $stock['stocks'])
                                        $p['quantity'] = $stock['stocks'];
                                    $amount += $p['price'] * $p['quantity'] * $order['rate'];
                                    $has = 1;
                                    break;
                                }
                            }
                            if (!$has)
                                $outstock = 1;
                        }
                        else
                        {
                            $amount += $p['price'] * $p['quantity'] * $order['rate'];
                        }
                    }
                    $plink = LANGPATH . '/product/' . $product['link'] . '_p' . $p['product_id'];

                endforeach;
                $amount_order = $amount + $order['amount_shipping'];
			//	echo $amount;
                if ($amount_order > $order['amount'])
                    $amount_order = $order['amount'];
                if (in_array($order['payment_status'], array('new', 'failed')) AND $amount == 0)
                    $amount_order = $order['amount'];
                ?>
				<?php 

				if(!$order['refund_status'] and $amount > 0 and $order['payment_status'] == 'new'){ ?>

								<a class="btn btn-primary btn-sm mb10" href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>">BEZAHLEN</a>
		<?php }  ?>
							</td>
							<td width="20%">
								<a href="#" class="mobile-btn"></a>
							</td>
						</tr>

					</tbody>
				</table>
			<?php } ?>
			</article>	
		</div>
	</div>
</section>