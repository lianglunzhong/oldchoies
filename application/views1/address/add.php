<?php
if(empty(LANGUAGE))
{
	$lists = Kohana::config('/customer/address.en');
}
else
{
	$lists = Kohana::config('/customer/address.'.LANGUAGE);
}
?>
<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/"><?php echo $lists['title1']; ?></a>
				<a href="<?php echo LANGPATH; ?>/customer/summary"> > <?php echo $lists['title2']; ?></a> > <?php echo $lists['title3']; ?>
			</div>
			<?php echo Message::get(); ?>
		</div>
	</div>
	<!-- main-middle begin -->
	<div class="container">
		<div class="row">
<?php echo View::factory('customer/left'); ?>
<?php echo View::factory('customer/left_1'); ?>
			<article class="user col-sm-9 col-xs-12">
				<div class="tit">
					<h2><?php echo $lists['title4']; ?></h2>
				</div>
				<div class="row">
					<div class="col-sm-2 hidden-xs"></div>
					<form action="#" method="post" class="user-form user-share-form col-sm-8 col-xs-12 form"  name="add">
						<ul>
							<li>
								<label class="col-sm-3 col-xs-12">
									<span>*</span> <?php echo $lists['First Name']; ?>
								</label>
								<div class="col-sm-9 col-xs-12">
									<input class="text text-long col-sm-12 col-xs-12" type="text" id="firstname" name="firstname" value="">
								</div>
							</li>
							<li>
								<label class="col-sm-3 col-xs-12">
									<span>*</span> <?php echo $lists['Last Name']; ?>
								</label>
								<div class="col-sm-9 col-xs-12">
									<input class="text text-long col-sm-12 col-xs-12" type="text" id="lastname" name="lastname" value="">
								</div>
							</li>
							<li>
								<label class="col-sm-3 col-xs-12">
									<span>*</span> <?php echo $lists['Address']; ?>
								</label>
								<div class="col-sm-9 col-xs-12">
									<textarea id="address" class="textarea-long col-sm-12 col-xs-12" name="address" onchange="ace2(this)"></textarea>
                                    <label class="a1 error" style="display:none;"  generated="true" id="guo_con"><?php echo $lists['Please choose your country']; ?></label>
                                    <label class="a1 error" style="display:none;"  generated="true" id="guo_con_2"><?php echo $lists['Please choose your country']; ?></label>
								</div>
							</li>
							<li>
								<label class="col-sm-3 col-xs-12"><span>*</span><?php echo $lists['Country']; ?> </label>
								<div class="col-sm-9 col-xs-12">
									<div class="wdrop">
										<select name="country" id="country" class="selected-option col-sm-12 col-xs-12" onchange="changeSelectCountry();$('#country').val($(this).val());">
											<option value=""><?php echo $lists['SELECT A COUNTRY']; ?></option>
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
								</div>
							</li>
				<li class="states">
        <?php
        $stateCalled = Kohana::config('state.called');
        foreach ($stateCalled as $name => $called)
        {
            ?>
					<label class="call col-sm-3 col-xs-12" id="call_<?php echo $name; ?>" <?php if ($name != 'Default') echo 'style="display:none;"'; ?>><span>*</span> <?php echo $called; ?></label>
            <?php
        }
        $stateArr = Kohana::config('state.states');
        foreach ($stateArr as $country => $states)
        {
			if(!empty(LANGUAGE) and LANGUAGE != 'en')
			{
				if($country == "US")
				{
					$enter_title = $lists['Select One1'];
				}
				else
				{
					$enter_title = $lists['Select One2'];
				}
			}else{
				$enter_title = 'Select One';
			}

            ?>
					<div class="col-sm-9 col-xs-12">
						<div class="wdrop all" id="all_<?php echo $country; ?>" style="display:none;">
							<select  name="" class="selected-option col-sm-12  col-xs-12 select_style selected304"  onblur="$('#state').val($(this).val());" onchange="acecoun()">
								<option value="">[<?php echo $enter_title; ?>]</option>
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
					</div>
            <?php
        }
        ?>
											<div class="col-sm-9 col-xs-12 all"  id="all_default"  style="margin-top:-15px;">
						<input type="text" name="state" id="state" class="text text-long col-sm-12 col-xs-12" value="" maxlength="320"  onblur="$('#shipping_state').val($(this).val());"  onchange="acecoun()" />
            <div class="errorInfo"></div>
            <label class="error a3" style="display:none;"  generated="true" id="guo_don"><?php echo $lists['title1']; ?>Please choose your country.</label>
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
							ooo.html('請輸入中文地址(Please enter the address in Chinese.)');
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
							<li>

								<label class="col-sm-3 col-xs-12">
									<span>*</span> <?php echo $lists['City / Town']; ?>
								</label>
								<div class="col-sm-9 col-xs-12">
									<input class="text text-long col-sm-12 col-xs-12"  id="city" type="text" name="city" value="" onchange="acedoun()">
					<label class="error a4" style="display:none;"  generated="true" id="guo_eon"><?php if(!empty(LANGUAGE) and LANGUAGE != 'en'){ echo $lists['City1'];}else{ echo $lists['Please choose your country'];} ?></label>
								</div>
							</li>
							<li>
								<label class="col-sm-3 col-xs-12">
									<span>*</span> <?php echo $lists['Zip / Postal Code']; ?>
								</label>
								<div class="col-sm-9 col-xs-12">
									<input class="text text-long col-sm-12 col-xs-12" type="text" id="zip" name="zip" value="" onchange="ace()">
				<label class="error" style="display:none;" generated="true" id="guo_fon"><?php echo $lists['Please choose your country']; ?>.</label>
        <em style="display:block;"><?php echo $lists['Code2']; ?></em>
								</div>
							</li>
							<li>
								<label class="col-sm-3 col-xs-12">
									<span>*</span> <?php echo $lists['Phone']; ?>
								</label>
								<div class="col-sm-9 col-xs-12">
									<input class="text text-long col-sm-12 col-xs-12" type="text" id="phone" name="phone" value="">
									<p class="phone-tips col-sm-12 col-xs-12"><?php echo $lists['Phone1']; ?></p>
								</div>
							</li>
							<li>
								<label class="col-sm-3 xs-hidden">&nbsp; </label>
								<div class="btn-grid12 col-sm-9 col-xs-12">
									<input id="default" class="radio" type="checkbox" value="1" name="default">
									<span for="default"><?php echo $lists['Make this your default shipping address']; ?></span>
								</div>
							</li>
							<li>
								<label class="col-sm-3 xs-hidden">&nbsp;</label>
								<div class="btn-grid12 col-sm-9 col-xs-12">
									<input class="view_btn btn btn-primary btn-sm" type="submit" value="<?php echo $lists['save & Add New']; ?>">
									<input class="btn btn-default btn-sm ml10" type="reset" value="<?php echo $lists['Cancel']; ?>">
								</div>
							</li>
						</ul>
					</form>
					<div class="col-sm-2 hidden-xs"></div>
				</div>
			</article>
	
	</div>
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
                rangelength:[3,100]
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
                required: "<?php echo $lists['firstname']['required']; ?>",
                maxlength:"<?php echo $lists['firstname']['required']; ?>",
            },
            lastname: {
                required: "<?php echo $lists['lastname']['required']; ?>",
                maxlength:"<?php echo $lists['lastname']['required']; ?>",
            },
            address: {
                required: "<?php echo $lists['address']['required']; ?>",
                rangelength: $.validator.format("<?php echo $lists['address']['required']; ?>")
            },
            zip: {
                required: "<?php echo $lists['zip']['required']; ?>",
                rangelength: $.validator.format("<?php echo $lists['zip']['required']; ?>")
            },
            city: {
                required: "<?php echo $lists['city']['required']; ?>",
                maxlength:"<?php echo $lists['city']['required']; ?>",
            },
            country: {
                required: "<?php echo $lists['country']['required']; ?>",
                maxlength:"<?php echo $lists['country']['required']; ?>",
            },
            state: {
                required: "<?php echo $lists['state']['required']; ?>",
                maxlength:"<?php echo $lists['state']['required']; ?>",
            },
            phone: {
                required: "<?php echo $lists['phone']['required']; ?>",
                rangelength: $.validator.format("<?php echo $lists['phone']['required']; ?>")
            }
        }
    });
	

function acecoun(){
    var s = $("#state").val(); 
		var re = /.*\d+.*/;
    if(re.test(s)){ 
            $("#guo_don").show();
            $("#guo_don").html("<?php echo $lists['guo_don']; ?>");
        }else{
            $("#guo_don").hide();
        }   
}

function ace2(acese)
{
    var addrs = acese.value;
    var re =  /@/;
    if(re.test(addrs))
    {
            $("#guo_con_2").show();
            $("#guo_con_2").html("<?PHP echo $lists['guo_con_2']; ?>");
    }
    else
    {
            $("#guo_con_2").hide(); 
            $("#guo_con_2").html(); 
    }
	
}

function acedoun(){
    var s = $("#city").val(); 
		var re = /.*\d+.*/;
    if(re.test(s)){ 
            $("#guo_eon").show();
            $("#guo_eon").html("<?php echo $lists['guo_eon']; ?>");
        }else{
            $("#guo_eon").hide();
        }   
}

function ace(){
    var s = $("#zip").val(); 
var re = /^[a-zA-Z]{3,10}$/;
        if(re.test(s)){     
        $("#guo_fon").show();
        $("#guo_fon").html("<?php echo $lists['guo_fon']; ?>");
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
	</body>

</html>