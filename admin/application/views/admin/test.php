<?php
/**
 * 测试用的 上传/选择图片（或其它类型文件）页面
 *文本框用来返回上传/选择的文件信息
 * 复用约定：
 * >页面中可包含多个"add image"按钮，每个按钮后面跟着一个（隐藏的）文本框，用来存储用户上传或选取的文件名。文本框名称任意。
 * >页面中必须包含div#image_box, div里面各个id名称不要变动。ul里面的相册ajax地址替换掉（href="ajax"）。
 * >注意js中的注释。
 * >ajax页面参照view/test_ajax_gallery.php
 * @package
 * @author    FangHao
 * @copyright    © 2010 Cofree Development Group
 */

?>
<div id="do_content">
	<script type="text/javascript" src="/media/js/jquery.uploadify/swfobject.js"></script>
	<script type="text/javascript" src="/media/js/jquery.uploadify/jquery.uploadify.v2.1.0.js"></script>
	<style type="text/css">
		.uploadifyQueueItem {
			font: 11px Verdana, Geneva, sans-serif;
			border: 2px solid #E5E5E5;
			background-color: #F5F5F5;
			margin-top: 5px;
			padding: 10px;
			width: 350px;
		}
		.uploadifyError {
			border: 2px solid #FBCBBC !important;
			background-color: #FDE5DD !important;
		}
		.uploadifyQueueItem .cancel {
			float: right;
		}
		.uploadifyProgress {
			background-color: #FFFFFF;
			border-top: 1px solid #808080;
			border-left: 1px solid #808080;
			border-right: 1px solid #C5C5C5;
			border-bottom: 1px solid #C5C5C5;
			margin-top: 10px;
			width: 100%;
		}
		.uploadifyProgressBar {
			background-color: #0099FF;
			width: 1px;
			height: 3px;
		}
		#fileQueue .uploadifyQueueItem {
			font: 11px Verdana, Geneva, sans-serif;
			border: none;
			border-bottom: 1px solid #E5E5E5;
			background-color: #FFFFFF;
			padding: 5%;
			width: 90%;
		}
		#fileQueue .uploadifyError {
			background-color: #FDE5DD !important;
		}
		#fileQueue .uploadifyQueueItem .cancel {
			float: right;
		}
	</style>
	<script type="text/javascript" language="javascript">
		$(function(){
			$('#image_box').dialog({
				autoOpen: false,
				title : '添加图片',
				height:500,
				width:750
			});
		});
		$(function(){
			$('#do_upload').uploadify({
				'uploader': '/media/js/jquery.uploadify/uploadify.swf',
				'script': '/test/upload',//改成具体的处理图片上传的url
				'folder': '/uploads',//改成具体文件夹
				'cancelImg': '/media/js/jquery.uploadify/cancel.png',
				'queueID':'uploadQueue',
				'fileExt':'*.jpg;*.gif',//此处及下一行改成具体的文件扩展名
				'fileDesc':'*.jpg;*.gif',
				'buttonText':'Browse',
				'onComplete':function(event, ID, fileObj, response, data) {
					var re_json = eval('(' + response + ')');
					if (re_json['status'] == 1) {
						jQuery("#do_upload" + ID + " .percentage").text(' - \u4e0a\u4f20\u6210\u529f\uff01');
						$('#' + $('#image_box').attr('image_for')).val('你上传了:' + re_json['filename']);//此处 "'你上传了:' + " 仅供测试，请去掉
						jQuery("#do_upload" + ID).fadeOut(500, function() { jQuery(this).remove()});
					}else if (re_json['status'] == 2){
						jQuery("#do_upload" + ID + " .percentage").text(' - Upload failed: file type must be "' + re_json['filetypes'].join('" or "') + '"');
					}//此处根据返回的status值不同，显示不同的报错信息，有待扩展
					return false;
				}
			});
			$('#upload_btn').click(function(){
				$('#do_upload').uploadifyUpload();
				return false;
			});
			$('#image_box').tabs({
				ajaxOptions: {
					error: function(xhr, status, index, anchor) {
						$(anchor.hash).html("Couldn't load this tab. We'll try to fix this as soon as possible. If this wouldn't be a demo.");
					},
					cache:false
				}
			});
			$('#open_image').button().click(function(){
				$('#image_box').attr('image_for',$(this).next().attr('id')).dialog('open');
			});
		});
	</script>

        <div class="box">
		<h3>Form Sample</h3>
		<button id="open_image">Add An Image</button>
		<input type="text" name="image_name" size="100" id="image_name" value="图片信息" />
		<br /><br /><br />
        </div>
</div>

<div id="image_box">
	<ul>
		<li><a href="#upload_box">上传新图</a></li>
		<li><a href="ajax">从相册中挑选</a></li>
	</ul>

	<div id="upload_box">
		<input type="file" id="do_upload" name="do_upload"/>
		<div id="uploadQueue"></div>
		<button id="upload_btn">Upload</button>
	</div>
</div>