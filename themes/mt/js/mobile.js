function addCollection(itemId)
{
    $.getJSON('/m/wishlist/add', {
        item_id:itemId
    }, function (json) {
        //alert(json.msg);
        });
}
var addCarts = function(item) {

    $.getJSON('/m/cart/add', item, function(res) {
        
        if (res.ret == 0)
        {
            $('.cart-count').html(res.count);
            $('.dropdown-menu--cart ul').html(res.items);
            window.location = '/m/cart';
        }
        else if (res.ret == 3001)
        {
            window.location = '/m/login';
        }

    });
};
var shopNumber= function($store_id, $sku_id) {
    var num= $("#item_"+$store_id+'_'+$sku_id+'_quantity').val(); 
    updateQuantity($store_id, $sku_id, num);
};
var updateQuantity = function($store_id, $sku_id, $quantity) {
    $.getJSON('/cart/update', {
        store_id: $store_id, 
        sku_id: $sku_id, 
        quantity: $quantity
    }, function(res) {
        if (res.ret == 0)
        {
            $("#item_"+$store_id+'_'+$sku_id+'_quantity').val(res.quantity);
            $("#item_"+$store_id+'_'+$sku_id+'_total').html((res.quantity*res.price).toFixed(2));
        }
        caculShop();
    });
};
var deleteItem = function($store_id, $sku_id) {
    $.getJSON('/cart/delete', {
        store_id: $store_id, 
        sku_id: $sku_id
    }, function(res) {
        if (res.ret == 0)
        {
            $('.item' + $sku_id).remove();
            $('.cart-count').html(res.count);
            $('.dropdown-menu--cart ul').html(res.items);
        }
        caculShop();
    });
};
var cats_Shop=function () {
    $.getJSON('/site/activity', {}, function (res) {
        if (res.cart.count > 0)
        {
            $('#tishi').text(res.cart.count);
            $('#tishi').show();
        }
    });
};

var caculShop = function () {
    var total = 0;
    $('.J-total').each(function(){
        total += parseFloat($(this).text());
        $('#J-cart-amount').html($('.J-total').length);
        $('#J-cart-total').html(total.toFixed(2));
    //   var price=$('#J-cart-total').text()
    //  $('.price_attr-suit-totalprice').text('¥'+price);
    });
};
$(function(){

    var total = 0;
    $('.J-total').each(function () {
        total += parseFloat($(this).text());
        $('#J-cart-amount').html($('.J-total').length);
        $('#J-cart-total').html(total.toFixed(2));
    });
    $("#plus").click(function(){
        var num=parseInt($("#buyNum").val());
        if(isNaN(num)){
            num=1;
        }
        num++;
        $("#buyNum").val(num);
        item.quantity = num;
    });	
    $("#minus").click(function(){
        var num=parseInt($("#buyNum").val());
        if(isNaN(num)){
            num=1;
        }
        if(num>1){
            num--;
            $("#buyNum").val(num);
        }
        item.quantity = num;
    });   
});
$(function() {
    $('#buyBtn2').click(function(){
        $('#form_cart').submit(); 
    })
    var price=$('#J-cart-total').text()
    $('.price_attr-suit-totalprice').text('¥'+price);
    $(".deal-component-quantity .plus").click(function() {
        $store_id = $(this).attr('data-store-id');
        $sku_id = $(this).attr('data-sku-id');
        var num = parseInt($("#item_"+$store_id+'_'+$sku_id+'_quantity').val());
        if (isNaN(num)) {
            num = 1;
        }
        num++;
        updateQuantity($store_id, $sku_id, num);
    });
    $(".deal-component-quantity .minus").click(function() {
        $store_id = $(this).attr('data-store-id');
        $sku_id = $(this).attr('data-sku-id');
        var num = parseInt($("#item_"+$store_id+'_'+$sku_id+'_quantity').val());
        if (isNaN(num)) {
            num = 1;
        }
        if (num > 1) {
            num--;
            updateQuantity($store_id, $sku_id, num);
        }
    });
});
$(function(){
    $(document).ready(function () {
        $.getJSON('/site/activity', {}, function (res) {
            if (res.cart.count > 0)
            {
                $('#tishi').text(res.cart.count);
                $('#tishi').show();
            }
            $("#cat_if").click(function(){
                            
                if($("#tishi").text()==0){
                    $('#skuTitle2').text("您还未选择商品")
                    $('#skuNotice').show();
                    setTimeout( function(){
                        $( '#skuNotice' ).fadeOut();
                    }, ( 1 * 1000 ) ); 
                }else{
                    window.location = '/m/cart';
                }
            });	
        });
    });
    $('#addCart2').bind('click',function(){
        var _this = $(this);
        $.getJSON('/m/cart/add', item, function(res) {
            console.log(res)
            if (res.ret == 3001)
            {
                $('#skuTitle2').text('您还未登陆');
                $('#skuNotice').show();
                window.location = '/m/login';
            }else{
                $('#popone').text('+'+(+item.quantity))
                $("#popone").css('top','-30px').show();
                $("#popone").animate({
                    top:'-10px'
                },1000,function(){
                    cats_Shop()
                });
                $('#skuTitle2').text('加入购物车成功');
                $('#skuNotice').show();
                setTimeout( function(){
                    $( '#skuNotice' ).fadeOut();
                }, ( 1 * 1000 ) ); 
                setTimeout( function(){
                    $('#popone').fadeOut(300);
                }, ( 1 * 1000 ) );
            }
        });
    });
    $('#fav').bind('click',function(){
        var _this = $(this);
        if(_this.attr('isSelected')=="false"){
            _this.addClass('btn_fav_checked');
            _this.find('i').css('background-position','-69px 2px');
            _this.attr('isSelected','true');
            $('#skuTitle2').text('收藏成功');
            $('#skuNotice').show();
            setTimeout( function(){
                $( '#skuNotice' ).fadeOut();
            }, ( 1 * 1000 ) ); 
        }else{
            _this.removeClass('btn_fav_checked');
            _this.find('i').css('background-position','-39px -147px');
            _this.attr('isSelected','false');
            $('#skuTitle2').text('取消收藏');
            $('#skuNotice').show();
            setTimeout( function(){
                $( '#skuNotice' ).fadeOut();
            }, ( 1 * 1000 ) );
        }
    });

    $('#detailTab span[no=1]').bind('click',function(){
        $('#detail2').hide();
        $('#detail3').hide();
        $('#detail1').show();
    });
    $('#detailTab span[no=2]').bind('click',function(){
        $('#detail1').hide();
        $('#detail3').hide();
        $('#detail2').show();
    });
    $('#detailTab span[no=3]').bind('click',function(){
        $('#detail1').hide();
        $('#detail2').hide();
        $('#detail3').show();
    });
				
    $("#loopImgBar").find('li').click(function(){
        var oLi = $(this);
        $("#loopImgBar").find('li').removeClass('cur');
        oLi.addClass('cur');
        $('#loopImgUl').css('left',-205*(oLi.attr('no')-1)+'px');
    });
});
