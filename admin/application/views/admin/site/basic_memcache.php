<?php echo View::factory('admin/site/basic_left')->render(); ?>
<script>
$(function(){
        $(".type").click(function(){
                var val = $(this).val();
                if(val == 'index')
                {
                        $("#catalog").hide();
                        $("#product").hide();
                }
                else if(val == 'catalog')
                {
                        $("#catalog").show();
                        $("#product").hide();
                }
                else if(val == 'product')
                {
                        $("#catalog").hide();
                        $("#product").show();
                }
        })
})
</script>
<div id="do_right">
        <div class="box">
                <h3>Site Memcache Delete</h3>
                <form action="" method="post" name="form1" id="form1">
                        <ul>
                                <li>
                                        <label>Type:</label>
                                        <div style="margin-top:5px;">
                                                <input type="radio" class="type" name="type" value="index"> <label class="note" style="font-size:14px;">Index</label><br/><br/>
                                                <input type="radio" class="type" name="type" value="catalog"> <label class="note" style="font-size:14px;">Catalog</label><br/><br/>
                                                <input type="radio" class="type" name="type" value="product"> <label class="note" style="font-size:14px;">Product</label>
                                        </div>
                                </li>
                                <li id="catalog" style="display:none;">
                                        <label>Catalog Link:</label>
                                        <div><input class="text long" type="text" id="fb_api_id" name="catalog" value=""></div>
                                </li>
                                <li id="product" style="display:none;">
                                        <label>Product Link:</label>
                                        <div><input class="text long" type="text" id="fb_api_secret" name="product" value=""></div>
                                </li>
                                <li>
                                        <div><input type="submit" value="Submit"></div>
                                </li>
                        </ul>
                </form>
        </div>
</div>
