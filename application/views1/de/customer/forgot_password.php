<div class="site-content">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs row">
            <div class="col-xs-12">
                <a href="<?php echo LANGPATH; ?>/">Homepage</a> > Passwort vergessen
            </div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <!-- main-middle begin -->
    <div class="container">
        <div class="row">
            <aside id="aside" class="col-sm-1 hidden-xs"></aside>
            <article class="user col-sm-10 col-xs-12">
                <div class="tit">
                    <h2>Passwort vergessen</h2>
                </div>
                <form class="forgot-psd-form col-xs-12" method="post" action="<?php echo LANGPATH; ?>/customer/forgot_password">
                    <p class="font14">Bitte geben Sie Ihre E-Mail Adresse unten ein. Wir werden Ihr ursprüngliches Passwort zu Ihrem E-Mail-Box senden. Der Prozess kann ein wenig Zeit brauchen, wegen der Verzögerung des potenziellen System. Vielen Dank für Ihre Geduld und Ihr Verständnis.</p>
                    <ul>
                        <li>
                            <label class="col-sm-2 col-xs-12">
                                <span>*</span> Ihre Email:
                            </label>
                            <div>
                                <input class="text col-xs-12" type="text" value="" name="email">
                            </div>
                        </li>
                        <li>
                            <label class="hidden-xs col-sm-2"> </label>
                            <div>
                                <input class="btn btn-primary btn-lg" type="submit" value="SENDEN" name="">
                            </div>
                        </li>
                    </ul>
                </form>
            </article>
        </div>
    </div>
</div>
<script type="text/javascript">
/* forgot-psd-form */
$(".forgot-psd-form").validate({
    rules: {
        email: {    
            required: true,
            email: true
        }
    },
    messages: {
        email: {
            required:"Bitte geben Sie eine E-Mail ein.",
            email:"Bitte geben Sie eine gültige E-Mail Adresse ein."
        }
    }
});
</script>
