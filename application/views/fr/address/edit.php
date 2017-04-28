<div id="container">
        <div class=" fix">
                <div id="main">
                        <div class="crumb"><a href="<?php echo LANGPATH; ?>/" class="home">Accueil</a>&gt;<span class="current">Address Add</span></div>
                        <?php echo Message::get(); ?>
                        <div class="user">
                                <h3><span><a>Edit New Address</a></span></h3>
                                <p class="color01">* Required Field</p>
                                <form name="addAddress" id="addAddress" method="post" action="" class="formArea">
                                        <ul class="fix">
                                                <li>
                                                        <label for="firstname"><span>*</span> First Name:</label>
                                                        <input type="text" name="firstname" id="firstname" class="allInput" value="<?php echo $address['firstname']; ?>" maxlength="250"   />
                                                        <div class="errorInfo"></div>
                                                </li>
                                                <li>
                                                        <label for="lastname"><span>*</span> Last Name:</label>
                                                        <input type="text" name="lastname" id="lastname" class="allInput" value="<?php echo $address['lastname']; ?>" maxlength="250"   />
                                                        <div class="errorInfo"></div>
                                                </li>
                                                <li>
                                                        <label for="address"><span>*</span> Address:</label>
                                                        <input type="text" name="address" id="address" class="allInput" value="<?php echo $address['address']; ?>" maxlength="320"   />
                                                        <div class="errorInfo"></div>
                                                </li>
                                                <li>
                                                        <label for="city"><span>*</span> City / Twon:</label>
                                                        <input type="text" name="city" id="city" class="allInput" value="<?php echo $address['state']; ?>" maxlength="320"   />
                                                        <div class="errorInfo"></div>
                                                </li>
                                                <li>
                                                        <label for="state"><span>*</span> State / County:</label>
                                                        <input type="text" name="state" id="state" class="allInput" value="<?php echo $address['address']; ?>" maxlength="320"   />
                                                        <div class="errorInfo"></div>
                                                </li>
                                                <li >
                                                        <label for="country"><span>*</span> Country:</label>
                                                        <select id="country" name="country">
                                                                <?php foreach( $countries as $country ): ?>
                                                                        <option temp="244" value="<?php echo $country['isocode']; ?>" <?php echo $address['country'] == $country['isocode'] ? 'selected' : ''; ?>><?php echo $country['name']; ?></option>
                                                                <?php endforeach; ?>
                                                        </select>
                                                </li>
                                                <li>
                                                        <label for="zip"><span>* </span> Zip / Postal Code:</label>
                                                        <input type="text" name="zip" id="zip" class="allInput" value="<?php echo $address['zip']; ?>" maxlength="16"   />
                                                        <div class="errorInfo"></div>
                                                </li>
                                                <li >
                                                        <label for="phone"><span>* </span>Phone:</label>
                                                        <input type="text" name="phone" id="phone" class="allInput" value="<?php echo $address['phone']; ?>" maxlength="320"   />
                                                        <div class="errorInfo"></div>
                                                </li>
                                                <li>
                                                        <label>&nbsp;</label>
                                                        <input type="submit"  class="allbtn btn-submit" onmouseover="$(this).addClass('on')" onmouseout="$(this).removeClass('on')" value="Submit" name="submit"  id="modifySubmit" />
                                                </li>
                                        </ul>
                                        <script type="text/javascript">
                                                $("#addAddress").validate($.extend(formSettings,{
                                                        rules: {
                                                                firstname: "required",
                                                                lastname: "required",

                                                                zip:  "required",
                                                                address: "required",
                                                                city: "required",
                                                                state: "required",
                                                                country: "required",
                                                                phone:  "required"
                                                        }
                                                }));
                                        </script>
                                </form>
                        </div>
                </div>
                <?php echo View::factory(LANGPATH . '/customer/left'); ?>
        </div>
</div>