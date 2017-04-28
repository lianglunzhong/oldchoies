<style>
      .sign{text-align: center;font-size:14px;font-weight:bold;height:48px;line-height: 48px;background: #f2ead6;}
      .sign a{color:#9e5d00;text-decoration: underline;}
      .survey form{margin-bottom: 60px;font-size:13px;}
      .survey form dt{margin-top: 30px;font-weight: bold;}
      .survey form dd{line-height: 25px;}
      .survey form input{display: inline;}
      .error{color:#ff0000;}
      .btn-sub{padding:8px 45px;background: #9e5d00;font-size: 18px;margin-top: 20px;display: block;color:#fff;}
</style>
<body>
  <div class="site-content">
      <div class="main-container clearfix">
          <div class="container">
            <div class="row">
              <div class="col-xs-12"><a href=""><img src="<?php echo STATICURL; ?>/assets/images/activity/1602/survey-0225.jpg"></a></div>
              <?php echo Message::get(); ?>
              <?php if(!$customer_id = Customer::logged_in()){ ?>
              <div class="col-xs-12"><p class="sign">Please <a href="/customer/login?redirect=/activity/choies_questionnaire201603">SIGN IN</a> first to start the survey.</p></div>
              <?php } ?>
                    <div class="col-xs-12 survey">
                      <p class="col-sm-2 hidden-xs">&nbsp;</p>
                      <form action="#" method="post" class="form col-sm-8 col-xs-12" id="formquest">
                    <dl>
                    <span id="ques1">
                    <?php $ques1 = Kohana_Cookie::get('ques1'); ?>
                    <dt>1. How do you visit Choies?</dt>
                    <div id="error1" class="error hide">Please complete this question.</div>
                    <dd><input type="radio" name="q1" value="A. PC" class="checkbox" <?php if($ques1 == 'A'){ echo 'checked'; } ?>  /> A. PC</dd>
                    <dd><input type="radio" name="q1" value="B. Tablet" class="checkbox" <?php if($ques1 == 'B'){ echo 'checked'; } ?>/> B. Tablet</dd>
                    <dd><input type="radio" name="q1" value="C. Smart Phone" class="checkbox" <?php if($ques1 == 'C'){ echo 'checked'; } ?>/> C. Smart Phone</dd>
                    </span>

                    <span id="ques2">
                    <?php $ques2 = Kohana_Cookie::get('ques2'); ?>
                    <dt>2. Which Broswer do you use to visit Choies?</dt>
                    <div id="error2" class="error hide">Please complete this question.</div>
                    <dd><input type="radio" name="q2" value="A. Chrome" class="checkbox" <?php if($ques2 == 'A'){ echo 'checked'; } ?> /> A. Chrome</dd>
                    <dd><input type="radio" name="q2" value="B. Safari" class="checkbox" <?php if($ques2 == 'B'){ echo 'checked'; } ?> /> B. Safari</dd>
                    <dd><input type="radio" name="q2" value="C. Firefox" class="checkbox" <?php if($ques2 == 'C'){ echo 'checked'; } ?> /> C. Firefox</dd>
                    <dd><input type="radio" name="q2" value="D. Opera" class="checkbox" <?php if($ques2 == 'D'){ echo 'checked'; } ?> /> D. Opera</dd>
                    <dd><input type="radio" name="q2" value="E. Internet Explorer" class="checkbox" <?php if($ques2 == 'E'){ echo 'checked'; } ?> /> E. Internet Explorer</dd>
                    <dd><input type="radio" name="q2" value="F. Others" class="checkbox" <?php if($ques2 == 'F'){ echo 'checked'; } ?> /> F. Others</dd>
                    </span>

                    <span id="ques3">
                    <?php $ques3 = Kohana_Cookie::get('ques3'); ?>
                    <dt>3. How do you get access to Choies?</dt>
                    <div id="error3" class="error hide">Please complete this question.</div>
                    <dd><input type="radio" name="q3" value="A. From promoted Pins or pins from pin society" class="checkbox" <?php if($ques3 == 'A'){ echo 'checked'; } ?> /> A. From promoted Pins or pins from pin society</dd>
                    <dd><input type="radio" name="q3" value="B. From facebook ads in News Feed or Right Column Ads via desktop or phone" class="checkbox" <?php if($ques3 == 'B'){ echo 'checked'; } ?> /> B. From facebook ads in News Feed or Right Column Ads via desktop or phone</dd>
                    <dd><input type="radio" name="q3" value="C. From publishers like Rewardstyle and coupon code site like Retailmenot.com" class="checkbox" <?php if($ques3 == 'C'){ echo 'checked'; } ?> /> C. From publishers like Rewardstyle and coupon code site like Retailmenot.com</dd>
                    <dd><input type="radio" name="q3" value="D. From Google Shopping, google search engine or google partner sites" class="checkbox" <?php if($ques3 == 'D'){ echo 'checked'; } ?> /> D. From Google Shopping, google search engine or google partner sites</dd>
                    <dd><input type="radio" name="q3" value="E. From recommendations by bloggers or youtubers" class="checkbox" <?php if($ques3 == 'E'){ echo 'checked'; } ?> /> E. From recommendations by bloggers or youtubers</dd>
                    <dd><input type="radio" name="q3" value="F. From Marketing & Promotion Emails" class="checkbox" <?php if($ques3 == 'F'){ echo 'checked'; } ?> /> F. From Marketing & Promotion Emails</dd>
                    <dd><input type="radio" name="q3" value="G. Directly visit Choies site" class="checkbox" <?php if($ques3 == 'G'){ echo 'checked'; } ?> /> G. Directly visit Choies site</dd>
                    </span>

                    <span id="ques4">
                    <?php $ques4 = Kohana_Cookie::get('ques4'); ?>
                    <dt>4. For the access you have chosen in Question 3, how long does it take to load to Choies site?</dt>
                    <div id="error4" class="error hide">Please complete this question.</div>
                    <dd><input type="radio" name="q4" value="A. 1-3 seconds" class="checkbox" <?php if($ques4 == 'A'){ echo 'checked'; } ?> /> A. 1-3 seconds</dd>
                    <dd><input type="radio" name="q4" value="B. 3-5 seconds" class="checkbox" <?php if($ques4 == 'B'){ echo 'checked'; } ?> /> B. 3-5 seconds</dd>
                    <dd><input type="radio" name="q4" value="C. 5-10 seconds" class="checkbox" <?php if($ques4 == 'C'){ echo 'checked'; } ?> /> C. 5-10 seconds</dd>
                    <dd><input type="radio" name="q4" value="D. More than 10 seconds" class="checkbox" <?php if($ques4 == 'D'){ echo 'checked'; } ?> /> D. More than 10 seconds</dd>
                    </span>

                    <span id="ques5">
                    <?php $ques5 = Kohana_Cookie::get('ques5'); ?>
                    <dt>5. For the access you have chosen in Question 3, what is the first page you have been loaded to Choies?</dt>
                    <div id="error5" class="error hide">Please complete this question.</div>
                    <dd><input type="radio" name="q5" value="A. Home page" class="checkbox" <?php if($ques5 == 'A'){ echo 'checked'; } ?> /> A. Home page</dd>
                    <dd><input type="radio" name="q5" value="B. Catagory page" class="checkbox" <?php if($ques5 == 'B'){ echo 'checked'; } ?> /> B. Catagory page</dd>
                    <dd><input type="radio" name="q5" value="C. Product page" class="checkbox" <?php if($ques5 == 'C'){ echo 'checked'; } ?> /> C. Product page</dd>
                    <dd><input type="radio" name="q5" value="D. Activity page" class="checkbox" <?php if($ques5 == 'D'){ echo 'checked'; } ?> /> D. Activity page</dd>
                    </span>

                    <span id="ques6">
                    <?php $ques6 = Kohana_Cookie::get('ques6'); ?>
                    <dt>6. How many pages do you usually browse with Choies?</dt>
                    <div id="error6" class="error hide">Please complete this question.</div>
                    <dd><input type="radio" name="q6" value="A. 3-5 pages" class="checkbox" <?php if($ques6 == 'A'){ echo 'checked'; } ?> /> A. 3-5 pages</dd>
                    <dd><input type="radio" name="q6" value="B. 5-7 pages" class="checkbox" <?php if($ques6 == 'B'){ echo 'checked'; } ?> /> B. 5-7 pages</dd>
                    <dd><input type="radio" name="q6" value="C. 7-10 pages" class="checkbox" <?php if($ques6 == 'C'){ echo 'checked'; } ?> /> C. 7-10 pages</dd>
                    <dd><input type="radio" name="q6" value="D. More than 10 pages" class="checkbox" <?php if($ques6 == 'D'){ echo 'checked'; } ?> /> D. More than 10 pagese</dd>
                    </span>

                    <span id="ques7">
                    <?php $ques7 = Kohana_Cookie::get('ques7'); ?>
                    <dt>7. What is the most possible reason for you to bounce from Choies?</dt>
                    <div id="error7" class="error hide">Please complete this question.</div>
                    <dd><input type="radio" name="q7" value="A. The loading speed is too slow" class="checkbox" <?php if($ques7 == 'A'){ echo 'checked'; } ?> /> A. The loading speed is too slow</dd>
                    <dd><input type="radio" name="q7" value="B. Having not found the wanted products" class="checkbox" <?php if($ques7 == 'B'){ echo 'checked'; } ?> /> B. Having not found the wanted products</dd>
                    <dd><input type="radio" name="q7" value="C. The actual product/activity page is not the same as the description in the ads" class="checkbox" <?php if($ques7 == 'C'){ echo 'checked'; } ?> /> C. The actual product/activity page is not the same as the description in the ads</dd>
                    <dd><input type="radio" name="q7" value="D. Have no faith in Choies brand" class="checkbox" <?php if($ques7 == 'D'){ echo 'checked'; } ?> /> D. Have no faith in Choies brand</dd>
                    </span>

                    <span id="stepeight1">
                    <?php $stepeight1 = Kohana_Cookie::get('stepeight1'); ?>
                    <dt>8. How long do you think is acceptable for the pages to load?</dt>
                    <div id="error8" class="error hide">Please complete this question.</div>
                    <dd><input type="radio" name="q8" value="A. 0-3 seconds" class="checkbox" <?php if($stepeight1 == 'A'){ echo 'checked'; } ?> /> A. 0-3 seconds</dd>
                    <dd><input type="radio" name="q8" value="B. 3-5 seconds" class="checkbox" <?php if($stepeight1 == 'B'){ echo 'checked'; } ?> /> B. 3-5 seconds</dd>
                    <dd><input type="radio" name="q8" value="C. 5-7 second" class="checkbox" <?php if($stepeight1 == 'C'){ echo 'checked'; } ?> /> C. 5-7 second</dd>
                    <dd><input type="radio" name="q8" value="D. 7-10 seconds" class="checkbox" <?php if($stepeight1 == 'D'){ echo 'checked'; } ?> /> D. 7-10 seconds</dd>
                    </span>
                  
                    <span id="stepeight2" style="display:none;">
                    <?php $stepeight2 = Kohana_Cookie::get('stepeight2'); ?>
                    <dt>8. Which one of the following styles do you like best?</dt>
                    <div id="error8" class="error hide">Please complete this question.</div>
                    <dd><input type="radio" name="q8" value="A. Ballerina Sports luxe style" class="checkbox" <?php if($stepeight2 == 'A'){ echo 'checked'; } ?> /> A. Ballerina Sports luxe style</dd>
                    <dd><input type="radio" name="q8" value="B. Coachella (music festival)+ Boho style" class="checkbox" <?php if($stepeight2 == 'B'){ echo 'checked'; } ?> /> B. Coachella (music festival)+ Boho style</dd>
                    <dd><input type="radio" name="q8" value="C. 90's School Girl style（grunge/ ringer tee)" class="checkbox" <?php if($stepeight2 == 'C'){ echo 'checked'; } ?> /> C. 90's School Girl style（grunge/ ringer tee)</dd>
                    <dd><input type="radio" name="q8" value="D. Minimal style (90's, little black dress)" class="checkbox" <?php if($stepeight2 == 'D'){ echo 'checked'; } ?> /> D. Minimal style (90's, little black dress)</dd>
                    <dd><input type="radio" name="q8" value="E. Country girl style (T-shirt, denim, white shirt)" class="checkbox" <?php if($stepeight2 == 'E'){ echo 'checked'; } ?> /> E. Country girl style (T-shirt, denim, white shirt)</dd>
                    </span>

                    <span id="stepeight3" style="display:none;">
                    <?php $stepeight3 = Kohana_Cookie::get('stepeight3'); ?>
                    <dt>8. What is your experience of "The actual product/activity page is not the same as the description in the ads"?</dt>
                    <div id="error8" class="error hide">Please complete this question.</div>
                    <dd><input type="radio" name="q8" value="A. The price difference (The actual price is higher than the advertised one)" class="checkbox" <?php if($stepeight3 == 'A'){ echo 'checked'; } ?> /> A. The price difference (The actual price is higher than the advertised one)</dd>
                    <dd><input type="radio" name="q8" value="B. The product difference (The product image is not the same as the model show)" class="checkbox" <?php if($stepeight3 == 'B'){ echo 'checked'; } ?> /> B. The product difference (The product image is not the same as the model show)</dd>
                    <dd><input type="radio" name="q8" value="C. The promotion difference (The promotion is not the same as it's said in the ad)" class="checkbox" <?php if($stepeight3 == 'C'){ echo 'checked'; } ?> /> C. The promotion difference (The promotion is not the same as it's said in the ad)</dd>
                    <dd><input type="radio" name="q8" value="D. The Advertisement expires" class="checkbox" <?php if($stepeight3 == 'D'){ echo 'checked'; } ?> /> D. The Advertisement expires</dd>
                    </span>

                    <span id="stepnine">
                    <?php $stepnine = Kohana_Cookie::get('stepnine'); ?>
                    <dt>9. What's your favorite promotion form?</dt>
                    <div id="error9" class="error hide">Please complete this question.</div>
                    <dd><input type="radio" name="q9" value="A. 20% Off Sitewide" class="checkbox"  <?php if($stepnine == 'A'){ echo 'checked'; } ?> /> A. 20% Off Sitewide</dd>
                    <dd><input type="radio" name="q9" value="B. $10 OFF $59" class="checkbox" <?php if($stepnine == 'B'){ echo 'checked'; } ?> /> B. $10 OFF $59</dd>
                    <dd><input type="radio" name="q9" value="C. Buy One, Get One 50% OFF" class="checkbox" <?php if($stepnine == 'C'){ echo 'checked'; } ?>/> C. Buy One, Get One 50% OFF</dd>
                    <dd><input type="radio" name="q9" value="D. Up to 60% OFF" class="checkbox" <?php if($stepnine == 'D'){ echo 'checked'; } ?>/> D. Up to 60% OFF</dd>
                    <dd><input type="radio" name="q9" value="E. From $5.99" class="checkbox" <?php if($stepnine == 'E'){ echo 'checked'; } ?>/> E. From $5.99</dd>
                    </span>

                    <span id="ques10">
                    <?php $ques10 = Kohana_Cookie::get('ques10'); ?>
                    <dt>10. What may be the reason for you not to complete your payment after checkout?</dt>
                    <div id="error10" class="error hide">Please complete this question.</div>
                    <dd><input type="radio" name="q10" value="A. 20% Off Sitewide" class="checkbox"  <?php if($ques10 == 'A'){ echo 'checked'; } ?>/> A. Don't want to wait for the slow confirming response</dd>
                    <dd><input type="radio" name="q10" value="B. Not loading to the right payment page" <?php if($ques10 == 'B'){ echo 'checked'; } ?>/> B. Not loading to the right payment page</dd>
                    <dd><input type="radio" name="q10" value="C. Thinking twice before paying" class="checkbox" <?php if($ques10 == 'C'){ echo 'checked'; } ?>/> C. Thinking twice before paying</dd>
                    <dd><input type="radio" name="q10" value="D. The payment method you want is not acceptable" class="checkbox" <?php if($ques10 == 'D'){ echo 'checked'; } ?>/> D. The payment method you want is not acceptable</dd>
                    </span>
                </dl>
                <div class="hidden-xs">
                        <p style="margin-top:50px;">At last, thanks so much for completing the questionnaire. We will announce the 5 $100 Gift Card winners on March 16th.</p>
                        <p>If you come across with any problems when visiting Choies.com, please follow the 2 steps below:</p>
                        <p style="font-weight: bold;">Step 1. Take the screenshot of the problem page</p>
                        <p style="font-weight: bold;">Step 2. Send the screenshot with the detailed problem description to <a href="mailto:lisa@choies.com" style="color:#ff0000;">lisa@choies.com</a></p>
                        <p>And you will be offered amazing gifts according to the problems you submit.</p>
                        </div>
                        <div class="hidden-sm hidden-md hidden-lg visible-xs-block" style="margin-top:30px;">
                          <p>Thanks so much for completing the questionnaire. We will announce the 5 $100 Gift Card winners on March 16th. If you come across with any problems when visiting Choies.com, please send the screenshot with the detailed problem to <a href="mailto:lisa@choies.com" style="color:#ff0000;">lisa@choies.com</a></p>
                        </div>
                        <p><input type="button" value="SUBMIT" class="btn-sub" onclick="check();" id="btnsubmit"/></p>
                      </form>
                      
                    </div>
              
            </div>
          </div>
        </div>
    </div>
</body>
<script type="text/javascript">
function check(){
  if($('input:radio[name="q1"]:checked').val()==undefined){
    $("#error1").css("display","block");
     var id=$("#error1").prev(); //取得需要跳转到的DIV的ID
     $("html,body").animate({scrollTop: $(id).offset().top-150}, 500);
    return false;
  }else{
    $("#error1").css("display","none");
  }
   if($('input:radio[name="q2"]:checked').val()==undefined){
    $("#error2").css("display","block");
    var id=$("#error2").prev(); 
     $("html,body").animate({scrollTop: $(id).offset().top-150}, 500);
    return false;
  }else{
    $("#error2").css("display","none");
  }
  if($('input:radio[name="q3"]:checked').val()==undefined){
    $("#error3").css("display","block");
    var id=$("#error3").prev(); 
     $("html,body").animate({scrollTop: $(id).offset().top-150}, 500);
    return false;
  }else{
    $("#error3").css("display","none");
  }
  if($('input:radio[name="q4"]:checked').val()==undefined){
    $("#error4").css("display","block");
   var id=$("#error4").prev(); 
     $("html,body").animate({scrollTop: $(id).offset().top-150}, 500);
    return false;
  }else{
    $("#error4").css("display","none");
  }
  if ($("input[name='q5']:checked").length < 1) {
          $("#error5").css("display","block");
          var id=$("#error5").prev(); 
     $("html,body").animate({scrollTop: $(id).offset().top-150}, 500);
          return false;
  }else{
    $("#error5").css("display","none");
  }
  if ($("input[name='q6']:checked").length < 1) {
          $("#error6").css("display","block");
          var id=$("#error6").prev(); 
     $("html,body").animate({scrollTop: $(id).offset().top-150}, 500);
          return false;
  }else{
    $("#error6").css("display","none");
  }
  if ($("input[name='q7']:checked").length < 1) {
          $("#error7").css("display","block");
         var id=$("#error7").prev(); 
     $("html,body").animate({scrollTop: $(id).offset().top-150}, 500);
          return false;
  }else{
    $("#error7").css("display","none");
  }
  if($('input:radio[name="q8"]:checked').val()==undefined){
    $("#error8").css("display","block");
    var id=$("#error8").prev(); 
     $("html,body").animate({scrollTop: $(id).offset().top-150}, 500);
    return false;
  }else{
    $("#error8").css("display","none");
  }
  if($('input:radio[name="q9"]:checked').val()==undefined){
    $("#error9").css("display","block");
    var id=$("#error9").prev(); 
     $("html,body").animate({scrollTop: $(id).offset().top-150}, 500);
    return false;
  }else{
    $("#error9").css("display","none");
  }
   if($('input:radio[name="q10"]:checked').val()==undefined){
    $("#error10").css("display","block");
   var id=$("#error10").prev(); 
     $("html,body").animate({scrollTop: $(id).offset().top-150}, 500);
    return false;
  }else{
    $("#error10").css("display","none");
  }
  $("#error").css("display","none");
  $("#formquest").submit();
}

$(function(){
    $("input[name='q7']").click(function(){
        var selectvalue = this.value.substr(0,1);
        if(selectvalue == 'A')
        {
          document.getElementById('stepeight1').style.display = 'block';
          document.getElementById('stepeight2').style.display = 'none';
          document.getElementById('stepeight3').style.display = 'none';
        }
        else if(selectvalue == 'B')
        {
          document.getElementById('stepeight2').style.display = 'block';
          document.getElementById('stepeight1').style.display = 'none';
          document.getElementById('stepeight3').style.display = 'none';
        }
        else if(selectvalue == 'C')
        {
          document.getElementById('stepeight3').style.display = 'block';
          document.getElementById('stepeight2').style.display = 'none';
          document.getElementById('stepeight1').style.display = 'none';
        }
        else if(selectvalue == 'D')
        {
          document.getElementById('stepeight1').style.display = 'none';
          document.getElementById('stepeight2').style.display = 'none';
          document.getElementById('stepeight3').style.display = 'none';  
          document.getElementById('stepnine').style.display = 'block';
          $('input:radio[name="q8"]').eq(0).attr("checked","true");          
        }
    })

      $(".survey").find("span").click(function(){
          var spanname = $(this).attr("id");
          var selectname  = $(this).find("input:checked");
          var checkedvalue = selectname.val();
        datas = new Object();
        datas.spanname = spanname;
        datas.checkedvalue = checkedvalue;
          $.ajax({
            type:"POST",
            url :"/activity/ajax_survey",
            data:datas,
            dataType:"json",
            success:function(datas){
            }
          });
      })

})
</script>
</html>