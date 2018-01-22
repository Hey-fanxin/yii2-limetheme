/**
 * Created by bianjunping on 2018/1/12.
 */

+ (function($) {
    'use strict';

    //var menu   = '.dropdown-menu'

    var pluginName = "dropDownMenuSelect",
        defaults = {
            checked: ''
        };

    var Plugin = function (element, options) {

        this.element = element;
        this.options = $.extend({}, defaults, options);
        this._name = pluginName;
        this.init();

    }

    Plugin.prototype = {
        init: function(){
            var $this = $(this.element).parent('div').has('ul.dropdown-menu').children('ul'),
                $checked = this.options.checkbox,
                $options = this.options;
            $this
                .find('li')
                .children('a')
                .on('click', function (e) {
                    e.preventDefault();

                    var $parent_sib = $(this).parent('li').parent('ul').siblings();
                    $parent_sib
                        .children('span')
                        .html($(this).html());
                    if(typeof $options['fn'] == 'function') {
                        $options['fn']($(this))
                    }

                })
        }
    }

    $.fn[pluginName] = function (options) {
        return this.each(function () {

            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin(this, options));
            }
        });
    };
})(jQuery);