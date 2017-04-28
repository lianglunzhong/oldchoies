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
$uri = Request::instance()->uri();
$catalog_id = 0;
?>
<div class="site-content">
    <div class="main-container clearfix">
        <div class="container">
            <div class="crumbs">
                <div class="fll">
                    <a href="<?php echo LANGPATH; ?>/" class="home">Página de Inicio</a>
                    &gt;<span>Buscado : <strong><?php echo $keywords; ?></strong></span>
                </div>
            </div>
            <div class="list-main">
                <div class="filter-right" style="width: 100%;">
                <?php
                if (!empty($products))
                {
                ?>
                <div class="filter-bar">
                    <ul class="bar-r">
                        <li class=" item-r pick">
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
                            <a href="<?php echo '?' . Security::xss_clean(implode('&', $gets1)); ?>" class="">Elección de Celebridad</a>
                        </li>
                        <li class=" drop-down JS-show">
                            <span class="fll">Ordenar por:&nbsp;</span>
                            <div class="drop-down-hd">
                                <?php
                                $getsort = '';
                                if(isset($_GET['sort']))
                                {
                                    $getsort = $_GET['sort'];                    
                                }

                                $ens = array("Default","What's New", 'Best Seller', 'Price: Low To High', 'Price: High To Low');
                                $trns = array('Defecto', 'Novedades', 'Mejor Vendido', 'Precio De Menor A Mayor', 'Precio De Mayor A Menor');
                                if(isset($_GET['sort']))
                                {
                                    $sname = str_replace($ens, $trns, $sorts[$_GET['sort']]['name']);
                                    echo $sname;
                                }
                                else
                                {
                                    echo 'Defecto'; 
                                }
                                ?>
                                <i class="fa fa-angle-down"></i>
                            </div>
                            <ul class="drop-down-list JS-showcon hide" style="display:none; width:110%;"> 
                                <?php
                                foreach($gets1 as $k => $g)
                                {
                                    if (strpos($g, 'sort') !== FALSE || strpos($g, 'pick') !== FALSE)
                                        unset($gets1[$k]);
                                }
                                foreach ($sorts as $key => $sort)
                                {
                                    $sname = str_replace($ens, $trns, $sort['name']);
                                    $link = empty($gets1) ? '' : '?' . implode('&', $gets1);
                                    if($link == "")
                                    {
                                        $tolink = $link . '?sort=' . $key;
                                    }
                                    else
                                    {
                                        $tolink = $link . '&sort=' . $key;
                                    }
                                    ?>
                                    <li class="drop-down-option">
                                        <a href="<?php echo $tolink; ?>"><?php echo $sname; ?></a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                    <div class="flr hidden-xs pagination_div"><?php echo $pagination; ?></div>
                </div>
                <?php
                }
                ?>
                <div class="fix"></div>
                <?php
                $auto_loaded_products = '';
                if (!empty($products))
                {
                ?>
                <div class="pro-list">
                    <ul class="row" id="product_ul">
                    <?php
                    $product_ids = array();
                    if($show_ship_tip)
                        $ready_shippeds = DB::select('product_id')->from('catalog_products')->where('catalog_id', '=', 395)->execute()->as_array();
                    else
                        $ready_shippeds = array();
                    foreach ($products as $i => $product_id)
                    {
                        $product_ids[] = $product_id;
                        $search = array('product_id' => $product_id);
                        $product_inf = Product::instance($product_id, LANGUAGE);
                        $cover_image = $product_inf->cover_image();
                        $plink = $product_inf->permalink();
                        ?>
                        <?php
                        if($i < 20)
                        {
                            $auto_loaded_products .= $product_id . ',';
                        ?>
                            <li class="pro-item col-xs-6 col-sm-3">
                                <div class="pic">
                                    <a href="<?php echo $plink; ?>">
                                    <div class="pic1"><img src="<?php echo Image::link($cover_image, 1); ?>" alt="<?php echo $product_inf->get('name'); ?>" title="<?php echo $product_inf->get('name'); ?>" /></div>
                                    </a>
                                    <a href="<?php echo $plink; ?>" id="more_color<?php echo $product_id; ?>" style="display:none;"><span class="icon-color" title="More Colors"></span></a>
                                </div>
                                <p class="title">
                                    <a href="<?php echo $plink; ?>" title="<?php echo $product_inf->get('name'); ?>">
                                    <?php
                                    if ($product_inf->get('has_pick') != 0)
                                    {
                                        ?>
                                        <i class="myaccount"></i>
                                        <?php
                                    }
                                    ?>
                                    <?php echo $product_inf->get('name'); ?>
                                    </a>
                                </p>
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
                                        <span class="pricenow"><?php echo Site::instance()->price($orig_price, 'code_view'); ?></span>
                                        <?php
                                    }
                                    ?>
                                </p>
                                <div class="star" id="star_<?php echo $product_id; ?>"></div>
                                <?php if ($product_inf->get('type') != 0): ?>
                                    <a href="#" id="<?php echo $product_id; ?>" attr-lang="<?php echo LANGUAGE; ?>" class="quick_view btn-qv"  data-reveal-id="myModal">VISTA RÁPIDA</a>
                                <?php endif; ?>
                                <div class="add-wish">
                                <?php if(!$customer_id = Customer::logged_in()){ ?>
                                <div class="add_to_wishlist" data-product="<?php echo $product_id; ?>">
                                    <a class="wish-title" data-reveal-id="myModal2" id="wish1_<?php echo $product_id; ?>">AÑADIR A SU LISTA DE DESEOS
                                    <i class="fa fa-heart add_wishlist" id="wish_<?php echo $product_id; ?>"></i></a>
                                </div>
                                <?php }else{ ?>
                                <div class="add_to_wishlist" data-product="<?php echo $product_id; ?>">
                                    <a class="wish-title" id="wish1_<?php echo $product_id; ?>">AÑADIR A SU LISTA DE DESEOS
                                    <i class="fa fa-heart add_wishlist" id="wish_<?php echo $product_id; ?>"></i></a>
                                </div>
                                <?php } ?>
                                </div>
                                <div class="sign-warp" id="sc_<?php echo $product_id; ?>">
                                    <span class="sign-close">
                                        <i class="fa fa-times-circle fa-lg"></i>
                                    </span>
                                    <div class="wishlist_success">
                                        <p class="text" style="border:none;"></p>
                                        <p class="wish"><i class="fa fa-heart"></i>Lista De Deseos</p>
                                    </div>
                                </div>
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
                                    echo '<span class="outstock">Fuera de Stock</span>';
                                }
                                elseif(in_array($search, $ready_shippeds))
                                {
                                    echo '<i class=""></i>';
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
                    }
                    ?>
                    </ul>
                </div>
            <div class="flr"><?php echo $pagination; ?></div>
            <div class="clearfix"></div>
            <div id="loading" style="text-align:center;display:none;"><img src="<?php echo STATICURL;?>/assets/images/loading.gif"></div>
            <div style="display:none" id="load">1</div>
            </div>
            </div>
            <?php
            }
            else
            {
                ?>
                <div class="notfound">
                    <!-- searchon_box -->
                    <div class="searchon-wp">
                        <div class="searchon-404">
                            <p class="font24"><strong>¡Lo siento!</strong> El artículo que usted está buscando no se ha encontrado,<br />
                                o su página de destino se está actualizando en este momento...</p>
                            <p><a href="<?php echo LANGPATH; ?>/contact-us" class="bottom">¿Petición especial? Póngase en contacto con nosotros!</a></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
        <div class="other-customers" id="alsoview" style="display:none">
            <div class="w-tit">
                <h2>PRODUCTOS RECOMENDADOS</h2>
            </div>
            <div class="box-dibu1">
            <div id="personal-recs"></div>
            <script type="text/javascript">
                        $.ajax({
                                type: "POST",
                                url: "/ajax/topseller_relate",
                                dataType: "json",
                                data: "lang=es",
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
                        <h2>PRODUCTOS RECOMENDADOS</h2>
                    </div>
                    <div class="flash-sale">
                        <ul class="row" id="phone_scare"></ul>
                    </div>  
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php echo View::factory(LANGPATH . '/quickview'); ?>

<!-- JS-popwincon1 -->
<div id="myModal2" class="reveal-modal xlarge">
    <a class="close-reveal-modal close-btn3"></a>
    <?php echo View::factory(LANGPATH . '/customer/ajax_login'); ?>
</div>

<script type="text/javascript">
    $(function(){
        // auto load tips
        var auto_loaded_products = '<?php echo $auto_loaded_products; ?>';
        showis(auto_loaded_products);

        <?php
        $product_str = !empty($product_ids) ? implode(',', $product_ids) : '';
        ?>

        // 分类产品信息加载 --- wanglong 2015-12-17
        var timeout = false;
        $(window).scroll(function(){
            if (timeout){clearTimeout(timeout);} 
            timeout = setTimeout(function(){ 
                $("#pagination").hide();
                var li_last_height=parseInt($("#product_ul li").last().offset().top);
                var seeheight=parseInt($(window).height());
                var scrolltop=parseInt($(window).scrollTop());
                if(li_last_height<seeheight+scrolltop+500)
                { // 
                    var tli = $('#product_ul').children('li').length;
                    var load=$("#load").text();
                    if(load==1)
                    {
                        $.ajax({
                            type: "POST",
                            url: "/ajax/more_product?lang=<?php echo LANGUAGE;?>",
                            dataType: "json",
                            data: "product_ids=<?php echo $product_str; ?>&tli="+tli,
                            beforeSend: function () {
                                $("#loading").show();
                                
                            },
                            success: function(product){
                                //判断是否最后一组
                                if(product.length==0){  
                                    $("#load").text("0")
                                }
                                var showis_ids = '';
                                //  var product = [0,1,2,3,4,5,6,7,];
                                var loaded_products = '';
                                $.each(product,function(i,pdata){
                                    showis_ids += pdata['product_id'] + ',';
                                    loaded_products += pdata['product_id'] + ',';
                                    var product_li = '';
                                    product_li += '\
                                    <li class="pro-item col-xs-6 col-sm-3">\
                                        <div class="pic">\
                                            <a href="' + pdata['product_href'] + '">\
                                            <div class="pic1">\
                                                <img class="lazy" title="' + pdata['product_title'] + '" src="<?php echo STATICURL; ?>/assets/images/2016/loading.jpg" data-original="' + pdata['image_src'] + '"  alt="' + pdata['image_alt'] + '">\
                                            </div>\
                                            </a>\
                                            <a href="' + pdata['product_href'] + '" style="display:none;">\
                                                <span class="icon-color" title="More Colors"></span>\
                                            </a>\
                                        </div>\
                                        <div class="title">\
                                            <a href="' + pdata['product_href'] + '">';
                                            if(pdata['has_pick'] != 0){
                                                product_li += '<i class="myaccount"></i>';
                                            }
                                            
                                            
                                        product_li += pdata['product_title']+'</a></div><p class="price">';
                                        
                                        if(pdata['price_new'] == pdata['price_old']){
                                        product_li +=  '<span class="pricenow">'+pdata['price_old']+'</span>';
                                        }else{
                                        product_li +=  '<span class="priceold">' + pdata['price_old'] + '</span><span class="pricenew">' + pdata['price_new'] + '</span>';
                                        }
                                        product_li +=  '</p>\
                                        <div class="star" id="star_' + pdata['product_id'] + '">\
                                        </div>\
                                        <a id="' + pdata['product_id'] + '" class="btn-qv quick_view" attr-lang="<?php echo LANGUAGE; ?>" data-reveal-id="myModal">VISTA RÁPIDA</a>';
                                        product_li +=  
                                        '<div class="add-wish">';
                                        <?php if(!$customer_id = Customer::logged_in()){ ?>
                                        product_li += '<div class="add_to_wishlist" data-product="' + pdata['product_id'] + '">\
                                            <a class="wish-title" data-reveal-id="myModal2" id="wish1_' + pdata['product_id'] + '">AÑADIR A SU LISTA DE DESEOS <i class="fa fa-heart add_wishlist" id="wish_' + pdata['product_id'] + '"></i></a></div>';

                                        <?php }else{ ?>
                                        product_li +=  
                                            '<div class="add_to_wishlist" data-product="' + pdata['product_id'] + '">\
                                                <a class="wish-title" id="wish1_' + pdata['product_id'] + '">AÑADIR A SU LISTA DE DESEOS \
                                                <i class="fa fa-heart add_wishlist" id="wish_' + pdata['product_id'] + '"></i></a>\
                                            </div>';

                                        <?php } ?>

                                        product_li += '</div>';
                                        product_li += '<div class="sign-warp" id="sc_' + pdata['product_id'] + '">\
                                            <span class="sign-close">\
                                                <i class="fa fa-times-circle fa-lg"></i>\
                                            </span>\
                                            <div class="wishlist_success">\
                                                <p class="text" style="border:none;"></p>\
                                                <p class="wish"><i class="fa fa-heart"></i>Lista De Deseos</p>\
                                            </div>\
                                        </div>';
                                        if(pdata['mark']=='outstock'){
                                            product_li += '<span class="outstock">Sold Out</span>';
                                        }else if(pdata['mark']=='flash_sales'){
                                            product_li += '<i class="icon-fsale" id="mark_' + pdata['product_id'] + '"></i>';
                                        }else if(pdata['mark']=='ready_shippeds'){
                                            product_li += '<i class="" id="mark_' + pdata['product_id'] + '"></i>';
                                        }else if(pdata['mark']=='icon-new'){
                                            product_li += '<i class="icon-new" id="mark_' + pdata['product_id'] + '"></i>';
                                        }else{
                                            product_li += '<i class="" id="mark_' + pdata['product_id'] + '"></i>';
                                        }
                                    product_li += '</li>';
                                            
                                    $("#product_ul").append(product_li);
                                    $(".sign-close").click(function(){
                                    $(this).parent().hide();
                                        $(".overlay").hide();
                                    });
                                })
                                showis(showis_ids);
                            },
                            complete: function () {
                                $("#loading").hide();
                                $("#pagination").show();
                                $("img.lazy").lazyload({
                                    event: "scrollstop"
                                });
                            },
                        });  // end ajax
                    }
                    else
                    {
                        $("#pagination").show();
                    }
                }
                
            },500);

        })

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
                        $(".wish-title").removeAttr("data-reveal-id");
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
                                    $("#myModal2").hide();
                                    $(".reveal-modal-bg").hide();
                                     $("#wish1_"+pid).html("<i class='fa fa-heart red' id='wish_'"+ pid+"></i>");
                                    $("#wish_" + pid).attr('class', 'fa fa-heart red')
                                    _proItem.find(".overlay").show();
                                    _proItem.find(".sign-warp").show();
                                    _proItem.find('.sign-warp').find('.wishlist_success').find('.text').text(result.message);
                                }
                                else
                                {
                                    alert(result.message)
                               //     showup(result.message);
                                }
                            }
                        });
                    }
                    else
                    {
                        $("#customer_pid").text(pid);
/*                        var top = getScrollTop();
                        top = top - 35;
                        $('body').append('<div class="JS-filter1 opacity"></div>');
                        $('.JS-popwincon1').css({
                            "top": top, 
                            "position": 'absolute'
                        });
                        $('.JS-popwincon1').appendTo('body').fadeIn(320);
                        $('.JS-popwincon1').show();
            $("#email2").val('');
            $("#password2").val('');*/
                    }
                }
            });
            return false;
        })

        $(".pro-item .add-wish .red").live('click', function() {
            return false;
        });

        $("#form_login").submit(function(){
            var email = $("#email1").val();
            var password = $("#password1").val();
            var remember_me = 'on';
            if(typeof($("#remember_me1").attr('checked')) == 'undefined')
                remember_me = '';
            var pid = $("#customer_pid").text();
            $.ajax({
                url:'<?php echo LANGPATH; ?>/customer/ajax_login',
                type:'POST',
                dataType: "json",
                data:{
                    email: email,
                    password: password,
                    remember_me: remember_me,
                },
                success:function(rs){
                    if(rs.success == 1)
                    {
                        $(".wish-title").removeAttr("data-reveal-id");
                        var str="";
                         str +="<li class='drop-down JS-show'>";
                         str +="<div class='drop-down-hd'>";
                         str +="<i class='myaccount'></i>";
                         str +="<span>¡Hola, "+rs.firstname+"!</span>";
                         str +="</div>";
                         str +="<dl class='drop-down-list JS-showcon hide' style='display:none;'>";
                         str +="<dd class='drop-down-option'>";
                         str +="<a href='<?php echo LANGPATH; ?>/customer/summary'>Mi Cuenta</a>";
                         str +="</dd>";
                         str +="<dd class='drop-down-option'>";
                         str +="<a href='<?php echo LANGPATH; ?>/customer/orders'>Mis Pedidos</a>";
                         str +="</dd>";
                         str +="<dd class='drop-down-option'>";
                         str +="<a href='<?php echo LANGPATH; ?>/tracks/track_order'>Rastrear</a>";
                         str +="</dd>";
                         str +="<dd class='drop-down-option'>";
                         str +="<a href='<?php echo LANGPATH; ?>/customer/wishlist'>Mi Lista de Deseos</a>";
                         str +="</dd>";
                         str +="<dd class='drop-down-option'>";
                         str +="<a href='<?php echo LANGPATH; ?>/customer/profile'>Mi Perfil</a>";
                         str +="</dd>";
                         str +="<dd class='drop-down-option'>";
                         str +="<a href='<?php echo LANGPATH; ?>/customer/logout'>Salir</a>";
                         str +="</dd></dl></li>";
                            $("#customer_sign_in").html(str);
                            
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
                                    $("#myModal2").hide();
                                    $(".reveal-modal-bg").hide();
                                    $("#wish_" + pid).parent().find('span').text('');
                                    $("#wish_" + pid).attr('class', 'fa fa-heart red');
                                    $(".wishlist_success").show();
                                    $(".JS-filter1").remove();
                                    $(".JS-popwincon1").fadeOut(160);
                                    var _proItem = $("#sc_"+pid).parents(".pro-item");
                                    _proItem.find(".overlay").show();
                                    _proItem.find(".sign-warp").show();
                                    _proItem.find('.sign-warp').find('.wishlist_success').find('.text').text(result.message);
                                    getwishlist();
                                    
                                }else if(result.success == '-1'){
                                    var _proItem = $("#sc_"+pid).parents(".pro-item");
                                    $("#myModal2").hide();
                                    $(".reveal-modal-bg").hide();
                                    $("#wish1_"+pid).html("<i class='fa fa-heart red' id='wish_'"+ pid+"></i>");
                                    $("#wish_" + pid).attr('class', 'fa fa-heart red')
                                    _proItem.find(".overlay").show();
                                    _proItem.find(".sign-warp").show();
                                    _proItem.find('.sign-warp').find('.wishlist_success').find('.text').text(result.message);
                                    getwishlist();
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
            var remember_me = 'on';
            if(typeof($("#remember_me2").attr('checked')) == 'undefined')
                remember_me = '';
            var pid = $("#customer_pid").text();
            $.ajax({
                url:'<?php echo LANGPATH; ?>/customer/ajax_register',
                type:'POST',
                dataType: "json",
                data:{
                    email: email,
                    password: password,
                    confirm_password: password_confirm,
                    remember_me: remember_me,
                },
                success:function(rs){
                    if(rs.success == 1)
                    {
                        var str="";
                         str +="<li class='drop-down JS-show'>";
                         str +="<div class='drop-down-hd'>";
                         str +="<i class='myaccount'></i>";
                         str +="<span>¡Hola, Choieser!</span>";
                         str +="</div>";
                         str +="<dl class='drop-down-list JS-showcon hide' style='display:none;'>";
                         str +="<dd class='drop-down-option'>";
                         str +="<a href='<?php echo LANGPATH; ?>/customer/summary'>Mi Cuenta</a>";
                         str +="</dd>";
                         str +="<dd class='drop-down-option'>";
                         str +="<a href='<?php echo LANGPATH; ?>/customer/orders'>Mis Pedidos</a>";
                         str +="</dd>";
                         str +="<dd class='drop-down-option'>";
                         str +="<a href='<?php echo LANGPATH; ?>/tracks/track_order'>Rastrear</a>";
                         str +="</dd>";
                         str +="<dd class='drop-down-option'>";
                         str +="<a href='<?php echo LANGPATH; ?>/customer/wishlist'>Mi Lista de Deseos</a>";
                         str +="</dd>";
                         str +="<dd class='drop-down-option'>";
                         str +="<a href='<?php echo LANGPATH; ?>/customer/profile'>Mi Perfil</a>";
                         str +="</dd>";
                         str +="<dd class='drop-down-option'>";
                         str +="<a href='<?php echo LANGPATH; ?>/customer/logout'>Salir</a>";
                         str +="</dd></dl></li>";
                            $("#customer_sign_in").html(str);
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
                                    var _proItem = $("#sc_"+pid).parents(".pro-item");
                                    $("#myModal2").hide();
                                    $(".reveal-modal-bg").hide();
                                    $("#wish1_"+pid).html("<i class='fa fa-heart red' id='wish_'"+ pid+"></i>");
                                    $("#wish_" + pid).attr('class', 'fa fa-heart red')
                                    _proItem.find(".overlay").show();
                                    _proItem.find(".sign-warp").show();
                                    _proItem.find('.sign-warp').find('.wishlist_success').find('.text').text(result.message);
                                    getwishlist();
                                }
                                else
                                {
                                  //  showup(result.message);
                                    alert(result.message);
                                }
                            }
                        });
                        return false;
                    }
                    else
                    {
                      //  showup(rs.message);
                        alert(rs.message);
                    }
                }
            });
            return false;
        })

        //close wihlist_success
        $(".sign-close").click(function(){
            $(this).parent().hide();
            $(".overlay").hide();
        })
        
    })

    function showis(loaded_products)
    {
        
        $.ajax({
            type: "POST",
            url: "<?php echo LANGPATH; ?>/ajax/wishlist_data",
            dataType: "json",
            async : false,
            data: "product_ids=" + loaded_products,
            success: function(res){
                wishlistresult = res;
                for(var p in res){
                    var pid = res[p];
                    $("#wish_"+pid).removeClass('add_wishlist');
                    $("#wish_"+pid).addClass('red');
                    $("#wish1_"+pid).html("<i class='fa fa-heart red' id='wish_'"+ pid+"></i>");
                }
            }
        });
        return true;
        $.ajax({
            type: "POST",
            url: "<?php echo LANGPATH; ?>/ajax/more_color",
            dataType: "json",
            data: "product_ids=" + loaded_products,
            success: function(res){
                showcolorarr=res;
                for(var p in res){
                    var pid = res[p];
                    $("#more_color"+pid).show();
                }
            }
        }); 
            
        $.ajax({
            type: "POST",
            url: "<?php echo LANGPATH; ?>/ajax/marks_data?catalog_id=<?php echo $catalog_id;?>",
            data: "product_ids=" + loaded_products,
            dataType: "json",
            success: function(res){
                showmarksarr=res;
                    if(res['catalog']){
                        for(var p in res['catalog']){
                            if(res['catalog'][p]){
                                $("#mark_"+p).removeClass().addClass(res['catalog'][p]);
                            }
                        }
                    }
                    for(var p in res['product']){
                        if(res['product'][p].length){
                                $("#mark_"+p).removeClass().addClass(res['product'][p]);
                            }
                            
                    }
            }
        });   
            
        //ajax reviews
        $.ajax({
            type: "POST",
            url: "<?php echo LANGPATH;?>/ajax/review_data",
            dataType: "json",
            data: "product_ids=" + loaded_products,
            success: function(res){
                showreviewsarr=res;
                for(var p in res){
                    var review = res[p];
                    var rating = parseFloat(review['rating']);
                    var integer = parseInt(review['rating']);
                    var decimal = rating - integer;
                    var div = '<div class="reviews">';
                    
                    div += '<a href="' + review['plink'] + '#review_list">';
                    for(var r = 1;r <= integer;r ++)
                    {
                        div += '<i class="fa fa-star"></i>';
                    }
                    if(decimal > 0)
                    {
                        div += '<i class="fa fa-star-half-full"></i>';
                    }
                    div += '(' + review['quantity'] + ')';
                    div += '</a>';
                    div += '</div>';
                    $("#star_" + review['product_id']).html(div);
                }
            }
        }); 
    }
    
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
    
</script>

<script type="text/javascript">
    var google_tag_params = {
        ecomm_prodid: '',           //SKU
        ecomm_pagetype: 'category',         // product
        ecomm_totalvalue: ''       // 
    };
</script>
<!-- lazyload-12-14 -->
<script type="text/javascript" charset="utf-8" src="<?php echo STATICURL;?>/assets/js/lazyload-12-14.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo STATICURL;?>/assets/js/scrollstop.js"></script>
<script>
    $("img.lazy").lazyload({
        event: "scrollstop"
    });
</script>
