<link type="text/css" rel="stylesheet" href="/css/giveaway.css" media="all" />
<style>
.lp_surveys img{ border:0 none;}
.error{color:red;display:none;padding: 2px 25px;width: 300px;border: 1px solid red;background: #eee;margin-bottom: 5px;}
.lp_surveys_box{ border:1px solid #50dcff; background-color:#fff; margin:-10px 17px 20px; padding:30px 28px 25px;}
.lp_surveys_box dl{ padding:0 0 20px;}
.lp_surveys_box dl dt{ margin:15px 0 10px; font-weight:bold;}
.lp_surveys_box dl dd{ margin:0 0 5px 10px;}
.lp_surveys_box span{ margin-left:20px; color:#F00; display:block;}
.lp_surveys_box dl dd select{ width:300px; padding:2px; background-color:#f4f4f0; border:1px solid #ccc;}
.lp_surveys_box dl dd .text{ width:170px; height:26px; line-height:26px; margin:0 5px; background-color:#f4f4f0; vertical-align:middle; color:#666;}
.lp_surveys_box dl dd textarea{ width:445px; height:130px; color:#666;}
.lp_surveys_box dl dt .btn40{ padding:0 20px; border:0 none; height:26px; line-height:26px; margin:0 10px 0 10px;}
.lp_surveys_box dl dd .checkbox,.lp_surveys_box dl dd .radio{ margin-right:5px; vertical-align:middle;}

.lp_surveys_box dl dd.mb20{ margin-bottom:20px;}
.lp_surveys_box dl dd span{ display:inline-block; vertical-align:middle;}
.lp_surveys_box dl dd span.s1{ width:300px; margin:0 10px 0 0;}
.lp_surveys_box dl dd span.s2{ width:65px; text-align:center; margin:0 5px;}
.lp_surveys_box dl dd.last{ font-weight:normal; margin-top:20px;}

.lp_surveys_box dl dd.layout1{ display:inline-block; width:220px; margin-right:5px;}
.lp_surveys_box dl dd.layout1 span{ margin-top:10px;}
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $("input[name='q5[]']").click(function() {
        if ($("input[name='q5[]']:checked").length >= 3) {
            $("input[name='q5[]']").attr('disabled', '');
            $("input[name='q5[]']:checked").attr('disabled', false);
        } else {
            $("input[name='q5[]']").attr('disabled', false);
        }
        });
        $("input[name='q6[]']").click(function() {
        if ($("input[name='q6[]']:checked").length >= 3) {
            $("input[name='q6[]']").attr('disabled', '');
            $("input[name='q6[]']:checked").attr('disabled', false);
        } else {
            $("input[name='q6[]']").attr('disabled', false);
        }
        });
        $("input[name='q7[]']").click(function() {
        if ($("input[name='q7[]']:checked").length >= 3) {
            $("input[name='q7[]']").attr('disabled', '');
            $("input[name='q7[]']:checked").attr('disabled', false);
        } else {
            $("input[name='q7[]']").attr('disabled', false);
        }
        });
    })
</script>
<script type="text/javascript">
function check(){
  if($('input:radio[name="q1"]:checked').val()==undefined){
    $("#error1").css("display","block");
    $("body").scrollTop(250);
    return false;
  }else{
    $("#error1").css("display","none");
  }
  if($('input:radio[name="q3"]:checked').val()==undefined){
    $("#error3").css("display","block");
    $("body").scrollTop(525);
    return false;
  }else{
    $("#error3").css("display","none");
  }
  if($('input:radio[name="q4"]:checked').val()==undefined){
    $("#error4").css("display","block");
    $("body").scrollTop(725);
    return false;
  }else{
    $("#error4").css("display","none");
  }
  if ($("input[name='q5[]']:checked").length < 1) {
          $("#error5").css("display","block");
          $("body").scrollTop(910);
          return false;
  }else{
    $("#error5").css("display","none");
  }
  if ($("input[name='q6[]']:checked").length < 1) {
          $("#error6").css("display","block");
          $("body").scrollTop(1150);
          return false;
  }else{
    $("#error6").css("display","none");
  }
  if ($("input[name='q7[]']:checked").length < 1) {
          $("#error7").css("display","block");
          $("body").scrollTop(1390);
          return false;
  }else{
    $("#error7").css("display","none");
  }
  if($('input:radio[name="q8"]:checked').val()==undefined){
    $("#error8").css("display","block");
    $("body").scrollTop(1650);
    return false;
  }else{
    $("#error8").css("display","none");
  }
  if($('input:radio[name="q9"]:checked').val()==undefined){
    $("#error9").css("display","block");
    $("body").scrollTop(1830);
    return false;
  }else{
    $("#error9").css("display","none");
  }
  aa=$("#textarea").val();
  if(aa==""||aa=="More significant advice and suggestions provided, more chances you will be awarded prizes.  Maximum 500 characters."){
    $("#error10").css("display","block");
    $("body").scrollTop(2000);
    return false;
  }else{
    $("#error10").css("display","none");
  }
  if(aa.length>500){
    $("#error11").css("display","block");
    $("body").scrollTop(2000);
    return false;
  }
  $("#error").css("display","none");
  $("#btnsubmit").css("display","none");
  $("#loading").css("display","block");
  $("#formquest").submit();
}
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
  <p><img src="/images/activity/new7_surveys.png" /></p>
  <div class="lp_surveys_box">
    <form action="#" method="post" class="form" id="formquest">
        <dl>
          <dt>1. What makes you visit Choies?</dt>
          <div id="error1" class="error">Please complete this question.</div>
          <dd><input type="radio" name="q1" value="I receive an email reminder" class="checkbox" /> I receive an email reminder</dd>
          <dd><input type="radio" name="q1" value="I see Choies is having a deep discount sale (x% off)" class="checkbox" /> I see Choies is having a deep discount sale (x% off)</dd>
          <dd><input type="radio" name="q1" value="I remember to come when the sales start" class="checkbox" /> I remember to come when the sales start</dd>
          <dd><input type="radio" name="q1" value="I see Choies referenced in social media or a blog" class="checkbox" /> I see Choies referenced in social media or a blog</dd>
          <dd><input type="radio" name="q1" value="I follow up Choies new in products" class="checkbox" /> I follow up Choies new in products</dd>
          <dd><input type="radio" name="q1" value="I find Choies through search engines" class="checkbox" /> I find Choies through search engines</dd>
          <dd>Other (please specify) <input type="text" value="( Maximum 50 characters )" name="other[q1]" class="text" maxLength="50"/></dd>
          
          <dt id="question2">2.What's your country of residence?</dt>
          <dd>
          <select name="q2">
          <?php
                    $countries = Site::instance()->countries(LANGUAGE);
                    foreach ($countries as $country):
                        ?>
                        <option value="<?php echo $country['isocode']; ?>" ><?php echo $country['name']; ?></option>
                        <?php
                    endforeach;
                    ?>
          </select>
          </dd>
          
          <dt>3. At what local time would you prefer Choies weekly deal to start.</dt>
          <div id="error3" class="error">Please complete this question.</div>
          <dd><input type="radio" name="q3" value="9:00 AM" class="radio" /> 9:00 AM</dd>
          <dd><input type="radio" name="q3" value="12:00 AM" class="radio" /> 12:00 AM</dd>
          <dd><input type="radio" name="q3" value="3:00 PM" class="radio" /> 3:00 PM</dd>
          <dd><input type="radio" name="q3" value="6:00 PM" class="radio" /> 6:00 PM</dd>
          <dd><input type="radio" name="q3" value="9:00 PM" class="radio" /> 9:00 PM</dd>
          <dd><input type="radio" name="q3" value="12:00 PM" class="radio" /> 12:00 PM</dd>
          <dd><input type="radio" name="q3" value="No preference" class="radio" /> No preference</dd>
          
          <dt>4. How many promotional emails would you like to receive from Choies every week?</dt>
          <div id="error4" class="error">Please complete this question.</div>
          <dd><input type="radio" name="q4" value="1" class="radio" /> 1</dd>
          <dd><input type="radio" name="q4" value="2" class="radio" /> 2</dd>
          <dd><input type="radio" name="q4" value="3" class="radio" /> 3</dd>
          <dd><input type="radio" name="q4" value="4" class="radio" /> 4</dd>
          <dd><input type="radio" name="q4" value="5" class="radio" /> 5</dd>
          <dd><input type="radio" name="q4" value="More than 5" class="radio" /> More than 5</dd>
          
          <dt>5. On which social networks do you usually share Choies products? (Please select up to 3)</dt>
          <div id="error5" class="error">Please complete this question.</div>
          <dd><input type="checkbox" name="q5[]" value="Facebook" class="checkbox" /> Facebook</dd>
          <dd><input type="checkbox" name="q5[]" value="Pinterest" class="checkbox" /> Pinterest</dd>
          <dd><input type="checkbox" name="q5[]" value="Twitter" class="checkbox" /> Twitter</dd>
          <dd><input type="checkbox" name="q5[]" value="Instagram" class="checkbox" /> Instagram</dd>
          <dd><input type="checkbox" name="q5[]" value="Tumblr" class="checkbox" /> Tumblr</dd>
          <dd><input type="checkbox" name="q5[]" value="Polyvore" class="checkbox" /> Polyvore</dd>
          <dd><input type="checkbox" name="q5[]" value="Chictopia" class="checkbox" /> Chictopia</dd>
          <dd><input type="checkbox" name="q5[]" value="I don't share at all" class="checkbox" /> I don't share at all</dd>
          <dd>Other (please specify) <input type="text" value="( Maximum 50 characters )" name="other[q5]" class="text" maxLength="50"/></dd>
           
          <dt>6. What makes you buy more with Choies? (select up to 3)</dt>
          <div id="error6" class="error">Please complete this question.</div>
          <dd><input type="checkbox" name="q6[]" value="Incentives to buy more, such as buy 1 get 1 50% off" class="checkbox" /> Incentives to buy more, such as buy 1 get 1 50% off</dd>
          <dd><input type="checkbox" name="q6[]" value="Discount or coupon for bundle purchase" class="checkbox" /> Discount or coupon for bundle purchase</dd>
          <dd><input type="checkbox" name="q6[]" value="Free Express shipping with purchase of more than 1 item" class="checkbox" /> Free Express shipping with purchase of more than 1 item</dd>
          <dd><input type="checkbox" name="q6[]" value="Customer ratings & reviews" class="checkbox" /> Customer ratings & reviews </dd>
          <dd><input type="checkbox" name="q6[]" value="Free return" class="checkbox" /> Free return</dd>
          <dd><input type="checkbox" name="q6[]" value="Buy the look feature" class="checkbox" /> "Buy the look" feature</dd>
          <dd><input type="checkbox" name="q6[]" value="Choies weekly newsletter and specials emails" class="checkbox" /> Choies weekly newsletter and specials emails</dd>
          <dd>Other (please specify) <input type="text" value="( Maximum 50 characters )" name="other[q6]" class="text" maxLength="50"/></dd>
           
          <dt>7. Which discounts/specials bring you back to Choies and make a purchase? (select up to 3)</dt>
          <div id="error7" class="error">Please complete this question.</div>
          <dd><input type="checkbox" name="q7[]" value="Free gift on every order over $69" class="checkbox" /> Free gift on every order over $69</dd>
          <dd><input type="checkbox" name="q7[]" value="10% off entire purchase" class="checkbox" /> 10% off entire purchase</dd>
          <dd><input type="checkbox" name="q7[]" value="Save $5 off $65, save $10 off $100, save $20 off $200" class="checkbox" /> Save $5 off $65, save $10 off $100, save $20 off $200</dd>
          <dd><input type="checkbox" name="q7[]" value="Receive a coupon for 5-10% off your next purchase" class="checkbox" /> Receive a coupon for 5-10% off your next purchase</dd>
          <dd><input type="checkbox" name="q7[]" value="Free Express Shipping on all orders over $100" class="checkbox" /> Free Express Shipping on all orders over $100</dd>
          <dd><input type="checkbox" name="q7[]" value="Buy 1, get the 2nd half price" class="checkbox" /> Buy 1, get the 2nd half price</dd>
          <dd><input type="checkbox" name="q7[]" value="Lucky bag ( consist of more than 2 items in it) with any order" class="checkbox" /> Lucky bag ( consist of more than 2 items in it) with any order</dd>
          <dd><input type="checkbox" name="q7[]" value="50% off Hot item for purchase of $69 or more" class="checkbox" /> 50% off Hot item for purchase of $69 or more</dd>
          <dd>Other (please specify) <input type="text" value="( Maximum 50 characters )" name="other[q7]" class="text" maxLength="50"/></dd>
          
          <dt>8. Which category of free gift would you like to choose at shopping cart page?</dt>
          <div id="error8" class="error">Please complete this question.</div>
          <dd><input type="radio" name="q8" value="Free basic style clothing, like dress, t-shirt or shorts" class="radio" /> Free basic style clothing, like dress, t-shirt or shorts</dd>
          <dd><input type="radio" name="q8" value="Free accessories like sunglasses, hats or bags" class="radio" /> Free accessories like sunglasses, hats or bags</dd>
          <dd><input type="radio" name="q8" value="Free item marked with Choies logo" class="radio" /> Free item marked with Choies logo</dd>
          <dd><input type="radio" name="q8" value="Free jewelry like necklaces, bracelets" class="radio" /> Free jewelry like necklaces, bracelets</dd>
          <dd><input type="radio" name="q8" value="Free personalised item like custom made t-shirt" class="radio" /> Free personalised item like custom made t-shirt</dd>
          <dd>Other (please specify) <input type="text" value="( Maximum 50 characters )" name="other[q8]" class="text" maxLength="50"/></dd>
          
          <dt>9. Why do you abandon your shopping cart? </dt>
          <div id="error9" class="error">Please complete this question.</div>
          <dd><input type="radio" name="q9" value="I was not ready to purchase, but wanted to get an idea of the total cost with shipping" class="radio" /> I was not ready to purchase, but wanted to get an idea of the total cost with shipping</dd>
          <dd><input type="radio" name="q9" value="I was not ready to purchase, but wanted to save the cart for later" class="radio" /> I was not ready to purchase, but wanted to save the cart for later</dd>
          <dd><input type="radio" name="q9" value="Shopping cart page doesnt provide detailed and valid privacy, security and return policy" class="radio" /> Shopping cart page doesn't provide detailed and valid privacy, security and return policy</dd>
          <dd><input type="radio" name="q9" value="I cant find online live customer service" class="radio" /> I can't find online live customer service</dd>
          <dd>Other (please specify) <input type="text" value="( Maximum 50 characters )" name="other[q9]" class="text" maxLength="50"/></dd>
          
          <dt>10. Tell us which incentives make you buy and buy more with Choies?</dt>
          <div id="error10" class="error">Please complete this question.</div>
          <div id="error11" class="error">Maximum 500 characters</div>
          <dd><textarea name="q10" maxLength="500" onclick="this.value=''" id="textarea">More significant advice and suggestions provided, more chances you will be awarded prizes.  Maximum 500 characters.</textarea></dd>
          <dd class="last"><input type="button" value="Submit" class="btn30_14_red mr10" onclick="check();" id="btnsubmit"/>
          <img src="/images/loading.gif" id="loading" style="display:none">
          </dd>
        </dl>
    </form>
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
</div>