<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<?php echo View::factory('admin/site/clicks_left')->render(); ?>
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/clicks/products_data?<?php echo $_SERVER['QUERY_STRING']; ?>',
                        datatype: "json",
                        height: 450,
                        width: 1250,
                        colNames:['ID','SKU','Set','Price','Clicks','Q_clicks','Add Cart','Hits'],
                        colModel:[
                                {name:'id',index:'id', width:20},
                                {name:'sku',index:'sku',align:'center', width:40},
                                {name:'set',index:'set',align:'center', width:50},
                                {name:'product_price',index:'price',align:'center', width:40},
                                {name:'clicks',index:'clicks',align:'center', width:40},
                                {name:'quick_clicks',index:'quick_clicks',align:'center', width:40},
                                {name:'add_times',index:'add_times',align:'center', width:40},
                                {name:'hits',index:'hits',align:'center', width:40},
//                                {width:80,search:false,formatter:actionFormatter}
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
                        sortname: 'clicks',
                        viewrecords: true,
                        sortorder: "desc"
                        //            caption: "Toolbar Searching"
                });

                jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
                jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});

                $('.delete').live('click',function(){
                        if(!confirm('Delete this link?\nIt can not be undone!')){
                                return false;
                        }
                });
                
                $('.edit_log').live('click',function(){
                        $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                        $('#celebrity_view').appendTo('body').fadeIn(320);
                        var id = $(this).attr('id');
                        var title = $(this).attr('title');
                        $('#editId').val(id);
                        $('#editLog').val(title);
                        $('#celebrity_view').show();
                        return false;
                })
        
                $("#celebrity_view .closebtn,#wingray").live("click",function(){
                        $("#wingray").remove();
                        $('#celebrity_view').fadeOut(160).appendTo('#tab2');
                        return false;
                })
                
                $("#export-button").click(function(){
                        $("#frm-filter").attr('action', '/admin/site/clicks/products_export');
                        $("#frm-filter").submit();
                        return false;
                })
                
        });
        function actionFormatter(cellvalue,options,rowObject) {
                return '<a href="#" class="edit_log" id="' + rowObject[0] + '" title="' + rowObject[15] + '">Edit_log</a>';
        }
</script>
<div>

        <div class="box" style="overflow:hidden;">
                <?php
                $fromto = '';
                $start = Arr::get($_GET, 'start', NULL);
                $end = Arr::get($_GET, 'end', NULL);
                if($start)
                {
                        if($end)
                        {
                                $fromto = 'From ' . date('Y-m-d', $start) . ' To ' . date('Y-m-d', $end);
                        }
                        else
                        {
                                $fromto = 'From ' . date('Y-m-d', $start) . ' To ' . date('Y-m-d');
                        }
                }
                ?>
                <h3>Products Clicks List <?php echo $fromto; ?></h3>
                <fieldset>
                        <legend style="font-weight:bold">Filter</legend>
                        <form id="frm-filter" method="post" action="">
                                <label for="filter-start">From: </label>
                                <input type="text" name="start" id="filter-start" class="ui-widget-content ui-corner-all" />
                                <label for="filter-end">To: </label>
                                <input type="text" name="end" id="filter-end" class="ui-widget-content ui-corner-all" />
                                <input type="submit" value="Filter" class="ui-button" style="padding:0 .5em" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="submit" value="Export" class="ui-button" id="export-button" style="padding:0 .5em" />
                        </form>
                </fieldset>
                <script type="text/javascript">
                        $('#filter-start, #filter-end').datepicker({
                                'dateFormat': 'yy-mm-dd'
                        });
                </script>
                <table id="toolbar"></table>
                <div id="ptoolbar"></div>

        </div>
</div>
<div id="celebrity_view" class="" style="padding-bottom: 50px; padding-right: 50px; width: 422px; height: 158px; top: 15px; left: 438.5px;display:none;">
        <div id="cboxWrapper" style="height: 218px; width: 472px;"><div>
                        <div id="cboxTopLeft" style="float: left;"></div>
                        <div id="cboxTopCenter" style="float: left; width: 422px;"></div>
                        <div id="cboxTopRight" style="float: left;"></div></div>
                <div style="clear: left;"><div id="cboxMiddleLeft" style="float: left; height: 158px;"></div>
                        <div id="cboxContent" style="float: left; width: 422px; height: 158px;">
                                <div id="cboxLoadedContent" style="display: block; width: 422px; overflow: auto; height: 148px;">
                                        <div style="padding:10px; background:#fff;" id="inline_example2">
                                                <h3>Edit Log</h3>
                                                <form action="/admin/site/clicks/edit_log" method="post" id="editLog">
                                                        <input type="hidden" name="id" value="" id="editId" />
                                                        <textarea type="text" name="log" id="editLog" cols="60" rows="5"></textarea>
                                                        <input type="submit" value="submit" />
                                                </form>
                                        </div>
                                </div>
                                <div class="closebtn" style="top: 25px;right: 20px;">close</div>
                        </div>
                        <div id="cboxMiddleRight" style="float: left; height: 158px;"></div>
                </div>
                <div style="clear: left;">
                        <div id="cboxBottomLeft" style="float: left;"></div>
                        <div id="cboxBottomCenter" style="float: left; width: 422px;"></div>
                        <div id="cboxBottomRight" style="float: left;"></div>  
                </div>
        </div>
        <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
</div>
