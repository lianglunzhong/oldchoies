<style type="text/css">
#product-detail-extra table td {text-align: center; }
</style>

<dl id="product-detail-extra" class="pink enhance" style="display: block;">
	
		<dt><a href="#tab-detail"  class="tabchange">Details</a></dt>
		<dd id="tab-detail"  class="closed"  data-height="138" style="height: 138px;">
			<div>
			  	<?php
	          	echo str_replace("\n","<br>",$product->get('keywords')) . '<br><br>';
	            $brief = $product->get('brief');
	            $brief = str_replace(';', '<br>', $brief);
	            echo $brief . '<br><br>';
	            $description = $product->get('description');
	          	$description = str_replace(';', '<br>', $description);
	            echo $description;
	           	?>
			</div>
		</dd>
		
		<dt><a href="#tab-deliver"  class="tabchange">DELIVER & RETURN</a></dt>
		<dd id="tab-deliver" class="closed">
			<p style="color:#F00;">Receiving time = Processing time + Shipping time</p>
            <p>Processing: Usually 3-5 working days</p>
            <h4>Shipping:</h4>
            <p>(1)	Free shipping worldwide (15-20 working days)</p>
            <p style="color:#F00; padding-left:18px;">No minimum purchase required.</p>
          	<p>(2)	$ 15 Express Shipping(4-7 working days)</p>
            <p style="padding-left:18px;">For detailed shipping info. You can check <a href="<?php echo LANGPATH; ?>/shipping-delivery" >Shipping &amp; Delivery</a>.</p>
            <h4>Return Policy:</h4>
            <p>If you are not 100% satisfied with the products or service, please feel  easy to contact us, you can return in 60 days. </p>
            <p>For more Information, please check the <a href="<?php echo LANGPATH; ?>/returns-exchange" title="return policy">return policy</a>.</p>
            <h4>Extra Attention:</h4>
           	<p>Orders may be subject to import duties, if you realize your local custom will charge some tax and you don't accept, please contact us, we will use HongKong Post, which will avoid tax but need more time to ship.</p>
		</dd>
		
		<dt class="fit"><a href="#tab-size" class="tabchange fit active-dt">Size Guide</a></dt>
		<dd id="tab-size"  class="closed" data-height="388" style="height: 388px;">
			<h4 id="tab-shoes" onclick="tab_size();">Shoes</h4>
			<h4 id="tab-clothes" onclick="tab_size();" class="inactive right" >Clothes</h4>
			<table id="table-shoes" cellspacing="0" >
				<tbody>
				<tr><th>US</th>	  <th>UK</th>		<th>EUROPEAN</th>			<th>CM</th></tr>
				<tr><td>4 </td>	  <td> 2-2.5 </td>	<td>35</td>					<td>22.5</td></tr>
				<tr><td>5 </td>   <td> 3-3.5 </td>	<td>36</td>					<td> 23 </td></tr>
				<tr><td>6 </td>	  <td> 4-4.5 </td>	<td>37</td>					<td>23.5</td></tr>
				<tr><td>7 </td>   <td> 5-5.5 </td>	<td>38</td>					<td> 24 </td></tr>
				<tr><td>8 </td>	  <td> 6-6.5 </td>	<td>39</td>					<td>24.5</td></tr>
				<tr><td>9 </td>   <td> 7-7.5 </td>	<td>40</td>					<td> 25 </td></tr>
				<tr><td>10</td>	  <td> 8-8.5 </td>	<td>41</td>					<td>25.5</td></tr>
				<tr><td>11</td>   <td> 9-9.5 </td>	<td>42</td>					<td> 26 </td></tr>
				<tr><td>12</td>   <td>10-10.5</td>	<td>43</td>					<td>26.5</td></tr>
				<tr><td>13</td>   <td>11-11.5</td>	<td>44</td>					<td> 27 </td></tr>
				<tr><td>14</td>   <td>12-12.5</td> 	<td>45</td>					<td>27.5</td></tr>
				</tbody>
			</table>
			<table id="table-clothes"  class="hide" cellspacing="0">
				<tbody>
				<tr><th>Size</th>			<th>US</th>	<th>UK</th>	<th>AUSTRALIA</th>	<th>EUROPEAN</th>	</tr>
				<tr><td>XXS</td>			<td>0</td>	<td>4</td>	<td>4</td>					<td>32</td>				</tr>
				<tr><td>XS </td>			<td>2</td>	<td>6</td>	<td>6</td>					<td>34</td>				</tr>
				<tr><td>S  </td>			<td>4</td>	<td>8</td>	<td>8</td>					<td>36</td>				</tr>
				<tr><td>M  </td>			<td>6</td>	<td>10</td>	<td>10</td>					<td>38</td>				</tr>
				<tr><td>L  </td>			<td>8</td>	<td>12</td>	<td>12</td>					<td>40</td>				</tr>
				<tr><td>XL </td>			<td>10</td>	<td>14</td>	<td>14</td>					<td>42</td>				</tr>
				<tr><td>XXL</td>			<td>12</td>	<td>16</td>	<td>16</td>					<td>44</td>				</tr>
				</tbody>
			</table>
		</dd>
</dl>
	

<dl id="product-related" class="enhance pink" >
	<dt><strong>We Recommend</strong></dt>

	<dd style="height:200px;"><div class="m-banner" >
	  	<div class="banner-list">
	    	<ul class="fix" style="height:200px;"><?php
            $key = 0;
            foreach ($product->related_products() as $related_product):
            	if (!Product::instance($related_product)->get('visibility'))
                    continue;
                else
                    $key++;
                if ($key == 6)
                    break;
                $relate_name = Product::instance($related_product)->get('name');
                ?>
                <li><a href="<?php echo Product::instance($related_product)->permalink(); ?>" title="<?php echo $relate_name; ?>">
                	<img src="<?php echo image::link(Product::instance($related_product)->cover_image(), 3); ?>" alt="<?php echo $relate_name; ?>"/></a></li>
            <?php endforeach; ?>
	    	</ul>
	  	</div>
	  	<span class="in-btn1"><a></a></span><span class="in-btn2"><a></a></span> 
		</div>
	</dd>
</dl>
	
<script type="text/javascript">
	$(document).ready(function() {
        if(window.location.hash != '')
        {
        	$(window.location.hash).removeClass('closed');
       	}
        
		$(".tabchange").click(function(){
			var tab = $(this).attr('href');

			if( $(tab).attr('class')=='closed' )
			{
				$(tab).removeClass('closed');
			}else{
				$(tab).addClass('closed');
			}
    	})
	});

	function tab_size()
	{
		$("#tab-shoes").toggleClass("inactive");
		$("#tab-clothes").toggleClass("inactive");
		$("#table-shoes").toggleClass("hide");
		$("#table-clothes").toggleClass("hide");
	}
</script>
	
	