$(function(){

	$('#ptoolbar').parent().append('<input type="hidden" name="product_ids" id="product_ids" value="' + product_ids.join(',') + '"/>');
	jQuery("#toolbar").jqGrid({
		url:'/admin/site/catalog/ajax_products/' + config['catalog_id'],
		datatype: "json",
		height: 400,
		width: 900,
		colNames:['ID','Name','Type','Set','SKU','Price','库存','Visibility','Status'],
		colModel:[
			{name:'product_id',index:'id', width:80,formatter: checkboxFormatter,searchoptions:{'value':':所有产品;' + (config['catalog_id'] > 0 ? '1:已包含的产品;0:未包含的产品;' : '') + '2:本次勾选的产品','defaultValue':(config['catalog_id'] > 0 ? 1 : '')},stype:'select'},
			{name:'product_name',index:'name', width:200},
			{name:'product_type',index:'type', width:100,align:'center',formatter:typeFormatter,searchoptions:{'value':':所有产品;0:基本产品;1:配置产品;2:打包产品'},stype:'select',"summaryTpl":"{0}"},
			{name:'product_set',index:'set_id', width:80,formatter:setFormatter,
				"searchoptions":{"value":":ALL"},
				"stype":"select",
				"summaryTpl":"{0}"
			},
			{name:'sku',index:'sku', width:100},
			{name:'product_price',index:'price', width:100},
			{name:'product_stock',index:'stock', width:100},
			{name:'product_visibility',index:'visibility', width:60,formatter:visibilityFormatter,
				"searchoptions":{"value":":All;1:可见;0:不可见"},
				"stype":"select",
				"summaryTpl":"{0}"
			},
			{name:'product_status',index:'status', width:60,formatter:statusFormatter,
				"searchoptions":{"value":":All;1:status=1;0:status=0"},
				"stype":"select",
				"summaryTpl":"{0}"
			},
		],
		rowNum:15,
		//  rowTotal: 12,
		rowList : [15,50,150,300],
		// loadonce:true,
		mtype: "POST",
		// rownumbers: true,
		// rownumWidth: 40,
		gridview: true,
		//            postData: {hello: 1,hello1: 2},
		pager: '#ptoolbar',
		sortname: 'id',
		viewrecords: true,
		sortorder: "desc",
		//            caption: "Toolbar Searching"
		//提交ajax请求之前
		beforeRequest:function(){
			if(config['catalog_id'] > 0){
				init_Grid();
			}
			//判断是否要传送“本地选中的id列表”给服务器:
			if($('#gs_product_id').val() == 2) {
				$(this).setPostDataItem('selected',$('#product_ids').val());
			} else {
				$(this).removePostDataItem('selected');
			}
		}
	});
	jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
	jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
    jQuery("#toolbar").jqGrid('sortableRows', {
        update: function(event, ui) {
            if ($('#gs_product_id').val() == 1) {
                $('#product_ids').val('');
                var ids = [];
                var inputs = $('#toolbar .product_ids');
                for (var i=0; i<inputs.length; i++) {
                    if (inputs[i].checked) {
                        ids.push(inputs[i].value);
                    }
                }

                $('#product_ids').val(ids.join(','));
            }
        }
    });
	//全选按钮的动作：
	$('#select_all').click(function(){
        var $not_checked = $('input.product_ids').not(':checked');
        if($not_checked.length){
            $not_checked.each(function(){
                product_ids.push($(this).val());
                $(this).attr('checked','checked');
            });
            $('#product_ids').val(product_ids.join(','));
            $('#selected_num').html(product_ids.length);
        }else{
            $('#invert_all').click();
        }
        return false;
    });
    //反选按钮：
    $('#invert_all').click(function(){
        $('input.product_ids').each(function(){
            var $this = $(this);
            if(!$this.is(':checked')) {
                product_ids.push($this.val());
                $this.attr('checked','checked');
            }else{
                var idx = $.inArray($this.val(), product_ids);
                if(idx >= 0) {
                    product_ids.splice(idx,1);
                }
                $this.removeAttr('checked');
            }
        });
		$('#product_ids').val(product_ids.join(','));
        $('#selected_num').html(product_ids.length);
        return false;
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
	//“查看所有产品”的动作
	$('#reset_search_grid').click(function(){
		jQuery("#toolbar")[0].clearToolbar();
		return false;
	});
	//给每个id的复选框绑定点击事件：
	$('input.product_ids').live('click',function(){
		if($(this).is(':checked')){
			product_ids.push($(this).val());
		}else {
			var idx = $.inArray($(this).val(), product_ids);
			if(idx >= 0) {
				product_ids.splice(idx,1);
			}
		}
        $('#product_ids').val(product_ids.join(','));
        $('#selected_num').html(product_ids.length);
	});
	set_search_options();
});
function checkboxFormatter (cellvalue, options, rowObject)
{
	var checked = $.inArray(cellvalue, product_ids) >= 0 ?' checked="checked"' : '';
	return '<input type="checkbox" class="product_ids" id="product_id_' + cellvalue + '" value="' + cellvalue + '" ' + checked + '/><label for="product_id_' + cellvalue + '"> #' + cellvalue + '</label>';
}
function typeFormatter (cellvalue, options, rowObject)
{
	var types = ['基本产品','配置产品','打包产品'];
	return ! types[cellvalue] ? '未知' : types[cellvalue] ;
}
function visibilityFormatter(cellvalue,options,rowObject) {
	return cellvalue == 1 ? '可见' : '不可见';
}
function statusFormatter(cellvalue,options,rowObject) {
	return cellvalue == 1 ? '可见' : '不可见';
}
function setFormatter(cellvalue,options,rowObject) {
	var userdata = jQuery("#toolbar").getGridParam('userData');
	return userdata['sets'][cellvalue];
}

//让grid在第一次加载时load已选择的产品而非所有产品列表：
init_Grid = (function(){
	var first_time = true;
	return function(){
		if(first_time) {
			var $grid = jQuery("#toolbar");
			$grid.setPostDataItem('_search',true);
			$grid.setPostDataItem('filters','{"groupOp":"AND","rules":[{"field":"id","op":"bw","data":"1"}]}');
			first_time = false;
		}
	};
})();
