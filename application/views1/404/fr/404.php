<div class="site-content">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs">
            <div>
                <a href="<?php echo LANGPATH; ?>/">Accueil</a> > 404
            </div>
            <div class="back visible-xs-inline hidden-sm hidden-md hidden-lg">&lt;&lt;&nbsp;<a class="back" href="<?php echo LANGPATH; ?>/">Retour</a>
            </div>
        </div>
    </div>
    <!-- main begin -->
    <section class="container">
        <div class="searchon-wp">
            <div class="searchon-404">
                <img src="/assets/images/404/not_found_1.png" />
                <h1>Oups... Page Non Trouvée !</h1>
                <p class="ss mt50">Nous sommes désolés de tout inconvénient.</p>
                <p class="ss">Voici votre code promo exclusif de  <b class="red">20% de réduction</b> : </p>
                <p class="b"><b class="red"><?php echo $code; ?></b>(Expirera dans 30 jours)</p>
                <p class="text-upper"><b>LE CODE NE PEUT ÊTRE UTILISÉ QUE POUR UNE FOIS.</b>
                </p>
                <p><a href="http://www.choies.com/<?php echo LANGUAGE; ?>/top-sellers-c-32" class="b">ACHETER MAINTENANT >></a>
                </p>
            </div>
            <div class="banner-404">
                <div class="left col-sm-5 col-sm-offset-2 col-xs-12">
                    <div class="col-xs-3">
                        <img src="/assets/images/404/not_found_l.png">
                    </div>
                    <div class="col-xs-9">
                        <p class="mb10"><b>ENVOYER LE CODE À MA BOÎTE AUX LETTRES >></b>
                        </p>
                        <form action="/site/404_mail" method="post" class="form">
                            <input type="hidden" name="code" value="<?php echo $code; ?>" />
                            <input type="text" name="email" value="Veillez Entrer l’Adresse E-mail" class="text" style="min-width:170px;"/>
                            <input type="submit" value="ENVOYER" class="btn" />
                        </form>
                    </div>
                </div>
                <div class="right col-sm-5 col-xs-12">
                    <div class="col-xs-3">
                        <img src="/assets/images/404/not_found_r.png">
                    </div>
                    <div class="col-xs-9">
                       <p>DEMANDE SPÉCIALE?</p>
                       <b><a href="http://www.choies.com/<?php echo LANGUAGE; ?>/contact-us">CONTACTEZ-NOUS!</a></b>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="other-customers" id="alsoview" style="display:none">
            <div class="w-tit">
                <h2>PRODUITS RECOMMANDÉS</h2>
            </div>
            <div class="box-dibu1">
            <div id="personal-recs"></div>
            <script type="text/javascript">
                        $.ajax({
                                type: "POST",
                                url: "/ajax/topseller_relate?lang=",
                                dataType: "json",
                                data: "lang=fr",
                        success: function(relate_products){
                            if(!relate_products){
                                $(".phone-fashion-top").hide();
                                $("#alsoview").hide();
                            }
                            else
                            {
                                relate_html = '';
                                for(var o in relate_products)
                                {
                                    if(o > 0)
                                    {
                                        var relate_html = '<div class="hide-box1-' + o + ' hide">';
                                    }
                                    else
                                    {
                                        var relate_html = '<div class="hide-box1-' + o + '">';
                                    }

                                    for(var p in relate_products[o])
                                    {
                                        var relate_product = relate_products[o][p];
                                        relate_html += '<li style="display: inline-block" class="rec-item">\
                                        <a href="' + relate_product['link'] + '">\
                                        <img src="' + relate_product['cover_image'] + '" class="rec-image" id="' + relate_product['sku'] + '">\
                                        </a>\
                                        <p class="price"><b>' + relate_product['price'] + '</b></p>\
                                        </li>';
                                        // add phone
                                        if(p <= 2)
                                        {
                                            phone_scare = '\
                                            <li class="col-xs-4">\
                                            <a href="' + relate_product['link'] + '">\
                                            <img src="' + relate_product['cover_image'] + '" class="rec-image" id="' + relate_product['sku'] + '">\
                                            <p class="price">' + relate_product['price'] + '</p>\
                                            </a>\
                                            </li>\
                                            ';
                                            $("#phone_scare").append(phone_scare);
                                        }

                                    }
                                       
                                    relate_html += '</div>';
                                    $("#personal-recs").append(relate_html);   
                                }                                   
                                    
                                $("#alsoview").show();
                                $(".phone-fashion-top").show();
                            }
                                }
                        });
            </script>  
                <div class="box-current" id="JS-current1">
                  <ul>
                    <li class="on"></li>
                    <li id="circle1"></li>
                    <li id="circle2"></li>
                    <li id="circle3"></li>
                  </ul>
                </div>
            </div>
                </div>
                <script type="text/javascript">
                var f=0;
                var t1;
                var tc1;
                $(function(){
                    $(".box-current1 li").hover(function(){   
                        $(this).addClass("on").siblings().removeClass("on");
                        var c=$(".box-current1 li").index(this);
                        $(".hide-box1_0,.hide-box1_1,.hide-box1_2,.hide-box1_3").hide();
                        $(".hide-box1_"+c).fadeIn(150); 
                        f=c; 
                    })
                })
                </script>

                <div class="index-fashion buyers-show">
                    <div class="phone-fashion-top w-tit">
                        <h2>PRODUITS RECOMMANDÉS</h2>
                    </div>
                    <div class="flash-sale">
                        <ul class="row" id="phone_scare"></ul>
                    </div>  
                </div>
            </div>
        </div>
    </section>
</div>