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
            '/site/ajax_product?lang=fr',
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
                    $('#product_rate').html(product['rate']+"% de réduction");
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
                    $(".btn_size").append('<input type="hidden" name="attributes[Size]" value="" class="s-size" /><div id="select_size" class="mb10">Sélectionner la taille:</div>');
                    var attribute = product['attributeSize'].replace('value="one size"', 'value="taille unique"');
                    $(".btn_size").append(attribute);
                }
                
                if(product['attributeColor'] != '')
                {
                    $(".btn_color").html('');
                    $(".btn_color").append('<input type="hidden" name="attributes[Color]" value="" class="s-color" /><div id="select_color" class="mb10">Veuillez sélectionner la couleur:</div>');
                    $(".btn_color").append(product['attributeColor']);
                }
                
                if(product['attributeType'] != '')
                {
                    $(".btn_type").html('');
                    $(".btn_type").append('<input type="hidden" name="attributes[Type]" value="" class="s-type" /><div id="select_type" class="mb10">sélectionner le type:</div>');
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
                        bimage = '/pimages/' + product['images'][n]['id'] + '/2.' + product['images'][n]['suffix'];
                        simage = '/pimages/' + product['images'][n]['id'] + '/3.' + product['images'][n]['suffix'];
                    }
                    else
                    {
                        bimage = '/pimages1/' + product['images'][n]['id'] + '/2.' + product['images'][n]['suffix'];
                        simage = '/pimages1/' + product['images'][n]['id'] + '/3.' + product['images'][n]['suffix'];
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
                    $("#outofstock").html('(seulement ' + product['stock'] + ' restant!)');
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
        
        $(".btn_size input").live("click",function(){
            if($(this).attr('class') != 'btn_size_normal')
            {
                return false;
            }
            var value = $(this).attr('id');
            $(".s-size").val(value);
            $(this).siblings().removeClass('btn_size_select');
            $(this).addClass('btn_size_select');
            $("#select_size").html('Taille: '+$(this).val());
            var qty = $(this).attr('title');
            if(qty)
                $("#only_left").html('seulement '+qty+' restant!');
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
            $("#select_color").html('Farbe: '+$(this).val());
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
            $("#select_type").html('Typ: '+$(this).val());
        })
        
        $('#addWishList').live("click",function(){
            var id = $('#product_id').val();
            window.location.href = 'fr/wishlist/add/'+id;
            return false;
        })

        $('.detail_tab2 li').mouseover(function(){
        var liindex = $('.detail_tab2 li').index(this);
        $(this).addClass('current').siblings().removeClass('current');
        $('.detail_tabcon2 div.bd').eq(liindex).fadeIn(150).siblings('div.bd').stop(false,true).hide();
        var liWidth = $('.detail_tab2 li').width();
        $('.last .detail_tab2 p').stop(false,true).animate({'left' : liindex * liWidth + 'px'},300);
        });
    })