<?php echo View::factory('admin/site/banner_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript" src="/media/js/file-uploader/fileuploader.js"></script>
<link rel="stylesheet" type="text/css" href="/media/js/file-uploader/fileuploader.css" />
<script type="text/javascript">
  $(function(){
        jQuery("#toolbar").jqGrid({
            url:'/admin/site/banner/data1',
            datatype: "json",
            height: 450,
            width: 800,
            colNames:['ID','catalog_id','mark_name','created'],
            colModel:[
                {name:'id',index:'id', width:40},
                {name:'catalog_id',index:'catalog_id', width:60},
                {name:'mark_name',index:'mark_name', width:100},
                {name:'created',index:'created', width:60},
            ],
            rowNum:20,
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

        $('.delete').live('click',function(){
            if(!confirm('Delete this lookbook?\nIt can not be undone!')){
                return false;
            }
        });
    });
</script>

<div id="do_right">

    <div class="box" style="overflow:hidden;">
<table id="toolbar"></table>
        <div id="ptoolbar"></div>
        <h3>Products Add</h3>
            

            <form enctype="multipart/form-data" method="post" action="/admin/site/banner/cologs_edit" class="lang_hidden">
                <h3>请选择marks</h3><br /><br /> 
                <?php
                foreach ($content as $key => $value) {
                    ?>
                    <label for="<?php echo $value['name']; ?>"><input name="sex" type="radio" value="<?php echo $value['name']; ?>" id="<?php echo $value['name']; ?>" /><img border="0" usemap="#Map" src="<?php echo STATICURL; ?>/assets/images/marks/<?php echo $value['name']; ?>.png"> </label> 
                    <?php
                };
                ?>
                <br/>
                <textarea name="sku" cols="30" rows="15"></textarea>
                <input type="submit" name="submit" value="提交" />
            </form>
            <br/>
            <?php

            if(!empty($update)){
                foreach ($update as $upmarks) {
            ?>
                     <h5>更新了product_id:<?php echo $upmarks;?></h5>
            <?php
            }}
            ?>
            <hr/>
            <?php

            if(!empty($add)){
            foreach ($add as $addmarks) {
            ?>
             <h5>添加了product_id:<?php echo $addmarks;?></h5>
            <?php 
            }}
            ?>

            <form enctype="multipart/form-data" method="post" action="/admin/site/banner/cologs_edit" class="lang_hidden">
                <h3>批量删除</h3><br /><br /> 
                <br/>
                <input type="hidden" name="del" value="del" />
                <textarea name="delsku" cols="30" rows="15"></textarea>
                <input type="submit" name="submit" value="提交" />
            </form>
            <br/>
            <?php
            if(!empty($del)){
                foreach ($del as $delmarks) {
            ?>
                     <h5>删除了product_id:<?php echo $delmarks;?></h5>
            <?php
            }}
            ?>
            <hr/>


    </div>
</div>
