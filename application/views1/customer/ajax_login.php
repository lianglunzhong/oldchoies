<div class="w-signup" id="sign_in_up">
    <div class="left col-sm-6 col-xs-12" style="width:438px;padding:0 80px;">
        <h3>CHOIES Member Sign In</h3>
        <div id="customer_pid" style="display:none;"></div>
        <form action="/customer/login<?php if(isset($redirect)) echo '?redirect=' . $redirect; ?>" method="post" class="signin-form sign-form form" id="form_login">
            <ul>
                <li>
                    <label>Email address: </label>
                    <input type="text" value="" name="email" class="text" id="email1" />
                </li>
                <li>
                    <label>Password: </label>
                    <input type="password" value="" name="password" class="text" maxlength="16" id="password1" />
                </li>
                <li>
                    <input type="checkbox" name="remember_me" id="remember_me1" checked="checked">
                    <label for="remember_me1" style="color:#999;">Remember me</label>
                </li>
                <li><input type="submit" value="Sign In" name="submit" class="btn btn-primary btn-lg mr10" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">Forgot password?</a></li>
                <li>
                    <?php
                    $page = BASEURL . URL::current(0);
                    $facebook = new facebook();
                    $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                    ?>
                    <a href="<?php echo $loginUrl; ?>" onclick="return addck();" class="facebook-btn">Sign in with Facebook</a>
                </li>
            </ul>
        </form>
    </div>
    <div class="right col-sm-6 col-xs-12" style="width:438px;padding:0 80px;">
        <h3>CHOIES Member Sign Up</h3>
        <form action="/customer/register<?php if(isset($redirect)) echo '?redirect=' . $redirect; ?>" method="post" class="signup-form sign-form form" id="form_register">
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
                <li>
                    <input type="checkbox" name="remember_me" id="remember_me2" checked="checked">
                    <label for="remember_me2" style="color:#999;">Remember me</label>
                </li>
                <li><input type="submit" value="Sign Up" name="submit" class="btn btn-primary btn-lg mr10" onclick="return loading();" /></li>
            </ul>
        </form>
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
    $("#email1, #email2").change(function(){
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