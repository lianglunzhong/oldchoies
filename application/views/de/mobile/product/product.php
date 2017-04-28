<script type="text/javascript" src="/css_mobile/jquery_choies.js"></script>
<script type="text/javascript" src="/css_mobile/jcarousellite.js"></script>

<style type="text/css">
    dl.enhance dd {margin-bottom: 3px;}
    #product-detail .sub {
        background: url("../images/mobile/xicon1.png") no-repeat scroll 0 -258px transparent;
        border: 0 none;
        cursor: pointer;
        height: 42px;
        width: 313px;
        margin-bottom: 10px;
    }
</style>

<script type="text/javascript">
    $(function(){
        $("#formAdd").submit(function(){
            $.post(
            '/mobilecart/ajax_add',
            {
                id: $('input:[name="id"]').val(),
                type: $('input:[name="type"]').val(),
                size: $('.s-size').val(),
                color: $('.s-color').val(),
                attrtype: $('.s-type').val(),
                quantity: $('input:[name="quantity"]').val()
            },
            function(product)
            {
                var count = 0;
                var cart_view = '';
                var cart_view1 = '';
                var key = 0;
                for(var p in product)
                {
                    if(key == 0)
                    {
                        cart_view = '<h2>success! item added to bag</h2>'
                            + '<div class="product row">'
                            +   '<div class="mobile-one"><img src="'+product[p]['image']+'" /></div>'
                            +	  '<div class="mobile-three"><h3>'+product[p]['name']+'</h3>'
                            +   '<ul><li>Item#: '+product[p]['sku']+'<br/>'+product[p]['price']+'<br/>'+product[p]['attributes']+'</li>'
                            + 	  '<li>Quantity: '+product[p]['quantity']+'</li></ul></div>'
                            +	'</div>';
                    }else{
                        count = count + product[p]['quantity'];
                    }
                    key = key + 1;
                }
                $('#bag_items').html(cart_view);
                $('#add-to-cart-modal').attr('style','top: 61px; opacity: 1; visibility: visible; display: block;z-index:100; background:#FFF;');
                $('#cart_count').text('My Bag('+count+')');
                $('body').animate({scrollTop:0},100);
            },
            'json'
        );
            return false;
        })

        $(".close-reveal-modal").live("click",function(){
            $("#add-to-cart-modal").slideToggle("fast");
        });
  	
    })
</script>


<p id="crumbs"><a href="<?php echo LANGPATH; ?>/">Home </a> /	
    <?php
    if (!$current_catalog)
    {
        $current_catalog = $product->default_catalog();
    }
    foreach (Catalog::instance($current_catalog)->crumbs() as $crumb)
    {
        if ($crumb['id'])
        {
            ?>
            &gt; <a href="<?php echo LANGPATH; ?>/mobile/catalog/<?php echo Catalog::instance($crumb['id'])->get('link'); ?>" rel="nofollow" >
                <?php echo $crumb['name']; ?></a> <?php
    }
}
        ?>&gt; <?php echo $product->get('name'); ?></p>

<?php
$p_price = round($product->get('price'), 2);
$price = round($product->price(), 2);
$customer_id = Customer::logged_in();
$customer = Customer::instance($customer_id);
$vip_level = $customer->get('vip_level');

$instock = 1;
$stock = $product->get('stock');
if (!$product->get('status') OR ($stock == 0 AND $stock != -99))
{
    $instock = 0;
}
?>                                       
<!--banner start-->
<div class="m-banner">
    <div class="banner-list">
        <ul class="fix" style="height:350px;">
            <?php
            $i = 0;
            foreach ($product->images() as $image): $i++
                ?>
                <li><a href="#"><img src="<?php echo Image::link($image, 2); ?>" alt="<?php echo $product->get('name'); ?>" width="300" height="196"/></a></li>
                <?php
            endforeach;
            ?>
        </ul>
    </div>
    <span class="in-btn1"><a></a></span><span class="in-btn2"><a></a></span> 
</div>
<!--banner end-->


<div id="product-main">
    <header>
        <h1><?php echo $product->get('name'); ?></h1><br/>
        <span style="margin-left:14px;">Item# : <?php echo $product->get('sku'); ?></span><br/>
        <?php
        if ($p_price > $price)
        {
            ?>
            <span style="margin-left:14px;">
                <del><?php echo Site::instance()->price($p_price, 'code_view'); ?></del>
                <?php echo Site::instance()->price($price, 'code_view'); ?>
            </span>
            <?php
        }
        else
        {
            ?> 
            <span style="margin-left:14px;">
                <h2><?php echo Site::instance()->price($price, 'code_view'); ?></h2>
            </span>
            <?php
        }
        ?>
    </header>
    <div class="rship"></div>

    <div class="content">
        <form action="/mobilecart/add" id="formAdd" method="POST">
            <input type="hidden" name="id" value="<?php echo $product->get('id'); ?>"/>
            <input type="hidden" name="items[]" value="<?php echo $product->get('id'); ?>"/>
            <input type="hidden" name="type" value="<?php echo $product->get('type'); ?>"/>

            <?php
            if (!empty($attributes['size']))
            {
                ?>	
                <label for="size" id="select_size">Size: SELECT SIZE</label>
                <input type="hidden" name="attributes[Size]" value="" class="s-size" />
                <div id="sizes-carousel" class="btn_type">
                    <ul id="sizes">
                        <?php
                        if ($stock == -1)
                        {
                            foreach ($attributes['size'] as $attribute)
                            {
                                if (array_key_exists($attribute, $stocks))
                                    echo '<li class="btn_size_normal" title="' . $stocks[$attribute] . '" id="' . $attribute . '" value="' . $attribute . '">' . $attribute . '</li>';
                                else
                                    echo '<li class="btn_size_normal" title="0" id="' . $attribute . '" value="' . $attribute . '">' . $attribute . '</li>';
                            }
                        }
                        else
                        {
                            foreach ($attributes['size'] as $attribute)
                            {
                                echo '<li class="btn_size_normal" id="' . $attribute . '" value="' . $attribute . '">' . $attribute . '</li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
                <script type="text/javascript">
                    $(function(){
                        $(".btn_type li").live("click",function(){

                            if($(this).attr('class') != 'btn_size_normal')
                            {
                                return false;
                            }
                            // var value = $(this).val();
                            var value = $(this).attr("id");
                            var qty = $(this).attr('title');
                            $(".s-size").val(value);
                            $(this).siblings().removeClass('active');
                            $(this).addClass('active');
                                            
                            //$("#select_size").html('Size: '+$(this).val());
                            $("#select_size").html('Size: '+value);
                            if(qty)
                                $("#only_left").html('Only '+qty+' Left!');
                        })
                                                                            
                        $('#addCart').live("click",function(){
                            size = $('.s-size').val();
                            if(!size)
                            {
                                alert('Please ' + $('#select_size').html());
                                return false;
                            }
                        })

                        $(".m-banner .banner-list").jCarouselLite({
                            btnPrev:".m-banner .in-btn1",
                            btnNext:".m-banner .in-btn2",
                            auto:10000,
                            visible:1
                        });
                    })
                </script><?php
                }
                if (!empty($attributes['color']))
                {
                        ?>
                <label for="color" id="select_color">Color: SELECT COLOR</label>
                <input type="hidden" name="attributes[Color]" value="" class="s-color" />
                <div class="btn_type">
                    <ul>
                        <?php
                        foreach ($attributes['color'] as $attribute)
                        {
                            echo '<li class="btn_normal" id="' . $attribute . '" value="' . $attribute . '">' . $attribute . '</li>';
                        }
                        ?>
                    </ul>
                </div>
                <script type="text/javascript">
                    $(function(){
                        $(".btn_type li").live("click",function(){
                            if($(this).attr('class') != 'btn_normal')
                            {
                                return false;
                            }
                            //var value = $(this).val();
                            var value = $(this).attr("id");
                            $(".s-color").val(value);
                            $(this).siblings().removeClass('active');
                            $(this).addClass('active');
                            $("#select_color").html('Color: '+value);
                        })
                                                                            
                        $('#addCart').live("click",function(){
                            size = $('.s-color').val();
                            if(!size)
                            {
                                alert('Please ' + $('#select_color').html());
                                return false;
                            }
                        })
                    })
                </script><?php
                }
                if (!empty($attributes['type']))
                {
                        ?>
                <label for="color" id="select_type">Type: SELECT TYPE</label>			
                <input type="hidden" name="attributes[Type]" value="" class="s-type" />
                <div class="btn_type">
                    <ul>
                        <?php
                        foreach ($attributes['type'] as $attribute)
                        {
                            echo '<li class="btn_normal" id="' . $attribute . '" value="' . $attribute . '">' . $attribute . '</li>';
                        }
                        ?>
                    </ul>
                </div>	
                <script type="text/javascript">
                    $(function(){
                        $(".btn_type li").live("click",function(){
                            if($(this).attr('class') != 'btn_normal')
                            {
                                return false;
                            }
                            //var value = $(this).val();
                            var value = $(this).attr("id");
                            $(".s-type").val(value);
                            $(this).siblings().removeClass('active');
                            $(this).addClass('active');
                            //$("#select_type").html('Type: '+$(this).val());
                            $("#select_type").html('Type: '+value);
                        })
                                                                            
                        $('#addCart').live("click",function(){
                            alert(333);
                            size = $('.s-type').val();
                            if(!size)
                            {
                                alert('Please ' + $('#select_type').html());
                                return false;
                            }
                        })
                    })
                </script>
                <?php
            }
            ?>	

            <div id="product-detail">
                <label for="quantity">QTY:</label>
                <input type="text" id="quantity" name="quantity" value="1">
                <span class="message stock">
                    <span id="only_left" class="red"></span>
                </span>

                <?php
                if ($instock <> 0)
                {
                    ?>
                    <input type="submit" value="" class="sub" id="addCart" />
                    <?php
                }
                else
                {
                    ?>
                    <b style="font-size:30px;color: red;">Out Of Stock</b>
                    <?php
                }
                ?>

                <a href="<?php echo LANGPATH; ?>/mobilewishlist/add/<?php echo $product->get('id'); ?>"  class="wantlist-new wish-add" title="Add to Wishlist">Add to Wishlist</a>
            </div>
        </form>

        <div id="social"></div>
        <?php echo View::factory('mobile/product/tabs')->set('product', $product)->render(); ?>
    </div>
</div>

<div id="add-to-cart-modal" class="reveal-modal">
    <div class="content" id="bag_items">

    </div>
    <a class="btn-viewtote" href="<?php echo LANGPATH; ?>/mobilecart/view" >View My Bag/Checkout</a>
    <a href="#" class="close-reveal-modal">x</a>
</div>

