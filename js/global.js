
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
    $(".JS_show").live('mouseenter', function(){
        $(this).find('.JS_showcon').show();
    })
    $(".JS_show").live('mouseleave', function(){
        $(this).find('.JS_showcon').hide();
    })
    
    // JS_shows
    $(".JS_shows").hover(function(){
        $(".JS_showcons").show();
    },function(){
        $(".JS_showcons").hide();
    });
	
    // JS_click
    $(".JS_click").click(function(){
        $(".JS_clickcon").slideToggle();
    });
    
    // ibanner
    $(".ibanner").mouseover(function(){ 
        $('.previous').stop().animate({
            left:'0'
        },'fast');
        $('.next').stop().animate({
            right:'0'
        },'fast');
    }).mouseout(function(){
        $('.previous').stop().animate({
            left:'-45px'
        },'fast');
        $('.next').stop().animate({
            right:'-45px'
        },'fast');
    })
	
    // JS_carousel4
    $(".JS_carousel4").carousel({
        btnPrev:".JS_prev4",
        btnNext:".JS_next4",
        scrolls:5,
        circular:false,
        visible:1
    })
    
    // JS_carousel5
    $(".JS_carousel5").carousel({
        btnPrev:".JS_prev5",
        btnNext:".JS_next5",
        scrolls:5,
        circular:false,
        visible:1
    })
					
    // JS_carousel
    $(".JS_carousel").carousel({
        btnPrev:".JS_prev",
        btnNext:".JS_next",
        scrolls:1,
        circular:false,
        visible:5
    })
    $(".product_carousel").css("width","100%");
    $(".paysuccess_b .product_carousel").css("width","680px");
	
    // JS_carousel1
    $(".JS_carousel1").carousel({
        btnPrev:".JS_prev1",
        btnNext:".JS_next1",
        scrolls:1,
        circular:false,
        visible:3
    })
    $(".pro_lookwith .pro_listcon").css("width","605px");
    $(".shopping_purchase").css("width","1000px");
    
    // JS_carousel2
    $(".JS_carousel2").carousel({
        btnPrev:".JS_prev2",
        btnNext:".JS_next2",
        scrolls:1,
        circular:false,
        visible:4
    })
    
    $(".JS_carousel3").carousel({
        btnPrev:".JS_prev3",
        btnNext:".JS_next3",
        scrolls:1,
        circular:false,
        visible:4
    })
    
    $(".wid805").css("width","805px");
	
    $(".flash_sale_prolist .size_list").css("position","static");
    $(".flash_sale_prolist .size_list").css("width","190px");
        
    // close hide
    $(".JS_close").click(function(){
        $(".JS_hide").slideUp();
    });
	
    // JS show1
    $(".JS_show_btn1").click(function(){
        $(".JS_show1").show();
    });
	
    // JS show2
    $(".JS_show_btn2").click(function(){
        $(".JS_show2").show();
    });
	
    // JS show3
    $(".JS_show_btn3").click(function(){
        $(".JS_show3").show();
    });
    
    // JS_shows1
    $(".JS_shows_btn1").hover(function(){
        $(this).find(".JS_shows1").show();
    },function(){
        $(this).find('.JS_shows1').hide();
    })
    
    // JS_tab click
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

    //View more/View less
    $('.scroll_list .JS_view_morebtn').click(function(){
        var _this = $(this);
        _this.parents(".scroll_list").children(".view_morecon").slideToggle();
        
        if(_this.html()=="View more"){
            _this.siblings().children(".view_morecon").slideDown();
            _this.html("View less");
        }
        else{
            _this.siblings().children(".view_morecon").slideUp();
            _this.html("View more");
        }
    }) 
    
    $('.dress_list .JS_view_morebtn').click(function(){
        var _this = $(this);
        _this.parents(".dress_list").children(".view_morecon").slideToggle();
        _this.parents(".dress_list").siblings().children(".view_morecon").slideUp();
        if(_this.html()=="View more"){
            _this.html("View less");
            _this.parents(".dress_list").siblings().find(".JS_view_morebtn").html("View more");
        }
        else{
            _this.html("View more");
        }
    })
    	
    // JS_probox
    $(".JS_myImages a").banner_thaw({
        thumbObj:".JS_scrollableDiv li",
        autoChange:false,
        botPrev:".Js_prev",
        botNext:".Js_next",
        otherobj:".current_style",
        animatetime:500,
        haveBigImg:true,
        fullScreen:true
    });





})

// JS_floatnav
$(window).scroll(function(){
    if ($(document).scrollTop() > 120){ 
        var nav = $("#nav_list #nav1").html();
        $("#JS_floatnav #nav2").html(nav);
        var search = $("#nav_list .search").html();
        $("#JS_floatnav .search").html(search);
        $("#JS_floatnav").fadeIn(500);
    }
    else
    {
        $("#JS_floatnav").fadeOut(500);
    }
});

// gotop
function gotop(){
    var $ua = navigator.userAgent.toLowerCase(),
    isChrome = $ua.indexOf("chrome") > -1,
    isSafari = $ua.indexOf("safari") > -1;
    var $top = $("#gotop"),$th = isChrome||isSafari?document.body.scrollTop:document.documentElement.scrollTop;
    if($th != 0){
        $top.fadeIn(300);
    }
    else{
        $top.hide();
    }
	
    $(window).scroll(function(){
        $th = isChrome||isSafari?document.body.scrollTop:document.documentElement.scrollTop;
        if($th == 0){
            $top.hide();
        }
        else if($th > 0){
            $top.show();
        }
    });
	
    $top.click(function(e){
        $("body,html").animate({
            scrollTop:0
        });
        e.preventDefault();
    });
} 

$(function(){
    gotop();
});

// JS_filter
$(".JS_popwinbtn").live("click",function(){
    var top = getScrollTop();
    top = top - 35;
    $('body').append('<div class="JS_filter opacity"></div>');
    $('.JS_popwincon').css({
        "top": top, 
        "position": 'absolute'
    });
    $('.JS_popwincon').appendTo('body').fadeIn(320);
    $('.JS_popwincon').show();
    return false;
})

$(".JS_popwincon .JS_close1,.JS_filter").live("click",function(){
    $(".JS_filter").remove();
    $('.JS_popwincon').fadeOut(160);
    return false;
})
		
function getScrollTop() {
    var scrollPos; 
    if (window.pageYOffset) 
    {
        scrollPos = window.pageYOffset;
    } 
    else if (document.compatMode && document.compatMode != 'BackCompat')
    { 
        scrollPos = document.documentElement.scrollTop; 
    } 
    else if (document.body) 
    { 
        scrollPos = document.body.scrollTop; 
    } 
    return scrollPos; 
}

function plus(){
    $init = document.getElementById("count_1").value;
    $init++;
    document.getElementById("count_1").value = $init;
    if(document.getElementById("count_1").value!=="1"){
        $(".btn_qty1").css("background","#666");
    }
}
                                                                
function minus(){
    if($init>1){
        $init = document.getElementById("count_1").value;
        $init--;
        document.getElementById("count_1").value = $init;
        if(document.getElementById("count_1").value =="1"){
            $(".btn_qty1").css("background","#CED0D4");
        }
    }
}

$(function(){
    // tab		
    tab(".JS_tab1",".JS_tabcon1","on","click");
    tab(".JS_tab2",".JS_tabcon2","on","click");
    tab(".JS_tab3",".JS_tabcon3","on","mouseover");
    tab(".JS_tab4",".JS_tabcon4","on","click");
    tab(".JS_tab5 ul",".JS_tabcon5","on","mouseover");
    tab("#tab1_nav ul","#tab1_con","on","mouseover");
    tab("#tab5-nav ul","#tab5-con","on","mouseover");
    tab("#tab5-nav1 ul","#tab5-con-1","on","mouseover");
    tab("#tab3-nav ul","#tab3-con","on","mouseover");
    tab("#tab6-nav ul","#tab6-con","on","mouseover");
	
	
    // colorBox
    $(".color .color_list li").hover(function(){
        $(this).find(".colorBox,.w_colorli").show();
    },function(){
        $(this).find('.colorBox,.w_colorli').hide();
    })
	
    // JS_td_even
    $(".JS_td_even tr:even").css("background-color","#f8f8f5");
	
    // JS_select
    $(".JS_select").click(function(){
        $(this).addClass("selected");
        $(this).siblings().removeClass("selected");
        $(this).parent().find(".JS_hidden1").val("1");
    })
    
    // JS_select1
    $(".JS_select1").click(function(){
        $(this).addClass("selected");
        $(this).siblings().removeClass("selected");
        $(this).parent().find(".JS_hidden1").val("1");
    })
	
    // JS_select2
    $(".JS_select2").toggle(function(){
        $(this).addClass("selected")
        $(this).parent().find(".JS_hidden2").val("1")
    },function(){
        $(this).removeClass("selected")
        $(this).parent().find(".JS_hidden2").val("0")
    })
	
    // JS_cart_side
    $(".JS_cart_side").smartFloat();
    gotop();
	
    // J_pop
    $('.J_pop_btn').click(function(){
        $(this).parents().find('.J_popcon').slideDown();
    }),$(".close_btn").click(function(){
        $(this).parents().find('.J_popcon').hide();
    })
    
    // aside_leftlist 
    $('.JS_leftlist .JS_down').click(function(){
        $(this).toggleClass("downon");
        $(this).next(".JS_menu").slideToggle(500).siblings(".JS_menu").slideUp("slow");
        $(this).siblings().removeClass("downon");
    })
    
    // pro_img 
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
    $(".JS_pro_small li").live("click",function(){
        var src = $(this).find("img").attr("imgb");
        var bigimgSrc = $(this).find("img").attr("bigimg");
        $(this).parents(".JS_imgbox").find(".JS_pro_img").loadthumb({
            src:src
        }).attr("bigimg",bigimgSrc);
        $(this).addClass("current").siblings().removeClass("current");
        return false;
    });
    $(".JS_pro_small li:nth-child(1)").trigger("click");
	
})

// JS_floatnav
$(window).scroll(function(){
    if ($(document).scrollTop() > 120){ 
        var nav = $("#nav_list #nav1").html();
        $("#JS_floatnav #nav2").html(nav);
        var search = $("#nav_list .search").html();
        $("#JS_floatnav .search").html(search);
        $("#JS_floatnav").fadeIn(500);
    }
    else
    {
        $("#JS_floatnav").fadeOut(500);
    }
});

// gotop
function gotop(){
    var $ua = navigator.userAgent.toLowerCase(),
    isChrome = $ua.indexOf("chrome") > -1,
    isSafari = $ua.indexOf("safari") > -1;
    var $top = $("#gotop"),$th = isChrome||isSafari?document.body.scrollTop:document.documentElement.scrollTop;
    if($th != 0){
        $top.fadeIn(300);
    }
    else{
        $top.hide();
    }
	
    $(window).scroll(function(){
        $th = isChrome||isSafari?document.body.scrollTop:document.documentElement.scrollTop;
        if($th == 0){
            $top.hide();
        }
        else if($th > 0){
            $top.show();
        }
    });
	
    $top.click(function(e){
        $("body,html").animate({
            scrollTop:0
        });
        e.preventDefault();
    });
} 

$(function(){
    gotop();
});

// time left
var startTime = new Date();
startTime.setFullYear(2014, 12, 1);
startTime.setHours(24);
startTime.setMinutes(59);
startTime.setSeconds(59);
startTime.setMilliseconds(999);
var EndTime=startTime.getTime();
function GetRTime(){
    var NowTime = new Date();
    var nMS = EndTime - NowTime.getTime();
    var nD = Math.floor(nMS/(1000 * 60 * 60 * 24));
    var nH = Math.floor(nMS/(1000*60*60)) % 24;
    var nM = Math.floor(nMS/(1000*60)) % 60;
    var nS = Math.floor(nMS/1000) % 60;
    if(nD<=9) nD = "0"+nD;
    if(nH<=9) nH = "0"+nH;
    if(nM<=9) nM = "0"+nM;
    if(nS<=9) nS = "0"+nS;
    if (nMS > 24){
        $(".JS_dao").hide();
        $(".JS_daobefore").show();
    }else{
        $(".JS_dao").show();
        $(".JS_daoend").hide();
        $(".JS_RemainD").text(nD);
        $(".JS_RemainH").text(nH);
        $(".JS_RemainM").text(nM);
        $(".JS_RemainS").text(nS); 
    }
}
$(document).ready(function () {
    var timer_rt = window.setInterval("GetRTime()", 1000);
});

// JS_filter1
$(".JS_popwinbtn").live("click",function(){
    var top = getScrollTop();
    top = top - 35;
    $('body').append('<div class="JS_filter opacity"></div>');
    $('.JS_popwincon').css({
        "top": top, 
        "position": 'absolute'
    });
    $('.JS_popwincon').appendTo('body').fadeIn(320);
    $('.JS_popwincon').show();
    return false;
})

$(".JS_close1,.JS_filter").live("click",function(){
    $(".JS_filter").remove();
    $('.JS_popwincon').fadeOut(160);
    return false;
})

// JS_filter2
$(".JS_popwinbtn1").live("click",function(){
    var top = getScrollTop();
    top = top - 35;
    $('body').append('<div class="JS_filter1 opacity"></div>');
    $('.JS_popwincon1').css({
        "top": top, 
        "position": 'absolute'
    });
    $('.JS_popwincon1').appendTo('body').fadeIn(320);
    $('.JS_popwincon1').show();
    return false;
})

$(".JS_close2,.JS_filter1").live("click",function(){
    $(".JS_filter1").remove();
    $('.JS_popwincon1').fadeOut(160);
    return false;
})

// JS_filter3
$(".JS_popwinbtn2").live("click",function(){
    var top = getScrollTop();
    top = top - 35;
    $('body').append('<div class="JS_filter2 opacity"></div>');
    $('.JS_popwincon2').css({
        "top": top, 
        "position": 'absolute'
    });
    $('.JS_popwincon2').appendTo('body').fadeIn(320);
    $('.JS_popwincon2').show();
    return false;
})

$(".JS_close3,.JS_filter2").live("click",function(){
    $(".JS_filter2").remove();
    $('.JS_popwincon2').fadeOut(160);
    return false;
})

// JS_filter4
$(".JS_popwinbtn3").live("click",function(){
    var top = getScrollTop();
    top = top - 35;
    $('body').append('<div class="JS_filter3 opacity"></div>');
    $('.JS_popwincon3').css({
        "top": top, 
        "position": 'absolute'
    });
    $('.JS_popwincon3').appendTo('body').fadeIn(320);
    $('.JS_popwincon3').show();
    return false;
})

$(".JS_close4,.JS_filter3").live("click",function(){
    $(".JS_filter3").remove();
    $('.JS_popwincon3').fadeOut(160);
    return false;
})

// JS_filter5
$(".JS_popwinbtn4").live("click",function(){
    var top = getScrollTop();
    top = top - 35;
    $('body').append('<div class="JS_filter4 opacity"></div>');
    $('.JS_popwincon4').css({
        "top": top, 
        "position": 'absolute'
    });
    $('.JS_popwincon4').appendTo('body').fadeIn(320);
    $('.JS_popwincon4').show();
    return false;
})

$(".JS_close5,.JS_filter4").live("click",function(){
    $(".JS_filter4").remove();
    $('.JS_popwincon4').fadeOut(160);
    return false;
})

		
function getScrollTop() {
    var scrollPos; 
    if (window.pageYOffset) 
    {
        scrollPos = window.pageYOffset;
    } 
    else if (document.compatMode && document.compatMode != 'BackCompat')
    { 
        scrollPos = document.documentElement.scrollTop; 
    } 
    else if (document.body) 
    { 
        scrollPos = document.body.scrollTop; 
    } 
    return scrollPos; 
}


// tab
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

// 显示/隐藏
$(".JS_hide1").live('click', function(){
    $(".JS_showcon1").hide();
    $(".JS_hide1").hide();
    $(".JS_show1").show();
});
$(".JS_show1").live('click', function(){
    $(".JS_showcon1").show();
    $(".JS_show1").hide();
    $(".JS_hide1").show();
});

/* cart side */
$.fn.smartFloat = function() {
    var position = function(element) {
        var top = element.position().top, pos = element.css("position");
        $(window).scroll(function() {
            var scrolls = $(this).scrollTop();
            if (scrolls > top) {
                if (window.XMLHttpRequest) {
                    element.css({
                        position: "fixed",
                        top: 100
                    });
                } else {
                    element.css({
                        top: scrolls
                    });
                }
            }else {
                element.css({
                    position: pos,
                    top: top
                });
            }
        });
    };
    return $(this).each(function() {
        position($(this));
    });
};

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