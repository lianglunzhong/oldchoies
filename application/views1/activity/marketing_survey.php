<link type="text/css" rel="stylesheet" href="/css/giveaway.css" media="all" />
<script src="/js/jquery.validate.min.js"></script>
<style>
.lp_surveys{ padding:0 0 20px;}
.lp_surveys img{ border:0 none;}
.lp_surveys_box{ border:1px solid #dedede; background-color:#fff; margin:-10px 17px 30px; padding:30px 0 25px; font-size:16px;}
.lp_surveys_box .box1{ padding:0 15px; margin-bottom:20px;}
.lp_surveys_box .box1 h1{ font-size:28px; font-style:italic; padding-bottom:25px; font-weight:normal; color:#5a5a5a; font-family:"Times New Roman", Times, serif; text-align:center;}
.lp_surveys_box .box1 h2{ font-size:20px;  color:#5a5a5a; margin-bottom:15px;}
.lp_surveys_box .box1 p{ padding-bottom:20px; color:#49c7fc; line-height:24px;}
.lp_surveys_box .box1 p b{ font-style:italic; color:#49c7fc;}

.lp_surveys .box2{ margin:0 17px;}
.lp_surveys .box2 ul{ width:105%;}
.lp_surveys .box2 ul li{ width:31%; float:left; text-align:center; margin-right:8px; color:#36512f; position:relative;}
.lp_surveys .box2 ul li p.con{ margin:5px 0; height:40px; color:#868686; font-size:14px; padding:0 10px;}
.lp_surveys .box2 ul li p.bottom{ font-size:20px; text-transform:uppercase; text-decoration:underline;}
.lp_surveys .box2 ul li p.b1{ color:#33acb7;}
.lp_surveys .box2 ul li p.b2{ color:#eba806;}
.lp_surveys .box2 ul li p.b3{ color:#cf59b2;}
</style>
<script type="text/javascript">
    var is_login = <?php echo Customer::logged_in() ? '1' : '0'; ?>;
    $(function(){
        $("#enternow").live("click",function(){
            if(!is_login)
            {
                $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                $('#catalog_link').show();
            }else{
                location.href="/activity/marketing_survey_questions";  
            }            
        })
                
        $("#loginForm").live('submit', function(){
            $.post(
            '/customer/login_ajax',
            {
                email: $("#email").val(),
                password: $("#password").val()
            },
            function (data) {
                if (data == 'success')
                {
                    location.href="/activity/marketing_survey_questions";
                }
                else
                {        
                    window.alert(data);
                }
            },
            'json'
        );
            return false;
        })
                
        $("#registerForm").live('submit', function(){
            $.post(
            '/customer/register_ajax',
            {
                email: $("#email1").val(),
                password: $("#password1").val(),
                confirm_password: $("#confirmpassword").val()
            },
            function (data) {
                if (data == 'success')
                {
                    location.href="/activity/marketing_survey_questions"; 
                }
                else
                {        
                    window.alert(data);
                }
            },
            'json'
        );
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
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  Makreting Survey</div>
        </div>
    </div>
    <section class="layout fix">
        <section id="container" class="flr">
           <div class="lp_surveys wid805">
  <p><img src="<?php echo STATICURL; ?>/ximg/activity/new7_surveys.png" /></p>
  <div class="lp_surveys_box">
    <div class="box1">
      <h1>Welcome to Choies Marketing Strategy Survey</h1>
      <h2>Dear Choiesers,</h2>
      <p>You're only moments away from sharing your voice and influencing Choies once again you love.</p>
      <p><b>Choies.com</b> has updated its website on the 13th of February and has made several changes to our product detail page upon your constructive voices we collect from previous surveys, such as adding size references and try-on report, avoid using blurry images and try to display pictures on human models.</p>
      <p>But our endeavor to provide better service and user experience to our valued customers never dies. This time, we'd like to hear your thoughts, opinions and suggestions about our online marketing strategies.</p>
      <p>Participants who complete the whole survey and provide very significant feedbacks and suggestions at the end will be awarded prizes, like free shopping bags, money-saving coupons and a chance to win $50 gift card.</p>
      <p>Plus keep an eye on your email inbox for more great offers from Choies!</p>
      <div class="center"><a href="#" class="surveys_btn" id="enternow"><img src="<?php echo STATICURL; ?>/ximg/activity/new7_surveys_btn2.png" /></a></div>
    </div>
  </div>
  <div class="box2">
      <p class="center mb25"><img src="<?php echo STATICURL; ?>/ximg/activity/new_surveys_tit.png" /></p>
      <ul class="fix">
        <li>
          <div class="top">
            <img src="<?php echo STATICURL; ?>/ximg/activity/new7_surveys01.png" />
            <p class="con">$50 worth of Choies order with Free Shipping</p>
          </div>
          <p class="bottom b1">1 winner</p>
        </li>
        <li>
          <div class="top">
            <img src="<?php echo STATICURL; ?>/ximg/activity/new7_surveys02.png" border="0" usemap="#Map" />
            <map name="Map" id="Map">
              <area shape="rect" coords="138,9,249,166" href="<?php echo BASEURL ;?>/product/choies-environmentally-friendly-shopping-bags-in-beige_p20977" target="_blank" title="CHOIES Environmentally Friendly Shopping Bags in Beige" alt="CHOIES Environmentally Friendly Shopping Bags in Beige" />
            </map>
<p class="con">$19.99 Choies Exclusive Bag</p>
          </div>
          <p class="bottom b2">80 winners</p>
        </li>
        <li>
          <div class="top top1">
            <img src="<?php echo STATICURL; ?>/ximg/activity/new7_surveys03.png" border="0" />
            <p class="con">Only applied to full price items</p>
          </div>
          <p class="bottom b3">Every one will get it</p>
        </li>
      </ul>
    </div>
</div>
        </section>
        <?php echo View::factory(LANGPATH . '/catalog_left'); ?>
    </section>
</section>

<script type="text/javascript">


// croptops_nav
function goto(k){
    var id = "#d"+k;
    var obj = $(id).offset();
    var pos = obj.top - 80;
    
    $("html,body").animate({scrollTop: pos}, 1000);
};

</script>
<div id="catalog_link" class="" style="position: fixed;z-index: 1000;width: 662px; height: 280px; top: 10px; left: 380px;">
    <div style="background:#fff; height: 280px;" id="inline_example2">
        <div class="login">
            <div class="clear"></div>
            <div class="login_l fll ml10">
                <div class="step_form_h2">LOG IN</div>
                <form id="loginForm" method="post" action="#" class="">
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
                            <input type="submit" class="btn40_16_red mr10" value="LOG IN" style="width:100px;" />
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
                <form id="registerForm" method="post" action="#" class="">
                    <ul>
                        <li>
                            <label><span>*</span> Email:</label>
                            <input type="text" id="email1" name="email" class="" />
                            <div class="errorInfo"></div>
                        </li>
                        <li>
                            <label><span>*</span> Password: </label>
                            <input type="password" id="password1" name="password" class="" />
                            <div class="errorInfo"></div>
                        </li>
                        <li>
                            <label><span>*</span> Confirm Pass:</label>
                            <input type="password" id="confirmpassword" name="confirmpassword" class="" />
                            <div class="errorInfo"></div>
                        </li>
                        <li>
                            <input type="submit" class="btn40_16_red mr10"  value="CREAT ACCOUNT" style="width:200px;"/>
                        </li>
                    </ul>
                </form>
                <script type="text/javascript">
                    $("#registerForm").validate($.extend(formSettings,{
                        rules: {            
                            email:{required: true,email: true},
                            password: {required: true,minlength: 5},
                            confirmpassword: {required: true,minlength: 5,equalTo: "#password1"}
                        }
                    }));
                </script>
            </div>
        </div>
    </div>
    <div class="closebtn" style="right: -0px;top: 3px;"></div>
    <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
</div>