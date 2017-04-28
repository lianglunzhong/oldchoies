<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Accueil</a>  >  Changer le mot de passe</div>
        </div>
        <?php echo message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Changer le mot de passe</h2></div>
            <!-- Share This Product begin -->
            <form action="" method="post" class="form user_share_form user_form mlr70">
                <p class="font14">Pour la sécurité de votre compte, nous vous recommandons de choisir un mot de passe autre que le nom, la date de naissance ou l’adresse de la rue, qui sont liés à vous.</p>
                <ul>
                    <li class="fix">
                        <label><span>*</span>Ancien mot de passe:</label>
                        <div class="right_box">
                            <input type="password" name="oldpassword" value="" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label><span>*</span>Nouveau mot de passe:</label>
                        <div class="right_box">
                            <input type="password" name="password" id="password" value="" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label><span>*</span>Confirmation du mot de passe:</label>
                        <div class="right_box">
                            <input type="password" name="confirmpassword" value="" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label>&nbsp;</label>
                        <div class="right_box">
                            <input type="submit" name="" value="CHANGER MOT DE PASSE" class="view_btn btn26 btn40" />
                        </div>
                    </li>
                </ul>
            </form>
        </article>
        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
    </section>
</section>
<script type="text/javascript">
    /* user_share_form */
    $(".user_share_form").validate({
        rules: {
            oldpassword: {    
                required: true,
                minlength: 5,
                maxlength:20
            },
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
            }
        },
        messages: {
            oldpassword: {
                required: "Veuillez saisir un mot de passe.",
                minlength:"Votre mot de passe doit avoir 5 caractères au moins.",
                maxlength:"Votre mot de passe ne peut pas dépasser 20 caractères."
            },
            password: {
                required: "Veuillez saisir un mot de passe.",
                minlength:"Votre mot de passe doit avoir 5 caractères au moins.",
                maxlength:"Votre mot de passe ne peut pas dépasser 20 caractères."
            },
            confirmpassword: {
                required: "Veuillez saisir un mot de passe.",
                minlength:"Votre mot de passe doit avoir 5 caractères au moins.",
                maxlength:"Votre mot de passe ne peut pas dépasser 20 caractères.",
                equalTo:  "Veuillez entrer le mot de passe même comme ci-dessus."
            }
        }
    });
</script>
