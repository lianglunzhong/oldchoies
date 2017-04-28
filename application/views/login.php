<?php
if(isset($_GET['redirect']) AND $_GET['redirect'] == '/cart/checkout')
{
?>
<!-- <script src="//cdn.optimizely.com/js/557241246.js"></script> -->
<?php
}
?>
<section id="main">
    <div class="w_signup layout">
        <?php echo Message::get(); ?>
        <div class="fix signpage">
            <p class="signin_top">Register to get <span class="f00">15%</span> off coupon &amp; Complete profile to place first order to get another <span class="f00">$15</span> points.</p>
            <div class="left">
                <h3>CHOIES Member Sign In</h3>
                <form action="/customer/login/<?php if (!empty($_GET['redirect'])) echo '?redirect=' . htmlspecialchars($_GET['redirect']); ?>" method="post" class="signin_form sign_form form">
                    <input type="hidden" name="referer" value="<?php echo $referer; ?>" />
                    <?php
                    if(isset($_GET['data']))
                    {
                        ?>
                        <input type="hidden" name="data" value="<?php echo $_GET['data']; ?>" />
                        <?php
                    }
                    ?>
                    <ul>
                        <li>
                            <label>Email address: </label>
                            <input type="text" value="" name="email" class="text" />
                        </li>
                        <li>
                            <label>Password: </label>
                            <input type="password" value="" name="password" class="text" maxlength="16" />
                        </li>
                        <li><input type="submit" value="Sign In" name="submit" class="btn40_16_red mr10" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">Forgot password?</a></li>
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
                <form action="/customer/register/<?php if (!empty($_GET['redirect'])) echo '?redirect=' . htmlspecialchars($_GET['redirect']); ?>" method="post" class="signup_form sign_form form">
                    <input type="hidden" name="referer" value="<?php echo $referer; ?>" />
                    <?php
                    if(isset($_GET['data']))
                    {
                        ?>
                        <input type="hidden" name="data" value="<?php echo $_GET['data']; ?>" />
                        <?php
                    }
                    ?>
                    <ul>
                        <li>
                            <label>Email address: </label>
                            <input type="text" value="" name="email" id="email" class="text" />
                        </li>
                        <li>
                            <label>Password: </label>
                            <input type="password" value="" name="password" class="text" id="password" maxlength="16" />
                        </li>
                        <li>
                            <label>Confirm Password: </label>
                            <input type="password" value="" name="password_confirm" class="text" maxlength="16" />
                        </li>
                        <li><input type="submit" value="Sign Up" name="submit" class="btn40_16_red mr10" /></li>
                    </ul>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            //check email exists
            $("#email").change(function(){
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
                                if (!window.confirm('Are you sure that your email address is ended with ' + result + '?'))
                                {
                                    $("#email").focus().select();
                                }
                            }
                        },
                        'json'
                    );
                }
                
            })
            
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
</section>