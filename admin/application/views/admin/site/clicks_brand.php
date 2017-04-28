<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<?php echo View::factory('admin/site/clicks_left')->render(); ?>
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/clicks/brand_data<?php echo isset($_GET['history']) ? '?history=' . $_GET['history'] : ''; ?>',
                        datatype: "json",
                        height: 450,
                        width: 1250,
                        colNames:['Brand','Orders','Cele Orders','Amount','Sale QTY','Ave.price','Total SKU','Sale SKU','Cele-Piece','Cele','Clicks','Ave. Click'],
                        colModel:[
                                {name:'name',index:'name',align:'center', width:50},
                                {name:'o_quantity',index:'o_quantity',align:'center', width:40, search:false},
                                {name:'c_quantity',index:'c_quantity',align:'center', width:40, search:false},
                                {name:'amount',index:'amount',align:'center', width:40, search:false},
                                {name:'p_quantity',index:'p_quantity',align:'center', width:40, search:false},
                                {name:'a_price',index:'a_price',align:'center', width:40, search:false},
                                {name:'total_skus',index:'total_skus',align:'center', width:40, search:false},
                                {name:'c_sku',index:'c_sku',align:'center', width:40, search:false},
                                {name:'c_products',index:'c_products',align:'center', width:40, search:false},
                                {name:'count_celebrits',index:'count_celebrits',align:'center', width:40, search:false},
                                {name:'total_clicks',index:'total_clicks',align:'center', width:40, search:false},
                                {name:'a_clicks',index:'a_clicks',align:'center', width:60, search:false},
                        ],
                        rowNum:5,
                        //  rowTotal: 12,
                        rowList : [5,10,20],
                        // loadonce:true,
                        mtype: "POST",
                        // rownumbers: true,
                        // rownumWidth: 40,
                        gridview: true,
                        pager: '#ptoolbar',
                        sortname: 'name',
                        viewrecords: true,
                        sortorder: "desc"
                        //            caption: "Toolbar Searching"
                });

                jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
                jQuery("#toolbar").jqGrid('navButtonAdd','#ptoolbar',{position:'last',title:'导出为Excel文件',caption:'ExportData',onClickButton:exportCsv});
                jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
                
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
//                        if( i == 6 || i == 0 ) continue;  	//+++++0开始++++0对应select
                        html += labels[i] + "\t ";    		//输出头部信息
                }
                html = html + "\t\n ";
                for( i=0; i<mya.length; i++ )
                {
                        for( j=0; j<labels.length; j++ )
                        {
//                                if( j == 12 || j == 0 ) continue;
                                html += $("#toolbar").getCell(mya[i],j) + "\t ";   //得到一行中每个单元格的值
                        }
                        html=html+"\t\n "; //一行结束
                }
                html=html+"\t\n ";
                html = html.replace(/<.*?>/g,"");
                document.getElementById('csvBuffer').value=html;
                document.getElementById('form-2').method='POST';
                document.getElementById('form-2').action='exprotcsv';
                document.getElementById('form-2').target='_blank';
                document.getElementById('form-2').submit();
        }
</script>
<div>

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
                        Brands statistics</h3>
                <fieldset>
                        <legend style="font-weight:bold">Filter</legend>
                        <form style="margin:20px;" id="frm-customer-export" method="post" action="#">
                                <label for="export-start">From: </label>
                                <input type="text" name="start" id="export-start" class="ui-widget-content ui-corner-all" />
                                <label for="export-end">To: </label>
                                <input type="text" name="end" id="export-end" class="ui-widget-content ui-corner-all" />
                                <input type="submit" value="submit" id="date_from" class="ui-button" style="padding:0 .5em" />
                        </form>
                        <script type="text/javascript">
                                $('#export-start, #export-end').datepicker({
                                        'dateFormat': 'yy-mm-dd'
                                });
                        </script>
                </fieldset>
                <table id="toolbar"></table>
                <div id="ptoolbar"></div>
                <form id="form-2">
                        <input type="hidden" name="filename" value="Brands statistics <?php echo date('Y-m-d', $daterange[0]) . ' ~ ' . $date = date('Y-m-d', $daterange[1]); ?>" />
                        <input type="hidden" name="csvBuffer" id="csvBuffer" />
                </form>
        </div>
</div>