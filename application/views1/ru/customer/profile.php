<section id="main">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs">
            <div>
                <a href="<?php echo LANGPATH; ?>/">Accueil</a>
                <a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > Личный кабинет</a> > Настройка профиля
            </div>

        </div>
    </div>
    <!-- main-middle begin -->
    <div class="container">
        <div class="row">
<?php echo View::factory(LANGPATH . '/customer/left'); ?>
<?php echo View::factory(LANGPATH . '/customer/left_1'); ?>
            <article class="user col-sm-9 col-xs-12">
                <div class="tit">
                    <h2>Настройка профиля</h2>
                </div>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <form action="#" method="post" class="user-form form col-sm-8" id="accountSettings">
                        <ul>
                            <li>
                                <label class="col-sm-3 col-xs-12"><span>*</span> Email:</label>
                                <div class="col-sm-9 col-xs-12"><?php echo $customer['email']; ?></div>
                            </li>
                            <li>
                                <label class="col-sm-3 col-xs-12"><span>*</span> Имя:</label>
                                <div class="col-sm-9 col-xs-12">
                                    <input type="text" required="required" value="<?php echo $customer['firstname']; ?>" name="firstname" id="firstname" class="text-long text col-sm-12 col-xs-12" />
                                </div>
                            </li>
                            <li>
                                <label class="col-sm-3 col-xs-12"><span>*</span>Фамилия:</label>
                                <div class="col-sm-9 col-xs-12">
                                    <input type="text" required="required" value="<?php echo $customer['lastname']; ?>" name="lastname" id="lastname" class="text-long text col-sm-12 col-xs-12" />
                                </div>
                            </li>
                            <li>
                                <label class="col-sm-3 col-xs-12"><span>*</span>Страна:</label>
                                <div class="col-sm-9 col-xs-12">
                                    <div class="wdrop">

                                        <select class="selected-option col-sm-12 col-xs-12"   name="country">
                                    <option value="" class="selected">  
                                            <?php
                                if ($customer['country'])
                            {

                                $country_name = DB::select('name')->from('countries')->where('isocode', '=', $customer['country'])->execute()->get('name');
                                 echo $country_name;
                            }
                            else
                            {
                                echo 'ВЫБЕРИТЕ СТРАНУ';
                            }   
                            ?></option>
                               <?php
                                $countries = Site::instance()->countries(LANGUAGE);
                                foreach ($countries as $country):
                                    ?>
                                            <option <?php if ($customer['country'] == $country['isocode']) echo 'selected'; ?> value="<?php echo $country['isocode']; ?>" >
                                            <?php echo $country['name']; ?> 
                                            </option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <label class="col-sm-3 col-xs-12">Пол:</label>
                                <div class="col-sm-9 col-xs-12">
                                    <span class="w-radio"><input type="radio" name="gender" value="1" id="radio1" <?php if ($customer['gender'] == 1) echo 'checked'; ?> /> Женщина</span>
                                    <span class="w-radio"><input type="radio" name="gender" value="0" id="radio2" <?php if ($customer['gender'] == 0) echo 'checked'; ?> /> Мужчина</span>
									<span class="w-radio"><input type="radio" name="gender" value="2" id="radio3" <?php if ($customer['gender'] == 2) echo 'checked'; ?> /> Другой</span>
                                </div>
                            </li>
                            <li>                                

                                <label class="col-sm-3 col-xs-12">День рождения:</label>
                                <div class="col-sm-9 col-xs-12">
                                    <div class="wdrop-chip col-xs-4 pl">
                            <?php                     
                                $year = '';
                                if ($customer['birthday'])
                                    $year = date('Y', $customer['birthday']);

                              ?> 
                                        <select class="selected-option col-xs-12" id="yearlist"  name="year">

                                <?php
                                    for ($i = date('Y') - 1; $i >= 1901; $i--):
                                        ?>
                                            <option value="<?php echo $i; ?>" 
                                            <?php if ($year == $i){ ?>
                                                selected 
                                                <?php } ?>
                                                > <?php echo $i; ?> </option>
                                       <?php
                                    endfor;
                                    ?>
                                        </select>
                                    </div>
                                    <div class="wdrop-chip col-xs-4 pl">
                                        <select class="selected-option col-xs-12" id="monthlist"  name="month">
                                        <?php
                                $month = '';
                                if ($customer['birthday'])
                                    $month = date('m', $customer['birthday']); 
                                
                                ?> 
                                   <?php
                                    for ($i = 1; $i <= 12; $i++):
                                        ?>
                                    <option <?php if ($month == $i){ ?>
                                    selected
                                    <?php   } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                       <?php
                                    endfor;
                                    ?>
                                        </select>

                                    </div>
                                    <div class="wdrop-chip col-xs-4 pl">                                                                                       <?php
                                $day = '';
                                if ($customer['birthday'])
                                    $day = date('d', $customer['birthday']);
                            //    echo $day;
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
                                        <select class="selected-option col-xs-12" id="daylist"  name="day">

                                <?php
                                    for ($i = 1; $i <= 31; $i++):
                                        ?>
                                            <option value="<?php echo $i; ?>" <?php if ($day == $i){ ?>
                                            selected 
                                        <?php   } if ($i > 28) {echo 'day' . $i . ' '; echo $hides[$i]; } ?>><?php echo $i; ?></option>
                                <?php
                                    endfor;
                                    ?>
                                        
                                        </select>

                                    </div>
                                </div>
                            </li>
                            <li>
                                <label class="col-sm-3 hidden-xs">&nbsp;</label>
                                <div class="btn-grid12 col-sm-9 col-xs-12">
                                    <input type="submit" name="" value="Сохранить" class="btn btn-primary btn-sm" />
                                </div>
                            </li>
                        </ul>
                    </form>
                    <div class="col-sm-2"></div>
                </div>
            </article>

        </div>
    </div>
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
    
        // $(".JS_drop").live('click', function(){
               // var _this=$(this);
        // })
</script>