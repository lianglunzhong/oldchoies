<style>
.lp_surveys img{ border:0 none;}

.lp_surveys_box{ border:1px solid #ccc; background-color:#fbfbfb; margin:-10px 17px 30px; padding:65px 0 25px; font-size:14px; text-align:center;}
.lp_surveys_box .box1{ padding-bottom:60px; margin-bottom:40px; border-bottom:1px dashed #ccc;}
.lp_surveys_box .box1 p{ padding-bottom:15px;}

.lp_surveys_box h4{ font-size:24px; color:#585757; font-weight:normal; line-height:35px; padding:0 55px;}
.lp_surveys_box .sns{ margin:30px 0 0 33%;}

.lp_surveys_box .box2{ padding:0 5px;}
.lp_surveys_box h1{ font-size:40px; color:#67e1ff; text-transform:uppercase; text-decoration:underline; font-weight:normal; margin:25px 0 35px;}
.lp_surveys_box h5{ font-size:18px; font-weight:normal;}
.lp_surveys_box .box2 .bottom{ font-style:italic;}
.lp_surveys_box .box2 .surveys_btn{ margin:40px 0 20px;}

.lp_surveys .bottom{ color:#8f8d8e; font-size:14px; margin:0 17px;}
.lp_surveys .bottom a{ color:#67E1FF; font-size:16px; font-style:italic; font-weight:bold;}
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
  <p><img src="<?php echo STATICURL; ?>/ximg/activity/new7_surveys.png" /></p>
  <div class="lp_surveys_box">
    <div class="box1">
        <h4>Sorry, the event has been expired. Please pay attention to our social channels for more contests and giveaways.</h4>
        <div class="sns fix">
            <a  href="http://www.facebook.com/choiescloth" target="_blank" class="sns1"></a>
            <a  href="http://twitter.com/#!/choiescloth" target="_blank" class="sns2"></a>
            <a  href="http://choiesclothes.tumblr.com" target="_blank" class="sns3"></a>
            <a  href="http://www.youtube.com/choiesclothes" target="_blank" class="sns4"></a>
            <a  href="http://pinterest.com/choies/" target="_blank" class="sns5"></a>
            <!--<a  href="http://www.chictopia.com/Choies" target="_blank" class="sns6"></a>-->
            <a  href="http://instagram.com/choiescloth" target="_blank" class="sns7"></a>
        </div>
    </div>
  </div>
  <p class="bottom">We will announce our 81 winners on July 21 on our site and via all social channels of Choies. <a href="mailto:lisa@choies.com">Lisa</a> will contact the winners to let you know how to redeem your prizes.  </p>
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