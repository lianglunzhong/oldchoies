<link rel="canonical" href="/<?php echo $catalog_link; ?>" />
<link type="text/css" rel="stylesheet" href="/css/common.css" media="all" />
<link type="text/css" rel="stylesheet" href="/css/catalog_<?php echo LANGUAGE; ?>.css" media="all" />
<link type="text/css" rel="stylesheet" href="/css/quickview.css" media="all" />
<style>
    .pro-item .icon-rshipped{position: absolute;top: 0; right: 0;}
    .icon-rshipped {width: 45px;height: 45px;background-image: url(/images/catalog/ico-rshipped.png);}
</style>

<?php
$gets = array();
foreach ($_GET as $name => $val)
{
    if ($name == 'sort')
        continue;
    $gets[] = $name . '=' . $val;
}
if (!empty($gets))
    $href = '?' . implode('&', $gets) . '&';
else
    $href = '?';
$link = empty($gets) ? '' : '?' . implode('&', $gets);
?>
<!-- main begin -->
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll">
                <a href="<?php echo LANGPATH; ?>/" class="home">Homepage</a>
                &gt;<span>Suchen : <strong><?php echo $keywords; ?></strong>
            </div>
        </div>
    </div>
    <div class="grid">
        <article class="filter_page">
            <ul class="filter-bar cf">
                <li style="float:left;"><div>Sortieren nach:&nbsp;</div></li>
                <li class="item-l choice" style="width:140px;">
                    <div class="choice-hd">
                        <?php
                        $ens = array("What's New", 'Best Seller', 'Price: Low To High', 'Price: High To Low');
                        $trns = array('Was ist NEU', 'Bestseller', 'Preis: Niedrig zu Hoch', 'Preis: Hoch zu Niedrig');
                        if(isset($_GET['sort']))
                        {
                            $sname = str_replace($ens, $trns, $sorts[$_GET['sort']]['name']);
                            echo $sname;
                        }
                        else
                        {
                            echo 'Default'; 
                        }
                        ?>
                        <i class="fa fa-caret-down"></i>
                    </div>
                    <ul class="choice-list">
                    <?php
                    foreach ($sorts as $key => $sort): 
                        $sname = str_replace($ens, $trns, $sort['name']);
                        if($link == "")
                        {
                            $tolink = $link . '?sort=' . $key;
                        }
                        else
                        {
                            $tolink = $link . '&sort=' . $key;
                        }
                        ?>
                        <li class="choice-option" <?php if (isset($_GET['sort']) AND (int) $_GET['sort'] == $key) echo 'class="on"'; ?> onclick="tolink(<?php echo $key; ?>);">
                            <a href="<?php echo $tolink; ?>"><?php echo $sname; ?></a>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                </li>
                <li class="item-l pick" style="width: auto;">
                <?php
                    $gets1 = $gets;
                    if (!empty($gets1))
                    {
                        $has = 0;
                        foreach ($gets1 as $key => $get)
                        {
                            if (strpos($get, 'pick') !== FALSE)
                            {
                                $has = 1;
                                $gets1[$key] = 'pick=1';
                                break;
                            }
                        }
                        if (!$has)
                            $gets1[] = 'pick=1';
                    }
                    else
                        $gets1[] = 'pick=1';

                    ?>
                    <a href="<?php echo $_SERVER['REDIRECT_URL'] . '?' . Security::xss_clean(implode('&', $gets1)); ?>" class=""> <i class="icon icon-pick"></i> Wahl der Berühmtheit</a>
                </li>
                <li class="item-r choice">
                    <div class="choice-hd">
                        Farbe <i class="fa fa-caret-down"></i>
                    </div>
                    <ul class="choice-list choice-list-col choice-color" id="color_ul">
                        <li class="choice-line"></li>
                        <?php
                        $gets = $_GET;
                        $current_color = Arr::get($_GET, 'color', 0);
                        $filtercolors = Kohana::config('filter.colors');
                        foreach ($filtercolors as $key => $color)
                        {
                            if ($current_color == $key + 1)
                                $on = 1;
                            else
                                $on = 0;
                            if(!$on)
                                $gets['color'] = $key + 1;
                            else
                                unset($gets['color']);
                            $_gets = array();
                            foreach ($gets as $name => $val)
                            {
                                $_gets[] = $name . '=' . $val;
                            }
                            $href = '?' . implode('&', $_gets);
                            $href = Security::xss_clean($href);
                            ?>
                            <li class="choice-option <?php if ($on) echo 'on'; ?>">
                                <a href="<?php echo $href; ?>" title="<?php echo ucfirst($color); ?>">
                                    <?php if ($on) echo '<em style="margin: 0px;"></em>'; ?>
                                    <span class="icon color_cate_<?php echo strtolower($color); ?>"></span>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
            </ul>
            <?php
            if (!empty($products))
            {
            ?>
                <div class="flr mt20"><?php echo $pagination; ?></div>
            <?php
            }
            ?>
        </article>
        <div class="fix"></div>
        <?php
        if (!empty($products))
        {
        ?>
        <div class="pro-list">
            <ul class="cf">
                <?php
                if($show_ship_tip)
                    $ready_shippeds = DB::select('product_id')->from('catalog_products')->where('catalog_id', '=', 395)->execute()->as_array();
                else
                    $ready_shippeds = array();
                foreach ($products as $i => $product_id)
                {
                    $search = array('product_id' => $product_id);
                    $product_inf = Product::instance($product_id, LANGUAGE);
                    $cover_image = $product_inf->cover_image();
                    $plink = $product_inf->permalink();
                    ?>
                    <li class="pro-item">
                        <?php
                        if($i >= 20)
                        {
                        ?>
                            <div class="overlay"></div>
                            <div class="pic">
                                <a href="<?php echo $plink; ?>">
                                <div class="pic1"><img data-original="<?php echo Image::link($cover_image, 1); ?>" src="/images/loading.gif" alt="<?php echo $product_inf->get('name'); ?>" title="<?php echo $product_inf->get('name'); ?>" /></div>
                                </a>
                            </div>
                        <?php
                        }
                        else
                        {
                            ?>
                            <div class="overlay"></div>
                            <div class="pic">
                                <a href="<?php echo $plink; ?>">
                                <div class="pic1"><img src="<?php echo Image::link($cover_image, 1); ?>" alt="<?php echo $product_inf->get('name'); ?>" title="<?php echo $product_inf->get('name'); ?>" /></div>
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                        <h6 class="title">
                            <a href="<?php echo $plink; ?>" title="<?php echo $product_inf->get('name'); ?>">
                            <?php
                            if ($product_inf->get('has_pick') != 0)
                            {
                                ?>
                                <i class="icon icon-pick"></i>
                                <?php
                            }
                            ?>
                            <?php echo $product_inf->get('name'); ?>
                            </a>
                        </h6>
                        <p class="price">
                            <?php
                            $orig_price = round($product_inf->get('price'), 2);
                            $price = round($product_inf->price(), 2);
                            if ($orig_price > $price)
                            {
                                ?>
                                <span class="priceold"><?php echo Site::instance()->price($orig_price, 'code_view'); ?></span>
                                <span class="pricenew"><?php echo Site::instance()->price($price, 'code_view'); ?></span>
                                <?php
                            }
                            else
                            {
                                ?>
                                <span class="pricenew"><?php echo Site::instance()->price($orig_price, 'code_view'); ?></span>
                                <?php
                            }
                            ?>
                        </p>
						
                        <?php
                        if(isset($review_statistics[$product_id]))
                        {
                            $review = $review_statistics[$product_id];
                            $integer = floor($review['rating']);
                            $decimal = $review['rating'] - $integer;
                        ?>
                        <div class="reviews">
                        <a href="<?php echo $plink; ?>#review_list">
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
                        </div>
                        <?php
                        }
                        ?>
						
                        <?php if ($product_inf->get('type') != 0): ?>
                            <a href="#" id="<?php echo $product_id; ?>" class="quick_view JS_shows1"><span class="btn-qv">SCHNELLANSICHT</span></a>
                        <?php endif; ?>
                        <?php
                        $onsale = 1;
                        if ($product_inf->get('status') == 0)
                            $onsale = 0;
                        else
                        {
                            if ($product_inf->get('stock') == 0)
                                $onsale = 0;
                            elseif ($product_inf->get('stock') == -1)
                            {
                                $stocks = DB::select(DB::expr('SUM(stocks) AS sum'))
                                    ->from('products_stocks')
                                    ->where('product_id', '=', $product_id)
                                    ->where('attributes', '<>', '')
                                    ->execute()->get('sum');
                                if (!$stocks)
                                    $onsale = 0;
                            }
                        }
                        if ($onsale == 0)
                        {
                            echo '<span class="outstock">AUSVERKAUFT</span>';
                        }
                        elseif(in_array($search, $ready_shippeds))
                        {
                            echo '<i class="icon icon-rshipped"></i>';
                        }
                        else
                        {
                            $is_new = time() - $product_inf->get('display_date') <= 86400 * 7 ? 1 : 0;
                            if($is_new)
                                echo '<i class="icon icon-new"></i>';
                        }
                        ?>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <div class="flr"><?php echo $pagination; ?></div>
        <?php
        }
        else
        {
            ?>
            <div class="notfound">
                    <div class="top_line"></div>
                    <!-- searchon_box -->
                    <div class="searchon_box">
                        <p class="top"><strong>Entschuldigung!</strong> Der Artikel, nach dem Sie suchen, wurde nicht gefunden,<br />
                            oder Ihre Zielseite aktualisiert im Moment ...</p>
                        <p><a href="<?php echo LANGPATH; ?>/contact-us" class="bottom">Spezielle Anfragen? Kontaktieren Sie uns!</a></p>
                    </div>
                    <div class=" font18 mb25">Oder Sie können einen Blick auf unsere meistverkauften Produkte werfen:</div>
                    <article class="pro_listcon">
                        <ul class="fix">
                        <?php
                        $top_seller = DB::select('product_id')
                            ->from('catalog_products')
                            ->where('catalog_id', '=', 32)
                            ->order_by('position', 'DESC')
                            ->execute();
                        $key = 0;
                        foreach ($top_seller as $product):
                            if (!Product::instance($product['product_id'], LANGUAGE)->get('visibility') OR !Product::instance($product['product_id'], LANGUAGE)->get('status'))
                                continue;
                            $relate_name = Product::instance($product['product_id'], LANGUAGE)->get('name');
                            $link = Product::instance($product['product_id'], LANGUAGE)->permalink();
                            ?>
                            <li>
                                <a href="<?php echo $link; ?>" title="<?php echo $relate_name; ?>">
                                    <img src="<?php echo image::link(Product::instance($product['product_id'], LANGUAGE)->cover_image(), 1); ?>" />
                                </a>
                                <?php if (Product::instance($product['product_id'], LANGUAGE)->get('type') != 0): ?>
                                    <a href="#" id="<?php echo $product['product_id']; ?>" class="quick_view">SCHNELLANSICHT</a>
                                <?php endif; ?>
                                <a href="<?php echo $link; ?>" class="name"><?php echo $relate_name; ?></a>
                                <p class="price fix">
                                    <?php
                                    $retail = Product::instance($product['product_id'], LANGUAGE)->get('price');
                                    $now = Product::instance($product['product_id'], LANGUAGE)->price();
                                    if ($retail > $now)
                                    {
                                        $off = (($retail - $now) / $retail) * 100;
                                        ?>
                                        <b><?php echo Site::instance()->price($now, 'code_view'); ?></b>    <del><?php echo Site::instance()->price($retail, 'code_view'); ?></del> <span class="off"><?php echo (int) $off; ?>% off</span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <b><?php echo Site::instance()->price($now, 'code_view'); ?></b>
                                        <?php
                                    }
                                    if (Product::instance($product['product_id'], LANGUAGE)->get('has_pick'))
                                        echo '<span class="icon_pick"></span>';
                                    ?>
                                </p>
                                <?php if ($retail > $now): ?>
                                    <span class="icon_sale"></span>
                                <?php endif; ?>
                                <?php if (!Product::instance($product['product_id'], LANGUAGE)->get('status')): ?>
                                    <span class="outstock">Ausverkauft</span>
                                <?php endif; ?>
                            </li>
                            <?php
                            $key++;
                            if ($key >= 10)
                                break;
                        endforeach;
                        ?>
                    </ul>
                    </article>
                </div>
            <?php
        }
        ?>
        <br><article class="product_reviews" id="alsoview" style="display:none">
        <div class="w_tit layout"><h2>EMPFOHLENE PRODUKTE</h2></div>
        <div class="box-dibu1">
        <!-- Template for rendering recommendations -->
        <script type="text/html" id="simple-tmpl" >
        <![CDATA[
            {{ for (var i=0; i < SC.page.products.length; i++) { }}
                {{ if(i==0){ }}
                <div class="hide-box1_0"><ul>
                {{ }else if(i%6==0){ }}
                <div class="hide-box1_{{= i/6 }} hide1"><ul>
                {{ } }}
              {{ var p = SC.page.products[i]; }}
              <li data-scarabitem="{{= p.id }}" style="display: inline-block" class="rec-item">
                 <a href="{{=p.plink}}" id="em{{= p.id }}link">
                  <img src="{{=p.image}}" class="rec-image">
                </a>
                <p class="price"><b id="em{{= p.id }}price">${{=p.price}}</b></p>
              </li>
                {{ if(i==5 || i==11 || i==17 || i==24){ }}
                </ul></div>
                {{ } }}
            {{ } }} 
        ]]>
        </script>
        <div id="personal-recs"></div>
        </article>
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
    </div>
</section>
<?php echo View::factory(LANGPATH . '/quickview'); ?>
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

<!-- JS_popwincon2 -->
<div class="JS_popwincon2 popwincon w_signup hide">
    <a class="JS_close3 close_btn3"></a>
    <div class="fix" id="sign_in_up">
        <div class="left" style="width:auto;margin-right:30px;padding-right:30px;">
            <div id="customer_pid" style="display:none;"></div>
            <h3>CHOIES Mitglied Anmelden</h3>
            <form action="#" method="post" class="signin_form sign_form form" id="form_login">
                <ul>
                    <li>
                        <label>Email adresse: </label>
                        <input type="text" value="" name="email" class="text" id="email1" />
                    </li>
                    <li>
                        <label>Passwort: </label>
                        <input type="password" value="" name="password" class="text" maxlength="16" id="password1" />
                    </li>
                    <li><input type="submit" value="ANMELDEN" name="submit" class="btn btn40" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">Passwort vergessen?</a></li>
                    <li>
                        <?php
                        $page = $plink;
                        $facebook = new facebook();
                        $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                        ?>
                        <a href="<?php echo $loginUrl; ?>" class="facebook_btn">Mit Facebook Verbinden</a>
                    </li>
                </ul>
            </form>
        </div>
        <div class="right">
            <h3>CHOIES Mitglied Registrieren</h3>
            <form action="#" method="post" class="signup_form sign_form form" id="form_register">
                <ul>
                    <li>
                        <label>Email adresse: </label>
                        <input type="text" value="" name="email" id="email2" class="text" />
                    </li>
                    <li>
                        <label>Passwort: </label>
                        <input type="password" value="" name="password" class="text" id="password2" maxlength="16" />
                    </li>
                    <li>
                        <label>Passwort Bestätigen: </label>
                        <input type="password" value="" name="password_confirm" id="password_confirm" class="text" maxlength="16" />
                    </li>
                    <li><input type="submit" value="REGISTRIEREN" name="submit" class="btn btn40" /></li>
                </ul>
            </form>
        </div>
    </div>
    <script type="text/javascript">
    // signin_form 
    $(".signin_form").validate({
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
                minlength: "Ihr Passwort muss mindestens 5 Zeichen lang ein."
            }
        }
    });

    // signup_form 
    $(".signup_form").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 5,
                maxlength:20
            },
            password_confirm: {
                required: true,
                minlength: 5,
                maxlength:20,
                equalTo: "#password2"
            }
        },
        messages: {
            email:{
                required:"Bitte geben Sie eine E-Mail ein.",
                email:"Bitte geben Sie eine gültige E-Mail Adresse ein."
            },
            password: {
                required: "Bitte geben Sie ein Passwort ein.",
                minlength: "Ihr Passwort muss mindestens 5 Zeichen lang ein."
            },
            password_confirm: {
                required: "Bitte geben Sie ein Passwort ein.",
                minlength: "Ihr Passwort muss mindestens 5 Zeichen lang ein.",
                equalTo: "Bitte geben Sie das gleiche Passwort wie oben ein."
            }
        }
    });
    </script>
</div>

<script type="text/javascript" src="/js/list.js"></script>

<script type="text/javascript">
    $(function(){
        $(".add_to_wishlist").live('click', function(){
            var pid = $(this).attr('data-product');
            var _proItem = $(this).parents(".pro-item");
            $.ajax({
                url:'/customer/ajax_login1',
                type:'POST',
                dataType:'json',
                data:{},
                success:function(res){
                    if(res != 0)
                    {
                        $.ajax({
                            url:'<?php echo LANGPATH; ?>/wishlist/ajax_add',
                            type:'POST',
                            dataType: "json",
                            data:{
                                product_id: pid,
                            },
                            success:function(result){
                                if(result.success)
                                {
                                    $("#wish_" + pid).parent().find('span').text('');
                                    $("#wish_" + pid).attr('class', 'fa fa-heart add_wishlist2')
                                    _proItem.find(".overlay").show();
                                    _proItem.find(".sign-warp").show();
                                    _proItem.find('.sign-warp').find('.wishlist_success').find('.text').text(result.message);
                                }
                                else
                                {
                                    alert(result.message);
                                }
                            }
                        });
                    }
                    else
                    {
                        $("#customer_pid").text(pid);
                        var top = getScrollTop();
                        top = top - 35;
                        $('body').append('<div class="JS_filter2 opacity"></div>');
                        $('.JS_popwincon2').css({
                            "top": top, 
                            "position": 'absolute'
                        });
                        $('.JS_popwincon2').appendTo('body').fadeIn(320);
                        $('.JS_popwincon2').show();
                    }
                }
            });
            return false;
        })

        $(".pro-item .add-wish .add_wishlist2").live('click', function() {
            return false;
        });

        $(".JS_popwinbtn2").click(function(){
            var product_id = $(this).attr('title');
            $("#customer_pid").text(product_id);
        })

        $("#form_login").submit(function(){
            var email = $("#email1").val();
            var password = $("#password1").val();
            var pid = $("#customer_pid").text();
            $.ajax({
                url:'<?php echo LANGPATH; ?>/customer/ajax_login',
                type:'POST',
                dataType: "json",
                data:{
                    email: email,
                    password: password,
                },
                success:function(rs){
                    if(rs.success)
                    {
                        $.ajax({
                            url:'<?php echo LANGPATH; ?>/wishlist/ajax_add',
                            type:'POST',
                            dataType: "json",
                            data:{
                                product_id: pid,
                            },
                            success:function(result){
                                if(result.success == 1)
                                {
                                    alert(result.message);
                                    $("#wish_" + pid).parent().find('span').text('');
                                    $("#wish_" + pid).attr('class', 'fa fa-heart add_wishlist2');
                                    $(".wishlist_success").show();
                                    $(".JS_filter2").remove();
                                    $(".JS_popwincon2").fadeOut(160);
                                    $(".overlay").hide();
                                    $(".sign-warp").hide();
                                }
                                else
                                {
                                    alert(result.message);
                                }
                            }
                        });
                        return false;
                    }
                    else
                    {
                        alert(rs.message);
                    }
                }
            });
            return false;
        })

        $("#form_register").submit(function(){
            var email = $("#email2").val();
            var password = $("#password2").val();
            var password_confirm = $("#password_confirm").val();
            var pid = $("#customer_pid").text();
            $.ajax({
                url:'<?php echo LANGPATH; ?>/customer/ajax_register',
                type:'POST',
                dataType: "json",
                data:{
                    email: email,
                    password: password,
                    confirm_password: password_confirm,
                },
                success:function(rs){
                    if(rs.success)
                    {
                        $.ajax({
                            url:'<?php echo LANGPATH; ?>/wishlist/ajax_add',
                            type:'POST',
                            dataType: "json",
                            data:{
                                product_id: pid,
                            },
                            success:function(result){
                                if(result.success == 1)
                                {
                                    alert(result.message);
                                    $("#wish_" + pid).parent().find('span').text('');
                                    $("#wish_" + pid).attr('class', 'fa fa-heart add_wishlist2');
                                    $(".wishlist_success").show();
                                    $(".JS_filter2").remove();
                                    $(".JS_popwincon2").fadeOut(160);
                                    $(".overlay").hide();
                                    $(".sign-warp").hide();
                                }
                                else
                                {
                                    alert(result.message);
                                }
                            }
                        });
                        return false;
                    }
                    else
                    {
                        alert(rs.message);
                    }
                }
            });
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

<script type="text/javascript">
    var google_tag_params = {
        ecomm_prodid: '',           //SKU
        ecomm_pagetype: 'category',         // product
        ecomm_totalvalue: ''       // 
    };
</script>
<!-- lazyload -->
<script type="text/javascript" charset="utf-8" src="/js/lazyload.js"></script>
