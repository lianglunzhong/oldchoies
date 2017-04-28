<link type="text/css" rel="stylesheet" href="<?php echo LANGPATH; ?>/css/all.css" media="all" id="mystyle"  />
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/jquery.validate.js"></script>
<div class="eddit_address">
    <div class="tit">Edit Shipping Address</div>
    <form id="shippingAddress" method="post" action="#" class="formArea" style="overflow: hidden;">
        <input type="hidden" name="shipping_address_id" value="<?php echo $address['id']; ?>" />
        <input type="hidden" name="return_url" value="<?php echo $return_url; ?>" />
        <ul id="newAddress" class="shipping_adress" style="margin-top:1px;">
            <li>
                <label for="firstname"><span>*</span> First Name:</label>
                <input type="text" name="shipping_firstname" id="firstname" class="allInput" value="<?php echo $address['firstname']; ?>" maxlength="16" onblur="$('#firstname').val($(this).val());" />
                <div class="errorInfo"></div>
            </li>
            <li>
                <label for="lastname"><span>*</span> Last Name:</label>
                <input type="text" name="shipping_lastname" id="lastname" class="allInput" value="<?php echo $address['lastname']; ?>" maxlength="16" onblur="$('#lastname').val($(this).val());" />
                <div class="errorInfo"></div>
            </li>
            <li>
                <label for="address"><span>*</span> Address:</label>
                <input type="text" name="shipping_address" id="address" class="allInput" value="<?php echo $address['address']; ?>" maxlength="320" onblur="$('#address').val($(this).val());" />
                <div class="errorInfo"></div>
            </li>
            <li>
                <label for="country"><span>*</span> Country:</label>
                <select name="shipping_country" id="country" class="allSelect" onchange="changeSelectCountry();$('#country').val($(this).val());return getCarrier($(this).val());">
                    <option value="">-Select-</option>
                    <?php foreach ($countries as $country): ?>
                        <option value="<?php echo $country['isocode']; ?>" <?php if ($country['isocode'] == $address['country']) echo 'selected'; else ''; ?> ><?php echo $country['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="errorInfo"></div>
            </li>
            <li class="states">
                <?php
                $stateCalled = Kohana::config('state.called');
                if (array_key_exists($address['country'], $stateCalled))
                    $call = $address['country'];
                else
                    $call = 'Default';
                foreach ($stateCalled as $name => $called)
                {
                    ?>
                    <div class="call" id="call_<?php echo $name; ?>" <?php if ($name != $call) echo 'style="display:none;"'; ?>>
                        <label for="state"><span>*</span> <font id="state_name"><?php echo $called; ?></font>:</label>
                    </div>
                    <?php
                }
                $stateArr = Kohana::config('state.states');
                if (array_key_exists($address['country'], $stateArr))
                    $s_call = $address['country'];
                else
                    $s_call = 'Default';
                foreach ($stateArr as $country => $states)
                {
                    ?>
                    <div class="all" id="all_<?php echo $country; ?>" <?php if ($country != $s_call) echo 'style="display:none;"'; ?>>
                        <select name="" id="state1" class="allSelect" onblur="$('#state1').val($(this).val());">
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
                                        <option value="<?php echo $s; ?>" <?php if ($s == $address['state']) echo 'selected'; else ''; ?>><?php echo $s; ?></option>
                                        <?php
                                    }
                                    echo '</optgroup>';
                                }
                                else
                                {
                                    ?>
                                    <option value="<?php echo $state; ?>" <?php if ($state == $address['state']) echo 'selected'; else ''; ?>><?php echo $state; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <?php
                }
                ?>
                <div class="all" id="all_default" <?php if ($s_call != 'Default') echo 'style="display:none;"'; ?>>
                    <input type="text" name="shipping_state" id="state" class="allInput" value="<?php echo $address['state']; ?>" maxlength="320" onblur="$('#state').val($(this).val());" />
                    <div class="errorInfo"></div>
                </div>
            </li>
            <li>
                <label for="city"><span>*</span> City / Town:</label>
                <input type="text" name="shipping_city" id="city" class="allInput" value="<?php echo $address['city']; ?>" maxlength="320" onblur="$('#city').val($(this).val());" />
                <div class="errorInfo"></div>
            </li>
            <li>
                <label for="zip"><span>*</span> Zip / Postal Code:</label>
                <input type="text" name="shipping_zip" id="zip" class="allInput" value="<?php echo $address['zip']; ?>" maxlength="16" onblur="$('#zip').val($(this).val());"  />
                <div class="errorInfo"></div>
            </li>
            <li>
                <label for="phone"><span>*</span> Phone:</label>
                <input type="text" name="shipping_phone" id="phone" class="allInput" value="<?php echo $address['phone']; ?>" maxlength="320"  onblur="$('#phone').val($(this).val());" />
                <div class="errorInfo"></div>
            </li>
            <li id="cpfIn" class="hide">
                <label for="cpf"><strong class="red">*</strong>o cadastro de pessoa Física:</label>
                <input type="text" name="shipping_cpf" id="cpf" class="allInput" value="" maxlength="16"  onblur="$('#cpf').val($(this).val());" />
                <div class="errorInfo"></div>
            </li>
            <script type="text/javascript">
                function changeSelectCountry(){
                    var select = document.getElementById("country");
                    var countryCode = select.options[select.selectedIndex].value;
                    if(countryCode=="BR"){
                        $("#cpfIn").show();
                    }
                    else {
                        $("#cpfIn").hide();
                    }
                    var c_name = 'call_' + countryCode;
                    $(".states .call").hide();
                    if(document.getElementById(c_name))
                    {
                        $(".states #"+c_name).show();
                    }
                    else
                    {
                        $(".states #call_Default").show();
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
                }
                $(function(){
                    $(".states .all select").change(function(){
                        var val = $(this).val();
                        $(".all #state").val(val);
                    })
                })
                $("#shippingAddress").validate($.extend(formSettings,{
                    rules: {
                        shipping_firstname:{required: true},
                        shipping_lastname:{required: true},
                        shipping_address:{required: true},
                        shipping_country:{required: true},
                        shipping_state:{required: true},
                        shipping_city:{required: true},
                        shipping_zip:{required: true},
                        shipping_phone:{required: true}                
                    }
                }));
            </script>
        </ul>
        <input type="submit" value="Save" class="form_btn ship_btn ml10" id="shippingAddressSubmit" />
    </form>
</div>
