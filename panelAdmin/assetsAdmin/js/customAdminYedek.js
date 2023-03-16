pathname = window.location.pathname.split("/");
pagename = pathname[0];
let web3 = new Web3(Web3.givenProvider);
var base_url = window.location.origin;
const customJS = {
  serviceURL: $("#url").html(),
  wallet: {
    singleWallet: function (id, short) {
      $("#loader111").show();
      $('#myTab a[href="#home"]').trigger("click");
      $.post(customJS.serviceURL + "wallet/singleWallet", {
        short: short,
      }).done(function (data) {
        data = jQuery.parseJSON(data);

        if (!data[0].wallet_server_port) {
          data[0].wallet_server_port = 0;
        }
        $("#wallet_short").val(data[0].wallet_short);
        $("#hideshort").val(data[0].wallet_short);
        $("#hideshort2").val(data[0].wallet_short);
        $("#wallet_name").val(data[0].wallet_name);
        $("#wallet_balance").val(data[0].wallet_balance);
        $("#wallet_system").val(data[0].wallet_system);
        $("#wallet_buy_com").val((data[0].wallet_buy_com - 1).toFixed(5) * 100);
        $("#wallet_with_com").val(data[0].wallet_with_com.toFixed(8));
        $("#wallet_dep_com").val(data[0].wallet_dep_com.toFixed(8));
        $("#wallet_min_dep").val(data[0].wallet_min_dep.toFixed(8));
        $("#wallet_max_dep").val(data[0].wallet_max_dep.toFixed(8));
        $("#wallet_min_with").val(data[0].wallet_min_with.toFixed(8));
        $("#wallet_max_with").val(data[0].wallet_max_with.toFixed(8));
        $("#wallet_conf").val(data[0].wallet_conf);
        $("#wallet_min_bid").val(data[0].wallet_min_bid.toFixed(8));
        $("#wallet_min_unit").val(data[0].wallet_min_unit.toFixed(8));
        $("#wallet_min_total").val(data[0].wallet_min_total.toFixed(8));
        $("#wallet_dep_status").prop(
          "checked",
          parseInt(data[0].wallet_dep_status)
        );
        $("#wallet_with_status").prop(
          "checked",
          parseInt(data[0].wallet_with_status)
        );
        $("#wallet_ex_status").prop(
          "checked",
          parseInt(data[0].wallet_ex_status)
        );
        $("#wallet_status").prop("checked", parseInt(data[0].wallet_status));
        $("#wallet_tag_system").val(data[0].wallet_tag_system);
        $("#wallet_dec").val(data[0].wallet_dec);
        $("#wallet_cont").val(data[0].wallet_cont);
        $("#wallet_main_pairs").val(data[0].wallet_main_pairs);
        $("#wallet_server_username").val(data[0].wallet_server_username);
        $("#wallet_server_pass").val(data[0].wallet_server_pass);
        $("#wallet_server_port").val(data[0].wallet_server_port);
        $("#wallet_password").val(data[0].wallet_password);
        $("#wallet_id").val(data[0].wallet_id);

        if (data[0].wallet_system == "fiat") {
          $("#fiat-tab").show();
          $("#walletBankaTable").DataTable().destroy();
          $.post(customJS.serviceURL + "wallet/fiat", {
            short: short,
          }).done(function (data2) {
            data2 = jQuery.parseJSON(data2);
            var listbanka = "";
            if (data2.durum != "error") {
              $.each(data2, function (index, bankalar) {
                if (bankalar.banka_status == 0) {
                  var durum_bs = "OFF",
                    color_bs = "danger";
                } else {
                  var durum_bs = "ON",
                    color_bs = "success";
                }
                listbanka +=
                  "<tr>" +
                  "<td>" +
                  bankalar.banka_id +
                  "</td>" +
                  "<td>" +
                  bankalar.banka_name +
                  "</td>" +
                  "<td>" +
                  bankalar.banka_iban +
                  "</td>" +
                  "<td>" +
                  bankalar.banka_hesap +
                  "</td>" +
                  '<td><select id="' +
                  bankalar.banka_id +
                  '" class="custom-select custom-select-sm" onChange="customJS.wallet.walletBankUpdate(this.id)">' +
                  '<option value="' +
                  bankalar.banka_status +
                  '">' +
                  durum_bs +
                  "</option>" +
                  '<option value="1">ON</option><option value="0">OFF</option>' +
                  "</select></i></td>" +
                  "</tr>";
              });
              $("#walletBanka").html(listbanka);
              $("#walletBankaTable").DataTable({
                order: [[1, "desc"]],
                responsive: {
                  details: {
                    renderer: function (api, rowIdx, columns) {
                      var data = $.map(columns, function (col, i) {
                        return col.hidden
                          ? '<tr data-dt-row="' +
                              col.rowIndex +
                              '" data-dt-column="' +
                              col.columnIndex +
                              '">' +
                              "<td>" +
                              col.title +
                              ":" +
                              "</td> " +
                              "<td>" +
                              col.data +
                              "</td>" +
                              "</tr>"
                          : "";
                      }).join("");

                      return data ? $("<table/>").append(data) : false;
                    },
                  },
                },
              });
            } else {
              $("#fiat-tab").hide();
            }
          });
        } else {
          $("#fiat-tab").hide();
        }
        /* wallet info detail page*/
        $("#wallet_short2").html(data[1].wallet_short);
        $("#wallet_info_name").val(data[1].wallet_info_name);
        $("#wallet_info_website").val(data[1].wallet_info_website);
        $("#wallet_info_chat").val(data[1].wallet_info_chat);
        $("#wallet_info_social").val(data[1].wallet_info_social);
        $("#wallet_info_explorer").val(data[1].wallet_info_explorer);
        $("#wallet_info_cmc").val(data[1].wallet_info_cmc);
        $("#wallet_info_maxsub").val(data[1].wallet_info_maxsub);
        $("#wallet_info").summernote("code", data[1].wallet_info);
        document.getElementById("walletlogo").src =
          "/assets/home/images/logo/" + data[0].wallet_logo;
        /* markets*/
        var listmarketNew = "";
        var listmarketNewDecimal = "";
        var check = "";
        $.each(data[2], function (index, m) {
          $.post(customJS.serviceURL + "wallet/walletMarketSor", {
            fromshort: m.wallet_short,
            toshort: data[0].wallet_short,
          }).done(function (data3) {
            if(m.wallet_short!=data[0].wallet_short){
            data3 = jQuery.parseJSON(data3);
            console.log(data3)
            $("#market_status" + data3.short).val(data3.durum.market_status);
            if (data3.durum.market_status == 1) {
              check = "checked";
            } else {
              check = "";
            }
            if(data3.durum.market_status){
            listmarketNewDecimal +=
            '<div class="col-12 col-lg-3">'+
            '<label>'+m.wallet_short+data[0].wallet_short+'</label>'+
            '<form>'+
              '<div class="form-group">'+
              '<label for="priceDecimal">Price Decimal</label>'+
              '<input type="number" class="form-control" id="priceDecimal'+m.wallet_short+data[0].wallet_short+'" value="'+data3.durum.priceDecimal+'" required>'+
              '</div>'+
              '<div class="form-group">'+
              '<label for="amountDecimal">Amount Decimal</label>'+
              '<input type="number" class="form-control" id="amountDecimal'+m.wallet_short+data[0].wallet_short+'" value="'+data3.durum.amountDecimal+'" required>'+
              '</div>'+
              '<div class="form-group">'+
              '<label for="totalDecimal">Total Decimal</label>'+
              '<input type="number" class="form-control" id="totalDecimal'+m.wallet_short+data[0].wallet_short+'" value="'+data3.durum.totalDecimal+'" required>'+
              '</div>'+
              '<button type="button"  onclick="customJS.wallet.marketDecimal(\''+m.wallet_short+'\', \''+data[0].wallet_short+'\')" class="btn btn-primary">Submit</button>'+
              '</form>'+
              '</div>'
              $("#marketsWalletDecimal").html(listmarketNewDecimal);
            }
              
            var pairId = m.wallet_main_pairs;
            listmarketNew +=
              '<div class="col-12"><div class="form-check form-check-inline"><input class="form-check-input" id="checkBoxMarket' +
              m.wallet_short +
              '" onclick="customJS.wallet.walletMarketUpdate(this.id,\'' + m.wallet_short +
              "'," +
              m.wallet_id +
              "," +
              pairId +
              ')" type="checkbox" id="inlineCheckbox1" value="option1" ' +
              check +
              '><label class="form-check-label" for="inlineCheckbox1">' +
              m.wallet_name +
              "</label></div></div>";
            $("#marketsWalletPageNew").html(listmarketNew);
          }
          });

          /*listmarket += '<label for="market_status">'+m.wallet_name+' Market</label>'
                    +'<select  id="market_status'+m.wallet_short+'" onChange="customJS.wallet.walletMarketUpdate(this.id,\''+m.wallet_short+'\','+m.wallet_id+')" class="custom-select custom-select-sm">'
                        +'<option value="0">OFF</option>'
                        +'<option value="1">ON</option>'
                    +'</select>';*/
        });
        //$('#marketsWalletPage').html(listmarket);

        $("#walletInfo").show("slow");
        $("#loader111").hide();
        $("html, body").animate({ scrollTop: $(id).offset().top }, 1000);

        //Result Tab
        var walletBalance = data[0].wallet_balance;
        $("#walletResultTable").DataTable().destroy();
        $.post(customJS.serviceURL + "wallet/walletTotalResult", {
          walletshort: data[0].wallet_short,
        }).done(function (data4) {
          data4 = jQuery.parseJSON(data4);
          var walletresult = (
            walletBalance -
            (data4.openorder + data4.userwallet + data4.withdrawP)
          ).toFixed(8);
          if (walletresult < 0) {
            document.getElementById("wallet_result").style.color = "red";
          } else {
            document.getElementById("wallet_result").style.color = "green";
          }
          $("#deposit_result").html(data4.deposit.toFixed(8));
          $("#withdraw_result").html(data4.withdraw.toFixed(8));
          $("#openorders_result").html(data4.openorder.toFixed(8));
          $("#userwallet_result").html(data4.userwallet.toFixed(8));
          $("#wallet_balance_result").html(walletBalance.toFixed(8));
          $("#wallet_result").html(walletresult);

          $("#walletResultTable").DataTable({
            responsive: true,
          });
        });

        $("#walletUserTable").DataTable().destroy();
        var listWalletUser = "";
        $.post(customJS.serviceURL + "wallet/walletUserBalance", {
          walletshort: data[0].wallet_short,
        }).done(function (data5) {
          data5 = jQuery.parseJSON(data5);
          //console.log(data5);
          $.each(data5, function (index, WUser) {
            listWalletUser +=
              "<tr>" +
              "<td>" +
              WUser.wallet_user_email +
              "</td>" +
              "<td>" +
              WUser.wallet_user_id +
              "</td>" +
              "<td ondblclick=\"customJS.wallet.addInputWalletUser(this,'" +
              data[0].wallet_short +
              "','" +
              WUser.wallet_user_id +
              "','" +
              WUser.wallet_user_email +
              "')\">" +
              WUser.wallet_user_balance.toFixed(8) +
              "</td>" +
              "</tr>";
          });
          $("#walletUserBalance").html(listWalletUser);
          $("#walletUserTable").DataTable({
            order: [[2, "desc"]],
            responsive: true,
          });
        });

        //buraya deposit

        //buraya withdraw
      });
    },
    walletSingleDepositWithdraw: function (DW) {
      if (DW == 1) {
        var short = $("#wallet_short").val();
        socket.emit("depositVeriWalletPage", { wallet: short, size: 100 });
        socket.on("depositVeriWalletPage", function (dep1) {
          //console.log(dep1);
          $("#walletDepositDataTableWalletPage").DataTable().destroy();
          var veriDep = "";
          $.each(dep1.data.veri, function (index, dep) {
            var odelete =
              '<span class="badge badge-info cursor-pointer" onclick="customJS.wallet.depositDelete(\'' +
              dep.dep_history_id +
              "')\">Delete</span>";
            if (
              dep.dep_history_system == "fiat" &&
              dep.dep_history_status != 1
            ) {
              var onayFiat =
                '<span class="badge badge-warning cursor-pointer" data-toggle="modal" data-target="#sendModal" onclick="customJS.wallet.fiatDepositOnayla(\'' +
                dep.dep_history_user_email +
                "','" +
                dep.dep_history_txid +
                "','" +
                dep.dep_history_user_id +
                "','" +
                dep.dep_history_id +
                "','" +
                dep.dep_history_wallet_short +
                "')\"> Confirm</span>";
            } else {
              onayFiat = "";
            }
            if (dep.dep_history_status != 1) {
              var durum =
                ' <i class="spinner-border text-success spinner-border-sm text-warning"><span class="d-none">0</span></i>(' +
                dep.dep_history_comfirmation +
                ")";
            } else {
              var durum =
                '<i class="fa fa-check-circle text-success"><span class="d-none">1</span></i>';
            }
            veriDep +=
              '<tr id="' +
              dep.dep_history_id +
              '">' +
              "<td>" +
              dep.dep_history_wallet_short +
              "</td>" +
              "<td ondblclick=\"customJS.wallet.addInputWallet(this,'" +
              dep.dep_history_id +
              "',3,'dep_history_amount','" +
              dep.dep_history_user_id +
              "')\">" +
              dep.dep_history_amount.toFixed(8) +
              "</td>" +
              "<td>" +
              dep.dep_history_user_email +
              "</td>" +
              "<td>" +
              durum +
              onayFiat +
              "</td>" +
              "<td>" +
              dep.dep_history_txid +
              "</td>" +
              '<td><span class="d-none">' +
              dep.dep_history_time +
              "</span>" +
              new Date(dep.dep_history_time * 1000).toLocaleString() +
              "</td>" +
              "<td>" +
              dep.dep_history_system +
              "</td>" +
              "<td>" +
              dep.dep_history_address +
              "</td>" +
              "<td>" +
              dep.dep_history_tag +
              "</td>" +
              "<td>" +
              dep.dep_history_user_id +
              "</td>" +
              "<td>" +
              dep.dep_history_id +
              "</td>" +
              "<td>" +
              odelete +
              "</td>" +
              "</tr>";
          });
          $("#depositVeriWalletPage").html(veriDep);
          $("#walletDepositDataTableWalletPage").DataTable({
            bLengthChange: false,
            info: false,
            order: [
              [3, "asc"],
              [5, "desc"],
            ],
            responsive: {
              details: {
                renderer: function (api, rowIdx, columns) {
                  var data = $.map(columns, function (col, i) {
                    return col.hidden
                      ? '<tr data-dt-row="' +
                          col.rowIndex +
                          '" data-dt-column="' +
                          col.columnIndex +
                          '">' +
                          "<td>" +
                          col.title +
                          ":" +
                          "</td> " +
                          "<td>" +
                          col.data +
                          "</td>" +
                          "</tr>"
                      : "";
                  }).join("");

                  return data ? $("<table/>").append(data) : false;
                },
              },
            },
          });
        });
      } else if (DW == 2) {
        var short = $("#wallet_short").val();
        socket.emit("withdrawVeriWalletPage", { wallet: short, size: 100 });
        socket.on("withdrawVeriWalletPage", function (with1) {
          $("#walletWithdrawDataTableWalletPage").DataTable().destroy();
          var veriWith = "";
          $.each(with1.data, function (index, with2) {
            $("body").tooltip({ selector: "[data-toggle=tooltip]" });
            if (with2.withdraw_status == "0") {
              var durum =
                '<span class="d-none">0</span><span class="badge badge-warning cursor-pointer" data-toggle="modal" data-target="#sendModal" onclick="customJS.wallet.walletSendModal(\'' +
                with2.withdraw_id +
                "','" +
                with2.withdraw_user_email +
                "','" +
                with2.withdraw_user_id +
                "','" +
                with2.withdraw_address +
                "','" +
                with2.withdraw_cont +
                "','" +
                with2.withdraw_tag +
                "','" +
                with2.withdraw_wallet_short +
                "'," +
                with2.withdraw_amount +
                ",'" +
                with2.withdraw_txid +
                "',1)\">Send</span>";
            } else if (with2.withdraw_status == "2") {
              var durum =
                '<i class="fa fa-times-circle text-warning" data-toggle="tooltip" data-placement="left" title="The withdrawal was cancelled."><span class="d-none">2</span></i>';
            } else if (with2.withdraw_status == "3") {
              var durum =
                '<i class="fa fa-times-circle text-danger" data-toggle="tooltip" data-placement="left" title="The withdrawal was deleted."><span class="d-none">2</span></i>';
            } else if (with2.withdraw_status == "1") {
              var durum =
                '<i class="fa fa-check-circle text-success" data-toggle="tooltip" data-placement="left" title="Withdrawal completed."><span class="d-none">1</span></i>';
            }
            veriWith +=
              "<tr>" +
              "<td>" +
              with2.withdraw_wallet_short +
              "</td>" +
              "<td>" +
              with2.withdraw_user_email +
              "</td>" +
              "<td>" +
              with2.withdraw_amount.toFixed(8) +
              "</td>" +
              "<td>" +
              durum +
              "</td>" +
              '<td><span class="d-none">' +
              with2.withdraw_time +
              "</span>" +
              new Date(with2.withdraw_time * 1000).toLocaleString() +
              "</td>" +
              "<td>" +
              with2.withdraw_address +
              "</td>" +
              "<td>" +
              with2.withdraw_tag +
              "</td>" +
              "<td>" +
              with2.withdraw_cont +
              "</td>" +
              "<td>" +
              with2.withdraw_txid +
              "</td>" +
              "<td>" +
              with2.withdraw_id +
              "</td>" +
              "<td>" +
              with2.withdraw_user_id +
              "</td>" +
              "<td>" +
              with2.withdraw_system +
              "</td>" +
              "</tr>";
          });

          $("#withdrawVeriWalletPage").html(veriWith);
          $("#walletWithdrawDataTableWalletPage").DataTable({
            bLengthChange: false,
            info: false,
            order: [
              [3, "asc"],
              [4, "desc"],
            ],
            responsive: {
              details: {
                renderer: function (api, rowIdx, columns) {
                  var data = $.map(columns, function (col, i) {
                    return col.hidden
                      ? '<tr data-dt-row="' +
                          col.rowIndex +
                          '" data-dt-column="' +
                          col.columnIndex +
                          '">' +
                          "<td>" +
                          col.title +
                          ":" +
                          "</td> " +
                          "<td>" +
                          col.data +
                          "</td>" +
                          "</tr>"
                      : "";
                  }).join("");

                  return data ? $("<table/>").append(data) : false;
                },
              },
            },
          });
        });
      }
    },

    tabloLimit: function (limit, table) {
      //console.log(table);
      $("ul li").click(function () {
        $("li").removeClass("active");
        $(this).addClass("active");
      });
      socket.emit(table, { pageNo: 1, size: limit });
    },
    walletUpdate: function (id, t, k) {
      var r = confirm(" Update Confirm?");
      if (r == true) {
        if (k == 5) {
          var veri = document.getElementById(id).value;
        } else if (k == 4) {
          if (document.getElementById(id).checked == true) {
            var veri = 1;
          } else {
            var veri = 0;
          }
        } else {
          var veri = $("#" + id).val();
        }

        $.post(customJS.serviceURL + "wallet/walletUpdate", {
          short: $("#hideshort").val(),
          satir: id,
          veri: veri,
          type: t,
        }).done(function (data) {
          data = jQuery.parseJSON(data);
          $("#hideshort").val($("#wallet_short").val());
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      } else {
        return;
      }
    },

    walletUpdateInfo: function (id, t) {
      var r = confirm(" Update Confirm?");
      if (r == true) {
        var veri = $("#" + id).val();
        $.post(customJS.serviceURL + "wallet/walletUpdateInfo", {
          short: $("#wallet_short").val(),
          satir: id,
          veri: veri,
          type: t,
        }).done(function (data) {
          data = jQuery.parseJSON(data);
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      }
    },

    walletUpdateWalletInfo: function () {
      var r = confirm("Confirm?");
      if (r == true) {
        setTimeout(function () {
          $.post(customJS.serviceURL + "wallet/walletUpdateInfo", {
            short: $("#wallet_short").val(),
            satir: "wallet_info",
            veri: $("#wallet_info").val(),
            type: "1",
          }).done(function (data) {
            data = jQuery.parseJSON(data);
            $.toast({
              heading: "Information",
              text: data.mesaj,
              icon: data.durum,
              loader: true,
              loaderBg: "#9fd5ff",
              showHideTransition: "plain",
              position: "bottom-right",
              hideAfter: 5000,
            });
          });
        }, 200);
      }
    },

    walletMarketUpdate: function (id, short, walletID, pairId) {
      var r = confirm(" Update Confirm?");
      if (r == true) {
        var veri = document.getElementById(id);

        if (veri.checked == true) {
          var durum = 1;
          var Id = pairId;
        } else {
          var durum = 0;
          var Id = 0;
        }
        $.post(customJS.serviceURL + "wallet/walletMarketUpdate", {
          short: short,
          toshort: $("#wallet_short").val(),
          veri: durum,
          walletID: walletID,
          toWalletID: $("#wallet_id").val(),
          toWalletName: $("#wallet_name").val(),
          pairId: Id,
        }).done(function (data) {
          data = jQuery.parseJSON(data);
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      } else {
        return;
      }
    },
    marketDecimal: function (from, to) {
      console.log(from, to);
      console.log($("#priceDecimal"+from+to).val(), $("#amountDecimal"+from+to).val()); 
      if (1 == confirm(" Update Confirm?")) {
          $.post(customJS.serviceURL + "wallet/walletMarketUpdateDecimal", { 
            short: from,
            toshort: to, 
            priceDec: $("#priceDecimal"+from+to).val(), 
            amountDec: $("#amountDecimal"+from+to).val(), 
            totalDec: $("#totalDecimal"+from+to).val()
          }).done(
              function (e) {
                  (e = jQuery.parseJSON(e)), $.toast({ heading: "Information", text: e.mesaj, icon: e.durum, loader: !0, loaderBg: "#9fd5ff", showHideTransition: "plain", position: "bottom-right", hideAfter: 5e3 });
              }
          );
      }
    },

    walletSendModal: async function (
      withdrawid,
      useremail,
      userid,
      address,
      cont,
      tag,
      short,
      amount,
      txid,
      wallet,
      decimals,
      network,
      fee,
      sendoption
    ) {
      $("#sendid").val(withdrawid);
      $("#sendaddress").val(address);
      $("#senduseremail").val(useremail);
      $("#senduserid").val(userid);
      $("#sendaddress").val(address);
      $("#sendcont").val(cont);
      $("#sendtag").val(tag);
      $("#sendamount").val(amount.toFixed(8));
      $("#sendshort").html(short);
      $("#sendoption").val(sendoption);
      $("#sendtxid").val(txid);
      $("#sendWallet").val(wallet);
      $("#sendDecimals").val(decimals);
      $("#sendNetwork").val(network);
      $("#sendfee").val(fee.toFixed(8));
      $("#sendtotal").val((amount.toFixed(8) - fee.toFixed(8)).toFixed(8));

      if (sendoption == 2) {
        $("#againAlert").show();
      } else {
        $("#againAlert").hide();
      }

      const currentNetwork = web3.currentProvider.networkVersion;
      if (currentNetwork !== network.toString()) {
        try {
          // show error when trying to switch to ethereum
          if (network.toString() === "1") {
            // only on production networks
            if (currentNetwork !== "4") {
              throw new Error("Please switch manually to Ethereum network");
            }
          } else {
            if (currentNetwork !== "97") {
              await customJS.wallet.switchToBinance(wallet, short, decimals);
            }
          }

          const fromAddress = await customJS.wallet.getCurrentAddress();
          if (network.toString() === "1" || network.toString() === "4") {
            // check ethereum
            await customJS.wallet.getWalletBalance(
              cont,
              fromAddress,
              short,
              decimals
            );
          } else {
            // check binance
            await customJS.wallet.getWalletBalance(
              cont,
              fromAddress,
              short,
              decimals
            );
          }
        } catch (error) {
          $("#balanceMetamask").text("N/A");

          let message = error.message;
          if (error.message.includes("invalid number value")) {
            message = "Invalid amount value";
          }
          if (error.message.includes("not a positive number.")) {
            message = "Amount value must be positive";
          }

          $.toast({
            heading: "",
            text: message,
            icon: "error",
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        }
      }
    },
    getWalletBalance: async (
      walletContract,
      fromAddress,
      walletShort,
      walletDecimals
    ) => {
      if (!walletContract.toString().startsWith("0x")) {
        let balance = await web3.eth.getBalance(fromAddress); //, function(err, balance) {
        balance =
          web3.extend.utils.fromWei(balance, "ether") + ` ${walletShort}`;
        $("#balanceMetamask").text(balance);
      } else {
        const minABI = [
          // balance
          {
            constant: true,
            inputs: [{ name: "_owner", type: "address" }],
            name: "balanceOf",
            outputs: [{ name: "balance", type: "uint256" }],
            type: "function",
          },
          // decimals
          {
            constant: true,
            inputs: [],
            name: "decimals",
            outputs: [{ name: "", type: "uint8" }],
            type: "function",
          },
        ];

        const contract = new web3.eth.Contract(minABI, walletContract);

        let balance = await contract.methods.balanceOf(fromAddress).call();
        balance = eval(balance / walletDecimals).toString() + ` ${walletShort}`;
        $("#balanceMetamask").text(balance);
      }
    },

    walletCancelModal: function (
      withdrawid,
      useremail,
      userid,
      address,
      cont,
      tag,
      short,
      amount,
      canceloption
    ) {
      //console.log(address,tag,short,amount);
      $("#cancelid").val(withdrawid);
      $("#canceladdress").val(address);
      $("#canceluseremail").val(useremail);
      $("#canceluserid").val(userid);
      $("#canceladdress").val(address);
      $("#cancelcont").val(cont);
      $("#canceltag").val(tag);
      $("#cancelamount").val(amount.toFixed(8));
      $("#cancelshort").html(short);
      $("#canceloption").val(canceloption);
      if (canceloption == 2) {
        console.log(canceloption);
        $("#cancelAlert").show();
      }
    },

    walletDeleteModal: function (
      withdrawid,
      useremail,
      userid,
      address,
      cont,
      tag,
      short,
      amount,
      deleteoption
    ) {
      //console.log(address,tag,short,amount);
      $("#deleteid").val(withdrawid);
      $("#deleteuseremail").val(useremail);
      $("#deleteuserid").val(userid);
      $("#deleteamount").val(amount.toFixed(8));
      $("#deleteshort").html(short);
      if (deleteoption == 2) {
        $("#deleteAlert").show();
      }
    },

    walletChangeType: function (id) {
      var type = $("#" + id).attr("type");
      if (type == "password") {
        $("#" + id).prop("type", "text");
      } else if (type == "text") {
        $("#" + id).prop("type", "password");
      }
    },

    uyrtcvsgw237dsadhbczxa: function () {
      var withid = $("#sendid").val();
      var sendoption = $("#sendoption").val();
      var withuserid = $("#senduserid").val();
      var withuseremail = $("#senduseremail").val();
      var withtxid = $("#sendtxid").val();
      var withamount = $("#sendamount").val();
      var withaddress = $("#sendaddress").val();
      var withcont = $("#sendcont").val();
      var withtag = $("#sendtag").val();
      var walletShort = $("#sendshort").html();
      var googleCode = $("#sendKey").val();
      document.getElementById("sendButton").innerHTML = "Loading..";
      document.getElementById("sendButton").disabled = true;
      $.post(customJS.serviceURL + "wallet/sendWithdrawTransaction", {
        withid: withid,
        withuserid: withuserid,
        withuseremail: withuseremail,
        withtxid: withtxid,
        withamount: withamount,
        withaddress: withaddress,
        withtag: withtag,
        walletShort: walletShort,
        googleCode: googleCode,
        sendoption: sendoption,
        withcont: withcont,
      }).done(function (data) {
        data = jQuery.parseJSON(data);
        if (data.durum == "xrpSend") {
          window.open(
            "http://" +
              $("#urlw").val() +
              "xrp/yeni.php?amount=" +
              withamount +
              "&address=" +
              withaddress +
              "&tag=" +
              withtag +
              "&code=" +
              googleCode +
              "&key=" +
              data.key +
              "&enckey=a41d8cd98f00b204e9800998fcf8427e&sec=" +
              data.sec,
            "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=500,width=700,height=400"
          );
          document.getElementById("sendButton").innerHTML = "Send";
          document.getElementById("sendButton").disabled = false;
        } else {
          if (data.durum == "result") {
            $("#sendModal").modal("hide");
            $("#resultModal").modal("show");
            $("#resultTxid").html(" TxID : " + data.mesaj.txid);
            if (data.mesaj.error && data.mesaj.error !== "null") {
              $("#resultError").html("Error : " + data.mesaj.error);
            }
            document.getElementById("sendButton").innerHTML = "Send";
            document.getElementById("sendButton").disabled = false;
            var socket = io.connect(socketUrl);
            socket.emit("withdrawVeri", { pageNo: 1, size: 100 });
          } else {
            document.getElementById("sendButton").innerHTML = "Send";
            document.getElementById("sendButton").disabled = false;
            $.toast({
              heading: "Information",
              text: data.mesaj,
              icon: data.durum,
              loader: true,
              loaderBg: "#9fd5ff",
              showHideTransition: "plain",
              position: "bottom-right",
              hideAfter: 5000,
            });
          }
        }
      });
    },
    registerWithdraw: function () {
      var withid = $("#sendid").val();
      var sendoption = $("#sendoption").val();
      var withuserid = $("#senduserid").val();
      var withuseremail = $("#senduseremail").val();
      var withtxid = $("#sendtxid").val();
      var withamount = $("#sendamount").val();
      var withaddress = $("#sendaddress").val();
      var withcont = $("#sendcont").val();
      var withtag = $("#sendtag").val();
      var walletShort = $("#sendshort").html();
      document.getElementById("sendButton").innerHTML = "Loading..";
      document.getElementById("sendButton").disabled = true;
      $.post(customJS.serviceURL + "wallet/registerWithdraw", {
        withid: withid,
        withuserid: withuserid,
        withuseremail: withuseremail,
        withtxid: withtxid,
        withamount: withamount,
        withaddress: withaddress,
        withtag: withtag,
        walletShort: walletShort,
        sendoption: sendoption,
        withcont: withcont,
      }).done(function (data) {
        data = jQuery.parseJSON(data);
        if (data.durum == "xrpSend") {
          window.open(
            "http://" +
              $("#urlw").val() +
              "xrp/yeni.php?amount=" +
              withamount +
              "&address=" +
              withaddress +
              "&tag=" +
              withtag +
              "&code=" +
              googleCode +
              "&key=" +
              data.key +
              "&enckey=a41d8cd98f00b204e9800998fcf8427e&sec=" +
              data.sec,
            "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=500,width=700,height=400"
          );
          document.getElementById("sendButton").innerHTML = "Send";
          document.getElementById("sendButton").disabled = false;
        } else {
          if (data.durum == "result") {
            $("#sendModal").modal("hide");
            $("#resultModal").modal("show");
            $("#resultTxid").html(" TxID : " + data.mesaj.txid);
            if (data.mesaj.error && data.mesaj.error !== "null") {
              $("#resultError").html("Error : " + data.mesaj.error);
            }
            document.getElementById("sendButton").innerHTML = "Send";
            document.getElementById("sendButton").disabled = false;
            var socket = io.connect(socketUrl);
            socket.emit("withdrawVeri", { pageNo: 1, size: 100 });
          } else {
            document.getElementById("sendButton").innerHTML = "Send";
            document.getElementById("sendButton").disabled = false;
            $.toast({
              heading: "Information",
              text: data.mesaj,
              icon: data.durum,
              loader: true,
              loaderBg: "#9fd5ff",
              showHideTransition: "plain",
              position: "bottom-right",
              hideAfter: 5000,
            });
          }
        }
      });
    },

    withdrawCancelTransactions: function () {
      var withid = $("#cancelid").val();
      var withuserid = $("#canceluserid").val();
      var withtxid = $("#canceltxid").val();
      var withamount = $("#cancelamount").val();
      var withaddress = $("#canceladdress").val();
      var googleCode = $("#cancelKey").val();
      var coinShort = $("#cancelshort").html();
      console.log(
        withid,
        withuserid,
        withtxid,
        withamount,
        withaddress,
        googleCode,
        coinShort
      );

      $.post(customJS.serviceURL + "wallet/cancelWithdrawTransaction", {
        withid: withid,
        withuserid: withuserid,
        withtxid: withtxid,
        withamount: withamount,
        withaddress: withaddress,
        googleCode: googleCode,
        coinShort: coinShort,
      }).done(function (data) {
        data = jQuery.parseJSON(data);
        if (data.durum == "success") {
          $("#cancelModal").modal("hide");
          var socket = io.connect(socketUrl);
          socket.emit("withdrawVeri", { pageNo: 1, size: 100 });
        }
        $.toast({
          heading: "Information",
          text: data.mesaj,
          icon: data.durum,
          loader: true,
          loaderBg: "#9fd5ff",
          showHideTransition: "plain",
          position: "bottom-right",
          hideAfter: 5000,
        });
      });
    },

    withdrawDeleteTransactions: function () {
      var withid = $("#deleteid").val();
      var withuserid = $("#deleteuserid").val();
      var withtxid = $("#deletetxid").val();
      var googleCode = $("#deleteKey").val();
      $.post(customJS.serviceURL + "wallet/deleteWithdrawTransaction", {
        withid: withid,
        withuserid: withuserid,
        withtxid: withtxid,
        googleCode: googleCode,
      }).done(function (data) {
        data = jQuery.parseJSON(data);
        if (data.durum == "success") {
          $("#cancelModal").modal("hide");
          $("#walletWithdrawDataTable").DataTable().destroy();
          socket.emit("withdrawVeri", { pageNo: 1, size: 100 });
        }
        $.toast({
          heading: "Information",
          text: data.mesaj,
          icon: data.durum,
          loader: true,
          loaderBg: "#9fd5ff",
          showHideTransition: "plain",
          position: "bottom-right",
          hideAfter: 5000,
        });
      });
    },

    doubleClick: function (id) {
      //console.log(id);
      $("#" + id).attr("readonly", !$("#" + id).attr("readonly"));
    },

    allWalletSelect: function (id) {
      var select = document.getElementById(id).value;
      var veri = select.split("-");
      if (veri[0] == "0") {
        $("#selectInput").show();
        $("#textInput").hide();
      } else if (veri[0] == "1") {
        $("#textInput").show();
        $("#selectInput").hide();
      }
      $("#selectOption").val(veri[1]);
      //console.log(veri[0],veri[1]);
    },

    allWalletChange: function (id, type) {
      var person = prompt("Please enter the Google 2FA code");
      if (person == null || person == "") {
        $("#select_input").val("");
        return;
      } else {
        if (type == 5) {
          var deger = document.getElementById(id).value;
          var ttt = 1;
        } else if (type == 1) {
          var deger = $("#" + id).val();
          var ttt = 2;
        }
        var sutun = $("#selectOption").val();
        //console.log(deger,sutun);

        $.post(customJS.serviceURL + "wallet/allwalletchange", {
          sutun: sutun,
          deger: deger,
          googleCode: person,
          ttt: ttt,
        }).done(function (data) {
          data = jQuery.parseJSON(data);
          if (data.durum == "error") {
            $("#select_input").val("");
          }
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      }
    },
    walletBankUpdate: function (bankid) {
      var status = document.getElementById(bankid).value;
      var r = confirm(" Update Confirm?");
      if (r == true) {
        $.post(customJS.serviceURL + "wallet/walletBankUpdate", {
          bankid: bankid,
          status: status,
        }).done(function (data) {
          data = jQuery.parseJSON(data);
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      }
    },
    fiatDepositOnayla: function (email, islemcode, userid, depid, walletShort) {
      var person = prompt("Confirm! Please enter the Google 2FA code");
      if (person == null || person == "") {
        $("#select_input").val("");
        return;
      } else {
        $.post(customJS.serviceURL + "wallet/fiatDepositConfirm", {
          email: email,
          islemcode: islemcode,
          googleCode: person,
          userid: userid,
          depid: depid,
          walletShort: walletShort,
        }).done(function (data) {
          var socket = io.connect(socketUrl);
          socket.emit("depositVeri", { pageNo: 1, size: 100 });
          data = jQuery.parseJSON(data);
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      }
    },

    addInputWallet: function (elm, veriID, veri1, veri2, userID) {
      if (elm.getElementsByTagName("input").length > 0) return;

      var value = elm.innerHTML;
      elm.innerHTML = "";
      var input = document.createElement("input");
      input.setAttribute("type", "text");
      input.setAttribute("value", value);
      input.setAttribute(
        "onBlur",
        "customJS.wallet.closeInputWallet(this,'" +
          veriID +
          "'," +
          value +
          ",'" +
          veri1 +
          "','" +
          veri2 +
          "','" +
          userID +
          "')"
      );
      elm.appendChild(input);
      input.focus();
    },

    closeInputWallet: function (elm, veriID, oldvalue, veri1, veri2, userID) {
      var td = elm.parentNode;
      var value = parseFloat(elm.value).toFixed(8);
      var person = prompt("Please enter the Google 2FA code");
      if (person == null || person == "") {
        td.removeChild(elm);
        td.innerHTML = oldvalue.toFixed(8);
      } else {
        $.post(customJS.serviceURL + "wallet/walletDepositChange", {
          userid: userID,
          veri: value,
          veriID: veriID,
          googleCode: person,
          type: veri1,
          sutun: veri2,
        }).done(function (data) {
          data = jQuery.parseJSON(data);
          if (data.durum == "success") {
            td.removeChild(elm);
            td.innerHTML = value;
          } else {
            td.removeChild(elm);
            td.innerHTML = oldvalue.toFixed(8);
          }
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      }
    },

    addInputWalletUser: function (elm, short, userID, userEmail) {
      if (elm.getElementsByTagName("input").length > 0) return;

      var value = elm.innerHTML;
      elm.innerHTML = "";
      var input = document.createElement("input");
      input.setAttribute("type", "text");
      input.setAttribute("value", value);
      input.setAttribute(
        "onBlur",
        "customJS.wallet.closeInputWalletUser(this,'" +
          short +
          "'," +
          value +
          ",'" +
          userID +
          "','" +
          userEmail +
          "',)"
      );
      elm.appendChild(input);
      input.focus();
    },

    closeInputWalletUser: function (elm, short, oldvalue, userID, userEmail) {
      var td = elm.parentNode;
      var value = parseFloat(elm.value).toFixed(8);
      var person = prompt("Please enter the Google 2FA code");
      if (person == null || person == "") {
        td.removeChild(elm);
        td.innerHTML = oldvalue.toFixed(8);
      } else {
        $.post(customJS.serviceURL + "user/userWalletBalanceUpdate", {
          userid: userID,
          useremail: userEmail,
          balance: value,
          short: short,
          googleCode: person,
        }).done(function (data) {
          //console.log(value,short,person,$("#user_id").html(),$("#user_email").html());
          data = jQuery.parseJSON(data);
          if (data.durum == "success") {
            td.removeChild(elm);
            td.innerHTML = value;
          } else {
            td.removeChild(elm);
            td.innerHTML = oldvalue.toFixed(8);
          }
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      }
    },

    orderwalletSelect: function (id, val) {
      var res = val.split("-");
      var selectWallet = [res[0], res[1]];
      var socket = io.connect(socketUrl);
      socket.emit("orderBookAll", selectWallet);
    },

    tradewalletSelect: function (id, val) {
      var res = val.split("-");
      var selectWallet = [res[0], res[1]];
      var socket = io.connect(socketUrl);
      socket.emit("tradehistoryAll", selectWallet);
    },

    cancelOpenOrder: function (userEmail, userID, orderID, time) {
      var person = prompt("Please enter the Google 2FA code");
      if (person == null || person == "") {
        return;
      } else {
        $.post(customJS.serviceURL + "wallet/cancelOpenOrder", {
          email: userEmail,
          userID: userID,
          orderID: orderID,
          time: time,
          googleCode: person,
        }).done(function (data) {
          data = jQuery.parseJSON(data);
          if (data.durum == "success") {
            $("#" + orderID).hide("slow");
          }
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      }
    },
    depositDelete: function (deposiId) {
      var person = prompt("Please enter the Google 2FA code");
      if (person == null || person == "") {
        return;
      } else {
        $.post(customJS.serviceURL + "wallet/deleteDeposit", {
          deposiId: deposiId,
          googleCode: person,
        }).done(function (data) {
          data = jQuery.parseJSON(data);
          if (data.durum == "success") {
            $("#" + deposiId).hide("slow");
          }
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      }
    },

    // TODO: start

    // window.onload = () => {
    //   if (typeof window.ethereum === 'undefined') {
    //     $.toast({
    //       heading: '',
    //       text: 'Metamask is not accessible',
    //       icon: "error",
    //       loader: true,
    //       loaderBg: '#9fd5ff',
    //       showHideTransition: 'plain',
    //       position: 'bottom-right',
    //       hideAfter: 5000
    //     });
    //   }
    // }

    depositMetamask: async () => {
      const id = $("#sendid").val();
      const toAddress = $("#sendaddress").val();
      const sendEmail = $("#senduseremail").val();
      const sendUserId = $("#senduserid").val();
      const walletContract = $("#sendcont").val();
      const sendTag = $("#sendtag").val();
      const sendAmount = $("#sendtotal").val();
      const walletShort = $("#sendshort").html();
      const sendOption = $("#sendoption").val();
      const sendTxId = $("#sendtxid").val();
      const wallet = $("#sendWallet").val();
      const walletDecimals = $("#sendDecimals").val();
      const walletNetwork = $("#sendNetwork").val();
      const apiUrl = `${base_url}/api`;
      const web3 = new Web3(Web3.givenProvider);
      const fromAddress = await customJS.wallet.getCurrentAddress();

      try {
        let amount = sendAmount;
        amount = web3.extend.utils.toWei(amount);
        if (amount === "0") {
          throw new Error("invalid number value");
        }
        amount = web3.extend.utils.toHex(amount);

        const currentNetwork = web3.currentProvider.networkVersion;
        if (currentNetwork !== walletNetwork.toString()) {
          // show error when trying to switch to ethereum
          if (walletNetwork.toString() === "1") {
            // only on production networks
            if (currentNetwork !== "4") {
              throw new Error("Please switch manually to Ethereum network");
            }
          } else {
            if (currentNetwork !== "97") {
              await customJS.wallet.switchToBinance(
                wallet,
                walletShort,
                walletDecimals
              );
            }
          }
        }

        let txId = "";
        // if it is not a custom token eg: ether
        if (!walletContract.startsWith("0x")) {
          txId = await ethereum.request({
            method: "eth_sendTransaction",
            params: [
              {
                from: fromAddress,
                to: toAddress,
                value: amount,
              },
            ],
          });
        } else {
          // get the amount
          let amount = sendAmount;

          // calculate ERC20 token amount and transform it into big number
          let value = web3.utils.toBN(amount * walletDecimals);

          const minABI = [
            // transfer
            {
              constant: false,
              inputs: [
                {
                  name: "_to",
                  type: "address",
                },
                {
                  name: "_value",
                  type: "uint256",
                },
              ],
              name: "transfer",
              outputs: [
                {
                  name: "",
                  type: "bool",
                },
              ],
              type: "function",
            },
          ];
          // Get ERC20 Token contract instance
          let contract = new web3.eth.Contract(minABI, walletContract);
          // call transfer function
          txId = await contract.methods.transfer(toAddress, value).send({
            from: fromAddress,
          });
        }

        $("#sendtxid").val(txId.transactionHash ? txId.transactionHash : txId);
        customJS.wallet.registerWithdraw();

        $.toast({
          heading: "",
          text: "Successful operation",
          icon: "success",
          loader: true,
          loaderBg: "#9fd5ff",
          showHideTransition: "plain",
          position: "bottom-right",
          hideAfter: 5000,
        });
        // setTimeout(function () {
        //   window.location.href = $("#urlw").val() + "wallet";
        // }, 5000);
      } catch (error) {
        if (!error.message.includes("MetaMask Tx Signature")) {
          $("#balanceMetamask").text("N/A");
        }

        let message = error.message;
        if (error.message.includes("invalid number value")) {
          message = "Invalid amount value";
        }
        if (error.message.includes("not a positive number.")) {
          message = "Amount value must be positive";
        }

        $.toast({
          heading: "",
          text: message,
          icon: "error",
          loader: true,
          loaderBg: "#9fd5ff",
          showHideTransition: "plain",
          position: "bottom-right",
          hideAfter: 5000,
        });
      }
    },
    getCurrentAddress: async () => {
      try {
        const accounts = await ethereum.request({
          method: "eth_requestAccounts",
        });
        return accounts[0];
      } catch (error) {
        alert("Could not detect a Metamask account");
      }
    },

    switchToBinance: async (networkName, networkShort, decimals) => {
      if (window.ethereum) {
        const web3 = new Web3(window.ethereum);
        const network = {
          name: "Smart Chain",
          number: web3.extend.utils.toHex(56),
          rpcUrl: "https://bsc-dataseed.binance.org/",
          explorer: "https://bscscan.com",
        }; // production
        // const network = {
        //   name: "Smart Chain - Testnet",
        //   number: web3.extend.utils.toHex(97),
        //   rpcUrl: "https://data-seed-prebsc-1-s1.binance.org:8545/",
        //   explorer: "https://testnet.bscscan.com",
        // }; // test

        try {
          window.ethereum.request({ method: "eth_requestAccounts" });

          const param = {
            chainId: `${network.number}`, //'0xa869',
            chainName: `${network.name}`, //"Fuji Testnet",
            nativeCurrency: {
              name: `${networkShort}`, //"AVAX",
              symbol: `${networkShort}`, //"AVAX",
              decimals: eval(decimals).toString().length - 1, //18
            },
            rpcUrls: [network.rpcUrl],
            blockExplorerUrls: [network.explorer],
          };

          console.log("param", param);
          await window.ethereum.request({
            method: "wallet_addEthereumChain",
            params: [param],
          });
        } catch (e) {
          $.toast({
            heading: "",
            text: (e && e.message) || e,
            icon: "error",
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
          throw e;
        }
      }
    },
  },
  users: {
    userSearch: function () {
      var userveri = "";
      $("#userDataTable").DataTable().destroy();
      $("#userVeri").html(userveri);
      $("#userDataTable").DataTable({
        bLengthChange: false,
        info: false,
      });
      $.post(customJS.serviceURL + "user/userSearch", {
        userData: $("#userSearch").val(),
      }).done(function (data) {
        data = jQuery.parseJSON(data);

        if (data != "yok") {
          $("#userDataTable").DataTable().destroy();
          $.each(data, function (index, user) {
            if (user.user_ex_status == 0) {
              var durum_ex = "OFF",
                color_ex = "danger";
            } else {
              var durum_ex = "ON",
                color_ex = "success";
            }
            if (user.user_wallet_status == 0) {
              var durum_wallet = "OFF",
                color_wallet = "danger";
            } else {
              var durum_wallet = "ON",
                color_wallet = "success";
            }
            if (user.user_login_status == 0) {
              var durum_login = "OFF",
                color_login = "danger";
            } else {
              var durum_login = "ON",
                color_login = "success";
            }
            if (user.user_free_trade == 0) {
              var durum_trade = "OFF",
                color_trade = "danger";
            } else {
              var durum_trade = "ON",
                color_trade = "success";
            }
            if (user.user_email_conf == 0) {
              var durum =
                '<i class="fa fa-times-circle text-warning" data-toggle="tooltip" data-placement="left" title="No mail confirmation."></i>';
            } else {
              var durum =
                '<i class="fa fa-check-circle text-success" data-toggle="tooltip" data-placement="left" title="Mail confirmation."></i>';
            }
            userveri +=
              "<tr>" +
              '<td class="text-left"><a data-toggle="collapse" href="javascript:void(0);" onclick="singleUser(\'#userInfoScrool\',\'' +
              user.user_id +
              "','" +
              user.user_email +
              "');\" >" +
              user.user_email +
              "</a></td>" +
              '<td><i class=" text-' +
              color_ex +
              ' font-size-12">' +
              durum_ex +
              "</i></td>" +
              '<td><i class=" text-' +
              color_wallet +
              ' font-size-12">' +
              durum_wallet +
              "</i></td>" +
              '<td><i class=" text-' +
              color_login +
              ' font-size-12">' +
              durum_login +
              "</i></td>" +
              "<td>" +
              durum +
              "</td>" +
              "<td>" +
              user.user_ip +
              "</td>" +
              '<td><span class="d-none">' +
              user.user_create +
              "</span>" +
              new Date(user.user_create * 1000).toLocaleString() +
              "</td>" +
              '<td><i class=" text-' +
              color_trade +
              ' font-size-12">' +
              durum_trade +
              "</i></td>" +
              "<td>" +
              user.user_id +
              "</td>" +
              "</tr>";
          });

          $("#userVeri").html(userveri);
          $("#userDataTable").DataTable({
            order: [[5, "desc"]],
            bLengthChange: false,
            info: false,
            responsive: {
              details: {
                renderer: function (api, rowIdx, columns) {
                  var data = $.map(columns, function (col, i) {
                    return col.hidden
                      ? '<tr data-dt-row="' +
                          col.rowIndex +
                          '" data-dt-column="' +
                          col.columnIndex +
                          '">' +
                          "<td>" +
                          col.title +
                          ":" +
                          "</td> " +
                          "<td>" +
                          col.data +
                          "</td>" +
                          "</tr>"
                      : "";
                  }).join("");

                  return data ? $("<table/>").append(data) : false;
                },
              },
            },
          });
        } else {
          //console.log("kullanıcı yok");
        }
      });
    },

    userUpdate: function (id, type, style) {
      var r = confirm(" Update Confirm?");
      if (r == true) {
        if (style == 5) {
          var veri = document.getElementById(id).value;
        } else if (style == 4) {
          if (document.getElementById(id).checked == true) {
            var veri = 1;
          } else {
            var veri = 0;
          }
        }
        $.post(customJS.serviceURL + "user/userUpdate", {
          userid: $("#user_id").html(),
          useremail: $("#user_email").html(),
          satir: id,
          veri: veri,
          type: type,
        }).done(function (data) {
          data = jQuery.parseJSON(data);
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      } else {
        return;
      }
    },

    closeInput: function (elm, short, oldvalue) {
      var td = elm.parentNode;
      var value = parseFloat(elm.value).toFixed(8);
      var person = prompt("Please enter the Google 2FA code");
      if (person == null || person == "") {
        td.removeChild(elm);
        td.innerHTML = oldvalue.toFixed(8);
      } else {
        $.post(customJS.serviceURL + "user/userWalletBalanceUpdate", {
          userid: $("#user_id").html(),
          useremail: $("#user_email").html(),
          balance: value,
          short: short,
          googleCode: person,
        }).done(function (data) {
          //console.log(value,short,person,$("#user_id").html(),$("#user_email").html());
          data = jQuery.parseJSON(data);
          if (data.durum == "success") {
            td.removeChild(elm);
            td.innerHTML = value;
          } else {
            td.removeChild(elm);
            td.innerHTML = oldvalue.toFixed(8);
          }
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      }
    },

    addInput: function (elm, short) {
      if (elm.getElementsByTagName("input").length > 0) return;

      var value = elm.innerHTML;
      elm.innerHTML = "";
      var input = document.createElement("input");
      input.setAttribute("type", "text");
      input.setAttribute("value", value);
      input.setAttribute(
        "onBlur",
        "customJS.users.closeInput(this,'" + short + "'," + value + ")"
      );
      elm.appendChild(input);
      input.focus();
    },
    userAddDepositModal: function (useremail, userid, address, short, system) {
      $("#depuserid").val(userid);
      $("#depuseremail").val(useremail);
      $("#depaddress").val(address);
      $("#depshort").html(short);
      $("#depwalletsystem").val(system);
    },

    userAddWithdrawModal: function (
      useremail,
      userid,
      address,
      short,
      walletid,
      system
    ) {
      $("#withuserid").val(userid);
      $("#withuseremail").val(useremail);
      $("#withshort").html(short);
      $("#withwalletid").val(walletid);
      $("#withwalletsystem").val(system);
    },

    userTransactionsInsert: function (id) {
      if (id == 1) {
        var userid = $("#depuserid").val();
        var useremail = $("#depuseremail").val();
        var address = $("#depaddress").val();
        var googleCode = $("#depKey").val();
        var amount = $("#depamount").val();
        var txid = $("#deptxid").val();
        var system = $("#depwalletsystem").val();
        var short = $("#depshort").html();
        var walletid = "0";
      } else if (id == 2) {
        var userid = $("#withuserid").val();
        var useremail = $("#withuseremail").val();
        var address = $("#withaddress").val();
        var googleCode = $("#withKey").val();
        var amount = $("#withamount").val();
        var system = $("#withwalletsystem").val();
        var walletid = $("#withwalletid").val();
        var txid = $("#withtxid").val();
        var short = $("#withshort").html();
      }
      //console.log(system);
      var r = confirm(" Update Confirm?");
      if (r == true) {
        $.post(customJS.serviceURL + "user/userTransactionsInsert", {
          userid: userid,
          useremail: useremail,
          address: address,
          googleCode: googleCode,
          amount: amount,
          txid: txid,
          short: short,
          system: system,
          walletid: walletid,
          islem: id,
        }).done(function (data) {
          data = jQuery.parseJSON(data);
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      }
    },

    userDeleteAddress: function (useremail, userid, address, short) {
      var person = prompt("Please enter the Google 2FA code");
      if (person == null || person == "") {
        return;
      } else {
        $.post(customJS.serviceURL + "user/userDeleteAddress", {
          userid: userid,
          useremail: useremail,
          address: address,
          googleCode: person,
          short: short,
        }).done(function (data) {
          data = jQuery.parseJSON(data);
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      }
    },
    userAddDepositCheck: function (userEmail, userId, walletShort) {
      var r = confirm(" Update Confirm?");
      if (r == true) {
        $.post(customJS.serviceURL + "user/userWalletCheck", {
          useremail: userEmail,
          userid: userId,
          short: walletShort,
        }).done(function (data) {
          data = jQuery.parseJSON(data);
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      }
    },
  },

  home: {
    newsUpdate: function (id) {
      $("#news_title").val($("#title_" + id).val());
      $("#news_detail").val($("#detail_" + id).val());
      $("#news_image").val($("#img_" + id).val());
      $("#news_id").val(id);
      $("#news_status").val($("#status_" + id).val());
      document.getElementById("news_imageGor").src =
        "/assets/home/images/news/" + $("#img_" + id).val();
      $("#newsUpdateModal").modal("show");
    },
    neswDelete: function (id) {
      var r = confirm(" Delete News Confirm?");
      if (r == true) {
        $.post(customJS.serviceURL + "home/deleteNews", {
          id: id,
        }).done(function (data) {
          location.reload();
        });
      }
    },

    supportStatusUpdate: function (status) {
      var r = confirm(" Change support request?");
      if (r == true) {
        $.post(customJS.serviceURL + "home/supportStatusUpdate", {
          id: $("#sup_id").val(),
          status: status,
        }).done(function (data) {
          data = jQuery.parseJSON(data);
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      }
    },

    supportUpdate: function (id) {
      $("#sup_name").val($("#name_" + id).val());
      $("#sup_email").val($("#email_" + id).val());
      $("#sup_subject").val($("#subject_" + id).val());
      $("#sup_reply").summernote("code", $("#reply_" + id).val());

      $("#sup_text").val($("#text_" + id).val());
      $("#sup_file").val($("#img_" + id).val());
      $("#sup_id").val(id);
      $("#sup_status").val($("#status_" + id).val());
      document.getElementById("support_imageGor").src =
        "/assets/home/images/support/" + $("#img_" + id).val();
      document.getElementById("imageBuyukGor").src =
        "/assets/home/images/support/" + $("#img_" + id).val();
      $("#supportUpdateModal").modal("show");
    },
    teamUpdate: function (id) {
      $("#team_name").val($("#name_" + id).html());
      $("#team_email").val($("#email_" + id).html());
      $("#team_linkedin").val($("#linkedin_" + id).html());
      $("#team_telegram").val($("#telegram_" + id).html());
      $("#team_jop").val($("#jop_" + id).html());
      $("#team_sira").val($("#sira_" + id).html());
      $("#team_image").val($("#image_" + id).html());
      $("#team_id").val(id);
      document.getElementById("team_imageGor").src =
        "/assets/home/images/team/" + $("#image_" + id).html();
      $("#teamUpdateModal").modal("show");
    },
    teamDelete: function (id) {
      var r = confirm(" Delete Team Confirm?");
      if (r == true) {
        $.post(customJS.serviceURL + "home/deleteTeam", {
          id: id,
        }).done(function (data) {
          location.reload();
        });
      }
    },

    faucetUpdate: function (short, id) {
      var r = confirm(" Change " + short + " faucet setting?");
      if (r == true) {
        $.post(customJS.serviceURL + "home/faucetUpdate", {
          short: short,
          id: id,
          faucet_status: $("#" + short + "-faucet_status").val(),
          faucet_amount: $("#" + short + "-faucet_amount").val(),
          faucet_period: $("#" + short + "-faucet_period").val(),
        }).done(function (data) {
          location.reload();
        });
      }
    },
  },

  admin: {
    adminUpdate: function (email, style, satir) {
      var person = prompt("Please enter the Google 2FA code");
      if (person == null || person == "") {
        return;
      } else {
        var veri = document.getElementById(satir).value;
        $.post(customJS.serviceURL + "admin/adminUpdate", {
          email: email,
          style: style,
          satir: satir,
          veri: veri,
          googleCode: person,
        }).done(function (data) {
          data = jQuery.parseJSON(data);
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      }
    },
    barkodeModal: function (id) {
      document.getElementById("imageBarcodeGor").src = $("#" + id).val();
      $("#barcodeModal").modal("show");
    },
  },
  auth: {
    auth_request: (apiUrl, accountAdress) => {
      return fetch(apiUrl + "/auth-request", {
        body: "address=" + accountAdress,
        headers: {
          "Content-Type": "application/x-www-form-urlencoded;charset=UTF-8",
        },
        method: "POST",
      });
    },
    /**
     * verify signature
     * @param {String} apiUrl
     * @param {String} accountAdress
     * @param {String} signature
     * @param {String} headingMessage optional custom message used in local signature
     * @returns
     */
    auth_signature: (apiUrl, accountAdress, signature, headingMessage) => {
      let requestBody = `address=${accountAdress}&signature=${signature}`;
      if (headingMessage) {
        requestBody += `&headingMessage=${headingMessage}`;
      }

      return fetch(apiUrl + "/auth-signature/", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded;charset=UTF-8",
        },
        body: requestBody,
      });
    },
    loginWithMetamask: async (baseUrl) => {
      try {
        const apiUrl = baseUrl + "api";
        const accountAddress = await ethereum.request({
          method: "eth_requestAccounts",
        });
        if (accountAddress.length > 0) {
          const auth_request_res = await customJS.auth.auth_request(
            apiUrl,
            accountAddress[0]
          );
          const { ticket } = await auth_request_res.json();

          const signature = await web3.eth.personal.sign(
            web3.utils.fromUtf8("starting session: " + ticket),
            accountAddress[0]
          );
          let auth_signature_res = await customJS.auth.auth_signature(
            apiUrl,
            accountAddress,
            signature
          );
          const { status } = await auth_signature_res.json();
          if (status === "ok") {
            // window.location = baseUrl + "market";
            $("#metamaskControl").html(
              `<button class="btn btn-outline-success btn-xs" title="Metamask">Connected to metamask</button>`
            );
          } else {
            alert("authentication error");
          }
        }
      } catch (err) {
        let errorMessage;
        let errorTitle;
        if (err.message && err.message.includes("ethereum is not defined")) {
          errorTitle = "Please install Metamask to login";
          errorMessage =
            "<a target='_blank' href='https://www.youtube.com/watch?v=ZIGUC9JAAw8'>Need help?</a>";
        }

        if (err.code && err.code === -32002) {
          errorMessage =
            "A login process already exists, please check your MetaMask";
        }
        $.toast({
          heading: errorTitle ?? "",
          text: errorMessage,
          icon: "error",
          loader: true,
          loaderBg: "#9fd5ff",
          showHideTransition: "plain",
          position: "bottom-right",
          hideAfter: 5000,
        });
      }
    },
    isLoggedInMetamask: () => {
      web3.eth.getAccounts((err, accounts) => {
        if (accounts.length == 0) {
          // console.log("User is not logged in to MetaMask");
          // return false;
          $("#metamaskControl").html(
            `<a class="btn btn-outline-secondary btn-xs" onclick="customJS.auth.loginWithMetamask('${base_url}/')" title="Login">login with metamask</a>`
          );
          return;
        }
        if (err != null) {
          // console.error("An error occurred: "+err);
          $.toast({
            heading: "An error occurred",
            text: err.message ? err.message : err,
            icon: "error",
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
          // return null;
          return;
        }
        //return true;
        $("#metamaskControl").html(
          `<button class="btn btn-outline-success btn-xs" title="Metamask">Connected to metamask</button>`
        );
      });
    },
  },

  bank: {
    bankUpdate: function (bankid) {
      $.post(customJS.serviceURL + "fiat/bulBank", {
        bankid: bankid,
      }).done(function (data) {
        data = jQuery.parseJSON(data);
        $("#banka_id").val(data[0].banka_id);
        //document.getElementById("banka_name").value=data[0].banka_name;
        $("#banka_name").val(data[0].banka_name);
        $("#banka_iban").val(data[0].banka_iban);
        $("#banka_hesap").val(data[0].banka_hesap);
        $("#fiat_short").val(data[0].fiat_short);
      });
    },
    bankDelete: function (bankid) {
      var r = confirm(" Delete Confirm?");
      if (r == true) {
        $.post(customJS.serviceURL + "fiat/silBank", {
          bankid: bankid,
        }).done(function (data) {
          data = jQuery.parseJSON(data);
          if (data.durum == "success") {
            $("#" + bankid).hide("slow");
          }
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      }
    },
  },

  tax: {
    createInvoise: function (email, userID, amount, tradeID) {
      var r = confirm(" Create Invoise Confirm?");
      if (r == true) {
        var tradeID = jQuery.parseJSON(tradeID);
        //console.log(tradeID);

        $.post(customJS.serviceURL + "invoice/invoiceCreateRun", {
          email: email,
          userID: userID,
          amount: amount,
          tradeID: tradeID,
        }).done(function (data) {
          data = jQuery.parseJSON(data);
          if (data.durum == "success") {
            var socket = io.connect(socketUrl);
            socket.emit("tradeVolTopla");
          }
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      }
    },
  },

  bot: {
    botDelete: function (bot_id) {
      var r = confirm(" Delete Confirm?");
      if (r == true) {
        $.post(customJS.serviceURL + "bot/deleteBot", {
          bot_id: bot_id,
        }).done(function (data) {
          location.reload();
        });
      }
    },
    botUpdate: function (bot_id) {
      var r = confirm(" Update Confirm?");
      if (r == true) {
        if (document.getElementById(bot_id + "_bot_status").checked == true) {
          var veri = 1;
        } else {
          var veri = 0;
        }
        $.post(customJS.serviceURL + "bot/updateBot", {
          bot_id: bot_id,
          priceBuy: $("#" + bot_id + "_bot_buyPrice").val(),
          priceSell: $("#" + bot_id + "_bot_sellPrice").val(),
          botVolume: $("#" + bot_id + "_bot_volume").val(),
          botStatus: veri,
        }).done(function (data) {
          data = jQuery.parseJSON(data);
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      }
    },

    botStatusUpdate: function (bot_id) {
      var r = confirm(" Update Confirm?");
      if (r == true) {
        if (document.getElementById(bot_id + "_bot_status").checked == true) {
          var veri = 1;
        } else {
          var veri = 0;
        }
        $.post(customJS.serviceURL + "bot/updateStatusBot", {
          bot_id: bot_id,
          botStatus: veri,
        }).done(function (data) {
          data = jQuery.parseJSON(data);
          $.toast({
            heading: "Information",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        });
      }
    },
  },
};

$(document).ready(function () {
  // update total amount to send on fee change
  $("#sendfee").change((e) => {
    const amount = eval($("#sendamount").val());
    const fee = eval(e.target.value);
    $("#sendtotal").val((amount.toFixed(8) - fee.toFixed(8)).toFixed(8));
  });
  // listen for the event of connect / desconnect event
  // check if metamask is installed and enabled
  if (typeof window.ethereum === "undefined") {
    $.toast({
      heading: "",
      text: "Metamask is not accessible",
      icon: "error",
      loader: true,
      loaderBg: "#9fd5ff",
      showHideTransition: "plain",
      position: "bottom-right",
      hideAfter: 5000,
    });
  } else {
    ethereum.on("accountsChanged", (accounts) => {
      window.location.reload();
    });
    // handler: (error: ProviderRpcError) => void);
    customJS.auth.isLoggedInMetamask();
  }

  $("#wallet_info").summernote({
    toolbar: [
      // [groupName, [list of button]]
      ["style", ["bold", "italic", "underline", "clear"]],
      ["font", ["strikethrough", "superscript", "subscript"]],
      ["fontsize", ["fontsize"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["height", ["height"]],
      ["style", ["style"]],
      ["fontname", ["fontname"]],
      ["table", ["table"]],
      ["insert", ["link", "picture", "video"]],
      ["view", ["fullscreen", "codeview", "help"]],
    ],
  });

  $("#site_termsofuse").summernote({
    height: 400,
    toolbar: [
      // [groupName, [list of button]]
      ["style", ["bold", "italic", "underline", "clear"]],
      ["font", ["strikethrough", "superscript", "subscript"]],
      ["fontsize", ["fontsize"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["height", ["height"]],
      ["style", ["style"]],
      ["fontname", ["fontname"]],
      ["table", ["table"]],
      ["insert", ["link", "picture", "video"]],
      ["view", ["fullscreen", "codeview", "help"]],
    ],
  });
  $("#site_privacypolicy").summernote({
    height: 400,
    toolbar: [
      // [groupName, [list of button]]
      ["style", ["bold", "italic", "underline", "clear"]],
      ["font", ["strikethrough", "superscript", "subscript"]],
      ["fontsize", ["fontsize"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["height", ["height"]],
      ["style", ["style"]],
      ["fontname", ["fontname"]],
      ["table", ["table"]],
      ["insert", ["link", "picture", "video"]],
      ["view", ["fullscreen", "codeview", "help"]],
    ],
  });
  $("#site_listing_about").summernote({
    height: 400,
    toolbar: [
      // [groupName, [list of button]]
      ["style", ["bold", "italic", "underline", "clear"]],
      ["font", ["strikethrough", "superscript", "subscript"]],
      ["fontsize", ["fontsize"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["height", ["height"]],
      ["style", ["style"]],
      ["fontname", ["fontname"]],
      ["table", ["table"]],
      ["insert", ["link", "picture", "video"]],
      ["view", ["fullscreen", "codeview", "help"]],
    ],
  });
  $("#sup_reply").summernote({
    height: 250,
    toolbar: [
      // [groupName, [list of button]]
      ["style", ["bold", "italic", "underline", "clear"]],
      ["font", ["strikethrough", "superscript", "subscript"]],
      ["fontsize", ["fontsize"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["height", ["height"]],
      ["style", ["style"]],
      ["fontname", ["fontname"]],
      ["table", ["table"]],
      ["insert", ["link", "picture", "video"]],
      ["view", ["fullscreen", "codeview", "help"]],
    ],
  });

  $('[data-toggle="tooltip"]').tooltip();

  //iban yazma
  $("#banka_iban").mask("SS00 0000 0000 0000 0000 0000 0000 00", {
    placeholder: "TR__ ____ ____ ____ ____ ____ ____ __",
  });
  $(".buyukResim").on("click", function () {
    $("#resimModal").modal("show");
  });

  $(window).scroll(function () {
    if ($(this).scrollTop() > 200) {
      $(".scroll-to-top").fadeIn(400);
    } else {
      $(".scroll-to-top").fadeOut(400);
    }
  });
  $(".custom-file-input").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });

  $("#adminDataTable").DataTable({
    order: [[1, "desc"]],
    responsive: {
      details: {
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.hidden
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data ? $("<table/>").append(data) : false;
        },
      },
    },
  });
  $("#adminActivityTable").DataTable({
    order: [[2, "desc"]],
    responsive: {
      details: {
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.hidden
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data ? $("<table/>").append(data) : false;
        },
      },
    },
  });
  $("#bankDataTable").DataTable({
    order: [[0, "desc"]],
    scrollX: true,
  });

  $("#newsDataTable").DataTable({
    order: [[1, "desc"]],
    responsive: {
      details: {
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.hidden
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data ? $("<table/>").append(data) : false;
        },
      },
    },
  });

  $("#faucetDataTable").DataTable({
    order: [[3, "desc"]],
    responsive: {
      details: {
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.hidden
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data ? $("<table/>").append(data) : false;
        },
      },
    },
  });

  $("#supportDataTable").DataTable({
    order: [
      [6, "desc"],
      [1, "desc"],
    ],
    responsive: {
      details: {
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.hidden
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data ? $("<table/>").append(data) : false;
        },
      },
    },
  });

  $("#fundDataTable").DataTable({
    order: [[5, "desc"]],
    responsive: {
      details: {
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.hidden
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data ? $("<table/>").append(data) : false;
        },
      },
    },
  });

  $("#submitWallet").submit(function (e) {
    e.preventDefault();
    $.ajax({
      url: customJS.serviceURL + "wallet/walletUpdateResim",
      type: "post",
      data: new FormData(this),
      processData: false,
      contentType: false,
      cache: false,
      async: false,
      success: function (data) {
        data = jQuery.parseJSON(data);
        $.toast({
          heading: "Information",
          text: data.mesaj,
          icon: data.durum,
          loader: true,
          loaderBg: "#9fd5ff",
          showHideTransition: "plain",
          position: "bottom-right",
          hideAfter: 5000,
        });
      },
    });
  });

  setInterval(() => {
    $.post(customJS.serviceURL + "wallet/deleteFiatDeposit", {}).done(function (
      data
    ) {
      data = jQuery.parseJSON(data);
      if (data.durum == "success") {
        $.toast({
          heading: "Information",
          text: data.mesaj,
          icon: data.durum,
          loader: true,
          loaderBg: "#9fd5ff",
          showHideTransition: "plain",
          position: "bottom-right",
          hideAfter: 5000,
        });
      }
    });
  }, 20000);

  $("#mainDepositDataTable").DataTable({
    info: false,
    order: [
      [2, "asc"],
      [4, "desc"],
    ],
    responsive: {
      details: {
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.hidden
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data ? $("<table/>").append(data) : false;
        },
      },
    },
  });

  $("#mainWithdrawDataTable").DataTable({
    info: false,
    order: [
      [3, "desc"],
      [6, "desc"],
    ],
    responsive: {
      details: {
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.hidden
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data ? $("<table/>").append(data) : false;
        },
      },
    },
  });

  $("#mainExchangeDataTable").DataTable({
    info: false,
    order: [7, "desc"],
    responsive: {
      details: {
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.hidden
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data ? $("<table/>").append(data) : false;
        },
      },
    },
  });

  $("#mainFaucetDataTable").DataTable({
    info: false,
    order: [2, "desc"],
    responsive: {
      details: {
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.hidden
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data ? $("<table/>").append(data) : false;
        },
      },
    },
  });
  $("#mainFaucetTotalDataTable").DataTable({
    info: false,
    order: [0, "desc"],
    responsive: {
      details: {
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.hidden
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data ? $("<table/>").append(data) : false;
        },
      },
    },
  });

  $("#mainTradeDataTable").DataTable({
    info: false,
    order: [8, "desc"],
    responsive: {
      details: {
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.hidden
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data ? $("<table/>").append(data) : false;
        },
      },
    },
  });

  $("#walletDepositDataTable").DataTable({
    bLengthChange: false,
    info: false,
    order: [
      [3, "asc"],
      [4, "desc"],
    ],
    responsive: {
      details: {
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.hidden
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data ? $("<table/>").append(data) : false;
        },
      },
    },
  });

  $("#userDataTable").DataTable({
    order: [[5, "desc"]],
    bLengthChange: false,
    info: false,
    responsive: {
      details: {
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.hidden
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data ? $("<table/>").append(data) : false;
        },
      },
    },
  });

  $("#mainvolBTCDataTable").DataTable({
    order: [[3, "desc"]],
    responsive: {
      details: {
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.hidden
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data ? $("<table/>").append(data) : false;
        },
      },
    },
  });

  $("#mainvolETHDataTable").DataTable({
    order: [[3, "desc"]],
    responsive: {
      details: {
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.hidden
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data ? $("<table/>").append(data) : false;
        },
      },
    },
  });

  $("#mainvolUSDTDataTable").DataTable({
    order: [[3, "desc"]],
    responsive: {
      details: {
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.hidden
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data ? $("<table/>").append(data) : false;
        },
      },
    },
  });

  $("#mainvolDOGEDataTable").DataTable({
    order: [[3, "desc"]],
    responsive: {
      details: {
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.hidden
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":" +
                  "</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
              : "";
          }).join("");

          return data ? $("<table/>").append(data) : false;
        },
      },
    },
  });
});
