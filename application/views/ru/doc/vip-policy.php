<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Home</a>  >  Уровень VIP& Привилегия</div>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user doc flr">
            <div class="tit"><h2>Уровень VIP& Привилегия</h2></div>
            <!-- vip -->
            <div class="vip">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th width="15%" class="first">
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
                        <td rowspan="6"><div>Вы может применить баллы в размере до 10% от стоимости заказа</div></td>
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
                </table>
            </div> 
            <div class="f00 mtb20">
                <b>Примечание: </b>
                <p>Если вы купили товары с использованием баллов, коды и стоимости доставки, не можете получить баллы. Надеюсь, вы можете нас понять.</p>
            </div>
            <p><img src="/images/<?php echo LANGUAGE; ?>/vip_img_<?php echo LANGUAGE; ?>.jpg" border="0" usemap="#Map" />
                <map name="Map" id="Map">
                    <area shape="rect" coords="598,272,760,294" href="<?php echo LANGPATH; ?>/customer/summary" />
                </map>
            </p>
        </article>
        <?php echo View::factory(LANGPATH . '/doc/left'); ?>
    </section>
</section>