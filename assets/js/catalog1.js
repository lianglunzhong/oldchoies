$(function(){
    $('.quick_view').live("click",function(){

        var id = $(this).attr('id');
        var lang = $(this).attr('attr-lang');
        $.post(
            '/site/ajax_product',
            {
                id: id,
                lang: lang,
            },
            function(product)
            {
                $('#product_id').val(id);
                $('#product_items').val(id);
                $('#product_type').val(product['type']);
                $('#catalog').val(product['catalog']);
                $('#product_name').html(product['name']);
                $('#product_sku').html(product['sku']);
                $('#product_link').attr('href', product['link']);
                $('#product_price').html(product['price']);
                $('#product_s_price').html(product['s_price']);
                if(product['s_price']!=""){
                    $('#product_rate').html(product['rate']);
                    $('#product_rate_show').show();
                }else{
                    $('#product_rate').html("");
                    $('#product_rate_show').hide();
                }

                $('#product_s_price').html(product['s_price']);
                var review_data = '';
                if(product['reviews_data']>0){
                    var r = parseFloat(product['reviews_data']);
                    while(r > 0)
                    {
                        if(r == 0.5)
                        {
                            review_data += '<i class="fa fa-star-half-full"></i>';
                        }
                        else
                        {
                            review_data += '<i class="fa fa-star"></i>';
                        }
                        r --;
                    }
                    $('#review_data').html(review_data);
                }else{
                    review_data = '<i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
                    $('#review_data').html(review_data);
                }
                $('#review_count').html("(<a href='"+product['link']+"#review_list'>"+product['review_count']+"</a>)");
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
                    var search = product['attributeSize'].toLowerCase();
                    if(search.indexOf('one size') > 0)
                    {
                        $("#btn_size").hide();
                        $("#one_size").show();
                    }
                    else
                    {
                        $("#btn_size").html('');
                        $("#btn_size").append(product['attributeSize']);
                        $("#btn_size").show();
                        $("#one_size").hide();
                    }
                    $(".s-size").val('');
                    $(".btn-size-normal").removeClass('on');
                    $("#select_size").show();
                    $("#size_span").hide();
                }
                                
                if(product['attributeColor'] != '')
                {
                    $("#btn_color").html('');
                    $("#btn_color").append(product['attributeColor']);
                    $(".btn-color").show();
                }
                else
                {
                    $(".btn-color").hide();
                }
                                
                if(product['attributeType'] != '')
                {
                    $("#btn_type").html('');
                    $("#btn_type").append(product['attributeType']);
                    $(".btn-type").show();
                }
                else
                {
                    $(".btn-type").hide();
                }
                                
                //images
                $('.myImgs').attr('alt', product['name']);
                $('.scrollableDiv').html('');
                var bimage = '';
                var simage = '';
                for(var n in product['images'])
                {
                    bimage = 'https://d1cr7zfsu1b8qs.cloudfront.net/pimg/420/' + product['images'][n]['id'] + '.' + product['images'][n]['suffix'];
                    simage = 'https://d1cr7zfsu1b8qs.cloudfront.net/pimg/75/' + product['images'][n]['id'] + '.' + product['images'][n]['suffix'];
                    if(n == 0)
                    {
                        $('.myImgs').attr('src', bimage);
                    }
                    $('.scrollableDiv').append('<a><img src="'+simage+'" alt="'+product['name']+'" imgb="'+bimage+'"  bigimg="'+bimage+'" /></a>');
                    $('.scrollableDiv').parent().show();
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
                                
                if(product['status'] == 0 || !instock)
                {
                    $('#outstock').show();
                    $('#stock').hide();
                    $('#addCart').hide();
					$('#outButton').show();
                }
                else
                {
                    $('#stock').show();
                    $('#outstock').hide();
                    $('#addCart').show();
                    $('#outButton').hide();
                }
                $('#only_left').html('');
            },
            'json'
            );
        return false;
    })

    $("#formAdd").submit(function(){
        $.post(
            '/cart/ajax_add',
            {
                id: $('#product_id').val(),
                type: $('#product_type').val(),
                size: $('.s-size').val(),
                color: $('.s-color').val(),
                attrtype: $('.s-type').val(),
                quantity: $('#count_1').val(),
                language: $('#language').val(),
            },
            function(product)
            {
				
			//	console.log(product);
                ajax_cart();
                addToCart();

                var ls = document.getElementById('language').value;                
                if(ls){
                    var direc = 'https://www.choies.com/'+ls+'/cart/view';
                }else{
                    var direc = 'https://www.choies.com/cart/view';
                }               
                var a = 1;
                 if(a){
                 window.location.href=direc;   
                }
                if($(document).scrollTop() > 120)
                {
                    //$('#mybagli2 .mybag-box').fadeIn(10).delay(3000).fadeOut(10);
                }
                else
                { 
                    //$('#mybagli1 .mybag-box').fadeIn(10).delay(3000).fadeOut(10);
                }
            },
            'json'
        );
        $(".JS-filter").remove();
        $('.JS-popwincon').fadeOut(160).appendTo('#tab2');
     //   location.reload();
        return false;
    })

    function addToCart(x) {
  ga('ec:addProduct', {
    'id': '$("#product_id").val()',
    'name': '$("#product_name").val()',
    'category': '$("#catalog").val()',
    'brand': 'Choies',
    'price': '$("#product_price").val()',
    'quantity': 1
  });

  ga('ec:setAction', 'add');
  ga('send', 'event', 'UX', 'click', 'add to cart');     // Send data using an event.

}
	
	    $('#addWishList').live("click",function(){
        var id = $('#product_id').val();
        var lang = $("#language").val();
        if(lang == '')
        {
            window.location.href = '/wishlist/add/'+id;
        }
        else
        {
            window.location.href = '/'+lang+'/wishlist/add/'+id;
        }
        return false;
    })
})