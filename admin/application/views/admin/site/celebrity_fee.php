<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript" src="/media/js/ZeroClipboard.js"></script>
<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<?php
echo View::factory('admin/site/celebrity_left')->render(); 
$currency = Site::instance()->currencies();
$currencys = array();
foreach($currency as $key => $c)
{
        $currencys[$key] = $c['name'];
}
$fors = DB::select(DB::expr('DISTINCT `for`'))->from('celebrity_fees')->execute('slave')->as_array();
$forArr = array();
foreach($fors as $for)
{
        $forArr[$for['for']] = $for['for'];
}
?>
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/celebrity/fee_data',
                        datatype: "json",
                        height: 450,
                        width: 1250,
                        colNames:['ID','Date','Email','PP Account','Fee','Currency','For','Admin','Action'],
                        colModel:[
                                {name:'id',index:'id', width:40},
                                {name:'created',index:'created', width:100},
                                {name:'email',index:'email',align:'center', width:200},
                                {name:'pp_account',index:'pp_account',align:'center', width:200},
                                {name:'fee',index:'fee', width:40},
                                {name:'currency',index:'currency', width:40,
                                        "searchoptions":{value:<?php echo "'" . str_replace(array('"', '{', '}', ','), array('', '', '', ';'), json_encode(array('' => '') + $currencys)) . "'"; ?>},
                                        "stype":"select",
                                        "summaryTpl":"{0}"
                                },
                                {name:'for',index:'for', width:60,
                                        "searchoptions":{value:<?php echo "'" . str_replace(array('"', '{', '}', ','), array('', '', '', ';'), json_encode(array('' => '') + $forArr)) . "'"; ?>},
                                        "stype":"select",
                                        "summaryTpl":"{0}"
                                },
                                {name:'admin',index:'admin', width:60},
                                {width:100,align:'center',search:false,formatter:actionFormatter}
                        ],
                        rowNum:20,
                        //  rowTotal: 12,
                        rowList : [20,50,100,1000],
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
                
                $(".add").live('click', function(){
                        var email = $(this).attr('href');
                        $("#email").val(email);
                        $("html,body").animate({scrollTop:0},1);
                        return false;
                })
                
                $("#fee_add").live('submit', function(){
                        $.post(
                        '/admin/site/celebrity/fee_add',
                        {
                                email: $("#email").val(),
                                pp: $("#pp").val(),
                                fee: $("#fee").val(),
                                currency: $("#currency").val(),
                                what_for: $("#for").val(),
                                created: $("#created").val()
                        },
                        function (data) {
                                if (data == 'success')
                                {
                                        window.alert('Add Celebrity Fee Successfully!');
                                        $("#email").val('');
                                        $("#pp").val('');
                                        $("#fee").val('');
                                        $('#toolbar').trigger('reloadGrid');
                                }
                                else
                                        window.alert(data);
                        },
                        'json'
                );
                        return false;
                })
                
        });
        function actionFormatter(cellvalue,options,rowObject) {
                var admin = rowObject[7];
                var user = '<?php echo User::instance(Session::instance()->get('user_id'))->get('name'); ?>';
                var role = '<?php echo $role_id = User::instance(Session::instance()->get('user_id'))->get('role_id'); ?>';
                if(role == 0)
                {
                        return '<a class="edit" href="javascript:edit_fee('+rowObject[0]+',&quot;'+rowObject[4]+'&quot;)">Edit</a> <a href="javascript:delete_fee('+rowObject[0]+')" class="delete">Delete</a>'; 
                }
                else if(admin == user)
                {
                        
                        return '<a class="add" href="'+rowObject[2]+'">Add</a> <a class="edit" href="javascript:edit_fee('+rowObject[0]+',&quot;'+rowObject[4]+'&quot;)">Edit</a> <a href="javascript:delete_fee('+rowObject[0]+')" class="delete">Delete</a>'; 
                }
                else
                {
                        return '';
                }
        }
        
        function edit_fee(id,fee)
        {
                var rea = window.prompt("Edit Fee: ",fee);
                if( rea != null )  
                {
                        $.ajax({
                                url: '/admin/site/celebrity/fee_edit/' + id +'?fee=' + rea,
                                success: function (data) {
                                        if (data == 'success')
                                                $('#toolbar').trigger('reloadGrid');
                                        else
                                                window.alert(data);
                                }
                        });
                }
        }
        
        function delete_fee(id)
        {
                if (window.confirm('Delete this data?'))
                {
                        $.ajax({
                                url: '/admin/site/celebrity/fee_delete/' + id,
                                success: function (data) {
                                        if (data == 'success')
                                                $('#toolbar').trigger('reloadGrid');
                                        else
                                                window.alert(data);
                                }
                        });
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
//                        if( i == 6 || i == 0 ) continue;  	//+++++0开始++++0对应select
                        html += labels[i] + "\t ";    		//输出头部信息
                }
                html = html + "\t\n ";
                for( i=0; i<mya.length; i++ )
                {
                        for( j=0; j<labels.length-1; j++ )
                        {
//                                if( j == 12 || j == 0 ) continue;
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
<div class="box" style="overflow:hidden;">
        <h3>Celebrity Fees List</h3>
        <br/>
        <fieldset>
                <legend style="font-weight:bold">Add Celebrity Fee</legend>
                <div>
                        <form action="/admin/site/celebrity/fee_add" method="post" class="need_validation" id="fee_add">
                                <label for="email">Celebrity Email: </label>
                                <input type="text" class="text small required email" id="email" name="email">
                                &nbsp;&nbsp;<label for="pp">PP Account: </label>
                                <input type="text" class="text small required email" id="pp"  name="pp">
                                &nbsp;&nbsp;<label for="fee">Price: </label>
                                <input type="text" class="text small required" id="fee"  name="fee">
                                &nbsp;&nbsp;<label for="fee">Currency: </label>
                                <select class="required" id="currency"  name="currency">
                                        <option value=""></option>
                                <?php foreach($currencys as $c): ?>
                                        <option value="<?php echo $c; ?>"><?php echo $c; ?></option>
                                <?php endforeach; ?>
                                </select>
                                &nbsp;&nbsp;<label for="for">What for: </label>
                                <select class="required" id="for"  name="for">
                                        <option value=""></option>
                                        <option value="customs">Customs</option>
                                        <option value="show">Show</option>
                                </select>
                                &nbsp;&nbsp;<label for="fee">Date: </label>
                                <input type="text" class="text small required" id="created"  name="created">
                                <input type="submit" style="padding:0 .5em" class="ui-button" value="Add">
                        </form>
                </div>
        </fieldset>
        <script type="text/javascript">
                $('#created').datepicker({
                        'dateFormat': 'yy-mm-dd'
                });
        </script>
        <table id="toolbar"></table>
        <div id="ptoolbar"></div> 
<form id="form-2"><input type="hidden" name="csvBuffer" id="csvBuffer" /></form>
</div>