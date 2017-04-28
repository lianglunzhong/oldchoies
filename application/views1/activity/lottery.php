<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
	<link rel="stylesheet" href="/css/style.css">
    <script src="/js/jquery-1.8.2.min.js"></script>
    <style>
	    .lucky{
			border:2px solid #ffc1da;
			box-shadow: 0 5px 10px 5px #ffc1da;
			margin:0 auto;
			}
    	.lucky-tip h2{
			width:88%;
			margin:0 auto;
			font-family:Georgia, "Times New Roman", Times, serif;
			
			}
		.lucky h3{
			text-align:center;
			}
		.lucky p{
			width:88%;
			margin:0 auto;
			font-size:18px;
			line-height:35px;
			}
		.lucky form{
			background:url(/images/lottery/luck7.jpg) center no-repeat;
			}
		.lucky .sign-in{
			float:right;
			width:30%;
			}
		.lucky .sign-in input{
			display:inline-block;
			color:#fff;
			}
		.lucky form ul{
			width:50%;
			overflow:hidden;
			font-size:14px;
			}
		.lucky form li{
			float:left;
			margin: 5px 0;}
		.lucky form li:first-child{
			margin-top:30px;
			}
		.lucky form li:last-child{
			margin-top:20px;
			height:auto;
			}
		.lucky form .text{
			height:30px;
			}
		.lucky .btn-submit{
			display:block;
			margin:0 auto;
			border-radius:5px;
			background-color:#ed0404;
			}
		.lucky .ka{
			width:100%;
			}
		.lucky label{
			display:inline-block;
			width:15%;
			}
		.kaa{
			width:45%;
			}	
		.kadd {
			cursor: pointer;
			color: #000;
			text-decoration: underline;
		}
		.lucky input{
			display:inline-block;
			
			}
			
		.lucky form ul{
			width: 50%; 
			color: #000;			
			display: block;
			margin: 0 auto;
		}
		.lucky form ul li{
			width: 100%;
			padding:5px;
			height:30px;
			line-height:30px;
			}
			
		.gcom {
			border:1px solid #ababab;
			border-top:1px solid #ff6666;
			color:#fff;
			width:70%;
			margin:0 auto;
		}
		.gcom h3{
			background-color:#ff6666;
			line-height:20px;
			padding:10px 15px;
			font-size:18px;
			width: 100%;
			}
		.gcom_cont {
			margin-top: 10px;
			padding: 10px 8%;
		}
		.gcom_cont div{
			margin-bottom:10px;
			}
		.gcom_cont .bt {
			background-color: #ff6666;
			color: #fff;
			margin-right: 20px;
			padding: 2px 15px;
			font-size:16px;
		}
		.blue {
			color: #4998b9;
		}
		.gcom_cont p{
			background-color:#f3f2f2;
			width:100%;
			padding-left:10px;
			line-height:25px;
			word-break:break-all;
			}
		.gcom_cont p a {
			color: #2045fc;
			font-size:14px;
			
		
		}
		@media (max-width: 767px){
			    h2,.lucky h3{
					font-size:16px;
				}
				.lucky p{
				font-size:12px;
				line-height:20px;
				}
				.textarea1,.textarea2{
					width:90%;
				}
				.lucky .sign-in{
					width:100%;
					text-align:right;
					margin-bottom:15px;
				}
				.lucky form ul{
					width:100%;
				}
				.gcom{
					width:100%;
				}
		}
		@media (max-width: 991px)and (min-width:768px){
				.lucky .sign-in{
					width:40%;
				}
			}
    </style>
	</head>
<body>
	<div class="site-content">
    	<div class="main-container clearfix">
        	<div class="container">
        		<div class="lucky">
        			<div><img src="/images/lottery/lucky1.jpg"></div>
                    <div>
					<?php
					$user_session = Session::instance()->get('user');
					$domain = URLSTR;
					//判断用户是否登陆11
					if($user_session['id']){
					?>
						
					<?php
					}else{
					?>
                    	<p class="sign-in">
                    		<input type="button" style="background-color:#2dab0b;border-radius:3px;padding:3px 8px;line-height:22px;" id="singup" class="btn" value="SIGN UP"> or
                            <input type="button" style="background-color:#ff0000;border-radius:3px;padding:3px 8px;line-height:22px;" id="singin" class="btn" value="SIGN IN"> to ENTER
                   		</p>
					<?php
					}
					?>
                    </div>
                    <div><img src="/images/lottery/lucky6.jpg"></div>
                    
                    <div>
                    	<div class="lucky-tip">
                        <h2><i>To Choies’s fans:</i></h2>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;We are now invite you to join our activity. From <span class="red">Nov. 26 to Dec. 31</span>, anyone who shares the selling activities of our site in any social platforms will get a chance in our <span class="red">lucky draw</span>. You will get bigger chance if you shared in more social platforms.</p>
						<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Consider about the openness and fairness, please leave your shared link in the blank below, we will randomly choose the winners by the time at Dec. 8, Dec. 20 and Dec. 31. We also going to show up the winners the day after each lucky draw day.</p>
                        </div>
                      <div class="mt20 mb20"><img src="/images/lottery/lucky2.jpg"></div>
                        <ul>
                        	<li div class="col-sm-3 col-xs-6"><a href="/activity/flash_sale"><img src="/images/lottery/lucky-img1.jpg"></a><p>Share It to:<img src="/images/lottery/share-icon.jpg" usemap="#Map">
                                <map name="Map">
                                  <area shape="rect" coords="1,2,23,24" target="_blank" href="http://www.facebook.com/sharer.php?u=https%3A%2F%2F<?php echo $domain; ?>%2Factivity%2Fflash_sale" class="a1">
                                  <area shape="rect" coords="25,2,51,23" target="_blank" href="http://twitter.com/share?url=https%3A%2F%2F<?php echo $domain; ?>%2Factivity%2Fflash_sale">
                                  <area shape="rect" coords="51,1,81,30" target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo BASEURL ;?>/activity/flash_sale&media=http://cloud.choies.com/assets/images/lottery/lucky-img1.jpg&description=Vote To Get Rewarded!">
                                </map>
                        	</p>
                        	</li>
                            <li div class="col-sm-3 col-xs-6"><a href="/black-friday-c-469"><img src="/images/lottery/lucky-img2.jpg"></a><p>Share It to:<img src="/images/lottery/share-icon.jpg" usemap="#Map1">
                                <map name="Map1">
                                   <area shape="rect" coords="1,2,23,24" target="_blank" href="http://www.facebook.com/sharer.php?u=https%3A%2F%2F<?php echo $domain; ?>%2Fblack-friday-c-469" class="a1">
                                  <area shape="rect" coords="25,2,51,23" target="_blank" href="http://twitter.com/share?url=https%3A%2F%2F<?php echo $domain; ?>%2Fblack-friday-c-469">
                                  <area shape="rect" coords="51,1,81,30" target="_blank" href="http://pinterest.com/pin/create/button/?url=http://<?php echo BASEURL ;?>/black-friday-c-469&media=http://cloud.choies.com/assets/images/lottery/lucky-img2.jpg&description=Vote To Get Rewarded!">
                                </map>
                        	</p></li>
                            <li div class="col-sm-3 col-xs-6"><a href="/cyber-monday-c-484"><img src="/images/lottery/lucky-img3.jpg"></a><p>Share It to:<img src="/images/lottery/share-icon.jpg" usemap="#Map2">
                                <map name="Map2">
                                   <area shape="rect" coords="1,2,23,24" target="_blank" href="http://www.facebook.com/sharer.php?u=https%3A%2F%2F<?php echo $domain; ?>%2Fcyber-monday-c-484" class="a1">
                                  <area shape="rect" coords="25,2,51,23" target="_blank" href="http://twitter.com/share?url=https%3A%2F%2F<?php echo $domain; ?>%2Fcyber-monday-c-484">
                                  <area shape="rect" coords="51,1,81,30" target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo BASEURL ;?>/cyber-monday-c-484&media=http://cloud.choies.com/assets/images/lottery/lucky-img3.jpg&description=Vote To Get Rewarded!">
                                </map>
                        	</p></li>
                            <li div class="col-sm-3 col-xs-6"><a href="/dresses-for-party-season-c-850"><img src="/images/lottery/lucky-img4.jpg"></a><p>Share It to:<img src="/images/lottery/share-icon.jpg" usemap="#Map3">
                                <map name="Map3">
                                   <area shape="rect" coords="1,2,23,24" target="_blank" href="http://www.facebook.com/sharer.php?u=https%3A%2F%2F<?php echo $domain; ?>%2Fdresses-for-party-season-c-850" class="a1">
                                  <area shape="rect" coords="25,2,51,23" target="_blank" href="http://twitter.com/share?url=https%3A%2F%2F<?php echo $domain; ?>%2Fdresses-for-party-season-c-850">
                                  <area shape="rect" coords="51,1,81,30" target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo BASEURL ;?>/dresses-for-party-season-c-850&media=http://cloud.choies.com/assets/images/lottery/lucky-img4.jpg&description=Vote To Get Rewarded!">
                                </map>
                        	</p></li>
                        </ul>
                        <div class="mt20 mb20"><img src="/images/lottery/lucky3.jpg"></div>
                        <h3><i>Make sure you leave the right share links and submit:</i></h4>
                        <form action="#" method="post" id="textlink">
                        	<ul>
                                <li><label>Name：</label><input type="text" class="text kaa" id="username"></li>
                                <li><label id="namenull" style="display:none">The information can't submit by empty!</label></li>
                                <li style="color:#ff1111;height:auto;">Share URL/Links ( More share links, more chances to win.)</li>
                                <li><input type="url" class="text ka"></li>
                                <li><input type="url" class="text ka"></li>
                                <li><input type="url" class="text ka"></li>
                                <li class="kadd "><strong>+ Add one more link</strong></li>
                                <li><input type="submit" class="btn btn-primary btn-lg btn-submit" value="SUBMIT"></li>
                        	</ul>
						</form>
						<p id="lotterystatus" style="text-align:center;display:none;color:red">Thanks for your support, you are now participate in the lucky draw!</p>
						<?php
						//echo "<pre>";
						//print_r($data);
						//echo "</pre>";
						?>
						<!--展示数据-->
                        <div class="mt20 mb20"><img src="/images/lottery/lucky4.jpg"></div>
                       <div class="gcom">

                         <h3 style="font-family:Georgia, 'Times New Roman', Times, serif;"><i><img src="/images/lottery/icon.png">Everyone who participate in this activity will get an 5% discount, our end will automatic add the discount on your Choies’s account.</i></h3>
                          <?php
							if(!empty($data)){
								foreach($data as $k=>$v){
							?>
							<div class="gcom_cont">
                            <div><span class="bt"><?php echo $v['username'];?></span><span style="color:black;"><?php echo $v['created'];?></span></div>
							<?php
								foreach($v['link'] as $link_id){
							?>
                            <p><a href="javascript:void(0)"><?php echo $link_id?></a></p>
							<?php
							}
							?>
                          </div>	
							<?php
							}
							}
						  ?>
						  
                          
                      </div>
						<p><img src="/images/lottery/lucky5.jpg"> </p>
                    </div>
					<!--分页-->
                    <div class="gcom_page">
                            <?php echo $pagination; ?>
					</div>
        		</div>
        	</div>
        </div>
    </div>
</body>
</html>
<script>
 $(function(){
	  $(".kadd").click(function(){
	  var add = '<li><input type="url" class="text ka"></li>';
	  $(".kadd").before(add);
	  })
	  });
</script>
<script>
$("#singup").click(function(){
	window.location.href="<?php echo LANGPATH;?>/customer/login?redirect=/activity/lottery";
});
$("#singin").click(function(){
	window.location.href="<?php echo LANGPATH;?>/customer/login?redirect=/activity/lottery";
});
$("#textlink").submit(function(){
			var name=$("#username").val();
			var link=new Array();
			$(this).find(".ka").each(function(){
				//link=$(this).val();
				link.push($(this).val());
			});
			if(name==''){
				alert("Name can not be empty!");
				return false;
			}
			 $.ajax({
				type:"post",
				url : '/activity/lotterylink',
				data: {name:name,link:link},
				dataType: "json",
				success: function(data){
					console.log(data);
					if(data['success']==1){
						$("#lotterystatus").show();
						return false;
					}else if(data['success']==-1){
						alert("You already paticipated in activity!");
						return false;
					}else if(data['success']==-2){
						alert("The links limited by Ten!");
						return false;
					}else if(data['success']==-3){
						alert("Please Log in, thanks!");
						window.location.href="<?php echo LANGPATH;?>/customer/login?redirect=/activity/lottery";
						return false;
					}else if(data['success']==-4){
						alert("The information can't submit by empty!");
						return false;
					}else if(data['success']==11){
						alert("coupon error!");
						return false;
					}else if(data['success']==12){
						alert("coupon error!");
						return false;
					}else{
						alert("Unknown Error!");
						return false;
					}
					
				}
			}); 
			return false;
		});
		
</script>