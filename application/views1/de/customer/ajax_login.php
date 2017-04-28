<div class="w-signup" id="sign_in_up">
    <div class="left col-sm-6 col-xs-12" style="width:388px;margin-right: 0px;padding-right:30px;">
        <h3>CHOIES Mitglied Anmelden</h3>
        <div id="customer_pid" style="display:none;"></div>
        <form action="<?php echo LANGPATH; ?>/customer/login<?php if(isset($redirect)) echo '?redirect=' . $redirect; ?>" method="post" class="signin-form sign-form form" id="form_login">
            <ul>
                <li>
                    <label>Email Adresse: </label>
                    <input type="text" value="" name="email" class="text" id="email1" />
                </li>
                <li>
                    <label>Passwort: </label>
                    <input type="password" value="" name="password" class="text" maxlength="16" id="password1" />
                </li>
                <li>
                    <input type="checkbox" name="remember_me" id="remember_me1" checked="checked">
                    <label for="remember_me1" style="color:#999;">Angemeldet bleiben</label>
                </li>
                <li><input type="submit" value="ANMELDEN" name="submit" class="btn btn-primary btn-lg mr10" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">Passwort vergessen?</a></li>
                <li>
                    <?php
                    $page = 'http://' . $_SERVER['COFREE_DOMAIN'] . URL::current(0);
                    $facebook = new facebook();
                    $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                    ?>
                    <a href="<?php echo $loginUrl; ?>" onclick="return addck();" class="facebook-btn">Mit Facebook Anmelden</a>
                </li>
            </ul>
        </form>
    </div>
    <div class="right col-sm-6 col-xs-12">
        <h3>CHOIES Mitglied Registrieren</h3>
        <form action="<?php echo LANGPATH; ?>/customer/register<?php if(isset($redirect)) echo '?redirect=' . $redirect; ?>" method="post" class="signup-form sign-form form" id="form_register">
            <ul>
                <li>
                    <label>Email Adresse: </label>
                    <input type="text" value="" name="email" class="text" id="email2" />
                </li>
                <li>
                    <label>Passwort: </label>
                    <input type="password" value="" name="password" class="text" id="password2" maxlength="16" />
                </li>
                <li>
                    <label>Passwort Bestätigen: </label>
                    <input type="password" value="" name="password_confirm" id="password_confirm" class="text" maxlength="16" />
                </li>
                <li>
                    <input type="checkbox" name="remember_me" id="remember_me2" checked="checked">
                    <label for="remember_me2" style="color:#999;">Angemeldet bleiben</label>
                </li>
                <li><input type="submit" value="REGISTRIEREN" name="submit" class="btn btn-primary btn-lg mr10" /></li>
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

    //check email exists
    $("#email1, #email2").change(function(){
        var email = $(this).val();
        var has = email.indexOf('@');
        if(has != -1)
        {
            $.post(
                '<?php echo LANGPATH; ?>/customer/email_exists',
                {
                    email: email
                },
                function(result)
                {
                    if(result != 1)
                    {
                        if (!window.confirm('Sind Sie sicher, dass Ihre E-Mail Adresse auf ' + result + ' endet?'))
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
                required:"Bitte geben Sie eine E-Mail ein.",
                email:"Bitte geben Sie eine gültige E-Mail Adresse ein."
            },
            password: {
                required: "Bitte geben Sie ein Passwort ein.",
                minlength: "Ihr Passwort muss mindestens 5 Zeichen lang ein."
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