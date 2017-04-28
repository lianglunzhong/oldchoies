<!-- main begin -->
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Homepage</a>  >  <a href="<?php echo LANGPATH; ?>/customer/orders">Bestellhistorie</a></a>  >  Bestellungdetails</div>
        </div>
    </div>
  
    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Ihre Bestellung Verfolgen</h2></div>
            <?php if(count($datas)>0){ ?>
            <!-- 有物流 -->
            <div class="track_con">
                <ul class="box1 fix">
                    <li><b>Bestellnummer:</b> <?php echo $datas['ordernum'];?></li>
                    <li><b>Bestelldatum:</b> <?php echo $datas['created'];?></li>
                </ul>
                <?php if(!in_array('error',$datas['tracks'])){ ?>
                <ul class="box1 fix">
                    <?php foreach($datas['tracks'] as $key=>$track){ ?>
                    <li><b>Paket <?php echo $key+1;?> Sendungnummer.:</b> <?php echo $track['tracking_code'];?></li>
                    <li><b>Versolgungslink:</b> <a href="<?php echo $track['tracking_link'];?>" target="_blank"><?php echo $track['tracking_link'];?></a></li>
                    <?php } ?>
                </ul>
          
                <p>Die Verfolgung Informationen werden nicht richtig auf unserer Website angezeigt wegen technischer Probleme, die von der Website Träger verursacht werden, Sie können auch Ihre Bestellung <a class="a_red" target="_blank" href="<?php echo $track['tracking_link'];?>">hier</a> mit Ihrer Sendungnummer verfolgen.</p>
    
                <div class="track_detail">
                    <?php if(count($datas['tracks'])>1){ ?>
                    <ul class="JS_tab detail_tab fix">
                        <?php foreach($datas['tracks'] as $key=>$track){ ?>
                        <li <?php if($key===0){ echo "class=\"current\""; }?>>Paket<?php echo $key+1;?></li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                    <div class="JS_tabcon detail_tabcon">
                        <?php foreach($datas['tracks'] as $key=>$track){ ?>
                        <div class="bd <?php if($key!==0){ echo "hide"; }?>">
                            <ul class="box1 fix">
                                <li><b>Sendungnummer:</b> <span><?php echo $track['tracking_code'];?></span></li>
                                <li><b>Status:</b> <?php echo $track['status'];?></li>
                                <li><b>Herkunftsland:</b> <?php echo $track['send_country'];?></li>                                                                              
                                <li><b>Zielland:</b> <?php echo $track['dest_country'];?></li>
                            </ul>
                            <dl class="box3">
                                <dt>Sendungnummer Historie</dt>
                                <?php if(is_array($track['history'])){foreach ($track['history'] as $value) { ?>
                                <dd><?php echo $value['a'];?>, <span><?php echo $value['z'];?></span></dd>   
                                <?php }} ?>
                            </dl>
                            <dl class="box3">
                                <dt>Versandt Nach:</dt>
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
                <p class="color666">Entschuldigung, die von Ihnen eingegebene Sendungnummer ist falsch, überprüfen Sie bitte Ihre Bestellhistorie wieder oder <a href="<?php echo LANGPATH; ?>/contact-us" class="a_red">kontaktieren Sie uns</a>.</p>
                <?php } ?>
            </div>
            <?php }else{ ?>
            <!-- 没有物流 -->
            <div class="track_con track_con_no">
            <p class="red">Entschuldigung, die von Ihnen eingegebene Sendungnummer ist falsch, überprüfen Sie bitte Ihre Bestellhistorie wieder oder <a href="<?php echo LANGPATH; ?>/contact-us" class="a_red">kontaktieren Sie uns</a>.</p>
            </div>
            <?php } ?>
        </article>
        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
    </section>
</section>