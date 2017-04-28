<style type="text/css">
.errorInfo { margin:0 0 0 5px; color:red; font-size:11px; }
.errorInfo label { width:220px; padding-left:5px; text-align:left; }
.errorInfo .error { border:none; }
.errorInfo .error { font:  11px/23px Arial; color:#fc3030; padding-left:85px; width:100%; }
.btn-add-long {height: 40px;border: 0 none;}
.all-btn {cursor: pointer; display: inline-block; -webkit-appearance: none; background-color: #ff6666; text-align: center; text-transform: uppercase;}
.btn-add-long, a.btn-add-long:hover {width: 93%;color: #fff;font-size: 20px;font-weight: bold;line-height: 40px;}
.forgetpwd a{ color: #BE4040;}
</style>	

<div id="div-login">	
<h3>LOG IN</h3>
<form id="login" method="post" action="/mobilecustomer/login/<?php if( !empty($_GET['redirect'])) echo '?redirect='.htmlspecialchars($_GET['redirect']); ?>" class="add-address">
	<fieldset>
		<input type="hidden" name="referer" value="<?php echo $referer; ?>" />
		<ul>
			<li>
				<strong><label>Email:</label></strong>
        		<input type="text" name="email" id="email" value="" maxlength="320"   />
        		<div class="errorInfo"></div></li>
			<li>
				<strong><label>Password: </label></strong>
        		<input type="password" name="password" id="password1" value="" maxlength="16"   />
        		<div class="errorInfo"></div></li>
		
			<li><span class="forgetpwd"><a href="<?php echo LANGPATH; ?>/mobilecustomer/forgot_password">I forgot my password!</a></span></li><br/>
			<li><input name="" type="submit" value="Sign In" class="all-btn btn-add-long"></li>
		</ul>
		
		<script type="text/javascript">
             $("#login").validate($.extend(formSettings,{
                	rules: {
                        	email:{required: true,email: true},
                      		password: {required: true,minlength: 5}
                		}
          	}));
        </script>
   	</fieldset>
</form>
</div>

<div id="div-login">
<h3>I’M NEW TO CHOIES</h3>
<form id="register" method="post" action="/mobilecustomer/register/<?php if( ! empty($_GET['redirect'])) echo '?redirect='.htmlspecialchars($_GET['redirect']); ?>" class="add-address">
	<fieldset>
	<input type="hidden" name="referer" value="<?php echo $referer; ?>" />
	<ul>
		<li>
			<strong><label>Email: </label></strong>
            <?php
            $login_email = Session::instance()->get('login_email');
            Session::instance()->delete('login_email');
            ?>
            <input type="text" name="email" id="email" value="<?php echo $login_email; ?>" maxlength="320" autocomplete="off" />
            <div class="errorInfo"></div></li>
		<li>
			<strong><label>Password:</label></strong>
            <input type="password" name="password" id="password" value="" maxlength="16" autocomplete="off" />
          	<div class="errorInfo"></div></li>
		<li>
          	<strong><label>Confirm Password:</label></strong>
            <input type="password" name="confirmpassword" id="confirmpassword" value="" maxlength="16"   />
            <div class="errorInfo"></div></li>
        <li><input type="submit" value="REGISTER" class="all-btn btn-add-long"></li>
	</ul>
	
		<script type="text/javascript">
           $("#register").validate($.extend(formSettings,{
                rules: {			
                        email:{required: true,email: true},
                        password: {required: true,minlength: 5},
                        confirmpassword: {required: true,minlength: 5,equalTo: "#password"}
                 }
           }));
    	</script>
	</fieldset>
</form>
</div>









