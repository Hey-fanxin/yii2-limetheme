+ function ($) {
    'use strict';

    // METISMENU CLASS DEFINITION ======================

   var pluginName = "sideMenu",
        defaults = {
            toggle: true
        };

    function SideMenu(element, options) {
        this.element = element;
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    SideMenu.prototype.init = function () {

        var $this = $(this.element),
            $toggle = this.settings.toggle;

        $this
            .find('li.active')
            .has('ul')
            .children('ul')
            .addClass('collapse in');
        $this
            .find('li')
            .not('.active')
            .has('ul')
            .children('ul')
            .addClass('collapse');
        $this
            .find('li')
            //.has('ul')
            .children('a')
            .on('click', function (e) {
                //e.preventDefault();
                $(this)
                    .parent('li')
                    .toggleClass('active')
                    .has('ul')
                    .children('ul')
                    .collapse('toggle');
                if ($toggle) {
                    $(this)
                        .parent('li')
                        .siblings()
                        .removeClass('active')
                        .has('ul.in')
                        .children('ul.in')
                        .collapse('hide');
                }
            });
        
    };

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            var $this   = $(this)
            var data    = $this.data('bs.sideMenu')
            var options = typeof option == 'object' && option

            if (!data) $this.data('bs.sideMenu', (data = new SideMenu(this, options)))
        });
    };

}(jQuery);
