<script type="text/javascript" src="/js/catalog.js"></script>
<script type="text/javascript" src="/js/catalog.loadthumb.js"></script>
<div class="JS_popwincon1 dwrapper hide">
  <a class="JS_close2 close_btn3"></a>
  <div>
    <div class="pro_left fll">
      <div id="myImagesSlideBox" class="fix">
        <div class="myImages fll">
          <a href="#" id="myImgsLink" class="JS_zoom">
            <img src="#" id="picture" class="myImgs" big="#" width="420" />
            </a>
        </div>
        <div id="scrollable" class="flr"> 
          <a href="#" class="b-prev prev3"></a>
          <a href="#" class="b-next next3"></a>
          <div class="items">
            <div class="scrollableDiv fix">   
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="pro_right flr ml35" id="productInfo">
      <dl>
        <dd>
          <h3 id="product_name">Choies Design Limited Fan Fare Floral Print</h3>
          <div class="fix">
          <p style="padding-bottom:12px;color:#999;">
            <span style="margin-right:15px;color:#000;" id="stock">In Stock</span>
            <span style="margin-right:15px;color:#000;" id="outstock" class="hide">Out Of Stock</span>
            Item# : <span id="product_sku" style="margin-right:15px;"></span>
            <span id="jr"><a href="#" id="product_link">View Full details</a></span>
            </p>
            </div>
        </dd>
        <dd class="fix info jiage" >
          <div class="fll font11 ttr">
            <p class="price">
                <span style="text-decoration:line-through" id="product_s_price"></span>
                <span class="red" style="font-size:24px;" id="product_price"></span>
                <i class="red" id="product_rate"></i></p>
          </div>
        </dd>
        <dd class="last">
          <div  class="fix mt10">   
            <span class="fll">
              <span id="review_date"></span>
              <span class="reviews" id="review_count"></span>
            </span>
          </div>
          <div id="action-form">
          <form action="#" method="post" id="formAdd">
            <input id="product_id" type="hidden" name="id" value="8468"/>
            <input id="product_items" type="hidden" name="items[]" value="8468"/>
            <input id="product_type" type="hidden" name="type" value="3"/>
            <div class="btn_size"></div>
            <div class="btn_color"></div>
            <div class="btn_type"></div>
             <div class="total">
              <input type="submit" style="font-size: 18px;" class="btn40_16_red" id="addCart" value="ADD TO BAG">
              <a href="#" class="view_btn btn40_1" style="margin-top:-6px;background: none;border: none;text-decoration: underline;" id="addWishList">my wishlist  (<span id="wishlists"></span>Add)</a>
             </div> 
          </form>
          </div>
          <ul class="JS_tab detail_tab detail_tab2 fix">
            <li class="ss1 current" style="width: 90px;margin: 0 0 -1px 0;">DETAILS</li>
            <li class="ss2" style="width: 90px;margin: 0 0 -1px 0;">MODEL INFO</li>
            <li class="ss3" style="width: 90px;margin: 0 0 -1px 0;">DELIVERY</li>
            <li class="ss4" style="width: 90px;margin: 0 0 -1px 0;">CONTACT</li>
            <p><b></b></p>
          </ul>
          <div class="JS_tabcon detail_tabcon detail_tabcon2">
            <div class="bd" id="tab-detail"></div>
            <div class="bd hide" id="tab-model"></div>
            <div class="bd hide">
                <p style="color:#F00;">Receiving time = Processing time（3-5 working days）+ Shipping time</p>
                <h4>Shipping:</h4>
                <p>(1)  Free shipping worldwide (10-15 working days)</p>
                <p style="color:#F00; padding-left:18px;">No minimum purchase required.</p>
                <p>(2)  $ 15 Express Shipping(4-7 working days)</p>
                <p style="padding-left:18px;">Check details in <a target="_blank" class="a_red" href="http://www.choies.com/shipping-delivery" title="Shipping &amp; Delivery">Shipping &amp; Delivery</a>.</p>
                <h4>Return Policy:</h4>
                <p>Not satisfied with your order, you can contact us and return it in 60 days. </p>
                <p>For <span class="red">Swimwear and Underwear</span>, if there is no quality problem, we do not offer return & exchange service, please understand. Check details in <a target="_blank" class="a_red" href="http://www.choies.com/returns-exchange" title="return policy">return policy</a></p>
                <h4>Extra Attention:</h4>
                <p>Orders may be subject to import duties, if you want to avoid being charged for extra tax by your local custom, please contact us, we will use HongKong Post.</p>
            </div>
            <div class="bd hide">
                <div class="LiveChat2 mt15 pl10">
                    <a href="#" onclick="psSMPPow(); return false;"><img name="psSMPPimage" src="http://www.choies.com/images/livechat_online1.gif" border="0" /> LiveChat</a>
                </div>
                <div class="LiveChat2 mt10 pl10"><a href="mailto:<?php echo Site::instance()->get('email'); ?>"><img src="/images/livemessage.png" alt="Leave Message" /> Leave Message</a></div>
                <div class="LiveChat2 mt10 pl10"><a href="<?php echo LANGPATH; ?>/faqs" target="_blank"><img src="/images/faq.png" alt="FAQ" /> FAQ</a></div>
            </div>
          </div>
        </dd>
      </dl>
    </div>
  </div>
</div> 
<script>
$(function(){
  $("#jr").click(function(){
   if($(".jr").hasClass("jrgd")){
   $(".jr").removeClass("jrgd");
   $('#jr').text("hide details");
   }else{
   $(".jr").addClass("jrgd");
   $('#jr').text("View Full details");
  } 
  }) 
});
$(function(){   
    $(".search_box .dselect").hover( function () {
        $(this).addClass("dselect_over");
    },function () {
        $(this).removeClass("dselect_over");
    }).on('click',function(){
        var _this = $(this),
            _bthis = $(this).find(".list");
        if ( _this.attr('isopen') ) {
            _bthis.slideUp(200 , function(){
                _this.removeAttr('isopen');
            });         
        } else {
            _bthis.slideDown(200,function(){
                _this.attr('isopen',"1");
            }); 
        }
    }).on('mouseleave',function(){
        var _thisa = $(this).find(".list"),
            _this = $(this);
        _thisa.hide();
        _this.removeAttr('isopen');
    }),$(this).find(".list li").hover( function (){
        $(this).addClass("sel");        
    },function (){
        $(this).removeClass("sel"); 
    }).on('click',function(){
        var _this = $(this).html();
        var _thisText = $(this).closest(".dselect").find(".text");
        _thisText.html(_this);
    })
});
$(".JS_close2,.JS_filter1").live("click",function(){
    $(".JS_filter1").remove();
    $('.JS_popwincon1').fadeOut(160);
    return false;
})
$(function(){
    $('.detail_tab2 li').mouseover(function(){
        var liindex = $('.detail_tab2 li').index(this);
        $(this).addClass('current').siblings().removeClass('current');
        $('.detail_tabcon2 div.bd').eq(liindex).fadeIn(150).siblings('div.bd').stop().hide();
        var liWidth = $('.detail_tab2 li').width();
        $('.last .detail_tab2 p').stop(false,true).animate({'left' : liindex * liWidth + 'px'},300);
    });
    });
</script> 