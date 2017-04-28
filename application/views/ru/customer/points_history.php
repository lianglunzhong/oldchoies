<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Home</a>  >  История баллов</div>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>История баллов</h2></div>
            <dl class="points_dl">
                <dt>Обший баланс баллов:</dt>
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
                <dd>Награда баллов: <?php echo $Rewarded; ?><span>|</span>Использование баллов: <?php echo $paymented; ?></dd>   
                <dd>Использование активных баллов: <?php echo $activated - $paymented; ?><span>|</span>Savings: <?php echo Site::instance()->price($paymented / 100, 'code_view'); ?></dd>
            </dl>
            <ul class="JS_tab1 detail_tab detail_tab1 fix">
                <li <?php if(!$pagetype) echo 'class="on"'; ?>>Баланс баллов</li>
                <li <?php if($pagetype == 'rewarded') echo 'class="on"'; ?>>Награда баллов</li>
                <li <?php if($pagetype == 'used') echo 'class="on"'; ?>>Использованные баллы</li>
            </ul>
            <div class="JS_tabcon1 detail_tabcon">
                <div class="bd <?php if($pagetype) echo 'hide'; ?>">
                    <table class="user_table">
                        <tr>
                            <?php $sort = isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'date1' : 'date'; ?>
                            <th width="12%">Дата баллов <a href="?sort=<?php echo $sort; ?>" class="icon_turn"></a></th>
                            <th width="22%">Использованный источник награды баллов</th>
                            <th width="10%">Награда баллов</th>
                            <th width="12%">Статус баллов</th>
                            <th width="10%">Использованные баллы</th>
                            <th width="10%">Save</th>
                            <th width="12%">Использованный тип награды</th>
                        </tr>
                        <?php
                        $tasks = array(
                            '0' => 'Розыгрыш Призов',
                            'review' => 'Шоу Товаров',
                            'promoting' => 'Принять участие в Блоггер',
                            'register' => 'Подписание',
                            'order' => 'Заказ',
                            'affiliate' => 'Филиал',
                            'compensation' => 'Компенсация',
                            'greeting' => 'С приветствием',
                            'complete_profile'=>'Заполнить профиль',
                            'lottery' => 'Лотерея',
                            'tryon' => 'tryon',
                            'product_show' => 'Шоу товаров',
                            'birthday' => 'день рождения',
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
                                        $type = 'Заказ';
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
                                        echo '<b>Номер заказа: <a href="' . LANGPATH  . '/order/view/' . $ordernum . '">' . $ordernum . '</a></b>';
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
                                        $status = str_replace('Activated', 'Активно', $status);
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
                    <?php echo $pagination; ?>
                </div>
                <div class="bd <?php if($pagetype != 'rewarded') echo 'hide'; ?>">
                    <table class="user_table">
                        <tr>
                            <th width="15%">Дата баллов <a href="?sort=<?php echo $sort; ?>" class="icon_turn"></a></th>
                            <th width="25%">Использованный источник награды баллов</th>
                            <th width="15%">Награда баллов</th>
                            <th width="15%">Статус баллов</th>
                            <th width="15%">Использованный тип награды</th>
                        </tr>
                        <?php
                        foreach ($records as $data):
                            ?>
                            <tr>
                                <td><?php echo date('n/j/Y H:i:s', $data['created']); ?></td>
                                <td>
                                    <?php
                                    if($data['order_id'])
                                        $type = 'Заказ';
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
                                        echo '<b>Номер заказа: <a href="' . LANGPATH  . '/order/view/' . $ordernum . '">' . $ordernum . '</a></b>';
                                    }
                                    else
                                        echo $type;
                                    ?>
                                </td>
                                <td><?php echo $data['amount']; ?></td>
                                <td>
                                    <?php
                                    $status = ucfirst($data['status']);
                                    $status = str_replace('Activated', 'Активно', $status);
                                    echo $status;
                                    ?>
                                </td>
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
                            <th width="15%">Дата баллов <a href="?sort=<?php echo $sort; ?>" class="icon_turn"></a></th>
                            <th width="25%">Использованный источник награды баллов</th>
                            <th width="12%">Использованные баллы</th>
                            <th width="12%">Save</th>
                            <th width="12%">Использованный тип награды</th>
                        </tr>
                        <?php
                        foreach ($payments as $data):
                            if (is_numeric($data['order_num']))
                            {
                                $type = 'Заказ';
                            }
                            ?>
                            <tr>
                                <td><?php echo date('n/j/Y H:i:s', $data['created']); ?></td>
                                <td>
                                    <?php
                                    $type = $data['order_id'] ? 'Заказ' : 'Лотерея';
                                    if ($data['order_id'])
                                    {
                                        $ordernum = Order::instance($data['order_id'])->get('ordernum');
                                        echo '<b>Номер заказа: <a href="'.LANGPATH.'/order/view/' . $ordernum . '">' . $ordernum . '</a></b>';
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
        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
    </section>
</section>