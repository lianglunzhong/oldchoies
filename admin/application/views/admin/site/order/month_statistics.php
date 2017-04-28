<script type="text/javascript">
    $(function(){
        jQuery("#toolbar").jqGrid({
            url:'/admin/site/orderproduct/month_data',
            datatype: "json",
            height: 480,
            width: 1250,
            colNames:['Id','Country','month','订单数','红人+活动单数','纯销售订单数','销售件数(纯销售)','客件数(纯销售)','客单价USD(纯销售)','毛利润率(纯销售)','热销分类1','热销分类2','热销分类3','热销分类4','热销分类5'],
            colModel:[
                {name:'id',index:'id', width:30},
                {name:'country',index:'country', width:100,
                    "searchoptions":{"value":":All"},
                    "stype":"select",
                    "summaryTpl":"{0}"
                },
                {name:'month',index:'month', width:60,
                    "searchoptions":{"value":":All"},
                    "stype":"select",
                    "summaryTpl":"{0}"
                },
                {name:'order_qty',index:'order_qty', width:60},
                {name:'celebrity_orders',index:'celebrity_orders', width:60},
                {name:'sale_orders',index:'sale_orders', width:60},
                {name:'product_qty',index:'product_qty', width:60},
                {name:'average_qty',index:'average_qty', width:60},
                {name:'order_amount',index:'order_amount', width:60},
                {name:'gross_margin',index:'gross_margin', width:60},
                {name:'top_sets1',index:'top_sets1', width:60},
                {name:'top_sets2',index:'top_sets2', width:60},
                {name:'top_sets3',index:'top_sets3', width:60},
                {name:'top_sets4',index:'top_sets4', width:60},
                {name:'top_sets5',index:'top_sets5', width:60},
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
            //caption: "Toolbar Searching"
        });
        jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
        jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
        country_search_options();
        month_search_options();
    });
    
    function countryFormatter(cellvalue,options,rowObject) {
        var userdata = jQuery("#toolbar").getGridParam('userData');
        return userdata['country'][cellvalue];
    }

    function country_search_options(){
        var $gs_country = $('#gs_country');
        $gs_country.append('<option value="">无</option>');
        $gs_country.append('<option value="total">Total</option>');
        <?php
        $countries = Site::instance()->countries();
        if (count($countries))
        {
            foreach ($countries as $country)
            {
                $name = str_replace("'", " ", $country['name']);
                ?>
                $gs_country.append('<option value="<?php echo $country['isocode']; ?>"><?php echo $name; ?></option>');
                <?php
            }
        }
        ?>
    }

    function month_search_options()
    {
        var $gs_month = $('#gs_month');
        $gs_month.append('<option value="">无</option>');
        <?php
        $months = DB::select(DB::expr('DISTINCT month'))->from('order_month_statistics')->execute('slave');
        foreach($months as $m)
        {
            ?>
            $gs_month.append('<option value="<?php echo $m['month']; ?>"><?php echo $m['month']; ?></option>');
            <?php
        }
        ?>
    }

    function month_search_options1()
    {
        var $gs_month = $('#gs_month');
        $gs_month.append('<option value="">无</option>');
        <?php
        $year_from = 2014;
        $year_to = date('Y');
        $month_now = date('n');
        for($j = $year_from;$j <= $year_to;$j ++)
        {
            for ($i = 1;$i <= 12;$i ++)
            {
                if($j == $year_to AND $i > $month_now)
                    continue;
                if($i < 10)
                    $i = '0' . $i;
                $month = $year_from . $i;
                ?>
                $gs_month.append('<option value="<?php echo $month; ?>"><?php echo $month; ?></option>');
                <?php
            }
        }
        ?>
    }
</script>
<div id="do_content">
    <div class="box" style="overflow:hidden;">
        <h3>月度销售看板 (by country)</h3>
        <table id="toolbar"></table>
        <div id="ptoolbar"></div>
    </div>
</div>