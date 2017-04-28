<div class="site-content">
    <div class="main-container clearfix">
        <div class="container">
            <?php echo Message::get(); ?>
            <div class="cart cart-view">
                <!-- shopping-bag -->
                <?php
                $end_day = 0;
                $count = Cart::count();
                if (!$count)
                {
                    ?>
                    <div class="clearfix">
                        <strong>Корзина</strong>
                    </div>
                    <div class="cart-empty">
                    <?php if($save_show){ ?>
                        <p>Ваша корзина сейчас пуста.</p>
                        <p>
                            Посмотреть товары в <a href="<?php echo LANGPATH; ?>/customer/wishlist" class="a-underline">избранное</a>&nbsp;или&nbsp;<a href="<?php echo LANGPATH; ?>/ready-to-be-shipped-c-395" class="a-underline">продолжить покупки</a>.
                        </p>
                    <?php }else{ ?>
                        <p>Нет товаров в вашей корзине.</p>
                        <p>
                            Если у вас есть аккаунт с нами, пожалуйста,<a href="<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/cart/view" class="a-underline">ВОЙДИТЕ В</a> систему, чтобы увидеть товары, которые вы ранее добавили.
                        </p>
                    <?php } ?>
                    </div>

                    <div id="saved_items"></div>
                    <?php if(count($cartcookie)>0){ ?>
                        <div class="saved-items">
                            <div class="title">
                                <strong>Ваши Сохраненные Товары</strong>
                            </div> 
                            <table class="shopping-table pc-tb" width="100%">
                                <tbody>
                                    <tr>
                     <th width="50%" class="first">Название</th>                  
                      <th width="15%">Цена</th>   
                      <th width="20%">Вариант</th>                            
                      <th width="15%">Итого</th>
                                    </tr>
                                    <?php
                                    //cartcookie
                                    $subtotal = 0;
                                    $save = 0;
                                    foreach ($cartcookie as $key => $value) { 
                                    $cookie_product = Product::instance($value['id'],LANGUAGE);
                                    $value['price'] = $cookie_product->price();
                                    $cookie_link = $cookie_product->permalink();
                                    $stock = $cookie_product->get('stock');

                                    $cname = $cookie_product->get('name');
                                    $cimage = image::link($cookie_product->cover_image(), 3);
                                    $csku = $cookie_product->get('sku');

                                    $_phone_save = array();
                                    $_phone_save['id'] = $value['id'];
                                    $_phone_save['key'] = $key;
                                    $_phone_save['name'] = $cname;
                                    $_phone_save['link'] = $cookie_link;
                                    $_phone_save['image'] = $cimage;
                                    $_phone_save['sku'] = $csku;
                                    $_phone_save['size'] = $value['attributes']['Size'];
                                    $_phone_save['quantity'] = $value['quantity'];
                                    $_phone_save['price'] = $value['price'];
                                    $_phone_save['stock'] = $stock;
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
                                                    <p class="item">Article: #<?php echo $csku; ?></p>
                                                    <p class="delete"><!--a href="<?php //echo LANGPATH; ?>/wishlist/cookie_add/<?php //echo $key; ?>?return=cart" class="a-underline">Save to Wishlist</a-->
                                                        <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $value['id'].'_'.$value['attributes']['Size'];?>" class="a-underline fll"  onclick="if(!confirm('Вы уверены, что хотите удалить этот товар?')){return false;}">Удалить</a><span style="margin:3px 10px;float:left">|</span>
                                                        <a href="<?php echo LANGPATH; ?>/cart/cookie2cart/<?php echo $value['id'].'_'.$value['attributes']['Size'];?>" class="a-underline fll green">Добавить в корзину</a>
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
                                                <p class="font11 mt5">Распродажа закончится:</p>
                                                <p class="font11 red"><strong style="font-size:14px;" class="JS_RemainD<?php echo $value['id'];?>"></strong>d <strong style="font-size:14px;" class="JS_RemainH<?php echo $value['id'];?>"></strong>h <strong style="font-size:14px;" class="JS_RemainM<?php echo $value['id'];?>"></strong>m <strong style="font-size:14px;" class="JS_RemainS<?php echo $value['id'];?>"></strong>s</p>
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
                                                    <label>Размер: </label>
                                                    <span class="cart-size">
                                                    <?php 
                              $attr_size=str_replace(' ', '', $value['attributes']['Size']);
                                $attr_size=str_replace('onesize', 'только один размер', $attr_size);
                                echo $attr_size;?>
                                                    </span>
                                                </li>
                                                <li>
                                                    <label>Количество: </label>&nbsp;
                                                    <span class="cart-size"><?php echo $value['quantity']; ?></span>
                                                </li>
                                            </ul>
                                        </td>
                                        <td><b class="font14"><?php echo Site::instance()->price($value['price'] * $value['quantity'], 'code_view'); ?></b></td>
                                    </tr>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                    <tr class="stock">
                                      <td>
                                        <div class="clearfix">
                                          <div class="left"><a href="<?php echo $cookie_link; ?>"><img src="<?php echo $cimage; ?>" alt="<?php echo $cname; ?>" /></a></div>
                                          <div class="right">
                                            <a href="<?php echo $cookie_link; ?>" class="name gray"><?php echo $cname; ?></a>
                                            <p class="gray">Товар: #<?php echo $csku; ?><span class="red font11 ml5">Нет в наличии</span></p>
                                            <p class="bottom"><!--a href="<?php //echo LANGPATH; ?>/wishlist/cookie_add/<?php //echo $key; ?>?return=cart" class="a-underline">Save to Wishlist</a-->
                                                <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $value['id'].'_'.$value['attributes']['Size'];?>" class="a-underline">Удалить</a></p>
                                          </div>
                                        </div>
                                      </td>
                                      <td>
                                        <p><b class="gray"><?php echo Site::instance()->price($value['price'], 'code_view'); ?></b></p>
                                      </td>
                                      <td>
                                        <ul class="cart-option gray" style="display: block;">
                                          <li>
                                              <label>Размер:  </label>
                                              <span class="cart-size"><?php 
                              $attr_size=str_replace(' ', '', $value['attributes']['Size']);
                                $attr_size=str_replace('onesize', 'только один размер', $attr_size);
                                echo $attr_size; ?></span>
                                          </li>
                                          <li>
                                              <label>Количество: </label>&nbsp;
                                              <span class="cart-size"><?php echo $value['quantity']; ?></span>
                                          </li>
                                        </ul>
                                      </td>
                                      <td><b class="font14 gray"><?php echo Site::instance()->price($value['price'] * $value['quantity'], 'code_view'); ?></b></td>
                                    </tr>
                                    <?php
                                    }
                                }
                                ?>
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
                                                        Товар: #<?php echo $psave['sku']; ?> <?php if(!$psave['stock']): ?><span class="red">Нет в наличии</span><?php endif; ?>
                                                    </p>
                                                    <p>
                                                        <b>
                                                            <?php echo Site::instance()->price($psave['price'], 'code_view'); ?>
                                                        </b>
                                                    </p>
                                                    <p></p>
                                                    <ul class="cart-option">
                                                        <li>
                                                            <label>Размер: </label>
                                            <?php 
                              $attr_size=str_replace(' ', '', $psave['size']);
                                $attr_size=str_replace('onesize', 'только один размер', $attr_size);
                                                            echo $attr_size;  ?>
                                                        </li>
                                                        <li>
                                                            <label>Количество: </label>&nbsp;
                                                            <?php echo $psave['quantity']; ?>
                                                        </li>
                                                    </ul>
                                                    <p></p>
                                                    <p class="delete">
                                                        <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $psave['id'].'_'.$psave['size'];?>" class="a-underline fll">Удалить</a>

                                                        <?php
                                                        if($psave['stock'])
                                                        {
                                                            ?>
                                                            <span class="v-line">|</span>
                                                            <a href="<?php echo LANGPATH; ?>/cart/cookie2cart/<?php echo $psave['id'].'_'.$psave['size'];?>" class="a-underline fll green" style="margin:0;">Добавить в корзину</a>
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
                            
                            <P class="mb20">Цены и Наличие товаров на Choies может Быть изменяться.Корзина-это временное место для хранения списка товаров и отражает последнюю цену каждых товаров .</P>
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
                        ->where('site_id', '=', Site::instance()->get('id'))
                        ->and_where('is_active', '=', 1)
                        ->and_where('from_date', '<=', time())
                        ->and_where('to_date', '>=', time())
                        ->order_by('priority')
                        ->execute()->as_array();
                    $sale_words = array();
                    $largess_words = array();
                    $wordsArr = array();
                    $cart_promotion_logs = isset($cart['promotion_logs']['cart']) ? $cart['promotion_logs']['cart'] : array();
                    $celebrity_avoid = 0;
                    $customer_id = Customer::logged_in();
                    $catalog_link = LANGPATH . '/';
                    foreach ($cpromotions as $cpromo)
                    {
                        $wordsArr[$cpromo['id']] = $cpromo[LANGUAGE];
                        $actions = unserialize($cpromo['actions']);
                        if ($customer_id AND Customer::instance($customer_id)->is_celebrity())
                            $celebrity_avoid = $cpromo['celebrity_avoid'];
                        if ($actions['action'] == 'largess')
                        {
                            if (empty($cart['largesses_for_choosing']) AND empty($cart['largesses']))
                            {
                                $largess_words[] = $cpromo[LANGUAGE];
                                $restrict = unserialize($cpromo['restrictions']);
                                if (isset($restrict['restrict_catalog']))
                                {
                                    $catalog_link = LANGPATH . '/' . Catalog::instance($restrict['restrict_catalog'])->get('link');
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
                            elseif (isset($cart_promotion_logs[$cpromo['id']]['log']))
                            {
                                $sale_words[] = $cpromo[LANGUAGE] . ': ' . Site::instance()->price($cart_promotion_logs[$cpromo['id']]['save'], 'code_view') . ' off';
                            }
                            elseif (!array_key_exists($cpromo['id'], $cart_promotion_logs))
                            {
                                $restrict = unserialize($cpromo['restrictions']);
                                if (isset($restrict['restrict_catalog']))
                                {
                                    $catalog_link = LANGPATH . '/' . Catalog::instance($restrict['restrict_catalog'])->get('link');
                                    $sale_words[] = $cpromo[LANGUAGE];
                                }
                                else
                                    $sale_words[] = $cpromo[LANGUAGE];
                            }
                        }
                    }
                    ?>
                    <!-- shopping_bag -->
                    <div class="clearfix cart-accept">
                        <div class="fll">
                            <strong>Корзина</strong>
                            <span class="show">Мы принимаем:<img src="<?php echo STATICURL; ?>/assets/images/shopping-bag-accept-0509.png" usemap="#Shopping"></span>
                            <map name="Shopping" id="Shopping">
                                <area target="_blank" shape="rect" coords="525,2,598,43" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&amp;dn=<?php echo URLSTR; ?>&amp;lang=en">
                            </map>
                        </div>
                        <a href="<?php echo LANGPATH; ?>/cart/checkout" class="flr btn btn-primary btn-lg">
                            Оформить заказ
                        </a>
                    </div>
                    <div class="phone-tb">
                        <strong>Корзина</strong>
                    </div>
                    <div class="shopping-bag">
                        <table class="shopping-table pc-tb" width="100%" id="shopping_bag">
                            <tr>
                            <th width="50%" class="first">Название</th>                  
                            <th width="15%">Цена</th>   
                            <th width="20%">Вариант</th>                            
                            <th width="15%">Итого</th>
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
                                $name = Product::instance($product['id'], LANGUAGE)->get('name');
                                $link = Product::instance($product['id'], LANGUAGE)->permalink();
                                $cover_image = image::link(Product::instance($product['id'])->cover_image(), 3);
                                $sku = Product::instance($product['id'], LANGUAGE)->get('sku');
                                $_phone['id'] = $product['id'];
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
                                                <p class="item">Товар: #<?php echo $sku; ?></p>
                                                <p class="delete">
                                                    <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $product['id'].'_'.$product['attributes']['Size'];?>" class="a-underline fll"  onclick="if(!confirm('Вы уверены, что хотите удалить этот товар?')){return false;}">Удалить</a><span style="margin:3px 10px;float:left">|</span>
                                                    <?php if($save_show){ 
                                                         if(!in_array($product['id'],array('56351','56352'))){ ?>
                                                    <a href="<?php echo LANGPATH; ?>/cart/cookie2later/<?php echo $product['id'].'_'.$product['attributes']['Size'];?>" class="a-underline fll green" style="margin:0">Только Сохранить</a>
                                                    <?php
                                                        }
                                                     }else{ ?>
                                                    <a id="sign_in" class="a-underline fll green" href="<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/cart/view">Только Сохранить</a>
                                                    <?php } ?>
                                                </p>
                                                <div style="clear:both"></div>
                                                <?php if(in_array($product['id'],array('56351','56352'))){?>
                                                <div style="color:red">
                                                    Купить сейчас! Подарок будет оставаться здесь в течение только 24 часов!
                                                </div>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        $_phone['org_price'] = 0;
                                        $_phone['price'] = $product['price'];
                                        if (isset($restrictions['restrict_catalog']) || isset($restrictions['restrict_product']))
                                        {
                                            $subtotal += $product['price'] * $product['quantity'];
                                            if (Product::instance($product['id'])->get('set_id') == $restrictions['restrict_catalog'] || $product['id'] == $restrictions['restrict_product'])
                                            {
                                                $_phone['org_price'] = $product['price'];
                                                $_phone['price'] = $sal_price;
                                                $sal_price = $product['price'] * $rate / 100;
                                                $save += ($product['price'] - $sal_price) * $product['quantity'];
                                                ?>
                                                <del><?php echo Site::instance()->price($product['price'], 'code_view'); ?></del>
                                                <p><b class="red"><?php echo Site::instance()->price($sal_price, 'code_view'); ?></b></p>
                                                <?php
                                            }
                                            else
                                            {
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
                                            <p class="font11 mt5">Распродажа закончится:</p>
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
                                                    <label>Размер:</label>
                                                    <select name="attribute">
                                                        <?php
                                                        foreach ($p_attributes[$product['id']] as $key1 => $a)
                                                        {
                                                            $attr = str_replace(' ', '', $a);
                                                        $attr = str_replace('onesize', 'только один размер', $attr);
                                                            $p_stock = isset($p_stocks[$product['id']][$key1]) ? $p_stocks[$product['id']][$key1] : 1000;
                                                            ?>
                                                            <option value="<?php echo $a . '-' . $p_stock; ?>" <?php if ($product['attributes']['Size'] == $a) echo 'selected'; ?>><?php echo $attr; ?></option>
                                                            <?php
                                                        }
                                                        $_phone['p_attributes'] = $p_attributes[$product['id']];
                                                        ?>
                                                    </select>
                                                </li>
                                                <li>
                                                    <label>Количество: </label>&nbsp;
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
                                                    if($stocks > 0)
                                                    {
                                                        ?>
                                                        <li class="red">Теперь Только <span><?php echo $stocks; ?></span> Пунктов</li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <li>
                                                    <input type="reset" value="переустановка" class="btn btn-xs change_cancel" />
                                                    <input type="submit" value="Дальше" class="btn btn-default btn-xs" />
                                                </li>
                                            </ul>
                                        </form>
                                        <ul class="cart-option">
                                            <li>
                                                <label>Размер:  </label>
                                                <span class="cart-size"><?php
                                            $attr_size=str_replace(' ', '', $product['attributes']['Size']);
                                            $attr_size=str_replace('onesize', 'только один размер', $attr_size);
                                                 echo $attr_size; ?></span>
                                            </li>
                                            <li>
                                                <label>Количество: </label>&nbsp;
                                                <span class="cart-size"><?php echo $product['quantity']; ?></span>
                                            </li>
                                            <?php
                                            $_phone['size'] = $attr_size;
                                            $_phone['quantity'] = $product['quantity'];
                                            $_phone['stock'] = $stocks;
                                            if($stocks > 0)
                                            {
                                                ?>
                                                <li class="red">Теперь Только <span><?php echo $stocks; ?></span> Пунктов</li>
                                                <?php
                                            }
                                            ?>
                                            <?php if(!in_array($product['id'],array('56351','56352'))){?>
                                            <li>
                                                <a class="btn btn-default btn-xs change_detail">Изменять детали</a>
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
                                    $l_link = Product::instance($largess['id'], LANGUAGE)->permalink();
                                    $l_name = Product::instance($largess['id'], LANGUAGE)->get('name');
                                    $l_cover_image = image::link(Product::instance($largess['id'], LANGUAGE)->cover_image(), 3);
                                    $l_sku = Product::instance($largess['id'], LANGUAGE)->get('sku');
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
                                                    <p>Товар: #<?php echo $l_sku; ?></p>
                                                    <p class="delete"><a href="<?php echo LANGPATH; ?>/cart/largess_delete/<?php echo $key; ?>" class="a-underline">Удалить</a></p>
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
                                                        <label>Размер: </label>
                                                        <span class="cart-size"><?php echo str_replace('one size', ' только один размер', $largess['attributes']['Size']); ?></span>
                                                    </li>
                                                    <li>
                                                        <label>Количество: </label>
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
                                                    Товар: #<?php echo $phone['sku']; ?>
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
                                                               Размер:
                                                            </label>
                                                            <select name="attribute">
                                                            <?php
                                                            foreach ($phone['p_attributes'] as $key1 => $a)
                                                            {
                                                                 $attr = str_replace(' ', '', $a);
                                                        $attr = str_replace('onesize', 'только один размер', $attr);
                                                                $p_stock = isset($p_stocks[$product['id']][$key1]) ? $p_stocks[$product['id']][$key1] : 1000;
                                                                ?>
                                                                <option value="<?php echo $a . '-' . $p_stock; ?>" <?php if ($product['attributes']['Size'] == $a) echo 'selected'; ?>><?php echo $attr; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                            </select>
                                                        </li>
                                                        <li>
                                                            <label>
                                                               Количество: 
                                                            </label>&nbsp;
                                                            <input value="<?php echo $phone['quantity']; ?>" name="quantity" class="text" type="text">
                                                        </li>
                                                        <?php
                                                        if($phone['stock'] > 0)
                                                        {
                                                            ?>
                                                            <li class="red">Теперь Только  <span><?php echo $phone['stock']; ?></span> restants</li>
                                                            <?php
                                                        }
                                                        ?>
                                                        <li>
                                                            <input type="reset" value="переустановка" class="btn btn-xs change_cancel" />
                                                            <input type="submit" value="Дальше" class="btn btn-default btn-xs" />
                                                        </li>
                                                    </ul>
                                                </form>
                                                <ul class="cart-option">
                                                    <li>
                                                    <?php
                                                    if($phone['size'])
                                                    {
                                                    ?>
                                                        <label>Размер:  </label>
                                                        <span class="cart-size"><?php 
                                                        $attr_size=str_replace(' ', '', $phone['size']);
                                            $attr_size=str_replace('onesize', 'только один размер', $attr_size);
                                            echo $attr_size; ?></span>
                                                    <?php
                                                    }
                                                    ?>
                                                    </li>
                                                    <li>
                                                        <label>Количество: </label>&nbsp;
                                                        <span class="cart-size"><?php echo $phone['quantity']; ?></span>
                                                    </li>
                                                    <?php if(!in_array($phone['id'],array('56351','56352'))){ ?> 
                                                    <li>
                                                        <a class="btn btn-default btn-xs change_detail">Изменять детали</a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                                <p></p>
												<!--ru 小语言 onesize 修改下 不然不好删除-->
												<?php if($phone['size']=='только один размер'){ $phone['size']='one size';}?>
                                                <p class="delete">
                                                    <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $phone['id'].'_'.$phone['size'];?>" class="a-underline fll"  onclick="if(!confirm('Вы уверены, что хотите удалить этот товар?')){return false;}">Удалить</a><span style="margin:3px 10px;float:left">|</span>
                                                    <?php if($save_show){
                                                    if(!in_array($phone['id'],array('56351','56352'))){ ?> 
                                                    <a href="<?php echo LANGPATH; ?>/cart/cookie2later/<?php echo $phone['id'].'_'.$phone['size'];?>" class="a-underline fll green">Добавить в корзину</a>
                                                    <?php } }else{ ?>
                                                    <a id="sign_in" class="a-underline fll green" href="<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/cart/view">Только Сохранить</a>
                                                    <?php } ?>
                                                </p>

                                                <div style="clear:both"></div>
                                                <?php if(in_array($phone['id'],array('56351','56352'))){?>
                                                <div style="color:red">
                                                    Купить сейчас! Подарок будет оставаться здесь в течение только 24 часов!
                                                </div>
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
                                                    Artikel: #<?php echo $phone['sku']; ?>
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
                                                        <label>Размер: </label>
                                                        <span class="cart-size"><?php echo str_replace('one size', ' только один размер', $phone['size']); ?></span>
                                                    <?php
                                                    }
                                                    ?>
                                                    </li>
                                                    <li>
                                                        <label>Количество: </label>
                                                        <span class="cart-size"><?php echo $phone['quantity']; ?></span>
                                                    </li>
                                                </ul>
                                                <p></p>
                                                <p class="delete">
                                                    <a href="<?php echo LANGPATH; ?>/cart/largess_delete/<?php echo $phone['key']; ?>" class="a-underline">Удалить</a>
                                                </p>
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
                            foreach ($cart['largesses_for_choosing'] as $cid => $largesses_for_choosing)
                            {
                                ?>
                                <table class="shopping-table pc-tb" width="100%">
                                    <tr>
                                        <th colspan="1" class="offers">Особые Предложения</th>
                                        <th colspan="4"><?php echo $wordsArr[$cid]; ?></th>
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
                                                        <div class="left"><a href="<?php echo Product::instance($key, LANGUAGE)->permalink(); ?>"><img src="<?php echo image::link(Product::instance($key)->cover_image(), 3); ?>" /></a></div>
                                                        <div class="right">
                                                            <a href="<?php echo Product::instance($key, LANGUAGE)->permalink(); ?>" class="name"><?php echo Product::instance($key, LANGUAGE)->get('name'); ?></a>
                                                            <p class="item">Товар: #<?php echo Product::instance($key)->get('sku'); ?></p>
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
                                                                <label>Размер:</label>
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
                                                                foreach ($attributes as $n => $attribute)
                                                                {
                                                                    ?>
                                                                    <label><?php echo str_replace('Size', 'Размер', $n); ?>:</label>
                                                                    <select name="attributes[<?php echo $n; ?>]">
                                                                    <?php
                                                                    foreach ($attribute as $att)
                                                                    {
                                                                        ?>
                                                                        <option value="<?php echo $att; ?>"><?php echo str_replace('one size', ' только один размер', $att); ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    </select>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </li>
                                                        <li>
                                                            <label>Количество: </label>
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
                                                <td width="15%"><input type="submit" value="Принять данное предложение" class="btn btn-default btn-xs" /></td>
                                            </tr>
                                        </form>
                                        <?php
                                    }
                                    ?>
                                </table>


                            <!--phone largress -->
                            
                            <table class="shopping-table phone-tb" width="100%" style="background:#fafafa;" >
                                    <tr >
                                        <td style="padding:0 0 0 15px;font-weight:bold;">Особые Предложения</td>
                                    </tr>
                                    <tr >
                                        <td style="padding:0 0 0 15px; color:#999"><?php echo $wordsArr[$cid]; ?></td>
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
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="clearfix">
                                                <div class="left"><a href="<?php echo Product::instance($key, LANGUAGE)->permalink(); ?>"><img src="<?php echo image::link(Product::instance($key)->cover_image(), 3); ?>" /></a></div>
                                                <div class="right">
                                                    <a href="<?php echo Product::instance($key, LANGUAGE)->permalink(); ?>" class="name"><?php echo Product::instance($key, LANGUAGE)->get('name'); ?></a>
                                                    <p class="item">Товар: #<?php echo Product::instance($key)->get('sku'); ?></p>
                                                    
                                                    <p>
                                                        <label>Цена:</label>
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
                                                        <label>Размер:</label>
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
                                                      <label>Размер:</label>
                                                      <select style="padding:0;" class="form-control form-cart" name="attributes[<?php echo $n; ?>]">
                                                      <?php foreach ($attribute as $att) { ?>
                                                            <option value="<?php echo $att; ?>"><?php echo str_replace('one size', ' только один размер', $att); ?></option>
                                                      <?php }?>
                                                      </select>
                                                      <?php }}?>
                                                     </li>
                                                    </ul>
                                                    
                                                    <ul class="cart-option">
                                                     <li>
                                                        <label>Количество:</label>
                                                        <select style="padding:0;" class="form-control form-cart" name="quantity">
                                                            <?php for ($i = 1; $i <= $largesses_for_choosing_product['available_quantity']; $i++):?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                            <?php endfor;?>
                                                        </select>
                                                     </li>
                                                    </ul>                                            
                                                    <p class="delete">
                                                        <input class="btn btn-default btn-xs" type="submit" value="Принять данное предложение">
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr> 
                                     </form> 
                                     <?php } ?>   
                                </tbody>
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
                                    <a href="<?php echo LANGPATH; ?>/top-sellers">Добавьте 1+ товар(товара,товаров) с пометкой "Free Shipping" в корзине,Получить Бесплатную Доставку На Весь Ваш Заказ>></a>
                                <?php }elseif((int)$cart['amount']['items'] == 0){ ?>
                                    <p style="color:black"><b>Добавить "Free Shipping" пункта и пользоваться бесплатной доставкой.<b></p>
                                <?php }?>

                                <a href="<?php echo $catalog_link; ?>" class="a-underline"><< Продолжить Покупки</a>
                            </li>
                            <li class="c1"><label>Промежуточный итог:</label><strong><?php echo Site::instance()->price($subtotal, 'code_view'); ?></strong></li>   
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
                                    <label>Экономить:</label>
                                    <strong><?php echo Site::instance()->price($save, 'code_view'); ?></strong><br/>
                                    <?php
                                }
                                if ($cart_save > 0)
                                {
                                    ?>
                                    <label>Сохранение В Корзину:</label>
                                    <strong><?php echo Site::instance()->price($cart_save, 'code_view'); ?></strong>
                                    <?php
                                }
                                ?>
                            </li>
                            <li class="bottom b1"><label>Итого:</label><strong><?php echo Site::instance()->price($cart['amount']['items'] - $cart_save, 'code_view'); ?></strong></li>
                            <div class="clearfix"></div>
                            <li class="bottom">
                        <?php    if((int)$cart['amount']['items'] == 0){ ?>
                                    <div class="visible-xs-block  mb10 mr20 ml20">
                                        <em>Добавить "Free Shipping" пункта и пользоваться бесплатной доставкой.</em>
                                    </div>
                        <?php } ?>
                                <a href="<?php echo LANGPATH; ?>/cart/checkout" class="btn btn-primary btn-lg">Оформить заказ</a>
                            </li>
                            <li class="bottom last">
                                <div><b class="red">Совет!</b> Можно использовать ваши баллы и купоны для оформления заказ.</div>
                            </li>
                        </ul>
                    </div>

                    <?php if(count($cartcookie)>0){//cartcookie ?>
                    <div class="saved-items">
                        <div class="title">
                            <strong>Ваши Сохраненные Товары</strong>
                        </div>
                        <table class="shopping-table pc-tb" width="100%">
                            <tr>
                       <th width="50%" class="first">Название</th>                  
                      <th width="15%">Цена</th>   
                      <th width="20%">Вариант</th>                            
                      <th width="15%">Итого</th>
                            </tr>
                            <?php
                            $phone_saves = array();
                            foreach ($cartcookie as $key => $value)
                            { 
                                $cookie_product = Product::instance($value['id'], LANGUAGE);
                                $value['price'] = $cookie_product->price();
                                $cookie_link = $cookie_product->permalink();
                                $stock = $cookie_product->get('stock');
                                $cname = $cookie_product->get('name');
                                $cimage = image::link($cookie_product->cover_image(), 3);
                                $csku = $cookie_product->get('sku');

                                $_phone_save = array();
                                $_phone_save['id'] = $value['id'];
                                $_phone_save['key'] = $key;
                                $_phone_save['name'] = $cname;
                                $_phone_save['link'] = $cookie_link;
                                $_phone_save['image'] = $cimage;
                                $_phone_save['sku'] = $csku;
                                $_phone_save['size'] = $value['attributes']['Size'];
                                $_phone_save['quantity'] = $value['quantity'];
                                $_phone_save['price'] = $value['price'];
                                $_phone_save['stock'] = $stock;
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
                                    <p class="item">Товар: #<?php echo $csku; ?></p>
                                    <p class="delete">
                                        <!--a href="<?php //echo LANGPATH; ?>/wishlist/cookie_add/<?php //echo $key; ?>?return=cart" class="a-underline">Save to Wishlist</a-->
                                        <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $value['id'].'_'.$value['attributes']['Size'];?>" onclick="if(!confirm('Вы уверены, что хотите удалить этот товар?')){return false;}" class="a-underline fll" >Удалить</a>

                                        <span style="margin:3px 10px;float:left">|</span>
                                        <a href="<?php echo LANGPATH; ?>/cart/cookie2cart/<?php echo $value['id'].'_'.$value['attributes']['Size'];?>" class="a-underline fll green" >Добавить в корзину</a>
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
                                    <p class="font11 mt5">Распродажа закончится:</p>
                                    <p class="font11 red"><strong  style="font-size:14px;" class="JS_RemainD<?php echo $value['id'];?>"></strong>d <strong  style="font-size:14px;" class="JS_RemainH<?php echo $value['id'];?>"></strong>h <strong  style="font-size:14px;" class="JS_RemainM<?php echo $value['id'];?>"></strong>m <strong  style="font-size:14px;" class="JS_RemainS<?php echo $value['id'];?>"></strong>s</p>
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
                                        <label>Размер:  </label>
                                        <span class="cart-size"><?php 
                                $attr_size=str_replace(' ', '', $value['attributes']['Size']);
                                $attr_size=str_replace('onesize', 'только один размер', $attr_size);
                                echo $attr_size;
                                ?></span>
                                    </li>
                                    <li>
                                        <label>Количество: </label>&nbsp;
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
                                    <p class="item">Товар: #<?php echo $csku; ?><span class="red font11 ml5">Нет в наличии</span></p>
                                    <p class="delete">
                                        <!--a href="<?php //echo LANGPATH; ?>/wishlist/cookie_add/<?php //echo $key; ?>?return=cart" class="a-underline">Save to Wishlist</a-->
                                        <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $value['id'].'_'.$value['attributes']['Size'];?>" class="a-underline fll">Удалить</a>
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
                                      <label>Размер:  </label>
                                      <span class="cart-size"><?php 
                                $attr_size=str_replace(' ', '', $value['attributes']['Size']);
                                $attr_size=str_replace('onesize', 'только один размер', $attr_size);
                                echo $attr_size; ?></span>
                                  </li>
                                  <li>
                                      <label>Количество: </label>&nbsp;
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
                                                    Товар: #<?php echo $psave['sku']; ?> <?php if(!$psave['stock']): ?><span class="red">Нет в наличии</span><?php endif; ?>
                                                </p>
                                                <p>
                                                    <b class="red">
                                                        <?php echo Site::instance()->price($psave['price'], 'code_view'); ?>
                                                    </b>
                                                </p>
                                                <p></p>
                                                <ul class="cart-option">
                                                    <li>
                                                        <label>Размер:  </label>
                                                        <?php echo $psave['size']; ?>
                                                    </li>
                                                    <li>
                                                        <label>Количество: </label>&nbsp;
                                                        <?php echo $psave['quantity']; ?>
                                                    </li>
                                                </ul>
                                                <p></p>
                                                <p class="delete">
                                                    <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $psave['id'].'_'.$psave['size'];?>" class="a-underline fll" style="margin:0;">Удалить</a>
                                                    <?php
                                                    if($psave['stock'])
                                                    {
                                                        ?>
                                                        <span class="v-line">|</span>
                                                        <a href="<?php echo LANGPATH; ?>/cart/cookie2cart/<?php echo $psave['id'].'_'.$psave['size'];?>" class="a-underline fll green" style="margin:0;">Добавить в корзину</a>
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
                        
                        <P class="mb20">Цены и Наличие товаров на Choies может Быть изменяться.Корзина-это временное место для хранения списка товаров и отражает последнюю цену каждых товаров .</P>
                        <?php } ?>
                        <div class="cartbag-bottom">
                            <a target="_blank" class="s1" href="<?php echo LANGPATH; ?>/privacy-security">Гарантированная Безопасность заказа</a><a class="s2" target="_blank" href="<?php echo LANGPATH; ?>/shipping-delivery">Бесплатная доставка по всему миру</a><a class="s3" target="_blank" href="<?php echo LANGPATH; ?>/returns-exchange">60-Дневная Гарантия Возврата Денег<</a>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="other-customers" id="alsoview" style="display:none">
                    <div class="w-tit">
                        <h2>РЕКОМЕНДУЕМЫЕ ТОВАРЫ</h2>
                    </div>
                    <div class="box-dibu1">
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
                      <li data-scarabitem="{{= p.id }}" style="display: inline-block" class="rec-item">
                         <a href="{{=p.link}}" id="em{{= p.id }}link">
                          <img src="{{=p.image}}" class="rec-image">
                        </a>
                        <p class="price"><b>${{=p.price}}</b></p>
                      </li>
                        {{ if(i==6 || i==13 || i==20 || i==27){ }}
                        </ul></div>
                        {{ } }}
                    {{ } }}
                    ]]>
                    </script>
                    <div id="personal-recs"></div>
                    <script type="text/javascript">
                    // Request personalized recommendations.
                    Cart = (function() {
                    var cart = [];
                    var render = function() {
                    //    ScarabQueue.push(['cart', cart]);
                        ScarabQueue.push(['recommend', {
                            logic: 'CART',
                            limit: 28,
                            containerId: 'personal-recs',
                            templateId: 'simple-tmpl',
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
                                        url: "/site/emarsysdata?page=product",
                                        dataType: "json",
                                        data:"sku="+psku+"&lang=<?php echo LANGUAGE; ?>",
                                        success: function(data){
                                            for(var o in data){
                                                $("#em"+o+"link").attr("href",data[o]["link"]);
                                                $("#em"+o+"price").html(data[o]["price"]);
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
                                        }
                                });
                                
                                var winWidth = window.innerWidth;
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
                         
                    };
                    return {
                        render: render,
                        add: function(itemId, price) {
                            cart.push({item: itemId, price: price, quantity: 1});
                            render();
                        },
                        remove: function(itemId) {
                            cart = cart.filter(function(e) {
                              return e.item !== itemId;
                            });
                            render();
                        } 
                    };
                    }());
                    Cart.render();
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
                        <h2>РЕКОМЕНДУЕМЫЕ ТОВАРЫ</h2>
                    </div>
                    <div class="flash-sale">
                        <ul class="row" id="phone_scare"></ul>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS-popwincon1 -->
<div class="JS-popwincon1 popwincon w_signup hide">
    <a class="JS-close2 close-btn3"></a>
    <div class="w-signup" id="sign_in_up">
        <div class="left col-sm-6 col-xs-12" style="width:388px;margin-right: 0px;padding-right:30px;">
            <h3>Вход на сайте CHOIES</h3>
            <div id="customer_pid" style="display:none;"></div>
            <form action="#" method="post" class="signin-form sign-form form" id="form_login">
                <ul>
                    <li>
                        <label>Электронная почта: </label>
                        <input type="text" value="" name="email" class="text" id="email1" />
                    </li>
                    <li>
                        <label>Пароль: </label>
                        <input type="password" value="" name="password" class="text" maxlength="16" id="password1" />
                    </li>
                    <li><input type="submit" value="Войти" name="submit" class="btn btn-primary btn-lg mr10" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">Вспомнить пароль?</a></li>
                    <li>
                        <?php
                        $page = BASEURL . URL::current(0);
                        $facebook = new facebook();
                        $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                        ?>
                        <a href="<?php echo $loginUrl; ?>" class="facebook-btn">Войти по Фейсбук</a>
                    </li>
                </ul>
            </form>
        </div>
        <div class="right col-sm-6 col-xs-12">
            <h3>Регистрация CHOIES</h3>
            <form action="#" method="post" class="signup-form sign-form form" id="form_register">
                <ul>
                    <li>
                        <label>Adresse e-mail:  </label>
                        <input type="text" value="" name="email" class="text" id="email2" />
                    </li>
                    <li>
                        <label>Пароль: </label>
                        <input type="password" value="" name="password" class="text" id="password2" maxlength="16" />
                    </li>
                    <li>
                        <label>Повторите пароль: </label>
                        <input type="password" value="" name="password_confirm" id="password_confirm" class="text" maxlength="16" />
                    </li>
                    <li><input type="submit" value="Регистрация" name="submit" class="btn btn-primary btn-lg mr10" /></li>
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
                            if (!window.confirm('Вы уверены, что ваш электронный адрес закончился по' + result + '?'))
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
                required:"Введите адрес вашей электронной почты,пожалуйста.",
                email:"Введите действительный адрес электронной почты,пожалуйста."
            },
            password: {
                required: "Заполните это поле.",
                minlength: "Пароль слишком короткий, не менее 5 символов."
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
                required:"Введите адрес вашей электронной почты,пожалуйста.",
                email:"Введите действительный адрес электронной почты,пожалуйста."
            },
            password: {
                required: "Заполните это поле.",
                minlength: "Пароль слишком короткий, не менее 5 символов."
            },
            password_confirm: {
                required: "Заполните это поле.",
                minlength: "Пароль слишком короткий, не менее 5 символов.",
                equalTo: "Пожалуйста, введите тот же пароль, что и выше."
            }
            }
        });
    </script>
</div>

<script type="text/javascript">
    var product_price = <?php echo $cart['amount']['items']; ?>;
    function ppecPay()
    {
        if(product_price <= 0)
        {
            alert('Корзина не может быть пустым');
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
foreach ($cart['products'] as $key => $product)
{
    $sku = Product::instance($product['id'])->get('sku');
    $allsku[]="['cartItem', '".$sku."']";
    $allskus[]=$sku;
    $allqty[]=$product['quantity'];
    if($product['id'])
    {
        $allid[]="'".$product['id']."'";
    }
}
$sqStr=implode(",", $allsku);
$sqStrs=implode(",", $allskus);
$sqQty=implode(",", $allqty);
if(isset($product['id']) && $product['id'])
{
    $sqid = implode(",", $allid);
    ?>
    <script type="text/javascript">
        window._fbq.push(["track", "AddToCart", { content_type: 'product', content_ids: [<?php echo $sqid; ?>], product_catalog_id: '1575263496062031' }]);  
    </script>
    <?php
}

?>


<script src="//cdn.optimizely.com/js/557241246.js"></script>

    <?php
        $user_id = Customer::logged_in();
        $user_session = Session::instance()->get('user');
        $currency = Site::instance()->currency();
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