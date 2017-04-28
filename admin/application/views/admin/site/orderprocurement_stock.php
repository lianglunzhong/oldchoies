<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<?php echo View::factory('admin/site/orderprocurement_left')->render(); ?>
<script type="text/javascript">
    $(function(){
        jQuery("#toolbar").jqGrid({
            url:'/admin/site/orderprocurement/stock_data',
            datatype: "json",
            height: 400,
            width: 1000,
            colNames:['ID','Sku','Attributes','Quantity','Total Cost','SET'],
            colModel:[
                {name:'id',index:'id', width:40,search:false},
                {name:'sku',index:'sku',width:100},
                {name:'attributes', index:'attributes',width:150},
                {name:'quantity', index:'quantity',width:80,search:false},
                {name:'cost', index:'cost',width:80,search:false},
                {name:'set',index:'set_id', width:80,formatter:setFormatter,search:false
                },
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
        
    });
    function actionFormatter(cellvalue,options,rowObject) {
        return '<a href="/admin/site/orderprocurement/view/' + rowObject[0] + '">View</a>';
    }

    function setFormatter(cellvalue,options,rowObject) {
                var userdata = jQuery("#toolbar").getGridParam('userData');
                return userdata['sets'][cellvalue];
            }
</script>
<div id="do_content">
    <form id="frm_remote_login" method="post" action="" target="_blank">
        <input type="hidden" name="hashed" value="TRUE" />
        <input type="hidden" name="email" value="" />
        <input type="hidden" name="password" value="" />
    </form>
                    <div style="margin:20px;">
                        <a href="/admin/site/orderprocurement/up_setid"><h4>批量更新set</h4></a>
                </div>
    <div class="box" style="overflow:hidden;">
        <h3>库存表&nbsp;&nbsp;&nbsp;&nbsp;<a href="/admin/site/orderprocurement/stock_export">导出库存表</a></h3>
<!--        <fieldset style="text-align:right">
            <legend style="font-weight:bold">Export</legend>
            <form id="frm-customer-export" method="post" action="/admin/site/orderprocurement/stock_export" target="_blank">
                <input type="submit" value="Export" class="ui-button" style="padding:0 .5em" />
            </form>
        </fieldset>-->
        <script type="text/javascript">
            $('#export-start, #export-end').datepicker({
                'dateFormat': 'yy-mm-dd'
            });
        </script>   
        <table id="toolbar"></table>
        <div id="ptoolbar"></div>
        <!--hr>
        <div style="margin:20px;">
            <h4>库存初始化导入<div style="margin:5px;color:red">(文件格式与导出库存表一致)</div></h4>
            <form enctype="multipart/form-data" method="post" action="/admin/site/orderprocurement/stock_init" target="_blank">
                <input id="file" type="file" name="file">
                <input type="submit" value="Bulk Upload" name="submit">
            </form>
        </div-->
        <br>
        <div style="width:400px;float:left;">
            <h4>SKU库存数导出</h4>
            <form action="/admin/site/orderprocurement/sku_stock_export" method="post" target="_blank">
                <div><span style="color:#FF0000"></span>一行一个SKU</div>
                <div><span>请输入产品SKU:</span><br>
                    <textarea name="SKUARR" cols="40" rows="20"></textarea>       
                </div>
                <input type="submit" value="Submit">   
            </form>
        </div>
    </div>
</div>
