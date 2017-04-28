<section id="main">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs">
            <div>
                <a href="<?php echo LANGPATH; ?>/">home</a>
                <a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > Личный кабинет</a> >Изменение пароля
            </div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <!-- main-middle begin -->
    <div class="container">
        <div class="row">
<?php echo View::factory(LANGPATH . '/customer/left'); ?>
<?php echo View::factory(LANGPATH . '/customer/left_1'); ?>
            <article class="user col-sm-9 col-xs-12">
                <div class="tit">
                    <h2>Изменение пароля</h2>
                </div>
                <div class="row">
                    <div class="col-sm-2 hidden-xs"></div>
                    <form class="user-form user-share-form col-sm-8 col-xs-12" method="post" action="">
                        <p class="col-sm-12 col-xs-12 change-password">Для безопасности вашего кабинета, мы рекомендуем Вам выбрать пароль, что имеет отличие от имена, дни рождения, адреса, или  других информации о вас.</p>
                        <ul>
                            <li>
                                <label class="col-sm-3 col-xs-12"><span>*</span>старый пароль:</label>
                                <div class="col-sm-9 col-xs-12">
                                    <input type="password" class="text text-long col-sm-12 col-xs-12" value="" name="oldpassword">
                                </div>
                            </li>
                            <li>
                                <label class="col-sm-3 col-xs-12"><span>*</span>Новый пароль:</label>
                                <div class="col-sm-9 col-xs-12">
                                    <input type="password" class="text text-long col-sm-12 col-xs-12" value="" id="password" name="password">
                                </div>
                            </li>
                            <li>
                                <label class="col-sm-3 col-xs-12"><span>*</span>Подтвердите Пароль:</label>
                                <div class="col-sm-9 col-xs-12">
                                    <input type="password" class="text text-long col-sm-12 col-xs-12" value="" name="confirmpassword">
                                </div>
                            </li>
                            <li>
                                <label class="col-sm-3 hidden-xs">&nbsp;</label>
                                <div class="btn-grid12 col-sm-9 col-xs-12">
                                    <input type="submit" class="btn btn-primary btn-sm" value="Изменение пароля" name="">
                                </div>
                            </li>
                        </ul>
                    </form>
                    <div class="col-sm-2 hidden-xs"></div>
                </div>
            </article>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(".user-share-form").validate({
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
