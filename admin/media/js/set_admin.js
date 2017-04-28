$(function(){
    jQuery("#toolbar").jqGrid({
        url:'/admin/site/attribute/data/simple',
        datatype: "json",
        height: 350,
        width: 300,
        colNames:['ID','Name'],
        colModel:[
            {name:'attribute_id',index:'id', width:45,formatter:checkboxFormatter},
            {name:'attribute_name',index:'name'}
        ],
        rowNum:15,
        rowList : [15,30,50],
        mtype: "POST",
        gridview: true,
        pager: '#ptoolbar',
        sortname: 'id',
        viewrecords: true,
        sortorder: "desc",
        recordtext: ""
    });

    jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
    jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});

    $('.attribute_ids').live('click',function(){
        var $this = $(this);
        if($this.is(':checked')){
            $this.attr('disabled','disabled');
            $('#attributes_inside').append('<li class="attribute_drag_item" attr_id="' + $this.val() + '"><a href="#" class="remove_attribute" title="Remove"></a><div>' + $this.parent().next().text() + '</div><input type="hidden" name="set[attribute][]" value="' + $this.val() + '"/></li>');
            attribute_ids.push($this.val());
            $('#select_num').text(attribute_ids.length);
        }
    });

    $('#attributes_inside').sortable({
        delay:100
    });
    $('.remove_attribute').live('click',function(){
        var $li = $(this).parent();
        $('#attribute_id_' + $li.attr('attr_id')).removeAttr('checked').removeAttr('disabled');
        var idx = $.inArray($li.attr('attr_id'),attribute_ids);
        if(idx >= 0){
            attribute_ids.splice(idx,1);
            $('#select_num').text(attribute_ids.length);
        }
        $li.remove();
        return false;
    });
    $('.attributes_box,.attributes_box li').disableSelection();
});
var attribute_ids = attribute_ids || [];
function checkboxFormatter (cellvalue, options, rowObject)
{
    var checked = $.inArray(cellvalue, attribute_ids) >= 0 ?' checked="checked" disabled="disabled"' : '';
    return '<input type="checkbox" class="attribute_ids" id="attribute_id_' + cellvalue + '" value="' + cellvalue + '" ' + checked + '/><label for="attribute_id_' + cellvalue + '"> #' + cellvalue + '</label>';
}

