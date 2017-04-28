<?php if (!Customer::logged_in()): ?>
    <script type="text/javascript">
        $(function(){
            $("#agree").live("click", function(){
                $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                $('#catalog_link').appendTo('body').fadeIn(320);
                $('#catalog_link').show();
                return false;
            })
                        
            $("#catalog_link .clsbtn,#wingray").live("click",function(){
                $("#wingray").remove();
                $('#catalog_link').fadeOut(160).appendTo('#tab2');
                return false;
            })
        })
    </script>
<?php endif; ?>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Home</a>  >  Блоггер хочет</div>
        </div>
    </div>
    <section class="layout fix">
        <div class="tit blogger_wanted mb25">
      <span>Модные программы</span><span class="on">Читать политики</span><span>Представить информацию</span><span>Получить Баннер</span>
      <img src="/images/<?php echo LANGUAGE; ?>/blogger_wanted2.png" />
    </div>  
        <article id="container" style="margin-top:30px;background: #fff;">
            <div class="fashion_policy" style="border-bottom:#CCC 1px dashed;">
                <h3>Модные Блоггеры:</h3>
                <p>Неважно, ты клевая девчонка, которая любит моду, или фэшн-блоггер, всегда показывает свой модный вкус, как свободная девушка.</p>
                <p>При применении программы модных блоггеров в Choies.com. Наши блоггеры могут воспользоваться особными скидками и бесплатными продуктами непосредственно из наштх новых товаров.</p>
                <p>Не стесняйтесь, чтобы отправить нам по электронной почте (<a href="mailto:business@choies.com" title="business@choies.com">business@choies.com</a>) о себе.</p>
            </div>
            <div class="fashion_policy mt20" style="border-bottom:#CCC 1px dashed;">
                <p>Как вступить CHOIES Модные Блоггеры?</p>
                <h3>1. Ты блоггер ли, который фокусируется текущую моду и стиль?</h3>
                <p>CHOIES теперь сотрудничает со многими известными блоггерами и будет иметь честь пригласить вас в нашей модныой программе.</p>
                <h3>Квалификация:</h3>
                <p>  1. Вы верите, что у вас есть вкус к моде и являетесь влиятельными в вашем личном блоге, странице Фейсбука, YouTube, <span class="red1">Chicisimo</span> и т.д,</p>
                <p>  2. Вы используете блог о моде часто, как минимум раз в неделю.</p>
                <p>&nbsp;</p>
                <h3>2. Что я должен сделать, чтобы начать?</h3>
                <p>Вы должны зарегистрироваться в www.choies.com и поставить наш баннер на свой блог. Вы можете получить код баннера, нажав кнопку "Согласно". Сообщить нам о вашей регистрации по электронной почте, мы будем добавлять баллы к вашему счету.</p>
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
            <div class="fashion_policy mt20">
                <h3>Об авторских правах ваших фото</h3>
                <p>Мы имеем право поставить фото из вашего блога на нашем Фейсбуке, странице instagram и других наших официальных страницах.</p>
                <p>Если у вас есть любые другие вопросы о программы модных блоггеров , вы можете посылать по электронной почте к <a href="mailto:business@choies.com" title="business@choies.com">business@choies.com</a>.</p>
                <p>&nbsp;</p>
                <p>Мы будем проверять его в неделю и ответ, если вы утверждены.</p>
                <p>Если вы согласны со всеми условиями выше, нажмите согласо и продолжать.</p>
                <div class="form_btn mt20 mb10" id="agree">
                    <p><a href="<?php echo LANGPATH; ?>/blogger/submit_information"><strong class="view_btn btn26 btn40" style="width: 100px;">Согласно</strong></a></p>
                </div>
            </div>
        </article>
    </section>
</section>
<div class="hide" id="catalog_link" style="position: fixed;padding: 10px 10px 20px; top: 0px;left: 400px;width: 640px;height: 230px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border:#CCC 1px solid;">
    <div class="order order_addtobag">
        <div class="fashion_thank">
            <h4>Получить ваш собственный кабинет,прежде следующего шага.<br/>
                Пожалуйста, войдите на сайт или зарегистрируйтесь.</h4>
            <div class="2btns">
                <span class="form_btn mr10"><a href="<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/blogger/submit_information" title="Log In"><strong class="view_btn btn26 btn40" style="width: 100px;">Логин</strong></a></span>
                <span class="form_btn"><a href="<?php echo LANGPATH; ?>/customer/register?redirect=<?php echo LANGPATH; ?>/blogger/submit_information" title="REGISTER"><strong class="view_btn btn26 btn40" style="width: 100px;">Регистрация</strong></a></span>
            </div>
        </div>
    </div>
    <div class="clsbtn" style="right: -0px;top: 3px;"></div>
</div>