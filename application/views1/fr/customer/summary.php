<!-- main begin -->
<section id="main">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs">
            <div>
                <a href="<?php echo LANGPATH; ?>/">Accueil</a> > Mon Compte
            </div>
        </div>
    </div>
    <!-- main-middle begin -->
    <div class="container">
        <div class="row">
<?php
$url = URL::current(0);
$lists = array(
    'MES COMMANDES' => array(
        array(
            'name' => 'Historique de Commandes',
            'link' => LANGPATH . '/customer/orders'
        ),
        array(
            'name' => 'Commande impayée',
            'link' => LANGPATH . '/customer/unpaid_orders'
        ),
        array(
            'name' => 'Items to review',
            'link' => '#'
        ),
        array(
            'name' => 'Liste d’envies',
            'link' => LANGPATH . '/customer/wishlist'
        ),
        array(
            'name' => 'Suivi de Commande',
            'link' => LANGPATH . '/tracks/track_order'
        ),
    ),
    'MON PROFIL' => array(
        array(
            'name' => 'Paramètre de compte',
            'link' => LANGPATH . '/customer/profile'
        ),
        array(
            'name' => 'Changer le mot de passe',
            'link' => LANGPATH . '/customer/password'
        ),
        array(
            'name' => 'Carnet d’adresses',
            'link' => LANGPATH . '/customer/address'
        ),
        array(
            'name' => 'Créer une adresse',
            'link' => LANGPATH . '/address/add'
        )
    ),
    'POINTS & COUPONS' => array(
        array(
            'name' => 'Historique de points',
            'link' => LANGPATH . '/customer/points_history'
        ),
        array(
            'name' => 'Social Sharing Bonus',
            'link' => '#'
        ),
        array(
            'name' => 'Mes Coupons',
            'link' => LANGPATH . '/customer/coupons'
        ),
    ),
);

$customer_id = Customer::logged_in();
$email = Customer::instance($customer_id)->get('email');
$celebrity = DB::select('id')->from('celebrities_celebrits')->where('email', '=', $email)->execute()->get('id');
if ($celebrity)
{
    $lists['My Profile'][] = array(
        'name' => 'Mon blog show',
        'link' => LANGPATH . '/customer/blog_show'
    );
}
?>
<aside id="aside" class="col-sm-3 col-xs-10 col-xs-offset-2 col-sm-offset-0">
    <a href="<?php echo LANGPATH; ?>/customer/summary" class="user-home hidden-xs">Mon Compte</a>
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
    <a href="<?php echo LANGPATH; ?>/customer/logout" class="user-home">Me Déconnecter</a>
</aside>

                    <article class="user user-account col-sm-9 hidden-xs">
                        <dl>
							<dt>Bonjour, <?php echo $customer->get('firstname') ? $customer->get('firstname') : 'Choieser'; ?> . Bienvenue à CHOICES.</dt>
							<dd>Membre VIP ou Non: <strong class="mr10"> <?php if($is_vip){ echo "Oui";}else{ echo "Non";}?></strong>
							<?php
								if($vip_end){
							?>
							<span>Expire le: <strong><?php echo $vip_end?></strong></span></dd>
							<?php
								}
							?>
						</dl>	
                        <!-- vip -->
                        <div class="vip JS_clickcon hide">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <th width="15%" class="first">
                                        <div class="r">Privileges</div>
                                       <div>Niveau VIP</div>
                                    </th>
                                    <th width="20%">Montant accumulé  de transaction</th>
                                    <th width="16%">Rabais supplémentaires sur articles</th>
                                    <th width="16%">Autorisation de l'utilisation des points</th>
                                    <th width="15%">Points de récompense de commande</th>
                                    <th width="18%">D'autres privilèges</th>
                                </tr>
                                <tr>
                                    <td><span class="icon-nonvip" title="Non-VIP"></span><strong>Non-VIP</strong>
                                    </td>
                                    <td>$0</td>
                                    <td>/</td>
                                    <td rowspan="6">
                                        <div>Vous pouvez utiliser les points équivalant à seulement 10% de la valeur de votre commande.</div>
                                    </td>
                                    <td rowspan="6">$1 = 1 points</td>
                                    <td>Bon de réduction de 15%</td>
                                </tr>
                                <tr>
                                    <td><span class="icon-vip" title="VIP"></span><strong>VIP</strong>
                                    </td>
                                    <td>$1 - $199</td>
                                    <td>/</td>
                                    <td rowspan="5">
                        <div>Obtenir des points doubles d'achat pendant les grandes fêtes.<br/>
                                      Cadeau d'anniversaire<br/>
                                           Et plus...</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="icon-bronze" title="Bronze VIP"></span><strong>VIP Bronze</strong>
                                    </td>
                                    <td>$199 - $399</td>
                                    <td>5% de réduction</td>
                                </tr>
                                <tr>
                                    <td><span class="icon-silver" title="Silver VIP"></span><strong>VIP Argent</strong>
                                    </td>
                                    <td>$399 - $599</td>
                                     <td>8% de réduction</td>
                                </tr>
                                <tr>
                                    <td><span class="icon-gold" title="Gold VIP"></span><strong>VIP Or</strong>
                                    </td>
                                    <td>$599 - $1999</td>
                                    <td>10% de réduction</td>
                                </tr>
                                <tr>
                                    <td><span class="icon-diamond" title="Diamond VIP"></span><strong>VIP Diamant</strong>
                                    </td>
                                    <td>&ge; $1999</td>
                                    <td>15% de réduction</td>
                                </tr>
                            </table>
                        </div>
                        <!--order-list-->
            <?php if(!empty($orders)){ ?>
                        <div class="order-list fix">
						<h4 style="font-size:18px;margin-bottom:10px;font-weight:normal;">Ci-dessous sont vos commandes récentes: </h4>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr bgcolor="#e4e4e4">
                    <th width="20%"><strong>Date De Commande</strong></th>
                    <th width="20%"><strong>No. De Commande</strong></th>
                    <th width="15%"><strong>Total</strong></th>
                    <th width="15%"><strong>Livraison</strong></th>
                    <th width="15%"><strong>Statut De Commande</strong></th>
                    <th width="15%"><strong>Action</strong></th>
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
                            if($order['shipping_status']=="new_s" OR $order['payment_status']=="cancel")
                            {
                                $status=$order['payment_status'];
                            }else{
                                $status=$order['shipping_status'];
                            }
                        }
                      if ($status == 'new'){ $status = 'Impayé'; }
                        elseif ($status == 'Unpaid'){ $status = 'impayé'; }
                        elseif ($status == 'cancel'){ $status = 'annuler'; }
                        elseif ($status == 'failed'){ $status = 'Échoué'; }
                        elseif ($status == 'success'){ $status = 'Succès'; }
                        elseif ($status == 'pending'){ $status = 'En attendant'; }
                        elseif ($status == 'partial_paid'){ $status = 'Payé partiellement'; }
                        elseif ($status == 'processing'){ $status = 'Traitement'; }
                        elseif ($status == 'shipped'){ $status = 'Expédié'; }
                        elseif ($status == 'partial_shipped'){ $status = 'Expédié partiellement'; }
                        elseif ($status == 'delivered'){ $status = 'Délivré'; }
                        elseif ($status == 'prepare refund'){ $status = 'Préparer remboursement'; }
                        elseif ($status == 'partial refund'){ $status = 'Remboursé partiellement'; }
                        elseif ($status == 'refund'){ $status = 'Remboursé'; }
                        echo ucfirst($status);
                        ?>
                    </td>
                    <td>
                    <?php
                    if($order['shipping_status'] == 'shipped' OR $order['shipping_status'] == 'partial_shipped'){
                        ?>
                        <a href="<?php echo LANGPATH; ?>/tracks/customer_track?id=<?php echo $order['ordernum']; ?>" class="order-list-btn">SUIVRE</a>
                    <?php }else{
                    if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                    {?>
                    <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>">Détails De Commande</a>
                    <?php }elseif (!$order['refund_status'] AND $order['amount'] > 0 AND ($order['payment_status']=="new" or $order['payment_status']=="failed")){ ?>
                        <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="btn btn-primary btn-xs">Payer</a>
                    <?php }else{ ?>
                        <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>">Détails De Commande</a>
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
                                <h2>Consultés récemment</h2>
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



