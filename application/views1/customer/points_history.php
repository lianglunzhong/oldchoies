<?php
if(empty(LANGUAGE))
{
	$lists = Kohana::config('/customer/points_history.en');
}
else
{
	$lists = Kohana::config('/customer/points_history.'.LANGUAGE);
}
?>
<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/"><?php echo $lists['title1']; ?></a>
				<a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > <?php echo $lists['title2']; ?></a> > <?php echo $lists['title3']; ?>
			</div>
		</div>
	</div>
	<!-- main-middle begin -->
	<div class="container">
		<div class="row">
<?php echo View::factory('customer/left'); ?>
<?php echo View::factory('customer/left_1'); ?>
			<article class="user col-sm-9 col-xs-12">
				<div class="tit">
					<h2><?php echo $lists['title4']; ?></h2>
				</div>
				<dl class="points-dl">
					<dt><?php echo $lists['title5']; ?></dt>
        <?php
        $activated = 0;
        $Rewarded = 0;
        foreach ($records as $p)
        {
            $Rewarded += $p['amount'];
            if ($p['status'] == 'activated')
                $activated += $p['amount'];
        }
        $paymented = 0;
        foreach ($payments as $p)
        {
            $paymented += $p['amount'];
        }
        ?>
					<dd><?php echo $lists['Points Rewarded']; ?><?php echo $Rewarded; ?><span>|</span><?php echo $lists['Used Points'];  echo $paymented; ?></dd>
					<dd><?php echo $lists['Activated Points to use']; ?> <?php echo $points; ?><span>|</span><?php echo $lists['Savings'];  echo Site::instance()->price($paymented / 100, 'code_view'); ?></dd>
				</dl>
				<ul class="JS-tab1 detail_tab detail-tab1 hidden-xs">
					<li <?php if(!$pagetype) echo 'class="on"'; ?>><?php echo $lists['Points Balance']; ?></li>
					<li <?php if($pagetype == 'rewarded') echo 'class="on"'; ?>><?php echo $lists['Points Rewarded1']; ?></li>
					<li <?php if($pagetype == 'used') echo 'class="on"'; ?>><?php echo $lists['Points Used']; ?></li>
					<p style="left:0px"><b></b></p>
				</ul>
				<div class="JS-tabcon1 detail-tabcon1 hidden-xs">
					<div class="bd <?php if($pagetype) echo 'hide'; ?> ">
						<div class="table-responsive">
							<table class="user-table">
								<tr>
								<?php $sort = isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'date1' : 'date'; ?>
									<th width="12%"><?php echo $lists['Points Date']; ?>
										<a href="?sort=<?php echo $sort; ?>" class="icon_turn"></a>
									</th>
									<th width="22%"><?php echo $lists['Points Rewarded / Used Source']; ?></th>
									<th width="10%"><?php echo $lists['Points Rewarded1']; ?></th>
									<th width="12%"><?php echo $lists['Points Status']; ?></th>
									<th width="10%"><?php echo $lists['Points Used']; ?></th>
									<th width="12%"><?php echo $lists['Save']; ?></th>
									<th width="22%"><?php echo $lists['Rewarded / Used Type']; ?></th>
								</tr>
                <?php
                $tasks = array(
                    '0' => 'Lucky Draw',
                    'review' => 'Product Show',
                    'promoting' => 'Joining Blogger',
                    'register' => 'Signing Up',
                    'order' => 'Order',
                    'affiliate' => 'Affiliate',
                    'compensation' => 'Compensation'
                );
                foreach ($datas as $data):
                    $spent = 0;
                    if (is_numeric($data['type']))
                    {
                        $data['type'] = 'order';
                        $spent = 1;
                    }
                    ?>
								<tr>
									<td><?php echo date('n/j/Y H:i:s', $data['created']); ?></td>
									<td>                                    <?php
                            if($data['order_id'])
                                $type = 'Order';
                            else
                            {
                                if(isset($tasks[$data['type']]))
                                    $type = $tasks[$data['type']];
                                else
                                    $type = ucfirst($data['type']);
                            }
                            if ($data['order_id'])
                            {
                                $ordernum = Order::instance($data['order_id'])->get('ordernum');
                                echo '<b>'.$lists['Order Number'].' <a href="/order/view/' . $ordernum . '">' . $ordernum . '</a></b>';
                            }
                            else
                                echo $type;
                            ?> </td>
									<td><?php if (!$spent) echo $data['amount']; else echo '-'; ?></td>
									<td><div><?php if (!$spent) echo ucfirst($data['status']); else echo '-'; ?></div></td>
									<td><?php if ($spent) echo $data['amount']; else echo '-'; ?></td>
									<td><?php if ($spent) echo Site::instance()->price($data['amount'] / 100, 'code_view'); else echo '-'; ?></td>
									<td><?php echo ucfirst($type); ?></td>
								</tr>
							<?php
						endforeach;
						?>
							</table>
						</div>
            			<!-- <?php 
            				#echo $pagination; 
            			?> -->
					</div>
					<div class="bd <?php if($pagetype != 'rewarded') echo 'hide'; ?>">
						<div class="table-responsive">
							<table class="user-table">
								<tr>
									<th width="15%"><?php echo $lists['Points Date']; ?>
										<a href="?sort=<?php echo $sort; ?>" class="icon-turn"></a>
									</th>
									<th width="25%"><?php echo $lists['Points Rewarded / Used Source']; ?></th>
									<th width="15%"><?php echo $lists['Points Rewarded1']; ?></th>
									<th width="15%"><?php echo $lists['Points Status']; ?></th>
									<th width="15%"><?php echo $lists['Rewarded / Used Type']; ?></th>
								</tr>
                <?php
                foreach ($records as $data):
                    ?>
								<tr>
									<td><?php echo date('n/j/Y H:i:s', $data['created']); ?></td>
									<td>                                    <?php
                            if($data['order_id'])
                                $type = 'Order';
                            else
                            {
                                if(isset($tasks[$data['type']]))
                                    $type = $tasks[$data['type']];
                                else
                                    $type = ucfirst($data['type']);
                            }
                            if ($data['order_id'])
                            {
                                $ordernum = Order::instance($data['order_id'])->get('ordernum');
                                echo '<b>'.$lists['Order Number'].' <a href="' . LANGPATH  . '/order/view/' . $ordernum . '">' . $ordernum . '</a></b>';
                            }
                            else
                                echo $type;
                            ?></td>
									<td><?php echo $data['amount']; ?></td>
									<td><div><?php echo ucfirst($data['status']); ?></div></td>
									<td><?php echo ucfirst($type); ?></td>
								</tr>
                    <?php
                endforeach;
                ?>
							</table>
						</div>

					</div>
					<div class="bd  <?php if($pagetype != 'used') echo 'hide'; ?>">
						<div class="table-responsive">
							<table class="user-table">
								<tr>
									<th width="15%"><?php echo $lists['Points Date']; ?>
										<a href="?sort=<?php echo $sort; ?>" class="icon-turn"></a>
									</th>
									<th width="25%"><?php echo $lists['Points Rewarded / Used Source']; ?></th>
									<th width="12%"><?php echo $lists['Points Used']; ?></th>
									<th width="12%"><?php echo $lists['Save']; ?></th>
									<th width="12%"><?php echo $lists['Rewarded / Used Type']; ?></th>
								</tr>
                <?php
                foreach ($payments as $data):
                    if (is_numeric($data['order_num']))
                    {
                        $type = 'order';
                    }
                    ?>
								<tr>
									<td><?php echo date('n/j/Y H:i:s', $data['created']); ?></td>
									<td>
                            <?php
                            $type = $data['order_id'] ? 'Order' : 'Lottery';
                            if ($data['order_id'])
                            {
                                $ordernum = Order::instance($data['order_id'])->get('ordernum');
                                echo '<b>'.$lists['Order Number'].' <a href="' . LANGPATH  . '/order/view/' . $ordernum . '">' . $ordernum . '</a></b>';
                            }
                            else
                                echo $type;
                            ?>
									</td>
									<td><?php echo $data['amount']; ?></td>
									<td><?php echo Site::instance()->price($data['amount'] / 100, 'code_view'); ?></td>
									<td><?php echo $type; ?></td>
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
						<li class="on"><?php echo $lists['Points Balance']; ?></li>
					</ul>
					<div class="<?php if($pagetype) echo 'hide'; ?> table-responsive">
							<table class="user-table">
								<tr>
                    <?php $sort = isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'date1' : 'date'; ?>
									<th width="12%"><?php echo $lists['Points Date']; ?>
										<a href="?sort=<?php echo $sort; ?>" class="icon-turn"></a>
									</th>
									<th width="22%"><?php echo $lists['Points Rewarded / Used Source']; ?></th>
									<th width="10%"><?php echo $lists['Points Rewarded1']; ?></th>
									<th width="12%"><?php echo $lists['Points Status']; ?></th>
									<th width="10%"><?php echo $lists['Points Used']; ?></th>
									<th width="12%"><?php echo $lists['Save']; ?></th>
									<th width="22%"><?php echo $lists['Rewarded / Used Type']; ?></th>
								</tr>
				<?php
                foreach ($datas as $data):
                    $spent = 0;
                    if (is_numeric($data['type']))
                    {
                        $data['type'] = 'order';
                        $spent = 1;
                    }
                    ?>
								<tr>
									<td><?php echo date('n/j/Y H:i:s', $data['created']); ?></td>
									<td>                                    <?php
                            if($data['order_id'])
                                $type = 'Order';
                            else
                            {
                                if(isset($tasks[$data['type']]))
                                    $type = $tasks[$data['type']];
                                else
                                    $type = ucfirst($data['type']);
                            }
                            if ($data['order_id'])
                            {
                                $ordernum = Order::instance($data['order_id'])->get('ordernum');
                                echo '<b>'.$lists['Order Number'].' <a href="/order/view/' . $ordernum . '">' . $ordernum . '</a></b>';
                            }
                            else
                                echo $type;
                            ?></td>
									<td><?php if (!$spent) echo $data['amount']; else echo '-'; ?></td>
									<td><div><?php if (!$spent) echo ucfirst($data['status']); else echo '-'; ?></div></td>
									<td><?php if ($spent) echo $data['amount']; else echo '-'; ?></td>
									<td><?php if ($spent) echo Site::instance()->price($data['amount'] / 100, 'code_view'); else echo '-'; ?></td>
									<td><?php echo ucfirst($type); ?></td>
								</tr>
                    <?php
                endforeach;
                ?>
							</table>
						</div>
					<ul class="detail-tab">
						<li class="on"><?php echo $lists['Points Rewarded']; ?></li>
					</ul>
					<div class="table-responsive">
						<table class="user-table">
							<tr>
								<th width="15%"><?php echo $lists['Points Date']; ?>
									<a href="?sort=<?php echo $sort; ?>" class="icon-turn"></a>
								</th>
								<th width="25%"><?php echo $lists['Points Rewarded / Used Source']; ?></th>
								<th width="15%"><?php echo $lists['Points Rewarded1']; ?></th>
								<th width="15%"><?php echo $lists['Points Status']; ?></th>
								<th width="15%"><?php echo $lists['Rewarded / Used Type']; ?></th>
							</tr>
                <?php
                foreach ($records as $data):
                    ?>
							<tr>
								<td><?php echo date('n/j/Y H:i:s', $data['created']); ?></td>
								<td>                                    <?php
                            if($data['order_id'])
                                $type = 'Order';
                            else
                            {
                                if(isset($tasks[$data['type']]))
                                    $type = $tasks[$data['type']];
                                else
                                    $type = ucfirst($data['type']);
                            }
                            if ($data['order_id'])
                            {
                                $ordernum = Order::instance($data['order_id'])->get('ordernum');
                                echo '<b>'.$lists['Order Number'].' <a href="' . LANGPATH  . '/order/view/' . $ordernum . '">' . $ordernum . '</a></b>';
                            }
                            else
                                echo $type;
                            ?></td>
								<td><?php echo $data['amount']; ?></td>
								<td><div><?php echo ucfirst($data['status']); ?></div></td>
								<td><?php echo ucfirst($type); ?></td>
							</tr>
                    <?php
                endforeach;
                ?>
						</table>
					</div>
					<ul class="detail-tab">
						<li class="on"><?php echo $lists['Points Used']; ?></li>
					</ul>
					<div class="table-responsive">
							<table class="user-table">
								<tr>
									<th width="15%"><?php echo $lists['Points Date']; ?>
										<a href="?sort=<?php echo $sort; ?>" class="icon-turn"></a>
									</th>
									<th width="25%"><?php echo $lists['Points Rewarded / Used Source']; ?></th>
									<th width="12%"><?php echo $lists['Points Used']; ?></th>
									<th width="12%"><?php echo $lists['Save']; ?></th>
									<th width="12%"><?php echo $lists['Rewarded / Used Type']; ?></th>
								</tr>
                <?php
                foreach ($payments as $data):
                    if (is_numeric($data['order_num']))
                    {
                        $type = 'order';
                    }
                    ?>
								<tr>
									<td><?php echo date('n/j/Y H:i:s', $data['created']); ?></td>
									<td>
                            <?php
                            $type = $data['order_id'] ? 'Order' : 'Lottery';
                            if ($data['order_id'])
                            {
                                $ordernum = Order::instance($data['order_id'])->get('ordernum');
                                echo '<b>'.$lists['Order Number'].' <a href="' . LANGPATH  . '/order/view/' . $ordernum . '">' . $ordernum . '</a></b>';
                            }
                            else
                                echo $type;
                            ?>
									</td>
									<td><?php echo $data['amount']; ?></td>
									<td><?php echo Site::instance()->price($data['amount'] / 100, 'code_view'); ?></td>
									<td><?php echo $type; ?></td>
								</tr>
                    <?php
                endforeach;
                ?>
							</table>
						</div>
				</div>
			</article>
		</div>
	</div>

