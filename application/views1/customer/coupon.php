<?php
if(empty(LANGUAGE))
{
	$lists = Kohana::config('/customer/my_coupons.en');
}
else
{
	$lists = Kohana::config('/customer/my_coupons.'.LANGUAGE);
}
$conditions1 = $lists['conditions1'];
$conditions2 = $lists['conditions2'];
?>
<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/"><?php echo $lists['title1']; ?></a>
				<a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > <?php echo $lists['title2']; ?></a> > <?php echo $lists['title3']; ?>
			</div>
             <?php echo Message::get(); ?>
		</div>
	</div>
	<!-- main-middle begin -->
	<div class="container">
		<div class="row">
			<?php echo View::factory('customer/left'); ?>
			<?php echo View::factory('customer/left_1'); ?>
			<article id="container" class="user col-sm-9 col-xs-12">
				<div class="tit"><h2><?php echo $lists['title4']; ?></h2></div>
				<ul class="JS_tab1 detail-tab1 hidden-xs">
					<li class="on"><?php echo $lists['Unused Coupons']; ?></li>
					<li><?php echo $lists['Coupon Used']; ?></li>
				     <p style="left:0px;">
                    <b></b>
                    </p>
				</ul>
				<div class="JS_tabcon1 detail-tabcon1 hidden-xs">
					<div>
						<div class=" table-responsive">
							<table class="user-table">
								<tr>
									<th width="20%"><?php echo $lists['Coupon Code']; ?></th>
									<th width="10%"><?php echo $lists['Coupon Type']; ?></th>
									<th width="10%"><?php echo $lists['Coupon Value']; ?></th>
									<th width="20%"><?php echo $lists['Terms & Conditions']; ?></th>
									<th width="10%"><?php echo $lists['Valid From']; ?></th>
									<th width="10%"><?php echo $lists['Expiration Date']; ?>
										<a href="?sort=<?php echo isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'date1' : 'date'; ?>" class="icon-turn"></a>
									</th>
									<th width="10%"><?php echo $lists['Created Date']; ?></th>
								</tr>
			             	<?php
			                $types = array(
			                    1 => 'Discount',
			                    2 => 'Reduce',
			                    3 => 'Largess',
			                    4 => 'Change');
			                foreach($coupons as $coupon)
			                {
			                	if(!in_array($coupon['code'],$us))
			                	{
			                    switch ($coupon['type'])
			                    {
			                        case 1:
			                            $value = $coupon['value'] . '% off';
			                            break;
			                        case 2:
			                            $value = 'Reduce $' . $coupon['value'];
			                            break;
			                        case 3:
			                            $value = 'Largess: ' . $coupon['item_sku'];
			                            break;
			                        case 4:
			                            $value = 'Reduce Price To ' . $coupon['value'];
			                            break;
			                        default:
			                        	$value = $coupon['value'];
			                        	break;
			                    }
			                    ?>
								<tr>
					                <td><?php echo $coupon['code']; ?></td>
				                    <td><?php echo isset($types[$coupon['type']]) ? $types[$coupon['type']] : $coupon['type']; ?></td>
				                    <td><?php echo $value; ?></td>
				                    <td>
				                    	<?php 
				                    		if($coupon['target'] == 'global'){
				                    			echo $conditions2;
				                    		}else{
				                    			echo $conditions1;
				                    		}
				                    	?>
				                    </td>
				                    <td><?php echo date('n/j/Y H:i:s', $coupon['created']); ?></td>
				                    <td><?php echo date('n/j/Y H:i:s', $coupon['expired']); ?></td>
				                    <td><?php echo date('n/j/Y H:i:s', $coupon['created']); ?></td>
								</tr>
				            <?php
				             	}
				            }
				            ?>
							</table>
							<!-- <span style="float:right;">
							<?php 
								#echo $pagination; 
							?>
							</span> -->
						</div>
					</div>
					<div class="hide">
						<div class=" table-responsive">
							<table class="user-table">
								<tr>
									<th width="20%"><?php echo $lists['Coupon Code']; ?></th>
									<th width="10%"><?php echo $lists['Coupon Type']; ?></th>
									<th width="10%"><?php echo $lists['Coupon Value']; ?></th>
									<th width="20%"><?php echo $lists['Terms & Conditions']; ?></th>
									<th width="10%"><?php echo $lists['Order Number']; ?></th>
									<th width="10%"><?php echo $lists['Saving']; ?></th>
									<th width="10%"><?php echo $lists['Used Date']; ?></th>
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
						<li class="on"><?php echo $lists['title1']; ?>Unused Coupons</li>
					</ul>
						<div class=" table-responsive">
							<table class="user-table">
								<tr>
									<th width="20%"><?php echo $lists['Coupon Code']; ?></th>
									<th width="10%"><?php echo $lists['Coupon Type']; ?></th>
									<th width="10%"><?php echo $lists['Coupon Value']; ?></th>
									<th width="20%"><?php echo $lists['Terms & Conditions']; ?></th>
									<th width="10%"><?php echo $lists['Valid From']; ?></th>
									<th width="10%"><?php echo $lists['Expiration Date']; ?>
										<a href="?sort=<?php echo isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'date1' : 'date'; ?>" class="icon-turn"></a>
									</th>
									<th width="10%"><?php echo $lists['Created Date']; ?></th>
								</tr>
				             	<?php
				                $types = array(
				                    1 => 'Discount',
				                    2 => 'Reduce',
				                    3 => 'Largess',
				                    4 => 'Change');
				                foreach($coupons as $coupon)
				                {
				                    switch ($coupon['type'])
				                    {
				                        case 1:
				                            $value = $coupon['value'] . '% off';
				                            break;
				                        case 2:
				                            $value = 'Reduce $' . $coupon['value'];
				                            break;
				                        case 3:
				                            $value = 'Largess: ' . $coupon['item_sku'];
				                            break;
				                        case 4:
				                            $value = 'Reduce Price To ' . $coupon['value'];
				                            break;
				                        default:
				                        	$value = $coupon['value'];
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
				                ?>
							</table>
						</div>
						<ul class="detail-tab">
							<li class="on"><?php echo $lists['Coupon Used']; ?></li>
						</ul>
					    <div class=" table-responsive">
							<table class="user-table">
								<tr>
									<th width="20%"><?php echo $lists['Coupon Code']; ?></th>
									<th width="10%"><?php echo $lists['Coupon Type']; ?></th>
									<th width="10%"><?php echo $lists['Coupon Value']; ?></th>
									<th width="20%"><?php echo $lists['Terms & Conditions']; ?></th>
									<th width="10%"><?php echo $lists['Order Number']; ?></th>
									<th width="10%"><?php echo $lists['Saving']; ?></th>
									<th width="10%"><?php echo $lists['Used Date']; ?></th>
								</tr>
			                <?php
			                foreach($used as $data)
			                {
			                    $currency = Site::instance()->currencies($data['currency']);
			                    ?>
								<tr>
									<td><?php echo $data['coupon_code']; ?></td>
									<td></td>
									<td></td>
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
									<td><a href="<?php echo LANGPATH; ?>/order/view/<?php echo $data['ordernum']; ?>"><?php echo $data['ordernum']; ?></a></a>
									</td>
									<td><?php echo $currency['code'] . $data['amount_coupon']; ?></td>
									<td><?php echo date('n/j/Y H:i:s', $data['created']); ?></td>
								</tr>
			                <?php
			                }
			                ?>
							</table>
						</div>
				</div>
			</article>
		</div>
	</div> 
</section>
