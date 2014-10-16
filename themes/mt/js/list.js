//导航菜单
$(function(){
	$(".component-cate-nav").hover(function(){
		$(this).find(".mt-cates").addClass("nav-unfolded");
		$(this).find(".J-nav__list--present").show();
	},function(){
		$(this).find(".mt-cates").removeClass("nav-unfolded");
		$(this).find(".J-nav__list--present").hide();	
	});
});


//抽奖
function upul(){
	
	var uls=$("#lottery-list>.lottery-result-list");
	if(uls.eq(0).css("top")=="-72px"){
		uls.eq(0).css("top","72px");
		uls.eq(1).animate({top:'-72px'},"slow");
		uls.eq(0).animate({top:'0px'},"slow");
		
	}
	else{
		uls.eq(1).css("top","72px");
		uls.eq(0).animate({top:'-72px'},"slow");
		uls.eq(1).animate({top:'0px'},"slow");
	}
}

window.setInterval(upul,3000);


//tag标签下拉菜单
$(function(){
	$(".breadcrumb__item").hover(function(){
		$(this).addClass("dropdown--open");	
	},function(){
		$(this).removeClass("dropdown--open")
	});
});
//浮动导航滑动网页
$(window).scroll(function(){
	if($("#yScroll1").offset().top<$(document).scrollTop()+20){
          //  alert(1)
		$("#yScroll1").addClass("common-fixed");
		//$("#J-nav-buy").show();	
	}else{
		$("#yScroll1").removeClass("common-fixed");
		//$("#J-nav-buy").hide();	
	}
});