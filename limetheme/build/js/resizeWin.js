(function ($) {
    "use strict";
    var mainApp = {
        resizeWindow: function () {

            if ($(window).width() < 1336) {
                $('div.sidebar-collapse').addClass('collapse');
            } else {
                $('div.sidebar-collapse').removeClass('collapse');
            }
            $('.navmenu').css({
                'height': parseInt($(window).height()) - 62
            });
            $('.wrapper-page-container').css({
                'height': parseInt($(window).height()) - 107
            });
        },
        loadMenu: function () {
            $(window)
                .bind("load resize", function () {
                    mainApp.resizeWindow();
                });
        }
    };
    $(document).ready(function () {
        mainApp.loadMenu();
        mainApp.resizeWindow();
    });
}(jQuery));