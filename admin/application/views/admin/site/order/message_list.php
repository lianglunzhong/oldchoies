<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
    $(function(){
        jQuery("#toolbar").jqGrid({
            url:'/admin/site/orderproduct/message_data',
            datatype: "json",
            height: 480,
            width: 1100,
            colNames:['Id','ordernum','message','created','status', 'Action'],
            colModel:[
                {name:'id',index:'id', width:30},
                {name:'ordernum',index:'ordernum', width:100},
                {name:'message',index:'message', width:500},
                {name:'created',index:'created', width:100},
                {name:'status',index:'status', width:50},
                {search:false,formatter:actionFormatter,width:120}
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
            //caption: "Toolbar Searching"
        });
        jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
        jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});

        $("#celebrity_view .closebtn,#wingray").live("click",function(){
            $("#wingray").remove();
            $('#celebrity_view').fadeOut(160).appendTo('#tab2');
            return false;
        })

        $('.delete').live('click',function(){
            if(!confirm('Delete this message?')){
                return false;
            }
        })

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
    });

    function actionFormatter(cellvalue,options,rowObject) {
        // var html = '<a class="edit" href="javascript:;" onclick="return view_message(&quot;'+rowObject[2]+'&quot;, &quot;'+rowObject[4]+'&quot;, &quot;'+rowObject[0]+'&quot;);">View</a> | <a class="delete" href="/admin/site/orderproduct/message_delete/' + rowObject[0] + '">Delete</a>';
        var html = '<a class="edit" href="javascript:;" onclick="return view_message(&quot;'+rowObject[0]+'&quot;, &quot;'+rowObject[4]+'&quot;)">View</a>';
        return html;
    }

    function view_message(message_id, status)
    {
        var message = $("#"+message_id).find('td').eq(2).html();
        $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
        $('#celebrity_view').appendTo('body').fadeIn(320);
        $('#show_value').text(message);
        $('#message_id').val(message_id);
        if(status == 0)
        {
            document.getElementById("set_read_checkbox").checked = false;
        }
        else
        {
            document.getElementById("set_read_checkbox").checked = true;
        }
        $('#celebrity_view').show();
        return false;
    }

    function message_submit()
    {
        datas = new Object();
        var message_id = document.getElementById("message_id").value;
        var checked = document.getElementById("set_read_checkbox").checked;
        var set_read = '';
        if(checked)
            set_read = 'on';
        datas.message_id = message_id;
        datas.set_read = set_read;
        datas.typ = 'ajax';
        $.ajax({
            type:"POST",
            url :"/admin/site/orderproduct/message",
            data:datas,
            dataType:"json",
            success:function(res){
                $('#toolbar').trigger('reloadGrid');
                $("#wingray").remove();
                $('#celebrity_view').fadeOut(160).appendTo('#tab2');
                return false;
            }
        });
        return false;
    }

</script>
<div id="do_content">
    <div class="box" style="overflow:hidden;">
        <h3>客户订单留言列表</h3>
        <table id="toolbar"></table>
        <div id="ptoolbar"></div>
    </div>
</div>

<div id="celebrity_view" class="" style="padding-bottom: 50px; padding-right: 50px; width: 400px; height: 180px; top: -30px; left: 360px;display:none;">
        <div id="cboxWrapper" style="height: 450px; width: 744px;"><div>
                        <div id="cboxTopLeft" style="float: left;"></div>
                        <div id="cboxTopCenter" style="float: left; width: 400px;"></div>
                        <div id="cboxTopRight" style="float: left;"></div></div>
                <div style="clear: left;"><div id="cboxMiddleLeft" style="float: left; height: 180px;"></div>
                        <div id="cboxContent" style="float: left; width: 400px; height: 180px;">
                                <div id="cboxLoad edContent" style="display: block; width: 400px; overflow: auto; height: 160px;">
                                        <div style="padding:10px; background:#fff;" id="inline_example2">
                                                <textarea id="show_value" style="line-height: 17px; width: 360px; height: 110px;" disabled="disabled"></textarea>
                                        </div>
                                </div>
                                <form action="" method="post" onsubmit="return message_submit();">
                                    <input type="hidden" name="message_id" id="message_id" value="0" />
                                    &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="set_read" id="set_read_checkbox" />
                                    <label for="set_read_checkbox">Set to read</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="submit" value="submit" />
                                </form>
                                <div class="closebtn" class="" style="right: 25px;top: 190px;">close</div>
                        </div>
                        <div id="cboxMiddleRight" style="float: left; height: 180px;"></div>
                </div>
                <div style="clear: left;">
                        <div id="cboxBottomLeft" style="float: left;"></div>
                        <div id="cboxBottomCenter" style="float: left; width: 400px;"></div>
                        <div id="cboxBottomRight" style="float: left;"></div>  
                </div>
        </div>
        <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
</div>