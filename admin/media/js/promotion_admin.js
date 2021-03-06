$(function(){
    $('.filter_condition_checkboxs').live('click',function(event){
        if(event.target == this) {
            $checkbox = $('input[type=checkbox]',this);
            $checkbox.attr('checked',$checkbox.is(':checked')?'':'checked');
            do_set($checkbox);
            check_label($checkbox,$label = $('label',this));
        }
    }).live('mouseover',function(){
        $('label',this).addClass('filter_condition_checkboxs_label_hover');
    }).live('mouseout',function(){
        $('label',this).removeClass('filter_condition_checkboxs_label_hover');
    });
    $('.filter_condition_checkboxs input[type=checkbox]').live('click',function(){
        check_label($(this),$(this).parent().find('label'));
    });
    //让 筛选最新 和 筛选最热门 互斥：
    //$('#condition_new').change(function(){
    //if($(this).val() != '') {
    //$('#condition_hot').val('').attr('disabled','disabled');
    //}else {
    //$('#condition_hot').attr('disabled','');
    //}
    //});
    //$('#condition_hot').change(function(){
    //if($(this).val() != '') {
    //$('#condition_new').val('').attr('disabled','disabled');
    //}else {
    //$('#condition_new').attr('disabled','');
    //}
    //});
    $('input[name=method]').click(function(){
        var $input = $('input[name=' + $(this).val() + ']');
        $input.removeAttr('disabled').siblings('input[type=text]').attr('disabled','disabled');
    });
    $(".datepick").datepicker().datepicker('option',{showAnim:'',dateFormat:'yy-mm-dd'});

    $('.sets_checkboxes').click(function(){
        do_set($(this));
    });
});
function check_label($checkbox,$label) {
    if($checkbox.is(':checked')) {
        $label.addClass('filter_condition_checkboxs_label_selected');
    }else {
        $label.removeClass('filter_condition_checkboxs_label_selected');
    }
}
function do_set($checkbox){
    if($checkbox.is(':checked')){
        attributes.add($checkbox.val());
    }else{
        attributes.remove($checkbox.val());
    }
}

attributes = (function(){
    var cache = {
        'sets':{},
        'attrs':{}
    };
    return {
        'add':function(set_id,init){
            if(cache['sets'][set_id]){
                attributes.insert(cache['sets'][set_id],set_id,init);
            }else{
                $.getJSON('/admin/site/set/get_options/' + set_id,function(json){
                    cache['sets'][set_id] = json;
                    attributes.insert(json,set_id,init);
                });
            }
        },'insert':function(json,set_id,init){
            var attr,options,$current_attr;
            for(var aid in json){
                if(!json[aid].options || json[aid].options == {}){
                    continue;
                }
                $current_attr = $('#attr_' + aid + '_options');
                if($current_attr.length){
                    $current_attr.attr('used',parseInt($current_attr.attr('used')) + 1);
                    continue;
                }
                if(cache['attrs'][aid]){
                    attr = cache['attrs'][aid];
                }else{
                    attr = $('<div class="filter_condition_little_box" id="attr_' + aid + '_options" aid="' + aid + '" used="1">\
                        <div class="filter_condition_little_box_title" title="' + json[aid]['name'] + '">' + json[aid]['name'] + '</div>\
                        <div class="filter_condition_little_box_content">\
                        </div>\
                        </div>');
                    options = '';
                    for(var oid in json[aid]['options']){
                        options += '<div class="filter_condition_checkboxs"><input type="checkbox" name="condition[options][]" value="' + oid + '" id="condition_opt_' + oid + '"><label for="condition_opt_' + oid + '" title="' + json[aid]['options'][oid] + '">' + json[aid]['options'][oid] + '</label></div>';
                    }
                    $('.filter_condition_little_box_content',attr).append(options);
                }

                if(init){
                    init_options(attr);
                }

                $('#attributes_box').append(attr);
            }
        },'remove':function(set_id){
            var $attr;
            if(!cache['sets'][set_id]){
                return false;
            }
            for(var aid in cache['sets'][set_id]){
                $attr = $('#attr_' + aid + '_options');
                if($attr.length){
                    if($attr.attr('used') <= 1){
                        $(':checked',$attr).removeAttr('checked').next().removeClass('filter_condition_checkboxs_label_selected');
                        cache['attrs'][aid] = $attr;
                        $attr.remove();
                    }else{
                        $attr.attr('used',parseInt($attr.attr('used')) - 1);
                    }
                }
            }
        }
    };
})();

function init_options($box){
    $('input[type=checkbox]',$box).each(function(){
        var $this = $(this),idx = $.inArray(parseInt($this.val()),options_selected);
        if(idx >= 0){
            $this.attr('checked','checked').parent().find('label').addClass('filter_condition_checkboxs_label_selected');
        }
    });
}
