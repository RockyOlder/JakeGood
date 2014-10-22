<script>
$(function(){
	var lis=$(".index-slider>.rg__focus__list>li");
	$(".index-slider").find(".rg__focus__p-n").hide();
	$(".index-slider").hover(function(){
		$(this).find(".pre-next").fadeIn(300);
	},function(){
		$(this).find(".pre-next").fadeOut(300);
	});
	
	//上一个
	$(".index-slider").find(".rg__focus__p-n>.sp-slide--previous").click(function(){
		var clis=$(this).parent().parent().find(".rg__focus__list>li");
		var index=$(this).parent().parent().find(".rg__focus__list>li[class*='rg__curr']").index();

		var next=index;
		if(next==0){
			next=clis.length-1;
		}else{
			next=next-1;	
		}
		clis.removeClass("rg__curr");
		clis.eq(index).animate({left:'740px'},300);
		clis.eq(next).addClass("rg__curr");
		clis.eq(next).css("left","-740px");
		clis.eq(next).animate({left:'0px'},300);
	});
	
	
	//下一个
	$(".index-slider").find(".rg__focus__p-n>.sp-slide--next").click(function(){
		var clis=$(this).parent().parent().find(".rg__focus__list>li");
		var index=$(this).parent().parent().find(".rg__focus__list>li[class*='rg__curr']").index();

		var next=index;
		if(next==clis.length-1){
			next=0;
		}else{
			next=next+1;	
		}

		clis.removeClass("rg__curr");
		clis.eq(index).animate({left:'-740px'},300);
		clis.eq(next).addClass("rg__curr");
		clis.eq(next).css("left","740px");
		clis.eq(next).animate({left:'0px'},300);
	});
	
	function nextfc(){
		var rg_focus=$(".index-slider");
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
			clis.eq(index).animate({left:'-740px'},300);
			clis.eq(next).addClass("rg__curr");
			clis.eq(next).css("left","740px");
			clis.eq(next).animate({left:'0px'},300);
		}	
	}
	
	nextfc();
});    
</script>
<style>
.content__cell--slider { height: 300px; overflow: hidden}
.index-slider .slider {position: absolute;}
.index-slider .slider img{width: 366px;height: 220px;}
.side-extension--hot .hot-item{height: 70px;}
</style>
<div class="site-wrapper__content">
    <div class="fs site-fs J-site-fs__content">
        <div class="content__cell  content__cell-small content__cell--hot">
            <h3 class="label"><i></i><span>热门团购</span></h3>
            <div class="filter-strip log-mod-viewed">
                <ul class="filter-strip__list">
                    <?php foreach (ANLMarket::getPopCats($this->market->market_id) as $v): ?>
                    <li><a href="<?php echo $v->url; ?>" class="<?php echo $v->css; ?>"><?php echo $v->name; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="content__cell  content__cell-small content__cell--geo J-filter__geo">
            <h3 class="label"><i></i><span>全部区域</span></h3>
            <div class="filter-strip log-mod-viewed">
                <ul class="filter-strip__list">
                    <?php foreach (ANLMarket::getRegions($this->market->city) as $v): ?>
                    <li><a href="<?php echo $v->url; ?>"><?php echo $v->name; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="content__cell  content__cell-small content__cell--area">
            <h3 class="label"><i></i><span>热门商圈</span></h3>
            <div class="filter-strip log-mod-viewed">
                <ul class="filter-strip__list">
                    <?php foreach (ANLMarket::getHots($this->market->market_id, 'region') as $v): ?>
                    <li><a href="<?php echo $v->url; ?>"><?php echo $v->name; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="content__cell content__cell--slider">
            <div class="component-index-slider">
                <div class="index-slider">
                    <div class="head ccf">
                        <h2><span class="icon"></span>本周精选</h2>
                        <ul class="trigger-container"></ul>
                    </div>
                    <ul id="" class="lotter__slider-container J-hub rg__focus__list">
                        <li class="slider rg__curr">
                            <div class="left">
                                <a class="link ccf" target="_blank" href="http://sz.anarry.com/item/detail?item_id=1015226">
                                    <img class="img" src="http://p1.meituan.net/366.220/deal/7d913962104000c4b28e403f552644f7142211.jpg" width="366"/>
                                </a>
                                <div class="title">
                                    <a class="xtitle link ccf" target="_blank" href="#">128天府香辣虾</a>
                                    <p class="desc">价值164元4人套餐，免费停车位</p>
                                </div>
                                <span class="price">¥<strong>128</strong></span>
                            </div>
                            <div class="right">
                                <a class="link ccf" target="_blank" href="http://sz.anarry.com/item/detail?item_id=1009667">
                                    <img class="img" src="http://t1.s2.dpfile.com/pc/mc/13ec123d774fe8b7f93e425afb0c2b97(450c280)/thumb.jpg" width="366" />
                                </a>
                                <div class="title">
                                    <a class="xtitle link ccf" target="_blank" href="#">【7店通用】金草帽韩式自助烤肉</a>
                                    <p class="desc">仅售36.8元，价值58元单人自助午餐</p>
                                </div>
                                <span class="price">¥<strong>36.8</strong></span>
                            </div>
                        </li>          
                    </ul>
                    
                    <div class="pre-next rg__focus__p-n" >
                        <a href="javascript:void(0);" style="opacity:0.6;" class="mt-slider-previous sp-slide--previous"></a>
                        <a href="javascript:void(0);" style="opacity:0.6;" class="mt-slider-next sp-slide--next"></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
