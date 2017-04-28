<form method="post" action="#" id="account-settings" name="userPassword">
	<fieldset>
	<p>For the security of your account, we recommend that you choose a Password other than names, 
		birthdays or street addresses that are associated with you.</p>
	<?php echo Message::get(); ?>
	<div class="edit-form ">
		<ul>
          	<li>
             	<label for="password"><span>*</span> Former Password:</label>
             	<input type="password" name="oldpassword" id="oldpassword" class="allInput" value="" maxlength="320"   />
                <div class="errorInfo"></div></li>
           	<li>
                <label for="password"><span>*</span> New Password:</label>
                <input type="password" name="password" id="password" class="allInput" value="" maxlength="320"   />
                <div class="errorInfo"></div></li>
         	<li>
                <label for="confirmpassword"><span>*</span> Confirm Password:</label>
                <input type="password" name="confirmpassword" id="confirmpassword" class="allInput" value="" maxlength="320"   />
                <div class="errorInfo"></div></li>
          	<li>
                <label>&nbsp;</label>
                <input type="submit"  class="allbtn btn-submit" onmouseover="$(this).addClass('on')" onmouseout="$(this).removeClass('on')" value="Change" name="submit" id="passwordSubmit"/>
            </li>
   		</ul>
   		
        <script type="text/javascript">
        $("#account-settings").validate($.extend(formSettings,{
                         	rules: {
                            		oldpassword: {required: true,minlength: 5},
                                    password: {required: true,minlength: 5},
                                    confirmpassword: {required: true,minlength: 5,equalTo: "#password"}
                            }
          }));
      	</script>
	</div>
	
	</fieldset>
</form>
			