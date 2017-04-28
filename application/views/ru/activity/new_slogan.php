<link type="text/css" rel="stylesheet" href="/css/giveaway.css" media="all" />
<script type="text/javascript" src="/js/catalog.js"></script>

<style>
    .wid805{ width:805px;}
    .lp_slogan img{ display:block; border:0 none;}
    .lp_slogan .view_btn{ width:90px; height:22px; text-align:center; line-height:22px; font-size:15px; border:0 none; border-radius:5px; margin:0 5px;}
    .lp_slogan .btn1{ background-color:#fa6561;}
    .lp_slogan .btn2{ background-color:#6fe0ce;}
    .lp_slogan .center p{ margin-bottom:5px;}

    .lp_vote_formcon{ width:520px; margin:20px auto;}
    .lp_vote_formcon li{ margin-bottom:10px;}
    .lp_vote_formcon li label{ display:inline-block; width:70px; margin-right:5px; float:left;}
    .lp_vote_formcon li .btn{ width:145px; height:30px; line-height:30px; background-color:#f65d00; font-size:18px; border-radius:5px; margin-top:10px;}
    .lp_vote_formcon li textarea{ width:430px; height:130px;}

    .lp_vote_share{ border:1px dashed #ccc; padding:12px 0; text-align:center; margin:30px 0; font-size:14px; text-transform:uppercase;}
    .lp_vote_share a{ font-size:12px; display:inline-block; margin-left:15px; text-decoration:underline; background:url(/images/activity/icon1.png) no-repeat; padding:2px 0 1px 22px;}
    .lp_vote_share .a1{ background-position:0 0;}
    .lp_vote_share .a2{ background-position:0 -23px;}
    .lp_vote_share .a3{ background-position:0 -46px;}
    .lp_vote_share p{ color:#5f9514; font-style:italic; text-transform:none; font-size:11px; margin:5px 0 0;}

    .lp_vote_bottom{ padding:20px 60px;}
    .lp_vote_history{ width:105%;}
    .lp_vote_history li{ float:left; width:325px; background-color:#fff; padding:0 30px 25px 0;}
    .lp_vote_history li .name{ display:inline-block; margin-right:5px; width:247px; color:#5f9514;}
    .lp_vote_history li .con{ margin-top:8px; background-color:#ededed; height:22px; line-height:22px; padding:0 10px;}

    .lp_slogan .form li .right_box{ width: 400px; }
    .lp_slogan label.error{ padding-left: 75px; }
</style>

<script type="text/javascript">
    $(function(){
        var step = '<?php echo $step; ?>';
        if(step != '')
        {
            location.href = '#step' + step;
        }
        $("#loginLink,#registerLink").click(function(){
            $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
            $('#catalog_link').appendTo('body').fadeIn(320);
            $('#catalog_link').show();
            return false;
        })
                
        $("#catalog_link .closebtn,#wingray").live("click",function(){
            $("#wingray").remove();
            $('#catalog_link').fadeOut(160).appendTo('#tab2');
            return false;
        })
                
        $("#product input").click(function(){
            var sku = $(this).val();
            $("#sku").val(sku);
            location.href = '#step3';
        })
    })
</script>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Home</a>  >  Giveaway</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <section class="layout fix">
        <section id="container" class="flr">
            <!--hgiveaway star-->
            <div class="lp_slogan wid805">
                <p><img src="/images/activity/slogan_img.jpg" /></p>
                <div id="step1"></div>
                <div id="step2"></div>
                <p><img src="/images/activity/slogan_01.jpg" /></p>
                <?php if(!Customer::logged_in()): ?>
                <div class="center mtb20">
                    <p><a href="#" class="view_btn btn1 JS_popwinbtn1">log in</a> or <a href="#" class="view_btn btn2 JS_popwinbtn1">register</a> to Sumbit Your Slogan.</p>
                    <p>We need to contact you for prize thing.</p>
                </div>
                <?php endif; ?>
                <form action="#" method="post" class="lp_vote_form form" id="sloganForm">
                    <ul class="lp_vote_formcon">
                        <li class="fix">
                            <label><span>*</span> Name:</label>
                            <div class="right_box">
                                <input type="text" name="name" id="name" value="" class="text text_short" />
                            </div>
                        </li>
                        <li class="fix">
                            <label><span>*</span> Slogan:</label>
                            <div class="right_box">
                                <input name="comment" id="giveawaw_comment" class="input text text_long fll" value="" />
                                <label for="giveawaw_comment" generated="true" class="error">Please enter no more than 5 words.</label>
                            </div>
                        </li>
                        <li class="center"><img src="/images/activity/slogan_02.jpg" /></li>
                        <li class="center">
                            <input type="submit" value="submit" class="btn view_btn" />
                        </li>
                    </ul>
                    <script type="text/javascript">
            // signin_form 
            $("#sloganForm").validate({
                rules: {
                    name: {
                        required: true
                    },
                    comment: {
                        required: true
                    }
                },
                messages: {
                    name:{
                        required:"Please provide your name."
                    },
                    comment: {
                        required: "Please enter no more than 5 words."
                    }
                }
            });            
        </script>
                </form>
                <div id="step5"></div>
                <div class="lp_vote_share">
                    <?php
                    $domain = Site::instance()->get('domain');
                    ?>
                    <div>Share to Get More Chances to Win a FREE ITEM: 
                        <a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode('http://www.choies.com/activity/new_slogan'); ?>" class="a1">facebook</a>
                        <a target="_blank" href="http://twitter.com/share?url=<?php echo urlencode('http://www.choies.com/activity/new_slogan'); ?>" class="a2">twitter</a>
                        <a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode('http://www.choies.com/activity/new_slogan'); ?>&media=http://www.choies.com/images/activity/slogan_img.jpg&description=New slogan" class="a3">pinterest</a></div>
                    <p>Or you can share this page's url to your blogs and any other social network.</p>
                </div>
                <?php
                if($success)
                    echo '<div class="remind remind_success">You have submitted your slogan successfully.</div>';
                ?>
                <?php
                if(!empty($comments))
                {
                ?>
                <p><img src="/images/activity/slogan_03.jpg" /></p>
                <div class="lp_vote_bottom">
                    <ul class="lp_vote_history fix">
                        <?php
                        foreach ($comments as $comment):
                            $urls = unserialize($comment['urls']);
                            ?>
                            <li>
                                <p><b class="name"><?php echo $comment['firstname']; ?></b><?php echo date('M d, Y', $comment['created']); ?></p>
                                <p class="con"><?php echo $comment['comments']; ?></p>
                            </li>
                            <?php
                        endforeach;
                        ?>
                    </ul>
                    <div class="fix">
                        <?php echo $pagination; ?>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </section>
        <?php echo View::factory('/catalog_left'); ?>
    </section>
</section>
<div class="JS_popwincon1 popwincon w_signup hide">
    <a class="JS_close2 close_btn2"></a>
    <div class="fix">
        <div class="left" style="width:auto;margin-right:30px;padding-right:30px;">
            <h3>CHOIES Member Sign In</h3>
            <form action="/customer/login?redirect=/activity/new_slogan#step2" method="post" class="signin_form sign_form form">
                <ul>
                    <li>
                        <label>Email address: </label>
                        <input type="text" value="" name="email" class="text" />
                    </li>
                    <li>
                        <label>Password: </label>
                        <input type="password" value="" name="password" class="text" maxlength="16" />
                    </li>
                    <li><input type="submit" value="Sign In" name="submit" class="btn btn40" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">Forgot password?</a></li>
                    <li>
                        <?php
                        $redirect = Arr::get($_GET, 'redirect', '');
                        $page = isset($_SERVER['HTTP_SELF']) ? 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_SELF'] . '/' . htmlspecialchars($redirect) : 'http://' . $_SERVER['HTTP_HOST'] . '/' . htmlspecialchars($redirect);
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
            <form action="/customer/register?redirect=/activity/new_slogan#step2" method="post" class="signup_form sign_form form">
                <ul>
                    <li>
                        <label>Email address: </label>
                        <input type="text" value="" name="email" class="text" />
                    </li>
                    <li>
                        <label>Password: </label>
                        <input type="password" value="" name="password" class="text" id="password" maxlength="16" />
                    </li>
                    <li>
                        <label>Confirm password: </label>
                        <input type="password" value="" name="password_confirm" class="text" maxlength="16" />
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