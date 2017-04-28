
        <section id="main">
            <!-- crumbs -->
            <div class="container">
                <div class="crumbs">
                    <div>
                        <a href="<?php echo LANGPATH; ?>/">Главная Старница</a>
                        <a href="<?php echo LANGPATH; ?>/mobile-left"> > ЧЗВ</a> > Уровень VIP& Привилегия
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
                            <h2>Уровень VIP& Привилегия</h2>
                        </div>
                        <div class="vip table-responsive">
                            <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                <tbody>
                                    <tr>
                                        <th class="first" width="15%">
                    <div class="r">Привилегия</div>
                    <div>Уровень VIP</div>
                                        </th>
                    <th width="20%">Накопленная сумма сделки</th>
                    <th width="16%">Дополнительные скидки для товаров с полной стоимостью</th>
                    <th width="16%">Разрешение использования баллов</th>
                    <th width="15%">Бонусные баллы за заказ</th>
                    <th width="18%">Другие привилегии</th>
                                    </tr>
                    <tr>
                        <td><span class="icon_nonvip" title="Non-VIP"></span><strong>Non-VIP</strong></td>
                        <td>$0</td>
                        <td>/</td>
                        <td rowspan="6"><div>Вы может применить баллы в размере до 10% от стоимости заказа.</div></td>
                        <td rowspan="6">$1 = 1 балл</td>
                        <td>15% off код купона</td>
                    </tr>
                    <tr>
                        <td><span class="icon_vip" title="VIP"></span><strong>VIP</strong></td>
                        <td>$1 - $199</td>
                        <td>/</td>
                        <td rowspan="5"><div>Получите двойные баллы во время крупных праздников.<br>
                            Особый подарок на день рождения.<br>
                            Подробнее..</div></td>
                    </tr>
                    <tr>
                        <td><span class="icon_bronze" title="VIP Бронза"></span><strong>VIP Бронза</strong></td>
                        <td>$199 - $399</td>
                        <td>5% OFF</td>
                    </tr>
                    <tr>
                        <td><span class="icon_silver" title="VIP Серебра"></span><strong>VIP Серебра</strong></td>
                        <td>$399 - $599</td>
                        <td>8% OFF</td>
                    </tr>
                    <tr>
                        <td><span class="icon_gold" title="VIP Золота"></span><strong>VIP Золота</strong></td>
                        <td>$599 - $1999</td>
                        <td>10% OFF</td>
                    </tr>
                    <tr>
                        <td><span class="icon_diamond" title="VIP Бриллианты"></span><strong>VIP Бриллианты</strong></td>
                        <td>&ge; $1999</td>
                        <td>15% OFF</td>
                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="f00 mtb20">
                <b>Примечание: </b>
                <p>Если вы купили товары с использованием баллов, коды и стоимости доставки, не можете получить баллы. Надеюсь, вы можете нас понять.</p>
                        </div>
                        <p class="hidden-xs">
                            <img border="0" usemap="#Map" src="<?php echo STATICURL; ?>/ximg/<?php echo LANGUAGE; ?>/vip_img_<?php echo LANGUAGE; ?>.jpg">
                            <map id="Map" name="Map">
                                <area href="<?php echo LANGPATH; ?>/customer/summary" coords="598,272,760,294" shape="rect">
                            </map>
                        </p>
                    </article>
                </div>
            </div>
        </section>
        <!-- footer begin -->

        <div id="gotop" class="hide">
            <a href="#" class="xs-mobile-top"></a>
        </div>
