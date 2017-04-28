

// --------------------------------------------------
// common
// --------------------------------------------------



//抽奖向下滚动
(function($){
    $.fn.fontscroll = function(options){
        var d = {time: 3000,num: 1}
        var o = $.extend(d,options);
        

        this.children('ul').addClass('line');
        var _con = $('.line').eq(0);
        var _conH = _con.height(); //滚动总高度
        var _conChildH = _con.children().eq(0).height();//一次滚动高度
        var _temp = _conChildH;  //临时变量
        var _time = d.time;  //滚动间隔


        _con.clone().insertAfter(_con);//初始化克隆

        //样式控制
        var num = d.num;
        var _p = this.find('li');
        var allNum = _p.length;


        var timeID = setInterval(Up,_time);
        this.hover(function(){clearInterval(timeID)},function(){timeID = setInterval(Up,_time);});

        function Up(){
            _con.animate({marginTop: '-'+_conChildH});

            if(_conH == _conChildH){
                _con.animate({marginTop: '-'+_conChildH},"normal",over);
            } else {
                _conChildH += _temp;
            }
        }
        function over(){
            _con.attr("style",'margin-top:0');
            _conChildH = _temp;
            num = 1;
        }
    }
})(jQuery);

//size-tab
$(function(){
    $('.size-tab li').click(function(){
        var liindex = $('.size-tab li').index(this);
        $(this).addClass('current').siblings().removeClass('current');
        $('.size-tabcon div.bd').eq(liindex).fadeIn(150).siblings('div.bd').hide();
        var liWidth = $('.size-tab li').width();
        $('.size-tab p').stop(false,true).animate({'left' : liindex * liWidth + 'px'},300);
    });
});

//size-tab
$(function(){
    $('.getlook-tab li').click(function(){
        var liindex = $('.getlook-tab li').index(this);
        $(this).addClass('current').siblings().removeClass('current');
        $('.getlook-tabcon div.bd').eq(liindex).fadeIn(150).siblings('div.bd').hide();
        var liWidth = $('.getlook-tab li').width();
        $('.getlook-tab p').stop(false,true).animate({'left' : liindex * liWidth + 'px'},300);
    });
});

// JS-tab click
$(function(){
$(".JS-tab li").each(function(index) {
    $(this).click(function() {
        var _this = $(this);
        _this.addClass("current").siblings().removeClass("current");
        _this.parent(".JS-tab").siblings(".JS-tabcon").find(".bd").hide();
        $.each($(".JS-tabcon .bd"), function(i, val) {
            if (i == index) val.style.display = "block";
        });
    });
});

$(".JS-tab1 li").each(function(index) {
    $(this).click(function() {
        var _this = $(this);
        _this.addClass("current").siblings().removeClass("current");
        _this.parent(".JS-tab1").siblings(".JS-tabcon1").find(".bd").hide();
        $.each($(".JS-tabcon1 .bd"), function(i, val) {
            if (i == index) val.style.display = "block";
        });
    });
});
})

$(function() {
var t=0;
var time;
var timec;
$(function(){
    //time=setInterval(lunbo,3000);
    $(".box-title ul li").hover(function(){
    //timec=clearInterval(time);
    //timec1=clearInterval(time1);   
    $(this).addClass("current").siblings().removeClass("current");
    var a=$(".box-title ul li").index(this);
    $(".hide-box-0,.hide-box-1,.hide-box-2,.hide-box-3").hide();
    $(".hide-box-"+a).show();
    var liWidth = $(".box-title ul li").width();
    var boxWidth = $(".box-title").width();
    $(".box-title p").stop(false,true).animate({'left' : ((((a) * liWidth)/boxWidth*100)+10) + '%'},300); 
    $("#JS-current li").removeClass("on");                                         
    $("#JS-current li").eq(a).addClass("on");
    t=a; })
    //function(){time=setInterval(lunbo,3000);timec1=clearInterval(time1);}
    })

    $(function(){
        //timec1=clearInterval(time1);
        t++;
        if(t>3){t=0;}
        $(".hide-box-0,.hide-box-1,.hide-box-2,.hide-box-3").hide();
        $(".hide-box-"+(t-1)).show();
        var liWidth = $(".box-title ul li").width();
        $(".box-title p").stop(false,true).animate({'left' : (t/2) * liWidth + 'px'},300);  
        $(".box-title li").eq(t-1).addClass("current").siblings().removeClass("current");
        $("#JS-current ul li").removeClass("on");                                       
        $("#JS-current ul li").eq(t-1).addClass("on");  
    })

 })
$(function() {
    var h=0;
    var time1;
    var timec1;
    $(function(){
        //time1=setInterval(lunbo1,3000);
        $("#JS-current ul li").hover(function(){
        //timec1=clearInterval(time1);
        //timec=clearInterval(time);   
        $(this).addClass("on").siblings().removeClass("on");
        var b=$("#JS-current ul li").index(this);
        $(".hide-box-0,.hide-box-1,.hide-box-2,.hide-box-3").hide();
        $(".hide-box-"+b).show(); 
        var liWidth = $(".box-title ul li").width();
        var boxWidth = $(".box-title").width(); 
        $(".box-title p").stop(false,true).animate({'left' : ((((b) * liWidth)/boxWidth*100)+10) + '%'},300); 
        $(".box-title li").eq(b).addClass("current").siblings().removeClass("current");
        $("#JS-current li").removeClass("on");                                         
        $("#JS-current li").eq(b).addClass("on");
        h=b; })
        })

        function lunbo1(){
            //timec=clearInterval(time);
            h++;
            if(h>3){h=0;}
            $(".hide-box-0,.hide-box-1,.hide-box-2,.hide-box-3").hide();
            $(".hide-box-"+(h-1)).show();
            var liWidth = $(".box-title ul li").width(); 
            $(".box-title p").stop(false,true).animate({'left' : (h/2) * liWidth + 'px'},300);  
            $(".box-title li").eq(h-1).addClass("current").siblings().removeClass("current");
            $("#JS-current ul li").eq(h-1).addClass("on").siblings().removeClass("on");
            $("#JS-current ul li").removeClass("on");                                         
            $("#JS-current ul li").eq(h-1).addClass("on");  
        }
scroll
 })

/*$("#phone-btn").click(function(){
    $("#phone-main").slideToggle();
})
*/
//new search

$(".search-text").focus(function(){
    $(this).parents(".n-search").addClass("s-long");
    $(this).attr("style","color: #000;");
    $(this).siblings(".search-close").show();
    $(this).siblings(".search-btn").hide();
    
})
$(".search-btn-lg").live("click",function(){
    $(".search-text").parents(".n-search").addClass("s-long");
    $(".search-text").attr("style","color: #000;");
    $(".search-text").siblings(".search-close").show();
    $(".search-text").siblings(".search-btn").hide();
    
})

$(".search-text").live("blur",function(){  
    $(this).parents(".n-search").removeClass("s-long")
    $(this).attr("style","color: #999;");
    $(".search-close").hide();
    $(".search-btn").show();
    
    
})
$(".search-close-hide").click(function(){
    $("#boss").val("");
    
})

//phone search
/*$(".phone-navbar input").focus(function(){
    $(this).parent().animate({"width":"85%"},500);
    $(this).parent().next(".bag-phone-on").animate({"width":"0"},500);
    $(this).parent().nextAll(".log-phone").animate({"width":"0","margin-right":"0"},500);;
})
$(".phone-navbar input").blur(function(){
    $(this).parent().animate({"width":"40%"},400);
    $(this).parent().next(".bag-phone-on").animate({"width":"20px",left:"0px"},600);
    $(this).parent().nextAll(".log-phone").animate({"width":"30px","margin-right":"10px",left:"0"},400);
})
*/
//phone-search 2016-03
$(".navbar-header .fa-search").click(function(){
    $(".navbar-search").slideToggle(300);
    $(this).toggleClass("fa-close")
})
// checked="checked"
$(function(){   
 
    $(".radio-option").click(function() {
        $(this).find(" input[type='radio']").attr("checked","checked").parents().siblings().find('input').removeAttr("checked","checked");
    });
 
});
// input empty
$(function(){
    $('.form-control').focus(function(){
            $(this).parents().removeClass("is-empty");
        })

})
$(function(){

	// mail and search
    $('.text').live('focusin', function(){
        $(this).addClass('inputfocus');
        if(this.value==this.defaultValue){
            this.value='';
        }
    }).focusout(function(){
        $(this).removeClass('inputfocus');
        if(this.value==''){
            this.value=this.defaultValue;

        }
    })
	
	// show / hide hover
    $(".JS-show").live('mouseenter', function(){
        $(this).children('.JS-showcon').show();
    })
    $(".JS-show").live('mouseleave', function(){
        $(this).children('.JS-showcon').hide();
    })
    $(".message-off").live('mouseenter', function(){
        $('.message-on').fadeIn(1);
        $('.message-off').fadeOut(1);
    })
    $(".message-on").live('mouseleave', function(){
        $('.message-off').fadeIn(1);
        $('.message-on').fadeOut(1);
    })
    
    $(".JS-delete").click(function(){
        $(this).siblings(".JS-delete-box").fadeIn(320);
    })
    $(".JS-delete-box .btn").click(function(){
        $(".JS-delete-box").fadeOut(320);
    })

    $(".cold-list").click(function(){
        $(".codelist-con").show();
    })

    $('.J-pop-btn').click(function(){
        $(this).parents().find('.J-popcon').slideDown();
    }),$(".close-btn").click(function(){
        $(this).parents().find('.J-popcon').hide();
    })

    function getScrollTop() {
        var scrollPos;
        if (window.pageYOffset) {
            scrollPos = window.pageYOffset;
        } else if (document.compatMode && document.compatMode != 'BackCompat') {
            scrollPos = document.documentElement.scrollTop;
        } else if (document.body) {
            scrollPos = document.body.scrollTop;
        }
        return scrollPos;
    }

	// JS_floatnav
    $(window).scroll(function() {
    if ($(document).scrollTop() > 120) {
        var nav = $(".nav-wrapper #nav1").html();
        $(".scroll-nav-wrapper #nav2").html(nav);
        var search = $(".nav-wrapper  .search").html();
        $(".scroll-nav-wrapper  .search").html(search);
        var mybag = $(".top-shortcut  .mybag").html();
        $(".scroll-nav-wrapper  .mybag").html(mybag);
        $(".scroll-nav-wrapper").fadeIn(500);
    } else {
        $(".scroll-nav-wrapper").fadeOut(500);
    }
    });
    // moblie header
    $(window).scroll(function() {
    if ($(document).scrollTop() > 100) {
        var newNav = $("#pc-header").html();
        $("#moblie-header").html(newNav);
        $("#moblie-header").fadeIn(500);
    } else {
        $("#moblie-header").fadeOut(500);
    }
    });

     // JS_floatnav-phone
    $(window).scroll(function() {
    if ($(document).scrollTop() > 20) {
        if($(".navbar-collapse").is(":hidden")==true){
        $(".phone-navbar").addClass("phone-scroll");
        }
    }
    else{
        $(".phone-navbar").removeClass("phone-scroll");
        }

    });
    $(".product-carousel").css("width", "100%");

   /* // navbar-toggle
    $(".navbar-toggle").click(function(){
        $(".collapse").slideToggle(500);
    })
    */
    $(".JS-filterAll").click(function() {
        $(".filterall").show();
    });

    $(".JS-filterClose").click(function() {
        $(".filterall").hide();
    });

    $('.fa-times').click(function(){
        $(".order-btns-fixed").hide();
    }) 


     // JS-filter2
    $(".JS-popwinbtn1").live("click", function() {
        var top = getScrollTop();
        top = top - 35;
        $('body').append('<div class="JS-filter1 opacity"></div>');
        $('.JS-popwincon1').css({
            "top": top,
            "position": 'absolute'
        });
        $('.JS-popwincon1').appendTo('body').fadeIn(320);
        $('.JS-popwincon1').show();
         $('.items').show();
        return false;
    })

    $(".JS-close2,.JS-filter1").live("click", function() {
        $(".JS-filter1").remove();
        $('.JS-popwincon1').fadeOut(160);
        $(".JS-filter4").remove();
        $('.JS-popwincon5').fadeOut(160);
         $('.items').hide();
        return false;
    })
    
})
// JS-toggle
$(function(){
    
    $(".JS-toggle").live('click', function(){
        $(this).siblings('.JS-toggle-box').slideToggle(500);
    })
});
//detail-tab
$(function(){
    $('.detail-tab li').click(function(){
        var liindex = $('.detail-tab li').index(this);
        $(this).addClass('current').siblings().removeClass('current');
        $('.detail-tabcon div.bd').eq(liindex).fadeIn(150).siblings('div.bd').hide();
        var liWidth = $('.detail-tab li').width();
        $('.detail-tab p').stop(false,true).animate({'left' : liindex * liWidth + 'px'},300);
    });
});
//detail-tab1
$(function(){
    $('.detail-tab1 li').click(function(){
        var liindex = $('.detail-tab1 li').index(this);
        $(this).addClass('on').siblings().removeClass('on');
        $('.detail-tabcon1 div.bd').eq(liindex).fadeIn(150).siblings('div.bd').hide();
        var liWidth = $('.detail-tab1 li').width();
        $('.detail-tab1 p').stop(false,true).animate({'left' : liindex * liWidth + 'px'},300);
    });
});


// JS-tab-video click
$(function(){
$(".JS-tab-v li").each(function(index) {
    $(this).click(function() {
        var _this = $(this);
        _this.addClass("current-v").siblings().removeClass("current-v");
        _this.parent(".JS-tab-v").siblings(".JS-tabcon-v").find(".bd-v").hide();
        $.each($(".JS-tabcon-v .bd-v"), function(i, val) {
            if (i == index) val.style.display = "block";
        });
    });
});
})
// JS-tab size
$(function(){
$(".JS-tab-size li").each(function(index) {
    $(this).click(function() {
        var _this = $(this);
        _this.addClass("current").siblings().removeClass("current");
        _this.parent(".JS-tab-size").siblings(".JS-tabcon-size").find(".bd").hide();
        $.each($(".JS-tabcon-size .bd"), function(i, val) {
            if (i == index) val.style.display = "block";
        });
    });
});
})
// JS-tab view
$(function(){
$(".JS-tab-view li").each(function(index) {
    $(this).click(function() {
        var _this = $(this);
        _this.addClass("current").siblings().removeClass("current");
        _this.parent(".JS-tab-view").siblings(".JS-tabcon-view").find(".bd").hide();
        $.each($(".JS-tabcon-view .bd"), function(i, val) {
            if (i == index) val.style.display = "block";
        });
    });
});
})
// --------------------------------------------------
// home
// --------------------------------------------------

// flexslider
$(function() {
    $('#homeBigBanner').flexslider({
                            animation: "slides",
                            direction:"horizontal",
                            easing:"swing"
                        });
    $('#phoneBigBanner').flexslider({
                            animation: "slides",
                            direction:"horizontal",
                            easing:"swing"
                        });
    $('#homeIndexFashion').flexslider({
                            animation: "fade",
                            slideshowSpeed:"40000000",
                            direction:"horizontal",
                            easing:"swing"
                        });
     $('#phoneProductPic').flexslider({
                            animation: "fade",
                            slideshowSpeed:"40000000",
                            direction:"horizontal",
                            easing:"swing"
                        });
                        
})


// buys-show
$(function() {
    $(".buys-show img").live('hover', function() {
        if ($(this).siblings().length > 0) {
            $(this).toggle();
            $(this).siblings().toggle();
        }
    }, function() {
        if ($(this).siblings().length > 0) {
            $(this).toggle();
            $(this).siblings().toggle();
        }
    })
})


// --------------------------------------------------
// Contenedor
// --------------------------------------------------
/*$(function() {
    var Accordion = function(el, multiple) {
        this.el = el || {};
        this.multiple = multiple || false;

        // Variables privadas
        var links = this.el.find('.link');
        // Evento
        links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
    }

    Accordion.prototype.dropdown = function(e) {
        var $el = e.data.el;
            $this = $(this),
            $next = $this.next();

        $next.slideToggle();
        $this.parent().toggleClass('open');

        if (!e.data.multiple) {
            $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
        };
    }   

    var accordion = new Accordion($('#accordion'), false);
});
*/
// --------------------------------------------------
// product
// --------------------------------------------------

// size choise
$(function(){
    // $(".size-list li").live("click",function(){
    //     if($(this).attr('class').indexOf('btn-size-normal') < 0)
    //     {
    //         return false;
    //     }
    //     var value = $(this).attr('id');
    //     var qty = $(this).attr('title');
    //     $(".s-size").val(value);
    //     $(this).siblings().removeClass('on');
    //     $(this).addClass('on');
    //     $(this).parents('.JS-popwincon').removeClass("product-note");
    //     $(this).parents('.JS-popwincon').children('.product-note-title').hide();
    //     $(this).parents('#formAdd').removeClass("product-pl");
    //     $("#select_size").hide();
    //     $("#size_show").html($(this).find('span').text());
    //     $("#size_span").show();
    //     if(qty)
    //     {
    //         $("#only_num").html(qty);
    //         $("#only_left").show();
    //     }
    //     else
    //     {
    //         $("#only_left").hide();
    //     }
    // })
    $("#select_size li").live("click",function(){
        var val=$(this).text();
        val = val.replace(/(^\s*)|(\s*$)/g, ""); 
        $(".s-size").val(val);
        $(this).parent().hide();
        $("#size-val").siblings(".fa-caret-down").removeClass("fa-caret-up");
        $("#size-val").text(val);
        var qty_left=$(this).attr("title");
        $(this).parents('.JS-popwincon').removeClass("product-note");
        $(this).parents('.JS-popwincon').children('.product-note-title').hide();
        $(this).parents('#formAdd').removeClass("product-pl");
        if(qty_left && qty_left<21)
         {
            $("#size_show").html($("#size-val").text());
             $("#only_num").html(qty_left);
             $("#only_left").show();
         }
         else
         {
            $("#only_left").hide();
         }
    })

    
    $("#qty").focus(function(){
        if($("#qty").val().trim()>1000){
            $("#qty").val("");
            $(this).parents('.JS-popwincon').removeClass("product-note");
            $(this).parents('.JS-popwincon').children('.product-note-title').hide();
            $(this).parents('#formAdd').removeClass("product-pl");
        }
    });
    
                                                                            
    $('#addCart').live("click",function(){
        var size = $('#size-val').text();
        size = $.trim(size);
        var qty=$("#qty").val();
        if(!qty)
        {
            qty = 1;
            return false;
        }
        if(size=="SELECT SIZE")
        {     
            $(this).parents('.JS-popwincon').addClass("product-note");
            $(this).parents('.JS-popwincon').find('.product-note-title').show();
            $(this).parents('#formAdd').addClass("product-pl");
            return false;
        }
        else if (!qty.trim().match(/^[0-9]*[1-9][0-9]*$/)||qty.trim()>1000)
        {
            $(this).parents('.JS-popwincon').addClass("product-note");
            var qty_tip=$(this).parents('.JS-popwincon').find('.product-note-title span');
            qty_tip.html("Qty 1~1000 Please!");
            $(this).parents('.JS-popwincon').find('.product-note-title').show();
            $(this).parents('#formAdd').addClass("product-pl");
            return false;
        }
    })
})

$(".product-view #addCart").click(function() {
    if($(window).width()>767){
    $("body,html").animate({
        scrollTop: 0
    });
    }
});


$(".JS-close").live("click", function() {
        $(this).parents('.JS-popwincon').removeClass("product-note");
        $(this).parent().hide();
        return false;
    })
$(".JS-close2").live("click", function() {
        $(this).parents('.JS-popwincon').removeClass("product-note");
        $(this).parents('.JS-popwincon1').hide();
        $(".reveal-modal-bg").fadeOut();
        //$(this).parent().hide();
        return false;
    })
//quick view scrollable div
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
            $(this).parents("#myImagesSlideBox").find(".myImgs").loadthumb({src:src}).attr("bigimg",bigimgSrc);
            $(this).addClass("active on").siblings().removeClass("active on");
            return false;
      });
      $(".scrollableDiv a:nth-child(1)").trigger("click");
        
      $(".myTxts").live("click",function(){
            var bigimgSrc =$(this).parents("#myImagesSlideBox").find(".myImgs").attr("bigimg");
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
 
// scrollableDiv
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
      var i = 1;  
      var m = 1;  
      var $content = $("#myImagesSlideBox .scrollableDiv");
      $("#scrollable .b-next").live("click",function(){
        var count = ($content.find("a").length)/5;
        var $scrollableDiv = $(this).siblings(".items").find(".scrollableDiv");
            if( !$scrollableDiv.is(":animated")){
                if(m<count){ 
                    m++;
                    $scrollableDiv.animate({top: "-=92px"});
                }
            }
            return false;
      });
      
      $("#scrollable .b-prev").live("click",function(){
            var $scrollableDiv = $(this).siblings(".items").find(".scrollableDiv");
            if( !$scrollableDiv.is(":animated")){
                if(m>i){ 
                m--;
                    $scrollableDiv.animate({top: "+=92px"});
                }
            }
            return false;
      });

      $(".scrollableDiv a").live("click",function(){
            var src = $(this).find("img").attr("imgb");
            var bigimgSrc = $(this).find("img").attr("bigimg");
//          $("#myImgsLink").attr("href",bigimgSrc);
            $(this).parents("#myImagesSlideBox").find(".myImgs").loadthumb({src:src});
            $("#bigView img").loadthumb({src:bigimgSrc});   
            $(this).addClass("active").siblings().removeClass("active");
            return false;
      });
      //$(".scrollableDiv a:nth-child(1)").trigger("click");
  })

//View More+
$(document).ready(function() {
    $(".bt-view p").click(function() {
        $(this).parent().parent().find(".more-view").toggle(500);  
        var text = $(this).text();  
        if(text == 'View More+')
        {
            $(this).text("View Less-");
        }
        else if(text == 'View Less-')
        {
            $(this).text("View More+");
        }
    })
});

//other product four cycle
$(function() {
    var f=0;
    var t1;
    var tc1;
        $(function(){
                    $("#JS-current1 li").hover(function(){   
                    $(this).addClass("on").siblings().removeClass("on");
                    var c=$("#JS-current1 li").index(this);
                    $(".hide-box1-"+c).show().siblings().hide();
                    f=c; 
                })
            })
})    

// --------------------------------------------------
// lookbook
// --------------------------------------------------
$(function(){
$(".pro-four-dp").mouseover(function(){
	var id = $(this).children("div").attr("id");
	var  aaa = $(this).children("div").children("ul").children("li").attr("class");
	var lang = $(this).attr('id');
	if(aaa != 'product aa'){
		$(this).children("div").addClass("expanded")
		return false;
	}
		
	
	
	var divbox = $(this).children("div").children("ul");	
	var html = '';		
	var libox = '';
        $.post(
            '/site/ajax_product?lang='+lang,
            {            
                lang: lang,
                id: id,
            },
            function(product)
            {		aa = 0;
				for (var n in product['images'])
				{
					if(aa >= 4){
						divbox.append(libox);
							$(this).children("div").addClass("expanded")
						return false;;
					}

                    var link = product['link'];
				
                    bimage = 'http://cloud.choies.com/pimg/420/' + product['images'][n]['id'] + '.' + product['images'][n]['suffix'];
                    simage = 'http://cloud.choies.com/pimg/75/' + product['images'][n]['id'] + '.' + product['images'][n]['suffix'];
					libox += '<li class="product"><a href="'+ link + '" target="_blank"><img src="'+simage+'" alt="'+product['name']+'" imgb="'+bimage+'"  bigimg="'+bimage+'" /></a></li>';						
					divbox.html('');	
							aa ++;
				}	

				divbox.append(libox);
			},
            'json'
            );

  		$(this).children("div").addClass("expanded")
        });
    $(".pro-four-dp").mouseout(function(){
        $(this).children("div").removeClass("expanded")
        })
})
// --------------------------------------------------
// zhangxi
// --------------------------------------------------
 $(".JS-show1").live('click', function(){
        $(this).children(".fa-caret-down").toggleClass("fa-caret-up");
        $(this).siblings('.JS-showcon1').toggle();
     })
  // JS_click
    $(".JS_click").click(function(){
        $(".JS_clickcon").slideToggle();
    });
//JS-click-tip
    $(".JS-click-tip").click(function(){
        $(this).find(".JS-clickcon-tip").show().delay(5000).hide(0);
        $(this).siblings().find(".JS-clickcon-tip").hide();
    })
// JS_shows1
    $(".JS_shows_btn1").hover(function(){
        $(this).find(".JS_shows1").show();
    },function(){
        $(this).find('.JS_shows1').hide();
    })    
// docs tab
tab(".JS_tab1",".JS_tabcon1","on","click");
    $(".JS_tab li").each(function(index){
        $(this).click(function(){
            var _this = $(this);
            _this.addClass("current").siblings().removeClass("current");
            _this.parent(".JS_tab").siblings(".JS_tabcon").find(".bd").hide();
            $.each($(".JS_tabcon .bd"), function(i,val){
                if(i==index) val.style.display = "block";
            });
        })          
    });
      

function tab(nav,content,on,type)
{
    $(nav).children().bind(type,(function(){
        var $tab=$(this);
        var tab_index=$tab.prevAll().length;
        var $content = $(content).children();
        $(nav).children().removeClass(on);
        $tab.addClass(on);
        $content.hide();
        $content.eq(tab_index).show();
    }));
}
// gotop
function gotop() {
    var $ua = navigator.userAgent.toLowerCase(),
        isChrome = $ua.indexOf("chrome") > -1,
        isSafari = $ua.indexOf("safari") > -1;
    var $top = $("#gotop"),
        $th = isChrome || isSafari ? document.body.scrollTop : document.documentElement.scrollTop;
    if ($th > document.body.clientHeight/2) {
        $top.fadeIn(300);
    } else {
        $top.hide();
    }

    $(window).scroll(function() {
        $th = isChrome || isSafari ? document.body.scrollTop : document.documentElement.scrollTop;
        if ($th <= document.body.clientHeight/2) {
            $top.hide();
        } else if ($th > document.body.clientHeight/2) {
            $top.show();
        }
    });

    $top.click(function(e) {
        $("body,html").animate({
            scrollTop: 0
        });
        e.preventDefault();
    });
}

$(function() {
    gotop();
});


 // drop
$(".JS_drop").live('click', function(){
    var _this=$(this);
    _this.find(".JS_drop_box").toggle().find("li").click(function(){
        var location=$(this).parent().parent().parent().parent().find(".Js_repNum");
        var that=$(this);
        that.addClass("on");
        that.siblings().removeClass("on");
        var hvalue = that.find(".hvalue").val(); 
        if(hvalue) location.val(hvalue);
        else location.val(that.attr("title"));
        _this.find(".selected").text(that.text());
    })
})

 //JS-toggle1
    $(".JS-toggle1").live('click', function(){
        $(this).children('.JS-toggle-box1').slideToggle(500);
    })


// 分类页Quick View 产品轮播
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
      var i = 1;  
      var m = 1;  
      var $content = $("#myImagesSlideBox .scrollableDiv");
      $("#scrollable .b-next").live("click",function(){
        var count = ($content.find("a").length)/5;
        var $scrollableDiv = $(this).siblings(".items").find(".scrollableDiv");
            if( !$scrollableDiv.is(":animated")){
                if(m<count){ 
                    m++;
                    $scrollableDiv.animate({top: "-=92px"});
                }
            }
            return false;
      });
      
      $("#scrollable .b-prev").live("click",function(){
            var $scrollableDiv = $(this).siblings(".items").find(".scrollableDiv");
            if( !$scrollableDiv.is(":animated")){
                if(m>i){ 
                m--;
                    $scrollableDiv.animate({top: "+=92px"});
                }
            }
            return false;
      });

      $(".scrollableDiv a").live("click",function(){
            var src = $(this).find("img").attr("imgb");
            var bigimgSrc = $(this).find("img").attr("bigimg");
//          $("#myImgsLink").attr("href",bigimgSrc);
            $(this).parents("#myImagesSlideBox").find(".myImgs").loadthumb({src:src});
            $("#bigView img").loadthumb({src:bigimgSrc});   
            $(this).addClass("active").siblings().removeClass("active");
            return false;
      });
      //$(".scrollableDiv a:nth-child(1)").trigger("click");
  })
// aside_leftlist 
    $('.JS_down').click(function(){
        $(this).toggleClass("fa-angle-down");
        $(this).toggleClass("fa-angle-up");
        $(this).parent().next(".JS_menu").slideToggle(500);
    })
//leftlist
$("#bar .item-l").click(function(){
    $(this).hide();
})
$("#bar .clear-li").click(function(){
    $(this).parent().hide();
})
$("#filter_size a,#filter_color a,#filter_price a").click(function(){
    if($(this).hasClass("disabled")){
        return false;
    }
    else{
        $(this).toggleClass("selected");
    }
})
//phone-nav
$(function(){
    $("#phone-btn").click(function(){
        $(".page").addClass("page-on");
        $(".navbar-collapse").addClass("navbar-collapse-on");
        $(window).scrollTop(0);
        $(".phone-mask").removeClass("hide");
        $(".phone-mask #phone-close-btn").addClass("btn-on");
        $(".navbar-search").hide(300);
        $(".navbar-header .fa-search").removeClass("fa-close");
})
$("#phone-close-btn").click(function(){
        $(".page").removeClass("page-on"); 
        $(".phone-mask").addClass("hide");    
    })
})
$(".phone-mask").click(function(){

        $(".navbar-collapse").removeClass("navbar-collapse-on");
        $(".phone-mask").addClass("hide");
        $(".page").removeClass("page-on"); 
})
$(function(){
    $("#accordion .link").click(function(){
        $(this).next(".submenu").addClass("submenu-on");
        $(this).parent().siblings().children(".submenu").removeClass("submenu-on");
    })
    $("#accordion .submenu li.back").click(function(){
        $(this).parent("ul").removeClass("submenu-on");
        $(this).parents(".navbar-collapse").removeClass("navbar-collapse-on1");
    })
   $(".phone-navbar").scrollTop(0);
})        

//message toggle
$(".message").click(function(){
    $(this).find(".messageDropdownIcon").toggleClass("open");
    $(this).siblings(".pinMessageBox").fadeToggle(300);
})