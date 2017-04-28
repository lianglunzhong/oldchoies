$(function(){
    //tree view:
    $('li.catalog_tree_name').prepend('<ins class="tree_icon">&nbsp;</ins>');
    $('li.catalog_tree_children').prev().find('.tree_icon').addClass('tree_icon_parent tree_icon_parent_expanded').css('cursor','pointer').click(function(){
        $(this).toggleClass('tree_icon_parent_expanded').parent().next().slideToggle(0);
    });
    $('li.catalog_tree_name input[type=checkbox]').click(function(){
        $(this).prev().toggleClass('tree_checked');
    });
    $('.delete_catalog').click(function(){
        if(!confirm('Delete this catalog: "' + $(this).prev().text() + '"?\nIt can not be undone!')){
            return false;
        }
    });
    $('#catalog_tree > li').css('margin-left','0');
    $('#catalog_tree_collapse_expand').click(function(){
        var $this = $(this),text = $this.text();
        $('#catalog_tree > li > .tree_icon_parent').each(function(){collapse_expand_all(this);});
        $this.text(text == 'Collapse All' ? 'Expand All' : 'Collapse All');
        return false;
    });

    $('input[name=catalog_name]').change(function(){
        $('input[name=link]').val($.trim($(this).val()).toLowerCase().replace(/[^\b\w]+/g,'-'));
    });
    $("#tabs").tabs();

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

    var uploader = new qq.FileUploader({
        element: document.getElementById('upload_box'),
        action: '/admin/site/image/embed_manager',
        params:{ 
            folder:'site_image'
        },
        allowedExtensions:config['image_allowed_extensions'],
        sizeLimit:config['image_max_size'],
        onComplete:function(id, fileName, responseJSON) {
            if(responseJSON['success'] == 'true'){
                var $src = $('input[name=image_src]'),$bak = $('input[name=image_bak]'),$name = $('#image_filename'),$preview = $('#image_preview');
                $name.text(responseJSON['filename']);
                $src.val(responseJSON['filename']);
                $bak.val($bak.val()+','+responseJSON['filename']);
                $preview.html('<img src="' + responseJSON['file_url'] + '"/>');
                $('#delete_image_src').show();
                $('.qq-upload-success').remove();
            }
        }
    });
    $('.qq-upload-drop-area').click(function(){this.style.display = 'none';});
    $('#delete_image_src').click(function(){
        var $src = $('input[name=image_src]'),$name = $('#image_filename'),$preview = $('#image_preview');
        $src.val('');
        $name.empty();
        $preview.empty();
        $(this).hide();
        return false;
    });
});
function check_label($checkbox,$label) {
    if($checkbox.is(':checked')) {
        $label.addClass('filter_condition_checkboxs_label_selected');
    }else {
        $label.removeClass('filter_condition_checkboxs_label_selected');
    }
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
