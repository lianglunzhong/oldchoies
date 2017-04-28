<?php echo View::factory('admin/site/feedback_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript">
$(function() {
	var dates = $( "#time" ).datepicker({
		dateFormat:"yy-mm-dd",
		changeMonth: true,
		changeYear: true,
		yearRange: '2013:2024',
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

    $("#sku").blur(function(){
        var sku = $(this).val();
        if(sku)
        {
            $.ajax({
                type: "POST",
                url: "/admin/site/review/product_attributes",
                dataType: "json",
                data: "sku="+sku,
                success: function(msg){
                    if(msg.success)
                    {
                        $("#attributes").html(msg.html);
                    }
                }
            });
            return false;
        }
    })
});
</script>
<div id="do_right">
    <form method="post" action="#" class="need_validation">
        <div class="box">
            <h3>Review Add<span class="moreActions"><a href="/admin/site/review/list">Back to review list</a></span></h3>

            <ul>
                <li>
                    <label>SKU</label>
                    <div><input name="sku" id="sku" type="text" value="" class="short text required"></div>
                </li>

                <li>
                    <label>Attribute</label>
                    <div id="attributes">

                    </div>
                </li>

                <li>
                    <label>Time</label>
                    <div><input id="time" name="time" type="text" value="" class="short text required"></div>
                </li>

                <li>
                    <label>User_id</label>
                    <div><input name="user_id" type="text" value="0" class="short text required"></div>
                </li>

                <li>
                    <label>Firstname</label>
                    <div><input name="firstname" type="text" value="" class="short text required"></div>
                </li>

                <li>
                    <label>Overall Rating: </label>
                    <div>
                    	<input id="overall_1" type="radio" name="overall" value="1" >&nbsp;<label for="overall_1">I hate it</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="overall_2" type="radio" name="overall" value="2" >&nbsp;<label for="overall_2">I don’t like it</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="overall_3" type="radio" name="overall" value="3" >&nbsp;<label for="overall_3">It’s okay</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="overall_4" type="radio" name="overall" value="4" >&nbsp;<label for="overall_4">I like it</label></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="overall_5" type="radio" name="overall" value="5" checked>&nbsp;<label for="overall_5">I love it</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                </li>

                <li>
                    <label>Quality Rating: </label>
                    <div>
                        <input id="quality_1" type="radio" name="quality" value="1" >&nbsp;<label for="quality_1">I hate it</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="quality_2" type="radio" name="quality" value="2" >&nbsp;<label for="quality_2">I don’t like it</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="quality_3" type="radio" name="quality" value="3" >&nbsp;<label for="quality_3">It’s okay</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="quality_4" type="radio" name="quality" value="4" >&nbsp;<label for="quality_4">I like it</label></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="quality_5" type="radio" name="quality" value="5" checked>&nbsp;<label for="quality_5">I love it</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                </li>

                <li>
                    <label>Price Rating: </label>
                    <div>
                        <input id="price_1" type="radio" name="price" value="1" >&nbsp;<label for="price_1">Very Expensive</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="price_2" type="radio" name="price" value="2" >&nbsp;<label for="price_2">Expensive</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="price_3" type="radio" name="price" value="3" >&nbsp;<label for="price_3">Reasonable</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="price_4" type="radio" name="price" value="4" >&nbsp;<label for="price_4">Cheap</label></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="price_5" type="radio" name="price" value="5" checked>&nbsp;<label for="price_5">Very Cheap</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                </li>

                <li>
                    <label>Fitness Rating: </label>
                    <div>
                        <input id="fitness_1" type="radio" name="fitness" value="1" >&nbsp;<label for="fitness_1">Very small</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="fitness_2" type="radio" name="fitness" value="2" >&nbsp;<label for="fitness_2">Small</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="fitness_3" type="radio" name="fitness" value="3" checked>&nbsp;<label for="fitness_3">Neutral</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="fitness_4" type="radio" name="fitness" value="4" >&nbsp;<label for="fitness_4">Large</label></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="fitness_5" type="radio" name="fitness" value="5" >&nbsp;<label for="fitness_5">Very large</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                </li>

                <li>
                    <label>Height(CM)</label>
                    <div><input name="height" type="text" value="" class="short text required"></div>
                </li>

                <li>
                    <label>Weight(KG)</label>
                    <div><input name="weight" type="text" value="" class="short text required"></div>
                </li>

                <li>
                    <label>Is Approved</label>
                    <div>
                        Yes:<input name="is_approved" type="radio" value="1" checked>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        No:<input name="is_approved" type="radio" value="0">
                    </div>
                </li>
                
                <li>
                    <label>Content</label>
                    <div><textarea name="content" rows="8" cols="90" class="required"></textarea></div>
                </li>
                <li>
                    <label>Reply</label>
                    <div><textarea name="reply" rows="8" cols="90"></textarea></div>
                </li>
                
                <li>
                    <button type="submit">Save</button>
                </li>

            </ul>
        </div>
    </form>
</div>



