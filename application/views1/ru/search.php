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
<div class="site-content">
    <div class="main-container clearfix">
        <div class="container">
            <div class="crumbs">
                <div class="fll">
                    <a href="<?php echo LANGPATH; ?>/" class="home">home</a>
                    &gt;<span>Поиск : <strong><?php echo $keywords; ?></strong></span>
                </div>
            </div>
            <?php
            if (!empty($products))
            {
            ?>
                <ul class="filter-bar cf">
                    <li class="fll mt5"><div>Сортировка по:&nbsp;</div></li>
                    <li class="item-l drop-down JS-show">
                        <div class="drop-down-hd">
                            <?php 
                            $ens = array("Default","What's New", 'Best Seller', 'Price: Low To High', 'Price: High To Low');
                            $trns = array('Новинки', 'популярности', 'цене по убыванию', 'цене по возрастанию','выбрать');
                            if(isset($_GET['sort']))
                            {
                                $sname = str_replace($ens, $trns, $sorts[$_GET['sort']]['name']);
                                echo $sname;
                            }
                            else
                            {
                                echo 'Default'; 
                            } ?>
                            <i class="fa fa-caret-down"></i>
                        </div>
                        <ul class="drop-down-list JS-showcon" style="width: 180%;display:none;">
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
                            <li class="drop-down-option" <?php if (isset($_GET['sort']) AND (int) $_GET['sort'] == $key) echo 'class="on"'; ?> onclick="tolink(<?php echo $key; ?>);">
                                <a href="<?php echo $tolink; ?>"><?php echo $sname; ?></a>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="item-l pick">
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
                        <a href="<?php echo  '?' . Security::xss_clean(implode('&', $gets1)); ?>" class=""> <i class="myaccount"></i>Выбор звёзд</a>
                    </li>
                    <li class="item-r drop-down JS-show">
                        <div class="drop-down-hd">
                            Цвет <i class="fa fa-caret-down"></i>
                        </div>
                        <ul class="choice-color drop-down-list JS-showcon hide" id="color_ul" style="width: 180%; left: -38px; display: none;">
                            <?php
                            $gets = $_GET;
                            $current_color = Arr::get($_GET, 'color', 0);
                            foreach ($sortcolor as $key => $color)
                            {
                                if(!$key)
                                    continue;
                                if ($current_color == $key)
                                    $on = 1;
                                else
                                    $on = 0;
                                if(!$on)
                                    $gets['color'] = $key;
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
                                <li class="drop-down-option <?php if ($on) echo 'on'; ?>">
                                    <a href="<?php echo $href; ?>" title="<?php echo ucfirst($color); ?>">
                                        <?php if ($on) echo '<em style="margin: 0px;"></em>'; ?>
                                        <span class="icon color-cate-<?php echo strtolower($color); ?>"></span>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
                <div class="flr mt20"><?php echo $pagination; ?></div>
            <?php
            }
            ?>
            <div class="fix"></div>
            <?php
            if (!empty($products))
            {
            ?>
            <div class="pro-list">
                <ul class="row">
                <?php
                $product_ids = array();
                foreach ($products as $i => $product_id)
                {
                    $product_ids[] = $product_id;
                    $search = array('product_id' => $product_id);
                    $product_inf = Product::instance($product_id, LANGUAGE);
                    $cover_image = $product_inf->cover_image();
                    $plink = $product_inf->permalink();
                    ?>
                    <li class="pro-item col-xs-6 col-sm-3">
                        <?php
                        if($i >= 20)
                        {
                        ?>
                            <div class="pic">
                                <a href="<?php echo $plink; ?>">
                                <div class="pic1"><img data-original="<?php echo Image::link($cover_image, 1); ?>" src="/assets/images/loading.gif" alt="<?php echo $product_inf->get('name'); ?>" title="<?php echo $product_inf->get('name'); ?>" /></div>
                                </a>
                                <a href="<?php echo $plink; ?>" id="more_color<?php echo $product_id; ?>" style="display:none;"><span class="icon-color" title="More Colors"></span></a>
                            </div>
                        <?php
                        }
                        else
                        {
                            ?>
                            <div class="pic">
                                <a href="<?php echo $plink; ?>">
                                <div class="pic1"><img src="<?php echo Image::link($cover_image, 1); ?>" alt="<?php echo $product_inf->get('name'); ?>" title="<?php echo $product_inf->get('name'); ?>" /></div>
                                </a>
                                <a href="<?php echo $plink; ?>" id="more_color<?php echo $product_id; ?>" style="display:none;"><span class="icon-color" title="More Colors"></span></a>
                            </div>
                            <?php
                        }
                        ?>
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
                            <a href="#" id="<?php echo $product_id; ?>" class="quick_view btn-qv"  data-reveal-id="myModal" attr-lang="<?php echo LANGUAGE; ?>">Бстрый посмотр</a>
                        <?php endif; ?>
						<div class="add-wish">
                        <?php if(!$customer_id = Customer::logged_in()){ ?>
                        <div class="add_to_wishlist" data-product="<?php echo $product_id; ?>">
                            <a class="wish-title" data-reveal-id="myModal2" id="wish1_<?php echo $product_id; ?>">Добавить в избранное
                            <i class="fa fa-heart add_wishlist" id="wish_<?php echo $product_id; ?>"></i></a>
                        </div>
                        <?php }else{ ?>
                        <div class="add_to_wishlist" data-product="<?php echo $product_id; ?>">
                            <a class="wish-title" id="wish1_<?php echo $product_id; ?>">Добавить в избранное
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
                                <p class="wish"><i class="fa fa-heart"></i>Избранное</p>
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
                            echo '<span class="outstock">Нет в наличии</span>';
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
                    <!-- searchon_box -->
                    <div class="searchon-wp">
                        <div class="searchon-404">
                            <p class="font24"><strong>Извините!</strong> По вашему запросу ничего не найдено,<br />
                        или ваша целевая страница обновляется на данный момент...</p>
                            <p><a href="<?php echo LANGPATH; ?>/contact-us" class="bottom">Особая Просьба? Свяжитесь С Нами!</a></p>
                        </div>
                    </div>
                    <div style="font-size:18px;margin-bottom:15px;">Вы можете посмотреть  наши ходовые товары:</div>
                    <div class="four-lay">
                        <div class="box-dibu1">
                            <div id="personal-recs">
                                <div class="hide-box1-0">
                                    <ul>
                                    <?php
                                    $phone_products = array();
                                    $top_seller = DB::select('product_id')
                                            ->from('catalog_products')
                                            ->where('catalog_id', '=', 32)
                                            ->order_by('position', 'DESC')
                                            ->execute();
                                    $key = 0;
                                    foreach ($top_seller as $product):
                                        if (!Product::instance($product['product_id'], LANGUAGE)->get('visibility') OR !Product::instance($product['product_id'], LANGUAGE)->get('status'))
                                            continue;
                                        $stock = Product::instance($product['product_id'], LANGUAGE)->get('stock');
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
                                        $relate_name = Product::instance($product['product_id'], LANGUAGE)->get('name');
                                        $link = Product::instance($product['product_id'], LANGUAGE)->permalink();
                                        $cover_image = Product::instance($product['product_id'], LANGUAGE)->cover_image();
                                        ?>
                                        <li>
                                            <a href="<?php echo $link; ?>" title="<?php echo $relate_name; ?>">
                                                <img src="<?php echo image::link($cover_image, 1); ?>" />
                                            </a>
                                            <p class="price">
                                                <?php
                                                $retail = Product::instance($product['product_id'], LANGUAGE)->get('price');
                                                $now = Product::instance($product['product_id'], LANGUAGE)->price();
                                                if ($retail > $now)
                                                {
                                                    $off = (($retail - $now) / $retail) * 100;
                                                    ?>
                                                    <b><?php echo Site::instance()->price($now, 'code_view'); ?></b>    <del><?php echo Site::instance()->price($retail, 'code_view'); ?></del> <span class="off"><?php echo (int) $off; ?>% de réduction</span>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <b><?php echo Site::instance()->price($now, 'code_view'); ?></b>
                                                    <?php
                                                }
                                                $has_pick = 0;
                                                if (Product::instance($product['product_id'], LANGUAGE)->get('has_pick'))
                                                {
                                                    $has_pick = 1;
                                                    echo '<span class="icon-pick"></span>';
                                                }
                                                ?>
                                            </p>
                                            <?php if ($retail > $now): ?>
                                                <span class="icon-sale"></span>
                                            <?php endif; ?>
                                            <?php
                                            $status = Product::instance($product['product_id'], LANGUAGE)->get('status');
                                            if (!$status)
                                            {
                                            ?>
                                                <span class="outstock">Нет в наличии</span>
                                            <?php
                                            }
                                            ?>
                                        </li>
                                        <?php
                                        $phone_products[] = array(
                                            'name' => $relate_name,
                                            'link' => $link,
                                            'cover_image' => $cover_image,
                                            'retail' => $retail,
                                            'now' => $now,
                                            'has_pick' => $has_pick,
                                            'status' => $status,
                                        );
                                        $key++;
                                        if ($key >= 7)
                                            break;
                                    endforeach;
                                    ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="index-fashion buyers-show">
                        <div class="flash-sale">
                            <ul class="row">
                                <?php
                                $key = 0;
                                foreach ($phone_products as $p):
                                    ?>
                                    <li class="col-xs-6">
                                        <a href="<?php echo $p['link']; ?>" title="<?php echo $p['name']; ?>">
                                            <img src="<?php echo image::link($p['cover_image'], 1); ?>" />
                                        </a>
                                        <p class="price">
                                            <?php
                                            if ($p['retail'] > $p['now'])
                                            {
                                                $off = (($p['retail'] - $p['now']) / $p['retail']) * 100;
                                                ?>
                                                <b><?php echo Site::instance()->price($p['now'], 'code_view'); ?></b>    <del><?php echo Site::instance()->price($p['retail'], 'code_view'); ?></del>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <b><?php echo Site::instance()->price($p['now'], 'code_view'); ?></b>
                                                <?php
                                            }
                                            if ($p['has_pick'])
                                                echo '<span class="icon-pick"></span>';
                                            ?>
                                        </p>
                                        <?php if ($p['retail'] > $p['now']): ?>
                                            <span class="icon-sale"></span>
                                        <?php endif; ?>
                                        <?php if (!$p['status']): ?>
                                            <span class="outstock">En rupture de Stock</span>
                                        <?php endif; ?>
                                    </li>
                                    <?php
                                    $key++;
                                    if ($key >= 6)
                                        break;
                                endforeach;
                                ?>
                            </ul>
                        </div>  
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
ScarabQueue.push(['searchTerm', '<?php echo $keywords; ?>']);
    $(function(){
		<?php
        $product_str = !empty($product_ids) ? implode(',', $product_ids) : '';
        ?>
		
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
                url:'/customer/ajax_login',
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
						 str +="<span>Здравствуйте, "+rs.firstname+"!</span>";
						 str +="</div>";
						 str +="<dl class='drop-down-list JS-showcon hide' style='display:none;'>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/summary'>Личный кабинет</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/orders'>Мои Заказы</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/tracks/track_order'>Отслеживать заказ</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/wishlist'>Мой Список Пожеланий</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/profile'>Мой Профиль</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/logout'>Выход</a>";
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
                url:'/customer/ajax_register',
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
						 str +="<span>Здравствуйте, Choieser!</span>";
						 str +="</div>";
						 str +="<dl class='drop-down-list JS-showcon hide' style='display:none;'>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/summary'>Личный кабинет</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/orders'>Мои Заказы</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/tracks/track_order'>Отслеживать заказ</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/wishlist'>Мой Список Пожеланий</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/profile'>Мой Профиль</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/logout'>Выход</a>";
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
                        showup(rs.message);
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

        <?php
        $product_str = !empty($product_ids) ? implode(',', $product_ids) : '';
        ?>

        //ajax more color
        $.ajax({
            type: "POST",
            url: "/ajax/more_color",
            dataType: "json",
            data: "product_ids=<?php echo $product_str; ?>",
            success: function(res){
                for(var p in res){
                    var pid = res[p];
                    $("#more_color"+pid).show();
                }
            }
        });
		
		
		//marks图标
		/*1.5暂时不用因为要改版
        $.ajax({
            type: "POST",
            url: "/ajax/marks_data",
			data: "product_ids=<?php echo $product_str; ?>",
            dataType: "json",
            success: function(res){
				console.log(res);
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
		*/
		
        //ajax wishlists
        $.ajax({
            type: "POST",
            url: "/ajax/wishlist_data",
            dataType: "json",
            data: "product_ids=<?php echo $product_str; ?>",
            success: function(res){
                for(var p in res){
                    var pid = res[p];
                    $("#wish_"+pid).removeClass('add_wishlist');
                    $("#wish_"+pid).addClass('red');
                    $("#wish1_"+pid).html("<i class='fa fa-heart red' id='wish_'"+ pid+"></i>");
                }
            }
        });

        //ajax reviews
        $.ajax({
            type: "POST",
            url: "/ajax/review_data",
            dataType: "json",
            data: "product_ids=<?php echo $product_str; ?>",
            success: function(res){
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
    })
	
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
	
	function getwishlist(){
		//ajax wishlists
        $.ajax({
            type: "POST",
            url: "/ajax/wishlist_data",
            dataType: "json",
            data: "product_ids=<?php echo $product_str; ?>",
            success: function(res){
                for(var p in res){
                    var pid = res[p];
                    $("#wish_"+pid).removeClass('add_wishlist');
                    $("#wish_"+pid).addClass('red');
                    $("#wish1_"+pid).html("<i class='fa fa-heart red' id='wish_'"+ pid+"></i>");
                }
            }
        });
	}
</script>

<script type="text/javascript">
    $(function(){
        $(".btn_size input").live("click",function(){
            var qty = $(this).attr('title');
            if(qty)
                $("#only_left").html('Only '+qty+' Left!');
        });
        // $("#formAdd").submit(function(){
        //     $.post(
        //         '/cart/ajax_add?lang=<?php echo LANGUAGE; ?>',
        //         {
        //             id: $('#product_id').val(),
        //             type: $('#product_type').val(),
        //             size: $('.s-size').val(),
        //             color: $('.s-color').val(),
        //             attrtype: $('.s-type').val(),
        //             quantity: $('#count_1').val()
        //         },
        //         function(product)
        //         {
        //             var count = 0;
        //             var cart_view = '';
        //             var cart_view1 = '';
        //             var key = 0;
        //             for(var p in product)
        //             {
        //                 if(key == 0)
        //                 {
        //                     cart_view = '\
        //                     <a href="'+product[p]['link']+'"><img src="'+product[p]['image']+'" alt="'+product[p]['name']+'" /></a>\
        //                         <div class="right">\
        //                             <a class="name" href="'+product[p]['link']+'">'+product[p]['name']+'</a>\
        //                             <p>Item# : '+product[p]['sku']+'</p>\
        //                             <p>'+product[p]['price']+'</p>\
        //                             <p>'+product[p]['attributes']+'</p>\
        //                             <p>Quantity: '+product[p]['quantity']+'</p>\
        //                         </div>\
        //                     <div class="fix"></div>\
        //                     ';
        //                 }
        //             }
        //             if($(document).scrollTop() > 120)
        //             {
        //                 $('#mybag2 .currentbag .bag_items li').html(cart_view);
        //                 $('#mybag2 .currentbag').fadeIn(10).delay(3000).fadeOut(10);
        //             }
        //             else
        //             {
        //                 $('#mybag1 .currentbag .bag_items li').html(cart_view);
        //                 $('#mybag1 .currentbag').fadeIn(10).delay(3000).fadeOut(10);
        //             }
        //             ajax_cart();
        //         },
        //         'json'
        //     );
        //     $(".JS_filter1").remove();
        //     $('.JS_popwincon1').fadeOut(160).appendTo('#tab2');
        //     return false;
        // })
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
<script type="text/javascript" charset="utf-8" src="/assets/js/lazyload.js"></script>