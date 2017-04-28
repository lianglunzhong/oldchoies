<style>
	.emallmain{
		width:715px;
		margin:0 auto;
	}
	.emallmain .special-prize{
		 margin:25px 0;
		 line-height: 46px; 
		 border-bottom:1px solid #000;
		 font-size:28px;
		 text-align: center; 
		 font-weight: normal;
	}
	.s-box{
		width: 400px;
		margin: 20px auto;
		
	}
	.special-sign-in{
		background-color: #f4f4f4;
		overflow: hidden;
	}
	.s-box h4{
		line-height: 30px;
		font-size: 24px;
		text-align: center; 
		font-weight: normal;
		color:#333;
	}
	.submit-box{
		width: 650px;
		margin: 30px auto;
	}
	.sumbit-list li{
		display: block;
		font-size:16px;
		margin-bottom: 40px;
	}
	.sumbit-list li .ur-title{
		margin-bottom: 15px;
		font-weight: bold;
		font-size: 18px;
	}
	.sumbit-list li .ur-inputs label{
		display: block;
		margin-bottom: 15px;
	}
	.survery{
		width: 700px;
		margin: 30px auto;
		color:#333;	
	}
	.survery p{ 
		text-align: center;
		line-height: 30px;
	}
	.survery-15 a{
		width:300px; 
		height:40px; 
		line-height:40px; 
		border:2px solid #990000; 
		color:#cc0000;
		font-size:28px; 
		display:inline-block; 
		margin:20px 0;
	}
	.survery-15 a:hover{
		background-color:#990000;
		color:#fff;
		text-decoration: none;
	}
</style>


	<section id="main">
		<article class="layout">
				<?php
                $over = 0;
                $customer_id = Customer::logged_in();
                if ($over OR !$customer_id)
                {
                    ?>
					<div class="banner">
						<a class="JS_popwinbtn" href="">
							<img src="/images/3-24banner.jpg">
						</a>
					</div>
					<div class="emallmain">
						<h3 class="special-prize">
							PRIZE
						</h3>
						<div class="fix mb25">
							<a class="fll" href=""><img src="/images/100free.jpg"></a>
							<a class="flr" href=""><img src="/images/15off.jpg"></a>
						</div>					
					</div>
					<?php
                }
                else
                {
                    ?>
                    <div class="banner">
						<a href="">
							<img src="/images/3-24banner1.jpg">
						</a>
					</div>
					<div class="emallmain">
						<div class="submit-box fix">
						<form action="/activity/after_sale_questionnaire" method="post" class="form" id="questionForm">
							<ul class="sumbit-list">
								<li>
									<div class="ur-title">
										1. Have you received your parcel on time?
									</div>
									<div class="ur-inputs">
										<label>  
											<input class="ur-radio" type="radio"  name="q1" value="YES"> YES      
										</label>
										<label>  
											<input class="ur-radio" type="radio"  name="q1" value="NO"> NO     
										</label>
									</div>
								</li>
								<li>
									<div class="ur-title">
										2. Are you satisfied with the items you got?
									</div>
									<div class="ur-inputs">
										<label>  
											<input class="ur-radio" type="radio"  name="q2" value="YES"> YES      
										</label>
										<label>  
											<input class="ur-radio" type="radio"  name="q2" value="NO"> NO     
										</label>
									</div>
								</li>
								<li>
									<div class="ur-title">
										3. Is Choies Service Team helpful to you?
									</div>
									<div class="ur-inputs">
										<label>  
											<input class="ur-radio" type="radio"  name="q3" value="YES"> YES      
										</label>
										<label>  
											<input class="ur-radio" type="radio"  name="q3" value="NO"> NO     
										</label>
									</div>
								</li>
								<li>
									<div class="ur-title">
										4. What makes you shop form Choies?
									</div>
									<div class="ur-inputs">
										<label>  
											<input class="ur-radio" type="radio"  name="q4" value="Reasonable Price"> Reasonable Price      
										</label>
										<label>  
											<input class="ur-radio" type="radio"  name="q4" value="NO"> Fabulous Styles     
										</label>
										<label>  
											<input class="ur-radio" type="radio"  name="q4" value="NO"> Free Shipping Worldwide     
										</label>
										<label>  
											<input class="ur-radio" type="radio"  name="q4" value="NO"> Good Customer Service     
										</label>
									</div>
								</li>
								<li>
									<div class="ur-title">
										5. What would make you shop more often from Choies?
									</div>
									<div class="ur-inputs">
										<label>  
											<textarea name="q5" value="" style="width:100%; height:80px"></textarea>     
										</label>
									</div>
								</li>
								<li style="text-align:center;">
									<div class="ur-title">
										<input type="submit" value="SUBMIT" name="submit" class="btn40_16_red mr10">
									</div>
									<div class="ur-inputs STYLE1">
										Please complete all the questions above.							</div>
								</li>
							</ul>
						</div>
					</div>
					<script>
                $("#questionForm").validate({
                    rules: {
                        q1: {
                            required: true
                        },
                        q2: {
                            required: true
                        },
                        q3: {
                            required: true
                        },
                        q4: {
                            required: true
                        },
                        q5: {
                            required: true
                        }
                    }
                });
                                        
                    </script>
					<?php
                }
                ?>
		</article>	
	</section>
	
	

<div class="JS_popwincon popwincon w_p30 hide" style="margin-left:-405px;">
	<a class="JS_close1 close_btn2"></a>
	<div class="special-sign-in">
		<div class="s-box fix">
			<h4 class="mb25">Please sign in fist.</h4>
			<form action="/customer/login?redirect=<?php echo Request::instance()->uri;?>" method="post" class="signin_form sign_form form">
                <input type="hidden" name="referer" value="<?php echo BASEURL ;?>/">
                <ul>
                    <li>
                        <label>Email address: </label>
                        <input style="width:400px;" type="text" value="" name="email" class="text">
                    </li>
                    <li>
                        <label>Password: </label>
                        <input style="width:400px;" type="password" value="" name="password" class="text" maxlength="16">
                    </li>
                    <li><input type="submit" value="Sign In" name="submit" class="btn30_14_black mr10"><a href="<?php echo BASEURL ;?>/customer/forgot_password" class="text_underline">Forgot password?</a></li>
                </ul>
            </form>
		</div>
	</div>
</div>