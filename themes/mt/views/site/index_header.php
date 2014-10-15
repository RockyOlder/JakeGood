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
.content__cell--slider {width: 560px; height: 270px; overflow: hidden}
.index-slider .slider {position: absolute;width: 560px;}
.index-slider .slider img{width: 560px;height: 270px;}
.site-fs .brands {width: 560px;}
.site-fs .brands a{display: block; float: left; width:140px;height: 185px; padding:0; text-align: center;}
.site-fs .brands a img{width:140px;height: 185px;}
.site-fs .brands .a{display: block; float: left; width: 108px; height: 45px; padding: 3px 0; text-align: center; line-height: 60px; border: 1px solid #fff;}
.site-fs .brands .a img{width:90px;height: 45px;}
.site-fs .brands .a:hover{ border: 1px solid #ccc;}

.side-extension--hot .hot-item{height: 70px;}
</style>
<div class="site-wrapper__content">
    <div class="fs site-fs J-site-fs__content">

        <div class="content__cell content__cell--slider">
            <div class="component-index-slider">
                <div class="index-slider">
                    <ul id="" class="lotter__slider-container J-hub rg__focus__list">
                        <li class="slider rg__curr">
                            <a class="link ccf" target="_blank" href="http://sz.mall.com/item/list?cid=50019780">
                                <img class="img" src="http://i.mmcdn.cn/simba/img/TB1QOCzFpXXXXb5bFXXSutbFXXX.jpg" />
                            </a>
                        </li>
                        <li class="slider" style="left:-740px;">
                            <a class="link ccf" target="_blank" href="http://sz.mall.com/item/list?cid=50012027">
                                <img class="img" src="http://i.mmcdn.cn/simba/img/TB1CDR5GXXXXXctXFXXSutbFXXX.jpg" />
                            </a>
                        </li>
                        <li class="slider" style="left:-740px;">
                            <a class="link ccf" target="_blank" href="http://sz.mall.com/item/list?cid=1512">
                                <img class="img"  src="http://gtms04.alicdn.com/tps/i4/TB1DjwcFVXXXXXjXFXXGYa7IVXX-570-200.jpg" />
                            </a>
                        </li>         
                    </ul>
                    <div class="pre-next rg__focus__p-n" >
                        <a href="javascript:void(0);" style="opacity:0.6;" class="mt-slider-previous sp-slide--previous"></a>
                        <a href="javascript:void(0);" style="opacity:0.6;" class="mt-slider-next sp-slide--next"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="content__cell brands" style="margin-top:0px;">
            <a href="item/list?q=洗衣机&sort=sale-desc"><img src="http://gtms03.alicdn.com/tps/i3/TB1dXF.GXXXXXbLXpXXc8PZ9XXX-130-200.png" /></a>
            <a href="item/list?q=顾家家居"><img src="http://gtms01.alicdn.com/tps/i1/TB1pFWwGXXXXXcVXXXXc8PZ9XXX-130-200.png" /></a>
            <a href="item/list?q=宝贝星"><img src="http://gtms01.alicdn.com/tps/i1/TB1BCGvGXXXXXcCXXXXc8PZ9XXX-130-200.png" /></a>
            <a href="item/list?q=家纺"><img src="http://gtms04.alicdn.com/tps/i4/TB1UuyuGXXXXXaBXpXXc8PZ9XXX-130-200.png" /></a>
            <!--
            <a href=""><img src="http://g.ald.alicdn.com/bao/uploaded/T1i.9QFiXkXXb1upjX.jpg" /></a>
            <a href=""><img src="http://g.ald.alicdn.com/bao/uploaded/T1bOKxFoFcXXb1upjX.jpg" /></a>
            <a href=""><img src="http://g.ald.alicdn.com/bao/uploaded/i1/T1zEvsXg8eXXXQXDnq-90-45.png" /></a>
            <a href=""><img src="http://g.ald.alicdn.com/bao/uploaded/T1i.9QFiXkXXb1upjX.jpg" /></a>
            <a href=""><img src="http://g.ald.alicdn.com/bao/uploaded/T1bOKxFoFcXXb1upjX.jpg" /></a>
            <a href=""><img src="http://g.ald.alicdn.com/bao/uploaded/i1/T1zEvsXg8eXXXQXDnq-90-45.png" /></a>
            <a href=""><img src="http://g.ald.alicdn.com/bao/uploaded/T1i.9QFiXkXXb1upjX.jpg" /></a>
            <a href=""><img src="http://g.ald.alicdn.com/bao/uploaded/T1bOKxFoFcXXb1upjX.jpg" /></a>
            <a href=""><img src="http://g.ald.alicdn.com/bao/uploaded/i1/T1zEvsXg8eXXXQXDnq-90-45.png" /></a>
            <a href=""><img src="http://g.ald.alicdn.com/bao/uploaded/T1i.9QFiXkXXb1upjX.jpg" /></a>
            <a href=""><img src="http://g.ald.alicdn.com/bao/uploaded/T1bOKxFoFcXXb1upjX.jpg" /></a>
            <a href=""><img src="http://g.ald.alicdn.com/bao/uploaded/i1/T1zEvsXg8eXXXQXDnq-90-45.png" /></a>
            <a href=""><img src="http://g.ald.alicdn.com/bao/uploaded/i1/T1zEvsXg8eXXXQXDnq-90-45.png" /></a>
            <a href=""><img src="http://g.ald.alicdn.com/bao/uploaded/i1/T1zEvsXg8eXXXQXDnq-90-45.png" /></a>
            <a href=""><img src="http://g.ald.alicdn.com/bao/uploaded/i1/T1zEvsXg8eXXXQXDnq-90-45.png" /></a>
            -->
        </div>
        <div class="right_ab" style="width:180px; position: absolute;top:12px;right: 0">
            <a href="http://sz.mall.com/item/list?cid=1101"><img src="http://gtms01.alicdn.com/tps/i1/TB1Mz8FGXXXXXXmaXXXRVNATXXX-170-280.jpg" height="270" width="180" /></a>
            <a href="http://sz.mall.comitem/list?cid=50009211"><img src="http://gtms04.alicdn.com/tps/i4/TB1usakGXXXXXcbaXXXsoa8_VXX-240-360.jpg" width="180" height="190" /></a>
        </div>
    </div>
</div>

<div class="site-wrapper__side">

    <div class="side__block side__activity">
        <div class="lottery rg__focus_2">
            <div class="lottery__header">
                <a class="lottery-link" href="#" target="_blank">更多</a> 
                <span class="lottery-icon"></span>
            </div>

            <ul class="lotter__slider-container J-hub rg__focus__list">
                <li class="slider rg__curr" style="left:0px;">
                    <a href="#" title="美梦成真：《后会无期》观影礼包，团购网免费送" >
                        <img src="/themes/mt/img/__49257148__7420534.jpg" width="206" height="158" />
                    </a>
                </li>
                <li class="slider" style="left:-206px;">
                    <a href="#" title="美梦成真：素乐移动电源，团购网免费送">
                        <img src="/themes/mt/img/__49513781__2228213.jpg" width="206" height="158" />
                    </a>
                </li>
                <li class="slider" style="left:-206px;">
                    <a href="#" title="美梦成真，苹果全新 iPad mini平板电脑，团购网免费送">
                        <img src="/themes/mt/img/__49602768__1704483.jpg" width="206" height="158" />
                    </a>
                </li>
                <li class="slider" style="left:-206px;">
                    <a href="#" title="美梦成真：酒店快订（原在线订）七夕礼包，团购网免费送">
                        <img src="/themes/mt/img/__49687650__4790907.jpg" width="206" height="158" />
                    </a>
                </li>
            </ul>
            <div class="pre-next rg__focus__p-n" >
                <a href="javascript:void(0);" style="opacity:0.6;" class="mt-slider-previous sp-slide--previous"></a>
                <a href="javascript:void(0);" style="opacity:0.6;" class="mt-slider-next sp-slide--next"></a>
            </div>
        </div>
        <ul class="sub-lottery">

            <li class="sub-lottery__item">
                <i class="icon"></i>
                <a class="content" href="#" target="_blank" title="8锅臭臭锅免费吃">小米手机入驻</a>
                <span class="status">...</span>
            </li>
            <li class="sub-lottery__item">
                <i class="icon"></i>
                <a class="content" href="#" target="_blank" title="张爷爷酸汤挂面">苹果iPhone手机入驻</a>
                <span class="status">...</span>
            </li>
            <li class="sub-lottery__item">
                <i class="icon"></i>
                <a class="content" href="#" target="_blank" title="张爷爷酸汤挂面">阿那里商城上线</a>
                <span class="status">...</span>
            </li>
        </ul>
        <div class="special rg__focus_2">
            <ul class="special__slider-container J-hub rg__focus__list">
                <li class="slider rg__curr">
                    <a href="#" title="" target="_blank">
                        <img class="lazy-img J-lazy-img" alt="超级星期二" src="/themes/mt/img/__46676666__9341069.jpg" width="206" height="190" />
                    </a>
                </li>
                <li class="slider" style="left:-206px;">
                    <a href="#" title="" target="_blank">
                        <img class="lazy-img J-lazy-img" alt="后会无期" src="/themes/mt/img/__46676666__9341069.jpg" width="206" height="190" />
                    </a>
                </li>
                <li class="slider" style="left:-206px;">
                    <a href="#" title="" target="_blank">
                        <img class="lazy-img J-lazy-img" alt="十二道锋味" src="/themes/mt/img/__46676666__9341069.jpg" width="206" height="190" />
                    </a>
                </li>
            </ul>
            <ul class="trigger-container">
                <li class="trigger" href="javascript:void(0);"></li>
                <li class="trigger" href="javascript:void(0);"></li>
                <li class="trigger" href="javascript:void(0);"></li>
            </ul>
            <div class="pre-next rg__focus__p-n">
                <a href="javascript:void(0);" style="opacity:0.6;" class="mt-slider-previous sp-slide--previous"></a>
                <a href="javascript:void(0);" style="opacity:0.6;" class="mt-slider-next sp-slide--next"></a>
            </div>
        </div>
    </div>
    
    <div class="side-extension side-extension--history side-extension--hot" style="">
        <div class="side-extension__item side-extension__item--last log-mod-viewed">
            <h3>热点关注</h3>
            <ul class="history-list J-history-list">
                <?php foreach ($items[0] as $k => $item): ?>
                <?php if ($k > 5) break; ?>
                <li class="hot-item history-list__item history-list__item--first history-list__item--last">
                    <a href="#" title="<?php echo $item->title; ?>" target="_blank">
                        <img class="" src="<?php echo $item->pic_url; ?>" width="60" height="60">
                        <span><?php echo $item->title; ?></span>
                    </a>
                    <p><em class="price">¥79</em></p>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    
    <div class="side-extension side-extension--history side-extension--hot" style="">
        <div class="side-extension__item side-extension__item--last log-mod-viewed">
            <h3>畅销推荐</h3>
            <ul class="history-list J-history-list">
                <?php foreach ($items[1] as $k => $item): ?>
                <?php if ($k > 5) break; ?>
                <li class="hot-item history-list__item history-list__item--first history-list__item--last">
                    <a href="#" title="<?php echo $item->title; ?>" target="_blank">
                        <img class="" src="<?php echo $item->pic_url; ?>" width="60" height="60">
                        <span><?php echo $item->title; ?></span>
                    </a>
                    <p><em class="price">¥79</em></p>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    
    
    <div class="side-extension side-extension--history J-side-history" style="display:none">
        <div class="side-extension__item side-extension__item--last log-mod-viewed">
            <h3><a href="javascript:;" class="clear-history J-clear">清空</a>最近浏览</h3>
            <ul class="history-list J-history-list">
                <li class="history-list__item  history-list__item--first history-list__item--last">
                    <a href="#" title="木屋烧烤代金券" target="_blank"><img class="" src="/themes/mt/img/__44446873__1618456.jpg" width="80" height="50"></a>
                    <h5><a href="#" title="木屋烧烤代金券" target="_blank">木屋烧烤代金券</a></h5>
                    <p><em class="price">¥79</em><del class="old-price">100</del></p>
                </li>

                <li class="history-list__item  history-list__item--first history-list__item--last">
                    <a href="#" title="木屋烧烤代金券" target="_blank"><img class="" src="/themes/mt/img/__44446873__1618456.jpg" width="80" height="50"></a>
                    <h5><a href="#" title="木屋烧烤代金券" target="_blank">木屋烧烤代金券</a></h5>
                    <p><em class="price">¥79</em><del class="old-price">100</del></p>
                </li>
            </ul>
        </div>
    </div>

</div>
