<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Homepage</a>  >  VIP Niveau & Privilegien</div>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user doc flr">
            <div class="tit"><h2>VIP Niveau & Privilegien</h2></div>
            <!-- vip -->
            <div class="vip">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th width="15%" class="first">
                    <div class="r">Privilegien</div>
                    <div>VIP Niveau</div>
                    </th>
                    <th width="20%">Kumulierte Transaktionsbetrag</th>
                    <th width="16%">Zusätzliche Rabatte für Artikel zum vollen Preis</th>
                    <th width="16%">Punkte-Verwenden Berechtigungen</th>
                    <th width="15%">Bestellung-Punkte Belohnung</th>
                    <th width="18%">Andere Vorrechte</th>
                    </tr>
                    <tr>
                        <td><span class="icon_nonvip" title="Non-VIP"></span><strong>Nicht-VIP</strong></td>
                        <td>$0</td>
                        <td>/</td>
                        <td rowspan="6"><div>Sie können Punkte bis zu insgesamt 10% des Auftragswertes anwenden.</div></td>
                        <td rowspan="6">$1 = 1 Punkt</td>
                        <td>15% Rabatte Code</td>
                    </tr>
                    <tr>
                        <td><span class="icon_vip" title="VIP"></span><strong>VIP</strong></td>
                        <td>$1 - $199</td>
                        <td>/</td>
                        <td rowspan="5"><div>Sie können Doppel Einkaufspunkte während der großen Ferien erhalten.<br />
                                Besondere Geburtstagsgeschenk.<br />
                                Und mehr...</div></td>
                    </tr>
                    <tr>
                        <td><span class="icon_bronze" title="Bronze VIP"></span><strong>Bronze VIP</strong></td>
                        <td>$199 - $399</td>
                        <td>5% Rabatte</td>
                    </tr>
                    <tr>
                        <td><span class="icon_silver" title="Silber VIP"></span><strong>Silber VIP</strong></td>
                        <td>$399 - $599</td>
                        <td>8% Rabatte</td>
                    </tr>
                    <tr>
                        <td><span class="icon_gold" title="Gold VIP"></span><strong>Gold VIP</strong></td>
                        <td>$599 - $1999</td>
                        <td>10% Rabatte</td>
                    </tr>
                    <tr>
                        <td><span class="icon_diamond" title="Diamant VIP"></span><strong>Diamant VIP</strong></td>
                        <td>&ge; $1999</td>
                        <td>15% Rabatte</td>
                    </tr>
                </table>
            </div> 
            <div class="f00 mtb20">
                <b>Hinweis: </b>
                <p>Bestellwert von Punkten, Codes und Versandkosten ist von der Transaktion Akkumulation ausgeschlossen, um Punkte zu bekommen. Vielen Dank im voraus für Ihr Verständnis.</p>
            </div>
            <p><img src="/images/de/vip_img_<?php echo LANGUAGE; ?>.jpg" border="0" usemap="#Map" />
                <map name="Map" id="Map">
                    <area shape="rect" coords="598,272,760,294" href="<?php echo LANGPATH; ?>/customer/summary" />
                </map>
            </p>
        </article>
        <?php echo View::factory(LANGPATH . '/doc/left'); ?>
    </section>
</section>