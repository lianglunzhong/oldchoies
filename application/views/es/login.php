<section id="main">
    <div class="w_signup layout">
        <?php echo Message::get(); ?>
        <div class="fix signpage">
            <p class="signin_top">Registrarte para obtener el cupón de <span class="f00">15%</span> descuento y complete el perfil para obtener otros <span class="f00"><?php echo Site::instance()->price(15, 'code_view'); ?></span> puntos al realizar el primero pedido.</p>
            <div class="left">
                <h3>Acceso para socios</h3>
                <form action="<?php echo LANGPATH; ?>/customer/login/<?php if (!empty($_GET['redirect'])) echo '?redirect=' . htmlspecialchars($_GET['redirect']); ?>" method="post" class="signin_form sign_form form">
                    <input type="hidden" name="referer" value="<?php echo $referer; ?>" />
                    <ul>
                        <li>
                            <label>Email: </label>
                            <input type="text" value="" name="email" class="text" />
                        </li>
                        <li>
                            <label>Contraseña: </label>
                            <input type="password" value="" name="password" class="text" maxlength="16" />
                        </li>
                        <li><input type="submit" value="ACCEDER" name="submit" class="btn40_16_red mr10" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">¿Olvidaste tu contraseña?</a></li>
                        <li>
                            <?php
                            $redirect = Arr::get($_GET, 'redirect', '');
                            $page = isset($_SERVER['HTTP_SELF']) ? 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_SELF'] . '/' . htmlspecialchars($redirect) : 'http://' . $_SERVER['HTTP_HOST'] . '/' . htmlspecialchars($redirect);
                            $facebook = new facebook();
                            $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                            ?>
                            <a href="<?php echo $loginUrl; ?>" class="facebook_btn">Acceder con Facebook</a>
                        </li>
                    </ul>
                </form>
            </div>
            <div class="right">
                <h3>Únete a Choies</h3>
                <form action="<?php echo LANGPATH; ?>/customer/register/<?php if (!empty($_GET['redirect'])) echo '?redirect=' . htmlspecialchars($_GET['redirect']); ?>" method="post" class="signup_form sign_form form">
                    <input type="hidden" name="referer" value="<?php echo $referer; ?>" />
                    <ul>
                        <li>
                            <label>Email: </label>
                            <input type="text" value="" name="email" class="text" />
                        </li>
                        <li>
                            <label>Contraseña: </label>
                            <input type="password" value="" name="password" class="text" id="password" maxlength="20" />
                        </li>
                        <li>
                            <label>Confirmar Contraseña: </label>
                            <input type="password" value="" name="password_confirm" class="text" maxlength="20" />
                        </li>
                        <li><input type="submit" value="REGISTRARTE" name="submit" class="btn40_16_red mr10" /></li>
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
                        required:"Por favor, proporcione un email.",
                        email:"Por favor, introduce una dirección de email válida."
                    },
                    password: {
                        required: "Por favor, ingrese su contraseña.",
                        minlength: "Su contraseña debe tener al menos 5 caracteres."
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
                        required:"Por favor, proporcione un email.",
                        email:"Por favor, introduce una dirección de email válida."
                    },
                    password: {
                        required: "Por favor, ingrese su contraseña.",
                        minlength: "Su contraseña debe tener al menos 5 caracteres."
                    },
                    password_confirm: {
                        required: "Por favor, ingrese su contraseña.",
                        minlength: "Su contraseña debe tener al menos 5 caracteres.",
                        equalTo: "Por favor, ingrese una contraseña la misma que arriba."
                    }
                }
            });
        </script>
    </div>
</section>