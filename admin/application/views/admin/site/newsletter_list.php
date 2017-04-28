<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/newsletter/data',
                        datatype: "json",
                        height: 500,
                        width: 1000,
                        colNames:['ID','Eamil','Firstname','Lastname','Gender','Zip','Occupation','Birthday','Country','Created','Action'],
                        colModel:[
                                {name:'id',index:'id', width:40},
                                {name:'email',index:'email',align:'left', width:200},
                                {name:'firstname',index:'firstname', width:120},
                                {name:'latname',index:'latname', width:120},
                                {name:'gender',index:'gender', width:60},
                                {name:'zip',index:'zip', width:50},
                                {name:'occupation',index:'occupation', width:160},
                                {name:'birthday',index:'birthday', width:80},
                                {name:'country',index:'country',align:'center', width:80},
                                {name:'created',index:'created', width:80},
                                {width:60,search:false,align:'center',formatter:actionFormatter}
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
                        sortorder: "desc"
                        //            caption: "Toolbar Searching"
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
                        if(!confirm('Delete this newsletter?\nIt can not be undone!')){
                                return false;
                        }
                });
        });
        function actionFormatter(cellvalue,options,rowObject) {
                return '<a href="javascript:delete_newsletter('+rowObject[0]+')">Delete</a>';
        }

        function delete_newsletter(id)
        {
                if(!confirm('Delete this newsletter?\nIt can not be undone!')) {
                        return false;
                }

                $.ajax({
                        url: '/admin/site/newsletter/delete/' + id, 
                        success: function (data) {
                                if (data == 'success') {
                                        $('#toolbar').trigger('reloadGrid');
                                } else {
                                        window.alert(data);
                                }
                        }
                });
        }
</script>
<div id="do_content">

        <div class="box" style="overflow:hidden;">
                <h3>Newsletters</h3>
                <fieldset style="text-align:right">
                        <legend style="font-weight:bold">Export Newsletters</legend>
                        <form id="frm-customer-export" method="post" action="/admin/site/newsletter/export" target="_blank">
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

        </div>
</div>

