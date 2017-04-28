<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript" src="/media/js/ZeroClipboard.js"></script>
<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<?php echo View::factory('admin/site/orderprocurement_left')->render(); ?>
<script type="text/javascript">
    $(function(){
        jQuery("#toolbar").jqGrid({
            url:'/admin/site/orderprocurement/monthly_inventory_data',
            datatype: "json",
            height: 600,
            width: 1000,
            colNames:['ID','Sku','Attributes','Month','初期库存','初期成本','入库数量','入库成本','出库数量','出库成本','期末库存','期末成本'],
            colModel:[
                {name:'id',index:'id', width:40},
                {name:'sku',index:'sku',width:80},
                {name:'attributes', index:'attributes',width:100}, 
                {name:'month',index:'month', width:60,
                    "searchoptions":{"value":":All"},
                    "stype":"select",
                    "summaryTpl":"{0}"
                },
                {name:'first', index:'first',width:100,search:false},
                {name:'first_cost', index:'first_cost',width:80,search:false},
                {name:'instock', index:'instock',width:100,search:false},
                {name:'instock_cost', index:'instock_cost',width:80,search:false},
                {name:'outstock',index:'outstock',width:100,search:false},
                {name:'outstock_cost',index:'outstock_cost',width:80,search:false},
                {name:'end', index:'end',width:100,search:false}, 
                {name:'end_cost', index:'end_cost',width:120,search:false}, 
            ],
            rowNum:20,
            rowList : [20,50,100],
            mtype: "POST",
            gridview: true,
            pager: '#ptoolbar',
            sortname: 'id',
            viewrecords: true,
            sortorder: "desc",
        });

        jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
        jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true}); 
        month_search_options();

		
    });
    function month_search_options()
    {
        var $gs_month = $('#gs_month');
        $gs_month.append('<option value="">无</option>');
        <?php
        $months = DB::select(DB::expr('DISTINCT month'))->from('checks_inventories')->execute('slave');
        foreach($months as $m)
        {
            ?>
            $gs_month.append('<option value="<?php echo $m['month']; ?>"><?php echo $m['month']; ?></option>');
            <?php
        }
        ?>
    }
</script>
<div id="do_content">
    <div class="box" style="overflow:hidden;">
        <h3>月度库存
            <form action="/admin/site/orderprocurement/inventory_do" target="_blank" style="float:right;">
                <label>Month: </label>
                <select name="m">
                    <option value=""></option>
                <?php
                $last_month_data = $months[count($months) - 1]['month'];
                $this_month = date('Ym');
                $month = date('Ym', strtotime($last_month_data . '01 + 1 month'));
                while($month < $this_month)
                {
                    ?>
                    <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                    <?php
                    $month = date('Ym', strtotime($month . '01 + 1 month'));
                }
                ?>
                </select>
                <input type="submit" value="跑月度库存数据">
            </form>
        </h3>
        <table id="toolbar"></table>
        <div id="ptoolbar"></div>
        <div style="float:left;">
            <form action="/admin/site/orderprocurement/monthly_inventory_export" method="post" target="_blank" class="need_validation">
                <label for="export-end">Month: </label>
                <select name="month">
                    <option></option>
                    <?php
                    $month = '201401';
                    while($month <= $last_month_data)
                    {
                        ?>
                        <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                        <?php
                        $month = date('Ym', strtotime($month . '01 + 1 month'));
                    }
                    ?>
                </select>
                <input type="submit" value="导出上面表格数据">
                <script type="text/javascript">
                    $('#export-from, #export-to').datepicker({
                        'dateFormat': 'yy-mm-dd'
                    });
                </script>
            </form>
        </div>
        <br><br>
        <div style="margin:20px;clear: both;">
            <h4>时点库存明细</h4>
            <div style="float:left;">
                <form action="/admin/site/orderprocurement/inventory_search" method="get" target="_blank" class="need_validation">
                    <label for="export-start">From: </label>
                    <input type="text" name="from" id="export-from" class="ui-widget-content ui-corner-all required">
                    <label for="export-end">To: </label>
                    <input type="text" name="to" id="export-to" class="ui-widget-content ui-corner-all">
                    <input type="submit" value="submit">
                    <script type="text/javascript">
                        $('#export-from, #export-to').datepicker({
                            'dateFormat': 'yy-mm-dd'
                        });
                    </script>
                </form>
            </div>
            <div style="float:right;">
                <a target="_blank" href="/admin/site/orderprocurement/inventory_check_error">库存异常统计表</a>
            </div>
        </div>
        <br><br>
        <div style="margin:20px;clear: both;">
            <h4>按SKU更新月度库存</h4>
            <div style="float:left;">
                <form action="/admin/site/orderprocurement/inventory_do" method="post" target="_blank" class="need_validation">
                    <label for="export-start">Month From: </label>
                    <select name="m" class="required">
                    <?php
                    foreach($months as $m)
                    {
                        ?>
                        <option value="<?php echo $m['month']; ?>"><?php echo $m['month']; ?></option>
                        <?php
                    }
                    ?>
                    </select>&nbsp;&nbsp;
                    <label for="export-end">SKU: </label>
                    <input type="text" name="sku" id="sku" class="text small required">&nbsp;&nbsp;
                    <label for="export-end">Attributes: </label>
                    <input type="text" name="attributes" id="attributes" class="text small required">
                    <input type="submit" value="submit">
                </form>
            </div>
        </div>
    </div>
</div>
