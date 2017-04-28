<!-- main begin -->
<section id="main">
    <?php echo Message::get(); ?>
    <!-- main begin -->
    <section class="layout fix">
        <section class="cart cart_view">
            <?php
            $count = Cart::count();
            if (!$count)
            {
                ?>
                <div class="cart_empty">
                    <p>Votre panier est vide pour le moment.</p>
                    <p>
                        Voir les articles déjà dans votre <a href="<?php echo LANGPATH; ?>/customer/wishlist" class="a_underline">Liste d’envies</a> 
                        <?php
                        if(!empty($cartcookie))
                        {
                            ?>
                            , <a href="#saved_items" class="a_underline">liste des articles sauvegardés</a>
                            <?php
                        }
                        ?>
                        ou <a href="<?php echo LANGPATH; ?>/" class="a_underline">continuer vos achats</a>.
                    </p>
                </div>
                <div id="saved_items"></div>
                <?php if(count($cartcookie)>0){ ?>
                <div class="fix mt30">
                    <strong class="fll font18">Vos Articles Sauvegardés</strong>
                </div> 
                <table class="shopping_table mt20" width="100%" >
                    <tr>
                      <th width="35%" class="first">NOM</th>                  
                      <th width="25%">PRIX</th>   
                      <th width="25%">OPTION</th>                            
                      <th width="15%">SOUS-TOTAL</th>
                    </tr>
                    <?php
                    //cartcookie
                    foreach ($cartcookie as $key => $value) { 
                    $cookie_product = Product::instance($value['id'],LANGUAGE);
                    $cookie_link = $cookie_product->permalink();
                    $stock = $cookie_product->get('stock');
                    if ($cookie_product->get('visibility') AND $cookie_product->get('status') AND $stock!=0 ){ ?>
                    <tr>
                        <td>
                            <div class="fix">
                                <div class="left"><a href="<?php echo $cookie_link; ?>"><img src="<?php echo image::link($cookie_product->cover_image(), 3); ?>" alt="<?php echo $cookie_product->get('name'); ?>" /></a></div>
                                <div class="right">
                                    <a href="<?php echo $cookie_link; ?>" class="name"><?php echo $cookie_product->get('name'); ?></a>
                                    <p class="color666">Article: #<?php echo $cookie_product->get('sku'); ?></p>
                                    <p class="bottom"><!--a href="<?php //echo LANGPATH; ?>/wishlist/cookie_add/<?php //echo $key; ?>?return=cart" class="a_underline">Ajouter à votre liste d’envie</a-->
                                        <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $key; ?>" class="a_underline fll"  onclick="if(!confirm('Êtes- vous sûr pour le supprimer?')){return false;}">Supprimer</a><span style="margin:3px 10px;float:left">|</span>
                                        <a href="<?php echo LANGPATH; ?>/cart/cookie2cart/<?php echo $key;?>" class="a_underline fll green">Ajouter au panier</a>
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
                            <p><b class="colored0000"><?php echo Site::instance()->price($value['price'], 'code_view'); ?></b></p>
                        <?php }else{ ?>
                            <p><b><?php echo Site::instance()->price($value['price'], 'code_view'); ?></b></p>
                        <?php } ?>
                        <?php if(isset($value['expired'])){ 
                        $end_day = strtotime(date('Y-m-d', $value['expired']) . ' - 1 month') + 86400;
                        ?>
                        <p class="flash mt5"><img src="/images/flsa_btn.png" /></p>
                        <div style="display:none" class="JS_dao<?php echo $value['id']; ?>">
                            <p class="font11 mt5">Promo se termine:</p>
                            <p class="font11 red"><strong class="JS_RemainD<?php echo $value['id'];?>"></strong>d <strong class="JS_RemainH<?php echo $value['id'];?>"></strong>h <strong class="JS_RemainM<?php echo $value['id'];?>"></strong>m <strong class="JS_RemainS<?php echo $value['id'];?>"></strong>s</p>
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
                       <ul class="cart_option" style="display: block;">
                          <li>
                              <label>TAILLE:  </label>
                              <span class="cart_size"><?php echo $value['attributes']['Size']; ?></span>
                          </li>
                          <li>
                              <label>Quantité: </label>
                              <span class="cart_size"><?php echo $value['quantity']; ?></span>
                          </li>
                          
                        </ul>
                      </td>
                      <td><b class="font14"><?php echo Site::instance()->price($value['price'] * $value['quantity'], 'code_view'); ?></b></td>
                    </tr>
                    <?php }else{ ?>
                    <tr class="bggy">
                      <td>
                        <div class="fix">
                          <div class="left"><a href="<?php echo $cookie_link; ?>"><img src="<?php echo image::link($cookie_product->cover_image(), 3); ?>" alt="<?php echo $cookie_product->get('name'); ?>" /></a></div>
                          <div class="right">
                            <a href="<?php echo $cookie_link; ?>" class="name gray"><?php echo $cookie_product->get('name'); ?></a>
                            <p class="gray">Article: #<?php echo $cookie_product->get('sku'); ?><span class="red font11 ml5">out of stock</span></p>
                            <p class="bottom"><!--a href="<?php //echo LANGPATH; ?>/wishlist/cookie_add/<?php //echo $key; ?>?return=cart" class="a_underline">Ajouter à votre liste d’envie</a-->
                                <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $key; ?>" class="a_underline">Supprimer</a></p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p><b class="gray"><?php echo Site::instance()->price($value['price'], 'code_view'); ?></b></p>
                      </td>
                      <td>
                        <ul class="cart_option gray" style="display: block;">
                          <li>
                              <label>TAILLE:  </label>
                              <span class="cart_size"><?php echo $value['attributes']['Size']; ?></span>
                          </li>
                          <li>
                              <label>Quantité: </label>
                              <span class="cart_size"><?php echo $value['quantity']; ?></span>
                          </li>
                        </ul>
                      </td>
                      <td><b class="font14 gray"><?php echo Site::instance()->price($value['price'] * $value['quantity'], 'code_view'); ?></b></td>
                    </tr>
                    <?php }} ?>
                </table>
                <P class="mb20">Le prix et la disponibilité des articles sur Choies sont sujettes à changement. Le panier est un endroit temporaire pour stocker une liste de vos articles et refléter prix le plus récent de chaque article.</P>
                <?php } ?>

                <article class="wufeng layout">
                <div id="related_box1">
                    <div style="width: 924px; height: 250px;" class="pdo-droll_layout">
                        <div class="main_box_1">
                            <div style="width: 1024px; height: 250px;z-index:1;overflow: hidden;" class="pdo-droll" id="main_qie">
                                <div id="qieqie"style="width:100%;height:250px;">
                                    <ul style="width: 1024px;float:left; " id="gd_box">
                                    <?php
                                    $top_seller = DB::select('product_id')->from('catalog_products')->where('catalog_id', '=', 32)
                                        ->order_by('position', 'DESC')->execute();
                                    $key = 0;
                                    foreach ($top_seller as $product):
                                        if (!Product::instance($product['product_id'])->get('visibility') OR !Product::instance($product['product_id'])->get('status'))
                                            continue;
                                        $stock = Product::instance($product['product_id'])->get('stock');
                                        if ($stock == 0)
                                            continue;
                                        elseif ($stock == -1)
                                        {
                                            $stocks = DB::select(DB::expr('SUM(stocks) AS sum'))
                                                ->from('products_stocks')
                                                ->where('product_id', '=', $product['product_id'])
                                                ->where('attributes', '<>', '')
                                                ->execute()->get('sum');
                                            if (!$stocks)
                                                continue;
                                        }
                                        $relate_name = Product::instance($product['product_id'])->get('name');
                                        $link = Product::instance($product['product_id'],LANGUAGE)->permalink();
                                        ?>
                                        <li> 
                                            <a href="<?php echo $link; ?>"> 
                                                <img src="<?php echo image::link(Product::instance($product['product_id'])->cover_image(), 1); ?>">
                                            </a>
                                            <p class="price1 fix">
                                            <?php
                                                $retail = Product::instance($product['product_id'])->get('price');
                                                $now = Product::instance($product['product_id'])->price();
                                                if ($retail > $now)
                                                {
                                                    $off = (($retail - $now) / $retail) * 100;
                                                    ?>
                                                    <b class="colored0000"><?php echo Site::instance()->price($now, 'code_view'); ?></b>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <b><?php echo Site::instance()->price($now, 'code_view'); ?></b>
                                                    <?php
                                                }
                                                ?>
                                            </p>
                                        </li>
                                        <?php
                                        $key++;
                                        if ($key >= 6)
                                            break;
                                    endforeach;
                                    ?>
                                    </ul>
                                    <ul style="width: 1024px;float:left; " id="recent_view"></ul>
                                </div>   
                            </div>
                        </div>
                    </div>   
                </div>
                <div id="review_list"></div>
                <div class="focus_fmx_tab">
                    <ul class="focus_ctrls focus_ctrls_fmx">
                        <li class="current" jcid="6E11">
                            <a href="#focus_fmx_3">3</a>
                        </li>
                        <li class=" " jcid="6F11">
                            <a href="#focus_fmx_6">6</a>
                        </li>
                    </ul>
                </div>
                </article>
                <script type="text/javascript">
                    //recent view
                    $.ajax({
                        type: "POST",
                        url: "/site/ajax_recent_view?lang=<?php echo LANGUAGE; ?>",
                        dataType: "json",
                        data: "",
                        success: function(msg){
                            if(msg.length == 0){
                                $("#recent_li,#recent_view").remove();
                            }else{
                                $("#recent_view").html(msg);
                            }
                        }
                    });

                    $(document).ready(function() {
                        var time=setInterval(autoplay,6000)
                        var thisc=0;
                        function autoplay(){
                            $("#qieqie ul").eq(thisc).siblings('ul').hide();
                            $("#qieqie ul").eq(thisc).show();
                            $(".focus_fmx_tab li").eq(thisc).addClass('current').siblings('li').removeClass('current');
                            thisc++;
                            if(thisc>3){
                                thisc=0;
                            }
                        }
                        $(".focus_fmx_tab,#qieqie ul").hover(function() {
                            clearInterval(time);
                        }, function() {
                            clearInterval(time);
                            time=setInterval(autoplay,2000);
                        });
                        $(".focus_fmx_tab li").click(function(){
                            thisc=$(this).index();
                            autoplay();
                        })
            
                    });
                </script>
            <?php }else{
                $currency = Site::instance()->currency();
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
                <div class="fix">
                    <div class="fll">
                        <h2>PANIER D’ACHAT</h2>
                        <span class="show" >Nous Acceptons:<img class="ml10" style="vertical-align:middle" src="/images/shopping-bag-accept.png" usemap="#Shopping" /></span>
                        <map name="Shopping" id="Shopping">
                            <area target="_blank" shape="rect" coords="525,2,598,43" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en" />
                        </map>
                    </div>
                    <a href="<?php echo LANGPATH; ?>/cart/checkout" class="flr btn40_16_red mr20" >
                        PROCÉDER AU PAIEMENT
                    </a>
                </div>
                <!--<p class="mb25"><span class="special_offers">Stock réservé pendant 30 minutes seulement</span></p>-->
                <div class="shopping_bag mb25">
                    <table class="shopping_table" width="100%">
                        <tr>
                            <th width="35%" class="first">NOM</th>                  
                            <th width="25%">PRIX</th>   
                            <th width="25%">OPTION</th>                            
                            <th width="15%">SOUS-TOTAL</th>
                        </tr>
                        <?php
                        $types = array(0 => 0, 3 => 0);
                        $save = 0;
                        $subtotal = 0;
                        foreach (array_reverse($cart['products']) as $key => $product):
                            if(!$key)
                                continue;
                            if(isset($cartcookie[$key])){//cartcookie
                                unset($cartcookie[$key]);
                            }
                            $types[$product['type']]++;
                            $name = Product::instance($product['id'], LANGUAGE)->get('name');
                            $link = Product::instance($product['id'], LANGUAGE)->permalink();
                            ?>
                            <tr>
                                <td>
                                    <div class="fix">
                                        <div class="left"><a href="<?php echo $link; ?>"><img src="<?php echo image::link(Product::instance($product['id'])->cover_image(), 3); ?>" alt="<?php echo $name; ?>" /></a></div>
                                        <div class="right">
                                            <a href="<?php echo $link; ?>" class="name"><?php echo $name; ?></a>
                                            <p class="color666">Article: #<?php echo Product::instance($product['id'])->get('sku'); ?></p>
                                            <p class="bottom">
                                                <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $key; ?>" class="a_underline fll" onclick="if(!confirm('Êtes- vous sûr pour le supprimer?')){return false;}">Supprimer</a>
                                                <span style="margin:3px 10px;float:left">|</span><?php if($save_show){ ?>
                                                <a href="/cart/cookie2later/<?php echo $key;?>" class="a_underline fll green">Mettre de côté</a>
                                                <?php }else{ ?>
                                                <a id="sign_in" class="pro_sign JS_popwinbtn1" href="<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/cart/view">Mettre de côté</a>
                                                <?php } ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                    if (isset($restrictions['restrict_catalog']) || isset($restrictions['restrict_product']))
                                    {
                                        $subtotal += $product['price'] * $product['quantity'];
                                        if (Product::instance($product['id'])->get('set_id') == $restrictions['restrict_catalog'] || $product['id'] == $restrictions['restrict_product'])
                                        {
                                            $sal_price = $product['price'] * $rate / 100;
                                            $save += $product['price'] - $sal_price;
                                            ?>
                                            <del><?php echo Site::instance()->price($product['price'], 'code_view'); ?></del>
                                            <p><b class="red"><?php echo Site::instance()->price($sal_price, 'code_view'); ?></b></p>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <p><b class="red"><?php echo Site::instance()->price($product['price'], 'code_view'); ?></b></p>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        $origial_price = Product::instance($product['id'])->get('price');
                                        $subtotal += $origial_price * $product['quantity'];
                                        if ($origial_price > $product['price'])
                                        {
                                            $save += $origial_price - $product['price'];
                                            ?>
                                            <del><?php echo Site::instance()->price($origial_price, 'code_view'); ?></del>
                                            <p><b class="red"><?php echo Site::instance()->price($product['price'], 'code_view'); ?></b></p>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <p><b class="red"><?php echo Site::instance()->price($product['price'], 'code_view'); ?></b></p>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <?php if(isset($product['expired'])){ 
                                    $end_day = strtotime(date('Y-m-d', $product['expired']) . ' - 1 month') + 86400;
                                    ?>
                                    <p class="flash mt5"><img src="/images/flsa_btn.png" /></p>
                                    <div style="display:none">
                                        <p class="font11 mt5">Promo se termine:</p>
                                        <p class="font11 red"><strong class="JS_RemainD<?php echo $product['id'];?>"></strong>d <strong class="JS_RemainH<?php echo $product['id'];?>"></strong>h <strong class="JS_RemainM<?php echo $product['id'];?>"></strong>m <strong class="JS_RemainS<?php echo $product['id'];?>"></strong>s</p>
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
                                        <ul class="cart_option">
                                            <li>
                                                <label>TAILLE:</label>
                                                <select name="attribute">
                                                    <?php
                                                    foreach ($p_attributes[$product['id']] as $key1 => $a)
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
                                                if($stocks > 0)
                                                {
                                                    ?>
                                                    <li class="red">seulement <span><?php echo $stocks; ?></span> restants</li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <li>
                                                <input type="reset" value="Annuler" class="btn22_black change_cancel" />
                                                <input type="submit" value="Valider" class="btn22_black" />
                                            </li>
                                        </ul>
                                    </form>
                                    <ul class="cart_option">
                                        <li>
                                            <label>TAILLE:  </label>
                                            <span class="cart_size"><?php echo str_replace('one size', 'taille unique', $product['attributes']['Size']); ?></span>
                                        </li>
                                        <li>
                                            <label>Quantité: </label>
                                            <span class="cart_size"><?php echo $product['quantity']; ?></span>
                                        </li>
                                        <?php
                                        if($stocks > 0)
                                        {
                                            ?>
                                            <li class="red">seulement <span><?php echo $stocks; ?></span> restants</li>
                                            <?php
                                        }
                                        ?>
                                        <li>
                                            <a class="btn22_black change_detail">Modifier</a>
                                        </li>
                                    </ul>
                                </td>
                                <td><b class="font14"><?php echo Site::instance()->price($product['price'] * $product['quantity'], 'code_view'); ?></b></td>
                            </tr>
                            <?php
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
                                ?>
                                <tr>
                                    <td>
                                        <div class="fix">
                                            <div class="left">
                                                <a href="<?php echo LANGPATH; ?><?php echo Product::instance($largess['id'], LANGUAGE)->permalink(); ?>" title="<?php echo Product::instance($largess['id'], LANGUAGE)->get('name'); ?>">
                                                    <img src="<?php echo image::link(Product::instance($largess['id'])->cover_image(), 3); ?>" alt="<?php echo Product::instance($largess['id'], LANGUAGE)->get('name'); ?>" />
                                                </a>
                                            </div>
                                            <div class="right">
                                                <a href="<?php echo LANGPATH; ?><?php echo Product::instance($largess['id'], LANGUAGE)->permalink(); ?>" class="name"><?php echo Product::instance($largess['id'], LANGUAGE)->get('name'); ?></a>
                                                <p>Article: #<?php echo Product::instance($largess['id'])->get('sku'); ?></p>
                                                <a href="<?php echo LANGPATH; ?>/cart/largess_delete/<?php echo $key; ?>" class="a_underline">Supprimer</a></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        $origial_price1 = Product::instance($largess['id'])->get('price');
                                        $subtotal += $origial_price1 * $largess['quantity'];
                                        $save += $origial_price1 - $largess['price'];
                                        ?>
                                        <del><?php echo Site::instance()->price($origial_price1, 'code_view'); ?></del>
                                        <p><b class="red"><?php echo Site::instance()->price($largess['price'], 'code_view'); ?></b></p>
                                    </td>
                                    <td>
                                        <?php echo $largess['quantity']; ?>
                                    </td>
                                    <td><b class="font14"><?php echo Site::instance()->price($largess['price'] * $largess['quantity'], 'code_view'); ?></b></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>

                    <!-- Special Offers -->
                    <?php
                    if (!empty($cart['largesses_for_choosing']) AND !$celebrity_avoid)
                    {
                        foreach ($cart['largesses_for_choosing'] as $cid => $largesses_for_choosing)
                        {
                            ?>
                            <table class="shopping_table shopping_table1" width="100%">
                                <tr>
                                    <th colspan="1" class="offers">Offres Spéciales</th>
                                    <th colspan="3" class="special_offers"><?php echo $wordsArr[$cid]; ?></th>
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
                                            <td width="35%">
                                                <div class="fix">
                                                    <div class="left"><a href="<?php echo Product::instance($key, LANGUAGE)->permalink(); ?>"><img src="<?php echo image::link(Product::instance($key)->cover_image(), 3); ?>" /></a></div>
                                                    <div class="right">
                                                        <a href="<?php echo Product::instance($key, LANGUAGE)->permalink(); ?>" class="name"><?php echo Product::instance($key, LANGUAGE)->get('name'); ?></a>
                                                        <p class="color666">Article: #<?php echo Product::instance($key)->get('sku'); ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td width="25%">
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
                                            <td width="25%">
                                                <input type="hidden" name="promotion_id" value="<?php echo $largesses_for_choosing['promotion_id']; ?>" />
                                                <input type="hidden" name="id" value="<?php echo $key; ?>" />
                                                <input type="hidden" name="items[]" value="<?php echo $key; ?>" />
                                                <ul class="cart_option">
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
                                                                <label><?php echo $n; ?>:</label>
                                                                <select name="attributes[<?php echo $n; ?>]">
                                                                <?php
                                                                foreach ($attribute as $att)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $att; ?>"><?php echo $att; ?></option>
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
                                            <td width="15%"><input type="submit" value="Prenez Cette Offre" class="btn22_black" /></td>
                                        </tr>
                                    </form>
                                    <?php
                                }
                                ?>
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
                    <ul class="shopping_total">
                        <li class="first">
                            <?php if (!empty($largess_words) AND !$celebrity_avoid): ?>
                                <em><?php echo implode(' / ', $largess_words); ?></em>
                            <?php endif; ?>
                            <?php if (!empty($sale_words) AND $cart['amount']['total'] > 0): ?>
                                <em><?php echo implode(' , ', $sale_words); ?></em>
                            <?php endif; ?>
                            <?php if ($cart['extra_flg']): ?>
                                <a href="<?php echo LANGPATH; ?>/top-sellers">Ajoutez 1+ Article Marqué "Free Shipping" à Votre Panier,Profitez De La Livraison Gratuite Pour Votre Commande>></a>
                            <?php endif; ?>
                            <a href="<?php echo $catalog_link; ?>" class="a_underline"><< continuer vos achats</a>
                        </li>
                        <li><label>Sous-total:</label><span class="font14"><?php echo Site::instance()->price($subtotal, 'code_view'); ?></span></li>   
                        <li class="red bold">
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
                                <span><?php echo Site::instance()->price($save, 'code_view'); ?></span><br/>
                                <?php
                            }
                            if ($cart_save > 0)
                            {
                                ?>
                                <label>Économie de Panier:</label>
                                <span><?php echo Site::instance()->price($cart_save, 'code_view'); ?></span>
                                <?php
                            }
                            ?>
                        </li>
                        <li class="bottom b1"><label>TOTAL:</label><span class="font20"><?php echo Site::instance()->price($cart['amount']['items'] - $cart_save, 'code_view'); ?></span></li>
                        <li class="bottom">
                            <a href="<?php echo LANGPATH; ?>/cart/checkout" class="btn40_16_red">PROCÉDER AU PAIEMENT</a>
                        </li>
                        <li class="bottom last">
                            <em class="color666"><b class="red">TIP!</b> N’oubliez pas d’utiliser vos Points & Coupons.</em>
                        </li>
                    </ul>
                </div>
                <article class="product_reviews" id="alsoview" style="display:none">
                <div class="w_tit layout"><h2>PRODUITS RECOMMANDÉS</h2></div>
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
                     <a href="{{=p.link}}" id="em{{= p.id }}link">
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
                Cart = (function() {
                var cart = [];
                var render = function() {
                    ScarabQueue.push(['cart', cart]);
                    ScarabQueue.push(['recommend', {
                        logic: 'CART',
                        limit: 24,
                        containerId: 'personal-recs',
                        templateId: 'simple-tmpl',
                        success: function(SC, render) {
                            var psku="";
                            for (var i = 0, l = SC.page.products.length; i < l; i++) {
                                var product = SC.page.products[i]; 
                                psku+=product.id+",";
                            }
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
                                            }
                                    }
                            });
                            SC.basket = cart;
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
                <?php if(count($cartcookie)>0){//cartcookie ?>
                <div class="fix mt30">
                    <strong class="fll font18">Vos Articles Sauvegardés</strong>
                </div>
                <table class="shopping_table mt20" width="100%" >
                    <tr>
                      <th width="35%" class="first">NOM</th>                  
                      <th width="25%">PRIX</th>   
                      <th width="25%">DÉTAIL</th>                            
                      <th width="15%">TOTAL</th>
                    </tr>
                    <?php
                    foreach ($cartcookie as $key => $value) { 
                    $cookie_product = Product::instance($value['id'],LANGUAGE);
                    $cookie_link = $cookie_product->permalink();
                    $stock = $cookie_product->get('stock');
                        if ($cookie_product->get('visibility') AND $cookie_product->get('status') AND $stock!=0 ){
                    ?>
                    <tr>
                      <td>
                        <div class="fix">
                          <div class="left"><a href="<?php echo $cookie_link; ?>"><img src="<?php echo image::link($cookie_product->cover_image(), 3); ?>" alt="<?php echo $cookie_product->get('name'); ?>" /></a></div>
                          <div class="right">
                            <a href="<?php echo $cookie_link; ?>" class="name"><?php echo $cookie_product->get('name'); ?></a>
                            <p class="color666">Article: #<?php echo $cookie_product->get('sku'); ?></p>
                            <p class="bottom">
                                <!--a href="<?php //echo LANGPATH; ?>/wishlist/cookie_add/<?php //echo $key; ?>?return=cart" class="a_underline">Ajouter à votre liste d’envie</a-->
                                <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $key; ?>" onclick="if(!confirm('Êtes- vous sûr pour le supprimer?')){return false;}" class="a_underline fll">Supprimer</a><span style="margin:3px 10px;float:left">|</span>
                                <a href="<?php echo LANGPATH; ?>/cart/cookie2cart/<?php echo $key;?>" class="a_underline fll green">Ajouter au panier</a>
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
                        $end_day = strtotime(date('Y-m-d', $value['expired']) . ' - 1 month') + 86400;
                        ?>
                        <p class="flash mt5"><img src="/images/flsa_btn.png" /></p>
                        <div style="display:none">
                            <p class="font11 mt5">Promo se termine:</p>
                            <p class="font11 red"><strong class="JS_RemainD<?php echo $value['id'];?>"></strong>d <strong class="JS_RemainH<?php echo $value['id'];?>"></strong>h <strong class="JS_RemainM<?php echo $value['id'];?>"></strong>m <strong class="JS_RemainS<?php echo $value['id'];?>"></strong>s</p>
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
                        <ul class="cart_option" style="display: block;">
                            <li>
                                <label>TAILLE:  </label>
                                <span class="cart_size"><?php echo $value['attributes']['Size']; ?></span>
                            </li>
                            <li>
                                <label>Quantité: </label>
                                <span class="cart_size"><?php echo $value['quantity']; ?></span>
                            </li>
                        </ul>
                      </td>
                      <td><b class="font14"><?php echo Site::instance()->price($value['price'] * $value['quantity'], 'code_view'); ?></b></td>
                    </tr>
                    <?php }else{ ?>
                    <tr class="bggy">
                      <td>
                        <div class="fix">
                          <div class="left"><a href="<?php echo $cookie_link; ?>"><img src="<?php echo image::link($cookie_product->cover_image(), 3); ?>" alt="<?php echo $cookie_product->get('name'); ?>" /></a></div>
                          <div class="right">
                            <a href="<?php echo $cookie_link; ?>" class="name gray"><?php echo $cookie_product->get('name'); ?></a>
                            <p class="gray">Article: #<?php echo $cookie_product->get('sku'); ?><span class="red font11 ml5">out of stock</span></p>
                            <p class="bottom">
                                <!--a href="<?php //echo LANGPATH; ?>/wishlist/cookie_add/<?php //echo $key; ?>?return=cart" class="a_underline">Ajouter à votre liste d’envie</a-->
                                <a href="<?php echo LANGPATH; ?>/cart/delete/<?php echo $key; ?>" class="a_underline">Supprimer</a>
                            </p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p><b class="gray"><?php echo Site::instance()->price($value['price'], 'code_view'); ?></b></p>
                      </td>
                      <td>
                        <ul class="cart_option gray" style="display: block;">
                          <li>
                              <label>TAILLE:  </label>
                              <span class="cart_size"><?php echo $value['attributes']['Size']; ?></span>
                          </li>
                          <li>
                              <label>Quantité: </label>
                              <span class="cart_size"><?php echo $value['quantity']; ?></span>
                          </li>
                        </ul>
                      </td>
                      <td><b class="font14 gray"><?php echo Site::instance()->price($value['price'] * $value['quantity'], 'code_view'); ?></b></td>
                    </tr>
                    <?php } } ?>
                </table>
                <p class="mb20"><a href="<?php echo LANGPATH; ?>/cart/cartcookie_invalid">Supprimer Les Articles Non Valides</a></p>
                <P class="mb20">Le prix et la disponibilité des articles sur Choies sont sujettes à changement. Le panier est un endroit temporaire pour stocker une liste de vos articles et refléter prix le plus récent de chaque article.</P>
                <?php } ?>
                <div class="cartbag_bottom">
                    <a class="s1" target="_blank" href="<?php echo LANGPATH; ?>/privacy-security">Payement En Sécurité</a>
                    <a class="s2" target="_blank" href="<?php echo LANGPATH; ?>/shipping-delivery">Livraison Internationale Gratuite</a>
                    <a class="s3" target="_blank" href="<?php echo LANGPATH; ?>/returns-exchange">Remboursement Dans Les 60 Jours</a>
                </div>
                <?php
            }
            ?>
        </section>
    </section>
</section>

<!-- JS_popwincon1 -->
<div class="JS_popwincon1 popwincon w_signup hide">
    <a class="JS_close2 close_btn2"></a>
    <div class="fix" id="sign_in_up">
        <div class="left" style="width:auto;margin-right:30px;padding-right:30px;">
            <h3>Déjà client CHOIES</h3>
            <form action="<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/cart/view" method="post" class="signin_form sign_form form">
                <ul>
                    <li>
                        <label>Adresse e-mail: </label>
                        <input type="text" value="" name="email" class="text" />
                    </li>
                    <li>
                        <label>Mot de passe: </label>
                        <input type="password" value="" name="password" class="text" maxlength="16" />
                    </li>
                    <li><input type="submit" value="SE CONNECTER " name="submit" class="btn btn40" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">Mot de passe oublié?</a></li>
                    <li>
                        <?php
                        $page = $plink;
                        $facebook = new facebook();
                        $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                        ?>
                        <a href="<?php echo $loginUrl; ?>" class="facebook_btn">Connection avec Facebook</a>
                    </li>
                </ul>
            </form>
        </div>
        <div class="right">
            <h3>Nouveau client CHOIES</h3>
            <form action="<?php echo LANGPATH; ?>/customer/register?redirect=<?php echo LANGPATH; ?>/cart/view" method="post" class="signup_form sign_form form">
                <ul>
                    <li>
                        <label>Adresse e-mail: </label>
                        <input type="text" value="" name="email" class="text" />
                    </li>
                    <li>
                        <label>Mot de passe: </label>
                        <input type="password" value="" name="password" class="text" id="password" maxlength="16" />
                    </li>
                    <li>
                        <label>Confirmer le mot de passe: </label>
                        <input type="password" value="" name="password_confirm" class="text" maxlength="16" />
                    </li>
                    <li><input type="submit" value="VALIDER" name="submit" class="btn btn40" /></li>
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
                required:"Veuillez fournir une adresse e-mail.",
                email:"Veuillez entrer une adresse e-mail valide."
            },
            password: {
                required: "Veuillez fournir un mot de passe.",
                minlength: "Votre mot de passe doit comporter au moins 5 caractères."
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
            alert('Shopping Cart cannot be empty');
            return false;
        }
        location.href="/payment/ppec_set";
    }
</script>
<script>
    //cartcookie 
    $(function(){
        $("p.flash").hover(function(){
            $(this).next().show();
        },function(){
            $(this).next().hide();
        })
    })
</script>
<script>
    $(function(){
        $(".change_detail").click(function(){
            $(this).parent().parent().hide();
            $(this).parent().parent().parent().find('form').show();
            return false;
        })
    
        $(".change_cancel").click(function(){
            $(this).parent().parent().parent().hide();
            $(this).parent().parent().parent().parent().find('.cart_option').show();
            return false;
        })
    })
</script>



<img src="track.excelmob.com?cart=EXCELMOB-150003&segment=4OAyKorrMv&sku=PRODUCT-SKU-HERE" />
<script src="//cdn.optimizely.com/js/557241246.js"></script>