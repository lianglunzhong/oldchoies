
<a href="edit?id=0">新建</a>
<table>
<tr><td>国家</td><td>feed名称</td><td>feed url</td><td>操作</td><td></tr>
	<?php foreach( $lists as $list ){ ?>
	<tr>
		<td><?php echo $list['country'];?></td>
		<td><?php echo $list['feed'];?></td>
		<td>http://www.choies.com/googleproduct/choies_googleshopping_feed.<?php if($list['feed']){echo $list['feed'];}; if($list['country']!='US'){echo '.'.strtolower($list['country']);}?>.txt</td>
		<td><a href="edit?id=<?php echo $list['id']?>">编辑</a></td>
		<td><a href="get?id=<?php echo $list['id']?>&c=<?php echo $list['country']?>">立即获取</a></td>

	</tr>
	<?php }; ?>
</table>
<script type="text/javascript">


$('form').submit(function(){

	$country=$("input[name='country']").val()
	$feed=$("input[name='feed']").val()
	$uid=$("input[name='uid']").val()
	$title=$("input[name='title']").val()
	$description=$("input[name='description']").val()
	$custom_label_0=$("input[name='custom_label_0']").val()
	$custom_label_1=$("input[name='custom_label_1']").val()
	$custom_label_2=$("input[name='custom_label_2']").val()
	if(!$country && !$feed && !$uid && !$title && !$description && !$custom_label_0 && !$custom_label_1 && !$custom_label_2 ){
		alert('至少输入一项!');
		return false;
	}
	if(!$country){
		alert('country为必填!');

		return false;
	}
	
});
	
</script>