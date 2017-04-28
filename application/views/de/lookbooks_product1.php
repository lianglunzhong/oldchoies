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
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Homepage</a>  >  SCHAU DER KÄUFER</div>
        </div>
        <?php echo message::get(); ?>
    </div>
    <section class="layout fix">
        <h3 class="lookbook_tit">
            <div class="fll">SCHAU DER KÄUFER</div>
            <a class="flr red" href="<?php echo LANGPATH; ?>/lookbook">ZRÜCK ZU LOOKBOOK</a>
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
                            <p><a href="<?php echo $link; ?>" id="<?php echo $c_images['product_id']; ?>" class="btn40_16_black btn mb20 quick_view JS_shows1 hide">JETZT KAUFEN</a></p>
                            <?php
                            if ($c_images['type'] != 1 && $c_images['link_sku'] && strlen($c_images['link_sku']) > 0)
                            {
                                ?>
                                <p><a class="btn40_16_red btn mb50 JS_popwinbtn4">SEHEN SIE HIER</a></p>
                                <?php
                            }
                            ?>
                            <div class="lookbook_share font14">
                                <span>Teilen mit:</span>
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
                        <h2>Zu diesem Artikel Passen</h2>
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
                <h3>KOMMENTARE</h3>
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
                <h3>EIN KOMMENAR SCHREIBEN</h3>
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
                                <b>Seien Sie der Erste, der einen Kommentar schreibt</b>
                                <?php
                            }
                            ?>

                            <ul class="mtb10">
                                <li class="fix">
                                    <label class="fll"><span>*</span>Grad:</label>
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
                                    <label><span>*</span>Kommentar:</label>
                                    <div class="right_box"><textarea name="content"></textarea></div>
                                </li>
                                <li class="fix">
                                    <label for="submit">&nbsp;</label>
                                    <input type="hidden" name="lookbook_id" value="<?php echo $c_images['id']; ?>" />
                                    <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
                                    <div class="right_box"><input type="submit" value="SENDEN" class="view_btn btn26" /></div>
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
                                        required:"Bitte geben Sie ein Grad ein."
                                    },
                                    content: {
                                        required: "Bitte geben Sie ein Kommentar ein.",
                                        minlength: "Ihr Kommentar muss mindestens 5 Zeichen lang sein."
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
                            <b>Bitte loggen Sie sich zunächst ein</b>
                            <ul class="mtb10">
                                <li class="fix">
                                    <label for="email"><span>*</span> Ihr Email :</label>
                                    <div class="right_box"><input type="text" value="" name="email" class="text" /></div>
                                </li>
                                <li class="fix">
                                    <label for="password1"><span>*</span> Passwort :</label>
                                    <div class="right_box"><input type="password" value="" name="password" class="text" /></div>
                                </li>
                                <li class="fix">
                                    <label for="submit">&nbsp;</label>
                                    <div class="right_box"><input type="submit" value="ANMELDEN" class="view_btn btn26 btn40" /></div>
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
                                        required:"Bitte geben Sie eine E-Mail ein.",
                                        email:"Bitte geben Sie eine gültige E-Mail Adresse ein."
                                    },
                                    password: {
                                        required: "Bitte geben Sie ein Passwort ein.",
                                        minlength: "Ihr Passwort muss mindestens 5 Zeichen lang sein."
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

<script type="text/javascript" src="/js/catalog.js"></script>
<script type="text/javascript" src="/js/catalog.loadthumb.js"></script>
<div class="JS_popwincon1 popwincon hide" style="padding-right: 50px;">
    <a class="JS_close2 close_btn2"></a>
    <div style="background:#fff; height: 545px;" id="inline_example2">
        <div id="quickView">

            <!------------------------------------ Product Images-------------------------------------->         
            <div class="content-product-image fix">
                <div class="myImagesSlideBox1" id="myImagesSlideBox">
                    <div class="myImages1">
                        <img src="" class="myImgs" alt="" />
                    </div>
                    <div id="scrollable"> 
                        <div class="items" >
                            <div class="scrollableDiv"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!------------------------------------ Product Info-------------------------------------->
            <div id="productInfo">
                <dl>
                    <dd>
                        <h1 id="product_name"></h1>
                        <div class="infoText">Artikel# : <span id="product_sku">CPDL1959</span></div>
                        <div class="stock" id="stock">
                            <span>Auf Lager</span>
                        </div>
                        <div class="hide" id="outstock">
                            <span class="red">Ausverkauft</span>
                        </div>
                        <div class="detils" style="width:190px;"><a id="product_link" href="#" title="VOLLSTÄNDIGE DETAILS SEHEN">VOLLSTÄNDIGE DETAILS SEHEN</a></div>
                        <div class="clear"></div>
                    </dd>
                    <dd>
                        <div class="price">
                            <span class="reg"><del id="product_s_price"></del></span>
                            <br/>
                            <span id="product_price" class="nowPrice"></span>
                        </div>
                    </dd>

                    <dd class="fix">
                        <div class="charge_fix" id="action-form">
                            <form action="#" method="post" id="formAdd">
                                <input id="product_id" type="hidden" name="id" value="8468"/>
                                <input id="product_items" type="hidden" name="items[]" value="8468"/>
                                <input id="product_type" type="hidden" name="type" value="3"/>
                                <div class="btn_size"></div>
                                <div class="btn_color"></div>
                                <div class="btn_type"></div>
                                <div class="qty mt10">Anzahl: 
                                    <input type="button" onclick="minus()" value="-" class="btn_qty1" />
                                    <input type="text" name="quantity" class="btn_text" value="1" id="count_1"/>
                                    <input type="button" onclick="plus()" value="+" class="btn_qty" />
                                    <span id="only_left" class="red"></span>
                                    <strong class="red" id="outofstock"></strong>
                                </div>
                                <div class="btnadd"> 
                                    <input type="submit" value="IN DEN WARENKORB" class="btn40_16_red" id="addCart" />
                                    <a id="addWishList" class="btn40_1 view_btn btn" href="#">MEINE WUNSCHLISTE</a>
                                </div>
                            </form>
                        </div>
                    </dd>
                    <dd>
                        <div id="tab5">
                            <div id="tab5-nav1">
                                <ul class="fix idTabs">
                                    <li class="on">DETAILS</li>
                                    <li>KONTAKT</li>
                                </ul>
                            </div>
                            <div id="tab5-con-1">
                                <div id="tab5-1-con"></div>
                                <div class="description hide" id="tab5-2-con">
                                    <div class="LiveChat2  mt15 pl10">
                                        <a href="#" onclick="psSMPPow(); return false;"><img name="psSMPPimage" src="http://www.choies.com/images/livechat_online1.gif" border="0" /> LiveChat</a>
                                    </div>
                                    <div class="LiveChat2 mt10 pl10"><a href="mailto:<?php echo Site::instance()->get('email'); ?>"><img src="/images/livemessage.png" alt="Eine Nachricht hinterlassen" /> Eine Nachricht hinterlassen</a></div>
                                    <div class="LiveChat2 mt10 pl10"><a href="<?php echo LANGPATH; ?>/faqs" target="_blank"><img src="/images/faq.png" alt="FAQ" /> FAQ</a></div>
                                </div>
                            </div>
                        </div>
                    </dd>
                    <dd>
                      <div><!--  <a href="<?php echo LANGPATH; ?>/20-coupon-code-for-spring-festival"><img src="/images/gift_banner.jpg" alt="" /></a>--></div>
                    </dd>
                </dl>
            </div>

        </div>
    </div>
    <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
</div>
<div class="mybag hide" id="mybag" style="position: fixed;top: 10px;right: 140px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border-style: solid;border-width: 8px 4px 4px;">
    <div class="add_tit" style="margin-top:0px;">ERFOLG! ARTIKEL IN DEN WARENKORB HINZUGEFÜGT</div>
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
        $(".pro_listcon .pic img").live('hover', function(){
            if($(this).siblings().length > 0)
            {
                $(this).toggle();
                $(this).siblings().toggle();
            } 
        },function(){
            if($(this).siblings().length > 0)
            {
                $(this).toggle();
                $(this).siblings().toggle();
            } 
        })
        $('.quick_view').live("click",function(){
            var id = $(this).attr('id');
            $.post(
            '/site/ajax_product?lang=<?php echo LANGUAGE; ?>',
            {
                id: id
            },
            function(product)
            {
                $('#product_id').val(id);
                $('#product_items').val(id);
                $('#product_type').val(product['type']);
                $('#product_name').html(product['name']);
                $('#product_sku').html(product['sku']);
                $('#product_link').attr('href', product['link']);
                $('#product_price').html(product['price']);
                $('#product_s_price').html(product['s_price']);
                
                //attributes
                if(product['attributeSize'] != '')
                {
                    $(".btn_size").html('');
                    $(".btn_size").append('<input type="hidden" name="attributes[Size]" value="" class="s-size" /><div id="select_size" class="mb10">Größe wählen:</div>');
                    var attribute = product['attributeSize'].replace('value="one size"', 'value="eine Größe"');
                    $(".btn_size").append(attribute);
                }
                
                if(product['attributeColor'] != '')
                {
                    $(".btn_color").html('');
                    $(".btn_color").append('<input type="hidden" name="attributes[Color]" value="" class="s-color" /><div id="select_color" class="mb10">Farbe wählen:</div>');
                    $(".btn_color").append(product['attributeColor']);
                }
                
                if(product['attributeType'] != '')
                {
                    $(".btn_type").html('');
                    $(".btn_type").append('<input type="hidden" name="attributes[Type]" value="" class="s-type" /><div id="select_type" class="mb10">Typ wählen:</div>');
                    $(".btn_type").append(product['attributeType']);
                }
                
                //images
                $('.myImgs').attr('alt', product['name']);
                $('.scrollableDiv').html('');
                var bimage = '';
                var simage = '';
                for(var n in product['images'])
                {
                    if(product['images'][n]['status'] == 0)
                    {
                        bimage = '/pimages/' + product['images'][n]['id'] + '/2.' + product['images'][n]['suffix'];
                        simage = '/pimages/' + product['images'][n]['id'] + '/3.' + product['images'][n]['suffix'];
                    }
                    else
                    {
                        bimage = '/pimages1/' + product['images'][n]['id'] + '/2.' + product['images'][n]['suffix'];
                        simage = '/pimages1/' + product['images'][n]['id'] + '/3.' + product['images'][n]['suffix'];
                    }
                    if(n == 0)
                    {
                        $('.myImgs').attr('src', bimage);
                    }
                    $('.scrollableDiv').append('<a><img src="'+simage+'" alt="'+product['name']+'" imgb="'+bimage+'"  bigimg="'+bimage+'" /></a>');
                }
                
                $('#tab5-1-con').html(product['keywords'] + '<br><br>' + product['brief'] + '<br><br>' + product['description']);
                var instock = 1;
                if(product['stock'] == 0 && product['stock'] != -99)
                {
                    var instock = 0;
                }
                else if(product['stock'] < 9)
                {
                    $("#quantity").html('');
                    for(i=1;i<=product['stock'];i ++)
                    {
                        $("#quantity").append('<option value="'+i+'">'+i+'</option>');
                    }
                }
                if(product['stock'] != -99 && product['stock'] > 0)
                {
                    $("#outofstock").html('(Nur noch ' + product['stock'] + ' auf Lager!)');
                }
                
                if(product['status'] == 0 || !instock)
                {
                    $('#outstock').show();
                    $('#stock').hide();
                    $('#addCart').hide();
                }
                else
                {
                    $('#stock').show();
                    $('#outstock').hide();
                    $('#addCart').show();
                }
                $('#only_left').html('');
                var top = getScrollTop();
                top = top - 35;
                $('body').append('<div class="JS_filter1 opacity"></div>');
                $('.JS_popwincon1').css({
                    "top": top, 
                    "position": 'absolute'
                });
                $('.JS_popwincon1').appendTo('body').fadeIn(320);
                $('.JS_popwincon1').show();
            },
            'json'
        );
            return false;
        })
        
        $(".btn_size input").live("click",function(){
            if($(this).attr('class') != 'btn_size_normal')
            {
                return false;
            }
            var value = $(this).attr('id');
            $(".s-size").val(value);
            $(this).siblings().removeClass('btn_size_select');
            $(this).addClass('btn_size_select');
            $("#select_size").html('Größe: '+$(this).val());
            var qty = $(this).attr('title');
            if(qty)
                $("#only_left").html('Nur noch '+qty+' auf Lager!');
        })
        
        $(".btn_color input").live("click",function(){
            if($(this).attr('class') != 'btn_size_normal')
            {
                return false;
            }
            var value = $(this).attr('id');
            $(".s-color").val(value);
            $(this).siblings().removeClass('btn_size_select');
            $(this).addClass('btn_size_select');
            $("#select_color").html('Farbe: '+$(this).val());
        })
        
        $(".btn_type input").live("click",function(){
            if($(this).attr('class') != 'btn_size_normal')
            {
                return false;
            }
            var value = $(this).attr('id');
            $(".s-type").val(value);
            $(this).siblings().removeClass('btn_size_select');
            $(this).addClass('btn_size_select');
            $("#select_type").html('Typ: '+$(this).val());
        })
        
        $('#addWishList').live("click",function(){
            var id = $('#product_id').val();
            window.location.href = '<?php echo LANGPATH; ?>/wishlist/add/'+id;
            return false;
        })
    })
</script>
<script type="text/javascript">
    $(function(){
        $('#addCart').live("click",function(){
            var btn_size = $('.btn_size').html();
            var size = $('.s-size').val();
            if(btn_size && !size)
            {
                alert('Bitte ' + $('#select_size').html());
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
                                <p>Artikel# : '+product[p]['sku']+'</p>\
                                <p>'+product[p]['price']+'</p>\
                                <p>'+product[p]['attributes']+'</p>\
                                <p>Anzahl: '+product[p]['quantity']+'</p>\
                            </div>\
                        <div class="fix"></div>\
                        ';
                    }
                }
                cart_view = cart_view.replace('Size', 'Größe');
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
                                                <input type="checkbox" name="check[<?php echo $n; ?>]" title="size<?php echo $n; ?>" class="checkbox" checked="checked" id="checkout<?php echo $pro_id . $key; ?>" /> <label for="checkout<?php echo $pro_id . $key; ?>">In den Warenkorb</label>
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
                                                <p class="select">Größe: 
                                                    <select name="size[<?php echo $n; ?>]" class="size_select">
                                                        <?php
                                                        $is_onesize = 0;
                                                        $set = $link_pro->get('set_id');
                                                        if(!empty($pro_stocks))
                                                        {
                                                            echo '<option>Bitte Wählen</option>';
                                                            foreach($pro_stocks as $size => $p)
                                                            {
                                                                $sizeval = $size;
                                                                if($set == 2)
                                                                {
                                                                        $sizeArr = explode('/', $size);
                                                                        $sizeval = $sizeArr[2];
                                                                }
                                                            ?>
                                                            <option value="<?php echo str_replace('EUR', '', $sizeval); ?>" ><?php echo $sizeval; ?> <span class="red">(Nur noch <?php echo $p; ?> auf Lager!)</span></option>
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
                                                                echo '<option>Bitte Wählen</option>';
                                                            foreach ($attributes['Size'] as $size)
                                                            {
                                                                $sizeval = $size;
                                                                if($set == 2)
                                                                {
                                                                        $sizeArr = explode('/', $size);
                                                                        $sizeval = $sizeArr[2];
                                                                }
                                                                $sizeSmall = str_replace(array('One size', 'one size', 'One Size'), 'Eine Größe', $sizeval);
                                                                ?>
                                                                    <option value="<?php echo str_replace('EUR', '', $sizeval); ?>" ><?php echo $sizeSmall; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $is_onesize = 1;
                                                            ?>
                                                            <option value="one size" <?php if (isset($pro_stocks['one size'])) echo 'title="' . $pro_stocks['one size'] . '"' ?>>Eine Größe</option>
                                                            <?php
                                                        }
                                                        }
                                                        ?>
                                                    </select>
                                                    <input type="hidden" class="size_input" name="size<?php echo $n; ?>" value="<?php if($is_onesize) echo 1; ?>" />
                                                </p>
                                                <p class="select">Anzahl: <input type="text" class="text" name="qty[<?php echo $n; ?>]" value="1" /></p>
                                                <?php
                                                }
                                                ?>
                                                <p class="center"><a href="<?php echo $sku_link; ?>" class="btn22_gray" target="_blank">ALLE DETAILS SEHEN</a></p>
                                                <?php
                                                if (!$instock)
                                                    echo '<span class="outstock">NICHT AUF LAGER</span>';
                                                ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="center mt50">
                                    <input type="submit" value="IN DEN WARENKORB" class="btn40_16_red" /><a href="<?php echo LANGPATH; ?>/wishlist/add_more/<?php echo implode('-', $wishlist); ?>" class="a_underline add_wishlist">ZUR WUNSCHLISTE</a>
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
                                                        required:"Erforderliches Feld."
                                                    },
                                                    size1:{
                                                        required:"Erforderliches Feld."
                                                    },
                                                    size2:{
                                                        required:"Erforderliches Feld."
                                                    },
                                                    size3:{
                                                        required:"Erforderliches Feld."
                                                    },
                                                    size4:{
                                                        required:"Erforderliches Feld."
                                                    },
                                                    size5:{
                                                        required:"Erforderliches Feld."
                                                    },
                                                    size6:{
                                                        required:"Erforderliches Feld."
                                                    },
                                                    size7:{
                                                        required:"Erforderliches Feld."
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