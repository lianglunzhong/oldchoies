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
							<a class="logo" href="/ru" title=""></a>
						</div>
						<div class="col-xs-10" style="display:block;">
							<nav id="nav1" class="nav">
								<ul>
									<li>
										<a href="/ru/daily-new">Новинки</a>
									</li>
									<li>
										<a href="/ru/clothing-c-615">Одежда</a>
									</li>
									<li>
										<a href="/ru/shoes-c-53">Обувь</a>
									</li>
									<li>
										<a href="/ru/accessory-c-52">Аксессуары</a>
									</li>
									<li>
										<a href="/ru/outlet-c-101" class="sale">Распродажа</a>
									</li>
									<li>
										<a href="/ru">Деятельность</a>
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
								<h3>Первый Шаг</h3>
								<i class="fa fa-play"></i>
							</div>	
							<!-- User In -->
							<div class="luck-reg flr" style="padding-top:50px;">
								<h3>Зарегистрируйся, чтобы выиграть</h3>
								<p>Регистрация с CHOIES!</p>
								<p>Затем вы можете начать Счастливый Вращающийся Диск, и пользуются большим сюрпризом!</p>
								<div class="reg-win">
									<div class="fll"><img src="/assets/images/reg-win-ru.jpg"></div>
									<?php if(Customer::logged_in()){?>
									<div class="flr signup-success">
										<b>Молодец!</b>
										<p>Вы успешно присоединились Chioes семьи!</p>
									</div>
									<?php }else{?>
									<div class="flr w-signup" style=" padding:40px 40px 0 0;">
										<form class="signup-form sign-form form" method="post" action="/customer/register">
											<input type="hidden" value="<?php echo BASEURL ;?>/" name="referer">
											<input type="hidden" value="luck_draw" name="draw_from">
											<input type="hidden" value="ru" name="langpath">
											<ul>
												<li>
													<div>
														<label>Адрес электронной почты:</label>
													</div>
													<input id="email" class="text umail" type="text" name="email" value="" onchange="chkemail()">
												</li>
												<li>
													<div>
														<label>Пароль:</label>
													</div>
													<input id="password" class="text" type="password" maxlength="16" name="password" value="">
												</li>
												<li>
													<div>
														<label>Подтвердите пароль:</label>
													</div>
													<input class="text" type="password" maxlength="16" name="password_confirm" value="">
												</li>
												<li>
													<input class="btn btn-primary btn-lg mr10" type="submit" name="submit" value="ЗАРЕГИСТРИРУЙСЯ">
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
								<h3>Второй Шаг</h3>
								<i class="fa fa-play"></i>
							</div>	
							<div class="luck-reg flr" style="padding-top:50px;">
								<h3>Попробуйте Ваше Счастье</h3>
								<div class="turntable">
									<div class="tur-box">
									<div id="dowebok">
										<div class="plate pla-bg-ru"> </div>
										<?php if(Customer::logged_in()){?>
									    <a id="plateBtn" class="pla-play-ru" href="javascript:void();" title="Начать">Начать</a>
										<?php }else{?>
										<a id="plateBtnHide" class="pla-play-ru" href="javascript:void();" title="Начать">Начать</a>
									    <?php }?>
									</div>
										<div class="tur-user">
											<div class="tur-r-t">
												<b>Сегодняшний Счастливец</b>
												<p>Мы показываем только последние 100 победителей здесь.</p>
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
																	  $v['draw_name']='Бесплатный Подарок';
																	  break;
																	case 'Happy Every Day':
																	  $v['draw_name']='СЧАСТЛИВОГО';
																	  break;
																	case '5% Coupon':
																	  $v['draw_name']='5% Код';
																	  break;
																	case '10% Coupon':
																	  $v['draw_name']='10% Код';
																	  break;
																	case '$100 LUCKY BAG':
																	  $v['draw_name']='$100 СЧАСТЛИВАЯ СУМКА';
																	  break;
																	case '$50 GIFT CARD':
																	  $v['draw_name']='50$ ПОДАРОЧНАЯ КАРТА';
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
										<dt>Сообщение::</dt>
										<dd>1.Один ID, Один Шанс, чтобы играть в Игры.</dd>
										<dd>2.Choies оставляет за собой право на окончательное объяснение кампании.</dd>
										<dd>Любые вопросы, касающиеся кампании, пожалуйста, сообщите нам  через service_ru@choies.com</dd>
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
						<p class="bottom container-fluid">Copyright © 2006-2015 Choies.com&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a style="color: #ccc;" href="/ru/privacy-security" class="hidden-xs">Конфиденциальность И Безопасность</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a style="color: #ccc;" href="/ru/about-us" class="hidden-xs">О Нас</a>
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
							alert("Извините! Вы уже играли в эту игру!");
							break;
						case "689717":  
							var five = [ 170, 140];
							five = five[Math.floor(Math.random()*five.length)];
							rotateFunc(689717,five,'<div class="res-box"><div class="res-title">ПОЗДРАВЛЯЕМ! ВЫ ПОЛУЧИЛИ ОДИН<span> 5%</span> КОД!</div><div class="res-img"><img src="/assets/images/5code-ru.png"></div><div class="res-back"><a href="<?php echo LANGPATH;?>/customer/coupons">Мои Купоны</a><a href="<?php echo  LANGPATH;?>/" style="margin-left:20px;">Начать Купить ></a></div></div>');
							break;
						case "0": 
							var haveno = [ 90, 75];
							haveno = haveno[Math.floor(Math.random()*haveno.length)];
							rotateFunc(0,haveno,'<div class="res-box"><div class="res-title">СЧАСТЛИВОГО КАЖДЫЙ ДЕНЬ</div><div class="res-img" style="margin-top:8px;"><img src="/assets/images/smile.png"></div><div class="res-back" style="margin-top:8px;">Жаль!<br>Жаль! Нет Подарка но Наилучших Пожелания от <a href="<?php echo  LANGPATH;?>/">Choies.</a></div></div>');
							break;
						case "689721": 
							var FREE = [ 245, 290];
							FREE = FREE[Math.floor(Math.random()*FREE.length)];
							rotateFunc(689721,FREE,'<div class="res-box"><div class="res-title" style="height:19px;line-height:19px">ПОЗДРАВЛЯЕМ! ПОЗДРАВЛЯЕМ! ВЫ ПОЛУЧИЛИ ОДИН<span>Бесплатный Подарок!<span> </div><div class="res-img" style="margin-top:8px;"><img src="/assets/images/luck-ru.png"></div><div class="res-back" style="margin-top:8px;"><a href="<?php echo LANGPATH;?>/customer/coupons">Проверьте Подарочный Код в Свои Купоны</a><a href="<?php echo  LANGPATH;?>/" style="margin-left:20px;">СЕЙЧАС Начать Купить ></a></div></div>');
							break;
						case "689718": 
							var ten = [ 355, 310];
							ten = ten[Math.floor(Math.random()*ten.length)];
							rotateFunc(689718,ten,'<div class="res-box"><div class="res-title">ПОЗДРАВЛЯЕМ! ВЫ ПОЛУЧИЛИ ОДИН<span> 10%</span> Код!</div><div class="res-img"><img src="/assets/images/10code-ru.png"></div><div class="res-back"><a href="<?php echo LANGPATH;?>/customer/coupons">Мои Купоны</a><a href="<?php echo  LANGPATH;?>/" style="margin-left:20px;">Начать Купить ></a></div></div>');
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
                        required:"Пожалуйста, предоставьте электронное письмо.",
                        email:"Пожалуйста, введите правильный адрес электронной почты."
                    },
                    password: {
                        required: "Пожалуйста, укажите пароль.",
                        minlength: "Ваш пароль должен быть 5 символов.",
                        maxlength:"Пароль не превышает максимальную длину 20 символов."
                    },
                    password_confirm: {
                        required: "Пожалуйста, укажите пароль.",
                        minlength: "Ваш пароль должен быть 5 символов.",
                        maxlength:"Пароль не превышает максимальную длину 20 символов.",
                        equalTo: "Пожалуйста, введите тот же пароль, что и выше. "
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
						alert("Это  адрес электронной почты был зарегистрировано.");
						$(".umail").val("");
						return false;
					}
				})
			}
        </script>	
</body>
</html>