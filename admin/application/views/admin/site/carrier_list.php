<?php echo View::factory('admin/site/basic_left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>物流方式列表 （取自配置文件）</h3>
        <table id="do_property_table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">name</th>
                    <th scope="col">设置默认初始运费</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
<?php
if(is_array($shipping_price) && count($shipping_price) > 0)
{
    foreach($shipping_price as $key => $value)
    {
?>
            <input type="hidden" name="carrier_id[]" value="<?php echo $key;?>">
            <tr class="odd">
                <td><?php echo $key;?></td>
                <td><?php echo $carrier[$key]['name'];?></td>
                <td><?php echo $value;?></td>
                <td><a href="/admin/site/country/carrierdel/<?php echo $key;?>">删除</a></td>
            </tr>
<?php
    }
}
?>
            </tbody>
        </table>
    </div>
    <div class="box">
        <h3>物流方式列表</h3>

        <form method="post" action="#">
            <ul>
                <li>
                    <div>系统支持物流方式:
                        <select class="drop" name="carrier_id">
<?php
$option_count = 0;
foreach($carrier as $k => $v)
{
    if((is_array($shipping_price) && count($shipping_price) > 0 && !array_key_exists($k, $shipping_price)) || $shipping_price=='' )
    {
        $option_count ++;
?>
                            <option value="<?php echo $k; ?>"><?php echo $v['name'] ?></option>
<?php
    }
}
if( ! $option_count)
{
    echo '<option value="-1">所有物流方式都已添加。</option>';
}
?>
                        </select>
<?php if($option_count){?>
                    设置默认价格：<input type="text" name="price" size="5">
                    <input type="submit" value="新增">
<?php }?>
                    </div>
                </li>
            </ul>
        </form>
    </div>
</div>
