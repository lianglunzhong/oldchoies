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
                $('input[name=promotion_method]').click(function(){
                        var $this = $(this),val = $this.val();
                        if(val == 'discount') {
                                $('.largess input').attr('disabled','disabled');
                                $('input[name=' + $('.discount input[type=radio]:checked').val() + ']').removeAttr('disabled');
                                $('.bundle input').attr('disabled','disabled');
                        }else if(val == 'largess'){
                                $('.largess input').removeAttr('disabled');
                                $('.discount input[type=text]').attr('disabled','disabled');
                                $('.bundle input[type=text]').attr('disabled','disabled');
                        }else if(val == 'freeshipping') {
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
                $(".datepick").datepicker().datepicker('option',{showAnim:'',dateFormat:'yy-mm-dd'});
                //TODO 验证表单 如果选择赠品，需要提供至少一个赠品
        });
</script>
<div id="do_right">
        <div class="box">
                <h3>修改购物车促销</h3>
                <form name="cart_promotion" action="" method="post" class="need_validation">
                        <ul>

                                <li>
                                        <label>名称<span class="req">*</span></label>
                                        <div>
                                                <input name="name"  class="text medium required" type="text"  value="<?php echo $cart_promotion->name; ?>"/>
                                        </div>
                                </li>

                                <li>
                                        <label>简介</label>
                                        <div>
                                                <textarea name="brief" class="text long" cols="80"><?php echo $cart_promotion->brief; ?></textarea>
                                        </div>
                                </li>
                                
                                <?php
                                $language = Kohana::config('sites.1.language');
                                foreach($language as $l)
                                {
                                    if($l == 'en')
                                        continue;
                                    ?>
                                    <li>
                                        <label><?php echo strtoupper($l); ?> 简介</label>
                                        <div>
                                                <textarea name="<?php echo $l; ?>" class="text long" cols="80"><?php echo Cartpromotion::instance($cart_promotion->id)->get($l); ?></textarea>
                                        </div>
                                </li>
                                    <?php
                                }
                                ?>

                                <li>
                                        <label>起止时间<span class="req">*</span></label>
                                        <div>
                                                <input type="text" name="from_date" class="text datepick required" value="<?php echo date('m/d/Y', $cart_promotion->from_date); ?>"/> - to - <input type="text" name="to_date" class="text datepick required"  value="<?php echo date('m/d/Y', $cart_promotion->to_date); ?>"/>
                                        </div>
                                </li>

                                <li>
                                        <label>优先级<span class="req">*</span></label>
                                        <div class="form_item_content">
                                                <input type="text" name="priority" value="<?php echo $cart_promotion->priority; ?>" class="text digits" /> <label class="note"> The rule with the highest priority (lowest number) will take effect first.</label><br/>
                                                <input type="checkbox" id="stop_further_rules" name="stop_further_rules" value="1" <?php echo $cart_promotion->stop_further_rules ? ' checked="checked" ' : ''; ?>/> <label for="stop_further_rules">Stop further rules processing.</label>
                                        </div>
                                </li>
                                <?php
                                if($cart_promotion->restrictions)
                                {
                                        $restrictions = unserialize($cart_promotion->restrictions);
                                ?>
                                <li>
                                        <input type="checkbox" checked="checked" id="is_restrict" name="is_restrict" value="1" /><label>分类/产品限制</label>
                                        <div class="form_item_content" id="to_restrict" >
                                        <?php
                                        if(isset($restrictions['restrict_catalog']))
                                        {
                                        ?>
                                                <input name="restrictions" value="restrict_catalog" type="radio" id="restriction_catalog" checked="checked" /><label for="restriction_catalog"> 分类限制</label> <input name="restrict_catalog" value="<?php echo $restrictions['restrict_catalog']; ?>" type="text" class="inline numeric" /> (分类id(catalog_id),多个用","隔开) &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input name="restrictions" value="restrict_product" type="radio" id="restriction_product" /><label for="restriction_product"> 产品限制</label> <input name="restrict_product" type="text" disabled="disabled" class="inline" /> (产品SKU,多个用","隔开) &nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php
                                        }
                                        elseif(isset($restrictions['restrict_product']))
                                        {
                                        ?>
                                                <input name="restrictions" value="restrict_catalog" type="radio" id="restriction_catalog" /><label for="restriction_catalog"> 分类限制</label> <input name="restrict_catalog" type="text" disabled="disabled" class="inline numeric" /> (分类id,多个用","隔开) &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input name="restrictions" value="restrict_product" type="radio" id="restriction_product" checked="checked" /><label for="restriction_product"> 产品限制</label> <input name="restrict_product" value="<?php echo $restrictions['restrict_product']; ?>" type="text" class="inline" /> (产品SKU,多个用","隔开) &nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php
                                        }
                                        ?>
                                        </div>
                                </li>
                                <?php
                                }
                                ?>

                                <li>
                                        <label>促销条件<span class="req">*</span></label>
                                        <div class="form_item_content">
                                                <?php
                                                $conditions = explode(':', $cart_promotion->conditions);
                                                ?>
                                                <input name="conditions" value="whatever" type="radio" id="condition_whatever" <?php if ($conditions[0] == 'whatever') echo ' checked="checked"'; ?>/><label for="condition_whatever"> 全场任意</label> &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input name="conditions" value="sum" type="radio" id="condition_sum" <?php if ($conditions[0] == 'sum') echo ' checked="checked"'; ?>/><label for="condition_sum"> 金额超过</label> <input name="sum" type="text" <?php echo $conditions[0] == 'sum' ? ' value="' . $conditions[1] . '" ' : ' disabled="disabled" '; ?> class="inline numeric" /> &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input name="conditions" value="quantity" type="radio" id="condition_quantity" <?php if ($conditions[0] == 'quantity') echo ' checked="checked"'; ?>/><label for="condition_quantity"> 数量超过</label> <input name="quantity" type="text" <?php echo $conditions[0] == 'quantity' ? ' value="' . $conditions[1] . '" ' : ' disabled="disabled" '; ?> class="inline numeric" /> &nbsp;&nbsp;&nbsp;&nbsp;
                                        </div>
                                </li>

                                <!-- TODO:与其他促销互斥？在多个促销方式中的顺序？ -->

                                <li>
                                        <label>促销方式<span class="req">*</span></label>
                                        <?php
                                        $actions = unserialize($cart_promotion->actions);
                                        if ($actions['action'] == 'discount')
                                        {
                                                $discount = explode(':', $actions['details']);
                                        }
                                        elseif ($actions['action'] == 'largess')
                                        {
                                                $largess_count = count($actions['details']['largesses']);
                                        }
                                        elseif ($actions['action'] == 'bundle')
                                        {
                                               $bundleprice = explode(':', $actions['bundleprice']);
                                               $bundlenum = explode(':', $actions['bundlenum']);
                                        }

                                        ?>
                                        <div class="form_item_content">
                                                <input name="promotion_method" value="discount" id="pmethod_1" type="radio" <?php if ($actions['action'] == 'discount') echo ' checked="checked" '; ?>/><label for="pmethod_1"> 打折</label>
                                                <div class="form_item_content discount">
                                                        <input type="radio" name="discount_method" id="method_1" value="rate" <?php if (isset($discount) AND $discount[0] == 'rate') echo ' checked="checked" '; ?>/><label for="method_1"> 原价乘以: </label> <input type="text" name="rate" <?php echo (isset($discount) AND $discount[0] == 'rate') ? ' value="' . $discount[1] . '" ' : ' disabled="disabled" '; ?>class="numeric" />% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" name="discount_method" id="method_2" value="reduce" <?php if (isset($discount) AND $discount[0] == 'reduce') echo ' checked="checked" '; ?>/><label for="method_2"> 原价减去: </label> <!-- TODO:显示货币符号 --><input type="text" name="reduce" <?php echo (isset($discount) AND $discount[0] == 'reduce') ? ' value="' . $discount[1] . '" ' : ' disabled="disabled" '; ?> class="numeric" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                                <input name="promotion_method" value="largess" id="pmethod_2" type="radio" <?php if ($actions['action'] == 'largess') echo ' checked="checked" '; ?>/><label for="pmethod_2"> 赠品</label>
                                                <div class="form_item_content largess">
                                                        <label for="largess_sum_quantity">最大总数量: </label><input name="largess_sum_quantity" id="largess_sum_quantity" class="inline numeric" <?php echo ($actions['action'] == 'largess') ? ' value="' . $actions['details']['max_sum_quantity'] . '" ' : ' value="1" disabled="disabled" '; ?>/>
                                                </div>
                                                <div class="form_item_content largess">
                                                        <label for="largess_SKU_1">SKU: </label><input name="largess[SKU][]" id="largess_SKU_1" class="inline short " <?php echo ($actions['action'] == 'largess') ? ' value="' . $actions['details']['largesses'][0]['SKU'] . '" ' : ' disabled="disabled" '; ?>/> &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label for="largess_price_1">价格: </label><input name="largess[price][]" id="largess_price_1" class="inline numeric" <?php echo ($actions['action'] == 'largess') ? ' value="' . $actions['details']['largesses'][0]['price'] . '" ' : ' value="0" disabled="disabled" '; ?>/> &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label for="largess_quantity_1">最大数量: </label><input name="largess[quantity][]" id="largess_quantity_1" class="inline numeric" <?php echo ($actions['action'] == 'largess') ? ' value="' . $actions['details']['largesses'][0]['max_quantity'] . '" ' : ' value="1" disabled="disabled" '; ?>/>&nbsp;&nbsp;<a href="#" id="add_largess" count="<?php echo isset($largess_count) ? $largess_count : 1; ?>">+更多赠品</a>
                                                </div>
                                                <?php
                                                if ($actions['action'] == 'largess' AND $largess_count > 1)
                                                {
                                                        for ($i = 1; $i < $largess_count; $i++)
                                                        {
                                                                ?>
                                                                <div class="form_item_content largess">
                                                                        <label for="largess_SKU_<?php echo $i + 1; ?>">SKU: </label><input name="largess[SKU][]" id="largess_SKU_<?php echo $i + 1; ?>" class="inline short " value="<?php echo $actions['details']['largesses'][$i]['SKU']; ?>"/> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <label for="largess_price_<?php echo $i + 1; ?>">价格: </label><input name="largess[price][]" id="largess_price_<?php echo $i + 1; ?>" class="inline numeric" value="<?php echo $actions['details']['largesses'][$i]['price']; ?>"/> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <label for="largess_quantity_<?php echo $i + 1; ?>">最大数量: </label><input name="largess[quantity][]" id="largess_quantity_<?php echo $i + 1; ?>" class="inline numeric" value="<?php echo $actions['details']['largesses'][$i]['max_quantity']; ?>"/>&nbsp;&nbsp;<a href="#" class="delete_largess">删除本赠品</a>
                                                                </div>
                                                        <?php
                                                        }
                                                }
                                                ?>
                                                <input name="promotion_method" value="freeshipping" id="pmethod_3" type="radio" <?php if ($actions['action'] == 'freeshipping') echo ' checked="checked" '; ?>/><label for="pmethod_3"> 免运费</label><br/><br/>
                                                <input name="promotion_method" value="secondhalf" id="pmethod_4" type="radio" <?php if ($actions['action'] == 'secondhalf') echo ' checked="checked" '; ?>/><label for="pmethod_4"> 第二件半价</label>
                                                <br>
                                                <br>
                                                <input name="promotion_method" value="bundle" id="pmethod_5" type="radio" checked="checked"/><label for="pmethod_5">捆绑销售</label>
                                                <div class="form_item_content bundle">
                                                        捆绑销售价格:  <!-- TODO:显示货币符号 --><input type="text" name="bundleprice" class="numeric" value="<?php echo isset($bundleprice[1]) ? $bundleprice[1] : '';?>" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        捆绑销售件数
                                                        <input type="text" name="bundlenum" class="numeric" value="<?php echo isset($bundlenum[1]) ? $bundlenum[1] : '';?>" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                        </div>
                                </li>
                                
                                <li>
                                        <div><input type="checkbox" id="celebrity_avoid" name="celebrity_avoid" value="1" <?php echo  $cart_promotion->celebrity_avoid ? 'checked="checked"' : ''; ?>>红人过滤</div>
                                </li>

                                <li>
                                        <input value="Submit" class="button" type="submit" />
                                </li>
                        </ul>
                </form>
        </div>
</div>
