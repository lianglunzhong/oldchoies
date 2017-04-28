<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<?php
echo View::factory('admin/site/clicks_left')->render();
$status = array('new'=>'new','shipped'=>'shipped','cancel'=>'cancel','return'=>'return');
?>
<div class="box">
        <h3 style="margin: 0pt 0pt 15px;padding: 0pt 0pt 10px;color: #222;font-size: 16px;border-bottom: 1px dotted #e8e8e8;">
                Brand Select
        </h3>
        <div style="margin:20px;">
        <?php foreach($brands as $brand): ?>
                <span style="color:green;margin-right:20px;">
                        <a href="/admin/site/clicks/brand_account/<?php echo $brand['id']; ?>"><?php echo $brand['name']; ?></a>
                </span>
        <?php endforeach; ?>
        </div>
</div>
<?php if(isset($sets)): ?>
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/clicks/brand_account_data<?php echo '/' . $sets['id']; ?>',
                        datatype: "json",
                        height: 450,
                        width: 1250,
                        colNames:['ID','Ordernum','SKU','Description','Qty','Attributes','Admin','Amount','Sale Price','Orig Price','Cost','Time','Status','重量','运费','产品成本','美金总成本','积分扣除','折扣扣除','利润','分成','合作方金额'],
                        colModel:[
                                {name:'id',index:'id',align:'center', width:10},
                                {name:'ordernum',index:'ordernum',align:'center', width:40},
                                {name:'sku',index:'sku',align:'center', width:50},
                                {name:'name',index:'name',align:'center', width:40},
                                {name:'quantity',index:'quantity',align:'center', width:20},
                                {name:'attributes',index:'attributes',align:'center', width:40},
                                {name:'admin',index:'admin',align:'center', width:30, search:false},
                                {name:'amount',index:'amount',align:'center', width:25},
                                {name:'price',index:'price',align:'center', width:25},
                                {name:'orig_price',index:'orig_price',align:'center', width:25},
                                {name:'cost',index:'cost',align:'center', width:25},
                                {name:'verify_date',index:'verify_date',align:'center', width:40},
                                {name:'status',index:'status',width:40,stype:'select',searchoptions:{value:<?php echo "'".str_replace(array( '"', '{', '}', ','), array( '', '', '', ';'), json_encode(array(''=>'')+$status))."'"; ?>}},
                                {name:'weight',index:'weight',align:'center', width:30},
                                {name:'shipping',index:'shipping',align:'center', width:30, search:false},
                                {name:'p_cost',index:'p_cost',align:'center', width:30, search:false},
                                {name:'total_cost',index:'total_cost',align:'center', width:30},
                                {name:'points',index:'points',align:'center', width:30, search:false},
                                {name:'coupons',index:'coupons',align:'center', width:30, search:false},
                                {name:'profit',index:'profit',align:'center', width:30, search:false},
                                {name:'commission',index:'commission',align:'center', width:30, search:false},
                                {name:'partners',index:'partners',align:'center', width:40, search:false},
                        ],
                        rowNum:20,
                        //  rowTotal: 12,
                        rowList : [20,50,100,500],
                        // loadonce:true,
                        mtype: "POST",
                        // rownumbers: true,
                        // rownumWidth: 40,
                        gridview: true,
                        pager: '#ptoolbar',
                        sortname: 'id',
                        viewrecords: true,
                        sortorder: "desc"
                        //            caption: "Toolbar Searching"
                });

                jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
                jQuery("#toolbar").jqGrid('navButtonAdd','#ptoolbar',{position:'last',title:'导出为Excel文件',caption:'ExportData',onClickButton:exportCsv});
                jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
                
                $('#gs_verify_date').daterangepicker({
                        dateFormat:'yy-mm-dd',
                        rangeSplitter:' to ',
                        onRangeComplete:(function(){
                                var last_date = '',$input = $('#gs_verify_date');
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
                return '';
        }
        function exportCsv()
        {
                var mya = new Array();
                mya = $("#toolbar").getDataIDs();     //得到所有展示出来的 ID
                var labels = jQuery("#toolbar").getGridParam('colNames');   //得到所有的 colNames label
                var html = " ";
                for (var i in labels) 
                {
                        if( i == 0 ) continue;       	//+++++0开始++++0对应select
                        html += labels[i] + "\t ";    		//输出头部信息
                }
                html = html + "\t\n ";
                for( i=0; i<mya.length; i++ )
                {
                        for( j=0; j<labels.length; j++ )
                        {
                                if( j == 0 ) continue;
                                html += $("#toolbar").getCell(mya[i],j) + "\t ";   //得到一行中每个单元格的值
                        }
                        html=html+"\t\n "; //一行结束
                }
                html=html+"\t\n ";
                html = html.replace(/<.*?>/g,"");
                var time = $("#gs_verify_date").val();
                document.getElementById('csvBuffer').value=html;
                document.getElementById('filename').value='Brand-<?php echo $sets['name']; ?>-account' + time;
                document.getElementById('form-2').method='POST';
                document.getElementById('form-2').action='/admin/site/clicks/exprotcsv';
                document.getElementById('form-2').target='_blank';
                document.getElementById('form-2').submit();
        }
</script>
<div>

        <div class="box" id="do_content" style="overflow:hidden;">
                <h3>
                        Brand "<?php echo $sets['name']; ?>" 分账系统
                </h3>
                <table id="toolbar"></table>
                <div id="ptoolbar"></div>
                <form id="form-2">
                        <input type="hidden" id="filename" name="filename" value="" />
                        <input type="hidden" name="csvBuffer" id="csvBuffer" />
                </form>
        </div>
</div>
<?php endif; ?>