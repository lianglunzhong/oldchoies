<link type="text/css" href="/css/sharewin.css" rel="stylesheet">
<style>
.pname{width: 240px;height: 30px;}
.s5 li{margin-right:15px;}
.pp1{width:240px;text-align: center;}
.timeleft_box strong{font-size:12px;}
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
    $week = date('w');
    $next_week=date('Y-m-d',strtotime('+1 week last tuesday'));
    $end_day = strtotime("-1 months", strtotime($next_week));
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
                    alert('Error de inicio de sesión, por favor inténtelo de nuevo');
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
                                alert("Lo siento, ya ha compartido este artículo.");
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
                                    alert("Por favor házte fan primero.( Paso 1)");
                                    return false;
                                }
                            }
                        }else if(result.status==3){
                            alert("Error de inicio de sesión, por favor inténtelo de nuevo");
                            return false;
                        }
            
                    }
                })
        
            });
        } else {
            alert("Error de inicio de sesión, por favor inténtelo de nuevo");
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
        $("#post_facebook_error").html("Su comentario contiene no menos de 20 caracteres.");
        $("#post_facebook_error").show();
        return false;
    }else if(goods_id == 0 || isNaN(goods_id)){
        $("#post_facebook_error").html("Este product no existe.");
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
            alert("Error de inicio de sesión, por favor inténtelo de nuevo");
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
    <h3>Complete los pasos siguientes para ganar el artículo gratuito.</h3>
    <div class="wwp">
      <div class="fll mt5"><img src="/images/<?php echo LANGUAGE; ?>/step_01.jpg" /></div>
      <div class="fll ml10">
        <h4>Házte fan en Facebook</h4>
        <div class="wc mt5">
          <div class="fll"><img src="/images/step_03.jpg" /></div>
          <div class="fll ml10">
            <p><iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fchoiescloth&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21&amp;appId=238843552981497" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe></p>
          </div>
        </div>
        <p class="red mt10">* Recuerde que hágase fan nuestro en Facebook en el primer lugar.</p>
      </div>
    </div>
    <div class="wwp">
      <div class="fll mt5"><img src="/images/<?php echo LANGUAGE; ?>/step_02.jpg" /></div>
      <div class="fll ml10">
        <h4>Comparte el artículo</h4>
        <div class="wc mt5"><a href="javascript:;" onclick="show_facebook_div();"><img src="/images/<?php echo LANGUAGE; ?>/share_fb.jpg" /></a></div>
      </div>
    </div> 
    <div class="wwp">
      <div class="fll mt5"><img src="/images/<?php echo LANGUAGE; ?>/step_04.jpg" /></div>
      <div class="fll ml10">
        <h4>Espera la lista de ganadores los miércoles.</h4>
        <div class="wc mt5"><a href="/es/sharewin/index" target="_blank"><img src="/images/<?php echo LANGUAGE; ?>/step_06.jpg"></a></div>
      </div>
    </div>
  </div>
</div>
<div class="share_success" id="share1" style="display:none;">
    <a class="JS_closes close_btn3" onclick="show_facebook_close();" href="javascript:;"></a>
    <div style="margin:0 50px;">
        <h5 class="clear"><strong>Comparte este a su amiga en Facebook</strong></h5>
        <form  method="post" action="#" class="formArea" onsubmit="return false;">
            <textarea name="comment" id="facebook_input_comment" rows="3" class="input textarea fll"></textarea>
            <input type="hidden" id="facebook_input_goods_id" value="0" />
            <span id="post_facebook_error" class="fll" style="color:red;"></span>
            <input type="submit" value="MANDAR" class="btn_post flr" onclick="set_facebook_share();" />
        </form>     
    </div>
</div>
<div class="share_success" id="share2" style="display:<?php echo $show_success ? 'inline' : 'none' ?>;">
    <a class="close" onclick="show_facebook_close();" href="javascript:;"><img src="/images/close.png"/></a>
    <div class="suc" style="background:url(/images/freebie/bg_success.jpg) bottom no-repeat;">
        <p style="font:48px/58px Georgia, 'Times New Roman', Times, serif;">¡Felicidades!</p>
        <p style="font-size:16px; font-weight:bold;">Has completado 2 tareas con éxito.</p>
        <p style="color:#900;">Se le notificará a través de su email de Facebook si usted gana.</p>
    </div>
</div>