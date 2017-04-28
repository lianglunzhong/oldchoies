        <style>
        .contact-form div{clear:none;}
        .contect div.contact-note p{color:#444;}
        .contact-form span{margin:none;line-height:24px;}
        .contact-form ul li p{font-size:11px;color:#444;}
        .contect span.btn-span{margin-bottom:20px;}
        
        </style>
        <section id="main">
            <!-- crumbs -->
            <div class="container">
                <div class="crumbs">
                    <div>
                        <a href="<?php echo LANGPATH; ?>/">home</a>
                        <a href="<?php echo LANGPATH; ?>/faqs" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > ЧЗВ</a> >  Свяжитесь С Нами
                    </div><?php echo Message::get(); ?>
                </div>
            </div>
            <!-- main-middle begin -->
            <div class="container">
                <div class="row">
            <?php echo View::factory(LANGPATH . '/doc/left'); ?>
                    <article class="user col-sm-9 col-xs-12">
                        <div class="tit">
                            <h2>Свяжитесь С Нами</h2>
                        </div>
                        <div class="doc-box contect">
                            <h3 style="text-transform:uppercase; font-size:18px; font-weight:normal;">Мы здесь, чтобы помочь!</h3>
                            <p class="mt10">Если вы столкнетесь с какими-либо проблемами во время покупки в Choies.com, вы можете связаться с нами по следующим методам:</p>
                            <div>
                                <span class="btn-span"><a class="btn btn-default btn-lg" style="color:#fff;text-decoration:none;" target="_blank" title="LiveChart" href="https://chatserver.comm100.com/chatwindow.aspx?planId=311&siteId=203306"><img src="/assets/images/docs/icon_chat.png">LIVECHAT</a></span>
                                <span></span>
                            </div>
                           <div>
                                <span class="btn-span"><a class="btn btn-default btn-lg JS_click" style="color:#fff;text-decoration:none;" target="_blank" title="">Нажмите И Свяжитесь С Нами</a></span>
                                 <div class="JS_clickcon hide">
                                    <div class="row">
                                        <form action="site/docsend" method="post" class="user-form contact-form col-xs-12 mt20" enctype="multipart/form-data">
                                        <ul> 
                                            <li>
                                                <label class="col-sm-3 col-xs-12"><span>*</span> Имя:</label>
                                                <div class="col-sm-6 col-xs-12">
                                                    <input type="text" value="" name="name" class="text-long text col-sm-12 col-xs-12" />
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-3 col-xs-12"><span>*</span> Адрес Почты :</label>
                                                <div class="col-sm-6 col-xs-12">
                                                    <input type="text" value="" name="email" class="text-long text col-sm-12 col-xs-12" />
                                                    <p>Если у вас счет Choies, заполните адрес почты для логина.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-3 col-xs-12"><span>*</span> Тип Вопросов:</label>
                                                <div class="col-sm-6 col-xs-12">
                                                    <div class="wdrop">
                                                        <select class="selected-option col-sm-12 col-xs-12" name="qt">
                                                            <option value="" class="selected"> - Выберите тип вопросов - </option>
                                                            <option value="1">Общий Вопрос о Предварительной продаже/Наличие На Складе/Информация Товаров</option>
                                                            <option value="2">Оптовая Предварительная продажа, Оптовые Закупки или Транзитный Запрос </option>
                                                            <option value="3">Изменение адреса или товаров/Отмена Заказа  </option>
                                                            <option value="4">Статус Заказа/Информация отслеживания/Потеряна посылка/Таможенный Вопрос</option>
                                                            <option value="5">Сервис После-продажи(например, дефектные товары, неправильные товары, неподошел размер) </option>
                                                            <option value="6">Вопрос о оплате/Технические Вопросы </option>
                                                            <option value="7">Вопрос о Счете(например, пароль забыл, отписаться от рассылки)  </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-3 col-xs-12"><span>&nbsp;</span>Номер Заказа:<br/><span style="color:#444;">(если применимо)</span></label>
                                                <div class="col-sm-6 col-xs-12">
                                                    <input type="text" value="" name="order" class="text-long text col-sm-12 col-xs-12" />
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-3 col-xs-12">
                                                    <span>*</span> Сообщение:
                                                </label>
                                                <div class="col-sm-6 col-xs-12 mb20">
                                                    <textarea class="textarea-long text col-sm-12 col-xs-12" name="message"></textarea>
                                                </div>
                                            </li>
                                             <li>
                                                <label class="col-sm-3 col-xs-12"><span>&nbsp;</span>Вложение:</label>
                                                <div class="col-sm-6 col-xs-12">
                                                <input type="text" class="text-long text col-sm-9 col-xs-9" readonly name="file_name" id="file_name"/><input type="button" value="загрузить" class="col-sm-3 col-xs-3 btn btn-xs btn-default" style="height:24px;" onclick="btn_file.click();" name="get_file"/>
                                                    <input type="file" name="btn_file" onchange="file_change(this.value)" style="display:none;"/>
                                                
                                                     <!-- <p class="col-sm-2 col-xs-2"><a><img style="max-width:none;" src="/assets/images/docs/upload.png" ></a></p> -->
                                                    <p>Если вы хотели показать нам несколько файлов, пожалуйста, загрузите их сюда. Каждый файл должен быть не больше 2 МБ.Следующие форматы файлов поддерживаются:gif, jpg, png, bmp, doc, xls, txt, rar, ppt, pdf.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-3 hidden-xs">&nbsp;</label>
                                                <div class="btn-grid12 col-sm-6 col-xs-12 mb20">
                                                    <input type="submit"  value="ПОСЛАТЬ" class="btn btn-primary btn-lg" />
                                                </div>
                                            </li>
                                        </ul>
                                    </form>
                                  </div>
                                </div>
                            </div>
                            <div class="contact-note">
                                <p style="font-weight:bold;">Электронные письма будут ответить В 24 часов,но может быть задержано в течение напряженного сезона.Чтобы решить вашу проблему быстро, Пожалуйста, обратите внимание:</p>
                                <p>
                                    1.Предпродажные вопросы, пожалуйста, нажмите <i><a href="<?php echo LANGPATH ?>/faqs" style="color:#444;">ЧЗВ</a> </i>;
                                </p>
                                <p>
                                    2.Если вы не получили подтверждение заказа и отслеживания информации,проверьте <strong> ПАПКУ ДЛЯ СПАМА</strong> ;
                                </p>
                                <p>
                                    3.Проверьте Статус Заказа и Отслеживайте, сначала <a href="<?php echo LANGPATH ?>/customer/login" class="a-red">логин</a> , потом нажмите кнопку <a href="<?php echo LANGPATH ?>/tracks/track_order" style="color: rgb(65, 140, 175);">ОТСЛЕЖИВАТЬ ЗАКАЗ</a>.
                                </p>
                            </div>

                            <div class="mt20">
                                <span class="icon-contect5"></span>
                                <span><strong>Телефон</strong></span>
                                <span> 442032899993 (ежедневно) </span>
                            </div>
							<div>
	                          	<p>[Имя Компании]  V-Shangs Наука и Техника(Гонконг) ООО</p>
	                          	<p>[Адрес]  Комната1702, 17 Этаж, Сино-Центр, 582-592 Натан Дорога, Цзюлун , Гонконг</p>
                            </div>
                            <p>[<i>Отношения Компании</i>]</p>
                            <div class="doc-contact-1230">
                            	<div>
	                            	<h4> УСИ В МОДЕ ТЕХНОЛОГИЧЕСКАЯ ГРУППА ООО</h4>
	                            	<p>Адрес: Комната 1801, № 855 НАНЬХУ Дорога , ЯНМИН НАУЧНЫЙ ИННОВАЦИОННЫЙ ЦЕНТР, Рай. НАНЬЧА, УСИ, ПРОВИНЦИЯ ЦЗЯНСУ, КИТАЙ</p>
	                            	<ul>
	                            		<li><p><img src="<?php echo STATICURL; ?>/assets/images/docs/contact-us-left.jpg"></p><span>Нанкин КуайЮэ Электронная Коммерция ООО </span></li>
	                            		<li><p><img src="<?php echo STATICURL; ?>/assets/images/docs/contact-us-right.jpg"></p><span style="margin:0 25px;float:right">V-Shangs Наука и Техника(Гонконг) ООО</span><p><img src="<?php echo STATICURL; ?>/assets/images/docs/contact-us-down.jpg"></p><p class="big-icon">choies</p></li>
	                            	</ul>
	                            	<p style="color:#c30;font-size:14px;">(Обратите внимание: Эти адреса НЕ принимают возвраты.)</p>
                            	</div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        
        <script type="text/javascript">
        function file_change(e)
        {
            document.getElementById("file_name").value = e;
        }
        </script>

<script type="text/javascript">
        $(".contact-form").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            qt: {
                required: true,
            },
            message: {
                required: true,
                minlength: 5,
                maxlength:20
            }
        },
        messages: {
            name: {
                required: "Please provide a name.",
            },
            email:{
                required:"Please provide an email.",
                email:"Please enter a valid email address."
            },
            qt: {
                required: "Please select a question.",
            },
            message:{
                required:"Please provide a message.",
            },
        }
    });
</script>



 