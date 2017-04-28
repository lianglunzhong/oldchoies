<?php
$conditions1 = 'Любые товары с полной стоимостью';
$conditions2 = 'любые вопросы';
?>

        <section id="main">
            <!-- crumbs -->
            <div class="container">
                <div class="crumbs">
                    <div>
                        <a href="<?php echo LANGPATH; ?>/">home</a>
                        <a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > Личный кабинет</a> > Мои купоны
                    </div>
                     <?php echo Message::get(); ?>
                </div>
            </div>
            <!-- main-middle begin -->
            <div class="container">
                <div class="row">
        
        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
        <?php echo View::factory(LANGPATH . '/customer/left_1'); ?>
                    <article id="container" class="user col-sm-9 col-xs-12">
                        <div class="tit">
                            <h2>Мои купоны</h2>
                        </div>
                        <ul class="JS_tab1 detail-tab1 hidden-xs">
                <li class="on">Неиспользованные Купоны</li>
                <li>Использованные купоны</li>
                            <p style="left:0px;">
                            <b></b>
                            </p>
                        </ul>
                        <div class="JS_tabcon1 detail-tabcon1 hidden-xs">
                            <div>
                                <div class=" table-responsive">
                                    <table class="user-table">
                                        <tr>
                            <th width="20%">Код купона</th>
                            <th width="10%">Тип купона</th>
                            <th width="10%">Стоимость купона</th>
                            <th width="20%">Условие</th>
                            <th width="10%">Начало срока действия</th>
                            <th width="10%">Дата истечения срока действия
                                                <a href="?sort=<?php echo isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'date1' : 'date'; ?>" class="icon-turn"></a>
                                            </th>
                                            <th width="10%">Создать дату</th>
                                        </tr>
                     <?php
                        $types = array(
                            1 => 'Скидка',
                            2 => 'Уменьшение',
                            3 => 'Щедрость',
                            4 => 'change');
                        foreach($coupons as $coupon):
                            if(!in_array($coupon['code'],$us)){
                            switch ($coupon['type'])
                            {
                                case 1:
                                    $value = $coupon['value'] . '% off';
                                    break;
                                case 2:
                                    $value = 'Уменьшение стоимости ' . Site::instance()->price($coupon['value'], 'code_view');
                                    break;
                                case 3:
                                    $value = 'Щедрость: ' . $coupon['item_sku'];
                                    break;
                                case 4:
                                    $value = 'Снизить Цену До ' . Site::instance()->price($coupon['value'], 'code_view');
                                    break;
                                default:
                                    $value = '';
                                    break;
                            }
                            ?>
                                        <tr>
                         <td><?php echo $coupon['code']; ?></td>
                            <td><?php echo isset($types[$coupon['type']]) ? $types[$coupon['type']] : $coupon['type']; ?></td>
                            <td><?php echo $value; ?></td>
                            <td>
                                <?php 
                                    if(strstr($coupon['code'], 'SIGNUP') && $coupon['target'] == 'global'){
                                        echo $conditions1;
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
                        endforeach;
                        ?>
                                    </table>   
									<span style="float:right;">
                        <?php echo $pagination; ?>
						</span>
                                </div>

                            </div>
                            <div class="hide">
                                <div class=" table-responsive">
                                    <table class="user-table">
                                        <tr>
                            <th width="20%">Код купона</th>
                            <th width="10%">Тип купона</th>
                            <th width="10%">Стоимость купона</th>
                            <th width="20%">Условие</th>
                            <th width="10%">Номер заказа</th>
                            <th width="10%">Saving</th>
                            <th width="10%">Дата использования</th>
                                        </tr>
                     <?php
                        foreach($used as $data):
                            $currency = Site::instance()->currencies($data['currency']);
                            ?>
                        <tr>
                            <td><?php echo $data['coupon_code']; ?></td>
                            <td> </td>
                            <td> </td>
                            <td>Любые товары с полной стоимостью</td>
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
                                <li class="on">Неиспользованные Купоны</li>
                            </ul>
                                <div class=" table-responsive">
                                    <table class="user-table">
                                        <tr>
                            <th width="20%">Код купона</th>
                            <th width="10%">Тип купона</th>
                            <th width="10%">Стоимость купона</th>
                            <th width="20%">Условие</th>
                            <th width="10%">Начало срока действия</th>
                            <th width="10%">Дата истечения срока действия
                                                <a href="?sort=<?php echo isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'date1' : 'date'; ?>" class="icon-turn"></a>
                                            </th>
                                            <th width="10%">Создать дату</th>
                                        </tr>
                     <?php
                        $types = array(
                            1 => 'Скидка',
                            2 => 'Уменьшение',
                            3 => 'Щедрость',
                            4 => 'change');
                        foreach($coupons as $coupon):
                            $conditions = 'Любые товары с полной стоимостью';
                            switch ($coupon['type'])
                            {
                                case 1:
                                    $value = $coupon['value'] . '% off';
                                    break;
                                case 2:
                                    $value = 'Уменьшение стоимости ' . Site::instance()->price($coupon['value'], 'code_view');
                                    break;
                                case 3:
                                    $value = 'Щедрость: ' . $coupon['item_sku'];
                                    break;
                                case 4:
                                    $value = 'Снизить Цену До ' . Site::instance()->price($coupon['value'], 'code_view');
                                    break;
                                default:
                                    $value = '';
                                    break;
                            }
                            ?>
                        <tr>
                            <td><?php echo $coupon['code']; ?></td>
                            <td><?php echo isset($types[$coupon['type']]) ? $types[$coupon['type']] : $coupon['type']; ?></td>
                            <td><?php echo $value; ?></td>
                            <td><?php 
                                    if(strstr($coupon['code'], 'SIGNUP') && $coupon['target'] == 'global'){
                                        echo $conditions1;
                                    }else{
                                        echo $conditions1;
                                    }
                                ?></td>
                            <td><?php echo date('n/j/Y H:i:s', $coupon['created']); ?></td>
                            <td><?php echo date('n/j/Y H:i:s', $coupon['expired']); ?></td>
                            <td><?php echo date('n/j/Y H:i:s', $coupon['created']); ?></td>
                        </tr>
                        <?php
                        endforeach;
                        ?>
                                    </table>
                                </div>
                                <ul class="detail-tab">
                                    <li class="on">Использованные купоны</li>
                                </ul>
                                <div class=" table-responsive">
                                    <table class="user-table">
                                        <tr>
                            <th width="20%">Код купона</th>
                            <th width="10%">Тип купона</th>
                            <th width="10%">Стоимость купона</th>
                            <th width="20%">Условие</th>
                            <th width="10%">Номер заказа</th>
                            <th width="10%">Saving</th>
                            <th width="10%">Дата использования</th>
                                        </tr>
                        <?php
                        foreach($used as $data):
                            $currency = Site::instance()->currencies($data['currency']);
                            ?>
                                        <tr>
                                            <td><?php echo $data['coupon_code']; ?></td>
                                            <td></td>
                                            <td></td>
                            <td>Любые товары с полной стоимостью</td>
                                            <td><a href="<?php echo LANGPATH; ?>/order/view/<?php echo $data['ordernum']; ?>"><?php echo $data['ordernum']; ?></a></a>
                                            </td>
                                            <td><?php echo $currency['code'] . $data['amount_coupon']; ?></td>
                                            <td><?php echo date('n/j/Y H:i:s', $data['created']); ?></td>
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

        <!-- footer begin -->

        <div id="gotop" class="hide">
            <a href="#" class="xs-mobile-top"></a>
        </div>
