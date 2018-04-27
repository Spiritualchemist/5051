//////////////////////////////////////////////////////////
//                                                      //
//                   .-..___..---.                      //
//                  (``...___..-``)                     //
//                   `-.._____.--`                      //
//            ._ o _ | | _   ._ | _.   _ ._             //
//            |_)|(_ |<|(/_  |_)|(_|\/(/_|              //
//            |              |      /                   //
//                   Pickle Player                      //
//                   Version 1.2.4                      //
//                      8/6/2013                        //
//                                                      //
//       Available at http://www.pickleplayer.com       //
//                 Copyright  Mike Gieson               //
//                                                      //
//////////////////////////////////////////////////////////


var PKL_UseHTML5only = false;
var PKL_EventsEnabled = true;

var PKL_FallbackExtension = "webm";
var PKL_MediaBackgroundColor = "#000000";
var PKL_StartupText = "Click To Play";
var PKL_AspectRatio = "1";
var PKL_TimeFormat = "1 / 3";
var PKL_InfoDisplayFormat = "1 - 2 ***";
var PKL_DiscoveryAttribute = "data-media";
var PKL_DefaultPlayerID = "PKL_PLAYER";

var PKL_loop = false;
var PKL_Random = false;
var PKL_AutoAdvance = true;

var PKL_EngineSpeed = 30;
var PKL_FadeDelaySpeed = 200;
var PKL_FadeSpeed = 55;
var PKL_ScrollUpdateSpeed = 8;
var PKL_InfoDisplaySpeed = 1.1;
var PKL_PlayerUpdateInterval = 10;

function PKL_HandleTrackLaunched(myReturnedObject) {
    // Your code here.
}
function PKL_HandleTrackStarted(myReturnedObject) {
    // Your code here.
}
function PKL_HandleTrackStopped(myReturnedObject) {
    // Your code here.
}
function PKL_HandleTrackDone(myReturnedObject) {
    // Your code here.
}
function PKL_HandlePickleLoad() {
    // Your code here.
}

//////////////////////////////////////////////////////////
//                                                      //
//               Do not edit below here                 //
//                                                      //
//////////////////////////////////////////////////////////


var __PKL = __PKL || null;
if (!__PKL) {
    var PKL_onload = function () {
        PKL_HandlePickleLoad()
    }, PKL_Reboot = function () {
        __PKL.fz()
    }, PKL_LoadAndPlay = function (a) {
        if (PKL_AmReady()) {
            if ("string" == typeof a)var b = {file: a, title: null, artist: null, image: null}; else {
                var b = {}, c;
                for (c in a)b[c] = a[c];
                b.file = a.file ? a.file : null;
                b.title = a.title ? a.title : null;
                b.artist = a.artist ? a.artist : null;
                b.image = a.image ? a.image : null
            }
            c = a.player ? a.player : PKL_DefaultPlayerID;
            b.file = __PKL.ai(b.file);
            __PKL.PLR[c].cf(b)
        } else __PKL.cR(function () {
            PKL_LoadAndPlay(a)
        })
    }, PKL_PreloadMedia = function (a) {
        if (PKL_AmReady()) {
            var b = "string" == typeof a ? {file: a, title: null, artist: null, image: null} : {file: a.file ? a.file : null, title: a.title ? a.title : null, artist: a.artist ? a.artist : null, image: a.image ? a.image : null};
            a = a.player ? a.player : PKL_DefaultPlayerID;
            b.file = __PKL.ai(b.file);
            __PKL.PLR[a].fs(b)
        }
    }, PKL_Play = function (a) {
        __PKL.PLR[a ? a : PKL_DefaultPlayerID].bD()
    }, PKL_Pause = function (a) {
        __PKL.PLR[a ? a : PKL_DefaultPlayerID].aB()
    }, PKL_Reset = function (a) {
        a = a ? a : PKL_DefaultPlayerID;
        a == __PKL.C.player && (__PKL.PLR[a].Rewind(), __PKL.PLR[a].bL(), __PKL.fE(), __PKL.PLR[a].bL())
    }, PKL_SetPlayheadSeconds = function (a) {
        var b = __PKL.bW(), c = 0;
        0 < parseInt(b.init) && 0 < parseInt(b.duration) && (c = b.duration, __PKL.aQ(a / c))
    }, PKL_GetInfo = function (a) {
        return __PKL.PLR[a ? a : PKL_DefaultPlayerID].aq()
    }, PKL_SetPoster = function (a) {
        a = "string" == typeof a ? {image: a, player: PKL_DefaultPlayerID} : a;
        a.player = a.player ? a.player : PKL_DefaultPlayerID;
        __PKL.PLR[a.player].dq(a.image)
    }, PKL_LoadPlaylist = function (a) {
        if (PKL_AmReady()) {
            var b = "", c = "", d = !1;
            "string" == typeof a ? c = a : a.file && (c = a.file, b = a.player, d = a.append ? a.append : !1);
            b = b ? b : PKL_DefaultPlayerID;
            c = __PKL.ai(c);
            __PKL.PLR[b].Playlist ? __PKL.PLR[b].Playlist.load(c, d) : __PKL.PLR[b].Playlist = new __PKL.Playlist(__PKL.PLR[b].V, c, __PKL.PLR[b].bw, __PKL.PLR[b].bJ, __PKL.PLR[b].cD)
        } else __PKL.cR(function () {
            PKL_LoadPlaylist(a)
        })
    }, PKL_SetInfo = function (a) {
        __PKL.PLR[a.player ? a.player : PKL_DefaultPlayerID].fF(a.title ? a.title : "", a.artist ? a.artist : "")
    }, PKL_AddPlayer = function (a) {
        PKL_AmReady() ? __PKL.bv(a) : __PKL.cR(function () {
            __PKL.bv(a)
        })
    }, PKL_AmReady = function () {
        return __PKL.cT()
    }, __PKL_INTERVAL = null, __PKL_Listener_TrackDone = function (a) {
        __PKL.bX(a)
    }, __PKL_Listener_TrackStopped = function (a) {
        __PKL.ec(a)
    }, __PKL_Listener_TrackStarted = function (a) {
        __PKL.fB(a)
    }, __PKL_Listener_TrackLaunched = function (a) {
        __PKL.ek(a)
    }, __PKL_EVENT_RESIZE = function () {
        if (__PKL.aD)__PKL.dz(); else for (var a in __PKL.PLR)__PKL.PLR[a].cJ()
    }, __PKL_EVENT_SCROLL = function () {
        __PKL.aD && __PKL.dz()
    }, __PKL_GOODBYE = function () {
        __PKL.PLR && __PKL.PLR[__PKL.C.player] && __PKL.PLR[__PKL.C.player].bL()
    }, __PKL_EXIT_FULLSCREEN = function (a) {
        __PKL.aD && (a || (a = window.event), 27 == a.keyCode && __PKL.dj())
    };
    (function () {
        __PKL = {H: document, el: "pickle.js", ak: "__PKLDYNID", dN: "__PKLOVERCOATID", eK: 0, cU: "__PKLPRELOADERDIV", co: [], cq: [], ef: [], bC: 0, ba: "__PICKLEPLAYER", dM: "__PICKLEPLAYERWRAPPER", ds: 0, ep: 0, dU: "position:relative;float:left;display:block;", bP: PKL_DiscoveryAttribute.replace("data-", ""), cj: !1, cn: [], PLR: {}, v: 10, ap: 0, ag: !1, aA: null, bq: null, he: !0, C: {file: "", player: ""}, K: {bf: !1, bM: !1, G: !0, ay: !1}, bh: !1, cg: !1, fI: 0.99999999, bn: 1E-8, dV: "PKLPLAYERTDIV", ce: !1, hy: 600, fk: 0, fj: "300", ft: "500", bA: {}, ar: "onmousedown", bc: "onmouseup", au: "onmousemove", T: null, cl: null, av: null, aV: null, bG: null, fp: [], bm: "2147480000", aD: !1, bs: null, an: "__PKL_FS_PLAYER", aY: [], az: 0, cv: null, bV: null, cc: null, fv: !1, eV: 0, aW: [], aa: [], cb: !1, fe: 0, eB: 0, bE: !1, bk: {current: {player: null, slider: null}, dK: null, cY: null}, eS: {mp3: ["audio", "audio/mp3,audio/mpeg"], aif: ["audio", "audio/x-aiff,audio/aiff"], aifc: ["audio", "audio/x-aiff,audio/aiff"], aiff: ["audio", "audio/x-aiff,audio/aiff"], wav: ["audio", "audio/wav, audio/wave, audio/x-wav, audio/vnd.wave"], gR: ["audio", "audio/wav, audio/wave, audio/x-wav, audio/vnd.wave"], aac: ["audio", "audio/aac, audio/aacp, audio/3gpp, audio/3gpp2, audio/mp4, audio/MP4A-LATM, audio/mpeg4-generic"], m4a: ["audio", "audio/m4a"], mpa: ["audio", "audio/mpeg"], oga: ["audio", "audio/ogg"], qt: ["video", "video/quicktime"], mov: ["video", "video/quicktime"], flv: ["video", "video/x-flv"], avi: ["video", "video/vnd.avi, video/avi, video/msvideo, video/x-msvideo"], mpe: ["video", "video/mpeg"], mpv: ["video", "video/mpeg"], mpeg: ["video", "video/mpeg"], mpg: ["video", "video/mpeg"], m4v: ["video", "video/mp4"], m4p: ["video", "video/mp4"], webm: ["video", "video/webm"], f4v: ["video", "video/x-flv, video/mp4, video/x-m4v, audio/mp4a-latm, video/3gpp, video/quicktime, audio/mp4"], f4p: ["video", "video/x-flv, video/mp4, video/x-m4v, audio/mp4a-latm, video/3gpp, video/quicktime, audio/mp4"], f4b: ["video", "video/x-flv, video/mp4, video/x-m4v, audio/mp4a-latm, video/3gpp, video/quicktime, audio/mp4"], mpg4: ["video", "video/mp4, audio/mp4"], mp4: ["video", "video/mp4, audio/mp4"], ogg: ["video", "video/ogg, audio/ogg"], ogx: ["video", "video/ogg, audio/ogg"], ogv: ["video", "video/ogg, audio/ogg"], ogm: ["video", "video/ogg, audio/ogg"], spx: ["video", "video/ogg, audio/ogg"]}, ct: "PKL_play PKL_playpause PKL_pause PKL_mute PKL_loop PKL_time PKL_thinker PKL_rewind PKL_next PKL_scrubBkgd PKL_scrubHandle PKL_scrubBar PKL_loading PKL_screen_play PKL_playlist PKL_playlistScrollBkgd PKL_playlistScrollHandle PKL_info PKL_infoBkgd PKL_controlsBkgd PKL_poster PKL_fullscreen".split(" "), cI: [], cV: function (a) {
            if (a = document.getElementById(a))for (; a.hasChildNodes();)a.removeChild(a.lastChild)
        }, dr: function (a) {
            a = document.getElementById(a);
            var b;
            null != a && null != (b = a.parentNode) && b.removeChild(a)
        }, fz: function () {
            __PKL_GOODBYE();
            for (var a = __PKL.co, b = 0; b < a.length; b++) {
                var c = a[b];
                __PKL.cV(c);
                var d = document.getElementById(c);
                d && (c = d.parentNode, c.id.substr(0, this.dN.length) == this.dN && (d = d.cloneNode(!0), d.removeAttribute("style"), d.id.substr(0, PKL_DefaultPlayerID.length) == PKL_DefaultPlayerID && d.removeAttribute("id"), c.parentNode.insertBefore(d, c)))
            }
            a = __PKL.cq;
            for (b = 0; b < a.length; b++)c = a[b], __PKL.cV(c), __PKL.dr(c);
            __PKL.cV(__PKL.cU);
            __PKL.dr(__PKL.cU);
            __PKL.cV(__PKL.dM);
            __PKL.dr(__PKL.dM);
            __PKL.co = [];
            __PKL.cq = [];
            __PKL.ef = [];
            __PKL.bC = 0;
            __PKL.eK = 0;
            __PKL.cj = !1;
            __PKL.cn = [];
            __PKL.PLR = {};
            __PKL.aA = null;
            __PKL.bq = null;
            __PKL.C = {file: "", player: ""};
            __PKL.bh = !1;
            __PKL.cg = !1;
            __PKL.ce = !1;
            __PKL.ag = !1;
            __PKL.bA = {};
            __PKL.T = null;
            __PKL.aV = null;
            __PKL.bG = null;
            __PKL.fp = [];
            __PKL.aD = !1;
            __PKL.bs = null;
            __PKL.aY = [];
            __PKL.az = 0;
            __PKL.cv = null;
            __PKL.bV = null;
            __PKL.cc = null;
            __PKL.fv = !1;
            __PKL.eV = 0;
            __PKL.aW = [];
            __PKL.aa = [];
            __PKL.cb = !1;
            __PKL.bk = {current: {player: null, slider: null}, dK: null, cY: null};
            __PKL.cI = [];
            __PKL.bh = !1;
            __PKL.aJ()
        }, cT: function () {
            return this.cg ? this.K.G ? this.ag ? !0 : !1 : !0 : !1
        }, cR: function (a) {
            this.cI.push(a)
        }, fJ: function () {
            for (var a = 0; a < this.cI.length; a++)this.cI[a]();
            return!0
        }, dW: function () {
            this.bh || (this.bh = !0, this.eI(), this.df())
        }, df: function () {
            var a = !0, b = __PKL.gv();
            b && 0 < b.length && (a = !1, __PKL.hh());
            a && setTimeout(__PKL.df, 100)
        }, hh: function () {
            for (var a = [], b = [], c = this.H.getElementsByTagName("div"), d = 0, e = c.length; e--;) {
                var f = c[e];
                if (null != f.getAttribute(PKL_DiscoveryAttribute)) {
                    var g = "", g = f.id ? f.id : f.id = PKL_DefaultPlayerID + (0 == d ? "" : this.bC++);
                    __PKL.co.push(g);
                    !f.className && !f.style.cssText && (f = this.en(g));
                    var h = this.fA(f);
                    h.V = g;
                    h.file = __PKL.ai(h[this.bP]);
                    for (var g = f.childNodes, l = 0, m = g.length; m--;)g[m].className && "PKL_" == g[m].className.substr(0, 4) && (this.dF(g[m], h), l++);
                    0 == l && !this.by(f.className, this.ct) ? (h.cL = !0, b.push(h)) : (a.push(h), this.dF(f, h));
                    d++
                }
            }
            for (e = a.length; e--;)c = a[e], this.PLR[c.V] = new this.O(c);
            for (e = this.cn.length; e--;)this.cG(this.cn[e]);
            for (var R in this.PLR)this.PLR[R].aJ();
            for (e = b.length; e--;)this.bv(b[e]);
            this.aP();
            this.cg = !0;
            this.fJ();
            !1 == __PKL.cT() ? __PKL.bq = !0 : PKL_onload();
            __PKL_EVENT_RESIZE()
        }, cZ: function (a) {
            var b = null;
            try {
                b = a.rules || a.cssRules
            } catch (c) {
            }
            return b
        }, dH: function (a) {
            if (a = a || document.styleSheets) {
                try {
                    if (a.imports) {
                        var b = a.imports.length;
                        if (b)for (var c = 0; c < b; c++) {
                            var d = a.imports[c];
                            d && this.dH(d)
                        }
                    }
                } catch (e) {
                }
                if (a.length) {
                    b = a.length;
                    for (c = 0; c < b; c++)this.dH(a[c])
                } else if (d = this.cZ(a))if (b = d.length)for (c = 0; c < b; c++) {
                    var f = d[c];
                    f.styleSheet && this.dH(f.styleSheet)
                }
            }
            (a.type || a.rules || a.cssRules) && !a.disabled && this.aW.push(a);
            return!0
        }, gv: function () {
            var a = [];
            this.dH();
            for (var b = this.aW.length; b--;) {
                var c = !1;
                if (a = this.cZ(this.aW[b])) {
                    for (var d = a.length; d--;)if (a[d]) {
                        var e = a[d].selectorText;
                        if (e && e.match(".PKL_")) {
                            for (var c = e.split(","), f = c.length; f--;) {
                                ".PKL_wrapper" == c[f] && (__PKL.cj = !0);
                                var g = c[f].replace(".PKL_", "");
                                !this.by(g, this.aa) && (this.by("PKL_" + g, this.ct) && (!g.match(".") || !g.match(":")) && !g.match("#")) && this.aa.push(g)
                            }
                            ".PKL_controlsBkgd" == e && (a[d].style.width && a[d].style.width.toString().match(/%/)) && (__PKL.cb = !0);
                            c = !0
                        }
                    }
                    if (c)break
                }
            }
            return this.aa
        }, bb: function (a, b) {
            if (this.by(a.className, this.ct)) {
                var c = {id: this.ak + this.bC++, className: a.className, V: b.V};
                a.id = c.id;
                __PKL.ef.push(c.id);
                return c
            }
            return!1
        }, dF: function (a, b) {
            if (a.tagName && "div" == a.tagName.toLowerCase() && this.by(a.className, this.ct)) {
                a.id || (a.id = this.ak + this.bC++);
                var c = this.fA(a);
                c.id = a.id;
                c.className = a.className;
                c.V = b.V;
                this.cn.push(c);
                for (var c = a.childNodes, d = c.length; d--;)this.dF(c[d], b);
                return!0
            }
            return!1
        }, ax: function (a) {
            var b = a.touches.length, c = 1 < b ? a.touches[0].pageY : a.pageY;
            this.fe = 1 < b ? a.touches[0].pageX : a.pageX;
            this.eB = c;
            this.bE = 1 < b ? !0 : !1
        }, cG: function (a) {
            if (a.className) {
                var b = this.F(a.id), c = this.PLR[a.V], d = a.className.replace("PKL_", ""), e = this.bc, f = this.ar;
                c.ge(b);
                switch (d) {
                    case "play":
                        c.ff = b;
                        c.dc = b.id;
                        __PKL.K.ay ? (b[f] = function (a) {
                            __PKL.ax(a)
                        }, b[e] = function (a) {
                            __PKL.bE || c.bD()
                        }) : b[e] = function (a) {
                            c.bD()
                        };
                        break;
                    case "pause":
                        __PKL.K.ay ? (b[f] = function (a) {
                            __PKL.ax(a)
                        }, b[e] = function (b) {
                            __PKL.bE || c.aB(a)
                        }) : b[e] = function (b) {
                            c.aB(a)
                        };
                        break;
                    case "playpause":
                        c.aS = b;
                        c.bK = b.id;
                        __PKL.K.ay ? (b[f] = function (a) {
                            __PKL.ax(a)
                        }, b[e] = function (a) {
                            __PKL.bE || c.am()
                        }) : b[e] = function (a) {
                            c.am()
                        };
                        break;
                    case "screen_play":
                        c.bU = b;
                        c.af = b.id;
                        __PKL.K.ay ? (b[f] = function (a) {
                            __PKL.ax(a)
                        }, b[e] = function (a) {
                            __PKL.bE || (c.as(), b.className = 1 == c.bQ ? "PKL_screen_play pause" : "PKL_screen_play", c.am())
                        }) : (b[f] = function (a) {
                            b.className = 1 == c.bQ ? "PKL_screen_play" : "PKL_screen_play pause"
                        }, b[e] = function (a) {
                            c.as();
                            b.className = 1 == c.bQ ? "PKL_screen_play pause" : "PKL_screen_play";
                            c.am()
                        });
                        break;
                    case "rewind":
                        __PKL.K.ay ? (b[f] = function (a) {
                            __PKL.ax(a)
                        }, b[e] = function (b) {
                            __PKL.bE || 1 == c.bB && c.Rewind(a)
                        }) : b[e] = function (b) {
                            1 == c.bB && c.Rewind(a)
                        };
                        break;
                    case "next":
                        __PKL.K.ay ? (b[f] = function (a) {
                            __PKL.ax(a)
                        }, b[e] = function (a) {
                            __PKL.bE || c.Next()
                        }) : b[e] = function (a) {
                            c.Next()
                        };
                        break;
                    case "mute":
                        __PKL.K.ay ? (b[f] = function (a) {
                            __PKL.ax(a)
                        }, b[e] = function (b) {
                            __PKL.bE || c.eE(a)
                        }) : b[e] = function (b) {
                            c.eE(a)
                        };
                        break;
                    case "loop":
                        c.eT = b;
                        c.ez = b.id;
                        __PKL.K.ay ? (b[f] = function (a) {
                            __PKL.ax(a)
                        }, b[e] = function (b) {
                            __PKL.bE || c.Loop(a)
                        }) : b[e] = function (b) {
                            c.Loop(a)
                        };
                        break;
                    case "scrubBkgd":
                        c.ee = a;
                        c.ab = b.id;
                        break;
                    case "scrubHandle":
                        c.eQ = b.id;
                        break;
                    case "scrubBar":
                        c.ej = b.id;
                        break;
                    case "time":
                        c.bF = b.id;
                        break;
                    case "loading":
                        b.style.visibility = "hidden";
                        c.aI = b;
                        c.ca = b.id;
                        break;
                    case "thinker":
                        b.className = "PKL_thinker off";
                        c.aX = b;
                        c.dG = b.id;
                        break;
                    case "playlistScrollBkgd":
                        c.bJ = b.id;
                        break;
                    case "playlistScrollHandle":
                        c.cD = b.id;
                        break;
                    case "playlist":
                        c.bw = b.id;
                        break;
                    case "info":
                        c.bi = b.id;
                        break;
                    case "controlsBkgd":
                        c.dn = b.id;
                        c.bo = b;
                        break;
                    case "poster":
                        c.bS = b;
                        c.aj = b.id;
                        break;
                    case "fullscreen":
                        __PKL.K.ay ? (b[f] = function (a) {
                            __PKL.ax(a)
                        }, b[e] = function (a) {
                            __PKL.bE || c.eR()
                        }) : b[e] = function (a) {
                            c.eR()
                        }
                }
            }
        }, bv: function (a) {
            var b = [], c = !1;
            if (a.cL)var c = !0, d = this.F(a.V); else {
                a.V = a.id || PKL_DefaultPlayerID + this.bC++;
                d = this.H.createElement("div");
                d.setAttribute("id", a.V);
                a[this.bP] && d.setAttribute("data-" + this.bP, a[this.bP]);
                for (var e = "controls startuptext timeformat eN loop random autoplay image artist title album autoadvance".split(" "), f = e.length; f--;)a[e[f]] && d.setAttribute("data-" + e[f], a[e[f]]);
                a.classname && (d.className = a.classname);
                b.push(this.bb(d, a))
            }
            var g = this.aa;
            a.controls && (g = a.controls.split(","));
            e = [];
            for (f = g.length; f--;) {
                var h = this.bu(g[f]);
                "scrub" == h.substr(0, 5) && !this.by("scrub", e) ? e.push("scrub") : "playlistScroll" == h.substr(0, 14) && !this.by("playlistScroll", e) ? e.push("playlistScroll") : "info" == h.substr(0, 4) && !this.by("info", e) ? e.push("info") : "play" == h && this.by("playpause", g) || ("loading" == h || "scrub" == h.substr(0, 5) || "playlistScroll" == h.substr(0, 14) || "info" == h.substr(0, 4)) || e.push(h)
            }
            g = !1;
            if (this.by("controlsBkgd", e)) {
                var l = this.H.createElement("div");
                l.className = "PKL_controlsBkgd";
                b.push(this.bb(l, a));
                g = !0
            }
            for (var m = "playpause play pause rewind next mute loop infoBkgd info time controlsBkgd fullscreen".split(" "), f = e.length; f--;)switch (h = e[f], h) {
                case "controlsBkgd":
                    break;
                case "scrub":
                    var R = this.H.createElement("div");
                    R.className = "PKL_scrubBkgd";
                    g ? l.appendChild(R) : d.appendChild(R);
                    b.push(this.bb(R, a));
                    for (var h = ["scrubBar", "loading", "scrubHandle"], n = h.length; n--;) {
                        var q = h[n];
                        if (this.by(q, this.aa)) {
                            var p = this.H.createElement("div");
                            p.className = "PKL_" + q;
                            R.appendChild(p);
                            b.push(this.bb(p, a))
                        }
                    }
                    break;
                case "playlistScroll":
                    this.by("playlistScrollBkgd", this.aa) && (h = this.H.createElement("div"), h.className = "PKL_playlistScrollBkgd", d.appendChild(h), b.push(this.bb(h, a)), this.by("playlistScrollHandle", this.aa) && (R = this.H.createElement("div"), R.className = "PKL_playlistScrollHandle", h.appendChild(R), b.push(this.bb(R, a))));
                    break;
                case "info":
                    this.by("info", this.aa) && (R = this.H.createElement("div"), R.className = "PKL_info", g ? l.appendChild(R) : d.appendChild(R), b.push(this.bb(R, a)));
                    this.by("infoBkgd", this.aa) && (R = this.H.createElement("div"), R.className = "PKL_infoBkgd", g ? l.appendChild(R) : d.appendChild(R), b.push(this.bb(R, a)));
                    break;
                default:
                    this.by(h, m) ? (R = this.H.createElement("div"), R.className = "PKL_" + h, g ? l.appendChild(R) : d.appendChild(R)) : (R = this.H.createElement("div"), R.className = "PKL_" + h, d.appendChild(R)), b.push(this.bb(R, a))
            }
            g && d.appendChild(l);
            !c && __PKL.cj && (d.className = "PKL_wrapper");
            a.cL || (a.target ? (c = this.F(a.target)) ? c.appendChild(d) : this.H.body.appendChild(d) : this.H.body.appendChild(d));
            if (this.bh) {
                this.PLR[a.V] = new this.O(a);
                for (f = b.length; f--;)this.cG(b[f]);
                this.PLR[a.V].aJ()
            }
            this.eV++
        }, fN: function (a, b) {
            var c = this.F(a), d = null;
            c.currentStyle ? d = c.currentStyle[b] || this.H.defaultView.getComputedStyle(c, null).getPropertyValue(b) : window.getComputedStyle && (d = __PKL.H.defaultView.getComputedStyle(c, null).getPropertyValue(b));
            return d
        }, cQ: function (a, b, c) {
            a.attachEvent ? a.attachEvent("on" + b, c) : a.addEventListener && a.addEventListener(b, c, !1)
        }, eI: function (a) {
            a = this.H.body.appendChild(this.H.createElement("div"));
            this.bG = this.cU;
            a.setAttribute("id", this.bG);
            a.className = "PKL_preloader";
            this.aV = this.H.createElement("div");
            this.aV.setAttribute("id", this.dM);
            this.aV.style.cssText = "z-index:" + this.ds + ";width:1px;height:1px;top:0px;left:0px;position:absolute;";
            this.H.body.appendChild(this.aV);
            this.fi();
            this.K.G || (__PKL.cQ(this.T, "ended", __PKL_Listener_TrackDone), __PKL.cQ(this.T, "pause", __PKL_Listener_TrackStopped), __PKL.cQ(this.T, "play", __PKL_Listener_TrackStarted), __PKL.cQ(this.T, "loadstart", __PKL_Listener_TrackLaunched));
            return this.fv = !0
        }, dJ: function (a) {
            return a.changedTouches[0]
        }, bd: function (a) {
            var b = a.w, c = a.h, d = a.x, e = a.y;
            a = a.z;
            0 > String(b).indexOf("%") && (b = parseInt(b) + "px", c = parseInt(c) + "px");
            d = parseInt(d) + "px";
            e = parseInt(e) + "px";
            "audio" == this.dh(this.C.file)[0] && (d = this.K.G ? "1px" : "-50px", e = this.K.G ? "1px" : "-50px", c = b = "1px");
            var f = this.ep;
            a && (f = a);
            this.aV.style.cssText = "top:" + e + ";left:" + d + ";width:" + b + ";height:" + c + ";position:absolute;z-index:" + f + ";background-color:" + PKL_MediaBackgroundColor + ";"
        }, fi: function () {
            var a = "";
            if (this.K.G) {
                var b = this.eh() + "pickle.swf", c = "s=0&a=" + PKL_AspectRatio;
                this.K.bf ? (a += '\t<object id="' + this.ba + '" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%">\n', a += '\t\t<param name="movie" value="' + b + '" />\n') : a += '\t<object type="application/x-shockwave-flash" id="' + this.ba + '" data="' + b + '" width="100%" height="100%">\n';
                a += '\t\t<param name="allowScriptAccess" value="always" />\t\t<param name="quality" value="high" />\n';
                a += '\t\t<param name="scale" value="noscale" />\n';
                a += '\t\t<param name="salign" value="lt" />\n';
                a += '\t\t<param name="wmode" value="opaque" />\n';
                a += '\t\t<param name="bgcolor" value="' + PKL_MediaBackgroundColor + '" />\n';
                a += '\t\t<param name="swfversion" value="' + this.v + ',0,0,0" />\n';
                a += '\t\t<param name="flashvars" value="' + c + '" />\n';
                a += "\t</object>\n";
                this.aV.innerHTML = a;
                this.T = this.F(this.ba)
            } else this.T = this.H.createElement("video"), this.T.setAttribute("id", this.ba), this.T.setAttribute("webkit-playsinline", ""), this.T.style.cssText = "z-index:" + this.ds + ";top:0px;left:0px;width:100%;height:100%;", a = document.createElement("source"), a.id = this.ba + "_SRC1", a.src = "", b = document.createElement("source"), b.id = this.ba + "_SRC2", b.src = "", this.cl = a, this.av = b, this.T.appendChild(a), this.T.appendChild(b), this.aV.appendChild(this.T), this.bd({x: "0", y: "0", w: "1", h: "1"});
            return!0
        }, hs: function () {
            if (!this.aD)if (this.K.webkit && !1 === this.T.webkitDisplayingFullscreen)this.T.webkitEnterFullscreen(); else {
                this.aD = !0;
                this.bs = this.H.createElement("div");
                this.bs.id = this.an;
                this.bs.style.cssText = "display:block;background-color:" + PKL_MediaBackgroundColor + ";z-index:" + this.bm + ";position:absolute;top:0px;left:0px;width:100%;height:100%";
                this.H.body.appendChild(this.bs);
                var a = this.PLR[this.C.player];
                this.cc = a.aj ? this.bN(a.bS) : this.bN(a.bU);
                this.cv = this.C.player;
                this.C.player = this.an;
                this.bV = this.H.createElement("div");
                this.bV.className = "PKL_screen_play pause";
                this.bV[this.ar] = function (a) {
                    __PKL.bV.className = 1 == __PKL.PLR[__PKL.an].bQ ? "PKL_screen_play" : "PKL_screen_play pause"
                };
                this.bV[this.bc] = function (a) {
                    __PKL.PLR[__PKL.an].as();
                    __PKL.PLR[__PKL.an].am()
                };
                this.bV[this.au] = function (a) {
                    __PKL.PLR[__PKL.an].as()
                };
                this.H.body.appendChild(this.bV);
                for (var a = ["screen_play", "poster", "playlistScrollBkgd", "playlistScrollHandle", "playlist"], b = [], c = this.aa.length; c--;) {
                    var d = this.aa[c];
                    this.by(d, a) || b.push(d)
                }
                c = b.join(",");
                c = {V: this.an, cL: !0, timeformat: this.PLR[this.cv].ae, width: "100%", height: "100%", autoplay: !0, controls: c, target: this.an};
                c[this.bP] = this.C.file;
                this.bv(c);
                b = this.F(this.an).childNodes;
                this.aY = [];
                this.az = 0;
                for (c = b.length; c--;)if (d = b[c], d.tagName) {
                    var e = d.className.replace("PKL_", "");
                    0 < e.indexOf(" ") && (e = e.substr(0, e.indexOf(" ")));
                    "div" == d.tagName.toLowerCase() && !this.by(e, a) && (e = this.bN(d), d = {div: d, gq: e}, e.h > this.az && (this.az = e.h), this.aY.push(d))
                }
                this.dz()
            }
        }, dz: function (a) {
            a = this.eY();
            var b = a.h - this.az + "px", c = {w: "100%", h: b, x: a.x, y: a.y, z: this.bm + 1}, d = "display:block;background-color:" + PKL_MediaBackgroundColor + ";z-index:" + this.bm + ";position:absolute;top:" + a.y + "px;left:" + a.x + "px;width:100%;height:100%";
            this.bs.style.cssText = d;
            d = "position:absolute;left:" + a.x + "px;top:" + a.y + "px;z-index:" + (this.bm + 2) + ";width:100%;height:" + (parseInt(b) - 20) + "px";
            this.bV.style.cssText = d;
            b = a.x + a.w / 2 - parseInt(this.cc.w) / 2;
            for (d = this.aY.length; d--;) {
                var e = this.aY[d];
                e.div.style.top = a.h - this.az + "px";
                __PKL.cb || (e.div.style.left = b + e.gq.x + "px")
            }
            this.bd(c);
            this.PLR[this.C.player].cJ()
        }, dj: function () {
            this.aD && (this.aD = !1, this.C.player = this.cv, this.H.body.removeChild(this.bs), this.H.body.removeChild(this.bV), this.bd(this.PLR[this.C.player].aE.screen), this.PLR[this.C.player].cJ())
        }, en: function (a) {
            a = document.getElementById(a);
            var b = a.parentNode, c = a.cloneNode(!0);
            a.id = "__PKL_REMOVE_NODE";
            var d = document.createElement("div"), e = this.dN + this.eK++;
            d.id = e;
            __PKL.cq.push(e);
            __PKL.cj ? d.className = "PKL_wrapper" : d.style.cssText = this.dU;
            d.appendChild(c);
            b.insertBefore(d, a);
            b.removeChild(a);
            return c
        }, aP: function () {
            __PKL_INTERVAL && window.clearInterval(__PKL_INTERVAL);
            __PKL_INTERVAL = window.setInterval("__PKL.fc()", PKL_PlayerUpdateInterval)
        }, cW: function () {
            __PKL_INTERVAL && window.clearInterval(__PKL_INTERVAL)
        }, F: function (a) {
            return a ? this.H.getElementById(a) : null
        }, dC: function (a) {
            a || (a = window.event);
            a.pageX || a.pageY ? (this.bA.x = a.pageX, this.bA.y = a.pageY) : (this.bA.x = a.clientX + this.H.body.scrollLeft + this.H.documentElement.scrollLeft, this.bA.y = a.clientY + this.H.body.scrollTop + this.H.documentElement.scrollTop);
            0 > this.bA.x && (this.bA.x = 0);
            0 > this.bA.y && (this.bA.y = 0);
            return!1
        }, fc: function () {
            for (var a in this.PLR)this.PLR[a].fo()
        }, ea: function (a) {
            var b = {};
            a = a.attributes;
            for (var c = a.length, d = 0; d < c; d++)this.K.bf ? a[d].specified && (b[a[d].nodeName] = a[d].nodeValue.toString()) : b[a[d].nodeName] = a[d].value ? a[d].value.toString() : a[d].nodeValue.toString();
            return b
        }, fA: function (a) {
            var b = {};
            a = this.ea(a);
            for (var c in a)if (c.match(/data-/i)) {
                var d = this.bu(c).replace(/(data-)/i, "").toLowerCase(), e = this.bu(a[c]);
                b[d] = __PKL.ai(e)
            }
            return b
        }, dh: function (a) {
            var b = ["audio", "audio/mp3"];
            a && (0 > a.indexOf(".") && (a = "x." + a), a = this.bu(a).split(".").pop(), a = a.toLowerCase(), this.eS[a] && (b = this.eS[a]));
            return b
        }, ci: function (a) {
            a = a.split("/").pop().split(".");
            a.pop();
            return a.join(".")
        }, bN: function (a, b) {
            var c = 0, d = 0, e = 0, f = 0;
            if (a) {
                for (var e = a.offsetWidth, f = a.offsetHeight, g = this.K.ay; a && !isNaN(a.offsetLeft) && !isNaN(a.offsetTop);)g ? (c += (a.offsetLeft || 0) - (a.scrollLeft || 0), d += (a.offsetTop || 0) - (a.scrollTop || 0)) : (c += a.offsetLeft || 0, d += a.offsetTop || 0), a = a.offsetParent;
                g && (g = null != window.scrollY ? window.scrollY : window.pageYOffset, c += null != window.scrollX ? window.scrollX : window.pageXOffset, d += g)
            }
            return{x: c, y: d, w: e, h: f, xMax: c + e, yMax: d + f}
        }, fm: function () {
            var a = 0, b = 0;
            if ("number" == typeof window.pageYOffset)a = window.pageXOffset, b = window.pageYOffset; else if (this.H.body && (this.H.body.scrollLeft || this.H.body.scrollTop))a = this.H.body.scrollLeft, b = this.H.body.scrollTop; else if (this.H.aH && (this.H.aH.scrollLeft || this.H.aH.scrollTop))a = this.H.aH.scrollLeft, b = this.H.aH.scrollTop;
            return[a, b]
        }, fb: function (a) {
            a = this.F(a);
            var b;
            b = a.parentNode.style.overflow ? a.parentNode.style.overflow : "hidden";
            a.parentNode.style.overflow = "visible";
            var c = this.bN(a);
            a.parentNode.style.overflow = b;
            return c
        }, eY: function () {
            var a = this.fm(), b, c;
            "undefined" != typeof window.innerWidth ? (b = window.innerWidth, c = window.innerHeight) : "undefined" != typeof document.documentElement && "undefined" != typeof document.documentElement.clientWidth && 0 != document.documentElement.clientWidth ? (b = document.documentElement.clientWidth, c = document.documentElement.clientHeight) : (b = document.getElementsByTagName("body")[0].clientWidth, c = document.getElementsByTagName("body")[0].clientHeight);
            a = {x: a[0], y: a[1], w: b, h: c, xMax: 0, yMax: 0};
            a.xMax = a.x + a.w;
            a.yMax = a.y + a.h;
            return a
        }, fw: function (a, b) {
            var c = this.bN(this.F(a)), d = this.bN(this.F(b));
            if (5 < c.w && 5 < c.h && 5 < d.w && 5 < d.h) {
                c.x -= 5;
                c.y -= 5;
                c.xMax += 5;
                c.yMax += 5;
                var e = {}, f;
                for (f in c)if ("x" == f || "y" == f || "xMax" == f || "yMax" == f)e[f] = c[f] >= d[f] ? !0 : !1;
                return!e.x && !e.y && e.xMax && e.yMax ? !0 : !1
            }
            return!1
        }, by: function (a, b) {
            for (var c = b.length; c--;)if (a == b[c])return!0;
            return!1
        }, bu: function (a) {
            for (var b = 0; b < a.length; b++)if (-1 === " \n\r\t\f\x00\x0B\u00a0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000".indexOf(a.charAt(b))) {
                a = a.substring(b);
                break
            }
            for (b = a.length - 1; 0 <= b; b--)if (-1 === " \n\r\t\f\x00\x0B\u00a0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000".indexOf(a.charAt(b))) {
                a = a.substring(0, b + 1);
                break
            }
            return-1 === " \n\r\t\f\x00\x0B\u00a0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000".indexOf(a.charAt(0)) ? a : ""
        }, cP: function (a, b, c) {
            if (b && (b = this.F(b)))b.innerHTML = c ? b.innerHTML + ("<br>" + a) : a
        }, cS: function (a, b) {
            if (!this.ce) {
                var c = this.H.body.appendChild(this.H.createElement("div"));
                c.id = this.dV;
                c.style.cssText = "margin:10px;display:block;padding:15px;overflow:hidden;white-space:nowrap;border: 1px solid #999;filter:alpha(opacity=50);opacity:0.5;top:" + this.fk + "px;left:" + this.hy + "px;background-color:#FFC;z-index:" + (this.bm + 100) + ";height:" + this.ft + "px;width:" + this.fj + "px;overflow:auto;position:fixed;";
                this.ce = !0
            }
            this.cP(a, this.dV, b)
        }, fq: function (a, b) {
            var c = "", d;
            for (d in a)c += d + " : " + a[d] + "<br>";
            this.cS(c, b)
        }, cE: function (a) {
            var b = new Date(1E3 * a), c = b.getUTCHours(), d = b.getUTCMinutes(), b = b.getUTCSeconds(), e = "", f = "", g = "";
            0 < c ? (e = c.toString(), f = 10 > d ? ":0" + d : ":" + d.toString()) : (e = "", f = d.toString());
            g = 10 > b ? ":0" + b : ":" + b.toString();
            c = e + f + g;
            if ("0:00" == c || "" == c || null == a)c = "00:00";
            return c
        }, SWFisReady: function (a) {
            this.ag = !0;
            this.aA && (this.PLR[this.aA].bD(), this.aA = null);
            this.bq && (this.bq = null, PKL_onload())
        }, Play: function () {
            this.K.G ? this.T.js_pickle_play() : this.T.play()
        }, aB: function () {
            this.K.G ? this.T.js_pickle_pause() : this.T.pause()
        }, eh: function () {
            for (var a = this.H.getElementsByTagName("script"), b = this.el, c = a.length; c--;) {
                var d = a[c].getAttribute("src");
                if (d && -1 < d.indexOf(b)) {
                    b = d;
                    break
                }
            }
            a = b.split("/");
            a.pop();
            b = "";
            0 < a.length && (b = "/");
            return b = a.join("/").toString() + b
        }, eu: function (a) {
            if (0 < a.indexOf(":/") || "/" == a.substr(0, 1))return a;
            var b = this.H.location.href.split("/");
            b.pop();
            a = a.split("../");
            for (var c = a.pop(), d = 0; d < a.length; d++)b.pop();
            return b.join("/") + "/" + c
        }, be: function (a, b) {
            if (a) {
                var c = this.eu(a).split("/");
                0 < c.length && c.pop();
                c = c.join("/");
                c.replace("://", "___p___");
                c.replace("//", "/");
                c.replace("___p___", "://");
                !0 == b && "/" != c.substr(-1) && "" != c && (c += "/")
            } else c = a;
            return c
        }, fr: function (a, b) {
            this.cW();
            this.C.file = b;
            this.C.player = a;
            var c = this.eu(__PKL.ai(b)), d;
            for (d in this.PLR)this.PLR[d].ei(), this.PLR[d].bL();
            this.PLR[a].dg();
            this.bd(this.PLR[a].aE.screen);
            this.K.G ? this.ag && (this.aP(), this.T.js_pickle_load(c)) : (__PKL.dh(c), this.cl.setAttribute("src", c), d = this.be(c, !0), d += this.ci(c) + "." + PKL_FallbackExtension, this.av.setAttribute("src", d), this.T.load(), this.T.play());
            this.aP()
        }, ed: function (a, b) {
            this.cW();
            this.C.file = b;
            this.C.player = a;
            var c = this.eu(__PKL.ai(b)), d;
            for (d in this.PLR)this.PLR[d].ei(), this.PLR[d].bL();
            this.PLR[a].dg();
            this.bd(this.PLR[a].aE.screen);
            this.K.G ? this.ag ? (this.aP(), this.T.js_pickle_preload(c)) : this.bq = !0 : (this.T.setAttribute("src", c), this.T.load());
            this.aP()
        }, dS: function (a) {
            this.K.G ? this.ag && this.T.js_pickle_setMuteState(a) : this.T.muted = "on" == a ? !0 : !1
        }, aQ: function (a) {
            a > this.fI && (a = this.fI);
            a < this.bn && (a = this.bn);
            this.K.G ? this.ag && this.T.js_pickle_setPlayheadPercent(a) : this.T.duration && (this.T.currentTime = this.T.duration * a)
        }, bW: function () {
            var a = {init: 0, status: 0, percent: 0, duration: 0, duration_nice: "00:00", remaining: 0, remaining_nice: "00:00", current: 0, current_nice: "00:00", buffering: !1};
            if (this.K.G)this.ag && (a = this.T.js_pickle_getPlayerState()); else {
                0 < this.T.readyState && (a.init = 1, this.T.paused || (a.status = 1), a.percent = this.T.currentTime / this.T.duration, a.duration = this.T.duration, a.duration_nice = this.cE(this.T.duration), a.remaining = this.T.duration - this.T.currentTime, a.remaining_nice = this.cE(a.remaining), a.current = this.T.currentTime, a.current_nice = this.cE(this.T.currentTime));
                var b = this.T.readyState;
                a.bufferState = b;
                4 != b && (a.buffering = !0)
            }
            return a
        }, dI: function (a) {
            this.K.G && this.ag && this.T.js_pickle_setScrubState(a)
        }, cr: function () {
            var a = {loaded: 0, percent: 0, total: 1, status: 0};
            this.K.G ? this.ag && (a = this.T.js_pickle_getLoadState()) : (0 < this.T.readyState && (a.loaded = this.T.buffered.end(0), a.percent = a.loaded / this.T.duration, a.total = this.T.duration), 1E-4 < a.percent && (a.status = 1));
            return a
        }, fE: function () {
            this.K.G && this.ag && this.T.js_pickle_rewindPlayerState()
        }, Call: function (a, b) {
            "string" == typeof a ? this.cS(a, b) : this.fq(a, b)
        }, eU: function () {
            var a = {};
            if (this.C.player) {
                for (var b in this.PLR[this.C.player].L)a[b] = this.PLR[this.C.player].L[b];
                a.player = this.C.player;
                a.playstate = __PKL.bW();
                a.loadstate = __PKL.cr()
            } else a.player = "No Player";
            return a
        }, gN: function (a) {
            PKL_EventsEnabled && this.C.player && __PKL.PLR[this.C.player] && PKL_HandleTrackStarted(__PKL.PLR[this.C.player].aq())
        }, ek: function (a) {
            PKL_EventsEnabled && this.C.player && __PKL.PLR[this.C.player] && PKL_HandleTrackLaunched(__PKL.PLR[this.C.player].aq())
        }, fB: function (a) {
            PKL_EventsEnabled && __PKL.PLR[this.C.player] && PKL_HandleTrackStarted(__PKL.PLR[this.C.player].aq())
        }, ec: function (a) {
            PKL_EventsEnabled && __PKL.PLR[this.C.player] && PKL_HandleTrackStopped(__PKL.PLR[this.C.player].aq())
        }, bX: function (a) {
            this.PLR[this.C.player].bX()
        }, aJ: function () {
            if (!1 === this.bh) {
                __PKL.cQ(window, "resize", __PKL_EVENT_RESIZE);
                __PKL.cQ(window, "scroll", __PKL_EVENT_SCROLL);
                __PKL.cQ(window, "keyup", __PKL_EXIT_FULLSCREEN);
                window.onbeforeunload && (window.onbeforeunload = __PKL_GOODBYE);
                var a = navigator, b = a.userAgent.toLowerCase(), c = function (a) {
                    a = a.toLowerCase();
                    a = /(chrome)[ \/]([\w.]+)/.exec(a) || /(webkit)[ \/]([\w.]+)/.exec(a) || /(opera)(?:.*version|)[ \/]([\w.]+)/.exec(a) || /(msie) ([\w.]+)/.exec(a) || 0 > a.indexOf("compatible") && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(a) || [];
                    return{browser: a[1] || "", version: a[2] || "0"}
                }(b);
                this.K.version = parseFloat(c.version);
                var c = c.browser, d = !1;
                if ("chrome" == c || "webkit" == c)d = !0;
                this.K.webkit = d;
                d = a.platform.toLowerCase();
                this.K.platform = d;
                this.K.raw = b;
                this.K.bM = /iphone/.test(d) || /ipod/.test(d) || /ipad/.test(d);
                this.K.mac = d ? /mac/.test(d) : /mac/.test(c);
                this.K.win = this.K.windows = d ? /win/.test(d) : /win/.test(c);
                this.K.bf = /msie/.test(c) && !/opera/.test(c);
                this.K.chrome = /chrome/.test(c) || /chromium/.test(c);
                this.K.moz = /mozilla/.test(c);
                this.K.safari = /webkit/.test(c);
                this.K.android = /android/.test(c);
                this.K.blackberry = /blackberry/.test(c);
                this.K.opera = /opera/.test(b) || /opr/.test(b);
                b = 0;
                c = document.createElement("video");
                d = document.createElement("audio");
                try {
                    c.canPlayType && c.canPlayType('video/mp4; codecs="avc1.42E01E"').replace(/^no$/, "") && (c.canPlayType('video/mp4; codecs="avc1.42E01E, mp4a.40.2"').replace(/^no$/, "") && c.canPlayType('video/mp4; codecs="mp4v.20.8"').replace(/^no$/, "")) && d.canPlayType("audio/mpeg;").replace(/^no$/, "") && (b = 1)
                } catch (e) {
                }
                d = c = null;
                if (PKL_UseHTML5only || 1 == b)this.K.G = !1; else {
                    b = null;
                    c = 0;
                    if ("undefined" != typeof a.plugins && "object" == typeof a.plugins["Shockwave Flash"]) {
                        if ((b = a.plugins["Shockwave Flash"].description) && !("undefined" != typeof a.mimeTypes && a.mimeTypes["application/x-shockwave-flash"] && !a.mimeTypes["application/x-shockwave-flash"].enabledPlugin))b = b.replace(/^.*\s+(\S+\s+\S+$)/, "$1"), c = parseInt(b.replace(/^(.*)\..*$/, "$1"), 10)
                    } else if ("undefined" != typeof window.ActiveXObject)try {
                        var f = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
                        if (f && (b = f.GetVariable("$version")))b = b.split(" ")[1].split(","), c = parseInt(b[0], 10)
                    } catch (g) {
                    }
                    this.K.G = c >= __PKL.v ? !0 : !1;
                    __PKL.ap = c
                }
                this.K.ay = !1;
                a = this.H.body.appendChild(this.H.createElement("div"));
                a.id = "PKL_TCH_ID";
                a.setAttribute("ontouchmove", "return;");
                "function" == typeof a.ontouchmove && (this.K.ay = !0, this.ar = "ontouchstart", this.bc = "ontouchend", this.au = "ontouchmove", document[this.au] = function (a) {
                    __PKL.bE = !0
                });
                a.parentNode.removeChild(a);
                this.dW()
            }
        }, O: function (a) {
            this.fu = !1;
            this.V = a.V;
            this.L = {image: a.image, artist: a.artist, title: a.title, album: a.album};
            var b = a[__PKL.bP] || "", c = b.substr(b.length - 3, b.length).toLowerCase();
            "xml" == c || "txt" == c || "php" == c || "asp" == c ? (this.L.file = "", this.er = b) : this.L.file = b;
            this.autoplay = "true" == a.autoplay || !0 === a.autoplay ? !0 : !1;
            this.ae = a.timeformat ? a.timeformat : PKL_TimeFormat;
            this.fL = a.startuptext ? a.startuptext : PKL_StartupText;
            this.ev = a.autoadvance ? "true" == a.autoadvance || !0 === a.autoadvance ? !0 : !1 : PKL_AutoAdvance;
            this.fK = a.loop ? "true" == a.loop || !0 === a.loop ? !0 : !1 : PKL_loop;
            this.dY = "true" == a.random || !0 === a.random ? !0 : !1;
            this.aO = [];
            this.aF = (a.eN ? a.eN : PKL_InfoDisplayFormat).split("");
            this.aE = {};
            this.aE = a;
            this.aE.screen = {x: "0", y: "0", w: "1", h: "1"};
            this.cz = __PKL.F(this.V);
            a = __PKL.bN(this.cz);
            this.aE.player = {x: a.x, y: a.y, w: 0, h: 0};
            this.J = {};
            this.aw = {};
            this.bQ = this.bB = 0;
            this.ck = "0";
            this.de = this.bY = this.aR = 0;
            this.aU = !1;
            this.bw = this.Playlist = this.ej = this.eQ = this.ab = this.ee = this.bH = null;
            this.ac = -1;
            this.cD = this.bJ = this.aL = null;
            this.di = !1;
            this.aS = this.bK = this.bU = this.af = this.ff = this.dc = this.aS = this.bK = null;
            this.bO = 0;
            this.aX = this.dG = this.bI = this.bF = this.dB = this.bo = this.dn = null;
            this.aC = 0;
            this.aI = this.ca = this.bS = this.aj = null;
            this.bx = 0;
            this.ah = !1;
            this.bZ = 0;
            this.dR = 1;
            this.ew = PKL_FadeDelaySpeed;
            this.cu = 1;
            this.fa = PKL_FadeSpeed;
            this.da = !1;
            this.dE = this.ey = this.cO = this.bi = null;
            this.cB = this.dp = 0;
            this.eF = 1;
            this.cX = 0
        }};
        __PKL.O.prototype.ge = function (a) {
            var b = __PKL.bN(a);
            a = this.aE.player;
            var c = b.xMax - b.x, b = b.yMax - b.y;
            this.aE.player.w = c > a.w ? c : a.w;
            this.aE.player.h = b > a.h ? b : a.h
        };
        __PKL.O.prototype.eZ = function () {
            1 == this.de && (__PKL.Play(), this.de = 0);
            this.bY = 0
        };
        __PKL.O.prototype.fC = function () {
            if (1 == this.bB) {
                1 == this.aR && 0 == this.bY && (this.de = this.J.status, __PKL.aB(), this.bY = 1);
                this.J = __PKL.bW();
                if (1 == this.J.status || 1 == this.aR) {
                    this.bQ = 1;
                    0 == this.bO && (this.bO = 1, this.af && (this.bU.className = "PKL_screen_play pause"), this.bK && (this.aS.className = "PKL_play pause"));
                    this.ab && 0 == this.bY && this.bH.eC(this.J.percent);
                    if (this.bF) {
                        for (var a = "", b = 0; b < this.bI.length; b++)"1" == this.bI[b] ? this.J.current_nice && (a += this.J.current_nice) : "2" == this.bI[b] ? this.J.remaining_nice && (a += this.J.remaining_nice) : "3" == this.bI[b] ? this.J.duration_nice && (a += this.J.duration_nice) : a += this.bI[b];
                        __PKL.cP(a, this.bF)
                    }
                    this.dG && (this.J.buffering || 1 == this.bQ && 1 > this.J.current ? 0 == this.aC && (this.aX.className = "PKL_thinker", this.aC = 1) : 1 == this.aC && (this.aX.className = "PKL_thinker off", this.aC = 0))
                } else this.bQ = 0, 1 == this.bO && (this.bO = 0, this.af && (this.bU.className = "PKL_screen_play"), this.bK && (this.aS.className = "PKL_play"));
                this.aw = __PKL.cr();
                this.ca && 1 == this.J.init && 0 == this.bx && (1 == this.aw.status ? 0 < this.aw.percent && (a = this.aw.percent || 1, 1 < a ? a = 1 : 0 > a && (a = 0), this.aI.style.cssText = "visibility:visible;width:" + (100 - 100 * a) + "%;") : 0 > this.aw.status && 0.8 < this.aw.percent ? (this.aI.style.cssText = "visibility:hidden;", this.bx = 1) : 0 > this.aw.status && (0 > this.aw.total && 0.1 > this.aw.percent) && (this.aI.style.cssText = "visibility:visible;width:95%;"));
                this.fd()
            }
        };
        __PKL.O.prototype.fd = function () {
            __PKL.C.file == this.L.file && (0.9 < this.aw.percent && 1 > this.aR && 1 < this.J.current && this.J.current >= this.J.duration) && this.bX()
        };
        __PKL.O.prototype.as = function () {
            this.bZ = 1;
            this.eD()
        };
        __PKL.O.prototype.fD = function () {
            if (1 == this.bZ && (this.dR++, this.dR > this.ew)) {
                this.cu++;
                var a = 1 - this.cu / this.fa;
                0 >= a && (this.bZ = 0, this.cu = this.dR = 1, a = 0);
                __PKL.aD && this.V == __PKL.an ? (__PKL.bV.style.filter = "alpha(opacity=" + 100 * a + ")", __PKL.bV.style.opacity = a) : this.af && (this.bU.style.filter = "alpha(opacity=" + 100 * a + ")", this.bU.style.opacity = a);
                this.dB && 1 == this.bQ && (this.bo.style.filter = "alpha(opacity=" + 100 * a + ")", this.bo.style.opacity = a)
            }
        };
        __PKL.O.prototype.eD = function () {
            this.cu = this.dR = 1;
            this.af && (this.bU.style.filter = "alpha(opacity=100)", this.bU.style.opacity = 1);
            this.dB && (this.bo.style.filter = "alpha(opacity=100)", this.bo.style.opacity = 1)
        };
        __PKL.O.prototype.dg = function () {
            this.bB = 1;
            this.aj && ("video" == __PKL.dh(this.L.file)[0] ? this.bS.style.visibility = "hidden" : this.bS.style.visibility = "visible");
            __PKL_EVENT_RESIZE()
        };
        __PKL.O.prototype.bL = function () {
            1 != this.aR && (__PKL.aD && __PKL.dj(), this.aB(), __PKL.aQ(__PKL.bn), this.bQ = this.bB = 0, this.bK && 1 == this.bO && (this.bO = 0, this.aS.className = "PKL_play"), this.aj && (this.bS.style.visibility = "visible"), this.af && (this.bU.className = "PKL_screen_play"), this.dG && (this.aX.className = "PKL_thinker off"), this.ab && this.bH.Rewind(), this.ca && (this.aI.style.cssText = "visibility:hidden;"))
        };
        __PKL.O.prototype.ei = function () {
            this.bx = 0;
            __PKL.aQ(__PKL.bn);
            this.ab && this.bH.Rewind();
            this.bF && __PKL.cP(this.ae.replace(/[123]/g, "00:00"), this.bF);
            __PKL.bd({x: 1, y: 1, w: 1, h: 1});
            this.J = {};
            this.eo = {}
        };
        __PKL.O.prototype.aq = function () {
            var a = {playerID: this.V, onoff: this.bB, playing: this.bQ, loading: this.bx}, b;
            for (b in this.L)a["td_" + b] = this.L[b];
            for (b in this.J)a["ps_" + b] = this.J[b];
            for (b in this.eo)a["ls_" + b] = this.eo[b];
            return a
        };
        __PKL.O.prototype.bD = function () {
            this.L.file ? __PKL.C.file == this.L.file ? this.Play(this.L) : this.cf(this.L) : this.Playlist && this.db()
        };
        __PKL.O.prototype.am = function () {
            1 == this.bQ ? this.aB() : this.bD()
        };
        __PKL.O.prototype.Play = function (a) {
            this.bQ = 1;
            this.dg();
            __PKL.Play()
        };
        __PKL.O.prototype.cf = function (a) {
            this.bx = 0;
            this.bQ = 1;
            this.dg();
            for (var b in a)this.L[b] = a[b];
            this.L.file = a.file;
            this.L.title = a.title;
            this.L.artist = a.artist;
            this.L.image = a.image;
            this.af && (this.bU.className = "PKL_screen_play pause");
            this.bK && (this.aS.className = "PKL_play pause");
            this.bi && this.bg(this.L);
            this.dq(this.L.image);
            __PKL.fr(this.V, this.L.file, this.L.image);
            this.as()
        };
        __PKL.O.prototype.fs = function (a) {
            this.bQ = this.bx = 0;
            this.L.file = a.file;
            this.L.title = a.title;
            this.L.artist = a.artist;
            this.L.image = a.image;
            this.af && (this.bU.className = "PKL_screen_play play");
            this.bK && (this.aS.className = "PKL_play play");
            this.bi && this.bg(this.L);
            this.dq(this.L.image);
            __PKL.ed(this.V, this.L.file, this.L.image);
            this.aB();
            this.as()
        };
        __PKL.O.prototype.dq = function (a) {
            this.aj && a && (this.L.image = a, this.bS.style.backgroundImage = "url(" + a + ")")
        };
        __PKL.O.prototype.aB = function () {
            1 == this.bB && (this.bQ = 0, this.dG && (this.aX.className = "PKL_thinker off", this.aC = 0), __PKL.aB())
        };
        __PKL.O.prototype.gL = function () {
        };
        __PKL.O.prototype.Rewind = function (a) {
            if (this.Playlist) {
                a = !1;
                if (this.J.current_nice) {
                    var b = this.J.current_nice.replace(/:/g, "");
                    1 <= parseInt(b) && (a = !0)
                }
                a || this.eA()
            }
            __PKL.aQ(__PKL.bn);
            this.ab && this.bH.Rewind()
        };
        __PKL.O.prototype.Next = function () {
            this.db()
        };
        __PKL.O.prototype.eE = function (a) {
            1 == this.bB && (a = __PKL.F(a.id), "1" == this.ck ? (a.className = "PKL_mute", __PKL.dS("off"), this.ck = "0") : (a.className = "PKL_mute on", __PKL.dS("on"), this.ck = "1"))
        };
        __PKL.O.prototype.Loop = function (a) {
            a = __PKL.F(a.id);
            this.aU ? (a.className = "PKL_loop", this.aU = !1) : (a.className = "PKL_loop on", this.aU = !0)
        };
        __PKL.O.prototype.aQ = function (a) {
            1 <= a && (a = 0.99);
            __PKL.aQ(a)
        };
        __PKL.O.prototype.bX = function () {
            this.Playlist ? this.db() : !0 === this.aU ? (this.Rewind(), this.Play()) : this.fh()
        };
        __PKL.O.prototype.fh = function () {
            this.bL();
            __PKL.fE();
            this.bL();
            PKL_EventsEnabled && PKL_HandleTrackDone(__PKL.eU())
        };
        __PKL.O.prototype.fF = function (a, b) {
            a && (this.L.title = a);
            b && (this.L.artist = b);
            this.bg(this.L)
        };
        __PKL.O.prototype.bg = function (a) {
            var b = "", c = "", d = "";
            "object" == typeof a ? (a.title ? b = a.title : this.L.file && (b = __PKL.ci(this.L.file).replace(/_/g, " ")), a.artist && (c = a.artist)) : c = b = a;
            b = __PKL.bu(b);
            c = __PKL.bu(c);
            for (a = 0; a < this.aF.length; a++)d = "1" == this.aF[a] ? d + b : "2" == this.aF[a] ? d + c : d + this.aF[a];
            1 > __PKL.bu(d).length && (d = this.fL);
            d += "&nbsp;&nbsp;&nbsp;";
            b = " " + ('<div id="' + this.cO + '" style="display:block;white-space:nowrap;position:absolute;">');
            b = b + (d + d) + "</div>";
            __PKL.cP(b, this.bi);
            this.ey = __PKL.fb(this.cO).w / 2;
            this.dE = __PKL.F(this.cO);
            this.dE.style.left = "0px"
        };
        __PKL.O.prototype.eW = function () {
            if (!__PKL.K.bM && __PKL.C.player == this.V) {
                var a = parseInt(this.dE.style.left), a = a - PKL_InfoDisplaySpeed;
                a < -this.ey && (a = "0");
                this.dE.style.left = a + "px"
            }
        };
        __PKL.O.prototype.cJ = function () {
            if (!__PKL.aD) {
                var a = this.fH();
                __PKL.C.player == this.V && __PKL.bd(a);
                this.Playlist && this.bJ && this.Playlist.aL && this.Playlist.aL.cp()
            }
            this.ab && this.bH && this.bH.cp()
        };
        __PKL.O.prototype.aJ = function () {
            if (!this.fu) {
                this.fu = !0;
                this.bi && (this.da = !0, this.cO = __PKL.ak + __PKL.bC++, this.bg(this.fL));
                this.ab && (this.bH = new __PKL.bz, this.bH.aJ(this.ab, this.eQ, this.ej, "scrub", this.V));
                this.bF && (this.ae || (this.ae = PKL_TimeFormat), this.bI = this.ae.split(""), __PKL.F(this.bF).innerHTML = this.ae.replace(/[123]/g, "00:00"));
                if (__PKL.aD)this.af = "FS", this.bU = __PKL.bV, this.ah = !0; else if (this.er || this.bw)this.Playlist = new __PKL.Playlist(this.V, this.er, this.bw, this.bJ, this.cD);
                if (this.af || this.aj)this.ah = !0, this.dq(this.L.image);
                this.dn && __PKL.fw(this.af, this.dn) && (this.dB = this.dn, this.ah = !0);
                if (this.ah) {
                    var a = this.V;
                    this.bU ? this.bU[__PKL.au] = function (b) {
                        __PKL.PLR[a].as()
                    } : this.bS[__PKL.au] = function (b) {
                        __PKL.PLR[a].as()
                    }
                }
                if (!__PKL.aD && __PKL.bG) {
                    var b;
                    this.bK ? b = this.bK : this.dc ? b = this.dc : this.af && (b = this.af);
                    if (b) {
                        var c = "background-image";
                        __PKL.K.bf && (c = "backgroundImage");
                        if (b = __PKL.fN(b, c)) {
                            var d = b.match(/url\("?'?(.*?)'?"?\)/i);
                            d && 1 < d.length && (b = __PKL.bu(unescape(d[1])));
                            d = b.split("/");
                            d.pop();
                            var e = d.join("/");
                            1 < d.length && (e += "/");
                            b = unescape(__PKL.fN(__PKL.bG, c).replace(e, ""));
                            (d = b.match(/url\("?'?(.*?)'?"?\)/i)) && 1 < d.length && (b = __PKL.bu(unescape(d[1])));
                            for (var d = b.split("#"), c = document.getElementById(__PKL.bG), f = d.length; f--;)if (d[f] && (b = d[f].replace("background-image:", ""), "none" != b)) {
                                var g = new Image(1, 1);
                                g.src = e + b;
                                c.appendChild(g)
                            }
                        }
                    }
                }
                !this.cz.className && !this.cz.style.cssText && (this.cz.style.cssText = __PKL.dU + ";width:" + this.aE.player.w + "px;height:" + this.aE.player.h + "px;", this.cJ());
                this.autoplay && (__PKL.aD ? this.Play() : __PKL.K.G ? __PKL.ag ? this.bD() : __PKL.aA = this.V : (__PKL.aA = this.V, this.bD()));
                this.fK && (this.aU = !0, this.ez && (this.eT.className = "PKL_loop on"))
            }
            return!0
        };
        __PKL.O.prototype.fH = function () {
            if (this.af || this.aj)this.aE.screen = this.aj ? __PKL.bN(this.bS) : __PKL.bN(this.bU);
            return this.aE.screen
        };
        __PKL.O.prototype.fo = function () {
            this.dp++;
            this.dp >= PKL_EngineSpeed && (this.fC(), this.dp = 0);
            this.ah && 1 == this.bZ && (this.cB++, this.cB >= this.eF && this.fD(), this.cB = 0);
            this.da && (this.cX++, this.cX >= PKL_ScrollUpdateSpeed && (this.eW(), this.cX = 0))
        };
        __PKL.O.prototype.LoadPlaylistItem = function (a) {
            this.ac = a;
            a = this.Playlist.ao.length;
            this.ac > a - 1 && (this.ac = 0);
            0 > this.ac && (this.ac = a - 1);
            if (this.Playlist.aM)for (; a--;)__PKL.F(this.Playlist.ao[a].objid).className = a == this.ac ? "PKL_playlistItemBkgd playing" : a % 2 ? "PKL_playlistItemBkgd alt" : "PKL_playlistItemBkgd";
            a = this.Playlist.ao[this.ac];
            !a && this.autoplay ? this.di = !0 : a && (this.Playlist.hI(a.objid), this.cf(a))
        };
        __PKL.O.prototype.db = function () {
            if (this.Playlist)if (this.aU)this.LoadPlaylistItem(this.ac); else if (this.ev) {
                this.ac++;
                if (!0 == this.dY) {
                    if (1 > this.aO.length) {
                        this.aO = [];
                        for (var a = 0; a < this.Playlist.ao.length; a++)this.aO.push(a);
                        this.aO = __PKL.eO(this.aO)
                    }
                    this.ac = this.aO.shift()
                }
                this.LoadPlaylistItem(this.ac)
            } else this.fh()
        };
        __PKL.O.prototype.eA = function () {
            this.ac--;
            this.LoadPlaylistItem(this.ac)
        };
        __PKL.O.prototype.eR = function () {
            __PKL.aD ? __PKL.dj() : (this.bD(), __PKL.hs())
        };
        __PKL.fg = function (a, b) {
            var c = !1;
            __PKL.PLR[b].aG = null;
            if (window.XMLHttpRequest)__PKL.PLR[b].aG = new XMLHttpRequest; else if (window.ActiveXObject)try {
                __PKL.PLR[b].aG = new ActiveXObject("Microsoft.XMLHTTP")
            } catch (d) {
                try {
                    __PKL.PLR[b].aG = new ActiveXObject("Msxml2.XMLHTTP")
                } catch (e) {
                    __PKL.PLR[b].aG = !1
                }
            }
            if (__PKL.PLR[b].aG) {
                __PKL.PLR[b].aG.overrideMimeType && __PKL.PLR[b].aG.overrideMimeType("text/plain");
                try {
                    __PKL.PLR[b].aG.onreadystatechange = function () {
                        4 == __PKL.PLR[b].aG.readyState && !c && (c = !0, __PKL.gf(b, __PKL.PLR[b].aG.responseText))
                    }, __PKL.PLR[b].aG.open("GET", a, !0), __PKL.PLR[b].aG.send("")
                } catch (f) {
                    __PKL.cS("Unable to load external playlist. <br> Check the URL of the playlist file. <br> NOTE: External playlists may not work on local file systems.")
                }
            }
        };
        __PKL.gf = function (a, b) {
            __PKL.PLR[a].Playlist.fM(b)
        };
        __PKL.es = function (a) {
            var b = null;
            return b = void 0 == a.xml ? (new XMLSerializer).serializeToString(a) : a.xml
        };
        __PKL.gI = function (a, b) {
            return Math.round(__PKL.eG(a, b))
        };
        __PKL.eG = function (a, b) {
            return a + Math.random() * (b - a)
        };
        __PKL.eO = function (a) {
            if (a) {
                for (var b = a.length, c, d; b;)d = Math.floor(Math.random() * b--), c = a[b], a[b] = a[d], a[d] = c;
                return a
            }
            return[]
        };
        __PKL.Playlist = function (a, b, c, d, e) {
            this.V = a;
            c && (this.aM = c, this.cA = __PKL.ak + __PKL.bC++, __PKL.F(this.aM).innerHTML = '<div id="' + this.cA + '" style="position:absolute;display:block;left:0px;top:0px;width:100%"></div>', this.aT = __PKL.F(this.cA), this.aK = {win: {}, data: {}}, d && (this.dQ = d, this.eP = e, a = __PKL.F(this.dQ), a = __PKL.bN(a), this.bp = "v", a.w > a.h && (this.bp = "h")));
            this.ao = [];
            b ? this.load(b, !1) : c && this.eb()
        };
        __PKL.Playlist.prototype.load = function (a, b) {
            b || (this.ao = []);
            this.fZ = new __PKL.fg(a, this.V)
        };
        __PKL.Playlist.prototype.fM = function (a) {
            if (-1 < a.indexOf("<playlist")) {
                window.DOMParser ? this.xmlDoc = (new DOMParser).parseFromString(a, "text/xml") : (this.xmlDoc = new ActiveXObject("Microsoft.XMLDOM"), this.xmlDoc.async = "false", this.xmlDoc.loadXML(a));
                var b = this.xmlDoc.getElementsByTagName("item");
                this.ao || (this.ao = []);
                for (a = 0; a < b.length; a++) {
                    for (var c = {render: {}}, d = b[a].firstChild; null != d; d = d.nextSibling)if (1 == d.nodeType) {
                        var e = d.nodeName;
                        "filename" == e && (e = "file");
                        c.objid = __PKL.ak + __PKL.bC++;
                        if (d.firstChild) {
                            for (var f = "", g = d.firstChild; null != g; g = g.nextSibling)f += __PKL.es(g);
                            g = __PKL.ea(d);
                            g.render && (c.render[e] = g.render);
                            c[e] = f
                        }
                    }
                    this.ao.push(c)
                }
            } else {
                b = String(a).split("\n");
                for (a = 0; a < b.length; a++)c = __PKL.ai(__PKL.bu(b[a])), "" != c && (c = {file: c, title: __PKL.ci(c).replace(/_/g, " "), objid: __PKL.ak + __PKL.bC++}, this.ao.push(c))
            }
            this.aM && this.eb();
            __PKL.PLR[this.V].di && (__PKL.PLR[this.V].LoadPlaylistItem(0), __PKL.PLR[this.V].di = !1)
        };
        __PKL.Playlist.prototype.hF = function () {
            var a = __PKL.bN(__PKL.F(this.dQ));
            this.bp = a.w > a.h ? "h" : "v";
            this.aL || (this.aL = new __PKL.bz);
            this.aL.aJ(this.dQ, this.eP, "", "playlist", this.V)
        };
        __PKL.Playlist.prototype.hI = function (a) {
            var b = __PKL.bN(__PKL.F(a));
            __PKL.fw(this.aM, a) || (this.dw(), a = "v" == this.bp ? (b.y - this.aK.data.y) / (this.aK.data.h - b.h) : (b.x - this.aK.data.x) / (this.aK.data.w - b.w), 0 <= a && 1 >= a && this.aL.eC(a), this.cs(a))
        };
        __PKL.Playlist.prototype.cs = function (a) {
            this.aT && ("v" == this.bp ? (a = -((this.aK.data.h - this.aK.win.h) * a), this.aT.style.top = parseInt(a) + "px") : (a = -((this.aK.data.w - this.aK.win.w) * a), this.aT.style.left = parseInt(a) + "px"))
        };
        __PKL.Playlist.prototype.dw = function () {
            var a = __PKL.F(this.aM);
            this.aK.win = __PKL.bN(a);
            if (0 < this.ao.length) {
                a = __PKL.bN(__PKL.F(this.ao[0].objid));
                if ("h" == this.bp) {
                    var b = this.ao.length / (this.aK.win.h / a.h);
                    this.aT.style.width = (b + 1) * a.w + "px"
                } else b = this.ao.length / (this.aK.win.w / a.w), this.aT.style.height = (b + 1) * a.h + "px";
                this.aK.data = __PKL.fb(this.cA)
            }
        };
        __PKL.Playlist.prototype.eb = function () {
            for (var a = '<table id="' + (__PKL.ak + __PKL.bC++) + '" style="width:101%;margin:0px;padding:0px;" border="0" cellpadding="0" cellspacing="0"><tr><td>', b = 0; b < this.ao.length; b++) {
                var c = b % 2 ? "PKL_playlistItemBkgd alt" : "PKL_playlistItemBkgd", d = !1, e = this.ao[b];
                e.filekind && "dir" == e.filekind && (d = !0);
                a = d ? a + ('<div id="' + e.objid + '" class="' + c + '" href="JavaScript:;" onClick=\'PKL_LoadPlaylist({player:"' + this.V + '", file:"' + e.file + "\"})'>") : a + ('<div id="' + e.objid + '" class="' + c + '" href="JavaScript:;" onClick=\'__PKL.PLR.' + this.V + '.LoadPlaylistItem("' + b + "\")'>");
                e.title && (a += '<span class="PKL_playlistItemTitle">' + e.title + "</span>");
                e.artist && (a += '<span class="PKL_playlistItemArtist">' + e.artist + "</span>");
                e.image && (a += '<img class="PKL_playlistItemImage" src="' + e.image + '" />');
                for (var f in e)if ("render" != f && e.render && e.render[f] && (!0 === e.render[f] || "true" === e.render[f]))a += e[f];
                a += "</div>\n"
            }
            this.aT.innerHTML = a + "</td></tr></table>\n";
            this.aT.style.top = "0px";
            this.dw();
            this.hF();
            return!0
        };
        __PKL.bz = function () {
        };
        __PKL.bz.prototype.eg = function (a) {
            var b = !1, c = __PKL.PLR[this.V];
            __PKL.bk.current.slider = this;
            __PKL.bk.current.player = c;
            "scrub" == this.aZ && 1 != c.bB && (b = !0, this.dk = !1, c.aR = 0, __PKL.dI(0), c.eZ());
            b || (a || (a = window.event), __PKL.dC(a), b = document, __PKL.bk.dK = b[__PKL.au], __PKL.bk.cY = b[__PKL.bc], b[__PKL.au] = __PKL.eH, b[__PKL.bc] = __PKL.eL, a.stopPropagation ? a.stopPropagation() : a.cancelBubble = !0, a.preventDefault ? a.preventDefault() : a.returnValue = !1, this.dk = !0);
            return!1
        };
        __PKL.eL = function (a) {
            a || (a = window.event);
            if (__PKL.bk.current.slider.dk) {
                var b = document;
                b[__PKL.au] = __PKL.bk.dK;
                b[__PKL.bc] = __PKL.bk.cY
            }
            a.stopPropagation ? a.stopPropagation() : a.cancelBubble = !0;
            a.preventDefault ? a.preventDefault() : a.returnValue = !1;
            a = __PKL.bk.current.slider;
            b = __PKL.bk.current.player;
            "scrub" == a.aZ && (a.dk = !1, b.aR = 0, __PKL.dI(0), b.eZ(), a.bj());
            return!1
        };
        __PKL.eH = function (a) {
            __PKL.K.ay && (a = __PKL.dJ(a));
            __PKL.dC(a);
            a = __PKL.bk.current.slider;
            var b = __PKL.bk.current.player;
            "h" == a.al ? (a.posX = __PKL.bA.x - a.ad.x, a.j = a.posX / a.ad.w) : (a.posY = __PKL.bA.y - a.ad.y, a.j = a.posY / a.ad.h);
            a.j = a.dO(a.j);
            "scrub" == a.aZ ? (b.aR = 1, __PKL.dI(1), b.aQ(a.j)) : "playlist" == a.aZ && b.Playlist.cs(a.j);
            a.bj();
            return!1
        };
        __PKL.bz.prototype.dO = function (a) {
            1 < a && (a = 1);
            0 > a && (a = 0);
            return a
        };
        __PKL.bz.prototype.du = function (a) {
            var b = __PKL.PLR[this.V];
            __PKL.dC(a);
            "h" == this.al ? (this.posX = __PKL.bA.x - this.ad.x, this.j = this.posX / this.ad.w) : (this.posY = __PKL.bA.y - this.ad.y, this.j = this.posY / this.ad.h);
            this.j = this.dO(this.j);
            "scrub" == this.aZ ? 1 == b.bB && (this.bj(), b.aQ(this.j)) : "playlist" == this.aZ && (b.Playlist.cs(this.j), this.bj());
            return!1
        };
        __PKL.bz.prototype.dv = function (a) {
            this.j = this.dO(a);
            "h" == this.al ? this.posX = this.ad.w * this.j : this.posY = this.ad.h * this.j;
            this.bj();
            return!1
        };
        __PKL.bz.prototype.bj = function () {
            if ("h" == this.al) {
                if (0 > this.posX || isNaN(this.posX))this.posX = 0;
                this.posX > this.ad.w && (this.posX = this.ad.w)
            } else {
                if (0 > this.posY || isNaN(this.posY))this.posY = 0;
                this.posY > this.ad.h && (this.posY = this.ad.h)
            }
            if (0 > this.j || isNaN(this.j))this.j = 0;
            this.aN && ("h" == this.al ? this.aN.style.left = String(this.posX) + "px" : this.aN.style.top = String(this.posY) + "px");
            this.cN && ("h" == this.al ? this.cN.style.width = String(100 * this.j) + "%" : this.cN.style.height = String(100 * this.j) + "%");
            return!1
        };
        __PKL.bz.prototype.Rewind = function () {
            "scrub" == this.aZ && (__PKL.PLR[this.V].aR = 0, __PKL.dI(0), this.dk = !1);
            this.dv(0);
            return!1
        };
        __PKL.bz.prototype.eC = function (a) {
            this.dv(a);
            return!1
        };
        __PKL.bz.prototype.cp = function () {
            var a = __PKL.bN(this.cd);
            if (this.aN) {
                var b = this.aN.offsetWidth, c = this.aN.offsetHeight;
                a.x += 0.5 * b;
                a.y += 0.5 * c;
                a.w -= b;
                a.h -= c
            }
            return this.ad = a
        };
        __PKL.bz.prototype.aJ = function (a, b, c, d, e) {
            var f = document;
            this.aZ = d;
            this.V = e;
            this.cd = f.getElementById(a);
            b && f.getElementById(b) && (this.aN = f.getElementById(b));
            c && f.getElementById(c) && (this.cN = f.getElementById(c));
            this.ad = this.cp();
            this.al = this.ad.h > this.ad.w ? "v" : "h";
            var g = this.aZ, h = __PKL.PLR[this.V];
            this.cd[__PKL.ar] = function (a) {
                __PKL.K.ay && (a = __PKL.dJ(a));
                "scrub" == g ? h.bH.eg(a) : h.Playlist.aL.eg(a);
                return!1
            };
            this.cd[__PKL.bc] = function (a) {
                __PKL.K.ay && (a = __PKL.dJ(a));
                "scrub" == g ? h.bH.du(a) : h.Playlist.aL.du(a);
                return!1
            };
            this.dv(0);
            return!1
        };
        __PKL.fG = function (a, b) {
            var c = navigator.userAgent.toLowerCase(), d = (c.match(/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/) || [])[1], e = /webkit/.test(c), f = /opera/.test(c), g = /msie/.test(c) && !/opera/.test(c);
            /mozilla/.test(c) && /(compatible|webkit)/.test(c);
            var h = !1, l = !1, m = [], R = function () {
                if (!l && (l = !0, m)) {
                    for (var a = 0; a < m.length; a++)m[a].call(window, []);
                    m = []
                }
            }, n = function (a) {
                var b = window.onload;
                window.onload = "function" != typeof window.onload ? a : function () {
                    b && b();
                    a()
                }
            };
            (function () {
                if (!h) {
                    h = !0;
                    document.addEventListener && !f && document.addEventListener("DOMContentLoaded", R, !1);
                    g && (10 > d && window == top) && function r() {
                        if (!l) {
                            try {
                                document.documentElement.doScroll("left")
                            } catch (a) {
                                setTimeout(r, 40);
                                return
                            }
                            R()
                        }
                    }();
                    f && document.addEventListener("DOMContentLoaded", function s() {
                        if (!l) {
                            for (var a = 0; a < document.styleSheets.length; a++)if (document.styleSheets[a].disabled) {
                                setTimeout(s, 0);
                                return
                            }
                            R()
                        }
                    }(), !1);
                    if (e) {
                        var a;
                        (function t() {
                            if (!l)if ("loaded" != document.readyState && "complete" != document.readyState)setTimeout(function () {
                            }, 0); else {
                                if (void 0 === a) {
                                    for (var b = document.getElementsByTagName("link"), c = 0; c < b.length; c++)"stylesheet" == b[c].getAttribute("rel") && a++;
                                    b = document.getElementsByTagName("style");
                                    a += b.length
                                }
                                document.styleSheets.length != a ? setTimeout(t, 0) : R()
                            }
                        })()
                    }
                    n(R)
                }
            })();
            l ? b.call(a, []) : m.push(function () {
                return b.call(a, [])
            })
        };
        __PKL.ai = function (a) {
            a = __PKL.bu(a);
            if ("__1" == a.substr(0, 3)) {
                a = a.substr(3, a.length);
                "=" != a.substr(-1) && (a += "=");
                for (var b = "", c, d, e, f, g, h = 0; h < a.length;)c = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".indexOf(a.charAt(h++)), d = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".indexOf(a.charAt(h++)), f = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".indexOf(a.charAt(h++)), g = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".indexOf(a.charAt(h++)), c = (c << 2) + (d >> 4), d = ((d & 15) << 4) + (f >> 2), e = ((f & 3) << 6) + g, 127 > c && (b += unescape(String.fromCharCode(c))), 64 != f && 127 > f && (b += unescape(String.fromCharCode(d))), 64 != g && 127 > g && (b += unescape(String.fromCharCode(e)));
                return __PKL.bu(unescape(b))
            }
            return a
        };
        __PKL.fG(__PKL, __PKL.aJ)
    })()
}
; 

