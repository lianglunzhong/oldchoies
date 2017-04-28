<div class="site-content">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs row">
            <div class="col-xs-12">
                <a href="<?php echo LANGPATH; ?>/">Accueil</a>  >  Reset Password
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
                    <h2>Reset Password</h2>
                </div>
                <form action="<?php echo URL::current(); ?>" method="post" class="forgot-psd-form col-xs-12">
                    <p>For the security of your account, we recommend that you choose a Password other than names, birthdays or street addresses that are associated with you.</p>
                    <ul>
                        <li>
                            <label class="col-sm-2 col-xs-12">
                                <span>*</span> New Password:
                            </label>
                            <div>
                                <input class="text col-xs-12" type="password" id="password" name="password" value="">
                            </div>
                        </li>
                        <li>
                            <label class="col-sm-2 col-xs-12">
                                <span>*</span> Confirm Password:
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
                required : "Veuillez saisir un mot de passe.",
                minlength: "Votre mot de passe doit avoir 5 caractères au moins.",
                maxlength: "Votre mot de passe ne peut pas dépasser 20 caractères."
            },
            confirmpassword: {
                required: "Veuillez saisir un mot de passe.",
                minlength:"Votre mot de passe doit avoir 5 caractères au moins.",
                maxlength:"Votre mot de passe ne peut pas dépasser 20 caractères.",
                equalTo : "Veuillez entrer le mot de passe même comme ci-dessus."
            }
        }
    });
</script>