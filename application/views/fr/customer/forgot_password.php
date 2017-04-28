<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Accueil</a>  >  Mot de passe oublié</div>
        </div>
        <?php echo message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Mot de passe oublié</h2></div>
            <!-- Share This Product begin -->
            <form action="<?php echo LANGPATH; ?>/customer/forgot_password" method="post" class="form user_share_form user_form mlr70">
                <p class="font14">Entrez votre adresse e-mail enregistrée sur Choies.Nous vous enverrons par email le mot de passe original.Le processus peut prendre un peu de temps en raison du retard éventuel du système. Merci pour votre patience.</p>
                <ul>
                    <li class="fix">
                        <label style="width:100px;"><span>*</span>Votre e-mail:</label>
                        <div class="right_box">
                            <input type="text" name="email" value="" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label style="width:100px;">&nbsp;</label>
                        <div class="right_box">
                            <input type="submit" name="" value="ENVOYER" class="view_btn btn26 btn40" />
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
                required:"Veuillez saisir une adresse e-mail valide.",
                email   :"Veuillez saisir une adresse é-mail valide."
            }
        }
    });
</script>
