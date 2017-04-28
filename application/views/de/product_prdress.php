<link rel="canonical" href="<?php echo $product->permalink(); ?>" />
<meta property="og:image" content="<?php echo Image::link($product->cover_image(), 2); ?>" />
<meta property="og:title" content="<?php echo $product->get('name'); ?> - Choies.com" />
<meta property="og:description" content="Shop <?php echo $product->get('name'); ?> from choies.com .Free shipping Worldwide." />
<meta property="og:type" content="product" />
<meta property="og:url" content="<?php echo $product->permalink(); ?>" />
<meta property="og:site_name" content="Choies" />
<meta property="og:price:amount" content="<?php echo $product->price(); ?>" />
<meta property="og:price:currency" content="USD" />
<meta property="og:price:availability" content="in stock" />
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Homepage</a>
                <?php
                if (!$current_catalog)
                    $current_catalog = $product->default_catalog();
                $crumbs = Catalog::instance($current_catalog)->crumbs();
                foreach ($crumbs as $crumb):
                    if ($crumb['id']):
                        ?>
                        >  <a href="<?php echo $crumb['link']; ?>" rel="nofollow" ><?php echo $crumb['name']; ?></a>
                        <?php
                    endif;
                endforeach;
                ?>
                >  <?php echo $product->get('name'); ?>
            </div>
            <div class="flr"><a href="<?php echo $crumbs[0]['link'] ?>">Back to <?php echo $crumbs[0]['name'] ?></a></div>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article class="pro_detail product_view fix">
            <!-- pro_left -->
            <div class="pro_left fll">
                <div class="top">
                    <div class="myImages JS_myImages JS_zoom">
                        <a href="#" class="picbox"><img src="<?php echo Image::link($product->cover_image(), 2); ?>" big="<?php echo Image::link($product->cover_image(), 2); ?>" width="480px" alt="" /></a>
                        <?php
                        foreach ($product->images() as $key => $image):
                            if (!$key)
                                continue;
                            ?>
                            <a href="#"><img src="<?php echo Image::link($image, 2); ?>" big="<?php echo Image::link($image, 2); ?>" alt="" width="480px" /></a>
                            <?php
                        endforeach;
                        ?>
                    </div>
                    <div class="scrollable">
                        <div class="items">
                            <ul class="scrollableDiv JS_scrollableDiv fix">
                                <?php foreach ($product->images() as $image): ?>
                                    <li><img src="<?php echo Image::link($image, 3); ?>" width="75" alt="" /></li>
                                <?php endforeach; ?>
<!--                                <li class="last"><img src="/images/pro_video_75.jpg" alt="" /></li>-->
                            </ul>
                            <div class="current_style"></div>
                        </div>
                    </div>
                    <a class="prev2 Js_prev"></a>
                    <a class="next2 Js_next"></a>
                </div>
                <div class="bottom fix">
                    <div class="fll">
                        <dl class="more_from">
                            <dt>MORE FROM:</dt>
                            <dd>
                                <?php
                                $key = 1;
                                foreach ($filter_sorts as $fname => $filter):
                                    $c_link = Catalog::instance($current_catalog)->get('link');
                                    $link = $c_link . '/all/all/' . str_replace(' ', '-', strtolower($fname)) . '_' . str_replace(' ', '-', strtolower($filter));
                                    ?>
                                    <a href="<?php echo LANGPATH; ?>/<?php echo $link; ?>"><?php echo strtoupper($filter); ?></a><?php if ($key < count($filter_sorts)) echo ' | '; ?>
                                    <?php
                                    $key++;
                                endforeach;
                                ?>
                            </dd>
                        </dl>
                    </div>
                    <div class="flr">
                        <span class="share flr">
                            <?php
                            $domain = 'www.choies.com';
                            ?>
                            <a target="_blank" href="http://twitter.com/share?url=http%3A%2F%2F<?php echo $domain; ?>%2Fproduct%2F<?php echo $product->get('link'); ?>" class="a1"></a>
                            <a target="_blank" href="http://www.facebook.com/sharer.php?u=http%3A%2F%2F<?php echo $domain; ?>%2Fproduct%2F<?php echo $product->get('link'); ?>" class="a2"></a>
                            <a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($product->permalink()); ?>&media=<?php echo Image::link($product->cover_image(), 1); ?>&description=<?php $product->get('name'); ?>" class="a3"></a>
                        </span>
                    </div>
                </div>
            </div>

            <!-- pro_right -->           
            <div class="pro_right flr">
                <dl>
                    <dd>
                        <h3><?php echo $product->get('name'); ?></h3>
                        <!--                        <div class="fix">
                                                    <span class="fll"><strong class="rating_show"><span class="rating_value">rating</span></strong> <span class="reviews">(<a href="#">5</a>)</span> Reviews</span>
                                                    <a href="#" class="flr text_underline JS_popwinbtn">Be the first to write a review</a>
                                                </div>-->
                    </dd>
                    <dd class="fix info">
                        <div class="fll font11">
                            <p>
                                <?php
                                $instock = 1;
                                $stock = $product->get('stock');
                                if (!$product->get('status') OR ($stock == 0 AND $stock != -99))
                                    $instock = 0;
                                if ($stock == -1 AND empty($stocks))
                                    $instock = 0;
                                ?>
                                <span><?php echo $instock ? 'In Stock' : 'Out Of Stock'; ?></span>
                                Item# : <?php echo $product->get('sku'); ?>
                            </p>
<!--                            <p>Presale  Pattern:</p>-->
                        </div>   
                        <div class="flr"><a href="#"><img src="/images/codetext.gif" /></a></div>
                    </dd>
                    <dd class="last">
                        <?php
                        $change_countries = array('CA', 'AU');
                        $currency_change = '';
                        if (isset($_GET['url_from']))
                        {
                            $currency = substr($_GET['url_from'], 0, 2);
                            if (in_array($currency, $change_countries))
                                $currency_change = $currency;
                        }
                        $p_price = round($product->get('price'), 2);
                        $price = round($product->price(), 2);
                        $customer_id = Customer::logged_in();
                        $customer = Customer::instance($customer_id);
                        $vip_level = $customer->get('vip_level');
                        if ($vip_level)
                        {
                            if ($customer->is_celebrity())
                            {
                                if ($p_price > $price)
                                {
                                    $rate = (($p_price - $price) / $p_price) * 100;
                                    ?>
                                    <p class="price">
                                        <del><?php echo $currency_change; ?><?php echo Site::instance()->price($p_price, 'code_view'); ?></del>   
                                        <span class="price_now">NOW  <?php echo $currency_change; ?><?php echo Site::instance()->price($price, 'code_view'); ?></span>  
                                        <?php echo floor($rate); ?>% OFF
                                    </p>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <p class="price">
                                        <span class="price_now"><?php echo $currency_change; ?><?php echo Site::instance()->price($price, 'code_view'); ?></span>
                                    </p>
                                    <?php
                                }
                            }
                            else
                            {
                                $vip = DB::select()->from('vip_types')->where('level', '=', $vip_level)->execute()->current();
                                $vip_price = round($p_price * $vip['discount'], 2);
                                if ($price > $vip_price)
                                    $price = $vip_price;
                                $rate = (($p_price - $price) / $p_price) * 100;
                                ?>
                                <p class="price">
                                    <del><?php echo $currency_change; ?><?php echo Site::instance()->price($p_price, 'code_view'); ?></del>   
                                    <span class="price_now">NOW  <?php echo $currency_change; ?><?php echo Site::instance()->price($price, 'code_view'); ?></span>  
                                    <?php echo floor($rate); ?>% OFF
                                </p>
                                <p class="price_vip">VIP. price <?php echo $currency_change; ?><?php echo Site::instance()->price($vip_price, 'code_view'); ?>  </p>
                                <?php
                            }
                        }
                        else
                        {
                            if ($p_price > $price)
                            {
                                $rate = (($p_price - $price) / $p_price) * 100;
                                ?>
                                <p class="price">
                                    <del><?php echo $currency_change; ?><?php echo Site::instance()->price($p_price, 'code_view'); ?></del>   
                                    <span class="price_now">NOW  <?php echo $currency_change; ?><?php echo Site::instance()->price($price, 'code_view'); ?></span>  
                                    <?php echo floor($rate); ?>% OFF
                                </p>
                                <?php
                            }
                            else
                            {
                                ?>
                                <p class="price">
                                    PRICE:<span class="price_now"><?php echo $currency_change; ?><?php echo Site::instance()->price($price, 'code_view'); ?></span>
                                </p>
                                <?php
                            }
                        }
                        if (!$customer_id)
                        {
                            ?>
                            <p><a href="<?php echo LANGPATH; ?>/customer/login?redirect=/product/<?php echo $product->get('link'); ?>" class="pro_sign JS_popwinbtn1">Sign In for VIP Privilege</a></p>
                            <?php
                        }
                        ?>
                        <form action="/cart/add" method="POST" id="formAdd">
                            <input type="hidden" name="id" value="<?php echo $product->get('id'); ?>"/>
                            <input type="hidden" name="items[]" value="<?php echo $product->get('id'); ?>"/>
                            <input type="hidden" name="type" value="<?php echo $product->get('type'); ?>"/>
                            <input type="hidden" name="size" id="size" value=""/>
                            <input type="hidden" name="color" id="color" value=""/>
                            <input type="hidden" name="custom_size" id="custom_size" value=""/>

                            <div class="size">
                                <div class="selected_box fix">
                                    <p class="left">
                                        <span class="selected" id="select_size">Select Size:</span>
                                        <span id="only_left" class="red ml10">&nbsp;</span>
                                    </p>
                                    <span class="size_chat JS_popwinbtn2" id="size_guide">Size Chat</span>
                                </div>
                                <ul class="size_list fix">
                                    <?php
                                    if ($country_code == 'US')
                                    {
                                        $sizeArr = $size['US'];
                                        $country = 'US';
                                    }
                                    elseif ($country_code == 'GB' OR $country_code == 'UK')
                                    {
                                        $sizeArr = $size['UK'];
                                        $country = 'UK';
                                    }
                                    else
                                    {
                                        $sizeArr = $size['EUR'];
                                        $country = 'EUR';
                                    }
                                    foreach ($sizeArr as $key => $val):
                                        ?>
                                        <li id="<?php echo $key; ?>" class="btn_size_normal"><span><?php echo $country . ' ' . $val; ?></span></li>
                                        <?php
                                    endforeach;
                                    ?>
                                    <li class="custom_size JS_popwinbtn3 btn_size_normal"><span>CUSTOM SIZE</span></li>
                                </ul>
                            </div>
                            <script type="text/javascript">
                                $(function(){
                                    $(".size_list li").live("click",function(){
                                        //                                        if($(this).attr('class') != 'btn_size_normal')
                                        //                                        {
                                        //                                            return false;
                                        //                                        }
                                        var value = $(this).find('span').text();
                                        $("#size").val(value);
                                        $(this).siblings().removeClass('on');
                                        $(this).addClass('on');
                                        $("#select_size").html('Size: '+$(this).text());
                                    })
                                                                                                                                                                
                                    $('#addCart').live("click",function(){
                                        var size = $('#size').val();
                                        if(!size)
                                        {
                                            alert('Please ' + $('#select_size').html());
                                            return false;
                                        }
                                    })
                                })
                            </script>
                            <div class="color">
                                <p class="selected_box"><span class="selected" id="select_color">Select Color:</span></p>
                                <ul class="color_list fix" id="colorFix">
                                    <?php
                                    if (!empty($fabric)):
                                        foreach ($fabric as $colorname => $background):
                                            $colorlink = str_replace(' ', '_', strtolower($colorname));
                                            $fabriclink = str_replace(' ', '-', strtolower($fabricName));
                                            ?>
                                            <li title="<?php echo $colorname; ?>">
                                                <em class="icon color_<?php echo $colorlink; ?>"></em>
                                                <strong class="w_colorli1"></strong>
                                                <strong class="w_colorli"></strong>
                                                <div class="colorBox hide">
                                                    <p class="img"><img src="/images/color/<?php echo $fabriclink . '/' . $colorlink; ?>.jpg" /></p>
                                                    <p class="colorBoxcon"><strong><?php echo ucfirst($colorname); ?></strong> (<?php echo $fabricName; ?>)</p>
                                                </div> 
                                            </li>
                                            <?php
                                        endforeach;
                                    else:
                                        $fabric = Kohana::config('prdress.fabric.taffeta');
                                        foreach ($fabric as $colorname => $background):
                                            $color_link = str_replace(' ', '_', strtolower($colorname));
                                            ?>
                                            <li title="<?php echo $colorname; ?>">
                                                <em class="icon color_<?php echo $color_link; ?>"></em>
                                                <strong class="w_colorli1"></strong>
                                                <strong class="w_colorli"></strong>
                                                <div class="colorBox hide" <?php if ($colorname == 'white' Or $colorname == 'White') echo 'style="background-color:#ccc;"'; ?>>
                                                    <p class="img" style="width:157px;height:157px;background-color:<?php echo '#' . $background; ?>;"></p>
                                                    <p class="colorBoxcon"><strong><?php echo ucfirst($colorname); ?></strong></p>
                                                </div> 
                                            </li>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </ul>
                            </div>
                            <script type="text/javascript">
                                $(function(){
                                    $("#colorFix li").live('click', function(){
                                        var color = $(this).attr('title');
                                        $("#color").val(color);
                                        $("#select_color").html('Color: '+color);
                                        $(".w_colorli1").hide();
                                        $(this).find(".w_colorli1").show();
                                    })
                                })
                            </script>
                            <div class="fix">
                                <ul>
                                    <?php
                                    $default_catalog = $product->default_catalog();
                                    if (Catalog::instance($default_catalog)->get('name') == 'Wedding Dresses')
                                    {
                                        ?>
                                        <li>
                                            <input type="radio" id="delivery_time" class="delivery_time" name="delivery_time" value="0" checked="checked" />
                                            <span style="color:#F66;">Regular Order (Total Delivery Time: 25-35 Days)</span>
                                        </li>
                                        <?php
                                    }
                                    else
                                    {
                                        $key = 0;
                                        foreach ($delivery_time as $price => $name):
                                            ?>
                                            <li>
                                                <input type="radio" id="delivery_time" class="delivery_time" name="delivery_time" value="<?php echo $price; ?>" <?php if ($key == 0) echo 'checked="checked"'; ?>/>
                                                <span style="color:#F66;"><?php echo $price > 0 ? $name . ' ( + ' . Site::instance()->price($price, 'code_view') . ' )' : $name; ?></span>
                                            </li>
                                            <?php
                                            $key++;
                                        endforeach;
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="total">
                                <span class="font14">Qty</span><input type="text" name="quantity" class="text" value="1" id="count_1" onkeydown="return total_price_points();" />
                                <input type="submit" value="add to bag" class="btn add_btn view_btn" id="addCart" />
                                <a href="<?php echo LANGPATH; ?>/wishlist/add/<?php echo $product->get('id'); ?>" class="btn40_1 view_btn btn">
                                    <?php
                                    $wishlists = DB::select(DB::expr('COUNT(id) AS count'))
                                            ->from('accounts_wishlists')
                                            ->where('site_id', '=', 1)
                                            ->where('product_id', '=', $product->get('id'))
                                            ->execute()->get('count');
                                    ?>
                                    my wishlist  <?php echo $wishlists ? '(' . $wishlists . 'Add)' : ''; ?>
                                </a>
                            </div>
                            <div class="pro_sign total_price">
                                Total Price: <?php
                                    $currency = Site::instance()->currency();
                                    echo $currency['code'];
                                    ?><b id="total_price"><?php echo Site::instance()->price($price); ?></b>          
                                <span><b id="get_points"><?php echo $price; ?></b> Choies Points Earned</span>
                                <script>
                                    $(function(){
                                        
                                        $("#count_1").change(function(){
                                            var qty = $(this).val();
                                            qty = parseInt(qty);
                                            if(qty)
                                            {
                                                $("#total_price").text(price * qty);
                                                $("#get_points").text(points * qty);
                                            }
                                        });
                                    })    
                                    function total_price_points()
                                    {
                                        var price = <?php echo Site::instance()->price($price); ?>;
                                        var points = <?php echo $price; ?>;
                                        var qty = document.getElementById('count_1');
    
                                        return window.setTimeout(function(){
                                            if (!qty.value) {
                                                return true;
                                            }
        
                                            $("#total_price").text(tofloat(price * qty.value, 2));
                                            $("#get_points").text(tofloat(points * qty.value, 2));
                                        }, 0);
                                    }
                                </script>
                            </div>
                        </form>
                        <ul class="JS_tab detail_tab fix">
                            <li class="current">Details</li><li>Contact</li><li>Deliver & Return</li>
                        </ul>
                        <div class="JS_tabcon detail_tabcon">
                            <div class="bd">
                                <?php
                                $keywords = $product->get('keywords');
                                if($keywords)
                                    echo '<p>' . str_replace("\n", "<br>", $keywords) . '</p><br><br>';
                                if (!empty($filter_sorts))
                                {
                                    echo '<table width="100%" class="pro_style_table">';
                                    foreach ($filter_sorts as $name => $sort)
                                    {
                                        echo '<tr><td width="40%"><p>' . $name . ':</p></td><td width="60%"><p>' . ucfirst($sort) . '</p></td></tr>';
                                    }
                                    echo '</table>';
                                    echo '<br>';
                                }
                                $brief = $product->get('brief');
                                $brief = str_replace(';', '<br>', $brief);
                                if($brief)
                                    echo $brief . '<br><br>';
                                $description = $product->get('description');
                                $description = str_replace(';', '<br>', $description);
                                if($description)
                                    echo $description;
                                ?>
                            </div>
                            <div class="bd hide">
                                <div class="LiveChat2  mt15 pl10">
                                    <a href="#" onclick="psSMPPow(); return false;"><img name="psSMPPimage" src="http://www.choies.com/images/livechat_online.gif" border="0" /> LiveChat</a>
                                </div>
                                <div class="LiveChat2 mt10 pl10"><a href="mailto:<?php echo Site::instance()->get('email'); ?>"><img src="/images/livemessage.png" alt="Leave Message" /> Leave Message</a></div>
                                <div class="LiveChat2 mt10 pl10"><a href="<?php echo LANGPATH; ?>/faqs" target="_blank"><img src="/images/faq.png" alt="FAQ" /> FAQ</a></div>
                            </div>
                            <div class="bd hide">
                                <p style="color:#F00;">Receiving time = Processing time + Shipping time</p>
                                <p>Processing: Usually 3-5 working days</p>
                                <h4>Shipping:</h4>
                                <p>(1)	Free shipping worldwide (15-20 working days)</p>
                                <p style="color:#F00; padding-left:18px;">No minimum purchase required.</p>
                                <p>(2)	$ 15 Express Shipping(4-7 working days)</p>
                                <p style="padding-left:18px;">For detailed shipping info. You can check <a href="<?php echo LANGPATH; ?>/shipping-delivery" title="Shipping &amp; Delivery">Shipping &amp; Delivery</a>.</p>
                                <h4>Return Policy:</h4>
                                <p>If you are not 100% satisfied with the products or service, please feel  easy to contact us, you can return in 60 days. </p>
                                <p>For <span class="red">Swimwear</span> and <span class="red">Underwear</span>, if there is no quality problem, we do not offer return & exchange service, please understand.</p>
                                <p>For more Information, please check the <a href="<?php echo LANGPATH; ?>/returns-exchange" title="return policy">return policy</a>.</p>
                                <h4>Extra Attention:</h4>
                                <p>Orders may be subject to import duties, if you realize your local custom will charge some tax and you don't accept, please contact us, we will use HongKong Post, which will avoid tax but need more time to ship.</p>
                            </div>
                        </div>
                    </dd>
                </dl>
            </div>
        </article>
        <?php
        if (!empty($celebrity_images) OR !empty($videos)):
            ?>
            <article class="index_fashion buyshow_box layout">
                <div class="w_tit layout"><h2>BUYERS' SHOW</h2></div>
                <?php
                if (isset($videos) AND !empty($videos)) :
                    ?>
                    <div class="buyers_show fix JS_imgbox">
                        <div class="img_big fll">
                            <?php
                            foreach ($videos as $key => $video):
                                ?>
                                <div id="video<?php echo $key; ?>" <?php if ($key > 0) echo ' style="display:none;"' ?>>
                                    <object type="application/x-shockwave-flash" style= "width:560px; height:310px; border: #333 1px solid; margin-bottom:5px;"
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
                                        $ch = curl_init();
                                        curl_setopt($ch, CURLOPT_URL, 'http://gdata.youtube.com/feeds/api/videos/' . $video['url_add']);
                                        curl_setopt($ch, CURLOPT_HEADER, 0);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                                        $response = curl_exec($ch);
                                        curl_close($ch);

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
                                            <div class="img"><img height="93px" src="http://i1.ytimg.com/vi/<?php echo $video['url_add']; ?>/mqdefault.jpg" imgb="images/buyers_show_big1.jpg" /></div>
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
                                            Do you own a fashion blog? JOIN CHOIES!<br />
                                            Fashion Bloger Program Now! >>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
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
                endif;
                ?>
                <?php
                if (!empty($celebrity_images)):
                    ?>
                    <div class="JS_carousel product_carousel">
                        <ul class="fix">
                            <?php
                            foreach ($celebrity_images as $c_image):
                                ?>
                                <li><a href="#" target="_self"><img src="http://img.choies.com/simages/<?php echo $c_image['image']; ?>" height="333px" /></a></li>
                                <?php
                            endforeach;
                            ?>
                        </ul>
                        <span class="prev1 JS_prev"></span>
                        <span class="next1 JS_next"></span>
                    </div>
                    <?php
                endif;
                ?>
            </article>
            <?php
        endif;
        ?>
        <!--        <article class="product_reviews">
                    <div class="w_tit layout"><h2>Reviews</h2></div>
                    <div class="rating">
                        <span class="s1">Overall Rating: <strong class="rating_show"><span class="rating_value">rating</span></strong>(Excellent)</span>
                        <span class="s1">Style Rating: <strong class="rating_show"><span class="rating_value">rating</span></strong>(Trendy)</span>
                        <span class="s1">Price Rating: <strong class="rating_show"><span class="rating_value">rating</span></strong>(Trendy)</span>
                    </div>
                    <ul class="reviews_box">
                        <li class="fix">
                            <div class="left">
                                <dl>
                                    <dd>Customer ID: <span>Superxxx</span></dd>     
                                    <dd>Name: <span>Lisa</span></dd>      
                                    <dd>Size: <span>M</span></dd> 
                                    <dd>Item Style:<span class="style">Vintage</span></dd> 
                                </dl>
                            </div>
                            <div class="right">
                                <div class="rating">
                                    <span class="s1">Overall Rating: <strong class="rating_show"><span class="rating_value">rating</span></strong>(Excellent)</span>
                                    <span class="s1">Style Rating: <strong class="rating_show"><span class="rating_value">rating</span></strong></strong>(Trendy)</span>
                                    <span class="s1">Price Rating: <strong class="rating_show"><span class="rating_value">rating</span></strong></strong>(Trendy)</span>
                                </div>
                                <div class="reviews_boxcon">
                                    <p>The quality is pure luxury. I feel like i'm in a 5 star resort in my bedroom. From purchasing this bedding collection i will definitely be buying from Hotel Collection  everytime i need anything bedding re lated. I'm officially obsessed.</p>
                                    <p class="fix mt10">
                                        <span class="date">24 July 2013</span>
                                    </p> 
                                </div>
                            </div>
                        </li>
                        <li class="fix">
                            <div class="left">
                                <dl>
                                    <dd>Customer ID: <span>Superxxx</span></dd>     
                                    <dd>Name: <span>Lisa</span></dd>      
                                    <dd>Size: <span>M</span></dd> 
                                    <dd>Item Style:<span class="style">Vintage</span></dd> 
                                </dl>
                            </div>
                            <div class="right">
                                <div class="rating">
                                    <span class="s1">Overall Rating: <strong class="rating_show"><span class="rating_value">rating</span></strong>(Excellent)</span>
                                    <span class="s1">Style Rating: <strong class="rating_show"><span class="rating_value">rating</span></strong></strong>(Trendy)</span>
                                    <span class="s1">Price Rating: <strong class="rating_show"><span class="rating_value">rating</span></strong></strong>(Trendy)</span>
                                </div>
                                <div class="reviews_boxcon">
                                    <p>The quality is pure luxury. I feel like i'm in a 5 star resort in my bedroom. From purchasing this bedding collection i will definitely be buying from Hotel Collection  everytime i need anything bedding re lated. I'm officially obsessed.</p>
                                    <p class="fix mt10">
                                        <span class="date">24 July 2013</span>
                                    </p> 
                                </div>
                            </div>
                        </li>
                        <li class="fix">
                            <div class="left">
                                <dl>
                                    <dd>Customer ID: <span>Superxxx</span></dd>     
                                    <dd>Name: <span>Lisa</span></dd>      
                                    <dd>Size: <span>M</span></dd> 
                                    <dd>Item Style:<span class="style">Vintage</span></dd> 
                                </dl>
                            </div>
                            <div class="right">
                                <div class="rating">
                                    <span class="s1">Overall Rating: <strong class="rating_show"><span class="rating_value">rating</span></strong>(Excellent)</span>
                                    <span class="s1">Style Rating: <strong class="rating_show"><span class="rating_value">rating</span></strong></strong>(Trendy)</span>
                                    <span class="s1">Price Rating: <strong class="rating_show"><span class="rating_value">rating</span></strong></strong>(Trendy)</span>
                                </div>
                                <div class="reviews_boxcon">
                                    <p>The quality is pure luxury. I feel like i'm in a 5 star resort in my bedroom. From purchasing this bedding collection i will definitely be buying from Hotel Collection  everytime i need anything bedding re lated. I'm officially obsessed.</p>
                                    <p class="fix mt10">
                                        <span class="date">24 July 2013</span>
                                    </p> 
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="bottom fix">
                        <div class="flr">
                            <span class="num">27 Reviews Found:</span>
                            <div class="page">
                                <a href="#" class="prev_btn1">PRE</a> <a href="#" class="on">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a>   <a href="#" class="next_btn1">NEXT</a>
                            </div>
                        </div>
                    </div>
                </article>-->
        <?php
        $sort_list = array(
            9 => array(
                'COLOR',
                'DRESSES LENGTH',
                'SHOP LOOKS',
                'SILHOUETTE',
                'SLEEVE LENGTH',
            ),
            8 => array(
                'COLOR',
                'MATERIAL',
                'SEASON',
                'SILHOUETTE',
                'COLLAR',
            ),
            10 => array(
                'COLOR',
                'MATERIAL',
                'PATTERN TYPE',
                'WAIST TYPE',
                'CLOSURE TYPE',
            ),
            12 => array(
                'COLOR',
                'DRESSES LENGTH',
                'WAIST TYPE',
                'SILHOUETTE',
                'DETAIL',
            ),
            13 => array(
                'COLOR',
                'WAIST TYPE',
                'FIT TYPE',
                'SILHOUETTE',
                'PATTERN TYPE',
            ),
            20 => array(
                'COLOR',
                'WAIST TYPE',
                'FIT TYPE',
                'SILHOUETTE',
                'PATTERN TYPE',
            ),
            15 => array(
                'COLOR',
                'MATERIAL',
                'TYPES',
                'SLEEVE LENGTH',
                'PATTERN TYPE',
            ),
            14 => array(
                'COLOR',
                'PATTERN TYPE',
                'MATERIAL',
                'SLEEVE LENGTH',
                'DETAIL',
            ),
            11 => array(
                'COLOR',
                'MATERIAL',
                'DETAIL',
                'SLEEVE LENGTH',
                'TYPES',
            ),
            280 => array(
                'COLOR',
                'SILHOUETTE',
                'PATTERN TYPE',
                'NECKLINE',
                'DETAIL',
            ),
            279 => array(
                'COLOR',
                'SILHOUETTE',
                'MATERIAL',
                'SLEEVE LENGTH',
                'SUIT TYPE',
            ),
            375 => array(
                'COLOR',
                'MATERIAL',
                'SUIT TYPE',
                'TYPES',
                'SLEEVE LENGTH',
            ),
            300 => array(
                'COLOR',
                'MATERIAL',
                'TOP',
                'TYPES',
                'DECORATION',
            ),
        );
        ?>
        <article class="product_recommend fix">
            <div class="left">
                <h3>We Recommend</h3>
                <ul class="JS_tab3 recommend_tab">
                    <?php
                    $recommend_sorts = array();
                    $set_id = $product->get('set_id');
                    $filter_sorts1 = $filter_sorts;
                    if (isset($sort_list[$set_id]))
                    {
                        foreach ($sort_list[$set_id] as $val)
                        {
                            if (isset($filter_sorts[$val]))
                            {
                                $recommend_sorts[] = $filter_sorts[$val];
                                unset($filter_sorts[$val]);
                            }
                        }
                    }
                    if (count($recommend_sorts) < 5 AND !empty($filter_sorts))
                    {
                        $key = count($recommend_sorts);
                        foreach ($filter_sorts as $val)
                        {
                            $recommend_sorts[] = $val;
                            $key++;
                            if ($key > 5)
                                break;
                        }
                    }
                    $key = 0;
                    foreach ($recommend_sorts as $val):
                        ?>
                        <li<?php if (!$key) echo ' class="on"'; ?>><?php echo ucfirst($val); ?></li>
                        <?php
                        $key++;
                        if ($key == 5)
                            break;
                    endforeach;
                    ?>
                    <li<?php if (!$key) echo ' class="on"'; ?>>Similar Styles</li>
                </ul>
            </div>
            <div class="right JS_tabcon3">
                <?php
                $key = 0;
                foreach ($recommend_sorts as $val):
                    $key++;
                    if ($key >= 4)
                        break;
                    $product_id = $product->get('id');
                    $products = array();
                    $products = DB::query(DATABASE::SELECT, 'SELECT id, name, link, price, has_pick, MATCH(filter_attributes) AGAINST (' . "'" . '"' . $val . '"' . "'" . ') AS sorts FROM `products_product`
                        WHERE set_id=' . $set_id . ' AND visibility = 1 AND status = 1 AND status <> 0 AND  
                        MATCH(filter_attributes) AGAINST (' . "'" . '"' . $val . '"' . "'" . ') AND id <> ' . $product_id . ' 
                        ORDER BY sorts DESC, display_date DESC LIMIT 0, 3')
                            ->execute()->as_array();
                    ?>
                    <div class="bd pro_listcon<?php if ($key > 1) echo ' hide' ?>">
                        <ul class="fix">
                            <?php
                            foreach ($products as $p):
                                ?>
                                <li>
                                    <a href="<?php echo LANGPATH; ?>/product/<?php echo $p['link']; ?>" title="<?php echo $p['name']; ?>">
                                        <img width="130px" src="<?php echo Image::link(Product::instance($p['id'])->cover_image(), 3); ?>" alt="<?php echo $p['name']; ?>" />
                                    </a>
                                    <a href="<?php echo LANGPATH; ?>/product/<?php echo $p['link']; ?>" class="name"><?php echo $p['name']; ?></a>
                                    <p class="price fix">
                                        <?php
                                        $price1 = Product::instance($p['id'])->price();
                                        if ($price1 < $p['price'])
                                        {
                                            $rate1 = round(($p['price'] - $price1) / $p['price'], 2) * 100;
                                            ?>
                                            <b><?php echo Site::instance()->price($price1, 'code_view'); ?></b>    
                                            <del><?php echo Site::instance()->price($p['price'], 'code_view'); ?></del> 
                                            <span class="off"><?php echo $rate1; ?>% off</span>
                                            <?php
                                            if ($p['has_pick'])
                                                echo '<span class="icon_pick"></span>';
                                        }
                                        else
                                        {
                                            ?>
                                            <b><?php echo Site::instance()->price($p['price'], 'code_view'); ?></b>    
                                            <?php
                                            if ($p['has_pick'])
                                                echo '<span class="icon_pick"></span>';
                                        }
                                        ?>
                                    </p>
                                    <?php
                                    if ($price1 < $p['price'])
                                        echo '<span class="icon_sale"></span>';
                                    ?>
        <!--                                    <span class="outstock">out of stock</span>-->
                                </li>
                                <?php
                            endforeach;
                            ?>
                        </ul>
                    </div>
                    <?php
                endforeach;
                ?>
                <div class="bd pro_listcon<?php if ($key) echo ' hide' ?>">
                    <ul class="fix">
                        <?php
                        $key = 0;
                        $products = array();
                        $products = $product->related_products();
                        if (!empty($products)):
                            foreach ($products as $related_product):
                                if (!Product::instance($related_product)->get('visibility'))
                                    continue;
                                else
                                    $key++;
                                if ($key == 5)
                                    break;
                                $relate_name = Product::instance($related_product)->get('name');
                                $relate_link = Product::instance($related_product)->get('link');
                                ?>
                                <li>
                                    <a href="<?php echo LANGPATH; ?>/product/<?php echo $relate_link; ?>" title="<?php echo $relate_name; ?>">
                                        <img width="130px" src="<?php echo Image::link(Product::instance($related_product)->cover_image(), 3); ?>" alt="<?php echo $relate_name; ?>" />
                                    </a>
                                    <a href="<?php echo LANGPATH; ?>/product/<?php echo $relate_link; ?>" class="name"><?php echo $relate_name; ?></a>
                                    <p class="price fix">
                                        <?php
                                        $price1 = Product::instance($related_product)->price();
                                        $p_price1 = Product::instance($related_product)->get('price');
                                        if ($price1 < $p_price1)
                                        {
                                            $rate1 = round(($p_price1 - $price1) / $p['price'], 2) * 100;
                                            ?>
                                            <b><?php echo Site::instance()->price($price1, 'code_view'); ?></b>    
                                            <del><?php echo Site::instance()->price($p_price1, 'code_view'); ?></del> 
                                            <span class="off"><?php echo $rate1; ?>% off</span>
                                            <?php
                                            if (Product::instance($related_product)->get('has_pick'))
                                                echo '<span class="icon_pick"></span>';
                                        }
                                        else
                                        {
                                            ?>
                                            <b><?php echo Site::instance()->price($p_price1, 'code_view'); ?></b>    
                                            <?php
                                            if (Product::instance($related_product)->get('has_pick'))
                                                echo '<span class="icon_pick"></span>';
                                        }
                                        ?>
                                    </p>
                                    <?php
                                    if ($price1 < $p_price1)
                                        echo '<span class="icon_sale"></span>';
                                    ?>
        <!--                                    <span class="outstock">out of stock</span>-->
                                </li>
                                <?php
                            endforeach;
                        else:
                            if (isset($filter_sorts1['COLOR']))
                            {
                                $products = DB::query(DATABASE::SELECT, 'SELECT id, name, link, price, has_pick FROM `products_product` 
                                WHERE set_id=' . $set_id . ' AND visibility = 1 AND status = 1 AND status <> 0 AND  
                                !MATCH(filter_attributes) AGAINST (' . "'" . '"' . $filter_sorts1['COLOR'] . '"' . "'" . ') AND id <> ' . $product->get('id') . ' 
                                ORDER BY hits DESC LIMIT 0, 3')
                                        ->execute()->as_array();
                            }
                            foreach ($products as $p):
                                ?>
                                <li>
                                    <a href="<?php echo LANGPATH; ?>/product/<?php echo $p['link']; ?>" title="<?php echo $p['name']; ?>">
                                        <img width="130px" src="<?php echo Image::link(Product::instance($p['id'])->cover_image(), 3); ?>" alt="<?php echo $p['name']; ?>" />
                                    </a>
                                    <a href="<?php echo LANGPATH; ?>/product/<?php echo $p['link']; ?>" class="name"><?php echo $p['name']; ?></a>
                                    <p class="price fix">
                                        <?php
                                        $price1 = Product::instance($p['id'])->price();
                                        if ($price1 < $p['price'])
                                        {
                                            $rate1 = round(($p['price'] - $price1) / $p['price'], 2) * 100;
                                            ?>
                                            <b><?php echo Site::instance()->price($price1, 'code_view'); ?></b>    
                                            <del><?php echo Site::instance()->price($p['price'], 'code_view'); ?></del> 
                                            <span class="off"><?php echo $rate1; ?>% off</span>
                                            <?php
                                            if ($p['has_pick'])
                                                echo '<span class="icon_pick"></span>';
                                        }
                                        else
                                        {
                                            ?>
                                            <b><?php echo Site::instance()->price($p['price'], 'code_view'); ?></b>    
                                            <?php
                                            if ($p['has_pick'])
                                                echo '<span class="icon_pick"></span>';
                                        }
                                        ?>
                                    </p>
                                    <?php
                                    if ($price1 < $p['price'])
                                        echo '<span class="icon_sale"></span>';
                                    ?>
        <!--                                    <span class="outstock">out of stock</span>-->
                                </li>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                </div>
            </div>
            </div>
        </article>
        <!--        <article class="pro_lookwith">
                    <h2>Complete Your Look With</h2>
                    <div class="fix">
                        <div class="left"><img src="/images/pr370_350.jpg" /></div>
                        <div class="right">
                            <div class="JS_carousel1 pro_listcon">
                                <ul class="fix">
                                    <li>
                                        <a href="#"><img src="/images/pr190.jpg" /></a>
                                        <a href="#" class="name">Beige Zipper Wedge Heel Boots With Wedge Heel Boots</a>
                                        <p class="price fix"><b>$132.00</b>    <del>$189.00</del> <span class="off">40% off</span><span class="icon_pick"></span></p>
                                        <span class="icon_sale"></span>
                                        <span class="outstock">out of stock</span>
                                    </li>
                                    <li>
                                        <a href="#"><img src="/images/pr190.jpg" /></a>
                                        <a href="#" class="name">Beige Zipper Wedge Heel Boots With Wedge Heel Boots</a>
                                        <p class="price fix"><b>$132.00</b>    <del>$189.00</del> <span class="off">40% off</span><span class="icon_pick"></span></p>
                                        <span class="icon_sale"></span>
                                    </li>
                                    <li>
                                        <a href="#"><img src="/images/pr190.jpg" /></a>
                                        <a href="#" class="name">Beige Zipper Wedge Heel Boots With Wedge Heel Boots</a>
                                        <p class="price fix"><b>$132.00</b>    <del>$189.00</del> <span class="off">40% off</span><span class="icon_pick"></span></p>
                                        <span class="icon_sale"></span>
                                    </li>
                                    <li>
                                        <a href="#"><img src="/images/pr190.jpg" /></a>
                                        <a href="#" class="name">Beige Zipper Wedge Heel Boots With Wedge Heel Boots</a>
                                        <p class="price fix"><b>$132.00</b>    <del>$189.00</del> <span class="off">40% off</span><span class="icon_pick"></span></p>
                                        <span class="icon_sale"></span>
                                    </li>
                                    <li>
                                        <a href="#"><img src="/images/pr190.jpg" /></a>
                                        <a href="#" class="name">Beige Zipper Wedge Heel Boots With Wedge Heel Boots</a>
                                        <p class="price fix"><b>$132.00</b>    <del>$189.00</del> <span class="off">40% off</span><span class="icon_pick"></span></p>
                                        <span class="icon_sale"></span>
                                    </li>
                                </ul>
                            </div>
                            <span class="prev1 JS_prev1"></span>
                            <span class="next1 JS_next1"></span>
                        </div>
                    </div>
                </article>   -->
    </section>
</section>

<!-- gotop -->
<div id="gotop"><a href="#"></a></div>

<!-- JS_popwincon -->
<div class="JS_popwincon popwincon pwin_reviews hide">
    <a class="JS_close1 close_btn2"></a>
    <form action="#" method="post" class="form">
        <dl>
            <dt><span>Customer ID: <em>Superxxx</em></span>     <span>Name: <em>Lisa</em></span>     <span>Size: <em>M</em></span>    <span class="last">24 July 2013</span></dt>
            <dd>
                <label>Overall Rating:</label>
                <span class="rating_wrap fix">
                    <input class="star" type="radio" name="star1" />
                    <input class="star" type="radio" name="star1" />
                    <input class="star" type="radio" name="star1" />
                    <input class="star" type="radio" name="star1" />
                    <input class="star" type="radio" name="star1" />
                </span>
            </dd>
            <dd>
                <label>Style Rating:</label>
                <span class="rating_wrap fix">
                    <input class="star" type="radio" name="star2" />
                    <input class="star" type="radio" name="star2" />
                    <input class="star" type="radio" name="star2" />
                    <input class="star" type="radio" name="star2" />
                    <input class="star" type="radio" name="star2" />
                </span>
            </dd>
            <dd>
                <label>Price Rating:</label>
                <span class="rating_wrap fix">
                    <input class="star" type="radio" name="star3" />
                    <input class="star" type="radio" name="star3" />
                    <input class="star" type="radio" name="star3" />
                    <input class="star" type="radio" name="star3" />
                    <input class="star" type="radio" name="star3" />
                </span>
            </dd>
            <dd><label>Item Style:</label><input type="text" name="" value="" class="text" /></dd>
            <dd><textarea></textarea></dd>
            <dd class="last">
                <label>This Product is:</label>
                <div class="pro_style fix">
                    <div class="left fll">
                        <span class="on">Boho</span><span>Feminine/Girly</span>
                    </div>
                    <div class="fll">
                        <span>Goth</span><span>Sporty</span>
                    </div>
                </div>
                <input type="submit" name="submit" value="submit" class="btn" />
            </dd>
        </dl>
    </form>
</div>

<!-- JS_popwincon1 -->
<div class="JS_popwincon1 popwincon w_signup hide">
    <a class="JS_close2 close_btn2"></a>
    <div class="fix">
        <div class="left">
            <h3>CHOIES Member Sign In</h3>
            <form action="<?php echo LANGPATH; ?>/customer/login?redirect=/product/<?php echo $product->get('link'); ?>" method="post" class="signin_form sign_form form">
                <ul>
                    <li><input type="text" value="Email address" name="email" class="text" /></li>
                    <li><input type="password" value="Password" name="password" class="text" /></li>
                    <li><input type="submit" value="Login" name="submit" class="btn" /></li>
                </ul>
                <div class="form_bottom">
                    <p><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_upper">Forgot password?</a></p>
                    <p class="bottom"><span>Or sign in/sign up with Facebook</span></p>
                    <p>
                        <?php
                        $redirect = Arr::get($_GET, 'redirect', '');
                        $page = isset($_SERVER['HTTP_SELF']) ? 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_SELF'] . '/' . htmlspecialchars($redirect) : 'http://' . $_SERVER['HTTP_HOST'] . '/' . htmlspecialchars($redirect);
                        $facebook = new facebook();
                        $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                        ?>
                        <a href="<?php echo $loginUrl; ?>" class="facebook_btn"></a>
                    </p>
                </div>
            </form>
        </div>
        <div class="right">
            <h3>CHOIES Member Sign Up</h3>
            <form action="<?php echo LANGPATH; ?>/customer/register?redirect=/product/<?php echo $product->get('link'); ?>" method="post" class="signup_form sign_form form">
                <ul>
                    <li><input type="text" value="Email address" name="email" class="text" /></li>
                    <li><input type="password" value="Password" name="password" class="text" id="password" /></li>
                    <li><input type="password" value="Confirm password" name="password_confirm" class="text" /></li>
                    <li><input type="submit" value="Sign Up" name="submit" class="btn" /></li>
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
                    equalTo: "#password"
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

<!-- JS_popwincon2 -->
<div class="JS_popwincon2 popwincon w_p30 hide">
    <a class="JS_close3 close_btn2"></a>
    <h2>SIZE GUIDE</h2>

    <!-- size guide1 -->
    <ul class="JS_tab2 detail_tab fix">
        <li class="on">SIZE CHAT</li>
        <li>COLOR CHAT</li>
        <li>MESUREMENTS</li>
    </ul>
    <div class="JS_tabcon2 detail_tabcon">
        <div class="bd"><img src="/images/tab1_img.jpg" /></div>
        <div class="bd hide">
            <img src="/images/stain.jpg" />
            <img src="/images/chiffon.jpg" />
            <img src="/images/taffeta.jpg" />
            <img src="/images/organza.jpg" />
            <img src="/images/elastic.jpg" />
        </div>
        <div class="bd size_mesurements hide fix">
            <div class="fll"><img src="/images/tab3_img.jpg" /></div>
            <div class="right fll">
                <h4>BUST</h4>
                <p>This is not your bra size ! Please wear an unpadded bra (your dress will have a built-in bra).Relax your arms at sides. Then pull tape across the fullest part of the bust.</p>
                <h4>WAIST</h4>
                <p>Measure around your waist, usually about 1 in. above belly button. The tape should be close to the abdomen but should not exert pressure on your skin. Keep tape slightly loose to allow for breathing room.</p>
                <h4>HIPS</h4>
                <p>Take the loose tape and wrap it around your hip area. The tape should be secured at the fullest part of the hip area; this is almost always over the buttocks.</p>
                <h4>HEIGHT</h4>
                <p>Stand straight with feet together, please measure in bare feet.Measure from the very top of your head and pull tape straight down to the floor.</p>
                <h4>HOLLOW to FLOOR</h4>
                <p>Stand straight with feet together, please measure in bare feet. Begin at the hollow space between the collarbones and pull tape straight down to the floor.</p>
            </div>
        </div>
    </div>
</div>

<!-- JS_popwincon3 -->
<div class="JS_popwincon3 popwincon w_p30 hide">
    <a class="JS_close4 close_btn2"></a>
    <h2>ADD YOUR OWN SIZE</h2>
    <div class="size_mesurements fix">
        <div class="fll"><img src="/images/tab3_img.jpg" /></div>
        <div class="right fll">
            <div class="size_form form">
                <p class="first">Perfect measurements starts the perfect-fitting dress.<br />
                    Not sure how to do ? Please check measurements in our size guide.</p>
                <ul>
                    <li>
                        <span>*</span>
                        <label>Bust：</label>
                        <input type="text" id="bust" class="text" />
                        inch
                    </li>
                    <li>
                        <span>*</span>
                        <label>Waist：</label>
                        <input type="text" id="waist" class="text" />
                        inch
                    </li>
                    <li>
                        <span>*</span>
                        <label>Hips：</label>
                        <input type="text" id="hips" class="text" />
                        inch
                    </li>
                    <li>
                        <span>*</span>
                        <label>Height：</label>
                        <input type="text" id="height" class="text" />
                        inch
                    </li>
                    <li>
                        <span>*</span>
                        <label>Hollow to Floor：</label>
                        <input type="text" id="hollow" class="text" />
                        inch
                    </li>
                </ul>
                <p>Choies wants to provide perfect dresses with best tailoring for our honored customers. So it takes a little bit longer for processing the customized ones. 
                    For any special requests, please feel free to contact our customer service: <?php echo Site::instance()->get('email'); ?></p>
                <input type="button" value="submit" class="view_btn btn40" id="add_custom" />
            </div>
        </div>
    </div>
</div>

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
    $(function(){
        $("#formAdd").submit(function(){
            $.post(
            '/cart/ajax_add',
            {
                id: $('input:[name="id"]').val(),
                type: $('input:[name="type"]').val(),
                size: $('#size').val(),
                custom_size: $('#custom_size').val(),
                color: $('#color').val(),
                delivery_time: $('#delivery_time').val(),
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
             return false;
        })
    })
</script>
<script type="text/javascript">
    $(function(){
        $('#addCart').live("click",function(){
            var size = $('#size').val();
            var color = $("#color").val();
            if(size == 'CUSTOM SIZE')
            {
                if(!$("#custom_size").val())
                {
                    alert('Please select size');
                    return false;
                }
            }
            else if(!size)
            {
                alert('Please select size');
                return false;
            }
            else if(!color)
            {
                alert('Please select color');
                return false
            }
        })
        $("#add_custom").live("click", function(){
            var bust = $("#bust").val();
            var waist = $("#waist").val();
            var hips = $("#hips").val();
            var height = $("#height").val();
            var hollow = $("#hollow").val();
            if(!bust || !waist || !hips || !height || !hollow)
            {
                return false;
            }
            else
            {
                var custom_size = 'bust:'+bust+', waist:'+waist+', hips:'+hips+', height:'+height+', hollow:'+hollow;
                $("#custom_size").val(custom_size);
                $("#select_size").text('Select Size: CUSTOM SIZE')
                $("#size").val('CUSTOM SIZE');
                $(".JS_filter3").remove();
                $('.JS_popwincon3').fadeOut(160);
            }
        })
        $("#size_guide").live("click",function(){
            var top = getScrollTop();
            top = top - 35;
            $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
            $('#catalog_link').css({"top": top, "position": 'absolute'});
            $('#catalog_link').appendTo('body').fadeIn(320);
            $('#catalog_link').show();
            return false;
        })
        
        $("#catalog_link .closebtn,#wingray").live("click",function(){
            $("#wingray").remove();
            $('#catalog_link').fadeOut(160).appendTo('#tab2');
            return false;
        })
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
</script>

<script type="text/javascript">
    var google_tag_params = {
        ecomm_prodid: '<?php echo $product->get('sku'); ?>',           //SKU
        ecomm_pagetype: 'product',         // product
        ecomm_totalvalue: '<?php echo $price; ?>'       // 
    };
</script>

<!-- New Remarket Code -->
<script type="text/javascript">
    var google_tag_params = {
        ecomm_prodid: '<?php echo $product->get('sku'); ?>',           //SKU
        ecomm_pagetype: 'product',         // product 
        ecomm_totalvalue: '<?php echo $price; ?>'       // 产品price
    };
        
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