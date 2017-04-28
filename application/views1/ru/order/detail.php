<section id="main">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs">
            <div>
                <a href="<?php echo LANGPATH; ?>/">home</a>
                <a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > Личный кабинет</a> > Детали заказа
            </div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <!-- main-middle begin -->
    <div class="container">
        <div class="row">
<?php echo View::factory(LANGPATH . '/customer/left'); ?>
<?php echo View::factory(LANGPATH . '/customer/left_1'); ?>
            <article class="user col-sm-9 hidden-xs">
                <div class="tit">
                    <h2>Детали заказа</h2>
                </div>
                <!-- user-step -->
<?php if (in_array($order->get('payment_status'), array('new', 'failed')) OR $order->get('refund_status')=='refund' ) { ?>
                <div class="step-nav">
                <ul class="clearfix">
                    <li class="current">Размещение Заказа<em></em><i></i></li>
                    <li>Обработка Заказа<em></em><i></i></li>
                    <li>Заказ Отправлен<em></em><i></i></li>
                </ul>
                </div>
                <br />
<?php }elseif ( in_array($order->get('payment_status'), array('success', 'verify_pass')) and !in_array($order->get('shipping_status'), array('shipped', 'partial_shipped','delivered'))  ) { ?>
                <!-- user-step1-on -->
                <div class="step-nav">
                <ul class="clearfix">
                    <li>Размещение Заказа<em></em><i></i></li>
                    <li class="current">Обработка Заказа<em></em><i></i></li>
                    <li>Заказ Отправлен<em></em><i></i></li>
                </ul>
                </div>
                <br />
                <!-- user-step1-pass 
                <div class="user-step ">
                    <em class="step1-pass"></em>
                    <div class="user-step-bottom">
                        <span class="pass">Order Placement</span>
                        <span>Order Processing</span>
                        <span>Order Shipped</span>
                    </div>
                </div>-->
                <!-- user-step2-on -->
<?php }elseif ( in_array($order->get('shipping_status'), array('shipped', 'partial_shipped','delivered')) ) { ?>        
                <div class="step-nav">
                <ul class="clearfix">
                    <li>Размещение Заказа<em></em><i></i></li>
                    <li>Обработка Заказа<em></em><i></i></li>
                    <li class="current">Заказ Отправлен<em></em><i></i></li>
                </ul>
                </div>
                <br />
                <!-- user-step2-pass
                <div class="user-step ">
                    <em class="step2-pass"></em>
                    <div class="user-step-bottom">
                        <span class="pass">Order Placement</span>
                        <span class="pass">Order Processing</span>
                        <span>Order Shipped</span>
                    </div>
                </div> -->
                <!-- user-step3-on -->
      <?php }else{ ?>
                <div class="step-nav">
                <ul class="clearfix">
                    <li>Размещение Заказа<em></em><i></i></li>
                    <li class="current">Обработка Заказа<em></em><i></i></li>
                    <li>Заказ Отправлен<em></em><i></i></li>
                </ul>
                </div>
                <br />
                <!-- user-step3-pass 
                <div class="user-step ">
                    <em class="step3-pass"></em>
                    <div class="user-step-bottom">
                        <span class="pass">Order Placement</span>
                        <span class="pass">Order Processing</span>
                        <span class="pass">Order Shipped</span>
                    </div>
                </div>-->
              <?php } ?>
                <div class="order-top ">
                    <span>Номер заказа: <b><?php $orderd = $order->get();echo $orderd['ordernum']; ?></b></span>Дата заказа: <?php echo date('m/d/Y H:i:s', $orderd['created']); ?>
                </div>

                <table class="user-table shopping-table" width="100%">
                    <tr>
      <th width="35%" class="first">Название</th>                  
      <th width="10%" class="second">Цена</th>   
      <th width="5%">Количество</th>
      <th width="10%">Итого</th>
      <th width="10%">Статус Заказа</th>
      <th width="15%">Отслеживать по номеру</th>                            
      <th width="15%">Действие</th>
                    </tr>
    <?php
        $currency = Site::instance()->currencies($orderd['currency']);
        $amount = 0;
        $d_amount = 0;
        $d_skus = array();
        foreach ($order->products() as $key => $product):
            if($product['status'] == 'cancel')
                continue;
            $product_inf = DB::select('stock', 'visibility', 'status', 'price', 'sku', 'name', 'link')->from('products_' . LANGUAGE)->where('id', '=', $product['product_id'])->execute()->current();
            $outstock = 0;
            if ($orderd['payment_status'] == 'success' OR $orderd['payment_status'] == 'verify_pass')
            {
              $amount += $product['price'] * $product['quantity'] * $orderd['rate'];
            }
            else
            {
                if (!$product_inf['visibility'] OR !$product_inf['status'] OR $product_inf['stock'] == 0)
                {
                    $outstock = 1;
                }
                elseif ($product_inf['stock'] == -1)
                {
                    $stocks = DB::select()
                        ->from('products_stocks')
                        ->where('product_id', '=', $product['product_id'])
                        ->where('stocks', '<>', 0)
                        ->execute();
                    $has = 0;
                    foreach ($stocks as $stock)
                    {

                        if (strpos($product['attributes'], $stock['attributes']) !== FALSE)
                        {
                            if ($product['quantity'] > $stock['stocks'])
                                $product['quantity'] = $stock['stocks'];
                            $amount += $product['price'] * $product['quantity'] * $orderd['rate'];
                            $has = 1;
                            break;
                        }
                    }
                    if (!$has)
                        $outstock = 1;
                }
                else
                {
                    $amount += $product['price'] * $product['quantity'] * $orderd['rate'];
                }
            }
    ?>
                    <tr>
                        <td>
                            <div class="product-name">
                                <div class="left">
<a href="<?php echo LANGPATH; ?>/product/<?php echo $product_inf['link']; ?>"><img src="<?php echo image::link(Product::instance($product['product_id'])->cover_image(), 3); ?>" /></a>
                                </div>
                                <div class="right">
            <a href="<?php echo LANGPATH; ?>/product/<?php echo $product_inf['link']; ?>" class="name"><?php echo $product_inf['name']; ?></a>
            <?php if ($outstock): ?><div class="red">(Нет в наличии)</div><?php endif; ?>
            <p class="bottom">
              <?php
               $attributes = str_replace(';', ';<br>', $product['attributes']);
              $attributes = str_replace('one size', 'только один размер', $attributes);
              $attributes = str_replace(array('Size', 'Color'), array('Размеры', 'Цвет'), $attributes);
              echo $attributes;
              ?>
            </p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <del>            
                            <?php
        $p_price = $product_inf['price'];
        echo Site::instance()->price($p_price, 'code_view', NULL, $currency);
        ?></del>
                            <p><b class="red"><?php echo $currency['code'] . round($product['price'] * $orderd['rate'], 2); ?></b>
                            </p>
                        </td>
                        <td><?php echo $product['quantity']; ?></td>
                        <td><?php echo $currency['code'] . round($product['price'] * $orderd['rate'], 2) * $product['quantity']; ?></td>
                        <td>                  <?php
          if($orderd['refund_status'])
          {
               $status = 'Remboursé';
          }
          else
          {
            $status = kohana::config('order_status.payment.' . $orderd['payment_status'] . '.name');
            $shipstatus = kohana::config('order_status.shipment.' . $orderd['shipping_status'] . '.name');
            if ($status == 'New' OR $status == 'new'){
                        $status = "Новинка";
                    }elseif($status == 'failed' OR $status == 'Failed'){
                        $status = "Échoué";
                    }elseif($status == 'cancel' OR $status == 'Cancel'){
                        $status = "Annulé";
                    }elseif($shipstatus == 'processing' OR $shipstatus == 'Processing'){
                        $status = "Traitement";
                    }elseif($shipstatus == 'partial shipped' OR $shipstatus == 'Partial Shipped'){
                        $status = "expédié partiellement";
                    }elseif($shipstatus == 'shipped' OR $shipstatus == 'Shipped'){
                        $status = "уже отправился";
                    }elseif($shipstatus == 'delivered' OR $shipstatus == 'Delivered'){
                        $status = "Livré";
                    }
          }
          echo ucfirst($status);
          ?></td>
                        <td>      
                        <?php
        $shipments = $order->shipments();
        if (isset($shipments[$key])):
          echo $shipments[$key]['tracking_code'];
          echo "<br><a class=\"red\" href=\"/tracks/customer_track?id=".$orderd['ordernum']."\">Отслеживать заказ</a>";
        endif;
        $domain = URLSTR;
        ?></td>
                        <td>
                            Поделиться С
                            <p class="share">
        <a target="_blank" href="http://www.facebook.com/sharer.php?u=https%3A%2F%2F<?php echo $domain; ?>%2Fproduct%2F<?php echo Product::instance($product['product_id'])->get('link'); ?>" class="a1"></a>
        <a target="_blank" href="http://twitter.com/share?url=https%3A%2F%2F<?php echo $domain; ?>%2Fproduct%2F<?php echo Product::instance($product['product_id'])->get('link'); ?>" class="a2"></a>
        <a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(Product::instance($product['product_id'])->permalink()); ?>&media=<?php echo Image::link(Product::instance($product['product_id'])->cover_image(), 1); ?>&description=<?php Product::instance($product['product_id'])->get('name'); ?>" class="a3"></a>
                            </p>
        <?php
        if ($orderd['payment_status'] == 'success' OR $orderd['payment_status'] == 'verify_pass')
        {
            if($product['erp_line_status'] == 1)
            {
                $is_approve = DB::select('is_approved')->from('reviews')->where('order_id', '=', $product['order_id'])->where('product_id', '=', $product['product_id'])->execute()->get('is_approved');
                if($is_approve)
                {
                ?>
                <a href="<?php echo LANGPATH; ?>/product/<?php echo $product_inf['link'] . '_p' . $product['product_id']; ?>#review_list" class="a-underline">Обзор</a>
                <?php
                }
                else
                {
                ?>
                <a class="a-underline">Обзор</a> 
                <?php
                }
            }
            else
            {
            ?>
                <a href="<?php echo LANGPATH; ?>/review/add/<?php echo $product['product_id']; ?>" class="a-underline review_link">Написать отзыв</a>
            <?php
            }
        }
        ?>
                        </td>
                    </tr>
    <?php
    endforeach;
    $delete_product = isset($d_product) ? implode(',', $d_product) : '';
    $amount_order = $amount + $orderd['amount_shipping'];
    if ($amount_order > $orderd['amount'])
        $amount_order = $orderd['amount'];
    if (in_array($orderd['payment_status'], array('new', 'failed')) AND $amount_order == 0)
        $amount_order = $orderd['amount'];
    $oi_insurance = 0;
    ?>
                </table>
                <ul class="total">
                    <li>
                        <label>Итого без доставки: </label><span><?php echo $currency['code'] . round($order->get('amount_products') - $d_amount, 2); ?></span>
                    </li>
                    <li>
                        <label>Доставка: </label><span><?php echo $currency['code'] . round($orderd['amount_shipping'], 2); ?></span>
                    </li>
                    <?php if($orderd['order_insurance']){ ?>
                    <li>
                <?php        $oi_insurance = $orderd['order_insurance'] * $orderd['rate']; ?>
                        <label>страхование доставки: </label><span><?php echo $currency['code'] . round($oi_insurance, 2); ?></span>
                    </li>
                    <?php } ?>

                   <?php if($orderd['points'] || $orderd['amount_coupon']){ 
                        $mon = $orderd['amount_coupon'] + $orderd['points'] / 100;
                        $mon = $mon * $orderd['rate'];
                        ?>
                    <li>
                         <label>Платеж с купоном и баллами: </label><span><?php echo $currency['code'] . round($mon, 2); ?></span>
                    </li>
                    <?php } ?>

                    <li>
                        <label>Итого:</label><span>       
                        <?php
      if($orderd['payment_status'] == 'success' OR $orderd['payment_status'] == 'verify_pass'){
          $amount_order = $orderd['amount'];
          echo $currency['code'] . round($amount_order, 2); 
      }else{
            $amount_order = $amount_order + $oi_insurance;
        echo $currency['code'] . round($amount_order, 2); 
      }
      ?></span>
                    </li>
                </ul>
                <div class="order-dl">
<?php
$success = 0;
if (in_array($orderd['payment_status'], array('success', 'verify_pass', 'pending')))
    $success = 1;
?>
                    <dl class="first">
                        <dt>АДРЕСЫ ДОСТАВКИ</dt>
                        <dd><?php echo $orderd['shipping_firstname'] . ' ' . $orderd['shipping_lastname']; ?></dd>
                        <dd><?php echo $orderd['shipping_address'] . ' ' . $orderd['shipping_city'] . ', ' . $orderd['shipping_state'] . ' ' . $orderd['shipping_country'] . ' ' . $orderd['shipping_zip']; ?></dd>
                        <dd><?php echo $orderd['shipping_phone']; ?></dd>
                    </dl>
                    <dl>
                        <dt>Деталь доставки</dt>
                        <dd><?php echo $orderd['amount_shipping'] > 0 ? 'Эксперсс-доставка' : 'Бесплатная Доставка'; ?></dd>
                    </dl>
                    <dl class="last">
                        <dt>Метод платежа</dt>
                <?php
                if ($success):
                ?>    <dd>       
Amount: <?php echo $currency['code'] . round($amount_order, 2); ?></dd>        
                        <dd>Вы заплатили <?php echo $currency['code'] . round($amount_order, 2); ?>  по:</dd>
        <?php
        if ($orderd['payment_method'] == 'PP' OR $orderd['payment_method'] == 'PPEC')
        {
        ?>
            <img src="/assets/images/card5.jpg" style="display:inline-block;" />
        <?php
        }
        else
        {
        ?>
            <img src="/assets/images/card2.jpg" />
        <?php
        }            else:
    ?>
                        <dd>
                            <form action="" method="post" class="shipping-methods"   id="payment_form">
      <input type="hidden" name="amount" value="<?php echo $amount; ?>" />
      <input type="hidden" name="delete_product" value="<?php echo $delete_product; ?>" />
                                <dd>Вы будете платить  <?php echo $currency['code'] . round($amount_order, 2); ?>  по:</dd>
                                <ul id="payment_select">
                                    <li>
                                        <input type="radio" value="PP" id="radio1" class="radio" name="payment_method" <?php if ($orderd['payment_method'] == 'PP') echo 'checked'; ?> />
                                        <label for="radio1">
                                            <img src="/assets/images/card5.jpg" style="display:inline-block;" /><em class="icon-tips JS_shows_btn1"><span class="JS_shows1 icon-tipscon hide">Если у вас нет счет PayPal, вы также можете оплатить через PayPal с помощью кредитной карты или банковской платежной карты.
   <img src="/assets/images/card1.jpg" /></span></em>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" value="GC" id="radio2" class="radio" name="payment_method" <?php if ($orderd['payment_method'] == 'GC') echo 'checked'; ?> />
                                        <label for="radio2">
                                            <img src="/assets/images/card2.jpg" />
                                        </label>
                                    </li>
        <?php
        $sofort_countries = array(
            'DE' => 'EUR', 'AT' => 'EUR', 'CH' => 'EUR', 'BE' => 'EUR', 'FR' => 'EUR',
            'IT' => 'EUR', 'GB' => 'GBP', 'ES' => 'EUR', 'NL' => 'EUR', 'PL' => 'PLN',
        );
        if(array_key_exists($orderd['shipping_country'], $sofort_countries))
        {
        ?>                                            <li>
                                        <input type="radio" value="SOFORT" id="radio3" class="radio" name="payment_method" <?php if ($orderd['payment_method'] == 'SOFORT') echo 'checked'; ?> />
                                        <label for="radio3">
                                            <img src="/assets/images/card12.jpg" />
                                        </label>
                                    </li>
                                    <?php
                                    }
                                    ?>
        <?php
        if($orderd['shipping_country'] == 'NL')
        {
        ?>
                                <li>
                                        <input type="radio" value="IDEAL" id="radio4" class="radio" name="payment_method" <?php if ($orderd['payment_method'] == 'IDEAL') echo 'checked'; ?> />
                                        <label for="radio4">
                                            <img src="/assets/images/card13.jpg" />
                                        </label>
                                </li>
        <?php
        }
        ?>
      <?php if (in_array($order->get('payment_status'), array('new', 'failed')) && $amount>0):?>
                                    <li class="last">
                                        <p>
                                            <input type="button" value="Подтвердить и оплатить" class="btn btn-primary btn-sm" onclick="return payment_submit();"  />
                                        </p>
                                    </li>
                                </ul>
                        
                        <?php endif; ?>
                    <!-- </form> -->
                    <?php endif;?>                                    
                        </dd>
                    </dl>
                </div>
                </form>
                <div style="width:500px;text-align:left;">
                    <label>Сообщение:</label>
                    <br>
                    <label style="color:#999;height:20px;font-weight:normal;">(5-100 символов)</label>
<div id="now_message" style="font-weight:normal;color:#8f8f8f;<?php if(!$order_message) echo 'display:none;'; ?>"><?php echo $order_message; ?></div>
<a href="javascript:;" onclick="editMessage();" id="message_edit" style="text-decoration: underline;<?php if(!$order_message) echo 'display:none;'; ?>">Edit</a>
                    <div id="set_message" style="<?php if($order_message) echo 'display:none;'; ?>">
                        <form class="form" method="post" action="<?php echo LANGPATH; ?>/order/set_message">
        <input type="hidden" name="order_id" value="<?php echo $order->get('id'); ?>" />
                            <div class="right-box">
                                <textarea class="textarea-long" style="width: 550px; height: 100px;background-color: #fff;" name="message"  maxlength="200" minlength='5'><?php echo $order_message; ?></textarea>
                                <input class="btn btn-default btn-sm mt10" type="submit" style="font-weight:normal;" value="Дальше">
                            </div>
                        </form>
                        <script>
                            $(".form").validate({
                                rules: {
                                    message: {
                                        required: true,
                                        minlength:5,
                                        maxlength:200
                                    }
                                },
                            });
                        </script>
                    </div>
                </div>
                <div class="cartbag-bottom">
<a class="s1" target="_blank" href="<?php echo LANGPATH; ?>/privacy-security">Гарантированная Безопасность заказа</a>
<a class="s2" target="_blank" href="<?php echo LANGPATH; ?>/shipping-delivery">Бесплатная доставка по всему миру</a>
<a class="s3" target="_blank" href="<?php echo LANGPATH; ?>/returns-exchange">60-Дневная Гарантия Возврата Денег</a>
                </div>
            </article>

            <article class="order-detail-unpaid-mobile col-sm-12 hidden-sm hidden-md hidden-lg">
                <table class="user-table">
                    <tbody>
    <?php
        $currency = Site::instance()->currencies($orderd['currency']);
        $amount = 0;
        $d_amount = 0;
        $d_skus = array();
        foreach ($order->products() as $key => $product):
            if($product['status'] == 'cancel')
                continue;
            $product_inf = DB::select('stock', 'visibility', 'status', 'price', 'sku', 'name', 'link')->from('products_' . LANGUAGE)->where('id', '=', $product['product_id'])->execute()->current();
            $outstock = 0;
            if ($orderd['payment_status'] == 'success' OR $orderd['payment_status'] == 'verify_pass')
            {
              $amount += $product['price'] * $product['quantity'] * $orderd['rate'];
            }
            else
            {
                if (!$product_inf['visibility'] OR !$product_inf['status'] OR $product_inf['stock'] == 0)
                {
                    $outstock = 1;
                }
                elseif ($product_inf['stock'] == -1)
                {
                    $stocks = DB::select()
                        ->from('products_stocks')
                        ->where('product_id', '=', $product['product_id'])
                        ->where('stocks', '<>', 0)
                        ->execute();
                    $has = 0;
                    foreach ($stocks as $stock)
                    {

                        if (strpos($product['attributes'], $stock['attributes']) !== FALSE)
                        {
                            if ($product['quantity'] > $stock['stocks'])
                                $product['quantity'] = $stock['stocks'];
                            $amount += $product['price'] * $product['quantity'] * $orderd['rate'];
                            $has = 1;
                            break;
                        }
                    }
                    if (!$has)
                        $outstock = 1;
                }
                else
                {
                    $amount += $product['price'] * $product['quantity'] * $orderd['rate'];
                }
            }
    ?>
                        <tr>
                            <td width="30%">
                                <a href="<?php echo LANGPATH; ?>/product/<?php echo $product_inf['link']; ?>">
                                    <img src="<?php echo image::link(Product::instance($product['product_id'])->cover_image(), 3); ?>" />
                                </a>
                            </td>
                            <td width="70%" align="left">
                                <a href="#" class="name"><?php echo $product_inf['name']; ?></a>
                                <p>       
                                <?php
              $attributes = str_replace(';', ';<br>', $product['attributes']);
              $attributes = str_replace('one size', 'только один размер', $attributes);
              $attributes = str_replace(array('Size', 'Color'), array('Размеры', 'Цвет'), $attributes);
              echo $attributes;
              ?></p>
                                <p>Количество: <?php echo $product['quantity']; ?></p>
                                <p>Цена: <?php echo $currency['code'] . round($product['price'] * $orderd['rate'], 2); ?></p>
                            </td>
                        </tr>
    <?php
    endforeach; ?>
                        <tr class="tol-mobile">
                            <td width="30%"></td>
                            <td class="align-right" width="70%">
                                <p>Итого:  <?php echo $currency['code'] . round($order->get('amount_products') - $d_amount, 2); ?></p>
                                <p>Доставка: <?php echo $currency['code'] . round($orderd['amount_shipping'], 2); ?></p>
                                <?php if($orderd['order_insurance']){ 
                                $oi_insurance = $orderd['order_insurance'] * $orderd['rate'];  ?>
                                <p>страхование доставки: <?php echo $currency['code'] . round($oi_insurance, 2); ?>
                                 </p>
                               <?php } ?>
                    <?php if($orderd['points'] || $orderd['amount_coupon']){ 
                        $mon = $orderd['amount_coupon'] + $orderd['points'] / 100;
                        $mon = $mon * $orderd['rate'];
                        ?>
                    <p>
                    Платеж с купоном и баллами: <?php echo $currency['code'] . round($mon, 2); ?>
                    </p>
                    <?php } ?>
                                <p><strong>Order Total:      
                                <?php
      if($orderd['payment_status'] == 'success' OR $orderd['payment_status'] == 'verify_pass')
          $amount_order = $orderd['amount'];
      echo $currency['code'] . round($amount_order, 2); 
      ?></strong>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <form action="" method="post" class="shipping-methods" id="payment_form1">
<?php
$success = 0;
if (in_array($orderd['payment_status'], array('success', 'verify_pass', 'pending')))
    $success = 1;
?>
                        <ul>
                            <li>
                                <input type="hidden" name="amount" value="<?php echo $amount; ?>" />
                                <input type="hidden" name="delete_product" value="<?php echo $delete_product; ?>" />
                                <input type="radio" value="PP" id="radio11" class="radio" name="payment_method" checked="checked" <?php if ($orderd['payment_method'] == 'PP') echo 'checked'; ?>  />
                                <label for="radio11">
                                    <img src="/assets/images/card5.jpg" style="display:inline-block;" /><em class="icon-tips1 JS_shows_btn1"><span class="JS_shows1 icon-tipscon1 hide" >Если у вас нет счет PayPal, вы также можете оплатить через PayPal с помощью кредитной карты или банковской платежной карты. 

    or bank debit card.<img src="/assets/images/card1.jpg" /></span></em>
                                </label>
                            </li>
                            <li>
                                <input type="radio" value="GC" id="radio12" class="radio" name="payment_method" <?php if ($orderd['payment_method'] == 'GC') echo 'checked'; ?>  />
                                <label for="radio12">
                                    <img src="/assets/images/card2.jpg" />
                                </label>
                            </li>
        <?php
        $sofort_countries = array(
            'DE' => 'EUR', 'AT' => 'EUR', 'CH' => 'EUR', 'BE' => 'EUR', 'FR' => 'EUR',
            'IT' => 'EUR', 'GB' => 'GBP', 'ES' => 'EUR', 'NL' => 'EUR', 'PL' => 'PLN',
        );
        if(array_key_exists($orderd['shipping_country'], $sofort_countries))
        { ?>
                            <li>
                                <input type="radio" value="SOFORT" id="radio13" class="radio" name="payment_method" <?php if ($orderd['payment_method'] == 'SOFORT') echo 'checked'; ?>  />
                                <label for="radio13">
                                    <img src="/assets/images/card12.jpg" />
                                </label>
                            </li>
        <?php
        }
        ?>
                        <?php
        if($orderd['shipping_country'] == 'NL')
        {
        ?>
        <li>
         <input type="radio" value="IDEAL" id="radio14" class="radio" name="payment_method" <?php if ($orderd['payment_method'] == 'IDEAL') echo 'checked'; ?> />
         <label for="radio14"><img src="/assets/images/card13.jpg" /></label>
        </li>
        <?php
        }
        ?>
        <?php if (in_array($order->get('payment_status'), array('new', 'failed')) && $amount>0):?>
                            <li class="last">
                                <p>
                                    <input type="button" value="Подтвердить и оплатить" class="btn btn-primary btn-sm" onclick="return payment_submit1();" />
                                </p>
                            </li>
         <?php endif; ?>
                        </ul>
                    </form>
                </div>
                <div class="tol-message-mobile">
                    <table class="user-table">
                        <tbody>
                            <tr>
                                <td width="30%"><strong>Номер заказа: </strong></td>
                                <td width="70%"><?php $orderd = $order->get();echo $orderd['ordernum']; ?></td>
                            </tr>
                            <tr>
                                <td width="30%"><strong>Дата заказа: </strong></td>
                                <td width="70%"><?php echo date('m/d/Y H:i:s', $orderd['created']); ?></td>
                            </tr>
                            <tr>
                                <td width="30%"><strong>Sous-Total:</strong></td>
                                <td width="70%">        
                                            <?php
                              if($orderd['payment_status'] == 'success' OR $orderd['payment_status'] == 'verify_pass')
                                  $amount_order = $orderd['amount'];
                              echo $currency['code'] . round($amount_order, 2); 
                              ?></td>
                            </tr>
                            <tr>
                                <td width="30%"><strong>Доставка:</strong></td>
                                <td width="70%"><?php echo $currency['code'] . round($orderd['amount_shipping'], 2); ?></td>
                            </tr>
                            <tr>
                                <td width="30%"><strong>АДРЕСЫ ДОСТАВКИ:</strong></td>
                                 <td width="70%"><?php echo $orderd['shipping_firstname'] . ' ' . $orderd['shipping_lastname']; ?><?php echo $orderd['shipping_address'] . ' ' . $orderd['shipping_city'] . ', ' . $orderd['shipping_state'] . ' ' . $orderd['shipping_country'] . ' ' . $orderd['shipping_zip']; ?><?php echo $orderd['shipping_phone']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="30%"><strong>Доставка:</strong></td>
                                <td width="70%"><?php echo $orderd['amount_shipping'] > 0 ? 'Экспресс-доставка' : 'Бесплатная Доставка'; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </article>
        </div>
    </div>
</section>

<!-- footer begin -->

<div id="gotop" class="hide">
    <a href="#" class="xs-mobile-top"></a>
</div>

<script>
  $(function(){
    $("#payment_select li").live('click', function(){
      var method = $(this).attr('title');
      $("#payment_method").val(method);
      })
  })

  function payment_submit()
  {
    var amount = <?php echo $amount; ?>;
    if(!amount)
    {
      window.alert('Ничего Не Существует В Корзине');
      return false;
    }
    else
    {
      $('#payment_form').submit();
    }
  }

  function payment_submit1()
  {
    var amount = <?php echo $amount; ?>;
    if(!amount)
    {
      window.alert('Ничего Не Существует В Корзине');
      return false;
    }
    else
    {
      $('#payment_form1').submit();
    }
  }

  function editMessage()
  {
      document.getElementById('set_message').style.display = 'block';
      document.getElementById('now_message').style.display = 'none';
      document.getElementById('message_edit').style.display = 'none';
  }
</script> 