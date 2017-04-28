<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/customer/orders_data?<?php echo $_SERVER['QUERY_STRING']; ?>',
                        datatype: "json",
                        height: 400,
                        width: 1000,
                        colNames:['ID','Email','Orders','Order Total($)'],
                        colModel:[
                                {name:'customer_id',index:'id', width:40},
                                {name:'customer_email',index:'email', width:150,formatter:actionFilter},
                                {name:'customer_orders', index:'orders',width:80}, 
                                {name:'customer_order_total', index:'order_total',width:50,search:false},
                        ],
                        rowNum:20,
                        rowList : [20,30,50],
                        mtype: "POST",
                        gridview: true,
                        pager: '#ptoolbar',
                        sortname: 'id',
                        viewrecords: true,
                        sortorder: "desc"
		
                });

                jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
                jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});

                $('#gs_created').daterangepicker({
                        dateFormat:'yy-mm-dd',
                        rangeSplitter:' to ',
                        onRangeComplete:(function(){
                                var last_date = '',$input = $('#gs_created');
                                return function(){
                                        if(last_date != $input.val()) {
                                                $('#toolbar')[0].triggerToolbar();
                                                last_date = $input.val();
                                        }
                                };
                        })()
                });
		
        });


        function actionFilter(cellvalue,options,rowObject) {
                return $('<div/>').text(cellvalue).html();
        }

</script>
<div id="do_content">
        <form id="frm_remote_login" method="post" action="" target="_blank">
                <input type="hidden" name="hashed" value="TRUE" />
                <input type="hidden" name="email" value="" />
                <input type="hidden" name="password" value="" />
        </form>
        <div class="box" style="overflow:hidden;">
                <h3>
                        <?php
                        if(isset($_GET['history']))
                        {
                                $history = $_GET['history'];
                                $daterange = explode('-', $history);
                                $date = date('Y-m-d', $daterange[0]) . ' ~ ' . $date = date('Y-m-d', $daterange[1]);
                        }
                        else
                        {
                                $date = '';
                        }
                        ?>
                        <strong style="color:red;"><?php echo $date; ?></strong>Customer Orders
                        <span class="moreActions">
                                <a href="/admin/site/customer/list">Back TO Customers</a>
                        </span>
                </h3>
                <fieldset>
                        <legend style="font-weight:bold">Time Filter</legend>
                        <form id="frm-customer-export" method="post" action="">
                                <label for="export-start">From: </label>
                                <input type="text" name="start" id="export-start" class="ui-widget-content ui-corner-all" />
                                <label for="export-end">To: </label>
                                <input type="text" name="end" id="export-end" class="ui-widget-content ui-corner-all" />
                                <input type="submit" value="Filter" class="ui-button" style="padding:0 .5em" />
                                <input type="submit" value="List All" class="ui-button" style="padding:0 .5em" name="all" />
                        </form>
                </fieldset>
                <script type="text/javascript">
                        $('#export-start, #export-end').datepicker({
                                'dateFormat': 'yy-mm-dd', 
                        });
                </script>
                <table id="toolbar"></table>
                <div id="ptoolbar"></div>
                <form id="frm-customer-export" method="post" action="/admin/site/customer/orders_export" target="_blank">
                        <input type="hidden" value="<?php echo Arr::get($_GET, 'history', ''); ?>" name="history" />
                        <input type="submit" value="Export" name="submit" class="ui-button" style="padding:0 .5em" />
                </form>
        </div>
</div>
