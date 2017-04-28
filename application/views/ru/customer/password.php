<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Home</a>  >  Изменение пароля</div>
        </div>
        <?php echo message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Изменение пароля</h2></div>
            <!-- Share This Product begin -->
            <form action="" method="post" class="form user_share_form user_form mlr70">
                <p class="font14">Для безопасности вашего кабинета, мы рекомендуем Вам выбрать пароль, что имеет отличие от имена, дни рождения, адреса, или  других информации о вас.</p>
                <ul>
                    <li class="fix">
                        <label><span>*</span>старый пароль:</label>
                        <div class="right_box">
                            <input type="password" name="oldpassword" value="" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label><span>*</span>Новый пароль:</label>
                        <div class="right_box">
                            <input type="password" name="password" id="password" value="" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label><span>*</span>Подтвердите Пароль:</label>
                        <div class="right_box">
                            <input type="password" name="confirmpassword" value="" class="text text_long" />
                        </div>
                    </li>
                    <li class="fix">
                        <label>&nbsp;</label>
                        <div class="right_box">
                            <input type="submit" name="" value="Изменение пароля" class="view_btn btn26 btn40" />
                        </div>
                    </li>
                </ul>
            </form>
        </article>
        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
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
                required: "Заполните это поле.",
                minlength: "Пароль слишком короткий, не менее 5 символов.",
                maxlength:"Пароль превышает максимальную длину 20 символов."
            },
            password: {
                required: "Заполните это поле.",
                minlength: "Пароль слишком короткий, не менее 5 символов.",
                maxlength:"Пароль превышает максимальную длину 20 символов."
            },
            confirmpassword: {
                required: "Заполните это поле.",
                minlength: "Пароль слишком короткий, не менее 5 символов.",
                maxlength:"Пароль превышает максимальную длину 20 символов.",
                equalTo: "Пожалуйста, введите тот же пароль, что и выше."
            }
        }
    });
</script>
