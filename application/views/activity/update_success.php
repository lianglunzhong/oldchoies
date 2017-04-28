<style>
    .lp_surveys{ background:url(/images/activity/surveys_top.jpg) no-repeat top #85944b; padding:200px 0 20px;}
    .lp_surveys img{ border:0 none;}

    .lp_surveys_box{ border:5px solid #e4e7d9; background-color:#fff; margin:0 20px; padding:20px;}
    .lp_surveys_box .box1{ padding-bottom:10px; margin-bottom:20px; border-bottom:1px dashed #ccc;}
    .lp_surveys_box .box1 p{ padding-bottom:15px;}

    .lp_surveys_box .f24{ font-size:24px; line-height:40px; color:#36512f;}
    .lp_surveys_box .f24 span{ color:#ffa200; text-shadow:0 0 1px #36512f;}
    .lp_surveys_box .f24 .border{ display:inline-block; *display:inline; padding:3px 20px; border:1px solid #ccc; margin:20px 0;}
    
    .lp_surveys_box .box1 .view_btn{ padding:0 20px; height:40px; line-height:40px;}
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
                <div class="lp_surveys_box">
                    <div class="box1">
                        <div class="f24 center">Thank You!<br />
                            You have submitted your survey successfully!<br />
                            Here is your <span>20%</span> Coupon Code:<br />
                            <p class="border">WERXDG0034ER</p>
                        </div>
                        <p>This code can only be applied to items of full price, sale items excluded. This code has been sent to your email box and your code list in account page, please check later.</p>
                    </div>
                    <p>We will announce our 14 winners on March 13 on our site and via all social channels of Choies. <a class="red" href="mailto:lisaconnor@choies.com">Lisa</a> will contact the winners to let you know how to redeem your prizes. </p>
                    <p class="center"><a href="/" class="view_btn btn26 btn40">Continue Shopping</a></p>
                </div>
            </div>
        </section>
        <?php echo View::factory(LANGPATH . '/catalog_left'); ?>
    </section>
</section>