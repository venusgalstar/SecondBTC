<?php
defined('BASEPATH') or exit('No direct script access allowed');

use kornrunner\Keccak;

require_once(APPPATH . 'libraries/php-ecrecover/ecrecover_helper.php');
class Wallet extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		dilBul();
		header('X-Frame-Options: SAMEORIGIN');
		// if(siteSetting()["site_status"]!=1 && $_SESSION['key']!="admin_bakim"){redirect('/maintenance');}
		if ($_SESSION['user_data'][0]['user_id'] == '') {
			redirect('/login');
		}
	}
	public function index()
	{
		$userID = $_SESSION['user_data'][0]['user_id'];
		$email = $_SESSION['user_data'][0]['user_email'];

		$data['WalletInfo'] = $this->wallet_model->getWallet();
		$data['withdrawHistory'] = $this->wallet_model->withdrawHistory($userID, $email);
    $data["withdrawHistory"] = array_map(
      function($withdraw) {
        if(strpos($withdraw["withraw_txid"], " ") == false && strlen($withdraw["withdraw_txid"]) > 0){
          $url = $withdraw['wallet_network'] == 1 || $withdraw['wallet_network'] == 4 ? "https://etherscan.io/tx/$withdraw[withdraw_txid]": "https://bscscan.com/tx/$withdraw[withdraw_txid]"; // production
          // $url = $withdraw['wallet_network'] == 1 || $withdraw['wallet_network'] == 4 ? "https://rinkeby.etherscan.io/tx/$withdraw[withdraw_txid]": "https://testnet.bscscan.com/tx/$withdraw[withdraw_txid]"; // testing
          $dep = array_merge($withdraw, ['withdraw_txid_link' => "$url"]);
          return $dep;
        }
        return $withdraw;
      },
      $data['withdrawHistory']
    );
		$data['depositHistory'] = $this->wallet_model->depositHistory($userID, $email);

    $data["depositHistory"] = array_map(
      function($deposit) {
        if(strpos($deposit["dep_history_txid"], " ") == false && strlen($deposit["dep_history_txid"]) > 0){
          $url = $deposit['wallet_network'] == 1 || $deposit['wallet_network'] == 4 ? "https://etherscan.io/tx/$deposit[dep_history_txid]": "https://bscscan.com/tx/$deposit[dep_history_txid]"; // production
          // $url = $deposit['wallet_network'] == 1 || $deposit['wallet_network'] == 4 ? "https://rinkeby.etherscan.io/tx/$deposit[dep_history_txid]": "https://testnet.bscscan.com/tx/$deposit[dep_history_txid]"; // testing
      $dep = array_merge($deposit, ['dep_txid_link' => "$url"]);
        return $dep;
        }
        return $deposit;
      },
      $data['depositHistory']
    );

		$this->load->view('wallet', $data);
	}
	public function withdraw()
	{
		$userID = $_SESSION['user_data'][0]['user_id'];
		$email = $_SESSION['user_data'][0]['user_email'];
		if (!empty($userID) && !empty($email)) {
			$walletShort = addslashes($_GET['wallet']);
			$data['walletDetail'] = $this->wallet_model->getWalletShort($walletShort);
			if (!empty($data['walletDetail'])) {
				$data['userDetail'] = $this->wallet_model->getUser($userID, $email);
				if ($data['walletDetail'][0]["wallet_system"] == "fiat") {
					$data['dataBanks'] = $this->mylibraries->trbanks();
					$this->load->view('wallet/withdrawTR', $data);
				} else {

					$this->load->view('wallet/withdraw', $data);
				}
			} else {
				redirect('/wallet');
			}
		} else {
			redirect('/404');
		}
	}
	public function deposit()
	{
		$this->load->library('AccountMonitor');
		$data['accountAddress'] = $this->accountmonitor->getAccountAddress();
		$userID = $_SESSION['user_data'][0]['user_id'];
		$email = $_SESSION['user_data'][0]['user_email'];
		if (!empty($userID) && !empty($email)) {
			$walletShort = addslashes($_GET['wallet']);
			$data['walletDetail'] = $this->wallet_model->getWalletShort($walletShort)[0];
			if (!empty($data['walletDetail'])) {
				if ($data['walletDetail']["wallet_system"] == "fiat") {
					$data['bankaDetail'] = $this->wallet_model->getBanka($walletShort);
					$this->load->view('wallet/depositTR', $data);
				} else {
					$this->load->view('wallet/deposit', $data);
				}
			} else {
				redirect('/wallet');
			}
		} else {
			redirect('/404');
		}
	}
	public function createAddress()
	{
		$userID = $_SESSION['user_data'][0]['user_id'];
		$email = $_SESSION['user_data'][0]['user_email'];
		$wallet = addslashes($this->input->post('wallet'));
		$wallet =  $this->security->xss_clean($wallet);
		if (!empty($userID) && !empty($email) && !empty($wallet)) {
			$walletDetail = $this->wallet_model->getWalletShort($wallet);
			if ($walletDetail[0]["wallet_dep_status"] == 1) {
				$sor = $this->wallet_model->walletAdresKontrol($userID, $email, $wallet);
				if (!empty($sor[0]["wallet_user_address"])) {
					$this->wallet_model->addressCheckTime($userID, $email, $wallet);
					$data = array("address" => $sor[0]["wallet_user_address"], "tag" => $sor[0]["wallet_user_tag"]);
				} else {
					$system = $walletDetail[0]["wallet_system"];
					$tokenCont = $walletDetail[0]["wallet_cont"];
					$decimal = $walletDetail[0]["wallet_dec"];
					$address = $this->wallet_model->createAddress($email, $userID, $walletDetail);
					if (!empty($address['address'])) {
						$this->wallet_model->addressCheckTime($userID, $email, $wallet);
						$data = array("address" => $address['address'], "tag" => $address['tag'], "mesaj" => lang("newaddress"), "durum" => "success");
					} else {
						$data = array("address" => '0', "tag" => '0', "mesaj" => lang("notnewaddress"), "durum" => "error");
					}
				}
			} else {
				$data = array("address" => '0', "tag" => '0', "mesaj" => lang("notdeposit"), "durum" => "error");
			}
		} else {
			$data = array("address" => '0', "tag" => '0', "mesaj" => lang("errordatas"), "durum" => "error");
		}
		echo json_encode($data);
	}
	public function withdrawConfirmemail()
	{
		$secret = yeniSifreCoz($this->input->post("id"));
		if (!empty($_SESSION['user_data'][0]['user_email']) && $secret == $_SESSION['user_data'][0]['user_id']) {
			$email = $_SESSION['user_data'][0]['user_email'];
			$this->wallet_model->getUserMailCodeGuncelle($email, lang('withdraw'));
		} else {
			redirect('/404');
		}
	}
	public function userWithdrawCreate()
	{
		$walletShort = addslashes($this->input->post("wallet"));
		$amount = $this->input->post("amount");
		$code = addslashes($this->input->post("code"));
		$address = addslashes($this->input->post("address"));
		$tag = addslashes($this->input->post("tag"));
		if ($_SESSION['user_data'][0]['user_email'] && $amount > 0 && is_numeric($amount) && !empty($code) && !empty($walletShort) && !empty($address) && !empty($amount)) {
			if ($tag == '') {
				$tag = "0";
			}
			$email = $_SESSION['user_data'][0]['user_email'];
			$userID = $_SESSION['user_data'][0]['user_id'];
			$walletDetail = $this->wallet_model->getWalletShort($walletShort);
			$walletInfoDetail = $this->wallet_model->getUserInfoDetail($email);
			$userDetail = $this->wallet_model->getUser($userID, $email);
			if (empty($walletDetail) || empty($userDetail)) {
				$data = array("mesaj" => "error", "durum" => "error");
			} elseif ($walletDetail[0]["wallet_max_with"] != 0 && $amount > $walletDetail[0]["wallet_max_with"]) {
				$data = array("mesaj" => lang("maxwith"), "durum" => "error");
			} else {
				if ($amount < $walletDetail[0]["wallet_min_with"]) {
					$data = array("mesaj" => lang("minwith"), "durum" => "error");
				} else {
						if ($userDetail[0]["user_wallet_status"] == 0) {
							$data = array("mesaj" => lang("notaccountwith") . ' ' . lang("contactus"), "durum" => "error");
						} else {
							if ($userDetail[0]["user_ip"] != 'DISABLED' && $userDetail[0]["user_ip"] != GetIP()) {
								$data = array("mesaj" => lang("notipwhite"), "durum" => "error");
							} else {
								if (userWalletBalance($walletDetail[0]["wallet_id"], $userID, $email) < (float)$amount) {
									$data = array("mesaj" => lang("notwithbalance"), "durum" => "error");
								} else {
									if ($this->wallet_model->addressControl($walletShort, $address, $walletDetail) == 'hata' && $walletDetail[0]["wallet_system"] != "fiat") {
										$data = array("mesaj" => lang("withaddresserror"), "durum" => "error");
									} else {
										if ($userDetail[0]["user_with_conf"] == 'M' && getUserMailCodeKontrol($email, $code) != 'ok') {
											$data = array("mesaj" => lang("codeerror"), "durum" => "error");
										} else {
											if ($userDetail[0]["user_with_conf"] == 'G' && getUserGoogleCodeKontrol(yeniSifreCoz($userDetail[0]["user_google_key"]), $code) != 'ok') {
												$data = array("mesaj" => lang("codeerror"), "durum" => "error");
											} else {
												if (empty($walletInfoDetail) && $walletDetail[0]["wallet_system"] == "fiat") {
													$data = array("mesaj" => lang("notbasicform"), "durum" => "error");
												} else {
													$insert = $this->wallet_model->withdrawCreate($walletDetail[0]["wallet_id"], $walletShort, $userID, $email, $amount, $walletDetail[0]["wallet_with_com"], $walletDetail[0]["wallet_system"], $address, $walletDetail[0]["wallet_cont"], $tag);
													if ($insert == 'ok') {
														$data = array("mesaj" => lang("processingsuccess"), "durum" => "success");
													} else {
														$data = array("mesaj" => lang("hata") . ' 112', "durum" => "error");
													}
												}
											}
										}
									}
								}
							}
						}
					
				}
			}
			echo json_encode($data);
		} else {
			$data = array("mesaj" => lang("bosluk"), "durum" => "error");
			echo json_encode($data);
		}
	}

	public function userWithdrawCreateMetamask()
	{

		$walletShort = addslashes($this->input->post("wallet"));
		$amount = $this->input->post("amount");
		// $code = addslashes($this->input->post("code"));
		$address = strtolower(addslashes($this->input->post("address")));
		$tag = addslashes($this->input->post("tag"));
		$signature = $this->input->post('signature');
		$headingMessage = 'starting session: ';
		if ($this->input->post('headingMessage') !== null) {
			$headingMessage = $this->input->post('headingMessage');
		}

		$user = $this->account_model->getUserByAddress(/*$address*/ strtolower($_SESSION["user_data"][0]["user_address"]));
		$ticket = $user[0]['user_ticket'];

		// $address   = "0x5a214a45585b336a776b62a3a61dbafd39f9fa2a";
		$message  = $headingMessage . $ticket;

		// verify authSignature
		if (!verifySignature($message, $signature, /*$address*/ strtolower($_SESSION["user_data"][0]["user_address"]) )) {
			$data = array("mesaj" => lang("notidnumber"), "durum" => "error");
			echo json_encode($data);
			return;
		}
		if ($_SESSION['user_data'][0]['user_email'] && $amount > 0 && is_numeric($amount) && !empty($walletShort) && !empty($address) && !empty($amount)) {
			if ($tag == '') {
				$tag = "0";
			}
			$email = $_SESSION['user_data'][0]['user_email'];
			$userID = $_SESSION['user_data'][0]['user_id'];
			$walletDetail = $this->wallet_model->getWalletShort($walletShort);
			$walletInfoDetail = $this->wallet_model->getUserInfoDetail($email);
			$userDetail = $this->wallet_model->getUser($userID, $email);
			if (empty($walletDetail) || empty($userDetail)) {
				$data = array("mesaj" => "error", "durum" => "error");
			} elseif ($walletDetail[0]["wallet_max_with"] != 0 && $amount > $walletDetail[0]["wallet_max_with"]) {
				$data = array("mesaj" => lang("maxwith"), "durum" => "error");
			} else {
				if ($amount < $walletDetail[0]["wallet_min_with"]) {
					$data = array("mesaj" => lang("minwith"), "durum" => "error");
				} else {
					
						if ($userDetail[0]["user_wallet_status"] == 0) {
							$data = array("mesaj" => lang("notaccountwith") . ' ' . lang("contactus"), "durum" => "error");
						} else {
							if ($userDetail[0]["user_ip"] != 'DISABLED' && $userDetail[0]["user_ip"] != GetIP()) {
								$data = array("mesaj" => lang("notipwhite"), "durum" => "error");
							} else {
								if (userWalletBalance($walletDetail[0]["wallet_id"], $userID, $email) < (float)$amount) {
									$data = array("mesaj" => lang("notwithbalance"), "durum" => "error");
								} else {
									// if ($this->wallet_model->addressControl($walletShort, $address, $walletDetail) == 'hata' && $walletDetail[0]["wallet_system"] != "fiat") {
									// 	$data = array("mesaj" => lang("withaddresserror"), "durum" => "error");
									// } else {

									// if (empty($walletInfoDetail) && $walletDetail[0]["wallet_system"] == "fiat") {
									// 	$data = array("mesaj" => lang("notbasicform"), "durum" => "error");
									// } else {
									$insert = $this->wallet_model->withdrawCreate($walletDetail[0]["wallet_id"], $walletShort, $userID, $email, $amount, $walletDetail[0]["wallet_with_com"], $walletDetail[0]["wallet_system"], $address, $walletDetail[0]["wallet_cont"], $tag);

									if ($insert == 'ok') {
										$data = array("mesaj" => lang("processingsuccess"), "durum" => "success");
									} else {
										$data = array("mesaj" => lang("hata") . ' 112', "durum" => "error");
									}
									// }
									// }
								}
							}
						}
					
				}
			}
			echo json_encode($data);
		} else {
			$data = array("mesaj" => lang("bosluk"), "durum" => "error");
			echo json_encode($data);
		}
	}
	public function userWithdrawCancel()
	{
		$userID = $_SESSION['user_data'][0]['user_id'];
		$email = $_SESSION['user_data'][0]['user_email'];
		$withdrawID = addslashes($this->input->post('withdrawID'));
		if (!empty($userID) && !empty($userID) && !empty($withdrawID)) {
			$withdrawCancel = $this->wallet_model->userWithdrawCancel($userID, $email, $withdrawID);
			if ($withdrawCancel == 'ok') {
				$data = array("mesaj" => lang("processingsuccess"), "durum" => "success");
			} elseif ($withdrawCancel == 'yok') {
				$data = array("mesaj" => lang("notwithdraw"), "durum" => "error");
			} else {
				$data = array("mesaj" => lang("hata") . ' 113', "durum" => "error");
			}
		} else {
			$data = array("mesaj" => lang("hata") . ' 114', "durum" => "error");
		}
		echo json_encode($data);
	}

	public function getBankaDetail()
	{
		$bankid = $this->input->post("bankid");
		$data = $this->wallet_model->getBankaDetail($bankid);
		if (!empty($data)) {
			echo json_encode($data);
		}
	}
	public function insertFiatDeposit()
	{
		$walletShort = addslashes($this->input->post("walletShort"));
		$bankid = addslashes($this->input->post("bankid"));
		$islemCode = addslashes($this->input->post("depositcode"));
		$amount = $this->input->post("depositamount");
		if ($_SESSION['user_data'][0]['user_email'] && !empty($amount) && $amount > 0 && is_numeric($amount) && !empty($walletShort) && !empty($bankid) && !empty($islemCode)) {
			$email = $_SESSION['user_data'][0]['user_email'];
			$userID = $_SESSION['user_data'][0]['user_id'];
			$walletDetail = $this->wallet_model->getWalletShort($walletShort);
			$bankaDetail = $this->wallet_model->getBankaDetail($bankid);
			$userDetail = $this->wallet_model->getUser($userID, $email);
			$walletInfoDetail = $this->wallet_model->getUserInfoDetail($email);
			getUserWalletKontrol($walletDetail[0]["wallet_id"], $userID, $email);
			if ($amount > $walletDetail[0]["wallet_max_dep"]) {
				$data = array("mesaj" => lang("maxdep"), "durum" => "error");
			} else {
				if ($amount < $walletDetail[0]["wallet_min_dep"]) {
					$data = array("mesaj" => lang("mindep"), "durum" => "error");
				} else {
					if ($userDetail[0]["user_wallet_status"] == "0") {
						$data = array("mesaj" => lang("notaccountdep") . ' ' . lang("contactus"), "durum" => "error");
					} else {
						if (empty($walletInfoDetail)) {
							$data = array("mesaj" => lang("notbasicform"), "durum" => "error");
						} else {
							$insert = $this->wallet_model->depositCreate($walletShort, $userID, $email, $amount, $walletDetail[0]["wallet_system"], $bankaDetail[0]["banka_name"], $bankaDetail[0]["banka_iban"], $islemCode);
							if ($insert == 'ok') {
								$data = array("mesaj" => lang("processingsuccess"), "durum" => "success");
							} else {
								$data = array("mesaj" => lang("hata") . ' 115', "durum" => "error");
							}
						}
					}
				}
			}
			echo json_encode($data);
		} else {
			$data = array("mesaj" => lang("bosluk"), "durum" => "error");
			echo json_encode($data);
		}
	}

	public function userDepositCheck()
	{
		$walletShort = addslashes($this->input->post("walletShort"));
		$fromAddress = addslashes($this->input->post("fromAddress"));
		$amount = $this->input->post("depositamount");
		if ($_SESSION['user_data'][0]['user_email'] && !empty($amount) && $amount > 0 && is_numeric($amount) && !empty($walletShort) && !empty($fromAddress)) {
			$email = $_SESSION['user_data'][0]['user_email'];
			$userID = $_SESSION['user_data'][0]['user_id'];
			$walletDetail = $this->wallet_model->getWalletShort($walletShort);
			//$fromAddress = $this->wallet_model->getBankaDetail($fromAddress);
			$userDetail = $this->wallet_model->getUser($userID, $email);
			$walletInfoDetail = $this->wallet_model->getUserInfoDetail($email);
			$walletInfoDetail = array('email'=>'yes@tes.com');
			getUserWalletKontrol($walletDetail[0]["wallet_id"], $userID, $email);
			if ($amount > $walletDetail[0]["wallet_max_dep"]) {
				$data = array("mesaj" => lang("maxdep"), "durum" => "error");
			} else {
				if ($amount < $walletDetail[0]["wallet_min_dep"]) {
					$data = array("mesaj" => lang("mindep"), "durum" => "error");
				} else {
					if ($userDetail[0]["user_wallet_status"] == "0") {
						$data = array("mesaj" => lang("notaccountdep") . ' ' . lang("contactus"), "durum" => "error");
					} else {
						if (empty($walletInfoDetail)) {
							$data = array("mesaj" => lang("notbasicform"), "durum" => "error");
						} else {
							$data = array("mesaj" => lang("processingsuccess"), "durum" => "success");
						}
					}
				}
			}
			echo json_encode($data);
		} else {
			$data = array("mesaj" => lang("bosluk"), "durum" => "error");
			echo json_encode($data);
		}
	}
	public function userDeposit()
	{
		$walletShort = addslashes($this->input->post("walletShort"));
		$fromAddress = addslashes($this->input->post("fromAddress"));
		$islemCode = addslashes($this->input->post("depositcode"));
		$amount = $this->input->post("depositamount");
		//if ($_SESSION['user_data'][0]['user_email'] && !empty($amount) && $amount > 0 && is_numeric($amount) && !empty($walletShort) && !empty($fromAddress) && !empty($islemCode)) {
			$email = $_SESSION['user_data'][0]['user_email'];
			$userID = $_SESSION['user_data'][0]['user_id'];
			$walletDetail = $this->wallet_model->getWalletShort($walletShort);
			//$fromAddress = $this->wallet_model->getBankaDetail($fromAddress);
			$userDetail = $this->wallet_model->getUser($userID, $email);
			$walletInfoDetail = $this->wallet_model->getUserInfoDetail($email);
			$walletInfoDetail = array('email'=>'yes@tes.com');
			getUserWalletKontrol($walletDetail[0]["wallet_id"], $userID, $email);
			if ($amount > $walletDetail[0]["wallet_max_dep"] && false) {
				$data = array("mesaj" => lang("maxdep"), "durum" => "error");
			} else {
				if ($amount < $walletDetail[0]["wallet_min_dep"]) {
					$data = array("mesaj" => lang("mindep"), "durum" => "error");
				} else {
					if ($userDetail[0]["user_wallet_status"] == "0") {
						$data = array("mesaj" => lang("notaccountdep") . ' ' . lang("contactus"), "durum" => "error");
					} else {
						if (empty($walletInfoDetail)) {
							$data = array("mesaj" => lang("notbasicform"), "durum" => "error");
						} else {
							$insert = $this->wallet_model->depositCreate($walletShort, $userID, $email, $amount, $walletDetail[0]["wallet_system"], '', $fromAddress, $islemCode);
							if ($insert == 'ok') {
								$data = array("mesaj" => lang("processingsuccess"), "durum" => "success");
							} else {
								$data = array("mesaj" => lang("hata") . ' 115', "durum" => "error");
							}
						}
					}
				}
			}
			echo json_encode($data);
		/* } else {
			$data = array("mesaj" => lang("bosluk"), "durum" => "error");
			echo json_encode($data);
		} */
	}

	public function userDepositCancel()
	{
		$userID = $_SESSION['user_data'][0]['user_id'];
		$email = $_SESSION['user_data'][0]['user_email'];
		$walletShort = addslashes($this->input->post('walletShort'));
		$depTime = addslashes($this->input->post('deptime'));
		if (!empty($userID) && !empty($userID) && !empty($walletShort) && !empty($depTime)) {
			$depCancel = $this->wallet_model->userDepositCancel($userID, $email, $walletShort, $depTime);
			if ($depCancel == 'ok') {
				$data = array("mesaj" => lang("processingsuccess"), "durum" => "success");
			} elseif ($depCancel == 'yok') {
				$data = array("mesaj" => lang("notfinddeposit"), "durum" => "error");
			} else {
				$data = array("mesaj" => lang("hata") . ' 116', "durum" => "error");
			}
		} else {
			$data = array("mesaj" => lang("hata") . ' 117', "durum" => "error");
		}
		echo json_encode($data);
	}
}
