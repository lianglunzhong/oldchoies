<link type="text/css" rel="stylesheet" href="/css/giveaway.css" media="all" />
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
</script>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Homepage</a>  >  Find Something</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <section class="layout fix">
        <section id="container" class="flr">
            <!------------- Main --------------->
            <div class="fix find">
                <div>
                    <img src="<?php echo STATICURL; ?>/ximg/activity/end_1.png" alt="Winner List" usemap="#Map2" style="display:block;"  title="Winner List" border="0"/>
                    <map name="Map2" id="Map2">
                        <area shape="rect" coords="126,1257,186,1284" href="mailto: lisaconnor@choies.com" target="_blank" alt="Mail to Lisa" title="Mail to Lisa" />
                    </map>
                    <a href="https://www.choies.com/find-something" target="_blank"><img src="<?php echo STATICURL; ?>/ximg/activity/end_2.jpg" alt="Find Something" style="display:block;" border="0" title="Find Something"/></a>
                    <a href="https://www.choies.com/find-something" target="_blank"><img src="<?php echo STATICURL; ?>/ximg/activity/end_3.jpg" alt="Find Something" title="Find Something" style="display:block;" border="0"/></a>
                    <a href="https://www.choies.com/find-something" target="_blank"><img src="<?php echo STATICURL; ?>/ximg/activity/end_4.jpg" alt="Find Something" title="Find Something" style="display:block;" border="0"/></a>
                    <img src="<?php echo STATICURL; ?>/ximg/activity/end_5.png" alt="" style="display:block;" border="0"/>
                </div>
            </div>
            <a name="step5"><img src="<?php echo STATICURL; ?>/ximg/null.png" /></a>
            <dl class="comment">
                <?php
                foreach ($comments as $comment):
                    $skus = explode(',', $comment['sku']);
                    $urls = unserialize($comment['urls']);
                    ?>
                    <dt>
                    <span class="fll"><?php echo $comment['firstname']; ?></span>
                    <span class="red fll">【Found Out: <?php echo count($skus); ?>】</span> 
                    <span class="flr"><?php echo date('F d, Y', $comment['created']); ?></span></dt>
                    <dd><?php echo $comment['comments']; ?></dd>
                    <?php foreach ($urls as $url): ?>
                        <dd><a href="<?php echo $url; ?>"><?php echo $url; ?></a></dd>
                        <?php
                    endforeach;
                endforeach;
                echo $pagination;
                ?>
            </dl>

            </div>
            <!------------- Aside --------------->
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
                <form id="loginForm" method="post" action="<?php echo LANGPATH; ?>/customer/login?redirect=activity/findsomething#step2" class="">
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
                            <span class="forgetpwd"><a href="#">I forgot my password !</a></span>
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
                <form id="registerForm" method="post" action="<?php echo LANGPATH; ?>/customer/register?redirect=activity/findsomething#step2" class="">
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
                            <label><span>*</span> Confirm Password: </label>
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