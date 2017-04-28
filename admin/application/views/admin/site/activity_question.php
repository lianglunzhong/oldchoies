<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/activity/question_data',
                        datatype: "json",
                        height: 400,
                        width: 1100,
                        colNames:['ID','Email','Created','Ip','Question1','Question2','Question3','Question4','Question5','Question6','Question7','Question8','Question9','Question10'],
                        colModel:[
                                {name:'id',index:'id', width:40},
                                {name:'email',index:'email', width:150,formatter:actionFilter},
                                {name:'created',index:'created',width:70},
                                {name:'ip', index:'ip',width:100}, 
                                {name:'q1', index:'q1',width:80}, 
                                {name:'q2', index:'q2',width:80}, 
                                {name:'q3', index:'q3',width:80}, 
                                {name:'q4', index:'q4',width:80}, 
                                {name:'q5', index:'q5',width:80}, 
                                {name:'q6', index:'q6',width:80}, 
                                {name:'q7', index:'q7',width:80}, 
                                {name:'q8', index:'q8',width:80}, 
                                {name:'q9', index:'q9',width:80}, 
                                {name:'q10', index:'q10',width:80}, 
                        ],
                        rowNum:20,
                        rowList : [20,30,50],
                        mtype: "POST",
                        gridview: true,
                        pager: '#ptoolbar',
                        sortname: 'id',
                        viewrecords: true,
                        sortorder: "desc",
//                        gridComplete: function () {
//                                $("table:first").find("tr:last").find("th:first").find("div").html("Select All<input id='selectall' type='checkbox'>");
//                                $("#selectall").click(function(){
//                                        $("#selectall").attr('checked') == true?$("input[name='orders[]']").each(function(){$(this).attr("checked", true)}):$("input[name='orders[]']").each(function(){$(this).attr("checked", false)});
//                                });
//                        }
		
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
        
        function actionFilter(cellvalue,options,rowObject) {
                return $('<div/>').text(cellvalue).html();
        }
        
        function exportCsv()
        {
                var mya = new Array();
                mya = $("#toolbar").getDataIDs();     //得到所有展示出来的 ID
                var labels = jQuery("#toolbar").getGridParam('colNames');   //得到所有的 colNames label
                var html = " ";

                for (var i in labels) 
                {
                        if( i == 14 || i == 0 ) continue;  	//+++++0开始++++0对应select
                        html += labels[i] + "\t ";    		//输出头部信息
                }
                html = html + "\t\n ";
                for( i=0; i<mya.length; i++ )
                {
                        for( j=0; j<labels.length-1; j++ )
                        {
                                if( j == 15 || j == 0 ) continue;
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
<?php echo View::factory('admin/site/activity_left')->render(); ?>
<div id="do_right">
        <form id="frm_remote_login" method="post" action="" target="_blank">
                <input type="hidden" name="hashed" value="TRUE" />
                <input type="hidden" name="email" value="" />
                <input type="hidden" name="password" value="" />
        </form>
        <div class="box" style="overflow:hidden;">
                <h3>Questionnaire List</h3>
                <fieldset style="text-align:right">
                        <legend style="font-weight:bold">Export</legend>
                        <form id="frm-customer-export" method="post" action="/admin/site/activity/question_export" target="_blank">
                                <label for="export-start">From: </label>
                                <input type="text" name="start" id="export-start" class="ui-widget-content ui-corner-all" />
                                <label for="export-end">To: </label>
                                <input type="text" name="end" id="export-end" class="ui-widget-content ui-corner-all" />
                                <input type="submit" value="Export" class="ui-button" style="padding:0 .5em" />
                        </form>
                </fieldset>
                <script type="text/javascript">
                        $('#export-start, #export-end').datepicker({
                                'dateFormat': 'yy-mm-dd', 
                        });
                </script>
                <table id="toolbar"></table>
                <div id="ptoolbar"></div>
                <form id="form-2"><input type="hidden" name="csvBuffer" id="csvBuffer" /></form>
        </div>
</div>
