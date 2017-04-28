<?php echo View::factory('admin/site/basic_left')->render(); ?>

<div id="do_right">

<div class="box">
<h3>Product Attribute
        <?php
            $languages = Kohana::config('sites.1.language');
            $now_lang = Arr::get($_GET, 'lang', 'en');
            foreach ($languages as $l)
            {
                ?>
                <a class="product_list" href="/admin/site/attribute/small/<?php if ($l != 'en') echo $l; ?>" <?php if ($now_lang == $l) echo 'style="color:red"'; ?>><?php echo $l; ?></a>
                <?php
            }
        ?>
</h3>

<table id="toolbar"></table>
<div id="ptoolbar"></div>

</div>
</div>

<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/admin/site/attribute/data',
            datatype: "json",
			height: 600,
			width: 750,
			colNames:['ID','Name','Label','Scope','Brief','Actions'],
			colModel:[
				{name:'attribute_id',index:'id', width:30},
				{name:'attribute_name',index:'name', width:120},
                {name:'attribute_label',index:'label', width:120},
                {name:'attribute_scope',index:'scope',align:'center', width:47,formatter:scopeFormatter,searchoptions:{'value':':ALL;0:Simple product ;1:Configrable product ;2:Cart'},stype:'select',"summaryTpl":"{0}"},
                {name:'attribute_brief',index:'brief', width:80},
				{width:60,search:false,formatter:actionFormatter}
			],
            rowNum:30,
            //  rowTotal: 12,
            rowList : [20,30,50],
            // loadonce:true,
            mtype: "POST",
                // rownumbers: true,
            // rownumWidth: 40,
            gridview: true,
            pager: '#ptoolbar',
            sortname: 'id',
            viewrecords: true,
            sortorder: "desc"
            //            caption: "Toolbar Searching"
		});

		jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
        jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});

        $('.delete_attribute').live('click',function(){
            if(!confirm('Delete this attribute? It can not be undone!'))
            {
                return false;
            }
        });
	});
	function actionFormatter(cellvalue,options,rowObject) {
		return '<a href="/admin/site/attribute/edit/' + rowObject[0] + '" title="edit">Edit</a>&nbsp;|&nbsp;<a class="delete_attribute" title="delete" href="/admin/site/attribute/delete/' + rowObject[0] + '">Delete</a>';
    }
    function scopeFormatter(cellvalue,options,rowObject) {
        var scopes = ['Simple product','Configurable roduct','Cart'];
        return scopes[cellvalue];
    }
</script>
