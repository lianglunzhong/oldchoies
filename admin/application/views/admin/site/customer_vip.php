<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
    $(function(){
        jQuery("#toolbar").jqGrid({
            url:'/admin/site/customer/vip_data<?php echo isset($_GET['total']) ? '?total=' . $_GET['total'] : ''; ?>',
            datatype: "json",
            height: 450,
            width: 1000,
            colNames:['Id','Email','Country','Vip level','Created','Order total','Order Qty','Last Order Date'],
            colModel:[
                {name:'id',index:'id', width:60},
                {name:'email',index:'email', width:80},
                {name:'ip_country',index:'ip_country', width:40},
                {name:'is_vip',index:'is_vip', width:30},
                {name:'created',index:'created', width:80},
                {name:'order_total',index:'order_total', width:40},
                {name:'order_qty',index:'orderqty', width:30},
                {name:'last_order_date',index:'last_order_date', width:100},
            ],
            rowNum:20,
            rowList : [20,50,100],
            mtype: "POST",
            gridview: true,
            pager: '#ptoolbar',
            sortname: 'id',
            viewrecords: true,
            sortorder: "desc"
            //caption: "Toolbar Searching"
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
        })
    });
</script>
<div id="do_right">

    <div class="box" style="overflow:hidden;">
        <h3>
            Vip客户订单统计
            <?php if(isset($_GET['total'])) echo ' <span style="color:red;">' . $_GET['total'] . '</span> <a href="/admin/site/customer/vip">clear</a>'; ?> :
        </h3>
        <div>
            <form style="margin:20px;" id="frm-customer-export" method="post" action="#">
                <label for="total-from">Order Total From: </label>
                <input type="text" name="start" id="total-from" class="ui-widget-content ui-corner-all" />
                <label for="total-to">To: </label>
                <input type="text" name="end" id="total-to" class="ui-widget-content ui-corner-all" />
                <input type="submit" name="submit" value="filter" id="filter" class="ui-button" style="padding:0 .5em" />
                <input type="submit" name="submit" value="export" id="export" class="ui-button" style="padding:0 .5em" />
            </form>
        </div>
        <table id="toolbar"></table>
        <div id="ptoolbar"></div>

    </div>
</div>