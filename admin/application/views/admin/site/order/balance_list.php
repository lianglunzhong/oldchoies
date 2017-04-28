<?php echo View::factory('admin/site/order/left')->render();?>
<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<div id="do_right">
<?php
$currencies_obj = Site::instance()->currencies();
$currencies = array('All');
foreach($currencies_obj as $c){
    $currencies[$c['name']] = $c['name'];
}
$pay_statuses = array('All');
$ship_statuses = array('All');
$issue_statuses = array('All');
$refund_statuses = array('All');
$return_statuses = array('All');
$statuses = kohana::config('order_status');
foreach($statuses['payment'] as $ck => $c)
    $pay_statuses[$ck] = $c['name'].($c['description']?' ['.$c['description'].']':'');
foreach($statuses['shipment'] as $ck => $c)
    $ship_statuses[$ck] = $c['name'].($c['description']?' ['.$c['description'].']':'');
foreach($statuses['refund'] as $ck => $c)
    $refund_statuses[$ck] = $c['name'].($c['description']?' ['.$c['description'].']':'');
foreach($statuses['return'] as $ck => $c)
    $return_statuses[$ck] = $c['name'].($c['description']?' ['.$c['description'].']':'');
?>
<script type="text/javascript">
$(function(){
    jQuery("#toolbar").jqGrid({
        url:'/admin/site/order/balance_data',
            datatype: "json",
            height: 460,
            width: 900,
            colNames:['ID','Order Number','Email','Created on','Payment Status','Currency','Amount','IP','Action'],
            colModel:[
            {name:'id',index:'id',width:80},
            {name:'ordernum',index:'ordernum'},
            {name:'email',index:'email'},
            {name:'created',index:'created',width:250},
            {name:'payment_status',index:'payment_status',stype:'select',searchoptions:{value:<?php echo "'".str_replace(array('"','{','}',',','0:All'),array('','','',';',':All'),json_encode($pay_statuses))."'";?>}},
            {name:'currency',index:'currency',width: 100,stype:'select',searchoptions:{value:<?php echo "'".str_replace(array('"','{','}',',','0:All'),array('','','',';',':All'),json_encode($currencies))."'";?>}},
            {name:'amount',index:'amount',width:80},
            {name:'ip',index:'ip',width:80},
            {search:false,formatter:actionFormatter}
            ],
            rowNum:20,
            rowList : [20,30,50],
            mtype: "POST",
            gridview: true,
            pager: '#ptoolbar',
            sortname: 'id',
            viewrecords: true,
            sortorder: "desc",
            recordtext: "View {0} - {1} of {2}",
            emptyrecords: "No records to view",
            loadtext: "Loading...",
            pgtext : "Page {0} of {1}"
    });

    jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,multipleSearch:true});
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
function actionFormatter(cellvalue,options,rowObject) {
    return '<a href="/admin/site/order/edit/' + rowObject[0] + '">Edit</a>';
}
</script>
<div id="do_content">
    <div class="box" style="overflow:hidden;">
        <h3>Order List</h3>
        <table id="toolbar"></table>
        <div id="ptoolbar"></div>
    </div>
</div>
</div>
