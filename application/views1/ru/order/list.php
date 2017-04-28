<section id="main">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs">
            <div>
                <a href="<?php echo LANGPATH; ?>/">Accueil</a>
                <a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> >  Личный кабинет</a> История заказов
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
                    <h2>История заказов</h2>
                </div>
    <?php
    $user_id = Customer::logged_in();
    $firstname = Customer::instance($user_id)->get('firstname');
    if (empty($orders)):
    ?>
    <p class="mb25"><?php echo $firstname ? ucfirst($firstname) : 'Choieser'; ?>, У вас нет заказов.Теперь вы можете делать покупки на Choies с 15% off купоном. </p>
    <p class="mb25">Нажмите на номер заказа или кнопку " Детали заказа", и можете смотреть  детали заказа.</p>
    <?php 
    else: 
    ?>
                <table class="user-table">
                    <tr class="tol-table">
                <th width="30%">Детали товаров</th>
                <th width="10%">Цена</th>
                <th width="5%">Количество</th>
                <th width="5%"></th>
                <th width="5%">Стоимость доставки</th>
                <th width="12%">Итого заказа</th>
                <th width="18%">Статус Заказа</th>
                <th width="20%">Действие</th>                
                    </tr>
                </table>   
                <?php
    foreach ($orders as $order):
        $currency = Site::instance()->currencies($order['currency']);
        $status = $order['payment_status'];

        $d_amount = 0;
        $amount = 0;
        $products = Order::instance($order['id'])->products();
        if (empty($products))
            continue;
    ?>
                <table class="user-table">

                    <tr class="sub-table">
                        <th colspan="8">Номер заказа: <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><b><?php echo $order['ordernum']; ?></b></a>    <span>Дата заказа: <?php echo date('n/j/Y H:i:s', $order['created']); ?></span></th>
                    </tr>
                    <tr>
                        <td colspan="4" width="45%" class="sub-table-box">
                            <table width="100%">
               <?php

                foreach ($products as $p):
                    if($p['status'] == 'cancel')
                        continue;
                    $product = DB::select('stock', 'visibility', 'status', 'sku', 'name', 'link','market_price')->from('products_' . LANGUAGE)->where('id', '=', $p['product_id'])->execute()->current();
                    $pa = Product::instance($p['product_id'],LANGUAGE);
                    $p_price = $pa->get('price');

                    $outstock = 0;
                    if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                    {
                        $amount += $p['price'] * $p['quantity'] * $order['rate'];
                    }
                    else
                    {
                        if (!$product['visibility'] OR !$product['status'] OR $product['stock'] == 0)
                        {
                            $outstock = 1;
                        }
                        elseif ($product['stock'] == -1)
                        {
                            $stocks = DB::select()
                                ->from('products_stocks')
                                ->where('product_id', '=', $p['product_id'])
                                ->where('stocks', '<>', 0)
                                ->execute();
                            $has = 0;
                            foreach ($stocks as $stock)
                            {
                                if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                {
                                    if ($p['quantity'] > $stock['stocks'])
                                        $p['quantity'] = $stock['stocks'];
                                    $amount += $p['price'] * $p['quantity'] * $order['rate'];
                                    $has = 1;
                                    break;
                                }
                            }
                            if (!$has)
                                $outstock = 1;
                        }
                        else
                        {
                            $amount += $p['price'] * $p['quantity'] * $order['rate'];
                        }
                    }
                    $plink = LANGPATH . '/product/' . $product['link'] . '_p' . $p['product_id'];
                ?>
                                <tr>
                                    <td width="60%">
                                        <div>
                                            <div class="left">
                                                <a target="_blank" href="<?php echo $plink; ?>">
                                                    <img src="<?php echo image::link(Product::instance($p['product_id'])->cover_image(), 3); ?>" />
                                                </a>
                                            </div>
                                            <div class="right">
                                                <a target="_blank" href="<?php echo $plink; ?>" class="name"><?php echo $product['name']; ?></a>
                                <?php if ($outstock): ?><p class="red">(Нет в наличии)</p><?php endif; ?>
                                <p>
                                    <?php
                                                    $attributes = str_replace(';', ';<br>', $p['attributes']);
                                                    $attributes = str_replace('one size', 'только один размер', $attributes);
                                                    $attributes = str_replace(array('Size', 'Color'), array('Размеры', 'Цвет'), $attributes);
                                                    echo $attributes;
                                    ?>
                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td width="22%">
                                    <?php 
                                    if ($p_price > $p['price']){ ?>
                                    <del><?php echo $currency['code'] . round($p_price * $order['rate'], 2); ?></del>
                                        <p class="red"><?php echo $currency['code'] . round($p['price'] * $order['rate'], 2); ?></p>
                                                                                    
                                <?php   }else{ ?>
                                        <p class="red"><?php echo $currency['code'] . round($p['price'] * $order['rate'], 2); ?></p>                                            
                                    <?php }  ?></td>

                                    <td width="10%"><?php echo $p['quantity']; ?></td>
                                    <td width="8%">

                                    </td>
                                </tr>
                <?php
                endforeach;
                $amount_order = $amount + $order['amount_shipping'];
                if ($amount_order > $order['amount'])
                    $amount_order = $order['amount'];
                if (in_array($order['payment_status'], array('new', 'failed')) AND $amount == 0)
                    $amount_order = $order['amount'];
                ?>
            </table>

                        </td>
                        <td width="8%"><?php echo $currency['code'] . round($order['amount_shipping'], 2); ?></td>
                        <td width="12%">          
                        <?php
                        if($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass'){
                        $amount_order = $order['amount'];
                        echo $currency['code'] . round($amount_order, 2); 
                        }else{
                        echo $currency['code'] . round($amount_order, 2);   
                        }
                        ?></td>
                        <td width="15%"><b>          
                        <?php
                    if($order['refund_status'])
                        {
                             $status = 'Платить';
                        }
                else
                {
                    $status = kohana::config('order_status.payment.' . $order['payment_status'] . '.name');

                    $shipstatus = kohana::config('order_status.shipment.' . $order['shipping_status'] . '.name');
                  if ($status == 'New' OR $status == 'new'){
                        $status = 'Неоплаченный(Новый)';
                    }elseif($status == 'failed' OR $status == 'Failed'){
                        $status = 'Безуспешно';
                    }elseif($status == 'cancel' OR $status == 'Cancel'){
                        $status =  'отменённый';
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
                ?></b>
                        </td>
                        <td width="15%">
            <?php 
            if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
            {
                $domain = URLSTR;
            ?>
            <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="a-underline mb10">Оплатить</a>     
            <?php }elseif($order['payment_status'] == 'cancel'){ ?>
             <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="a-underline mb10">Платить</a>
            <?php }elseif (!$order['refund_status'] AND $amount > 0 AND $order['payment_status'] == 'new'){ ?>
            <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="btn btn-primary btn-sm mb10">Оплатить</a>
            <?php }else{ ?>
            <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="a-underline mb10">Детали Заказа</a>
            <?php } ?>
            <?php if($order['shipping_status'] == 'shipped' OR $order['shipping_status'] == 'partial_shipped'){ ?>
                    <?php
                    if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                    {
                        if($p['erp_line_status'] == 1)
                        {
                            $is_approve = DB::select('is_approved')->from('reviews')->where('order_id', '=', $order['id'])->where('product_id', '=', $p['product_id'])->execute()->get('is_approved');
                            if($is_approve)
                            {
                            ?>
                            <a href="<?php echo $plink; ?>#review-list" class="a-underline">Обзор</a>
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
                            <a href="<?php echo LANGPATH; ?>/review/add/<?php echo $p['product_id']; ?>" class="a-underline review-link">Написать отзыв</a>
                        <?php
                        }
                    }
                    ?>
            <span class="JS_shows_btn1 trackjs a-underline" id="<?php echo $order['ordernum']; ?>"><a href="<?php echo  LANGPATH; ?>/tracks/customer_track?id=<?php echo $order['ordernum']; ?>">Отслеживать заказ</a>

                            <div class="JS_shows1 track-order-hidecon hide">
                                <p>Отслеживания подробной информации , следует последние обновленые, пожалуйста,<a href="<?php echo  LANGPATH; ?>/tracks/customer_track?id=<?php echo $order['ordernum']; ?>" class="red">нажмите здесь</a>, чтобы проверить все детали</p>
                                <p class="mt20" id="<?php echo $order['ordernum']; ?>error_block"></p>
                                <ul class="track-ul" id="history<?php echo $order['ordernum']; ?>"></ul>
        </div>
        </span>
      <?php } ?>
        </td>
        </tr>
    <?php
    endforeach;
    ?>
        </table>

    <div class="tol-page">
    <?php  echo $pagination;   ?>
    </div>
    </article>
    <article class="order-history-mobile col-xs-12 hidden-sm hidden-md hidden-lg">
                            <?php

    foreach ($orders as $order){
        
        $currency = Site::instance()->currencies($order['currency']);

        $status = $order['payment_status'];
        $d_amount = 0;
        $amount = 0;
        $products = Order::instance($order['id'])->products();
        if (empty($products))
            continue;
    ?>
        <table class="user-table">
            <tbody>
                <tr>
                    <td width="80%" align="left">
                        <p>Номер заказа:  &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><?php echo $order['ordernum']; ?></a></p>
                        <p>Дата заказа:  &nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('n/j/Y H:i:s', $order['created']); ?></p>
                <?php
                foreach ($products as $p):
                    if($p['status'] == 'cancel')
                        continue;
                    $product = DB::select('stock', 'visibility', 'status', 'sku', 'name', 'link')->from('products_' . LANGUAGE)->where('id', '=', $p['product_id'])->execute()->current();
                    $outstock = 0;
                    if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                    {
                        $amount += $p['price'] * $p['quantity'] * $order['rate'];
                    }
                    else
                    {
                        if (!$product['visibility'] OR !$product['status'] OR $product['stock'] == 0)
                        {
                            $outstock = 1;
                        }
                        elseif ($product['stock'] == -1)
                        {
                            $stocks = DB::select()
                                ->from('products_stocks')
                                ->where('product_id', '=', $p['product_id'])
                                ->where('stocks', '<>', 0)
                                ->execute();
                            $has = 0;
                            foreach ($stocks as $stock)
                            {
                                if (strpos($p['attributes'], $stock['attributes']) !== FALSE)
                                {
                                    if ($p['quantity'] > $stock['stocks'])
                                        $p['quantity'] = $stock['stocks'];
                                    $amount += $p['price'] * $p['quantity'] * $order['rate'];
                                    $has = 1;
                                    break;
                                }
                            }
                            if (!$has)
                                $outstock = 1;
                        }
                        else
                        {
                            $amount += $p['price'] * $p['quantity'] * $order['rate'];
                        }
                    }
                    $plink = LANGPATH . '/product/' . $product['link'] . '_p' . $p['product_id'];
                ?>
                <?php
                endforeach;
                $amount_order = $amount + $order['amount_shipping'];
                if ($amount_order > $order['amount'])
                    $amount_order = $order['amount'];
                if (in_array($order['payment_status'], array('new', 'failed')) AND $amount == 0)
                    $amount_order = $order['amount'];
                ?>                      
    
                        <p>Order Total:&nbsp;&nbsp;&nbsp;&nbsp;        
                        <?php
        if($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
            $amount_order = $order['amount'];
        echo $currency['code'] . round($amount_order, 2); 
        ?></p>
                        <p>Стоимость доставки:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $currency['code'] . round($order['amount_shipping'], 2); ?></p>
                        <p>Статус Заказа:&nbsp;&nbsp;&nbsp;&nbsp;                                    <?php
                            if ($order['refund_status'])
                            {
                                $status = str_replace('_', ' ', $order['refund_status']);
                            }
                            else
                            {
                                $status = kohana::config('order_status.payment.' . $order['payment_status'] . '.name');
                                if ($status == 'New' OR $status == 'new')
                                    $status = 'Unpaid(New)';
                            }
                            echo ucfirst($status);
                            ?></p>
                        <?php   $status = kohana::config('order_status.payment.' . $order['payment_status'] . '.name');
                        if ($amount > 0 AND $status == 'New' OR $status == 'new'){                              
                    ?>                          
                        <a class="btn btn-primary btn-sm mb10" href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>">Платить</a>
                        <?php } ?>
                    </td>
                    <td width="20%">
                        <a href="#" class="mobile-btn"></a>
                    </td>
                </tr>



            </tbody>
        </table> 
        <?php } ?>
                <div class="tol-page">
    <?php  echo $pagination;   ?>
    </div>
    </article>
    </div>
    </div>
            <?php
    endif;
?> 
</section>

<!-- footer begin -->

<div id="gotop" class="hide">
    <a href="#" class="xs-mobile-top"></a>
</div>

<script>
    $(".trackjs").hover(function() {
        var code = $(this).attr("id");
        var flg = $(this).children('div').attr('name');
        if (flg == 0) {
            $("#" + code + "error_block").html("Loading...").fadeIn(320);
            $("#" + code).children('div').attr('name', '1');
            $.ajax({
                type: "POST",
                url: "/track/ajax_pagedata",
                dataType: "json",
                data: "code=" + code,
                success: function(data) {
                    if (data.result == "noData") {
                        $("#" + code + "error_block").html(data.msg).fadeIn(320)
                    } else if (data.result == "success") {
                        $("#" + code + "error_block").html("").fadeOut(320)
                        $("#history" + code).html('');
                        var item = eval(data.data)
                        for (var i = 0; i < item.length; i++) {
                            if (typeof(item[i]['history']) != "undefined") {
                                $("#history" + code).append("<li class=\"first\"><span class=\"btn-black-sm\">Package" + (i + 1) + "</span></li>");
                                for (var l = 0; l < item[i]['history'].length; l++) {
                                    $("#history" + code).append("<li>" + item[i]['history'][l]['a'] + " " + item[i]['history'][l]['z'] + "</li>");
                                }
                            }
                        }
                    }
                },
                error: function() {
                    $("#error_block").html("Error.").fadeIn(320)
                }
            });
        }
        $(this).find(".JS_shows1").show();
    }, function() {
        $(this).find('.JS_shows1').hide();
    })
</script>
