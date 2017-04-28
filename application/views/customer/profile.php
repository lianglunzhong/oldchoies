
<!-- crumbs -->
<div class="layout">
    <div class="crumbs fix">
        <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  Account Setting</div>
    </div>
    <?php echo Message::get(); ?>
</div>

<!-- main begin -->
<section class="layout fix">
    <article id="container" class="user flr">
        <div class="tit"><h2>Account Setting</h2></div>
        <form action="#" method="post" class="form user_form" id="accountSettings">
            <ul>
                <li class="fix">
                    <label><span>*</span> Email:</label>
                    <div class="right"><?php echo $customer['email']; ?></div>
                </li>
                <li class="fix">
                    <label><span>*</span> First Name:</label>
                    <div class="right"><input type="text" value="<?php echo $customer['firstname']; ?>" name="firstname" id="firstname" class="text text_long" /></div>
                </li>
                <li class="fix">
                    <label><span>*</span> Last Name:</label>
                    <div class="right"><input type="text" value="<?php echo $customer['lastname']; ?>" name="lastname" id="lastname" class="text text_long" /></div>
                </li>

                <li class="fix">
                    <label><span>*</span> Country:</label>
                    <div class="right">
                        <div class="wdrop">
                            <div class="JS_drop drop">
                                <span class="selected selecteds selected304">
                                    <?php
                                    if ($customer['country'])
                                    {
                                        $country_name = DB::select('name')->from('countries')->where('isocode', '=', $customer['country'])->execute()->get('name');
                                        echo $country_name;
                                    }
                                    else
                                    {
                                        echo 'Select A Country';
                                    }
                                    ?>
                                </span>
                                <div class="JS_drop_box drop_box drop_boxs drop_box304 hide">
                                    <ul class="drop_list">
                                        <?php
                                        $countries = Site::instance()->countries(LANGUAGE);
                                        foreach ($countries as $country):
                                            ?>
                                            <li <?php if ($customer['country'] == $country['isocode']) echo 'selected'; ?>><?php echo $country['name']; ?><input type="hidden" class="hvalue" value="<?php echo $country['isocode']; ?>" /></li>
                                            <?php
                                        endforeach;
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <input class="Js_repNum" type="hidden" value="<?php echo $customer['country'] ? $customer['country'] : ''; ?>" name="country" />
                        </div>
                    </div>
                </li>
                <li class="fix">
                    <label>Gender:</label>
                    <div class="right" id="gender">
                        <input type="radio" name="gender" value="1" id="radio1" class="radio" <?php if ($customer['gender'] == 1) echo 'checked'; ?> /><label for="radio1" style="float: none;">Female</label>
                        <input type="radio" name="gender" value="0" id="radio2" class="radio" <?php if ($customer['gender'] == 0) echo 'checked'; ?> /><label for="radio2" style="float: none;">Male</label>
                    </div>
                </li>
                <li class="fix">
                    <label>Birthday:</label>
                    <div class="right">
                        <div class="right_box fix">
                            <div class="wdrop fll">
                                <div class="JS_drop drop">
                                    <span class="selected selecteds selected82">
                                        <?php
                                        $year = '';
                                        if ($customer['birthday'])
                                            $year = date('Y', $customer['birthday']);
                                        echo $year;
                                        ?>
                                    </span>
                                    <div class="JS_drop_box drop_box drop_boxs drop_box82 hide">
                                        <ul class="drop_list" id="yearlist">
                                            <li></li>
                                            <?php
                                            for ($i = date('Y') - 1; $i >= 1901; $i--):
                                                ?>
                                                <li <?php if ($year == $i) echo 'class="selected"' ?>><?php echo $i; ?><input type="hidden" class="hvalue" value="<?php echo $i; ?>" /></li>
                                                <?php
                                            endfor;
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <input class="Js_repNum" type="hidden" id="year" value="<?php echo $year; ?>" name="year" />
                            </div>
                            <div class="wdrop fll">
                                <div class="JS_drop drop">
                                    <span class="selected selecteds selected82">
                                        <?php
                                        $month = '';
                                        if ($customer['birthday'])
                                            $month = date('m', $customer['birthday']);
                                        echo $month;
                                        ?>
                                    </span>
                                    <div class="JS_drop_box drop_box drop_boxs drop_box82 hide">
                                        <ul class="drop_list" id="monthlist">
                                            <?php
                                            for ($i = 1; $i <= 12; $i++):
                                                ?>
                                                <li <?php if ($month == $i) echo 'class="on"' ?>><?php echo $i; ?><input type="hidden" class="hvalue" value="<?php echo $i; ?>" /></li>
                                                <?php
                                            endfor;
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <input class="Js_repNum" type="hidden" id="month" value="<?php echo $month; ?>" name="month" />
                            </div>
                            <div class="wdrop fll">
                                <div class="JS_drop drop">
                                    <span class="selected selecteds selected82">
                                        <?php
                                        $day = '';
                                        if ($customer['birthday'])
                                            $day = date('d', $customer['birthday']);
                                        echo $day;
                                        $hides = array(
                                            29 => '', 30 => '', 31 => ''
                                        );
                                        if($month == 2)
                                        {
                                            $hides[30] = 'hide';
                                            $hides[31] = 'hide';
                                            $is_leap = 0 == $year % 4 && ($year % 100 != 0 || $year % 400 == 0);
                                            if(!$is_leap)
                                            {
                                                $hides[29] = 'hide';
                                            }
                                        }
                                        elseif($month == 4 || $month == 6 || $month == 9 || $month == 11)
                                        {
                                            $hides[31] = 'hide';
                                        }
                                        ?>
                                    </span>
                                    <div class="JS_drop_box drop_box drop_boxs drop_box82 hide">
                                        <ul class="drop_list" id="daylist">
                                            <?php
                                            for ($i = 1; $i <= 31; $i++):
                                                ?>
                                                <li class="<?php if ($day == $i) echo 'on '; if ($i > 28) {echo 'day' . $i . ' '; echo $hides[$i]; } ?>"><?php echo $i; ?>
                                                    <input type="hidden" class="hvalue" value="<?php echo $i; ?>" />
                                                </li>
                                                <?php
                                            endfor;
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <input class="Js_repNum" id="day" type="hidden" value="<?php echo $day; ?>" name="day" />
                            </div>
                        </div>
                    </div>
                </li>
                <li class="fix">
                    <label>&nbsp;</label>
                    <div class="right">
                        <input type="submit" name="" value="save" class="view_btn btn26 btn40" />
                    </div>
                </li>
            </ul>
        </form>

<!--        <div class="tit"><h2>Email Preference</h2></div>
        <p class="center">We want to make sure we're sending you the information you most want to hear about.</p>
        <p class="center">Please fill up all the questions below.</p>
        <ul class="JS_tab1 detail_tab fix" id="question">
            <li<?php if ($customer['gender'] == 0) echo ' class="on"'; ?>>Female</li>
            <li<?php if ($customer['gender'] == 1) echo ' class="on"'; ?>>Male</li>
        </ul>
        <div class="JS_tabcon1 detail_tabcon" id="question_list">
            <form action="#" method="post" class="bd <?php if ($customer['gender'] == 1) echo 'hide'; ?>">
                <dl class="user_preference">
                    <dt>Question 1. How would you like to describe your fashion style?</dt>
                    <dd>
                        <ul class="user_preference_select fix">
                            <li class="JS_select2">Boho<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Goth<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Earthy<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Trendsetter<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Feminine/Girly<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Sporty<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Urban<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Classic<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Couture<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Glam/ Punk<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Vintage<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Indie<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Elegant / Classic<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Sophisticated<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Preppy<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Polished<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Bold and edgy<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">School Girl<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Casual<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Collegiate<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">English<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Ethnic<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2 text_underline">Add Your Own<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                        </ul> 
                    </dd>
                    <dt>Question 2. On average, how much do you spend on clothing per month?</dt>
                    <dd>
                        <ul class="user_preference_select user_preference_select1 fix">
                            <li class="JS_select2">$0-$30<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">$30-$50<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">$50-$100<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">$100-$150<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">$150-$200<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">$200-$300<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">$300-$500<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">above $500<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                        </ul> 
                    </dd>
                    <dt>Question 3. Email frequency</dt>
                    <dd>
                        <ul class="user_preference_select user_preference_select2 fix">
                            <li class="JS_select2"><b>Choies Newsletter: Daily</b>
                                Receive info on our new looks for each day<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2"><b>Choies Newsletter: Weekly</b>
                                Receive info about our new looks for each week<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                        </ul> 
                    </dd>
                    <dt class="last"><a href="#" class="view_btn btn26">Edit</a><input type="submit" name="" value="save" class="view_btn btn26 btn40" /></dt>
                </dl>
            </form>
            <form action="#" method="post" class="bd <?php if ($customer['gender'] == 0) echo 'hide'; ?>">
                <dl class="user_preference">
                    <dt>Question 1. How would you like to describe your fashion style?</dt>
                    <dd>
                        <ul class="user_preference_select fix">
                            <li class="JS_select2">Boho<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Goth<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Earthy<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Trendsetter<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Sporty<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Urban<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Classic<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Couture<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Glam/ Punk<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Vintage<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Indie<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Elegant / Classic<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Sophisticated<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Preppy<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Polished<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Bold and edgy<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Casual<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Collegiate<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">English<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">Ethnic<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2 text_underline">Add Your Own<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                        </ul> 
                    </dd>
                    <dt>Question 2. On average, how much do you spend on clothing per month?</dt>
                    <dd>
                        <ul class="user_preference_select user_preference_select1 fix">
                            <li class="JS_select2">$0-$30<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">$30-$50<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">$50-$100<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">$100-$150<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">$150-$200<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">$200-$300<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">$300-$500<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">above $500<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2">above $800<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                        </ul> 
                    </dd>
                    <dt>Question 3. Email frequency</dt>
                    <dd>
                        <ul class="user_preference_select user_preference_select2 fix">
                            <li class="JS_select2"><b>Choies Newsletter: Daily</b>
                                Receive info on our new looks for each day<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                            <li class="JS_select2"><b>Choies Newsletter: Weekly</b>
                                Receive info about our new looks for each week<input type="hidden" name="service" class="JS_hidden2" value="0" /></li>
                        </ul> 
                    </dd>
                    <dt class="last"><a href="#" class="view_btn btn26">Edit</a><input type="submit" name="" value="save" class="view_btn btn26 btn40" /></dt>
                </dl>
            </form>-->
        </div>
    </article>
    <?php echo View::factory('/customer/left'); ?>
</section>
</section>

<script type="text/javascript">
    $(function(){
        $("#gender .select1").live('click', function(){
            var val = $(this).attr('title');
            $("#gender input").val(val);
            $("#question").find('li').eq(val).addClass('on');
            $("#question").find('li').eq(val).siblings().removeClass('on');
            $("#question_list").find('form').eq(val).show();
            $("#question_list").find('form').eq(val).siblings().hide();
        })
        
        $("#yearlist li").live('click', function(){
            var month = $("#month").val();
            $("#daylist .day31").show();
            $("#daylist .day30").show();
            $("#daylist .day29").show();
            if(month == 2)
            {
                $("#daylist .day31").hide();
                $("#daylist .day30").hide();
                var year = $(this).find('input').val();
                if(!isLeapYear(year))
                {
                    $("#daylist .day29").hide();
                }
            }
            else if(month == 4 || month == 6 || month == 9 || month == 11)
            {
                $("#daylist .day31").hide();
            }
        })
        
        $("#monthlist li").live('click', function(){
            var month = $(this).find('input').val();
            $("#daylist .day31").show();
            $("#daylist .day30").show();
            $("#daylist .day29").show();
            if(month == 2)
            {
                $("#daylist .day31").hide();
                $("#daylist .day30").hide();
                var year = $("#year").val();
                if(!isLeapYear(year))
                {
                    $("#daylist .day29").hide();
                }
            }
            else if(month == 4 || month == 6 || month == 9 || month == 11)
            {
                $("#daylist .day31").hide();
            }
        })
    })
    function isLeapYear(year) {
        return(0 == year % 4 && (year % 100 != 0 || year % 400 == 0));
    }
</script>