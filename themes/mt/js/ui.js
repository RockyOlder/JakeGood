// JavaScript Document

//下拉菜单
$(function(){
	$(".site-mast .dropdown").hover(function(){
		$(this).addClass("dropdown--open");	
	},function(){
		$(this).removeClass("dropdown--open");		
	});
});

//导航二级菜单
$(function(){
	$(".J-nav__list .J-nav-item").hover(function(){
		$(this).addClass("nav-active");
		$(this).addClass("nav-hover");
		$(this).find(".J-nav-level2").show();
	},function(){
		$(this).removeClass("nav-active");
		$(this).removeClass("nav-hover");
		$(this).find(".J-nav-level2").hide();
	});	
});



//搜索框选项下拉菜单
$(function(){
	$(".search-box__tabs-container").hover(function(){
		$(this).addClass("search-box__tabs-container--over");	
	},function(){
		$(this).removeClass("search-box__tabs-container--over");
	});	
});

//搜索框选项点击
$(function(){
	$(".search-box__tabs-container li").click(function(){
		if(!$(this).hasClass("search-box__tab--current")){
			$(this).parent().find("li").removeClass("search-box__tab--current");	
			$(this).addClass("search-box__tab--current");
			$(this).parent().prepend($(this));
			$(".search-box__tabs-container").removeClass("search-box__tabs-container--over");
		}
	});
});

//焦点图片切换
$(function(){
	$("#bzjx_pre").click(function(){
		var lis=$("#bzjx>li");
		var index=$("#bzjx>li[class*='mt-slider-current-sheet']").index();
		lis.removeClass("mt-slider-current-sheet");	
			lis.hide();
			lis.css("opacity","0");
		if(index>0){
			lis.eq(index-1).show();
			lis.eq(index-1).animate({opacity:'1'},300);
			lis.eq(index-1).addClass("mt-slider-current-sheet");
		}
		else{
			
			lis.eq(lis.length-1).show();
			lis.eq(lis.length-1).animate({opacity:'1'},300);
			lis.eq(lis.length-1).addClass("mt-slider-current-sheet");
		}
	});	
	
	
	$("#bzjx_next").click(function(){
		var lis=$("#bzjx>li");
		var index=$("#bzjx>li[class*='mt-slider-current-sheet']").index();
		lis.removeClass("mt-slider-current-sheet");	
		lis.hide();
		lis.css("opacity","0");
		if(index<lis.length-1){
		lis.eq(index+1).show();
		lis.eq(index+1).animate({opacity:'1'},300);
		lis.eq(index+1).addClass("mt-slider-current-sheet");
		}
		else{
			lis.eq(0).show(0);
			lis.eq(0).animate({opacity:'1'},300);
			lis.eq(0).addClass("mt-slider-current-sheet");
		}	
	});
	
	function next(){
		var lis=$("#bzjx>li");
		var index=$("#bzjx>li[class*='mt-slider-current-sheet']").index();
		lis.removeClass("mt-slider-current-sheet");	
		lis.hide();
		lis.css("opacity","0");
		if(index<lis.length-1){
		lis.eq(index+1).show();
		lis.eq(index+1).animate({opacity:'1'},300);
		lis.eq(index+1).addClass("mt-slider-current-sheet");
		}
		else{
			lis.eq(0).show();
			lis.eq(0).animate({opacity:'1'},300);
			lis.eq(0).addClass("mt-slider-current-sheet");
		}
	}
	
	window.setInterval(next,5000);
});


$(function(){
	$(".pre-next>a").hover(function(){
		$(this).css("opacity","1");	
	},function(){
		$(this).css("opacity","0.6");	
	});	
	
	$(".index-slider").find(".pre-next>a").hide();
	$(".index-slider").hover(function(){
		$(this).find(".pre-next>a").fadeIn(200);
	},function(){
		$(this).find(".pre-next>a").fadeOut(200);	
	});
});


//清空浏览记录
$(function(){
	$(".clear__btn").click(function(){
		$(this).parent().parent().html("<p class=\"dropdown-menu--empty\">暂无浏览记录</p>");	
	});
});

//清空浏览记录
$(function(){
	$(".delete").click(function(){
		if($(this).parent().parent().parent().find("li").length==1){
			$(this).parent().parent().parent().parent().html("<p class=\"dropdown-menu--empty\">暂无浏览记录</p>");	
		}
		else{
			$(this).parent().parent().remove();	
		}
	});	
});


//右侧浏览历史条件满足时固定顶部
$(function(){
	$(window).scroll(function(){
		$(".J-side-history").first().removeClass("stickyPlugin-fixed");	
		if($(".J-side-history").first().offset().top-$(document).scrollTop()<0){
			$(".J-side-history").first().addClass("stickyPlugin-fixed");
		}
	});
});


//清空右侧浏览历史
$(function(){
	$(".clear-history").click(function(){
		$(this).parent().parent().find(".history-list").remove();
		$(this).parent().parent().append("<div class=\"no-history\">暂无浏览记录</div>");
	});	
});

//友情链接tab标签
$(function(){
	$(".content-navbar>.ccf>.J-holy-reco__label").click(function(){
		var index=$(this).index();
		$(".content-navbar>.ccf>.J-holy-reco__label").removeClass("current");
		$(this).addClass("current");
		
		$(".component-holy-reco>.J-holy-reco>.J-holy-reco__content").hide();
		$(".component-holy-reco>.J-holy-reco>.J-holy-reco__content").eq(index).show();
	});	
});


//左侧漂浮导航宽度不够时候隐藏
$(function(){
	$(".J-go-top").click(function(){
		$('html, body').animate({scrollTop:0}, 'slow'); 	
	});
});
