var weather_api = window.weather_api;
var apiKey      = window.apiKey;
(() => {
    function e(e) {
        return (
            (function (e) {
                if (Array.isArray(e)) return t(e);
            })(e) ||
            (function (e) {
                if (("undefined" != typeof Symbol && null != e[Symbol.iterator]) || null != e["@@iterator"]) return Array.from(e);
            })(e) ||
            (function (e, i) {
                if (e) {
                    if ("string" == typeof e) return t(e, i);
                    var o = Object.prototype.toString.call(e).slice(8, -1);
                    return "Object" === o && e.constructor && (o = e.constructor.name), "Map" === o || "Set" === o ? Array.from(e) : "Arguments" === o || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(o) ? t(e, i) : void 0;
                }
            })(e) ||
            (function () {
                throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
            })()
        );
    }
    function t(e, t) {
        (null == t || t > e.length) && (t = e.length);
        for (var i = 0, o = new Array(t); i < t; i++) o[i] = e[i];
        return o;
    }
    var i = {
        el: jQuery(".js-max-sb-neighborhoods"),
        geocoder: new google.maps.Geocoder(),
        neighborhoodResultsEl: "#max-sb-neighborhood-html",
        activitiesResultsEl: "#max-sb-activities-html",
        defaults: { location: "Chicago", limit: 60, sort: "asc" },
        geo: { location: "", lat: 0, lng: 0 },
        locationMarkers: [],
        activitiesMarkers: [],
        cache: {},
        cacheLength: 2592e5,
        init: function () {
            i.loadComponents();
        },
        loadComponents: function () {
            i.components.neighborhood(), i.components.activities(), i.components.map(), i.components.about.init(), i.components.directions.load();
        },
        updateGeoLatLng: function (e, t) {
            (i.geo.lat = e), (i.geo.lng = t);
        },
        loadCache: function (e, t) {
            void 0 === i.cache[e] && (i.cache[e] = t);
        },
        removeLoadedCache: function (e) {
            delete i.cache[e];
        },
        components: {
            neighborhood: function () {
                void 0 !== jQuery(".js-max-sb-neighborhoods") &&
                jQuery(".js-max-sb-neighborhoods").each(function () {
                    var e = jQuery(this),
                        t = "neighborhood",
                        o = e.find(".js-max-sb-list"),
                        n = e.attr("data-location"),
                        a = e.attr("data-limit"),
                        r = e.attr("data-sort"),
                        s = i.defaults.location,
                        c = t + "-" + e.attr("data-id").split("-")[2];
                    null !== lscache.get(e.attr("data-id")) ? i.loadCache(c, JSON.parse(lscache.get(e.attr("data-id")))) : i.removeLoadedCache(c),
                    void 0 !== n && "" !== n && (s = n),
                    void 0 === a && (a = i.defaults.limit),
                    void 0 === r && (r = i.defaults.sort);
                    var d = { query: "Neighborhoods in " + s, rankby: "distance" },
                        l = function (e, t) {
                            var n = ",";
                            0 == t && (n = ""), i.append(o, "".concat(n, ' <a target="_blank" href="https://www.google.com/maps/search/?api=1&query=').concat(encodeURIComponent(e.name), '">').concat(e.name, "</a>"));
                        };
                    void 0 !== i.cache[c]
                        ? (i.removeLoader(e), i.getPlacesApi.displayResults(i.cache[c], o, a, r, l))
                        : i.getGeoCode.init({ _this: e, location: n, zoom: 11, request: d, displayResults: l, limit: a, sort: r, resultsHtml: o, type: t });
                });
            },
            activities: function () {
                void 0 !== jQuery(".js-max-sb-activities") &&
                jQuery(".js-max-sb-activities").each(function () {
                    var e = jQuery(this),
                        t = e.find(".js-max-sb-list"),
                        o = e.attr("data-location"),
                        n = e.attr("data-limit"),
                        a = e.attr("data-sort"),
                        r = e.attr("data-types"),
                        s = i.defaults.location,
                        c = "activities-" + e.attr("data-id").split("-")[2];
                    null !== lscache.get(e.attr("data-id")) ? i.loadCache(c, JSON.parse(lscache.get(e.attr("data-id")))) : i.removeLoadedCache(c),
                    void 0 !== o && "" !== o && (s = o),
                    void 0 === n && (n = i.defaults.limit),
                    void 0 === a && (a = i.defaults.sort);
                    var d = { radius: 100, query: "Things to do", types: r.split(",") };
                    i.getGeoCode.init({
                        _this: e,
                        location: s,
                        zoom: 11,
                        request: d,
                        displayResults: function (e, o) {
                            var n = void 0 !== e.photos ? e.photos[0].getUrl({ maxWidth: 500, maxHeight: 500 }) : "";
                            "" !== n &&
                            i.append(
                                t,
                                '<div class="max-sb__card"><a target="_blank" href="https://www.google.com/maps/search/?api=1&query='
                                    .concat(encodeURIComponent(e.name), '"><div class="max-sb__card-img"><img alt="')
                                    .concat(e.name, '" width="500" height="500" src="')
                                    .concat(n, '" /></div><p>')
                                    .concat(e.name, "</p></a></div>")
                            );
                        },
                        limit: n,
                        sort: a,
                        resultsHtml: t,
                        type: "activities",
                    });
                });
            },
            map: function () {
                void 0 !== jQuery(".js-max-sb-map") &&
                jQuery(".js-max-sb-map").each(function () {
                    var e = jQuery(this),
                        t = e.attr("data-location"),
                        o = e.attr("data-zoom"),
                        n = e.attr("data-neighborhood"),
                        a = e.attr("data-activities"),
                        r = i.defaults.location,
                        s = !1;
                    (n || a) && (s = !0),
                    void 0 !== t && "" !== t && (r = t),
                        i.getGeoCode.init({
                            _this: e,
                            location: r,
                            multipleMarkers: s,
                            zoom: parseInt(o),
                            neighborhood: n,
                            activities: a,
                            component: "map",
                            callback: function () {
                                jQuery(".js-max-sb-map .max-sb-gmap").show(), i.removeLoader(e);
                            },
                        });
                });
            },
            about: {
                init: function () {
                    void 0 !== jQuery(".js-max-sb-aboutlocation") &&
                    jQuery(".js-max-sb-aboutlocation").each(function () {
                        var e = jQuery(this),
                            t = e.attr("data-location"),
                            o = e.attr("data-limit"),
                            n = i.defaults.location,
                            a = "details-" + e.attr("data-id").split("-")[2];
                        void 0 !== t && "" !== t && (n = t),
                            null !== lscache.get(e.attr("data-id")) ? i.loadCache(a, JSON.parse(lscache.get(e.attr("data-id")))) : i.removeLoadedCache(a),
                            i.components.about.getLocationDetails({ _this: e, location: n, limit: o, cacheId: a });
                    });
                },
                useCache: function (e, t, i) {
                    void 0 !== i[t]
                        ? e.find(".js-max-sb-" + t).html(i[t])
                        : e
                            .find(".js-max-sb-" + t)
                            .parent()
                            .remove();
                },
                getLocationDetails: function (e) {
                    var t = "https://en.wikipedia.org/w/api.php",
                        o = e.location,
                        n = e.location;
                    void 0 !== e.split && (o = e.split), n.split(",").length > 2 && (n = n.split(",")[0] + "," + n.split(",")[1]);
                    var a = { action: "query", prop: "extracts", exsentences: e.limit, exlimit: 1, titles: n, explaintext: 1, formatversion: 2, format: "json" };
                    (t += "?origin=*"),
                        Object.keys(a).forEach(function (e) {
                            t += "&" + e + "=" + a[e];
                        }),
                        void 0 !== i.cache[e.cacheId]
                            ? (i.components.about.useCache(e._this, "desc", i.cache[e.cacheId]),
                                i.components.about.useCache(e._this, "area", i.cache[e.cacheId]),
                                i.components.about.useCache(e._this, "population", i.cache[e.cacheId]),
                                i.components.about.useCache(e._this, "mayor", i.cache[e.cacheId]),
                                i.getTimeAndDay(e._this, o),
                                i.getWeather.init(e._this, o),
                                setTimeout(function () {
                                    i.removeLoader(e._this);
                                }, 200))
                            : fetch(t)
                                .then(function (e) {
                                    return e.json();
                                })
                                .then(function (t) {
                                    if ((void 0 === e.split && (i.getLocationData(e._this, e.location), i.getTimeAndDay(e._this, o)), "" !== t.query.pages[0].extract))
                                        i.removeLoader(e._this), e._this.find(".js-max-sb-desc").html("<p>" + t.query.pages[0].extract + "</p>"), i.saveDetailsToCache(e._this, "desc", t.query.pages[0].extract);
                                    else {
                                        var n = o.split(",");
                                        i.components.about.getLocationDetails({ _this: e._this, location: o, split: n[0], limit: e.limit });
                                    }
                                    i.getWeather.init(e._this, o);
                                })
                                .catch(function (e) {
                                    console.log(e);
                                });
                },
            },
            directions: {
                load: function () {
                    jQuery(".js-max-sb-directions").length > 0 &&
                    ((i.directions = {}),
                        (i.directions.directionsDisplay = ""),
                        (i.directions.directionsService = new google.maps.DirectionsService()),
                        (i.directions.map = ""),
                        (i.directions.bounds = ""),
                        (i.directions.routesHandler = document.getElementById("js-max-sb-direction-routes")),
                        (i.directions.destination = jQuery(".js-max-sb-directions").attr("data-address")),
                        (i.directions.city = jQuery(".js-max-sb-directions").attr("data-city")),
                        (i.directions.currentAddress = []),
                        (i.directions.nextAddress = 0),
                        (i.directions.delay = 100),
                        (i.directions.pins = jQuery(".js-max-sb-directions").attr("data-pins")),
                    void 0 !== lscache.get(jQuery(".js-max-sb-directions").attr("data-id")) && (i.directions.results = JSON.parse(lscache.get(jQuery(".js-max-sb-directions").attr("data-id")))),
                        i.components.directions.initialize(),
                        i.components.directions.clearDirections());
                },
                initialize: function (e) {
                    (i.directions.directionsDisplay = new google.maps.DirectionsRenderer()), jQuery("#js-max-sb-direction-routes").niceScroll();
                    var t = jQuery(".js-max-sb-directions").attr("data-id");
                    if (null == i.directions.results)
                        console.info("Send geocode request"),
                            i.geocoder.geocode({ address: i.directions.destination }, function (e, o) {
                                var n = { zoom: 7, center: new google.maps.LatLng(e[0].geometry.location.lat(), e[0].geometry.location.lng()) };
                                (i.directions.map = new google.maps.Map(document.getElementById("max-sb-directions-map"), n)),
                                    i.directions.directionsDisplay.setMap(i.directions.map),
                                    (i.directions.bounds = new google.maps.LatLngBounds()),
                                    i.getStreetNames(e[0].geometry.location.lat(), e[0].geometry.location.lng()),
                                    lscache.set(t + "-latlng", [{ lat: e[0].geometry.location.lat(), lng: e[0].geometry.location.lng() }], i.cacheLength);
                            });
                    else {
                        console.info("Using Cache", i.directions.results);
                        var o = lscache.get(t + "-latlng");
                        i.components.directions.mapInit(o[0].lat, o[0].lng),
                            setTimeout(function () {
                                return i.components.directions.generateDisplay(i.directions.results);
                            }, 100);
                    }
                },
                clearDirections: function () {
                    jQuery(".js-clear-routes").on("click", function () {
                        (i.directions.currentAddress = []), jQuery("#js-max-sb-direction-routes a").removeClass("active"), i.components.directions.load(!0), (i.directions.removeRoutes = !0);
                    });
                },
                mapInit: function (e, t) {
                    var o = { zoom: 7, center: new google.maps.LatLng(e, t) };
                    (i.directions.map = new google.maps.Map(document.getElementById("max-sb-directions-map"), o)), i.directions.directionsDisplay.setMap(i.directions.map), (i.directions.bounds = new google.maps.LatLngBounds());
                },
                generateDisplay: function (e) {
                    if (
                        (e.forEach(function (e, t) {
                            i.directions.routesHandler.innerHTML += '<li><a data-address="'.concat(e.formatted_address, '" href="#" class="js-route-link">').concat(e.formatted_address, "</a></li>");
                        }),
                            i.removeLoader(jQuery(".js-max-sb-directions")),
                            jQuery(".js-route-link").each(function () {
                                jQuery(this).on("click", function (e) {
                                    jQuery(this).toggleClass("active");
                                    var t = i.directions.currentAddress,
                                        o = [jQuery(this).attr("data-address"), i.directions.destination, "DRIVING"];
                                    i.isArrayInArray(t, o)
                                        ? ((i.directions.currentAddress = t.filter(function (e) {
                                            return (
                                                0 !=
                                                e.filter(function (e, t) {
                                                    return e != o[t];
                                                }).length
                                            );
                                        })),
                                            i.directions.nextAddress--,
                                            i.directions.directionsDisplay.setMap(null))
                                        : i.directions.currentAddress.push(o),
                                        i.components.directions.pinMap(),
                                        google.maps.event.trigger(i.directions.map, "resize"),
                                        e.preventDefault();
                                });
                            }),
                        void 0 === i.directions.removeRoutes)
                    )
                        for (var t = 0; t < jQuery("#js-max-sb-direction-routes li").length; t++) t < parseInt(i.directions.pins) && jQuery("#js-max-sb-direction-routes li").eq(t).find("a").click();
                },
                geocode: function (e, t) {
                    i.geocoder.geocode({ placeId: t }, function (e, t) {
                        i.directions.routesHandler.innerHTML += '<li><a data-address="'.concat(e[0].formatted_address, '" href="#" class="js-route-link">').concat(e[0].formatted_address, "</a></li>");
                    }),
                        i.removeLoader(jQuery(".js-max-sb-directions"));
                },
                pinMap: function () {
                    i.directions.nextAddress < i.directions.currentAddress.length ? (setTimeout(i.components.directions.calcRoute(), i.directions.delay), i.directions.nextAddress++) : i.directions.map.fitBounds(i.directions.bounds);
                },
                calcRoute: function (e, t) {
                    var o = { origin: i.directions.currentAddress[i.directions.nextAddress][0], destination: i.directions.currentAddress[i.directions.nextAddress][1], travelMode: "DRIVING" };
                    i.directions.directionsService.route(o, function (e, t) {
                        "OK" == t
                            ? ((i.directions.directionsDisplay = new google.maps.DirectionsRenderer({ suppressBicyclingLayer: !0, suppressMarkers: !1, preserveViewport: !0 })),
                                i.directions.directionsDisplay.setOptions({ polylineOptions: { strokeColor: "#b4161b" } }),
                                i.directions.directionsDisplay.setMap(i.directions.map),
                                i.directions.directionsDisplay.setDirections(e),
                                i.directions.bounds.union(e.routes[0].bounds),
                                i.directions.map.fitBounds(i.directions.bounds))
                            : t == google.maps.GeocoderStatus.OVER_QUERY_LIMIT
                                ? (i.directions.nextAddress--, (i.directions.delay += 100))
                                : i.directions.delay,
                            i.components.directions.pinMap();
                    });
                },
            },
        },
        saveDetailsToCache: function (e, t, o) {
            var n = e.attr("data-id");
            if (null !== lscache.get(n)) {
                var a = JSON.parse(lscache.get(n));
                (a[t] = o), lscache.set(n, JSON.stringify(a), i.cacheLength);
            } else {
                var r = {};
                (r[t] = o), lscache.set(n, JSON.stringify(r), i.cacheLength);
            }
        },
        getStreetNames: function (t, o) {
            var n = new google.maps.LatLng(t, o),
                a = document.getElementById("max-sb-directions-map2"),
                r = new google.maps.Map(a, { center: n }),
                s = { location: n, query: "Streets in " + i.directions.city, radius: 500 },
                c = [];
            new google.maps.places.PlacesService(r).textSearch(s, function (t, o, n) {
                if ((o == google.maps.places.PlacesServiceStatus.OK && c.push.apply(c, e(t)), n.hasNextPage))
                    setTimeout(function () {
                        return n.nextPage();
                    }, 100);
                else {
                    (i.directions.results = c),
                        setTimeout(function () {
                            return i.components.directions.generateDisplay(c);
                        }, 100);
                    var a = jQuery(".js-max-sb-directions").attr("data-id");
                    lscache.set(a, JSON.stringify(c), i.cacheLength);
                }
            });
        },
        getGeoCode: {
            init: function (e) {
                var t;
                if (void 0 !== e._this) {
                    var o = e._this.find(".max-sb-gmap")[0];
                    t = new google.maps.Map(o, { zoom: e.zoom });
                }
                i.geocoder.geocode({ address: e.location }, function (o, n) {
                    if ("OK" == n) {
                        var a = new google.maps.LatLng(o[0].geometry.location.lat(), o[0].geometry.location.lng());
                        if (
                            (void 0 !== t &&
                            (e.multipleMarkers
                                ? (void 0 !== e.neighborhood && e.neighborhood && i.addNeighborhoodMarkers(t, e.location), void 0 !== e.activities && e.activities && i.addActivitiesMarkers(t, e.location, a))
                                : new google.maps.Marker({ position: a, title: "Marker", map: t, draggable: !0 }),
                                t.setCenter(o[0].geometry.location)),
                            void 0 !== e.request && ((e.request.location = a), i.getPlacesApi.init(e._this, a, e.request, e.resultsHtml, e.limit, e.sort, e.displayResults, e.type)),
                            void 0 !== e.callback)
                        ) {
                            var r = {};
                            "timeAndDay" === e.component && (r.latLng = o[0].geometry.location.lat().toString() + ", " + o[0].geometry.location.lng().toString()), e.callback(r);
                        }
                    } else console.error("Geocode was not successful for the following reason: " + n);
                });
            },
        },
        getPlacesApi: {
            init: function (t, o, n, a, r, s, c, d) {
                var l = [],
                    u = t.find(".max-sb-gmap")[0],
                    g = new google.maps.Map(u, { center: o });
                new google.maps.places.PlacesService(g).textSearch(n, function (o, n, u) {
                    if ((n == google.maps.places.PlacesServiceStatus.OK && l.push.apply(l, e(o)), "neighborhood" === d || "activities" === d)) {
                        var g = t.attr("data-id");
                        lscache.set(g, JSON.stringify(l), i.cacheLength);
                    }
                    u.hasNextPage
                        ? setTimeout(function () {
                            return u.nextPage();
                        }, 100)
                        : (i.removeLoader(t), i.getPlacesApi.displayResults(l, a, r, s, c, d, t));
                });
            },
            displayResults: function (e, t, o, n, a, r, s) {
                i.sortAlphabetically(e, "name", n), i.limitResults(e, o).forEach(a);
            },
        },
        getLocationData: function (e, t) {
            var o = t.split(","),
                n = "SELECT DISTINCT ?city ?cityLabel ?area ?population ?head_of_government ?alternative ?country ?label ?labelc WHERE {\n  ?city wdt:P17 ?country.\n  ?country wdt:P31 wd:Q6256;\n    rdfs:label ?labelc .\n";
            o.length > 2 && (n += 'FILTER(CONTAINS(?labelc, "' + o[2].trim() + '"))\n'),
                (function (t, o, n) {
                    var a = { headers: { Accept: "application/sparql-results+json" }, data: { query: o } };
                    jQuery.ajax("https://query.wikidata.org/sparql", a).then(function (t) {
                        i.sparqlQueryCallback(e, t);
                    });
                })(
                    0,
                    (n +=
                        '  ?city (wdt:P31/(wdt:P279*)) wd:Q515;\n    wdt:P2046 ?area;\n    wdt:P1082 ?population;\n    skos:altLabel ?alternative.\n  FILTER(CONTAINS(?alternative, "' +
                        o[0] +
                        "," +
                        o[1] +
                        '"))\n  ?city rdfs:label ?label.\n  OPTIONAL { ?city wdt:P6 ?head_of_government. }\n  SERVICE wikibase:label { bd:serviceParam wikibase:language "en". }\n}\nLIMIT 1')
                );
        },
        sparqlQueryCallback: function (e, t) {
            if (void 0 !== t.results.bindings[0]) {
                if (void 0 !== t.results.bindings[0].head_of_government) {
                    var o = t.results.bindings[0].head_of_government.value,
                        n = o.split("/").pop();
                    i.getEntityValue(n, e, o);
                } else e.find(".js-max-sb-mayor").parent().remove();
                if (void 0 !== t.results.bindings[0].area) {
                    var a = t.results.bindings[0].area.value + " km²";
                    e.find(".js-max-sb-area").html(a), i.saveDetailsToCache(e, "area", a);
                } else e.find(".js-max-sb-area").html("Not available");
                if (void 0 !== t.results.bindings[0].population) {
                    var r = Number(parseFloat(t.results.bindings[0].population.value).toFixed(2)).toLocaleString("en", { minimumFractionDigits: 0 });
                    e.find(".js-max-sb-population").html(r), i.saveDetailsToCache(e, "population", r);
                } else e.find(".js-max-sb-population").parent().remove();
            } else e.find(".js-max-sb-mayor, .js-max-sb-area, .js-max-sb-population").parent().remove();
        },
        getEntityValue: function (e, t, o) {
            var n = "https://www.wikidata.org/wiki/Special:EntityData/" + e + ".json";
            jQuery.getJSON(n, function (n) {
                t.find(".js-max-sb-mayor").html('<a href="'.concat(o, '" target="_blank">').concat(n.entities[e].labels.en.value, "</a>")),
                    i.saveDetailsToCache(t, "mayor", '<a href="' + o + '" target="_blank">' + n.entities[e].labels.en.value + "</a>");
            });
        },
        getWeather: {
            init: function (e, t) {
                // jQuery.getJSON("https://api.openweathermap.org/data/2.5/weather?q=" + t + "&appid=9b8dc9c8d7761b05cc8fae3b2e5606dd&units=metric", function (e) {
                jQuery.getJSON("https://api.openweathermap.org/data/2.5/weather?q=" + t + "&appid="+weather_api+"&units=metric", function (e) {
                    var t = i.getWeather.getTemp(e),
                        o = i.getWeather.getWind(e),
                        n = i.getWeather.getHumidity(e),
                        a = t + ",  Wind " + o.direction + " at " + o.speed + ", " + n;
                    jQuery(".js-max-sb-weather").html(a);
                });
            },
            getTemp: function (e) {
                return "".concat(e.main.temp, " °C");
            },
            getHumidity: function (e) {
                return "".concat(e.main.humidity, "% Humidity");
            },
            getWind: function (e) {
                return { direction: i.getWeather.getWindDirection(e.wind.deg), speed: i.getWeather.getWindSpeed(e) };
            },
            getWindDirection: function (e) {
                return ["N", "NE", "E", "SE", "S", "SW", "W", "NW"][Math.round(e / 45) % 8];
            },
            getWindSpeed: function (e) {
                var t = Math.round(1.852 * e.wind.speed);
                return "".concat(t, " km/h ");
            },
        },
        getTimeAndDay: function (e, t) {
            i.getGeoCode.init({
                location: t,
                component: "timeAndDay",
                callback: function (t) {
                    var o = t.latLng,
                        n = new Date(),
                        a = n.getTime() / 1e3 + 60 * n.getTimezoneOffset(),
                        r = i.getApiKey(e),
                        s = "https://maps.googleapis.com/maps/api/timezone/json?location=" + o + "&timestamp=" + a + "&key=" + r,
                        c = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                        d = new XMLHttpRequest();
                    d.open("GET", s),
                        (d.onload = function () {
                            if (200 === d.status) {
                                var e = JSON.parse(d.responseText);
                                if ("OK" == e.status) {
                                    var t = 1e3 * e.dstOffset + 1e3 * e.rawOffset,
                                        i = new Date(1e3 * a + t),
                                        o = c[i.getDay()] + " " + i.toLocaleTimeString();
                                    jQuery(".js-max-sb-timezone").html(o);
                                }
                            } else console.error("Request failed.  Returned status of " + d.status);
                        }),
                        d.send();
                },
            });
        },
        addNeighborhoodMarkers: function (t, o) {
            var n = [],
                a = { query: "Neighborhoods in " + o, rankby: "distance" };
            new google.maps.places.PlacesService(t).textSearch(a, function (o, a, r) {
                a == google.maps.places.PlacesServiceStatus.OK && n.push.apply(n, e(o)),
                    r.hasNextPage
                        ? setTimeout(function () {
                            return r.nextPage();
                        }, 100)
                        : n.forEach(function (e, o) {
                            i.locationMarkers.push([e.name, new google.maps.LatLng(e.geometry.location.lat(), e.geometry.location.lng())]);
                            var n,
                                a,
                                r = i.locationMarkers,
                                s = new google.maps.InfoWindow();
                            for (a = 0; a < r.length; a++)
                                (n = new google.maps.Marker({
                                    position: r[a][1],
                                    map: t,
                                    draggable: !0,
                                    icon:
                                        "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAAsTAAALEwEAmpwYAAALNGlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxNDUgNzkuMTYzNDk5LCAyMDE4LzA4LzEzLTE2OjQwOjIyICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKFdpbmRvd3MpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAyMS0wOC0wOFQxMzo1MzozOCswODowMCIgeG1wOk1vZGlmeURhdGU9IjIwMjEtMDgtMDhUMTQ6MDM6NDQrMDg6MDAiIHhtcDpNZXRhZGF0YURhdGU9IjIwMjEtMDgtMDhUMTQ6MDM6NDQrMDg6MDAiIGRjOmZvcm1hdD0iaW1hZ2UvcG5nIiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIiBwaG90b3Nob3A6SUNDUHJvZmlsZT0ic1JHQiBJRUM2MTk2Ni0yLjEiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6M2E4NmI2ZjUtMzdlNS04MjQzLTg0NmEtZGRjOTgxMDc4N2MwIiB4bXBNTTpEb2N1bWVudElEPSJhZG9iZTpkb2NpZDpwaG90b3Nob3A6ODQ2YjJjYzAtZGQxMC0yMzQxLTllYWItYmY1NGYyNzMzY2IwIiB4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ9InhtcC5kaWQ6NDk4MzU2MDEtYmY5ZS1iZDQ1LWJhMzctNjY0MDNkMTE1OWJmIj4gPHhtcE1NOkhpc3Rvcnk+IDxyZGY6U2VxPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY3JlYXRlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDo0OTgzNTYwMS1iZjllLWJkNDUtYmEzNy02NjQwM2QxMTU5YmYiIHN0RXZ0OndoZW49IjIwMjEtMDgtMDhUMTM6NTM6MzgrMDg6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE5IChXaW5kb3dzKSIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6Nzg3OTczMTEtMDkxYS0zZjRjLWIwMDAtMmFhMjJhNzI3YTkwIiBzdEV2dDp3aGVuPSIyMDIxLTA4LTA4VDE0OjAyOjEyKzA4OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ0MgMjAxOSAoV2luZG93cykiIHN0RXZ0OmNoYW5nZWQ9Ii8iLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249ImNvbnZlcnRlZCIgc3RFdnQ6cGFyYW1ldGVycz0iZnJvbSBpbWFnZS9wbmcgdG8gYXBwbGljYXRpb24vdm5kLmFkb2JlLnBob3Rvc2hvcCIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iZGVyaXZlZCIgc3RFdnQ6cGFyYW1ldGVycz0iY29udmVydGVkIGZyb20gaW1hZ2UvcG5nIHRvIGFwcGxpY2F0aW9uL3ZuZC5hZG9iZS5waG90b3Nob3AiLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOmU1YjUzMGMzLWFiNWMtMjc0Yi04YTU5LTUyMWMwM2NjMTRlZSIgc3RFdnQ6d2hlbj0iMjAyMS0wOC0wOFQxNDowMjoxMiswODowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKFdpbmRvd3MpIiBzdEV2dDpjaGFuZ2VkPSIvIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDpjNTU0NGE2ZC00N2IwLTgyNDUtYWZkZC05NGUzMTJlNzdlNzYiIHN0RXZ0OndoZW49IjIwMjEtMDgtMDhUMTQ6MDM6NDQrMDg6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE5IChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY29udmVydGVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJmcm9tIGFwcGxpY2F0aW9uL3ZuZC5hZG9iZS5waG90b3Nob3AgdG8gaW1hZ2UvcG5nIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJkZXJpdmVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJjb252ZXJ0ZWQgZnJvbSBhcHBsaWNhdGlvbi92bmQuYWRvYmUucGhvdG9zaG9wIHRvIGltYWdlL3BuZyIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6M2E4NmI2ZjUtMzdlNS04MjQzLTg0NmEtZGRjOTgxMDc4N2MwIiBzdEV2dDp3aGVuPSIyMDIxLTA4LTA4VDE0OjAzOjQ0KzA4OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ0MgMjAxOSAoV2luZG93cykiIHN0RXZ0OmNoYW5nZWQ9Ii8iLz4gPC9yZGY6U2VxPiA8L3htcE1NOkhpc3Rvcnk+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOmM1NTQ0YTZkLTQ3YjAtODI0NS1hZmRkLTk0ZTMxMmU3N2U3NiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDplNWI1MzBjMy1hYjVjLTI3NGItOGE1OS01MjFjMDNjYzE0ZWUiIHN0UmVmOm9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo0OTgzNTYwMS1iZjllLWJkNDUtYmEzNy02NjQwM2QxMTU5YmYiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4ca7svAAADkElEQVQ4jZWUW0ycRRTHfzPft9+yXJZdhXLZlHw1YhNDL4khEQvBl6oNSb0QXgxpU/VFE6Mp2mJClCZNGpM+GKs1xqSN2j5Ai0ZNrFtKBKzSWqPRhlqpXBe3gJS9QcvusjM+LEsphaT+3+bMmd+cy8wRbT6bNbQNeB7YAlQAEvgL+APoAL5d7ZBYBVgFvAvUrHXToq4AbwFfLzfKFU6vAD/dAwzgYeAr4NBawJeBD4WUqOQCiVAItAYhbnsIAVqTCIVQySRCSoBm4PBKYAVwVJomiUiE+PQ02T4fs8EAKpFASImQEpVIMBsMkO3zEZ++QSISRpomQBPw7G2gECelaRIdHWI+eoNHj75PXV8vW/Y3k4xFCQeGCAeGSMSibN63n7q+Xqo++oB4NER0dBBpmCDEZ5BuSqU0zJ+jY0PkltnUnviUoprqpSz923fgfuhBAKJXB3iyy7+0N3n+R3obdxEbHcFd9gAqtfASbT774+NOl/Y/VaeTsZjOaDYwri++3qSH2zuWbMPtp/XF1/bq2cD4ki05O6fP7qjTx50u3eazv5fAI0II9HwSYToACJ7r4reWdyiurcFueG4pIruhnuLHa/m15W2CZ8+lq2VI1K0EIt28DSaw0ZntZqqvj/jMDNFr15jo7mVrawu5tn3XWyl7Zif3bd3MwCfHkE4Ld3k5U30XcOa4Ae6XgKFUCsuTj5ntYrLnB4qqt60KyyjXtimqqWay5zxmtgvLm49SKQApgb+1UuiFFJbHQ/me3Ux09wAw+PlJLrW0ADA3FuDCgQOMnOoAYKK7h/I9u7A8HnQyhVYKIGQCvxuWtUkrzfgZP3PXg7hKigH45c1mLk+OU3nwIJGrA3zT2kpV5WPYDfW4iosIdHaSU1KK1hrDsgDGTOCE4XI1aqXoqnuasI6z/b0jADzReYaa6X8BWLh1k0Igd0O6FNJ08N2LL+ARTlylJQgp0Up9aQJ+rVQQKM1aV4hjchxHXh4A3k0VeBfrZriyWACMLCcAlicfB5C1rhAgk/IRc9F/N9ApTBO3t4CR9lOE+/vvaERseIQCbwGhy/1catpH+MqfuL0FCDOD4FVgfvn4OgQ0Gw4HN69PMB+P3QG0jCzy1q9nPhJhLjSF05lLTkkJqWQS4AugHu6eh4dJf/T/o9NAQ2axch6+ATQC/9wDKALsXQ5bLcKMLNJ13QlsBIoAAUwDg4AfOAbMrDz4Hy4qaZlZpMIAAAAAAElFTkSuQmCC",
                                })),
                                    google.maps.event.addListener(
                                        n,
                                        "click",
                                        (function (e, i) {
                                            return function () {
                                                s.setContent(r[i][0]), s.open(t, e);
                                            };
                                        })(n, a)
                                    );
                        });
            });
        },
        addActivitiesMarkers: function (t, o, n) {
            var a = [],
                r = { radius: 5e4, location: n, query: "Things to do", types: ["point_of_interest", "landmark"] };
            new google.maps.places.PlacesService(t).textSearch(r, function (o, n, r) {
                n == google.maps.places.PlacesServiceStatus.OK && a.push.apply(a, e(o)),
                    r.hasNextPage
                        ? setTimeout(function () {
                            return r.nextPage();
                        }, 100)
                        : a.forEach(function (e, o) {
                            i.activitiesMarkers.push([e.name, new google.maps.LatLng(e.geometry.location.lat(), e.geometry.location.lng()), e.icon]);
                            var n = i.activitiesMarkers,
                                a = new google.maps.InfoWindow(),
                                r = n.map(function (e, i) {
                                    var o = new google.maps.Marker({ position: n[i][1], draggable: !0 });
                                    return (
                                        google.maps.event.addListener(o, "click", function (i) {
                                            a.setContent(e[0]), a.open(t, o);
                                        }),
                                            o
                                    );
                                });
                            new MarkerClusterer(t, r, { imagePath: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m" });
                        });
            });
        },
        limitResults: function (e, t) {
            return e.slice(0, t);
        },
        append: function (e, t) {
            e.append(t);
        },
        removeLoader: function (e) {
            setTimeout(function () {
                e.find(".js-max-sb-loader").remove(), e.find(".max-sb-block--loading").removeClass("max-sb-block--loading");
            }, 200);
        },
        sortAlphabetically: function (e, t, o) {
            if ("rand" !== o)
                return e.sort(function (e, i) {
                    return "asc" === o ? (e[t].toLowerCase() < i[t].toLowerCase() ? -1 : 1) : "desc" === o ? (e[t].toLowerCase() > i[t].toLowerCase() ? -1 : 1) : void 0;
                });
            "rand" === o && i.randomizeData(e);
        },
        randomizeData: function (e) {
            return e.sort(function () {
                return 0.5 - Math.random();
            });
        },
        hasClass: function (e, t) {
            return (" " + e.className + " ").indexOf(" " + t + " ") > -1;
        },
        setCookie: function (e, t, i) {
            var o = "";
            if (i) {
                var n = new Date();
                n.setTime(n.getTime() + 24 * i * 60 * 60 * 1e3), (o = "; expires=" + n.toUTCString());
            }
            document.cookie = e + "=" + (t || "") + o + "; path=/";
        },
        deleteCookie: function (e) {
            document.cookie = e + "=; Max-Age=0; path=/; domain=" + location.host;
        },
        getCookie: function (e) {
            for (var t = e + "=", i = document.cookie.split(";"), o = 0; o < i.length; o++) {
                for (var n = i[o]; " " == n.charAt(0); ) n = n.substring(1, n.length);
                if (0 == n.indexOf(t)) return n.substring(t.length, n.length);
            }
            return null;
        },
        isArrayInArray: function (e, t) {
            var i = JSON.stringify(t);
            return e.some(function (e) {
                return JSON.stringify(e) === i;
            });
        },
        getApiKey: function (e) {
            return e.attr("data-key");
        },
    };
    !(function (e) {
        "use strict";
        i.init();
    })(jQuery);
})();
