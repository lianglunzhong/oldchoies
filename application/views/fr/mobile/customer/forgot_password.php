<div id="container">
 	<div class="icontainer">
      	<div class="myaccount">
         	<div class="login-s fix">
                   <?php echo Message::get(); ?>
                  
                   <h2><span><a>Forgot Password</a></span></h2>
                   <p>Please enter your email address below. We will send your original password to your email box. The process may take a little time because of the potential system delay. Thanks for your patience.</p>
                   <form id="findPwd" method="post" action="<?php echo URL::current(); ?>" class="formArea fix">
                      <ul>
                                                        <li>
                                                                <label for="email"><span>* </span> Your Email :</label>
                                                                <input type="text" name="email" id="email" class="allInput error" value="" maxlength="320" style="border:#DDD 1px solid;">
                                                                <div class="errorInfo"></div>
                                                        </li>
                                                        <li class="actions tar">
                                                                <label>&nbsp;</label>
                                                                <input type="submit" id="findPwdsubmit" name="submit" value="Find Password"  class="allbtn btn-btb" onmouseover="$(this).addClass('on')" onmouseout="$(this).removeClass('on')"  />
                                                        </li>
                                                </ul>
                                                <script type="text/javascript">
                                                        $("#findPwd").validate($.extend(formSettings,{
                                                                rules: {
                                                                        email:{required: true,email: true}
                                                                }
                                                        }));
                                                </script>
                                        </form>
                               

                        </div>
                </div>
        </div>
</div>