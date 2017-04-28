<section id="main">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs">
            <div>
                <a href="<?php echo LANGPATH; ?>/">Accueil</a>
                <a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> >  Mon Compte</a> Historique de Commandes
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
                    <h2>Historique de Commandes</h2>
                </div>
    <?php
    $user_id = Customer::logged_in();
    $firstname = Customer::instance($user_id)->get('firstname');
    if (empty($orders)):
    ?>
    <p class="mb25"><?php echo $firstname ? ucfirst($firstname) : 'Choieser'; ?>, vous n'avez pas encore de commandes. C'est le temps de faire des achats sur Choies avec votre coupon-rabais de 15% maintenant.</p>
        <p class="mb25">Pour voir les détails de la commande, veuillez cliquer sur le numéro de commande ou bouton "Détails de la commande".</p>
    <?php 
    else: 
    ?>
                <table class="user-table">
                    <tr class="tol-table">
                <th width="30%">Détails De Produit</th>
                <th width="10%">Prix</th>
                <th width="5%">QTÉ</th>
                <th width="5%"></th>
                <th width="5%">Livraison</th>
                <th width="12%">Total</th>
                <th width="18%">Statut De Commande</th>
                <th width="20%">Action</th>                
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
                        <th colspan="8">N° De Commande: <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><b><?php echo $order['ordernum']; ?></b></a>    <span>Date De Commande: <?php echo date('n/j/Y H:i:s', $order['created']); ?></span></th>
                    </tr>
                    <tr>
                        <td colspan="4" width="45%" class="sub-table-box">
                            <table width="100%">
               <?php

                foreach ($products as $p):
                    if($p['status'] != 'cancel')
                    {                   
                    $product = DB::select('stock', 'visibility', 'status', 'sku', 'name', 'link','market_price')->from('products_' . LANGUAGE)->where('id', '=', $p['product_id'])->execute()->current();
                    $pa = Product::instance($p['product_id'],LANGUAGE);
                    $p_price = $pa->get('price');

                    $outstock = 0;
                    if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                    {
                        $amount += $p['price'] * $p['quantity'] * $order['rate'];
                    }
                    
                        if (!$product['visibility'] OR !$product['status'] OR $product['stock'] == 0)
                        {
                            $outstock = 1;
                        }
                        elseif ($product['stock'] == -1)
                        {
                            $product_stocks = $pa->get_stocks();
                            $has = 0;
                            $stocks = 0;
                            $search_attr = str_replace(array('SIZE:', ';'), array(''), strtoupper($p['attributes']));
                            $search_attr = trim($search_attr);
                            if($search_attr == 'ONE SIZE')
                            {
                               $search_attr = strtolower($search_attr); 
                            }
                            if(!empty($search_attr))
                            {
                                foreach($product_stocks as $attr => $stock)
                                {
                                    if(strpos($attr, $search_attr) !== false)
                                    {
                                        $stocks = $stock;
                                        break;
                                    }
                                }                                
                            }
                            if ($stocks > 0)
                            {
                                if ($p['quantity'] > $stocks)
                                    $p['quantity'] = $stocks;
                                $amount += $p['price'] * $p['quantity'] * $order['rate'];
                                $has = 1;
                            }
                            if (!$has)
                                $outstock = 1;
                        }
                        else
                        {
                            $amount += $p['price'] * $p['quantity'] * $order['rate'];
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
                                <?php if ($outstock): ?><p class="red">(En rupture de stock)</p><?php endif; ?>
                                <p>
                                    <?php
                                    $attributes = str_replace(';', ';<br>', $p['attributes']);
                                    $attributes = str_replace('delivery time: 0', 'delivery time: regular order', $attributes);
                                    $attributes = str_replace('delivery time: 15', 'delivery time: rush order', $attributes);
                                      $attributes = str_replace('one size', 'taille unique', $attributes);
                                                    $attributes = str_replace(array('Size', 'Color'), array('Taille', 'Couleur'), $attributes);
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
                        }
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
                            $status = str_replace('_', ' ', $order['refund_status']);
                            if($status == 'prepare refund'){
                               $status = 'Préparer le remboursement';
                            }elseif($status == 'partial refund'){
                               $status = 'Remboursement partiel';
                            }else{
                               $status = 'Remboursement';
                            }
                        }
                else
                {
                    $status = kohana::config('order_status.payment.' . $order['payment_status'] . '.name');

                    $shipstatus = kohana::config('order_status.shipment.' . $order['shipping_status'] . '.name');
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
                ?></b>
                        </td>
                        <td width="15%">
            <?php 
            if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
            {
                $domain = 'www.choies.com';
            ?>
            <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="a-underline mb10">Détails De Commande</a>     
            <?php }elseif($order['payment_status'] == 'cancel'){ ?>
             <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="a-underline mb10">Détails De Commande</a>
            <?php }elseif (!$order['refund_status'] AND $amount > 0 AND $order['payment_status'] == 'new'){ ?>
            <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="btn btn-primary btn-sm mb10">Payer</a>
            <?php }else{ ?>
            <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="a-underline mb10">Détails De Commande</a>
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
                            <a href="<?php echo $plink; ?>#review-list" class="a-underline">commenté</a>
                            <?php
                            }
                            else
                            {
                            ?>
                            <a class="a-underline">commenté</a>
                            <?php
                            }
                        }
                        else
                        {
                        ?>
                            <a href="<?php echo LANGPATH; ?>/review/add/<?php echo $p['product_id']; ?>" class="a-underline review-link">commenter</a>
                        <?php
                        }
                    }
                    ?>
            <span class="JS_shows_btn1 trackjs a-underline" id="<?php echo $order['ordernum']; ?>"><a href="<?php echo LANGPATH; ?>/tracks/customer_track?id=<?php echo $order['ordernum']; ?>">Suivi de Commande</a>

                            <div class="JS_shows1 track-order-hidecon hide">
                                <p>Les détails de suivi au dessous sont mis au jour récemment,<a href="<?php echo  LANGPATH; ?>/tracks/customer_track?id=<?php echo $order['ordernum']; ?>" class="red">cliquer ici</a> pour vérifier tous les détails. </p>
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

    <div class="tol-page" style="float:right;">
    <?php  echo $pagination;?>
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
                        <p>N° De Commande: &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><?php echo $order['ordernum']; ?></a></p>
                        <p>Date De Commande: &nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('n/j/Y H:i:s', $order['created']); ?></p>
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
                            $product_stocks = Product::instance($p['product_id'])->get_stocks();
                            $has = 0;
                            $stocks = 0;
                            $search_attr = str_replace(array('SIZE:', ';'), array(''), strtoupper($p['attributes']));
                            $search_attr = trim($search_attr);
                            if(!empty($search_attr))
                            {
                                foreach($product_stocks as $attr => $stock)
                                {
                                    if(strpos($attr, $search_attr) !== false)
                                    {
                                        $stocks = $stock;
                                        break;
                                    }
                                }                                
                            }
                            if ($stocks > 0)
                            {
                                if ($p['quantity'] > $stocks)
                                    $p['quantity'] = $stocks;
                                $amount += $p['price'] * $p['quantity'] * $order['rate'];
                                $has = 1;
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
    
                        <p>Total:&nbsp;&nbsp;&nbsp;&nbsp;        
                        <?php
        if($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
            $amount_order = $order['amount'];
        echo $currency['code'] . round($amount_order, 2); 
        ?></p>
                        <p>Livraison:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $currency['code'] . round($order['amount_shipping'], 2); ?></p>
                        <p>Statut De Commande:&nbsp;&nbsp;&nbsp;&nbsp;                                    <?php
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
                        <a class="btn btn-primary btn-sm mb10" href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>">PAYER</a>
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
