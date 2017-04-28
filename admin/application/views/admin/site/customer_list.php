<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<?php
$languages = Kohana::config('sites.1.language');
$langs = array();
foreach($languages as $l)
{
    if($l == 'en')
        continue;
    $langs[$l] = $l;
}
$user_id = Session::instance()->get('user_id');
?>
<script type="text/javascript">
    $(function(){
        jQuery("#toolbar").jqGrid({
            url:'/admin/site/customer/data',
            datatype: "json",
            height: 400,
            width: 1250,
            colNames:['Selected','ID','Email','Name','Affiliate Level', 'Commissions', 'Pending Commissions', 'Points', 'Order Total', 'FB','Created On','Orders','Ip','Ip Country','Vip','users_admin','Lang','flag','Action'],
            colModel:[
                {name:'selectall',align:'center',search:false,formatter:actionSelect,index:false,width:40},
                {name:'customer_id',index:'id', width:40},
                {name:'customer_email',index:'email', width:150,formatter:actionFilter},
                {name:'customer_name',index:'name',width:100},
                {name:'customer_level', index:'affiliate_level',width:80}, 
                {name:'customer_commissions', index:'commissions',width:80}, 
                {name:'customer_commissions_pending', index:'commissions_pending',width:100,search:false,sortable:false}, 
                {name:'customer_points', index:'points',width:50}, 
                {name:'customer_order_total', index:'order_total',width:80}, 
                {name:'is_facebook',index:'is_facebook',width:30},
                {name:'created',index:'created',width:80},
                {name:'customer_orders', index:'orders',width:50},
                {name:'customer_ip', index:'ip',width:100},
                {name:'ip_country', index:'ip_country',width:50},
                {name:'is_vip',index:'is_vip',width:60},
                {name:'users_email',index:'users_email',width:60},
                {name:'lang',index:'lang',width:60,stype:'select',searchoptions:{value:<?php echo "'" . str_replace(array('"', '{', '}', ','), array('', '', '', ';'), json_encode(array('' => '') + $langs)) . "'"; ?>}},
                {name:'flag',index:'flag',width:60},
                {search:false,formatter:actionFormatter}
            ],
            rowNum:20,
            rowList : [20,30,50],
            mtype: "POST",
            gridview: true,
            pager: '#ptoolbar',
            sortname: 'id',
            viewrecords: true,
            sortorder: "desc",
            gridComplete: function () {
                $("table:first").find("tr:last").find("th:first").find("div").html("Select All<input id='selectall' type='checkbox'>");
                $("#selectall").click(function(){
                    $("#selectall").attr('checked') == true?$("input[name='orders[]']").each(function(){$(this).attr("checked", true)}):$("input[name='orders[]']").each(function(){$(this).attr("checked", false)});
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
		
    });

    function actionSelect(cellvalue,options,rowObject){
        return '<input type="checkbox" name="orders[]" value ="'+rowObject[1]+'" >';
    }
    function actionFormatter(cellvalue,options,rowObject) {
        return '<a href="/admin/site/customer/edit/' + rowObject[1] + '">Edit</a>'
            + ' <a href="javascript:remote_login(' + rowObject[1] + ')">Login</a>'
            <?php if(User::instance($user_id)->get('role_id') == 0) { ?>+ ' <a href="javascript:delete_user('+rowObject[1]+')">Delete</a>'<?php } ?>
            + ' <a href="javascript:reset_pwd(' + rowObject[1] + ')" style="color:green;">#Reset</a>';
    }

    function actionFilter(cellvalue,options,rowObject) {
        return $('<div/>').text(cellvalue).html();
    }

    function remote_login(customer_id)
    {
        $.ajax({
            url: '/admin/site/customer/login/'+customer_id, 
            type: 'GET', 
            dataType: 'json', 
            success: function (data) {
                $('#frm_remote_login').attr('action', data.action);
                document.getElementById('frm_remote_login').email.value = data.email;
                document.getElementById('frm_remote_login').password.value = data.password;
                $('#frm_remote_login').submit();
            }
        });
    }

    function delete_user(customer_id)
    {
        if (!window.confirm('确定要删除该用户？'))
        {
            return false;
        }

        $.ajax({
            url: '/admin/site/customer/delete/'+customer_id, 
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

    function reset_pwd(customer_id)
    {
        if (!window.confirm('确定要重置该用户的密码？'))
        {
            return false;
        }

        $.ajax({
            url: '/admin/site/customer/resetpwd/'+customer_id, 
            type: 'GET', 
            success: function (data) {
                if (data == 'success') {
                    window.alert('该用户的密码被重置为：123456');
                    $('#toolbar').trigger('reloadGrid');
                } else {
                    window.alert(data);
                }
            }
        });
    }
</script>
<div id="do_content">
    <form id="frm_remote_login" method="post" action="" target="_blank">
        <input type="hidden" name="hashed" value="TRUE" />
        <input type="hidden" name="email" value="" />
        <input type="hidden" name="password" value="" />
    </form>
    <div class="box" style="overflow:hidden;">
        <h3>Customers

            <span class="moreActions">
                <a href="/admin/site/customer/orders">Customer Orders</a>
            </span>

        </h3>
        <fieldset>
            <h4>用户统计：</h4>
            <table>
                <tr><td>时间:</td>
                    <?php
                    foreach ($dates as $date)
                    {
                        echo '<td>' . $date . '</td>';
                    }
                    ?>
                </tr>
                <tr><td>当日注册:</td>
                    <?php foreach ($customers_statistics['today_register'] as $date => $count): ?>
                        <?php echo "<td><strong>$count</strong> &nbsp;</td>"; ?>
                    <?php endforeach ?>
                </tr>
                <tr><td>当日登录:</td>
                    <?php foreach ($customers_statistics['today_login'] as $date => $count): ?>
                        <?php echo "<td><strong>$count</strong> &nbsp;</td>"; ?>
                    <?php endforeach ?>
                </tr>
                <tr><td>注册用户总数:</td>
                    <?php foreach ($customers_statistics['register_allcount'] as $date => $count): ?>
                        <?php echo "<td><strong>$count</strong> &nbsp;</td>"; ?>
                    <?php endforeach ?>
                </tr>

            </table>
        </fieldset>
        <fieldset style="text-align:right">
            <legend style="font-weight:bold">Export Customers</legend>
            <form id="frm-customer-export" method="post" action="/admin/site/customer/export" target="_blank">
                <label for="point-from">Point FROM</label>
                <input type="text" name="point_from" id="point-from" class="ui-widget-content ui-corner-all" />
                <label for="point-to">Point To: </label>
                <input type="text" name="point_to" id="point-from" class="ui-widget-content ui-corner-all" />
                &nbsp;
                <label for="export-start">From: </label>
                <input type="text" name="start" id="export-start" class="ui-widget-content ui-corner-all" />
                <label for="export-end">To: </label>
                <input type="text" name="end" id="export-end" class="ui-widget-content ui-corner-all" />
                &nbsp;&nbsp;&nbsp;
                <label for="is_fb">Is_facebook: </label>
                <input type="checkbox" name="is_fb" id="is_fb" class="ui-widget-content ui-corner-all" />
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" value="Export" name="submit" class="ui-button" style="padding:0 .5em" />
                <input type="submit" value="Export_ip" name="submit" class="ui-button" style="padding:0 .5em" />
            </form>
            <div style="margin-top:10px;">
                <form method="post" action="/admin/site/customer/export_by_country">
                    <span style="color: #222;font-size: 16px;border-bottom: 1px dotted #e8e8e8;">Export By Country</span>&nbsp;&nbsp;&nbsp;
                    <label>Type: </label>
                    <select name="type">
                        <option value="register">Register</option>
                        <option value="order">Order</option>
                    </select>&nbsp;&nbsp;&nbsp;
                    <label>Country Code: </label>
                    <input type="text" name="country" id="country" class="ui-widget-content ui-corner-all" />
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="export-start">From: </label>
                    <input type="text" name="start" id="export-start1" class="ui-widget-content ui-corner-all" />
                    <label for="export-end">To: </label>
                    <input type="text" name="end" id="export-end1" class="ui-widget-content ui-corner-all" />
                    &nbsp;&nbsp;&nbsp;
                    <input type="submit" value="Export" class="ui-button" style="padding:0 .5em" />
                </form>
            </div>
            <div style="margin-top:10px;">
                <form method="post" action="/admin/site/customer/export_by_wishlist_not_payment">
                    <span style="color: #222;font-size: 16px;border-bottom: 1px dotted #e8e8e8;">Wishlist buy none</span>&nbsp;&nbsp;&nbsp;
                    
                    <input type="submit" value="Export" class="ui-button" style="padding:0 .5em" />
                </form>
            </div>
            <div style="margin-top:10px;">
                <form method="post" action="/admin/site/customer/add_cart">                    
                    <input type="submit" value="Export customer add cart" class="ui-button" style="padding:0 .5em" />
                </form>
            </div>
            <div style="float:right;margin-top:10px;">
                <a href="/admin/site/customer/vip" target="_blank">Vip用户列表</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="/admin/site/customer/export_vip" target="_blank"><button>导出VIP用户</button></a>
            </div>
        </fieldset>
        <script type="text/javascript">
            $('#export-start, #export-end, #export-start1, #export-end1').datepicker({
                'dateFormat': 'yy-mm-dd'
            });
            $(function(){
                $("#frm-customer-export").submit(function(){
                    var start = $("#export-start").val();
                    var end = $("#export-end").val();
                    if(!start && !end)
                    {
                        if (!window.confirm('确定要导出所有的用户吗？'))
                        {
                            return false;
                        }
                    }
                })
            })
        </script>
        <?php echo Form::open('admin/site/sendmail/index'); ?>
        <table id="toolbar"></table>
        <?php
        echo Form::select('mail_type', $mail_type);
        echo Form::submit('submit', '发送邮件');
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a target="_blank" href="/admin/site/wishlist/list">Wishlist</a>';
        echo Form::close();
        ?>
        <div id="ptoolbar"></div>
        <div>
            <fieldset>
                <div style="width:460px;float:left;">
                    <h4>
                        批量打积分
                        <!-- <div style="float:right;"><a href="/admin/site/customer/vip_add" target="_blank"><button>批量vip处理</button></a></div> -->
                    </h4>
                    <form action="/admin/site/customer/import_points" method="post">
                        <div><span style="color:#FF0000"></span>一行一个Email</div>
                        <div>
                            <textarea name="EmalARR" cols="40" rows="20"></textarea>       
                        </div>
                        Points: <input type="text" name="points" value="" />
                        Type: 
                        <select id="point_type" name="type">
                            <option value="">Select Type</option>
                            <?php
                            $types = Kohana::config('points.type');
                            foreach ($types as $type):
                                ?>
                                <option value="<?php echo $type['name']; ?>"><?php echo $type['brief']; ?></option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                        <input type="submit" value="Submit">   
                    </form>
                    <!-- <div style="float:right;"><a href="/admin/site/customer/birth_points" target="_blank"><button>批量生日送积分</button></a></div> -->

                <br/>
                <!-- <div><a href="/admin/site/customer/wishlist_mail" target="_blank"><button>批量Wishlist邮件发送</button></a></div> -->
                <br/>
                <div><a href="/admin/site/customer/coupon_mail" target="_blank"><button>将过期折扣号提醒邮件发送</button></a></div>
                    <!-- <div style="float:right;"><a href="/admin/site/customer/update_country" target="_blank"><button>批量更新ip国家</button></a></div> -->
                </div>
                <div  style="width:400px;float:left;">
                    <h4>
                        用户批量加flag=3的标记
                    </h4>
                    <form action="/admin/site/customer/import_flag" method="post">
                        <div><span style="color:#FF0000"></span>一行一个Email</div>
                        <div>
                            <textarea name="EmalARR" cols="40" rows="20"></textarea>
                        </div>
                        <input type="submit" value="Submit">
                    </form>
                </div>
                <div  style="width:300px;float:left;">
                    <h4>
                        新开发批发客批量录入
                    </h4>
                    <form action="/admin/site/customer/import_coustomers_flag" method="post">
                        <div><span style="color:#FF0000"></span>一行一个Email</div>
                        <div>
                            <textarea name="EmalARR" cols="40" rows="20"></textarea>
                        </div>
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </fieldset>
        </div>

                <!-- 添加于2015、9、15 -->
        <div>
            <fieldset>
                <h4>循环导入数据</h4>
                <form method="post" action="/admin/site/customer/memerin" enctype="multipart/form-data">
                <div>
                    <h4>大批量导入数据</h4>
                    <span>请选择csv文件：</span><input type="file" name="tb_file"/>
                    <input type="submit" value="开始执行" />
                </div>
                </form>
            </fieldset>
        </div>
        <!-- 添加于2016、3、14 -->
        <div>
            <fieldset>
				<h4>2016年下单用户</h4>
				<form style="margin:20px;" method="post" action="/admin/site/customer/newvip1" enctype="multipart/form-data">
                <div>
                    <input type="submit" value="开始执行" class="ui-button" style="padding:0 .5em" />
                </div>
                </form>
				<br/>
				<br/>
				<br/>
				<!--
				<div style="margin-top:10px;">
					<form method="post" action="/admin/site/customer/export_by_country">
						<span style="color: #222;font-size: 16px;border-bottom: 1px dotted #e8e8e8;">Export By Country</span>&nbsp;&nbsp;&nbsp;
						<label>Type: </label>
						<select name="type">
							<option value="register">Register</option>
							<option value="order">Order</option>
						</select>&nbsp;&nbsp;&nbsp;
						<label>Country Code: </label>
						<input type="text" name="country" id="country" class="ui-widget-content ui-corner-all" />
						&nbsp;&nbsp;&nbsp;&nbsp;
						<label for="export-start">From: </label>
						<input type="text" name="start" id="export-start1" class="ui-widget-content ui-corner-all" />
						<label for="export-end">To: </label>
						<input type="text" name="end" id="export-end1" class="ui-widget-content ui-corner-all" />
						&nbsp;&nbsp;&nbsp;
						<input type="submit" value="Export" class="ui-button" style="padding:0 .5em" />
					</form>
				</div>
				-->
				<h4>所有会员导出</h4>
				<form style="margin:20px;" method="post" action="/admin/site/customer/getvipall" target="_blank">
					<label for="export-start">From: </label>
                    <input type="text" name="start" id="export-start3" class="ui-widget-content ui-corner-all" />
                    <label for="export-end">To: </label>
                    <input type="text" name="end" id="export-end3" class="ui-widget-content ui-corner-all" />
                    <input type="submit" value="按时间导出所有会员" class="ui-button" style="padding:0 .5em">
                </form>
				<br/>
				<br/>
				
				<form style="margin:20px;" method="post" action="/admin/site/customer/getvipallone" target="_blank">
                    <input type="submit" value="导出所有会员" class="ui-button" style="padding:0 .5em">
                </form>
				<br/>
				<form style="margin:20px;" method="post" action="/admin/site/customer/getvipallone1" target="_blank">
                    <input type="submit" value="导出现在有效的vip用户" class="ui-button" style="padding:0 .5em">
                </form>
				<br/>
				<form style="margin:20px;" method="post" action="/admin/site/customer/wpvipsendemail" target="_blank">
                    <input type="submit" value="wp_vip会员发送邮件" class="ui-button" style="padding:0 .5em">
                </form>
				<!--
				<br/>
				<br/>
				<br/>
				<h4>按具体时间导出vip用户表</h4>
				<form style="margin:20px;" method="post" action="/admin/site/customer/getnewvip" target="_blank">
                    <input type="submit" value="按具体时间导出vip用户表" class="ui-button" style="padding:0 .5em">
                </form>
				-->
				<br/>
				<br/>
				<br/>
				<h4>按到期时间导表</h4>
				<form action="/admin/site/customer/getnewvip" method="post" target="_blank">
                        Type: 
                        <select id="vip_type" name="vip_type">
                                <option value="6">还剩6个月会员到期时间的用户</option>
                                <option value="3">还剩3个月会员到期时间的用户</option>
                                <option value="1">还剩1个月会员到期时间的用户</option>
                        </select>
                        <input type="submit" value="导出会员">   
                    </form>
            </fieldset>
        </div>
		
		
		<!--判断用户权限权限-->
		<?php
			$user = User::instance()->logged_in();
			$user_arr = array("1","120","125","175","375");
			if(in_array($user['id'], $user_arr)){
		?>
		<!--用户表分配admin-->
		<div>
            <fieldset>
                <div>
                    <h4>
                        批量分配用户admin(负责人)
                        <!-- <div style="float:right;"><a href="/admin/site/customer/vip_add" target="_blank"><button>批量vip处理</button></a></div> -->
                    </h4>
                    <form action="/admin/site/customer/user_admin" method="post">
                        <div><span style="color:#FF0000"></span>一行一个用户邮箱(尾部不要加换行)</div>
                        <div>
                            <textarea name="emailARR" cols="40" rows="20"></textarea>       
                        </div>
						<div style="display:none" id="tag"><?php
							$user_email = DB::select('email')->from('auth_user')->where('created', '>', 0)->where('role_id','>',1)->execute('slave')->as_array();
							$user_str="";
							foreach($user_email as $k=>$v){
								$user_str.='"'.$v['email'].'"'.",";
							}
							$user_str = substr($user_str,0,strlen($user_str)-1); 
							echo "[".$user_str."]";
						?>
						</div>
                        admin(负责人)邮箱: 
                        <div class="ui-widget">
						  <input name="user_email">
						</div>
                        <input type="submit" value="Submit">   
                    </form>
                    <!-- <div style="float:right;"><a href="/admin/site/customer/birth_points" target="_blank"><button>批量生日送积分</button></a></div> -->
                </div>
				<script>
					$(function(){
						var availableTags=$("#tag").text();
						//var availableTags=[""];
						jQuery.trim(availableTags);
						console.log(availableTags);
						$( "#tags" ).autocomplete({
						  source: availableTags
						});
					})
				</script>
                <br/>
                <br/>
            </fieldset>
        </div>
		<?php
			}
		?>
				
		<h4>导出所有用户订单</h4>
				<form style="margin:20px;" method="post" action="/admin/site/customer/get1emailorder" target="_blank">
					<label for="export-start">From: </label>
                    <input type="text" name="start" id="export-start5" class="ui-widget-content ui-corner-all" />
                    <label for="export-end">To: </label>
                    <input type="text" name="end" id="export-end5" class="ui-widget-content ui-corner-all" /><div>
                    <input type="submit" value="导出所有用户订单" class="ui-button" style="padding:0 .5em">
                </form>		
		</div>		
		<br/>
		<br/>
		<h4>Admin销售统计表字段</h4>
				<form style="margin:20px;" method="post" action="/admin/site/customer/getadminorder" target="_blank">
					<label for="export-start">From: </label>
                    <input type="text" name="start" id="export-start6" class="ui-widget-content ui-corner-all" />
                    <label for="export-end">To: </label>
                    <input type="text" name="end" id="export-end6" class="ui-widget-content ui-corner-all" /><div>
                    <input type="submit" value="导出所有用户订单" class="ui-button" style="padding:0 .5em">
                </form>		
    
	<script>
	$('#export-start2, #export-end2,#export-start3,#export-end3,#export-start1,#export-end1,#export-start4,#export-end4,#export-start5,#export-end5,#export-start6,#export-end6').datepicker({
                'dateFormat': 'yy-mm-dd'
	});
	</script>
</div>
