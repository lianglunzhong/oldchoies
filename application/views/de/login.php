<section id="main">
    <div class="w_signup layout">
        <?php echo Message::get(); ?>
        <div class="fix signpage">
            <p class="signin_top">Registrieren Sie sich, um <span class="f00">15%</span> steigen Gutschein zu erhalten. &amp; Vervollständigen Sie Ihr Profil und machen Sie die erste Bestellung, um andere <span class="f00"><?php echo Site::instance()->price(15, 'code_view'); ?></span> Punkte zu bekommen.</p>
            <div class="left">
                <h3>CHOIES Mitglied Anmelden</h3>
                <form action="<?php echo LANGPATH; ?>/customer/login/<?php if (!empty($_GET['redirect'])) echo '?redirect=' . htmlspecialchars($_GET['redirect']); ?>" method="post" class="signin_form sign_form form">
                    <input type="hidden" name="referer" value="<?php echo $referer; ?>" />
                    <ul>
                        <li>
                            <label>Email Adresse: </label>
                            <input type="text" value="" name="email" class="text" />
                        </li>
                        <li>
                            <label>Passwort: </label>
                            <input type="password" value="" name="password" class="text" maxlength="16" />
                        </li>
                        <li><input type="submit" value="ANMELDEN" name="submit" class="btn btn40" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">Passwort vergessen?</a></li>
                        <li>
                            <?php
                            $redirect = Arr::get($_GET, 'redirect', '');
                            $page = isset($_SERVER['HTTP_SELF']) ? 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_SELF'] . '/' . htmlspecialchars($redirect) : 'http://' . $_SERVER['HTTP_HOST'] . '/' . htmlspecialchars($redirect);
                            $facebook = new facebook();
                            $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                            ?>
                            <a href="<?php echo $loginUrl; ?>" class="facebook_btn">Mit Facebook Verbinden</a>
                        </li>
                    </ul>
                </form>
            </div>
            <div class="right">
                <h3>CHOIES Mitglied Registrieren</h3>
                <form action="<?php echo LANGPATH; ?>/customer/register/<?php if (!empty($_GET['redirect'])) echo '?redirect=' . htmlspecialchars($_GET['redirect']); ?>" method="post" class="signup_form sign_form form">
                    <input type="hidden" name="referer" value="<?php echo $referer; ?>" />
                    <ul>
                        <li>
                            <label>Email Adresse: </label>
                            <input type="text" value="" name="email" id="email" class="text" />
                        </li>
                        <li>
                            <label>Passwort: </label>
                            <input type="password" value="" name="password" class="text" id="password" maxlength="20" />
                        </li>
                        <li>
                            <label>Passwort Bestätigen: </label>
                            <input type="password" value="" name="password_confirm" class="text" maxlength="20" />
                        </li>
                        <li><input type="submit" value="REGISTRIEREN" name="submit" class="btn btn40" /></li>
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
                        required:"Bitte geben Sie eine E-Mail ein.",
                        email:"Bitte geben Sie eine gültige E-Mail Adresse ein."
                    },
                    password: {
                        required: "Bitte geben Sie ein Passwort ein.",
                        minlength: "Ihr Passwort muss mindestens 5 Zeichen lang sein.",
                        maxlength: "Das Passwort überschreitet eine maximale Länge von 20 Zeichen."
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
                        required:"Bitte geben Sie eine E-Mail ein.",
                        email:"Bitte geben Sie eine gültige E-Mail Adresse ein."
                    },
                    password: {
                        required: "Bitte geben Sie ein Passwort ein.",
                        minlength: "Ihr Passwort muss mindestens 5 Zeichen lang sein.",
                        maxlength:"Das Passwort überschreitet eine maximale Länge von 20 Zeichen."
                    },
                    password_confirm: {
                        required: "Bitte geben Sie ein Passwort ein.",
                        minlength: "Ihr Passwort muss mindestens 5 Zeichen lang sein.",
                        maxlength:"Das Passwort überschreitet eine maximale Länge von 20 Zeichen.",
                        equalTo: "Bitte geben Sie das gleiche Passwort wie oben ein."
                    }
                }
            });
        </script>
    </div>
</section>
