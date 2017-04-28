// JavaScript Document
$(
function(){
	$(".datalist tbody tr").hover(function(){$(this).addClass("hover");}, function(){$(this).removeClass("hover");});
	$(".datalist tbody tr").click(function(){$(".datalist tbody tr").removeClass("active");$(this).addClass("active");});
	$(".datalist tbody tr:even").addClass("even");
	$(".datalist tbody tr:odd").addClass("odd");
	$(".ui-datepicker-prev, ui-datepicker-next").live('click', function(){
		return false;
	})
})