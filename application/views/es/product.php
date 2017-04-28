<?php
if (strripos($_SERVER["HTTP_USER_AGENT"], 'ipad'))
{
    ?>
    <style>
        .pro_lookwith .right{ width:450px;}
    </style>
    <?php
}
$product = Product::instance($product->id, LANGUAGE);
$plink = $product->permalink();
$product_name = $product->get('name');
$pprice = $product->price();
?>
<link rel="canonical" href="<?php echo $plink; ?>" />
<link type="text/css" rel="stylesheet" href="/css/product.css" media="all" id="mystyle" />
<meta property="og:title" content="<?php echo $product_name; ?> - Choies.com" />
<meta property="og:description" content="Shop <?php echo $product_name; ?> from choies.com .Free shipping Worldwide." />
<meta property="og:type" content="product" />
<meta property="og:url" content="<?php echo $plink; ?>" />
<meta property="og:site_name" content="Choies" />
<meta property="og:price:amount" content="<?php echo $pprice; ?>" />
<meta property="og:price:currency" content="USD" />
<meta property="og:availability" content="in stock" />
<?php echo View::factory(LANGPATH.'/sharewin/include'); ?>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Página de Inicio</a>
                <?php
                    $product_id = $product->get('id');
                if (!$current_catalog)
                    $current_catalog = $product->default_catalog();
                $crumbs = Catalog::instance($current_catalog, LANGUAGE)->crumbs();
                foreach ($crumbs as $crumb):
                    if ($crumb['id']):
                        ?>
                        >  <a href="<?php echo $crumb['link']; ?>" rel="nofollow" ><?php echo $crumb['name']; ?></a>
                        <?php
                    endif;
                endforeach;
                ?>
                >  <?php echo $product_name; ?>
            </div>
            <div class="flr"><a href="<?php echo $crumbs[0]['link'] ?>">Volver A <?php echo $crumbs[0]['name'] ?></a></div>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article class="pro_detail product_view fix">
            <?php
            $message = Message::get();
            echo $message;
            ?>
            <!-- pro_left -->
            <div class="pro_left fll" >
                <div id="gallery" class="fix" oncontextmenu="self.event.returnValue=false">
                    <?php
                    $cover = $product->cover_image();
                    ?>
                        <div id="JS_productPic" class="productpic loadding">
                            <?php if($product->get("extra_fee")==0){ ?>
                            <div class="myImages-icon"><img src="/images/icon_fressshipping.png" /></div>
                            <?php } ?>
                            <?php
                            if($show_ship_tip)
                                $ready_shippeds = DB::select('product_id')->from('catalog_products')->where('catalog_id', '=', 395)->execute()->as_array();
                            else
                                $ready_shippeds = array();
                            if(in_array(array('product_id' => $product_id), $ready_shippeds))
                            {
                                ?>
                                <div class="myImages-icon"><img src="/images/icon_ship24.png" /></div>
                                <?php
                            }
                            ?>
                            <div class="click-enlarge"><img src="/images/click-enlarge.png"></div>
                            <a href="<?php echo '/pimages1/' . $cover['id'] . '/9.' . $cover['suffix']; ?>" class="picbox img480">
                                <img src="<?php echo Image::link($cover, 2); ?>" id="picture" alt="<?php echo $product_name; ?>" title="<?php echo $product_name; ?>" />
                            </a>
                        </div>
                        <div class="firstthumbnail">
                            <span id="bigPrev" class="jiantou1"></span>
                            <span id="bigNext" class="jiantou2"></span>
                        </div>
                </div>
                <div class="hide">
                    <?php foreach ($product->images() as $key => $image): ?>
                        <img src="<?php echo Image::link($image, 2); ?>" />
                        <img src="<?php echo '/pimages1/' . $image['id'] . '/9.' . $image['suffix']; ?>" />
                    <?php endforeach; ?>
                </div>
                <div style="width:480px;">
                    <div id="JS_thumbnail" class="thumbnail clearfix">
                        <span id="JS_thumbnailPrev" class="trigger prev">prev</span>
                        <div id="JS_thumbnailSlide" class="thumbnail_slide">
                            <ul class="thumbnail_list">
                            <?php foreach ($product->images() as $key => $image): ?>
                                <li class="list_item <?php if($key == 0) echo 'selected'; ?>"><a class="img60"><img src="<?php echo Image::link($image, 3); ?>" imgb="<?php echo Image::link($image, 2); ?>" bigimg="<?php echo '/pimages1/' . $image['id'] . '/9.' . $image['suffix']; ?>" alt="" /></a></li>
                            <?php endforeach; ?>    
                            </ul>
                        </div>
                        <span id="JS_thumbnailNext" class="trigger next">next</span>
                    </div>
                    <div class="mb10" style="float: left;margin:10px 0 0 10px;height: 50px;width: 500px;overflow: hidden;"> 
                        <script type="text/javascript" src="http://akwww.polyvorecdn.com/rsrc/add_to_polyvore.js"></script>
                        <a target="_blank" href="http://www.polyvore.com" name="addToPolyvore" id="addToPolyvore" data-product-url="<?php echo $plink; ?>" data-image-url="<?php echo Image::link($cover, 2); ?>" data-name="<?php echo $product_name; ?>" data-price="$|<?php echo $pprice; ?>"><img src="http://www.polyvore.com/rsrc/icons/embed/AddToPolyvore_61x20.png"/></a>
                        <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
                        <script type="text/javascript">stLight.options({publisher: "76c0dd88-6e79-4e80-875e-7bc8934145b8", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
                        <span class='st_fblike_hcount' displayText='Facebook Like'></span>
                        <span class='st_facebook_hcount' displayText='Facebook'></span>
                        <span class='st_twitter_hcount' displayText='Tweet'></span>
                        <span class='st_tumblr_hcount' displayText='Tumblr'></span>
                        <span class='st_pinterest_hcount' displayText='Pinterest'></span>
                    </div>
                </div>
            </div>
            <!-- pro_right -->           
            <div class="pro_right flr">
                <dl>
                    <dd>
                        <h3><?php echo $product_name; ?></h3>
                        <div class="fix">
                            <p style="padding-bottom:12px;color:#999;">
                                <?php
                                $instock = 1;
                                $stock = $product->get('stock');
                                if (!$product->get('status') OR ($stock == 0 AND $stock != -99))
                                    $instock = 0;
                                if($stock == -1 AND empty($stocks))
                                {
                                    $instock = 0;
                                }
                                ?>
                            <span id="product_status" style="margin-right:15px;color:#000;"><?php echo $instock ? 'En Stock' : '<strong class="red">Fuera De Stock</strong>'; ?></span>
                            artículo#: <?php echo $product->get('sku'); ?>
                            <?php
                            if(!empty($brands))
                            {
                                ?>
                                <a target="_blank" href="<?php echo LANGPATH; ?>/brand/list/<?php echo $brands['id']; ?>" class="ml10"><i>por <?php echo $brands['name']; ?></i></a>
                                <?php
                            }
                            ?>
                            </p>
                            <?php if ($product->get('presell') > time()): ?>
                            <p>Preventa: <b class="red"><?php echo $product->get('presell_message'); ?></b></p>
                            <?php endif; ?>
                        </div>
                    </dd>
                    <dd class="fix info jiage" style="margin-top:15px;">
                        <div class="fll font11 ttr">
                        <p class="price">
                        <?php
                        //vip spromotions price | Table spromotions 'type' = '0:vip'
                        $vip_promotion_price = DB::select('price')
                            ->from('spromotions')->where('type', '=', 0)
                            ->where('product_id', '=', $product_id)
                            ->where('expired', '>', time() - 36000)
                            ->execute()->get('price');
                        $change_countries = array('CA', 'AU');
                        $currency_change = '';
                        if (isset($_GET['url_from']))
                        {
                            $currency = substr($_GET['url_from'], 0, 2);
                            if (in_array($currency, $change_countries))
                                $currency_change = $currency;
                        }
                        $p_price = $product->get('price');
                        $price = $product->price();
                        $customer_id = Customer::logged_in();
                        $customer = Customer::instance($customer_id);
                        $vip_level = $customer->get('vip_level');
                        if ($vip_level)
                        {
                            if($vip_promotion_price AND $vip_level >= 2)
                            {
                                if ($p_price > $price)
                                {
                                    $rate =  round((($p_price - $price) / $p_price) * 100);
                                    ?>
                                        <del><?php echo $currency_change; ?><span class="orign_price"><?php echo Site::instance()->price($p_price, 'code_view'); ?></span></del>   
                                        <span class="price_now">AHORA  <?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>  
                                        <i><?php if($rate > 0) echo $rate; ?>% MENOS</i>
                                    <?php
                                }
                            }
                            else
                            {
                                if ($customer->is_celebrity())
                                {
                                    if ($p_price > $price)
                                    {
                                        $rate =  round((($p_price - $price) / $p_price) * 100);
                                        ?>
                                            <del><?php echo $currency_change; ?><span class="orign_price"><?php echo Site::instance()->price($p_price, 'code_view'); ?></span></del>   
                                            <span class="price_now">AHORA  <?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>  
                                            <i><?php if($rate > 0) echo $rate; ?>% MENOS</i>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                            <span style="font-Tallas:24px;"><?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
                                        <?php
                                    }
                                }
                                else
                                {
                                    $vip = DB::select()->from('vip_types')->where('level', '=', $vip_level)->execute()->current();
                                    $vip_price = round($p_price * $vip['discount'], 2);
                                    if ($price < $vip_price)
                                        $vip_price = $price;
                                    $rate = round((($p_price - $price) / $p_price) * 100);
                                    ?>
                                    <?php
                                    if($p_price > $price)
                                    {
                                    ?>
                                        <del><?php echo $currency_change; ?><span class="orign_price"><?php echo Site::instance()->price($p_price, 'code_view'); ?></span></del>   
                                        <span class="price_now">AHORA  <?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>  
                                        <i><?php if($rate > 0) echo $rate; ?>% MENOS</i>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <span style="font-Tallas:24px;"><?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
                                    <?php
                                    }
                                    ?>
                                    VIP. Precio <?php echo $currency_change; ?><?php echo Site::instance()->price($vip_price, 'code_view'); ?>
                                    <?php
                                }
                            }
                        }
                        else
                        {
                            if ($p_price > $price)
                            {
                                $rate =round((($p_price - $price) / $p_price) * 100);
                                ?>
                                    <del><?php echo $currency_change; ?><span class="orign_price"><?php echo Site::instance()->price($p_price, 'code_view'); ?></span></del>   
                                    <span class="price_now"><?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>  
                                    <i><?php if($rate > 0) echo $rate; ?>% MENOS</i>
                                <?php
                            }
                            else
                            {
                                ?>
                                
                                    PRECIO: <span style="font-Tallas:24px;"><?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
                                <?php
                            }
                        }
                        ?>
                        </p>
                        <?php
                        if (!$customer_id)
                        {
                            ?>
                            <a href="<?php echo LANGPATH; ?>/customer/login?redirect=/product/<?php echo $product->get('link'); ?>_p<?php echo $product_id; ?>" style="text-decoration:underline;font:Arial, Helvetica, sans-serif;font-Tallas:11px;" class="pro_sign JS_popwinbtn1" id="sign_in">ACCEDER</a> por privilegio de VIP
                            <?php
                        }
                        ?>
                        <?php
                        //vip spromotions price
                        if($vip_promotion_price)
                        {
                            if($customer_id)
                            {
                                if($vip_level >= 2)
                                {
                                    ?>
                                        <strong style="color:#FF5200;">VIP. Precio <span style="font-size: 16px;"><?php echo $currency_change; ?><?php echo Site::instance()->price($vip_promotion_price, 'code_view'); ?></span></strong>
                                    <?php
                                }
                            }
                            else
                            {
                            ?>
                                <strong style="color:#FF5200;">VIP. Precio <span style="font-size: 16px;"><?php echo $currency_change; ?><?php echo Site::instance()->price($vip_promotion_price, 'code_view'); ?></span></strong>
                            <?php
                            }
                        }
                        ?>
                        </div>
                        <div class="flr">
                        <?php
                        $codetext = DB::select()->from('banners')->where('type', '=', 'product')->where('lang', '=', LANGUAGE)->where('visibility', '=', 1)->execute()->current();
                        if(!empty($codetext))
                        {
                        ?>
                            <a href="<?php echo $codetext['link']; ?>" target="_blank"><img src="/uploads/1/files/<?php echo $codetext['image']; ?>" alt="<?php echo $codetext['alt']; ?>" title="<?php echo $codetext['title']; ?>" /></a>
                        <?php
                        }
                        ?>
                        </div>
                    </dd>
                    <dd>
                        <?php
                        $flash_sale = DB::select('expired')->from('spromotions')->where('product_id', '=', $product->get('id'))->where('type', '=', 6)->where('expired', '>', time())->execute()->get('expired');
                        if($flash_sale)
                        {
                        ?>
                        <!-- time left -->
                        <div class="timeleft_box mb10">
                            <div class="JS_daoend hide">Fin</div>
                            <div class="JS_dao">Tiempo restante : <strong class="JS_RemainD"></strong>d <strong class="JS_RemainH"></strong>h <strong class="JS_RemainM"></strong>m <strong class="JS_RemainS"></strong>s</div>
                        </div>
                        <?php
                        }
                        ?>
                    </dd>
                    <dd class="last" style="margin-top:25px;">

                        <div  class="fix">   
                            <span class="fll">
                            <?php
                            $review_title = Kohana::config('review.' . LANGUAGE);
                            $overalls = explode('.', $reviews_data['overall']);
                            if(!isset($overalls[1]) || !$overalls[1])
                            {
                                $star_num = $overalls[0];
                                if($overalls[0] == 0)
                                    $star_class = 'rating_show1';
                                else
                                    $star_class = 'rating_show1 star' . $overalls[0];
                            }
                            else
                            {
                                $star_num = $overalls[0] + 0.5;
                                $star_class = 'rating_show1 star' . $overalls[0] . '5';
                            }
                            ?>
                                <strong class="<?php echo $star_class; ?>" ></strong>
                                <span class="reviews">(<a href="#review_list" style="font-weight:bold;font-Tallas:10px;"><?php $count_reviews = count($reviews); echo $count_reviews; ?></a>)</span>
                            </span>
                            <img src="/images/write1.jpg" style="margin-left:30px;"/>
                            <?php
                            if(!$customer_id)
                            {
                            ?>
                                <a target="_blank" href="#" class="text_underline JS_popwinbtn1" id="write_review" style="margin-left:10px;font-weight:bold;" >Escribir un comentario</a>
                            <?php
                            }
                            else
                            {
                                ?>
                                <a target="_blank" href="<?php echo LANGPATH; ?>/review/add/<?php echo $product_id; ?>" class="text_underline" style="margin-left:10px;font-weight:bold;" >Escribir un comentario</a>
                                <?php
                            }
                            ?>
                        </div>
                        <!-- time left -->
                        <form action="/cart/add" method="POST" id="formAdd">
                            <input type="hidden" name="id" value="<?php echo $product_id; ?>"/>
                            <input type="hidden" name="items[]" value="<?php echo $product_id; ?>"/>
                            <input type="hidden" name="type" value="<?php echo $product->get('type'); ?>"/>
                            <input type="hidden" name="psku" value="<?php echo $product->get('sku'); ?>"/>
                            <input type="hidden" name="price" value="<?php echo $product->get('price'); ?>"/>
                            <?php
                            if (!empty($attributes['size']))
                            {
                                ?>
                            <div class="size">
                                <div class="selected_box fix">
                                    <p class="left" style="font-weight:bold;">
                                        <span id="select_size">SELECCIONAR TALLA:</span> <span class="selected"></span>
                                        <span id="only_left" class="red ml10">&nbsp;</span>
                                    </p>
                                </div>
                                <input type="hidden" name="attributes[Size]" value="" class="s-size" />
                                <ul class="size_list fix" style="float:left;">
                                    <?php
                                    if (isset($attributes['size']))
                                    {
                                        if(count($attributes['size']) == 1)
                                        {
                                            $onesize = 1;
                                        }else{
                                            $onesize = 0;
                                        }
                                    }
                                    if (!empty($stocks))
                                    {
                                        foreach ($attributes['size'] as $attribute)
                                        {
                                            $attribute_name = $attribute;
                                            if(strtolower($attribute) == 'one size')
                                                $attribute_name = 'talla única';
                                            if(array_key_exists($attribute, $stocks))
                                            {
                                                if($stocks[$attribute] == 0)
                                                    echo '<li type="button" title="0" class="disable" id="' . $attribute . '" value="' . $attribute_name . '" disabled="disabled" ></li>';
                                                else
                                                    echo '<li title="' . $stocks[$attribute] . '" id="' . $attribute . '" class="btn_size_normal"><span>' . $attribute_name . '</span></li>';
                                            }
                                            else
                                                echo '<li title="0" class="disable" id="' . $attribute . '"><span>' . $attribute_name . '</span></li>';
                                        }
                                    }
                                    else
                                    {
                                        foreach ($attributes['size'] as $attribute)
                                        {
                                            $attribute_name = $attribute;
                                            if(strtolower($attribute) == 'one size')
                                                $attribute_name = 'talla única';
                                            echo '<li id="' . $attribute . '" class="btn_size_normal"><span>' . $attribute_name . '</span></li>';
                                        }
                                    }
                                    ?>              
                                </ul>
                                <?php
                                $clothes = array(
                                    3,4,5,6,17,18,19,21,22,23,31,270,298
                                );
                                $set_id = $product->get('set_id');
                                if(!in_array($set_id, $clothes))
                                {
                                ?>
                                    <span class="JS_popwinbtn2 fix" style="cursor:pointer;float:right;margin-top:3px;text-decoration: underline;font-weight: bold;">Tabla de tallas</span>
                                <?php
                                }
                                ?>
                                </div>
                                <script type="text/javascript">
                                    $(function(){
                                        $(".size_list li").live("click",function(){
                                            if($(this).attr('class') != 'btn_size_normal')
                                            {
                                                return false;
                                            }
                                            var value = $(this).attr('id');
                                            var qty = $(this).attr('title');
                                            $(".s-size").val(value);
                                            $(this).siblings().removeClass('on');
                                            $(this).addClass('on');
                                            $("#select_size").html('Talla: '+$(this).text());
                                            if(qty)
                                                $("#only_left").html('¡Sólo queda '+qty+'!');
                                        })
                                                                                                                                                            
                                        $('#addCart').live("click",function(){
                                            var size = $('.s-size').val();
                                            if(!size)
                                            {
                                                alert('POR FAVOR ' + $('#select_size').html());
                                                return false;
                                            }
                                        })
                                    })
                                </script>
                            <?php
                            }
                            if (!empty($attributes['color']))
                            {
                                ?>
                                <div class="color">
                                    <input type="hidden" name="attributes[Color]" value="" class="s-color" />
                                    <p class="selected_box"><span class="selected" id="select_color">SELECCIONAR COLOR:</span></p>
                                    <ul class="color_list fix">
                                        <?php
                                        foreach ($attributes['color'] as $attribute)
                                        {
                                            ?>
                                            <li>
                                                <em class="icon color_black"></em>
                                                <strong class="w_colorli"></strong>
                                                <div class="colorBox hide">
                                                    <p class="img"><img src="/images/color/<?php echo strtolower($attribute); ?>.jpg" /></p>
                                                    <p class="colorBoxcon">
                                                        <strong class="btn_size_normal" id="<?php echo $attribute; ?>"><?php echo $attribute; ?></strong> (Chiffon)
                                                    </p>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <script type="text/javascript">
                                    $(function(){
                                        $(".color_list .colorBoxcon strong").live("click",function(){
                                            if($(this).attr('class') != 'btn_size_normal')
                                            {
                                                return false;
                                            }
                                            var value = $(this).attr('id');
                                            $(".s-color").val(value);
                                            $(this).siblings().removeClass('btn_size_select');
                                            $(this).addClass('btn_size_select');
                                            $("#select_color").html('Color: '+$(this).val());
                                        })
                                                                                                                                                        
                                        $('#addCart').live("click",function(){
                                            size = $('.s-color').val();
                                            if(!size)
                                            {
                                                alert('POR FAVOR ' + $('#select_color').html());
                                                return false;
                                            }
                                        })
                                    })
                                </script>
                                <?php
                            }
                            if (!empty($attributes['type']))
                            {
                                ?>
                                <div id="select_type" class="mb10">SELECCIONAR Tipo:</div>
                                <div class="btn_type">
                                    <input type="hidden" name="attributes[Type]" value="" class="s-type" />
                                    <?php
                                    foreach ($attributes['type'] as $attribute)
                                    {
                                        echo '<input type="button" class="btn_size_normal" id="' . $attribute . '" value="' . $attribute . '" />';
                                    }
                                    ?>
                                </div>
                                <script type="text/javascript">
                                    $(function(){
                                        $(".btn_type input").live("click",function(){
                                            if($(this).attr('class') != 'btn_size_normal')
                                            {
                                                return false;
                                            }
                                            var value = $(this).attr('id');
                                            $(".s-type").val(value);
                                            $(this).siblings().removeClass('btn_size_select');
                                            $(this).addClass('btn_size_select');
                                            $("#select_type").html('Tipo: '+$(this).val());
                                        })
                                                                                                                                                    
                                        $('#addCart').live("click",function(){
                                            size = $('.s-type').val();
                                            if(!size)
                                            {
                                                alert('POR FAVOR ' + $('#select_type').html());
                                                return false;
                                            }
                                        })
                                    })
                                </script>
                                <?php
                            }
                            ?>
                            <div class="total">
                                <div class="same-paragraph">
                                    <ul class="color-choies">
                                        <li class="current-color"><img width="50" src="<?php echo Image::link($product->cover_image(), 3) ?>"><b class="on"></b></li>
                                    </ul>
                                </div>
                                <div style="display:none;">
                                <span class="font14" style="margin-left:8px;display:inline-block;">Cantidad:</span><br />
                                <div class="p_size" style="height:45px;">
                                    <select class="s_input" id="cart_quantity" style="width:50px;padding:4px;margin-top: 5px" name="quantity">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>     
                                </div>
                                </div>
                                <br>
                                <input type="submit" value="AÑADIR A BOLSA" id="addCart" class="btn40_16_red" style="font-Tallas:18px;<?php if(!$instock) echo 'display:none;'; ?>" />
                                <span class="btn40_16_gray" id="outofstock" style="font-Tallas:18px;<?php if($instock) echo 'display:none;'; ?>" />Fuera De Stock</span>
                                <a href="<?php echo LANGPATH; ?>/wishlist/add/<?php echo $product_id; ?>" class="view_btn btn40_1" style="margin: 0 0 5px 10px;background: none;border: none;text-decoration: underline;">
                                <?php
                                $wishlists = DB::select(DB::expr('COUNT(id) AS count'))
                                        ->from('accounts_wishlists')
                                        ->where('site_id', '=', 1)
                                        ->where('product_id', '=', $product_id)
                                        ->execute()->get('count');
                                ?>
                                LISTA DE DESEOS <?php echo $wishlists ? '(' . $wishlists . ' AÑADIDO)' : ''; ?>
                                </a>
                                <div class="same-paragraph same-paragraph1">
                                    <label>MÁS COLORES:</label>
                                    <div id="same_paragraph"></div>
                                </div>
                            </div>
                        </form>
        <script>
          $(function(){
              $("#sbtn").hover(function(){
                   $(".swrp").show();
              },function(){
                   $(".swrp").hide();
              });
              $(".swrp").hover(function(){
                   $(this).show();
              },function(){
                   $(this).hide();
              }); 
          }) 
          </script>
                        <ul class="JS_tab detail_tab fix">
                            <li class="current ss1" style="width: 90px;margin: 0 0 -1px 0;">Detalles</li>
                            <?php
                            $models = '';
                            if($product->get('model_size'))
                            {
                                $models .= 'Talla de Modelo: ' . $product->get('model_size') . '<br><br>';
                            }
                            $model_id = $product->get('model_id');
                            if($model_id)
                            {
                                $modelArr = DB::select()->from('models')->where('id', '=', $model_id)->execute()->current();
                                if(!empty($modelArr))
                                {
                                    $models .= 'Modelo:<br>';
                                }
                                $models .= 'Nombre:' . $modelArr['name'] . '<br>';
                                $ft = 0.0328084;
                                $in = 0.3937008;
                                $height_ft = round($modelArr['height'] * $ft, 1);
                                $height_ft = str_replace(".", "'", $height_ft);
                                $height_ft .= '"';
                                $bust_in = round($modelArr['bust'] * $in, 1);
                                $waist_in = round($modelArr['waist'] * $in, 1);
                                $hip_in = round($modelArr['hip'] * $in, 1);
                                $models .= 'Altura: ' . $height_ft .' | Busto: ' . $bust_in . ' | Cintura: ' . $waist_in . ' | Cadera: ' . $hip_in . '<br>';
                                $models .= 'Altura: ' . $modelArr['height'] . ' cm | Busto: ' . $modelArr['bust'] . ' cm | Cintura: ' . $modelArr['waist'] . ' cm | Cadera: ' . $modelArr['hip'] . ' cm' . '<br>';
                            }
                            if($models)
                            {
                                ?>
                                <li class="ss2" style="width: 90px;margin: 0 0 -1px 0;">MODELO</li>
                                <?php
                            }
                            ?>
                            <li class="ss3" style="width: 90px;margin: 0 0 -1px 0;">Envío </li>
                            <li class="ss4" style="width: 90px;margin: 0 0 -1px 0;">Contacto</li>
                            <p><b></b></p>
                        </ul>
                        <div class="JS_tabcon detail_tabcon">
                            <div class="bd">
                                <?php
                                $keywords = $product->get('keywords');
                                if($keywords)
                                {
                                    echo '<p class="red">';
                                    echo str_replace("\n", "<br>", $keywords) . '<br><br>';
                                    echo '</p>';
                                }
                                $sortArr_en = Kohana::config('sorts.en');
                                $sortArr_small = Kohana::config('sorts.' . LANGUAGE);
                                if (!empty($filter_sorts))
                                {
                                    echo '<table width="100%" class="pro_style_table">';
                                    foreach ($filter_sorts as $name => $sort)
                                    {
                                        $en_name = strtolower($name);
                                        if(in_array($en_name, $sortArr_en))
                                        {
                                            $small_key = array_keys($sortArr_en, $en_name);
                                            $small_name = $sortArr_small[$small_key[0]];
                                        }
                                        else
                                            $small_name = $name;
                                        echo '<tr><td width="40%"><p>' . strtoupper($small_name) . ':</p></td><td width="60%"><p>' . ucfirst($small_filter[strtolower($sort)]) . '</p></td></tr>';
                                    }
                                    echo '</table>';
                                    echo '<br>';
                                }    
								$brief = $product->get('brief');
                                $brief = str_replace(';', '<br>', $brief);
                                $brief = str_replace(array('One size', 'one size', 'One Size'), array('talla única'), $brief);
                                echo $brief;?>
								<span class="JS_popwinbtn2 fix" style="cursor:pointer;margin-top:3px;text-decoration: underline;font-weight: bold;">Tabla de tallas</span>
								<?php
								if($has == 0){
									$description = $prodes;
									$description = str_replace(';', '<br>', $description);
									echo $description;
								}else{
								$description = $product->get('description');
                                $description = str_replace(';', '<br>', $description);
                                if($description)
                                    echo $description;
								}
                                ?>
                                
                            </div>
                            <?php
                            if($models)
                            {
                            ?>
                            <div class="bd hide">
                                <?php
                                echo '<p>' . $models . str_replace("\n", "<br>", $keywords) . '</p><br><br>';
                                ?>
                            </div>
                            <?php
                            }
                            ?>
                            <div class="bd hide">
                                <p style="color:#F00;">Tiempo Recibido= tiempo de preparación(3-5 dias laborables) + Duración del transporte</p>
                                <h4>Envío:</h4>
                                <p>(1)  Envío gratuito por todo el mundo(10-15 dias laborables)</p>
                                <p style="color:#F00; padding-left:18px;">Sin compra mínima requerida.</p>
                                <p>(2)  <?php echo Site::instance()->price(15, 'code_view'); ?> El envío expreso(4-7 dias laborables)</p>
                                <p style="padding-left:18px;">Ver más en <a class="a_red" href="<?php echo LANGPATH; ?>/shipping-delivery" title="envío y entrega">envío y entrega</a>.</p>
                                <h4>La Política De Devolución:</h4>
                                <p>Para <span class="red">traje de baño y ropa interior</span>, si no hay un problema de calidad, no ofrecemos servicio de devolución o cambio <a class="a_red" href="<?php echo LANGPATH; ?>/returns-exchange" title="la política de devolución">la política de devolución</a>.</p>
                                <h4>Atención Adicional:</h4>
                                <p>Los pedidos pueden estar sujetos a derechos de importación, si usted no quiere pagar el impuesto adicional por su aduana local, póngase en contacto con nosotros, vamos a utilizar Correos de Hong Kong. </p>
                            </div>
                            <div class="bd hide">
                                <div class="LiveChat2  mt15 pl10">
                                    <a href="#" onclick="psSMPPow(); return false;"><img name="psSMPPimage" src="http://www.choies.com/images/livechat_online1.gif" border="0" /> Live chat</a>
                                </div>
                                <div class="LiveChat2 mt10 pl10"><a href="mailto:service_es@choies.com"><img src="/images/livemessage.png" alt="Dejar Un Mensaje" /> Dejar Un Mensaje</a></div>
                                <div class="LiveChat2 mt10 pl10"><a href="<?php echo LANGPATH; ?>/faqs" target="_blank"><img src="/images/faq.png" alt="FAQ" /> FAQ</a></div>
                            </div>
                        </div>
                    </dd>
                </dl>
            </div>

        </article> 
        <?php
        if(!empty($celebrity_images) || ($product->get('has_link') == 1 AND !empty($link_images)) || (isset($videos) AND !empty($videos)))
        {
        ?>
        <article class="buyshow_box layout fix">
            <div class="w_tit layout">
                <ul class="fix dingbu" style="float:left;">
                    <?php if(!empty($celebrity_images)): ?>
                    <li class="current">SHOW DE COMPRADOR</li>
                    <?php endif; ?>
                    <?php if ($product->get('has_link') == 1 AND !empty($link_images)): ?>
                    <li <?php if(empty($celebrity_images)) echo 'class="current"'; ?>>CONSEGUIR EL LOOK</li>
                    <?php endif; ?>
                    <?php if (isset($videos) AND !empty($videos)): ?>
                    <li <?php if ($product->get('has_link') == 0 AND empty($link_images) AND empty($celebrity_images)) echo 'class="current"'; ?>>VÍDEO CLIENTE</li>
                    <?php endif; ?>
                    <p><b></b></p>
                </ul>
            </div>
            <?php
            if(!empty($celebrity_images))
            {
            ?>
            <div class="product_carousel fix ts">
                <ul class="fix tt" style="float:left;width:1024px;">
                <?php
                $celebrity_lists = array();
                $count = count($celebrity_images);
                $cel_num = $count > 8 ? 8 : $count;
                for($i = 0;$i < $cel_num;$i ++)
                {
                    $c_image = $celebrity_images[$i];
                    $cel_id = (int) $c_image['link_sku'];
                    if($cel_id AND !in_array($cel_id, $celebrity_lists))
                    {
                        $celebrity_lists[] = $cel_id;
                    }
                ?>
                    <li>
                        <a target="_blank" href="<?php echo LANGPATH; ?>/lookbook/<?php echo $c_image['id']; ?>-1" <?php if($i % 8 == 0){ echo 'style="display:block;"'; }elseif($i % 4 == 3){ echo 'style="margin:0;"'; } ?>>
                            <img src="http://img.choies.com/simages/<?php echo $c_image['image']; ?>" />
                        </a>
                    </li>
                <?php
                }
                $grey = (8 - $cel_num) % 4;
                for($i = 1;$i <= $grey;$i ++)
                {
                    ?>
                    <li>
                        <img src="/images/bantou.jpg" />
                    </li>
                    <?php
                }
                ?>
                </ul>
                <?php
                if($count > 8)
                {
                    ?>
                    <ul class="fix qwe" style="display:none;">
                        <?php
                        for($j = 8 * $i;$j < $count;$j ++)
                        {
                            if($j >= $count)
                                continue;
                            $c_image = $celebrity_images[$j];
                            $cel_id = (int) $c_image['link_sku'];
                            if($cel_id AND !in_array($cel_id, $celebrity_lists))
                            {
                                $celebrity_lists[] = $cel_id;
                            }
                        ?>
                            <li>
                                <a target="_blank" href="<?php echo LANGPATH; ?>/lookbook/<?php echo $c_image['id']; ?>-1" <?php if($j % 8 == 0){ echo 'style="display:block;"';}elseif($j % 4 == 3){ echo 'style="margin:0;"'; } ?>>
                                    <img src="http://img.choies.com/simages/<?php echo $c_image['image']; ?>" />
                                </a>
                            </li>
                        <?php
                        }
                        $grey = 4 - $count % 4;
                        if($grey == 4)
                            $grey = 0;
                        for($k = 1;$k <= $grey;$k ++)
                        {
                            ?>
                            <li>
                                <img src="/images/bantou.jpg" />
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <?php
                    echo '<div class="view1 fix"><p>Ver Más+</p></div>';
                }
                ?>
            </div>
            <?php
            }
            ?>
            
            <?php
            if ($product->get('has_link') == 1 AND !empty($link_images))
            {
            ?>
                <div class="pro_lookwith fix ts <?php if(!empty($celebrity_images)) echo 'hide'; ?>" style="width:1024px;height:auto;margin:0 auto;overflow: hidden;">
                    <div style="float:left;">
                        <?php foreach ($link_images as $key => $link_img) : ?>
                            <ul class="fix" style="height:493px;<?php if($key > 0) echo 'display:none;'; ?>">
                                <li style="float:left;"><img src="http://img.choies.com/simages/<?php echo $link_img['image']; ?>" width="370px"/></li>
                                <li style="overflow: hidden; float: left; width: 613px; height: 510px;">
                                    <div class="fix">
                                        <?php
                                        $skus = explode(',', $link_img['link_sku']);
                                        if (is_array($skus)):
                                            $n = 1;
                                            foreach ($skus as $sku):
                                                $pro_id = Product::get_productId_by_sku(trim($sku));
                                                $link_pro = Product::instance($pro_id, LANGUAGE);
                                                if (!$link_pro->get('visibility'))
                                                {
                                                    continue;
                                                }
                                                if ($n > 8)
                                                {
                                                    break;
                                                }
                                                $n++;
                                                ?>
                                                <div class="fashion_code">
                                                    <?php
                                                    $orig_price = round($link_pro->get('price'), 2);
                                                    $price = round($link_pro->price(), 2);
                                                    ?>
                                                    <a href="<?php echo $link_pro->permalink(); ?>" target="_blank"><img title="<?php echo $link_pro->get('name'); ?>" alt="<?php echo $link_pro->get('name'); ?>" src="<?php echo Image::link($link_pro->cover_image(), 7); ?>" /></a>
                                                    <p class="price center">
                                                        <?php
                                                        if ($orig_price > $price)
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
                                                </div>
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </div>
                                    <p class="fix"><a class="btn40_16_red flr JS_popwinbtn4" title="<?php echo $key; ?>">CONSEGUIR EL LOOK</a></p>
                                </li>
                            </ul>
                        <?php endforeach; ?>
                        <?php
                        if($key > 0)
                        {
                            ?>
                            <a class="view_more flr mr15" onclick="$('.pro_lookwith .fix').show();$(this).hide();">Ver Más+</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            }
            ?>

            <div class="buyers_sho fix JS_imgbox ts <?php if (($product->get('has_link') == 1 AND !empty($link_images)) || !empty($celebrity_images)) echo 'hide'; ?>">
            <?php
            if (isset($videos) AND !empty($videos))
            {
            ?>
                <div class="img_big fll">
                    <?php
                    foreach ($videos as $key => $video):
                        ?>
                        <div id="video<?php echo $key; ?>" <?php if ($key > 0) echo ' style="display:none;"' ?>>
                            <object type="application/x-shockwave-flash" style= "width:600px; height:350px; border: #333 1px solid; margin-bottom:5px;"
                                    data="http://www.youtube.com/v/<?php echo $video['url_add']; ?>?">
                                <param name="movie" value="http://www.youtube.com/v/<?php echo $video['url_add']; ?>?"/>
                            </object>
                        </div>
                        <?php
                    endforeach;
                    ?>
                </div>
                <div class="right flr">
                    <div id="scrollTest">
                        <ul class="JS_pro_small">
                            <?php
                            foreach ($videos as $key => $video):
                                $url = substr($video['url_add'], 0, 11);
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, 'http://gdata.youtube.com/feeds/api/videos/' . $url);
                                curl_setopt($ch, CURLOPT_HEADER, 0);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                                $response = curl_exec($ch);
                                curl_close($ch);
                                if (strpos($response, 'xml') === FALSE)
                                    continue;
                                if ($response)
                                {
                                    $xml = new SimpleXMLElement($response);
                                    $title = (string) $xml->title;
                                    $author = (string) $xml->author->name;
                                }
                                else
                                {
                                    $title = "No Title";
                                    $author = "No author";
                                }
                                ?>
                                <li class="fix current" title="video<?php echo $key; ?>">
                                    <div class="img"><img height="100px" src="http://i1.ytimg.com/vi/<?php echo $video['url_add']; ?>/mqdefault.jpg" imgb="" /></div>
                                    <div class="con">
                                        <p class="tit"><?php echo $title; ?></p>
                                        <p class="name">by: <?php echo $author; ?></p>
                                    </div>
                                </li>
                                <?php
                            endforeach;
                            ?>
                            <!-- only one -->
                            <li class="less">
                                <a href="<?php echo LANGPATH; ?>/blogger/programme">
                                    Haben Sie einen Mode-Blog? Begleiten Sie an Choies!<br />
                                    Fashion Blogger Programm JETZT! >>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
                <script type="text/javascript" src="/js/scroll.js"></script>
                <script>
                    window.onload = function(){
                        var a = skyScroll( {
                            target : 'scrollTest',
                            width:387,
                            height:361
                        });
                    };  
                </script>
                <script>
                    $(function(){
                        $(".JS_pro_small li").live("click",function(){
                            var src = $(this).find("img").attr("imgb");
                            var video = $(this).attr("title");
                            if(src!=null&&src!=undefined&&src!=""){
                                var bigimgSrc = $(this).find("img").attr("bigimg");
                                $(this).parents(".JS_imgbox").find(".JS_pro_img").loadthumb({src:src}).attr("bigimg",bigimgSrc);
                                $("#"+video).show().siblings().hide();
                                $(this).addClass("current").siblings().removeClass("current");
                                return false;
                            }
                                
                        });
                        $(".JS_pro_small li:nth-child(1)").trigger("click");
                    })
                </script>
            <?php
            }
            ?>
            </div>
            <script type="text/javascript">
                $(document).ready(function() {
                    $(".view1 p").click(function() {
                        $(".qwe").toggle();  
                        var text = $(".view1 p").text();
                        if(text == 'Ver Más+')
                        {
                            $(".view1 p").text("Ver Menos-");
                        }
                        else if(text == 'Ver Menos-')
                        {
                            $(".view1 p").text("Ver Más+");
                        }
                    })
                });
            </script>
            <script type="text/javascript">
                $(function(){
                    $(".JS_popwinbtn4").click(function(){
                        var id = $(this).attr('title');
                        $("#form" + id).show().siblings().hide();
                    })
                })
            </script>
            <div class="JS_popwincon4 popwincon hide">
                <a class="JS_close5 close_btn2"></a>
                <!-- look_box -->
                <div class="look_pro">
                    <?php
                    foreach ($link_images as $key => $link_img)
                    {
                        $skus = explode(',', $link_img['link_sku']);
                        if (!empty($skus))
                        {
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
                                            $link_pro = Product::instance($pro_id, LANGUAGE);
                                            if (!$link_pro->get('visibility'))
                                            {
                                                continue;
                                            }
                                            if ($n > 5)
                                            {
                                                break;
                                            }
                                            $n++;
                                            $wishlist[] = $pro_id;
                                            $orig_price = round($link_pro->get('price'), 2);
                                            $price = round($link_pro->price(), 2);
                                            $sku_link = $link_pro->permalink();
                                            ?>
                                            <li>
                                                <input type="checkbox" name="check[<?php echo $n; ?>]" title="size<?php echo $n; ?>" class="checkbox" checked="checked" id="checkout<?php echo $pro_id . $key; ?>" /> <label for="checkout<?php echo $pro_id . $key; ?>">AÑADIR A BOLSA</label>
                                                <input type="hidden" name="item[<?php echo $n; ?>]" value="<?php echo $pro_id; ?>" />
                                                <a href="<?php echo $sku_link; ?>"><img src="<?php echo Image::link($link_pro->cover_image(), 7); ?>" /></a>
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
                                                <p class="select">Tallas: 
                                                    <select name="size[<?php echo $n; ?>]" class="size_select" <?php if(!$instock) echo 'disabled="disabled"'; ?>>
                                                        <?php
                                                        $is_onesize = 0;
                                                        $set = $link_pro->get('set_id');
                                                        if(!empty($pro_stocks))
                                                        {
                                                            echo '<option>Elegir Talla</option>';
                                                            foreach($pro_stocks as $size => $p)
                                                            {
                                                                $sizeval = $size;
                                                                if($set == 2)
                                                                {
                                                                        $sizeArr = explode('/', $size);
                                                                        $sizeval = $sizeArr[2];
                                                                }
                                                            ?>
                                                            <option value="<?php echo str_replace('EUR', '', $sizeval); ?>" ><?php echo $sizeval; ?> <span class="red">(Sólo queda <?php echo $p; ?>)</span></option>
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
                                                                echo '<option>Elegir Talla</option>';
                                                            foreach ($attributes['Size'] as $size)
                                                            {
                                                                $sizeval = $size;
                                                                if($set == 2)
                                                                {
                                                                        $sizeArr = explode('/', $size);
                                                                        $sizeval = $sizeArr[2];
                                                                }
                                                                $sizeSmall = str_replace(array('One size', 'one size', 'One Size'), 'talla única', $sizeval);
                                                                ?>
                                                                    <option value="<?php echo str_replace('EUR', '', $sizeval); ?>" ><?php echo $sizeSmall; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $is_onesize = 1;
                                                            ?>
                                                            <option value="one size" <?php if (isset($pro_stocks['one size'])) echo 'title="' . $pro_stocks['one size'] . '"' ?>>talla única</option>
                                                            <?php
                                                        }
                                                        }
                                                        ?>
                                                    </select>
                                                    <input type="hidden" class="size_input" name="size<?php echo $n; ?>" value="<?php if($is_onesize) echo 1; ?>" />
                                                </p>
                                                <p class="select">CANTIDAD: <input type="text" class="text" name="qty[<?php echo $n; ?>]" value="1" <?php if(!$instock) echo 'disabled="disabled"'; ?> /></p>
                                                <p class="center"><a href="<?php echo $sku_link; ?>" class="btn22_gray" target="_blank">VER DETALLES</a></p>
                                                <?php
                                                if (!$instock)
                                                    echo '<span class="outstock">Fuera De Stock</span>';
                                                ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="center mt50">
                                    <input type="submit" value="AÑADIR A BOLSA" class="btn40_16_red" /><a href="<?php echo LANGPATH; ?>/wishlist/add_more/<?php echo implode('-', $wishlist); ?>" class="a_underline add_wishlist">LISTA DE DESEOS</a>
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
                                                    size0: {
                                                        required:"Campo requerido",
                                                    },
                                                    size1: {
                                                        required:"Campo requerido",
                                                    },
                                                    size2: {
                                                        required:"Campo requerido",
                                                    },
                                                    size3: {
                                                        required:"Campo requerido",
                                                    },
                                                    size4: {
                                                        required:"Campo requerido",
                                                    },
                                                    size5: {
                                                        required:"Campo requerido",
                                                    },
                                                    size6: {
                                                        required:"Campo requerido",
                                                    },
                                                    size7: {
                                                        required:"Campo requerido",
                                                    }
                                                },
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
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </article>
        <?php
        }
        ?>
        <article class="product_reviews" id="alsoview" style="display:none">
        <div class="w_tit layout"><h2>Los clientes también han visitado</h2></div>
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
            <script type="text/javascript">
        // Request personalized recommendations.
        ScarabQueue.push(['recommend', {
            logic: 'RELATED',
            limit: 24,
            containerId: 'personal-recs',
            templateId: 'simple-tmpl',
            success: function(SC, render) {
                var psku="";
                for (var i = 0, l = SC.page.products.length; i < l; i++) {
                    var product = SC.page.products[i]; 
                    psku+=product.id+",";
                }
                var pdata=[];
                render(SC);
                $.ajax({
                        type: "POST",
                        url: "/site/emarsysdata",
                        dataType: "json",
                        data:"sku="+psku+"&lang=<?php echo LANGUAGE; ?>",
                        success: function(data){
                                for(var o in data){
                                    $("#em"+o+"link").attr("href",data[o]["link"]);
                                    $("#em"+o+"price").html(data[o]["price"]);
                                    if(data[o]["show"]==0){
                                        $("#em"+o).css('display','none');
                                    }
                                }
                        }
                });
                
                if(SC.page.products.length>0){
                    keyone = Math.ceil(SC.page.products.length/6);
                    for (var j=keyone; j <= 4; j++) {
                       $("#circle"+j).hide(); 
                    }
                    $("#alsoview").show();
                }else{
                    $("#alsoview").hide();
                }  
            }
        }]);
        </script>  
            <div class="box-current1">
              <ul>
                <li class="on"></li>
                <li id="circle1"></li>
                <li id="circle2"></li>
                <li id="circle3"></li>
              </ul>
            </div>
        </div>
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
        <article class="wufeng layout">
        <div class="box-title">
                    <ul>
                        <li class="current">FLASH SALE</li>
                        <li class="">Novedades</li>
                        <li class="">Los Más Vendidos</li>
                        <li class="">Comentado Recientemente</li>
                    </ul>
                    <p style="left: 180px;">
                        <img src="/images/sanjiao.gif" width="14" height="7">
                    </p>
                </div>
            <div class="box-dibu">
                <div id="personal-recs">
                    <div class="hide-box_0">
                        <ul style="width: 1024px;float:left;" id="gd_box">
                        <?php
                        $key = 0;
                        if(!empty($flash_sales))
                        {
                            foreach($flash_sales as $flash)
                            {
                                $flash_name = Product::instance($flash['product_id'], LANGUAGE)->get('name');
                                $flash_link = Product::instance($flash['product_id'])->get('link');
                                ?>
                                <li> 
                                    <a href="<?php echo LANGPATH; ?>/product/<?php echo $flash_link . '_p' . $flash['product_id']; ?>"> 
                                        <img src="<?php echo Image::link(Product::instance($flash['product_id'])->cover_image(), 7); ?>" alt="<?php echo $flash_name; ?>">
                                    </a>
                                    <p class="price fix">
                                        <b><?php echo Site::instance()->price($flash['price'], 'code_view'); ?></b>    
                                        <?php
                                        if (Product::instance($flash['product_id'])->get('has_pick'))
                                            echo '<span class="icon_pick"></span>';
                                        ?>
                                    </p>
                                </li>
                                <?php
                            }
                        }
                        elseif(!empty($related_products))
                        {
                            foreach($related_products as $pid)
                            {
                                if (!Product::instance($pid)->get('visibility') OR !Product::instance($pid)->get('status'))
                                    continue;
                                else
                                    $key++;
                                if ($key == 7)
                                    break;
                                $relate_name = Product::instance($pid, LANGUAGE)->get('name');
                                $relate_link = Product::instance($pid)->get('link');
                                ?>
                                <li> 
                                    <a href="<?php echo LANGPATH; ?>/product/<?php echo $relate_link . '_p' . $pid; ?>"> 
                                        <img src="<?php echo Image::link(Product::instance($pid)->cover_image(), 7); ?>" alt="<?php echo $relate_name; ?>">
                                    </a>
                                    <p class="price fix">
                                        <b><?php echo Site::instance()->price(Product::instance($pid)->price(), 'code_view'); ?></b>    
                                        <?php
                                        if (Product::instance($pid)->get('has_pick'))
                                            echo '<span class="icon_pick"></span>';
                                        ?>
                                    </p>
                                </li>
                                <?php
                            }
                        }
                        ?>
                        </ul>
                    </div>
                    <div class="hide-box_1 hide">
                        <ul style="width: 1024px;float:left; " id="gd_box">
                        <?php
                        $news = array();
                        $from = time() - 14 * 86400;
                        $to = time();
                        $news = DB::query(Database::SELECT, 'SELECT id, name, link, price, has_pick FROM products WHERE set_id = ' . $product->get('set_id') . ' AND visibility = 1 AND status=1 AND stock <> 0 ORDER BY display_date DESC LIMIT 0, 6')->execute();
                        foreach($news as $pdetail)
                        {
                            ?>
                            <li> 
                                <a href="<?php echo LANGPATH; ?>/product/<?php echo $pdetail['link'] . '_p' . $pdetail['id']; ?>"> 
                                    <img src="<?php echo Image::link(Product::instance($pdetail['id'])->cover_image(), 7); ?>" alt="<?php echo $pdetail['name']; ?>">
                                </a>
                                <p class="price fix">
                                    <b><?php echo Site::instance()->price(Product::instance($pdetail['id'])->price(), 'code_view'); ?></b>    
                                    <?php
                                    if ($pdetail['has_pick'])
                                        echo '<span class="icon_pick"></span>';
                                    ?>
                                </p>
                            </li>
                            <?php
                        }
                        ?>
                        </ul>
                    </div>
                    <div class="hide-box_2 hide">
                        <ul style="width: 1024px;float:left; " id="gd_box">
                        <?php
                        $hots = array();
                        $hots = DB::query(Database::SELECT, 'SELECT product_id FROM catalog_products WHERE catalog_id = 32 ORDER BY position DESC LIMIT 0, 6')->execute();
                        foreach($hots as $h)
                        {
                            $hproduct = Product::instance($h['product_id'], LANGUAGE);
                            ?>
                            <li> 
                                <a href="<?php echo $hproduct->permalink(); ?>"> 
                                    <img src="<?php echo Image::link($hproduct->cover_image(), 7); ?>" alt="<?php echo $hproduct->get('name'); ?>">
                                </a>
                                <p class="price fix">
                                    <b><?php echo Site::instance()->price($hproduct->price(), 'code_view'); ?></b>    
                                    <?php
                                    if ($hproduct->get('has_pick'))
                                        echo '<span class="icon_pick"></span>';
                                    ?>
                                </p>
                            </li>
                            <?php
                        }
                        ?>
                        </ul>
                    </div>
                    <div class="hide-box_3 hide">
                        <ul style="width: 1024px;float:left;" id="recent_view">
                        </ul>
                    </div>
                </div>
                <div class="box-current">
                    <ul>
                        <li class="on"></li>
                        <li class=""></li>
                        <li class=""></li>
                        <li class=""></li>
                    </ul>
                </div>
            </div>
        </article>
        <div id="review_list"></div>
        <article class="product_reviews" style="margin-top:30px;">
            <div class="w_tit layout" style="margin-bottom:30px"><h2>COMENTARIOS DE CLIENTE</h2></div>
            <?php
            if(empty($reviews))
            {
            ?>
                <div style="text-align:center; margin-bottom:-40px;">
                    <img src="/images/product-detail_hongxin.jpg" /><span style="font-weight:bold; margin-left:10px;font-Tallas:16px;">0</span><span style=" margin-left:5px;font-Tallas:16px;">Comentarios</span>
                    <p style="margin-top:15px;font-Tallas:14px;">SEA EL PRIMERO PARA COMPARTIR SU COMENTARIO</p>
                    <?php
                    if(!$customer_id)
                    {
                    ?>
                        <a class="JS_popwinbtn1 btn40_16_red" id="write_review1" href="javascript:void(0)" style="margin-top:18px;margin-bottom:100px; cursor:pointer;">Escribir un comentario</a>
                    <?php
                    }
                    else
                    {
                        ?>
                        <a target="_blank" class="btn40_16_red" href="<?php echo LANGPATH; ?>/review/add/<?php echo $product_id; ?>" style="margin-top:18px;margin-bottom:100px; cursor:pointer;">Escribir un comentario</a>
                        <?php
                    }
                    ?>
                </div>
            <?php
            }
            else
            {
                ?>
                <div style="margin:0 0 20px 0;padding:10px 0 ; background-color:#fafafa;border:1px solid #CCC">
                    <div class="rating" style="margin:10px 0 0 0;">
                        <span class="s1" style="margin-left:30px;font-weight:bold;">
                            <strong class="<?php echo $star_class; ?>"></strong>EVALUACIÓN MEDIA
                        </span>
                        <span class="s1" style="margin-left:20px;font-weight:bold;">Clasificación de Calidad: <div class="outbt"><div style="width:<?php echo round($reviews_data['quality'] / 0.05, 2); ?>%;background:#f8b500;" class="inbt"></div></div></span>
                        <span class="s1" style="margin-left:20px;font-weight:bold;">Clasificación de Precio: <div class="outbt"><div style="width:<?php echo round($reviews_data['price'] / 0.05, 2); ?>%;background:#f8b500;" class="inbt"></div></div></strong></span>
                        <span class="s1" style="margin-left:20px;font-weight:bold;">Idoneidad: </span><span> <?php echo $review_title['fitness'][ceil($reviews_data['fitness'])]; ?></span>
                    </div>
                    <div style="margin:0 0 15px 0;">
                        <span class="s2" style="margin-left:139px;font-weight:bold;"><?php echo $reviews_data['overall']; ?> DE 5(<?php echo $count_reviews; ?> CLASIFICACION)</span>
                        <span class="s2" style="margin-left:144px;color:##727272;">
                            <?php
                            $r_title = $review_title['quality'][ceil($reviews_data['quality'])];
                            $r_title = str_replace('I ', 'We ', $r_title);
                            echo $r_title;
                            ?>
                        </span>
                        <span class="s2" style="margin-left:205px;color:##727272;">
                            <?php echo $review_title['price'][ceil($reviews_data['price'])]; ?>
                        </span>
                    </div>
                    <div>
                        <span class="s2" style="margin:0 0 15px 30px;"><?php echo $count_reviews; ?> COMENTARIO<?php if($count_reviews > 1) echo 'S'; ?>  &nbsp; | &nbsp;   
                        <?php
                        if(!$customer_id)
                        {
                            ?>
                            <a href="<?php echo LANGPATH; ?>/review/add/<?php echo $product_id; ?>" class="JS_popwinbtn1" id="write_review2" style="text-decoration:underline;">ESCRIBIR UN COMENTARIO</a>
                            <?php
                        }
                        else
                        {
                            ?>
                            <a target="_blank" href="<?php echo LANGPATH; ?>/review/add/<?php echo $product_id; ?>" style="text-decoration:underline;">ESCRIBIR UN COMENTARIO</a>
                            <?php
                        }
                        ?>
                        </span>
                    </div>
                </div>
                <?php
                $r_limit = 4;
                $r_pages = ceil($count_reviews / $r_limit);
                for($i = 1;$i <= $r_pages;$i ++)
                {
                ?>
                    <ul class="reviews_box <?php if($i > 1) echo 'hide'; ?>" id="page_<?php echo $i; ?>">
                    <?php
                    for($j = ($i - 1) * $r_limit;$j < $i * $r_limit;$j ++)
                    {
                        if($j >= $count_reviews)
                            break;
                        $r = $reviews[$j];
                        if($r['user_id'] == 0)
                        {
                            $firstname = $r['firstname'];
                        }
                        else
                        {
                            $firstname = DB::select('shipping_firstname')->from('orders_order')->where('id', '=', $r['order_id'])->execute()->get('shipping_firstname');
                        }
                        if(!$firstname)
                            $firstname = 'Choieser';
                        $attrs = explode(':', $r['attribute']);
                        if(strtolower($attrs[0]) == 'size')
                            $size = $attrs[1];
                        $size = str_replace(';', '', $size);
                    ?>
                        <li class="fix bgg">
                            <div class="left">
                                <dl>
                                    <dd><span style="color:#000;width:60px;display:block;float:left;">Nombre:</span><span><?php echo $firstname; ?></span></dd>      
                                    <dd><span style="color:#000;width:60px;display:block;float:left;">Tallas:</span><span><?php echo $size ? $size : $attributes['size'][0]; ?></span></dd> 
                                    <dd><span style="color:#000;width:60px;display:block;float:left;">Idoneidad:</span><span><?php echo $review_title['fitness'][$r['fitness']]; ?></span></dd>     
                                    <dd><span style="color:#000;width:60px;display:block;float:left;">Altura:</span><span><?php echo $r['height']; ?> CM</span></dd> 
                                    <dd><span style="color:#000;width:60px;display:block;float:left;">Peso:</span><span><?php echo $r['weight']; ?> KG</span></dd> 
                                </dl>
                            </div>
                            <div class="right">
                                <div class="rating1">
                                    <span class="s1" style="font-weight:bold;">
                                    Clasificación General: <strong class="rating_show1 <?php echo 'star' . $r['overall']; ?>"></strong> (<?php echo $review_title['overall'][$r['overall']]; ?>)
                                    </span>
                                    <span class="s1" style="margin-left:20px;font-weight:bold;">Calidad: <div class="outbt" title="<?php echo $review_title['overall'][$r['quality']]; ?>"><div style="width:<?php echo round($r['quality'] / 0.05, 2); ?>%;background:#f8b500;" class="inbt"></div></div></span>
                                    <span class="s1" style="margin-left:20px;font-weight:bold;">Precio: <div class="outbt" title="<?php echo $review_title['overall'][$r['price']]; ?>"><div style="width:<?php echo round($r['price'] / 0.05, 2); ?>%;background:#f8b500;" class="inbt"></div></div></span>
                                </div>
                                <div class="reviews_boxcon" style="margin-top:20px;">
                                    <p id="sluo">
                                    <?php
                                    if(strlen($r['content']) > 400)
                                    {
                                        $front_400 = substr($r['content'], 0, 400);
                                        $remain = substr($r['content'], 400);
                                    ?>
                                        <div>
                                            <?php echo $front_400; ?>
                                            <span id="review_remain_<?php echo $r['id']; ?>" style="display:none;"><?php echo $remain; ?></span>
                                            <a onclick="$('#review_remain_<?php echo $r['id']; ?>').show();$(this).hide();" class="red">Ver Más</a>
                                        </div>
                                    <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <div><?php echo $r['content']; ?></div>
                                        <?php
                                    }
                                    ?>
                                    </p>
                                    <p class="fix mt10">
                                    <?php
                                    if($r['reply'])
                                    {
                                    ?>
                                        <span style="font-weight:bold;width:20px;height:10px;"> Respuestas de Choies:</span>
                                        <span><?php echo $r['reply']; ?></span>
                                    <?php
                                    }
                                    ?>    
                                        <span class="date"><?php echo date('d M Y', $r['time']); ?></span>
                                    </p> 
                                </div>
                            </div>
                        </li>
                    <?php
                    }
                    ?>
                    </ul>
                <?php
                }
                ?>
                <div class="bottom fix" id="review_pagination">
                    <div class="flr">
                        <?php
                        $pagination = Pagination::factory(array(
                            'current_page' => array('source' => 'query_string', 'key' => 'page'),
                            'total_items' => $count_reviews,
                            'items_per_page' => $r_limit,
                            'view' => LANGPATH . '/pagination_2'));
                        echo $pagination->render();
                        ?>
                    </div>
                </div>
                <script>
                $(function(){
                    $("#review_pagination .page a").live('click', function(){
                        var page = $(this).attr('title');
                        $(".product_reviews .reviews_box").addClass('loadding');
                        $.ajax({
                            type: "POST",
                            url: "<?php echo LANGPATH; ?>/review/pagination?page=" + page,
                            dataType: "json",
                            data: "count=<?php echo $count_reviews; ?>&limit=<?php echo $r_limit; ?>",
                            success: function(msg){
                                setTimeout(function(){ 
                                    $(".product_reviews .reviews_box").removeClass('loadding');
                                    $("#review_pagination .flr").html(msg);
                                    $(".reviews_box").hide()
                                    $("#page_" + page).show();
                                }, 1000);
                            }
                        });
                        return false;
                    })
                })
                </script>
                <?php
            }
            ?>

        </article>
    </section>
</section>

<!-- JS_popwincon1 -->
<div class="JS_popwincon1 popwincon w_signup hide">
    <a class="JS_close2 close_btn2"></a>
    <div class="fix" id="sign_in_up">
        <div class="left" style="width:auto;margin-right:30px;padding-right:30px;">
            <h3>Acceso para socios</h3>
            <form action="<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/product/<?php echo $product->get('link'); ?>_p<?php echo $product_id; ?>" method="post" class="signin_form sign_form form">
                <ul>
                    <li>
                        <label>Email: </label>
                        <input type="text" value="" name="email" class="text" />
                    </li>
                    <li>
                        <label>Contraseña: </label>
                        <input type="password" value="" name="password" class="text" maxlength="16" />
                    </li>
                    <li><input type="submit" value="ACCEDER" name="submit" class="btn btn40" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">¿Olvidaste su contraseña?</a></li>
                    <li>
                        <?php
                        $page = $plink;
                        $facebook = new facebook();
                        $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                        ?>
                        <a href="<?php echo $loginUrl; ?>" class="facebook_btn">Conéctate Con Facebook</a>
                    </li>
                </ul>
            </form>
        </div>
        <div class="right">
            <h3>Únete a Choies</h3>
            <form action="<?php echo LANGPATH; ?>/customer/register?redirect=<?php echo LANGPATH; ?>/product/<?php echo $product->get('link'); ?>_p<?php echo $product_id; ?>" method="post" class="signup_form sign_form form">
                <ul>
                    <li>
                        <label>Email address: </label>
                        <input type="text" value="" name="email" class="text" />
                    </li>
                    <li>
                        <label>Contraseña: </label>
                        <input type="password" value="" name="password" class="text" id="password" maxlength="16" />
                    </li>
                    <li>
                        <label>Confirmar Contraseña: </label>
                        <input type="password" value="" name="password_confirm" class="text" maxlength="16" />
                    </li>
                    <li><input type="submit" value="REGISTRARTE" name="submit" class="btn btn40" /></li>
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
                required:"Por favor, proporcione un email.",
                email:"Por favor, introduce una dirección de email válida."
            },
            password: {
                required: "Por favor, ingrese su contraseña.",
                minlength: "Su contraseña debe tener al menos 5 caracteres."
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
                equalTo: "#password"
            }
        },
        messages: {
            email:{
                required:"Por favor, proporcione un email.",
                email:"Por favor, introduce una dirección de email válida."
            },
            password: {
                required: "Por favor, ingrese su contraseña.",
                minlength: "Su contraseña debe tener al menos 5 caracteres."
            },
            password_confirm: {
                required: "Por favor, ingrese su contraseña.",
                minlength: "Su contraseña debe tener al menos 5 caracteres.",
                equalTo: "Por favor, ingrese una contraseña la misma que arriba."
            }
        }
    });
    </script>
</div>

<!-- JS_popwincon2 -->
<div class="JS_popwincon2 popwincon w_p30 hide">
    <a class="JS_close3 close_btn2"></a>
    <h2>GUÍA DE TALLAS</h2>
    <!-- size guide2 -->
    <ul class="JS_tab4 detail_tab fix">
        <?php if ($set_id != 2): ?>
            <li class="current">ROPA</li>
            <li>TABLA DE CONVERSIÓN</li>
        <?php endif; ?>
        <?php if ($set_id == 2): ?>
            <li class="current">ZAPATOS</li>
        <?php else: ?>
            <li>ZAPATOS</li>
        <?php endif; ?>
        <?php if (Product::instance($product_id)->get('set_id') != 2 AND !empty($celebrity_lists)): ?>
            <li>INFORME DE PRUEBE</li>
        <?php endif; ?>
        <li>MEDIDAS</li>
    </ul>
    <div class="JS_tabcon4 detail_tabcon size_table_box">
        <?php
        if ($set_id != 2)
        {
            ?>
            <div class="bd">
                <?php
                $brief = str_replace(array('<p>', '</p>'), '', $brief);
                $brief = str_replace(array('<br />', '<br/>'), '<br>', $brief);
                $brief = str_replace(':<br>', ':', $brief);
                $briefs = explode("<br>", trim($brief));
                $sizes = array();
                $details = array();
                foreach ($briefs as $key => $b)
                {
                    if (strlen($b) > 4)
                    {
                        $sizes[] = substr($b, 0, strpos($b, ':'));
                        $briefs[$key] = substr($b, strpos($b, ':') + 1, strlen($b));
                    }
                }
                foreach ($briefs as $key => $b)
                {
                    $detail = explode(',', trim($b));
                    foreach ($detail as $d)
                    {
                        $de = explode(':', trim($d));
                        $titlekey = strtolower($de[0]);
                        if ($titlekey == 'sleeve')
                            $titlekey = 'sleeve length';
                        elseif ($titlekey == 'hips')
                            $titlekey = 'hip';
                        if (!isset($details[$titlekey]))
                            $details[$titlekey] = array();
                        $details[$titlekey][$key] = $de[1];
                    }
                }
                $size_titles = array(
                    'shoulder', 'bust', 'waist', 'hip', 'length', 'sleeve length'
                );
                $us_sizes = Site::us_size($details, $set_id);
                ?>
                <table class="user_table">
                    <tr>
                        <th width="10%" rowspan="2">Talla</th>
                        <?php
                        if (!empty($us_sizes))
                        {
                            ?>
                            <th width="5%" rowspan="2">EE.UU Talla</th>
                            <th width="5%" rowspan="2">Reino Unido Talla</th>
                            <th width="5%" rowspan="2">EU Talla</th>
                            <?php
                        }
                        ?>
                        <th width="15%" colspan="2">Hombro</th>
                        <th width="15%" colspan="2">Busto</th>
                        <th width="15%" colspan="2">Cintura</th>
                        <th width="15%" colspan="2">Cadera</th>
                        <th width="15%" colspan="2">Longitud</th>
                        <th width="15%" colspan="2">Longitud de Manga</th>
                    </tr>
                    <tr>
                        <th>pulgada</th>
                        <th>cm</th>
                        <th>pulgada</th>
                        <th>cm</th>
                        <th>pulgada</th>
                        <th>cm</th>
                        <th>pulgada</th>
                        <th>cm</th>
                        <th>pulgada</th>
                        <th>cm</th>
                        <th>pulgada</th>
                        <th>cm</th>
                    </tr>
                    <?php
                    foreach ($sizes as $key1 => $size)
                    {
                        if (!$size)
                            continue;
                        if($size == 'one size')
                            $size = 'talla única';
                        ?>
                        <tr>
                            <td class="b"><?php echo $size; ?></td>
                            <?php
                            $us = isset($us_sizes[$key1]) ? $us_sizes[$key1] : 0;
                            $uk = $eu = 0;
                            if ($us)
                            {
                                if (strpos($us, '+') !== False)
                                {
                                    $uk = (int) $us + 4;
                                    $uk .= '+';
                                    $eu = (int) $us + 32;
                                    $eu .= '+';
                                }
                                else
                                {
                                    $uk = $us + 4;
                                    $eu = $us + 32;
                                }
                            }
                            if ($us)
                            {
                                echo '<td>' . $us . '</td><td>' . $uk . '</td><td>' . $eu . '</td>';
                            }
                            foreach ($size_titles as $key => $title)
                            {
                                if (isset($details[$title]))
                                {
                                    $cm = str_replace('cm', '', $details[$title][$key1]);
                                    $pulgadas = array();
                                    $cms = explode('-', $cm);
                                    foreach ($cms as $c)
                                    {
                                        $c = trim($c);
                                        $i = round($c * 0.39370078740157, 2);
                                        $pulgadas[] = $i;
                                    }
                                    $cm = implode(' - ', $cms);
                                    $pulgada = implode(' - ', $pulgadas);
                                    if ((int) $pulgada)
                                        echo '<td>' . $pulgada . '</td><td>' . $cm . '</td>';
                                    else
                                        echo '<td>/</td><td>/</td>';
                                }
                                else
                                {
                                    echo '<td>/</td><td>/</td>';
                                }
                            }
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
            <div class="bd hide">
                <?php
                $hides = array(
                    9 => array(),
                    14 => array(),
                    15 => array(),
                    474 => array('bust'),
                    12 => array('bust'),
                    10 => array('bust'),
                    13 => array('bust'),
                    20 => array('bust'),
                );
                if (array_key_exists($set_id, $hides))
                {
                    $hide = $hides[$set_id];
                    ?>
                    <h3> Ropa - Tabla de conversión del tamaño Internacional</h3>
                    <table width="100%" class="user_table">
                        <tr>
                            <th width="5%" rowspan="2">EE.UU Talla</th>
                            <th width="5%" rowspan="2">Reino Unido Talla</th>
                            <th width="5%" rowspan="2">EU Talla</th>
                            <th width="15%" colspan="2" class="bust">Busto</th>
                            <th width="15%" colspan="2" class="waist">Cintura</th>
                            <th width="15%" colspan="2" class="hip">Cadera</th>
                        </tr>
                        <tr>
                            <th class="bust">pulgada</th>
                            <th class="bust">cm</th>
                            <th class="waist">pulgada</th>
                            <th class="waist">cm</th>
                            <th class="hip">pulgada</th>
                            <th class="hip">cm</th>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>6</td>
                            <td>34</td>
                            <td class="bust">31</td>
                            <td class="bust">78.5</td>
                            <td class="waist">23.75</td>
                            <td class="waist">60.5</td>
                            <td class="hip">33.75</td>
                            <td class="hip">86</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>8</td>
                            <td>36</td>
                            <td class="bust">32</td>
                            <td class="bust">81</td>
                            <td class="waist">24.75</td>
                            <td class="waist">63</td>
                            <td class="hip">34.75</td>
                            <td class="hip">88.5</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>10</td>
                            <td>38</td>
                            <td class="bust">34</td>
                            <td class="bust">86</td>
                            <td class="waist">26.75</td>
                            <td class="waist">68</td>
                            <td class="hip">36.75</td>
                            <td class="hip">93.5</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>12</td>
                            <td>40</td>
                            <td class="bust">36</td>
                            <td class="bust">91</td>
                            <td class="waist">28.75</td>
                            <td class="waist">73</td>
                            <td class="hip">38.75</td>
                            <td class="hip">98.5</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>14</td>
                            <td>42</td>
                            <td class="bust">38</td>
                            <td class="bust">96</td>
                            <td class="waist">30.75</td>
                            <td class="waist">78</td>
                            <td class="hip">40.75</td>
                            <td class="hip">103.5</td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>16</td>
                            <td>44</td>
                            <td class="bust">40</td>
                            <td class="bust">101</td>
                            <td class="waist">32.75</td>
                            <td class="waist">83</td>
                            <td class="hip">42.75</td>
                            <td class="hip">108.5</td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>18</td>
                            <td>46</td>
                            <td class="bust">43</td>
                            <td class="bust">108.5</td>
                            <td class="waist">35.75</td>
                            <td class="waist">90.5</td>
                            <td class="hip">45.75</td>
                            <td class="hip">116</td>
                        </tr>
                    </table>
                    <script>
                    <?php
                    foreach ($hide as $h)
                    {
                        ?>
                                $(".<?php echo $h; ?>").hide();
                        <?php
                    }
                    ?>
                    </script>
                    <?php
                }
                ?>
                <table width="100%" class="user_table">
                    <tr>
                        <td class="b" width="16%" bgcolor="f4f4f0">EE.UU</td>
                        <td width="6%">00</td>
                        <td width="6%">0</td>
                        <td width="6%">2</td>
                        <td width="6%">4</td>
                        <td width="6%">6</td>
                        <td width="6%">8</td>
                        <td width="6%">10</td>
                        <td width="6%">12</td>
                        <td width="6%">14</td>
                        <td width="6%">16</td>
                        <td width="6%">18</td>
                        <td width="6%">20</td>
                        <td width="6%">22</td>
                        <td width="6%">24</td>
                    </tr>
                    <tr>
                        <td class="b" bgcolor="f4f4f0">Reino Unido</td>
                        <td>2</td>
                        <td>4</td>
                        <td>6</td>
                        <td>8</td>
                        <td>10</td>
                        <td>12</td>
                        <td>14</td>
                        <td>16</td>
                        <td>18</td>
                        <td>20</td>
                        <td>22</td>
                        <td>24</td>
                        <td>26</td>
                        <td>28</td>
                    </tr>
                    <tr>
                        <td class="b" bgcolor="f4f4f0">EU</td>
                        <td>/</td>
                        <td>32</td>
                        <td>34</td>
                        <td>36</td>
                        <td>38</td>
                        <td>40</td>
                        <td>42</td>
                        <td>44</td>
                        <td>46</td>
                        <td>48</td>
                        <td>50</td>
                        <td>52</td>
                        <td>54</td>
                        <td>56</td>
                    </tr>
                    <tr>
                        <td class="b" bgcolor="f4f4f0">Francia/España</td>
                        <td>30</td>
                        <td>32</td>
                        <td>34</td>
                        <td>36</td>
                        <td>38</td>
                        <td>40</td>
                        <td>42</td>
                        <td>44</td>
                        <td>46</td>
                        <td>48</td>
                        <td>50</td>
                        <td>52</td>
                        <td>54</td>
                        <td>56</td>
                    </tr>
                    <tr>
                        <td class="b" bgcolor="f4f4f0">Alemania</td>
                        <td>32</td>
                        <td>34</td>
                        <td>36</td>
                        <td>38</td>
                        <td>40</td>
                        <td>42</td>
                        <td>44</td>
                        <td>46</td>
                        <td>48</td>
                        <td>50</td>
                        <td>52</td>
                        <td>54</td>
                        <td>56</td>
                        <td>58</td>
                    </tr>
                    <tr>
                        <td class="b" bgcolor="f4f4f0">Italia</td>
                        <td>34</td>
                        <td>36</td>
                        <td>38</td>
                        <td>40</td>
                        <td>42</td>
                        <td>44</td>
                        <td>46</td>
                        <td>48</td>
                        <td>50</td>
                        <td>52</td>
                        <td>54</td>
                        <td>56</td>
                        <td>58</td>
                        <td>60</td>
                    </tr>
                    <tr>
                        <td class="b" bgcolor="f4f4f0">AU</td>
                        <td>2</td>
                        <td>4</td>
                        <td>6</td>
                        <td>8</td>
                        <td>10</td>
                        <td>12</td>
                        <td>14</td>
                        <td>16</td>
                        <td>18</td>
                        <td>20</td>
                        <td>22</td>
                        <td>24</td>
                        <td>26</td>
                        <td>28</td>
                    </tr>
                </table>
            </div>
    <?php
}
?>
        <div class="bd <?php if ($set_id != 2) echo 'hide'; ?>">
            <table width="95%" class="size_table">
                <tr>
                    <th width="24%">EE.UU</th>
                    <th width="24%">Reino Unido</th>
                    <th width="28%">EUROPEAN</th>
                    <th width="24%">CM</th>
                </tr>
                <tr style="background:#f6f6f7;">
                    <td>3</td>
                    <td>1.5-2</td>
                    <td>34</td>
                    <td>22</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>2-2.5</td>
                    <td>35</td>
                    <td>22.5</td>
                </tr>
                <tr style="background:#f6f6f7;">
                    <td>5</td>
                    <td>3-3.5</td>
                    <td>36</td>
                    <td>23</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>4-4.5</td>
                    <td>37</td>
                    <td>23.5</td>
                </tr>
                <tr style="background:#f6f6f7;">
                    <td>7</td>
                    <td>5-5.5</td>
                    <td>38</td>
                    <td>24</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>6-6.5</td>
                    <td>39</td>
                    <td>24.5</td>
                </tr>
                <tr style="background:#f6f6f7;">
                    <td>9</td>
                    <td>7-7.5</td>
                    <td>40</td>
                    <td>25</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>8-8.5</td>
                    <td>41</td>
                    <td>25.5</td>
                </tr>
                <tr style="background:#f6f6f7;">
                    <td>11</td>
                    <td>9-9.5</td>
                    <td>42</td>
                    <td>26</td>
                </tr>
                <tr>
                    <td>12</td>
                    <td>10-10.5</td>
                    <td>43</td>
                    <td>26.5</td>
                </tr>
                <tr style="background:#f6f6f7;">
                    <td>13</td>
                    <td>11-11.5</td>
                    <td>44</td>
                    <td>27</td>
                </tr>
                <tr>
                    <td>14</td>
                    <td>12-12.5</td>
                    <td>45</td>
                    <td>27.5</td>
                </tr>
            </table>
            <p>Utilice estas tablas de tallas para ayudar a determinar su tamaño. Tamaño en nuestro sitio se mide manualmente, podría tener una ligera desviación. Si usted tiene un requisito de tamaño específico o te gustaría saber más información, póngase en contacto con nuestro Servicio de Atención al Cliente: <a href="mailto:service_<?php echo LANGUAGE; ?>@choies.com">service_<?php echo LANGUAGE; ?>@choies.com</a>. </p>
        </div>
        <?php
        if (Product::instance($product_id)->get('set_id') != 2 AND !empty($celebrity_lists))
        {
            ?>
            <div class="bd hide">
                <h3 class="center">INFORME DE PRUEBE</h3>
                <table width="100%" class="user_table">
                    <tr>
                        <th width="5%" rowspan="2">Nombre</th>
                        <th width="5%" rowspan="2">Talla</th>
                        <th width="15%" colspan="2">Altura</th>
                        <th width="15%" colspan="2">Peso</th>
                        <th width="15%" colspan="2">Busto</th>
                        <th width="15%" colspan="2">Cintura</th>
                        <th width="15%" colspan="2">Cadera</th>
                    </tr>
                    <tr>
                        <th>foot</th>
                        <th>cm</th>
                        <th>lbs</th>
                        <th>kg</th>
                        <th>pulgada</th>
                        <th>cm</th>
                        <th>pulgada</th>
                        <th>cm</th>
                        <th>pulgada</th>
                        <th>cm</th>
                    </tr>
                    <?php
                    foreach ($celebrity_lists as $cid)
                    {
                        $cid = (int) $cid;
                        $cel_customer = DB::select('customer_id')->from('celebrities_celebrits')->where('id', '=', $cid)->execute()->get('customer_id');
                        $cel_customer = (int) $cel_customer;
                        if ($cel_customer)
                        {
                            $cel_attrs = DB::query(Database::SELECT, 'SELECT i.attributes FROM order_items i 
                        LEFT JOIN orders o ON i.site_id = o.site_id AND i.order_id = o.id
                        WHERE i.product_id = ' . $product_id . ' AND o.customer_id = ' . $cel_customer)
                                            ->execute()->get('attributes');
                            $eur = strpos($cel_attrs, 'EUR');
                            $size = '';
                            if ($eur !== FALSE)
                            {
                                $size = substr($cel_attrs, $eur + 3, 2);
                            }
                            else
                            {
                                $size = substr($cel_attrs, 5, -1);
                            }
                            $celebrity = DB::query(Database::SELECT, 'SELECT show_name,height,weight,bust,waist,hips FROM celebrits WHERE id = ' . $cid)->execute()->current();
                            $height = (float) $celebrity['height'];
                            $weight = (float) $celebrity['weight'];
                            $bust = (float) $celebrity['bust'];
                            $waist = (float) $celebrity['waist'];
                            $hips = (float) $celebrity['hips'];
                            $in = 0.3937008;
                            $ft = 0.0328084;
                            $lb = 2.2046226;
                            ?>
                            <tr>
                                <td><?php echo $celebrity['show_name']; ?></td>
                                <td><?php echo $size; ?></td>
                                <td>
                                    <?php
                                    $height_ft = round($height * $ft, 1);
                                    $height_ft = str_replace(".", "'", $height_ft);
                                    $height_ft .= '"';
                                    echo $height_ft;
                                    ?>
                                </td>
                                <td><?php echo $height; ?></td>
                                <td><?php echo round($weight * $lb, 1); ?></td>
                                <td><?php echo $weight; ?></td>
                                <td><?php echo round($bust * $in, 1); ?></td>
                                <td><?php echo $bust; ?></td>
                                <td><?php echo round($waist * $in, 1); ?></td>
                                <td><?php echo $waist; ?></td>
                                <td><?php echo round($hips * $in, 1); ?></td>
                                <td><?php echo $hips; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>
            </div>
            <?php
        }
        ?>
        <div class="bd size_mesurements hide">
            <h3>ROPA</h3>
            <div class="fix">
                <div class="fll"><img src="/images/size_pic1.jpg" /></div>
                <div class="right fll">
                    <h4>BUSTO</h4>
                    <p>Mide alrededor del punto del busto más lleno, a través de los omóplatos, y asegúrese de pasar por debajo de los brazos, no alrededor de ellos. Asegúrese de dar una medida exacta, teniendo cuidado de no añadir cualquier longitud adicional a la medición.</p>
                    <h4>CINTURA</h4>
                    <p>Mida alrededor de su cintura, justo por encima del hueso de la cadera. La cinta debe estar cerca del abdomen, pero no debe ejercer presión sobre la piel.</p>
                    <h4>HIPS</h4>
                    <p>Tome la cinta floja y se envuelve alrededor de su área de la cadera. La cinta debe ser asegurado en la parte más completa de la zona de la cadera, lo que es casi siempre por encima de las nalgas.</p>
                    <h4>LONGITUD DEL VESTIDO</h4>
                    <p>Párese derecho con los talones juntos. Mida desde el punto más alto de los hombros hacia abajo de la longitud de la espalda. Por favor, elija su longitud apropiada de acuerdo con la situación práctica.</p>
                </div>
            </div>
            <h3>ZAPATOS</h3>
            <div class="fix">
                <div class="fll"><img src="/images/size_pic2.jpg" /></div>
                <div class="right fll">
                    <h4>LONGITUD DE ZAPATOS </h4>
                    <p>Medir los zapatos de la parte frontal de la parte del dedo del pie a la parte posterior de los talones.</p>
                    <h4>ALTURA DE ZAPATOS</h4>
                    <p>Medir la parte posterior de los zapatos desde la parte superior de los zapatos ribete hasta la parte inferior de los talones que descansan sobre la superficie plana.</p>
                    <h4>ALTURA DEL TALÓN</h4>
                    <p>Medir la parte posterior de los talones desde el punto donde se conecta con el zapato, llamada la costura, hasta la parte inferior de los talones que descansan sobre la superficie plana.</p>
                    <h4>ALTURA DE LA PLATAFORMA</h4>
                    <p>Mida desde la parte inferior de la suela hasta donde se conecta con el zapato en la parte superior de la plataforma.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/js/zoom.js"></script>
<script type="text/javascript" src="/js/product.js"></script>

<script type="text/javascript">
    $(function(){
        $.ajax({
            type: "POST",
            url: "/site/ajax_product1",
            dataType: "json",
            data: "id=<?php echo $product_id; ?>",
            success: function(product){
                if(product['status'] == 0)
                {
                    $("#product_status").html('<strong class="red">Fuera De Stock</strong>');
                    $("#addCart").hide();
                    $("#outofstock").show();
                }
                else
                {
                    $("#product_status").html('En Stock');
                    $("#addCart").show();
                    $("#outofstock").hide();
                }
                $(".orig_price").html(product['s_price']);
                $(".product_price").html(product['price']);
                var attributes = product['attributeSize'].replace('<span>one size</span>', '<span>talla única</span>');
                <?php
                if($crumbs[0]['id'] == 53)
                {
                    ?>
                    $(".size_list").html(product['attributeSize']);
                    <?php
                }
                ?>
                $("#total_price").text(product['total_price']);
                $("#get_points").text(parseInt(product['points']));
                <?php if($onesize==1){ ?>
                var value = $(".size_list li").attr('id');
                var qty = $(".size_list li").attr('title');
                $(".s-size").val(value);
                $(".size_list li").addClass('on');
                $("#select_size").html('Talla: '+$(".size_list li").text());
                <?php } ?>
            }
        });
    })

    $(function(){
        $("#sign_in").click(function(){
            $("#sign_in_up form").attr('action', '<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/product/<?php echo $product->get('link'); ?>_p<?php echo $product_id; ?>');
        })
        $("#write_review, #write_review1, #write_review2").click(function(){
            $("#sign_in_up form").attr('action', '<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/review/add/<?php echo $product_id; ?>');
        })
    })
</script>

<!--<div class="JS_filter opacity hide"></div>-->
<script type="text/javascript">
    function tofloat(f,dec)       
    {          
        if(dec <0) return "Error:dec <0! ";          
        result=parseInt(f)+(dec==0? " ": ".");          
        f-=parseInt(f);          
        if(f==0)
        {
            for(i=0;i <dec;i++) result+= '0';          
        }
        else       
        {          
            for(i=0;i <dec;i++)
            {
                f*=10;
                if(parseInt(f) == 0)
                {
                    result+= '0';
                }
            }          
            result+=parseInt(Math.round(f));
        } 
        return result;          
    }
</script>

<script type="text/javascript">
    var quantity = 1;
    $(function(){
        $("#formAdd").submit(function(){
            var obj = document.getElementById('cart_quantity');
            var index = obj.selectedIndex;
            quantity = obj.options[index].value;
            
            $.post(
            '/cart/ajax_add?lang=<?php echo LANGUAGE; ?>',
            {
                id: $('input:[name="id"]').val(),
                type: $('input:[name="type"]').val(),
                size: $('.s-size').val(),
                color: $('.s-color').val(),
                attrtype: $('.s-type').val(),
                quantity: $('input:[name="quantity"]').val()
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
                                <p>Artículo# : '+product[p]['sku']+'</p>\
                                <p>'+product[p]['price']+'</p>\
                                <p>'+product[p]['attributes']+'</p>\
                                <p>Cantidad: '+product[p]['quantity']+'</p>\
                            </div>\
                        <div class="fix"></div>\
                        ';
                    }
                }
                cart_view = cart_view.replace('Size', 'Talla');
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
            return false;
        })
        var sku=$('input:[name="psku"]').val();
        var price=$('input:[name="price"]').val();
        tprice=price*quantity;
        ScarabQueue.push(['addToCart', sku, quantity , tprice]);
    })
                                        
    function getScrollTop() {
        var scrollPos; if (window.pageYOffset) {
            scrollPos = window.pageYOffset; } else if (document.compatMode && document.compatMode != 'BackCompat') { scrollPos = document.documentElement.scrollTop; } else if (document.body) { scrollPos = document.body.scrollTop; } return scrollPos; 
    }
    function plus(){
        $init = document.getElementById("count_1").value;
        $init++;
        document.getElementById("count_1").value = $init;
        if(document.getElementById("count_1").value!=="1"){
            $(".btn_qty1").css("background","#666");
        }
    }
                                        
    function minus(){
        if($init>1){
            $init = document.getElementById("count_1").value;
            $init--;
            document.getElementById("count_1").value = $init;
            if(document.getElementById("count_1").value =="1"){
                $(".btn_qty1").css("background","#CED0D4");
            }
        }
    }

<?php
if ($flash_sale)
{
    $end_day = strtotime(date('Y-m-d', $flash_sale) . ' - 1 month');
    ?>
        /* time left */
        var startTime = new Date();
        startTime.setFullYear(<?php echo date('Y, m, d', $end_day); ?>);
        startTime.setHours(9);
        startTime.setMinutes(59);
        startTime.setSeconds(59);
        startTime.setMilliseconds(999);
        var EndTime=startTime.getTime();
        function GetRTime(){
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
                $(".JS_dao").hide();
                $(".JS_daoend").show();
            }else{
                $(".JS_dao").show();
                $(".JS_daoend").hide();
                $(".JS_RemainD").text(nD);
                $(".JS_RemainH").text(nH);
                $(".JS_RemainM").text(nM);
                $(".JS_RemainS").text(nS); 
            }
        }
        
        $(document).ready(function () {
            var timer_rt = window.setInterval("GetRTime()", 1000);
        });
    <?php
}
?>
</script>

<script type="text/javascript">
$(function(){
    //recent view
    $.ajax({
        type: "POST",
        url: "/site/ajax_recent_view?lang=<?php echo LANGUAGE; ?>",
        dataType: "json",
        data: "",
        success: function(msg){
            if(msg.length == 0)
            {
                $("#recent_li,#recent_view").remove();
            }
            else
            {
                $("#recent_view").html(msg);
            }
        }
    });

    $.ajax({
        type: "POST",
        url: "/site/ajax_product_same?lang=<?php echo LANGUAGE; ?>",
        dataType: "json",
        data: "product_id=<?php echo $product_id; ?>",
        success: function(msg){
            if(msg.length == 0)
            {
                $("#same_paragraph").hide();
                $(".same-paragraph1").hide();
            }
            else
            {
                $("#same_paragraph").html(msg);
            }
        }
    });

    //设计案例切换
    $('.detail_tab li').click(function(){
        var liindex = $('.detail_tab li').index(this);
        $(this).addClass('current').siblings().removeClass('current');
        $('.detail_tabcon div.bd').eq(liindex).fadeIn(150).siblings('div.bd').hide();
        var liWidth = $('.detail_tab li').width();
        $('.last .detail_tab p').stop(false,true).animate({'left' : liindex * liWidth + 'px'},300);
    });
});


$(function(){       
    //切换
    $('.dingbu li').click(function(){
        var liindex = $('.dingbu li').index(this);
        $(this).addClass('current').siblings().removeClass('current');
        $('.buyshow_box .ts').eq(liindex).fadeIn(150).siblings('div.ts').hide();
        var liWidth = $('.dingbu li').width();
        $('.w_tit .dingbu p').stop(false,true).animate({'left' : liindex * liWidth + 'px'},300);
    });
    });
    

function show(){ 
var box = document.getElementById("sluo"); 
var text = box.innerHTML; 
var newBox = document.createElement("div"); 
var btn = document.createElement("a"); 
newBox.innerHTML = text.substring(0,300); 
btn.innerHTML = text.length > 200 ? "View More" : ""; 
btn.href = "###";
btn.style="float:right;margin:-18px 22px 0 0;text-decoration:underline;";
btn.onclick = function(){ 
if (btn.innerHTML == "View More"){ 
btn.innerHTML = "View Less"; 
newBox.innerHTML = text; 
}else{ 
btn.innerHTML = "View More"; 
newBox.innerHTML = text.substring(0,300); 
} 
} 
box.innerHTML = ""; 
box.appendChild(newBox); 
box.appendChild(btn); 
} 
show(); 


</script>

<script type="text/javascript">
var t=0;
var time;
var timec;
$(function(){   
    $(".box-title ul li").hover(function(){     
    $(this).addClass("current").siblings().removeClass("current");
    var a=$(".box-title ul li").index(this);
    $(".hide-box_0,.hide-box_1,.hide-box_2,.hide-box_3").hide();
    $(".hide-box_"+a).fadeIn(150); 
    var liWidth = $(".box-title ul li").width(); 
    $(".box-title p").stop(false,true).animate({'left' : (a+1) * liWidth + 'px'},300); 
    $(".box-current li").removeClass("on");                                         
    $(".box-current li").eq(a).addClass("on");
    t=a; })
    })

 function lunbo(){
t++;
if(t>3){t=0;}
$(".hide-box_0,.hide-box_1,.hide-box_2,.hide-box_3").hide();
     $(".hide-box_"+t).fadeIn(150);
     var liWidth = $(".box-title ul li").width(); 
    $(".box-title p").stop(false,true).animate({'left' : (t+1) * liWidth + 'px'},300);  
    $(".box-title li").eq(t).addClass("current").siblings().removeClass("current");
    $(".box-current li").removeClass("on");                                         
    $(".box-current li").eq(t).addClass("on");  
    }    

</script>

<script type="text/javascript">
var h=0;
var time1;
var timec1;
$(function(){
    $(".box-current li").hover(function(){  
    $(this).addClass("on").siblings().removeClass("on");
    var b=$(".box-current li").index(this);
    $(".hide-box_0,.hide-box_1,.hide-box_2,.hide-box_3").hide();
    $(".hide-box_"+b).fadeIn(150); 
    var liWidth = $(".box-title ul li").width(); 
    $(".box-title p").stop(false,true).animate({'left' : (b+1) * liWidth + 'px'},300); 
    $(".box-title ul li").removeClass("current");                                         
    $(".box-title ul li").eq(b).addClass("current");
    h=b; })
    })

 function lunbo1(){
h++;
if(h>3){h=0;}
$(".hide-box_0,.hide-box_1,.hide-box_2,.hide-box_3").hide();
     $(".hide-box_"+h).fadeIn(150);
     var liWidth = $(".box-title ul li").width(); 
    $(".box-title p").stop(false,true).animate({'left' : (h+1) * liWidth + 'px'},300);  
    $(".box-title li").eq(h).addClass("current").siblings().removeClass("current");
    $(".box-current li").removeClass("on");                                         
    $(".box-current li").eq(h).addClass("on");  
      }
</script>

<!-- New Remarket Code -->
<script type="text/javascript">
    var google_tag_params = {
        ecomm_prodid: '<?php echo $product->get('sku'); ?>',
        ecomm_pagetype: 'product',
        ecomm_totalvalue: '<?php echo $price; ?>'
    };
</script>
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 983779940;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
</script>
<script type="text/javascript" src="www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
    <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/983779940/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<script type="text/javascript">
ScarabQueue.push(['view', '<?php echo $product->get('sku'); ?>']);
</script>