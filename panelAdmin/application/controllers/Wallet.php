<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wallet extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		header('X-Frame-Options: SAMEORIGIN');
		// if(siteSetting()["site_status"]!=1 && $_SESSION['key']!="admin_bakim"){redirect('/maintenance');}
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
	}
	public function index()
	{
		$this->load->view('wallet');
	}
	public function singleWallet()
	{
		$short = $this->input->post('short');
		$veri = $this->admin_wallet_model->getWallet($short);
		if ($veri != "bos") {
			$data = $veri;
		} else {
			$data = array("durum" => 'error', "mesaj" => $veri);
		}
		echo json_encode($data);
	}

	public function deposit()
	{
		$this->load->view('wallet/deposit');
	}

	public function withdraw()
	{
    $data["withdraw"] = $this->admin_home_model->mainPageWithdraw();


    $data["withdraw"] = array_map(
      function($withdraw) { 
        if(strpos($withdraw["withdraw_txid"], " ") == false && strlen($withdraw["withdraw_txid"]) > 0){  
          $url = $withdraw['wallet_network'] == 1 || $withdraw['wallet_network'] == 4 ? "https://etherscan.io/tx/$withdraw[withdraw_txid]": "https://bscan.io/tx/withdraw[withdraw_txid]"; // production
          // $url = $withdraw['wallet_network'] == 1 || $withdraw['wallet_network'] == 4 ? "https://rinkeby.etherscan.io/tx/$withdraw[withdraw_txid]": "https://bscan.io/tx/withdraw[withdraw_txid]"; // testing
      $with = array_merge($withdraw, ['withdraw_txid_link' => "<a target='_blank' href=\"$url\">$withdraw[withdraw_txid]</a>"]);
        return $with;
        }
        return $withdraw;
     
      },
      $data['withdraw']
    );

    $this->load->view('wallet/withdraw', $data);
  }

	public function walletUpdate()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 5) {
			$short = $this->input->post('short');
			$satir = $this->input->post('satir');
			$postveri = $this->input->post('veri');
			$type = $this->input->post('type');
			if ($satir == "wallet_server_port" || $satir == "wallet_server_pass" || $satir == "wallet_server_username" || $satir == "wallet_password") {
				$postveri = yeniSifrele($postveri);
			}
			$veri = $this->admin_wallet_model->updateWallet($short, $satir, $postveri, $type);
			if ($veri == "ok") {
				$data = array("durum" => 'success', "mesaj" => "Update successful.");
			} else {
				$data = array("durum" => 'info', "mesaj" => "No update was made..");
			}
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}
		echo json_encode($data);
	}
	public function walletUpdateResim()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 5) {
			$short = $this->input->post('title');
			$upload = resimUpload("logo");
			if ($upload["durum"] == "ok") {
				$veri = $this->admin_wallet_model->updateWallet($short, "wallet_logo", $upload["data"]["file_name"], "1");
				$data = array("durum" => 'success', "mesaj" => "File Update successful.");
			} else {
				$data = array("durum" => 'error', "mesaj" => $upload["error"]);
			}
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}
		echo json_encode($data);
	}

	public function walletUpdateInfo()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 5) {
			$short = $this->input->post('short');
			$satir = $this->input->post('satir');
			$postveri = $this->input->post('veri');
			$type = $this->input->post('type');
			$veri = $this->admin_wallet_model->updateWalletInfo($short, $satir, $postveri, $type);
			if ($veri == "ok") {
				$data = array("durum" => 'success', "mesaj" => "Update successful.");
			} else {
				$data = array("durum" => 'info', "mesaj" => "No update was made..");
			}
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}
		echo json_encode($data);
	}

	public function walletMarketSor()
	{
		$fromShort = $this->input->post('fromshort');
		$toshort = $this->input->post('toshort');
		$data = array("durum" => adminMarketSetting($fromShort, $toshort), "short" => $fromShort);
		echo json_encode($data);
	}

	public function walletMarketUpdate()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 5) {
			$short = $this->input->post('short');
			$toshort = $this->input->post('toshort');
			$walletID = $this->input->post('walletID');
			$toWalletID = $this->input->post('toWalletID');
			$toWalletName = $this->input->post('toWalletName');
			$postveri = $this->input->post('veri');
			$pairId = $this->input->post('pairId');
			$veri = $this->admin_wallet_model->walletMarketUpdate($short, $toshort, $postveri, $walletID, $toWalletID, $toWalletName, $pairId);
			if ($veri == "ok") {
				$data = array("durum" => 'success', "mesaj" => "Update successful.");
			} else {
				$data = array("durum" => 'info', "mesaj" => "No update was made..");
			}
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}
		echo json_encode($data);
	}

	public function walletMarketUpdateDecimal()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 5) {
			$short = $this->input->post('short');
			$toshort = $this->input->post('toshort');
			$priceDecimal = (int)$this->input->post('priceDec');
			$amountDecimal = (int)$this->input->post('amountDec');
			$totalDecimal = (int)$this->input->post('totalDec');
			$veri = $this->admin_wallet_model->walletMarketUpdateDecimal($short, $toshort, $priceDecimal, $amountDecimal, $totalDecimal);
			if ($veri == "ok") {
				$data = array("durum" => 'success', "mesaj" => "Update successful.");
			} else {
				$data = array("durum" => 'info', "mesaj" => "No update was made..");
			}
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}
		echo json_encode($data);
	}

	public function addwallet()
	{
		if ($_POST) {
			if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 5) {
				$walletID = $this->input->post('wallet_id');
				$walletShort = $this->input->post('wallet_short');
				$walletName = $this->input->post('wallet_name');
				$walletSystem = $this->input->post('wallet_system');
				$walletNetwork = $this->input->post('wallet_network');
				$insert = $this->admin_wallet_model->insertWallet($walletID, $walletShort, $walletName, $walletSystem, $walletNetwork);
			} else {
				$this->session->set_flashdata('hata', 'You are not authorized to perform this operation.!');
			}
		}
		$data["wallet_id"] = $this->admin_wallet_model->walletIDSor();
		$this->load->view('wallet/add_wallet', $data);
	}

	public function sendWithdrawTransaction()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 4) {
			if ($this->input->post("googleCode")) {
				$withid = $this->input->post("withid");
				$withuserid = $this->input->post("withuserid");
				$withuseremail = $this->input->post("withuseremail");
				$withtxid = $this->input->post("withtxid");
				$withamount = $this->input->post("withamount");
				$withaddress = $this->input->post("withaddress");
				$withcont = $this->input->post("withcont");
				$withtag = $this->input->post("withtag");
				$walletShort = $this->input->post("walletShort");
				$googleCode = $this->input->post("googleCode");
				$withOption = $this->input->post("sendoption");
				if (is_numeric($googleCode) && getUserGoogleCodeKontrol(yeniSifreCoz($_SESSION['user_data_admin'][0]['admin_google_key']), $googleCode) == "ok") {
					$walletInfo = $this->admin_wallet_model->getWalletInfo($walletShort);
					$withdrawInfo = $this->admin_wallet_model->getWithdrawInfo($withid, $withuserid, $withaddress);
					if ($withdrawInfo == "bos") {
						$data = array("durum" => 'error', "mesaj" => "No such withdrawal request!");
					} elseif ($withdrawInfo[0]["withdraw_status"] != 0 && $withOption == 1) {
						$data = array("durum" => 'error', "mesaj" => "Withdraw operation completed or canceled. Please refresh the page!");
					} elseif ($walletInfo == "bos") {
						$data = array("durum" => 'error', "mesaj" => "This wallet is not valid!");
						//}elseif($walletInfo[0]["wallet_balance"]<$withamount && $walletInfo[0]["wallet_system"]!="fiat"){
						$data = array("durum" => 'error', "mesaj" => "The amount withdrawn is more than the wallet balance!");
					} elseif ($walletInfo[0]["wallet_with_status"] != 1) {
						$data = array("durum" => 'error', "mesaj" => "Wallet is closed the withdrawal process!");
					} else {
						$send = $this->admin_wallet_model->withdrawConfirm($walletInfo, $withid, $withuserid, $withuseremail, $withtxid, $withamount, $withaddress, $withcont, $withtag, $walletShort, $googleCode);
						if ($send == "ripple") {
							$data = array("durum" => 'xrpSend', "key" => $_SESSION['user_data_admin'][0]['admin_email'], 'sec' => $walletInfo[0]["wallet_password"]);
						} else {
							if (!empty($send)) {
								if ($send["error"] == "Code Error") {
									$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
								} else {
									$data = array("durum" => 'result', "mesaj" => $send);
								}
							} else {
								$data = array("durum" => 'error', "mesaj" => "Error!" . $walletShort);
							}
						}
					}
				} else {
					$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
				}
			} else {
				$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
			}
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}
		echo json_encode($data);
	}
	public function registerWithdraw()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 4) {
			// if ($this->input->post("googleCode")) {
				$withid = $this->input->post("withid");
				$withuserid = $this->input->post("withuserid");
				$withuseremail = $this->input->post("withuseremail");
				$withtxid = $this->input->post("withtxid");
				$withamount = $this->input->post("withamount");
				$withaddress = $this->input->post("withaddress");
				$withcont = $this->input->post("withcont");
				$withtag = $this->input->post("withtag");
				$walletShort = $this->input->post("walletShort");
				// $googleCode = $this->input->post("googleCode");
				$withOption = $this->input->post("sendoption");
        // if (is_numeric($googleCode) && getUserGoogleCodeKontrol(yeniSifreCoz($_SESSION['user_data_admin'][0]['admin_google_key']), $googleCode) == "ok") {
					$walletInfo = $this->admin_wallet_model->getWalletInfo($walletShort);
					$withdrawInfo = $this->admin_wallet_model->getWithdrawInfo($withid, $withuserid, $withaddress);
					if ($withdrawInfo == "bos") {
						$data = array("durum" => 'error', "mesaj" => "No such withdrawal request!");
					} elseif ($withdrawInfo[0]["withdraw_status"] != 0 && $withOption == 1) {
						$data = array("durum" => 'error', "mesaj" => "Withdraw operation completed or canceled. Please refresh the page!");
					} elseif ($walletInfo == "bos") {
						$data = array("durum" => 'error', "mesaj" => "This wallet is not valid!");
						//}elseif($walletInfo[0]["wallet_balance"]<$withamount && $walletInfo[0]["wallet_system"]!="fiat"){
						$data = array("durum" => 'error', "mesaj" => "The amount withdrawn is more than the wallet balance!");
					} elseif ($walletInfo[0]["wallet_with_status"] != 1) {
						$data = array("durum" => 'error', "mesaj" => "Wallet is closed the withdrawal process!");
					} else {
						$send = $this->admin_wallet_model->confirmWithdrawMetamask($walletInfo, $withid, $withuserid, $withuseremail, $withtxid, $withamount, $withaddress, $withcont, $withtag, $walletShort, $googleCode);
						if ($send == "ripple") {
							$data = array("durum" => 'xrpSend', "key" => $_SESSION['user_data_admin'][0]['admin_email'], 'sec' => $walletInfo[0]["wallet_password"]);
						} else {
							if (!empty($send)) {
								if ($send["error"] == "Code Error") {
									$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
								} else {
									$data = array("durum" => 'result', "mesaj" => $send);
								}
							} else {
								$data = array("durum" => 'error', "mesaj" => "Error!" . $walletShort);
							}
						}
					}
				// } else {
				// 	$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
				// }
			// } else {
			// 	$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
			// }
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}
		echo json_encode($data);
	}

	public function cancelWithdrawTransaction()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 4) {
			if ($this->input->post("googleCode")) {
				$withid = $this->input->post("withid");
				$withuserid = $this->input->post("withuserid");
				$withtxid = $this->input->post("withtxid");
				$withamount = $this->input->post("withamount");
				$withaddress = $this->input->post("withaddress");
				$googleCode = $this->input->post("googleCode");
				$coinShort = $this->input->post("coinShort");
				if (is_numeric($googleCode) && getUserGoogleCodeKontrol(yeniSifreCoz($_SESSION['user_data_admin'][0]['admin_google_key']), $googleCode) == "ok") {
					$update = $this->admin_wallet_model->getWithdrawCancel($withid, $withuserid, $withaddress, $withtxid, $withamount, $coinShort);
					if ($update == "ok") {
						$data = array("durum" => 'success', "mesaj" => "The withdrawal was canceled.");
					} else {
						$data = array("durum" => 'error', "mesaj" => "Failed to cancel withdrawal. (" . $update . " )");
					}
				} else {
					$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
				}
			} else {
				$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
			}
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}
		echo json_encode($data);
	}

	public function deleteWithdrawTransaction()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 5) {
			if ($this->input->post("googleCode")) {
				$withid = $this->input->post("withid");
				$withuserid = $this->input->post("withuserid");
				$withtxid = $this->input->post("withtxid");
				$googleCode = $this->input->post("googleCode");
				if (is_numeric($googleCode) && getUserGoogleCodeKontrol(yeniSifreCoz($_SESSION['user_data_admin'][0]['admin_google_key']), $googleCode) == "ok") {
					$update = $this->admin_wallet_model->getWithdrawDelete($withid, $withuserid, $withtxid);
					if ($update == "ok") {
						$data = array("durum" => 'success', "mesaj" => "The withdrawal was deleted.");
					} else {
						$data = array("durum" => 'error', "mesaj" => "Failed to deleted withdrawal.");
					}
				} else {
					$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
				}
			} else {
				$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
			}
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}
		echo json_encode($data);
	}

	public function walletsetting()
	{
		$this->load->view('wallet/wallet_setting');
	}

	public function allwalletchange()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 5) {
			if ($this->input->post("googleCode")) {
				$sutun = $this->input->post("sutun");
				$deger = $this->input->post("deger");
				$type = $this->input->post("ttt");
				$googleCode = $this->input->post("googleCode");
				if (is_numeric($googleCode) && getUserGoogleCodeKontrol(yeniSifreCoz($_SESSION['user_data_admin'][0]['admin_google_key']), $googleCode) == "ok") {
					$update = $this->admin_wallet_model->allwalletchange($sutun, $deger, $type);
					if ($update == "ok") {
						$data = array("durum" => 'success', "mesaj" => "Wallet setting update");
					} else {
						$data = array("durum" => 'error', "mesaj" => "Wallet setting not update");
					}
				} else {
					$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check." . $sutun . $deger);
				}
			} else {
				$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
			}
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}
		echo json_encode($data);
	}
	public function fiat()
	{
		$walletShort = $this->input->post("short");
		$sor = $this->admin_wallet_model->fiat($walletShort);
		if ($sor != "bos") {
			$data = $sor;
		} else {
			$data = array("durum" => 'error');
		}
		echo json_encode($data);
	}
	public function walletBankUpdate()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 5) {
			$bankid = $this->input->post('bankid');
			$status = $this->input->post('status');
			$veri = $this->admin_wallet_model->walletBankUpdate($bankid, $status);
			if ($veri == "ok") {
				$data = array("durum" => 'success', "mesaj" => "Update successful.");
			} else {
				$data = array("durum" => 'info', "mesaj" => "No update was made..");
			}
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}
		echo json_encode($data);
	}

	public function fiatDepositConfirm()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 4) {
			if ($this->input->post("googleCode")) {
				$email = $this->input->post("email");
				$userid = $this->input->post("userid");
				$depid = $this->input->post("depid");
				$islemcode = $this->input->post("islemcode");
				$walletShort = $this->input->post("walletShort");
				$googleCode = $this->input->post("googleCode");
				if (is_numeric($googleCode) && getUserGoogleCodeKontrol(yeniSifreCoz($_SESSION['user_data_admin'][0]['admin_google_key']), $googleCode) == "ok") {
					$update = $this->admin_wallet_model->fiatDepositConfirm($email, $userid, $depid, $islemcode, $walletShort);
					if ($update == "ok") {
						$data = array("durum" => 'success', "mesaj" => "Deposit confirm success");
					} elseif ($update == "bakiye") {
						$data = array("durum" => 'error', "mesaj" => "An error occurred while processing the balance.");
					} else {
						$data = array("durum" => 'error', "mesaj" => "Deposit not confirm!" . $update);
					}
				} else {
					$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
				}
			} else {
				$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
			}
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}
		echo json_encode($data);
	}

	public function walletDepositChange()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 5) {
			if ($this->input->post("googleCode")) {
				$veri = $this->input->post('veri');
				$type = $this->input->post('type');
				$sutun = $this->input->post('sutun');
				$userID = $this->input->post('userid');
				$googleCode = $this->input->post("googleCode");
				$veriID = $this->input->post('veriID');
				if (is_numeric($googleCode) && getUserGoogleCodeKontrol(yeniSifreCoz($_SESSION['user_data_admin'][0]['admin_google_key']), $googleCode) == "ok") {
					$veri = $this->admin_wallet_model->walletDepositChange($veriID, $veri, $type, $sutun, $userID);
					if ($veri == "ok") {
						$data = array("durum" => 'success', "mesaj" => "Update successful.");
					} else {
						$data = array("durum" => 'info', "mesaj" => "No update was made..");
					}
				} else {
					$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
				}
			} else {
				$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
			}
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}
		echo json_encode($data);
	}

	public function deleteFiatDeposit()
	{
		$delete = $this->admin_wallet_model->deleteFiatDeposit();
		if ($delete == "ok") {
			$data = array("durum" => 'success', "mesaj" => "Delete fiat deposit successful.");
		} else {
			$data = array("info" => 'success', "mesaj" => "No pending fiat deposit.");
		}
		echo json_encode($data);
	}

	public function orderbook()
	{
		$data["marketList"] = $this->admin_wallet_model->getAllMarket();
		$this->load->view('wallet/orderbook', $data);
	}

	public function tradehistory()
	{
		$data["marketList"] = $this->admin_wallet_model->getAllMarket();
		$this->load->view('wallet/tradehistory', $data);
	}

	public function cancelOpenOrder()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 6) {
			if ($this->input->post("googleCode")) {
				$email = $this->input->post('email');
				$orderID = $this->input->post('orderID');
				$userID = $this->input->post('userID');
				$googleCode = $this->input->post("googleCode");
				$time = $this->input->post('time');
				if (is_numeric($googleCode) && getUserGoogleCodeKontrol(yeniSifreCoz($_SESSION['user_data_admin'][0]['admin_google_key']), $googleCode) == "ok") {
					$data = $this->admin_wallet_model->cancelOpenOrder($email, $userID, $orderID, $time);
				} else {
					$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
				}
			} else {
				$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
			}
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}
		echo json_encode($data);
	}

	public function deleteDeposit()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 6) {
			if ($this->input->post("googleCode")) {
				$depId = $this->input->post('deposiId');

				$googleCode = $this->input->post("googleCode");
				if (is_numeric($googleCode) && getUserGoogleCodeKontrol(yeniSifreCoz($_SESSION['user_data_admin'][0]['admin_google_key']), $googleCode) == "ok") {
					$result = $this->admin_wallet_model->deleteDeposit($depId);
					if ($result == "ok") {
						$data = array("durum" => 'success', "mesaj" => "Delete deposit successful.");
					}
				} else {
					$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
				}
			} else {
				$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
			}
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}
		echo json_encode($data);
	}

	public function walletTotalResult()
	{
		$walletShort = $this->input->post('walletshort');
		$data = $this->admin_wallet_model->walletTotalResult($walletShort);
		echo json_encode($data);
	}

	public function walletUserBalance()
	{
		$walletShort = $this->input->post('walletshort');
		$data = $this->admin_wallet_model->walletUserBalance($walletShort);
		echo json_encode($data);
	}
}
