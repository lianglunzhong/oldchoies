<div id="do_content">
<div class="box">
<h3>
添加产品 / 选择产品过滤属性
</h3>
<form method="post" action="#">
<input type="hidden" name="set_id" value="<?php echo $set_id; ?>" />
<input type="hidden" name="type" value="<?php echo $type; ?>" />

<p>产品过滤属性选择(至少选择一个)</p>
<ul>
<?php
foreach($attributes as $attribute)
{
?>
<li>
<div>
<input type="checkbox" name="p_attrs[]" value="<?php echo $attribute->id; ?>" />&nbsp;<?php echo $attribute->name; ?> (<?php echo $attribute->brief; ?>)
</div>
</li>
<?php
}
?>

<li>
<input value="下一步" class="button" type="submit" />
</li>

</ul>
</form>
</div>
