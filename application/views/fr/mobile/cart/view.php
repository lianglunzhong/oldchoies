<?php
$currency = Site::instance()->currency();
$cpromotions = DB::select()->from('carts_cpromotions')
                ->where('site_id', '=', Site::instance()->get('id'))
                ->and_where('is_active', '=', 1)
                ->and_where('from_date', '<=', time())
                ->and_where('to_date', '>=', time())
                ->order_by('priority')
                ->execute()->as_array();
$sale_words = array();
$cart_promotion_logs = isset($cart['promotion_logs']['cart']) ? $cart['promotion_logs']['cart'] : array();
foreach ($cpromotions as $cpromo)
{
        if (!array_key_exists($cpromo['id'], $cart_promotion_logs))
        {
                $sale_words[] = '"' . $cpromo['name'] . '"';
        }
        elseif (isset($cart_promotion_logs[$cpromo['id']]['restrictions']))
        {
                $restrictions = unserialize($cart_promotion_logs[$cpromo['id']]['restrictions']);
                $rate = $cart_promotion_logs[$cpromo['id']]['value'];
        }
        elseif (isset($cart_promotion_logs[$cpromo['id']]['next']))
        {
                $sale_words[] = $cart_promotion_logs[$cpromo['id']]['next'];
        }
}
?>

<script type="text/javascript">
        $(function(){
                $("#shipping_price").change(function(){
                        var price = $(this).val();
                        var code = "<?php echo $currency['code']; ?>";
                        var rate = <?php echo $currency['rate']; ?>;
                        var amount = <?php echo $cart['amount']['total'] - $cart['amount']['shipping']; ?>;
                        var shipping_price = tofloat(price * rate, 2);
                        shipping_price += " ";
                        var shipping_total = code + shipping_price;
                        var amount_total = code + tofloat((amount + parseInt(price)) * rate, 2);
                        $("#shipping_total").html(shipping_total);
                        $("#shipping_amount").val(price);
                        $("#totalPrice").html(amount_total);
                        $("#amount_left").html(tofloat((amount + parseInt(price)), 2));
                })
        })
        
        function shipping_submit()
        {
                var count = <?php echo count($cart['products']); ?>;
                if(count != 0)
                {
                        $("#shipping_form").submit();
                }
                return false;
        }
                
        function tofloat(f,dec)       
        {          
                if(dec <0) return "Error:dec <0! ";          
                result=parseInt(f)+(dec==0? " ": ".");          
                f-=parseInt(f);          
                if(f==0)
                {
                        for(i=0;i <dec;i++) result+= '0';          
                }
                else       
                {          
                        for(i=0;i <dec;i++)
                        {
                                f*=10;
                                if(parseInt(f) == 0)
                                {
                                        result+= '0';
                                }
                        }          
                        result+=parseInt(Math.round(f));
                } 
                return result;          
        }
</script>
<script type="text/javascript">
        var product_price = <?php echo $cart['amount']['items']; ?>;
        $(function(){
                $('#pp_express').click(function(){
                        if(product_price <= 0)
                        {
                                alert('Shopping Cart cannot be empty');
                                return false;
                        }
                        $('#shipping_form').attr('action', '/payment/ppec_set');
                        $('#shipping_form').submit();
                })
        })
</script>


<div id="cart-full">
	<h2>Review Your Bag</h2><?php echo Message::get(); ?>
	
<?php
$types = array(0 => 0,3 => 0);
foreach ($cart['products'] as $key => $product):
  	$types[$product['type']] ++;
    $name = Product::instance($product['id'])->get('name');
    $link = Product::instance($product['id'])->permalink();
    ?>
	<div class="product row">
		<div class="mobile-one">
			<a href="<?php echo $link; ?>" >
				<img src="<?php echo image::link(Product::instance($product['id'])->cover_image(), 3); ?>" width="156" height="234">
			</a>
		</div>
		<div class="mobile-three">
			<h3><a href="<?php echo $link; ?>"><?php echo $name; ?></a></h3>
			<span class="style-number">Item# : <?php echo Product::instance($product['id'])->get('sku'); ?></span>
			<div class="rship"></div>
			<ul>
			<?php
            $delivery_time = kohana::config('prdress.delivery_time');
            if (isset($product['attributes'])):
             	foreach ($product['attributes'] as $attribute => $option):
                  	if ($attribute == 'delivery time')
                    {
                      	$option = $option > 0 ? 'Rush Order' . ' ( + ' . Site::instance()->price($option, 'code_view') . ' )' : 'Regular Order';
                    }?>
                    <li><?php echo ucfirst($attribute) . ': ' . $option ; ?></li> <?php
              	endforeach;
            endif;
            ?>
            
					<li class="row-qty"><?php
            		if ($product['price'] == 0 OR $product['is_killer'])
            		{
                 			echo '1';
            		}
           			else
            		{	?>
						<form action="/mobilecart/quantity" method="POST">Quantity:
							<a href="<?php echo LANGPATH; ?>/mobilecart/reduce/<?php echo $key; ?>" class="allbtn btn-dec" title="reduce" style="margin : 0px 5px"><b> - </b></a>
							<input name="key" type="hidden" class="b-num" value="<?php echo $key; ?>">
                      		<input name="num" type="text" class="b-num" value="<?php echo $product['quantity']; ?>" size="3" style="margin : 0px 0px 0px 5px;">
                      		<a href="<?php echo LANGPATH; ?>/mobilecart/increase/<?php echo $key; ?>" class="allbtn btn-inc" title="increase"><b> + </b></a>
						</form><?php 
						
					}?>
					</li>
			
			
			 	<?php
                if (isset($restrictions['restrict_catalog']) || isset($restrictions['restrict_product']))
                {
                  	if (Product::instance($product['id'])->get('set_id') == $restrictions['restrict_catalog'] 
                      					|| $product['id'] == $restrictions['restrict_product'])
                    { ?>
                       		
                        <li>Price: 
                        	<?php echo Site::instance()->price($product['price'], 'code_view'); ?><br />
                         	<?php echo Site::instance()->price($product['price'] * $rate / 100, 'code_view'); ?></li>
                        <li><strong>Total: </strong>
                           	<?php echo Site::instance()->price($product['price'] * $product['quantity'], 'code_view'); ?></li><?php
                        
                  	}else{   ?>
                       	<li>Price:
                       		<?php echo Site::instance()->price($product['price'], 'code_view'); ?></li>
                        <li><strong>Total: </strong>
                           	<?php echo Site::instance()->price($product['price'] * $product['quantity'], 'code_view'); ?></li><?php
                    }
             	}else{  ?>
                        <li>Price:
                         	<?php if (Product::instance($product['id'])->get('price') > $product['price'])
                                {
                                     echo Site::instance()->price(Product::instance($product['id'])->get('price'), 'code_view') . '<br>';
                                }
                                echo Site::instance()->price($product['price'], 'code_view');
                    		?><li>
                        <li><strong>Total: </strong><?php echo Site::instance()->price($product['price'] * $product['quantity'], 'code_view'); ?></li> <?php
             	}
                ?>
			</ul>
			
			<span style="margin-right:15px;"><a href="<?php echo LANGPATH; ?>/wishlist/add/<?php echo $product['id']; ?>" class="wantlist-add"  >Add to Wish List</a></span> | 
			<a href="<?php echo LANGPATH; ?>/mobilecart/delete/<?php echo $key; ?>" class="remove" style="margin-left:15px;">Remove</a>
		</div>
	</div>
<?php endforeach; ?>	
	
    <?php if (isset($cart['largesses'])){
        foreach ($cart['largesses'] as $key => $largess){ ?>
        <div class="product row">
            <div class="mobile-one">
                <a href="<?php echo Product::instance($largess['id'])->permalink(); ?>">
                    <img src="<?php echo image::link(Product::instance($largess['id'])->cover_image(), 3); ?>" width="156" height="234">
                </a>
            </div>
            <div class="mobile-three">
                <h3><a href="<?php echo Product::instance($largess['id'])->permalink(); ?>"><?php echo Product::instance($largess['id'])->get('name'); ?></a></h3>
                <span class="style-number">Item# : <?php echo Product::instance($largess['id'])->get('sku'); ?></span>
                <div class="rship"></div>
                <ul>
                    <?php
                    if (isset($largess['attributes'])):
                      foreach ($largess['attributes'] as $attribute => $option):
                          ?>
                      <li><?php echo ucfirst($attribute) . ': ' . $option; ?></li>
                      <?php
                      endforeach;
                      endif;
                      ?>         
                      <li class="row-qty">                        
                        Quantity:<input name="num" type="text" class="b-num" value="<?php echo $largess['quantity']; ?>" size="3" style="margin : 0px 0px 0px 5px;">                
                    </li>


                    <li>Price:<?php echo Site::instance()->price($largess['price'], 'code_view'); ?></li>
                </ul>

                <a href="<?php echo LANGPATH; ?>/mobilecart/largess_delete/<?php echo $key; ?>" class="allbtn btn-del">delete</a>
            </div>
        </div>
        <?php }
    } ?>

    <?php if (!empty($cart['largesses_for_choosing'])): ?>
        <?php foreach ($cart['largesses_for_choosing'] as $largesses_for_choosing): ?>
            <b><?php echo $largesses_for_choosing['brief']; ?></b>
            <?php
            $num = 1;
            foreach ($largesses_for_choosing['largesses'] as $key => $largesses_for_choosing_product):
                if ($num > 3)
                    break;
                $stock = Product::instance($key)->get('stock');
                if ($stock != -99 AND $stock == 0)
                    continue;
                if($stock == -1)
                {
                    $stocks = DB::select(DB::expr('SUM(stocks) AS sum'))->from('products_stocks')->where('product_id', '=', $key)->execute()->get('sum');
                    if(!$stocks)
                        continue;
                }
                $num++;
                ?>
                <form method="POST" action="/mobilecart/largess_add">
                    <div class="product row"> 
                            <div class="mobile-one">
                                <a href="<?php echo Product::instance($key)->permalink(); ?>" title="<?php echo Product::instance($key)->get('name'); ?>">
                                    <img src="<?php echo image::link(Product::instance($key)->cover_image(), 3); ?>" alt="<?php echo Product::instance($key)->get('name'); ?>" />
                                </a>
                            </div>
                            <div class="mobile-three">
                                        <h3>
                                        <a href="<?php echo Product::instance($key)->permalink(); ?>" title="<?php echo Product::instance($key)->get('name'); ?>" class="b-item-name">
                                            <?php echo Product::instance($key)->get('name'); ?>
                                        </a></h3>
                                        <span class="style-number">Item# : <?php echo Product::instance($key)->get('sku'); ?></span>
                            <ul>
                                <?php
                                $attributes = Product::instance($key)->get('attributes');
                                foreach ($attributes as $name => $attribute)
                                {
                                    ?>
                                    <span><?php echo $name; ?>:</span>
                                    <select name="attributes[<?php echo $name; ?>]">
                                        <?php
                                        foreach ($attribute as $att)
                                        {
                                            ?>
                                            <option value="<?php echo $att; ?>"><?php echo $att; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <br>
                                    <?php
                                }
                                ?>
                                <input type="hidden" name="promotion_id" value="<?php echo $largesses_for_choosing['promotion_id']; ?>" />
                                <input type="hidden" name="id" value="<?php echo $key; ?>" />
                                <input type="hidden" name="items[]" value="<?php echo $key; ?>" />
                                <li><select name="quantity">
                                    <?php for ($i = 1; $i <= $largesses_for_choosing_product['available_quantity']; $i++): ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select></li>
                            <li>
                                <?php
                                $orig_price = Product::instance($key)->get('price');
                                if ($orig_price > $largesses_for_choosing_product['price']):
                                    ?>
                                <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del><br/>
                                <?php
                                endif;
                                echo Site::instance()->price($largesses_for_choosing_product['price'], 'code_view');
                                ?></li>
                            </ul>
                            <input  type="submit" class="allbtn btn-btb ml10" value="Take This Offer" onmouseover="$(this).addClass('on')" onmouseout="$(this).removeClass('on')"  />
                        </div>
                    </div>
                </form>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endif; ?>
	
	<form id="shipping_form" action="" method="post">
    	<?php if($only_hkpf): ?>
        <span class="flr">Sorry but only standard shipping for your area.</span><br/>
        <?php endif; ?>
        <strong  class="mr10"><span class="red">*</span> Shipping Method:</strong>
        <span>
         	<select name="shipping_price" id="shipping_price">
            <?php
            foreach ($site_shipping as $key => $price):
                 if($price['price'] > 0 AND $only_hkpf)
                       continue;
                       
                 $selected = '';
                 if ($cart_shipping == -1)
                 {
                    	if ($key == 1)
                        {
                             $default_shipping = $price['price'];
                             $selected = 'selected="selected"';
                        }
                 }
                 elseif ($price['price'] == $cart_shipping)
                 {
                       $default_shipping = $price['price'];
                       $selected = 'selected="selected"';
                 }
                 ?>
                 <option <?php echo $selected; ?> value="<?php echo $price['price']; ?>"><?php echo $price['name'] . ' (' . Site::instance()->price($price['price'], 'code_view') . ')'; ?></option>
                 <?php
           	endforeach;
            ?>
            </select>
     	</span>
  	</form>
	
	
	
	<table class="cost-summary" cellspacing="0"><tbody>
		<tr><td>Subtotal:</td>
			<td class="text-right"><?php echo Site::instance()->price($cart['amount']['items'], 'code_view'); ?></td></tr>	
		<tr><td>Estimated Shipping:</td>
			<td id="shipping_total" class="text-right"><?php echo $cart_shipping == -1 ? Site::instance()->price($site_shipping[1]['price'], 'code_view') : Site::instance()->price($cart_shipping, 'code_view'); ?></td>
		<?php if ($cart['amount']['save']){ 
                 foreach ($cart['promotion_logs']['cart'] as $p_cart)
                 {
                 	if ($p_cart['save'])
                    {
                     	$p_name = explode(':', $p_cart['log']);
                        ?>
                        <tr><?php echo '<td class="tal">"' . $p_name[0] . '" Save : </td><td class="tar">-' . Site::instance()->price($p_cart['save'], 'code_view'); ?></td></tr>
                        <?php
                	}
         		}
                                        
                if ($cart['amount']['coupon_save'] > 0){ ?>
                        <tr>
                       		<td class="tal">Coupon Code:</td>
                            <td class="tar text-right">-<?php echo Site::instance()->price($cart['amount']['coupon_save'], 'code_view'); ?></td>
                      	</tr> <?php
                }
       		}
           	?>
       	<tr class="estimated-totals">
        	<td><strong>Total:</strong></td>
            <td id="totalPrice" class="text-right"><strong>
            <?php echo $cart['amount']['shipping'] ? Site::instance()->price($cart['amount']['total'], 'code_view') : Site::instance()->price($cart['amount']['total'] + $default_shipping, 'code_view');?>  
           	</strong></td>
      	</tr>	
		</tbody>	
	</table>
		
		
<!--	<a href="<?php echo LANGPATH; ?>/mobilecart/continue" class="inline-block" style="margin-top:25px;"><span class="arrow-left" ></span>CONTINUE SHOPPING</a>-->
	<a class="btn-checkout right" href="#" onclick="return shipping_submit();">CHECKOUT</a>
	<div class="paypal">
<!--		<strong>OR</strong><br><br>-->
<!--		<a href="javascript:void(0)"  onclick="return ppecPay();" id="pp_express" class="paypal">-->
<!--			<img src="/images/mobile/paypal.png"  alt="Click here to pay via PayPal Express Checkout">-->
<!--		</a>-->
	</div>
	
	
</div>

