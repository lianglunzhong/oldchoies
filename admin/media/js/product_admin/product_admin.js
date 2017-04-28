
tinyMCE.init({
    mode : 'exact',
    elements : "description",
    theme : "advanced",
    plugins : "fullscreen,advimage",
    height: 350,
    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,fullscreen",
    theme_advanced_buttons2 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,
    relative_urls: false,
    preformatted : true,
    remove_script_host: false,
    //forced_root_block : false, // Needed for 3.x
    force_p_newlines : false,
    //convert_newlines_to_brs: true,
    //invalid_elements : "p",
    force_br_newlines: true,
    file_browser_callback: myFileBrowser
});
function myFileBrowser(field_name,url,type,win) {
    tinyMCE.activeEditor.windowManager.open({
        file: "/admin/site/image/embed_manager",
        title: "Image Browser",
        width: 610,
        height:400,
        resizable: "no",
        inline: "yes",
        close_previous: "no"
    },{
        window:win,
        input:field_name
    });
    return false;
}
$(function(){
    $('input[name=product\[name\]]').change(function(){
        $('input[name=product\[link\]]').val($.trim($(this).val()).toLowerCase().replace(/[^\b\w]+/g,'-').replace(/-+$/, ''));
    });
    //jqGrid选择相关产品：
    //全选按钮的动作：
    $('#select_all').click(function(){
        if($(this).is(':checked')) {
            $('input.product_ids').each(function(){
                var idx = $.inArray($(this).val(), product_ids);
                if(idx < 0) {
                    product_ids.push($(this).val());
                }
                $(this).attr('checked','checked');
            });
        } else {
            $('input.product_ids').each(function(){
                var idx = $.inArray($(this).val(), product_ids);
                if(idx >= 0) {
                    product_ids.splice(idx,1);
                }
                $(this).removeAttr('checked');
            });
        }
        $('#product_ids').val(product_ids.join(','));
        $('#selected_num').html(product_ids.length);
    });
    //“预览我的本次操作”的按钮动作
    $('#view_selected_products').click(function(){
        $('#gs_product_id option[value=2]').attr('selected','selected');
        $('#search_grid').click();
        return false;
    });
    //“过滤”的动作
    $('#search_grid').click(function(){
        jQuery("#toolbar")[0].triggerToolbar();
        return false;
    });
    //“清空过滤条件”的动作
    $('#reset_search_grid').click(function(){
        jQuery("#toolbar")[0].clearToolbar();
        return false;
    });
    //给每个id的复选框绑定点击事件：
    $('input.product_ids').live('click',function(){
        if($(this).is(':checked')){
            product_ids.push($(this).val());
            $('#product_ids').val(product_ids.join(','));
        }else {
            var idx = $.inArray($(this).val(), product_ids);
            if(idx >= 0) {
                product_ids.splice(idx,1);
                $('#product_ids').val(product_ids.join(','));
            }
        }
        $('#selected_num').html(product_ids.length);
    });

    $('.product_stock').live('click',function(){
        var $this = $(this);
        $('.no_limit_stock[value=0]',$this.parent()).click();
    });
    $('.no_limit_stock').live('click',function(){
        var $this = $(this),$stock = $('.product_stock',$this.parent());
        if($this.attr('value') == 0) {
            $stock.removeAttr('disabled').focus();
        }else{
            $stock.attr('disabled','disabled');
        }
    });

    $("#tabs").tabs();

	$('.product_bulk_rules_toggle').live('click',function(){
		var $this = $(this);
		if(!$this.next().hasClass('product_bulk_rules')){
			$this.after('<div class="product_bulk_rules">' + create_bulk_rule_div($this) + '</div>');
		}
		return false;
	});
    $('.remove_bulk_rule').live('click',function(){
        var $rule_div = $(this).parent(),$rules_div = $rule_div.parent();
		$rule_div.remove();
		if(!$('div',$rules_div).length){
			$rules_div.remove();
		}
		return false;
	});
	$('.add_bulk_rule').live('click',function(){
        var $this = $(this);
		$this.parent().after(create_bulk_rule_div($this));
		return false;
	});

    $('#catalog_tree').css({width:'450px',height:'auto','_height':'400px','max-height':'400px'}).before('<a id="catalog_tree_collapse_expand" href="#" style="margin:0">Collapse All</a>');
    $('li.catalog_tree_name').prepend('<ins class="tree_icon">&nbsp;</ins>');
    $('li.catalog_tree_children').prev().find('.tree_icon').addClass('tree_icon_parent tree_icon_parent_expanded').css('cursor','pointer').click(function(){
        $(this).toggleClass('tree_icon_parent_expanded').parent().next().slideToggle(0);
    });
    $('li.catalog_tree_name input[type=checkbox]').click(function(){
        $(this).prev().toggleClass('tree_checked');
    });
    $('#catalog_tree_collapse_expand').click(function(){
        var $this = $(this),text = $this.text();
        $('#catalog_tree > li > .tree_icon_parent').each(function(){collapse_expand_all(this);});
        $this.text(text == 'Collapse All' ? 'Expand All' : 'Collapse All');
        return false;
    }).before('<div class="filter_condition"><label>Default Catalog: </label><select name="default_catalog" id="default_catalog" class="drop"><option value="0">--NONE--</option></select></div>');
    if(config['catalogs'].length){
        init_catalogs();
    }
    $('#catalog_tree input[type=checkbox]').click(function(){
        var $this = $(this),id = $this.val();
        if($this.is(':checked')){
            $('#default_catalog').append('<option value="' + id + '">' + $this.next().text() + '</option>');
        }else{
            $('#default_catalog option[value=' + id + ']').remove();
        }
    });
});
//jqgrid for products
function checkboxFormatter (cellvalue, options, rowObject)
{
    var checked = $.inArray(cellvalue, product_ids) >= 0 ?' checked="checked"' : '';
    return '<input type="checkbox" class="product_ids" id="product_id_' + cellvalue + '" value="' + cellvalue + '" ' + checked + '/><label for="product_id_' + cellvalue + '"> #' + cellvalue + '</label>';
}
function typeFormatter (cellvalue, options, rowObject)
{
    var types = ['Simple','config','package','simple-config'];
    return ! types[cellvalue] ? 'none' : types[cellvalue] ;
}
function visibilityFormatter(cellvalue,options,rowObject) {
    return cellvalue == 1 ? 'Visible' : 'Invisible';
}
function setFormatter(cellvalue,options,rowObject) {
    var userdata = jQuery("#toolbar").getGridParam('userData');
    return userdata['sets'][cellvalue];
}
function statusFormatter(cellvalue,options,rowObject) {
    return cellvalue == 1 ? 'On' : 'Off';
}

//for related product grid
function on_grid_refresh(){
    if($('input.product_ids').length == $('input.product_ids:checked').length){
        $('#select_all').attr('checked','checked');
    }else{
        $('#select_all').removeAttr('checked');
    }
}

function create_bulk_rule_div($link){
    var bulk_rule_div = '<div>Qty &gt;= <input type="text" name="{{input_name}}[bulk_num][]" class="text numeric required digits"/>, Price = <input type="text" name="{{input_name}}[bulk_price][]"  class="text numeric required number" /> <a href="#" class="remove_bulk_rule">[-]</a> <a href="#" class="add_bulk_rule" input_name="{{input_name}}">[+]</a></div>',input_name = $link.attr('input_name');
    if(!input_name){
        input_name = 'product';
    }
    return bulk_rule_div.replace(/{{input_name}}/g,input_name);
}

function init_catalogs(){
    $('#catalog_tree input[type=checkbox]').each(function(){
        var $this = $(this),id = $this.val(),opt = '';
        if($.inArray(id, config['catalogs']) != -1) {
            $this.attr('checked','checked');
            $('#default_catalog').append('<option value="' + id + '"' + (config.default_catalog == id ? ' selected="selected"' : '') + '>' + $this.next().text() + '</option>');
        }
    });
}
function collapse_expand_all(obj){
    var $obj = $(obj),$children,$next_ol = $obj.parent().next(),text = $('#catalog_tree_collapse_expand').text();
    if(!$next_ol.hasClass('catalog_tree_children')){
        return false;
    }

    $('ol > li > .tree_icon_parent',$next_ol).each(function(){collapse_expand_all(this);});

    if((text == 'Collapse All' && $obj.hasClass('tree_icon_parent_expanded')) || ((text != 'Collapse All' && !$obj.hasClass('tree_icon_parent_expanded')))){
        $obj.click();
    }
}
