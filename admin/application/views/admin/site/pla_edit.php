

<form action="add" method="post">

<table>
<?php if($lists[0]){ ?>

<input type="hidden" name='id' value="<?php echo $lists[0]['id']?>"></input>

<input type="hidden" name='pla' value="edit"></input>
	<tr><td>country:</td><td>
		<select name="country">
			<option value="US" <?php if($lists[0]['country']=='US'){echo "selected='selected'";}?>>US</option>
			<option value="UK" <?php if($lists[0]['country']=='UK'){echo "selected='selected'";}?>>UK</option>
			<option value="AU" <?php if($lists[0]['country']=='AU'){echo "selected='selected'";}?>>AU</option>
			<option value="CA" <?php if($lists[0]['country']=='CA'){echo "selected='selected'";}?>>CA</option>
			<option value="FR" <?php if($lists[0]['country']=='FR'){echo "selected='selected'";}?>>FR</option>
			<option value="ES" <?php if($lists[0]['country']=='ES'){echo "selected='selected'";}?>>ES</option>
			<option value="DE" <?php if($lists[0]['country']=='DE'){echo "selected='selected'";}?>>DE</option>
			</select></td></tr>
	<tr><td>feed:</td><td><input type="text" name='feed'value="<?php echo $lists[0]['feed']?>"></input></td></tr>
	<tr><td>id:</td><td><input type="text" name="uid" value="<?php echo $lists[0]['uid']?>"></input></td></tr>
	<tr><td>title:</td><td>开头<input type="text" name="title1" value="<?php echo $lists[0]['title'][0]?>"></input>
			&nbsp;&nbsp;&nbsp;&nbsp;
		结尾<input type="text" name="title2" value="<?php echo $lists[0]['title'][1]?>"></input>
	</td></tr>
	<tr><td>description:</td><td>开头<input type="text" name="description1"  value="<?php echo $lists[0]['description'][0]?>"></input>
			&nbsp;&nbsp;&nbsp;&nbsp;
		结尾<input type="text" name="description2"  value="<?php echo $lists[0]['description'][1]?>"></input>
	</td></tr>
	<tr><td>custom_label_0:</td>
		<td><select name="custom_label_0">
			<option value="1" <?php if($lists[0]['custom_label_0']=='1'){echo "selected='selected'";}?>>颜色</option>
			<option value="2" <?php if($lists[0]['custom_label_0']=='2'){echo "selected='selected'";}?>>分类</option>
			<option value="3" <?php if($lists[0]['custom_label_0']=='3'){echo "selected='selected'";}?>>价格范围</option>
			<option value="4" <?php if($lists[0]['custom_label_0']=='4'){echo "selected='selected'";}?>>爆款</option>
			<option value="5" <?php if($lists[0]['custom_label_0']=='5'){echo "selected='selected'";}?>>自定义</option>
		</select> </td></tr>
	<tr><td>custom_label_1:</td><td>
		<select name="custom_label_1">
			<option value="1" <?php if($lists[0]['custom_label_1']=='1'){echo "selected='selected'";}?>>颜色</option>
			<option value="2" <?php if($lists[0]['custom_label_1']=='2'){echo "selected='selected'";}?>>分类</option>
			<option value="3" <?php if($lists[0]['custom_label_1']=='3'){echo "selected='selected'";}?>>价格范围</option>
			<option value="4" <?php if($lists[0]['custom_label_1']=='4'){echo "selected='selected'";}?>>爆款</option>
			<option value="5" <?php if($lists[0]['custom_label_1']=='5'){echo "selected='selected'";}?>>自定义</option>
		</select> 
	</td></tr>
	<tr><td>custom_label_2:</td><td><select name="custom_label_2">
			<option value="1" <?php if($lists[0]['custom_label_2']=='1'){echo "selected='selected'";}?>>颜色</option>
			<option value="2" <?php if($lists[0]['custom_label_2']=='2'){echo "selected='selected'";}?>>分类</option>
			<option value="3" <?php if($lists[0]['custom_label_2']=='3'){echo "selected='selected'";}?>>价格范围</option>
			<option value="4" <?php if($lists[0]['custom_label_2']=='4'){echo "selected='selected'";}?>>爆款</option>
			<option value="5" <?php if($lists[0]['custom_label_2']=='5'){echo "selected='selected'";}?>>自定义</option>
		</select> </td></tr>
	<tr><td>custom_label_3:</td><td><select name="custom_label_3">
			<option value="1" <?php if($lists[0]['custom_label_3']=='1'){echo "selected='selected'";}?>>颜色</option>
			<option value="2" <?php if($lists[0]['custom_label_3']=='2'){echo "selected='selected'";}?>>分类</option>
			<option value="3" <?php if($lists[0]['custom_label_3']=='3'){echo "selected='selected'";}?>>价格范围</option>
			<option value="4" <?php if($lists[0]['custom_label_3']=='4'){echo "selected='selected'";}?>>爆款</option>
			<option value="5" <?php if($lists[0]['custom_label_3']=='5'){echo "selected='selected'";}?>>自定义</option>
		</select> </td></tr>
	<tr><td>custom_label_4:</td><td><select name="custom_label_4">
			<option value="1" <?php if($lists[0]['custom_label_4']=='1'){echo "selected='selected'";}?>>颜色</option>
			<option value="2" <?php if($lists[0]['custom_label_4']=='2'){echo "selected='selected'";}?>>分类</option>
			<option value="3" <?php if($lists[0]['custom_label_4']=='3'){echo "selected='selected'";}?>>价格范围</option>
			<option value="4" <?php if($lists[0]['custom_label_4']=='4'){echo "selected='selected'";}?>>爆款</option>
			<option value="5" <?php if($lists[0]['custom_label_4']=='5'){echo "selected='selected'";}?>>自定义</option>
		</select> </td></tr>
	<tr><td>custom_label自定义内容</td><td><input name="zdy" type="text" placeholder="自定义"  value='<?php echo $lists[0]['custom_label']?>'></input></td></tr>
	<tr><td>promotion:</td><td><input type="text" name="promotion" placeholder="自定义" value="<?php echo $lists[0]['promotion']?>"></input></td></tr>
	<tr><td>lang:</td><td><input type="text" name="lang" placeholder="自定义"  value="<?php echo $lists[0]['lang']?>"></input></td></tr>
<?php }else{ ?>
<input type="hidden" name='pla' value="add"></input>
		<tr><td>country:</td><td>
		<select name="country">
			<option value="US">US</option>
			<option value="UK">UK</option>
			<option value="AU">AU</option>
			<option value="CA">CA</option>
			<option value="FR">FR</option>
			<option value="ES">ES</option>
			<option value="DE">DE</option>
			</select></td></tr>
	<tr><td>feed:</td><td><input type="text" name='feed'></input></td></tr>
	<tr><td>id:</td><td><input type="text" name="uid" ></input></td></tr>
	<tr><td>title:</td><td>开头<input type="text" name="title1" ></input>
			&nbsp;&nbsp;&nbsp;&nbsp;
		结尾<input type="text" name="title2" ></input>
	</td></tr>
	<tr><td>description:</td><td>开头<input type="text" name="description1"  ></input>
			&nbsp;&nbsp;&nbsp;&nbsp;
		结尾</input><input type="text" name="description2"  ></input>
	</td></tr>
	<tr><td>custom_label_0:</td>
		<td><select name="custom_label_0">
			<option value="1">颜色</option>
			<option value="2">分类</option>
			<option value="3">价格范围</option>
			<option value="4">爆款</option>
			<option value="5">自定义</option>
		</select> </td></tr>
	<tr><td>custom_label_1:</td><td>
		<select name="custom_label_1">
			<option value="1">颜色</option>
			<option value="2">分类</option>
			<option value="3">价格范围</option>
			<option value="4">爆款</option>
			<option value="5">自定义</option>
		</select> 
	</td></tr>
	<tr><td>custom_label_2:</td><td><select name="custom_label_2">
			<option value="1">颜色</option>
			<option value="2">分类</option>
			<option value="3">价格范围</option>
			<option value="4">爆款</option>
			<option value="5">自定义</option>
		</select> </td></tr>
	<tr><td>custom_label_3:</td><td><select name="custom_label_3">
			<option value="1">颜色</option>
			<option value="2">分类</option>
			<option value="3">价格范围</option>
			<option value="4">爆款</option>
			<option value="5">自定义</option>
		</select> </td></tr>
	<tr><td>custom_label_4:</td><td><select name="custom_label_4">
			<option value="1">颜色</option>
			<option value="2">分类</option>
			<option value="3">价格范围</option>
			<option value="4">爆款</option>
			<option value="5">自定义</option>
		</select> </td></tr>
	<tr><td>custom_label自定义内容</td><td><input name="zdy" type="text" placeholder="自定义"></input></td></tr>
	<tr><td>promotion:</td><td><input type="text" name="promotion" placeholder="自定义" ></input></td></tr>
	<tr><td>lang:</td><td><input type="text" name="lang" placeholder="自定义" ></input></td></tr>
<?php }?>
	<tr><td><input type="submit" value="提交"></input></td></tr>
</table>
</form>
<script type="text/javascript">
$('form').submit(function(){

	
	$feed=$("input[name='feed']").val()
	$uid=$("input[name='uid']").val()



	if( !$feed && !$uid ){
		alert('至少输入feed!');
		return false;
	}
	if(!$feed){
		alert('feed为必填!');

		return false;
	}


});
	
	
</script>
