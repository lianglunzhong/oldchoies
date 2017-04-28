<script>
    var page = <?php echo isset($_GET['page']) ? 1 : 0; ?>;
    $(function(){
        if(page)
        {
            window.location.href = '#pagefocus';
        }
    })
</script>
	<div class="page">
		<div class="site-content">
			<div class="main-container clearfix">
				<div class="container">
					<div class="crumbs">
			            <div class="fll">
			                <a href="<?php echo LANGPATH; ?>/" class="home">PÁGINA DE INICIO</a>&gt; 
			               
			            </div>
                    </div>
        <?php echo message::get(); ?>
                    <div class="lookbook-details row mb20">
                    	<div class="col-xs-12 col-sm-4">   
						<?php
                        $product = Product::instance($c_images['product_id'], LANGUAGE);
                        $link = $product->permalink();
                        ?>
                    		<a href="<?php echo $link; ?>"><img src="<?php echo STATICURL . '/limg/' . $c_images['image']; ?>"  alt=""></a>
                    	</div>
                    	<div class="col-xs-12 col-sm-8 container">
                    		<div class="row">

                    			<div class="col-xs-6 col-sm-5">
		                        	<a href="<?php echo $link; ?>"><img src="<?php echo Image::link($product->cover_image(), 1); ?>"  alt="" /></a></a>
		                        </div>
		                     	<div class="col-xs-6 col-sm-7">
		                        	<div class="con cle">
			                            <h4><a href="<?php echo $link; ?>"><?php echo $product->get('name'); ?></a></h4>
			                            <h2 class="mt20"><?php echo Site::instance()->price($product->price(), 'code_view'); ?></h2>
			                            <p class="pc-btn"><a href="<?php echo $link; ?>" id="<?php echo $c_images['product_id']; ?>" attr-lang="<?php echo LANGUAGE; ?>" class="btn btn-default btn-lg mt20">COMPRAR AHORA</a></p>
										<p class="phone-btn"><a href="<?php echo $link; ?>" class="btn btn-default btn-lg ">COMPRAR AHORA</a></p>
                            <?php
                            if ($c_images['type'] != 1 && $c_images['link_sku'] && strlen($c_images['link_sku']) > 0)
                            {
                                ?>
                                <p class="pc-btn"><a class="btn btn-default btn-lg mt20 JS-popwinbtn1">Conseguir el look</a></p>
                                <?php
                            }
                            ?>
			                            <div class="lookbook-share">
			                                <span>compartir:</span>
			                                <span class="sns fix">
			                                    <a  href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($link); ?>" target="_blank" class="sns1"></a>
			                                    <a  href="http://twitter.com/share?url=<?php echo urlencode($link); ?>" target="_blank" class="sns2"></a>
			                                    <a  href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($link); ?>&media=<?php echo Image::link($product->cover_image(), 1); ?>&description=<?php $product->get('name'); ?>" target="_blank" class="sns5"></a>
			                                </span>
			                            </div>
			                        </div>
		                        </div>		
         
                <?php
                if ($c_images['type'] != 1 && $c_images['link_sku'] && strlen($c_images['link_sku']) > 0)
                {
                    ?>
                        <div class="col-xs-12 col-sm-12 pc-btn">
                         <div id="homeIndexFashion" class="flexslider">
                            <ul class="slides">
                                <?php
                                $skus = explode(',', $c_images['link_sku']);
                                if (is_array($skus)):
                                    $n = 1;
                                    $num = 4;
                                    $sku_num = ceil(count($skus) / $num);
                                       for($i = 0;$i < $sku_num;$i ++)
                                     {  ?>
                                      <li <?php if($i > 0) echo 'style="display:none;"' ?>>
                                            <div class="row">
                                            <ul>    
                                      <?php 
                                    for($j = $num * $i;$j < ($i + 1) * $num;$j ++){
                                        if(!isset($skus[$j]))
                                            continue;
                                        $pro_id = Product::get_productId_by_sku(trim($skus[$j]));
                                        if (!$pro_id)
                                        {
                                            continue;
                                        }
                                        if ($n > 8)
                                        {
                                            break;
                                        }
                                        $n++;
                                        ?>
                                        
                                            <?php
                                            $link_pro = Product::instance($pro_id, LANGUAGE);
                                            if ($link_pro->get('visibility') != 1)
                                            {
                                                continue;
                                            }
                                            $orig_price = round($link_pro->get('price'), 2);
                                            $price = round($link_pro->price(), 2);
                                            ?>
                                              <li class="col-sm-3">
                                            <a href="<?php echo $link_pro->permalink(); ?>" target="_blank"><img src="<?php echo Image::link($link_pro->cover_image(), 1); ?>" title="<?php echo $link_pro->get('name'); ?>" alt="<?php echo $link_pro->get('name'); ?>" /></a>
                                        </li>
                                                <?php 
                                                }
                                                ?>
                                            </ul>
                                        </div>

                                        </li>
                                    <?php
                                        }
                                endif;
                                ?>
                            </ul>

                        </div>
                    </div>
                    <?php
                } 
                ?>  			
					
                         </div>
                        </div>
                    </div>      
				</div>
			</div>
		</div>
<script type="text/javascript">
    $(function(){
        $('.grade').children().click(function(){
            var star = $(this).attr('alt');
            $('#star').val(star);
        })
    })
</script>

<?php echo View::factory(LANGPATH . '/quickview'); ?>

<?php
if (!empty($skus))
{
    ?>
	<div class="JS-popwincon1 popwincon hide">
							<a class="JS-close2 close-btn3"></a>
							<!-- look-box -->
							<div class="look-pro">
                            <?php
                            $wishlist = array();
                            $n = 1;
                            $key = 0;
                            ?>
								<form action="<?php echo LANGPATH; ?>/cart/add_more" method="post" class="form3" id="form<?php echo $key; ?>">
									<input name="page" value="product" type="hidden">
									<div class="clearfix items<?php echo $key; ?>">
										<ul class="scrollableDiv1 scrollableDivs<?php echo $key; ?> fix">
                        <?php
                        foreach ($skus as $sku)
                        {
                            $pro_id = Product::get_productId_by_sku(trim($sku));
                            if (!$pro_id)
                            {
                                continue;
                            }
                            if ($n > 5)
                            {
                                break;
                            }
                            $n++;
                            $wishlist[] = $pro_id;
                            $link_pro = Product::instance($pro_id, LANGUAGE);
                            $orig_price = round($link_pro->get('price'), 2);
                            $price = round($link_pro->price(), 2);
                            $sku_link = $link_pro->permalink();
                            ?>
											<li>
												<input type="checkbox" name="check[<?php echo $n; ?>]" title="size<?php echo $n; ?>" class="checkbox" checked="checked" id="checkout<?php echo $pro_id . $key; ?>" /> <label for="checkout<?php echo $pro_id . $key; ?>">Añadir a Bolsa</label>
                                <input type="hidden" name="item[<?php echo $n; ?>]" value="<?php echo $pro_id; ?>" />
                                <a href="<?php echo $sku_link; ?>"><img src="<?php echo Image::link($link_pro->cover_image(), 3); ?>" /></a>
                                <a href="<?php echo $sku_link; ?>" class="name"><?php echo $link_pro->get('name'); ?> </a>
												<p class="price">
                                    <?php
                                    if ($orig_price > $price)
                                    {
                                        ?>
                                        <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del> <b class="red font18"><?php echo Site::instance()->price($price, 'code_view'); ?></b>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <b class="red font18"><?php echo Site::instance()->price($link_pro->get('price'), 'code_view'); ?></b>
                                    <?php
                                }
                                ?>
												</p>
								<?php
                                $instock = 1;
                                $stock = $link_pro->get('stock');
                                $stocks = array();
                                $pro_stocks = array();
                                if (!$link_pro->get('status') OR ($stock == 0 AND $stock != -99))
                                {
                                    $instock = 0;
                                }
                                elseif ($stock == -1)
                                {
                                    $stocks = DB::select()->from('products_stocks')->where('product_id', '=', $pro_id)->where('stocks', '>', 0)->execute()->as_array();
                                    if (count($stocks) == 0)
                                        $instock = 0;
                                    else
                                    {
                                        foreach ($stocks as $s)
                                        {
                                            $pro_stocks[$s['attributes']] = $s['stocks'];
                                        }
                                    }
                                }
                                ?>
                                <?php
                                if ($instock)
                                {
                                    ?>
												<p class="select">TALLA:
													<select name="size[<?php echo $n; ?>]" class="size_select">
                                            <?php
                                            $is_onesize = 0;
                                            $set = $link_pro->get('set_id');
                                            if (!empty($pro_stocks))
                                            {
                                                echo '<option>Elegir Talla</option>';
                                                foreach ($pro_stocks as $size => $p)
                                                {
                                                    $sizeval = $size;
                                                    if ($set == 2)
                                                    {
                                                        $sizeArr = explode('/', $size);
                                                        $sizeval = $sizeArr[2];
                                                    }
                                                    $sizetitle = str_replace('one size', 'talla única', $sizeval);
                                                    ?>
                                                    <option value="<?php echo str_replace('EUR', '', $sizeval); ?>" ><?php echo $sizetitle; ?> <span class="red">(¡Sólo queda <?php echo $p; ?> !)</span></option>
                                                    <?php
                                                }
                                            }
                                            else
                                            {
                                                $attributes = $link_pro->get('attributes');
                                                if (isset($attributes['Size']))
                                                {
                                                    if (count($attributes['Size']) == 1)
                                                        $is_onesize = 1;
                                                    else
                                                        echo '<option>Elegir Talla</option>';
                                                    foreach ($attributes['Size'] as $size)
                                                    {
                                                        $sizeval = $size;
                                                        if ($set == 2)
                                                        {
                                                            $sizeArr = explode('/', $size);
                                                            $sizeval = $sizeArr[2];
                                                        }
                                                        $sizetitle = str_replace('one size', 'talla única', $sizeval);
                                                        ?>
                                                        <option value="<?php echo str_replace('EUR', '', $sizeval); ?>" ><?php echo $sizetitle; ?></option>
                                                        <?php
                                                    }
                                                }
                                                else
                                                {
                                                    $is_onesize = 1;
                                                    ?>
                                                    <option value="one size" <?php if (isset($pro_stocks['one size'])) echo 'title="' . $pro_stocks['one size'] . '"' ?>>talla única</option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
													<input type="hidden" class="size_input" name="size<?php echo $n; ?>" value="<?php if ($is_onesize) echo 1; ?>" />
												</p>
												<p class="select">CANTIDAD: <input type="text" class="text" name="qty[<?php echo $n; ?>]" value="1" /></p>
                                    <?php
                                }
                                ?>
												<p><a href="<?php echo $sku_link; ?>" class="btn btn-default btn-xs" target="_blank">DETALLES</a>
												</p>
                                <?php
                                if (!$instock)
                                    echo '<span class="red outstock">FUERA DE STOCK</span>';
                                ?>
											</li>
									<?php
										}
									?>

										</ul>
									</div>
									<div class="add-bag">
										<input value="AÑADIR A BOLSA" class="btn btn-primary btn-lg" type="submit"><a href="<?php echo LANGPATH; ?>/wishlist/add_more/<?php echo implode('-', $wishlist); ?>" class="a-underline add-wishlist">LISTA DE DESEOS</a>
									</div>
				<span class="prevs<?php echo $key; ?>"></span>
                <span class="nexts<?php echo $key; ?>"></span>
								</form>
            <script>
                $("#form<?php echo $key; ?>").validate({
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
                    },
                    messages: {
                        size0:{
                            required:"Campo Requerido."
                        },
                        size1:{
                            required:"Campo Requerido."
                        },
                        size2:{
                            required:"Campo Requerido."
                        },
                        size3:{
                            required:"Campo Requerido."
                        },
                        size4:{
                            required:"Campo Requerido."
                        },
                        size5:{
                            required:"Campo Requerido."
                        },
                        size6:{
                            required:"Campo Requerido."
                        },
                        size7:{
                            required:"Campo Requerido."
                        },
                        
                    }
                })
                $(function(){
                    $(".form3 .checkbox").click(function(){
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
                                    
                    $(".size_select").change(function(){
                        var val = $(this).val();
                        $(this).parent().find(".size_input").val(val);
                    })
                                    
                    var i = 1;  
                    var m = 1;  
                    var $content = $(".scrollableDivs<?php echo $key; ?>");
                    var count = ($content.find("li").length)-4;
                    $(".look_pro .nexts<?php echo $key; ?>").live("click",function(){
                        var $scrollableDiv = $(this).siblings(".items<?php echo $key; ?>").find(".scrollableDivs<?php echo $key; ?>");
                        if( !$scrollableDiv.is(":animated")){
                            if(m<count){ 
                                m++;
                                $scrollableDiv.animate({left: "-=175px"});
                            }
                        }
                        return false;
                    });
                                    
                    //上一张
                    $(".look_pro .prevs<?php echo $key; ?>").live("click",function(){
                        var $scrollableDiv = $(this).siblings(".items<?php echo $key; ?>").find(".scrollableDivs<?php echo $key; ?>");
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
	    <?php
}
?>
<script>
        		
function getScrollTop() {
    var scrollPos; 
    if (window.pageYOffset) 
    {
        scrollPos = window.pageYOffset;
    } 
    else if (document.compatMode && document.compatMode != 'BackCompat')
    { 
        scrollPos = document.documentElement.scrollTop; 
    } 
    else if (document.body) 
    { 
        scrollPos = document.body.scrollTop; 
    } 
    return scrollPos; 
}
</script>
		<div id="gotop" class="hide ">
			<a href="#" class="xs-mobile-top"></a>
		</div>
	</div>	
