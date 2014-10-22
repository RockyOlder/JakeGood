// JavaScript Document

$(function(){
	$(window).scroll(function(){
		var top=$(".category-floor").first().offset().top-$(document).scrollTop()+85;
		if(top<0)top=0;	
		//var bottomheigh = ($(".component-holy-reco").offset().top-$(document).scrollTop())-$(".elevator-wrapper").height();
		//if(bottomheigh<0)top=bottomheigh;
		$(".elevator-wrapper").css("top",top);
	});
	
	if($(window).width()<1310){
		$(".elevator-wrapper").hide();
	}
});


//左侧漂浮导航点击滑动
$(function(){
	$(".elevator-wrapper>.elevator>li").click(function(){
		var index=$(this).index();
		var scrollheight=$(".floors .category-floor").eq(index).offset().top;
		$('html, body').animate({scrollTop:scrollheight}, 'slow'); 
	});
});