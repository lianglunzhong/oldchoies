<?php echo View::factory('admin/external/top')->render(); ?>
<body>
	<div id="wrapper">
		<?php echo View::factory('admin/external/head')->set('active', $active)->render(); ?>
		<div id="content">
			<div class="clear"></div>
			<div class="column full">
				<div class="box">
					<h2 class="box-header">ORDER #<?php echo $order['detail']['ordernum']; ?></h2>
					<div class="box-content">
						<p><strong>Order Infomation</strong></p>
						<table width="100%">
							<tr style="height:25px">
								<td><strong>Order #:</strong> <?php echo $order['detail']['ordernum']; ?></td>
								<td><strong>Created:</strong> <?php echo $order['detail']['created']; ?></td>
								<td><strong>Updated:</strong> <?php echo $order['detail']['updated']; ?></td>
								<td><strong>IP:</strong> <?php echo $order['detail']['ip']; ?></td>
							</tr>
							<tr style="height:25px">
								<td><strong>Payment Status:</strong> <?php echo $order['detail']['payment_status']; ?></td>
								<td><strong>Shipment Status:</strong> <?php echo $order['detail']['shipment_status']; ?></td>
								<td><strong>Amount:</strong> <?php echo $order['detail']['amount']; ?></td>
								<td><strong>Currency:</strong> <?php echo $order['detail']['currency']; ?></td>
							</tr>
						</table>
						<hr/>
						<p class="p_justify"><strong>Customer Infomation</strong></p>
						<table width="100%">
							<tr style="height:25px">
								<td><strong>Email:</strong> <?php echo $order['customer']['email']; ?></td>
								<td><strong>Name:</strong> <?php echo $order['customer']['name']; ?></td>
								<td><strong>Regist Date:</strong> <?php echo $order['customer']['date']; ?></td>
								<td></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="column full">
				<div class="box">
					<h2 class="box-header">Products</h2>
					<div class="box-content box-table">
						<table class="tablebox">
							<thead class="table-header">
								<tr>
									<th>Name</th>
									<th>SKU</th>
									<th>price</th>
									<th>Quantity</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach( $order['products'] as $product ): ?>
									<tr class="<?php echo $product['style']; ?>">
										<td><?php echo $product['name']; ?></td>
										<td><?php echo $product['sku']; ?></td>
										<td><?php echo $product['price']; ?></td>
										<td><?php echo $product['quantity']; ?></td>
									</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="column full">
					<div class="box">
						<h2 class="box-header">Shipment</h2>
						<div class="box-content box-table">
							<table class="tablebox">
								<thead class="table-header">
									<tr>
										<th>Method</th>
										<th>Tracking Code</th>
										<th>Tracking Link</th>
										<th>Ship Date</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach( $order['shipments'] as $shipment ): ?>
										<tr class="<?php echo $shipment['style']; ?>">
											<td><?php echo $shipment['method']; ?></td>
											<td><?php echo $shipment['code']; ?></td>
											<td><?php echo $shipment['link']; ?></td>
											<td><?php echo $shipment['date']; ?></td>
										</tr>
								<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="column full">
						<div class="box">
							<h2 class="box-header">Payment</h2>
							<div class="box-content box-table">
								<table class="tablebox">
									<thead class="table-header">
										<tr>
											<th>Method</th>
											<th>Transaction ID</th>
											<th>Amount</th>
											<th>Currency</th>
											<th>Status</th>
											<th>Date</th>
											<th>IP</th>
										</tr>
									</thead>
									<tbody>
								<?php foreach( $order['payments'] as $payment ): ?>
											<tr class="<?php echo $payment['style']; ?>">
												<td><?php echo $payment['method']; ?></td>
												<td><?php echo $payment['transaction_id']; ?></td>
												<td><?php echo $payment['amount']; ?></td>
												<td><?php echo $payment['currency']; ?></td>
												<td><?php echo $payment['status']; ?></td>
												<td><?php echo $payment['date']; ?></td>
												<td><?php echo $payment['ip']; ?></td>
									<?php endforeach; ?>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
	<?php echo View::factory('admin/external/foot')->render(); ?>