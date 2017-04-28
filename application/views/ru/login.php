<section id="main">
    <div class="w_signup layout">
        <?php echo Message::get(); ?>
        <div class="fix signpage">
            <p class="signin_top">Зарегистрировайтесь на сайте и получите купон на скидку <span class="f00">15%</span>.Пожалуйста, заполните свой профиль,чтобы получить  <span class="f00"><?php echo Site::instance()->price(15, 'code_view'); ?></span> points после оформления первого заказа.</p>
            <div class="left">
                <h3>Вход на сайте CHOIES</h3>
                <form action="<?php echo LANGPATH; ?>/customer/login/<?php if (!empty($_GET['redirect'])) echo '?redirect=' . htmlspecialchars($_GET['redirect']); ?>" method="post" class="signin_form sign_form form">
                    <input type="hidden" name="referer" value="<?php echo $referer; ?>" />
                    <ul>
                        <li>
                            <label>Электронная почта: </label>
                            <input type="text" value="" name="email" class="text" />
                        </li>
                        <li>
                            <label>Пароль: </label>
                            <input type="password" value="" name="password" class="text" maxlength="16" />
                        </li>
                        <li><input type="submit" value="Войти" name="submit" class="btn btn40" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">Вспомнить пароль?</a></li>
                        <li>
                            <?php
                            $redirect = Arr::get($_GET, 'redirect', '');
                            $page = isset($_SERVER['HTTP_SELF']) ? 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_SELF'] . '/' . htmlspecialchars($redirect) : 'http://' . $_SERVER['HTTP_HOST'] . '/' . htmlspecialchars($redirect);
                            $facebook = new facebook();
                            $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                            ?>
                            <a href="<?php echo $loginUrl; ?>" class="facebook_btn">Войти по Фейсбук</a>
                        </li>
                    </ul>
                </form>
            </div>
            <div class="right">
                <h3>Регистрация CHOIES</h3>
                <form action="<?php echo LANGPATH; ?>/customer/register/<?php if (!empty($_GET['redirect'])) echo '?redirect=' . htmlspecialchars($_GET['redirect']); ?>" method="post" class="signup_form sign_form form">
                    <input type="hidden" name="referer" value="<?php echo $referer; ?>" />
                    <ul>
                        <li>
                            <label>Электронная почта: </label>
                            <input type="text" value="" name="email" id="email" class="text" />
                        </li>
                        <li>
                            <label>Пароль: </label>
                            <input type="password" value="" name="password" class="text" id="password" maxlength="20" />
                        </li>
                        <li>
                            <label>Повторите пароль: </label>
                            <input type="password" value="" name="password_confirm" class="text" maxlength="20" />
                        </li>
                        <li><input type="submit" value="Регистрация" name="submit" class="btn btn40" /></li>
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
                                if (!window.confirm('Sind Sie sicher, dass Ihre E-Mail-Adresse mit ' + result + ' beendet?'))
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
                        required:"Введите адрес вашей электронной почты,пожалуйста.",
                        email:"Введите действительный адрес электронной почты,пожалуйста."
                    },
                    password: {
                        required: "Заполните это поле.",
                        minlength: "Пароль слишком короткий, не менее 5 символов.",
                        maxlength: "Пароль превышает максимальную длину:20 символов."
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
                        required:"Введите адрес вашей электронной почты,пожалуйста.",
                        email:"Введите действительный адрес электронной почты,пожалуйста."
                    },
                    password: {
                        required: "Заполните это поле.",
                        minlength: "Пароль слишком короткий, не менее 5 символов.",
                        maxlength:"Пароль превышает максимальную длину:20 символов."
                    },
                    password_confirm: {
                        required: "Заполните это поле.",
                        minlength: "Пароль слишком короткий, не менее 5 символов.",
                        maxlength:"Пароль превышает максимальную длину:20 символов.",
                        equalTo: "Пожалуйста, введите тот же пароль, что и выше."
                    }
                }
            });
        </script>
    </div>
</section>