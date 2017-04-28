
		<style>

			.original-sale{
				color:#5a5a5a!important;
			}
			.pro-class ul{
				border-top:2px solid #be194c;
				position:relative;
			}
			.pro-class li{
				padding-top:10px;
				width:16.5%;
				float:left;
				padding-bottom:50px;
			}
			.pro-class li div{
				background-image:url("/assets/images/11-11.png");
				background-repeat:no-repeat;
				width:82px;
				height:100px;
				background-position-y:0;
				margin:0 auto;
				cursor:pointer;
			}
			.pro-class li.current div{
				background-position-y:-105px;
			}
			.pro-class .dresses{
				background-position-x:0;
				
			}
			.pro-class .dresses:hover{
				background-position:0 -105px;
			}
			.pro-class .tops{
				background-position-x:-82px;
				background-position:-82px 0;
			}
			.pro-class .tops:hover{
				background-position:-82px -105px;
			}
			.pro-class .outwear{
				background-position-x:-163px;
				background-position:-163px 0;
			}
			.pro-class .outwear:hover{
				background-position:-163px -105px;
			}
			.pro-class .bottoms{
				background-position-x:-243px;
				background-position:-243px 0;
			}
			.pro-class .bottoms:hover{
				background-position:-243px -105px;
			}
			.pro-class .shoes{
				background-position-x:-322px;
				background-position:-322px 0;
			}
			.pro-class .shoes:hover{
				background-position:-322px -105px;
			}
			.pro-class .accessories{
				background-position-x:-403px;
				background-position:-403px 0;
			}
			.pro-class .accessories:hover{
				background-position:-403px -105px;
			}
			.icon-11 p{
				 
		    height: 10px;
		    left:0;
		    overflow: hidden;
			margin:0;
		    position: absolute;
		    text-align: center;
		    top:0;
			width:16.5%;
			background:url(/assets/images/11-tip-1.png) no-repeat top center;
			height:10px;

			}
			.pro-class-phone li{
				padding-top:10px;
				width:16.5%;
				float:left;
			}
			.pro-class-phone li div{
				background-image:url("/assets/images/11-11.png");
				background-repeat:no-repeat;
				width:50px;
				height:50px;
				background-position-y:-216px;
				margin:0 auto;
				cursor:pointer;
			}
			.pro-class-phone .dresses{
				background-position-x:0;
				
			}
			.pro-class-phone .tops{
				background-position-x:-50px;
			}
			.pro-class-phone .outwear{
				background-position-x:-99px;
			}
			.pro-class-phone .bottoms{
				background-position-x:-148px;
			}
			.pro-class-phone .shoes{
				background-position-x:-198px;
			}
			.pro-class-phone .accessories{
				background-position-x:-248px;
			}
			.four-partake span.st_facebook_hcount{ display: none;}   
			</style>
		<!-- main begin -->
		<section id="main">
			
			<div class="container">
				<!-- crumbs -->
				<div class="crumbs">
						<a href="<?php echo LANGPATH;?>/">home</a> > singles day sale
				</div>
				<!-- -->
                <div class="sale-filter">
					<img src="/assets/images/11-11-fr-1.jpg">
				</div>
				<div class="nov-box">
					<div class="pro-class hidden-xs">
						<ul class="icon-11">
							<li class="current">
								<div class="dresses" data-id="1" onclick="acceptpc(this)"></div>
							</li>
							<li>
								<div class="tops" data-id="2" onclick="acceptpc(this)"></div>
							</li>
							<li>
								<div class="outwear" data-id="3" onclick="acceptpc(this)"></div>
							</li>
							<li>
								<div class="bottoms" data-id="4" onclick="acceptpc(this)"></div>
							</li>
							<li>
								<div class="shoes" data-id="5" onclick="acceptpc(this)"></div>
							</li>
							<li>
								<div class="accessories" data-id="6" onclick="acceptpc(this)"></div>
							</li>
							<p style="left:0;">
		                        <b></b>
		                    </p>
						</ul>	
					</div>
					<div class="pro-class-phone hidden-sm hidden-md hidden-lg">
						<ul class="icon-11">
							<li class="current">
								<div class="dresses" data-id="1" onclick="acceptpc(this)"></div>
							</li>
							<li>
								<div class="tops" data-id="2" onclick="acceptpc(this)"></div>
							</li>
							<li>
								<div class="outwear" data-id="3" onclick="acceptpc(this)"></div>
							</li>
							<li>
								<div class="bottoms" data-id="4" onclick="acceptpc(this)"></div>
							</li>
							<li>
								<div class="shoes" data-id="5" onclick="acceptpc(this)"></div>
							</li>
							<li>
								<div class="accessories" data-id="6" onclick="acceptpc(this)"></div>
							</li>
						</ul>	
					</div>
					<script>
					function acceptpc(obj){

						$(obj).ajaxSend( function(event, jqXHR, options){
						    $("#acceptpc").empty().append("<p><img src='/assets/images/gb_loading.gif' /></p>");
						});
						var data_id=$(obj).attr("data-id");
						$.post('/activity/11_11', {data_id:data_id}, function(re){
							var strVar = "";
							$.each(re,function(i,item){
								strVar += "<li class=\"pro-item col-xs-6 col-sm-3\">";
								strVar += "<div class=\"pic\">";
								strVar += "<a href='"+item.plink+"' target='_bank'>";
								strVar += "<img src='"+item.image+"' alt=\"\">";
								strVar += "<\/a>";
								strVar += "<\/div>";
								strVar += "<div class=\"title-11 mt5\">";
								strVar += "<a href=\""+item.plink+"\" target='_bank'>"+item.name+"<\/a>";
								strVar += "<\/div>";
								strVar += "<div class=\"original-sale mt5\">";
									strVar += "<span class=\"mr5\">Original Price: <del>"+item.orig_price+"<\/del><\/span>    <span>Sale Price: "+item.price+"<\/span>";
								
								strVar += "<\/div>";
								strVar += "<div class=\"price-11 mt5\">";
								strVar += "Double-11 Price:<b class=\"red\">"+item.discount_price+"<\/b>";
								strVar += "<\/div>";
								strVar += "<div class=\"partake-11 mt5\">";
								strVar += "<div class=\"four-partake\">";
								strVar += "<span class='st_pinterest_hcount' displayText='Pinterest'><\/span>";
								strVar += "<script type=\"text/javascript\" src=\"http://w.sharethis.com/button/buttons.js\"><\/script>";
								strVar += "<script type=\"text/javascript\">stLight.options({publisher: \"76c0dd88-6e79-4e80-875e-7bc8934145b8\", doNotHash: false, doNotCopy: false, hashAddressBar: false});<\/script>";
								strVar += "<span class='st_fblike_hcount' displayText='Facebook Like'><\/span>";
								strVar += "<span class='st_facebook_hcount' displayText='Facebook'><\/span>";
								strVar += "<\/div>";
								strVar += "<\/div>";
								strVar += "<div class=\"view-11 mt5\">";
							    strVar += "		<a class=\"mr5\" href='"+item.plink+"' target='_bank'> View Details<\/a><i class=\"fa fa-chevron-circle-right\"><\/i>";
							    strVar += "<\/div>";
								strVar += "</li>"
							})
							$("#acceptpc").empty().append(strVar);
						},"json")
						}
					</script>
					<div class="pro-list mt20">
						<ul class="row" id="acceptpc">
						
						<?php foreach ($data as $v){?>
							<li class="pro-item col-xs-6 col-sm-3">
								<div class="pic">
									<a href="<?php echo $v['plink'];?>" target='_bank'>
										<img src="<?php echo $v['image']?>" alt="">
									</a>
								</div>
								<div class="title-11 mt5">
									<a href="<?php echo $v['plink'];?>" target='_bank'><?php echo $v['name']?></a>
								</div>
								<div class="original-sale mt5">
									 <span class="mr5">Original Price: <del><?php echo $v['orig_price'];?></del></span>    <span>Sale Price: <?php echo $v['price'];?></span>
								</div>
								<div class="price-11 mt5">
									 Double-11 Price:<b class="red"> <?php echo $v['discount_price'];?></b>
								</div>
								<div class="partake-11 mt5">
									<div class="four-partake">
				                        <span class='st_pinterest_hcount' displayText='Pinterest'></span>
				                        <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
				                        <script type="text/javascript">stLight.options({publisher: "76c0dd88-6e79-4e80-875e-7bc8934145b8", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
				                        <span class='st_fblike_hcount' displayText='Facebook Like'></span>
				                        <span class='st_facebook_hcount' displayText='Facebook'></span>
				                    </div>
								</div>
								<div class="view-11 mt5">
									 <a class="mr5" href="<?php echo $v['plink'];?>" target='_bank'> View Details</a><i class="fa fa-chevron-circle-right"></i>
								</div>
							</li>
						<?php }?>
							
							
						</ul>
					</div>
				</div>
				<script>
				    $('.pro-class li').click(function(){
				        var liindex = $('.pro-class li').index(this);
				        $(this).addClass('current').siblings().removeClass('current');
				        var liWidth = $('.pro-class li').width();
				        $('.pro-class p').stop(false,true).animate({'left' : (liindex * liWidth)+ 'px'},300);
				    });
			    </script>
			</div>
			

		</section>
		