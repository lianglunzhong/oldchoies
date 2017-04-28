<style>
.order-list{margin-top:38px;}
.order-list table th,.order-list table td{ padding:10px; text-align:center; border:#e4e4e4 1px solid;text-transform:capitalize;}
.order-list table th{padding:8px;}
.order-list table td:second-child{text-decoration:underline;}
.order-list-btn{color:#fff; text-transform:uppercase; text-align:center; display:inline-block; cursor:pointer; background:#D8271C;padding:3px 12px;}
.order-list-btn:hover{ color:#fff;background:#ed7971;text-decoration:none;}
.recently-viewed{margin-top:40px; overflow:hidden;}
#personal-recs {
    width: 100%;
}
#personal-recs img {
    width: 157px;
}
.w_tit {
    border-bottom: 2px solid #000;
    margin-bottom: 20px;
    text-align: center;
}
.w_tit h2 {
    background-color: #fff;
    color: #000;
    display: inline-block;
    font-size: 18px;
    font-weight: normal;
    padding: 0 15px;
    position: relative;
    text-transform:capitalize;
    top: 8px;
}
.hide1{display:none;}
.hide-box1_0 li p b, .hide-box1_1 li p b, .hide-box1_2 li p b, .hide-box1_3 li p b{color: #000}
.box-current1{width:100%;height:30px;}
.box-current1 ul{margin-left:365px;}
</style>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Home</a>  >  Личный кабинет</div>
        </div>
        <?php echo Message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <dl class="box1">
                <dt>Привет, <?php echo $customer->get('firstname') ? $customer->get('firstname') : 'Choieser'; ?> .  Добро пожаловать на Choies.</dt>
                <?php
                $points = $customer->points();
                if ($customer->is_celebrity()):
                    ?>
                    <dd>Итого баллов:<span class="red"><?php echo $points; ?></span></dd>
                    <?php
                elseif (!$customer->get('vip_level')):
                    ?>
                    <dd>Итого баллов: <strong class="red mr10"><?php echo $points ? $points : 0; ?></strong>Итого сумма покупки: <strong class="red">0</strong></dd>
                    <dd>Ваш уровень:{ Non VIP }</dd>
                    <dd>Потратить $1 больше, вы станете членом VIP.</dd>
                    <?php
                else:
                    $vip_level = $customer->get('vip_level');
                    $vip = DB::select()->from('vip_types')->where('level', '=', $vip_level)->execute()->current();
                    $called = array(
                        1 => '',
                        2 => 'Бронза',
                        3 => 'Серебра',
                        4 => 'Золота',
                        5 => 'Бриллианты'
                    );
                    ?>
                    <dd>Итого баллов: <strong class="red mr10"><?php echo $points; ?></strong></dd>
                    <dd>Ваш уровень: { VIP <?php echo $called[$vip_level]; ?> }</dd>
                    <?php
                    if ($vip_level < 5):
                        $vip_called = $called[$vip_level + 1];
                        $vip_called = str_replace(array('Silver', 'Diamond'), array('Серебра', 'Бриллианты'), $vip_called);
                        ?>
                        <dd>Потратить <?php echo Site::instance()->price($vip['condition'], 'code_view'); ?> больше, вы станете { VIP <?php echo $vip_called; ?> }.</dd>
                        <?php
                    endif;
                    ?>
                <?php
                endif;
                $customer_id = $customer->get('id');
                $country = $customer->get('country');
                if (!$country)
                {
                    $country = DB::select('shipping_country')
                            ->from('orders_order')
                            ->where('customer_id', '=', $customer_id)
                            ->where('payment_status', '=', 'verify_pass')
                            ->execute()->get('shipping_country');
                    if($country)
                        DB::update('accounts_customers')->set(array('country' => $country))->where('id', '=', $customer_id)->execute();
                }
                if ($country)
                {
                    $country_customers = DB::select('id')->from('accounts_customers')->where('country', '=', $country)->execute()->as_array();
                    $find = array('id' => $customer_id);
                    $array_keys = array_keys($country_customers, $find);
                    $rank = $array_keys[0];
                    $country_name = DB::select('name')->from('countries')->where('isocode', '=', $country)->execute()->get('name');
                    $count_counrty = count($country_customers);
                    if($count_counrty > 50);
                    {
                        $rank += 50;
                        if($rank > $count_counrty)
                            $rank = $count_counrty;
                    }
                    ?>
                    <dd>Там уже <?php echo $count_counrty; ?> членов Choies в вашей стране, <?php echo $country_name; ?> , Ваш ранг является #<?php echo $rank; ?></dd>
                    <?php
                }
                $order_total = $customer->get('order_total');
                $vip_level = $customer->get('vip_level');
                $vip_amount = array();
                $vips = DB::select('level', 'condition')->from('vip_types')->execute()->as_array();
                foreach($vips as $v)
                {
                    $vip_amount[$v['level']] = $v['condition'];
                }
                $margin_right = 0;
                if ($vip_level == 0)
                {
                    $vip_left = 0;
                    $vip_width = 0;
                    $margin_right = 48;
                }
                elseif ($vip_level == 1)
                {
                    $extra = ($order_total - $vip_amount[0]) / ($vip_amount[1] - $vip_amount[0]);
                    $vip_left = 130 + floor($extra * 148);
                    $vip_width = 182 + floor($extra * 148);
                }
                elseif ($vip_level == 5)
                {
                    $vip_left = 705;
                    $vip_width = 745;
                }
                else
                {
                    $extra = ($order_total - $vip_amount[$vip_level - 1]) / ($vip_amount[$vip_level] - $vip_amount[$vip_level - 1]);
                    $vip_left = 130 + ($vip_level - 1) * 148 + floor($extra * 148);
                    $vip_width = 185 + ($vip_level - 1) * 148 + floor($extra * 148);
                }

                if ($vip_left > 668)
                {
                    $margin_right = 668 - $vip_left - 23;
                    $vip_left = 668;
                }
                ?>
            </dl>
            <div class="user_vip">
                <div class="user_vip_cursor" style="left:<?php echo $vip_left; ?>px;">
                    <span>Итого заказов:<?php echo Site::instance()->price($order_total, 'code_view', 'USD', array('name'=>'USD','code'=>'$','rate'=>1)); ?></span>
                    <em style="margin-right:<?php echo $margin_right; ?>px;"></em>
                </div>
                <div class="user_vip_b"></div>
                <div class="user_vip_t" style="width:<?php echo $vip_width; ?>px;"></div>
                <div class="user_vipname">
                    <span class="first">Non-VIP</span>
                    <span>VIP</span>
                    <span>VIP Бронза</span>
                    <span>VIP Серебра</span>
                    <span>VIP Золота</span>
                    <span class="last">VIP Бриллианты</span>
                </div>
            </div>
            <p class="center"><a class="view_btn btn26 btn40 JS_click">Смотреть политики VIP</a></p>
            <!-- vip -->
            <div class="vip JS_clickcon hide">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th width="15%" class="first">
                    <div class="r">Привилегии</div>
                    <div>Уровень VIP</div>
                    </th>
                    <th width="20%">Накопленная сумма сделки</th>
                    <th width="16%">Товары с дополнительной скидкой</th>
                    <th width="16%">Разрешения использования баллов</th>
                    <th width="15%">Награда баллов заказов</th>
                    <th width="18%">Другие привилегии</th>
                    </tr>
                    <tr>
                        <td><span class="icon_nonvip" title="Non-VIP"></span><strong>Non-VIP</strong></td>
                        <td>$0</td>
                        <td>/</td>
                        <td rowspan="6"><div>Вы можете использовать баллы в размере до 10% стоимости заказа.</div></td>
                        <td rowspan="6">$1 = 1 points</td>
                        <td>15% off код купона</td>
                    </tr>
                    <tr>
                        <td><span class="icon_vip" title="VIP"></span><strong>VIP</strong></td>
                        <td>$1 - $199</td>
                        <td>/</td>
                        <td rowspan="5"><div>Получите двойные баллы во время крупных праздников.<br>
                        Особый подарок на день рождения.<br>
                        И больше</div></td>
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
            <!--order-list-->
            <?php if(!empty($orders)){ ?>
            <div class="order-list fix">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr bgcolor="#e4e4e4">
                    <th width="20%"><strong>Дата заказа</strong></th>
                    <th width="20%"><strong>Номер заказа</strong></th>
                    <th width="15%"><strong>Итого заказа</strong></th>
                    <th width="15%"><strong>Стоимость доставки</strong></th>
                    <th width="15%"><strong>Статус Заказа</strong></th>
                    <th width="15%"><strong>Действие</strong></th>
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
                            $status = $order['refund_status'];
                        }else{
                            if($order['shipping_status']=="new_s" OR $order['shipping_status']=="pre_o")
                            {
                                $status=$order['payment_status'];
                            }else{
                                $status=$order['shipping_status'];
                            }
                        }
                        if ($status == 'new'){ $status = 'Неоплаченный'; }
                        elseif ($status == 'failed'){ $status = 'Безуспешно'; }
                        elseif ($status == 'success'){ $status = 'Успешно'; }
                        elseif ($status == 'pending'){ $status = 'в ожидании'; }
                        elseif ($status == 'partial_paid'){ $status = 'Частично Оплачен'; }
                        elseif ($status == 'processing'){ $status = 'Обработка'; }
                        elseif ($status == 'shipped'){ $status = 'Отправлен'; }
                        elseif ($status == 'partial_shipped'){ $status = 'Частично Отправлен'; }
                        elseif ($status == 'delivered'){ $status = 'Доставлено'; }
                        elseif ($status == 'prepare_refund'){ $status = 'Подготовка Возврата'; }
                        elseif ($status == 'partial_refund'){ $status = 'Частичный Возврат'; }
                        elseif ($status == 'refund'){ $status = 'Возврат'; }
                        echo ucfirst($status);
                        ?>
                    </td>
                    <td>
                    <?php
                    if($order['shipping_status'] == 'shipped' OR $order['shipping_status'] == 'partial_shipped'){
                        ?>
                        <a href="/track/customer_track?id=<?php echo $order['ordernum']; ?>" class="order-list-btn">Отслеживать</a>
                    <?php }else{
                    if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass'){ ?>
                    <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>">Детали заказа</a>
                    <?php }elseif (!$order['refund_status'] AND $order['amount'] > 0 AND ($order['payment_status']=="new" or $order['payment_status']=="failed")){ ?>
                        <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="order-list-btn">Платить</a>
                    <?php }else{ ?>
                        <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>">Детали заказа</a>
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
            $num=ceil($count/5);
        ?>
          <div class="recently-viewed"> 
            <div class="w_tit">
                <h2>последнее рассмотрение</h2>
            </div>
            <div id="personal-recs">
                <?php foreach($view_history as $id){
                if($i==0){ ?>
                <div class="hide-box1_0">
                <ul>
                <?php }elseif($i%5==0){ ?>
                <div class="hide-box1_<?php echo ceil($i/5); ?> hide1">
                <ul>
                <?php } ?>
                <li><a href="<?php echo Product::instance($id,LANGUAGE)->permalink(); ?>">
                    <img src="<?php echo Image::link(Product::instance($id)->cover_image(), 7); ?>" width="150"  /></a>
                  <p class="price">
                      <b><?php echo Site::instance()->price(Product::instance($id)->price(), 'code_view'); ?></b>
                   </p>
                </li>
                <?php
                $i++;
                if($i%5==0){
                    echo "</ul></div>";
                }
                } ?>
           </div>
       </div>
        <div class="box-current1">
          <ul>
            <li class="on"></li>
            <?php for($j=0;$j<$num-1;$j++){ ?>
            <li></li>
            <?php } ?>
          </ul>
        </div>
        
        <?php }else{ ?>
            <div class="recently-viewed"> 
            <div class="w_tit">
                <h2>Ходовые товары</h2>
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
                <div class="hide-box1_0">
                <ul>
                <?php }elseif($i%5==0){ ?>
                <div class="hide-box1_<?php echo ceil($i/5); ?> hide1">
                <ul>
                <?php } ?>
                <li><a href="<?php echo Product::instance($id,LANGUAGE)->permalink(); ?>">
                    <img src="<?php echo Image::link(Product::instance($id)->cover_image(), 7); ?>" width="150"  /></a>
                  <p class="price">
                      <b><?php echo Site::instance()->price(Product::instance($id)->price(), 'code_view'); ?></b>
                   </p>
                </li>
                <?php
                $i++;
                if($i%5==0){
                    echo "</ul></div>";
                }
                } ?>
           </div>
       </div>
        <div class="box-current1">
          <ul>
            <li class="on"></li>
            <?php 
            $num=ceil($i/5);
            for($j=0;$j<$num-1;$j++){ ?>
            <li></li>
            <?php } ?>
          </ul>
        </div>
        
        <?php } ?>      
        </article>
        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
    </section>
</section>
<script type="text/javascript">
var f=0;
var t1;
var tc1;
$(function(){
$(".box-current1 li").hover(function(){
$(this).addClass("on").siblings().removeClass("on");
var c=$(".box-current1 li").index(this);
$(".hide-box1_0,.hide-box1_1,.hide-box1_2,.hide-box1_3").hide();
$(".hide-box1_"+c).fadeIn(150);
f=c;
})
})
</script>