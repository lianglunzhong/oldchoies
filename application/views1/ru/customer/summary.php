<section id="main">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs">
            <div>
                <a href="<?php echo LANGPATH; ?>/">home</a> > Личный кабинет
            </div>
        </div>
    </div>
    <!-- main-middle begin -->
    <div class="container">
        <div class="row">
<?php
$url = URL::current(0);
$lists = array(
   'Мои Заказы' => array(
        array(
            'name' => 'История заказов',
            'link' => LANGPATH . '/customer/orders'
        ),
        array(
            'name' => 'Неоплаченные Заказы',
            'link' => LANGPATH . '/customer/unpaid_orders'
        ),
        array(
            'name' => 'Items to review',
            'link' => '#'
        ),
        array(
            'name' => 'Избранное',
            'link' => LANGPATH . '/customer/wishlist'
        ),
        array(
            'name' => 'Отслеживать заказ',
            'link' => LANGPATH . '/tracks/track_order'
        ),
    ),
    'МОЙ ПРОФИЛЬ' => array(
        array(
            'name' => 'Настройка профиля',
            'link' => LANGPATH . '/customer/profile'
        ),
        array(
            'name' => 'Изменение пароля',
            'link' => LANGPATH . '/customer/password'
        ),
        array(
            'name' => 'Адресная книга',
            'link' => LANGPATH . '/customer/address'
        ),
        array(
            'name' => 'Создать адрес',
            'link' => LANGPATH . '/address/add'
        )
    ),
    'Мои Купоны и баллы' => array(
        array(
            'name' => 'История баллов',
            'link' => LANGPATH . '/customer/points_history'
        ),
        array(
            'name' => 'Social Sharing Bonus',
            'link' => '#'
        ),
        array(
            'name' => 'Мои купоны',
            'link' => LANGPATH . '/customer/coupons'
        ),
    ),
);

$customer_id = Customer::logged_in();
$email = Customer::instance($customer_id)->get('email');
$celebrity = DB::select('id')->from('celebrities_celebrits')->where('email', '=', $email)->execute()->get('id');
if ($celebrity)
{
    $lists['МОЙ ПРОФИЛЬ'][] = array(
        'name' => 'Мое шоу блога',
        'link' => LANGPATH . '/customer/blog_show'
    );
}
?>
<aside id="aside" class="col-sm-3 col-xs-10 col-xs-offset-2 col-sm-offset-0">
    <a href="<?php echo LANGPATH; ?>/customer/summary" class="user-home hidden-xs">Личный кабинет</a>
    <?php
    foreach ($lists as $title => $link):
        ?>
        <div class="category-box aside-box">
            <h3 class="bg"><?php echo $title; ?></h3>
            <ul class="scroll-list">
                <?php
                foreach ($link as $l):
                    if (!$l['link'] OR $l['link'] == '#')
                        continue;
                    ?>
                    <li><a  href="<?php echo $l['link']; ?>"<?php if ($url == $l['link']) echo ' class="on"'; ?>><?php echo $l['name']; ?></a></li>
                    <?php
                endforeach;
                ?>
            </ul>
        </div>
        <?php
    endforeach;
    ?>
    <a href="<?php echo LANGPATH; ?>/customer/logout" class="user-home">Выход</a>
</aside>

                    <article class="user user-account col-sm-9 hidden-xs">
                        <dl>
                            <dt>Привет,  <?php echo $customer->get('firstname') ? $customer->get('firstname') : 'Choieser'; ?> .  Добро пожаловать на Choies.</dt>
                            <?php
                            $points = $customer->points();
                            if ($customer->is_celebrity()):
                            ?>
                            <dd>Итого баллов:<strong class="mr10"><?php echo $points; ?></strong>   Итого сумма покупки:<strong>0</strong>
                            </dd>
                    <?php
                elseif (!$customer->get('vip_level')):
                    ?><dd>Итого баллов: <strong class="mr10"><?php echo $points ? $points : 0; ?></strong>
                    Итого сумма покупки: <strong>0</strong>
                            </dd>
                            <dd>Ваш уровень:{<strong>   Non VIP  </strong>}</dd>
                            <dd>Потратить $1 больше, вы станете членом VIP.</dd>
                    <?php
                else:
                    $vip_level = $customer->get('vip_level');
                    if(!$vip_level){
                        $vip_level = 0;
                    }
                    $vip = $vipconfig[$vip_level]; 
                    $called = array(
                        1 => '',
                        2 => 'Бронза',
                        3 => 'Серебра',
                        4 => 'Золота',
                        5 => 'Бриллианты'
                    );
                    ?>
                    <dd>Итого баллов: <strong class="mr10"><?php echo $points; ?></strong>
                    <!--Total purchased amount:<strong>0</strong>-->
                            </dd>
                            <dd>Ваш уровень:{<strong>   <?php echo $called[$vip_level]; ?> VIP  </strong>}</dd>
                        <?php
                        if ($vip_level < 5):
                            ?>
                            <dd>Потратить  <?php echo $vip['condition']; ?> больше, вы станете  {<?php 
                            $vip_called = $called[$vip_level + 1];
                        $vip_called = str_replace(array('Silver', 'Diamond'), array('Серебра', 'Бриллианты'), $vip_called);
                            echo $vip_called; 
                         ?> VIP}.</dd>
                                <?php
                            endif;                      
                        ?>
                <?php endif;
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
                $order_total = $customer->get('order_total');
                $vip_level = $customer->get('vip_level');
                $vip_amount = array();
                $vips = $vipconfig;
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
                    $vip_left = 150 + floor($extra * 100);
                    $vip_width = 200 + floor($extra * 100);
                    $margin_right = -($vip_left - $vip_width);
                }
                elseif ($vip_level == 5)
                {
                    $vip_left = 705;
                    $vip_width = 745;
                }
                else
                {
                    $extra = ($order_total - $vip_amount[$vip_level - 1]) / ($vip_amount[$vip_level] - $vip_amount[$vip_level - 1]);
                    $vip_left = 210 + ($vip_level - 1) * 100 + floor($extra * 100);
                    $vip_width = 250 + ($vip_level - 1) * 100 + floor($extra * 100);
                    //$margin_right = $order_total - $vip_left;
                }

                if ($vip_left > 668)
                {
                    $margin_right = 668 - $vip_left - 23;
                    $vip_left = 668;
                }
                ?>
            </dl>               
                    <div class="user-vip hidden-sm ">
                            <div class="user-vip-cursor" style="left:<?php echo $vip_left; ?>px;"><span>Итого заказов:<?php echo Site::instance()->price($order_total, 'code_view', 'USD', array('name'=>'USD','code'=>'$','rate'=>1)); ?></span><em style="margin-right:<?php echo $margin_right; ?>px;"></em>
                            </div>
                            <div class="user-vip-b"></div>
                            <div class="user-vip-t" style="width:<?php echo $vip_width; ?>px;"></div>
                            <div class="user-vipname">
                <span class="first">Non-VIP</span>
                    <span>VIP</span>
                    <span>VIP Бронза</span>
                    <span>VIP Серебра</span>
                    <span>VIP Золота</span>
                    <span class="last">VIP Бриллианты</span>
                            </div>
                        </div>
                        <p class="user-vip-btn"><a class="btn btn-primary btn-sm JS_click">Смотреть политики VIP</a>
                        </p>
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
                                    <td><span class="icon-nonvip" title="Non-VIP"></span><strong>Non-VIP</strong>
                                    </td>
                                    <td>$0</td>
                                    <td>/</td>
                                    <td rowspan="6">
                                        <div>Вы можете использовать баллы в размере до 10% стоимости заказа.</div>
                                    </td>
                                    <td rowspan="6">$1 = 1 points</td>
                                      <td>15% off код купона</td>
                                </tr>
                                <tr>
                                    <td><span class="icon-vip" title="VIP"></span><strong>VIP</strong>
                                    </td>
                                    <td>$1 - $199</td>
                                    <td>/</td>
                                    <td rowspan="5">
                        <div>Получите двойные баллы во время крупных праздников.<br>
                        Особый подарок на день рождения.<br>
                        И больше</div>
                                    </td>
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
                            if($order['shipping_status']=="new_s" OR $order['shipping_status']=="pre_o")
                            {
                                $status=$order['payment_status'];
                            }else{
                                $status=$order['shipping_status'];
                            }
                        }
                     if ($status == 'new'){ $status = 'Неоплаченный'; }
                        elseif ($status == 'Unpaid'){ $status = 'Неоплаченный'; }
                        elseif ($status == 'cancel'){ $status = 'отменить'; }
                        elseif ($status == 'failed'){ $status = 'Безуспешно'; }
                        elseif ($status == 'success'){ $status = 'Успешно'; }
                        elseif ($status == 'pending'){ $status = 'в ожидании'; }
                        elseif ($status == 'partial_paid'){ $status = 'Частично Оплачен'; }
                        elseif ($status == 'processing'){ $status = 'Обработка'; }
                        elseif ($status == 'shipped'){ $status = 'Отправлен'; }
                        elseif ($status == 'partial shipped'){ $status = 'Частично Отправлен'; }
                        elseif ($status == 'delivered'){ $status = 'Доставлено'; }
                        elseif ($status == 'prepare refund'){ $status = 'Подготовка Возврата'; }
                        elseif ($status == 'partial refund'){ $status = 'Частичный Возврат'; }
                        elseif ($status == 'refund'){ $status = 'Возврат'; }
                        echo ucfirst($status);
                        ?>
                    </td>
                    <td>
                    <?php
                    if($order['shipping_status'] == 'shipped' OR $order['shipping_status'] == 'partial_shipped'){
                        ?>
                        <a href="<?php echo LANGPATH; ?>/tracks/customer_track?id=<?php echo $order['ordernum']; ?>" class="order-list-btn">Отслеживать</a>
                    <?php }else{
                    if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                    {?>
                    <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>">Детали заказа</a>
                    <?php }elseif (!$order['refund_status'] AND $order['amount'] > 0 AND ($order['payment_status']=="new" or $order['payment_status']=="failed")){ ?>
                        <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="btn btn-primary btn-xs">Платить</a>
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
                        $num=ceil($count/7);
                    ?>  
                        <div class="box-dibu1">
                            <div class="w-tit">
                                <h2>последнее рассмотрение</h2>
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

                <li><a href="<?php echo Product::instance($id,LANGUAGE)->permalink(); ?>">
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
        <?php       }else{ ?>
        
                            <div class="recently-viewed">
                            <div class="w-tit">
                                <h2>Meilleures Ventes</h2>
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

                <li><a href="<?php echo Product::instance($id,LANGUAGE)->permalink(); ?>">
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

        <!-- footer begin -->

        <div id="gotop" class="hide">
            <a href="#" class="xs-mobile-top"></a>
        </div>
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



