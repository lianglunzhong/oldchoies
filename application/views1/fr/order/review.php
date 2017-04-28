<section id="main">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs">
            <div>
                <a href="<?php echo LANGPATH; ?>/">Accueil</a>
                <a href="/" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > Détails De Commande</a> > Ecrire un Commentaire
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
                    <h2>Écrire Un Commentaire</h2>
                </div>
                <dl class="review">
                    <dd class="oh">
                        <div class="pic">
                            <a href="<?php echo Product::instance($product_id, LANGUAGE)->permalink(); ?>">
                                <img src="<?php echo Image::link(Product::instance($product_id, LANGUAGE)->cover_image(), 7); ?>">
                            </a>
                        </div>
                        <div class="retit">
                            <h6><?php echo Product::instance($product_id, LANGUAGE)->get('name'); ?></h6>
                            <p>Article# : <?php echo Product::instance($product_id, LANGUAGE)->get('sku'); ?></p>
                            <p class="price mt10">
                <?php
                $p_price = Product::instance($product_id, LANGUAGE)->get('price');
                $price = Product::instance($product_id, LANGUAGE)->price();
                if ($p_price > $price)
                {
                    $rate =round((($p_price - $price) / $p_price) * 100);
                    ?>
                                <del><span><?php echo Site::instance()->price($p_price, 'code_view'); ?></span></del>
                                <span class="price-now">MAINTENANT<span><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
                                <span><?php if($rate > 0) echo $rate; ?>% DE REDUCTION</span>
                    <?php
                }
                  else
                {   ?>              
            <span class="price-now">Prix:<span><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
                    <?php
                }
                ?>
                            </p>
                        </div>
                        <p class="sub-tit"><b>Commentaires</b>
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
                                    <li>ID Acheteur:<span class="red"><?php echo $user_id; ?></span> Nom:<span class="red"><?php echo $firstname; ?></span> <?php echo date('d M Y'); ?></li>
                                    <li class="row">
                                        <label class="col-sm-2">Note Globale:</label>
                                        <ul class="star-ul col-sm-4 col-xs-12 col-xs-offset-1 col-sm-offset-0">
                               <li><a class="one-star" title="Je le déteste" alt="1" href="#"></a></li>
                                <li><a class="two-star" title="Je ne l'aime pas" alt="2" href="#"></a></li>
                                <li><a class="three-star" title="C'est bon" alt="3" href="#"></a></li>
                                <li><a class="four-star" title="Je l'aime" alt="4" href="#"></a></li>
                                <li><a class="five-star" title="Je l'adore " alt="5" href="#"></a></li>
                                        </ul>
                                        <span class="s-result col-sm-4 col-xs-12" style="color: rgb(51, 51, 51);">Veuillez sélectionner une valeur de feed-back</span>
                            <div class="s-result_h hide" color="333">Veuillez sélectionner une valeur de feed-back</div>
                            <br><input type="hidden" name="overall" id="review_overall" value="" />
                                    </li>
                                    <li class="starbox row">
                                        <label class="col-sm-2">Note de Qualité: </label>
                                        <ul class="square-ul col-sm-4 col-xs-12 col-xs-offset-1 col-sm-offset-0">
                                  <li><a class="square-1" title="Je le déteste" alt="1" href="#"></a></li>
                                <li><a class="square-2" title="Je ne l'aime pas" alt="2" href="#"></a></li>
                                <li><a class="square-3" title="C'est bon" alt="3" href="#"></a></li>
                                <li><a class="square-4" title="Je l'aime" alt="4" href="#"></a></li>
                                <li><a class="square-5" title="Je l'adore" alt="5" href="#"></a></li>
                                        </ul>
                            <input type="hidden" name="quality" id="review_quality" value="" />
                                        <span class="s-result-square col-sm-4 col-xs-12" style="color: rgb(51, 51, 51);">Veuillez sélectionner une valeur de feed-back</span>
                            <div class="s-result-square-h hide" color="333">Veuillez sélectionner une valeur de feed-back</div>
                                    </li>
                                    <li class="starbox row">
                                        <label class="col-sm-2">Note de Prix</label>
                                        <ul class="square-ul col-sm-4 col-xs-12 col-xs-offset-1 col-sm-offset-0">
                               <li><a class="square-1" title="Très Cher" alt="1" href="#"></a></li>
                                <li><a class="square-2" title="Cher" alt="2" href="#"></a></li>
                                <li><a class="square-3" title="Raisonnable" alt="3" href="#"></a></li>
                                <li><a class="square-4" title="Bon marché" alt="4" href="#"></a></li>
                                <li><a class="square-5" title="Très Bon marché" alt="5" href="#"></a></li>
                                        </ul>
                            <input type="hidden" name="price" id="review_price" value="" />
                                        <span class="s-result-square col-sm-4 col-xs-12" style="color: rgb(51, 51, 51);">Veuillez sélectionner une valeur de feed-back</span>
                            <div class="s-result-square-h hide" color="333">Veuillez sélectionner une valeur de feed-back</div>
                                    </li>
                                    <li class="starbox row">
                                        <label class="col-md-2">Note de Taille:</label>
                                        <ul class="radio-ul">
                                            <li class="col-xs-12 col-md-2 ">
                                                <input type="radio" value="1" name="fitness" id="fitness_1">&nbsp;
                                                <label for="fitness_1" style="float:initial;">Très Petit</label>
                                            </li>
                                            <li class="col-xs-12 col-md-2">
                                                <input type="radio" value="2" name="fitness" id="fitness_2">&nbsp;
                                                <label for="fitness_2" style="float:initial;">Petit</label>
                                            </li>
                                            <li class="col-xs-12 col-md-2">
                                                <input type="radio" value="3" name="fitness" id="fitness_3">&nbsp;
                                                <label for="fitness_3" style="float:initial;">Neutre</label>
                                            </li>
                                            <li class="col-xs-12 col-md-2">
                                                <input type="radio" value="4" name="fitness" id="fitness_4">&nbsp;
                                                <label for="fitness_4" style="float:initial;">Grand</label>
                                            </li>
                                            <li class="col-xs-12 col-md-2">
                                                <input type="radio" value="5" name="fitness" id="fitness_5">&nbsp;
                                                <label for="fitness_5" style="float:initial;">Très Grand</label>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <ul class="review-ul-second">
                                    <li class="row">
                                        <label class="col-sm-2">Hauteur:</label>
                                        <input type="text" name="height" value="" class="text col-sm-8 col-xs-12">
                                        <span>&nbsp;&nbsp;CM</span>
                                    </li>
                                    <li class="starbox row">
                                        <label class="col-sm-2">Poids: </label>
                                        <input type="text" name="weight" value="" class="text col-sm-8 col-xs-12">
                                        <span>&nbsp;&nbsp;KG</span>
                                    </li>
                                </ul>
                            </div>
                            <p>Donnez votre commentaire et vous obtiendrez 100 points Choies. Une fois que vous soumettez avec succès votre commentaire, vous serez également inscrit pour une chance de gagner une carte-cadeau de $ 100 de Choies chaque mois! <a href="<?php echo LANGPATH; ?>/rate-order-win-100" class="red" target="_blank">En savoir plus &gt;&gt;</a>
                            </p>
                            <p>
                                <textarea id="review_text">Aimez-vous cet article? Partagez vos opinions avec d'autres filles de la mode. 
* L'expérience d'achat( Prix, Taille, Qualité, Délai de livraison,etc.)
* Vos conseils ou idées personnels(qu'est-ce que vous portez avec cet article)
remarques grossièretés ou malveillantes, contenu obscène ou de mauvais goût, etc. 
Nous lisons tous les commentaires avant de les afficher.
                                </textarea>
                    <textarea name="content" class="hide" id="review_content"></textarea>
                            </p>
                            <p class="btn-two">
                                <input type="button" class="btn btn-default btn-sm" value="ANNULER">
                                <input type="SUBMIT" class="btn btn-primary btn-sm" value="SOUMETTRE">
                            </p>
                            <p>Veuillez nous permettre 24 heures ouvrables pour approuver ce commentaire et vous offrir 100 points.</p>
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
            required:"Ce champ est obligatoire",
        },
        quality:{
            required:"Ce champ est obligatoire",
        },
        price:{
            required:"Ce champ est obligatoire",
        },
        fitness:{
            required:"Ce champ est obligatoire",
        },
        height:{
            required:"Ce champ est obligatoire",
        },
        weight:{
            required:"Ce champ est obligatoire",
        },
        content:{
            required:"Ce champ est obligatoire",
            minlength:"Le contenu doit être au moins 20 caractères.",
            maxlength:"Votre contenu ne doit pas avoir plus de 1000 caractères.",
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