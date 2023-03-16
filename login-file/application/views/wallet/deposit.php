<?php include  __DIR__ . "/../include/header.php"; ?>

<div class="container">
  <div class="row mt-5">
    <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3 text-center">
      <h2 class="buyukharf"><?php echo lang("deposit"); ?> <span id="wallet"><?php echo $_GET["wallet"]; ?></span></h2>
    </div>
    <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3">
      <h3 class="font-size-15 ml-3 text-center">Please dont send deposits its still under development</h3>
    </div>
    <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3 mb-5">
      <form>
        <div class="form-group mt-3" id="depositInput">
          <?php if ($walletDetail["wallet_tag_system"] != '0') { ?>
          <div id="tagDiv" class="collapse">
            <label for="depositTagLabel"><?php echo lang("deposit"); ?> <?php echo lang("address"); ?> tag</label>
            <div class="input-group">
              <input type="text" class="form-control" id="receive_address_tag" aria-describedby="depositHelp">
              <div class="input-group-prepend">
                <button class="bg-light input-group-text border-left-0" onclick="customJS.wallet.copyAddressUni('receive_address_tag')" type="button" id="inputGroupPrepend3"><i class="fas fa-copy"></i></button>
              </div>
            </div>
          </div>
          <?php } ?>
          <div id="addressDiv" class="collapse">
            <label for="depositLabel"><?php echo lang("deposit"); ?> <?php echo lang("address"); ?></label>
            <div class="input-group">
              <input type="text" class="form-control" id="receive_address" aria-describedby="depositHelp">
              <div class="input-group-prepend">
                <button class="bg-light input-group-text border-left-0" onclick="customJS.wallet.copyAddressUni('receive_address')" type="button" id="inputGroupPrepend3"><i class="fas fa-copy"></i></button>
              </div>
            </div>
          </div>
        </div>
        <div id="barcodeDiv" class="collapse">
          <div class="input-group justify-content-center" id="qrcode"></div>
        </div>

        <?php if ($walletDetail["wallet_short"] != 'ETH' && $walletDetail["wallet_short"] != 'BNB' && substr($walletDetail['wallet_cont'], 0, 2) != '0x') { ?>
        <div class="col-12 text-center">
          <h3 class="font-size-15 ml-3">Only Ether and ERC-20 Tokens deposit are available</h3>
        </div>
        <?php } ?>
        <?php if ($walletDetail["wallet_short"] == 'ETH' || $walletDetail["wallet_short"] == 'BNB'|| substr($walletDetail['wallet_cont'], 0, 2) == '0x') { ?>
        <fieldset id="amountDiv" class="form-group mt-3">
          <div class="input-group">
            <input type="text" class="form-control" id="depositAmount" aria-describedby="depositHelp">
            <div class="input-group-prepend">
              <button class="bg-light input-group-text border-left-0" onclick="deposit('<?= $accountAddress ?>', '<?= $walletDetail["wallet_name"] ?>', '<?= $walletDetail["wallet_short"] ?>', '<?= $walletDetail["wallet_cont"] ?>', <?= $walletDetail["wallet_dec"] ?>, <?= $walletDetail["wallet_network"] ?? null ?>)" type="button" id="depositButton">deposit</button>
            </div>
          </div>
        </fieldset>
        <?php } ?>
      </form>
    </div>
  </div>
</div>
<p class="d-none" id="copysuc"><?php echo lang("copysuc"); ?></p>
<input type="hidden" id="userSecret" value="<?php echo yeniSifrele($_SESSION['user_data'][0]['user_id']); ?>">
<script>
  window.onload = () => {
    if (typeof window.ethereum === 'undefined') {
      $.toast({
        heading: '',
        text: 'Metamask is not accessible',
        icon: "error",
        loader: true,
        loaderBg: '#9fd5ff',
        showHideTransition: 'plain',
        position: 'bottom-right',
        hideAfter: 5000
      });
    }
  }

const deposit = async (toAddress, wallet, walletShort, walletContract, walletDecimals, walletNetwork) => {
  const apiUrl = '<?= base_url(); ?>' + 'api';
  provider = await web3Modal.connect();
  // Get a Web3 instance for the wallet
  var web3 = await new Web3(provider);
  // const web3 = new Web3(Web3.givenProvider);
  // const fromAddress = await getCurrentAddress();
  let fromAddress = await web3.eth.getAccounts();
  fromAddress = fromAddress[0];

  try {

    let amount = document.getElementById('depositAmount').value;
    // amount = web3.utils.toBN(amount * walletDecimals);
    amount = web3.extend.utils.toWei(amount);
    if (amount === "0") {
      throw new Error('invalid number value');
    }
    amount = web3.extend.utils.toHex(amount);


    const currentNetwork = parseInt(web3.currentProvider.chainId).toString();
    if(currentNetwork !== walletNetwork.toString()){
      // show error when trying to switch to ethereum
      if(walletNetwork.toString() === '1') {
        // only on production networks
        if(currentNetwork !== '4'){
          throw new Error('Please switch manually to Ethereum network');
        }
      } else {
        if(currentNetwork !== '97'){
          await switchToBinance(wallet, walletShort, walletDecimals);
        }
      }
    }

    let txId = '';
    // if it is not a custom token eg: ether
    if (!walletContract.startsWith('0x')) {

      // let contract = new web3.eth.Contract(minABI, walletContract);
      // // call transfer function
      // cons.log('contract methods', contract.methods);

      // txId = await ethereum.request({
      //   method: 'eth_sendTransaction',
      //   params: [{
      //     from: fromAddress,
      //     to: toAddress,
      //     value: amount
      //   }
      //   ],
      // })
      
      txId = await web3.eth.sendTransaction({
        to: toAddress,
        from: fromAddress,
        value: amount
      })

    } else {
      // get the amount
      let amount = parseFloat(document.getElementById('depositAmount').value);

      // calculate ERC20 token amount and transform it into big number
      let value = web3.utils.toBN(amount * walletDecimals);

      const minABI = [
        // transfer
        {
          "constant": false,
          "inputs": [
            {
              "name": "_to",
              "type": "address"
            },
            {
              "name": "_value",
              "type": "uint256"
            }
          ],
          "name": "transfer",
          "outputs": [
            {
              "name": "",
              "type": "bool"
            }
          ],
          "type": "function"
        }
      ];
      // Get ERC20 Token contract instance
      let contract = new web3.eth.Contract(minABI, walletContract);
      // call transfer function
      txId = await contract.methods.transfer(toAddress, value).send({
        from: fromAddress
      })
    }

    $.toast({
      heading: '',
      text: 'Successful operation',
      icon: "success",
      loader: true,
      loaderBg: '#9fd5ff',
      showHideTransition: 'plain',
      position: 'bottom-right',
      hideAfter: 5000
    });
    setTimeout(function() {
      window.location.href = '<?= base_url(); ?>' + 'wallet';
    }, 5000);

  } catch (error) {

    let message = error.message;
    if (error.message.includes('invalid number value')) {
      message = "Invalid amount value";
    }
    if (error.message.includes('not a positive number.')) {
      message = "Amount value must be positive";
    }

    $.toast({
      heading: '',
      text: message,
      icon: "error",
      loader: true,
      loaderBg: '#9fd5ff',
      showHideTransition: 'plain',
      position: 'bottom-right',
      hideAfter: 5000
    });
  }
}
// const getCurrentAddress = async () => {
//   try {
//     const accounts = await ethereum.request({
//       method: 'eth_requestAccounts'
//     });
//     return accounts[0];
//   } catch (error) {
//     alert('Could not detect a Metamask account');
//   }
// }

const switchToBinance = async (networkName, networkShort, decimals) => {
  if(window.ethereum) {
  const web3 = new Web3(window.ethereum);
    // const network = {
    //     name:'Smart Chain',
    //     number: web3.extend.utils.toHex(56),
    //     rpcUrl: 'https://bsc-dataseed.binance.org/',
    //     explorer: 'https://bscscan.com'
    //   }; // production
     const network = {
         name:'Smart Chain - Testnet',
         number: web3.extend.utils.toHex(97),
         rpcUrl: 'https://data-seed-prebsc-1-s1.binance.org:8545/',
         explorer: 'https://testnet.bscscan.com'
       }; // test

    try{
      window.ethereum.request({method: 'eth_requestAccounts'})
      await window.ethereum.request({
        method: 'wallet_addEthereumChain',
        params: [{chainId: `${network.number}`, //'0xa869',
          chainName: `${network.name}`, //"Fuji Testnet",
          nativeCurrency: {
            name: `${networkShort}`, //"AVAX",
            symbol: `${networkShort}`,//"AVAX",
            decimals: eval(decimals).toString().length -1 //18
          },
          rpcUrls: [network.rpcUrl],
          blockExplorerUrls: [network.explorer]
        }]
      })
      document.location.reload();

    } catch(e){
      $.toast({
        heading: '',
        text: e && e.message || e,
        icon: "error",
        loader: true,
        loaderBg: '#9fd5ff',
        showHideTransition: 'plain',
        position: 'bottom-right',
        hideAfter: 5000
      });
      return false;
    }
  }
}
</script>
<?php include  __DIR__ . "/../include/footer.php"; ?>
