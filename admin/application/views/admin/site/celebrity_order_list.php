<script type="text/javascript" src="/media/js/ZeroClipboard.js"></script>
<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />

<script type="text/javascript">
    $(function(){
        jQuery("#toolbar").jqGrid({
            url:'/admin/site/celebrity/order_data?<?php echo $_SERVER['QUERY_STRING']; ?>',
            datatype: "json",
            height: 450,
            width: 1250,
            colNames:['Id','C_id','Name','Email','Ordernum','Created','Track_code','Ship_date','Sku','Count','Url','Show date','Flow','Admin','Action'],
            colModel:[
                {name:'id',index:'id', width:20,search:false},
                {name:'c_id',index:'c_id', width:40,search:false},
                {name:'name',index:'name',align:'center', width:200},
                {name:'email',index:'email',align:'center', width:200},
                {name:'ordernum',index:'ordernum', width:100},
                {name:'created',index:'created', width:100},
                {name:'track_code',index:'track_code', width:180,search:false},
                {name:'ship_date',index:'ship_date', width:80,search:false},
                {name:'sku',index:'sku', width:80},
                {name:'count',index:'count', width:40,search:false},
                {name:'url',index:'url', width:200},
                {name:'show_date',index:'show_date', width:80},
                {name:'flow',index:'flow', width:100},
                {name:'admin',index:'admin', width:50},
                {width:50,search:false,formatter:actionFormatter}
            ],
            rowNum:200000,
            //  rowTotal: 12,
            rowList : [20,30,50,100,200,1000,10000],
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
                var rowData = $("#toolbar").getRowData();
                for (var i = 0; i < rowData.length; i++)
                {

                    var track_link = $('#'+rowData[i].id).find('td').eq(6);
                    if (track_link.html().length > 6)
                    {
                        track_link.css('background-color', '#00FF00');
                    }
                }
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
                
        $('.edit_url').live('click',function(){
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
                
        var get = <?php echo json_encode($_GET); ?>;
        for(var i in get)
        {
            $('#gs_' + i).val(get[i]);
        }
                
    });
    function actionFormatter(cellvalue,options,rowObject) {
        var admin = rowObject[13];
        var user = '<?php echo User::instance(Session::instance()->get('user_id'))->get('name'); ?>';
        var name = $('#gs_name').val();
        var email = $('#gs_email').val();
        var ordernum = $('#gs_ordernum').val();
        var sku = $('#gs_sku').val();
        var admin_name = $('#gs_admin').val();
        var query = '';
        if(name)
        {
            query += '&gs_name=' + name;
        }
        if(email)
        {
            query += '&gs_email=' + email;
        }
        if(ordernum)
        {
            query += '&gs_ordernum=' + ordernum;
        }
        if(sku)
        {
            query += '&gs_sku=' + sku;
        }
        if(admin_name)
        {
            query += '&gs_admin=' + admin_name;
        }
        if(admin == user)
        {
            return '<a class="edit_url" href="/admin/site/celebrity/edit_url/' + rowObject[1] + '?sku='+rowObject[8]+'&ordernum='+rowObject[4]+query+'">Edit_Url</a>'; 
        }
        else
        {
            return '';
        }
    }

    function exportCsv()
    {
        var mya = new Array();
        mya = $("#toolbar").getDataIDs();     //得到所有展示出来的 ID
        var labels = jQuery("#toolbar").getGridParam('colNames');   //得到所有的 colNames label
        var html = " ";
                
        for (var i in labels) 
        {
            if( labels[i] == 'Select' ) continue;   //+++++0开始++++0对应select
            html += labels[i] + "\t ";              //输出头部信息
        }
        html = html + "\t\n ";
        for( i=0; i<mya.length; i++ )
        {
            for( j=0; j<labels.length-1; j++ )  //+++这里.length减几要变，取决于删了几行++
            {
                if( labels[j] == 'Select' ) continue; 
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
<?php echo View::factory('admin/site/celebrity_left')->render(); ?>
<div>

    <div class="box" style="overflow:hidden;">
        <fieldset style="text-align:right">
            <legend style="font-weight:bold">Export Celebrities</legend>
            <form target="_blank" action="/admin/site/celebrity/export_products" method="post">
                <label for="admin">Admin: </label>
                <select name="admin">
                    <?php
                    $admins = DB::query(Database::SELECT, 'SELECT DISTINCT admin FROM celebrits WHERE admin > 100')->execute('slave')->as_array();
                    foreach ($admins as $admin):
                        ?>
                        <option value="<?php echo $admin['admin']; ?>"><?php echo User::instance($admin['admin'])->get('name'); ?></option>
                    <?php endforeach; ?>
                    <option value="0">All</option>
                </select>
                <label for="export-start">From: </label>
                <input type="text" class="ui-widget-content ui-corner-all" id="start" name="start">
                <label for="export-end">To: </label>
                <input type="text" class="ui-widget-content ui-corner-all" id="end" name="end">
                <input type="submit" style="padding:0 .5em" class="ui-button" value="Export">
            </form>

            <form target="_blank" action="/admin/site/celebrity/export_urls" method="post">
                <label for="export-start">From: </label>
                <input type="text" class="ui-widget-content ui-corner-all" id="start1" name="start">
                <label for="export-end">To: </label>
                <input type="text" class="ui-widget-content ui-corner-all" id="end1" name="end">
                <input type="submit" style="padding:0 .5em" class="ui-button" value="Export Urls">
            </form>

        </fieldset>
        <script type="text/javascript">
            $('#start, #end, #start1, #end1').datepicker({
                'dateFormat': 'yy-mm-dd'
            });
        </script>
        <h3>Celebrity Order List</h3>
        <table id="toolbar"></table>
        <div id="ptoolbar"></div>
    </div>
    <!--        <div id="celebrity_view" style="display:none;">
                    <iframe id="celebrity_iframe" class="ui-widget ui-widget-content ui-corner-all  ui-draggable ui-resizable" width="800px" height="300px" src=""></iframe>
            </div>-->
    <div id="celebrity_view" class="" style="padding-bottom: 50px; padding-right: 50px; width: 622px; height: 418px; top: -40px; left: 400px;display:none;">
        <div id="cboxWrapper" style="height: 468px; width: 672px;"><div>
                <div id="cboxTopLeft" style="float: left;"></div>
                <div id="cboxTopCenter" style="float: left; width: 622px;"></div>
                <div id="cboxTopRight" style="float: left;"></div></div>
            <div style="clear: left;"><div id="cboxMiddleLeft" style="float: left; height: 418px;"></div>
                <div id="cboxContent" style="float: left; width: 622px; height: 418px;">
                    <div id="cboxLoadedContent" style="display: block; width: 622px; overflow: auto; height: 400px;">
                        <div style="padding:10px; background:#fff;" id="inline_example2">
                            <iframe id="celebrity_iframe" class="ui-widget ui-widget-content ui-corner-all  ui-draggable ui-resizable" width="600px" height="360px" src=""></iframe>
                        </div>
                    </div>
                    <div class="closebtn" class="" style="right: 25px;top: 433px;">close</div>
                </div>
                <div id="cboxMiddleRight" style="float: left; height: 418px;"></div>
            </div>
            <div style="clear: left;">
                <div id="cboxBottomLeft" style="float: left;"></div>
                <div id="cboxBottomCenter" style="float: left; width: 622px;"></div>
                <div id="cboxBottomRight" style="float: left;"></div>  
            </div>
        </div>
        <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
    </div>
</div>
<form id="form-2"><input type="hidden" name="csvBuffer" id="csvBuffer" /></form>