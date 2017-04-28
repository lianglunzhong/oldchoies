<?php
if(empty(LANGUAGE))
{
    $lists = Kohana::config('/art/checkout.en');
}
else
{
    $lists = Kohana::config('/art/checkout.'.LANGUAGE);
}

?>
<body>
<div class="page">
    <header class="site-header">
        <div class="cart-header">
            <div class="container">
                <div class="row">
                    <div class="col-xs-8 col-md-8">
                        <a href="<?php echo LANGPATH; ?>/" class="logo"><img src="<?php echo STATICURL; ?>/assets/images/2016/logo.png"></a>
                    </div>
                    <div class="col-xs-4 col-md-4">
                        <a href="" target="_blank"><img src="<?php echo STATICURL; ?>/assets/images/card3.png"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="phone-cart-header">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="step-nav">
                            <ul class="clearfix">
                                <li>Place Order<em></em><i></i></li>
                                <li class="current">Pay<em></em><i></i></li>
                                <li>Succeed<em></em><i></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="site-content">
        <div class="main-container clearfix">
            <div class="container">
                <div class="row">
                    <div class="cart clearfix">
                        <div class="col-xs-12 col-sm-7">
                            <div class="shipping-information">
                                <div class="information-con">
                                    <div class="billing-address">
                                        <h3><strong>Billing Address</strong><span>Please make sure the billing address you enter below matches the name and address associated with the credit card you are using for this purchase.Please note your billing address and shipping address country must be the same.</span></h3>
                                        <p class="mt10" id="address"><?php echo $billAddress['firstName'].' '.$billAddress['lastName'];?>, <?php echo $billAddress['phone'];?>, <?php echo $billAddress['address'].' '.$billAddress['city'].' '.$billAddress['state'].' '.$billAddress['country'].' '.$billAddress['zip']?><a href="javascript:;" data-reveal-id="myModal">Edit</a></p>
                                    </div>

                                </div>
                                <div class="payment-wrap">
                                    <div class="payment-p">
                                        <div class="payment-message">
                                            <div class="fll mr20">Order Amount:
                                                <span class=" f16 bold"> <?php  echo $amount.$currency;?></span>
                                            </div>
                                            <div class="fll">Order NO.:<span class=" f16 bold"><?php echo $ordernum;?></span></div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <form id="ipay" action="/payment/ipay_pay" method="post">
                                            <input type="hidden" name="ordernum" value="<?php echo $ordernum;?>">
                                            <ul>
                                                <li class="clearfix">
                                                   <!-- <label class="payment-td-right bold"><em>*</em>Credit Card Type</label>
                                                    <select name="" class="ui-input" style="width:130px">
                                                        <option selected="selected" value="1"> Visa </option>
                                                        <option value="3"> MasterCard </option>
                                                        <option value="122"> Visa Electron </option>
                                                        <option value="114"> Visa Debit </option>
                                                        <option value="119"> MasterCard Debit </option>
                                                        <option value="125"> JCB </option>
                                                        <option value="128"> Discover </option>
                                                        <option value="132"> Diners Club </option>
                                                    </select>-->
                                                    <div class="payment-ul">
                                                        <ul>
                                                            <li onclick="">
                                                                <label for=""><img src="<?php echo STATICURL; ?>/assets/images/card16.jpg" title="Visa"></label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li class="clearfix">
                                                    <label class="payment-td-right bold"><em>*</em>Credit Card Number</label>
                                                    <div class="payment-card-time">12-19 digits, spaces are not allowed</div>
                                                    <div class="card-num">
                                                        <input class="ui-input" style="width:220px;" maxlength="19" name="cardNumber" id="cardNumber">
                                                        <div class="card-num-box"></div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </li>
                                                <li class="clearfix">
                                                    <label class="payment-td-right bold"><em>*</em>Expiration Date</label>
                                                    <div class="fll" style="width:100px;">
                                                        <select  class="ui-input" style="width:70px;" name="cardMonth" id="cardMonth">
                                                            <option value="1"> 01 </option>
                                                            <option value="2"> 02 </option>
                                                            <option value="3"> 03 </option>
                                                            <option value="4"> 04 </option>
                                                            <option value="5"> 05 </option>
                                                            <option value="6"> 06 </option>
                                                            <option value="7"> 07 </option>
                                                            <option value="8"> 08 </option>
                                                            <option value="9"> 09 </option>
                                                            <option value="10"> 10 </option>
                                                            <option value="11"> 11 </option>
                                                            <option value="12"> 12 </option>
                                                        </select>
                                                        <div class="payment-card-time fl">MONTH</div>
                                                    </div>
                                                    <div class="fll" style="margin-top:17px;">/</div>
                                                    <div class="fll" style="width:100px;">
                                                        <select class="ui-input" style="width:70px;" name="cardYear" id="cardYear">
                                                            <option value="17"> 17 </option>
                                                            <option value="18"> 18 </option>
                                                            <option value="19"> 19 </option>
                                                            <option value="20"> 20 </option>
                                                            <option value="21"> 21 </option>
                                                            <option value="22"> 22 </option>
                                                            <option value="23"> 23 </option>
                                                            <option value="24"> 24 </option>
                                                            <option value="25"> 25 </option>
                                                            <option value="26"> 26 </option>
                                                            <option value="27"> 27 </option>
                                                            <option value="28"> 28 </option>
                                                            <option value="29"> 29 </option>
                                                            <option value="30"> 30 </option>
                                                            <option value="31"> 31 </option>
                                                            <option value="32"> 32 </option>
                                                        </select>
                                                        <div class="payment-card-time fl">YEAR</div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </li>
                                                <li class="clearfix">
                                                    <label class="payment-td-right bold"><em>*</em>Security Code <span style="font-weight:normal; color:#999">(CVV/CVC)</span></label>
                                                    <input  maxlength="3" class="ui-input" style="width:60px;" id="cardCode" name="cardCode" type="text">
                                                    <div class="payment-icon-box-pic-en"><img src="<?php echo STATICURL; ?>/assets/images/payment-new-credit-crad.png"></div>
                                                    <div class="clearfix"></div>
                                                </li>
                                            </ul>
                                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                <tbody>
                                                <tr>
                                                    <td style="text-align: left;padding: 30px 0 30px 15px;" width="487">
                                                        <input value="PAY NOW"  class="btn btn-primary btn-lg" type="submit"></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-offset-1">
                            <div class="order-summary">
                                <div class="cart-side">
                                    <p>
                                        <strong>Accepted Credit Cards</strong>
                                        We accept VISA, Electron, MasterCard and Debit
                                        VISA or Debit MasterCard.<br>
                                        If you use another card ( e.g. Maestro  or American
                                        Express) please Pay with <a style="text-decoration:underline;" href="https://www.choies.com/order/view/13255451340" target="_blank">PayPal</a> instead.
                                        <br>
                                        <br>
                                        <strong>60-day Refund Policy</strong>
                                        If you're not satisfied with your purchase, then
                                        simply email at
                                        <a style="text-decoration:underline;" href="mailto:service@choies.com" target="_blank">service@choies.com</a>
                                        to get a return
                                        authorization (return address) or exchange authorization within 60 days upon receipt.
                                    </p>
                                    <div class="add-payment">
                                        <strong>Additional payment security with:</strong>
                                        <span class="encryption"><b></b>Secure Checkout  256-bit SSL encryption by Norton</span>
                                        <span>
				                            <img src="<?php echo STATICURL; ?>/assets/images/card24.jpg" usemap="#Card24">
				                            <map name="Card24" id="Card24">
				                                <area target="_blank" shape="rect" coords="2,1,91,49" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en">
				                            </map>
				                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- JS-popwincon1 -->
<div id="myModal" class="reveal-modal large">
    <a class="close-reveal-modal close-btn3"></a>
    <div class="address-fill">
        <h3>Billing Address</h3>
        <form class="form payment-form form2" id="billAddressEdit">
            <input type="hidden" name="is_checkout" value="1">
            <ul>
                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span> First Name:</label>
                    <input type="text" value="<?php echo $billAddress['firstName']?>" name="firstname" id="firstname" class="text col-xs-12 col-md-9">
                </li>
                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span> Last Name:</label>
                    <input type="text" value="<?php echo $billAddress['lastName']?>" name="lastname" id="lastname" class="text col-xs-12 col-md-9">
                </li>
                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span> Address:</label>
                    <div>
                        <textarea class="col-xs-12 col-md-9" name="address" id="addressEdit" ><?php echo $billAddress['address']?></textarea>
                    </div>
                </li>
                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span> Country:</label>
                    <select class="select-style  col-xs-12 col-md-9" name="country" id="billCountry">
                        <option value="">SELECT A COUNTRY</option>
                        <?php if (is_array($countries_top)): ?>
                            <?php foreach ($countries_top as $country_top): ?>
                                <option value="<?php echo $country_top['isocode']; ?>"><?php echo $country_top['name']; ?></option>
                            <?php endforeach; ?>
                            <option disabled="disabled">———————————</option>
                        <?php endif; ?>
                        <?php foreach ($countries as $country): ?>
                            <option value="<?php echo $country['isocode']; ?>" <?php if ($billAddress['country'] == $country['isocode']) echo 'selected'; ?> ><?php echo $country['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </li>
                <li class="states2">
                    <?php
                    $stateCalled = Kohana::config('state.called');
                    foreach ($stateCalled as $name => $called)
                    {
                        ?>
                        <div class="col-xs-12 col-md-3 call2" id="call2_<?php echo $name; ?>" <?php if ($name != 'Default') echo 'style="display:none;"'; ?>>
                            <label for="state"><span>*</span> <font id=""><?php echo $called; ?></font>:</label>
                        </div>
                        <?php
                    }
                    $stateArr = Kohana::config('state.states');
                    foreach ($stateArr as $country => $states)
                    {
                        if(!empty(LANGUAGE) and LANGUAGE !='en')
                        {
                            if($country == "US")
                            {
                                $enter_title = $lists['Select One1'];
                            }
                            else
                            {
                                $enter_title = $lists['Select One2'];
                            }
                        }else
                        {
                            $enter_title = $lists['Select One'];
                        }


                        ?>
                        <div class="all2 JS_drop" id="all2_<?php echo $country; ?>" style="display:none;">
                            <select  class="select-style col-xs-12 col-md-9 s_state" >
                                <option  class="state-enter" >[<?php echo 'select'; ?>]</option>
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
                    <input type="text" class="text col-xs-12 col-md-9" id="state" name="state" value="">

                </li>

                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span> City / Town:</label>
                    <input type="text" value="<?php echo $billAddress['city']?>" name="city" id="city" class="text col-xs-12 col-md-9">
                </li>
                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span> Zip / Postal Code:</label>
                    <input type="text" value="<?php echo $billAddress['zip']?>" name="zip" id="zip" class="text col-xs-12 col-md-9">
                </li>
                <li>
                    <label class="col-xs-12 col-md-3"><span>*</span> Phone:</label>
                    <input type="text" value="<?php echo $billAddress['phone']?>" name="phone" id="phone" class="text col-xs-12 col-md-9">
                    <p class=" mt5 col-md-offset-3 col-xs-12 col-md-9">Please leave correct and complete phone number for accurate delivery by postman</p>
                </li>

            </ul>
            <input type="hidden" name="ordernum" value="<?php echo $ordernum;?>">
            <p class="col-md-offset-3 col-xs-12 col-md-9"><button type="button"  class="btn btn-default" onclick="setBillAddress()">COUNTINUE</button></p>
        </form>
    </div>
</div>
</body>
<script>
    function Trim(str)
    {
        return str.replace(/(^\s*)|(\s*$)/g, "");
    }
    var country1 = $('#billCountry').val();
    var select = '';
    $("#billCountry").change(function () {

        $("#all2_" + country1).hide();
        country = $('#billCountry').val();
        if(document.getElementById("all2_" + country)){
            $("#all2_" + country).show();
            country1 = country;
            $("#state").hide();
            select = "#all2_" + country;
        } else {
            $("#state").show();
        }

    });

    $('.s_state').change(function () {
        option = $(this).val();
        $("#state").val(option);
    });


    function setBillAddress() {
        if(!$('#billCountry').val()){alert('Please select a country');return false;};
        if($('#state').val()=='[select]'){alert('Please select a state');return false;};

        if(!Trim($('#firstname').val())){alert('First name cannot be empty');return false;};
        if(!Trim($('#lastname').val())){alert('Last name cannot be empty');return false;};
        if(!Trim($('#addressEdit').val())){alert('Address cannot be empty');return false;};
        if(!Trim($('#city').val())){alert('City / Town cannot be empty');return false;};
        if(!Trim($('#zip').val())){alert('Zip / Postal Code cannot be empty');return false;};
        if(!Trim($('#state').val())){alert('Country / Province Code cannot be empty');return false;};
        if(!Trim($('#state').val())){alert('Please select a state');return false;};
        if(isNaN($('#phone').val())){alert('Please enter a valid phone number');return false;};
        $.ajax({
            type: "POST",
            url: "/address/ajax_edit1",
            data: $('#billAddressEdit').serialize(),
            dataType: "json",
            success: function (data) {
                if(data['success']==1)
                {
                    alert(data['message']);
                    $("#address").html(data.address);
                    $("#myModal").css('visibility','hidden');
                    $(".reveal-modal-bg").css('display','none');
                }else{
                    alert(data['message']);
                }

            }
        })
    }
    $("#ipay").submit(function () {
        if(!Trim($('#cardNumber').val())){alert('Credit Card Number cannot be empty');return false;};
        if(!Trim($('#cardMonth').val())){alert('Expiration Date cannot be empty');return false;};
        if(!Trim($('#cardYear').val())){alert('Expiration Date cannot be empty1');return false;};
        if(!Trim($('#cardCode').val())){alert('Security Code cannot be empty');return false;};
    })
</script>