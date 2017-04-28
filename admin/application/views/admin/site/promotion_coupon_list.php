<?php echo View::factory('admin/site/promotion_left')->render(); ?>
<?php 
$coupon_types = array(
    1 => '减折扣', 
    2 => '减价', 
    3 => '赠品', 
    4 => '改价'); 
?>
<script type="text/javascript">
function tzset()
{   
    type=$("#coupon_set").val();
    if(type==0){
        url='coupon_list';
    }else{
      url='coupon_list?type='+type;  
    } 
    javascript:location.href=url;
}
</script>
<div id="do_right">
    <div class="box">
        <h3>站点折扣列表</h3>
        <div style="float:right;margin:5px">
                <strong>折扣用途：</strong>
                <select name="coupon_set" onchange="tzset();" id="coupon_set">
                <option value="0">ALL</option>
                        <?php foreach($coupons_sets as $coupons_set){ ?>
                            <option value="<?php echo $coupons_set['id']; ?>" <?php if(isset($_GET['type'])&&$coupons_set['id']==$_GET['type'])echo 'selected'; ?>><?php echo $coupons_set['name']; ?></option>
                        <?php } ?>
                </select>
        </div>
        <div style="float:right;margin:5px">
            <form action="" method="post">
                <strong>Email：</strong>
                <input type="text" name="email" value="<?php print $email; ?>" />
                <input type="submit" value="搜索" />
            </form>
        </div>
        <div style="float:right;margin:5px">
            <form action="" method="post">
                <strong>折扣号：</strong>
                <input type="text" name="search_code" value="<?php print $q; ?>" />
                <input type="submit" value="搜索" />
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">折扣号</th>
                    <th scope="col">折扣价(率)</th>
                    <th scope="col">折扣类型</th>
                    <th scope="col">可用次数</th>
                    <th scope="col">已使用次数</th>
                    <th scope="col">开始日期</th>
                    <th scope="col">结束日期</th>
                    <th scope="col">Admin</th>
                    <th scope="col">折扣来源</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $coupons_usedfor=array();
            foreach($coupons_sets as $v){
                $coupons_usedfor[$v['id']]=$v['name'];
            }
            ?>
                <?php foreach ($data as $item): ?>
                <tr <?php if ($item->expired <= time()) { print 'style="background:#BEC0C2"'; } ?>>
                    <td><?php print $item->id; ?></td>
                    <td><?php print $item->code; ?></td>
                    <td><?php print $item->value; ?></td>
					<?php
						if(!empty($coupon_types[$item->type])){
					?>
					<td><?php print $coupon_types[$item->type]; ?></td>
					<?php
						}
					?>
                    <td><?php print $item->limit == -1 ? '不限' : $item->limit; ?></td>
                    <td><?php print $item->used; ?></td>
                    <td><?php print date('Y-m-d', $item->created); ?></td>
                    <td><?php print date('Y-m-d', $item->expired); ?></td>
                    <td><?php print User::instance($item->admin)->get('name'); ?></td>
                    <td><?php print $item->usedfor?$coupons_usedfor[$item->usedfor]:''; ?></td>
                    <td>
                        <a href="/admin/site/promotion/coupon_edit/<?php echo $item->id; ?>">修改</a>
                        <a href="/admin/site/promotion/coupon_del/<?php echo $item->id; ?>" onclick="return window.confirm('delete?');">删除</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php print $page_view; ?>
        <button id="cuopon_delete" onclick="location.href='/admin/site/promotion/coupon_sinup_del';">批量删除注册折扣号</button>
        <div style="float:right;">
                <form action="/admin/site/promotion/coupon_orders" method="post" target="_blank">
                        <strong>折扣号：</strong>
                        <input type="text" name="search_code" value="" />
                        <input type="submit" value="搜索折扣号订单" />
                </form>
        </div>
    </div>
</div>
