<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bot extends CI_Controller
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
		$data["marketList"] = $this->Admin_bot_model->getAllMarket();
		$data["botList"] = $this->Admin_bot_model->getAllBot();
		$this->load->view('bot', $data);
	}

	public function addBot()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		if ($_POST) {
			if (yetki($_SESSION['user_data_admin']{
				0}['admin_email']) >= 4) {
				$insert = $this->Admin_bot_model->addBot();
			} else {
				$this->session->set_flashdata('hata', 'You are not authorized to perform this operation.!');
				redirect('/bot');
			}
		}
	}

	public function deleteBot()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		if ($_POST) {
			if (yetki($_SESSION['user_data_admin']{
				0}['admin_email']) >= 4) {
				$this->Admin_bot_model->deleteBot();
			} else {
				$this->session->set_flashdata('hata', 'You are not authorized to perform this operation.!');
				redirect('/bot');
			}
		}
	}

	public function updateBot()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		if ($_POST) {
			if (yetki($_SESSION['user_data_admin']{
				0}['admin_email']) >= 4) {
				$kontrol = $this->Admin_bot_model->updateBot();
				if ($kontrol == "ok") {
					$data = array("durum" => 'success', "mesaj" => "Bot update success!");
					echo json_encode($data);
				} else {
					$data = array("durum" => 'error', "mesaj" => "Bot update error!" . $kontrol);
					echo json_encode($data);
				}
			} else {
				$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.!");
				echo json_encode($data);
			}
		}
	}

	public function updateStatusBot()
	{
		if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
			redirect('/login');
		}
		if ($_POST) {
			if (yetki($_SESSION['user_data_admin']{
				0}['admin_email']) >= 4) {
				$kontrol = $this->Admin_bot_model->updateStatusBot();
				if ($kontrol == "ok") {
					$data = array("durum" => 'success', "mesaj" => "Bot update success!");
					echo json_encode($data);
				} else {
					$data = array("durum" => 'error', "mesaj" => "Bot update error!");
					echo json_encode($data);
				}
			} else {
				$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.!");
				echo json_encode($data);
			}
		}
	}
}
