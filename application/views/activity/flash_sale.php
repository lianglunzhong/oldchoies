<link type="text/css" rel="stylesheet" href="/css/quickview.css" media="all" />
<style type="text/css">
.dwrapper{ background-color: #fff;box-shadow: 0 0 8px #5e5e5e;left: 50%; margin: 100px auto 0 -380px;padding: 20px 10px 50px;position: absolute;z-index: 1001;width:720px;position: absolute;top: 181px;}

#jr{ cursor:pointer; font-size:12px; font-weight:bold; color:#F00} 
.jrgd{height:220px; overflow:hidden; }
.pro_left{ width:300px; overflow:visible ;position:relative; z-index:10;}
.pro_left .myImages{ width:300px; height:400px; border:1px solid #ccc;}

.pro_right{ width:380px;margin-top:20px;}
.pro_right dd {border-bottom:none;margin: 0;padding: 0 ;}
.pro_right dd h3{ font-size:18px; font-weight:normal; margin-bottom:16px;}
.pro_right dd .price{ font-weight:bold; font-size:12px; margin-bottom:3px;}
.pro_right dd.info p span{  margin:0 8px 0 0; height:12px; display:inline-block; line-height:12px; border:none; }
.pro_right dd.last{ border-bottom:0 none; margin:0; padding:0;}
.pro_right dd .reviews{ margin:0 2px;}
.pro_right dd .size{ margin:20px 0 0;}
.pro_right dd .selected_box{ margin:0 0 10px;width:150px;}

.pro_right dd .color,.pro_right dd .submit1{ margin:10px 0 10px 0;}
.btn40_16_red{ height:40px; line-height:40px; display:inline-block; padding:0 26px; *padding:0 13px; color:#fff; font-size:16px; font-weight:bold; background-color:#d8271c; text-transform:uppercase; cursor:pointer;}
.btn40_1{ height:38px; line-height:38px; color:#232121; padding:0 10px; vertical-align:middle; cursor:pointer;}
#action-form .btn_size_select, #action-form .btn_size_normal:hover {border: 1px solid #d8271c;color: #838383;}
#action-form .btn_size_normal { background: none repeat scroll 0 0 #fff;height: 27px;margin-bottom: 10px;min-width: 62px;}
#action-form input {background: none repeat scroll 0 0 #f4f4f4;border: 1px solid #dbdbdb;cursor: pointer;height: 22px;padding: 0 5px;}
#action-form .btn11 {background-color: #d8271c;color: #fff;cursor: pointer;display: inline-block;font-size: 16px;font-weight: bold;height: 45px;line-height: 40px;padding: 0 17px;text-transform: uppercase;width: 200px;}
#select_size{font-weight:bold;}
#action-form {border: medium none;margin-top: 10px;}
.saletime1{ position:static; background:none; font-size:14px; text-align:center; margin:0 5px 15px; height:auto; line-height:18px; color:#333333;font-weight:bold;padding:15px 0;}
.opacity {background: none repeat scroll 0 0 #000;height: 100%;left: 0;opacity: 0.5;position: fixed;top: 0;width: 100%;z-index: 1000;}
.reviews a:hover{text-decoration: none;}
.newin_banner .con {position: absolute;z-index: 1;top: 155px;left: 170px;width: 800px;}
.newin_banner .con li {float: left;margin: 0px 60px 20px 0px;border: 1px solid #CCC;width: 85px;height: 30px;line-height: 30px;text-align: center;}
</style>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  Flash Sale</div>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <section>
            <p><a href="<?php echo $banner['image_link']; ?>"><img src="/simages/<?php echo $banner['image_src']; ?>" width="1024" /></a></p>
            <?php
            if(!empty($weekly))
            {
            ?>
            <!-- flash_sale_prolist -->
            <article class="cate-sales flash_sale_prolist">
                <ul class="fix">
                <?php
                foreach ($weekly as $key => $w)
                {
                    $product = Product::instance($w['product_id']);
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
                    <li>
                        <div class="JS_shows_btn1">
                            <a target="_blank" href="<?php echo $link; ?>"><img src="<?php echo Image::link($product->cover_image(), 2); ?>" width="300" height="400"/></a>
                            <?php
                            if(isset($attributes['Size']))
                            {
                                $count_attr = count($attributes['Size']);
                            ?>
                            <form action="#" method="post" class="JS_shows1 show2 hide">
                                <div class="size">
                                <?php
                                if($count_attr == 1 AND strtolower($attributes['Size'][0]) == 'one size')
                                {
                                    ?>
                                    <span class="onesize-detail fix">
                                    <?php 
                                    $brief = $product->get('brief');
                                    $brief = str_replace(',', ', ', $brief);
                                    echo $brief; 
                                    ?>
                                    </span>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <p>Size:</p>
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
                            <div class="JS_shows1 showscon hide"></div>
                        </div>  
                        <p class="price"><?php echo Site::instance()->price($price, 'code_view'); ?> <span>(<?php echo $off; ?>% Off)</span></p>
                        <a target="_blank" href="<?php echo $link; ?>" class="name" title="<?php echo $product->get('name'); ?>"><?php echo $product->get('name'); ?></a>
                        <div class="reviews">
                        <?php
                        if(isset($review_statistics[$w['product_id']]))
                        {
                            $review = $review_statistics[$w['product_id']];
                            $integer = floor($review['rating']);
                            $decimal = $review['rating'] - $integer;
                        ?>
                        <a target="_blank" href="<?php echo $link; ?>#review_list">
                            <?php
                            for($r = 1;$r <= $integer;$r ++)
                            {
                            ?>
                                <i class="fa fa-star"></i>
                            <?php
                            }
                            if($decimal > 0)
                            {
                            ?>
                                <i class="fa fa-star-half-full"></i>
                            <?php
                            }
                            ?>
                            (<?php echo $review['quantity']; ?>)
                            </a>
                        <?php
                        }
                        ?>
                        </div>
                        <?php
                        if($count_attr == 1)
                        {
                            $choose_size = $attributes['Size'][0];
                            ?>
                            <a class="btn add_to_bag" href="javascript:;" attr-id="<?php echo $w['product_id']; ?>" attr-size="<?php echo $choose_size; ?>">ADD TO BAG</a>
                            <?php
                        }
                        else
                        {
                            ?>
                            <a class="btn btn1 JS_popwinbtn1 quick_view" id="<?php echo $w['product_id']; ?>" attr-key="<?php echo $key; ?>" href="javascript:;">CHOOSE SIZE</a>
                            <?php
                        }
                        ?>
                        <div class="saletime">
                            <div class="JS_daoend<?php echo $key; ?> hide">Time Over!</div>
                            <div class="JS_dao<?php echo $key; ?>">Sale Ends in: <strong class="JS_RemainD<?php echo $key; ?>"></strong>d <strong class="JS_RemainH<?php echo $key; ?>"></strong>h <strong class="JS_RemainM<?php echo $key; ?>"></strong>m <strong class="JS_RemainS<?php echo $key; ?>"></strong>s</div>
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
	          	
	            <div class="newin_banner mt15">
                    <!--<a target="_blank" href="<?php echo LANGPATH; ?>/daily-new/">
	                    <img src="/images/activity/new_in.jpg" width="1020" />
	                </a>	-->
                <a href="<?php echo $index_banners[1]['link']; ?>" <?php if(strpos($index_banners[1]['link'], 'http') !== False) echo 'target="_blank"'; ?>>
                    <img src="/uploads/1/files/<?php echo $index_banners[1]['image']; ?>" alt="<?php echo $index_banners[0]['alt']; ?>" title="<?php echo $index_banners[1]['title']; ?>" width="1020"  />
                </a>
	            </div>

                <div class="tab-bottom">
                    <div class="tab_menu">
                        <ul>
                            <li class="selected">USD1.9</li>
                            <li>USD9.9</li>
                            <li>USD13.9</li>
                            <li>USD16.9</li>
                            <li>USD19.9</li>
                            <li>USD29.9</li>
                        </ul>
                    </div>
                    <div class="tab_box"> 
                    <?php
                    $key = 0;
                    foreach($usdsArr as $usd => $products)
                    {
                        $key ++;
                    ?>
                        <div class="v_show" <?php if($key > 1) echo 'style="display:none"'; ?>>
                            <div class="v_content">
                                <div class="v_content_list">
                                    <ul>
                                    <?php
                                    foreach($products as $p)
                                    {
                                        $product = Product::instance($p['id']);
                                    ?>
                                        <li>
                                            <a target="_blank" href="<?php echo $product->permalink(); ?>"><img src="<?php echo Image::link($product->cover_image(), 7); ?>" alt="" /></a>
                                            <span><?php echo Site::instance()->price($product->price(), 'code_view'); ?></span>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <a target="_blank" href="/<?php echo $usd; ?>" style="color:#ff0000;text-decoration:underline;font-weight:bold;text-align:center;font-size:18px;padding:0 0 15px 0;display:block;" ><i>View More Deals</i></a> 
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    </div>
                </div>
            </article>

            <?php
            }
            ?>
            
        </section>
    </section>
</section>

<script type="text/javascript" src="/js/catalog.js"></script>
<script type="text/javascript" src="/js/catalog.loadthumb.js"></script>
<div class="JS_popwincon1 dwrapper hide">
    <a class="JS_close2 close_btn3"></a>
    <div class="pro_left fll">
        <div id="myImagesSlideBox" class="fix">
            <div class="myImages fll">
                <div id="myImgsLink" class="JS_zoom">
                    <img src="#" id="picture" class="myImgs" big="#" width="300" />
                </div>
                <?php
                for ($i = 0;$i <= $key;$i ++)
                {
                ?>
                    <div class="saletime1" id="saletime<?php echo $i; ?>" style="display:none;">
                       <div class="JS_daoend<?php echo $i; ?>" style="display:none;">Time Over!</div>
                       <div class="JS_dao<?php echo $i; ?>">Sale Ends in:<span style="color:#d8261a;"> <strong class="JS_RemainD<?php echo $i; ?>"></strong>d <strong class="JS_RemainH<?php echo $i; ?>"></strong>h <strong class="JS_RemainM<?php echo $i; ?>"></strong>m <strong class="JS_RemainS<?php echo $i; ?>"></strong>s</span></div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="pro_right flr ml35">
        <dl>
            <dd>
              <h3 id="product_name">Choies Design Limited Fan Fare Floral Print</h3>
              <div class="fix">
              <p style="padding-bottom:12px;color:#999;">
                <span style="margin-right:15px;color:#000;" id="stock">In Stock</span>
                <span style="margin-right:15px;color:#000;" id="outstock" class="hide">Out Of Stock</span>
                Item# : <span id="product_sku" style="margin-right:15px;"></span>
                <span id="jr"><a href="#" target="_blank" id="product_link">View Full details</a></span>
                </p>
                </div>
            </dd>
            <dd class="fix info jiage" >
              <div class="fll font11 ttr">
                <p class="price">
                    <span style="text-decoration:line-through" id="product_s_price"></span>
                    <span class="red" style="font-size:24px;" id="product_price"></span>
                    <i class="red" id="product_rate"></i></p>
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
                    <form action="#" method="post" id="formAdd">
                        <input id="product_id" type="hidden" name="id" value="8468"/>
                        <input id="product_items" type="hidden" name="items[]" value="8468"/>
                        <input id="product_type" type="hidden" name="type" value="3"/>
                        <div class="btn_size"></div>
                        <div class="btn_color"></div>
                        <div class="btn_type"></div>
                        <div class="total">
                            <input type="submit" style="font-size: 18px;" class="btn40_16_red" id="addCart" value="ADD TO BAG">
                        </div> 
                    </form>
                </div>
                <ul class="JS_tab detail_tab detail_tab2 fix">
                    <li class="ss1 current" style="width: 90px;margin: 0 0 -1px 0;">DETAILS</li>
                    <p><b></b></p>
                </ul>
                <div class="JS_tabcon detail_tabcon detail_tabcon2">
                    <div class="bd" id="tab-brief"></div>
                </div>
            </dd>
        </dl>
    </div>
</div>
<script>
$(function(){
  $("#jr").click(function(){
   if($(".jr").hasClass("jrgd")){
   $(".jr").removeClass("jrgd");
   $('#jr').text("hide details");
   }else{
   $(".jr").addClass("jrgd");
   $('#jr').text("View Full details");
  } 
  }) 
});
$(function(){
    var $div_li =$("div.tab_menu ul li");
    $div_li.hover(function(){
        $(this).addClass("selected")             
               .siblings().removeClass("selected");   
        var index =  $div_li.index(this);   
        $("div.tab_box > div")         
                .eq(index).show()    
                .siblings().hide();  
    }) 
})
$(".JS_close2,.JS_filter1").live("click",function(){
    $(".JS_filter1").remove();
    $('.JS_popwincon1').fadeOut(160);
    return false;
})
$(function(){
    $('.detail_tab2 li').mouseover(function(){
        var liindex = $('.detail_tab2 li').index(this);
        $(this).addClass('current').siblings().removeClass('current');
        $('.detail_tabcon2 div.bd').eq(liindex).fadeIn(150).siblings('div.bd').stop().hide();
        var liWidth = $('.detail_tab2 li').width();
        $('.last .detail_tab2 p').stop(false,true).animate({'left' : liindex * liWidth + 'px'},300);
    });
    });
</script>

<script type="text/javascript">
    $(function(){
        $(".quick_view").click(function(){
            var key = $(this).attr('attr-key');
            $(".saletime1").hide();
            $("#saletime" + key).show();
        })
        $(".btn_size input").live("click",function(){
            var qty = $(this).attr('title');
            if(qty)
                $("#only_left").html('Only '+qty+' Left!');
        });
        $("#formAdd").submit(function(){
            $.post(
                '/cart/ajax_add',
                {
                    id: $('#product_id').val(),
                    type: $('#product_type').val(),
                    size: $('.s-size').val(),
                    color: $('.s-color').val(),
                    attrtype: $('.s-type').val(),
                    quantity: $('#count_1').val()
                },
                function(product)
                {
                    var count = 0;
                    var cart_view = '';
                    var cart_view1 = '';
                    var key = 0;
                    for(var p in product)
                    {
                        if(key == 0)
                        {
                            cart_view = '\
                            <a href="'+product[p]['link']+'"><img src="'+product[p]['image']+'" alt="'+product[p]['name']+'" /></a>\
                                <div class="right">\
                                    <a class="name" href="'+product[p]['link']+'">'+product[p]['name']+'</a>\
                                    <p>Item# : '+product[p]['sku']+'</p>\
                                    <p>'+product[p]['price']+'</p>\
                                    <p>'+product[p]['attributes']+'</p>\
                                    <p>Quantity: '+product[p]['quantity']+'</p>\
                                </div>\
                            <div class="fix"></div>\
                            ';
                        }
                    }
                    if($(document).scrollTop() > 120)
                    {
                        $('#mybag2 .currentbag .bag_items li').html(cart_view);
                        $('#mybag2 .currentbag').fadeIn(10).delay(3000).fadeOut(10);
                    }
                    else
                    {
                        $('#mybag1 .currentbag .bag_items li').html(cart_view);
                        $('#mybag1 .currentbag').fadeIn(10).delay(3000).fadeOut(10);
                    }
                    ajax_cart();
                },
                'json'
            );
            $(".JS_filter1").remove();
            $('.JS_popwincon1').fadeOut(160).appendTo('#tab2');
            return false;
        })

        $(".add_to_bag").click(function(){
            id = $(this).attr('attr-id');
            size = $(this).attr('attr-size')
            $.post(
                '/cart/ajax_add',
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
                    var count = 0;
                    var cart_view = '';
                    var cart_view1 = '';
                    var key = 0;
                    for(var p in product)
                    {
                        if(key == 0)
                        {
                            cart_view = '\
                            <a href="'+product[p]['link']+'"><img src="'+product[p]['image']+'" alt="'+product[p]['name']+'" /></a>\
                                <div class="right">\
                                    <a class="name" href="'+product[p]['link']+'">'+product[p]['name']+'</a>\
                                    <p>Item# : '+product[p]['sku']+'</p>\
                                    <p>'+product[p]['price']+'</p>\
                                    <p>'+product[p]['attributes']+'</p>\
                                    <p>Quantity: '+product[p]['quantity']+'</p>\
                                </div>\
                            <div class="fix"></div>\
                            ';
                        }
                    }
                    if($(document).scrollTop() > 120)
                    {
                        $('#mybag2 .currentbag .bag_items li').html(cart_view);
                        $('#mybag2 .currentbag').fadeIn(10).delay(3000).fadeOut(10);
                    }
                    else
                    {
                        $('#mybag1 .currentbag .bag_items li').html(cart_view);
                        $('#mybag1 .currentbag').fadeIn(10).delay(3000).fadeOut(10);
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

<script>
$(function(){
    $("#catalog_sort li").click(function(){
        var val = $(this).attr('title');
        if(val)
        {
            $("#flash_week li").hide();
            $("#flash_week ."+val).show();
        }
        else
            $("#flash_week li").show();
        
    })
})
</script>