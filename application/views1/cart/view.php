<?php
if(empty(LANGUAGE))
{
    $lists = Kohana::config('/cart/cart.en');
}
else
{
    $lists = Kohana::config('/cart/cart.'.LANGUAGE);
}
?>
<div class="site-content">
    <div class="main-container clearfix">
        <div class="container">
            <?php echo Message::get(); ?>
            <div class="cart cart-view">
                <!-- shopping-bag -->
                <?php
                $end_day = 0;
                $count = Cart::count();
                $subtotal = 0;
                $save = 0;
                if (!$count)
                {
                    ?>
                    <div class="clearfix">
                        <strong><?php echo $lists['SHOPPING BAG']; ?></strong>
                    </div>
                    <div class="cart-empty">
                    <?php if($save_show){ ?>
                        <p><?php echo $lists['cart-empty']['title1']; ?></p>
                        <p><?php echo $lists['cart-empty']['title2']; ?></p>
                    <?php }else{ ?>
                        <p><?php echo $lists['cart-empty']['title3']; ?></p>
                        <p><?php echo $lists['cart-empty']['title4']; ?></p>
                    <?php } ?>
                    </div>

                    <div id="saved_items"></div>
                    <?php if(count($cartcookie)>0){ ?>
                        <div class="saved-items">
                            <div class="title">
                                <strong><?php echo $lists['Your Saved Items']; ?></strong>
                            </div> 
                            <table class="shopping-table pc-tb" width="100%">
                                <tbody>
                                    <tr>
                                        <th class="first" width="50%"><?php echo $lists['NAME']; ?></th>
                                        <th width="15%"><?php echo $lists['PRICE']; ?></th>
                                        <th width="20%"><?php echo $lists['OPTION']; ?></th>
                                        <th width="15%"><?php echo $lists['TOTAL']; ?></th>
                                    </tr>
                                    <?php
                                    //cartcookie
                                    foreach ($cartcookie as $key => $value) {

                                    $cookie_product = Product::instance($value['id'],LANGUAGE);
                                    $value['price'] = $cookie_product->price();
                                    $cookie_link = $cookie_product->permalink();
                                    $stock = $cookie_product->get('stock');
                                    $cname =  $cookie_product->get('name');
                                    $cimage = image::link($cookie_product->cover_image(), 3);
                                    $csku = $cookie_product->get('sku');

                                    $_phone_save = array();
                                    $_phone_save['id'] = $value['id'];
                                    $_phone_save['items'][0] = $value['items'][0];
                                    $_phone_save['key'] = $key;
                                    $_phone_save['name'] = $cname;
                                    $_phone_save['link'] = $cookie_link;
                                    $_phone_save['image'] = $cimage;
                                    $_phone_save['sku'] = $csku;
                                    $_phone_save['size'] = $value['attributes']['Size_value'];
                                    $_phone_save['quantity'] = $value['quantity'];
                                    $_phone_save['price'] = $value['price'];
                                    $_phone_save['stock'] = $stock;
                                    $phone_saves[] = $_phone_save;

                                    if ($cookie_product->get('visibility') AND $cookie_product->get('status') AND $stock!=0 ){ ?>
                                    <tr>
                                        <td>
                                            <div class="clearfix">
                                                <div class="left"><a href="<?php echo $cookie_link; ?>"><img src="<?php echo $cimage; ?>" alt="<?php echo $cname; ?>" /></a></div>
                                                <div class="right">
                                                    <a href="<?php echo $cookie_link; ?>" class="name"><?php echo $cname; ?></a>
                                                    <p class="item"><?php echo $lists['Item'],$csku ?></p>
                                                    <p class="delete"><!--a href="<?php //echo LANGPATH; ?>/wishlist/cookie_add/<?php //echo $key; ?>?return=cart" class="a-underline">Save to Wishlist</a-->
                                                        <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $value['items'][0].'_'.$value['attributes']['Size_value'];?>" class="a-underline fll"  onclick="if(!confirm('<?php echo $lists['js_message1'];?>')){return false;}"><?php echo $lists['Delete']; ?></a><span style="margin:3px 10px;float:left">|</span>
                                                        <a href="<?php echo LANGPATH; ?>/cart/cookie2cart/<?php echo $value['items'][0].'_'.$value['attributes']['Size_value'];?>" class="a-underline fll green"><?php echo $lists['Add To Cart'];?></a>
                                                    </p>
                                                </div> 
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                            $origial_price = $cookie_product->get('price');
                                            $subtotal += $origial_price * $value['quantity'];
                                            if ($origial_price > $value['price']){
                                                $save += ($origial_price - $value['price']) * $value['quantity']; ?>
                                                <del><?php echo Site::instance()->price($origial_price, 'code_view'); ?></del>
                                                <p><b class="red"><?php echo Site::instance()->price($value['price'], 'code_view'); ?></b></p>
                                            <?php }else{ ?>
                                                <p><b><?php echo Site::instance()->price($value['price'], 'code_view'); ?></b></p>
                                            <?php } ?>
                                            <?php if(isset($value['expired'])){ 
                                            $end_day = strtotime(date('Y-m-d', $value['expired']) . ' - 1 month');
                                            ?>
                                            <p class="flash mt5"><img src="<?php echo STATICURL; ?>/ximg/flsa_btn.png" /></p>
                                            <div style="display:block;" class="JS_dao<?php echo $value['id']; ?>">
                                                <p class="font11 mt5"><?php echo $lists['Sale Ends'];?></p>
                                                <p class="font11 red"><strong  style="font-size:14px;" class="JS_RemainD<?php echo $value['id'];?>"></strong>d <strong  style="font-size:14px;" class="JS_RemainH<?php echo $value['id'];?>"></strong>h <strong style="font-size:14px;" class="JS_RemainM<?php echo $value['id'];?>"></strong>m <strong style="font-size:14px;" class="JS_RemainS<?php echo $value['id'];?>"></strong>s</p>
                                            </div>
                                            <?php } ?>
                                        </td>
                                        <script type="text/javascript">
                                            /* time left */
                                            function GetRTime<?php echo $value['id'];?>(){
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
                                                    $(".JS_dao<?php echo $value['id']; ?>").html("Time Over!");
                                                }else{
                                                    $(".JS_RemainD<?php echo $value['id']; ?>").text(nD);
                                                    $(".JS_RemainH<?php echo $value['id']; ?>").text(nH);
                                                    $(".JS_RemainM<?php echo $value['id']; ?>").text(nM);
                                                    $(".JS_RemainS<?php echo $value['id']; ?>").text(nS); 
                                                }
                                            }
                                            $(document).ready(function () {
                                                var timer_rt = window.setInterval("GetRTime<?php echo $value['id']; ?>()", 1000);
                                            });
                                        </script>
                                        <td>
                                            <ul class="cart-option" style="display: block;">
                                                <li>
                                                    <label><?php echo $lists['size']; ?>  </label>
                                                    <span class="cart-size"><?php echo $value['attributes']['Size']; ?></span>
                                                </li>
                                                <li>
                                                    <label><?php echo $lists['quantity']; ?> </label>
                                                    <span class="cart-size"><?php echo $value['quantity']; ?></span>
                                                </li>
                                            </ul>
                                        </td>
                                        <td><b class="font14"><?php echo Site::instance()->price($value['price'] * $value['quantity'], 'code_view'); ?></b></td>
                                    </tr>
                                    <?php }else{ ?>
                                    <tr class="stock">
                                      <td>
                                        <div class="clearfix">
                                          <div class="left"><a href="<?php echo $cookie_link; ?>"><img src="<?php echo $cimage; ?>" alt="<?php echo $cname; ?>" /></a></div>
                                          <div class="right">
                                            <a href="<?php echo $cookie_link; ?>" class="name gray"><?php echo $cname; ?></a>
                                            <p class="gray"><?php echo $lists['Item'],$csku; ?><span class="red font11 ml5"><?php echo $lists['out of stock']; ?></span></p>
                                            <p class="bottom"><!--a href="<?php //echo LANGPATH; ?>/wishlist/cookie_add/<?php //echo $key; ?>?return=cart" class="a-underline">Save to Wishlist</a-->
                                                <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $value['id'].'_'.$value['attributes']['Size_value'];?>" class="a-underline"><?php echo $lists['Delete'];?></a></p>
                                          </div>
                                        </div>
                                      </td>
                                      <td>
                                        <p><b class="gray"><?php echo Site::instance()->price($value['price'], 'code_view'); ?></b></p>
                                      </td>
                                      <td>
                                        <ul class="cart-option gray" style="display: block;">
                                          <li>
                                              <label>Size:  </label>
                                              <span class="cart-size"><?php echo $value['attributes']['Size']; ?></span>
                                          </li>
                                          <li>
                                              <label>Quantity: </label>
                                              <span class="cart-size"><?php echo $value['quantity']; ?></span>
                                          </li>
                                        </ul>
                                      </td>
                                      <td><b class="font14 gray"><?php echo Site::instance()->price($value['price'] * $value['quantity'], 'code_view'); ?></b></td>
                                    </tr>
                                    <?php }} ?>
                                </tbody>
                            </table>
                            <table class="shopping-table phone-tb" width="100%">
                                <tbody>
                                <?php
                                foreach($phone_saves as $psave)
                                {
                                ?>
                                    <tr class="<?php if(!$psave['stock']) echo 'stock'; ?>">
                                        <td>
                                            <div class="clearfix">
                                                <div class="left">
                                                    <a href="<?php echo $psave['link']; ?>">
                                                        <img src="<?php echo $psave['image']; ?>" alt="<?php echo $psave['name']; ?>">
                                                    </a>
                                                </div>
                                                <div class="right">
                                                    <a href="<?php echo $psave['link']; ?>" class="name">
                                                        <?php echo $psave['name']; ?>
                                                    </a>
                                                    <p class="item">
                                                        <?php echo $lists['Item'], $psave['sku']; ?> <?php if(!$psave['stock']): ?><span class="red"><?php echo $lists['out of stock'];?></span><?php endif; ?>
                                                    </p>
                                                    <p>
                                                        <b>
                                                            <?php echo Site::instance()->price($psave['price'], 'code_view'); ?>
                                                        </b>
                                                    </p>
                                                    <p></p>
                                                    <ul class="cart-option">
                                                        <li>
                                                            <label><?php echo $lists['size'];?></label>
                                                            <?php echo $psave['size']; ?>
                                                        </li>
                                                        <li>
                                                            <label><?php echo $psave['quantity']; ?></label>
                                                            <?php echo $psave['quantity']; ?>
                                                        </li>
                                                    </ul>
                                                    <p></p>
                                                    <p class="delete">
                                                        <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $psave['items'][0].'_'.$psave['size'];?>" class="a-underline fll">Delete</a>

                                                        <?php
                                                        if($psave['stock'])
                                                        {
                                                            ?>
                                                            <span class="v-line">|</span>
                                                            <a href="<?php echo LANGPATH; ?>/cart/cookie2cart/<?php echo $psave['items'][0].'_'.$psave['size'];?>" class="a-underline fll green">Add To Cart</a>
                                                            <?php
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                            
                            <P class="mb20"><?php echo $lists['message'];?></P>
                        </div>
                    <?php } ?>
                <?php 
                }
                else
                {
                    $currency = Site::instance()->currency();
                    //$cart = Promotion::instance()->apply_cart($cart);
                    //print_r($cart);exit;
                    $cpromotions = DB::select()
                                    ->from('carts_cpromotions')
                                    ->and_where('is_active', '=', 1)
                                    ->and_where('from_date', '<=', time())
                                    ->and_where('to_date', '>=', time())
                                    ->order_by('priority')
                                    ->execute()->as_array();
                    $sale_words = array();
                    $largess_words = array();
                    $cart_promotion_logs = isset($cart['promotion_logs']['cart']) ? $cart['promotion_logs']['cart'] : array();
                    $celebrity_avoid = 0;
                    $customer_id = Customer::logged_in();
                    $catalog_link = '/';
                    foreach ($cpromotions as $cpromo)
                    {
                        $actions = unserialize($cpromo['actions']);
                        if ($customer_id AND Customer::instance($customer_id)->is_celebrity())
                            $celebrity_avoid = $cpromo['celebrity_avoid'];
                        if ($actions['action'] == 'largess')
                        {
                            if (empty($cart['largesses_for_choosing']) AND empty($cart['largesses']))
                            {
                                $largess_words[] = $cpromo['name'];
                                $restrict = unserialize($cpromo['restrictions']);
                                if (isset($restrict['restrict_catalog']))
                                {
                                    $catalog_link = '/' . Catalog::instance($restrict['restrict_catalog'])->get('link');
                                }
                            }
                        }
                        else
                        {
                            if (isset($cart_promotion_logs[$cpromo['id']]['restrictions']))
                            {
                                $restrictions = unserialize($cart_promotion_logs[$cpromo['id']]['restrictions']);
                                $rate = $cart_promotion_logs[$cpromo['id']]['value'];
                            }
                            elseif (isset($cart_promotion_logs[$cpromo['id']]['next']) AND $cart_promotion_logs[$cpromo['id']]['next'])
                            {
                                $sale_words[] = $cart_promotion_logs[$cpromo['id']]['next'];
                            }
                            elseif (isset($cart_promotion_logs[$cpromo['id']]['log']))
                            {
                                $sale_words[] = $cart_promotion_logs[$cpromo['id']]['log'];
                            }
                            elseif (!array_key_exists($cpromo['id'], $cart_promotion_logs))
                            {
                                $restrict = unserialize($cpromo['restrictions']);
                                if (isset($restrict['restrict_catalog']))
                                {
                                    $catalog_link = '/' . Catalog::instance($restrict['restrict_catalog'])->get('link');
                                    $sale_words[] = $cpromo['name'];
                                }
                                else
                                    $sale_words[] = $cpromo['name'];
                            }
                        }
                    }
                    ?>
                    <!-- shopping_bag -->
                    <div class="clearfix cart-accept">
                        <div class="fll">
                            <strong><?php echo $lists['SHOPPING BAG'];?></strong>
                            <span class="show"><?php echo $lists['We accept'];?>:<img src="<?php echo STATICURL; ?>/assets/images/shopping-bag-accept-0509.png" usemap="#Shopping"></span>
                            <map name="Shopping" id="Shopping">
                                <area target="_blank" shape="rect" coords="525,2,598,43" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&amp;dn=<?php echo URLSTR; ?>&amp;lang=en">
                            </map>
                        </div>
                        <a href="<?php echo LANGPATH; ?>/cart/checkout" class="flr btn btn-primary btn-lg">
                            <?php echo $lists['Proceed to checkout'];?>
                        </a>
                    </div>
                    <div class="phone-tb">
                        <strong><?php echo $lists['SHOPPING BAG'];?></strong>
                    </div>
                    <div class="shopping-bag">
                        <table class="shopping-table pc-tb" width="100%" id="shopping_bag">
                            <tr>
                                <th width="50%" class="first"><?php echo $lists['NAME'];?></th>
                                <th width="15%"><?php echo $lists['PRICE'];?></th>
                                <th width="20%"><?php echo $lists['OPTION'];?> </th>
                                <th width="15%"><?php echo $lists['TOTAL'];?></th>
                            </tr>
                            <?php
                            $types = array(0 => 0, 3 => 0);
                            $save = 0;
                            $subtotal = 0;
                            $phone_bags = array();
                            foreach (array_reverse($cart['products']) as $key => $product):

                                if(!$key)
                                    continue;
                                if(isset($cartcookie[$key])){//cartcookie
                                    unset($cartcookie[$key]);
                                }
                                $_phone = array();
                                $types[$product['type']]++;
                                $product_obj = Product::instance($product['id'],LANGUAGE);
                                $name = $product_obj->get('name');
                                $link = $product_obj->permalink();
                                $cover_image = image::link($product_obj->cover_image(), 3);
                                $sku = $product_obj->get('sku');
                                $_phone['id'] = $product['id'];
                                $_phone['items'][0] = $product['items'][0];
                                $_phone['key'] = $key;
                                $_phone['name'] = $name;
                                $_phone['link'] = $link;
                                $_phone['cover_image'] = $cover_image;
                                $_phone['sku'] = $sku;
                                ?>
                                <tr>
                                    <td>
                                        <div class="clearfix">
                                            <div class="left"><a href="<?php echo $link; ?>"><img src="<?php echo $cover_image; ?>" alt="<?php echo $name; ?>" /></a></div>
                                            <div class="right">
                                                <a href="<?php echo $link; ?>" class="name"><?php echo $name; ?></a>
                                                <p class="item"><?php echo $lists['Item'], $sku; ?></p>
                                                <p class="delete">
                                                    <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $product['items'][0].'_'.$product['attributes']['Size_value'];?>" class="a-underline fll"  onclick="if(!confirm('Are you sure you want to delete this item?')){return false;}">Delete</a><span style="margin:3px 10px;float:left">|</span>
                                                    <?php if($save_show){
                                                    if(1){ ?>
                                                    <a href="<?php echo LANGPATH;?>/cart/cookie2later/<?php echo $product['items'][0].'_'.$product['attributes']['Size_value'];?>" class="a-underline fll green"><?php echo $lists['Save for Later'];?></a>
                                                    <?php
                                                    } }else{ ?>
                                                    <a id="sign_in" class="a-underline fll green" href="<?php echo LANGPATH;?>/customer/login?redirect=/cart/view"><?php echo $lists['Save for Later'];?></a>
                                                    <?php } ?>
                                                </p>
                                                <div style="clear:both"></div>
                                                <?php if(0){?>
                                                <div style="color:red"><?php echo $lists['message1'];?></div>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        $_phone['org_price'] = 0;
                                        $_phone['price'] = $product['price'];
                                        $restrict_product = isset($restrictions['restrict_product']) ? $restrictions['restrict_product'] : '';
                                        if (isset($restrictions['restrict_catalog']) || $restrict_product)
                                        {
                                            if ($actions['action'] == 'bundle')
                                            {
                                                $origial_price = Product::instance($product['id'])->get('price');
                                                $subtotal += $origial_price * $product['quantity'];
                                            }
                                            else
                                            {
                                               $subtotal += $product['price'] * $product['quantity']; 
                                            } 

                                            if (Product::instance($product['id'])->get('set_id') == $restrictions['restrict_catalog'] || $product['id'] == $restrict_product)
                                            {
                                                if ($actions['action'] == 'bundle')
                                                {
                                                    $origial_price = Product::instance($product['id'])->get('price');
                                                    $sprice =  Product::instance($product['id'])->price();
                                                    if($origial_price > $sprice)
                                                    {
                                                       $save += ($origial_price - $sprice) * $product['quantity'];
                                                    }
                                                }
                                                else
                                                {
                                                    $_phone['org_price'] = $product['price'];
                                                    $_phone['price'] = $sal_price;
                                                    $sal_price = $product['price'] * $rate / 100;
                                                    $save += ($product['price'] - $sal_price) * $product['quantity'];                                                    
                                                }

                                                ?>
                                                <del><?php echo Site::instance()->price($product['price'], 'code_view'); ?></del>
                                                <p><b class="red"><?php echo Site::instance()->price($sal_price, 'code_view'); ?></b></p>
                                                <?php
                                            }
                                            else
                                            {
                                                if ($actions['action'] == 'bundle')
                                                {
                                                    $origial_price = Product::instance($product['id'])->get('price');
                                                    $sprice =  Product::instance($product['id'])->price();
                                                    $vip_level = Customer::instance($customer_id)->get('is_vip');
                                                    //新 vip    2016-4-27
                                                    if(!$vip_level){
                                                        $vip_level = 0;
                                                        $vipconfig = Site::instance()->vipconfig();
                                                        $vip = $vipconfig[0]; 
                                                    }else{
                                                        $vipconfig = Site::instance()->vipconfig();
                                                        $vip = $vipconfig[4]; 
                                                    }

                                                    $vip_price = Product::instance($product['id'])->get('price') * $vip['discount'];

                                                    if ($vip_price < $sprice)
                                                    {
                                                        $sprice = $vip_price;
                                                    }

                                                    if($origial_price > $sprice)
                                                    {
                                                       $save += ($origial_price - $sprice) * $product['quantity'];
                                                    }
                                                }
                                                ?>
                                                <p><b><?php echo Site::instance()->price($product['price'], 'code_view'); ?></b></p>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            $origial_price = Product::instance($product['id'])->get('price');
                                            $subtotal += $origial_price * $product['quantity'];
                                            if ($origial_price > $product['price'])
                                            {
                                                $_phone['org_price'] = $origial_price;
                                                $_phone['price'] = $product['price'];
                                                $save += ($origial_price - $product['price']) * $product['quantity'];
                                                ?>
                                                <del><?php echo Site::instance()->price($origial_price, 'code_view'); ?></del>
                                                <p><b class="red"><?php echo Site::instance()->price($product['price'], 'code_view'); ?></b></p>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <p><b><?php echo Site::instance()->price($product['price'], 'code_view'); ?></b></p>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <?php if(isset($product['expired'])){ 
                                        $end_day = strtotime(date('Y-m-d', $product['expired']) . ' - 1 month');
                                        ?>
                                        <p class="flash mt5"><img src="<?php echo STATICURL; ?>/ximg/flsa_btn.png" /></p>
                                        <div style="display:block;">
                                            <p class="font11 mt5"><?php echo $lists['Sale Ends'];?></p>
                                            <p class="font11 red"><strong style="font-size:14px;" class="JS_RemainD<?php echo $product['id'];?>"></strong>d <strong style="font-size:14px;" class="JS_RemainH<?php echo $product['id'];?>"></strong>h <strong style="font-size:14px;" class="JS_RemainM<?php echo $product['id'];?>"></strong>m <strong style="font-size:14px;" class="JS_RemainS<?php echo $product['id'];?>"></strong>s</p>
                                        </div>
                                        <?php } ?>
                                        <script type="text/javascript">
                                            /* time left */
                                            function GetRTime<?php echo $product['id'];?>(){
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
                                                    $(".JS_dao<?php echo $product['id']; ?>").html("Time Over!");
                                                }else{
                                                    $(".JS_RemainD<?php echo $product['id']; ?>").text(nD);
                                                    $(".JS_RemainH<?php echo $product['id']; ?>").text(nH);
                                                    $(".JS_RemainM<?php echo $product['id']; ?>").text(nM);
                                                    $(".JS_RemainS<?php echo $product['id']; ?>").text(nS); 
                                                }
                                            }
                                            $(document).ready(function () {
                                                var timer_rt = window.setInterval("GetRTime<?php echo $product['id']; ?>()", 1000);
                                            });
                                        </script>
                                    </td>
                                    <td>
                                        <form action="<?php echo LANGPATH; ?>/cart/product_edit" method="post" class="hide">
                                            <input name="key" type="hidden" class="b-num fll" value="<?php echo $key; ?>">
                                            <ul class="cart-option">
                                                <li>
                                                    <label>Size:</label>
                                                    <select name="attribute">
                                                        <?php
                                                        foreach ($p_attributes[$product['id']] as $key1 => $a)
                                                        {
                                                            $p_stock = isset($p_stocks[$product['id']][$key1]) ? $p_stocks[$product['id']][$key1] : 1000;
                                                            ?>
                                                            <option value="<?php echo $a . '-' . $p_stock; ?>" <?php if ($product['attributes']['Size'] == $a) echo 'selected'; ?>><?php echo $a; ?></option>
                                                            <?php
                                                        }
                                                        $_phone['p_attributes'] = $p_attributes[$product['id']];
                                                        ?>
                                                    </select>
                                                </li>
                                                <li>
                                                    <label><?php echo $lists['quantity'];?> </label>
                                                    <input type="text" value="<?php echo $product['quantity']; ?>" name="quantity" class="text" />
                                                </li>
                                                <?php
                                                $stocks = 0;
                                                if(Product::instance($product['id'])->get('stock') == -1)
                                                {
                                                    if(Product::instance($product['id'])->get('set_id') == 2)
                                                    {
                                                        $stocks = DB::select('stocks')->from('products_stocks')
                                                            ->where('product_id', '=', $product['id'])
                                                            ->where('attributes', 'LIKE', '%'.$product['attributes']['Size'].'%')
                                                            ->execute()->get('stocks');
                                                    }
                                                    else
                                                    {
                                                        $stocks = DB::select('stocks')->from('products_stocks')
                                                            ->where('product_id', '=', $product['id'])
                                                            ->where('attributes', '=', $product['attributes']['Size'])
                                                            ->execute()->get('stocks');
                                                    }
                                                    if($stocks > 0 && $stocks < 21)
                                                    {
                                                        ?>
                                                        <li class="red"><?php echo $lists['only'];?> <span><?php echo $stocks; ?></span> <?php echo $lists['left'];?></li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <li>
                                                    <input type="reset" value="<?php echo $lists['Cancel'];?>" class="btn btn-xs change_cancel" />
                                                    <input type="submit" value="<?php echo $lists['Update'];?>" class="btn btn-default btn-xs" />
                                                </li>
                                            </ul>
                                        </form>
                                        <ul class="cart-option">
                                            <li>
                                                <label><?php echo $lists['size'];?>  </label>
                                                <span class="cart-size"><?php echo $product['attributes']['Size']; ?></span>
                                            </li>
                                            <li>
                                                <label><?php echo $lists['quantity'];?> </label>
                                                <span class="cart-size"><?php echo $product['quantity']; ?></span>
                                            </li>
                                            <?php
                                            $_phone['size_value'] = $product['attributes']['Size_value'];
                                            $_phone['size'] = $product['attributes']['Size'];
                                            $_phone['quantity'] = $product['quantity'];
                                            $_phone['stock'] = $stocks;
                                            if($stocks > 0)
                                            {
                                                ?>
                                                <li class="red"><?php echo $lists['only'];?> <span><?php echo $stocks; ?></span> <?php echo $lists['left'];?></li>
                                                <?php
                                            }
                                            ?>
                                            <?php if(1){?>
                                            <li>
                                                <a class="btn btn-default btn-xs change_detail"><?php echo $lists['Change Details'];?></a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                    <td><b class="font14"><?php echo Site::instance()->price($product['price'] * $product['quantity'], 'code_view'); ?></b></td>
                                </tr>
                                <?php
                                $phone_bags[] = $_phone;
                            endforeach;
                            if (!empty($cart['stock_tips']))
                            {
                                foreach ($cart['stock_tips'] as $tips)
                                {
                                    echo '<strong class="red">' . $tips . '</strong><br>';
                                }
                            }
                            if (isset($cart['largesses']) AND !$celebrity_avoid)
                            {
                                foreach ($cart['largesses'] as $key => $largess)
                                {
                                    $product = Product::instance($largess['id'],LANGUAGE);
                                    $l_link = $product->permalink();
                                    $l_name = $product->get('name');
                                    $l_cover_image = image::link($product->cover_image(), 3);
                                    $l_sku = $product->get('sku');
                                    $_phone1 = array();
                                    $_phone1['key'] = $key;
                                    $_phone1['link'] = $l_link;
                                    $_phone1['name'] = $l_name;
                                    $_phone1['cover_image'] = $l_cover_image;
                                    $_phone1['sku'] = $l_sku;
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="clearfix">
                                                <div class="left">
                                                    <a href="<?php echo $l_link; ?>" title="<?php echo $l_name; ?>">
                                                        <img src="<?php echo $l_cover_image; ?>" alt="<?php echo $l_name; ?>" />
                                                    </a>
                                                </div>
                                                <div class="right">
                                                    <a href="<?php echo $l_link; ?>" class="name"><?php echo $l_name; ?></a>
                                                    <p>Item: #<?php echo $l_sku; ?></p>
                                                    <p class="delete"><a href="<?php echo LANGPATH; ?>/cart/largess_delete/<?php echo $key; ?>" class="a-underline">Delete</a></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                            $origial_price1 = Product::instance($largess['id'])->get('price');
                                            $subtotal += $origial_price1 * $largess['quantity'];
                                            $save += ($origial_price1 - $largess['price']) * $largess['quantity'];
                                            ?>
                                            <del><?php echo Site::instance()->price($origial_price1, 'code_view'); ?></del>
                                            <p><b class="red"><?php echo Site::instance()->price($largess['price'], 'code_view'); ?></b></p>
                                        </td>
                                        <td>
                                            <ul class="cart-option">
                                                <li>
                                                    <label>Size:  </label>
                                                    <span class="cart-size"><?php echo $largess['attributes']['Size']; ?></span>
                                                </li>
                                                <li>
                                                    <label>Quantity: </label>
                                                    <span class="cart-size"><?php echo $largess['quantity']; ?></span>
                                                </li>
                                            </ul>
                                        </td>
                                        <td><b class="font14"><?php echo Site::instance()->price($largess['price'] * $largess['quantity'], 'code_view'); ?></b></td>
                                    </tr>
                                    <?php
                                    $_phone1['org_price'] = $origial_price1;
                                    $_phone1['price'] = $largess['price'];
                                    $_phone1['quantity'] = $largess['quantity'];
                                    $_phone1['p_attributes'] = array();
                                    $_phone1['size'] = '';
                                    $_phone1['stock'] = 0;
                                    $_phone1['size'] = $largess['attributes']['Size'];
                                    $phone_bags1[] = $_phone1;
                                }
                            }
                            ?>
                        </table>

                        <table class="shopping-table phone-tb" width="100%" id="shopping_bag">
                            <tbody>
                            <?php
                            foreach($phone_bags as $phone)
                            {
                            ?>
                                <tr>
                                    <td>
                                        <div class="clearfix">
                                            <div class="left">
                                                <a href="<?php echo $phone['link']; ?>">
                                                    <img src="<?php echo $phone['cover_image']; ?>" alt="<?php echo $phone['name']; ?>">
                                                </a>
                                            </div>
                                            <div class="right">
                                                <a href="<?php echo $phone['link']; ?>" class="name">
                                                    <?php echo $phone['name']; ?>
                                                </a>
                                                <p class="item">
                                                    <?php echo $lists['Item'], $phone['sku']; ?>
                                                </p>
                                                <p>
                                                    <?php
                                                    if($phone['org_price'])
                                                    {
                                                    ?>
                                                        <del>
                                                            <?php echo Site::instance()->price($phone['org_price'], 'code_view'); ?>
                                                        </del>       
                                                   <b class="red">
                                                        <?php echo Site::instance()->price($phone['price'], 'code_view'); ?>
                                                    </b>
                                                    <?php
                                                    }else{ ?>
                                                   <b>
                                                        <?php echo Site::instance()->price($phone['price'], 'code_view'); ?>
                                                    </b>

                                            <?php        }
                                                    ?>

                                                </p>
                                                <p></p>
                                                <form action="<?php echo LANGPATH; ?>/cart/product_edit" method="post" class="hide">
                                                    <input name="key" type="hidden" class="b-num fll" value="<?php echo $phone['key']; ?>">
                                                    <ul class="cart-option">
                                                        <li>
                                                            <label>
                                                                <?php echo $lists['size'];?>
                                                            </label>
                                                            <select name="attribute">
                                                            <?php
                                                            foreach ($phone['p_attributes'] as $key1 => $a)
                                                            {
                                                                $p_stock = isset($p_stocks[$product['id']][$key1]) ? $p_stocks[$product['id']][$key1] : 1000;
                                                                ?>
                                                                <option value="<?php echo $a . '-' . $p_stock; ?>" <?php if ($product['attributes']['Size'] == $a) echo 'selected'; ?>><?php echo $a; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                            </select>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <?php echo $lists['quantity'];?>
                                                            </label>
                                                            <input value="<?php echo $phone['quantity']; ?>" name="quantity" class="text" type="text">
                                                        </li>
                                                        <?php
                                                        if($phone['stock'] > 0)
                                                        {
                                                            ?>
                                                            <li class="red"><?php echo $lists['only'];?>only <span><?php echo $phone['stock']; ?></span> <?php echo $lists['left'];?></li>
                                                            <?php
                                                        }
                                                        ?>
                                                        <li>
                                                            <input type="reset" value="Cancel" class="btn btn-xs change_cancel" />
                                                            <input type="submit" value="Update" class="btn btn-default btn-xs" />
                                                        </li>
                                                    </ul>
                                                </form>
                                                <ul class="cart-option">
                                                    <li>
                                                    <?php
                                                    if($phone['size'])
                                                    {
                                                    ?>
                                                        <label><?php echo $lists['size']; ?> </label>
                                                        <span class="cart-size"><?php echo $phone['size']; ?></span>
                                                    <?php
                                                    }
                                                    ?>
                                                    </li>
                                                    <li>
                                                        <label><?php echo $lists['quantity']; ?> </label>
                                                        <span class="cart-size"><?php echo $phone['quantity']; ?></span>
                                                    </li>
                                                    <?php if(1){?>
                                                    <li>
                                                        <a class="btn btn-default btn-xs change_detail"><?php echo $lists['Change Details']; ?></a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                                <p></p>
                                                <p class="delete">
                                                    <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $phone['items'][0].'_'.$phone['size_value'];?>" class="a-underline fll"  onclick="if(!confirm('<?php echo $lists['js_message1']; ?>')){return false;}"><?php echo $lists['Delete']; ?></a><span style="margin:3px 10px;float:left">|</span>
                                                    <?php if($save_show){ if(1){ ?>
                                                    <a href="<?php echo LANGPATH;?>/cart/cookie2later/<?php echo $phone['items'][0].'_'.$phone['size_value'];?>" class="a-underline fll green"><?php echo $lists['Save for Later']; ?></a>
                                                    <?php } }else{ ?>
                                                    <a id="sign_in" class="a-underline fll green" href="<?php echo LANGPATH;?>/customer/login?redirect=/cart/view"><?php echo $lists['Save for Later']; ?></a>
                                                    <?php } ?>
                                                </p>
                                                <div style="clear:both"></div>
                                                <?php if(0){?>
                                                <div style="color:red"><?php echo $lists['message1']; ?></div>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>   

                            <!-- phone cart cuxiao -->
                            <?php
                            if(!empty($phone_bags1)){
                                foreach($phone_bags1 as $key=>$phone)
                                {
                                ?>
                                <tr>
                                    <td>
                                        <div class="clearfix">
                                            <div class="left">
                                                <a href="<?php echo $phone['link']; ?>">
                                                    <img src="<?php echo $phone['cover_image']; ?>" alt="<?php echo $phone['name']; ?>">
                                                </a>
                                            </div>
                                            <div class="right">
                                                <a href="<?php echo $phone['link']; ?>" class="name">
                                                    <?php echo $phone['name']; ?>
                                                </a>
                                                <p class="item">
                                                    <?php echo $lists['Item'], $phone['sku']; ?>
                                                </p>
                                                <p>
                                                    <?php
                                                    if($phone['org_price'])
                                                    {
                                                    ?>
                                                        <del>
                                                            <?php echo Site::instance()->price($phone['org_price'], 'code_view'); ?>
                                                        </del>       
                                                   <b class="red">
                                                        <?php echo Site::instance()->price($phone['price'], 'code_view'); ?>
                                                    </b>
                                                    <?php
                                                    }else{ ?>
                                                   <b>
                                                        <?php echo Site::instance()->price($phone['price'], 'code_view'); ?>
                                                    </b>

                                            <?php        }
                                                    ?>

                                                </p>
                                                <p></p>

                                                <ul class="cart-option">
                                                    <li>
                                                    <?php
                                                    if($phone['size'])
                                                    {
                                                    ?>
                                                        <label><?php echo $lists['size']; ?> </label>
                                                        <span class="cart-size"><?php echo $phone['size']; ?></span>
                                                    <?php
                                                    }
                                                    ?>
                                                    </li>
                                                    <li>
                                                        <label><?php echo $lists['quantity']; ?> </label>
                                                        <span class="cart-size"><?php echo $phone['quantity']; ?></span>
                                                    </li>
                                                </ul>
                                                <p></p>
                                                <p class="delete"><a href="<?php echo LANGPATH; ?>/cart/largess_delete/<?php echo $phone['key']; ?>" class="a-underline"><?php echo $lists['Delete']; ?></a></p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                }
                             }
                            ?>  
                            </tbody>
                        </table>

                        <!-- Special Offers -->
                        <?php
                        if (!empty($cart['largesses_for_choosing']) AND !$celebrity_avoid)
                        {
                            foreach ($cart['largesses_for_choosing'] as $largesses_for_choosing)
                            {
                                ?>
                                <table class="shopping-table pc-tb" width="100%">
                                    <tr>
                                        <th colspan="1" class="offers"><?php echo $lists['Special Offers']; ?></th>
                                        <th colspan="4"><?php if(isset($largesses_for_choosing['brief'])){ echo $largesses_for_choosing['brief']; } ?></th>
                                    </tr>
                                    <?php
                                    $num = 1;
                                    foreach ($largesses_for_choosing['largesses'] as $key => $largesses_for_choosing_product)
                                    {
                                        if ($num > 3)
                                            break;
                                        $stock = Product::instance($key)->get('stock');
                                        if ($stock != -99 AND $stock == 0)
                                            continue;
                                        $num++;
                                        ?>
                                        <form method="POST" action="<?php echo LANGPATH; ?>/cart/largess_add">
                                            <tr>
                                                <td width="50%">
                                                    <div class="clearfix">
                                                        <div class="left"><a href="<?php echo Product::instance($key)->permalink(); ?>"><img src="<?php echo image::link(Product::instance($key)->cover_image(), 3); ?>" /></a></div>
                                                        <div class="right">
                                                            <a href="<?php echo Product::instance($key)->permalink(); ?>" class="name"><?php echo Product::instance($key,LANGUAGE)->get('name'); ?></a>
                                                            <p class="item"><?php echo $lists['Item']; ?><?php echo Product::instance($key)->get('sku'); ?></p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="15%">
                                                    <?php
                                                    $orig_price = Product::instance($key)->get('price');
                                                    if ($orig_price > $largesses_for_choosing_product['price']):
                                                        ?>
                                                        <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del>
                                                        <?php
                                                    endif;
                                                    ?>
                                                    <p><b class="red"><?php echo Site::instance()->price($largesses_for_choosing_product['price'], 'code_view'); ?></b></p>
                                                </td>
                                                <td width="20%">
                                                    <input type="hidden" name="promotion_id" value="<?php echo $largesses_for_choosing['promotion_id']; ?>" />
                                                    <input type="hidden" name="id" value="<?php echo $key; ?>" />
                                                    <input type="hidden" name="items[]" value="<?php echo $key; ?>" />
                                                    <ul class="cart-option">
                                                        <li>
                                                            <?php
                                                            if(Product::instance($key)->get('stock') == -1)
                                                            {
                                                                $l_stocks = DB::select('attributes', 'stocks')->from('products_stocks')->where('product_id', '=', $key)->execute();
                                                                ?>
                                                                <label><?php echo $lists['size'];?></label>
                                                                <select name="attributes[Size]">
                                                                <?php
                                                                foreach ($l_stocks as $attribute)
                                                                {
                                                                    if($attribute['stocks'] <= 0)
                                                                        continue;
                                                                    ?>
                                                                    <option value="<?php echo $attribute['attributes']; ?>"><?php echo $attribute['attributes']; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                                </select>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                $attributes = Product::instance($key)->get('attributes');
                                                                ?>
                                                                <label><?php echo $lists['size'];?></label>
                                                                    <select name="attributes[Size]">
                                                                <?php
                                                                foreach ($attributes['Size'] as $n => $attribute)
                                                                {
                                                                    ?>

                                                                        <option value="<?php echo $attribute; ?>"><?php echo $attribute; ?></option>



                                                                    <?php
                                                                }?>
                                                                    </select>
                                                                <?php
                                                            }
                                                            ?>
                                                        </li>
                                                        <li>
                                                            <label><?php echo $lists['quantity'];?> </label>
                                                            <select name="quantity">
                                                                <?php
                                                                for ($i = 1; $i <= $largesses_for_choosing_product['available_quantity']; $i++):
                                                                    ?>
                                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                                    <?php
                                                                endfor;
                                                                ?>
                                                            </select>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td width="15%"><input type="submit" value="<?php echo $lists['Take This Offer'];?>" class="btn btn-default btn-xs" /></td>
                                            </tr>
                                        </form>
                                        <?php
                                    }
                                    ?>
                                </table>

                            <table class="shopping-table phone-tb" width="100%" style="background:#fafafa;">
                                    <tr >
                                        <td style="padding:0 0 0 15px;font-weight:bold;"><?php echo $lists['quantity'];?>Special Offers</td>
                                    </tr>
                                    <tr >
                                        <td style="padding:0 0 0 15px; color:#999"><?php if(isset($largesses_for_choosing['brief'])){ echo $largesses_for_choosing['brief']; } ?></td>
                                    </tr>
                                    <?php
                                    $num = 1;
                                    foreach ($largesses_for_choosing['largesses'] as $key => $largesses_for_choosing_product)
                                    {
                                        if ($num > 3)
                                            break; ?>
                                <form action="<?php echo LANGPATH; ?>/cart/largess_add" method="post">
                                <input type="hidden" name="promotion_id" value="<?php echo $largesses_for_choosing['promotion_id']; ?>" />
                                <input type="hidden" name="id" value="<?php echo $key; ?>" />
                                <input type="hidden" name="items[]" value="<?php echo $key; ?>" />
                                    <tr>
                                        <td style="padding: 10px 0px">
                                            <div class="clearfix">
                                                <div class="left"><a href="<?php echo Product::instance($key)->permalink(); ?>"><img src="<?php echo image::link(Product::instance($key)->cover_image(), 3); ?>" /></a></div>
                                                <div class="right">
                                                    <a href="<?php echo Product::instance($key)->permalink(); ?>" class="name"><?php echo Product::instance($key,LANGUAGE)->get('name'); ?></a>
                                                    <p class="item"><?php echo $lists['Item'];?><?php echo Product::instance($key)->get('sku'); ?></p>
                                                    
                                                    <p>
                                                        <label><?php echo $lists['Price'];?></label>
                                                        <?php
                                                            $orig_price = Product::instance($key)->get('price');
                                                            if ($orig_price > $largesses_for_choosing_product['price']):
                                                        ?>
                                                        <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del>
                                                        <?php endif;?>
                                                        <b class="red"><?php echo Site::instance()->price($largesses_for_choosing_product['price'], 'code_view'); ?></b>
                                                    </p>
                                                    
                                                <ul class="cart-option">
                                                     <li>
                                                        <?php
                                                        if(Product::instance($key)->get('stock') == -1)
                                                        {
                                                            $l_stocks = DB::select('attributes', 'stocks')->from('products_stocks')->where('product_id', '=', $key)->execute();
                                                        ?>
                                                        <select style="padding:0;" class="form-control form-cart" name="attributes[Size]">
                                                        <?php
                                                            foreach ($l_stocks as $attribute) {
                                                                if($attribute['stocks'] <= 0) continue;
                                                        ?>
                                                            <option value="<?php echo $attribute['attributes']; ?>"><?php echo $attribute['attributes']; ?></option>
                                                       <?php }?>
                                                       </select>
                                                       <?php }else{
                                                            $attributes = Product::instance($key)->get('attributes');
                                                            foreach ($attributes as $n => $attribute)
                                                            {
                                                      ?>
                                                      <label><?php echo $n; ?>:</label>
                                                      <select style="padding:0;" class="form-control form-cart" name="attributes[<?php echo $n; ?>]">
                                                      <?php foreach ($attribute as $att) { ?>
                                                            <option style="h" value="<?php echo $att; ?>"><?php echo $att; ?></option>
                                                      <?php }?>
                                                      </select>
                                                      <?php }}?>
                                                      </li>
                                                    </ul>
                                                    
                                                    <ul class="cart-option">
                                                     <li>
                                                        <label><?php echo $lists['QTY'];?> </label>
                                                        <select style="padding:0;" class="form-control form-cart" name="quantity">
                                                            <?php for ($i = 1; $i <= $largesses_for_choosing_product['available_quantity']; $i++):?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                            <?php endfor;?>
                                                        </select>
                                                     </li>
                                                    </ul>                                            
                                                    <p class="delete">
                                                        <input type="submit" class="btn btn-default btn-xs" value="<?php echo $lists['Take This Offer'];?>">
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>  
                                     </form> 
                                     <?php } ?>  
                                    <tr>
                                    </tr> 

                            </table>
                                <?php
                            }
                            ?>
                            <script type="text/javascript">
                                $(function(){
                                    $(".wdrop li").live('click', function(){
                                        var val = $(this).text();
                                        $(this).parent().parent().parent().parent().find('input').val(val);
                                        return false;
                                    })
                                })
                            </script>
                            <?php
                        }
                        ?>
                        <ul class="shopping-total">
                            <li class="first" style="padding-left:10px;">

                                <?php if (!empty($largess_words) AND !$celebrity_avoid): ?>
                                    <em><?php echo implode(' / ', $largess_words); ?></em><br>
                                <?php endif; ?>
                                <?php if (!empty($sale_words) AND $cart['amount']['total'] > 0): ?>
                                    <em><?php echo implode(' , ', $sale_words); ?></em><br>
                                <?php endif; ?>


                                <?php if ($cart['extra_flg'] && (int)$cart['amount']['items'] != 0){ ?>
                                    <a href="<?php echo LANGPATH; ?>/top-sellers"><?php echo $lists['message2'];?>>></a>
                                <?php }elseif((int)$cart['amount']['items'] == 0){ ?>
                                    <p style="color:black"><b><?php echo $lists['message3'];?><b></p>
                                <?php }?>


                                <a href="<?php echo LANGPATH.$catalog_link; ?>" class="a-underline"><< <?php echo $lists['Continue Shopping'];?></a>
                            </li>

                            <li class="c1"><label><?php echo $lists['Subtotal'];?></label><strong><?php echo Site::instance()->price($subtotal, 'code_view'); ?></strong></li>
                            <li class="red c1">
                                <?php
                                $cart_save = 0;
                                if ($cart['amount']['save'])
                                {
                                    if (isset($cart['promotion_logs']['cart']))
                                    {
                                        foreach ($cart['promotion_logs']['cart'] as $p_cart)
                                        {
                                            if ($p_cart['save'])
                                            {
                                                $cart_save += $p_cart['save'];
                                            }
                                        }
                                    }
                                }
                                ?>
                                <?php
                                if ($save > 0)
                                {
                                    ?>
                                    <label><?php echo $lists['Product Saving'];?></label>
                                    <strong><?php echo Site::instance()->price($save, 'code_view'); ?></strong><br/>
                                    <?php
                                }
                                if ($cart_save > 0)
                                {
                                    ?>
                                    <label><?php echo $lists['Cart Saving'];?>:</label>
                                    <strong><?php echo Site::instance()->price($cart_save, 'code_view'); ?></strong>
                                    <?php
                                }
                                ?>
                            </li>
							<li class="bottom b1">
							<?php
                            if($cart['amount']['items']<15)
                            {
                                $add_price=15-$cart['amount']['items']
                            ?>
                                <p class="hidden-xs"><?php echo $lists['Add'];?> <span><?php echo Site::instance()->price($add_price,'code_view');?></span> <?php echo $lists['message4'];?><b></b>. </p>
                            <?php
                            }
                            ?>
							<label><?php echo $lists['TOTAL'];?></label><strong><?php echo Site::instance()->price($cart['amount']['items'] - $cart_save, 'code_view'); ?></strong>
							</li>
							<?php
                            if($cart['amount']['items']<15)
                            {
                                $add_price=15-$cart['amount']['items']
                            ?>
							<li class="cart-phone-tip hidden-sm hidden-md hidden-lg">
					            	<p><?php echo $lists['Add'];?> <span class="red"><?php echo Site::instance()->price($add_price,'code_view');?></span> <?php echo $lists['message5'];?></p>
							</li>
							<?php
                            }
                            ?>
                            <div class="clearfix"></div>
                            <li class="bottom">
                        <?php    if((int)$cart['amount']['items'] == 0){ ?>
                                    <div class="visible-xs-block  mb10 mr20 ml20">
                                        <em><?php echo $lists['message6'];?></em>
                                    </div>
                        <?php } ?>
                                <a href="<?php echo LANGPATH; ?>/cart/checkout" class="btn btn-primary btn-lg"><?php echo $lists['Proceed to checkout'];?></a>
                            </li>
                            <li class="bottom last">
                              <!--  <div><b class="red">TIP!</b> Just Checkout to Use Your Points & Coupons.</div> -->
                        <?php if($customer_id = Customer::logged_in()){ ?>
                                <div><?php echo $lists['message7'];?></div>
                        <?php }else{ ?>
                                <div><?php echo $lists['message8'];?></div>
                        <?php } ?>
                            </li>
                        </ul>
                    </div>

                    <?php if(count($cartcookie)>0){//cartcookie ?>
                    <div class="saved-items">
                        <div class="title">
                            <strong><?php echo $lists['Your Saved Items'];?></strong>
                        </div>
                        <table class="shopping-table pc-tb" width="100%">
                            <tr>
                                <th width="50%" class="first"><?php echo $lists['NAME'];?></th>
                                <th width="15%"><?php echo $lists['PRICE'];?></th>
                                <th width="20%"><?php echo $lists['OPTION'];?> </th>
                                <th width="15%"><?php echo $lists['TOTAL'];?></th>
                            </tr>
                            <?php
                            $phone_saves = array();
                            foreach ($cartcookie as $key => $value)
                            { 
                                $cookie_product = Product::instance($value['id'],LANGUAGE);
                                $value['price'] = $cookie_product->price();
                                $cookie_link = $cookie_product->permalink();
                                $stock = $cookie_product->get('stock');
                                $cname = $cookie_product->get('name');
                                $status = $cookie_product->get('status');
                                $visibility = $cookie_product->get('visibility');
                                $cimage = image::link($cookie_product->cover_image(), 3);
                                $csku = $cookie_product->get('sku');

                                $_phone_save = array();
                                $_phone_save['id'] = $value['id'];
                                $_phone_save['items'][0] = $value['items'][0];
                                $_phone_save['key'] = $key;
                                $_phone_save['name'] = $cname;
                                $_phone_save['link'] = $cookie_link;
                                $_phone_save['image'] = $cimage;
                                $_phone_save['sku'] = $csku;
                                $_phone_save['size'] = $value['attributes']['Size'];
                                $_phone_save['size_value'] = $value['attributes']['Size_value'];
                                $_phone_save['quantity'] = $value['quantity'];
                                $_phone_save['price'] = $value['price'];
                                $_phone_save['stock'] = $stock;
                                $_phone_save['status'] = $status;
                                $_phone_save['visibility'] = $visibility;
                                $phone_saves[] = $_phone_save;

                                if ($cookie_product->get('visibility') AND $cookie_product->get('status') AND $stock!=0 )
                                {
                            ?>
                            <tr>
                              <td>
                                <div class="clearfix">
                                  <div class="left"><a href="<?php echo $cookie_link; ?>"><img src="<?php echo $cimage; ?>" alt="<?php echo $cname; ?>" /></a></div>
                                  <div class="right">
                                    <a href="<?php echo $cookie_link; ?>" class="name"><?php echo $cname; ?></a>
                                    <p class="item"><?php echo $lists['Item'], $csku; ?></p>
                                    <p class="delete">
                                        <!--a href="<?php //echo LANGPATH; ?>/wishlist/cookie_add/<?php //echo $key; ?>?return=cart" class="a-underline">Save to Wishlist</a-->
                                        <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $value['items'][0].'_'.$value['attributes']['Size_value'];?>" onclick="if(!confirm('<?php echo $lists['js_message1'];?>')){return false;}" class="a-underline fll" ><?php echo $lists['Delete'];?></a>

                                        <span style="margin:3px 10px;float:left">|</span>
                                        <a href="<?php echo LANGPATH; ?>/cart/cookie2cart/<?php echo $value['items'][0].'_'.$value['attributes']['Size_value'];?>" class="a-underline fll green" ><?php echo $lists['Add To Cart'];?></a>
                                    </p>
                                  </div>
                                </div>
                              </td>
                              <td>
                                <?php
                                $origial_price = $cookie_product->get('price');
                                $subtotal += $origial_price * $value['quantity'];
                                if ($origial_price > $value['price']){
                                    $save += ($origial_price - $value['price']) * $value['quantity']; ?>
                                    <del><?php echo Site::instance()->price($origial_price, 'code_view'); ?></del>
                                    <p><b class="red"><?php echo Site::instance()->price($value['price'], 'code_view'); ?></b></p>
                                <?php }else{ ?>
                                    <p><b><?php echo Site::instance()->price($value['price'], 'code_view'); ?></b></p>
                                <?php } ?>
                                <?php if(isset($value['expired'])){ 
                                $end_day = strtotime(date('Y-m-d', $value['expired']) . ' - 1 month');
                                ?>
                                <p class="flash mt5"><img src="<?php echo STATICURL; ?>/ximg/flsa_btn.png" /></p>
                                <div style="display:block;">
                                    <p class="font11 mt5"><?php echo $lists['Sale Ends'];?></p>
                                    <p class="font11 red"><strong  style="font-size:14px;" class="JS_RemainD<?php echo $value['id'];?>"></strong>d <strong style="font-size:14px;" class="JS_RemainH<?php echo $value['id'];?>"></strong>h <strong style="font-size:14px;" class="JS_RemainM<?php echo $value['id'];?>"></strong>m <strong style="font-size:14px;" class="JS_RemainS<?php echo $value['id'];?>"></strong>s</p>
                                </div>
                                <?php } ?>
                                </td>
                                <script type="text/javascript">
                                    /* time left */
                                    function GetRTime<?php echo $value['id'];?>(){
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
                                            $(".JS_dao<?php echo $value['id']; ?>").html("Time Over!");
                                        }else{
                                            $(".JS_RemainD<?php echo $value['id']; ?>").text(nD);
                                            $(".JS_RemainH<?php echo $value['id']; ?>").text(nH);
                                            $(".JS_RemainM<?php echo $value['id']; ?>").text(nM);
                                            $(".JS_RemainS<?php echo $value['id']; ?>").text(nS); 
                                        }
                                    }
                                    $(document).ready(function () {
                                        var timer_rt = window.setInterval("GetRTime<?php echo $value['id']; ?>()", 1000);
                                    });
                                </script>
                                <td>
                                <ul class="cart-option" style="display: block;">
                                    <li>
                                        <label><?php echo $lists['size'];?>  </label>
                                        <span class="cart-size"><?php echo $value['attributes']['Size']; ?></span>
                                    </li>
                                    <li>
                                        <label><?php echo $lists['quantity'];?></label>
                                        <span class="cart-size"><?php echo $value['quantity']; ?></span>
                                    </li>
                                </ul>
                              </td>
                              <td><b class="font14"><?php echo Site::instance()->price($value['price'], 'code_view'); ?></b></td>
                            </tr>
                            <?php }else{ ?>
                            <tr class="stock">
                              <td>
                                <div class="clearfix">
                                  <div class="left"><a href="<?php echo $cookie_link; ?>"><img src="<?php echo $cimage; ?>" alt="<?php echo $cname; ?>" /></a></div>
                                  <div class="right">
                                    <a href="<?php echo $cookie_link; ?>" class="name"><?php echo $cname; ?></a>
                                    <p class="item"><?php echo $lists['Item'], $csku; ?><span class="red font11 ml5"><?php echo  $lists['out of stock'];?></span></p>
                                    <p class="delete">
                                        <!--a href="<?php //echo LANGPATH; ?>/wishlist/cookie_add/<?php //echo $key; ?>?return=cart" class="a-underline">Save to Wishlist</a-->
                                        <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $value['items'][0].'_'.$value['attributes']['Size_value'];?>" class="a-underline fll"><?php echo $lists['Delete'];?></a>
                                    </p>
                                  </div>
                                </div>
                              </td>
                              <td>
                                <p><b class="gray"><?php echo Site::instance()->price($value['price'], 'code_view'); ?></b></p>
                              </td>
                              <td>
                                <ul class="cart-option gray" style="display: block;">
                                  <li>
                                      <label><?php echo $lists['size'];?>  </label>
                                      <span class="cart-size"><?php echo $value['attributes']['Size']; ?></span>
                                  </li>
                                  <li>
                                      <label><?php echo $lists['quantity'];?> </label>
                                      <span class="cart-size"><?php echo $value['quantity']; ?></span>
                                  </li>
                                </ul>
                              </td>
                              <td><b class="font14 gray"><?php echo Site::instance()->price($value['price'], 'code_view'); ?></b></td>
                            </tr>
                            <?php } } ?>
                        </table>
                        <table class="shopping-table phone-tb" width="100%">
                            <tbody>
                            <?php
                            foreach($phone_saves as $psave)
                            {
                            ?>
                                <tr class="<?php if(!$psave['stock']) echo 'stock'; ?>">
                                    <td>
                                        <div class="clearfix">
                                            <div class="left">
                                                <a href="<?php echo $psave['link']; ?>">
                                                    <img src="<?php echo $psave['image']; ?>" alt="<?php echo $psave['name']; ?>">
                                                </a>
                                            </div>
                                            <div class="right">
                                                <a href="<?php echo $psave['link']; ?>" class="name">
                                                    <?php echo $psave['name']; ?>
                                                </a>
                                                <p class="item">
                                                    <?php echo  $lists['Item'],$psave['sku']; ?> <?php if(!$psave['stock']): ?><span class="red"><?php echo  $lists['out of stock'];?></span><?php endif; ?>
                                                </p>
                                                <p>
                                                    <b class="red">
                                                        <?php echo Site::instance()->price($psave['price'], 'code_view'); ?>
                                                    </b>
                                                </p>
                                                <p></p>
                                                <ul class="cart-option">
                                                    <li>
                                                        <label><?php echo $lists['size'];?></label>
                                                        <?php echo $psave['size']; ?>
                                                    </li>
                                                    <li>
                                                        <label><?php echo $lists['quantity'];?></label>
                                                        <?php echo $psave['quantity']; ?>
                                                    </li>
                                                </ul>
                                                <p></p>
                                                <p class="delete">
                                                    <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $psave['items'][0].'_'.$psave['size_value'];?>" class="a-underline fll"><?php echo $lists['Delete'];?></a>
                                                    <?php
                                if ($psave['visibility'] AND $psave['status'] AND $psave['stock'])
                                {

                                                        ?>
                                                        <span class="v-line">|</span>
                                                        <a href="<?php echo LANGPATH; ?>/cart/cookie2cart/<?php echo $psave['items'][0].'_'.$psave['size_value'];?>" class="a-underline fll green"><?php echo $lists['Add To Cart'];?></a>
                                                        <?php
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        
                        <P class="mb20"><?php echo $lists['message'];?></P>
                        <?php } ?>
                        <div class="cartbag-bottom">
                            <a target="_blank" class="s1" href="<?php echo LANGPATH; ?>/privacy-security"><?php echo $lists['Guaranteed Secure Checkout'];?></a><a class="s2" target="_blank" href="<?php echo LANGPATH; ?>/shipping-delivery">Free Worldwide Shipping</a><a class="s3" target="_blank" href="<?php echo LANGPATH; ?>/returns-exchange">60 Day Money Back Warranty</a>
                        </div>
                    </div>
                    <?php
                }
                ?>
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
        </div>
    </div>
</div>

<!-- JS-popwincon1 -->
<div class="JS-popwincon1 popwincon w_signup hide">
    <a class="JS-close2 close-btn3"></a>
    <div class="w-signup" id="sign_in_up">
        <div class="left col-sm-6 col-xs-12" style="width:388px;margin-right: 0px;padding-right:30px;">
            <h3><?php echo $lists['CHOIES Member Sign In'];?></h3>
            <div id="customer_pid" style="display:none;"></div>
            <form action="#" method="post" class="signin-form sign-form form" id="form_login">
                <ul>
                    <li>
                        <label><?php echo $lists['Email address'];?> </label>
                        <input type="text" value="" name="email" class="text" id="email1" />
                    </li>
                    <li>
                        <label><?php echo $lists['Password'];?> </label>
                        <input type="password" value="" name="password" class="text" maxlength="16" id="password1" />
                    </li>
                    <li><input type="submit" value="<?php echo $lists['Sign In'];?>" name="submit" class="btn btn-primary btn-lg mr10" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline"><?php echo $lists['Forgot password'];?></a></li>
                    <li>
                        <?php
                        $page = BASEURL . URL::current(0);
                        $facebook = new facebook();
                        $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                        ?>
                        <a href="<?php echo $loginUrl; ?>" class="facebook-btn"><?php echo $lists['Sign in with Facebook'];?></a>
                    </li>
                </ul>
            </form>
        </div>
        <div class="right col-sm-6 col-xs-12">
            <h3><?php echo $lists['CHOIES Member Sign Up'];?></h3>
            <form action="#" method="post" class="signup-form sign-form form" id="form_register">
                <ul>
                    <li>
                        <label><?php echo $lists['Email address'];?> </label>
                        <input type="text" value="" name="email" class="text" id="email2" />
                    </li>
                    <li>
                        <label><?php echo $lists['Password'];?> </label>
                        <input type="password" value="" name="password" class="text" id="password2" maxlength="16" />
                    </li>
                    <li>
                        <label><?php echo $lists['Confirm password'];?> </label>
                        <input type="password" value="" name="password_confirm" id="password_confirm" class="text" maxlength="16" />
                    </li>
                    <li><input type="submit" value="<?php echo $lists['Sign In'];?>" name="submit" class="btn btn-primary btn-lg mr10" /></li>
                </ul>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        //check email exists
        $("#email1, #email2").change(function(){
            var email = $(this).val();
            var has = email.indexOf('@');
            if(has != -1)
            {
                $.post(
                    '/customer/email_exists',
                    {
                        email: email
                    },
                    function(result)
                    {
                        if(result != 1)
                        {
                            if (!window.confirm('Are you sure that your email address is ended with ' + result + '?'))
                            {
                                $("#email").focus().select();
                            }
                        }
                    },
                    'json'
                );
            }
            
        })
        
        // signin-form 
        $(".signin-form").validate({
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

        // signup-form 
        $(".signup-form").validate({
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

<script type="text/javascript">
ga('ec:setAction','checkout', {'step': 1});

ga('send', 'pageview');
    var product_price = <?php echo $cart['amount']['items']; ?>;
    function ppecPay()
    {
        if(product_price <= 0)
        {
            alert('Shopping Cart cannot be empty');
            return false;
        }
        location.href="/payment/ppec_set";
    }
</script>
<!--<script>
    //cartcookie 
    $(function(){
        $("p.flash").hover(function(){
            $(this).next().show();
        },function(){
            $(this).next().hide();
        })
    }) 
</script>-->
<script type="text/javascript">

    $(function(){
        $(".change_detail").click(function(){
            $(this).parent().parent().hide();
            $(this).parent().parent().parent().find('form').show();
            return false;
        })
    
        $(".change_cancel").click(function(){
            $(this).parent().parent().parent().hide();
            $(this).parent().parent().parent().parent().find('.cart-option').show();
            return false;
        })
    })
</script>
<?php 
$allsku=$allskus=$allqty=array();
$allname = array();
$allcataname = array();
foreach ($cart['products'] as $key => $product)
{
    $product_obj = Product::instance($product['id'],LANGUAGE);
    $sku = $product_obj->get('sku');
    $name = $product_obj->get('name');
    $current_catalog = $product_obj->default_catalog();
    $cataname = Catalog::instance($current_catalog)->get("name");
    $allsku[]="['cartItem', '".$sku."']";
    $allskus[]=$sku;
    $allname[]='"'.$name.'"';
    $allcataname[]='"'.$cataname.'"';
    $allqty[]=$product['quantity'];
    if(isset($product['id'])){
        $allid[]="'".$product['id']."'";
    }
}

$sqStr=implode(",", $allsku);
$sqStrs=implode(",", $allskus);
$sqname = implode(",", $allname);
$sqcataname = implode(",", $allcataname);
$sqQty=implode(",", $allqty);
if(isset($product['id'])){
    $sqid = implode(",", $allid);
}

?>
<?php
if(!empty($sqid))
{
    $currency = Site::instance()->currency();
?>
<script type="text/javascript">
 window._fbq.push(["track", "AddToCart", { content_type: 'product', content_ids: [<?php echo $sqid; ?>], product_catalog_id: '1575263496062031' }]);  
 fbq('track', 'AddToCart'),{
    content_name: [<?php echo isset($sqname) ? $sqname : '';?>],
    content_category: [<?php echo isset($sqcataname) ? $sqcataname : '';?>],
    content_ids: [<?php echo isset($sqid) ? $sqid : ''; ?>],
    content_type: 'product',
    value:"<?php echo round($cart['amount']['items'] - $cart_save,2); ?>",
    currency: "USD"
    };
</script>
<?php
}
?>

<script src="//cdn.optimizely.com/js/557241246.js"></script>

<?php
    $user_id = Customer::logged_in();
    $user_session = Session::instance()->get('user');
    $currency = Site::instance()->currency();
    if(0){
?>
<!-- Criteo Code For Basket Page -->
<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
<script type="text/javascript">
    if (window.innerWidth)
        winWidth = window.innerWidth;
    else if ((document.body) && (document.body.clientWidth))
        winWidth = document.body.clientWidth;
    if(winWidth<=768)
        var  m='m';
    else if((winWidth<=1024))
        var  m='t';
    else
        var m='d';
    window.criteo_q = window.criteo_q || [];
    window.criteo_q.push(
    { event: "manualFlush" },

    { event: "setAccount", account: [23687,23689] }, 
    { event: "setHashedEmail", email: "<?php echo !empty($user_session['email'])? md5($user_session['email']):' '; ?>" },
    { event: "setSiteType", type: m },
    { event: "viewBasket", currency:"<?php echo $currency['name']; ?>",item: [
    <?php foreach (array_reverse($cart['products']) as $key => $product){?>
          { id: "<?php echo $product['id'];?>", price:<?php echo round($product['price'] * $currency['rate'] ,2) ;?>, quantity:<?php echo $product['quantity'];?> },
          <?php } ?>]},

    { event: "flushEvents"},

    { event: "setAccount", account: 23688 },
    { event: "setHashedEmail", email: "<?php echo !empty($user_session['email'])? md5($user_session['email']):' '; ?>" },
    { event: "setSiteType", type: m },
    { event: "viewBasket", currency:"<?php echo $currency['name']; ?>",item: [
    <?php foreach (array_reverse($cart['products']) as $key => $product){?>
          { id: "<?php echo $product['id'];?>", price:<?php echo round($product['price'] * $currency['rate'] ,2) ;?>, quantity:<?php echo $product['quantity'];?> },
          <?php } ?>]},

    { event: "flushEvents"}

    );
</script>
<!-- end Criteo Code For Basket Page -->
<?php } ?>