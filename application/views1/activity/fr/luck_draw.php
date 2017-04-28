<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
	<link rel="stylesheet" href="/assets/css/style.css">
	<script src="/assets/js/jquery-1.8.2.min.js"></script>
	</head>
<body>
	<div class="page">
		<header class="site-header">
			<div class="nav-wrapper" style="display:block;">
				<div class="container">
					<div class="row" style="width:1200px;  background-color: #202020;">
						<div class="col-xs-2">
							<a class="logo" href="/fr" title=""></a>
						</div>
						<div class="col-xs-10" style="display:block;">
							<nav id="nav1" class="nav">
								<ul>
									<li>
										<a href="/fr/daily-new">NOUVEAUTÉS</a>
									</li>
									<li>
										<a href="/fr/clothing-c-615">VÊTEMENTS</a>
									</li>
									<li>
										<a href="/fr/shoes-c-53">CHAUSSURES</a>
									</li>
									<li>
										<a href="/fr/accessory-c-52">ACCESSORIES</a>
									</li>
									<li>
										<a href="/fr/outlet-c-101" class="sale">SALE</a>
									</li>
									<li>
										<a href="/fr">ACTIVITÉS</a>
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
								<h3>Étape 1</h3>
								<i class="fa fa-play"></i>
							</div>	
							<!-- User In -->
							<div class="luck-reg flr" style="padding-top:50px;">
								<h3>Inscrivez-vous pour GAGNER</h3>
								<p>Inscrivez-vous avec CHOIES!</p>
								<p>Ensuite, vous pouvez commencer à Lucky Platine, et profiter de la grande surprise!</p>
								<div class="reg-win">
									<div class="fll"><img src="/assets/images/reg-win-fr.jpg"></div>
									<?php if(Customer::logged_in()){?>
									<div class="flr signup-success">
										<b>Super!</b>
										<p>Vous avez rejoint avec succès Chioes famille!</p>
									</div>
									<?php }else{?>
									<div class="flr w-signup" style=" padding:40px 40px 0 0;">
										<form class="signup-form sign-form form" method="post" action="/customer/register">
											<input type="hidden" value="http://www.choies.com/" name="referer">
											<input type="hidden" value="luck_draw" name="draw_from">
											<input type="hidden" value="fr" name="langpath">
											<ul>
												<li>
													<div>
														<label>Adresse email:</label>
													</div>
													<input id="email" class="text umail" type="text" name="email" value="" onchange="chkemail()">
												</li>
												<li>
													<div>
														<label>Mot de Passe:</label>
													</div>
													<input id="password" class="text" type="password" maxlength="16" name="password" value="">
												</li>
												<li>
													<div>
														<label>Confirmez le mot de passe:</label>
													</div>
													<input class="text" type="password" maxlength="16" name="password_confirm" value="">
												</li>
												<li>
													<input class="btn btn-primary btn-lg mr10" type="submit" name="submit" value="SOUMETTRE">
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
								<h3>Étape 2</h3>
								<i class="fa fa-play"></i>
							</div>	
							<div class="luck-reg flr" style="padding-top:50px;">
								<h3>Tentez Votre Chance</h3>
								<div class="turntable">
									<div class="tur-box">
									<div id="dowebok">
										<div class="plate pla-bg-fr">	</div>
										<?php if(Customer::logged_in()){?>
									    <a id="plateBtn" class="pla-play-fr" href="javascript:void();" title="Commencer">Commencer</a>
										<?php }else{?>
										<a id="plateBtnHide" class="pla-play-fr" href="javascript:void();" title="Commencer">Commencer</a>
									    <?php }?>
									</div>
										<div class="tur-user">
											<div class="tur-r-t">
												<b>VEINAR D'AUJOURD'HUI</b>
												<p>Nous montrons que les 100 derniers gagnants ici.</p>
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
												    		$row = DB::query(Database::SELECT, 'select email,draw_name from customer_draw order by position ASC limit 50')->execute()->as_array();
												    		if(count($row)>=1){foreach ($row as $v) {
												    			$email = explode('@', $v['email']);
													    		$email1 = substr($email[0], 0,2).'**'.substr($email[0], -1);//eg:ma**s
													    		$email2 = explode('.', $email[1]);
													    		$newemail = $email1.'@'.substr($email[1], 0,1).'*'.substr($email[1], -4);//eg:ma**s
																switch ($v['draw_name'])
																	{
																	case 'Free Gift':
																	  $v['draw_name']='Cadeau Gratuit';
																	  break;
																	case 'Happy Every Day':
																	  $v['draw_name']='Heureux Chaque Jour'; 
																	  break;
																	case '5% Coupon':
																	  $v['draw_name']='5% COUPON';
																	  break;
																	case '10% Coupon':
																	  $v['draw_name']='10% COUPON';
																	  break;
																	case '$100 LUCKY BAG':
																	  $v['draw_name']='$100 FUKUBUKURO';
																	  break;
																	case '$50 GIFT CARD':
																	  $v['draw_name']='$50 CARTE CADEAU';
																	  break;
																	default:
																	  $v['draw_name']=$v['draw_name'];
																	}
												    	?>
												        <li style="font-size:12px"><?php echo $newemail;?><span><?php echo $v['draw_name'];?></span></li>
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
										<dt>Remarque:</dt>
										<dd>1.Un ID, une chance de jouer le match.</dd>
										<dd>2.Choies se réserve le droit à l'explication finale de la campagne.</dd>
										<dd>Toute question concernant la campagne s'il vous plaît envoyer un courriel à service_fr@choies.com.</dd>
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
						<p class="bottom container-fluid">Copyright © 2006-2015 Choies.com&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a style="color: #ccc;" href="/fr/privacy-security" class="hidden-xs">summaryConfidentialité&amp;&amp; Sécurité</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a style="color: #ccc;" href="/fr/about-us" class="hidden-xs">À propos de nous</a>
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
							alert("Pardon! Vous avez déjà joué le jeu!.");
							break;
						case "689717": 
							var five = [ 170, 140];
							five = five[Math.floor(Math.random()*five.length)];
							rotateFunc(689717,five,'<div class="res-box"><div class="res-title">FELICITATIONS! VOUS AVEZ UN CODE DE<span> 5%</span></div><div class="res-img"><img src="/assets/images/5code-fr.png"></div><div class="res-back"><a href="<?php echo LANGPATH;?>/customer/coupons">Mes Coupons</a><a href="<?php echo  LANGPATH;?>/" style="margin-left:20px;">Commencez Shopping></a></div></div>');
							break;
						case "0": 
							var haveno = [ 90, 75];
							haveno = haveno[Math.floor(Math.random()*haveno.length)];
							rotateFunc(0,haveno,'<div class="res-box"><div class="res-title">HEUREUX TOUS LES JOURS</div><div class="res-img" style="margin-top:8px;"><img src="/assets/images/smile.png"></div><div class="res-back" style="margin-top:8px;">Désolé! <br>Pas de cadeau, mais les meilleurs vœux de <a href="<?php echo  LANGPATH;?>/">Choies.</a></div></div>');
							break;
						case "689721": 
							var FREE = [ 245, 290];
							FREE = FREE[Math.floor(Math.random()*FREE.length)];
							rotateFunc(689721,FREE,'<div class="res-box"><div class="res-title">FELICITATIONS! VOUS AVEZ UN<span>CADEAU GRATUIT!<span> </div><div class="res-img" style="margin-top:8px;"><img src="/assets/images/luck-fr.png"></div><div class="res-back" style="margin-top:8px;"><a href="<?php echo LANGPATH;?>/customer/coupons">Consultez le Code Cadeau dans MES COUPONS</a><a href="<?php echo  LANGPATH;?>/" style="margin-left:20px;">Commencez Shopping MAINTENANT></a></div></div>');
							break;
						case "689718": 
							var ten = [ 355, 310];
							ten = ten[Math.floor(Math.random()*ten.length)];
							rotateFunc(689718,ten,'<div class="res-box"><div class="res-title">FELICITATIONS! VOUS AVEZ UN CODE DE <span>10%</span></div><div class="res-img"><img src="/assets/images/10code-fr.png"></div><div class="res-back"><a href="<?php echo LANGPATH;?>/customer/coupons">Mes Coupons</a><a href="<?php echo  LANGPATH;?>/" style="margin-left:20px;">Commencez Shopping ></a></div></div>');
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
                        required:"Fournissez une adresse email s'il vous plaît.",
                        email:"Enterez une adresse email valide s'il vous plaît."
                    },
                    password: {
                        required: "Fournissez un mot de passe s'il vous plaît.",
                        minlength: "Votre mot de passe doit être 5 caractères.",
                        maxlength:"Le mot de passe dépasse la longueur maximum de 20 caractères."
                    },
                    password_confirm: {
                        required: "Fournissez un mot de passe s'il vous plaît.",
                        minlength: "Votre mot de passe doit être 5 caractères.",
                        maxlength:"Le mot de passe dépasse la longueur maximum de 20 caractères.",
                        equalTo: "Enterez le même mot de passe ci-dessus s'il vous plaît."
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
						alert("Cet email a été enregistré.");
						$(".umail").val("");
						return false;
					}
				})
			}
        </script>	
</body>
</html>