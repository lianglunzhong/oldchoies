<?php
        if ($type != 'payment' && $type != 'purchase' && $type != 'cart')
        {
            ?>
            <!-- footer begin -->
            <footer>
                <div class="w_top">
                    <div class="top layout fix">
                        <dl>
                            <dt>MY ACCOUNT</dt>
                            <dd><a href="/track/track_order">Track Order</a></dd>
                            <dd><a href="/customer/orders">Order History</a></dd>
                            <dd><a href="/customer/profile">Account Setting</a></dd>
                            <dd><a href="/customer/points_history">Points History</a></dd>
                            <dd><a href="/customer/wishlist">Wish List</a></dd>
                            <dd><a href="/vip-policy">VIP Policy</a></dd>
                            <dd><a onclick="return feed_show();">Feedback</a></dd>
                        </dl>
                        <dl>
                            <dt>HELP INFO</dt>
                            <dd><a href="/faqs">FAQ</a></dd>
                            <dd><a href="/contact-us">Contact Us</a></dd>
                            <dd><a href="/payment">Payment</a></dd>
                            <dd><a href="/coupon-points">Coupon &amp; Points</a></dd>
                            <dd><a href="/shipping-delivery">Shipping &amp; Delivery</a></dd>
                            <dd><a href="/returns-exchange">Returns &amp; Exchange</a></dd>
                            <dd><a href="/conditions-of-use">Conditions of Use</a></dd>
                            <dd><a href="/how-to-order">How To Order</a></dd>
                        </dl>
                        <dl>
                            <dt>FEATURED</dt>
                            <dd><a href="/lookbook">Lookbook</a></dd>
                            <dd><a href="/freetrial/add">Free Trial</a></dd>
                            <dd><a href="/activity/flash_sale">Flash Sale</a></dd>
                            <dd><a href="/wholesale">Wholesale</a></dd>
                            <dd><a href="/affiliate-program">Affiliate Program</a></dd>
                            <dd><a href="/blogger/programme">Blogger Wanted</a></dd>
                            <dd><a href="/rate-order-win-100" style="color:red;">Rate &amp; Win $100</a></dd>
                            <dd><a href="/sharewin/index">Share and Win</a></dd>
                        </dl>
                        <dl>
                            <dt>ALL SITES</dt>
                            <dd><a href="<?php echo $request; ?>">English Site</a></dd>
                            <dd><a href="/es<?php echo $request; ?>">Spanish Site</a></dd>
                            <dd><a href="/fr<?php echo $request; ?>">French Site</a></dd>
                            <dd><a href="/de<?php echo $request; ?>">German Site</a></dd>
                            <dd><a href="/ru<?php echo $request; ?>">Russian Site</a></dd>
                        </dl>
                        <dl class="last">
                            <dt>Find Us On</dt>
                            <dd class="sns fix">
                                <a rel="nofollow" href="http://www.facebook.com/choiescloth" target="_blank" class="sns1" title="facebook"></a>
                                <a rel="nofollow" href="http://twitter.com/#!/choiescloth" target="_blank" class="sns2" title="twitter"></a>
                                <a rel="nofollow" href="http://thatisstylish.tumblr.com" target="_blank" class="sns3" title="tumblr"></a>
                                <a rel="nofollow" href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4" title="youtube"></a>
                                <!--<a rel="nofollow" href="http://www.pinterest.com/choiesclothes/" target="_blank" class="sns5" title="pinterest"></a>-->
                                <a rel="nofollow" href="http://www.chictopia.com/Choies" target="_blank" class="sns6" title="chictopia"></a>
                                <a rel="nofollow" href="http://instagram.com/choiescloth" target="_blank" class="sns7" title="instagram"></a>
                                <!--<a rel="nofollow" href="http://wanelo.com/store/choies" target="_blank" class="sns9" title="wanelo"></a>-->
                            </dd>
                            <dd class="letter">
                                <form action="" method="post" id="letter_form">
                                    <label>SIGN UP FOR OUR EMAILS</label>
                                    <div class="fix">
                                        <input type="text" id="letter_text" class="text fll" value="Email Address" onblur="if(this.value==''){this.value=this.defaultValue;}"  onfocus="if(this.value=='Email Address'){this.value='';};" />
                                        <input type="submit" id="letter_btn" value="Submit" class="btn fll" />
                                    </div>
                                </form>
                            </dd>
                            <div class="red" id="letter_message" style="display: none;"></div>
                            <script language="JavaScript">
                                $(function(){
                                    $("#letter_form").submit(function(){
                                        var email = $('#letter_text').val();
                                        if(!email)
                                        {
                                            return false;
                                        }
                                        $.post(
                                        '/newsletter/ajax_add',
                                        {
                                            email: email
                                        },
                                        function(data)
                                        {
                                            $("#letter_message").html(data['message']);
                                            if(data['success'] == 0)
                                            {
                                                $('#letter_message').fadeIn(10).delay(3000).fadeOut(10);
                                            }
                                            else
                                            {
                                                $("#letter").css('display', 'none');
                                                $("#letter_message").css('display', 'block');
                                            }
                                        },
                                        'json'
                                    );
                                        return false;
                                    })
                                })
                            </script>
                        </dl>
                    </div>
                    
                    <div class="card">
                        <p>
                            <img src="/images/card.jpg" usemap="#Card" />
                            <map name="Card" id="Card">
                                <area shape="rect" coords="88,2,193,62" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en" target="_blank" />
                            </map>
                        </p>
                    </div>
                </div>
                <div style="background-color:#232121;">
                    <p class="bottom">
                        Copyright © 2006-<?php echo date('Y'); ?> Choies.com&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a style="color: #ccc;" href="/privacy-security">Privacy &amp; Security</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a style="color: #ccc;" href="/about-us">About Choies</a>
                    </p>
                </div>
                <!--            <div class="w_bottom JS_hide">
                                <div class="bottom layout fix">
                                    <div class="left fll">
                                        <a href="#" class="a1"></a>
                                        <a href="#" class="a2"></a>
                                        <span class="f0llowus"></span>
                                    </div>
                                    <div class="right flr">
                                        <form action="/newsletter/single_add" method="post" class="fix" id="newsletter_form">
                                            <label class="left"></label>
                                            <div class="newsletter fix">
                                                <input type="text" name="email" value="Sign up with your email..." class="text fll" />
                                                <input type="submit" value="" class="btn fll" />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <span class="JS_close close_btn1"></span>
                            </div>-->
            </footer>
            <div id="gotop" class="hide" style="display:block;"><a href="#"></a></div>
            
            <script type="text/javascript">
                $(function(){
                    $("#w_bottom_close").live("click",function(){
                    $.ajax({
                                    type: "POST",
                                    url: "/site/hide_banner",
                                    dataType: "json",
                                    data: "",
                                    success: function(msg){
                                        $("#w_bottom_banner").css('display','none');
                                    }
                                });
                    });
                })
            </script>
            <script type="text/javascript">
                $(function(){
                    //                                $(".feed").live('click', function(){
                    //                                        $(".f_email").val('');
                    //                                        $("#f_comment").val('');
                    //                                        $('body').append('<div id="wingray2" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                    //                                        $('#feedback').appendTo('body').fadeIn(240);
                    //                                })
                    $("#feedback .clsbtn,#wingray2").live("click",function(){
                        $("#wingray2").remove();
                        $('#feedback').fadeOut(160);
                        $('#feedback_success').fadeOut(160);
                        return false;
                                                
                    })
                    $("#feedback_success .clsbtn,#wingray3").live("click",function(){
                        $("#wingray3").remove();
                        $("#wingray2").remove();
                        $('#feedback_success').fadeOut(160);
                        $('#feedback').fadeOut(160);
                        return false;
                    })
                    $("#feedback .formArea").submit(function(){
                        var email1 = $('#f_email1').val();
                        var email2 = $('#f_email2').val();
                        var comment = $("#f_comment").val();
                        var what_like = $("#what_like").val();
                        var do_better = $("#do_better").val();
                        if((!email1 && !email2) || (!comment && !do_better))
                        {
                            return false;
                        }
                        $.post(
                        '/review/ajax_feedback',
                        {
                            email1: email1,
                            email2: email2,
                            comment: comment,
                            what_like: what_like,
                            do_better: do_better
                        },
                        function(data)
                        {
                            $('body').append('<div id="wingray3" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                            $('#feedback_success').appendTo('body').fadeIn(240);
                            if(data['success'] == 0)
                            {
                                $("#feedback_success .failed1").show();
                                $("#feedback_success .failed1 p").html(data['message']);
                                $("#feedback_success .success1").hide();
                                $("#wingray3").remove();
                                $("#feedback").hide();
                            }
                            else if(data['success'] == -1)
                            {
                                $("#feedback_success .failed1").show();
                                $("#feedback_success .failed1 p").html(data['message']);
                                $("#feedback_success .success1").hide();
                                $("#wingray3").remove();
                                $("#feedback").remove();
                                $("#feedback_success").attr('id', 'feedback');
                            }
                            else
                            {
                                $("#feedback_success success1").show();
                                $("#feedback_success .failed1").hide();
                                $("#wingray3").remove();
                                $("#feedback").remove();
                                $("#feedback_success").attr('id', 'feedback');
                            }
                        },
                        'json'
                    );
                        return false;
                    })
                })
                                
                function feed_show()
                {
                    $(".f_email").val('');
                    $("#f_comment").val('');
                    $('body').append('<div id="wingray2" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                    $('#feedback').appendTo('body').fadeIn(240);
                }
            </script>

            <div id="feedback" style="display:none;">
                <div class="feedback">
                    <div class="feedback_title">
                        <div class="fll text1">CHOIES WANT TO HEAR YOUR VOICE!</div>
                        <div class="close_btn3 clsbtn" style="right: 0px;top: 3px;"></div>
                    </div>
                    <div class="clear"></div>
                    <div class="point ml15 mt5">Those who provide significant feedbacks can get <strong class="red">$5 Points</strong> Reward.</div>
                    <div id="tab6">
                        <div id="tab-nav" class="JS_tab5">
                            <ul class="fix">
                                <li class="on">FEEDBACK</li>
                                <li>PROBLEM?</li>
                            </ul>
                        </div>
                        <div id="tab-con" class="JS_tabcon5">
                            <div>
                                <form id="feedbackForm" method="post" action="#" class="form formArea">
                                    <ul>
                                        <li>
                                            <label for="My Suggestion:">Choies,this is what I like: </label>
                                            <textarea name="what_like" id="what_like" rows="3" class="input textarea"></textarea>
                                        </li>
                                        <li>
                                            <label for="My Suggestion:"><span>*</span> Choies,I think you can do better: <span class="errorInfo clear hide">Please write something here.</span></label>
                                            <textarea name="do_better" id="do_better" rows="5" class="input textarea"></textarea>
                                        </li>
                                        <li>
                                            <label for="Email Address:"><span>*</span> Email Address:<span class="errorInfo clear hide">Please enter your email.</span><br/>
                                            </label>
                                            <input type="email" name="email" id="f_email1" class="text text_long" value="" maxlength="340" />
                                        </li>
                                        <li>
                                            <input type="submit" value="SUBMIT" class="view_btn btn26 btn40 form_btn" style="width: 100px;" />
                                        </li>
                                    </ul>
                                </form>
                                <script>
                                    $("#feedbackForm").validate({
                                        rules: {
                                            email: {
                                                required: true,
                                                email: true
                                            },
                                            do_better: {
                                                required: true,
                                                minlength: 5
                                            }
                                        },
                                        messages: {
                                            email:{
                                                required:"Please provide an email.",
                                                email:"Please enter a valid email address."
                                            },
                                            password: {
                                                minlength: "Your password must be at least 5 characters long."
                                            }
                                        }
                                    });
                                </script>
                            </div>
                            <div class="hide">
                                <form id="problemForm" method="post" action="#" class="form formArea">
                                    <ul>
                                        <li>
                                            <label for="My Suggestion:"><span>*</span> Need help? Please describe the problem: <span class="errorInfo clear hide">Please write something here.</span></label>
                                            <textarea name="comment" id="f_comment" rows="7" class="input textarea"></textarea>
                                        </li>
                                        <li>
                                            <label for="Email Address:"><span>*</span> Email Address:<span class="errorInfo clear hide">Please enter your email.</span><br/>
                                            </label>
                                            <input type="email" name="email1" id="f_email2" class="text text_long" value="" maxlength="340" />
                                        </li>
                                        <li>
                                            <input type="submit" value="SUBMIT" class="view_btn btn26 btn40 form_btn" style="width: 100px;" />
                                        </li>
                                    </ul>
                                </form>
                                <script>
                                    $("#problemForm").validate({
                                        rules: {
                                            email1: {
                                                required: true,
                                                email: true
                                            },
                                            comment: {
                                                required: true,
                                                minlength: 5
                                            }
                                        },
                                        messages: {
                                            email1:{
                                                required:"Please provide an email.",
                                                email:"Please enter a valid email address."
                                            },
                                            password: {
                                                required: "Please provide a comment.",
                                                minlength: "Your password must be at least 5 characters long."
                                            }
                                        }
                                    });
                                </script>
                                <p class="mt10">More detailed questions? Please <a href="https://chatserver.comm100.com/chatwindow.aspx?planId=311&siteId=203306" title="contact us" target="_blank">contact us</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="feedback_success" style="display:none;">
                <div class="feedback" style="height:200px;">
                    <div class="close_btn3 clsbtn" style="right: 0px;top: 3px;"></div>
                    <div class="success1">
                        <h3>THANK YOU !</h3>
                        <p><em>Your feedback has been received !</em></p>
                    </div>
                    <div class="failed1">
                        <h3>Sorry!</h3>
                        <p></p>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                // newsletter_form
                $("#newsletter_form").validate({
                    rules: {
                        email: {
                            required: true,
                            email: true
                        }
                    },
                    messages: {
                        email:{
                            required:"",
                            email:""
                        }
                    }
                
                });
            </script>
            <?php
        }
        ?>

        <script type="text/javascript">
            $(function(){
                //cart ajax
                ajax_cart();
                $('.currency_select').change(function(){
                    var currency = $(this).val();
                    location.href = '/currency/set/' + currency;
                    return false;
                })
                //recent view
                //                $.ajax({
                //                    type: "POST",
                //                    url: "/site/ajax_recent_view",
                //                    dataType: "json",
                //                    data: "",
                //                    success: function(msg){
                //                        $("#recent_view ul").html(msg);
                //                    }
                //                });
                
                //                $(".remind").delay(8000).fadeOut(500);
            })

            function ajax_cart()
            {
                $.ajax({
                    type: "POST",
                    url: "/cart/ajax_cart",
                    dataType: "json",
                    data: "",
                    success: function(msg){
                        if(msg['count'] > 0)
                        {
                            $(".cart_count").text(msg['count']);
                            if(msg['count'] > 1)
                                $(".cart_s").html('s');
                            else
                                $(".cart_s").html('');
                            $(".cart-all-goods").show();
                            $(".cart_bag").html(msg['cart_view']);
                            if(msg['sale_words'])
                            {
                                $("#sale_words").show();
                                $("#sale_words").text(msg['sale_words']);
                                $("#free_shipping").hide();
                            }
                            else if(msg['free_shipping'])
                            {
                                $("#free_shipping").show();
                                $("#sale_words").hide();
                            }
                            else
                            {
                                $("#free_shipping").hide();
                                $("#sale_words").hide();
                            }
                            $(".cart_amount").html(msg['cart_amount']);
                            $(".cart_bag").show();
                            $(".cart_bag_empty").hide();
                            $(".cart_button").show();
                            $(".cart_button_empty").hide();
                        }
                        else
                        {
                            $(".free-shipping").hide();
                            $(".cart_bag_empty").show();
                            $(".cart_bag").hide();
                            $(".cart_button_empty").show();
                            $(".cart_button").hide();
                            $(".cart-all-goods").hide();
                        }
                    }
                });
            }
        </script>

        <div style="display:none;">

<!--            <script language="javascript" src="http://count35.51yes.com/click.aspx?id=352285727&logo=1" charset="gb2312"></script>-->

            <!-- New Remarket Code -->
            <?php
            if (!$type)
            {
                ?>
                <script type="text/javascript">
                    var google_tag_params = {
                        ecomm_prodid: '',
                        ecomm_pagetype: 'other',
                        ecomm_totalvalue: ''
                    };
                </script>
                <script type="text/javascript">
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

                <?php
            }
            elseif (in_array($type, array('cart','category','home','purchase', 'cart_view')))
            {
                if($type == 'cart_view')
                    $type = 'cart';
                ?>
                <script type="text/javascript">
                    var google_tag_params = {
                        ecomm_prodid: '',
                        ecomm_pagetype: '<?php echo $type; ?>',
                        ecomm_totalvalue: ''
                    };
                </script>
                <script type="text/javascript">
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

                <?php
            }
            ?>
                
            <!-- FB Website Visitors Code -->
            <script>
                (function() {
                  var _fbq = window._fbq || (window._fbq = []);
                  if (!_fbq.loaded) {
                    var fbds = document.createElement('script');
                    fbds.async = true;
                    fbds.src = '//connect.facebook.net/en_US/fbds.js';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(fbds, s);
                    _fbq.loaded = true;
                  }
                  _fbq.push(['addPixelId', '454325211368099']);
                })();
                window._fbq = window._fbq || [];
                window._fbq.push(['track', 'PixelInitialized', {}]);
            </script>
            <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=454325211368099&amp;ev=NoScript" /></noscript>
            <!-- End FB Website Visitors Code -->
            <!-- HK ScarabQueue statistics Code -->
            <?php 
            if($user_id){
            $email = $user_session['email'];
            ?>
            <script type="text/javascript">ScarabQueue.push(['setEmail', '<?php echo $email; ?>']);</script>
            <script type="text/javascript">
            varpageTracker=_gat._getTracker("UA-32176633-1");
            pageTracker._setVar('register');//设置用户分类
            pageTracker._trackPageview();
            </script>
            <?php } ?>
            <script type="text/javascript">ScarabQueue.push(['go']);</script>
            <!-- HK ScarabQueue statistics Code -->
            <?php if (!in_array($type, array('cart','product', 'paysuccess','cart_view'))){ ?>
            <!-- cityads code -->
            <script id="xcntmyAsync" type="text/javascript"> 
            (function(d){ 
            var xscr = d.createElement( 'script' ); xscr.async = 1; 
            xscr.src = '//x.cnt.my/async/track/?r=' + Math.random(); 
            var x = d.getElementById( 'xcntmyAsync' ); 
            x.parentNode.insertBefore( xscr, x ); 
            })(document); 
            </script>
            <!-- cityads code -->
            <?php } ?>
            <!-- <script src="//cdn.optimizely.com/js/557241246.js"></script> -->
        </div>
        
    </body>
</html>