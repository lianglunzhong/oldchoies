<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<?php
$catalogs = array();
$result = DB::select(DB::expr('DISTINCT catalog_id'))->from('catalog_sorts')->execute();
foreach($result as $val)
{
        $catalogs[$val['catalog_id']] = htmlspecialchars_decode(Catalog::instance($val['catalog_id'])->get('name'));
}
?>
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/catalog/sorts_data',
                        datatype: "json",
                        height: 480,
                        width: 1100,
                        colNames:['ID','Catalog','Sort','Attributes','Action'],
                        colModel:[
                                {name:'id',index:'id', width:30},
                                {name:'catalog_id',index:'catalog_id',width:50,stype:'select',searchoptions:{value:<?php echo '"' . str_replace(array('"', '{', '}', ','), array('', '', '', ';'), json_encode(array('' => '') + $catalogs)) . '"'; ?>}},
                                {name:'sort',index:'sort',width:50},
                                {name:'attributes',index:'attributes',width:300},
                                {width:50,align:'center',search:false,formatter:actionFormatter}
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

                $('.edit').live('click',function(){
                        var id = $(this).attr('title');
                        $.post(
                                '/admin/site/catalog/sorts_ajaxdata',
                                {
                                        id: id
                                },
                                function(data)
                                {
                                $("#id1").val(id);
                                $("#catalog1").val(data['catalog']);
                                $("#sort1").val(data['sort']);
                                $("#attributes1").val(data['attributes']);
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
                
                $('.delete').live('click',function(){
                        if(!confirm('Delete this data?')){
                                return false;
                        }
                });
                
                $("#sorts_edit").submit(function(){
                        $.post(
                                '/admin/site/catalog/sorts_edit',
                                {
                                        id: $("#id1").val(),
                                        catalog: $("#catalog1").val(),
                                        sort: $("#sort1").val(),
                                        attributes: $("#attributes1").val()
                                },
                                function(data)
                                {
                                        if(data == 'success')
                                        {
                                                alert('Update catalog sort success!');
                                                $("#wingray").remove();
                                                $('#celebrity_view').fadeOut(160).appendTo('#tab2');
                                                $('#toolbar').trigger('reloadGrid');
                                        }
                                        else
                                        {
                                                 window.alert(data);
                                        }
                                },
                                'json'
                        );
                        return false;
                })

        });
        
        function actionFormatter(cellvalue,options,rowObject) {
                return '<a class="edit" title="' + rowObject[0] + '" href="#">Edit</a> | <a class="delete" href="/admin/site/catalog/sorts_delete/' + rowObject[0] + '">Delete</a>';
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
<?php echo View::factory('admin/site/catalog_left')->render(); ?>
<div id="do_right">
        <form id="frm_remote_login" method="post" action="" target="_blank">
                <input type="hidden" name="hashed" value="TRUE" />
                <input type="hidden" name="email" value="" />
                <input type="hidden" name="password" value="" />
        </form>
        <div class="box" style="overflow:hidden;">
                <h3>Catalog Sorts List</h3>
                <br/>
                <fieldset>
                        <legend style="font-weight:bold">Add Catalog sort</legend>
                        <div style="float:left;">
                                <form action="/admin/site/catalog/sorts_add" method="post" class="need_validation" id="sort_add">
                                        <label for="catalog">Catalog: </label>
                                        <input type="text" class="text required" id="catalog" name="catalog" style="width: 20%;">
                                        &nbsp;&nbsp;<label for="sort">Sort: </label>
                                        <input type="text" class="text small required" id="sort"  name="sort"><br/>
                                        <label for="attributes">Attributes: </label>
                                        <textarea class="textarea" rows="5" cols="60" id="attributes" name="attributes"></textarea>
                                        <input type="submit" style="padding:0 .5em" class="ui-button" value="Add">
                                </form>
                        </div>
                        <div style="float:right;">
                                <h4>Bulk import</h4>
                                <form enctype="multipart/form-data" method="post" action="/admin/site/catalog/sorts_import"  target="_blank">
                                        <input id="file" type="file" name="file">
                                        <input type="submit" value="Bulk Upload" name="submit">
                                </form>
                                <h4 style="color:red;">(CSV表格格式:Catalog,Sort,Attribuite,Attribute,...)</h4>
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
                                                        <h4>Edit Catalog Sort:</h4>
                                                        <form action="/admin/site/catalog/sorts_edit" method="post" id="sorts_edit">
                                                                <input type="hidden" value="" name="id" id="id1" />
                                                                <ul>
                                                                        <li>
                                                                                <label>Catalog: </label>
                                                                                <input type="text" class="text required" id="catalog1" name="catalog" style="width: 70%;">
                                                                        </li>
                                                                        <li>
                                                                                <label>Sort: </label>
                                                                                <input type="text" class="text required" id="sort1" name="sort" style="width: 20%;">
                                                                        </li>
                                                                        <li>
                                                                                <label>Attributes: </label>
                                                                                <textarea id="attributes1" name="attributes" cols="40" rows="8"></textarea>
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
