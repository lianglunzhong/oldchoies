<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/product/weight_history_data',
                        datatype: "json",
                        height: 400,
                        width: 1250,
                        colNames:['ID','Created','Sku','Old Weight','New Weight', 'Admin'],
                        colModel:[
                                {name:'id',index:'id', width:40},
                                {name:'created',index:'created',width:80},
                                {name:'sku', index:'sku',width:50},
                                {name:'old', index:'old',width:50},
                                {name:'new', index:'new',width:100},
                                {name:'admin',index:'admin',width:60},
                        ],
                        rowNum:20,
                        rowList : [20,50,100,300],
                        mtype: "POST",
                        gridview: true,
                        pager: '#ptoolbar',
                        sortname: 'id',
                        viewrecords: true,
                        sortorder: "desc"
		
                });

                jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
                jQuery("#toolbar").jqGrid('navButtonAdd','#ptoolbar',{position:'last',title:'导出为Excel文件',caption:'ExportData',onClickButton:exportCsv});
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
		
        });

        function actionSelect(cellvalue,options,rowObject){
                return '<input type="checkbox" name="orders[]" value ="'+rowObject[1]+'" >';
        }
        function actionFormatter(cellvalue,options,rowObject) {
                return '<a href="/admin/site/customer/edit/' + rowObject[1] + '">Edit</a>';
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
                var time = $("#gs_created").val();
                document.getElementById('csvBuffer').value=html;
                document.getElementById('filename').value='Product-weight-history' + time;
                document.getElementById('form-2').method='POST';
                document.getElementById('form-2').action='/admin/site/clicks/exprotcsv';
                document.getElementById('form-2').target='_blank';
                document.getElementById('form-2').submit();
        }
</script>
<div id="do_content">
        <div class="box" style="overflow:hidden;">
                <h3>Product Weight History</h3>
                <table id="toolbar"></table>
                <div id="ptoolbar"></div>
                <form id="form-2">
                        <input type="hidden" id="filename" name="filename" value="" />
                        <input type="hidden" name="csvBuffer" id="csvBuffer" />
                </form>
        </div>
</div>
