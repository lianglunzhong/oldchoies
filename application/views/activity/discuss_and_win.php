<?php
echo View::factory('/activity/header')
    ->set('og_title', $og_title)
    ->set('c_url', $c_url)
    ->set('og_description', $og_description)
    ->set('c_image', $c_image);
?>
<style>
@charset "utf-8";
#Discuss_Win .discuss_form .lp_vote_form.form {
}
.lp_slogan img{ display:block; border:0 none;}
.lp_slogan .view_btn{ width:90px; height:25px; text-align:center; line-height:25px; font-size:15px; border:0 none; border-radius:5px; margin:0 5px;}
.lp_slogan h1{font-size:25px;color:#333333;line-height:60px;border-bottom:2px solid #333333;text-transform:uppercase;}
.lp_slogan .btn1{ background-color:#ee2031;}
.lp_slogan .btn2{ background-color:#040404;}
.lp_slogan p{ margin:15px 0;font-size:14px;}
.lp-main{width:1024px;margin:0 auto;margin-top:45px;}
.tips ul{width:1024px;overflow:hidden;}
.tips li{ text-align:center; margin-top:30px; float:left; margin-right:40px;}
.tips li.last{margin-right:0;}
.tips li div{margin-top:10px;font-size:12px;}
.tips li div span{float:left;}
.tips li div span.vote-number{float:right;color:#ee2031;}
.vote-form{margin-top:40px;margin-left:120px;}
.lp_vote_formcon{ width:500px; margin:40px auto;}
.lp_vote_formcon li{ margin-bottom:10px;}
.lp_vote_formcon .rightbox1 input{background-color:#fff;width:300px;height:30px;display:block;}
.lp_vote_formcon .textarea1 textarea{background-color:#fff;width:300px;height:150px;display:block;}
.lp_vote_formcon li label{ display:inline-block; width:90px; margin-right:5px;float:left;font-size:14px;font-weight:bold;}
.lp_vote_formcon li .btn1{ width:150px; height:35px; line-height:35px; background-color:#dc1a2a; font-size:18px; border-radius:5px; margin-top:10px;margin-left:144px;}
.lp_vote_formcon li .btn2{ width:150px; height:35px; line-height:35px; background-color:#grey; font-size:18px; border-radius:5px; margin-top:10px;margin-left:144px;}
.lp_vote_formcon li .text123{width:90px; margin-left:90px;font-size:14px;color:#F30}
.lp_vote_share{clear:both; width:540px;margin:20px 0 30px 240px;border:1px dashed #ccc; padding:15px 0; text-align:center; font-size:14px; text-transform:uppercase;}
.lp_vote_share a{ font-size:12px; display:inline-block; margin-left:15px; text-decoration:underline; background:url(/images/activity/icon1.png) no-repeat; padding:2px 0 1px 22px;}
.lp_vote_share .a1{ background-position:0 0;}
.lp_vote_share .a2{ background-position:0 -23px;}
.lp_vote_share .a3{ background:url(/images/activity/icon2.jpg) no-repeat;}
.lp_vote_share p{ color:#6a9c24; font-style:italic; text-transform:none; font-size:12px; margin:5px 0 0;}

.lp_vote_bottom{ padding:20px 0;width:1024px;margin:0 auto;background-color:#f2f2f2;}
.lp_vote_bottom h1{text-align:center;border-bottom-color:#cccccc;}
.lp_vote_history{ width:100%;}
.lp_vote_history li{ float:left; width:425px; background-color:#fff; padding:0 20px 5px 25px;margin:10px 20px;text-transform:capitalize;}
.lp_vote_history li .name{ display:inline-block; margin-right:5px; width:80px; color:#5f9514;}
.lp_vote_history li .time1{color:#626262;}
.lp_vote_history li .con1{ font-weight: bold;}
.lp_vote_history li .con{background-color:#ffdddd;margin-top:8px; height:42px; line-height:42px;color:#660000;font-weight: bold;font-size:16px;padding-left:10px;}
.gcom_page a,.gcom_page span{ border:1px solid #ccc; padding:2px 5px;}
.gcom_page .noborder{ border:none}
.gcom_page .on{ border:1px solid #000}
.form label.error{ display: initial;margin-left: 5px; }


#Discuss_Win {
    width: 1024px;
    margin-right: auto;
    margin-left: auto;
}
.disscuss_comment .title {
    width: 1024px;
    height: 40px;
    border-bottom-width: 1px;
    border-bottom-style: solid;
    border-bottom-color: #cccccc;
    font-size: 30px;
    font-family: Arial;
    font-weight: bold;
    text-align: center;
    padding-top: 25px;
}
.disscuss_comment .comment_body{
    width: 930px;
    background-color: #FFF;
    margin-right: auto;
    margin-left: auto;
    margin-top: 5px;

}
.disscuss_comment .comment_body .body1 {
    background-color: #FFF;
    font-size: 14px;
    color: #660000;
    border-bottom-style: solid;
    border-top-style: none;
    border-right-style: none;
    border-left-style: none;
    padding: 6px;
    border-bottom-width: 10px;
    border-bottom-color: #f2f2f2;
    margin: 0px;
}
.disscuss_comment .comment_body .body1  .con1 .name {
    display:inline-block; margin-right:10px; color:#5f9514;
}
.disscuss_comment .comment_body .body1  .con1 {
    font-weight: bold;
    background-color: #FFF;
    line-height:25px;
}
.disscuss_comment .comment_body .body1 .con {
    background-color: #FFDDDD;
    line-height: 20px;
    color: #660000;
    font-size: 14px;
    padding-left: 10px;
}



body {
    margin-top: 0px;
}

.show
{
    padding-top: 20px;
    float: left;
    width: 1024px;

}

.Guide
{
    float: left;
    padding-top: 50px;
    margin-right: 0px;
    padding-right: 20px;
    width: 400px;
}
.Guide ul li {
    list-style-image: url(/images/activity/discuss_and_win_icon3.png);
    font-family: Arial;
    font-size: 20px;
    color: #111111;
    line-height: 50px;
    margin-left: 40px;
}

#Discuss_Win .show img {
    float: left;
}
.discuss_form {
    background-image: url(/images/activity/discuss_and_win_bg_03.jpg);
    height: 416px;
    width: 688px;
    float: left;
    margin-right: 168px;
    margin-left: 168px;
    margin-tsop: 20px;
    margin-top: 30px;
    padding-top: 30px;
}

.but_show{
    width: 200px;
    height: 25px;
    background-color: #fff999;
    float: right;
    font-family: Arial;
    font-size: 14px;
    color: #111111;
    font-weight: bold;
    text-align: center;
    padding-top: 10px;
    margin-top: 73px;
    text-decoration: none;
    }
.but_show:hover
{
    background-color: #dedfff;
    text-align: center;
    }

.choose_color
{
    width: 688px;
    float: left;
    height: 446px;
    background-image: url(/images/activity/discuss_and_win_bg_03.jpg);
    background-repeat: no-repeat;
    margin-right: 168px;
    margin-left: 168px;
    margin-top: 50px;
    }
.lp_vote_formcon .fix label .card {
    color: #000;
}

.disscuss_comment
{
    width: 1024px;
    background-color: #f2f2f2;
    margin-right: auto;
    margin-left: auto;
}

</style>
        <!-- main begin -->
        <img src="<?php echo $c_image; ?>" style="display:none;">
        <div id="step1"></div>
        <section id="main">
            <!-- crumbs -->
            <div class="layout">
                <div class="crumbs fix">
                    <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  Vote For The Best Design</div>
                </div>
                <?php echo Message::get(); ?>
            </div>
            <section class="layout fix">
                <div id="Discuss_Win">
                    <img src="/images/activity/discuss_and_win_banner.jpg"/>
                    <div class="show">
                        <img src="/images/activity/discuss_and_win_dress.gif"/> 
                        <div class="Guide">
                            <ul>
                                <li>What <em>colors</em> are this<strong> DRESS</strong>?</li>
                                <li>Why does this happen?</li>
                                <li> Anything you want to say? </li>
                            </ul>
                            <div class="but_show">
                                <a href="<?php echo BASEURL ;?>/product/blue-black-or-white-gold-lace-detail-bodycon-dress_p40264 "target="_blank" style="color:#111111;" title="BUY THIS DRESS NOW">BUY THIS DRESS NOW >></a>
                            </div><!--but-->
                        </div><!--Guide-->
                        <a href="<?php echo BASEURL ;?>/product/blue-black-or-white-gold-lace-detail-bodycon-dress_p40264 " target="_blank" style="display:block;"><img src="/images/activity/discuss_and_win_pro.jpg"/></a>
                    </div><!--show-->
                    <div id="step2"></div>
                    <div class="discuss_form">
                        <form action="#" method="post" class="lp_vote_form form" id="discussForm">
                            <ul class="lp_vote_formcon">
                                <li class="fix">
                                    <label><span>*</span>　NAME:</label>
                                    <div class="right_box"><input type="text" name="name" value="" class="text" id="name" /></div>
                                </li>
                                <li class="fix">
                                    <label><span class="card">*</span>　EMAIL:</label>
                                    <div class="right_box"><input type="text" name="email" value="" class="text" /></div>
                                </li>
                                <li class="fix">
                                    <div><span class="text123">(Leave an email address if you wanna win a free dress.)</span></div>
                                </li>
                                <li class="fix">
                                    <label><span>*</span>　OPINION:</label>
                                    <div class="textarea1"><textarea name="comments" cols="" rows="" id="comments" ></textarea></div>
                                </li>
                                <li>
                                    <input type="submit" name="" value="submit" class="btn1 view_btn" id="discussSubmit1" />
                                    <input type="submit" name="" value="submit" class="btn2 view_btn" disabled="disabled" id="discussSubmit2" style="display:none;" />
                                </li>
                            </ul>
                        </form>
                        <script type="text/javascript">
                            $("#discussForm").validate({
                                rules: {
                                    name: {
                                        required: true,
                                    },
                                    email: {
                                        email: true,
                                    },
                                    comments: {
                                        required: true,
                                        minlength: 5,
                                    }
                                }
                            });

                            $(function(){
                                $("#discussForm").submit(function(){
                                    var name = $("#name").val();
                                    var comments = $("#comments").val();
                                    if(name.length > 0 && comments.length >= 5)
                                    {
                                        $("#discussSubmit1").hide();
                                        $("#discussSubmit2").show();
                                    }
                                })
                            })
                        </script>
                    </div><!--lp_vote_formcon-->
                    <p class="center" style="color:#666666;font-size:15px;text-transform:uppercase;font-weight:bold;padding-top:15px;clear:both;">&nbsp;&nbsp;&nbsp;&nbsp;SHARE THIS to Your SNS Friends to vote together! </p>
                    <div class="lp_vote_share">
                        <div>
                            <a href="http://www.facebook.com/sharer.php?u=<?php echo BASEURL ;?><?php echo $c_url; ?>" target="_blank" class="a1">facebook</a>
                            <a href="http://twitter.com/share?url=<?php echo BASEURL ;?><?php echo $c_url; ?>" target="_blank" class="a2">twitter</a>
                            <a href="http://www.tumblr.com/share/link?url=<?php echo BASEURL ;?><?php echo $c_url; ?>&amp;name=<?php echo $og_title; ?>&amp;description=<?php echo $og_description; ?>" target="_blank" class="a3">tumblr</a>
                        </div>
                        <p>Or you can share to your personal blogs and any other social networks.</p>
                    </div><!--lp_vote_share-->
                </div><!--choose-->
                <div id="step3"></div>
                <?php
                if(!empty($comments))
                {
                ?>
                <div class="disscuss_comment">
                    <div class="title"><span>COMMENTS</span></div><!--title-->
                    <div class="comment_body">
                    <?php
                    foreach($comments as $comment)
                    {
                    ?>
                        <div class="body1">
                            <p class="con1"><b class="name"><?php echo $comment['firstname']; ?></b><span class="time1"><?php echo date('M d, Y', $comment['created']); ?></span></p>
                            <p class="con"><?php echo $comment['comments']; ?></p>
                        </div>
                    <?php
                    }
                    ?>
                    </div>
                    
                    <div class="fix gcom_page" style="background-color:#f5f5f5;padding:8px;">
                        <?php echo $pagination; ?>
                    </div>
                </div>
                <?php
                }
                ?>
                <!--Discuss_Win-->
            </section>
        </section>

        <!-- JS_popwincon1 -->
        <div class="JS_popwincon1 popwincon w_signup hide">
            <a class="JS_close2 close_btn2"></a>
            <div class="fix" id="sign_in_up">
                <div class="left" style="width:auto;margin-right:30px;padding-right:30px;">
                    <h3>CHOIES Member Sign In</h3>
                    <form action="/customer/login?redirect=<?php echo $c_url; ?>" method="post" class="signin_form sign_form form">
                        <ul>
                            <li>
                                <label>Email address: </label>
                                <input type="text" value="" name="email" class="text" />
                            </li>
                            <li>
                                <label>Password: </label>
                                <input type="password" value="" name="password" class="text" maxlength="16" />
                            </li>
                            <li><input type="submit" value="Sign In" name="submit" class="btn btn40" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">Forgot password?</a></li>
                            <li>
                                <?php
                                $page = $plink;
                                $facebook = new facebook();
                                $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                                ?>
                                <a href="<?php echo $loginUrl; ?>" class="facebook_btn"></a>
                            </li>
                        </ul>
                    </form>
                </div>
                <div class="right">
                    <h3>CHOIES Member Sign Up</h3>
                    <form action="/customer/register?redirect=<?php echo $c_url; ?>" method="post" class="signup_form sign_form form">
                        <ul>
                            <li>
                                <label>Email address: </label>
                                <input type="text" value="" name="email" class="text" />
                            </li>
                            <li>
                                <label>Password: </label>
                                <input type="password" value="" name="password" class="text" id="password" maxlength="16" />
                            </li>
                            <li>
                                <label>Confirm password: </label>
                                <input type="password" value="" name="password_confirm" class="text" maxlength="16" />
                            </li>
                            <li><input type="submit" value="Sign Up" name="submit" class="btn btn40" /></li>
                        </ul>
                    </form>
                </div>
            </div>
            <script type="text/javascript">
                // signin_form 
                $(".signin_form").validate({
                    rules: {
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true,
                            minlength: 5,
                            maxlength:20
                        }
                    },
                    messages: {
                        email:{
                            required:"Please provide an email.",
                            email:"Please enter a valid email address."
                        },
                        password: {
                            required: "Please provide a password.",
                            minlength: "Your password must be at least 5 characters long.",
                            maxlength: "The password exceeds maximum length of 20 characters."
                        }
                    }
                });

                // signup_form 
                $(".signup_form").validate({
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
                            required:"Please provide an email.",
                            email:"Please enter a valid email address."
                        },
                        password: {
                            required: "Please provide a password.",
                            minlength: "Your password must be at least 5 characters long.",
                            maxlength:"The password exceeds maximum length of 20 characters."
                        },
                        password_confirm: {
                            required: "Please provide a password.",
                            minlength: "Your password must be at least 5 characters long.",
                            maxlength:"The password exceeds maximum length of 20 characters.",
                            equalTo: "Please enter the same password as above."
                        }
                    }
                });
            </script>
        </div>

        <SCRIPT LANGUAGE="JavaScript"> 
            <!-- //checkbox元素的名字前缀，例sample1,sample2,sample3... 
            var sCtrlPrefix = "design"; 
            //checkbox元素数量； 
            var iMaxCheckbox = <?php echo $count; ?>; 
            //设置最大允许选择的数量； 
            var iMaxSelected = 3; 
            
            function doCheck(ctrl) {
                var iNumChecked = 0; 
                var thisCtrl; 
                var i; 

                //初始化 
                i = 1; 
                //循环直到选中了最多的checkbox; 
                while ((i <= iMaxCheckbox) && (iNumChecked <= iMaxSelected)) { 
                        
                    thisCtrl = eval("ctrl.form." + sCtrlPrefix + i); 
                    
                    if ((thisCtrl != ctrl) && (thisCtrl.checked)) { 
                            
                        iNumChecked++; 
                    } 
                    
                    i++; 
                }
                
                // 检查是否达到了最大选择数量； 
                if (iNumChecked == iMaxSelected) { 
                    // 如果是则uncheck刚选择的元素； 
                    ctrl.checked = false; 
                }
            } 
            // --> 
        </SCRIPT> 
        <script type="text/javascript">

            $(function(){
                var step = '<?php echo $step; ?>';
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
                
                $("#product input").click(function(){
                    var sku = $(this).val();
                    $("#sku").val(sku);
                    location.href = '#step3';
                })
                
                $("#voteSubmit").click(function(){
                    $("#voteForm").submit();
                })
                
                $(".votting .mr5").click(function(){
                    if($(this).attr('checked') == 'checked')
                    {
                        var skus = $("#sku").val();
                        var sku = $(this).val();
                        if(skus == '')
                        {
                                skus = sku;
                        }
                        else
                        {
                                skus += ',' + sku;
                        }
                        $("#sku").val(skus);
                    }
                    else
                    {
                        var skus = $("#sku").val();
                        var sku = $(this).val();
                        if(skus.indexOf(','+sku) != -1)
                        {
                                skus = skus.replace(','+sku, '');
                        }
                        else if(skus.indexOf(sku) != -1)
                        {
                                skus = skus.replace(sku, '');
                        }
                        $("#sku").val(skus);
                    }
                })
                
                $("#skuReset").click(function(){
                    $("#sku").val('');
                    $("#voteForm .mr5").removeAttr('checked');
                    return false;
                })
            })
            function addTags()
            {
                var itemOriginal =document.getElementsByName("tagsInput");
                var arr = new Array(itemOriginal.length);
                for(var j = 0; j < itemOriginal.length;j++){
                    arr[j] = itemOriginal.item(j).value;
                }
         
                var str = "<table><tr><td><input type='url' name='urls[]' id='url2' class='allInput mt5' style='width:509px;' value='' maxlength='390' /></td></tr></table>";
                document.getElementById("tags").innerHTML += str;
                var itemNew =document.getElementsByName("tagsInput");
                for(var i=0;i<arr.length;i++)
                {
                    itemNew.item(i).value = arr[i];
                }
            }
            function showTags()
            {
                var item=document.getElementsByName("tagsInput");
                for(var i=0;i<item.length;i++)
                {
                        document.getElementById("showTags").innerHTML += item[i].value + " ";
                }
            }
        </script>

<?php
echo View::factory('/activity/footer');
?>

        