<style>
    .lp_surveys{ background:url(/images/activity/surveys_top.jpg) no-repeat top #85944b; padding:200px 0 20px;}
    .lp_surveys img{ border:0 none;}

    .lp_surveys_box{ border:5px solid #e4e7d9; background-color:#fff; margin:0 20px; padding:20px;}
    .lp_surveys_box .box1{ padding-bottom:10px; margin-bottom:20px; border-bottom:1px dashed #ccc;}
    .lp_surveys_box .box1 h3{ font-size:16px; font-style:italic; padding-bottom:15px; font-weight:normal;}
    .lp_surveys_box .box1 p{ padding-bottom:15px;}
    .lp_surveys_box .box1 .view_btn{ padding:0 20px; height:40px; line-height:40px;}

    .lp_surveys_box .box2 ul li{ width:175px; float:left; text-align:center; margin:0 1px; color:#36512f; position:relative;}
    .lp_surveys_box .box2 ul li .top p{ position:absolute; top:65px; left:0; width:155px; margin:0 10px; z-index:1;}
    .lp_surveys_box .box2 ul li .top1 p{ top:28px;}
    .lp_surveys_box .box2 ul li .top2 p{ top:75px;}
    .lp_surveys_box .box2 ul li .bottom{ font-size:18px; margin:10px 0 0;}
    .lp_surveys{ background:url(/images/activity/surveys_top.jpg) no-repeat top #85944b; padding:200px 0 20px;}
    .lp_surveys img{ border:0 none;}

    .lp_surveys_box{ border:5px solid #e4e7d9; background-color:#fff; margin:0 20px; padding:20px;}
    .lp_surveys_box dl{ padding:0 0 20px;}
    .lp_surveys_box dl dt{ margin:15px 0 10px; font-weight:bold;}
    .lp_surveys_box dl dd{ margin:0 0 5px 10px;}
    .lp_surveys_box dl dd select{ width:170px; padding:5px; background-color:#f4f4f0; border:1px solid #ccc;}
    .lp_surveys_box dl dd .text{ width:170px; height:26px; line-height:26px; margin:0 5px; background-color:#f4f4f0; vertical-align:middle;}
    .lp_surveys_box dl dd textarea{ width:445px; height:130px;}
    .lp_surveys_box dl dt .btn40{ padding:0 20px; border:0 none; height:26px; line-height:26px; margin:0 10px 0 10px;}
    .lp_surveys_box dl dd .checkbox,.lp_surveys_box dl dd .radio{ margin-right:5px; vertical-align:middle;}

    .lp_surveys_box dl dd.mb20{ margin-bottom:20px;}
    .lp_surveys_box dl dd span{ display:inline-block; vertical-align:middle;}
    .lp_surveys_box dl dd span.s1{ width:300px; margin:0 10px 0 0;}
    .lp_surveys_box dl dd span.s2{ width:65px; text-align:center; margin:0 5px;}
    .lp_surveys_box dl dt.last{ font-weight:normal;}

    .lp_surveys{ background:url(/images/activity/surveys_top.jpg) no-repeat top #85944b; padding:200px 0 20px;}
    .lp_surveys img{ border:0 none;}

    .lp_surveys_box{ border:5px solid #e4e7d9; background-color:#fff; margin:0 20px; padding:20px;}
    .lp_surveys_box .box1{ padding-bottom:10px; margin-bottom:20px; border-bottom:1px dashed #ccc;}
    .lp_surveys_box .box1 p{ padding-bottom:15px;}

    .lp_surveys_box .f24{ font-size:24px; line-height:40px; color:#36512f;}
    .lp_surveys_box .f24 span{ color:#ffa200; text-shadow:0 0 1px #36512f;}
    .lp_surveys_box .f24 .border{ display:inline-block; *display:inline; padding:3px 20px; border:1px solid #ccc; margin:20px 0;}

</style>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  Questionnaire</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <section class="layout fix">
        <section id="container" class="flr">
            <!-------------ES_Questionnaire---------------->
            <div class="lp_surveys wid805">
                <?php
                $over = 1;
                $customer_id = Customer::logged_in();
                if ($over OR !$customer_id)
                {
                    ?>
                    <div class="lp_surveys_box">
                        <div class="box1">
                            <h3>Dear Choiesers,</h3>
                            <p>On the 13th of February, Choies.com has updated its website to provide more information and easier use to you. As a valued member
                                of Choies, we'd like to hear your thoughts and opinions about your experience shopping with our new look.</p>
                            <p>Your responses are very important to us and your help to our improvement will be greatly appreciated.</p>
                            <p>Participants who complete the whole survey and provide very significant feedbacks and suggestions at the end will be awarded prizes.</p>
<!--                            <p class="center"><a href="#" class="view_btn btn26 btn40 JS_popwinbtn1">Sign In to Enter</a></p>-->
                            <p style="text-align:center;color:#d8271c;font-size:22px;">The activity is over, thanks for your participation and support.</p>
                        </div>
                        <div class="box2">
                            <p class="center mb25"><img src="<?php echo STATICURL; ?>/ximg/activity/surveys_tit1.png" /></p>
                            <ul class="fix">
                                <li>
                                    <div class="top">
                                        <img src="<?php echo STATICURL; ?>/ximg/activity/surveys_prize1.jpg" />
                                        <p>($100 worth of Choies order with Free Shipping)</p>
                                    </div>
                                    <p class="bottom">1 winner</p>
                                </li>
                                <li>
                                    <div class="top">
                                        <img src="<?php echo STATICURL; ?>/ximg/activity/surveys_prize2.jpg" />
                                        <p>($50 worth of Choies order with Free Shipping)</p>
                                    </div>
                                    <p class="bottom">3 winners</p>
                                </li>
                                <li>
                                    <div class="top top1">
                                        <img src="<?php echo STATICURL; ?>/ximg/activity/surveys_prize3.jpg" border="0" usemap="#Map" />
                                        <map name="Map" id="Map">
                                            <area shape="rect" coords="13,41,90,124" href="<?php echo BASEURL ;?><?php echo LANGPATH; ?>/product/choies-environmentally-friendly-shopping-bags-in-black" title="CHOIES Environmentally Friendly Shopping Bags in Black" alt="CHOIES Environmentally Friendly Shopping Bags in Black" target="_blank" />
                                            <area shape="rect" coords="91,42,154,122" href="<?php echo BASEURL ;?><?php echo LANGPATH; ?>/product/choies-environmentally-friendly-shopping-bags-in-beige" title="CHOIES Environmentally Friendly Shopping Bags in Beige" alt="CHOIES Environmentally Friendly Shopping Bags in Beige" target="_blank" />
                                        </map>
                                        <p>($19.99  Randomly Sent)</p>
                                    </div>
                                    <p class="bottom">10 winners</p>
                                </li>
                                <li>
                                    <div class="top top2">
                                        <img src="<?php echo STATICURL; ?>/ximg/activity/surveys_prize4.jpg" />
                                        <p>(Only applied to full price items)</p>
                                    </div>
                                    <p class="bottom">Everyone will get it</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php
                }
                else
                {
                    ?>
                    <div class="lp_surveys_box">
                        <form action="#" method="post" class="form" id="questionForm">
                            <dl>
                                <dt>1. What's your country of residence ?</dt>
                                <dd>
                                    <select name="q1">
                                        <option value="">Select A Country</option>
                                        <?php
                                        $countries = Site::instance()->countries();
                                        foreach ($countries as $c)
                                        {
                                            ?>
                                            <option name="<?php echo $c['isocode']; ?>"><?php echo $c['name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </dd>
                                <dt>2. How long have you been a Choies member ?</dt>
                                <div id="question2div">
                                    <dd><input type="radio" name="q2" value="new customer" class="radio" /> New customer today</dd>
                                    <dd><input type="radio" name="q2" value="Less than 1 month" class="radio" /> Less than 1 month</dd>
                                    <dd><input type="radio" name="q2" value="1 - 6 months" class="radio" /> 1 - 6 months</dd>
                                    <dd><input type="radio" name="q2" value="7 - 12 months" class="radio" /> 7 - 12 months</dd>
                                    <dd><input type="radio" name="q2" value="More than one year" class="radio" /> More than one year</dd>
                                    <dd><input type="radio" name="q2" value="Not sure" class="radio" /> Not sure</dd>
                                    <input type="hidden" name="question2" id="question2" value="" />
                                </div>
                                <script>
                                    $(function(){
                                        $("#question2div .radio").click(function(){
                                            var value = $(this).val();
                                            $("#question2").val(value);
                                            if(value == 'new customer')
                                            {
                                                $("#question4div").hide();
                                                $("#q7title").text('Please tell us what area and/or feature you find the worst designed on our website?');
                                                $("#question4div .radio").attr('name', 'q4-1');
                                                $(".num5").text(4);
                                                $(".num6").text(5);
                                                $(".num7").text(6);
                                                $(".num8").text(7);
                                                $(".num9").text(8);
                                                $(".num10").text(9);
                                            }
                                            else
                                            {
                                                $("#question4div").show();
                                                $("#q7title").text('Please tell us what area and/or feature you find the most improved over our previous website?');
                                                $("#question4div .radio").attr('name', 'q4');
                                                $(".num5").text(5);
                                                $(".num6").text(6);
                                                $(".num7").text(7);
                                                $(".num8").text(8);
                                                $(".num9").text(9);
                                                $(".num10").text(10);
                                            }
                                        })
                                    })
                                </script>

                                <dt>3. How do you prefer to shop on Choies ?</dt>
                                <div id="question3div">
                                    <dd><input type="radio" name="q3" value="Tablet" class="radio" /> Tablet</dd>
                                    <dd><input type="radio" name="q3" value="Smartphone" class="radio" /> Smartphone</dd>
                                    <dd><input type="radio" name="q3" value="Desktop" class="radio" /> Desktop</dd>
                                    <dd><input type="radio" name="q3" value="Laptop" class="radio" /> Laptop</dd>
                                    <dd>Other (please specify) <input type="text" value="enter text..." name="q3-1" class="text" /></dd>
                                    <input type="hidden" name="question3" id="question3" value="" />
                                </div>
                                <script>
                                    $(function(){
                                        $("#question3div .radio").click(function(){
                                            var value = $(this).val();
                                            $("#question3").val(value);
                                        })
                                    })
                                </script>
                                <div id="question4div">
                                    <dt>4. Compared to our old site, is the new site_______ ?</dt>
                                    <dd><input type="radio" name="q4" value="Better" class="radio" /> Better</dd>
                                    <dd><input type="radio" name="q4" value="Worse" class="radio" /> Worse</dd>
                                    <dd><input type="radio" name="q4" value="No noticeable changes" class="radio" /> No noticeable changes</dd>
                                    <input type="hidden" name="question4" id="question4" value="" />
                                    <script>
                                    $(function(){
                                        $("#question4div .radio").click(function(){
                                            var value = $(this).val();
                                            $("#question4").val(value);
                                        })
                                    })
                                    </script>
                                </div>

                                <dt><span class="num5">5</span>. How would you rate our website on the following parameters ?</dt>
                                <dd class="mb20">
                                    <span class="s1">&nbsp;</span>
                                    <span class="s2">Very Poor</span>
                                    <span class="s2">Poor</span>
                                    <span class="s2">Average</span>
                                    <span class="s2">Good</span>
                                    <span class="s2">Excellent</span>
                                </dd>
                                <dd class="mb20">
                                    <span class="s1">Look and feel of the website (i.e. clean fonts, prettiness)</span>
                                    <span class="s2"><input type="radio" name="q5_1" value="Very Poor" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_1" value="Poor" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_1" value="Average" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_1" value="Good" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_1" value="Excellent" class="" /></span>
                                </dd>
                                <dd class="mb20">
                                    <span class="s1">Organization of the content</span>
                                    <span class="s2"><input type="radio" name="q5_2" value="Very Poor" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_2" value="Poor" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_2" value="Average" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_2" value="Good" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_2" value="Excellent" class="" /></span>
                                </dd>
                                <dd class="mb20">
                                    <span class="s1">Ease of finding information (ease of navigation and effectiveness of use)</span>
                                    <span class="s2"><input type="radio" name="q5_3" value="Very Poor" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_3" value="Poor" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_3" value="Average" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_3" value="Good" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_3" value="Excellent" class="" /></span>
                                </dd>
                                <dd class="mb20">
                                    <span class="s1">Content (clarity of language used, spelling, grammar)</span>
                                    <span class="s2"><input type="radio" name="q5_4" value="Very Poor" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_4" value="Poor" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_4" value="Average" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_4" value="Good" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_4" value="Excellent" class="" /></span>
                                </dd>
                                <dd class="mb20">
                                    <span class="s1">Website response and performance</span>
                                    <span class="s2"><input type="radio" name="q5_5" value="Very Poor" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_5" value="Poor" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_5" value="Average" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_5" value="Good" class="" /></span>
                                    <span class="s2"><input type="radio" name="q5_5" value="Excellent" class="" /></span>
                                </dd>

                                <dt><span class="num6">6</span>. How would you rate some components on our website on the following parameters ?</dt>
                                <dd class="mb20">
                                    <span class="s1">&nbsp;</span>
                                    <span class="s2">Very Poor</span>
                                    <span class="s2">Poor</span>
                                    <span class="s2">Average</span>
                                    <span class="s2">Good</span>
                                    <span class="s2">Excellent</span>
                                </dd>
                                <dd class="mb20">
                                    <span class="s1">Account page (ease of use and completeness of order info and setting)</span>
                                    <span class="s2"><input type="radio" name="q6_1" value="Very Poor" class="" /></span>
                                    <span class="s2"><input type="radio" name="q6_1" value="Poor" class="" /></span>
                                    <span class="s2"><input type="radio" name="q6_1" value="Average" class="" /></span>
                                    <span class="s2"><input type="radio" name="q6_1" value="Good" class="" /></span>
                                    <span class="s2"><input type="radio" name="q6_1" value="Excellent" class="" /></span>
                                </dd>
                                <dd class="mb20">
                                    <span class="s1">Whole buying experience (the clearness of checkout process)</span>
                                    <span class="s2"><input type="radio" name="q6_2" value="Very Poor" class="" /></span>
                                    <span class="s2"><input type="radio" name="q6_2" value="Poor" class="" /></span>
                                    <span class="s2"><input type="radio" name="q6_2" value="Average" class="" /></span>
                                    <span class="s2"><input type="radio" name="q6_2" value="Good" class="" /></span>
                                    <span class="s2"><input type="radio" name="q6_2" value="Excellent" class="" /></span>
                                </dd>
                                <dd class="mb20">
                                    <span class="s1">Your overall experience with Choies</span>
                                    <span class="s2"><input type="radio" name="q6_3" value="Very Poor" class="" /></span>
                                    <span class="s2"><input type="radio" name="q6_3" value="Poor" class="" /></span>
                                    <span class="s2"><input type="radio" name="q6_3" value="Average" class="" /></span>
                                    <span class="s2"><input type="radio" name="q6_3" value="Good" class="" /></span>
                                    <span class="s2"><input type="radio" name="q6_3" value="Excellent" class="" /></span>
                                </dd>

                                <dt><span class="num7">7</span>. <span id="q7title">Please tell us what area and/or feature you find the most improved over our previous website?</span> (Check All That Apply)</dt>
                                <dd><input type="checkbox" name="q7[]" value="Site Navigation" class="checkbox" /> Site Navigation</dd>
                                <dd><input type="checkbox" name="q7[]" value="Overall Layout and Colors" class="checkbox" /> Overall Layout and Colors</dd>
                                <dd><input type="checkbox" name="q7[]" value="Homepage" class="checkbox" /> Homepage</dd>
                                <dd><input type="checkbox" name="q7[]" value="List page" class="checkbox" /> List page</dd>
                                <dd><input type="checkbox" name="q7[]" value="List page" class="checkbox" /> Product view page</dd>
                                <dd><input type="checkbox" name="q7[]" value="Account page" class="checkbox" /> Account page</dd>
                                <dd><input type="checkbox" name="q7[]" value="Checkout process" class="checkbox" /> Checkout process</dd>
                                <dd><input type="checkbox" name="q7[]" value="Social Interactio" class="checkbox" /> Social Interaction</dd>
                                <dd><input type="checkbox" name="q7[]" value="Loading Time" class="checkbox" /> Loading Time</dd>
                                <dd>Other (please specify) <input type="text" value="enter text..." name="q7-1" class="text" /></dd>
                                <input type="hidden" name="question7" id="question7" value="" />


                                <dt><span class="num8">8</span>. Did you find the information you were looking for on this website ?</dt>
                                <div id="question8div">
                                    <dd><input type="radio" name="q8" value="Yes" class="radio" /> Yes</dd>
                                    <dd><input type="radio" name="q8" value="No" class="radio" /> No</dd>
                                    <dd><input type="radio" name="q8" value="No sure" class="radio" /> No sure</dd>
                                    <input type="hidden" name="question8" id="question8" value="" />
                                </div>
                                <script>
                            $(function(){
                                $("#question8div .radio").click(function(){
                                    var value = $(this).val();
                                    $("#question8").val(value);
                                })
                            })
                                </script>

                                <dt><span class="num9">9</span>. What would make you shop more often on Choies ? (select up to 3)</dt>
                                <div id="question9div">
                                    <dd><input type="checkbox" name="q9[]" value="Site translation into my local language" class="checkbox" /> Site translation into my local language</dd>
                                    <dd><input type="checkbox" name="q9[]" value="Lower prices" class="checkbox" /> Lower prices</dd>
                                    <dd><input type="checkbox" name="q9[]" value="More sizes" class="checkbox" /> More sizes</dd>
                                    <dd><input type="checkbox" name="q9[]" value="Different and better designs of garment, shoes or accessories" class="checkbox" /> Different and better designs of garment, shoes or accessories</dd>
                                    <dd><input type="checkbox" name="q9[]" value="More inventory in the product I like" class="checkbox" /> More inventory in the product I like</dd>
                                    <dd><input type="checkbox" name="q9[]" value="Better shipping policies" class="checkbox" /> Better shipping policies</dd>
                                    <dd><input type="checkbox" name="q9[]" value="Different brands" class="checkbox" /> Different brands</dd>
                                    <dd>Other (please specify) <input type="text" value="enter text..." name="q9-1" class="text" /></dd>
                                    <input type="hidden" value="question9" id="question9" value="" />
                                </div>
                                <script>
                            $(function(){
                                $("#question9div .checkbox").click(function(){
                                    if($(this).attr('checked') == true)
                                    {
                                        if($("input[name='q9[]']:checked").length > 3)
                                        {
                                            return false;
                                        }
                                    }
                                })
                            })
                                </script>
                                <dt><span class="num10">10</span>. What additional features would you like to see on the Choies website ?</dt>
                                <dd>
                                    <textarea id="question10" name="question10">More significant advice and suggestions provided, more chances you will be awarded prizes.</textarea>
                                    <input type="hidden" name="q10" id="q10" value="" />
                                    <script>
                                $(function(){
                                    $("#question10").live('focusin', function(){
                                        $(this).addClass('inputfocus');
                                        if(this.value==this.defaultValue){
                                            this.value='';
                                        }
                                    }).focusout(function(){
                                        $(this).removeClass('inputfocus');
                                        if(this.value==''){
                                            this.value=this.defaultValue;
                                        }
                                    })
                                    $("#question10").keyup(function(){
                                        var value = $(this).val();
                                        $("#q10").val(value);
                                    })
                                })
                                    </script>
                                </dd>

                                <dt class="last"><input type="submit" name="" value="Submit" class="view_btn btn40" /> Please complete all the questions above</dt>
                            </dl>
                        </form>
                    </div>
                    <script>
                $("#questionForm").validate({
                    rules: {
                        q1: {
                            required: true
                        },
                        q2: {
                            required: true
                        },
                        q3: {
                            required: true
                        },
                        q4: {
                            required: true
                        },
                        q5_1: {
                            required: true
                        },
                        q5_2: {
                            required: true
                        },
                        q5_3: {
                            required: true
                        },
                        q5_4: {
                            required: true
                        },
                        q5_5: {
                            required: true
                        },
                        q6_1: {
                            required: true
                        },
                        q6_2: {
                            required: true
                        },
                        q6_3: {
                            required: true
                        },
                        q7: {
                            required: true
                        },
                        q8: {
                            required: true
                        },
                        q9: {
                            required: true
                        },
                        q10: {
                            required: true
                        }
                    }
                });
                                        
                    </script>
                    <?php
                }
                ?>
            </div>
        </section>
        <?php echo View::factory(LANGPATH . '/catalog_left'); ?>
    </section>
</section>
<div class="JS_popwincon1 popwincon w_signup hide">
    <a class="JS_close2 close_btn2"></a>
    <div class="fix">
        <div class="left" style="width:auto;margin-right:30px;padding-right:30px;">
            <h3>CHOIES Member Sign In</h3>
            <form action="/customer/login?redirect=/activity/update_questionnaire" method="post" class="signin_form sign_form form">
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
                        $redirect = Arr::get($_GET, 'redirect', '');
                        $page = isset($_SERVER['HTTP_SELF']) ? BASEURL . $_SERVER['HTTP_SELF'] . '/' . htmlspecialchars($redirect) : BASEURL . '/' . htmlspecialchars($redirect);
                        $facebook = new facebook();
                        $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                        ?>
                        <a href="<?php echo $loginUrl; ?>" class="facebook-btn">Sign in with Facebook</a>
                    </li>
                </ul>
            </form>
        </div>
        <div class="right">
            <h3>CHOIES Member Sign Up</h3>
            <form action="/customer/register?redirect=/activity/update_questionnaire" method="post" class="signup_form sign_form form">
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