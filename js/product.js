
/* ---------- DOM加载完毕 ---------- */
$(document).ready(function(){

/* ============================== 产品页 脚本 ============================== Begin */
	
	/* ---------- 产品页图片展示 gallery ---------- */
	
	var productPic = $('#JS_productPic');   //使用全局变量存储DOM，性能会更好

	/* 大图展示 popover-1.0 */
	productPic.popover({
		imgWrap:				".picbox",						//存放大图路径且包裹小图的元素的类名或者ID
		thumbnail:				"#JS_thumbnail",				//缩略图区域的类名或者ID
		thumbnailWidth:			75,								//缩略图的宽度
		thumbWidth:				80,								//弹出框中缩略图的宽度
		thumbMargin:			20,								//弹出框中缩略图区域与大图展示区域之间的距离
		overlayBgColor: 		"#555555",						//背景遮罩层的颜色
		overlayOpacity:			0.4,							//背景遮罩层半透明值
		popoverTop:				30,								//窗口与浏览器顶部的距离，建议用默认值
		windowControl:			10,								//控制弹出窗口的宽度，数字越大，宽度越大。建议用默认值
		cursorZoomIn:			"/images/zoom_in.cur",			//放大镜指针路径(放大)，建议用默认图片(由于项目正式上线后路由会重写，文件夹路径会发生变化，要在"iamges"前加"/",以保证路径正确)
		cursorZoomOut:			"/images/zoom_out.cur"			//放大镜指针路径(缩小)，其余同ZoomIn
	});
	
	/* 放大镜效果 zoom-1.2.3 */
	productPic.zoom({
		xzoom:400,
		yzoom:400,
		offset:10,
		// offsetTop:50,
		lens:1
	});
	
	/* 图片展示提示信息变化 (当页面有大图浏览时用此脚本，否则不用) */
	productPic.hover(function(){
		$("span.gallery_tips_item").remove();
		$("div.gallery_tips").append('<span class="gallery_tips_item gallery_tips_view">Click to open expanded view</span>');
	},function(){
		$("span.gallery_tips_item").remove();
		$("div.gallery_tips").append('<span class="gallery_tips_item gallery_tips_zoom">Roll over image to zoom in</span>');
	});
	
	/* 缩略图滚动 */
	$("#JS_thumbnailSlide").carousel({
		btnNext:"#JS_thumbnailNext",
		btnPrev:"#JS_thumbnailPrev",
		scrolls:1,
		circular: false,
		visible:5
	});

	jQuery.fn.loadthumb = function(options) {
		options = $.extend({
			 src : ""
		},options);
		var _self = this;
		_self.hide();
		var img = new Image();
		$(img).load(function(){
			_self.attr("src", options.src);
			_self.fadeIn("slow");
		}).attr("src", options.src); 
		return _self;
	}
	
	/* 缩略图切换 */
	var thumbItem = $("#JS_thumbnailSlide li");
	var small_img = 60;
	var mid_img = 400;
	thumbItem.first().addClass("selected");
	var thumbTimeHover,thumbTimeOut;
	thumbItem.hover(function(){
		var _this=$(this);
		clearTimeout(thumbTimeOut);
		thumbTimeHover = setTimeout(function(){
			_this.addClass("hover").siblings().removeClass("hover");
			// $("#picture").attr("src",_this.find('img').attr("imgb").replace(small_img + "x" + small_img,mid_img + "x" + mid_img));
			$("#picture").loadthumb({src:_this.find('img').attr("imgb")});
			$("#picture").parent("a").attr("href",_this.find('img').attr("bigimg").replace("_" + small_img + "x" + small_img,""));
		},150)
    },function(){
		var _this=$(this);
		_this.removeClass("hover");
		clearTimeout(thumbTimeHover);
		thumbTimeOut = setTimeout(function(){
			var _thumbSelectedImg = $("#JS_thumbnailSlide li.selected img");
			// $("#picture").attr("src",_thumbSelectedImg.attr("imgb").replace(small_img + "x" + small_img,mid_img + "x" + mid_img));
			$("#picture").loadthumb({src:_this._thumbSelectedImg.attr("imgb")});
			$(".bigimg").attr("src",_thumbSelectedImg.attr("bigimg").replace("_" + small_img + "x" + small_img,""));
		},100)
    })
	.click(function(){
		var _this=$(this);
		_this.addClass("selected").siblings().removeClass("selected");
		// $("#picture").parent("a").attr("href",$("#picture").attr("bigimg").replace("_" + mid_img + "x" + mid_img,""));
		return false;
	});
	
	$("#bigNext").click(function(){
		var imgNow = $("#picture").attr("src").replace(mid_img + "x" + mid_img,small_img + "x" + small_img);
		$(".thumbnail_list .list_item").each(function(index) {
			if($(this).find("img").attr("imgb") == imgNow ){
				var imgb = $(".thumbnail_list .list_item").eq(index+1).find("img").attr("imgb");
				if(typeof(imgb) == 'undefined')
				{
					index = -1;
					var imgb = $(".thumbnail_list .list_item").eq(index+1).find("img").attr("imgb");
				}
				var bigImg = $(".thumbnail_list .list_item").eq(index+1).find("img").attr("bigimg");
				// $("#picture").attr("src",imgb.replace(small_img + "x" + small_img,mid_img + "x" + mid_img));
				$("#picture").loadthumb({src:imgb});
				$("#picture").parent("a").attr("href",bigImg.replace("_" + small_img + "x" + small_img,""));
				$(".thumbnail_list .list_item").eq(index+1).addClass("selected").siblings().removeClass("selected");
			}
		});
	})
	$("#bigPrev").click(function(){
		var imgNow = $("#picture").attr("src").replace(mid_img + "x" + mid_img,small_img + "x" + small_img);
		$(".thumbnail_list .list_item").each(function(index) {
			if($(this).find("img").attr("imgb") == imgNow ){
				var imgb = $(".thumbnail_list .list_item").eq(index-1).find("img").attr("imgb");
				var bigImg = $(".thumbnail_list .list_item").eq(index-1).find("img").attr("bigimg")
				// $("#picture").attr("src",imgb.replace(small_img + "x" + small_img,mid_img + "x" + mid_img));
				$("#picture").loadthumb({src:imgb});
				$("#picture").parent("a").attr("href",bigImg.replace("_" + small_img + "x" + small_img,""));
				$(".thumbnail_list .list_item").eq(index-1).addClass("selected").siblings().removeClass("selected");
			}
		});
	})
	

/* ============================== 产品页 脚本 ============================== End */

	
});
