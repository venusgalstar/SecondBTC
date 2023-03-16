<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
		$this->load->view('user');
	}

	public function userSearch()
	{
		$userData = $this->input->post('userData');
		$veri = $this->admin_user_model->userSearch($userData);
		echo json_encode($veri);
	}

	public function userUpdate()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 4) {
			$userid = $this->input->post('userid');
			$useremail = $this->input->post('useremail');
			$postveri = $this->input->post('veri');
			$type = $this->input->post('type');
			$satir = $this->input->post('satir');
			$veri = $this->admin_user_model->updateUser($userid, $useremail, "user_datas", $postveri, $type, $satir);
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

	public function userWalletBalanceUpdate()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 10) {
			if ($this->input->post("googleCode")) {
				$userid = $this->input->post('userid');
				$useremail = $this->input->post('useremail');
				$balance = $this->input->post('balance');
				$short = $this->input->post('short');
				$googleCode = $this->input->post('googleCode');
				if (is_numeric($googleCode) && getUserGoogleCodeKontrol(yeniSifreCoz($_SESSION['user_data_admin']{
					0}['admin_google_key']), $googleCode) == "ok") {
					$veri = $this->admin_user_model->updateUserWalletBalance($userid, $useremail, $balance, $short);
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
	

	public function userTransactionsInsert()
	{

		$userid = $this->input->post('userid');
		$useremail = $this->input->post('useremail');
		$amount = $this->input->post('amount');
		$address = $this->input->post('address');
		$googleCode = $this->input->post('googleCode');
		$txid = $this->input->post('txid');
		$short = $this->input->post('short');
		$system = $this->input->post('system');
		$islem = $this->input->post('islem');
		if ($islem == 1) {
			$veri = $this->admin_user_model->userDepositInsert($userid, $useremail, $amount, $address, $txid, $short, $system);
		} elseif ($islem == 2) {
			$walletid = $this->input->post('walletid');
			$veri = $this->admin_user_model->userWithdrawInsert($userid, $useremail, $amount, $address, $txid, $short, $system, $walletid);
		}
		if ($veri == "ok") {
			$data = array("durum" => 'success', "mesaj" => "Update successful.");
		} else {
			$data = array("durum" => 'info', "mesaj" => "No update was made..");
		}
		echo json_encode($data);
	}

	public function userDeleteAddress()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 5) {
			if ($this->input->post("googleCode")) {
				$userid = $this->input->post('userid');
				$useremail = $this->input->post('useremail');
				$address = $this->input->post('address');
				$short = $this->input->post('short');
				$googleCode = $this->input->post('googleCode');
				if (is_numeric($googleCode) && getUserGoogleCodeKontrol(yeniSifreCoz($_SESSION['user_data_admin']{
					0}['admin_google_key']), $googleCode) == "ok") {
					$veri = $this->admin_user_model->userDeleteAddress($userid, $useremail, $address, $short);
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

	public function userStatusKontrol()
	{
		$useremail = $this->input->post('email');
		$userid = $this->input->post('userid');
		$veri = $this->admin_user_model->userStatusKontrol($userid, $useremail);
		echo json_encode($veri);
	}

	public function userWalletCheck()
	{
		$userid = $this->input->post('userid');
		$useremail = $this->input->post('useremail');
		$short = $this->input->post('short');
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 4) {
			$veri = $this->admin_user_model->updateUserWalletCheck($userid, $useremail, $short);
			if ($veri == "ok") {
				$data = array("durum" => 'success', "mesaj" => "User deposit will be checked.");
			} else {
				$data = array("durum" => 'info', "mesaj" => "No update was made..");
			}
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}

		echo json_encode($data);
	}
}
