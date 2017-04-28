<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/site/country/data',
                        datatype: "json",
                        height: 600,
                        width: 900,
                        colNames:['ID','Country Name','Isocode','Order','Brief','Action'],
                        colModel:[
                                {name:'id',index:'id',align:'center', width:40},
                                {name:'country_name',index:'name', width:120,align:'center'},
                                {name:'isocode',index:'isocode',align:'center', width:40},
                                {name:'position',index:'position', width:40,align:'center',formatter:orderFormatter},
                                {name:'brief',index:'brief', width:40,align:'center'},
                                {width:110,search:false,formatter:actionFormatter}
                        ],
                        rowNum:20,
                        rowList : [20,30,50],
                        mtype: "POST",
                        gridview: true,
                        pager: '#ptoolbar',
                        sortname: 'position',
                        viewrecords: true,
                        sortorder: "desc"
                });

                jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
                jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});

        });

        function orderFormatter(cellvalue,options,rowObject) {
                return '<input type="text" id="position_'+rowObject[0]+'" name="position" value="'+ rowObject[3] +'" onchange="change_position('+rowObject[0]+')"/>';
        }

        function actionFormatter(cellvalue,options,rowObject) {
                var active;
                if(rowObject[5]==1)
                {
                        active = '隐藏';
                }
                else
                {
                        active = '显示';
                }
                return '<a href="/admin/site/country/edit/' + rowObject[0] + '">修改</a> | <a href="/admin/site/country/active/' + rowObject[0] + '">'+active+'</a>　　<a href="/admin/site/country/removeup/' + rowObject[0] + '">向上</a> | <a href="/admin/site/country/removedown/' + rowObject[0] + '">向下</a>　<a href="/admin/site/carrier/united/' + rowObject[0] + '">添加物流国家关联</a>';
        }

        function change_position(obj)
        {
                var postion = $("#position_"+obj).val();
                window.location.href="/admin/site/country/change/"+obj+"&"+postion;
        }
</script>
<?php echo View::factory('admin/site/basic_left')->render(); ?>

<div id="do_content">
        <div class="box" style="overflow:hidden;">
                <h3>国家列表</h3>

                <table id="toolbar"></table>
                <div id="ptoolbar"></div>

        </div>
</div>

