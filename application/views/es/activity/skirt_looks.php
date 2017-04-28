<style>
.skirt{ margin-left:40px;overflow:hidden}
.skirt li{ margin-right:17px; width:225px; overflow:hidden; margin-top:30px; float:left}
.ski{ margin-top:10px; overflow:hidden}
.skirt li .vi{ font-size:14px; text-decoration:underline; }
.skirt li .ge{ background-color:#000; color:#fff; padding:0 5px; float:right; cursor:pointer }
.skirtban{ margin:20px 0 20px 40px;}
.skirt li a.vi:hover{color:#fff;background-color:#000;}
</style>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  SKIRTS</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <div class="banner layout" id="banner">
	<img src="/images/activity/skirt_looks/es_skirt_look.jpg" border="0" usemap="#Map" />
            <map name="Map" id="Map">
<area shape="rect" coords="1,0,511,301" href="http://www.choies.com/es/skirt?sort=1" />

<area shape="rect" coords="514,1,1024,313" href="http://www.choies.com/es/skirt?sort=2" />
            </map>
    </div>
    <script type="text/javascript">  
    $(function(){
      $(".banner .bannerPic li").soChange({
        thumbObj:".banner .bannerBtn li",
        botPrev:".banner .previous",
        botNext:".banner .next",
        botPrevslideTime:500,
        changeTime:5000,
        slideTime:500
        });

      // newsletter_form
      $("#newsletter_form").validate({
        rules: {
          email: {
            required: true,
            email: true
          }
        },
        messages: {
          email:{
            required:"",
            email:""
          }
        }
        
      });
    })
    </script>
    <div class="layout">
        <ul class="skirt">
            <?php foreach ($data as $value) { ?>
            <li>
                <div><img src="<?php echo $value['image'];?>" /></div>
                <div class="ski"><a class="vi" target="_blank" href="<?php echo $value['product_url'];?>">Ver Detalles >></a><span class="ge JS_popwinbtn4" title="<?php echo $value['link_sku'];?>" onclick="load_data('<?php echo $value['link_sku'];?>')" >Conseguir el Look</span></div>
            </li>
            <?php } ?>
        </ul>
        <!--<div class="skirtban"><a target="_blank" href="http://www.choies.com/skirt?ap0926"><img src="/images/activity/skirt_looks/skirt-05.jpg" /></a></div>	-->
    </div>
</section>

<script type="text/javascript">
function load_data(skus){
    $.post(
        '/activity/ajax_skirt_looks?lang=es',
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
                str += '<li><input type="checkbox" name="check['+item[i]['n']+']" title="size'+item[i]['n']+'" class="checkbox" checked="checked" id="checkout'+item[i]['product_id']+'" /> <label for="checkout'+item[i]['product_id']+'">AÑADIR A BOLSA</label><input type="hidden" name="item['+item[i]['n']+']" value="'+item[i]['product_id']+'" /><a href="'+item[i]['sku_link']+'"  target="_blank"><img src="'+item[i]['img_src']+'" /></a><a href="'+item[i]['sku_link']+'" class="name">'+item[i]['product_name']+'</a><p class="price">'+price+'</p>'+item[i]['options']+'<p class="center"><a href="'+item[i]['sku_link']+'" class="btn22_black" target="_blank">VER DETALLES</a></p></li>';
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
        <form action="<?php echo LANGPATH; ?>/cart/add_more" method="post" class="form3" id="form">
            <input type="hidden" name="page" value="product" />
            <div class="items">
                <ul class="scrollableDiv1 scrollableDivs fix"></ul>
            </div>
            <div class="center mt50">
                <input type="submit" value="AÑADIR A BOLSA" class="btn40_16_red" /><a href="" class="a_underline add_wishlist">LISTA DE DESEOS</a>
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
