<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript" src="/media/js/ZeroClipboard.js"></script>
<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<?php echo View::factory('admin/site/celebrity_left')->render(); ?>
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/celebrity/contacted_data',
                        datatype: "json",
                        height: 450,
                        width: 1250,
                        colNames:['Select','ID','Created','C Id','Email','Sites','Admin'],
                        colModel:[
                                {name:'selectall',align:'center',search:false,formatter:actionSelect,index:false,width:40},
                                {name:'id',index:'id', width:40},
                                {name:'created',index:'created', width:100},
                                {name:'celebrity_id',index:'celebrity_id', width:40},
                                {name:'email',index:'email', width:200},
                                {name:'sites',index:'sites', width:250},
                                {name:'admin',index:'admin', width:60},
//                                {width:100,align:'center',search:false,formatter:actionFormatter}
                        ],
                        rowNum:20,
                        //  rowTotal: 12,
                        rowList : [20,50,100,1000],
                        // loadonce:true,
                        mtype: "POST",
                        // rownumbers: true,
                        // rownumWidth: 40,
                        gridview: true,
                        pager: '#ptoolbar',
                        sortname: 'id',
                        viewrecords: true,
                        sortorder: "desc",
                        //            caption: "Toolbar Searching"
                        gridComplete: function () {
                                $("table:first").find("tr:last").find("th:first").find("div").html("All<input id='selectall' type='checkbox'>");
                                $("#selectall").click(function(){
                                        $("#selectall").attr('checked') == true?$("input[name='ids[]']").each(function(){$(this).attr("checked", true)}):$("input[name='ids[]']").each(function(){$(this).attr("checked", false)});
                                });
                        }
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
        function actionFormatter(cellvalue,options,rowObject) {
                return '';
        }
        
        function actionSelect(cellvalue,options,rowObject){
                return '<input type="checkbox" name="ids[]" value ="'+rowObject[1]+'" >';
        }
        
        function exportCsv()
        {
                var mya = new Array();
                mya = $("#toolbar").getDataIDs();     //得到所有展示出来的 ID
                var labels = jQuery("#toolbar").getGridParam('colNames');   //得到所有的 colNames label
                var html = " ";

                for (var i in labels) 
                {
                        if( i == 6 || i == 0 ) continue;  	//+++++0开始++++0对应select
                        html += labels[i] + "\t ";    		//输出头部信息
                }
                html = html + "\t\n ";
                for( i=0; i<mya.length; i++ )
                {
                        for( j=0; j<labels.length-1; j++ )
                        {
                                if( j == 12 || j == 0 ) continue;
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
<div class="box" style="overflow:hidden;">
        <h3>Celebrity Contacted List</h3>
        
        <form action="/admin/site/celebrity/exprot_all" method="post" style="text-align:right">
     		<label>创建时间: </label><input type="text" name="start" class="ui-widget-content ui-corner-all time-to" />
	    	<label>To: </label><input type="text" name="end" class="ui-widget-content ui-corner-all time-to" />
	    	<input type="submit" value="export .xls" class="ui-button" style="padding:0 .5em" />
    	</form>
    
        <br/>
        <fieldset>
                <legend style="font-weight:bold">Import Celebrity Contacted</legend>
                <div>
                        <form enctype="multipart/form-data" method="post" action="/admin/site/celebrity/contacted_import">
                                <input id="file" type="file" name="file">
                                <input type="submit" value="Bulk Upload" name="submit">
                        </form>
                </div>
        </fieldset>
        <script type="text/javascript">
                $('#start, #end, .time-to').datepicker({
                        'dateFormat': 'yy-mm-dd'
                });
        </script>
        <form action="/admin/site/celebrity/contacted_delete" id="orderForm" method="post">
                <table id="toolbar"></table>
                <input type="submit" value="批量删除" id="deleteSubmit">
        </form>
        <div id="ptoolbar"></div> 
<form id="form-2"><input type="hidden" name="csvBuffer" id="csvBuffer" /></form>
</div>