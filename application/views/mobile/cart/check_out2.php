<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/jquery.validate.js"></script>
<style>
#billingSubmit {border: none; height: 46px; width: 300px; display: block; white-space: nowrap; overflow: hidden; background: #ff887c; 
		font-size: 19px; text-transform: uppercase; color: #fff; -webkit-appearance: button; line-height: 46px; margin: 10px;}

/*		
.codelist_con{ width:180px; border:2px solid #ccc; background-color:#fff; position:absolute; top:19px; left:258px;}
.codelist_con .close_btn{ position:absolute; top:5px; right:5px; background:url(../images/icon_close.png) no-repeat 0 -2px; display:inline-block; width:10px; height:10px; cursor:pointer;}
.codelist_con .tit{ background-color:#f3f3f3; height:22px; line-height:22px;}
.codelist_con .tit h3{ margin-left:5px; font-weight:bold; text-transform:uppercase; color:#999;}
.codelist_con .list_con li a{ height:24px; line-height:24px; display:block; padding-left:5px;}
.codelist_con .list_con li a:hover{ background-color:#f99393; color:#fff;}
.codenone{ text-align:center; padding:15px 0;}
*/

</style>

<div id="checkout">
<div id="step">
	<h2 class="step-title">SHIPPING ADDRESSES</h2><?php echo Message::get(); ?>
</div>


<?php $has_address = isset($cart['shipping_address']) AND !empty($cart['shipping_address']) ? 1 : 0; ?>
<div class="addresses" id="addresses" <?php if($has_address) echo ' style="display:none;"' ?>>
	<?php foreach ($addresses as $key => $value):  ?>
	<div class="saved-address" >
		<form action="/mobilecart/edit_address" method="POST" class="selectAddress">
			<input type="hidden" name="shipping_address_id" value="<?php echo $value['id']; ?>" />
			<ul>
				<li><?php echo $value['firstname'] . ' ' . $value['lastname']; ?></li>
				<li><?php echo $value['address']; ?></li>
				<li><?php echo $value['city'] . ' ' . $value['state'] . ' ' . $value['zip']; ?></li>
				<li class="cntry"><?php echo $value['country']; ?></li>
			</ul>
			<input type="submit" class="selectShipmentOption boxed button" value="Ship to this Address" >
		</form>

		<div class="editAddress">
			<a class="edit_address button gray" id="<?php echo $value['id']; ?>">Edit Address</a>
			<div class="hide" id="catalog_link"><iframe id="cart_address" style="border: none;" width="500px" height="400px" src=""></iframe></div>
		</div><br/>
		
		<div class="deleteAddress">
			<a class="delete_address button gray" href="#" id="<?php echo $value['id']; ?>" >Delete</a>
		</div>
	</div>
	<?php endforeach;?>		
	
	
	<div class="hide" id="cart_delete" style="position: fixed;padding: 10px 10px 20px; top: 170px;left: 400px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border:1px solid #cdcdcd;">
        <div style="font-size: 1.4em;margin-top:0px;border-bottom: 2px solid #F4F4F4;">CONFIRM ACTION</div>
        <div class="order order_addtobag" style="margin:20px;">
                <div style="font-size:13px;margin-bottom: 20px;">Are you sure you want to delete this? It cannot be undone.</div>
                <form action="/mobilecart/delete_address" method="post">
                <input type="hidden" name="address_id" id="address_id" value="" />
                <input type="submit" class="allbtn btn-apply" value="DELETE" />
                <a href="#" class="cancel" style="text-decoration:underline;margin-left:10px;">Cancel</a>
                </form>
        </div>
        <div class="clsbtn" style="right: -0px;top: 3px;"></div>
	</div>
	
	
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
            $("#state").val('');
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
 	</script>			
				
	<form id="shippingAddress" method="post" action="/mobilecart/edit_address" class="formArea">
       	<div class="step2_tit">Add A New Address</div>
        <input type="hidden" name="shipping_address_id" value="new" />
        <ul id="newAddress" class="shipping_adress">
                                <li>
                                        <label for="firstname"><span>*</span> First Name:</label>
                                        <input type="text" name="shipping_firstname" id="firstname" class="allInput" value="" maxlength="16" onblur="$('#firstname').val($(this).val());" />
                                        <div class="errorInfo"></div>
                                </li>
                                <li>
                                        <label for="lastname"><span>*</span> Last Name:</label>
                                        <input type="text" name="shipping_lastname" id="lastname" class="allInput" value="" maxlength="16" onblur="$('#lastname').val($(this).val());" />
                                        <div class="errorInfo"></div>
                                </li>
                                <li>
                                        <label for="address"><span>*</span> Address:</label>
                                        <input type="text" name="shipping_address" id="address" class="allInput" value="" maxlength="320" onblur="$('#address').val($(this).val());" />
                                        <div class="errorInfo"></div>
                                </li>
                                <li>
                                        <label for="country"><span>*</span> Country:</label>
                                        <select name="shipping_country" id="country" class="allSelect" onchange="changeSelectCountry();$('#country').val($(this).val());return getCarrier($(this).val());">
                                                <option value="">-Select-</option>
                                                <?php foreach ($countries as $country): ?>
                                                        <option value="<?php echo $country['isocode']; ?>"><?php echo $country['name']; ?></option>
                                                <?php endforeach; ?>
                                        </select>
                                        <div class="errorInfo"></div>
                                </li>
                                <li class="states clear">
                                        <?php
                                        $stateCalled = Kohana::config('state.called');
                                        foreach ($stateCalled as $name => $called)
                                        {
                                                ?>
                                                <div class="call" id="call_<?php echo $name; ?>" <?php if ($name != 'Default') echo 'style="display:none;"'; ?>>
                                                        <label for="state" style="float:left;"><span>*</span> <font id="state_name"><?php echo $called; ?></font>:</label>
                                                </div>
                                                <?php
                                        }
                                        $stateArr = Kohana::config('state.states');
                                        foreach ($stateArr as $country => $states)
                                        {
                                                ?>
                                                <div class="all" id="all_<?php echo $country; ?>" style="display:none;">
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
                                        <div class="all" id="all_default">
                                                <input type="text" name="shipping_state" id="state" class="allInput" value="" maxlength="320" />
                                                <div class="errorInfo"></div>
                                        </div>
                                </li>
                                <li>
                                        <label for="city"><span>*</span> City / Town:</label>
                                        <input type="text" name="shipping_city" id="city" class="allInput" value="" maxlength="320" onblur="$('#city').val($(this).val());" />
                                        <div class="errorInfo"></div>
                                </li>
                                <li>
                                        <label for="zip"><span>*</span> Zip / Postal Code:</label>
                                        <input type="text" name="shipping_zip" id="zip" class="allInput" value="" maxlength="16" onblur="$('#zip').val($(this).val());"  />
                                        <div class="errorInfo"></div>
                                </li>
                                <li>
                                        <label for="phone"><span>*</span> Phone:</label>
                                        <input type="text" name="shipping_phone" id="phone" class="allInput" value="<?php echo $defaultAdd['phone']; ?>" maxlength="320"  onblur="$('#phone').val($(this).val());" />
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
                                                $("#state").val('');
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
                                </script>
                        </ul>
                        <?php
                        foreach ($carriers as $key => $carrier):
                                ?>
                                <input type="hidden" name="shipping_method" value="<?php echo $carrier['id']; ?>" />
                                <?php
                                break;
                        endforeach;
        		?>
      	<input type="submit"  class="btn-shipto" value="SAVE AND SHIP TO THIS ADDRESS" >
  	</form>
	
	
	
	
</div>

<?php if($has_address){ ?>
<div id="shippingTo" style="">
	<h2>SHIPPING ADDRESS</h2>
	<a href="#" id="addressEdit" class="btn-edit">Edit</a>
	<div id="shippingToInfo">
		<ul>
			<li><?php echo $cart['shipping_address']['shipping_firstname'] . ' ' . $cart['shipping_address']['shipping_lastname']; ?></li>
			<li><?php echo $cart['shipping_address']['shipping_address']; ?></li>
			<li><?php echo $cart['shipping_address']['shipping_city'] . ' ' . $cart['shipping_address']['shipping_state'] . ' ' . $cart['shipping_address']['shipping_zip']; ?></li>
			<li><?php echo $cart['shipping_address']['shipping_country']; ?></li>
		</ul>
	</div>
</div>



<div class="payment" id="shpping" style="display: block;" data-step="'payment'">
<h3>PAYMENT</h3>	
	<div class="totalPaymentOptions">
		<div class="message cc" style="display: none;">Please enter a valid credit card and security code.</div>			
		<div id="savedPaymentOptions" style="display: none;"></div>
	</div>

<form id="payment_method" method="post" action="" class="formArea" style="min-height:190px;height:auto;">
	<div class="totalPaymentOptions">
		<div class="step2_tit"><b>Choose Your Payment</b></div><br/>
     	<input type="radio" checked onclick="$('#ccDiv').hide();" value="PP" id="radio2" class="payment_method" name="payment_method" />
     	<img src="/images/mobile/checkout-paypal.jpg" alt="" style="vertical-align:middle;" /><br /><br />
        <input type="radio" onclick="$('#ccDiv').show();" value="GLOBEBILL" id="radio1" class="payment_method" name="payment_method" />
        <img src="/images/mobile/checkout-cards.jpg" alt="" style="vertical-align:middle;" />

		<?php
        if (Site::instance()->get('is_pay_insite'))
        {
          	?>
            <div class="mt10 fix">
             	<div id="billing" style="display: none;">
                	<div class="step2_tit"><b>Billing Address:</b></div>
                    <input type="radio" name="billing_method" id="radio_changeaddr1" value="1" checked />
                    Send the Bill to my Shipping Address<br />
                   	<input type="radio" name="billing_method" id="radio_changeaddr2" value="2" />
                    Send the Bill to Another Address 
                   	<ul id="billingAddress" style="display:none;">
                   		<li>
                          	<label for="billing_firstname"><span class="strong1">*</span> First Name :</label>
                            <input type="text" name="billing_firstname" id="billing_firstname" class="allInput" value="" maxlength="250"   />
                            <div class="errorInfo"></div></li>
                        <li>
                            <label for="billing_lastname"><span class="strong1">*</span> Last Name :</label>
                            <input type="text" name="billing_lastname" id="billing_lastname" class="allInput" value="" maxlength="250"   />
                            <div class="errorInfo"></div></li>
                       	<li>
                            <label for="billing_address"><span class="strong1">*</span> Address :</label>
                            <input type="text" name="billing_address" id="billing_address" class="allInput" value="" maxlength="320"   />
                            <div class="errorInfo"></div></li>
                      	<li>
                            <label for="billing_country"><span class="strong1">*</span> Country :</label>
                           	<select name="billing_country" id="billing_country" class="allSelect" onchange="changeSelectCountry1();$('#billing_country').val($(this).val());">
	                            <option value="">SELECT A COUNTRY</option>
	                            <?php foreach ($countries as $country): ?>
	                            <option value="<?php echo $country['isocode']; ?>" ><?php echo $country['name']; ?></option>
                                <?php endforeach; ?>
                           	</select>
                            <div class="errorInfo"></div></li>
                                                        
                      	<li class="states1 clear">
                        <?php
                        $stateCalled = Kohana::config('state.called');
                        foreach ($stateCalled as $name => $called)
                       	{
                        	?>
                            <div class="call1" id="call1_<?php echo $name; ?>" <?php if ($name != 'Default') echo 'style="display:none;"'; ?>>
                            	<label for="state " style="float:left;"><span>*</span> <font id="state_name1"><?php echo $called; ?></font>:</label>
                            </div>
                            <?php
                       	}
                        $stateArr = Kohana::config('state.states');
                        foreach ($stateArr as $country => $states)
                        {
                       		?>
                            <div class="all1" id="all1_<?php echo $country; ?>" style="display:none;">
                           	<select name="" id="billing_state1" class="allSelect" onblur="$('#billing_state1').val($(this).val());">
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
                                            <option value="<?php echo $s; ?>"><?php echo $s; ?></option> <?php
                                        }
                                        echo '</optgroup>';
                                        
                                   	}else {  ?>
                                        <option value="<?php echo $state; ?>"><?php echo $state; ?></option> <?php
                                   	}
                             	} ?>
                      		</select>
                            </div><?php
                       	}    ?>
                       	<div class="all1" id="all1_default">
                        	<input type="text" name="billing_state" id="billing_state" class="allInput" value="" maxlength="320" onblur="$('#billing_state').val($(this).val());" />
                         	<div class="errorInfo"></div>
                        </div>
                        <script>
                        function changeSelectCountry1(){
                        		var select = document.getElementById("billing_country");
                                var countryCode = select.options[select.selectedIndex].value;
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
                                                               	$("#billing_state").val(val);
                                        })
                                })
                   		}
                    	</script>
                   		</li>
                   		
                        <li>
                         	<label for="billing_city"><span class="strong1">*</span> Town/City:</label>
                            <input type="text" name="billing_city" id="billing_city" class="allInput" value="" maxlength="320"   />
                            <div class="errorInfo"></div></li>
                        <li>
                            <label for="billing_zip"><span class="strong1">* </span> Postcode/Zip Code</label>
                            <input type="text" name="billing_zip" id="billing_zip" class="allInput" value="" maxlength="320"   />
                            <div class="errorInfo"></div></li>
                      	<li>
                            <label for="billing_phone"><span class="strong1">*</span> Phone1 :</label>
                           	<input type="text" name="billing_phone" id="billing_phone" class="allInput" value="" maxlength="320"   />
                            <div class="errorInfo"></div></li>
                   	</ul>
              	</div>
          	</div><?php
     	}
        ?>
<!--        <input type="submit" value="PROCEED TO CHECKOUT" class="form_btn2 fll mb10" id="billingSubmit" />-->
        <div class="mt10 clear"><input type="submit" value="PROCEED TO CHECKOUT" class="form_btn2 fll mb10 " id="billingSubmit" style="display: block;"></div>
	</div>
</form>
<?php }?>


<dl class="pink border order-summary enhance clear">
	<dt class="active-dt"><a href="#">Order Summary</a></dt>
	<dd data-height="371" class="active" style="height: auto;">
		<div id="cart-full">
		<?php foreach ($cart['products'] as $key => $product): ?>
        	<div class="product row">
				<div class="mobile-one">
					<img src="<?php echo image::link(Product::instance($product['id'])->cover_image(), 3); ?>" alt="">
				</div>
       			<div class="mobile-three">
					<h2><?php echo Product::instance($product['id'])->get('name'); ?></h2>
					<span class="style"></span>
					<span class="inventory"></span>
					
					<ul>
						<li><?php echo Site::instance()->price($product['price'], 'code_view'); ?></li>
						<?php
                        if(isset($product['attributes']) AND is_array($product['attributes']))
                        {
                           	foreach ($product['attributes'] as $name => $attribute)
                           	{
	                            if ($name == 'delivery time')
	                            {
	                                 if ($attribute > 0)
	                                      $attribute = 'rush order';
	                                 else
	                                      $attribute = 'regular order';
	                           	}
                            	echo '<li>'.$name . ': ' . $attribute . ';</li>';
                           	}
                       	}
                       	?>
						<li>Quantity: <?php echo $product['quantity']; ?></li>
					</ul>
				</div>
			</div>
		<?php endforeach; ?> 
						
		<table class="cost-summary" cellspacing="0"><tbody>
			<tr><td>Subtotal: </td>
				<td class="text-right"><?php echo Site::instance()->price($cart['amount']['items'], 'code_view'); ?></td></tr>
			<tr><td>Estimated Shipping: </td>
				<td class="text-right">
                <?php  if ($cart['shipping_address'])
                            $shipping_price = $cart['amount']['shipping'];
                       else
                           	$shipping_price = Session::instance()->get('shipping_price', 0);
                       echo Site::instance()->price($shipping_price, 'code_view'); ?>
                </td></tr>
            <?php 
            if ($cart['amount']['save'])
            { 
                    foreach ($cart['promotion_logs']['cart'] as $p_cart)
                   	{
                    	if ($p_cart['save'])
                        {
                          	$p_name = explode(':', $p_cart['log']);
                            echo '<li><span>"' . $p_name[0] . '" Save : </span>-' . Site::instance()->price($p_cart['save'], 'code_view') . '</li>';
                       	}
                 	}
                	if ($cart['amount']['coupon_save'] > 0){  ?>
                          <tr><td>Coupon Code: </td> 
                          <td class="text-right"> - <?php echo Site::instance()->price($cart['amount']['coupon_save'], 'code_view'); ?></td></tr><?php
                	}
            }
            if ($cart['amount']['point'] > 0)
            {  ?>
                  <tr><td>Pay with Points:</td> 
                  <td class="text-right">  - <?php echo Site::instance()->price($cart['amount']['point'], 'code_view'); ?></td></tr><?php
           	} ?>
                                        
			<tr class="estimated-total">
				<td><strong>Total: </strong></td>
				<td class="text-right">
				<?php echo Site::instance()->price($cart['amount']['total'] - $cart['amount']['shipping'] + $shipping_price, 'code_view');?></td></tr></tbody>
		</table>
			
		</div>
	</dd>
</dl>

<div class="step_point mt10 mb10">
        <div class="step2_tit">
                USE YOUR POINTS(10 points=$0.1)<br/>
                <span style="font-size:12px;">
                        <?php echo $points_avail >= 0 ? '<strong class="red">' . $points_avail . '</strong> points can be used for this time.' : 'To use your points, please shop at least $10+.' ?>
                        <a href="<?php echo LANGPATH; ?>/mobile/doc/vip-policy" target="_blank" style="text-decoration:underline;">VIP Policy</a>
                </span>
        </div>
        <form id="point_form" action="/mobilecart/point" method="POST" class="mt5">
                <input type="hidden" name="shipping" value="1" />
                <div>
                        <span><input name="points" type="text" class="allInput fll" id="point" maxlength="22" onkeydown="return point2dollar();" /></span>
                        <span class="mt5">Points = $</span>
                        <span><input name="dollar" type="text" class="allInput" id="dollar" maxlength="22" readonly="readonly" /></span>
                        <span>
                                <input type="submit" value="REDEEM" class="allbtn btn-apply ml10" onclick="return point_redeem();" />
                        </span>
                </div>
        </form>
        <div class="leftPoints clear pt10">
                <span class="ship_cost_tip">
                        <span>
                                <a href="#">HELP</a>
                        </span>
                        <span class="ship_cost_tip_con">
                                <b>How to Get Points</b><span class="close flr" style="font-size:14px;">x</span>
                                <br />
                                -Participate our activities on facebook, fanshion blogs to get Giveaway points(1000-10000 points each activity)
                                <br />
                                -Give us your valuable reviews after getting your items. 10 points every time!
                                <br />
                                -Any good ideas to Choies, send emails to us (100-1000 points each time)
                                <br />
                                <b>How to Use Points</b>
                                <br />
                                -Use them as money. 10 points=$0.1
                                <br />
                                -Please add the points at the checkout.
                        </span> 
                </span>
                <span class="step2_tit" style="font-size:12px;">
                        $<span id="amount_left"><?php echo round($cart['amount']['total'], 2); ?></span>
                        <span id="point_left"></span> Left for you to pay
                </span>
        </div>
        <script type="text/javascript">
        $(function(){
                $('.ship_cost_tip a').click(function(){
                        $('.ship_cost_tip_con').show();
                        return false;
                })
                $('.ship_cost_tip_con .close').click(function(){
                        $('.ship_cost_tip_con').hide();
                        return false;
                })
        })
        </script>
        <script type="text/javascript">
                var xhr = null;
                var amount_left = $('#amount_left').text();
                                
                function point_redeem()
                {
                        var points = parseFloat(document.getElementById('point').value);
                        if (points > <?php print $points_avail; ?>) {
                                window.alert('Not enough points available');
                                return false;
                        }
                        else
                        {
                                $('#point_form').submit();
                                return false;
                        }
                }
                                
                function point2dollar()
                {
                        var point = document.getElementById('point');
                        var dollar = document.getElementById('dollar');
                                        
                        return window.setTimeout(function(){
                                if (!point.value) {
                                        dollar.value = '';
                                        $('#amount_left').text(tofloat(amount_left,2));
                                        $('#point_left').text('');
                                        return true;
                                }
                                                
                                if (xhr)
                                        xhr.abort();
                                                
                                var point_left = tofloat(parseInt(point.value)*0.01, 2);
                                $('#point_left').text(' - $'+point_left);
                                dollar.value = point_left;
                        }, 0);
                }
        </script>
</div>
<?php if(!$cart['coupon']): ?>
<div id="promo">
	<form id="discount_form" action="/mobilecart/set_coupon" method="post">
		<input name="return_url" type="hidden" value="/mobilecart/check_out" />
	
		<label for="fulfillmentSystemCode1">Enter Coupon Code: </label>
		<input name="coupon_code" type="text" class="codeInput">
		<input id="apply" name="apply" type="submit" value="APPLY" class="btn-apply" onmouseover="$(this).addClass('on')" onsmouseout="$(this).removeClass('on')">
		
		
		
	</form>
	
	<a class="codelist J_pop_btn">Code list</a>
	<div class="codelist_con J_popcon hide">
      	<span class="close_btn"></span>
        <div class="tit"><h3>Available Codes</h3></div>
        <?php
        if(count($codes) > 0):
                echo '<ul class="list_con">';
                foreach($codes as $code):
      	?>
            		<li><a href="#"><?php echo $code['code']; ?></a></li>
                	<?php
                endforeach;
                echo '</ul>';
      	else:
        ?>
                <div class="codenone">No Available Codes.</div> 
      	<?php endif; ?>
  	</div>
  								<script type="text/javascript">
                                        $(function(){
                                                $('.J_pop_btn').click(function(){
                                                        $(this).parents().find('.J_popcon').slideDown();
                                                }),$(".close_btn").click(function(){
                                                        $(this).parents().find('.J_popcon').hide();
                                                })
                                                
                                                $(".list_con a").click(function(){
                                                        var code = $(this).html();
                                                        $(".codeInput").val(code);
                                                        $(".codelist_con").hide();
                                                        return false;
                                                })
                                        })
                                </script>
</div>
<?php endif; ?>


</div>
<script type="text/javascript">
        $("document").ready(function(){
                $("#shippingAddress").bind("submit",function(){
                    $("#shippingAddress").validate();
                    $("#firstname").rules("add",{required: true});
                    $("#lastname").rules("add",{required: true});
                    $("#zip").rules("add",{required: true});
                    $("#address").rules("add",{required: true});
                    $("#city").rules("add",{required: true});
                    $("#state").rules("add",{required: true});
                    $("#country").rules("add",{required: true});
                    $("#phone").rules("add",{required: true});
                    var select = document.getElementById("country");
                    var countryCode = select.options[select.selectedIndex].value;
                    if(countryCode=="BR")
                    {
                            $("#cpf").rules("add",{required: true,minlength: 11,maxlength: 12})
                    }
                    else
                    {
                            $("#cpf").rules("add",{required: false})
                    }
                    var valid = $("#shippingAddress").valid();
                    if (valid==true) {this.submit();}
                    return false;
            });
                
                $('#radio1').click(function(){
                        $('#billing').attr('style', 'display: block;');
                        $('#radio_changeaddr1').attr('checked', 'checked');
                        $('#billingAddress').css('display', 'none');
                        $("#billing_firstname").val($('#firstname').attr('value'));
                        $("#billing_lastname").val($('#lastname').attr('value'));
                        $("#billing_zip").val($('#zip').attr('value'));
                        $("#billing_address").val($('#address').attr('value'));
                        $("#billing_city").val($('#city').attr('value'));
                        $("#billing_state").val($('#state').attr('value'));
                        $("#billing_country").val($('#country').attr('value'));
                        $("#billing_phone").val($('#phone').attr('value'));
                })
                $('#radio2').click(function(){
                        $('#billing').attr('style', 'display: none;');
                })
                
                $("#radio_changeaddr1").click(function(){
                        $('#billingAddress').css('display', 'none');
                })
                
                $("#radio_changeaddr2").click(function(){
                        $('#billingAddress').css('display', 'block');                        
                })
                
                $("#billingSubmit").click(function(){
                        if($("#radio_changeaddr2").attr("checked") == true)
                        {
                                $("#payment_method").validate();
                                $("#billing_firstname").rules("add",{required: true});
                                $("#billing_lastname").rules("add",{required: true});
                                $("#billing_zip").rules("add",{required: true});
                                $("#billing_address").rules("add",{required: true});
                                $("#billing_city").rules("add",{required: true});
                                $("#billing_state").rules("add",{required: true});
                                $("#billing_country").rules("add",{required: true});
                                $("#billing_phone").rules("add",{required: true});
                                var select = document.getElementById("billing_country");
                                var countryCode = select.options[select.selectedIndex].value;
                                var valid = $("#payment_method").valid();
                                
                                if (valid==true) {$("#payment_method").submit();}
                        }
                        else
                        {
                                $("#payment_method").validate();
                                $("#billing_firstname").rules("add",{required: false});
                                $("#billing_lastname").rules("add",{required: false});
                                $("#billing_zip").rules("add",{required: false});
                                $("#billing_address").rules("add",{required: false});
                                $("#billing_city").rules("add",{required: false});
                                $("#billing_state").rules("add",{required: false});
                                $("#billing_state1").rules("add",{required: false});
                                $("#billing_country").rules("add",{required: false});
                                $("#billing_phone").rules("add",{required: false});
                                $("#payment_method").submit();
                        }
                        return false;
                })
        });
        
        $(function(){
                $(".edit_address").live("click",function(){
                        $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                        $('#catalog_link').appendTo('body').fadeIn(320);
                        var id = $(this).attr('id');
                        $('#cart_address').attr('src', '/cart/edit_address/'+id)
                        $('#catalog_link').show();
                        return false;
                })
                
                $("#catalog_link .clsbtn,#wingray").live("click",function(){
                        $("#wingray").remove();
                        $('#catalog_link').fadeOut(160).appendTo('#tab2');
                        return false;
                })
                
                $(".delete_address").live("click", function(){
                        $('body').append('<div id="wingray1" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                        $('#cart_delete').appendTo('body').fadeIn(320);
                        var id = $(this).attr('id');
                        $("#address_id").val(id);
                        $('#cart_delete').show();
                        return false;
                })
                
                $("#cart_delete .clsbtn,#cart_delete .cancel,#wingray1").live("click",function(){
                        $("#wingray1").remove();
                        $('#cart_delete').fadeOut(160).appendTo('#tab2');
                        return false;
                })
                
                $("#addressEdit").live("click", function(){
                        $("#shpping").hide();
                        $("#addresses").show();
                })
        })
        
        function tofloat(f,dec)       
        {          
                if(dec <0) return "Error:dec <0! ";          
                result=parseInt(f)+(dec==0? " ": ".");          
                f-=parseInt(f);          
                if(f==0)
                {
                        for(i=0;i <dec;i++) result+= '0';          
                }
                else       
                {          
                        for(i=0;i <dec;i++)
                        {
                                f*=10;
                                if(parseInt(f) == 0)
                                {
                                        result+= '0';
                                }
                        }          
                        result+=parseInt(Math.round(f));
                } 
                return result;          
        }
</script>
 
 