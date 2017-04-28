<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Home</a>  >  Создать адрес</div>
        </div>
        <?php echo Message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Создать адрес</h2></div>
            <form action="#" method="post" class="form user_share_form user_form mlr70" name="add">
                <ul class="add_showcon_boxcon">
                    <li class="fix">
                        <label><span>*</span> Имя:</label>
                        <div class="right_box">
                            <input type="text" id="firstname" value="" name="firstname" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label><span>*</span> Фамилия:</label>
                        <div class="right_box">
                            <input type="text" id="lastname"  value="" name="lastname" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label><span>*</span> Адрес:</label>
                        <div class="right_box">
                            <textarea id="address" class="textarea_long" name="address" onchange="ace2()"></textarea><label class="a1 error" style="display:none;"  generated="true" id="guo_con">Please choose your country.</label>
                        </div>
                    </li>
                    <li class="fix">
                        <label for="country"><span class="strong1">*</span> Страна :</label>
                        <div class="right_box">
                        <select name="country" id="country" class="select_style selected304" onchange="changeSelectCountry();$('#country').val($(this).val());">
                            <option value="">ВЫБЕРИТЕ СТРАНУ</option>
                            <?php if (is_array($countries_top)): ?>
                                <?php foreach ($countries_top as $country_top): ?>
                                    <option value="<?php echo $country_top['isocode']; ?>"><?php echo $country_top['name']; ?></option>
                                <?php endforeach; ?>
                                <option disabled="disabled">———————————</option>
                            <?php endif; ?>
                            <?php foreach ($countries as $country): ?>
                                <option value="<?php echo $country['isocode']; ?>" ><?php echo $country['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        </div>
                    </li>
                    <li class="fix states">
                        <?php
                        $stateCalled = Kohana::config('state.called');
                        foreach ($stateCalled as $name => $called)
                        {
                            $called = str_replace(array('County', 'Province'), array('Страна', 'Провинция'), $called);
                            ?>
                            <div class="call" id="call_<?php echo $name; ?>" <?php if ($name != 'Default') echo 'style="display:none;"'; ?>>
                                <label for="state"><span>*</span> <font id=""><?php echo $called; ?></font>:</label>
                            </div>
                            <?php
                        }
                        $stateArr = Kohana::config('state.states');
                        foreach ($stateArr as $country => $states)
                        {
                            $enter_title = 'Выберите Один';
                            ?>
                            <div class="all JS_drop" id="all_<?php echo $country; ?>" style="display:none;">
                                <select name="" class="select_style selected304" onblur="$('#state').val($(this).val());" onchange="acecoun()">
                                    <option value="" class="state_enter">[<?php echo $enter_title; ?>]</option>
                                    <?php
                                    foreach ($states as $coun => $state)
                                    {
                                        if (is_array($state))
                                        {
                                            echo '<optgroup label="' . $coun . '">';
                                            foreach ($state as $s)
                                            {
                                                ?>
                                                <option value="<?php echo $s; ?>"><?php echo $s; ?></option>
                                                <?php
                                            }
                                            echo '</optgroup>';
                                        }
                                        else
                                        {
                                            ?>
                                            <option value="<?php echo $state; ?>"><?php echo $state; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="right_box all" id="all_default">
                            <input type="text" name="state" id="state" class="text text_long" value="" maxlength="320" onblur="$('#shipping_state').val($(this).val());" onchange="acecoun()"  />
                        </div>
                        <script>
                            function changeSelectCountry(){
                                var select = document.getElementById("country");
                                var countryCode = select.options[select.selectedIndex].value;
                                var c_name = 'call_' + countryCode;
                                $(".states .call").hide();
                                if(document.getElementById(c_name))
                                {
                                    $(".states #"+c_name).show();
				                    var ooo = $("#guo_con");
								    ooo.hide();
                                }
								else if(countryCode == 'HK' || countryCode == 'MO' || countryCode == 'TW')
								{   
									$(".states #call_Default").show();                        
									var ooo = $("#guo_con");
									ooo.show();
									ooo.html('請輸入中文地址(Пожалуйста, введите адрес на китайском языке.)');
								}
                                else
                                {
                                    $(".states #call_Default").show();
						            var ooo = $("#guo_con");
                                    ooo.hide();
                                }
                                var s_name = 'all_' + countryCode;
                                $(".states .all").hide();
                                if(document.getElementById(s_name))
                                {
                                    $(".states #"+s_name).show();
                                }
                                else
                                {
                                    $(".states #all_default").show();
                                }
                                $(function(){
                                    $(".states .all select").change(function(){
                                        var val = $(this).val();
                                        $("#state").val(val);
                                    })
                                })
                            }
                        </script>
                    </li>
                    <li class="fix">
                        <label><span>*</span> Город/Городок:</label>
                        <div class="right_box">
                            <input type="text" id="city" value="" name="city" class="text text_long"onchange="acedoun()"  />
							<label class="error a4" style="display:none;"  generated="true" id="guo_eon">Please choose your country.</label>
                        </div>
                    </li>
                    <li class="fix">
                        <label><span>*</span> Почтовый индекс:</label>
                        <div class="right_box">
                            <input type="text" id="zip" value="" name="zip" class="text text_long"onchange="ace()" />
						<label class="error" style="display:none;" generated="true" id="guo_fon">Please choose your country.</label>
                <em style="display:block;">Если вы не используете Индекс в вашем регионе, пожалуйста, введите 0000 вместо.</em>
                        </div>
                    </li>
                    <li class="fix">
                        <label><span>*</span> Телефон:</label>
                        <div class="right_box">
                            <input type="text" id="phone" value="" name="phone" class="text text_long" />
                            <p class="phone_tips">Введите правильный и полный номер телефона,чтобы почтальон товары точно доставил.</p>
                        </div>
                    </li>
                    <li class="fix">
                        <label>&nbsp;</label>
                        <input type="checkbox" name="default" value="1" class="radio" id="default" /> 
                        <label for="default" style="float:none;width: 60%;">Использовать ваш адрес доставки по умолчанию.</label>
                    </li>

                </ul>
                <div class="center">
                    <input type="submit" id="submitAdd" value="Сохранить и добавить новый адрес" class="view_btn btn26" style="width: 300px;" />
                    <input type="reset" value="Отмена" class="view_btn btn26" />
                </div>
            </form>
        </article>
        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
    </section>
</section>
<script>
$(".form").validate({
        rules: {
            firstname: {    
                required: true,
                maxlength:50
            },
            lastname: {    
                required: true,
                maxlength:50
            },
            address: {
                required: true,
                rangelength:[3,200]
            },
            zip: {
                required: true,
                rangelength:[3,10]
            },
            city: {
                required: true,
                maxlength:50
            },
            country: {
                required: true,
                maxlength:50
            },
            state: {
                required: true,
                maxlength:50
            },
            phone: {
                required: true,
                rangelength:[6,20]
            }
        },
        messages: {
                firstname: {
                    required: "Введите ваше имя,пожалуйста.",
                    maxlength:"Имя превышает максимальную длину:50 символов."
                },
                lastname: {
                    required: "Введите вашу фамилию,пожалуйста.",
                    maxlength:"Фамилия превышает максимальную длину:50 символов."
                },
                address: {
                    required: "Введите ваш адрес,пожалуйста.",
                    rangelength: $.validator.format("Пожалуйста, введите  3-100 символов.")
                },
                zip: {
                    required: "Введите ваш почтовый индекс,пожалуйста.",
                    rangelength: $.validator.format("Пожалуйста, введите  3-10 символов.")
                },
                city: {
                    required: "Введите ваш город,пожалуйста.",
                    maxlength:"Город/Городок превышает максимальную длину:50 символов."
                },
                country: {
                    required: "Выберите страну,пожалуйста.",
                    maxlength:"Страна превышает максимальную длину:50 символов."
                },
                state: {
                    required: "Введите вашу страну/провинцию/штат,пожалуйста.",
                    maxlength:"страну/провинцию/штат,пожалуйста превышает максимальную длину:50 символов."
                },
                phone: {
                    required: "Введите ваш номер телефона,пожалуйст", 
                    rangelength: $.validator.format("Пожалуйста, введите номер телефона в пределах 6-20 цифр.")
                }
        }
    });
	
function acecoun(){
    var s = $("#state").val(); 
		var re = /.*\d+.*/;
    if(re.test(s)){ 
            $("#guo_don").show();
            $("#guo_don").html('Страна / Провинция Имя с цифрами? Пожалуйста, проверьте точно.');
        }else{
            $("#guo_don").hide();
        }   
}

function acedoun(){
    var s = $("#city").val(); 
		var re = /.*\d+.*/;
    if(re.test(s)){ 
            $("#guo_eon").show();
            $("#guo_eon").html('Город / Городок Имя с цифрами? Пожалуйста, проверьте точно. ');
        }else{
            $("#guo_eon").hide();
        }   
}

function ace(){
    var s = $("#zip").val(); 
var re = /^[a-zA-Z]{3,10}$/;
        if(re.test(s)){     
        $("#guo_fon").show();
        $("#guo_fon").html("Кажется, что нет цифр в коде, пожалуйста, проверьте точно.");
    }else{
        $("#guo_fon").hide();
    }
}

function check_address(datas)
{
        var s = datas.zip; 
        var re = /^[a-zA-Z]{3,10}$/;
        var c = datas.state;
        var ct = datas.city;
        var ret = /.*\d+.*/;
    // if(re.test(s)){
        // $("#guo222").show();
        // $("#guo222").html("It seems that there are no digits in your code, please check the accuracy.");
    // }else{
        // $("#guo222").hide();
    // }
    if(!trim(datas.firstname) || !trim(datas.lastname) || !trim(datas.address) || !trim(datas.country) || !trim(datas.state) || !trim(datas.city) || !trim(datas.zip) || !trim(datas.phone) || datas.address.length>100 || datas.address.length<3 || (re.test(s)) || (ret.test(c)) || (ret.test(ct)) || datas.phone.length>20 || datas.phone.length<6 || s.length>10 || s.length<3) 
        return 0;
    else
        return 1;
}

$("form[name='add']").submit(function(){
    var datas = createData(this);
    if(!check_address(datas))
        return false;

})



function createData(formObj){
    var datas = new Object();
    formElement = $(formObj).find("input,select,textarea");
    formElement.each(function(i,n){
        datas[$(n).attr("name")] = $(n).val();
    });
    return datas;
}

function trim(str){
    return str.replace(/(^\s*)|(\s*$)/g, "");
}
</script>