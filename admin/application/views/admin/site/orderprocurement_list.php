<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<?php echo View::factory('admin/site/orderprocurement_left')->render(); ?>
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/orderprocurement/data',
                        datatype: "json",
                        height: 400,
                        width: 1250,
                        colNames:['ID','订单号','Sku','数量','Attribute','Price','Created','类型','采购产品名称','旺旺户名','备注','国内物流','国内运单号','广州确认','采购单号','Action'],
                        colModel:[
                                {name:'id',index:'id', width:40},
                                {name:'ordernum',index:'ordernum', width:100},
                                {name:'sku',index:'sku',width:80},
                                {name:'quantity', index:'quantity',width:40}, 
                                {name:'attribute', index:'attribute',width:150}, 
                                {name:'price', index:'price',width:60}, 
                                {name:'created', index:'created',width:100},
                                {name:'type', index:'type',width:40},
                                {name:'name', index:'name',width:250},
                                {name:'wangwang', index:'wangwang',width:100},
                                {name:'remark', index:'remark',width:250},
                                {name:'cn_carrier', index:'cn_carrier',width:250},
                                {name:'cn_tracking_code', index:'cn_tracking_code',width:250},
                                {name:'confirm', index:'confirm',width:250,stype:'select',searchoptions:{value:':All;0:否;1:是'},formatter:confirmFormatter},
                                {name:'purchase_id', index:'purchase_id',width:250},
                                {width:50,search:false,formatter:actionFormatter},
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
                
                $('.edit').live('click',function(){
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
                        $('#toolbar').trigger('reloadGrid');
                        return false;
                })
        });
        function actionFormatter(cellvalue,options,rowObject) {
                return '<a class="edit" href="/admin/site/orderprocurement/edit/' + rowObject[0] + '">Edit</a>';
        }
</script>
<script type="text/javascript">
        function confirmFormatter(cellvalue,options,rowObject){
                return (cellvalue==1)?'是':'否';
        }
</script>
<div id="do_content">
        <form id="frm_remote_login" method="post" action="" target="_blank">
                <input type="hidden" name="hashed" value="TRUE" />
                <input type="hidden" name="email" value="" />
                <input type="hidden" name="password" value="" />
        </form>
        <div class="box" style="overflow:hidden;">
                <h3>采购表
                        <div style="margin:20px;">
                                <form enctype="multipart/form-data" method="post" action="/admin/site/orderprocurement/upload" style="border-style:groove;padding:3px;margin:4px 0">
                                        <input id="file" type="file" name="file">
                                        <input type="submit" value="Bulk Upload" name="submit">CSV文件
                                </form>
                                <form enctype="multipart/form-data" method="post" action="/admin/site/orderprocurement/update_track" style="border-style:groove;padding:3px;margin:4px 0">
                                        <input id="file" type="file" name="file">
                                        <input type="submit" value="Upload" name="submit">国内物流批量上传#CSV文件/格式:订单号,sku,数量,尺码,国内物流,国内运单号
                                </form>
                        </div>
                        <fieldset style="text-align:right">
                        <legend style="font-weight:bold">Export</legend>
                        <form id="frm-customer-export" method="post" action="/admin/site/orderprocurement/export" target="_blank">
                                <label for="export-start">From: </label>
                                <input type="text" name="start" id="export-start" class="ui-widget-content ui-corner-all" />
                                <label for="export-end">To: </label>
                                <input type="text" name="end" id="export-end" class="ui-widget-content ui-corner-all" />
                                <input type="submit" value="Export" class="ui-button" style="padding:0 .5em" />
                        </form>
                        </fieldset>
                </h3>
                <script type="text/javascript">
                        $('#export-start, #export-end').datepicker({
                                'dateFormat': 'yy-mm-dd'
                        });
                </script>	
                <table id="toolbar"></table>
                <div id="ptoolbar"></div> 
        </div>
        <div id="celebrity_view" class="" style="padding-bottom: 50px; padding-right: 50px; width: 522px; height: 438px; top: 15px; left: 438.5px;display:none;">
                <div id="cboxWrapper" style="width: 572px; height: 488px;"><div>
                                <div id="cboxTopLeft" style="float: left;"></div>
                                <div id="cboxTopCenter" style="float: left; width: 522px;"></div>
                                <div id="cboxTopRight" style="float: left;"></div></div>
                        <div style="clear: left;"><div id="cboxMiddleLeft" style="float: left; height: 438px;"></div>
                                <div id="cboxContent" style="float: left; width: 522px; height: 438px;">
                                        <div id="cboxLoadedContent" style="display: block; width: 522px; overflow: auto; height: 418px;">
                                                <div style="padding:10px; background:#fff;" id="inline_example2">
                                                        <iframe id="celebrity_iframe" class="ui-widget ui-widget-content ui-corner-all  ui-draggable ui-resizable" width="800px" height="400px" src=""></iframe>
                                                </div>
                                        </div>
                                        <div class="closebtn" style="right: 20px;top: 450px;">close</div>
                                </div>
                                <div id="cboxMiddleRight" style="float: left; height: 438px;"></div>
                        </div>
                        <div style="clear: left;">
                                <div id="cboxBottomLeft" style="float: left;"></div>
                                <div id="cboxBottomCenter" style="float: left; width: 522px;"></div>
                                <div id="cboxBottomRight" style="float: left;"></div>  
                        </div>
                </div>
                <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
        </div>
</div>
