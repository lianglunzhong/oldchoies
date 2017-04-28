<link type="text/css" href="/css/sharewin.css" rel="stylesheet">
<style>
.pname{width: 240px;height: 30px;}
.s5 li{margin-right:15px;}
.pp1{width:240px;text-align: center;}
.timeleft_box strong{font-size:15px;}
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
                    alert('Erreur de connexion, veuillez essayer de nouveau.');
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
                                alert("Désolé, vous avez déjà partagé cet article!");
                                return false;
                            }else{
                                if(rep.length != 0){
                                    $("#facebook_input_goods_id").val(goods_id);
                                    $("#facebook_input_comment").val('');
                                    $('body').append('<div class="JS_filters opacity"></div>');
                                    $('#share1').appendTo('body').fadeIn(320);
                                    $('#share1').show();
                                }else{
                                    $("#facebook_input_goods_id").val(goods_id);
                                    $("#facebook_input_comment").val('');
                                    alert("Vous devez nous aimer tout d'abord (étape 1).");
                                    return false;
                                }
                            }
                        }else if(result.status==3){
                            alert("Erreur de connexion, veuillez essayer de nouveau.");
                            return false;
                        }
            
                    }
                })
        
            });
        } else {
            alert("Erreur de connexion, veuillez essayer de nouveau.");
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
        $("#post_facebook_error").html("Votre commentaire ne peut pas avoir moins de 20 caractères.");
        $("#post_facebook_error").show();
        return false;
    }else if(goods_id == 0 || isNaN(goods_id)){
        $("#post_facebook_error").html("Ce produit n'existe pas.");
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
            alert("Erreur de connexion, veuillez essayer de nouveau.");
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
      <div class="fll"><a href="/">ACCUEIL</a>  >  PARTAGER ET GAGNER</div>
      <div class="flr"></div>
    </div>
  </div> 
  <section class="layout fix">
    <div><img src="/images/<?php echo LANGUAGE; ?>/share_01.jpg" height="282px" width="1024px" /></div>
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
          <li class="selected">LE PLUS RECHERCHÉ CETTE SEMAINE</li>
          <li>TOP 10 LES PLUS RECHERCHÉS</li>
          <!--<li>Winners' Feedback</li>-->
          <li>TERMS & CONDITIONS</li>
        </ul>
      </div>
      <div class="tab_box"> 
         <div class="swrapp">
           <div class="fll">
             <h3>LE PLUS RECHERCHÉ CETTE SEMAINE</h3>
             <div class="s4">
             <ul>
             <?php foreach($products as $val){
            $pid=$val['product_id'];
            $qty=$val['qty'];
              $product = Product::instance($pid,LANGUAGE);
              if($product->get('id')){
                $link = $product->permalink();
                $p_price = $product->get('price');
                $price=$product->price();
              ?>
               <li>
                 <div><a href="<?php echo $link; ?>"><img src="<?php echo Image::link($product->cover_image(), 2); ?>" width="240px" height="320px" /></a></div>
                 <div class="mt10 pname"><?php echo substr($product->get('name'),0,70); ?></div>
                 <div class="mt10 smi">
                   <p><strong><?php echo $qty; ?></strong> 
                   <?php if($qty==1){ 
                      echo "a partagé"; 
                    }else{
                      echo "ont partagé!";
                    }; ?></p>
                   <p class="pp1">Je l'ai partagé! Vous voulez l'obtenir gratuitement?</p>
                   <p class="mt10"><a href="javascript:;" onclick="show_facebook_div_to('<?php echo $product->get('id'); ?>');"><img src="http://www.choies.com/images/<?php echo LANGUAGE; ?>/share_win.png"/></a></p>
                   <div class="timeleft_box mt10">
                                <div class="JS_daoend hide">Time Over!</div>
                                <div class="JS_dao">Temps restant: <strong class="JS_RemainD"></strong> d : <strong class="JS_RemainH"></strong> h : <strong class="JS_RemainM"></strong> m : <strong class="JS_RemainS"></strong>s</div>
                   </div>
                 </div>
                 <div class="mt10" style="height:105px">
                  <p>Ou l’obtenir tout de suite!</p>
                  <p class="price fix"><b><?php echo Site::instance()->price($product->price(), 'code_view'); ?></b>
                  <?php 
                    if ($p_price > $price){ 
                    $rate =  round((($p_price - $price) / $p_price) * 100);
                  ?><del><?php echo Site::instance()->price($p_price, 'code_view'); ?></del><br><span class="off"><?php echo $rate; ?>% Rabatt</span>
                  <?php }else{ ?>
                  <del></del><br><span class="off">&nbsp;</span>
                  <?php } ?>
                  </p>
                  <p class="sbuy"><a href="<?php echo $link; ?>">ACHETEZ MAINTENANT</a></p>
                 </div>
               </li> 
               <?php }} ?>              
             </ul>
             </div>
           </div>
           <div class="fll">
             <h3><i>Liste des gagnants</i></h3>
             <div class="fbr ">
               <div class="prize_info">Chaque semaine, nous choisissons au hasard trois gagnants parmi tous les clients qui ont cliqué les articles les plus partagés dans une semaine.<br />Le prix principal sera les articles les plus partagés qu'ils ont cliqué. Si vos amis sur Facebook ont cliqué votre message et participé à ce jeu, alors quand ils gagnent un prix, vous pourrez également le gagner.</div>
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
                  $product=Product::instance($pid,LANGUAGE);
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
                   <p class="fbr_img"><a href="<?php echo $link; ?>"><img src="<?php echo Image::link($product->cover_image(), 2); ?>" height="60px" /></a></p>
                   <p class="fbr_icon"></p>
                 </li>
                 <?php }} ?>          
                 <?php echo $pagination; ?>
         </ul>
             </div>
           </div>
         </div>
         <div class="swrapp hide">
           <h3>TOP 10 LES PLUS RECHERCHÉS</h3>
           <div>
           <ul class="s5">
           <?php foreach($allproducts as $value){
            $pid=$value['product_id'];
            $qty=$value['qty'];
              $product = Product::instance($pid,LANGUAGE);
              if($product->get('id')){
                $link = $product->permalink();
                $p_price = $product->get('price');
                $price=$product->price();
              ?>
             <li>
               <div><a href="<?php echo $link; ?>"><img src="<?php echo Image::link($product->cover_image(), 2); ?>" width="240px" height="320px" /></a></div>
               <p class="mt10"><strong><?php echo $qty; ?></strong> 
               <?php if($qty==1){ 
                      echo "a partagé"; 
                    }else{
                      echo "ont partagé!";
                    }; ?></p>
               <p class="mt5"><a href="javascript:;" onclick="show_facebook_div_to('<?php echo $product->get('id'); ?>');"><img src="/images/<?php echo LANGUAGE; ?>/share_win.png"/></a></p>
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
           <h4>1.Comment participer à cette manifestation de Choies?</h4>
           <p>Vous pouvez choisir n'importe quel article que vous voulez et aller dans la page de détails du produit.</p>
           <p>Il vous suffit de cliquer sur le bouton «Partager et gagner» sur tous les articles que vous voulez, suivez les instructions:</p>
           <p>Aimez-nous sur notre page de Facebook, puis partagez l'article par Facebook.</p>
           <p>Les trois gagnants seront choisis au hasard parmi ceux qui ont partagé les articles les plus partagés et le prix sera le produit le plus partagé qu'ils ont cliqué.</p>
           <h4>2.Comment nous choisissons le gagnant?</h4>
           <p> Nous choisissons au hasard trois gagnants parmi tous les clients qui ont partagé articles les plus populaires. Si vos amis sur Facebook partagent votre message et participent à cet événement, alors si ils gagnent le prix, vous aussi le gagnez. C'est vraiment simple!</p>
           <p> Astuce: Pour améliorer vos chances de gagner votre produit préféré gratuitement, il vous suffit de partager l’article avec autant d'amis que possible!</p>
           <h4>3.Comment nous envoyons le prix aux gagnants?</h4>
           <p>Les gagnants seront annoncés tous les mercredis sur cette page, n'oubliez pas de revenir et de vérifier! Trois gagnants seront avisés aussi par é-mail et informés du moyen de recevoir vos prix. Les rapports de produit sont demandés après que les gagnants reçoivent les produits gratuits. (Les rapports excellents vous apporteront plus de chances de gagner des produits gratuits la prochaine fois.) Nous espérons que les gagnants peuvent afficher des images de leurs prix sur Facebook afin que les autres personnes puissent les voir. Ceux qui fournissent le texte et le commentaire de photo ou envoient un message sur Facebook serons attribués 500 Choies points.</p>
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
    <h3>Effectuez les étapes suivantes pour gagner l’article gratuit</h3>
    <div class="wwp">
      <div class="fll mt5"><img src="/images/<?php echo LANGUAGE; ?>/step_01.jpg" /></div>
      <div class="fll ml10">
        <h4>Aimez-nous sur Facebook</h4>
        <div class="wc mt5">
          <div class="fll"><img src="/images/step_03.jpg" /></div>
          <div class="fll ml10">
            <p><iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fchoiescloth&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21&amp;appId=238843552981497" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe></p>
          </div>
        </div>
        <p class="red mt10">* N'oubliez pas de nous aimer lors de la première étape</p>
      </div>
    </div>
    <div class="wwp">
      <div class="fll mt5"><img src="/images/<?php echo LANGUAGE; ?>/step_02.jpg" /></div>
      <div class="fll ml10">
        <h4>Partagez cet article</h4>
        <div class="wc mt5"><a href="javascript:;" onclick="show_facebook_div();"><img src="/images/<?php echo LANGUAGE; ?>/share_fb.jpg" /></a></div>
      </div>
    </div> 
    <div class="wwp">
      <div class="fll mt5"><img src="/images/<?php echo LANGUAGE; ?>/step_04.jpg" /></div>
      <div class="fll ml10">
        <h4>Attendez la liste des gagnants sur tous les mercredis</h4>
        <div class="wc mt5"><img src="/images/<?php echo LANGUAGE; ?>/step_06.jpg"></div>
      </div>
    </div>
  </div>
</div>
<div class="share_success" id="share1" style="display:none;">
    <a class="JS_closes close_btn3" onclick="show_facebook_close();" href="javascript:;"></a>
    <div style="margin:0 50px;">
        <h5 class="clear"><strong>Partager Avec Vos Amis Sur Facebook</strong></h5>
        <form  method="post" action="#" class="formArea" onsubmit="return false;">
            <textarea name="comment" id="facebook_input_comment" rows="3" class="input textarea fll"></textarea>
            <input type="hidden" id="facebook_input_goods_id" value="0" />
            <span id="post_facebook_error" class="fll" style="color:red;"></span>
            <input type="submit" value="DÉPOSER" class="btn_post flr" onclick="set_facebook_share();" />
        </form>     
    </div>
</div>
<div class="share_success" id="share2" style="display:<?php echo $show_success ? 'inline' : 'none' ?>;">
    <a class="close" onclick="show_facebook_close();" href="javascript:;"><img src="/images/close.png"/></a>
    <div class="suc" style="background:url(/images/freebie/bg_success.jpg) bottom no-repeat;">
        <p style="font:48px/58px Georgia, 'Times New Roman', Times, serif;">Félicitations!</p>
        <p style="font-size:16px; font-weight:bold;">Vous avez terminé ces deux tâches avec succès.</p>
        <p style="color:#900;">Vous serez informé via votre é-mail de compte facebook si vous gagnez.</p>
    </div>
</div>