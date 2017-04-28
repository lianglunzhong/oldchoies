<?php
if(empty(LANGUAGE))
{
    $lists = Kohana::config('/customer/login.en');
}
else
{
    $lists = Kohana::config('/customer/login.'.LANGUAGE);
}
if(isset($_GET['redirect']) AND $_GET['redirect'] == '/cart/checkout')
{
?>
<!-- <script src="//cdn.optimizely.com/js/557241246.js"></script> -->
<?php
}
?>
<div class="site-content">
    <div class="w-signup container">
        <?php echo Message::get(); ?>
        <div class="signpage">
            <p class="signin-top">
               <?php echo $lists['title1'];?>
            </p>
        </div>
        <div class="row">
            <div class="left col-sm-6 col-xs-12">
                <h3><?php echo $lists['title2'];?></h3>
                <form class="signin-form sign-form form" method="post" action="<?php echo LANGPATH;?>/customer/login/<?php if (!empty($_GET['redirect'])) echo '?redirect=' . htmlspecialchars($_GET['redirect']); ?>">
                    <input type="hidden" value="<?php echo $referer; ?>" name="referer">
                    <?php
                    if(isset($_GET['data']))
                    {
                        ?>
                        <input type="hidden" name="data" value="<?php echo $_GET['data']; ?>" />
                        <?php
                    }
                    ?>
                    <ul class="method">
                        <li>
                            <div>
                                <label><?php echo $lists['Email address'];?></label>
                            </div>
                            <input id="sign-in-email" class="text" type="text" name="email" value="">
                        </li>
                        <li>
                            <div>
                                <label><?php echo $lists['Password'];?></label>
                            </div>
                            <input class="text" type="password" maxlength="16" name="password" value="">
                        </li>
                        <li class="insurance JS-show">
                            <input type="checkbox" name="remember_me" id="remember_me1" checked="checked">
                            <label for="remember_me1" style="color:#999;"><?php echo $lists['Remember me'];?></label>
							<div style="display: none;top:50%;" class="ins-info JS-showcon hidden-xs hidden-sm hidden-md">
                                        <b class="arrow-up"></b>
                                        <div class="ins-tipscon" style="margin-top:1px;padding:2px 5px;"><?php echo $lists['Tick to keep login for 14 days'];?></div>
                            </div>
                        </li>
                        <li>
                            <input class="btn btn-primary btn-lg mr10" type="submit" name="submit" value="<?php echo $lists['Sign In'];?>">
                            <a class="text-underline" href="<?php echo LANGPATH; ?>/customer/forgot_password"><?php echo $lists['Forgot password'];?></a>
                        </li>
                        <li>
                            <?php
                            $redirect = Arr::get($_GET, 'redirect', '');
                            $page = isset($_SERVER['HTTP_SELF']) ? BASEURL . $_SERVER['HTTP_SELF'] . '/' . htmlspecialchars($redirect) : BASEURL . '/' . htmlspecialchars($redirect);
                            $facebook = new facebook();
                            $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                            ?>
                            <a href="<?php echo $loginUrl; ?>" onclick="return addck();"  class="facebook-btn"><?php echo $lists['Sign in with Facebook'];?></a>
                        </li>
                    </ul>
                </form>
            </div>
            <div class="right col-sm-6 col-xs-12">
                <h3><?php echo $lists['CHOIES Member Sign Up'];?></h3>
                <form class="signup-form sign-form form" method="post" action="/customer/register/<?php if (!empty($_GET['redirect'])) echo '?redirect=' . htmlspecialchars($_GET['redirect']); ?>">
                    <input type="hidden" value="<?php echo $referer; ?>" name="referer">
                    <?php
                    if(isset($_GET['data']))
                    {
                        ?>
                        <input type="hidden" name="data" value="<?php echo $_GET['data']; ?>" />
                        <?php
                    }
                    ?>
                    <ul class="method">
                        <li>
                            <div>
                                <label><?php echo $lists['Email address'];?></label>
                            </div>
                            <input id="email" class="text" type="text" name="email" value="">
                        </li>
                        <li>
                            <div>
                                <label><?php echo $lists['Password'];?></label>
                            </div>
                            <input id="password" class="text" type="password" maxlength="16" name="password" value="">
                        </li>
                        <li>
                            <div>
                                <label><?php echo $lists['Confirm Password'];?></label>
                            </div>
                            <input class="text" type="password" maxlength="16" name="password_confirm" value="">
                        </li>
                        <li class="insurance JS-show">
                            <input type="checkbox" name="remember_me" id="remember_me2" checked="checked">
                            <label for="remember_me2" style="color:#999;"><?php echo $lists['Remember me'];?></label>
							<div style="display: none;top:74%;" class="ins-info JS-showcon hidden-xs hidden-sm hidden-md">
                                        <b class="arrow-up"></b>
                                        <div class="ins-tipscon" kai="13" style="margin-top:1px;padding:2px 5px;"><?php echo $lists['Tick to keep login for 14 days'];?></div>
                            </div>
                        </li>
                        <li>
                            <input class="btn btn-primary btn-lg mr10" type="submit" name="submit" value="<?php echo $lists['Sign Up'];?>" onclick="return loading();">
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function addck()
{
         $.ajax({
            type: "POST",
            url: '/ajax/ajax_addck',
            dataType: "json",
            success: function(msg){
            }
        });
}

function loading()
{
    ga('send', 'event', 'Button_click', 'click', 'Sign Up');
}
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

<!-- Facebook Conversion Code for Registrations - YeahMobi -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6035664465245', {'value':'0.00','currency':'USD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6035664465245&cd[value]=0.00&cd[currency]=USD&noscript=1" /></noscript>