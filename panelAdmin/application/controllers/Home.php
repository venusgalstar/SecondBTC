<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		header('X-Frame-Options: SAMEORIGIN');
		// if(siteSetting()["site_status"]!=1 && $_SESSION['key']!="admin_bakim"){redirect('/maintenance');}
	}

	public function index()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		} elseif ($_SESSION['user_data_admin'][0]['admin_type'] == '' || $_SESSION['user_data_admin'][0]['admin_email']) {
			$data["deposit"] = $this->admin_home_model->mainPageDeposit();
			$data["withdraw"] = $this->admin_home_model->mainPageWithdraw();
			$data["trade"] = $this->admin_home_model->mainPageTrade();
			$data["exchange"] = $this->admin_home_model->mainPageExchange();
			$data["faucet"] = $this->admin_home_model->mainPageFaucet();
			$data["tradeVolBTC"] = $this->admin_home_model->mainPageTradeVol("BTC");
			$data["tradeVolETH"] = $this->admin_home_model->mainPageTradeVol("ETH");
			$data["tradeVolUSDT"] = $this->admin_home_model->mainPageTradeVol("USDT");
			$data["tradeVolDOGE"] = $this->admin_home_model->mainPageTradeVol("DOGE");
			$this->load->view('index', $data);
		} else {
			redirect('/404');
		}
	}

	public function login()
	{
		if ($this->input->post("form_submit_login") == "send") {
			$sor = $this->admin_home_model->getAdmin();
			if ($sor == "ok") {
				redirect('/home');
			} else {
				redirect('/login');
			}
		} else {
			$this->load->view('login');
		}
	}

	public function logout()
	{
		unset($_SESSION['user_data_admin']);
		redirect('/login');
	}

	public function sitesetting()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		$data["siteSetting"] = $this->admin_home_model->getSiteSetting();
		$this->load->view('site_setting', $data);
	}

	public function updateSiteSetting()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 5) {
			$update = $this->admin_home_model->updateSiteSetting();
		} else {
			$this->session->set_flashdata('hata', 'You are not authorized to perform this operation.!');
			redirect('/home/sitesetting');
		}
	}

	public function news()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		$data["news"] = $this->admin_home_model->getNews();
		$this->load->view('news', $data);
	}

	public function newsAdd()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		if ($_POST) {
			if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 5) {
				$add = $this->admin_home_model->newsAdd();
			} else {
				$this->session->set_flashdata('hata', 'You are not authorized to perform this operation.!');
				redirect('/home/news');
			}
		}
		$this->load->view('news_add');
	}

	public function newsUpdate()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		if ($_POST) {
			if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 5) {
				$add = $this->admin_home_model->newsUpdate();
			} else {
				$this->session->set_flashdata('hata', 'You are not authorized to perform this operation.!');
				redirect('/home/news');
			}
		}
		$this->load->view('news_add');
	}

	public function support()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		$data["support"] = $this->admin_home_model->getSupport();
		$this->load->view('support', $data);
	}

	public function supportUpdate()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		if ($_POST) {
			if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 4) {
				$add = $this->admin_home_model->supportUpdate();
			} else {
				$this->session->set_flashdata('hata', 'You are not authorized to perform this operation.!');
				redirect('/home/support');
			}
		}
	}

	public function supportStatusUpdate()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		if ($_POST) {
			if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 10) {
				$veri = $this->admin_home_model->supportStatusUpdate();
			} else {
				$veri = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
			}
			echo json_encode($veri);
		}
	}

	public function sendEmail()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		if ($_POST) {
			if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 4) {
				$this->admin_home_model->sendEmail();
			} else {
				$this->session->set_flashdata('hata', 'You are not authorized to perform this operation.!');
				$this->load->view('send_mail');
			}
		}
		$this->load->view('send_mail');
	}

	public function team()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		$data["team"] = $this->admin_home_model->getTeam();
		$this->load->view('team', $data);
	}

	public function addTeam()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		if ($_POST) {
			if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 4) {
				$this->admin_home_model->addTeam();
			} else {
				$this->session->set_flashdata('hata', 'You are not authorized to perform this operation.!');
				redirect('/home/team');
			}
		}
		$this->load->view('add_team');
	}

	public function updateTeam()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		if ($_POST) {
			if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 4) {
				$this->admin_home_model->updateTeam();
			} else {
				$this->session->set_flashdata('hata', 'You are not authorized to perform this operation.!');
				redirect('/home/team');
			}
		}
	}

	public function deleteNews()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		if ($_POST) {
			if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 4) {
				$this->admin_home_model->deleteDatas("news_datas", "news_id");
			} else {
				$this->session->set_flashdata('hata', 'You are not authorized to perform this operation.!');
			}
		}
	}

	public function deleteTeam()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		if ($_POST) {
			if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 5) {
				$this->admin_home_model->deleteDatas("team_datas", "team_id");
			} else {
				$this->session->set_flashdata('hata', 'You are not authorized to perform this operation.!');
			}
		}
	}

	public function addFund()
	{
		if ($_POST) {
			if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 10) {
				if ($this->input->post("googleCode")) {
					$googleCode = $this->input->post("googleCode");
					$useremail = $this->input->post('fund_email');
					$userid = $this->input->post('fund_id');
					$amount = $this->input->post('fund_amount');
					$walletShort = $this->input->post('fund_wallet');
					if (is_numeric($googleCode) && getUserGoogleCodeKontrol(yeniSifreCoz($_SESSION['user_data_admin'][0]['admin_google_key']), $googleCode) == "ok") {
						$veri = $this->admin_home_model->addFund($userid, $useremail, $amount, $walletShort);
					} else {
						$this->session->set_flashdata('hata', 'The code entered is incorrect! Please check!');
						redirect('/home/addFund');
					}
				} else {
					$this->session->set_flashdata('hata', 'The code entered is incorrect! Please check!');
					redirect('/home/addFund');
				}
			} else {
				$this->session->set_flashdata('hata', 'You are not authorized to perform this operation.!');
				redirect('/home/addFund');
			}
		}
		$data["oldFund"] = $this->admin_home_model->oldFund();
		$this->load->view('add_fund', $data);
	}

	public function faucet()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		$data["faucet"] = $this->admin_home_model->getFaucet();
		$this->load->view('faucet', $data);
	}

	public function faucetUpdate()
	{
		if ($_POST) {
			if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 6) {
				$this->admin_home_model->faucetUpdate();
			} else {
				$this->session->set_flashdata('hata', 'You are not authorized to perform this operation.!');
			}
		}
	}
}
