<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Accueil</a>  >  Reset Password</div>
        </div>
        <?php echo message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Reset Password</h2></div>
            <!-- Share This Product begin -->
            <form action="<?php echo URL::current(); ?>" method="post" class="form user_share_form user_form mlr70">
                <p class="font14">For the security of your account, we recommend that you choose a Password other than names, birthdays or street addresses that are associated with you.</p>
                <ul>
                    <li class="fix">
                        <label><span>*</span>New Password:</label>
                        <div class="right_box">
                            <input type="password" name="password" id="password" value="" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label><span>*</span>Confirm Password:</label>
                        <div class="right_box">
                            <input type="password" name="confirmpassword" value="" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label>&nbsp;</label>
                        <div class="right_box">
                            <input type="submit" name="" value="Reset Password" class="view_btn btn26 btn40" />
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