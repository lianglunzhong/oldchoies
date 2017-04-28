<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
	<link rel="stylesheet" href="/assets/css/style.css">
	<script src="/assets/js/jquery-1.8.2.min.js"></script>
<!-- GA code -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-32176633-1', 'choies.com', {'siteSpeedSampleRate': 20});
ga('require', 'displayfeatures');
ga('send', 'pageview');

</script>
	</head>
<body>
	<div class="page">
		<header class="site-header">
			<div class="nav-wrapper" style="display:block;">
				<div class="container">
					<div class="row" style="width:1200px;  background-color: #202020;">
						<div class="col-xs-2">
							<a class="logo" href="/es" title=""></a>
						</div>
						<div class="col-xs-10" style="display:block;">
							<nav id="nav1" class="nav">
								<ul>
									<li>
										<a href="/es/daily-new">NOVEDADES</a>
									</li>
									<li>
										<a href="/es/clothing-c-615">ROPA</a>
									</li>
									<li>
										<a href="/es/shoes-c-53">ZAPATOS</a>
									</li>
									<li>
										<a href="/es/accessory-c-52">ACCESORIOS</a>
									</li>
									<li>
										<a href="/es/outlet-c-101" class="sale">SALE</a>
									</li>
									<li>
										<a href="/es">ACTIVIDADES</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</header>
		<div class="site-content">
			<div class="main-container clearfix">
				<div class="container">
					<div class="row" style="width:1200px;">
						<div class="luck-lay">
							<div class="luck-step fll" style="padding-top:50px;">
								<h3>Paso 1</h3>
								<i class="fa fa-play"></i>
							</div>	
							<!-- User In -->
							<div class="luck-reg flr" style="padding-top:50px;">
								<h3>Registrarte para Ganar </h3>
								<p>Registrarte en CHOIES!</p>
								<p>Entonces puedes comenzar la ruleta de la suerte y disfrutar de la gran sorpresa!</p>
								<div class="reg-win">
									<div class="fll"><img src="/assets/images/reg-win-es.jpg"></div>
									<?php if(Customer::logged_in()){?>
									<div class="flr signup-success">
										<b>¡Qué bien! </b>
										<p>Se ha unido a Choies Familia con éxito.</p>
									</div>
									<?php }else{?>
									<div class="flr w-signup" style=" padding:40px 40px 0 0;">
										<form class="signup-form sign-form form" method="post" action="/customer/register">
											<input type="hidden" value="http://www.choies.com/" name="referer">
											<input type="hidden" value="luck_draw" name="draw_from">
											<input type="hidden" value="es" name="langpath">
											<ul>
												<li>
													<div>
														<label>Dirección de email:</label>
													</div>
													<input id="email" class="text umail" type="text" name="email" value="" onchange="chkemail()">
												</li>
												<li>
													<div>
														<label>Contraseña :</label>
													</div>
													<input id="password" class="text" type="password" maxlength="16" name="password" value="">
												</li>
												<li>
													<div>
														<label>Confirmar contraseña:</label>
													</div>
													<input class="text" type="password" maxlength="16" name="password_confirm" value="">
												</li>
												<li>
													<input class="btn btn-primary btn-lg mr10" type="submit" name="submit" value="REGISTRARTE" onclick="ga('send', 'event', 'Button_click', 'click', 'Sign Up_activity');">
												</li>
											</ul>
										</form>
									</div>
									<?php }?>
								</div>	
							</div>
						</div>
						<div class="luck-lay">
							<div class="luck-step fll" style="padding-top:50px;">
								<h3>Paso 2</h3>
								<i class="fa fa-play"></i>
							</div>	
							<div class="luck-reg flr" style="padding-top:50px;">
								<h3>Pruebe su suerte</h3>
								<div class="turntable">
									<div class="tur-box">
									<div id="dowebok">
										<div class="plate pla-bg-es">	</div>
										<?php if(Customer::logged_in()){?>
									    <a id="plateBtn" class="pla-play-es" href="javascript:void();" title="Comenzar ">Comenzar </a>
										<?php }else{?>
										<a id="plateBtnHide" class="pla-play-es" href="javascript:void();" title="Comenzar ">Comenzar </a>
									    <?php }?>
									</div>
										<div class="tur-user">
											<div class="tur-r-t">
												<b>Afortunado Ganador  Hoy</b>
												<p>Sólo mostramos los ultimos 100 ganadores aquí.</p>
											</div>
											<div class="tur-r-line">
												<div class="fll"><img src="/assets/images/cup.png"></div>

												<script type="text/javascript">
													$(function(){
													    $('.fontscroll').fontscroll({time: 3000,num: 1});
													});
												</script>
												<div class="fontscroll flr">
												    <ul>
												    	<?php 
												    		$row = DB::query(Database::SELECT, 'select email,draw_name from customer_draw order by position asc limit 50')->execute()->as_array();
												    		if(count($row)>=1){foreach ($row as $v) {
												    			$email = explode('@', $v['email']);
													    		$email1 = substr($email[0], 0,2).'**'.substr($email[0], -1);//eg:ma**s
													    		$email2 = explode('.', $email[1]);
													    		$newemail = $email1.'@'.substr($email[1], 0,1).'*'.substr($email[1], -4);//eg:ma**s
															switch ($v['draw_name'])
																	{
																	case 'Free Gift':
																	  $v['draw_name']='REGALO GRATUITO';
																	  break;
																	case 'Happy Every Day':
																	  $v['draw_name']='FELIZ CADA DÍA';
																	  break;
																	case '5% Coupon':
																	  $v['draw_name']='5% Cupón';
																	  break;
																	case '10% Coupon':
																	  $v['draw_name']='10% Cupón';
																	  break;
																	case '$100 LUCKY BAG':
																	  $v['draw_name']='$100 BOLSA SORPRESA';
																	  break;
																	case '$50 LUCKY BAG':
																	  $v['draw_name']='$50 TARJETA DE REGALO';
																	  break;
																	default:
																	  $v['draw_name']=$v['draw_name'];
																	}
														?>
												        <li style="font-size:13px"><?php echo $newemail;?><span><?php echo $v['draw_name'];?></span></li>
												        <?php }}?>
												    </ul>
												</div>
											</div>	
										</div>	
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="luck-notes">
									<dl>
										<dt>Notas:</dt>
										<dd>1. Un ID sólo tiene una oportunidad de jugar el juego.</dd>
										<dd>2. Choies reservas la derecha de hacer una explicación final de la campaña.</dd>
										<dd>Si tiene preguntas relacionadas con la campaña, envíenos un email a service_es@choies.com.</dd>
									</dl>
								</div>
							</div>
						</div>
					</div>	
				</div>
			</div>
		</div>
		<footer>
			<div class="container-fluid" style="background-color: #202020;">
				<div class="copyr container">
					<div class="row" style="width:1200px;  background-color: #202020;">
						<p class="bottom container-fluid">Copyright © 2006-2015 Choies.com&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a style="color: #ccc;" href="#" class="hidden-xs">Privacy &amp; Security</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a style="color: #ccc;" href="#" class="hidden-xs">About Choies</a>
						</p>
					</div>
				</div>
			</div>
		</footer>
		<div id="gotop" class="hide ">
			<a href="#" class="xs-mobile-top"></a>
		</div>

	</div>
	<div id="result">
    	<div class="result-modal-bg"></div>
		<div id="resultTxt">       	
        </div>
	</div>
	
	<script src="/assets/js/jquery.rotate.min.js"></script>
	<script>
		$(function(){
			var $plateBtn = $('#plateBtn');
			var $plate = $('.plate');
			var $result = $('#result');
			var $resultTxt = $('#resultTxt');
			var $resultBtn = $('#resultBtn');
			
			$plateBtn.click(function()
			{
				$plateBtn.unbind("click"); 
				$.post('/activity/chkdraw',{customer_id : "<?php echo Customer::logged_in();?>"},function(data)
				{
					switch(data){
						case "nochange":
							alert("¡Lo siento! Ya ha jugado el juego.");
							break;
						case "689717": 
							var five = [ 170, 140];
							five = five[Math.floor(Math.random()*five.length)];
							rotateFunc(689717,five,'<div class="res-box"><div class="res-title">¡Felicidades! Has obtenido un cupón de<span> -5%.</span></div><div class="res-img"><img src="/assets/images/5code-es.png"></div><div class="res-back"><a href="<?php echo LANGPATH;?>/customer/coupons">Mis Cupónes</a><a href="<?php echo LANGPATH;?>/" style="margin-left:20px;">Empezar a Comprar ></a></div></div>');
							break;
						case "0": 
							var haveno = [ 90, 75];
							haveno = haveno[Math.floor(Math.random()*haveno.length)];
							rotateFunc(0,haveno,'<div class="res-box"><div class="res-title">FELIZ CADA DÍA</div><div class="res-img" style="margin-top:8px;"><img src="/assets/images/smile.png"></div><div class="res-back" style="margin-top:8px;">¡Lo siento! <br>No regalo pero los mejores deseos desde <a href="<?php echo LANGPATH;?>/">CHOIES.</a></div></div>');
							break; 
						case "689721": 
							var FREE = [ 245, 290];
							FREE = FREE[Math.floor(Math.random()*FREE.length)];
							rotateFunc(689721,FREE,'<div class="res-box"><div class="res-title">¡Felicidades! Has obtenido un <span>REGALO GRATUITO!<span> </div><div class="res-img" style="margin-top:8px;"><img src="/assets/images/luck-es.png"></div><div class="res-back" style="margin-top:8px;"><a href="<?php echo LANGPATH;?>/customer/coupons">Ver el código de regalo en Mis Cupones</a><a href="<?php echo LANGPATH;?>/" style="margin-left:20px;">Empezar a comprar ahora ></a></div></div>');
							break;
						case "689718": 
							var ten = [ 355, 310];
							ten = ten[Math.floor(Math.random()*ten.length)];
							rotateFunc(689718,ten,'<div class="res-box"><div class="res-title">¡Felicidades! Has obtenido un cupón de<span> -10%.</span></div><div class="res-img"><img src="/assets/images/10code-es.png"></div><div class="res-back"><a href="<?php echo LANGPATH;?>/customer/coupons">Mis Cupónes</a><a href="<?php echo LANGPATH;?>/" style="margin-left:20px;">Empezar a Comprar ></a></div></div>');
							break;
						}
				});
					
			});
			 
			var rotateFunc = function(awards,angle,text){
				$plate.stopRotate();
				$plate.rotate({
					angle: 0, 
					duration: 5000,
					animateTo: angle + 1440, 
					callback: function(){
						$.post('/activity/senddraw',{coupon_id:awards,customer_id:"<?php echo Customer::logged_in();?>"},function(re){
							$resultTxt.html(text);
							$result.show();
						})	
					}
				});
			};
		});
	</script>

	<script type="text/javascript">
            // signup-form 
            $(".signup-form").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 5,
                        maxlength:20
                    },
                    password_confirm: {
                        required: true,
                        minlength: 5,
                        maxlength:20,
                        equalTo: "#password"
                    }
                },
                messages: {
                    email:{
                        required:"Proporcione un correo electrónico.",
                        email:"Introduzca una dirección de correo electrónico válida."
                    },
                    password: {
                        required: "Proporcione una contraseña.",
                        minlength: "La contraseña debe tener entre 5 caracteres.",
                        maxlength:"La contraseña excede la longitud máxima de 20 caracteres."//gai
                    },
                    password_confirm: {
                        required: "Proporcione una contraseña.",
                        minlength: " La contraseña debe tener entre 5 caracteres.",
                        maxlength:"La contraseña excede la longitud máxima de 20 caracteres.",//gai
                        equalTo: "Introduzca la misma contraseña que arriba."
                    }
                }
            });
 			$("#plateBtnHide").click(function(){
				$(window).scrollTop(0);
			});

			//chkemail
			function chkemail(){
				var uemail = $(".umail").val();
				$.post('/draw/chkmail', {email:uemail}, function(result){
					if(result == "isset"){
						alert("Este email ya ha sido registrado.");
						$(".umail").val("");
						return false;
					}
				})
			}
        </script>	
</body>
</html>