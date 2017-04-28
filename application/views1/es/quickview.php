<script src="<?php echo Site::instance()->version_file('/assets/js/catalog.js'); ?>"></script>
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
                        <span class="stock-sp" id="stock">En Stock</span>
                        <span class="stock-sp" style="display: none;" id="outstock" class="hide">Fuera De Stock</span>
                        artículo# : <span id="product_sku"></span>
                        <strong>
                            <a href="" id="product_link">Ver Detalles Completos</a>
                        </strong>
                    </div>
                </dd>
                <dd>
                    <p class="price">
                        <del id="product_s_price"></del>
                        <span id="product_price"></span>
                    </p>
                </dd>
                <dd class="last">
                    <div class="reviews">
                        <span id="review_data"></span>
                        <span id="review_count"></span>
                    </div>
                    <div id="action_form" class="JS-popwincon">
                        <p class="product-note-title" style="display:none;"><span>Please select size!</span><b class="JS-close">&times; </b></p>
                        <form action="#" method="post" id="formAdd">
                            <input id="product_id" type="hidden" name="id" value="8468"/>
                            <input id="product_items" type="hidden" name="items[]" value="8468"/>
                            <input id="product_type" type="hidden" name="type" value="3"/>
                            <input id="language" type="hidden" name="language" value="<?php echo LANGUAGE; ?>"/>
                            <div class="btn-size" style=" margin-top:20px;">
                                <input type="hidden" name="attributes[Size]" value="" class="s-size" />
                                <div class="selected-box">
                                    <p class="fll">
                                        <span id="select_size">Seleccionar Talla :</span>
                                        <span id="size_span" style="display:none;">Talla: <span id="size_show"></span></span>
                                    </p>
                                    <div id="btn_size"></div>
                                </div>     
                                <div id="one_size" style="display:none;">
                                    <div class="clearfix">
                                        <ul class="size-list">
                                            <li class="drop-down-option" id="one size" data-attr="one size">
                                                <a href="javascript:void(0);">talla única</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-color" style="display:none;">
                                <input type="hidden" name="attributes[Color]" value="" class="s-color" /><div id="select_color" class="mb10">Seleccionar Color:</div>
                                <div id="btn_color"></div>
                            </div>
                            <div class="btn-type" style="display:none;">
                                <input type="hidden" name="attributes[Type]" value="" class="s-type" /><div id="select_type" class="mb10">Seleccionar Tipo:</div>
                                <div id="btn_type"></div>
                            </div>
                            <div class="qty-box">
                                <span class="mt10" style="font-weight:bold;">Qty:</span>
                                <input type="number" required="required" value="1" min="1" name="quantity" id="qty" class="text-long text ml10">
                            </div>
                            <div class="total">
                                <input class="btn btn-primary btn-lg" id="addCart" value="AÑADIR A BOLSA" type="submit">
                                <button class="btn btn-primary btn-lg" disabled="disabled" id="outButton" style="display:none;">Fuera de Stock</button>
                                <!-- <a href="#" class="wishlist" id="addWishList">LISTA DE DESEOS  (<span id="wishlists"></span>Add)</a> -->
                                <div style="height:20px;">
                                    <div class="add-success" style="display:none"><i class="fa fa-check"></i>¡Artículo se añadió a la bolsa!</div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <ul class="JS-tab-view detail-tab two-bor" style="margin-top:30px;">
                        <li class="dt-s1 current">DETALLES</li>
                        <li class="dt-s1">Envío</li>
                        <li class="dt-s1">Contacto</li>
                        <p style="left: 0px;"><b></b></p>
                    </ul>
                    <div class="JS-tabcon-view detail-tabcon">
                        <div class="bd" id="tab-detail">
                        </div>
                        <div class="bd hide">
                            <p style="color:#F00;">Tiempo Recibido= tiempo de preparación(3-5 dias laborables) + Duración del transporte</p>
                            <h4>Envío:</h4>
                            <p>(1)  Envío gratuito por todo el mundo(10-15 dias laborables)</p>
                            <p style="color:#F00; padding-left:18px;">Sin compra mínima requerida.</p>
                            <p>(2)  <?php echo Site::instance()->price(15, 'code_view'); ?> El envío expreso(4-7 dias laborables)</p>
                            <p style="padding-left:18px;">Ver más en <a class="red" href="<?php echo LANGPATH; ?>/shipping-delivery" title="envío y entrega">envío y entrega</a>.</p>
                            <h4>La Política De Devolución:</h4>
                            <p>Para <span class="red">traje de baño y ropa interior</span>, si no hay un problema de calidad, no ofrecemos servicio de devolución o cambio <a class="red" href="<?php echo LANGPATH; ?>/returns-exchange" title="la política de devolución">la política de devolución</a>.</p>
                            <h4>Atención Adicional:</h4>
                            <p>Los pedidos pueden estar sujetos a derechos de importación, si usted no quiere pagar el impuesto adicional por su aduana local, póngase en contacto con nosotros, vamos a utilizar Correos de Hong Kong. </p>
                        </div>
                        <div class="bd hide">
                            <div class="ml10 mt10">
                                <a href="#" onclick="openLivechat();return false;">
                                    <img name="psSMPPimage" src="<?php echo STATICURL; ?>/assets/images/livechat_online1.gif" border="0">Live chat
                                </a>
                            </div>
                            <div class="ml10 mt10">
                                <a href="mailto:service_es@choies.com">
                                    <img src="<?php echo STATICURL; ?>/assets/images/livemessage.png" alt="Leave Message"> Dejar Un Mensaje
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