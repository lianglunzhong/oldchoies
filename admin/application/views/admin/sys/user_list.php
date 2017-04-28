<?php echo View::factory('admin/sys/sys_left')->render(); ?>
<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
        $(function(){
                jQuery("#toolbar").jqGrid({
                        url:'/admin/sys/user/data',
                        datatype: "json",
                        height: 400,
                        width: 1100,
                        colNames:['ID','Name', 'Email', 'Role', 'Created', 'Parent', 'Is active', 'Action'],
                        colModel:[
                                {name:'id',index:'id', width:40},
                                {name:'name',index:'name', width:50},
                                {name:'email',index:'email', width:150},
                                {name:'role_id',index:'role_id', width:80,formatter:roleFormatter,
                                        "searchoptions":{"value":":All"},
                                        "stype":"select",
                                        "summaryTpl":"{0}"
                                },
                                {name:'created', index:'created',width:80}, 
                                {name:'parent_id', index:'parent_id',width:80}, 
                                {name:'active', index:'active',width:40}, 
                                {search:false,formatter:actionFormatter, width:100}
                        ],
                        rowNum:20,
                        rowList : [20,30,50],
                        mtype: "POST",
                        gridview: true,
                        postData: {id_for_search:true},
                        pager: '#ptoolbar',
                        sortname: 'id',
                        viewrecords: true,
                        sortorder: "desc",
                        gridComplete: function () {
                               
                        }
		
                });

                jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
                jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
                role_search_options();

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
                return '<a href="/admin/sys/user/edit/' + rowObject[0] + '">Edit</a>'
                        + ' <a href="javascript:delete_user('+rowObject[0]+')">Delete</a>'
        }
        
        function roleFormatter(cellvalue,options,rowObject) {
                var userdata = jQuery("#toolbar").getGridParam('userData');
                return userdata['roles'][cellvalue];
        }

        function delete_user(customer_id)
        {
                if (window.confirm('确定要删除该用户？'))
                {
                        $.ajax({
                                url: '/admin/sys/user/delete/'+customer_id,
                                type: 'GET', 
                                success: function (data) {
                                        if (data == 'success') {
                                                $('#toolbar').trigger('reloadGrid');
                                        } else {
                                                window.alert(data);
                                        }
                                }
                        });
                }
        }
        
        function role_search_options(){
                var $gs_role_id = $('#gs_role_id');
        <?php
        $roles = DB::select('id', 'name', 'brief')->from('roles')->execute()->as_array();
        if (count($roles))
        {
                foreach ($roles as $role)
                {
                        ?>
                                $gs_role_id.append('<option value="<?php echo $role['id']; ?>"><?php echo $role['brief']; ?></option>');
                        <?php
                }
        }
        ?>
}

</script>
<div id="do_content">
        <form id="frm_remote_login" method="post" action="" target="_blank">
                <input type="hidden" name="hashed" value="TRUE" />
                <input type="hidden" name="email" value="" />
                <input type="hidden" name="password" value="" />
        </form>
        <div class="box" style="overflow:hidden;">
                <h3>User List
                        <span class="moreActions">
                                <a href="/admin/sys/user/add">Add User</a>
                        </span>
                </h3>
                <table id="toolbar"></table>
                <div id="ptoolbar"></div>
        </div>
</div>
