<!-- main begin -->
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">PÁGINA DE INICIO</a>  >  <a href="<?php echo LANGPATH; ?>/customer/orders">Historial De Pedidos</a></a>  >  Detalles de Rastrear</div>
        </div>
    </div>
  
    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Seguimiento de su pedido</h2></div>
            <?php if(count($datas)>0){ ?>
            <!-- 有物流 -->
            <div class="track_con">
                <ul class="box1 fix">
                    <li><b>N°de Pedido:</b> <?php echo $datas['ordernum'];?></li>
                    <li><b>Fecha De Pedido:</b> <?php echo $datas['created'];?></li>
                </ul>
                <?php if(!in_array('error',$datas['tracks'])){ ?>
                <ul class="box1 fix">
                    <?php foreach($datas['tracks'] as $key=>$track){ ?>
                    <li><b>Paquete <?php echo $key+1;?> N°de Seguimiento:</b> <?php echo $track['tracking_code'];?></li>
                    <li><b>Enlace de seguimiento:</b> <a href="<?php echo $track['tracking_link'];?>" target="_blank"><?php echo $track['tracking_link'];?></a></li>
                    <?php } ?>
                </ul>
          
                <p>Los detalles de seguimiento no se muestran correctamente en nuestro sitio debido a problemas técnicos de el sitio web de soporte, también puede realizar un seguimiento de su pedido <a class="a_red" target="_blank" href="<?php echo $track['tracking_link'];?>">aquí</a> con su N°de Seguimiento.</p>
    
                <div class="track_detail">
                    <?php if(count($datas['tracks'])>1){ ?>
                    <ul class="JS_tab detail_tab fix">
                        <?php foreach($datas['tracks'] as $key=>$track){ ?>
                        <li <?php if($key===0){ echo "class=\"current\""; }?>>Paquete<?php echo $key+1;?></li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                    <div class="JS_tabcon detail_tabcon">
                        <?php foreach($datas['tracks'] as $key=>$track){ ?>
                        <div class="bd <?php if($key!==0){ echo "hide"; }?>">
                            <ul class="box1 fix">
                                <li><b>N°de Seguimiento:</b> <span><?php echo $track['tracking_code'];?></span></li>
                                <li><b>Estado:</b> <?php echo $track['status'];?></li>
                                <li><b>País de Origen:</b> <?php echo $track['send_country'];?></li>                                                                              
                                <li><b>País de Destino:</b> <?php echo $track['dest_country'];?></li>
                            </ul>
                            <dl class="box3">
                                <dt>Historial de Seguimiento</dt>
                                <?php if(is_array($track['history'])){foreach ($track['history'] as $value) { ?>
                                <dd><?php echo $value['a'];?>, <span><?php echo $value['z'];?></span></dd>   
                                <?php }} ?>
                            </dl>
                            <dl class="box3">
                                <dt>Enviado a:</dt>
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
                <p class="color666">Lo sentimos, el N°de Seguimiento que ha introducido es incorrecto, compruebe su historial de pedidos de nuevo o <a href="<?php echo LANGPATH; ?>/contact-us" class="a_red">contacte con nosotros</a>.</p>
                <?php } ?>
            </div>
            <?php }else{ ?>
            <!-- 没有物流 -->
            <div class="track_con track_con_no">
            <p class="red">Lo sentimos, el N°de Seguimiento que ha introducido es incorrecto, compruebe su historial de pedidos de nuevo o <a href="<?php echo LANGPATH; ?>/contact-us" class="a_red">contacte con nosotros</a>.</p>
            </div>
            <?php } ?>
        </article>
    <?php echo View::factory(LANGPATH . '/customer/left'); ?>
    </section>
</section>