<script type="text/javascript" charset="utf-8" src="chrome-extension://cpngackimfmofbokmjmljamhdncknpmg/page_context.js"></script>
<link type="text/css" rel="stylesheet" href="chrome-extension://cpngackimfmofbokmjmljamhdncknpmg/style.css">
<link type="text/css" href="/css/freetrial.css" rel="stylesheet">
<style>
    .report_list{ width:820px;}
    .report_list img{ display:block;}
    .report_list .tit{ margin-bottom:10px; padding:0 0 8px; border-bottom:1px solid #000;}
    .report_list .tit h1{ font-size:24px; font-family:Tahoma, Geneva, sans-serif;}

    .report_list_con li{ width:255px; float:left; margin:0 0 20px 5px; line-height:18px;}
    .report_list_con li .name{ font-weight:bold; font-size:14px; margin:10px 0 2px; max-height:18px; overflow:hidden;}
    .report_list_con li .con{ max-height:36px; overflow:hidden;text-overflow:ellipsis;width:255px;}
    .report_list_con li .view_btn{ display:inline-block; padding:2px 5px; color:#fff; font-weight:bold; margin-top:8px; background-color:#f54b00;}

    .report_list .bottom{ border-top:1px solid #000;}
    .lp_page a{ text-decoration:none; color:#808080; padding:2px 7px; border:1px solid #ccc; display:inline-block; margin-left:5px; line-height:normal;}
    .lp_page a:hover,.lp_page .on{color:#F66; border:#F66 1px solid;}
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
        scope : 'email,user_likes,user_friends'
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
                    alert('Ошибка Логина,пожалуйста попробуйте еще раз');
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
                    url:'/freetrial/facebook_share',
                    data:'action=1&goods_id='+goods_id+'&type='+type,
                    success:function(result){
                        if(result.status==2||result.status==1){
                            var a = true;
                            if(result.status==2){
                                a = confirm('Вы уже поделились этот товар,вы уверены, что хотите поделиться его еще раз?');
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
                            alert("Ошибка Логина,пожалуйста попробуйте еще раз");
                            return false;
                        }
						
                    }
                })
				
            });
        } else {
            alert("Ошибка Логина,пожалуйста попробуйте еще раз");
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
        $("#post_facebook_error").html("Ваш комментарий не менее 20 символов.");
        $("#post_facebook_error").show();
        return false;
    }else if(goods_id == 0 || isNaN(goods_id)){
        $("#post_facebook_error").html("Этот товар не существует.");
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
                        url:'/freetrial/facebook_share',
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
            alert("Ошибка Логина,пожалуйста попробуйте еще раз");
            return false;
        }
    }, {
        scope : 'email,publish_actions,publish_actions,user_likes,user_friends'
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
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Home</a>  >  Бесплатная доставка</div>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <section id="container" class="flr">
            <p><img src="/cimages/<?php echo LANGUAGE; ?>_banner_freetrial.jpg" /></p>
            <div class="trial_winners">
                <h3>Победители На прошлой неделе</h3>
                <ul class="fix">
                    <?php
                    foreach ($winners as $key => $winner):
                        ?>
                        <li width="<?php echo $width[$k]; ?>%"><?php echo $winner; ?></li>
                        <?php
                    endforeach;
                    ?>
                </ul>
                <p><a href="mailto:lisaconnor@choies.com" class="a_red" title="Mail to Lisa">Лиза</a> свяжется с вами позже с подробностями.</p>
            </div>

            <!-- report_details -->
            <?php
            foreach ($products as $k => $pid):
                $product = Product::instance($pid, LANGUAGE);
                $link = $product->permalink();
                ?>
                <div class="report_details fix">
                    <div class="left JS_imgbox">
                        <em class="chances chances<?php echo trim($chances[$k]); ?>"></em>
                        <div class="pro_img">
                            <a href="<?php echo $link; ?>" target="_blank"><img src="<?php echo Image::link($product->cover_image(), 2); ?>" class="JS_pro_img" width="324" /></a>
                        </div>
                        <div class="pro_small">
                            <div class="pro_items">
                                <ul class="fix JS_pro_small">
                                    <?php
                                    $key = 0;
                                    foreach ($product->images() as $image):
                                        $key++;
                                        if ($key > 3)
                                            break;
                                        ?>
                                        <li class="<?php if ($key == 1) echo 'current'; ?>"><img src="<?php echo Image::link($image, 7); ?>" imgb="<?php echo Image::link($image, 2); ?>" width="102px"/></li>
                                        <?php
                                    endforeach;
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="<?php echo $pid; ?>"></div>
                    <div class="right">
                        <h3><a href="<?php echo $product->permalink(); ?>"><?php echo $product->get('name'); ?></a></h3>
                        <dl>
                            <dt class="fix">
                            <span class="left">Бесплатное испытание</span>
                            <!-- time left -->
                            <div class="timeleft_box flr">
                                <div class="JS_daoend hide">Время Кончилось!</div>
                                <div class="JS_dao">Закончится: <strong class="JS_RemainD"></strong> d : <strong class="JS_RemainH"></strong> h : <strong class="JS_RemainM"></strong> m : <strong class="JS_RemainS"></strong>s</div>
                            </div>
                            </dt>
                            <dd>
                                <ul class="price">
                                    <li>
                                        <span>Цена: <del><?php echo Site::instance()->price($product->price(), 'code_view'); ?></del></span>
                                        <label class="f00">$0.00</label></li>
                                    <li><span>Стоимость доставки:</span> <label class="f00">$0.00</label></li>
                                    <li class="m">
                                        <span><em class="f00"><?php echo $chances[$k]; ?></em> шанс(шанса,шансов)</span>
                                        <label><em class="f00"><?php echo $quantitys[$pid]; ?></em> приложение(приложения,приложений)</label>
                                    </li>
                                    <li><a href="javascript:;" onclick="show_facebook_div('<?php echo $pid; ?>','1');" class="view_btn btn26 btn40">ПОДАТЬ ЗАЯВКУ НА БЕСПЛАТНОЕ</a></li>
                                    <span class="share flr" style="width: 160px;">
                                        <a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($product->permalink()); ?>" class="a1"></a>
                                        <a target="_blank" href="http://twitter.com/share?url=<?php echo urlencode($product->permalink()); ?>" class="a2"></a>
                                        <a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($product->permalink()); ?>&media=<?php echo Image::link($product->cover_image(), 1); ?>&description=<?php $product->get('name'); ?>" class="a3"></a>
                                    </span>
                                </ul>
                            </dd>
                            <dt>ХОЧЕТСЯ ПОЛУЧИТЬ</dt>
                            <dd>
                                <p>Не ждете получить один?</p>
                                <p><a href="<?php echo $link; ?>" class="view_btn btn26 btn40">КУПИТЬ СЕЙЧАС</a></p>
                            </dd>
                            <dt>Описание:</dt>
                            <dd>
                                <dl>
                                    <dt>Детали:</dt>
                                    <dd>
                                        <?php
                                        $description = $product->get('description');
                                        $description = str_replace(';', '<br>', $description);
                                        echo $description;
                                        ?>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Размеры:</dt>
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
            <div class="trial_report">
                <h2>Фидбэк победителей</h2>
                <ul class="trial_report_listcon fix">
                    <?php
                    if (!empty($reports)):
                        $domain = Site::instance()->get('domain');
                        foreach ($reports as $report):
                            ?>
                            <li>
                                <a href="<?php echo LANGPATH; ?>/freetrial/reports/<?php echo $report['id']; ?>"><img src="<?php echo 'http://img.choies.com/simages/' . $report['image']; ?>" width="240" height="320" /></a>
                                <h3><?php echo $report['name']; ?></h3>
                                <a href="<?php echo LANGPATH; ?>/freetrial/reports/<?php echo $report['id']; ?>" class="name"><?php echo strlen($report['comments']) > 60 ? substr($report['comments'], 0, 60) . ' ...' : $report['comments']; ?></a>
                                <a href="<?php echo LANGPATH; ?>/freetrial/reports/<?php echo $report['id']; ?>" class="view_btn btn26 btn40">Смотреть дедали</a>
                            </li>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </ul>
                <div class="bottom"><a href="<?php echo LANGPATH; ?>/freetrial/reports">Смотреть более >></a></div>
            </div>
        </section>
        <?php echo View::factory(LANGPATH.'/catalog_left'); ?>
    </section>
</section>
<div class="share1" id="share" style="display:none;">
    <a class="close" onclick="show_facebook_close();" href="javascript:;"><img src="/images/close.png"/></a>
    <div class="clear">
        <h2 style="font-size: 21px;">Выполнить 2 задачи ниже<br/>Получить шанс,чтобы выиграть бесплатное испытание!</h2>
    </div>
    <div class="share_main">
        <div class="fix">
            <div class="task_num" style="line-height:114px;">Задача 1</div>
            <div class="task_share">
                <p>Дайте нам "Нравится" на Фейсбуке</p>
                <img src="/images/choies_fblogo.jpg"/>
                <span>Choies Street Fashion Sketch</span>
                <div class="share_facebook_like">
                    <div class="fb-like" data-href="https://www.facebook.com/choiescloth" data-width="450" data-layout="button_count" data-show-faces="false" data-send="false"></div>
                </div>
                <p id="trial_facebook_like_error" class="error">Вы можете дать нам "Нравится" прежде всего(Шаг 1).</p>
            </div>
        </div>
    </div>
    <div class="share_main">
        <div class="fix">
            <div class="task_num" style="line-height:90px;">Задача 2</div>
            <div class="task_share">
                <p>Поделиться этим бесплатным испытанием</p>
                <a href="javascript:;" class="share_btn" onclick="show_facebook_div_to();"></a>
            </div>
        </div>
    </div>
</div>
<div class="share_success" id="share1" style="display:none;">
    <a class="close" onclick="show_facebook_close();" href="javascript:;"><img src="/images/close.png"/></a>
    <div style="margin:0 50px;">
        <h5 class="clear"><strong>Поделиться этим с друзьями на Фейсбуке</strong></h5>
        <form  method="post" action="#" class="formArea" onsubmit="return false;">
            <textarea name="comment" id="facebook_input_comment" rows="3" class="input textarea fll"></textarea>
            <input type="hidden" id="facebook_input_goods_id" value="0" />
            <span id="post_facebook_error" class="fll" style="color:red;"></span>
            <input type="submit" value="SENDEN" class="btn_post flr" onclick="set_facebook_share();" />
        </form>     
    </div>
</div>
<div class="share_success" id="share2" style="display:<?php echo $show_success ? 'inline' : 'none' ?>;">
    <a class="close" onclick="show_facebook_close();" href="javascript:;"><img src="/images/close.png"/></a>
    <div class="suc" style="background:url(/images/freebie/bg_success.jpg) bottom no-repeat;">
        <p style="font:48px/58px Georgia, 'Times New Roman', Times, serif;">Поздравляю!</p>
        <p style="font-size:16px; font-weight:bold;">Вы выполнили эти 2 задачи успешно.</p>
        <p style="color:#900;">Вы будете уведомлены через Ваш фейсбук,кабинет или почту, если вы выиграете.</p>
    </div>
</div>