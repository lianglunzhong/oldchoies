<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  Points History</div>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Points History</h2></div>
            <dl class="points_dl">
                <dt>Points Balance Summary:</dt>
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
                <dd>Points Rewarded: <?php echo $Rewarded; ?><span>|</span>Used Points: <?php echo $paymented; ?></dd>   
                <dd>Activated Points to use: <?php echo $activated - $paymented; ?><span>|</span>Savings: <?php echo Site::instance()->price($paymented / 100, 'code_view'); ?></dd>
            </dl>
            <ul class="JS_tab1 detail_tab detail_tab1 fix">
                <li <?php if(!$pagetype) echo 'class="on"'; ?>>Points Balance</li>
                <li <?php if($pagetype == 'rewarded') echo 'class="on"'; ?>>Points Rewarded</li>
                <li <?php if($pagetype == 'used') echo 'class="on"'; ?>>Points Used</li>
            </ul>
            <div class="JS_tabcon1 detail_tabcon">
                <div class="bd <?php if($pagetype) echo 'hide'; ?>">
                    <table class="user_table">
                        <tr>
                            <?php $sort = isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'date1' : 'date'; ?>
                            <th width="12%">Points Date <a href="?sort=<?php echo $sort; ?>" class="icon_turn"></a></th>
                            <th width="22%">Points Rewarded / Used Source</th>
                            <th width="10%">Points Rewarded</th>
                            <th width="12%">Points Status</th>
                            <th width="10%">Points Used</th>
                            <th width="10%">Save</th>
                            <th width="12%">Rewarded / Used Type</th>
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
                                <td>
                                    <?php
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
                                        echo '<b>Order Number: <a href="/order/view/' . $ordernum . '">' . $ordernum . '</a></b>';
                                    }
                                    else
                                        echo $type;
                                    ?>
                                </td>
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
                    <?php echo $pagination; ?>
                </div>
                <div class="bd <?php if($pagetype != 'rewarded') echo 'hide'; ?>">
                    <table class="user_table">
                        <tr>
                            <th width="15%">Points Date <a href="?sort=<?php echo $sort; ?>" class="icon_turn"></a></th>
                            <th width="25%">Points Rewarded / Used Source</th>
                            <th width="15%">Points Rewarded</th>
                            <th width="15%">Points Status</th>
                            <th width="15%">Rewarded / Used Type</th>
                        </tr>
                        <?php
                        foreach ($records as $data):
                            ?>
                            <tr>
                                <td><?php echo date('n/j/Y H:i:s', $data['created']); ?></td>
                                <td>
                                    <?php
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
                                        echo '<b>Order Number: <a href="' . LANGPATH  . '/order/view/' . $ordernum . '">' . $ordernum . '</a></b>';
                                    }
                                    else
                                        echo $type;
                                    ?>
                                </td>
                                <td><?php echo $data['amount']; ?></td>
                                <td><div><?php echo ucfirst($data['status']); ?></div></td>
                                <td><?php echo ucfirst($type); ?></td>
                            </tr>
                            <?php
                        endforeach;
                        ?>
                    </table>
                </div>
                <div class="bd <?php if($pagetype != 'used') echo 'hide'; ?>">
                    <table class="user_table">
                        <tr>
                            <th width="15%">Points Date <a href="?sort=<?php echo $sort; ?>" class="icon_turn"></a></th>
                            <th width="25%">Points Rewarded / Used Source</th>
                            <th width="12%">Points Used</th>
                            <th width="12%">Save</th>
                            <th width="12%">Rewarded / Used Type</th>
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
                                        echo '<b>Order Number: <a href="' . LANGPATH  . '/order/view/' . $ordernum . '">' . $ordernum . '</a></b>';
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
        <?php echo View::factory('customer/left'); ?>
    </section>
</section>