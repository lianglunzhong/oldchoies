<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/celebrity/backups_data',
                        datatype: "json",
                        height: 450,
                        width: 1000,
                        colNames:['Select','ID','Email','Sites','Comment','Gender','Country','Status','Created','Admin','Assign','Action'],
                        colModel:[
                                {name:'selectall',align:'center',search:false,formatter:actionSelect,index:false,width:40},
                                {name:'id',index:'id', width:40},
                                {name:'email',index:'email', width:150},
                                {name:'sites',index:'sites', width:200},
                                {name:'comment',index:'comment', width:200},
                                {name:'gender',index:'gender', width:40,formatter:genderFormatter,
                                        "searchoptions":{"value":":All;1:Male;0:Female"},
                                        "stype":"select",
                                        "summaryTpl":"{0}"},
                                {name:'country',index:'country', width:80},
                                {name:'is_join',index:'is_join', width:50,formatter:statusFormatter,
                                        "searchoptions":{"value":":All;1:Yes;0:No"},
                                        "stype":"select",
                                        "summaryTpl":"{0}"
                                },
                                {name:'created',index:'created', width:80},
                                {name:'admin',index:'admin', width:60,search:false},
                                {name:'assign',index:'assign', width:60,search:false},
                                {width:60,search:false,formatter:actionFormatter}
                        ],
                        rowNum:10,
                        //  rowTotal: 12,
                        rowList : [10,20,150],
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
                
                $('.assign').live('click',function(){
                        var c_id = $(this).attr('id');
                        $('body').append('<div id="wingray1" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                        $('#celebrity_assign').appendTo('body').fadeIn(320);
                        $('#celebrity_id').val(c_id)
                        return false;
                })
        
                $("#celebrity_assign .closebtn,#wingray1").live("click",function(){
                        $("#wingray1").remove();
                        $('#celebrity_assign').fadeOut(160).appendTo('#tab2');
                        return false;
                })
                
                $("#formAssign").live('submit', function(){
                        $.post(
                        '/admin/site/celebrity/backup_assign',
                        {
                                celebrity_id: $('input:[name="celebrity_id"]').val(),
                                user: $('.user:checked').val()
                        },
                        function(data)
                        {
                                $("#wingray1").remove();
                                $('#celebrity_assign').hide();
                                $('#toolbar').trigger('reloadGrid');
                        },
                        'json'
                        );
                        return false;
                })
                
                $("#assignSubmit").click(function(){
                        var form = $('#orderForm');
                        form.attr('action', '/admin/site/celebrity/backup_bulkassign');
                        form.submit();
                })
                                        
                $("#deleteSubmit").click(function(){
                        var form = $('#orderForm');
                        form.attr('action', '/admin/site/celebrity/backup_bulkdelete');
                        form.submit();
                })
                
        });
        function actionSelect(cellvalue,options,rowObject){
                return '<input type="checkbox" name="ids[]" value ="'+rowObject[1]+'" >';
        }
        function actionFormatter(cellvalue,options,rowObject) {
                return '<a href="#" class="assign" id="' + rowObject[0] + '">Assign</a> <a href="javascript:assign_delete('+rowObject[0]+')" class="delete">Delete</a>';
        }
        function statusFormatter(cellvalue) {
                return cellvalue == 1 ? 'Yes' : 'No';
        }
        function genderFormatter(cellvalue) {
                return cellvalue == 1 ? 'Male' : cellvalue == 0 ? 'Female' : 'Null';
        }
        function assign_delete(id)
        {
                if (!window.confirm('Delete this celebrity?\nIt can not be undone!'))
                        return false;
                
                $.ajax({
                        url: '/admin/site/celebrity/backup_delete/' + id,
                        success: function (data) {
                                if (data == 'success')
                                        $('#toolbar').trigger('reloadGrid');
                                else
                                        window.alert(data);
                        }
                });
        }
</script>
<?php echo View::factory('admin/site/celebrity_left')->render(); ?>
<div>

        <div class="box" style="overflow:hidden;">
                <h3>Celebrity Backups List</h3>
                <fieldset style="text-align:right">
                        <legend style="font-weight:bold">Export</legend>
                        <form target="_blank" action="/admin/site/celebrity/backup_export" method="post">
                                <label for="export-start">From: </label>
                                <input type="text" class="ui-widget-content ui-corner-all" id="start" name="start">
                                <label for="export-end">To: </label>
                                <input type="text" class="ui-widget-content ui-corner-all" id="end" name="end">
                                <input type="submit" style="padding:0 .5em" class="ui-button" value="Export">
                        </form>
                </fieldset>
                <script type="text/javascript">
                        $('#start, #end').datepicker({
                                'dateFormat': 'yy-mm-dd'
                        });
                </script>
                <form action="" id="orderForm" method="post">
                        <table id="toolbar"></table>
                        <select name="user">
                        <?php foreach($admins as $admin): ?>
                                <option value="<?php echo $admin['id']; ?>"><?php echo $admin['name']; ?></option>
                        <?php endforeach; ?>
                        </select>
                        <input type="button" value="批量分配" id="assignSubmit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" value="批量删除" id="deleteSubmit">
                </form>
                <div id="ptoolbar"></div>

        </div>
</div>
<div id="celebrity_assign" class="" style="padding-bottom: 50px; padding-right: 50px; width: 342px; height: 318px; top: 15px; left: 500px;display:none;">
        <div id="cboxWrapper" style="height: 368px; width: 392px;"><div>
                        <div id="cboxTopLeft" style="float: left;"></div>
                        <div id="cboxTopCenter" style="float: left; width: 342px;"></div>
                        <div id="cboxTopRight" style="float: left;"></div></div>
                <div style="clear: left;"><div id="cboxMiddleLeft" style="float: left; height: 318px;"></div>
                        <div id="cboxContent" style="float: left; width: 342px; height: 318px;">
                                <div id="cboxLoadedContent" style="display: block; width: 342px; overflow: auto; height: 298px;">
                                        <div style="padding:10px; background:#fff;" id="inline_example2">
                                                <h4>Assign Celebrity TO:</h4>
                                                <?php
                                                $users = DB::select('id', 'name')->from('auth_user')->execute('slave')->as_array();
                                                ?>
                                                <form action="#" method="post" id="formAssign">
                                                        <input type="hidden" id="celebrity_id" name="celebrity_id" value="" />
                                                        <ul>

                                                                <?php 
                                                                foreach ($users as $user)
                                                                { 
                                                                        echo '<li><label><input type="radio" class="user" name="user" value="' . $user['id'] . '" checked="checked"></label>' . $user['name'] . '</li>';
                                                                }
                                                                ?>
                                                                <input class="button" id="assignSbumit" style="margin-left:180px;" type="submit" value="submit" />
                                                        </ul>
                                                </form>

                                        </div>
                                </div>
                                <div class="closebtn" class="">close</div>
                        </div>
                        <div id="cboxMiddleRight" style="float: left; height: 318px;"></div>
                </div>
                <div style="clear: left;">
                        <div id="cboxBottomLeft" style="float: left;"></div>
                        <div id="cboxBottomCenter" style="float: left; width: 342px;"></div>
                        <div id="cboxBottomRight" style="float: left;"></div>  
                </div>
        </div>
        <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
</div>