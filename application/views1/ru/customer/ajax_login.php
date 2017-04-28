<div class="w-signup" id="sign_in_up">
    <div class="left col-sm-6 col-xs-12">
        <h3>Вход на сайте CHOIES</h3>
        <div id="customer_pid" style="display:none;"></div>
        <form action="<?php echo LANGPATH; ?>/customer/login<?php if(isset($redirect)) echo '?redirect=' . $redirect; ?>" method="post" class="signin-form sign-form form" id="form_login">
            <ul>
                <li>
                    <label>Электронная почта: </label>
                    <input type="text" value="" name="email" class="text" id="email1" />
                </li>
                <li>
                    <label>Пароль: </label>
                    <input type="password" value="" name="password" class="text" maxlength="16" id="password1" />
                </li>
                <li>
                    <input type="checkbox" name="remember_me" id="remember_me1" checked="checked">
                    <label for="remember_me1" style="color:#999;">Оставаться в системе</label>
                </li>
                <li><input type="submit" value="Войти" name="submit" class="btn btn-primary btn-lg mr10" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">Вспомнить пароль?</a></li>
                <li>
                    <?php
                    $page = BASEURL . URL::current(0);
                    $facebook = new facebook();
                    $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                    ?>
                    <a href="<?php echo $loginUrl; ?>" class="facebook-btn">Войти по Фейсбук</a>
                </li>
            </ul>
        </form>
    </div>
    <div class="right col-sm-6 col-xs-12">
        <h3>Регистрация CHOIES</h3>
        <form action="<?php echo LANGPATH; ?>/customer/register<?php if(isset($redirect)) echo '?redirect=' . $redirect; ?>" method="post" class="signup-form sign-form form" id="form_register">
            <ul>
                <li>
                    <label>Электронная почта: </label>
                    <input type="text" value="" name="email" class="text" id="email2" />
                </li>
                <li>
                    <label>Пароль: </label>
                    <input type="password" value="" name="password" class="text" id="password2" maxlength="16" />
                </li>
                <li>
                    <label>Повторите пароль:</label>
                    <input type="password" value="" name="password_confirm" id="password_confirm" class="text" maxlength="16" />
                </li>
                <li>
                    <input type="checkbox" name="remember_me" id="remember_me2" checked="checked">
                    <label for="remember_me2" style="color:#999;">Оставаться в системе</label>
                </li>
                <li><input type="submit" value="Регистрация" name="submit" class="btn btn-primary btn-lg mr10" /></li>
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
                    required:"Введите адрес вашей электронной почты,пожалуйста.",
                    email:"Введите действительный адрес электронной почты,пожалуйста."
                },
            password: {
                required: "Заполните это поле.",
                minlength: "Пароль слишком короткий, не менее 5 символов."
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
                required:"Введите адрес вашей электронной почты,пожалуйста.",
                email:"Введите действительный адрес электронной почты,пожалуйста."
            },
            password: {
                required: "Заполните это поле.",
                minlength: "Пароль слишком короткий, не менее 5 символов."
            },
            password_confirm: {
                required: "Заполните это поле.",
                minlength: "Пароль слишком короткий, не менее 5 символов.",
                equalTo: "Пожалуйста, введите тот же пароль, что и выше."
            }
        }
    });
</script>