<div id="container">
        <div class="icontainer">
                <div class="login">
                        <?php echo Message::get(); ?>
                        <h3><span><a>Newsletter</a></span></h3>
                        <p>Fill out the following form to join <?php echo Site::instance()->get('domain'); ?> mailing list and get the new arrivals, special offers and more as well as a 5% discount coupon for your next purchase. The information below marked with &quot;*&quot; is required. It is advised that you fill out the whole form, so that we can provide you with more customized information according to such information as your gender and occupation.</p>
                        <p class="color01">* Required Field</p>
                        <form id="newsLetter" method="post" action="" class="formArea fix">
                                <ul>
                                        <li>
                                                <label for="email" class="lblText"><span>*</span> Email:</label>
                                                <input type="text" name="email" id="email" class="allInput" value="<?php echo isset($email) ? $email : ''; ?>" maxlength="320"  />
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <label for="youremail"><span>*</span> Confirm Email:</label>
                                                <input type="text" name="youremail" id="youremail" class="allInput" value="" maxlength="320"   />
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <label for="firstname"> First Name:</label>
                                                <input type="text" name="firstname" id="firstname" class="allInput" value="" maxlength="250"   />
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <label for="lastname"> Last Name:</label>
                                                <input type="text" name="lastname" id="lastname" class="allInput" value="" maxlength="250"   />
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <label for="gender"> Gender:</label>
                                                <input type="radio" checked="checked" value="" name="female" />
                                                Female
                                                <input type="radio" value="" name="female" />
                                                Male
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <label for="occupation"> Occupation:</label>
                                                <select class="allSelect" name="occupation" id="occupation">
                                                        <option value="" selected="selected">- Select -</option>
                                                        <option value="Sales">Sales</option>
                                                        <option value="Teacher">Teacher</option>
                                                        <option value="Wife">Wife</option>
                                                        <option value="Other">Other</option>
                                                </select>
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <label for="birthday"> Birthday:</label>
                                                <input type="text" name="birthday" id="birthday" class="allInput hasDatepick" value="07/13/2010" maxlength="16" onclick='new WdatePicker({lang:"en",skin:"default",maxDate:(new Date().getMonth() + 1)+"/"+new Date().getDate()+"/"+new Date().getFullYear(),readOnly:true});' />
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <label for="country"> Country:</label>
                                                <select name="country" id="country" class="allSelect">
                                                        <?php foreach( $countries as $country ): ?>
                                                                <option value="<?php echo $country['isocode']; ?>" temp="<?php echo $country['isocode']; ?>"  ><?php echo $country['name']; ?></option>
                                                        <?php endforeach; ?>
                                                </select>
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <label for="zip"> Zip / Postal Code :</label>
                                                <input type="text" name="zip" id="zip" class="allInput" value="" maxlength="16"   />
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li class="actions">
                                                <label>&nbsp;</label>
                                                <input type="submit" value="Submit" name="submit" id="newsletterFormSubmit"  class="allbtn btn-submit" onmouseover="$(this).addClass('on')" onmouseout="$(this).removeClass('on')" />
                                        </li>
                                </ul>
                                <script type="text/javascript" src="/js/my97datepicker/wdatepicker.js"></script>
                                <script type="text/javascript">
                                        $("#newsLetter").validate($.extend(formSettings,{
                                                rules: {
                                                        email:{required: true,email: true},
                                                        youremail:{required: true,email: true,equalTo:"#email"}				
                                                }		
                                        }));
                                </script>
                        </form>
                </div>
        </div>
</div>
