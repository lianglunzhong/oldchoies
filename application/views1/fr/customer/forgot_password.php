<div class="site-content">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs row">
            <div class="col-xs-12">
                <a href="<?php echo LANGPATH; ?>/">Accueil</a> > Mot de passe oublié
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
                    <h2>Mot de passe oublié</h2>
                </div>
                <form class="forgot-psd-form col-xs-12" method="post" action="/customer/forgot_password">
                    <p>Entrez votre adresse e-mail enregistrée sur Choies.Nous vous enverrons par email le mot de passe original.Le processus peut prendre un peu de temps en raison du retard éventuel du système. Merci pour votre patience.</p>
                    <ul>
                        <li>
                            <label class="col-sm-2 col-xs-12">
                                <span>*</span> Votre e-mail:
                            </label>
                            <div>
                                <input class="text col-xs-12" type="text" value="" name="email">
                            </div>
                        </li>
                        <li>
                            <label class="hidden-xs col-sm-2"> </label>
                            <div>
                                <input class="btn btn-primary btn-lg" type="submit" value="SOUMETTRE" name="">
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
            required:"Veuillez saisir une adresse e-mail valide.",
            email   :"Veuillez saisir une adresse é-mail valide."
        }
    }
});
</script>
