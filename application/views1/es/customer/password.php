<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/">Página de Inicio</a>
				<a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > RESUMEN DE CUENTA</a> > Cambiar Contraseña
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
					<h2>Cambiar Contraseña</h2>
				</div>
				<div class="row">
					<div class="col-sm-2 hidden-xs"></div>
					<form class="user-form user-share-form col-sm-8 col-xs-12" method="post" action="">
						<p class="col-sm-12 col-xs-12 change-password">Para la seguridad de su cuenta, le recomendamos que elija una contraseña que no sea nombres, cumpleaños o direcciones de calles que se asocian con usted.</p>
						<ul>
							<li>
								<label class="col-sm-3 col-xs-12"><span>*</span>Contraseña Anterior:</label>
								<div class="col-sm-9 col-xs-12">
									<input type="password" class="text text-long col-sm-12 col-xs-12" value="" name="oldpassword">
								</div>
							</li>
							<li>
								<label class="col-sm-3 col-xs-12"><span>*</span>Contraseña Nueva:</label>
								<div class="col-sm-9 col-xs-12">
									<input type="password" class="text text-long col-sm-12 col-xs-12" value="" id="password" name="password">
								</div>
							</li>
							<li>
								<label class="col-sm-3 col-xs-12"><span>*</span>Confirmar Contraseña:</label>
								<div class="col-sm-9 col-xs-12">
									<input type="password" class="text text-long col-sm-12 col-xs-12" value="" name="confirmpassword">
								</div>
							</li>
							<li>
								<label class="col-sm-3 hidden-xs">&nbsp;</label>
								<div class="btn-grid12 col-sm-9 col-xs-12">
									<input type="submit" class="btn btn-primary btn-sm" value="CAMBIAR CONTRASEÑA" name="">
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
                required: "Por favor, ingrese su contraseña.",
                minlength: "Su contraseña debe tener al menos 5 caracteres.",
                maxlength:"La contraseña supera la longitud máxima de 20 caracteres."
            },
            password: {
                required: "Por favor, ingrese su contraseña.",
                minlength: "Su contraseña debe tener al menos 5 caracteres.",
                maxlength:"La contraseña supera la longitud máxima de 20 caracteres."
            },
            confirmpassword: {
                required: "Por favor, ingrese su contraseña.",
                minlength: "Su contraseña debe tener al menos 5 caracteres.",
                maxlength:"La contraseña supera la longitud máxima de 20 caracteres.",
                equalTo: "Por favor, ingrese una contraseña la misma que arriba."
            }
        }
    });
</script>
