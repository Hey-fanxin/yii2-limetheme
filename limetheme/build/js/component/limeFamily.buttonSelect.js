/**
 * Created by bianjunping on 2018/1/12.
 */

+ (function ($) {
    'use strict';

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

    function getDropMenu($this) {
        var $parent = $this.parent()

        if ($parent.has('ul.dropdown-menu').length) {
            return $parent.children('ul')
        } else {
            $parent = $parent.parent()
            return $parent && $parent.length
                ? $parent.children('ul')
                : $parent
                    .parent()
                    .children('ul')
        }

    }
    function getBtn($ele) {
        var $btn = $ele.siblings('.btn-select')
        return $btn && $btn.length
            ? $btn
            : $ele
                .siblings()
                .children('.btn-select')
    }

    Plugin.prototype = {
        init: function () {
            var $menu = getDropMenu($(this.element)),
                $checked = this.options.checkbox,
                $options = this.options;
            $menu
                .find('li')
                .children('a')
                .on('click', function (e) {
                    e.preventDefault();

                    var $btn = getBtn($menu);
                    $btn
                        .siblings('input')
                        .val($(this).attr('data-dropdown-n'));
                    $btn
                        .children('span')
                        .html($(this).html());

                    if (typeof $options['fn'] == 'function') {
                        $options['fn']($(this))
                    }
                })
        }
    }

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            var option = typeof options == 'object' && options
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin(this, option));
            }
        });
    };
})(jQuery);