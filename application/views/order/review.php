<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="/">Home Page</a>  >  Write a Review</div>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <?php echo Message::get(); ?>
            <div class="tit"><h2>Write a Review</h2></div>
            <!-- form begin -->
            <dl class="review">
                <dd class="oh">
                    <div class="fll">
                        <a href="<?php echo Product::instance($product_id)->permalink(); ?>">
                            <img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 7); ?>" width="120px" height="180px" />
                        </a>
                    </div>  
                    <div class="fll retit ml35">
                        <h6><?php echo Product::instance($product_id)->get('name'); ?></h6>
                        <p>Item# : <?php echo Product::instance($product_id)->get('sku'); ?></p>
                        <p class="price mt10">
                        <?php
                        $p_price = Product::instance($product_id)->get('price');
                        $price = Product::instance($product_id)->price();
                        if ($p_price > $price)
                        {
                            $rate =round((($p_price - $price) / $p_price) * 100);
                            ?>
                                <del><span class="orign_price"><?php echo Site::instance()->price($p_price, 'code_view'); ?></span></del>   
                                <span class="price_now">NOW <?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>  
                                <span class="rate_off"><?php if($rate > 0) echo $rate; ?>% OFF</span>
                            <?php
                        }
                        else
                        {
                            ?>
                            
                                PRICE:<span style="font-size:24px;"><?php echo $currency_change; ?><span class="product_price"><?php echo Site::instance()->price($price, 'code_view'); ?></span></span>
                            <?php
                        }
                        ?>
                        </p>
                    </div>
                    <div class="clear"></div>
                    <p class="mt30 font14"><b>Reviews</b></p>
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
                                <li>Customer ID:<span class="red"><?php echo $user_id; ?></span> Name:<span class="red"><?php echo $firstname; ?></span> <?php echo date('d M Y'); ?></li>
                                <li class="fix">
                                    <label>Overall Rating:</label>
                                    <ul class="star_ul fl">
                                        <li><a class="one-star" title="I hate it" alt="1" href="#"></a></li>
                                        <li><a class="two-star" title="I don’t like it" alt="2" href="#"></a></li>
                                        <li><a class="three-star" title="It’s okay" alt="3" href="#"></a></li>
                                        <li><a class="four-star" title="I like it" alt="4" href="#"></a></li>
                                        <li><a class="five-star" title="I love it" alt="5" href="#"></a></li>
                                    </ul>
                                    <span class="s_result fl">Please select a feedback value</span>
                                    <div class="s_result_h hide" color="333">Please select a feedback value</div>
                                    <br><input type="hidden" name="overall" id="review_overall" value="" />
                                </li>
                                <li class="fix starbox">
                                    <label>Quality Rating: </label>
                                    <ul class="square_ul fl">
                                        <li><a class="square-1" title="I hate it" alt="1" href="#"></a></li>
                                        <li><a class="square-2" title="I don’t like it" alt="2" href="#"></a></li>
                                        <li><a class="square-3" title="It’s okay" alt="3" href="#"></a></li>
                                        <li><a class="square-4" title="I like it" alt="4" href="#"></a></li>
                                        <li><a class="square-5" title="I love it" alt="5" href="#"></a></li>
                                    </ul>
                                    <input type="hidden" name="quality" id="review_quality" value="" />
                                    <span class="s_result_square fl">Please select a feedback value</span>
                                    <div class="s_result_square_h hide" color="333">Please select a feedback value</div>
                                </li>
                                <li class="fix starbox">
                                    <label>Price Rating: </label>
                                    <ul class="square_ul fl">
                                        <li><a class="square-1" title="Very Expensive" alt="1" href="#"></a></li>
                                        <li><a class="square-2" title="Expensive" alt="2" href="#"></a></li>
                                        <li><a class="square-3" title="Reasonable" alt="3" href="#"></a></li>
                                        <li><a class="square-4" title="Cheap" alt="4" href="#"></a></li>
                                        <li><a class="square-5" title="Very Cheap" alt="5" href="#"></a></li>
                                    </ul>
                                    <input type="hidden" name="price" id="review_price" value="" />
                                    <span class="s_result_square fl">Please select a feedback value</span>
                                    <div class="s_result_square_h hide" color="333">Please select a feedback value</div>
                                </li>
                                <li class="fix starbox">
                                    <label>Fitness Rating: </label>
                                    <!-- <ul class="square_ul fl">
                                        <li><a class="square-1" title="Very small" alt="1" href="#"></a></li>
                                        <li><a class="square-2" title="Small" alt="2" href="#"></a></li>
                                        <li><a class="square-3" title="Neutral" alt="3" href="#"></a></li>
                                        <li><a class="square-4" title="Large" alt="4" href="#"></a></li>
                                        <li><a class="square-5" title="Very large" alt="5" href="#"></a></li>
                                    </ul> -->
                                    <div class="fl">
                                        <input id="fitness_1" type="radio" name="fitness" value="1" >&nbsp;<label style="float:initial;" for="fitness_1">Very small</label>
                                        <input id="fitness_2" type="radio" name="fitness" value="2" >&nbsp;<label style="float:initial;" for="fitness_2">Small</label>
                                        <input id="fitness_3" type="radio" name="fitness" value="3" >&nbsp;<label style="float:initial;" for="fitness_3">Neutral</label>
                                        <input id="fitness_4" type="radio" name="fitness" value="4" >&nbsp;<label style="float:initial;" for="fitness_4">Large</label></label>
                                        <input id="fitness_5" type="radio" name="fitness" value="5" >&nbsp;<label style="float:initial;" for="fitness_5">Very large</label>
                                    </div>
                                </li>
                            </ul>
                            <ul class="review_ul">
                                <li class="fix ">
                                    <label>Height:</label>
                                    <input class="text" type="text" value="" name="height"/> 
                                    <span >CM</span>
                                </li>
                                <li class="fix starbox">
                                    <label>Weight: </label>
                                    <input class="text" type="text" value="" name="weight"/> 
                                    <span >KG</span>
                                </li>
                            </ul>
                        </div>
                        <p>Write your review and you will get 100 Choies points. Once you sucessfully submit your review, you'll also be entered for a chance to win a $100 Choies' gift card every month!  <a target="_blank" class="red" href="/rate-order-win-100">Learn more>></a></p>
                        <p class="mt10">
                            <textarea id="review_text">
Do you fancy this item? Share your opinion with other fashion girls! 
* Shopping experience (Price, Fit, Quality, Shipping time, etc)
* Your personal style advice or outfit ideas (What do you wear with this item)
Avoid: profanity or spiteful remarks, obscene or distasteful content,etc. We reads all reviews before posting them. 
We reserve the right not to post a review if it does not meet certain guidelines.
                            </textarea>
                            <textarea name="content" class="hide" id="review_content"></textarea>
                        </p>
                        <p class="top_btn"><input type="button" value="Cancel" class="view_btn btn26" /><input type="SUBMIT" value="SUBMIT" class="view_btn btn26 btn40"  /></p>
                        <p >Please allow 24 working hours for us to approve this review and offer 100 points to you.</p>
                    </form>
                </dd>
            </dl>
        </article>
        <?php echo View::factory('/customer/left'); ?>
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