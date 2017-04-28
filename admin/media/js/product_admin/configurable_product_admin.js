/*
* 用于配置产品的创建与修改页。
*/
$(function(){
    //创建关联产品
    do_products = {
        'created':{},
        'removed':{},
        'create':function(data,count) {
            //初始化-创建容器：
            if( ! $('#associated_products').length) {
                $('#create_simple_form').after('<fieldset>\
                    <legend>已创建的关联产品</legend>\
                    <div id="associated_products">\
                    </div>\
                </fieldset>');
            }

            data['id'].sort();
            var product_box_id = data['id'].join('-');
            if(this.created[product_box_id]) {
                return false;
            }
            if(! this.removed[product_box_id]) {
                var options = data['options'],values = data['values'],options_hidden = '',div_title = '';
                $.each(options,function(i,v){
                    div_title += v.name + ' : ' +  v.value + '&nbsp;&nbsp;';
                    options_hidden += '<input type="hidden" name="associated[' + count + '][options][]" value="' + v.id + '" />';
                });
                var $product=$('<div class="associated_product" id="' + product_box_id + '"><div class="product_title clr" product_key="-' + count + '"><a class="toggle_product" href="#">Collapse</a><a class="remove_product" href="#">Delete</a><a class="product_set_default" href="#" >Set as Default</a>' + div_title + '</div></div>');
                var $inputs = $('<ul class="product_inputs">\n\
                    <li>' + options_hidden + '\n\
                    <label>Name<span class="req">*</span></label><br />\n\
                    <input type="text" class="text medium required" name="associated[' + count + '][name]" value="' + $('#name').val() + values+ '" />\n\
                    </li>\n\
                    <li>\n\
                    <label>SKU<span class="req">*</span></label><br />\n\
                    <input type="text" class="text short required" name="associated[' + count + '][sku]" value="' + $('#sku').val() + '-' + count + '" />\n\
                    </li>\n\
                    <li>\n\
                    <label>Price(' + config['currency_code'] + ')<span class="req">*</span></label><br />\n\
                    <input type="text" class="text short required number" name="associated[' + count + '][price]" value="' + $('#price').val() + '" /> <a href="#" class="product_bulk_rules_toggle" input_name="associated[' + count + ']">Tier price</a><br />\n\
                    <label>Market Price(' + config['currency_code'] + ')</label><br />\n\
                    <input type="text" class="text short number" name="associated[' + count + '][market_price]" value="' + $('#market_price').val() + '" /><br />\n\
                    <label>Cost(' + config['currency_code'] + ')</label><br />\n\
                    <input type="text" class="text short number" name="associated[' + count + '][cost]" value="' + $('#cost').val() + '" />\n\
                    </li>\n\
                    <li>\n\
                    <label>Weight(g)<span class="req">*</span></label><br />\n\
                    <input type="text" class="text short required digits" name="associated[' + count + '][weight]" value="' + $('#weight').val() + '" />\n\
                    </li>\n\
                    <li>\n\
                    <label>Stock<span class="req">*</span></label><br />\n\
                    <div class="form_radio_row">\n\
                    <input type="radio" name="associated[' + count + '][no_limit_stock]" class="no_limit_stock" id="no_limit_stock_yes_' + count + '" checked="checked"/><label for="no_limit_stock_yes_' + count + '"> No limit.</label><br/>\n\
                    <input type="radio" name="associated[' + count + '][no_limit_stock]" class="no_limit_stock radio" value="0"/>\n\
                    <input name="associated[' + count + '][stock]" id="stock" class="product_stock short text required digits" type="text" disabled="disabled" />\n\
                    </div>\n\
                    </li>\n\
                </ul>');
                $product.append($inputs);
                $('#associated_products').append($product);
            }else {
                $('#associated_products').append(this.removed[product_box_id]);
                this.removed[product_box_id] = undefined;
            }
            this.created[product_box_id] = '1';
            return true;
        },
        'remove':function($product_box) {
            var product_box_id = $product_box.attr('id');
            this.removed[product_box_id] = $product_box;
            this.created[product_box_id] = undefined;
            $product_box.remove();
        }
    };
    $('#create_associated_product').click(function(){
        check_options();
        var $this=$(this),count = parseInt($this.attr('count')),succeed = 0,ignored = 0;
        $.each(check_result,function(i,arr){
            if(do_products.create(arr,++count)) {
                succeed++;
            } else {
                ignored++;
            }
        });
        $this.attr('count',count).next().text(' 成功新建了' + succeed + '个关联产品。' + (ignored ? '（另有' + ignored + '个产品已存在，故未重复创建。）' : '')).stop(true,true).fadeIn(100,function(){
            $(this).fadeOut(10000);
        });
        check_created_products();
        return false;
    });
    //删除产品
    $('.remove_product').live('click',function(){
        do_products.remove($(this).parent().parent());
        check_created_products();
        return false;
    });
    //折叠产品
    $('.toggle_product').live('click',function(){
        var $this = $(this);
        $this.text($this.text() == 'Collapse' ?  'Expand' : 'Collapse').parent().next().slideToggle();
        return false;
    });

    //checkbox视觉效果以及点击增强
    $('.filter_condition_checkboxs').click(function(event){
        if(event.target == this) {
            $checkbox = $('input[type=checkbox]',this);
            $checkbox.attr('checked',$checkbox.is(':checked')?'':'checked');
            check_label($checkbox,$label = $('label',this));
        }
    }).hover(function(){
        $('label',this).addClass('filter_condition_checkboxs_label_hover');
    },function(){
        $('label',this).removeClass('filter_condition_checkboxs_label_hover');
    });
    $('.filter_condition_checkboxs input[type=checkbox]').click(function(){
        check_label($(this),$(this).parent().find('label'));
    });
    $('.filter_condition_checkboxs input').filter(':checked').each(function(){
        $(this).parent().find('label').addClass('filter_condition_checkboxs_label_selected');
    });
    $('.product_set_default').live('click',function(){
        var $this = $(this),$div = $this.parent();
        $('input[name=default_item]').val($div.attr('product_key'));
        $('#is_default_product').after($this.clone()).remove();
        $this.after('<a href="javascript:return false;" id="is_default_product"><strong>Default</strong></a>').remove();
        return false;
    });
});
function check_options(){
    check_result = [];
    var temp_options=[],missed = false;
    $('.config_attribution').each(function(i,a){
        var $this=$(a),$options = $('input[type=checkbox]',$this).filter(':checked'),attr_id = $this.attr('id');
        if(!$options.length) {
            missed = true;
        }
        temp_options[i] = {
            'id':attr_id,
            'name':$('.filter_condition_little_box_title',$this).text(),
            'selected':[]
        };
        $options.each(function(j,o){
            var $o = $(o);
            temp_options[i]['selected'][j] = {
                'id':$o.val(),
                'value':$('label[for=' + $o.attr('id') + ']',$this).text()
            }
        });
    });
    if(missed) {
        return false;
    }
    var temp_result1=[
        {
            'id':[],
            'values':'',
            'options':[]
        }
    ],temp_result2=[],temp_id,temp_op;
    for(i = 0;i<temp_options.length;i++) {
        temp_result2=[];
        for(r=0;r<temp_result1.length;r++) {
            for(j=0;j<temp_options[i]['selected'].length;j++) {
                temp_id = temp_result1[r]['id'].slice(0);
                temp_id.push(temp_options[i]['id'] + '__' + temp_options[i]['selected'][j]['id']);
                temp_op = temp_result1[r]['options'].slice(0);
                temp_op.push({
                    'id':temp_options[i]['selected'][j]['id'],
                    'name':temp_options[i]['name'],
                    'value':temp_options[i]['selected'][j]['value']
                });
                temp_result2.push({
                    'id':temp_id,
                    'values':temp_result1[r]['values'] + ' - ' + temp_options[i]['selected'][j]['value'],
                    'options':temp_op
                });
            }
        }
        temp_result1 = temp_result2.slice(0);
    }
    check_result = temp_result1;
    return true;
}
function check_label($checkbox,$label) {
    if($checkbox.is(':checked')) {
        $label.addClass('filter_condition_checkboxs_label_selected');
    }else {
        $label.removeClass('filter_condition_checkboxs_label_selected');
    }
}

//for select associate products
function idFormatter (cellvalue, options, rowObject)
{
    return '<input type="checkbox" disabled="disabled" for_choosing = "' + rowObject[8] + '" attr_opt = "' + rowObject[9] + '" class="simple_product_ids" id="simple_product_id_' + cellvalue + '" value="' + cellvalue + '" /><label for="simple_product_id_' + cellvalue + '"> #' + cellvalue + '</label>';
}
function check_created_products(){
    $('.simple_product_ids').each(function(){
        var $this = $(this);
        if( $this.attr('for_choosing') != 0 && (! do_products.created[$this.attr('attr_opt')] )) {
            $this.removeAttr('checked').removeAttr('disabled');
        } else {
            $this.removeAttr('checked').attr('disabled','disabled');
        }
    });
}

//关联产品的选择列表
$(function(){
    jQuery("#atoolbar").jqGrid({
        url:'/admin/site/product/data',
        datatype: "json",
        height: 400,
        width: 900,
        colNames:['ID','配置属性','名称','SKU','价格','库存','显示','状态'],
        colModel:[
            {name:'simple_product_id',index:'id', width:40,formatter:idFormatter},
            {name:'simple_product_optname',index:'optname', width:200,search:false},
            {name:'simple_product_name',index:'name', width:200},
            {name:'simple_product_sku',index:'sku', width:100},
            {name:'simple_product_price',index:'price', width:60},
            {name:'simple_product_stock',index:'stock', width:60},
            {name:'simple_product_visibility',index:'visibility', width:60,formatter:visibilityFormatter,
                "searchoptions":{"value":":所有产品;1:可见;0:不可见"},
                "stype":"select",
                "summaryTpl":"{0}"
            },
            {name:'simple_product_status',index:'status', width:50,formatter:statusFormatter,
                "searchoptions":{"value":":所有产品;1:上架;0:下架"},
                "stype":"select",
                "summaryTpl":"{0}"
            }
        ],
        rowNum:30,
        rowList : [15,30,50],
        mtype: "POST",
        gridview: true,
        postData: {'id_for_search':1,'usefor':'configurable_products','set_id':config['set_id'],'configurable_attributes':config['configurable_attributes']},
        pager: '#aptoolbar',
        sortname: 'id',
        viewrecords: true,
        sortorder: "desc",
        //表格数据载入后:
        gridComplete: function(){
            //检查id的复选框是否应该设为可选
            check_created_products();
            //给每个id的复选框绑定点击事件：
            $('input.simple_product_ids').click(function(){
                var $this = $(this);
                if($this.is(':checked')){
                    var $next = $this.parent().next();
                    add_simple_product($this.val(),$this.attr('attr_opt'),$next.text(),$next.next().text());
                    selected_associated.push($this.val());
                    $('#associated_ids').val(selected_associated.join(','));
                }
            });
        }
    });
    jQuery("#atoolbar").jqGrid('navGrid','#aptoolbar',{del:false,add:false,edit:false,search:false});
    jQuery("#atoolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
    $('.remove_selected_product').live('click',function(){
        var $this = $(this),$parent = $this.parent().parent();
        do_products.created[$parent.attr('id')] = undefined;
        $parent.remove();
        check_created_products();
        var idx = $.inArray($this.attr('product_id'),selected_associated);
        if(idx >= 0) {
            selected_associated.splice(idx,1);
        }
        $('#associated_ids').val(selected_associated.join(','));
        return false;
    });
});
function add_simple_product(id,div_id,label,name) {
    var div = '<div class="associated_product" id="' + div_id + '">\
    <div class="product_title clr" product_key="' + id + '"><a href="#" product_id="' + id + '" class="remove_selected_product">Cancel</a><a href="/admin/site/product/edit/' + id + '" target="_blank">Edit</a><a class="product_set_default" href="#" >Set as Default</a>' + label + '&nbsp;&nbsp;, (#' + id + ') ' + name + '</div>\
    </div>';
    if(!$('#selected_associated_products').length){
        $('#selecte_simple_form').before('<fieldset>\
            <legend>已选择的关联产品</legend>\
            <div id="selected_associated_products">\
            </div>\
        </fieldset>	');
    }
    $('#selected_associated_products').append(div);
    do_products.created[div_id] = 1;
    check_created_products();
}

