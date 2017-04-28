<div class="site-content">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs">
            <div>
                <a href="<?php echo LANGPATH; ?>/">home</a> > 404
            </div>
            <div class="back visible-xs-inline hidden-sm hidden-md hidden-lg">&lt;&lt;&nbsp;<a class="back" href="/">back</a>
            </div>
        </div>
    </div>
    <!-- main begin -->
    <section class="container">
        <div class="searchon-wp">
            <div class="searchon-404">
                <img src="/assets/images/404/not_found_1.png" />
                <h1>Упс... Страница Не Найдена!</h1>
                <p class="ss mt50">Мы искренне сожалеем за причиненные неудобства.</p>
                <p class="ss">Вот ваш эксклюзивный код купона<b class="red">20% off</b> coupon code: </p>
                <p class="b"><b class="red"><?php echo $code; ?></b>(Истекает в течение 30 дней)</p>
                <p class="text-upper"><b>КОД МОЖЕТ БЫТЬ ИСПОЛЬЗОВАН ТОЛЬКО ОДИН РАЗ.</b>
                </p>
                <p><a href="<?php echo BASEURL ;?>/<?php echo LANGUAGE; ?>/top-sellers-c-32" class="b">КУПИТЬ СЕЙЧАС >></a>
                </p>
            </div>
            <div class="banner-404">
                <div class="left col-sm-5 col-sm-offset-2 col-xs-12">
                    <div class="col-xs-3">
                        <img src="/assets/images/404/not_found_l.png">
                    </div>
                    <div class="col-xs-9">
                        <p class="mb10"><b>ОТПРАВИТЬ КОД НА МОЙ ПОЧТУ >></b>
                        </p>
                        <form action="/site/404_mail" method="post" class="form">
                            <input type="hidden" name="code" value="<?php echo $code; ?>" />
                            <input type="text" name="email" value="Введите Адрес Электронной Почты" class="text" style="min-width:170px;"/>
                            <input type="submit" value="ОТПРАВИТЬ" class="btn" />
                        </form>
                    </div>
                </div>
                <div class="right col-sm-5 col-xs-12">
                    <div class="col-xs-3">
                        <img src="/assets/images/404/not_found_r.png">
                    </div>
                    <div class="col-xs-9">
                       <p>Особая Просьба?</p>
                       <b><a href="<?php echo BASEURL ;?>/<?php echo LANGUAGE; ?>/contact-us">Свяжитесь С Нами</a></b>
                    </div>
                </div>
            </div>
        </div>

        <div class="other-customers" id="alsoview" style="display:none">
            <div class="w-tit">
                <h2>РЕКОМЕНДУЕМЫЕ ТОВАРЫ</h2>
            </div>
            <div class="box-dibu1">
                <!-- Template for rendering recommendations -->
                <script type="text/html" id="simple-tmpl" >
                    <![CDATA[
                    {{ for (var i=0; i < SC.page.products.length; i++) { }}
                        {{ if(i==0){ }}
                        <div class="hide-box1-0"><ul>
                        {{ }else if(i%7==0){ }}
                        <div class="hide-box1-{{= i/7 }} hide"><ul>
                        {{ } }}
                      {{ var p = SC.page.products[i]; }}
                      <li data-scarabitem="{{= p.id }}" style="display: inline-block" class="rec-item">
                         <a href="{{=p.link}}" id="em{{= p.id }}link">
                          <img src="{{=p.image}}" class="rec-image">
                        </a>
                        <p class="price"><b>${{=p.price}}</b></p>
                      </li>
                        {{ if(i==6 || i==13 || i==20 || i==27){ }}
                        </ul></div>
                        {{ } }}
                    {{ } }}
                    ]]>
                    </script>
                    <div id="personal-recs"></div>
                    <script type="text/javascript">
                    // Request personalized recommendations.
                    Cart = (function() {
                    var cart = [];
                    var render = function() {
                        ScarabQueue.push(['cart', cart]);
                        ScarabQueue.push(['recommend', {
                            logic: 'CART',
                            limit: 28,
                            containerId: 'personal-recs',
                            templateId: 'simple-tmpl',
                            success: function(SC, render) {
                                var psku="";
                                for (var i = 0, l = SC.page.products.length; i < l; i++) {
                                    var product = SC.page.products[i]; 
                                    psku+=product.id+",";
                                }
                                var pdata=[];
                                var phone_scare = '';
                                var num = 0;
                                render(SC);
                                $.ajax({
                                        type: "POST",
                                        url: "/site/emarsysdata?page=product",
                                        dataType: "json",
                                        data:"sku="+psku+"&lang=<?php echo LANGUAGE; ?>",
                                        success: function(data){
                                            for(var o in data){
                                                $("#em"+o+"link").attr("href",data[o]["link"]);
                                                $("#em"+o+"price").html(data[o]["price"]);
                                                if(data[o]["show"]==0 || typeof(data[o]["link"]) == "undefined"){
                                                    $("#em"+o).css('display','none');
                                                }
                                                else
                                                {
                                                    num ++;
                                                    if(num <= 12)
                                                    {
                                                        phone_scare = '\
                                                        <li class="col-xs-6">\
                                                            <a href="' + data[o]['link'] + '">\
                                                                <img src="' + data[o]['cover_image'] + '">\
                                                                <p class="price">' + data[o]['price'] + '</p>\
                                                            </a>\
                                                        </li>\
                                                        ';
                                                        $("#phone_scare").append(phone_scare);
                                                    }
                                                }
                                            }
                                        }
                                });
                                
                                var winWidth = window.innerWidth;
                                if(SC.page.products.length>0){
                                    keyone = Math.ceil(SC.page.products.length/7);
                                    for (var j=keyone; j <= 4; j++) {
                                       $("#circle"+j).hide(); 
                                    }
                                    if(winWidth > 768)
                                        $("#alsoview").show();
                                }else{
                                    $("#alsoview").hide();
                                }
                            }
                        }]);
                     
                    };
                    return {
                        render: render,
                        add: function(itemId, price) {
                            cart.push({Artikel: itemId, price: price, Menge: 1});
                            render();
                        },
                        remove: function(itemId) {
                            cart = cart.filter(function(e) {
                              return e.item !== itemId;
                            });
                            render();
                        } 
                    };
                    }());
                    Cart.render();
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
                        <h2>РЕКОМЕНДУЕМЫЕ ТОВАРЫ</h2>
                    </div>
                    <div class="flash-sale">
                        <ul class="row" id="phone_scare"></ul>
                    </div>  
                </div>
            </div>
        </div>
    </section>
</div>