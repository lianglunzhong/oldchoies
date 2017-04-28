<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Página de Inicio</a>  >  Cambiar Contraseña</div>
        </div>
        <?php echo message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Cambiar Contraseña</h2></div>
            <!-- Share This Product begin -->
            <form action="" method="post" class="form user_share_form user_form mlr70">
                <p class="font14">Para la seguridad de su cuenta, le recomendamos que elija una contraseña que no sea nombres, cumpleaños o direcciones de calles que se asocian con usted.</p>
                <ul>
                    <li class="fix">
                        <label><span>*</span>Anterior Contraseña:</label>
                        <div class="right_box">
                            <input type="text" name="oldpassword" value="" class="text text_long" maxlength="16" />
                        </div>
                    </li>
                    <li class="fix">
                        <label><span>*</span>Nuevo Contraseña:</label>
                        <div class="right_box">
                            <input type="text" name="password" id="password" value="" class="text text_long" maxlength="16" />
                        </div>
                    </li>
                    <li class="fix">
                        <label><span>*</span>Confirmar Contraseña:</label>
                        <div class="right_box">
                            <input type="text" name="confirmpassword" value="" class="text text_long" maxlength="16" />
                        </div>
                    </li>
                    <li class="fix">
                        <label>&nbsp;</label>
                        <div class="right_box">
                            <input type="submit" name="" value="CAMBIAR CONTRASEÑA" class="view_btn btn26 btn40" />
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
                required: "Por favor, ingrese una contraseña.",
                minlength: "Su contraseña debe tener al menos 5 caracteres."
            },
            password: {
                required: "Por favor, ingrese una contraseña.",
                minlength: "Su contraseña debe tener al menos 5 caracteres."
            },
            confirmpassword: {
                required: "Por favor, ingrese una contraseña.",
                minlength: "Su contraseña debe tener al menos 5 caracteres.",
                equalTo: "Por favor, ingrese una contraseña la misma que arriba."
            }
        }
    });
</script>
