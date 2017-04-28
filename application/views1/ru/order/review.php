<section id="main">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs">
            <div>
                <a href="<?php echo LANGPATH; ?>/">home</a>
                <a href="/" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > Личный кабинет</a> > Написать отзыв
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
                    <h2>Написать отзыв</h2>
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
                            <p>Товар# : <?php echo Product::instance($product_id, LANGUAGE)->get('sku'); ?></p>
                            <p class="price mt10">
                <?php
                $p_price = Product::instance($product_id, LANGUAGE)->get('price');
                $price = Product::instance($product_id, LANGUAGE)->price();
                if ($p_price > $price)
                {
                    $rate =round((($p_price - $price) / $p_price) * 100);
                    ?>
                                <del><span><?php echo Site::instance()->price($p_price, 'code_view'); ?></span></del>
                                <span class="price-now">Теперь<span><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
                                <span><?php if($rate > 0) echo $rate; ?>% OFF</span>
                    <?php
                }
                  else
                {   ?>              
            <span class="price-now">Цена:<span><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
                    <?php
                }
                ?>
                            </p>
                        </div>
                        <p class="sub-tit"><b>Отзывы покупателей</b>
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
                                    <li>Идентификатор клиента:<span class="red"><?php echo $user_id; ?></span>Имя:<span class="red"><?php echo $firstname; ?></span> <?php echo date('d M Y'); ?></li>
                                    <li class="row">
                                        <label class="col-sm-2">Общий Рейтинг:</label>
                                        <ul class="star-ul col-sm-4 col-xs-12 col-xs-offset-1 col-sm-offset-0">
                                <li><a class="one-star" title="Я этот товар ненавижу" alt="1" href="#"></a></li>
                                <li><a class="two-star" title="Не Нравится" alt="2" href="#"></a></li>
                                <li><a class="three-star" title="Неплохо" alt="3" href="#"></a></li>
                                <li><a class="four-star" title="Нравится" alt="4" href="#"></a></li>
                                <li><a class="five-star" title="Я этот товар люблю" alt="5" href="#"></a></li>
                                        </ul>
                                        <span class="s-result col-sm-4 col-xs-12" style="color: rgb(51, 51, 51);">Пожалуйста, выберите оценку</span>
                            <div class="s-result_h hide" color="333">Пожалуйста, выберите оценку</div>
                            <br><input type="hidden" name="overall" id="review_overall" value="" />
                                    </li>
                                    <li class="starbox row">
                                        <label class="col-sm-2">Рейтинг Качества: </label>
                                        <ul class="square-ul col-sm-4 col-xs-12 col-xs-offset-1 col-sm-offset-0">
                                   <li><a class="square-1" title="Я этот товар ненавижу" alt="1" href="#"></a></li>
                                <li><a class="square-2" title="Не Нравится" alt="2" href="#"></a></li>
                                <li><a class="square-3" title="EНеплохо" alt="3" href="#"></a></li>
                                <li><a class="square-4" title="Нравится" alt="4" href="#"></a></li>
                                <li><a class="square-5" title="Я этот товар люблю" alt="5" href="#"></a></li>
                                        </ul>
                            <input type="hidden" name="quality" id="review_quality" value="" />
                                        <span class="s-result-square col-sm-4 col-xs-12" style="color: rgb(51, 51, 51);">Пожалуйста, выберите оценку</span>
                            <div class="s-result-square-h hide" color="333">Пожалуйста, выберите оценку</div>
                                    </li>
                                    <li class="starbox row">
                                        <label class="col-sm-2">Цена Рейтинг: </label>
                                        <ul class="square-ul col-sm-4 col-xs-12 col-xs-offset-1 col-sm-offset-0">
                                <li><a class="square-1" title="Очень дорогие" alt="1" href="#"></a></li>
                                <li><a class="square-2" title="Дорогие" alt="2" href="#"></a></li>
                                <li><a class="square-3" title="Разумные" alt="3" href="#"></a></li>
                                <li><a class="square-4" title="Дешевые" alt="4" href="#"></a></li>
                                <li><a class="square-5" title="Очень Дешевые" alt="5" href="#"></a></li>
                                        </ul>
                            <input type="hidden" name="price" id="review_price" value="" />
                                        <span class="s-result-square col-sm-4 col-xs-12" style="color: rgb(51, 51, 51);">Пожалуйста, выберите оценку</span>
                            <div class="s-result-square-h hide" color="333">Пожалуйста, выберите оценку</div>
                                    </li>
                                    <li class="starbox row">
                                        <label class="col-md-2">Фитнес-Рейтинг:</label>
                                        <ul class="radio-ul">
                                            <li class="col-xs-12 col-md-2 ">
                                                <input type="radio" value="1" name="fitness" id="fitness_1">&nbsp;
                                                <label for="fitness_1" style="float:initial;">Очень маленький</label>
                                            </li>
                                            <li class="col-xs-12 col-md-2">
                                                <input type="radio" value="2" name="fitness" id="fitness_2">&nbsp;
                                                <label for="fitness_2" style="float:initial;">Маленький</label>
                                            </li>
                                            <li class="col-xs-12 col-md-2">
                                                <input type="radio" value="3" name="fitness" id="fitness_3">&nbsp;
                                                <label for="fitness_3" style="float:initial;">Нормальный</label>
                                            </li>
                                            <li class="col-xs-12 col-md-2">
                                                <input type="radio" value="4" name="fitness" id="fitness_4">&nbsp;
                                                <label for="fitness_4" style="float:initial;">Большой</label>
                                            </li>
                                            <li class="col-xs-12 col-md-2">
                                                <input type="radio" value="5" name="fitness" id="fitness_5">&nbsp;
                                                <label for="fitness_5" style="float:initial;">Очень большой</label>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <ul class="review-ul-second">
                                    <li class="row">
                                        <label class="col-sm-2">Высота:</label>
                                        <input type="text" name="height" value="" class="text col-sm-8 col-xs-12">
                                        <span>&nbsp;&nbsp;См</span>
                                    </li>
                                    <li class="starbox row">
                                        <label class="col-sm-2">Вес: </label>
                                        <input type="text" name="weight" value="" class="text col-sm-8 col-xs-12">
                                        <span>&nbsp;&nbsp;Кг</span>
                                    </li>
                                </ul>
                            </div>
                            <p>Напишите свой отзыв и вы получите 100 Choies баллов. После того, как вы успешно представить свой отзыв, вы также будете получить шанс выиграть $100 Choies' подарочные карты каждый месяц! <a href="<?php echo LANGPATH; ?>/rate-order-win-100" class="red" target="_blank">Узнать больше &gt;&gt;</a>
                            </p>
                            <p>
                                <textarea id="review_text">Вам нравится этот товар? Поделитесь вашим мнением с другими модными девочками! 
* Опыт покупок (Цена,Подгонка,Качество,Время Доставки И Т.Д.) 
* Ваши советы или идеи о одежды в личном стиле (Как вы носите в этом товаре)
Избегать ненормативной лексики или ехидных замечаний,непристойных или неприличных контентов и т.д.Мы будем читать все отзывы, прежде чем отправляем их.
Мы оставляем за собой право не публиковать отзыв, если он не соответствует определенным правилам
                                </textarea>
                    <textarea name="content" class="hide" id="review_content"></textarea>
                            </p>
                            <p class="btn-two">
                                <input type="button" class="btn btn-default btn-sm" value="Отмена">
                                <input type="SUBMIT" class="btn btn-primary btn-sm" value="Дальше">
                            </p>
                             <p>Пожалуйста, подождите нас 24 рабочих часов, чтобы утвердили этот отзыв и предложение 100 баллов.</p>
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