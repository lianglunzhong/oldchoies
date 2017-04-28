<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Homepage</a>  >  Passwort vergessen</div>
        </div>
        <?php echo message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Passwort vergessen</h2></div>
            <!-- Share This Product begin -->
            <form action="<?php echo LANGPATH; ?>/customer/forgot_password" method="post" class="form user_share_form user_form mlr70">
                <p class="font14">Bitte geben Sie Ihre E-Mail Adresse unten ein. Wir werden Ihr ursprüngliches Passwort zu Ihrem E-Mail-Box senden. Der Prozess kann ein wenig Zeit brauchen, wegen der Verzögerung des potenziellen System. Vielen Dank für Ihre Geduld und Ihr Verständnis.</p>
                <ul>
                    <li class="fix">
                        <label style="width:100px;"><span>*</span>Ihre Email:</label>
                        <div class="right_box">
                            <input type="text" name="email" value="" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label style="width:100px;">&nbsp;</label>
                        <div class="right_box">
                            <input type="submit" name="" value="SENDEN" class="view_btn btn26 btn40" />
                        </div>
                    </li>
                </ul>
            </form>
        </article>
    </section>
</section>
<script type="text/javascript">
    /* user_share_form */
    $(".user_share_form").validate({
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
