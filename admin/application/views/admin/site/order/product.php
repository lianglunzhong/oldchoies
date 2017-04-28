<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/orderproduct/data<?php echo isset($_GET['history']) ? '?history=' . $_GET['history'] : ''; ?>',
                        datatype: "json",
                        height: 450,
                        width: 1000,
                        colNames:['Product Id','Sku','分类','Price','Admin','Picker','Source','Created','clicks','Add Cart Times','销售量','采购类型','红人购买次数','红人购ID列表'],
                        colModel:[
                                {name:'id',index:'id', width:60},
                                {name:'sku',index:'sku', width:80},
                                {name:'set',index:'set', width:80},
                                {name:'price',index:'price', width:60},
                                {name:'admin',index:'admin', width:60},
                                {name:'picker',index:'picker', width:60},
                                {name:'source',index:'source', width:60},
                                {name:'created',index:'created', width:80},
                                {name:'clicks',index:'clicks', width:60},
                                {name:'add_times',index:'add_times', width:60},
                                {name:'sales',index:'hits', search:false, width:100},
                                {name:'purchase',index:'purchase', search:false, width:100},
                                {name:'celebrity_num',index:'celebrity_num', search:false, width:100},
                                {name:'celebrity',index:'celebrity', search:false, width:300},
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
                
                $("#history").live('change',function(){
                        var history = $(this).val();
                        if(history)
                        {
                                location.href = '/<?php echo Request::instance()->uri(); ?>?history=' + history;
                        }
                        else
                        {
                                location.href = '/<?php echo Request::instance()->uri(); ?>';
                        }
                })
        });
</script>
<div id="do_right">

        <div class="box" style="overflow:hidden;">
                <h3>
                        <?php
                        if(isset($_GET['history']))
                        {
                                $history = $_GET['history'];
                                $daterange = explode('-', $history);
                                $date = date('Y年m月d日', $daterange[0]) . ' ~ ' . $date = date('Y年m月d日', $daterange[1]);
                        }
                        else
                        {
                                $date = '';
                        }
                        ?>
                        <strong style="color:red;"><?php echo $date; ?></strong>订单产品销量统计:
                </h3>
                <div>
                        历史统计:
                        <select name="history" id="history">
                                <option value="1338480000-<?php echo time();?>">Total</option>
                        <?php
                        $first_order = DB::query(Database::SELECT,'SELECT created FROM orders WHERE payment_status IN("success","verify_pass") ORDER BY created limit 1')->execute()->current();
                        $first_month = strtotime(date('Y-m-01', $first_order['created']));
                        $time = strtotime(date('Y-m-01', time()));
                        while($time >= $first_month)
                        {
                                $timestr = date('Y-m-d', $time);
                                $time1 = strtotime("$timestr + 1 month - 1 day");
                                $daterange = $time . '-' . $time1;
                        ?>
                                <option value="<?php echo $daterange; ?>" <?php if(isset($_GET['history']) && $_GET['history'] == $daterange) echo 'selected'; ?>><?php echo date('Y年m月份', $time); ?></option>
                        <?php
                                $time = strtotime("$timestr - 1 month");
                        }
                        ?>
                        </select>
                </div>
                <div>
                        <form style="margin:20px;" id="frm-customer-export" method="post" action="#">
                                <label for="export-start">From: </label>
                                <input type="text" name="start" id="export-start" class="ui-widget-content ui-corner-all" />
                                <label for="export-end">To: </label>
                                <input type="text" name="end" id="export-end" class="ui-widget-content ui-corner-all" />
                                <input type="submit" value="submit" id="date_from" class="ui-button" style="padding:0 .5em" />
                                <input type="submit" value="export" id="export" />
                                <input type="submit" value="exportallproduct" id="exportall" />
                        </form>
                        <script type="text/javascript">
                                $('#export-start, #export-end').datepicker({
                                        'dateFormat': 'yy-mm-dd'
                                });
                                $(function(){
                                        $("#export").live('click', function(){
                                                $("#frm-customer-export").attr('action', '/admin/site/orderproduct/export');
                                                $("#frm-customer-export").submit();
                                        })
                                        $("#exportall").live('click', function(){
                                                $("#frm-customer-export").attr('action', '/admin/site/orderproduct/exportall');
                                                $("#frm-customer-export").submit();
                                        })
                                })
                        </script>
                </div>
                <table id="toolbar"></table>
                <div id="ptoolbar"></div>

        </div>
</div>