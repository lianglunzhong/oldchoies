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
                    <h3 id="product_name"></h3>
                    <div class="pro-stock">
                        <span class="stock-sp" id="stock">Auf Lager</span>
                        <span class="stock-sp" style="display: none;" id="outstock" class="hide">Ausverkauft</span>
                        Artikel# : <span id="product_sku"></span>
                        <strong>
                            <a href="" id="product_link">VOLLSTÄNDIGE DETAILS SEHEN</a>
                        </strong>
                    </div>
                </dd>
                <dd>
                    <p class="price">
                        <del id="product_s_price"></del>
                        <span class="red" id="product_price"></span>
                        <i class="red" id="product_rate_show" style="display:none;">
                            <i id="product_rate"></i>% Rabatt
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
                                        <span id="select_size">Größe Wählen:</span>
                                        <span id="size_span" style="display:none;">Größe: <span id="size_show"></span></span>
                                    </p>
                                </div>
                                <div id="btn_size"></div>
                                <div id="one_size" style="display:none;">
                                    <div class="clearfix">
                                        <ul class="size-list">
                                            <li class="btn-size-normal on-border JS-show" id="one size" data-attr="one size">
                                                <span>Eine Größe</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-color" style="display:none;">
                                <input type="hidden" name="attributes[Color]" value="" class="s-color" /><div id="select_color" class="mb10">Farbe Wählen:</div>
                                <div id="btn_color"></div>
                            </div>
                            <div class="btn-type" style="display:none;">
                                <input type="hidden" name="attributes[Type]" value="" class="s-type" /><div id="select_type" class="mb10">Typ Wählen:</div>
                                <div id="btn_type"></div>
                            </div>
                            <div class="total">
                                <input class="btn btn-primary btn-lg" id="addCart" value="IN DEN WARENKORB" type="submit">
                                <button class="btn btn-primary btn-lg" disabled="disabled" id="outButton" style="display:none;">OAusverkauft</button>
                                <a href="#" class="wishlist" id="addWishList">MEINE WUNSCHLISTE  (<span id="wishlists"></span>ADDIEREN)</a>
                            </div>
                        </form>
                    </div>
                    <ul class="JS-tab-view detail-tab two-bor" style="margin-top:30px;">
                        <li class="dt-s1 current">DETAILS</li>
                        <li class="dt-s1">Lieferung</li>
                        <li class="dt-s1">KONTAKT</li>
                        <p style="left: 0px;"><b></b></p>
                    </ul>
                    <div class="JS-tabcon-view detail-tabcon">
                        <div class="bd" id="tab-detail">
                        </div>
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
                        </div>
                        <div class="bd hide">
                            <div class="ml10 mt10">
                                <a href="#" onclick="Comm100API.open_chat_window(event, 311);">
                                    <img name="psSMPPimage" src="<?php echo STATICURL; ?>/assets/images/livechat_online1.gif" border="0">LiveChat
                                </a>
                            </div>
                            <div class="ml10 mt10">
                                <a href="mailto:service_de@choies.com">
                                    <img src="<?php echo STATICURL; ?>/assets/images/livemessage.png" alt="Leave Message"> Eine Nachricht hinterlassen
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