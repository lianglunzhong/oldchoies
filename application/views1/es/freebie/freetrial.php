<script type="text/javascript" charset="utf-8" src="chrome-extension://cpngackimfmofbokmjmljamhdncknpmg/page_context.js"></script>
<link type="text/css" rel="stylesheet" href="chrome-extension://cpngackimfmofbokmjmljamhdncknpmg/style.css">
<div id="fb-root"></div>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
<?php $fb_api_id = Site::instance()->get('fb_api_id'); ?>
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo $fb_api_id; ?>";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script type="text/javascript">
/* time left */
var startTime = new Date();
startTime.setFullYear(<?php echo date('Y, m, d', $timeto); ?>);
startTime.setHours(15);
startTime.setMinutes(59);
startTime.setSeconds(59);
startTime.setMilliseconds(999);
var EndTime=startTime.getTime();
function GetRTime(){
        var NowTime = new Date();
        var nMS = EndTime - NowTime.getTime();
        var nD = Math.floor(nMS/(1000 * 60 * 60 * 24));
        var nH = Math.floor(nMS/(1000*60*60)) % 24;
        var nM = Math.floor(nMS/(1000*60)) % 60;
        var nS = Math.floor(nMS/1000) % 60;
        if(nD<=9) nD = "0"+nD;
        if(nH<=9) nH = "0"+nH;
        if(nM<=9) nM = "0"+nM;
        if(nS<=9) nS = "0"+nS;
        if (nMS < 0){
                $(".JS_dao").hide();
                $(".JS_daoend").show();
        }else{
                $(".JS_dao").show();
                $(".JS_daoend").hide();
                $(".JS_RemainD").text(nD);
                $(".JS_RemainH").text(nH);
                $(".JS_RemainM").text(nM);
                $(".JS_RemainS").text(nS); 
        }
}
	
$(document).ready(function () {
        var timer_rt = window.setInterval("GetRTime()", 1000);
});
</script>
<script async="true" type="text/javascript">
window.fbAsyncInit = function() {
    FB.init( {
        appId : '<?php echo $fb_api_id; ?>',
        status : true,
        cookie : true,
        xfbml : true,
        oauth : true
    });
};

(function() {
    var e = document.createElement('script');
    e.async = true;
    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo $fb_api_id; ?>';
    document.getElementById('fb-root').appendChild(e);
}());
var facebook_fan = 0;
function fbLoginBegin(status) {

    FB.login(function(response) {
        if (response.authResponse) {
            var fbuid = response.authResponse.userID;
            var fbtoken = response.authResponse.accessToken;
            facebook_fan = 0;
            FB.api(
            {
                method : 'fql.query',
                query : 'SELECT uid,page_id FROM page_fan WHERE page_id =277865785629162 and uid=' + fbuid
            }, function(rep) {
                if(rep.length != 0){
                    facebook_fan = 1;
						
                }
                FB.api(
                {
                    method : 'fql.query',
                    query : 'select first_name,last_name,email from user where uid=' + fbuid
                }, function(rep) {
                    var fname = rep[0].first_name;
                    var lname = rep[0].last_name;
                    var fbEmail = rep[0].email;//alert(facebook_fan);
                    fbLogin(fbuid,fbtoken,fname,lname,fbEmail,status,facebook_fan);
                });
            });
		
		
	  	
		
		
        } else {
            return;
        }
    }, {
        scope : 'email,user_likes,friends_likes'
    }	);
}

function fbLogin(fbuid,fbtoken,fname,lname,fbEmail,status,facebook_fan){
    if(parseInt(fbuid)){
        $.ajax({
            type:'POST',
            dataType:'json',
            async:false,
            data:'act=facebook&facebook_id='+fbuid+'&email='+fbEmail+'&fname='+fname+'&lname='+lname+'&facebook_fan='+facebook_fan,
            url:'facebook_login.php',
            fail:function(){
                //alert('fail');
            },
            error:function(){
                //alert('error');
            },
            success:function(json){
                if(json==1){
                    if(status=="checkout"){
                        location.href='checkout.php?action=sel_address';
                    }else if(status=="simple"){
                        location.href='login_register.php?return=wishList';
                    }else{
                        location.href='member_order.php?action=list&msg=Welcome Back.';
                    }
				
                }else if(json==2){
                    if(status=="checkout"){
                        location.href='checkout.php?action=sel_address';
                    }else if(status=="simple"){
                        location.href='login_register.php?return=wishList';
                    }else{
                        location.href='member_order.php?action=list&msg=You have successfully logged in.';
                    }
                }else{
                    alert('Login error,please try again');
                }
            }
        })
    }
}
function show_facebook_div(goods_id,type) {
    FB.login(function(response) {
        if (response.authResponse) {
            var fbuid = response.authResponse.userID;
            var fbtoken = response.authResponse.accessToken;
			
            FB.api({
                method : 'fql.query',
                query : 'SELECT uid,page_id FROM page_fan WHERE page_id =277865785629162 and uid=' + fbuid
            }, function(rep) {
                $.ajax({
                    type:'POST',
                    dataType:'json',
                    async:false,
                    url:'<?php echo LANGPATH; ?>/freetrial/facebook_share',
                    data:'action=1&goods_id='+goods_id+'&type='+type,
                    success:function(result){
                        if(result.status==2||result.status==1){
                            var a = true;
                            if(result.status==2){
                                a = confirm('You have already shared this item,are you sure you want to share it one more time?');
                            }
                            if(a){
                                if(rep.length != 0){
                                    $("#facebook_input_goods_id").val(goods_id);
                                    $("#facebook_input_comment").val('');
                                    $("#trial_facebook_like_error").hide();
                                    $("#share1").show();
                                }else{
                                    $("#trial_facebook_like_error").show();
                                    $("#facebook_input_goods_id").val(goods_id);
                                    $("#facebook_input_comment").val('');
                                    $("#share").show();
                                }
                            }
                        }else if(result.status==3){
                            alert("Login error,please try again");
                            return false;
                        }
						
                    }
                })
				
            });
        } else {
            alert("Login error,please try again");
            return false;
        }
    }, {
        scope : 'email,publish_actions,publish_stream,user_likes,friends_likes'
    });

}	
function set_facebook_share() {
    var con_ent  = $.trim($("#facebook_input_comment").val());
	
    var goods_id = parseInt($("#facebook_input_goods_id").val());
	
    if (con_ent.length < 20) {
        $("#post_facebook_error").html("Your comment has no less than 20 characters.");
        $("#post_facebook_error").show();
        return false;
    }else if(goods_id == 0 || isNaN(goods_id)){
        $("#post_facebook_error").html("This product does not exist.");
        $("#post_facebook_error").show();
        return false;
    }else{
        $("#post_facebook_error").html("");
        $("#post_facebook_error").hide();
    }
    show_facebook_close();
    FB.login(function(response) {
        if (response.authResponse) {
            var fbuid = response.authResponse.userID;
            var fbtoken = response.authResponse.accessToken;
			
            FB.api({
                method : 'fql.query',
                query : 'SELECT uid,page_id FROM page_fan WHERE page_id =277865785629162 and uid=' + fbuid
            }, function(rep) {
                if(rep.length != 0){
					
                    con_ent=encodeURIComponent(con_ent);
                    //alert('action=facebook_share_to_get_discount&rec_id='+rec_id+'&goods_id='+goods_id+'&message='+con_ent);
                    //					return false;
                    $.ajax({
                        type:"POST",
                        dataType:'json',
                        async:false,
                        url:'<?php echo LANGPATH; ?>/freetrial/facebook_share',
                        data:'action=2&goods_id='+goods_id+'&message='+con_ent,
                        success:function(result){
                            if(result.status==4){
                                $("#share").hide();
                                $("#share1").hide();
                                $("#share2").show();
                                return false
                            }
                            else
                            {
                                alert(result.message);
                                return false;
                            }
                        }
                    })
                }else{
                    //alert("You have to like first(Step 1).");
                    if(type == 1){
                        $("#erial_h2_1").hide();
                    }else{
                        $("#erial_h2_2").hide();
                    }						
                    $(".trial_body").show();
                    return false;
                }
            });
        } else {
            alert("Login error,please try again");
            return false;
        }
    }, {
        scope : 'email,publish_actions,publish_stream,user_likes,friends_likes'
    });
}
function show_facebook_close() {
    $("#share").hide();
    $("#share1").hide();
    $("#share2").hide();
}
function show_facebook_div_to(){
    var goods_id =  $("#facebook_input_goods_id").val();
    //alert(goods_id);
    show_facebook_div(goods_id);
}
function hide_face_share_bg(){
    $(".face_share_bg").hide();
}
</script>

		<section id="main">
			<!-- crumbs -->
			<div class="container">
				<div class="crumbs">
					<div>
						<a href="<?php echo LANGPATH; ?>/">home</a> > free trial
					</div>
					<div class="back visible-xs-inline hidden-sm hidden-md hidden-lg">&lt;&lt;&nbsp;<a class="back" href="window.history.back()">Volver</a>
					</div>
				</div>
			</div>
			<!-- main begin -->
				<section class="container">
					<p class="hidden-xs">
						<img src="/assets/images/freetrial/banner_freetrial.jpg" />
					</p>
					<div class="trial-winners col-xs-12">
						<h3>Last Week's Winners</h3>
						<ul>
                    <?php
                    foreach ($winners as $key => $winner):
                        ?>
							<li class="col-sm-4 col-xs-12"><?php echo $winner; ?></li>
                        <?php
                    endforeach;
                    ?>
						</ul>
						<p><a class="a-red" title="Mail to Lisa" href="mailto:lisaconnor@choies.com">Lisa</a> will contact you later with the details.
						</p>
					</div>

					<!-- report_details -->
            <?php
            foreach ($products as $k => $pid):
                $product = Product::instance($pid);
                $link = $product->permalink();
                ?>
					<div class="report-details row">
						<div class="report-left JS_imgbox col-sm-5 col-xs-12">
							<em class="chances chances<?php echo trim($chances[$k]); ?>"></em>
							<div class="pro-img">
								<a href="<?php echo $link; ?>" target="_blank">
									<img class="JS_pro_img" src="<?php echo Image::link($product->cover_image(), 2); ?>" style="display: inline;">
								</a>
							</div>
							<div class="pro-small row">
								<div class="pro-items">
									<ul class="JS_pro_small">
                                    <?php
                                    $key = 0;
                                    foreach ($product->images() as $image):
                                        $key++;
                                        if ($key > 4)
                                            break;
                                        ?>
										<li class="col-xs-3 <?php if ($key == 1) echo 'current'; ?>">
											<a href="<?php echo LANGPATH; ?>/"><img src="<?php echo Image::link($image, 3); ?>" imgb="<?php echo Image::link($image, 2); ?>"/></a>
										</li>
                                        <?php
                                    endforeach;
                                    ?>
									</ul>
								</div>
							</div>
						</div>
                    <div id="<?php echo $pid; ?>"></div>
						<div class="report-right col-sm-6 col-xs-12 col-sm-offset-1">
							<h3><a href="<?php echo $product->permalink(); ?>"><?php echo $product->get('name'); ?></a></h3>
							<dl>
								<dt>
					                <span class="left col-md-4 col-sm-12">FREE TRIAL</span>
					                <!-- time left -->
					                <div class="timeleft-box col-md-8 col-sm-12">
					                  <div class="JS_daoend hide">Time Over!</div>
					                  <div class="JS_dao">Time left: <strong class="JS_RemainD"></strong>d : <strong class="JS_RemainH"></strong>h : <strong class="JS_RemainM"></strong>m : <strong class="JS_RemainS"></strong>s</div>
					                </div>
				                </dt>
								<dd class="col-xs-12">
									<ul class="price">
										<li><span>Price: <del><?php echo Site::instance()->price($product->price(), 'code_view'); ?></del></span>
											<label class="f00">$0.00</label>
										</li>
										<li><span>Shipping fee:</span>
											<label class="f00">$0.00</label>
										</li>
										<li class="m"><span><em class="f00"><?php echo $chances[$k]; ?></em> Chances<?php echo $chances[$k] > 1 ? 's' : ''; ?></span>
											<label><em class="f00"><?php echo $quantitys[$pid]; ?></em> Applications</label>
										</li>
										<li><a href="javascript:;" onclick="show_facebook_div('<?php echo $pid; ?>','1');" class="btn btn-primary btn-sm">apply for free</a><span class="share flr"><a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php  echo urlencode($product->permalink()); ?>" class="a1"></a>                                   <a target="_blank" href="http://twitter.com/share?url=<?php echo urlencode($product->permalink()); ?>" class="a2"></a>
                                            <a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($product->permalink()); ?>&media=<?php echo Image::link($product->cover_image(), 1); ?>&description=<?php $product->get('name'); ?>" class="a3"></a></span>
										</li>
									</ul>
								</dd>
								<dt class="col-xs-12">EAGER TO GET</dt>
								<dd class="col-xs-12">
									<p>Can't wait to Get One?</p>
									<p><a href="<?php echo $link; ?>" class="btn btn-primary btn-sm">buy now</a>
									</p>
								</dd>
								<dt class="col-xs-12">DESCRIPTION:</dt>
								<dd class="col-xs-12">
									<dl>
										<dt>Details:</dt>
									<dd>
                                        <?php
                                        $description = $product->get('description');
                                        $description = str_replace(';', '<br>', $description);
                                        echo $description;
                                        ?>
                                    </dd>
									</dl>
									<dl>
										<dt>Size:</dt>
									<dd>
                                        <?php
                                        $brief = $product->get('brief');
                                        $brief = str_replace(';', '<br>', $brief);
                                        echo $brief;
                                        ?>
                                    </dd>
									</dl>
								</dd>
							</dl>
						</div>
					</div>
				<?php
                if ($k < count($products) - 1)
                    echo '<div class="hr"></div>';
            endforeach;
            ?>

					
					<!-- trial_report -->
					<div class="trial-report">
						<h2>Winners' Feedbacks</h2>
						<ul class="trial-report-listcon">
                    <?php
                    if (!empty($reports)):
                        $domain = Site::instance()->get('domain');
                        foreach ($reports as $report):
                            ?>
							<li class="col-sm-3 col-xs-6">
								<a href="<?php echo LANGPATH; ?>/freetrial/reports/<?php echo $report['id']; ?>">
									<img src="<?php echo 'http://img.choies.com/simages/' . $report['image']; ?>">
								</a>
								<h3><?php echo $report['name']; ?></h3>
								<a href="<?php echo LANGPATH; ?>/freetrial/reports/<?php echo $report['id']; ?>" class="name"><?php echo strlen($report['comments']) > 60 ? substr($report['comments'], 0, 60) . ' ...' : $report['comments']; ?></a>
								<a href="<?php echo LANGPATH; ?>/freetrial/reports/<?php echo $report['id']; ?>" class="btn btn-primary btn-xs">View Details</a>
							</li>
                            <?php
                        endforeach;
                    endif;
                    ?>
						</ul>
						<div class="bottom"><a href="<?php echo LANGPATH; ?>/freetrial/reports">view more >></a>
						</div>
					</div>
				</section>
		</section>
		<!-- footer begin -->

		<!-- gotop -->
		<div id="gotop" class="hide">
			<a href="#" class="xs-mobile-top"></a>
		</div>

		<script>
			 /* pro_img */
		    jQuery.fn.loadthumb = function(options) {
		        options = $.extend({
		            src : ""
		        },options);
		        var _self = this;
		        _self.hide();
		        var img = new Image();
		        $(img).load(function(){
		            _self.attr("src", options.src);
		            _self.fadeIn("slow");
		        }).attr("src", options.src); 
		        return _self;
		    }
		    $(".JS_pro_small li").live("click",function(){
		        var src = $(this).find("img").attr("imgb");
		        var bigimgSrc = $(this).find("img").attr("bigimg");
		        $(this).parents(".JS_imgbox").find(".JS_pro_img").loadthumb({
		            src:src
		        }).attr("bigimg",bigimgSrc);
		        $(this).addClass("current").siblings().removeClass("current");
		        return false;
		    });
		    $(".JS_pro_small li:nth-child(1)").trigger("click");
			            
			/* time left */
			var startTime = new Date();
			startTime.setFullYear(2015, 04, 05);
			startTime.setHours(15);
			startTime.setMinutes(59);
			startTime.setSeconds(59);
			startTime.setMilliseconds(999);
			var EndTime=startTime.getTime();
			function GetRTime(){
			        var NowTime = new Date();
			        var nMS = EndTime - NowTime.getTime();
			        var nD = Math.floor(nMS/(1000 * 60 * 60 * 24));
			        var nH = Math.floor(nMS/(1000*60*60)) % 24;
			        var nM = Math.floor(nMS/(1000*60)) % 60;
			        var nS = Math.floor(nMS/1000) % 60;
			        if(nD<=9) nD = "0"+nD;
			        if(nH<=9) nH = "0"+nH;
			        if(nM<=9) nM = "0"+nM;
			        if(nS<=9) nS = "0"+nS;
			        if (nMS < 0){
			                $(".JS_dao").hide();
			                $(".JS_daoend").show();
			        }else{
			                $(".JS_dao").show();
			                $(".JS_daoend").hide();
			                $(".JS_RemainD").text(nD);
			                $(".JS_RemainH").text(nH);
			                $(".JS_RemainM").text(nM);
			                $(".JS_RemainS").text(nS); 
			        }
			}
				
			$(document).ready(function () {
			        var timer_rt = window.setInterval("GetRTime()", 1000);
			});
		</script>
