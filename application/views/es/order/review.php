<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="/">Home Page</a>  >  Escribir un comentario</div>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <?php echo Message::get(); ?>
            <div class="tit"><h2>Escribir un comentario</h2></div>
            <!-- form begin -->
            <dl class="review">
                <dd class="oh">
                    <div class="fll">
                        <a href="<?php echo Product::instance($product_id, LANGUAGE)->permalink(); ?>">
                            <img src="<?php echo Image::link(Product::instance($product_id, LANGUAGE)->cover_image(), 7); ?>" width="120px" height="180px" />
                        </a>
                    </div>  
                    <div class="fll retit ml35">
                        <h6><?php echo Product::instance($product_id, LANGUAGE)->get('name'); ?></h6>
                        <p>Artículo# : <?php echo Product::instance($product_id, LANGUAGE)->get('sku'); ?></p>
                        <p class="price mt10">
                        <?php
                        $p_price = Product::instance($product_id, LANGUAGE)->get('price');
                        $price = Product::instance($product_id, LANGUAGE)->price();
                        if ($p_price > $price)
                        {
                            $rate =round((($p_price - $price) / $p_price) * 100);
                            ?>
                                <del><span class="orign_price"><?php echo Site::instance()->price($p_price, 'code_view'); ?></span></del>   
                                <span class="price_now">AHORA <?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>  
                                <span class="rate_off"><?php if($rate > 0) echo $rate; ?>% MENOS</span>
                            <?php
                        }
                        else
                        {
                            ?>
                            
                                Precio:<span style="font-size:24px;"><?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
                            <?php
                        }
                        ?>
                        </p>
                    </div>
                    <div class="clear"></div>
                    <p class="mt30 font14"><b>Comentarios</b></p>
                </dd>
                <dd class="last">
                    <form class="form form2 review_form" method="post" action="#">
                        <input type="hidden" name="product_id" id="review_product" value="<?php echo $product_id; ?>" />
                        <input type="hidden" name="item_id" id="review_item" value="<?php echo $items['id']; ?>" />
                        <input type="hidden" name="attribute" value="<?php echo $items['attributes']; ?>" />
                        <input type="hidden" name="order_id" value="<?php echo $items['order_id']; ?>" />
                       <div>
                            <ul class="review_ul">
                                <?php
                                $firstname = Customer::instance($user_id)->get('firstname');
                                if(!$firstname)
                                    $firstname = 'Choieser';
                                ?>
                                <li>ID de Cliente:<span class="red"><?php echo $user_id; ?></span> Nombre:<span class="red"><?php echo $firstname; ?></span> <?php echo date('d M Y'); ?></li>
                                <li class="fix">
                                    <label style="width:150px;">Clasificación General:</label>
                                    <ul class="star_ul fl">
                                        <li><a class="one-star" title="Lo detesto" alt="1" href="#"></a></li>
                                        <li><a class="two-star" title="No me gusta" alt="2" href="#"></a></li>
                                        <li><a class="three-star" title="Es bueno" alt="3" href="#"></a></li>
                                        <li><a class="four-star" title="Me gusta" alt="4" href="#"></a></li>
                                        <li><a class="five-star" title="Me encanta" alt="5" href="#"></a></li>
                                    </ul>
                                    <span class="s_result fl">Selecciona un valor real</span>
                                    <div class="s_result_h hide" color="333">Selecciona un valor real</div>
                                    <br><input type="hidden" name="overall" id="review_overall" value="" />
                                </li>
                                <li class="fix starbox">
                                    <label style="width:150px;">Clasificación de Calidad: </label>
                                    <ul class="square_ul fl">
                                        <li><a class="square-1" title="Lo detesto" alt="1" href="#"></a></li>
                                        <li><a class="square-2" title="No me gusta" alt="2" href="#"></a></li>
                                        <li><a class="square-3" title="Es bueno" alt="3" href="#"></a></li>
                                        <li><a class="square-4" title="Me gusta" alt="4" href="#"></a></li>
                                        <li><a class="square-5" title="Me encanta" alt="5" href="#"></a></li>
                                    </ul>
                                    <input type="hidden" name="quality" id="review_quality" value="" />
                                    <span class="s_result_square fl">Selecciona un valor real</span>
                                    <div class="s_result_square_h hide" color="333">Selecciona un valor real</div>
                                </li>
                                <li class="fix starbox">
                                    <label style="width:150px;">Clasificación de Precio: </label>
                                    <ul class="square_ul fl">
                                        <li><a class="square-1" title="Muy Caro" alt="1" href="#"></a></li>
                                        <li><a class="square-2" title="Caro" alt="2" href="#"></a></li>
                                        <li><a class="square-3" title="Razonable" alt="3" href="#"></a></li>
                                        <li><a class="square-4" title="Barato" alt="4" href="#"></a></li>
                                        <li><a class="square-5" title="Bástante  Barato" alt="5" href="#"></a></li>
                                    </ul>
                                    <input type="hidden" name="price" id="review_price" value="" />
                                    <span class="s_result_square fl">Selecciona un valor real</span>
                                    <div class="s_result_square_h hide" color="333">Selecciona un valor real</div>
                                </li>
                                <li class="fix starbox">
                                    <label style="width:150px;">Clasificación de Idoneidad: </label>
                                    <div class="fl">
                                        <input id="fitness_1" type="radio" name="fitness" value="1" >&nbsp;<label style="float:initial;" for="fitness_1">Muy pequeño</label>
                                        <input id="fitness_2" type="radio" name="fitness" value="2" >&nbsp;<label style="float:initial;" for="fitness_2">Pequeño</label>
                                        <input id="fitness_3" type="radio" name="fitness" value="3" >&nbsp;<label style="float:initial;" for="fitness_3">Neutro</label>
                                        <input id="fitness_4" type="radio" name="fitness" value="4" >&nbsp;<label style="float:initial;" for="fitness_4">Grande</label></label>
                                        <input id="fitness_5" type="radio" name="fitness" value="5" >&nbsp;<label style="float:initial;" for="fitness_5">Muy grande</label>
                                    </div>
                                </li>
                            </ul>
                            <ul class="review_ul">
                                <li class="fix ">
                                    <label>Altura:</label>
                                    <input class="text" type="text" value="" name="height"/> 
                                    <span >CM</span>
                                </li>
                                <li class="fix starbox">
                                    <label>Peso: </label>
                                    <input class="text" type="text" value="" name="weight"/> 
                                    <span >KG</span>
                                </li>
                            </ul>
                        </div>
                        <p>Escribe un comentario para obtener 100 puntos de Choies. Una vez que enviar su opinión con éxito, también entrarás para tener la oportunidad de ganar una $ 100 tarjeta de regalo de choies todos los meses!  <a target="_blank" class="red" href="<?php echo LANGPATH; ?>/rate-order-win-100">Ver más>></a></p>
                        <p class="mt10">
                            <textarea id="review_text">
¿Te apetece este artículo? Comparta su opinión con otras chicas de moda. 
* Experiencia de Compras (Precio, Idoneidad, calidad, tiempo de envío, etc)
* Su consejo personal o las ideas del prendas(¿Qué te pones con este artículo?)
Evite: comentarios de blasfemia o rencorosos, contenido obsceno o de mal gusto, etc. Nos leemos todos los comentarios antes de publicarlos.
Nos reservamos el derecho de no publicar un comentario si no cumple con determinadas directrices.
                            </textarea>
                            <textarea name="content" class="hide" id="review_content"></textarea>
                        </p>
                        <p class="top_btn"><input type="button" value="CANCELAR" class="view_btn btn26" /><input type="SUBMIT" value="PRESENTAR" class="view_btn btn26 btn40"  /></p>
                        <p>Por favor permítannos 24 horas de trabajo para aprobarlo y ofrecer 100 puntos a usted entonces.</p>
                    </form>
                </dd>
            </dl>
        </article>
        <?php echo View::factory(LANGPATH . '/customer/left'); ?>
    </section>
</section>

<script type="text/javascript">
        // signin_form 
        $(".form").validate({
            rules: {
                overall: {
                    required: true,
                },
                quality : {
                    required: true,
                },
                price: {
                    required: true,
                },
                fitness: {
                    required: true,
                },
                height: {
                    required: true,
                    number: true,
                },
                weight: {
                    required: true,
                    number: true,
                },
                content: {
                    required: true,
                    minlength: 20,
                    maxlength: 1000,
                }
            },
            messages: {
                overall:{
                    required:"Campo requerido",
                },
                quality:{
                    required:"Campo requerido",
                },
                price:{
                    required:"Campo requerido",
                },
                fitness:{
                    required:"Campo requerido",
                },
                height:{
                    required:"Campo requerido",
                },
                weight:{
                    required:"Campo requerido",
                },
                content:{
                    required:"Campo requerido",
                    minlength:"Su contenido debe tener al menos 20 caracteres.",
                    maxlength:"Su contenido debe tener no más 1000 caracteres.",
                },
            }
        });
    </script>

<script type="text/javascript">
$(function(){
  $("#review_text").live('focusin', function(){
      $(this).addClass('inputfocus');
      if(this.value==this.defaultValue){
          this.value='';
      }
  }).focusout(function(){
      $(this).removeClass('inputfocus');
      if(this.value==''){
          this.value=this.defaultValue;
      }
  })

  $("#review_text").keydown(function(){
      var text = document.getElementById('review_text');
      $("#review_content").val(text.value);
  })
  
  $('.star_ul a').hover(function(){
    $(this).addClass('active-star');
    $('.s_result').css('color','#c00').html($(this).attr('title'));
  },function(){
    $(this).removeClass('active-star');
    $parent = $(this).parent().parent().parent().find('.s_result_h');
    var color = $parent.attr('color');
    var html = $parent.html();
    $('.s_result').css('color','#' + color).html(html);
  });
  
  $('.star_ul a').click(function(){
    var star = $(this).attr('alt');
    $(this).parent().parent().parent().find('input').val(star);
    $(this).parent().parent().parent().find('.error').hide();
    $(this).parent().siblings().find('a').removeClass('actived-star');
    $(this).addClass('actived-star');
    $(this).parent().parent().parent().find('.s_result_h').attr('color','c00').html($(this).attr('title'));
    return false;
  });
  
  $('.square_ul a').hover(function(){
    $(this).addClass('active-square');
    $(this).parents('.starbox').find('.s_result_square').css('color','#c00').html($(this).attr('title'))
  },function(){
    $(this).removeClass('active-square');
    $parent = $(this).parent().parent().parent().find('.s_result_square_h');
    var color = $parent.attr('color');
    var html = $parent.html();
    $(this).parents('.starbox').find('.s_result_square').css('color','#' + color).html(html);
  });
  
  $('.square_ul a').click(function(){
    var square = $(this).attr('alt');
    $(this).parent().parent().parent().find('input').val(square);
    $(this).parent().parent().parent().find('.error').hide();
    $(this).parent().siblings().find('a').removeClass('actived-square');
    $(this).addClass('actived-square');
    $(this).parent().parent().parent().find('.s_result_square_h').attr('color','c00').html($(this).attr('title'));
    return false;
  });
})
</script>