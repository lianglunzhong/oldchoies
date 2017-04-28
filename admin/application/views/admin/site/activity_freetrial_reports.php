<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/activity/freetrial_reports_data',
                        datatype: "json",
                        height: 1000,
                        width: 1100,
                        colNames:['ID','Sku','Name','Age','Profession','Created','Comments','Image','Action'],
                        colModel:[
                                {name:'id',index:'id', width:30},
                                {name:'sku',index:'sku', width:50},
                                {name:'name',index:'name',width:70},
                                {name:'age',index:'age',width:30}, 
                                {name:'profession',index:'profession',width:70},
                                {name:'created',index:'created',width:50},
                                {name:'comments',index:'comments',width:150},
                                {name:'image',index:'image',width:150},
                                {width:100,align:'center',search:false,formatter:actionFormatter}
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

                $('.delete').live('click', function(){
                        if(!confirm('Are you sure to delete this data?')){
                                return false;
                        }
                });

        });
        
        function actionFormatter(cellvalue,options,rowObject) {
                return '<a target="_blank" href="/admin/site/activity/freetrial_reports_edit/' + rowObject[0] + '">Edit</a> <a href="/admin/site/activity/freetrial_reports_delete/' + rowObject[0] + '" class="delete">Delete</a>';
        }
        
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
                <h3>Freetrial Reports List</h3>
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
