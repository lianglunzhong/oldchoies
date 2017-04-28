<section id="main">
    <div class="w_signup layout">
        <?php echo Message::get(); ?>
        <div class="fix signpage">
            <p class="signin_top">Enregistrer pour bénéficier d'un bon de réduction de <span class="f00">15%</span> & Compléter le profil pour obtenir les autres points de <span class="f00"><?php echo Site::instance()->price(15, 'code_view'); ?></span> .</p>
            <div class="left">
                <h3>Déjà client CHOIES</h3>
                <form action="<?php echo LANGPATH; ?>/customer/login/<?php if (!empty($_GET['redirect'])) echo '?redirect=' . htmlspecialchars($_GET['redirect']); ?>" method="post" class="signin_form sign_form form">
                    <input type="hidden" name="referer" value="<?php echo $referer; ?>" />
                    <ul>
                        <li>
                            <label>Adresse e-mail: </label>
                            <input type="text" value="" name="email" class="text" />
                        </li>
                        <li>
                            <label>Mot de passe: </label>
                            <input type="password" value="" name="password" class="text" maxlength="16" />
                        </li>
                        <li><input type="submit" value="SE CONNECTER" name="submit" class="btn btn40" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">Mot de passe oublié?</a></li>
                        <li>
                            <?php
                            $redirect = Arr::get($_GET, 'redirect', '');
                            $page = isset($_SERVER['HTTP_SELF']) ? 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_SELF'] . '/' . htmlspecialchars($redirect) : 'http://' . $_SERVER['HTTP_HOST'] . '/' . htmlspecialchars($redirect);
                            $facebook = new facebook();
                            $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                            ?>
                            <a href="<?php echo $loginUrl; ?>" class="facebook_btn">Connexion avec Facebook</a>
                        </li>
                    </ul>
                </form>
            </div>
            <div class="right">
                <h3>Nouveau client CHOIES</h3>
                <form action="<?php echo LANGPATH; ?>/customer/register/<?php if (!empty($_GET['redirect'])) echo '?redirect=' . htmlspecialchars($_GET['redirect']); ?>" method="post" class="signup_form sign_form form">
                    <input type="hidden" name="referer" value="<?php echo $referer; ?>" />
                    <ul>
                        <li>
                            <label>Adresse e-mail: </label>
                            <input type="text" value="" name="email" id="email" class="text" />
                        </li>
                        <li>
                            <label>Mot de passe: </label>
                            <input type="password" value="" name="password" class="text" id="password" maxlength="20" />
                        </li>
                        <li>
                            <label>Confirmer le mot de passe: </label>
                            <input type="password" value="" name="password_confirm" class="text" maxlength="20" />
                        </li>
                        <li><input type="submit" value="VALIDER" name="submit" class="btn btn40" /></li>
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
                                if (!window.confirm('Désolé, il existe déjà un compte sous cette adresse e-mail, veuillez en utiliser une autre.'))
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
                        required:"Veuillez saisir une adresse é-mail.",
                        email:"Veuillez saisir une adresse e-mail valide."
                    },
                    password: {
                        required: "Veuillez saisir un mot de passe.",
                        minlength: "Veuillez saisir au moins 5 caractères.",
                        maxlength: "Votre mot de passe ne peut pas dépasser 20 caractères."
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
                        required:"Veuillez saisir une adresse é-mail.",
                        email:"Veuillez saisir une adresse e-mail valide."
                    },
                    password: {
                        required: "Veuillez saisir un mot de passe.",
                        minlength:"Veuillez saisir au moins 5 caractères.",
                        maxlength:"Votre mot de passe ne peut pas dépasser 20 caractères."
                    },
                    password_confirm: {
                        required: "Veuillez saisir un mot de passe.",
                        minlength:"Veuillez saisir au moins 5 caractères.",
                        maxlength:"Votre mot de passe ne peut pas dépasser 20 caractères.",
                        equalTo:  "Veuillez entrer le mot de passe même comme ci-dessus."
                    }
                }
            });
        </script>
    </div>
</section>