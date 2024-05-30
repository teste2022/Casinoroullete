
jQuery(function(a) {
  "use strict";
  var b = function(a, c) {
    this.element = a,
      this.settings = c,
      this.items = new b.items(this),
      this.selector = new b.selector(this),
      this.events = new b.events(this),
      this.position = new b.position(this),
      this.arrow = new b.arrow(this),
      this.container = new b.container(this),
      this.build()
  };
  b.prototype.build = function() {
      this.container.build(),
        this.events.bind()
    },
    b.prototype.destroy = function() {
      this.container.destroy(),
        this.events.unbind()
    },
    b.prototype.show = function(a) {
      this.container.show(a)
    },
    b.prototype.hide = function(a) {
      this.container.hide(a)
    },
    b.prototype.trigger = function(a, b) {
      var c = this.settings.hooks[a];
      "function" == typeof c && c.call(null, b)
    },
    b.defaults = {
      maxHeight: null,
      minHeight: null,
      maxWidth: null,
      minWidth: 160,
      height: null,
      width: null,
      "class": null,
      event: "contextmenu",
      selector: null,
      hooks: {
        show: null,
        hide: null,
        position: null
      },
      position: {
        my: "left-25 top+5",
        at: "mouse",
        children: !1
      },
      autoHide: !1,
      transition: {
        speed: 0,
        type: "none"
      },
      appendTo: document.body,
      arrow: "auto",
      items: [],
      click: null,
      hover: null
    },
    b.items = function(a) {
      this.parent = a
    },
    b.items.prototype.build = function(a) {
      var c = this.parent.settings;
      if (this.isDynamic()) {
        if ("undefined" == typeof a)
          return;
        this.isBuilt() && (this.root.element.remove(),
          this.root = void 0)
      }
      this.isBuilt() || (this.isDynamic() ? this.nodes = c.items.call(null, a) : this.nodes = this.cloneItems(c.items),
        this.postProcess(this.nodes),
        b.items.resetIDs(),
        this.root = new b.menu(this.getAll(), this.parent))
    },
    b.items.prototype.postProcess = function(a) {
      for (var b = 0; b < a.length; b++) {
        var c = a[b];
        ("item" === c.type || "checkbox" === c.type) && (c.click || (c.click = this.parent.settings.click),
          c.hover || (c.hover = this.parent.settings.hover)),
        c.hasSubmenu && c.hasSubmenu() && this.postProcess(c.submenu)
      }
    },
    b.items.prototype.cloneItems = function(b) {
      for (var c = [], d = 0; d < b.length; d++)
        c.push(a.extend({}, b[d]));
      return c
    },
    b.items.prototype.getAll = function() {
      return "undefined" != typeof this.nodes ? this.nodes : []
    },
    b.items.prototype.isDynamic = function() {
      return "function" == typeof this.parent.settings.items
    },
    b.items.prototype.isBuilt = function() {
      return "undefined" != typeof this.root
    },
    b.items.generateID = function() {
      return "undefined" == typeof this.currentID && (this.currentID = 0),
        this.currentID++
    },
    b.items.resetIDs = function() {
      this.currentID = 0
    },
    b.selector = function(a) {
      this.parent = a
    },
    b.selector.prototype.select = function(b, c, d) {
      "undefined" == typeof c && (c = this.parent.items.root);
      for (var e = 0; e < c.items.length; e++) {
        var f = c.items[e].instance;
        if (f.getID && f.getID() === b)
          return this.deselect(),
            a.isArray(d) && d.length > 0 ? (a(d).each(function() {
                this.element.addClass("active"),
                  this.submenu.show()
              }),
              this.activeParents = d) : this.activeParents = void 0,
            f.element.addClass("active"),
            this.activeItem = f, !0;
        if (f.hasSubmenu && f.hasSubmenu()) {
          if ("undefined" == typeof d ? d = [f] : d.push(f),
            this.select(b, f.submenu, d))
            return !0;
          d.pop()
        }
      }
      return !1
    },
    b.selector.prototype.deselect = function() {
      this.activeItem && (this.activeItem.element.removeClass("active"),
        this.activeItem.hasSubmenu && this.activeItem.hasSubmenu() && this.activeItem.submenu.hide(),
        this.activeItem = void 0,
        a(this.activeParents).each(function() {
          this.element.removeClass("active"),
            this.submenu.hide()
        }),
        this.activeParents = [])
    },
    b.selector.prototype.getSelection = function() {
      return this.activeItem
    },
    b.selector.prototype.getFirstItem = function(a) {
      for (var b = a ? a.items : this.parent.items.root.items, c = 0; c < b.length; c++) {
        var d = b[c].instance;
        if (d.isDisabled && !d.isDisabled())
          return d
      }
      throw "This context menu has no selectable items"
    },
    b.selector.prototype.getNextItem = function() {
      var a = this.parent.items.root;
      if (!this.activeItem)
        return this.getFirstItem();
      this.activeParents && (a = this.activeParents[this.activeParents.length - 1].submenu);
      for (var b = 0; b < a.items.length; b++) {
        var c = a.items[b].instance;
        if (c.id > this.activeItem.id && c.isDisabled && !c.isDisabled())
          return c
      }
      return this.activeItem
    },
    b.selector.prototype.getPrevItem = function() {
      var a = this.parent.items.root;
      if (!this.activeItem)
        return this.getFirstItem();
      this.activeParents && (a = this.activeParents[this.activeParents.length - 1].submenu);
      for (var b = a.items.length - 1; b >= 0; b--) {
        var c = a.items[b].instance;
        if (c.id < this.activeItem.id && c.isDisabled && !c.isDisabled())
          return c
      }
      return this.activeItem
    },
    b.selector.prototype.getFirstChildItem = function() {
      return this.activeItem ? this.activeItem.hasSubmenu && this.activeItem.hasSubmenu() ? this.getFirstItem(this.activeItem.submenu) : this.activeItem : this.getFirstItem()
    },
    b.selector.prototype.getImmediateParentItem = function() {
      return this.activeItem ? this.activeParents ? this.activeParents[this.activeParents.length - 1] : this.activeItem : this.getFirstItem()
    },
    b.menu = function(a, b) {
      this.ctxMenu = b,
        this.build(a)
    },
    b.menu.prototype.build = function(b) {
      this.items = [],
        this.element = a("<ul>").addClass("contextmenu-menu");
      for (var c = 0; c < b.length; c++)
        this.addItem(b[c])
    },
    b.menu.prototype.addItem = function(c) {
      var d = new b.ui[c.type](c, this.ctxMenu);
      this.items.push(a.extend({}, c, {
          instance: d
        })),
        a(this.element).append(d.element)
    },
    b.menu.prototype.show = function() {
      this.element.css({
        display: "block"
      });
      var b = this.element.outerWidth(),
        c = this.element.outerHeight(),
        d = this.element.offset().top - a(window).scrollTop(),
        e = this.element.offset().left;
      e + b > a(window).width() && this.element.css({
          left: "-100%"
        }),
        d + c > a(window).height() && this.element.css({
          top: a(window).height() - (d + c)
        })
    },
    b.menu.prototype.hide = function() {
      this.element.css({
        display: "none",
        top: "0",
        left: "100%"
      })
    },
    b.container = function(b) {
      this.parent = b,
        this.createElement(), !1 !== this.parent.settings.autoHide && "hover" !== this.parent.settings.event && this.setAutoHide(),
        a(window).on("resize", function() {
          b.position.onResize()
        })
    },
    b.container.prototype.createElement = function() {
      var b = this.parent,
        c = b.settings.transition;
      this.element = a("<div>").attr("id", "contextmenu").css({
        "animation-duration": c.speed + "ms"
      }).addClass("contextmenu-transition-" + c.type).addClass(b.settings["class"])
    },
    b.container.prototype.build = function(b) {
      var c = this.parent.items;
      c.build(b),
        c.isBuilt() && c.getAll().length ? (a(this.element).append(this.parent.items.root.element),
          this.setMenuDimensions(),
          this.isBuilt = !0) : this.isBuilt = !1
    },
    b.container.prototype.setMenuDimensions = function() {
      var a = this.parent.settings,
        b = this.parent.items.root.element;
      a.minHeight && b.css({
          "min-height": a.minHeight
        }),
        a.minWidth && b.css({
          "min-width": a.minWidth
        }),
        a.maxHeight && b.css({
          "max-height": a.maxHeight,
          "overflow-y": "auto",
          "overflow-x": "hidden"
        }),
        a.maxWidth && b.css({
          "max-width": a.maxWidth
        }),
        a.height && b.css({
          height: a.height,
          "overflow-y": "auto",
          "overflow-x": "hidden"
        }),
        a.width && b.css({
          width: a.width
        })
    },
    b.container.prototype.show = function(b) {
      if (this.parent.items.isDynamic() && this.build(b),
        this.isBuilt) {
        if (this.cancelHide(),
          this.isVisible())
          return void this.parent.position.set(b);
        a(this.parent.settings.appendTo).append(this.element),
          this.parent.position.set(b),
          this.element.addClass("contextmenu-visible"),
          this.parent.trigger("show", b)
      }
    },
    b.container.prototype.hide = function(a, b) {
      if (this.isVisible()) {
        var c = this.parent;
        this.timeout = setTimeout(function() {
          c.container.element.removeClass("contextmenu-visible"),
            c.container.detachTimeout = setTimeout(function() {
              c.selector.deselect(),
                c.container.element.detach()
            }, c.settings.transition.speed),
            c.trigger("hide", a)
        }, b || 0)
      }
    },
    b.container.prototype.cancelHide = function() {
      clearTimeout(this.detachTimeout),
        clearTimeout(this.timeout)
    },
    b.container.prototype.isVisible = function() {
      return this.parent.items.isBuilt() && this.element.hasClass("contextmenu-visible")
    },
    b.container.prototype.setAutoHide = function() {
      var a = this.parent;
      this.element.hover(function(b) {
        a.container.cancelHide()
      }, function(b) {
        a.container.hide(b, a.settings.autoHide)
      })
    },
    b.container.prototype.destroy = function() {
      this.element.remove()
    },
    b.events = function(a) {
      this.parent = a
    },
    b.events.prototype.bind = function() {
      this[this.parent.settings.event](),
        this.setKeyboardNavigation()
    },
    b.events.prototype.unbind = function() {
      null !== this.parent.settings.selector && a("html").off("click contextmenu mouseenter mouseleave dblclick focusin", this.parent.settings.selector)
    },
    b.events.prototype.hover = function() {
      var b = this.parent,
        c = b.settings.selector;
      a(c ? "html" : b.element).on({
          mouseenter: function(a) {
            b.events.targetIsElement(a.target) && b.show(a)
          },
          mouseleave: function(c) {
            a(c.toElement).closest(b.container.element).length || b.container.hide(c, b.settings.autoHide)
          },
          mousemove: function(a) {
            b.events.targetIsElement(a.target) && b.settings.position.children && b.show(a)
          }
        }, c),
        this.parent.container.element.hover(function(a) {
          b.container.cancelHide()
        }, function(c) {
          a(c.toElement).closest(b.element).length || b.container.hide(c, b.settings.autoHide)
        }),
        a("html").on("click contextmenu", function(a) {
          b.events.offEvent(a)
        })
    },
    b.events.prototype.contextmenu = function() {
      var b = this.parent;
      a("html").on("contextmenu", b.settings.selector, function(a) {
          b.events.onEvent(a)
        }),
        a("html").on("click", function(a) {
          b.hide(a)
        })
    },
    b.events.prototype.click = function() {
      var b = this.parent;
      a("html").on("click", b.settings.selector, function(a) {
          b.events.onEvent(a)
        }),
        a("html").on("click contextmenu", function(a) {
          b.events.offEvent(a)
        })
    },
    b.events.prototype.focus = function() {
      var b = this.parent;
      a("html").on("focusin", b.settings.selector, function(a) {
          b.events.onEvent(a)
        }),
        a("html").on("click contextmenu", function(a) {
          b.events.offEvent(a)
        })
    },
    b.events.prototype.dblclick = function() {
      var b = this.parent;
      a("html").on("dblclick", b.settings.selector, function(a) {
          b.events.onEvent(a)
        }),
        a("html").on("click contextmenu", function(a) {
          b.events.offEvent(a)
        })
    },
    b.events.prototype.onEvent = function(a) {
      var b = this.parent;
      b.events.targetIsElement(a.target) ? (a.preventDefault(),
        b.show(a)) : b.hide(a)
    },
    b.events.prototype.offEvent = function(a) {
      this.parent.events.targetIsElement(a.target) || this.parent.hide(a)
    },
    b.events.prototype.targetIsElement = function(b) {
      return a(b).closest(this.parent.settings.selector || this.parent.element).length
    },
    b.events.prototype.setKeyboardNavigation = function() {
      var b = this.parent;
      a(document).on("keydown keyup", function(a) {
        if (b.container.isVisible()) {
          var c, d = b.selector,
            e = a.which,
            f = d.getSelection();
          if (13 === e && f)
            return a.preventDefault(),
              void f.element.trigger("click");
          if (37 === e || 38 === e || 39 === e || 40 === e) {
            if (a.preventDefault(),
              "keyup" === a.type)
              return;
            switch (e) {
              case 37:
                c = d.getImmediateParentItem();
                break;
              case 38:
                c = d.getPrevItem();
                break;
              case 39:
                c = d.getFirstChildItem();
                break;
              case 40:
                c = d.getNextItem()
            }
            if (f && f.getID() === c.id || (f && f.element.trigger("mouseleave"),
                c.element.trigger("mouseenter")),
              null !== b.settings.maxHeight) {
              var g = c.element,
                h = b.items.root.element,
                i = g.outerHeight(),
                j = h.outerHeight();
              g.offset().top + i > h.offset().top + j && h.scrollTop(h.scrollTop() + i),
                g.offset().top < h.offset().top && h.scrollTop(h.scrollTop() - i)
            }
          }
        }
      })
    },
    b.position = function(a) {
      this.parent = a
    },
    b.position.prototype.set = function(b) {
      this.element = this.getElement(b),
        this.offset = {
          x: b.pageX - a(this.element).offset().left,
          y: b.pageY - a(this.element).offset().top
        },
        this.target = b.target,
        this.mouse = {
          x: b.pageX,
          y: b.pageY
        },
        this.$position(),
        this.parent.selector.deselect(),
        this.parent.trigger("position", b)
    },
    b.position.prototype.onResize = function() {
      this.parent.container.isVisible() && this.$position()
    },
    b.position.prototype.$position = function() {
      if ("undefined" == typeof this.element)
        throw "Must use ContextMenu.position.set() prior to $position";
      var b = this.parent,
        c = b.settings.position,
        d = "mouse" === c.at,
        e = c.my,
        f = d ? "left+" + this.offset.x + " top+" + this.offset.y : c.at;
      a(this.parent.container.element).position({
        my: e,
        at: f,
        of: c.children !== !1 && a(this.target).closest(c.children).length ? a(this.target).closest(c.children) : this.element,
        collision: "fit",
        using: function(a, c) {
          c.element.element.css({
              top: a.top,
              left: a.left
            }),
            b.position.placeArrow(c.element, c.target)
        }
      })
    },
    b.position.prototype.placeArrow = function(a, b) {
      var c = this.parent,
        d = c.settings,
        e = c.arrow,
        f = "mouse" === c.settings.position.at;
      !1 !== d.arrow && ("auto" === d.arrow ? e.setPosition(f ? e.calcCoordsRelativePosition(this.mouse) : e.calcTargetRelativePosition(a, b)) : e.setPosition(d.arrow))
    },
    b.position.prototype.getElement = function(b) {
      return null !== this.parent.settings.selector ? a(b.target).closest(this.parent.settings.selector) : this.parent.element
    },
    b.arrow = function(a) {
      this.parent = a
    },
    b.arrow.prototype.setPosition = function(b) {
      if (this.parent.settings.arrow.match()) {
        var c = ["top", "left", "right", "bottom"],
          d = "contextmenu-arrow-",
          e = d + c.join(" " + d),
          f = this.parent.container.element;
        a(f).removeClass(e).addClass(d + b)
      }
    },
    b.arrow.prototype.calcCoordsRelativePosition = function(b) {
      var c = b.x,
        d = b.y,
        e = a(this.parent.container.element),
        f = e.offset().left,
        g = f + e.width(),
        h = e.offset().top,
        i = h + e.height();
      if (g >= c && c >= f) {
        if (h >= d)
          return "top";
        if (d >= i)
          return "bottom"
      }
      if (i >= d && d >= h) {
        if (f >= c)
          return "left";
        if (c >= g)
          return "right"
      }
    },
    b.arrow.prototype.calcTargetRelativePosition = function(a, b) {
      var c = a.left,
        d = a.left + a.width,
        e = a.top,
        f = a.top + a.height,
        g = b.left,
        h = b.left + b.width,
        i = b.top,
        j = b.top + b.height;
      return c > g && h > c && e > i && j > e ? "top" : i >= f ? "bottom" : e >= j ? "top" : c >= h ? "left" : g >= d ? "right" : void 0
    },
    b.ui = function() {},
    b.ui.title = function(b) {
      this.element = a("<li>").addClass("contextmenu-title").html(b.text)
    },
    b.ui.divider = function(b) {
      this.element = a("<li>").addClass("contextmenu-divider")
    },
    b.ui.item = function(c, d) {
      this.settings = c,
        this.ctxMenu = d,
        this.id = b.items.generateID(),
        this.icon = a("<i>").addClass(c.icon),
        this.text = a("<span>").addClass("contextmenu-item-text").html(c.text),
        this.element = a("<li>").addClass("contextmenu-item").attr("data-item-id", this.id).append(this.icon).append(this.text),
        c.disabled && this.disable(),
        "undefined" != typeof c.id && this.element.attr("id", c.id),
        this.createSubmenu(),
        this.bindEvents()
    },
    b.ui.item.prototype.disable = function() {
      this.element.addClass("contextmenu-disabled")
    },
    b.ui.item.prototype.isDisabled = function() {
      return this.element.hasClass("contextmenu-disabled")
    },
    b.ui.item.prototype.bindEvents = function() {
      if (!this.settings.disabled) {
        var b = this,
          c = a.extend({}, b.settings, {
            instance: b
          });
        this.element.on("mouseenter", function(a) {
            a.preventDefault(),
              a.stopPropagation(),
              b.isDisabled() || b.ctxMenu.selector.select(b.getID()),
              b.hasSubmenu() && b.submenu.show(),
              "function" == typeof b.settings.hover && b.settings.hover.call(c, a)
          }),
          this.element.on("mouseleave", function(a) {
            a.preventDefault(),
              a.stopPropagation(),
              b.ctxMenu.selector.deselect(),
              b.hasSubmenu() && b.submenu.hide()
          }),
          this.element.on("click", function(a) {
            "function" == typeof b.settings.click && b.settings.click.call(c, a),
              b.hasSubmenu() && b.submenu.hide()
          })
      }
    },
    b.ui.item.prototype.createSubmenu = function() {
      this.settings.disabled || this.hasSubmenu() && (this.submenu = new b.menu(this.settings.items, this.ctxMenu),
        this.element.addClass("contextmenu-submenu").append(this.submenu.element))
    },
    b.ui.item.prototype.hasSubmenu = function() {
      return Array.isArray(this.settings.items) && this.settings.items.length > 0
    },
    b.ui.item.prototype.getID = function() {
      return this.id
    },
    b.ui.checkbox = function(c, d) {
      this.settings = c,
        this.ctxMenu = d,
        this.id = b.items.generateID(),
        this.icon = a("<i>").addClass(c.icon),
        this.text = a("<span>").addClass("contextmenu-item-text").html(c.text),
        this.element = a("<li>").addClass("contextmenu-checkbox").attr("data-item-id", this.id).append(this.icon).append(this.text),
        c.disabled && this.disable(),
        c.checked && this.check(),
        "undefined" != typeof c.id && this.element.attr("id", c.id),
        this.registerEventListeners()
    },
    b.ui.checkbox.prototype.registerEventListeners = function() {
      if (!this.settings.disabled) {
        var b = this,
          c = a.extend({}, b.settings, {
            instance: b
          });
        this.element.on("mouseenter", function(a) {
            b.isDisabled() || b.ctxMenu.selector.select(b.getID()),
              "function" == typeof b.settings.hover && b.settings.hover.call(c, a)
          }),
          this.element.on("mouseleave", function(a) {
            b.ctxMenu.selector.deselect()
          }),
          this.element.click(function(a) {
            b.toggle(),
              "function" == typeof b.settings.click && b.settings.click.call(c, a)
          })
      }
    },
    b.ui.checkbox.prototype.disable = function() {
      this.element.addClass("contextmenu-disabled")
    },
    b.ui.checkbox.prototype.isDisabled = function() {
      return this.element.hasClass("contextmenu-disabled")
    },
    b.ui.checkbox.prototype.check = function() {
      this.element.addClass("contextmenu-checked")
    },
    b.ui.checkbox.prototype.uncheck = function() {
      this.element.removeClass("contextmenu-checked")
    },
    b.ui.checkbox.prototype.toggle = function() {
      this.element.toggleClass("contextmenu-checked")
    },
    b.ui.checkbox.prototype.isChecked = function() {
      return this.element.hasClass("contextmenu-checked")
    },
    b.ui.checkbox.prototype.getID = function() {
      return this.id
    },
    a.widget("custom.contextMenu", {
      options: b.defaults,
      _create: function() {
        null !== this.options.selector && (this.element = a(this.options.selector)),
          this.contextMenu = new b(this.element, this.options)
      },
      _refresh: function() {
        this.contextMenu.build()
      },
      _destroy: function() {
        this.contextMenu.destroy()
      },
      show: function(a) {
        return this.contextMenu.show(a),
          this.element
      },
      hide: function(a) {
        return this.contextMenu.hide(a),
          this.element
      },
      refresh: function(a) {
        return this.contextMenu.hide(a),
          this.contextMenu.show(a),
          this.element
      },
      isVisible: function() {
        return this.contextMenu.container.isVisible()
      },
      getItems: function() {
        var a = this.contextMenu;
        return this.isVisible() ? a.items.getAll() : void 0
      },
      select: function(a) {
        var b = this.contextMenu;
        return b.container.isVisible() ? b.selector.select(a) : void 0
      }
    })
});
! function(a, t) {
  "function" == typeof define && define.amd ? define(t) : "object" == typeof exports ? module.exports = t(require, exports, module) : a.CountUp = t()
}(this, function(a, t, n) {
  var e = function(a, t, n, e, i, r) {
    for (var o = 0, s = ["webkit", "moz", "ms", "o"], m = 0; m < s.length && !window.requestAnimationFrame; ++m)
      window.requestAnimationFrame = window[s[m] + "RequestAnimationFrame"],
      window.cancelAnimationFrame = window[s[m] + "CancelAnimationFrame"] || window[s[m] + "CancelRequestAnimationFrame"];
    window.requestAnimationFrame || (window.requestAnimationFrame = function(a, t) {
        var n = (new Date).getTime(),
          e = Math.max(0, 16 - (n - o)),
          i = window.setTimeout(function() {
            a(n + e)
          }, e);
        return o = n + e,
          i
      }),
      window.cancelAnimationFrame || (window.cancelAnimationFrame = function(a) {
        clearTimeout(a)
      });
    var u = this;
    u.options = {
      useEasing: !0,
      useGrouping: !0,
      separator: ",",
      decimal: ".",
      easingFn: null,
      formattingFn: null
    };
    for (var l in r)
      r.hasOwnProperty(l) && (u.options[l] = r[l]);
    "" === u.options.separator && (u.options.useGrouping = !1),
      u.options.prefix || (u.options.prefix = ""),
      u.options.suffix || (u.options.suffix = ""),
      u.d = "string" == typeof a ? document.getElementById(a) : a,
      u.startVal = Number(t),
      u.endVal = Number(n),
      u.countDown = u.startVal > u.endVal,
      u.frameVal = u.startVal,
      u.decimals = Math.max(0, e || 0),
      u.dec = Math.pow(10, u.decimals),
      u.duration = 1e3 * Number(i) || 2e3,
      u.formatNumber = function(a) {
        a = a.toFixed(u.decimals),
          a += "";
        var t, n, e, i;
        if (t = a.split("."),
          n = t[0],
          e = t.length > 1 ? u.options.decimal + t[1] : "",
          i = /(\d+)(\d{3})/,
          u.options.useGrouping)
          for (; i.test(n);)
            n = n.replace(i, "$1" + u.options.separator + "$2");
        return u.options.prefix + n + e + u.options.suffix
      },
      u.easeOutExpo = function(a, t, n, e) {
        return n * (-Math.pow(2, -10 * a / e) + 1) * 1024 / 1023 + t
      },
      u.easingFn = u.options.easingFn ? u.options.easingFn : u.easeOutExpo,
      u.formattingFn = u.options.formattingFn ? u.options.formattingFn : u.formatNumber,
      u.version = function() {
        return "1.7.1"
      },
      u.printValue = function(a) {
        var t = u.formattingFn(a);
        "INPUT" === u.d.tagName ? this.d.value = t : "text" === u.d.tagName || "tspan" === u.d.tagName ? this.d.textContent = t : this.d.innerHTML = t
      },
      u.count = function(a) {
        u.startTime || (u.startTime = a),
          u.timestamp = a;
        var t = a - u.startTime;
        u.remaining = u.duration - t,
          u.options.useEasing ? u.countDown ? u.frameVal = u.startVal - u.easingFn(t, 0, u.startVal - u.endVal, u.duration) : u.frameVal = u.easingFn(t, u.startVal, u.endVal - u.startVal, u.duration) : u.countDown ? u.frameVal = u.startVal - (u.startVal - u.endVal) * (t / u.duration) : u.frameVal = u.startVal + (u.endVal - u.startVal) * (t / u.duration),
          u.countDown ? u.frameVal = u.frameVal < u.endVal ? u.endVal : u.frameVal : u.frameVal = u.frameVal > u.endVal ? u.endVal : u.frameVal,
          u.frameVal = Math.round(u.frameVal * u.dec) / u.dec,
          u.printValue(u.frameVal),
          t < u.duration ? u.rAF = requestAnimationFrame(u.count) : u.callback && u.callback()
      },
      u.start = function(a) {
        return u.callback = a,
          u.rAF = requestAnimationFrame(u.count), !1
      },
      u.pauseResume = function() {
        u.paused ? (u.paused = !1,
          delete u.startTime,
          u.duration = u.remaining,
          u.startVal = u.frameVal,
          requestAnimationFrame(u.count)) : (u.paused = !0,
          cancelAnimationFrame(u.rAF))
      },
      u.reset = function() {
        u.paused = !1,
          delete u.startTime,
          u.startVal = t,
          cancelAnimationFrame(u.rAF),
          u.printValue(u.startVal)
      },
      u.update = function(a) {
        cancelAnimationFrame(u.rAF),
          u.paused = !1,
          delete u.startTime,
          u.startVal = u.frameVal,
          u.endVal = Number(a),
          u.countDown = u.startVal > u.endVal,
          u.rAF = requestAnimationFrame(u.count)
      },
      u.printValue(u.startVal)
  };
  return e
});