<!-- main begin -->
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">ACCUEIL</a>  >  <a href="<?php echo LANGPATH; ?>/customer/orders">Historique des Commandes</a></a>  >  Suivi Détaillé</div>
        </div>
    </div>
  
    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Suivi De Commande</h2></div>
            <?php if(count($datas)>0){ ?>
            <!-- has -->
            <div class="track_con">
                <ul class="box1 fix">
                    <li><b>N° De Commande:</b> <?php echo $datas['ordernum'];?></li>
                    <li><b>Date De Commande:</b> <?php echo $datas['created'];?></li>
                </ul>
                <?php if(!in_array('error',$datas['tracks'])){ ?>
                <ul class="box1 fix">
                    <?php foreach($datas['tracks'] as $key=>$track){ ?>
                    <li><b>Colis <?php echo $key+1;?> N° De Suivi:</b> <?php echo $track['tracking_code'];?></li>
                    <li><b>lien de suivi:</b> <a href="<?php echo $track['tracking_link'];?>" target="_blank"><?php echo $track['tracking_link'];?></a></li>
                    <?php } ?>
                </ul>
          
                <p>Les détails de suivi ne se affichent pas correctement sur notre site en raison de problèmes techniques causés par le site Web du transporteur, vous pouvez également suivre votre commande <a class="a_red" target="_blank" href="<?php echo $track['tracking_link'];?>">ici</a> avec votre n ° de suivi.</p>
    
                <div class="track_detail">
                    <?php if(count($datas['tracks'])>1){ ?>
                    <ul class="JS_tab detail_tab fix">
                        <?php foreach($datas['tracks'] as $key=>$track){ ?>
                        <li <?php if($key===0){ echo "class=\"current\""; }?>>Colis<?php echo $key+1;?></li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                    <div class="JS_tabcon detail_tabcon">
                        <?php foreach($datas['tracks'] as $key=>$track){ ?>
                        <div class="bd <?php if($key!==0){ echo "hide"; }?>">
                            <ul class="box1 fix">
                                <li><b>N ° De Suivi:</b> <span><?php echo $track['tracking_code'];?></span></li>
                                <li><b>Statut:</b> <?php echo $track['status'];?></li>
                                <li><b>Pays d'Origine:</b> <?php echo $track['send_country'];?></li>                                                                              
                                <li><b>Pays De Destination:</b> <?php echo $track['dest_country'];?></li>
                            </ul>
                            <dl class="box3">
                                <dt>L'historique Du Suivi</dt>
                                <?php if(is_array($track['history'])){foreach ($track['history'] as $value) { ?>
                                <dd><?php echo $value['a'];?>, <span><?php echo $value['z'];?></span></dd>   
                                <?php }} ?>
                            </dl>
                            <dl class="box3">
                                <dt>Expédié Pour:</dt>
                                <dd><?php echo $track['shipping_address'].','.$track['shipping_city'].','.$track['shipping_state'];?></dd>
                                <dd><?php echo $track['shipping_country'];?></dd>
                                <dd><?php echo $track['shipping_zip'];?></dd>
                                <dd><?php echo $track['shipping_phone'];?></dd>
                            </dl>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php }else{ ?>
                <p class="color666">Désolé, le n ° de suivi saisi est incorrect, veuillez vérifier votre historique des commandes à nouveau ou <a href="<?php echo LANGPATH; ?>/contact-us" class="a_red">nous contacter</a>.</p>
                <?php } ?>
            </div>
            <?php }else{ ?>
            <!-- nothing -->
            <div class="track_con track_con_no">
            <p class="red">Désolé, le n ° de suivi saisi est incorrect, veuillez vérifier votre historique des commandes à nouveau ou <a href="<?php echo LANGPATH; ?>/contact-us" class="a_red">nous contacter</a>.</p>
            </div>
            <?php } ?>
        </article>
        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
    </section>
</section>