<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/">Homepage</a>
				<a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > KONTOÜBERSICHT</a> > Passwort Ändern
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
					<h2>Passwort Ändern</h2>
				</div>
				<div class="row">
					<div class="col-sm-2 hidden-xs"></div>
					<form class="user-form user-share-form col-sm-8 col-xs-12" method="post" action="">
						<p class="col-sm-12 col-xs-12 change-password">Für die Sicherheit Ihres Kontos, empfehlen wir Ihnen, ein Passwort andere als Namen, Geburtstage oder Straßenadressen, die mit Ihnen verbunden sind, zu wählen.</p>
						<ul>
							<li>
								<label class="col-sm-3 col-xs-12"><span>*</span>Altes Passwort:</label>
								<div class="col-sm-9 col-xs-12">
									<input type="password" class="text text-long col-sm-12 col-xs-12" value="" name="oldpassword">
								</div>
							</li>
							<li>
								<label class="col-sm-3 col-xs-12"><span>*</span>Neues Passwort:</label>
								<div class="col-sm-9 col-xs-12">
									<input type="password" class="text text-long col-sm-12 col-xs-12" value="" id="password" name="password">
								</div>
							</li>
							<li>
								<label class="col-sm-3 col-xs-12"><span>*</span>Passwort Bestätigen:</label>
								<div class="col-sm-9 col-xs-12">
									<input type="password" class="text text-long col-sm-12 col-xs-12" value="" name="confirmpassword">
								</div>
							</li>
							<li>
								<label class="col-sm-3 hidden-xs">&nbsp;</label>
								<div class="btn-grid12 col-sm-9 col-xs-12">
									<input type="submit" class="btn btn-primary btn-sm" value="PASSWORT ÄNDERN" name="">
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
                required: "Bitte geben Sie ein Passwort.",
                minlength: "Ihr Passwort muss mindestens 5 Zeichen lang sein.",
                maxlength:"Das Passwort überschreitet eine maximale Länge von 20 Zeichen."
            },
            password: {
                required: "Bitte geben Sie ein Passwort.",
                minlength: "Ihr Passwort muss mindestens 5 Zeichen lang sein.",
                maxlength:"Das Passwort überschreitet eine maximale Länge von 20 Zeichen."
            },
            confirmpassword: {
                required: "Bitte geben Sie ein Passwort.",
                minlength: "Ihr Passwort muss mindestens 5 Zeichen lang sein.",
                maxlength:"Das Passwort überschreitet eine maximale Länge von 20 Zeichen.",
                equalTo: "Bitte geben Sie das gleiche Passwort wie oben ein."
            }
        }
    });
</script>
