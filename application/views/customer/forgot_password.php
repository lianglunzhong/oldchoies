<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  Forgot Password</div>
        </div>
        <?php echo message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Forgot Password</h2></div>
            <!-- Share This Product begin -->
            <form action="/customer/forgot_password" method="post" class="form user_share_form user_form mlr70">
                <p class="font14">Please enter your email address below. We will send your original password to your email box. The process may take a little time because of the potential system delay. Thanks for your patience.</p>
                <ul>
                    <li class="fix">
                        <label style="width:100px;"><span>*</span>Your Email:</label>
                        <div class="right_box">
                            <input type="text" name="email" value="" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label style="width:100px;">&nbsp;</label>
                        <div class="right_box">
                            <input type="submit" name="" value="Submit" class="view_btn btn26 btn40" />
                        </div>
                    </li>
                </ul>
            </form>
        </article>
    </section>
</section>
<script type="text/javascript">
    /* user_share_form */
    $(".user_share_form").validate({
        rules: {
            email: {    
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required:"Please provide an email.",
                email:"Please enter a valid email address."
            }
        }
    });
</script>
