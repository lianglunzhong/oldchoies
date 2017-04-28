<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<?php
$result = DB::select(DB::expr('DISTINCT catalog'))->from('spromotions')->execute();
$catalogs = array();
foreach ($result as $val)
{
    $catalogs[$val['catalog']] = $val['catalog'];
}
$types = Kohana::config('promotion.types');
$_types = Kohana::config('promotion._types');
$get_type = isset($_GET['type']) ? $_GET['type'] : 100000;
?>
<script type="text/javascript">
    $(function(){
        jQuery("#toolbar").jqGrid({
            url:'/admin/site/promotion/special_data<?php echo $get_type <= 0 ? "?type=" . $get_type : ""; ?>',
            datatype: "json",
            height: 480,
            width: 1100,
            colNames:['Select','ID','SKU','Orig Price','Orig Profit','Sale Price','Sale Profit','Catalog','Type','Created','Expired','Admin','Position','Action'],
            colModel:[
                {name:'selectall',align:'center',search:false,formatter:actionSelect,index:false,width:20},
                {name:'id',index:'id', width:40},
                {name:'sku',index:'sku', width:40},
                {name:'orig_price',index:'orig_price',width:40},
                {name:'orig_profit',index:'orig_profit',width:40},
                {name:'price',index:'price',width:40},
                {name:'sale_profit',index:'sale_profit',width:40},
                {name:'catalog',index:'catalog',width:80,stype:'select',searchoptions:{value:<?php echo "'" . str_replace(array('"', '{', '}', ','), array('', '', '', ';'), json_encode(array('' => '') + $catalogs)) . "'"; ?>}},
                {name:'type',index:'type',width:80,stype:'select',searchoptions:{value:<?php echo "'" . str_replace(array('"', '{', '}', ','), array('', '', '', ';'), json_encode(array('' => '') + $types)) . "'"; ?>}},
                {name:'created',index:'created', width:80},
                {name:'expired',index:'expired', width:80},
                {name:'admin',index:'admin', width:50},
                {name:'position',index:'position', width:50},
                {width:100,search:false,formatter:actionFormatter}
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
            sortorder: "desc",
            gridComplete: function () {
                $("table:first").find("tr:last").find("th:first").find("div").html("All<input id='selectall' type='checkbox'>");
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

        $('.delete').live('click',function(){
            if(!confirm('Delete this review?\nIt can not be undone!')){
                return false;
            }
        });
                
        $("#flash_add").live('submit', function(){
            $.post(
            '/admin/site/promotion/special_add',
            {
                id: $("#special_id").val(),
                sku: $("#sku").val(),
                price: $("#price").val(),
                catalog: $("#catalog").val(),
                type: $("#type").val(),
                expired: $("#expired").val()
            },
            function (data) {
                if (data == 'success')
                {
                    window.alert('Add Promotion Product Successfully!');
                    $("#special_id").val('');
                    $("#sku").val('');
                    $("#price").val('');
                    $("#catalog").val('');
                    $("#type").val('');
                    $("#expired").val('');
                    $('#toolbar').trigger('reloadGrid');
                }
                else
                    window.alert(data);
            },
            'json'
            );
            return false;
        })

        $("#flash_add1").live('submit', function(){
            $.post(
            '/admin/site/promotion/special_add',
            {
                id: $("#special_id").val(),
                sku: $("#sku").val(),
                price: $("#price").val(),
                catalog: $("#catalog").val(),
                type: $("#type").val(),
                created: $("#created").val(),
                expired: $("#expired1").val()
            },
            function (data) {
                if (data == 'success')
                {
                    window.alert('Add Promotion Product Successfully!');
                    $("#special_id").val('');
                    $("#sku").val('');
                    $("#price").val('');
                    $("#catalog").val('');
                    $("#type").val('');
                    $("#created").val('');
                    $("#expired1").val('');
                    $('#toolbar').trigger('reloadGrid');
                }
                else
                    window.alert(data);
            },
            'json'
            );
            return false;
        })
        
        $(".edit").live('click', function(){
            <?php
            $types1 = array();
            foreach($types as $key => $type)
            {
                $types1[$type] = $key;
            }
            ?>
            var types = <?php echo json_encode($types1); ?>;
            $value = $(this).parent().parent().find('td');
            $("#special_id").val($value.eq(1).text());
            $("#sku").val($value.eq(2).text());
            $("#price").val($value.eq(5).text());
            $("#catalog").val($value.eq(7).text());
            var type = $value.eq(8).text();
            $("#type").val(types[type]);
            $("#expired").val($value.eq(10).text());
            $("#created").val($value.eq(9).text());
            $("#expired1").val($value.eq(10).text());
            return false;
        })
        
        $("#deleteSubmit").click(function(){
            var form = $('#orderForm');
            form.attr('action', '/admin/site/promotion/special_bulk_delete');
            form.submit();
        })
    });
    function actionFormatter(cellvalue,options,rowObject) {
        var html = '<a class="edit" href="#">Edit</a> | <a href="javascript:do_delete(' + rowObject[1] + ');">Delete</a>';
        return html;
    }

    function do_delete(id)
    {
        if (!window.confirm("delete?"))
            return false;

        $.ajax({
            url: '/admin/site/promotion/special_delete/'+id, 
            type: 'GET', 
            success: function(data)
            {
                if (data == 'success')
                {
                    $('#toolbar').trigger('reloadGrid');
                }
                else
                {
                    window.alert(data);
                }
            }
        });

        //return false;
    }
    function actionSelect(cellvalue,options,rowObject){
        return '<input type="checkbox" name="ids[]" value ="'+rowObject[1]+'" >';
    }
</script>
<?php echo View::factory('admin/site/promotion_left')->render(); ?>
<div id="do_right">

    <div class="box" style="overflow:hidden;">
        <h3><?php if($get_type == -1) echo '秒杀'; elseif($get_type == 0) echo 'VIP'; else echo '特价'; ?>产品促销 <span style="color:red;">(CSV模板: SKU,Price,Catalog,Expired Time,Type)</span>
            <div style="margin:20px;">
                <form enctype="multipart/form-data" method="post" action="/admin/site/promotion/special_bulk" target="_blank">
                    <input id="file" type="file" name="file">
                    <input type="submit" value="Bulk Upload" name="submit">
                    <span style="margin-left: 50px">
                        <a href="/admin/site/promotion/export_special_expired">折扣过期产品导出</a>
                    </span>
                </form>
            </div>
        </h3>
        <fieldset>
            <legend style="font-weight:bold">Add Special Promotion</legend>
            <div>
                <form action="/admin/site/promotion/special_add" method="post" class="need_validation" id="<?php if($get_type == -1) echo 'flash_add1'; else echo 'flash_add'; ?>">
                    <input type="hidden" name="id" value="" id="special_id" >
                    <label for="sku">Sku: </label>
                    <input type="text" class="text small required" id="sku" name="sku" style="width:100px;">
                    &nbsp;&nbsp;<label for="price">Price: </label>
                    <input type="text" class="text small required" id="price" name="price" style="width:60px;">
                    &nbsp;&nbsp;<label for="catalog">Catalog: </label>
                    <input type="text" class="text small" id="catalog" name="catalog" style="width:100px;">
                    <?php
                    if($get_type == -1)
                    {
                        ?>
                        &nbsp;&nbsp;<label for="expired">Start Time: </label>
                        <input type="text" class="text small required" id="created" name="created" style="width:120px;">
                        &nbsp;&nbsp;<label for="expired">Expired Time: </label>
                        <input type="text" class="text small required" id="expired1" name="expired" style="width:120px;">
                        <?php
                    }
                    else
                    {
                        ?>
                        &nbsp;&nbsp;<label for="expired">Expired Time: </label>
                        <input type="text" class="text small required" id="expired"  name="expired">
                        <?php
                    }
                    ?>
                    &nbsp;&nbsp;<label for="type">Type: </label>
                    <select id="type" name="type" class="required">
                        <option></option>
                    <?php
                    if($get_type <= 0)
                    {
                        ?>
                        <option value="<?php echo $get_type; ?>"><?php echo $types[$get_type]; ?>(<?php echo $_types[$get_type]; ?>)</option>
                        <?php
                    }
                    else
                    {
                        foreach($types as $key => $type): 
                            ?>
                            <option value="<?php echo $key; ?>"><?php echo $type; ?></option>
                        <?php
                        endforeach;
                    }
                    ?>
                    </select>
                    <input type="submit" style="padding:0 .5em" class="ui-button" value="Add">
                </form>
                <script>
                    $('#expired').datepicker({
                        'dateFormat': 'yy-mm-dd'
                    });
                </script>
            </div>
        </fieldset>
        <div>
            <h4>Types:</h4>
            <?php
            if($get_type <= 0)
            {
                echo $types[$get_type] . ' : <span style="color:red;">' . $_types[$get_type] . '</span>';
            }
            else
            {
                foreach($_types as $key => $val)
                {
                    echo $types[$key] . ' : <span style="color:red;">' . $val . '</span> , ';
                }
            }
            ?>
        </div>
        <form action="" id="orderForm" method="post">
            <table id="toolbar"></table>
            <input type="button" value="批量删除" id="deleteSubmit">
        </form>
        <div id="ptoolbar"></div>
<!--        <fieldset>
            <div style="width:400px;float:left;">
                <h4>产品批量置顶</h4>
                <form action="/admin/site/promotion/special_top" method="post">
                    <div><span style="color:#FF0000"></span>一行一个SKU</div>
                    <div><span>请输入产品SKU:</span><br>
                        <textarea name="SKUARR" cols="40" rows="20"></textarea>       
                    </div>
                    <input type="submit" value="Submit">   
                </form>
            </div>
        </fieldset>-->
    </div>
</div>

