<div class="site-content">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs row">
            <div class="col-xs-12">
                <a href="<?php echo LANGPATH; ?>/">Homepage</a>  >  Reset Password
            </div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <!-- main-middle begin -->
    <div class="container">
        <div class="row">
            <aside id="aside" class="col-sm-3 hidden-xs"></aside>
            <article class="user col-sm-9 col-xs-12">
                <div class="tit">
                    <h2>Passwort Zurücksetzen</h2>
                </div>
                <form action="<?php echo URL::current(); ?>" method="post" class="forgot-psd-form col-xs-12">
                    <p>Für die Sicherheit Ihres Kontos, empfehlen wir Ihnen, ein Passwort andere als Namen, Geburtstage oder Straßenadressen, die mit Ihnen verbunden sind, zu wählen.</p>
                    <ul>
                        <li>
                            <label class="col-sm-2 col-xs-12">
                                <span>*</span> NEU Passwort:
                            </label>
                            <div>
                                <input class="text col-xs-12" type="password" id="password" name="password" value="">
                            </div>
                        </li>
                        <li>
                            <label class="col-sm-2 col-xs-12">
                                <span>*</span> Passwort Bestätigen:
                            </label>
                            <div>
                                <input class="text col-xs-12" type="password" name="confirmpassword" value="">
                            </div>
                        </li>
                        <li>
                            <label class="hidden-xs col-sm-2"> </label>
                            <div>
                                <input class="btn btn-primary btn-lg" type="submit" value="Reset Password">
                            </div>
                        </li>
                    </ul>
                </form>
            </article>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(".forgot-psd-form").validate({
        rules: {
            password: {
                required: true,
                minlength: 5,
                maxlength:20
            },
            confirmpassword: {
                required: true,
                minlength: 5,
                maxlength:20,
                equalTo: "#password"
            },
        },
        messages: {
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