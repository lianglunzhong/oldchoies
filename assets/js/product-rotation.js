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
		$(".thumbnail-list .list-item").each(function(index) {
			if($(this).find("img").attr("imgb") == imgNow ){
				var imgb = $(".thumbnail-list .list-item").eq(index+1).find("img").attr("imgb");
				if(typeof(imgb) == 'undefined')
				{
					index = -1;
					var imgb = $(".thumbnail-list .list-item").eq(index+1).find("img").attr("imgb");
				}
				var bigImg = $(".thumbnail-list .list-item").eq(index+1).find("img").attr("bigimg");
				// $("#picture").attr("src",imgb.replace(small_img + "x" + small_img,mid_img + "x" + mid_img));
				$("#picture").loadthumb({src:imgb});
				$("#picture").parent("a").attr("href",bigImg.replace("_" + small_img + "x" + small_img,""));
				$(".thumbnail-list .list-item").eq(index+1).addClass("selected").siblings().removeClass("selected");
			}
		});
	})
	$("#bigPrev").click(function(){
		var imgNow = $("#picture").attr("src").replace(mid_img + "x" + mid_img,small_img + "x" + small_img);
		$(".thumbnail-list .list-item").each(function(index) {
			if($(this).find("img").attr("imgb") == imgNow ){
				var imgb = $(".thumbnail-list .list-item").eq(index-1).find("img").attr("imgb");
				var bigImg = $(".thumbnail-list .list-item").eq(index-1).find("img").attr("bigimg")
				// $("#picture").attr("src",imgb.replace(small_img + "x" + small_img,mid_img + "x" + mid_img));
				$("#picture").loadthumb({src:imgb});
				$("#picture").parent("a").attr("href",bigImg.replace("_" + small_img + "x" + small_img,""));
				$(".thumbnail-list .list-item").eq(index-1).addClass("selected").siblings().removeClass("selected");
			}
		});
	})
	
});


(function(d){d.fn.carousel=function(e){e=d.extend({btnPrev:null,btnNext:null,btnGo:null,mouseWheel:false,auto:null,speed:200,easing:null,vertical:false,circular:true,visible:3,start:0,scrolls:1,beforeStart:null,onMouse:true,afterEnd:null},e||{});return this.each(function(){var n=false,l=e.vertical?"top":"left",g=e.vertical?"height":"width";var f=d(this),p=d("ul",f),i=d("li:visible",p),u=i.size(),t=e.visible;var s=0;if(e.circular){p.prepend(i.slice(u-t-1+1).clone()).append(i.slice(0,t).clone());e.start+=t}var r=d("li:visible",p),o=r.size(),w=e.start;f.css("visibility","visible");r.css({overflow:"hidden","float":e.vertical?"none":"left"});p.css({margin:"0",padding:"0",position:"relative","list-style-type":"none","z-index":"1"});f.css({overflow:"hidden",position:"relative","z-index":"2",left:"0px"});var k=e.vertical?a(r):c(r);var q=k*o;var m=k*t;r.css({width:r.width(),height:r.height()});p.css(g,q+"px").css(l,-(w*k));f.css(g,m+"px");d((w-e.scrolls<0&&e.btnPrev)).addClass("prev-disabled");d((w+e.scrolls>o-t&&e.btnNext)).addClass("next-disabled");d(e.btnPrev).hover(function(){if(!d(e.btnPrev).hasClass("prev-disabled")){d(e.btnPrev).addClass("prev-hover")}},function(){d(e.btnPrev).removeClass("prev-hover")});d(e.btnNext).hover(function(){if(!d(e.btnNext).hasClass("next-disabled")){d(e.btnNext).addClass("next-hover")}},function(){d(e.btnNext).removeClass("next-hover")});if(e.btnPrev){d(e.btnPrev).click(function(){return j(w-e.scrolls)})}if(e.btnNext){d(e.btnNext).click(function(){return j(w+e.scrolls)})}if(e.btnGo){d.each(e.btnGo,function(v,x){d(x).click(function(){return j(e.circular?e.visible+v:v)})})}if(e.mouseWheel&&f.mousewheel){f.mousewheel(function(v,x){return x>0?j(w-e.scrolls):j(w+e.scrolls)})}if(e.auto){s=setInterval(function(){j(w+e.scrolls)},e.auto+e.speed)}if(e.onMouse){p.bind("mouseover",function(){if(e.auto){clearInterval(s)}});p.bind("mouseout",function(){if(e.auto){s=setInterval(function(){j(w+e.scrolls)},e.auto+e.speed)}})}function h(){return r.slice(w).slice(0,t)}function j(v){if(!n){if(e.beforeStart){e.beforeStart.call(this,h())}if(e.circular){if(v<=e.start-t-1){p.css(l,-((o-(t*2))*k)+"px");w=v==e.start-t-1?o-(t*2)-1:o-(t*2)-e.scrolls}else{if(v>=o-t+1){p.css(l,-((t)*k)+"px");w=v==o-t+1?t+1:t+e.scrolls}else{w=v}}}else{if(v<0||v>o-t){return}else{w=v}}n=true;p.animate(l=="left"?{left:-(w*k)}:{top:-(w*k)},e.speed,e.easing,function(){if(e.afterEnd){e.afterEnd.call(this,h())}n=false});if(!e.circular){d(e.btnPrev).removeClass("prev-disabled");d(e.btnNext).removeClass("next-disabled");d((w-e.scrolls<0&&e.btnPrev)).addClass("prev-disabled");d((w+e.scrolls>o-t&&e.btnNext)).addClass("next-disabled")}}return false}})};function b(e,f){return parseInt(d.css(e[0],f))||0}function c(e){return e[0].offsetWidth+b(e,"marginLeft")+b(e,"marginRight")}function a(e){return e[0].offsetHeight+b(e,"marginTop")+b(e,"marginBottom")}})(jQuery);


(function($){$.fn.extend({"banner_thaw":function(o){o=$.extend({thumbObj:null,botPrev:null,botNext:null,thumbNowClass:'hover',thumbOverEvent:true,slideTime:1000,autoChange:true,clickFalse:true,overStop:true,changeTime:5000,delayTime:300,pause:false,pauseClass:'promo_paush',pauseText:'paush',playClass:'promo_play',playText:'play',otherobj:null,animatetime:500},o||{});var _self=$(this);var thumbObj;var size=_self.size();var nowIndex=0;var index;var startRun;var delayRun;var positionobj=$(o.thumbObj).eq(0).position();function fadeAB(){if(nowIndex!=index){if(o.thumbObj!=null&&positionobj!=null){$(o.thumbObj).removeClass(o.thumbNowClass).eq(index).addClass(o.thumbNowClass);$(o.otherobj).animate({left:$(o.thumbObj).eq(index).position().left},o.animatetime);};_curr_banner_obj=_self.eq(index).find("img");if(_curr_banner_obj.attr("original")&&(_curr_banner_obj.attr("src")!=_curr_banner_obj.attr("original"))){_curr_banner_obj.attr("src",_curr_banner_obj.attr("original"));}
if(o.slideTime<=0){_self.eq(nowIndex).hide();_self.eq(index).show();}else{_self.eq(nowIndex).fadeOut(o.slideTime);_self.eq(index).fadeIn(o.slideTime);};nowIndex=index;};};function runNext(){index=(nowIndex+1)%size;fadeAB();};_self.hide().eq(0).show();if(o.thumbObj!=null){thumbObj=$(o.thumbObj);otherobj=$(o.otherobj);thumbObj.removeClass(o.thumbNowClass).eq(0).addClass(o.thumbNowClass);if(positionobj!=null){otherobj.css("left",positionobj.left)}
thumbObj.click(function(){index=thumbObj.index($(this));fadeAB();if(o.clickFalse==true){return false;};});if(o.thumbOverEvent==true){thumbObj.mouseenter(function(){clearInterval(startRun);index=thumbObj.index($(this));delayRun=setTimeout(fadeAB,o.delayTime);});thumbObj.mouseleave(function(){clearTimeout(delayRun);startRun=setInterval(runNext,o.changeTime);});if(o.otherobj!=null){$(o.otherobj).mouseenter(function(){clearInterval(startRun);});$(o.otherobj).mouseleave(function(){startRun=setInterval(runNext,o.changeTime);})}};};if(o.botNext!=null){$(o.botNext).click(function(){if(_self.queue().length<1){runNext();};return false;});};if(o.botPrev!=null){$(o.botPrev).click(function(){if(_self.queue().length<1){index=(nowIndex+size-1)%size;fadeAB();};return false;});};if(o.autoChange==true){startRun=setInterval(runNext,o.changeTime);if(o.overStop==true){_self.hover(function(){clearInterval(startRun);},function(){if(o.pause==true&&$("."+o.pauseClass).hasClass(o.playClass)){}else{startRun=setInterval(runNext,o.changeTime);};});};if(o.pause==true){$("."+o.pauseClass).click(function(){if($("."+o.pauseClass).hasClass(o.playClass)){startRun=setInterval(runNext,o.changeTime);$("."+o.pauseClass).removeClass(o.playClass).text(o.pauseText);}else{clearInterval(startRun);$("."+o.pauseClass).addClass(o.playClass).text(o.playText);};});};};}})})(jQuery);

/* ============================== 产品页 脚本 ============================== End */