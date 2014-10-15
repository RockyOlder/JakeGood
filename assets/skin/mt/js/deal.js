// JavaScript Document

//产品图组
$(function(){
	$(".candidates>img").hover(function(){
		var src=$(this).attr("src");
		$(".candidates>img").removeClass("active");
		$(this).addClass("active");
		$(".focus-view").attr("src",src);	
	});
});


//数字加减
$(function(){
	$("#buy_count_jia").click(function(){
		var num=parseInt($("#buy_count").val());
		if(isNaN(num)){
			num=1;
		}
		num++;
		$("#buy_count").val(num);
	});	
	$("#buy_count_jian").click(function(){
		var num=parseInt($("#buy_count").val());
		if(isNaN(num)){
			num=1;
		}
		if(num>1){
			num--;
			$("#buy_count").val(num);
		}
	});
});


//其他团购还有N个
$(function(){
	$(".more-deal-trigger-wrapper")	.click(function(){
		if($(this).hasClass("collapse")){
			$(this).removeClass("collapse");
			$(this).parent().parent().find("li").removeClass("hidden");	
			$(this).find(".left-title").attr("data-morecount",$(this).find(".left-title").html());
			$(this).find(".left-title").html("收起");
		}else{
			$(this).addClass("collapse");
			$(this).parent().parent().find("li[class=more]").addClass("hidden");	
			$(this).find(".left-title").html($(this).find(".left-title").attr("data-morecount"));
		}
	});
});


//浮动导航滑动网页
$(window).scroll(function(){
	if($("#deal-stuff").offset().top<$(document).scrollTop()+70){
		$("#J-content-navbar").addClass("common-fixed");
		$("#J-nav-buy").show();	
	}else{
		$("#J-content-navbar").removeClass("common-fixed");
		$("#J-nav-buy").hide();	
	}
});

//浮动导航点击样式
$(function(){
	$("#J-content-navbar>ul>li").click(function(){
		$("#J-content-navbar>ul>li").removeClass("content-navbar__item--current");
		$(this).addClass("content-navbar__item--current");
		var index=$(this).index();
		var titles=$(".main .content-title");
		var h=titles.eq(index).offset().top-40;
		$('html, body').animate({scrollTop:h}, 'slow'); 
	});
});


//商家位置折叠菜单
$(function(){
	$(".biz-info").hover(function(){
		$(".biz-info").removeClass("biz-info--open");
		$(this).addClass("biz-info--open");
	});	
});


//右侧热门专题翻页
$(function(){
	$(".J-side-topic-list>li").hide();
	$(".J-side-topic-list>li").eq(0).show();
	//上一个
	$(".side-topic-buttons>.side-box--topic--previous").click(function(){
		var lis=$(".J-side-topic-list>li");
		var curr=$(".J-side-topic-list>li[class*=curr]").index();
		lis.eq(curr).hide();
		if(curr==0){
			curr=lis.length-1;	
		}else{
			curr--;
		}
		lis.removeClass("curr");
		lis.eq(curr).addClass("curr");
		lis.eq(curr).fadeIn(300);
	});	
	
	//下一个
	$(".side-topic-buttons>.side-box--topic--next").click(function(){
		var lis=$(".J-side-topic-list>li");
		var curr=$(".J-side-topic-list>li[class*=curr]").index();
		lis.eq(curr).hide();
		if(curr==lis.length-1){
			curr=0;	
		}else{
			curr++;
		}
		lis.removeClass("curr");
		lis.eq(curr).addClass("curr");
		lis.eq(curr).fadeIn(300);
	});
});

//二维码
$(function(){
	$(".stick-qrcode .close").click(function(){
		$(".stick-qrcode").hide();
	});
	
	
	if($(window).width()<1250){
		$(".stick-qrcode").hide();	
	}
});

$(function(){
	$(".deal-component-quantity-warning>a").click(function(){
		$(this).parent().find("a").css("border-color","#ccc");
		$(this).parent().find("a").css("color","#000");	
		$(this).parent().find("a").css("background","none");
		$(this).css("border-color","#00c3bb");
		$(this).css("color","#00c3bb");	
		$(this).css("background","url(img/check.gif) no-repeat right bottom");
	});	
});