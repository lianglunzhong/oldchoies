<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  Order History</div>
        </div>
        <?php echo Message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Order History</h2></div>
            <?php
            $user_id = Customer::logged_in();
            $firstname = Customer::instance($user_id)->get('firstname');
            if (empty($orders)):
            ?>
            <p class="mb25"><?php echo $firstname ? ucfirst($firstname) : 'Choieser'; ?>, you do not have any Orders. It′s time to do some shopping on Choies with your 15% off Coupon now.</p>
            <p class="mb25">To view the order details, please click the order number or "Order Details" button</p>
            <?php 
            else: 
            ?>
          <table class="user_table user_table1">
            <tr class="first">
              <th width="25%">Product Details</th>
              <th width="10%">Price</th>
              <th width="5%">QTY</th>
              <th width="10%"></th>
              <th width="5%">Shipping</th>
              <th width="12%">Order Total</th>
              <th width="18%">Order Status</th>
              <th width="20%">Action</th>
            </tr>
          </table>
          <table class="user_table user_table1">
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
            <tr class="second">
              <th colspan="8">Order No.: <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><b><?php echo $order['ordernum']; ?></b></a>    <span>Order Time: <?php echo date('n/j/Y H:i:s', $order['created']); ?></span></th>
            </tr>
            <tr>
                <td colspan="4" width="45%" class="table2_box">
                    <table class="table2" width="100%">
                        <?php
                        foreach ($products as $p):
                            if($p['status'] == 'cancel')
                                continue;
                            $product = DB::select('stock', 'visibility', 'status', 'sku', 'name', 'link')->from('products_product')->where('id', '=', $p['product_id'])->execute()->current();
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
                        ?>
                        <tr>
                            <td width="45%">
                                <div class="fix">
                                    <div class="left"><a target="_blank" href="<?php echo $plink; ?>"><img src="<?php echo image::link(Product::instance($p['product_id'])->cover_image(), 3); ?>" /></a></div>
                                    <div class="right">
                                        <a target="_blank" href="<?php echo $plink; ?>" class="name"><?php echo $product['name']; ?></a>
                                        <?php if ($outstock): ?><p class="red">(Out of stock)</p><?php endif; ?>
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
                            <td width="20%"><p class="red"><?php echo $currency['code'] . round($p['price'] * $order['rate'], 2); ?></p></td>
                            <td width="10%"><?php echo $p['quantity']; ?></td>  
                            <td width="15%">
                            <?php
                            if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                            {
                                if($p['erp_line_status'] == 1)
                                {
                                    $is_approve = DB::select('is_approved')->from('reviews')->where('order_id', '=', $order['id'])->where('product_id', '=', $p['product_id'])->execute()->get('is_approved');
                                    if($is_approve)
                                    {
                                    ?>
                                    <a href="<?php echo $plink; ?>#review_list" class="a_underline">Reviewed</a>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                    Reviewed
                                    <?php
                                    }
                                }
                                else
                                {
                                ?>
                                    <a href="/review/add/<?php echo $p['product_id']; ?>" class="a_underline review_link">Review</a>
                                <?php
                                }
                            }
                            ?>
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
                <td width="12%">
                <?php
                if($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                    $amount_order = $order['amount'];
                echo $currency['code'] . round($amount_order, 2); 
                ?>
                </td>
                <td width="15%">
                    <b>
                        <?php
						
						echo $order['refund_status'];
						die;
                        if($order['refund_status'])
                        {
                            $status = str_replace('_', ' ', $order['refund_status']);
                        }
                        else
                        {
							$status = kohana::config('order_status.payment.' . $order['payment_status'] . '.name');
							$shipstatus = kohana::config('order_status.shipment.' . $order['shipping_status'] . '.name');
                            if ($status == 'New' OR $status == 'new'){
                                $status = 'Unpaid(New)';
							}elseif($shipstatus == 'processing' OR $shipstatus == 'Processing'){
								$status = $shipstatus;
							}elseif($shipstatus == 'partial shipped' OR $shipstatus == 'Partial Shipped'){
								$status = $shipstatus;
							}elseif($shipstatus == 'shipped' OR $shipstatus == 'Shipped'){
								$status = $shipstatus;
							}elseif($shipstatus == 'delivered' OR $shipstatus == 'Delivered'){
								$status = $shipstatus;
							}
                        }
                        echo ucfirst($status);
                        ?>
                    </b>
                </td>
                <td width="15%">
                    <?php 
                    if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                    {
                        $domain = 'www.choies.com';
                    ?>
                    <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="a_underline mb10">Order Details</a>
                    <?php }elseif (!$order['refund_status'] AND $amount > 0){ ?>
                    <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="btn22_red bold mb10">To pay</a>
                    <?php }else{ ?>
                    <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="a_underline mb10">Order Details</a>
                    <?php } ?>
                    <?php if($order['shipping_status'] == 'shipped' OR $order['shipping_status'] == 'partial_shipped'){ ?>
                    <span class="a_underline JS_shows_btn1 trackjs" id="<?php echo $order['ordernum']; ?>"><a href="/track/customer_track?id=<?php echo $order['ordernum']; ?>">Track Order</a>
                        <div class="JS_shows1 share_box track_order_hidecon hide" name="0">
                        <p>Tracking Details as follows are recently updated, please <a href="/track/customer_track?id=<?php echo $order['ordernum']; ?>" class="red">click here</a> to check all details </p>
                        <p class="mt20" id="<?php echo $order['ordernum']; ?>error_block"></p>
                        <ul class="track_ul" id="history<?php echo $order['ordernum']; ?>"></ul>
                      </div>
                    </span>
                    <?php } ?>
                </td>
            </tr>
            <?php
            endforeach;
            ?>
          </table>
          <div class="fix">
            <?php echo $pagination; ?>
          </div>  
        <?php
            endif;
        ?> 
        </article>
    <?php echo View::factory('customer/left'); ?>
    </section>
</section>

<script>
$(".trackjs").hover(function(){
    var code = $(this).attr("id");
    var flg = $(this).children('div').attr('name');
    if(flg==0){
        $("#"+code+"error_block").html("Loading...").fadeIn(320);
        $("#"+code).children('div').attr('name','1');
        $.ajax({
            type: "POST",
            url: "/track/ajax_pagedata",
            dataType: "json",
            data: "code="+code,
            success: function(data){
                if(data.result=="noData"){
                    $("#"+code+"error_block").html(data.msg).fadeIn(320)
                }else if(data.result=="success"){
                    $("#"+code+"error_block").html("").fadeOut(320)
                    $("#history"+code).html('');
                    var item = eval(data.data)
                    for(var i=0; i<item.length;i++){
                        if(typeof(item[i]['history'])!="undefined"){
                            $("#history"+code).append("<li class=\"first\"><span class=\"btn22_black\">Package"+(i+1)+"</span></li>");
                            for (var l = 0; l < item[i]['history'].length; l++) {
                                $("#history"+code).append("<li>"+item[i]['history'][l]['a']+" "+item[i]['history'][l]['z']+"</li>");
                            }
                        }
                    }
                }
            },
            error:function(){
                $("#error_block").html("Error.").fadeIn(320)
            }
        });
    }
    $(this).find(".JS_shows1").show();
},function(){
    $(this).find('.JS_shows1').hide();
})
</script>