<?php
if(empty(LANGUAGE))
{
	$lists = Kohana::config('/customer/summary.en');
}
else
{
	$lists = Kohana::config('/customer/summary.'.LANGUAGE);
}
?>
<!-- main begin -->
<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/"><?php echo $lists['title1']; ?></a> > <?php echo $lists['title2']; ?>
			</div>
		</div>
	</div>
	<!-- main-middle begin -->
	<div class="container">
		<div class="row">
			<?php echo View::factory('customer/left'); ?>
            <?php //echo View::factory('customer/left_1'); ?>
					<article class="user user-account col-sm-9 hidden-xs " style="float:left">
						<dl>
							<dt><?php echo $lists['title3'];  echo $customer->get('firstname') ? $customer->get('firstname') : 'Choieser';  echo $lists['title4']; ?></dt>
							<dd><?php echo $lists['title5']; ?><strong class="mr10"> <?php if($is_vip){ echo "Yes";}else{ echo "No";}?></strong>
							<?php
								if($vip_end){
							?>
							<span><?php echo $lists['Expires on']; ?> <strong><?php echo $vip_end?></strong></span></dd>
							<?php
								}
							?>
						</dl>				

						<!-- vip -->
						<div class="vip JS_clickcon hide">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<th width="15%" class="first">
										<div class="r"><?php echo $lists['Privileges']; ?></div>
										<div><?php echo $lists['VIP Level']; ?></div>
									</th>
									<th width="20%"><?php echo $lists['Accumulated Transaction Amount']; ?></th>
									<th width="16%"><?php echo $lists['Extra Discounts for Items']; ?></th>
									<th width="16%"><?php echo $lists['Points Use Permissions']; ?></th>
									<th width="15%"><?php echo $lists['Order Points Reward']; ?></th>
									<th width="18%"><?php echo $lists['Other Privileges']; ?></th>
								</tr>
								<tr>
									<td><span class="icon-nonvip" title="Non-VIP"></span><strong><?php echo $lists['Non-VIP']; ?></strong>
									</td>
									<td><?php echo $lists['$0']; ?></td>
									<td>/</td>
									<td rowspan="6">
										<div><?php echo $lists['You may apply Points equaling up to only 10% of your order value']; ?> </div>
									</td>
									<td rowspan="6"><?php echo $lists['$1 = 1 points']; ?></td>
									<td><?php echo $lists['15% off Coupon Code']; ?></td>
								</tr>
								<tr>
									<td><span class="icon-vip" title="Diamond VIP"></span><strong><?php echo $lists['VIP']; ?></strong>
									</td>
									<td><?php echo $lists['$1 - $199']; ?></td>
									<td>/</td>
									<td rowspan="5">
										<div><?php echo $lists['Get double shopping points during major holidays']; ?>
											<br /> <?php echo $lists['Special birthday gift']; ?>
											<br /> <?php echo $lists['And More...']; ?></div>
									</td>
								</tr>
								<tr>
									<td><span class="icon-bronze" title="Bronze VIP"></span><strong><?php echo $lists['Bronze VIP']; ?></strong>
									</td>
									<td><?php echo $lists['$199 - $399']; ?></td>
									<td><?php echo $lists['5% OFF']; ?></td>
								</tr>
								<tr>
									<td><span class="icon-silver" title="Silver VIP"></span><strong><?php echo $lists['Silver VIP']; ?></strong>
									</td>
									<td><?php echo $lists['$399 - $599']; ?></td>
									<td><?php echo $lists['8% OFF']; ?></td>
								</tr>
								<tr>
									<td><span class="icon-gold" title="Gold VIP"></span><strong><?php echo $lists['Gold VIP']; ?></strong>
									</td>
									<td><?php echo $lists['$599 - $1999']; ?></td>
									<td><?php echo $lists['10% OFF']; ?></td>
								</tr>
								<tr>
									<td><span class="icon-diamond" title="Diamond VIP"></span><strong><?php echo $lists['Diamond VIP']; ?></strong>
									</td>
									<td>&ge;<?php echo $lists['$1999']; ?> </td>
									<td><?php echo $lists['15% OFF']; ?></td>
								</tr>
							</table>
						</div>
						<!--order-list-->
            <?php if(!empty($orders)){ ?>
						<div class="order-list fix">
						<h4 style="font-size:18px;margin-bottom:10px;font-weight:normal;"><?php echo $lists['Below are your recent orders']; ?> </h4>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr bgcolor="#e4e4e4">
									<th width="20%"><strong><?php echo $lists['Order Date']; ?></strong>
									</th>
									<th width="20%"><strong><?php echo $lists['Order No']; ?></strong>
									</th>
									<th width="15%"><strong><?php echo $lists['Order Total']; ?></strong>
									</th>
									<th width="15%"><strong><?php echo $lists['Shipping']; ?></strong>
									</th>
									<th width="15%"><strong><?php echo $lists['Order Status']; ?></strong>
									</th>
									<th width="15%"><strong><?php echo $lists['Action']; ?></strong>
									</th>
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
                            $status = str_replace('_', ' ', $order['refund_status']);
                        }else{
                            if($order['shipping_status']=="new_s" OR $order['payment_status']=="cancel")
                            {
                                $status = kohana::config('order_status.payment.' . $order['payment_status'] . '.name');
                                if ($status == 'New' OR $status == 'new'){ $status = 'Unpaid'; }
                            }else{
                                $status=$order['shipping_status'];
                                if ($status == 'partial_shipped'){ $status = 'Partial Shipped'; }
                            }
                        }
                        echo ucfirst($status);
                        ?>
                    </td>
                    <td>
                    <?php
                    if($order['shipping_status'] == 'shipped' OR $order['shipping_status'] == 'partial_shipped'){
                        ?>
                        <a href="/tracks/customer_track?id=<?php echo $order['ordernum']; ?>" class="order-list-btn"><?php echo $lists['Track']; ?></a>
                    <?php }else{
                    if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                    {?>
                    <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><?php echo $lists['View Details']; ?></a>
                    <?php }elseif (!$order['refund_status'] AND $order['amount'] > 0 AND ($order['payment_status']=="new" or $order['payment_status']=="failed")){ ?>
                        <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="btn btn-primary btn-xs"><?php echo $lists['To pay']; ?></a>
                    <?php }else{ ?>
                        <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><?php echo $lists['View Details']; ?></a>
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
								<h2><?php echo $lists['Recently Viewed']; ?></h2>
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

                <li><a href="<?php echo Product::instance($id)->permalink(); ?>">
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
								<h2><?php echo $lists['Best Seller']; ?></h2>
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

                <li><a href="<?php echo Product::instance($id)->permalink(); ?>">
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



