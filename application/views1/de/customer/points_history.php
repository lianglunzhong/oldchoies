<section id="main">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs">
            <div>
                <a href="<?php echo LANGPATH; ?>/">Homepage</a>
                <a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > KONTOÜBERSICHT</a> > Punkte Historie
            </div>
        </div>
    </div>
    <!-- main-middle begin -->
    <div class="container">
        <div class="row">
<?php echo View::factory(LANGPATH . '/customer/left'); ?>
<?php echo View::factory(LANGPATH . '/customer/left_1'); ?>
            <article class="user col-sm-9 col-xs-12">
                <div class="tit">
                    <h2>Punkte Historie</h2>
                </div>
                <dl class="points-dl">
                    <dt>PUNKTE BILANZ ZUSAMMENFASSEN:</dt>
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
                    <dd>Punkte Erhalten: <?php echo $Rewarded; ?><span>|</span>Verwendete Punkte: <?php echo $paymented; ?></dd>   
                    <dd>Aktivierte Punkte zu benutzen: <?php echo $points; ?><span>|</span>Einsparungen: <?php echo Site::instance()->price($paymented / 100, 'code_view'); ?></dd>
                </dl>
                <ul class="JS-tab1 detail_tab detail-tab1 hidden-xs">
                     <li <?php if(!$pagetype) echo 'class="on"'; ?>>Punkt Bilanz</li>
                    <li <?php if($pagetype == 'rewarded') echo 'class="on"'; ?>>Punkte Erhalten</li>
                    <li <?php if($pagetype == 'used') echo 'class="on"'; ?>>Punkte Verwendet</li>
                    <p style="left:0px"><b></b></p>
                </ul>
                <div class="JS-tabcon1 detail-tabcon1 hidden-xs">
                    <div class="bd">
                        <div class="<?php if($pagetype) echo 'hide'; ?>    table-responsive">
                            <table class="user-table">
                                <tr>
                                    <?php $sort = isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'date1' : 'date'; ?>
                                    <th width="12%">Punkte Datum <a href="?sort=<?php echo $sort; ?>" class="icon_turn"></a></th>
                                    <th width="22%">Punkte Erhalten / Quelle</th>
                                    <th width="10%">Punkte Erhalten</th>
                                    <th width="12%">Punkte Status</th>
                                    <th width="10%">Punkte Verwendete</th>
                                    <th width="10%">Speichern</th>
                                    <th width="12%">Belohnt / Verwendet Typ</th>
                                </tr>
                                <?php
                                $tasks = array(
                                    '0' => 'Verlosung',
                                    'review' => 'Produkt Show',
                                    'promoting' => 'Begleiten Sie an Blogger',
                                    'register' => 'Anmeldung',
                                    'order' => 'Bestellung',
                                    'affiliate' => 'Partnerprogramm',
                                    'compensation' => 'Entschädigung',
                                    'greeting' => 'Grüß',
                                    'complete_profile'=>'Profil Vollständigen',
                                    'lottery' => 'Lotterie',
                                    'tryon' => 'tryon',
                                    'product_show' => 'Produktschau',
                                    'birthday' => 'Geburtstag',
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
                                                $type = 'Bestellung';
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
                                                echo '<b>Bestellnummer: <a href="' . LANGPATH  . '/order/view/' . $ordernum . '">' . $ordernum . '</a></b>';
                                            }
                                            else
                                                echo $type;
                                            ?>
                                        </td>
                                        <td><?php if (!$spent) echo $data['amount']; else echo '-'; ?></td>
                                        <td>
                                            <?php
                                            if (!$spent)
                                            {
                                                $status = ucfirst($data['status']);
                                                $status = str_replace('Activated', 'Aktiviert', $status);
                                                echo $status;
                                            }
                                            else 
                                                echo '-'; 
                                            ?>
                                        </td>
                                        <td><?php if ($spent) echo $data['amount']; else echo '-'; ?></td>
                                        <td><?php if ($spent) echo Site::instance()->price($data['amount'] / 100, 'code_view'); else echo '-'; ?></td>
                                        <td><?php echo ucfirst($type); ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                                ?>
                            </table>
                        </div>
            <?php echo $pagination; ?>
                    </div>
                    <div class="bd <?php if($pagetype != 'rewarded') echo 'hide'; ?>">
                        <div class="table-responsive">
                            <table class="user-table">
                                <tr>
                                    <th width="15%">Punkte Datum <a href="?sort=<?php echo $sort; ?>" class="icon_turn"></a></th>
                                    <th width="25%">Punkte Erhalten / Quelle</th>
                                    <th width="15%">Punkte Erhalten</th>
                                    <th width="15%">Punkte Status</th>
                                    <th width="15%">Belohnt / Verwendet Typ</th>
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
                                            echo '<b>Bestellnummer: <a href="' . LANGPATH  . '/order/view/' . $ordernum . '">' . $ordernum . '</a></b>';
                                        }
                                        else
                                            echo $type;
                                        ?>
                                    </td>
                                    <td><?php echo $data['amount']; ?></td>
                                    <td><div>
                                        <?php
                                        $status = ucfirst($data['status']);
                                        $status = str_replace('Activated', 'Aktiviert', $status);
                                        echo $status;
                                        ?>
                                    </div></td>
                                    <td><?php echo ucfirst($type); ?></td>
                                </tr>
                    <?php
                endforeach;
                ?>
                            </table>
                        </div>

                    </div>
                    <div class="bd">
                        <div class="table-responsive  <?php if($pagetype != 'used') echo 'hide'; ?>">
                            <table class="user-table">
                                <tr>
                                    <th width="15%">Punkte Datum <a href="?sort=<?php echo $sort; ?>" class="icon_turn"></a></th>
                                    <th width="25%">Punkte Erhalten / Quelle</th>
                                    <th width="12%">Punkte Verwendete</th>
                                    <th width="12%">Speichern</th>
                                    <th width="12%">Belohnt / Verwendet Typ</th>
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
                                        $type = $data['order_id'] ? 'Bestellung' : 'Lotterie';
                                        if ($data['order_id'])
                                        {
                                            $ordernum = Order::instance($data['order_id'])->get('ordernum');
                                            echo '<b>Bestellnummer: <a href="'.LANGPATH.'/order/view/' . $ordernum . '">' . $ordernum . '</a></b>';
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
                        <li class="on">Punkt Bilanz</li>
                    </ul>
                    <div class="<?php if($pagetype) echo 'hide'; ?> table-responsive">
                            <table class="user-table">
                                <tr>
                                    <?php $sort = isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'date1' : 'date'; ?>
                                    <th width="12%">Punkte Datum <a href="?sort=<?php echo $sort; ?>" class="icon_turn"></a></th>
                                    <th width="22%">Punkte Erhalten / Quelle</th>
                                    <th width="10%">Punkte Erhalten</th>
                                    <th width="12%">Punkte Status</th>
                                    <th width="10%">Punkte Verwendete</th>
                                    <th width="10%">Speichern</th>
                                    <th width="12%">Belohnt / Verwendet Typ</th>
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
                                    <td>
                                        <?php
                                        if($data['order_id'])
                                            $type = 'Bestellung';
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
                                            echo '<b>Bestellnummer: <a href="' . LANGPATH  . '/order/view/' . $ordernum . '">' . $ordernum . '</a></b>';
                                        }
                                        else
                                            echo $type;
                                        ?>
                                    </td>
                                    <td><?php if (!$spent) echo $data['amount']; else echo '-'; ?></td>
                                    <td><div>
                                        <?php
                                        if (!$spent)
                                        {
                                            $status = ucfirst($data['status']);
                                            $status = str_replace('Activated', 'Aktiviert', $status);
                                            echo $status;
                                        }
                                        else 
                                            echo '-'; 
                                        ?>
                                    </div></td>
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
                        <li class="on">Punkte Erhalten</li>
                    </ul>
                    <div class="<?php if($pagetype != 'rewarded') echo 'hide'; ?>table-responsive">
                        <table class="user-table">
                            <tr>
                                <th width="15%">Punkte Datum <a href="?sort=<?php echo $sort; ?>" class="icon_turn"></a></th>
                                <th width="25%">Punkte Erhalten / Quelle</th>
                                <th width="15%">Punkte Erhalten</th>
                                <th width="15%">Punkte Status</th>
                                <th width="15%">Belohnt / Verwendet Typ</th>
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
                                        echo '<b>Bestellnummer: <a href="' . LANGPATH  . '/order/view/' . $ordernum . '">' . $ordernum . '</a></b>';
                                    }
                                    else
                                        echo $type;
                                    ?>
                                </td>
                                <td><?php echo $data['amount']; ?></td>
                                <td><div>
                                <?php
                                $status = ucfirst($data['status']);
                                $status = str_replace('Activated', 'Aktiviert', $status);
                                echo $status;
                                ?>
                                </div></td>
                                <td><?php echo ucfirst($type); ?></td>
                            </tr>
                    <?php
                endforeach;
                ?>
                        </table>
                    </div>
                    <ul class="detail-tab">
                        <li class="on">Punkte Verwendet</li>
                    </ul>
                    <div class="<?php if($pagetype != 'used') echo 'hide'; ?>  table-responsive">
                            <table class="user-table">
                                <tr>
                                    <th width="15%">Punkte Datum <a href="?sort=<?php echo $sort; ?>" class="icon_turn"></a></th>
		                            <th width="25%">Punkte Erhalten / Quelle</th>
		                            <th width="12%">Punkte Verwendete</th>
		                            <th width="12%">Speichern</th>
		                            <th width="12%">Belohnt / Verwendet Typ</th>
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
	                                    $type = $data['order_id'] ? 'Bestellung' : 'Lotterie';
	                                    if ($data['order_id'])
	                                    {
	                                        $ordernum = Order::instance($data['order_id'])->get('ordernum');
	                                        echo '<b>Bestellnummer: <a href="'.LANGPATH.'/order/view/' . $ordernum . '">' . $ordernum . '</a></b>';
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
</section>
