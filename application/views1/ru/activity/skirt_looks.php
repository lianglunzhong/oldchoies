<style>
.ski{ margin:15px; overflow:hidden}
.skirt li .vi{ font-size:14px; text-decoration:underline; }
.skirtban{ margin:20px 0 20px 40px;}
</style>
<div class="site-content">
    <div class="main-container clearfix">
        <div class="container">
            <div class="crumbs">
                <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  SKIRTS</div>
            </div>
            <?php echo Message::get(); ?>
            <div id="homeBigBanner" class="flexslider">
                <ul class="slides">
                    <li>
                        <img src="<?php echo STATICURL; ?>/ximg/activity/skirt_looks/<?php echo LANGUAGE; ?>_skirt_look.jpg" border="0" />
                    </li>
                </ul>
            </div>
            <div class="pro-list">
                <ul class="row skirt">
                    <?php foreach ($data as $value) { ?>
                    <li class="pro-item col-xs-6 col-sm-3">
                        <div><a target="_blank" href="<?php echo $value['product_url'];?>"><img src="<?php echo $value['image'];?>" /></a></div>
                        <div class="ski"><a class="vi" target="_blank" href="<?php echo $value['product_url'];?>">Деталь >></a><a data-reveal-id="myModal" class="flr btn btn-default btn-xs hidden-xs" title="<?php echo $value['link_sku'];?>" onclick="load_data('<?php echo $value['link_sku'];?>')" >Другие В Фото </a></div>
                    </li>
                    <?php } ?>
                </ul>
                  <div class="skirtban"><a target="_blank" href="<?php echo LANGPATH; ?>/skirt-c-99"><img src="<?php echo STATICURL; ?>/ximg/activity/skirt_looks/skirt-09.jpg" /></a></div>                  
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function load_data(skus){
    $.post(
        '/activity/ajax_skirt_looks?lang=<?php echo LANGUAGE; ?>',
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
                    price = "<del>"+item[i]['orig_price']+"</del><b class='red font18'>"+item[i]['curr_price']+"</b>";
                }else{
                    price = "<b class='red font18'>"+item[i]['curr_price']+"</b>";
                }
                str += '<li><input type="checkbox" name="check['+item[i]['n']+']" title="size'+item[i]['n']+'" class="checkbox" checked="checked" id="checkout'+item[i]['product_id']+'" /> <label for="checkout'+item[i]['product_id']+'">Добавить</label><input type="hidden" name="item['+item[i]['n']+']" value="'+item[i]['product_id']+'" /><a href="'+item[i]['sku_link']+'"><img src="'+item[i]['img_src']+'" /></a><a href="'+item[i]['sku_link']+'" class="name">'+item[i]['product_name']+'</a><p class="price">'+price+'</p>'+item[i]['options']+'<p class="center"><a href="'+item[i]['sku_link']+'" class="btn22_gray" target="_blank">Детали</a></p></li>';
            };
            wishlist_href = wishlist.join('-');
            var top = ($(window).height() - $(".JS-popwincon").height())/2;   
            var left = ($(window).width() - $(".JS-popwincon").width())/2;   
            var scrollTop = $(document).scrollTop();   
            var scrollLeft = $(document).scrollLeft();   
            $(".JS-popwincon").css( { position : 'absolute', 'top' : top + scrollTop + (-350), left : "50%" } ).show();
            $('.add-wishlist').attr('href','<?php echo LANGPATH; ?>/wishlist/add_more/'+wishlist_href)
            $('.scrollableDiv1').html(str)
            $(".items").show();
        },
        'json'
    )
}

function JSpopwinconhide(){
    $(".JS-popwincon").hide();
}
</script>

<div id="myModal" class="reveal-modal xlarge">
        <a class="close-reveal-modal close-btn3"></a>
    <!-- look_box -->
    <div class="look-pro">
        <form action="<?php echo LANGPATH; ?>/cart/add_more" method="post" class="form3" id="form">
            <input type="hidden" name="page" value="product" />
            <div class="items">
                <ul class="scrollableDiv1 scrollableDivs fix"></ul>
            </div>
            <div class="add-bag">
                <input value="Добавить в корзину" class="btn btn-primary btn-lg" type="submit"><a href="<?php echo LANGPATH; ?>/wishlist/add_more/" class="a-underline add-wishlist">Избранное</a>
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
