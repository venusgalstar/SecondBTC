"use strict";
var buycommission = $("#buycommission").val();
var sellcommission = $("#sellcommission").val();
var fromID = $("#fromID").val();
var toID = $("#toID").val();
var markyeni = [fromID, toID];
var base_url = window.location.origin;
// var base_url = 'http://localhost/secondbtc/public_html/';

const web3 = new Web3(Web3.givenProvider);

/**web3Modal*/

const Web3Modal = window.Web3Modal.default;
const WalletConnectProvider = window.WalletConnectProvider.default;
// const Fortmatic = window.Fortmatic;
const evmChains = window.evmChains;

// Web3modal instance
let web3Modal;

// Chosen wallet provider given by the dialog window
let provider;

// Address of the selected account
let selectedAccount;

/**Web3Modal*/

const customJS = {
  serviceURL: $("#url").html(),
  copyToClipboard: function (textToCopy) {
    const selBox = document.createElement("textarea");
    selBox.style.position = "fixed";
    selBox.style.left = "0";
    selBox.style.top = "0";
    selBox.style.opacity = "0";
    selBox.value = textToCopy;
    document.body.appendChild(selBox);
    selBox.focus();
    selBox.select();
    document.execCommand("copy");
    document.body.removeChild(selBox);
    $.toast({
      heading: "",
      text: $("#copysuc").html(),
      icon: "success",
      loader: true,
      loaderBg: "#9fd5ff",
      showHideTransition: "plain",
      position: "bottom-right",
      hideAfter: 5000,
    });
  },
  exchange: {
    fiyatCek: function (type, id) {
      if ($("#" + type + "-bids" + id).html() > 0) {
        var price = $("#" + type + "-bids" + id).html();
        $("#buyFromPrice").val(price);
        $("#sellToPrice").val(price);
        if ($("#buyFromUnit").val() > 0) {
          var unit = $("#buyFromUnit").val();
          $("#buyFromTotal").val(
            (unit * parseFloat(price) * buycommission).toFixed(document.getElementById("tdec").value)
          );
        }
        if ($("#sellToUnit").val() > 0) {
          var unit = $("#sellToUnit").val();
          $("#sellToTotal").val(
            (unit * parseFloat(price) * sellcommission).toFixed(document.getElementById("tdec").value)
          );
        }
      }
    },

    unitCek: function (type, id) {
      //console.log(type+'-bids'+id);
      if ($("#" + type + "-bids" + id).html() > 0) {
        var price = $("#" + type + "-bids" + id).html();
        $("#buyFromPrice").val(price);
        $("#sellToPrice").val(price);
        if (type == "buy") {
          var unit = $("#" + type + "-unit" + id).html();
          $("#sellToTotal").val(
            (unit * parseFloat(price) * sellcommission).toFixed(document.getElementById("tdec").value)
          );
          $("#sellToUnit").val(parseFloat(unit).toFixed(document.getElementById("adec").value));
        }
        if (type == "sell") {
          var unit = $("#" + type + "-unit" + id).html();
          $("#buyFromTotal").val(
            (unit * parseFloat(price) * buycommission).toFixed(document.getElementById("tdec").value)
          );
          $("#buyFromUnit").val(parseFloat(unit).toFixed(document.getElementById("adec").value));
        }
      }
    },

    /*RangeFrom:function (newval) {
           
            var price = $("#buyFromPrice").val();
            if(price){
            document.getElementById("formControlRangefrom").max = $("#userFromBalance").html();
            var frombalance = $("#userFromBalance").html();
            var yuzde = (newval/frombalance)*100;
            $("#rangeFromYuzde").html(yuzde.toFixed(0)+"%");
            $("#buyFromTotal").val(parseFloat(newval).toFixed(8));
            var unit = (newval/buycommission)/price;
            $("#buyFromUnit").val((unit).toFixed(8));
            $("#buyFromPrice").val(parseFloat(price).toFixed(8));
            }
        },*/
    RangeFrom: function (newval) {
      var price = $("#buyFromPrice").val();
      if (price) {
        var frombalance = $("#userFromBalance").html();
        if (newval != "100") {
          var yuzde = frombalance * (1 + "." + newval) - frombalance;
        } else {
          var yuzde = frombalance;
        }
        $("#buyFromTotal").val(parseFloat(yuzde).toFixed(document.getElementById("tdec").value));
        var unit = yuzde / buycommission / price;
        $("#buyFromUnit").val(unit.toFixed(document.getElementById("adec").value));
        $("#buyFromPrice").val(parseFloat(price).toFixed(document.getElementById("pdec").value));
      }
    },
    tradeBuyTotal: function (unit) {
      var price = $("#buyFromPrice").val();
      if (price) {
        var total = unit * price * buycommission;
        $("#buyFromTotal").val(total.toFixed(document.getElementById("tdec").value));
        $("#buyFromUnit").focusout(function () {
          $(this).val(parseFloat(unit).toFixed(document.getElementById("adec").value));
        });
      }
    },
    tradeBuyUnit: function (total) {
      var price = $("#buyFromPrice").val();
      if (price) {
        var unit = total / buycommission / price;
        $("#buyFromUnit").val(unit.toFixed(document.getElementById("adec").value));
        $("#buyFromTotal").focusout(function () {
          $(this).val(parseFloat(total).toFixed(document.getElementById("tdec").value));
        });
      }
    },
    tradeBuyPrice: function (price) {
      var unit = $("#buyFromUnit").val();
      if (unit) {
        var total = price * unit * buycommission;
        $("#buyFromTotal").val(total.toFixed(document.getElementById("tdec").value));
      }
      $("#buyFromPrice").focusout(function () {
        $(this).val(parseFloat(price).toFixed(document.getElementById("pdec").value));
      });
    },
    /*RangeTo:function (newval) {
            var price = $("#sellToPrice").val();
            if(price){
            document.getElementById("formControlRangeto").max = $("#userToBalance").html();
            var tobalance = $("#userToBalance").html();
            var yuzde = (newval/tobalance)*100;
            $("#rangeToYuzde").html(yuzde.toFixed(0)+"%");
            $("#sellToUnit").val(parseFloat(newval).toFixed(8));
            var total = (newval*price)*sellcommission;
            $("#sellToTotal").val(total.toFixed(8));
            $("#sellToPrice").val(parseFloat(price).toFixed(8));
            }
        },*/
    RangeTo: function (newval) {
      var price = $("#sellToPrice").val();
      if (price) {
        var tobalance = $("#userToBalance").html();
        if (newval != "100") {
          var yuzde = tobalance * (1 + "." + newval) - tobalance;
        } else {
          var yuzde = tobalance;
        }
        $("#sellToUnit").val(parseFloat(yuzde).toFixed(document.getElementById("adec").value));
        var total = yuzde * price * sellcommission;
        $("#sellToTotal").val(total.toFixed(document.getElementById("tdec").value));
        $("#sellToPrice").val(parseFloat(price).toFixed(document.getElementById("pdec").value));
      }
    },
    tradeSellTotal: function (unit) {
      var price = $("#sellToPrice").val();
      if (price) {
        var total = unit * price * sellcommission;
        $("#sellToTotal").val(total.toFixed(document.getElementById("tdec").value));
        $("#sellToUnit").focusout(function () {
          $(this).val(parseFloat(unit).toFixed(document.getElementById("adec").value));
        });
      }
    },
    tradeSellUnit: function (total) {
      var price = $("#sellToPrice").val();
      if (price) {
        var unit = total / sellcommission / price;
        $("#sellToUnit").val(unit.toFixed(document.getElementById("adec").value));
        $("#sellToTotal").focusout(function () {
          $(this).val(parseFloat(total).toFixed(document.getElementById("tdec").value));
        });
      }
    },
    tradeSellPrice: function (price) {
      var unit = $("#sellToUnit").val();
      if (unit) {
        var total = price * unit * sellcommission;
        $("#sellToTotal").val(total.toFixed(document.getElementById("tdec").value));
      }
      $("#sellToPrice").focusout(function () {
        $(this).val(parseFloat(price).toFixed(document.getElementById("pdec").value));
      });
    },
    trade: function (type) {
      if (type == "buy") {
        var price = $("#buyFromPrice").val();
        var unit = $("#buyFromUnit").val();
        var load = $("#buyButton");
      } else {
        var price = $("#sellToPrice").val();
        var unit = $("#sellToUnit").val();
        var load = $("#sellButton");
      }
      var toShort = $("#toWallet").html();
      var fromShort = $("#fromWallet").html();

      var loadingText =
        '<i class="spinner-border spinner-border-sm"></i> loading...';
      if (load.html() !== loadingText) {
        load.data("original-text", load.html());
        load.html(loadingText);
      }

      $.post(base_url + "/exchange/trade", {
        price: price,
        unit: unit,
        type: type,
        fromID: fromID,
        toID: toID,
        toShort: toShort,
        fromShort: fromShort,
      }).done(function (data) {
        data = jQuery.parseJSON(data);
        var orderbook = [data.id, data.hesap, fromShort, toShort];
        var orderbookto = [data.toid, data.tohesap, fromShort, toShort];
        var fromarray2 = [fromID, data.id, data.hesap];
        var toarray2 = [toID, data.id, data.hesap];
        var fromarray3 = [fromID, data.toid, data.tohesap];
        var toarray3 = [toID, data.toid, data.tohesap];
        var orderbookOrderPage = [data.id, data.hesap];

        if (data.islem == "orderbook") {
          socket.emit("userfromBalance", fromarray2);
          socket.emit("usertoBalance", toarray2);
          socket.emit("userfromBalance", fromarray3);
          socket.emit("usertoBalance", toarray3);
          socket.emit("exchangeBuy", [fromID, toID]);
          socket.emit("exchangeSell", [fromID, toID]);
          socket.emit("orderBook", orderbook);
          socket.emit("orderBook", orderbookto);
          socket.emit("tradeData", markyeni);
          socket.emit("orderPageBook", orderbookOrderPage);
          load.html(load.data("original-text"));
        }
        $.toast({
          heading: "",
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

    orderDelete: function (id, socketId, OpfromID, OptoID, sayfa) {
      $.post(base_url + "/exchange/deleteorder", {
        id: id,
        socketId: socketId,
      }).done(function (data) {
        data = jQuery.parseJSON(data);
        if (data.durum == "success") {
          if (sayfa == 2) {
            fromID = OpfromID;
            toID = OptoID;
          }
          var marketDel = [fromID, toID];
          var fromarray3 = [fromID, data.id, data.hesap];
          var toarray3 = [toID, data.id, data.hesap];
          socket.emit("userfromBalance", fromarray3);
          socket.emit("usertoBalance", toarray3);
          socket.emit("exchangeSell", marketDel);
          socket.emit("exchangeBuy", marketDel);
          $("#" + socketId).hide("slow");
        }
        $.toast({
          heading: "",
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
  },

  auth: {
    onSubmit: (token) => {
      document.getElementById("newForm").submit();
    },
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
            accountAddress[0].toLowerCase()
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
            window.location = baseUrl + "market";
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
    /**
     * Setup the Web3Modal orchestra
     */
    init: async () => {
      // Tell Web3modal what providers we have available.
      // Built-in web browser provider (only one can exist as a time)
      // like MetaMask, Brave or Opera is added automatically by Web3modal
      const providerOptions = {
        walletconnect: {
          package: WalletConnectProvider,
          options: {
            // Mikko's test key - don't copy as your mileage may vary
            infuraId: "861366ae4a2d43428f90e70b7c5d7ec0",
            rpc: {
              56: 'https://bsc-dataseed.binance.org/'
            },
          },    
        },
        // fortmatic: {
        //   package: Fortmatic,
        //   options: {
        //     // Mikko's TESTNET api key
        //     key: "pk_test_391E26A3B43A3350",
        //   },
        // },
      };

      web3Modal = new Web3Modal({
        cacheProvider: true, // optional
        providerOptions, // required
        disableInjectedProvider: false, // optional. For MetaMask / Brave / Opera.
      });

      // console.log("Web3Modal instance is", web3Modal);

      // auto connect if cache enabled
      // console.log("------->>>>>: ", web3Modal.cachedProvider)
      if (web3Modal.cachedProvider) {
        // console.log("cached provider details: ", provider);
        await customJS.auth.reconnect();
      }
    },
    /**
     * Kick in the UI action after Web3modal dialog has chosen a provider
     */
    fetchAccountData: async (baseUrl) => {
      // Get a Web3 instance for the wallet
      const web3 = new Web3(provider);

      // console.log("Web3 instance is", web3);

      // Get connected chain id from Ethereum node
      const chainId = await web3.eth.getChainId();
      // Load chain information over an HTTP API
      const chainData = evmChains.getChain(chainId);
      // document.querySelector("#network-name").textContent = chainData.name;

      // Get list of accounts of the connected wallet
      const accounts = await web3.eth.getAccounts();

      // MetaMask does not give you all accounts, only the selected account
      // console.log("Got accounts$$$$$$$$$$$$$$", accounts);
      selectedAccount = accounts[0].toLowerCase();

      // Go through all accounts and get their ETH balance
      const rowResolvers = accounts.map(async (address) => {
        const balance = await web3.eth.getBalance(address);
        // ethBalance is a BigNumber instance
        // https://github.com/indutny/bn.js/
        const ethBalance = web3.utils.fromWei(balance, "ether");
        const humanFriendlyBalance = parseFloat(ethBalance).toFixed(4);
        // console.log({ address, balance, ethBalance, humanFriendlyBalance });
        // Fill in the templated row and put in the document
        // const clone = template.content.cloneNode(true);
        // clone.querySelector(".address").textContent = address;
        // clone.querySelector(".balance").textContent = humanFriendlyBalance;
        // accountContainer.appendChild(clone);
      });

      // Because rendering account does its own RPC commucation
      // with Ethereum node, we do not want to display any results
      // until data for all accounts is loaded
      await Promise.all(rowResolvers);

      // Display fully loaded UI for wallet data
      // document.querySelector("#prepare").style.display = "none";
      // document.querySelector("#connected").style.display = "block";
    },
    /**
     * Fetch account data for UI when
     * - User switches accounts in wallet
     * - User switches networks in wallet
     * - User connects wallet initially
     */
    refreshAccountData: async () => {
      // If any current data is displayed when
      // the user is switching acounts in the wallet
      // immediate hide this data
      document.querySelector("#connected").style.display = "none";
      document.querySelector("#prepare").style.display = "block";

      // Disable button while UI is loading.
      // fetchAccountData() will take a while as it communicates
      // with Ethereum node via JSON-RPC and loads chain data
      // over an API call.
      document
        .querySelector("#btn-connect")
        .setAttribute("disabled", "disabled");
      await fetchAccountData(provider);
      document.querySelector("#btn-connect").removeAttribute("disabled");
    },

    /**
     * Connect wallet button pressed.
     */
    connect: async (baseUrl) => {
      console.log("Opening a dialog", web3Modal);
      localStorage.clear()
      await customJS.auth.handleWalletConnect(baseUrl, true);
      // return false;
    },

    reconnect: async () => {
      console.log('reconnect called');
      await customJS.auth.handleWalletConnect();
    },

    handleWalletConnect: async (base_url, clearCache = false) => {
      
      if(!base_url || base_url == ""){
        base_url = SITE_BASEURL;
      }
      // console.log('handle wallet connect base url: ', base_url);

      try {
        if(clearCache){
          await web3Modal.clearCachedProvider();  
        }

        provider = await web3Modal.connect();
        console.log('Connect Provider: ', provider);

        // global web3
        window.__web3 = new Web3(provider);

        // Subscribe to accounts change
        provider.on("accountsChanged", async (accounts) => {
          // console.log("accountsChanged", accounts);
          // customJS.auth.fetchAccountData();
          // sign conexion

          if (accounts.length > 0) {
            // Authentication
            await customJS.auth.handleAccountAuth(base_url, accounts);
          }
        });

        // Subscribe to chainId change
        provider.on("chainChanged", (chainId) => {
          // console.log("chainChanged", chainId);
          customJS.auth.fetchAccountData(base_url);
        });

        // Subscribe to accounts change
        provider.on("connect", (info) => {
          // console.log("connect", info);
          customJS.auth.fetchAccountData(base_url);
        });

        // Subscribe to accounts change
        provider.on("disconnect", async (error) => {
          console.log("disconnect", error);
          await customJS.auth.disconnect();
        });

        // // Subscribe to networkId change
        provider.on("networkChanged", (networkId) => {
          // console.log("networkChanged", networkId);
          // fetchAccountData();
          customJS.auth.fetchAccountData(base_url);
        });

        // await customJS.auth.refreshAccountData();
        // console.log("first call to fetchAccountData");
        await customJS.auth.fetchAccountData(base_url);
        if(clearCache){
          await customJS.auth.handleAccountAuth(base_url);
        }
      } catch (e) {
        console.log("Could not get a wallet connection");
        console.log(e);
        // return;
      }
    },

    handleAccountAuth: async (base_url, accounts) => {
      // console.log('----->>>> handle account auth');
      // console.log('----->>>> accounts: ', accounts);
      // const web3 = null;
      if(!accounts){
        // web3 = new Web3(provider);
        accounts = await window.__web3.eth.getAccounts();
      }
      // console.log('----->>>> web3: ', web3);
      // console.log('----->>>> __web3: ', window.__web3);
      // console.log('----->>>> accounts1: ', accounts);
      const auth_request_res = await customJS.auth.auth_request(
        base_url + "/api",
        accounts[0].toLowerCase()
      );
      
      const { ticket } = await auth_request_res.json();
      // console.log('----->>>> ticket: ', ticket);

      Swal.fire({
        title: 'Info!',
        text: 'Please sign your login request in your wallet.',
        icon: 'info',
        confirmButtonText: 'Okay'
      })

      const signature = await window.__web3.eth.personal.sign(
        web3.utils.fromUtf8("starting session: " + ticket),
        accounts[0].toLowerCase()
      );
      // console.log('----->>>> signature: ', signature);
 
      let auth_signature_res = await customJS.auth.auth_signature(
        base_url + "/api",
        accounts[0].toLowerCase(),
        signature
      );
      const { status } = await auth_signature_res.json();

      // console.log('----->>>> status: ', status);
      if (status === "ok") {
        localStorage.setItem('signAccount', signature);
        // let oldAccount = localStorage.getItem('signVerified');
        localStorage.setItem("signVerified", accounts[0].toLowerCase());
        // if(oldAccount != accounts[0].toLowerCase()){
          
        // }
        window.location.reload();
        // window.location = base_url + "market";
      } else {
        alert("Account Authentication Error");
      }
    },

    /**
     * Disconnect wallet button pressed.
     */
    disconnect: async () => {
      console.log("Killing the wallet connection", provider);

      // TODO: Which providers have close method?
      // if (provider.close) {
      //   console.log('provider.close');
      //   await provider.close();

      //   // If the cached provider is not cleared,
      //   // WalletConnect will default to the existing session
      //   // and does not allow to re-scan the QR code with a new wallet.
      //   // Depending on your use case you may want or want not his behavir.
      //   await web3Modal.clearCachedProvider();
      //   provider = null;
      //   console.log('provider.close provider null');
      // }

      // selectedAccount = null;

      // Set the UI back to the initial state
      // document.querySelector("#prepare").style.display = "block";
      // document.querySelector("#connected").style.display = "none";

      try{
        if(provider.close){
          await provider.close();
          await web3Modal.clearCachedProvider();
        }
      }catch(er){
        console.log('[ERROR] disconnect: ', er);
      }finally{
        provider = null;
        selectedAccount = null;
        window.location.replace(base_url + '/account/logout');
      }

      
    },
  },
  api: {
    createTicketRequest: () => {
      return fetch(base_url + "/api/createTicketRequest", {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded;charset=UTF-8",
        },
        method: "POST",
      });
    },
    userWithdrawCreateMetamask: (
      accountAdress,
      signature,
      headingMessage,
      amount,
      wallet,
      tag
    ) => {
      $.toast({
        heading: "",
        text: "Processing! Please wait..",
        icon: "info",
        loader: true,
        loaderBg: "#9fd5ff",
        showHideTransition: "plain",
        position: "bottom-right",
        hideAfter: 5000,
      });
      /*return fetch(base_url + '/api/userWithdrawCreateMetamask', {
                body: 'address=' + accountAdress + '&signature=' + signature + '&headingMessage=' + headingMessage,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
                },
                method: 'POST'
            })*/
      $.post(base_url + "/wallet/userWithdrawCreateMetamask", {
        address: accountAdress,
        signature: signature,
        headingMessage: headingMessage,
        amount: amount, //$("#amount").val(),
        //address:$("#address").val(),
        tag: tag, //$("#tag").val(),
        wallet: wallet, //qs[1]
      }).done(function (data) {
        data = jQuery.parseJSON(data);
        if (data.durum == "success") {
          $("#withdrawModalEmail").modal("hide");
          $("#withdrawModal2FA").modal("hide");
          setTimeout(function () {
            //location.href = base_url+"wallet";
          }, 4000);
        }
        setTimeout(function () {
          $.toast({
            heading: "",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        }, 1000);
      });
    },
  },
  account: {
    userIPChange: function (veri) {
      var postuserip = $("#user_ip_value").val();
      var onaykodu = $("#onay_kodu").val();
      var onaykodu2 = $("#onay_kodu2").val();
      $.toast({
        text: "Processing! Please wait..",
        textAlign: "center",
        position: "bottom-right",
      });
      if (veri == "kaydet") {
        var islem = "kaydet";
        var code = onaykodu;
      } else if (veri == "sil") {
        var islem = "sil";
        var code = onaykodu2;
        postuserip = "DISABLED";
      }
      $.post(base_url + "/account/ipupdate", {
        user_ip: postuserip,
        islem: islem,
        code: code,
      }).done(function (data) {
        data = jQuery.parseJSON(data);
        if (data.durum == "success") {
          $("#ipupdateModal").modal("hide");
          $("#userIp").html(postuserip);
        }
        if (data.durum == "success") {
          $("#ipupdateModalsil").modal("hide");
        }
        $.toast({
          heading: "",
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
    withdrawaddressupdateemail: function (veri) {
      var postuseraddress = $("#user_ip_value").val();
      var onaykodu = $("#onay_kodu").val();
      var onaykodu2 = $("#onay_kodu2").val();
      if (veri == "kaydet") {
        var islem = "kaydet";
        var code = onaykodu;
      } else if (veri == "sil") {
        var islem = "sil";
        var code = onaykodu2;
        postuseraddress = "0";
      }
      $.post(base_url + "/account/ipupdate", {
        user_address: postuseraddress,
        islem: islem,
        code: code,
      }).done(function (data) {
        data = jQuery.parseJSON(data);
        if (data.durum == "success") {
          $("#ipupdateModal").modal("hide");
          $("#userIp").html(postuserip);
        }
        if (data.durum == "success") {
          $("#ipupdateModalsil").modal("hide");
        }
        $.toast({
          heading: "",
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
    userIPChangeConfirm: function () {
      $.post(base_url + "/account/ipupdateemail", {
        id: $("#userSecret").val(),
      });
    },
    userPassChange: function () {
      $("#passchange").attr("disabled", true);
      $.post(base_url + "/account/passupdateS", {
        id: $("#userSecret").val(),
      }).done(function (data) {
        data = jQuery.parseJSON(data);
        $.toast({
          heading: "",
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

    usertwofadurum: function (veri) {
      if (veri == "E") {
        var code = $("#google_code").val();
        var key = $("#gokey").val();
      } else {
        var code = $("#goonay_kodu").val();
        var key = $("#gokey").val();
      }
      $.post(base_url + "/account/twofasetting", {
        tercih: veri,
        code: code,
        key: key,
      }).done(function (data) {
        data = jQuery.parseJSON(data);
        if (data.durum == "success") {
          $("#ipupdateModalGoogle").modal("hide");
          setTimeout(function () {
            location.reload();
          }, 3000);
        }
        $.toast({
          heading: "",
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
    ConfirmOption: function (islem, tercih) {
      $.toast({
        text: "Processing! Please wait..",
        textAlign: "center",
        position: "bottom-right",
      });
      $.post(base_url + "/account/confirmoption", {
        tercih: tercih,
        islem: islem,
      }).done(function (data) {
        data = jQuery.parseJSON(data);
        $.toast({
          heading: "",
          text: data.mesaj,
          icon: data.durum,
          loader: true,
          loaderBg: "#9fd5ff",
          showHideTransition: "plain",
          position: "bottom-right",
          hideAfter: 5000,
        });
        setTimeout(function () {
          //location.reload();
        }, 3000);
      });
    },

    userInfoChangeConfirm: function () {
      if (
        $("#user_first_name").val() != "" &&
        $("#user_last_name").val() != "" &&
        $("#user_id_number").val() != "" &&
        $("#user_tel").val() != "" &&
        $("#user_dogum").val() != ""
      ) {
        $.post(base_url + "/account/ipupdateemail", {
          id: $("#userSecret").val(),
        });
      } else {
        setTimeout(function () {
          $("#infoupdateModal").modal("hide");
        }, 500);
        $.toast({
          heading: "",
          text: $("#bosluk").html(),
          icon: "error",
          loader: true,
          loaderBg: "#9fd5ff",
          showHideTransition: "plain",
          position: "bottom-right",
          hideAfter: 5000,
        });
      }
    },
    userInfoChange: function () {
      $.post(base_url + "/account/infoupdate", {
        code: $("#info_onay_kodu").val(),
        firsname: $("#user_first_name").val(),
        middlename: $("#user_middle_name").val(),
        lastname: $("#user_last_name").val(),
        ulke: document.getElementById("user_country").value,
        sehir: $("#user_city").val(),
        semt: $("#user_district").val(),
        address: $("#user_address").val(),
        idnumber: $("#user_id_number").val(),
        telefon: $("#user_tel").val(),
        dogum: $("#user_dogum").val(),
      }).done(function (data) {
        data = jQuery.parseJSON(data);
        if (data.durum == "success") {
          $("#infoupdateModal").modal("hide");
        }
        if (data.durum == "info") {
          $("#infoupdateModal").modal("hide");
        }
        $.toast({
          heading: "",
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
  },
  home: {
    userFaucetConfirm: function (short) {
      $.post(base_url + "/home/userFaucetConfirm", { short: short }).done(
        function (data) {
          location.reload();
        }
      );
    },
  },
  wallet: {
    userWithdrawMetamask: async function () {
      provider = await web3Modal.connect();
      // Get a Web3 instance for the wallet
      const web3 = await new Web3(provider);

      var accountAdress = await web3.eth.getAccounts();
      var nonce;
      // try {
      //   accountAdress = await window.ethereum.enable();
      // } catch (err) {
      //   if (err.code && err.code === -32002) {
      //     alert("A process already exists, please check your MetaMask");
      //     return;
      //   }
      // }

      // if (accountAdress.length > 0) {
        var tikect_request_res = await customJS.api.createTicketRequest();
        await tikect_request_res.json().then((data) => (nonce = data.ticket));

        let headingMessage = "withdraw: ";
        
        web3.eth.personal
          .sign(web3.utils.fromUtf8(headingMessage + nonce), accountAdress[0])
          .then(async (signature) => {
            // get the withdraw currency
            const query = window.location.search.substring(1);
            const qs = query.split("=");
            const wallet = qs[1];
            const amount = $("#amount").val();
            const address = $("#address").val();
            const tag = $("#tag").val();
            customJS.api.userWithdrawCreateMetamask(
              address,
              signature,
              headingMessage,
              amount,
              wallet,
              tag
            );
          });
      // }
    },
    copyAddressUni: function (id) {
      var copyText = document.getElementById(id);
      copyText.select();
      document.execCommand("copy");
      $.toast({
        heading: "",
        text: $("#copysuc").html(),
        icon: "success",
        loader: true,
        loaderBg: "#9fd5ff",
        showHideTransition: "plain",
        position: "bottom-right",
        hideAfter: 5000,
      });
    },
    createAddress: function () {
      var query = window.location.search.substring(1);
      var qs = query.split("=");
      setTimeout(function () {
        $.post(base_url + "/wallet/createAddress", { wallet: qs[1] }).done(
          function (data) {
            data = jQuery.parseJSON(data);
            if (data.address != "0" && data.tag == "0") {
              $("#receive_address").val(data.address);
              $("#addressDiv").show();
              $("#barcodeDiv").show();
              $("#checkAddressButton").hide();
              $("#qrcode").html(
                "<img src='https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=" +
                  data.address +
                  "'>"
              );
            } else if (data.address != "0" && data.tag != "0") {
              $("#receive_address").val(data.address);
              $("#receive_address_tag").val(data.tag);
              $("#barcodeDiv").show();
              $("#qrcode").html(
                "<img src='https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=" +
                  data.address +
                  "'>"
              );
              $("#addressDiv").show();
              $("#tagDiv").show();
              $("#checkAddressButton").hide();
            } else {
              $.toast({
                heading: "",
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
        );
      }, 2000);
    },

    withdrawValue: function (val) {
      var commission = $("#commission").val();
      var totalWith = (val - commission).toFixed(8);
      var balance = $("#balance").html();
      //console.log(balance);
      if (totalWith < commission) {
        document.getElementById("totalWith").style.color = "red";
      } else if (totalWith > Number(balance)) {
        document.getElementById("totalWith").style.color = "red";
      } else {
        document.getElementById("totalWith").style.color = "green";
      }
      $("#totalWith").html(totalWith);
      document.execCommand("copy");
    },
    userWithdrawConfirm: function () {
      $("#modalButton").attr("disabled", false);
      var withConf = $("#withConf").val();
      $("#onay_kodu").val("");
      $("#onay_kodu2").val("");
      if (withConf == "M") {
        $.post(base_url + "/wallet/withdrawConfirmemail", {
          id: $("#userSecret").val(),
        });
        setTimeout(function () {
          $("#modalButton").attr("disabled", true);
        }, 100);
        setTimeout(function () {
          $("#modalButton").attr("disabled", false);
        }, 5000);
      }
    },
    userWithdrawCreate: function (onay) {
      $.toast({
        heading: "",
        text: "Processing! Please wait..",
        icon: "info",
        loader: true,
        loaderBg: "#9fd5ff",
        showHideTransition: "plain",
        position: "bottom-right",
        hideAfter: 5000,
      });
      var query = window.location.search.substring(1);
      var qs = query.split("=");
      if (onay == "M") {
        var code = $("#onay_kodu").val();
      } else if (onay == "G") {
        var code = $("#onay_kodu2").val();
      }
      $.post(base_url + "/wallet/userWithdrawCreate", {
        amount: $("#amount").val(),
        address: $("#address").val(),
        tag: $("#tag").val(),
        code: code,
        wallet: qs[1],
      }).done(function (data) {
        data = jQuery.parseJSON(data);
        if (data.durum == "success") {
          $("#withdrawModalEmail").modal("hide");
          $("#withdrawModal2FA").modal("hide");
          setTimeout(function () {
            //location.href = base_url+"wallet";
          }, 4000);
        }
        setTimeout(function () {
          $.toast({
            heading: "",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        }, 1000);
      });
    },

    withdrawCancel: function (id) {
      $.toast({
        heading: "",
        text: "Processing! Please wait..",
        icon: "info",
        loader: true,
        loaderBg: "#9fd5ff",
        showHideTransition: "plain",
        position: "bottom-right",
        hideAfter: 5000,
      });
      $.post(base_url + "/wallet/userWithdrawCancel", { withdrawID: id }).done(
        function (data) {
          data = jQuery.parseJSON(data);
          if (data.durum == "success") {
            $("#with_" + id).hide("slow");
          }
          setTimeout(function () {
            $.toast({
              heading: "",
              text: data.mesaj,
              icon: data.durum,
              loader: true,
              loaderBg: "#9fd5ff",
              showHideTransition: "plain",
              position: "bottom-right",
              hideAfter: 5000,
            });
          }, 1000);
        }
      );
    },

    depositCancel: function (walletShort, deptime) {
      $.toast({
        heading: "",
        text: "Processing! Please wait..",
        icon: "info",
        loader: true,
        loaderBg: "#9fd5ff",
        showHideTransition: "plain",
        position: "bottom-right",
        hideAfter: 5000,
      });
      $.post(base_url + "/wallet/userDepositCancel", {
        walletShort: walletShort,
        deptime: deptime,
      }).done(function (data) {
        data = jQuery.parseJSON(data);
        if (data.durum == "success") {
          $("#dep_" + walletShort + deptime).hide("slow");
        }
        setTimeout(function () {
          $.toast({
            heading: "",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        }, 1000);
      });
    },

    transactionsDetailModal: function (
      markerShort,
      amount,
      address,
      tag,
      txid,
      time
    ) {
      var date = new Date(time * 1000).toLocaleString();
      $("#modalShort").html(markerShort);
      $("#modalAmount").html(amount);
      $("#modalDate").html(time);
      $("#modalAddress").html(address);
      $("#modalTag").html(tag);
      $("#modaTxid").html(
        `<a href="${txid}" target="_blank">${txid.split("/").reverse()[0]}</a>`
      );
      $("#transactionsModal").modal("show");
    },

    bankaSelect: function (bankinput) {
      var bankselectid = document.getElementById(bankinput).value;
      $.post(base_url + "/wallet/getBankaDetail", {
        bankid: bankselectid,
      }).done(function (data) {
        if (data) {
          data = jQuery.parseJSON(data);
          $("#iban_number").val(data[0].banka_iban);
          $("#sirket_adi").val(data[0].banka_hesap);
          $("#iban").show("slow");
          $("#checkBank").show("slow");
        } else {
          $("#iban").hide("slow");
          $.toast({
            heading: "",
            text: "Yatırmak için lütfen bir banka seçiniz.",
            icon: "info",
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        }
      });
    },

    createFiatDeposit: function () {
      $.toast({
        heading: "",
        text: "Processing! Please wait..",
        icon: "info",
        loader: true,
        loaderBg: "#9fd5ff",
        showHideTransition: "plain",
        position: "bottom-right",
        hideAfter: 5000,
      });
      $("#checkBankButton").attr("disabled", true);
      $.post(base_url + "/wallet/insertFiatDeposit", {
        bankid: document.getElementById("banka").value,
        depositamount: $("#fiat_amount").val(),
        depositcode: $("#islem_kodu").val(),
        walletShort: $("#wallet").html(),
      }).done(function (data) {
        data = jQuery.parseJSON(data);
        setTimeout(function () {
          $("#checkBankButton").attr("disabled", false);
          $.toast({
            heading: "",
            text: data.mesaj,
            icon: data.durum,
            loader: true,
            loaderBg: "#9fd5ff",
            showHideTransition: "plain",
            position: "bottom-right",
            hideAfter: 5000,
          });
        }, 2000);
      });
    },
  },
};

$(document).ready(async () => {
  customJS.auth.init();

  

  $('[data-toggle="tooltip"]').tooltip();
  $("#market-page").dataTable({
    language: {
      search: "_INPUT_",
      searchPlaceholder: search + "...",
    },
    info: false,
    lengthChange: false,
    autoWidth: false,
  });

  $("#wallet-page").dataTable({
    pageLength: 20,
    language: {
      search: "_INPUT_",
      searchPlaceholder: search + "...",
    },
    info: false,
    lengthChange: false,
    autoWidth: false,
    order: [[3, "desc"]],
  });

  $("#market-page-usdt").dataTable({
    language: {
      search: "_INPUT_",
      searchPlaceholder: search + "...",
    },
    info: false,
    lengthChange: false,
    autoWidth: false,
  });

  $(".btn").on("click", function () {
    var $this = $(this);
    var loadingText =
      '<i class="spinner-border spinner-border-sm"></i> loading...';
    if ($(this).html() !== loadingText) {
      $this.data("original-text", $(this).html());
      $this.html(loadingText);
    }
    setTimeout(function () {
      $this.html($this.data("original-text"));
    }, 2000);
  });

  $("#tradingHistory").dataTable({
    height: 350,
    info: false,
    lengthChange: false,
    autoWidth: false,
    scrollCollapse: true,
    paging: false,
    ordering: false,
    searching: false,
    scrollY: "350px",
  });

  $("#myTradingHistory").dataTable({
    language: {
      search: "_INPUT_",
      searchPlaceholder: search + "...",
    },
    height: 150,
    info: false,
    lengthChange: false,
    autoWidth: true,
    scrollY: "150px",
    scrollCollapse: true,
    paging: false,
  }),
    $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

  $("#activity").dataTable({
    language: {
      search: "_INPUT_",
      searchPlaceholder: search + "...",
    },
    info: false,
    lengthChange: false,
    autoWidth: false,
    searching: false,
    order: [[0, "desc"]],
  });

  $("#pendingWithdrawTable").dataTable({
    language: {
      search: "_INPUT_",
      searchPlaceholder: search + "...",
    },
    info: false,
    lengthChange: false,
    autoWidth: false,
    searching: true,
    order: [[1, "desc"]],
  });

  $("#WithdrawHistoryTable").dataTable({
    language: {
      search: "_INPUT_",
      searchPlaceholder: search + "...",
    },
    info: false,
    lengthChange: false,
    autoWidth: false,
    searching: true,
    order: [[1, "desc"]],
  });

  $("#pendingDepositTable").dataTable({
    language: {
      search: "_INPUT_",
      searchPlaceholder: search + "...",
    },
    info: false,
    lengthChange: false,
    autoWidth: false,
    searching: true,
    order: [[1, "desc"]],
  });

  $("#depositHistoryTable").dataTable({
    language: {
      search: "_INPUT_",
      searchPlaceholder: search + "...",
    },
    info: false,
    lengthChange: false,
    autoWidth: false,
    searching: true,
    order: [[1, "desc"]],
  });

  $("#statuspage").DataTable({
    language: {
      search: "_INPUT_",
      searchPlaceholder: search + "...",
    },
    scrollY: 600,
    paging: false,
    info: false,
    lengthChange: false,
    autoWidth: true,
    searching: true,
    order: [[1, "asc"]],
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

  $("#faucetpage").DataTable({
    language: {
      search: "_INPUT_",
      searchPlaceholder: search + "...",
    },
    scrollY: 600,
    paging: false,
    info: false,
    lengthChange: false,
    autoWidth: true,
    searching: true,
    order: [[1, "asc"]],
  });

  $(".custom-file-input").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });

  const RangeFrom1 = function () {
    document.getElementById("formControlRangefrom").max =
      $("#userFromBalance").html();
    document.getElementById("formControlRangeto").max =
      $("#userToBalance").html();
  };

  $(".banka_iban").mask("SS00 0000 0000 0000 0000 0000 00", {
    placeholder: "TR__ ____ ____ ____ ____ ____ __",
  });
});
