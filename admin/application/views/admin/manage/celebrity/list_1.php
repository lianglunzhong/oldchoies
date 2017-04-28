<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/manage/celebrity/data',
            datatype: "json",
			height: 450,
			width: 1100,
			colNames:['#','S#','姓名','Email','联系方式','等级','积分数','个人博客','博客ALEXA排名','lookbook地址','facebook地址','流量','管理员','操作'],
			colModel:[
                {name:'id',index:'id', width:30},
				{name:'user_id',index:'user_id', width:30},
				{name:'name',index:'name',align:'center', width:100},
                {name:'email',index:'email', width:120},
                {name:'contact',index:'contact', width:60},
                {name:'level',index:'level', width:40},
                {name:'points',index:'points', width:40},
                {name:'blog_url',index:'blog_url', width:120},
                {name:'blog_alexa',index:'blog_alexa', width:100},
                {name:'lookbook_url',index:'lookbook_url', width:120},
                {name:'facebook_url',index:'facebook_url', width:120},
                {name:'flow',index:'flow', width:50},
                {name:'user',index:'user', width:50},
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
            pager: '#ptoolbar',
            sortname: 'id',
            viewrecords: true,
            sortorder: "desc"
            //            caption: "Toolbar Searching"
		});

		jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
        jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});

        $('.delete').live('click',function(){
            confirm_info = '确定删除？';
            if(!confirm(confirm_info)){
                return false;
            }
        });
	});
    
    function actionFormatter(cellvalue,options,rowObject) {
		return '<a href="/manage/celebrity/edit/' + rowObject[0] + '">编辑</a> ' + '<a href="/manage/celebrity/activities/' + rowObject[0] + '">活动记录</a>' +  ' <a href="/manage/celebrity/delete/' + rowObject[0] + '" class="delete">删除</a>';
	}
    function visibilityFormatter(cellvalue,options,rowObject) {
		return cellvalue == 1 ? '正常' : '缺货';
	}
</script>
<?php echo View::factory('admin/manage/left')->render(); ?>
<div id="do_right">

    <div class="box" style="overflow:hidden;">
        <h3>红人</h3>
        <div style="margin-bottom: 10px;"><span><a href="/manage/celebrity/add" style="color: red">添加红人</a></span> | <span><a href="/manage/celebrity/add_activity" style="color: red">添加活动记录</a></span></div>
		<div>
            <h3>
                <form enctype="multipart/form-data" action="/manage/celebrity/import" method="post">
                    <input type="file" name="file" />
                    <input type="submit" name="submit" value="红人批量导入" />
                </form>
            </h3>
        </div>
        <table id="toolbar"></table>
		<div id="ptoolbar"></div>

    </div>
</div>