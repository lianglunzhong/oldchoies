<div class="site-content">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs row">
            <div class="col-xs-12">
                <a href="<?php echo LANGPATH; ?>/">Página de Inicio</a> > Recuperar su contraseña
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
                    <h2>Recuperar su contraseña</h2>
                </div>
                <form class="forgot-psd-form col-xs-12" method="post" action="<?php echo LANGPATH; ?>/customer/forgot_password">
                    <p>Por favor introduzca su dirección de email abajo. Le enviaremos la contraseña original. El proceso puede tardar algún tiempo debido a un posible retraso del sistema. Gracias por su paciencia.</p>
                    <ul>
                        <li>
                            <label class="col-sm-2 col-xs-12">
                                <span>*</span> Su Email
                            </label>
                            <div>
                                <input class="text col-xs-12" type="text" value="" name="email">
                            </div>
                        </li>
                        <li>
                            <label class="hidden-xs col-sm-2"> </label>
                            <div>
                                <input class="btn btn-primary btn-lg" type="submit" value="PRESENTAR" name="">
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
            required:"Por favor, proporcione un email.",
            email:"Por favor, introduce una dirección de email válida."
        }
    }
});
</script>
