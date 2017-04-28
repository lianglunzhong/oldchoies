$(function(){
    $(".pro_listcon .pic div").live('hover', function(){
        if($(this).siblings().length > 0)
        {
            $(this).toggle();
            $(this).siblings().toggle();
        } 
    },function(){
        if($(this).siblings().length > 0)
        {
            $(this).toggle();
            $(this).siblings().toggle();
        } 
    })
                
    $('.quick_view').live("click",function(){
        var id = $(this).attr('id');
        $.post(
            '/site/ajax_product',
            {
                id: id
            },
            function(product)
            {
                $('#product_id').val(id);
                $('#product_items').val(id);
                $('#product_type').val(product['type']);
                $('#product_name').html(product['name']);
                $('#product_sku').html(product['sku']);
                $('#product_link').attr('href', product['link']);
                $('#product_price').html(product['price']);
                $('#product_s_price').html(product['s_price']);
                if(product['s_price']!=""){
                    $('#product_rate').html(product['rate']+"% off");
                }else{
                    $('#product_rate').html("");
                }

                $('#product_s_price').html(product['s_price']);
                if(product['reviews_data']>0){
                    $('#review_date').html('<strong class="rating_show1 star'+product['reviews_data']+'"></strong>');
                }else{
                    $('#review_date').html('<strong class="rating_show1"></strong>');
                }
                if(product['review_count']>0){
                    $('#review_count').html("(<a href='"+product['link']+"#review_list'>"+product['review_count']+"</a>)");
                }
                $('#wishlists').html(product['wishlists']);
                if(product['models']){
                    $('#tab-model').html(product['models']);
                }else{
                    $('.ss2').remove();
                    $('#tab-model').remove();
                }
                
                
                                
                //attributes
                if(product['attributeSize'] != '')
                {
                    $(".btn_size").html('');
                    $(".btn_size").append('<input type="hidden" name="attributes[Size]" value="" class="s-size" /><div id="select_size" class="mb10">Select Size:</div>');
                    $(".btn_size").append(product['attributeSize']);
                }
                                
                if(product['attributeColor'] != '')
                {
                    $(".btn_color").html('');
                    $(".btn_color").append('<input type="hidden" name="attributes[Color]" value="" class="s-color" /><div id="select_color" class="mb10">Select Color:</div>');
                    $(".btn_color").append(product['attributeColor']);
                }
                                
                if(product['attributeType'] != '')
                {
                    $(".btn_type").html('');
                    $(".btn_type").append('<input type="hidden" name="attributes[Type]" value="" class="s-type" /><div id="select_type" class="mb10">Select Type:</div>');
                    $(".btn_type").append(product['attributeType']);
                }
                                
                //images
                $('.myImgs').attr('alt', product['name']);
                $('.scrollableDiv').html('');
                var bimage = '';
                var simage = '';
                for(var n in product['images'])
                {
                    if(product['images'][n]['status'] == 0)
                    {
                        bimage = 'https://www.choies.com/pimages/' + product['images'][n]['id'] + '/2.' + product['images'][n]['suffix'];
                        simage = 'https://www.choies.com/pimages/' + product['images'][n]['id'] + '/3.' + product['images'][n]['suffix'];
                    }
                    else
                    {
                        bimage = 'https://www.choies.com/pimages1/' + product['images'][n]['id'] + '/2.' + product['images'][n]['suffix'];
                        simage = 'https://www.choies.com/pimages1/' + product['images'][n]['id'] + '/3.' + product['images'][n]['suffix'];
                    }
                    if(n == 0)
                    {
                        $('.myImgs').attr('src', bimage);
                    }
                    $('.scrollableDiv').append('<a><img src="'+simage+'" alt="'+product['name']+'" imgb="'+bimage+'"  bigimg="'+bimage+'" /></a>');
                }
                                
                $('#tab-detail').html(product['keywords'] + '<br><br>' + product['brief'] + '<br><br>' + product['description']);
                $('#tab-brief').html(product['brief']);
                var instock = 1;
                if(product['stock'] == 0 && product['stock'] != -99)
                {
                    var instock = 0;
                }
                else if(product['stock'] < 9)
                {
                    $("#quantity").html('');
                    for(i=1;i<=product['stock'];i ++)
                    {
                        $("#quantity").append('<option value="'+i+'">'+i+'</option>');
                    }
                }
                if(product['stock'] != -99 && product['stock'] > 0)
                {
                    $("#outofstock").html('( Only ' + product['stock'] + ' left! )');
                }
                                
                if(product['status'] == 0 || !instock)
                {
                    $('#outstock').show();
                    $('#stock').hide();
                    $('#addCart').hide();
                }
                else
                {
                    $('#stock').show();
                    $('#outstock').hide();
                    $('#addCart').show();
                }
                $('#only_left').html('');
                var top = getScrollTop();
                top = top - 35;
                $('body').append('<div class="JS_filter1 opacity"></div>');
                $('.JS_popwincon1').css({
                    "top": top, 
                    "position": 'absolute'
                });
                $('.JS_popwincon1').appendTo('body').fadeIn(320);
                $('.JS_popwincon1').show();
            },
            'json'
            );
        return false;
    })
    $("#catalog_link .close_btn2,#wingray").live("click",function(){
        $("#wingray").remove();
        $('#catalog_link').fadeOut(160).appendTo('#tab2');
        return false;
    })
                
    $('#addCart').live("click",function(){
        var btn_size = $('.btn_size').html();
        var size = $('.s-size').val();
        if(btn_size && !size)
        {
            alert('Please ' + $('#select_size').html());
            return false;
        }
    })
                
    $('#addCart').live("click",function(){
        var btn_color = $('.btn_color').html();
        var size = $('.s-color').val();
        if(btn_color && !size)
        {
            alert('Please ' + $('#select_color').html());
            return false;
        }
    })
        
    $('#addCart').live("click",function(){
        var btn_type = $('.btn_type').html();
        var type = $('.s-type').val();
        if(btn_type && !type)
        {
            alert('Please ' + $('#select_type').html());
            return false;
        }
    })
                
    $('#addWishList').live("click",function(){
        var id = $('#product_id').val();
        window.location.href = '/wishlist/add/'+id;
        return false;
    })
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

$(function(){
    $(".btn_size input").live("click",function(){
        if($(this).attr('class') != 'btn_size_normal')
        {
            return false;
        }
        var value = $(this).attr('id');
        $(".s-size").val(value);
        $(this).siblings().removeClass('btn_size_select');
        $(this).addClass('btn_size_select');
        $("#select_size").html('Size: '+$(this).val());
    })
                                                                        
    $(".btn_color input").live("click",function(){
        if($(this).attr('class') != 'btn_size_normal')
        {
            return false;
        }
        var value = $(this).attr('id');
        $(".s-color").val(value);
        $(this).siblings().removeClass('btn_size_select');
        $(this).addClass('btn_size_select');
        $("#select_color").html('Color: '+$(this).val());
    })
        
    $(".btn_type input").live("click",function(){
        if($(this).attr('class') != 'btn_size_normal')
        {
            return false;
        }
        var value = $(this).attr('id');
        $(".s-type").val(value);
        $(this).siblings().removeClass('btn_size_select');
        $(this).addClass('btn_size_select');
        $("#select_type").html('Type: '+$(this).val());
    })
})

// JavaScript Document
/* sidenav */
$(function(){
    $("h2").click(function(){    
        var $ul=$(this).next("ul");
        $ul.slideToggle("slow").prev("h2").addClass("on");
        $(".pare ul").not($ul).slideUp("slow").prev("h2").removeClass("on");
    }); 

})
function accordion(nav,content,on,type){
    $(nav).bind(type,function(){
        var $cur=$(this);
        $(nav).removeClass(on);
        $(content).hide();
        $cur.addClass(on);
        $cur.next(content).fadeIn();
    })
}
function switchIndex(nav,content,on,index){
    var $tab=$(nav).children().eq(index);
    var $content=$(content).children();
    $(nav).children().removeClass(on);
    $(nav).children().removeClass("next");
    $tab.addClass(on);
    $tab.next().addClass("next");
    $content.hide();
    $content.eq(index).show();
    $('html,body').animate({
        scrollTop:700
    },1000);
}
function menu(nav){
    $('li:has(> div)',nav).addClass('parent');
    $("li.parent",nav).hover(function(){
        $(this).addClass('on');
        $('> a',this).addClass('hover');
        $(this).children("div").stop(true,true).show();
    },function(){
        $(this).children("div").stop(true,true).hide();
        $(this).removeClass('on');
        $('> a',this).removeClass('hover');
    });
}
function menu2(nav){
    $('li:has(> ul)',nav).addClass('parent');
    $("li.parent",nav).hover(function(){
        $(this).addClass('on');
        $('> a',this).addClass('hover');
        $(this).children("ul").stop(true,true).slideDown();
    },function(){
        $(this).children("ul").stop(true,true).slideUp();
        $(this).removeClass('on');
        $('> a',this).removeClass('hover');
    });
}
function tab(nav,content,on,type)
{
    $(nav).children().bind(type,(function(){
        var $tab=$(this);
        var tab_index=$tab.prevAll().length;
        var $content=$(content).children();
        $(nav).children().removeClass(on);
        $(nav).children().removeClass("next");
        $tab.addClass(on);
        $tab.next().addClass("next");
        $content.hide();
        $content.eq(tab_index).show();
    }));
}
function inputSelect(){
    var g_DefaultText=[];
    var g_DefaultTextColor=[];
    var g_NormalTextColor=[];
    var g_o_num=0;
    function setText(oInputElement,text)

    {
        oInputElement.isDefault=false;
        oInputElement.value=text;
        oInputElement.style.color=g_NormalTextColor[oInputElement.index];
    }
    function input_onFocus(event)
    {
        if(this.isDefault)

        {
            this.value='';
            this.style.color=g_NormalTextColor[this.index];
        }
    }
    function input_onBlur(event)
    {
        if(this.value.length)

        {
            this.isDefault=false;
        }
        else
        {
            this.isDefault=true;
            this.value=g_DefaultText[this.index];
            this.style.color=g_DefaultTextColor[this.index];
        }
    }
    $$=function(id)
    {
        return"string"==typeof id?document.getElementById(id):id;
    }
}
function plays(value){
    for(i=0;i<3;i++)

    {
            if(i==value){
                document.getElementById("pc_"+value).style.display="block";
            }else{
                document.getElementById("pc_"+i).style.display="none";
            }
        }
}
function plays2(value){
    for(i=0;i<3;i++)

    {
            if(i==value){
                document.getElementById("pc2_"+value).style.display="block";
            }else{
                document.getElementById("pc2_"+i).style.display="none";
            }
        }
}
$(function(){
    $(".index_main .main_con1 .brand,.categoryBanner").mouseover(function(){
        $('.btn-prev').stop().animate({
            left:'0px'
        },'fast');
        $('.btn-next').stop().animate({
            right:'0px'
        },'fast');
        $(".brand .viewmore").css("display","block");
    }).mouseout(function(){
        $('.btn-prev').stop().animate({
            left:'-24px'
        },'fast');
        $('.btn-next').stop().animate({
            right:'-24px'
        },'fast');
        $(".brand .viewmore").css("display","none");
    })
})
$(function(){
    $(".index_main .main_con2 img, .index_main .main_con3 img").mouseover(function(){
        $(this).css("opacity","0.5");
    }).mouseout(function(){
        $(this).css("opacity","1");
    })
})

function scrollup()
{
    document.getElementById('index_scroll').scrollTop=document.getElementById('index_scroll').scrollTop-20;
}
function scrolldown()
{
    document.getElementById('index_scroll').scrollTop=document.getElementById('index_scroll').scrollTop+20;
}
function selectarea(curkey,keylist,sellist){
    var $tip=$(curkey),$keylist=$(keylist),$list=$(sellist);
    var len=$list.length;
    $tip.click(function(){
        $keylist.show();
    }).hover(function(){},function(){
        $keylist.hide();
    });
    $list.each(function(){
        $(this).click(function(){
            $tip.find("span").html($(this).html());
            $('input[name=cid]',$tip).val($(this).attr('real_value'));
            $keylist.hide();
            return false;
        });
    }).hover(function(){
        $(this).addClass("on");
    },function(){
        $(this).removeClass("on");
    });
}
$(function(){
    $('#recent_view').mouseover(function(){
        if($("#addToCart ul").text().length>100)

        {
            $('#addToCart').css("display","block");
            $bag=$("#addToCart .order_hight");
            if($bag.height()>480)

            {
                $bag.height("480px");
            }
        }
    }).mouseout(function(){
        $('#addToCart').css("display","none");
    })
})
