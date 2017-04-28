<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<?php echo View::factory('admin/site/orderprocurement_left')->render(); ?>
<?php 
$status = array('0'=>'库存', '1'=>'已出库');
?>
<script type="text/javascript">
    $(function(){
        jQuery("#toolbar").jqGrid({
            url:'/admin/site/orderprocurement/instock_data?orderno=inventory',
            datatype: "json",
            height: 400,
            width: 600,
            colNames:['Select','ID','Created','Ordernum','Sku','Quantity','Attributes','Cost','是否出库','出库ID','Action'],
            colModel:[
                {name:'selectall',align:'center',search:false,formatter:actionSelect,index:false,width:1},
                {name:'id',index:'id', width:30},
                {name:'created', index:'created',width:150},
                {name:'ordernum', index:'ordernum',width:50},
                {name:'sku',index:'sku',width:80},
                {name:'quantity', index:'quantity',width:50}, 
                {name:'attributes', index:'attributes',width:150},
                {name:'cost',index:'cost',width:40},
                {name:'status',index:'status',width:40,formatter:actionStatus,stype:'select',searchoptions:{value:<?php echo "'".str_replace(array( '"', '{', '}', ','), array( '', '', '', ';'), json_encode(array(''=>'')+$status))."'"; ?>}},
                {name:'outstock_id',index:'outstock_id',width:40},
                {width:100,search:false,formatter:actionFormatter}
            ],
            rowNum:20,
            rowList : [20,30,50],
            mtype: "POST",
            gridview: true,
            pager: '#ptoolbar',
            sortname: 'id',
            viewrecords: true,
            sortorder: "desc",
            gridComplete: function () {
                $("table:first").find("tr:last").find("th:first").find("div").html("<input id='selectall' type='checkbox'>");
                $("#selectall").click(function(){
                    $("#selectall").attr('checked') == true?$("input[name='ids[]']").each(function(){$(this).attr("checked", true)}):$("input[name='ids[]']").each(function(){$(this).attr("checked", false)});
                });
            }
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
        
        jQuery("#toolbar1").jqGrid({
            url:'/admin/site/orderprocurement/outstock_data?orderno=inventory',
            datatype: "json",
            height: 400,
            width: 600,
            colNames:['ID','Created','Ordernum','Sku','Quantity','Attributes','Cost','入库ID','Action'],
            colModel:[
                {name:'id',index:'id', width:30},
                {name:'created1', index:'created',width:150},
                {name:'ordernum', index:'ordernum',width:90},
                {name:'sku',index:'sku',width:80},
                {name:'quantity', index:'quantity',width:50}, 
                {name:'attributes', index:'attributes',width:150}, 
                {name:'cost', index:'cost',width:50}, 
                {name:'instock_id', index:'instock_id',width:50}, 
                {width:100,search:false,formatter:actionFormatter1}
            ],
            rowNum:20,
            rowList : [20,30,50],
            mtype: "POST",
            gridview: true,
            postData: {id_for_search:true},
            pager: '#ptoolbar1',
            sortname: 'id',
            viewrecords: true,
            sortorder: "desc"
        });
        jQuery("#toolbar1").jqGrid('navGrid','#ptoolbar1',{del:false,add:false,edit:false,search:false});
        jQuery("#toolbar1").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true}); 
        
        $('#gs_created1').daterangepicker({
            dateFormat:'yy-mm-dd',
            rangeSplitter:' to ',
            onRangeComplete:(function(){
                var last_date = '',$input = $('#gs_created1');
                return function(){
                    if(last_date != $input.val()) {
                        $('#toolbar1')[0].triggerToolbar();
                        last_date = $input.val();
                    }
                };
            })()
        });
        $('.delete').live('click',function(){
            if(!confirm('Delete this product?\nIt can not be undone!')){
                return false;
            }
        });
        
        $('.edit').live('click',function(){
            $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
            $('#celebrity_view').appendTo('body').fadeIn(320);
            var href = $(this).attr('href');
            $('#celebrity_iframe').attr('src', href)
            $('#celebrity_view').show();
            return false;
        })
        
        $('.edit1').live('click',function(){
            $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
            $('#celebrity_view').appendTo('body').fadeIn(320);
            var href = $(this).attr('href');
            $('#celebrity_iframe').attr('src', href)
            $('#celebrity_view').show();
            return false;
        })
        
        $("#celebrity_view .closebtn,#wingray").live("click",function(){
            $("#wingray").remove();
            $('#celebrity_view').fadeOut(160).appendTo('#tab2');
            return false;
        })

        $("#out_stock").click(function(){
            var form = $('#outStockForm');
            form.attr('action', '/admin/site/orderprocurement/do_out_stock');
            form.submit();
        })
    });
    function actionSelect(cellvalue,options,rowObject)
    {
        return '<input type="checkbox" name="ids[]" value ="'+rowObject[1]+'" >';
    }
    function actionFormatter(cellvalue,options,rowObject) {
        // return '<a class="edit" href="/admin/site/orderprocurement/instock_edit/' + rowObject[1] + '">Edit</a> <a href="/admin/site/orderprocurement/instock_delete/' + rowObject[1] + '" class="delete">Delete</a>';
        return '';
    }
    function actionFormatter1(cellvalue,options,rowObject) {
        // return '<a class="edit1" href="/admin/site/orderprocurement/outstock_edit/' + rowObject[0] + '">Edit</a> <a href="/admin/site/orderprocurement/outstock_delete/' + rowObject[0] + '" class="delete">Delete</a>';
        return '';
    }
    function actionStatus(cellvalue,options,rowObject){
        if( cellvalue == 1 ){
            return '已出库';
        }else{
            return '';       
        }
    }
</script>
<div id="do_content">
    <!--div style="margin:20px;">
        <h4>批量出库<div style="margin:5px;color:red">(文件格式:ordernum,sku,quantity,attributes)</div></h4>
        <div>
            <form enctype="multipart/form-data" method="post" action="/admin/site/orderprocurement/bulk_outstock">
                <input id="file" type="file" name="file">
                <input type="submit" value="Bulk Upload" name="submit">
            </form>
        </div>
    </div-->
    <div class="box fll" style="overflow:hidden;" >
        <h3>盘点入库产品&nbsp;&nbsp;&nbsp;&nbsp;<a href="/admin/site/orderprocurement/stock_export">导出库存表</a></h3>
        <form action="" id="outStockForm" method="post" target="_blank">
        <table id="toolbar"></table>
        <!-- <input type="button" value="批量出库" id="out_stock"> -->
        </form>
        <div id="ptoolbar"></div>
    </div>
    <div class="box flr" style="overflow:hidden;" >
        <h3>盘点出库产品</h3>
        <table id="toolbar1"></table>
        <div id="ptoolbar1"></div>
    </div>
    <br>
    <div style="margin:20px;">
        <h4>库存盘查导入&nbsp;&nbsp;&nbsp;<a href="/media/check_inventory.csv">模板下载</a>
            <div style="margin:5px;color:red">(文件格式:ordernum,sku,quantity,size,color)</div>
        </h4>
        <form enctype="multipart/form-data" method="post" action="/admin/site/orderprocurement/stock_check" target="_blank">
            <input id="file" type="file" name="file">
            <input type="submit" value="Bulk Upload" name="submit">
        </form>
    </div>
</div>
