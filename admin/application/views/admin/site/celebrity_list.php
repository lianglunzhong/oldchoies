<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript" src="/media/js/ZeroClipboard.js"></script>
<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<?php
echo View::factory('admin/site/celebrity_left')->render();
$user_id = Session::instance()->get('user_id');
$members = array(User::instance($user_id)->get('name'));
$result = DB::select()->from('auth_user')->where('parent_id', '=', $user_id)->execute();
foreach($result as $val)
{
        $members[] = $val['name'];
}
?>
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/celebrity/data',
                        datatype: "json",
                        height: 450,
                        width: 1250,
                        colNames:['Select','ID','CustomerId','Name','Email','Country','Level','Admin','Created','Updated','Remark','is_able',"Point","Height","Weight","Bust","Waist","Hips",'Action'],
                        colModel:[
                                {name:'selectall',align:'center',search:false,formatter:actionSelect,index:false,width:40},
                                {name:'id',index:'id', width:40},
                                {name:'customer_id',index:'customer_id',search:false, width:40},
                                {name:'name',index:'name',align:'center', width:150},
                                {name:'email',index:'email',align:'center', width:150},
                                {name:'country',index:'country',align:'center', width:60},
                                {name:'level',index:'level', width:40},
                                {name:'admin',index:'admin', width:40},
                                {name:'created',index:'created', width:80},
                                {name:'updated',index:'updated', width:80},
                                {name:'remark',index:'remark', width:100},
                                {name:'is_able',index:'is_able', width:30, stype:'select', searchoptions:{value:':All;1:Yes;0:No'}},
                                {name:'point',index:'point', width:100},
                                {name:'height',index:'height',align:'center', width:60},
                                {name:'weight',index:'weight',align:'center', width:60},
                                {name:'bust',index:'bust',align:'center', width:60},
                                {name:'waist',index:'waist',align:'center', width:60},
                                {name:'hips',index:'hips',align:'center', width:60},
                                {width:150,align:'center',search:false,formatter:actionFormatter}
                        ],
                        rowNum:20,
                        //  rowTotal: 12,
                        rowList : [20,30,100],
                        // loadonce:true,
                        mtype: "POST",
                        // rownumbers: true,
                        // rownumWidth: 40,
                        gridview: true,
                        pager: '#ptoolbar',
                        sortname: 'id',
                        viewrecords: true,
                        sortorder: "desc",
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

                $('.disable').live('click',function(){
                        if(!confirm('Disable this celebrity?')){
                                return false;
                        }
                });
                
                $('.delete').live('click',function(){
                        if(!confirm('Delete this celebrity?')){
                                return false;
                        }
                });
                
                $('.view').live('click',function(){
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
                
        });
        function actionFormatter(cellvalue,options,rowObject) {
                var admin = rowObject[7];
                var users = <?php echo json_encode($members); ?>;
                var role = '<?php echo $role_id = User::instance($user_id)->get('role_id'); ?>';
                if(role == 0)
                {
                        return '<a class="view" href="/admin/site/celebrity/view/' + rowObject[1] + '">View</a> <a href="#" class="assign" id="' + rowObject[1] + '">Assign</a> <a href="/admin/site/celebrity/delete/' + rowObject[1] + '" class="delete">Delete</a>'; 
                }
                else if(users.in_array(admin))
                {
                        var is_able = rowObject[11];
                        if(is_able == 'Yes')
                        {
                                return '<a class="view" href="/admin/site/celebrity/view/' + rowObject[1] + '">View</a> <a href="/admin/site/celebrity/edit/' + rowObject[1] + '" target="_blank">Edit</a> <a href="/admin/site/celebrity/disable/' + rowObject[1] + '" class="disable">Disable</a> <a href="/admin/site/celebrity/delete/' + rowObject[1] + '" class="delete">Delete</a>'; 
                        }
                        else
                        {
                                return '<a class="view" href="/admin/site/celebrity/view/' + rowObject[1] + '">View</a> <a href="/admin/site/celebrity/edit/' + rowObject[1] + '" target="_blank">Edit</a> <a href="/admin/site/celebrity/enable/' + rowObject[1] + '" class="disable">Enable</a> <a href="/admin/site/celebrity/delete/' + rowObject[1] + '" class="delete">Delete</a>'; 
                        }
                }
                else
                {
                        return '<a class="view" href="/admin/site/celebrity/view/' + rowObject[1] + '">View</a>';
                }
        }
        function actionSelect(cellvalue,options,rowObject){
                return '<input type="checkbox" name="ids[]" value ="'+rowObject[1]+'" >';
        }
        
        Array.prototype.in_array = function(e) 
        { 
                for(i=0;i<this.length;i++)
                {
                        if(this[i] == e)
                                return true;
                }
                return false;
        }
</script>
<div>

        <div class="box" style="overflow:hidden;">
                <h3>
                        Celebrity List
                        <div style="margin:20px;">
                                <span class="moreActions">
                                        <a href="/admin/site/celebrity/add">Celebrity Add</a>
                                </span>
                                <form enctype="multipart/form-data" method="post" action="/admin/site/celebrity/upload">
                                        <input id="file" type="file" name="file">
                                        <input type="submit" value="Bulk Upload" name="submit">
                                        <a href="/media/images/celebrity_upload.csv">上传模板.csv</a>
                                </form>
                                <form enctype="multipart/form-data" action="/admin/site/celebrity/import_basic" method="post" class="lang_hidden">
                                    <input type="file" name="file">
                                    <input type="submit" name="submit" value="Import celebrity basic">
                                    <span style="color:red;">模板: email,show_name,height,weight,bust,waist,hips</span>
                                </form>
                                <form enctype="multipart/form-data" action="/admin/site/celebrity/special_bulkfor" method="post" class="lang_hidden">
                                    <input type="file" name="file">
                                    <input type="submit" name="submit" value="Import">
                                    <span style="color:red;">批量删除终止合作红人</span>
                                </form>
<form enctype="multipart/form-data" action="/admin/site/celebrity/input_bwh" method="post" class="lang_hidden">
                                    <input type="file" name="file">
                                    <input type="submit" name="submit" value="Import">
                                    <span style="color:red;">红人三维导入</span>
                                </form>
                                <form enctype="multipart/form-data" action="/admin/site/celebrity/output_celebrity_info" method="post" class="lang_hidden">
                                    <input type="file" name="file">
                                    <input type="submit" name="submit" value="Import">
                                    <span style="color:red;">导出指定红人地址信息</span>
                                </form>
                                <form enctype="multipart/form-data" action="/admin/site/celebrity/output_celebrity_amount" method="post" class="lang_hidden">
                                    <input type="file" name="file">
                                    <input type="submit" name="submit" value="Import">
                                    <span style="color:red;">导出指定红人采购信息</span>
                                </form>
                        </div>
                </h3>
                <fieldset style="text-align:right">
                        <legend style="font-weight:bold">Export Celebrities</legend>
                        <form target="_blank" action="/admin/site/celebrity/export" method="post">
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
                
                <div id="ptoolbar"></div>
                <div>
                        <form action="/admin/site/celebrity/bulk_assign" id="orderForm" method="post">
                        <table id="toolbar"></table>
                        <select name="user">
                                <option value=""></option>
                                <option value="<?php echo $user_id; ?>"><?php echo User::instance($user_id)->get('name'); ?></option>
                                <?php
                                $admins = DB::select()->from('auth_user')->where('parent_id', '=', $user_id)->execute();
                                foreach ($admins as $admin):
                                        ?>
                                        <option value="<?php echo $admin['id']; ?>"><?php echo $admin['name']; ?></option>
                                <?php endforeach; ?>
                        </select>
                        <input type="submit" value="批量分配" id="assignSubmit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </form>
                </div>
                
                <fieldset>
                        <div style="width:400px;float:left;">
                                <h4>Email批量分配</h4>
                                <form action="/admin/site/celebrity/email_assign" method="post">
                                        <div><span style="color:#FF0000"></span>一行一个Email</div>
                                        <div><span>请输入Email:</span><br>
                                                <textarea name="EMAILARR" cols="40" rows="20"></textarea>       
                                        </div>
                                        <select name="user">
                                                <option value=""></option>
                                                <option value="<?php echo $user_id; ?>"><?php echo User::instance($user_id)->get('name'); ?></option>
                                                <?php
                                                if($user_id == 1)
                                                {
                                                	$admins = DB::select()->from('auth_user')->where('active', '=', 1)->execute();
                                                }else{
                                                	$admins = DB::select()->from('auth_user')->where('parent_id', '=', $user_id)->execute();
                                                }
                                                foreach ($admins as $admin):
                                                        ?>
                                                        <option value="<?php echo $admin['id']; ?>"><?php echo $admin['name']; ?></option>
                                                <?php endforeach; ?>
                                        </select>
                                        <input type="submit" value="Submit">   
                                </form>
                        </div>
                        <div style="float:right;">
                                <strong style="font-weight:bold">Export celebrity order items: </strong>
                                <form target="_blank" action="/admin/site/celebrity/export_orders" method="post">
                                        <label for="export-start">From: </label>
                                        <input type="text" class="ui-widget-content ui-corner-all" id="start1" name="start">
                                        <label for="export-end">To: </label>
                                        <input type="text" class="ui-widget-content ui-corner-all" id="end1" name="end">
                                        <input type="submit" style="padding:0 .5em" class="ui-button" value="Export">
                                </form>
                                <script type="text/javascript">
                                        $('#start1, #end1').datepicker({
                                                'dateFormat': 'yy-mm-dd'
                                        });
                                </script>
                        </div>
                </fieldset>

        </div>
        <!--        <div id="celebrity_view" style="display:none;">
                        <iframe id="celebrity_iframe" class="ui-widget ui-widget-content ui-corner-all  ui-draggable ui-resizable" width="800px" height="300px" src=""></iframe>
                </div>-->
        <div id="celebrity_view" class="" style="padding-bottom: 50px; padding-right: 50px; width: 544px; height: 640px; top: -30px; left: 360px;display:none;">
                <div id="cboxWrapper" style="height: 450px; width: 744px;"><div>
                                <div id="cboxTopLeft" style="float: left;"></div>
                                <div id="cboxTopCenter" style="float: left; width: 644px;"></div>
                                <div id="cboxTopRight" style="float: left;"></div></div>
                        <div style="clear: left;"><div id="cboxMiddleLeft" style="float: left; height: 440px;"></div>
                                <div id="cboxContent" style="float: left; width: 644px; height: 440px;">
                                        <div id="cboxLoadedContent" style="display: block; width: 644px; overflow: auto; height: 420px;">
                                                <div style="padding:10px; background:#fff;" id="inline_example2">
                                                        <iframe id="celebrity_iframe" class="ui-widget ui-widget-content ui-corner-all  ui-draggable ui-resizable" width="820px" height="420px" src=""></iframe>
                                                </div>
                                        </div>
                                        <div class="closebtn" class="">close</div>
                                </div>
                                <div id="cboxMiddleRight" style="float: left; height: 440px;"></div>
                        </div>
                        <div style="clear: left;">
                                <div id="cboxBottomLeft" style="float: left;"></div>
                                <div id="cboxBottomCenter" style="float: left; width: 644px;"></div>
                                <div id="cboxBottomRight" style="float: left;"></div>  
                        </div>
                </div>
                <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
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
                                                        $users = DB::select('id', 'name')->from('auth_user')->where('role_id', '>', $role_id)->execute()->as_array();
                                                        ?>
                                                        <form action="/admin/site/celebrity/assign" method="post" id="formAssign">
                                                                <input type="hidden" id="celebrity_id" name="celebrity_id" value="" />
                                                                <ul>

                                                                        <?php
                                                                        foreach ($users as $user)
                                                                        {
                                                                                echo '<li><label><input type="radio" name="user" value="' . $user['id'] . '" checked="checked"></label>' . $user['name'] . '</li>';
                                                                        }
                                                                        ?>
                                                                        <input class="button" style="margin-left:180px;" type="submit" value="submit" />
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
</div>