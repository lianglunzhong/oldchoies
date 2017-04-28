<script type="text/javascript" src="/js/catalog-fr.js"></script>
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
            <span style="margin-right:15px;color:#000;" id="stock">Disponible</span>
            <span style="margin-right:15px;color:#000;" id="outstock" class="hide">Indisponible</span>
            Article# : <span id="product_sku" style="margin-right:15px;"></span>
            <span id="jr"><a href="#" id="product_link">VOIR PLUS DE DÉTAILS</a></span>
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
              <input type="submit" style="font-size: 16px;" class="btn40_16_red" id="addCart" value="Ajouter au panier">
              <a href="#" class="view_btn btn40_1" style="margin-top:-6px;background: none;border: none;text-decoration: underline;" id="addWishList">Liste d’envies(<span id="wishlists"></span>)</a>
             </div> 
          </form>
          </div>
          <ul class="JS_tab detail_tab detail_tab2 fix">
            <li class="ss1 current" style="width: 90px;margin: 0 0 -1px 0;">Détails</li>
            <li class="ss2" style="width: 90px;margin: 0 0 -1px 0;">MODEL INFO</li>
            <li class="ss3" style="width: 90px;margin: 0 0 -1px 0;">LIVRAISON</li>
            <li class="ss4" style="width: 90px;margin: 0 0 -1px 0;">Contact</li>
            <p><b></b></p>
          </ul>
          <div class="JS_tabcon detail_tabcon detail_tabcon2">
            <div class="bd" id="tab-detail"></div>
            <div class="bd hide" id="tab-model"></div>
            <div class="bd hide">
                <p style="color:#F00;">Temps de réception = Temps de traitement + Temps de livraison</p>
                <h4>Livraison:</h4>
                <p>(1)  Livraison internationale gratuite (15-20 jours ouvrables)</p>
                <p style="color:#F00; padding-left:18px;">Pas de minimum d'achat requis.</p>
                <p>(2)  <?php echo Site::instance()->price(15, 'code_view'); ?> de Livraison Express (4-7 jours ouvrables)</p>
                <p style="padding-left:18px;">Consultez les détails dans <a class="a_red" href="<?php echo LANGPATH; ?>/shipping-delivery" title="envío y entrega">Expédition & Livraison</a>.</p>
                <h4>Politique de retour:</h4>
                <p>Pas satisfait de votre commande, vous pouvez nous contacter et de le retourner dans 60 jours.</p>
                <p>Pour <span class="red">Maillots de bain</span> et <span class="red">Sous-vêtements</span>, si il n'y a aucun problème de qualité, nous n'offrent pas le service de retour et d'échange, veuillez nous comprendre <a class="a_red" href="<?php echo LANGPATH; ?>/returns-exchange" title="la política de devolución">la politique de retour</a>.</p>
                <h4>Attention:</h4>
                <p>Les commandes peuvent être soumises à des droits d'importation, si vous voulez éviter d'être facturé pour l'impôt supplémentaire par la douane locale, veuillez nous contacter, nous allons utiliser Hong Kong Post.</p>
            </div>
            <div class="bd hide">
                <div class="LiveChat2  mt15 pl10">
                    <a href="#" onclick="psSMPPow(); return false;"><img name="psSMPPimage" src="http://www.choies.com/images/livechat_online1.gif" border="0" /> Live chat</a>
                </div>
                <div class="LiveChat2 mt10 pl10"><a href="mailto:<?php echo Site::instance()->get('email'); ?>"><img src="/images/livemessage.png" alt="Dejar Un Mensaje" /> Laisser un message</a></div>
                <div class="LiveChat2 mt10 pl10"><a href="<?php echo LANGPATH; ?>/faqs" target="_blank"><img src="/images/faq.png" alt="FAQ" /> FAQ</a></div>
            </div>
          </div>
        </dd>
      </dl>
    </div>
  </div>
</div>