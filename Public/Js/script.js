$(document).ready(function() {
	$(".btn-info").click(function() {
		$(".mx_list").fadeIn(100);
		$(".mx-poptit").slideDown(200);
	});
	$(".mx-poptit .close").click(function() {
		window.location.href = window.location.href;
		$(".mx_list").fadeOut(100);
		$(".mx-poptit").slideUp(200);
	});
	$(".selectall").click(function(){
		if($(this).is(":checked")){
			$(".checkitem").prop("checked",true);
			}else{
			$(".checkitem").prop("checked",false);
			}
	});
	$(".checkitem").click(function(){
		$('.selectall').attr('checked', false);
	});
});
