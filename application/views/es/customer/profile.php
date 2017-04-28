
<!-- crumbs -->
<div class="layout">
    <div class="crumbs fix">
        <div class="fll"><a href="<?php echo LANGPATH; ?>/">Página de Inicio</a>  >  Configuración de Cuenta</div>
    </div>
    <?php echo Message::get(); ?>
</div>

<!-- main begin -->
<section class="layout fix">
    <article id="container" class="user flr">
        <div class="tit"><h2>Configuración de Cuenta</h2></div>
        <form action="#" method="post" class="form user_form" id="accountSettings">
            <ul>
                <li class="fix">
                    <label><span>*</span> Email:</label>
                    <div class="right"><?php echo $customer['email']; ?></div>
                </li>
                <li class="fix">
                    <label><span>*</span> Primer Nombre:</label>
                    <div class="right"><input type="text" value="<?php echo $customer['firstname']; ?>" name="firstname" id="firstname" class="text text_long" /></div>
                </li>
                <li class="fix">
                    <label><span>*</span> Apellido:</label>
                    <div class="right"><input type="text" value="<?php echo $customer['lastname']; ?>" name="lastname" id="lastname" class="text text_long" /></div>
                </li>

                <li class="fix">
                    <label><span>*</span> País:</label>
                    <div class="right">
                        <div class="wdrop">
                            <div class="JS_drop">
                                <?php
                                if ($customer['country'])
                                    $country_name = DB::select('name')->from('countries')->where('isocode', '=', $customer['country'])->execute()->get('name');
                                else
                                    echo 'Seleccionar un país';
                                ?>
                                <select name="country" class="select_style selected304">
                                    <option>SELECCIONAR UN PAÍS</option>
                                    <?php
                                    $countries = Site::instance()->countries(LANGUAGE);
                                    foreach ($countries as $country)
                                    {
                                        ?>
                                        <option value="<?php echo $country['isocode']; ?>" <?php if ($customer['country'] == $country['isocode']) echo 'selected'; ?>><?php echo $country['name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="fix">
                    <label>Sexo:</label>
                    <div class="right" id="gender">
                        <input type="radio" name="gender" value="1" id="radio1" class="radio" <?php if ($customer['gender'] == 1) echo 'checked'; ?> /><label for="radio1" style="float: none;">Mujer</label>
                        <input type="radio" name="gender" value="0" id="radio2" class="radio" <?php if ($customer['gender'] == 0) echo 'checked'; ?> /><label for="radio2" style="float: none;">Hombre</label>
                    </div>
                </li>
                <li class="fix">
                    <label>Fecha De Nacimiento:</label>
                    <div class="right">
                        <div class="right_box fix">
                            <div class="wdrop fll">
                                <div class="JS_drop drop mr10">
                                    <?php
                                    $year = '';
                                    if ($customer['birthday'])
                                        $year = date('Y', $customer['birthday']);
                                    ?>
                                    <select name="year" id="yearlist" class="select_style selected106">
                                        <?php
                                        for ($i = date('Y') - 1; $i >= 1901; $i--)
                                        {
                                            ?>
                                            <option value="<?php echo $i; ?>" <?php if ($year == $i) echo 'selected="selected"' ?>><?php echo $i; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="wdrop fll">
                                <div class="JS_drop drop mr10">
                                    <?php
                                    $month = '';
                                    if ($customer['birthday'])
                                        $month = date('m', $customer['birthday']);
                                    ?>
                                    <select name="month" id="monthlist" class="select_style selected106">
                                        <?php
                                        for ($i = 1; $i <= 12; $i++)
                                        {
                                            ?>
                                            <option value="<?php echo $i; ?>" <?php if ($month == $i) echo 'selected="selected"' ?>><?php echo $i; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="wdrop fll">
                                <div class="JS_drop drop">
                                    <?php
                                    $day = '';
                                    if ($customer['birthday'])
                                        $day = date('d', $customer['birthday']);
                                    $hides = array(
                                        29 => '', 30 => '', 31 => ''
                                    );
                                    if ($month == 2)
                                    {
                                        $hides[30] = 'hide';
                                        $hides[31] = 'hide';
                                        $is_leap = 0 == $year % 4 && ($year % 100 != 0 || $year % 400 == 0);
                                        if (!$is_leap)
                                        {
                                            $hides[29] = 'hide';
                                        }
                                    }
                                    elseif ($month == 4 || $month == 6 || $month == 9 || $month == 11)
                                    {
                                        $hides[31] = 'hide';
                                    }
                                    ?>
                                    <select name="day" id="daylist" class="select_style selected106">
                                        <?php
                                        for ($i = 1; $i <= 31; $i++)
                                        {
                                            ?>
                                            <option value="<?php echo $i; ?>" <?php if ($day == $i) echo 'selected="selected"' ?> class="<?php
                                        if ($i > 28)
                                        {
                                            echo 'day' . $i . ' ';
                                            echo $hides[$i];
                                        }
                                            ?>"><?php echo $i; ?></option>
                                                    <?php
                                                }
                                                ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="fix">
                    <label>&nbsp;</label>
                    <div class="right">
                        <input type="submit" name="" value="GUARDAR" class="view_btn btn26 btn40" />
                    </div>
                </li>
            </ul>
        </form>
        </div>
    </article>
    <?php echo View::factory(LANGPATH . '/customer/left'); ?>
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
        
        $("#yearlist").change(function(){
            var month = $(this).val();
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
        
        $("#monthlist").change(function(){
            var month = $(this).val();
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