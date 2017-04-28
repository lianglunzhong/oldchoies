<?php
if(empty(LANGUAGE))
{
	$lists = Kohana::config('/customer/order.en');
	$list = Kohana::config('/customer/order_status.en');
}
else
{
	$lists = Kohana::config('/customer/order.'.LANGUAGE);
	$list = Kohana::config('/customer/order_status.'.LANGUAGE);
}
?>
<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/"><?php echo $lists['title1']; ?></a>
				<a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > <?php echo $lists['title2']; ?></a> > <?php echo $lists['history_title3']; ?>
			</div>
		</div>
        <?php echo Message::get(); ?>
	</div>
	<!-- main-middle begin -->
	<div class="container">
		<div class="row">
<?php echo View::factory('customer/left'); ?>
<?php echo View::factory('customer/left_1'); ?>
			<article class="user col-sm-9 hidden-xs">
				<div class="tit">
					<h2><?php echo $lists['history_title4']; ?></h2>
				</div>
    <?php
    $user_id = Customer::logged_in();
    $firstname = Customer::instance($user_id)->get('firstname');
    if (empty($orders)):
    ?>
		<p class="mb25"><?php echo $firstname ? ucfirst($firstname) : 'Choieser'; echo $lists['empty1'];?></p>
		<p class="mb25"><?php echo $lists['empty2']; ?></p>
    <?php 
    else: 
    ?>
				<table class="user-table">
					<tr class="tol-table">
						<th width="30%"><?php echo $lists['Product Details']; ?></th>
						<th width="10%"><?php echo $lists['Price']; ?></th>
						<th width="5%"><?php echo $lists['QTY']; ?></th>
						<th width="5%"></th>
						<th width="5%"><?php echo $lists['Shipping']; ?></th>
						<th width="12%"><?php echo $lists['Order Total']; ?></th>
						<th width="18%"><?php echo $lists['Order Status']; ?></th>
						<th width="20%"><?php echo $lists['Action']; ?></th>
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
						<th colspan="8"><?php echo $lists['Order No']; ?> <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><b><?php echo $order['ordernum']; ?></b></a>    <span><?php echo $lists['Order Time']; echo date('n/j/Y H:i:s', $order['created']); ?></span></th>
					</tr>
					<tr>
						<td colspan="4" width="45%" class="sub-table-box">
							<table width="100%">
               <?php

                foreach ($products as $p):
                    if($p['status'] != 'cancel')
                    {
//                    $product = DB::select('stock', 'visibility', 'status', 'sku', 'name', 'link','market_price')->from('products_product')->where('id', '=', $p['product_id'])->execute()->current();
                    $product = Product::instance($p['product_id']);
					$p_price = $product->get('price');

                    $outstock = 0;
                    if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                    {
                        $amount += $p['price'] * $p['quantity'] * $order['rate'];
                    }
                    $item_status =DB::select('status')->from('products_productitem')->where('product_id','=',$p['product_id'])->execute()->current();
                        $product_stocks = $product->get_stocks();
                        if (!$item_status['status'] and $product->get('stock') == 0)
                        {
                            $outstock = 1;
                        }
                        if ($product->get('stock') == -1)
                        {

                            $has = 0;
                            $stocks = 0;
                            $search_attr = str_replace(array('SIZE:', ';'), array(''), strtoupper($p['attributes']));
                            $search_attr = trim($search_attr);

                            if($search_attr == 'ONE SIZE')
                            {
                               $search_attr = strtolower($search_attr); 
                            }
                            if(!empty($search_attr))
                            {
                                foreach($product_stocks as  $stock)
                                {
                                    if(in_array($search_attr,$stock))
                                    {
                                        $stocks = $stock['stock'];
                                        break;
                                    }
                                }                                
                            }

                            if ($stocks > 0)
                            {
                                if ($p['quantity'] > $stocks)
                                    $p['quantity'] = $stocks;
                                $amount += $p['price'] * $p['quantity'] * $order['rate'];

                            }

                        }
                        else
                        {
                            $amount += $p['price'] * $p['quantity'] * $order['rate'];
                        }
                    
                    $plink = LANGPATH . '/product/' . $product->get('link') . '_p' . $p['product_id'];
                ?>
								<tr>
									<td width="60%">
										<div>
											<div class="left">
												<a target="_blank" href="<?php echo $plink; ?>">
													<img src="<?php echo image::link(Product::instance($p['product_id'])->cover_image(), 3); ?>" />
												</a>
											</div>
											<div class="right">
												<a target="_blank" href="<?php echo $plink; ?>" class="name"><?php echo $product->get('name'); ?></a>
                                <?php if ($outstock): ?><p class="red">(<?php echo $lists['Out of stock'];?>)</p><?php endif; ?>
                                <p>
                                    <?php
                                    $attributes = str_replace(';', ';<br>', $p['attributes']);
                                    $attributes = str_replace('delivery time: 0', 'delivery time: regular order', $attributes);
                                    $attributes = str_replace('delivery time: 15', 'delivery time: rush order', $attributes);
                                    echo $attributes;
                                    ?>
                                </p>
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

									</td>
								</tr>
                <?php
                        }
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
						<td width="12%">          
						<?php
						if($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass'){
							$amount_order = $order['amount'];
							echo $currency['code'] . round($amount_order, 2);
						}else{
							echo $currency['code'] . round($amount_order, 2);
						}
						?></td>
						<td width="15%"><b>          
						<?php


				if($order['refund_status'] && $order['refund_status'] != 'none')
				{
					$status = str_replace('_', ' ', $order['refund_status']);
					if(!empty(LANGUAGE) and LANGUAGE != 'en')
					{
						if($status == 'prepare refund'){
							$status = $list['prepare refund'];
						}elseif($status == 'partial refund'){
							$status = $list['partial refund'];
						}else{
							$status = $list['refund_else'];
						}
					}

				}
                else
                {
					$status = kohana::config('order_status.payment.' . $order['payment_status'] . '.name');

					$shipstatus = kohana::config('order_status.shipment.' . $order['shipping_status'] . '.name');
                    if ($status == 'New' OR $status == 'new') {
						$status = $list['New'];
					}elseif($status == 'failed' OR $status == 'Failed'){
						$status = $list['Failed'];
					}elseif($status == 'cancel' OR $status == 'Cancel'){
						$status = $list['Cancel'];
					}elseif($shipstatus == 'processing' OR $shipstatus == 'Processing'){
						$status = $list['Processing'];
					}elseif($shipstatus == 'partial shipped' OR $shipstatus == 'Partial Shipped'){
						$status = $list['Partial Shipped'];
					}elseif($shipstatus == 'shipped' OR $shipstatus == 'Shipped'){
						$status = $list['Shipped'];
					}elseif($shipstatus == 'delivered' OR $shipstatus == 'Delivered'){
						$status = $list['Delivered'];
					}
                }
                $echo_status = $status;
                echo ucfirst($echo_status);
                ?></b>
						</td>
						<td width="15%">
            <?php 
            if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
            {
                $domain = URLSTR;
            ?>
            <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="a-underline mb10"><?php echo $lists['Order Details']; ?></a>
			<?php }elseif($order['payment_status'] == 'cancel'){ ?>
			 <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="a-underline mb10"><?php echo $lists['Order Details']; ?></a>
            <?php }elseif (!$order['refund_status'] AND $amount > 0 AND $order['payment_status'] == 'new'){ ?>
            <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="btn btn-primary btn-sm mb10"><?php echo $lists['to pay'];?></a>
            <?php }else{ ?>
            <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="a-underline mb10"><?php echo $lists['Order Details']; ?></a>
            <?php } ?>
            <?php if($order['shipping_status'] == 'shipped' OR $order['shipping_status'] == 'partial_shipped'){ ?>
                    <?php
                    if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                    {
                        if($p['erp_line_status'] == 1)
                        {
                            $is_approve = DB::select('is_approved')->from('reviews')->where('order_id', '=', $order['id'])->where('product_id', '=', $p['product_id'])->execute()->get('is_approved');
                            if($is_approve)
                            {
                            ?>
                            <a href="<?php echo $plink; ?>#review-list" class="a-underline"><?php echo $lists['Reviewed']; ?></a>
                            <?php
                            }
                            else
                            {
                            ?>
                            <a class="a-underline"><?php echo $lists['Reviewed']; ?></a>
                            <?php
                            }
                        }
                        else
                        {
                        ?>
                            <a href="/review/add/<?php echo $p['product_id']; ?>" class="a-underline review-link"><?php echo $lists['Reviewed']; ?></a>
                        <?php
                        }
                    }
                    ?>
			<span class="JS_shows_btn1 trackjs a-underline" id="<?php echo $order['ordernum']; ?>"><a href="/tracks/customer_track?id=<?php echo $order['ordernum']; ?>"><?php echo $lists['Track Order'];?></a>

	            			<div class="JS_shows1 track-order-hidecon hide">
		                		<p><?php echo $lists['Tracking1']; ?><a href="/tracks/customer_track?id=<?php echo $order['ordernum']; ?>" class="red"><?php echo $lists['Tracking2']; ?></a> <?php echo $lists['Tracking3']; ?> </p>
								<p class="mt20" id="<?php echo $order['ordernum']; ?>error_block"></p>
		                		<ul class="track-ul" id="history<?php echo $order['ordernum']; ?>"></ul>
		</div>
		</span>
      <?php } ?>
		</td>
		</tr>
    <?php
    endforeach;
    ?>
		</table>

	<div class="tol-page" style="float:right;">
	<?php  echo $pagination;   ?>
	</div>
	</article>
	<article class="order-history-mobile col-xs-12 hidden-sm hidden-md hidden-lg">
	<?php

    foreach ($orders as $order){
		
        $currency = Site::instance()->currencies($order['currency']);

//        $status = $order['payment_status'];
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
						<p><?php echo $lists['Order No']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><?php echo $order['ordernum']; ?></a></p>
						<p><?php echo $lists['Order Time']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('n/j/Y H:i:s', $order['created']); ?></p>
                <?php
                foreach ($products as $p):
                    if($p['status'] == 'cancel')
                        continue;
//                    $product = DB::select('stock', 'visibility', 'status', 'sku', 'name', 'link')->from('products_product')->where('id', '=', $p['product_id'])->execute()->current();
                    $product = Product::instance($p['product_id']);
                    $outstock = 0;
                    if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                    {
                        $amount += $p['price'] * $p['quantity'] * $order['rate'];
                    }
                    else
                    {
                        $item_status =DB::select('status')->from('products_productitem')->where('product_id','=',$p['product_id'])->execute()->current();
                        if (!$product->get('visibility') OR !$item_status['status'] OR $product->get('stock') == 0)
                        {
                            $outstock = 1;
                        }
                        elseif ($product->get('stock') == -1)
                        {
                            $product_stocks = $product->get_stocks();
                            $has = 0;
                            $stocks = 0;
                            $search_attr = str_replace(array('SIZE:', ';'), array(''), strtoupper($p['attributes']));
                            $search_attr = trim($search_attr);
                            if(!empty($search_attr))
                            {
                                foreach($product_stocks as  $stock)
                                {
                                    if(in_array($search_attr,$stock))
                                    {
                                        $stocks = $stock['stock'];
                                        break;
                                    }
                                }                                
                            }
                            if ($stocks > 0)
                            {
                                if ($p['quantity'] > $stocks)
                                    $p['quantity'] = $stocks;
                                $amount += $p['price'] * $p['quantity'] * $order['rate'];
                                $has = 1;
                            }
                            if (!$has)
                                $outstock = 1;
                        }
                        else
                        {
                            $amount += $p['price'] * $p['quantity'] * $order['rate'];
                        }
                    }
                    $plink = LANGPATH . '/product/' . $product->get('link') . '_p' . $p['product_id'];
                ?>
                <?php
                endforeach;
                $amount_order = $amount + $order['amount_shipping'];
                if ($amount_order > $order['amount'])
                    $amount_order = $order['amount'];
                if (in_array($order['payment_status'], array('new', 'failed')) AND $amount == 0)
                    $amount_order = $order['amount'];
                ?>						
	
						<p><?php echo $lists['Order Total1']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
						<?php
        if($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
            $amount_order = $order['amount'];
        echo $currency['code'] . round($amount_order, 2); 
        ?></p>
						<p><?php echo $lists['Shipping Fee']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $currency['code'] . round($order['amount_shipping'], 2); ?></p>
						<p><?php echo $lists['Order Status1']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
						<?php

                        if($order['refund_status'] && $order['refund_status'] != 'none')
                        {
                            $status = str_replace('_', ' ', $order['refund_status']);
                            if(!empty(LANGUAGE) and LANGUAGE != 'en')
                            {
                                if($status == 'prepare refund'){
                                    $status = $list['prepare refund'];
                                }elseif($status == 'partial refund'){
                                    $status = $list['partial refund'];
                                }else{
                                    $status = $list['refund_else'];
                                }
                            }

                        }
                        else
                        {
                            $status = kohana::config('order_status.payment.' . $order['payment_status'] . '.name');

                            $shipstatus = kohana::config('order_status.shipment.' . $order['shipping_status'] . '.name');
                            if ($status == 'New' OR $status == 'new') {
                                $status = $list['New'];
                            }elseif($status == 'failed' OR $status == 'Failed'){
                                $status = $list['Failed'];
                            }elseif($status == 'cancel' OR $status == 'Cancel'){
                                $status = $list['Cancel'];
                            }elseif($shipstatus == 'processing' OR $shipstatus == 'Processing'){
                                $status = $list['Processing'];
                            }elseif($shipstatus == 'partial shipped' OR $shipstatus == 'Partial Shipped'){
                                $status = $list['Partial Shipped'];
                            }elseif($shipstatus == 'shipped' OR $shipstatus == 'Shipped'){
                                $status = $list['Shipped'];
                            }elseif($shipstatus == 'delivered' OR $shipstatus == 'Delivered'){
                                $status = $list['Delivered'];
                            }
                        }
                        $echo_status = $status;
                        echo ucfirst($echo_status);
						?></p>
						<?php	$status = kohana::config('order_status.payment.' . $order['payment_status'] . '.name');
							if ($amount > 0 AND $status == 'New' OR $status == 'new')
							{
						?>
								<a class="btn btn-primary btn-sm mb10" href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><?php echo $lists['to pay']; ?></a>
						<?php } ?>
					</td>
					<td width="20%">
						<a href="#" class="mobile-btn"></a>
					</td>
				</tr>



			</tbody>
		</table> 
		<?php } ?>
				<div class="tol-page">
	<?php  echo $pagination;   ?>
	</div>
	</article>
	</div>
	</div>
	        <?php
    endif;
?> 
</section>

<!-- footer begin -->

<div id="gotop" class="hide">
	<a href="#" class="xs-mobile-top"></a>
</div>

<script>

	$(".trackjs").hover(function() {
		var code = $(this).attr("id");
		var flg = $(this).children('div').attr('name');
		if (flg == 0) {
			$("#" + code + "error_block").html("Loading...").fadeIn(320);
			$("#" + code).children('div').attr('name', '1');
			$.ajax({
				type: "POST",
				url: "/track/ajax_pagedata",
				dataType: "json",
				data: "code=" + code,
				success: function(data) {
					if (data.result == "noData") {
						$("#" + code + "error_block").html(data.msg).fadeIn(320)
					} else if (data.result == "success") {
						$("#" + code + "error_block").html("").fadeOut(320)
						$("#history" + code).html('');
						var item = eval(data.data)
						for (var i = 0; i < item.length; i++) {
							if (typeof(item[i]['history']) != "undefined") {
								$("#history" + code).append("<li class=\"first\"><span class=\"btn-black-sm\">Package" + (i + 1) + "</span></li>");
								for (var l = 0; l < item[i]['history'].length; l++) {
									$("#history" + code).append("<li>" + item[i]['history'][l]['a'] + " " + item[i]['history'][l]['z'] + "</li>");
								}
							}
						}
					}
				},
				error: function() {
					$("#error_block").html("Error.").fadeIn(320)
				}
			});
		}
		$(this).find(".JS_shows1").show();
	}, function() {
		$(this).find('.JS_shows1').hide();
	})
</script>
