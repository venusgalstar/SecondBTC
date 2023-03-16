<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fiat extends CI_Controller
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
		$data["fiatWallet"] = $this->admin_fiat_model->fiatBul();
		$data["bankList"] = $this->admin_fiat_model->bankBul();
		$data['dataBanks'] = $this->mylibraries->trbanks();
		$this->load->view('wallet/bank', $data);
	}

	public function addbank()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 5) {
			$bankID = $this->input->post("banka_id");
			$fiatShort = $this->input->post("fiat_short");
			$bankName = $this->input->post("banka_name");
			$bankIban = strtoupper($this->input->post("banka_iban"));
			$bankHesap = $this->input->post("banka_hesap");
			$this->admin_fiat_model->bankInsert($bankID, $fiatShort, $bankName, $bankIban, $bankHesap);
		} else {
			$this->session->set_flashdata('hata', 'You are not authorized to perform this operation!');
			redirect('/fiat');
		}
	}
	public function bulBank()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 5) {
			$bankId = $this->input->post("bankid");
			$data = $this->admin_fiat_model->bankBul2($bankId);
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}
		echo json_encode($data);
	}
	public function silBank()
	{
		if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 5) {
			$bankId = $this->input->post("bankid");
			$data = $this->admin_fiat_model->bankSil($bankId);
			if ($data == "ok") {
				$data = array("durum" => 'success', "mesaj" => "Bank successfully deleted.");
			} else {
				$data = array("durum" => 'error', "mesaj" => "Failed to delete bank successfully.");
			}
		} else {
			$data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
		}
		echo json_encode($data);
	}
}
