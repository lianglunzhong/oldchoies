//for select associate products
function idFormatter (cellvalue, options, rowObject)
{
    var checked = disabled = '';
    if($.inArray(cellvalue, selected_packaged) >= 0) {
        checked = ' checked="checked" ';
        disabled = ' disabled="disabled" ';
    }
    return '<input type="checkbox" class="packaged_product_ids" product_name="' + rowObject[1] + '" product_sku="' + rowObject[4] + '" id="packaged_product_id_' + cellvalue + '" value="' + cellvalue + '" ' + checked + disabled +' /><label for="packaged_product_id_' + cellvalue + '"> #' + cellvalue + '</label>';
}

		
	//打包产品的选择列表
	$(function(){
		jQuery("#atoolbar").jqGrid({
			url:'/admin/site/product/data',
			datatype: "json",
			height: 400,
			width: 900,
			colNames:['ID','名称','类型','SET','SKU','价格','库存','显示','状态'],
			colModel:[
				{name:'packaged_product_id',index:'id', width:60,formatter:idFormatter},
                {name:'packaged_product_name',index:'name', width:200},
                {name:'packaged_product_type',index:'type', width:100,align:'center',formatter:typeFormatter,searchoptions:{'value':':所有产品;0:基本产品;1:配置产品'},stype:'select',"summaryTpl":"{0}"},
				{name:'packaged_product_set',index:'set_id', width:80,formatter:packageSetFormatter,
						"searchoptions":{"value":":所有产品"},
						"stype":"select",
						"summaryTpl":"{0}"
					},
				{name:'packaged_product_sku',index:'sku', width:100},
				{name:'packaged_product_price',index:'price', width:60},
				{name:'packaged_product_stock',index:'stock', width:60},
				{name:'packaged_product_visibility',index:'visibility', width:60,formatter:visibilityFormatter,
					"searchoptions":{"value":":所有产品;1:可见;0:不可见"},
					"stype":"select",
					"summaryTpl":"{0}"
				},
				{name:'packaged_product_status',index:'status', width:50,formatter:statusFormatter,
					"searchoptions":{"value":":所有产品;1:上架;0:下架"},
					"stype":"select",
					"summaryTpl":"{0}"
				}
			],
			rowNum:15,
			rowList : [15,30,50],
			mtype: "POST",
			gridview: true,
			postData: {'id_for_search':1,'usefor':'packaged_products'},
			pager: '#aptoolbar',
			sortname: 'id',
			viewrecords: true,
			sortorder: "desc",
			//表格数据载入后:
			gridComplete: function(){
				//给每个id的复选框绑定点击事件：
				$('input.packaged_product_ids').click(function(){
					var $this = $(this);
					if($this.is(':checked')){
						add_packaged_product($this.val(),$this.attr('product_name'),$this.attr('product_sku'));
						selected_packaged.push($this.val());
                        $('#packaged_ids').val(selected_packaged.join(','));
                        $this.attr('disabled','disabled');
					}
				});
			}
		});
		jQuery("#atoolbar").jqGrid('navGrid','#aptoolbar',{del:false,add:false,edit:false,search:false});
		jQuery("#atoolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
		$('.remove_selected_product').live('click',function(){
			var $this = $(this),$parent = $this.parent().parent();
			$parent.remove();
			$('#packaged_product_id_' + $this.attr('product_id')).removeAttr('checked').removeAttr('disabled');
			var idx = $.inArray($this.attr('product_id'),selected_packaged);
			if(idx >= 0) {
				selected_packaged.splice(idx,1);
			}
			$('#packaged_ids').val(selected_packaged.join(','));
			return false;
        });
    });
    function packageSetFormatter(cellvalue,options,rowObject) {
	    var userdata = jQuery("#atoolbar").getGridParam('userData');
	    return userdata['sets'][cellvalue];
    }
    function add_packaged_product(id,label,sku) {
        var tr = '<tr><td>' + id + '</td><td>' + label + '</td><td>' + sku + '</td><td><input type="text" class="text numeric digits inline" name="packaged[min][' + id + ']" value="0"/></td><td><input type="text" class="text numeric digits inline" name="packaged[max][' + id + ']" value="1"/></td><td><a href="/admin/site/product/edit/' + id + '" target="_blank">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" product_id="' + id + '" class="remove_selected_product">Remove</a></td></tr>'
		var div = '<div class="associated_product" id="packaged_box_' + id + '">\
							<div class="product_title clr"><a href="#" product_id="' + id + '" class="remove_selected_product">Remove</a><a href="/admin/site/product/edit/' + id + '" target="_blank">编辑</a>#' + id + ': ' + label + '&nbsp;&nbsp;&nbsp;&nbsp;Min.Quantity: <input type="text" class="text numeric inline" value="0"/>&nbsp;&nbsp;Max.Quantity: <input type="text" class="text numeric inline" value="1"/></div>\
						</div>';
		if(!$('#selected_packaged_products').length){
            $('#selecte_simple_form').before('<table><thead>\
                <tr>\
                <th scope="col">ID</td>\
                <th scope="col" width="60%">Name</td>\
                <th scope="col">SKU</td>\
                <th scope="col">Min. Quantity</td>\
                <th scope="col">Max. Quantity</td>\
                <th scope="col">Actions</td>\
                </tr>\
                </thead><tbody id="selected_packaged_products"></tbody></table>');
		}
		$('#selected_packaged_products').append(tr);
	}
