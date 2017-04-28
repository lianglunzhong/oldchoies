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
                        <strong>PANIER D’ACHAT</strong>
                    </div>
                    <div class="cart-empty">
                    <?php if($save_show){ ?>
                        <p>Votre panier est vide pour le moment.</p>
                        <p>
                            Voir les articles déjà dans votre&nbsp;<a href="<?php echo LANGPATH; ?>/customer/wishlist" class="a-underline">liste d’envies </a>&nbsp;ounbsp;<a href="<?php echo LANGPATH; ?>/ready-to-be-shipped-c-395" class="a-underline">continuer vos achats</a>.
                        </p>
                    <?php }else{ ?>
                        <p>Il n'y a pas d'articles dans votre panier d’achat.</p>
                        <p>
                            Si vous avez un compte avec nous, <a href="<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/cart/view" class="a-underline">Connectez-vous</a> pour voir les articles que vous avez ajoutés s'il vous plaît.
                        </p>
                    <?php } ?>
                    </div>

                    <div id="saved_items"></div>
                    <?php if(count($cartcookie)>0){ ?>
                        <div class="saved-items">
                            <div class="title">
                                <strong>Vos Articles Sauvegardés</strong>
                            </div> 
                            <table class="shopping-table pc-tb" width="100%">
                                <tbody>
                                    <tr>
                                        <th class="first" width="50%">NOM</th>
                                        <th width="15%">PRIX</th>
                                        <th width="20%">OPTION</th>
                                        <th width="15%">SOUS-TOTAL</th>
                                    </tr>
                                    <?php
                                    //cartcookie
                                    $subtotal = 0;
                                    $save = 0;
                                    foreach ($cartcookie as $key => $value) { 
                                    $cookie_product = Product::instance($value['id'], LANGUAGE);
                                    $value['price'] = $cookie_product->price();
                                    $cookie_link = $cookie_product->permalink();
                                    $stock = $cookie_product->get('stock');

                                    #$cname = $cookie_product->get('name');
                                    $cname = $cookie_product->transname();
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

                                    if ($cookie_product->get('visibility') AND $cookie_product->get('status') AND $stock!=0 ){ ?>
                                    <tr>
                                        <td>
                                            <div class="clearfix">
                                                <div class="left"><a href="<?php echo $cookie_link; ?>"><img src="<?php echo $cimage; ?>" alt="<?php echo $cname; ?>" /></a></div>
                                                <div class="right">
                                                    <a href="<?php echo $cookie_link; ?>" class="name"><?php echo $cname; ?></a>
                                                    <p class="item">Article: #<?php echo $csku; ?></p>
                                                    <p class="delete"><!--a href="<?php //echo LANGPATH; ?>/wishlist/cookie_add/<?php //echo $key; ?>?return=cart" class="a-underline">Save to Wishlist</a-->
                                                        <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $value['id'].'_'.$value['attributes']['Size'];?>" class="a-underline fll"  onclick="if(!confirm('Êtes-vous sûr de vouloir supprimer cet article?')){return false;}">Supprimer</a><span style="margin:3px 10px;float:left">|</span>
                                                        <a href="<?php echo LANGPATH; ?>/cart/cookie2cart/<?php echo $value['id'].'_'.$value['attributes']['Size'];?>" class="a-underline fll green">Ajouter au panier</a>
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
                                                <p class="font11 mt5">Promo se termine:</p>
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
                                                    <label>TAILLE:</label>
                                                    <span class="cart-size"><?php echo $value['attributes']['Size']; ?></span>
                                                </li>
                                                <li>
                                                    <label>Quantité:  </label>
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
                                            <p class="gray">Article: #<?php echo $csku; ?><span class="red font11 ml5">en rupture de stock</span></p>
                                            <p class="bottom"><!--a href="<?php //echo LANGPATH; ?>/wishlist/cookie_add/<?php //echo $key; ?>?return=cart" class="a-underline">Save to Wishlist</a-->
                                                <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $value['id'].'_'.$value['attributes']['Size'];?>" class="a-underline">Supprimer</a></p>
                                          </div>
                                        </div>
                                      </td>
                                      <td>
                                        <p><b class="gray"><?php echo Site::instance()->price($value['price'], 'code_view'); ?></b></p>
                                      </td>
                                      <td>
                                        <ul class="cart-option gray" style="display: block;">
                                          <li>
                                              <label>TAILLE:  44444</label>
                                              <span class="cart-size"><?php echo $value['attributes']['Size']; ?></span>
                                          </li>
                                          <li>
                                              <label>Quantité: </label>
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
                                                        Article: #<?php echo $psave['sku']; ?> <?php if(!$psave['stock']): ?><span class="red">en rupture de stock</span><?php endif; ?>
                                                    </p>
                                                    <p>
                                                        <b>
                                                            <?php echo Site::instance()->price($psave['price'], 'code_view'); ?>
                                                        </b>
                                                    </p>
                                                    <p></p>
                                                    <ul class="cart-option">
                                                        <li>
                                                            <label>TAILLE:</label>
                                                            <?php echo $psave['size']; ?>
                                                        </li>
                                                        <li>
                                                            <label>Quantité:</label>
                                                            <?php echo $psave['quantity']; ?>
                                                        </li>
                                                    </ul>
                                                    <p></p>
                                                    <p class="delete">
                                                        <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $psave['id'].'_'.$psave['size'];?>" class="a-underline fll">Supprimer</a>

                                                        <?php
                                                        if($psave['stock'])
                                                        {
                                                            ?>
                                                            <span class="v-line">|</span>
                                                            <a href="<?php echo LANGPATH; ?>/cart/cookie2cart/<?php echo $psave['id'].'_'.$psave['size'];?>" class="a-underline fll green" style="margin:0;">Ajouter au panier</a>
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
                            
                            <P class="mb20">Le prix et la disponibilité des articles sur Choies sont sujettes à changement. Le panier est un endroit temporaire pour stocker une liste de vos articles et refléter prix le plus récent de chaque article.</P>
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
                            <strong>PANIER D’ACHAT</strong>
                            <span class="show">Nous Acceptons:<img src="<?php echo STATICURL; ?>/assets/images/shopping-bag-accept-0509.png" usemap="#Shopping"></span>
                            <map name="Shopping" id="Shopping">
                                <area target="_blank" shape="rect" coords="525,2,598,43" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&amp;dn=www.choies.com&amp;lang=en">
                            </map>
                        </div>
                        <a href="<?php echo LANGPATH; ?>/cart/checkout" class="flr btn btn-primary btn-lg">
                            PROCÉDER AU PAIEMENT
                        </a>
                    </div>
                    <div class="phone-tb">
                        <strong>PANIER D’ACHAT</strong>
                    </div>
                    <div class="shopping-bag">
                        <table class="shopping-table pc-tb" width="100%" id="shopping_bag">
                            <tr>
                                <th width="50%" class="first">NOM</th>
                                <th width="15%">PRIX</th>
                                <th width="20%">OPTION </th>
                                <th width="15%">SOUS-TOTAL</th>
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
                                #$name = Product::instance($product['id'], LANGUAGE)->get('name');
                                $name = Product::instance($product['id'], LANGUAGE)->transname();
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
                                                <p class="item">Article: #<?php echo $sku; ?></p>
                                                <p class="delete">
                                                    <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $product['id'].'_'.$product['attributes']['Size'];?>" class="a-underline fll"  onclick="if(!confirm('Êtes-vous sûr de vouloir supprimer cet article?')){return false;}">Supprimer</a><span style="margin:3px 10px;float:left">|</span>
                                                    <?php if($save_show){ if(!in_array($product['id'],$giftarr)){ ?>
                                                    <a href="<?php echo LANGPATH; ?>/cart/cookie2later/<?php echo $product['id'].'_'.$product['attributes']['Size'];?>" class="a-underline fll green" style="margin:0">Mettre de côté</a>
                                                    <?php } }else{ ?>
                                                    <a id="sign_in" class="a-underline fll green" href="<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/cart/view">Mettre de côté</a>
                                                    <?php } ?>
                                                </p>
                                                <div style="clear:both"></div>
                                                <?php if(in_array($product['id'],$giftarr)){?>
                                                <div style="color:red">
                                                    J'en Profite! Le cadeau va rester ici pour 24 heures seulement!
                                                </div> 
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
                                            <p class="font11 mt5">Promo se termine:</p>
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
                                                    <label>Taille:</label>
                                                    <select name="attribute">
                                                        <?php
                                                        foreach ($p_attributes[$product['id']] as $key1 => $a)
                                                        {
                                                            $attr = str_replace('one size', 'taille unique', $a);
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
                                                    <label>Quantité: </label>
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
                                                        <li class="red">seulement&nbsp;<span><?php echo $stocks; ?></span> restants</li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <li>
                                                    <input type="reset" value="Annuler" class="btn btn-xs change_cancel" />
                                                    <input type="submit" value="Valider" class="btn btn-default btn-xs" />
                                                </li>
                                            </ul>
                                        </form>
                                        <ul class="cart-option">
                                            <li>
                                                <label>TAILLE:  </label>
                                                <span class="cart-size"><?php echo str_replace('one size', 'taille unique', $product['attributes']['Size']);?></span>
                                            </li>
                                            <li>
                                                <label>Quantité: </label>
                                                <span class="cart-size"><?php echo $product['quantity']; ?></span>
                                            </li>
                                            <?php
                                            $_phone['size'] = $product['attributes']['Size'];
                                            $_phone['quantity'] = $product['quantity'];
                                            $_phone['stock'] = $stocks;
                                            if($stocks > 0)
                                            {
                                                ?>
                                                <li class="red">seulement&nbsp;<span><?php echo $stocks; ?></span>restants</li>
                                                <?php
                                            }
                                            ?>
                                            <?php if(!in_array($product['id'],$giftarr)){?>
                                            <li>
                                                <a class="btn btn-default btn-xs change_detail">Modifier</a>
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
                                    #$l_name = Product::instance($largess['id'], LANGUAGE)->get('name');
                                    $l_name = Product::instance($product['id'], LANGUAGE)->transname();
                                    $l_cover_image = image::link(Product::instance($largess['id'])->cover_image(), 3);
                                    $l_sku = Product::instance($largess['id'])->get('sku');
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
                                                    <p>Article: #<?php echo $l_sku; ?></p>
                                                    <p class="delete"><a href="<?php echo LANGPATH; ?>/cart/largess_delete/<?php echo $key; ?>" class="a-underline">Supprimer</a></p>
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
                                                        <label>TAILLE: </label>
                                                        <span class="cart-size"><?php echo str_replace('one size', 'taille unique', $largess['attributes']['Size']); ?></span>
                                                    </li>
                                                    <li>
                                                        <label>Quantité: </label>
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
                                                    Article: #<?php echo $phone['sku']; ?>
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
                                                                TAILLE:
                                                            </label>
                                                            <select name="attribute">
                                                            <?php
                                                            foreach ($phone['p_attributes'] as $key1 => $a)
                                                            {
                                                                $attr = str_replace('one size', 'taille unique', $a);
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
                                                                Quantité:
                                                            </label>
                                                            <input value="<?php echo $phone['quantity']; ?>" name="quantity" class="text" type="text">
                                                        </li>
                                                        <?php
                                                        if($phone['stock'] > 0)
                                                        {
                                                            ?>
                                                            <li class="red">seulement <span><?php echo $phone['stock']; ?></span> restants</li>
                                                            <?php
                                                        }
                                                        ?>
                                                        <li>
                                                            <input type="reset" value="Annuler" class="btn btn-xs change_cancel" />
                                                            <input type="submit" value="Valider" class="btn btn-default btn-xs" />
                                                        </li>
                                                    </ul>
                                                </form>
                                                <ul class="cart-option">
                                                    <li>
                                                    <?php
                                                    if($phone['size'])
                                                    {
                                                    ?>
                                                        <label>TAILLE: </label>
                                                        <span class="cart-size"><?php echo str_replace('one size', 'taille unique', $phone['size']); ?></span>
                                                    <?php
                                                    }
                                                    ?>
                                                    </li>
                                                    <li>
                                                        <label>Quantité: </label>
                                                        <span class="cart-size"><?php echo $phone['quantity']; ?></span>
                                                    </li>
                                                    <?php if(!in_array($phone['id'],$giftarr)){ ?>
                                                    <li>
                                                        <a class="btn btn-default btn-xs change_detail">Modifier</a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                                <p></p>
                                                <p class="delete">
                                                    <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $phone['id'].'_'.$phone['size'];?>" class="a-underline fll"  onclick="if(!confirm('Êtes-vous sûr de vouloir supprimer cet article?')){return false;}">Supprimer</a><span style="margin:3px 10px;float:left">|</span>
                                                    <?php if($save_show){ if(!in_array($phone['id'],$giftarr)){ ?>
                                                    <a href="<?php echo LANGPATH; ?>/cart/cookie2later/<?php echo $phone['id'].'_'.$phone['size'];?>" class="a-underline fll green">Mettre de côté</a>
                                                    <?php } }else{ ?>
                                                    <a id="sign_in" class="a-underline fll green" href="<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/cart/view">Mettre de côté</a>
                                                    <?php } ?>
                                                </p>

                                                <div style="clear:both"></div>
                                                <?php if(in_array($phone['id'],$giftarr)){?>
                                                <div style="color:red">
                                                    J'en Profite! Le cadeau va rester ici pour 24 heures seulement!
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
                                                    Article: #<?php echo $phone['sku']; ?>
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
                                                        <label>TAILLE: </label>
                                                        <span class="cart-size"><?php echo str_replace('one size', 'eine Größe', $phone['size']); ?></span>
                                                    <?php
                                                    }
                                                    ?>
                                                    </li>
                                                    <li>
                                                        <label>Quantité: </label>
                                                        <span class="cart-size"><?php echo $phone['quantity']; ?></span>
                                                    </li>
                                                </ul>
                                                <p></p>
                                                <p class="delete">
                                                    <a href="<?php echo LANGPATH; ?>/cart/largess_delete/<?php echo $phone['key']; ?>" class="a-underline">Supprimer</a>
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
                            foreach ($cart['largesses_for_choosing'] as $cid =>  $largesses_for_choosing)
                            {
                                ?>
                                <table class="shopping-table pc-tb" width="100%">
                                    <tr>
                                        <th colspan="1" class="offers">Offres Spéciales</th>
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
                                                            <a href="<?php echo Product::instance($key, LANGUAGE)->permalink(); ?>" class="name"><?php echo Product::instance($product['id'], LANGUAGE)->transname(); ?></a>
                                                            <p class="item">Article:#<?php echo Product::instance($key)->get('sku'); ?></p>
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
                                                                <label>TAILLE:</label>
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
                                                                    <label><?php echo str_replace('Size', 'TAILLE', $n); ?>:</label>
                                                                    <select name="attributes[<?php echo $n; ?>]">
                                                                    <?php
                                                                    foreach ($attribute as $att)
                                                                    {
                                                                        ?>
                                                                        <option value="<?php echo $att; ?>"><?php echo str_replace('one size', 'taille unique', $att); ?></option>
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
                                                            <label>Quantité: </label>
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
                                                <td width="15%"><input type="submit" value="Prenez Cette Offre" class="btn btn-default btn-xs" /></td>
                                            </tr>
                                        </form>
                                        <?php
                                    }
                                    ?>
                                </table>

                            <!--phone largress -->
                            <form action="<?php echo LANGPATH; ?>/cart/largess_add" method="post">
                            <table class="shopping-table phone-tb" width="100%" style="background:#fafafa;" >
                                    <tr >
                                        <td style="padding:0 0 0 15px;font-weight:bold;">Offres Spéciales</td>
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
                                                    <p class="item">Article: #<?php echo Product::instance($key)->get('sku'); ?></p>
                                                    
                                                    <p>
                                                        <label>Preis:</label>
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
                                                        <label>TAILLE:</label>
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
                                                      <label><?php echo str_replace('Size', 'TAILLE', $n); ?>:</label>
                                                      <select style="padding:0;" class="form-control form-cart" name="attributes[<?php echo $n; ?>]">
                                                      <?php foreach ($attribute as $att) { ?>
                                                            <option value="<?php echo $att; ?>"><?php echo str_replace('one size', 'taille unique', $att); ?></option>
                                                      <?php }?>
                                                      </select>
                                                      <?php }}?>
                                                     </li>
                                                    </ul>
                                                    
                                                    <ul class="cart-option">
                                                     <li>
                                                        <label>Quantité: </label>
                                                        <select style="padding:0;" class="form-control form-cart" name="quantity">
                                                            <?php for ($i = 1; $i <= $largesses_for_choosing_product['available_quantity']; $i++):?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                            <?php endfor;?>
                                                        </select>
                                                     </li>
                                                    </ul>                                            
                                                    <p class="delete">
                                                        <input type="submit" value="Prenez Cette Offre" class="btn btn-default btn-xs" />
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
                                    <a href="<?php echo LANGPATH; ?>/top-sellers">Ajoutez 1+ Article Marqué "Free Shipping" à Votre Panier,Profitez De La Livraison Gratuite Pour Votre Commande>></a>
                                <?php }elseif((int)$cart['amount']['items'] == 0){ ?>
                                    <p style="color:black"><b>Ajouter "Free Shipping" article de profiter de la livraison gratuite<b></p>
                                <?php }?> 

                                <a href="<?php echo $catalog_link; ?>" class="a-underline"><< continuer vos achats</a>
                            </li>
                            <li class="c1"><label>Sous-total:</label><strong><?php echo Site::instance()->price($subtotal, 'code_view'); ?></strong></li>   
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
                                    <label>Économise:</label>
                                    <strong><?php echo Site::instance()->price($save, 'code_view'); ?></strong><br/>
                                    <?php
                                }
                                if ($cart_save > 0)
                                {
                                    ?>
                                    <label>Économie de Panier:</label>
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
                                <p class="hidden-xs">Ajouter <span><?php echo Site::instance()->price($add_price,'code_view');?></span> d'articles pour profiter la <span>LIVRAISON STANDARD GRATUITE </span><b></b>. </p>
                            <?php
                            }
                            ?>
							<label>TOTAL:</label><strong><?php echo Site::instance()->price($cart['amount']['items'] - $cart_save, 'code_view'); ?></strong>
							</li>
							<?php
                            if($cart['amount']['items']<15)
                            {
                                $add_price=15-$cart['amount']['items']
                            ?>
							<li class="cart-phone-tip hidden-sm hidden-md hidden-lg">
					            <p>Ajouter <span class="red"><?php echo Site::instance()->price($add_price,'code_view');?></span> d'articles pour profiter la <span class="red">livraison standard gratuite</span><b></b>. </p>
							</li>
							<?php
                            }
                            ?>
							<li class="bottom">
                                <a href="<?php echo LANGPATH; ?>/cart/checkout" class="btn btn-primary btn-lg">PROCÉDER AU PAIEMENT</a>
                            </li>
                            <li class="bottom last">
                                <div><b class="red">TIP!</b> N’oubliez pas d’utiliser vos Points & Coupons.</div>
                            </li>
                        </ul>
                    </div>

                    <?php if(count($cartcookie)>0){//cartcookie ?>
                    <div class="saved-items">
                        <div class="title">
                            <strong>Vos Articles Sauvegardés</strong>
                        </div>
                        <table class="shopping-table pc-tb" width="100%">
                            <tr>
                      <th width="50%" class="first">NOM</th>                  
                      <th width="15%">PRIX</th>   
                      <th width="20%">OPTION</th>                            
                      <th width="15%">SOUS-TOTAL</th>
                            </tr>
                            <?php
                            $phone_saves = array();
                            foreach ($cartcookie as $key => $value)
                            { 
                                $cookie_product = Product::instance($value['id'], LANGUAGE);
                                $value['price'] = $cookie_product->price();
                                $cookie_link = $cookie_product->permalink();
                                $stock = $cookie_product->get('stock');
                                #$cname = $cookie_product->get('name');
                                $cname = $cookie_product->transname();
                                $status = $cookie_product->get('status');
                                $visibility = $cookie_product->get('visibility');
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
                                    <p class="item">Article: #<?php echo $csku; ?></p>
                                    <p class="delete">
                                        <!--a href="<?php //echo LANGPATH; ?>/wishlist/cookie_add/<?php //echo $key; ?>?return=cart" class="a-underline">Save to Wishlist</a-->
                                        <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $value['id'].'_'.$value['attributes']['Size'];?>" onclick="if(!confirm('Êtes-vous sûr de vouloir supprimer cet article?')){return false;}" class="a-underline fll" >Supprimer</a>

                                        <span style="margin:3px 10px;float:left">|</span>
                                        <a href="<?php echo LANGPATH; ?>/cart/cookie2cart/<?php echo $value['id'].'_'.$value['attributes']['Size'];?>" class="a-underline fll green" >Ajouter au panier</a>
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
                                    <p class="font11 mt5">Promo se termine:</p>
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
                                        <label>Taille:  </label>
                                        <span class="cart-size"><?php echo str_replace('one size', 'taille unique', $value['attributes']['Size']);?></span>
                                    </li>
                                    <li>
                                        <label>Quantité: </label>
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
                                    <p class="item">Article: #<?php echo $csku; ?><span class="red font11 ml5">en rupture de stock</span></p>
                                    <p class="delete">
                                        <!--a href="<?php //echo LANGPATH; ?>/wishlist/cookie_add/<?php //echo $key; ?>?return=cart" class="a-underline">Save to Wishlist</a-->
                                        <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $value['id'].'_'.$value['attributes']['Size'];?>" class="a-underline fll">Supprimer</a>
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
                                      <label>TAILLE:  </label>
                                      <span class="cart-size"><?php echo str_replace('one size', 'taille unique', $product['attributes']['Size']); ?></span>
                                  </li>
                                  <li>
                                      <label>Quantité: </label>
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
                                                    Article: #<?php echo $psave['sku']; ?> <?php if(!$psave['stock']): ?><span class="red">en rupture de stock</span><?php endif; ?>
                                                </p>
                                                <p>
                                                    <b class="red">
                                                        <?php echo Site::instance()->price($psave['price'], 'code_view'); ?>
                                                    </b>
                                                </p>
                                                <p></p>
                                                <ul class="cart-option">
                                                    <li>
                                                        <label>TAILLE:</label>
                                                        <?php echo str_replace('one size', 'taille unique', $psave['size']); ?>
                                                    </li>
                                                    <li>
                                                        <label>Quantité:</label>
                                                        <?php echo $psave['quantity']; ?>
                                                    </li>
                                                </ul>
                                                <p></p>
                                                <p class="delete">
                                                    <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $psave['id'].'_'.$psave['size'];?>" class="a-underline fll" style="margin:0;">Supprimer</a>
                                                    <?php
                                if ($psave['visibility'] AND $psave['status'] AND $psave['stock'])
                                {
                                                        ?>
                                                        <span class="v-line">|</span>
                                                        <a href="<?php echo LANGPATH; ?>/cart/cookie2cart/<?php echo $psave['id'].'_'.$psave['size'];?>" class="a-underline fll green" style="margin:0;">Ajouter au panier</a>
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
                        
                        <P class="mb20">Le prix et la disponibilité des articles sur Choies sont sujettes à changement. Le panier est un endroit temporaire pour stocker une liste de vos articles et refléter prix le plus récent de chaque article.</P>
                        <?php } ?>
                        <div class="cartbag-bottom">
                            <a target="_blank" class="s1" href="<?php echo LANGPATH; ?>/privacy-security">Payement En Sécurité</a><a class="s2" target="_blank" href="<?php echo LANGPATH; ?>/shipping-delivery">Livraison Internationale Gratuite</a><a class="s3" target="_blank" href="<?php echo LANGPATH; ?>/returns-exchange">Remboursement Dans Les 60 Jours</a>
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
            <h3>Déjà client CHOIES</h3>
            <div id="customer_pid" style="display:none;"></div>
            <form action="#" method="post" class="signin-form sign-form form" id="form_login">
                <ul>
                    <li>
                        <label>Adresse e-mail: </label>
                        <input type="text" value="" name="email" class="text" id="email1" />
                    </li>
                    <li>
                        <label>Mot de passe: </label>
                        <input type="password" value="" name="password" class="text" maxlength="16" id="password1" />
                    </li>
                    <li><input type="submit" value="Sign In" name="submit" class="btn btn-primary btn-lg mr10" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">Mot de passe oublié?</a></li>
                    <li>
                        <?php
                        $page = 'http://' . $_SERVER['COFREE_DOMAIN'] . URL::current(0);
                        $facebook = new facebook();
                        $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                        ?>
                        <a href="<?php echo $loginUrl; ?>" class="facebook-btn">Sign in with Facebook</a>
                    </li>
                </ul>
            </form>
        </div>
        <div class="right col-sm-6 col-xs-12">
            <h3>Nouveau client CHOIES</h3>
            <form action="#" method="post" class="signup-form sign-form form" id="form_register">
                <ul>
                    <li>
                        <label>Adresse e-mail:  </label>
                        <input type="text" value="" name="email" class="text" id="email2" />
                    </li>
                    <li>
                        <label>Mot de passe: </label>
                        <input type="password" value="" name="password" class="text" id="password2" maxlength="16" />
                    </li>
                    <li>
                        <label>Confirmer le mot de passe: </label>
                        <input type="password" value="" name="password_confirm" id="password_confirm" class="text" maxlength="16" />
                    </li>
                    <li><input type="submit" value="VALIDER" name="submit" class="btn btn-primary btn-lg mr10" /></li>
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
                            if (!window.confirm('Êtes-vous sûr que votre adresse email se termine par' + result + '?'))
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
                required:"Veuillez fournir une adresse e-mail.",
                email:"Veuillez entrer une adresse e-mail valide."
            },
            password: {
                required: "Veuillez fournir un mot de passe.",
                minlength: "Votre mot de passe doit comporter au moins 5 caractères."
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
                required:"Veuillez fournir une adresse e-mail.",
                email:"Veuillez entrer une adresse e-mail valide."
            },
            password: {
                required: "Veuillez fournir un mot de passe.",
                minlength: "Votre mot de passe doit comporter au moins 5 caractères."
            },
            password_confirm: {
                required: "Veuillez fournir un mot de passe.",
                minlength: "Votre mot de passe doit comporter au moins 5 caractères.",
                equalTo: "Veuillez entrer le même mot de passe comme ci-dessus."
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
            alert('Le Panier ne peut pas être vide');
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
    $sku = Product::instance($product['id'])->get('sku');
    $name = Product::instance($product['id'])->get('name');
    $current_catalog = Product::instance($product['id'])->default_catalog();
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