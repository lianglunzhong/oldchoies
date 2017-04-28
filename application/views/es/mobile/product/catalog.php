<script type="text/javascript" src="/js/jquery.multiselect.js"></script>
<link type="text/css" href="/css/jquery.multiselect.css" rel="stylesheet" />
<script src="/css_mobile/modernizr-2.5.3.js"></script>
<style type="text/css">
dl.enhance dd {margin-bottom: 3px;margin-top: 0;}
#refine ul li.activeli {background: #ff887c;color: white;}
</style>

<script type="text/javascript">
$(function() {
   	$("#fil_color").click(function(){
   	   	if( $("#color_show").attr("class") == "closed" )
   	   	{
   	   		$("#color_show").removeClass("closed");
   	   	}else{
   	   		$("#color_show").addClass("closed");
   	   	}
   	});

   	$("#fil_price").click(function(){
   	   	if( $("#price_show").attr("class") == "price-range closed" )
   	   	{
   	   		$("#price_show").removeClass("closed");
   	   	}else{
   	   		$("#price_show").addClass("closed");
   	   	}
   	});

   	$("#refine ul li").click(function(){
   	   	if( $(this).attr("class") == "activeli" )
   	   	{
   	   		$(this).removeClass("activeli");
   	   	}else{
   	   		$(this).siblings().removeClass("activeli");
   	   		$(this).addClass("activeli");
   	   		var color = $(this).val();
   	   		$("#filter_color").val(color);
   	   	}
   	});

   	$("#submit").click(function(){
   	   	if( $("#filter_color").val() < 1 )
   	   	{
   	   		$("#filter_color").removeAttr("name");
   	   	}
		$("#refine form").attr("action","<?php echo $_SERVER['REDIRECT_URL']; ?>");
   	})
});

function filter_open()
{
	$("#refine").addClass("open");
	$("#refine").attr("style","top: 100px; opacity: 1; visibility: visible; display: block;");
}
function filter_close()
{
	$("#refine").removeClass("open");
	$("#refine").attr("style","top: 15px; opacity: 1; visibility: hidden; display: none;");
}
</script>

<div id="refine" class="reveal-modal" style="top: 15px; opacity: 1; visibility: hidden; display: none;" data-loaded="true">
	<form action="" method="get" id=>
		<label for="sorts">SORT BY:</label>
		<div style="position:relative; height:60px;">
		    <select name="sort">
		    	<?php foreach ($sorts as $key => $sort): ?>
                <option value="<?php echo $key; ?>" <?php if (isset($_GET['sort']) AND $_GET['sort'] == $key) echo 'selected'; ?>>
                	<?php echo $sort['name']; ?>
                </option>
                <?php endforeach; ?>
			</select>
		</div>
		
		<label>REFINE BY:</label>
		<dl id="filters" class="enhance">
		    <dt><a id="fil_color" onclick="">Color</a></dt>
		    <dd id="color_show" data-height="95" class="closed">
		    	<ul class="colors">
		    	<?php foreach ($sortcolor as $key => $color): ?>
		    		<li value="<?php echo $key; ?>" <?php if (isset($_GET['color']) AND $_GET['color'] == $key) echo 'class="activeli"'; ?>>
		    			<?php echo ucfirst($color); ?></li>
		    	<?php endforeach; ?>
				</ul>
				<input type="hidden" id="filter_color" name="color" value="<?php echo isset($_GET['color']) ? $_GET['color'] : 0; ?>" />
		    </dd>
		    
		    
		    <dt><a id="fil_price" >Price Range</a></dt>
		    <dd id="price_show" class="price-range closed" >
			    <select name="pricefrom">
			    	<?php for($min=0;$min<=500;$min=$min+10){?>
			    	<option value="<?php echo $min?>" <?php if(isset($_GET['pricefrom']) && $_GET['pricefrom']==  $min )echo "selected"; ?>>
			    			$<?php echo $min;?></option>
			    	<?php }?>
				</select>

				<select name="priceto" class="right">
				  	<?php for($max=0;$max<=500;$max=$max+10){?>
			    	<option  <?php if(isset($_GET['priceto'])){ echo 'selected';} 
			    				   elseif($max == 500){ echo 'selected';}?> value="<?php echo $max?>" >$<?php echo $max;?></option>
			        <?php }?>
				</select>
		    </dd>
		</dl>    
		
		<input type="submit" value="Apply" class="btn-pink-apply" id="submit">
		<a class="btn-cancel close-reveal-modal" onclick="filter_close();"></a>
	</form>
	<a class="close-reveal-modal" onclick="filter_close();">x</a>
</div>

<!--   +++++++++++++++++++++		-->
<div class="family ">
	<p id="crumbs"><a href="<?php echo LANGPATH; ?>/">Home</a>/<a title="Home" class="first"> <?php echo $catalog->get('name'); ?></a></p>
	<a class="refine btn-refine" id="refine-click" onclick="filter_open();">REFINE</a>
	<div class="clearfix"></div>
	<div class="prodWrap">
	<?php 
	$_20 = count($products) >= 20 ? 20 : count($products);
	for ($i = 0; $i < $_20; $i++)
	{
		$product_id = $products[$i];
		$product = Product::instance($product_id);
		$images = $product->images();
		?>
		<div class="product">
			<a href="<?php echo $product->permalink(); ?>" >
			<img class="lazyload" src="<?php echo Image::link($images[0], 1); ?>" height="226" width="150" style="height:226px;width:150px;" />
			<h3><?php echo $product->get('name'); ?></h3>
			<?php if (round($product->get('price'), 2) > round($product->price(), 2)) { ?>
				<span class="regular"><del><?php echo Site::instance()->price($product->get('price'), 'code_view'); ?></del></span>
				<span class="regular"><?php echo Site::instance()->price($product->price(), 'code_view'); ?></span>
			<?php }else{ ?>
				<span class="regular"><?php echo Site::instance()->price($product->price(), 'code_view'); ?></span>
			<?php } ?>
			</a>
		</div>
	<?php } ?>	    
	</div>
	<?php echo $pagination; ?>
</div>	

