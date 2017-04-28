<section id="main">
    <!-- crumbs -->
    <div class="container visible-xs-inline hidden-sm hidden-md hidden-lg col-xs-12">
        <div class="crumbs">
            <div>
                <a href="<?php echo LANGPATH; ?>/">ACCUEIL</a>
                <a href="<?php echo LANGPATH; ?>/customer/summary"> > Mon Compte</a> >Suivi Détaillé
            </div>
        <?php echo Message::get(); ?>
        </div>
    </div>
    <!-- main-middle begin -->
    <div class="container">
        <div class="cart row">
<?php echo View::factory(LANGPATH . '/customer/left'); ?>
<?php echo View::factory(LANGPATH . '/customer/left_1'); ?>
            <div class="order-track-tit col-xs-12 col-sm-9">
                <h4>Suivi De Commande</h4>
            </div>
    <?php if(count($datas)>0){ ?>
    <!-- 有物流 -->
        <!--有物流 -->
        <div class="track-con col-xs-12 col-sm-9">
            <ul class="box1">
                <li><b>N° De Commande:</b><?php echo $datas['ordernum'];?></li>
                <li><b>Date De Commande:</b> <?php echo $datas['created'];?></li>
            </ul>
       <?php if(!in_array('error',$datas['tracks'])){ ?>
            <ul class="box2">
            <?php foreach($datas['tracks'] as $key=>$track){ ?>
                <li>Colis  <?php echo $key+1;?> N° De Suivi:<?php echo $track['tracking_code'];?><a href="<?php echo $track['tracking_link'];?>">lien de suivi:<?php echo $track['tracking_link'];?></a>
                </li>
                    <?php } ?>
            </ul>
            <p>Les détails de suivi ne se affichent pas correctement sur notre site en raison de problèmes techniques causés par le site Web du transporteur, vous pouvez également suivre votre commande <a class="a-red" target="_blank" href="<?php echo $track['tracking_link'];?>">ici</a>  avec votre n ° de suivi.</p>
            <div class="track-detail hidden-xs">
              <?php if(count($datas['tracks'])>0){ ?>
                <ul class="JS_tab detail-tab">
                <?php 

                foreach($datas['tracks'] as $key=>$track){ ?>
                <li <?php if($key==0){ echo "class=\"current\""; }?>>Colis<?php echo $key+1;?></li>
                <?php } ?>
                </ul>
            <?php } ?>
                <div class="JS_tabcon">
                <?php foreach($datas['tracks'] as $key=>$track){ ?>
                    <div class="bd <?php if($key!==0){ echo "hide"; }?>">
                        <ul class="box1 row">
                            <li class="col-xs-12 col-sm-6"><b class="col-xs-12 col-sm-2" style="padding:0;">N ° De Suivi:</b> <span class="col-xs-12 col-sm-4"><?php echo $track['tracking_code'];?></span>
                            </li>
                            <li class="col-xs-12 col-sm-6"><b>Statut:</b><?php echo $track['status'];?></li>
                            <li class="col-xs-12 col-sm-6"><b>Pays d'Origine:</b> <?php echo $track['send_country'];?></li>
                            <li class="col-xs-12 col-sm-6"><b>Pays De Destination:</b> <?php echo $track['dest_country'];?></li>
                        </ul>
                        <dl class="box3">
                            <dt>L'historique Du Suivi</dt>
                        <?php if(is_array($track['history'])){foreach ($track['history'] as $value) { ?>
                        <dd><?php echo $value['a'];?>, <span><?php echo $value['z'];?></span></dd>   
                        <?php }} ?>
                            <dd>Package Details</dd>
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
            <div class="track-detail visible-xs-block hidden-sm hidden-md hidden-lg col-xs-12">
              <?php if(count($datas['tracks'])>1){ ?>
                <ul class="detail-tab">
                <?php foreach($datas['tracks'] as $key=>$track){ ?>
                <li <?php if($key===0){ echo "class=\"current\""; }?>>Package<?php echo $key+1;?></li>
                <?php } ?>
                </ul>
                 <?php } ?>
                 <?php foreach($datas['tracks'] as $key=>$track){ ?>
                <div class="bd <?php if($key!==0){ echo "hide"; }?>">
                    <ul class="box1 row">
                        <li class="col-xs-12 col-sm-6"><b class="col-xs-12 col-sm-2" style="padding:0;">Tracking No.:</b> <span class="col-xs-12 col-sm-4"><?php echo $track['tracking_code'];?></span><span class="col-xs-12 col-sm-4"><?php echo $track['tracking_code'];?></span>
                        </li>
                        <li class="col-xs-12 col-sm-6"><b>Status:</b><?php echo $track['status'];?></li>
                        <li class="col-xs-12 col-sm-6"><b>Origin Country:</b><?php echo $track['send_country'];?></li>
                        <li class="col-xs-12 col-sm-6"><b>Destination Country:</b> <?php echo $track['dest_country'];?></li>
                    </ul>
                    <dl class="box3">
                        <dt>L'historique Du Suivi</dt>
                        <?php if(is_array($track['history'])){foreach ($track['history'] as $value) { ?>
                        <dd><?php echo $value['a'];?>, <span><?php echo $value['z'];?></span></dd>   
                        <?php }} ?>
                        <dd>Package Details</dd>
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
        <p class="color666">Désolé, le n ° de suivi saisi est incorrect, veuillez vérifier votre historique des commandes à nouveau ou <a href="<?php echo LANGPATH; ?>/contact-us" class="a_red a-underline" style="display:inline;">nous contacter</a>.</p>
        <?php } ?>
    </div>
        <!--无物流 -->
    <?php }else{ ?>
        <div id="msg" class="track-con-no col-xs-12 col-sm-9">
            <p class="red" style="">Désolé, le n ° de suivi saisi est incorrect, veuillez vérifier votre historique des commandes à nouveau ou <a href="<?php echo LANGPATH; ?>/contact-us" class="a_red a-underline" style="display:inline;">nous contacter</a>.</p>
        </div>
    <?php } ?>



    </div>
</section>
