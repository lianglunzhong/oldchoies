<?php
/**
 * 测试用的 ajax获取的图片列表页
 * 点击save按钮，将所选图片信息存到页面表单某处。
 * 复用约定：
 * >各处id不做变动。
 * >checkbox的value可自定义为图片名称、sku之类的东东
 * >注意js里面的注释
 * @package
 * @author    FangHao
 * @copyright    © 2010 Cofree Development Group
 */

?>
<style type="text/css">
	.image_select {
		float:left;
		margin:10px;
	}
	.image_select img{
		width:175px;
	}
</style>
<script type="text/javascript">
	$('#image_select_save').click(function(){
		var images = [];
		$('#gallery_images :checked').each(function(){
			images.push($(this).val() + '号图');//此处 "+ '号图'" 仅供测试，请去掉
		});
		if(images.length == 0){
			confirm('No image selected!');
			$('#' + $('#image_box').attr('image_for')).val('');
		}else{
			$('#' + $('#image_box').attr('image_for')).val('你选择了:' + images.join(','));//此处 "'你选择了:' + " 仅供测试，请去掉
			$('#image_box').dialog('close');
		}
	});
	$('#image_select_cancel').click(function(){
		$('#image_box').dialog('close');
	});
</script>
<div id="ajax_gallery">
	<div id="gallery_images">
		<div class="image_select">
			<img src="/uploads/0.jpg" />
			<input type="checkbox" value="1" name="image_checked" />
		</div>
		<div class="image_select">
			<img src="/uploads/0.jpg" />
			<input type="checkbox" value="2" name="image_checked" />
		</div>
		<div class="image_select">
			<img src="/uploads/0.jpg" />
			<input type="checkbox" value="3" name="image_checked" />
		</div>
		<div class="image_select">
			<img src="/uploads/0.jpg" />
			<input type="checkbox" value="4" name="image_checked" />
		</div>
		<div class="image_select">
			<img src="/uploads/0.jpg" />
			<input type="checkbox" value="5" name="image_checked" />
		</div>
		<div class="image_select">
			<img src="/uploads/0.jpg" />
			<input type="checkbox" value="6" name="image_checked" />
		</div>
		<div style="clear:both;"></div>
	</div>
	<button id="image_select_save">保存</button> <button id="image_select_cancel">取消</button>
	<div id="gallery_pagination">
		上一页 1 2 3 4 下一页
	</div>
</div>