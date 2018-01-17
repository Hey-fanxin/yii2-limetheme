

+function ($) {
    'use strict'

    //  初始化自拟定的单选框和复选框
    $('.radio-custom input').after('<i class="fa-li fa fa-lg">');
    $('.checkbox-custom input').after('<i class="fa-li fa fa-lg"></i>');
    //  初始化h5标题样式所需元素
    $('.custom-h').prepend('<span></span>');
    $('[data-route]')
        .bind("click", function () {
            var route = $(this)
                .attr('data-route')
                .split('/');
            $('#route').html('');
            for (var i = 0; i < route.length; i++) {
                var text = $('<span></span>').text(route[i] + ' — ');
                if (i == route.length - 1) {
                    text = $('<span class="active"></span>').text(route[i]);
                }
                $('#route').append(text);
            }
        })
}(jQuery)