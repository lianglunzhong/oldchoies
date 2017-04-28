<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/review/dataVideo',
                        datatype: "json",
                        height: 420,
                        width: 1040,
                        colNames:['ID','SKU','Customer Email','Caption','URL','Valid','Time','Options'],
                        colModel:[
                                {name:'id',index:'id', width:24,align:'center',search:false},
                                {name:'product_id',index:'product_id', width:70,align:'center'},
                                {name:'customer_id',index:'customer_id',width:100,align:'center'},
                                {name:'caption',index:'caption',width:100,align:'center',search:false},
                                {name:'url_add',index:'url_add',align:'center'},
                                {name:'checked',index:'checked', width:24,align:'center',stype:'select',searchoptions:{value:':All;1:Yes;0:No'}},
                                {name:'created',index:'created', width:50,align:'center'},
                                {width:50,search:false,formatter:actionFormatter,align:'center'}
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
                        if(!confirm('Delete this review?\nIt can not be undone!')){
                                return false;
                        }
                });
                
                $("#video_add").submit(function(){
                        $.post(
                        '/admin/site/review/video_add',
                        {
                                email: $("#email").val(),
                                sku: $("#sku").val(),
                                url: $("#url").val()
                        },
                        function (data) {
                                if (data == 'success')
                                {
                                        window.alert('Add Video Successfully!');
                                        $("#email").val('');
                                        $("#sku").val('');
                                        $("#url").val('');
                                        $('#toolbar').trigger('reloadGrid');
                                }
                                else
                                        window.alert(data);
                        },
                        'json'
                );
                        return false;
                })
                
        });
        function actionFormatter(cellvalue,options,rowObject) {
                var html = '<a href="/admin/site/review/editVideo/' + rowObject[0] + '">Edit</a><span> or </span><a href="javascript:do_delete(' + rowObject[0] + ');">Delete</a>';
                return html;
        }

        function do_delete(review_id)
        {
                if (!window.confirm("Are you sure you want to delete this video ?"))
                        return false;

                $.ajax({
                        url: '/admin/site/review/deleteVideo/'+review_id, 
                        type: 'GET', 
                        success: function(data)
                        {
                                if (data == 'success')
                                {
                                        $('#toolbar').trigger('reloadGrid');
                                }
                                else
                                {
                                        window.alert(data);
                                }
                        }
                });

                //return false;
        }
</script>
<?php echo View::factory('admin/site/feedback_left')->render(); ?>
<div id="do_right">

        <div class="box" style="overflow:hidden;">
                <h3>Video List
                        <div style="margin:20px;">
                                <form enctype="multipart/form-data" method="post" action="/admin/site/review/upload_video" target="_blank">
                                        <input id="file" type="file" name="file">
                                        <input type="submit" value="Bulk Upload" name="submit">
                                </form>
                        </div>
                </h3>
                <fieldset>
                        <legend style="font-weight:bold">Add Video</legend>
                        <div>
                                <form action="/admin/site/review/video_add" method="post" class="need_validation" id="video_add">
                                        <label for="email">Email: </label>
                                        <input type="text" class="text small email" id="email" name="email">
                                        &nbsp;&nbsp;<label for="sku">SKU: </label>
                                        <input type="text" class="text small required" id="sku"  name="sku">
                                        &nbsp;&nbsp;<label for="url">URL: </label>
                                        <input type="text" class="text small required" id="url"  name="url">
                                        <input type="submit" style="padding:0 .5em" class="ui-button" value="Add">
                                </form>
                        </div>
                </fieldset>
                <table id="toolbar"></table>
                <div id="ptoolbar"></div>

        </div>
</div>