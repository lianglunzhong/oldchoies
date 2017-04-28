<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/">Homepage</a>
				<a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > KONTOÜBERSICHT</a> > Adressbuch
			</div>
			<div class="back visible-xs-inline hidden-sm hidden-md hidden-lg">&lt;&lt;&nbsp;</div><?php echo Message::get(); ?>
		</div>
	</div>
	<!-- main-middle begin -->
	<div class="container">
		<div class="row">
<?php echo View::factory(LANGPATH . '/customer/left'); ?>
	<?php echo View::factory(LANGPATH . '/customer/left_1'); ?>
			<article class="user col-sm-9 col-xs-12">
				<div class="tit">
					<h2>Adressbuch</h2>
				</div>
				<div class="row">
					<div class="col-sm-3 hidden-xs"></div>
					<dl class="address-book col-sm-6 col-xs-12">
						<dd class="last">
							<div class="address-book-form">
								<p class="top-btn"><a class="btn btn-primary btn-xs"  href="<?php echo LANGPATH; ?>/address/add">NEUE ADRESSE HINZUFÜGEN</a>
								</p>
                <?php
                $countries = Site::instance()->countries();
                $countries_top = Site::instance()->countries_top();
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
								<div title="" class="JS_select1 w-address-book-con <?php if (!$key) echo 'selected'; ?>" title="<?php echo $address['id']; ?>">
									<div class="address-book-con">
										<ul>
								<?php
                                if ($address['is_default']):
                                    ?>
											<li>
												<label>Label:</label>
												<div>Dies ist Ihre Standard Lieferadresse</div>
											</li>
                            <?php
                                endif;
                                ?>
                                			<li>
	                                            <label>Name:</label>
	                                            <div class="right_box">
	                                                <?php echo $address['firstname'] . ' ' . $address['lastname']; ?>
	                                            </div>
	                                        </li>
											<li>
												<label>Tel:</label>
												<div><?php echo $address['phone']; ?></div>
											</li>
											<li>
												<label>Adresse:</label>
												<div>                                   <?php echo $address['address']; ?>
                                        <?php echo $address['city'] . ', ' . $address['state'] . ' ' . $country . ' ' . $address['zip']; ?></div>
											</li>
										</ul>
									</div>
								</div>
								<form method="post" action="<?php echo LANGPATH; ?>/address/set_default">
									<p class="top-btn">
										<a  href="<?php echo LANGPATH; ?>/address/edit/<?php echo $address['id']; ?>" class="a-red edit_address JS-popwinbtn" title="<?php echo $address['id']; ?>" >EDITIEREN</a>
										<a class="a-underline delete" href="javascript:delete_address(<?php echo $address['id']; ?>)">LÖSCHEN</a>
										
										<?php
										if (!$address['is_default'])
										{
										?>
										<input type="hidden" id="address_id" value="<?php echo $address['id']; ?>" name="address_id">
										<input type="submit" class="btn btn-default btn-xs flr" value="DEFAULT">
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
					<div class="col-sm-3 hidden-xs"></div>
				</div>
			</article>

		</div>
	</div>
</section>

<script type="text/javascript">
	// JS_filter1
		function getScrollTop() {
		    var scrollPos; 
		    if (window.pageYOffset) 
		    {
		        scrollPos = window.pageYOffset;
		    } 
		    else if (document.compatMode && document.compatMode != 'BackCompat')
		    { 
		        scrollPos = document.documentElement.scrollTop; 
		    } 
		    else if (document.body) 
		    { 
		        scrollPos = document.body.scrollTop; 
		    } 
		    return scrollPos; 
		}
		$(".JS_popwinbtn").live("click",function(){
						
					    var top = getScrollTop();
					    top = top - 35;
					    $('body').append('<div class="JS_filter opacity hidden-xs"></div>');
					    $('.JS_popwincon').css({
					        "top": top, 
					        "position": 'absolute'
					    });
					    
					    $('.JS_popwincon').appendTo('body').fadeIn(320);
					    $('.JS_popwincon').show();
					    return false;
					})			
		$(".JS_close1,.JS_filter").live("click",function(){
					    $(".JS_filter").remove();
					    $('.JS_popwincon').fadeOut(160);
					    return false;
					})
</script>

<!-- JS_popwincon -->
<div class="JS_popwincon popwincon popwincon-user hide hidden-xs" id="edit_address">
	<a class="JS_close1 close-btn2"></a>
	<div class="tit">
		<h2>IHRE ADRESSE EDITIEREN</h2>
	</div>
	<div class="row">
		<form action="<?php echo LANGPATH; ?>/address/ajax_edit" method="post" class="form address_form user-share-form user-form" name="add">
<input type="hidden" name="return_url" value="<?php echo LANGPATH; ?>/customer/address" />
<input type="hidden" id="e_address_id" name="address_id" value="">
			<ul class="add-showcon-boxcon">
				<li>
					<label class="col-sm-3 col-xs-12"><span>*</span> Vorname:</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" id="e_firstname" value="" name="firstname" class="text text-long col-sm-12 col-xs-12" />
					</div>
				</li>
				<li>
					<label class="col-sm-3 col-xs-12"><span>*</span> Nachname:</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" id="e_lastname" value="" name="lastname" class="text text-long col-sm-12 col-xs-12" />
					</div>
				</li>
				<li>
					<label class="col-sm-3 col-xs-12"><span>*</span> Adresse:</label>
					<div class="col-sm-9 col-xs-12">
						<textarea id="e_address" class="textarea-long col-sm-12 col-xs-12" name="address" onchange="ace2(this)"></textarea>
        <label class="a1 error" style="display:none;"  generated="true" id="guo_con"></label>
        <label class="a1 error" style="display:none;"  generated="true" id="guo_con_2">Please choose your country.</label>
					</div>
				</li>
				<li>
					<label class="col-sm-3 col-xs-12"><span>*</span> Land:</label>
					<div class="col-sm-9 col-xs-12">
						<div class="wdrop">
							<select name="country" id="e_country" class="selected-option col-sm-12 col-xs-12" onchange="changeSelectCountry1();$('#billing_country').val($(this).val());">
            <option value="">EIN LAND WÄHLEN</option>
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
				<li class="states1">
        <?php
        $stateCalled = Kohana::config('state.called');
        foreach ($stateCalled as $name => $called)
        {
            $called = str_replace(array('County', 'Province'), array('Bundesland', 'Provinz'), $called);
            ?>
					<label class="call1 col-sm-3 col-xs-12" id="call1_<?php echo $name; ?>" <?php if ($name != 'Default') echo 'style="display:none;"'; ?>><span>*</span> <?php echo $called; ?></label>
            <?php
        }
        $stateArr = Kohana::config('state.states');
        foreach ($stateArr as $country => $states)
        {
        	if($country == "US")
            {
                $enter_title = 'Einen Bundesstaat Eingeben';
            }
            else
            {
                $enter_title = 'Ein(e) Bundesland/Provinz Wählen';
            }
            ?>
					<div class="col-sm-9 col-xs-12">
						<div class="wdrop all1" id="all1_<?php echo $country; ?>" style="display:none;">
							<select  name="" class="selected-option col-sm-12  col-xs-12  e_state" onchange="acecoun()">
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
						</div>
            <?php
        }
        ?>
					
					<div class="col-sm-9 col-xs-12 all1"  id="all1_default">
						<input type="text" name="state" id="e_state" class="text text-long col-sm-12 col-xs-12" value="" maxlength="320" onchange="acecoun()" />
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
                    ooo.html('請輸入中文地址(Bitte geben Sie die Adresse auf Chinesisch ein.)');
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
                    $(".states1 .col-sm-9 .all1 select").change(function(){
                        var val = $(this).val();
                        $("#e_state").val(val);
                    })
                })
            }
        </script>
				</li>
				<li>
					<label class="col-sm-3 col-xs-12"><span>*</span> Stadt / Ort:</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" id="e_city" value="" name="city" class="text text-long col-sm-12 col-xs-12" onchange="acedoun()" />
        <label class="error a4" style="display:none;"  generated="true" id="guo_eon">Stadt / Ort mit Ziffern? Bitte überprüfen Sie es noch einmal.</label>
					</div>
				</li>
				<li>
					<label class="col-sm-3 col-xs-12"><span>*</span> PLZ:</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" id="e_zip" value="" name="zip" class="text text-long col-sm-12 col-xs-12" onchange="ace()"  />
        <label class="error" style="display:none;" generated="true" id="guo_fon">Es scheint, dass es keine Ziffern in der PLZ gibt, überprüfen Sie sie bitte erneut.</label>
        <em style="display:block;">Bitte geben Sie Ihre Postleitzahl ein (oder 0000, wenn keine Postleitzahl in Ihrem Land erforderlich ist).</em>
					</div>
				</li>
				<li>
					<label class="col-sm-3 col-xs-12"><span>*</span> Telefon:</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" id="e_phone" value="" name="phone" class="text text-long col-sm-12 col-xs-12" />
						<p class="phone-tips">Bitte hinterlassen Sie eine richtige und vollständige Telefonnummer für pünktliche Lieferung von Postbote</p>
					</div>
				</li>
    <li id="e_cpf" class="hide">
        <label><span>*</span>o cadastro de pessoa Física:</label>
        <input type="text" name="cpf" class="text text_long" value="" />
    </li>
				<li>
					<label class="col-sm-3 xs-hidden">&nbsp;</label>
					<div class="col-sm-9 col-xs-12">
						<input id="default" class="radio" type="checkbox" value="1" name="default">
						<span for="default">Machen Sie dies als Ihre Standard Lieferadresse.</span>
					</div>
				</li>

			</ul>
			<div>
				<label class="col-sm-3 xs-hidden">&nbsp;</label>
				<div class="col-sm-9 col-xs-12">
					<input type="reset" value="ABBRECHEN" class="btn btn-default btn-sm" />
					<input type="submit" value="SPEICHERN & NEUE HINZUFÜGEN" class="btn btn-primary btn-sm" id="submitAdd" />
					<input type="submit" id="submitSave" value="SPEICHERN" class="btn btn-primary btn-sm" />
				</div>
			</div>
		</form>
	</div>
</div>
<script>
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
                required: "Bitte geben Sie Ihren Vornamen ein.",
                maxlength:"Ihren Vornamen überschreitet eine maximale Länge von 50 Zeichen."
            },
            lastname: {
                required: "Bitte geben Sie Ihren Nachnamen ein.",
                maxlength:"Ihren Nachnamen überschreitet eine maximale Länge von 50 Zeichen."
            },
            address: {
                required: "Bitte geben Sie Ihren Adresse ein.",
                rangelength: $.validator.format("Bitte geben Sie 3-100 Zeichen ein.")
            },
            zip: {
                required: "Bitte geben Sie Ihre Postleitzahl ein.",
                rangelength: $.validator.format("Bitte geben Sie 3-10 Zeichen ein.")
            },
            city: {
                required: "Bitte geben Sie Ihre Stadt ein.",
                maxlength:"Ihre Stadt überschreitet eine maximale Länge von 50 Zeichen."
            },
            country: {
                required: "Bitte wählen Sie Ihr Land.",
                maxlength:"Ihr Land überschreitet eine maximale Länge von 50 Zeichen."
            },
            state: {
                required: "Bitte geben Sie Ihren Bundesland / Provinz / Staat ein.",
                maxlength:"Ihren Bundesland überschreitet eine maximale Länge von 50 Zeichen."
            },
            phone: {
                required: "Bitte geben Sie Ihre Telefon ein.", 
                rangelength: $.validator.format("Bitte geben Sie eine Telefonnummer innerhalb von 6-20 Ziffern ein.")
            }
        }
    });


function ace2(acese)
{
    var addrs = acese.value;
    var re =  /@/;
    if(re.test(addrs))
    {
            $("#guo_con_2").show();
            $("#guo_con_2").html("Es scheint, dass Sie eine E-Mail-Adresse eingegeben haben, aber wir brauchen eine Lieferadresse.");   
    }
    else
    {
            $("#guo_con_2").hide(); 
            $("#guo_con_2").html(); 
    }
   var select = document.getElementById("e_country");
   var countryCode = select.options[select.selectedIndex].value;
        if(countryCode == 'HK' || countryCode == 'MO' || countryCode == 'TW')
        {   
            $("#guo111").show();
            $("#guo111").html('請輸入中文地址(Bitte geben Sie die Adresse auf Chinesisch ein.)');
        }else{
            $("#guo111").hide();
        }   
}
function acecoun(){
    var s = $("#e_state").val(); 
var re = /.*\d+.*/;
    if(re.test(s)){ 
            $("#guo_don").show();
            $("#guo_don").html('Bundesland / Provinz mit Ziffern? Bitte überprüfen Sie es noch einmal.');
        }else{
            $("#guo_don").hide();
        }   
}

function acedoun(){
    var s = $("#e_city").val(); 
var re = /.*\d+.*/;
    if(re.test(s)){ 
            $("#guo_eon").show();
            $("#guo_eon").html('Stadt / Ort mit Ziffern? Bitte überprüfen Sie es noch einmal.');
        }else{
            $("#guo_eon").hide();
        }   
}

function ace(){
    var s = $("#e_zip").val(); 
var re = /^[a-zA-Z]{3,10}$/;
        if(re.test(s)){     
        $("#guo_fon").show();
        $("#guo_fon").html("Es scheint, dass es keine Ziffern in der PLZ gibt, überprüfen Sie sie bitte erneut.");
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

        $(".edit_address").click(function(){

            var id = $(this).attr('title');		
			var len = parseInt($(document).width()) + parseInt(18);
			if(len <769){
				location.href = "/address/edit/"+id;
			}
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
            $("#edit_address .tit h2").text('IHRE ADRESSE EDITIEREN');
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
            $("#edit_address .tit h2").text('NEUE ADRESSE HINZUFÜGEN');
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
        if (!window.confirm('Sind Sie sicher, dass Sie diese Adresse löschen wollen? Es kann nicht rückgängig gemacht werden.'))
        {
            return false;
        }
        location.href = "<?php echo LANGPATH; ?>/address/delete/"+id;
    }
	
    $(".states1 .col-sm-9 .all1 select").change(function(){
                                var val = $(this).val();
                                $("#e_state").val(val);
                            })
	
</script>