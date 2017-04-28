<script type="text/javascript" src="css_mobile/jquery_choies.js"></script>
<script type="text/javascript" src="css_mobile/jcarousellite.js"></script>
<style type="text/css">
#mycarousel {overflow: hidden; position: relative; top: 0px; margin: 0px; padding: 0px; left: 0px; }
.carousel ul li{float: left; list-style: none;}	
.carousel ul>li img{display:inline-block; width:300px; height:196px;}				
</style>

<script type="text/javascript">
$(document).ready(function(){
	var mao = window.location.hash;
	if(mao){
		$("#home-carousel").addClass("reveal-modal");
		$(".main-navigation").addClass("reveal-modal");
		$(mao).removeClass("reveal-modal");
	}
	
	$("a.toggler").click(function() {
			$("#home-carousel").addClass("reveal-modal");
			$(".main-navigation").addClass("reveal-modal");
		    $($(this).attr('href')).removeClass("reveal-modal");
		    return 1;
	});

	$(".m-banner .banner-list").jCarouselLite({
		btnPrev:".m-banner .in-btn1",
		btnNext:".m-banner .in-btn2",
		auto:10000,
		visible:1
	});
	
});
</script>

<div style="text-align:center;"><img src="/images/mobile/5coupon.png" alt="coupon" /></div>
<!--banner start-->
<div class="m-banner">
  <div class="banner-list">
    <ul class="fix">
    	<li><a href="<?php echo LANGPATH; ?>/mobile/catalog/the-solid-soft"><img src="/images/mobile/banner3.jpg" alt="" /></a></li>
    	<!--li><a href="<?php echo LANGPATH; ?>/mobile/catalog/woolen-coat-on-sale"><img src="/images/mobile/banner5.jpg" alt="" /></a></li-->
    	<li><a href="<?php echo LANGPATH; ?>/mobile/catalog/jewelry-sale"><img src="/images/mobile/banner2.jpg" alt="" /></a></li>
    	<!--li><a href="<?php echo LANGPATH; ?>/mobile/catalog/choies-latest-design"><img src="/images/mobile/banner1.jpg" alt="" /></a></li-->
    </ul>
  </div>
  <span class="in-btn1"><a></a></span><span class="in-btn2"><a></a></span> </div>
<!--banner end-->


<nav class="main-navigation" >
	<ul>
		<!--li><a class="toggler" href="#weekly-new"><span>NEW IN</span></a></li-->
		<li><a class="toggler" href="#daily-new"><span>DAILY NEW</span></a></li> 
		<li><a class="toggler" href="#shoes"><span>SHOES</span></a></li>
		<li><a class="toggler" href="#apparels"><span>APPAREL</span></a></li>
		<li><a class="toggler" href="#mans"><span>MEN'S</span></a></li>
		<li><a class="toggler" href="#accessory"><span>ACCESSORIES</span></a></li>
		<li><a class="toggler" href="#brands"><span>BRANDS</span></a></li>
		<li><a class="toggler" href="#outlet"><span>OUTLET</span></a></li>
	</ul>
</nav>

<!--nav id="weekly-new" class="main-navigation fam reveal-modal">
	<h1 >NEW IN</h1>
	<a href="<?php echo LANGPATH; ?>/" class="back">Back</a>
	<ul>
		<?php
    //     $today = strtotime('midnight') + 86400;
  		// for ($i = 0; $i <= 4; $i++):
    //        	$to = $today - $i * 604800 + 86400;
    //        	$from = strtotime('-1 week', $to);
          	?>
            <li><a href="<?php echo LANGPATH; ?>/mobile/catalog/weekly-new/<?php //echo $i ? $i : ''; ?>"><?php //echo 'WEEK ' . date('m.d', $from) . ' - ' . date('m.d', $to - 1); ?></a></li>
       <?php //endfor;?>
	</ul>
</nav-->
<nav id="daily-new" class="main-navigation fam reveal-modal">
	<h1 >NEW IN</h1>
	<a href="<?php echo LANGPATH; ?>/" class="back">Back</a>
	<ul>
		<?php
        $today = strtotime('midnight') - 50400;
        $i = 0;
        while ($i < 10):
            $to = $today - $i * 86400 + 86400;
            $i ++;
            ?>
            <li><a href="<?php echo LANGPATH; ?>/mobile/catalog/daily-new/<?php echo $i - 1 ? $i - 1 : ''; ?>"><?php echo date('Y-m-d', $to - 1); ?></a></li>
       <?php endwhile; ?>
	</ul>
</nav>

<nav id="shoes" class="main-navigation fam reveal-modal">
	<h1 class="shoes-white">Shoes</h1>
	<a href="<?php echo LANGPATH; ?>/" class="back">Back</a>
	<ul>
		<li><a href="<?php echo LANGPATH; ?>/mobile/catalog/shoes/new">NEW IN</a></li>
		<?php
        $catalog1 = DB::select('id')->from('products_category')->where('link', '=', 'shoes')->execute()->current();
        $apparels = Catalog::instance($catalog1['id'])->children();
       	foreach ($apparels as $catalog):
        	?>
      		<li><a href="<?php echo LANGPATH; ?>/mobile/catalog/<?php echo Catalog::instance($catalog)->get('link'); ?>"><?php echo ucfirst(Catalog::instance($catalog, LANGUAGE)->get('name')); ?></a></li>
            <?php
       endforeach;  ?>
	</ul>
</nav>


<nav id="apparels" class="main-navigation fam reveal-modal">
	<h1>APPAREL</h1>
	<a href="<?php echo LANGPATH; ?>/" class="back">Back</a>
	<ul>
		<li><a href="<?php echo LANGPATH; ?>/mobile/catalog/apparels/new">NEW IN</a></li>
		<?php
        $catalog1 = DB::select('id')->from('products_category')->where('link', '=', 'apparels')->execute()->current();
        $apparels = Catalog::instance($catalog1['id'])->children();
        foreach ($apparels as $catalog):
          	?>
            <li><a href="<?php echo LANGPATH; ?>/mobile/catalog/<?php echo Catalog::instance($catalog)->get('link'); ?>"><?php echo ucfirst(Catalog::instance($catalog, LANGUAGE)->get('name')); ?></a></li>
           	<?php
      	endforeach; ?>
	</ul>
</nav>

<?php if(isset($asd)){?>
<nav id="occasion-dresses" class="main-navigation fam reveal-modal">
	<h1>PROM DRESSES</h1>
	<a href="<?php echo LANGPATH; ?>/" class="back">Back</a>
	<ul>
		<?php
     	$catalog2 = DB::select('id')->from('products_category')->where('link', '=', 'occasion-dresses')->execute()->current();
        $dresses = Catalog::instance($catalog2['id'])->children();
        foreach ($dresses as $catalog):
        	?>
          	<li><a href="<?php echo LANGPATH; ?>/mobile/catalog/<?php echo Catalog::instance($catalog)->get('link'); ?>"><?php echo ucfirst(Catalog::instance($catalog, LANGUAGE)->get('name')); ?></a></li>
            <?php
      	endforeach; ?>
	</ul>
</nav>
<?php }?>

<nav id="accessory" class="main-navigation fam reveal-modal">
	<h1>ACCESSORY</h1>
	<a href="<?php echo LANGPATH; ?>/" class="back">Back</a>
	<ul>
		<li><a href="<?php echo LANGPATH; ?>/mobile/catalog/weekly-new">NEW IN</a></li>
		<?php
        $catalog3 = DB::select('id')->from('products_category')->where('link', '=', 'accessory')->execute()->current();
       	$accessory = Catalog::instance($catalog3['id'])->children();
        foreach ($accessory as $catalog):
           	?>
            <li><a href="<?php echo LANGPATH; ?>/mobile/catalog/<?php echo Catalog::instance($catalog)->get('link'); ?>"><?php echo ucfirst(Catalog::instance($catalog, LANGUAGE)->get('name')); ?></a></li>
            <?php
    	endforeach; ?>
	</ul>
</nav>


<nav id="mans" class="main-navigation fam reveal-modal">
	<h1>MEN'S</h1>
	<a href="<?php echo LANGPATH; ?>/" class="back">Back</a>
	<ul>
		<li><a href="<?php echo LANGPATH; ?>/mobile/catalog/men-s-collection">NEW IN</a></li>
		<?php
        $catalog2 = DB::select('id')->from('products_category')->where('link', '=', 'men-s-collection')->execute()->current();
       $dresses = Catalog::instance($catalog2['id'])->children();
        foreach ($dresses as $catalog):
           	?>
            <li><a href="<?php echo LANGPATH; ?>/mobile/catalog/<?php echo Catalog::instance($catalog)->get('link'); ?>"><?php echo ucfirst(Catalog::instance($catalog, LANGUAGE)->get('name')); ?></a></li>
            <?php
    	endforeach; ?>
	</ul>
</nav>

<nav id="brands" class="main-navigation fam reveal-modal">
	<h1>BRANDS</h1>
	<a href="<?php echo LANGPATH; ?>/" class="back">Back</a>
	<ul>
		<?php
     	$brands = DB::select('name', 'link')->from('products_category')->where('is_brand', '=', 1)->where('visibility', '=', 1)->where('on_menu', '=', 0)
     					->where('parent_id', '=', 0)->order_by('position', 'DESC')->execute()->as_array();
        foreach ($brands as $catalog):
          	?>
            <li><a href="<?php echo LANGPATH; ?>/mobile/catalog/<?php echo $catalog['link']; ?>"><?php echo ucfirst($catalog['name']); ?></a></li>
            <?php
      	endforeach;  ?>
	</ul>
</nav>

<nav id="outlet" class="main-navigation fam reveal-modal">
	<h1>OUTLET</h1>
	<a href="<?php echo LANGPATH; ?>/" class="back">Back</a>
	<ul>
		<li><a href="<?php echo LANGPATH; ?>/mobile/catalog/outlet/new">NEW IN</a></li>
		<?php
        $catalog4 = DB::select('id')->from('products_category')->where('link', '=', 'outlet')->execute()->current();
        $outlet = Catalog::instance($catalog4['id'])->children();
       	foreach ($outlet as $catalog):
        	?>
      		<li><a href="<?php echo LANGPATH; ?>/mobile/catalog/<?php echo Catalog::instance($catalog)->get('link'); ?>"><?php echo ucfirst(Catalog::instance($catalog, LANGUAGE)->get('name')); ?></a></li>
            <?php
       	endforeach;  ?>
	</ul>
</nav>


