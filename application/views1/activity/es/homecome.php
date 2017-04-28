<link rel="canonical" href="/<?php echo $catalog_link; ?>" />
	<link rel="stylesheet" type="text/css" href="/css/common.css">
	<link type="text/css" rel="stylesheet" href="/css/quickview.css" media="all" />
    <style>
    .back-to-school-top{
    width:1200px;
    height:auto;
    margin:0 auto;
    }
.back-to-school-top p{
    margin:0;
    }
.back-to-school-top img{
    display:block;
    }
.back-to-school-filter{
    margin-bottom:30px;
    }
.back-to-school-filter .filter-main{
    overflow:hidden;
    }
.back-to-school-filter .filter-main li {
    color: #000;
    cursor: pointer;
    float: left;
    font-size: 1.2em;
    text-align: center;
    filter: alpha(opacity=80);
    opacity: 0.8;
    font-weight:bold;
    text-transform:uppercase;
    width:15%;
}
 @media (max-width: 992px){
     .back-to-school-filter .filter-main li{
     font-size: 0.8em;}
     
     }
.back-to-school-filter .filter-main li span{
    height:22px;
    width:79%;
    border:1px solid #000;
    display:inline-block;
    padding-top: 2px;
    }
.fix::after {
    clear: both;
    content: ".";
    display: block;
    height: 0;
    overflow: hidden;
    visibility: hidden;
}
</style>



    <div class="site-content">
    <div class="main-container clearfix">
    <div class="container">
      <div class="homecoming-top">
            <p><img src="/assets/images/back-to-school-<?php echo LANGUAGE; ?>.jpg"></p>
            <div class="back-to-school-filter ">
                <div class="img-active">
                   <img src="/assets/images/back-to-school-bj.jpg" usemap="#Map">
                   <map name="Map" id="Map11">
                     <area shape="rect" coords="153,2,322,90" href="<?php echo LANGPATH; ?>/activity/back_to_school?type=709">
                     <area shape="rect" coords="329,4,514,93" href="<?php echo LANGPATH; ?>/activity/back_to_school?type=710">
                     <area shape="rect" coords="515,2,688,108" href="<?php echo LANGPATH; ?>/activity/back_to_school?type=711">
                     <area shape="rect" coords="693,3,866,93" href="<?php echo LANGPATH; ?>/activity/back_to_school?type=712">
                     <area shape="rect" coords="871,3,1054,93" href="<?php echo LANGPATH; ?>/activity/back_to_school?type=713">
                   </map>
               <div>
               <ul class="filter-main hidden-xs">
               <a href="<?php echo LANGPATH; ?>/activity/back_to_school?type=709"><li class=" current" style="margin-left:13%;"><span>Partes de arriba</span></li></a>
               <a href="<?php echo LANGPATH; ?>/activity/back_to_school?type=710"><li class=""><span>Partes de abajo</span></li></a>
               <a href="<?php echo LANGPATH; ?>/activity/back_to_school?type=711"><li class=""><span>Vestidos</span></li></a>
                    <a href="<?php echo LANGPATH; ?>/activity/back_to_school?type=712"><li class=""><span>Zapatos</span></li></a>
                    <a href="<?php echo LANGPATH; ?>/activity/back_to_school?type=713"><li class=""><span>Accesorios</span></li></a>
                </ul>                     
          </div>    
        </div>  
	  <div class="pro-list">
			<ul class="row">
    <?php
                        $_limit = count($products) >= $limit ? $limit : count($products);
                        foreach ($products as $key => $product_id){
                            $images = Product::instance($product_id)->images();
							$product = Product::instance($product_id, LANGUAGE);
                            $cover_image = Product::instance($product_id)->cover_image();
                            $product_inf = DB::select('type', 'name', 'price', 'has_pick', 'status', 'stock', 'display_date')
                                            ->from('products_'.LANGUAGE)
                                            ->where('id', '=', $product_id)
                                            ->execute()->current();
                            $plink = $product->permalink();
                            ?>
				<li class="pro-item col-xs-6 col-sm-3">
                 <div class="overlay"></div>
                            <div class="pic">
                                <a href="<?php echo $plink; ?>">
                                    <div class="pic1"><img data-original="<?php echo Image::link($cover_image, 1); ?>" src="/assets/images/loading.gif"  title="<?php echo $product_inf['name']; ?>" /></div>
                                </a>
                                <a href="<?php echo $plink; ?>" id="more_color<?php echo $product_id; ?>" style="display:none;"><span class="icon-color" title="More Colors"></span></a>
                            </div>
             <div class="title">
                            <a href="<?php echo $plink; ?>" title="<?php echo $product_inf['name']; ?>">
                            <?php
                            if ($product_inf['has_pick'] != 0)
                            {
                                ?>
                                <i class="myaccount"></i>
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
                                <span class="pricenew"><?php echo Site::instance()->price($product_inf['price'], 'code_view'); ?></span>
                                <?php
                            }
                            ?>
                        </p>
                        <div class="star" id="star_<?php echo $product_id; ?>">
                        
                        </div>
					 <a href="#" id="<?php echo $product_id; ?>" class="btn-qv quick_view"  data-reveal-id="myModal">Quick View</a>
					<div class="add-wish">
					
					  <?php
					  $product_id = $product->get('id');
                        if(in_array(array('product_id' => $product_id), $wishlists))
                        {
                            ?>
						
                        <i class="fa fa-heart add_wishlist2"></i>
						
                            <?php
                        }
                        else
                        {   ?>
                        <div class="add_to_wishlist" data-product="<?php echo $product->get('id'); ?>">
                            <a class="wish-title" data-reveal-id="myModal2">Add to wishlist</a>
                            <i class="fa fa-heart add_wishlist" id="wish_<?php echo $product->get('id'); ?>"></i>
                        </div>
                        <?php
                        }
                        ?>

						
					</div>
                        <div class="sign-warp">
                            <span class="sign-close">
                                <i class="fa fa-times-circle fa-lg"></i>
                            </span>
                            <div class="wishlist_success">
                                <p class="text" style="border:medium none;"></p>
                              <p class="wish">
					<i class="fa fa-heart"></i>
						Wishlist
							</p>
                            </div>
                        </div>
				</li>
					<?php }?>
			</ul>
		<div class="pager">
			<?php echo $pagination1; ?>
		</div>
		</div>
	</div>	
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
<?php echo View::factory('quickview'); ?>
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
	</div>
	
<!-- JS_popwincon2 -->
<div id="myModal2" class="reveal-modal xlarge">
        <a class="close-reveal-modal close-btn3"></a>
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
                                    $("#myModal2").hide();
                                    $(".reveal-modal-bg").hide();
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
/*                        var top = getScrollTop();
                        top = top - 35;
                        $('body').append('<div class="JS_filter2 opacity"></div>');
                        $('.JS_popwincon2').css({
                            "top": top, 
                            "position": 'absolute'
                        });
                        $('.JS_popwincon2').appendTo('body').fadeIn(320);
                        $('.JS_popwincon2').show();*/
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
                                    $("#myModal2").hide();
                                    $(".reveal-modal-bg").hide();
                                    $("#wish_" + pid).parent().find('span').text('');
                                    $("#wish_" + pid).attr('class', 'fa fa-heart red');
                                    $(".wishlist_success").show();
                                    $(".JS-filter1").remove();
                                    $(".JS-popwincon1").fadeOut(160);
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
                                    $("#myModal2").hide();
                                    $(".reveal-modal-bg").hide();
                                    $("#wish_" + pid).parent().find('span').text('');
                                    $("#wish_" + pid).attr('class', 'fa fa-heart red');
                                    $(".wishlist_success").show();
                                    $(".JS_filter2").remove();
                                    $(".JS-popwincon2").fadeOut(160);
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
/*        $(".page a").click(function(){
            var link = $(this).attr('href');
            if(link)
                location.href = link + '#catalog_filter';
            return false;
        })*/

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
                    $("#wish_"+pid).parent().find('.wish-title').remove();
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
	<script type="text/javascript" src="/js/list.js"></script>
    <script>
    //pic map自适应
        adjust();  
        var timeout = null;//onresize触发次数过多，设置定时器  
        window.onresize = function () {  
            clearTimeout(timeout);  
            timeout = setTimeout(function () { window.location.reload(); },50);//页面大小变化，重新加载页面以刷新MAP  
        }  
  
        //获取MAP中元素属性  
        function adjust() {  
            var map = document.getElementById("Map11");  
            var element = map.childNodes;  
            var itemNumber = element.length / 2;  
            for (var i = 0; i < itemNumber - 1; i++) {  
                var item = 2 * i + 1;  
                var oldCoords = element[item].coords;  
                var newcoords = adjustPosition(oldCoords);  
                element[item].setAttribute("coords", newcoords);  
            }  
            var test = element;  
        }  
  
        //调整MAP中坐标  
        function adjustPosition(position) {   
            var boxWidth = $(".img-active").width();
            var boxHeight = $(".img-active").height();

            var imageWidth =  1200;    //图片的长宽  
            var imageHeight = 91;  
  
            var each = position.split(",");  
            //获取每个坐标点  
            for (var i = 0; i < each.length; i++) {  
                each[i] = Math.round(parseInt(each[i]) * boxWidth / imageWidth).toString();//x坐标  
                i++;  
                each[i] = Math.round(parseInt(each[i]) * boxHeight / imageHeight).toString();//y坐标  
            }  
            //生成新的坐标点  
            var newPosition = "";  
            for (var i = 0; i < each.length; i++) {  
                newPosition += each[i];  
                if (i < each.length - 1) {  
                    newPosition += ",";  
                }  
            }  
            return newPosition;  
        }  
    
    
    $('.detail-tab li').click(function(){
        var liindex = $('.detail-tab li').index(this);
        $(this).addClass('current').siblings().removeClass('current');
        var liWidth = $('.detail-tab li').width();
        $('.detail-tab p').stop(false,true).animate({'left' : (liindex * liWidth +213)+ 'px'},300);
    });
    </script>
    <script>
	
	$("#a1").click(function(){
    $.post(
        '/activity/ajax_homecome?type=1',
        {
            cata:'Dresses'
        },
        function (data) {
		
			$("#aaa").html(data.pro);
			var abc = data.pa;
			$("#aaa").append(abc);
        },
        'json'
    )
		
		
	})
    </script>
