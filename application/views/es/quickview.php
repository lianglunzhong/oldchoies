<script type="text/javascript" src="/js/catalog-es.js"></script>
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
            <span style="margin-right:15px;color:#000;" id="stock">En Stock</span>
            <span style="margin-right:15px;color:#000;" id="outstock" class="hide">Fuera De Stock</span>
            artículo# : <span id="product_sku" style="margin-right:15px;"></span>
            <span id="jr"><a href="#" id="product_link">Ver Detalles Completos</a></span>
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
              <input type="submit" style="font-size: 18px;" class="btn40_16_red" id="addCart" value="AÑADIR A BOLSA">
              <a href="#" class="view_btn btn40_1" style="margin-top:-6px;background: none;border: none;text-decoration: underline;" id="addWishList">LISTA DE DESEOS(<span id="wishlists"></span>Add)</a>
             </div> 
          </form>
          </div>
          <ul class="JS_tab detail_tab detail_tab2 fix">
            <li class="ss1 current" style="width: 90px;margin: 0 0 -1px 0;">DETALLES</li>
            <li class="ss2" style="width: 90px;margin: 0 0 -1px 0;">MODELO</li>
            <li class="ss3" style="width: 90px;margin: 0 0 -1px 0;">Envío</li>
            <li class="ss4" style="width: 90px;margin: 0 0 -1px 0;">Contacto</li>
            <p><b></b></p>
          </ul>
          <div class="JS_tabcon detail_tabcon detail_tabcon2">
            <div class="bd" id="tab-detail"></div>
            <div class="bd hide" id="tab-model"></div>
            <div class="bd hide">
                <p style="color:#F00;">Tiempo Recibido= tiempo de preparación(3-5 dias laborables) + Duración del transporte</p>
                <h4>Envío:</h4>
                <p>(1)  Envío gratuito por todo el mundo(10-15 dias laborables)</p>
                <p style="color:#F00; padding-left:18px;">Sin compra mínima requerida.</p>
                <p>(2)  <?php echo Site::instance()->price(15, 'code_view'); ?> El envío expreso(4-7 dias laborables)</p>
                <p style="padding-left:18px;">Ver más en <a class="a_red" href="<?php echo LANGPATH; ?>/shipping-delivery" title="envío y entrega">envío y entrega</a>.</p>
                <h4>La Política De Devolución:</h4>
                <p>Para <span class="red">traje de baño y ropa interior</span>, si no hay un problema de calidad, no ofrecemos servicio de devolución o cambio <a class="a_red" href="<?php echo LANGPATH; ?>/returns-exchange" title="la política de devolución">la política de devolución</a>.</p>
                <h4>Atención Adicional:</h4>
                <p>Los pedidos pueden estar sujetos a derechos de importación, si usted no quiere pagar el impuesto adicional por su aduana local, póngase en contacto con nosotros, vamos a utilizar Correos de Hong Kong. </p>
            </div>
            <div class="bd hide">
                <div class="LiveChat2  mt15 pl10">
                    <a href="#" onclick="psSMPPow(); return false;"><img name="psSMPPimage" src="http://www.choies.com/images/livechat_online1.gif" border="0" /> Live chat</a>
                </div>
                <div class="LiveChat2 mt10 pl10"><a href="mailto:service_es@choies.com"><img src="/images/livemessage.png" alt="Dejar Un Mensaje" /> Dejar Un Mensaje</a></div>
                <div class="LiveChat2 mt10 pl10"><a href="<?php echo LANGPATH; ?>/faqs" target="_blank"><img src="/images/faq.png" alt="FAQ" /> FAQ</a></div>
            </div>
          </div>
        </dd>
      </dl>
    </div>
  </div>
</div>