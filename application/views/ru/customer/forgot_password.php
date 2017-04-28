<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Home</a>  >  Вспомнить пароль</div>
        </div>
        <?php echo message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Вспомнить пароль</h2></div>
            <!-- Share This Product begin -->
            <form action="<?php echo LANGPATH; ?>/customer/forgot_password" method="post" class="form user_share_form user_form mlr70">
                <p class="font14">Пожалуйста, введите ваш адрес электронной почты ниже. Мы вышлем ваш оригинальный пароль на ваш электронный ящик. Процесс может занять немного времени, так как потенциал системы задержки. Спасибо за ваше терпение.</p>
                <ul>
                    <li class="fix">
                        <label style="width:100px;"><span>*</span>Ваша электронная почта:</label>
                        <div class="right_box">
                            <input type="text" name="email" value="" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label style="width:100px;">&nbsp;</label>
                        <div class="right_box">
                            <input type="submit" name="" value="Дальше" class="view_btn btn26 btn40" />
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
                required:"Введите адрес вашей электронной почты,пожалуйста.",
                email:"Введите действительный адрес электронной почты,пожалуйста."
            }
        }
    });
</script>
