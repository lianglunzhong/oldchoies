<?php echo View::factory('admin/site/basic_left')->render(); ?>

<script type="text/javascript">
function addInterval(){
    var min = parseInt($("#interval").children().last().children('.max').val()) + 1;
    $("#delInterval").remove();
    $("#interval").append('<p><input value="'+min+'" size="4" disabled/> g ~ <input value="" size="4" name="intervals[]" class="max"/> g : <input value="" size="4" name="price[]"/> USD <span id="delInterval" onclick="return delInterval(this);">[ <a href="#">X</a> ]</span></p>');
}
function delInterval(obj){
    $(obj).parent().prev().append('<span id="delInterval" onclick="return delInterval(this);">[ <a href="#">X</a> ]</span>');
    $(obj).parent().remove();
}
</script>
<div id="do_right">
    <div class="box">
    <table>
        <thead>
        <tr>
            <th scope="col">物流方式</th>
            <th scope="col">物流名称</th>
            <th scope="col">重量区间及价格</th>
            <th scope="col">操作</th>
        </tr>
        </thead>
        <tbody>
<?php
foreach ($data as $key => $carrier):
    $interval_arr = unserialize($carrier['interval']);
?>
            <tr class="odd">
                <td><?php echo $carrier['carrier']; ?></td>
                <td><?php echo $carrier['carrier_name']; ?></td>
                <td>
<?php
if($interval_arr)
{
    foreach ($interval_arr as $key => $interval)
    {
        echo $key.' [g]'.'&nbsp;&nbsp;&nbsp;&nbsp;'.$interval.'USD'.'<br />';
    }
}
?>
            </td>
            <td><a href="/admin/site/carrier/delete/<?php echo $carrier['id']; ?>">删除</a></td>
        </tr>
<?php endforeach; ?>
        </tbody>
    </table>
    <form action="" method="POST">
        <table>
        <thead>
            <tr>
            <th scope="col">物流方式</th>
            <th scope="col">名称</th>
            <th scope="col">重量区间及价格</th>
            <th scope="col">选择</th>
            </tr>
        </thead>
        <tbody>
            <tr class="odd">
            <td>
                <select name="carrier">
                <?php foreach($carrier_defaults as $key => $carrier_default): ?>
                <option value="<?php echo $key; ?>"><?php echo $carrier_default['name']; ?></option>
                <?php endforeach; ?>
                </select>
            </td>
            <td><input value="" name="carrier_name"/></td>
            <td>
                <div id="interval">
                <p><input value="0" size="4" disabled/> g ~ <input value="" name="intervals[]" size="4" class="max"/> g : <input value="" name="prices[]" size="4"/> USD</p>
                </div>
                            [<a href="#" onclick="return addInterval();">添加新区间</a>]
            </td>
            <td><input type="submit" value="添加新物流"/></td>
            </tr>
        </tbody>
        </table>
    </form>
<?php	if(isset($country)):?>
    <table>
    <tr class="odd">
    <td>国家：<?php echo $country['name'];?></td>
    </tr>
    </table>
<?php endif;?>
    </div>
</div>
