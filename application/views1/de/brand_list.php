<div class="site-content">
    <div class="main-container clearfix">
        <div class="container">
            <div class="crumbs">
                <div class="fll">
                    <a href="<?php echo LANGPATH; ?>/" class="home">Homepage</a>&gt; <span><?php echo $brands['name']; ?>
                </div>
            </div>
            <!-- aside -->
			<div class="list-main">
                <div class="filter-right" style="width: 100%;">
                <div class="filter-bar">
				<?php
                    $gets = isset($gets) ? $gets : array();
                    $has = 0;
					$gets1 = $gets;
					if (!empty($gets1))
					{
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
					$pick = Arr::get($_GET, 'pick',0);
                    ?>
                    <ul class="bar-r">
					
                        <li class=" item-r pick <?php if($pick) echo 'pick-on'; ?>">
							<a href="<?php echo '?' . implode('&', $gets1); ?>" class=""> Wahl der Berühmtheit</a>
						</li>
            <li class=" drop-down JS-show">
                            <span class="fll">ortieren nach:&nbsp;</span>
                            <div class="drop-down-hd">
                                <?php
                                $getsort = '';
                                if(isset($_GET['sort']))
                                {
                                    $getsort = $_GET['sort'];                    
                                }

                                if(array_key_exists($getsort, $sorts))
                                {
                                    echo isset($getsort) ? $sorts[$getsort]['name'] : 'Default';
                                }
                                else
                                {
                                    echo 'Default';
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
                                        <a href="<?php echo $tolink; ?>"><?php echo $sort['name']; ?></a>
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
            $count_product = count($products);
			$auto_loaded_products = '';
            if($count_product > 0)
            {
            ?>
            <div class="fix"></div>
            <div class="pro-list">
                <ul class="row" id="product_ul">
                    <?php
                $product_ids = array();
                $key = 'site_restrictions_choies';
                $cache = Cache::instance('memcache');
                if (!($secondhalf = $cache->get($key)))
                {
                    $secondhalf = DB::select('restrictions')
                        ->from('carts_cpromotions')
                        ->where('actions', '=', 'a:1:{s:6:"action";s:10:"secondhalf";}')
                        ->and_where('is_active', '=', 1)
                        ->and_where('to_date', '>', time())
                        ->execute()->get('restrictions');  
                    if($secondhalf && $secondhalf !=1)
                    {
                        $cache->set($key, $secondhalf, 86400);
                    }
                    else
                    {
                        $cache->set($key, 1, 86400);             
                    }
                }
					foreach($products as $i => $product)
					{
                        $product_id = $product['id'];
						$product_ids[] = $product_id;
						$cover_image = Product::instance($product_id)->cover_image();
						$product_inf = Product::instance($product_id)->get();
						$search = array('product_id' => $product_id);
						$plink = Product::instance($product_id)->permalink();
                        ?>
                        <?php
                        if($i < 20)
                        {
                            $auto_loaded_products .= $product_id . ',';
                        ?>
                            <li class="pro-item col-xs-6 col-sm-3">
                                <div class="pic">
                                <a href="<?php echo $plink; ?>">
                                    <div class="pic1"><img data-original="<?php echo Image::link($cover_image, 1); ?>" src="/assets/images/loading.gif" alt="<?php echo $product_inf['name']; ?>" title="<?php echo $product_inf['name']; ?>" /></div>
                                </a>
                            </div>
                                <div class="title">
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
								</div>
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
										<span class="pricenow"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
										<?php
									}
									?>
								</p>
                                <div class="star" id="star_<?php echo $product_id; ?>"></div>
								<?php if ($product_inf['type'] != 0): ?>
									<a href="#" id="<?php echo $product_id; ?>" class="JS-popwinbtn quick_view" data-reveal-id="myModal"><span class="btn-qv">SCHNELLANSICHT</span></a>
								<?php endif; ?>
								<div class="add-wish">
								<?php if(!$customer_id = Customer::logged_in()){ ?>
                                <div class="add_to_wishlist" data-product="<?php echo $product_id; ?>">
                                    <a class="wish-title" data-reveal-id="myModal2" id="wish1_<?php echo $product_id; ?>">Zur Wunschliste Hinzufügen
                                    <i class="fa fa-heart add_wishlist" id="wish_<?php echo $product_id; ?>"></i></a>
                                </div>
                                <?php }else{ ?>
                                <div class="add_to_wishlist" data-product="<?php echo $product_id; ?>">
                                    <a class="wish-title" id="wish1_<?php echo $product_id; ?>">Zur Wunschliste Hinzufügen
                                    <i class="fa fa-heart add_wishlist" id="wish_<?php echo $product_id; ?>"></i></a>
                                </div>
                                <?php } ?>
								</div>
								<div class="sign-warp">
									<span class="sign-close">
										<i class="fa fa-times-circle fa-lg"></i>
									</span>
									<div class="wishlist_success">
										<p class="text" style="border:none;"></p>
										<p class="wish"><i class="fa fa-heart"></i>Wunschliste</p>
									</div>
								</div>
								<?php
								if ($secondhalf && $secondhalf !=1):
									$restrict = unserialize($secondhalf);
									$has = DB::query(Database::SELECT, 'SELECT id FROM catalog_products WHERE product_id = ' . $product_id . ' AND catalog_id IN (' . $restrict['restrict_catalog'] . ')')->execute()->get('id');
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
									$is_new = time() - $product_inf['display_date'] <= 86400 * 7 ? 1 : 0;
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
        <?php
        }
        else
        {
            ?>
            <div class="font18 mt20">Entschuldigung! Ihre Suche ergab leider keine Produkttreffer. Sie können unsere empfohlenen Produkte hier sehen:</div>
            <div class="hide-box1_2">
                <ul class="cf">
                <?php
                $hots = array();
                if(isset($catalog_id))
                {
                    $hots = DB::query(Database::SELECT, 'SELECT P.id, P.link FROM products P LEFT JOIN catalog_products C ON P.id = C.product_id WHERE C.catalog_id = ' . $catalog_id . ' AND P.visibility = 1 AND P.status = 1 AND stock <> 0 ORDER BY P.hits DESC LIMIT 0, 6')->execute();
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
                }
                ?>
                </ul>
            </div>
            <?php
        }
        ?>
        <div class="clearfix"></div>
		<div id="loading" style="text-align:center;display:none;"><img src="<?php echo STATICURL;?>/assets/images/loading.gif"></div>
		<div style="display:none" id="load">1</div>
    </div>
</div>

<?php echo View::factory(LANGPATH . '/quickview'); ?>

<!-- JS-popwincon1 -->
<div id="myModal2" class="reveal-modal xlarge">
    <a class="close-reveal-modal close-btn3"></a>
    <?php echo View::factory(LANGPATH . '/customer/ajax_login'); ?>
</div>
<?php
	$product_str = !empty($product_ids) ? implode(',', $product_ids) : '';
?>

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
                                            <a href="' + pdata['product_href'] + '" id="more_color'+pdata['product_id']+'" style="display:none;">\
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
                                        <a id="' + pdata['product_id'] + '" class="btn-qv quick_view" attr-lang="<?php echo LANGUAGE; ?>" data-reveal-id="myModal">SCHNELLANSICHT</a>';
                                        product_li +=  
                                        '<div class="add-wish">';
                                        <?php if(!$customer_id = Customer::logged_in()){ ?>
                                        product_li += '<div class="add_to_wishlist" data-product="' + pdata['product_id'] + '">\
                                            <a class="wish-title" data-reveal-id="myModal2" id="wish1_' + pdata['product_id'] + '">Zur Wunschliste Hinzufügen <i class="fa fa-heart add_wishlist" id="wish_' + pdata['product_id'] + '"></i></a></div>';

                                        <?php }else{ ?>
                                        product_li +=  
                                            '<div class="add_to_wishlist" data-product="' + pdata['product_id'] + '">\
                                                <a class="wish-title" id="wish1_' + pdata['product_id'] + '">Zur Wunschliste Hinzufügen \
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
                                                <p class="wish"><i class="fa fa-heart"></i>Wunschliste</p>\
                                            </div>\
                                        </div>';
                                        if(pdata['mark']=='outstock'){
                                            product_li += '<span class="outstock">Sold Out</span>';
                                        }else if(pdata['mark']=='flash_sales'){
                                            product_li += '<i class="icon-fsale" id="mark_' + pdata['product_id'] + '"></i>';
                                        }else if(pdata['mark']=='ready_shippeds'){
                                            product_li += '<i class="icon-rshipped" id="mark_' + pdata['product_id'] + '"></i>';
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
						 str +="<span>Hallo, "+rs.firstname+"!</span>";
						 str +="</div>";
						 str +="<dl class='drop-down-list JS-showcon hide' style='display:none;'>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/summary'>Mein Konto</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/orders'>Bestellhistorie</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/tracks/track_order'>Verfolgen</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/wishlist'>Meine Wunschliste</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/profile'>Mein Profil</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/logout'>Abmelden</a>";
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
						 str +="<span>Hallo, "+rs.firstname+"!</span>";
						 str +="</div>";
						 str +="<dl class='drop-down-list JS-showcon hide' style='display:none;'>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/summary'>Mein Konto</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/orders'>Bestellhistorie</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/tracks/track_order'>Verfolgen</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/wishlist'>Meine Wunschliste</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/profile'>Mein Profil</a>";
						 str +="</dd>";
						 str +="<dd class='drop-down-option'>";
						 str +="<a href='<?php echo LANGPATH; ?>/customer/logout'>Abmelden</a>";
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
        })
	})
		
		function showis(loaded_products)
    {
        
        $.ajax({
            type: "POST",
            url: "/ajax/wishlist_data",
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
            url: "/ajax/more_color",
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
<!-- lazyload -->
<script type="text/javascript" charset="utf-8" src="/assets/js/lazyload.js"></script>