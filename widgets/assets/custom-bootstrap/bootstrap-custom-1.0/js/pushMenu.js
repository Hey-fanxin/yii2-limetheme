+ function (a) {
    "use strict";
    function b(b) {
        return this.each(function () {
            var e = a(this),
                f = e.data(c);
            if (!f) {
                var g = a.extend({}, d, e.data(), "object" == typeof b && b);
                e.data(c, f = new h(g))
            }
            "toggle" == b && f.toggle()
        })
    }
    var c = "lte.pushmenu",
        d = {
            collapseScreenSize: 767,
            expandOnHover: !1,
            expandTransitionDelay: 200
        },
        e = {
            collapsed: ".sidebar-collapse",
            open: ".sidebar-open",
            mainSidebar: ".main-sidebar",
            contentWrapper: ".content-wrapper",
            searchInput: ".sidebar-form .form-control",
            button: '[data-toggle="push-menu"]',
            mini: ".sidebar-mini",
            expanded: ".sidebar-expanded-on-hover",
            layoutFixed: ".fixed"
        },
        f = {
            collapsed: "sidebar-collapse",
            open: "sidebar-open",
            mini: "sidebar-mini",
            expanded: "sidebar-expanded-on-hover",
            expandFeature: "sidebar-mini-expand-feature",
            layoutFixed: "fixed"
        },
        g = {
            expanded: "expanded.pushMenu",
            collapsed: "collapsed.pushMenu"
        },
        h = function (a) {
            this.options = a,
            this.init()
        };
    h.prototype.init = function () {
        (this.options.expandOnHover || a("body").is(e.mini + e.layoutFixed)) && (this.expandOnHover(), a("body").addClass(f.expandFeature)),
        a(e.contentWrapper).click(function () {
            a(window).width() <= this.options.collapseScreenSize && a("body").hasClass(f.open) && this.close()
        }.bind(this)),
        a(e.searchInput).click(function (a) {
            a.stopPropagation()
        })
    },
    h.prototype.toggle = function () {
        var b = a(window).width(),
            c = !a("body").hasClass(f.collapsed);
        b <= this.options.collapseScreenSize && (c = a("body").hasClass(f.open)),
        c
            ? this.close()
            : this.open()
    },
    h.prototype.open = function () {
        a(window).width() > this.options.collapseScreenSize
            ? a("body")
                .removeClass(f.collapsed)
                .trigger(a.Event(g.expanded))
            : a("body")
                .addClass(f.open)
                .trigger(a.Event(g.expanded))
    },
    h.prototype.close = function () {
        a(window).width() > this.options.collapseScreenSize
            ? a("body")
                .addClass(f.collapsed)
                .trigger(a.Event(g.collapsed))
            : a("body")
                .removeClass(f.open + " " + f.collapsed)
                .trigger(a.Event(g.collapsed))
    },
    h.prototype.expandOnHover = function () {
        a(e.mainSidebar)
            .hover(function () {
                a("body").is(e.mini + e.collapsed) && a(window).width() > this.options.collapseScreenSize && this.expand()
            }.bind(this), function () {
                a("body").is(e.expanded) && this.collapse()
            }.bind(this))
    },
    h.prototype.expand = function () {
        setTimeout(function () {
            a("body")
                .removeClass(f.collapsed)
                .addClass(f.expanded)
        }, this.options.expandTransitionDelay)
    },
    h.prototype.collapse = function () {
        setTimeout(function () {
            a("body")
                .removeClass(f.expanded)
                .addClass(f.collapsed)
        }, this.options.expandTransitionDelay)
    };
    var i = a.fn.pushMenu;
    a.fn.pushMenu = b,
    a.fn.pushMenu.Constructor = h,
    a.fn.pushMenu.noConflict = function () {
        return a.fn.pushMenu = i,
        this
    },
    a(document).on("click", e.button, function (c) {
        c.preventDefault(),
        b.call(a(this), "toggle")
    }),
    a(window).on("load", function () {
        b.call(a(e.button))
    })
}(jQuery);