/**
 * limefamily GridView widget.
 *
 * This is the JavaScript widget used by the limefamily\widget\GridView widget.
 *
 * @author bianjunping
 * @since 1.0
 */

+ (function ($) {
    'use strict';

    var pluginName = "limeFamilyGridView",
        defaults = {
            filterUrl: undefined,
            filterSelector: undefined
        };

    var gridEvents = {
        /**
         * beforeFilter event is triggered before filtering the grid.
         * The signature of the event handler should be:
         *     function (event)
         * where
         *  - event: an Event object.
         *
         * If the handler returns a boolean false, it will stop filter form submission after this event. As
         * a result, afterFilter event will not be triggered.
         */
        beforeFilter: 'beforeFilter',
        /**
         * afterFilter event is triggered after filtering the grid and filtered results are fetched.
         * The signature of the event handler should be:
         *     function (event)
         * where
         *  - event: an Event object.
         */
        afterFilter: 'afterFilter'
    };

    var gridEventHandlers = {};

    var Plugin = function (element, options) {

        this.element = element;
        this.options = $.extend({}, defaults, options);
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype = {
        init: function () {
            var $this = $(this.element),
                _this = this,
                $options = this.options;

            var filterEvents = 'DOMNodeInserted';
            var enterPressed = false;

            initEventHandler($($this), 'filter', filterEvents, $options.filterSelector, function (event) {

                _this.appFilter($this);

                return false;
            });
        },
        appFilter: function () {
            var $this = $(this.element),
                $options = this.options,
                data = {};

            $.each(yii.getQueryParams($options.filterUrl), function (name, value) {

                if (!$.isArray(value)) {
                    value = [value];
                }
                if (!(name in data)) {
                    data[name] = value;
                } else {
                    $.each(value, function (i, val) {
                        if ($.inArray(val, data[name])) {
                            data[name].push(val);
                        }
                    });
                }

            });
            var namesInFilter = Object.keys(data);
            $.each($($options.filterSelector).serializeArray(), function (index, o) {
                if (namesInFilter.indexOf(o.name) === -1 && namesInFilter.indexOf(o.name.replace(/\[\d*\]$/, '')) === -1) {
                    if (!(o.name in data)) {
                        data[o.name] = [];
                    }
                    data[o.name].push(o.value);
                } else {
                    data[o.name] = [];
                    data[o.name].push(o.value);
                }

            });

            var pos = $options.filterUrl.indexOf('?');
            var url = pos < 0 ? $options.filterUrl : $options.filterUrl.substring(0, pos);
            var hashPos = $options.filterUrl.indexOf('#');
            if (pos >= 0 && hashPos >= 0) {
                url += $options.filterUrl.substring(hashPos);
            }

            $($this)
                .find('formq.gridview-filter-form')
                .remove();
            var $form = $('<form/>', {
                'action': url,
                'method': 'get',
                'class': 'gridview-filter-form',
                'style': 'display:none',
                'data-pjax': ''
            }).appendTo($($this));

            $.each(data, function (name, values) {
                $.each(values, function (index, value) {
                    $form.append($('<input/>').attr({type: 'hidden', name: name, value: value}));
                });
            });

            var event = $.Event(gridEvents.beforeFilter);
            $($this).trigger(event);
            if (event.result === false) {
                return;
            }

            $form.submit();
            $($this).trigger(gridEvents.afterFilter);
        }

    }

    function initEventHandler($gridView, type, event, selector, callback) {
        var id = $gridView.attr('id');
        var prevHandler = gridEventHandlers[id];
        if (prevHandler !== undefined && prevHandler[type] !== undefined) {
            var data = prevHandler[type];
            $(document).off(data.event, data.selector);
        }
        if (prevHandler === undefined) {
            gridEventHandlers[id] = {};
        }

        var sel = $(selector)
            .siblings('a')
            .attr('class')
            .split(' ')[1];
        var str = selector.split(' ')[0]
        str = str + " ." + sel + " span";

        $(document).on(event, str, callback);
        gridEventHandlers[id][type] = {
            event: event,
            selector: str
        };
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