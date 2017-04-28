<style>
.lp_surveys img{ border:0 none;}

.lp_surveys_box{ border:1px solid #ccc; margin:-10px 17px 30px; padding:65px 0 25px; font-size:14px; text-align:center;}
.lp_surveys_box .box1{ padding-bottom:60px; margin-bottom:40px; border-bottom:1px dashed #ccc;}
.lp_surveys_box .box1 p{ padding-bottom:15px;}

.lp_surveys_box h2{ font-size:36px; color:#50dcff; text-transform:uppercase; margin-bottom:25px; font-weight:normal;}
.lp_surveys_box h4{ font-size:24px; color:#50dcff; font-weight:normal; line-height:24px;}

.lp_surveys_box .box2{ padding:0 5px;}
.lp_surveys_box h1{ font-size:40px; color:#50dcff; text-transform:uppercase; text-decoration:underline; font-weight:normal; margin:25px 0 35px;}
.lp_surveys_box h5{ font-size:18px; font-weight:normal;}
.lp_surveys_box .box2 .bottom{ font-style:italic;}
.lp_surveys_box .box2 .surveys_btn{ margin:40px 0 20px;}

.lp_surveys .bottom{ color:#8f8d8e; font-size:14px; margin:0 17px;}
.lp_surveys .bottom a{ color:#50dcff; font-size:16px; font-style:italic; font-weight:bold;}
</style>
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
  <p><img src="/images/activity/new7_surveys.png" /></p>
  <div class="lp_surveys_box">
    <div class="box1">
        <h2>Thank You!</h2>
        <h4>You have submitted your survey successfully!</h4>
    </div>
    <div class="box2">
      <h5>Here is your 15% off Coupon Code:</h5>
      <h1>CHOIESMSS0035ER</h1>
      <p class="bottom">This code can only be used once and be valid within a month, it can only be applied to items of full price, sale items excluded. This code has been sent to your email box and your code list in account page, please check later.</p>
      <p class="surveys_btn"><a href="/"><img src="/images/activity/new7_surveys_btn1.png" /></a></p>
    </div>
  </div>
  <p class="bottom">We will announce our 81 winners on July 21 on our site and via all social channels of Choies.  <a href="mailto:lisa@choies.com">Lisa</a> will contact the winners to let you know how to redeem your prizes. </p>
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