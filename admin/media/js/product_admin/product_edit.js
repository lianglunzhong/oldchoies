$(function(){
    uploaded = {
        'add':function(filename,file_id){
            //TODO 修改具体样式：
            var image_li = '\
            <li image_id = "' + file_id + '">\n\
            <img src = "' + config['image_tempfolder'] + filename + '" />\n\
            <div class="image_actions">\n\
            <a href="#" class="image_set_default">设为默认</a>\n\
            <a href="#" class="image_remove">删除</a>\n\
            </div>\n\
            </li>';
            $('#images_list').append(image_li);
            //set images_order
            var images_order = '';
            $("#images_list").find('li').each(function(){
                var image_id = $(this).attr('image_id');
                images_order += image_id + ',';
            })
            images_order = images_order.substr(0, images_order.length - 1);
            $('input[name=images_order]').val(images_order);
        },
        'remove':function(file_id){
            var $input_default = $('input[name=images_default]'),
            $input_removed = $('input[name=images_removed]');
            $input_removed.val($input_removed.val() + ($input_removed.val()  == '' ? '' : ',') + file_id);
            //如果删掉了默认图片，则把默认设为空：
            if($input_default.val() == file_id) {
                $input_default.val('');
            }
            //set images_order
            var images_order = '';
            $("#images_list").find('li').each(function(){
                var image_id = $(this).attr('image_id');
                images_order += image_id + ',';
            })
            images_order = images_order.substr(0, images_order.length - 1);
            $('input[name=images_order]').val(images_order);
        }
    };
    var uploader = new qq.FileUploader({
        element: document.getElementById('upload_box'),
        action: '/admin/site/product/image_upload/'+config['product_id'],
        params:{
            folder:'product_image'
        },
        allowedExtensions:config['image_allowed_extensions'],
        sizeLimit:config['image_max_size'],
        onComplete:function(id, fileName, responseJSON) {
            if(responseJSON['success'] == 'true'){
                uploaded.add(responseJSON['filename'],responseJSON['file_id']);
            }
        }
    });
    $('.qq-upload-drop-area').click(function(){this.style.display = 'none';});

    $('.image_remove').live('click',function(){
        var $li = $(this).parent().parent();
        uploaded.remove($li.attr('image_id'));
        $li.remove();
        return false;
    });
    $('.image_set_default').live('click',function(){
        var $this = $(this),$li = $this.parent().parent();
        $('input[name=images_default]').val($li.attr('image_id'));
        $('#is_default').after($this.clone()).remove();
        $this.after('<span id="is_default">默认&nbsp;&nbsp;</span>').remove();
        return false;
    });
});

//相关产品的选择列表
$(function(){
    $('#ptoolbar').parent().append('<input type="hidden" name="product_ids" id="product_ids" value="' + product_ids.join(',') + '"/>');
    jQuery("#toolbar").jqGrid({
        url:'/admin/site/product/data/'+config['product_id'],
        datatype: "json",
        height: 400,
        width: 1100,
        colNames:['ID','Name','Type','Set','SKU','Price','Created','Stock','Visibility','Status'],
        colModel:[
            {name:'product_id',index:'id', width:80,formatter: checkboxFormatter,searchoptions:{'value':':所有产品;1:已设为相关的产品;0:未设为相关的产品;2:本次勾选的产品','defaultValue':1},stype:'select'},
            {name:'product_name',index:'name', width:200},
            {name:'product_type',index:'type', width:70,align:'center',formatter:typeFormatter,searchoptions:{'value':':所有产品;0:基本产品;1:配置产品;2:打包产品'},stype:'select',"summaryTpl":"{0}"},
            {name:'product_set',index:'set_id', width:80,formatter:setFormatter,
                "searchoptions":{"value":":ALL"},
                "stype":"select",
                "summaryTpl":"{0}"
            },
            {name:'product_sku',index:'sku', width:100},
            {name:'product_price',index:'price', width:100},
            {name:'product_created',index:'created', width:60},
            {name:'product_stock',index:'stock', width:100},
            {name:'product_visibility',index:'visibility', width:60,formatter:visibilityFormatter,
                "searchoptions":{"value":":ALL;1:可见;0:不可见"},
                "stype":"select",
                "summaryTpl":"{0}"
            },
            {name:'product_status',index:'status', width:100,formatter:statusFormatter,
                "searchoptions":{"value":":所有产品;1:上架;0:下架"},
                "stype":"select",
                "summaryTpl":"{0}"
            }
        ],
        rowNum:30,
        //  rowTotal: 12,
        rowList : [15,30,50],
        // loadonce:true,
        mtype: "POST",
        // rownumbers: true,
        // rownumWidth: 40,
        gridview: true,
        postData: {'usefor':'related_products'},
        pager: '#ptoolbar',
        sortname: 'id',
        viewrecords: true,
        sortorder: "desc",
        //表格数据载入后:
        gridComplete: on_grid_refresh,
        //提交ajax请求之前，判断是否要传送“本地选中的id列表”给服务器
        beforeRequest:function(){
            init_Grid();
            //判断是否要传送“本地选中的id列表”给服务器
            if($('#gs_product_id').val() == 2) {
                $(this).setPostDataItem('selected',$('#product_ids').val());
            } else {
                $(this).removePostDataItem('selected');
            }
        }
    });
    jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
    jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
    set_search_options();
});
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
$(function() {
	$( "#images_list" ).sortable({
		stop: function(event, ui)
			{
				images_order = $('input[name=images_order]');
				images_order.val('');
				$.each($('#images_list li'),function(){
					images_order.val(images_order.val() + (images_order.val()  == '' ? '' : ',') + $(this).attr('image_id'))
					});
			}
		});
	$( "#images_list" ).disableSelection();
});
function typeFormatter (cellvalue, options, rowObject)
{
        var types = ['Simple','Configure','Package','Simple-Config'];
        return ! types[cellvalue] ? '未知' : types[cellvalue] ;
}