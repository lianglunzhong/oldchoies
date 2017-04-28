<link type="text/css" href="/css/sharewin.css" rel="stylesheet">
<style>
.pname{width: 240px;height: 30px;}
.s5 li{margin-right:15px;}
</style>
<div id="fb-root"></div>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
<?php $fb_api_id = Site::instance()->get('fb_api_id'); ?>
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo $fb_api_id; ?>";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php
    date_default_timezone_set("Asia/Shanghai"); 
    $week = date('w');
    if($week<=2){
        $next_week=strtotime(date("Y-m-d",strtotime('this tuesday')));
    }else{
        $next_week=strtotime(date("Y-m-d",strtotime('+1 week last tuesday')));
    }
    if($week==2&&date("H")>=16){
      $next_week=strtotime(date("Y-m-d",strtotime('+1 week last tuesday')));
    }
    $end_day = strtotime("-1 months", $next_week);
?>
<script type="text/javascript">
/* time left */
var startTime = new Date();
startTime.setFullYear(<?php echo date('Y,m,d',$end_day); ?>);
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
        scope : 'email,user_likes,user_friends'
    } );
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
    $(".JS_filters").remove();
    $('.share1').fadeOut(160);
    var goods_id=$("#facebook_input_goods_id").val();
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
                    url:'/sharewin/facebook_share',
                    data:'action=1&goods_id='+goods_id+'&type='+type,
                    success:function(result){
                        if(result.status==2||result.status==1){
                            if(result.status==2){
                                alert("Sorry, you have already shared this item!");
                                return false;
                            }else{
                                if(rep.length != 0){
                                    $("#facebook_input_goods_id").val(goods_id);
                                    $("#facebook_input_comment").val('');
                                    $("#trial_facebook_like_error").hide();
                                    $('body').append('<div class="JS_filters opacity"></div>');
                                    $('#share1').appendTo('body').fadeIn(320);
                                    $('#share1').show();
                                }else{
                                    $("#trial_facebook_like_error").show();
                                    $("#facebook_input_goods_id").val(goods_id);
                                    $("#facebook_input_comment").val('');
                                    alert("You have to like first(Step 1).");
                                    return false;
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
        scope : 'email,publish_actions,publish_actions,user_likes,user_friends'
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
                    //          return false;
                    $.ajax({
                        type:"POST",
                        dataType:'json',
                        async:false,
                        url:'/sharewin/facebook_share',
                        data:'action=2&goods_id='+goods_id+'&message='+con_ent,
                        success:function(result){
                            if(result.status==4){
                                $("#share").hide();
                                $("#share1").hide();
                                $('body').append('<div class="JS_filters opacity"></div>');
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
        scope : 'email,publish_actions,publish_actions,user_likes,user_friends'
    });
}
function show_facebook_close() {
    $(".JS_filters").remove();
    $("#share").hide();
    $("#share1").hide();
    $("#share2").hide();
}
function show_facebook_div_to(id){
    var top = getScrollTop();
    $("#facebook_input_goods_id").val(id);
    $('body').append('<div class="JS_filters opacity"></div>');
    $('.share1').appendTo('body').fadeIn(320);
    $('.share1').show();
}
function hide_face_share_bg(){
    $(".face_share_bg").hide();
}
</script>
<section id="main">
  <!-- crumbs -->
  <div class="layout">
    <div class="crumbs fix">
      <div class="fll"><a href="/">Home</a>  >  SHARE AND WIN</div>
      <div class="flr"></div>
    </div>
  </div> 
  <section class="layout fix">
    <div><img src="/images/share_01.jpg" height="282px" width="1024px" /></div>
    <script type="text/javascript" >
 
  $(function(){
      var $div_li =$("div.tab_menu ul li");
      $div_li.click(function(){
      $(this).addClass("selected")           
           .siblings().removeClass("selected");   
            var index =  $div_li.index(this);   
      $("div.tab_box > div")     
          .eq(index).show()   
          .siblings().hide();  
    }) 
  })
 
</script>  
    <div class="tab mt20">
      <div class="tab_menu">
        <ul>
          <li class="selected">Most Wanted This Week</li>
          <li>Top 10 Most Wanted</li>
          <!--<li>Winners' Feedback</li>-->
          <li>Terms & Conditions</li>
        </ul>
      </div>
      <div class="tab_box"> 
         <div class="swrapp">
           <div class="fll">
             <h3>MOST WANTED THIS WEEK</h3>
             <div class="s4">
             <ul>
             <?php foreach($products as $val){
            $pid=$val['product_id'];
            $qty=$val['qty'];
              $product = Product::instance($pid);
              if($product->get('id')){
                $link = $product->permalink();
                $p_price = $product->get('price');
                $price=$product->price();
              ?>
               <li>
                 <div><a href="<?php echo $link; ?>"><img src="<?php echo Image::link($product->cover_image(), 2); ?>" width="240px" height="320px" /></a></div>
                 <div class="mt10 pname"><?php echo substr($product->get('name'),0,75); ?></div>
                 <div class="mt10 smi">
                   <p><strong><?php echo $qty; ?></strong> have shared it!</p>
                   <p>Want to get it FREE?</p>
                   <p class="mt10"><a href="javascript:;" onclick="show_facebook_div_to('<?php echo $product->get('id'); ?>');"><img src="http://www.choies.com/images/share_fb.jpg"/></a></p>
                   <div class="timeleft_box mt10">
                                <div class="JS_daoend hide">Time Over!</div>
                                <div class="JS_dao">Time left: <strong class="JS_RemainD"></strong> d : <strong class="JS_RemainH"></strong> h : <strong class="JS_RemainM"></strong> m : <strong class="JS_RemainS"></strong>s</div>
                   </div>
                 </div>
                 <div class="mt10" style="height:105px">
                  <p>Or get it right away!</p>
                  <p class="price fix"><b><?php echo Site::instance()->price($product->price(), 'code_view'); ?></b>
                  <?php 
                    if ($p_price > $price){ 
                    $rate =  round((($p_price - $price) / $p_price) * 100);
                  ?><del><?php echo Site::instance()->price($p_price, 'code_view'); ?></del><br><span class="off"><?php echo $rate; ?>% off</span>
                  <?php }else{ ?>
                  <del></del><br><span class="off">&nbsp;</span>
                  <?php } ?>
                  </p>
                  <p class="sbuy"><a href="<?php echo $link; ?>">BUY IT NOW</a></p>
                 </div>
               </li> 
               <?php }} ?>              
             </ul>
             </div>
           </div>
           <div class="fll">
             <h3><i>Winners' List</i></h3>
             <div class="fbr ">
               <div class="prize_info">Every week, we randomly choose three winners from all the customers who clicked the most shared items within a week. the main prize will be the most shared items they have clicked. If your Facebook friends have clicked your post and participated in this game then when they win a prize, you will also win it</div>
               <ul id="share_winner">
               <?php foreach ($config_results as $config_result) { 
                $products=explode(",", $config_result['products']);
                $winners=explode(",", $config_result['winners']);
                $week_date=$config_result['endtime']?$config_result['endtime']:date("Y-m-d",time());
                $i=0;
                foreach ($winners as $uid) {
                  $sku=$products[$i];
                  $i++;
                  $pid=Product::instance()->get_productId_by_sku($sku);
                  $product=Product::instance($pid);
                  $link=$product->permalink();
                  $fb=DB::query(DATABASE::SELECT, 'SELECT `fb_id`,`email` FROM `share_win` WHERE `customer_id`='.$uid.' limit 0,1')->execute();
                  $fb_id=$fb->get('fb_id');
                  $fb_email=$fb->get('email');
                  $n = strpos($fb_email,'@');
                  if($n<=3){
                  $username = substr_replace($fb_email,"**",1,2);
                  }elseif ($n>3&&$n<6){
                  $username = substr_replace($fb_email,"***",2,$n-1);
                  }else {
                  $username = substr_replace($fb_email,"****",$n-6,4);
                  }
                  ?>
                  <li>
                   <p class="fbr_user"><a target="_blank" href="https://www.facebook.com/profile.php?id=<?php echo $fb_id; ?>"><img src="http://graph.facebook.com/<?php echo $fb_id; ?>/picture?type=large" width="60" height="60" border="0"></a></p>
                   <p class="fbr_text"><strong><?php echo $week_date; ?></strong><br><?php echo $username; ?></p>
                   <p class="fbr_img"><a href="<?php echo $link; ?>"><img src="<?php echo Image::link($product->cover_image(), 7); ?>" height="60px" /></a></p>
                   <p class="fbr_icon"></p>
                 </li>
                 <?php } } ?>
                 <?php echo $pagination; ?>
         </ul>
             </div>
           </div>
         </div>
         <div class="swrapp hide">
           <h3>TOP 10 MOST WANTED</h3>
           <div>
           <ul class="s5">
           <?php foreach($allproducts as $value){
            $pid=$value['product_id'];
            $qty=$value['qty'];
              $product = Product::instance($pid);
              if($product->get('id')){
                $link = $product->permalink();
                $p_price = $product->get('price');
                $price=$product->price();
              ?>
             <li>
               <div><a href="<?php echo $link; ?>"><img src="<?php echo Image::link($product->cover_image(), 2); ?>" height="320px" /></a></div>
               <p class="mt10"><strong><?php echo $qty; ?></strong> have shared it!</p>
               <p class="mt5"><a href="javascript:;" onclick="show_facebook_div_to('<?php echo $product->get('id'); ?>');"><img src="/images/share_fb.jpg"/></a></p>
             </li>
             <?php }}?>
           </ul>
           </div>
         </div>
         <!--<div class="swrapp hide">
           <h3>WINNERS' FEEDBACKS</h3>
           <div class="s42">
           <ul>
             <li>
               <div><a href=""><img src="images/88.jpg" width="240px" height="320px" /></a></div>
               <p class="mt10"><span class="name">Kathy</span><span class="age">21</span><span class="do">Student</span></p>
               <p><a class="into" href="">I was so delighted to receive an email informing me that I had won an opportunit ...</a></p>
               <p class="sbuy"><a href="">View Details</a></p>
             </li> 
           </ul>
           </div>
           <div class="vm"><a href="">View More Reports >></a></div>
         </div>-->
         <div class="swrapp hide">
           <h3>TERMS & CONDITIONS</h3>
           <h4>1. How to join Choies Giveaway Event?</h4>
           <p>You can choose any item you want and go into its product detail page.</p>
           <p>Simply click the "Share and Win" button on all the items you fancy, follow the instructions:</p>
           <p>First Like us on our Facebook page, then share the item via Facebook.</p>
           <p>The three winners will be chosen randomly from those who have shared the most shared items and the prize will be the most shared product they have clicked</p>
           <h4>2. How do we choose the winner?</h4>
           <p> We randomly choose three winners from all of the customers who shared the most popular items. If your Facebook friends share your post and join this event, then if they win the prize, you also win it. It's really that simple!</p>
           <p> Hint: To improve your chances of winning your favorite product for free, share the item with as many friends as you can!</p>
           <h4>3. How do we send the prize to the winners?</h4>
           <p> Winners will be announced every Wednesday on this page, please remember to come back and check ! Three winners will also be notified by email and informed of how to redeem your prizes. Product reports are requested after the winners receive the free item. ( Excellent reports will bring you more chances to win more free items next time)  We'd like the winners to post images of their prizes on Facebook page as well so that other people can see it. Those who provide text and photo review or send a post on Facebook will be awarded 500 Choies points.</p>
         </div>
      </div>
    </div> 
      
      
       
  </section>
</section>
 

 
<script type="text/javascript">
$(".JS_popwinbtn11").live("click",function(){
    var top = getScrollTop();
    
    $('body').append('<div class="JS_filters opacity"></div>');
    $('.share1').appendTo('body').fadeIn(320);
    $('.share1').show();
    return false;
})

$(".JS_closes,.JS_filters").live("click",function(){
    $(".JS_filters").remove();
    $('#share').fadeOut(160);
    $('#share1').fadeOut(160);
    $('#share2').fadeOut(160);
    return false;
})
 
</script>
<div class="share1 wwrapper" id="share" style="display:none;">
  <a class="JS_closes close_btn3"></a>
  <div class="wcontent">
    <h3>Complete the following steps to win free item</h3>
    <div class="wwp">
      <div class="fll mt5"><img src="/images/step_01.jpg" /></div>
      <div class="fll ml10">
        <h4>Like Us on Facebook</h4>
        <div class="wc mt5">
          <div class="fll"><img src="/images/step_03.jpg" /></div>
          <div class="fll ml10">
            <p><iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fchoiescloth&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21&amp;appId=238843552981497" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe></p>
          </div>
        </div>
        <p class="red mt10">* Do remember to Like Us at the first step</p>
      </div>
    </div>
    <div class="wwp">
      <div class="fll mt5"><img src="/images/step_02.jpg" /></div>
      <div class="fll ml10">
        <h4>Share this item</h4>
        <div class="wc mt5"><a href="javascript:;" onclick="show_facebook_div();"><img src="/images/step_05.jpg" /></a></div>
      </div>
    </div> 
    <div class="wwp">
      <div class="fll mt5"><img src="/images/step_04.jpg" /></div>
      <div class="fll ml10">
        <h4>Wait for winners' list on every Wednesday</h4>
        <div class="wc mt5"><img src="/images/step_06.jpg"></div>
      </div>
    </div>
  </div>
</div>
<div class="share_success" id="share1" style="display:none;">
    <a class="JS_closes close_btn3" onclick="show_facebook_close();" href="javascript:;"></a>
    <div style="margin:0 50px;">
        <h5 class="clear"><strong>Share This to Your Friends on Facebook</strong></h5>
        <form  method="post" action="#" class="formArea" onsubmit="return false;">
            <textarea name="comment" id="facebook_input_comment" rows="3" class="input textarea fll"></textarea>
            <input type="hidden" id="facebook_input_goods_id" value="0" />
            <span id="post_facebook_error" class="fll" style="color:red;"></span>
            <input type="submit" value="POST" class="btn_post flr" onclick="set_facebook_share();" />
        </form>     
    </div>
</div>
<div class="share_success" id="share2" style="display:<?php echo $show_success ? 'inline' : 'none' ?>;">
    <a class="close" onclick="show_facebook_close();" href="javascript:;"><img src="/images/close.png"/></a>
    <div class="suc" style="background:url(/images/freebie/bg_success.jpg) bottom no-repeat;">
        <p style="font:48px/58px Georgia, 'Times New Roman', Times, serif;">Congrats!</p>
        <p style="font-size:16px; font-weight:bold;">You have completed these 2 tasks successfully.</p>
        <p style="color:#900;">You'll be notified via your facebook account email if you win.</p>
    </div>
</div>