<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Página de Inicio</a>  >  VIP Nivel Y Privilegios</div>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user doc flr">
            <div class="tit"><h2>VIP Nivel Y Privilegios</h2></div>
            <!-- vip -->
            <div class="vip">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th width="15%" class="first">
                    <div class="r">Privilegios</div>
                    <div>VIP Nivel</div>
                    </th>
                    <th width="20%">Importe de transacción </th>
                    <th width="16%">Descuento Extra por Articulo de Precio Completo</th>
                    <th width="16%">Puntos Permitidos</th>
                    <th width="15%">Puntos Recompensados de Pedido</th>
                    <th width="18%">Otros Privilegios</th>
                    </tr>
                    <tr>
                        <td><span class="icon_nonvip" title="NO VIP"></span><strong>NO VIP</strong></td>
                        <td>$0</td> 
                        <td>/</td>
                        <td rowspan="6"><div>Usted puede solicitar puntos que equivalen a sólo 10% de valor del pedido.</div></td>
                        <td rowspan="6">$1 = 1 Punto</td>
                        <td>15% de descuento  código promocional</td>
                    </tr>
                    <tr>
                        <td><span class="icon_vip" title="VIP"></span><strong>VIP</strong></td>
                        <td>$1 - $199</td>
                        <td>/</td>
                        <td rowspan="5"><div>Consigue puntos comerciales dobles durante los principales días festivos.<br>
                                Regalo de cumpleaños especial.<br>
                                Y más...</div></td>
                    </tr>
                    <tr>
                        <td><span class="icon_bronze" title="VIP Bronce"></span><strong>VIP Bronce</strong></td>
                        <td>$199 - $399</td>
                        <td>5% menos</td>
                    </tr>
                    <tr>
                        <td><span class="icon_silver" title="VIP plata"></span><strong>VIP plata</strong></td>
                        <td>$399 - $599</td>
                        <td>8% menos</td>
                    </tr>
                    <tr>
                        <td><span class="icon_gold" title="VIP oro"></span><strong>VIP oro</strong></td>
                        <td>$599 - $1999</td>
                        <td>10% menos</td>
                    </tr>
                    <tr>
                        <td><span class="icon_diamond" title="VIP diamante"></span><strong>VIP diamante</strong></td>
                        <td>&ge; $1999</td>
                        <td>15% menos</td>
                    </tr>
                </table>
            </div> 
            <div class="f00 mtb20">
                <b>Nota: </b>
                <p>Valor del pedido redimido por Puntos, los códigos y los gastos de envío son excluidos de la acumulación de transacciones para conseguir puntos. Por favor, entienda eso.</p>
            </div>
            <p><img src="/images/es/vip_img.jpg" border="0" usemap="#Map" />
                <map name="Map" id="Map">
                    <area shape="rect" coords="598,272,760,294" href="<?php echo LANGPATH; ?>/customer/summary" />
                </map>
            </p>
        </article>
        <?php echo View::factory(LANGPATH . '/doc/left'); ?>
    </section>
</section>