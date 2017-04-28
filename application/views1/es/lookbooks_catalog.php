<div class="page">
    <div class="site-content">
		<div class="main-container clearfix">
			<div class="container">
				<div class="crumbs">
		            <div class="fll">
		                <a href="<?php echo LANGPATH; ?>/" class="home">PÁGINA DE INICIO</a>&gt; 
		                <a href="<?php echo LANGPATH; ?>/lookbook" >Lookbook</a>
		               <!-- <span>Dresses</span>-->
		            </div>
                </div>
				<ul class="filter-bar cf">
					<div class="fll fa-2x">LOOKBOOK</div>
				</ul>
				<ul class="pagination flr mt15">
					<?php echo $pagination; ?>
			    </ul>
			    <div class="clearfix"></div>
			    <!-- lookbook-list -->
		        <div class="lookbook-list">
		        	<div class="lookbook-box row">
		        		<ul class="lookbook-ul">
                        <?php
            			$customer_id = Customer::logged_in();

                        foreach($lookbooks as $i =>$v)
                        {
                            if (isset($v['product_id']))
                            {
                                $product_ins = Product::instance($v['product_id'], LANGUAGE);
            					$link = $product_ins->permalink();
                                if($product_ins->get('set_id') == 502)
                                    continue;
                                $c = DB::select('id', 'image')->from('celebrity_images')->where('product_id', '=', $v['product_id'])->where('type','in',array(1,3))->order_by('position', 'desc')->execute()->current(); 
                                $lookbook['id'] = $c['id'] . '-' . '1';
                                $lookbook['title'] = $product_ins->get('name');
                                $images = array(
                                    'main' => $c['image']
                                );
                            }
                            else
                            {
                                $lookbook = $lookbooks[$i];
                                $images = unserialize($lookbook['images']);
                            }

                            ?>				
			
		        			<li class="lookbook-item col-xs-6 col-sm-3">
					        	<div class="outfit">
					            	<div class="viewport pro-four-dp" id="<?php echo LANGUAGE; ?>">
					            		<div class="products" id="<?php echo $v['product_id']; ?>">
					                		<ul class="product-list">
                                                <li class="product aa"><a href="" target="_blank"></a></li>
                                                <li class="product aa"><a href="" target="_blank"></a></li>
                                                <li class="product aa"><a href="" target="_blank"></a></li>
                                                <li class="product aa"><a href="" target="_blank"></a></li>
					                    	</ul>
					                    </div>
					                    <a class="gallery-overlay-trigger" href="<?php echo LANGPATH; ?>/lookbook/<?php echo $lookbook['id']; ?>"  target="_blank" ><img class="outfit-image" src="<?php echo STATICURL . '/simg/' . $images['main']; ?>"></a>
					                </div>             
					            	<div class="meta-bar">
					            		<div class="meta-pro-name"><a target="_blank" href="<?php echo LANGPATH; ?>/lookbook/<?php echo $lookbook['id']; ?>"><?php echo $lookbook['title']; ?></a></div>
					                    <div class="meta-pro-botton">
					                    	<div class="meta-pro-mes fll" >
					                        	<div class="meta-sns met-pc mr10 JS-show">
					                           		<div class="meta-sns-list JS-showcon" style="display:none;">
					                                	<b class="sc-b"></b>
					                            		<a class="meta-sns1 met-pc" title="facebook" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($link); ?>" target="_blank" ></a>
					                           			<a class="meta-sns2 met-pc" title="twitter" href="http://twitter.com/share?url=<?php echo urlencode($link); ?>" target="_blank"></a>
					                            		<a class="meta-sns3 met-pc" title="tumblr" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($link); ?>&media=<?php echo Image::link($product_ins->cover_image(), 1); ?>&description=<?php $product_ins->get('name'); ?>" target="_blank"></a>
					                            	</div>
					                            </div>
												<?php
            									if(in_array(array('product_id' => $v['product_id']), $wishlists))
            									{
            									?>
            									<a href="" title="I like it" class="notadd meta-heart-on met-pc" data-product="<?php echo $v['product_id']; ?>"></a>									
            									<?php
            									}
            									else
            									{
            									?>
            							
            								    <a href="" title="I like it" class="add_to_wishlist meta-heart-on met-pc" data-product="<?php echo $v['product_id']; ?>"></a>							
            									<?php
            									}
            									?>
					                            <div class="loves-count fll" id="wish1_<?php echo $v['product_id']; ?>"><?php echo $v['wish']['wish']; ?></div>
					                        </div>
					                    	<a  class="btn btn-primary btn-xs flr" target="_blank" href="<?php echo LANGPATH; ?>/lookbook/<?php echo $lookbook['id']; ?>">Ver Detalles </a>
					                    </div>
					            	</div>
					            </div>
				            </li>
                            <?php
                        }
                        ?>
			            </ul>
					</div>
		        </div>
			    <ul class="pagination flr mt10 mb10">
				<?php echo $pagination; ?>
			    </ul>
			</div>
		</div>
	</div>

	<div id="gotop" class="hide ">
		<a href="#" class="xs-mobile-top"></a>
	</div>
</div>

<!-- JS-popwincon1 -->
<div class="JS-popwincon1 popwincon w_signup hide">
<a class="JS-close2 close-btn3"></a>
<div class="w-signup" id="sign_in_up">
    <div class="left col-sm-6 col-xs-12" style="width:388px;margin-right: 0px;padding-right:30px;">
        <h3>Acceso para socios</h3>
        <div id="customer_pid" style="display:none;"></div>
        <form action="#" method="post" class="signin-form sign-form form" id="form_login">
            <ul>
                <li>
                    <label>Email: </label>
                    <input type="text" value="" name="email" class="text" id="email1" />
                </li>
                <li>
                    <label>Contraseña: </label>
                    <input type="password" value="" name="password" class="text" maxlength="16" id="password1" />
                </li>
                <li><input type="submit" value="ACCEDER" name="submit" class="btn btn-primary btn-lg mr10" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">¿Olvidaste tu contraseña?</a></li>
                <li>
                    <?php
                    $page = 'http://' . $_SERVER['COFREE_DOMAIN'] . URL::current(0);
                    $facebook = new facebook();
                    $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                    ?>
                    <a href="<?php echo $loginUrl; ?>" class="facebook-btn">Acceder con Facebook</a>
                </li>
            </ul>
        </form>
    </div>
    <div class="right col-sm-6 col-xs-12">
        <h3>Únete a Choies</h3>
        <form action="#" method="post" class="signup-form sign-form form" id="form_register">
            <ul>
                <li>
                    <label>Email: </label>
                    <input type="text" value="" name="email" class="text" id="email2" />
                </li>
                <li>
                    <label>Contraseña: </label>
                    <input type="password" value="" name="password" class="text" id="password2" maxlength="16" />
                </li>
                <li>
                    <label>Confirmar Contraseña: </label>
                    <input type="password" value="" name="password_confirm" id="password_confirm" class="text" maxlength="16" />
                </li>
                <li><input type="submit" value="REGISTRARTE" name="submit" class="btn btn-primary btn-lg mr10" /></li>
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
                '<?php echo LANGPATH; ?>/customer/email_exists',
                {
                    email: email
                },
                function(result)
                {
                    if(result != 1)
                    {
                        if (!window.confirm('¿Estás seguro de que tu dirección de correo electrónico termina con ' + result + '?'))
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
                required:"Por favor, proporcione un email.",
                email:"Por favor, introduce una dirección de email válida."
            },
            password: {
                required: "Por favor, ingrese su contraseña.",
                minlength: "Su contraseña debe tener al menos 5 caracteres."
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
                required:"Por favor, proporcione un email.",
                email:"Por favor, introduce una dirección de email válida."
            },
            password: {
                required: "Por favor, ingrese su contraseña.",
                minlength: "Su contraseña debe tener al menos 5 caracteres.",
                maxlength:"La contraseña supera la longitud máxima de 20 caracteres."
            },
            password_confirm: {
                required: "Por favor, ingrese su contraseña.",
                minlength: "Su contraseña debe tener al menos 5 caracteres.",
                maxlength:"La contraseña supera la longitud máxima de 20 caracteres.",
                equalTo: "Por favor, ingrese una contraseña la misma que arriba."
            }
        }
    });
</script>
</div>
<script>
$(function(){
    $(".add_to_wishlist").live('click', function(){
        var pid = $(this).attr('data-product');
        var _proItem = $(this).parents(".pro-item");
		var coo =$(this).next("div").html();

        $.ajax({
            url:'<?php echo LANGPATH; ?>/customer/ajax_login1',
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
								coo  = parseInt(coo) + parseInt(1);
								$("#wish1_" + pid).html(coo);
								$("#wish1_" + pid).prev().attr('class','notadd meta-heart-on met-pc');
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
                    $('body').append('<div class="JS-filter1 opacity"></div>');
                    $('.JS-popwincon1').css({
                        "top": top, 
                        "position": 'absolute'
                    });
                    $('.JS-popwincon1').appendTo('body').fadeIn(320);
                    $('.JS-popwincon1').show();
                }
            }
        });
        return false;
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
	
    $(".notadd").live('click', function() {
        return false;
    });

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

    //close wihlist_success
    $(".sign-close").click(function(){
        $(this).parent().hide();
    })



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

</script>

