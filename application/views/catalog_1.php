<?php $catalog_link = $catalog->get('link'); ?>
<link rel="canonical" href="/<?php echo $catalog_link; ?>" />
<link type="text/css" rel="stylesheet" href="/css/catalog.css" media="all" />
<link type="text/css" rel="stylesheet" href="/css/common.css" media="all" />
<link type="text/css" rel="stylesheet" href="/css/quickview.css" media="all" />
<style>
    .pro-item .icon-rshipped{position: absolute;top: 0; right: 0;}
    .icon-rshipped {width: 45px;height: 45px;background-image: url(/images/catalog/ico-rshipped.png);}
</style>

<?php
$name = $catalog->get('name');
if ($catalog_link == 'daily-new')
{
    $today = strtotime('midnight') - 50400;
    $uri = $_SERVER['REQUEST_URI'];
    $uriArr = explode('/', $uri);
    if (!isset($uriArr[2]))
    {
        $to = $today + 86400;
        $from = strtotime('-1 day', $to);
    }
    else
    {
        $to = $today - $uriArr[2] * 86400 + 86400;
        $from = strtotime('-1 day', $to);
    }
    $m = date('m', $to - 1);
    if ($m == 5)
        $name = date('d M, Y', $to - 1);
    else
        $name = date('d M., Y', $to - 1);
}

$catalog_id = $catalog->get('id');
?>
<!-- main begin -->
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll">
                <a href="<?php echo LANGPATH; ?>/" class="home">home</a>
                <?php
                $crumbs = $catalog->crumbs();
                foreach ($crumbs as $key => $crumb):
                    ?>
                    <?php if ($key != count($catalog->crumbs()) - 1): ?>
                        &gt; <span><a href="<?php echo $crumb['link']; ?>" rel="nofollow" ><?php echo $crumb['name']; ?></a></span>
                    <?php else: ?>
                        &gt; <span><?php echo $name; ?></span>
                    <?php endif; ?>
                    <?php
                endforeach;
                ?>
            </div>
            <?php if (count($crumbs) > 1): ?>
                <div class="flr"><a href="<?php echo $crumbs[0]['link']; ?>">Back To <?php echo $crumbs[0]['name']; ?></a></div>
                <?php
            endif;
            ?>
        </div>
    </div>
    <div class="grid">
        <?php
        if (1)
        {
            if ($catalog_link == 'daily-new')
            {
                $image_src = $catalog->get('image_src');
                if ($image_src)
                {
                    ?>
                    <div class="newin_banner">
                        <img src="/simages/<?php echo $image_src; ?>" width="1020" />
                        <ul class="con fix">
                            <?php
                            for ($i = 0; $i < 10; $i++):
                                $day = $today - $i * 86400 + 86400;
                                $on = 0;
                                if (isset($uriArr[2]) AND $uriArr[2] == $i)
                                    $on = 1;
                                elseif (!isset($uriArr[2]) AND $i == 0)
                                    $on = 1;
                                ?>
                                <li <?php echo $on ? 'class="on"' : ''; ?>>
                                    <a href="<?php echo LANGPATH; ?>/daily-new/<?php echo $i ? $i : ''; ?>">
                                        <?php
                                        $m = date('m', $day);
                                        if($m == 5)
                                            echo date('d M', $day);
                                        else
                                            echo date('d M.', $day);
                                        ?>
                                    </a>
                                </li>
                                <?php
                            endfor;
                            ?>
                        </ul>
                    </div>
                    <?php
                }
            }
            elseif ($catalog_link == 'halloween')
            {
                ?>
                <div class="banner" id="banner">
                    <div class="ibanner layout" style="height:300px;">
                        <ul class="bannerPic">
                            <li><a href="#" title=""><img src="/images/1020-300-1.jpg" alt="" /></a></li>
                            <li><a href="#" title=""><img src="/images/1020-300-2.jpg" alt="" /></a></li>
                            <li><a href="#" title=""><img src="/images/1020-300-3.jpg" alt="" /></a></li>
                        </ul>
                        <div class="banner_lr">
                            <button class="previous prev1"></button>
                            <button class="next next1"></button>
                        </div>
                    </div>
                </div>
                <script>
                    // banner805 
                    $(function(){
                        $(".banner .bannerPic li").soChange({
                            //thumbObj:".banner .bannerBtn li",
                            botPrev:".banner .previous",
                            botNext:".banner .next",
                            botPrevslideTime:500,
                            changeTime:5000,
                            slideTime:500
                        });
                    });
                </script>
                <?php
            }
            elseif ($catalog_link == 'new-year-paypal-sale')
            {
                ?>
                <div class="banner" id="banner">
                    <div class="ibanner layout" style="height:300px;">
                        <ul class="bannerPic">
                            <li><a href="#" title=""><img src="/images/new-year-paypal-sale1.jpg" alt="" /></a></li>
                            <li><a href="#" title=""><img src="/images/new-year-paypal-sale2.jpg" alt="" /></a></li>
                        </ul>
                        <div class="banner_lr">
                            <button class="previous prev1"></button>
                            <button class="next next1"></button>
                        </div>
                    </div>
                </div>
                <script>
                    // banner805 
                    $(function(){
                        $(".banner .bannerPic li").soChange({
                            //thumbObj:".banner .bannerBtn li",
                            botPrev:".banner .previous",
                            botNext:".banner .next",
                            botPrevslideTime:500,
                            changeTime:5000,
                            slideTime:500
                        });
                    });
                </script>
                <?php
            }
            elseif($catalog_link == 'south-east-asian-sale')
            {
                ?>
                <div class="banner" id="banner">
                    <div class="ibanner layout" style="height:300px;">
                        <ul class="bannerPic">
                            <li><a href="#" title=""><img src="/images/south-east-asian-sale1.jpg" alt="" /></a></li>
                            <li><a href="#" title=""><img src="/images/south-east-asian-sale2.jpg" alt="" /></a></li>
                        </ul>
                        <div class="banner_lr">
                            <button class="previous prev1"></button>
                            <button class="next next1"></button>
                        </div>
                    </div>
                </div>
                <script>
                    // banner805 
                    $(function(){
                        $(".banner .bannerPic li").soChange({
                            //thumbObj:".banner .bannerBtn li",
                            botPrev:".banner .previous",
                            botNext:".banner .next",
                            botPrevslideTime:500,
                            changeTime:5000,
                            slideTime:500
                        });
                    });
                </script>
                <?php
            }
            else
            {
                $image_src = $catalog->get('image_src');
                if ($image_src):
                    $image_map = $catalog->get('image_map');
                    if ($image_map)
                        $map = 'Map' . $catalog->get('id');
                    else
                        $map = '';
                    ?>
                    <p class="mb25">
                        <a href="<?php echo $catalog->get('image_link'); ?>">
                            <img src="/simages/<?php echo $image_src; ?>" alt="<?php echo $catalog->get('image_alt'); ?>" usemap="#<?php echo $map; ?>" />
                        </a>
                    </p>
                    <?php
                    if ($map)
                    {
                        echo '<map name="' . $map . '" id="' . $map . '">' . $image_map . '</map>';
                    }
                endif;
            }
        }
        ?>
        <div id="catalog_filter"></div>
        <!-- aside -->
        <?php
        if($catalog_link != 'daily-new' AND $catalog_link != 'new-in')
        {
            echo View::factory('/catalog_left_1')
                ->set('catalog_id', $catalog_id)
                ->set('sort_by', $sorts)
                ->set('crumbs', $crumbs)
                ->set('custom_filter', $custom_filter)
                ->set('now_filters', $now_filters)
                ->set('pricerang', $pricerang)
                ->set('size_filter', $size_filter);
        }
        ?>
        <?php
        $count_product = count($products);
        if($count_product > 0)
        {
        ?>
        <div class="flr mt20"><?php echo $pagination; ?></div>
        <div class="fix"></div>
        <div class="pro-list">
            <ul class="cf">
                <?php
                $secondhalf = DB::select('restrictions')
                    ->from('carts_cpromotions')
                    ->where('actions', '=', 'a:1:{s:6:"action";s:10:"secondhalf";}')
                    ->and_where('site_id', '=', 1)
                    ->and_where('is_active', '=', 1)
                    ->and_where('to_date', '>', time())
                    ->execute()->get('restrictions');
                if($show_ship_tip)
                    $ready_shippeds = DB::select('product_id')->from('products_categoryproduct')->where('category_id', '=', 395)->execute()->as_array();
                else
                    $ready_shippeds = array();
                $_limit = $count_product >= $limit ? $limit : count($products);
                for ($i = 0; $i < $_limit; $i++):
                    $product_id = $products[$i];
                    $cover_image = Product::instance($product_id)->cover_image();
                    $product_inf = Product::instance($product_id)->get();
                    $search = array('product_id' => $product_id);
                    if(in_array($search, $same_paragraphs))
                        $in_same = 1;
                    else
                        $in_same = 0;
                    $plink = Product::instance($product_id)->permalink();
                    ?>
                    <li class="pro-item">
                        <?php
                        if($i >= 20)
                        {
                        ?>
                            <div class="overlay"></div>
                            <div class="pic">
                                <a href="<?php echo $plink; ?>">
                                <div class="pic1"><img data-original="<?php echo Image::link($cover_image, 1); ?>" src="/images/loading.gif" alt="<?php echo 'Fashion ' . $catalog->get('name'); ?>" title="<?php echo $product_inf['name']; ?>" /></div>
                                </a>
                                <?php if($in_same){ ?>
                                <span class="icon-color"></span>
                                <?php } ?>
                            </div>
                        <?php
                        }
                        else
                        {
                            ?>
                            <div class="overlay"></div>
                            <div class="pic">
                                <a href="<?php echo $plink; ?>">
                                <div class="pic1"><img src="<?php echo Image::link($cover_image, 1); ?>" alt="<?php echo 'Fashion ' . $catalog->get('name'); ?>" title="<?php echo $product_inf['name']; ?>" /></div>
                                </a>
                                <?php if($in_same){ ?>
                                    <a href="<?php echo $plink; ?>"><span class="icon-color" title="More Colors"></span></a>
                                <?php } ?>
                            </div>
                            <?php
                        }
                        ?>
                        <h6 class="title">
                            <a href="<?php echo $plink; ?>" title="<?php echo $product_inf['name']; ?>">
                            <?php
                            if ($product_inf['has_pick'] != 0)
                            {
                                ?>
                                <i class="icon icon-pick"></i>
                                <?php
                            }
                            ?>
                            <?php echo $product_inf['name']; ?>
                            </a>
                        </h6>
                        <p class="price">
                            <?php
                            $orig_price = round($product_inf['price'], 2);
                            $price = round(Product::instance($product_id)->price(), 2);
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
                                <span class="pricenew"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
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
                        <?php if ($product_inf['type'] != 0): ?>
                            <a href="#" id="<?php echo $product_id; ?>" class="quick_view JS_shows1"><span class="btn-qv">Quick View</span></a>
                        <?php endif; ?>
                        <div class="add-wish">
                        <?php
                        if(in_array(array('product_id' => $product_id), $wishlists))
                        {
                            ?>
                            <i class="fa fa-heart add_wishlist2"></i>
                            <?php
                        }
                        else
                        {
                        ?>
                        <a class="add_to_wishlist" data-product="<?php echo $product_id; ?>">
                            <span>Add to wishlist</span>
                            <i class="fa fa-heart add_wishlist" id="wish_<?php echo $product_id; ?>"></i>
                        </a>
                        <?php
                        }
                        ?>
                        </div>
                        <div class="sign-warp">
                            <span class="sign-close">
                                <i class="fa fa-times-circle fa-lg"></i>
                            </span>
                            <div class="wishlist_success">
                                <p class="text"></p>
                                <p class="wish"><i class="fa fa-heart"></i>Wishlist</p>
                            </div>
                        </div>
                        <?php
                        if ($secondhalf):
                            $restrict = unserialize($secondhalf);
                            $has = DB::query(Database::SELECT, 'SELECT id FROM products_categoryproduct WHERE product_id = ' . $product_id . ' AND category_id IN (' . $restrict['restrict_catalog'] . ')')->execute()->get('id');
                            if ($has):
                                ?>
                                <div style="height: 16px;background:#ff3333;color:#fff;font-family: Century Gothic;font-size: 12px;text-align: center;">
                                    BUY 1 GET 2nd HALF PRICE
                                </div>
                                <?php
                            endif;
                        endif;
                        ?>

                        <?php
                        $onsale = 1;
                        if ($product_inf['status'] == 0)
                            $onsale = 0;
                        else
                        {
                            if ($product_inf['stock'] == 0)
                                $onsale = 0;
                            elseif ($product_inf['stock'] == -1)
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
                            echo '<span class="outstock">Sold Out</span>';
                        }
                        else
                        {
                            if(in_array($search, $flash_sales))
                                echo '<i class="icon icon-fsale"></i>';
                            else
                            {
                                if(in_array($search, $ready_shippeds))
                                {
                                    echo '<i class="icon icon-rshipped"></i>';
                                }
                                else
                                {
                                    $is_new = time() - $product_inf['display_date'] <= 86400 * 7 ? 1 : 0;
                                    if($is_new)
                                        echo '<i class="icon icon-new"></i>';
                                }
                                
                            }
                        }
                        ?>
                    </li>
                    <?php
                endfor;
                ?>
            </ul>
        </div>
        <div class="flr"><?php echo $pagination; ?></div>
        <?php
        }
        else
        {
            ?>
            <div class="font18 mt20">Sorry, no results found. You may take a look at our recommended products:</div>
            <div class="hide-box1_2">
                <ul class="cf">
                <?php
                $hots = array();
                $hots = DB::query(Database::SELECT, 'SELECT P.id, P.link FROM products_product P LEFT JOIN products_categoryproduct C ON P.id = C.product_id WHERE C.category_id = ' . $catalog_id . ' AND P.visibility = 1 AND P.status = 1 AND stock <> 0 ORDER BY P.hits DESC LIMIT 0, 6')->execute();
                foreach($hots as $pdetail)
                {
                    ?>
                    <li data-scarabitem="<?php echo $pdetail['sku']; ?>" style="display: inline-block" class="rec-item">
                        <a href="/product/<?php echo $pdetail['link'] . '_p' . $pdetail['id']; ?>">
                            <img src="<?php echo Image::link(Product::instance($pdetail['id'])->cover_image(), 7); ?>" class="rec-image">
                        </a>
                        <p class="price"><b><?php echo Site::instance()->price(Product::instance($pdetail['id'])->price(), 'code_view') ?></b></p>
                    </li>
                    <?php
                }
                ?>
                </ul>
            </div>
            <?php
        }
        ?>
        <br><article class="product_reviews" id="alsoview" style="display:none">
        <div class="w_tit layout"><h2>Recommended Products</h2></div>
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
        ScarabQueue.push(['category', '<?php
        $crumbs = $catalog->crumbs();
        foreach ($crumbs as $key => $crumb):
         if ($key != count($catalog->crumbs()) - 1):  echo $crumb['name']." > ";  else: echo $name; endif; 
        endforeach;
        ?>']);
        // Request personalized recommendations.
        ScarabQueue.push(['recommend', {
            logic: 'CATEGORY',
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
                        data:"sku="+psku,
                        success: function(data){
                                for(var o in data){
                                    $("#em"+o+"link").attr("href",data[o]["link"]);
                                    $("#em"+o+"price").html(data[o]["price"]);
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
        </div>
</section>
<?php echo View::factory('/quickview'); ?>
<div class="mybag hide" id="mybag" style="position: fixed;top: 10px;right: 140px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border-style: solid;border-width: 8px 4px 4px;">
    <div class="add_tit" style="margin-top:0px;">Success! Item Added To BAG</div>
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
        <div class="left" style="width:320px;margin-right:30px;padding-right:30px;">
            <h3>CHOIES Member Sign In</h3>
            <div id="customer_pid" style="display:none;"></div>
            <form action="#" method="post" class="signin_form sign_form form" id="form_login">
                <ul>
                    <li>
                        <label>Email address: </label>
                        <input type="text" value="" name="email" class="text" id="email1" />
                    </li>
                    <li>
                        <label>Password: </label>
                        <input type="password" value="" name="password" class="text" maxlength="16" id="password1" />
                    </li>
                    <li><input type="submit" value="Sign In" name="submit" class="btn btn40" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">Forgot password?</a></li>
                    <li>
                        <?php
                        $page = $plink;
                        $facebook = new facebook();
                        $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                        ?>
                        <a href="<?php echo $loginUrl; ?>" class="facebook_btn"></a>
                    </li>
                </ul>
            </form>
        </div>
        <div class="right">
            <h3>CHOIES Member Sign Up</h3>
            <form action="#" method="post" class="signup_form sign_form form" id="form_register">
                <ul>
                    <li>
                        <label>Email address: </label>
                        <input type="text" value="" name="email" class="text" id="email2" />
                    </li>
                    <li>
                        <label>Password: </label>
                        <input type="password" value="" name="password" class="text" id="password2" maxlength="16" />
                    </li>
                    <li>
                        <label>Confirm password: </label>
                        <input type="password" value="" name="password_confirm" id="password_confirm" class="text" maxlength="16" />
                    </li>
                    <li><input type="submit" value="Sign Up" name="submit" class="btn btn40" /></li>
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
                    required:"Please provide an email.",
                    email:"Please enter a valid email address."
                },
                password: {
                    required: "Please provide a password.",
                    minlength: "Your password must be at least 5 characters long.",
                    maxlength: "The password exceeds maximum length of 20 characters."
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
                    required:"Please provide an email.",
                    email:"Please enter a valid email address."
                },
                password: {
                    required: "Please provide a password.",
                    minlength: "Your password must be at least 5 characters long.",
                    maxlength:"The password exceeds maximum length of 20 characters."
                },
                password_confirm: {
                    required: "Please provide a password.",
                    minlength: "Your password must be at least 5 characters long.",
                    maxlength:"The password exceeds maximum length of 20 characters.",
                    equalTo: "Please enter the same password as above."
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
        //pagination locate to 'Sort By:'
        $(".page a").click(function(){
            var link = $(this).attr('href');
            if(link)
                location.href = link + '#catalog_filter';
            return false;
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
