$(function(){
	$(".choice").hover(function(){
        $(this).addClass("hover");
    },function(){
        $(this).removeClass("hover");
    });

    $(".pro-item").hover(function(){
        $(this).addClass("hover");
    },function(){
        $(this).removeClass("hover");
    });

    $(".pro-item .add-wish .fa").hover(function(){
        $(this).parent(".add-wish").addClass("hover");
    },function(){
        $(this).parent(".add-wish").removeClass("hover");
    });

    $(".pro-item .add-wish .fa").click(function() {
    	var _proItem = $(this).parents(".pro-item");
    	_proItem.find(".overlay").show();
    	_proItem.find(".sign-warp").show();
    });

    $(".pro-item .sign-close").click(function() {
    	var _proItem = $(this).parents(".pro-item");
    	_proItem.find(".overlay").hide();
    	_proItem.find(".sign-warp").hide();
    });

    $("#JS_filterAll").click(function() {
    	$(".filter-list").show();
    });

    $("#JS_filterClose").click(function() {
    	$(".filter-list").hide();
    });

    $(".filter-selected .fa").click(function() {
    	$(this).parent(".item").hide();
    });

})
$(".filter-list .choice-option a :checkbox").click(function(){
        $(this).parents(".choice-list").find(":checkbox").not($(this)).attr('checked',false);
    })