<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="/">HOMEPAGE</a>  >  Kundenrezensionen Verfassen</div>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <?php echo Message::get(); ?>
            <div class="tit"><h2>Kundenrezensionen Verfassen</h2></div>
            <!-- form begin -->
            <dl class="review">
                <dd class="oh">
                    <div class="fll">
                        <a href="<?php echo Product::instance($product_id, LANGUAGE)->permalink(); ?>">
                            <img src="<?php echo Image::link(Product::instance($product_id, LANGUAGE)->cover_image(), 7); ?>" height="180px" />
                        </a>
                    </div>  
                    <div class="fll retit ml35">
                        <h6><?php echo Product::instance($product_id, LANGUAGE)->get('name'); ?></h6>
                        <p>Artikel# : <?php echo Product::instance($product_id, LANGUAGE)->get('sku'); ?></p>
                        <p class="price mt10">
                        <?php
                        $p_price = Product::instance($product_id, LANGUAGE)->get('price');
                        $price = Product::instance($product_id, LANGUAGE)->price();
                        if ($p_price > $price)
                        {
                            $rate =round((($p_price - $price) / $p_price) * 100);
                            ?>
                                <del><span class="orign_price"><?php echo Site::instance()->price($p_price, 'code_view'); ?></span></del>   
                                <span class="price_now">JETZT <?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>  
                                <span class="rate_off"><?php if($rate > 0) echo $rate; ?>% Rabatt</span>
                            <?php
                        }
                        else
                        {
                            ?>
                            
                                PREIS:<span style="font-size:24px;"><?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
                            <?php
                        }
                        ?>
                        </p>
                    </div>
                    <div class="clear"></div>
                    <p class="mt30 font14"><b>REZENSIONEN</b></p>
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
                                <li>Kunde/Kundin ID:<span class="red"><?php echo $user_id; ?></span> Name:<span class="red"><?php echo $firstname; ?></span> <?php echo date('d M Y'); ?></li>
                                <li class="fix">
                                    <label style="width:150px;">Gesamtbewertung:</label>
                                    <ul class="star_ul fl">
                                        <li><a class="one-star" title="Ich hasse es" alt="1" href="#"></a></li>
                                        <li><a class="two-star" title="Ich mag es nicht" alt="2" href="#"></a></li>
                                        <li><a class="three-star" title="Es ist okay" alt="3" href="#"></a></li>
                                        <li><a class="four-star" title="Ich mag es" alt="4" href="#"></a></li>
                                        <li><a class="five-star" title="Ich liebe es" alt="5" href="#"></a></li>
                                    </ul>
                                    <span class="s_result fl">Bitte wählen Sie einen Feedback Wert</span>
                                    <div class="s_result_h hide" color="333">Bitte wählen Sie einen Feedback Wert</div>
                                    <br><input type="hidden" name="overall" id="review_overall" value="" />
                                </li>
                                <li class="fix starbox">
                                    <label style="width:150px;">Qualitätsbewertung: </label>
                                    <ul class="square_ul fl">
                                        <li><a class="square-1" title="Ich hasse es" alt="1" href="#"></a></li>
                                        <li><a class="square-2" title="Ich mag es nicht" alt="2" href="#"></a></li>
                                        <li><a class="square-3" title="Es ist okay" alt="3" href="#"></a></li>
                                        <li><a class="square-4" title="Ich mag es" alt="4" href="#"></a></li>
                                        <li><a class="square-5" title="Ich liebe es" alt="5" href="#"></a></li>
                                    </ul>
                                    <input type="hidden" name="quality" id="review_quality" value="" />
                                    <span class="s_result_square fl">Bitte wählen Sie einen Feedback Wert</span>
                                    <div class="s_result_square_h hide" color="333">Bitte wählen Sie einen Feedback Wert</div>
                                </li>
                                <li class="fix starbox">
                                    <label style="width:150px;">Preis Bewertung: </label>
                                    <ul class="square_ul fl">
                                        <li><a class="square-1" title="Sehr Teuer" alt="1" href="#"></a></li>
                                        <li><a class="square-2" title="Teuer" alt="2" href="#"></a></li>
                                        <li><a class="square-3" title="Vernünftig" alt="3" href="#"></a></li>
                                        <li><a class="square-4" title="Billig" alt="4" href="#"></a></li>
                                        <li><a class="square-5" title="Sehr Billig" alt="5" href="#"></a></li>
                                    </ul>
                                    <input type="hidden" name="price" id="review_price" value="" />
                                    <span class="s_result_square fl">Bitte wählen Sie einen Feedback Wert</span>
                                    <div class="s_result_square_h hide" color="333">Bitte wählen Sie einen Feedback Wert</div>
                                </li>
                                <li class="fix starbox">
                                    <label style="width:150px;">Fitness Bewertung: </label>
                                    <div class="fl">
                                        <input id="fitness_1" type="radio" name="fitness" value="1" >&nbsp;<label style="float:initial;" for="fitness_1">Sehr Klein</label>
                                        <input id="fitness_2" type="radio" name="fitness" value="2" >&nbsp;<label style="float:initial;" for="fitness_2">Klein</label>
                                        <input id="fitness_3" type="radio" name="fitness" value="3" >&nbsp;<label style="float:initial;" for="fitness_3">Neutral</label>
                                        <input id="fitness_4" type="radio" name="fitness" value="4" >&nbsp;<label style="float:initial;" for="fitness_4">Groß</label></label>
                                        <input id="fitness_5" type="radio" name="fitness" value="5" >&nbsp;<label style="float:initial;" for="fitness_5">Sehr Groß</label>
                                    </div>
                                </li>
                            </ul>
                            <ul class="review_ul">
                                <li class="fix ">
                                    <label>Höhe:</label>
                                    <input class="text" type="text" value="" name="height"/> 
                                    <span >CM</span>
                                </li>
                                <li class="fix starbox">
                                    <label>Gewicht: </label>
                                    <input class="text" type="text" value="" name="weight"/> 
                                    <span >KG</span>
                                </li>
                            </ul>
                        </div>
                        <p>Verfassen Sie eine Kundenrezension und Sie werden 100 Choies Punkte bekommen. Sobald Sie Ihre Kundenrezension erfolgreich senden, werden Sie auch eine Chance haben, ein $100 Choies Geschenkkarte jeden Monat zu gewinnen! <a target="_blank" class="red" href="<?php echo LANGPATH; ?>/rate-order-win-100">Erfahren Sie mehr</a> >></p>
                        <p class="mt10">
                            <textarea id="review_text">
Haben Sie Lust auf diese Artikel? Teilen Sie Ihre Meinung mit anderen Modemädchen!
* Einkaufserfahrung (Preis, Passform, Qualität, Lieferzeit, u.s.w.)
* Ihre persönliche Stilberatung oder Outfit Ideen (Was wollen Sie mit diesem Artikel tragen)
Vermeiden: Profanität oder Gehässigkeit , obszöner oder geschmackloser Inhalt, u.s.w. Wir werden Alle Rezensionen vor der Veröffentlichung lesen. Wir behalten uns das Recht vor, einen Rezension nicht zu posten, wenn sie bestimmte Richtlinien nicht erfüllen.
                            </textarea>
                            <textarea name="content" class="hide" id="review_content"></textarea>
                        </p>
                        <p class="top_btn"><input type="button" value="Abbrechen" class="view_btn btn26" /><input type="SUBMIT" value="SENDEN" class="view_btn btn26 btn40"  /></p>
                        <p>Bitte erlauben Sie uns 24 Arbeitsstunden, um diese Rezension zu genehmigen und 100 Punkte für Sie zu  bieten.</p>
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
                    required:"Erforderliches Feld.",
                },
                quality:{
                    required:"Erforderliches Feld.",
                },
                price:{
                    required:"Erforderliches Feld.",
                },
                fitness:{
                    required:"Erforderliches Feld.",
                },
                height:{
                    required:"Erforderliches Feld.",
                },
                weight:{
                    required:"Erforderliches Feld.",
                },
                content:{
                    required:"Erforderliches Feld.",
                    minlength:"Su contenido debe tener al Rabatt 20 caracteres.",
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