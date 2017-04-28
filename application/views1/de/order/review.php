<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/">HOMEPAGE</a>
				<a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > KONTOÜBERSICHT</a> > Kundenrezensionen Verfassen
			</div>
           <?php echo Message::get(); ?>
		</div>
	</div>
	<!-- main-middle begin -->
	<div class="container">
		<div class="row">
<?php echo View::factory(LANGPATH . '/customer/left'); ?>
<?php echo View::factory(LANGPATH . '/customer/left_1'); ?>
			<article class="user col-sm-9 col-xs-12">
				<div class="tit">
					<h2>Kundenrezensionen Verfassen</h2>
				</div>
				<dl class="review">
					<dd class="oh">
						<div class="pic">
							<a href="<?php echo Product::instance($product_id ,LANGUAGE)->permalink(); ?>">
								<img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 7); ?>">
							</a>
						</div>
						<div class="retit">
							<h6><?php echo Product::instance($product_id, LANGUAGE)->get('name'); ?></h6>
							<p>Artikel# : <?php echo Product::instance($product_id)->get('sku'); ?></p>
							<p class="price mt10">
                <?php
                $p_price = Product::instance($product_id)->get('price');
                $price = Product::instance($product_id)->price();
                if ($p_price > $price)
                {
                    $rate =round((($p_price - $price) / $p_price) * 100);
                    ?>
								<del><span><?php echo Site::instance()->price($p_price, 'code_view'); ?></span></del>
								<span class="price-now">JETZT <span><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
								<span><?php if($rate > 0) echo $rate; ?>% RABATT</span>
                    <?php
                }
				                        else
                { 	?>				
			<span class="price-now">PREIS:<span><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
                    <?php
                }
                ?>
							</p>
						</div>
						<p class="sub-tit"><b>REZENSIONEN</b>
						</p>
					</dd>
					<dd>
						<form action="#" method="post" class="form form2 review-form">
                <input type="hidden" name="product_id" id="review_product" value="<?php echo $product_id; ?>" />
                <input type="hidden" name="item_id" id="review_item" value="<?php echo $items['id']; ?>" />
                <input type="hidden" name="attribute" value="<?php echo $items['attributes']; ?>" />
                <input type="hidden" name="order_id" value="<?php echo $items['order_id']; ?>" />
							<div>
								<ul class="review-ul">
                        <?php
                        $firstname = Customer::instance($user_id)->get('firstname');
                        if(!$firstname)
                            $firstname = 'Choieser';
                        ?>
									<li>Kunde/Kundin ID:<span class="red"><?php echo $user_id; ?></span> Name:<span class="red"><?php echo $firstname; ?></span> <?php echo date('d M Y'); ?></li>
									<li class="row">
										<label class="col-sm-2">Gesamtbewertung:</label>
										<ul class="star-ul col-sm-4 col-xs-12 col-xs-offset-1 col-sm-offset-0">
											<li><a class="one-star" title="Ich hasse es" alt="1" href="#"></a></li>
	                                        <li><a class="two-star" title="Ich mag es nicht" alt="2" href="#"></a></li>
	                                        <li><a class="three-star" title="Es ist okay" alt="3" href="#"></a></li>
	                                        <li><a class="four-star" title="Ich mag es" alt="4" href="#"></a></li>
	                                        <li><a class="five-star" title="Ich liebe es" alt="5" href="#"></a></li>
										</ul>
										<span class="s-result col-sm-4 col-xs-12" style="color: rgb(51, 51, 51);">Bitte wählen Sie einen Feedback Wert</span>
                            <div class="s-result_h hide" color="333">Bitte wählen Sie einen Feedback Wert</div>
                            <br><input type="hidden" name="overall" id="review_overall" value="" />
									</li>
									<li class="starbox row">
										<label class="col-sm-2">Qualitätsbewertung: </label>
										<ul class="square-ul col-sm-4 col-xs-12 col-xs-offset-1 col-sm-offset-0">
											<li><a class="square-1" title="Ich hasse es" alt="1" href="#"></a></li>
	                                        <li><a class="square-2" title="Ich mag es nicht" alt="2" href="#"></a></li>
	                                        <li><a class="square-3" title="Es ist okay" alt="3" href="#"></a></li>
	                                        <li><a class="square-4" title="Ich mag es" alt="4" href="#"></a></li>
	                                        <li><a class="square-5" title="Ich liebe es" alt="5" href="#"></a></li>
										</ul>
                            <input type="hidden" name="quality" id="review_quality" value="" />
										<span class="s-result-square col-sm-4 col-xs-12" style="color: rgb(51, 51, 51);">Bitte wählen Sie einen Feedback Wert</span>
                            <div class="s-result-square-h hide" color="333">Bitte wählen Sie einen Feedback Wert</div>
									</li>
									<li class="starbox row">
										<label class="col-sm-2">Preis Bewertung: </label>
										<ul class="square-ul col-sm-4 col-xs-12 col-xs-offset-1 col-sm-offset-0">
											<li><a class="square-1" title="Sehr Teuer" alt="1" href="#"></a></li>
	                                        <li><a class="square-2" title="Teuer" alt="2" href="#"></a></li>
	                                        <li><a class="square-3" title="Vernünftig" alt="3" href="#"></a></li>
	                                        <li><a class="square-4" title="Billig" alt="4" href="#"></a></li>
	                                        <li><a class="square-5" title="Sehr Billig" alt="5" href="#"></a></li>
											</li>
										</ul>
                            <input type="hidden" name="price" id="review_price" value="" />
										<span class="s-result-square col-sm-4 col-xs-12" style="color: rgb(51, 51, 51);">Bitte wählen Sie einen Feedback Wert</span>
                            <div class="s-result-square-h hide" color="333">Bitte wählen Sie einen Feedback Wert</div>
									</li>
									<li class="starbox row">
										<label class="col-md-2">Fitness Bewertung: </label>
										<ul class="radio-ul">
											<li class="col-xs-12 col-md-2 "><input id="fitness_1" type="radio" name="fitness" value="1" >&nbsp;<label style="float:initial;" for="fitness_1">Sehr Klein</label></li>
	                                        <li class="col-xs-12 col-md-2 "><input id="fitness_2" type="radio" name="fitness" value="2" >&nbsp;<label style="float:initial;" for="fitness_2">Klein</label></li>
	                                        <li class="col-xs-12 col-md-2 "><input id="fitness_3" type="radio" name="fitness" value="3" >&nbsp;<label style="float:initial;" for="fitness_3">Neutral</label></li>
	                                        <li class="col-xs-12 col-md-2 "><input id="fitness_4" type="radio" name="fitness" value="4" >&nbsp;<label style="float:initial;" for="fitness_4">Groß</label></label></li>
	                                        <li class="col-xs-12 col-md-2 "><input id="fitness_5" type="radio" name="fitness" value="5" >&nbsp;<label style="float:initial;" for="fitness_5">Sehr Groß</label></li>
										</ul>
									</li>
								</ul>
								<ul class="review-ul-second">
									<li class="row">
										<label class="col-sm-2">Höhe:</label>
										<input type="text" name="height" value="" class="text col-sm-8 col-xs-12">
										<span>&nbsp;&nbsp;CM</span>
									</li>
									<li class="starbox row">
										<label class="col-sm-2">Gewicht: </label>
										<input type="text" name="weight" value="" class="text col-sm-8 col-xs-12">
										<span>&nbsp;&nbsp;KG</span>
									</li>
								</ul>
							</div>
                			<p>Verfassen Sie eine Kundenrezension und Sie werden 100 Choies Punkte bekommen. Sobald Sie Ihre Kundenrezension erfolgreich senden, werden Sie auch eine Chance haben, ein $100 Choies Geschenkkarte jeden Monat zu gewinnen! <a target="_blank" class="red" href="<?php echo LANGPATH; ?>/rate-order-win-100">Erfahren Sie mehr</a> >></p>
							<p>
								<textarea id="review_text">
Haben Sie Lust auf diese Artikel? Teilen Sie Ihre Meinung mit anderen Modemädchen!
* Einkaufserfahrung (Preis, Passform, Qualität, Lieferzeit, u.s.w.)
* Ihre persönliche Stilberatung oder Outfit Ideen (Was wollen Sie mit diesem Artikel tragen)
Vermeiden: Profanität oder Gehässigkeit , obszöner oder geschmackloser Inhalt, u.s.w. Wir werden Alle Rezensionen vor der Veröffentlichung lesen. Wir behalten uns das Recht vor, einen Rezension nicht zu posten, wenn sie bestimmte Richtlinien nicht erfüllen.
                    			</textarea>
                    <textarea name="content" class="hide" id="review_content"></textarea>
							</p>
							<p class="btn-two">
								<input type="button" class="btn btn-default btn-sm" value="Abbrechen">
								<input type="SUBMIT" class="btn btn-primary btn-sm" value="SENDEN">
							</p>
                			<p>Bitte erlauben Sie uns 24 Arbeitsstunden, um diese Rezension zu genehmigen und 100 Punkte für Sie zu  bieten.</p>
						</form>
					</dd>
				</dl>

			</article>

		</div>
	</div>
</section>

<script type="text/javascript">
	 // signin_form 
	$(".form").validate({
		rules: {
			overall: {
				required: true,
			},
			quality: {
				required: true,
			},
			price: {
				required: true,
			},
			fitness: {
				required: true,
			},
			Höhe: {
				required: true,
				number: true,
			},
			Gewicht: {
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
  
		$('.star-ul a').hover(function() {
					$(this).addClass('active-star');
					$('.s-result').css('color', '#c00').html($(this).attr('title'))
				}, function() {
					$(this).removeClass('active-star');
			$parent = $(this).parent().parent().parent().find('.s-result_h');
    var color = $parent.attr('color');
    var html = $parent.html();
    $('.s-result').css('color','#' + color).html(html);
				});
  
  $('.star-ul a').click(function(){
    var star = $(this).attr('alt');
    $(this).parent().parent().parent().find('input').val(star);
    $(this).parent().parent().parent().find('.error').hide();
    $(this).parent().siblings().find('a').removeClass('actived-star');
    $(this).addClass('actived-star');
    $(this).parent().parent().parent().find('.s-result_h').attr('color','c00').html($(this).attr('title'));
    return false;
  });
  
  $('.square-ul a').hover(function(){
    $(this).addClass('active-square');
    $(this).parents('.starbox').find('.s-result-square').css('color','#c00').html($(this).attr('title'))
  },function(){
    $(this).removeClass('active-square');
    $parent = $(this).parent().parent().parent().find('.s-result-square-h');
    var color = $parent.attr('color');
    var html = $parent.html();
    $(this).parents('.starbox').find('.s-result_square').css('color','#' + color).html(html);
  });
  
  $('.square-ul a').click(function(){
    var square = $(this).attr('alt');
    $(this).parent().parent().parent().find('input').val(square);
    $(this).parent().parent().parent().find('.error').hide();
    $(this).parent().siblings().find('a').removeClass('actived-square');
    $(this).addClass('actived-square');
    $(this).parent().parent().parent().find('.s-result_square_h').attr('color','c00').html($(this).attr('title'));
    return false;
  });
})
</script>