<script type="text/javascript" src="/js/product.js"></script>
<link type="text/css" rel="stylesheet" href="/css/quickview.css" media="all" />
<script>
    var page = <?php echo isset($_GET['page']) ? 1 : 0; ?>;
    $(function(){
        if(page)
        {
            window.location.href = '#pagefocus';
        }
    })
</script>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Home</a>  >  Шоу Покупателей</div>
        </div>
        <?php echo message::get(); ?>
    </div>
    <section class="layout fix">
        <h3 class="lookbook_tit">
            <div class="fll">Шоу Покупателей</div>
            <a class="flr red" href="<?php echo LANGPATH; ?>/lookbook">Назад на Лукбук</a>
        </h3>
        <div class="lookbook_details_rows1 fix">
            <div class="left fll"><img src="<?php echo 'http://img.choies.com/simages/' . $c_images['image']; ?>" width="422" alt="" /></div>
            <div class="right fll">
                <div class="top">
                    <div class="fix">
                        <?php
                        $product = Product::instance($c_images['product_id'], LANGUAGE);
                        $link = $product->permalink();
                        ?>
                        <div class="fll top_left"><a href="<?php echo $link; ?>"><img src="<?php echo Image::link($product->cover_image(), 1); ?>" width="260" alt="" /></a></div>
                        <div class="fll con">
                            <h4><a href="<?php echo $link; ?>"><?php echo $product->get('name'); ?></a></h4>
                            <h2><?php echo Site::instance()->price($product->price(), 'code_view'); ?></h2>
                            <p><a href="<?php echo $link; ?>" id="<?php echo $c_images['product_id']; ?>" class="btn40_16_black btn mb20 quick_view JS_shows1 hide">КУПИТЬ СЕЙЧАС</a></p>
                            <?php
                            if ($c_images['type'] != 1 && $c_images['link_sku'] && strlen($c_images['link_sku']) > 0)
                            {
                                ?>
                                <p><a class="btn40_16_red btn mb50 JS_popwinbtn4">Получить этот лук</a></p>
                                <?php
                            }
                            ?>
                            <div class="lookbook_share font14">
                                <span>Поделиться:</span>
                                <span class="sns fix">
                                    <a rel="nofollow" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($link); ?>" target="_blank" class="sns1"></a>
                                    <a rel="nofollow" href="http://twitter.com/share?url=<?php echo urlencode($link); ?>" target="_blank" class="sns2"></a>
                                    <a rel="nofollow" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($link); ?>&media=<?php echo Image::link($product->cover_image(), 1); ?>&description=<?php $product->get('name'); ?>" target="_blank" class="sns5"></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if ($c_images['type'] != 1 && $c_images['link_sku'] && strlen($c_images['link_sku']) > 0)
                {
                    ?>
                    <div class="bottom">
                        <h2>Этот товар сочетается с</h2>
                        <div class="JS_carousel2 product_carousel">
                            <ul class="fix">
                                <?php
                                $skus = explode(',', $c_images['link_sku']);
                                if (is_array($skus)):
                                    $n = 1;
                                    foreach ($skus as $sku):
                                        $pro_id = Product::get_productId_by_sku(trim($sku));
                                        if (!$pro_id)
                                        {
                                            continue;
                                        }
                                        if ($n > 8)
                                        {
                                            break;
                                        }
                                        $n++;
                                        ?>
                                        <li style="height: 153px;">
                                            <?php
                                            $link_pro = Product::instance($pro_id);
                                            if ($link_pro->get('visibility') != 1)
                                            {
                                                continue;
                                            }
                                            $orig_price = round($link_pro->get('price'), 2);
                                            $price = round($link_pro->price(), 2);
                                            ?>
                                            <a href="<?php echo $link_pro->permalink(); ?>" target="_blank"><img src="<?php echo Image::link($link_pro->cover_image(), 1); ?>" title="<?php echo $link_pro->get('name'); ?>" alt="<?php echo $link_pro->get('name'); ?>" /></a>
                                            <p class="price center">
                                                <?php if ($orig_price > $price)
                                                {
                                                    ?>
                                                    <?php echo Site::instance()->price($price, 'code_view'); ?>
                                                    <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del>
                                                    <?php
                                                }
                                                else
                                                {
                                                    echo Site::instance()->price($link_pro->get('price'), 'code_view');
                                                }
                                                ?>
                                            </p>
                                        </li>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </ul>
                            <span class="prev1 JS_prev2"></span>
                            <span class="next1 JS_next2"></span>
                        </div>
                    </div>
                    <?php
                } 
                ?>
            </div>
        </div>

        <div class="lookbook_details_rows1 fix">
            <div class="left_reviews fll">
                <h3>Отзывы покупателей</h3>
                <ul class="con">
                    <?php
                    if (count($reviews) > 0)
                    {
                        foreach ($reviews as $review)
                        {
                            $firstname = Customer::instance($review['user_id'])->get('firstname');
                            $date = date('d/m/Y', $review['created']);
                            ?>
                            <li>
                                <div class="fix"><strong class="rating_show fll"><span class="rating_value<?php echo $review['star']; ?>">rating</span></strong><span class="time flr"><?php echo $firstname . ' on ' . $date; ?></span></div>
                                <p><?php echo $review['content']; ?></p>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
                <?php echo $pagination; ?>
            </div>
            <div id="pagefocus"></div>
            <div class="right_reviews flr">
                <h3>Отзывы покупателей</h3>
                <!--　login before -->
                <div class="review-form">
                    <?php
                    if ($customer_id = Customer::logged_in())
                    {
                        ?>
                        <form method="post" action="<?php echo LANGPATH; ?>/site/lookbook_review" class="form form2 user_form" id="reviewForm">
                            <input type="hidden" name="type" value="1" />
                            <?php
                            if (count($reviews) == 0)
                            {
                                ?>
                                <b>БУДЬТЕ ПЕРВЫМ, ВЫСКАЖИТЕ СВОЕ МНЕНИЕ</b>
                                <?php
                            }
                            ?>

                            <ul class="mtb10">
                                <li class="fix">
                                    <label class="fll"><span>*</span>Оценка:</label>
                                    <div class="right_box fll">
                                        <span class="rating_wrap fix">
                                            <input class="star" type="radio" name="star" value="1" />
                                            <input class="star" type="radio" name="star" value="2" />
                                            <input class="star" type="radio" name="star" value="3" />
                                            <input class="star" type="radio" name="star" value="4" />
                                            <input class="star" type="radio" name="star" value="5" checked="checked" />
                                        </span>
                                    </div>
                                </li>
                                <li class="fix">
                                    <label><span>*</span>Комментарий:</label>
                                    <div class="right_box"><textarea name="content"></textarea></div>
                                </li>
                                <li class="fix">
                                    <label for="submit">&nbsp;</label>
                                    <input type="hidden" name="lookbook_id" value="<?php echo $c_images['id']; ?>" />
                                    <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
                                    <div class="right_box"><input type="submit" value="Далее" class="view_btn btn26" /></div>
                                </li>
                            </ul>
                        </form>
                        <script>
                            $("#reviewForm").validate({
                                rules: {
                                    star: {
                                        required: true
                                    },
                                    content: {
                                        required: true,
                                        minlength: 5
                                    }
                                },
                                messages: {
                                    star:{
                                        required:"Пожалуйста, выберите оценку."
                                    },
                                    content: {
                                        required: "Пожалуйста, пишите комментария.",
                                        minlength: "Ваш комментарий должен быть не менее 5 символов."
                                    }
                                }
                            });
                        </script>
                        <?php
                    }
                    else
                    {
                        ?>
                        <form action="<?php echo LANGPATH; ?>/customer/login" method="post" class="form form1 user_form" id="loginForm">
                            <input type="hidden" value="<?php echo 'http://' . Site::instance()->get('domain') . '/lookbook/' . $c_images['id'] . '-1#pagefocus'; ?>" name="referer">
                            <b>Войти прежде всего</b>
                            <ul class="mtb10">
                                <li class="fix">
                                    <label for="email"><span>*</span> Адрес почты :</label>
                                    <div class="right_box"><input type="text" value="" name="email" class="text" /></div>
                                </li>
                                <li class="fix">
                                    <label for="password1"><span>*</span> Пароль :</label>
                                    <div class="right_box"><input type="password" value="" name="password" class="text" /></div>
                                </li>
                                <li class="fix">
                                    <label for="submit">&nbsp;</label>
                                    <div class="right_box"><input type="submit" value="Далее" class="view_btn btn26 btn40" /></div>
                                </li>
                            </ul>
                        </form>
                        <script>
                            $("#loginForm").validate({
                                rules: {
                                    email: {
                                        required: true,
                                        email: true
                                    },
                                    password: {
                                        required: true,
                                        minlength: 5,
                                        maxlength:20
                                    }
                                },
                                messages: {
                                    email:{
                                        required:"Введите адрес вашей электронной почты,пожалуйста.",
                                        email:"Введите действительный адрес электронной почты,пожалуйста."
                                    },
                                    password: {
                                        required: "Заполните это поле.",
                                        minlength: "Пароль слишком короткий, не менее 5 символов."
                                    }
                                }
                            });
                        </script>
                        <?php
                    }
                    ?>
                </div>

                <!--　login after -->
                <div class="review-form">

                </div>                                                            
            </div>
        </div>
    </section>
</section>
<script type="text/javascript">
    $(function(){
        $('.grade').children().click(function(){
            var star = $(this).attr('alt');
            $('#star').val(star);
        })
    })
</script>
<?php echo View::factory(LANGPATH.'/quickview'); ?>
<div class="mybag hide" id="mybag" style="position: fixed;top: 10px;right: 140px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border-style: solid;border-width: 8px 4px 4px;">
    <div class="add_tit" style="margin-top:0px;">Молодец! Товар добавлен в корзину.</div>
    <div class="order order_addtobag">
        <ul id="bag_items">
            <li>
            </li>
        </ul>
    </div>
    <div class="mybagButton"><a href="<?php echo LANGPATH; ?>/cart/view" id="checkout1" class="allbtn btn-chk1">&nbsp;</a></div>
</div>
<script type="text/javascript">
    $(function(){
        $('#addCart').live("click",function(){
            var btn_size = $('.btn_size').html();
            var size = $('.s-size').val();
            if(btn_size && !size)
            {
                alert($('#select_size').html());
                return false;
            }
        })
        
        $("#formAdd").submit(function(){
            $.post(
            '/cart/ajax_add?lang=<?php echo LANGUAGE; ?>',
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
                                <p>Товар# : '+product[p]['sku']+'</p>\
                                <p>'+product[p]['price']+'</p>\
                                <p>'+product[p]['attributes']+'</p>\
                                <p>Количество: '+product[p]['quantity']+'</p>\
                            </div>\
                        <div class="fix"></div>\
                        ';
                    }
                }
                cart_view = cart_view.replace('Size', 'Размеры');
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

<?php
if (!empty($skus))
{
    ?>
    <div class="JS_popwincon4 popwincon hide">
        <a class="JS_close5 close_btn2"></a>
        <!-- look_box -->
        <div class="look_pro">
            <?php
            $wishlist = array();
            $n = 1;
            ?>
            <form action="<?php echo LANGPATH; ?>/cart/add_more" method="post" class="form3" id="form<?php echo $key; ?>">
                                <input type="hidden" name="page" value="product" />
                                <div class="items<?php echo $key; ?>">
                                    <ul class="scrollableDiv1 scrollableDivs<?php echo $key; ?> fix">
                                        <?php
                                        foreach ($skus as $sku)
                                        {
                                            $pro_id = Product::get_productId_by_sku(trim($sku));
                                            if (!$pro_id)
                                            {
                                                continue;
                                            }
                                            if ($n > 5)
                                            {
                                                break;
                                            }
                                            $n++;
                                            $wishlist[] = $pro_id;
                                            $link_pro = Product::instance($pro_id, LANGUAGE);
                                            $orig_price = round($link_pro->get('price'), 2);
                                            $price = round($link_pro->price(), 2);
                                            $sku_link = $link_pro->permalink();
                                            ?>
                                            <li>
                                                <input type="checkbox" name="check[<?php echo $n; ?>]" title="size<?php echo $n; ?>" class="checkbox" checked="checked" id="checkout<?php echo $pro_id . $key; ?>" /> <label for="checkout<?php echo $pro_id . $key; ?>">ДОБАВИТЬ В КОРЗИНУ</label>
                                                <input type="hidden" name="item[<?php echo $n; ?>]" value="<?php echo $pro_id; ?>" />
                                                <a href="<?php echo $sku_link; ?>"><img src="<?php echo Image::link($link_pro->cover_image(), 3); ?>" /></a>
                                                <a href="<?php echo $sku_link; ?>" class="name"><?php echo $link_pro->get('name'); ?> </a>
                                                <p class="price">
                                                    <?php
                                                    if ($orig_price > $price)
                                                    {
                                                        ?>
                                                        <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del> <b class="red font18"><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <b class="red font18"><?php echo Site::instance()->price($link_pro->get('price'), 'code_view'); ?></b>
                                                        <?php
                                                    }
                                                    ?>
                                                </p>
                                                <?php
                                                $instock = 1;
                                                $stock = $link_pro->get('stock');
                                                $stocks = array();
                                                $pro_stocks = array();
                                                if (!$link_pro->get('status') OR ($stock == 0 AND $stock != -99))
                                                {
                                                    $instock = 0;
                                                }
                                                elseif ($stock == -1)
                                                {
                                                    $stocks = DB::select()->from('products_stocks')->where('product_id', '=', $pro_id)->where('stocks', '>', 0)->execute()->as_array();
                                                    if (count($stocks) == 0)
                                                        $instock = 0;
                                                    else
                                                    {
                                                        foreach ($stocks as $s)
                                                        {
                                                            $pro_stocks[$s['attributes']] = $s['stocks'];
                                                        }
                                                    }
                                                }
                                                ?>
                                                <?php
                                                if($instock)
                                                {
                                                ?>
                                                <p class="select">Размеры: 
                                                    <select name="size[<?php echo $n; ?>]" class="size_select">
                                                        <?php
                                                        $is_onesize = 0;
                                                        $set = $link_pro->get('set_id');
                                                        if(!empty($pro_stocks))
                                                        {
                                                            echo '<option>выбрать размер</option>';
                                                            foreach($pro_stocks as $size => $p)
                                                            {
                                                                $sizeval = $size;
                                                                if($set == 2)
                                                                {
                                                                        $sizeArr = explode('/', $size);
                                                                        $sizeval = $sizeArr[2];
                                                                }
                                                            ?>
                                                            <option value="<?php echo str_replace('EUR', '', $sizeval); ?>" ><?php echo $sizeval; ?> <span class="red">(Теперь Только <?php echo $p; ?> !)</span></option>
                                                            <?php
                                                            }
                                                        }
                                                        else
                                                        {
                                                        $attributes = $link_pro->get('attributes');
                                                        if (isset($attributes['Size']))
                                                        {
                                                            if(count($attributes['Size']) == 1)
                                                                $is_onesize = 1;
                                                            else
                                                                echo '<option>выбрать размер</option>';
                                                            foreach ($attributes['Size'] as $size)
                                                            {
                                                                $sizeval = $size;
                                                                if($set == 2)
                                                                {
                                                                        $sizeArr = explode('/', $size);
                                                                        $sizeval = $sizeArr[2];
                                                                }
                                                                $sizeSmall = str_replace(array('One size', 'one size', 'One Size'), 'только один размер', $sizeval);
                                                                ?>
                                                                    <option value="<?php echo str_replace('EUR', '', $sizeval); ?>" ><?php echo $sizeSmall; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $is_onesize = 1;
                                                            ?>
                                                            <option value="one size" <?php if (isset($pro_stocks['one size'])) echo 'title="' . $pro_stocks['one size'] . '"' ?>>только один размер</option>
                                                            <?php
                                                        }
                                                        }
                                                        ?>
                                                    </select>
                                                    <input type="hidden" class="size_input" name="size<?php echo $n; ?>" value="<?php if($is_onesize) echo 1; ?>" />
                                                </p>
                                                <p class="select">Количество: <input type="text" class="text" name="qty[<?php echo $n; ?>]" value="1" /></p>
                                                <?php
                                                }
                                                ?>
                                                <p class="center"><a href="<?php echo $sku_link; ?>" class="btn22_gray" target="_blank">Подробнее</a></p>
                                                <?php
                                                if (!$instock)
                                                    echo '<span class="outstock">Нет в наличии</span>';
                                                ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="center mt50">
                                    <input type="submit" value="ДОБАВИТЬ В КОРЗИНУ" class="btn40_16_red" /><a href="<?php echo LANGPATH; ?>/wishlist/add_more/<?php echo implode('-', $wishlist); ?>" class="a_underline add_wishlist">ZUR WUNSCHLISTE</a>
                                </div>
                                <span class="prevs<?php echo $key; ?>"></span>
                                <span class="nexts<?php echo $key; ?>"></span>
                            </form>
            <script>
                                $("#form<?php echo $key; ?>").validate({
                                                rules: {
                                                    size0: {
                                                        required: true
                                                    },
                                                    size1: {
                                                        required: true
                                                    },
                                                    size2: {
                                                        required: true
                                                    },
                                                    size3: {
                                                        required: true
                                                    },
                                                    size4: {
                                                        required: true
                                                    },
                                                    size5: {
                                                        required: true
                                                    },
                                                    size6: {
                                                        required: true
                                                    },
                                                    size7: {
                                                        required: true
                                                    }
                                                },
                                                messages: {
                                                    size0:{
                                                        required:"обязательные поля."
                                                    },
                                                    size1:{
                                                        required:"обязательные поля."
                                                    },
                                                    size2:{
                                                        required:"обязательные поля."
                                                    },
                                                    size3:{
                                                        required:"обязательные поля."
                                                    },
                                                    size4:{
                                                        required:"обязательные поля."
                                                    },
                                                    size5:{
                                                        required:"обязательные поля."
                                                    },
                                                    size6:{
                                                        required:"обязательные поля."
                                                    },
                                                    size7:{
                                                        required:"обязательные поля."
                                                    },
                                                    
                                                }
                                    })
                                    $(function(){
                                        $(".form3 .checkbox").click(function(){
                                            var ck = $(this).attr('checked');
                                            if(ck == 'checked')
                                            {
                                                var title = $(this).attr('title');
                                                $(this).parent().find('.size_input').attr('name', title);
                                            }
                                            else
                                            {
                                                $(this).parent().find('.size_input').attr('name', '');
                                            }
                                        })
                                        
                                        $(".size_select").change(function(){
                                            var val = $(this).val();
                                            $(this).parent().find(".size_input").val(val);
                                        })
                                        
                                        var i = 1;  
                                        var m = 1;  
                                        var $content = $(".scrollableDivs<?php echo $key; ?>");
                                        var count = ($content.find("li").length)-4;
                                        $(".look_pro .nexts<?php echo $key; ?>").live("click",function(){
                                            var $scrollableDiv = $(this).siblings(".items<?php echo $key; ?>").find(".scrollableDivs<?php echo $key; ?>");
                                            if( !$scrollableDiv.is(":animated")){
                                                if(m<count){ 
                                                    m++;
                                                    $scrollableDiv.animate({left: "-=175px"});
                                                }
                                            }
                                            return false;
                                        });
                                        
                                        //上一张
                                        $(".look_pro .prevs<?php echo $key; ?>").live("click",function(){
                                            var $scrollableDiv = $(this).siblings(".items<?php echo $key; ?>").find(".scrollableDivs<?php echo $key; ?>");
                                            if( !$scrollableDiv.is(":animated")){
                                                if(m>i){ 
                                                    m--;
                                                    $scrollableDiv.animate({left: "+=175px"});
                                                }
                                            }
                                            return false;
                                        });
                                    })
                                </script>
        </div>
    </div>
    <?php
}
?>