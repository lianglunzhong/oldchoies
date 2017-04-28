<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  Address Book</div>
        </div>
        <?php echo Message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Address Book</h2></div>
            <!-- form begin -->
            <dl class="address_book">
                <dd class="last">
                    <div class="form form2 address_book_form">
                        <p class="top_btn"><a href="<?php echo LANGPATH; ?>/address/add" id="add_new" class="view_btn btn26 btn40">Add New</a></p>
                        <?php
                        $countries = Site::instance()->countries(LANGUAGE);
                        $countries_top = Site::instance()->countries_top(LANGUAGE);
                        foreach ($addresses as $key => $address):
                            $country = $address['country'];
                            foreach ($countries as $c)
                            {
                                if ($c['isocode'] == $country)
                                {
                                    $country = $c['name'];
                                    break;
                                }
                            }
                            ?>
                            <div class="JS_select1 w_address_book_con <?php if (!$key) echo 'selected'; ?>" title="<?php echo $address['id']; ?>">
                                <div class="address_book_con">
                                    <ul>
                                        <?php
                                        if ($address['is_default']):
                                            ?>
                                            <li class="fix">
                                                <label>Label:</label>
                                                <div class="right_box">
                                                    This is your default shipping address
                                                </div>
                                            </li>
                                            <?php
                                        endif;
                                        ?>
                                        <li class="fix">
                                            <label>Name:</label>
                                            <div class="right_box">
                                                <?php echo $address['firstname'] . ' ' . $address['lastname']; ?>
                                            </div>
                                        </li>
                                        <li class="fix">
                                            <label>Tel:</label>
                                            <div class="right_box">
                                                <?php echo $address['phone']; ?>
                                            </div>
                                        </li>
                                        <li class="fix">
                                            <label>Address:</label>
                                            <div class="right_box">
                                                <?php echo $address['address']; ?>
                                                <?php echo $address['city'] . ', ' . $address['state'] . ' ' . $country . ' ' . $address['zip']; ?>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <form action="<?php echo LANGPATH; ?>/address/set_default" method="post">
                                <p class="top_btn">
                                    <a href="<?php echo LANGPATH; ?>/address/edit/<?php echo $address['id']; ?>" class="view_btn btn26 btn40 edit_address" title="<?php echo $address['id']; ?>">Edit</a>
                                    <a href="javascript:delete_address(<?php echo $address['id']; ?>)" class="view_btn btn26 btn40 delete">Delete</a>
                                    <?php
                                    if (!$address['is_default'])
                                    {
                                        ?>
                                        <input type="hidden" name="address_id" value="<?php echo $address['id']; ?>" id="address_id" />
                                        <input type="submit" value="DEFAULT" class="view_btn btn26" />
                                        <?php
                                    }
                                    ?>
                                </p>
                            </form>
                            <?php
                        endforeach;
                        ?>
                    </div>

                </dd>
            </dl>
        </article>
        <?php echo View::factory('customer/left'); ?>
    </section>
</section>
<!-- JS_popwincon -->
<div class="JS_popwincon popwincon popwincon_user hide" id="edit_address">
    <a class="JS_close1 close_btn2"></a>
    <div class="tit"><h2>EDIT YOUR ADDRESS</h2></div>
    <form action="/address/ajax_edit" method="post" class="form address_form user_share_form user_form" name="add">
        <input type="hidden" name="return_url" value="/customer/address" />
        <input type="hidden" id="e_address_id" name="address_id" value="">
        <ul class="add_showcon_boxcon">
            <li>
                <label><span>*</span> First Name:</label>
                <input type="text" id="e_firstname" value="" name="firstname" class="text text_long" />
            </li>
            <li>
                <label><span>*</span> Last Name:</label>
                <input type="text" id="e_lastname" value="" name="lastname" class="text text_long" />
            </li>
            <li>
                <label><span>*</span> Address:</label>
                <div>
                    <textarea id="e_address" class="textarea_long" name="address"  onchange="ace2()"></textarea>
                </div>
                <label class="a1 error" style="display:none;"  generated="true" id="guo_con">Please choose your country.</label>
            </li>
            <li>
                <label><span>*</span> Country:</label>
                <div class="right_box">
                <select name="country" id="e_country" class="select_style selected304" onchange="changeSelectCountry1();$('#billing_country').val($(this).val());">
                    <option value="">SELECT A COUNTRY</option>
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
            <li class="states1">
                <?php
                $stateCalled = Kohana::config('state.called');
                foreach ($stateCalled as $name => $called)
                {
                    ?>
                    <div class="call1" id="call1_<?php echo $name; ?>" <?php if ($name != 'Default') echo 'style="display:none;"'; ?>>
                        <label for="state"><span>*</span> <font id=""><?php echo $called; ?></font>:</label>
                    </div>
                    <?php
                }
                $stateArr = Kohana::config('state.states');
                foreach ($stateArr as $country => $states)
                {
                    ?>
                    <div class="all1 JS_drop" id="all1_<?php echo $country; ?>" style="display:none;">
                        <select name="" class="select_style selected304 e_state" onchange="acecoun()">
                            <option value="">[Select One]</option>
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
                <div class="all1" id="all1_default">
                    <input type="text" name="state" id="e_state" class="text text_long" value="" maxlength="320" onchange="acecoun()" />
                    <div class="errorInfo"></div>
                    <label class="error a3" style="display:none;"  generated="true" id="guo_don">Please choose your country.</label>
                </div>
                <script>
                    function changeSelectCountry1(){
                        var select = document.getElementById("e_country");
                        var countryCode = select.options[select.selectedIndex].value;
                        if(countryCode == 'BR')
                        {
                            $("#e_cpf").show();
                        var ooo = $("#guo_con");
                            ooo.hide();
                        }
                        else if(countryCode == 'HK' || countryCode == 'MO' || countryCode == 'TW')
                        {   
                        
                        var ooo = $("#guo_con");
                            ooo.show();
                            ooo.html('請輸入中文地址(Please enter the address in Chinese.)');
                        }
                        else
                        {
                            $("#e_cpf").hide();
                        var ooo = $("#guo_con");
                            ooo.hide();
                        }
                        var c_name = 'call1_' + countryCode;
                        $(".states1 .call1").hide();
                        if(document.getElementById(c_name))
                        {
                            $(".states1 #"+c_name).show();
                        }
                        else
                        {
                            $(".states1 #call1_Default").show();
                        }
                        var s_name = 'all1_' + countryCode;
                        $(".states1 .all1").hide();
                        if(document.getElementById(s_name))
                        {
                            $(".states1 #"+s_name).show();
                        }
                        else
                        {
                            $(".states1 #all1_default").show();
                        }
                        $(function(){
                            $(".states1 .all1 select").change(function(){
                                var val = $(this).val();
                                $("#e_state").val(val);
                            })
                        })
                    }
                </script>
            </li>
            <li>
                <label><span>*</span> City / Town:</label>
                <input type="text" id="e_city" value="" name="city" class="text text_long" onchange="acedoun()" />
                <label class="error a4" style="display:none;"  generated="true" id="guo_eon">Please choose your country.</label>
            </li>
            <li>
                <label><span>*</span> Zip / Postal Code:</label>
                <input type="text" id="e_zip" value="" name="zip" class="text text_long" onchange="ace()" />
                <label class="error" style="display:none;" generated="true" id="guo_fon">Please choose your country.</label>
                <em style="display:block;margin-left:160px">If there is no zip code in your area, please enter 0000 instead.</em>
            </li>
            <li>
                <label><span>*</span> Phone:</label>
                <input type="text" id="e_phone" value="" name="phone" class="text text_long" />
                <em style="display:block;margin-left:160px">Please leave correct and complete phone number for 
                    accurate delivery by postman</em>
            </li>
            <li id="e_cpf" class="hide">
                <label><span>*</span>o cadastro de pessoa Física:</label>
                <input type="text" name="cpf" class="text text_long" value="" />
            </li>
            <li class="fix">
                <label>&nbsp;</label>
                <input type="checkbox" name="default" value="1" class="radio" id="default" /> 
                <label for="default" style="float:none;width: 50%;">Make this your default shipping address.</label>
            </li>

        </ul>
        <div class="center">
            <input type="submit" id="submitAdd" value="save & Add New" class="view_btn btn26" />
            <input type="submit" id="submitSave" value="save" class="view_btn btn26" />
            <input type="reset" value="Cancel" class="view_btn btn26" />
        </div>
    </form>
</div>
<script type="text/javascript">
    $(".address_form").validate({
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
                required: "Please enter your first name.",
                maxlength:"The first name exceeds maximum length of 50 characters."
            },
            lastname: {
                required: "Please enter your last name.",
                maxlength:"The last name exceeds maximum length of 50 characters."
            },
            address: {
                required: "Please enter your address.",
                rangelength: $.validator.format("Please enter 3-100 characters.")
            },
            zip: {
                required: "Please enter your zip.",
                rangelength: $.validator.format("Please enter 3-10 characters.")
            },
            city: {
                required: "Please enter your city.",
                maxlength:"The city exceeds maximum length of 50 characters."
            },
            country: {
                required: "Please choose your country.",
                maxlength:"The country exceeds maximum length of 50 characters."
            },
            state: {
                required: "Please enter your County / Province / State.",
                maxlength:"The country exceeds maximum length of 50 characters."
            },
            phone: {
                required: "Please enter your phone.",
                rangelength: $.validator.format("Please enter a phone no. within 6-20 digits.")
            }
        }
    });


function ace2(){
   var select = document.getElementById("e_country");
   var countryCode = select.options[select.selectedIndex].value;
        if(countryCode == 'HK' || countryCode == 'MO' || countryCode == 'TW')
        {   
            $("#guo111").show();
            $("#guo111").html('請輸入中文地址(Please enter the address in Chinese.)');
        }else{
            $("#guo111").hide();
        }   
}
function acecoun(){
    var s = $("#e_state").val(); 
var re = /.*\d+.*/;
    if(re.test(s)){ 
            $("#guo_don").show();
            $("#guo_don").html('County / Province Name with digits? Please check the accuracy.');
        }else{
            $("#guo_don").hide();
        }   
}

function acedoun(){
    var s = $("#e_city").val(); 
var re = /.*\d+.*/;
    if(re.test(s)){ 
            $("#guo_eon").show();
            $("#guo_eon").html('City / Town Name with digits? Please check the accuracy.');
        }else{
            $("#guo_eon").hide();
        }   
}

function ace(){
    var s = $("#e_zip").val(); 
var re = /^[a-zA-Z]{3,10}$/;
        if(re.test(s)){     
        $("#guo_fon").show();
        $("#guo_fon").html("It seems that there are no digits in your code, please check the accuracy.");
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

    $(function(){
        $(".edit_address").live('click', function(){
            var id = $(this).attr('title');
            $.ajax({
                type: "POST",
                url: "/address/ajax_data",
                dataType: "json",
                data: "id="+id,
                success: function(addresses){
                    if(addresses)
                    {
                        $("#e_address_id").val(addresses['id']);
                        $("#e_firstname").val(addresses['firstname']);
                        $("#e_lastname").val(addresses['lastname']);
                        $("#e_address").val(addresses['address']);
                        $("#e_country").val(addresses['country']);
                        $(".e_state").val(addresses['state']);
                        $("#e_state").val(addresses['state']);
                        $("#e_city").val(addresses['city']);
                        $("#e_zip").val(addresses['zip']);
                        $("#e_phone").val(addresses['phone']);
                        if(addresses['country'] == "BR")
                        {
                            $("#e_cpf input").val(addresses['cpf']);
                            $("#e_cpf").show();
                        }
                        $(".states1 .all1").hide();
                        var s_name = 'all1_'+addresses['country'];
                        if(document.getElementById(s_name))
                        {
                            $(".states1 #"+s_name).show();
                        }
                        else
                        {
                            $("#all1_default").show();
                        }
                        if(addresses['is_default'] == 1)
                        {
                            $("#default").addClass('selected');
                            $("#default input").val(1);
                        }
                        else
                        {
                            $("#default").removeClass('selected');
                            $("#default input").val(0);
                        }
                        $('html, body').animate({scrollTop: $('#edit_address').offset().top - 90}, 10); 
                    }
                }
            });
            $("#edit_address .tit h2").text('EDIT YOUR ADDRESS');
            var top = getScrollTop();
            top = top - 35;
            $('body').append('<div class="JS_filter opacity"></div>');
            $('#edit_address').css({
                "top": top, 
                "position": 'absolute'
            });
            $('#edit_address').appendTo('body').fadeIn(320);
            $('#edit_address').show();
            $("#submitSave").show();
            $("#submitAdd").hide();
            return false;
        })
        
        $("#add_new").live('click', function(){
            $("#e_address_id").val('new');
            $("#e_firstname").val('');
            $("#e_lastname").val('');
            $("#e_address").val('');
            $("#e_country").val('');
            $(".e_state").val('');
            $("#e_state").val('');
            $("#e_city").val('');
            $("#e_zip").val('');
            $("#e_phone").val('');
            $("#e_cpf input").val('');
            $("#default").removeClass('selected');
            $("#default input").val(0);
            $("#edit_address .tit h2").text('ADD NEW ADDRESS');
            var top = getScrollTop();
            top = top - 35;
            $('body').append('<div class="JS_filter opacity"></div>');
            $('#edit_address').css({
                "top": top, 
                "position": 'absolute'
            });
            $('#edit_address').appendTo('body').fadeIn(320);
            $('#edit_address').show();
            $("#submitAdd").show();
            $("#submitSave").hide();
            return false;
        })
        
        $(".address_book_form .w_address_book_con").live('click', function(){
            var address_id = $(this).attr('title');
            $("#address_id").val(address_id);
        })
    })
    function delete_address(id)
    {
        if (!window.confirm('Are you sure you want to delete this? It cannot be undone.'))
        {
            return false;
        }
        location.href = "/address/delete/"+id;
    }
</script>