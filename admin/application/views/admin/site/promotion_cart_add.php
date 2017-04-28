<?php echo View::factory('admin/site/promotion_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript">
        $(function(){
                $('input[name=discount_method],input[name=conditions],input[name=restrictions]').click(function(){
                        var $input = $('input[name=' + $(this).val() + ']');
                        if($input.length){
                                $input.removeAttr('disabled').siblings('input[type=text]').attr('disabled','disabled');
                        }else {
                                $(this).siblings('input[type=text]').attr('disabled','disabled');
                        }
                });
//                $('.restrict_method_1').click(function(){
//                        $('.restrict_method_rate_1').removeAttr('disabled');
//                        $('.restrict_method_reduce_1').attr('disabled','disabled');
//                });
//                $('.restrict_method_2').click(function(){
//                        $('.restrict_method_reduce_1').removeAttr('disabled');
//                        $('.restrict_method_rate_1').attr('disabled','disabled');
//                });
                $('input[name=promotion_method]').click(function(){
                        var $this = $(this),val = $this.val();
                        if(val == 'discount') {
                                $('.largess input,.restrict input').attr('disabled','disabled');
                                $('input[name=' + $('.discount input[type=radio]:checked').val() + ']').removeAttr('disabled');
                        }else if(val == 'largess'){
                                $('.largess input').removeAttr('disabled');
                                $('.restrict input[type=text],.discount input[type=text]').attr('disabled','disabled');
                                $('.bundle input[type=text]').attr('disabled','disabled');
                        }else if(val == 'freeshipping') {
                                $('.largess input,.restrict input[type=text],.discount input[type=text]').attr('disabled','disabled');
                        }else if(val == 'restrict') {
                                $('.restrict input').removeAttr('disabled');
                                $('.largess input,.discount input[type=text]').attr('disabled','disabled');
                        }else if(val == 'secondhalf') {
                                $('.largess input,.restrict input[type=text],.discount input[type=text]').attr('disabled','disabled');
                        }else if(val == 'bundle') {
                                $('.largess input').attr('disabled','disabled');
                                $('.largess input[type=text]').attr('disabled','disabled');
                                $('.bundle input').removeAttr('disabled');
                                
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
                
//                $('#add_restrict').click(function(){
//                        if( ! $('#pmethod_4').is(':checked')){
//                                return false;
//                        }
//                        var $this = $(this),count = parseInt($this.attr('count')) + 1;
//                        var $div = $('<div class="form_item_content restrict">\
//                                                <span class="restrict">\
//                                                        <label for="restrict_quantity">限制数量: </label><input type="text" name="restrict[quantity][]" id="restrict_quantity" class="inline numeric " /> &nbsp;&nbsp;&nbsp;&nbsp;\
//                                                       <label for="restrict_catalog">促销分类: </label><input type="text" name="restrict[catalog][]" id="restrict_catalog" class="inline numeric " /> &nbsp;&nbsp;&nbsp;&nbsp;\
//                                                </span>\
//                                                <input type="radio" name="restrict_method//'+count+'" class="restrict_method_1" value="rate" checked="checked"/><label for="restrict_method_1"> 原价乘以: </label> <input type="text" name="restrict[rate][]" class="restrict_method_rate_'+count+' numeric" />% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\
//                                                <input type="radio" name="restrict_method//'+count+'" class="restrict_method_2" value="reduce"/><label for="restrict_method_2"> 原价减去: </label> <input type="text" name="restrict[reduce][]" class="restrict_method_reduce_'+count+' numeric" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="delete_restrict">删除本赠品</a>\
//                                    </div>//');
//                        $div.insertAfter($this.parent().parent().find('div:last'));
//                        $this.attr('count',count);
//                        return false;
//                });
                
//                $('.delete_restrict').live('click',function(){
//                        if( ! $('#pmethod_4').is(':checked')){
//                                return false;
//                        }
//                        $(this).parent().remove();
//                        return false;
//                });
                
                $(".datepick").datepicker().datepicker('option',{showAnim:'',dateFormat:'yy-mm-dd'});
                //TODO 验证表单 如果选择赠品，需要提供至少一个赠品
                
                $('#is_restrict').click(function(){
                        $("#to_restrict,#restrict_promotion").toggle();
                })
        });
</script>
<div id="do_right">
        <div class="box">
                <h3>添加购物车促销</h3>
                <form name="cart_promotion" action="" method="post" class="need_validation">
                        <ul>

                                <li>
                                        <label>名称<span class="req">*</span></label>
                                        <div>
                                                <input name="name"  class="text medium required" type="text" />
                                        </div>
                                </li>

                                <li>
                                        <label>简介</label>
                                        <div>
                                                <input name="brief" class="text long" value="" type="text">
                                        </div>
                                </li>

                                <li>
                                        <label>起止时间<span class="req">*</span></label>
                                        <div>
                                                <input type="text" name="from_date" class="text datepick required"/> - to - <input type="text" name="to_date" class="text datepick required" />
                                        </div>
                                </li>

                                <li>
                                        <label>优先级<span class="req">*</span></label>
                                        <div class="form_item_content">
                                                <input type="text" name="priority" class="text digits" /> <label class="note"> The rule with the highest priority (lowest number) will take effect first.</label><br/>
                                                <input type="checkbox" id="stop_further_rules" name="stop_further_rules" value="1" checked="checked"/> <label for="stop_further_rules">Stop further rules processing.</label>
                                        </div>
                                </li>
                                
                                <li>
                                        <input type="checkbox" id="is_restrict" name="is_restrict" value="1" /><label>分类/产品限制</label>
                                        <div class="form_item_content" id="to_restrict" style="display:none;">
                                                <input name="restrictions" value="restrict_catalog" type="radio" id="restriction_catalog" checked="checked"/><label for="restriction_catalog"> 分类限制</label> <input name="restrict_catalog" type="text" class="inline numeric" /> (分类id(catalog_id),多个用","隔开) &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input name="restrictions" value="restrict_product" type="radio" id="restriction_product"/><label for="restriction_product"> 产品限制</label> <input name="restrict_product" type="text" disabled="disabled" class="inline" /> (产品SKU,多个用","隔开) &nbsp;&nbsp;&nbsp;&nbsp;
                                        </div>
                                </li>

                                <li>
                                        <label>促销条件<span class="req">*</span></label>
                                        <div class="form_item_content">
                                                <input name="conditions" value="whatever" type="radio" id="condition_whatever" checked="checked"/><label for="condition_whatever"> 全场任意</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input name="conditions" value="sum" type="radio" id="condition_sum"/><label for="condition_sum"> 金额超过</label> <input name="sum" type="text" disabled="disabled" class="inline numeric" /> &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input name="conditions" value="quantity" type="radio" id="condition_quantity"/><label for="condition_quantity"> 数量超过</label> <input name="quantity" type="text" disabled="disabled" class="inline numeric" /> &nbsp;&nbsp;&nbsp;&nbsp;
                                        </div>
                                </li>

                                <!-- TODO:与其他促销互斥？在多个促销方式中的顺序？ -->

                                <li>
                                        <label>促销方式<span class="req">*</span></label>
                                        <div class="form_item_content">
                                                <input name="promotion_method" value="discount" id="pmethod_1" type="radio" checked="checked"/><label for="pmethod_1"> 打折</label>
                                                <div class="form_item_content discount">
                                                        <input type="radio" name="discount_method" id="method_1" value="rate" checked="checked"/><label for="method_1"> 原价乘以: </label> <input type="text" name="rate" class="numeric" />% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" name="discount_method" id="method_2" value="reduce"/><label for="method_2"> 原价减去: </label> <!-- TODO:显示货币符号 --><input type="text" name="reduce" disabled="disabled" class="numeric" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                                <input name="promotion_method" value="largess" id="pmethod_2" type="radio" /><label for="pmethod_2"> 赠品</label>
                                                <div class="form_item_content largess">
                                                        <label for="largess_sum_quantity">最大总数量: </label><input name="largess_sum_quantity" id="largess_sum_quantity" class="inline numeric" value="1" disabled="disabled"/>
                                                </div>
                                                <div class="form_item_content largess">
                                                        <label for="largess_SKU_1">SKU: </label><input name="largess[SKU][]" id="largess_SKU_1" class="inline short " disabled="disabled"/> &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label for="largess_price_1">价格: </label><input name="largess[price][]" id="largess_price_1" class="inline numeric" value="0" disabled="disabled"/> &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label for="largess_quantity_1">最大数量: </label><input name="largess[quantity][]" id="largess_quantity_1" class="inline numeric" value="1" disabled="disabled"/>&nbsp;&nbsp;<a href="#" id="add_largess" count="1">+更多赠品</a>
                                                </div>
                                                <input name="promotion_method" value="freeshipping" id="pmethod_3" type="radio" /><label for="pmethod_3"> 免运费</label>
                                                <div class="form_item_content largess"></div>
<!--                                                <div id="restrict_promotion" style="display:none;">
                                                        <input name="promotion_method" value="restrict" id="pmethod_4" type="radio" /><label for="pmethod_4"> 限制促销</label>
                                                        <div class="form_item_content">
                                                                <span class="restrict">
                                                                        <label for="restrict_quantity">限制数量: </label><input type="text" name="restrict[quantity][]" id="restrict_quantity" class="inline numeric " disabled="disabled"/> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <label for="restrict_catalog">促销分类: </label><input type="text" name="restrict[catalog][]" id="restrict_catalog" class="inline numeric " disabled="disabled"/> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                </span>
                                                                <input type="radio" name="restrict_method" class="restrict_method_1" value="rate" checked="checked"/><label for="restrict_method_1"> 原价乘以: </label> <input type="text" name="restrict[rate][]" class="restrict_method_rate_1 numeric" />% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <input type="radio" name="restrict_method" class="restrict_method_2" value="reduce"/><label for="restrict_method_2"> 原价减去: </label><input type="text" name="restrict[reduce][]" disabled="disabled" class="restrict_method_reduce_1 numeric" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                                             
                                                                <a href="#" id="add_restrict" count="1">+更多数量</a>
                                                        </div>
                                                </div>-->
                                                <br/>
                                                <input name="promotion_method" value="secondhalf" id="pmethod_4" type="radio" /><label for="pmethod_4"> 第二件半价</label>
                                                <br>
                                                <br>
                                                <input name="promotion_method" value="bundle" id="pmethod_5" type="radio" checked="checked"/><label for="pmethod_5">捆绑销售</label>
                                                <div class="form_item_content bundle">
                                                        捆绑销售价格:  <!-- TODO:显示货币符号 --><input type="text" name="bundleprice" class="numeric" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        捆绑销售件数
                                                        <input type="text" name="bundlenum" class="numeric" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                        </div>
                                </li>

                                <li>
                                        <input value="Submit" class="button" type="submit" />
                                </li>
                        </ul>
                </form>
        </div>
</div>
