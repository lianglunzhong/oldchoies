<!-- main begin -->
<section id="main">
  <!-- crumbs -->
  <div class="layout">
    <div class="crumbs fix">
      <div class="fll"><a href="<?php echo LANGPATH; ?>/">Home</a>  >  Детали заказа</div>
    </div>
  </div>
  
  <!-- main begin -->
  <section class="layout fix">
    <article id="container" class="user flr">
      <?php echo Message::get(); ?>
      <div class="tit"><h2>Детали заказа</h2></div>
      <?php if (in_array($order->get('payment_status'), array('new', 'failed'))) { ?>
      <!-- user_step -->
      <div class="user_step">
        <em></em>
        <div class="user_step_bottom">
          <span>Размещение Заказа</span>
          <span>Обработка Заказа</span>
          <span>Заказ Отправлен</span>
        </div>
      </div>
      <?php }elseif ( in_array($order->get('shipping_status'), array('shipped', 'partial_shipped')) ) { ?>
      <!-- user_step3_on -->
      <div class="user_step">
        <em class="step3_on"></em>
        <div class="user_step_bottom">
          <span class="pass">Размещение Заказа</span>
          <span class="pass">Обработка Заказа</span>
          <span class="on">Заказ Отправлен</span>
        </div>
      </div>
      <?php }elseif ( in_array($order->get('shipping_status'), array('delivered')) ) { ?>
      <!-- user_step3_pass -->
      <div class="user_step">
        <em class="step3_pass"></em>
        <div class="user_step_bottom">
          <span class="pass">Размещение Заказа</span>
          <span class="pass">Обработка Заказа</span>
          <span class="pass">Заказ Отправлен</span>
        </div>
      </div>
      <?php }else{ ?>
      <!-- user_step2_pass -->
      <div class="user_step">
        <em class="step2_pass"></em>
        <div class="user_step_bottom">
          <span class="pass">Размещение Заказа</span>
          <span class="pass">Обработка Заказа</span>
          <span>Заказ Отправлен</span>
        </div>
      </div>
      <?php } ?>
      <form action="" method="post" id="payment_form">
      <div class="order_top">
        <span>Номер заказа: <b><?php $orderd = $order->get();echo $orderd['ordernum']; ?></b></span>   
        Дата заказа: <?php echo date('m/d/Y H:i:s', $orderd['created']); ?>
      </div>
        <table class="shopping_table" width="100%">
            <tr>
              <th width="35%" class="first">Название</th>                  
              <th width="10%" class="second">Цена</th>   
              <th width="5%">Количество</th>
              <th width="10%">Итого</th>
              <th width="10%">Статус</th>
              <th width="15%">Отслеживать</th>                            
              <th width="15%">Действие</th>
            </tr>
            <?php
                $currency = Site::instance()->currencies($orderd['currency']);
                $status = $orderd['payment_status'];
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
                <div class="fix">
                  <div class="left"><a href="<?php echo LANGPATH; ?>/product/<?php echo $product_inf['link']; ?>"><img src="<?php echo image::link(Product::instance($product['product_id'])->cover_image(), 3); ?>" /></a></div>
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
              <td class="second">
                <del>
                <?php
                $p_price = $product_inf['price'];
                echo Site::instance()->price($p_price, 'code_view', NULL, $currency);
                ?>
                </del>
                <p><b class="red"><?php echo $currency['code'] . round($product['price'] * $orderd['rate'], 2); ?></b></p>
              </td>
              <td><?php echo $product['quantity']; ?></td>
              <td><?php echo $currency['code'] . round($product['price'] * $orderd['rate'], 2) * $product['quantity']; ?></td>
              <td><?php 
			  if($orderd['refund_status'])
                {
                $status = 'Возврат';
                }else{
					$status = kohana::config('order_status.payment.' . $orderd['payment_status'] . '.name');
					$shipstatus = kohana::config('order_status.shipment.' . $orderd['shipping_status'] . '.name');
                    if ($status == 'New' OR $status == 'new'){
                                $status = "Неоплачен";
							}elseif($status == 'failed' OR $status == 'Failed'){
								$status = "Безуспешно";
							}elseif($status == 'cancel' OR $status == 'Cancel'){
								$status = "отменённый";
							}elseif($shipstatus == 'processing' OR $shipstatus == 'Processing'){
								$status = "Обработка";
							}elseif($shipstatus == 'partial shipped' OR $shipstatus == 'Partial Shipped'){
								$status = "Частично Отправлен";
							}elseif($shipstatus == 'shipped' OR $shipstatus == 'Shipped'){
								$status = "Отправлен";
							}elseif($shipstatus == 'delivered' OR $shipstatus == 'Delivered'){
								$status = "Доставили";
							}
                        }
                        echo ucfirst($status);?></td>
              <td>
                <?php
                $shipments = $order->shipments();
                if (isset($shipments[$key])):
                  echo $shipments[$key]['tracking_code'];
                  echo "<br><a class=\"red\" href=\"/track/customer_track?id=".$orderd['ordernum']."\">Отслеживать заказ</a>";
                endif;
                $domain = 'www.choies.com';
                ?>
              </td>
              <td>Поделиться С<p class="share mtb5">
                <a target="_blank" href="http://www.facebook.com/sharer.php?u=http%3A%2F%2F<?php echo $domain; ?>%2Fproduct%2F<?php echo Product::instance($product['product_id'])->get('link'); ?>" class="a1"></a>
                <a target="_blank" href="http://twitter.com/share?url=http%3A%2F%2F<?php echo $domain; ?>%2Fproduct%2F<?php echo Product::instance($product['product_id'])->get('link'); ?>" class="a2"></a>
                <a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(Product::instance($product['product_id'])->permalink()); ?>&media=<?php echo Image::link(Product::instance($product['product_id'])->cover_image(), 1); ?>&description=<?php Product::instance($product['product_id'])->get('name'); ?>" class="a3"></a></p>
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
                        <a href="<?php echo LANGPATH; ?>/product/<?php echo $product_inf['link'] . '_p' . $product['product_id']; ?>#review_list" class="a_underline">Обзор</a>
                        <?php
                        }
                        else
                        {
                        ?>
                        Обзор
                        <?php
                        }
                    }
                    else
                    {
                    ?>
                        <a href="<?php echo LANGPATH; ?>/review/add/<?php echo $product['product_id']; ?>" class="a_underline review_link">Написать отзыв</a>
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
            ?>
                       
        </table>
        <input type="hidden" name="amount" value="<?php echo $amount; ?>" />
              <input type="hidden" name="delete_product" value="<?php echo $delete_product; ?>" />
        
        <ul class="total">
            <li><label>Итого: </label><span><?php echo $currency['code'] . round($order->get('amount_products') - $d_amount, 2); ?></span></li>     
            <li><label>Доставка: </label><span><?php echo $currency['code'] . round($orderd['amount_shipping'], 2); ?></span></li>      
            <li style="font-size:17px;"><label>Итого заказов: </label>
                <span>
                <?php
                if($orderd['payment_status'] == 'success' OR $orderd['payment_status'] == 'verify_pass')
                    $amount_order = $orderd['amount'];
                echo $currency['code'] . round($amount_order, 2); 
                ?>
                </span>
            </li>
        </ul>
<div class="shipping_methods">
        <?php
        $success = 0;
        if (in_array($orderd['payment_status'], array('success', 'verify_pass', 'pending')))
            $success = 1;
        ?>
        <div class="order_dl fix">
        <dl class="first">
          <dt>АДРЕСЫ ДОСТАВКИ</dt>
          <dd><?php echo $orderd['shipping_firstname'] . ' ' . $orderd['shipping_lastname']; ?></dd> 
          <dd><?php echo $orderd['shipping_address'] . ' ' . $orderd['shipping_city'] . ', ' . $orderd['shipping_state'] . ' ' . $orderd['shipping_country'] . ' ' . $orderd['shipping_zip']; ?></dd>  
          <dd><?php echo $orderd['shipping_phone']; ?></dd> 
        </dl>
        <dl>
          <dt>Деталь доставки</dt>
          <dd><?php echo $orderd['amount_shipping'] > 0 ? 'экспресс-доставка' : 'бесплатная доставка по всему миру'; ?></dd> 
        </dl>
        <dl class="last">
          <dt>Метод платежа</dt>
          <dd>
            <?php
            if ($success):
                ?>
                <p>Вы заплатили <?php echo $currency['code'] . round($amount_order, 2); ?> по:</p>
                <?php
                if ($orderd['payment_method'] == 'PP' OR $orderd['payment_method'] == 'PPEC')
                {
                ?>
                    <img src="/images/card5.jpg" style="display:inline-block;" />
                <?php
                }
                else
                {
                ?>
                    <img src="/images/card2.jpg" />
                <?php
                }
            else:
            ?>
            <!--form action="" method="post" class="shipping_methods" id="payment_form"-->
              <!-- <input type="hidden" name="amount" value="<?php //echo $amount; ?>" />
              <input type="hidden" name="delete_product" value="<?php //echo $delete_product; ?>" /> -->
              <p>Вы будете платить <?php echo $currency['code'] . round($amount_order, 2); ?> по:</p>
              <ul class="fix" id="payment_select">
                <li style="margin-right:28px;">
                  <input type="radio" value="PP" id="radio1" class="radio" name="payment_method" <?php if ($orderd['payment_method'] == 'PP') echo 'checked'; ?> />
                  <label for="radio1"><img src="/images/card5.jpg" style="display:inline-block;" /><em class="icon_tips JS_shows_btn1">
                    <span class="JS_shows1 icon_tipscon hide">Если у вас нет счет PayPal, вы также можете оплатить через PayPal с помощью кредитной карты или банковской платежной карты.<img src="/images/card1.jpg" /></span></em></label>
                </li>
                <li>
                 <input type="radio" value="GC" id="radio2" class="radio" name="payment_method" <?php if ($orderd['payment_method'] == 'GC') echo 'checked'; ?> />
                 <label for="radio2"><img src="/images/card2.jpg" /></label>
                </li>
                <?php
                $sofort_countries = array(
                    'DE' => 'EUR', 'AT' => 'EUR', 'CH' => 'EUR', 'BE' => 'EUR', 'FR' => 'EUR',
                    'IT' => 'EUR', 'GB' => 'GBP', 'ES' => 'EUR', 'NL' => 'EUR', 'PL' => 'PLN',
                );
                if(array_key_exists($orderd['shipping_country'], $sofort_countries))
                {
                ?>
                <li style="margin-right:28px;">
                 <input type="radio" value="SOFORT" id="radio3" class="radio" name="payment_method" <?php if ($orderd['payment_method'] == 'SOFORT') echo 'checked'; ?> />
                 <label for="radio3"><img src="/images/card12.jpg" /></label>
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
                 <label for="radio4"><img src="/images/card13.jpg" /></label>
                </li>
                <?php
                }
                ?>
              </ul>
              <?php if (in_array($order->get('payment_status'), array('new', 'failed')) && $amount>0):?>
              <p class="fix"><input type="button" value="ПЛАТИТЬ СЕЙЧАС" class="btn30_14_red flr" onclick="return payment_submit();" /></p>
              <?php endif; ?>
            <!-- </form> -->
            <?php endif;?>
          </dd>
        </dl>               
      </div>
    </div>
      </form>
        <div class="cartbag_bottom">
          <a class="s1" target="_blank" href="<?php echo LANGPATH; ?>/privacy-security">Гарантированная Безопасность заказа</a>
          <a class="s2" target="_blank" href="<?php echo LANGPATH; ?>/shipping-delivery">Бесплатная доставка по всему миру</a>
          <a class="s3" target="_blank" href="<?php echo LANGPATH; ?>/returns-exchange">60-Дневная Гарантия Возврата Денег</a>
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
        </script>   
    </article>
    <?php echo View::factory(LANGPATH . '/customer/left'); ?>
  </section>
</section>