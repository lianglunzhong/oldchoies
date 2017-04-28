<style>
    @charset "utf-8";
    #NOTICE {
        background-image: url(/images/<?php echo LANGUAGE; ?>/activity/bg.jpg);
        width: 1024px;
        margin-right: auto;
        margin-left: auto;
    }
    body {
        margin-top: 0px;
    }
    #content_top
    {
        width: 596px;
        margin-right: auto;
        margin-left: auto;
        background-image: url(/images/<?php echo LANGUAGE; ?>/activity/act_03.jpg);
        background-repeat: no-repeat;
    }

    .t2 {
        font-size: 14px;
        font-weight: normal;
        font-family: Arial;
        color: #FFF;
        line-height: 25px;
    }
    #bottom_banner {
        margin-right: auto;
        margin-left: auto;
        width: 900px;
        padding-bottom: 50px;
        padding-top: 40px;
    }
    .pic_bottom {
        border: 5px solid #F03B30;
    }
    .pic_bottom:hover {
        border: 5px solid #C12016;
    }

    .t4 {
        font-size: 125px;
        color: #bf2016;
        font-family: Arial;
        font-weight: bold;
        line-height:50px;
    }
    .t5 {
        font-size: 30px;
        color: #fff;
        font-family: Arial;
        font-style: italic;
        font-weight: bold;
        line-height:40px;
    }

    .t7{
        font-size: 25px;
        color: #FFF;
        font-family: Arial;
        line-height:30px;
    }
    #content_2 img {
        float: right;
    }
</style>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  Holiday Notice</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <section class="layout fix">
        <div id="NOTICE">
            <div id="banner" style="display:block" border="0">
                <img src="/images/<?php echo LANGUAGE; ?>/activity/act_01.jpg" width="1024" height="209"/>
            </div><!--banner-->

            <div id="content_top">
                <div id="content_1">
                    <table width="596" height="482" border="0" cellspacing="0" cellpadding="0" style="display:inline-block;">
                        <tr>
                            <td width="316" height="154"></td>
                            <td width="280" height="154"></td>
                        </tr>
                        <tr>
                            <td height="328"><span class="t2" style="font-size:20px;"><strong>Liebe Kunden,</strong></span><br/>
                                <span class="t2">Vielen Dank für Ihr Besuch.</span><br/>
                                <span class="t2">Unsere kooperative Hersteller und Schifffahrtsunternehmen werden in Chinesische Frühlingsfest Saison Ferien machen.<br />
                                </span><span class="t2">Alle Bestellungen</span>
                                <span class="t2" style="color:#FF0;font-style: italic; font-weight: bold; font-size:18px">von 14. Februar bis 28. Februar</span> <span class="t2">werden im März versendet werden.Manche maßgeschneiderte Schuhe können am Ende des März versendet werden.<br />
                                </span><span class="t2">Hier möchten wir unsere aufrichtige Entschuldigung aus vollem Herzen ausdrücken.</span><br/>
                                <span class="t2" style="color:#FF0;font-style: italic; font-weight: bold; font-size:16px">Aber für alle verschobene Bestellungen werden Sie eine Entschädigung erhalten.</span>
                            </td>
                            <td height="328"></td>
                        </tr>
                    </table><!--content_1-->
                </div>
                <div id="content_2">
                    <table style="display:inline-block;">
                        <tr>
                            <td>
                                <span class="t4"  style="line-height:100px;">a.</span>
                                <span class="t5">Für Bestellungen unter</span><span class="t5" style="color:#FF0"> $39,</span>
                                <span class="t7">werden wir Ihnen zusätzliche <span style="color:#FF0"><strong>1000</strong></span> Einkaufspunkte (im Wert von <strong>$10</strong>) schenken.</span>
                                <img src="/images/<?php echo LANGUAGE; ?>/activity/coin.png" width="105" height="95" />
                            </td>
                        </tr>
                        <tr> 
                            <td> 
                                <span class="t4">b.</span>
                                <span class="t5">Für Bestellungen</span><span class="t5" style="color:#FF0"> $39 +</span>
                                <span class="t7">, werden wir Ihnen ein Zusätzliches Geschenk im Paket versenden.</span>  
                                <img src="/images/<?php echo LANGUAGE; ?>/activity/gift.png" width="250" height="140" />
                            </td>
                        </tr> 
                    </table>        
                </div><!--content_2-->
            </div><!--content_top-->

            <div id="bottom_banner">
                <a href="<?php echo BASEURL ;?>/ready-to-be-shipped" target="_blank">
                <?php
                $date = date('Ymd');
                if($date >= '20150213')
                    $img = 'banner_bottom_1.jpg';
                else
                    $img = 'banner_bottom_3.jpg';
                ?>
                    <img src="/images/<?php echo LANGUAGE; ?>/activity/<?php echo $img; ?>" width="900" height="465" class="pic_bottom"/>
                </a> 
            </div><!--bottom_banner-->

        </div><!--notice-->
    </section>
</section>