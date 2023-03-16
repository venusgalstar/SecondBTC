<?php include  __DIR__ . "/../include/header.php"; ?>

<div class="container text-white">
    <div class="row mt-5">
        <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3 text-center">
            <h2 class="buyukharf"><?php echo lang("deposit"); ?> <span id="wallet"><?php echo $_GET["wallet"]; ?></span></h2>
        </div>
        <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3">
            <h3 class="font-size-15 ml-3 text-center">Please wait for transaction confirmation after deposit </h3>
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

                <!-- if native coin -->
                <?php if ($walletDetail["wallet_short"] != 'GETH' && $walletDetail["wallet_short"] != 'ETH' && $walletDetail["wallet_short"] != 'BNB' && substr($walletDetail['wallet_cont'], 0, 2) != '0x') { ?>
                    <div class="col-12 text-center">
                        <h3 class="font-size-15 ml-3">Only Ether and ERC-20 Tokens deposit are available</h3>
                    </div>
                <?php } ?>

                <!-- if token -->
                <?php if ($walletDetail["wallet_short"] == 'GETH' || $walletDetail["wallet_short"] == 'ETH' || $walletDetail["wallet_short"] == 'BNB' || substr($walletDetail['wallet_cont'], 0, 2) == '0x') { ?>
                    <fieldset id="amountDiv" class="form-group mt-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="depositAmount" aria-describedby="depositHelp">
                            <div class="input-group-prepend">
                                <button class="input-group-text border-left-0 btn-sell" onclick="deposit('<?= $accountAddress ?>', '<?= $walletDetail["wallet_name"] ?>', '<?= $walletDetail["wallet_short"] ?>', '<?= $walletDetail["wallet_cont"] ?>', <?= $walletDetail["wallet_dec"] ?>, <?= $walletDetail["wallet_network"] ?? null ?>)" type="button" id="depositButton">deposit</button>
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

    const isNetworkAllowed = async () => {
        const web3 = window.__web3;
        console.log('is network allowed: ', web3);
        const currentChainID = await web3.eth.getChainId();
        const walletNetworkID = '<?= $walletDetail["wallet_network"] ?? null ?>';

        console.log('current chain id: ', currentChainID);
        console.log('wallet network id: ', walletNetworkID);
        console.log("test network: ", parseInt(walletNetworkID) === parseInt(currentChainID))
        return parseInt(walletNetworkID) === parseInt(currentChainID);
    }

    const getWalletChainData = () => {
        const walletNetworkID = '<?= $walletDetail["wallet_network"] ?? null ?>';
        return window.evmChains.getChain(parseInt(walletNetworkID));
    }
    
    window.onload = async () => {
        console.log('wallet details: ', <?php echo json_encode($walletDetail) ?>)
        // console.log('loaded: ', !(await isNetworkAllowed()));
        // if(!(await isNetworkAllowed())){
            
        //     const chainData = getWalletChainData();
        //     return Swal.fire({
        //         title: 'Error!',
        //         text: `Please switch your network manually to - ${chainData?.name || 'Ethereum'}` ,
        //         icon: 'error',
        //         confirmButtonText: 'Okay'
        //     })
        // }

        // console.log('windows__web3', window.__web3)
        // if (typeof window.ethereum === 'undefined') {
        //     $.toast({
        //         heading: '',
        //         text: 'Metamask is not accessible',
        //         icon: "error",
        //         loader: true,
        //         loaderBg: '#9fd5ff',
        //         showHideTransition: 'plain',
        //         position: 'bottom-right',
        //         hideAfter: 5000
        //     });
        // }
    }

    const deposit = async (toAddress, wallet, walletShort, walletContract, walletDecimals, walletNetwork) => {// alert();
        console.log('deposit: ', !(await isNetworkAllowed()));
        if(!(await isNetworkAllowed())){
            
            const chainData = getWalletChainData();
            return Swal.fire({
                title: 'Error!',
                text: `Please switch your network manually to - ${chainData?.name || 'Ethereum'}` ,
                icon: 'error',
                confirmButtonText: 'Okay'
            })
        }
        // console.log("web3 give provider: ", Web3.givenProvider);
        // console.log('-0-0-0-: ', provider)
        const apiUrl = '<?= base_url(); ?>' + 'api';
        // const web3 = new Web3(provider);
        const web3 = window.__web3;
        // console.log('------------>>> web3; ', web3);
        const fromAddress = await getCurrentAddress();

        //toAddress = "0x238dD61D45604Da78Ba98667407704E503084074";

//         $.post('<?= base_url(); ?>' + "/wallet/userDeposit", {
// 						depositamount: 1,
// 						//depositcode: $("#islem_kodu").val(),
// 						walletShort: walletShort,
// 						toAddress: toAddress,
// 						fromAddress: fromAddress,
// 						depositcode: '11',
// 					}).done(function (data) {
// 						data = jQuery.parseJSON(data);
//                         console.log('user deposit data: ', data);
// 						setTimeout(function () {
// 						  $("#checkBankButton").attr("disabled", false);
// 						  $.toast({
// 							heading: "",
// 							text: data.mesaj,
// 							icon: data.durum,
// 							loader: true,
// 							loaderBg: "#9fd5ff",
// 							showHideTransition: "plain",
// 							position: "bottom-right",
// 							hideAfter: 5000,
// 						  });
// 						}, 2000);
// 					});
        
// return;
        // const x = await web3.eth.getTransactionReceipt('0x527a07b7a6ca140e8458a4ebb02283b0d26dac7c998437ec40f1019e92aae8f5');
        // const logs1 = x.logs;
        // const log1 = logs1.find(i => i.transactionHash == '0x527a07b7a6ca140e8458a4ebb02283b0d26dac7c998437ec40f1019e92aae8f5');
        // // console.log('log: ', log);
        // let value1 = await web3.eth.abi.decodeParameter('uint256', log1.data)
        // // return console.log(web3.utils.fromWei(x.value));
        // console.log(x, value1);
        // console.log('pow: ', web3.utils.BN(10).pow(web3.utils.BN(6)).toString())
        // return console.log(value1/web3.utils.BN(10).pow(web3.utils.BN(6)).toString())
        
        // testing account
        
        if(fromAddress != localStorage.getItem("signVerified")){
            return $.toast({
                heading: "",
                text: 'Please verify your signature in your wallet.',
                icon: "error",
                loader: true,
                loaderBg: "#9fd5ff",
                showHideTransition: "plain",
                position: "bottom-right",
                hideAfter: 5000,
            });
        }
	/*
web3.eth.getTransaction('0xe0d451c424d1dc11ede1ba23a1869c4b3deae104bfc68e835802ccc4511af06f',function(error, result) {
  console.log(result);
}); */


                    // return console.log('tx Receipt: ', await web3.eth.getTransactionReceipt('0x11f7ea31fb40036643633c1ef73ab62c59eba99aae47dd7656f5b172db735a93'));
        try {
            
			$.post('<?= base_url(); ?>' + "/wallet/userDepositCheck", {
				depositamount: document.getElementById('depositAmount').value,
				walletShort: walletShort,
				toAddress: toAddress,
				fromAddress: fromAddress
			})
            .done(async function (data) {
				data = jQuery.parseJSON(data);

				if(data.durum == 'success'){
					
					let amount = document.getElementById('depositAmount').value;
					// amount = web3.utils.toBN(amount * walletDecimals);
					amount = web3.extend.utils.toWei(amount);
                    
					if (amount === "0") {
						throw new Error('invalid number value');
					}
					amount = web3.extend.utils.toHex(amount);

					const currentNetwork = await web3.eth.getChainId();
					if (currentNetwork !== walletNetwork) {
						// show error when trying to switch to ethereum
						if (walletNetwork.toString() === '1') {
							// only on production networks
							if (currentNetwork !== '4') {
                                return $.toast({
                                    heading: "",
                                    text: 'Please switch manually to Ethereum network',
                                    icon: "error",
                                    loader: true,
                                    loaderBg: "#9fd5ff",
                                    showHideTransition: "plain",
                                    position: "bottom-right",
                                    hideAfter: 5000,
                                });
								// throw new Error('Please switch manually to Ethereum network');
							}
						} else {
							// if (currentNetwork !== '97') {
							// 	await switchToBinance(wallet, walletShort, walletDecimals);
							// }
						}
					}

                    let txId = '';
                    let amountfinal = 0;
					// if it is not a custom token eg: ether
					if (!walletContract.startsWith('0x')) {
                        // call transfer function
						try{
                            // notification
                            Swal.fire({
                                title: 'Info',
                                text: `Please confirm transation in you wallet.` ,
                                icon: 'info',
                                confirmButtonText: 'Okay'
                            })
                            txId = await web3.eth.sendTransaction({
                                from: fromAddress,
                                to: toAddress,
                                value: amount
                            });
                        }catch(er){
                            return Swal.fire({
                                title: 'Error',
                                text: er.message || 'Transaction rejected',
                                icon: 'error',
                                confirmButtonText: 'Okay'
                            });
                        }

                        const txDetails = await web3.eth.getTransaction(txId.transactionHash);
                        console.log('txDetails: ', txDetails);
                        amountfinal = ((txDetails.value || amount)/walletDecimals);

					} else {
						// get the amount
						let amount = parseFloat(document.getElementById('depositAmount').value);

						// calculate ERC20 token amount and transform it into big number
						let value = web3.utils.toBN(amount * walletDecimals);

						const minABI = [
							// transfer
							{
								"constant": false,
								"inputs": [{
										"name": "_to",
										"type": "address"
									},
									{
										"name": "_value",
										"type": "uint256"
									}
								],
								"name": "transfer",
								"outputs": [{
									"name": "",
									"type": "bool"
								}],
								"type": "function"
							}
						];
						// Get ERC20 Token contract instance
						let contract = new web3.eth.Contract(minABI, walletContract);

                        // notification
                        Swal.fire({
                            title: 'Info',
                            text: `Please confirm transation in you wallet.` ,
                            icon: 'info',
                            confirmButtonText: 'Okay'
                        })

						// call transfer function
						try{
                            txId = await contract.methods.transfer(toAddress, value).send({
                                from: fromAddress
                            });
                        }catch(er){
                            return Swal.fire({
                                title: 'Error',
                                text: er.message || 'Transaction rejected',
                                icon: 'error',
                                confirmButtonText: 'Okay'
                            });
                        }

                        console.log("contract transfer txid: ", txId);

                        let rawData = 0;
                        for (const k in txId.events) {
                            let event = txId.events[k];
                            if(event.transactionHash == txId.transactionHash){
                                rawData = event?.raw?.data || 0;
                            }
                        }
                        
                        const txvalue = await web3.eth.abi.decodeParameter('uint256', rawData);
                        amountfinal = (txvalue/walletDecimals);
					}

					$.post('<?= base_url(); ?>' + "/wallet/userDeposit", {
						depositamount: amountfinal,
						//depositcode: $("#islem_kodu").val(),
						walletShort: walletShort,
						toAddress: toAddress,
						fromAddress: fromAddress,
						depositcode: txId.transactionHash,
					}).done(function (data) {
						data = jQuery.parseJSON(data);
                        // console.log('user deposit data: ', data);
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

					setTimeout(function() {
					   window.location.href = '<?= base_url(); ?>' + 'wallet';
					}, 5000); 
				}else{
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
				}
			    // $.toast({
				// 	heading: '',
				// 	text: 'Successful operation',
				// 	icon: "success",
				// 	loader: true,
				// 	loaderBg: '#9fd5ff',
				// 	showHideTransition: 'plain',
				// 	position: 'bottom-right',
				// 	hideAfter: 5000
				// });
            });
        } catch (error) {
            console.log('catch: ', error);

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
    const getCurrentAddress = async () => {
        try {
            // const accounts = await ethereum.request({
            //     method: 'eth_requestAccounts'
            // });
            const accounts = await window.__web3.eth.getAccounts();
            // console.log('------->>>> get current address accounts: ', accounts);
            return accounts[0].toLowerCase();
        } catch (error) {
            alert('Could not detect a Metamask account');
        }
    }

    const switchToBinance = async (networkName, networkShort, decimals) => {
        if (window.ethereum) {
            const web3 = new Web3(window.ethereum);
            // const network = {
            //     name:'Smart Chain',
            //     number: web3.extend.utils.toHex(56),
            //     rpcUrl: 'https://bsc-dataseed.binance.org/',
            //     explorer: 'https://bscscan.com'
            //   }; // production
            const network = {
                name: 'Smart Chain - Testnet',
                number: web3.extend.utils.toHex(97),
                rpcUrl: 'https://data-seed-prebsc-1-s1.binance.org:8545/',
                explorer: 'https://testnet.bscscan.com'
            }; // test

            try {
                window.ethereum.request({
                    method: 'eth_requestAccounts'
                })
                await window.ethereum.request({
                    method: 'wallet_addEthereumChain',
                    params: [{
                        chainId: `${network.number}`, //'0xa869',
                        chainName: `${network.name}`, //"Fuji Testnet",
                        nativeCurrency: {
                            name: `${networkShort}`, //"AVAX",
                            symbol: `${networkShort}`, //"AVAX",
                            decimals: eval(decimals).toString().length - 1 //18
                        },
                        rpcUrls: [network.rpcUrl],
                        blockExplorerUrls: [network.explorer]
                    }]
                })
                document.location.reload();

            } catch (e) {
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