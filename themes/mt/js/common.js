$(document).ready(function () {
    $.getJSON('/site/activity', {}, function (res) {
        if (res.logged == 1)
        {
            $('.user-info').html(res.userinfo);
        }
        if (res.cart.count > 0)
        {
            $('.cart-count').html(res.cart.count);
            $('.dropdown-menu--cart ul').html(res.cart.items);
        }
    });
});