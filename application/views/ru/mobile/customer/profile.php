<p id="crumbs"><a href="<?php echo LANGPATH; ?>/">Home</a> /My Account</p>
<h3><strong>My Account</strong></h3>
<?php echo Message::get(); ?>
 	
<form action="" id="account-settings" method="post">
		<fieldset>
<!--			<legend><strong>Account Settings</strong></legend>-->
			<!--<ul>
				<li><strong>Email:&nbsp;</strong><?php echo $customer['email']; ?></li>
				<li><strong>Password:&nbsp;</strong>******</li>
			</ul>-->
			
<!--			<a href="#" class="edit-account myaccountsprite btn-edit-account show">Edit Account Settings</a>-->
			<div class="edit-form ">
				<ul>
                   	<li>
                        <label for="email">Email :</label><?php echo $customer['email']; ?></li>
                    <li>
                       	<label for="firstname">First Name :</label>
                        <input type="text" name="firstname" class="allInput" id="firstname" value="<?php echo $customer['firstname']; ?>" />
                        <div class="errorInfo"></div></li> 
                                                        
                    <li>
                        <label for="lastname">Last Name :</label>
                       	<input type="text" name="lastname" class="allInput" id="lastname" value="<?php echo $customer['lastname']; ?>" />
                        <div class="errorInfo"></div></li> 
                                                        
                    <li>
                        <label for="country">Country :</label>
                        <select name="country" id="country">
                        <?php
                        $countries = Site::instance()->countries(LANGUAGE);
                        foreach ($countries as $country):
                           ?>
                           <option value="<?php echo $country['isocode']; ?>" <?php if($customer['country'] == $country['isocode']) echo 'selected'; ?>><?php echo $country['name']; ?></option>
                           <?php
                        endforeach;
                        ?>
                        </select>
                        <div class="errorInfo"></div></li>
                                                        
                 	<li>
                        <label for="birthday">Gender :</label>
                        <input type="radio" name="gender" value="0" <?php if($customer['gender'] == 0) echo 'checked'; ?> class="mr5"/>Female&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="gender" value="1" <?php if($customer['gender'] == 1) echo 'checked'; ?> class="mr5"/>Male</li>
                                                        
                    <li>
                        <script type="text/javascript" src="/js/my97datepicker/wdatepicker.js"></script>
                        <label for="birthday">Birthday :</label>
                        <input type="text" name="birthday" id="birthday" class="allInput hasDatepick" value="<?php echo $customer['birthday'] ? date('Y-m-d', $customer['birthday']) : ''; ?>" maxlength="16" onclick='new WdatePicker({lang:"en",skin:"default",dateFmt:"yyyy-MM-dd",maxDate:(new Date().getFullYear()+"-"+new Date().getMonth() + 1)+"-"+new Date().getDate()+"-",readOnly:true});' />
                    </li>
                    
                    <li><input type="submit" class="myaccountsprite btn-save" onmouseover="$(this).addClass('on')" onmouseout="$(this).removeClass('on')" value="EDIT" name="submit" id="">
                </ul>
<!--				<a href="#" class="cancel show">Cancel</a>-->
			</div>
		</fieldset>
</form>
	
<script type="text/javascript">
$("document").ready(function(){
	$('.show').click(function(){
				$(".edit-form").toggle(20);
	})
});

$("#account-settings").validate($.extend(formSettings,{
    rules: {
            firstname:"required",
            lastname:"required",			
            email:{required: true,email: true}
    }
}));
</script>
	
	
