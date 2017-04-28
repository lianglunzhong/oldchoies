<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="/">Home</a>  >  Написать отзыв</div>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <?php echo Message::get(); ?>
            <div class="tit"><h2>Написать отзыв</h2></div>
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
                        <p>Товар# : <?php echo Product::instance($product_id, LANGUAGE)->get('sku'); ?></p>
                        <p class="price mt10">
                        <?php
                        $p_price = Product::instance($product_id, LANGUAGE)->get('price');
                        $price = Product::instance($product_id, LANGUAGE)->price();
                        if ($p_price > $price)
                        {
                            $rate =round((($p_price - $price) / $p_price) * 100);
                            ?>
                                <del><span class="orign_price"><?php echo Site::instance()->price($p_price, 'code_view'); ?></span></del>   
                                <span class="price_now">Теперь <?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>  
                                <span class="rate_off"><?php if($rate > 0) echo $rate; ?>% OFF</span>
                            <?php
                        }
                        else
                        {
                            ?>
                            
                                Цена:<span style="font-size:24px;"><?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
                            <?php
                        }
                        ?>
                        </p>
                    </div>
                    <div class="clear"></div>
                    <p class="mt30 font14"><b>Отзывы покупателей</b></p>
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
                                <li>Идентификатор клиента:<span class="red"><?php echo $user_id; ?></span> Имя:<span class="red"><?php echo $firstname; ?></span> <?php echo date('d M Y'); ?></li>
                                <li class="fix">
                                    <label style="width:150px;">Общий Рейтинг:</label>
                                    <ul class="star_ul fl">
                                        <li><a class="one-star" title="Я этот товар ненавижу" alt="1" href="#"></a></li>
                                        <li><a class="two-star" title="Не Нравится" alt="2" href="#"></a></li>
                                        <li><a class="three-star" title="Неплохо" alt="3" href="#"></a></li>
                                        <li><a class="four-star" title="Нравится" alt="4" href="#"></a></li>
                                        <li><a class="five-star" title="Я этот товар люблю" alt="5" href="#"></a></li>
                                    </ul>
                                    <span class="s_result fl">Пожалуйста, выберите оценку</span>
                                    <div class="s_result_h hide" color="333">Пожалуйста, выберите оценку</div>
                                    <br><input type="hidden" name="overall" id="review_overall" value="" />
                                </li>
                                <li class="fix starbox">
                                    <label style="width:150px;">Рейтинг Качества: </label>
                                    <ul class="square_ul fl">
                                        <li><a class="square-1" title="Я этот товар ненавижу" alt="1" href="#"></a></li>
                                        <li><a class="square-2" title="Не Нравится" alt="2" href="#"></a></li>
                                        <li><a class="square-3" title="EНеплохо" alt="3" href="#"></a></li>
                                        <li><a class="square-4" title="Нравится" alt="4" href="#"></a></li>
                                        <li><a class="square-5" title="Я этот товар люблю" alt="5" href="#"></a></li>
                                    </ul>
                                    <input type="hidden" name="quality" id="review_quality" value="" />
                                    <span class="s_result_square fl">Пожалуйста, выберите оценку</span>
                                    <div class="s_result_square_h hide" color="333">Пожалуйста, выберите оценку</div>
                                </li>
                                <li class="fix starbox">
                                    <label style="width:150px;">Цена Рейтинг: </label>
                                    <ul class="square_ul fl">
                                        <li><a class="square-1" title="Очень дорогие" alt="1" href="#"></a></li>
                                        <li><a class="square-2" title="Дорогие" alt="2" href="#"></a></li>
                                        <li><a class="square-3" title="Разумные" alt="3" href="#"></a></li>
                                        <li><a class="square-4" title="Дешевые" alt="4" href="#"></a></li>
                                        <li><a class="square-5" title="Очень Дешевые" alt="5" href="#"></a></li>
                                    </ul>
                                    <input type="hidden" name="price" id="review_price" value="" />
                                    <span class="s_result_square fl">Пожалуйста, выберите оценку</span>
                                    <div class="s_result_square_h hide" color="333">Пожалуйста, выберите оценку</div>
                                </li>
                                <li class="fix starbox">
                                    <label style="width:150px;">Фитнес-Рейтинг: </label>
                                    <div class="fl">
                                        <input id="fitness_1" type="radio" name="fitness" value="1" >&nbsp;<label style="float:initial;" for="fitness_1" style="width:110px">Очень маленький</label>
                                        <input id="fitness_2" type="radio" name="fitness" value="2" >&nbsp;<label style="float:initial;" for="fitness_2">Маленький</label>
                                        <input id="fitness_3" type="radio" name="fitness" value="3" >&nbsp;<label style="float:initial;" for="fitness_3">Нормальный</label>
                                        <input id="fitness_4" type="radio" name="fitness" value="4" >&nbsp;<label style="float:initial;" for="fitness_4">Большой</label>
                                        <input id="fitness_5" type="radio" name="fitness" value="5" >&nbsp;<label style="float:initial;" for="fitness_5">Очень большой</label>
                                    </div>
                                </li>
                            </ul>
                            <ul class="review_ul">
                                <li class="fix ">
                                    <label>Высота:</label>
                                    <input class="text" type="text" value="" name="height"/> 
                                    <span >См</span>
                                </li>
                                <li class="fix starbox">
                                    <label>Вес: </label>
                                    <input class="text" type="text" value="" name="weight"/> 
                                    <span >Кг</span>
                                </li>
                            </ul>
                        </div>
                        <p>Напишите свой отзыв и вы получите 100 Choies баллов. После того, как вы успешно представить свой отзыв, вы также будете получить шанс выиграть $100 Choies' подарочные карты каждый месяц! <a target="_blank" class="red" href="<?php echo LANGPATH; ?>/rate-order-win-100">Узнать больше</a> >></p>
                        <p class="mt10">
                            <textarea id="review_text">
Вам нравится этот товар? Поделитесь вашим мнением с другими модными девочками! 
* Опыт покупок (Цена,Подгонка,Качество,Время Доставки И Т.Д.) 
* Ваши советы или идеи о одежды в личном стиле (Как вы носите в этом товаре)
Избегать ненормативной лексики или ехидных замечаний,непристойных или неприличных контентов и т.д.Мы будем читать все отзывы, прежде чем отправляем их.
Мы оставляем за собой право не публиковать отзыв, если он не соответствует определенным правилам
                            </textarea>
                            <textarea name="content" class="hide" id="review_content"></textarea>
                        </p>
                        <p class="top_btn"><input type="button" value="Отмена" class="view_btn btn26" /><input type="SUBMIT" value="Дальше" class="view_btn btn26 btn40"  /></p>
                        <p>Пожалуйста, подождите нас 24 рабочих часов, чтобы утвердили этот отзыв и предложение 100 баллов.</p>
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
                    required:"обязательные поля.",
                },
                quality:{
                    required:"обязательные поля.",
                },
                price:{
                    required:"обязательные поля.",
                },
                fitness:{
                    required:"обязательные поля.",
                },
                height:{
                    required:"обязательные поля.",
                },
                weight:{
                    required:"обязательные поля.",
                },
                content:{
                    required:"обязательные поля.",
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