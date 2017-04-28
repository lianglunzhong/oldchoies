<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  Change Password</div>
        </div>
        <?php echo message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Change Password</h2></div>
            <!-- Share This Product begin -->
            <form action="" method="post" class="form user_share_form user_form mlr70">
                <p class="font14">For the security of your account, we recommend that you choose a Password other than names, birthdays or street addresses that are associated with you.</p>
                <ul>
                    <li class="fix">
                        <label><span>*</span>Former Password:</label>
                        <div class="right_box">
                            <input type="text" name="oldpassword" value="" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label><span>*</span>New Password:</label>
                        <div class="right_box">
                            <input type="text" name="password" id="password" value="" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label><span>*</span>Confirm Password:</label>
                        <div class="right_box">
                            <input type="text" name="confirmpassword" value="" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label>&nbsp;</label>
                        <div class="right_box">
                            <input type="submit" name="" value="Change Password" class="view_btn btn26 btn40" />
                        </div>
                    </li>
                </ul>
            </form>
        </article>
        <?php echo View::factory('customer/left'); ?>
    </section>
</section>
<script type="text/javascript">
    /* user_share_form */
    $(".user_share_form").validate({
        rules: {
            oldpassword: {    
                required: true,
                minlength: 5,
                maxlength:20
            },
            password: {
                required: true,
                minlength: 5,
                maxlength:20
            },
            confirmpassword: {
                required: true,
                minlength: 5,
                maxlength:20,
                equalTo: "#password"
            }
        },
        messages: {
            oldpassword: {
                required: "Please provide a password.",
                minlength: "Your password must be at least 5 characters long.",
                maxlength:"The password exceeds maximum length of 20 characters."
            },
            password: {
                required: "Please provide a password.",
                minlength: "Your password must be at least 5 characters long.",
                maxlength:"The password exceeds maximum length of 20 characters."
            },
            confirmpassword: {
                required: "Please provide a password.",
                minlength: "Your password must be at least 5 characters long.",
                maxlength:"The password exceeds maximum length of 20 characters.",
                equalTo: "Please enter the same password as above."
            }
        }
    });
</script>
