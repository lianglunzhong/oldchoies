;(function(d){d.flexslider=function(i,k){var a=d(i),c=d.extend({},d.flexslider.defaults,k),e=c.namespace,p="ontouchstart"in window||window.DocumentTouch&&document instanceof DocumentTouch,t=p?"touchend":"click",l="vertical"===c.direction,m=c.reverse,h=0<c.itemWidth,r="fade"===c.animation,s=""!==c.asNavFor,f={};d.data(i,"flexslider",a);f={init:function(){a.animating=!1;a.currentSlide=c.startAt;a.animatingTo=a.currentSlide;a.atEnd=0===a.currentSlide||a.currentSlide===a.last;a.containerSelector=c.selector.substr(0,c.selector.search(" "));a.slides=d(c.selector,a);a.container=d(a.containerSelector,a);a.count=a.slides.length;a.syncExists=0<d(c.sync).length;"slide"===c.animation&&(c.animation="swing");a.prop=l?"top":"marginLeft";a.args={};a.manualPause=!1;var b=a,g;if(g=!c.video)if(g=!r)if(g=c.useCSS)a:{g=document.createElement("div");var n=["perspectiveProperty","WebkitPerspective","MozPerspective","OPerspective","msPerspective"],e;for(e in n)if(void 0!==g.style[n[e]]){a.pfx=n[e].replace("Perspective","").toLowerCase();a.prop="-"+a.pfx+"-transform";g=!0;break a}g=!1}b.transitions=g;""!==c.controlsContainer&&(a.controlsContainer=0<d(c.controlsContainer).length&&d(c.controlsContainer));""!==c.manualControls&&(a.manualControls=0<d(c.manualControls).length&&d(c.manualControls));c.randomize&&(a.slides.sort(function(){return Math.round(Math.random())-0.5}),a.container.empty().append(a.slides));a.doMath();s&&f.asNav.setup();a.setup("init");c.controlNav&&f.controlNav.setup();c.directionNav&&f.directionNav.setup();c.keyboard&&(1===d(a.containerSelector).length||c.multipleKeyboard)&&d(document).bind("keyup",function(b){b=b.keyCode;if(!a.animating&&(39===b||37===b))b=39===b?a.getTarget("next"):37===b?a.getTarget("prev"):!1,a.flexAnimate(b,c.pauseOnAction)});c.mousewheel&&a.bind("mousewheel",function(b,g){b.preventDefault();var d=0>g?a.getTarget("next"):a.getTarget("prev");a.flexAnimate(d,c.pauseOnAction)});c.pausePlay&&f.pausePlay.setup();c.slideshow&&(c.pauseOnHover&&a.hover(function(){!a.manualPlay&&!a.manualPause&&a.pause()},function(){!a.manualPause&&!a.manualPlay&&a.play()}),0<c.initDelay?setTimeout(a.play,c.initDelay):a.play());p&&c.touch&&f.touch();(!r||r&&c.smoothHeight)&&d(window).bind("resize focus",f.resize);setTimeout(function(){c.start(a)},200)},asNav:{setup:function(){a.asNav=!0;a.animatingTo=Math.floor(a.currentSlide/a.move);a.currentItem=a.currentSlide;a.slides.removeClass(e+"active-slide").eq(a.currentItem).addClass(e+"active-slide");a.slides.click(function(b){b.preventDefault();var b=d(this),g=b.index();!d(c.asNavFor).data("flexslider").animating&&!b.hasClass("active")&&(a.direction=a.currentItem<g?"next":"prev",a.flexAnimate(g,c.pauseOnAction,!1,!0,!0))})}},controlNav:{setup:function(){a.manualControls?f.controlNav.setupManual():f.controlNav.setupPaging()},setupPaging:function(){var b=1,g;a.controlNavScaffold=d('<ol class="'+e+"control-nav "+e+("thumbnails"===c.controlNav?"control-thumbs":"control-paging")+'"></ol>');if(1<a.pagingCount)for(var n=0;n<a.pagingCount;n++)g="thumbnails"===c.controlNav?'<img src="'+a.slides.eq(n).attr("data-thumb")+'"/>':"<a>"+b+"</a>",a.controlNavScaffold.append("<li>"+g+"</li>"),b++;a.controlsContainer?d(a.controlsContainer).append(a.controlNavScaffold):a.append(a.controlNavScaffold);f.controlNav.set();f.controlNav.active();a.controlNavScaffold.delegate("a, img",t,function(b){b.preventDefault();var b=d(this),g=a.controlNav.index(b);b.hasClass(e+"active")||(a.direction=g>a.currentSlide?"next":"prev",a.flexAnimate(g,c.pauseOnAction))});p&&a.controlNavScaffold.delegate("a","click touchstart",function(a){a.preventDefault()})},setupManual:function(){a.controlNav=a.manualControls;f.controlNav.active();a.controlNav.live(t,function(b){b.preventDefault();var b=d(this),g=a.controlNav.index(b);b.hasClass(e+"active")||(g>a.currentSlide?a.direction="next":a.direction="prev",a.flexAnimate(g,c.pauseOnAction))});p&&a.controlNav.live("click touchstart",function(a){a.preventDefault()})},set:function(){a.controlNav=d("."+e+"control-nav li "+("thumbnails"===c.controlNav?"img":"a"),a.controlsContainer?a.controlsContainer:a)},active:function(){a.controlNav.removeClass(e+"active").eq(a.animatingTo).addClass(e+"active")},update:function(b,c){1<a.pagingCount&&"add"===b?a.controlNavScaffold.append(d("<li><a>"+a.count+"</a></li>")):1===a.pagingCount?a.controlNavScaffold.find("li").remove():a.controlNav.eq(c).closest("li").remove();f.controlNav.set();1<a.pagingCount&&a.pagingCount!==a.controlNav.length?a.update(c,b):f.controlNav.active()}},directionNav:{setup:function(){var b=d('<ul class="'+e+'direction-nav"><li><a class="'+e+'prev" href="#">'+c.prevText+'</a></li><li><a class="'+e+'next" href="#">'+c.nextText+"</a></li></ul>");a.controlsContainer?(d(a.controlsContainer).append(b),a.directionNav=d("."+e+"direction-nav li a",a.controlsContainer)):(a.append(b),a.directionNav=d("."+e+"direction-nav li a",a));f.directionNav.update();a.directionNav.bind(t,function(b){b.preventDefault();b=d(this).hasClass(e+"next")?a.getTarget("next"):a.getTarget("prev");a.flexAnimate(b,c.pauseOnAction)});p&&a.directionNav.bind("click touchstart",function(a){a.preventDefault()})},update:function(){var b=e+"disabled";1===a.pagingCount?a.directionNav.addClass(b):c.animationLoop?a.directionNav.removeClass(b):0===a.animatingTo?a.directionNav.removeClass(b).filter("."+e+"prev").addClass(b):a.animatingTo===a.last?a.directionNav.removeClass(b).filter("."+e+"next").addClass(b):a.directionNav.removeClass(b)}},pausePlay:{setup:function(){var b=d('<div class="'+e+'pauseplay"><a></a></div>');a.controlsContainer?(a.controlsContainer.append(b),a.pausePlay=d("."+e+"pauseplay a",a.controlsContainer)):(a.append(b),a.pausePlay=d("."+e+"pauseplay a",a));f.pausePlay.update(c.slideshow?e+"pause":e+"play");a.pausePlay.bind(t,function(b){b.preventDefault();d(this).hasClass(e+"pause")?(a.manualPause=!0,a.manualPlay=!1,a.pause()):(a.manualPause=!1,a.manualPlay=!0,a.play())});p&&a.pausePlay.bind("click touchstart",function(a){a.preventDefault()})},update:function(b){"play"===b?a.pausePlay.removeClass(e+"pause").addClass(e+"play").text(c.playText):a.pausePlay.removeClass(e+"play").addClass(e+"pause").text(c.pauseText)}},touch:function(){function b(b){j=l?d-b.touches[0].pageY:d-b.touches[0].pageX;p=l?Math.abs(j)<Math.abs(b.touches[0].pageX-e):Math.abs(j)<Math.abs(b.touches[0].pageY-e);if(!p||500<Number(new Date)-k)b.preventDefault(),!r&&a.transitions&&(c.animationLoop||(j/=0===a.currentSlide&&0>j||a.currentSlide===a.last&&0<j?Math.abs(j)/q+2:1),a.setProps(f+j,"setTouch"))}function g(){i.removeEventListener("touchmove",b,!1);if(a.animatingTo===a.currentSlide&&!p&&null!==j){var h=m?-j:j,l=0<h?a.getTarget("next"):a.getTarget("prev");a.canAdvance(l)&&(550>Number(new Date)-k&&50<Math.abs(h)||Math.abs(h)>q/2)?a.flexAnimate(l,c.pauseOnAction):r||a.flexAnimate(a.currentSlide,c.pauseOnAction,!0)}i.removeEventListener("touchend",g,!1);f=j=e=d=null}var d,e,f,q,j,k,p=!1;i.addEventListener("touchstart",function(j){a.animating?j.preventDefault():1===j.touches.length&&(a.pause(),q=l?a.h:a.w,k=Number(new Date),f=h&&m&&a.animatingTo===a.last?0:h&&m?a.limit-(a.itemW+c.itemMargin)*a.move*a.animatingTo:h&&a.currentSlide===a.last?a.limit:h?(a.itemW+c.itemMargin)*a.move*a.currentSlide:m?(a.last-a.currentSlide+a.cloneOffset)*q:(a.currentSlide+a.cloneOffset)*q,d=l?j.touches[0].pageY:j.touches[0].pageX,e=l?j.touches[0].pageX:j.touches[0].pageY,i.addEventListener("touchmove",b,!1),i.addEventListener("touchend",g,!1))},!1)},resize:function(){!a.animating&&a.is(":visible")&&(h||a.doMath(),r?f.smoothHeight():h?(a.slides.width(a.computedW),a.update(a.pagingCount),a.setProps()):l?(a.viewport.height(a.h),a.setProps(a.h,"setTotal")):(c.smoothHeight&&f.smoothHeight(),a.newSlides.width(a.computedW),a.setProps(a.computedW,"setTotal")))},smoothHeight:function(b){if(!l||r){var c=r?a:a.viewport;b?c.animate({height:a.slides.eq(a.animatingTo).height()},b):c.height(a.slides.eq(a.animatingTo).height())}},sync:function(b){var g=d(c.sync).data("flexslider"),e=a.animatingTo;switch(b){case"animate":g.flexAnimate(e,c.pauseOnAction,!1,!0);break;case"play":!g.playing&&!g.asNav&&g.play();break;case"pause":g.pause()}}};a.flexAnimate=function(b,g,n,i,k){s&&1===a.pagingCount&&(a.direction=a.currentItem<b?"next":"prev");if(!a.animating&&(a.canAdvance(b,k)||n)&&a.is(":visible")){if(s&&i)if(n=d(c.asNavFor).data("flexslider"),a.atEnd=0===b||b===a.count-1,n.flexAnimate(b,!0,!1,!0,k),a.direction=a.currentItem<b?"next":"prev",n.direction=a.direction,Math.ceil((b+1)/a.visible)-1!==a.currentSlide&&0!==b)a.currentItem=b,a.slides.removeClass(e+"active-slide").eq(b).addClass(e+"active-slide"),b=Math.floor(b/a.visible);else return a.currentItem=b,a.slides.removeClass(e+"active-slide").eq(b).addClass(e+"active-slide"),!1;a.animating=!0;a.animatingTo=b;c.before(a);g&&a.pause();a.syncExists&&!k&&f.sync("animate");c.controlNav&&f.controlNav.active();h||a.slides.removeClass(e+"active-slide").eq(b).addClass(e+"active-slide");a.atEnd=0===b||b===a.last;c.directionNav&&f.directionNav.update();b===a.last&&(c.end(a),c.animationLoop||a.pause());if(r)p?(a.slides.eq(a.currentSlide).css({opacity:0,zIndex:1}),a.slides.eq(b).css({opacity:1,zIndex:2}),a.slides.unbind("webkitTransitionEnd transitionend"),a.slides.eq(a.currentSlide).bind("webkitTransitionEnd transitionend",function(){c.after(a)}),a.animating=!1,a.currentSlide=a.animatingTo):(a.slides.eq(a.currentSlide).fadeOut(c.animationSpeed,c.easing),a.slides.eq(b).fadeIn(c.animationSpeed,c.easing,a.wrapup));else{var q=l?a.slides.filter(":first").height():a.computedW;h?(b=c.itemWidth>a.w?2*c.itemMargin:c.itemMargin,b=(a.itemW+b)*a.move*a.animatingTo,b=b>a.limit&&1!==a.visible?a.limit:b):b=0===a.currentSlide&&b===a.count-1&&c.animationLoop&&"next"!==a.direction?m?(a.count+a.cloneOffset)*q:0:a.currentSlide===a.last&&0===b&&c.animationLoop&&"prev"!==a.direction?m?0:(a.count+1)*q:m?(a.count-1-b+a.cloneOffset)*q:(b+a.cloneOffset)*q;a.setProps(b,"",c.animationSpeed);if(a.transitions){if(!c.animationLoop||!a.atEnd)a.animating=!1,a.currentSlide=a.animatingTo;a.container.unbind("webkitTransitionEnd transitionend");a.container.bind("webkitTransitionEnd transitionend",function(){a.wrapup(q)})}else a.container.animate(a.args,c.animationSpeed,c.easing,function(){a.wrapup(q)})}c.smoothHeight&&f.smoothHeight(c.animationSpeed)}};a.wrapup=function(b){!r&&!h&&(0===a.currentSlide&&a.animatingTo===a.last&&c.animationLoop?a.setProps(b,"jumpEnd"):a.currentSlide===a.last&&(0===a.animatingTo&&c.animationLoop)&&a.setProps(b,"jumpStart"));a.animating=!1;a.currentSlide=a.animatingTo;c.after(a)};a.animateSlides=function(){a.animating||a.flexAnimate(a.getTarget("next"))};a.pause=function(){clearInterval(a.animatedSlides);a.playing=!1;c.pausePlay&&f.pausePlay.update("play");a.syncExists&&f.sync("pause")};a.play=function(){a.animatedSlides=setInterval(a.animateSlides,c.slideshowSpeed);a.playing=!0;c.pausePlay&&f.pausePlay.update("pause");a.syncExists&&f.sync("play")};a.canAdvance=function(b,g){var d=s?a.pagingCount-1:a.last;return g?!0:s&&a.currentItem===a.count-1&&0===b&&"prev"===a.direction?!0:s&&0===a.currentItem&&b===a.pagingCount-1&&"next"!==a.direction?!1:b===a.currentSlide&&!s?!1:c.animationLoop?!0:a.atEnd&&0===a.currentSlide&&b===d&&"next"!==a.direction?!1:a.atEnd&&a.currentSlide===d&&0===b&&"next"===a.direction?!1:!0};a.getTarget=function(b){a.direction=b;return"next"===b?a.currentSlide===a.last?0:a.currentSlide+1:0===a.currentSlide?a.last:a.currentSlide-1};a.setProps=function(b,g,d){var e,f=b?b:(a.itemW+c.itemMargin)*a.move*a.animatingTo;e=-1*function(){if(h)return"setTouch"===g?b:m&&a.animatingTo===a.last?0:m?a.limit-(a.itemW+c.itemMargin)*a.move*a.animatingTo:a.animatingTo===a.last?a.limit:f;switch(g){case"setTotal":return m?(a.count-1-a.currentSlide+a.cloneOffset)*b:(a.currentSlide+a.cloneOffset)*b;case"setTouch":return b;case"jumpEnd":return m?b:a.count*b;case"jumpStart":return m?a.count*b:b;default:return b}}()+"px";a.transitions&&(e=l?"translate3d(0,"+e+",0)":"translate("+e+",0)",d=void 0!==d?d/1E3+"s":"0s",a.container.css("-"+a.pfx+"-transition-duration",d));a.args[a.prop]=e;(a.transitions||void 0===d)&&a.container.css(a.args)};a.setup=function(b){if(r)a.slides.css({width:"100%","float":"left",marginRight:"-100%",position:"relative"}),"init"===b&&(p?a.slides.css({opacity:0,display:"block",webkitTransition:"opacity "+c.animationSpeed/1E3+"s ease",zIndex:1}).eq(a.currentSlide).css({opacity:1,zIndex:2}):a.slides.eq(a.currentSlide).fadeIn(c.animationSpeed,c.easing)),c.smoothHeight&&f.smoothHeight();else{var g,n;"init"===b&&(a.viewport=d('<div class="'+e+'viewport"></div>').css({overflow:"hidden",position:"relative"}).appendTo(a).append(a.container),a.cloneCount=0,a.cloneOffset=0,m&&(n=d.makeArray(a.slides).reverse(),a.slides=d(n),a.container.empty().append(a.slides)));c.animationLoop&&!h&&(a.cloneCount=2,a.cloneOffset=1,"init"!==b&&a.container.find(".clone").remove(),a.container.append(a.slides.first().clone().addClass("clone")).prepend(a.slides.last().clone().addClass("clone")));a.newSlides=d(c.selector,a);g=m?a.count-1-a.currentSlide+a.cloneOffset:a.currentSlide+a.cloneOffset;l&&!h?(a.container.height(200*(a.count+a.cloneCount)+"%").css("position","absolute").width("100%"),setTimeout(function(){a.newSlides.css({display:"block"});a.doMath();a.viewport.height(a.h);a.setProps(g*a.h,"init")},"init"===b?100:0)):(a.container.width(200*(a.count+a.cloneCount)+"%"),a.setProps(g*a.computedW,"init"),setTimeout(function(){a.doMath();a.newSlides.css({width:a.computedW,"float":"left",display:"block"});c.smoothHeight&&f.smoothHeight()},"init"===b?100:0))}h||a.slides.removeClass(e+"active-slide").eq(a.currentSlide).addClass(e+"active-slide")};a.doMath=function(){var b=a.slides.first(),d=c.itemMargin,e=c.minItems,f=c.maxItems;a.w=a.width();a.h=b.height();a.boxPadding=b.outerWidth()-b.width();h?(a.itemT=c.itemWidth+d,a.minW=e?e*a.itemT:a.w,a.maxW=f?f*a.itemT:a.w,a.itemW=a.minW>a.w?(a.w-d*e)/e:a.maxW<a.w?(a.w-d*f)/f:c.itemWidth>a.w?a.w:c.itemWidth,a.visible=Math.floor(a.w/(a.itemW+d)),a.move=0<c.move&&c.move<a.visible?c.move:a.visible,a.pagingCount=Math.ceil((a.count-a.visible)/a.move+1),a.last=a.pagingCount-1,a.limit=1===a.pagingCount?0:c.itemWidth>a.w?(a.itemW+2*d)*a.count-a.w-d:(a.itemW+d)*a.count-a.w-d):(a.itemW=a.w,a.pagingCount=a.count,a.last=a.count-1);a.computedW=a.itemW-a.boxPadding};a.update=function(b,d){a.doMath();h||(b<a.currentSlide?a.currentSlide+=1:b<=a.currentSlide&&0!==b&&(a.currentSlide-=1),a.animatingTo=a.currentSlide);if(c.controlNav&&!a.manualControls)if("add"===d&&!h||a.pagingCount>a.controlNav.length)f.controlNav.update("add");else if("remove"===d&&!h||a.pagingCount<a.controlNav.length)h&&a.currentSlide>a.last&&(a.currentSlide-=1,a.animatingTo-=1),f.controlNav.update("remove",a.last);c.directionNav&&f.directionNav.update()};a.addSlide=function(b,e){var f=d(b);a.count+=1;a.last=a.count-1;l&&m?void 0!==e?a.slides.eq(a.count-e).after(f):a.container.prepend(f):void 0!==e?a.slides.eq(e).before(f):a.container.append(f);a.update(e,"add");a.slides=d(c.selector+":not(.clone)",a);a.setup();c.added(a)};a.removeSlide=function(b){var e=isNaN(b)?a.slides.index(d(b)):b;a.count-=1;a.last=a.count-1;isNaN(b)?d(b,a.slides).remove():l&&m?a.slides.eq(a.last).remove():a.slides.eq(b).remove();a.doMath();a.update(e,"remove");a.slides=d(c.selector+":not(.clone)",a);a.setup();c.removed(a)};f.init()};d.flexslider.defaults={namespace:"flex-",selector:".slides > li",animation:"fade",easing:"swing",direction:"horizontal",reverse:!1,animationLoop:!0,smoothHeight:!1,startAt:0,slideshow:!0,slideshowSpeed:5000,animationSpeed:400,initDelay:0,randomize:!1,pauseOnAction:!0,pauseOnHover:!0,useCSS:!0,touch:!0,video:!1,controlNav:!0,directionNav:!0,prevText:"Previous",nextText:"Next",keyboard:!0,multipleKeyboard:!1,mousewheel:!1,pausePlay:!1,pauseText:"Pause",playText:"Play",controlsContainer:"",manualControls:"",sync:"",asNavFor:"",itemWidth:0,itemMargin:0,minItems:0,maxItems:0,move:0,start:function(){},before:function(){},after:function(){},end:function(){},added:function(){},removed:function(){}};d.fn.flexslider=function(i){void 0===i&&(i={});if("object"===typeof i)return this.each(function(){var a=d(this),c=a.find(i.selector?i.selector:".slides > li");1===c.length?(c.fadeIn(400),i.start&&i.start(a)):void 0==a.data("flexslider")&&new d.flexslider(this,i)});var k=d(this).data("flexslider");switch(i){case"play":k.play();break;case"pause":k.pause();break;case"next":k.flexAnimate(k.getTarget("next"),!0);break;case"prev":case"previous":k.flexAnimate(k.getTarget("prev"),!0);break;default:"number"===typeof i&&k.flexAnimate(i,!0)}}})(jQuery);

// 弹窗插件
(function($) {

/*---------------------------
 Defaults for Reveal
----------------------------*/
     
/*---------------------------
 Listener for data-reveal-id attributes
----------------------------*/

    $('a[data-reveal-id]').live('click', function(e) {
        e.preventDefault();
        var modalLocation = $(this).attr('data-reveal-id');
        $('#'+modalLocation).reveal($(this).data());
    });

/*---------------------------
 Extend and Execute
----------------------------*/

    $.fn.reveal = function(options) {
        
        
        var defaults = {  
            animation: 'fadeAndPop', //fade, fadeAndPop, none
            animationspeed: 400, //how fast animtions are
            closeonbackgroundclick: true, //if you click background will modal close?
            dismissmodalclass: 'close-reveal-modal' //the class of a button or element that will close an open modal
        }; 
        
        //Extend dem' options
        var options = $.extend({}, defaults, options); 
    
        return this.each(function() {
        
/*---------------------------
 Global Variables
----------------------------*/
            var modal = $(this),
                topMeasure  = parseInt(modal.css('top')),
                topOffset = modal.height() + topMeasure,
                locked = false,
                modalBG = $('.reveal-modal-bg');

/*---------------------------
 Create Modal BG
----------------------------*/
            if(modalBG.length == 0) {
                modalBG = $('<div class="reveal-modal-bg" />').insertAfter(modal);
            }           
     
/*---------------------------
 Open & Close Animations
----------------------------*/
            //Entrance Animations
            modal.bind('reveal:open', function () {
              modalBG.unbind('click.modalEvent');
                $('.' + options.dismissmodalclass).unbind('click.modalEvent');
                if(!locked) {
                    lockModal();
                    if(options.animation == "fadeAndPop") {
                        modal.css({'top': $(document).scrollTop()-topOffset, 'opacity' : 0, 'visibility' : 'visible'});
                        modalBG.fadeIn(options.animationspeed/2);
                        modal.delay(options.animationspeed/2).animate({
                            "top": $(document).scrollTop()+topMeasure + 'px',
                            "opacity" : 1
                        }, options.animationspeed,unlockModal());                   
                    }
                    if(options.animation == "fade") {
                        modal.css({'opacity' : 0, 'visibility' : 'visible', 'top': $(document).scrollTop()+topMeasure});
                        modalBG.fadeIn(options.animationspeed/2);
                        modal.delay(options.animationspeed/2).animate({
                            "opacity" : 1
                        }, options.animationspeed,unlockModal());                   
                    } 
                    if(options.animation == "none") {
                        modal.css({'visibility' : 'visible', 'top':$(document).scrollTop()+topMeasure});
                        modalBG.css({"display":"block"});   
                        unlockModal()               
                    }
                }
                modal.unbind('reveal:open');
            });     

            //Closing Animation
            modal.bind('reveal:close', function () {
              if(!locked) {
                    lockModal();
                    if(options.animation == "fadeAndPop") {
                        modalBG.delay(options.animationspeed).fadeOut(options.animationspeed);
                        modal.animate({
                            "top":  $(document).scrollTop()-topOffset + 'px',
                            "opacity" : 0
                        }, options.animationspeed/2, function() {
                            modal.css({'top':topMeasure, 'opacity' : 1, 'visibility' : 'hidden'});
                            unlockModal();
                        });                 
                    }   
                    if(options.animation == "fade") {
                        modalBG.delay(options.animationspeed).fadeOut(options.animationspeed);
                        modal.animate({
                            "opacity" : 0
                        }, options.animationspeed, function() {
                            modal.css({'opacity' : 1, 'visibility' : 'hidden', 'top' : topMeasure});
                            unlockModal();
                        });                 
                    }   
                    if(options.animation == "none") {
                        modal.css({'visibility' : 'hidden', 'top' : topMeasure});
                        modalBG.css({'display' : 'none'});  
                    }       
                }
                modal.unbind('reveal:close');
            });     
    
/*---------------------------
 Open and add Closing Listeners
----------------------------*/
            //Open Modal Immediately
        modal.trigger('reveal:open')
            
            //Close Modal Listeners
            var closeButton = $('.' + options.dismissmodalclass).bind('click.modalEvent', function () {
              modal.trigger('reveal:close')
            });
            
            if(options.closeonbackgroundclick) {
                modalBG.css({"cursor":"pointer"})
                modalBG.bind('click.modalEvent', function () {
                  modal.trigger('reveal:close')
                });
            }
            $('body').keyup(function(e) {
                if(e.which===27){ modal.trigger('reveal:close'); } // 27 is the keycode for the Escape key
            });
            
            
/*---------------------------
 Animations Locks
----------------------------*/
            function unlockModal() { 
                locked = false;
            }
            function lockModal() {
                locked = true;
            }   
            
        });//each call
    }//orbit plugin call
})(jQuery);

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



(function($){$.fn.extend({"banner_thaw":function(o){o=$.extend({thumbObj:null,botPrev:null,botNext:null,thumbNowClass:'hover',thumbOverEvent:true,slideTime:1000,autoChange:true,clickFalse:true,overStop:true,changeTime:5000,delayTime:300,pause:false,pauseClass:'promo_paush',pauseText:'paush',playClass:'promo_play',playText:'play',otherobj:null,animatetime:500},o||{});var _self=$(this);var thumbObj;var size=_self.size();var nowIndex=0;var index;var startRun;var delayRun;var positionobj=$(o.thumbObj).eq(0).position();function fadeAB(){if(nowIndex!=index){if(o.thumbObj!=null&&positionobj!=null){$(o.thumbObj).removeClass(o.thumbNowClass).eq(index).addClass(o.thumbNowClass);$(o.otherobj).animate({left:$(o.thumbObj).eq(index).position().left},o.animatetime);};_curr_banner_obj=_self.eq(index).find("img");if(_curr_banner_obj.attr("original")&&(_curr_banner_obj.attr("src")!=_curr_banner_obj.attr("original"))){_curr_banner_obj.attr("src",_curr_banner_obj.attr("original"));}
if(o.slideTime<=0){_self.eq(nowIndex).hide();_self.eq(index).show();}else{_self.eq(nowIndex).fadeOut(o.slideTime);_self.eq(index).fadeIn(o.slideTime);};nowIndex=index;};};function runNext(){index=(nowIndex+1)%size;fadeAB();};_self.hide().eq(0).show();if(o.thumbObj!=null){thumbObj=$(o.thumbObj);otherobj=$(o.otherobj);thumbObj.removeClass(o.thumbNowClass).eq(0).addClass(o.thumbNowClass);if(positionobj!=null){otherobj.css("left",positionobj.left)}
thumbObj.click(function(){index=thumbObj.index($(this));fadeAB();if(o.clickFalse==true){return false;};});if(o.thumbOverEvent==true){thumbObj.mouseenter(function(){clearInterval(startRun);index=thumbObj.index($(this));delayRun=setTimeout(fadeAB,o.delayTime);});thumbObj.mouseleave(function(){clearTimeout(delayRun);startRun=setInterval(runNext,o.changeTime);});if(o.otherobj!=null){$(o.otherobj).mouseenter(function(){clearInterval(startRun);});$(o.otherobj).mouseleave(function(){startRun=setInterval(runNext,o.changeTime);})}};};if(o.botNext!=null){$(o.botNext).click(function(){if(_self.queue().length<1){runNext();};return false;});};if(o.botPrev!=null){$(o.botPrev).click(function(){if(_self.queue().length<1){index=(nowIndex+size-1)%size;fadeAB();};return false;});};if(o.autoChange==true){startRun=setInterval(runNext,o.changeTime);if(o.overStop==true){_self.hover(function(){clearInterval(startRun);},function(){if(o.pause==true&&$("."+o.pauseClass).hasClass(o.playClass)){}else{startRun=setInterval(runNext,o.changeTime);};});};if(o.pause==true){$("."+o.pauseClass).click(function(){if($("."+o.pauseClass).hasClass(o.playClass)){startRun=setInterval(runNext,o.changeTime);$("."+o.pauseClass).removeClass(o.playClass).text(o.pauseText);}else{clearInterval(startRun);$("."+o.pauseClass).addClass(o.playClass).text(o.playText);};});};};}})})(jQuery);

/* ============================== 产品页 脚本 ============================== End */



