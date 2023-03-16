<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		header('X-Frame-Options: SAMEORIGIN');
		// if(siteSetting()["site_status"]!=1 && $_SESSION['key']!="admin_bakim"){redirect('/maintenance');}
		if ($this->session->userdata('dur') >= 4) {
			redirect(siteSetting()["site_url"]);
		}
	}

	public function index()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		} elseif ($_SESSION['user_data_admin'][0]['admin_type'] != '' && $_SESSION['user_data_admin'][0]['admin_email']) {
			$data["adminAct"] = $this->admin_admin_model->adminActivity();
			$data["admin"] = $this->admin_admin_model->getAdmin();
			$this->load->view('admin', $data);
		} else {
			redirect('/login');
		}
	}

	public function adminUpdate()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 10) {
			$googleCode = $this->input->post('googleCode');
			if (is_numeric($googleCode) && getUserGoogleCodeKontrol(yeniSifreCoz($_SESSION['user_data_admin']{
				0}['admin_google_key']), $googleCode) == "ok") {
				$email = $this->input->post("email");
				$style = $this->input->post("style");
				$satir = $this->input->post("satir");
				$veri = $this->input->post("veri");
				$data = $this->admin_admin_model->adminUpdate($email, $style, $satir, $veri);
			} else {
				$data = array("durum" => 'error', "mesaj" => "The code entered is incorrect! Please check.");
			}
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}
		echo json_encode($data);
	}

	public function addAdmin()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		if ($_POST) {
			if (yetki($_SESSION['user_data_admin']{
				0}['admin_email']) >= 10) {
				$googleCode = $this->input->post('googleCode');
				if (is_numeric($googleCode) && getUserGoogleCodeKontrol(yeniSifreCoz($_SESSION['user_data_admin']{
					0}['admin_google_key']), $googleCode) == "ok") {
					$data = $this->admin_admin_model->addAdmin();
				} else {
					$this->session->set_flashdata('hata', 'The code entered is incorrect! Please check.');
					redirect('/admin/addAdmin');
				}
			} else {
				$this->session->set_flashdata('hata', 'You are not authorized to perform this operation.');
				redirect('/admin');
			}
		}
		$this->load->view('add_admin');
	}
}
