$(function(){
	var lis=$(".rg__focus_2>.rg__focus__list>li");
	$(".rg__focus_2").find(".rg__focus__p-n").hide();
	$(".rg__focus_2").hover(function(){
		$(this).find(".pre-next").fadeIn(300);
	},function(){
		$(this).find(".pre-next").fadeOut(300);
	});
	
	//上一个
	$(".rg__focus_2").find(".rg__focus__p-n>.sp-slide--previous").click(function(){
		var clis=$(this).parent().parent().find(".rg__focus__list>li");
		var index=$(this).parent().parent().find(".rg__focus__list>li[class*='rg__curr']").index();

		var next=index;
		if(next==0){
			next=clis.length-1;
		}else{
			next=next-1;	
		}
		clis.removeClass("rg__curr");
		clis.eq(index).animate({left:'206px'},300);
		clis.eq(next).addClass("rg__curr");
		clis.eq(next).css("left","-206px");
		clis.eq(next).animate({left:'0px'},300);
	});
	
	
	//下一个
	$(".rg__focus_2").find(".rg__focus__p-n>.sp-slide--next").click(function(){
		var clis=$(this).parent().parent().find(".rg__focus__list>li");
		var index=$(this).parent().parent().find(".rg__focus__list>li[class*='rg__curr']").index();

		var next=index;
		if(next==clis.length-1){
			next=0;
		}else{
			next=next+1;	
		}

		clis.removeClass("rg__curr");
		clis.eq(index).animate({left:'-206px'},300);
		clis.eq(next).addClass("rg__curr");
		clis.eq(next).css("left","206px");
		clis.eq(next).animate({left:'0px'},300);
	});
	
	function next(){
		var rg_focus=$(".rg__focus_2");
		for(var i=0;i<rg_focus.length;i++){
			var clis=rg_focus.eq(i).find(".rg__focus__list>li");
			var index=rg_focus.eq(i).find(".rg__focus__list>li[class*='rg__curr']").index();
	
			var next=index;
			if(next==clis.length-1){
				next=0;
			}else{
				next=next+1;	
			}
	
			clis.removeClass("rg__curr");
			clis.eq(index).animate({left:'-206px'},300);
			clis.eq(next).addClass("rg__curr");
			clis.eq(next).css("left","206px");
			clis.eq(next).animate({left:'0px'},300);
		}	
	}
	
	next();
});