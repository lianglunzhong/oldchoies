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
            <h3>Video Edit<span class="moreActions"><a href="/admin/site/review/video">Back to video list</a></span></h3>

            <ul>
                <li>
                    <label>Product Info: </label>
                    <div>SKU: <?php echo $product->get('sku');?> - Name: <a href="<?php echo $product->permalink();?>"><?php echo $product->get('name');?></a></div>
                </li>
                <li>
                    <label>Customer Email: </label><span style="color:#088;"><?php echo Customer::instance($review->customer_id)->get('email');?></span>
                </li>
                <li>
                    <label>Upload Time: </label><input id="time" name="time" type="text" value="<?php echo date('Y-m-d',$review->created); ?>" class="short text required">
                </li>
                <li>
                    <label>Video Details: </label>
                    <div>
                        <span style="width: 72px; display: inline-block">Caption: </span>
                        <input name="video_caption" type="text" value="<?php echo $review->caption ?>" class="short text required"><br/>
                        <span style="width: 72px; display: inline-block">Video URL: </span>
                        <input name="video_url" type="text" value="<?php echo $review->url_add ?>" class="short text required">
                    </div>
                </li>
                <li>
                    <label>Is Valid ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <span>
                        <?php if($review->checked):?>
                        <input type="radio" name="valid" value="1" checked="true" /><label>Yes</label>
                        <input type="radio" name="valid" value="0" /><label>No</label>
                        <?php else:?>
                        <input type="radio" name="valid" value="1" /><label>Yes</label>
                        <input type="radio" name="valid" value="0" checked="true" /><label>No</label>
                        <?php endif; ?>
                    </span>
                </li>
                <!--<li>
                    <label>Rmarks</label>
                    <div><textarea name="video_remarks" rows="8" cols="90"><?php //echo $review->remarks;?></textarea></div>
                </li>-->
                <li>
                    <br/><br/><button type="submit" style="width:100px;height:36px;color:#08C;font-weight: bold;background:#f8f8f8;border:#d9d9d9 1px solid;cursor: pointer;">Save</button>
                </li>
            </ul>
        </div>
    </form>
</div>