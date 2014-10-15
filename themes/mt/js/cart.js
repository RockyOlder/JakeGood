var addToCart = function(item) {
        
    $.getJSON('/cart/add', item, function(res) {
   // alert(console.log(res))
 //  console.log(res)
        if (res.ret == 0)
        {
            $('.cart-count').html(res.count);
            $('.dropdown-menu--cart ul').html(res.items);
            window.location = '/cart';
        }
		else if (res.ret == 3001)
		{
			window.location = '/login';
		}

    });
};
var updateQuantity = function($store_id, $sku_id, $quantity) {
    $.getJSON('/cart/update', {store_id: $store_id, sku_id: $sku_id, quantity: $quantity}, function(res) {
        if (res.ret == 0)
        {
            $("#item_"+$store_id+'_'+$sku_id+'_quantity').val(res.quantity);
            $("#item_"+$store_id+'_'+$sku_id+'_total').html((res.quantity*res.price).toFixed(2));
        }
        caculateTotal();
    });
};

var deleteItem = function($store_id, $sku_id) {
    $.getJSON('/cart/delete', {store_id: $store_id, sku_id: $sku_id}, function(res) {
        if (res.ret == 0)
        {
            $('.item' + $sku_id).remove();
            $('.cart-count').html(res.count);
            $('.dropdown-menu--cart ul').html(res.items);
        }
        caculateTotal();
    });
};
var caculateTotal = function () {
    var total = 0;
    $('.buy_checked .J-total').each(function () {
        total += parseFloat($(this).html());
    });
    $('#J-cart-amount').html($('.buy_checked .J-total').length);
    $('#J-cart-total').html(total.toFixed(2));
};

var chooseAll = function(block, checked) {
	
	if (block == 'all') {
		$('.J-choose').attr('checked', checked);
		if (checked)
		{
			$('.R-items').addClass('buy_checked');
		}
		else
		{
			$('.R-items').removeClass('buy_checked');
		}
	}
	else {
		$('.J-choose'+block).attr('checked', checked);
		if (checked)
		{
			$('.R-items-'+block).addClass('buy_checked');
		}
		else
		{
			$('.R-items-'+block).removeClass('buy_checked');
		}
	}
    caculateTotal();
}

$(function() {
    $('.J-cart-item').click(function (){
        
        if ($(this).attr('checked') == 'checked')
        {
            $(this).parent().parent().removeClass('buy_checked');
            $(this).attr('checked', false);
        }
        else
        {
            $(this).parent().parent().addClass('buy_checked');
            $(this).attr('checked', true);
        }
        caculateTotal();
    });
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