<?php echo View::factory('admin/site/promotion_left')->render(); ?>
<script type="text/javascript">
	$(function(){
		$('input[name=discount_method],input[name=conditions]').click(function(){
			var $input = $('input[name=' + $(this).val() + ']');
			if($input.length){
				$input.removeAttr('disabled').siblings('input[type=text]').attr('disabled','disabled');
			}else {
				$(this).siblings('input[type=text]').attr('disabled','disabled');
			}
		});
		$('input[name=promotion_method]').click(function(){
			var $this = $(this),val = $this.val();
			if(val == 'discount') {
				$('.largess input').attr('disabled','disabled');
				$('input[name=' + $('.discount input[type=radio]:checked').val() + ']').removeAttr('disabled');
			}else if(val == 'largess'){
				$('.largess input').removeAttr('disabled');
				$('.discount input[type=text]').attr('disabled','disabled');
			}else if(val == 'free_delivery') {
				$('.largess input,.discount input[type=text]').attr('disabled','disabled');
			}
		});
		$('#add_largess').click(function(){
			if( ! $('#pmethod_2').is(':checked')){
				return false;
			}
			var $this = $(this),count = parseInt($this.attr('count')) + 1;
			var $div = $('<div class="form_item_content largess">\
							<label for="largess_SKU_' + count + '">SKU: </label><input name="largess[SKU][]" id="largess_SKU_' + count + '" class="inline short "/> &nbsp;&nbsp;&nbsp;&nbsp;\
							<label for="largess_price_' + count + '">价格: </label><input name="largess[price][]" id="largess_price_' + count + '" class="inline numeric" value="0"/> &nbsp;&nbsp;&nbsp;&nbsp;\
							<label for="largess_quantity_' + count + '">最大数量: </label><input name="largess[quantity][]" id="largess_quantity_' + count + '" class="inline numeric" value="1"/>&nbsp;&nbsp;<a href="#" class="delete_largess">删除本赠品</a>\
						</div>');
			$div.insertAfter($this.parent().parent().find('div:last'));
			$this.attr('count',count);
			return false;
		});
		$('.delete_largess').live('click',function(){
			if( ! $('#pmethod_2').is(':checked')){
				return false;
			}
			$(this).parent().remove();
			return false;
		});
		$(".datepick").datepicker().datepicker('option',{showAnim:'',dateFormat:'yy-mm-dd'});
		//TODO 验证表单 如果选择赠品，需要提供至少一个赠品
	});
</script>
<script type="text/javascript">
function type_change(slt)
{
    if (slt.value == 0)
    {
        $('#li_item_sku').hide();
        $('#li_coupon_value').hide();
    }
    else if (slt.value == 3)
    {
        $('#li_item_sku').show();
        $('#li_coupon_value').hide();
    }
    else
    {
        $('#li_item_sku').hide();
        $('#li_coupon_value').show();
    }
}
</script>
<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/admin/site/promotion/coupon_data?coupon_id=<?php echo $coupon->id; ?>',
            datatype: "json",
			height: 450,
			width: 500,
			colNames:['ID','customer_id','email','Action'],
			colModel:[
				{name:'id',index:'id', width:40},
				{name:'customer_id',index:'customer_id',align:'center', width:50},
                                {name:'email',index:'email', width:200},
				{width:60,search:false,formatter:actionFormatter}
			],
            rowNum:20,
            //  rowTotal: 12,
            rowList : [20,30,50],
            // loadonce:true,
            mtype: "POST",
            // rownumbers: true,
            // rownumWidth: 40,
            gridview: true,
            pager: '#ptoolbar',
            sortname: 'id',
            viewrecords: true,
            sortorder: "desc"
            //            caption: "Toolbar Searching"
		});

		jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
        jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});

        $('.delete').live('click',function(){
			if(!confirm('Delete this data?\nIt can not be undone!')){
				return false;
			}
		});
	});
	function actionFormatter(cellvalue,options,rowObject) {
		return '<a href="/admin/site/promotion/coupon_customer_delete/' + rowObject[0] + '" class="delete">Delete</a>';
	}
</script>
<div id="do_right">
    <div class="box" style="float:left;width:49%;">
        <h3>修改</h3>
        <form name="coupon_promotion" action="/admin/site/promotion/coupon_edit_go  " method="post">
            <input type="hidden" name="id" value="<?php echo $coupon->id;?>" />
            <ul>
                <li>
                <label><span class="req">*</span>折扣号: </label>
                <input name="coupon_number" class="coupon_number"  type="text" value="<?php echo $coupon->code;?>"  />
                </li>
                <li>
                <label><span class="req">*</span>折扣类型: </label>
                    <select name="coupon_type" onchange="type_change(this);">
                        <option value="0" <?php if ($coupon->type == 0) {print "selected"; } ?>>------------</option>
                        <option value="1" <?php if ($coupon->type == 1) {print "selected"; } ?>>减折扣</option>
                        <option value="2" <?php if ($coupon->type == 2) {print "selected"; } ?>>减价</option>
<!--                        <option value="4" <?php if ($coupon->type == 4) {print "selected"; } ?>>改价</option>-->
                        <option value="3" <?php if ($coupon->type == 3) {print "selected"; } ?>>赠品</option>
                    </select>
                </li>
                <li id="li_item_sku" <?php if ($coupon->type != 3): ?>style="display:none"<?php endif ?>>
                    <label>赠品SKU: </label>
                    <input name="item_sku" type="text" class="text numeric inline" value="<?php print $coupon->item_sku; ?>" />
                </li>
                <li id="li_coupon_value" <?php if ($coupon->type == 3): ?>style="display:none"<?php endif ?>>
                    <label>减折扣/减价/改价: </label>
                    <input name="coupon_value"  class="text numeric inline"  value="<?php print $coupon->value; ?>" type="text">
                </li>
                <li>
                <label><span class="req">*</span>折扣用途: </label>
                    <select name="coupon_set">
                        <?php foreach($coupons_sets as $coupons_set){ ?>
                            <option value="<?php echo $coupons_set['id']; ?>" <?php if($coupon->usedfor==$coupons_set['id'])echo 'selected'; ?>><?php echo $coupons_set['name']; ?></option>
                        <?php } ?>
                    </select>
                </li>
                <li>
                <input type="checkbox" id="condition_enable" <?php if ($coupon->condition): ?>checked="checked"<?php endif ?> onchange="if (this.checked) {$('#span_condition').show()} else {$('#span_condition').hide()}" />
                <label>最低消费限制: </label>
                <span id="span_condition" <?php if ($coupon->condition == 0): ?>style="display:none"<?php endif ?>>$<input type="text" name="condition" value="<?php print $coupon->condition; ?>" /></span>
                </li>
                <li>
                <input type="checkbox" id="catalog_enable" <?php if ($coupon->catalog_limit): ?>checked="checked"<?php endif ?> onchange="if (this.checked) {$('#span_catalog').show()} else {($('#span_catalog').hide())}" />
                <label>类别限制：</label>
                <span id="span_catalog" <?php if (empty($coupon->catalog_limit)): ?>style="display:none"<?php endif ?>><input type="text" name="catalog_limit" value="<?php print $coupon->catalog_limit; ?>" /> 填入类别ID，多个ID以逗号分隔</span>
                </li>
                <li>
                <input type="checkbox" id="catalog_enable" <?php if ($coupon->product_limit): ?>checked="checked"<?php endif ?> onchange="if (this.checked) {$('#span_product').show()} else {($('#span_product').hide())}" />
                <label>产品限制：</label>
                <span id="span_product" <?php if (empty($coupon->product_limit)): ?>style="display:none"<?php endif ?>><input type="text" name="product_limit" value="<?php print $coupon->product_limit; ?>" /> 填入产品ID，多个ID以逗号分隔</span>
                </li>
                <li>
                <input type="checkbox" id="effective_enable" <?php if ($coupon->effective_limit != -1): ?>checked="checked"<?php endif ?> onchange="if (this.checked) {$('#span_effective').show()} else {($('#span_effective').hide())}" />
                <label>对产品使用次数：</label>
                <span id="span_effective" <?php if ($coupon->effective_limit == -1): ?>style="display:none"<?php endif ?>><input type="text" name="effective_limit" value="<?php print $coupon->effective_limit; ?>" /> 只有限制类别或产品时有效(-1为不限制)</span>
                </li>
                <li>
                        <label>使用次数: </label>
                        <input name="coupon_limit" class="text numeric inline" value="<?php echo $coupon->limit; ?>" type="text">(* 若次数值为 -1 则为无限使用！)
                </li>
                <li>
                <label>开始时间<span class="req">*</span></label>
                <div>
                    <input type="text" name="coupon_created" class="text datepick" value="<?php echo date('m/d/Y',$coupon->created);?>"/>
                </div>
                </li>

                <li>
                <label>结束时间<span class="req">*</span></label>
                <div>
                    <input type="text" name="coupon_expired" class="text datepick" value="<?php echo date('m/d/Y',$coupon->expired);?>"  />
                </div>
                </li>

                <li>
                <input type="checkbox" id="on_show" name="on_show" <?php if($coupon->on_show) echo 'checked="checked"'; ?> />
                <label>是否为所有客户公用</label>
                </li>

                <li>
                <input type="checkbox" id="global" name="global" <?php if($coupon->target == 'global') echo 'checked="checked"'; ?> />
                <label for="global">是否打折产品通用</label>
                </li>

                <li>
                        <label>用户email:</label><br/>
                        <div><span style="color:#FF0000"></span>一行一个Email</div>
                        <div>
                                <textarea name="emails" cols="40" rows="20"></textarea>       
                        </div>
                        
                </li>
                <li style="clear:both;">
                <input value="Submit" class="button" type="submit" />
                </li>
            </ul>
        </form>
</div>
        <div class="box" style="overflow:hidden;float:left;">
                <h3>Customer List</h3>
                <table id="toolbar"></table>
                <div id="ptoolbar"></div>
        </div>
</div>
