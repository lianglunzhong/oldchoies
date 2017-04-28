//loadthumb
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
  $(function(){
	  var i = 5;  
	  var m = 5;  
      var $content = $("#myImagesSlideBox .scrollableDiv");
	  var count = $content.find("a").length;

	  $(".scrollableDiv a").live("click",function(){
			var src = $(this).find("img").attr("imgb");
			var bigimgSrc = $(this).find("img").attr("bigimg");
			$("#myImgsLink").attr("href",bigimgSrc);
			$(this).parents(".myImagesSlideBox1").find(".myImgs").loadthumb({src:src}).attr("bigimg",bigimgSrc);
			$(this).addClass("on").siblings().removeClass("on");
			return false;
	  });
	  $(".scrollableDiv a:nth-child(1)").trigger("click");
		
	  $(".myTxts").live("click",function(){
			var bigimgSrc =$(this).parents(".myImagesSlideBox1").find(".myImgs").attr("bigimg");
			popZoom( bigimgSrc , "400" , "400");
			return false;
	  });

		var windowWidth  =$(window).width();
		var windowHeight  =$(window).height();
		function popZoom(pictURL, pWidth, pHeight) {
			var sWidth = windowWidth;
			var sHeight = windowHeight;
			var x1 = pWidth;
			var y1 = pHeight;
			var opts = "height=" + y1 + ",width=" + x1 + ",left=" + ((sWidth-x1)/2) +",top="+ ((sHeight-y1)/2)+",scrollbars=0,menubar=0";
			pZoom = window.open("","", opts);
			pZoom.document.open();
			pZoom.document.writeln("<html><body bgcolor=\"skyblue\"" +" onblur='self.close();' style='margin:0;padding:0;'>");
			pZoom.document.writeln("<img src=\"" + pictURL + "\" width=\"" +pWidth + "px\" height=\"" + pHeight + "px\">");
			pZoom.document.writeln("</body></html>");
			pZoom.document.close();
		} 
  })