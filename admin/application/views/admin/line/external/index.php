<?php echo View::factory('admin/external/top')->render(); ?>
<body>
	<div id="wrapper">
		<?php echo View::factory('admin/external/head')->set('active', $active)->render(); ?>
		<div id="content">
			<div class="clear"></div>
			<div class="column full">
				<div class="box">
					<h2 class="box-header">Order List</h2>
					<div class="box-content">
						<table class="display" id="tabledata">
							<thead>
								<tr>
									<th>Order#</th>
									<th>Email</th>
									<th>Status</th>
									<th>Name</th>
									<th>Created</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody class="openable-tbody">
								<?php if(count($orders) > 0): ?>
								<?php foreach( $orders as $order ): ?>
								<?php $order = External::instance($site)->format($order); ?>
										<tr class="gradeA odd">
											<td><?php echo $order['ordernum']; ?></td>
											<td><?php echo $order['email']; ?></td>
											<td><?php echo $order['status']; ?></td>
											<td>[C] <?php echo substr($order['name'], 0, 30); ?><br/>[S] <?php echo substr($order['shipping_name'], 0, 30); ?><br/>[B] <?php echo substr($order['billing_name'], 0, 30); ?></td>
											<td><?php echo $order['date']; ?></td>
											<td class="center"><a href="/external/usa/detail/<?php echo $order['ordernum']; ?>" title="View #<?php echo $order['ordernum']; ?>" target="_blank"><img src="/media/external/gfx/search_input.png" alt="View"/></a></td>
										</tr>
								<?php endforeach; ?>
								<?php endif; ?>
									</tbody>
								</table>
								<div class="clear"></div>
							</div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
	<?php echo View::factory('admin/external/foot')->render(); ?>