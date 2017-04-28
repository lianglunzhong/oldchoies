   <style>
   #personal-recs{
   overflow:hidden;}
span.scarab-item { 
                            display:inline; 
                            float:left; 
                            margin:10px 0; 
                            text-align:center;
                            width:18.5%;
                            margin-left:1%;
                            border:none;} 
   span.scarab-item a { 
                                display:block;  
                                overflow:hidden; 
                            }
   span.scarab-item img {
                                max-width:100%;  
                            }
    span.scarab-item span { 
                                color:#ff0000; 
                            }
.scarab-prev, .scarab-next{
                        vertical-align: middle;
                        float:left;
                        line-height: 265px;
                        cursor: pointer;
                        font-weight: bold;
                        font-size: 16px;
                        display: inline-block;
                        width: 1%;
                        text-align: center;
                        @media(min-width:768px)and(max-width:992px){
                            line-height:180px;
                        }
                    }

span.scarab-item a {

width: 90%;
}
                    </style>
        <section id="main">
            <!-- crumbs -->
            <div class="container">
                <div class="crumbs">
                    <div>
                        <a href="<?php echo LANGPATH; ?>/">ДОМ</a> > FLASH SALE
                    </div>
                </div>
			</div>
                <!-- -->
                
            
            <!-- -->
          

            <!-- main begin -->
            <section class="container">
            <?php if($banner['image_src']){ ?>
                <p style="width:100%;margin-bottom:0;">
                    <img src="<?php echo STATICURL; ?>/simages/<?php echo $banner['image_src']; ?>"  />
                </p>
            <?php } ?>
            <?php
            // if(!empty($weekly))
            // {
            ?>
                <!-- flash-sale-prolist -->
                <article class="cate-sales flash-sale-prolist">
                    <ul>
                <?php
                foreach ($weekly as $key => $w)
                {
                    $product = Product::instance($w['product_id'], LANGUAGE);
                    if(!$product->get('id'))
                        continue;
                    $link = $product->permalink();
                    $orig_price = $product->get('price');
                    $price = $product->price();
                    $off = round(($orig_price - $price) / $orig_price, 2) * 100;
                    
                    $c_class = str_replace(array(' ', '/', '&'), array('-', '-', '-'), $w['catalog']);
                    $end_day = strtotime(date('Y-m-d', $w['expired']) . ' - 1 month');
                    $attributes = $product->get('attributes');
                ?>
                        <li class="prolist-li">
                            <div class="JS_shows_btn1">
                                <a target="_blank" href="<?php echo $link; ?>">
                                    <img src="<?php echo Image::link($product->cover_image(), 2); ?>" />
                                </a>
                            <?php
                            if(isset($attributes['Size']))
                            {
                                $count_attr = count($attributes['Size']);
                            ?>
                                <form action="#" method="post" class="JS_shows1 hide hidden-xs">
                                    <div class="size">
                                <?php
                                if($count_attr == 1 AND strtolower($attributes['Size'][0]) == 'one size')
                                {
                                    ?>
                                        <span class="onesize-detail">                  
                                        <?php 
                                    $brief = $product->get('brief');
                                    $brief = str_replace(array(',', 'Size'), array(', ', 'Размеры'), $brief);
                                    echo $brief; 
                                    ?></span>
                            <?php
                                }
                                else
                                {
                                    ?>
                                    <p>Размеры:</p>
                                    <div class="size_list fix">
                                    <?php
                                    foreach($attributes['Size'] as $size)
                                    {
                                        $eur = strpos($size, 'EUR');
                                        if ($eur !== FALSE)
                                        {
                                            $size = substr($size, $eur + 3, 2);
                                        }
                                    ?>
                                        <span><?php echo $size; ?></span>
                                    <?php
                                    }
                                    ?>
                                    </div>
                                    <?php
                                }
                                ?>
                                    </div>
                                </form>
                        <?php
                            }
                            ?>
                                <div class="JS_shows1 showscon hide hidden-xs"></div>
                            </div>
                            <p class="price"><?php echo Site::instance()->price($price, 'code_view'); ?><span><?php if($off>0){ echo '('.$off.'% Off)';
                            } 
                            ?></span>
                            </p>
                            <a target="_blank" href="<?php echo $link; ?>" class="name" title="<?php echo $product->get('name'); ?>"><?php echo $product->get('name'); ?></a>
                        <?php
                        if($count_attr == 1)
                        {
                            $choose_size = $attributes['Size'][0];
                            ?>
                            <a class="btn add_to_bag btn-primary btn-sm" href="javascript:;" attr-id="<?php echo $w['product_id']; ?>" attr-size="<?php echo $choose_size; ?>">Добавить в корзину</a>
                            <?php
                        }
                        else
                        {
                        ?>  
                            <a class="btn btn-primary btn-sm  quick_view hidden-xs" id="<?php echo $w['product_id']; ?>" data-reveal-id="myModal" attr-key="<?php echo $key; ?>" >Размеры</a>
                            <a href="<?php echo $link;  ?>" class="visible-xs-inline-block btn btn-primary btn-sm hidden-sm hidden-md hidden-lg">Размеры</a>
                            <?php
                        }
                        ?>                          
                            
                        <div class="saletime">
                            <div class="JS_daoend<?php echo $key; ?> hide" style="display: none;">Время Кончилось!</div>
                            <div class="JS_dao<?php echo $key; ?>">Распродажа закончится: <strong class="JS_RemainD<?php echo $key; ?>"></strong>d <strong class="JS_RemainH<?php echo $key; ?>"></strong>h <strong class="JS_RemainM<?php echo $key; ?>"></strong>m <strong class="JS_RemainS<?php echo $key; ?>"></strong>s</div>
                        </div>
                        
                    </li>
                    <script type="text/javascript">
                        /* time left */
                        function GetRTime<?php echo $key; ?>(){
                            var startTime = new Date();
                            startTime.setFullYear(<?php echo date('Y, m, d', $end_day); ?>);
                            startTime.setHours(9);
                            startTime.setMinutes(59);
                            startTime.setSeconds(59);
                            startTime.setMilliseconds(999);
                        var EndTime=startTime.getTime();
                            var NowTime = new Date();
                            var nMS = EndTime - NowTime.getTime();
                        
                            var nD = Math.floor(nMS/(1000 * 60 * 60 * 24));
                            var nH = Math.floor(nMS/(1000*60*60)) % 24;
                            var nM = Math.floor(nMS/(1000*60)) % 60;
                            var nS = Math.floor(nMS/1000) % 60;
                            if(nD<=9) nD = "0"+nD;
                            if(nH<=9) nH = "0"+nH;
                            if(nM<=9) nM = "0"+nM;
                            if(nS<=9) nS = "0"+nS;
                            if (nMS < 0){
                                $(".JS_dao<?php echo $key; ?>").hide();
                                $(".JS_daoend<?php echo $key; ?>").show();
                            }else{
                                $(".JS_dao<?php echo $key; ?>").show();
                                $(".JS_daoend<?php echo $key; ?>").hide();
                                $(".JS_RemainD<?php echo $key; ?>").text(nD);
                                $(".JS_RemainH<?php echo $key; ?>").text(nH);
                                $(".JS_RemainM<?php echo $key; ?>").text(nM);
                                $(".JS_RemainS<?php echo $key; ?>").text(nS); 
                            }
                        }
                        
                        $(document).ready(function () {
                            var timer_rt = window.setInterval("GetRTime<?php echo $key; ?>()", 1000);
                        });
                    </script>
                <?php
                }
                ?>
                </ul>


                <div class="w-tit hidden-xs">
                <h2 style="background-color:#fafafa;">Рекомендую для вас</h2>
                </div>
                <!-- The container where the recommendations are rendered -->
                <div class="box-dibu1 hidden-xs">
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
                          <li data-scarabitem="{{= p.id }}" style="display: inline-block" class="rec-item" id="em{{= p.id }}">
                             <a href="{{=p.plink}}" id="em{{= p.id }}link">
                              <img src="{{=p.image}}" class="rec-image">
                            </a>
                            <p class="price"><b id="em{{= p.id }}price">${{=p.price}}</b></p>
                          </li>
                            {{ if(i==6 || i==13 || i==20 || i==27){ }}
                            </ul></div>
                            {{ } }}
                        {{ } }} 
                    ]]>
                    </script>
                <div id="personal-recs"><div class="scarab-itemlist"></div></div>
                    <script type="text/javascript">
                    // Request personalized recommendations.
                    ScarabQueue.push(['recommend', {
                    logic: 'PERSONAL',
                    containerId: 'personal-recs',
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
                                    url: "/site/emarsysdata?page=flash",
                                    dataType: "json",
                                    data:"sku="+psku+"&lang=<?php echo LANGUAGE; ?>",
                                    success: function(data){
                                            pc_scare = '<div class="scarab-prev">◀</div>';
                                        for(var o in data){
                                            pc_scare += '<span class="scarab-item" data-scarabitem="' + o + '"><a href="' + data[o]['link'] + '"><img src="' + data[o]['cover_image'] + '">'+data[o]['name']+'</a></span>';

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
                                        pc_scare +='<div class="scarab-next">▶</div></div></div>';
                                        $("#personal-recs .scarab-itemlist").children().hide();
                                        $("#personal-recs .scarab-itemlist").append(pc_scare);
                                    
                                    }
                            });
                            
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
                    </script> 
                </article>
                <!--<div class="flash-sale-filter hidden-xs">
                    <img src="/assets/images/flash-sale/flash-sale-bottom.jpg" />
                    <ul class="con">
                        <li class="on"><a href="">23 Dec.</a>
                        </li>
                        <li><a href="">22 Dec. </a>
                        </li>
                        <li><a href="">21 Dec. </a>
                        </li>
                        <li><a href="">20 Dec. </a>
                        </li>
                        <li><a href="">19 Dec. </a>
                        </li>
                        <li><a href="">18 Dec. </a>
                        </li>
                        <li><a href="">17 Dec. </a>
                        </li>
                        <li><a href="">16 Dec. </a>
                        </li>
                        <li><a href="">15 Dec. </a>
                        </li>
                        <li><a href="">14 Dec. </a>
                        </li>
                    </ul>
                </div>-->
           <?php
            // }
            // ?>   

            </section>

        </section>
        
        
        <script language="JavaScript">
            $(function() {
                $("#letter_form").submit(function() {
                    var email = $('#letter_text').val();
                    if (!email) {
                        return false;
                    }
                    $.post(
                        '/newsletter/ajax_add', {
                            email: email
                        },
                        function(data) {
                            $("#letter_message").html(data['message']);
                            if (data['success'] == 0) {
                                $('#letter_message').fadeIn(10).delay(3000).fadeOut(10);
                            } else {
                                $("#letter").css('display', 'none');
                                $("#letter_message").css('display', 'block');
                            }
                        },
                        'json'
                    );
                    return false;
                })
            })
        </script>

        <div id="gotop" class="hide ">
            <a href="#" class="xs-mobile-top"></a>
        </div>
        
<script type="text/javascript" src="/assets/js/catalog.js"></script>
<!-- JS-popwincon1 -->
<div id="myModal" class="reveal-modal xlarge">
        <a class="close-reveal-modal close-btn3"></a>
    <div>
        <div class="pro-left">
            <div id="myImagesSlideBox">
                <div class="myImages">
                    <a href="#" id="myImgsLink" class="JS-zoom">
                        <img alt="" src="" id="picture" class="myImgs" big="#">
                    </a>
                </div>
                <div id="scrollable" class="flr">
                    <a href="#" class="b-prev prev3"></a>
                    <a href="#" class="b-next next3"></a>
                    <div class="items">
                        <div class="scrollableDiv">
                            
                        </div>
                    </div>
                </div>
                <div style="font-size: 14px; text-align: center;font-weight: bold;">
                <?php
                for ($i = 0;$i <= count($weekly);$i ++)
                {
                ?>
                    <div class="saletime1" id="saletime<?php echo $i; ?>" style="display:none;">
                        <div class="JS_daoend<?php echo $i; ?> hide" style="display: none;">Время Кончилось!</div>
                        <div class="JS_dao<?php echo $i; ?>">Распродажа закончится:<span style="color:#d8261a;"> <strong class="JS_RemainD<?php echo $i; ?>"></strong>d <strong class="JS_RemainH<?php echo $i; ?>"></strong>h <strong class="JS_RemainM<?php echo $i; ?>"></strong>m <strong class="JS_RemainS<?php echo $i; ?>"></strong>s</span>
                        </div>
                    </div>
                <?php
                }
                ?>
                </div>
            </div>
        </div>
        <div class="pro-right" style="width:400px;">
            <dl>
                <dd>
                    <h3 id="product_name"></h3>
                    <div class="pro-stock">
                        <span class="stock-sp" id="stock">В наличии</span>
                        <span class="stock-sp" style="display: none;" id="outstock" class="hide">Нет в наличии</span>
                        Товар# : <span id="product_sku"></span>
                        <strong>
                            <a href="" id="product_link">Подробнее</a>
                        </strong>
                    </div>
                </dd>
                <dd>
                    <p class="price">
                        <del id="product_s_price"></del>
                        <span class="red" id="product_price"></span>
                        <i class="red" id="product_rate_show" style="display:none;">
                            <i id="product_rate"></i>% off
                        </i>
                    </p>
                </dd>
                <dd class="last">
                    <div class="reviews">
                        <span id="review_data"></span>
                        <span id="review_count"></span>
                    </div>
                    <div id="action_form">
                        <form action="#" method="post" id="formAdd">
                            <input id="product_id" type="hidden" name="id" value="8468"/>
                            <input id="product_items" type="hidden" name="items[]" value="8468"/>
                            <input id="product_type" type="hidden" name="type" value="3"/>
                            <input id="language" type="hidden" name="language" value="<?php echo LANGUAGE; ?>"/>
                            <div class="btn-size" style=" margin-top:20px;">
                                <input type="hidden" name="attributes[Size]" value="" class="s-size" />
                                <div class="selected-box">
                                    <p class="fll">
                                        <span id="select_size">Выберите размер:</span>
                                        <span id="size_span" style="display:none;">Pазмер: <span id="size_show"></span></span>
                                    </p>
                                </div>
                                <div id="btn_size"></div>
                                <div id="one_size" style="display:none;">
                                    <div class="clearfix">
                                        <ul class="size-list">
                                            <li class="btn-size-normal on-border JS-show" id="one size" data-attr="one size">
                                                <span>только один размер</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-color" style="display:none;">
                                <input type="hidden" name="attributes[Color]" value="" class="s-color" /><div id="select_color" class="mb10">Select Color:</div>
                                <div id="btn_color"></div>
                            </div>
                            <div class="btn-type" style="display:none;">
                                <input type="hidden" name="attributes[Type]" value="" class="s-type" /><div id="select_type" class="mb10">Select Type:</div>
                                <div id="btn_type"></div>
                            </div>
                            <div class="total">
                                <input class="btn btn-primary btn-lg" id="addCart" value="ДОБАВИТЬ В КОРЗИНУ" type="submit">
                                <button class="btn btn-primary btn-lg" disabled="disabled" id="outButton" style="display:none;">OUT OF STOCK</button>
                                <a href="#" class="wishlist" id="addWishList">Избранное (<span id="wishlists"></span>Add)</a>
                            </div>
                        </form>
                    </div>
                    <ul class="JS-tab-view detail-tab two-bor" style="margin-top:30px;">
                        <li class="dt-s1 current">Детали</li>
                        <li class="dt-s1">модель</li>
                        <li class="dt-s1">Доставка</li>
                        <p style="left: 0px;"><b></b></p>
                    </ul>
                    <div class="JS-tabcon-view detail-tabcon">
                        <div class="bd" id="tab-detail">
                            <br>
                            <br>
                            <p>S:Shoulder:37cm,Bust:98cm,Length:62cm,Sleeve Length:55cm
                                <br> M:Shoulder:38cm,Bust:102cm,Length:63cm,Sleeve Length:56cm
                                <br> L:Shoulder:39cm,Bust:106cm,Length:64cm,Sleeve Length:57cm
                                <br>
                            </p>
                            <br>
                            <br>
                            <p>Non-stretchable Material
                                <br> Cotton
                                <br> Wash according to instructions on care label.</p>
                        </div>
                        <div class="bd hide">
          <p style="color:#F00;">Время приема= время обработки（3-5 рабочих дней） + время доставки</p>
                <h4>Доставка:</h4>
                <p>(1)  бесплатная доставка по всему миру (10-15 рабочих дней)</p>
                <p style="color:#F00; padding-left:18px;">Нет минимальной суммы покупки</p>
                <p>(2)  <?php echo Site::instance()->price(15, 'code_view'); ?> экспресс-доставка(4-7 рабочих дней)</p>
                <p style="padding-left:18px;">Проверить детали в <a class="a_red" href="<?php echo LANGPATH; ?>/shipping-delivery" title="Отправка и доставка">Отправка и доставка</a></p>
                <h4>Политики Возврата:</h4>
                <p>Не устраивает ваш заказ, вы можете связаться с нами и вернуть его в течение 60 дней.</p>
                <p>Если нет проблем качества с одеждой, мы не осуществляем возврат и обмен <span class="red">купальников и пижамы</span>. Проверить детали в <a class="a_red" href="<?php echo LANGPATH; ?>/returns-exchange" title="Политики Возврата">Политики Возврата</a>.</p>
                <h4>Дополнительное Внимание:</h4>
                <p>Заказы может быть облагаться импортными пошлинами, если вы хотите избежать дополнительных налогов в местный обычай,пожалуйста,свяжитесь с нами.Мы будем использовать почту Hong Kong.</p>
                        </div>
                        <div class="bd hide">
                            <div class="ml10 mt10">
                                <a href="#" onclick="Comm100API.open_chat_window(event, 311);">
                                    <img name="psSMPPimage" src="<?php echo BASEURL ;?>/images/livechat_online1.gif" border="0">LiveChat
                                </a>
                            </div>
                            <div class="ml10 mt10">
                                <a href="mailto:service@choies.com">
                                    <img src="/assets/images/livemessage.png" alt="Leave Message"> Laisser un message
                                </a>
                            </div>
                            <div class="ml10 mt10">
                                <a href="<?php echo LANGPATH; ?>/faqs" target="_blank">
                                    <img src="/assets/images/faq.png" alt="FAQ"> FAQ
                                </a>
                            </div>
                        </div>
                    </div>
                </dd>
            </dl>
        </div>
    </div>
</div>

<div class="JS_popwincon1 flash-sale-dwrapper hidden-xs hide">
    <a class="JS_close2 close-btn3"></a>
    <div>
        <div class="pro-left fll">
            <div id="myImagesSlideBox">
                <div class="myImages fll">
                    <a href="" id="myImgsLink">
                        <img src="#" id="picture" class="myImgs" />
                    </a>
                    <?php
                    for ($i = 0;$i <= count($weekly);$i ++)
                    {
                    ?>
                    <div class="saletime1" id="saletime<?php echo $i; ?>" style="display:none;">
                        <div class="JS_daoend<?php echo $i; ?> hide" style="display: none;">Время Кончилось!</div>
                        <div class="JS_dao<?php echo $i; ?>">Распродажа закончится:<span style="color:#d8261a;"> <strong class="JS_RemainD<?php echo $i; ?>"></strong>d <strong class="JS_RemainH<?php echo $i; ?>"></strong>h <strong class="JS_RemainM<?php echo $i; ?>"></strong>m <strong class="JS_RemainS<?php echo $i; ?>"></strong>s</span>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>

            </div>
        </div>
        <div class="pro-right">
            <dl>
                <dd>
                    <h3 id="product_name">Choies Design Limited Fan Fare Floral Print </h3>
                </dd>
                <dd class="info">
                    <div>
            <p style="padding-bottom:12px;color:#999;">
                    <span style="margin-right:15px;color:#000;" id="stock">В наличии</span>
                    <span style="margin-right:15px;color:#000;" id="outstock" class="hide">Нет в наличии</span>
                    Товар# : <span id="product_sku" style="margin-right:15px;"></span>
                    <span id="jr"><a href="#" target="_blank" id="product_link">Подробнее</a></span>
                    </p>
                        <p class="price">
                        <span style="text-decoration:line-through;font-size:12px;" id="product_s_price"></span>
                        <span class="red" style="font-size:24px;" id="product_price"></span><i class="red" id="product_rate"></i>
                        </p>
                    </div>
                </dd>
                <dd class="last">
        <div  class="fix mt10">   
            <span class="fll">
                <span id="review_date"></span>
                <span class="reviews" id="review_count"></span>
            </span>
        </div>
                    <div id="action-form">                               
                    <form id="formAdd" method="post" action="#">
                <input id="product_id" type="hidden" name="id" value="8468"/>
                <input id="product_items" type="hidden" name="items[]" value="8468"/>
                <input id="product_type" type="hidden" name="type" value="3"/>
                    <div class="btn-size mb10"></div>
                    <div class="btn-color"></div>
                    <div class="btn-type"></div>
                                <div class="mb10" id="select-size" class="btn-size"></div>
                                <div class="submit1">
                                    <input type="submit" value="Добавить в корзину" id="addCart" class="btn btn-primary btn-lg">
                                </div>
                            </form>
                        </div>
                        
                        <ul class="JS_tab detail-tab fix">
                            <li class="ss1 current" style="width: 90px;margin: 0 0 -1px 0;">Детали</li>
                            <p><b></b></p>
                        </ul>
                        <div class="JS_tabcon detail-tabcon">
                            <div class="bd" id="tab-brief"></div>
                        </div>
        
                    </div>
        
                </dd>
            </dl>
        </div>
    </div>
</div>

<div id="gotop" class="hide">
    <a href="#" class="xs-mobile-top"></a>
</div>

<script type="text/javascript">
     // JS_shows1
    $(".JS_shows_btn1").hover(function() {
            $(this).find(".JS_shows1").show();
        }, function() {
            $(this).find('.JS_shows1').hide();
        })
        // JS_filter2

    function getScrollTop() {
        var scrollPos;
        if (window.pageYOffset) {
            scrollPos = window.pageYOffset;
        } else if (document.compatMode && document.compatMode != 'BackCompat') {
            scrollPos = document.documentElement.scrollTop;
        } else if (document.body) {
            scrollPos = document.body.scrollTop;
        }
        return scrollPos;
    }
    $(function(){
        $(".quick_view").live("click", function() {
        var id = $(this).attr('id');
        var lang = $(this).attr('attr-lang');
            var key = $(this).attr('attr-key');
            $(".saletime1").hide();
            $("#saletime" + key).show();
        })
    })
     $(".flash-sale-prolist .size-list").css("position", "static");
    $(function() {
            var $div_li = $("div.tab-menu ul li");
            $div_li.hover(function() {
                $(this).addClass("selected")
                    .siblings().removeClass("selected");
                var index = $div_li.index(this);
                $("div.tab-box > div")
                    .eq(index).show()
                    .siblings().hide();
            })
        })
        /* time left */


    $(function() {
        $(".btn-size input").live("click", function() {
            if ($(this).attr('class') != 'btn-size-normal') {
                return false;
            }
            var value = $(this).attr('id');
            $(".s-size").val(value);
            $(this).parent().siblings().removeClass('btn-size-select');
            $(this).parent().addClass('btn-size-select');
            $("#select_size").html('Size: ' + $(this).val());
        })
        $(".add_to_bag").click(function(){
            id = $(this).attr('attr-id');
            size = $(this).attr('attr-size')
            $.post(
                '/cart/ajax_add?lang=<?php echo LANGUAGE; ?>',
                {
                    id: id,
                    type: 3,
                    size: size,
                    color: '',
                    attrtype: '',
                    quantity: 1
                },
                function(product)
                {
                var winWidth = window.innerWidth;
                if(winWidth <= 768){
                    window.location.href="<?php echo LANGPATH;?>/cart/view";
                    return false;
                }
                    if($(document).scrollTop() > 120)
                    {
                      //  $('#mybag2 .currentbag .bag_items li').html(cart_view);
                        $('#mybagli2 .mybag-box').fadeIn(10).delay(3000).fadeOut(10);
                    }
                    else
                    {
                      //  $('#mybag1 .currentbag .bag_items li').html(cart_view);
                        $('#mybagli2 .mybag-box').fadeIn(10).delay(3000).fadeOut(10);
                    }
                    ajax_cart();
                },
                'json'
            );
            $(".JS_filter1").remove();
            $('.JS_popwincon1').fadeOut(160).appendTo('#tab2');
            return false;
        })
    })
</script>
        