<style>
    .lp_match{ width:820px;}
    .lp_match img{ display:block; border:0 none;}
    .contactcon{ height:38px; line-height:35px; background-color:#dd4137; color:#fff; text-align:center; margin:15px 0; font-size:22px;}
    .contactcon a{ color:#fae29a; text-decoration:underline;}

    .match_sign{ width:820px; height:404px; background:url(/images/activity/important_clues_2.jpg) no-repeat; position:relative; margin:10px 0 0; padding:0;}
    .match_signcon{ position:absolute; top:68px; left:290px; z-index:1;}
    .match_sign span{float:left; margin-right:5px; line-height:101px; font-size:14px;}
    .match_sign .up a,.match_sign .in a{ float:left;margin-right:5px; width:96px; height:101px; background:url(/images/activity/find_btn1.png) no-repeat; display:block;}
    .match_sign .up a{ background-position:0 -308px;}
    .match_sign .up a:hover{ background-position:0 -412px;}
    .match_sign .in a{ background-position:-101px -308px;}
    .match_sign .in a:hover{ background-position:-101px -412px;}

    .important_clues_tips{ position:relative;}
    .important_clues_tips .tips1{ top:-30px; left:155px; position:absolute; z-index:1; }
    .important_clues_tips .tips1 a{ display:inline-block; width:236px; height:147px;background:url(/images/activity/important_clues_btn1.png) no-repeat;}
    .important_clues_tips .tips1 a:hover{background:url(/images/activity/important_clues_btn1_hover.png) no-repeat;}

    .important_clues_tips .tips2 a{ position:absolute; z-index:1; top:2px; right:10px; display:inline-block; width:190px; height:278px;background:url(/images/activity/important_clues_btn2.jpg) no-repeat; cursor:pointer;}
    .important_clues_tips .tips2 a:hover{background:url(/images/activity/important_clues_btn2_hover.jpg) no-repeat;}

    .matchshowcon{ position:absolute; top:30px; right:175px; z-index:2;}

    .match_form{ padding: 15px 120px 40px 130px; margin:0; width:auto; background-color:#faf8f8;}
    .match_form li{ margin-bottom:15px;}
    .match_form li.b{ margin-bottom:5px;}
    .match_form li label{ margin-right:10px;}
    .match_form li label span{ color:#f00;}
    .match_form li .text{ width:263px; height:28px; padding:0 5px; border:1px solid #ccc; display:inline-block; margin:0 10px 10px 0;}
    .match_form li textarea { width:553px; height:150px; border:1px solid #ccc; padding:5px; color:#999; margin:5px 0 0;}
    .match_form li .share_con{ margin:10px 0 0; border:1px dashed #ccc; padding:10px;}
    .match_form li .share_con b{ color:#666; text-transform:uppercase;}
    .match_form li .share_con a{ display:inline-block; background:url(/images/activity/icon1.png) no-repeat; padding:2px 0 2px 25px; text-transform:uppercase; margin:0 0 0 20px;}
    .match_form li .share_con a.share1{ background-position:0 0;}
    .match_form li .share_con a.share2{ background-position:0 -23px;}
    .match_form li .share_con a.share3{ background-position:0 -46px;}
    .match_form li .share_con p.bottom{ margin:5px 0 0; font-style:italic; color:#5f9514; font-size:11px;}
    .match_form li .long_text{ width:553px; margin-bottom:10px;}
    .match_form li .add_btn{ background:url(/images/activity/icon1.png) no-repeat 0 -93px; padding-left:18px; color:#f00; font-family:Tahoma, Geneva, sans-serif; text-decoration:underline; cursor:pointer; margin-bottom:10px; display:block;}
    .match_form li .btn{width:228px; height:42px; background:url(/images/activity/find_btn1.png) no-repeat 0 -219px; margin:5px 0 0 165px;}
    .match_form li .btn:hover{ background-position:0 -262px; cursor:pointer;}

    .match_comments span{ margin-right:10px;}
    .match_comments span.red{ color:#c00;}
    .match_comments dt,.match_comments dd{ padding:0 40px;line-height:18px;}
    .match_comments dt{ background-color:#fafaf8; height:30px; line-height:30px; margin-top:15px;}
    .match_comments dd a{ text-decoration:underline; color:#0066ff;}

    .match_page a{ text-decoration:none; color:#808080; padding:2px 7px; border:1px solid #ccc; display:inline-block; margin-left:5px; line-height:normal;}
    .match_page a:hover,.match_page .on{color:#F66; border:#F66 1px solid;}

    /* login*/
    .login{width: 660px;height: auto;min-height:279px;border: #CCC 1px solid;margin: 0 auto;padding: 0;}
    .login_l {width: 300px;margin-left:20px;padding-top: 20px;}
    .login_l li {padding: 8px 0px;}
    .login_l li label {width: 88px;display: inline-block;font-size: 12px;color: #666;}
    .login_l li input {border: 1px solid #DEDEDE;height: 22px;line-height: 22px;width: 205px;float: none;margin:0;}
    .login_l li .form_btn,.form_btn_long{background: url(../images/form_btn_bg.jpg) repeat-x;width: 91px;height: 27px;border: none;cursor: pointer;color: #fff;font: bold 13px/27px Arial;}
    .login_l li .form_btn_long {width:120px;background: url(../images/form_btn_bg.jpg) repeat-x;}
    .login_l li .forgetpwd {vertical-align: bottom;padding-left: 20px;}
    .login_l li .forgetpwd a {color:#BE4040;text-decoration:underline;}
    .step_form_h2 {font:18px/30px Verdana, Geneva, sans-serif; color:#666;border-bottom:3px solid #f3f3f3; margin:0 0 10px 0;}

</style>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  XMAS SHOPPING GUIDE</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <section class="layout fix">
        <div class="thanksgiving-looks">
            <table id="__01" width="1024" height="3016" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <img src="<?php echo STATICURL; ?>/ximg/activity/amas_01.jpg" width="1024" height="139" alt=""></td>
                </tr>
                <tr>
                    <td><a href="<?php echo BASEURL ;?>/christmas-sale?xmas1212" target="_blank" title="XMAS SALE"><img src="<?php echo STATICURL; ?>/ximg/activity/amas_02.jpg" width="1024" height="285" alt="XMAS SALE"></a></td>
                </tr>
                <tr>
                    <td>
                        <img src="<?php echo STATICURL; ?>/ximg/activity/amas_03.jpg" width="1024" height="80" alt=""></td>
                </tr>
                <tr>
                    <td>
                        <img src="<?php echo STATICURL; ?>/ximg/activity/amas_04.jpg" alt="" name="as" width="1024" height="254" border="0" usemap="#asMap" id="as"></td>
                </tr>
                <tr>
                    <td>
                        <img src="<?php echo STATICURL; ?>/ximg/activity/amas_05.jpg" width="1024" height="148" alt=""></td>
                </tr>
                <tr>
                    <td>
                        <img src="<?php echo STATICURL; ?>/ximg/activity/amas_06.jpg" alt="" name="ad" width="1024" height="288" border="0" usemap="#adMap" id="ad"></td>
                </tr>
                <tr>
                    <td>
                        <img src="<?php echo STATICURL; ?>/ximg/activity/amas_07.jpg" alt="" name="af" width="1024" height="294" border="0" usemap="#afMap" id="af"></td>
                </tr>
                <tr>
                    <td>
                        <img src="<?php echo STATICURL; ?>/ximg/activity/amas_08.jpg" width="1024" height="40" alt=""></td>
                </tr>
                <tr>
                    <td><a href="<?php echo BASEURL ;?>/christmas-red?xmas1212" title="Shop Christmas Red" target="_blank"><img src="<?php echo STATICURL; ?>/ximg/activity/amas_09.jpg" width="1024" height="342" alt=""></a>
                      <span style="font-size:32px; color:#fff; position:relative; top:-117px; left:512px; display:block;">RED5</span>
                  </td>
                </tr>
                <tr>
                    <td>
                        <img src="<?php echo STATICURL; ?>/ximg/activity/amas_10.jpg" width="1024" height="98" alt=""></td>
                </tr>
                <tr>
                    <td>
                        <img src="<?php echo STATICURL; ?>/ximg/activity/amas_11.jpg" alt="" name="ag" width="1024" height="114" border="0" usemap="#agMap" id="ag"></td>
                </tr>
                <tr>
                    <td>
                        <img src="<?php echo STATICURL; ?>/ximg/activity/amas_12.jpg" width="1024" height="100" alt=""></td>
                </tr>
                <tr>
                    <td>
                        <img src="<?php echo STATICURL; ?>/ximg/activity/amas_13.jpg" width="1024" height="309" alt=""></td>
                </tr>
                <tr>
                    <td>
                        <img src="<?php echo STATICURL; ?>/ximg/activity/amas_14.jpg" width="1024" height="357" alt=""></td>
                </tr>
                <tr>
                    <td>
                        <img src="<?php echo STATICURL; ?>/ximg/activity/amas_15.jpg" width="1024" height="168" alt=""></td>
                </tr>
            </table>
            <!-- End Save for Web Slices -->

            <map name="asMap">
              <area shape="rect" coords="1,1,247,251" href="<?php echo BASEURL ;?>/jumpers-cardigans?xmas1212 " title="Cardigans & Knit Sweaters" target="_blank">
              <area shape="rect" coords="258,3,509,250" href="<?php echo BASEURL ;?>/dresses?xmas1212" title="Dress? Of course!" target="_blank">
              <area shape="rect" coords="515,2,765,252" href="<?php echo BASEURL ;?>/outerwear?xmas1212" title="Burrow into essential outerwear styles." target="_blank">
              <area shape="rect" coords="774,3,1025,252" href="<?php echo BASEURL ;?>/little-things?xmas1212" title="Little lovely Things" target="_blank">
            </map>

            <map name="adMap">
              <area shape="rect" coords="0,2,249,285" href="<?php echo BASEURL ;?>/2014-summer-sale?xmas1212"  title="USD9.9" target="_blank">
              <area shape="rect" coords="259,5,763,287" href="<?php echo BASEURL ;?>/usd-13?xmas1212" title="USD13.9" target="_blank">
              <area shape="rect" coords="775,4,1025,286" href="<?php echo BASEURL ;?>/usd-16?xmas1212" title="USD16.9" target="_blank">
            </map>

            <map name="afMap">
              <area shape="rect" coords="2,10,505,294" href="<?php echo BASEURL ;?>/usd20?xmas1212" title="USD19.9" target="_blank">
              <area shape="rect" coords="518,11,767,288" href="<?php echo BASEURL ;?>/usd30?xmas1212" title="USD29.9" target="_blank">
              <area shape="rect" coords="778,13,1021,291" href="<?php echo BASEURL ;?>/usd40?xmas1212" title="USD39.9" target="_blank">
            </map>

            <map name="agMap">
              <area shape="rect" coords="2,1,504,111" href="<?php echo BASEURL ;?>/freetrial/add?xmas1212" title="FREE TRIAL CENTER" target="_blank">
              <area shape="rect" coords="521,4,1021,110" href="<?php echo BASEURL ;?>/sharewin/index?xmas1212 " title="SHARE & WIN ACTIVITY" target="_blank">
            </map>
        </div>
    </section>
</section>
<div id="catalog_link" class="" style="position: fixed;z-index: 1000;width: 662px; height: 280px; top: 70px; left: 380px;">
    <div style="background:#fff; height: 280px;" id="inline_example2">
        <div class="login">
            <div class="clear"></div>
            <div class="login_l fll ml10">
                <div class="step_form_h2">LOG IN</div>
                <form id="loginForm" method="post" action="/customer/login?redirect=activity/lets_to_win#step2" class="">
                    <ul>
                        <li>
                            <label><span>*</span> Email:</label>
                            <input type="text" id="" name="email" class="" />
                            <div class="errorInfo"></div>
                        </li>
                        <li>
                            <label><span>*</span> Password: </label>
                            <input type="password" id="" name="password" class="" />
                            <div class="errorInfo"></div>
                        </li>
                        <li>
                            <input type="submit" class="form_btn ml10" value="LOG IN" />
                            <span class="forgetpwd"><a href="<?php echo LANGPATH; ?>/customer/forgot_password">I forgot my password !</a></span>
                        </li>
                    </ul>
                </form>
                <script type="text/javascript">
                    $("#loginForm").validate($.extend(formSettings,{
                        rules: {
                            email:{required: true,email: true},
                            password: {required: true,minlength: 5}
                        }
                    }));
                </script>
            </div>
            <div class="login_l fll">
                <div class="step_form_h2">I’M NEW TO CHOIES</div>
                <form id="registerForm" method="post" action="/customer/register?redirect=activity/lets_to_win#step2" class="">
                    <ul>
                        <li>
                            <label><span>*</span> Email:</label>
                            <input type="text" id="email" name="email" class="" />
                            <div class="errorInfo"></div>
                        </li>
                        <li>
                            <label><span>*</span> Password: </label>
                            <input type="password" id="password" name="password" class="" />
                            <div class="errorInfo"></div>
                        </li>
                        <li>
                            <label><span>*</span> Confirm Pass: </label>
                            <input type="password" id="confirmpassword" name="confirmpassword" class="" />
                            <div class="errorInfo"></div>
                        </li>
                        <li>
                            <input type="submit" class="form_btn_long ml10"  value="CREAT ACCOUNT" />
                        </li>
                    </ul>
                </form>
                <script type="text/javascript">
                    $("#registerForm").validate($.extend(formSettings,{
                        rules: {			
                            email:{required: true,email: true},
                            password: {required: true,minlength: 5},
                            confirmpassword: {required: true,minlength: 5,equalTo: "#password"}
                        }
                    }));
                </script>
            </div>
        </div>
    </div>
    <div class="closebtn" style="right: -0px;top: 3px;"></div>
    <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
</div>
<script type="text/javascript">
    $(function(){
        var step = '<?php if(isset($step)){echo $step;} ?>';
            if(step != '')
            {
                location.href = '#step' + step;
            }
            $("#loginLink,#registerLink").click(function(){
                $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                $('#catalog_link').appendTo('body').fadeIn(320);
                $('#catalog_link').show();
                return false;
            })
                    
            $("#catalog_link .closebtn,#wingray").live("click",function(){
                $("#wingray").remove();
                $('#catalog_link').fadeOut(160).appendTo('#tab2');
                return false;
            })
    })
    $(function(){
        // show / hide hover
        $(".JS_matchshow").hover(function(){
            $(this).find('.JS_matchshowcon').show();
        },function(){
            $(this).find('.JS_matchshowcon').hide();
        })
    });

    function add_Tags(){
        var itemOriginal =document.getElementsByName("tagsInput");
        var arr = new Array(itemOriginal.length);
        for(var j = 0; j < itemOriginal.length;j++){
            arr[j] = itemOriginal.item(j).value;
        }
         
        var str = "<input type='text' name='skus[]' value='' class='text' /><input type='text' name='skus[]' value='' class='text' />";
        document.getElementById("tags1").innerHTML += str;
        var itemNew =document.getElementsByName("tagsInput");
        for(var i=0;i<arr.length;i++)
        {
            itemNew.item(i).value = arr[i];
        }
		 
        var str = "<input type='text' name='urls[]' value='' class='text long_text' />";
        document.getElementById("tags2").innerHTML += str;
        var itemNew =document.getElementsByName("tagsInput");
        for(var i=0;i<arr.length;i++)
        {
            itemNew.item(i).value = arr[i];
        }
    }
</script>