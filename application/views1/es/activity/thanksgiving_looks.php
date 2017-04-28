<style>
.thanksgiving-looks{
    margin: 0 auto;
    width: 1024px;
    background-color:#ffffff;
}
.clothes-looks {
    margin-left:35px;
    overflow: hidden;
}
.clothes-looks li {
    float: left;
    margin-right: 17px;
    margin-top: 30px;
    overflow: hidden;
    width: 225px;
}
.ski {
    margin-top: 10px;
    height:20px;
    overflow: hidden;
    width:225px;
}
.ski a{float:left;}
.ski span{float:right;}
.clothes-looks li .vi {
    font-size: 14px;
    text-decoration: underline;
}
.clothes-looks li .ge {
    background-color: #000;
    color: #fff;
    cursor: pointer;
    float: right;
    padding: 0 5px;
}
a:hover{color:#666;}
</style>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  THANKSGIVING LOOKS</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <div class="thanksgiving-looks">

    <div class="thanksgiving-top"><img src="<?php echo STATICURL; ?>/ximg/activity/thanksgivinglooks/thanksgivinglooks-top.jpg"></div>
    <div class="thanksgiving-looks1">
      <p><img src="<?php echo STATICURL; ?>/ximg/activity/thanksgivinglooks/thanksgivinglooks1.jpg"></p>
      <ul class="clothes-looks">
            <?php foreach ($data_1 as $value) { ?>
            <li>
                <div>
                    <a href="<?php echo $value['product_url'];?>" target="_blank">
                        <img src="<?php echo $value['image'];?>">
                    </a>
                </div>
                <div class="ski">
                    <a class="vi" href="<?php echo $value['product_url'];?>" target="_blank">View Detail >></a>
                    <span class="ge JS_popwinbtn4" onclick="load_data('<?php echo $value['link_sku'];?>')" title="">Get the Look </span>
                </div>
            </li>
            <?php } ?>
      </ul>
    </div>
    <div class="thanksgiving-looks2">
        <p><img src="<?php echo STATICURL; ?>/ximg/activity/thanksgivinglooks/thanksgivinglooks2.jpg" usemap="#Map" border="0">
          <map name="Map">
            <area shape="rect" coords="313,13,710,110" href="/warm-things" target="_blank">
          </map>
        </p>
         <ul class="clothes-looks">
            <?php foreach ($data_2 as $value) { ?>
            <li>
                <div>
                    <a href="<?php echo $value['product_url'];?>" target="_blank">
                        <img src="<?php echo $value['image'];?>">
                    </a>
                </div>
                <div class="ski">
                    <a class="vi" href="<?php echo $value['product_url'];?>" target="_blank">View Detail >></a>
                    <span class="ge JS_popwinbtn4" onclick="load_data('<?php echo $value['link_sku'];?>')" title="">Get the Look </span>
                </div>
           </li>
            <?php } ?>
      </ul>
    </div>
    <div class="thanksgiving-looks3">
        <p><img src="<?php echo STATICURL; ?>/ximg/activity/thanksgivinglooks/thanksgivinglooks3.jpg" usemap="#Map2" border="0">
          <map name="Map2">
            <area shape="rect" coords="285,30,760,134" href="/family-gathering" target="_blank">
          </map>
        </p>
        <ul class="clothes-looks">
            <?php foreach ($data_3 as $value) { ?>
            <li>
                <div>
                    <a href="<?php echo $value['product_url'];?>" target="_blank">
                        <img src="<?php echo $value['image'];?>">
                    </a>
                </div>
                <div class="ski">
                    <a class="vi" href="<?php echo $value['product_url'];?>" target="_blank">View Detail >></a>
                    <span class="ge JS_popwinbtn4" onclick="load_data('<?php echo $value['link_sku'];?>')" title="">Get the Look </span>
                </div>
            </li>
            <?php } ?>
      </ul>
    </div>
    <div><img src="<?php echo STATICURL; ?>/ximg/activity/thanksgivinglooks/thanksgivinglooks4.jpg" usemap="#Map3" border="0">
      <map name="Map3">
        <area shape="rect" coords="316,16,721,122" href="/homecoming-dress" target="_blank">
      </map>
    </div>
</div>
</section>

<script type="text/javascript">
function load_data(skus){
    $.post(
        '/activity/ajax_skirt_looks',
        {
            skus:skus,
        },
        function (data) {
            var item = eval(data)
            var str = "";
            var wishlist = new Array();
            for (var i = item.length - 1; i >= 0; i--) {
                wishlist.push(item[i]['product_id'])
                var price = "";
                if(item[i]['orig_price']){
                    price = "<del>"+item[i]['orig_price']+"</del><br><b class='red font18'>"+item[i]['curr_price']+"</b>";
                }else{
                    price = "<b class='red font18'>"+item[i]['curr_price']+"</b>";
                }
                str += '<li><input type="checkbox" name="check['+item[i]['n']+']" title="size'+item[i]['n']+'" class="checkbox" checked="checked" id="checkout'+item[i]['product_id']+'" /> <label for="checkout'+item[i]['product_id']+'">Add to Bag</label><input type="hidden" name="item['+item[i]['n']+']" value="'+item[i]['product_id']+'" /><a href="'+item[i]['sku_link']+'"><img src="'+item[i]['img_src']+'" /></a><a href="'+item[i]['sku_link']+'" class="name">'+item[i]['product_name']+'</a><p class="price">'+price+'</p>'+item[i]['options']+'<p class="center"><a href="'+item[i]['sku_link']+'" class="btn22_gray" target="_blank">View Full Details</a></p></li>';
            };
            wishlist_href = wishlist.join('-');
            $('.add_wishlist').attr('href','/wishlist/add_more/'+wishlist_href)
            $('.scrollableDiv1').html(str)
        },
        'json'
    )
}
</script>

<div class="JS_popwincon4 popwincon hide">
    <a class="JS_close5 close_btn2"></a>
    <!-- look_box -->
    <div class="look_pro">
        <form action="/cart/add_more" method="post" class="form3" id="form">
            <input type="hidden" name="page" value="product" />
            <div class="items">
                <ul class="scrollableDiv1 scrollableDivs fix"></ul>
            </div>
            <div class="center mt50">
                <input type="submit" value="ADD TO BAG" class="btn40_16_red" /><a href="" class="a_underline add_wishlist">Add to wishlist</a>
            </div>
        </form>
        <script>
            $("#form").validate({
                rules: {
                    size0: {
                        required: true
                    },
                    size1: {
                        required: true
                    },
                    size2: {
                        required: true
                    },
                    size3: {
                        required: true
                    },
                    size4: {
                        required: true
                    },
                    size5: {
                        required: true
                    },
                    size6: {
                        required: true
                    },
                    size7: {
                        required: true
                    }
                }
            })
            $(function(){
                $(".form3 .checkbox").live("click",function(){
                    var ck = $(this).attr('checked');
                    if(ck == 'checked')
                    {
                        var title = $(this).attr('title');
                        $(this).parent().find('.size_input').attr('name', title);
                    }
                    else
                    {
                        $(this).parent().find('.size_input').attr('name', '');
                    }
                })
                
                $(".size_select").live("change",function(){
                    var val = $(this).val();
                    $(this).parent().find(".size_input").val(val);
                })
                
                var i = 1;  
                var m = 1;  
                var $content = $(".scrollableDivs");
                var count = ($content.find("li").length)-4;
                $(".look_pro .nexts").live("click",function(){
                    var $scrollableDiv = $(this).siblings(".items").find(".scrollableDivs");
                    if( !$scrollableDiv.is(":animated")){
                        if(m<count){ 
                            m++;
                            $scrollableDiv.animate({left: "-=175px"});
                        }
                    }
                    return false;
                });
                
                //上一张
                $(".look_pro .prevs").live("click",function(){
                    var $scrollableDiv = $(this).siblings(".items").find(".scrollableDivs");
                    if( !$scrollableDiv.is(":animated")){
                        if(m>i){ 
                            m--;
                            $scrollableDiv.animate({left: "+=175px"});
                        }
                    }
                    return false;
                });
            })
        </script>
    </div>
</div>
