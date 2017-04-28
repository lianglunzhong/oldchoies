<script type="text/javascript" src="/assets/js/catalog1.js"></script>
<!-- JS-popwincon1 -->
<div id="myModal" class="reveal-modal xlarge">
        <a class="close-reveal-modal close-btn3"></a>
    <div>
        <div class="pro-left">
            <div id="myImagesSlideBox">
                <div class="myImages">
                    <a href="#" id="myImgsLink" class="JS-zoom" onclick="return false;">
                        <img alt="" src="" id="picture" class="myImgs" big="#">
                    </a>
                </div>
                <div id="scrollable" class="flr">
                    <a href="#" class="b-prev prev3"></a>
                    <a href="#" class="b-next next3"></a>
                    <div class="items">
                        <div class="scrollableDiv">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pro-right" style="width:400px;">
            <dl>
                <dd>
                    <h3 id="product_name">Black And White Plaid Long Sleeve Shirt</h3>
                    <div class="pro-stock">
                        <span class="stock-sp" id="stock">Disponible</span>
                        <span class="stock-sp" style="display: none;" id="outstock" class="hide">Indisponible</span>
                        Article# : <span id="product_sku"></span>
                        <strong>
                            <a href="" id="product_link">VOIR PLUS DE DÉTAILS</a>
                        </strong>
                    </div>
                </dd>
                <dd>
                    <p class="price">
                        <del id="product_s_price"></del>
                        <span class="red" id="product_price"></span>
                        <i class="red" id="product_rate_show" style="display:none;">
                            <i id="product_rate"></i>% off
                        </i>
                    </p>
                </dd>
                <dd class="last">
                    <div class="reviews">
                        <span id="review_data"></span>
                        <span id="review_count"></span>
                    </div>
                    <div id="action_form">
                        <form action="#" method="post" id="formAdd">
                            <input id="product_id" type="hidden" name="id" value="8468"/>
                            <input id="product_items" type="hidden" name="items[]" value="8468"/>
                            <input id="product_type" type="hidden" name="type" value="3"/>
                            <input id="language" type="hidden" name="language" value="<?php echo LANGUAGE; ?>"/>
                            <div class="btn-size" style=" margin-top:20px;">
                                <input type="hidden" name="attributes[Size]" value="" class="s-size" />
                                <div class="selected-box">
                                    <p class="fll">
                                        <span id="select_size">Sélectionner la taille:</span>
                                        <span id="size_span" style="display:none;">Taille: <span id="size_show"></span></span>
                                    </p>
                                </div>
                                <div id="btn_size"></div>
                                <div id="one_size" style="display:none;">
                                    <div class="clearfix">
                                        <ul class="size-list">
                                            <li class="btn-size-normal on-border JS-show" id="one size" data-attr="one size">
                                                <span>taille unique</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-color" style="display:none;">
                                <input type="hidden" name="attributes[Color]" value="" class="s-color" /><div id="select_color" class="mb10">Select Color:</div>
                                <div id="btn_color"></div>
                            </div>
                            <div class="btn-type" style="display:none;">
                                <input type="hidden" name="attributes[Type]" value="" class="s-type" /><div id="select_type" class="mb10">Select Type:</div>
                                <div id="btn_type"></div>
                            </div>
                            <div class="total">
                                <input class="btn btn-primary btn-lg" id="addCart" value="AJOUTER AU PANIER" type="submit">
                                <button class="btn btn-primary btn-lg" disabled="disabled" id="outButton" style="display:none;">OUT OF STOCK</button>
                                <a href="#" class="wishlist" id="addWishList">Liste d’envies (<span id="wishlists" data-lang="<?php echo language; ?>" ></span>ajoutés)</a>
                            </div>
                        </form>
                    </div>
                    <ul class="JS-tab-view detail-tab two-bor" style="margin-top:30px;">
                        <li class="dt-s1 current">DÉTAILS</li>
                        <li class="dt-s1">LIVRAISON</li>
                        <li class="dt-s1">CONTACT</li>
                        <p style="left: 0px;"><b></b></p>
                    </ul>
                    <div class="JS-tabcon-view detail-tabcon">
                        <div class="bd" id="tab-detail">
                            <br>
                            <br>
                            <p>S:Shoulder:37cm,Bust:98cm,Length:62cm,Sleeve Length:55cm
                                <br> M:Shoulder:38cm,Bust:102cm,Length:63cm,Sleeve Length:56cm
                                <br> L:Shoulder:39cm,Bust:106cm,Length:64cm,Sleeve Length:57cm
                                <br>
                            </p>
                            <br>
                            <br>
                            <p>Non-stretchable Material
                                <br> Cotton
                                <br> Wash according to instructions on care label.</p>
                        </div>
                        <div class="bd hide">
                            <p style="color:#F00;">Temps de réception = Temps de traitement + Temps de livraison</p>
                            <h4>Livraison:</h4>
                            <p>(1)  Livraison internationale gratuite (15-20 jours ouvrables)</p>
                            <p style="color:#F00; padding-left:18px;">No minimum purchase required.</p>
                            <p>(2)  <?php echo Site::instance()->price(15, 'code_view'); ?> de Livraison Express (4-7 jours ouvrables)</p>
                            <p style="padding-left:18px;">Consultez les détails dans <a target="_blank" class="red" href="" title="Shipping &amp; Delivery">Expédition & Livraison</a>.</p>
                            <h4>Politique de retour:</h4>
                            <p>Pas satisfait de votre commande, vous pouvez nous contacter et de le retourner dans 60 jours.</p>
                           <p>Pour <span class="red">Maillots de bain</span> et <span class="red">Sous-vêtements</span>, si il n'y a aucun problème de qualité, nous n'offrent pas le service de retour et d'échange, veuillez nous comprendre <a class="a_red" href="<?php echo LANGPATH; ?>/returns-exchange" title="la política de devolución">la politique de retour</a>.</p>
                            <h4>Attention:</h4>
                            <p>Les commandes peuvent être soumises à des droits d'importation, si vous voulez éviter d'être facturé pour l'impôt supplémentaire par la douane locale, veuillez nous contacter, nous allons utiliser Hong Kong Post.</p>
                        </div>
                        <div class="bd hide">
                            <div class="ml10 mt10">
                                <a href="#" onclick="Comm100API.open_chat_window(event, 311);">
                                    <img name="psSMPPimage" src="<?php echo STATICURL; ?>/assets/images/livechat_online1.gif" border="0">LiveChat
                                </a>
                            </div>
                            <div class="ml10 mt10">
                                <a href="mailto:service_fr@choies.com">
                                    <img src="<?php echo STATICURL; ?>/assets/images/livemessage.png" alt="Leave Message"> Laisser un message
                                </a>
                            </div>
                            <div class="ml10 mt10">
                                <a href="<?php echo LANGPATH; ?>/faqs" target="_blank">
                                    <img src="<?php echo STATICURL; ?>/assets/images/faq.png" alt="FAQ"> FAQ
                                </a>
                            </div>
                        </div>
                    </div>
                </dd>
            </dl>
        </div>
    </div>
</div>