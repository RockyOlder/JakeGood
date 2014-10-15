// JavaScript Document

$(function(){
	$(".simple-stick-qrcode .close").click(function(){
		$(this).parent().parent().hide();	
	});	
});

$(function(){
	$(".J-common-tip .close").click(function(){
		$(this).parent().hide();	
	});	
});


$(function(){
	$("#question-stick").hover(function(){
		$(this).find(".questions").show();	
	},function(){
		$(this).find(".questions").hide();		
	});
});

$(function(){
	$(".info>.op>a").hover(function(){
		$(".opinfo>.uix-tooltip-tip").css("visibility","hidden");
		$(".opinfo>.uix-tooltip-tip").eq($(this).index()).css("visibility","visible");
	});	
	
	$(".showdiv").mouseleave(function(){
		$(".opinfo>.uix-tooltip-tip").css("visibility","hidden");
	});
	
	$(".side-nav__account").mousemove(function(){
		$(".opinfo>.uix-tooltip-tip").css("visibility","hidden");
	});
		
});