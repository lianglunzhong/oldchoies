<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/product/taobao_data',
                        datatype: "json",
                        height: 600,
                        width: 1200,
                        colNames:['ID','SKU','Name','Price','Set','Visibility','Status','Clicks','Q_clicks','Add Cart Times','红人次数','Created','Sales','Admin','Taobao_url','Action'],
                        colModel:[
                                {name:'id',index:'id', width:40},
                                {name:'sku',index:'sku', width:70},
                                {name:'name',index:'name', width:150},
                                {name:'price',index:'price', width:60},
                                {name:'set',index:'set_id', width:80},
                                {name:'visibility',index:'visibility', width:60},
                                {name:'status',index:'status', width:50},
                                {name:'clicks',index:'clicks', width:50},
                                {name:'quick_clicks',index:'quick_clicks', width:50},
                                {name:'add_times',index:'add_times', width:80},
                                {name:'celebrity_times',index:'celebrity_times', width:50},
                                {name:'created',index:'created', width:70},
                                {name:'sales',index:'sales', width:30,search:false},
                                {name:'admin',index:'admin', width:40},
                                {name:'taobao_url',index:'taobao_url', width:250},
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
                        postData: {id_for_search:true},
                        pager: '#ptoolbar',
                        sortname: 'id',
                        viewrecords: true,
                        sortorder: "desc",
                        gridComplete: function () {
                                var rowData = $("#toolbar").getRowData();
                                for (var i = 1; i <= rowData.length; i++)
                                {
                                        var taobao = $('#'+i).find('td').eq(10);
                                        if (taobao.html() == 'instock')
                                        {
                                                taobao.css('background-color', 'lime');
                                        }
                                        else if (taobao.html() == 'outstock')
                                        {
                                                taobao.css('background-color', 'red');
                                        }
                                }
                        }
                });

                jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
                jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
                
                $('.edit').live('click',function(){
                        $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                        $('#celebrity_view').appendTo('body').fadeIn(320);
                        var id = $(this).attr('id');
                        $('#product_id').val(id);
                        var url = $(this).attr('name');
                        $('#taobao_url').val(url);
                        $('#celebrity_view').show();
                        return false;
                })
                
                $("#celebrity_view .closebtn,#wingray").live("click",function(){
                        $("#wingray").remove();
                        $('#celebrity_view').fadeOut(160).appendTo('#tab2');
                        return false;
                })
                
                $("#export_url").live("click", function(){
                        $("#frm-taobao-export").attr("action", '/admin/site/product/export_taobaourl');
                        $("#frm-taobao-export").submit();
                        return false;
                })

        });
        function actionFormatter(cellvalue,options,rowObject) {
                return '<a href="#" id="'+rowObject[0]+'" name="' + rowObject[11] + '" class="edit">Edit_url</a>';
        }
</script>
<div id="do_content">

        <div class="box" style="overflow:hidden;">
                <h3>Products Status Statistics
                        <fieldset>
                        <legend style="font-weight:bold">Export</legend>
                        <form id="frm-taobao-export" method="post" action="/admin/site/product/export_taobao" target="_blank">
                                <label for="admin">Admin: </label>
                                <select name="admin">
                                <?php foreach($admins as $admin): ?>
                                        <option value="<?php echo $admin['admin']; ?>"><?php echo User::instance($admin['admin'])->get('name'); ?></option>
                                <?php endforeach; ?>
                                        <option value="all">All</option>
                                </select>
                                <label for="export-start">From: </label>
                                <input type="text" name="start" id="export-start" class="ui-widget-content ui-corner-all" />
                                <label for="export-end">To: </label>
                                <input type="text" name="end" id="export-end" class="ui-widget-content ui-corner-all" />
                                <input type="submit" value="Export" class="ui-button" style="padding:0 .5em" />
                                <input type="button" value="Export Url" id="export_url" style="padding:0 .5em" />
                        </form>
                        </fieldset>
                        <script type="text/javascript">
                        $('#export-start, #export-end').datepicker({
                                'dateFormat': 'yy-mm-dd'
                        });
                        </script>
                </h3>

                <table id="toolbar"></table>
                <div id="ptoolbar"></div>
                <div style="margin:20px;">
                        <h3>批量上传产品淘宝链接</h3>
                        <form enctype="multipart/form-data" action="/admin/site/product/upload_taobaoUrl" method="post">
                                <input type="file" name="file" />
                                <input type="submit" name="submit" value="Import product taobao url" />
                        </form>
                        
                        <fieldset>
                                <div style="width:800px;float:left;">
                                        <h4>URL导出产品信息</h4>
                                        <form action="/admin/site/product/export_urlproduct" method="post">
                                                <div><span style="color:#FF0000"></span>一行一个URL</div>
                                                <div><span>请输入产品URL:</span><br>
                                                        <textarea name="urls" cols="80" rows="20"></textarea>       
                                                </div>
                                                <input type="submit" value="Submit">   
                                        </form>
                                </div>
                        </fieldset>
                </div>

                <div id="celebrity_view" class="" style="padding-bottom: 50px; padding-right: 50px; width: 522px; height: 238px; top: 100px; left: 438.5px;display:none;">
                        <div id="cboxWrapper" style="width: 572px; height: 188px;"><div>
                                        <div id="cboxTopLeft" style="float: left;"></div>
                                        <div id="cboxTopCenter" style="float: left; width: 522px;"></div>
                                        <div id="cboxTopRight" style="float: left;"></div></div>
                                <div style="clear: left;"><div id="cboxMiddleLeft" style="float: left; height: 138px;"></div>
                                        <div id="cboxContent" style="float: left; width: 522px; height: 138px;">
                                                <div id="cboxLoadedContent" style="display: block; width: 522px; overflow: auto; height: 118px;">
                                                        <div style="padding:10px; background:#fff;" id="inline_example2">
                                                                <h3>Edit taobao url</h3>
                                                                <form action="" method="post">
                                                                        <input type="hidden" name="id" value="" id="product_id" />
                                                                        <table cellspacing="1" cellpadding="1" border="0">
                                                                        <tr><td><input type="text" name="url" value="" id="taobao_url" style="width:400px" /><br /></td></tr>
                                                                        </table>
                                                                        <br>
                                                                        <input type="submit" value="submit" />
                                                                </form>
                                                        </div>
                                                </div>
                                                <div class="closebtn" style="right: 20px;top: 150px;">close</div>
                                        </div>
                                        <div id="cboxMiddleRight" style="float: left; height: 138px;"></div>
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
</div>
