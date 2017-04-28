<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<?php echo View::factory('admin/site/clicks_left')->render(); ?>
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/clicks/data',
                        datatype: "json",
                        height: 450,
                        width: 1250,
                        colNames:['ID','Day','Add cart','Cart view','Continue Shopping','cart/login','cart/view-checkout','proceed','Credit Card','Paypal','Card Pay Now','cart2cookie','cookie2cart','log','Action'],
                        colModel:[
                                {name:'id',index:'id', width:20},
                                {name:'day',index:'day',align:'center', width:50},
                                {name:'add_to_cart',index:'add_to_cart',align:'center', width:40},
                                {name:'cart_view',index:'cart_view',align:'center', width:40},
                                {name:'continue',index:'continue',align:'center', width:40},
                                {name:'cart_login',index:'cart_login',align:'center', width:40},
                                {name:'cart_checkout',index:'cart_checkout',align:'center', width:60},
                                {name:'proceed',index:'proceed',align:'center', width:40},
                                {name:'globebill',index:'globebill',align:'center', width:50},
                                {name:'ppjump',index:'ppjump',align:'center', width:30},
                                {name:'card_pay',index:'card_pay',align:'center', width:40},
                                {name:'cart_to_cookie',index:'cart_to_cookie',align:'center', width:100},
                                {name:'cookie_to_cart',index:'cookie_to_cart',align:'center', width:100},
                                {name:'log',index:'log',align:'center', width:100},
                                {width:80,search:false,formatter:actionFormatter}
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
                
                $('#gs_day').daterangepicker({
                        dateFormat:'yy-mm-dd',
                        rangeSplitter:' to ',
                        onRangeComplete:(function(){
                                var last_date = '',$input = $('#gs_day');
                                return function(){
                                        if(last_date != $input.val()) {
                                                $('#toolbar')[0].triggerToolbar();
                                                last_date = $input.val();
                                        }
                                };
                        })()
                });

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
        });
        function actionFormatter(cellvalue,options,rowObject) {
                return '<a href="#" class="edit_log" id="' + rowObject[0] + '" title="' + rowObject[16] + '">Edit_log</a>';
        }
</script>
<div>

        <div class="box" style="overflow:hidden;">
                <h3>Cart Clicks List</h3>
                <fieldset>
                        <legend style="font-weight:bold">Export</legend>
                        <form id="frm-filter" method="post" action="/admin/site/clicks/export">
                                <label for="filter-start">From: </label>
                                <input type="text" name="start" id="filter-start" class="ui-widget-content ui-corner-all" />
                                <label for="filter-end">To: </label>
                                <input type="text" name="end" id="filter-end" class="ui-widget-content ui-corner-all" />
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
