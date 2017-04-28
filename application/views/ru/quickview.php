<script type="text/javascript" src="/js/catalog-ru.js"></script>
<script type="text/javascript" src="/js/catalog.loadthumb.js"></script>
<div class="JS_popwincon1 dwrapper hide">
  <a class="JS_close2 close_btn3"></a>
  <div>
    <div class="pro_left fll">
      <div id="myImagesSlideBox" class="fix">
        <div class="myImages fll">
          <a href="#" id="myImgsLink" class="JS_zoom">
            <img src="#" id="picture" class="myImgs" big="#" width="420" />
            </a>
        </div>
        <div id="scrollable" class="flr"> 
          <a href="#" class="b-prev prev3"></a>
          <a href="#" class="b-next next3"></a>
          <div class="items">
            <div class="scrollableDiv fix">   
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="pro_right flr ml35" id="productInfo">
      <dl>
        <dd>
          <h3 id="product_name"></h3>
          <div class="fix">
          <p style="padding-bottom:12px;color:#999;">
            <span style="margin-right:15px;color:#000;" id="stock">В наличии</span>
            <span style="margin-right:15px;color:#000;" id="outstock" class="hide">Нет в наличии</span>
            Товар# : <span id="product_sku" style="margin-right:15px;"></span>
            <span id="jr"><a href="#" id="product_link">Подробнее</a></span>
            </p>
            </div>
        </dd>
        <dd class="fix info jiage" >
          <div class="fll font11 ttr">
            <p class="price">
                <span style="text-decoration:line-through" id="product_s_price"></span>
                <span class="red" style="font-size:24px;" id="product_price"></span>
                <i class="red" id="product_rate"></i></p>
          </div>
        </dd>
        <dd class="last">
          <div  class="fix mt10">   
            <span class="fll">
              <span id="review_date"></span>
              <span class="reviews" id="review_count"></span>
            </span>
          </div>
          <div id="action-form">
          <form action="#" method="post" id="formAdd">
            <input id="product_id" type="hidden" name="id" value="8468"/>
            <input id="product_items" type="hidden" name="items[]" value="8468"/>
            <input id="product_type" type="hidden" name="type" value="3"/>
            <div class="btn_size"></div>
            <div class="btn_color"></div>
            <div class="btn_type"></div>
             <div class="total">
              <input type="submit" style="font-size: 13px;" class="btn40_16_red" id="addCart" value="Добавить в корзину">
              <a href="#" class="view_btn btn40_1" style="margin-top:-6px;background: none;border: none;text-decoration: underline;" id="addWishList">Избранное (<span id="wishlists"></span>)</a>
             </div> 
          </form>
          </div>
          <ul class="JS_tab detail_tab detail_tab2 fix">
            <li class="ss1 current" style="width: 82px;margin: 0 0 -1px 0;">Детали</li>
            <li class="ss2" style="width: 82px;margin: 0 0 -1px 0;">модель</li>
            <li class="ss3" style="width: 82px;margin: 0 0 -1px 0;">Доставка</li>
            <li class="ss4" style="width: 82px;margin: 0 0 -1px 0;">Контакт</li>
            <p><b></b></p>
          </ul>
          <div class="JS_tabcon detail_tabcon detail_tabcon2">
            <div class="bd" id="tab-detail" style="opacity:1"></div>
            <div class="bd hide" id="tab-model" style="opacity:1"></div>
            <div class="bd hide">
                <p style="color:#F00;">Время приема= время обработки（3-5 рабочих дней） + время доставки</p>
                <h4>Доставка:</h4>
                <p>(1)  бесплатная доставка по всему миру (10-15 рабочих дней)</p>
                <p style="color:#F00; padding-left:18px;">Нет минимальной суммы покупки</p>
                <p>(2)  <?php echo Site::instance()->price(15, 'code_view'); ?> экспресс-доставка(4-7 рабочих дней)</p>
                <p style="padding-left:18px;">Проверить детали в <a class="a_red" href="<?php echo LANGPATH; ?>/shipping-delivery" title="Отправка и доставка">Отправка и доставка</a></p>
                <h4>Политики Возврата:</h4>
                <p>Не устраивает ваш заказ, вы можете связаться с нами и вернуть его в течение 60 дней.</p>
                <p>Если нет проблем качества с одеждой, мы не осуществляем возврат и обмен <span class="red">купальников и пижамы</span>. Проверить детали в <a class="a_red" href="<?php echo LANGPATH; ?>/returns-exchange" title="Политики Возврата">Политики Возврата</a>.</p>
                <h4>Дополнительное Внимание:</h4>
                <p>Заказы может быть облагаться импортными пошлинами, если вы хотите избежать дополнительных налогов в местный обычай,пожалуйста,свяжитесь с нами.Мы будем использовать почту Hong Kong.</p>
            </div>
            <div class="bd hide" style="opacity:1">
                <div class="LiveChat2  mt15 pl10">
                    <a href="#" onclick="psSMPPow(); return false;"><img name="psSMPPimage" src="http://www.choies.com/images/livechat_online1.gif" border="0" /> Чат</a>
                </div>
                <div class="LiveChat2 mt10 pl10"><a href="mailto:service_ru@choies.com"><img src="/images/livemessage.png" alt="Dejar Un Mensaje" /> Оставить сообщение</a></div>
                <div class="LiveChat2 mt10 pl10"><a href="<?php echo LANGPATH; ?>/faqs" target="_blank"><img src="/images/faq.png" alt="FAQ" /> ЧЗВ</a></div>
            </div>
          </div>
        </dd>
      </dl>
    </div>
  </div>
</div>