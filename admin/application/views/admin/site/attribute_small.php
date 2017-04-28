<?php echo View::factory('admin/site/basic_left')->render(); ?>

<div id="do_right">

    <div class="box">
        <h3>Product Attribute
        <?php
            $languages = Kohana::config('sites.1.language');
            foreach ($languages as $l)
            {
                ?>
                <a class="product_list" href="/admin/site/attribute/small/<?php if ($l != 'en') echo $l; ?>" <?php if ($lang == $l) echo 'style="color:red"'; ?>><?php echo $l; ?></a>
                <?php
            }
        ?>
        </h3>
        
        <table id="toolbar"></table>
        <div id="ptoolbar"></div>
        <script type="text/javascript" src="/media/js/core.js"></script>
            <script type="text/javascript" src="/media/js/tiny_mce/tiny_mce.js"></script>
            <script type="text/javascript">
                    tinyMCE.init({
                        mode : "textareas",
                        theme : "advanced",
                        plugins : "fullscreen",
                        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,"
                            + "|,justifyleft,justifycenter,justifyright,justifyfull,"
                            + "|,cut,copy,paste,pastetext,pasteword,"
                            + "|,search,replace,"
                            + "|,bullist,numlist,"
                            + "|,outdent,indent,blockquote,"
                            + "|,undo,redo,|,link,unlink,cleanup,code,|,fullscreen",
                        theme_advanced_buttons2 : "",
                        theme_advanced_toolbar_location : "top",
                        theme_advanced_toolbar_align : "left",
                        theme_advanced_statusbar_location : "bottom",
                        theme_advanced_resizing : true,
                        elements : "content"
                    });
            </script>
            <div style="margin:20px;">
                <div>小语种批量修改attribute名称</div>
                <span style="color:red;">模板: en_name, name</span>
                <form method="post" action="/admin/site/attribute/import_small/<?php echo $lang; ?>" id="form1">
                    <table class="layout">
                        <tr>
                            <td></td>
                            <td><textarea name="content" id="content" cols="55" rows="20" ></textarea></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" value="Save" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>

    </div>
</div>

<script type="text/javascript">
    $(function(){
        jQuery("#toolbar").jqGrid({
            url:'/admin/site/attribute/small_data/<?php echo $lang; ?>',
            datatype: "json",
            height: 600,
            width: 750,
            colNames:['ID','Name','Label','Brief','<?php echo strtoupper($lang); ?> Name','Actions'],
            colModel:[
                {name:'attribute_id',index:'id', width:30},
                {name:'attribute_name',index:'name', width:120},
                {name:'attribute_label',index:'label', width:120},
                {name:'attribute_brief',index:'brief', width:80},
                {name:'<?php echo $lang; ?>',index:'<?php echo $lang; ?>', width:80},
                {width:60,search:false,formatter:actionFormatter}
            ],
            rowNum:30,
            //  rowTotal: 12,
            rowList : [20,50,100,200],
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
        return '<a class="edit" href="javascript:edit(&quot;<?php echo $lang; ?>&quot;,'+rowObject[0]+',&quot;'+rowObject[4]+'&quot;,&quot;'+rowObject[1]+'&quot;)">Edit</a>';
    }
    function scopeFormatter(cellvalue,options,rowObject) {
        var scopes = ['Simple product','Configurable roduct','Cart'];
        return scopes[cellvalue];
    }
    
    function edit(lang,id,name,en_name)
        {
                var rea = window.prompt("'" + en_name + "' <?php echo $lang; ?> Name is: ",name);
                if( rea != null )  
                {
                        $.ajax({
                                url: '/admin/site/attribute/small_edit/' + id +'?lang='+lang+'&name=' + rea,
                                success: function (data) {
                                        if (data == 'success')
                                                $('#toolbar').trigger('reloadGrid');
                                        else
                                                window.alert(data);
                                }
                        });
                }
        }
</script>
