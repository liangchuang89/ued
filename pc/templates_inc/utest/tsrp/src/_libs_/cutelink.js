/*publish time:2011-08-10 20:45:18*/
(function (A) {
    A.mix(A, {_invoke:function (C, E) {
        if (C) {
            for (var D = 0; D < C.length; D++) {
                try {
                    (new Function(C[D])).apply(E);
                    _log(C[D] + "\u5df2\u89e6\u53d1")
                } catch (B) {
                }
            }
        }
    }, _log:function () {
        if (window._DEV_) {
            A.log.apply(A, arguments)
        }
    }})
})(KISSY);
KISSY.add("cutelink", function (B) {
    var D = "data", A = "params";

    function C() {
        var E = this;
        B.mix(E, {_inited:false, camps:{}, callbacks:{}});
        return E
    }

    B.mix(C, {camps:[], data:{}, params:{}});
    B.augment(C, B.EventTarget, {clear:function (E) {
        if (B.isArray(E)) {
            B.each(E, function (F) {
                delete C[D][F]
            })
        } else {
            C[D] = {}
        }
    }, init:function (G) {
        var F = this;
        if (F._inited && !G) {
            return F
        }
        var G = B.mix({doRedirect:true}, G);
        var E = window.__SafeUrl__, I = initialParam = C.getLocParam(), H = C.getUrlPath(E);
        C[A][H] = I;
        var J = G.oninit;
        if (G.doRedirect && !J) {
            C.history.locCheck()
        } else {
            if (B.isFunction(J)) {
                J.call(F, F.getUrlDetail(E))
            }
        }
        F.fire("init", G);
        F._inited = true;
        return F
    }});
    B.CuteLink = C;
    return C
});
KISSY.add("cutelink/urltools", function (E, F) {
    var D = window, Q = /\?(\w[^#]+)/, V = /([^#\?]*)(\?([^#\?]*))?(#!?([^#]*$))?/, I = /#[^#]*$/, N = "#!", C = "/", W = "", B = "?", K = ",", O = "unparam", H = "param";

    function U() {
        return E[O](D.location.search.replace(B, W))
    }

    function P() {
        return D.location.hash.replace(N, W)
    }

    function A(S) {
        if (I.test(S)) {
            return S.match(I)[0].replace(N, W)
        } else {
            return W
        }
    }

    function G(S) {
        if (Q.test(S)) {
            return S.match(Q)[1]
        } else {
            return W
        }
    }

    function M(S) {
        var X = D.location;
        return S.replace(Q, W).replace(I, W).replace(X.protocol + C + C + X.host, W)
    }

    function R(S) {
        var Y = S.match(V), d = Y[1], Z = Y[2], h = Y[3] || "", c = Y[4], a = Y[5], b = E[O](h), g = {}, f = M(S) || M(D.location.href), e;
        var X = b;
        if (c && c.indexOf(N) == 0) {
            if (a.indexOf(C) != -1 || a.indexOf(B) > 0) {
                var Y = a.match(V);
                e = Y[1];
                X = E[O](Y[3])
            } else {
                X = E[O](a)
            }
        }
        return{path:f, realPath:e || f, param:X, search:h, search_f:Z, searchParam:b, hash:a, hash_f:c, hashParam:g}
    }

    function J(Z, S) {
        if (E.isString(Z)) {
            Z = R(Z)
        }
        var X = Z.hash_f, Y = Z.hash;
        if (!S && X && X.indexOf(N) == 0) {
            if (Y.indexOf(C) != -1 || Y.indexOf(B) > 0) {
                return Y
            } else {
                return Z.path + B + Y
            }
        }
        return Z.path + B + decodeURI(E[H](Z.param))
    }

    function T(Y, X, S) {
        if (E.isObject(X)) {
            E.mix(Y, X)
        }
        if (E.isArray(S)) {
            E.each(S, function (Z) {
                delete Y[Z]
            })
        }
        return Y
    }

    E.mix(E.CuteLink, {getLocParam:U, getLocHash:P, getUrlPath:M, getUrlHash:A, getUrlSearch:G, getUrlDetail:R, getCleanUrl:J, mergeParam:T, makeRealQuery:function (X) {
        var Z = M(D.location.href), f = M(X) || Z;
        if (!Q.test(X)) {
            return{realPath:X, url:X, param:{}}
        }
        var a = this.params, e = R(X), S = e[H], Y = e.realPath, c = a[Y];
        if (c) {
            for (var b in c) {
                if (!S[b]) {
                    delete c[b]
                }
            }
            for (var b in S) {
                if (!c[b] || c[b] != S[b]) {
                    c[b] = S[b]
                }
            }
        } else {
            c = a[Y] = S
        }
        c = L(c);
        var d = Y + B + decodeURI(E[H](c));
        return{realPath:Y, param:c, url:d}
    }});
    function L(Z) {
        var X = {}, Y, S = [];
        for (Y in Z) {
            if (Z.hasOwnProperty(Y)) {
                S.push(Y)
            }
        }
        S.sort();
        for (Y = 0; Y < S.length; Y++) {
            X[S[Y]] = Z[S[Y]]
        }
        return X
    }
});
KISSY.add("cutelink/history", function (G, C) {
    var K = window, N = document, I = G.all, P = G.Event, A = G.DOM, F = G.CuteLink;
    var O = "#!", L = /#[^#]*$/, H = "__clrms", B = "", M = !!(K.history && K.history.pushState);
    F.History = function () {
        this.handlers = {}
    };
    function J(D, E) {
        var E = E || K.location;
        if (D === B) {
            if (E.hash) {
                E.href = E.href.replace(L, B)
            }
        } else {
            E.hash = O + D;
            if(!window.__SafeHash__){
                window.__SafeTempUrl__ = window.__SafeUrl__;
            }
            window.__SafeHash__ = E.hash = O + D;
            window.__SafeUrl__ = window.__SafeTempUrl__ + window.__SafeHash__;
        }
    }

    G.augment(F.History, G.EventTarget, {getCrtUrl:function () {
        return F.getCleanUrl(K.location.href)
    }, start:function () {
        var D = this;
        if (D.started) {
            return
        }
        D.started = true;
        var E = D.getCrtUrl();
        if (M) {
            P.on(K, "popstate", function () {
                D.checkUrl()
            })
        } else {
            if ("onhashchange" in window) {
                P.on(K, "hashchange", function () {
                    D.checkUrl()
                })
            } else {
            }
        }
        D.current = E;
        D._hasPushState = M
    }, setHash:function (Q, D) {
        var E = this;
        J(Q)
    }, navigate:function (R, Q, D) {
        var E = this;
        if (Q) {
            E.prevHandler = E.handlers[R] = [Q, D]
        }
        if (E._hasPushState) {
            K.history.pushState(null, null, R)
        } else {
            E.setHash(R)
        }
        E.checkUrl(R)
    }, loadUrl:function (Q) {
        var R = this.handlers[Q], E, D;
        if (R) {
            E = R[0];
            D = R[1]
        } else {
            R = this.prevHandler;
            E = (R && R[0]) || F.defaultCamp
        }
        if (D) {
            D.data = F.data[Q];
            D.hasCache = !G.isUndefined(D.data);
            E.doRequest(D)
        } else {
            if (E) {
                E.load(Q)
            }
        }
    }, checkUrl:function (Q) {
        var E = this, D = Q || E.getCrtUrl();
        if (D == E.current) {
            return false
        }
        E.current = D;
        E.loadUrl(D)
    }, locCheck:function () {
        var D = K.location;
        if (D.hash.indexOf(O) == -1) {
            return
        }
        D.href = this.current
    }});
    F.history = new F.History();
    F.history.start()
});
KISSY.add("cutelink/register", function (C, J) {
    var k = window, F = document, d = C.all, K = C.DOM, n = C._invoke, G = C._log, j = C.CuteLink, e = /\?(\w[^#]+)/, O = /([^#\?]*)(\?([^#\?]*))?(#!?([^#]*$))?/, o = /#[^#]*$/, A = "/", P = "", T = "?", Q = ",", c = "_cl-guid", W = "status", R = "cache", M = "queue", I = "init", Z = "parse", f = "start", B = "load", U = "loaded", X = "render", N = "rendered", h = "error", m = "loading";

    function l(S) {
        var p = document.createElement("a");

        function D(q) {
            if (!q) {
                return P
            }
            if (window.ActiveXObject) {
                return q.replace(/[\d\D]/g, function (r) {
                    window.vbsval = "";
                    execScript('window.vbsval=Hex(Asc("' + r + '"))', "vbscript");
                    return"%" + window.vbsval.slice(0, 2) + "%" + window.vbsval.slice(-2)
                })
            }
            p.href = "?key=" + q;
            return p.href.split("key=").pop()
        }

        return S.replace(/([^\x00-\xff]+)|([\x00-\xff]+)/g, function (r, q, s) {
            return D(q) + encodeURIComponent(s || "")
        })
    }

    function i(D) {
        return(Y(D, T) ? "&" : T)
    }

    function Y(S, D) {
        if (!C.isString(S)) {
            return false
        }
        return S.indexOf(D) != -1
    }

    function a(r, p) {
        var S = r[0].tagName.toLowerCase(), s = p.split("|"), D = false;
        for (var q = s.length - 1; q >= 0; q--) {
            if (S == s[q]) {
                D = true;
                break
            }
        }
        return D
    }

    function g(S, D, q, p) {
        return q * (Math.pow(S / p - 1, 5) + 1) + D
    }

    function V(r, q) {
        var q = q || 0, r = d(r);
        if (!r.length) {
            return
        }
        var s = K.scrollTop(), D = K.scrollLeft(), t = r.offset().top + q, v = t - s, S = 20, p = 400;
        if (Math.abs(s - t) < 5) {
            return
        }
        function u(x) {
            if (x >= p) {
                return
            }
            x += S;
            var w = g(x, s, v, p);
            setTimeout(function () {
                k.scrollTo(D, w)
            }, x);
            u(x)
        }

        u(0)
    }

    function H(D, p) {
        if (C.isFunction(D)) {
            D.call(this, p)
        } else {
            if (C.isArray(D)) {
                n(D, this)
            } else {
                if (C.isObject(D) && C.isObject(p)) {
                    for (var S in p) {
                        try {
                            D[S].call(this, p[S])
                        } catch (q) {
                            G(q);
                            G("\u6267\u884c " + S + " \u56de\u8c03\u51fa\u9519", "warn");
                            G(p)
                        }
                    }
                }
            }
        }
    }

    var E = {dataType:"json", intf:"_self", intfAttr:"data-cl-intf", intfParam:P, loadingCls:"loading", oneLoading:false, loadingTip:function () {
        alert("\u4e0a\u4e00\u6b21\u8bf7\u6c42\u5c1a\u672a\u5b8c\u6210\uff0c\u8bf7\u7a0d\u540e...")
    }, pushState:true, doCache:true, doRefresh:true, cacheLife:5, onerror:"_fallback", execGlobal:true, scrollTo:"_target", scrollOffset:0, scrollTiming:N};

    function L(S) {
        var D = this;
        D.init(S);
        return D
    }

    var b = j.data;
    C.augment(L, C.EventTarget, {checkQueue:function (S) {
        var s = this[M], r = s.indexOf(S), D = s.length;
        if (r == -1) {
            return
        } else {
            s[r] = U + "||" + s[r]
        }
        if (r == D - 1) {
            return
        }
        for (var p = r + 1; p < D; p++) {
            if (s[p].indexOf(U) == 0) {
                G("[CuteLink]\u7b2c " + (r + 1) + " \u4e2a\u8bf7\u6c42\u5df2\u7ecf\u88ab\u7b2c " + (p + 1) + " \u4e2a\u62a2\u5360", "warn");
                return true
            }
        }
    }, init:function (u) {
        var x = this, u = C.merge(E, u), v = u.dataType, t = u.intfAttr, y = u.intfParam, S = u.loadingCls, w = u.scrollTo, s = u.scrollOffset, D = d(u.baseCamp), r = d(u.target);
        if (!D.length) {
            return x
        }
        if (u.scrollTo == "_target") {
            w = u.scrollTo = r
        }
        u = x.config = u;
        x.isLoading = false;
        D.on("click", q);
        var p = a(D, "form") ? D : d("form", D[0]);
        if (p.length && !u.nativeSubmit && p[0].method.toLowerCase() != "post") {
            p.on("submit", q)
        }
        x.id = u.id || C.guid();
        x.base = D;
        x.target = r;
        x[M] = [];
        x.on(u.scrollTiming, function (z) {
            z.scrollTo ? V(z.scrollTo, s) : P
        });
        x.on(h, function (AA) {
            var z = u.onerror;
            if (z === "_fallback") {
                window.location = AA.url
            } else {
                H.call(x, z, AA)
            }
        });
        x.on(X, function (z) {
            if (v == "html") {
                r.html(z.data)
            }
            x.fire(N, z)
        });
        x.on(N, function (AC) {
            if (u.execGlobal) {
                var AB = x.builder.callbacks, AA = x.id;
                if (v == "html" && AA) {
                    var z = AB[AA];
                    z && z.call(AC)
                } else {
                    H.call(x, AB, AC.data, AC)
                }
            }
        });
        function q(AE) {
            var AA = this, AF = AE.target, AJ = false;
            if (a(AF, "form") && AE.type == "submit") {
                AJ = true
            } else {
                if (!a(AF, "a")) {
                    AF = AF.parent("a")
                }
                if (!AF) {
                    return
                }
            }
            var AB = x.fire(Z, {target:AF, originEvent:AE});
            if (AB && AB != x) {
                return
            }
            var AD = x.parseTarget(AF, AE, AJ);
            if (!C.isObject(AD)) {
                return
            }
            var AG = AF[0].id || AF.attr(c);
            if (!AG) {
                AF.attr(c, AG = C.guid())
            }
            var AI = urlInfo = j.makeRealQuery(AD.url), z = url = urlInfo.url;
            if (AD.intfUrl != AD.url) {
                AI = j.makeRealQuery(AD.intfUrl);
                z = AI.url
            }
            if (y) {
                z += i(z) + y
            }
            z += i(z) + "_cl_t=" + AG;
            var AC = AG + "::" + url;
            if (AC == x.current && u.doRefresh) {
                delete b[url]
            }
            x.current = AC;
            var AH = {isFormSubmit:AJ, guid:AG, target:AF, urlInfo:urlInfo, intfUrlInfo:AI, url:url, intfUrl:z, data:b[url], scrollTo:AD.scrollTo || w};
            if (x.isLoading && u.oneLoading) {
                try {
                    u.loadingTip.call(x, AH)
                } catch (AE) {
                }
                return AE.halt()
            }
            if (u.pushState) {
                window.__SafeUrl__ = url;
                j.history.navigate(url, x, AH)
            } else {
                x.doRequest(AH)
            }
            AE.preventDefault()
        }
    }, getIntfUrl:function (s, u) {
        var p = this, r = p.config, t = r.intfAttr, S = u && u.attr(t), q;
        var D = r.intf;
        if (D == "_global" || C.isFunction(D)) {
            D = p.builder.intf
        }
        switch (D) {
            case"_default":
                intfUrl = S || s;
                break;
            case"_self":
                intfUrl = s;
                break;
            case"_indie":
                intfUrl = S;
                break;
            default:
                intfUrl = D + i(D) + j.getUrlSearch(s)
        }
        return intfUrl
    }, parseTarget:function (AD, AB, q) {
        var v = this, r = v.config, y = AD.attr("href"), s = r.intfAttr, AA = AD.attr(s), p = y, u = P, S = P, AE;
        var z = r.intf;
        if (q) {
            var t = AD, D = t[0], AC = D.elements, x = D.action, w = {};
            if (C.isFunction(r.beforeSubmit)) {
                r.beforeSubmit.call(v, D)
            }
            C.each(AC, function (AG) {
                var AF = AG.name, AH = AG.value;
                if (AF) {
                    w[AF] = l(AH)
                }
            });
            p = x;
            if (!C.isEmptyObject(w)) {
                p += i(x) + C.param(w)
            }
        }
        if (!p || /^(#|javascript:)/.test(p)) {
            return
        }
        if (C.isFunction(z)) {
            AE = z.call(v, AD, AB);
            C.isObject(AE) ? AE.scrollTo = S : P;
            return AE
        }
        if (o.test(p)) {
            S = p.match(o)[0];
            p = p.replace(S, P)
        } else {
            S = r.scollTo
        }
        u = v.getIntfUrl(p);
        return{scrollTo:S, intfUrl:u, url:p}
    }, doRequest:function (v) {
        var w = this, t = w.config, r = w.target, S = t.loadingCls;
        if (v.data) {
            v.hasCache = true
        }
        w.fire(f, v);
        if (v.hasCache) {
            w.render(v);
            return true
        }
        var p = v.url, D = v.intfUrl, u = v.guid, s = v.target, q = u + "||" + D;
        w[M].push(q);
        w.fire(B, v);
        r.addClass(S);
        w.isLoading = true;
        C.io({url:D, success:function (y) {
            v.data = y;
            w.isLoading = false;
            r.removeClass(S);
            if (!y) {
                w.fire(h, v);
                return
            }
            var x = w.config.cacheLife * 60000;
            b[p] = y;
            C.later(function () {
                delete b[p]
            }, x);
            if (!w.checkQueue(q)) {
                w.render(v)
            }
            w.fire(U, v)
        }, complete:function (y, x) {
            w.isLoading = false;
            r.removeClass(S)
        }, error:function (x) {
            w.isLoading = false;
            r.removeClass(S);
            v.data = x;
            w.fire(h, v)
        }, dataType:w.config.dataType})
    }, render:function (D) {
        this.fire(X, D)
    }, load:function (D) {
        this.doRequest({url:D, intfUrl:this.getIntfUrl(D), noPushState:true, data:j.data[D]})
    }, reset:function () {
        self[M] = []
    }});
    C.augment(j, {register:function (S) {
        var D = new L(S);
        j.camps.push(this.camps[D.id] = D);
        D.builder = this;
        return D
    }})
});