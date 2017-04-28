<script type="text/javascript">
    $(function(){
        jQuery("#toolbar").jqGrid({
            url:'/admin/site/orderproduct/month_data',
            datatype: "json",
            height: 450,
            width: 1000,
            colNames:['Id','Country','month','订单数','红人+活动单数','纯销售订单数','销售件数(纯销售)','客件数(纯销售)','客单价USD(纯销售)','毛利润率(纯销售)','热销分类1','热销分类2','热销分类3','热销分类4','热销分类5'],
            colModel:[
                {name:'id',index:'id', width:60},
                {name:'country',index:'country', width:80},
                {name:'month',index:'month', width:80},
                {name:'order_qty',index:'order_qty', width:60},
                {name:'celebrity_orders',index:'celebrity_orders', width:60},
                {name:'sale_orders',index:'sale_orders', width:60},
                {name:'product_qty',index:'product_qty', width:60},
                {name:'average_qty',index:'average_qty', width:80},
                {name:'order_amount',index:'order_amount', width:60},
                {name:'gross_margin',index:'gross_margin', width:60},
                {name:'top_sets1',index:'top_sets1', width:80},
                {name:'top_sets2',index:'top_sets2', width:80},
                {name:'top_sets3',index:'top_sets3', width:80},
                {name:'top_sets4',index:'top_sets4', width:80},
                {name:'top_sets5',index:'top_sets5', width:80},
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
            sortname: 'hits',
            viewrecords: true,
            sortorder: "desc"
            //caption: "Toolbar Searching"
        });
        jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
        jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
    });
</script>
<div id="do_content">
    <div class="box" style="overflow:hidden;">
        <h3>月度销售看板 (by country)</h3>
        <table id="toolbar"></table>
        <div id="ptoolbar"></div>
    </div>
</div>