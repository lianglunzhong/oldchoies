$(document).ready(function(){
	$('#check_all').click(function(){
		if($("#check_all").attr("checked")){
			$("input[id='check']").attr("checked",true);
		}else{
			$("input[id='check']").attr("checked",false);
		}
	});
});