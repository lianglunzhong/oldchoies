<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Accueil</a>  >  Historique de Commandes</div> 
        </div>
        <?php echo Message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Historique de Commandes</h2></div>
            <?php
            if (empty($orders)):
                $user_id = Customer::logged_in();
                $firstname = Customer::instance($user_id)->get('firstname');
                ?>
                <p class="mb25"><?php echo $firstname ? ucfirst($firstname) : 'Choieser'; ?>, vous n'avez pas encore de commandes. C'est le temps de faire des achats sur Choies avec votre coupon-rabais de 15% maintenant.</p>
                <p class="mb25">Pour voir les détails de la commande, veuillez cliquer sur le numéro de commande ou bouton "Détails de la commande".</p>
                <?php
            else:
                ?>
                <table class="user_table user_table1">
                    <tr class="first">
                        <th width="25%">Détails De Produit</th>
                        <th width="10%">Prix</th>
                        <th width="5%">QTÉ</th>
                        <th width="10%"></th>
                        <th width="5%">Livraison</th>
                        <th width="12%">Total</th>
                        <th width="18%">Statut De Commande</th>
                        <th width="20%">Action</th>
                    </tr>
                </table>
                <table class="user_table user_table1">
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
                        <tr class="second">
                            <th colspan="8">No. De Commande: <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><b><?php echo $order['ordernum']; ?></b></a>    <span>Date De Commande: <?php echo date('n/j/Y H:i:s', $order['created']); ?></span></th>
                        </tr>
                        <tr>
                            <td colspan="4" width="45%" class="table2_box">
                                <table class="table2" width="100%">
                                    <?php
                                    foreach ($products as $p):
                                        if($p['status'] == 'cancel')
                                            continue;
                                        $product = DB::select('stock', 'visibility', 'status', 'sku', 'name', 'link')->from('products_' . LANGUAGE)->where('id', '=', $p['product_id'])->execute()->current();
                                        $outstock = 0;
                                        if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                                        {
                                            $amount += $p['price'] * $p['quantity'];
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
                                                        $amount += $p['price'] * $p['quantity'];
                                                        $has = 1;
                                                        break;
                                                    }
                                                }
                                                if (!$has)
                                                    $outstock = 1;
                                            }
                                            else
                                            {
                                                $amount += $p['price'] * $p['quantity'];
                                            }
                                            $plink = LANGPATH . '/product/' . $product['link'] . '_p' . $p['product_id'];
                                        }
                                        ?>
                                        <tr>
                                            <td width="45%">
                                                <div class="fix">
                                                    <div class="left"><a href="<?php echo LANGPATH . '/product/' . $product['link'] . '_p' . $p['product_id']; ?>"><img src="<?php echo image::link(Product::instance($p['product_id'])->cover_image(), 3); ?>" /></a></div>
                                                    <div class="right">
                                                        <a href="<?php echo LANGPATH . '/product/' . $product['link'] . '_p' . $p['product_id']; ?>" class="name"><?php echo $product['name']; ?></a>
                                                        <?php if ($outstock): ?><p class="red">(En rupture de stock)</p><?php endif; ?>
                                                        <p>
                                                            <?php
                                                            $attributes = str_replace(';', ';<br>', $p['attributes']);
                                                            $attributes = str_replace('one size', 'taille unique', $attributes);
                                                            $attributes = str_replace(array('Size', 'Color'), array('Taille', 'Couleur'), $attributes);
                                                            echo $attributes;
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td width="20%"><p class="red"><?php echo Site::instance()->price($p['price'], 'code_view', NULL, $currency); ?></p></td>
                                            <td width="10%"><?php echo $p['quantity']; ?></td>
                                            <td width="15%">
                                                <?php
                                                if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                                                {
                                                    if($p['erp_line_status'] == 1)
                                                    {
                                                        $is_approve = DB::select('is_approved')->from('reviews')->where('order_id', '=', $order['id'])->where('product_id', '=', $p['product_id'])->execute()->get('is_approved');
                                                        if($is_approve)
                                                        {
                                                        ?>
                                                        <a href="<?php echo $plink; ?>#review_list" class="a_underline">commenté</a>
                                                        <?php
                                                        }
                                                        else
                                                        {
                                                        ?>
                                                        commenté
                                                        <?php
                                                        }
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                        <a href="<?php echo LANGPATH; ?>/review/add/<?php echo $p['product_id']; ?>" class="a_underline review_link">commenter</a>
                                                    <?php
                                                    }
                                                }
                                                ?>
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
                            if($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                                $amount_order = $order['amount'];
                            echo $currency['code'] . round($amount_order, 2); 
                            ?>
                            </td>
                            <td width="15%">
                                <b>
                                    <?php
			  if($order['refund_status'])
                {
                $status = 'Remboursé';
                }else{
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
                                    ?>
                                </b>
                            </td>
                            <td width="15%">
                                <?php
                                if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                                {
                                    $domain = 'www.choies.com';
                                    ?>
                                    <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="a_underline mb10">Détails De Commande</a>
                                    <?php
                                }
                                elseif (!$order['refund_status'] AND $amount > 0 AND $order['payment_status'] != 'cancel')
                                {
                                    ?>
                                    <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="btn22_red bold mb10">Payer</a>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="a_underline mb10">Détails De Commande</a>
                                <?php
                                } 
                                ?>
                                <?php
                                if ($order['shipping_status'] == 'shipped' OR $order['shipping_status'] == 'partial_shipped')
                                {
                                    ?>
                                    <span class="a_underline JS_shows_btn1 trackjs" id="<?php echo $order['ordernum']; ?>"><a href="<?php echo  LANGPATH; ?>/track/customer_track?id=<?php echo $order['ordernum']; ?>">Suivi de Commande</a>
                                        <div class="JS_shows1 share_box track_order_hidecon hide" name="0">
                                            <p>Les détails de suivi au dessous sont mis au jour récemment, <a href="<?php echo  LANGPATH; ?>/track/customer_track?id=<?php echo $order['ordernum']; ?>" class="red">cliquer ici</a> pour vérifier tous les détails. </p>
                                            <p class="mt20" id="<?php echo $order['ordernum']; ?>error_block"></p>
                                            <ul class="track_ul" id="history<?php echo $order['ordernum']; ?>"></ul>
                                        </div>
                                    </span>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                    ?>
                </table>
                <div class="fix">
                    <?php echo $pagination; ?>
                </div>  
            <?php
            endif;
            ?> 
        </article>
        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
    </section>
</section>
<script>
    $(".trackjs").hover(function(){
        var code = $(this).attr("id");
        var flg = $(this).children('div').attr('name');
        if(flg==0){
            $("#"+code+"error_block").html("Loading...").fadeIn(320);
            $("#"+code).children('div').attr('name','1');
            $.ajax({
                type: "POST",
                url: "/track/ajax_pagedata",
                dataType: "json",
                data: "code="+code,
                success: function(data){
                    if(data.result=="noData"){
                        $("#"+code+"error_block").html(data.msg).fadeIn(320)
                    }else if(data.result=="success"){
                        $("#"+code+"error_block").html("").fadeOut(320)
                        $("#history"+code).html('');
                        var item = eval(data.data)
                        for(var i=0; i<item.length;i++){
                            if(typeof(item[i]['history'])!="undefined"){
                                $("#history"+code).append("<li class=\"first\"><span class=\"btn22_black\">Paket"+(i+1)+"</span></li>");
                                for (var l = 0; l < item[i]['history'].length; l++) {
                                    $("#history"+code).append("<li>"+item[i]['history'][l]['a']+" "+item[i]['history'][l]['z']+"</li>");
                                }
                            }
                        }
                    }
                },
                error:function(){
                    $("#error_block").html("Error.").fadeIn(320)
                }
            });
        }
        $(this).find(".JS_shows1").show();
    },function(){
        $(this).find('.JS_shows1').hide();
    })
</script>