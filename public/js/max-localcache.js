!(function (a, b) {
    "function" == typeof define && define.amd ? define([], b) : "undefined" != typeof module && module.exports ? (module.exports = b()) : (a.lscache = b());
})(this, function () {
    function a() {
        var a = "__lscachetest__",
            c = a;
        if (void 0 !== o) return o;
        try {
            if (!localStorage) return !1;
        } catch (a) {
            return !1;
        }
        try {
            h(a, c), i(a), (o = !0);
        } catch (a) {
            o = !(!b(a) || !localStorage.length);
        }
        return o;
    }
    function b(a) {
        return a && ("QUOTA_EXCEEDED_ERR" === a.name || "NS_ERROR_DOM_QUOTA_REACHED" === a.name || "QuotaExceededError" === a.name);
    }
    function c() {
        return void 0 === p && (p = null != window.JSON), p;
    }
    function d(a) {
        return a.replace(/[[\]{}()*+?.\\^$|]/g, "\\$&");
    }
    function e(a) {
        return a + r;
    }
    function f() {
        return Math.floor(new Date().getTime() / t);
    }
    function g(a) {
        return localStorage.getItem(q + v + a);
    }
    function h(a, b) {
        localStorage.removeItem(q + v + a), localStorage.setItem(q + v + a, b);
    }
    function i(a) {
        localStorage.removeItem(q + v + a);
    }
    function j(a) {
        for (var b = new RegExp("^" + q + d(v) + "(.*)"), c = localStorage.length - 1; c >= 0; --c) {
            var f = localStorage.key(c);
            (f = f && f.match(b)), (f = f && f[1]), f && f.indexOf(r) < 0 && a(f, e(f));
        }
    }
    function k(a) {
        var b = e(a);
        i(a), i(b);
    }
    function l(a) {
        var b = e(a),
            c = g(b);
        if (c) {
            var d = parseInt(c, s);
            if (f() >= d) return i(a), i(b), !0;
        }
    }
    function m(a, b) {
        w && "console" in window && "function" == typeof window.console.warn && (window.console.warn("lscache - " + a), b && window.console.warn("lscache - The error was: " + b.message));
    }
    function n(a) {
        return Math.floor(864e13 / a);
    }
    var o,
        p,
        q = "lscache-",
        r = "-cacheexpiration",
        s = 10,
        t = 6e4,
        u = n(t),
        v = "",
        w = !1,
        x = {
            set: function (d, l, n) {
                if (!a()) return !1;
                if (!c()) return !1;
                try {
                    l = JSON.stringify(l);
                } catch (a) {
                    return !1;
                }
                try {
                    h(d, l);
                } catch (a) {
                    if (!b(a)) return m("Could not add item with key '" + d + "'", a), !1;
                    var o,
                        p = [];
                    j(function (a, b) {
                        var c = g(b);
                        (c = c ? parseInt(c, s) : u), p.push({ key: a, size: (g(a) || "").length, expiration: c });
                    }),
                        p.sort(function (a, b) {
                            return b.expiration - a.expiration;
                        });
                    for (var q = (l || "").length; p.length && q > 0; ) (o = p.pop()), m("Cache is full, removing item with key '" + d + "'"), k(o.key), (q -= o.size);
                    try {
                        h(d, l);
                    } catch (a) {
                        return m("Could not add item with key '" + d + "', perhaps it's too big?", a), !1;
                    }
                }
                return n ? h(e(d), (f() + n).toString(s)) : i(e(d)), !0;
            },
            get: function (b) {
                if (!a()) return null;
                if (l(b)) return null;
                var d = g(b);
                if (!d || !c()) return d;
                try {
                    return JSON.parse(d);
                } catch (a) {
                    return d;
                }
            },
            remove: function (b) {
                a() && k(b);
            },
            supported: function () {
                return a();
            },
            flush: function () {
                a() &&
                j(function (a) {
                    k(a);
                });
            },
            flushExpired: function () {
                a() &&
                j(function (a) {
                    l(a);
                });
            },
            setBucket: function (a) {
                v = a;
            },
            resetBucket: function () {
                v = "";
            },
            getExpiryMilliseconds: function () {
                return t;
            },
            setExpiryMilliseconds: function (a) {
                (t = a), (u = n(t));
            },
            enableWarnings: function (a) {
                w = a;
            },
        };
    return x;
});
