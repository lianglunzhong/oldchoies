<p id="crumbs"><a href="<?php echo LANGPATH; ?>/index.cfm">Home</a> / <a href="<?php echo LANGPATH; ?>/mobilecustomer/profile">My Account</a> / Order History</p>
<?php echo Message::get(); ?>

<table id="order-history">
	<tbody>
		<tr>
			<th>Order Number</th>
			<th>Date</th>
			<th colspan="2">Status</th>
		</tr>
		
	  <?php foreach ($orders as $order): ?>
		<tr>
			<td><?php echo $order['ordernum']; ?></td>
			<td><?php echo date('Y-m-d H:i:s', $order['created']); ?></td>
			<td><?php echo kohana::config('order_status.payment.' . $order['payment_status'] . '.name'); ?></td>
			<td><a class="myaccountsprite btn-view" href="<?php echo LANGPATH; ?>/mobileorder/view/<?php echo $order['ordernum']; ?>">View</a></td>
		</tr>
	  <?php endforeach; ?>
		
	</tbody>
</table>
			
								
