<script type="text/javascript" src="/js/catalog-de.js"></script>
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
            <span style="margin-right:15px;color:#000;" id="stock">Auf Lager</span>
            <span style="margin-right:15px;color:#000;" id="outstock" class="hide">Ausverkauft</span>
            Artikel# : <span id="product_sku" style="margin-right:15px;"></span>
            <span id="jr"><a href="#" id="product_link">VOLLSTÄNDIGE DETAILS SEHEN</a></span>
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
              <input type="submit" style="font-size: 16px;" class="btn40_16_red" id="addCart" value="IN DEN WARENKORB">
              <a href="#" class="view_btn btn40_1" style="margin-top:-6px;background: none;border: none;text-decoration: underline;" id="addWishList">MEINE WUNSCHLISTE (<span id="wishlists"></span>)</a>
             </div> 
          </form>
          </div>
          <ul class="JS_tab detail_tab detail_tab2 fix">
            <li class="ss1 current" style="width: 82px;margin: 0 0 -1px 0;">DETAILS</li>
            <li class="ss2" style="width: 82px;margin: 0 0 -1px 0;">MODELL</li>
            <li class="ss3" style="width: 82px;margin: 0 0 -1px 0;">Lieferung</li>
            <li class="ss4" style="width: 82px;margin: 0 0 -1px 0;">KONTAKT</li>
            <p><b></b></p>
          </ul>
          <div class="JS_tabcon detail_tabcon detail_tabcon2">
            <div class="bd" id="tab-detail" style="opacity:1"></div>
            <div class="bd hide" id="tab-model" style="opacity:1"></div>
            <div class="bd hide">
                <p style="color:#F00;">Empfangszeit = Bearbeitungszeit(3-5 Arbeitstage) + Versandzeit</p>
                <h4>Versand:</h4>
                <p>(1)  Kostenloser weltweiter Versand (10-15 Arbeitstage)</p>
                <p style="color:#F00; padding-left:18px;">Keine Mindestbestellung erforderlich.</p>
                <p>(2)  <?php echo Site::instance()->price(15, 'code_view'); ?> Express Versand (4-7 Arbeitstage)</p>
                <p style="padding-left:18px;">Prüfen Sie Details hier <a class="a_red" href="<?php echo LANGPATH; ?>/shipping-delivery" title="Versand &amp; Lieferung">Versand &amp; Lieferung</a>.</p>
                <h4>Rückgabe Politik:</h4>
                <p>Wenn Sie nicht 100% zufrieden mit Ihrer Bestellung sind, können Sie Ihre Artikel(n) innerhalb von 60 Tagen zurückgeben.</p>
                <p>Für <span class="red">Bademode &amp; Unterwäsche</span>, wenn es kein Qualitätsproblem gibt, akzeptieren wir KEINE Rückgabe oder Umtausch, Prüfen Sie Details hier <a class="a_red" href="<?php echo LANGPATH; ?>/returns-exchange" title="Rückgabe Politik">Rückgabe Politik</a>.</p>
                <h4>Zusätzliche Aufmerksamkeit:</h4>
                <p>Bestellungen können Importzöllen und Steuern unterliegen, wenn Sie dies vermeiden möchten, kontaktieren Sie uns bitte, wir werden HongKong Post verwenden.</p>
            </div>
            <div class="bd hide" style="opacity:1">
                <div class="LiveChat2  mt15 pl10">
                    <a href="#" onclick="psSMPPow(); return false;"><img name="psSMPPimage" src="http://www.choies.com/images/livechat_online1.gif" border="0" /> LiveChat</a>
                </div>
                <div class="LiveChat2 mt10 pl10"><a href="mailto:service_de@choies.com"><img src="/images/livemessage.png" alt="Dejar Un Mensaje" /> Eine Nachricht hinterlassen</a></div>
                <div class="LiveChat2 mt10 pl10"><a href="<?php echo LANGPATH; ?>/faqs" target="_blank"><img src="/images/faq.png" alt="FAQ" /> FAQ</a></div>
            </div>
          </div>
        </dd>
      </dl>
    </div>
  </div>
</div>