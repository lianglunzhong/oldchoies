<div class="site-content">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs row">
            <div class="col-xs-12">
                <a href="<?php echo LANGPATH; ?>/">home</a> > Вспомнить пароль
            </div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <!-- main-middle begin -->
    <div class="container">
        <div class="row">
            <aside id="aside" class="col-sm-1 hidden-xs"></aside>
            <article class="user col-sm-10 col-xs-12">
                <div class="tit">
                    <h2>Вспомнить пароль</h2>
                </div>
                <form class="forgot-psd-form col-xs-12" method="post" action="/customer/forgot_password">
                    <p>Пожалуйста, введите ваш адрес электронной почты ниже. Мы вышлем ваш оригинальный пароль на ваш электронный ящик. Процесс может занять немного времени, так как потенциал системы задержки. Спасибо за ваше терпение.</p>
                    <ul>
                        <li>
                            <label class="col-sm-2 col-xs-12">
                                <span>*</span> Ваша электронная почта:
                            </label>
                            <div>
                                <input class="text col-xs-12" type="text" value="" name="email">
                            </div>
                        </li>
                        <li>
                            <label class="hidden-xs col-sm-2"> </label>
                            <div>
                                <input class="btn btn-primary btn-lg" type="submit" value="Submit" name="">
                            </div>
                        </li>
                    </ul>
                </form>
            </article>
        </div>
    </div>
</div>
<script type="text/javascript">
/* forgot-psd-form */
$(".forgot-psd-form").validate({
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
