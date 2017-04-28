<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/activity/share_win_configs_data',
                        datatype: "json",
                        height: 480,
                        width: 1100,
                        colNames:['ID','Products','Week time','Winners','Created','Action'],
                        colModel:[
                                {name:'id',index:'id', width:30},
                                {name:'products',index:'products', width:100},
                                {name:'endtime',index:'endtime',width:70},
                                {name:'winners',index:'winners',width:200},
                                {name:'created',index:'created',width:70},
                                {width:100,align:'center',search:false,formatter:actionFormatter}
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

                $('.edit').live('click',function(){
                        var id = $(this).attr('title');
                        $.post(
                                '/admin/site/activity/share_win_configs_ajaxdata',
                                {
                                        id: id
                                },
                                function(data)
                                {
                                $("#id1").val(id);
                                $("#products1").val(data['products']);
                                $("#chances1").val(data['chances']);
                                $("#winners").val(data['winners']);
                                $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                                $('#celebrity_view').appendTo('body').fadeIn(320);
                                $('#celebrity_view').show();
                                },
                                'json'
                        );
                        return false;
                })
                
                $("#celebrity_view .closebtn,#wingray").live("click",function(){
                        $("#wingray").remove();
                        $('#celebrity_view').fadeOut(160).appendTo('#tab2');
                        return false;
                })

        });
        
        function actionFormatter(cellvalue,options,rowObject) {
                return '<a target="_blank" class="edit" title="' + rowObject[0] + '" href="#">Edit</a>';
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
                <h3>Share&Win Configs List</h3>
                <br/>
                <fieldset>
                        <legend style="font-weight:bold">Add share and win</legend>
                        <div>
                                <form action="/admin/site/activity/share_win_config_add" method="post" class="need_validation" id="fee_add">
                                        <label for="products">Products sku: </label>
                                        <input type="text" class="text required" id="products" name="products" style="width: 20%;">
                                        &nbsp;&nbsp;<label for="endtime">week time: </label>
                                        <input type="text" class="text small required" id="endtime"  name="endtime">
                                        <input type="submit" style="padding:0 .5em" class="ui-button" value="Add">
                                </form>
                                <script type="text/javascript">
                                        $('#endtime').datepicker({
                                                'dateFormat': 'yy-mm-dd'
                                        });
                                </script>
                        </div>
                </fieldset>
                <table id="toolbar"></table>
                <div id="ptoolbar"></div>
                <form id="form-2"><input type="hidden" name="csvBuffer" id="csvBuffer" /></form>
        </div>
        <div id="celebrity_view" class="" style="padding-bottom: 50px; padding-right: 50px; width: 244px; height: 640px; top: -30px; left: 500px;display:none;">
                <div id="cboxWrapper" style="height: 450px; width: 444px;"><div>
                                <div id="cboxTopLeft" style="float: left;"></div>
                                <div id="cboxTopCenter" style="float: left; width: 344px;"></div>
                                <div id="cboxTopRight" style="float: left;"></div></div>
                        <div style="clear: left;"><div id="cboxMiddleLeft" style="float: left; height: 370px;"></div>
                                <div id="cboxContent" style="float: left; width: 344px; height: 370px;">
                                        <div id="cboxLoadedContent" style="display: block; width: 344px; overflow: auto; height: 375px;">
                                                <div style="padding:10px; background:#fff;" id="inline_example2">
                                                        <h4>Edit share_win Config:</h4>
                                                        <form action="/admin/site/activity/share_win_config_edit" method="post">
                                                                <input type="hidden" id="celebrity_id" name="celebrity_id" value="" />
                                                                <ul>
                                                                        <input type="hidden" value="" name="id" id="id1" />
                                                                        <li>
                                                                                <label>Products: </label>
                                                                                <input type="text" class="text required" id="products1" name="products" style="width: 70%;">
                                                                        </li>
                                                                        <li>
                                                                                <label>Winners: </label>
                                                                                <textarea id="winners" name="winners" cols="40" rows="8"></textarea>
                                                                        </li>
                                                                        <input class="button" style="margin-left:180px;" type="submit" value="submit" />
                                                                </ul>
                                                        </form>

                                                </div>
                                        </div>
                                        <div class="closebtn" style="top: 360px;">close</div>
                                </div>
                                <div id="cboxMiddleRight" style="float: left; height: 370px;"></div>
                        </div>
                        <div style="clear: left;">
                                <div id="cboxBottomLeft" style="float: left;"></div>
                                <div id="cboxBottomCenter" style="float: left; width: 344px;"></div>
                                <div id="cboxBottomRight" style="float: left;"></div>  
                        </div>
                </div>
                <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
        </div>
</div>
