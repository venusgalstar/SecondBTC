var pathname = window.location.pathname.split("/"),
pagename = pathname[1],
serviceURL = "/",
socketUrl = "https://secondbtc.com:8443/",
socket = io.connect(socketUrl,{transport : ['websocket']});
if ("exchange" == pagename) {
    function myFunction(e) {
        console.log(e);
        $("#marketEx").attr("id", "marketEx" + e),
        socket.emit("marketveri", Number(e)),
        socket.on("marketveri", function (t) {
            var i = "";
            $.each(t.data, function (t, e) {
                console.log(e)
                var sonRenk= "";
                if(e.last_trade=="buy"){sonRenk = "success";}else{sonRenk = "danger";}
                if (new Date().getTime() - 864e5 < 1e3 * e.to_wallet_last_trade_date)
                    var a = e.change,
                r = e.to_wallet_24h_vol.toFixed(4);
                else (a = "0.00"), (r = "0.0000");
                var l = serviceURL + "exchange/" + e.from_wallet_short + "-" + e.to_wallet_short;
                if (0 < e.change) var o = "success";
                else if (e.change < 0) o = "danger";
                else o = "dark";
                i +=
                '<tr><td><a title="' +
                e.to_wallet_short +
                "/" +
                e.from_wallet_short +
                '" name="' +
                e.to_wallet_short +
                "/" +
                e.from_wallet_short +
                '" alt="' +
                e.to_wallet_short +
                "/" +
                e.from_wallet_short +
                '" href="' +
                l +
                '">' +
                e.to_wallet_short +
                "/" +
                e.from_wallet_short +
                '</a></td><td class="text-right text-'+sonRenk+'">' +
                e.to_wallet_last_price?.toFixed(e.market_priceDecimal) +
                '</td><td class="text-right text-' +
                o +
                '">' +
                a +
                '%</td><td class="text-right d-none">' +
                r +
                "</td></tr>";
            }),
            $("#marketEx" + e).DataTable().destroy(),
            $("#market").html(i),
            /*$("#marketEx" + e).dataTable({
                searching: !0,
                info: !1,
                lengthChange: !1,
                autoWidth: !1,
                scrollY: "300px",
                scrollCollapse: !0,
                paging: !1,
                order: [[3, "desc"]],
            });*/
            $("#marketEx").DataTable({ language: { search: "_INPUT_", searchPlaceholder: search + "..." }, searching: !0, info: !1, lengthChange: !1, autoWidth: !1, scrollY: "300px", scrollCollapse: !0, paging: !1, order: [[3, "desc"]] }).draw();
        });
    }
    function myTradeHistory() {
        var t = [fromID, toID, $("#soketID").html(), $("#hesap").html()];
        socket.emit("mytradeData", t),
        socket.on("mytradeData", function (t) {
            if ("bos" == t.i && t.veri[0] == fromID && t.veri[1] == toID && t.veri[2] == $("#soketID").html() && t.veri[3] == $("#hesap").html()) {
                var s = "";
                $("#mytradeHistory").html(s);
            } else
            "dolu" == t.i &&
            t.veri[0] == fromID &&
            t.veri[1] == toID &&
            t.veri[2] == $("#soketID").html() &&
            t.veri[3] == $("#hesap").html() &&
            ($.each(t.data, function (t, e) {
                if ("sell" == e.trade_type) var a = "danger";
                else a = "success";
                var r = e.trade_unit.toFixed(8),
                l = e.trade_bid.toFixed(8),
                o = (e.trade_total.toFixed(8), e.trade_created),
                i = new Date(1e3 * o).toLocaleString();
                s +=
                '<tr><td class="text-left">' +
                e.trade_from_wallet_short +
                "/" +
                e.trade_to_wallet_short +
                '</td><td class="text-right text-' +
                a +
                '">' +
                l +
                '</td><td class="text-right">' +
                r +
                '</td><td class="text-right">' +
                (e.trade_unit * e.trade_bid).toFixed(8) +
                '</td><td class="text-center">' +
                i +
                '</td><td class="d-none">' +
                o +
                "</td></tr>";
            }),
            $("#MYTradingHistory").DataTable().destroy(),
            $("#mytradeHistory").html(s),
            $("#MYTradingHistory").dataTable({
                height: 250,
                info: !1,
                lengthChange: !1,
                autoWidth: !0,
                scrollY: "250px",
                scrollCollapse: !0,
                paging: !1,
                order: [[4, "desc"]],
            }),
            $('a[data-toggle="tab"]').on("shown.bs.tab", function (t) {
                $($.fn.dataTable.tables(!0)).DataTable().columns.adjust();
            }));
        });
    }
    $(document).ready(function () {
        var n = $("#fromID").val(),
        h = $("#toID").val(),
        t = [n, h],
        a = $("#soketID").html(),
        r = $("#hesap").html(),
        e = $("#toWallet").html(),
        l = $("#fromWallet").html();
        if (0 != a && 0 != r) {
            var o = [a, r, l, e];
            socket.emit("orderBook", o),
            socket.on("orderBook", function (t) {
                if (t.data[0] || t.veri[0] != a) {
                    if (t.data[0] && t.veri[0] == a) {
                        var i = "";
                        $.each(t.data, function (t, e) {
                            var a = e.exchange_created,
                            r = new Date(1e3 * a).toLocaleString(),
                            l = e.exchange_id;
                            if ("buy" == e.exchange_type) var o = "success";
                            else o = "danger";
                            i +=
                            '<tr id="' +
                            e.exchange_id +
                            '"><td class="text-left">' +
                            e.exchange_from_short +
                            "/" +
                            e.exchange_to_short +
                            '</td><td class="text-right text-' +
                            o +
                            '">' +
                            e.exchange_bid.toFixed(8) +
                            '</td><td class="text-right">' +
                            e.exchange_unit.toFixed(8) +
                            '</td><td class="text-right">' +
                            e.exchange_total.toFixed(8) +
                            '</td><td class="text-right text-uppercase text-' +
                            o +
                            '">' +
                            e.exchange_type +
                            '</td><td class="text-center">' +
                            r +
                            '</td><td class="d-none">' +
                            a +
                            '</td><td class=" cursor-pointer text-center"><i id="deleteOrder" onclick="customJS.exchange.orderDelete(' +
                            e.exchange_created +
                            ",'" +
                            l +
                            '\',1)" class="fa fa-minus-circle text-danger" title="cancel order"></i><input id="closeOrder" type="hidden" value="' +
                            l +
                            '"></td></tr>';
                        });
                    }
                } else i = "";
                $("#myOpenOrders").DataTable().destroy(),
                $("#myOrderBook").html(i),
                $("#myOpenOrders").dataTable({
                    height: 250,
                    info: !1,
                    lengthChange: !1,
                    autoWidth: !1,
                    scrollCollapse: !0,
                    paging: !1,
                    scrollY: "250px",
                    order: [[5, "desc"]],
                });
            });
            var s = [n, a, r];
            socket.emit("userfromBalance", s),
            socket.on("userfromBalance", function (t) {
                if ("dolu" == t.i && t.veri[0] == n && t.veri[1] == a && t.veri[2] == r) {
                    var e = t.data[0].wallet_user_balance.toFixed(8);
                    "" == e && (e = 0), $("#userFromBalance").html(e);
                }
            });
            var d = [h, a, r];
            socket.emit("usertoBalance", d),
            socket.on("usertoBalance", function (t) {
                if ("dolu" == t.i && t.veri[0] == h && t.veri[1] == a && t.veri[2] == r) {
                    var e = t.data[0].wallet_user_balance.toFixed(8);
                    $("#userToBalance").html(e);
                }
            });
        }
        socket.emit("exchangeSell", t),
        socket.on("exchangeSell", function (t) {
            if ("bos" == t.i && t.veri[0] == n && t.veri[1] == h)
                for (i2 = 0; i2 < 16; i2++)
                    $("#sell-bids" + i2).html("-"), $("#sell-unit" + i2).html("-"), $("#sell-total" + i2).html("-"), $("#sell-hacim" + i2).html('<div class="orderBackRenk bg-success" style="position: absolute; max-width:0px;">.</div>');
                else if ("dolu" == t.i && t.veri[0] == n && t.veri[1] == h) {
                    var i = 0;
                    for (i2 = 0; i2 < 16; i2++)
                        $("#sell-bids" + i2).html("-"), $("#sell-unit" + i2).html("-"), $("#sell-total" + i2).html("-"), $("#sell-hacim" + i2).html('<div class="orderBackRenk bg-success" style="position: absolute; max-width:0px;">.</div>');
                    var s = 0;
                    $.each(t.data, function (t, e) {
                        i += 1;
                        var a = e._id * e.unit;
                        if (new Date().getTime().toString().substring(0, 10) - 3 < e.time) {
                            var r = "srenk" + i;
                            //(document.getElementById(r).style.backgroundColor = "#eaeaea"),
                            setTimeout(function () {
                                    //document.getElementById(r).style.backgroundColor = "white";
                                }, 200);
                        }
                        var l = (s += a).toFixed(8).toString().split(".")[0].length,
                        o = 0;
                        l <= 1 ? (o = 10 * s) : 3 <= l && (o = s / 1e3),
                        (o = 96 < o ? 96 : o),
                        //document.getElementById("sell-hacim15").style.backgroundColor = "red",
                        //(document.getElementById("#sell-hacim"+i).style.width = o + '%');
                        //$("#sell-hacim" + i).html('<div class="orderBackRenk bg-danger ml-3" style="position: absolute; width:' + o + '%;">.</div>'),
                        $("#sell-bids" + i).html(e._id.toFixed(8)),
                        $("#sell-unit" + i).html(e.unit.toFixed(8)),
                        $("#sell-total" + i).html(a.toFixed(4));
                    });
                }
            }),
        socket.emit("exchangeBuy", t),
        socket.on("exchangeBuy", function (t) {
            if ("bos" == t.i && t.veri[0] == n && t.veri[1] == h)
                for (i = 0; i < 16; i++)
                    $("#buy-bids" + i).html("-"), $("#buy-unit" + i).html("-"), $("#buy-total" + i).html("-"), $("#buy-hacim" + i).html('<div class="orderBackRenk bg-success" style="position: absolute; max-width:0px;">.</div>');
                else if ("dolu" == t.i && t.veri[0] == n && t.veri[1] == h) {
                    var s = 0;
                    for (i = 0; i < 16; i++)
                        $("#buy-bids" + i).html("-"), $("#buy-unit" + i).html("-"), $("#buy-total" + i).html("-"), $("#buy-hacim" + i).html('<div class="orderBackRenk bg-success" style="position: absolute; max-width:0px;">.</div>');
                    var d = 0;
                    $.each(t.data, function (t, e) {
                        s += 1;
                        var a = e._id * e.unit;
                        if (new Date().getTime().toString().substring(0, 10) - 3 < e.time) {
                            var r = "brenk" + s;
                            //(document.getElementById(r).style.backgroundColor = "#eaeaea"),
                            setTimeout(function () {
                                    //document.getElementById(r).style.backgroundColor = "white";
                                }, 200);
                        }
                        var l = (d += a).toFixed(8).toString().split(".")[0].length,
                        o = 0;
                        l <= 1 ? (o = 10 * d) : 3 <= l && (o = d / 1e3),
                        (o = 96 < o ? 96 : o),
                        $("#buy-hacim" + s).html('<div class="orderBackRenk bg-success ml-3" style="position: absolute; max-width:' + o + '%;">.</div>'),
                        $("#buy-bids" + s).html(e._id.toFixed(8)),
                        $("#buy-unit" + s).html(e.unit.toFixed(8)),
                        $("#buy-total" + s).html(a.toFixed(4));
                    });
                }
            }),
        socket.emit("tradeData", t),
        socket.on("tradeData", function (t) {
            if ("bos" == t.i && t.veri[0] == n && t.veri[1] == h) {
                var c = "";
                $("#tradeHistory").html(c);
            } else
            "dolu" == t.i &&
            t.veri[0] == n &&
            t.veri[1] == h &&
            ($.each(t.data, function (t, e) {
                if ("sell" == e.trade_type) var a = "danger";
                else a = "success";
                var r = e.trade_unit.toFixed(8),
                l = e.trade_bid.toFixed(8),
                o = e.trade_created,
                i = new Date(1e3 * o).getTime().toString().substring(0, 10),
                s = new Date(1e3 * o).toLocaleTimeString(),
                d = new Date().getTime().toString().substring(0, 10);
                if (--d < i) {
                    if ("sell" == e.trade_type);
                    else;
                    setTimeout(function () {
                                    //document.getElementById("trade").style.backgroundColor = "white";
                                }, 100);
                }
                c += '<tr id="trade"><td class= text-' + a + ' pr-2">' + l + '</td><td class="text-right ">' + r + '</td><td class="text-right pr-2">' + s + "</td></tr>";
            }),
            $("#tradeHistory").html(c));
        }),
        socket.emit("marketveri", $("#active").html()),
        socket.on("marketveri", function (t) {
            //console.log($("#active").html());
            var i = "";
            i = 0;
            $.each(t.data, function (t, e) {
                var sonRenk= "";
                if(e.last_trade=="buy"){sonRenk = "success";}else{sonRenk = "danger";}
                if (new Date().getTime() - 864e5 < 1e3 * e.to_wallet_last_trade_date)
                    var a = e.change,
                r = e.to_wallet_24h_vol.toFixed(4);
                else (a = "0.00"), (r = "0.0000");
                if (0 < e.change) var l = "success";
                else if (e.change < 0) l = "danger";
                else l = "dark";
                var o = serviceURL + "exchange/" + e.from_wallet_short + "-" + e.to_wallet_short;
                i +=
                '<tr><td><a title="' +
                e.to_wallet_short +
                "/" +
                e.from_wallet_short +
                '" name="' +
                e.to_wallet_short +
                "/" +
                e.from_wallet_short +
                '" alt="' +
                e.to_wallet_short +
                "/" +
                e.from_wallet_short +
                '" href="' +
                o +
                '">' +
                e.to_wallet_short +
                "/" +
                e.from_wallet_short +
                '</a></td><td class="text-right text-'+sonRenk+'">' +
                e.to_wallet_last_price.toFixed(8) +
                '</td><td class="text-right text-' +
                l +
                '">' +
                a +
                '%</td><td class="text-right d-none">' +
                r +
                "</td></tr>";
            }),
            $("#market").html(i),
            /*$("#marketEx").dataTable({
                searching: !0,
                info: !1,
                lengthChange: !1,
                autoWidth: !1,
                scrollY: "300px",
                scrollCollapse: !0,
                paging: !1,
                order: [[3, "desc"]],
            });*/
            $("#marketEx").DataTable({ language: { search: "_INPUT_", searchPlaceholder: search + "..." }, searching: !0, info: !1, lengthChange: !1, autoWidth: !1, scrollY: "300px", scrollCollapse: !0, paging: !1, order: [[3, "desc"]] }).draw();
        }),
        socket.emit("marketveridetail", t),
        socket.on("marketveridetail", function (t) {
            if ("dolu" == t.i && t.veri[0] == n && t.veri[1] == h) {
                var e = new Date().getTime() - 864e5,
                a = 1e3 * t.data[0].to_wallet_last_trade_date,
                r = t.data[0].to_wallet_last_price.toFixed(8);
                if (e < a)
                    var l = t.data[0].change,
                o = t.data[0].to_wallet_24_high.toFixed(8),
                i = t.data[0].to_walet_24_low.toFixed(8),
                s = t.data[0].to_wallet_24h_vol.toFixed(4);
                else (l = "0.00"), (o = "0.00000000"), (i = "0.00000000"), (s = "0.0000");
                $("#lastPrice").html(r),
                $("#lastPriceUst").html(r),
                t.data[0].change < 0
                ? (document.getElementById("renkChange").style.color = "red")
                : 0 < t.data[0].change
                ? (document.getElementById("renkChange").style.color = "green")
                : (document.getElementById("renkChange").style.color = "dark"),
                $("#change").html(l),
                $("#24hvol").html(s),
                $("#24hHigh").html(o),
                $("#24hLow").html(i);
            }
        });
    });
}
if ("order" == pagename){
    $(document).ready(function () {
        var e = $("#soketID").html(),
        t = $("#hesap").html();
        if (0 != e && 0 != t) {
            var a = [e, t];
            socket.emit("orderPageBook", a);
            socket.on("orderPageBook", function (t) {
                if (t.data[0] || t.veri[0] != e) {
                    if (t.data[0] && t.veri[0] == e) {
                        var i = "";
                        $.each(t.data, function (t, e) {
                            var a = e.exchange_created,
                            r = new Date(1e3 * a).toLocaleString(),
                            l = e.exchange_id;
                            if ("buy" == e.exchange_type) var o = "success";
                            else o = "danger";
                            i += '<tr id="' +
                            e.exchange_id +
                            '"><td class="text-left align-middle" scope="row">' +
                            e.exchange_from_short +
                            "/" +
                            e.exchange_to_short +
                            '</td><td class="text-left align-middle buyukharf text-' +
                            o +
                            '">' +
                            e.exchange_type +
                            '</td><td class="text-right align-middle">' +
                            e.exchange_bid.toFixed(8) +
                            '</td><td class="text-right align-middle">' +
                            e.exchange_unit.toFixed(8) +
                            '</td><td class="text-right align-middle">' +
                            e.exchange_total.toFixed(8) +
                            '</td><td class="text-right align-middle"><span class="d-none">' +
                            a +
                            "</span>" +
                            r +
                            '</td><td class="text-right align-middle cursor-pointer"><i id="deleteOrder" onclick="customJS.exchange.orderDelete(' +
                            e.exchange_created +
                            ",'" +
                            l +
                            "'," +
                            e.exchange_from_wallet_id +
                            "," +
                            e.exchange_to_wallet_id +
                            ',2)" class="fa fa-minus-circle text-danger" title="cancel order"></i></td></tr>';
                        });
                    }
                } else {i = ""};
                $("#order-page1").DataTable().destroy(),
                $("#myOrderBook").html(i);
                var table1 = $('#order-page1').DataTable( {
                    "info":     false,
                    "bLengthChange":false,
                    "order": [[5, "desc"]],
                    dom: "Bfrtip",
                    //"dom": "lrbti<'col-sm-12 col-md-7'p>",
                    buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
                } );
                $('#orderpageSearch1').on( 'keyup', function () {
                    table1.search( this.value ).draw();
                } );
            });
            var r = [$("#soketID").html(), $("#hesap").html()];
            socket.emit("orderPageTradeData", r);
            socket.on("orderPageTradeData", function (t) {
                if ("bos" == t.i && t.veri[0] == $("#soketID").html() && t.veri[1] == $("#hesap").html()) {
                    var d = "";
                    $("#mytradeHistory").html(d);
                } else if(
                "dolu" == t.i &&
                t.veri[0] == $("#soketID").html() &&
                t.veri[1] == $("#hesap").html()
                ){$.each(t.data, function (t, e) {
                    if ("sell" == e.trade_type) var a = "danger";
                    else a = "success";
                    var r = e.trade_unit.toFixed(8),
                    l = e.trade_bid.toFixed(8),
                    o = e.trade_total.toFixed(8),
                    i = e.trade_created,
                    s = new Date(1e3 * i).toLocaleString();
                    d +=
                    '<tr><td class="text-left align-middle" scope="row">' +
                    e.trade_from_wallet_short +
                    "/" +
                    e.trade_to_wallet_short +
                    '</td><td class="text-left align-middle buyukharf text-' +
                    a +
                    '">' +
                    e.trade_type +
                    '</td><td class="text-right align-middle">' +
                    l +
                    '</td><td class="text-right align-middle">' +
                    r +
                    '</td><td class="text-right align-middle">' +
                    o +
                    '</td><td class="text-right align-middle"><span class="d-none">' +
                    i +
                    "</span>" +
                    s +
                    "</td></tr>";
                }),
                $("#order-page2").DataTable().destroy(),
                $("#MYTradingHistory").html(d);
                var table2 = $('#order-page2').DataTable( {
                    "info":     false,
                    "bLengthChange":false,
                    "order": [[5, "desc"]],
                    dom: "Bfrtip",
                    //"dom": "lrbti<'col-sm-12 col-md-7'p>",
                    buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
                } );
                $('#orderpageSearch2').on( 'keyup', function () {
                    table2.search( this.value ).draw();
                } );
                 /*$("#order-page2").dataTable({
                    language: { search: "_INPUT_", searchPlaceholder: search + "..." },
                    info: !1,
                    lengthChange: !1,
                    autoWidth: !1,
                    order: [[5, "desc"]],
                    dom: "Bfrtip",
                    buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
                });*/
             }
            });
        }
    })
}
if("market" == pagename)
{
    function myFunction(t) {
        var e = io.connect(socketUrl);
        e.emit("marketveri", t),
        e.on("marketveri", function (t) {
            console.log(t)
            $("#marketEx").DataTable().destroy();
            var d = "";
            d = 0;
            $.each(t.data, function (t, e) {
                if (new Date().getTime() - 864e5 < 1e3 * e.to_wallet_last_trade_date)
                    var a = e.change,
                r = e.to_wallet_24_high.toFixed(8),
                l = e.to_walet_24_low.toFixed(8),
                o = e.to_wallet_24h_vol.toFixed(4);
                else (a = "0.00"), (r = "0.00000000"), (l = "0.00000000"), (o = "0.0000");
                if (0 < e.change) var i = "success";
                else if (e.change < 0) i = "danger";
                else i = "dark";
                var s = serviceURL + "exchange/" + e.from_wallet_short + "-" + e.to_wallet_short;
                var lbl = e.to_wallet_short + '/' + e.from_wallet_short;
                d +=
                '<tr><td class="text-left" scope="row"><a href="' +
                s +
                '">' +
                e.to_wallet_short +
                "/" +
                e.from_wallet_short +
                '</a></td><td class="text-left" scope="row">' +
                e.to_wallet_name +
                '</td><td class="text-right">' +
                e.to_wallet_last_price.toFixed(8) +
                '</td><td class="text-right text-' +
                i +
                '">' +
                a +
                '%</td><td class="text-right">' +
                o +
                '</td><td class="text-right">' +
                r +
                '</td><td class="text-right">' +
                l +
                '</td><td class="text-right"><a class="btn btn-sm btn-buy" href="' + s + '">Trade</a>' +
                "</td></tr>";
            }),
            $("#market").html(d);
            var table1 = $('#marketEx').DataTable( {
                "info":     false,
                "bLengthChange":false,
                "order": [[4, "desc"]],
                "dom": "lrti<'col-sm-12 col-md-7'p>"
            } );
            $('#marketpageSearch').on( 'keyup', function () {
                table1.search( this.value ).draw();
            } );
        });

    }

    $(document).ready(function () {
        socket.emit("marketveri", $("#active").html()),
        socket.on("marketveri", function (t) {
            var d = "";
            d = 0;
            $.each(t.data, function (t, e) {
                if (new Date().getTime() - 864e5 < 1e3 * e.to_wallet_last_trade_date)
                    var a = e.change,
                r = e.to_wallet_24_high.toFixed(8),
                l = e.to_walet_24_low.toFixed(8),
                o = e.to_wallet_24h_vol.toFixed(4);
                else (a = "0.00"), (r = "0.00000000"), (l = "0.00000000"), (o = "0.0000");
                if (0 < e.change) var i = "success";
                else if (e.change < 0) i = "danger";
                else i = "dark";
                var s = serviceURL + "exchange/" + e.from_wallet_short + "-" + e.to_wallet_short;
                var lbl = e.to_wallet_short + '/' + e.from_wallet_short;
                d +=
                '<tr><td class="text-left" scope="row"><a title="' +
                e.to_wallet_short +
                "/" +
                e.from_wallet_short +
                '" name="' +
                e.to_wallet_short +
                "/" +
                e.from_wallet_short +
                '" alt="' +
                e.to_wallet_short +
                "/" +
                e.from_wallet_short +
                '" href="' +
                s +
                '">' +
                e.to_wallet_short +
                "/" +
                e.from_wallet_short +
                '</a></td><td class="text-left" scope="row">' +
                e.to_wallet_name +
                '</td><td class="text-right">' +
                e.to_wallet_last_price.toFixed(8) +
                '</td><td class="text-right text-' +
                i +
                '">' +
                a +
                '%</td><td class="text-right">' +
                o +
                '</td><td class="text-right">' +
                r +
                '</td><td class="text-right">' +
                l +
                '</td><td class="text-right"><a class="btn btn-sm btn-buy" href="' + s + '">Trade</a>' +
                "</td></tr>";
            }),
            $("#market").html(d);
            var table1 = $('#marketEx').DataTable( {
                "info":     false,
                "bLengthChange":false,
                "order": [[4, "desc"]],
                "dom": "lrti<'col-sm-12 col-md-7'p>"
            } );
            $('#marketpageSearch').on( 'keyup', function () {
                table1.search( this.value ).draw();
            } );




        });
    });
}
if("" == pagename || "/" == pagename)
{
    function myFunctionHome(t) {
        var e = io.connect(socketUrl);
        e.emit("marketveri", t),
        e.on("marketveri", function (t) {
            $("#marketExHome").DataTable().destroy();
            var d = "";
            d = 0;
            $.each(t.data, function (t, e) {
                if (new Date().getTime() - 864e5 < 1e3 * e.to_wallet_last_trade_date)
                    var a = e.change,
                r = e.to_wallet_24_high.toFixed(8),
                l = e.to_walet_24_low.toFixed(8),
                o = e.to_wallet_24h_vol.toFixed(4);
                else (a = "0.00"), (r = "0.00000000"), (l = "0.00000000"), (o = "0.0000");
                if (0 < e.change) var i = "success";
                else if (e.change < 0) i = "danger";
                else i = "dark";
                var s = serviceURL + "exchange/" + e.from_wallet_short + "-" + e.to_wallet_short;
                d +=
                '<tr><td class="text-left" scope="row"><a href="' +
                s +
                '">' +
                e.to_wallet_short +
                "/" +
                e.from_wallet_short +
                '</a></td><td class="text-left" scope="row">' +
                e.to_wallet_name +
                '</td><td class="text-right">' +
                e.to_wallet_last_price.toFixed(8) +
                '</td><td class="text-right text-' +
                i +
                '">' +
                a +
                '%</td><td class="text-right">' +
                o +
                '</td><td class="text-right">' +
                r +
                '</td><td class="text-right">' +
                l +
                "</td></tr>";
            }),
            $("#market").html(d);
            var table1 = $('#marketExHome').DataTable( {
                "info":     false,
                "bLengthChange":false,
                "order": [[4, "desc"]],
                "dom": "lrti<'col-sm-12 col-md-7'p>"
            } );
            $('#homepageSearch').on( 'keyup', function () {
                table1.search( this.value ).draw();
            } );
        });

    }

    $(document).ready(function () {
        socket.emit("marketveri", $("#active").html()),
        socket.on("marketveri", function (t) {
            var d = "";
            d = 0;
            $.each(t.data, function (t, e) {
                if (new Date().getTime() - 864e5 < 1e3 * e.to_wallet_last_trade_date)
                    var a = e.change,
                r = e.to_wallet_24_high.toFixed(8),
                l = e.to_walet_24_low.toFixed(8),
                o = e.to_wallet_24h_vol.toFixed(4);
                else (a = "0.00"), (r = "0.00000000"), (l = "0.00000000"), (o = "0.0000");
                if (0 < e.change) var i = "success";
                else if (e.change < 0) i = "danger";
                else i = "dark";
                var s = serviceURL + "exchange/" + e.from_wallet_short + "-" + e.to_wallet_short;
                d +=
                '<tr><td class="text-left" scope="row"><a title="' +
                e.to_wallet_short +
                "/" +
                e.from_wallet_short +
                '" name="' +
                e.to_wallet_short +
                "/" +
                e.from_wallet_short +
                '" alt="' +
                e.to_wallet_short +
                "/" +
                e.from_wallet_short +
                '" href="' +
                s +
                '">' +
                e.to_wallet_short +
                "/" +
                e.from_wallet_short +
                '</a></td><td class="text-left" scope="row">' +
                e.to_wallet_name +
                '</td><td class="text-right">' +
                e.to_wallet_last_price.toFixed(8) +
                '</td><td class="text-right text-' +
                i +
                '">' +
                a +
                '%</td><td class="text-right">' +
                o +
                '</td><td class="text-right">' +
                r +
                '</td><td class="text-right">' +
                l +
                "</td></tr>";
            }),
            $("#market").html(d);
            var table1 = $('#marketExHome').DataTable( {
                "info":     false,
                "bLengthChange":false,
                "order": [[4, "desc"]],
                "dom": "lrti<'col-sm-12 col-md-7'p>"
            } );
            $('#homepageSearch').on( 'keyup', function () {
                table1.search( this.value ).draw();
            } );




        });
    });
}
