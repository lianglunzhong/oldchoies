<?php echo View::factory('admin/site/order/left')->render();?>
<div id="do_right">
	<div id="do_content">
		<div class="box">
			<h3>添加订单</h3>
			<form method="post">
    			<div class="navigation">
    				<ul>
    					<li>&nbsp;
    						<ul>
    							<li>User id: <input name="customer_id"/><!-- <a href="">+Add new user</a> --></li>
<!--    							<li>Email: <input name="email"/></li>-->
    						</ul>
    					</li>
    				</ul>
    			</div>
    			<div class="navigation">
    				<ul>
    					<li>
    					<h4>Shipping Method: </h4>
    						<ul>
    							<li>
    								<label for="shipping_carrier">Carrier:</label>
    								<select name="shipping_carrier">
    									<option value="EMS">EMS</option>
    								</select>
    							</li>
    							<!--<li>
    								<label for="shipping_status">Status: </label>
    								<?php $order_ship = Order::instance()->get_orderstatus(NULL, Order::instance()->SHIP_TYPE);?>
    								<select name="shipping_status">
    									<?php foreach($order_ship as $os){?>
    									<option value="<?php echo $os['id'];?>"><?php echo $os['name']; ?></option>
    									<?php }?>
    								</select>
    							</li>
    							<li>
    								<label for="shipping_url">Url: </label>
    								<input type="text" name="shipping_url" value=""/>
    							</li>
    							<li>
    								<label for="shipping_code">Code:</label>
    								<input type="text" name="shipping_code" value=""/>
    							</li>
    							<li>
    								<label for="shipping_date">Shipping Date:</label>
    								<input type="text" name="shipping_date" value=""/>
    							</li>
    							<li>
    								<label for="shipping_comment">Comment:</label>
    								<textarea name="shipping_comment"></textarea>
    							</li>
    						--></ul>
    					</li>
    				</ul>
    			</div>
    			<div class="navigation">
    				<ul>
    					<li><h4>Shipping Address</h4>
    						<ul>
    							<li>
    								<label for="shipping_firstname">Firstname:</label>
    								<input type="text" name="shipping_firstname" value=""/>
    							</li>
    							<li>
    								<label for="shipping_lastname">Lastname:</label>
    								<input type="text" name="shipping_lastname" value=""/>
    							</li>
    							<li>
    								<label for="shipping_address">Address:</label>
    								<input type="text" name="shipping_address" value=""/>
    							</li>
    							<li>
    								<label for="shipping_city">City:</label>
    								<input type="text" name="shipping_city" value=""/>
    							</li>
    							<li>
    								<label for="shipping_state">State:</label>
    								<input type="text" name="shipping_state" value=""/>
    							</li>
    							<li>
    								<label for="shipping_zip">Zip code:</label>
    								<input type="text" name="shipping_zip" value=""/>
    							</li>
    							<li>
    								<label for="shipping_country">Country:</label>
    								<select name="shipping_country">
    									<?php foreach($countries as $c){?>
    									<option value="<?php echo $c['isocode'];?>"><?php echo $c['name'];?></option>
    									<?php }?>
    								</select>
    							</li>
    							<li>
    								<label for="shipping_phone">Phone:</label>
    								<input type="text" name="shipping_phone" value=""/>
    							</li>
    							<li>
    								<label for="shipping_mobile">Mobile:</label>
    								<input type="text" name="shipping_mobile" value=""/>
    							</li>
    						</ul>
    					</li>
    					<li><h4>Billing Address</h4>
    						<ul>
    							<li>
    								<label for="billing_firstname">Firstname:</label>
    								<input type="text" name="billing_firstname" value=""/>
    							</li>
    							<li>
    								<label for="billing_lastname">Lastname:</label>
    								<input type="text" name="billing_lastname" value=""/>
    							</li>
    							<li>
    								<label for="billing_address">Address:</label>
    								<input type="text" name="billing_address" value=""/>
    							</li>
    							<li>
    								<label for="billing_city">City:</label>
    								<input type="text" name="billing_city" value=""/>
    							</li>
    							<li>
    								<label for="billing_state">State:</label>
    								<input type="text" name="billing_state" value=""/>
    							</li>
    							<li>
    								<label for="billing_zip">Zip code:</label>
    								<input type="text" name="billing_zip" value=""/>
    							</li>
    							<li>
    								<label for="billing_country">Country:</label>
    								<select name="billing_country">
    									<?php foreach($countries as $c){?>
    									<option value="<?php echo $c['isocode'];?>"><?php echo $c['name'];?></option>
    									<?php }?>
    								</select>
    							</li>
    							<li>
    								<label for="billing_phone">Phone:</label>
    								<input type="text" name="billing_phone" value=""/>
    							</li>
    							<li>
    								<label for="billing_mobile">Mobile:</label>
    								<input type="text" name="billing_mobile" value=""/>
    							</li>
    						</ul>
    					</li>
    				</ul>
    			</div>
    			<div class="navigation">
    				<ul>
    					<li><h4>Order Total</h4>
    						<ul>
<!--    							<li>-->
<!--    								<label for="amount_products">amount_products:</label>-->
<!--    								<input type="text" name="amount_products" value=""/>-->
<!--    							</li>-->
    							<li>
    								<label for="amount_shipping">amount_shipping</label>
    								<input type="text" name="amount_shipping" value=""/>
    							</li>
<!--    							<li>-->
<!--    								<label for="amount_order">amount_order</label>-->
<!--    								<input type="text" name="amount_order" value=""/>-->
<!--    							</li>-->
<!--    							<li>-->
<!--    								<label for="amount">amount</label>-->
<!--    								<input type="text" name="amount" value=""/>-->
<!--    							</li>-->
    							<li>
    								<label for="currency">currency</label>
    								<?php $currencies = Site::instance()->currencies();?>
    								<select name="currency">
    									<?php foreach ($currencies as $currency){?>
    									<option value="<?php echo $currency['name'];?>"><?php echo $currency['name'];?></option>
    									<?php }?>
    								</select>
    							</li>
<!--    							<li>-->
<!--    								<label for="rate">rate</label>-->
<!--    								<input type="text" name="rate" value=""/>-->
<!--    							</li>-->
<!--    							<li>-->
<!--    								<label for="amount_payment">amount_payment</label>-->
<!--    								<input type="text" name="amount_payment" value=""/>-->
<!--    							</li>-->
<!--    							<li>-->
<!--    								<label for="currency_payment">currency_payment</label>-->
<!--    								<input type="text" name="currency_payment" value=""/>-->
<!--    							</li>-->
<!--    							<li>-->
<!--    								<label for="rate_payment">rate_payment</label>-->
<!--    								<input type="text" name="rate_payment" value=""/>-->
<!--    							</li>-->
<!--    							<li>-->
<!--    								<label for="payment_status">payment_status</label>-->
<!--    								<input type="text" name="payment_status" value=""/>-->
<!--    							</li>-->
<!--    							<li>-->
<!--    								<label for="transaction_id">transaction_id</label>-->
<!--    								<input type="text" name="transaction_id" value=""/>-->
<!--    							</li>-->
    						</ul>
    					</li>
    				</ul>
    			</div>
    			<div class="navigation">
    				<ul>
    					<li>
    						<h4>Order Products</h4>
    						<table>
    							<tr>
    								<td>Product ID</td>
    								<td>Items</td>
    								<td>Quantity</td>
    							</tr>
    							<tr id="product-1">
    								<td><input type="text" name="product-1-product_id" value=""/></td>
    								<td><input type="text" name="product-1-items[]" value=""/></td>
    								<td><input type="text" name="product-1-quantity" value=""/></td>
    							</tr>
    							<tr id="product-2">
    								<td><input type="text" name="product-2-product_id" value=""/></td>
    								<td><input type="text" name="product-2-items[]" value=""/></td>
    								<td><input type="text" name="product-2-quantity" value=""/></td>
    							</tr>
    							<tr id="product-3">
    								<td><input type="text" name="product-3-product_id" value=""/></td>
    								<td><input type="text" name="product-3-items[]" value=""/></td>
    								<td><input type="text" name="product-3-quantity" value=""/></td>
    							</tr>
    							<tr><td colspan="3"><a href="javascript:void(0);">Add another order item</a></td></tr>
    						</table>
    					</li>
    				</ul>
    			</div>
    			<input type="submit" name="_addanother" value="Save and add another"/>
    			<input type="submit" name="_continue" value="Save and continue editing"/>
    			<input type="submit" name="_save" value="Save"/>
			</form>
		</div>
	</div>
</div>