<?php echo View::factory('admin/site/feedback_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript">
$(function() {
	var dates = $( "#time" ).datepicker({
		dateFormat:"yy-mm-dd",
		changeMonth: true,
		changeYear: true,
		yearRange: '2000:2012',
		onSelect: function( selectedDate ) {
			var option = this.id == "from" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
});
</script>
<div id="do_right">
    <form method="post" action="#" name="form_add_set" class="need_validation">
        <div class="box">
            <h3>Review Edit<span class="moreActions"><a href="/admin/site/review/list">Back to review list</a></span></h3>

            <ul>
                <li>
                    <label>Product</label>
                    <div><a href="<?php echo $product->permalink();?>"><?php echo $product->get('name');?></a> - SKU: <?php echo $product->get('sku');?></div>
                </li>

                <li>
                    <label>Time</label>
                    <div><input id="time" name="time" type="text" value="<?php echo date('Y-m-d',$review->time); ?>" class="short text required"></div>
                </li>

                <li>
                    <label>User details</label>
                    <div>
                    <?php 
                    if($review->is_fake==1):
                    ?>
                    <input name="fake_name" type="text" value="<?php echo $review->fake_name ?>" class="short text required">
                    <?php else:
                    	echo '#'.$user->get('id').', '.$user->get('firstname').' '.$user->get('lastname').', '.$user->get('email');
                    endif;
                    	?>
                    </div>
                </li>

                <li>
                    <label>Overall</label>
                    <div><input name="overall" <?php if($review->is_fake!=1) echo 'disabled="disabled"';?> class="short text" type="text" value="<?php echo $review->overall; ?>"></div>
                </li>

                <li>
                    <label>Quality</label>
                    <div><input name="quality" <?php if($review->is_fake!=1) echo 'disabled="disabled"';?> class="short text" type="text" value="<?php echo $review->quality; ?>"></div>
                </li>

                <li>
                    <label>Price</label>
                    <div><input name="price" <?php if($review->is_fake!=1) echo 'disabled="disabled"';?> class="short text" type="text" value="<?php echo $review->price; ?>"></div>
                </li>

                <li>
                    <label>Fitness</label>
                    <div><input name="fitness" <?php if($review->is_fake!=1) echo 'disabled="disabled"';?> class="short text" type="text" value="<?php echo $review->fitness; ?>"></div>
                </li>

                <li>
                    <label>Content</label>
                    <div><textarea name="content" rows="8" cols="90" <?php if($review->is_fake!=1) echo 'disabled="disabled"';?> class="required"><?php echo $review->content;?></textarea></div>
                </li>
                <li>
                    <label>Reply</label>
                    <div><textarea name="reply" rows="8" cols="90"><?php echo $review->reply;?></textarea></div>
                </li>
                
                <li>
                    <label>Height (CM)</label>
                    <div><input name="height" <?php if($review->is_fake!=1) echo 'disabled="disabled"';?> class="short text" type="text" value="<?php echo $review->height; ?>"></div>
                </li>

                <li>
                    <label>Weight (KG)</label>
                    <div><input name="weight" <?php if($review->is_fake!=1) echo 'disabled="disabled"';?> class="short text" type="text" value="<?php echo $review->weight; ?>"></div>
                </li>
                
                <li>
                    <div><input name="is_process" type="checkbox" id="is_process" <?php if($review->is_process) echo 'checked="checked"'; ?>><label for="is_process">已处理</label></div>
                </li>

                <li>
                    <button type="submit">Save</button>
                </li>

            </ul>
        </div>
    </form>
</div>



