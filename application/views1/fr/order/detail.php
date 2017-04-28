<section id="main">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs">
            <div>
                <a href="<?php echo LANGPATH; ?>/">Accueil</a>
                <a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > Historique de Commandes</a> > Détails De Commande
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
                    <h2>Détails De Commande</h2>
                </div>
                <!-- user-step -->
<?php if (in_array($order->get('payment_status'), array('new', 'failed')) OR $order->get('refund_status')=='refund' ) { ?>
                <div class="step-nav">
                <ul class="clearfix">
                    <li class="current">Placement De Commande <em></em><i></i></li>
                    <li>Traitement De Commande<em></em><i></i></li>
                    <li>Livraison<em></em><i></i></li>
                </ul>
                </div>
                <br />
<?php }elseif ( in_array($order->get('payment_status'), array('success', 'verify_pass')) and !in_array($order->get('shipping_status'), array('shipped', 'partial_shipped','delivered'))  ) { ?>
                <!-- user-step1-on -->
                <div class="step-nav">
                <ul class="clearfix">
                    <li>Placement De Commande <em></em><i></i></li>
                    <li class="current">Traitement De Commande<em></em><i></i></li>
                    <li>Livraison<em></em><i></i></li>
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
                    <li>Placement De Commande <em></em><i></i></li>
                    <li>Traitement De Commande<em></em><i></i></li>
                    <li  class="current">Livraison<em></em><i></i></li>
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
                    <li>Placement De Commande <em></em><i></i></li>
                    <li  class="current">Traitement De Commande<em></em><i></i></li>
                    <li>Livraison<em></em><i></i></li>
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
                    <span>N° de Commande: <b><?php $orderd = $order->get();echo $orderd['ordernum']; ?></b></span>Date de Commande: <?php echo date('m/d/Y H:i:s', $orderd['created']); ?>
                </div>

                <table class="user-table shopping-table" width="100%">
                    <tr>
      <th width="35%" class="first">Nom</th>                  
      <th width="10%" class="second">Prix</th>   
      <th width="5%">QTÉ</th>
      <th width="10%">Sous-Total</th>
      <th width="10%">Statut</th>
      <th width="15%">N° De Suivi</th>                            
      <th width="15%">Action</th>
                    </tr>
    <?php
        $currency = Site::instance()->currencies($orderd['currency']);
        $amount = 0;
        $d_amount = 0;
        $d_skus = array();
        $oproducts = $order->products();
        $tsum = count($oproducts);
        $product_amount = 0;
        $isout = 0;
        $giftarr = Site::giftsku();
        foreach ($oproducts as $key => $product):
            if($product['status'] == 'cancel')
                continue;
            $product_inf = DB::select('stock', 'visibility', 'status', 'price', 'sku', 'name', 'link')->from('products_' . LANGUAGE)->where('id', '=', $product['product_id'])->execute()->current();
            $outstock = 0;
            if(in_array($product['product_id'], $giftarr) && $tsum == 1)
            {
                $product_amount = 1;
            }
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
                    $product_stocks = Product::instance($product['product_id'])->get_stocks();
                    $has = 0;
                    $stocks = 0;
                    $search_attr = str_replace(array('SIZE:', ';'), array(''), strtoupper($product['attributes']));
                    $search_attr = trim(strtolower($search_attr));
                    foreach($product_stocks as $attr => $stock)
                    {
                        if(strpos($attr, $search_attr) !== false)
                        {
                            $stocks = $stock;
                            break;
                        }
                    }
                    if ($stocks > 0)
                    {
                        if ($product['quantity'] > $stocks)
                            $product['quantity'] = $stocks;
                        $amount += $product['price'] * $product['quantity'] * $orderd['rate'];
                        $has = 1;
                    }
                    if (!$has)
                        $outstock = 1;
                }
                else
                {
                    $amount += $product['price'] * $product['quantity'] * $orderd['rate'];
                }
            }

            if($outstock)
            {
                $isout = 1;
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
            <?php if ($outstock): ?><div class="red">(Indisponible)</div><?php endif; ?>
            <p class="bottom">
              <?php
              $attributes = str_replace(';', ';<br>', $product['attributes']);
              $attributes = str_replace('one size', 'taille unique', $attributes);
              $attributes = str_replace(array('Size', 'Color'), array('Taille', 'Farbe'), $attributes);
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
                        $status = "Impayé(Nouveau)";
                    }elseif($status == 'failed' OR $status == 'Failed'){
                        $status = "Échoué";
                    }elseif($status == 'cancel' OR $status == 'Cancel'){
                        $status = "Annulé";
                    }elseif($shipstatus == 'processing' OR $shipstatus == 'Processing'){
                        $status = "Traitement";
                    }elseif($shipstatus == 'partial shipped' OR $shipstatus == 'Partial Shipped'){
                        $status = "expédié partiellement";
                    }elseif($shipstatus == 'shipped' OR $shipstatus == 'Shipped'){
                        $status = "Expédié";
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
          echo "<br><a class=\"red\" href=\"/tracks/customer_track?id=".$orderd['ordernum']."\">suivre la commande</a>";
        endif;
        $domain = 'www.choies.com';
        ?></td>
                        <td>
                            Partager Avec
                            <p class="share">
        <a target="_blank" href="http://www.facebook.com/sharer.php?u=http%3A%2F%2F<?php echo $domain; ?>%2Fproduct%2F<?php echo Product::instance($product['product_id'])->get('link'); ?>" class="a1"></a>
        <a target="_blank" href="http://twitter.com/share?url=http%3A%2F%2F<?php echo $domain; ?>%2Fproduct%2F<?php echo Product::instance($product['product_id'])->get('link'); ?>" class="a2"></a>
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
                <a href="<?php echo LANGPATH; ?>/product/<?php echo $product_inf['link'] . '_p' . $product['product_id']; ?>#review_list" class="a-underline">commenter</a>
                <?php
                }
                else
                {
                ?>
                <a class="a-underline">commenter</a> 
                <?php
                }
            }
            else
            {
            ?>
                <a href="<?php echo LANGPATH; ?>/review/add/<?php echo $product['product_id']; ?>" class="a-underline review_link">commenter</a>
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
                        <label>Sous-Total: </label><span><?php echo $currency['code'] . round($order->get('amount_products') - $d_amount, 2); ?></span>
                    </li>
                    <li>
                        <label>Livraison:</label><span><?php echo $currency['code'] . round($orderd['amount_shipping'], 2); ?></span>
                    </li>
                    <?php if($orderd['order_insurance']){ ?>
                    <li>
                <?php        $oi_insurance = $orderd['order_insurance'] * $orderd['rate']; ?>
                        <label>Assurance transport: </label><span><?php echo $currency['code'] . round($oi_insurance, 2); ?></span>
                    </li>
                    <?php } ?>

                   <?php if($orderd['points'] || $orderd['amount_coupon']){ 
                        $mon = $orderd['amount_coupon'] + $orderd['points'] / 100;
                        $mon = $mon * $orderd['rate'];
                        ?>
                    <li>
                         <label>COUPONS & POINTS: </label><span><?php echo $currency['code'] . round($mon, 2); ?></span>
                    </li>
                    <?php } ?>
                    <li>
                        <label>TOTAL:</label><span>       
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
                        <dt>ADRESSE DE LIVRAISON</dt>
                        <dd><?php echo $orderd['shipping_firstname'] . ' ' . $orderd['shipping_lastname']; ?></dd>
                        <dd><?php echo $orderd['shipping_address'] . ' ' . $orderd['shipping_city'] . ', ' . $orderd['shipping_state'] . ' ' . $orderd['shipping_country'] . ' ' . $orderd['shipping_zip']; ?></dd>
                        <dd><?php echo $orderd['shipping_phone']; ?></dd>
                    </dl>
                    <dl>
                        <dt>DÉTAILS DE LIVRAISON</dt>
                        <dd><?php echo ($orderd['amount_shipping'] > 0 && $orderd['amount_shipping'] !=4.99) ? 'Livraison Express' : 'Livraison standard'; ?></dd>
                    </dl>
                    <dl class="last">
                        <dt>MÉTHODE DE PAIEMENT</dt>
                <?php
                if ($success):
                ?>    <dd>       
Montant: <?php echo $currency['code'] . round($amount_order, 2); ?></dd>        
                        <dd>Vous paierez <?php echo $currency['code'] . round($amount_order, 2); ?> avec:</dd>
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
      <input type="hidden" name="product_amount" value="<?php echo $product_amount; ?>" />
      <input type="hidden" name="delete_product" value="<?php echo $delete_product; ?>" />
                                <dd>Vous paierez<?php echo $currency['code'] . round($amount_order, 2); ?> avec:</dd>
                                <ul id="payment_select">
                                    <li>
                                        <input type="radio" value="PP" id="radio1" class="radio" name="payment_method" <?php if ($orderd['payment_method'] == 'PP') echo 'checked'; ?> />
                                        <label for="radio1">
                                            <img src="/assets/images/card5.jpg" style="display:inline-block;" /><em class="icon-tips JS_shows_btn1"><span class="JS_shows1 icon-tipscon hide">Si vous ne possédez pas de compte PayPal, vous pouvez également payer via PayPal avec votre carte de crédit ou carte de débit bancaire.
    or bank debit card.<img src="/assets/images/card1.jpg" /></span></em>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" value="OC" id="radio2" class="radio" name="payment_method" <?php if ($orderd['payment_method'] == 'GC' || $orderd['payment_method'] == 'OC') echo 'checked'; ?> />
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
      <?php if ((in_array($order->get('payment_status'), array('new', 'failed')) && $amount>0) or ($product_amount)):
                                if(!$isout)
                                {
                                    ?>
                                    <li class="last">
                                        <p>
                                            <input type="button" value="Confirmer et payer" class="btn btn-primary btn-sm" onclick="return payment_submit();"  />
                                        </p>
                                    </li>
                                <?php
                                }
                                else
                                {
                                ?>
                                    <li class="last">
                                        <p>
                                            <b>Désolé, il y a "rupture de stock" articles dans cette commande, faire un nouveau s'il vous plaît.</b>
                                        </p>
                                    </li>
                                <?php 
                                }
                                ?>

                                </ul>
                        
                        <?php endif; ?>
                    <!-- </form> -->
                    <?php endif;?>                                    
                        </dd>
                    </dl>
                </div>
                </form>
                <div style="width:500px;text-align:left;">
                    <label>Message:</label>
                    <br>
                    <label style="color:#999;height:20px;font-weight:normal;">5-100 caractères</label>
<div id="now_message" style="font-weight:normal;color:#8f8f8f;<?php if(!$order_message) echo 'display:none;'; ?>"><?php echo $order_message; ?></div>
<a href="javascript:;" onclick="editMessage();" id="message_edit" style="text-decoration: underline;<?php if(!$order_message) echo 'display:none;'; ?>">Modifier</a>
                    <div id="set_message" style="<?php if($order_message) echo 'display:none;'; ?>">
                        <form class="form" method="post" action="<?php echo LANGPATH; ?>/order/set_message">
        <input type="hidden" name="order_id" value="<?php echo $order->get('id'); ?>" />
                            <div class="right-box">
                                <textarea class="textarea-long" style="width: 550px; height: 100px;background-color: #fff;" name="message"  maxlength="200" minlength='5'><?php echo $order_message; ?></textarea>
                                <input class="btn btn-default btn-sm mt10" type="submit" style="font-weight:normal;" value="SOUMETTRE">
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
                                  messages: {
                               message: {
              required: "Ce champ est obligatoire.",
         minlength:"Vous devez inscrire au moins 5 caractères."
    },
}
                            });
                        </script>
                    </div>
                </div>
                <div class="cartbag-bottom">
<a class="s1" target="_blank" href="<?php echo LANGPATH; ?>/privacy-security">Paiement Sécurisé</a>
<a class="s2" target="_blank" href="<?php echo LANGPATH; ?>//shipping-delivery">Livraison Gratuite</a>
<a class="s3" target="_blank" href="<?php echo LANGPATH; ?>//returns-exchange">Garantie De Remboursement De 60 Jours </a>
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
                    $product_stocks = Product::instance($product['product_id'])->get_stocks();
                    $has = 0;
                    $stocks = 0;
                    $search_attr = str_replace(array('SIZE:', ';'), array(''), strtoupper($product['attributes']));
                    $search_attr = trim($search_attr);
                    foreach($product_stocks as $attr => $stock)
                    {
                        if(strpos($attr, $search_attr) !== false)
                        {
                            $stocks = $stock;
                            break;
                        }
                    }
                    if ($stocks > 0)
                    {
                        if ($product['quantity'] > $stocks)
                            $product['quantity'] = $stocks;
                        $amount += $product['price'] * $product['quantity'] * $orderd['rate'];
                        $has = 1;
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
              $attributes = str_replace(';', ' ', $product['attributes']);
              $attributes = str_replace('delivery time: 0', 'delivery time: regular order', $attributes);
              $attributes = str_replace('delivery time: 15', 'delivery time: rush order', $attributes);
              $attributes = str_replace(array('Size', 'Color'), array('Taille', 'Farbe'), $attributes);
              echo $attributes;
              ?>;</p>
                                <p>QTÉ: <?php echo $product['quantity']; ?></p>
                                <p>Prix: <?php echo $currency['code'] . round($product['price'] * $orderd['rate'], 2); ?></p>
                            </td>
                        </tr>
    <?php
    endforeach; ?>
                        <tr class="tol-mobile">
                            <td width="30%"></td>
                            <td class="align-right" width="70%">
                                <p>Sous-Total: <?php echo $currency['code'] . round($order->get('amount_products') - $d_amount, 2); ?></p>
                                <p>Livraison: <?php echo $currency['code'] . round($orderd['amount_shipping'], 2); ?></p>
                                <?php if($orderd['order_insurance']){ 
                                $oi_insurance = $orderd['order_insurance'] * $orderd['rate'];  ?>
                                <p>assurance transport: <?php echo $currency['code'] . round($oi_insurance, 2); ?>
                                 </p>
                               <?php } ?>
                    <?php if($orderd['points'] || $orderd['amount_coupon']){ 
                        $mon = $orderd['amount_coupon'] + $orderd['points'] / 100;
                        $mon = $mon * $orderd['rate'];
                        ?>
                    <p>
                    COUPONS & POINTS: <?php echo $currency['code'] . round($mon, 2); ?>
                    </p>
                    <?php } ?>
                                <p><strong>TOTAL:      
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
                                <input type="hidden" name="product_amount" value="<?php echo $product_amount; ?>" />
                                <input type="hidden" name="delete_product" value="<?php echo $delete_product; ?>" />
                                <input type="radio" value="PP" id="radio11" class="radio" name="payment_method" checked="checked" <?php if ($orderd['payment_method'] == 'PP') echo 'checked'; ?>  />
                                <label for="radio11">
                                    <img src="/assets/images/card5.jpg" style="display:inline-block;" /><em class="icon-tips1 JS_shows_btn1"><span class="JS_shows1 icon-tipscon1 hide" >If you don't have a PayPal account, you can also pay via PayPal avec your credit card 

    or bank debit card.<img src="/assets/images/card1.jpg" /></span></em>
                                </label>
                            </li>
                            <li>
                                <input type="radio" value="OC" id="radio12" class="radio" name="payment_method" <?php if ($orderd['payment_method'] == 'GC' || $orderd['payment_method'] == 'OC') echo 'checked'; ?>  />
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
        <?php if ((in_array($order->get('payment_status'), array('new', 'failed')) && $amount>0) or ($product_amount)):
                                if(!$isout)
                                {
                                    ?>
                                    <li class="last">
                                        <p>
                                            <input type="button" value="Confirmer et payer" class="btn btn-primary btn-sm" onclick="return payment_submit1();" />
                                        </p>
                                    </li>
                                <?php
                                }
                                else
                                {
                                ?>
                                    <li class="last">
                                        <p>
                                            <b>Désolé, il y a "rupture de stock" articles dans cette commande, faire un nouveau s'il vous plaît.</b>
                                        </p>
                                    </li>
                                <?php 
                                }
                                ?>

         <?php endif; ?>
                        </ul>
                    </form>
                </div>
                <div class="tol-message-mobile">
                    <table class="user-table">
                        <tbody>
                            <tr>
                                <td width="30%"><strong>N° de Commande: </strong></td>
                                <td width="70%"><?php $orderd = $order->get();echo $orderd['ordernum']; ?></td>
                            </tr>
                            <tr>
                                <td width="30%"><strong>Date de Commande: </strong></td>
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
                                <td width="30%"><strong>Livraison:</strong></td>
                                <td width="70%"><?php echo $currency['code'] . round($orderd['amount_shipping'], 2); ?></td>
                            </tr>
                            <tr>
                                <td width="30%"><strong>ADRESSE DE LIVRAISON:</strong></td>
                                 <td width="70%"><?php echo $orderd['shipping_firstname'] . ' ' . $orderd['shipping_lastname']; ?><?php echo $orderd['shipping_address'] . ' ' . $orderd['shipping_city'] . ', ' . $orderd['shipping_state'] . ' ' . $orderd['shipping_country'] . ' ' . $orderd['shipping_zip']; ?><?php echo $orderd['shipping_phone']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="30%"><strong>Livraison:</strong></td>
                                <td width="70%"><?php echo ($orderd['amount_shipping'] > 0 && $orderd['amount_shipping'] !=4.99) ? 'Livraison Express' : 'Livraison standard'; ?></td>
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
    var product_amount = <?php echo $product_amount; ?>;
    if(!amount && !product_amount)
    {
      window.alert('No product in shopping cart');
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
    var product_amount = <?php echo $product_amount; ?>;
    if(!amount && !product_amount)
    {
      window.alert('No product in shopping cart');
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