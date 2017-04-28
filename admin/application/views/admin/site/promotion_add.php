<?php echo View::factory('admin/site/promotion_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript">
//商品分类的树状显示
$(function(){
    $('li.catalog_tree_name').prepend('<ins class="tree_icon">&nbsp;</ins>');
    $('li.catalog_tree_children').prev().find('.tree_icon').addClass('tree_icon_parent tree_icon_parent_expanded').css('cursor','pointer').click(function(){
        $(this).toggleClass('tree_icon_parent_expanded').parent().next().slideToggle(0);
    });
    $('li.catalog_tree_name input[type=checkbox]').click(function(){
        $(this).prev().toggleClass('tree_checked');
    });
});
</script>
<script type="text/javascript" src="/media/js/promotion_admin.js"></script>
<div id="do_right">
    <div class="box promotion_box" style="overflow:hidden;">
        <div class="title">
            <h3>添加产品促销</h3>
        </div>

        <form method="post" action="#" class="need_validation">

<script type="text/javascript">
$(function() {
    $("#tabs").tabs();
});
</script>

            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">基本信息</a></li>
                    <li><a href="#tabs-2">促销详情</a></li>
                    <li><a href="#tabs-3">SEO相关</a></li>
                </ul>
                <!--START tabs-1 -->
                <div id="tabs-1">
                    <ul>

                        <li>
                            <label>名称<span class="req">*</span></label>
                            <div>
                                <input name="catalog_name" id="catalog_name" class="text medium required" type="text"  />
                            </div>
                        </li>

                        <li>
                            <label>简介</label>
                            <div>
                                <input name="brief" class="text long" value="" type="text">
                            </div>
                        </li>

                        <li>
                            <label>开始时间<span class="req">*</span></label>
                            <div>
                                <input type="text" name="from_date" class="text datepick required"/>
                            </div>
                        </li>

                        <li>
                            <label>结束时间<span class="req">*</span></label>
                            <div>
                                <input type="text" name="to_date" class="text datepick required"  />
                            </div>
                        </li>

                    </ul>
                </div>
                <div id="tabs-2">
                    <br />
                    <fieldset class="filter_condition catalog_checkboxes_tree">
                        <legend>选择商品分类:</legend>
                        <?php echo $catalog_checkboxes_tree; ?>
                    </fieldset>
                    <div class="filter_condition">
                        <label for="price_lower">价格区间($)</label>: 从
                        <input type="text" name="condition[price_lower]" id="price_lower" class="text numeric inline" value="" />
                                                                                                                                                                        到
                        <input type="text" name="condition[price_upper]" class="text numeric inline" value="" />
                    </div>
                    <!--<div class="filter_condition">
                        <label for="condition_new">筛选最新</label>:
                        <input type="text" name="condition[new]" id="condition_new" class="text numeric inline" value="" />
                                                                                                                                                                        个 - 或 - <label for="condition_hot">筛选最热门</label>:
                        <input type="text" name="condition[hot]" id="condition_hot" class="text numeric inline" value="" />
                                                                                                                                                                        个
                    </div>-->
                    <div class="filter_condition filter_condition_sets">
                        <fieldset class="clr">
                            <legend>选择商品类型:</legend>
                            <div class="filter_condition_sets_check_box">
<?php
foreach( $sets as $set )
{
    echo '
        <div class="filter_condition_checkboxs"><input type="checkbox" name="condition[sets][]" class="sets_checkboxes" value="'.$set->id.'" id="condition_set_'.$set->id.'" /><label for="condition_set_'.$set->id.'" title="'.$set->name.'"> '.$set->name.'</label></div>';
}
?>
                            </div>
                        </fieldset>
                    </div>
                    <div class="filter_condition filter_condition_attributes">
                        <fieldset class="clr" id="attributes_box">
                            <legend>选择商品属性:</legend>

                            </fieldset>
                        </div>
                        <!--<div class="filter_condition">
                            <fieldset class="clr" id="filter_condition_attributes">
                                <legend>特定数值区间:</legend>
<?php
//foreach( $attributes as $attribute )
//{
//if($attribute->type == 2)
//{
//echo '
//<div class="filter_condition clr">
//<label for="attr_'.$attribute->id.'">'.$attribute->name.'</label>: 从
//<input type="text" name="condition[attributes]['.$attribute->id.'][0]" id="attr_'.$attribute->id.'" class="text numeric inline" value="" />
//到
//<input type="text" name="condition[attributes]['.$attribute->id.'][1]" class="text numeric inline" value="" />
//</div>';
//}
//}
?>
                        </fieldset>
                    </div>-->
                    <div class="filter_condition promotion_method">
                        <fieldset>
                            <legend>促销方式</legend>
                            <input type="radio" name="method" id="method_1" value="rate" checked="checked"/> <label for="method_1">原价乘以: </label> <input type="text" name="rate" class="numeric" />% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="method" id="method_2" value="reduce"/> <label for="method_2">原价减去: </label> <!-- TODO:显示货币符号 --><input type="text" name="reduce" disabled="disabled" class="numeric" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="method" id="method_3" value="equal"/> <label for="method_3">原价改至: </label> <!-- TODO:显示货币符号 --><input type="text" name="equal" disabled="disabled" class="numeric" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="method" id="method_4" value="points"/> <label for="method_4">双倍积分</label><input type="text" name="points" disabled="disabled" class="numeric"/>                      	
                        </fieldset>
                    </div>
                </div>
                <!--END tabs-2 -->

                <!--START tabs-3 -->
                <div id="tabs-3">

                    <ul>

                        <li>
                            <label>META TITLE</label>
                            <div>
                                <input name="meta_title" id="meta_title" class="text long" type="text"/>
                            </div>
                        </li>

                        <li>
                            <label>META KEYWORDS</label>
                            <div>
                                <input name="meta_keywords" id="meta_keywords" class="text long" type="text" />
                            </div>
                        </li>

                        <li>
                            <label>META DESCRIPTION</label>
                            <div>
                                <textarea name="meta_description" id="meta_description" rows="6" cols="60" tabindex="1" class="textarea"></textarea>
                            </div>
                        </li>

                        <li>
                            <label>image src</label>
                            <div>
                                <input name="image_src" id="image_src" class="text long" type="text"/>
                            </div>
                        </li>

                        <li>
                            <label>image link</label>
                            <div>
                                <input name="image_link" id="image_link" class="text long" type="text"/>
                            </div>
                        </li>

                        <li>
                            <label>image alt</label>
                            <div>
                                <input name="image_alt" id="image_alt" class="text long" type="text"/>
                            </div>
                        </li>

                    </ul>
                </div>
                <!--END tabs-3 -->

            </div>

            <ul>
                <li>
                    <input value="Submit" class="button" type="submit" />
                </li>
            </ul>
        </form>
    </div>
</div>
