<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Página de Inicio</a>  >  Olvidaste su contraseña</div>
        </div>
        <?php echo message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Olvidaste su contraseña</h2></div>
            <!-- Share This Product begin -->
            <form action="/customer/forgot_password" method="post" class="form user_share_form user_form mlr70">
                <p class="font14">Introduzca su dirección de email abajo. Le enviaremos su contraseña original a ti. El proceso puede tardar un poco de tiempo, debido al potencial de retardo del sistema. Gracias por su paciencia.</p>
                <ul>
                    <li class="fix">
                        <label style="width:100px;"><span>*</span>Su Email:</label>
                        <div class="right_box">
                            <input type="text" name="email" value="" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label style="width:100px;">&nbsp;</label>
                        <div class="right_box">
                            <input type="submit" name="" value="PRESENTAR" class="view_btn btn26 btn40" />
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
                required:"Por favor, proporcione un email.",
                email:"Por favor, introduce una dirección de email válida."
            }
        }
    });
</script>
