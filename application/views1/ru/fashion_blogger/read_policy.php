<?php if (!Customer::logged_in()): ?>
    <script type="text/javascript">
        $(function(){
            $("#agree").live("click", function(){
                var top = getScrollTop();
                top = top - 35;
                $('body').append('<div class="JS_filter1 opacity hidden-xs"></div>');
                $('.JS_popwincon1').css({
                    "top": top,
                    "position": 'absolute'
                });
                $('.JS_popwincon1').appendTo('body').fadeIn(320);
                $('.JS_popwincon1').show();
                return false;

            })
                    
             $(".JS_close2,.JS_filter1").live("click", function() {
                $(".JS_filter1").remove();
                $('.JS_popwinbtn1').fadeOut(160);
                return false;
            })
                    
            $("#catalog_link .clsbtn,#wingray").live("click",function(){
                $("#wingray").remove();
                $('#catalog_link').fadeOut(160).appendTo('#tab2');
                return false;
            })
        })
        
        function getScrollTop() {
                var scrollPos;
                if (window.pageYOffset) {
                    scrollPos = window.pageYOffset;
                } else if (document.compatMode && document.compatMode != 'BackCompat') {
                    scrollPos = document.documentElement.scrollTop;
                } else if (document.body) {
                    scrollPos = document.body.scrollTop;
                }
                return scrollPos;
            }
    </script>
<?php endif; ?>
<?php
$url1 = parse_url(Request::$referrer);
?>
        <section id="main">
            <!-- crumbs -->
            <div class="container">
                <div class="crumbs">
                    <div class="back visible-xs-inline hidden-sm hidden-md hidden-lg">&lt;&lt;&nbsp;<a class="back" href="<?php echo LANGPATH.$url1['path']; ?>">back</a>
                    </div>
                </div>
            </div>
            <!-- main begin -->
            <section class="container blogger-wanted">
            <div class="blogger-img hidden-xs">
                    <div class="step-nav step-nav1">
                        <ul class="clearfix">
                           <li>Модные программы<em></em><i></i></li>
                            <li class="current">Читать политики<em></em><i></i></li>
                            <li>Представить информацию<em></em><i></i></li>
                            <li>Получить Баннер<em></em><i></i></li>
                        </ul>
                    </div>
                </div>
                <article class="row">
                    <div class="col-sm-1 hidden-xs"></div>
                    <div class="col-sm-10 col-xs-12">
                        <div class="fashion-policy">
                <h3>Модные Блоггеры:</h3>
                <p>Неважно, ты клевая девчонка, которая любит моду, или фэшн-блоггер, всегда показывает свой модный вкус, как свободная девушка.</p>
                <p>При применении программы модных блоггеров в Choies.com. Наши блоггеры могут воспользоваться особными скидками и бесплатными продуктами непосредственно из наштх новых товаров.</p>
                <p>Не стесняйтесь, чтобы отправить нам по электронной почте (<a href="mailto:business@choies.com" title="business@choies.com">business@choies.com</a>) о себе.</p>
            </div>
            <div class="fashion-policy">
                <p>Как вступить CHOIES Модные Блоггеры?</p>
                <h3>1. Ты блоггер ли, который фокусируется текущую моду и стиль?</h3>
                <p>CHOIES теперь сотрудничает со многими известными блоггерами и будет иметь честь пригласить вас в нашей модныой программе.</p>
                <h3>Квалификация:</h3>
                <p>  1. Вы верите, что у вас есть вкус к моде и являетесь влиятельными в вашем личном блоге, странице Фейсбука, YouTube, <span class="red1">Chicisimo</span> и т.д,</p>
                <p>  2. Вы используете блог о моде часто, как минимум раз в неделю.</p>
                <p>&nbsp;</p>
                <h3>2. Что я должен сделать, чтобы начать?</h3>
                <p>Вы должны зарегистрироваться в <?php echo URLSTR; ?> и поставить наш баннер на свой блог. Вы можете получить код баннера, нажав кнопку "Согласно". Сообщить нам о вашей регистрации по электронной почте, мы будем добавлять баллы к вашему счету.</p>
                <p>&nbsp;</p>
                <h3>3. Какие правила я должен соблюдать, чтобы получить продление своих баллов?</h3>
                <p> Обычно вы должны показать наши товары в течение 7 дней и пришлите мне ссылку на ваш блог. Там должна быть соответствующой ссылкой ниже изделие, которую вы носите на своем блоге вместо главной страницы только в случае если товар вам показать закончились на складе. Дополнительные баллы, если вы поделитесь ваш лук в Chicisimo.com и есть ссылка choies.com.</p>
                <p>&nbsp;</p>
                <h3>4. Как часто вы даете награду разным блоггерам?</h3>
                <p>Обычно мы даем баллы для блоггеров в качестве награды, которые вы можете использовать в нашем магазине. Мы будем обновлять свои баллы, когда они делают наряды на своем блоге и социальных платформ и отправить нам сообщение ссылки.</p>
                <p>&nbsp;</p>
                <h3>5. Должен ли я платить таможню?</h3>
                <p> Пользовательские политики таможни отличаются от разных стран. Например, блоггеры из Бразилии должны предоставить нам номер налогоплательщика и уплатить налог. Это зависит от политики вашей страны.</p>
                <p>&nbsp;</p>
                <h3>6. Существуют ли другие способы, чтобы получить больше баллов?</h3>
                <p> Да, вы можете получить больше баллов, путем записи в блоге с CHOIES или провести подарок для choies и пришлить нам ссылку.</p>
                <p>&nbsp;</p>
                <h3>7. Пожалуйста, зарегистрируйтесь choies.com прежде чем делать другие.</h3>
                <p>Вы не можете использовать баллы, если вы не зарегистрированы.</p>
            </div>
            <div class="fashion-policy">
                <h3>Об авторских правах ваших фото</h3>
                <p>Мы имеем право поставить фото из вашего блога на нашем Фейсбуке, странице instagram и других наших официальных страницах.</p>
                <p>Если у вас есть любые другие вопросы о программы модных блоггеров , вы можете посылать по электронной почте к <a href="mailto:business@choies.com" title="business@choies.com">business@choies.com</a>.</p>
                <p>&nbsp;</p>
                <p>Мы будем проверять его в неделю и ответ, если вы утверждены.</p>
                <p>Если вы согласны со всеми условиями выше, нажмите согласо и продолжать.</p>
                            <div id="agree" class="mt20 mb10">
                                <p><a href="<?php echo LANGPATH; ?>/blogger/submit_information"><strong class="btn btn-primary btn-lg">Согласно</strong></a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1 hidden-xs"></div>
                </article>
            </section>
            <div class="JS_popwincon1  hide" style="position: fixed; padding: 10px 10px 20px; top: 100px; left: 400px; width: 640px; height: 230px; z-index: 1000; background: none repeat scroll 0% 0% rgb(255, 255, 255); border:1px solid rgb(204, 204, 204);">
                <div class="order">
                    <div class="fashion-thank">
            <h4>Получить ваш собственный кабинет,прежде следующего шага.<br/>
                Пожалуйста, войдите на сайт или зарегистрируйтесь.</h4>
                        <div class="2btns">
                            <span style="padding-right:10px;"><a class="btn btn-primary btn-sm" title="Log In" href="<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/blogger/submit_information"><strong style="width: 100px;" class="view_btn btn26 btn40">огин</strong></a></span>
                            <span><a class="btn btn-primary btn-sm" title="REGISTER" href="<?php echo LANGPATH; ?>/customer/register?redirect=<?php echo LANGPATH; ?>/blogger/submit_information"><strong style="width: 100px;" class="view_btn btn26 btn40">Регистрация</strong></a></span>
                        </div>
                    </div>
                </div>
                <div class="JS_close2 close-btn3"></div>
            </div>          
                    

            <!-- footer begin -->

            <!-- gotop -->
            <div id="gotop" class="hide">
                <a href="#" class="xs-mobile-top"></a>
            </div>