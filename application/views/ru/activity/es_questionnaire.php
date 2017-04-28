<link type="text/css" rel="stylesheet" href="/css/giveaway.css" media="all" />
<script type="text/javascript">
    var is_login = <?php echo Customer::logged_in() ? '1' : '0'; ?>;
    $(function(){
        $("#qForm").live('submit', function(){
            if(!is_login)
            {
                $.ajax({
                    url: '/customer/ajax_login1',
                    success: function (data) {
                        if(data == '0')
                        {
                            $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                            $('#catalog_link').appendTo('body').fadeIn(320);
                            $('#catalog_link').show();
                        }
                    }
                });
                return false;
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
                    $(".formquest").attr('id', '');
                    $(".formquest").submit();
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
                    $(".formquest").attr('id', '');
                    $(".formquest").submit();
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
                
        //                $(".q1").live('click', function(){
        //                        var q1 = $(".question1").val();
        //                        var val = $(this).val();
        //                        if($(this).attr('checked'))
        //                        {
        //                                $(".question1").val(q1+val);
        //                        }
        //                        else
        //                        {
        //                                q1 = q1.replace(val,'');
        //                                $(".question1").val(q1);
        //                        }
        //                })
        //                
        //                $(".q2").live('click', function(){
        //                        var q1 = $(".question2").val();
        //                        var val = $(this).val();
        //                        if($(this).attr('checked'))
        //                        {
        //                                $(".question2").val(q1+val);
        //                        }
        //                        else
        //                        {
        //                                q1 = q1.replace(val,'');
        //                                $(".question2").val(q1);
        //                        }
        //                })
        //        
        //                $(".q3").live('click', function(){
        //                        var q1 = $(".question3").val();
        //                        var val = $(this).val();
        //                        if($(this).attr('checked'))
        //                        {
        //                                $(".question3").val(q1+val);
        //                        }
        //                        else
        //                        {
        //                                q1 = q1.replace(val,'');
        //                                $(".question3").val(q1);
        //                        }
        //                })
        //                
        //                $(".q6").live('click', function(){
        //                        var q1 = $(".question6").val();
        //                        var val = $(this).val();
        //                        if($(this).attr('checked'))
        //                        {
        //                                $(".question6").val(q1+val);
        //                        }
        //                        else
        //                        {
        //                                q1 = q1.replace(val,'');
        //                                $(".question6").val(q1);
        //                        }
        //                })
    })
        
    function docheck(q)
    {
                
    }
</script>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Home</a>  >  Questionnaire</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <section class="layout fix">
        <section id="container" class="flr">
            <!-------------ES_Questionnaire---------------->
            <div class="fix esq">
                <div><img src="/images/activity/esq_01.jpg"/></div>
                <div><img src="/images/activity/esq_02.jpg"/></div>
                <div class="fix  mt10">
                    <div class="successs">
                        <h3 style="border-top:0; line-height:60px;"><span style="font-size:40px;">Already Ended!</span><br/><span style="font-size:50px;">THANKS~</span></h3>
                        <div style="height:150px; padding-left:190px;">
<!--                                                        <input type="submit"  class="btn_submit2" value="SUBMIT" style="margin:0;"/>-->
                        </div>
                    </div>
                </div>

                <!--                                <div class="fix summary">
                                                        <div class="text pt15">
                                                                <p class="mt15">Dear customers,<br/>
                                                                        The purpose of this survey is to get your feedbacks regarding to our new coming brand '<a href="<?php echo LANGPATH; ?>/elf-sack/?queationnaire" title="elf sack" target="_blank">ELF SACK</a>'. please take a moment to complete the following questions and help us know what you think of our services. Your responses are very important to us and will be kept strictly confidential.</p>
                                                                        <div class="btn_login"><a href="#">Register / Log in first</a></div>
                                                                <p>Before you start the questionnaire, please have a look at the <a href="<?php echo LANGPATH; ?>/elf-sack/?queationnaire" title="elf sack" target="_blank">ELF SACK Collection</a>.</p>
                                                        </div>
                                                        <div class="hr"></div>
                                                </div>
                                                <form action="" method="post" id="qForm" class="formquest">
                                                        <div class="fix">
                                                                <div class="que fix">
                                                                        <h3>Q 1: How would you like to describe your fashion style? <br/><span class="remark">(Please tick all that apply.)</span></h3>
                                                                        <ul>
                                                                                <input type="hidden" name="question1" class="question1" value="" />
                                                                                <li>
                                                                                        <input type="checkbox" name="q1[]" id="" value="Boho"  onclick="docheck(1)" class="mr5 q1">
                                                                                        Boho</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q1[]" id="" value="Glam / punk"  onclick="docheck(1)" class="mr5 q1">
                                                                                        Glam / punk</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q1[]" id="" value="Vintage"  onclick="docheck(1)" class="mr5 q1">
                                                                                        Vintage</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q1[]" id="" value="Feminine / girly"  onclick="docheck(1)" class="mr5 q1">
                                                                                        Feminine / girly </li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q1[]" id="" value="Sophisticated"  onclick="docheck(1)" class="mr5 q1">
                                                                                        Sophisticated</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q1[]" id="" value="Preppy"  onclick="docheck(1)" class="mr5 q1">
                                                                                        Preppy</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q1[]" id="" value="Couture"  onclick="docheck(1)" class="mr5 q1">
                                                                                        Couture</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q1[]" id="" value="School girl"  onclick="docheck(1)" class="mr5 q1">
                                                                                        School girl</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q1[]" id="" value="Casual"  onclick="docheck(1)" class="mr5 q1">
                                                                                        Casual</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q1[]" id="" value="Elegant / classic"  onclick="docheck(1)" class="mr5 q1">
                                                                                        Elegant / classic</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q1[]" id="" value="Goth"  onclick="docheck(1)" class="mr5 q1">
                                                                                        Goth</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q1[]" id="" value="English"  onclick="docheck(1)" class="mr5 q1">
                                                                                        English</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q1[]" id="" value="Bold and edgy"  onclick="docheck(1)" class="mr5 q1">
                                                                                        Bold and edgy</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q1[]" id="" value="Earthy"  onclick="docheck(1)" class="mr5 q1">
                                                                                        Earthy</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q1[]" id="" value="Ethnic"  onclick="docheck(1)" class="mr5 q1">
                                                                                        Ethnic</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q1[]" id="" value="Sporty"  onclick="docheck(1)" class="mr5 q1">
                                                                                        Sporty</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q1[]" id="" value="Urban"  onclick="docheck(1)" class="mr5 q1">
                                                                                        Urban</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q1[]" id="" value="Collegiate"  onclick="docheck(1)" class="mr5 q1">
                                                                                        Collegiate</li>
                                                                        </ul>
                                                                        <div><label for="other" class="mr5">other: </label><input type="text" name="other[q1]" id="q1other" class="allinput other" value="" maxlength="340" /></div>
                
                                                                </div>
                                                                <div class="hr"></div>
                                                        </div>
                
                                                        <div class="fix">
                                                                <div class="que fix">
                                                                        <h3>Q 2: How would you like to describe the style of Elf Sack? <br/><span class="remark">(Please tick all that apply.)</span></h3>
                                                                        <ul>
                                                                                <input type="hidden" name="question2" class="question2" value="" />
                                                                                <li>
                                                                                        <input type="checkbox" name="q2[]" id="" value="Boho"  onclick="docheck(2)" class="mr5 q2">
                                                                                        Boho</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q2[]" id="" value="Glam / punk"  onclick="docheck(2)" class="mr5 q2">
                                                                                        Glam / punk</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q2[]" id="" value="Vintage"  onclick="docheck(2)" class="mr5 q2">
                                                                                        Vintage</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q2[]" id="" value="Feminine / girly"  onclick="docheck(2)" class="mr5 q2">
                                                                                        Feminine / girly </li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q2[]" id="" value="Sophisticated"  onclick="docheck(2)" class="mr5 q2">
                                                                                        Sophisticated</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q2[]" id="" value="Preppy"  onclick="docheck(2)" class="mr5 q2">
                                                                                        Preppy</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q2[]" id="" value="Couture"  onclick="docheck(2)" class="mr5 q2">
                                                                                        Couture</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q2[]" id="" value="School girl"  onclick="docheck(2)" class="mr5 q2">
                                                                                        School girl</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q2[]" id="" value="Casual"  onclick="docheck(2)" class="mr5 q2">
                                                                                        Casual</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q2[]" id="" value="Elegant / classic"  onclick="docheck(2)" class="mr5 q2">
                                                                                        Elegant / classic</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q2[]" id="" value="Goth"  onclick="docheck(2)" class="mr5 q2">
                                                                                        Goth</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q2[]" id="" value="English"  onclick="docheck(2)" class="mr5 q2">
                                                                                        English</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q2[]" id="" value="Bold and edgy"  onclick="docheck(2)" class="mr5 q2">
                                                                                        Bold and edgy</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q2[]" id="" value="Earthy"  onclick="docheck(2)" class="mr5 q2">
                                                                                        Earthy</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q2[]" id="" value="Ethnic"  onclick="docheck(2)" class="mr5 q2">
                                                                                        Ethnic</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q2[]" id="" value="Sporty"  onclick="docheck(2)" class="mr5 q2">
                                                                                        Sporty</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q2[]" id="" value="Urban"  onclick="docheck(2)" class="mr5 q2">
                                                                                        Urban</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q2[]" id="" value="Collegiate"  onclick="docheck(2)" class="mr5">
                                                                                        Collegiate</li>
                                                                        </ul>
                                                                        <div><label for="other" class="mr5">other: </label><input type="text" name="other[q2]" id="q1other" class="allinput other" value="" maxlength="340" /></div>
                                                                </div>
                                                                <div class="hr"></div>
                                                        </div>
                
                                                        <div class="fix">
                                                                <div class="que fix">
                                                                        <input type="hidden" name="question3" class="question3" value="" />
                                                                        <h3>Q 3: Which celebrity’s style do you think will fit close to Elf Sack 
                                                                                products?<span class="remark">(Please tick all that apply.)</span></h3>
                                                                        <div class="celebrity">
                                                                                <img src="/images/activity/esq_celebrity1.jpg"/>
                                                                                <div><input type="checkbox" name="q3[]" id="" value="Kate Mara"  onClick="doCheck(3)" class="mr5 q3">Kate Mara</div></div>
                                                                        <div class="celebrity">
                                                                                <img src="/images/activity/esq_celebrity2.jpg"/>
                                                                                <div><input type="checkbox" name="q3[]" id="" value="Alexa Chung"  onClick="doCheck(3)" class="mr5 q3">Alexa Chung</div></div>
                                                                        <div class="celebrity">
                                                                                <img src="/images/activity/esq_celebrity3.jpg"/>
                                                                                <div><input type="checkbox" name="q3[]" id="" value="Miranda Kerr"  onClick="doCheck(3)" class="mr5 q3">Miranda Kerr</div></div>
                                                                        <div class="celebrity">
                                                                                <img src="/images/activity/esq_celebrity4.jpg"/>
                                                                                <div><input type="checkbox" name="q3[]" id="" value="Blake Lively"  onClick="doCheck(3)" class="mr5 q3">Blake Lively</div></div>
                                                                        <div class="celebrity">
                                                                                <img src="/images/activity/esq_celebrity5.jpg"/>
                                                                                <div><input type="checkbox" name="q3[]" id="" value="Taylor Swift"  onClick="doCheck(3)" class="mr5 q3">Taylor Swift</div></div>
                                                                        <div class="celebrity">
                                                                                <img src="/images/activity/esq_celebrity6.jpg"/>
                                                                                <div><input type="checkbox" name="q3[]" id="" value="Rihanna"  onClick="doCheck(3)" class="mr5 q3">Rihanna</div></div>
                                                                        <div class="celebrity">
                                                                                <img src="/images/activity/esq_celebrity7.jpg"/>
                                                                                <div><input type="checkbox" name="q3[]" id="" value="Cara Delevingne"  onClick="doCheck(3)" class="mr5 q3">Cara Delevingne</div></div>
                                                                        <div class="celebrity">
                                                                                <img src="/images/activity/esq_celebrity8.jpg"/>
                                                                                <div><input type="checkbox" name="q3[]" id="" value="Victoria Beckham"  onClick="doCheck(3)" class="mr5 q3">Victoria Beckham</div></div>
                                                                </div>
                                                                <div class="hr"></div>
                                                        </div>
                
                                                        <div class="fix">
                                                                <div class="que fix radio">
                                                                        <h3>Q 4: What’s your general impression towards Elf Sack?</h3>
                                                                        <div class="title2">General Impression:</div>
                
                                                                        <ul>
                                                                                <li>I hate it<br/>(-2)<br/>
                                                                                        <input type="radio" name="q4" id="" value="-2"  class="mt5">
                                                                                </li>
                                                                                <li>I don’t like it<br/>(-1)<br/>
                                                                                        <input type="radio" name="q4" id="" value="-1"  class="mt5">
                                                                                </li>
                                                                                <li>Neutral<br/>(0)<br/>
                                                                                        <input type="radio" name="q4" id="" value="0"  class="mt5">
                                                                                </li>
                                                                                <li>I like it<br/>(1)<br/>
                                                                                        <input type="radio" name="q4" id="" value="1"  class="mt5">
                                                                                </li>
                                                                                <li>I love it<br/>(2)<br/>
                                                                                        <input type="radio" name="q4" id="" value="2"  class="mt5">
                                                                                </li>
                                                                        </ul>
                
                                                                </div>
                                                                <div class="hr"></div>
                                                        </div>
                
                                                        <div class="fix">
                                                                <div class="que fix radio">
                                                                        <h3>Q 5: How likely are you to purchase Elf Sack products?</h3>
                                                                        <div class="title2">General Impression:</div>
                
                                                                        <ul>
                                                                                <li>Very Unlikely<br/>(-2)<br/>
                                                                                        <input type="radio" name="q5" id="" value="-2"  class="mt5">
                                                                                </li>
                                                                                <li>Unlikely<br/>(-1)<br/>
                                                                                        <input type="radio" name="q5" id="" value="-1"  class="mt5">
                                                                                </li>
                                                                                <li>Neutral<br/>(0)<br/>
                                                                                        <input type="radio" name="q5" id="" value="0"  class="mt5">
                                                                                </li>
                                                                                <li>Likely<br/>(1)<br/>
                                                                                        <input type="radio" name="q5" id="" value="1"  class="mt5">
                                                                                </li>
                                                                                <li>Very<br/>(2)<br/>
                                                                                        <input type="radio" name="q5" id="" value="2"  class="mt5">
                                                                                </li>
                                                                        </ul>
                
                                                                </div>
                                                                <div class="hr"></div>
                                                        </div>
                
                                                        <div class="fix">
                                                                <div class="que fix">
                                                                        <h3>Q 6:  What categories of clothing would you be most likely to 
                                                                                purchase from Elf Sack? <span class="remark">(Please tick all that apply.)</span></h3>
                
                                                                        <ul>
                                                                                <input type="hidden" name="question6" class="question6" value="" />
                                                                                <li>
                                                                                        <input type="checkbox" name="q6[]" id="" value="T-shirts"  onclick="docheck(6)" class="mr5 q6">T-shirts</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q6[]" id="" value="Dresses"  onclick="docheck(6)" class="mr5 q6">Dresses </li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q6[]" id="" value="Blouses"  onclick="docheck(6)" class="mr5 q6">Blouses</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q6[]" id="" value="Shorts"  onclick="docheck(6)" class="mr5 q6">Shorts </li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q6[]" id="" value="Jeans"  onclick="docheck(6)" class="mr5 q6">Jeans</li>
                                                                                <li>
                                                                                        <input type="checkbox" name="q6[]" id="" value="Skirt"  onclick="docheck(6)" class="mr5 q6">Skirt</li>
                                                                        </ul>
                                                                        <div><label for="other" class="mr5">other: </label><input type="text" name="other[q6]" id="q1other" class="allinput other" value="" maxlength="340" /></div>
                
                                                                </div>
                                                                <div class="hr"></div>
                                                        </div>
                
                                                        <div class="fix">
                                                                <div class="que fix radio">
                                                                        <h3>Q 7: Please indicate how attractive the following features of Elf 
                                                                                Sack are?</h3>
                                                                        <div class="title2" style="width:200px;">Product Design and Style:</div>
                
                                                                        <ul class="q7">
                                                                                <li>Not Trendy At All<br/>(-2)<br/>
                                                                                        <input type="radio" name="q7-1" id="" value="-2"  class="mt5">
                                                                                </li>
                                                                                <li>Some Are Trendy<br/>(-1)<br/>
                                                                                        <input type="radio" name="q7-1" id="" value="-1"  class="mt5">
                                                                                </li>
                                                                                <li>Neutral<br/>(0)<br/>
                                                                                        <input type="radio" name="q7-1" id="" value="0"  class="mt5">
                                                                                </li>
                                                                                <li>On Trendy<br/>(1)<br/>
                                                                                        <input type="radio" name="q7-1" id="" value="1"  class="mt5">
                                                                                </li>
                                                                                <li>Very Trendy<br/>(2)<br/>
                                                                                        <input type="radio" name="q7-1" id="" value="2"  class="mt5">
                                                                                </li>
                                                                        </ul>
                
                                                                        <div class="clear title2" style="width:60px;">Price:</div>
                
                                                                        <ul>
                                                                                <li>Very Expensive<br/>(-2)<br/>
                                                                                        <input type="radio" name="q7-2" id="" value="-2"  class="mt5">
                                                                                </li>
                                                                                <li>Expensive<br/>(-1)<br/>
                                                                                        <input type="radio" name="q7-2" id="" value="-1"  class="mt5">
                                                                                </li>
                                                                                <li>Neutral<br/>(0)<br/>
                                                                                        <input type="radio" name="q7-2" id="" value="0"  class="mt5">
                                                                                </li>
                                                                                <li>Cheap<br/>(1)<br/>
                                                                                        <input type="radio" name="q7-2" id="" value="1"  class="mt5">
                                                                                </li>
                                                                                <li>Very Cheap<br/>(2)<br/>
                                                                                        <input type="radio" name="q7-2" id="" value="2"  class="mt5">
                                                                                </li>
                                                                        </ul>
                
                                                                </div>
                                                                <div class="hr"></div>
                                                        </div>
                
                                                        <div class="fix">
                                                                <div class="que fix">
                                                                        <h3 style="padding:5px 0 8px 0;">Q 8: How old are you?<span class="remark">(Pardon us for asking.)</span></h3>
                                                                        <input type="text" name="q8" id="q8" class="allinput other mt5" value="" maxlength="340" />
                                                                </div>
                                                                <div class="que fix">
                                                                        <h3  style="padding:25px 0 8px 0;">Q 9: On average, how much do you spend on clothing per month?<span class="remark">(Please indicate the currency.)</span></h3>
                                                                        <input type="text" name="q9" id="q9" class="allinput other" maxlength="340" value="" onBlur="if(this.value==''){this.value=this.defaultValue;}"  onfocus="if(this.value=='Please indicate the currency'){this.value='';};" />
                                                                </div>
                                                                <div class="que fix">
                                                                        <h3 style="padding:25px 0 8px 0;">Q 10: Any improvement we should make? Feel free to write it 
                                                                                down.</h3>
                                                                        <textarea class="" name="q10" id="q10" rows="5"></textarea>
                                                                        <div class="fix">
                                                                                <input type="submit" id="qSubmit" class="btn_submit" value="SUBMIT"/><span class="remark fll ml10" style="line-height:70px;">(Please complete all these 10 questions!)</span>
                                                                        </div>           
                                                                        <div class="fix hide">
                                                                                <input type="submit"  class="btn_submit2 mr10" value="SUBMIT"/><div class="btn_login fll" style="margin-bottom:0; margin-top:20px;"><a href="#">Register / Log in first</a>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <script type="text/javascript">
                                                                $(".formquest").validate($.extend(formSettings,{
                                                                        rules: {
                                                                                q1:{required: true},
                                                                                q2:{required: true},
                                                                                q3:{required: true},
                                                                                q4:{required: true},
                                                                                q5:{required: true},
                                                                                q6:{required: true},
                                                                                q7:{required: true},
                                                                                q8:{required: true},
                                                                                q9:{required: true},
                                                                                q10:{required: true}
                                                                        }
                                                                }));
                                                        </script>
                                                </form>-->
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
                <form id="loginForm" method="post" action="<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo URL::current(TRUE); ?>#step2" class="">
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
                <form id="registerForm" method="post" action="<?php echo LANGPATH; ?>/customer/register?redirect=<?php echo URL::current(TRUE); ?>#step2" class="">
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
                            <input type="submit" class="form_btn_long ml10"  value="CREAT ACCOUNT" />
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