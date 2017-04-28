<?php
if($customer_id)
{
    ?>
    <style>
    #main{background-color:#006600;margin-bottom:-30px;min-height: 414px;}
    .main-green{width:1024px;margin:0 auto;padding-bottom:160px;}
    .main-green p.scan-win-img{padding: 70px 0 0 296px;}
    .main-green div{padding:20px 0 0 296px;overflow:hidden;width:432px;}
    .main-green div p{text-align:center;color:#ffffff;font-size:14px;}
    .main-green div a{display:block;margin:20px 0 0 150px;}
    </style>
    <?php
}
else
{
    ?>
    <style>
    #main{background-color:#006600;margin-bottom:-30px;min-height: 414px;}
    .main-green{width:1024px;margin:0 auto;padding-bottom:190px;}
    .main-green p.scan-win-img{padding: 85px 0 0 296px;}
    .main-green div{padding:32px 0 0 296px;overflow:hidden;width:43%;}
    .main-green div a,.main-green div p{float:left;display:block;}
    .main-green div p{font-size:23px;color:#ffffff;line-height:50px;margin-left:12px;}
    .main-green div p span{font-size:40px;}
    .main-green div p.t1{float:right;}
    </style>
    <?php
}
?>
<section id="main">
    <div class="main-green">
        <p class="scan-win-img"><img src="<?php echo STATICURL; ?>/ximg/activity/scan-win.jpg"></p>
        <?php
        if($customer_id)
        {
            ?>
            <div>
                <p style="font-size:32px;line-height:50px;">CODE:<span style="color:#e0202d;">SCAN$5</span> <span style="font-size:16px;">(Expires in 30 days)</span></p>
                <p>It has been added to the Code List of your Choies account. </p>
                <p>Simply choose it when you place an order.</p>
                <a href="<?php echo BASEURL ;?>/top-sellers"><img src="<?php echo STATICURL; ?>/ximg/activity/scan-btn2.jpg" /></a>
            </div>
            <?php
        }
        else
        {
            ?>
            <div>
                <a href="#" class="JS_popwinbtn1"><img src="<?php echo STATICURL; ?>/ximg/activity/scan-btn.jpg"></a>
                <p>to Get the <span>$5 CODE</span> <br></p>
                <p class="t1">to Your Account&gt;&gt;</p>
            </div>
            <?php
        }
        ?>
    </div>
</section>

<!-- JS_popwincon1 -->
<div class="JS_popwincon1 popwincon w_signup hide">
    <a class="JS_close2 close_btn2"></a>
    <div class="fix" id="sign_in_up">
        <div class="left" style="width:auto;margin-right:30px;padding-right:30px;">
            <h3>CHOIES Member Sign In</h3>
            <form action="/customer/login?redirect=/activity/quick_response_code" method="post" class="signin_form sign_form form">
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
                        $page = BASEURL . URL::current(0);
                        $facebook = new facebook();
                        $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                        ?>
                        <a href="<?php echo $loginUrl; ?>" class="facebook-btn">Sign in with Facebook</a>
                    </li>
                </ul>
            </form>
        </div>
        <div class="right">
            <h3>CHOIES Member Sign Up</h3>
            <form action="/customer/register?redirect=/activity/quick_response_code" method="post" class="signup_form sign_form form">
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