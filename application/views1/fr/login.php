<?php
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
                S'inscrire pour obtenir <span>15%</span> code de coupon et un cadeau de bienvenue.
            </p>
        </div>
        <div class="row">
            <div class="left col-sm-6 col-xs-12">
                <h3>Déjà client CHOIES</h3>
                <form class="signin-form sign-form form" method="post" action="<?php echo LANGPATH; ?>/customer/login/<?php if (!empty($_GET['redirect'])) echo '?redirect=' . htmlspecialchars($_GET['redirect']); ?>">
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
                                <label>Adresse e-mail: </label>
                            </div>
                            <input id="sign-in-email" class="text" type="text" name="email" value="">
                        </li>
                        <li>
                            <div>
                                <label>Mot de passe: </label>
                            </div>
                            <input class="text" type="password" maxlength="16" name="password" value="">
                        </li>
                        <li class="insurance JS-show">
                            <input type="checkbox" name="remember_me" id="remember_me1" checked="checked">
                            <label for="remember_me1" style="color:#999;">Rester connecté</label>
                            <div style="display: none;top:50%;" class="ins-info JS-showcon hidden-xs hidden-sm hidden-md">
                                        <b class="arrow-up"></b>
                                        <div class="ins-tipscon" style="margin-top:1px;padding:2px 5px;">Cochez pour garder connexion pendant 14 jours.</div>
                            </div>
                        </li>
                        <li>
                            <input class="btn btn-primary btn-lg mr10" type="submit" name="submit" value="SE CONNECTER">
                            <a class="text-underline" href="<?php echo LANGPATH; ?>/customer/forgot_password">Mot de passe oublié?</a>
                        </li>
                        <li>
                            <?php
                            $redirect = Arr::get($_GET, 'redirect', '');
                            $page = isset($_SERVER['HTTP_SELF']) ? 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_SELF'] .'/' . htmlspecialchars($redirect) : 'http://' . $_SERVER['HTTP_HOST'] . '/' . htmlspecialchars($redirect);
                            $facebook = new facebook();
                            $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                            ?>
                            <a href="<?php echo $loginUrl; ?>" onclick="return addck();" class="facebook-btn">Connexion avec Facebook</a>
                        </li>
                    </ul>
                </form>
            </div>
            <div class="right col-sm-6 col-xs-12">
                <h3>Nouveau client CHOIES</h3>
                <form class="signup-form sign-form form" method="post" action="<?php echo LANGPATH; ?>/customer/register/<?php if (!empty($_GET['redirect'])) echo '?redirect=' . htmlspecialchars($_GET['redirect']); ?>">
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
                                <label>Adresse e-mail: </label>
                            </div>
                            <input id="email" class="text" type="text" name="email" value="">
                        </li>
                        <li>
                            <div>
                                <label>Mot de passe: </label>
                            </div>
                            <input id="password" class="text" type="password" maxlength="16" name="password" value="">
                        </li>
                        <li>
                            <div>
                                <label>Confirmer le mot de passe:</label>
                            </div>
                            <input class="text" type="password" maxlength="16" name="password_confirm" value="">
                        </li>
                        <li class="insurance JS-show">
                            <input type="checkbox" name="remember_me" id="remember_me2" checked="checked">
                            <label for="remember_me2" style="color:#999;">Rester connecté</label>
                            <div style="display: none;top:74%;" class="ins-info JS-showcon hidden-xs hidden-sm hidden-md">
                                        <b class="arrow-up"></b>
                                        <div class="ins-tipscon" style="margin-top:1px;padding:2px 5px;">Cochez pour garder connexion pendant 14 jours.</div>
                            </div>
                        </li>
                        <li>
                            <input class="btn btn-primary btn-lg mr10" type="submit" name="submit" value="S'INSCRIRE">
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
                required:"Veuillez saisir une adresse e-mail.",
                email:"Veuillez saisir une adresse e-mail valide."
            },
            password: {
                required: "Veuillez saisir un mot de passe.",
                minlength: "Veuillez saisir au moins 5 caractères.",
                maxlength: "Votre mot de passe ne peut pas dépasser 20 caractères."
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