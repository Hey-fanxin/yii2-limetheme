(function ($) {
    "use strict";
    var mainApp = {
        openModal: function () {
            $(".open-modal")
                .click(function () {
                    $("#myModal").modal("show");
                });
        },

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
                'height': parseInt($(window).height()) - 83
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
        mainApp.openModal();
        mainApp.resizeWindow();
        $('#layout-btn').on('click', function () {
            if ($('body').hasClass('layout-boxed')) {
                $('body').removeClass('layout-boxed')
            } else {
                $('body').addClass('layout-boxed')
            };
            mainApp.resizeWindow();
        })
    });
}(jQuery));