<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Accueil</a>  >  Niveau VIP & Privilège</div>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user doc flr">
            <div class="tit"><h2>Niveau VIP & Privilège</h2></div>
            <!-- vip -->
            <div class="vip">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th width="15%" class="first">
                    <div class="r">Privilèges</div>
                    <div>Niveau VIP</div>
                    </th>
                    <th width="20%">Montant de la transaction accumulée</th>
                    <th width="16%">Les rabais supplémentaires sur articles plein tarif</th>
                    <th width="16%">Permission de l’utilisation des points</th>
                    <th width="15%">Le coût des points</th>
                    <th width="18%">D’autres privilèges</th>
                    </tr>
                    <tr>
                        <td><span class="icon_nonvip" title="Non-VIP"></span><strong>Non-VIP</strong></td>
                        <td>$0</td>
                        <td>/</td>
                        <td rowspan="6"><div>Vous pouvez utiliser les points équivalents de 10% de la valeur de votre commande.</div></td>
                        <td rowspan="6">$1 = 1 point</td>
                        <td>Bon de réduction de 15%</td>
                    </tr>
                    <tr>
                        <td><span class="icon_vip" title="VIP"></span><strong>VIP</strong></td>
                        <td>$1 - $199</td>
                        <td>/</td>
                        <td rowspan="5"><div>Obtenir des points doubles d'achat pendant les grandes fêtes.<br/>
                        Les cadeaux d’anniversaire spéciaux,<br/>
                        etc...</div></td>
                    </tr>
                    <tr>
                        <td><span class="icon_bronze" title="Bronze VIP"></span><strong>VIP Bronze</strong></td>
                        <td>$199 - $399</td>
                        <td>5% de réduction</td>
                    </tr>
                    <tr>
                        <td><span class="icon_silver" title="Silber VIP"></span><strong>VIP Argent</strong></td>
                        <td>$399 - $599</td>
                        <td>8% de réduction</td>
                    </tr>
                    <tr>
                        <td><span class="icon_gold" title="Gold VIP"></span><strong>VIP Or</strong></td>
                        <td>$599 - $1999</td>
                        <td>10% de réduction</td>
                    </tr>
                    <tr>
                        <td><span class="icon_diamond" title="Diamant VIP"></span><strong>VIP Diamant</strong></td>
                        <td>&ge; $1999</td>
                        <td>15% de réduction</td>
                    </tr>
                </table>
            </div> 
            <div class="f00 mtb20">
                <b>Note: </b>
                <p>La valeur de la commande récompensé par les points, codes et les frais de livraison sont exclus de la transaction accumulée pour obtenir les points. Priez de nous comprendre.</p>
            </div>
            <p><img src="/images<?php echo LANGPATH; ?>/vip_img_<?php echo LANGUAGE; ?>.jpg" border="0" usemap="#Map" />
                <map name="Map" id="Map">
                    <area shape="rect" coords="598,272,760,294" href="<?php echo LANGPATH; ?>/customer/summary" />
                </map>
            </p>
        </article>
        <?php echo View::factory(LANGPATH . '/doc/left'); ?>
    </section>
</section>