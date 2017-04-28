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
  function  CreateCode(){
        $.post(
         "/admin/site/promotion/coupon_code_create",
        {
        },
        function(flag){
            if(flag)
                {
                    $("input[name='coupon_number']").val(flag);
                }
                else
                    {
                          "/admin/site/promotion/coupon_code_create";
                    }
        },
           'html'
    );
    }
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
function set_change(slt)
{
    if (slt.value == 0)
    {
        $('#set_name').show();
    }
    else
    {
        $('#set_name').hide();
    }
}
</script>
<div id="do_right">
    <div class="box">
        <h3>添加折扣</h3>
        <form name="coupon_promotion" action="/admin/site/promotion/coupon_add_go" method="post">
            <ul>

                <li>
                <label><span class="req">*</span>折扣号: </label>
                    <input name="coupon_number" class="coupon_number"  type="text"  /> (如果没有折扣号，现在马上生成！)
                    <input type="button" name="code_do" value="生成折扣号" onclick ="CreateCode();" />
                </li>

                <li>
                <label><span class="req">*</span>折扣类型: </label>
                    <select name="coupon_type" onchange="type_change(this);">
                        <option value="0" selected>------------</option>
                        <option value="1">减折扣</option>
                        <option value="2">减价</option>
<!--                        <option value="4">改价</option>-->
                        <option value="3">赠品</option>
                    </select>
                </li>
                <li id="li_item_sku" style="display:none">
                    <label>赠品SKU: </label>
                    <input name="item_sku" type="text" class="text numeric inline" />
                </li>
                <li id="li_coupon_value" style="display:none">
                    <label>减折扣/减价/改价: </label>
                    <input name="coupon_value"  class="text numeric inline"  value="" type="text">
                </li>
                <li><label><span class="req">*</span>折扣用途: </label>
                    <select name="coupon_set" onchange="set_change(this);">
                        <?php foreach($coupons_sets as $coupons_set){ ?>
                            <option value="<?php echo $coupons_set['id']; ?>"><?php echo $coupons_set['name']; ?></option>
                        <?php } ?>
                        <option value="0">其它+</option>
                    </select>
                </li>
                <li id="set_name" style="display:none">
                    <label>其他折扣用途: </label>
                    <input name="set_name" type="text" class="text" />
                </li>
                <li>
                <input type="checkbox" id="condition_enable" onchange="if (this.checked) {$('#span_condition').show()} else {$('#span_condition').hide()}" />
                <label for="condition_enable">最低消费限制: </label>
                <span id="span_condition" style="display:none">$<input type="text" name="condition" value="0" /></span>
                </li>
                <li>
                <input type="checkbox" id="catalog_enable" onchange="if (this.checked) {$('#span_catalog').show()} else {($('#span_catalog').hide())}" />
                <label for="catalog_enable">类别限制：</label>
                <span id="span_catalog" style="display:none"><input type="text" name="catalog_limit" value="" /> 填入类别ID，多个ID以逗号分隔</span>
                </li>
                <li>
                <input type="checkbox" id="product_enable" onchange="if (this.checked) {$('#span_product').show()} else {($('#span_product').hide())}" />
                <label for="product_enable">产品限制：</label>
                <span id="span_product" style="display:none"><input type="text" name="product_limit" value="" /> 填入产品ID，多个ID以逗号分隔</span>
                </li>
                <li>
                <input type="checkbox" id="effective_enable" onchange="if (this.checked) {$('#span_effective').show()} else {($('#span_effective').hide())}" />
                <label for="effective_enable">对产品使用次数：</label>
                <span id="span_effective" style="display:none"><input type="text" name="effective_limit" value="-1" /> 只有限制类别或产品时有效(-1为不限制)</span>
                </li>
                <li>
                <label>使用次数: </label>
                <input name="coupon_limit" class="text numeric inline" value="" type="text"> (  * 若次数值为 -1 则为无限使用！)
                </li>
                <li>
                <label>开始时间<span class="req">*</span></label>
                <div>
                    <input type="text" name="coupon_created" class="text datepick"/>
                </div>
                </li>

                <li>
                <label>结束时间<span class="req">*</span></label>
                <div>
                    <input type="text" name="coupon_expired" class="text datepick"  />
                </div>
                </li>
                
                <li>
                <input type="checkbox" id="on_show" name="on_show" />
                <label for="on_show">是否为所有客户公用</label>
                </li>

                <li>
                <input type="checkbox" id="global" name="global" />
                <label for="global">是否打折产品通用</label>
                </li>
                
                <li>
                        <label>用户email:</label><br/>
                        <div><span style="color:#FF0000"></span>一行一个Email</div>
                        <div>
                                <textarea name="emails" cols="40" rows="20"></textarea>       
                        </div>
                </li>
                
                <li>
                <input value="Submit" class="button" type="submit" />
                </li>
            </ul>
        </form>
    </div>
</div>
