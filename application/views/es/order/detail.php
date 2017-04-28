<!-- main begin -->
<section id="main">
  <!-- crumbs -->
  <div class="layout">
    <div class="crumbs fix">
      <div class="fll"><a href="<?php echo LANGPATH; ?>/">PÁGINA DE INICIO</a>  >  Detalles de Pedido</div>
    </div>
  </div>
  
  <!-- main begin -->
  <section class="layout fix">
    <article id="container" class="user flr">
      <?php echo Message::get(); ?>
      <div class="tit"><h2>Detalles de Pedido</h2></div>
      <?php if (in_array($order->get('payment_status'), array('new', 'failed')) OR $order->get('refund_status')=='refund' ) { ?>
      <!-- user_step -->
      <div class="user_step">
        <em></em>
        <div class="user_step_bottom">
          <span>Realizar el Pedido</span>
          <span>Procesamiento de Pedido</span>
          <span>Envío de Pedido</span>
        </div>
      </div>
      <?php }elseif ( in_array($order->get('shipping_status'), array('shipped', 'partial_shipped')) ) { ?>
      <!-- user_step3_on -->
      <div class="user_step">
        <em class="step3_on"></em>
        <div class="user_step_bottom">
          <span class="pass">Realizar el Pedido</span>
          <span class="pass">Procesamiento de Pedido</span>
          <span class="on">Envío de Pedido</span>
        </div>
      </div>
      <?php }elseif ( in_array($order->get('shipping_status'), array('delivered')) ) { ?>
      <!-- user_step3_pass -->
      <div class="user_step">
        <em class="step3_pass"></em>
        <div class="user_step_bottom">
          <span class="pass">Realizar el Pedido</span>
          <span class="pass">Procesamiento de Pedido</span>
          <span class="pass">Envío de Pedido</span>
        </div>
      </div>
      <?php }else{ ?>
      <!-- user_step2_pass -->
      <div class="user_step">
        <em class="step2_pass"></em>
        <div class="user_step_bottom">
          <span class="pass">Realizar el Pedido</span>
          <span class="pass">Procesamiento de Pedido</span>
          <span>Envío de Pedido</span>
        </div>
      </div>
      <?php } ?>

      <!-- user_step1_on -->
      <!--div class="user_step">
        <em class="step1_on"></em>
        <div class="user_step_bottom">
          <span class="on">Order Placement</span>
          <span>Order Processing</span>
          <span>Order Shipped</span>
        </div>
      </div-->
      
      <!-- user_step1_pass -->
      <!--div class="user_step">
        <em class="step1_pass"></em>
        <div class="user_step_bottom">
          <span class="pass">Order Placement</span>
          <span>Order Processing</span>
          <span>Order Shipped</span>
        </div>
      </div-->
      
      <!-- user_step2_on -->
      <!--div class="user_step">
        <em class="step2_on"></em>
        <div class="user_step_bottom">
          <span class="pass">Order Placement</span>
          <span class="on">Order Processing</span>
          <span>Order Shipped</span>
        </div>
      </div-->
      <form action="" method="post" id="payment_form">
      <div class="order_top">
        <span>No. de Pedido: <b><?php $orderd = $order->get();echo $orderd['ordernum']; ?></b></span>   Fecha De Pedido: 
        <?php echo date('m/d/Y H:i:s', $orderd['created']); ?>
      </div>
        <table class="shopping_table" width="100%">
            <tr>
              <th width="33%" class="first">Nombre</th>                  
              <th width="8%" class="second">Precio</th>   
              <th width="8%">Cantidad</th>
              <th width="8%">Subtotal</th>
              <th width="15%">Estado de Pedido</th>
              <th width="15%">No. de seguimiento</th>                            
              <th width="13%" style="text-indent:1em">Acción</th>
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
                <div class="fix">
                  <div class="left"><a href="<?php echo LANGPATH; ?>/product/<?php echo $product_inf['link']; ?>"><img src="<?php echo image::link(Product::instance($product['product_id'])->cover_image(), 3); ?>" /></a></div>
                  <div class="right">
                    <a href="<?php echo LANGPATH; ?>/product/<?php echo $product_inf['link']; ?>" class="name"><?php echo $product_inf['name']; ?></a>
                    <?php if ($outstock): ?><div class="red">(Fuera De Stock)</div><?php endif; ?>
                    <p class="bottom">
                      <?php
                      $attributes = str_replace(';', ';<br>', $product['attributes']);
                      $attributes = strtolower($attributes);
                      $attributes = str_replace(' ', '', $attributes);
                      $attributes = str_ireplace('onesize', 'talla única', $attributes);
                      $attributes = str_replace('size', 'Talla', $attributes);
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
              <td>
                  <?php
			  if($orderd['refund_status'])
                {
                $status = 'Reembolso';
                }else{
					$status = kohana::config('order_status.payment.' . $orderd['payment_status'] . '.name');
					$shipstatus = kohana::config('order_status.shipment.' . $orderd['shipping_status'] . '.name');
                    if ($status == 'New' OR $status == 'new'){
                                $status = "No pagado(Nuevo)";
							}elseif($status == 'failed' OR $status == 'Failed'){
								$status = "Fracasado";
							}elseif($status == 'cancel' OR $status == 'Cancel'){
								$status = "Cancelado";
							}elseif($shipstatus == 'processing' OR $shipstatus == 'Processing'){
								$status = "Procedimiento";
							}elseif($shipstatus == 'partial shipped' OR $shipstatus == 'Partial Shipped'){
								$status = "Enviado Parcialmente";
							}elseif($shipstatus == 'shipped' OR $shipstatus == 'Shipped'){
								$status = "Enviado";
							}elseif($shipstatus == 'delivered' OR $shipstatus == 'Delivered'){
								$status = "Entregado";
							}
                        }
                        echo ucfirst($status);
                  ?>
              </td>
              <td>
                <?php
                $shipments = $order->shipments();
                if (isset($shipments[$key])):
                  echo $shipments[$key]['tracking_code'];
                  echo "<br><a class=\"red\" href=\"/track/customer_track?id=".$orderd['ordernum']."\">rastrear</a>";
                endif;
                $domain = 'www.choies.com';
                ?>
              </td>
              <td>Compartir<p class="share mtb5">
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
                        <a href="<?php echo LANGPATH; ?>/product/<?php echo $product_inf['link'] . '_p' . $product['product_id']; ?>#review_list" class="a_underline">Comentado</a>
                        <?php
                        }
                        else
                        {
                        ?>
                        Comentado
                        <?php
                        }
                    }
                    else
                    {
                    ?>
                        <a href="<?php echo LANGPATH; ?>/review/add/<?php echo $product['product_id']; ?>" class="a_underline review_link">Comentar</a>
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
            <li><label>Subtotal: </label><span><?php echo $currency['code'] . round($order->get('amount_products') - $d_amount, 2); ?></span></li>     
            <li><label>Envío: </label><span><?php echo $currency['code'] . round($orderd['amount_shipping'], 2); ?></span></li>      
            <li class="font18"><label>Total: </label>
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
          <dt>DIRECCIÓN DE ENVÍO</dt>
          <dd><?php echo $orderd['shipping_firstname'] . ' ' . $orderd['shipping_lastname']; ?></dd> 
          <dd><?php echo $orderd['shipping_address'] . ' ' . $orderd['shipping_city'] . ', ' . $orderd['shipping_state'] . ' ' . $orderd['shipping_country'] . ' ' . $orderd['shipping_zip']; ?></dd>  
          <dd><?php echo $orderd['shipping_phone']; ?></dd> 
        </dl>
        <dl>
          <dt>DETALLES DE ENVÍO</dt>
          <dd><?php echo $orderd['amount_shipping'] > 0 ? 'Envío Expreso' : 'Free Shipping'; ?></dd> 
        </dl>
        <dl class="last">
          <dt>MÉTODO DE PAGO</dt>
          <dd>
            <?php
            if ($success):
                ?>
                <p>Ya haya pagado <?php echo $currency['code'] . round($amount_order, 2); ?> con:</p>
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
              <p>Deseo pagar <?php echo $currency['code'] . round($amount_order, 2); ?> con:</p>
              <ul class="fix" id="payment_select">
                <li style="margin-right:28px;">
                  <input type="radio" value="PP" id="radio1" class="radio" name="payment_method" <?php if ($orderd['payment_method'] == 'PP') echo 'checked'; ?> />
                  <label for="radio1"><img src="/images/card5.jpg" style="display:inline-block;" /><em class="icon_tips JS_shows_btn1">
                    <span class="JS_shows1 icon_tipscon hide">Usted puede solicitar los puntos que equivalen a sólo el 10% de valor de su pedido.Completa tu perfil, se le otorgará 500 puntos para canjear tu primer pedido.<img src="/images/card1.jpg" /></span></em></label>
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
              <p class="fix"><input type="button" value="PAGA HAORA" class="btn30_14_red flr" onclick="return payment_submit();" /></p>
              <?php endif; ?>
            <!-- </form> -->
            <?php endif;?>
          </dd>
        </dl>               
      </div>
    </div>
      </form>
        <div class="cartbag_bottom">
          <a class="s1" target="_blank" href="/privacy-security">Pago Seguro Garantizado</a>
          <a class="s2" target="_blank" href="/shipping-delivery">Envío Gratis Mundial</a>
          <a class="s3" target="_blank" href="/returns-exchange">60 Días De Rembolso Garantizado</a>
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
              window.alert('Su cesta de compra está vacía');
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