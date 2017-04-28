<style>
    .lp_match{ width:820px;}
    .lp_match img{ display:block;}
    .match_sign{ width:520px; height:380px; background:url(../images/activity/match_bg1.jpg) no-repeat; padding:52px 0 0 300px;}
    .match_sign span{float:left; margin-right:5px; line-height:101px; font-size:14px;}
    .match_sign .up a,.match_sign .in a{ width:96px; height:101px; background:url(../images/activity/find_btn1.png) no-repeat; display:block;}
    .match_sign .up a:hover{background:url(../images/activity/find_btn1.png) -100px 0px no-repeat;}
    .match_sign .in a{background:url(../images/activity/find_btn1.png) 0px -105px no-repeat;}
    .match_sign .in a:hover{background:url(../images/activity/find_btn1.png) -100px -105px no-repeat;}
    .match_box{ position:relative;}
    .match_box .con{ position:absolute; bottom:165px; left:500px; width:285px; font-size:14px; z-index:1;}
    .match_box .con .tit{ border-bottom:1px dashed #ccc; padding:0 0 20px; margin:0 0 20px;}
    .match_box .con .tit h2{ font-size:22px; margin-bottom:10px;}
    .match_box .con .tit span{color:#cc0000;}
    .match_box .con .tit a{ color:#cc0000; text-decoration:underline;}
    .match_box .con .text{ width:240px; height:30px; border:1px solid #ccc; padding:0 5px; line-height:30px; margin-top:10px;}

    .match_form{ margin: 15px 0 40px 130px; width:565px;}
    .match_form li{ margin-bottom:15px;}
    .match_form li label{ margin-right:10px;}
    .match_form li label span{ color:#f00;}
    .match_form li .text{ width:265px; height:28px; padding:0 5px; border:1px solid #ccc;}
    .match_form li textarea { width:553px; height:150px; border:1px solid #ccc; padding:5px; color:#999; margin:5px 0 0;}
    .match_form li .share_con{ margin:10px 0 0; border:1px dashed #ccc; padding:10px;}
    .match_form li .share_con b{ color:#666; text-transform:uppercase;}
    .match_form li .share_con a{ display:inline-block; background:url(../images/activity/icon1.png) no-repeat; padding:2px 0 2px 25px; text-transform:uppercase; margin:0 0 0 20px;}
    .match_form li .share_con a.share1{ background-position:0 0;}
    .match_form li .share_con a.share2{ background-position:0 -23px;}
    .match_form li .share_con a.share3{ background-position:0 -46px;}
    .match_form li .share_con p.bottom{ margin:5px 0 0; font-style:italic; color:#5f9514; font-size:11px;}
    .match_form li .long_text{ width:553px; margin-bottom:10px;}
    .match_form li .add_btn{ background:url(../images/activity/icon1.png) no-repeat 0 -93px; padding-left:18px; color:#f00; font-family:Tahoma, Geneva, sans-serif; text-decoration:underline;}
    .match_form li .btn{width:228px; height:42px; background:url(../images/activity/find_btn1.png) no-repeat 0 -219px; margin:5px 0 0 165px;}
    .match_form li .btn:hover{ background-position:0 -262px; cursor:pointer;}

    .match_comments span{ margin-right:10px;}
    .match_comments span.red{ color:#c00;}
    .match_comments dt,.match_comments dd{ padding:0 40px;line-height:18px;}
    .match_comments dt{ background-color:#fafaf8; height:30px; line-height:30px; margin-top:15px;}
    .match_comments dd a{ text-decoration:underline; color:#0066ff;}

    .match_page a{ text-decoration:none; color:#808080; padding:2px 7px; border:1px solid #ccc; display:inline-block; margin-left:5px; line-height:normal;}
    .match_page a:hover,.match_page .on{color:#F66; border:#F66 1px solid;}
    .successText{ font-size:15px; color:#666; margin:30px 0 30px 0;}
</style>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Home</a>  >  Find Something</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <section class="layout fix">
        <section id="container" class="flr">
            <!------------- Main --------------->
            <div class="lp_match">
                <div id="step1"></div>
<!--                        <p><img src="/images/activity/match_banner.jpg" alt="" /></p>
                <div class="match_sign fix">
                <?php
                $customer_id = Customer::logged_in();
                if (!$customer_id):
                    ?>
                                        <span class="up"><a href="#" title="Sign up" id="registerLink"></a></span>
                                        <span>or</span>
                                        <span class="in"><a href="#" title="Sign in" id="loginLink"></a></span>
                <?php else: ?>
                                        <div class="successText pl90">YOU ARE IN NOW!</div>
                <?php endif; ?>
                </div>-->
                <p><img src="/images/activity/match_winner1.png" /></p>
                <p><img src="/images/activity/match_winner2.png" /></p>
                <p><img src="/images/activity/match_winner3.png" /></p>
                <p><img src="/images/activity/match_winner4.png" border="0" usemap="#Map" />
                    <map name="Map" id="Map">
                        <area shape="rect" coords="151,311,206,343" href="mailto: lisaconnor@choies.com" />
                    </map>
                </p>
                <p><img src="/images/activity/match_missingtit.png" /></p>
                <div id="step2"></div>
                <form action="#" method="post" id="winForm">
                    <div class="match_box">
                        <img src="/images/activity/match_img1.jpg" alt="" />
                        <div class="con">
                            <div class="tit">
                                <h2>Use Your FQ to Match It!</h2>
                                <span><a href="<?php echo LANGPATH; ?>/bottoms" target="_blank">Click Here to Find the Bottoms</a> >></span>
                            </div>
<!--                                                <div class="bottom">SKU of the item that you match:<input type="text" name="sku1" value="" class="text" /></div>-->
                        </div>
                    </div>
                    <div class="match_box">
                        <img src="/images/activity/match_img2.jpg" alt="" />
                        <div class="con">
                            <div class="tit">
                                <h2>Congrats! Level Up! <br />Come on~</h2>
                                <span><a href="<?php echo LANGPATH; ?>/shoes" target="_blank">Click Here to Find the Shoes</a> >></span>
                            </div>
<!--                                                <div class="bottom">SKU of the item that you match:<input type="text" name="sku2" value="" class="text" /></div>-->
                        </div>
                    </div>
                    <div class="match_box">
                        <img src="/images/activity/match_img3.jpg" alt="" />
                        <div class="con">
                            <div class="tit">
                                <h2>OMG! Quite a CHALLENGE, Right? Hold On~</h2>
                                <span><a href="<?php echo LANGPATH; ?>/accessory" target="_blank">Click Here to Find the Accessories</a> >></span>
                            </div>
<!--                                                <div class="bottom">SKU of the item that you match:<input type="text" name="sku3" value="" class="text" /></div>-->
                        </div>
                    </div>
                    <!--                                <div id="step4"></div>
                                                    <p><img src="/images/activity/match_tit1.jpg" /></p>
                              
                                                    <ul class="match_form">
                                                            <li>
                                                                    <label><span>*</span> Name: </label>
                                                                    <input type="text" name="name" value="" class="text" /><br/>
                                                            </li>
                                                            <li>
                                                                    <label><span>*</span> Comments:</label>
                                                                    <textarea name="comments" onblur="this.value=(this.value=='')?'Say something about this \'Match the Missing\' Activity.':this.value" value="Say something about this 'Match the Missing' Activity." onfocus="this.value=(this.value=='Say something about this \'Match the Missing\' Activity.')?'':this.value">Say something about this 'Match the Missing' Activity.</textarea>
                                                            </li>
                                                            <li>
                                                                    <label><span>*</span> Share URL/Links (<em>More share links, more chances to win.</em>)</label><br/>
                                                                    <div class="share_con">
                                                                            <p>
                                                                                    <b>Share to:</b>
                    <?php $domain = Site::instance()->get('domain'); ?>
                                                                                    <a rel="nofollow" target="_blank" class="share1"  href="http://www.facebook.com/sharer.php?u=<?php echo urlencode('http://www.choies.com/activity/matchtowin'); ?>"> FACEBOOK</a>
                                                                                    <a rel="nofollow" target="_blank" class="share2"  href="http://twitter.com/share?url=<?php echo urlencode('http://www.choies.com/activity/matchtowin'); ?>"> TWITTER</a>
                                                                                    <a rel="nofollow" target="_blank" class="share3"  href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode('http://www.choies.com/activity/matchtowin'); ?>&media=http://www.choies.com/images/activity/match_img1.jpg&description=<?php echo urlencode("Choies \"Let's Play & Win\" Season 2 --- Play the game and win free items + points ! Don't miss it!"); ?>"> PIN IT</a>
                                                                            </p>
                                                                            <p class="bottom">Or you can share to your personal blogs and any other social network. Just leave the share URL/Links above.</p>
                                                                    </div>
                                                            </li>
                                                            <li>
                                                                    <input type="url" name="url" id="url2" value="" class="text long_text" />
                                                                    <input type="url" name="urls[]" id="url2" value="" class="text long_text" />
                                                                    <input type="url" name="urls[]" id="url2" value="" class="text long_text" />
                                                                    <div id="tags"></div>
                                                                    <p><a href="javascript:;" class="add_btn" onclick="addTags()">Add one more link</a></p>
                                                            </li>
                                                            <li><input type="submit" value="" class="btn" /></li>
                                                    </ul>
                                            </form>
                                            <script type="text/javascript">
                                                    $("#winForm").validate($.extend(formSettings,{
                                                            rules: {
                                                                    name:{required: true},
                                                                    sku1:{required: true},
                                                                    sku2:{required: true},
                                                                    sku3:{required: true},
                                                                    comment: {required: true,minlength: 5},
                                                                    url: {required: true}
                                                            }
                                                    }));
                                            </script>-->
                    <div id="step5"></div>
                    <?php if (!empty($comments)): ?>
                        <p><img src="/images/activity/match_tit2.jpg" /></p>
                        <dl class="match_comments">
                            <?php
                            foreach ($comments as $comment):
                                $urls = unserialize($comment['urls']);
                                $skus = str_replace(',', ', ', $comment['sku']);
                                ?>
                                <dt class="fix">
                                <span class="fll"><?php echo $comment['firstname']; ?></span>   
                                <span class="red fll"><?php echo $skus; ?></span> 
                                <span class="flr"><?php echo date('M d, Y', $comment['created']); ?></span>
                                </dt>
                                <dd><?php echo $comment['comments'] ?></dd>
                                <?php
                                if (!empty($urls))
                                {
                                    foreach ($urls as $url)
                                    {
                                        echo '<dd><a rel="nofollow" target="_blank" href="' . $url . '">' . $url . '</a></dd>';
                                    }
                                }
                            endforeach;
                            ?>
                            <dt class="fix">
                            <?php echo $pagination; ?>
                            </dt>
                        </dl>
                    <?php endif; ?>
            </div>

        </section>
        <?php echo View::factory('/catalog_left'); ?>
    </section>
</section>
<div id="catalog_link" class="" style="position: fixed;z-index: 1000;width: 662px; height: 280px; top: 70px; left: 380px;">
    <div style="background:#fff; height: 280px;" id="inline_example2">
        <div class="login">
            <div class="clear"></div>
            <div class="login_l fll ml10">
                <div class="step_form_h2">LOG IN</div>
                <form id="loginForm" method="post" action="<?php echo LANGPATH; ?>/customer/login?redirect=activity/matchtowin#step2" class="">
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
                <form id="registerForm" method="post" action="<?php echo LANGPATH; ?>/customer/register?redirect=activity/matchtowin#step2" class="">
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
    })
        
    function addTags()
    {
        var itemOriginal =document.getElementsByName("tagsInput");
        var arr = new Array(itemOriginal.length);
        for(var j = 0; j < itemOriginal.length;j++){
            arr[j] = itemOriginal.item(j).value;
        }
         
        var str = '<input type="url" name="urls[]" id="url2" value="" class="text long_text" />';
        document.getElementById("tags").innerHTML += str;
        var itemNew =document.getElementsByName("tagsInput");
        for(var i=0;i<arr.length;i++)
        {
            itemNew.item(i).value = arr[i];
        }
    }
    function showTags(){
        var item=document.getElementsByName("tagsInput");
        for(var i=0;i<item.length;i++)
        {
            document.getElementById("showTags").innerHTML += item[i].value + " ";
        }
    }
</script>