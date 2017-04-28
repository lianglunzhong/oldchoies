<section id="main">
	<!-- crumbs -->
	<div class="container visible-xs-inline hidden-sm hidden-md hidden-lg col-xs-12">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/">PÁGINA DE INICIO</a>
				<a href="<?php echo LANGPATH; ?>/customer/summary"> > RESUMEN DE CUENTA</a> > Seguimiento de su pedido
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
				<h4>Seguimiento de su pedido</h4>
			</div>
    <?php if(count($datas)>0){ ?>
    <!-- 有物流 -->
		<!--有物流 -->
		<div class="track-con col-xs-12 col-sm-9">
			<ul class="box1">
				<li><b>No. de Pedido:</b><?php echo $datas['ordernum'];?></li>
				<li><b>Fecha De Pedido:</b> <?php echo $datas['created'];?></li>
			</ul>
       <?php if(!in_array('error',$datas['tracks'])){ ?>
			<ul class="box2">
            <?php foreach($datas['tracks'] as $key=>$track){ ?>
				<li>Paquete <?php echo $key+1;?>  N°de Seguimiento.: <?php echo $track['tracking_code'];?><a href="<?php echo $track['tracking_link'];?>">Enlace de seguimiento: <?php echo $track['tracking_link'];?></a>
				</li>
                    <?php } ?>
			</ul>
        	<p>Los detalles de seguimiento no se muestran correctamente en nuestro sitio debido a problemas técnicos de el sitio web de soporte, también puede realizar un seguimiento de su pedido <a class="a_red" target="_blank" href="<?php echo $track['tracking_link'];?>">aquí</a> con su N°de Seguimiento.</p>
			<div class="track-detail hidden-xs">
			  <?php if(count($datas['tracks'])>0){ ?>
				<ul class="JS_tab detail-tab">
                <?php 

				foreach($datas['tracks'] as $key=>$track){ ?>
                <li <?php if($key==0){ echo "class=\"current\""; }?>>Paquete<?php echo $key+1;?></li>
                <?php } ?>
				</ul>
            <?php } ?>
				<div class="JS_tabcon">
                <?php foreach($datas['tracks'] as $key=>$track){ ?>
					<div class="bd <?php if($key!==0){ echo "hide"; }?>">
						<ul class="box1 row">
							<li class="col-xs-12 col-sm-6"><b class="col-xs-12 col-sm-2" style="padding:0;">N°de Seguimiento:</b> <span class="col-xs-12 col-sm-4"><?php echo $track['tracking_code'];?></span>
							</li>
							<li class="col-xs-12 col-sm-6"><b>Estado:</b><?php echo $track['status'];?></li>
							<li class="col-xs-12 col-sm-6"><b>País de Origen:</b> <?php echo $track['send_country'];?></li>
							<li class="col-xs-12 col-sm-6"><b>País de Destino:</b> <?php echo $track['dest_country'];?></li>
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
			<div class="track-detail visible-xs-block hidden-sm hidden-md hidden-lg col-xs-12">
			  <?php if(count($datas['tracks'])>1){ ?>
				<ul class="detail-tab">
				<?php foreach($datas['tracks'] as $key=>$track){ ?>
                <li <?php if($key===0){ echo "class=\"current\""; }?>>Paquete<?php echo $key+1;?></li>
                <?php } ?>
				</ul>
				 <?php } ?>
				 <?php foreach($datas['tracks'] as $key=>$track){ ?>
				<div class="bd <?php if($key!==0){ echo "hide"; }?>">
					<ul class="box1 row">
						<li class="col-xs-12 col-sm-6"><b class="col-xs-12 col-sm-2" style="padding:0;">N°de Seguimiento:</b> <span class="col-xs-12 col-sm-4"><?php echo $track['tracking_code'];?></span><span class="col-xs-12 col-sm-4"><?php echo $track['tracking_code'];?></span>
						</li>
						<li class="col-xs-12 col-sm-6"><b>Estado:</b><?php echo $track['status'];?></li>
						<li class="col-xs-12 col-sm-6"><b>País de Origen:</b><?php echo $track['send_country'];?></li>
						<li class="col-xs-12 col-sm-6"><b>País de Destino:</b> <?php echo $track['dest_country'];?></li>
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
		<!--无物流 -->
    <?php }else{ ?>
		<div id="msg" class="track-con-no col-xs-12 col-sm-9">
    		<p class="red">Lo sentimos, el N°de Seguimiento que ha introducido es incorrecto, compruebe su historial de pedidos de nuevo o <a href="<?php echo LANGPATH; ?>/contact-us" class="a_red">contacte con nosotros</a>.</p>
		</div>
	<?php } ?>



	</div>
</section>
