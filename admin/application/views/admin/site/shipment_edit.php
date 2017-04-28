<?php echo View::factory('admin/site/order/left')->render();?>
<?php $orderstatus = Order::instance()->get_orderstatus();?>
<div id="do_right">
	<div id="do_content">
		<div class="box">
			<h3>Shipment Details: <?php echo $data['id'];?></h3>
			<form method="post">
				<script type="text/javascript">
                	$(function(){
                		$(".datepick").datepicker({dateFormat:'yy-mm-dd'});
                	});
                </script>
    			<div class="navigation">
    				<ul>
    					<li><h4>Order number: <?php echo $data['ordernum'];?></h4>
    						<ul>
    							<li>
    								<label for="tracking_link">Tracking Url: </label>
    								<input type="text" name="tracking_link" value="<?php echo $data['tracking_link'];?>"/>
    							</li>
    							<li>
    								<label for="tracking_code">Tracking Code:</label>
    								<input type="text" name="tracking_code" value="<?php echo $data['tracking_code'];?>"/>
    							</li>
    							<li>
    								<label for="ship_date">Shipping Date:</label>
    								<input type="text" name="ship_date" value="<?php if ($data['ship_date']) echo date('Y-m-d', $data['ship_date']);?>" class="datepick"/>
    							</li>
    							<li>&nbsp;</li>
    							<li>
    								<label for="orderitems">Products for shipment:</label>
    								<table>
    									<tr>
    										<td>SKU</td>
    										<td>Image</td>
    										<td>Name</td>
    										<td>Quantity</td>
    									</tr>
    									<?php foreach($orderitems as $v){?>
    									<tr>
    										<td><?php echo Product::instance($v['item_id'])->get('sku');?></td>
    										<td><img src="<?php echo Image::link(Product::instance($v['item_id'])->cover_image(), 0);?>"/></td>
    										<td><?php echo Product::instance($v['item_id'])->get('name');?></td>
    										<td><?php echo $v['quantity'];?></td>
    									</tr>
    									<?php }?>
    								</table>
    							</li>
    							<li>
    								<input type="submit" name="_continue" value="Save and continue editing"/>
    								<input type="submit" name="_save" value="Save"/>
    							</li>
    						</ul>
    					</li>
    				</ul>
    			</div>
			</form>
		</div>
	</div>
</div>
