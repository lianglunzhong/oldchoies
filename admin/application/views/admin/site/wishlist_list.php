<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
    $(function(){
        jQuery("#toolbar").jqGrid({
            url:'/admin/site/wishlist/data',
            datatype: "json",
            height: 500,
            width: 1100,
            colNames:['ID','Customer','SKU','Created','Action'],
            colModel:[
                {name:'id',index:'id',align:'center', width:40},
                {name:'customer',index:'customer_id',align:'center', width:120},
                {name:'sku',index:'sku',align:'center', width:120},
                {name:'created',index:'created',align:'center', width:120},
                {width:80,search:false,formatter:actionFormatter}
            ],
            rowNum:20,
            rowList : [20,50,500],
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
                                        
        $("#deleteSubmit").click(function(){
            var form = $('#orderForm');
            form.attr('action', '/admin/site/feedback/delete');
            form.submit();
        })
    });
    
    function actionFormatter(cellvalue,options,rowObject) {
        // return '<a href="/admin/site/feedback/delete/' + rowObject[1] + '" class="delete">Delete</a>';
        return '';
    }
</script>
<div id="do_content">
    <div class="box" style="overflow:hidden;">
        <h3>Wishlist List</h3>
        <fieldset style="text-align:left;">
            <legend style="font-weight:bold">Export Wishlist</legend>
            <form id="frm-customer-export" method="post" action="/admin/site/wishlist/export" target="_blank">
                <label for="export-start">From: </label>
                <input type="text" name="start" id="export-start" class="ui-widget-content ui-corner-all" />
                <label for="export-end">To: </label>
                <input type="text" name="end" id="export-end" class="ui-widget-content ui-corner-all" />
                <input type="submit" value="Export" class="ui-button" style="padding:0 .5em" />
            </form>
        </fieldset>
        <script type="text/javascript">
            $('#export-start, #export-end').datepicker({
                'dateFormat': 'yy-mm-dd', 
            });
        </script>
        <table id="toolbar"></table>
        <div id="ptoolbar"></div>
    </div>
</div>
