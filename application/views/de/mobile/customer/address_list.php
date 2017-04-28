<style>
.clsbtn {background: url("../images/close.png") no-repeat scroll 0 0 transparent; cursor: pointer;
    height: 25px; position: absolute; right: 25px; top: 325px; width: 25px; z-index: 129;}
</style>

<p id="crumbs"><a href="<?php echo LANGPATH; ?>/">Home</a> / <a href="<?php echo LANGPATH; ?>/mobilecustomer/summary">My Account</a> / Address List </p>
<p>Here you may modify or delete the shipping addresses you have provided to us. You may also add new shipping addresses 
	which you can use for your order in the payment process.</p>
<h3>Address List</h3>

<div id="account-addresses">
	<?php echo Message::get(); ?>
	<?php foreach ($addresses as $address): ?>
	<ul class="address_box">
		<li></li>
		<li><?php echo $address['firstname'] . ' ' . $address['lastname']; ?></li>
		<li><?php echo $address['address']; ?></li>			
		<li><?php echo $address['city'] . ' ' . $address['state'] . ' ' . $address['zip'] . ' ' . $address['phone']; ?></li>
		<li><?php echo $address['country']; ?></li>
		
		<li>
			<div class="hide" id="catalog_link" style="position: fixed; top: 0px;left: 0px;width: 400px;height: 400px; z-index:1000; background: #FFFFFF; border-color: #F6F6F7; border:#CCC 1px solid;">
	        	<div class="order order_addtobag">
	                <iframe id="cart_address" style="border: none;" width="400px" height="400px" src=""></iframe>
	        	</div>
	        	<div class="clsbtn" style="right: -0px;top: 3px;"></div>
			</div></li>
		<li>
			<form class="functions" action="" method="post">
				<a href="#" class="btn-edit edit" id="<?php echo $address['id']; ?>">Edit</a>
				<input type="submit" value="Delete" class="del button gray" id="<?php echo $address['id']; ?>">
			</form>
			</li>
	</ul>
	<?php endforeach; ?>
	
<script type="text/javascript">
        $(function(){
                $(".address_box .edit").live("click",function(){
                	$('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                    $('#catalog_link').appendTo('body').fadeIn(320);
                        var id = $(this).attr('id');
                        $('#cart_address').attr('src', '/mobileaddress/ajax_edit/'+id+'?return_url=/mobilecustomer/address')
                        $('#catalog_link').show();
                        return false;
                })
                
                $("#catalog_link .clsbtn,#wingray").live("click",function(){
                        $("#wingray").remove();
                        $('#catalog_link').fadeOut(160).appendTo('#tab2');
                        return false;
                })
                
                $(".address_box .del").live("click", function(){
                        $('body').append('<div id="wingray1" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                        $('#cart_delete').appendTo('body').fadeIn(320);
                        var id = $(this).attr('id');
                        $("#address_id").val(id);
                        $('#cart_delete').show();
                        return false;
                })
                
                $("#cart_delete .clsbtn,#cart_delete .cancel,#wingray1").live("click",function(){
                        $("#wingray1").remove();
                        $('#cart_delete').fadeOut(160).appendTo('#tab2');
                        return false;
                })
                
                $("#addressEdit").live("click", function(){
                        $("#shpping").hide();
                        $("#addresses").show();
                })
                
                $("#add_new").live("click", function(){
                        $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                        $('#catalog_link').appendTo('body').fadeIn(320);
                        $('#cart_address').attr('src', '/mobileaddress/ajax_edit')
                        $('#catalog_link').show();
                        return false;
                })
        })
</script>

	<div class="hide" id="cart_delete" style="position: fixed;padding: 10px 10px 20px; top: 170px;left: 10px; z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border:1px solid #cdcdcd;">
        <div style="font-size: 1.4em;margin-top:0px;border-bottom: 2px solid #F4F4F4;">CONFIRM ACTION</div>
        <div class="order order_addtobag" style="margin:20px;">
                <div style="font-size:13px;margin-bottom: 20px;">Are you sure you want to delete this? It cannot be undone.</div>
                <form action="/mobileaddress/ajax_delete" method="post">
                <input type="hidden" name="address_id" id="address_id" value="" />
                <input type="hidden" name="return_url" value="/mobilecustomer/address" />
                <input type="submit" class="allbtn btn-apply" value="DELETE" />
                <a href="#" class="cancel" style="text-decoration:underline;margin-left:10px;">Cancel</a>
                </form>
        </div>
        <div class="clsbtn" style="right: -0px;top: 3px;"></div>
	</div>
	<a href="#" class="button boxed btn-add-address" id="add_new" value="Add New Address" name="submit">Add an Address</a>

</div>

