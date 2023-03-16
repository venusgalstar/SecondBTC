<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends CI_Controller {

	public function __construct() {
		parent::__construct();
		dilBul();
		header('X-Frame-Options: SAMEORIGIN');
		if(siteSetting()["site_status"]!=1 && $_SESSION['key']!="admin_bakim"){redirect('/maintenance');}		
	}
	public function index()
	{
		if($_POST){
			if(recaptcha($_POST['g-recaptcha-response'])!=1){
				$this->session->set_flashdata('hata', lang("robot"));
				redirect('/support');
			}else{
				$insert= $this->index_model->insertSupport();
				$this->load->view('support');
			}
		}else{
			$this->load->view('support');
		}
		
	} 
}