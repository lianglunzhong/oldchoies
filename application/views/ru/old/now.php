<?php
 date_default_timezone_set('America/Chicago');
 $user = Customer::instance(Customer::logged_in())->get();
 if($user == '')
 {
       Request::instance()->redirect(URL::base().'customer/login?redirect=catnip-freebie');
 }
?>
<section class="container">
<section class="icontainer fix">
  <article class="main">
    <article class="imain">
      <nav>
        <ul class="fix">
          <li><a href="http://<?php echo Site::instance()->get('domain');?>/dog" title="Dog" class="first">Dog</a></li>
          <li><a href="http://<?php echo Site::instance()->get('domain');?>/cat" title="Cat">Cat</a></li>
          <li><a href="http://<?php echo Site::instance()->get('domain');?>/boutique-for-dog" title="Dog Boutique">Dog Boutique</a></li>
          <li><a href="http://<?php echo Site::instance()->get('domain');?>/boutique-for-cat" title="Cat Boutique ">Cat Boutique </a></li>
          <li><a href="http://<?php echo Site::instance()->get('domain');?>/bestsellers" title="Bestsellers" class="last">Bestsellers</a></li>
          <li><a href="http://<?php echo Site::instance()->get('domain');?>/new-arrivals" title="New Arrivals" class="last">New Arrivals</a></li>
        </ul>
      </nav>
<article class="category">
      <div class="crumb"><h1>Catnip Freebie &gt;&gt;</h1> Back to: <a href="<?php echo LANGPATH; ?>/" title="">Home</a></div>
      <style type="text/css">
.bohe{ width:780px; margin:0 auto;}
.bohe img{ display:block; border:0;}
.bohe .top{ width:724px; height:90px; padding:11px 0 0 56px; background: url(images/bohe01.jpg) no-repeat; font-size:16px; color:#fff;}
.bohe .top .strong{ font-weight:bold; font-size:12px;}
.bohe .fb-show{ position:relative; width:780px; height:86px; background:url(images/bohe02.jpg) no-repeat;}
.bohe .fb-show .fb-sign{ position:absolute; top:36px; left:126px; width:210px; height:32px; background:url(images/fb_sign.gif) no-repeat;}
.bohe .fb-show .fb-like{ position:absolute; top:27px; left:336px; width:114px; height:41px; background:url(images/fb_like.gif) no-repeat;}
.bohe .fb-share{ position:relative; width:780px; height:104px; background:url(images/bohe04-1.jpg) no-repeat;}
.bohe .fb-share .share{ position:absolute; top:17px; left:101px; width:360px; height:40px; background:url(images/fb_share.gif) no-repeat;}
.bohe .bohepr{ position:relative; width:780px; height:339px;}
.bohe .bohepr .img{ float:left; width:230px; height:339px;}
.bohe .bohepr .pr{ position:relative; float:left; width:550px; height:339px; background:url(images/bohepr_r.jpg) no-repeat;}
.bohe .bohepr .add1{ position:absolute; top:59px; left:313px;}
.bohe .bohepr .add2{ position:absolute; top:229px; left:313px;}
</style>
    <div class="bohe">
         <div class="top">
         </div>
         <div class="fb-show">
         <?php  
		$facebook = new facebook();
	    $loginUrl = $facebook->getLoginUrl(array('scope' => array('email')));
 ?>
            <a href="<?php echo $loginUrl; ?>" class="fb-sign" title="sign in with facebook"></a>
            <a href="#sclRXE" class="fb-like" title="and like us"></a>
         </div>
         <div>
            <img src="images/bohe03.jpg" width="779" height="214" />
         </div>
         
         <div class="fb-share">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://www.myfavoritepetshop.com/catnip-freebie');?>" class="share" title="share on facebook with your freinds &amp; relatives" target="_blank"></a>
         </div>
         
         <div>
            <img src="images/bohe-title1.gif" width="780" height="30" />
         </div>
<script type="text/javascript">
$(document).ready(function(){
		var times = <?php echo time();?>;
		var time_start= <?php echo $freeday;?>;
		var Interval = time_start - times;
		var amount = [<?php echo $amount[0]?> , <?php echo $amount[1]?>];
		if(Interval > 0){
			$('#add_1').html('<a href="javascript:void(0);" title="add to cart" class="add1"><img src="images/bohe_add_gray.gif" width="196" height="42" /></a>');
			$('#add_2').html('<a href="javascript:void(0);" title="add to cart" class="add2"><img src="images/bohe_add_gray.gif" width="196" height="42" /></a>');
			setTimeout("show_time("+Interval+")",1000);
		}else{
			if(amount[0] > 0){
				$('#add_1').html('<a href="javascript:void(0);" onclick="checks(<?php echo $product[0]->get('id'); ?>);" title="add to cart" class="add1"><img src="images/bohe_add.gif" width="196" height="42" /></a>');
			}else{
				$('#add_1').html('<a href="javascript:void(0);" title="add to cart" class="add1"><img src="images/bohe_soldout.gif" width="196" height="60" /></a>');
			}
			if(amount[1] > 0){
				$('#add_2').html('<a href="javascript:void(0);" onclick="checks(<?php echo $product[1]->get('id'); ?>);" title="add to cart" class="add2"><img src="images/bohe_add.gif" width="196" height="42" /></a>');
			}else{
				$('#add_2').html('<a href="javascript:void(0);" title="add to cart" class="add2"><img src="images/bohe_soldout.gif" width="196" height="60" /></a>');
			}
		}
});
function show_time(Interval){
	if(Interval > 0){
		Interval = Interval - 1;
		setTimeout("show_time("+Interval+")",1000); 
	}else{
		$('#add_1').html('<a href="javascript:void(0);" onclick="checks(<?php echo $product[0]->get('id'); ?>);" title="add to cart" class="add1"><img src="images/bohe_add.gif" width="196" height="42" /></a>');
		$('#add_2').html('<a href="javascript:void(0);" onclick="checks(<?php echo $product[1]->get('id'); ?>);" title="add to cart" class="add2"><img src="images/bohe_add.gif" width="196" height="42" /></a>');
		clearTimeout();
	}
}
</script>         
         <!-- freebie body -->
         <div class="bohepr fix">
            <div class="img">
                <a href="http://www.myfavoritepetshop.com/product/yeowww-catnip-mini-4-gram-bag" title="Catnip Mini, 4 gram bag">
                    <img src="images/bohepr.jpg" width="230" height="339" alt="Catnip Mini, 4 gram bag" />
                </a>
            </div>
            <div class="pr">
            	<form action="" method="post" id="form_<?php echo $product[0]->get('id'); ?>">
                    <input type="hidden" name="id" id="product_id" value="<?php echo $product[0]->get('id'); ?>" />
                    <input type="hidden" name="sku" value="<?php echo $product[0]->get('sku'); ?>" />
                    <input type="hidden" name="type" value="<?php echo $product[0]->get('type'); ?>" />
                    <input type="hidden" name="quantity" value="1" />
                    <input type="hidden" name="amount" value="" id="amount_<?php echo $product[0]->get('id'); ?>" />
                    <input type="hidden" name="items[]" value="<?php echo $product[0]->get('id'); ?>" />
                    <input type="hidden" name="arguments[permalink]" value="<?php echo $product[0]->permalink(); ?>" />
                    <article id='add_1'></article>
                 
                 </form>
                 
                 <form action="" method="post" id="form_<?php echo $product[1]->get('id'); ?>">
                    <input type="hidden" name="id" id="product_id" value="<?php echo $product[1]->get('id'); ?>" />
                    <input type="hidden" name="sku" value="<?php echo $product[1]->get('sku'); ?>" />
                    <input type="hidden" name="type" value="<?php echo $product[1]->get('type'); ?>" />
                    <input type="hidden" name="quantity" value="1" />
                    <input type="hidden" name="amount" value="" id="amount_<?php echo $product[1]->get('id'); ?>" />
                    <input type="hidden" name="items[]" value="<?php echo $product[1]->get('id'); ?>" />
                    <input type="hidden" name="arguments[permalink]" value="<?php echo $product[1]->permalink(); ?>" />
                 	<article id='add_2'></article>
                 </form>
            </div>
        </div>
        <!-- freebie body end -->
        
        <div style="display:none;" id="more1">
        	<form action="/cart/add" method="post" id="form-3">
            	<input type="hidden" value="<?php echo $product[2]->get('id'); ?>" name="id">
                <input type="hidden" value="<?php echo $product[2]->get('type'); ?>" name="type">
                <input type="hidden" value="<?php echo $product[2]->get('id'); ?>" name="items[]">
                <input type="hidden" name="quantity" value="1" class="num" />
            <a href="javascript:void(0);" onclick="_submit();"><img src="images/bohe_banner01.jpg" width="780" height="228" /></a>
            </form>
        </div>
        <div style="display:none;" id="more2">
            <a href="http://<?php echo Site::instance()->get('domain');?>/cat"><img src="images/bohe_banner02.jpg" width="779" height="365" /></a>
        </div>
    </div>
</article>
<script type="text/javascript">
function _submit()
{
	$('#form-3').submit();	
}
function checks(o){
$.ajax({
	type: "POST",
	url: "/site/gettime/"+o,
	data: "",
	success: function(msg){
		   msg = eval( '('+msg+')' );
		   
		   if(msg['state'] == 'ok')
		   {
			    $('#amount_'+o).val(msg['amount']);
			    $('#form_'+o).attr('action', '/cart/addfreebie');
				$('#form_'+o).submit();
				return true;
		   }else if(msg['state'] == 'faild'){
			    alert("The item is sold out.");
				if(msg['product_id'] == '<?php echo $product[0]->get('id'); ?>'){
					$('#add_1').html('<a href="javascript:void(0);" title="add to cart" class="add1"><img src="images/bohe_soldout.gif" width="196" height="60" /></a>');
				}else{
					$('#add_2').html('<a href="javascript:void(0);" title="add to cart" class="add2"><img src="images/bohe_soldout.gif" width="196" height="60" /></a>');
				}
				$("#more1").show();
				$("#more2").show();
		   }else {
				alert(msg['state']);
				return false;
		   }
		 }
});	
}
</script>      
<?php echo View::factory('footer')->render(); ?>
<aside>
	<?php echo View::factory('aside_catalog')->set('catalog',$catalog)->render();?>
  </aside>