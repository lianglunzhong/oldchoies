<section id="main">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs">
            <div>
                <a href="<?php echo LANGPATH; ?>/">Accueil</a>
                <a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > Mon Compte</a> >Changer le mot de passe
            </div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <!-- main-middle begin -->
    <div class="container">
        <div class="row">
<?php echo View::factory(LANGPATH . '/customer/left'); ?>
<?php echo View::factory(LANGPATH . '/customer/left_1'); ?>
            <article class="user col-sm-9 col-xs-12">
                <div class="tit">
                    <h2>Changer le mot de passe</h2>
                </div>
                <div class="row">
                    <div class="col-sm-2 hidden-xs"></div>
                    <form class="user-form user-share-form col-sm-8 col-xs-12" method="post" action="">
                        <p class="col-sm-12 col-xs-12 change-password">Pour la sécurité de votre compte, nous recommandons que vous choisissiez un mot de passe d'autre que des noms, des anniversaires ou les adresses postales qui vous sont associées.</p>
                        <ul>
                            <li>
                                <label class="col-sm-3 col-xs-12"><span>*</span>Ancien mot de passe:</label>
                                <div class="col-sm-9 col-xs-12">
                                    <input type="password" class="text text-long col-sm-12 col-xs-12" value="" name="oldpassword">
                                </div>
                            </li>
                            <li>
                                <label class="col-sm-3 col-xs-12"><span>*</span>Nouveau mot de passe:</label>
                                <div class="col-sm-9 col-xs-12">
                                    <input type="password" class="text text-long col-sm-12 col-xs-12" value="" id="password" name="password">
                                </div>
                            </li>
                            <li>
                                <label class="col-sm-3 col-xs-12"><span>*</span>Confirmation du mot de passe:</label>
                                <div class="col-sm-9 col-xs-12">
                                    <input type="password" class="text text-long col-sm-12 col-xs-12" value="" name="confirmpassword">
                                </div>
                            </li>
                            <li>
                                <label class="col-sm-3 hidden-xs">&nbsp;</label>
                                <div class="btn-grid12 col-sm-9 col-xs-12">
                                    <input type="submit" class="btn btn-primary btn-sm" value="CHANGER MOT DE PASSE" name="">
                                </div>
                            </li>
                        </ul>
                    </form>
                    <div class="col-sm-2 hidden-xs"></div>
                </div>
            </article>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(".user-share-form").validate({
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
