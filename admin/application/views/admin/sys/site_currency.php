<script type="text/javascript">
$(function(){

    $('.submit_remove').click(function(){
        $(this).parent().submit();
        return false;
    });

    $('.submit_move').click(function(){
        $('#'+$(this).parent().attr('name')+'').val($(this).attr('to'));
        $(this).parent().submit();
        return false;
    });

});
</script>

<div id="do_content">
<div class="box">
<h3>站点支持货币列表</h3>

<table>
<thead>
<tr>
<th scope="col">名称</th>
<th scope="col">汇率</th>
<th scope="col">符号</th>
<th scope="col" style="width:120px;">操作</th>
<th scope="col" style="width:80px;">排序</th>
</tr>
</thead>

<tbody>
<?php
if(isset($currencies) AND is_array($currencies)  AND count($currencies))
{
    $currencies_count = count($currencies);
    foreach($currencies as $key => $item)
    {
        $submit_uplink = ($key == 0) ? '<s>向上</s>' : '<a href="#" class="submit_move" to="up">向上</a>';
        $submit_downlink = ($key == ($currencies_count - 1)) ? '<s>向下</s>' : '<a href="#" class="submit_move" to="down">向下</a>';
?>
<tr>
<td><?php echo $item; ?></td>
<td><?php echo $sys_currencies[$item]['rate']; ?></td>
<td><?php echo $sys_currencies[$item]['code']; ?></td>
<td>
<form name="remove_currency_<?php echo $item; ?>" method="post" action="#">
<input type="hidden" name="currency_key" value="<?php echo $item; ?>" />
<input type="hidden" name="act" value="remove" />
<a href="#" class="submit_remove">移除</a>
</form>
</td>
<td>
<form name="order_currency_<?php echo $item; ?>" method="post" action="#">
<input type="hidden" name="act" value="order" />
<input type="hidden" name="currency_key" value="<?php echo $item; ?>" />
<input type="hidden" name="moving" id="order_currency_<?php echo $item; ?>"  value="" />
<?php echo $submit_uplink; ?>
&nbsp;
<?php echo $submit_downlink; ?>
</form>
</td>
</tr>
<?php
    }
}
?>
</tbody>
</table>

</div>

<div class="box">
<h3>货币列表</h3>

<form method="post" action="#" name="currency_add_form">
<ul>

<li>
<label>系统支持货币</label>
<div>
<input type="hidden" name="act" value="add" />
<select class="drop" name="currency_key">
<?php
$option_count = 0;
foreach($sys_currencies as $key => $item)
{
    if( ! in_array($key, $currencies))
    {
        $option_count ++;
?>
<option value="<?php echo $key; ?>"><?php echo $item['code'].' '.$key.'  汇率:'.$item['rate'] ?></option>
<?php
    }
}
if( ! $option_count)
{
    echo '<option value="-1">所有货币均已添加。</option>';
}
?>
</select>
</div>
</li>

<li>
<button type="submit">添加</button>
</li>


</ul>
</form>
</div>

</div>

